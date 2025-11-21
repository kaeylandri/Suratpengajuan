<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengajuan Ditolak - Dashboard Dekan</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;background:#f5f7fa;}
    .navbar{background:#8E44AD;color:white;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
    .navbar h2{font-size:20px;}
    .container{max-width:1200px;margin:30px auto;padding:0 20px;}
    .card{background:white;border-radius:10px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,0.06);margin-bottom:20px}
    .card-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid #eee}
    table{width:100%;border-collapse:collapse}
    thead{background:#f4f6f7}
    th,td{padding:12px;border-bottom:1px solid #ecf0f1;text-align:left;font-size:14px}
    tbody tr:hover{background:#fbfcfd}
    .badge{display:inline-block;padding:6px 10px;border-radius:999px;font-weight:600;font-size:12px}
    .badge-rejected{background:#f8d7da;color:#721c24}
    .btn{padding:6px 10px;border-radius:6px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s}
    .btn:hover{transform:scale(1.05)}
    .btn-detail{background:#3498db;color:#fff}
    .btn-detail:hover{background:#2980b9}
    .pagination-info{margin-top:15px;color:#7f8c8d;font-size:14px;text-align:right}
    .back-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#8E44AD;color:white;text-decoration:none;border-radius:8px;font-weight:600;transition:all 0.3s;margin-bottom:20px}
    .back-btn:hover{background:#7D3C98;transform:translateY(-2px)}
    .status-header{display:flex;align-items:center;gap:15px;margin-bottom:20px;padding:20px;background:white;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.06)}
    .status-icon{width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:24px}
    .status-icon.rejected{background:#f8d7da;color:#e74c3c}
    .status-info h1{margin:0;color:#2c3e50;font-size:28px}
    .status-info p{margin:5px 0 0 0;color:#7f8c8d;font-size:16px}
    
    /* Modal Styles */
    .modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.45);align-items:center;justify-content:center}
    .modal.show{display:flex}
    .modal-content{background:white;padding:0;border-radius:15px;max-width:800px;width:95%;max-height:85vh;overflow:hidden;animation:slideIn 0.3s ease;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
    @keyframes slideIn{from{transform:translateY(-50px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-header{background:#8E44AD;color:white;padding:20px 25px;display:flex;justify-content:space-between;align-items:center;border-radius:15px 15px 0 0}
    .modal-header h3{margin:0;font-size:18px;font-weight:600}
    .close-modal{background:none;border:0;color:white;font-size:24px;cursor:pointer;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background 0.2s}
    .close-modal:hover{background:rgba(255,255,255,0.2)}
    
    /* Detail Content Styles */
    .detail-content{padding:25px;max-height:calc(85vh - 80px);overflow-y:auto}
    .detail-section{margin-bottom:25px;background:#f8f9fa;border-radius:12px;padding:20px;border:1px solid #e9ecef}
    .detail-section:last-child{margin-bottom:0}
    .detail-section-title{font-size:16px;font-weight:700;color:#8E44AD;margin-bottom:15px;padding-bottom:10px;border-bottom:2px solid #8E44AD;display:flex;align-items:center;gap:10px}
    .detail-section-title i{font-size:18px}
    .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:15px}
    .detail-row{display:flex;flex-direction:column;margin-bottom:12px}
    .detail-label{font-weight:600;color:#495057;font-size:13px;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.5px}
    .detail-value{color:#212529;font-size:14px;background:white;padding:10px 15px;border-radius:8px;border:1px solid #e9ecef;min-height:40px;display:flex;align-items:center}
    .detail-value-empty{color:#6c757d;font-style:italic}
    
    /* File Evidence Styles */
    .file-evidence{margin-top:10px}
    .file-item{display:flex;align-items:center;gap:12px;padding:12px 15px;background:white;border:1px solid #e9ecef;border-radius:8px;transition:all 0.2s}
    .file-item:hover{background:#f8f0ff;border-color:#8E44AD}
    .file-icon{width:24px;height:24px;display:flex;align-items:center;justify-content:center;color:#8E44AD;font-size:16px}
    .file-info{flex:1}
    .file-name{font-weight:600;color:#212529;font-size:14px}
    .file-size{font-size:12px;color:#6c757d}
    .download-btn{background:#8E44AD;color:white;border:none;padding:8px 16px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;transition:background 0.2s;display:flex;align-items:center;gap:6px;text-decoration:none}
    .download-btn:hover{background:#7D3C98;color:white;text-decoration:none}
    
    /* Action Buttons in Modal */
    .modal-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:20px;padding-top:20px;border-top:1px solid #e9ecef}
    .modal-btn{padding:10px 20px;border-radius:8px;border:none;cursor:pointer;font-weight:600;font-size:14px;transition:all 0.2s;display:flex;align-items:center;gap:8px}
    .modal-btn-close{background:#6c757d;color:white}
    .modal-btn-close:hover{background:#5a6268;transform:translateY(-2px)}
    
    /* Rejection Notes Styles */
    .rejection-notes{background:#fff5f5;border:1px solid #f8d7da;border-radius:8px;padding:20px;margin-top:15px}
    .rejection-notes .detail-label{color:#dc3545;font-weight:700}
    .rejection-notes .detail-value{background:#fff5f5;border-color:#f8d7da;color:#721c24;font-size:14px;line-height:1.5;min-height:auto;padding:12px}
    
    /* Responsive */
    @media (max-width:768px){
        .detail-grid{grid-template-columns:1fr}
        .modal-content{width:95%;margin:10px}
        .detail-content{padding:15px}
        .modal-actions{flex-direction:column}
        .modal-btn{justify-content:center}
    }
    
    /* Search Box Styles */
    .search-container{margin-bottom:20px}
    .search-label{display:block;margin-bottom:8px;color:#6c757d;font-size:14px;font-weight:500}
    .search-box{display:flex;gap:10px;align-items:center;width:100%}
    .search-input-wrapper{position:relative;flex:1}
    .search-input{width:100%;padding:12px 45px 12px 15px;border:1px solid #e9ecef;border-radius:8px;font-size:14px;transition:all 0.3s;background:white;color:#495057}
    .search-input:focus{outline:none;border-color:#8E44AD;box-shadow:0 0 0 2px rgba(142,68,173,0.1)}
    .search-input::placeholder{color:#6c757d}
    .search-icon{position:absolute;right:15px;top:50%;transform:translateY(-50%);color:#6c757d;font-size:16px}
    .btn-cari{padding:12px 24px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#6c757d;color:#fff;white-space:nowrap}
    .btn-cari:hover{background:#5a6268;transform:translateY(-1px)}

    /* Progress Bar Styles */
    .progress-track {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin: 40px 0;
    }

    .progress-track::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 0;
        width: 100%;
        height: 4px;
        background: #e0e0e0;
        z-index: 1;
    }

    .progress-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    .step-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        margin-bottom: 10px;
        border: 3px solid #e0e0e0;
        background: white;
    }

    .step-text {
        font-size: 12px;
        text-align: center;
        max-width: 100px;
        color: #666;
    }

    .step-date {
        font-size: 11px;
        color: #999;
        margin-top: 5px;
        display: none !important;
    }

    /* Progress Line */
    .progress-line {
        position: absolute;
        top: 20px;
        left: 0;
        height: 4px;
        background: #4caf50;
        z-index: 2;
        transition: width 0.5s ease;
    }

    /* Status Colors */
    .progress-step.completed .step-icon {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
    }

    .progress-step.status-completed i {
        color: white !important;
    }

    .progress-step.in-progress .step-icon {
        background: #ffc107;
        border-color: #ffc107;
        color: white;
    }

    .progress-step.rejected .step-icon {
        background: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    .progress-step.pending .step-icon {
        background: #e0e0e0;
        border-color: #e0e0e0;
        color: #666;
    }

    .progress-estimasi {
        width: 100%;
        text-align: center;
        margin-top: 5px;
        font-size: 12px;
        color: #777;
    }

    .rejection-reason {
        background: #fff5f5;
        border: 1px solid #f8cccc;
        padding: 15px;
        border-radius: 10px;
        margin-top: 15px;
    }

    .rejection-reason h6 {
        color: #e63946;
        font-weight: 700;
        margin-bottom: 8px;
    }

    /* Tombol status hijau */
    .btn-status {
        background: #66bb6a !important;
        color: white !important;
        border: none !important;
        border-radius: 5px !important;
        padding: 6px 10px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        transition: 0.2s ease-in-out;
        font-size: 14px;
        height: 32px;
    }

    .btn-status i {
        font-size: 14px;
    }

    .btn-status:hover {
        background: #4caf50 !important;
        transform: scale(1.05);
    }

    /* Status Modal Styles */
    .status-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .status-modal.show {
        display: flex;
    }

    .status-content {
        background: white;
        border-radius: 12px;
        width: 90%;
        max-width: 600px;
        padding: 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .status-header-modal {
        background: #FB8C00;
        color: white;
        padding: 20px;
        border-radius: 12px 12px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .status-header-modal h3 {
        margin: 0;
        font-size: 18px;
    }

    .close-status {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
    }

    .status-body {
        padding: 30px;
    }
</style>
</head>
<body>

<div class="navbar">
    <h2><i class="fa-solid fa-user-tie"></i> Dashboard Dekan</h2>
    <div></div>
</div>

<div class="container">
    <!-- Tombol Kembali -->
    <a href="<?= base_url('dekan') ?>" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
    </a>

    <!-- Header Status -->
    <div class="status-header">
        <div class="status-icon rejected">
            <i class="fa-solid fa-times"></i>
        </div>
        <div class="status-info">
            <h1>DITOLAK</h1>
            <p><?= isset($total_surat) ? $total_surat : '2' ?> Pengajuan</p>
        </div>
    </div>

    <?php if($this->session->flashdata('success')): ?>
    <div class="card" style="border-left:4px solid #27ae60;margin-bottom:18px">
        <div style="color:#155724;font-weight:700"><?php echo $this->session->flashdata('success'); ?></div>
    </div>
    <?php endif; ?>

    <!-- Tabel Pengajuan Ditolak -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-table"></i> Daftar Pengajuan Ditolak</h3>
            <div>
                <span id="filterInfo" style="color:#7f8c8d;font-size:13px">
                    Menampilkan: Semua Data (<?= isset($surat_list) ? count($surat_list) : '2' ?>)
                </span>
            </div>
        </div>
        
        <!-- Search Box -->
        <div class="search-container">
            <label class="search-label">Cari berdasarkan nama kegiatan, penyelenggara, atau jenis pengajuan...</label>
            <div class="search-box">
                <div class="search-input-wrapper">
                    <input 
                        type="text" 
                        id="searchInput"
                        class="search-input"
                        placeholder="Ketik untuk mencari..."
                        value="<?= $this->input->get('search') ?>"
                    >
                    <div class="search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
                <button type="button" class="btn-cari" onclick="handleSearch()">
                    <i class="fa-solid fa-search"></i> Cari
                </button>
                
                <?php if($this->input->get('search')): ?>
                <a href="<?= base_url('dekan/ditolak') ?>" class="btn-cari" style="background:#95a5a6">
                    <i class="fa-solid fa-refresh"></i> Reset
                </a>
                <?php endif; ?>
            </div>
        </div>
        
        <div style="overflow-x:auto">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Penyelenggara</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Tanggal Kegiatan</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Ditolak Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php 
                    // Data statis contoh
                    $data_pengajuan = [
                        [
                            'id' => 1,
                            'nama_kegiatan' => 'Seminar Teknologi',
                            'nama_dosen' => 'Dr. Ahmad Wijaya, M.Kom.',
                            'nip' => '1987654321',
                            'penyelenggara' => 'Fakultas Teknik',
                            'created_at' => '2025-11-20',
                            'created_at' => '2025-11-20',
                            'tanggal_kegiatan' => '2025-12-15',
                            'akhir_kegiatan' => '2025-12-15',
                            'jenis_pengajuan' => 'Kelompok',
                            'lingkup_penugasan' => 'Nasional',
                            'eviden' => 'proposal_seminar.pdf',
                            'catatan_penolakan' => 'Anggaran yang diajukan melebihi batas yang ditentukan untuk kegiatan seminar internal. Silakan ajukan ulang dengan anggaran yang lebih realistis.',
                            'status' => 'ditolak dekan',
                            'ditolak_oleh' => 'Dekan'
                        ],
                        [
                            'id' => 2,
                            'nama_kegiatan' => 'Workshop Programming',
                            'nama_dosen' => 'Prof. Sari Indah, M.T.',
                            'nip' => '1976543210',
                            'penyelenggara' => '-',
                            'created_at' => '2025-11-18',
                            'created_at' => '2025-11-18',
                            'tanggal_kegiatan' => '2025-12-10',
                            'akhir_kegiatan' => '2025-12-12',
                            'jenis_pengajuan' => 'Perorangan',
                            'lingkup_penugasan' => 'Fakultas',
                            'eviden' => 'workshop_proposal.pdf',
                            'catatan_penolakan' => 'Jadwal kegiatan bentrok dengan ujian akhir semester. Silakan pilih tanggal lain di luar periode ujian.',
                            'status' => 'ditolak dekan',
                            'ditolak_oleh' => 'Dekan'
                        ]
                    ];
                    
                    // Gunakan data dari controller jika ada, jika tidak gunakan data statis
                    $data_to_display = isset($surat_list) && is_array($surat_list) && !empty($surat_list) ? $surat_list : $data_pengajuan;
                    
                    if(is_array($data_to_display) && !empty($data_to_display)): 
                        $no = 1; 
                        foreach($data_to_display as $s): 
                            // Pastikan $s adalah array, bukan objek
                            $s = (array)$s;
                            
                            $tgl_pengajuan = isset($s['created_at']) && $s['created_at'] ? date('d M Y', strtotime($s['created_at'])) : '-';
                            $tgl_pengajuan = isset($s['created_at']) && $s['created_at'] ? date('d M Y', strtotime($s['created_at'])) : '-';
                            
                            // Format tanggal kegiatan - handle range tanggal
                            $tgl_kegiatan = '-';
                            if (isset($s['tanggal_kegiatan']) && $s['tanggal_kegiatan']) {
                                $tgl_kegiatan = date('d M Y', strtotime($s['tanggal_kegiatan']));
                                if (isset($s['akhir_kegiatan']) && $s['akhir_kegiatan'] && $s['akhir_kegiatan'] !== '-' && $s['akhir_kegiatan'] !== $s['tanggal_kegiatan']) {
                                    $tgl_kegiatan .= ' - ' . date('d M Y', strtotime($s['akhir_kegiatan']));
                                }
                            }
                            
                            // Tentukan siapa yang menolak
                            $ditolak_oleh = isset($s['ditolak_oleh']) ? $s['ditolak_oleh'] : 'Dekan';
                    ?>
                    <tr data-status="rejected">
                        <td><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($s['nama_kegiatan'] ?? '-') ?></strong></td>
                        <td><?= htmlspecialchars($s['penyelenggara'] ?? '-') ?></td>
                        <td><?= $tgl_pengajuan ?></td>
                        <td><?= $tgl_kegiatan ?></td>
                        <td><?= htmlspecialchars($s['jenis_pengajuan'] ?? '-') ?></td>
                        <td>
                            <span class="badge badge-rejected">
                                Ditolak
                            </span>
                        </td>
                        <td>
                            <span style="font-size:12px;color:#6c757d;">
                                <?= $ditolak_oleh ?>
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <button class="btn btn-detail" onclick="showDetail(<?= $s['id'] ?? 0 ?>)" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button class="btn btn-status" title="Lihat Status" onclick="showStatusModal(<?= $s['id'] ?? 0 ?>)">
                                    <i class="fas fa-tasks"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="9" style="text-align:center;padding:40px;color:#7f8c8d">
                            <i class="fa-solid fa-times-circle" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
                            <strong>
                                <?php if(!isset($surat_list)): ?>
                                    Variabel $surat_list tidak terdefinisi
                                <?php elseif(empty($surat_list)): ?>
                                    <?php if($this->input->get('search')): ?>
                                        Tidak ada pengajuan yang sesuai dengan pencarian "<?= htmlspecialchars($this->input->get('search')) ?>"
                                    <?php else: ?>
                                        Tidak ada pengajuan yang ditolak
                                    <?php endif; ?>
                                <?php else: ?>
                                    Data tidak valid
                                <?php endif; ?>
                            </strong>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-info">
            Menampilkan: Pengajuan Ditolak 
            <?php if($this->input->get('search')): ?>
                (<?= isset($surat_list) ? count($surat_list) : '2' ?> data dari <?= isset($total_surat) ? $total_surat : '2' ?> total)
            <?php else: ?>
                (<?= isset($surat_list) ? count($surat_list) : '2' ?> data)
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="modal" onclick="modalClickOutside(event,'detailModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-alt"></i> Detail Pengajuan Ditolak</h3>
            <button class="close-modal" onclick="closeModal('detailModal')">&times;</button>
        </div>
        <div class="detail-content" id="detailContent">
            <!-- Content akan diisi oleh JavaScript -->
        </div>
    </div>
</div>

<!-- Status Modal -->
<div id="statusModal" class="status-modal">
    <div class="status-content">
        <div class="status-header-modal">
            <h3>Status Pengajuan Surat Tugas</h3>
            <button class="close-status">&times;</button>
        </div>
        <div class="status-body">
            <div class="progress-track">
                <div class="progress-line" id="progressLine"></div>

                <!-- Step 1: Mengirim -->
                <div class="progress-step status-completed" id="step1">
                    <div class="step-icon">
                        <i class="fas fa-check" id="step1-icon"></i>
                    </div>
                    <div class="step-text" id="step1-text">Mengirim</div>
                    <div class="step-date" id="step1-date">-</div>
                </div>
                <div class="progress-estimasi">
                    <span id="est1">-</span>
                </div>

                <!-- Step 2: Persetujuan KK -->
                <div class="progress-step status-in-progress" id="step2">
                    <div class="step-icon">
                        <i class="fas fa-clock" id="step2-icon"></i>
                    </div>
                    <div class="step-text" id="step2-text">Persetujuan KK</div>
                    <div class="step-date" id="step2-date">-</div>
                </div>
                <div class="progress-estimasi">
                    <span id="est2">-</span>
                </div>

                <!-- Step 3: Persetujuan Sekretariat -->
                <div class="progress-step status-pending" id="step3">
                    <div class="step-icon">
                        <i class="fas fa-clock" id="step3-icon"></i>
                    </div>
                    <div class="step-text" id="step3-text">Persetujuan Sekretariat</div>
                    <div class="step-date" id="step3-date">-</div>
                </div>
                <div class="progress-estimasi">
                    <span id="est3">-</span>
                </div>

                <!-- Step 4: Persetujuan Dekan -->
                <div class="progress-step status-pending" id="step4">
                    <div class="step-icon">
                        <i class="fas fa-clock" id="step4-icon"></i>
                    </div>
                    <div class="step-text" id="step4-text">Persetujuan Dekan</div>
                    <div class="step-date" id="step4-date">-</div>
                </div>
            </div>

            <div class="status-info mt-4">
                <h5>Informasi Status:</h5>
                <p id="status-description">Memuat informasi status...</p>
                <div id="rejection-reason" class="rejection-reason" style="display: none;">
                    <h6>Alasan Penolakan:</h6>
                    <p id="rejection-text"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Data untuk modal detail - harus sama dengan data yang ditampilkan di tabel
const suratList = <?= json_encode($data_to_display) ?>;

let currentSearchTerm = '';

function showDetail(id) {
    console.log('Mencari data dengan ID:', id);
    console.log('Data yang tersedia:', suratList);
    
    const item = suratList.find(s => {
        const itemId = s.id || s.ID || s.Id;
        console.log('Item ID:', itemId, 'Tipe:', typeof itemId);
        return Number(itemId) === Number(id);
    });
    
    if (!item) { 
        alert('Data tidak ditemukan. ID: ' + id); 
        return; 
    }
    
    console.log('Data ditemukan:', item);
    
    // Helper functions
    const getVal = (k) => (item[k] !== undefined && item[k] !== null ? item[k] : '-');
    const formatDate = (dateString) => {
        if (!dateString || dateString === '-') return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', { 
            day: '2-digit', 
            month: 'short', 
            year: 'numeric' 
        });
    };
    const escapeHtml = (unsafe) => {
        if (unsafe === null || unsafe === undefined) return '-';
        return String(unsafe)
           .replace(/&/g, "&amp;")
           .replace(/</g, "&lt;")
           .replace(/>/g, "&gt;")
           .replace(/"/g, "&quot;")
           .replace(/'/g, "&#039;");
    };
    
    // Format status dengan badge
    const status = getVal('status');
    let statusBadge = '<span class="badge badge-rejected" style="margin-left:10px">Ditolak</span>';

    const content = `
        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fa-solid fa-info-circle"></i> Informasi Utama
            </div>
            <div class="detail-grid">
                <div class="detail-row">
                    <div class="detail-label">Nama Kegiatan</div>
                    <div class="detail-value">${escapeHtml(getVal('nama_kegiatan'))}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Status Pengajuan</div>
                    <div class="detail-value" style="display:flex;align-items:center">
                        ${escapeHtml(status)} ${statusBadge}
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Ditolak Oleh</div>
                    <div class="detail-value">${escapeHtml(getVal('ditolak_oleh') || 'Dekan')}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Jenis Pengajuan</div>
                    <div class="detail-value">${escapeHtml(getVal('jenis_pengajuan'))}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Lingkup Penugasan</div>
                    <div class="detail-value">${escapeHtml(getVal('lingkup_penugasan'))}</div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fa-solid fa-user-tie"></i> Informasi Dosen
            </div>
            <div class="detail-grid">
                <div class="detail-row">
                    <div class="detail-label">Nama Dosen</div>
                    <div class="detail-value">${escapeHtml(getVal('nama_dosen'))}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">NIP</div>
                    <div class="detail-value">${escapeHtml(getVal('nip'))}</div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fa-solid fa-calendar-alt"></i> Informasi Waktu & Tempat
            </div>
            <div class="detail-grid">
                <div class="detail-row">
                    <div class="detail-label">Tanggal Pengajuan</div>
                    <div class="detail-value">${formatDate(getVal('created_at'))}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Tanggal Kegiatan</div>
                    <div class="detail-value">${formatDate(getVal('tanggal_kegiatan'))}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Penyelenggara</div>
                    <div class="detail-value">${escapeHtml(getVal('penyelenggara'))}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Tempat Kegiatan</div>
                    <div class="detail-value">${escapeHtml(getVal('tempat_kegiatan'))}</div>
                </div>
            </div>
        </div>

        ${getVal('eviden') && getVal('eviden') !== '-' ? `
        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fa-solid fa-paperclip"></i> File Evidence
            </div>
            <div class="file-evidence">
                <div class="file-item">
                    <div class="file-icon">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <div class="file-info">
                        <div class="file-name">${escapeHtml(getVal('eviden'))}</div>
                    </div>
                    <a href="<?= base_url('uploads/') ?>${escapeHtml(getVal('eviden'))}" target="_blank" class="download-btn">
                        <i class="fa-solid fa-download"></i> Download
                    </a>
                </div>
            </div>
        </div>
        ` : ''}

        ${getVal('catatan_penolakan') && getVal('catatan_penolakan') !== '-' ? `
        <div class="detail-section rejection-notes">
            <div class="detail-section-title">
                <i class="fa-solid fa-exclamation-triangle"></i> Alasan Penolakan
            </div>
            <div class="detail-row">
                <div class="detail-label">Catatan Penolakan</div>
                <div class="detail-value">${escapeHtml(getVal('catatan_penolakan'))}</div>
            </div>
        </div>
        ` : ''}

        <div class="modal-actions">
            <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal')">
                <i class="fa-solid fa-times"></i> Tutup
            </button>
        </div>
    `;
    
    document.getElementById('detailContent').innerHTML = content;
    document.getElementById('detailModal').classList.add('show');
}

function closeModal(id) {
    document.getElementById(id).classList.remove('show');
}

function modalClickOutside(evt, id) {
    if (evt.target && evt.target.id === id) closeModal(id);
}

// Search functionality
function handleSearch() {
    const searchInput = document.getElementById('searchInput');
    currentSearchTerm = searchInput.value.toLowerCase();
    applyFilters();
}

function applyFilters() {
    const rows = document.querySelectorAll('#tableBody tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        
        let matchesSearch = true;
        
        // Filter by search
        if (currentSearchTerm && !text.includes(currentSearchTerm)) {
            matchesSearch = false;
        }
        
        if (matchesSearch) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update pagination info
    updatePaginationInfo(visibleCount);
}

function updatePaginationInfo(visibleCount) {
    const paginationInfo = document.querySelector('.pagination-info');
    const filterInfo = document.getElementById('filterInfo');
    
    if (paginationInfo && filterInfo) {
        if (currentSearchTerm) {
            paginationInfo.textContent = `Menampilkan: Pengajuan Ditolak - ${visibleCount} data (difilter)`;
            filterInfo.textContent = `Menampilkan: Pengajuan Ditolak - ${visibleCount} data (difilter)`;
        } else {
            paginationInfo.textContent = `Menampilkan: Pengajuan Ditolak (${visibleCount} data)`;
            filterInfo.textContent = `Menampilkan: Pengajuan Ditolak (${visibleCount})`;
        }
    }
}

// Enter key support for search
document.getElementById('searchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        handleSearch();
    }
});

// Auto reset when input is cleared
document.getElementById('searchInput').addEventListener('input', function(e) {
    if (e.target.value === '') {
        currentSearchTerm = '';
        applyFilters();
    }
});

// Initialize filters
document.addEventListener('DOMContentLoaded', function() {
    applyFilters();
});

// ============================================
// STATUS MODAL FUNCTIONS
// ============================================

// Tampilkan modal dan load data
function showStatusModal(suratId) {
    const modal = document.getElementById('statusModal');
    modal.style.display = 'flex';
    resetAllStatus();
    loadStatusData(suratId);
}

// Reset seluruh tampilan sebelum load data baru
function resetAllStatus() {
    for (let i = 1; i <= 4; i++) {
        const step = document.getElementById(`step${i}`);
        const icon = document.getElementById(`step${i}-icon`);
        const text = document.getElementById(`step${i}-text`);
        const date = document.getElementById(`step${i}-date`);
        
        step.className = 'progress-step pending';
        icon.className = 'fas fa-clock';

        const defaultTexts = [
            'Mengirim',
            'Persetujuan KK',
            'Persetujuan Sekretariat',
            'Persetujuan Dekan'
        ];
        text.textContent = defaultTexts[i-1];
        date.textContent = '-';
    }

    document.getElementById('progressLine').style.width = '0%';
    const desc = document.getElementById("status-description");
    desc.textContent = "Memuat informasi status...";
    desc.style.color = "black";
}

// Load status dari server (AJAX)
function loadStatusData(suratId) {
    fetch('<?= site_url("surat/get_status/") ?>' + suratId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateStatusDisplay(data.data);
                updateEstimasiWaktu(data.data);
            } else {
                alert('Gagal memuat status: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error loading status data:', error);
            alert('Terjadi kesalahan saat memuat status');
        });
}

// Update tampilan status
function updateStatusDisplay(statusData) {
    const steps = statusData.steps;

    steps.forEach((step, index) => {
        const stepNumber = index + 1;
        const stepElement = document.getElementById(`step${stepNumber}`);
        const iconElement = document.getElementById(`step${stepNumber}-icon`);
        const textElement = document.getElementById(`step${stepNumber}-text`);
        const dateElement = document.getElementById(`step${stepNumber}-date`);

        stepElement.className = 'progress-step';

        // STATUS WARNA
        switch (step.status) {
            case 'completed':
                stepElement.classList.add('completed');
                iconElement.className = 'fas fa-check';
                break;

            case 'rejected':
                stepElement.classList.add('rejected');
                iconElement.className = 'fas fa-times';
                break;

            case 'in-progress':
                stepElement.classList.add('in-progress');
                iconElement.className = 'fas fa-spinner fa-spin';
                break;

            default:
                stepElement.classList.add('pending');
                iconElement.className = 'fas fa-clock';
        }

        textElement.textContent = step.step_name;
        dateElement.textContent = step.date;
    });

    // Update progress bar panjang
    document.getElementById('progressLine').style.width = 
        (statusData.progress_percentage || 0) + '%';

    // Update informasi status
    const desc = document.getElementById("status-description");
    const finalStatus = statusData.current_status.toLowerCase();

    if (finalStatus === "disetujui dekan") {
        desc.textContent = "Pengajuan ini sudah disetujui.";
        desc.style.color = "green";
    }
    else if (finalStatus.includes("ditolak")) {
        desc.textContent = "Pengajuan ini tidak disetujui.";
        desc.style.color = "red";
    }
    else {
        desc.textContent = "Pengajuan ini masih dalam proses persetujuan.";
        desc.style.color = "black";
    }
    
    // Tampilkan alasan penolakan
    const rejectionBox = document.getElementById("rejection-reason");
    const rejectionText = document.getElementById("rejection-text");

    if (finalStatus.includes("ditolak")) {
        rejectionBox.style.display = "block";
        rejectionText.textContent = statusData.catatan_penolakan || "Tidak ada catatan penolakan.";
    } else {
        rejectionBox.style.display = "none";
    }
}

// Update estimasi waktu
function updateEstimasiWaktu(statusData) {
    const d = statusData.durasi;
    document.getElementById("est1").textContent = d.durasi_1 || "-";
    document.getElementById("est2").textContent = d.durasi_2 || "-";
    document.getElementById("est3").textContent = d.durasi_3 || "-";
}

// Event listener untuk close modal status
document.addEventListener('DOMContentLoaded', function() {
    const closeBtn = document.querySelector('.close-status');
    const modal = document.getElementById('statusModal');
    
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }

    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});
</script>
</body>
</html>