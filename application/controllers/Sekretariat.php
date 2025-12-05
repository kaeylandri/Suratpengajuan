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
    DASHBOARD - DENGAN FILTER JENIS PENUGASAN BARU
    ================================= */
    public function index($filter = 'all') {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $search = $this->input->get('search');
        $status_filter = $this->input->get('status');
        $lingkup_penugasan_filter = $this->input->get('lingkup_penugasan');
        $jenis_penugasan_filter = $this->input->get('jenis_penugasan'); // Filter baru
        
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['current_filter'] = $filter;
        $data['jenis_penugasan_filter'] = $jenis_penugasan_filter;

        // Surat yang relevan bagi sekretariat
        $this->db->where('YEAR(created_at)', $tahun);
        
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        
        $this->db->where_in("status", ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        
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

        // Filter lingkup penugasan
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }

        // Filter jenis penugasan baru
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);

        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // Statistik untuk card
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['total_surat'] = $this->db->count_all_results('surat');

        // Pending count
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['pending_count'] = $this->db->where('status', 'disetujui KK')
                                         ->count_all_results('surat');

        // Disetujui oleh sekretariat
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['approved_count'] = $this->db->where('status', 'disetujui sekretariat')
                                          ->count_all_results('surat');

        // Ditolak oleh sekretariat
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['rejected_count'] = $this->db->where_in('status', ['ditolak sekretariat', 'ditolak KK'])
                                          ->count_all_results('surat');

        // Grafik data
        $total     = array_fill(0, 12, 0);
        $pending   = array_fill(0, 12, 0);
        $approved  = array_fill(0, 12, 0);
        $rejected  = array_fill(0, 12, 0);

        if ($bulan === 'all') {
            for ($i = 1; $i <= 12; $i++) {
                $total[$i-1] = $this->countByMonthYear($i, $tahun, $lingkup_penugasan_filter, $jenis_penugasan_filter);
                $pending[$i-1] = $this->countPendingByMonthYear($i, $tahun, $lingkup_penugasan_filter, $jenis_penugasan_filter);
                $approved[$i-1] = $this->countApprovedByMonthYear($i, $tahun, $lingkup_penugasan_filter, $jenis_penugasan_filter);
                $rejected[$i-1] = $this->countRejectedByMonthYear($i, $tahun, $lingkup_penugasan_filter, $jenis_penugasan_filter);
            }
        } else {
            $bulan_int = (int)$bulan;
            for ($i = 1; $i <= 12; $i++) {
                if ($i == $bulan_int) {
                    $total[$i-1] = $this->countByMonthYear($i, $tahun, $lingkup_penugasan_filter, $jenis_penugasan_filter);
                    $pending[$i-1] = $this->countPendingByMonthYear($i, $tahun, $lingkup_penugasan_filter, $jenis_penugasan_filter);
                    $approved[$i-1] = $this->countApprovedByMonthYear($i, $tahun, $lingkup_penugasan_filter, $jenis_penugasan_filter);
                    $rejected[$i-1] = $this->countRejectedByMonthYear($i, $tahun, $lingkup_penugasan_filter, $jenis_penugasan_filter);
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
    private function countByMonthYear($month, $year, $lingkup_penugasan_filter = null, $jenis_penugasan_filter = null)
    {
        $this->db->where('YEAR(created_at)', $year);
        $this->db->where('MONTH(created_at)', $month);
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        return $this->db->count_all_results('surat');
    }

    private function countPendingByMonthYear($month, $year, $lingkup_penugasan_filter = null, $jenis_penugasan_filter = null)
    {
        $this->db->where('YEAR(created_at)', $year);
        $this->db->where('MONTH(created_at)', $month);
        $this->db->where('status', 'disetujui KK');
        
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        return $this->db->count_all_results('surat');
    }

    private function countApprovedByMonthYear($month, $year, $lingkup_penugasan_filter = null, $jenis_penugasan_filter = null)
    {
        $this->db->where('YEAR(created_at)', $year);
        $this->db->where('MONTH(created_at)', $month);
        $this->db->where('status', 'disetujui sekretariat');
        
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        return $this->db->count_all_results('surat');
    }

    private function countRejectedByMonthYear($month, $year, $lingkup_penugasan_filter = null, $jenis_penugasan_filter = null)
    {
        $this->db->where('YEAR(created_at)', $year);
        $this->db->where('MONTH(created_at)', $month);
        $this->db->where('status', 'ditolak sekretariat');
        
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        return $this->db->count_all_results('surat');
    }

    /* ================================
    FUNGSI BARU: FILTER JENIS PENUGASAN
    ================================= */
  private function applyJenisPenugasanFilter($jenis_penugasan_filter = null)
{
    if (!empty($jenis_penugasan_filter)) {
        if ($jenis_penugasan_filter === 'perorangan') {
            $this->db->where("(
                (`jenis_penugasan_perorangan` IS NOT NULL AND `jenis_penugasan_perorangan` != '' AND `jenis_penugasan_perorangan` != '-') AND
                (`jenis_penugasan_kelompok` IS NULL OR `jenis_penugasan_kelompok` = '' OR `jenis_penugasan_kelompok` = '-')
            ) OR (
                (`penugasan_lainnya_perorangan` IS NOT NULL AND `penugasan_lainnya_perorangan` != '' AND `penugasan_lainnya_perorangan` != '-') AND
                (`penugasan_lainnya_kelompok` IS NULL OR `penugasan_lainnya_kelompok` = '' OR `penugasan_lainnya_kelompok` = '-')
            )");
            
        } elseif ($jenis_penugasan_filter === 'kelompok') {
            $this->db->where("(
                (`jenis_penugasan_kelompok` IS NOT NULL AND `jenis_penugasan_kelompok` != '' AND `jenis_penugasan_kelompok` != '-') AND
                (`jenis_penugasan_perorangan` IS NULL OR `jenis_penugasan_perorangan` = '' OR `jenis_penugasan_perorangan` = '-')
            ) OR (
                (`penugasan_lainnya_kelompok` IS NOT NULL AND `penugasan_lainnya_kelompok` != '' AND `penugasan_lainnya_kelompok` != '-') AND
                (`penugasan_lainnya_perorangan` IS NULL OR `penugasan_lainnya_perorangan` = '' OR `penugasan_lainnya_perorangan` = '-')
            )");
            
        } elseif ($jenis_penugasan_filter === 'lainnya') {
            $this->db->where("(
                (`penugasan_lainnya_perorangan` IS NOT NULL AND `penugasan_lainnya_perorangan` != '' AND `penugasan_lainnya_perorangan` != '-') OR
                (`penugasan_lainnya_kelompok` IS NOT NULL AND `penugasan_lainnya_kelompok` != '' AND `penugasan_lainnya_kelompok` != '-')
            ) AND (
                (`jenis_penugasan_perorangan` IS NULL OR `jenis_penugasan_perorangan` = '' OR `jenis_penugasan_perorangan` = '-') AND
                (`jenis_penugasan_kelompok` IS NULL OR `jenis_penugasan_kelompok` = '' OR `jenis_penugasan_kelompok` = '-')
            )");
        }
    }
}

    /* ================================
    PENDING - DENGAN FILTER JENIS PENUGASAN
    ================================= */
    public function pending() {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $search = $this->input->get('search');
        $lingkup_penugasan_filter = $this->input->get('lingkup_penugasan');
        $jenis_penugasan_filter = $this->input->get('jenis_penugasan');
        
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['current_page'] = 'pending';
        $data['jenis_penugasan_filter'] = $jenis_penugasan_filter;

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where('status', 'disetujui KK');
        
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }

        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // Statistik
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['pending_count'] = $this->db->where('status', 'disetujui KK')
                                         ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['approved_count'] = $this->db->where('status', 'disetujui sekretariat')
                                          ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['rejected_count'] = $this->db->where('status', 'ditolak sekretariat')
                                          ->count_all_results('surat');

        $this->load->view('sekretariat/halaman_pending', $data);
    }

    /* ================================
    DISETUJUI SEKRETARIAT - DENGAN FILTER JENIS PENUGASAN
    ================================= */
    public function disetujui() {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $search = $this->input->get('search');
        $lingkup_penugasan_filter = $this->input->get('lingkup_penugasan');
        $jenis_penugasan_filter = $this->input->get('jenis_penugasan');

        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['current_page'] = 'disetujui';
        $data['jenis_penugasan_filter'] = $jenis_penugasan_filter;

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where('status', 'disetujui sekretariat');
        
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }

        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }

        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // Statistik
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['pending_count'] = $this->db->where('status', 'disetujui KK')
                                         ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['approved_count'] = $this->db->where('status', 'disetujui sekretariat')
                                          ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['rejected_count'] = $this->db->where('status', 'ditolak sekretariat')
                                          ->count_all_results('surat');

        $this->load->view('sekretariat/halaman_disetujui', $data);
    }

    /* ================================
    DITOLAK SEKRETARIAT - DENGAN FILTER JENIS PENUGASAN
    ================================= */
    public function ditolak() {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $search = $this->input->get('search');
        $lingkup_penugasan_filter = $this->input->get('lingkup_penugasan');
        $jenis_penugasan_filter = $this->input->get('jenis_penugasan');

        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['current_page'] = 'ditolak';
        $data['jenis_penugasan_filter'] = $jenis_penugasan_filter;

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where('status', 'ditolak sekretariat');
        
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }

        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }

        $this->db->order_by("created_at", "DESC");
        $data['pengajuan_ditolak'] = $this->db->get("surat")->result();

        // Statistik
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['pending_count'] = $this->db->where('status', 'disetujui KK')
                                         ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['approved_count'] = $this->db->where('status', 'disetujui sekretariat')
                                          ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['rejected_count'] = $this->db->where('status', 'ditolak sekretariat')
                                          ->count_all_results('surat');

        $this->load->view('sekretariat/halaman_ditolak', $data);
    }

    /* ================================
    DISETUJUI DEKAN - DENGAN FILTER JENIS PENUGASAN
    ================================= */
    public function disetujui_dekan() {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $search = $this->input->get('search');
        $lingkup_penugasan_filter = $this->input->get('lingkup_penugasan');
        $jenis_penugasan_filter = $this->input->get('jenis_penugasan');

        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['current_page'] = 'disetujui_dekan';
        $data['jenis_penugasan_filter'] = $jenis_penugasan_filter;

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where('status', 'disetujui dekan');
        
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }

        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }

        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // Statistik
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['pending_count'] = $this->db->where('status', 'disetujui KK')
                                         ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['approved_count'] = $this->db->where('status', 'disetujui sekretariat')
                                          ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['rejected_count'] = $this->db->where('status', 'ditolak sekretariat')
                                          ->count_all_results('surat');

        $this->load->view('sekretariat/halaman_disetujui_dekan', $data);
    }

    /* ================================
    DITOLAK DEKAN - DENGAN FILTER JENIS PENUGASAN
    ================================= */
    public function ditolak_dekan() {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $search = $this->input->get('search');
        $lingkup_penugasan_filter = $this->input->get('lingkup_penugasan');
        $jenis_penugasan_filter = $this->input->get('jenis_penugasan');

        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['current_page'] = 'ditolak_dekan';
        $data['jenis_penugasan_filter'] = $jenis_penugasan_filter;

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where('status', 'ditolak dekan');
        
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }

        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }

        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // Statistik
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['pending_count'] = $this->db->where('status', 'disetujui KK')
                                         ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['approved_count'] = $this->db->where('status', 'disetujui sekretariat')
                                          ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['rejected_count'] = $this->db->where('status', 'ditolak sekretariat')
                                          ->count_all_results('surat');

        $this->load->view('sekretariat/halaman_ditolak_dekan', $data);
    }

    /* ================================
    TOTAL SEMUA PENGAJUAN - DENGAN FILTER JENIS PENUGASAN
    ================================= */
    public function semua() {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $search = $this->input->get('search');
        $status = $this->input->get('status');
        $lingkup_penugasan_filter = $this->input->get('lingkup_penugasan');
        $jenis_penugasan_filter = $this->input->get('jenis_penugasan');
        
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['current_page'] = 'semua';
        $data['jenis_penugasan_filter'] = $jenis_penugasan_filter;

        // Ambil semua data yang relevan untuk sekretariat
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);

        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }

        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);

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

        // Statistik
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        
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
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['pending_count'] = $this->db->where('status', 'disetujui KK')
                                         ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['approved_count'] = $this->db->where('status', 'disetujui sekretariat')
                                          ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $data['rejected_count'] = $this->db->where('status', 'ditolak sekretariat')
                                          ->count_all_results('surat');

        $this->load->view('sekretariat/halaman_total', $data);
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
            
            $jenis_date = $pengajuan->jenis_date ?? null;
            $periode_kegiatan = $pengajuan->periode_kegiatan ?? null;
            $periode_value = $pengajuan->periode_value ?? null;
            $tanggal_kegiatan = $pengajuan->tanggal_kegiatan ?? null;
            $akhir_kegiatan = $pengajuan->akhir_kegiatan ?? null;
            
            $periode_display = '-';
            
            if ($jenis_date === 'Custom') {
                if ($tanggal_kegiatan && $akhir_kegiatan) {
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
                    $periode_display = date('d M Y', strtotime($tanggal_kegiatan));
                }
            } elseif ($jenis_date === 'Periode') {
                $periode_display = $periode_kegiatan ?: $periode_value ?: '-';
            }
            
            // TAMBAHAN: Data jenis penugasan untuk modal detail
            $jenis_penugasan_perorangan = $pengajuan->jenis_penugasan_perorangan ?? '-';
            $jenis_penugasan_kelompok = $pengajuan->jenis_penugasan_kelompok ?? '-';
            $penugasan_lainnya_perorangan = $pengajuan->penugasan_lainnya_perorangan ?? '-';
            $penugasan_lainnya_kelompok = $pengajuan->penugasan_lainnya_kelompok ?? '-';
            
            $response_data = array(
                'id' => $pengajuan->id,
                'nama_kegiatan' => $pengajuan->nama_kegiatan,
                'status' => $pengajuan->status,
                'jenis_pengajuan' => $pengajuan->jenis_pengajuan,
                'lingkup_penugasan' => $pengajuan->lingkup_penugasan ?? '-',
                'jenis_penugasan_perorangan' => $jenis_penugasan_perorangan,
                'jenis_penugasan_kelompok' => $jenis_penugasan_kelompok,
                'penugasan_lainnya_perorangan' => $penugasan_lainnya_perorangan,
                'penugasan_lainnya_kelompok' => $penugasan_lainnya_kelompok,
                'penyelenggara' => $pengajuan->penyelenggara,
                'jenis_date' => $jenis_date,
                'periode_value' => $periode_display,
                'tanggal_kegiatan' => $tanggal_kegiatan,
                'akhir_kegiatan' => $akhir_kegiatan,
                'tempat_kegiatan' => $pengajuan->tempat_kegiatan ?? '-',
                'created_at' => $pengajuan->created_at,
                'catatan_penolakan' => $pengajuan->catatan_penolakan ?? null,
                'dosen_data' => $dosen_data,
                'eviden' => $pengajuan->eviden ?? null,
                'nomor_surat' => $pengajuan->nomor_surat ?? null,
                'nama_dosen' => $pengajuan->nama_dosen ?? null,
                'nip' => $pengajuan->nip ?? null,
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
    FUNGSI UNTUK MENDAPATKAN PROGRESS TIMELINE
    ================================= */
    private function getProgressTimeline($id)
    {
        $this->db->where('id', $id);
        $surat = $this->db->get('surat')->row();
        
        if (!$surat) {
            return null;
        }
        
        $approval = json_decode($surat->approval_status, true) ?? [];
        
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
                    $status = 'completed';
                }
                
                $timeline[$role]['status'] = $status;
                $timeline[$role]['timestamp'] = is_array($data) ? ($data['timestamp'] ?? null) : $data;
                $timeline[$role]['display_time'] = $timeline[$role]['timestamp'] ? 
                    $this->formatDisplayTime($timeline[$role]['timestamp']) : '-';
            }
        }
        
        if ($timeline['sekretariat']['status'] == 'completed') {
            $timeline['kaprodi']['status'] = 'completed';
            
            if (!$timeline['kaprodi']['timestamp']) {
                $timeline['kaprodi']['timestamp'] = date('Y-m-d H:i:s', strtotime($surat->created_at . ' +1 hour'));
                $timeline['kaprodi']['display_time'] = $this->formatDisplayTime($timeline['kaprodi']['timestamp']);
            }
        }
        
        if ($timeline['dekan']['status'] == 'completed') {
            $timeline['kaprodi']['status'] = 'completed';
            $timeline['sekretariat']['status'] = 'completed';
            
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
    FORMAT DISPLAY TIME
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
    FUNGSI AMBIL DATA DOSEN
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
    APPROVE - DENGAN NOMOR SURAT & PROGRESS BAR
    ================================= */
    public function approve($id)
    {
        $nomor_surat = $this->input->post('nomor_surat');
        
        if (empty($nomor_surat)) {
            $this->session->set_flashdata('error', 'Nomor surat harus diisi!');
            $this->redirectToPreviousPage();
            return;
        }

        $this->db->where('nomor_surat', $nomor_surat);
        $this->db->where('id !=', $id);
        $existing = $this->db->get('surat')->row();

        if ($existing) {
            $this->session->set_flashdata('error', 'Nomor surat sudah digunakan! Silakan gunakan nomor lain.');
            $this->redirectToPreviousPage();
            return;
        }

        $surat = $this->db->get_where('surat', ['id' => $id])->row();
        
        if (!$surat) {
            $this->session->set_flashdata('error', 'Data surat tidak ditemukan');
            $this->redirectToPreviousPage();
            return;
        }

        if ($surat->status !== 'disetujui KK') {
            $this->session->set_flashdata('error', 'Status pengajuan tidak valid untuk disetujui. Status saat ini: ' . $surat->status);
            $this->redirectToPreviousPage();
            return;
        }

        $approval = json_decode($surat->approval_status, true) ?? [];
        
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
    REJECT
    ================================= */
    public function reject($id)
    {
        $notes = $this->input->post('rejection_notes');
        if (empty($notes)) {
            $this->session->set_flashdata('error', 'Alasan penolakan harus diisi');
            $this->redirectToPreviousPage();
            return;
        }

        $surat = $this->db->get_where('surat', ['id' => $id])->row();
        
        if (!$surat) {
            $this->session->set_flashdata('error', 'Data surat tidak ditemukan');
            $this->redirectToPreviousPage();
            return;
        }

        if ($surat->status !== 'disetujui KK') {
            $this->session->set_flashdata('error', 'Status pengajuan tidak valid untuk ditolak. Status saat ini: ' . $surat->status);
            $this->redirectToPreviousPage();
            return;
        }

        $approval = json_decode($surat->approval_status, true) ?? [];
        
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
    HELPER FUNCTION UNTUK REDIRECT
    ================================= */
    private function redirectToPreviousPage()
    {
        $current_page = $this->input->get('from') ?? 'sekretariat';
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $search = $this->input->get('search');
        $status = $this->input->get('status');
        $lingkup_penugasan = $this->input->get('lingkup_penugasan');
        $jenis_penugasan = $this->input->get('jenis_penugasan');
        
        $query_params = 'tahun=' . $tahun . '&bulan=' . $bulan;
        if (!empty($search)) {
            $query_params .= '&search=' . urlencode($search);
        }
        if (!empty($status)) {
            $query_params .= '&status=' . $status;
        }
        if (!empty($lingkup_penugasan)) {
            $query_params .= '&lingkup_penugasan=' . $lingkup_penugasan;
        }
        if (!empty($jenis_penugasan)) {
            $query_params .= '&jenis_penugasan=' . $jenis_penugasan;
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
    REALTIME DASHBOARD COUNTER - DENGAN FILTER JENIS PENUGASAN
    ================================= */
    public function get_dashboard_counts() {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $lingkup_penugasan_filter = $this->input->get('lingkup_penugasan');
        $jenis_penugasan_filter = $this->input->get('jenis_penugasan');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $total = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $this->db->where('status', 'disetujui KK');
        $pending = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $this->db->where('status', 'disetujui sekretariat');
        $approved = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }
        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
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
    TAMPILKAN SURAT PENGAJUAN DALAM MODAL
    ================================= */
    public function view_surat_pengajuan($id)
    {
        $this->db->where('id', $id);
        $data['surat'] = $this->db->get('surat')->row();
        
        if (!$data['surat']) {
            show_404();
            return;
        }
        
        $data['dosen_data'] = $this->get_dosen_data_from_nip_fixed($data['surat']->nip);
        
        $this->load->view('surat_print2', $data);
    }
    
    /* ================================
    GET EVIDEN
    ================================= */
    public function getEviden($id)
    {
        $this->db->where('id', $id);
        $surat = $this->db->get('surat')->row();
        
        if ($surat && !empty($surat->eviden)) {
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

    /* ================================
    BULK APPROVE
    ================================= */
    public function bulk_approve()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $ids = $this->input->post('ids');
            $nomor_surat_data = $this->input->post('nomor_surat');
            
            if (empty($ids)) {
                $this->session->set_flashdata('error', 'Tidak ada pengajuan yang dipilih.');
                redirect('sekretariat/pending');
            }
            
            $id_array = explode(',', $ids);
            
            $success_count = 0;
            $error_count = 0;
            $error_messages = [];
            
            foreach ($id_array as $id) {
                $id = trim($id);
                
                if (!isset($nomor_surat_data[$id]) || empty($nomor_surat_data[$id])) {
                    $error_count++;
                    $error_messages[] = "Nomor surat harus diisi untuk ID: $id";
                    continue;
                }
                
                $nomor_surat = $nomor_surat_data[$id];
                
                $this->db->where('nomor_surat', $nomor_surat);
                $this->db->where('id !=', $id);
                $existing = $this->db->get('surat')->row();
                
                if ($existing) {
                    $error_count++;
                    $error_messages[] = "Nomor surat '$nomor_surat' sudah digunakan (ID: $id)";
                    continue;
                }
                
                $surat = $this->db->get_where('surat', ['id' => $id])->row();
                
                if (!$surat) {
                    $error_count++;
                    $error_messages[] = "Data tidak ditemukan (ID: $id)";
                    continue;
                }
                
                if ($surat->status !== 'disetujui KK') {
                    $error_count++;
                    $error_messages[] = "Status tidak valid untuk ID: $id (Status: $surat->status)";
                    continue;
                }
                
                $approval = json_decode($surat->approval_status, true) ?? [];
                
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
                
                $this->db->where('id', $id);
                if ($this->db->update('surat', $update_data)) {
                    $success_count++;
                } else {
                    $error_count++;
                    $error_messages[] = "Gagal update database (ID: $id)";
                }
            }
            
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
            redirect('sekretariat/pending');
        }
    }

    /* ================================
    BULK REJECT
    ================================= */
    public function bulk_reject()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $ids = $this->input->post('ids');
            $rejection_notes_data = $this->input->post('rejection_notes');
            
            if (empty($ids)) {
                $this->session->set_flashdata('error', 'Tidak ada pengajuan yang dipilih.');
                redirect('sekretariat/pending');
            }
            
            $id_array = explode(',', $ids);
            
            $success_count = 0;
            $error_count = 0;
            $error_messages = [];
            
            foreach ($id_array as $id) {
                $id = trim($id);
                
                if (!isset($rejection_notes_data[$id]) || empty($rejection_notes_data[$id])) {
                    $error_count++;
                    $error_messages[] = "Alasan penolakan harus diisi untuk ID: $id";
                    continue;
                }
                
                $rejection_notes = $rejection_notes_data[$id];
                
                $surat = $this->db->get_where('surat', ['id' => $id])->row();
                
                if (!$surat) {
                    $error_count++;
                    $error_messages[] = "Data tidak ditemukan (ID: $id)";
                    continue;
                }
                
                if ($surat->status !== 'disetujui KK') {
                    $error_count++;
                    $error_messages[] = "Status tidak valid untuk ID: $id (Status: $surat->status)";
                    continue;
                }
                
                $approval = json_decode($surat->approval_status, true) ?? [];
                
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

        $status_lower = strtolower($surat->status);
        
        if ($status_lower !== 'ditolak dekan') {
            $this->session->set_flashdata('error', '⚠️ Edit hanya dapat dilakukan untuk surat yang ditolak Dekan! Status surat ini: ' . $surat->status);
            redirect('sekretariat');
            return;
        }

        $data['surat'] = (array)$surat;
        $data['dosen_data'] = $this->get_dosen_data_from_nip_fixed($surat->nip);
        
        $eviden_raw = $surat->eviden ?? "[]";
        
        if (is_string($eviden_raw)) {
            $eviden_decoded = json_decode($eviden_raw, true);
            $data['eviden'] = is_array($eviden_decoded) ? $eviden_decoded : [];
        } else {
            $data['eviden'] = is_array($eviden_raw) ? $eviden_raw : [];
        }

        if (!$this->input->post()) {
            $this->load->view('sekretariat/edit_surat', $data);
            return;
        }

        $this->update_surat($id);
    }

    /* ================================
    UPDATE SURAT
    ================================= */
    public function update_surat($id = null)
    {
        if (!$id) {
            $id = $this->uri->segment(3);
        }

        $surat = $this->Surat_model->get_by_id($id);

        if (!$surat) {
            show_404();
            return;
        }

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

        foreach ($post as $k => $v) {
            if (is_array($v)) {
                $post[$k] = array_values(array_filter($v, function($x) {
                    return trim($x) !== "";
                }));
            } else {
                $post[$k] = ($v === "" ? "-" : $v);
            }
        }

        $existing_eviden = json_decode($surat->eviden, true) ?: [];
        $deleted_files = $post['delete_eviden'] ?? [];
        
        foreach ($deleted_files as $del_file) {
            if ($del_file && trim($del_file) !== '') {
                $existing_eviden = array_filter($existing_eviden, function($f) use ($del_file) {
                    return $f !== $del_file;
                });
                
                if (!filter_var($del_file, FILTER_VALIDATE_URL)) {
                    $file_path = './uploads/eviden/' . $del_file;
                    if (file_exists($file_path)) {
                        @unlink($file_path);
                    }
                }
            }
        }
        
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
                    }
                }
            }
        }
        
        $final_eviden = array_merge(array_values($existing_eviden), $new_files);
        $update_eviden = json_encode($final_eviden);

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

        $approval_status = json_decode($surat->approval_status, true);
        if (!is_array($approval_status)) {
            $approval_status = [
                'kk' => null,
                'sekretariat' => null,
                'dekan' => null
            ];
        }
        
        $approval_status['dekan'] = null;
        $update['status'] = 'disetujui sekretariat';
        $update['approval_status'] = json_encode($approval_status);
        $update['catatan_penolakan'] = null;
        $update['updated_at'] = date('Y-m-d H:i:s');

        $result = $this->Surat_model->update_surat($id, $update);

        if ($result) {
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
    CETAK SURAT UNTUK SEKRETARIAT
    ================================= */
    public function cetak($id)
    {
        $surat = $this->Surat_model->get_by_id($id);
        
        if (!$surat) {
            show_404();
            return;
        }

        $allowed_status = ['disetujui sekretariat', 'disetujui dekan'];
        if (!in_array(strtolower($surat->status), array_map('strtolower', $allowed_status))) {
            $this->session->set_flashdata('error', 'Surat belum disetujui untuk dicetak.');
            redirect('sekretariat');
            return;
        }

        $data['surat'] = $surat;
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

        $approval = json_decode($surat->approval_status, true);
        if (!is_array($approval)) $approval = [];

        $getTime = function($val) {
            if (!$val) return null;

            if (is_string($val)) return $val;
            if (is_array($val) && isset($val['waktu'])) return $val['waktu'];

            return null;
        };

        $kk  = $getTime($approval['kk'] ?? null);
        $sek = $getTime($approval['sekretariat'] ?? null);
        $dek = $getTime($approval['dekan'] ?? null);

        $status = strtolower(trim($surat->status ?? 'pengajuan'));
        
        $steps = [];
        $progress_percentage = 0;

        $steps[] = [
            'step_name' => 'Mengirim',
            'status' => 'completed',
            'date' => date('d M Y', strtotime($surat->created_at)),
            'label' => 'Terkirim'
        ];

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