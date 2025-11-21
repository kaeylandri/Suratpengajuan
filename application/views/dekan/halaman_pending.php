<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Total Pengajuan - Dashboard Dekan</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;background:#f5f7fa;}
    .navbar{background:#FB8C00;color:white;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
    .navbar h2{font-size:20px;}
    .container{max-width:1200px;margin:30px auto;padding:0 20px;}
    
    /* Back Button */
    .back-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#FB8C00;color:white;text-decoration:none;border-radius:8px;font-weight:600;transition:all 0.3s;margin-bottom:20px}
    .back-btn:hover{background:#e67e22;transform:translateY(-2px)}
    
    /* Card Styles */
    .card{background:white;border-radius:10px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,0.06);margin-bottom:20px}
    .card-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid #eee}
    
    /* Search and Filter */
    .search-filter-container{display:flex;align-items:center;gap:15px;margin-bottom:20px;flex-wrap:wrap;background:#f8f9fa;padding:15px;border-radius:10px;border:1px solid #e9ecef}
    .search-box{position:relative;flex:1;min-width:300px}
    .search-input{width:100%;padding:12px 45px 12px 15px;border:1px solid #ddd;border-radius:8px;font-size:14px;transition:all 0.3s;background:white}
    .search-input:focus{outline:none;border-color:#FB8C00;box-shadow:0 0 0 2px rgba(251,140,0,0.1)}
    .search-icon{position:absolute;right:15px;top:50%;transform:translateY(-50%);color:#6c757d}
    .filter-select{padding:12px 15px;border:1px solid #ddd;border-radius:8px;font-size:14px;background:white;color:#495057;min-width:180px;cursor:pointer;transition:all 0.3s}
    .filter-select:focus{outline:none;border-color:#FB8C00;box-shadow:0 0 0 2px rgba(251,140,0,0.1)}
    .btn-primary{padding:10px 20px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#FB8C00;color:#fff}
    .btn-primary:hover{background:#e67e22;transform:translateY(-2px)}
    .btn-secondary{padding:10px 20px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#95a5a6;color:#fff}
    .btn-secondary:hover{background:#7f8c8d}
    
    /* Table Styles */
    table{width:100%;border-collapse:collapse}
    thead{background:#f4f6f7}
    th,td{padding:12px;border-bottom:1px solid #ecf0f1;text-align:left;font-size:14px}
    tbody tr:hover{background:#fbfcfd}
    
    /* Badge Styles */
    .badge{display:inline-block;padding:6px 10px;border-radius:999px;font-weight:600;font-size:12px}
    .badge-pending{background:#fff3cd;color:#856404}
    .badge-approved{background:#d4edda;color:#155724}
    .badge-rejected{background:#f8d7da;color:#721c24}
    
    /* Button Styles */
    .btn{padding:6px 10px;border-radius:6px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s}
    .btn:hover{transform:scale(1.05)}
    .btn-approve{background:#27ae60;color:#fff}
    .btn-approve:hover{background:#229954}
    .btn-reject{background:#e74c3c;color:#fff}
    .btn-reject:hover{background:#c0392b}
    .btn-detail{background:#3498db;color:#fff}
    .btn-detail:hover{background:#2980b9}
    
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
    
    /* Pagination Info */
    .pagination-info{margin-top:15px;color:#7f8c8d;font-size:14px;text-align:right}
    
    /* Modal Styles */
    .modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.45);align-items:center;justify-content:center}
    .modal.show{display:flex}
    .modal-content{background:white;padding:0;border-radius:10px;max-width:700px;width:95%;max-height:85vh;overflow:auto;animation:slideIn 0.3s ease}
    @keyframes slideIn{from{transform:translateY(-50px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-header{display:flex;justify-content:space-between;align-items:center;padding:20px;border-bottom:1px solid #eee;background:#f8f9fa}
    .modal-header h3{margin:0;color:#2c3e50;font-size:20px}
    
    /* Detail Modal Content */
    .detail-section{margin-bottom:25px}
    .section-title{font-size:18px;font-weight:700;color:#2c3e50;margin-bottom:15px;padding-bottom:8px;border-bottom:2px solid #FB8C00}
    .info-grid{display:grid;gap:15px}
    .info-item{display:flex;flex-direction:column;gap:5px}
    .info-label{font-weight:600;color:#7f8c8d;font-size:14px}
    .info-value{color:#2c3e50;font-size:15px;padding:8px 0}
    .status-badge{margin-left:10px;font-size:12px !important;padding:4px 8px !important}
    
    /* Status Badge Colors */
    .status-ditolak{background:#e74c3c;color:white}
    .status-disetujui{background:#27ae60;color:white}
    .status-menunggu{background:#f39c12;color:white}
    
    .divider{height:1px;background:#ecf0f1;margin:20px 0}
    .modal-body{padding:25px}

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
</style>
</head>
<body>

<div class="navbar">
    <h2><i class="fa-solid fa-university"></i> Dashboard Dekan</h2>
    <div></div>
</div>

<div class="container">
    <!-- Tombol Kembali -->
    <a href="<?= base_url('dekan') ?>" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
    </a>

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

    <!-- Tabel Total Pengajuan -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-table"></i> Total Pengajuan Surat - Dekan</h3>
            <div>
                <span style="color:#7f8c8d;font-size:13px">
                    <?php
                    $filter_info = "Semua Data";
                    if($this->input->get('status') == 'pending') $filter_info = "Menunggu";
                    if($this->input->get('status') == 'approved') $filter_info = "Disetujui";
                    if($this->input->get('status') == 'rejected') $filter_info = "Ditolak";
                    echo "Menampilkan: " . $filter_info . " (" . (isset($total_surat) ? $total_surat : '0') . " data)";
                    ?>
                </span>
            </div>
        </div>
        
        <!-- Search + Filter -->
        <form method="get" action="<?= base_url('dekan/halaman_total') ?>">
            <div class="search-filter-container">
                <div class="search-box">
                    <input 
                        type="text" 
                        name="search" 
                        class="search-input"
                        placeholder="Cari nama kegiatan atau penyelenggara..."
                        value="<?= htmlspecialchars($this->input->get('search') ?? '') ?>"
                    >
                    <div class="search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
                
                <select name="status" class="filter-select">
                    <option value="">Semua Status</option>
                    <option value="pending" <?= ($this->input->get('status') == 'pending') ? 'selected' : '' ?>>Menunggu</option>
                    <option value="approved" <?= ($this->input->get('status') == 'approved') ? 'selected' : '' ?>>Disetujui</option>
                    <option value="rejected" <?= ($this->input->get('status') == 'rejected') ? 'selected' : '' ?>>Ditolak</option>
                </select>
                
                <!-- Tambahkan input hidden untuk tahun -->
                <input type="hidden" name="tahun" value="<?= isset($tahun) ? $tahun : date('Y') ?>">
                
                <button type="submit" class="btn-primary" style="white-space:nowrap">
                    <i class="fa-solid fa-filter"></i> Terapkan
                </button>
                
                <a href="<?= base_url('dekan/halaman_total') ?>" class="btn-secondary" style="white-space:nowrap">
                    <i class="fa-solid fa-refresh"></i> Reset
                </a>
            </div>
        </form>
        
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php 
                    if (isset($surat_list) && is_array($surat_list) && count($surat_list) > 0): 
                        $i = 1; 
                        foreach ($surat_list as $s): 
                            // Normalisasi status untuk dekan
                            $st_raw = isset($s['status']) ? trim($s['status']) : '';
                            $st_l = strtolower($st_raw);
                            
                            // Mapping status ke kategori
                            if ($st_l === 'disetujui sekretariat') {
                                $st_key = 'pending';
                                $badge = '<span class="badge badge-pending">Menunggu</span>';
                            } elseif ($st_l === 'disetujui dekan') {
                                $st_key = 'approved';
                                $badge = '<span class="badge badge-approved">Disetujui Dekan</span>';
                            } elseif ($st_l === 'ditolak dekan') {
                                $st_key = 'rejected';
                                $badge = '<span class="badge badge-rejected">Ditolak Dekan</span>';
                            } else {
                                $st_key = 'other';
                                $badge = '<span class="badge badge-pending">'.ucwords($st_raw).'</span>';
                            }
                            
                            // Format tanggal
                            $tgl_pengajuan = isset($s['created_at']) && $s['created_at'] ? date('d M Y', strtotime($s['created_at'])) : '-';
                            $tgl_kegiatan = isset($s['tanggal_kegiatan']) && $s['tanggal_kegiatan'] ? date('d M Y', strtotime($s['tanggal_kegiatan'])) : '-';
                    ?>
                    <tr data-status="<?= $st_key ?>">
                        <td><?= $i ?></td>
                        <td><strong><?= htmlspecialchars($s['nama_kegiatan'] ?? '-') ?></strong></td>
                        <td><?= htmlspecialchars($s['penyelenggara'] ?? '-') ?></td>
                        <td><?= $tgl_pengajuan ?></td>
                        <td><?= $tgl_kegiatan ?></td>
                        <td><?= htmlspecialchars($s['jenis_pengajuan'] ?? '-') ?></td>
                        <td><?= $badge ?></td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <button class="btn btn-detail" onclick="showDetail(<?= (int)$s['id'] ?>)" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button class="btn btn-status" title="Lihat Status" onclick="showStatusModal(<?= $s['id']; ?>)">
                                    <i class="fas fa-tasks"></i>
                                </button>
                                <?php if ($st_l === 'disetujui sekretariat'): ?>
                                    <button class="btn btn-approve" onclick="approveSurat(<?= (int)$s['id'] ?>)" title="Setujui">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                    <button class="btn btn-reject" onclick="showRejectModal(<?= (int)$s['id'] ?>)" title="Tolak">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php $i++; endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align:center;padding:40px;color:#7f8c8d">
                                <i class="fa-solid fa-inbox" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
                                <strong>
                                    <?php if($this->input->get('search') || $this->input->get('status')): ?>
                                        Tidak ada data yang sesuai dengan filter
                                    <?php else: ?>
                                        Belum ada pengajuan
                                    <?php endif; ?>
                                </strong>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-info">
            <?php
            $filter_info = "Semua Data";
            if($this->input->get('status') == 'pending') $filter_info = "Menunggu";
            if($this->input->get('status') == 'approved') $filter_info = "Disetujui";
            if($this->input->get('status') == 'rejected') $filter_info = "Ditolak";
            echo "Menampilkan: " . $filter_info . " (" . (isset($total_surat) ? $total_surat : '0') . " data)";
            ?>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Detail Pengajuan Surat Tugas</h3>
            <button onclick="closeModal('detailModal')" style="background:none;border:0;font-size:20px;cursor:pointer">&times;</button>
        </div>
        <div class="modal-body" id="detailContent">
            <!-- Content akan diisi oleh JavaScript -->
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fa-solid fa-ban"></i> Tolak Pengajuan</h3>
            <button onclick="closeModal('rejectModal')" style="background:none;border:0;font-size:20px;cursor:pointer">&times;</button>
        </div>
        <div>
            <p style="margin-bottom:10px;color:#7f8c8d">Berikan alasan penolakan:</p>
            <textarea id="rejectionNotes" rows="5" placeholder="Masukkan alasan penolakan..." style="width:100%;padding:12px;border:2px solid #ddd;border-radius:8px;font-family:inherit;resize:vertical"></textarea>
            <div style="text-align:right;margin-top:12px">
                <button class="btn btn-reject" onclick="confirmReject()">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Penolakan
                </button>
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

<script>
// Data dari controller
const suratList = <?= isset($surat_list) ? json_encode($surat_list) : '[]' ?>;
let currentRejectId = null;

// Detail functions
function findSuratById(id) {
    return suratList.find(s => Number(s.id) === Number(id));
}

function showDetail(id) {
    const item = findSuratById(id);
    if (!item) { alert('Data tidak ditemukan'); return; }

    const getVal = (k) => (item[k] !== undefined && item[k] !== null ? item[k] : '-');
    
    // Tentukan class badge status
    let statusClass = 'status-menunggu';
    let statusText = getVal('status');
    if (statusText.toLowerCase().includes('ditolak')) {
        statusClass = 'status-ditolak';
    } else if (statusText.toLowerCase().includes('disetujui')) {
        statusClass = 'status-disetujui';
    }

    const content = `
        <div class="detail-section">
            <div class="section-title">3 Informasi Utama</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">NAMA KEGIATAN</div>
                    <div class="info-value">${escapeHtml(getVal('nama_kegiatan'))}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">STATUS PENGAJUAN</div>
                    <div class="info-value">
                        ${escapeHtml(getVal('status'))}
                        <span class="badge status-badge ${statusClass}">${getVal('status')}</span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">JENIS PENGAJUAN</div>
                    <div class="info-value">${escapeHtml(getVal('jenis_pengajuan'))}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">LINGKUP PENUGASAN</div>
                    <div class="info-value">${escapeHtml(getVal('lingkup_penugasan'))}</div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <div class="section-title">Informasi Dosen</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">NAMA DOSEN</div>
                    <div class="info-value">${escapeHtml(getVal('nama_dosen'))}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">NIP</div>
                    <div class="info-value">${escapeHtml(getVal('nip'))}</div>
                </div>
            </div>
        </div>

        <div class="divider"></div>

        <div class="detail-section">
            <div class="section-title">Informasi Waktu & Tempat</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">TANGGAL PENGAJUAN</div>
                    <div class="info-value">${formatDate(getVal('created_at'))}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">PENYELENGGARA</div>
                    <div class="info-value">${escapeHtml(getVal('penyelenggara'))}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">TANGGAL KEGIATAN</div>
                    <div class="info-value">${formatDate(getVal('tanggal_kegiatan'))}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">TEMPAT KEGIATAN</div>
                    <div class="info-value">${escapeHtml(getVal('tempat_kegiatan') || '-')}</div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <div class="section-title">File Evidence</div>
            <div class="info-item">
                <div class="info-value">
                    ${getVal('eviden') ? 
                        `<a href="<?= base_url('uploads/') ?>${escapeHtml(getVal('eviden'))}" target="_blank" style="color:#3498db; text-decoration:none;">
                            <i class="fa-solid fa-download"></i> Download
                        </a>` : 
                        '-'
                    }
                </div>
            </div>
        </div>

        ${getVal('catatan_penolakan') && getVal('catatan_penolakan') !== '-' ? 
            `<div class="detail-section">
                <div class="section-title">Catatan Penolakan</div>
                <div class="info-item">
                    <div class="info-value" style="color:#e74c3c; background:#f8f9fa; padding:10px; border-radius:5px;">
                        ${escapeHtml(getVal('catatan_penolakan'))}
                    </div>
                </div>
            </div>` : ''
        }

        <div style="text-align:right;margin-top:20px;padding-top:15px;border-top:1px solid #eee">
            ${ (item.status && item.status.toLowerCase() === 'disetujui sekretariat') ? 
                `<button class="btn btn-approve" onclick="approveSurat(${item.id}); closeModal('detailModal')" style="margin-right:8px">
                    <i class="fa-solid fa-check"></i> Setujui
                </button>
                <button class="btn btn-reject" onclick="showRejectModal(${item.id}); closeModal('detailModal')">
                    <i class="fa-solid fa-times"></i> Tolak
                </button>` : '' }
        </div>
    `;
    
    document.getElementById('detailContent').innerHTML = content;
    document.getElementById('detailModal').classList.add('show');
}

function approveSurat(id) {
    if (!confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')) return;
    
    // Build URL dengan parameter filter yang aktif
    const searchParams = new URLSearchParams(window.location.search);
    const from = 'total';
    const tahun = searchParams.get('tahun') || '<?= date("Y") ?>';
    
    window.location.href = `<?= base_url("dekan/approve/") ?>${id}?from=${from}&tahun=${tahun}&${searchParams.toString()}`;
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
    
    // Build URL dengan parameter filter yang aktif
    const searchParams = new URLSearchParams(window.location.search);
    const from = 'total';
    const tahun = searchParams.get('tahun') || '<?= date("Y") ?>';
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `<?= base_url("dekan/reject/") ?>${currentRejectId}?from=${from}&tahun=${tahun}&${searchParams.toString()}`;

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

function formatDate(d) {
    if (!d || d === '-' || d === '0000-00-00') return '-';
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

// Status Modal Functions
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

// Close modal ketika klik di luar
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal')) {
        e.target.classList.remove('show');
    }
});

// Auto submit form ketika select berubah
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.querySelector('select[name="status"]');
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
});
</script>
</body>
</html>