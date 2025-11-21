<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sekretariat extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->model('Surat_model');
    }

    /* ================================
       DASHBOARD
    ================================= */
    public function index() {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $data['tahun'] = $tahun;

        // Surat yang relevan bagi sekretariat
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in("status", ['disetujui KK', 'disetujui dekan', 'ditolak dekan']);
        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // Statistik
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui KK', 'disetujui dekan', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        // Pending (menunggu sekretariat)
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'disetujui KK');
        $data['pending_count'] = $this->db->count_all_results('surat');

        // Disetujui oleh dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'disetujui dekan');
        $data['approved_count'] = $this->db->count_all_results('surat');

        // Ditolak oleh dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'ditolak dekan');
        $data['rejected_count'] = $this->db->count_all_results('surat');

        // Grafik
        $total     = array_fill(0, 12, 0);
        $approved  = array_fill(0, 12, 0);
        $rejected  = array_fill(0, 12, 0);
        $pending   = array_fill(0, 12, 0);

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui KK', 'disetujui dekan', 'ditolak dekan']);
        $query = $this->db->get('surat')->result();

        foreach ($query as $row) {
            $month = (int)date('m', strtotime($row->created_at)) - 1;

            $total[$month]++;

            if ($row->status == 'disetujui KK') {
                $pending[$month]++;
            }

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
        $data['chart_pending']  = $pending;

        $this->load->view('sekretariat/dashboard', $data);
    }

    /* ================================
       PENDING (Disetujui KK)
    ================================= */
    public function pending() {
        $search = $this->input->get('search');
        $tahun = $this->input->get('tahun') ?? date('Y');
        
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'disetujui KK');
        
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
        $data['judul'] = "Pengajuan Menunggu Persetujuan Sekretariat";
        $data['role'] = "sekretariat";
        $data['tahun'] = $tahun;

        $this->load->view('sekretariat/halaman_pending', $data);
    }

    /* ================================
       DISETUJUI DEKAN
    ================================= */
    public function disetujui() {
        $search = $this->input->get('search');
        $tahun = $this->input->get('tahun') ?? date('Y');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'disetujui dekan');

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
        $data['judul'] = "Pengajuan Disetujui - Final Dekan";
        $data['role'] = "sekretariat";
        $data['tahun'] = $tahun;

        $this->load->view('sekretariat/halaman_disetujui', $data);
    }

    /* ================================
       DITOLAK DEKAN
    ================================= */
    public function ditolak() {
        $search = $this->input->get('search');
        $tahun = $this->input->get('tahun') ?? date('Y');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'ditolak dekan');

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
        $data['judul'] = "Pengajuan Ditolak - Final Dekan";
        $data['role'] = "sekretariat";
        $data['tahun'] = $tahun;

        $this->load->view('sekretariat/halaman_ditolak', $data);
    }

    /* ================================
       TOTAL SEMUA PENGAJUAN
    ================================= */
    public function semua() {
        $search = $this->input->get('search');
        $status_filter = $this->input->get('status');
        $tahun = $this->input->get('tahun') ?? date('Y');

        $this->db->where('YEAR(created_at)', $tahun);

        if (!empty($status_filter)) {
            switch ($status_filter) {
                case 'pending':
                    $this->db->where('status', 'disetujui KK');
                    break;
                case 'approved':
                    $this->db->where('status', 'disetujui dekan');
                    break;
                case 'rejected':
                    $this->db->where('status', 'ditolak dekan');
                    break;
                default:
                    $this->db->where_in('status', ['disetujui KK', 'disetujui dekan', 'ditolak dekan']);
                    break;
            }
        } else {
            $this->db->where_in('status', ['disetujui KK', 'disetujui dekan', 'ditolak dekan']);
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
        $data['judul'] = "Total Pengajuan - Sekretariat";
        $data['role'] = "sekretariat";
        $data['tahun'] = $tahun;
        $data['status_filter'] = $status_filter;

        $this->load->view('sekretariat/halaman_total', $data);
    }

    /* ================================
       DETAIL MODAL (AJAX)
    ================================= */
    public function getDetailPengajuan($id) {
        $this->db->where('id', $id);
        $pengajuan = $this->db->get('surat')->row();
        
        if ($pengajuan) {
            echo json_encode([
                'success' => true,
                'data' => $pengajuan
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    /* ================================
       REALTIME DASHBOARD COUNTER
    ================================= */
    public function get_dashboard_counts() {
        $tahun = $this->input->get('tahun') ?? date('Y');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui KK', 'disetujui dekan', 'ditolak dekan']);
        $total = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'disetujui KK');
        $pending = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'disetujui dekan');
        $approved = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'ditolak dekan');
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
