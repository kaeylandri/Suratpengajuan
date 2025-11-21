<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dekan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
    }

    public function index($filter = 'all')
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $search = $this->input->get('search');
        $status_filter = $this->input->get('status');

        $data['tahun'] = $tahun;
        $data['current_filter'] = $filter;

        // Hanya ambil data yang relevan untuk dekan
        $this->db->where('YEAR(tanggal_created_atpengajuan)', $tahun);
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);

        // Filter search
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('nama_dosen', $search);
            $this->db->group_end();
        }

        // Filter status dari URL parameter
        if (!empty($status_filter)) {
            switch ($status_filter) {
                case 'pending':
                    $this->db->where('status', 'disetujui sekretariat');
                    break;
                case 'approved':
                    $this->db->where('status', 'disetujui dekan');
                    break;
                case 'rejected':
                    $this->db->where('status', 'ditolak dekan');
                    break;
            }
        } else {
            // Filter berdasarkan parameter route
            switch ($filter) {
                case 'approved':
                    $this->db->where('status', 'disetujui dekan');
                    break;
                case 'rejected':
                    $this->db->where('status', 'ditolak dekan');
                    break;
                case 'pending':
                    $this->db->where('status', 'disetujui sekretariat');
                    break;
                default:
                    // Semua data untuk dashboard utama (hanya yang relevan untuk dekan)
                    break;
            }
        }

        $data['surat_list'] = $this->db->order_by('created_at', 'DESC')
            ->get('surat')
            ->result_array();

        // Statistik untuk card - hanya data yang relevan untuk dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $data['approved_count'] = $this->db->where('YEAR(created_at)', $tahun)
            ->where('status', 'disetujui dekan')
            ->count_all_results('surat');

        $data['pending_count'] = $this->db->where('YEAR(created_at)', $tahun)
            ->where('status', 'disetujui sekretariat')
            ->count_all_results('surat');

        $data['rejected_count'] = $this->db->where('YEAR(created_at)', $tahun)
            ->where('status', 'ditolak dekan')
            ->count_all_results('surat');

        // Grafik data - hanya data yang relevan untuk dekan
        $total     = array_fill(0, 12, 0);
        $approved  = array_fill(0, 12, 0);
        $rejected  = array_fill(0, 12, 0);

        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $query = $this->db->get('surat')->result();

        foreach ($query as $row) {
            $month = (int)date('m', strtotime($row->created_at)) - 1;

            $total[$month]++;

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

        $this->load->view('dekan/dashboard', $data);
    }

    // Method untuk halaman khusus berdasarkan card
    public function halaman_total()
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $search = $this->input->get('search');
        $status = $this->input->get('status');

        $data['tahun'] = $tahun;
        $data['current_page'] = 'total';

        // Ambil semua data yang relevan untuk dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);

        // Filter search
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('nama_dosen', $search);
            $this->db->group_end();
        }

        // Filter status
        if (!empty($status)) {
            switch ($status) {
                case 'pending':
                    $this->db->where('status', 'disetujui sekretariat');
                    break;
                case 'approved':
                    $this->db->where('status', 'disetujui dekan');
                    break;
                case 'rejected':
                    $this->db->where('status', 'ditolak dekan');
                    break;
            }
        }

        $data['surat_list'] = $this->db->order_by('created_at', 'DESC')
            ->get('surat')
            ->result_array();

        // Statistik - hanya data yang relevan untuk dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);

        // Apply same filters for statistics
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('nama_dosen', $search);
            $this->db->group_end();
        }

        if (!empty($status)) {
            switch ($status) {
                case 'pending':
                    $this->db->where('status', 'disetujui sekretariat');
                    break;
                case 'approved':
                    $this->db->where('status', 'disetujui dekan');
                    break;
                case 'rejected':
                    $this->db->where('status', 'ditolak dekan');
                    break;
            }
        }

        $data['total_surat'] = $this->db->count_all_results('surat');

        $data['approved_count'] = $this->db->where('YEAR(created_at)', $tahun)
            ->where('status', 'disetujui dekan')
            ->count_all_results('surat');

        $data['pending_count'] = $this->db->where('YEAR(created_at)', $tahun)
            ->where('status', 'disetujui sekretariat')
            ->count_all_results('surat');

        $data['rejected_count'] = $this->db->where('YEAR(created_at)', $tahun)
            ->where('status', 'ditolak dekan')
            ->count_all_results('surat');

        $this->load->view('dekan/halaman_total', $data);
    }

    public function halaman_disetujui()
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $search = $this->input->get('search');

        $data['tahun'] = $tahun;
        $data['current_page'] = 'disetujui';

        // Ambil hanya data yang disetujui dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'disetujui dekan');

        // Filter search
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('nama_dosen', $search);
            $this->db->group_end();
        }

        $data['surat_list'] = $this->db->order_by('created_at', 'DESC')
            ->get('surat')
            ->result_array();

        // Statistik - hanya data yang relevan untuk dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $data['approved_count'] = $this->db->where('YEAR(created_at)', $tahun)
            ->where('status', 'disetujui dekan')
            ->count_all_results('surat');

        $data['pending_count'] = $this->db->where('YEAR(created_at)', $tahun)
            ->where('status', 'disetujui sekretariat')
            ->count_all_results('surat');

        $data['rejected_count'] = $this->db->where('YEAR(created_at)', $tahun)
            ->where('status', 'ditolak dekan')
            ->count_all_results('surat');

        $this->load->view('dekan/halaman_disetujui', $data);
    }

    public function halaman_ditolak()
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $search = $this->input->get('search');

        $data['tahun'] = $tahun;
        $data['current_page'] = 'ditolak';

        // Ambil hanya data yang ditolak dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'ditolak dekan');

        // Filter search
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('nama_dosen', $search);
            $this->db->group_end();
        }

        $data['surat_list'] = $this->db->order_by('created_at', 'DESC')
            ->get('surat')
            ->result_array();

        // Statistik - hanya data yang relevan untuk dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $data['approved_count'] = $this->db->where('YEAR(created_at)', $tahun)
            ->where('status', 'disetujui dekan')
            ->count_all_results('surat');

        $data['pending_count'] = $this->db->where('YEAR(created_at)', $tahun)
            ->where('status', 'disetujui sekretariat')
            ->count_all_results('surat');

        $data['rejected_count'] = $this->db->where('YEAR(created_at)', $tahun)
            ->where('status', 'ditolak dekan')
            ->count_all_results('surat');

        $this->load->view('dekan/halaman_ditolak', $data);
    }

    public function halaman_pending()
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $search = $this->input->get('search');

        $data['tahun'] = $tahun;
        $data['current_page'] = 'pending';

        // Ambil hanya data yang menunggu persetujuan dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where('status', 'disetujui sekretariat');

        // Filter search
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kegiatan', $search);
            $this->db->or_like('penyelenggara', $search);
            $this->db->or_like('nama_dosen', $search);
            $this->db->group_end();
        }

        $data['surat_list'] = $this->db->order_by('created_at', 'DESC')
            ->get('surat')
            ->result_array();

        // Statistik - hanya data yang relevan untuk dekan
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $data['total_surat'] = $this->db->count_all_results('surat');

        $data['approved_count'] = $this->db->where('YEAR(created_at)', $tahun)
            ->where('status', 'disetujui dekan')
            ->count_all_results('surat');

        $data['pending_count'] = $this->db->where('YEAR(created_at)', $tahun)
            ->where('status', 'disetujui sekretariat')
            ->count_all_results('surat');

        $data['rejected_count'] = $this->db->where('YEAR(created_at)', $tahun)
            ->where('status', 'ditolak dekan')
            ->count_all_results('surat');

        $this->load->view('dekan/halaman_pending', $data);
    }

    public function approve($id)
    {
        $this->db->where('id', $id)->update('surat', [
            'status' => 'disetujui dekan',
        ]);

        $this->session->set_flashdata('success', 'Surat berhasil disetujui oleh Dekan.');

        // Redirect kembali ke halaman sebelumnya dengan filter yang sama
        $current_page = $this->input->get('from') ?? 'dekan';
        $tahun = $this->input->get('tahun') ?? date('Y');
        $search = $this->input->get('search');
        $status = $this->input->get('status');

        $query_params = 'tahun=' . $tahun;
        if (!empty($search)) {
            $query_params .= '&search=' . urlencode($search);
        }
        if (!empty($status)) {
            $query_params .= '&status=' . $status;
        }

        switch ($current_page) {
            case 'total':
                redirect('dekan/halaman_total?' . $query_params);
                break;
            case 'disetujui':
                redirect('dekan/halaman_disetujui?' . $query_params);
                break;
            case 'ditolak':
                redirect('dekan/halaman_ditolak?' . $query_params);
                break;
            case 'pending':
                redirect('dekan/halaman_pending?' . $query_params);
                break;
            default:
                redirect('dekan?' . $query_params);
        }
    }

    public function reject($id)
    {
        $notes = $this->input->post('rejection_notes');

        $this->db->where('id', $id)->update('surat', [
            'status' => 'ditolak dekan',
            'catatan_penolakan' => $notes,
        ]);

        $this->session->set_flashdata('success', 'Surat berhasil ditolak.');

        // Redirect kembali ke halaman sebelumnya dengan filter yang sama
        $current_page = $this->input->get('from') ?? 'dekan';
        $tahun = $this->input->get('tahun') ?? date('Y');
        $search = $this->input->get('search');
        $status = $this->input->get('status');

        $query_params = 'tahun=' . $tahun;
        if (!empty($search)) {
            $query_params .= '&search=' . urlencode($search);
        }
        if (!empty($status)) {
            $query_params .= '&status=' . $status;
        }

        switch ($current_page) {
            case 'total':
                redirect('dekan/halaman_total?' . $query_params);
                break;
            case 'disetujui':
                redirect('dekan/halaman_disetujui?' . $query_params);
                break;
            case 'ditolak':
                redirect('dekan/halaman_ditolak?' . $query_params);
                break;
            case 'pending':
                redirect('dekan/halaman_pending?' . $query_params);
                break;
            default:
                redirect('dekan?' . $query_params);
        }
    }

    public function list_surat_tugas()
    {
        // Semua surat yg pernah diproses Dekan
        $this->db->where_in("status", ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $this->db->order_by("created_at", "DESC");
        $data['surat_list'] = $this->db->get("surat")->result();

        // Statistik - hanya data yang relevan untuk dekan
        $data['approved_count'] = $this->db->where('status', 'disetujui dekan')->count_all_results('surat');
        $data['pending_count'] = $this->db->where('status', 'disetujui sekretariat')->count_all_results('surat');
        $data['rejected_count'] = $this->db->where('status', 'ditolak dekan')->count_all_results('surat');

        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);
        $data['total_count'] = $this->db->count_all_results('surat');

        $this->load->view('dekan/list_surat_tugas', $data);
    }

    public function laporan()
    {
        $data['stats'] = [
            'total_surat'        => $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan'])->count_all_results('surat'),
            'surat_bulan_ini'    => $this->db->like('created_at', date('Y-m'))->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan'])->count_all_results('surat'),
            'surat_diselesaikan' => $this->db->where('status', 'disetujui dekan')->count_all_results('surat'),
            'surat_ditolak'      => $this->db->where('status', 'ditolak dekan')->count_all_results('surat'),
            'surat_menunggu'     => $this->db->where('status', 'disetujui sekretariat')->count_all_results('surat')
        ];

        $this->load->view('dekan/laporan', $data);
    }

    public function detail($id)
    {
        $this->db->where('id', $id);
        $data['surat'] = $this->db->get("surat")->row();

        if (!$data['surat']) {
            show_404();
        }

        $this->load->view('dekan/detail_surat', $data);
    }

    public function get_surat_detail($id)
    {
        $this->db->where('id', $id);
        $surat = $this->db->get("surat")->row();

        echo json_encode($surat ? $surat : ['error' => 'Data tidak ditemukan']);
    }

    // Filter laporan
    public function filter($status = '')
    {
        $this->db->order_by("created_at", "DESC");
        $this->db->where_in('status', ['disetujui sekretariat', 'disetujui dekan', 'ditolak dekan']);

        if ($status == 'menunggu') {
            $this->db->where('status', 'disetujui sekretariat');
        } elseif ($status == 'disetujui') {
            $this->db->where('status', 'disetujui dekan');
        } elseif ($status == 'ditolak') {
            $this->db->where('status', 'ditolak dekan');
        }
        // else: tampilkan semua data yang relevan untuk dekan

        $data['surat_list'] = $this->db->get("surat")->result();
        $data['current_filter'] = $status;

        $this->load->view('dekan/list_surat_tugas', $data);
    }
}
