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
        
        // Filter search
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('nip', $search);
            $this->db->or_like('nama_dosen', $search);
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
                    break;
            }
        }

        $data['surat_list'] = $this->db->select('*')
                               ->order_by('created_at', 'DESC')
                               ->get('surat')
                               ->result_array();

        // Proses data dosen untuk setiap surat
        foreach ($data['surat_list'] as &$surat) {
            $surat['dosen_data'] = $this->get_dosen_data($surat);
        }

        // Statistik untuk card
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

        // Grafik data
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

        // Filter search
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('nip', $search);
            $this->db->or_like('nama_dosen', $search);
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

        $data['surat_list'] = $this->db->select('*')
                               ->order_by('created_at', 'DESC')
                               ->get('surat')
                               ->result_array();

        // Proses data dosen untuk setiap surat
        foreach ($data['surat_list'] as &$surat) {
            $surat['dosen_data'] = $this->get_dosen_data($surat);
        }

        // Statistik
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('nip', $search);
            $this->db->or_like('nama_dosen', $search);
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

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'disetujui dekan');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('nip', $search);
            $this->db->or_like('nama_dosen', $search);
            $this->db->group_end();
        }

        $data['surat_list'] = $this->db->select('*')
                               ->order_by('created_at', 'DESC')
                               ->get('surat')
                               ->result_array();

        foreach ($data['surat_list'] as &$surat) {
            $surat['dosen_data'] = $this->get_dosen_data($surat);
        }

        // Statistik
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

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'ditolak dekan');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('nip', $search);
            $this->db->or_like('nama_dosen', $search);
            $this->db->group_end();
        }

        $data['surat_list'] = $this->db->select('*')
                               ->order_by('created_at', 'DESC')
                               ->get('surat')
                               ->result_array();

        foreach ($data['surat_list'] as &$surat) {
            $surat['dosen_data'] = $this->get_dosen_data($surat);
        }

        // Statistik
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

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'disetujui sekretariat');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('nip', $search);
            $this->db->or_like('nama_dosen', $search);
            $this->db->group_end();
        }

        $data['surat_list'] = $this->db->select('*')
                               ->order_by('created_at', 'DESC')
                               ->get('surat')
                               ->result_array();

        foreach ($data['surat_list'] as &$surat) {
            $surat['dosen_data'] = $this->get_dosen_data($surat);
        }

        // Statistik
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

    // Process Multi Approve untuk Dekan
    public function process_multi_approve()
    {
        if ($this->input->post()) {
            $selected_ids = $this->input->post('selected_ids');
            
            if (empty($selected_ids)) {
                $this->session->set_flashdata('error', 'Tidak ada pengajuan yang dipilih');
                redirect('dekan/halaman_pending');
            }
            
            $success_count = 0;
            $error_count = 0;
            
            foreach ($selected_ids as $id) {
                $surat = $this->db->get_where('surat', ['id' => $id])->row();
                
                if ($surat) {
                    if ($surat->status !== 'disetujui sekretariat') {
                        $error_count++;
                        continue;
                    }
                    
                    $approval = json_decode($surat->approval_status, true) ?? [];
                    $approval['dekan'] = date("Y-m-d H:i:s");
                    
                    $nomor_surat = $this->generate_nomor_surat_dekan();
                    
                    $result = $this->db->where('id', $id)->update('surat', [
                        'status' => 'disetujui dekan',
                        'nomor_surat' => $nomor_surat,
                        'approval_status' => json_encode($approval),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    
                    if ($result) {
                        $success_count++;
                    } else {
                        $error_count++;
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
            
            redirect('dekan/halaman_pending');
        } else {
            $this->session->set_flashdata('error', 'Metode request tidak valid');
            redirect('dekan/halaman_pending');
        }
    }

    // Process Multi Reject untuk Dekan
    public function process_multi_reject()
    {
        if ($this->input->post()) {
            $selected_ids = $this->input->post('selected_ids');
            $rejection_notes = $this->input->post('rejection_notes');
            
            if (empty($selected_ids)) {
                $this->session->set_flashdata('error', 'Tidak ada pengajuan yang dipilih');
                redirect('dekan/halaman_pending');
            }
            
            if (empty($rejection_notes)) {
                $this->session->set_flashdata('error', 'Alasan penolakan harus diisi');
                redirect('dekan/halaman_pending');
            }
            
            $success_count = 0;
            $error_count = 0;
            
            foreach ($selected_ids as $index => $id) {
                $surat = $this->db->get_where('surat', ['id' => $id])->row();
                
                if ($surat) {
                    if ($surat->status !== 'disetujui sekretariat') {
                        $error_count++;
                        continue;
                    }
                    
                    $approval = json_decode($surat->approval_status, true) ?? [];
                    $approval['dekan'] = date("Y-m-d H:i:s");

                    if (is_array($rejection_notes)) {
                        $catatan = isset($rejection_notes[$index]) ? $rejection_notes[$index] : 'Tidak ada catatan';
                    } else {
                        $catatan = $rejection_notes;
                    }
                    
                    $catatan = is_array($catatan) ? implode(', ', $catatan) : $catatan;

                    $result = $this->db->where('id', $id)->update('surat', [
                        'status' => 'ditolak dekan',
                        'approval_status' => json_encode($approval),
                        'catatan_penolakan' => $catatan,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    
                    if ($result) {
                        $success_count++;
                    } else {
                        $error_count++;
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
            
            redirect('dekan/halaman_pending');
        } else {
            $this->session->set_flashdata('error', 'Metode request tidak valid');
            redirect('dekan/halaman_pending');
        }
    }

    public function list_surat_tugas()
    {
        $this->db->where_in("status", ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $this->db->order_by("created_at", "DESC");
        
        $data['surat_list'] = $this->db->select('*')
                               ->get("surat")
                               ->result_array();

        foreach ($data['surat_list'] as &$surat) {
            $surat['dosen_data'] = $this->get_dosen_data($surat);
        }

        // Statistik
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
    
    public function detail($id)
    {
        $this->db->where('id', $id);
        $data['surat'] = $this->db->get("surat")->row_array();

        if (!$data['surat']) {
            show_404();
        }

        $data['surat']['dosen_data'] = $this->get_dosen_data($data['surat']);

        $this->load->view('dekan/detail_surat', $data);
    }

    public function get_surat_detail($id)
    {
        $surat = $this->db->get_where('surat', ['id' => $id])->row_array();

        if (!$surat) {
            echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan']);
            return;
        }

        $surat['dosen_data'] = $this->get_dosen_data($surat);

        echo json_encode(['success' => true, 'data' => $surat]);
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

        $data['surat_list'] = $this->db->select('*')
                               ->get("surat")
                               ->result_array();

        foreach ($data['surat_list'] as &$surat) {
            $surat['dosen_data'] = $this->get_dosen_data($surat);
        }
                               
        $data['current_filter'] = $status;

        $this->load->view('dekan/list_surat_tugas', $data);
    }

    // Helper function untuk generate nomor surat dekan
    private function generate_nomor_surat_dekan()
    {
        $this->load->helper('string');
        
        $year = date('Y');
        $random = random_string('numeric', 4);
        
        return "{$random}/SK/FT/{$year}";
    }

    // PERBAIKAN UTAMA: Fungsi get_dosen_data yang sudah dikoreksi
    private function get_dosen_data($surat)
    {
        $dosen_data = [];
        $nip = $surat['nip'] ?? '';
        $nama_dosen = $surat['nama_dosen'] ?? '';

        // Debug informasi
        error_log("Dekan - Processing dosen data for surat ID: " . ($surat['id'] ?? 'unknown'));
        error_log("Dekan - Raw NIP: " . $nip);
        error_log("Dekan - Raw Nama Dosen: " . $nama_dosen);

        // PERBAIKAN UTAMA: Prioritaskan menggunakan data dari field nama_dosen langsung
        if (!empty($nama_dosen)) {
            // Cek apakah nama_dosen adalah JSON array
            if ($this->_is_json($nama_dosen)) {
                try {
                    $nama_list = json_decode($nama_dosen, true);
                    error_log("Dekan - Decoded Nama List: " . print_r($nama_list, true));
                    
                    if (is_array($nama_list) && !empty($nama_list)) {
                        // Jika NIP juga JSON array
                        if (!empty($nip) && $this->_is_json($nip)) {
                            $nip_list = json_decode($nip, true);
                            error_log("Dekan - Decoded NIP List: " . print_r($nip_list, true));
                            
                            // Gabungkan nama dan NIP
                            foreach ($nama_list as $index => $nama) {
                                $current_nip = isset($nip_list[$index]) ? $nip_list[$index] : '-';
                                $dosen_data[] = [
                                    'nama' => $nama,
                                    'nip' => $current_nip,
                                    'jabatan' => 'Dosen',
                                    'divisi' => $this->get_divisi_from_nip($current_nip)
                                ];
                            }
                        } else {
                            // Jika hanya nama_dosen yang JSON array
                            foreach ($nama_list as $nama) {
                                $dosen_data[] = [
                                    'nama' => $nama,
                                    'nip' => $nip ?: '-',
                                    'jabatan' => 'Dosen',
                                    'divisi' => $this->get_divisi_from_nip($nip)
                                ];
                            }
                        }
                    }
                } catch (Exception $e) {
                    error_log("Dekan - Error decoding JSON: " . $e->getMessage());
                    // Fallback: gunakan sebagai string biasa
                    $dosen_data[] = [
                        'nama' => $nama_dosen,
                        'nip' => $nip ?: '-',
                        'jabatan' => 'Dosen',
                        'divisi' => $this->get_divisi_from_nip($nip)
                    ];
                }
            } else {
                // Jika nama_dosen adalah string biasa
                // Cek apakah NIP adalah JSON array
                if (!empty($nip) && $this->_is_json($nip)) {
                    try {
                        $nip_list = json_decode($nip, true);
                        if (is_array($nip_list) && !empty($nip_list)) {
                            foreach ($nip_list as $nip_item) {
                                $dosen_data[] = [
                                    'nama' => $nama_dosen,
                                    'nip' => $nip_item,
                                    'jabatan' => 'Dosen',
                                    'divisi' => $this->get_divisi_from_nip($nip_item)
                                ];
                            }
                        }
                    } catch (Exception $e) {
                        error_log("Dekan - Error decoding NIP JSON: " . $e->getMessage());
                        $dosen_data[] = [
                            'nama' => $nama_dosen,
                            'nip' => $nip,
                            'jabatan' => 'Dosen',
                            'divisi' => $this->get_divisi_from_nip($nip)
                        ];
                    }
                } else {
                    // Kasus paling sederhana: single dosen
                    $dosen_data[] = [
                        'nama' => $nama_dosen,
                        'nip' => $nip ?: '-',
                        'jabatan' => 'Dosen',
                        'divisi' => $this->get_divisi_from_nip($nip)
                    ];
                }
            }
        } else {
            // Jika tidak ada nama_dosen, coba ambil dari list_dosen berdasarkan NIP
            if (!empty($nip)) {
                if ($this->_is_json($nip)) {
                    try {
                        $nip_list = json_decode($nip, true);
                        if (is_array($nip_list) && !empty($nip_list)) {
                            // PERBAIKAN: Pastikan array tidak kosong sebelum query
                            $this->db->where_in('nip', $nip_list);
                            $dosen_result = $this->db->get('list_dosen')->result_array();
                            
                            if (!empty($dosen_result)) {
                                $dosen_data = $dosen_result;
                            } else {
                                foreach ($nip_list as $nip_item) {
                                    $dosen_data[] = [
                                        'nama' => 'Data tidak tersedia',
                                        'nip' => $nip_item,
                                        'jabatan' => 'Dosen',
                                        'divisi' => $this->get_divisi_from_nip($nip_item)
                                    ];
                                }
                            }
                        }
                    } catch (Exception $e) {
                        error_log("Dekan - Error decoding NIP JSON: " . $e->getMessage());
                    }
                } else {
                    // Single NIP
                    $dosen_result = $this->db->get_where('list_dosen', ['nip' => $nip])->result_array();
                    if (!empty($dosen_result)) {
                        $dosen_data = $dosen_result;
                    } else {
                        $dosen_data[] = [
                            'nama' => 'Data tidak tersedia',
                            'nip' => $nip,
                            'jabatan' => 'Dosen',
                            'divisi' => $this->get_divisi_from_nip($nip)
                        ];
                    }
                }
            } else {
                // Ultimate fallback
                $dosen_data[] = [
                    'nama' => 'Data dosen tidak tersedia',
                    'nip' => '-',
                    'jabatan' => '-',
                    'divisi' => '-'
                ];
            }
        }

        // PERBAIKAN: Jika masih kosong, berikan data default
        if (empty($dosen_data)) {
            $dosen_data[] = [
                'nama' => 'Data dosen tidak tersedia',
                'nip' => '-',
                'jabatan' => '-',
                'divisi' => '-'
            ];
        }

        error_log("Dekan - Final Dosen Data: " . print_r($dosen_data, true));
        return $dosen_data;
    }

    // Helper function untuk mendapatkan divisi dari NIP
    private function get_divisi_from_nip($nip)
    {
        if (empty($nip) || $nip == '-') return '-';
        
        // Mapping sederhana berdasarkan digit NIP
        if (strpos($nip, '1777') === 0) return 'DKV';
        if (strpos($nip, '2095') === 0) return 'DI';
        if (strpos($nip, '1888') === 0) return 'IK';
        if (strpos($nip, '1999') === 0) return 'RKS';
        
        return '-';
    }

    // Method helper untuk cek JSON
    private function _is_json($string) {
        if (!is_string($string)) {
            return false;
        }
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}