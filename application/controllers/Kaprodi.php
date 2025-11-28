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

    /* ================================
       DASHBOARD
    ================================= */
    public function index()
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $data['tahun'] = $tahun;

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where("status", 'pengajuan');
        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        $this->db->where('YEAR(created_at)', $tahun);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'pengajuan');
        $data['pending_count'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui KK', 'disetujui dekan', 'disetujui sekretariat']);
        $data['approved_count'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['ditolak KK', 'ditolak sekretariat', 'ditolak dekan']);
        $data['rejected_count'] = $this->db->count_all_results('surat');

        $total     = array_fill(0, 12, 0);
        $approved  = array_fill(0, 12, 0);
        $rejected  = array_fill(0, 12, 0);
        $pending   = array_fill(0, 12, 0);

        $this->db->where('YEAR(created_at)', $tahun);
        $query = $this->db->get('surat')->result();

        foreach ($query as $row) {
            $month = (int)date('m', strtotime($row->created_at)) - 1;
            $total[$month]++;
            if ($row->status == 'pengajuan') $pending[$month]++;
            if (in_array($row->status, ['disetujui KK', 'disetujui dekan', 'disetujui sekretariat'])) $approved[$month]++;
            if (in_array($row->status, ['ditolak KK', 'ditolak sekretariat'])) $rejected[$month]++;
        }

        $data['chart_total']    = $total;
        $data['chart_approved'] = $approved;
        $data['chart_rejected'] = $rejected;
        $data['chart_pending']  = $pending;

        $this->load->view('kaprodi/dashboard', $data);
    }

    /* ================================
       PENDING
    ================================= */
    public function pending()
    {
        $search = $this->input->get('search');
        $tahun = $this->input->get('tahun') ?? date('Y');
        
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'pengajuan');
        
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }

        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();
        $data['total_surat'] = count($data['surat_list']);
        $data['judul'] = "Pengajuan Menunggu Persetujuan Kaprodi";
        $data['role'] = "kaprodi";
        $data['tahun'] = $tahun;

        $this->load->view('kaprodi/halaman_pending', $data);
    }

    /* ================================
       DISETUJUI
    ================================= */
    public function disetujui()
    {
        $search = $this->input->get('search');
        $tahun = $this->input->get('tahun') ?? date('Y');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui KK', 'disetujui dekan', 'disetujui sekretariat']);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }

        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();
        $data['total_surat'] = count($data['surat_list']);
        $data['judul'] = "Pengajuan Disetujui";
        $data['role'] = "kaprodi";
        $data['tahun'] = $tahun;

        $this->load->view('kaprodi/halaman_disetujui', $data);
    }

    /* ================================
       DITOLAK
    ================================= */
    public function ditolak()
    {
        $search = $this->input->get('search');
        $tahun = $this->input->get('tahun') ?? date('Y');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['ditolak KK', 'ditolak sekretariat']);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }

        $this->db->order_by("created_at", "DESC");
        $data['pengajuan_ditolak'] = $this->db->get("surat")->result();
        $data['total_surat'] = count($data['pengajuan_ditolak']);
        $data['judul'] = "Pengajuan Ditolak";
        $data['role'] = "kaprodi";
        $data['tahun'] = $tahun;

        $this->load->view('kaprodi/halaman_ditolak', $data);
    }

    /* ================================
       SEMUA
    ================================= */
    public function semua()
    {
        $search = $this->input->get('search');
        $status_filter = $this->input->get('status');
        $tahun = $this->input->get('tahun') ?? date('Y');

        $this->db->where('YEAR(created_at)', $tahun);

        if (!empty($status_filter)) {
            switch ($status_filter) {
                case 'pending':
                    $this->db->where('status', 'pengajuan');
                    break;
                case 'approved':
                    $this->db->where_in('status', ['disetujui KK', 'disetujui dekan', 'disetujui sekretariat']);
                    break;
                case 'rejected':
                    $this->db->where_in('status', ['ditolak KK', 'ditolak sekretariat']);
                    break;
            }
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }

        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();
        $data['total_surat'] = count($data['surat_list']);
        $data['judul'] = "Total Pengajuan - Kaprodi";
        $data['role'] = "kaprodi";
        $data['tahun'] = $tahun;
        $data['status_filter'] = $status_filter;

        $this->load->view('kaprodi/halaman_total', $data);
    }

    /* ================================
       GET DETAIL PENGAJUAN (AJAX)
    ================================= */
    public function getDetailPengajuan($id)
    {
        $this->db->where('id', $id);
        $pengajuan = $this->db->get('surat')->row();
        
        if ($pengajuan) {
            $dosen_data = $this->get_dosen_data_from_nip_fixed($pengajuan->nip);
            
            $response_data = array(
                'id' => $pengajuan->id,
                'nama_kegiatan' => $pengajuan->nama_kegiatan,
                'status' => $pengajuan->status,
                'jenis_pengajuan' => $pengajuan->jenis_pengajuan,
                'lingkup_penugasan' => $pengajuan->lingkup_penugasan,
                'penyelenggara' => $pengajuan->penyelenggara,
                'tanggal_kegiatan' => $pengajuan->tanggal_kegiatan,
                'tempat_kegiatan' => $pengajuan->tempat_kegiatan,
                'created_at' => $pengajuan->created_at,
                'eviden' => $pengajuan->eviden,
                'nomor_surat' => $pengajuan->nomor_surat,
                'catatan_penolakan' => $pengajuan->catatan_penolakan,
                'dosen_data' => $dosen_data
            );
            
            echo json_encode([
                'success' => true,
                'data' => $response_data
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    /* ================================
       GET DOSEN DATA FROM NIP
    ================================= */
    private function get_dosen_data_from_nip_fixed($nip_data)
    {
        $dosen_data = array();
        
        if (empty($nip_data) || $nip_data === '-' || $nip_data === '[]' || $nip_data === 'null') {
            return [array(
                'nama' => 'Data dosen tidak tersedia',
                'nip' => '-',
                'jabatan' => '-',
                'divisi' => '-'
            )];
        }
        
        $nip_array = array();
        
        if (is_string($nip_data)) {
            $trimmed_data = trim($nip_data);
            
            if (preg_match('/^\[.*\]$/', $trimmed_data)) {
                $decoded = json_decode($trimmed_data, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $nip_array = $decoded;
                } else {
                    preg_match_all('/\d+/', $trimmed_data, $matches);
                    $nip_array = $matches[0] ?? [$trimmed_data];
                }
            } else {
                $nip_array = [$trimmed_data];
            }
        } elseif (is_array($nip_data)) {
            $nip_array = $nip_data;
        } else {
            $nip_array = [$nip_data];
        }
        
        $nip_array = array_filter(array_map(function($nip) {
            if (is_array($nip)) {
                return !empty($nip) ? trim(strval($nip[0])) : null;
            }
            return trim(strval($nip));
        }, $nip_array), function($nip) {
            return !empty($nip) && $nip !== '-' && $nip !== 'null' && $nip !== '[]';
        });
        
        if (empty($nip_array)) {
            return [array(
                'nama' => 'Data dosen tidak tersedia',
                'nip' => '-',
                'jabatan' => '-',
                'divisi' => '-'
            )];
        }
        
        $this->db->select('nip, nama_dosen, jabatan, divisi');
        $this->db->from('list_dosen');
        
        if (count($nip_array) === 1) {
            $this->db->where('nip', $nip_array[0]);
        } else {
            $this->db->where_in('nip', $nip_array);
        }
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
            
            $dosen_by_nip = [];
            foreach ($results as $row) {
                $dosen_by_nip[trim($row['nip'])] = array(
                    'nama' => $row['nama_dosen'],
                    'nip' => $row['nip'],
                    'jabatan' => $row['jabatan'],
                    'divisi' => $row['divisi']
                );
            }
            
            foreach ($nip_array as $nip) {
                $clean_nip = trim(strval($nip));
                if (isset($dosen_by_nip[$clean_nip])) {
                    $dosen_data[] = $dosen_by_nip[$clean_nip];
                } else {
                    $dosen_data[] = array(
                        'nama' => 'Data tidak ditemukan',
                        'nip' => $clean_nip,
                        'jabatan' => '-',
                        'divisi' => '-'
                    );
                }
            }
        } else {
            foreach ($nip_array as $nip) {
                $clean_nip = trim(strval($nip));
                $dosen_data[] = array(
                    'nama' => 'Data dari NIP: ' . $clean_nip,
                    'nip' => $clean_nip,
                    'jabatan' => '-',
                    'divisi' => '-'
                );
            }
        }
        
        return $dosen_data;
    }

    /* ================================
       APPROVE SINGLE
    ================================= */
    public function approve($id)
    {
        $surat = $this->db->get_where('surat', ['id' => $id])->row();
        
        if (!$surat) {
            $this->session->set_flashdata('error', 'Surat tidak ditemukan.');
            redirect('kaprodi/pending');
        }

        $approval = json_decode($surat->approval_status, true) ?? [];
        $approval['kk'] = date("Y-m-d H:i:s");
        
        $this->db->where('id', $id)->update('surat', [
            'status' => 'disetujui KK',
            'approval_status' => json_encode($approval),
        ]);

        $this->session->set_flashdata('success', 'Surat berhasil disetujui Kaprodi.');
        redirect('kaprodi/pending');
    }

    /* ================================
       REJECT SINGLE
    ================================= */
    public function reject($id)
    {
        $surat = $this->db->get_where('surat', ['id' => $id])->row();
        
        if (!$surat) {
            $this->session->set_flashdata('error', 'Surat tidak ditemukan.');
            redirect('kaprodi/pending');
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
        redirect('kaprodi/pending');
    }

    /* ================================
       ✅ FIXED: PROCESS MULTI APPROVE
    ================================= */
    public function process_multi_approve()
    {
        // Validasi request method
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('kaprodi/pending');
            return;
        }

        // Ambil selected IDs dari POST (sebagai array)
        $selected_ids = $this->input->post('selected_ids');
        
        // Validasi input
        if (empty($selected_ids) || !is_array($selected_ids)) {
            $this->session->set_flashdata('error', 'Tidak ada pengajuan yang dipilih.');
            redirect('kaprodi/pending');
            return;
        }
        
        $success_count = 0;
        $error_count = 0;
        $error_messages = [];
        
        // Proses setiap ID
        foreach ($selected_ids as $id) {
            $id = trim($id);
            
            // Skip jika ID kosong
            if (empty($id)) {
                continue;
            }
            
            // Ambil data surat
            $surat = $this->db->get_where('surat', ['id' => $id])->row();
            
            if (!$surat) {
                $error_count++;
                $error_messages[] = "Data tidak ditemukan (ID: $id)";
                continue;
            }
            
            // Update approval status
            $approval = json_decode($surat->approval_status, true);
            if (!is_array($approval)) {
                $approval = [];
            }
            $approval['kk'] = date("Y-m-d H:i:s");
            
            // Update database
            $update_data = [
                'status' => 'disetujui KK',
                'approval_status' => json_encode($approval),
            ];
            
            $this->db->where('id', $id);
            if ($this->db->update('surat', $update_data)) {
                $success_count++;
            } else {
                $error_count++;
                $error_messages[] = "Gagal update database (ID: $id)";
            }
        }
        
        // Set flash message berdasarkan hasil
        if ($success_count > 0) {
            $message = "✅ Berhasil menyetujui $success_count pengajuan.";
            if ($error_count > 0) {
                $message .= " ⚠️ $error_count pengajuan gagal: " . implode(', ', $error_messages);
            }
            $this->session->set_flashdata('success', $message);
        } else {
            $this->session->set_flashdata('error', "❌ Gagal menyetujui semua pengajuan: " . implode(', ', $error_messages));
        }
        
        redirect('kaprodi/pending');
    }

    /* ================================
       ✅ FIXED: PROCESS MULTI REJECT
    ================================= */
    public function process_multi_reject()
    {
        // Validasi request method
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('kaprodi/pending');
            return;
        }

        // Ambil selected IDs dan rejection notes dari POST (sebagai array)
        $selected_ids = $this->input->post('selected_ids');
        $rejection_notes_array = $this->input->post('rejection_notes');
        
        // Validasi input
        if (empty($selected_ids) || !is_array($selected_ids)) {
            $this->session->set_flashdata('error', 'Tidak ada pengajuan yang dipilih.');
            redirect('kaprodi/pending');
            return;
        }
        
        if (empty($rejection_notes_array) || !is_array($rejection_notes_array)) {
            $this->session->set_flashdata('error', 'Alasan penolakan harus diisi.');
            redirect('kaprodi/pending');
            return;
        }
        
        // Validasi jumlah IDs dan notes harus sama
        if (count($selected_ids) !== count($rejection_notes_array)) {
            $this->session->set_flashdata('error', 'Jumlah pengajuan dan alasan penolakan tidak sesuai.');
            redirect('kaprodi/pending');
            return;
        }
        
        $success_count = 0;
        $error_count = 0;
        $error_messages = [];
        
        // Proses setiap ID dengan rejection notes yang sesuai
        foreach ($selected_ids as $index => $id) {
            $id = trim($id);
            $rejection_notes = isset($rejection_notes_array[$index]) ? trim($rejection_notes_array[$index]) : '';
            
            // Skip jika ID kosong
            if (empty($id)) {
                continue;
            }
            
            // Validasi rejection notes untuk setiap item
            if (empty($rejection_notes)) {
                $error_count++;
                $error_messages[] = "Alasan penolakan kosong untuk ID: $id";
                continue;
            }
            
            // Ambil data surat
            $surat = $this->db->get_where('surat', ['id' => $id])->row();
            
            if (!$surat) {
                $error_count++;
                $error_messages[] = "Data tidak ditemukan (ID: $id)";
                continue;
            }
            
            // Update approval status
            $approval = json_decode($surat->approval_status, true);
            if (!is_array($approval)) {
                $approval = [];
            }
            $approval['kk'] = date("Y-m-d H:i:s");
            
            // Update database
            $update_data = [
                'status' => 'ditolak KK',
                'approval_status' => json_encode($approval),
                'catatan_penolakan' => $rejection_notes,
            ];
            
            $this->db->where('id', $id);
            if ($this->db->update('surat', $update_data)) {
                $success_count++;
            } else {
                $error_count++;
                $error_messages[] = "Gagal update database (ID: $id)";
            }
        }
        
        // Set flash message berdasarkan hasil
        if ($success_count > 0) {
            $message = "✅ Berhasil menolak $success_count pengajuan.";
            if ($error_count > 0) {
                $message .= " ⚠️ $error_count pengajuan gagal: " . implode(', ', $error_messages);
            }
            $this->session->set_flashdata('success', $message);
        } else {
            $this->session->set_flashdata('error', "❌ Gagal menolak semua pengajuan: " . implode(', ', $error_messages));
        }
        
        redirect('kaprodi/pending');
    }

    /* ================================
       GET DASHBOARD COUNTS (AJAX)
    ================================= */
    public function get_dashboard_counts()
    {
        $tahun = $this->input->get('tahun') ?? date('Y');

        $this->db->where('YEAR(created_at)', $tahun);
        $total = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'pengajuan');
        $pending = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui KK', 'disetujui dekan', 'disetujui sekretariat']);
        $approved = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['ditolak KK', 'ditolak sekretariat']);
        $rejected = $this->db->count_all_results('surat');

        $counts = [
            'total' => $total,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected
        ];

        header('Content-Type: application/json');
        echo json_encode($counts);
    }
}