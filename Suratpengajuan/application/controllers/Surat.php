<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
        return $ts ? date('Y-m-d', $ts) : "-";
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
       SUBMIT DATA — FIX EVIDEN UPLOADCARE
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

        // Tanggal pengajuan
        $tp_safe = $this->safe_date($post['tanggal_pengajuan'] ?? null);
        $tanggal_pengajuan = ($tp_safe === "-") ? date('Y-m-d') : $tp_safe;

        // --- HANDLE EVIDEN (UploadCare) ---
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
            'tanggal_pengajuan' => $tanggal_pengajuan,
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

            'eviden' => json_encode($arr)
        ];

        $this->Surat_model->insert_surat($data);

        $this->session->set_flashdata('success', 'Data berhasil disimpan!');
        redirect('surat');
    }

    /* ===========================================
       DOWNLOAD VIA URL (Legacy - untuk UploadCare)
    ============================================*/
    public function download_eviden_url()
    {
        $url = $this->input->get('url');
        $name = $this->input->get('name') ?? "eviden";

        if (!$url) show_404();

        header("Content-Disposition: attachment; filename=\"$name\"");
        readfile($url);
    }

    /* ===========================================
       DOWNLOAD EVIDEN FILE - NEW METHOD
    ============================================*/
    public function download_eviden($filename = null)
    {
        if (!$filename) {
            show_404();
            return;
        }

        // Decode filename jika di-encode
        $filename = urldecode($filename);

        // Cek apakah file adalah URL (UploadCare atau external)
        if (filter_var($filename, FILTER_VALIDATE_URL)) {
            // Download dari URL external
            $this->_download_from_url($filename);
            return;
        }

        // File lokal - cek keamanan path
        $safe_filename = basename($filename);
        $filepath = './uploads/eviden/' . $safe_filename;

        if (!file_exists($filepath)) {
            show_404();
            return;
        }

        // Get mime type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $filepath);
        finfo_close($finfo);

        // Clear any previous output
        if (ob_get_level()) {
            ob_end_clean();
        }

        // Set headers untuk force download
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: attachment; filename="' . $safe_filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        
        // Flush output
        flush();
        
        // Read and output file
        readfile($filepath);
        exit;
    }

    /* ===========================================
       HELPER: DOWNLOAD FROM EXTERNAL URL
    ============================================*/
    private function _download_from_url($url)
    {
        // Get filename dari URL
        $filename = basename(parse_url($url, PHP_URL_PATH));
        
        if (empty($filename)) {
            $filename = 'download_' . time();
        }

        // Get file content
        $file_content = @file_get_contents($url);
        
        if ($file_content === false) {
            show_404();
            return;
        }

        // Detect mime type from content
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_buffer($finfo, $file_content);
        finfo_close($finfo);

        // Clear any previous output
        if (ob_get_level()) {
            ob_end_clean();
        }

        // Set headers untuk force download
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . strlen($file_content));
        
        // Flush output
        flush();
        
        // Output file content
        echo $file_content;
        exit;
    }

    /* ===========================================
       EDIT DATA — FIX EVIDEN DENGAN UPLOAD FILE
    ============================================*/
    public function edit($id)
    {
        $surat = $this->Surat_model->get_by_id($id);

        if (!$surat) show_404();

        // Convert object to array
        $data['surat'] = (array)$surat;
        
        // PERBAIKAN: Decode eviden dengan benar
        $eviden_raw = $surat->eviden ?? "[]";
        
        // Jika masih string JSON, decode
        if (is_string($eviden_raw)) {
            $eviden_decoded = json_decode($eviden_raw, true);
            $data['eviden'] = is_array($eviden_decoded) ? $eviden_decoded : [];
        } else {
            $data['eviden'] = is_array($eviden_raw) ? $eviden_raw : [];
        }

        // Debug: uncomment untuk cek isi eviden
        // echo '<pre>'; print_r($data['eviden']); die();

        // Jika belum submit → tampilkan view edit
        if (!$this->input->post()) {
            $this->load->view('edit_surat', $data);
            return;
        }

        // === USER MENEKAN SAVE ===
        $post = $this->input->post();

        foreach ($post as $k => $v) {
            if (is_array($v)) {
                $post[$k] = array_values(array_filter($v, fn($x) => trim($x) !== ""));
            } else {
                $post[$k] = ($v === "" ? "-" : $v);
            }
        }

        /* ===================================================
           FIX EVIDEN UPDATE LOGIC - SUPPORT UPLOAD FILE
        ====================================================*/
        
        // 1. Ambil existing eviden dari database
        $existing_eviden = json_decode($surat->eviden, true) ?: [];
        
        // 2. Handle file yang dihapus
        $deleted_files = $post['delete_eviden'] ?? [];
        foreach ($deleted_files as $del_file) {
            if ($del_file && trim($del_file) !== '') {
                // Hapus dari array
                $existing_eviden = array_filter($existing_eviden, fn($f) => $f !== $del_file);
                
                // Hapus file fisik dari server (jika bukan URL external)
                if (!filter_var($del_file, FILTER_VALIDATE_URL)) {
                    $file_path = './uploads/eviden/' . $del_file;
                    if (file_exists($file_path)) {
                        @unlink($file_path);
                    }
                }
            }
        }
        
        // 3. Handle upload file baru
        $new_files = [];
        if (!empty($_FILES['new_eviden']['name'][0])) {
            
            $upload_path = './uploads/eviden/';
            
            // Buat folder jika belum ada
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0755, true);
            }
            
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx|xls|xlsx';
            $config['max_size'] = 10240; // 10MB
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
                        // Log error jika upload gagal
                        log_message('error', 'Upload failed: ' . $this->upload->display_errors());
                    }
                }
            }
        }
        
        // 4. Gabungkan existing files (yang tidak dihapus) dengan file baru
        $final_eviden = array_merge(array_values($existing_eviden), $new_files);
        
        // 5. Encode ke JSON
        $update_eviden = json_encode($final_eviden);

        // ---------------- UPDATE DATA ----------------
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

        // Update tanggal pengajuan jika diganti
        if (!empty($post['tanggal_pengajuan'])) {
            $tp = $this->safe_date($post['tanggal_pengajuan']);
            if ($tp !== '-') $update['tanggal_pengajuan'] = $tp;
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
        // Ambil data surat untuk hapus file eviden
        $surat = $this->Surat_model->get_by_id($id);
        
        if ($surat) {
            // Hapus semua file eviden yang terkait
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
       GET DOSEN BY NIP
    ============================================*/
    public function get_dosen_by_nip()
    {
        $nip = $this->input->get('nip');
        if (!$nip) { echo json_encode(['status' => false]); return; }

        $row = $this->db->get_where('list_dosen', ['nip' => $nip])->row();

        echo json_encode(
            $row ? [
                'status' => true,
                'nip' => $row->nip,
                'nama_dosen' => $row->nama_dosen,
                'jabatan' => $row->jabatan,
                'divisi' => $row->divisi
            ] : ['status' => false]
        );
    }
/* ===========================================
   DEBUG EVIDEN - TAMBAHKAN DI CONTROLLER
   Method untuk cek data eviden di database
============================================*/

public function debug_eviden($id)
{
    $surat = $this->Surat_model->get_by_id($id);
    
    if (!$surat) {
        die('Data tidak ditemukan');
    }
    
    echo "<h2>Debug Eviden - ID: $id</h2>";
    echo "<hr>";
    
    echo "<h3>Raw Data dari Database:</h3>";
    echo "<pre>";
    print_r($surat);
    echo "</pre>";
    
    echo "<hr>";
    
    echo "<h3>Eviden Field (Raw):</h3>";
    echo "<code>" . htmlspecialchars($surat->eviden ?? 'NULL') . "</code>";
    
    echo "<hr>";
    
    echo "<h3>Eviden Decoded:</h3>";
    $eviden = json_decode($surat->eviden ?? '[]', true);
    echo "<pre>";
    print_r($eviden);
    echo "</pre>";
    
    echo "<hr>";
    
    echo "<h3>Analisis Eviden:</h3>";
    if (is_array($eviden)) {
        foreach ($eviden as $idx => $file) {
            echo "<strong>[$idx]</strong> $file<br>";
            echo "- Is URL: " . (filter_var($file, FILTER_VALIDATE_URL) ? 'YES' : 'NO') . "<br>";
            echo "- Contains ucarecdn: " . (strpos($file, 'ucarecdn.com') !== false ? 'YES' : 'NO') . "<br>";
            echo "- Contains tilde (~): " . (strpos($file, '~') !== false ? 'YES' : 'NO') . "<br>";
            
            if (filter_var($file, FILTER_VALIDATE_URL)) {
                echo "- <strong style='color: green;'>Ini adalah URL UploadCare yang valid</strong><br>";
                echo "- Download URL: <a href='" . site_url('surat/download_eviden_url?url=' . urlencode($file)) . "' target='_blank'>Test Download</a><br>";
            } else {
                $local_path = './uploads/eviden/' . basename($file);
                echo "- File lokal path: $local_path<br>";
                echo "- File exists: " . (file_exists($local_path) ? 'YES' : 'NO') . "<br>";
            }
            
            echo "<br>";
        }
    } else {
        echo "<em>Eviden bukan array atau kosong</em>";
    }
}
    /* ===========================================
       AUTOCOMPLETE NIP
    ============================================*/
    public function autocomplete_nip()
    {
        $term = $this->input->get('term') ?? $this->input->get('q');
        if (!$term) { echo json_encode([]); return; }

        $this->db->select('nip,nama_dosen,jabatan,divisi')
            ->group_start()
            ->like('nip', $term)
            ->or_like('nama_dosen', $term)
            ->or_like('jabatan', $term)
            ->or_like('divisi', $term)
            ->group_end()
            ->limit(10);

        $result = $this->db->get('list_dosen')->result();

        $out = [];
        foreach ($result as $r) {
            $out[] = [
                'nip' => $r->nip,
                'nama_dosen' => $r->nama_dosen,
                'jabatan' => $r->jabatan,
                'divisi' => $r->divisi,
                'label' => "{$r->nip} - {$r->nama_dosen}",
                'value' => $r->nip
            ];
        }

        echo json_encode($out);
    }
}