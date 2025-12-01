<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sekretariat extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->model('Surat_model');
    }

    /* ================================
    DASHBOARD
    ================================= */
    public function index() {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $data['tahun'] = $tahun;

        // Surat yang relevan bagi sekretariat
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in("status", ['disetujui KK', 'disetujui dekan', 'ditolak dekan']);
        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // Statistik
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui KK', 'disetujui dekan', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        // Pending (menunggu sekretariat)
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'disetujui KK');
        $data['pending_count'] = $this->db->count_all_results('surat');

        // Disetujui oleh dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'disetujui dekan');
        $data['approved_count'] = $this->db->count_all_results('surat');

        // Ditolak oleh dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'ditolak dekan');
        $data['rejected_count'] = $this->db->count_all_results('surat');

        // Grafik
        $total     = array_fill(0, 12, 0);
        $approved  = array_fill(0, 12, 0);
        $rejected  = array_fill(0, 12, 0);
        $pending   = array_fill(0, 12, 0);

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui KK', 'disetujui dekan', 'ditolak dekan']);
        $query = $this->db->get('surat')->result();

        foreach ($query as $row) {
            $month = (int)date('m', strtotime($row->created_at)) - 1;

            $total[$month]++;

            if ($row->status == 'disetujui KK') {
                $pending[$month]++;
            }

            if ($row->status == 'disetujui dekan') {
                $approved[$month]++;
            }

            if ($row->status == 'ditolak dekan') {
                $rejected[$month]++;
            }
        }

        $data['chart_total']    = $total;
        $data['chart_approved'] = $approved;
        $data['chart_rejected'] = $rejected;
        $data['chart_pending']  = $pending;

        $this->load->view('sekretariat/dashboard', $data);
    }

    /* ================================
    PENDING (Disetujui KK)
    ================================= */
    public function pending() {
        $search = $this->input->get('search');
        $tahun = $this->input->get('tahun') ?? date('Y');
        
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'disetujui KK');
        
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }

        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        $data['total_surat'] = count($data['surat_list']);
        $data['judul'] = "Pengajuan Menunggu Persetujuan Sekretariat";
        $data['role'] = "sekretariat";
        $data['tahun'] = $tahun;

        $this->load->view('sekretariat/halaman_pending', $data);
    }

    /* ================================
    DISETUJUI DEKAN
    ================================= */
    public function disetujui() {
        $search = $this->input->get('search');
        $tahun = $this->input->get('tahun') ?? date('Y');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'disetujui dekan');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }

        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        $data['total_surat'] = count($data['surat_list']);
        $data['judul'] = "Pengajuan Disetujui - Final Dekan";
        $data['role'] = "sekretariat";
        $data['tahun'] = $tahun;

        $this->load->view('sekretariat/halaman_disetujui', $data);
    }

    /* ================================
    DITOLAK DEKAN
    ================================= */
    public function ditolak() {
        $search = $this->input->get('search');
        $tahun = $this->input->get('tahun') ?? date('Y');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'ditolak dekan');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }

        $this->db->order_by("created_at", "DESC");
        $data['pengajuan_ditolak'] = $this->db->get("surat")->result();

        $data['total_surat'] = count($data['pengajuan_ditolak']);
        $data['judul'] = "Pengajuan Ditolak - Final Dekan";
        $data['role'] = "sekretariat";
        $data['tahun'] = $tahun;

        $this->load->view('sekretariat/halaman_ditolak', $data);
    }

    /* ================================
    TOTAL SEMUA PENGAJUAN
    ================================= */
    public function semua() {
        $search = $this->input->get('search');
        $status_filter = $this->input->get('status');
        $tahun = $this->input->get('tahun') ?? date('Y');

        $this->db->where('YEAR(created_at)', $tahun);

        if (!empty($status_filter)) {
            switch ($status_filter) {
                case 'pending':
                    $this->db->where('status', 'disetujui KK');
                    break;
                case 'approved':
                    $this->db->where('status', 'disetujui dekan');
                    break;
                case 'rejected':
                    $this->db->where('status', 'ditolak dekan');
                    break;
                default:
                    $this->db->where_in('status', ['disetujui KK', 'disetujui dekan', 'ditolak dekan']);
                    break;
            }
        } else {
            $this->db->where_in('status', ['disetujui KK', 'disetujui dekan', 'ditolak dekan']);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('jenis_pengajuan', $search);
            $this->db->group_end();
        }

        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        $data['total_surat'] = count($data['surat_list']);
        $data['judul'] = "Total Pengajuan - Sekretariat";
        $data['role'] = "sekretariat";
        $data['tahun'] = $tahun;
        $data['status_filter'] = $status_filter;

        $this->load->view('sekretariat/halaman_total', $data);
    }

    /* ================================
    GET DETAIL PENGAJUAN (AJAX) - PERBAIKAN FINAL SEKRETARIAT
    ================================= */
    public function getDetailPengajuan($id)
    {
        $this->db->where('id', $id);
        $pengajuan = $this->db->get('surat')->row();
        
        if ($pengajuan) {
            $dosen_data = $this->get_dosen_data_from_nip_fixed($pengajuan->nip);
            
            // PERBAIKAN: Ambil semua field yang diperlukan
            $jenis_date = $pengajuan->jenis_date ?? null;
            $periode_value = $pengajuan->periode_value ?? null;
            $tanggal_kegiatan = $pengajuan->tanggal_kegiatan ?? null;
            $akhir_kegiatan = $pengajuan->akhir_kegiatan ?? null;
            
            // Debug log
            error_log("DEBUG SEKRETARIAT - ID: $id");
            error_log("Jenis Date: " . $jenis_date);
            error_log("Periode Value: " . $periode_value);
            error_log("Tanggal Kegiatan: " . $tanggal_kegiatan);
            error_log("Akhir Kegiatan: " . $akhir_kegiatan);
            
            // LOGIKA SAMA SEPERTI KAPRODI:
            // Jika jenis_date = "Periode" -> tampilkan periode_value, kosongkan tanggal
            // Jika jenis_date = "Custom" -> tampilkan tanggal, kosongkan periode
            
            $periode_display = null;
            $tanggal_display = null;
            $akhir_display = null;
            
            if ($jenis_date === 'Periode') {
                // Tampilkan periode, kosongkan tanggal
                $periode_display = $periode_value;
                $tanggal_display = null;
                $akhir_display = null;
            } elseif ($jenis_date === 'Custom') {
                // Tampilkan tanggal, kosongkan periode
                $periode_display = null;
                $tanggal_display = $tanggal_kegiatan;
                $akhir_display = $akhir_kegiatan;
            } else {
                // Fallback jika jenis_date tidak diset
                if ($periode_value) {
                    $periode_display = $periode_value;
                } elseif ($tanggal_kegiatan) {
                    $tanggal_display = $tanggal_kegiatan;
                    $akhir_display = $akhir_kegiatan;
                }
            }
            
            $response_data = array(
                'id' => $pengajuan->id,
                'nama_kegiatan' => $pengajuan->nama_kegiatan,
                'status' => $pengajuan->status,
                'jenis_pengajuan' => $pengajuan->jenis_pengajuan,
                'lingkup_penugasan' => $pengajuan->lingkup_penugasan,
                'penyelenggara' => $pengajuan->penyelenggara,
                'tanggal_kegiatan' => $tanggal_display,      // NULL jika Periode
                'akhir_kegiatan' => $akhir_display,          // NULL jika Periode
                'periode_value' => $periode_display,         // NULL jika Custom
                'jenis_date' => $jenis_date,
                'tempat_kegiatan' => $pengajuan->tempat_kegiatan,
                'created_at' => $pengajuan->created_at,
                'eviden' => $pengajuan->eviden,
                'nomor_surat' => $pengajuan->nomor_surat,
                'catatan_penolakan' => $pengajuan->catatan_penolakan,
                'dosen_data' => $dosen_data
            );
            
            echo json_encode([
                'success' => true,
                'data' => $response_data
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    /* ================================
    GET DOSEN DATA FROM NIP - MENGAMBIL DARI KAPRODI YANG BERHASIL
    ================================= */
    private function get_dosen_data_from_nip_fixed($nip_data)
    {
        $dosen_data = array();
        
        if (empty($nip_data) || $nip_data === '-' || $nip_data === '[]' || $nip_data === 'null') {
            return [array(
                'nama' => 'Data dosen tidak tersedia',
                'nip' => '-',
                'jabatan' => '-',
                'divisi' => '-'
            )];
        }
        
        $nip_array = array();
        
        if (is_string($nip_data)) {
            $trimmed_data = trim($nip_data);
            
            if (preg_match('/^\[.*\]$/', $trimmed_data)) {
                $decoded = json_decode($trimmed_data, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $nip_array = $decoded;
                } else {
                    preg_match_all('/\d+/', $trimmed_data, $matches);
                    $nip_array = $matches[0] ?? [$trimmed_data];
                }
            } else {
                $nip_array = [$trimmed_data];
            }
        } elseif (is_array($nip_data)) {
            $nip_array = $nip_data;
        } else {
            $nip_array = [$nip_data];
        }
        
        $nip_array = array_filter(array_map(function($nip) {
            if (is_array($nip)) {
                return !empty($nip) ? trim(strval($nip[0])) : null;
            }
            return trim(strval($nip));
        }, $nip_array), function($nip) {
            return !empty($nip) && $nip !== '-' && $nip !== 'null' && $nip !== '[]';
        });
        
        if (empty($nip_array)) {
            return [array(
                'nama' => 'Data dosen tidak tersedia',
                'nip' => '-',
                'jabatan' => '-',
                'divisi' => '-'
            )];
        }
        
        $this->db->select('nip, nama_dosen, jabatan, divisi');
        $this->db->from('list_dosen');
        
        if (count($nip_array) === 1) {
            $this->db->where('nip', $nip_array[0]);
        } else {
            $this->db->where_in('nip', $nip_array);
        }
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
            
            $dosen_by_nip = [];
            foreach ($results as $row) {
                $dosen_by_nip[trim($row['nip'])] = array(
                    'nama' => $row['nama_dosen'],
                    'nip' => $row['nip'],
                    'jabatan' => $row['jabatan'],
                    'divisi' => $row['divisi']
                );
            }
            
            foreach ($nip_array as $nip) {
                $clean_nip = trim(strval($nip));
                if (isset($dosen_by_nip[$clean_nip])) {
                    $dosen_data[] = $dosen_by_nip[$clean_nip];
                } else {
                    $dosen_data[] = array(
                        'nama' => 'Data tidak ditemukan',
                        'nip' => $clean_nip,
                        'jabatan' => '-',
                        'divisi' => '-'
                    );
                }
            }
        } else {
            foreach ($nip_array as $nip) {
                $clean_nip = trim(strval($nip));
                $dosen_data[] = array(
                    'nama' => 'Data dari NIP: ' . $clean_nip,
                    'nip' => $clean_nip,
                    'jabatan' => '-',
                    'divisi' => '-'
                );
            }
        }
        
        return $dosen_data;
    }
    /* ================================
   GET DOSEN DETAIL UNTUK AUTOCOMPLETE
================================= */
private function get_dosen_detail_for_autocomplete($surat)
{
    $nip_list = is_array($surat->nip) ? $surat->nip : json_decode($surat->nip, true);
    
    if (!$nip_list) return [];
    
    $dosen_data = [];
    
    foreach ($nip_list as $nip) {
        if (!empty($nip) && $nip !== '-') {
            $this->db->where('nip', $nip);
            $dosen = $this->db->get('list_dosen')->row();
            
            if ($dosen) {
                $dosen_data[] = [
                    'nip' => $dosen->nip,
                    'nama_dosen' => $dosen->nama_dosen,
                    'jabatan' => $dosen->jabatan,
                    'divisi' => $dosen->divisi
                ];
            } else {
                $dosen_data[] = [
                    'nip' => $nip,
                    'nama_dosen' => '',
                    'jabatan' => '',
                    'divisi' => ''
                ];
            }
        }
    }
    
    return $dosen_data;
}
    /* ================================
    REALTIME DASHBOARD COUNTER
    ================================= */
    public function get_dashboard_counts() {
        $tahun = $this->input->get('tahun') ?? date('Y');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui KK', 'disetujui dekan', 'ditolak dekan']);
        $total = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'disetujui KK');
        $pending = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'disetujui dekan');
        $approved = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'ditolak dekan');
        $rejected = $this->db->count_all_results('surat');

        $counts = [
            'total' => $total,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected
        ];

        header('Content-Type: application/json');
        echo json_encode($counts);
    }

    /* ================================
    APPROVE - DENGAN NOMOR SURAT
    ================================= */
    public function approve($id)
    {
        // Validasi nomor surat wajib diisi
        $nomor_surat = $this->input->post('nomor_surat');
        
        if (empty($nomor_surat)) {
            $this->session->set_flashdata('error', 'Nomor surat harus diisi!');
            redirect('sekretariat');
            return;
        }

        // Cek apakah nomor surat sudah digunakan
        $this->db->where('nomor_surat', $nomor_surat);
        $this->db->where('id !=', $id);
        $existing = $this->db->get('surat')->row();

        if ($existing) {
            $this->session->set_flashdata('error', 'Nomor surat sudah digunakan! Silakan gunakan nomor lain.');
            redirect('sekretariat');
            return;
        }

        // Ambil data surat
        $surat = $this->db->get_where('surat', ['id' => $id])->row();
        $approval = json_decode($surat->approval_status, true);

        // Update approval status
        $approval['sekretariat'] = date("Y-m-d H:i:s");
        
        $this->db->where('id', $id)->update('surat', [
            'status' => 'disetujui sekretariat',
            'approval_status' => json_encode($approval),
            'nomor_surat' => $nomor_surat,
        ]);
        
        $this->session->set_flashdata('success', 'Surat berhasil disetujui dengan nomor: ' . $nomor_surat);
        redirect('sekretariat');
    }
    
    /* ================================
    REJECT
    ================================= */
    public function reject($id)
    {
        $notes = $this->input->post('rejection_notes');

        // Ambil data surat dari database
        $surat = $this->db->get_where('surat', ['id' => $id])->row();

        // Decode approval_status lama
        $approval = json_decode($surat->approval_status, true);

        // Jika null, jadikan array kosong agar tidak error
        if (!is_array($approval)) {
            $approval = [];
        }

        // Tambahkan timestamp penolakan sekretariat
        $approval['sekretariat'] = date("Y-m-d H:i:s");

        // Update database
        $this->db->where('id', $id)->update('surat', [
            'status' => 'ditolak sekretariat',
            'approval_status' => json_encode($approval),
            'catatan_penolakan' => $notes,
        ]);

        $this->session->set_flashdata('success', 'Surat berhasil ditolak Sekretariat.');
        redirect('sekretariat');
    }

    /* ================================
    BULK APPROVE - MULTI APPROVE
    ================================= */
    public function bulk_approve()
    {
        // Check jika request adalah POST
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $ids = $this->input->post('ids');
            $nomor_surat_data = $this->input->post('nomor_surat');
            
            // Validasi input
            if (empty($ids)) {
                $this->session->set_flashdata('error', 'Tidak ada pengajuan yang dipilih.');
                redirect('sekretariat/pending');
            }
            
            // Convert string IDs to array
            $id_array = explode(',', $ids);
            
            $success_count = 0;
            $error_count = 0;
            $error_messages = [];
            
            foreach ($id_array as $id) {
                $id = trim($id);
                
                // Validasi nomor surat untuk setiap item
                if (!isset($nomor_surat_data[$id]) || empty($nomor_surat_data[$id])) {
                    $error_count++;
                    $error_messages[] = "Nomor surat harus diisi untuk ID: $id";
                    continue;
                }
                
                $nomor_surat = $nomor_surat_data[$id];
                
                // Cek apakah nomor surat sudah digunakan (kecuali untuk surat yang sama)
                $this->db->where('nomor_surat', $nomor_surat);
                $this->db->where('id !=', $id);
                $existing = $this->db->get('surat')->row();
                
                if ($existing) {
                    $error_count++;
                    $error_messages[] = "Nomor surat '$nomor_surat' sudah digunakan (ID: $id)";
                    continue;
                }
                
                // Ambil data surat
                $surat = $this->db->get_where('surat', ['id' => $id])->row();
                
                if (!$surat) {
                    $error_count++;
                    $error_messages[] = "Data tidak ditemukan (ID: $id)";
                    continue;
                }
                
                // Update approval status
                $approval = json_decode($surat->approval_status, true);
                $approval['sekretariat'] = date("Y-m-d H:i:s");
                
                // Update database
                $update_data = [
                    'status' => 'disetujui sekretariat',
                    'approval_status' => json_encode($approval),
                    'nomor_surat' => $nomor_surat,
                ];
                
                $this->db->where('id', $id);
                if ($this->db->update('surat', $update_data)) {
                    $success_count++;
                } else {
                    $error_count++;
                    $error_messages[] = "Gagal update database (ID: $id)";
                }
            }
            
            // Set flash message berdasarkan hasil
            if ($success_count > 0) {
                $message = "Berhasil menyetujui $success_count pengajuan.";
                if ($error_count > 0) {
                    $message .= " $error_count pengajuan gagal.";
                }
                $this->session->set_flashdata('success', $message);
            } else {
                $this->session->set_flashdata('error', "Gagal menyetujui semua pengajuan: " . implode(', ', $error_messages));
            }
            
            redirect('sekretariat/pending');
        } else {
            // Jika bukan POST request, redirect ke halaman pending
            redirect('sekretariat/pending');
        }
    }

    /* ================================
    BULK REJECT - MULTI REJECT
    ================================= */
    public function bulk_reject()
    {
        // Check jika request adalah POST
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $ids = $this->input->post('ids');
            $rejection_notes_data = $this->input->post('rejection_notes');
            
            // Validasi input
            if (empty($ids)) {
                $this->session->set_flashdata('error', 'Tidak ada pengajuan yang dipilih.');
                redirect('sekretariat/pending');
            }
            
            // Convert string IDs to array
            $id_array = explode(',', $ids);
            
            $success_count = 0;
            $error_count = 0;
            $error_messages = [];
            
            foreach ($id_array as $id) {
                $id = trim($id);
                
                // Validasi rejection notes untuk setiap item
                if (!isset($rejection_notes_data[$id]) || empty($rejection_notes_data[$id])) {
                    $error_count++;
                    $error_messages[] = "Alasan penolakan harus diisi untuk ID: $id";
                    continue;
                }
                
                $rejection_notes = $rejection_notes_data[$id];
                
                // Ambil data surat
                $surat = $this->db->get_where('surat', ['id' => $id])->row();
                
                if (!$surat) {
                    $error_count++;
                    $error_messages[] = "Data tidak ditemukan (ID: $id)";
                    continue;
                }
                
                // Update approval status
                $approval = json_decode($surat->approval_status, true);
                if (!is_array($approval)) {
                    $approval = [];
                }
                $approval['sekretariat'] = date("Y-m-d H:i:s");
                
                // Update database
                $update_data = [
                    'status' => 'ditolak sekretariat',
                    'approval_status' => json_encode($approval),
                    'catatan_penolakan' => $rejection_notes,
                ];
                
                $this->db->where('id', $id);
                if ($this->db->update('surat', $update_data)) {
                    $success_count++;
                } else {
                    $error_count++;
                    $error_messages[] = "Gagal update database (ID: $id)";
                }
            }
            
            // Set flash message berdasarkan hasil
            if ($success_count > 0) {
                $message = "Berhasil menolak $success_count pengajuan.";
                if ($error_count > 0) {
                    $message .= " $error_count pengajuan gagal.";
                }
                $this->session->set_flashdata('success', $message);
            } else {
                $this->session->set_flashdata('error', "Gagal menolak semua pengajuan: " . implode(', ', $error_messages));
            }
            
            redirect('sekretariat/pending');
        } else {
            // Jika bukan POST request, redirect ke halaman pending
            redirect('sekretariat/pending');
        }
    }

    /* ================================
    DEBUG: CEK STRUKTUR TABEL SURAT
    ================================= */
    public function debug_table_structure()
    {
        // Cek struktur tabel surat untuk memastikan field yang ada
        $query = $this->db->query("DESCRIBE surat");
        $structure = $query->result();
        
        echo "<h3>Struktur Tabel Surat:</h3>";
        echo "<pre>";
        foreach ($structure as $field) {
            echo "Field: " . $field->Field . " | Type: " . $field->Type . " | Null: " . $field->Null . " | Key: " . $field->Key . "<br>";
        }
        echo "</pre>";
        
        // Cek data contoh untuk debugging
        $sample = $this->db->get('surat')->row();
        echo "<h3>Data Contoh:</h3>";
        echo "<pre>";
        print_r($sample);
        echo "</pre>";
    }

    /* ================================
    EDIT SURAT - HANYA UNTUK DITOLAK DEKAN (SESUAI DENGAN VIEW BARU)
    ================================= */
    public function edit_surat($id)
    {
        $surat = $this->Surat_model->get_by_id($id);

        if (!$surat) {
            show_404();
            return;
        }

        // ========================================
        // 🔥 CEK APAKAH STATUS DITOLAK DEKAN
        // ========================================
        $status_lower = strtolower($surat->status);
        
        if ($status_lower !== 'ditolak dekan') {
            $this->session->set_flashdata('error', '⚠️ Edit hanya dapat dilakukan untuk surat yang ditolak Dekan! Status surat ini: ' . $surat->status);
            redirect('sekretariat');
            return;
        }

        $data['surat'] = (array)$surat;
        
        // Get dosen data untuk ditampilkan
        $data['dosen_data'] = $this->get_dosen_detail_for_autocomplete($surat);
        
        // Process eviden data
        $eviden_raw = $surat->eviden ?? "[]";
        
        if (is_string($eviden_raw)) {
            $eviden_decoded = json_decode($eviden_raw, true);
            $data['eviden'] = is_array($eviden_decoded) ? $eviden_decoded : [];
        } else {
            $data['eviden'] = is_array($eviden_raw) ? $eviden_raw : [];
        }

        // Jika bukan POST request, tampilkan form edit
        if (!$this->input->post()) {
            $this->load->view('sekretariat/edit_surat', $data);
            return;
        }

        // Jika ada POST data, proses update melalui method update_surat
        $this->update_surat($id);
    }

    /* ================================
    UPDATE SURAT - PROSES UPDATE DATA (HANYA UNTUK DITOLAK DEKAN)
    ================================= */
    public function update_surat($id = null)
    {
        // Jika $id tidak ada, ambil dari URL segment
        if (!$id) {
            $id = $this->uri->segment(3);
        }

        $surat = $this->Surat_model->get_by_id($id);

        if (!$surat) {
            show_404();
            return;
        }

        // ========================================
        // 🔥 VALIDASI: HANYA UNTUK DITOLAK DEKAN
        // ========================================
        $status_lower = strtolower($surat->status);
        
        if ($status_lower !== 'ditolak dekan') {
            $this->session->set_flashdata('error', '⚠️ Update hanya dapat dilakukan untuk surat yang ditolak Dekan!');
            redirect('sekretariat');
            return;
        }

        if (!$this->input->post()) {
            redirect('sekretariat/edit_surat/' . $id);
            return;
        }

        $post = $this->input->post();

        // Normalize data
        foreach ($post as $k => $v) {
            if (is_array($v)) {
                $post[$k] = array_values(array_filter($v, function($x) {
                    return trim($x) !== "";
                }));
            } else {
                $post[$k] = ($v === "" ? "-" : $v);
            }
        }

        // ========================================
        // 🔥 PROSES EVIDEN
        // ========================================
        $existing_eviden = json_decode($surat->eviden, true) ?: [];
        
        // Hapus file yang ditandai untuk dihapus
        $deleted_files = $post['delete_eviden'] ?? [];
        foreach ($deleted_files as $del_file) {
            if ($del_file && trim($del_file) !== '') {
                $existing_eviden = array_filter($existing_eviden, function($f) use ($del_file) {
                    return $f !== $del_file;
                });
                
                // Hapus file fisik jika bukan URL external
                if (!filter_var($del_file, FILTER_VALIDATE_URL)) {
                    $file_path = './uploads/eviden/' . $del_file;
                    if (file_exists($file_path)) {
                        @unlink($file_path);
                    }
                }
            }
        }
        
        // Upload file baru
        $new_files = [];
        if (!empty($_FILES['new_eviden']['name'][0])) {
            $upload_path = './uploads/eviden/';
            
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0755, true);
            }
            
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx|xls|xlsx';
            $config['max_size'] = 10240;
            $config['encrypt_name'] = TRUE;
            
            $this->load->library('upload', $config);
            
            $files_count = count($_FILES['new_eviden']['name']);
            
            for ($i = 0; $i < $files_count; $i++) {
                if (!empty($_FILES['new_eviden']['name'][$i])) {
                    $_FILES['file']['name'] = $_FILES['new_eviden']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['new_eviden']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['new_eviden']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['new_eviden']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['new_eviden']['size'][$i];
                    
                    if ($this->upload->do_upload('file')) {
                        $upload_data = $this->upload->data();
                        $new_files[] = $upload_data['file_name'];
                    } else {
                        log_message('error', 'Upload failed: ' . $this->upload->display_errors());
                    }
                }
            }
        }
        
        // Gabungkan eviden lama dan baru
        $final_eviden = array_merge(array_values($existing_eviden), $new_files);
        $update_eviden = json_encode($final_eviden);

        // ========================================
        // 🔥 PREPARE DATA UPDATE
        // ========================================
        $update = [
            'nama_kegiatan' => $post['nama_kegiatan'] ?? $surat->nama_kegiatan,
            'jenis_date' => $post['jenis_date'] ?? $surat->jenis_date,
            'tanggal_kegiatan' => $this->safe_date($post['tanggal_kegiatan'] ?? null),
            'akhir_kegiatan' => $this->safe_date($post['akhir_kegiatan'] ?? null),
            'periode_penugasan' => $this->safe_date($post['periode_penugasan'] ?? null),
            'akhir_periode_penugasan' => $this->safe_date($post['akhir_periode_penugasan'] ?? null),
            'periode_value' => $post['periode_value'] ?? $surat->periode_value,
            'tempat_kegiatan' => $post['tempat_kegiatan'] ?? $surat->tempat_kegiatan,
            'penyelenggara' => $post['penyelenggara'] ?? $surat->penyelenggara,
            'jenis_pengajuan' => $post['jenis_pengajuan'] ?? $surat->jenis_pengajuan,
            'lingkup_penugasan' => $post['lingkup_penugasan'] ?? $surat->lingkup_penugasan,
            'jenis_penugasan_perorangan' => $post['jenis_penugasan_perorangan'] ?? $surat->jenis_penugasan_perorangan,
            'penugasan_lainnya_perorangan' => $post['penugasan_lainnya_perorangan'] ?? $surat->penugasan_lainnya_perorangan,
            'jenis_penugasan_kelompok' => $post['jenis_penugasan_kelompok'] ?? $surat->jenis_penugasan_kelompok,
            'penugasan_lainnya_kelompok' => $post['penugasan_lainnya_kelompok'] ?? $surat->penugasan_lainnya_kelompok,
            'nip' => isset($post['nip']) ? json_encode($post['nip']) : $surat->nip,
            'eviden' => $update_eviden
        ];

        // ========================================
        // 🔥 UPDATE STATUS & APPROVAL (KIRIM KE DEKAN ULANG)
        // ========================================
        
        // Ambil approval_status saat ini
        $approval_status = json_decode($surat->approval_status, true);
        if (!is_array($approval_status)) {
            $approval_status = [
                'kk' => null,
                'sekretariat' => null,
                'dekan' => null
            ];
        }
        
        // PERBAIKAN: Tetap pertahankan approval KK dan Sekretariat yang sudah ada
        // Reset hanya approval dekan (karena akan di-review ulang)
        $approval_status['dekan'] = null;
        
        // Update status ke "disetujui sekretariat" (untuk dikirim ke dekan)
        $update['status'] = 'disetujui sekretariat';
        $update['approval_status'] = json_encode($approval_status);
        
        // Hapus catatan penolakan karena ini pengajuan ulang
        $update['catatan_penolakan'] = null;
        
        // Update timestamp
        $update['updated_at'] = date('Y-m-d H:i:s');

        // ========================================
        // 🔥 EKSEKUSI UPDATE DATABASE
        // ========================================
        $result = $this->Surat_model->update_surat($id, $update);

        if ($result) {
            log_message('info', "Surat ID {$id} direvisi dan diajukan ulang ke Dekan oleh Sekretariat");
            
            $this->session->set_flashdata('success', "✅ Revisi berhasil disimpan! Pengajuan telah dikirim kembali ke <strong>Dekan</strong> untuk persetujuan ulang.");
        } else {
            $this->session->set_flashdata('error', '❌ Gagal menyimpan revisi. Silakan coba lagi.');
        }
        
        redirect('sekretariat');
    }

    /* ================================
    HELPER: SAFE DATE (SAMA DENGAN SURAT CONTROLLER)
    ================================= */
    private function safe_date($val)
    {
        if (!$val || trim($val) === "" || $val === "-") return "-";
        $ts = strtotime($val);
        return $ts ? date('Y-m-d', $ts) : "";
    }

    /* ================================
    CETAK SURAT UNTUK SEKRETARIAT
    ================================= */
    public function cetak($id)
    {
        $surat = $this->Surat_model->get_by_id($id);
        
        if (!$surat) {
            show_404();
            return;
        }

        // Validasi: Hanya bisa cetak jika sudah disetujui sekretariat atau dekan
        $allowed_status = ['disetujui sekretariat', 'disetujui dekan'];
        if (!in_array(strtolower($surat->status), array_map('strtolower', $allowed_status))) {
            $this->session->set_flashdata('error', 'Surat belum disetujui untuk dicetak.');
            redirect('sekretariat');
            return;
        }

        $data['surat'] = $surat;
        
        // Get dosen data
        $data['dosen_data'] = $this->get_dosen_data_from_nip_fixed($surat->nip);
        
        $this->load->view('sekretariat/cetak_surat', $data);
    }

    /* ================================
    DOWNLOAD PDF UNTUK SEKRETARIAT
    ================================= */
    public function download_pdf($id)
    {
        $surat = $this->Surat_model->get_by_id($id);
        
        if (!$surat) {
            show_404();
            return;
        }

        // Validasi: Hanya bisa download jika sudah disetujui sekretariat atau dekan
        $allowed_status = ['disetujui sekretariat', 'disetujui dekan'];
        if (!in_array(strtolower($surat->status), array_map('strtolower', $allowed_status))) {
            $this->session->set_flashdata('error', 'Surat belum disetujui untuk didownload.');
            redirect('sekretariat');
            return;
        }

        $this->load->library('pdf');
        
        $data['surat'] = $surat;
        $data['dosen_data'] = $this->get_dosen_data_from_nip_fixed($surat->nip);
        
        $html = $this->load->view('sekretariat/pdf_surat', $data, TRUE);
        
        $this->pdf->generate($html, 'surat_tugas_' . $id . '.pdf', TRUE);
    }

    /* ================================
    VALIDASI QR CODE UNTUK SEKRETARIAT
    ================================= */
    public function validasi($id)
    {
        $surat = $this->Surat_model->get_by_id($id);
        
        if (!$surat) {
            $data['found'] = false;
        } else {
            $data['found'] = true;
            $data['surat'] = $surat;
            $data['dosen_data'] = $this->get_dosen_data_from_nip_fixed($surat->nip);
        }

        $data['role'] = 'sekretariat';
        
        $this->load->view('sekretariat/validasi_surat', $data);
    }

    /* ================================
    GET STATUS APPROVAL UNTUK SEKRETARIAT
    ================================= */
    public function get_status($surat_id)
    {
        header('Content-Type: application/json');
        
        $this->db->select('id, status, created_at, catatan_penolakan, approval_status');
        $this->db->where('id', $surat_id);
        $query = $this->db->get('surat');

        if ($query->num_rows() == 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Data surat tidak ditemukan'
            ]);
            return;
        }

        $surat = $query->row();

        // Decode JSON approval_status
        $approval = json_decode($surat->approval_status, true);
        if (!is_array($approval)) $approval = [];

        // Get waktu persetujuan
        $getTime = function($val) {
            if (!$val) return null;

            if (is_string($val)) return $val; // approved → datetime string
            if (is_array($val) && isset($val['waktu'])) return $val['waktu']; // rejected → ambil waktu penolakan

            return null;
        };

        $kk  = $getTime($approval['kk'] ?? null);
        $sek = $getTime($approval['sekretariat'] ?? null);
        $dek = $getTime($approval['dekan'] ?? null);

        // Status untuk sekretariat
        $status = strtolower(trim($surat->status ?? 'pengajuan'));
        
        $steps = [];
        $progress_percentage = 0;

        // Step pertama: Mengirim
        $steps[] = [
            'step_name' => 'Mengirim',
            'status' => 'completed',
            'date' => date('d M Y', strtotime($surat->created_at)),
            'label' => 'Terkirim'
        ];

        // Tentukan steps berdasarkan status
        switch ($status) {
            case 'disetujui kk':
                $steps[] = [
                    'step_name' => 'Disetujui Kaprodi',
                    'status' => 'completed',
                    'date' => ($kk) ? date('d M Y', strtotime($kk)) : '-',
                    'label' => 'Disetujui'
                ];
                $steps[] = [
                    'step_name' => 'Menunggu Sekretariat',
                    'status' => 'in-progress',
                    'date' => '-',
                    'label' => 'Dalam Proses'
                ];
                $steps[] = [
                    'step_name' => 'Persetujuan Dekan',
                    'status' => 'pending',
                    'date' => '-',
                    'label' => 'Menunggu'
                ];
                $progress_percentage = 65;
                break;

            case 'disetujui sekretariat':
                $steps[] = [
                    'step_name' => 'Disetujui Kaprodi',
                    'status' => 'completed',
                    'date' => ($kk) ? date('d M Y', strtotime($kk)) : '-',
                    'label' => 'Disetujui'
                ];
                $steps[] = [
                    'step_name' => 'Disetujui Sekretariat',
                    'status' => 'completed',
                    'date' => ($sek) ? date('d M Y', strtotime($sek)) : '-',
                    'label' => 'Disetujui'
                ];
                $steps[] = [
                    'step_name' => 'Menunggu Dekan',
                    'status' => 'in-progress',
                    'date' => '-',
                    'label' => 'Dalam Proses'
                ];
                $progress_percentage = 95;
                break;

            case 'disetujui dekan':
                $steps[] = [
                    'step_name' => 'Disetujui Kaprodi',
                    'status' => 'completed',
                    'date' => ($kk) ? date('d M Y', strtotime($kk)) : '-',
                    'label' => 'Disetujui'
                ];
                $steps[] = [
                    'step_name' => 'Disetujui Sekretariat',
                    'status' => 'completed',
                    'date' => ($sek) ? date('d M Y', strtotime($sek)) : '-',
                    'label' => 'Disetujui'
                ];
                $steps[] = [
                    'step_name' => 'Disetujui Dekan',
                    'status' => 'completed',
                    'date' => ($dek) ? date('d M Y', strtotime($dek)) : '-',
                    'label' => 'Disetujui'
                ];
                $progress_percentage = 100;
                break;

            case 'ditolak sekretariat':
                $steps[] = [
                    'step_name' => 'Disetujui Kaprodi',
                    'status' => 'completed',
                    'date' => ($kk) ? date('d M Y', strtotime($kk)) : '-',
                    'label' => 'Disetujui'
                ];
                $steps[] = [
                    'step_name' => 'Ditolak Sekretariat',
                    'status' => 'rejected',
                    'date' => ($sek) ? date('d M Y', strtotime($sek)) : '-',
                    'label' => 'Ditolak',
                    'catatan_penolakan' => $surat->catatan_penolakan
                ];
                $steps[] = [
                    'step_name' => 'Persetujuan Dekan',
                    'status' => 'pending',
                    'date' => '-',
                    'label' => 'Dibatalkan'
                ];
                $progress_percentage = 65;
                break;

            case 'ditolak dekan':
                $steps[] = [
                    'step_name' => 'Disetujui Kaprodi',
                    'status' => 'completed',
                    'date' => ($kk) ? date('d M Y', strtotime($kk)) : '-',
                    'label' => 'Disetujui'
                ];
                $steps[] = [
                    'step_name' => 'Disetujui Sekretariat',
                    'status' => 'completed',
                    'date' => ($sek) ? date('d M Y', strtotime($sek)) : '-',
                    'label' => 'Disetujui'
                ];
                $steps[] = [
                    'step_name' => 'Ditolak Dekan',
                    'status' => 'rejected',
                    'date' => ($dek) ? date('d M Y', strtotime($dek)) : '-',
                    'label' => 'Ditolak',
                    'catatan_penolakan' => $surat->catatan_penolakan
                ];
                $progress_percentage = 100;
                break;

            default:
                $steps[] = [
                    'step_name' => 'Persetujuan Kaprodi',
                    'status' => 'pending',
                    'date' => '-',
                    'label' => 'Menunggu'
                ];
                $steps[] = [
                    'step_name' => 'Persetujuan Sekretariat',
                    'status' => 'pending',
                    'date' => '-',
                    'label' => 'Menunggu'
                ];
                $steps[] = [
                    'step_name' => 'Persetujuan Dekan',
                    'status' => 'pending',
                    'date' => '-',
                    'label' => 'Menunggu'
                ];
                $progress_percentage = 25;
                break;
        }

        echo json_encode([
            'success' => true,
            'data' => [
                'steps' => $steps,
                'current_status' => $status,
                'status_raw' => $surat->status,
                'progress_percentage' => $progress_percentage,
                'catatan_penolakan' => $surat->catatan_penolakan,
                'durasi' => [
                    'durasi_1' => ($kk) ? $this->bedaWaktu($surat->created_at, $kk) : '-',
                    'durasi_2' => ($kk && $sek) ? $this->bedaWaktu($kk, $sek) : '-',
                    'durasi_3' => ($sek && $dek) ? $this->bedaWaktu($sek, $dek) : '-',
                ]
            ]
        ]);
    }

    /* ================================
    HELPER: BEDA WAKTU
    ================================= */
    private function bedaWaktu($start, $end)
    {
        if (!$start || !$end) return '-';

        try {
            $mulai = new DateTime($start);
            $selesai = new DateTime($end);
        } catch (Exception $e) {
            return '-';
        }

        $diff = $mulai->diff($selesai);

        return $diff->d . " hari " . $diff->h . " jam ";
    }
   /* ================================
   AUTOCOMPLETE NIP - SAMA SEPERTI DI SURAT CONTROLLER
================================= */
public function autocomplete_nip()
{
    header('Content-Type: application/json');
    
    $query = $this->input->get('q');
    $field = $this->input->get('field');
    
    if (empty($query) || strlen($query) < 1) {
        echo json_encode([]);
        return;
    }
    
    $allowed_fields = ['nip', 'nama_dosen', 'jabatan', 'divisi'];
    if (!in_array($field, $allowed_fields)) {
        $field = 'nip';
    }
    
    try {
        $this->db->select('nip, nama_dosen, jabatan, divisi');
        $this->db->from('list_dosen');
        $this->db->like($field, $query);
        $this->db->limit(10);
        $this->db->order_by($field, 'ASC');
        
        $result = $this->db->get();
        
        if ($result->num_rows() > 0) {
            $data = $result->result_array();
            echo json_encode($data);
        } else {
            echo json_encode([]);
        }
        
    } catch (Exception $e) {
        log_message('error', 'Autocomplete error: ' . $e->getMessage());
        echo json_encode([]);
    }
}
}