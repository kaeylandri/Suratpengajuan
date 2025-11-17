<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property Surat_model $Surat_model
 * @property Dosen_model $Dosen_model
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 */

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
    private function safe_json_decode($value)
{
    // Jika null atau kosong → return array kosong
    if (!$value) return [];

    // Jika sudah array → langsung return
    if (is_array($value)) return $value;

    // Jika bukan string → return array kosong
    if (!is_string($value)) return [];

    // Decode string JSON
    $decode = json_decode($value, true);

    // Jika gagal decode → return array kosong
    return json_last_error() === JSON_ERROR_NONE ? $decode : [];
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
       DOWNLOAD VIA URL
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
       EDIT DATA — FIX EVIDEN
    ============================================*/
    public function edit($id)
    {
        $surat = $this->Surat_model->get_by_id($id);

        if (!$surat) show_404();

        $data['surat'] = (array)$surat;
        $data['eviden'] = json_decode($surat->eviden ?? "[]", true);

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
           FIX EVIDEN TANPA ERROR json_decode ARRAY
        ====================================================*/
        $eviden_raw = $post['eviden'] ?? null;

        if (is_array($eviden_raw)) {
            // Sudah array → langsung encode
            $update_eviden = json_encode($eviden_raw);

        } elseif (is_string($eviden_raw) && trim($eviden_raw) !== "") {

            $decode = json_decode($eviden_raw, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $update_eviden = json_encode($decode);
            } else {
                $update_eviden = $surat->eviden;
            }

        } else {
            // Tidak dikirim → pakai data lama
            $update_eviden = $surat->eviden;
        }

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
    public function cetak($id)
{
    // ambil data surat menggunakan model Surat
    $surat = $this->Surat_model->get_by_id($id);

    if (!$surat) show_404();

    // decode array id dosen dari field json
    $dosen_ids = $this->safe_json_decode($surat->nama_dosen);


    // load model dosen
    $this->load->model('Dosen_model');

    // ambil semua data dosen berdasarkan ID
    $list_dosen = $this->Dosen_model->get_dosen_by_ids($dosen_ids);

    $data = [
        'surat' => $surat,
        'list_dosen' => $list_dosen
    ];

    // load halaman cetak
    $this->load->view('surat_print', $data);
}


}
