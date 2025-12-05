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

    /* ================================
       DASHBOARD
    ================================= */
    public function index($filter = 'all')
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $search = $this->input->get('search');
        $status_filter = $this->input->get('status');
        
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['current_filter'] = $filter;

        // Hanya ambil data yang relevan untuk dekan
        $this->db->where('YEAR(created_at)', $tahun);
        
        // Filter bulan jika dipilih
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        
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

        // Statistik untuk card (dengan filter bulan)
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        // Approved count
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['approved_count'] = $this->db->where('status', 'disetujui dekan')
                                          ->count_all_results('surat');

        // Pending count
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['pending_count'] = $this->db->where('status', 'disetujui sekretariat')
                                         ->count_all_results('surat');

        // Rejected count
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['rejected_count'] = $this->db->where('status', 'ditolak dekan')
                                          ->count_all_results('surat');

        // Grafik data - dengan dukungan filter bulan
        $total     = array_fill(0, 12, 0);
        $approved  = array_fill(0, 12, 0);
        $rejected  = array_fill(0, 12, 0);

        if ($bulan === 'all') {
            // Jika semua bulan, ambil data 12 bulan
            for ($i = 1; $i <= 12; $i++) {
                $total[$i-1] = $this->countByMonthYear($i, $tahun);
                $approved[$i-1] = $this->countApprovedByMonthYear($i, $tahun);
                $rejected[$i-1] = $this->countRejectedByMonthYear($i, $tahun);
            }
        } else {
            // Jika filter bulan spesifik, isi hanya bulan tersebut
            $bulan_int = (int)$bulan;
            for ($i = 1; $i <= 12; $i++) {
                if ($i == $bulan_int) {
                    $total[$i-1] = $this->countByMonthYear($i, $tahun);
                    $approved[$i-1] = $this->countApprovedByMonthYear($i, $tahun);
                    $rejected[$i-1] = $this->countRejectedByMonthYear($i, $tahun);
                } else {
                    $total[$i-1] = 0;
                    $approved[$i-1] = 0;
                    $rejected[$i-1] = 0;
                }
            }
        }

        $data['chart_total']    = $total;
        $data['chart_approved'] = $approved;
        $data['chart_rejected'] = $rejected;

        $this->load->view('dekan/dashboard', $data);
    }

    /* ================================
       HELPER FUNCTIONS UNTUK COUNT DATA PER BULAN
    ================================= */
    private function countByMonthYear($month, $year)
    {
        $this->db->where('YEAR(created_at)', $year);
        $this->db->where('MONTH(created_at)', $month);
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        return $this->db->count_all_results('surat');
    }

    private function countApprovedByMonthYear($month, $year)
    {
        $this->db->where('YEAR(created_at)', $year);
        $this->db->where('MONTH(created_at)', $month);
        $this->db->where('status', 'disetujui dekan');
        return $this->db->count_all_results('surat');
    }

    private function countRejectedByMonthYear($month, $year)
    {
        $this->db->where('YEAR(created_at)', $year);
        $this->db->where('MONTH(created_at)', $month);
        $this->db->where('status', 'ditolak dekan');
        return $this->db->count_all_results('surat');
    }

    /* ================================
       PENDING (Status Disetujui Sekretariat)
    ================================= */
    public function halaman_pending()
    {
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

        // Statistik (dengan filter bulan)
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['approved_count'] = $this->db->where('status', 'disetujui dekan')
                                          ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['pending_count'] = $this->db->where('status', 'disetujui sekretariat')
                                         ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['rejected_count'] = $this->db->where('status', 'ditolak dekan')
                                          ->count_all_results('surat');

        $this->load->view('dekan/halaman_pending', $data);
    }

    /* ================================
       DISETUJUI 
    ================================= */
    public function halaman_disetujui()
    {
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

        // Statistik (dengan filter bulan)
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['approved_count'] = $this->db->where('status', 'disetujui dekan')
                                          ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['pending_count'] = $this->db->where('status', 'disetujui sekretariat')
                                         ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['rejected_count'] = $this->db->where('status', 'ditolak dekan')
                                          ->count_all_results('surat');

        $this->load->view('dekan/halaman_disetujui', $data);
    }

    /* ================================
       DITOLAK
    ================================= */
    public function halaman_ditolak()
    {
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

        // Statistik (dengan filter bulan)
        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['approved_count'] = $this->db->where('status', 'disetujui dekan')
                                          ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['pending_count'] = $this->db->where('status', 'disetujui sekretariat')
                                         ->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $data['rejected_count'] = $this->db->where('status', 'ditolak dekan')
                                          ->count_all_results('surat');

        $this->load->view('dekan/halaman_ditolak', $data);
    }

/* ================================
   TOTAL SEMUA PENGAJUAN - VERSI DIPERBAIKI
================================= */
public function halaman_total()
{
    $tahun = $this->input->get('tahun') ?? date('Y');
    $bulan = $this->input->get('bulan') ?? 'all';
    $search = $this->input->get('search');
    $status = $this->input->get('status');
    $jenis_penugasan = $this->input->get('jenis_penugasan');
    
    $data['tahun'] = $tahun;
    $data['bulan'] = $bulan;
    $data['current_page'] = 'total';
    $data['jenis_penugasan'] = $jenis_penugasan;
    
    // Query dasar
    $this->db->select('*');
    $this->db->from('surat');
    $this->db->where('YEAR(created_at)', $tahun);
    
    if ($bulan !== 'all') {
        $this->db->where('MONTH(created_at)', $bulan);
    }
    
    // Filter status
    $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
    
    if ($status) {
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
    
    // Filter search
    if ($search) {
        $this->db->group_start();
        $this->db->like('nama_kegiatan', $search);
        $this->db->or_like('penyelenggara', $search);
        $this->db->or_like('nip', $search);
        $this->db->or_like('nama_dosen', $search);
        $this->db->group_end();
    }
    
    $this->db->order_by('created_at', 'DESC');
    $query = $this->db->get();
    $all_data = $query->result_array();
    
    // Filter berdasarkan jenis penugasan dengan logika yang lebih baik
    $data['surat_list'] = [];
    $perorangan_count = 0;
    $kelompok_count = 0;
    
    foreach ($all_data as $surat) {
        $nip = trim($surat['nip'] ?? '');
        $nama_dosen = trim($surat['nama_dosen'] ?? '');
        $jenis_pengajuan = strtolower(trim($surat['jenis_pengajuan'] ?? ''));
        
        // Deteksi jenis penugasan - LOGIKA YANG DIOPTIMASI
        $is_kelompok = false;
        
        // Cek 1: Apakah field jenis_pengajuan sudah ada dan jelas
        if (!empty($jenis_pengajuan)) {
            if (strpos($jenis_pengajuan, 'kelompok') !== false || 
                strpos($jenis_pengajuan, 'tim') !== false ||
                strpos($jenis_pengajuan, 'group') !== false ||
                strpos($jenis_pengajuan, 'multiple') !== false ||
                strpos($jenis_pengajuan, 'banyak') !== false) {
                $is_kelompok = true;
            }
        }
        
        // Cek 2: Analisis NIP jika jenis_pengajuan tidak jelas
        if (!$is_kelompok && !empty($nip)) {
            // Hapus karakter tidak penting
            $nip_clean = preg_replace('/[\[\]\{\}]/', '', $nip);
            
            // Deteksi multiple NIP
            // Cek koma (pemisah NIP)
            if (strpos($nip_clean, ',') !== false) {
                // Pecah berdasarkan koma
                $nip_parts = explode(',', $nip_clean);
                $valid_nip_count = 0;
                
                foreach ($nip_parts as $part) {
                    $clean_part = trim($part);
                    // Jika bagian terlihat seperti NIP (panjang minimal 6 angka)
                    if (preg_match('/^\d{6,}$/', $clean_part)) {
                        $valid_nip_count++;
                    }
                }
                
                // Jika ada lebih dari 1 NIP valid, anggap kelompok
                if ($valid_nip_count > 1) {
                    $is_kelompok = true;
                }
            }
            // Cek format JSON tanpa tanda baca
            elseif (strlen($nip) > 15) {
                // Cek apakah NIP sangat panjang (mungkin berisi multiple NIP tanpa pemisah jelas)
                // Atau cek pola "nip1nip2nip3"
                if (preg_match('/(\d{18,})/', $nip) || strlen($nip) > 30) {
                    $is_kelompok = true;
                }
            }
        }
        
        // Cek 3: Analisis nama dosen
        if (!$is_kelompok && !empty($nama_dosen)) {
            // Hapus karakter tidak penting
            $nama_clean = preg_replace('/[\[\]\{\}]/', '', $nama_dosen);
            
            // Cek koma atau kata kunci "dan", "&"
            if (strpos($nama_clean, ',') !== false ||
                strpos($nama_clean, ' dan ') !== false ||
                strpos($nama_clean, ' & ') !== false ||
                strpos(strtolower($nama_clean), 'dr.') !== false && strpos($nama_clean, ',') !== false) {
                
                // Hitung kemungkinan jumlah nama
                $nama_count = 0;
                if (strpos($nama_clean, ',') !== false) {
                    $nama_parts = explode(',', $nama_clean);
                    foreach ($nama_parts as $part) {
                        if (str_word_count(trim($part)) >= 2) { // Minimal 2 kata per nama
                            $nama_count++;
                        }
                    }
                }
                
                if ($nama_count > 1) {
                    $is_kelompok = true;
                }
            }
        }
        
        // Cek 4: Fallback - lihat field lain yang mungkin indikator
        if (!$is_kelompok) {
            // Cek field lain seperti jumlah_dosen jika ada
            if (isset($surat['jumlah_dosen']) && $surat['jumlah_dosen'] > 1) {
                $is_kelompok = true;
            }
            // Cek field nama_kegiatan untuk kata kunci tim/kelompok
            elseif (isset($surat['nama_kegiatan'])) {
                $nama_kegiatan_lower = strtolower($surat['nama_kegiatan']);
                if (strpos($nama_kegiatan_lower, 'tim ') === 0 ||
                    strpos($nama_kegiatan_lower, 'kelompok ') === 0 ||
                    strpos($nama_kegiatan_lower, 'team ') === 0) {
                    $is_kelompok = true;
                }
            }
        }
        
        // Hitung statistik
        if ($is_kelompok) {
            $kelompok_count++;
        } else {
            $perorangan_count++;
        }
        
        // Terapkan filter
        $include = true;
        if ($jenis_penugasan) {
            if ($jenis_penugasan == 'perorangan' && $is_kelompok) {
                $include = false;
            } elseif ($jenis_penugasan == 'kelompok' && !$is_kelompok) {
                $include = false;
            }
        }
        
        if ($include) {
            $data['surat_list'][] = $surat;
        }
    }
    
    // Hitung statistik
    $data['total_surat'] = count($data['surat_list']);
    
    // Hitung berdasarkan status
    $data['approved_count'] = 0;
    $data['pending_count'] = 0;
    $data['rejected_count'] = 0;
    
    foreach ($data['surat_list'] as $surat) {
        switch ($surat['status']) {
            case 'disetujui dekan':
                $data['approved_count']++;
                break;
            case 'disetujui sekretariat':
                $data['pending_count']++;
                break;
            case 'ditolak dekan':
                $data['rejected_count']++;
                break;
        }
    }
    
    // DEBUG: Kirim data statistik ke view
    $data['debug_info'] = [
        'total_data' => count($all_data),
        'filtered_data' => count($data['surat_list']),
        'perorangan_detected' => $perorangan_count,
        'kelompok_detected' => $kelompok_count,
        'filter_applied' => $jenis_penugasan
    ];
    
    $this->load->view('dekan/halaman_total', $data);
}
    /* ================================
       FUNGSI UNTUK MENDAPATKAN PROGRESS TIMELINE - BARU
    ================================= */
    private function getProgressTimeline($id)
    {
        $this->db->where('id', $id);
        $surat = $this->db->get('surat')->row();
        
        if (!$surat) {
            return null;
        }
        
        $approval = json_decode($surat->approval_status, true) ?? [];
        
        // Default timeline structure
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
       FORMAT DISPLAY TIME - BARU
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

    public function approve($id)
    {
        // Generate nomor surat otomatis jika tidak diisi
        $nomor_surat = $this->input->post('nomor_surat');
        if (empty($nomor_surat)) {
            $nomor_surat = $this->generate_nomor_surat_dekan();
        }

        $surat = $this->db->get_where('surat', ['id' => $id])->row();
        if (!$surat) {
            $this->session->set_flashdata('error', 'Data surat tidak ditemukan');
            redirect('dekan/dashboard');
            return;
        }

        // Validasi status - lebih fleksibel
        $allowed_statuses = ['disetujui sekretariat', 'pending', 'menunggu persetujuan dekan'];
        
        if (!in_array($surat->status, $allowed_statuses)) {
            $this->session->set_flashdata('error', 'Status pengajuan tidak dapat diproses. Status saat ini: ' . $surat->status);
            redirect('dekan/dashboard');
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
        if (!isset($approval['sekretariat'])) {
            $approval['sekretariat'] = date("Y-m-d H:i:s", strtotime($surat->created_at . ' +2 hours'));
        }
        
        $approval['dekan'] = date("Y-m-d H:i:s");
        
        $update_data = [
            'status' => 'disetujui dekan',
            'nomor_surat' => $nomor_surat,
            'approval_status' => json_encode($approval),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->db->where('id', $id)->update('surat', $update_data);

        if ($result) {
            // PERBAIKAN UTAMA: Siapkan data untuk success modal
            $approved_items = [[
                'nama' => $surat->nama_kegiatan,
                'details' => '📅 ' . date('d M Y', strtotime($surat->tanggal_kegiatan)) . ' | 📍 ' . $surat->penyelenggara
            ]];
            
            // Set flashdata untuk success modal
            $this->session->set_flashdata('approved_items', $approved_items);
            $this->session->set_flashdata('is_single_approve', true);
            $this->session->set_flashdata('success', 'Surat berhasil disetujui oleh Dekan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyetujui surat.');
        }
        
        redirect('dekan/dashboard');
    }

    /* ================================
       REJECT - VERSI DIPERBAIKI DENGAN PROGRESS BAR
    ================================= */
    public function reject($id)
    {
        $notes = $this->input->post('rejection_notes');
        if (empty($notes)) {
            $this->session->set_flashdata('error', 'Alasan penolakan harus diisi');
            redirect('dekan');
        }

        $surat = $this->db->get_where('surat', ['id' => $id])->row();
        if (!$surat) {
            $this->session->set_flashdata('error', 'Data surat tidak ditemukan');
            redirect('dekan');
        }

        // Validasi status - lebih fleksibel
        $allowed_statuses = ['disetujui sekretariat', 'pending', 'menunggu persetujuan dekan'];
        
        if (!in_array($surat->status, $allowed_statuses)) {
            $this->session->set_flashdata('error', 'Status pengajuan tidak dapat diproses. Status saat ini: ' . $surat->status);
            redirect('dekan');
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
        if (!isset($approval['sekretariat'])) {
            $approval['sekretariat'] = date("Y-m-d H:i:s", strtotime($surat->created_at . ' +2 hours'));
        }
        
        $approval['dekan'] = date("Y-m-d H:i:s");

        $update_data = [
            'status' => 'ditolak dekan',
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

    public function process_multi_approve()
    {
        if ($this->input->post()) {
            $selected_ids = $this->input->post('selected_ids');
            
            if (empty($selected_ids)) {
                $this->session->set_flashdata('error', 'Tidak ada pengajuan yang dipilih');
                redirect('dekan/halaman_pending');
                return;
            }
            
            $success_count = 0;
            $error_count = 0;
            $errors = [];
            $approved_items = []; // TAMBAHAN: Array untuk menyimpan data yang disetujui
            
            foreach ($selected_ids as $id) {
                $surat = $this->db->get_where('surat', ['id' => $id])->row();
                
                if ($surat) {
                    // Validasi status yang lebih fleksibel
                    $allowed_statuses = ['disetujui sekretariat', 'pending', 'menunggu persetujuan dekan'];
                    
                    if (!in_array($surat->status, $allowed_statuses)) {
                        $error_count++;
                        $errors[] = "ID $id: Status tidak valid ($surat->status)";
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
                    if (!isset($approval['sekretariat'])) {
                        $approval['sekretariat'] = date("Y-m-d H:i:s", strtotime($surat->created_at . ' +2 hours'));
                    }
                    
                    $approval['dekan'] = date("Y-m-d H:i:s");
                    
                    $result = $this->db->where('id', $id)->update('surat', [
                        'status' => 'disetujui dekan',
                        'nomor_surat' => $this->generate_nomor_surat_dekan(),
                        'approval_status' => json_encode($approval),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    
                    if ($result) {
                        $success_count++;
                        
                        // TAMBAHAN: Simpan data yang berhasil disetujui
                        $approved_items[] = [
                            'nama' => $surat->nama_kegiatan,
                            'details' => '📅 ' . date('d M Y', strtotime($surat->tanggal_kegiatan)) . ' | 📍 ' . $surat->penyelenggara
                        ];
                    } else {
                        $error_count++;
                        $errors[] = "ID $id: Gagal update database";
                    }
                } else {
                    $error_count++;
                    $errors[] = "ID $id: Data tidak ditemukan";
                }
            }
            
            if ($success_count > 0) {
                $message = "Berhasil menyetujui $success_count pengajuan";
                if ($error_count > 0) {
                    $message .= ". Gagal: $error_count pengajuan";
                }
                
                // PERBAIKAN UTAMA: Set flashdata untuk success modal
                $this->session->set_flashdata('approved_items', $approved_items);
                $this->session->set_flashdata('is_single_approve', false);
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

    /* ================================
       BULK REJECT - DIPERBAIKI DENGAN PROGRESS BAR
    ================================= */
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
            $errors = [];
            
            foreach ($selected_ids as $index => $id) {
                $surat = $this->db->get_where('surat', ['id' => $id])->row();
                
                if ($surat) {
                    // Validasi status yang lebih fleksibel
                    $allowed_statuses = ['disetujui sekretariat', 'pending', 'menunggu persetujuan dekan'];
                    
                    if (!in_array($surat->status, $allowed_statuses)) {
                        $error_count++;
                        $errors[] = "ID $id: Status tidak valid ($surat->status)";
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
                    if (!isset($approval['sekretariat'])) {
                        $approval['sekretariat'] = date("Y-m-d H:i:s", strtotime($surat->created_at . ' +2 hours'));
                    }
                    
                    $approval['dekan'] = date("Y-m-d H:i:s");

                    // Handle rejection notes
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
                        $errors[] = "ID $id: Gagal update database";
                    }
                } else {
                    $error_count++;
                    $errors[] = "ID $id: Data tidak ditemukan";
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

    /* ================================
       HELPER FUNCTION UNTUK REDIRECT
    ================================= */
    private function redirectToPreviousPage()
    {
        $current_page = $this->input->get('from') ?? 'dekan';
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';
        $search = $this->input->get('search');
        $status = $this->input->get('status');
        $jenis_penugasan = $this->input->get('jenis_penugasan'); // TAMBAHAN: Filter jenis penugasan
        
        $query_params = 'tahun=' . $tahun . '&bulan=' . $bulan;
        if (!empty($search)) {
            $query_params .= '&search=' . urlencode($search);
        }
        if (!empty($status)) {
            $query_params .= '&status=' . $status;
        }
        if (!empty($jenis_penugasan)) {
            $query_params .= '&jenis_penugasan=' . $jenis_penugasan;
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

    /* ================================
       HELPER FUNCTION UNTUK GENERATE NOMOR SURAT
    ================================= */
    private function generate_nomor_surat_dekan()
    {
        $this->load->helper('string');
        $year = date('Y');
        $random = random_string('numeric', 4);
        return "{$random}/SK/FT/{$year}";
    }

    /* ================================
       REALTIME DASHBOARD COUNTER
    ================================= */
    public function get_dashboard_counts()
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $bulan = $this->input->get('bulan') ?? 'all';

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $total = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where('status', 'disetujui sekretariat');
        $pending = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
        $this->db->where('status', 'disetujui dekan');
        $approved = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        if ($bulan !== 'all') {
            $this->db->where('MONTH(created_at)', $bulan);
        }
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
        
        echo "<h1>Debug Data Dosen - Dekan</h1>";
        
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
       TAMPILKAN SURAT PENGAJUAN DALAM MODAL - DIPERBAIKI
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
       GET EVIDEN - UNTUK TOMBOL LIHAT EVIDEN
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
/* ================================
   DEBUG DATA - UNTUK TROUBLESHOOTING
================================= */
/* ================================
   DEBUG FILTER JENIS PENUGASAN
================================= */
public function debug_filter_jenis_penugasan()
{
    $tahun = date('Y');
    $jenis_penugasan = $this->input->get('jenis') ?? 'perorangan';
    
    echo "<h1>Debug Filter Jenis Penugasan: $jenis_penugasan</h1>";
    
    // Ambil semua data
    $this->db->select('id, nama_kegiatan, nip, nama_dosen');
    $this->db->where('YEAR(created_at)', $tahun);
    $all_data = $this->db->get('surat')->result_array();
    
    echo "<h2>Semua Data (" . count($all_data) . ")</h2>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Nama Kegiatan</th><th>NIP</th><th>Nama Dosen</th><th>Jenis Deteksi</th></tr>";
    
    $perorangan_count = 0;
    $kelompok_count = 0;
    
    foreach ($all_data as $row) {
        $nip = $row['nip'] ?? '';
        $nama_dosen = $row['nama_dosen'] ?? '';
        
        // Deteksi
        $is_kelompok = false;
        
        if (strpos($nip, ',') !== false) {
            $is_kelompok = true;
        } elseif (strpos($nip, '[') !== false && strpos($nip, ']') !== false) {
            $is_kelompok = true;
        } elseif (strpos($nama_dosen, ',') !== false) {
            $is_kelompok = true;
        } elseif (strpos($nama_dosen, '[') !== false && strpos($nama_dosen, ']') !== false) {
            $is_kelompok = true;
        }
        
        $jenis_deteksi = $is_kelompok ? 'kelompok' : 'perorangan';
        
        if ($is_kelompok) {
            $kelompok_count++;
        } else {
            $perorangan_count++;
        }
        
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>" . htmlspecialchars($row['nama_kegiatan']) . "</td>";
        echo "<td>" . htmlspecialchars(substr($nip, 0, 50)) . "</td>";
        echo "<td>" . htmlspecialchars(substr($nama_dosen, 0, 50)) . "</td>";
        echo "<td>{$jenis_deteksi}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h2>Statistik:</h2>";
    echo "<p>Perorangan: $perorangan_count</p>";
    echo "<p>Kelompok: $kelompok_count</p>";
    
    // Test dengan filter
    echo "<h2>Test Filter untuk '$jenis_penugasan':</h2>";
    
    $filtered = [];
    foreach ($all_data as $row) {
        $nip = $row['nip'] ?? '';
        $nama_dosen = $row['nama_dosen'] ?? '';
        
        $is_kelompok = false;
        
        if (strpos($nip, ',') !== false) {
            $is_kelompok = true;
        } elseif (strpos($nip, '[') !== false && strpos($nip, ']') !== false) {
            $is_kelompok = true;
        } elseif (strpos($nama_dosen, ',') !== false) {
            $is_kelompok = true;
        } elseif (strpos($nama_dosen, '[') !== false && strpos($nama_dosen, ']') !== false) {
            $is_kelompok = true;
        }
        
        if ($jenis_penugasan == 'perorangan' && !$is_kelompok) {
            $filtered[] = $row;
        } elseif ($jenis_penugasan == 'kelompok' && $is_kelompok) {
            $filtered[] = $row;
        }
    }
    
    echo "<p>Jumlah setelah filter: " . count($filtered) . "</p>";
}
}
