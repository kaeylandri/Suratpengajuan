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
    DASHBOARD - DIPERBAIKI DENGAN FILTER BULAN
    ================================= */
    public function index($filter = 'all') {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $search = $this->input->get('search');
        $status_filter = $this->input->get('status');
        
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['current_filter'] = $filter;

        // Surat yang relevan bagi sekretariat
        $this->db->where('YEAR(created_at)', $tahun);
        
        // Filter bulan jika dipilih
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        
        $this->db->where_in("status", ['disetujui KK', 'ditolak dekan']);
        
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
                    $this->db->where('status', 'disetujui KK');
                    break;
                case 'approved':
                    $this->db->where('status', 'disetujui sekretariat');
                    break;
                case 'rejected':
                    $this->db->where('status', 'ditolak sekretariat');
                    break;
                case 'dekan_approved':
                    $this->db->where('status', 'disetujui dekan');
                    break;
                case 'dekan_rejected':
                    $this->db->where('status', 'ditolak dekan');
                    break;
            }
        } else {
            // Filter berdasarkan parameter route
            switch($filter) {
                case 'pending':
                    $this->db->where('status', 'disetujui KK');
                    break;
                case 'disetujui':
                    $this->db->where('status', 'disetujui sekretariat');
                    break;
                case 'ditolak':
                    $this->db->where('status', 'ditolak sekretariat');
                    break;
                case 'dekan_disetujui':
                    $this->db->where('status', 'disetujui dekan');
                    break;
                case 'dekan_ditolak':
                    $this->db->where('status', 'ditolak dekan');
                    break;
                default:
                    break;
            }
        }

        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // Statistik untuk card (dengan filter bulan)
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        // Pending count (disetujui KK)
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['pending_count'] = $this->db->where('status', 'disetujui KK')
                                         ->count_all_results('surat');

        // Disetujui oleh sekretariat
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['approved_count'] = $this->db->where('status', 'disetujui sekretariat')
                                          ->count_all_results('surat');

        // Ditolak oleh sekretariat
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['rejected_count'] = $this->db->where_in('status', ['ditolak sekretariat', 'ditolak KK'])
                                          ->count_all_results('surat');

        // Grafik data - dengan dukungan filter bulan
        $total     = array_fill(0, 12, 0);
        $pending   = array_fill(0, 12, 0);
        $approved  = array_fill(0, 12, 0);
        $rejected  = array_fill(0, 12, 0);

        if ($bulan === 'all') {
            // Jika semua bulan, ambil data 12 bulan
            for ($i = 1; $i <= 12; $i++) {
                $total[$i-1] = $this->countByMonthYear($i, $tahun);
                $pending[$i-1] = $this->countPendingByMonthYear($i, $tahun);
                $approved[$i-1] = $this->countApprovedByMonthYear($i, $tahun);
                $rejected[$i-1] = $this->countRejectedByMonthYear($i, $tahun);
            }
        } else {
            // Jika filter bulan spesifik, isi hanya bulan tersebut
            $bulan_int = (int)$bulan;
            for ($i = 1; $i <= 12; $i++) {
                if ($i == $bulan_int) {
                    $total[$i-1] = $this->countByMonthYear($i, $tahun);
                    $pending[$i-1] = $this->countPendingByMonthYear($i, $tahun);
                    $approved[$i-1] = $this->countApprovedByMonthYear($i, $tahun);
                    $rejected[$i-1] = $this->countRejectedByMonthYear($i, $tahun);
                } else {
                    $total[$i-1] = 0;
                    $pending[$i-1] = 0;
                    $approved[$i-1] = 0;
                    $rejected[$i-1] = 0;
                }
            }
        }

        $data['chart_total']    = $total;
        $data['chart_approved'] = $approved;
        $data['chart_rejected'] = $rejected;

        $this->load->view('sekretariat/dashboard', $data);
    }

    /* ================================
       HELPER FUNCTIONS UNTUK COUNT DATA PER BULAN
    ================================= */
    private function countByMonthYear($month, $year)
    {
        $this->db->where('YEAR(created_at)', $year);
        $this->db->where('MONTH(created_at)', $month);
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        return $this->db->count_all_results('surat');
    }

    private function countPendingByMonthYear($month, $year)
    {
        $this->db->where('YEAR(created_at)', $year);
        $this->db->where('MONTH(created_at)', $month);
        $this->db->where('status', 'disetujui KK');
        return $this->db->count_all_results('surat');
    }

    private function countApprovedByMonthYear($month, $year)
    {
        $this->db->where('YEAR(created_at)', $year);
        $this->db->where('MONTH(created_at)', $month);
        $this->db->where('status', 'disetujui sekretariat');
        return $this->db->count_all_results('surat');
    }

    private function countRejectedByMonthYear($month, $year)
    {
        $this->db->where('YEAR(created_at)', $year);
        $this->db->where('MONTH(created_at)', $month);
        $this->db->where('status', 'ditolak sekretariat');
        return $this->db->count_all_results('surat');
    }

    /* ================================
    PENDING (Disetujui KK) - DIPERBAIKI DENGAN FILTER BULAN
    ================================= */
    public function pending() {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $search = $this->input->get('search');
        
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['current_page'] = 'pending';

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
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

        // Statistik (dengan filter bulan)
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['pending_count'] = $this->db->where('status', 'disetujui KK')
                                         ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['approved_count'] = $this->db->where('status', 'disetujui sekretariat')
                                          ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['rejected_count'] = $this->db->where('status', 'ditolak sekretariat')
                                          ->count_all_results('surat');

        $this->load->view('sekretariat/halaman_pending', $data);
    }

    /* ================================
    DISETUJUI SEKRETARIAT - DIPERBAIKI DENGAN FILTER BULAN
    ================================= */
    public function disetujui() {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $search = $this->input->get('search');

        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['current_page'] = 'disetujui';

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where('status', 'disetujui sekretariat');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }

        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // Statistik (dengan filter bulan)
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['pending_count'] = $this->db->where('status', 'disetujui KK')
                                         ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['approved_count'] = $this->db->where('status', 'disetujui sekretariat')
                                          ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['rejected_count'] = $this->db->where('status', 'ditolak sekretariat')
                                          ->count_all_results('surat');

        $this->load->view('sekretariat/halaman_disetujui', $data);
    }

    /* ================================
    DITOLAK SEKRETARIAT - DIPERBAIKI DENGAN FILTER BULAN
    ================================= */
    public function ditolak() {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $search = $this->input->get('search');

        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['current_page'] = 'ditolak';

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where('status', 'ditolak sekretariat');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }

        $this->db->order_by("created_at", "DESC");
        $data['pengajuan_ditolak'] = $this->db->get("surat")->result();

        // Statistik (dengan filter bulan)
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['pending_count'] = $this->db->where('status', 'disetujui KK')
                                         ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['approved_count'] = $this->db->where('status', 'disetujui sekretariat')
                                          ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['rejected_count'] = $this->db->where('status', 'ditolak sekretariat')
                                          ->count_all_results('surat');

        $this->load->view('sekretariat/halaman_ditolak', $data);
    }

    /* ================================
    DISETUJUI DEKAN - DIPERBAIKI DENGAN FILTER BULAN
    ================================= */
    public function disetujui_dekan() {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $search = $this->input->get('search');

        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['current_page'] = 'disetujui_dekan';

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
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

        // Statistik (dengan filter bulan)
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['pending_count'] = $this->db->where('status', 'disetujui KK')
                                         ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['approved_count'] = $this->db->where('status', 'disetujui sekretariat')
                                          ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['rejected_count'] = $this->db->where('status', 'ditolak sekretariat')
                                          ->count_all_results('surat');

        $this->load->view('sekretariat/halaman_disetujui_dekan', $data);
    }

    /* ================================
    DITOLAK DEKAN - DIPERBAIKI DENGAN FILTER BULAN
    ================================= */
    public function ditolak_dekan() {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $search = $this->input->get('search');

        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['current_page'] = 'ditolak_dekan';

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where('status', 'ditolak dekan');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }

        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // Statistik (dengan filter bulan)
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['pending_count'] = $this->db->where('status', 'disetujui KK')
                                         ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['approved_count'] = $this->db->where('status', 'disetujui sekretariat')
                                          ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['rejected_count'] = $this->db->where('status', 'ditolak sekretariat')
                                          ->count_all_results('surat');

        $this->load->view('sekretariat/halaman_ditolak_dekan', $data);
    }

    /* ================================
    TOTAL SEMUA PENGAJUAN - DIPERBAIKI DENGAN FILTER BULAN
    ================================= */
    public function semua() {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $search = $this->input->get('search');
        $status = $this->input->get('status');
        
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['current_page'] = 'semua';

        // Ambil semua data yang relevan untuk sekretariat
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);

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
                    $this->db->where('status', 'disetujui KK');
                    break;
                case 'approved':
                    $this->db->where('status', 'disetujui sekretariat');
                    break;
                case 'rejected':
                    $this->db->where('status', 'ditolak sekretariat');
                    break;
                case 'dekan_approved':
                    $this->db->where('status', 'disetujui dekan');
                    break;
                case 'dekan_rejected':
                    $this->db->where('status', 'ditolak dekan');
                    break;
            }
        }

        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // Statistik (dengan filter bulan)
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        
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
                    $this->db->where('status', 'disetujui KK');
                    break;
                case 'approved':
                    $this->db->where('status', 'disetujui sekretariat');
                    break;
                case 'rejected':
                    $this->db->where('status', 'ditolak sekretariat');
                    break;
                case 'dekan_approved':
                    $this->db->where('status', 'disetujui dekan');
                    break;
                case 'dekan_rejected':
                    $this->db->where('status', 'ditolak dekan');
                    break;
            }
        }
        
        $data['total_surat'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['pending_count'] = $this->db->where('status', 'disetujui KK')
                                         ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['approved_count'] = $this->db->where('status', 'disetujui sekretariat')
                                          ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['rejected_count'] = $this->db->where('status', 'ditolak sekretariat')
                                          ->count_all_results('surat');

        $this->load->view('sekretariat/halaman_total', $data);
    }

    /* ================================
    GET DETAIL PENGAJUAN (AJAX) - DIPERBAIKI SEPERTI DEKAN DENGAN PROGRESS BAR
    ================================= */
    public function getDetailPengajuan($id)
    {
        $this->db->where('id', $id);
        $pengajuan = $this->db->get('surat')->row();
        
        if ($pengajuan) {
            // Ambil data dosen
            $dosen_data = $this->get_dosen_data_from_nip_fixed($pengajuan->nip);
            
            // Ambil progress timeline yang lengkap
            $progress_timeline = $this->getProgressTimeline($id);
            
            // Ambil semua field yang berkaitan dengan periode
            $jenis_date = $pengajuan->jenis_date ?? null;
            $periode_kegiatan = $pengajuan->periode_kegiatan ?? null;
            $periode_value = $pengajuan->periode_value ?? null;
            $tanggal_kegiatan = $pengajuan->tanggal_kegiatan ?? null;
            $akhir_kegiatan = $pengajuan->akhir_kegiatan ?? null;
            
            // Tentukan nilai periode yang akan ditampilkan
            $periode_display = '-';
            
            if ($jenis_date === 'Custom') {
                // FORMAT CUSTOM: "30 Nov 2025 - 01 Des 2025"
                if ($tanggal_kegiatan && $akhir_kegiatan) {
                    // Format tanggal Indonesia
                    $bulan_indonesia = [
                        'Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Apr',
                        'May' => 'Mei', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Ags',
                        'Sep' => 'Sep', 'Oct' => 'Okt', 'Nov' => 'Nov', 'Dec' => 'Des'
                    ];
                    
                    $format_tanggal = function($date) use ($bulan_indonesia) {
                        $day = date('d', strtotime($date));
                        $month_en = date('M', strtotime($date));
                        $month_id = $bulan_indonesia[$month_en] ?? $month_en;
                        $year = date('Y', strtotime($date));
                        return $day . ' ' . $month_id . ' ' . $year;
                    };
                    
                    $start_formatted = $format_tanggal($tanggal_kegiatan);
                    $end_formatted = $format_tanggal($akhir_kegiatan);
                    $periode_display = $start_formatted . ' - ' . $end_formatted;
                } elseif ($tanggal_kegiatan) {
                    // Jika hanya ada tanggal mulai
                    $periode_display = date('d M Y', strtotime($tanggal_kegiatan));
                }
            } elseif ($jenis_date === 'Periode') {
                // Untuk jenis Periode, gunakan periode_kegiatan atau periode_value
                $periode_display = $periode_kegiatan ?: $periode_value ?: '-';
            }
            
            $response_data = array(
                'id' => $pengajuan->id,
                'nama_kegiatan' => $pengajuan->nama_kegiatan,
                'status' => $pengajuan->status,
                'jenis_pengajuan' => $pengajuan->jenis_pengajuan,
                'eviden' => $pengajuan->eviden,
                'dosen_data' => $dosen_data,
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
    FUNGSI UNTUK MENDAPATKAN PROGRESS TIMELINE - SEPERTI DI DEKAN
    ================================= */
    private function getProgressTimeline($id)
    {
        $this->db->where('id', $id);
        $surat = $this->db->get('surat')->row();
        
        if (!$surat) {
            return null;
        }
        
        $approval = json_decode($surat->approval_status, true) ?? [];
        
        // Default timeline structure untuk sekretariat
        $timeline = [
            'mengirim' => [
                'status' => 'completed',
                'timestamp' => $surat->created_at,
                'label' => 'Mengirim',
                'display_time' => $this->formatDisplayTime($surat->created_at)
            ],
            'kaprodi' => [
                'status' => 'pending',
                'timestamp' => null,
                'label' => 'Disetujui Kaprodi',
                'display_time' => '-'
            ],
            'sekretariat' => [
                'status' => 'pending', 
                'timestamp' => null,
                'label' => 'Disetujui Sekretariat',
                'display_time' => '-'
            ],
            'dekan' => [
                'status' => 'pending',
                'timestamp' => null,
                'label' => 'Disetujui Dekan',
                'display_time' => '-'
            ]
        ];
        
        // Update dari approval status
        foreach ($approval as $role => $data) {
            if (isset($timeline[$role])) {
                $status = 'pending';
                if (isset($data['status'])) {
                    if ($data['status'] == 'approved' || $data['status'] == 'completed') {
                        $status = 'completed';
                    } elseif ($data['status'] == 'rejected') {
                        $status = 'rejected';
                    }
                } else {
                    // Jika format lama (hanya timestamp)
                    $status = 'completed';
                }
                
                $timeline[$role]['status'] = $status;
                $timeline[$role]['timestamp'] = is_array($data) ? ($data['timestamp'] ?? null) : $data;
                $timeline[$role]['display_time'] = $timeline[$role]['timestamp'] ? 
                    $this->formatDisplayTime($timeline[$role]['timestamp']) : '-';
            }
        }
        
        // Auto-complete previous steps if current step is completed
        if ($timeline['sekretariat']['status'] == 'completed') {
            $timeline['kaprodi']['status'] = 'completed';
            
            // Set default timestamps if not set
            if (!$timeline['kaprodi']['timestamp']) {
                $timeline['kaprodi']['timestamp'] = date('Y-m-d H:i:s', strtotime($surat->created_at . ' +1 hour'));
                $timeline['kaprodi']['display_time'] = $this->formatDisplayTime($timeline['kaprodi']['timestamp']);
            }
        }
        
        if ($timeline['dekan']['status'] == 'completed') {
            $timeline['kaprodi']['status'] = 'completed';
            $timeline['sekretariat']['status'] = 'completed';
            
            // Set default timestamps if not set
            if (!$timeline['kaprodi']['timestamp']) {
                $timeline['kaprodi']['timestamp'] = date('Y-m-d H:i:s', strtotime($surat->created_at . ' +1 hour'));
                $timeline['kaprodi']['display_time'] = $this->formatDisplayTime($timeline['kaprodi']['timestamp']);
            }
            
            if (!$timeline['sekretariat']['timestamp']) {
                $timeline['sekretariat']['timestamp'] = date('Y-m-d H:i:s', strtotime($timeline['kaprodi']['timestamp'] . ' +1 hour'));
                $timeline['sekretariat']['display_time'] = $this->formatDisplayTime($timeline['sekretariat']['timestamp']);
            }
        }
        
        return $timeline;
    }

    /* ================================
    FORMAT DISPLAY TIME - SEPERTI DI DEKAN
    ================================= */
    private function formatDisplayTime($timestamp)
    {
        if (!$timestamp) return '-';
        
        $time = strtotime($timestamp);
        $now = time();
        $diff = $now - $time;
        
        if ($diff < 60) {
            return 'Baru saja';
        } elseif ($diff < 3600) {
            $minutes = floor($diff / 60);
            return $minutes . ' menit yang lalu';
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . ' jam yang lalu';
        } else {
            return date('d M Y H:i', $time);
        }
    }

    /* ================================
    FUNGSI AMBIL DATA DOSEN - SEPERTI DI DEKAN
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
        
        // Handle berbagai format NIP
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
        
        // Ambil data dosen dari tabel list_dosen
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
    APPROVE - DENGAN NOMOR SURAT & PROGRESS BAR
    ================================= */
    public function approve($id)
    {
        // Validasi nomor surat wajib diisi
        $nomor_surat = $this->input->post('nomor_surat');
        
        if (empty($nomor_surat)) {
            $this->session->set_flashdata('error', 'Nomor surat harus diisi!');
            $this->redirectToPreviousPage();
            return;
        }

        // Cek apakah nomor surat sudah digunakan
        $this->db->where('nomor_surat', $nomor_surat);
        $this->db->where('id !=', $id);
        $existing = $this->db->get('surat')->row();

        if ($existing) {
            $this->session->set_flashdata('error', 'Nomor surat sudah digunakan! Silakan gunakan nomor lain.');
            $this->redirectToPreviousPage();
            return;
        }

        // Ambil data surat
        $surat = $this->db->get_where('surat', ['id' => $id])->row();
        
        if (!$surat) {
            $this->session->set_flashdata('error', 'Data surat tidak ditemukan');
            $this->redirectToPreviousPage();
            return;
        }

        // Validasi status
        if ($surat->status !== 'disetujui KK') {
            $this->session->set_flashdata('error', 'Status pengajuan tidak valid untuk disetujui. Status saat ini: ' . $surat->status);
            $this->redirectToPreviousPage();
            return;
        }

        // Update approval status dengan format yang mendukung progress bar
        $approval = json_decode($surat->approval_status, true) ?? [];
        
        // Pastikan semua tahap sebelumnya ada
        if (!isset($approval['pengirim'])) {
            $approval['pengirim'] = date("Y-m-d H:i:s");
        }
        if (!isset($approval['kaprodi'])) {
            $approval['kaprodi'] = date("Y-m-d H:i:s", strtotime($surat->created_at . ' +1 hour'));
        }
        
        $approval['sekretariat'] = date("Y-m-d H:i:s");
        
        $update_data = [
            'status' => 'disetujui sekretariat',
            'approval_status' => json_encode($approval),
            'nomor_surat' => $nomor_surat,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->db->where('id', $id)->update('surat', $update_data);

        if ($result) {
            $this->session->set_flashdata('success', 'Surat berhasil disetujui dengan nomor: ' . $nomor_surat);
        } else {
            $this->session->set_flashdata('error', 'Gagal menyetujui surat.');
        }
        
        $this->redirectToPreviousPage();
    }
    
    /* ================================
    REJECT - DIPERBAIKI DENGAN PROGRESS BAR
    ================================= */
    public function reject($id)
    {
        $notes = $this->input->post('rejection_notes');
        if (empty($notes)) {
            $this->session->set_flashdata('error', 'Alasan penolakan harus diisi');
            $this->redirectToPreviousPage();
            return;
        }

        // Ambil data surat dari database
        $surat = $this->db->get_where('surat', ['id' => $id])->row();
        
        if (!$surat) {
            $this->session->set_flashdata('error', 'Data surat tidak ditemukan');
            $this->redirectToPreviousPage();
            return;
        }

        // Validasi status
        if ($surat->status !== 'disetujui KK') {
            $this->session->set_flashdata('error', 'Status pengajuan tidak valid untuk ditolak. Status saat ini: ' . $surat->status);
            $this->redirectToPreviousPage();
            return;
        }

        // Update approval status dengan format yang mendukung progress bar
        $approval = json_decode($surat->approval_status, true) ?? [];
        
        // Pastikan semua tahap sebelumnya ada
        if (!isset($approval['pengirim'])) {
            $approval['pengirim'] = date("Y-m-d H:i:s");
        }
        if (!isset($approval['kaprodi'])) {
            $approval['kaprodi'] = date("Y-m-d H:i:s", strtotime($surat->created_at . ' +1 hour'));
        }
        
        $approval['sekretariat'] = date("Y-m-d H:i:s");

        $update_data = [
            'status' => 'ditolak sekretariat',
            'approval_status' => json_encode($approval),
            'catatan_penolakan' => $notes,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->db->where('id', $id)->update('surat', $update_data);

        if ($result) {
            $this->session->set_flashdata('success', 'Surat berhasil ditolak.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menolak surat.');
        }
        
        $this->redirectToPreviousPage();
    }

    /* ================================
    HELPER FUNCTION UNTUK REDIRECT - SEPERTI DI DEKAN
    ================================= */
    private function redirectToPreviousPage()
    {
        $current_page = $this->input->get('from') ?? 'sekretariat';
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $search = $this->input->get('search');
        $status = $this->input->get('status');
        
        $query_params = 'tahun=' . $tahun . '&bulan=' . $bulan;
        if (!empty($search)) {
            $query_params .= '&search=' . urlencode($search);
        }
        if (!empty($status)) {
            $query_params .= '&status=' . $status;
        }
        
        switch($current_page) {
            case 'semua':
                redirect('sekretariat/semua?' . $query_params);
                break;
            case 'disetujui':
                redirect('sekretariat/disetujui?' . $query_params);
                break;
            case 'ditolak':
                redirect('sekretariat/ditolak?' . $query_params);
                break;
            case 'pending':
                redirect('sekretariat/pending?' . $query_params);
                break;
            case 'disetujui_dekan':
                redirect('sekretariat/disetujui_dekan?' . $query_params);
                break;
            case 'ditolak_dekan':
                redirect('sekretariat/ditolak_dekan?' . $query_params);
                break;
            default:
                redirect('sekretariat?' . $query_params);
        }
    }

    /* ================================
    REALTIME DASHBOARD COUNTER - DIPERBAIKI DENGAN FILTER BULAN
    ================================= */
    public function get_dashboard_counts() {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        $total = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where('status', 'disetujui KK');
        $pending = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where('status', 'disetujui sekretariat');
        $approved = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where('status', 'ditolak sekretariat');
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

    /* ================================
    FUNGSI DEBUG: Untuk troubleshooting
    ================================= */
    public function debug_dosen_data($surat_id = null)
    {
        if (!$surat_id) {
            $this->db->where('nip IS NOT NULL');
            $this->db->limit(1);
            $sample_surat = $this->db->get('surat')->row();
            $surat_id = $sample_surat ? $sample_surat->id : null;
        }
        
        echo "<h1>Debug Data Dosen - Sekretariat</h1>";
        
        if ($surat_id) {
            $this->db->where('id', $surat_id);
            $surat = $this->db->get('surat')->row();
            
            echo "<h2>Data Surat (ID: $surat_id)</h2>";
            echo "<pre>";
            print_r($surat);
            echo "</pre>";
            
            echo "<h2>Proses get_dosen_data_from_nip_fixed</h2>";
            $dosen_data = $this->get_dosen_data_from_nip_fixed($surat->nip);
            echo "<pre>";
            print_r($dosen_data);
            echo "</pre>";
            
            echo "<h2>Progress Timeline</h2>";
            $progress_timeline = $this->getProgressTimeline($surat_id);
            echo "<pre>";
            print_r($progress_timeline);
            echo "</pre>";
        }
        
        echo "<h2>Sample Data list_dosen (5 records)</h2>";
        $sample_dosen = $this->db->get('list_dosen', 5)->result();
        echo "<pre>";
        print_r($sample_dosen);
        echo "</pre>";
    }
    
    /* ================================
    TAMPILKAN SURAT PENGAJUAN DALAM MODAL - SEPERTI DI DEKAN
    ================================= */
    public function view_surat_pengajuan($id)
    {
        $this->db->where('id', $id);
        $data['surat'] = $this->db->get('surat')->row();
        
        if (!$data['surat']) {
            show_404();
            return;
        }
        
        // Ambil data dosen lengkap dari list_dosen
        $data['dosen_data'] = $this->get_dosen_data_from_nip_fixed($data['surat']->nip);
        
        // Load view surat_print2
        $this->load->view('surat_print2', $data);
    }
    
    /* ================================
    GET EVIDEN - UNTUK TOMBOL LIHAT EVIDEN (SEPERTI DI DEKAN)
    ================================= */
    public function getEviden($id)
    {
        $this->db->where('id', $id);
        $surat = $this->db->get('surat')->row();
        
        if ($surat && !empty($surat->eviden)) {
            // Periksa apakah file exist
            $file_path = FCPATH . $surat->eviden;
            
            if (file_exists($file_path)) {
                echo json_encode([
                    'success' => true,
                    'eviden' => $surat->eviden,
                    'nama_kegiatan' => $surat->nama_kegiatan
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'File eviden tidak ditemukan di server'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Tidak ada eviden untuk pengajuan ini'
            ]);
        }
    }

    // ========================================================================
    // FUNGSI-FUNGSI LAIN YANG TIDAK DIUBAH (KARENA SUDAH SESUAI)
    // ========================================================================

    /* ================================
    BULK APPROVE - MULTI APPROVE
    ================================= */
    public function bulk_approve()
    {
        // Check jika request adalah POST
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $ids = $this->input->post('ids');
            $nomor_surat_data = $this->input->post('nomor_surat');
            
            // Validasi input
            if (empty($ids)) {
                $this->session->set_flashdata('error', 'Tidak ada pengajuan yang dipilih.');
                redirect('sekretariat/pending');
            }
            
            // Convert string IDs to array
            $id_array = explode(',', $ids);
            
            $success_count = 0;
            $error_count = 0;
            $error_messages = [];
            
            foreach ($id_array as $id) {
                $id = trim($id);
                
                // Validasi nomor surat untuk setiap item
                if (!isset($nomor_surat_data[$id]) || empty($nomor_surat_data[$id])) {
                    $error_count++;
                    $error_messages[] = "Nomor surat harus diisi untuk ID: $id";
                    continue;
                }
                
                $nomor_surat = $nomor_surat_data[$id];
                
                // Cek apakah nomor surat sudah digunakan (kecuali untuk surat yang sama)
                $this->db->where('nomor_surat', $nomor_surat);
                $this->db->where('id !=', $id);
                $existing = $this->db->get('surat')->row();
                
                if ($existing) {
                    $error_count++;
                    $error_messages[] = "Nomor surat '$nomor_surat' sudah digunakan (ID: $id)";
                    continue;
                }
                
                // Ambil data surat
                $surat = $this->db->get_where('surat', ['id' => $id])->row();
                
                if (!$surat) {
                    $error_count++;
                    $error_messages[] = "Data tidak ditemukan (ID: $id)";
                    continue;
                }
                
                // Validasi status
                if ($surat->status !== 'disetujui KK') {
                    $error_count++;
                    $error_messages[] = "Status tidak valid untuk ID: $id (Status: $surat->status)";
                    continue;
                }
                
                // Update approval status dengan format yang mendukung progress bar
                $approval = json_decode($surat->approval_status, true) ?? [];
                
                // Pastikan semua tahap sebelumnya ada
                if (!isset($approval['pengirim'])) {
                    $approval['pengirim'] = date("Y-m-d H:i:s");
                }
                if (!isset($approval['kaprodi'])) {
                    $approval['kaprodi'] = date("Y-m-d H:i:s", strtotime($surat->created_at . ' +1 hour'));
                }
                
                $approval['sekretariat'] = date("Y-m-d H:i:s");
                
                // Update database
                $update_data = [
                    'status' => 'disetujui sekretariat',
                    'approval_status' => json_encode($approval),
                    'nomor_surat' => $nomor_surat,
                    'updated_at' => date('Y-m-d H:i:s')
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
                $message = "Berhasil menyetujui $success_count pengajuan.";
                if ($error_count > 0) {
                    $message .= " $error_count pengajuan gagal.";
                }
                $this->session->set_flashdata('success', $message);
            } else {
                $this->session->set_flashdata('error', "Gagal menyetujui semua pengajuan: " . implode(', ', $error_messages));
            }
            
            redirect('sekretariat/pending');
        } else {
            // Jika bukan POST request, redirect ke halaman pending
            redirect('sekretariat/pending');
        }
    }

    /* ================================
    BULK REJECT - MULTI REJECT
    ================================= */
    public function bulk_reject()
    {
        // Check jika request adalah POST
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $ids = $this->input->post('ids');
            $rejection_notes_data = $this->input->post('rejection_notes');
            
            // Validasi input
            if (empty($ids)) {
                $this->session->set_flashdata('error', 'Tidak ada pengajuan yang dipilih.');
                redirect('sekretariat/pending');
            }
            
            // Convert string IDs to array
            $id_array = explode(',', $ids);
            
            $success_count = 0;
            $error_count = 0;
            $error_messages = [];
            
            foreach ($id_array as $id) {
                $id = trim($id);
                
                // Validasi rejection notes untuk setiap item
                if (!isset($rejection_notes_data[$id]) || empty($rejection_notes_data[$id])) {
                    $error_count++;
                    $error_messages[] = "Alasan penolakan harus diisi untuk ID: $id";
                    continue;
                }
                
                $rejection_notes = $rejection_notes_data[$id];
                
                // Ambil data surat
                $surat = $this->db->get_where('surat', ['id' => $id])->row();
                
                if (!$surat) {
                    $error_count++;
                    $error_messages[] = "Data tidak ditemukan (ID: $id)";
                    continue;
                }
                
                // Validasi status
                if ($surat->status !== 'disetujui KK') {
                    $error_count++;
                    $error_messages[] = "Status tidak valid untuk ID: $id (Status: $surat->status)";
                    continue;
                }
                
                // Update approval status dengan format yang mendukung progress bar
                $approval = json_decode($surat->approval_status, true) ?? [];
                
                // Pastikan semua tahap sebelumnya ada
                if (!isset($approval['pengirim'])) {
                    $approval['pengirim'] = date("Y-m-d H:i:s");
                }
                if (!isset($approval['kaprodi'])) {
                    $approval['kaprodi'] = date("Y-m-d H:i:s", strtotime($surat->created_at . ' +1 hour'));
                }
                
                $approval['sekretariat'] = date("Y-m-d H:i:s");

                // Update database
                $update_data = [
                    'status' => 'ditolak sekretariat',
                    'approval_status' => json_encode($approval),
                    'catatan_penolakan' => $rejection_notes,
                    'updated_at' => date('Y-m-d H:i:s')
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
                $message = "Berhasil menolak $success_count pengajuan.";
                if ($error_count > 0) {
                    $message .= " $error_count pengajuan gagal.";
                }
                $this->session->set_flashdata('success', $message);
            } else {
                $this->session->set_flashdata('error', "Gagal menolak semua pengajuan: " . implode(', ', $error_messages));
            }
            
            redirect('sekretariat/pending');
        } else {
            // Jika bukan POST request, redirect ke halaman pending
            redirect('sekretariat/pending');
        }
    }

    /* ================================
    EDIT SURAT - HANYA UNTUK DITOLAK DEKAN
    ================================= */
    public function edit_surat($id)
    {
        $surat = $this->Surat_model->get_by_id($id);

        if (!$surat) {
            show_404();
            return;
        }

        // ========================================
        // 🔥 CEK APAKAH STATUS DITOLAK DEKAN
        // ========================================
        $status_lower = strtolower($surat->status);
        
        if ($status_lower !== 'ditolak dekan') {
            $this->session->set_flashdata('error', '⚠️ Edit hanya dapat dilakukan untuk surat yang ditolak Dekan! Status surat ini: ' . $surat->status);
            redirect('sekretariat');
            return;
        }

        $data['surat'] = (array)$surat;
        
        // Get dosen data untuk ditampilkan
        $data['dosen_data'] = $this->get_dosen_data_from_nip_fixed($surat->nip);
        
        // Process eviden data
        $eviden_raw = $surat->eviden ?? "[]";
        
        if (is_string($eviden_raw)) {
            $eviden_decoded = json_decode($eviden_raw, true);
            $data['eviden'] = is_array($eviden_decoded) ? $eviden_decoded : [];
        } else {
            $data['eviden'] = is_array($eviden_raw) ? $eviden_raw : [];
        }

        // Jika bukan POST request, tampilkan form edit
        if (!$this->input->post()) {
            $this->load->view('sekretariat/edit_surat', $data);
            return;
        }

        // Jika ada POST data, proses update melalui method update_surat
        $this->update_surat($id);
    }

    /* ================================
    UPDATE SURAT - PROSES UPDATE DATA (HANYA UNTUK DITOLAK DEKAN)
    ================================= */
    public function update_surat($id = null)
    {
        // Jika $id tidak ada, ambil dari URL segment
        if (!$id) {
            $id = $this->uri->segment(3);
        }

        $surat = $this->Surat_model->get_by_id($id);

        if (!$surat) {
            show_404();
            return;
        }

        // ========================================
        // 🔥 VALIDASI: HANYA UNTUK DITOLAK DEKAN
        // ========================================
        $status_lower = strtolower($surat->status);
        
        if ($status_lower !== 'ditolak dekan') {
            $this->session->set_flashdata('error', '⚠️ Update hanya dapat dilakukan untuk surat yang ditolak Dekan!');
            redirect('sekretariat');
            return;
        }

        if (!$this->input->post()) {
            redirect('sekretariat/edit_surat/' . $id);
            return;
        }

        $post = $this->input->post();

        // Normalize data
        foreach ($post as $k => $v) {
            if (is_array($v)) {
                $post[$k] = array_values(array_filter($v, function($x) {
                    return trim($x) !== "";
                }));
            } else {
                $post[$k] = ($v === "" ? "-" : $v);
            }
        }

        // ========================================
        // 🔥 PROSES EVIDEN
        // ========================================
        $existing_eviden = json_decode($surat->eviden, true) ?: [];
        
        // Hapus file yang ditandai untuk dihapus
        $deleted_files = $post['delete_eviden'] ?? [];
        foreach ($deleted_files as $del_file) {
            if ($del_file && trim($del_file) !== '') {
                $existing_eviden = array_filter($existing_eviden, function($f) use ($del_file) {
                    return $f !== $del_file;
                });
                
                // Hapus file fisik jika bukan URL external
                if (!filter_var($del_file, FILTER_VALIDATE_URL)) {
                    $file_path = './uploads/eviden/' . $del_file;
                    if (file_exists($file_path)) {
                        @unlink($file_path);
                    }
                }
            }
        }
        
        // Upload file baru
        $new_files = [];
        if (!empty($_FILES['new_eviden']['name'][0])) {
            $upload_path = './uploads/eviden/';
            
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0755, true);
            }
            
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx|xls|xlsx';
            $config['max_size'] = 10240;
            $config['encrypt_name'] = TRUE;
            
            $this->load->library('upload', $config);
            
            $files_count = count($_FILES['new_eviden']['name']);
            
            for ($i = 0; $i < $files_count; $i++) {
                if (!empty($_FILES['new_eviden']['name'][$i])) {
                    $_FILES['file']['name'] = $_FILES['new_eviden']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['new_eviden']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['new_eviden']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['new_eviden']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['new_eviden']['size'][$i];
                    
                    if ($this->upload->do_upload('file')) {
                        $upload_data = $this->upload->data();
                        $new_files[] = $upload_data['file_name'];
                    } else {
                        log_message('error', 'Upload failed: ' . $this->upload->display_errors());
                    }
                }
            }
        }
        
        // Gabungkan eviden lama dan baru
        $final_eviden = array_merge(array_values($existing_eviden), $new_files);
        $update_eviden = json_encode($final_eviden);

        // ========================================
        // 🔥 PREPARE DATA UPDATE
        // ========================================
        $update = [
            'nomor_surat' => $post['nomor_surat'] ?? $surat->nomor_surat,
            'nama_kegiatan' => $post['nama_kegiatan'] ?? $surat->nama_kegiatan,
            'jenis_date' => $post['jenis_date'] ?? $surat->jenis_date,
            'tanggal_kegiatan' => $this->safe_date($post['tanggal_kegiatan'] ?? null),
            'akhir_kegiatan' => $this->safe_date($post['akhir_kegiatan'] ?? null),
            'periode_penugasan' => $this->safe_date($post['periode_penugasan'] ?? null),
            'akhir_periode_penugasan' => $this->safe_date($post['akhir_periode_penugasan'] ?? null),
            'periode_value' => $post['periode_value'] ?? $surat->periode_value,
            'tempat_kegiatan' => $post['tempat_kegiatan'] ?? $surat->tempat_kegiatan,
            'penyelenggara' => $post['penyelenggara'] ?? $surat->penyelenggara,
            'jenis_pengajuan' => $post['jenis_pengajuan'] ?? $surat->jenis_pengajuan,
            'lingkup_penugasan' => $post['lingkup_penugasan'] ?? $surat->lingkup_penugasan,
            'jenis_penugasan_perorangan' => $post['jenis_penugasan_perorangan'] ?? $surat->jenis_penugasan_perorangan,
            'penugasan_lainnya_perorangan' => $post['penugasan_lainnya_perorangan'] ?? $surat->penugasan_lainnya_perorangan,
            'jenis_penugasan_kelompok' => $post['jenis_penugasan_kelompok'] ?? $surat->jenis_penugasan_kelompok,
            'penugasan_lainnya_kelompok' => $post['penugasan_lainnya_kelompok'] ?? $surat->penugasan_lainnya_kelompok,
            'nip' => isset($post['nip']) ? json_encode($post['nip']) : $surat->nip,
            'eviden' => $update_eviden
        ];

        // ========================================
        // 🔥 UPDATE STATUS & APPROVAL (KIRIM KE DEKAN ULANG)
        // ========================================
        
        // Ambil approval_status saat ini
        $approval_status = json_decode($surat->approval_status, true);
        if (!is_array($approval_status)) {
            $approval_status = [
                'kk' => null,
                'sekretariat' => null,
                'dekan' => null
            ];
        }
        
        // PERBAIKAN: Tetap pertahankan approval KK dan Sekretariat yang sudah ada
        // Reset hanya approval dekan (karena akan di-review ulang)
        $approval_status['dekan'] = null;
        
        // Update status ke "disetujui sekretariat" (untuk dikirim ke dekan)
        $update['status'] = 'disetujui sekretariat';
        $update['approval_status'] = json_encode($approval_status);
        
        // Hapus catatan penolakan karena ini pengajuan ulang
        $update['catatan_penolakan'] = null;
        
        // Update timestamp
        $update['updated_at'] = date('Y-m-d H:i:s');

        // ========================================
        // 🔥 EKSEKUSI UPDATE DATABASE
        // ========================================
        $result = $this->Surat_model->update_surat($id, $update);

        if ($result) {
            log_message('info', "Surat ID {$id} direvisi dan diajukan ulang ke Dekan oleh Sekretariat");
            
            $this->session->set_flashdata('success', "✅ Revisi berhasil disimpan! Pengajuan telah dikirim kembali ke <strong>Dekan</strong> untuk persetujuan ulang.");
        } else {
            $this->session->set_flashdata('error', '❌ Gagal menyimpan revisi. Silakan coba lagi.');
        }
        
        redirect('sekretariat');
    }

    /* ================================
    HELPER: SAFE DATE
    ================================= */
    private function safe_date($val)
    {
        if (!$val || trim($val) === "" || $val === "-") return "-";
        $ts = strtotime($val);
        return $ts ? date('Y-m-d', $ts) : "";
    }

    /* ================================
    GET DOSEN DETAIL UNTUK AUTOCOMPLETE
    ================================= */
    private function get_dosen_detail_for_autocomplete($surat)
    {
        $nip_list = is_array($surat->nip) ? $surat->nip : json_decode($surat->nip, true);
        
        if (!$nip_list) return [];
        
        $dosen_data = [];
        
        foreach ($nip_list as $nip) {
            if (!empty($nip) && $nip !== '-') {
                $this->db->where('nip', $nip);
                $dosen = $this->db->get('list_dosen')->row();
                
                if ($dosen) {
                    $dosen_data[] = [
                        'nip' => $dosen->nip,
                        'nama_dosen' => $dosen->nama_dosen,
                        'jabatan' => $dosen->jabatan,
                        'divisi' => $dosen->divisi
                    ];
                } else {
                    $dosen_data[] = [
                        'nip' => $nip,
                        'nama_dosen' => '',
                        'jabatan' => '',
                        'divisi' => ''
                    ];
                }
            }
        }
        
        return $dosen_data;
    }

    /* ================================
    CETAK SURAT UNTUK SEKRETARIAT
    ================================= */
    public function cetak($id)
    {
        $surat = $this->Surat_model->get_by_id($id);
        
        if (!$surat) {
            show_404();
            return;
        }

        // Validasi: Hanya bisa cetak jika sudah disetujui sekretariat atau dekan
        $allowed_status = ['disetujui sekretariat', 'disetujui dekan'];
        if (!in_array(strtolower($surat->status), array_map('strtolower', $allowed_status))) {
            $this->session->set_flashdata('error', 'Surat belum disetujui untuk dicetak.');
            redirect('sekretariat');
            return;
        }

        $data['surat'] = $surat;
        
        // Get dosen data
        $data['dosen_data'] = $this->get_dosen_data_from_nip_fixed($surat->nip);
        
        $this->load->view('sekretariat/cetak_surat', $data);
    }

    /* ================================
    DOWNLOAD PDF UNTUK SEKRETARIAT
    ================================= */
    public function download_pdf($id)
    {
        $surat = $this->Surat_model->get_by_id($id);
        
        if (!$surat) {
            show_404();
            return;
        }

        // Validasi: Hanya bisa download jika sudah disetujui sekretariat atau dekan
        $allowed_status = ['disetujui sekretariat', 'disetujui dekan'];
        if (!in_array(strtolower($surat->status), array_map('strtolower', $allowed_status))) {
            $this->session->set_flashdata('error', 'Surat belum disetujui untuk didownload.');
            redirect('sekretariat');
            return;
        }

        $this->load->library('pdf');
        
        $data['surat'] = $surat;
        $data['dosen_data'] = $this->get_dosen_data_from_nip_fixed($surat->nip);
        
        $html = $this->load->view('sekretariat/pdf_surat', $data, TRUE);
        
        $this->pdf->generate($html, 'surat_tugas_' . $id . '.pdf', TRUE);
    }

    /* ================================
    VALIDASI QR CODE UNTUK SEKRETARIAT
    ================================= */
    public function validasi($id)
    {
        $surat = $this->Surat_model->get_by_id($id);
        
        if (!$surat) {
            $data['found'] = false;
        } else {
            $data['found'] = true;
            $data['surat'] = $surat;
            $data['dosen_data'] = $this->get_dosen_data_from_nip_fixed($surat->nip);
        }

        $data['role'] = 'sekretariat';
        
        $this->load->view('sekretariat/validasi_surat', $data);
    }

    /* ================================
    GET STATUS APPROVAL UNTUK SEKRETARIAT
    ================================= */
    public function get_status($surat_id)
    {
        header('Content-Type: application/json');
        
        $this->db->select('id, status, created_at, catatan_penolakan, approval_status');
        $this->db->where('id', $surat_id);
        $query = $this->db->get('surat');

        if ($query->num_rows() == 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Data surat tidak ditemukan'
            ]);
            return;
        }

        $surat = $query->row();

        // Decode JSON approval_status
        $approval = json_decode($surat->approval_status, true);
        if (!is_array($approval)) $approval = [];

        // Get waktu persetujuan
        $getTime = function($val) {
            if (!$val) return null;

            if (is_string($val)) return $val; // approved → datetime string
            if (is_array($val) && isset($val['waktu'])) return $val['waktu']; // rejected → ambil waktu penolakan

            return null;
        };

        $kk  = $getTime($approval['kk'] ?? null);
        $sek = $getTime($approval['sekretariat'] ?? null);
        $dek = $getTime($approval['dekan'] ?? null);

        // Status untuk sekretariat
        $status = strtolower(trim($surat->status ?? 'pengajuan'));
        
        $steps = [];
        $progress_percentage = 0;

        // Step pertama: Mengirim
        $steps[] = [
            'step_name' => 'Mengirim',
            'status' => 'completed',
            'date' => date('d M Y', strtotime($surat->created_at)),
            'label' => 'Terkirim'
        ];

        // Tentukan steps berdasarkan status
        switch ($status) {
            case 'disetujui kk':
                $steps[] = [
                    'step_name' => 'Disetujui Kaprodi',
                    'status' => 'completed',
                    'date' => ($kk) ? date('d M Y', strtotime($kk)) : '-',
                    'label' => 'Disetujui'
                ];
                $steps[] = [
                    'step_name' => 'Menunggu Sekretariat',
                    'status' => 'in-progress',
                    'date' => '-',
                    'label' => 'Dalam Proses'
                ];
                $steps[] = [
                    'step_name' => 'Persetujuan Dekan',
                    'status' => 'pending',
                    'date' => '-',
                    'label' => 'Menunggu'
                ];
                $progress_percentage = 65;
                break;

            case 'disetujui sekretariat':
                $steps[] = [
                    'step_name' => 'Disetujui Kaprodi',
                    'status' => 'completed',
                    'date' => ($kk) ? date('d M Y', strtotime($kk)) : '-',
                    'label' => 'Disetujui'
                ];
                $steps[] = [
                    'step_name' => 'Disetujui Sekretariat',
                    'status' => 'completed',
                    'date' => ($sek) ? date('d M Y', strtotime($sek)) : '-',
                    'label' => 'Disetujui'
                ];
                $steps[] = [
                    'step_name' => 'Menunggu Dekan',
                    'status' => 'in-progress',
                    'date' => '-',
                    'label' => 'Dalam Proses'
                ];
                $progress_percentage = 95;
                break;

            case 'disetujui dekan':
                $steps[] = [
                    'step_name' => 'Disetujui Kaprodi',
                    'status' => 'completed',
                    'date' => ($kk) ? date('d M Y', strtotime($kk)) : '-',
                    'label' => 'Disetujui'
                ];
                $steps[] = [
                    'step_name' => 'Disetujui Sekretariat',
                    'status' => 'completed',
                    'date' => ($sek) ? date('d M Y', strtotime($sek)) : '-',
                    'label' => 'Disetujui'
                ];
                $steps[] = [
                    'step_name' => 'Disetujui Dekan',
                    'status' => 'completed',
                    'date' => ($dek) ? date('d M Y', strtotime($dek)) : '-',
                    'label' => 'Disetujui'
                ];
                $progress_percentage = 100;
                break;

            case 'ditolak sekretariat':
                $steps[] = [
                    'step_name' => 'Disetujui Kaprodi',
                    'status' => 'completed',
                    'date' => ($kk) ? date('d M Y', strtotime($kk)) : '-',
                    'label' => 'Disetujui'
                ];
                $steps[] = [
                    'step_name' => 'Ditolak Sekretariat',
                    'status' => 'rejected',
                    'date' => ($sek) ? date('d M Y', strtotime($sek)) : '-',
                    'label' => 'Ditolak',
                    'catatan_penolakan' => $surat->catatan_penolakan
                ];
                $steps[] = [
                    'step_name' => 'Persetujuan Dekan',
                    'status' => 'pending',
                    'date' => '-',
                    'label' => 'Dibatalkan'
                ];
                $progress_percentage = 65;
                break;

            case 'ditolak dekan':
                $steps[] = [
                    'step_name' => 'Disetujui Kaprodi',
                    'status' => 'completed',
                    'date' => ($kk) ? date('d M Y', strtotime($kk)) : '-',
                    'label' => 'Disetujui'
                ];
                $steps[] = [
                    'step_name' => 'Disetujui Sekretariat',
                    'status' => 'completed',
                    'date' => ($sek) ? date('d M Y', strtotime($sek)) : '-',
                    'label' => 'Disetujui'
                ];
                $steps[] = [
                    'step_name' => 'Ditolak Dekan',
                    'status' => 'rejected',
                    'date' => ($dek) ? date('d M Y', strtotime($dek)) : '-',
                    'label' => 'Ditolak',
                    'catatan_penolakan' => $surat->catatan_penolakan
                ];
                $progress_percentage = 100;
                break;

            default:
                $steps[] = [
                    'step_name' => 'Persetujuan Kaprodi',
                    'status' => 'pending',
                    'date' => '-',
                    'label' => 'Menunggu'
                ];
                $steps[] = [
                    'step_name' => 'Persetujuan Sekretariat',
                    'status' => 'pending',
                    'date' => '-',
                    'label' => 'Menunggu'
                ];
                $steps[] = [
                    'step_name' => 'Persetujuan Dekan',
                    'status' => 'pending',
                    'date' => '-',
                    'label' => 'Menunggu'
                ];
                $progress_percentage = 25;
                break;
        }

        echo json_encode([
            'success' => true,
            'data' => [
                'steps' => $steps,
                'current_status' => $status,
                'status_raw' => $surat->status,
                'progress_percentage' => $progress_percentage,
                'catatan_penolakan' => $surat->catatan_penolakan,
                'durasi' => [
                    'durasi_1' => ($kk) ? $this->bedaWaktu($surat->created_at, $kk) : '-',
                    'durasi_2' => ($kk && $sek) ? $this->bedaWaktu($kk, $sek) : '-',
                    'durasi_3' => ($sek && $dek) ? $this->bedaWaktu($sek, $dek) : '-',
                ]
            ]
        ]);
    }

    /* ================================
    HELPER: BEDA WAKTU
    ================================= */
    private function bedaWaktu($start, $end)
    {
        if (!$start || !$end) return '-';

        try {
            $mulai = new DateTime($start);
            $selesai = new DateTime($end);
        } catch (Exception $e) {
            return '-';
        }

        $diff = $mulai->diff($selesai);

        return $diff->d . " hari " . $diff->h . " jam ";
    }

    /* ================================
    AUTOCOMPLETE NIP
    ================================= */
    public function autocomplete_nip()
    {
        header('Content-Type: application/json');
        
        $query = $this->input->get('q');
        $field = $this->input->get('field');
        
        if (empty($query) || strlen($query) < 1) {
            echo json_encode([]);
            return;
        }
        
        $allowed_fields = ['nip', 'nama_dosen', 'jabatan', 'divisi'];
        if (!in_array($field, $allowed_fields)) {
            $field = 'nip';
        }
        
        try {
            $this->db->select('nip, nama_dosen, jabatan, divisi');
            $this->db->from('list_dosen');
            $this->db->like($field, $query);
            $this->db->limit(10);
            $this->db->order_by($field, 'ASC');
            
            $result = $this->db->get();
            
            if ($result->num_rows() > 0) {
                $data = $result->result_array();
                echo json_encode($data);
            } else {
                echo json_encode([]);
            }
            
        } catch (Exception $e) {
            log_message('error', 'Autocomplete error: ' . $e->getMessage());
            echo json_encode([]);
        }
    }
    public function set_disposisi()
{
    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data["id"];
    $disposisi = $data["disposisi"];
    $catatan = $data["catatan"] ?? "";

    $this->db->where("id", $id);
    $this->db->update("surat", [
        "disposisi_status" => $disposisi,
        "disposisi_catatan" => $catatan,
    ]);

    echo json_encode(["success" => true]);
}

}
