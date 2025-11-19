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

    public function index()
{
    // Statistik
    $data['total_surat'] = $this->db->count_all('surat');
    $data['approved_count'] = $this->db->where('status', 'disetujui dekan')->count_all_results('surat');
    $data['pending_count'] = $this->db->where('status', 'disetujui sekretariat')->count_all_results('surat');
    $data['rejected_count'] = $this->db->where_in('status', ['ditolak KK', 'ditolak sekretariat'])->count_all_results('surat');

    // Surat yg akan tampil ke Dekan = yg sudah disetujui sekretariat
    $this->db->where('status', 'disetujui sekretariat');
    $this->db->order_by('created_at', 'DESC');
    $data['surat_list'] = $this->db->get('surat')->result_array();

    // Data grafik (sesuai kode Anda)
    $bulan = array_fill(0, 12, 0);
    $disetujui = array_fill(0, 12, 0);
    $ditolak = array_fill(0, 12, 0);

    $surat = $this->db->get('surat')->result();

    foreach ($surat as $s) {
        $monthIndex = (int)date('m', strtotime($s->created_at)) - 1;

        $bulan[$monthIndex]++;

        if ($s->status == 'disetujui dekan') {
            $disetujui[$monthIndex]++;
        }

        if (in_array($s->status, ['ditolak KK', 'ditolak sekretariat'])) {
            $ditolak[$monthIndex]++;
        }
    }

    $data['chart_total'] = $bulan;
    $data['chart_approved'] = $disetujui;
    $data['chart_rejected'] = $ditolak;

    $this->load->view('dekan/dashboard', $data);
}




    public function approve($id)
{
    $this->db->where('id', $id)->update('surat', [
        'status' => 'disetujui dekan',
        'approved_by_dekan' => date('Y-m-d H:i:s')
    ]);

    $this->session->set_flashdata('success', 'Surat berhasil disetujui oleh Dekan.');
    redirect('dekan');
}

public function reject($id)
{
    $notes = $this->input->post('rejection_notes');

    // Dekan tidak memutuskan ditolak, tetapi mengembalikan ke sekretariat
    $this->db->where('id', $id)->update('surat', [
        'status' => 'pengajuan',
        'catatan_dekan' => $notes,
        'updated_at' => date('Y-m-d H:i:s')
    ]);

    $this->session->set_flashdata('success', 'Surat dikembalikan ke Sekretariat.');
    redirect('dekan');
}

    public function list_surat_tugas()
    {
        // Semua surat yg pernah diproses Dekan
        $this->db->where_in("status", [
            'disetujui sekretariat',
            'disetujui dekan',
            'kembalikan ke sekretariat'
        ]);
        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // Statistik mengikuti aturan baru
        $data['approved_count'] = $this->db->where('status', 'disetujui dekan')->count_all_results('surat');
        $data['pending_count'] = $this->db->where('status', 'disetujui sekretariat')->count_all_results('surat');
        $data['rejected_count'] = $this->db->where_in('status', ['ditolak KK', 'ditolak sekretariat'])->count_all_results('surat');
        $data['total_count'] = $this->db->count_all_results('surat');

        $this->load->view('dekan/list_surat_tugas', $data);
    }

    public function laporan()
    {
        $data['stats'] = [
            'total_surat'        => $this->db->count_all_results('surat'),
            'surat_bulan_ini'    => $this->db->like('created_at', date('Y-m'))->count_all_results('surat'),
            'surat_diselesaikan' => $this->db->where('status', 'disetujui dekan')->count_all_results('surat'),
            'surat_ditolak'      => $this->db->where_in('status', ['ditolak KK', 'ditolak sekretariat'])->count_all_results('surat'),
            'surat_menunggu'     => $this->db->where('status', 'disetujui sekretariat')->count_all_results('surat')
        ];

        $this->load->view('dekan/laporan', $data);
    }
    

    public function detail($id)
    {
        $this->db->where('id', $id);
        $data['surat'] = $this->db->get("surat")->row();

        if (!$data['surat']) {
            show_404();
        }

        $this->load->view('dekan/detail_surat', $data);
    }

    public function get_surat_detail($id)
    {
        $this->db->where('id', $id);
        $surat = $this->db->get("surat")->row();

        echo json_encode($surat ? $surat : ['error' => 'Data tidak ditemukan']);
    }

    // Filter laporan sesuai aturan baru
    public function filter($status = '')
    {
        $this->db->order_by("created_at", "DESC");

        if ($status == 'menunggu') {
            $this->db->where('status', 'disetujui sekretariat');
        } 
        elseif ($status == 'disetujui') {
            $this->db->where('status', 'disetujui dekan');
        } 
        elseif ($status == 'ditolak') {
            // DITOLAK = KK + sekretariat, BUKAN dekan
            $this->db->where_in('status', ['ditolak KK', 'ditolak sekretariat']);
        } 
        else {
            // Semua yg terkait Dekan
            $this->db->where_in('status', [
                'disetujui sekretariat',
                'disetujui dekan',
                'kembalikan ke sekretariat'
            ]);
        }

        $data['surat_list'] = $this->db->get("surat")->result();
        $data['current_filter'] = $status;

        $this->load->view('dekan/list_surat_tugas', $data);
    }
}
