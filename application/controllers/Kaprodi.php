<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kaprodi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->model('Surat_model');
    }

    public function index()
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $data['tahun'] = $tahun;

        // ✅ STATISTIK YANG BENAR
        $data['total_surat'] = $this->db->where('YEAR(created_at)', $tahun)
                                        ->count_all_results('surat');

        $data['approved_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                          ->where_in('status', ['disetujui dekan', 'disetujui KK', 'disetujui sekretariat'])
                                          ->count_all_results('surat');

        $data['rejected_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                           ->where_in('status', ['ditolak KK', 'ditolak sekretariat'])
                                           ->count_all_results('surat');

        $data['pending_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                          ->where('status', 'pengajuan')
                                          ->count_all_results('surat');

        // ✅ Ambil daftar surat HANYA status pengajuan
        $this->db->where("status", 'pengajuan');
        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // ✅ GRAFIK BULANAN
        $total     = array_fill(0, 12, 0);
        $approved  = array_fill(0, 12, 0);
        $rejected  = array_fill(0, 12, 0);

        $this->db->where('YEAR(created_at)', $tahun);
        $query = $this->db->get('surat')->result();

        foreach ($query as $row) {
            $month = (int)date('m', strtotime($row->created_at)) - 1;
            $total[$month]++;

            if ($row->status == 'disetujui dekan') {
                $approved[$month]++;
            }
             if (in_array($row->status, ['ditolak KK', 'ditolak sekretariat'])) {
                $rejected[$month]++;
            }
        }

        $data['chart_total']    = $total;
        $data['chart_approved'] = $approved;
        $data['chart_rejected'] = $rejected;

        $this->load->view('kaprodi/dashboard', $data);
    }

    public function approve($id)
    {
        $surat = $this->db->get_where('surat', ['id' => $id])->row();
        
        if (!$surat) {
            $this->session->set_flashdata('error', 'Surat tidak ditemukan.');
            redirect('kaprodi');
        }

        $approval = json_decode($surat->approval_status, true) ?? [];

        $approval['kk'] = date("Y-m-d H:i:s");
        $this->db->where('id', $id)->update('surat', [
            'status' => 'disetujui KK',
            'approval_status' => json_encode($approval),
        ]);

        $this->session->set_flashdata('success', 'Surat berhasil disetujui Kaprodi.');
        redirect('kaprodi');
    }

    public function reject($id)
    {
        $surat = $this->db->get_where('surat', ['id' => $id])->row();
        
        if (!$surat) {
            $this->session->set_flashdata('error', 'Surat tidak ditemukan.');
            redirect('kaprodi');
        }

        $notes = $this->input->post('rejection_notes');
        $approval = json_decode($surat->approval_status, true) ?? [];

        $approval['kk'] = date("Y-m-d H:i:s");

        $this->db->where('id', $id)->update('surat', [
            'status' => 'ditolak KK',
            'approval_status' => json_encode($approval),
            'catatan_penolakan' => $notes,
        ]);

        $this->session->set_flashdata('success', 'Surat berhasil ditolak Kaprodi.');
        redirect('kaprodi');
    }

    // ✅ METHOD BARU: Process Multi Approve - DIPERBAIKI
    public function process_multi_approve()
    {
        if ($this->input->post()) {
            // Perbaikan: Ambil selected_ids sebagai array
            $selected_ids = $this->input->post('selected_ids');
            
            // Debug: Cek data yang diterima
            log_message('debug', 'Selected IDs: ' . print_r($selected_ids, true));
            
            if (empty($selected_ids)) {
                $this->session->set_flashdata('error', 'Tidak ada pengajuan yang dipilih');
                redirect('kaprodi/pending');
            }
            
            $success_count = 0;
            $error_count = 0;
            
            foreach ($selected_ids as $id) {
                $surat = $this->db->get_where('surat', ['id' => $id])->row();
                
                if ($surat) {
                    $approval = json_decode($surat->approval_status, true) ?? [];
                    $approval['kk'] = date("Y-m-d H:i:s");
                    
                    // Generate nomor surat unik untuk setiap pengajuan
                    $nomor_surat = $this->generate_nomor_surat();
                    
                    $result = $this->db->where('id', $id)->update('surat', [
                        'status' => 'disetujui KK',
                        'nomor_surat' => $nomor_surat,
                        'approval_status' => json_encode($approval),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    
                    if ($result) {
                        $success_count++;
                        $this->add_approval_log($id, 'Kaprodi', 'Disetujui');
                    } else {
                        $error_count++;
                        log_message('error', "Gagal menyetujui pengajuan ID: $id");
                    }
                } else {
                    $error_count++;
                }
            }
            
            if ($success_count > 0) {
                $message = "Berhasil menyetujui $success_count pengajuan";
                if ($error_count > 0) {
                    $message .= ". Gagal: $error_count pengajuan";
                }
                $this->session->set_flashdata('success', $message);
            } else {
                $this->session->set_flashdata('error', 'Gagal menyetujui semua pengajuan yang dipilih');
            }
            
            redirect('kaprodi/pending');
        } else {
            $this->session->set_flashdata('error', 'Metode request tidak valid');
            redirect('kaprodi/pending');
        }
    }

    // ✅ METHOD BARU: Process Multi Reject - DIPERBAIKI TOTAL
    public function process_multi_reject()
    {
        if ($this->input->post()) {
            // Perbaikan: Ambil selected_ids dan rejection_notes sebagai array
            $selected_ids = $this->input->post('selected_ids');
            $rejection_notes = $this->input->post('rejection_notes');
            
            // Debug: Cek data yang diterima
            log_message('debug', 'Selected IDs: ' . print_r($selected_ids, true));
            log_message('debug', 'Rejection Notes: ' . print_r($rejection_notes, true));
            
            if (empty($selected_ids)) {
                $this->session->set_flashdata('error', 'Tidak ada pengajuan yang dipilih');
                redirect('kaprodi/pending');
            }
            
            // Validasi rejection notes
            if (empty($rejection_notes)) {
                $this->session->set_flashdata('error', 'Alasan penolakan harus diisi');
                redirect('kaprodi/pending');
            }
            
            $success_count = 0;
            $error_count = 0;
            
            // PERBAIKAN UTAMA: Handle rejection_notes yang berupa array
            foreach ($selected_ids as $index => $id) {
                $surat = $this->db->get_where('surat', ['id' => $id])->row();
                
                if ($surat) {
                    $approval = json_decode($surat->approval_status, true) ?? [];
                    $approval['kk'] = date("Y-m-d H:i:s");

                    // PERBAIKAN: Ambil catatan penolakan yang sesuai berdasarkan index
                    if (is_array($rejection_notes)) {
                        // Jika rejection_notes adalah array dari multiple textarea
                        $catatan = isset($rejection_notes[$index]) ? $rejection_notes[$index] : 'Tidak ada catatan';
                    } else {
                        // Jika rejection_notes adalah string tunggal
                        $catatan = $rejection_notes;
                    }
                    
                    // Pastikan $catatan adalah string
                    $catatan = is_array($catatan) ? implode(', ', $catatan) : $catatan;

                    $result = $this->db->where('id', $id)->update('surat', [
                        'status' => 'ditolak KK',
                        'approval_status' => json_encode($approval),
                        'catatan_penolakan' => $catatan, // Simpan sebagai string
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    
                    if ($result) {
                        $success_count++;
                        $this->add_approval_log($id, 'Kaprodi', 'Ditolak', $catatan);
                    } else {
                        $error_count++;
                        log_message('error', "Gagal menolak pengajuan ID: $id");
                    }
                } else {
                    $error_count++;
                }
            }
            
            if ($success_count > 0) {
                $message = "Berhasil menolak $success_count pengajuan";
                if ($error_count > 0) {
                    $message .= ". Gagal: $error_count pengajuan";
                }
                $this->session->set_flashdata('success', $message);
            } else {
                $this->session->set_flashdata('error', 'Gagal menolak semua pengajuan yang dipilih');
            }
            
            redirect('kaprodi/pending');
        } else {
            $this->session->set_flashdata('error', 'Metode request tidak valid');
            redirect('kaprodi/pending');
        }
    }

    // ✅ METHOD BARU: Get Detail Pengajuan untuk Popup - DIPERBAIKI
    public function getDetailPengajuan($id)
    {
        try {
            // Set header JSON pertama
            header('Content-Type: application/json');
            
            // Ambil data dari database
            $this->db->where('id', $id);
            $data = $this->db->get('surat')->row();

            if ($data) {
                // Format data untuk response
                $response = [
                    'success' => true,
                    'data' => [
                        'id' => $data->id,
                        'nama_kegiatan' => $data->nama_kegiatan ?? '-',
                        'jenis_pengajuan' => $data->jenis_pengajuan ?? '-',
                        'status' => $data->status ?? '-',
                        'lingkup_penugasan' => $data->lingkup_penugasan ?? '-',
                        'nama_dosen' => $data->nama_dosen ?? '-',
                        'nip' => $data->nip ?? '-',
                        'created_at' => $data->created_at ?? '-',
                        'tanggal_kegiatan' => $data->tanggal_kegiatan ?? '-',
                        'akhir_kegiatan' => $data->akhir_kegiatan ?? '-',
                        'penyelenggara' => $data->penyelenggara ?? '-',
                        'tempat_kegiatan' => $data->tempat_kegiatan ?? '-',
                        'eviden' => $data->eviden ?? '-',
                        'catatan_penolakan' => $data->catatan_penolakan ?? '-'
                    ]
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Data pengajuan tidak ditemukan'
                ];
            }

            echo json_encode($response);
            exit;

        } catch (Exception $e) {
            // Handle error
            $response = [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
            
            echo json_encode($response);
            exit;
        }
    }

    // ✅ METHOD BARU: Untuk halaman pending dengan search
    public function pending()
    {
        $search = $this->input->get('search');
        $tahun = $this->input->get('tahun') ?? date('Y');
        
        $data['tahun'] = $tahun;
        $data['page_title'] = 'Pengajuan Menunggu Persetujuan';

        // Query untuk data pending
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'pengajuan');

        // Jika ada pencarian
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->or_like('nip', $search);
            $this->db->or_like('nama_dosen', $search);
            $this->db->group_end();
        }

        $this->db->order_by('created_at', 'DESC');
        $data['surat_list'] = $this->db->get('surat')->result();

        // Hitung total untuk pagination info
        $data['total_surat'] = count($data['surat_list']);

        // Load view halaman_pending
        $this->load->view('kaprodi/halaman_pending', $data);
    }

    // ✅ METHOD BARU: Untuk halaman rejected dengan search
    public function ditolak_list()
    {
        $search = $this->input->get('search');
        $tahun = $this->input->get('tahun') ?? date('Y');
        
        $data['tahun'] = $tahun;
        $data['page_title'] = 'Pengajuan Ditolak';

        // Query untuk data ditolak
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['ditolak KK', 'ditolak sekretariat']);

        // Jika ada pencarian
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->or_like('nip', $search);
            $this->db->or_like('nama_dosen', $search);
            $this->db->group_end();
        }

        $this->db->order_by('created_at', 'DESC');
        $data['surat_list'] = $this->db->get('surat')->result();

        // Hitung total untuk pagination info
        $data['total_surat'] = count($data['surat_list']);

        // Load view halaman_ditolak
        $this->load->view('kaprodi/halaman_ditolak', $data);
    }

    // ✅ METHOD BARU: Untuk halaman approved dengan search
    public function disetujui_list()
    {
        $search = $this->input->get('search');
        $tahun = $this->input->get('tahun') ?? date('Y');
        
        $data['tahun'] = $tahun;
        $data['page_title'] = 'Pengajuan Disetujui';

        // Query untuk data disetujui
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui dekan', 'disetujui KK', 'disetujui sekretariat']);

        // Jika ada pencarian
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->or_like('nip', $search);
            $this->db->or_like('nama_dosen', $search);
            $this->db->group_end();
        }

        $this->db->order_by('created_at', 'DESC');
        $data['surat_list'] = $this->db->get('surat')->result();

        // Hitung total untuk pagination info
        $data['total_surat'] = count($data['surat_list']);

        // Load view halaman_disetujui
        $this->load->view('kaprodi/halaman_disetujui', $data);
    }

    // ✅ METHOD TAMBAHAN: Untuk halaman filtered
    public function semua()
    {
        $this->loadFilteredView('semua');
    }

    public function disetujui()
    {
        $this->loadFilteredView('disetujui');
    }

    public function ditolak()
    {
        $this->loadFilteredView('ditolak');
    }

    private function loadFilteredView($type)
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $data['tahun'] = $tahun;

        // Query berdasarkan jenis filter
        switch ($type) {
            case 'semua':
                $this->db->where('YEAR(created_at)', $tahun);
                $data['surat_list'] = $this->db->get('surat')->result();
                $data['page_title'] = 'Semua Pengajuan';
                break;
                
            case 'disetujui':
                $this->db->where('YEAR(created_at)', $tahun)
                         ->where_in('status', ['disetujui dekan', 'disetujui KK', 'disetujui sekretariat']);
                $data['surat_list'] = $this->db->get('surat')->result();
                $data['page_title'] = 'Pengajuan Disetujui';
                break;
                
            case 'ditolak':
                $this->db->where('YEAR(created_at)', $tahun)
                         ->where_in('status', ['ditolak KK', 'ditolak sekretariat']);
                $data['surat_list'] = $this->db->get('surat')->result();
                $data['page_title'] = 'Pengajuan Ditolak';
                break;
        }

        // Hitung statistik untuk card
        $data['total_surat'] = $this->db->where('YEAR(created_at)', $tahun)->count_all_results('surat');
        $data['approved_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                          ->where_in('status', ['disetujui dekan', 'disetujui KK', 'disetujui sekretariat'])
                                          ->count_all_results('surat');
        $data['rejected_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                           ->where_in('status', ['ditolak KK', 'ditolak sekretariat'])
                                           ->count_all_results('surat');
        $data['pending_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                          ->where('status', 'pengajuan')
                                          ->count_all_results('surat');

        // Load view yang sama dengan data berbeda
        $this->load->view('kaprodi/dashboard', $data);
    }

    // ✅ METHOD BARU: Helper function untuk generate nomor surat
    private function generate_nomor_surat()
    {
        $this->load->helper('string');
        
        $year = date('Y');
        $random = random_string('numeric', 3);
        
        return "{$random}/SKT/FT/{$year}";
    }

    // ✅ METHOD BARU: Helper function untuk log (opsional)
    private function add_approval_log($surat_id, $approver, $status, $notes = '')
    {
        $log_data = [
            'surat_tugas_id' => $surat_id,
            'approver' => $approver,
            'status' => $status,
            'notes' => $notes,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Jika Anda punya tabel log, uncomment baris berikut:
        // $this->db->insert('approval_logs', $log_data);
        
        // Untuk saat ini, kita hanya log ke file atau tidak melakukan apa-apa
        log_message('info', "Approval Log: Surat ID $surat_id - $approver - $status - $notes");
    }
}