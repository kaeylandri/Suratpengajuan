<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kaprodi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
    }

    public function index()
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $data['tahun'] = $tahun;

         // Statistik
    $data['total_surat'] = $this->db->count_all_results('surat');

    $data['approved_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                      ->where('status', 'disetujui dekan')
                                      ->count_all_results('surat');

    $data['pending_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                      ->where('status', 'pengajuan')
                                      ->count_all_results('surat');

    $data['rejected_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                       ->where_in('status', ['ditolak KK', 'ditolak sekretariat'])
                                       ->count_all_results('surat');

        // Ambil daftar surat untuk tabel
        $this->db->where("status", 'pengajuan');
        $this->db->order_by("tanggal_pengajuan", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();


                                       
        // Grafik
        $total     = array_fill(0, 12, 0);
        $approved  = array_fill(0, 12, 0);
        $rejected  = array_fill(0, 12, 0);

        $this->db->where('YEAR(tanggal_pengajuan)', $tahun);
        $query = $this->db->get('surat')->result();

        foreach ($query as $row) {
            $month = (int)date('m', strtotime($row->tanggal_pengajuan)) - 1;

            $total[$month]++;

            if ($row->status == 'disetujui KK') {
                $approved[$month]++;
            }

            if ($row->status == 'ditolak KK') {
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
        $this->db->where('id', $id)->update('surat', [
            'status' => 'disetujui KK',
        ]);

        $this->session->set_flashdata('success', 'Surat berhasil disetujui Kaprodi.');
        redirect('kaprodi');
    }

    public function reject($id)
    {
        $notes = $this->input->post('rejection_notes');

        $this->db->where('id', $id)->update('surat', [
            'status' => 'ditolak KK',
            'catatan_penolakan' => $notes,
        ]);

        $this->session->set_flashdata('success', 'Surat berhasil ditolak Kaprodi.');
        redirect('kaprodi');
    }

    public function list_surat_tugas()
    {
        // Semua surat yang diproses Kaprodi
        $this->db->where_in("status", [
            'disetujui sekretariat',
            'disetujui KK',
            'ditolak KK'
        ]);
        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // Statistik
        $data['approved_count'] = $this->db->where('status', 'disetujui KK')->count_all_results('surat');
        $data['pending_count'] = $this->db->where('status', 'disetujui sekretariat')->count_all_results('surat');
        $data['rejected_count'] = $this->db->where('status', 'ditolak KK')->count_all_results('surat');
        $data['total_count']    = $this->db->count_all_results('surat');

        $this->load->view('kaprodi/list_surat_tugas', $data);
    }

    public function detail($id)
    {
        $this->db->where('id', $id);
        $data['surat'] = $this->db->get("surat")->row();

        if (!$data['surat']) {
            show_404();
        }

        $this->load->view('kaprodi/detail_surat', $data);
    }

    public function get_surat_detail($id)
    {
        $this->db->where('id', $id);
        $surat = $this->db->get("surat")->row();

        echo json_encode($surat ? $surat : ['error' => 'Data tidak ditemukan']);
    }

    public function filter($status = '')
    {
        $this->db->order_by("created_at", "DESC");

        if ($status == 'menunggu') {
            $this->db->where('status', 'disetujui sekretariat');
        } 
        elseif ($status == 'disetujui') {
            $this->db->where('status', 'disetujui KK');
        } 
        elseif ($status == 'ditolak') {
            $this->db->where('status', 'ditolak KK');
        } 
        else {
            $this->db->where_in('status', [
                'disetujui sekretariat',
                'disetujui KK',
                'ditolak KK'
            ]);
        }

        $data['surat_list'] = $this->db->get("surat")->result();
        $data['current_filter'] = $status;

        $this->load->view('kaprodi/list_surat_tugas', $data);
    }
}
