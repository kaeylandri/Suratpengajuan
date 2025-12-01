<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Sekretariat</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;background:#f5f7fa;}
    .navbar{background:#16A085;color:white;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
    .navbar h2{font-size:20px;}
    .container{max-width:1200px;margin:30px auto;padding:0 20px;}
    .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:20px;}
    .stat-card{background:white;padding:20px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.06);border-left:4px solid #3498db;transition:all 0.3s ease;cursor:pointer;text-decoration:none;display:block;color:inherit}
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
    .badge-completed{background:#d1ecf1;color:#0c5460}
    .btn{padding:6px 10px;border-radius:6px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s}
    .btn:hover{transform:scale(1.05)}
    .btn-approve{background:#27ae60;color:#fff}
    .btn-approve:hover{background:#229954}
    .btn-reject{background:#e74c3c;color:#fff}
    .btn-reject:hover{background:#c0392b}
    .btn-detail{background:#3498db;color:#fff}
    .btn-detail:hover{background:#2980b9}
    .chart-container{position:relative;height:450px;padding:20px}
    .filter-container{display:flex;gap:15px;margin-bottom:20px;flex-wrap:wrap}
    .filter-select{padding:10px 15px;border-radius:8px;border:2px solid #ddd;font-weight:600;cursor:pointer;min-width:200px}
    
    /* Modal Styles */
    .modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.45);align-items:center;justify-content:center}
    .modal.show{display:flex}
    .modal-content{background:white;padding:0;border-radius:15px;max-width:800px;width:95%;max-height:85vh;overflow:hidden;animation:slideIn 0.3s ease;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
    @keyframes slideIn{from{transform:translateY(-50px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-header{background:#16A085;color:white;padding:20px 25px;display:flex;justify-content:space-between;align-items:center;border-radius:15px 15px 0 0}
    .modal-header h3{margin:0;font-size:18px;font-weight:600}
    .close-modal{background:none;border:0;color:white;font-size:24px;cursor:pointer;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background 0.2s}
    .close-modal:hover{background:rgba(255,255,255,0.2)}
    
    /* Detail Content Styles - IMPROVED */
    .detail-content{padding:25px;max-height:calc(85vh - 80px);overflow-y:auto}
    .detail-section{margin-bottom:25px;background:#f8f9fa;border-radius:12px;padding:20px;border:1px solid #e9ecef}
    .detail-section:last-child{margin-bottom:0}
    .detail-section-title{font-size:16px;font-weight:700;color:#16A085;margin-bottom:15px;padding-bottom:10px;border-bottom:2px solid #16A085;display:flex;align-items:center;gap:10px}
    .detail-section-title i{font-size:18px}
    .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:15px}
    .detail-row{display:flex;flex-direction:column;margin-bottom:12px}
    .detail-label{font-weight:600;color:#495057;font-size:13px;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.5px}
    .detail-value{color:#212529;font-size:14px;background:white;padding:10px 15px;border-radius:8px;border:1px solid #e9ecef;min-height:40px;display:flex;align-items:center}
    .detail-value-empty{color:#6c757d;font-style:italic;background:#f8f9fa !important}
    
    /* Dosen list in detail */
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
        background: #16A085;
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
    .file-item:hover{background:#e8f6f3;border-color:#16A085}
    .file-icon{width:24px;height:24px;display:flex;align-items:center;justify-content:center;color:#16A085;font-size:16px}
    .file-info{flex:1}
    .file-name{font-weight:600;color:#212529;font-size:14px;cursor:pointer}
    .file-name:hover{color:#16A085}
    .file-size{font-size:12px;color:#6c757d}
    .preview-btn{background:#3498db;color:white;border:none;padding:8px 16px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;transition:background 0.2s;display:flex;align-items:center;gap:6px;text-decoration:none}
    .preview-btn:hover{background:#2980b9;color:white;text-decoration:none}
    .preview-btn.disabled{background:#bdc3c7;cursor:not-allowed;opacity:0.6}
    .preview-btn.disabled:hover{background:#bdc3c7}
    .download-btn{background:#16A085;color:white;border:none;padding:8px 16px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;transition:background 0.2s;display:flex;align-items:center;gap:6px;text-decoration:none}
    .download-btn:hover{background:#138D75;color:white;text-decoration:none}

    /* Preview Modal Styles */
    .preview-modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.8);z-index:10000;justify-content:center;align-items:center;padding:20px}
    .preview-modal.show{display:flex}
    .preview-content{background:white;border-radius:12px;width:90%;max-width:900px;max-height:90vh;overflow:hidden;display:flex;flex-direction:column}
    .preview-header{background:#16A085;color:white;padding:15px 20px;display:flex;justify-content:space-between;align-items:center}
    .preview-header h3{margin:0;font-size:16px;font-weight:600}
    .preview-close{background:none;border:none;color:white;font-size:24px;cursor:pointer;padding:0;width:30px;height:30px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background 0.2s}
    .preview-close:hover{background:rgba(255,255,255,0.2)}
    .preview-body{flex:1;padding:0;display:flex;justify-content:center;align-items:center;background:#f8f9fa;min-height:400px}
    .preview-iframe{width:100%;height:70vh;border:none}
    .preview-image{max-width:100%;max-height:70vh;object-fit:contain}
    .preview-unsupported{text-align:center;padding:40px;color:#6c757d}
    .preview-unsupported i{font-size:48px;margin-bottom:15px;color:#16A085}
    
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
    .approve-modal-header{background:#16A085;color:white;padding:20px 25px;display:flex;justify-content:space-between;align-items:center;border-radius:15px 15px 0 0}
    .approve-modal-header h3{margin:0;font-size:18px;font-weight:600}
    .approve-info-box{background:#e8f6f3;border:1px solid #16A085;border-radius:8px;padding:15px;margin-bottom:20px}
    .approve-info-box strong{color:#16A085;display:block;margin-bottom:5px}
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
    
    /* Status Button Styles */
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
        background: #16A085;
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
    }
    /* Google-style Autocomplete */
.autocomplete-box-fixed {
    position: fixed;
    background: #fff;
    border: none;
    z-index: 9999999;
    max-height: 400px;
    overflow-y: auto;
    box-shadow: 0 4px 6px rgba(32,33,36,0.28);
    border-radius: 24px;
    font-size: 14px;
    padding: 8px 0;
    margin-top: 8px;
    font-family: 'Poppins', sans-serif;
    min-width: 300px;
}

.autocomplete-item {
    padding: 0;
    cursor: pointer;
    transition: background-color 0.1s ease;
    border: none;
    line-height: 1.4;
    display: flex;
    align-items: center;
    gap: 16px;
    position: relative;
}

.autocomplete-item:hover,
.autocomplete-item.active {
    background: #f8f9fa;
}

.autocomplete-icon {
    width: 20px;
    height: 20px;
    margin-left: 16px;
    flex-shrink: 0;
    opacity: 0.54;
}

.autocomplete-icon svg {
    width: 20px;
    height: 20px;
    fill: #5f6368;
}

.autocomplete-content {
    display: flex;
    flex-direction: column;
    gap: 2px;
    padding: 12px 16px 12px 0;
    flex: 1;
    min-width: 0;
}

.autocomplete-item .item-primary {
    font-size: 14px;
    color: #202124;
    font-weight: 400;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.autocomplete-item .item-secondary {
    font-size: 12px;
    color: #70757a;
    font-weight: 400;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.query-match {
    font-weight: 600;
    color: #1a73e8; /* Warna biru untuk sekretariat */
}

.autocomplete-item:first-child {
    border-left: 3px solid #1a73e8;
}

.autocomplete-loading,
.autocomplete-empty {
    padding: 16px 20px;
    text-align: center;
    color: #70757a;
    font-size: 13px;
}

.autocomplete-box-fixed::-webkit-scrollbar {
    width: 10px;
}

.autocomplete-box-fixed::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.autocomplete-box-fixed::-webkit-scrollbar-thumb {
    background: #dadce0;
    border-radius: 10px;
    border: 2px solid #fff;
}

.autocomplete-box-fixed::-webkit-scrollbar-thumb:hover {
    background: #bdc1c6;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
</head>
<body>

<div class="navbar">
    <h2><i class="fa-solid fa-clipboard-list"></i> Dashboard Sekretariat</h2>
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
    $total_all = isset($total_surat) ? (int)$total_surat : 0;
    $pending_count = isset($pending_count) ? (int)$pending_count : 0;
    $approved_count = isset($approved_count) ? (int)$approved_count : 0;
    $rejected_count = isset($rejected_count) ? (int)$rejected_count : 0;
    ?>

    <div class="stats-grid">
        <a href="<?= base_url('sekretariat/semua') ?>" class="stat-card" style="border-left-color:#3498db;">
            <h3><i class="fa-solid fa-folder"></i> Total Pengajuan</h3>
            <div class="number"><?= $total_all ?></div>
        </a>
        
        <a href="<?= base_url('sekretariat/pending') ?>" class="stat-card" style="border-left-color:#f39c12;">
            <h3><i class="fa-solid fa-clock"></i> Menunggu Persetujuan</h3>
            <div class="number"><?= $pending_count ?></div>
        </a>
        
        <a href="<?= base_url('sekretariat/disetujui') ?>" class="stat-card" style="border-left-color:#27ae60;">
            <h3><i class="fa-solid fa-check-circle"></i> Disetujui</h3>
            <div class="number"><?= $approved_count ?></div>
        </a>
        
        <a href="<?= base_url('sekretariat/ditolak') ?>" class="stat-card" style="border-left-color:#e74c3c;">
            <h3><i class="fa-solid fa-times-circle"></i> Ditolak</h3>
            <div class="number"><?= $rejected_count ?></div>
        </a>
    </div>

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
                    <option value="<?= $y ?>" <?= ($selectedYear == $y ? 'selected' : '') ?>>Tahun <?= $y ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>

    <div class="card" style="background: linear-gradient(135deg, #ffffffff 0%, #ffffffff 100%);">
        <div class="card-header" style="border-bottom-color: rgba(0, 0, 0, 0.1)">
            <strong style="color: #000000ff"><i class="fa-solid fa-chart-bar"></i> Grafik Pengajuan Sekretariat — Tahun <?= isset($tahun) ? $tahun : date('Y') ?></strong>
        </div>
        <div class="chart-container">
            <canvas id="grafikSurat"></canvas>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-table"></i> Daftar Pengajuan Surat</h3>
            <div>
                <span id="filterInfo" style="color:#7f8c8d;font-size:13px">Menampilkan: Semua Data (<?= count($surat_list ?? []) ?>)</span>
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php if(isset($surat_list) && !empty($surat_list)): $no=1; foreach($surat_list as $s): 
                        $status = $s->status ?? '';
                        $st_key = 'unknown';
                        $badge_text = ucwords($status);
                        
                        if ($status == 'disetujui KK') {
                            $st_key = 'pending';
                            $badge = '<span class="badge badge-pending">Menunggu</span>';
                        } elseif ($status == 'disetujui sekretariat') {
                            $st_key = 'approved';
                            $badge = '<span class="badge badge-approved">Disetujui Sekretariat</span>';
                        } elseif ($status == 'ditolak sekretariat') {
                            $st_key = 'rejected';
                            $badge = '<span class="badge badge-rejected">Ditolak Sekretariat</span>';
                        } elseif ($status == 'disetujui dekan') {
                            $st_key = 'completed';
                            $badge = '<span class="badge badge-completed">Disetujui Dekan</span>';
                        } elseif ($status == 'ditolak dekan') {
                            $st_key = 'rejected';
                            $badge = '<span class="badge badge-rejected">Ditolak Dekan</span>';
                        } elseif (strpos($status, 'pengajuan') !== false || strpos($status, 'pending') !== false || strpos($status, 'menunggu') !== false) {
                            $st_key = 'pending';
                            $badge = '<span class="badge badge-pending">' . $badge_text . '</span>';
                        } elseif (strpos($status, 'setuju') !== false || strpos($status, 'approved') !== false) {
                            $st_key = 'approved';
                            $badge = '<span class="badge badge-approved">' . $badge_text . '</span>';
                        } elseif (strpos($status, 'tolak') !== false || strpos($status, 'rejected') !== false) {
                            $st_key = 'rejected';
                            $badge = '<span class="badge badge-rejected">' . $badge_text . '</span>';
                        } else {
                            $st_key = 'unknown';
                            $badge = '<span class="badge badge-pending">' . $badge_text . '</span>';
                        }

                        $tgl_pengajuan = isset($s->created_at) && $s->created_at ? date('d M Y', strtotime($s->created_at)) : '-';
                        $tgl_kegiatan = isset($s->tanggal_kegiatan) && $s->tanggal_kegiatan ? date('d M Y', strtotime($s->tanggal_kegiatan)) : '-';
                    ?>
                    <tr data-status="<?= $st_key ?>">
                        <td><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($s->nama_kegiatan) ?></strong></td>
                        <td><?= htmlspecialchars($s->penyelenggara) ?></td>
                        <td><?= $tgl_pengajuan ?></td>
                        <td><?= $tgl_kegiatan ?></td>
                        <td><?= htmlspecialchars($s->jenis_pengajuan) ?></td>
                        <td><?= $badge ?></td>
                        <td>
<td>
    <div style="display:flex;gap:6px;flex-wrap:wrap">
        <button class="btn btn-status" title="Lihat Status" onclick="showStatusModal(<?= $s->id ?>)">
            <i class="fas fa-tasks"></i>
        </button>
        <button class="btn btn-detail" onclick="showDetail(<?= $s->id ?>)" title="Lihat Detail">
            <i class="fa-solid fa-eye"></i>
        </button>
        
        <?php if($status == 'disetujui KK'): ?>
            <button class="btn btn-approve" onclick="showApproveModal(<?= $s->id ?>, '<?= htmlspecialchars(addslashes($s->nama_kegiatan)) ?>')" title="Setujui & Teruskan ke Dekan">
                <i class="fa-solid fa-check"></i>
            </button>
            <button class="btn btn-reject" onclick="showRejectModal(<?= $s->id ?>)" title="Tolak Pengajuan">
                <i class="fa-solid fa-times"></i>
            </button>
        <?php endif; ?>
        
        <?php if($status == 'ditolak dekan'): ?>
            <a href="<?= site_url('sekretariat/edit_surat/' . $s->id) ?>" 
               class="btn btn-warning" 
               title="Edit & Ajukan Ulang ke Dekan"
               style="background:#ffc107;color:#000;border:none;border-radius:5px;padding:6px 10px;display:inline-flex;align-items:center;justify-content:center;gap:5px;transition:0.2s ease-in-out;font-size:14px;height:32px;text-decoration:none;">
                <i class="fas fa-edit"></i>
            </a>
        <?php endif; ?>
    </div>
</td>
                    </tr>
                    <?php endforeach; else: ?>
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
                <strong><i class="fa-solid fa-info-circle"></i> Informasi: Silahkan isi Nomor Surat sebelum disetujui</strong>
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
                    placeholder="Contoh: 001 SKT FT 2025" 
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
                        <i class="fa-solid fa-check"></i> Setujui & Teruskan
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

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Data dari controller
const suratList = <?= isset($surat_list) && !empty($surat_list) ? json_encode($surat_list) : '[]' ?>;
let currentRejectId = null;
let currentApproveId = null;

// PERBAIKAN: Fungsi untuk mengambil data detail via AJAX
function getSuratDetail(id) {
    return fetch('<?= site_url("sekretariat/getDetailPengajuan/") ?>' + id)
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
            <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #16A085;"></i>
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

// Existing Functions
function updateTahun(year) {
    window.location.href = "<?= base_url('sekretariat?tahun=') ?>" + year;
}

// PERBAIKAN FUNGSI showDetail - SEKRETARIAT (SAMA SEPERTI KAPRODI)
async function showDetail(id) {
    try {
        // Tampilkan loading
        document.getElementById('detailContent').innerHTML = `
            <div style="text-align:center;padding:40px;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#16A085"></i>
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

        // DEBUG: Tampilkan data di console
        console.log('Data detail lengkap:', item);

        // Fungsi helper untuk mendapatkan value
        const getVal = (k) => {
            const value = (item[k] !== undefined && item[k] !== null && item[k] !== '' ? item[k] : '-');
            return value;
        };

        // Format status dengan badge
        const status = getVal('status');
        let statusBadge = '';
        if (status.toLowerCase() === 'disetujui dekan') {
            statusBadge = '<span class="badge badge-completed" style="margin-left:10px">Disetujui Dekan</span>';
        } else if (status.toLowerCase() === 'disetujui sekretariat') {
            statusBadge = '<span class="badge badge-approved" style="margin-left:10px">Disetujui Sekretariat</span>';
        } else if (status.toLowerCase() === 'disetujui kk') {
            statusBadge = '<span class="badge badge-pending" style="margin-left:10px">Menunggu Sekretariat</span>';
        } else if (status.toLowerCase().includes('ditolak')) {
            statusBadge = '<span class="badge badge-rejected" style="margin-left:10px">Ditolak</span>';
        } else {
            statusBadge = '<span class="badge badge-pending" style="margin-left:10px">Menunggu</span>';
        }

        // Generate dosen data
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

        // LOGIKA BARU: Tentukan tampilan berdasarkan jenis_date (SAMA SEPERTI KAPRODI)
        const jenisDate = getVal('jenis_date');
        const periodeValue = getVal('periode_value');
        const tanggalKegiatan = getVal('tanggal_kegiatan');
        const akhirKegiatan = getVal('akhir_kegiatan');
        
        console.log('=== DEBUG PERIODE SEKRETARIAT ===');
        console.log('Jenis Date:', jenisDate);
        console.log('Periode Value:', periodeValue);
        console.log('Tanggal Kegiatan:', tanggalKegiatan);
        console.log('Akhir Kegiatan:', akhirKegiatan);
        
        // Tentukan tampilan untuk Periode dan Tanggal Mulai
        let periodeDisplay = '-';
        let tanggalMulaiDisplay = '-';
        let tanggalAkhirDisplay = '-';
        
        if (jenisDate === 'Periode') {
            // Jika Periode: tampilkan periode_value, kosongkan tanggal
            periodeDisplay = periodeValue !== '-' && periodeValue ? periodeValue : '-';
            tanggalMulaiDisplay = '-';
            tanggalAkhirDisplay = '-';
        } else if (jenisDate === 'Custom') {
            // Jika Custom: tampilkan tanggal, kosongkan periode
            periodeDisplay = '-';
            if (tanggalKegiatan !== '-' && tanggalKegiatan) {
                tanggalMulaiDisplay = formatDate(tanggalKegiatan);
            }
            if (akhirKegiatan !== '-' && akhirKegiatan) {
                tanggalAkhirDisplay = formatDate(akhirKegiatan);
            }
        } else {
            // Fallback jika jenis_date tidak ada (data lama)
            if (periodeValue && periodeValue !== '-') {
                periodeDisplay = periodeValue;
            } else if (tanggalKegiatan && tanggalKegiatan !== '-') {
                tanggalMulaiDisplay = formatDate(tanggalKegiatan);
                if (akhirKegiatan && akhirKegiatan !== '-') {
                    tanggalAkhirDisplay = formatDate(akhirKegiatan);
                }
            }
        }

        // Tampilkan Nomor Surat jika sudah ada
        let nomorSuratHtml = '';
        const nomorSurat = getVal('nomor_surat');
        if (nomorSurat && nomorSurat !== '-') {
            nomorSuratHtml = `
            <div class="nomor-surat-container">
                <div class="nomor-surat-label">
                    <i class="fa-solid fa-file-signature"></i> Nomor Surat
                </div>
                <div class="nomor-surat-value">${escapeHtml(nomorSurat)}</div>
            </div>`;
        }

        const content = `
            ${nomorSuratHtml}

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
                        <div class="detail-value ${periodeDisplay === '-' ? 'detail-value-empty' : ''}">${escapeHtml(periodeDisplay)}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Tanggal Mulai</div>
                        <div class="detail-value ${tanggalMulaiDisplay === '-' ? 'detail-value-empty' : ''}">${tanggalMulaiDisplay}</div>
                    </div>
                    ${tanggalAkhirDisplay !== '-' ? `
                    <div class="detail-row">
                        <div class="detail-label">Tanggal Akhir</div>
                        <div class="detail-value">${tanggalAkhirDisplay}</div>
                    </div>
                    ` : ''}
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

            ${ (item.status && item.status.toLowerCase() === 'disetujui kk') ? `
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
    document.getElementById('approveForm').action = '<?= base_url("sekretariat/approve/") ?>' + id;
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
    form.action = '<?= base_url("sekretariat/reject/") ?>' + currentRejectId;
    
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

// Grafik
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
                    let darkColor = datasetIndex === 0 ? 'rgba(0, 177, 253, 0.6)' : (datasetIndex === 1 ? 'rgba(46, 204, 113, 0.85)' : 'rgba(192, 57, 43, 0.6)');
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
/* ========================================
   AUTOCOMPLETE FUNCTIONALITY UNTUK DOSEN
======================================== */

/**
 * JavaScript autocomplete interactions - SAMA SEPERTI EDIT_SURAT BIASA
 */
const BASE_URL = '<?= rtrim(base_url(), "/") ?>';

// ===== AUTOCOMPLETE FUNCTIONALITY =====
let currentAutocompleteBox = null;
let currentKeydownHandler = null;
let currentClickHandler = null;
let currentInputElement = null;

// Debounce function
function debounce(fn, delay = 300) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => fn.apply(this, args), delay);
    };
}

// Highlight matching text
function highlightMatch(text, query) {
    if (!query || !text) return text;
    const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    const regex = new RegExp(`(${escapedQuery})`, 'gi');
    return text.replace(regex, '<span class="query-match">$1</span>');
}

// Remove existing autocomplete box
function removeAutocompleteBox() {
    if (currentAutocompleteBox) {
        currentAutocompleteBox.remove();
        currentAutocompleteBox = null;
    }
    if (currentKeydownHandler) {
        document.removeEventListener('keydown', currentKeydownHandler);
        currentKeydownHandler = null;
    }
    if (currentClickHandler) {
        document.removeEventListener('click', currentClickHandler);
        currentClickHandler = null;
    }
    currentInputElement = null;
}

// Fetch suggestions from database
async function fetchSuggestions(query, fieldType = 'nip') {
    if (!query) return [];
    
    try {
        // Gunakan endpoint yang sama seperti edit_surat biasa
        const response = await fetch(`${BASE_URL}/surat/autocomplete_nip?q=${encodeURIComponent(query)}&field=${fieldType}`);
        
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        
        const data = await response.json();
        return Array.isArray(data) ? data : [];
    } catch (error) {
        console.error('Autocomplete error:', error);
        return [];
    }
}

// Show suggestion box
function showSuggestionBox(inputEl, items, onSelect, fieldType) {
    removeAutocompleteBox();

    const rect = inputEl.getBoundingClientRect();
    const box = document.createElement('div');
    box.className = 'autocomplete-box-fixed';
    box.style.left = rect.left + 'px';
    box.style.top = (rect.bottom + 4) + 'px';
    box.style.width = Math.max(rect.width, 300) + 'px';

    if (!items || !items.length) {
        const empty = document.createElement('div');
        empty.className = 'autocomplete-empty';
        empty.textContent = 'Tidak ada data ditemukan';
        box.appendChild(empty);
        document.body.appendChild(box);
        currentAutocompleteBox = box;
        currentInputElement = inputEl;
        setTimeout(() => removeAutocompleteBox(), 2000);
        return;
    }

    const query = inputEl.value.trim();
    let selectedIndex = -1;

    items.forEach((item, idx) => {
        const option = document.createElement('div');
        option.className = `autocomplete-item type-${fieldType}`;
        
        let primaryText, secondaryText;
        
        switch(fieldType) {
            case 'nip':
                primaryText = highlightMatch(item.nip, query);
                secondaryText = item.nama_dosen;
                break;
            case 'nama_dosen':
                primaryText = highlightMatch(item.nama_dosen, query);
                secondaryText = `NIP: ${item.nip}`;
                break;
            case 'jabatan':
                primaryText = highlightMatch(item.jabatan, query);
                secondaryText = `${item.nama_dosen} (${item.nip})`;
                break;
            case 'divisi':
                primaryText = highlightMatch(item.divisi, query);
                secondaryText = `${item.nama_dosen} (${item.nip})`;
                break;
            default:
                primaryText = highlightMatch(item.nip, query);
                secondaryText = item.nama_dosen;
        }

        option.innerHTML = `
            <div class="autocomplete-icon">
                <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                </svg>
            </div>
            <div class="autocomplete-content">
                <div class="item-primary">${primaryText || '-'}</div>
                ${secondaryText ? '<div class="item-secondary">' + secondaryText + '</div>' : ''}
            </div>
        `;
        
        option.addEventListener('click', (e) => {
            e.stopPropagation();
            onSelect(item);
            removeAutocompleteBox();
        });
        
        box.appendChild(option);
    });

    document.body.appendChild(box);
    currentAutocompleteBox = box;
    currentInputElement = inputEl;

    // Keyboard navigation
    currentKeydownHandler = function(e) {
        if (!currentAutocompleteBox) return;
        
        const opts = currentAutocompleteBox.querySelectorAll('.autocomplete-item');
        if (!opts.length) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            selectedIndex = Math.min(selectedIndex + 1, opts.length - 1);
            opts.forEach((o, i) => o.classList.toggle('active', i === selectedIndex));
            if (opts[selectedIndex]) {
                opts[selectedIndex].scrollIntoView({ block: 'nearest' });
            }
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            selectedIndex = Math.max(selectedIndex - 1, 0);
            opts.forEach((o, i) => o.classList.toggle('active', i === selectedIndex));
            if (opts[selectedIndex]) {
                opts[selectedIndex].scrollIntoView({ block: 'nearest' });
            }
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (selectedIndex >= 0 && opts[selectedIndex]) {
                opts[selectedIndex].click();
            }
        } else if (e.key === 'Escape') {
            removeAutocompleteBox();
        }
    };
    
    document.addEventListener('keydown', currentKeydownHandler);

    // Close on outside click
    currentClickHandler = function(ev) {
        if (currentAutocompleteBox && !currentAutocompleteBox.contains(ev.target) && ev.target !== currentInputElement) {
            removeAutocompleteBox();
        }
    };
    document.addEventListener('click', currentClickHandler);
}

// Initialize autocomplete for a row
function initAutocompleteForRow(rowEl) {
    const inputNip = rowEl.querySelector('.nip-input');
    const inputNama = rowEl.querySelector('.nama-dosen-input');
    const inputJabatan = rowEl.querySelector('.jabatan-input');
    const inputDivisi = rowEl.querySelector('.divisi-input');

    if (!inputNip || !inputNama || !inputJabatan || !inputDivisi) {
        return;
    }

    // Fill all fields when item is selected
    function fillRowWith(item) {
        if (!item) return;
        
        inputNip.value = item.nip || '';
        inputNama.value = item.nama_dosen || '';
        inputJabatan.value = item.jabatan || '';
        inputDivisi.value = item.divisi || '';
    }

    // Create autocomplete handlers for each field
    function createAutocompleteHandler(fieldType, inputElement) {
        const handler = debounce(async function() {
            const val = this.value.trim();
            
            if (val.length < 2 || document.activeElement !== this) {
                removeAutocompleteBox();
                return;
            }

            const suggestions = await fetchSuggestions(val, fieldType);
            showSuggestionBox(inputElement, suggestions, fillRowWith, fieldType);
        }, 300);

        // Remove old event listener if exists
        if (inputElement._currentHandler) {
            inputElement.removeEventListener('input', inputElement._currentHandler);
        }
        
        // Save reference to new handler
        inputElement._currentHandler = handler;
        // Attach new event listener
        inputElement.addEventListener('input', handler);

        // Focus handlers
        inputElement.addEventListener('focus', () => {
            removeAutocompleteBox();
        });
        
        inputElement.addEventListener('blur', () => {
            setTimeout(() => {
                if (document.activeElement !== inputElement && 
                    (!currentAutocompleteBox || !currentAutocompleteBox.contains(document.activeElement))) {
                    removeAutocompleteBox();
                }
            }, 150);
        });
    }

    // Initialize autocomplete for all fields
    createAutocompleteHandler('nip', inputNip);
    createAutocompleteHandler('nama_dosen', inputNama);
    createAutocompleteHandler('jabatan', inputJabatan);
    createAutocompleteHandler('divisi', inputDivisi);
}

// Initialize semua baris dosen
$(document).ready(function(){
    // Initialize autocomplete for existing rows
    document.querySelectorAll('.dosen-row').forEach(row => {
        initAutocompleteForRow(row);
    });

    // ==========================================
    // MODIFIKASI FUNGSI TAMBAH BARIS DOSEN
    // ==========================================
    $("#addRow").off('click').click(function(){
        const rowIndex = $('#dosen_table tbody tr').length;
        const newRow = $(`<tr class="dosen-row" style="opacity:0;transform:translateY(-10px);" data-row-index="${rowIndex}">
            <td><input type="text" name="nip[]" class="form-control nip-input" required></td>
            <td><input type="text" name="nama_dosen[]" class="form-control nama-dosen-input" required></td>
            <td><input type="text" name="jabatan[]" class="form-control jabatan-input"></td>
            <td><input type="text" name="divisi[]" class="form-control divisi-input"></td>
            <td><span class="remove-row" style="cursor:pointer;color:#ea4335;font-weight:bold;"><i class="fas fa-trash"></i></span></td>
        </tr>`).appendTo("#dosen_table tbody");
        
        setTimeout(()=>{ 
            newRow.css({'transition':'all 0.3s ease','opacity':'1','transform':'translateY(0)'});
            // Initialize autocomplete untuk baris baru
            initAutocompleteForRow(newRow[0]);
        }, 10);
    });

    // Close autocomplete when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.autocomplete-box-fixed') && 
            !e.target.closest('.nip-input') && 
            !e.target.closest('.nama-dosen-input') && 
            !e.target.closest('.jabatan-input') && 
            !e.target.closest('.divisi-input')) {
            removeAutocompleteBox();
        }
    });

    // Close autocomplete on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            removeAutocompleteBox();
        }
    });
});
</script>
</body>
</html>