
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen_model extends CI_Model {

    public function get_dosen_by_ids($ids)
    {
        if (!$ids || count($ids) == 0) return [];

        $this->db->where_in('id', $ids);
        return $this->db->get('list_dosen')->result();
    }
    // Tambahkan method ini ke Dosen_model.php
public function get_by_nip($nip) {
    return $this->db->get_where('list_dosen', ['nip' => $nip])->row();
}

public function search_dosen($query, $field = 'nip') {
    $this->db->select('nip, nama_dosen, jabatan, divisi');
    $this->db->from('list_dosen');
    $this->db->like($field, $query);
    $this->db->limit(10);
    $this->db->order_by($field, 'ASC');
    
    return $this->db->get()->result_array();
}
}
