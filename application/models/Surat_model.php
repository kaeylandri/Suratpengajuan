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

                // Jika array → encode
                if (is_array($data[$f])) {
                    $data[$f] = json_encode($data[$f]);
                }

                // Jika kosong → simpan sebagai "[]"
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

        // Decode JSON biar enak dipakai di view
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
    // GET MULTIPLE BY IDs - FOR MULTI EDIT (NEW)
    // ============================================
    public function getMultiByIds($ids)
    {
        if (empty($ids)) {
            return [];
        }

        // Pastikan semua ID adalah integer
        $ids = array_map('intval', $ids);
        
        // Filter ID yang valid (> 0)
        $ids = array_filter($ids, function($id) {
            return $id > 0;
        });

        if (empty($ids)) {
            return [];
        }
        
        // Query dengan WHERE IN
        $this->db->where_in('id', $ids);
        $this->db->order_by('id', 'ASC');
        $result = $this->db->get('surat')->result();

        // Decode JSON fields untuk setiap row
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
    // GET STATUS BY ID - FIXED VERSION
    // ============================================
    public function get_status_by_id($id)
    {
        // Query untuk mengambil data status dari tabel surat
        // Sesuaikan dengan kolom yang ada di database (step1, step2, step3, step4)
        $this->db->select('
            id,
            status,
            step1_status,
            step1_date,
            step1_text,
            step2_status,
            step2_date,
            step2_text,
            step3_status,
            step3_date,
            step3_text,
            step4_status,
            step4_date,
            step4_text,
            current_description,
            estimated_time,
            rejection_reason,
            created_at
        ');
        $this->db->where('id', $id);
        $query = $this->db->get('surat');
        
        if ($query->num_rows() > 0) {
            $data = $query->row();
            
            // Format data untuk response
            $status_data = new stdClass();
            
            // Step 1: Mengirim/Pengajuan (selalu completed)
            $status_data->step1_status = !empty($data->step1_status) ? $data->step1_status : 'completed';
            $status_data->step1_date = !empty($data->step1_date) ? date('d M Y, H:i', strtotime($data->step1_date)) : date('d M Y, H:i', strtotime($data->created_at));
            $status_data->step1_text = !empty($data->step1_text) ? $data->step1_text : 'Terkirim';
            
            // Step 2: Persetujuan KK
            $status_data->step2_status = !empty($data->step2_status) ? $data->step2_status : 'in-progress';
            $status_data->step2_date = !empty($data->step2_date) ? date('d M Y, H:i', strtotime($data->step2_date)) : '-';
            
            if ($data->step2_status === 'approved') {
                $status_data->step2_text = 'Disetujui KK';
            } elseif ($data->step2_status === 'rejected') {
                $status_data->step2_text = 'Ditolak KK';
            } else {
                $status_data->step2_text = !empty($data->step2_text) ? $data->step2_text : 'Menunggu Persetujuan KK';
            }
            
            // Step 3: Persetujuan Sekretariat
            if ($data->step2_status === 'approved') {
                $status_data->step3_status = !empty($data->step3_status) ? $data->step3_status : 'in-progress';
                $status_data->step3_date = !empty($data->step3_date) ? date('d M Y, H:i', strtotime($data->step3_date)) : '-';
                
                if ($data->step3_status === 'approved') {
                    $status_data->step3_text = 'Disetujui Sekretariat';
                } elseif ($data->step3_status === 'rejected') {
                    $status_data->step3_text = 'Ditolak Sekretariat';
                } else {
                    $status_data->step3_text = !empty($data->step3_text) ? $data->step3_text : 'Menunggu Persetujuan Sekretariat';
                }
            } else {
                $status_data->step3_status = 'pending';
                $status_data->step3_text = 'Persetujuan Sekretariat';
                $status_data->step3_date = '-';
            }
            
            // Step 4: Persetujuan Dekan
            if ($data->step3_status === 'approved') {
                $status_data->step4_status = !empty($data->step4_status) ? $data->step4_status : 'in-progress';
                $status_data->step4_date = !empty($data->step4_date) ? date('d M Y, H:i', strtotime($data->step4_date)) : '-';
                
                if ($data->step4_status === 'approved') {
                    $status_data->step4_text = 'Disetujui Dekan';
                } elseif ($data->step4_status === 'rejected') {
                    $status_data->step4_text = 'Ditolak Dekan';
                } else {
                    $status_data->step4_text = !empty($data->step4_text) ? $data->step4_text : 'Menunggu Persetujuan Dekan';
                }
            } else {
                $status_data->step4_status = 'pending';
                $status_data->step4_text = 'Persetujuan Dekan';
                $status_data->step4_date = '-';
            }
            
            // Deskripsi dan estimasi waktu
            $status_data->current_description = !empty($data->current_description) 
                ? $data->current_description 
                : $this->generate_status_description($data);
                
            $status_data->estimated_time = !empty($data->estimated_time) 
                ? $data->estimated_time 
                : $this->generate_estimated_time($data);
            
            // Alasan penolakan
            $status_data->rejection_reason = !empty($data->rejection_reason) ? $data->rejection_reason : null;
            
            $status_data->created_at = $data->created_at;
            $status_data->status = $data->status;
            
            return $status_data;
        }
        
        return null;
    }
    
    // ============================================
    // HELPER: GENERATE STATUS DESCRIPTION
    // ============================================
    private function generate_status_description($data)
    {
        if ($data->step4_status === 'approved') {
            return 'Surat tugas Anda telah disetujui oleh Dekan. Proses pengajuan selesai.';
        } elseif ($data->step4_status === 'rejected') {
            return 'Pengajuan surat tugas Anda ditolak oleh Dekan.';
        } elseif ($data->step3_status === 'approved') {
            return 'Surat tugas Anda sedang dalam proses persetujuan akhir oleh Dekan.';
        } elseif ($data->step3_status === 'rejected') {
            return 'Pengajuan surat tugas Anda ditolak oleh Sekretariat.';
        } elseif ($data->step2_status === 'approved') {
            return 'Surat tugas Anda sedang menunggu persetujuan dari Sekretariat.';
        } elseif ($data->step2_status === 'rejected') {
            return 'Pengajuan surat tugas Anda ditolak oleh KK. Silakan perbaiki dan ajukan kembali.';
        } else {
            return 'Surat tugas Anda sedang menunggu persetujuan dari KK.';
        }
    }
    
    // ============================================
    // HELPER: GENERATE ESTIMATED TIME
    // ============================================
    private function generate_estimated_time($data)
    {
        if ($data->step4_status === 'approved') {
            return 'Selesai';
        } elseif ($data->step4_status === 'rejected' || $data->step3_status === 'rejected' || $data->step2_status === 'rejected') {
            return '-';
        } elseif ($data->step3_status === 'approved') {
            return '1-2 hari kerja';
        } elseif ($data->step2_status === 'approved') {
            return '2-3 hari kerja';
        } else {
            return '3-5 hari kerja';
        }
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

    // ============================================
    // UPDATE STEP STATUS - GENERIC METHOD
    // ============================================
    public function update_step_status($id, $step_number, $status, $text = null, $reason = null)
    {
        $data = [
            "step{$step_number}_status" => $status,
            "step{$step_number}_date" => date('Y-m-d H:i:s')
        ];
        
        if ($text) {
            $data["step{$step_number}_text"] = $text;
        }
        
        if ($reason) {
            $data['rejection_reason'] = $reason;
        }
        
        // Update deskripsi dan estimasi waktu
        $surat = $this->get_by_id($id);
        if ($surat) {
            $data['current_description'] = $this->generate_status_description((object)$data);
            $data['estimated_time'] = $this->generate_estimated_time((object)$data);
        }
        
        // Jika step 4 (Dekan) disetujui, ubah status utama
        if ($step_number == 4 && $status === 'approved') {
            $data['status'] = 'approved';
        }
        
        return $this->db->where('id', $id)->update('surat', $data);
    }

    // ============================================
    // UPDATE STATUS KK (STEP 2)
    // ============================================
    public function update_status_kk($id, $status, $reason = null)
    {
        $text = $status === 'approved' ? 'Disetujui KK' : 'Ditolak KK';
        return $this->update_step_status($id, 2, $status, $text, $reason);
    }

    // ============================================
    // UPDATE STATUS SEKRETARIAT (STEP 3)
    // ============================================
    public function update_status_sekretariat($id, $status, $reason = null)
    {
        $text = $status === 'approved' ? 'Disetujui Sekretariat' : 'Ditolak Sekretariat';
        return $this->update_step_status($id, 3, $status, $text, $reason);
    }

    // ============================================
    // UPDATE STATUS DEKAN (STEP 4)
    // ============================================
    public function update_status_dekan($id, $status, $reason = null)
    {
        $text = $status === 'approved' ? 'Disetujui Dekan' : 'Ditolak Dekan';
        return $this->update_step_status($id, 4, $status, $text, $reason);
    }
}