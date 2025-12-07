<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;

class Surat extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Surat_model');
        $this->load->helper(['file', 'url']);
        $this->load->library('session');
        $this->load->database();
    }

    /* ===========================================
       FORMAT TANGGAL AMAN
    ============================================*/
    private function safe_date($val)
    {
        if (!$val || trim($val) === "" || $val === "-") return "-";
        $ts = strtotime($val);
        return $ts ? date('Y-m-d', $ts) : "";
    }

    /* ===========================================
       SAFE JSON DECODE
    ============================================*/
    private function safe_json_decode($json)
    {
        if (is_array($json)) return $json;
        if (!is_string($json)) return [];
        $decoded = json_decode($json, true);
        return (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : [];
    }

    // Helper function untuk get dosen by NIP - FIXED VERSION
    private function get_dosen_by_nip($nip_data) {
        // Handle berbagai tipe data input
        if (empty($nip_data)) {
            return [];
        }
        
        $nip_array = [];
        
        // Jika sudah array, langsung gunakan
        if (is_array($nip_data)) {
            $nip_array = $nip_data;
        } 
        // Jika string JSON, decode
        elseif (is_string($nip_data) && $nip_data !== '[]' && $nip_data !== '-') {
            $decoded = json_decode($nip_data, true);
            $nip_array = is_array($decoded) ? $decoded : [];
        }
        
        if (empty($nip_array)) {
            return [];
        }
        
        $dosen_data = [];
        
        foreach ($nip_array as $nip) {
            if (!empty($nip) && $nip !== '-') {
                // Cari dosen berdasarkan NIP dari tabel list_dosen
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
                    // Fallback jika tidak ditemukan di list_dosen
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

    /* ===========================================
       AUTOCOMPLETE NIP - UNTUK FORM PANITIA
    ============================================*/
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

    /* ===========================================
       LIST DATA - DEFAULT (UPDATED)
    ============================================*/
    public function index()
    {
        $data['surat_list'] = $this->Surat_model->get_all_surat();
        
        // TAMBAHAN: Enrich data dengan informasi dosen dari list_dosen
        foreach ($data['surat_list'] as &$surat) {
            $surat->dosen_data = $this->get_dosen_by_nip($surat->nip);
        }
        
        $this->load->view('surat', $data);
    }

    /* ===========================================
       HALAMAN STATS GRID - TOTAL (UPDATED)
    ============================================*/
    public function halaman_total()
    {
        $data['surat_list'] = $this->Surat_model->get_all_surat();
        
        // TAMBAHAN: Enrich data dengan informasi dosen
        foreach ($data['surat_list'] as &$surat) {
            $surat->dosen_data = $this->get_dosen_by_nip($surat->nip);
        }
        
        $data['title'] = 'Semua Surat';
        $data['page_type'] = 'total';
        $this->load->view('halaman_total', $data);
    }

    /* ===========================================
       HALAMAN STATS GRID - PENDING (UPDATED)
    ============================================*/
    public function halaman_pending()
    {
        $data['surat_list'] = $this->Surat_model->get_by_status('pengajuan');
        
        // TAMBAHAN: Enrich data dengan informasi dosen
        foreach ($data['surat_list'] as &$surat) {
            $surat->dosen_data = $this->get_dosen_by_nip($surat->nip);
        }
        
        $data['title'] = 'Surat Pending';
        $data['page_type'] = 'pending';
        $this->load->view('halaman_pending', $data);
    }

    /* ===========================================
       HALAMAN STATS GRID - DITOLAK (UPDATED)
    ============================================*/
    public function halaman_ditolak()
    {
        $data['surat_list'] = $this->Surat_model->get_ditolak();
        
        // TAMBAHAN: Enrich data dengan informasi dosen
        foreach ($data['surat_list'] as &$surat) {
            $surat->dosen_data = $this->get_dosen_by_nip($surat->nip);
        }
        
        $data['title'] = 'Surat Ditolak';
        $data['page_type'] = 'ditolak';
        $this->load->view('halaman_ditolak', $data);
    }

    /* ===========================================
       HALAMAN STATS GRID - DISETUJUI (UPDATED)
    ============================================*/
    public function halaman_disetujui()
    {
        $data['surat_list'] = $this->Surat_model->get_disetujui();
        
        // TAMBAHAN: Enrich data dengan informasi dosen
        foreach ($data['surat_list'] as &$surat) {
            $surat->dosen_data = $this->get_dosen_by_nip($surat->nip);
        }
        
        $data['title'] = 'Surat Disetujui';
        $data['page_type'] = 'disetujui';
        $this->load->view('halaman_disetujui', $data);
    }

    /* ===========================================
       GET STATUS - WITH APPROVAL STATUS JSON
    ============================================*/
    public function get_status($surat_id)
    {
        header('Content-Type: application/json');
        
        // Ambil data surat
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

        // Ambil waktu persetujuan / penolakan
        $getTime = function($val) {
            if (!$val) return null;

            if (is_string($val)) return $val; // approved → datetime string
            if (is_array($val) && isset($val['waktu'])) return $val['waktu']; // rejected → ambil waktu penolakan

            return null;
        };

        $kk  = $getTime($approval['kk'] ?? null);
        $sek = $getTime($approval['sekretariat'] ?? null);
        $dek = $getTime($approval['dekan'] ?? null);

        // Normalisasi status
        $status = strtolower(trim($surat->status ?? 'pengajuan'));
        $catatan_penolakan = $surat->catatan_penolakan ?? null;
        $created_at = $surat->created_at;

        $steps = [];
        $progress_percentage = 0;

        // Step pertama: Mengirim
        $steps[] = [
            'step_name' => 'Mengirim',
            'status' => 'completed',
            'date' => date('d M Y', strtotime($created_at)),
            'label' => 'Terkirim'
        ];

        // Tentukan steps berdasarkan status
        switch ($status) {

            case 'pengajuan':
                $steps[] = ['step_name'=>'Dalam Proses','status'=>'in-progress','date'=>'-','label'=>'Dalam Proses'];
                $steps[] = ['step_name'=>'Menunggu','status'=>'pending','date'=>'-','label'=>'Menunggu'];
                $steps[] = ['step_name'=>'Menunggu','status'=>'pending','date'=>'-','label'=>'Menunggu'];
                $progress_percentage = 35;
                break;

            case 'disetujui kk':
                $steps[] = [
                    'step_name'=>'Disetujui Kaprodi',
                    'status'=>'completed',
                    'date'=> ($kk) ? date('d M Y', strtotime($kk)) : '-',
                    'label'=>'Disetujui'
                ];
                $steps[] = ['step_name'=>'Dalam Proses','status'=>'in-progress','date'=>'-','label'=>'Dalam Proses'];
                $steps[] = ['step_name'=>'Menunggu','status'=>'pending','date'=>'-','label'=>'Menunggu'];
                $progress_percentage = 65;
                break;

            case 'disetujui sekretariat':
                $steps[] = [
                    'step_name'=>'Disetujui Kaprodi',
                    'status'=>'completed',
                    'date'=> ($kk) ? date('d M Y', strtotime($kk)) : '-',
                    'label'=>'Disetujui'
                ];
                $steps[] = [
                    'step_name'=>'Disetujui Sekretariat',
                    'status'=>'completed',
                    'date'=> ($sek) ? date('d M Y', strtotime($sek)) : '-',
                    'label'=>'Disetujui'
                ];
                $steps[] = ['step_name'=>'Dalam Proses','status'=>'in-progress','date'=>'-','label'=>'Dalam Proses'];
                $progress_percentage = 95;
                break;

            case 'disetujui dekan':
            case 'selesai':
            case 'completed':
                $steps[] = [
                    'step_name'=>'Disetujui Kaprodi',
                    'status'=>'completed',
                    'date'=> ($kk) ? date('d M Y', strtotime($kk)) : '-',
                    'label'=>'Disetujui'
                ];
                $steps[] = [
                    'step_name'=>'Disetujui Sekretariat',
                    'status'=>'completed',
                    'date'=> ($sek) ? date('d M Y', strtotime($sek)) : '-',
                    'label'=>'Disetujui'
                ];
                $steps[] = [
                    'step_name'=>'Disetujui Dekan',
                    'status'=>'completed',
                    'date'=> ($dek) ? date('d M Y', strtotime($dek)) : '-',
                    'label'=>'Disetujui'
                ];
                $progress_percentage = 80;
                break;

            case 'ditolak kk':
                $steps[] = [
                    'step_name'=>'Ditolak Kaprodi',
                    'status'=>'rejected',
                    'date'=> ($kk) ? date('d M Y', strtotime($kk)) : '-',
                    'label'=>'Ditolak',
                    'catatan_penolakan'=>$catatan_penolakan
                ];
                $steps[] = ['step_name'=>'Menunggu','status'=>'pending','date'=>'-','label'=>'Menunggu'];
                $steps[] = ['step_name'=>'Menunggu','status'=>'pending','date'=>'-','label'=>'Menunggu'];
                $progress_percentage = 35;
                break;

            case 'ditolak sekretariat':
                $steps[] = [
                    'step_name'=>'Disetujui Kaprodi',
                    'status'=>'completed',
                    'date'=> ($kk) ? date('d M Y', strtotime($kk)) : '-',
                    'label'=>'Disetujui'
                ];
                $steps[] = [
                    'step_name'=>'Ditolak Sekretariat',
                    'status'=>'rejected',
                    'date'=> ($sek) ? date('d M Y', strtotime($sek)) : '-',
                    'label'=>'Ditolak',
                    'catatan_penolakan'=>$catatan_penolakan
                ];
                $steps[] = ['step_name'=>'Menunggu','status'=>'pending','date'=>'-','label'=>'Menunggu'];
                $progress_percentage = 65;
                break;

            case 'ditolak dekan':
                $steps[] = [
                    'step_name'=>'Disetujui Kaprodi',
                    'status'=>'completed',
                    'date'=> ($kk) ? date('d M Y', strtotime($kk)) : '-',
                    'label'=>'Disetujui'
                ];
                $steps[] = [
                    'step_name'=>'Disetujui Sekretariat',
                    'status'=>'completed',
                    'date'=> ($sek) ? date('d M Y', strtotime($sek)) : '-',
                    'label'=>'Disetujui'
                ];
                $steps[] = [
                    'step_name'=>'Ditolak Dekan',
                    'status'=>'rejected',
                    'date'=> ($dek) ? date('d M Y', strtotime($dek)) : '-',
                    'label'=>'Ditolak',
                    'catatan_penolakan'=>$catatan_penolakan
                ];
                $progress_percentage = 80;
                break;

            default:
                $steps[] = ['step_name'=>'Persetujuan KK','status'=>'in-progress','date'=>'-','label'=>'Dalam Proses'];
                $steps[] = ['step_name'=>'Persetujuan Sekretariat','status'=>'pending','date'=>'-','label'=>'Menunggu'];
                $steps[] = ['step_name'=>'Persetujuan Dekan','status'=>'pending','date'=>'-','label'=>'Menunggu'];
                $progress_percentage = 25;
                break;
        }

        // Deskripsi status
        $status_description = match ($status) {
            'pengajuan'              => '⏳ Menunggu persetujuan Kepala Kelompok (KK).',
            'disetujui kk'           => '⏳ Menunggu persetujuan Sekretariat.',
            'disetujui sekretariat'  => '⏳ Menunggu persetujuan Dekan.',
            'disetujui dekan','selesai','completed'
                                    => '✅ Semua persetujuan selesai.',
            'ditolak kk'             => '❌ Ditolak oleh Kepala Kelompok (KK).',
            'ditolak sekretariat'    => '❌ Ditolak oleh Sekretariat.',
            'ditolak dekan'          => '❌ Ditolak oleh Dekan.',
            default                  => '⏳ Pengajuan sedang dalam proses.',
        };

        // Response final
        echo json_encode([
            'success' => true,
            'data' => [
                'steps' => $steps,
                'current_status' => $status,
                'status_raw' => $surat->status,
                'progress_percentage' => $progress_percentage,
                'catatan_penolakan' => $catatan_penolakan,
                'status_description' => $status_description,
                'durasi' => [
                    'durasi_1' => ($kk) ? $this->bedaWaktu($created_at, $kk) : '-',
                    'durasi_2' => ($kk && $sek) ? $this->bedaWaktu($kk, $sek) : '-',
                    'durasi_3' => ($sek && $dek) ? $this->bedaWaktu($sek, $dek) : '-',
                ]
            ]
        ]);
    }

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

        return $diff->d . " hari " . $diff->h . " jam " ;
    }

    /* ===========================================
       HELPER: GET ICON BY STATUS
    ============================================*/
    private function get_icon_by_status($status)
    {
        switch ($status) {
            case 'completed':
            case 'approved':
                return 'check';
            case 'rejected':
                return 'times';
            case 'in-progress':
                return 'spinner';
            default:
                return 'clock';
        }
    }

    /* ===========================================
       HELPER: CALCULATE PROGRESS PERCENTAGE
    ============================================*/
    private function calculate_progress($steps)
    {
        $completed = 0;
        $total = count($steps);
        
        foreach ($steps as $step) {
            if ($step['status'] === 'completed' || $step['status'] === 'approved') {
                $completed++;
            }
        }
        
        return round(($completed / $total) * 100);
    }

    public function submit()
    {
        $post = $this->input->post() ?? [];

        $nama_kegiatan = $post['nama_kegiatan'] ?? '';
        $tanggal_kegiatan = $this->safe_date($post['tanggal_awal_kegiatan'] ?? null);
        $user_id = $post['user_id'] ?? '';
        
        // Cek apakah ada pengajuan yang sama dalam 5 menit terakhir
        $five_minutes_ago = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        
        $this->db->where('user_id', $user_id);
        $this->db->where('nama_kegiatan', $nama_kegiatan);
        $this->db->where('tanggal_kegiatan', $tanggal_kegiatan);
        $this->db->where('created_at >=', $five_minutes_ago);
        $existing = $this->db->get('surat')->row();
        
        if ($existing) {
            $this->session->set_flashdata('error', 'Anda sudah mengajukan surat tugas dengan data yang sama baru-baru ini. Silakan tunggu beberapa saat atau periksa daftar pengajuan.');
            redirect('list-surat-tugas');
            return;
        }
        // Clean array values
        foreach ($post as $k => $v) {
            if (is_array($v)) {
                $post[$k] = array_values(array_filter($v, fn($x) => trim($x) !== ""));
            } else {
                $post[$k] = ($v === "" || $v === null) ? "-" : $v;
            }
        }

        // Process tanggal dengan aman
        $tanggal_kegiatan = $this->safe_date($post['tanggal_awal_kegiatan'] ?? null);
        $akhir_kegiatan = $this->safe_date($post['tanggal_akhir_kegiatan'] ?? null);
        $periode_penugasan = $this->safe_date($post['periode_penugasan'] ?? null);
        $akhir_periode_penugasan = $this->safe_date($post['akhir_periode_penugasan'] ?? null);

        /* ======================================================
           🔥 PROSES EVIDEN: ambil URL Uploadcare → download → simpan
           ====================================================== */
        $eviden_raw = $post['eviden'] ?? "[]";
        $eviden_urls = json_decode($eviden_raw, true);

        if (!is_array($eviden_urls)) {
            $eviden_urls = [];
        }

        $saved_filenames = [];

        // Pastikan folder ada
        $upload_dir = FCPATH . "uploads/eviden/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        foreach ($eviden_urls as $url) {
            if (empty($url)) continue;

            // ===============================
            // 1. Coba ambil ekstensi dari URL
            // ===============================
            $path = parse_url($url, PHP_URL_PATH);
            $file_ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

            // ===========================================
            // 2. Jika tidak ada ekstensi → deteksi MIME
            // ===========================================
            if (!$file_ext) {

                // Ambil header untuk membaca MIME
                $headers = @get_headers($url, 1);
                $mime = isset($headers["Content-Type"]) ? $headers["Content-Type"] : "application/octet-stream";

                // Mapping MIME → EXT
                $mime_to_ext = [
                    "image/jpeg" => "jpg",
                    "image/png" => "png",
                    "image/webp" => "webp",
                    "image/gif" => "gif",
                    "application/pdf" => "pdf",
                    "application/msword" => "doc",
                    "application/vnd.openxmlformats-officedocument.wordprocessingml.document" => "docx",
                ];

                $file_ext = isset($mime_to_ext[$mime]) ? $mime_to_ext[$mime] : "bin";  
            }

            // ===============================
            // 3. Buat nama file final
            // ===============================
            $filename = "eviden_" . time() . "_" . rand(1000,9999) . "." . $file_ext;

            $save_path = $upload_dir . $filename;

            // ===============================
            // 4. Download file
            // ===============================
            $file_data = @file_get_contents($url);

            if ($file_data !== false) {
                file_put_contents($save_path, $file_data);
                $saved_filenames[] = $filename;
            }
        }

        $data = [
            'user_id' => $post['user_id'] ?? '-',
            'nama_kegiatan' => $post['nama_kegiatan'] ?? '-',
            'jenis_date' => $post['jenis_date'] ?? '-',
            'created_at' => date('Y-m-d H:i:s'),
            
            // TANGGAL KEGIATAN - DUA FIELD TERPISAH
            'tanggal_kegiatan' => $tanggal_kegiatan,
            'akhir_kegiatan' => $akhir_kegiatan,
            
            // PERIODE PENUGASAN - AUTO-FILLED
            'periode_penugasan' => $periode_penugasan,
            'akhir_periode_penugasan' => $akhir_periode_penugasan,
            
            'periode_value' => $post['periode_value'] ?? '-',
            'tempat_kegiatan' => $post['tempat_kegiatan'] ?? '-',
            'penyelenggara' => $post['penyelenggara'] ?? '-',
            'jenis_pengajuan' => $post['jenis_pengajuan'] ?? '-',
            'lingkup_penugasan' => $post['lingkup_penugasan'] ?? '-',
            'jenis_penugasan_perorangan' => $post['jenis_penugasan_perorangan'] ?? '-',
            'penugasan_lainnya_perorangan' => $post['penugasan_lainnya_perorangan'] ?? '-',
            'jenis_penugasan_kelompok' => $post['jenis_penugasan_kelompok'] ?? '-',
            'penugasan_lainnya_kelompok' => $post['penugasan_lainnya_kelompok'] ?? '-',
            'format' => $post['format'] ?? '-',
            'nip' => json_encode($post['nip'] ?? []),
            'eviden' => json_encode($saved_filenames),
            'status' => 'pengajuan',
        ];

        $this->Surat_model->insert_surat($data);

        log_message('info', 'Surat submitted - Tanggal Kegiatan: ' . $tanggal_kegiatan . ' s/d ' . $akhir_kegiatan);
        log_message('info', 'Periode Penugasan: ' . $periode_penugasan . ' s/d ' . $akhir_periode_penugasan);

        $this->session->set_flashdata('success', 'Data berhasil disimpan!');
        redirect('list-surat-tugas');
    }

    /* ===========================================
       DOWNLOAD EVIDEN
    ============================================*/
    public function download_eviden_url()
    {
        $url = $this->input->get('url');
        $name = $this->input->get('name') ?? "eviden";

        if (!$url) show_404();

        header("Content-Disposition: attachment; filename=\"$name\"");
        readfile($url);
    }

    public function download_eviden()
    {
        $file = $this->input->get('file');

        if (!$file) {
            show_404();
            return;
        }

        $file = urldecode($file);

        if (filter_var($file, FILTER_VALIDATE_URL)) {
            $this->_download_from_url($file);
            return;
        }

        $safe_filename = basename($file);
        $filepath = FCPATH . 'uploads/eviden/' . $safe_filename;

        if (!file_exists($filepath)) {
            show_404();
            return;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $filepath);
        finfo_close($finfo);

        if (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: attachment; filename="' . $safe_filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));

        flush();
        readfile($filepath);
        exit;
    }

    private function _download_from_url($url)
    {
        $filename = basename(parse_url($url, PHP_URL_PATH));

        if (empty($filename)) {
            $filename = 'download_' . time();
        }

        $file_content = @file_get_contents($url);

        if ($file_content === false) {
            show_404();
            return;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_buffer($finfo, $file_content);
        finfo_close($finfo);

        if (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($file_content));

        flush();
        echo $file_content;
        exit;
    }

    /* ===========================================
       GET EVIDEN URL - METHOD BARU
    ============================================*/
    public function get_eviden_url($eviden_data)
    {
        if (empty($eviden_data)) return [];
        
        $urls = [];
        
        if (is_string($eviden_data)) {
            $decoded = json_decode($eviden_data, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $eviden_data = $decoded;
            } else {
                $eviden_data = [$eviden_data];
            }
        }
        
        if (!is_array($eviden_data)) {
            $eviden_data = [];
        }
        
        foreach ($eviden_data as $file) {
            if (filter_var($file, FILTER_VALIDATE_URL)) {
                // Jika sudah URL lengkap (dari Uploadcare)
                $urls[] = $file;
            } else if (strpos($file, 'ucarecdn.com') !== false || strpos($file, 'uploadcare.com') !== false) {
                // Jika URL Uploadcare tanpa protokol
                if (strpos($file, '//') === 0) {
                    $urls[] = 'https:' . $file;
                } else {
                    $urls[] = 'https://' . $file;
                }
            } else {
                // File lokal
                $urls[] = base_url('uploads/eviden/' . $file);
            }
        }
        
        return $urls;
    }

    public function edit($id)
    {
        $surat = $this->Surat_model->get_by_id($id);

        if (!$surat) show_404();

        // CEK APAKAH STATUS DITOLAK
        $status_lower = strtolower($surat->status);
        $is_rejected = in_array($status_lower, ['ditolak kk', 'ditolak sekretariat', 'ditolak dekan']);
        
        if (!$is_rejected) {
            $this->session->set_flashdata('error', 'Edit hanya dapat dilakukan untuk surat yang ditolak!');
            redirect('list-surat-tugas');
            return;
        }

        $data['surat'] = (array)$surat;
        
        // Get dosen data untuk ditampilkan
        $data['dosen_data'] = $this->get_dosen_by_nip($surat->nip);
            
        $eviden_raw = $surat->eviden ?? "[]";
        
        if (is_string($eviden_raw)) {
            $eviden_decoded = json_decode($eviden_raw, true);
            $data['eviden'] = is_array($eviden_decoded) ? $eviden_decoded : [];
        } else {
            $data['eviden'] = is_array($eviden_raw) ? $eviden_raw : [];
        }

        if (!$this->input->post()) {
            $this->load->view('edit_surat', $data);
            return;
        }

        // PROSES UPDATE
        $post = $this->input->post();

        foreach ($post as $k => $v) {
            if (is_array($v)) {
                $post[$k] = array_values(array_filter($v, fn($x) => trim($x) !== ""));
            } else {
                $post[$k] = ($v === "" ? "-" : $v);
            }
        }

        // PROSES EVIDEN (sama seperti sebelumnya)
        $existing_eviden = json_decode($surat->eviden, true) ?: [];
        
        $deleted_files = $post['delete_eviden'] ?? [];
        foreach ($deleted_files as $del_file) {
            if ($del_file && trim($del_file) !== '') {
                $existing_eviden = array_filter($existing_eviden, fn($f) => $f !== $del_file);
                
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
                    } else {
                        log_message('error', 'Upload failed: ' . $this->upload->display_errors());
                    }
                }
            }
        }
        
        $final_eviden = array_merge(array_values($existing_eviden), $new_files);
        $update_eviden = json_encode($final_eviden);

        // DATA UPDATE
        $update = [
            'nama_kegiatan' => $post['nama_kegiatan'],
            'jenis_date' => $post['jenis_date'],
            'tanggal_kegiatan' => $this->safe_date($post['tanggal_kegiatan']),
            'akhir_kegiatan' => $this->safe_date($post['akhir_kegiatan']),
            'periode_penugasan' => $this->safe_date($post['periode_penugasan']),
            'akhir_periode_penugasan' => $this->safe_date($post['akhir_periode_penugasan']),
            'periode_value' => $post['periode_value'],
            'tempat_kegiatan' => $post['tempat_kegiatan'],
            'penyelenggara' => $post['penyelenggara'],
            'jenis_pengajuan' => $post['jenis_pengajuan'],
            'lingkup_penugasan' => $post['lingkup_penugasan'],
            'jenis_penugasan_perorangan' => $post['jenis_penugasan_perorangan'],
            'penugasan_lainnya_perorangan' => $post['penugasan_lainnya_perorangan'],
            'jenis_penugasan_kelompok' => $post['jenis_penugasan_kelompok'],
            'penugasan_lainnya_kelompok' => $post['penugasan_lainnya_kelompok'],
            'format' => $post['format'],
            'nip' => json_encode($post['nip']),
            'eviden' => $update_eviden
        ];

        // ========================================
        // 🔥 FITUR BARU: RESET STATUS KE PENGAJUAN ULANG
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
        
        // Tentukan status baru berdasarkan siapa yang menolak
        $new_status = 'pengajuan'; // default
        
        switch ($status_lower) {
            case 'ditolak kk':
                // Reset approval KK, tapi tetap simpan history lainnya
                $approval_status['kk'] = null;
                $new_status = 'pengajuan'; // Kembali ke awal untuk review KK
                break;
                
            case 'ditolak sekretariat':
                // Tetap pertahankan approval KK yang sudah ada
                // Reset approval sekretariat
                $approval_status['sekretariat'] = null;
                $new_status = 'disetujui kk'; // Langsung ke sekretariat (karena KK sudah approve sebelumnya)
                break;
                
            case 'ditolak dekan':
                // Tetap pertahankan approval KK dan Sekretariat
                // Reset approval dekan
                $approval_status['dekan'] = null;
                $new_status = 'disetujui sekretariat'; // Langsung ke dekan
                break;
        }
        
        // Update status dan approval_status
        $update['status'] = $new_status;
        $update['approval_status'] = json_encode($approval_status);
        
        // Hapus catatan penolakan karena ini pengajuan ulang
        $update['catatan_penolakan'] = null;

        // Update tanggal pengajuan ulang
        if (!empty($post['created_at'])) {
            $tp = $this->safe_date($post['created_at']);
            if ($tp !== '-') $update['created_at'] = $tp;
        }

        // EKSEKUSI UPDATE
        $this->Surat_model->update_surat($id, $update);

        // Flashdata dengan informasi lebih detail
        $rejector_name = match($status_lower) {
            'ditolak kk' => 'Kepala Kelompok (Kaprodi)',
            'ditolak sekretariat' => 'Sekretariat',
            'ditolak dekan' => 'Dekan',
            default => 'pihak terkait'
        };
        
        $this->session->set_flashdata('success', "Data berhasil diperbarui! Pengajuan telah dikirim kembali ke {$rejector_name} untuk persetujuan ulang.");
        redirect('list-surat-tugas');
    }

    /* ===========================================
       DELETE DATA
    ============================================*/
    public function delete($id)
    {
        $surat = $this->Surat_model->get_by_id($id);
        
        if ($surat) {
            $eviden = json_decode($surat->eviden, true) ?: [];
            foreach ($eviden as $file) {
                if ($file && !filter_var($file, FILTER_VALIDATE_URL)) {
                    $file_path = './uploads/eviden/' . $file;
                    if (file_exists($file_path)) {
                        @unlink($file_path);
                    }
                }
            }
        }
        
        $this->Surat_model->delete_surat($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus!');
        redirect('list-surat-tugas');
    }

    /* ===========================================
       MULTI DELETE
    ============================================*/
    public function multi_delete()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
            return;
        }

        $ids_input = $this->input->post('ids');
        
        if (!$ids_input) {
            echo json_encode([
                'success' => false,
                'message' => 'Tidak ada data yang dipilih untuk dihapus.'
            ]);
            return;
        }

        if (is_string($ids_input)) {
            $ids = array_map('intval', explode(',', $ids_input));
        } else if (is_array($ids_input)) {
            $ids = array_map('intval', $ids_input);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Format ID tidak valid.'
            ]);
            return;
        }

        $ids = array_filter($ids, function($id) {
            return $id > 0;
        });

        if (empty($ids)) {
            echo json_encode([
                'success' => false,
                'message' => 'Tidak ada ID yang valid untuk dihapus.'
            ]);
            return;
        }

        $deleted_count = 0;
        $failed_ids = [];

        foreach ($ids as $id) {
            $surat = $this->Surat_model->get_by_id($id);
            
            if ($surat) {
                $eviden = json_decode($surat->eviden, true) ?: [];
                foreach ($eviden as $file) {
                    if ($file && !filter_var($file, FILTER_VALIDATE_URL)) {
                        $file_path = './uploads/eviden/' . $file;
                        if (file_exists($file_path)) {
                            @unlink($file_path);
                        }
                    }
                }

                $result = $this->Surat_model->delete_surat($id);
                
                if ($result) {
                    $deleted_count++;
                } else {
                    $failed_ids[] = $id;
                }
            } else {
                $failed_ids[] = $id;
            }
        }

        if ($deleted_count > 0) {
            $message = "Berhasil menghapus {$deleted_count} data.";
            
            if (!empty($failed_ids)) {
                $message .= " Gagal menghapus ID: " . implode(', ', $failed_ids);
            }
            
            echo json_encode([
                'success' => true,
                'message' => $message,
                'deleted_count' => $deleted_count
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Tidak ada data yang berhasil dihapus.'
            ]);
        }
    }

    public function multi_edit()
    {
        $ids = $this->input->get('ids');

        if (!$ids) {
            $this->session->set_flashdata('error', 'Tidak ada data yang dipilih untuk di-edit.');
            redirect('list-surat-tugas');
            return;
        }

        $idArray = explode(',', $ids);
        
        $idArray = array_filter(array_map('intval', $idArray), function($id) {
            return $id > 0;
        });

        if (empty($idArray)) {
            $this->session->set_flashdata('error', 'ID yang diberikan tidak valid.');
            redirect('list-surat-tugas');
            return;
        }

        $data['surat_list'] = $this->Surat_model->getMultiByIds($idArray);

        if (empty($data['surat_list'])) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan untuk ID: ' . implode(', ', $idArray));
            redirect('list-surat-tugas');
            return;
        }

        // TAMBAHAN: Enrich dengan data dosen dari list_dosen - FIXED
        foreach ($data['surat_list'] as &$surat) {
            // Pastikan kita memproses field nip dengan benar
            $nip_data = $surat->nip;
            
            // Debug log untuk melihat tipe data
            log_message('debug', 'NIP data type: ' . gettype($nip_data) . ' value: ' . print_r($nip_data, true));
            
            $surat->dosen_data = $this->get_dosen_by_nip($nip_data);
        }

        $this->load->view('multi_edit_surat', $data);
    }

    /* ===========================================
       SAVE MULTI EDIT (UPDATED)
    ============================================*/
    public function save_multi_edit()
    {
        if (!$this->input->post()) {
            $this->session->set_flashdata('error', 'Tidak ada data yang dikirim.');
            redirect('list-surat-tugas');
            return;
        }

        $post = $this->input->post();
        
        if (!isset($post['items']) || !is_array($post['items'])) {
            $this->session->set_flashdata('error', 'Format data tidak valid.');
            redirect('list-surat-tugas');
            return;
        }

        $success_count = 0;
        $failed_count = 0;

        foreach ($post['items'] as $item) {
            if (!isset($item['id']) || empty($item['id'])) {
                continue;
            }

            $id = intval($item['id']);
            if ($id <= 0) {
                $failed_count++;
                continue;
            }

            $existing = $this->Surat_model->get_by_id($id);
            if (!$existing) {
                $failed_count++;
                continue;
            }

            $update_data = [
                'nama_kegiatan' => $item['nama_kegiatan'] ?? $existing->nama_kegiatan,
                'jenis_date' => $item['jenis_date'] ?? $existing->jenis_date,
                'tanggal_kegiatan' => $this->safe_date($item['tanggal_kegiatan'] ?? null),
                'akhir_kegiatan' => $this->safe_date($item['akhir_kegiatan'] ?? null),
                'periode_penugasan' => $this->safe_date($item['periode_penugasan'] ?? null),
                'akhir_periode_penugasan' => $this->safe_date($item['akhir_periode_penugasan'] ?? null),
                'periode_value' => $item['periode_value'] ?? $existing->periode_value,
                'tempat_kegiatan' => $item['tempat_kegiatan'] ?? $existing->tempat_kegiatan,
                'penyelenggara' => $item['penyelenggara'] ?? $existing->penyelenggara,
                'jenis_pengajuan' => $item['jenis_pengajuan'] ?? $existing->jenis_pengajuan,
                'lingkup_penugasan' => $item['lingkup_penugasan'] ?? $existing->lingkup_penugasan,
                'jenis_penugasan_perorangan' => $item['jenis_penugasan_perorangan'] ?? $existing->jenis_penugasan_perorangan,
                'penugasan_lainnya_perorangan' => $item['penugasan_lainnya_perorangan'] ?? $existing->penugasan_lainnya_perorangan,
                'jenis_penugasan_kelompok' => $item['jenis_penugasan_kelompok'] ?? $existing->jenis_penugasan_kelompok,
                'penugasan_lainnya_kelompok' => $item['penugasan_lainnya_kelompok'] ?? $existing->penugasan_lainnya_kelompok,
                
                // PERUBAHAN: HANYA UPDATE NIP
                'nip' => isset($item['nip']) ? json_encode($item['nip']) : $existing->nip,
            ];

            $result = $this->Surat_model->update_surat($id, $update_data);
            
            if ($result) {
                $success_count++;
            } else {
                $failed_count++;
            }
        }

        if ($success_count > 0) {
            $message = "Berhasil mengupdate {$success_count} data.";
            if ($failed_count > 0) {
                $message .= " Gagal update {$failed_count} data.";
            }
            $this->session->set_flashdata('success', $message);
        } else {
            $this->session->set_flashdata('error', 'Tidak ada data yang berhasil diupdate.');
        }

        redirect('list-surat-tugas');
    }

    public function cetak($id)
    {
        $surat = $this->Surat_model->get_by_id($id);
        
        if (!$surat) {
            show_404();
            return;
        }
        
        // Validasi status harus 'disetujui dekan'
        if (strtolower($surat->status) !== 'disetujui dekan') {
            // Tampilkan error atau redirect
            $this->session->set_flashdata('error', 'Surat belum disetujui dekan. Tidak dapat dicetak.');
            redirect('list-surat-tugas');
            return;
        }
        
        // --- NIP array ---
        $surat->nip = is_array($surat->nip) ? $surat->nip : json_decode($surat->nip, true);
        
        // --- data dosen ---
        $surat->dosen_data = $this->get_dosen_detail($surat);
        
        $jumlah_dosen = count($surat->dosen_data);
        
        // Tentukan file view
        if ($jumlah_dosen == 1) {
            $view_file = 'surat_satu';
        } elseif ($jumlah_dosen <= 5) {
            $view_file = 'surat_print';
        } else {
            $view_file = 'surat_banyak';
        }
        
        // --- QR VALIDATION URL ---
        $validation_url = base_url("surat/validasi/" . $surat->id);
        
        // --- QR CODE GENERATE ---
        $qr_base64 = '';
        try {
            if (extension_loaded('gd')) {
                $qrCode = QrCode::create($validation_url)
                    ->setEncoding(new Encoding('UTF-8'))
                    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
                    ->setSize(160);
                
                $writer = new PngWriter();
                $qrResult = $writer->write($qrCode);
                $qr_base64 = base64_encode($qrResult->getString());
            }
        } catch (Exception $e) {
            log_message('error', 'QR Code generation failed: ' . $e->getMessage());
        }
        
        $data = [
            'surat'      => $surat,
            'qr_base64'  => $qr_base64
        ];
        
        // Render view + header + footer
        $html = $this->load->view($view_file, $data, TRUE);
        
        // PDF OPTIONS
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        
        ini_set("memory_limit", "8192M");
        ini_set("pcre.backtrack_limit", "30000000");
        
        $dompdf->render();
        
        $filename = "surat_tugas_" . $surat->id . "_" . date('Ymd_His') . ".pdf";
        
        $dompdf->stream($filename, ["Attachment" => 0]);
    }

    public function download_pdf($id)
    {
        $this->load->helper('download');

        $surat = $this->Surat_model->get_by_id($id);

        $file_path = FCPATH . "uploads/surat_pdf/" . $surat->file_pdf;

        if (!file_exists($file_path)) {
            show_404();
            return;
        }

        force_download($file_path, NULL);
    }

    /* ===========================================
       VALIDASI (UPDATED WITH DOSEN LIST)
    ============================================*/
    public function validasi($id)
    {
        $surat = $this->Surat_model->get_by_id($id);
        
        if (!$surat) {
            $data['found'] = false;
            $data['surat'] = null;
            $data['dosen_list'] = [];
            $data['dosen_penandatangan'] = null;
            $data['logo_base64'] = '';
        } else {
            $data['found'] = true;
            $data['surat'] = $surat;
            
            // AMBIL SEMUA DOSEN YANG TERLIBAT DALAM PENGAJUAN INI
            $data['dosen_list'] = $this->get_dosen_by_nip($surat->nip);
            
            // Ambil data dosen penandatangan (dekan)
            $data['dosen_penandatangan'] = $this->db
                ->select('nama_dosen, jabatan, divisi')
                ->from('list_dosen')
                ->where('jabatan LIKE', '%Dekan%')
                ->or_where('divisi LIKE', '%Dekan%')
                ->limit(1)
                ->get()
                ->row();
            
            // Load logo untuk header
            $logo_path = FCPATH . 'assets/Tel-U_logo.png';
            if (file_exists($logo_path)) {
                $logo_data = file_get_contents($logo_path);
                $data['logo_base64'] = base64_encode($logo_data);
            } else {
                $data['logo_base64'] = '';
            }
        }

        $this->load->view('surat_validasi', $data);
    }

    private function get_dosen_detail($surat)
    {
        // NIP sudah array → tidak perlu json_decode
        $nip_list = is_array($surat->nip) ? $surat->nip : json_decode($surat->nip, true);

        if (!$nip_list) return [];

        // Ambil dosen dari model
        $this->load->model('ListSurat_model');
        $dosen_data = $this->ListSurat_model->get_many_by_nip($nip_list);

        // Susun ulang urutan sesuai urutan NIP di surat
        $result = [];

        foreach ($nip_list as $nip) {
            if (isset($dosen_data[$nip])) {
                $result[] = [
                    'nip'     => $nip,
                    'nama'    => $dosen_data[$nip]->nama_dosen,
                    'jabatan' => $dosen_data[$nip]->jabatan,
                    'divisi'  => $dosen_data[$nip]->divisi,
                ];
            } else {
                // fallback jika nip tidak ada di tabel list_dosen
                $result[] = [
                    'nip'     => $nip,
                    'nama'    => '-',
                    'jabatan' => '-',
                    'divisi'  => '-',
                ];
            }
        }

        return $result;
    }

    /* ===========================================
       LIST SURAT TUGAS (UPDATED)
    ============================================*/
    public function list_surat_tugas()
    {
        $data['surat_list'] = $this->Surat_model->get_all_surat();
        
        // TAMBAHAN: Enrich data dengan informasi dosen
        foreach ($data['surat_list'] as &$surat) {
            $surat->dosen_data = $this->get_dosen_by_nip($surat->nip);
        }
        
        $this->load->view('list_surat_tugas', $data);
    }

    /* ===========================================
       TAMBAH DOSEN KE PENGAJUAN (AJAX) - DEBUG VERSION
    ============================================*/
    public function tambah_dosen()
    {
        header('Content-Type: application/json');
        
        // Log input untuk debugging
        log_message('debug', 'tambah_dosen called');
        log_message('debug', 'POST data: ' . print_r($this->input->post(), true));
        
        $surat_id = $this->input->post('surat_id');
        $nip_baru = $this->input->post('nip');
        
        if (!$surat_id || !$nip_baru) {
            log_message('error', 'Data tidak lengkap. surat_id: ' . $surat_id . ', nip: ' . $nip_baru);
            echo json_encode([
                'success' => false,
                'message' => 'Data tidak lengkap'
            ]);
            return;
        }
        
        // Ambil data surat
        $surat = $this->Surat_model->get_by_id($surat_id);
        
        if (!$surat) {
            log_message('error', 'Surat tidak ditemukan. ID: ' . $surat_id);
            echo json_encode([
                'success' => false,
                'message' => 'Surat tidak ditemukan'
            ]);
            return;
        }
        
        // Decode NIP yang sudah ada
        $nip_array = json_decode($surat->nip, true);
        if (!is_array($nip_array)) {
            $nip_array = [];
        }
        
        log_message('debug', 'NIP array sebelum: ' . print_r($nip_array, true));
        
        // Cek apakah NIP sudah ada
        if (in_array($nip_baru, $nip_array)) {
            log_message('debug', 'NIP sudah ada: ' . $nip_baru);
            echo json_encode([
                'success' => false,
                'message' => 'Dosen dengan NIP ini sudah ada dalam pengajuan'
            ]);
            return;
        }
        
        // Cek apakah NIP valid di database
        $this->db->where('nip', $nip_baru);
        $dosen = $this->db->get('list_dosen')->row();
        
        if (!$dosen) {
            log_message('error', 'NIP tidak ditemukan di database: ' . $nip_baru);
            echo json_encode([
                'success' => false,
                'message' => 'NIP tidak ditemukan di database dosen'
            ]);
            return;
        }
        
        // Tambahkan NIP baru
        $nip_array[] = $nip_baru;
        
        log_message('debug', 'NIP array sesudah: ' . print_r($nip_array, true));
        
        // Update database
        $update_data = [
            'nip' => json_encode($nip_array),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        log_message('debug', 'Update data: ' . print_r($update_data, true));
        
        $result = $this->Surat_model->update_surat($surat_id, $update_data);
        
        if ($result) {
            log_message('debug', 'Update berhasil untuk surat ID: ' . $surat_id);
            echo json_encode([
                'success' => true,
                'message' => 'Dosen berhasil ditambahkan',
                'dosen' => [
                    'nip' => $dosen->nip,
                    'nama_dosen' => $dosen->nama_dosen,
                    'jabatan' => $dosen->jabatan,
                    'divisi' => $dosen->divisi
                ],
                'total_dosen' => count($nip_array)
            ]);
        } else {
            log_message('error', 'Update gagal untuk surat ID: ' . $surat_id);
            echo json_encode([
                'success' => false,
                'message' => 'Gagal menambahkan dosen ke database'
            ]);
        }
    }

    /* ===========================================
       PERBAIKAN UTAMA: HAPUS DOSEN DARI PENGAJUAN - WORKING VERSION
    ============================================*/
    public function hapus_dosen()
    {
        header('Content-Type: application/json');
        
        // Log untuk debugging
        log_message('debug', 'hapus_dosen called');
        log_message('debug', 'POST data: ' . print_r($this->input->post(), true));
        
        $surat_id = $this->input->post('surat_id');
        $nip = $this->input->post('nip');
        
        if (!$surat_id || !$nip) {
            log_message('error', 'Data tidak lengkap. surat_id: ' . $surat_id . ', nip: ' . $nip);
            echo json_encode([
                'success' => false,
                'message' => 'Data tidak lengkap'
            ]);
            return;
        }
        
        // Ambil data surat
        $surat = $this->Surat_model->get_by_id($surat_id);
        
        if (!$surat) {
            log_message('error', 'Surat tidak ditemukan. ID: ' . $surat_id);
            echo json_encode([
                'success' => false,
                'message' => 'Surat tidak ditemukan'
            ]);
            return;
        }
        
        // Decode NIP yang sudah ada
        $nip_array = json_decode($surat->nip, true);
        if (!is_array($nip_array)) {
            $nip_array = [];
        }
        
        log_message('debug', 'NIP array sebelum hapus: ' . print_r($nip_array, true));
        
        // Cek apakah NIP ada dalam array
        if (!in_array($nip, $nip_array)) {
            log_message('debug', 'NIP tidak ditemukan: ' . $nip);
            echo json_encode([
                'success' => false,
                'message' => 'Dosen dengan NIP ini tidak ditemukan dalam pengajuan'
            ]);
            return;
        }
        
        // Cek minimal harus ada 1 dosen tersisa
        if (count($nip_array) <= 1) {
            log_message('debug', 'Tidak dapat menghapus: hanya tersisa 1 dosen');
            echo json_encode([
                'success' => false,
                'message' => 'Minimal harus ada 1 dosen dalam pengajuan'
            ]);
            return;
        }
        
        // Hapus NIP dari array
        $new_nip_array = array_values(array_filter($nip_array, function($item) use ($nip) {
            return $item !== $nip;
        }));
        
        log_message('debug', 'NIP array sesudah hapus: ' . print_r($new_nip_array, true));
        
        // Update database
        $update_data = [
            'nip' => json_encode($new_nip_array),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', $surat_id);
        $result = $this->db->update('surat', $update_data);
        
        if ($result) {
            log_message('debug', 'Hapus dosen berhasil untuk surat ID: ' . $surat_id);
            
            // Ambil info dosen yang dihapus untuk response
            $this->db->where('nip', $nip);
            $dosen_hapus = $this->db->get('list_dosen')->row();
            
            $dosen_info = [
                'nip' => $nip,
                'nama_dosen' => $dosen_hapus ? $dosen_hapus->nama_dosen : '-',
                'jabatan' => $dosen_hapus ? $dosen_hapus->jabatan : '-',
                'divisi' => $dosen_hapus ? $dosen_hapus->divisi : '-'
            ];
            
            echo json_encode([
                'success' => true,
                'message' => 'Dosen berhasil dihapus',
                'dosen' => $dosen_info,
                'total_dosen' => count($new_nip_array)
            ]);
        } else {
            log_message('error', 'Hapus dosen gagal untuk surat ID: ' . $surat_id);
            echo json_encode([
                'success' => false,
                'message' => 'Gagal menghapus dosen dari database'
            ]);
        }
    }

    /* ===========================================
       CARI DOSEN UNTUK AUTOCOMPLETE (AJAX)
    ============================================*/
    public function cari_dosen()
    {
        header('Content-Type: application/json');
        
        $nip = $this->input->get('q');
        
        if (!$nip) {
            echo json_encode([
                'success' => false,
                'message' => 'NIP tidak boleh kosong'
            ]);
            return;
        }
        
        // Cari dosen di database
        $this->db->select('nip, nama_dosen, jabatan, divisi');
        $this->db->from('list_dosen');
        $this->db->where('nip', $nip);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $dosen = $query->row();
            echo json_encode([
                'success' => true,
                'dosen' => [
                    'nip' => $dosen->nip,
                    'nama_dosen' => $dosen->nama_dosen,
                    'jabatan' => $dosen->jabatan,
                    'divisi' => $dosen->divisi
                ]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Dosen tidak ditemukan'
            ]);
        }
    }

    /* ===========================================
       TEST FUNCTION - Untuk debugging
    ============================================*/
    public function test_tambah_dosen()
    {
        // Test data hardcoded untuk debugging
        $test_data = [
            'surat_id' => 1, // Ganti dengan ID surat yang valid
            'nip' => '14800004' // Ganti dengan NIP yang valid dari database list_dosen
        ];
        
        log_message('debug', 'Test tambah dosen dengan data: ' . print_r($test_data, true));
        
        // Simulasikan POST request
        $_POST = $test_data;
        
        // Panggil fungsi tambah_dosen
        $this->tambah_dosen();
    }

    public function test_hapus_dosen()
    {
        // Test data hardcoded untuk debugging
        $test_data = [
            'surat_id' => 1, // Ganti dengan ID surat yang valid
            'nip' => '14800004' // Ganti dengan NIP yang ada di surat tersebut
        ];
        
        log_message('debug', 'Test hapus dosen dengan data: ' . print_r($test_data, true));
        
        // Simulasikan POST request
        $_POST = $test_data;
        
        // Panggil fungsi hapus_dosen
        $this->hapus_dosen();
    }

    /* ===========================================
       CEK STATUS SURAT - Untuk debugging
    ============================================*/
    public function cek_surat($id)
    {
        header('Content-Type: application/json');
        
        $surat = $this->Surat_model->get_by_id($id);
        
        if (!$surat) {
            echo json_encode([
                'success' => false,
                'message' => 'Surat tidak ditemukan'
            ]);
            return;
        }
        
        $nip_array = json_decode($surat->nip, true);
        
        echo json_encode([
            'success' => true,
            'data' => [
                'id' => $surat->id,
                'nama_kegiatan' => $surat->nama_kegiatan,
                'nip_raw' => $surat->nip,
                'nip_array' => $nip_array,
                'count_nip' => is_array($nip_array) ? count($nip_array) : 0,
                'dosen_data' => $this->get_dosen_by_nip($surat->nip)
            ]
        ]);
    }

    /* ===========================================
       AUTOCOMPLETE DOSEN UNTUK MODAL TAMBAH
    ============================================*/
    public function autocomplete_dosen()
    {
        header('Content-Type: application/json');
        
        $query = $this->input->get('q');
        
        if (!$query || strlen($query) < 2) {
            echo json_encode([
                'success' => false,
                'message' => 'Kata kunci terlalu pendek',
                'results' => []
            ]);
            return;
        }
        
        try {
            // Mencari di database dengan multiple fields
            $this->db->select('nip, nama_dosen, jabatan, divisi');
            $this->db->from('list_dosen');
            
            // Search in multiple columns
            $this->db->group_start();
            $this->db->like('nip', $query);
            $this->db->or_like('nama_dosen', $query);
            $this->db->or_like('jabatan', $query);
            $this->db->or_like('divisi', $query);
            $this->db->group_end();
            
            $this->db->limit(10);
            $this->db->order_by('nama_dosen', 'ASC');
            
            $result = $this->db->get();
            
            if ($result->num_rows() > 0) {
                $dosen_list = $result->result_array();
                
                // Format results for autocomplete
                $results = array_map(function($dosen) {
                    return [
                        'nip' => $dosen['nip'] ?? '',
                        'nama_dosen' => $dosen['nama_dosen'] ?? '',
                        'jabatan' => $dosen['jabatan'] ?? '',
                        'divisi' => $dosen['divisi'] ?? '',
                        'display_text' => $dosen['nama_dosen'] . ' (' . $dosen['nip'] . ')'
                    ];
                }, $dosen_list);
                
                echo json_encode([
                    'success' => true,
                    'results' => $results,
                    'count' => count($results)
                ]);
            } else {
                echo json_encode([
                    'success' => true,
                    'results' => [],
                    'message' => 'Tidak ditemukan dosen yang cocok'
                ]);
            }
            
        } catch (Exception $e) {
            log_message('error', 'Autocomplete dosen error: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mencari dosen',
                'results' => []
            ]);
        }
    }
/* ===========================================
   TAMBAH BANYAK DOSEN SEKALIGUS (BATCH)
============================================*/
public function tambah_banyak_dosen()
{
    header('Content-Type: application/json');
    
    // Log untuk debugging
    log_message('debug', 'tambah_banyak_dosen called');
    log_message('debug', 'POST data: ' . print_r($this->input->post(), true));
    
    $surat_id = $this->input->post('surat_id');
    $nip_list_json = $this->input->post('nip_list');
    
    if (!$surat_id || !$nip_list_json) {
        echo json_encode([
            'success' => false,
            'message' => 'Data tidak lengkap'
        ]);
        return;
    }
    
    // Decode NIP list
    $nip_list = json_decode($nip_list_json, true);
    if (!is_array($nip_list) || empty($nip_list)) {
        echo json_encode([
            'success' => false,
            'message' => 'Daftar NIP tidak valid'
        ]);
        return;
    }
    
    // Ambil data surat
    $surat = $this->Surat_model->get_by_id($surat_id);
    if (!$surat) {
        echo json_encode([
            'success' => false,
            'message' => 'Surat tidak ditemukan'
        ]);
        return;
    }
    
    // Decode NIP yang sudah ada
    $existing_nips = json_decode($surat->nip, true);
    if (!is_array($existing_nips)) {
        $existing_nips = [];
    }
    
    // Filter NIP yang belum ada
    $new_nips = array_filter($nip_list, function($nip) use ($existing_nips) {
        return !in_array($nip, $existing_nips);
    });
    
    // Validasi NIP di database
    $valid_nips = [];
    $invalid_nips = [];
    
    foreach ($new_nips as $nip) {
        // Cek apakah NIP valid di database
        $this->db->where('nip', $nip);
        $dosen = $this->db->get('list_dosen')->row();
        
        if ($dosen) {
            $valid_nips[] = $nip;
        } else {
            $invalid_nips[] = $nip;
        }
    }
    
    // Jika tidak ada NIP valid
    if (empty($valid_nips)) {
        echo json_encode([
            'success' => false,
            'message' => 'Tidak ada NIP yang valid untuk ditambahkan',
            'invalid_nips' => $invalid_nips
        ]);
        return;
    }
    
    // Gabungkan NIP lama dengan baru
    $final_nips = array_merge($existing_nips, $valid_nips);
    
    // Update database
    $update_data = [
        'nip' => json_encode($final_nips),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    $this->db->where('id', $surat_id);
    $result = $this->db->update('surat', $update_data);
    
    if ($result) {
        // Get dosen data untuk response
        $added_dosen = [];
        foreach ($valid_nips as $nip) {
            $this->db->where('nip', $nip);
            $dosen = $this->db->get('list_dosen')->row();
            if ($dosen) {
                $added_dosen[] = [
                    'nip' => $dosen->nip,
                    'nama_dosen' => $dosen->nama_dosen,
                    'jabatan' => $dosen->jabatan,
                    'divisi' => $dosen->divisi
                ];
            }
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Berhasil menambahkan ' . count($valid_nips) . ' dosen',
            'added_count' => count($valid_nips),
            'added_dosen' => $added_dosen,
            'invalid_nips' => $invalid_nips,
            'total_dosen' => count($final_nips)
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal memperbarui database'
        ]);
    }
}
}