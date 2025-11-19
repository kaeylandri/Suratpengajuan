<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaprodi extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
    }
    
    public function index() {
        // Status surat yang harus muncul di Kaprodi (hanya yang pengajuan)
        $this->db->where("status", 'pengajuan');
        $this->db->order_by("tanggal_pengajuan", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // Statistik dengan filter bulan dan tahun berjalan
        $current_month = date('m');
        $current_year = date('Y');
        
        // Menunggu persetujuan (hanya status pengajuan)
        $data['pending_count'] = $this->db->where('status', 'pengajuan')->count_all_results('surat');
        
        // Disetujui bulan ini (status disetujui KK dan created_at bulan ini)
        $data['approved_count'] = $this->db->where('status', 'disetujui dekan')
            ->where('MONTH(tanggal_pengajuan)', $current_month)
            ->where('YEAR(tanggal_pengajuan)', $current_year)
            ->count_all_results('surat');
            
        // Ditolak bulan ini (status ditolak KK dan created_at bulan ini)
        $data['rejected_count'] = $this->db->where_in('status', ['ditolak KK', 'ditolak sekretariat'])
            ->where('MONTH(tanggal_pengajuan)', $current_month)
            ->where('YEAR(tanggal_pengajuan)', $current_year)
            ->count_all_results('surat');

        $this->load->view('kaprodi/dashboard', $data);
    }
    
    public function approve($id) {
        $this->db->where('id', $id);
        $this->db->update('surat', [
            'status' => 'disetujui KK'
            // Tidak perlu disetujui_pada
        ]);

        $this->session->set_flashdata('success', 'Surat diteruskan ke sekretariat.');
        redirect('kaprodi');
    }

    public function reject($id) {
        $notes = $this->input->post('rejection_notes');
        
        $this->db->where('id', $id);
        $this->db->update('surat', [
            'status' => 'ditolak KK',
            'catatan_penolakan' => $notes
            // Tidak perlu ditolak_pada
        ]);
        
        $this->session->set_flashdata('success', 'Pengajuan ditolak');
        redirect('kaprodi');
    }
}