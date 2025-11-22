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

        // ✅ STATISTIK YANG BENAR
        // Total semua surat tahun ini
        $data['total_surat'] = $this->db->where('YEAR(created_at)', $tahun)
                                        ->count_all_results('surat');

        // Disetujui KK tahun ini
        $data['approved_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                          ->where_in('status', ['disetujui dekan', 'disetujui KK', 'disetujui sekretariat'])
                                          ->count_all_results('surat');

        // Ditolak KK tahun ini
        $data['rejected_count'] = $this->db->where('YEAR(created_at)', $tahun)
                                           ->where_in('status', ['ditolak KK', 'ditolak sekretariat'])
                                           ->count_all_results('surat');

        // Menunggu (status pengajuan) tahun ini
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
        $approval = json_decode($surat->approval_status, true);

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
        $notes = $this->input->post('rejection_notes');
        $approval = json_decode($surat->approval_status, true);

        $approval['kk'] = date("Y-m-d H:i:s");

        $this->db->where('id', $id)->update('surat', [
            'status' => 'ditolak KK',
            'approval_status' => json_encode($approval),
            'catatan_penolakan' => $notes,
        ]);

        $this->session->set_flashdata('success', 'Surat berhasil ditolak Kaprodi.');
        redirect('kaprodi');
    }
}