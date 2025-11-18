<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dekan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->database();
    }
    
    public function index() {
        // Status surat yang harus muncul di Dekan (setelah disetujui Sekretariat)
        $this->db->where("status", 'disetujui sekretariat');
        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // Statistik untuk dashboard
        $data['total_surat'] = $this->db->count_all_results('surat');
        $data['pending_count'] = $this->db->where('status', 'disetujui sekretariat')->count_all_results('surat');
        $data['approved_count'] = $this->db->where('status', 'disetujui dekan')->count_all_results('surat');
        $data['rejected_count'] = $this->db->where('status', 'ditolak dekan')->count_all_results('surat');

        $this->load->view('dekan/dashboard', $data);
    }
    
    public function approve($id) {
        $this->db->where('id', $id);
        $this->db->update('surat', [
            'status' => 'disetujui dekan',
            'approved_by_dekan' => date('Y-m-d H:i:s')
        ]);

        $this->session->set_flashdata('success', 'Surat tugas berhasil disetujui Dekan.');
        redirect('dekan');
    }
    
    public function reject($id) {
        $notes = $this->input->post('rejection_notes');

        $this->db->where('id', $id);
        $this->db->update('surat', [
            'status' => 'ditolak dekan',
            'catatan_dekan' => $notes
        ]);

        $this->session->set_flashdata('success', 'Surat tugas ditolak Dekan.');
        redirect('dekan');
    }

    public function list_surat_tugas() {
        // Semua surat yang pernah melalui tahap Dekan
        $this->db->where_in("status", ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // Statistik
        $data['pending_count'] = $this->db->where('status', 'disetujui sekretariat')->count_all_results('surat');
        $data['approved_count'] = $this->db->where('status', 'disetujui dekan')->count_all_results('surat');
        $data['rejected_count'] = $this->db->where('status', 'ditolak dekan')->count_all_results('surat');
        $data['total_count'] = $this->db->count_all_results('surat');

        $this->load->view('dekan/list_surat_tugas', $data);
    }

    public function laporan() {
        // Data untuk laporan statistik
        $data['stats'] = [
            'total_surat' => $this->db->count_all_results('surat'),
            'surat_bulan_ini' => $this->db->like('created_at', date('Y-m'))->count_all_results('surat'),
            'surat_diselesaikan' => $this->db->where('status', 'disetujui dekan')->count_all_results('surat'),
            'surat_ditolak' => $this->db->where('status', 'ditolak dekan')->count_all_results('surat'),
            'surat_menunggu' => $this->db->where('status', 'disetujui sekretariat')->count_all_results('surat')
        ];

        $this->load->view('dekan/laporan', $data);
    }

    // Method untuk melihat detail surat
    public function detail($id) {
        $this->db->where('id', $id);
        $data['surat'] = $this->db->get("surat")->row();

        if (!$data['surat']) {
            show_404();
        }

        $this->load->view('dekan/detail_surat', $data);
    }

    // Method untuk AJAX get detail surat
    public function get_surat_detail($id) {
        $this->db->where('id', $id);
        $surat = $this->db->get("surat")->row();

        if ($surat) {
            echo json_encode($surat);
        } else {
            echo json_encode(['error' => 'Data tidak ditemukan']);
        }
    }

    // Method untuk filter surat berdasarkan status
    public function filter($status = '') {
        $this->db->order_by("created_at", "DESC");
        
        if ($status == 'menunggu') {
            $this->db->where('status', 'disetujui sekretariat');
        } elseif ($status == 'disetujui') {
            $this->db->where('status', 'disetujui dekan');
        } elseif ($status == 'ditolak') {
            $this->db->where('status', 'ditolak dekan');
        } else {
            // Tampilkan semua yang terkait dekan
            $this->db->where_in("status", ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        }
        
        $data['surat_list'] = $this->db->get("surat")->result();
        $data['current_filter'] = $status;

        $this->load->view('dekan/list_surat_tugas', $data);
    }
}