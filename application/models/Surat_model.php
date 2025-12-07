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
// Di Surat_model.php
public function get_by_id($id)
{
    log_message('debug', 'get_by_id called with id: ' . $id);
    
    $this->db->where('id', $id);
    $query = $this->db->get('surat');
    
    log_message('debug', 'Query result: ' . ($query->num_rows() > 0 ? 'found' : 'not found'));
    
    return $query->row();
}

    // ============================================================
    //  GET BY IDS (METHOD BARU UNTUK MULTI EDIT)
    // ============================================================
    public function get_by_ids($ids)
    {
        if (empty($ids)) {
            return [];
        }
        
        $this->db->where_in('id', $ids);
        $this->db->order_by('id', 'DESC');
        $result = $this->db->get('surat')->result();
        
        return $this->append_dosen_data($result);
    }

    // ============================================================
    //  GET BY STATUS
    // ============================================================
    public function get_by_status($status)
    {
        $this->db->order_by('created_at', 'DESC');
        $result = $this->db->get_where('surat', ['status' => $status])->result();
        return $this->append_dosen_data($result);
    }

public function update_surat($id, $data)
{
    log_message('debug', 'update_surat called for id: ' . $id);
    log_message('debug', 'Update data: ' . print_r($data, true));
    
    $this->db->where('id', $id);
    $result = $this->db->update('surat', $data);
    
    log_message('debug', 'Update result: ' . ($result ? 'success' : 'failed'));
    log_message('debug', 'DB error: ' . $this->db->error()['message']);
    
    return $result;
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

    // ============================================================
    //  METHOD TAMBAHAN UNTUK COMPATIBILITY
    // ============================================================
    
    /**
     * Alias untuk get_by_ids - untuk kompatibilitas dengan kode lama
     */
    public function getMultiByIds($ids)
    {
        return $this->get_by_ids($ids);
    }

    /**
     * Get surat dengan filter custom
     */
    public function get_where($where = [])
    {
        $this->db->where($where);
        $this->db->order_by('id', 'DESC');
        $result = $this->db->get('surat')->result();
        return $this->append_dosen_data($result);
    }

    /**
     * Get surat dengan limit untuk pagination
     */
    public function get_surat_paginated($limit, $offset)
    {
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        $result = $this->db->get('surat')->result();
        return $this->append_dosen_data($result);
    }

    /**
     * Total semua surat
     */
    public function count_all()
    {
        return $this->db->count_all('surat');
    }

    /**
     * Search surat by nama_kegiatan
     */
    public function search($keyword)
    {
        $this->db->like('nama_kegiatan', $keyword);
        $this->db->order_by('id', 'DESC');
        $result = $this->db->get('surat')->result();
        return $this->append_dosen_data($result);
    }
    public function get_dosen_by_nip_list($nip_list)
{
    if(empty($nip_list)) return [];

    $this->db->where_in('nip', $nip_list);
    return $this->db->get('list_surat')->result();
}

public function hapus_dosen_dari_surat($surat_id, $nip)
{
    // Pastikan surat ada
    $surat = $this->db->get_where('surat_tugas', ['id' => $surat_id])->row();
    if (!$surat) {
        return false;
    }
    
    // Hapus dari tabel pivot (sesuaikan dengan nama tabel Anda)
    // Contoh: jika tabel pivot adalah surat_dosen
    $this->db->where('surat_id', $surat_id);
    $this->db->where('nip', $nip);
    $result = $this->db->delete('surat_dosen');
    
    return $result;
}

public function get_dosen_by_surat_id($surat_id)
{
    // Query untuk mengambil dosen terkait surat
    // Sesuaikan dengan struktur database Anda
    $this->db->select('d.nip, d.nama_dosen, d.jabatan, d.divisi');
    $this->db->from('surat_dosen sd');
    $this->db->join('dosen d', 'd.nip = sd.nip');
    $this->db->where('sd.surat_id', $surat_id);
    $this->db->order_by('d.nama_dosen', 'ASC');
    
    $query = $this->db->get();
    return $query->result_array();
}
}