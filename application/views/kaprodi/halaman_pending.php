<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengajuan Menunggu - Dashboard Kaprodi</title>
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
    .search-container{display:flex;align-items:center;gap:15px;margin-bottom:20px;flex-wrap:wrap;background:#f8f9fa;padding:15px;border-radius:10px;border:1px solid #e9ecef}
    .search-box{position:relative;flex:1;min-width:300px}
    .search-input{width:100%;padding:12px 45px 12px 15px;border:1px solid #ddd;border-radius:8px;font-size:14px;transition:all 0.3s;background:white}
    .search-input:focus{outline:none;border-color:#8E44AD;box-shadow:0 0 0 2px rgba(142,68,173,0.1)}
    .search-icon{position:absolute;right:15px;top:50%;transform:translateY(-50%);color:#6c757d}
    .btn-secondary{padding:10px 20px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#95a5a6;color:#fff;text-decoration:none}
    .btn-secondary:hover{background:#7f8c8d}
    .pagination-info{margin-top:15px;color:#7f8c8d;font-size:14px;text-align:right}
    .back-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#3498db;color:white;text-decoration:none;border-radius:8px;font-weight:600;transition:all 0.3s;margin-bottom:20px}
    .back-btn:hover{background:#2980b9;transform:translateY(-2px)}
    .status-header{display:flex;align-items:center;gap:15px;margin-bottom:20px;padding:20px;background:white;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.06)}
    .status-icon{width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:24px}
    .status-icon.pending{background:#fff3cd;color:#f39c12}
    .status-info h1{margin:0;color:#ffffff;font-size:28px}
    .status-info p{margin:5px 0 0 0;color:#7f8c8d;font-size:16px}
    
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
    .file-item:hover{background:#f5eef8;border-color:#8E44AD}
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
    .modal-btn-approve{background:#27ae60;color:white}
    .modal-btn-approve:hover{background:#229954;transform:translateY(-2px)}
    .modal-btn-reject{background:#e74c3c;color:white}
    .modal-btn-reject:hover{background:#c0392b;transform:translateY(-2px)}
    
    /* Rejection Notes Styles */
    .rejection-notes{background:#fff5f5;border:1px solid #f8d7da;border-radius:8px;padding:20px;margin-top:15px}
    .rejection-notes .detail-label{color:#dc3545;font-weight:700}
    .rejection-notes .detail-value{background:#fff5f5;border-color:#f8d7da;color:#721c24;font-size:14px;line-height:1.5;min-height:auto;padding:12px}
    
    /* Bulk Action Styles */
    .bulk-actions {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        align-items: center;
    }
    
    .bulk-checkbox {
        margin-right: 10px;
        transform: scale(1.2);
    }
    
    .bulk-info {
        flex-grow: 1;
        color: #495057;
        font-size: 14px;
    }
    
    .btn-bulk {
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-bulk-approve {
        background: #27ae60;
        color: white;
    }
    
    .btn-bulk-approve:hover {
        background: #229954;
    }
    
    .btn-bulk-reject {
        background: #e74c3c;
        color: white;
    }
    
    .btn-bulk-reject:hover {
        background: #c0392b;
    }
    
    .btn-bulk:disabled {
        background: #bdc3c7;
        cursor: not-allowed;
        transform: none;
    }
    
    /* Bulk Modal Styles */
    .bulk-modal-content {
        background: white;
        padding: 0;
        border-radius: 15px;
        max-width: 600px;
        width: 95%;
        max-height: 85vh;
        overflow: hidden;
        animation: slideIn 0.3s ease;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }
    
    .bulk-list {
        max-height: 300px;
        overflow-y: auto;
        margin: 15px 0;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 10px;
    }
    
    .bulk-item {
        padding: 10px;
        border-bottom: 1px solid #f1f1f1;
        display: flex;
        align-items: center;
    }
    
    .bulk-item:last-child {
        border-bottom: none;
    }
    
    .bulk-item-name {
        flex-grow: 1;
    }
    
    /* Individual Rejection Styles - BARU */
    .individual-rejection {
        margin-bottom: 15px;
        padding: 15px;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        background: #f8f9fa;
    }
    
    .individual-rejection-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        padding-bottom: 8px;
        border-bottom: 1px solid #dee2e6;
    }
    
    .individual-rejection-title {
        font-weight: 600;
        color: #495057;
        flex-grow: 1;
    }
    
    .individual-rejection-textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        font-family: inherit;
        resize: vertical;
        min-height: 80px;
        font-size: 14px;
    }
    
    .individual-rejection-textarea:focus {
        outline: none;
        border-color: #8E44AD;
        box-shadow: 0 0 0 2px rgba(142,68,173,0.1);
    }
    
    .bulk-notes-info {
        background: #e7f3ff;
        border: 1px solid #b3d7ff;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        font-size: 14px;
        color: #0066cc;
    }
    
    .bulk-notes-info i {
        margin-right: 8px;
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
        background: #8E44AD;
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
    
    /* Loading spinner */
    .loading-spinner {
        display: none;
        text-align: center;
        padding: 40px;
        color: #8E44AD;
    }
    .loading-spinner i {
        font-size: 48px;
        margin-bottom: 15px;
    }
    
    /* Error message */
    .error-message {
        text-align: center;
        padding: 40px;
        color: #e74c3c;
    }
    .error-message i {
        font-size: 48px;
        margin-bottom: 15px;
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
        .bulk-actions {
            flex-direction: column;
            align-items: flex-start;
        }
        .bulk-info {
            margin: 10px 0;
        }
    }
</style>
</head>
<body>

<div class="navbar">
    <h2><i class="fa-solid fa-user-tie"></i> Dashboard Kaprodi</h2>
    <div></div>
</div>

<div class="container">
    <!-- Tombol Kembali -->
    <a href="<?= base_url('kaprodi') ?>" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
    </a>

    <!-- Header Status -->
    <div class="status-header">
        <div class="status-icon pending">
            <i class="fa-solid fa-clock"></i>
        </div>
        <div class="status-info">
            <h1>MENUNGGU PERSETUJUAN</h1>
            <p><?= isset($total_surat) ? $total_surat : '0' ?> Pengajuan</p>
        </div>
    </div>

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

    <!-- Tabel Pengajuan Menunggu -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-table"></i> Daftar Pengajuan Menunggu Persetujuan</h3>
        </div>
        
        <!-- Bulk Actions (untuk inline selection) -->
        <div class="bulk-actions" id="bulkActions" style="display: none;">
            <input type="checkbox" id="selectAll" class="bulk-checkbox" onchange="toggleSelectAll()">
            <div class="bulk-info" id="selectedCount">0 item dipilih</div>
            <button class="btn-bulk btn-bulk-approve" onclick="processBulkApprove()" id="bulkApproveBtn">
                <i class="fa-solid fa-check"></i> Setujui yang Dipilih
            </button>
            <button class="btn-bulk btn-bulk-reject" onclick="showBulkRejectModal()" id="bulkRejectBtn">
                <i class="fa-solid fa-times"></i> Tolak yang Dipilih
            </button>
            <button class="btn-bulk" onclick="clearSelection()" style="background: #95a5a6; color: white;">
                <i class="fa-solid fa-times"></i> Batal
            </button>
        </div>
        
        <!-- Search Box -->
        <form method="get" action="<?= base_url('kaprodi/pending') ?>" id="searchForm">
            <div class="search-container">
                <div class="search-box">
                    <input 
                        type="text" 
                        name="search" 
                        class="search-input"
                        placeholder="Cari berdasarkan nama kegiatan, penyelenggara, jenis pengajuan, atau NIP..."
                        value="<?= $this->input->get('search') ?>"
                        id="searchInput"
                    >
                    <div class="search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
                
                <button type="submit" class="btn-secondary" style="white-space:nowrap">
                    <i class="fa-solid fa-search"></i> Cari
                </button>
                
                <?php if($this->input->get('search')): ?>
                <a href="<?= base_url('kaprodi/pending') ?>" class="btn-secondary" style="white-space:nowrap">
                    <i class="fa-solid fa-refresh"></i> Reset
                </a>
                <?php endif; ?>
            </div>
        </form>
        
        <div style="overflow-x:auto">
            <table>
                <thead>
                    <tr>
                        <th width="40">
                            <input type="checkbox" id="selectAllHeader" onchange="toggleSelectAllHeader()">
                        </th>
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
                    if(isset($surat_list) && is_array($surat_list) && !empty($surat_list)): 
                        $no = 1; 
                        foreach($surat_list as $s): 
                            $tgl_pengajuan = isset($s->created_at) && $s->created_at ? date('d M Y', strtotime($s->created_at)) : '-';
                            $tgl_kegiatan = isset($s->tanggal_kegiatan) && $s->tanggal_kegiatan ? date('d M Y', strtotime($s->tanggal_kegiatan)) : '-';
                    ?>
                    <tr>
                        <td>
                            <input type="checkbox" class="row-checkbox" value="<?= $s->id ?? 0 ?>" onchange="updateBulkActions()">
                        </td>
                        <td><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($s->nama_kegiatan ?? '-') ?></strong></td>
                        <td><?= htmlspecialchars($s->penyelenggara ?? '-') ?></td>
                        <td><?= $tgl_pengajuan ?></td>
                        <td><?= $tgl_kegiatan ?></td>
                        <td><?= htmlspecialchars($s->jenis_pengajuan ?? '-') ?></td>
                        <td><span class="badge badge-pending"><?= ucwords($s->status ?? 'Menunggu') ?></span></td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <button class="btn btn-sm btn-status" title="Lihat Status" onclick="showStatusModal(<?= $s->id ?? 0; ?>)">
                                    <i class="fas fa-tasks"></i>
                                </button>
                                <button class="btn btn-detail" onclick="showDetail(<?= $s->id ?? 0 ?>)" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button class="btn btn-approve" onclick="processSingleApprove(<?= $s->id ?? 0 ?>)" title="Setujui">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                <button class="btn btn-reject" onclick="showRejectModal(<?= $s->id ?? 0 ?>)" title="Tolak">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="9" style="text-align:center;padding:40px;color:#7f8c8d">
                            <i class="fa-solid fa-clock" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
                            <strong>
                                <?php if(!isset($surat_list)): ?>
                                    Variabel $surat_list tidak terdefinisi
                                <?php elseif(empty($surat_list)): ?>
                                    <?php if($this->input->get('search')): ?>
                                        Tidak ada pengajuan yang sesuai dengan pencarian "<?= htmlspecialchars($this->input->get('search')) ?>"
                                    <?php else: ?>
                                        Tidak ada pengajuan yang menunggu persetujuan
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
            Menampilkan: Pengajuan Menunggu Persetujuan 
            <?php if($this->input->get('search')): ?>
                (Hasil pencarian: "<?= htmlspecialchars($this->input->get('search')) ?>")
            <?php else: ?>
                (<?= isset($total_surat) ? $total_surat : '0' ?> data)
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Detail Modal -->
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
        <div style="padding:25px">
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

<!-- Bulk Reject Modal - DIUBAH untuk individual rejection notes -->
<div id="bulkRejectModal" class="modal" onclick="modalClickOutside(event,'bulkRejectModal')">
    <div class="bulk-modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-ban"></i> Tolak Pengajuan Terpilih</h3>
            <button class="close-modal" onclick="closeModal('bulkRejectModal')">&times;</button>
        </div>
        <div style="padding:25px">
            <div style="background:#f5eef8;border:1px solid #8E44AD;border-radius:8px;padding:15px;margin-bottom:20px">
                <strong><i class="fa-solid fa-info-circle"></i> Anda akan menolak:</strong>
                <span id="bulkRejectCount">0 pengajuan</span>
            </div>
            
            <div class="bulk-notes-info">
                <i class="fa-solid fa-info-circle"></i>
                Berikan alasan penolakan untuk masing-masing pengajuan:
            </div>
            
            <div id="individualRejectionContainer">
                <!-- Container untuk individual rejection notes -->
            </div>
            
            <div style="text-align:right;margin-top:12px">
                <button class="btn btn-reject" onclick="confirmBulkReject()">
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

                <!-- Step 4: Persetujuan Kaprodi -->
                <div class="progress-step status-pending" id="step4">
                    <div class="step-icon">
                        <i class="fas fa-clock" id="step4-icon"></i>
                    </div>
                    <div class="step-text" id="step4-text">Persetujuan Kaprodi</div>
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
const suratList = <?= isset($surat_list) && !empty($surat_list) ? json_encode($surat_list) : '[]' ?>;
let currentRejectId = null;
let currentDetailId = null;
let selectedIds = [];

// Bulk Action Functions
function toggleSelectAllHeader() {
    const selectAll = document.getElementById('selectAllHeader').checked;
    const checkboxes = document.querySelectorAll('.row-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll;
    });
    
    updateBulkActions();
}

function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll').checked;
    const checkboxes = document.querySelectorAll('.row-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll;
    });
    
    updateBulkActions();
}

function updateBulkActions() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    selectedIds = [];
    
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            selectedIds.push(checkbox.value);
        }
    });
    
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    const selectAllHeader = document.getElementById('selectAllHeader');
    const selectAllBulk = document.getElementById('selectAll');
    
    if (selectedIds.length > 0) {
        bulkActions.style.display = 'flex';
        selectedCount.textContent = `${selectedIds.length} item dipilih`;
        
        // Update select all checkboxes
        const allChecked = selectedIds.length === checkboxes.length;
        selectAllHeader.checked = allChecked;
        selectAllBulk.checked = allChecked;
    } else {
        bulkActions.style.display = 'none';
        selectAllHeader.checked = false;
        selectAllBulk.checked = false;
    }
}

function clearSelection() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    updateBulkActions();
}

// Process single approve without modal
function processSingleApprove(id) {
    if (confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url("kaprodi/approve/") ?>' + id;
        
        const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
        const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
        const inpCsrf = document.createElement('input');
        inpCsrf.type='hidden'; 
        inpCsrf.name=csrfName; 
        inpCsrf.value=csrfHash;
        form.appendChild(inpCsrf);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// ✅ PROCESS BULK APPROVE - DIPERBAIKI TOTAL (Gunakan Form Submit Biasa)
function processBulkApprove() {
    if (selectedIds.length === 0) {
        alert('Tidak ada pengajuan yang dipilih');
        return;
    }
    
    if (confirm(`Apakah Anda yakin ingin menyetujui ${selectedIds.length} pengajuan terpilih?`)) {
        // Buat form dan submit secara tradisional (bukan AJAX)
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url("kaprodi/process_multi_approve") ?>';
        
        // CSRF Token
        const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
        const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
        const inpCsrf = document.createElement('input');
        inpCsrf.type = 'hidden'; 
        inpCsrf.name = csrfName; 
        inpCsrf.value = csrfHash;
        form.appendChild(inpCsrf);
        
        // Tambahkan setiap selected ID sebagai input terpisah (ARRAY)
        selectedIds.forEach(id => {
            const inpId = document.createElement('input');
            inpId.type = 'hidden';
            inpId.name = 'selected_ids[]';
            inpId.value = id;
            form.appendChild(inpId);
        });
        
        document.body.appendChild(form);
        form.submit();
    }
}

// ✅ PROCESS BULK REJECT - DIPERBAIKI TOTAL
function showBulkRejectModal() {
    if (selectedIds.length === 0) {
        alert('Tidak ada pengajuan yang dipilih');
        return;
    }
    
    const modal = document.getElementById('bulkRejectModal');
    const countSpan = document.getElementById('bulkRejectCount');
    const container = document.getElementById('individualRejectionContainer');
    
    countSpan.textContent = `${selectedIds.length} pengajuan`;
    
    // Populate individual rejection notes
    container.innerHTML = '';
    selectedIds.forEach(id => {
        const surat = suratList.find(s => Number(s.id) === Number(id));
        if (surat) {
            const rejectionDiv = document.createElement('div');
            rejectionDiv.className = 'individual-rejection';
            rejectionDiv.innerHTML = `
                <div class="individual-rejection-header">
                    <div class="individual-rejection-title">
                        <strong>${escapeHtml(surat.nama_kegiatan || '-')}</strong>
                        <div style="font-size:12px;color:#6c757d">${escapeHtml(surat.penyelenggara || '-')}</div>
                    </div>
                </div>
                <textarea 
                    class="individual-rejection-textarea" 
                    placeholder="Masukkan alasan penolakan untuk pengajuan ini..."
                    data-id="${id}"
                ></textarea>
            `;
            container.appendChild(rejectionDiv);
        }
    });
    
    modal.classList.add('show');
}

// ✅ CONFIRM BULK REJECT - DIPERBAIKI TOTAL (Gunakan Form Submit Biasa)
function confirmBulkReject() {
    // Validasi semua textarea
    const textareas = document.querySelectorAll('.individual-rejection-textarea');
    let allFilled = true;
    const rejectionData = [];
    
    textareas.forEach(textarea => {
        const id = textarea.getAttribute('data-id');
        const notes = textarea.value.trim();
        
        if (!notes) {
            allFilled = false;
            textarea.style.borderColor = '#e74c3c';
        } else {
            textarea.style.borderColor = '';
            rejectionData.push({
                id: id,
                notes: notes
            });
        }
    });
    
    if (!allFilled) {
        alert('Semua alasan penolakan harus diisi');
        return;
    }
    
    // Tutup modal terlebih dahulu
    closeModal('bulkRejectModal');
    
    // Buat form dan submit secara tradisional (bukan AJAX)
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= base_url("kaprodi/process_multi_reject") ?>';
    
    // CSRF Token
    const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
    const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
    const inpCsrf = document.createElement('input');
    inpCsrf.type = 'hidden'; 
    inpCsrf.name = csrfName; 
    inpCsrf.value = csrfHash;
    form.appendChild(inpCsrf);
    
    // Tambahkan setiap selected ID dan rejection notes sebagai input terpisah
    rejectionData.forEach(item => {
        const inpId = document.createElement('input');
        inpId.type = 'hidden';
        inpId.name = 'selected_ids[]';
        inpId.value = item.id;
        form.appendChild(inpId);
        
        const inpNotes = document.createElement('input');
        inpNotes.type = 'hidden';
        inpNotes.name = 'rejection_notes[]';
        inpNotes.value = item.notes;
        form.appendChild(inpNotes);
    });
    
    document.body.appendChild(form);
    form.submit();
}

// Helper function untuk escape HTML
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
function showStatusModal(suratId) {
    const modal = document.getElementById('statusModal');
    modal.style.display = 'flex';
    resetAllStatus();
    loadStatusData(suratId);
}

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
            'Persetujuan Kaprodi'
        ];
        text.textContent = defaultTexts[i-1];
        date.textContent = '-';
    }

    document.getElementById('progressLine').style.width = '0%';
    const desc = document.getElementById("status-description");
    desc.textContent = "Memuat informasi status...";
    desc.style.color = "black";
}

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

    if (finalStatus === "disetujui kaprodi") {
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

function showDetail(id) {
    currentDetailId = id;
    
    // Reset dan tampilkan loading
    const detailContent = document.getElementById('detailContent');
    detailContent.innerHTML = `
        <div class="loading-spinner" id="detailLoading">
            <i class="fa-solid fa-spinner fa-spin"></i>
            <p>Memuat data...</p>
        </div>
        <div class="error-message" id="detailError" style="display:none">
            <i class="fa-solid fa-exclamation-triangle"></i>
            <p id="errorText">Terjadi kesalahan saat memuat data</p>
            <button class="btn btn-detail" onclick="retryLoadDetail()" style="margin-top:15px">
                <i class="fa-solid fa-refresh"></i> Coba Lagi
            </button>
        </div>
    `;
    
    // Tampilkan modal
    document.getElementById('detailModal').classList.add('show');
    
    // Load data
    loadDetailData(id);
}

function loadDetailData(id) {
    const detailLoading = document.getElementById('detailLoading');
    const detailError = document.getElementById('detailError');
    
    if (detailLoading) detailLoading.style.display = 'block';
    if (detailError) detailError.style.display = 'none';
    
    // Fetch dari server
    fetch(`<?= base_url('kaprodi/getDetailPengajuan/') ?>${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Sembunyikan loading
            if (detailLoading) detailLoading.style.display = 'none';
            
            if (data.success && data.data) {
                displayDetailContent(data);
            } else {
                showDetailError(data.message || 'Data tidak ditemukan');
            }
        })
        .catch(error => {
            console.error('Error fetching detail:', error);
            if (detailLoading) detailLoading.style.display = 'none';
            
            // Coba gunakan data dari suratList jika ada
            const localData = suratList.find(s => Number(s.id) === Number(id));
            if (localData) {
                displayDetailContent({success: true, data: localData});
            } else {
                showDetailError('Gagal memuat data dari server. Periksa koneksi internet Anda.');
            }
        });
}

function displayDetailContent(data) {
    const item = data.data;
    const detailContent = document.getElementById('detailContent');
    
    const getVal = (k) => (item[k] !== undefined && item[k] !== null ? item[k] : '-');
    
    // Helper functions
    const formatDate = (dateStr) => {
        if (!dateStr || dateStr === '-' || dateStr === '0000-00-00' || dateStr === '0000-00-00 00:00:00') return '-';
        try {
            const date = new Date(dateStr);
            return isNaN(date.getTime()) ? '-' : date.toLocaleDateString('id-ID', { 
                day: '2-digit', 
                month: 'short', 
                year: 'numeric' 
            });
        } catch (e) {
            return '-';
        }
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
    let statusBadge = '';
    if (status.toLowerCase().includes('ditolak')) {
        statusBadge = '<span class="badge badge-rejected" style="margin-left:10px">Ditolak</span>';
    } else if (status.toLowerCase().includes('disetujui')) {
        statusBadge = '<span class="badge badge-approved" style="margin-left:10px">Disetujui</span>';
    } else {
        statusBadge = '<span class="badge badge-pending" style="margin-left:10px">Menunggu</span>';
    }

    const content = `
        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fa-solid fa-info-circle"></i> 1 Informasi Utama
            </div>
            <div class="detail-grid">
                <div class="detail-row">
                    <div class="detail-label">NAMA KEGIATAN</div>
                    <div class="detail-value">${escapeHtml(getVal('nama_kegiatan'))}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">JENIS PENGAJUAN</div>
                    <div class="detail-value">${escapeHtml(getVal('jenis_pengajuan'))}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">STATUS PENGAJUAN</div>
                    <div class="detail-value" style="display:flex;align-items:center">
                        ${escapeHtml(status)} ${statusBadge}
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">LINGKUP PENUGASAN</div>
                    <div class="detail-value">${escapeHtml(getVal('lingkup_penugasan') || '-')}</div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fa-solid fa-user-tie"></i> 2 Informasi Dosen
            </div>
            <div class="detail-grid">
                <div class="detail-row">
                    <div class="detail-label">NAMA DOSEN</div>
                    <div class="detail-value">${escapeHtml(getVal('nama_dosen') || '-')}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">NIP</div>
                    <div class="detail-value">${escapeHtml(getVal('nip') || '-')}</div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fa-solid fa-calendar-alt"></i> 3 Informasi Waktu & Tempat
            </div>
            <div class="detail-grid">
                <div class="detail-row">
                    <div class="detail-label">TANGGAL PENGAJUAN</div>
                    <div class="detail-value">${formatDate(getVal('created_at'))}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">TANGGAL KEGIATAN</div>
                    <div class="detail-value">${formatDate(getVal('tanggal_kegiatan'))}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">PENYELENGGARA</div>
                    <div class="detail-value">${escapeHtml(getVal('penyelenggara'))}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">TEMPAT KEGIATAN</div>
                    <div class="detail-value">${escapeHtml(getVal('tempat_kegiatan') || '-')}</div>
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
            <button class="modal-btn modal-btn-approve" onclick="processSingleApprove(${item.id}); closeModal('detailModal')">
                <i class="fa-solid fa-check"></i> Setujui
            </button>
            <button class="modal-btn modal-btn-reject" onclick="showRejectModal(${item.id}); closeModal('detailModal')">
                <i class="fa-solid fa-times"></i> Tolak
            </button>
            <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal')">
                <i class="fa-solid fa-times"></i> Tutup
            </button>
        </div>
    `;
    
    detailContent.innerHTML = content;
}

function showDetailError(message) {
    const detailContent = document.getElementById('detailContent');
    detailContent.innerHTML = `
        <div class="error-message" id="detailError">
            <i class="fa-solid fa-exclamation-triangle"></i>
            <p id="errorText">${message}</p>
            <button class="btn btn-detail" onclick="retryLoadDetail()" style="margin-top:15px">
                <i class="fa-solid fa-refresh"></i> Coba Lagi
            </button>
        </div>
    `;
}

function retryLoadDetail() {
    if (currentDetailId) {
        loadDetailData(currentDetailId);
    }
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
    form.action = '<?= base_url("kaprodi/reject/") ?>' + currentRejectId;
    
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

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    
    // Prevent form submission when pressing Enter in search input
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            // Biarkan form submit normal jika ada nilai search
            if (!searchInput.value.trim()) {
                e.preventDefault(); // Cegah submit jika search kosong
            }
        });
    }
    
    // Auto focus pada search input
    if (searchInput) {
        const searchValue = '<?= $this->input->get('search') ?>';
        if (searchValue) {
            searchInput.focus();
            searchInput.setSelectionRange(searchValue.length, searchValue.length);
        }
    }
});
</script>
</body>
</html>