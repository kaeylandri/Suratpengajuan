<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat_model extends CI_Model
{
    // ============================================================
    //  HELPER: ENCODE ARRAY FIELD KE JSON
    // ============================================================
    private function encode_array_fields(&$data)
    {
        $fields = ['nip', 'nama_dosen', 'jabatan', 'divisi'];

        foreach ($fields as $f) {
            if (!isset($data[$f])) continue;

            // Jika array → encode JSON
            if (is_array($data[$f])) {
                $data[$f] = json_encode($data[$f]);
            }

            // Jika kosong → jadikan array kosong
            if ($data[$f] === "-" || $data[$f] === "" || $data[$f] === null) {
                $data[$f] = json_encode([]);
            }
        }
    }

    // ============================================================
    //  HELPER: DECODE JSON FIELDS
    // ============================================================
    private function decode_json_fields(&$result)
    {
        if (is_array($result)) {
            foreach ($result as &$row) {
                if (is_object($row)) {
                    $row->nip        = json_decode($row->nip, true) ?: [];
                    $row->nama_dosen = json_decode($row->nama_dosen, true) ?: [];
                    $row->jabatan    = json_decode($row->jabatan, true) ?: [];
                    $row->divisi     = json_decode($row->divisi, true) ?: [];
                    $row->eviden     = json_decode($row->eviden, true) ?: [];
                }
            }
        } elseif (is_object($result)) {
            $result->nip        = json_decode($result->nip, true) ?: [];
            $result->nama_dosen = json_decode($result->nama_dosen, true) ?: [];
            $result->jabatan    = json_decode($result->jabatan, true) ?: [];
            $result->divisi     = json_decode($result->divisi, true) ?: [];
            $result->eviden     = json_decode($result->eviden, true) ?: [];
        }
        
        return $result;
    }

    // ============================================================
    //  INSERT DATA
    // ============================================================
    public function insert_surat($data)
    {
        $this->encode_array_fields($data);
        return $this->db->insert('surat', $data);
    }

    // ============================================================
    //  GET SEMUA SURAT (MAIN)
    // ============================================================
    public function get_all_surat()
    {
        $this->db->order_by('id', 'DESC');
        $result = $this->db->get('surat')->result();
        return $this->decode_json_fields($result);
    }

    // Alias
    public function getAll()
    {
        return $this->get_all_surat();
    }

    // ============================================================
    //  GET BY STATUS (EXACT MATCH)
    // ============================================================
    public function get_by_status($status)
    {
        $this->db->where('status', $status);
        $this->db->order_by('created_at', 'DESC');
        $result = $this->db->get('surat')->result();
        return $this->decode_json_fields($result);
    }

    // Alias
    public function getByStatus($status)
    {
        return $this->get_by_status($status);
    }

    // ============================================================
    //  GET SURAT DISETUJUI (SEMUA STATUS SETUJU)
    // ============================================================
    public function get_surat_disetujui()
    {
        $this->db->where("(status LIKE '%setuju%' OR status LIKE '%approved%' OR status = 'disetujui')", NULL, FALSE);
        $this->db->order_by('created_at', 'DESC');
        $result = $this->db->get('surat')->result();
        return $this->decode_json_fields($result);
    }

    // ============================================================
    //  GET SURAT DITOLAK (SEMUA STATUS TOLAK)
    // ============================================================
    public function get_surat_ditolak()
    {
        $this->db->where("(status LIKE '%tolak%' OR status LIKE '%rejected%' OR status = 'ditolak')", NULL, FALSE);
        $this->db->order_by('created_at', 'DESC');
        $result = $this->db->get('surat')->result();
        return $this->decode_json_fields($result);
    }

    // ============================================================
    //  GET SURAT PENDING (SEMUA STATUS MENUNGGU)
    // ============================================================
    public function get_surat_pending()
    {
        $this->db->where("(status = 'pengajuan' OR status LIKE '%pending%' OR status LIKE '%menunggu%')", NULL, FALSE);
        $this->db->order_by('created_at', 'DESC');
        $result = $this->db->get('surat')->result();
        return $this->decode_json_fields($result);
    }

    // ============================================================
    //  GET PENDING DENGAN SEARCH - UNTUK HALAMAN PENDING
    // ============================================================
    public function get_pending_with_search($search)
    {
        $this->db->select('*');
        $this->db->from('surat');
        $this->db->where("(status = 'pengajuan' OR status LIKE '%pending%' OR status LIKE '%menunggu%')", NULL, FALSE);
        
        // Filter pencarian
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }
        
        $this->db->order_by('created_at', 'DESC');
        $result = $this->db->get()->result();
        return $this->decode_json_fields($result);
    }

    // ============================================================
    //  GET DISETUJUI DENGAN SEARCH
    // ============================================================
    public function get_disetujui_with_search($search)
    {
        $this->db->select('*');
        $this->db->from('surat');
        $this->db->where("(status LIKE '%setuju%' OR status LIKE '%approved%' OR status = 'disetujui')", NULL, FALSE);
        
        // Filter pencarian
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }
        
        $this->db->order_by('created_at', 'DESC');
        $result = $this->db->get()->result();
        return $this->decode_json_fields($result);
    }

    // ============================================================
    //  GET DITOLAK DENGAN SEARCH
    // ============================================================
    public function get_ditolak_with_search($search)
    {
        $this->db->select('*');
        $this->db->from('surat');
        $this->db->where("(status LIKE '%tolak%' OR status LIKE '%rejected%' OR status = 'ditolak')", NULL, FALSE);
        
        // Filter pencarian
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }
        
        $this->db->order_by('created_at', 'DESC');
        $result = $this->db->get()->result();
        return $this->decode_json_fields($result);
    }

    // ============================================================
    //  GET DATA DENGAN FILTER UNTUK HALAMAN TOTAL
    // ============================================================
    public function get_data($search = '', $status = '')
    {
        $this->db->select('*');
        $this->db->from('surat');
        
        // Filter pencarian
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }
        
        // Filter status
        if (!empty($status)) {
            switch ($status) {
                case 'pending':
                    $this->db->where("(status = 'pengajuan' OR status LIKE '%pending%' OR status LIKE '%menunggu%')", NULL, FALSE);
                    break;
                case 'approved':
                    $this->db->where("(status LIKE '%setuju%' OR status LIKE '%approved%' OR status = 'disetujui')", NULL, FALSE);
                    break;
                case 'rejected':
                    $this->db->where("(status LIKE '%tolak%' OR status LIKE '%rejected%' OR status = 'ditolak')", NULL, FALSE);
                    break;
            }
        }
        
        $this->db->order_by('id', 'DESC');
        $result = $this->db->get()->result();
        return $this->decode_json_fields($result);
    }

    // ============================================================
    //  COUNT TOTAL SURAT
    // ============================================================
    public function count_total_surat()
    {
        return $this->db->count_all('surat');
    }

    // ============================================================
    //  COUNT BY STATUS
    // ============================================================
    public function count_by_status($status_type)
    {
        switch ($status_type) {
            case 'pending':
                $this->db->where("(status = 'pengajuan' OR status LIKE '%pending%' OR status LIKE '%menunggu%')", NULL, FALSE);
                break;
            case 'approved':
                $this->db->where("(status LIKE '%setuju%' OR status LIKE '%approved%' OR status = 'disetujui')", NULL, FALSE);
                break;
            case 'rejected':
                $this->db->where("(status LIKE '%tolak%' OR status LIKE '%rejected%' OR status = 'ditolak')", NULL, FALSE);
                break;
            default:
                $this->db->where('status', $status_type);
                break;
        }
        
        return $this->db->count_all_results('surat');
    }

    // ============================================================
    //  GET BY ID
    // ============================================================
    public function get_by_id($id)
    {
        $row = $this->db->get_where('surat', ['id' => $id])->row();
        if (!$row) return null;
        
        return $this->decode_json_fields($row);
    }

    // ============================================================
    //  GET MULTIPLE IDS
    // ============================================================
    public function getMultiByIds($ids)
    {
        if (empty($ids)) return [];

        // Pastikan integer
        $ids = array_filter(array_map('intval', $ids), fn($x) => $x > 0);
        if (empty($ids)) return [];

        $this->db->where_in('id', $ids);
        $this->db->order_by('id', 'ASC');
        $result = $this->db->get('surat')->result();
        return $this->decode_json_fields($result);
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
    //  UPDATE STATUS SURAT
    // ============================================================
    public function update_surat_status($id, $status, $catatan_penolakan = null)
    {
        $data = ['status' => $status];
        
        if ($status === 'ditolak' && $catatan_penolakan) {
            $data['catatan_penolakan'] = $catatan_penolakan;
        } else {
            // Hapus catatan penolakan jika status bukan ditolak
            $data['catatan_penolakan'] = null;
        }
        
        return $this->db->where('id', $id)->update('surat', $data);
    }

    // Alias untuk update status
    public function update_status($id, $status, $catatan_penolakan = null)
    {
        return $this->update_surat_status($id, $status, $catatan_penolakan);
    }

    // ============================================================
    //  DELETE SURAT
    // ============================================================
    public function delete_surat($id)
    {
        return $this->db->where('id', $id)->delete('surat');
    }

    // ============================================================
    //  GET STATUS COUNTS UNTUK DASHBOARD
    // ============================================================
    public function get_status_counts()
    {
        $counts = [
            'total' => $this->count_total_surat(),
            'pending' => $this->count_by_status('pending'),
            'approved' => $this->count_by_status('approved'),
            'rejected' => $this->count_by_status('rejected')
        ];

        return $counts;
    }

    // ============================================================
    //  SEARCH SURAT (GENERAL SEARCH)
    // ============================================================
    public function search_surat($keyword)
    {
        $this->db->select('*');
        $this->db->from('surat');
        $this->db->group_start();
        $this->db->like('nama_kegiatan', $keyword);
        $this->db->or_like('penyelenggara', $keyword);
        $this->db->or_like('jenis_pengajuan', $keyword);
        $this->db->or_like('tempat_kegiatan', $keyword);
        $this->db->or_like('status', $keyword);
        $this->db->group_end();
        $this->db->order_by('id', 'DESC');
        
        $result = $this->db->get()->result();
        return $this->decode_json_fields($result);
    }

    // ============================================================
    //  METHOD UNTUK SEKRETARIAT - BARU DITAMBAHKAN
    // ============================================================

    // Get semua surat untuk sekretariat dengan filter
    public function get_surat_sekretariat($search = '', $status = '')
    {
        $this->db->select('*');
        $this->db->from('surat');
        
        // Filter pencarian
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->or_like('tempat_kegiatan', $search);
            $this->db->group_end();
        }
        
        // Filter status untuk sekretariat
        if (!empty($status)) {
            switch ($status) {
                case 'pending':
                    $this->db->where("(status = 'pengajuan' OR status LIKE '%pending%' OR status LIKE '%menunggu%')", NULL, FALSE);
                    break;
                case 'approved':
                    $this->db->where("(status LIKE '%setuju%' OR status LIKE '%approved%' OR status = 'disetujui')", NULL, FALSE);
                    break;
                case 'rejected':
                    $this->db->where("(status LIKE '%tolak%' OR status LIKE '%rejected%' OR status = 'ditolak')", NULL, FALSE);
                    break;
                case 'menunggu_sekretariat':
                    $this->db->where("status", 'disetujui KK');
                    break;
                case 'disetujui_sekretariat':
                    $this->db->where("status", 'disetujui sekretariat');
                    break;
                case 'ditolak_sekretariat':
                    $this->db->where("status", 'ditolak sekretariat');
                    break;
            }
        }
        
        $this->db->order_by('created_at', 'DESC');
        $result = $this->db->get()->result();
        return $this->decode_json_fields($result);
    }

    // Get surat yang menunggu persetujuan sekretariat
    public function get_menunggu_sekretariat($search = '')
    {
        $this->db->select('*');
        $this->db->from('surat');
        $this->db->where('status', 'disetujui KK');
        
        // Filter pencarian
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }
        
        $this->db->order_by('created_at', 'DESC');
        $result = $this->db->get()->result();
        return $this->decode_json_fields($result);
    }

    // Get surat yang sudah disetujui sekretariat
    public function get_disetujui_sekretariat($search = '')
    {
        $this->db->select('*');
        $this->db->from('surat');
        $this->db->where('status', 'disetujui sekretariat');
        
        // Filter pencarian
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }
        
        $this->db->order_by('created_at', 'DESC');
        $result = $this->db->get()->result();
        return $this->decode_json_fields($result);
    }

    // Get surat yang ditolak sekretariat
    public function get_ditolak_sekretariat($search = '')
    {
        $this->db->select('*');
        $this->db->from('surat');
        $this->db->where('status', 'ditolak sekretariat');
        
        // Filter pencarian
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }
        
        $this->db->order_by('created_at', 'DESC');
        $result = $this->db->get()->result();
        return $this->decode_json_fields($result);
    }

    // Update status oleh sekretariat
    public function update_status_sekretariat($id, $status, $catatan_penolakan = null)
    {
        $data = ['status' => $status];
        
        if ($status === 'ditolak sekretariat' && $catatan_penolakan) {
            $data['catatan_penolakan'] = $catatan_penolakan;
        } else {
            // Hapus catatan penolakan jika status bukan ditolak
            $data['catatan_penolakan'] = null;
        }
        
        return $this->db->where('id', $id)->update('surat', $data);
    }
}