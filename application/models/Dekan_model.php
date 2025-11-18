<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dekan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_dashboard_stats() {
        $stats = array(
            'total_surat_tugas' => $this->db->count_all('surat_tugas'),
            'surat_pending' => $this->db->where('status', 'pending')->count_all_results('surat_tugas'),
            'surat_approved' => $this->db->where('status', 'approved')->count_all_results('surat_tugas'),
            'total_peminjaman' => $this->db->count_all('peminjaman_ruangan'),
            'ticketing_open' => $this->db->where('status', 'open')->count_all_results('ticketing')
        );
        return $stats;
    }

    public function get_surat_tugas_terbaru($limit = 5) {
        $this->db->select('*');
        $this->db->from('surat_tugas');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function get_peminjaman_ruangan($limit = 5) {
        $this->db->select('*');
        $this->db->from('peminjaman_ruangan');
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function get_ticketing_terbaru($limit = 5) {
        $this->db->select('*');
        $this->db->from('ticketing');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function get_all_surat_tugas() {
        $this->db->select('st.*, u.nama as pic_nama');
        $this->db->from('surat_tugas st');
        $this->db->join('users u', 'st.user_id = u.id', 'left');
        $this->db->order_by('st.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function approve_surat_tugas($id) {
        $data = array(
            'status' => 'approved',
            'approved_by' => $this->session->userdata('user_id'),
            'approved_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $id);
        return $this->db->update('surat_tugas', $data);
    }

    public function reject_surat_tugas($id) {
        $data = array(
            'status' => 'rejected',
            'approved_by' => $this->session->userdata('user_id'),
            'approved_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $id);
        return $this->db->update('surat_tugas', $data);
    }

    public function get_stats_periode() {
        $current_month = date('Y-m');
        
        $stats = array(
            'surat_bulan_ini' => $this->db->where("DATE_FORMAT(created_at, '%Y-%m') =", $current_month)
                                         ->count_all_results('surat_tugas'),
            'peminjaman_bulan_ini' => $this->db->where("DATE_FORMAT(tanggal, '%Y-%m') =", $current_month)
                                             ->count_all_results('peminjaman_ruangan'),
            'ticketing_bulan_ini' => $this->db->where("DATE_FORMAT(created_at, '%Y-%m') =", $current_month)
                                            ->count_all_results('ticketing')
        );
        
        return $stats;
    }
}
?>