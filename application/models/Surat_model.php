<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat_model extends CI_Model
{
    // Encode array → JSON sebelum insert/update
    private function encode_array_fields(&$data)
    {
        $fields = ['nip', 'nama_dosen', 'jabatan', 'divisi'];

        foreach ($fields as $f) {
            if (isset($data[$f])) {

                if (is_array($data[$f])) {
                    $data[$f] = json_encode($data[$f]);
                }

                if ($data[$f] === "-" || $data[$f] === "" || $data[$f] === null) {
                    $data[$f] = json_encode([]);
                }
            }
        }
    }

    // ============================================
    // INSERT
    // ============================================
    public function insert_surat($data)
    {
        $this->encode_array_fields($data);
        return $this->db->insert('surat', $data);
    }

    // ============================================
    // GET ALL
    // ============================================
    public function get_all_surat()
    {
        $this->db->order_by('id', 'DESC');
        $result = $this->db->get('surat')->result();

        foreach ($result as &$row) {
            $row->nip        = json_decode($row->nip, true);
            $row->nama_dosen = json_decode($row->nama_dosen, true);
            $row->jabatan    = json_decode($row->jabatan, true);
            $row->divisi     = json_decode($row->divisi, true);
        }

        return $result;
    }

    // ============================================
    // GET BY ID
    // ============================================
    public function get_by_id($id)
    {
        $row = $this->db->get_where('surat', ['id' => $id])->row();

        if ($row) {
            $row->nip        = json_decode($row->nip, true);
            $row->nama_dosen = json_decode($row->nama_dosen, true);
            $row->jabatan    = json_decode($row->jabatan, true);
            $row->divisi     = json_decode($row->divisi, true);
        }

        return $row;
    }

    // ============================================
    // GET MULTIPLE BY IDs - FOR MULTI EDIT
    // ============================================
    public function getMultiByIds($ids)
    {
        if (empty($ids)) {
            return [];
        }

        $ids = array_map('intval', $ids);
        
        $ids = array_filter($ids, function($id) {
            return $id > 0;
        });

        if (empty($ids)) {
            return [];
        }
        
        $this->db->where_in('id', $ids);
        $this->db->order_by('id', 'ASC');
        $result = $this->db->get('surat')->result();

        foreach ($result as &$row) {
            $row->nip        = json_decode($row->nip, true) ?: [];
            $row->nama_dosen = json_decode($row->nama_dosen, true) ?: [];
            $row->jabatan    = json_decode($row->jabatan, true) ?: [];
            $row->divisi     = json_decode($row->divisi, true) ?: [];
            $row->eviden     = json_decode($row->eviden, true) ?: [];
        }

        return $result;
    }
    // ============================================
    // UPDATE
    // ============================================
    public function update_surat($id, $data)
    {
        $this->encode_array_fields($data);
        return $this->db->where('id', $id)->update('surat', $data);
    }

    // ============================================
    // DELETE
    // ============================================
    public function delete_surat($id)
    {
        return $this->db->where('id', $id)->delete('surat');
    }
    
    // ============================================
    // GET BY STATUS
    // ============================================
    public function get_by_status($status)
    {
        return $this->db->where('status', $status)
                        ->order_by('created_at', 'DESC')
                        ->get('surat')
                        ->result();
    }
}