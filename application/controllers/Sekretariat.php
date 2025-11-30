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
DETAIL MODAL (AJAX) - MENGAMBIL DARI KAPRODI YANG BERHASIL
================================= */
public function getDetailPengajuan($id)
{
    $this->db->where('id', $id);
    $pengajuan = $this->db->get('surat')->row();
    
    if ($pengajuan) {
        $dosen_data = $this->get_dosen_data_from_nip_fixed($pengajuan->nip);
        
        // Ambil semua field yang berkaitan dengan periode
        $jenis_date = $pengajuan->jenis_date ?? null;
        $periode_kegiatan = $pengajuan->periode_kegiatan ?? null;
        $periode_value = $pengajuan->periode_value ?? null;
        $tanggal_kegiatan = $pengajuan->tanggal_kegiatan ?? null;
        $akhir_kegiatan = $pengajuan->akhir_kegiatan ?? null;
        
        // Tentukan nilai periode yang akan ditampilkan
        $periode_display = '-';
        
        if ($jenis_date === 'Custom') {
            // FORMAT CUSTOM: "30 Nov 2025 - 01 Des 2025"
            if ($tanggal_kegiatan && $akhir_kegiatan) {
                // Format tanggal Indonesia
                $bulan_indonesia = [
                    'Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Apr',
                    'May' => 'Mei', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Ags',
                    'Sep' => 'Sep', 'Oct' => 'Okt', 'Nov' => 'Nov', 'Dec' => 'Des'
                ];
                
                $format_tanggal = function($date) use ($bulan_indonesia) {
                    $day = date('d', strtotime($date));
                    $month_en = date('M', strtotime($date));
                    $month_id = $bulan_indonesia[$month_en] ?? $month_en;
                    $year = date('Y', strtotime($date));
                    return $day . ' ' . $month_id . ' ' . $year;
                };
                
                $start_formatted = $format_tanggal($tanggal_kegiatan);
                $end_formatted = $format_tanggal($akhir_kegiatan);
                $periode_display = $start_formatted . ' - ' . $end_formatted;
            } elseif ($tanggal_kegiatan) {
                // Jika hanya ada tanggal mulai
                $periode_display = date('d M Y', strtotime($tanggal_kegiatan));
            }
        } elseif ($jenis_date === 'Periode') {
            // Untuk jenis Periode, gunakan periode_kegiatan atau periode_value
            $periode_display = $periode_kegiatan ?: $periode_value ?: '-';
        }
        
        $response_data = array(
            'id' => $pengajuan->id,
            'nama_kegiatan' => $pengajuan->nama_kegiatan,
            'status' => $pengajuan->status,
            'jenis_pengajuan' => $pengajuan->jenis_pengajuan,
            'lingkup_penugasan' => $pengajuan->lingkup_penugasan,
            'penyelenggara' => $pengajuan->penyelenggara,
            'tanggal_kegiatan' => $tanggal_kegiatan,
            'akhir_kegiatan' => $akhir_kegiatan,
            'periode_kegiatan' => $periode_display,  // Nilai yang sudah diformat
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
}