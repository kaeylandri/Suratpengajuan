<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dekan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->database();
    }
    
    public function index()
{
    // Surat yang sudah disetujui kaprodi akan masuk ke sekretariat
    $this->db->where_in("status", ['disetujui sekretariat']);
    $this->db->order_by("created_at", "DESC");
    $data['surat_list'] = $this->db->get("surat")->result_array(); // WAJIB result_array()

    // Statistik
    $data['pending_count']  = $this->db->where('status', 'disetujui sekretariat')->count_all_results('surat');
    $data['approved_count'] = $this->db->where('status', 'disetujui dekan')->count_all_results('surat');
    $data['rejected_count'] = $this->db->where('status', 'ditolak dekan')->count_all_results('surat');

    
        // Statistik dengan filter bulan
        $current_month = date('m');
        $current_year = date('Y');
        
        // Menunggu persetujuan sekretariat
        $data['pending_count'] = $this->db->where('status', 'disetujui KK')->count_all_results('surat');
        
        // Disetujui bulan ini oleh sekretariat
        $data['approved_count'] = $this->db->where('status', 'disetujui dekan')
            ->where('MONTH(tanggal_pengajuan)', $current_month)
            ->where('YEAR(tanggal_pengajuan)', $current_year)
            ->count_all_results('surat');
            
        // Ditolak bulan ini OLEH KAPRODI ATAU SEKRETARIAT
        $data['rejected_count'] = $this->db->where_in('status', ['ditolak KK', 'ditolak sekretariat'])
            ->where('MONTH(tanggal_pengajuan)', $current_month)
            ->where('YEAR(tanggal_pengajuan)', $current_year)
            ->count_all_results('surat');

    $this->load->view('dekan/dashboard', $data);
}

    public function approve($id) {

        $this->db->where('id', $id);
        $this->db->update('surat', [
            'status' => 'disetujui dekan'
        ]);

        $this->session->set_flashdata('success', 'Surat telah disetujui Dekan.');
        redirect('dekan');
    }
    
    public function reject($id) {
        $notes = $this->input->post('rejection_notes');
        
        $this->db->where('id', $id);
        $this->db->update('surat', [
            'status' => 'ditolak dekan',
            'catatan_penolakan' => $notes
        ]);
        
        $this->session->set_flashdata('success', 'Pengajuan ditolak oleh Dekan.');
        redirect('sekretariat');
    }
}
