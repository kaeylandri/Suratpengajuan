<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaprodi extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->database();
    }
    
    public function index() {

        // Status surat yang harus muncul di Kaprodi
        $this->db->where_in("status", ['pengajuan', 'pending_kaprodi']);
        $this->db->order_by("tanggal_pengajuan", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // Statistik
        $data['pending_count']  = $this->db->where_in('status', ['pengajuan', 'pending_kaprodi'])->count_all_results('surat');
        $data['approved_count'] = $this->db->where('status', 'approved_kaprodi')->count_all_results('surat');
        $data['rejected_count'] = $this->db->where('status', 'rejected_kaprodi')->count_all_results('surat');

        $this->load->view('kaprodi/dashboard', $data);
    }
    
   public function approve($id)
{
    $this->db->where('id', $id);
    $this->db->update('surat', [
        'status' => 'disetujui KK'
    ]);

    $this->session->set_flashdata('success', 'Surat diteruskan ke sekretariat.');
    redirect('kaprodi');
}


    public function reject($id) {
        $notes = $this->input->post('rejection_notes');
        
        $this->db->where('id', $id);
        $this->db->update('surat', ['status' => 'rejected_kaprodi']);
        
        $this->session->set_flashdata('success', 'Pengajuan ditolak');
        redirect('kaprodi');
    }
}
