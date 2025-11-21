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
        $this->load->helper(['form', 'url']);
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
       LIST DATA
    ============================================*/
    public function index()
    {
        $data['surat_list'] = $this->Surat_model->get_all_surat();
        $this->load->view('surat', $data);
    }

    /* ===========================================
    GET STATUS - WITH REJECTION REASON
    ============================================*/
   public function get_status($surat_id)
{
    header('Content-Type: application/json');
    
    $this->db->select('id, status, created_at, catatan_penolakan,
                   tanggal_disetujui_kk, tanggal_disetujui_sekretariat, tanggal_disetujui_dekan');

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

        // Hitung durasi waktu di tiap tahap
    $durasi_1 = $this->bedaWaktu($surat->created_at, $surat->tanggal_disetujui_kk);
    $durasi_2 = $this->bedaWaktu($surat->tanggal_disetujui_kk, $surat->tanggal_disetujui_sekretariat);
    $durasi_3 = $this->bedaWaktu($surat->tanggal_disetujui_sekretariat, $surat->tanggal_disetujui_dekan);


    $status = strtolower(trim($surat->status ?? 'pengajuan'));
    $catatan_penolakan = $surat->catatan_penolakan ?? null;
    $created_at = $surat->created_at ?? $surat->created_at;
    
    $steps = [];
    $progress_percentage = 0;
    
    // Step 1: Mengirim (Always completed)
    $steps[] = [
        'step_name' => 'Mengirim',
        'status' => 'completed',
        'date' => date('d M Y', strtotime($created_at)),
        'label' => 'Terkirim'
    ];
    
    // Tentukan status berdasarkan field status di database
    switch ($status) {
        case 'pengajuan':
            // Baru diajukan, menunggu KK
            $steps[] = [
                'step_name' => 'Dalam Proses',
                'status' => 'in-progress',
                'date' => '-',
                'label' => 'Dalam Proses'
            ];
            $steps[] = [
                'step_name' => 'Menunggu',
                'status' => 'pending',
                'date' => '-',
                'label' => 'Menunggu'
            ];
            $steps[] = [
                'step_name' => 'Menunggu',
                'status' => 'pending',
                'date' => '-',
                'label' => 'Menunggu'
            ];
            $progress_percentage = 35;
            break;
            
        case 'disetujui kk':
            // Sudah disetujui KK, menunggu Sekretariat
            $steps[] = [
                'step_name' => 'Disetujui Kaprodi',
                'status' => 'completed',
                'date' => date('d M Y'),
                'label' => 'Disetujui'
            ];
            $steps[] = [
                'step_name' => 'Dalam Proses',
                'status' => 'in-progress',
                'date' => '-',
                'label' => 'Dalam Proses'
            ];
            $steps[] = [
                'step_name' => 'Menunggu',
                'status' => 'pending',
                'date' => '-',
                'label' => 'Menunggu'
            ];
            $progress_percentage = 65;
            break;
            
        case 'disetujui sekretariat':
            // Sudah disetujui Sekretariat, menunggu Dekan
            $steps[] = [
                'step_name' => 'Disetujui Kaprodi',
                'status' => 'completed',
                'date' => date('d M Y'),
                'label' => 'Disetujui'
            ];
            $steps[] = [
                'step_name' => 'Disetujui Sekretariat',
                'status' => 'completed',
                'date' => date('d M Y'),
                'label' => 'Disetujui'
            ];
            $steps[] = [
                'step_name' => 'Dalam Proses',
                'status' => 'in-progress',
                'date' => '-',
                'label' => 'Dalam Proses'
            ];
            $progress_percentage = 95;
            break;
            
        case 'disetujui dekan':
        case 'selesai':
        case 'completed':
            // Semua sudah disetujui
            $steps[] = [
                'step_name' => 'Disetujui KK',
                'status' => 'completed',
                'date' => date('d M Y'),
                'label' => 'Disetujui'
            ];
            $steps[] = [
                'step_name' => 'Disetujui Sekretariat',
                'status' => 'completed',
                'date' => date('d M Y'),
                'label' => 'Disetujui'
            ];
            $steps[] = [
                'step_name' => 'Disetujui Dekan',
                'status' => 'completed',
                'date' => date('d M Y'),
                'label' => 'Disetujui'
            ];
            $progress_percentage = 100;
            break;
            
        case 'ditolak kk':
            // Ditolak di KK
            $steps[] = [
                'step_name' => 'Ditolak Kaprodi',
                'status' => 'rejected',
                'date' => date('d M Y'),
                'label' => 'Ditolak',
                'catatan_penolakan' => $catatan_penolakan
            ];
            $steps[] = [
                'step_name' => 'Menunggu',
                'status' => 'pending',
                'date' => '-',
                'label' => 'Menunggu'
            ];
            $steps[] = [
                'step_name' => 'Menunggu',
                'status' => 'pending',
                'date' => '-',
                'label' => 'Menunggu'
            ];
            $progress_percentage = 35;
            break;

        case 'ditolak sekretariat':
            // Ditolak di Sekretariat
            $steps[] = [
                'step_name' => 'Disetujui Kaprodi',
                'status' => 'completed',
                'date' => date('d M Y'),
                'label' => 'Disetujui'
            ];
            $steps[] = [
                'step_name' => 'Ditolak Sekretariat',
                'status' => 'rejected',
                'date' => date('d M Y'),
                'label' => 'Ditolak',
                'catatan_penolakan' => $catatan_penolakan
            ];
            $steps[] = [
                'step_name' => 'Menunggu',
                'status' => 'pending',
                'date' => '-',
                'label' => 'Menunggu'
            ];
            $progress_percentage = 65;
            break;

        case 'ditolak dekan':
            // Ditolak di Dekan
            $steps[] = [
                'step_name' => 'Disetujui Kaprodi',
                'status' => 'completed',
                'date' => date('d M Y'),
                'label' => 'Disetujui'
            ];
            $steps[] = [
                'step_name' => 'Disetujui Sekretariat',
                'status' => 'completed',
                'date' => date('d M Y'),
                'label' => 'Disetujui'
            ];
            $steps[] = [
                'step_name' => 'Ditolak Dekan',
                'status' => 'rejected',
                'date' => date('d M Y'),
                'label' => 'Ditolak',
                'catatan_penolakan' => $catatan_penolakan
            ];
            $progress_percentage = 100;
            break;
            
        default:
            // Default: status tidak dikenali, anggap sebagai pengajuan
            $steps[] = [
                'step_name' => 'Persetujuan KK',
                'status' => 'in-progress',
                'date' => '-',
                'label' => 'Dalam Proses'
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
    
    // Buat deskripsi status
    $status_description = '';
    switch ($status) {
        case 'pengajuan':
            $status_description = '⏳ Pengajuan Anda sedang menunggu persetujuan dari Kepala Kelompok (KK).';
            break;
        case 'disetujui kk':
            $status_description = '⏳ Pengajuan telah disetujui KK, sedang menunggu persetujuan Sekretariat.';
            break;
        case 'disetujui sekretariat':
            $status_description = '⏳ Pengajuan telah disetujui Sekretariat, sedang menunggu persetujuan Dekan.';
            break;
        case 'disetujui dekan':
        case 'selesai':
        case 'completed':
            $status_description = '✅ Selamat! Pengajuan Anda telah disetujui oleh semua pihak.';
            break;
        case 'ditolak kk':
            $status_description = '❌ Pengajuan Anda ditolak oleh Kepala Kelompok (KK).';
            break;
        case 'ditolak sekretariat':
            $status_description = '❌ Pengajuan Anda ditolak oleh Sekretariat.';
            break;
        case 'ditolak dekan':
            $status_description = '❌ Pengajuan Anda ditolak oleh Dekan.';
            break;
        default:
            $status_description = '⏳ Pengajuan Anda sedang dalam proses.';
            break;
    }
    
    $response = [
        'success' => true,
        'data' => [
        'steps' => $steps,
        'current_status' => $status,
        'status_raw' => $surat->status,
        'progress_percentage' => $progress_percentage,
        'catatan_penolakan' => $catatan_penolakan,
        'status_description' => $status_description,
        'durasi' => [
        'durasi_1' => (!empty($surat->tanggal_disetujui_kk)) 
                        ? $this->bedaWaktu($surat->created_at, $surat->tanggal_disetujui_kk)
                        : '-',

        'durasi_2' => (!empty($surat->tanggal_disetujui_sekretariat)) 
                        ? $this->bedaWaktu($surat->tanggal_disetujui_kk, $surat->tanggal_disetujui_sekretariat)
                        : '-',

        'durasi_3' => (!empty($surat->tanggal_disetujui_dekan)) 
                        ? $this->bedaWaktu($surat->tanggal_disetujui_sekretariat, $surat->tanggal_disetujui_dekan)
                        : '-',
    ]

]

    ];
    
    echo json_encode($response);
    log_message('error', print_r($surat, true));

}

private function bedaWaktu($start, $end)
{
    if (!$start || !$end) return '-';

    $mulai = new DateTime($start);
    $selesai = new DateTime($end);
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


    /* ===========================================
       SUBMIT DATA
    ============================================*/
    public function submit()
    {
        $post = $this->input->post() ?? [];

        foreach ($post as $k => $v) {
            if (is_array($v)) {
                $post[$k] = array_values(array_filter($v, fn($x) => trim($x) !== ""));
            } else {
                $post[$k] = ($v === "" || $v === null) ? "-" : $v;
            }
        }

        $tp_safe = $this->safe_date($post['created_at'] ?? null);
        $created_at = ($tp_safe === "-") ? date('Y-m-d') : $tp_safe;

        $eviden_raw = $post['eviden'] ?? [];

        if (!is_array($eviden_raw)) {
            $arr = array_map('trim', explode(",", $eviden_raw));
        } else {
            $arr = $eviden_raw;
        }

        $arr = array_values(array_filter($arr, fn($x) => trim($x) !== ""));

        $data = [
            'user_id' => $post['user_id'] ?? '-',
            'nama_kegiatan' => $post['nama_kegiatan'] ?? '-',
            'jenis_date' => $post['jenis_date'] ?? '-',
            'created_at' => $created_at,
            'tanggal_kegiatan' => $this->safe_date($post['tanggal_kegiatan']),
            'akhir_kegiatan' => $this->safe_date($post['akhir_kegiatan']),
            'periode_penugasan' => $this->safe_date($post['periode_penugasan']),
            'akhir_periode_penugasan' => $this->safe_date($post['akhir_periode_penugasan']),
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
            'nama_dosen' => json_encode($post['nama_dosen'] ?? []),
            'jabatan' => json_encode($post['jabatan'] ?? []),
            'divisi' => json_encode($post['divisi'] ?? []),

            'eviden' => json_encode($arr),

            'status' => 'pengajuan',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->Surat_model->insert_surat($data);

        $this->session->set_flashdata('success', 'Data berhasil disimpan!');
        redirect('surat');
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
       EDIT DATA
    ============================================*/
    public function edit($id)
    {
        $surat = $this->Surat_model->get_by_id($id);

        if (!$surat) show_404();

        $data['surat'] = (array)$surat;
        
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

        $post = $this->input->post();

        foreach ($post as $k => $v) {
            if (is_array($v)) {
                $post[$k] = array_values(array_filter($v, fn($x) => trim($x) !== ""));
            } else {
                $post[$k] = ($v === "" ? "-" : $v);
            }
        }

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
            'nama_dosen' => json_encode($post['nama_dosen']),
            'jabatan' => json_encode($post['jabatan']),
            'divisi' => json_encode($post['divisi']),

            'eviden' => $update_eviden
        ];

        if (!empty($post['created_at'])) {
            $tp = $this->safe_date($post['created_at']);
            if ($tp !== '-') $update['created_at'] = $tp;
        }

        $this->Surat_model->update_surat($id, $update);

        $this->session->set_flashdata('success', 'Data berhasil diperbarui!');
        redirect('surat');
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
        redirect('surat');
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

    /* ===========================================
       MULTI EDIT
    ============================================*/
    public function multi_edit()
    {
        $ids = $this->input->get('ids');

        if (!$ids) {
            $this->session->set_flashdata('error', 'Tidak ada data yang dipilih untuk di-edit.');
            redirect('surat');
            return;
        }

        $idArray = explode(',', $ids);
        
        $idArray = array_filter(array_map('intval', $idArray), function($id) {
            return $id > 0;
        });

        if (empty($idArray)) {
            $this->session->set_flashdata('error', 'ID yang diberikan tidak valid.');
            redirect('surat');
            return;
        }

        $data['surat_list'] = $this->Surat_model->getMultiByIds($idArray);

        if (empty($data['surat_list'])) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan untuk ID: ' . implode(', ', $idArray));
            redirect('surat');
            return;
        }

        $this->load->view('multi_edit_surat', $data);
    }

    /* ===========================================
       SAVE MULTI EDIT
    ============================================*/
    public function save_multi_edit()
    {
        if (!$this->input->post()) {
            $this->session->set_flashdata('error', 'Tidak ada data yang dikirim.');
            redirect('surat');
            return;
        }

        $post = $this->input->post();
        
        if (!isset($post['items']) || !is_array($post['items'])) {
            $this->session->set_flashdata('error', 'Format data tidak valid.');
            redirect('surat');
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
                'format' => $item['format'] ?? $existing->format,
                'jenis_penugasan_perorangan' => $item['jenis_penugasan_perorangan'] ?? $existing->jenis_penugasan_perorangan,
                'penugasan_lainnya_perorangan' => $item['penugasan_lainnya_perorangan'] ?? $existing->penugasan_lainnya_perorangan,
                'jenis_penugasan_kelompok' => $item['jenis_penugasan_kelompok'] ?? $existing->jenis_penugasan_kelompok,
                'penugasan_lainnya_kelompok' => $item['penugasan_lainnya_kelompok'] ?? $existing->penugasan_lainnya_kelompok,
                
                'nip' => isset($item['nip']) ? json_encode($item['nip']) : $existing->nip,
                'nama_dosen' => isset($item['nama_dosen']) ? json_encode($item['nama_dosen']) : $existing->nama_dosen,
                'jabatan' => isset($item['jabatan']) ? json_encode($item['jabatan']) : $existing->jabatan,
                'divisi' => isset($item['divisi']) ? json_encode($item['divisi']) : $existing->divisi,
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

        redirect('surat');
    }
    

    /* ===========================================
       CETAK SURAT
    ============================================*/
    public function cetak($id)
{
    $surat = $this->Surat_model->get_by_id($id);
    if (!$surat) show_404();

    // URL validasi
    $validation_url = "http://localhost/surat/validasi/" . $surat->id;

    // === QR Code (Endroid v4) ===
    $qrCode = QrCode::create($validation_url)
        ->setEncoding(new Encoding('UTF-8'))
        ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
        ->setSize(160);

    $writer = new PngWriter();
    $qrResult = $writer->write($qrCode);

    $qr_base64 = base64_encode($qrResult->getString());

    // Data ke view
    $data = [
        'surat' => $surat,
        'qr_base64' => $qr_base64
    ];

    $html = $this->load->view('surat_print', $data, TRUE);

    // PDF
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $filename = "surat_tugas_" . $surat->id . ".pdf";
    $dompdf->stream($filename, array("Attachment" => 1));
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
public function validasi($id)
{
    $surat = $this->Surat_model->get_by_id($id);
    if (!$surat) {
        $data['found'] = false;
    } else {
        $data['found'] = true;
        $data['surat'] = $surat;
    }

    $this->load->view('surat_validasi', $data);
}
    public function list_surat_tugas()
    {
        $data['surat_list'] = $this->Surat_model->get_all_surat();
        $this->load->view('list_surat_tugas', $data);
    }
}