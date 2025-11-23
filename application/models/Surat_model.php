<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat_model extends CI_Model
{
    // ============================================================
    //  HELPER: ENCODE NIP KE JSON
    // ============================================================
    private function encode_array_fields(&$data)
    {
        if (isset($data['nip']) && is_array($data['nip'])) {
            $data['nip'] = json_encode($data['nip']);
        }
    }

    // ============================================================
    //  HELPER: DECODE JSON NIP + JOIN DOSEN
    // ============================================================
    private function append_dosen_data(&$result)
    {
        if (is_array($result)) {
            foreach ($result as &$row) {
                $this->process_single_row($row);
            }
        } elseif (is_object($result)) {
            $this->process_single_row($result);
        }

        return $result;
    }

    private function process_single_row(&$row)
    {
        $row->nip = json_decode($row->nip, true) ?: [];

        $row->dosen = [];

        if (!empty($row->nip)) {
            $this->db->where_in('nip', $row->nip);
            $query = $this->db->get('list_dosen')->result();

            $row->dosen = $query; 
        }
    }

    // ============================================================
    //  INSERT
    // ============================================================
    public function insert_surat($data)
    {
        $this->encode_array_fields($data);
        return $this->db->insert('surat', $data);
    }

    // ============================================================
    //  GET ALL
    // ============================================================
    public function get_all_surat()
    {
        $this->db->order_by('id', 'DESC');
        $result = $this->db->get('surat')->result();
        return $this->append_dosen_data($result);
    }

    // ============================================================
    //  GET BY ID
    // ============================================================
    public function get_by_id($id)
    {
        $row = $this->db->get_where('surat', ['id' => $id])->row();
        if (!$row) return null;

        return $this->append_dosen_data($row);
    }

    // ============================================================
    //  GET BY STATUS - METHOD YANG DITAMBAHKAN
    // ============================================================
    public function get_by_status($status)
    {
        $this->db->order_by('created_at', 'DESC');
        $result = $this->db->get_where('surat', ['status' => $status])->result();
        return $this->append_dosen_data($result);
    }

    // ============================================================
    //  UPDATE SURAT
    // ============================================================
    public function update_surat($id, $data)
    {
        $this->encode_array_fields($data);
        return $this->db->where('id', $id)->update('surat', $data);
    }

    // ============================================================
    //  DELETE
    // ============================================================
    public function delete_surat($id)
    {
        return $this->db->where('id', $id)->delete('surat');
    }

    // ============================================================
    //  METHOD LAIN (pending / approved / rejected dll)
    // ============================================================
    private function filter_status_query($status_condition)
    {
        $this->db->order_by('created_at', 'DESC');
        $result = $this->db->get_where('surat', $status_condition)->result();
        return $this->append_dosen_data($result);
    }

    public function get_pending()
    {
        return $this->filter_status_query("status = 'pengajuan'");
    }

    public function get_disetujui()
    {
        return $this->filter_status_query("status LIKE '%setuju%'");
    }

    public function get_ditolak()
    {
        return $this->filter_status_query("status LIKE '%tolak%'");
    }

    // ============================================================
    //  COUNT METHODS (OPTIONAL - JIKA DIBUTUHKAN)
    // ============================================================
    public function count_by_status($status)
    {
        $this->db->where('status', $status);
        return $this->db->count_all_results('surat');
    }

    public function count_pending()
    {
        return $this->count_by_status('pengajuan');
    }

    public function count_disetujui()
    {
        $this->db->like('status', 'setuju');
        return $this->db->count_all_results('surat');
    }

    public function count_ditolak()
    {
        $this->db->like('status', 'tolak');
        return $this->db->count_all_results('surat');
    }
}