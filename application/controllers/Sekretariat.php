<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sekretariat extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->database();
    }
    
    public function index()
{
    // Surat yang sudah disetujui kaprodi akan masuk ke sekretariat
    $this->db->where_in("status", ['disetujui KK']);
    $this->db->order_by("created_at", "DESC");
    $data['surat_list'] = $this->db->get("surat")->result_array(); // WAJIB result_array()

    // Statistik
    $data['pending_count']  = $this->db->where('status', 'disetujui KK')->count_all_results('surat');
    $data['approved_count'] = $this->db->where('status', 'approved_sekretariat')->count_all_results('surat');
    $data['rejected_count'] = $this->db->where('status', 'rejected_sekretariat')->count_all_results('surat');

    $this->load->view('sekretariat/dashboard', $data);
}


    
    public function approve($id) {

        $this->db->where('id', $id);
        $this->db->update('surat', [
            'status' => 'approved_sekretariat'
        ]);

        $this->session->set_flashdata('success', 'Surat telah disetujui sekretariat.');
        redirect('sekretariat');
    }
    
    public function reject($id) {
        $notes = $this->input->post('rejection_notes');
        
        $this->db->where('id', $id);
        $this->db->update('surat', [
            'status' => 'rejected_sekretariat',
            'catatan_penolakan' => $notes
        ]);
        
        $this->session->set_flashdata('success', 'Pengajuan ditolak oleh sekretariat.');
        redirect('sekretariat');
    }
}
