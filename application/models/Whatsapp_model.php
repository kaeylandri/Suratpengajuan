<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Whatsapp_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Ambil nomor WhatsApp admin utama saja (role = superadmin)
     */
    public function get_admin_numbers($only_active = true)
    {
        $this->db->select('whatsapp, nama, role');
        $this->db->from('admin');
        
        // HANYA ambil admin utama (superadmin)
        $this->db->where('role', 'superadmin');
        
        if ($only_active) {
            $this->db->where('is_active', 1);
        }
        
        $this->db->where('whatsapp IS NOT NULL');
        $this->db->where("whatsapp != ''");
        
        $query = $this->db->get();
        
        log_message('debug', 'WhatsApp Model Query: ' . $this->db->last_query());
        
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
            $numbers = [];
            
            foreach ($results as $row) {
                if (!empty($row['whatsapp'])) {
                    $numbers[] = $row['whatsapp'];
                }
            }
            
            log_message('info', 'Found ' . count($numbers) . ' admin utama numbers');
            return $numbers;
        }
        
        log_message('warning', 'No admin utama numbers found');
        return [];
    }
    
    /**
     * Cek apakah sudah ada notifikasi untuk surat tertentu
     */
    public function is_notified($surat_id)
    {
        $this->db->from('whatsapp_logs');
        $this->db->where('surat_id', $surat_id);
        $this->db->where('message_type', 'notifikasi_surat');
        
        $query = $this->db->get();
        return $query->num_rows() > 0;
    }
    
    /**
     * Simpan log pengiriman WhatsApp
     */
    public function save_log($data)
    {
        $log_data = [
            'surat_id' => isset($data['surat_id']) ? $data['surat_id'] : null,
            'message_type' => isset($data['message_type']) ? $data['message_type'] : 'notifikasi_surat',
            'recipient_count' => isset($data['recipient_count']) ? $data['recipient_count'] : 0,
            'message' => isset($data['message']) ? substr($data['message'], 0, 500) : null,
            'status' => isset($data['status']) ? $data['status'] : 'pending',
            'response' => isset($data['response']) ? json_encode($data['response']) : null,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $result = $this->db->insert('whatsapp_logs', $log_data);
        
        if ($result) {
            log_message('info', 'WhatsApp log saved for surat ID: ' . $data['surat_id']);
        } else {
            log_message('error', 'Failed to save WhatsApp log for surat ID: ' . $data['surat_id']);
        }
        
        return $result;
    }
    
    /**
     * Ambil semua log untuk debugging
     */
    public function get_logs($limit = 10)
    {
        $this->db->select('*');
        $this->db->from('whatsapp_logs');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result_array();
    }
}