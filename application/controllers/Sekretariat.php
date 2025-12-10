<?php
defined('BASEPATH') or exit('No direct script access allowed');
    use Dompdf\Dompdf;
    use Dompdf\Options;
class Sekretariat extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->model('Surat_model');
    }

    public function index($filter = 'all')
{
    $tahun = $this->input->get('tahun') ?? date('Y');
    $bulan = $this->input->get('bulan') ?? 'all';
    $search = $this->input->get('search');
    $status_filter = $this->input->get('status');
    $lingkup_penugasan_filter = $this->input->get('lingkup_penugasan');
    $jenis_penugasan_filter = $this->input->get('jenis_penugasan');
    $divisi_filter = $this->input->get('divisi');

    $data['tahun'] = $tahun;
    $data['bulan'] = $bulan;
    $data['current_filter'] = $filter;
    $data['jenis_penugasan_filter'] = $jenis_penugasan_filter;
    $data['divisi_filter'] = $divisi_filter;
    $data['divisi_list'] = $this->getDivisiList();

    // PENTING: Reset query builder sebelum mulai
    $this->db->reset_query();
    
    // Query untuk surat_list
    $this->db->select('*');
    $this->db->from('surat');
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

    // Filter status
    if (!empty($status_filter)) {
        switch ($status_filter) {
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
        switch ($filter) {
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

    // Filter jenis penugasan
    $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
    
    // PENTING: Filter divisi harus dipanggil terakhir sebelum get()
    $this->applyDivisiFilter($divisi_filter);

    $this->db->order_by("created_at", "DESC");
    $data['surat_list'] = $this->db->get()->result();

    // Statistik untuk card - RESET query builder untuk setiap query
    
    // Total surat
    $this->db->reset_query();
    $this->db->from('surat');
    $this->db->where('YEAR(created_at)', $tahun);
    if ($bulan !== 'all') {
        $this->db->where('MONTH(created_at)', $bulan);
    }
    $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
    if (!empty($lingkup_penugasan_filter)) {
        $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
    }
    $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
    $this->applyDivisiFilter($divisi_filter);
    $data['total_surat'] = $this->db->count_all_results();

    // Pending count
    $this->db->reset_query();
    $this->db->from('surat');
    $this->db->where('YEAR(created_at)', $tahun);
    if ($bulan !== 'all') {
        $this->db->where('MONTH(created_at)', $bulan);
    }
    $this->db->where('status', 'disetujui KK');
    if (!empty($lingkup_penugasan_filter)) {
        $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
    }
    $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
    $this->applyDivisiFilter($divisi_filter);
    $data['pending_count'] = $this->db->count_all_results();

    // Approved count
    $this->db->reset_query();
    $this->db->from('surat');
    $this->db->where('YEAR(created_at)', $tahun);
    if ($bulan !== 'all') {
        $this->db->where('MONTH(created_at)', $bulan);
    }
    $this->db->where('status', 'disetujui sekretariat');
    if (!empty($lingkup_penugasan_filter)) {
        $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
    }
    $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
    $this->applyDivisiFilter($divisi_filter);
    $data['approved_count'] = $this->db->count_all_results();

    // Rejected count
    $this->db->reset_query();
    $this->db->from('surat');
    $this->db->where('YEAR(created_at)', $tahun);
    if ($bulan !== 'all') {
        $this->db->where('MONTH(created_at)', $bulan);
    }
    $this->db->where_in('status', ['ditolak sekretariat', 'ditolak KK']);
    if (!empty($lingkup_penugasan_filter)) {
        $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
    }
    $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
    $this->applyDivisiFilter($divisi_filter);
    $data['rejected_count'] = $this->db->count_all_results();

    // Grafik data
    $total = array_fill(0, 12, 0);
    $pending = array_fill(0, 12, 0);
    $approved = array_fill(0, 12, 0);
    $rejected = array_fill(0, 12, 0);

    if ($bulan === 'all') {
        for ($i = 1; $i <= 12; $i++) {
            $total[$i - 1] = $this->countByMonthYear($i, $tahun, $lingkup_penugasan_filter, $jenis_penugasan_filter, $divisi_filter);
            $pending[$i - 1] = $this->countPendingByMonthYear($i, $tahun, $lingkup_penugasan_filter, $jenis_penugasan_filter, $divisi_filter);
            $approved[$i - 1] = $this->countApprovedByMonthYear($i, $tahun, $lingkup_penugasan_filter, $jenis_penugasan_filter, $divisi_filter);
            $rejected[$i - 1] = $this->countRejectedByMonthYear($i, $tahun, $lingkup_penugasan_filter, $jenis_penugasan_filter, $divisi_filter);
        }
    } else {
        $bulan_int = (int)$bulan;
        for ($i = 1; $i <= 12; $i++) {
            if ($i == $bulan_int) {
                $total[$i - 1] = $this->countByMonthYear($i, $tahun, $lingkup_penugasan_filter, $jenis_penugasan_filter, $divisi_filter);
                $pending[$i - 1] = $this->countPendingByMonthYear($i, $tahun, $lingkup_penugasan_filter, $jenis_penugasan_filter, $divisi_filter);
                $approved[$i - 1] = $this->countApprovedByMonthYear($i, $tahun, $lingkup_penugasan_filter, $jenis_penugasan_filter, $divisi_filter);
                $rejected[$i - 1] = $this->countRejectedByMonthYear($i, $tahun, $lingkup_penugasan_filter, $jenis_penugasan_filter, $divisi_filter);
            }
        }
    }

    $data['chart_total'] = $total;
    $data['chart_approved'] = $approved;
    $data['chart_rejected'] = $rejected;

    $this->load->view('sekretariat/dashboard', $data);
}

   private function countByMonthYear($month, $year, $lingkup_penugasan_filter = null, $jenis_penugasan_filter = null, $divisi_filter = null)
{
    $this->db->where('YEAR(created_at)', $year);
    $this->db->where('MONTH(created_at)', $month);
    $this->db->where_in('status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);

    if (!empty($lingkup_penugasan_filter)) {
        $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
    }

    $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
    $this->applyDivisiFilter($divisi_filter); // TAMBAHAN BARU
    return $this->db->count_all_results('surat');
}

private function countPendingByMonthYear($month, $year, $lingkup_penugasan_filter = null, $jenis_penugasan_filter = null, $divisi_filter = null)
{
    $this->db->where('YEAR(created_at)', $year);
    $this->db->where('MONTH(created_at)', $month);
    $this->db->where('status', 'disetujui KK');

    if (!empty($lingkup_penugasan_filter)) {
        $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
    }

    $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
    $this->applyDivisiFilter($divisi_filter); // TAMBAHAN BARU
    return $this->db->count_all_results('surat');
}

private function countApprovedByMonthYear($month, $year, $lingkup_penugasan_filter = null, $jenis_penugasan_filter = null, $divisi_filter = null)
{
    $this->db->where('YEAR(created_at)', $year);
    $this->db->where('MONTH(created_at)', $month);
    $this->db->where('status', 'disetujui sekretariat');

    if (!empty($lingkup_penugasan_filter)) {
        $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
    }

    $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
    $this->applyDivisiFilter($divisi_filter); // TAMBAHAN BARU
    return $this->db->count_all_results('surat');
}

private function countRejectedByMonthYear($month, $year, $lingkup_penugasan_filter = null, $jenis_penugasan_filter = null, $divisi_filter = null)
{
    $this->db->where('YEAR(created_at)', $year);
    $this->db->where('MONTH(created_at)', $month);
    $this->db->where('status', 'ditolak sekretariat');

    if (!empty($lingkup_penugasan_filter)) {
        $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
    }

    $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
    $this->applyDivisiFilter($divisi_filter); // TAMBAHAN BARU
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
    public function pending()
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $search = $this->input->get('search');
        $lingkup_penugasan_filter = $this->input->get('lingkup_penugasan');
        $jenis_penugasan_filter = $this->input->get('jenis_penugasan');
         $divisi_filter = $this->input->get('divisi'); 

        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['current_page'] = 'pending';
        $data['jenis_penugasan_filter'] = $jenis_penugasan_filter;
        $data['divisi_filter'] = $divisi_filter; // TAMBAHAN BARU
        $data['divisi_list'] = $this->getDivisiList(); // TAMBAHAN BARU

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where('status', 'disetujui KK');

        if (!empty($lingkup_penugasan_filter)) {
            $this->db->where('lingkup_penugasan', $lingkup_penugasan_filter);
        }

        $this->applyJenisPenugasanFilter($jenis_penugasan_filter);
        $this->applyDivisiFilter($divisi_filter);

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
    public function disetujui()
    {
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
    public function ditolak()
    {
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
    public function disetujui_dekan()
    {
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
    public function ditolak_dekan()
    {
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
    public function semua()
    {
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
            switch ($status) {
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
            switch ($status) {
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
                        'Jan' => 'Jan',
                        'Feb' => 'Feb',
                        'Mar' => 'Mar',
                        'Apr' => 'Apr',
                        'May' => 'Mei',
                        'Jun' => 'Jun',
                        'Jul' => 'Jul',
                        'Aug' => 'Ags',
                        'Sep' => 'Sep',
                        'Oct' => 'Okt',
                        'Nov' => 'Nov',
                        'Dec' => 'Des'
                    ];

                    $format_tanggal = function ($date) use ($bulan_indonesia) {
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
<<<<<<< HEAD

    /* ================================
    FUNGSI AMBIL DATA DOSEN
    ================================= */
    private function get_dosen_data_from_nip_fixed($nip_data)
    {
        $dosen_data = array();
=======
/* ================================
GET DOSEN DATA FROM NIP - DENGAN PARSE JABATAN & PERAN
================================= */
private function get_dosen_data_from_nip_fixed($nip_data, $peran_data = null)
{
    $dosen_data = array();
>>>>>>> 3efbe30ae6b3b9a3ba77a2ab87b6d0b72562271d

        if (empty($nip_data) || $nip_data === '-' || $nip_data === '[]' || $nip_data === 'null') {
            return [array(
                'nama' => 'Data dosen tidak tersedia',
                'nip' => '-',
                'jabatan' => '-',
                'divisi' => '-'
            )];
        }

<<<<<<< HEAD
        $nip_array = array();
=======
    // Parse NIP
    $nip_array = array();
>>>>>>> 3efbe30ae6b3b9a3ba77a2ab87b6d0b72562271d

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

        $nip_array = array_filter(array_map(function ($nip) {
            if (is_array($nip)) {
                return !empty($nip) ? trim(strval($nip[0])) : null;
            }
            return trim(strval($nip));
        }, $nip_array), function ($nip) {
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
<<<<<<< HEAD
            foreach ($nip_array as $nip) {
                $clean_nip = trim(strval($nip));
=======
            $nip_array = [$trimmed_data];
        }
    } elseif (is_array($nip_data)) {
        $nip_array = $nip_data;
    } else {
        $nip_array = [$nip_data];
    }

    $nip_array = array_filter(array_map(function ($nip) {
        if (is_array($nip)) {
            return !empty($nip) ? trim(strval($nip[0])) : null;
        }
        return trim(strval($nip));
    }, $nip_array), function ($nip) {
        return !empty($nip) && $nip !== '-' && $nip !== 'null' && $nip !== '[]';
    });

    if (empty($nip_array)) {
        return [array(
            'nama' => 'Data dosen tidak tersedia',
            'nip' => '-',
            'jabatan' => '-',
            'divisi' => '-',
            'peran' => '-'
        )];
    }

    // Process peran data (yang berisi gabungan jabatan & peran)
    $peran_array = [];
    if (!empty($peran_data)) {
        if (is_string($peran_data)) {
            $decoded_peran = json_decode($peran_data, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded_peran)) {
                $peran_array = $decoded_peran;
            } else {
                $peran_array = [$peran_data];
            }
        } elseif (is_array($peran_data)) {
            $peran_array = $peran_data;
        }
    }

    // Query dosen dari database
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

        foreach ($nip_array as $index => $nip) {
            $clean_nip = trim(strval($nip));
            if (isset($dosen_by_nip[$clean_nip])) {
                $dosen_info = $dosen_by_nip[$clean_nip];
                
                // PARSE PERAN DATA (yang berisi jabatan & peran)
                $peran_value = '-';
                $jabatan_value = $dosen_info['jabatan']; // Default dari database
                
                if (isset($peran_array[$index])) {
                    $peran_item = $peran_array[$index];
                    
                    // Jika peran_item adalah string JSON, decode
                    if (is_string($peran_item)) {
                        $decoded = json_decode($peran_item, true);
                        if (is_array($decoded) && isset($decoded['jabatan'])) {
                            $jabatan_value = $decoded['jabatan'];
                            $peran_value = $decoded['peran'] ?? '-';
                        } else {
                            // Fallback: jika string biasa (data lama)
                            $peran_value = $peran_item;
                        }
                    } 
                    // Jika peran_item sudah array
                    elseif (is_array($peran_item) && isset($peran_item['jabatan'])) {
                        $jabatan_value = $peran_item['jabatan'];
                        $peran_value = $peran_item['peran'] ?? '-';
                    }
                }
                
                $dosen_data[] = array(
                    'nama' => $dosen_info['nama'],
                    'nip' => $dosen_info['nip'],
                    'jabatan' => $jabatan_value, // Jabatan dari edit atau database
                    'divisi' => $dosen_info['divisi'],
                    'peran' => $peran_value // Peran dari edit
                );
            } else {
>>>>>>> 3efbe30ae6b3b9a3ba77a2ab87b6d0b72562271d
                $dosen_data[] = array(
                    'nama' => 'Data dari NIP: ' . $clean_nip,
                    'nip' => $clean_nip,
                    'jabatan' => '-',
<<<<<<< HEAD
                    'divisi' => '-'
                );
            }
        }

        return $dosen_data;
    }

=======
                    'divisi' => '-',
                    'peran' => '-'
                );
            }
        }
    } else {
        foreach ($nip_array as $index => $nip) {
            $clean_nip = trim(strval($nip));
            $dosen_data[] = array(
                'nama' => 'Data dari NIP: ' . $clean_nip,
                'nip' => $clean_nip,
                'jabatan' => '-',
                'divisi' => '-',
                'peran' => '-'
            );
        }
    }

    return $dosen_data;
}
>>>>>>> 3efbe30ae6b3b9a3ba77a2ab87b6d0b72562271d
/* ================================
UPDATE FUNGSI edit_surat_sekretariat
================================= */
public function edit_surat_sekretariat($id)
{
    $surat = $this->Surat_model->get_by_id($id);

    if (!$surat) {
        show_404();
        return;
    }

    // Cek status: tidak boleh edit jika sudah disetujui dekan
    if (strtolower($surat->status) === 'disetujui dekan') {
        $this->session->set_flashdata('error', '⚠️ Surat dengan status <strong>Disetujui Dekan</strong> tidak dapat diedit!');
        redirect('sekretariat');
        return;
    }

    // Cek status: tidak boleh edit jika sudah ditolak dekan
    if (strtolower($surat->status) === 'ditolak dekan') {
        redirect('sekretariat/edit_surat/' . $id);
        return;
    }

    // Process dosen data with peran
    $dosen_data = $this->get_dosen_data_from_nip_fixed($surat->nip, $surat->peran);
    
    // Format untuk form
    $formatted_dosen = [];
    foreach ($dosen_data as $dosen) {
        $formatted_dosen[] = [
            'nip' => $dosen['nip'],
            'nama_dosen' => $dosen['nama'],
            'jabatan' => $dosen['jabatan'],
            'divisi' => $dosen['divisi'],
            'peran' => $dosen['peran']
        ];
    }

    $data['surat'] = (array)$surat;
    $data['dosen_data'] = $formatted_dosen;
    $data['is_edit_sekretariat'] = true;
    $data['current_status'] = strtolower($surat->status);

    // Process eviden files
    $eviden_raw = $surat->eviden ?? "[]";
    $eviden_files = [];

    if (is_string($eviden_raw)) {
        $eviden_decoded = json_decode($eviden_raw, true);
        if (is_array($eviden_decoded)) {
            $eviden_files = $eviden_decoded;
        } else {
            $eviden_files = [$eviden_raw];
        }
    } elseif (is_array($eviden_raw)) {
        $eviden_files = $eviden_raw;
    }

    $data['eviden'] = $eviden_files;

    $this->load->view('sekretariat/edit', $data);
}

/* ================================
PROSES DATA UPDATE SURAT - DENGAN JABATAN & PERAN
================================= */
private function process_surat_update_data($post, $surat)
{
    $update = [
        'nama_kegiatan' => $post['nama_kegiatan'] ?? $surat->nama_kegiatan,
        'jenis_date' => $post['jenis_date'] ?? $surat->jenis_date,
        'tanggal_kegiatan' => $this->safe_date($post['tanggal_kegiatan'] ?? null),
        'akhir_kegiatan' => $this->safe_date($post['akhir_kegiatan'] ?? null),
        'periode_penugasan' => $this->safe_date($post['periode_penugasan'] ?? null),
        'akhir_periode_penugasan' => $this->safe_date($post['akhir_periode_penugasan'] ?? null),
        'periode_value' => $post['periode_value'] ?? $surat->periode_value,
        'tempat_kegiatan' => $post['tempat_kegiatan'] ?? $surat->tempat_kegiatan,
        'penyelenggara' => $post['penyelenggara'] ?? $surat->penyelenggara,
        'customize' => $post['customize'] ?? $surat->customize,
        'jenis_pengajuan' => $post['jenis_pengajuan'] ?? $surat->jenis_pengajuan,
        'lingkup_penugasan' => $post['lingkup_penugasan'] ?? $surat->lingkup_penugasan,
        'jenis_penugasan_perorangan' => $post['jenis_penugasan_perorangan'] ?? $surat->jenis_penugasan_perorangan,
        'penugasan_lainnya_perorangan' => $post['penugasan_lainnya_perorangan'] ?? $surat->penugasan_lainnya_perorangan,
        'jenis_penugasan_kelompok' => $post['jenis_penugasan_kelompok'] ?? $surat->jenis_penugasan_kelompok,
        'penugasan_lainnya_kelompok' => $post['penugasan_lainnya_kelompok'] ?? $surat->penugasan_lainnya_kelompok
    ];

    // Handle nomor surat (hanya jika statusnya disetujui sekretariat)
    if (strtolower($surat->status) === 'disetujui sekretariat') {
        $update['nomor_surat'] = $post['nomor_surat'] ?? $surat->nomor_surat;
    }

    // Process NIP, Nama, dan GABUNGAN JABATAN & PERAN
    if (isset($post['nip']) && is_array($post['nip'])) {
        $nip_array = [];
        $nama_array = [];
        $peran_array = []; // Ini akan berisi gabungan jabatan dan peran
        
        foreach ($post['nip'] as $key => $nip) {
            if (!empty(trim($nip))) {
                $nip_array[] = trim($nip);
                $nama_array[] = $post['nama_dosen'][$key] ?? '';
                
                // GABUNGKAN JABATAN DAN PERAN dalam satu object JSON
                $jabatan_value = isset($post['jabatan'][$key]) && !empty(trim($post['jabatan'][$key])) 
                    ? trim($post['jabatan'][$key]) 
                    : '-';
                
                $peran_value = isset($post['peran'][$key]) && !empty(trim($post['peran'][$key])) 
                    ? trim($post['peran'][$key]) 
                    : '-';
                
                // Simpan sebagai JSON object dengan 2 key: jabatan dan peran
                $peran_array[] = json_encode([
                    'jabatan' => $jabatan_value,
                    'peran' => $peran_value
                ]);
            }
        }
        
        // Simpan NIP sebagai JSON array
        $update['nip'] = json_encode($nip_array);
        
        // Simpan PERAN sebagai JSON array yang berisi JSON objects
        $update['peran'] = json_encode($peran_array);
    }

    // Process file uploads
    $update['eviden'] = $this->process_eviden_files($post, $surat);

    return $update;
}
   public function approve($id)
{
    // HAPUS validasi nomor surat - biarkan kosong
    // $nomor_surat = $this->input->post('nomor_surat');

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
        // 'nomor_surat' => $nomor_surat, // HAPUS atau biarkan null
        'updated_at' => date('Y-m-d H:i:s'),
    ];

    $result = $this->db->where('id', $id)->update('surat', $update_data);

    if ($result) {
        // AMBIL DATA DOSEN DARI DATABASE
        $dosen_data = $this->get_dosen_data_from_nip_fixed($surat->nip);
        
        // Siapkan data untuk success modal dengan data dosen
        $approved_items = [[
            'nama' => $surat->nama_kegiatan,
            'details' => '📅 ' . date('d M Y', strtotime($surat->tanggal_kegiatan)) . ' | 📍 ' . $surat->penyelenggara,
            'dosen_data' => $dosen_data
        ]];
        
        // Set flashdata untuk success modal
        $this->session->set_flashdata('approved_items', $approved_items);
        $this->session->set_flashdata('is_single_approve', true);
        $this->session->set_flashdata('success', 'Surat berhasil disetujui oleh Sekretariat.');
    } else {
        $this->session->set_flashdata('error', 'Gagal menyetujui surat.');
    }

    $this->redirectToPreviousPage();
}

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
    // Get rejection notes
    $rejection_notes = $this->input->post('rejection_notes');
    if (empty($rejection_notes)) {
        $this->session->set_flashdata('error', 'Alasan penolakan harus diisi');
        redirect('sekretariat');
    }
    $update_data = [
        'status' => 'ditolak sekretariat',
        'approval_status' => json_encode($approval),
        'catatan_penolakan' => $notes,
        'updated_at' => date('Y-m-d H:i:s'),
    ];

      $result = $this->db->where('id', $id)->update('surat', $update_data);

    if ($result) {
        // AMBIL DATA DOSEN DARI DATABASE
        $dosen_data = $this->get_dosen_data_from_nip_fixed($surat->nip);
        
        // Siapkan data untuk success modal dengan data dosen
        $rejected_items = [[
            'nama' => $surat->nama_kegiatan,
            'details' => '📅 ' . date('d M Y', strtotime($surat->tanggal_kegiatan)) . ' | 📍 ' . $surat->penyelenggara,
            'dosen_data' => $dosen_data,
            'rejection_notes' => $rejection_notes
        ]];
        
        // Set flashdata untuk success modal
        $this->session->set_flashdata('rejected_items', $rejected_items);
        $this->session->set_flashdata('is_single_reject', true);
        $this->session->set_flashdata('success', 'Surat berhasil ditolak oleh Sekretariat.');
    } else {
        $this->session->set_flashdata('error', 'Gagal menolak surat.');
    }

    $this->redirectToPreviousPage();
}   
   private function redirectToPreviousPage()
{
    $current_page = $this->input->get('from') ?? 'sekretariat';
    $tahun = $this->input->get('tahun') ?? date('Y');
    $bulan = $this->input->get('bulan') ?? 'all';
    $search = $this->input->get('search');
    $status = $this->input->get('status');
    $lingkup_penugasan = $this->input->get('lingkup_penugasan');
    $jenis_penugasan = $this->input->get('jenis_penugasan');
    $divisi = $this->input->get('divisi'); // TAMBAHAN BARU

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
    if (!empty($divisi)) { // TAMBAHAN BARU
        $query_params .= '&divisi=' . urlencode($divisi);
    }

    switch ($current_page) {
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
    public function get_dashboard_counts()
    {
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
TAMPILKAN SURAT PENGAJUAN DALAM MODAL (DENGAN TOOLBAR)
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
    $data['show_toolbar'] = true; // Flag untuk menampilkan toolbar
    $data['surat_id'] = $id; // Pass ID untuk URL download/print

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

<<<<<<< HEAD
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
                $post[$k] = array_values(array_filter($v, function ($x) {
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
                $existing_eviden = array_filter($existing_eviden, function ($f) use ($del_file) {
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
        'customize' => $post['customize'] ?? $surat->customize,
        'jenis_pengajuan' => $post['jenis_pengajuan'] ?? $surat->jenis_pengajuan,
        'lingkup_penugasan' => $post['lingkup_penugasan'] ?? $surat->lingkup_penugasan,
        'jenis_penugasan_perorangan' => $post['jenis_penugasan_perorangan'] ?? $surat->jenis_penugasan_perorangan,
        'penugasan_lainnya_perorangan' => $post['penugasan_lainnya_perorangan'] ?? $surat->penugasan_lainnya_perorangan,
        'jenis_penugasan_kelompok' => $post['jenis_penugasan_kelompok'] ?? $surat->jenis_penugasan_kelompok,
        'penugasan_lainnya_kelompok' => $post['penugasan_lainnya_kelompok'] ?? $surat->penugasan_lainnya_kelompok,
        'eviden' => $update_eviden
    ];

    // PENTING: Process NIP, Nama, dan PERAN data
    if (isset($post['nip']) && is_array($post['nip'])) {
        $nip_array = [];
        $nama_array = [];
        $peran_array = [];
        
        foreach ($post['nip'] as $key => $nip) {
            if (!empty(trim($nip))) {
                $nip_array[] = trim($nip);
                $nama_array[] = $post['nama_dosen'][$key] ?? '';
                
                // Ambil peran, default '-' jika kosong
                $peran_value = isset($post['peran'][$key]) && !empty(trim($post['peran'][$key])) 
                    ? trim($post['peran'][$key]) 
                    : '-';
                $peran_array[] = $peran_value;
            }
        }
        
        $update['nip'] = json_encode($nip_array);
        $update['peran'] = json_encode($peran_array);
    }

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
    $update['updated_at'] = date( $result = $this->Surat_model->update_surat($id, $update));

    if ($result) {
        // TAMBAHKAN FLASHDATA UNTUK SUCCESS MODAL (KHUSUS DITOLAK DEKAN)
        $updated_surat = $this->Surat_model->get_by_id($id);
        $dosen_data = $this->get_dosen_data_from_nip_fixed($updated_surat->nip);
        
        // Siapkan data untuk success modal
        $revision_items = [[
            'nama' => $updated_surat->nama_kegiatan,
            'details' => '📅 ' . date('d M Y', strtotime($updated_surat->tanggal_kegiatan)) . ' | 📍 ' . $updated_surat->penyelenggara,
            'dosen_data' => $dosen_data,
            'new_status' => $updated_surat->status,
            'timestamp' => date('Y-m-d H:i:s')
        ]];
        
        // Set flashdata untuk success modal
        $this->session->set_flashdata('revision_items', $revision_items);
        $this->session->set_flashdata('is_single_revision', true);
        $this->session->set_flashdata('success', "✅ Revisi berhasil disimpan! Pengajuan telah dikirim kembali ke <strong>Dekan</strong> untuk persetujuan ulang.");
    } else {
        $this->session->set_flashdata('error', '❌ Gagal menyimpan revisi. Silakan coba lagi.');
    }
    $result = $this->Surat_model->update_surat($id, $update);

        if ($result) {
            $this->session->set_flashdata('success', "✅ Revisi berhasil disimpan! Pengajuan telah dikirim kembali ke <strong>Dekan</strong> untuk persetujuan ulang.");
        } else {
            $this->session->set_flashdata('error', '❌ Gagal menyimpan revisi. Silakan coba lagi.');
        }

    redirect('sekretariat');
}
=======
 
>>>>>>> 3efbe30ae6b3b9a3ba77a2ab87b6d0b72562271d
 public function update_surat_sekretariat($id = null)
{
    if (!$id) {
        $id = $this->uri->segment(3);
    }

    $surat = $this->Surat_model->get_by_id($id);

    if (!$surat) {
        show_404();
        return;
    }

    // Cek status: tidak boleh edit jika sudah disetujui dekan
    if (strtolower($surat->status) === 'disetujui dekan') {
        $this->session->set_flashdata('error', '⚠️ Surat dengan status <strong>Disetujui Dekan</strong> tidak dapat diedit!');
        redirect('sekretariat');
        return;
    }

    if (!$this->input->post()) {
        redirect('sekretariat/edit_surat_sekretariat/' . $id);
        return;
    }

    $post = $this->input->post();

    // DETEKSI PERUBAHAN - BANDINGKAN DATA LAMA DAN BARU
    $changes = $this->detect_changes($surat, $post);

    // Process form data (sama seperti update_surat biasa)
    $update_data = $this->process_surat_update_data($post, $surat);
    
    // LOGIKA RESET STATUS KHUSUS UNTUK SEKRETARIAT
    $current_status_lower = strtolower($surat->status);
    $approval_status = json_decode($surat->approval_status, true);
    if (!is_array($approval_status)) {
        $approval_status = [
            'kk' => null,
            'sekretariat' => null,
            'dekan' => null
        ];
    }

    // Reset berdasarkan status saat ini
    if (in_array($current_status_lower, ['disetujui sekretariat', 'ditolak sekretariat'])) {
        // Reset ke disetujui KK
        $approval_status['sekretariat'] = null;
        $approval_status['dekan'] = null; // Reset juga approval dekan jika ada
        
        $update_data['status'] = 'disetujui KK';
        $update_data['catatan_penolakan'] = null;
        $update_data['disposisi_status'] = null;
        $update_data['disposisi_catatan'] = null;
        
        $success_message = "✅ Revisi berhasil disimpan! Pengajuan dikembalikan ke status <strong>Disetujui KK</strong>.";
    } elseif ($current_status_lower === 'disetujui kk') {
        // Tetap di status disetujui KK
        $update_data['status'] = 'disetujui KK';
        $success_message = "✅ Revisi berhasil disimpan!";
    }

    $update_data['approval_status'] = json_encode($approval_status);
    $update_data['updated_at'] = date('Y-m-d H:i:s');

    $result = $this->Surat_model->update_surat($id, $update_data);

    if ($result) {
        // TAMBAHKAN FLASHDATA UNTUK SUCCESS MODAL
        $updated_surat = $this->Surat_model->get_by_id($id);
        $dosen_data = $this->get_dosen_data_from_nip_fixed($updated_surat->nip);
        
        // Siapkan data untuk success modal dengan perubahan yang terdeteksi
        $edited_items = [[
            'nama' => $updated_surat->nama_kegiatan,
            'details' => '📅 ' . date('d M Y', strtotime($updated_surat->tanggal_kegiatan)) . ' | 📍 ' . $updated_surat->penyelenggara,
            'dosen_data' => $dosen_data,
            'new_status' => $updated_surat->status,
            'timestamp' => date('Y-m-d H:i:s'),
            'changes' => $changes // TAMBAHAN BARU: Data perubahan
        ]];
        
        // Set flashdata untuk success modal
        $this->session->set_flashdata('edited_items', $edited_items);
        $this->session->set_flashdata('is_single_edit', true);
        $this->session->set_flashdata('success', $success_message);
    } else {
        $this->session->set_flashdata('error', '❌ Gagal menyimpan revisi. Silakan coba lagi.');
    }

    redirect('sekretariat');
}

/* ================================
UPDATE FUNGSI edit_surat (KHUSUS DITOLAK DEKAN) - READONLY EXCEPT JABATAN & PERAN
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

    // AMBIL DATA DOSEN DARI DATABASE - NIP/Nama/Divisi READONLY, Jabatan/Peran EDITABLE
    $dosen_data = $this->get_dosen_data_from_nip_fixed($surat->nip, $surat->peran);
    
    // Format untuk form - SESUAIKAN DENGAN VIEW YANG ADA
    $formatted_dosen = [];
    foreach ($dosen_data as $dosen) {
        $formatted_dosen[] = [
            'nip' => $dosen['nip'],
            'nama' => $dosen['nama'], // Readonly dari list_dosen
            'jabatan' => $dosen['jabatan'], // Editable, akan masuk ke kolom peran
            'divisi' => $dosen['divisi'], // Readonly dari list_dosen
            'peran' => $dosen['peran'] // Editable untuk kelompok
        ];
    }

    $data['surat'] = (array)$surat;
    $data['dosen_data'] = $formatted_dosen;

    $eviden_raw = $surat->eviden ?? "[]";

    if (is_string($eviden_raw)) {
        $eviden_decoded = json_decode($eviden_raw, true);
        $data['eviden'] = is_array($eviden_decoded) ? $eviden_decoded : [];
    } else {
        $data['eviden'] = is_array($eviden_raw) ? $eviden_raw : [];
    }

    if (!$this->input->post()) {
        // Load view yang sudah ada (edit_surat.php dari document 3)
        $this->load->view('sekretariat/edit_surat', $data);
        return;
    }

    $this->update_surat($id);
}

/* ================================
UPDATE FUNGSI update_surat (KHUSUS DITOLAK DEKAN) - HANYA SIMPAN JABATAN & PERAN
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
        $this->session->set_flashdata('error', '⚠️ Edit hanya dapat dilakukan untuk surat yang ditolak Dekan!');
        redirect('sekretariat');
        return;
    }

    if (!$this->input->post()) {
        redirect('sekretariat/edit_surat/' . $id);
        return;
    }

    $post = $this->input->post();

    // Clean data
    foreach ($post as $k => $v) {
        if (is_array($v)) {
            $post[$k] = array_values(array_filter($v, function ($x) {
                return trim($x) !== "";
            }));
        } else {
            $post[$k] = ($v === "" ? "-" : $v);
        }
    }

    // ============= DETEKSI PERUBAHAN =============
    $changes = $this->detect_changes($surat, $post);

    // ============= PROCESS FILE EVIDEN =============
    $existing_eviden = json_decode($surat->eviden, true) ?: [];
    $deleted_files = $post['delete_eviden'] ?? [];

    foreach ($deleted_files as $del_file) {
        if ($del_file && trim($del_file) !== '') {
            $existing_eviden = array_filter($existing_eviden, function ($f) use ($del_file) {
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

    // ============= BUILD UPDATE DATA =============
    $update = [
        'nama_kegiatan' => $post['nama_kegiatan'] ?? $surat->nama_kegiatan,
        'jenis_date' => $post['jenis_date'] ?? $surat->jenis_date,
        'tanggal_kegiatan' => $this->safe_date($post['tanggal_kegiatan'] ?? null),
        'akhir_kegiatan' => $this->safe_date($post['akhir_kegiatan'] ?? null),
        'periode_penugasan' => $this->safe_date($post['periode_penugasan'] ?? null),
        'akhir_periode_penugasan' => $this->safe_date($post['akhir_periode_penugasan'] ?? null),
        'periode_value' => $post['periode_value'] ?? $surat->periode_value,
        'tempat_kegiatan' => $post['tempat_kegiatan'] ?? $surat->tempat_kegiatan,
        'penyelenggara' => $post['penyelenggara'] ?? $surat->penyelenggara,
        'customize' => $post['customize'] ?? $surat->customize,
        'jenis_pengajuan' => $post['jenis_pengajuan'] ?? $surat->jenis_pengajuan,
        'lingkup_penugasan' => $post['lingkup_penugasan'] ?? $surat->lingkup_penugasan,
        'jenis_penugasan_perorangan' => $post['jenis_penugasan_perorangan'] ?? $surat->jenis_penugasan_perorangan,
        'penugasan_lainnya_perorangan' => $post['penugasan_lainnya_perorangan'] ?? $surat->penugasan_lainnya_perorangan,
        'jenis_penugasan_kelompok' => $post['jenis_penugasan_kelompok'] ?? $surat->jenis_penugasan_kelompok,
        'penugasan_lainnya_kelompok' => $post['penugasan_lainnya_kelompok'] ?? $surat->penugasan_lainnya_kelompok,
        'eviden' => $update_eviden
    ];

    // ============= PROCESS JABATAN & PERAN (EDITABLE) =============
    // NIP TIDAK BERUBAH, hanya ambil dari database lama
    // NAMA & DIVISI TIDAK BERUBAH, readonly dari list_dosen
    // HANYA JABATAN & PERAN yang BISA DIEDIT dan MASUK KE KOLOM PERAN
    
    if (isset($post['nip']) && is_array($post['nip'])) {
        $nip_array = json_decode($surat->nip, true); // Ambil NIP lama (TIDAK BERUBAH)
        
        if (!is_array($nip_array)) {
            $nip_array = [];
        }
        
        $peran_array = []; // Ini berisi gabungan jabatan & peran dalam format JSON
        
        foreach ($post['nip'] as $key => $nip) {
            if (!empty(trim($nip)) && isset($nip_array[$key])) {
                // GABUNGKAN JABATAN DAN PERAN dalam satu object JSON
                // Jabatan bisa diedit dari form
                $jabatan_value = isset($post['jabatan'][$key]) && !empty(trim($post['jabatan'][$key])) 
                    ? trim($post['jabatan'][$key]) 
                    : '-';
                
                // Peran bisa diedit dari form (untuk jenis kelompok)
                $peran_value = isset($post['peran'][$key]) && !empty(trim($post['peran'][$key])) 
                    ? trim($post['peran'][$key]) 
                    : '-';
                
                // Simpan sebagai JSON object dengan 2 key: jabatan dan peran
                $peran_array[] = json_encode([
                    'jabatan' => $jabatan_value,
                    'peran' => $peran_value
                ]);
            }
        }
        
        // NIP TIDAK DIUPDATE (tetap sama)
        // update['nip'] = json_encode($nip_array); // TIDAK PERLU, NIP tidak berubah
        
        // Simpan PERAN (yang berisi jabatan & peran editable)
        $update['peran'] = json_encode($peran_array); // Format: [{"jabatan":"Lektor","peran":"Ketua"},...]
    }

    // ============= RESET APPROVAL STATUS =============
    $approval_status = json_decode($surat->approval_status, true);
    if (!is_array($approval_status)) {
        $approval_status = [
            'kk' => null,
            'sekretariat' => null,
            'dekan' => null
        ];
    }

    // Reset approval dekan
    $approval_status['dekan'] = null;
    $update['status'] = 'disetujui sekretariat';
    $update['approval_status'] = json_encode($approval_status);
    $update['catatan_penolakan'] = null;
    $update['updated_at'] = date('Y-m-d H:i:s');

    // ============= SAVE TO DATABASE =============
    $result = $this->Surat_model->update_surat($id, $update);

    if ($result) {
        // Get updated data untuk success modal
        $updated_surat = $this->Surat_model->get_by_id($id);
        $dosen_data = $this->get_dosen_data_from_nip_fixed(
            $updated_surat->nip, 
            $updated_surat->peran
        );
        
        // Siapkan data untuk success modal DENGAN PERUBAHAN
        $revision_items = [[
            'nama' => $updated_surat->nama_kegiatan,
            'details' => '📅 ' . date('d M Y', strtotime($updated_surat->tanggal_kegiatan)) . ' | 📍 ' . $updated_surat->penyelenggara,
            'dosen_data' => $dosen_data,
            'new_status' => $updated_surat->status,
            'timestamp' => date('Y-m-d H:i:s'),
            'changes' => $changes // Data perubahan untuk ditampilkan
        ]];
        
        // Set flashdata untuk success modal
        $this->session->set_flashdata('revision_items', $revision_items);
        $this->session->set_flashdata('is_single_revision', true);
        $this->session->set_flashdata('success', "✅ Revisi berhasil disimpan! Pengajuan telah dikirim kembali ke <strong>Dekan</strong> untuk persetujuan ulang.");
    } else {
        $this->session->set_flashdata('error', '❌ Gagal menyimpan revisi. Silakan coba lagi.');
    }

    redirect('sekretariat');
}

/* ================================
FUNGSI DETECT CHANGES - HANYA CEK JABATAN & PERAN
================================= */
private function detect_changes($surat, $post)
{
    $changes = [];
    
    // Mapping field dengan label yang user-friendly
    $field_labels = [
        'nama_kegiatan' => 'Nama Kegiatan',
        'jenis_pengajuan' => 'Jenis Pengajuan',
        'lingkup_penugasan' => 'Lingkup Penugasan',
        'jenis_penugasan_perorangan' => 'Jenis Penugasan (Perorangan)',
        'jenis_penugasan_kelompok' => 'Jenis Penugasan (Kelompok)',
        'penugasan_lainnya_perorangan' => 'Penugasan Lainnya (Perorangan)',
        'penugasan_lainnya_kelompok' => 'Penugasan Lainnya (Kelompok)',
        'penyelenggara' => 'Penyelenggara',
        'tempat_kegiatan' => 'Tempat Kegiatan',
        'jenis_date' => 'Jenis Tanggal',
        'periode_value' => 'Periode Kegiatan',
        'tanggal_kegiatan' => 'Tanggal Mulai Kegiatan',
        'akhir_kegiatan' => 'Tanggal Akhir Kegiatan',
        'periode_penugasan' => 'Periode Penugasan',
        'akhir_periode_penugasan' => 'Akhir Periode Penugasan',
        'customize' => 'Customize',
        'eviden' => 'File Evidence'
    ];
    
    // Cek perubahan untuk field text biasa
    foreach ($field_labels as $field => $label) {
        if ($field === 'nip' || $field === 'eviden' || $field === 'peran') {
            continue; // Skip
        }
        
        $old_value = isset($surat->$field) ? $surat->$field : '-';
        $new_value = isset($post[$field]) ? $post[$field] : '-';
        
        // Normalisasi nilai kosong
        if (empty($old_value) || $old_value === 'null' || $old_value === '') {
            $old_value = '-';
        }
        if (empty($new_value) || $new_value === 'null' || $new_value === '') {
            $new_value = '-';
        }
        
        // Bandingkan
        if (trim($old_value) !== trim($new_value)) {
            $changes[] = [
                'field' => $field,
                'label' => $label,
                'old_value' => $old_value,
                'new_value' => $new_value,
                'type' => 'text'
            ];
        }
    }
    
    // ============= CEK PERUBAHAN JABATAN & PERAN =============
    $old_peran_data = json_decode($surat->peran, true);
    
    if (!is_array($old_peran_data)) {
        $old_peran_data = [];
    }
    
    // Build old dosen data (untuk display)
    $old_dosen = $this->get_dosen_data_from_nip_fixed($surat->nip, $surat->peran);
    
    // Build new dosen data (hanya jabatan & peran yang berubah)
    $new_nip = json_decode($surat->nip, true); // NIP tidak berubah, ambil dari database
    $new_dosen = [];
    
    if (is_array($new_nip)) {
        foreach ($new_nip as $key => $nip) {
            if (!empty($nip)) {
                // Ambil data dari database (NIP, Nama, Divisi READONLY)
                $dosen_info = $this->db->get_where('list_dosen', ['nip' => $nip])->row();
                
                // Ambil jabatan & peran dari form (EDITABLE)
                $jabatan_value = isset($post['jabatan'][$key]) && !empty(trim($post['jabatan'][$key])) 
                    ? trim($post['jabatan'][$key]) 
                    : '-';
                
                $peran_value = isset($post['peran'][$key]) && !empty(trim($post['peran'][$key])) 
                    ? trim($post['peran'][$key]) 
                    : '-';
                
                $new_dosen[] = [
                    'nip' => $nip,
                    'nama' => $dosen_info ? $dosen_info->nama_dosen : 'Data tidak ditemukan',
                    'jabatan' => $jabatan_value,
                    'divisi' => $dosen_info ? $dosen_info->divisi : '-',
                    'peran' => $peran_value
                ];
            }
        }
    }
    
    // Bandingkan HANYA jabatan & peran
    if ($this->isDifferentDosenJabatanPeran($old_dosen, $new_dosen)) {
        $changes[] = [
            'field' => 'dosen',
            'label' => 'Jabatan & Peran Dosen',
            'old_value' => $old_dosen,
            'new_value' => $new_dosen,
            'type' => 'dosen'
        ];
    }
    
    // Cek perubahan file evidence
    $old_eviden = json_decode($surat->eviden, true) ?: [];
    $deleted_files = $post['delete_eviden'] ?? [];
    $existing_eviden = array_filter($old_eviden, function($f) use ($deleted_files) {
        return !in_array($f, $deleted_files);
    });
    
    $new_files_count = 0;
    if (!empty($_FILES['new_eviden']['name'][0])) {
        $new_files_count = count(array_filter($_FILES['new_eviden']['name']));
    }
    
    if (!empty($deleted_files) || $new_files_count > 0) {
        $changes[] = [
            'field' => 'eviden',
            'label' => 'File Evidence',
            'old_value' => count($old_eviden) . ' file(s)',
            'new_value' => count($existing_eviden) + $new_files_count . ' file(s)',
            'type' => 'text'
        ];
    }
    
    return $changes;
}

/* ================================
HELPER: CEK PERBEDAAN JABATAN & PERAN SAJA
================================= */
private function isDifferentDosenJabatanPeran($old_dosen, $new_dosen)
{
    if (count($old_dosen) !== count($new_dosen)) {
        return true;
    }
    
    // Bandingkan HANYA jabatan & peran
    foreach ($old_dosen as $index => $old) {
        if (!isset($new_dosen[$index])) {
            return true;
        }
        
        $new = $new_dosen[$index];
        
        // HANYA bandingkan Jabatan dan Peran (NIP, Nama, Divisi diabaikan karena readonly)
        if ($old['jabatan'] !== $new['jabatan'] || 
            $old['peran'] !== $new['peran']) {
            return true;
        }
    }
    
    return false;
}


    /* ================================
    HELPER: PROCESS EVIDEN FILES (reuse dari fungsi update_surat)
    ================================= */
    private function process_eviden_files($post, $surat)
    {
        $existing_eviden = json_decode($surat->eviden, true) ?: [];
        $deleted_files = $post['delete_eviden'] ?? [];

        // Remove deleted files
        foreach ($deleted_files as $del_file) {
            if ($del_file && trim($del_file) !== '') {
                $existing_eviden = array_filter($existing_eviden, function ($f) use ($del_file) {
                    return $f !== $del_file;
                });

                // Delete physical file
                if (!filter_var($del_file, FILTER_VALIDATE_URL)) {
                    $file_path = './uploads/eviden/' . $del_file;
                    if (file_exists($file_path)) {
                        @unlink($file_path);
                    }
                }
            }
        }

        // Upload new files
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
        return json_encode($final_eviden);
    }
    /* ================================
    HELPER: SAFE DATE (jika belum ada di controller)
    ================================= */
    private function safe_date($val)
    {
        if (!$val || trim($val) === "" || $val === "-") return "-";
        $ts = strtotime($val);
        return $ts ? date('Y-m-d', $ts) : "-";
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

        $allowed_status = ['disetujui kk'];
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
DOWNLOAD PDF UNTUK SEKRETARIAT - PERBAIKAN
================================= */
public function download_pdf($id)
{
    $surat = $this->Surat_model->get_by_id($id);

    if (!$surat) {
        show_404();
        return;
    }

    // Cek status surat
    $allowed_status = ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan'];
    if (!in_array(strtolower($surat->status), array_map('strtolower', $allowed_status))) {
        echo "<script>alert('Surat belum disetujui untuk didownload.'); window.close();</script>";
        return;
    }

    // Load data
    $data['surat'] = $surat;
    $data['dosen_data'] = $this->get_dosen_data_from_nip_fixed($surat->nip);
    $data['show_toolbar'] = false; // Hide toolbar di PDF
    
    // Load HTML content
    $html = $this->load->view('surat_print2', $data, TRUE);
    
    // PERBAIKAN: Gunakan DOMPDF
    require_once APPPATH . 'third_party/dompdf/autoload.inc.php';
    
    
    // Konfigurasi DOMPDF
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('isHtml5ParserEnabled', true);
    $options->set('defaultFont', 'Arial');
    
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    // Output PDF
    $filename = 'Surat_Tugas_' . ($surat->nomor_surat ?? $id) . '.pdf';
    $dompdf->stream($filename, array('Attachment' => 1));
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

        $getTime = function ($val) {
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

    // Update dengan timestamp
    $this->db->where("id", $id);
    $this->db->update("surat", [
        "disposisi_status" => $disposisi,
        "disposisi_catatan" => $catatan,
        "disposisi_updated_at" => date('Y-m-d H:i:s'), // TAMBAHAN BARU
    ]);

    echo json_encode(["success" => true]);
}   
    public function return_pengajuan($id)
    {
        $surat = $this->db->get_where('surat', ['id' => $id])->row();

        if (!$surat) {
            $this->session->set_flashdata('error', 'Surat tidak ditemukan.');
            $this->redirectToPreviousPage();
            return;
        }

        // Validasi: Hanya bisa return jika sudah disetujui/ditolak oleh Kaprodi
        $allowed_statuses = ['disetujui sekretariat', 'ditolak sekretariat'];

        if (!in_array($surat->status, $allowed_statuses)) {
            $this->session->set_flashdata('error', 'Hanya pengajuan yang sudah disetujui/ditolak Sekretariat yang dapat dikembalikan.');
            $this->redirectToPreviousPage();
            return;
        }

        // Cek apakah sudah disetujui oleh pihak selanjutnya (Sekretariat/Dekan)
        $approval = json_decode($surat->approval_status, true) ?? [];

        if (isset($approval['dekan'])) {
            $this->session->set_flashdata('error', 'Pengajuan tidak dapat dikembalikan karena sudah diproses oleh Dekan.');
            $this->redirectToPreviousPage();
            return;
        }

        // Update: Kembalikan ke status pengajuan & hapus approval Kaprodi
        if (isset($approval['sekretariat'])) {
            unset($approval['sekretariat']);
        }

        $this->db->where('id', $id)->update('surat', [
            'status' => 'disetujui KK',
            'approval_status' => json_encode($approval),
            'catatan_penolakan' => null, // Hapus catatan penolakan jika ada
            'disposisi_status' => 'none'
        ]);

        // Set flashdata untuk success return modal
        $surat = $this->db->get_where('surat', ['id' => $id])->row();
        
        $returned_items = [
            [
                'nama' => $surat->nama_kegiatan,
                'details' => "{$surat->penyelenggara} - " . date('d M Y', strtotime($surat->tanggal_kegiatan)),
                'new_status' => $surat->status
            ]
        ];
        
        $this->session->set_flashdata('returned_items', $returned_items);
        $this->session->set_flashdata('is_single_return', true);
        $this->redirectToPreviousPage();
    }
    public function ubah_pin()
    {
        $this->load->model('Setting_model');

        if ($this->input->post('pin')) {
            $pin = $this->input->post('pin');

            // Validasi: harus 6 digit angka
            if (!preg_match('/^[0-9]{6}$/', $pin)) {
                $this->session->set_flashdata('error', 'PIN harus 6 digit angka!');
                redirect('sekretariat/ubah_pin');
                return;
            }

            $this->Setting_model->update_pin($pin);
            $this->session->set_flashdata('success', 'PIN berhasil diperbarui!');
            redirect('sekretariat/ubah_pin');
            return;
        }
        $this->load->model('Setting_model');

        $pin_benar = $this->Setting_model->get_pin();
        $pin_input = $this->input->post('pin');

        if ($pin_input !== $pin_benar) {
            echo json_encode(['status' => 'error', 'message' => 'PIN salah!']);
            return;
        }

        $data['pin'] = $this->Setting_model->get_pin();
        $this->load->view('sekretariat/ubah_pin', $data);
    }
public function cek_pin()
{
    // Load model
    $this->load->model('Setting_model');

    // Set header JSON
    header('Content-Type: application/json');
    
    // Disable CodeIgniter output buffering untuk JSON
    $this->output->set_content_type('application/json');

    // Ambil raw input
    $raw_input = file_get_contents('php://input');
    $json = json_decode($raw_input, true);
    
    // Ambil PIN dari request
    $pin_input = isset($json['pin']) ? trim($json['pin']) : '';

    // Log untuk debugging
    log_message('debug', '=== PIN Check Request ===');
    log_message('debug', 'Raw Input: ' . $raw_input);
    log_message('debug', 'PIN Input: ' . $pin_input);

    // Validasi input tidak kosong
    if (empty($pin_input)) {
        echo json_encode([
            "status" => "error",
            "message" => "PIN tidak boleh kosong"
        ]);
        return;
    }

    // Validasi PIN harus 6 digit angka
    if (!preg_match('/^[0-9]{6}$/', $pin_input)) {
        echo json_encode([
            "status" => "error",
            "message" => "PIN harus 6 digit angka"
        ]);
        return;
    }

    // Ambil PIN dari database
    $pin_benar = $this->Setting_model->get_pin();

    // Log untuk debugging
    log_message('debug', 'PIN dari DB: ' . $pin_benar);
    log_message('debug', 'PIN Match: ' . (strval($pin_input) === strval($pin_benar) ? 'YES' : 'NO'));

    // Bandingkan PIN
    if (strval($pin_input) === strval($pin_benar)) {
        echo json_encode([
            "status" => "success",
            "message" => "PIN benar"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "PIN salah! Coba lagi."
        ]);
    }
}
public function updatePin()
{
    $this->load->model('Setting_model');

    $oldPin = $this->input->post('old_pin');
    $newPin = $this->input->post('new_pin');

    $currentPin = $this->Setting_model->getPin();

    if (!$currentPin) {
        echo json_encode(['status' => false, 'message' => 'PIN tidak ditemukan di database!']);
        return;
    }

    if ($oldPin !== $currentPin) {
        echo json_encode(['status' => false, 'message' => 'PIN lama salah!']);
        return;
    }

    if (!preg_match('/^[0-9]{6}$/', $newPin)) {
        echo json_encode(['status' => false, 'message' => 'PIN baru harus 6 digit angka!']);
        return;
    }

    $update = $this->Setting_model->updatePin($newPin);

    if ($update) {
        echo json_encode(['status' => true, 'message' => 'PIN berhasil diperbarui!']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Gagal memperbarui PIN!']);
    }
}
private function applyDivisiFilter($divisi_filter = null)
{
    if (!empty($divisi_filter)) {
        // Query terpisah menggunakan SQL langsung
        $query = $this->db->query("
            SELECT nip 
            FROM list_dosen 
            WHERE divisi = ?
        ", [$divisi_filter]);
        
        if ($query->num_rows() > 0) {
            $nip_list = [];
            foreach ($query->result() as $dosen) {
                $clean_nip = trim($dosen->nip);
                if (!empty($clean_nip)) {
                    $nip_list[] = $clean_nip;
                }
            }
            
            if (!empty($nip_list)) {
                // Buat WHERE condition untuk JSON array
                $this->db->group_start();
                
                foreach ($nip_list as $index => $nip) {
                    // Escape untuk keamanan
                    $safe_nip = $this->db->escape_str($nip);
                    
                    if ($index === 0) {
                        $this->db->like('nip', '"' . $safe_nip . '"');
                    } else {
                        $this->db->or_like('nip', '"' . $safe_nip . '"');
                    }
                }
                
                $this->db->group_end();
            } else {
                $this->db->where('1', '0');
            }
        } else {
            $this->db->where('1', '0');
        }
    }
}

public function debug_filter()
{
    $divisi = $this->input->get('divisi') ?? 'DI';
    
    echo "<h2>Debug Filter Divisi: $divisi</h2>";
    
    // 1. Cek dosen di divisi
    echo "<h3>1. Dosen di Divisi '$divisi':</h3>";
    
    // PERBAIKAN: Gunakan query SQL langsung
    $dosen_query = $this->db->query("
        SELECT nip, nama_dosen, divisi 
        FROM list_dosen 
        WHERE divisi = ?
    ", [$divisi]);
    
    echo "<pre>";
    if ($dosen_query->num_rows() > 0) {
        $nip_list = [];
        foreach ($dosen_query->result() as $d) {
            echo "NIP: {$d->nip} - Nama: {$d->nama_dosen} - Divisi: {$d->divisi}\n";
            $nip_list[] = $d->nip;
        }
    } else {
        echo "Tidak ada dosen di divisi ini!";
    }
    echo "</pre>";
    
    // 2. Cek format NIP di tabel surat
    if (!empty($nip_list)) {
        echo "<h3>2. Format NIP di Tabel Surat:</h3>";
        
        // PERBAIKAN: Query terpisah untuk surat
        $surat_query = $this->db->query("
            SELECT id, nip, nama_kegiatan, status 
            FROM surat 
            LIMIT 20
        ");
        
        echo "<table border='1' style='border-collapse:collapse;'>";
        echo "<tr><th>ID</th><th>NIP (Raw)</th><th>NIP (Decoded)</th><th>Nama Kegiatan</th><th>Match?</th></tr>";
        
        foreach ($surat_query->result() as $s) {
            $nip_decoded = json_decode($s->nip, true);
            $is_match = false;
            
            // Cek apakah ada NIP yang match
            if (is_array($nip_decoded)) {
                foreach ($nip_decoded as $nip_item) {
                    if (in_array(trim($nip_item), $nip_list)) {
                        $is_match = true;
                        break;
                    }
                }
            }
            
            $match_text = $is_match ? '<span style="color:green;">✓ MATCH</span>' : '<span style="color:red;">✗ NO MATCH</span>';
            
            echo "<tr>";
            echo "<td>{$s->id}</td>";
            echo "<td>" . htmlspecialchars($s->nip) . "</td>";
            echo "<td><pre>" . print_r($nip_decoded, true) . "</pre></td>";
            echo "<td>" . htmlspecialchars($s->nama_kegiatan) . "</td>";
            echo "<td>$match_text</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        
        // 3. Test query dengan filter
        echo "<h3>3. Test Query dengan Filter:</h3>";
        
        // PERBAIKAN: Reset query builder dan gunakan fresh query
        $this->db->reset_query();
        $this->db->select('surat.id, surat.nip, surat.nama_kegiatan, surat.status');
        $this->db->from('surat');
        $this->db->where_in('surat.status', ['disetujui KK', 'disetujui sekretariat', 'disetujui dekan', 'ditolak sekretariat', 'ditolak dekan']);
        
        // Apply filter
        $this->applyDivisiFilter($divisi);
        
        $filtered = $this->db->get();
        
        echo "<p><strong>Query:</strong> " . $this->db->last_query() . "</p>";
        echo "<p><strong>Hasil:</strong> " . $filtered->num_rows() . " baris ditemukan</p>";
        
        if ($filtered->num_rows() > 0) {
            echo "<table border='1' style='border-collapse:collapse;'>";
            echo "<tr><th>ID</th><th>NIP</th><th>Nama Kegiatan</th><th>Status</th></tr>";
            foreach ($filtered->result() as $f) {
                echo "<tr>";
                echo "<td>{$f->id}</td>";
                echo "<td>" . htmlspecialchars($f->nip) . "</td>";
                echo "<td>" . htmlspecialchars($f->nama_kegiatan) . "</td>";
                echo "<td>{$f->status}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
}
private function getDivisiList()
{
    // Cara 1: Menggunakan distinct() method (Recommended)
    $this->db->distinct();
    $this->db->select('divisi');
    $this->db->from('list_dosen');
    $this->db->where('divisi IS NOT NULL');
    $this->db->where('divisi !=', '');
    $this->db->where('divisi !=', '-');
    $this->db->order_by('divisi', 'ASC');
    $query = $this->db->get();
    
    $divisi_list = [];
    foreach ($query->result() as $row) {
        $divisi_list[] = $row->divisi;
    }
    
    return $divisi_list;
}
/* ================================
FUNGSI TAMBAH NOMOR SURAT (AJAX VERSION)
================================= */
public function tambah_nomor_surat_ajax($id)
{
    header('Content-Type: application/json');
    
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        return;
    }
    
    $nomor_surat = $this->input->post('nomor_surat');
    
    if (empty($nomor_surat)) {
        echo json_encode(['success' => false, 'message' => 'Nomor surat harus diisi!']);
        return;
    }
    
    // Cek apakah surat ada
    $surat = $this->db->get_where('surat', ['id' => $id])->row();
    
    if (!$surat) {
        echo json_encode(['success' => false, 'message' => 'Surat tidak ditemukan.']);
        return;
    }
    
    // Validasi: hanya untuk surat yang sudah disetujui dekan
    if (strtolower($surat->status) !== 'disetujui dekan') {
        echo json_encode(['success' => false, 'message' => 'Nomor surat hanya dapat diisi untuk surat yang sudah disetujui Dekan.']);
        return;
    }
    
    // Cek duplikasi nomor surat
    $this->db->where('nomor_surat', $nomor_surat);
    $this->db->where('id !=', $id);
    $existing = $this->db->get('surat')->row();
    
    if ($existing) {
        echo json_encode(['success' => false, 'message' => 'Nomor surat sudah digunakan! Silakan gunakan nomor lain.']);
        return;
    }
    
    // Update nomor surat
    $update_data = [
        'nomor_surat' => $nomor_surat,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    $result = $this->db->where('id', $id)->update('surat', $update_data);
    
    if ($result) {
        echo json_encode([
            'success' => true, 
            'message' => 'Nomor surat berhasil disimpan.',
            'nomor_surat' => $nomor_surat
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan nomor surat.']);
    }
}

/* ================================
GET DATA SURAT UNTUK MODAL NOMOR SURAT
================================= */
public function get_data_for_nomor_surat($id)
{
    header('Content-Type: application/json');
    
    $surat = $this->db->select('id, nama_kegiatan, status, nomor_surat')
                      ->from('surat')
                      ->where('id', $id)
                      ->get()
                      ->row();
    
    if (!$surat) {
        echo json_encode(['success' => false, 'message' => 'Surat tidak ditemukan.']);
        return;
    }
    
    echo json_encode([
        'success' => true,
        'data' => [
            'id' => $surat->id,
            'nama_kegiatan' => $surat->nama_kegiatan,
            'status' => $surat->status,
            'nomor_surat' => $surat->nomor_surat ?: ''
        ]
    ]);
}

/* ================================
FUNGSI CETAK SURAT (DENGAN VALIDASI NOMOR SURAT)
================================= */
public function cetak_surat($id)
{
    $surat = $this->Surat_model->get_by_id($id);
    
    if (!$surat) {
        show_404();
        return;
    }
    
    // Validasi: surat harus sudah disetujui dekan
    if (strtolower($surat->status) !== 'disetujui dekan') {
        $this->session->set_flashdata('error', 'Surat belum disetujui Dekan untuk dicetak.');
        redirect('sekretariat');
        return;
    }
    
    // Validasi: nomor surat harus sudah terisi
    if (empty($surat->nomor_surat) || $surat->nomor_surat === '-' || $surat->nomor_surat === 'null') {
        $this->session->set_flashdata('error', 'Nomor surat belum diisi. Silakan isi nomor surat terlebih dahulu.');
        redirect('sekretariat');
        return;
    }
    
    $data['surat'] = $surat;
    $data['dosen_data'] = $this->get_dosen_data_from_nip_fixed($surat->nip);
    
    // Load view cetak
    $this->load->view('sekretariat/cetak_surat', $data);
}

/* ================================
DOWNLOAD PDF (DENGAN VALIDASI NOMOR SURAT)
================================= */
public function download_pdf_final($id)
{
    $surat = $this->Surat_model->get_by_id($id);
    
    if (!$surat) {
        show_404();
        return;
    }
    
    // Validasi: surat harus sudah disetujui dekan
    if (strtolower($surat->status) !== 'disetujui dekan') {
        echo "<script>alert('Surat belum disetujui Dekan untuk didownload.'); window.close();</script>";
        return;
    }
    
    // Validasi: nomor surat harus sudah terisi
    if (empty($surat->nomor_surat) || $surat->nomor_surat === '-' || $surat->nomor_surat === 'null') {
        echo "<script>alert('Nomor surat belum diisi. Silakan isi nomor surat terlebih dahulu.'); window.close();</script>";
        return;
    }
    
    $data['surat'] = $surat;
    $data['dosen_data'] = $this->get_dosen_data_from_nip_fixed($surat->nip);
    $data['show_toolbar'] = false;
    
    // Load HTML content
    $html = $this->load->view('surat_print_final', $data, TRUE);
    
    // Generate PDF
    require_once APPPATH . 'third_party/dompdf/autoload.inc.php';
    
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('isHtml5ParserEnabled', true);
    $options->set('defaultFont', 'Arial');
    
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    // Output PDF
    $filename = 'Surat_Tugas_' . $surat->nomor_surat . '.pdf';
    $dompdf->stream($filename, array('Attachment' => 1));
}
}
