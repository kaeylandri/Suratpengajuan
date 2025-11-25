<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Dekan</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;background:#f5f7fa;}
    .navbar{background:#FB8C00;color:white;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
    .navbar h2{font-size:20px;}
    .container{max-width:1200px;margin:30px auto;padding:0 20px;}
    .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:20px;}
    .stat-card{background:white;padding:20px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.06);border-left:4px solid #3498db;transition:all 0.3s ease;cursor:pointer}
    .stat-card:hover{transform:translateY(-5px);box-shadow:0 8px 16px rgba(0,0,0,0.12)}
    .stat-card h3{color:#7f8c8d;font-size:13px;margin-bottom:8px;text-transform:uppercase}
    .stat-card .number{font-size:28px;font-weight:700;color:#2c3e50}
    .card{background:white;border-radius:10px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,0.06);margin-bottom:20px}
    .card-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid #eee}
    table{width:100%;border-collapse:collapse}
    thead{background:#f4f6f7}
    th,td{padding:12px;border-bottom:1px solid #ecf0f1;text-align:left;font-size:14px}
    tbody tr:hover{background:#fbfcfd}
    .badge{display:inline-block;padding:6px 10px;border-radius:999px;font-weight:600;font-size:12px}
    .badge-pending{background:#fff3cd;color:#856404}
    .badge-approved{background:#d4edda;color:#155724}
    .badge-rejected{background:#f8d7da;color:#721c24}
    .btn{padding:6px 10px;border-radius:6px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s}
    .btn:hover{transform:scale(1.05)}
    .btn-approve{background:#27ae60;color:#fff}
    .btn-approve:hover{background:#229954}
    .btn-reject{background:#e74c3c;color:#fff}
    .btn-reject:hover{background:#c0392b}
    .btn-detail{background:#3498db;color:#fff}
    .btn-detail:hover{background:#2980b9}
    .empty-state{text-align:center;padding:40px;color:#7f8c8d}
    .chart-container{position:relative;height:450px;padding:20px}
    .filter-container{display:flex;gap:15px;margin-bottom:20px;flex-wrap:wrap}
    .filter-btn{padding:10px 20px;border-radius:8px;border:2px solid #ddd;background:white;cursor:pointer;font-weight:600;transition:all 0.3s;font-size:14px}
    .filter-btn:hover{border-color:#3498db;color:#3498db;transform:translateY(-2px)}
    .filter-btn.active{background:#3498db;color:white;border-color:#3498db}
    .filter-select{padding:10px 15px;border-radius:8px;border:2px solid #ddd;font-weight:600;cursor:pointer;min-width:200px}
    
    /* Modal Styles - IMPROVED */
    .modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.45);align-items:center;justify-content:center}
    .modal.show{display:flex}
    .modal-content{background:white;padding:0;border-radius:15px;max-width:800px;width:95%;max-height:85vh;overflow:hidden;animation:slideIn 0.3s ease;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
    @keyframes slideIn{from{transform:translateY(-50px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-header{background:#FB8C00;color:white;padding:20px 25px;display:flex;justify-content:space-between;align-items:center;border-radius:15px 15px 0 0}
    .modal-header h3{margin:0;font-size:18px;font-weight:600}
    .close-modal{background:none;border:0;color:white;font-size:24px;cursor:pointer;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background 0.2s}
    .close-modal:hover{background:rgba(255,255,255,0.2)}
    
    /* Detail Content Styles - IMPROVED */
    .detail-content{padding:25px;max-height:calc(85vh - 80px);overflow-y:auto}
    .detail-section{margin-bottom:25px;background:#f8f9fa;border-radius:12px;padding:20px;border:1px solid #e9ecef}
    .detail-section:last-child{margin-bottom:0}
    .detail-section-title{font-size:16px;font-weight:700;color:#FB8C00;margin-bottom:15px;padding-bottom:10px;border-bottom:2px solid #FB8C00;display:flex;align-items:center;gap:10px}
    .detail-section-title i{font-size:18px}
    .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:15px}
    .detail-row{display:flex;flex-direction:column;margin-bottom:12px}
    .detail-label{font-weight:600;color:#495057;font-size:13px;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.5px}
    .detail-value{color:#212529;font-size:14px;background:white;padding:10px 15px;border-radius:8px;border:1px solid #e9ecef;min-height:40px;display:flex;align-items:center}
    .detail-value-empty{color:#6c757d;font-style:italic}
    
    /* Dosen list in detail - NEW STYLES */
    .dosen-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .dosen-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 12px;
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 6px;
    }

    .dosen-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #FB8C00;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 12px;
        font-weight: 600;
    }

    .dosen-info {
        flex: 1;
    }

    .dosen-name {
        font-weight: 600;
        color: #212529;
        font-size: 14px;
    }

    .dosen-details {
        font-size: 12px;
        color: #6c757d;
    }
    
    /* File Evidence Styles */
    .file-evidence{margin-top:10px}
    .file-item{display:flex;align-items:center;gap:12px;padding:12px 15px;background:white;border:1px solid #e9ecef;border-radius:8px;transition:all 0.2s}
    .file-item:hover{background:#fffaf5;border-color:#FB8C00}
    .file-icon{width:24px;height:24px;display:flex;align-items:center;justify-content:center;color:#FB8C00;font-size:16px}
    .file-info{flex:1}
    .file-name{font-weight:600;color:#212529;font-size:14px}
    .file-size{font-size:12px;color:#6c757d}
    .download-btn{background:#FB8C00;color:white;border:none;padding:8px 16px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;transition:background 0.2s;display:flex;align-items:center;gap:6px;text-decoration:none}
    .download-btn:hover{background:#e67e00;color:white;text-decoration:none}
    
    /* Action Buttons in Modal */
    .modal-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:20px;padding-top:20px;border-top:1px solid #e9ecef}
    .modal-btn{padding:10px 20px;border-radius:8px;border:none;cursor:pointer;font-weight:600;font-size:14px;transition:all 0.2s;display:flex;align-items:center;gap:8px}
    .modal-btn-approve{background:#27ae60;color:white}
    .modal-btn-approve:hover{background:#229954;transform:translateY(-2px)}
    .modal-btn-reject{background:#e74c3c;color:white}
    .modal-btn-reject:hover{background:#c0392b;transform:translateY(-2px)}
    .modal-btn-close{background:#6c757d;color:white}
    .modal-btn-close:hover{background:#5a6268;transform:translateY(-2px)}
    
    /* Rejection Notes Styles */
    .rejection-notes{background:#fff5f5;border:1px solid #f8d7da;border-radius:8px;padding:15px;margin-top:15px}
    .rejection-notes .detail-label{color:#dc3545}
    .rejection-notes .detail-value{background:#fff5f5;border-color:#f8d7da;color:#721c24}
    
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

    .status-header {
        background: #FB8C00;
        color: white;
        padding: 20px;
        border-radius: 12px 12px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .status-header h3 {
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
    
    /* Nomor Surat Styles */
    .nomor-surat-container {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border: 2px solid #2196f3;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        text-align: center;
    }
    
    .nomor-surat-label {
        font-size: 14px;
        font-weight: 600;
        color: #1565c0;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .nomor-surat-value {
        font-size: 18px;
        font-weight: 700;
        color: #0d47a1;
        font-family: 'Courier New', monospace;
    }
    
    /* Responsive */
    @media (max-width:768px){
        .detail-grid{grid-template-columns:1fr}
        .modal-content{width:95%;margin:10px}
        .detail-content{padding:15px}
        .modal-actions{flex-direction:column}
        .modal-btn{justify-content:center}
        .progress-track {
            flex-direction: column;
            align-items: flex-start;
            gap: 30px;
            padding: 0 10px;
        }
        .progress-track::before {
            display: none;
        }
        .progress-step {
            flex-direction: row;
            align-items: center;
            gap: 15px;
            width: 100%;
        }
        .step-text {
            text-align: left;
            max-width: none;
            flex: 1;
        }
    }
    
    /* Tambahan untuk card yang dapat diklik */
    .stat-card-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }
    
    .stat-card.active {
        border-left-width: 6px;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
</style>
</head>
<body>

<div class="navbar">
    <h2><i class="fa-solid fa-university"></i> Dashboard Dekan</h2>
    <div></div>
</div>

<div class="container">
    <?php if($this->session->flashdata('success')): ?>
    <div class="card" style="border-left:4px solid #27ae60;margin-bottom:18px">
        <div style="color:#155724;font-weight:700"><?php echo $this->session->flashdata('success'); ?></div>
    </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
    <div class="card" style="border-left:4px solid #e74c3c;margin-bottom:18px">
        <div style="color:#721c24;font-weight:700"><?php echo $this->session->flashdata('error'); ?></div>
    </div>
    <?php endif; ?>

    <?php
    // Hitung statistik dari database
    $total_all = isset($total_surat) ? (int)$total_surat : 0;
    $approved_count = isset($approved_count) ? (int)$approved_count : 0;
    $rejected_count = isset($rejected_count) ? (int)$rejected_count : 0;
    $pending_count = isset($pending_count) ? (int)$pending_count : 0;
    
    // Tentukan halaman aktif
    $current_page = 'dashboard'; // Default
    ?>

    <!-- Statistik ringkas -->
    <div class="stats-grid">
        <a href="<?= base_url('dekan/halaman_total') ?>" class="stat-card-link">
            <div class="stat-card" style="border-left-color:#3498db;">
                <h3><i class="fa-solid fa-folder"></i> Total Pengajuan</h3>
                <div class="number" id="totalAll"><?= $total_all ?></div>
            </div>
        </a>
        
        <a href="<?= base_url('dekan/halaman_disetujui') ?>" class="stat-card-link">
            <div class="stat-card" style="border-left-color:#27ae60;">
                <h3><i class="fa-solid fa-check-circle"></i> Disetujui</h3>
                <div class="number" id="approvedCount"><?= $approved_count ?></div>
            </div>
        </a>
        
        <a href="<?= base_url('dekan/halaman_ditolak') ?>" class="stat-card-link">
            <div class="stat-card" style="border-left-color:#e74c3c;">
                <h3><i class="fa-solid fa-times-circle"></i> Ditolak</h3>
                <div class="number" id="rejectedCount"><?= $rejected_count ?></div>
            </div>
        </a>
        
        <a href="<?= base_url('dekan/halaman_pending') ?>" class="stat-card-link">
            <div class="stat-card" style="border-left-color:#f39c12;">
                <h3><i class="fa-solid fa-clock"></i> Menunggu Persetujuan</h3>
                <div class="number" id="pendingCount"><?= $pending_count ?></div>
            </div>
        </a>
    </div>

    <!-- Filter Tahun & Status -->
    <div class="filter-container">
        <div>
            <label style="display:block;margin-bottom:5px;font-weight:600;color:#7f8c8d">
                <i class="fa-solid fa-calendar"></i> Filter Tahun
            </label>
            <select class="filter-select" id="tahunSelect" onchange="updateTahun(this.value)">
                <?php 
                    $currentYear = date('Y');
                    $selectedYear = isset($tahun) ? $tahun : $currentYear;
                    for ($y = $currentYear; $y >= $currentYear - 5; $y--): 
                ?>
                    <option value="<?= $y ?>" <?= ($selectedYear == $y ? 'selected' : '') ?>>
                        Tahun <?= $y ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
    </div>

   <!-- Grafik 3D -->
    <div class="card" style="background: linear-gradient(135deg, #ffffffff 0%, #ffffffff 100%);">
        <div class="card-header" style="border-bottom-color: rgba(0, 0, 0, 0.1)">
            <strong style="color: #000000ff"><i class="fa-solid fa-chart-bar"></i> Grafik Pengajuan — Tahun <?= isset($tahun) ? $tahun : date('Y') ?></strong>
        </div>
        <div class="chart-container">
            <canvas id="grafikSurat"></canvas>
        </div>
    </div>

    <!-- Tabel Pengajuan -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-table"></i> Daftar Pengajuan Surat</h3>
            <div>
                <span id="filterInfo" style="color:#7f8c8d;font-size:13px">Menampilkan: Semua Data</span>
            </div>
        </div>
        
        <div style="overflow-x:auto">
            <table id="suratTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Penyelenggara</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Tanggal Kegiatan</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php if (isset($surat_list) && is_array($surat_list) && count($surat_list) > 0): ?>
                        <?php $i = 1; foreach ($surat_list as $item): 
                            // Normalisasi status
                            $st_raw = isset($item['status']) ? trim($item['status']) : '';
                            $st_l = strtolower($st_raw);
                            
                            // Mapping status ke kategori
                            if ($st_l === 'disetujui sekretariat') {
                                $st_key = 'pending';
                                $badge = '<span class="badge badge-pending">Menunggu Persetujuan</span>';
                            } elseif ($st_l === 'disetujui dekan') {
                                $st_key = 'approved';
                                $badge = '<span class="badge badge-approved">Disetujui Dekan</span>';
                            } elseif (in_array($st_l, ['ditolak kk', 'ditolak sekretariat', 'ditolak dekan'])) {
                                $st_key = 'rejected';
                                $badge = '<span class="badge badge-rejected">'.ucwords($st_raw).'</span>';
                            } else {
                                $st_key = 'pending';
                                $badge = '<span class="badge badge-pending">'.ucwords($st_raw).'</span>';
                            }
                            
                            // Format tanggal
                            $tgl_pengajuan = isset($item['created_at']) && $item['created_at'] ? date('d M Y', strtotime($item['created_at'])) : '-';
                            $tgl_kegiatan = isset($item['created_at']) && $item['created_at'] ? date('d M Y', strtotime($item['created_at'])) : '-';
                        ?>
                        <tr data-status="<?= $st_key ?>">
                            <td><?= $i ?></td>
                            <td><strong><?= htmlspecialchars($item['nama_kegiatan'] ?? '-') ?></strong></td>
                            <td><?= htmlspecialchars($item['penyelenggara'] ?? '-') ?></td>
                            <td><?= $tgl_pengajuan ?></td>
                            <td><?= $tgl_kegiatan ?></td>
                            <td><?= htmlspecialchars($item['jenis_pengajuan'] ?? '-') ?></td>
                            <td><?= $badge ?></td>
                            <td>
                                <div style="display:flex;gap:6px">
                                    <button class="btn btn-sm btn-status" title="Lihat Status" onclick="showStatusModal(<?= $item['id']; ?>)">
                                        <i class="fas fa-tasks"></i>
                                    </button>
                                    <button class="btn btn-detail" onclick="showDetail(<?= (int)$item['id'] ?>)" title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <?php if ($st_l === 'disetujui sekretariat'): ?>
                                        <button class="btn btn-approve" onclick="approveSurat(<?= (int)$item['id'] ?>)" title="Setujui">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                        <button class="btn btn-reject" onclick="showRejectModal(<?= (int)$item['id'] ?>)" title="Tolak">
                                            <i class="fa-solid fa-times"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php $i++; endforeach; ?>
                    <?php else: ?>
                        <tr id="emptyRow">
                            <td colspan="8" style="text-align:center;padding:40px;color:#7f8c8d">
                                <i class="fa-solid fa-inbox" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
                                <strong>Belum ada pengajuan</strong>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Detail Modal - IMPROVED -->
<div id="detailModal" class="modal" onclick="modalClickOutside(event,'detailModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-alt"></i> Detail Pengajuan Surat Tugas</h3>
            <button class="close-modal" onclick="closeModal('detailModal')">&times;</button>
        </div>
        <div class="detail-content" id="detailContent">
            <!-- Content akan diisi oleh JavaScript -->
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="modal" onclick="modalClickOutside(event,'rejectModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-ban"></i> Tolak Pengajuan</h3>
            <button class="close-modal" onclick="closeModal('rejectModal')">&times;</button>
        </div>
        <div class="detail-content">
            <div class="detail-section">
                <div class="detail-section-title">
                    <i class="fa-solid fa-comment-dots"></i> Alasan Penolakan
                </div>
                <div class="detail-row">
                    <div class="detail-label">Keterangan</div>
                    <textarea id="rejectionNotes" rows="5" placeholder="Masukkan alasan penolakan pengajuan ini..." style="width:100%;padding:12px;border:2px solid #ddd;border-radius:8px;font-family:inherit;resize:vertical"></textarea>
                </div>
                <div style="text-align:right;margin-top:15px">
                    <button class="modal-btn modal-btn-reject" onclick="confirmReject()">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Penolakan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Modal -->
<div id="statusModal" class="status-modal">
    <div class="status-content">
        <div class="status-header">
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

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// Data dari controller
const suratList = <?= isset($surat_list) ? json_encode($surat_list) : '[]' ?>;
let currentRejectId = null;

// PERBAIKAN: Fungsi untuk mengambil data detail via AJAX
function getSuratDetail(id) {
    return fetch('<?= site_url("dekan/get_surat_detail/") ?>' + id)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            return data;
        })
        .catch(error => {
            console.error('Error fetching detail:', error);
            throw error;
        });
}

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
        const iconElement = document.getElementById(`step${i}-icon`);
        const textElement = document.getElementById(`step${i}-text`);
        const dateElement = document.getElementById(`step${i}-date`);

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

// Event listener untuk close modal
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

// Update tahun filter
function updateTahun(year) {
    window.location.href = "<?= base_url('dekan?tahun=') ?>" + year;
}

// Filter tabel
function filterTable(status) {
    const rows = document.querySelectorAll('#tableBody tr:not(#emptyRow)');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const filterInfo = document.getElementById('filterInfo');
    
    let visibleCount = 0;
    
    // Update active button
    filterBtns.forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.filter === status) {
            btn.classList.add('active');
        }
    });
    
    // Filter rows
    rows.forEach((row, index) => {
        const rowStatus = row.dataset.status;
        if (status === 'all' || rowStatus === status) {
            row.style.display = '';
            visibleCount++;
            // Update nomor urut
            row.querySelector('td:first-child').textContent = visibleCount;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update info
    const statusText = {
        'all': 'Semua Data',
        'pending': 'Menunggu Persetujuan',
        'approved': 'Disetujui',
        'rejected': 'Ditolak'
    };
    filterInfo.textContent = `Menampilkan: ${statusText[status]} (${visibleCount} data)`;
    
    // Show empty state if no results
    const emptyRow = document.getElementById('emptyRow');
    if (visibleCount === 0 && !emptyRow) {
        const tbody = document.getElementById('tableBody');
        const newRow = tbody.insertRow();
        newRow.id = 'emptyRowFiltered';
        newRow.innerHTML = `<td colspan="8" style="text-align:center;padding:40px;color:#7f8c8d">
            <i class="fa-solid fa-search" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
            <strong>Tidak ada data untuk filter ini</strong>
        </td>`;
    } else if (visibleCount > 0) {
        const filtered = document.getElementById('emptyRowFiltered');
        if (filtered) filtered.remove();
    }
}

// Detail functions - PERBAIKAN UTAMA
function findSuratById(id) {
    return suratList.find(s => Number(s.id) === Number(id));
}

async function showDetail(id) {
    try {
        // Tampilkan loading
        document.getElementById('detailContent').innerHTML = `
            <div style="text-align:center;padding:40px;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#FB8C00"></i>
                <p style="margin-top:10px;color:#7f8c8d">Memuat data...</p>
            </div>
        `;
        document.getElementById('detailModal').classList.add('show');

        // Ambil data detail via AJAX
        const item = await getSuratDetail(id);
        
        if (!item) {
            alert('Data tidak ditemukan');
            closeModal('detailModal');
            return;
        }

        // Fungsi helper untuk mendapatkan value
        const getVal = (k) => {
            return (item[k] !== undefined && item[k] !== null && item[k] !== '' ? item[k] : '-');
        };

        // Format status dengan badge
        const status = getVal('status');
        let statusBadge = '';
        if (status.toLowerCase() === 'disetujui dekan') {
            statusBadge = '<span class="badge badge-approved" style="margin-left:10px">Disetujui</span>';
        } else if (status.toLowerCase().includes('ditolak')) {
            statusBadge = '<span class="badge badge-rejected" style="margin-left:10px">Ditolak</span>';
        } else {
            statusBadge = '<span class="badge badge-pending" style="margin-left:10px">Menunggu</span>';
        }

        // PERBAIKAN UTAMA: Mengambil data dosen dari struktur yang benar
        let dosenData = [];
        
        // Cek berbagai kemungkinan struktur data dosen
        if (item.dosen_data && Array.isArray(item.dosen_data) && item.dosen_data.length > 0) {
            // Struktur 1: dosen_data dari AJAX response
            dosenData = item.dosen_data;
        } else if (item.nama_dosen) {
            // Struktur 2: nama_dosen langsung dari item
            if (Array.isArray(item.nama_dosen)) {
                // Jika nama_dosen adalah array
                dosenData = item.nama_dosen.map((nama, index) => ({
                    nama: nama,
                    nip: (item.nip && item.nip[index]) ? item.nip[index] : '-',
                    jabatan: (item.jabatan && item.jabatan[index]) ? item.jabatan[index] : '-',
                    divisi: (item.divisi && item.divisi[index]) ? item.divisi[index] : '-'
                }));
            } else {
                // Jika nama_dosen adalah string tunggal
                dosenData = [{
                    nama: item.nama_dosen,
                    nip: item.nip || '-',
                    jabatan: item.jabatan || '-',
                    divisi: item.divisi || '-'
                }];
            }
        } else {
            // Fallback: gunakan data dasar dari item
            dosenData = [{
                nama: getVal('nama_dosen'),
                nip: getVal('nip'),
                jabatan: getVal('jabatan'),
                divisi: getVal('divisi')
            }];
        }

        // Debug: Tampilkan data dosen di console
        console.log('Dosen Data:', dosenData);

        const content = `
            <!-- NOMOR SURAT DARI SEKRETARIAT -->
            ${getVal('nomor_surat') && getVal('nomor_surat') !== '-' ? `
            <div class="nomor-surat-container">
                <div class="nomor-surat-label">
                    <i class="fa-solid fa-file-signature"></i> Nomor Surat
                </div>
                <div class="nomor-surat-value">${escapeHtml(getVal('nomor_surat'))}</div>
            </div>
            ` : ''}

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
                        <div class="detail-label">Jenis Pengajuan</div>
                        <div class="detail-value">${escapeHtml(getVal('jenis_pengajuan'))}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Lingkup Penugasan</div>
                        <div class="detail-value">${escapeHtml(getVal('lingkup_penugasan'))}</div>
                    </div>
                </div>
            </div>

            <!-- PERBAIKAN UTAMA: Tampilan Dosen yang Diperbaiki -->
            <div class="detail-section">
                <div class="detail-section-title">
                    <i class="fa-solid fa-user-tie"></i> Dosen Terkait
                    <span style="font-size:12px;color:#6c757d;margin-left:auto">(${dosenData.length} dosen)</span>
                </div>
                <div class="dosen-list">
                    ${dosenData.length > 0 ? dosenData.map((dosen, index) => {
                        const nama = dosen.nama || dosen.nama_dosen || 'Tidak ada nama';
                        const initial = nama && nama !== 'Tidak ada nama' ? nama.charAt(0).toUpperCase() : '?';
                        return `
                        <div class="dosen-item">
                            <div class="dosen-avatar">${initial}</div>
                            <div class="dosen-info">
                                <div class="dosen-name">${escapeHtml(nama)}</div>
                                <div class="dosen-details">
                                    NIP: ${escapeHtml(dosen.nip || '-')} | 
                                    Jabatan: ${escapeHtml(dosen.jabatan || '-')} | 
                                    Divisi: ${escapeHtml(dosen.divisi || '-')}
                                </div>
                            </div>
                        </div>
                        `;
                    }).join('') : `
                    <div style="text-align:center;padding:20px;color:#6c757d">
                        <i class="fa-solid fa-user-slash" style="font-size:24px;margin-bottom:10px"></i>
                        <div>Tidak ada data dosen</div>
                    </div>
                    `}
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
                    <i class="fa-solid fa-exclamation-triangle"></i> Catatan Penolakan
                </div>
                <div class="detail-row">
                    <div class="detail-label">Alasan Penolakan</div>
                    <div class="detail-value">${escapeHtml(getVal('catatan_penolakan'))}</div>
                </div>
            </div>
            ` : ''}

            ${ (item.status && item.status.toLowerCase() === 'disetujui sekretariat') ? `
            <div class="modal-actions">
                <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal')">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
                <button class="modal-btn modal-btn-reject" onclick="showRejectModal(${item.id}); closeModal('detailModal')">
                    <i class="fa-solid fa-times"></i> Tolak
                </button>
                <button class="modal-btn modal-btn-approve" onclick="approveSurat(${item.id}); closeModal('detailModal')">
                    <i class="fa-solid fa-check"></i> Setujui
                </button>
            </div>
            ` : `
            <div class="modal-actions">
                <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal')">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
            </div>
            ` }
        `;
        
        document.getElementById('detailContent').innerHTML = content;
        
    } catch (error) {
        console.error('Error loading detail:', error);
        document.getElementById('detailContent').innerHTML = `
            <div style="text-align:center;padding:40px;color:#e74c3c">
                <i class="fa-solid fa-exclamation-triangle" style="font-size:48px;margin-bottom:10px"></i>
                <p>Gagal memuat data: ${error.message}</p>
                <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal')" style="margin-top:20px">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
            </div>
        `;
    }
}

function approveSurat(id) {
    if (!confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')) return;
    window.location.href = '<?= base_url("dekan/approve/") ?>' + id;
}

function showRejectModal(id) {
    currentRejectId = id;
    document.getElementById('rejectionNotes').value = '';
    document.getElementById('rejectModal').classList.add('show');
}

function confirmReject() {
    const notes = document.getElementById('rejectionNotes').value.trim();
    if (!notes) { 
        alert('Alasan penolakan harus diisi'); 
        return; 
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= base_url("dekan/reject/") ?>' + currentRejectId;

    const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
    const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
    const inpCsrf = document.createElement('input'); 
    inpCsrf.type='hidden'; 
    inpCsrf.name=csrfName; 
    inpCsrf.value=csrfHash; 
    form.appendChild(inpCsrf);
    
    const inpNotes = document.createElement('input'); 
    inpNotes.type='hidden'; 
    inpNotes.name='rejection_notes'; 
    inpNotes.value=notes; 
    form.appendChild(inpNotes);
    
    document.body.appendChild(form);
    form.submit();
}

function closeModal(id) {
    document.getElementById(id).classList.remove('show');
}

function modalClickOutside(evt, id) {
    if (evt.target && evt.target.id === id) closeModal(id);
}

function formatDate(d) {
    if (!d || d === '-') return '-';
    const t = new Date(d);
    if (isNaN(t)) return d;
    return t.toLocaleDateString('id-ID', { day:'2-digit', month: 'short', year:'numeric' });
}

function escapeHtml(unsafe) {
    if (unsafe === null || unsafe === undefined) return '-';
    return String(unsafe)
       .replace(/&/g, "&amp;")
       .replace(/</g, "&lt;")
       .replace(/>/g, "&gt;")
       .replace(/"/g, "&quot;")
       .replace(/'/g, "&#039;");
}

// Grafik 3D
const ctx = document.getElementById('grafikSurat').getContext('2d');
const fusionStyle3DPlugin = {
    id: 'fusionStyle3d',
    beforeDatasetsDraw: (chart) => {
        const ctx = chart.ctx;
        chart.data.datasets.forEach((dataset, datasetIndex) => {
            const meta = chart.getDatasetMeta(datasetIndex);
            if (!meta.hidden) {
                meta.data.forEach((bar) => {
                    const x = bar.x, y = bar.y, base = bar.base, width = bar.width, height = base - y;
                    if (height <= 1) return;
                    const offsetX = 15, offsetY = -15;
                    ctx.save();
                    const rightGradient = ctx.createLinearGradient(x + width/2, y, x + width/2 + offsetX, y + offsetY);
                    let darkColor = datasetIndex === 0 ? 'rgba(0, 177, 253, 0.6)' : (datasetIndex === 1 ? 'rgba(0, 177, 253, 0.6)' : 'rgba(192, 57, 43, 0.6)');
                    rightGradient.addColorStop(0, darkColor);
                    rightGradient.addColorStop(1, 'rgba(0, 0, 0, 0.2)');
                    ctx.fillStyle = rightGradient;
                    ctx.beginPath();
                    ctx.moveTo(x + width/2, y);
                    ctx.lineTo(x + width/2 + offsetX, y + offsetY);
                    ctx.lineTo(x + width/2 + offsetX, base + offsetY);
                    ctx.lineTo(x + width/2, base);
                    ctx.closePath();
                    ctx.fill();
                    const topGradient = ctx.createLinearGradient(x - width/2, y, x + width/2 + offsetX, y + offsetY);
                    let lightColor = datasetIndex === 0 ? 'rgba(162, 217, 206, 0.9)' : (datasetIndex === 1 ? 'rgba(200, 247, 197, 0.9)' : 'rgba(245, 183, 177, 0.9)');
                    topGradient.addColorStop(0, lightColor);
                    topGradient.addColorStop(1, 'rgba(255, 255, 255, 0.2)');
                    ctx.fillStyle = topGradient;
                    ctx.beginPath();
                    ctx.moveTo(x - width/2, y);
                    ctx.lineTo(x + width/2, y);
                    ctx.lineTo(x + width/2 + offsetX, y + offsetY);
                    ctx.lineTo(x - width/2 + offsetX, y + offsetY);
                    ctx.closePath();
                    ctx.fill();
                    ctx.restore();
                });
            }
        });
    }
};

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [
            {label: "Total", data: <?= json_encode(isset($chart_total) ? $chart_total : array_fill(0,12,0)) ?>, backgroundColor: 'rgba(0, 177, 253, 0.6)', borderColor: 'rgba(4, 146, 207, 0.6)', borderWidth: 2, borderRadius: 6},
            {label: "Disetujui", data: <?= json_encode(isset($chart_approved) ? $chart_approved : array_fill(0,12,0)) ?>, backgroundColor: 'rgba(46, 204, 113, 0.85)', borderColor: 'rgba(46, 204, 113, 1)', borderWidth: 2, borderRadius: 6},
            {label: "Ditolak", data: <?= json_encode(isset($chart_rejected) ? $chart_rejected : array_fill(0,12,0)) ?>, backgroundColor: 'rgba(231, 76, 60, 0.85)', borderColor: 'rgba(231, 76, 60, 1)', borderWidth: 2, borderRadius: 6}
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {legend: {position: 'top', labels: {padding: 20, font: {size: 14, weight: '700'}, color: '#000000ff'}}, tooltip: {backgroundColor: 'rgba(44, 62, 80, 0.95)', padding: 16}},
        scales: {x: {grid: {display: false}, ticks: {color: '#000000ff'}}, y: {beginAtZero: true, grid: {color: 'rgba(12, 7, 7, 0.08)'}, ticks: {color: '#95a5a6'}}},
        animation: {duration: 1800, easing: 'easeInOutQuart'}
    },
    plugins: [fusionStyle3DPlugin]
});
</script>
</body>
</html>