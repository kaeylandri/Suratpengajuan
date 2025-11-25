<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dekan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
    }

    public function index($filter = 'all')
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $search = $this->input->get('search');
        $status_filter = $this->input->get('status');
        
        $data['tahun'] = $tahun;
        $data['current_filter'] = $filter;

        // Hanya ambil data yang relevan untuk dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        
        // Filter search - PERBAIKAN: Tambah pencarian di field nama_dosen
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('nip', $search);
            $this->db->or_like('nama_dosen', $search); // TAMBAHAN: Cari di nama_dosen juga
            $this->db->group_end();
        }

        // Filter status dari URL parameter
        if (!empty($status_filter)) {
            switch($status_filter) {
                case 'pending':
                    $this->db->where('status', 'disetujui sekretariat');
                    break;
                case 'approved':
                    $this->db->where('status', 'disetujui dekan');
                    break;
                case 'rejected':
                    $this->db->where('status', 'ditolak dekan');
                    break;
            }
        } else {
            // Filter berdasarkan parameter route
            switch($filter) {
                case 'approved':
                    $this->db->where('status', 'disetujui dekan');
                    break;
                case 'rejected':
                    $this->db->where('status', 'ditolak dekan');
                    break;
                case 'pending':
                    $this->db->where('status', 'disetujui sekretariat');
                    break;
                default:
                    // Semua data untuk dashboard utama (hanya yang relevan untuk dekan)
                    break;
            }
        }

        // PERBAIKAN UTAMA: Ambil data dengan field yang lengkap untuk dosen
        $data['surat_list'] = $this->db->select('*')
                               ->order_by('created_at', 'DESC')
                               ->get('surat')
                               ->result_array();

        // Statistik untuk card - hanya data yang relevan untuk dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $data['approved_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                          ->where('status', 'disetujui dekan')
                                          ->count_all_results('surat');

        $data['pending_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                         ->where('status', 'disetujui sekretariat')
                                         ->count_all_results('surat');

        $data['rejected_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                          ->where('status', 'ditolak dekan')
                                          ->count_all_results('surat');

        // Grafik data - hanya data yang relevan untuk dekan
        $total     = array_fill(0, 12, 0);
        $approved  = array_fill(0, 12, 0);
        $rejected  = array_fill(0, 12, 0);

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $query = $this->db->get('surat')->result();

        foreach ($query as $row) {
            $month = (int)date('m', strtotime($row->created_at)) - 1;

            $total[$month]++;

            if ($row->status == 'disetujui dekan') {
                $approved[$month]++;
            }

            if ($row->status == 'ditolak dekan') {
                $rejected[$month]++;
            }
        }

        $data['chart_total']    = $total;
        $data['chart_approved'] = $approved;
        $data['chart_rejected'] = $rejected;

        $this->load->view('dekan/dashboard', $data);
    }

    // Method untuk halaman khusus berdasarkan card
    public function halaman_total()
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $search = $this->input->get('search');
        $status = $this->input->get('status');
        
        $data['tahun'] = $tahun;
        $data['current_page'] = 'total';

        // Ambil semua data yang relevan untuk dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);

        // Filter search - PERBAIKAN: Tambah pencarian di field nama_dosen
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('nip', $search);
            $this->db->or_like('nama_dosen', $search); // TAMBAHAN
            $this->db->group_end();
        }

        // Filter status
        if (!empty($status)) {
            switch($status) {
                case 'pending':
                    $this->db->where('status', 'disetujui sekretariat');
                    break;
                case 'approved':
                    $this->db->where('status', 'disetujui dekan');
                    break;
                case 'rejected':
                    $this->db->where('status', 'ditolak dekan');
                    break;
            }
        }

        // PERBAIKAN: Ambil data dengan field lengkap
        $data['surat_list'] = $this->db->select('*')
                               ->order_by('created_at', 'DESC')
                               ->get('surat')
                               ->result_array();

        // Statistik - hanya data yang relevan untuk dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        
        // Apply same filters for statistics
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('nip', $search);
            $this->db->or_like('nama_dosen', $search); // TAMBAHAN
            $this->db->group_end();
        }
        
        if (!empty($status)) {
            switch($status) {
                case 'pending':
                    $this->db->where('status', 'disetujui sekretariat');
                    break;
                case 'approved':
                    $this->db->where('status', 'disetujui dekan');
                    break;
                case 'rejected':
                    $this->db->where('status', 'ditolak dekan');
                    break;
            }
        }
        
        $data['total_surat'] = $this->db->count_all_results('surat');

        $data['approved_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                          ->where('status', 'disetujui dekan')
                                          ->count_all_results('surat');

        $data['pending_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                         ->where('status', 'disetujui sekretariat')
                                         ->count_all_results('surat');

        $data['rejected_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                          ->where('status', 'ditolak dekan')
                                          ->count_all_results('surat');

        $this->load->view('dekan/halaman_total', $data);
    }

    public function halaman_disetujui()
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $search = $this->input->get('search');
        
        $data['tahun'] = $tahun;
        $data['current_page'] = 'disetujui';

        // Ambil hanya data yang disetujui dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'disetujui dekan');

        // Filter search - PERBAIKAN: Tambah pencarian di field nama_dosen
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('nip', $search);
            $this->db->or_like('nama_dosen', $search); // TAMBAHAN
            $this->db->group_end();
        }

        // PERBAIKAN: Ambil data dengan field lengkap
        $data['surat_list'] = $this->db->select('*')
                               ->order_by('created_at', 'DESC')
                               ->get('surat')
                               ->result_array();

        // Statistik - hanya data yang relevan untuk dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $data['approved_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                          ->where('status', 'disetujui dekan')
                                          ->count_all_results('surat');

        $data['pending_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                         ->where('status', 'disetujui sekretariat')
                                         ->count_all_results('surat');

        $data['rejected_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                          ->where('status', 'ditolak dekan')
                                          ->count_all_results('surat');

        $this->load->view('dekan/halaman_disetujui', $data);
    }

    public function halaman_ditolak()
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $search = $this->input->get('search');
        
        $data['tahun'] = $tahun;
        $data['current_page'] = 'ditolak';

        // Ambil hanya data yang ditolak dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'ditolak dekan');

        // Filter search - PERBAIKAN: Tambah pencarian di field nama_dosen
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('nip', $search);
            $this->db->or_like('nama_dosen', $search); // TAMBAHAN
            $this->db->group_end();
        }

        // PERBAIKAN: Ambil data dengan field lengkap
        $data['surat_list'] = $this->db->select('*')
                               ->order_by('created_at', 'DESC')
                               ->get('surat')
                               ->result_array();

        // Statistik - hanya data yang relevan untuk dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $data['approved_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                          ->where('status', 'disetujui dekan')
                                          ->count_all_results('surat');

        $data['pending_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                         ->where('status', 'disetujui sekretariat')
                                         ->count_all_results('surat');

        $data['rejected_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                          ->where('status', 'ditolak dekan')
                                          ->count_all_results('surat');

        $this->load->view('dekan/halaman_ditolak', $data);
    }

    public function halaman_pending()
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $search = $this->input->get('search');
        
        $data['tahun'] = $tahun;
        $data['current_page'] = 'pending';

        // Ambil hanya data yang menunggu persetujuan dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'disetujui sekretariat');

        // Filter search - PERBAIKAN: Tambah pencarian di field nama_dosen
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('nip', $search);
            $this->db->or_like('nama_dosen', $search); // TAMBAHAN
            $this->db->group_end();
        }

        // PERBAIKAN: Ambil data dengan field lengkap
        $data['surat_list'] = $this->db->select('*')
                               ->order_by('created_at', 'DESC')
                               ->get('surat')
                               ->result_array();

        // Statistik - hanya data yang relevan untuk dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $data['approved_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                          ->where('status', 'disetujui dekan')
                                          ->count_all_results('surat');

        $data['pending_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                         ->where('status', 'disetujui sekretariat')
                                         ->count_all_results('surat');

        $data['rejected_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                          ->where('status', 'ditolak dekan')
                                          ->count_all_results('surat');

        $this->load->view('dekan/halaman_pending', $data);
    }

    public function approve($id)
    {
        $surat = $this->db->get_where('surat', ['id' => $id])->row();
        $approval = json_decode($surat->approval_status, true);

        $approval['dekan'] = date("Y-m-d H:i:s");
        $this->db->where('id', $id)->update('surat', [
            'status' => 'disetujui dekan',
            'approval_status' => json_encode($approval)
        ]);

        $this->session->set_flashdata('success', 'Surat berhasil disetujui oleh Dekan.');
        
        // Redirect kembali ke halaman sebelumnya dengan filter yang sama
        $current_page = $this->input->get('from') ?? 'dekan';
        $tahun = $this->input->get('tahun') ?? date('Y');
        $search = $this->input->get('search');
        $status = $this->input->get('status');
        
        $query_params = 'tahun=' . $tahun;
        if (!empty($search)) {
            $query_params .= '&search=' . urlencode($search);
        }
        if (!empty($status)) {
            $query_params .= '&status=' . $status;
        }
        
        switch($current_page) {
            case 'total':
                redirect('dekan/halaman_total?' . $query_params);
                break;
            case 'disetujui':
                redirect('dekan/halaman_disetujui?' . $query_params);
                break;
            case 'ditolak':
                redirect('dekan/halaman_ditolak?' . $query_params);
                break;
            case 'pending':
                redirect('dekan/halaman_pending?' . $query_params);
                break;
            default:
                redirect('dekan?' . $query_params);
        }
    }

    public function reject($id)
    {
        $notes = $this->input->post('rejection_notes');
         // Ambil data surat dari database
        $surat = $this->db->get_where('surat', ['id' => $id])->row();

        $approval = json_decode($surat->approval_status, true);

        $approval['dekan'] = date("Y-m-d H:i:s");

        $this->db->where('id', $id)->update('surat', [
            'status' => 'ditolak dekan',
            'approval_status' => json_encode($approval),
            'catatan_penolakan' => $notes,
        ]);

        $this->session->set_flashdata('success', 'Surat berhasil ditolak.');
        
        // Redirect kembali ke halaman sebelumnya dengan filter yang sama
        $current_page = $this->input->get('from') ?? 'dekan';
        $tahun = $this->input->get('tahun') ?? date('Y');
        $search = $this->input->get('search');
        $status = $this->input->get('status');
        
        $query_params = 'tahun=' . $tahun;
        if (!empty($search)) {
            $query_params .= '&search=' . urlencode($search);
        }
        if (!empty($status)) {
            $query_params .= '&status=' . $status;
        }
        
        switch($current_page) {
            case 'total':
                redirect('dekan/halaman_total?' . $query_params);
                break;
            case 'disetujui':
                redirect('dekan/halaman_disetujui?' . $query_params);
                break;
            case 'ditolak':
                redirect('dekan/halaman_ditolak?' . $query_params);
                break;
            case 'pending':
                redirect('dekan/halaman_pending?' . $query_params);
                break;
            default:
                redirect('dekan?' . $query_params);
        }
    }

    // ✅ METHOD BARU: Process Multi Approve untuk Dekan
    public function process_multi_approve()
    {
        if ($this->input->post()) {
            // Ambil selected_ids sebagai array
            $selected_ids = $this->input->post('selected_ids');
            
            // Debug: Cek data yang diterima
            log_message('debug', 'Dekan - Selected IDs: ' . print_r($selected_ids, true));
            
            if (empty($selected_ids)) {
                $this->session->set_flashdata('error', 'Tidak ada pengajuan yang dipilih');
                redirect('dekan/halaman_pending');
            }
            
            $success_count = 0;
            $error_count = 0;
            
            foreach ($selected_ids as $id) {
                $surat = $this->db->get_where('surat', ['id' => $id])->row();
                
                if ($surat) {
                    // Cek apakah status sudah 'disetujui sekretariat' (harus melalui proses sebelumnya)
                    if ($surat->status !== 'disetujui sekretariat') {
                        $error_count++;
                        log_message('error', "Dekan - Pengajuan ID: $id belum disetujui sekretariat. Status: " . $surat->status);
                        continue;
                    }
                    
                    $approval = json_decode($surat->approval_status, true) ?? [];
                    $approval['dekan'] = date("Y-m-d H:i:s");
                    
                    // Generate nomor surat unik untuk setiap pengajuan
                    $nomor_surat = $this->generate_nomor_surat_dekan();
                    
                    $result = $this->db->where('id', $id)->update('surat', [
                        'status' => 'disetujui dekan',
                        'nomor_surat' => $nomor_surat,
                        'approval_status' => json_encode($approval),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    
                    if ($result) {
                        $success_count++;
                        $this->add_approval_log($id, 'Dekan', 'Disetujui');
                        
                        // Kirim notifikasi atau email (opsional)
                        $this->send_approval_notification($surat);
                    } else {
                        $error_count++;
                        log_message('error', "Dekan - Gagal menyetujui pengajuan ID: $id");
                    }
                } else {
                    $error_count++;
                    log_message('error', "Dekan - Pengajuan ID: $id tidak ditemukan");
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
            
            redirect('dekan/halaman_pending');
        } else {
            $this->session->set_flashdata('error', 'Metode request tidak valid');
            redirect('dekan/halaman_pending');
        }
    }

    // ✅ METHOD BARU: Process Multi Reject untuk Dekan
    public function process_multi_reject()
    {
        if ($this->input->post()) {
            // Ambil selected_ids dan rejection_notes sebagai array
            $selected_ids = $this->input->post('selected_ids');
            $rejection_notes = $this->input->post('rejection_notes');
            
            // Debug: Cek data yang diterima
            log_message('debug', 'Dekan - Selected IDs: ' . print_r($selected_ids, true));
            log_message('debug', 'Dekan - Rejection Notes: ' . print_r($rejection_notes, true));
            
            if (empty($selected_ids)) {
                $this->session->set_flashdata('error', 'Tidak ada pengajuan yang dipilih');
                redirect('dekan/halaman_pending');
            }
            
            // Validasi rejection notes
            if (empty($rejection_notes)) {
                $this->session->set_flashdata('error', 'Alasan penolakan harus diisi');
                redirect('dekan/halaman_pending');
            }
            
            $success_count = 0;
            $error_count = 0;
            
            // PERBAIKAN UTAMA: Handle rejection_notes yang berupa array
            foreach ($selected_ids as $index => $id) {
                $surat = $this->db->get_where('surat', ['id' => $id])->row();
                
                if ($surat) {
                    // Cek apakah status sudah 'disetujui sekretariat'
                    if ($surat->status !== 'disetujui sekretariat') {
                        $error_count++;
                        log_message('error', "Dekan - Pengajuan ID: $id belum disetujui sekretariat. Status: " . $surat->status);
                        continue;
                    }
                    
                    $approval = json_decode($surat->approval_status, true) ?? [];
                    $approval['dekan'] = date("Y-m-d H:i:s");

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
                        'status' => 'ditolak dekan',
                        'approval_status' => json_encode($approval),
                        'catatan_penolakan' => $catatan, // Simpan sebagai string
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    
                    if ($result) {
                        $success_count++;
                        $this->add_approval_log($id, 'Dekan', 'Ditolak', $catatan);
                    } else {
                        $error_count++;
                        log_message('error', "Dekan - Gagal menolak pengajuan ID: $id");
                    }
                } else {
                    $error_count++;
                    log_message('error', "Dekan - Pengajuan ID: $id tidak ditemukan");
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
            
            redirect('dekan/halaman_pending');
        } else {
            $this->session->set_flashdata('error', 'Metode request tidak valid');
            redirect('dekan/halaman_pending');
        }
    }

    public function list_surat_tugas()
    {
        // Semua surat yg pernah diproses Dekan
        $this->db->where_in("status", ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $this->db->order_by("created_at", "DESC");
        
        // PERBAIKAN: Ambil data dengan field lengkap
        $data['surat_list'] = $this->db->select('*')
                               ->get("surat")
                               ->result_array();

        // Statistik - hanya data yang relevan untuk dekan
        $data['approved_count'] = $this->db->where('status', 'disetujui dekan')->count_all_results('surat');
        $data['pending_count'] = $this->db->where('status', 'disetujui sekretariat')->count_all_results('surat');
        $data['rejected_count'] = $this->db->where('status', 'ditolak dekan')->count_all_results('surat');
        
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $data['total_count'] = $this->db->count_all_results('surat');

        $this->load->view('dekan/list_surat_tugas', $data);
    }

    public function laporan()
    {
        $data['stats'] = [
            'total_surat'        => $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan'])->count_all_results('surat'),
            'surat_bulan_ini'    => $this->db->like('created_at', date('Y-m'))->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan'])->count_all_results('surat'),
            'surat_diselesaikan' => $this->db->where('status', 'disetujui dekan')->count_all_results('surat'),
            'surat_ditolak'      => $this->db->where('status', 'ditolak dekan')->count_all_results('surat'),
            'surat_menunggu'     => $this->db->where('status', 'disetujui sekretariat')->count_all_results('surat')
        ];

        $this->load->view('dekan/laporan', $data);
    }
    
    // PERBAIKAN UTAMA: Method detail yang sudah dikoreksi
    public function detail($id)
    {
        // Ambil surat dengan field lengkap
        $this->db->where('id', $id);
        $data['surat'] = $this->db->get("surat")->row_array(); // Ubah ke row_array untuk konsistensi

        if (!$data['surat']) {
            show_404();
        }

        // DEBUG: Tampilkan struktur data untuk troubleshooting
        // echo "<pre>"; print_r($data['surat']); echo "</pre>"; die();

        // PERBAIKAN: Ambil data dosen berdasarkan NIP dari tabel surat
        $nip = $data['surat']['nip'];
        
        // Cek apakah NIP ada dan tidak kosong
        if (!empty($nip)) {
            // Jika NIP adalah JSON array, decode dulu
            if (is_json($nip)) {
                $nip_list = json_decode($nip, true);
                if (is_array($nip_list)) {
                    $this->db->where_in('nip', $nip_list);
                } else {
                    $this->db->where('nip', $nip);
                }
            } else {
                $this->db->where('nip', $nip);
            }
            
            $data['dosen_list'] = $this->db->get('list_dosen')->result_array();
        } else {
            $data['dosen_list'] = [];
        }

        // Jika tidak ada data dosen, buat data fallback dari field nama_dosen di tabel surat
        if (empty($data['dosen_list']) && !empty($data['surat']['nama_dosen'])) {
            $data['dosen_list'] = [
                [
                    'nama' => $data['surat']['nama_dosen'],
                    'nip' => $data['surat']['nip'],
                    'jabatan' => '-',
                    'divisi' => '-'
                ]
            ];
        }

        $this->load->view('dekan/detail_surat', $data);
    }

    // PERBAIKAN: Method untuk AJAX detail
    public function get_surat_detail($id)
    {
        // Ambil data surat dulu
        $surat = $this->db->get_where('surat', ['id' => $id])->row_array();

        if (!$surat) {
            echo json_encode(['error' => 'Data tidak ditemukan']);
            return;
        }

        // PERBAIKAN: Ambil data dosen berdasarkan NIP
        $nip = $surat['nip'];
        $dosen_data = [];

        if (!empty($nip)) {
            // Handle NIP yang berupa JSON array
            if (is_json($nip)) {
                $nip_list = json_decode($nip, true);
                if (is_array($nip_list)) {
                    $this->db->where_in('nip', $nip_list);
                    $dosen_result = $this->db->get('list_dosen')->result_array();
                    $dosen_data = $dosen_result;
                }
            } else {
                // NIP tunggal
                $dosen = $this->db->get_where('list_dosen', ['nip' => $nip])->row_array();
                if ($dosen) {
                    $dosen_data = [$dosen];
                }
            }
        }

        // Gabungkan data
        $surat['dosen_data'] = $dosen_data;

        // Jika tidak ada data dosen dari list_dosen, gunakan data dari field nama_dosen di surat
        if (empty($dosen_data) && !empty($surat['nama_dosen'])) {
            $surat['dosen_data'] = [
                [
                    'nama' => $surat['nama_dosen'],
                    'nip' => $surat['nip'],
                    'jabatan' => '-',
                    'divisi' => '-'
                ]
            ];
        }

        echo json_encode($surat);
    }

    // Filter laporan
    public function filter($status = '')
    {
        $this->db->order_by("created_at", "DESC");
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);

        if ($status == 'menunggu') {
            $this->db->where('status', 'disetujui sekretariat');
        } 
        elseif ($status == 'disetujui') {
            $this->db->where('status', 'disetujui dekan');
        } 
        elseif ($status == 'ditolak') {
            $this->db->where('status', 'ditolak dekan');
        } 
        // else: tampilkan semua data yang relevan untuk dekan

        // PERBAIKAN: Ambil data dengan field lengkap
        $data['surat_list'] = $this->db->select('*')
                               ->get("surat")
                               ->result_array();
                               
        $data['current_filter'] = $status;

        $this->load->view('dekan/list_surat_tugas', $data);
    }

    // ✅ METHOD BARU: Helper function untuk generate nomor surat dekan
    private function generate_nomor_surat_dekan()
    {
        $this->load->helper('string');
        
        $year = date('Y');
        $random = random_string('numeric', 4);
        
        return "{$random}/SK/FT/{$year}";
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
        log_message('info', "Dekan Approval Log: Surat ID $surat_id - $approver - $status - $notes");
    }

    // ✅ METHOD BARU: Helper function untuk notifikasi (opsional)
    private function send_approval_notification($surat)
    {
        // Implementasi notifikasi email atau sistem notifikasi lainnya
        // Contoh sederhana log
        log_message('info', "Notifikasi: Pengajuan {$surat->nama_kegiatan} telah disetujui Dekan");
    }
}

// PERBAIKAN: Tambahkan helper function untuk cek JSON
if (!function_exists('is_json')) {
    function is_json($string) {
        if (!is_string($string)) {
            return false;
        }
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}