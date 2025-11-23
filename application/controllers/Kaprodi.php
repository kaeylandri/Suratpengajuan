<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kaprodi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->model('Surat_model');
    }

    public function index()
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $data['tahun'] = $tahun;

        // ✅ STATISTIK YANG BENAR
        $data['total_surat'] = $this->db->where('YEAR(created_at)', $tahun)
                                        ->count_all_results('surat');

        $data['approved_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                          ->where_in('status', ['disetujui dekan', 'disetujui KK', 'disetujui sekretariat'])
                                          ->count_all_results('surat');

        $data['rejected_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                           ->where_in('status', ['ditolak KK', 'ditolak sekretariat'])
                                           ->count_all_results('surat');

        $data['pending_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                          ->where('status', 'pengajuan')
                                          ->count_all_results('surat');

        // ✅ Ambil daftar surat HANYA status pengajuan
        $this->db->where("status", 'pengajuan');
        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // ✅ GRAFIK BULANAN
        $total     = array_fill(0, 12, 0);
        $approved  = array_fill(0, 12, 0);
        $rejected  = array_fill(0, 12, 0);

        $this->db->where('YEAR(created_at)', $tahun);
        $query = $this->db->get('surat')->result();

        foreach ($query as $row) {
            $month = (int)date('m', strtotime($row->created_at)) - 1;
            $total[$month]++;

            if ($row->status == 'disetujui dekan') {
                $approved[$month]++;
            }
             if (in_array($row->status, ['ditolak KK', 'ditolak sekretariat'])) {
                $rejected[$month]++;
            }
        }

        $data['chart_total']    = $total;
        $data['chart_approved'] = $approved;
        $data['chart_rejected'] = $rejected;

        $this->load->view('kaprodi/dashboard', $data);
    }

    public function approve($id)
    {
        $surat = $this->db->get_where('surat', ['id' => $id])->row();
        
        if (!$surat) {
            $this->session->set_flashdata('error', 'Surat tidak ditemukan.');
            redirect('kaprodi');
        }

        $approval = json_decode($surat->approval_status, true) ?? [];

        $approval['kk'] = date("Y-m-d H:i:s");
        $this->db->where('id', $id)->update('surat', [
            'status' => 'disetujui KK',
            'approval_status' => json_encode($approval),
        ]);

        $this->session->set_flashdata('success', 'Surat berhasil disetujui Kaprodi.');
        redirect('kaprodi');
    }

    public function reject($id)
    {
        $surat = $this->db->get_where('surat', ['id' => $id])->row();
        
        if (!$surat) {
            $this->session->set_flashdata('error', 'Surat tidak ditemukan.');
            redirect('kaprodi');
        }

        $notes = $this->input->post('rejection_notes');
        $approval = json_decode($surat->approval_status, true) ?? [];

        $approval['kk'] = date("Y-m-d H:i:s");

        $this->db->where('id', $id)->update('surat', [
            'status' => 'ditolak KK',
            'approval_status' => json_encode($approval),
            'catatan_penolakan' => $notes,
        ]);

        $this->session->set_flashdata('success', 'Surat berhasil ditolak Kaprodi.');
        redirect('kaprodi');
    }

    // ✅ METHOD BARU: Get Detail Pengajuan untuk Popup
    public function getDetailPengajuan($id)
    {
        try {
            // Ambil data dari database
            $this->db->where('id', $id);
            $data = $this->db->get('surat')->row();

            if ($data) {
                // Format data untuk response
                $response = [
                    'success' => true,
                    'data' => [
                        'id' => $data->id,
                        'nama_kegiatan' => $data->nama_kegiatan ?? '-',
                        'jenis_pengajuan' => $data->jenis_pengajuan ?? '-',
                        'status' => $data->status ?? '-',
                        'lingkup_penugasan' => $data->lingkup_penugasan ?? '-',
                        'nama_dosen' => $data->nama_dosen ?? '-',
                        'nip' => $data->nip ?? '-',
                        'created_at' => $data->created_at ?? '-',
                        'tanggal_kegiatan' => $data->tanggal_kegiatan ?? '-',
                        'akhir_kegiatan' => $data->akhir_kegiatan ?? '-',
                        'penyelenggara' => $data->penyelenggara ?? '-',
                        'tempat_kegiatan' => $data->tempat_kegiatan ?? '-',
                        'eviden' => $data->eviden ?? '-',
                        'catatan_penolakan' => $data->catatan_penolakan ?? '-'
                    ]
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Data pengajuan tidak ditemukan'
                ];
            }

            // Set header JSON
            header('Content-Type: application/json');
            echo json_encode($response);

        } catch (Exception $e) {
            // Handle error
            $response = [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
            
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    // ✅ METHOD TAMBAHAN: Untuk halaman filtered
    public function semua()
    {
        $this->loadFilteredView('semua');
    }

    public function disetujui()
    {
        $this->loadFilteredView('disetujui');
    }

    public function ditolak()
    {
        $this->loadFilteredView('ditolak');
    }

    // ✅ METHOD BARU: Untuk halaman pending dengan search
    public function halaman_pending()
    {
        $search = $this->input->get('search');
        $tahun = $this->input->get('tahun') ?? date('Y');
        
        $data['tahun'] = $tahun;
        $data['page_title'] = 'Pengajuan Menunggu Persetujuan';

        // Query untuk data pending
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'pengajuan');

        // Jika ada pencarian
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->or_like('nip', $search);
            $this->db->group_end();
        }

        $this->db->order_by('created_at', 'DESC');
        $data['surat_list'] = $this->db->get('surat')->result();

        // Hitung total untuk pagination info
        $data['total_surat'] = count($data['surat_list']);

        // Load view halaman_pending
        $this->load->view('kaprodi/halaman_pending', $data);
    }

    // ✅ METHOD BARU: Untuk halaman rejected dengan search
    public function halaman_ditolak()
    {
        $search = $this->input->get('search');
        $tahun = $this->input->get('tahun') ?? date('Y');
        
        $data['tahun'] = $tahun;
        $data['page_title'] = 'Pengajuan Ditolak';

        // Query untuk data ditolak
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['ditolak KK', 'ditolak sekretariat']);

        // Jika ada pencarian
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->or_like('nip', $search);
            $this->db->group_end();
        }

        $this->db->order_by('created_at', 'DESC');
        $data['surat_list'] = $this->db->get('surat')->result();

        // Hitung total untuk pagination info
        $data['total_surat'] = count($data['surat_list']);

        // Load view halaman_ditolak
        $this->load->view('kaprodi/halaman_ditolak', $data);
    }

    // ✅ METHOD BARU: Untuk halaman approved dengan search
    public function halaman_disetujui()
    {
        $search = $this->input->get('search');
        $tahun = $this->input->get('tahun') ?? date('Y');
        
        $data['tahun'] = $tahun;
        $data['page_title'] = 'Pengajuan Disetujui';

        // Query untuk data disetujui
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui dekan', 'disetujui KK', 'disetujui sekretariat']);

        // Jika ada pencarian
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->or_like('nip', $search);
            $this->db->group_end();
        }

        $this->db->order_by('created_at', 'DESC');
        $data['surat_list'] = $this->db->get('surat')->result();

        // Hitung total untuk pagination info
        $data['total_surat'] = count($data['surat_list']);

        // Load view halaman_disetujui
        $this->load->view('kaprodi/halaman_disetujui', $data);
    }

    private function loadFilteredView($type)
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $data['tahun'] = $tahun;

        // Query berdasarkan jenis filter
        switch ($type) {
            case 'semua':
                $this->db->where('YEAR(created_at)', $tahun);
                $data['surat_list'] = $this->db->get('surat')->result();
                $data['page_title'] = 'Semua Pengajuan';
                break;
                
            case 'disetujui':
                $this->db->where('YEAR(created_at)', $tahun)
                         ->where_in('status', ['disetujui dekan', 'disetujui KK', 'disetujui sekretariat']);
                $data['surat_list'] = $this->db->get('surat')->result();
                $data['page_title'] = 'Pengajuan Disetujui';
                break;
                
            case 'ditolak':
                $this->db->where('YEAR(created_at)', $tahun)
                         ->where_in('status', ['ditolak KK', 'ditolak sekretariat']);
                $data['surat_list'] = $this->db->get('surat')->result();
                $data['page_title'] = 'Pengajuan Ditolak';
                break;
        }

        // Hitung statistik untuk card
        $data['total_surat'] = $this->db->where('YEAR(created_at)', $tahun)->count_all_results('surat');
        $data['approved_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                          ->where_in('status', ['disetujui dekan', 'disetujui KK', 'disetujui sekretariat'])
                                          ->count_all_results('surat');
        $data['rejected_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                           ->where_in('status', ['ditolak KK', 'ditolak sekretariat'])
                                           ->count_all_results('surat');
        $data['pending_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                          ->where('status', 'pengajuan')
                                          ->count_all_results('surat');

        // Load view yang sama dengan data berbeda
        $this->load->view('kaprodi/dashboard', $data);
    }
}