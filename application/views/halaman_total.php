<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Total Pengajuan - Dashboard Kaprodi</title>
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
    .badge-completed{background:#d1ecf1;color:#0c5460}
    .btn{padding:6px 10px;border-radius:6px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s}
    .btn:hover{transform:scale(1.05)}
    .btn-approve{background:#27ae60;color:#fff}
    .btn-approve:hover{background:#229954}
    .btn-reject{background:#e74c3c;color:#fff}
    .btn-reject:hover{background:#c0392b}
    .btn-detail{background:#3498db;color:#fff}
    .btn-detail:hover{background:#2980b9}
    .search-filter-container{display:flex;align-items:center;gap:15px;margin-bottom:20px;flex-wrap:wrap;background:#f8f9fa;padding:15px;border-radius:10px;border:1px solid #e9ecef}
    .search-box{position:relative;flex:1;min-width:300px}
    .search-input{width:100%;padding:12px 45px 12px 15px;border:1px solid #ddd;border-radius:8px;font-size:14px;transition:all 0.3s;background:white}
    .search-input:focus{outline:none;border-color:#8E44AD;box-shadow:0 0 0 2px rgba(142,68,173,0.1)}
    .search-icon{position:absolute;right:15px;top:50%;transform:translateY(-50%);color:#6c757d}
    .filter-select{padding:12px 15px;border:1px solid #ddd;border-radius:8px;font-size:14px;background:white;color:#495057;min-width:180px;cursor:pointer;transition:all 0.3s}
    .filter-select:focus{outline:none;border-color:#8E44AD;box-shadow:0 0 0 2px rgba(142,68,173,0.1)}
    .btn-primary{padding:10px 20px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#8E44AD;color:#fff;text-decoration:none}
    .btn-primary:hover{background:#7d3c98;transform:translateY(-2px)}
    .btn-secondary{padding:10px 20px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#95a5a6;color:#fff;text-decoration:none}
    .btn-secondary:hover{background:#7f8c8d}
    .pagination-info{margin-top:15px;color:#7f8c8d;font-size:14px;text-align:right}
    .back-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#3498db;color:white;text-decoration:none;border-radius:8px;font-weight:600;transition:all 0.3s;margin-bottom:20px}
    .back-btn:hover{background:#2980b9;transform:translateY(-2px)}
    
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
    
    /* Detail Content Styles - IMPROVED */
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
        background: #8E44AD;
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
    .file-item:hover{background:#f5eef8;border-color:#8E44AD}
    .file-icon{width:24px;height:24px;display:flex;align-items:center;justify-content:center;color:#8E44AD;font-size:16px}
    .file-info{flex:1}
    .file-name{font-weight:600;color:#212529;font-size:14px;cursor:pointer}
    .file-name:hover{color:#8E44AD}
    .file-size{font-size:12px;color:#6c757d}
    .preview-btn{background:#3498db;color:white;border:none;padding:8px 16px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;transition:background 0.2s;display:flex;align-items:center;gap:6px;text-decoration:none}
    .preview-btn:hover{background:#2980b9;color:white;text-decoration:none}
    .preview-btn.disabled{background:#bdc3c7;cursor:not-allowed;opacity:0.6}
    .preview-btn.disabled:hover{background:#bdc3c7}
    .download-btn{background:#8E44AD;color:white;border:none;padding:8px 16px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;transition:background 0.2s;display:flex;align-items:center;gap:6px;text-decoration:none}
    .download-btn:hover{background:#7D3C98;color:white;text-decoration:none}

    /* Preview Modal Styles */
    .preview-modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.8);z-index:10000;justify-content:center;align-items:center;padding:20px}
    .preview-modal.show{display:flex}
    .preview-content{background:white;border-radius:12px;width:90%;max-width:900px;max-height:90vh;overflow:hidden;display:flex;flex-direction:column}
    .preview-header{background:#8E44AD;color:white;padding:15px 20px;display:flex;justify-content:space-between;align-items:center}
    .preview-header h3{margin:0;font-size:16px;font-weight:600}
    .preview-close{background:none;border:none;color:white;font-size:24px;cursor:pointer;padding:0;width:30px;height:30px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background 0.2s}
    .preview-close:hover{background:rgba(255,255,255,0.2)}
    .preview-body{flex:1;padding:0;display:flex;justify-content:center;align-items:center;background:#f8f9fa;min-height:400px}
    .preview-iframe{width:100%;height:70vh;border:none}
    .preview-image{max-width:100%;max-height:70vh;object-fit:contain}
    .preview-unsupported{text-align:center;padding:40px;color:#6c757d}
    .preview-unsupported i{font-size:48px;margin-bottom:15px;color:#8E44AD}
    
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
    
    /* Approve Modal Styles */
    .approve-modal-content{background:white;padding:0;border-radius:15px;max-width:550px;width:95%;max-height:85vh;overflow:hidden;animation:slideIn 0.3s ease;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
    .approve-modal-body{padding:25px}
    .approve-modal-header{background:#8E44AD;color:white;padding:20px 25px;display:flex;justify-content:space-between;align-items:center;border-radius:15px 15px 0 0}
    .approve-modal-header h3{margin:0;font-size:18px;font-weight:600}
    .approve-info-box{background:#f5eef8;border:1px solid #8E44AD;border-radius:8px;padding:15px;margin-bottom:20px}
    .approve-info-box strong{color:#8E44AD;display:block;margin-bottom:5px}
    .approve-info-box span{color:#2c3e50;font-weight:600}
    .form-group{margin-bottom:20px}
    .form-group label{display:block;margin-bottom:8px;font-weight:600;color:#2c3e50;font-size:14px}
    .form-control{width:100%;padding:12px 15px;border:2px solid #ddd;border-radius:8px;font-family:inherit;font-size:14px;transition:border-color 0.2s}
    .form-control:focus{outline:none;border-color:#3498db;box-shadow:0 0 0 3px rgba(52, 152, 219, 0.2)}
    .form-hint{color:#7f8c8d;font-size:12px;margin-top:5px;display:flex;align-items:center;gap:5px}
    .approve-modal-actions{display:flex;justify-content:flex-end;gap:12px;margin-top:25px;padding-top:20px;border-top:1px solid #e9ecef}
    .approve-btn{padding:10px 20px;border-radius:8px;border:none;cursor:pointer;font-weight:600;font-size:14px;transition:all 0.2s;display:flex;align-items:center;gap:8px}
    .approve-btn-cancel{background:#95a5a6;color:white}
    .approve-btn-cancel:hover{background:#7f8c8d;transform:translateY(-2px)}
    .approve-btn-submit{background:#27ae60;color:white}
    .approve-btn-submit:hover{background:#229954;transform:translateY(-2px)}
    
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
    
    /* Nomor Surat Styles */
    .nomor-surat-container {
        background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
        border: 2px solid #8E44AD;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        text-align: center;
    }
    
    .nomor-surat-label {
        font-size: 14px;
        font-weight: 600;
        color: #8E44AD;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .nomor-surat-value {
        font-size: 18px;
        font-weight: 700;
        color: #6c3483;
        font-family: 'Courier New', monospace;
    }
    
    /* PAGINATION STYLES */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid #e9ecef;
    }
    
    .pagination {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-wrap: wrap;
    }
    
    .pagination-btn {
        min-width: 36px;
        height: 36px;
        border: 1px solid #ddd;
        background: white;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
        color: #495057;
        transition: all 0.2s;
    }
    
    .pagination-btn:hover {
        background: #f8f9fa;
        border-color: #8E44AD;
        color: #8E44AD;
    }
    
    .pagination-btn.active {
        background: #8E44AD;
        border-color: #8E44AD;
        color: white;
    }
    
    .pagination-btn.disabled {
        background: #f8f9fa;
        color: #adb5bd;
        cursor: not-allowed;
        border-color: #e9ecef;
    }
    
    .pagination-btn.disabled:hover {
        background: #f8f9fa;
        color: #adb5bd;
        border-color: #e9ecef;
    }
    
    .page-info {
        font-size: 14px;
        color: #6c757d;
        font-weight: 500;
    }
    
    .pagination-select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: white;
        color: #495057;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .pagination-select:focus {
        outline: none;
        border-color: #8E44AD;
        box-shadow: 0 0 0 2px rgba(142,68,173,0.1);
    }
    
    /* Responsive */
    @media (max-width:768px){
        .detail-grid{grid-template-columns:1fr}
        .modal-content{width:95%;margin:10px}
        .detail-content{padding:15px}
        .search-filter-container{flex-direction:column}
        .search-box{width:100%;min-width:100%}
        .filter-select{width:100%}
        .modal-actions{flex-direction:column}
        .modal-btn{justify-content:center}
        .approve-modal-content{width:95%;margin:10px}
        .approve-modal-body{padding:15px}
        .approve-modal-actions{flex-direction:column}
        .approve-btn{justify-content:center}
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
        .pagination-container {
            flex-direction: column;
            gap: 15px;
            align-items: stretch;
        }
        .page-info {
            text-align: center;
        }
        .pagination {
            justify-content: center;
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
            <h3><i class="fa-solid fa-table"></i> Total Pengajuan Surat</h3>
            <div>
                <span style="color:#7f8c8d;font-size:13px">
                    Total: <?= isset($total_surat) ? $total_surat : '0' ?> data
                </span>
            </div>
        </div>
        
        <!-- Search + Filter -->
        <div class="search-filter-container">
            <div class="search-box">
                <input 
                    type="text" 
                    id="searchInput"
                    class="search-input"
                    placeholder="Cari berdasarkan nama kegiatan, penyelenggara, atau jenis pengajuan..."
                    value=""
                    autocomplete="off"
                >
                <div class="search-icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>
            
            <select id="statusSelect" class="filter-select">
                <option value="">Semua Status</option>
                <option value="pending">Menunggu</option>
                <option value="approved">Disetujui</option>
                <option value="rejected">Ditolak</option>
            </select>
            
            <button type="button" onclick="resetFilter()" class="btn-secondary">
                <i class="fa-solid fa-refresh"></i> Reset
            </button>
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php 
                    if(isset($surat_list) && is_array($surat_list) && !empty($surat_list)): 
                        $no = 1; 
                        foreach($surat_list as $s): 
                            $st_l = strtolower($s->status ?? '');
                            
                            // Tentukan warna berdasarkan kata kunci
                            if (strpos($st_l, 'setuju') !== false || strpos($st_l, 'disetujui') !== false) {
                                $st_key = 'approved';
                                $badge = '<span class="badge badge-approved">'.ucwords($s->status ?? '').'</span>';
                            } elseif (strpos($st_l, 'tolak') !== false || strpos($st_l, 'ditolak') !== false) {
                                $st_key = 'rejected';
                                $badge = '<span class="badge badge-rejected">'.ucwords($s->status ?? '').'</span>';
                            } else {
                                $st_key = 'pending';
                                $badge = '<span class="badge badge-pending">'.ucwords($s->status ?? '').'</span>';
                            }

                            $tgl_pengajuan = isset($s->created_at) && $s->created_at? date('d M Y', strtotime($s->created_at)) : '-';
                            $tgl_kegiatan = isset($s->tanggal_kegiatan) && $s->tanggal_kegiatan ? date('d M Y', strtotime($s->tanggal_kegiatan)) : '-';
                    ?>
                    <tr class="data-row" data-status="<?= $st_key ?>" data-nama="<?= strtolower(htmlspecialchars($s->nama_kegiatan ?? '')) ?>" data-penyelenggara="<?= strtolower(htmlspecialchars($s->penyelenggara ?? '')) ?>" data-jenis="<?= strtolower(htmlspecialchars($s->jenis_pengajuan ?? '')) ?>">
                        <td class="row-number"><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($s->nama_kegiatan ?? '-') ?></strong></td>
                        <td><?= htmlspecialchars($s->penyelenggara ?? '-') ?></td>
                        <td><?= $tgl_pengajuan ?></td>
                        <td><?= $tgl_kegiatan ?></td>
                        <td><?= htmlspecialchars($s->jenis_pengajuan ?? '-') ?></td>
                        <td><?= $badge ?></td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <button class="btn btn-sm btn-status" title="Lihat Status" onclick="showStatusModal(<?= $s->id ?? 0; ?>)">
                                    <i class="fas fa-tasks"></i>
                                </button>
                                <button class="btn btn-detail" onclick="showDetail(<?= $s->id ?? 0 ?>)" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr id="emptyRow">
                        <td colspan="8" style="text-align:center;padding:40px;color:#7f8c8d">
                            <i class="fa-solid fa-inbox" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
                            <strong>Tidak ada data pengajuan</strong>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="pagination-container">
            <div class="page-info">
                <span id="pageInfoText">Menampilkan 0-0 dari 0 data</span>
            </div>
            
            <div class="pagination">
                <select id="pageSizeSelect" class="pagination-select">
                    <option value="10">10 per halaman</option>
                    <option value="25">25 per halaman</option>
                    <option value="50">50 per halaman</option>
                    <option value="100">100 per halaman</option>
                </select>
                
                <button class="pagination-btn" onclick="changePage(1)" id="firstPageBtn" title="Halaman Pertama">
                    <i class="fa-solid fa-angles-left"></i>
                </button>
                <button class="pagination-btn" onclick="prevPage()" id="prevPageBtn" title="Halaman Sebelumnya">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                
                <div id="pageNumbers" style="display: flex; gap: 5px;">
                    <!-- Page numbers will be generated here -->
                </div>
                
                <button class="pagination-btn" onclick="nextPage()" id="nextPageBtn" title="Halaman Selanjutnya">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
                <button class="pagination-btn" onclick="changePage(totalPages)" id="lastPageBtn" title="Halaman Terakhir">
                    <i class="fa-solid fa-angles-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div id="previewModal" class="preview-modal">
    <div class="preview-content">
        <div class="preview-header">
            <h3 id="previewTitle">Preview File</h3>
            <button class="preview-close" onclick="closePreviewModal()">&times;</button>
        </div>
        <div class="preview-body" id="previewBody">
            <!-- Preview content akan diisi oleh JavaScript -->
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

<!-- Approve Modal -->
<div id="approveModal" class="modal" onclick="modalClickOutside(event,'approveModal')">
    <div class="approve-modal-content" onclick="event.stopPropagation()">
        <div class="approve-modal-header">
            <h3><i class="fa-solid fa-check-circle"></i> Setujui Pengajuan</h3>
            <button class="close-modal" onclick="closeModal('approveModal')">&times;</button>
        </div>
        <div class="approve-modal-body">
            <div class="approve-info-box">
                <strong><i class="fa-solid fa-info-circle"></i> Informasi:</strong>
                <span id="approveNamaKegiatan"></span>
            </div>
            
            <form id="approveForm" method="POST" action="">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                
                <div class="form-group">
                    <label for="nomorSurat">
                        <i class="fa-solid fa-file-alt"></i> Nomor Surat <span style="color:#e74c3c">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="nomorSurat" 
                        name="nomor_surat" 
                        class="form-control" 
                        placeholder="Contoh: 001/SKT/FT/2025" 
                        required
                        autocomplete="off"
                    >
                    <div class="form-hint">
                        <i class="fa-solid fa-exclamation-circle"></i> Format: 001/SKT/FT/Tahun
                    </div>
                </div>

                <div class="approve-modal-actions">
                    <button type="button" class="approve-btn approve-btn-cancel" onclick="closeModal('approveModal')">
                        <i class="fa-solid fa-times"></i> Batal
                    </button>
                    <button type="submit" class="approve-btn approve-btn-submit">
                        <i class="fa-solid fa-check"></i> Setujui
                    </button>
                </div>
            </form>
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
let currentApproveId = null;

// PAGINATION VARIABLES
let currentPage = 1;
let totalPages = 1;
let pageSize = 10;
let filteredData = [];
let allRows = [];

// Initialize Pagination
document.addEventListener('DOMContentLoaded', function() {
    initializePagination();
    setupEventListeners();
});

function initializePagination() {
    // Get all data rows
    allRows = Array.from(document.querySelectorAll('#tableBody tr.data-row'));
    filteredData = [...allRows];
    
    // Set page size from select or default
    pageSize = parseInt(document.getElementById('pageSizeSelect').value) || 10;
    
    // Calculate total pages
    totalPages = Math.ceil(allRows.length / pageSize);
    
    // Show first page
    updateTable();
    updatePaginationControls();
}

function setupEventListeners() {
    const searchInput = document.getElementById('searchInput');
    const statusSelect = document.getElementById('statusSelect');
    const pageSizeSelect = document.getElementById('pageSizeSelect');
    
    // Search input with debounce
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            currentPage = 1; // Reset to first page on search
            filterTable();
        }, 300);
    });
    
    // Status filter
    statusSelect.addEventListener('change', function() {
        currentPage = 1; // Reset to first page on filter change
        filterTable();
    });
    
    // Page size change
    pageSizeSelect.addEventListener('change', function() {
        pageSize = parseInt(this.value);
        currentPage = 1; // Reset to first page on size change
        totalPages = Math.ceil(filteredData.length / pageSize);
        updateTable();
        updatePaginationControls();
    });
}

function filterTable() {
    const searchValue = document.getElementById('searchInput').value.toLowerCase().trim();
    const statusValue = document.getElementById('statusSelect').value;
    
    filteredData = allRows.filter(row => {
        const rowStatus = row.getAttribute('data-status');
        const rowNama = row.getAttribute('data-nama');
        const rowPenyelenggara = row.getAttribute('data-penyelenggara');
        const rowJenis = row.getAttribute('data-jenis');
        
        // Check status filter
        const statusMatch = !statusValue || rowStatus === statusValue;
        
        // Check search filter
        const searchMatch = !searchValue || 
            rowNama.includes(searchValue) || 
            rowPenyelenggara.includes(searchValue) || 
            rowJenis.includes(searchValue);
        
        return statusMatch && searchMatch;
    });
    
    totalPages = Math.ceil(filteredData.length / pageSize);
    if (currentPage > totalPages) {
        currentPage = totalPages || 1;
    }
    
    updateTable();
    updatePaginationControls();
}

function updateTable() {
    // Hide all rows
    allRows.forEach(row => row.style.display = 'none');
    
    // Show empty message if no data
    const emptyRow = document.getElementById('emptyRow');
    if (filteredData.length === 0) {
        if (emptyRow) emptyRow.style.display = '';
        return;
    }
    
    if (emptyRow) emptyRow.style.display = 'none';
    
    // Calculate start and end index for current page
    const startIndex = (currentPage - 1) * pageSize;
    const endIndex = Math.min(startIndex + pageSize, filteredData.length);
    
    // Show only rows for current page
    for (let i = startIndex; i < endIndex; i++) {
        const row = filteredData[i];
        if (row) {
            row.style.display = '';
            // Update row number
            const rowNumberCell = row.querySelector('.row-number');
            if (rowNumberCell) {
                rowNumberCell.textContent = i + 1;
            }
        }
    }
}

function updatePaginationControls() {
    const pageNumbers = document.getElementById('pageNumbers');
    const pageInfoText = document.getElementById('pageInfoText');
    const prevPageBtn = document.getElementById('prevPageBtn');
    const nextPageBtn = document.getElementById('nextPageBtn');
    const firstPageBtn = document.getElementById('firstPageBtn');
    const lastPageBtn = document.getElementById('lastPageBtn');
    
    // Update page info
    const startIndex = (currentPage - 1) * pageSize + 1;
    const endIndex = Math.min(currentPage * pageSize, filteredData.length);
    const totalData = filteredData.length;
    
    pageInfoText.textContent = filteredData.length > 0 
        ? `Menampilkan ${startIndex}-${endIndex} dari ${totalData} data` 
        : 'Tidak ada data';
    
    // Update button states
    prevPageBtn.disabled = currentPage <= 1;
    prevPageBtn.classList.toggle('disabled', currentPage <= 1);
    nextPageBtn.disabled = currentPage >= totalPages;
    nextPageBtn.classList.toggle('disabled', currentPage >= totalPages);
    firstPageBtn.disabled = currentPage <= 1;
    firstPageBtn.classList.toggle('disabled', currentPage <= 1);
    lastPageBtn.disabled = currentPage >= totalPages;
    lastPageBtn.classList.toggle('disabled', currentPage >= totalPages);
    
    // Generate page number buttons
    pageNumbers.innerHTML = '';
    
    // Always show first page
    pageNumbers.appendChild(createPageButton(1));
    
    // Calculate range of pages to show
    let startPage = Math.max(2, currentPage - 2);
    let endPage = Math.min(totalPages - 1, currentPage + 2);
    
    // Adjust if near start
    if (currentPage <= 3) {
        endPage = Math.min(5, totalPages - 1);
    }
    
    // Adjust if near end
    if (currentPage >= totalPages - 2) {
        startPage = Math.max(2, totalPages - 4);
    }
    
    // Add ellipsis after first page if needed
    if (startPage > 2) {
        const ellipsis = document.createElement('span');
        ellipsis.className = 'pagination-btn disabled';
        ellipsis.textContent = '...';
        ellipsis.style.cursor = 'default';
        pageNumbers.appendChild(ellipsis);
    }
    
    // Add middle pages
    for (let i = startPage; i <= endPage; i++) {
        pageNumbers.appendChild(createPageButton(i));
    }
    
    // Add ellipsis before last page if needed
    if (endPage < totalPages - 1) {
        const ellipsis = document.createElement('span');
        ellipsis.className = 'pagination-btn disabled';
        ellipsis.textContent = '...';
        ellipsis.style.cursor = 'default';
        pageNumbers.appendChild(ellipsis);
    }
    
    // Always show last page if there is more than one page
    if (totalPages > 1) {
        pageNumbers.appendChild(createPageButton(totalPages));
    }
}

function createPageButton(pageNum) {
    const button = document.createElement('button');
    button.className = 'pagination-btn';
    if (pageNum === currentPage) {
        button.classList.add('active');
    }
    button.textContent = pageNum;
    button.onclick = () => changePage(pageNum);
    return button;
}

function changePage(page) {
    if (page < 1 || page > totalPages || page === currentPage) return;
    currentPage = page;
    updateTable();
    updatePaginationControls();
}

function prevPage() {
    if (currentPage > 1) {
        changePage(currentPage - 1);
    }
}

function nextPage() {
    if (currentPage < totalPages) {
        changePage(currentPage + 1);
    }
}

function resetFilter() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusSelect').value = '';
    currentPage = 1;
    filterTable();
}

// PERBAIKAN: Fungsi untuk mengambil data detail via AJAX
function getSuratDetail(id) {
    return fetch('<?= site_url("kaprodi/getDetailPengajuan/") ?>' + id)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                return data.data;
            } else {
                throw new Error(data.message || 'Gagal memuat data');
            }
        })
        .catch(error => {
            console.error('Error fetching detail:', error);
            throw error;
        });
}

// Preview File Functions
function previewFile(fileUrl, fileName) {
    console.log('Preview File:', {
        fileName: fileName,
        fileUrl: fileUrl,
        fullUrl: fileUrl
    });
    
    const previewModal = document.getElementById('previewModal');
    const previewTitle = document.getElementById('previewTitle');
    const previewBody = document.getElementById('previewBody');
    
    previewTitle.textContent = 'Preview: ' + fileName;
    previewBody.innerHTML = `
        <div style="text-align: center; padding: 40px;">
            <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #8E44AD;"></i>
            <p style="margin-top: 15px; color: #6c757d;">Memuat preview...</p>
        </div>
    `;
    
    previewModal.classList.add('show');

    const fileExtension = fileName.split('.').pop().toLowerCase();
    const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
    const pdfExtensions = ['pdf'];
    
    setTimeout(() => {
        if (imageExtensions.includes(fileExtension)) {
            const img = new Image();
            img.onload = function() {
                console.log('Image loaded successfully');
                previewBody.innerHTML = `<img src="${fileUrl}" class="preview-image" alt="${fileName}">`;
            };
            img.onerror = function() {
                console.error('Error loading image:', fileUrl);
                showUnsupportedPreview(fileUrl, fileName);
            };
            img.src = fileUrl;
        } else if (pdfExtensions.includes(fileExtension)) {
            previewBody.innerHTML = `
                <iframe 
                    src="${fileUrl}" 
                    class="preview-iframe" 
                    frameborder="0"
                ></iframe>
            `;
        } else {
            showUnsupportedPreview(fileUrl, fileName);
        }
    }, 100);
}

function showUnsupportedPreview(fileUrl, fileName) {
    document.getElementById('previewBody').innerHTML = `
        <div class="preview-unsupported">
            <i class="fas fa-eye-slash"></i>
            <h4>Preview Tidak Tersedia</h4>
            <p>File "${escapeHtml(fileName)}" tidak dapat dipreview di browser.</p>
            <a href="${fileUrl}" class="download-btn" download="${fileName}" target="_blank" style="margin-top: 15px;">
                <i class="fas fa-download"></i> Download File
            </a>
        </div>
    `;
}

function closePreviewModal() {
    document.getElementById('previewModal').classList.remove('show');
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
        if (e.target.id === 'previewModal') {
            closePreviewModal();
        }
    });
});

// PERBAIKAN UTAMA: Function showDetail yang sudah diperbaiki dengan PERIODE
async function showDetail(id) {
    try {
        // Tampilkan loading
        document.getElementById('detailContent').innerHTML = `
            <div style="text-align:center;padding:40px;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#8E44AD"></i>
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

        // DEBUG: Tampilkan semua data di console untuk troubleshooting
        console.log('Data detail untuk ID', id, ':', item);

        // Fungsi helper untuk mendapatkan value
        const getVal = (k) => {
            const value = (item[k] !== undefined && item[k] !== null && item[k] !== '' ? item[k] : '-');
            console.log(`Field ${k}:`, value); // Debug setiap field
            return value;
        };

        // Format status dengan badge
        const status = getVal('status');
        let statusBadge = '';
        if (status.toLowerCase() === 'disetujui kaprodi') {
            statusBadge = '<span class="badge badge-completed" style="margin-left:10px">Disetujui</span>';
        } else if (status.toLowerCase() === 'disetujui sekretariat') {
            statusBadge = '<span class="badge badge-approved" style="margin-left:10px">Disetujui Sekretariat</span>';
        } else if (status.toLowerCase().includes('ditolak')) {
            statusBadge = '<span class="badge badge-rejected" style="margin-left:10px">Ditolak</span>';
        } else {
            statusBadge = '<span class="badge badge-pending" style="margin-left:10px">Menunggu</span>';
        }

        // PERBAIKAN UTAMA: Gunakan langsung dosen_data dari response
        let dosenData = [];
        
        if (item.dosen_data && Array.isArray(item.dosen_data) && item.dosen_data.length > 0) {
            dosenData = item.dosen_data;
        } else {
            dosenData = [{
                nama: getVal('nama_dosen') !== '-' ? getVal('nama_dosen') : 'Data dosen tidak tersedia',
                nip: getVal('nip') !== '-' ? getVal('nip') : '-',
                jabatan: '-',
                divisi: '-'
            }];
        }

        // Generate file evidence HTML
        let fileEvidenceHtml = '';
        const evidenValue = getVal('eviden');
        
        if (evidenValue && evidenValue !== '-') {
            let evidenFiles = [];
            
            try {
                if (evidenValue.startsWith('[') || evidenValue.startsWith('{')) {
                    const parsed = JSON.parse(evidenValue);
                    if (Array.isArray(parsed)) {
                        evidenFiles = parsed;
                    } else if (parsed.url) {
                        evidenFiles = [parsed.url];
                    }
                } else {
                    evidenFiles = [evidenValue];
                }
            } catch (e) {
                evidenFiles = [evidenValue];
            }
            
            if (evidenFiles.length > 0) {
                fileEvidenceHtml = `
                <div class="detail-section">
                    <div class="detail-section-title">
                        <i class="fa-solid fa-paperclip"></i> File Evidence (${evidenFiles.length} file)
                    </div>
                    <div class="file-evidence">`;
                
                evidenFiles.forEach((file, index) => {
                    let fileName = file;
                    let fileUrl = file;
                    
                    if (!file.startsWith('http://') && !file.startsWith('https://')) {
                        fileName = file.split('/').pop();
                        fileUrl = '<?= base_url("uploads/eviden/") ?>' + fileName;
                    } else {
                        fileName = file.split('/').pop();
                    }
                    
                    const ext = fileName.split('.').pop().toLowerCase();
                    let fileIcon = 'fa-file';
                    let canPreview = false;
                    
                    if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(ext)) {
                        fileIcon = 'fa-file-image';
                        canPreview = true;
                    } else if (ext === 'pdf') {
                        fileIcon = 'fa-file-pdf';
                        canPreview = true;
                    } else if (['doc', 'docx'].includes(ext)) {
                        fileIcon = 'fa-file-word';
                    } else if (['xls', 'xlsx'].includes(ext)) {
                        fileIcon = 'fa-file-excel';
                    }
                    
                    fileEvidenceHtml += `
                        <div class="file-item">
                            <div class="file-icon">
                                <i class="fa-solid ${fileIcon}"></i>
                            </div>
                            <div class="file-info" ${canPreview ? `onclick="previewFile('${fileUrl}', '${fileName}')" style="cursor: pointer;"` : ''}>
                                <div class="file-name" ${canPreview ? 'title="Klik untuk preview"' : ''}>${escapeHtml(fileName)}</div>
                                <div class="file-size">File ${index + 1} • ${ext.toUpperCase()}</div>
                            </div>
                            ${canPreview ? 
                                `<button class="preview-btn" onclick="previewFile('${fileUrl}', '${fileName}')">
                                    <i class="fa-solid fa-eye"></i> Preview
                                </button>` :
                                `<button class="preview-btn disabled" disabled title="Preview tidak tersedia">
                                    <i class="fa-solid fa-eye-slash"></i> Preview
                                </button>`
                            }
                            <a href="${fileUrl}" target="_blank" class="download-btn" download="${fileName}">
                                <i class="fa-solid fa-download"></i> Download
                            </a>
                        </div>`;
                });
                
                fileEvidenceHtml += `
                    </div>
                </div>`;
            }
        }

        // PERBAIKAN UTAMA: Format Periode Kegiatan berdasarkan jenis_date
        const jenisDate = getVal('jenis_date');
        const periodeKegiatan = getVal('periode_kegiatan');
        const tanggalKegiatan = getVal('tanggal_kegiatan');
        const akhirKegiatan = getVal('akhir_kegiatan');
        
        // DEBUG: Tampilkan data periode di console
        console.log('Jenis Date:', jenisDate);
        console.log('Periode Kegiatan:', periodeKegiatan);
        console.log('Tanggal Kegiatan:', tanggalKegiatan);
        console.log('Akhir Kegiatan:', akhirKegiatan);
        
        // Tentukan tampilan untuk Periode Kegiatan
        let periodeDisplay = '-';
        if (jenisDate === 'Periode') {
            // Jika memilih Periode, tampilkan nilai periode yang dipilih
            periodeDisplay = periodeKegiatan !== '-' ? periodeKegiatan : '-';
            console.log('Periode Display (Periode):', periodeDisplay);
        } else if (jenisDate === 'Custom') {
            // Jika memilih Custom, tampilkan range tanggal
            if (tanggalKegiatan !== '-' && akhirKegiatan !== '-') {
                periodeDisplay = formatDate(tanggalKegiatan) + ' - ' + formatDate(akhirKegiatan);
            }
            console.log('Periode Display (Custom):', periodeDisplay);
        }

        // Format tanggal mulai
        const tanggalMulaiDisplay = tanggalKegiatan !== '-' ? formatDate(tanggalKegiatan) : '-';

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

            <div class="detail-section">
                <div class="detail-section-title">
                    <i class="fa-solid fa-user-tie"></i> Dosen Terkait
                    <span style="font-size:12px;color:#6c757d;margin-left:auto">(${dosenData.length} dosen)</span>
                </div>
                <div class="dosen-list">
                    ${dosenData.map((dosen, index) => {
                        const nama = dosen.nama || 'Data tidak tersedia';
                        const initial = nama && nama !== 'Data tidak tersedia' ? nama.charAt(0).toUpperCase() : '?';
                        const nip = dosen.nip || '-';
                        const jabatan = dosen.jabatan || '-';
                        const divisi = dosen.divisi || '-';
                        
                        return `
                        <div class="dosen-item">
                            <div class="dosen-avatar">${initial}</div>
                            <div class="dosen-info">
                                <div class="dosen-name">${escapeHtml(nama)}</div>
                                <div class="dosen-details">
                                    NIP: ${escapeHtml(nip)} | 
                                    Jabatan: ${escapeHtml(jabatan)} | 
                                    Divisi: ${escapeHtml(divisi)}
                                </div>
                            </div>
                        </div>
                        `;
                    }).join('')}
                </div>
            </div>

            <!-- PERBAIKAN UTAMA: Bagian Informasi Waktu & Tempat yang disamakan dengan dashboard -->
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
                        <div class="detail-label">Jenis Tanggal</div>
                        <div class="detail-value">${escapeHtml(jenisDate !== '-' ? jenisDate : '-')}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Periode Kegiatan</div>
                        <div class="detail-value">${escapeHtml(periodeDisplay)}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Tanggal Mulai</div>
                        <div class="detail-value">${tanggalMulaiDisplay}</div>
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

            ${fileEvidenceHtml}

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

            ${ (item.status && item.status.toLowerCase() === 'pengajuan') ? `
            <div class="modal-actions">
                <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal')">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
                <button class="modal-btn modal-btn-reject" onclick="showRejectModal(${item.id}); closeModal('detailModal')">
                    <i class="fa-solid fa-times"></i> Tolak
                </button>
                <button class="modal-btn modal-btn-approve" onclick="showApproveModal(${item.id}, '${escapeHtml(item.nama_kegiatan)}'); closeModal('detailModal')">
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

function showApproveModal(id, namaKegiatan) {
    currentApproveId = id;
    document.getElementById('approveNamaKegiatan').textContent = namaKegiatan;
    document.getElementById('nomorSurat').value = '';
    document.getElementById('approveForm').action = '<?= base_url("kaprodi/approve/") ?>' + id;
    document.getElementById('approveModal').classList.add('show');
    
    // Auto focus ke input nomor surat
    setTimeout(() => {
        document.getElementById('nomorSurat').focus();
    }, 300);
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

// Helper functions
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
</script>
</body>
</html>