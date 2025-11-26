<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kaprodi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->model('Surat_model');
    }

    /* ================================
       DASHBOARD
    ================================= */
    public function index()
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $data['tahun'] = $tahun;

        // Surat yang relevan bagi kaprodi (status pengajuan)
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where("status", 'pengajuan');
        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // Statistik
        $this->db->where('YEAR(created_at)', $tahun);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'pengajuan');
        $data['pending_count'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui KK', 'disetujui dekan', 'disetujui sekretariat']);
        $data['approved_count'] = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['ditolak KK', 'ditolak sekretariat']);
        $data['rejected_count'] = $this->db->count_all_results('surat');

        // Grafik
        $total     = array_fill(0, 12, 0);
        $approved  = array_fill(0, 12, 0);
        $rejected  = array_fill(0, 12, 0);
        $pending   = array_fill(0, 12, 0);

        $this->db->where('YEAR(created_at)', $tahun);
        $query = $this->db->get('surat')->result();

        foreach ($query as $row) {
            $month = (int)date('m', strtotime($row->created_at)) - 1;

            $total[$month]++;

            if ($row->status == 'pengajuan') {
                $pending[$month]++;
            }

            if (in_array($row->status, ['disetujui KK', 'disetujui dekan', 'disetujui sekretariat'])) {
                $approved[$month]++;
            }

            if (in_array($row->status, ['ditolak KK', 'ditolak sekretariat'])) {
                $rejected[$month]++;
            }
        }

        $data['chart_total']    = $total;
        $data['chart_approved'] = $approved;
        $data['chart_rejected'] = $rejected;
        $data['chart_pending']  = $pending;

        $this->load->view('kaprodi/dashboard', $data);
    }

    /* ================================
       PENDING (Status Pengajuan)
    ================================= */
    public function pending()
    {
        $search = $this->input->get('search');
        $tahun = $this->input->get('tahun') ?? date('Y');
        
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'pengajuan');
        
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
        $data['judul'] = "Pengajuan Menunggu Persetujuan Kaprodi";
        $data['role'] = "kaprodi";
        $data['tahun'] = $tahun;

        $this->load->view('kaprodi/halaman_pending', $data);
    }

    /* ================================
       DISETUJUI 
    ================================= */
    public function disetujui()
    {
        $search = $this->input->get('search');
        $tahun = $this->input->get('tahun') ?? date('Y');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui KK', 'disetujui dekan', 'disetujui sekretariat']);

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
        $data['judul'] = "Pengajuan Disetujui";
        $data['role'] = "kaprodi";
        $data['tahun'] = $tahun;

        $this->load->view('kaprodi/halaman_disetujui', $data);
    }

    /* ================================
       DITOLAK
    ================================= */
    public function ditolak()
    {
        $search = $this->input->get('search');
        $tahun = $this->input->get('tahun') ?? date('Y');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['ditolak KK', 'ditolak sekretariat']);

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
        $data['judul'] = "Pengajuan Ditolak";
        $data['role'] = "kaprodi";
        $data['tahun'] = $tahun;

        $this->load->view('kaprodi/halaman_ditolak', $data);
    }

    /* ================================
       TOTAL SEMUA PENGAJUAN
    ================================= */
    public function semua()
    {
        $search = $this->input->get('search');
        $status_filter = $this->input->get('status');
        $tahun = $this->input->get('tahun') ?? date('Y');

        $this->db->where('YEAR(created_at)', $tahun);

        if (!empty($status_filter)) {
            switch ($status_filter) {
                case 'pending':
                    $this->db->where('status', 'pengajuan');
                    break;
                case 'approved':
                    $this->db->where_in('status', ['disetujui KK', 'disetujui dekan', 'disetujui sekretariat']);
                    break;
                case 'rejected':
                    $this->db->where_in('status', ['ditolak KK', 'ditolak sekretariat']);
                    break;
                default:
                    // Tampilkan semua
                    break;
            }
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
        $data['judul'] = "Total Pengajuan - Kaprodi";
        $data['role'] = "kaprodi";
        $data['tahun'] = $tahun;
        $data['status_filter'] = $status_filter;

        $this->load->view('kaprodi/halaman_total', $data);
    }

    /* ================================
       DETAIL MODAL (AJAX) - VERSI REVISI DENGAN PERBAIKAN DATA DOSEN
    ================================= */
    public function getDetailPengajuan($id)
    {
        // Tambahkan logging untuk debug
        error_log("Getting detail for surat ID: " . $id);
        
        $this->db->where('id', $id);
        $pengajuan = $this->db->get('surat')->row();
        
        if ($pengajuan) {
            // Debug data NIP dari database
            error_log("Raw NIP data from database: " . $pengajuan->nip);
            error_log("NIP data type: " . gettype($pengajuan->nip));
            
            // Ambil data dosen dengan fungsi yang diperbaiki
            $dosen_data = $this->get_dosen_data_from_nip_fixed($pengajuan->nip);
            
            // Gabungkan data pengajuan dengan data dosen
            $response_data = array(
                'id' => $pengajuan->id,
                'nama_kegiatan' => $pengajuan->nama_kegiatan,
                'status' => $pengajuan->status,
                'jenis_pengajuan' => $pengajuan->jenis_pengajuan,
                'lingkup_penugasan' => $pengajuan->lingkup_penugasan,
                'penyelenggara' => $pengajuan->penyelenggara,
                'tanggal_kegiatan' => $pengajuan->tanggal_kegiatan,
                'tempat_kegiatan' => $pengajuan->tempat_kegiatan,
                'created_at' => $pengajuan->created_at,
                'eviden' => $pengajuan->eviden,
                'nomor_surat' => $pengajuan->nomor_surat,
                'catatan_penolakan' => $pengajuan->catatan_penolakan,
                'nip_raw' => $pengajuan->nip, // Tambahkan field untuk debug
                'dosen_data' => $dosen_data
            );
            
            error_log("Sending response with " . count($dosen_data) . " dosen records");
            
            echo json_encode([
                'success' => true,
                'data' => $response_data
            ]);
        } else {
            error_log("Surat not found for ID: " . $id);
            echo json_encode([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    /* ================================
       FUNGSI REVISI FIXED: Ambil data dosen dari tabel list_dosen berdasarkan NIP
       DENGAN PERBAIKAN UNTUK FORMAT JSON ARRAY ["20940012"]
    ================================= */
    private function get_dosen_data_from_nip_fixed($nip_data)
    {
        $dosen_data = array();
        
        // Debug: Lihat data NIP yang diterima
        error_log("FIXED METHOD - NIP Data Received: " . print_r($nip_data, true));
        error_log("FIXED METHOD - NIP Data Type: " . gettype($nip_data));
        
        if (empty($nip_data) || $nip_data === '-' || $nip_data === '[]' || $nip_data === 'null') {
            error_log("NIP data is empty or invalid");
            return [array(
                'nama' => 'Data dosen tidak tersedia',
                'nip' => '-',
                'jabatan' => '-',
                'divisi' => '-'
            )];
        }
        
        // Handle berbagai format NIP - PERBAIKAN UTAMA
        $nip_array = array();
        
        if (is_string($nip_data)) {
            $trimmed_data = trim($nip_data);
            
            // Cek jika format JSON array seperti ["20940012"]
            if (preg_match('/^\[.*\]$/', $trimmed_data)) {
                $decoded = json_decode($trimmed_data, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $nip_array = $decoded;
                    error_log("Successfully decoded JSON array: " . print_r($nip_array, true));
                } else {
                    error_log("JSON decode failed, using string extraction");
                    // Extract NIP dari string menggunakan regex
                    preg_match_all('/\d+/', $trimmed_data, $matches);
                    $nip_array = $matches[0] ?? [$trimmed_data];
                }
            } else {
                // Single NIP string
                $nip_array = [$trimmed_data];
            }
        } elseif (is_array($nip_data)) {
            $nip_array = $nip_data;
        } else {
            $nip_array = [$nip_data];
        }
        
        // Clean and validate NIP array - PERBAIKAN: Handle nested arrays
        $nip_array = array_filter(array_map(function($nip) {
            if (is_array($nip)) {
                // Jika masih array, ambil nilai pertama
                return !empty($nip) ? trim(strval($nip[0])) : null;
            }
            return trim(strval($nip));
        }, $nip_array), function($nip) {
            return !empty($nip) && $nip !== '-' && $nip !== 'null' && $nip !== '[]';
        });
        
        error_log("FIXED METHOD - Processed NIP Array: " . print_r($nip_array, true));
        
        if (empty($nip_array)) {
            error_log("No valid NIP found after processing");
            return [array(
                'nama' => 'Data dosen tidak tersedia',
                'nip' => '-',
                'jabatan' => '-',
                'divisi' => '-'
            )];
        }
        
        // Ambil data dosen dari tabel list_dosen - PERBAIKAN: Gunakan query yang lebih robust
        $this->db->select('nip, nama_dosen, jabatan, divisi');
        $this->db->from('list_dosen');
        
        // Gunakan where_in untuk multiple NIP
        if (count($nip_array) === 1) {
            $this->db->where('nip', $nip_array[0]);
        } else {
            $this->db->where_in('nip', $nip_array);
        }
        
        $query = $this->db->get();
        
        error_log("FIXED METHOD - Database Query: " . $this->db->last_query());
        error_log("FIXED METHOD - Found " . $query->num_rows() . " dosen records");
        
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
            
            // Buat array asosiatif dengan NIP sebagai key
            $dosen_by_nip = [];
            foreach ($results as $row) {
                $dosen_by_nip[trim($row['nip'])] = array(
                    'nama' => $row['nama_dosen'],
                    'nip' => $row['nip'],
                    'jabatan' => $row['jabatan'],
                    'divisi' => $row['divisi']
                );
            }
            
            error_log("FIXED METHOD - Dosen by NIP mapping: " . print_r($dosen_by_nip, true));
            
            // Return data dalam urutan yang sama dengan input NIP array
            foreach ($nip_array as $nip) {
                $clean_nip = trim(strval($nip));
                if (isset($dosen_by_nip[$clean_nip])) {
                    $dosen_data[] = $dosen_by_nip[$clean_nip];
                    error_log("FIXED METHOD - Found dosen for NIP: " . $clean_nip);
                } else {
                    // Fallback untuk NIP yang tidak ditemukan
                    error_log("FIXED METHOD - NIP not found in database: " . $clean_nip);
                    $dosen_data[] = array(
                        'nama' => 'Data tidak ditemukan',
                        'nip' => $clean_nip,
                        'jabatan' => '-',
                        'divisi' => '-'
                    );
                }
            }
        } else {
            error_log("FIXED METHOD - No dosen data found in database for NIPs: " . implode(', ', $nip_array));
            // Jika tidak ada data di list_dosen, buat dari NIP saja
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
        
        error_log("FIXED METHOD - Final dosen data: " . print_r($dosen_data, true));
        return $dosen_data;
    }

    /* ================================
       FUNGSI DEBUG: Untuk troubleshooting data dosen
    ================================= */
    public function debug_dosen_data($surat_id = null)
    {
        if (!$surat_id) {
            // Ambil sample surat untuk debug
            $this->db->where('nip IS NOT NULL');
            $this->db->limit(1);
            $sample_surat = $this->db->get('surat')->row();
            $surat_id = $sample_surat ? $sample_surat->id : null;
        }
        
        echo "<h1>Debug Data Dosen</h1>";
        
        if ($surat_id) {
            $this->db->where('id', $surat_id);
            $surat = $this->db->get('surat')->row();
            
            echo "<h2>Data Surat (ID: $surat_id)</h2>";
            echo "<pre>";
            print_r($surat);
            echo "</pre>";
            
            echo "<h2>Proses get_dosen_data_from_nip_fixed</h2>";
            $dosen_data = $this->get_dosen_data_from_nip_fixed($surat->nip);
            echo "<pre>";
            print_r($dosen_data);
            echo "</pre>";
        }
        
        echo "<h2>Sample Data list_dosen (5 records)</h2>";
        $sample_dosen = $this->db->get('list_dosen', 5)->result();
        echo "<pre>";
        print_r($sample_dosen);
        echo "</pre>";
        
        echo "<h2>Struktur Tabel list_dosen</h2>";
        $structure = $this->db->query("DESCRIBE list_dosen")->result();
        echo "<pre>";
        print_r($structure);
        echo "</pre>";
    }

    /* ================================
       APPROVE - TANPA NOMOR SURAT (Karena Kaprodi tidak butuh nomor surat)
    ================================= */
    public function approve($id)
    {
        $surat = $this->db->get_where('surat', ['id' => $id])->row();
        
        if (!$surat) {
            $this->session->set_flashdata('error', 'Surat tidak ditemukan.');
            redirect('kaprodi');
        }

        $approval = json_decode($surat->approval_status, true) ?? [];

        $approval['kk'] = date("Y-m-d H:i:s");
        $this->db->where('id', $id)->update('surat', [
            'status' => 'disetujui KK',
            'approval_status' => json_encode($approval),
        ]);

        $this->session->set_flashdata('success', 'Surat berhasil disetujui Kaprodi.');
        redirect('kaprodi');
    }

    /* ================================
       REJECT
    ================================= */
    public function reject($id)
    {
        $surat = $this->db->get_where('surat', ['id' => $id])->row();
        
        if (!$surat) {
            $this->session->set_flashdata('error', 'Surat tidak ditemukan.');
            redirect('kaprodi');
        }

        $notes = $this->input->post('rejection_notes');
        $approval = json_decode($surat->approval_status, true) ?? [];

        $approval['kk'] = date("Y-m-d H:i:s");

        $this->db->where('id', $id)->update('surat', [
            'status' => 'ditolak KK',
            'approval_status' => json_encode($approval),
            'catatan_penolakan' => $notes,
        ]);

        $this->session->set_flashdata('success', 'Surat berhasil ditolak Kaprodi.');
        redirect('kaprodi');
    }

    /* ================================
       REALTIME DASHBOARD COUNTER
    ================================= */
    public function get_dashboard_counts()
    {
        $tahun = $this->input->get('tahun') ?? date('Y');

        $this->db->where('YEAR(created_at)', $tahun);
        $total = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'pengajuan');
        $pending = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui KK', 'disetujui dekan', 'disetujui sekretariat']);
        $approved = $this->db->count_all_results('surat');

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['ditolak KK', 'ditolak sekretariat']);
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
       BULK APPROVE - MULTI APPROVE
    ================================= */
    public function bulk_approve()
    {
        // Check jika request adalah POST
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $ids = $this->input->post('ids');
            
            // Validasi input
            if (empty($ids)) {
                $this->session->set_flashdata('error', 'Tidak ada pengajuan yang dipilih.');
                redirect('kaprodi/pending');
            }
            
            // Convert string IDs to array
            $id_array = explode(',', $ids);
            
            $success_count = 0;
            $error_count = 0;
            $error_messages = [];
            
            foreach ($id_array as $id) {
                $id = trim($id);
                
                // Ambil data surat
                $surat = $this->db->get_where('surat', ['id' => $id])->row();
                
                if (!$surat) {
                    $error_count++;
                    $error_messages[] = "Data tidak ditemukan (ID: $id)";
                    continue;
                }
                
                // Update approval status
                $approval = json_decode($surat->approval_status, true);
                $approval['kk'] = date("Y-m-d H:i:s");
                
                // Update database
                $update_data = [
                    'status' => 'disetujui KK',
                    'approval_status' => json_encode($approval),
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
            
            redirect('kaprodi/pending');
        } else {
            // Jika bukan POST request, redirect ke halaman pending
            redirect('kaprodi/pending');
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
                redirect('kaprodi/pending');
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
                $approval['kk'] = date("Y-m-d H:i:s");
                
                // Update database
                $update_data = [
                    'status' => 'ditolak KK',
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
            
            redirect('kaprodi/pending');
        } else {
            // Jika bukan POST request, redirect ke halaman pending
            redirect('kaprodi/pending');
        }
    }
}