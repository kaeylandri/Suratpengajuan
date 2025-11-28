<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengajuan Menunggu - Dashboard Sekretariat</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;background:#f5f7fa;}
    .navbar{background:#16A085;color:white;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
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
    .search-container{display:flex;align-items:center;gap:15px;margin-bottom:20px;flex-wrap:wrap;background:#f8f9fa;padding:15px;border-radius:10px;border:1px solid #e9ecef}
    .search-box{position:relative;flex:1;min-width:300px}
    .search-input{width:100%;padding:12px 45px 12px 15px;border:1px solid #ddd;border-radius:8px;font-size:14px;transition:all 0.3s;background:white}
    .search-input:focus{outline:none;border-color:#16A085;box-shadow:0 0 0 2px rgba(22,160,133,0.1)}
    .search-icon{position:absolute;right:15px;top:50%;transform:translateY(-50%);color:#6c757d}
    .btn-secondary{padding:10px 20px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#95a5a6;color:#fff;text-decoration:none}
    .btn-secondary:hover{background:#7f8c8d}
    .back-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#16A085;color:white;text-decoration:none;border-radius:8px;font-weight:600;transition:all 0.3s;margin-bottom:20px}
    .back-btn:hover{background:#138D75;transform:translateY(-2px)}
    .status-header{display:flex;align-items:center;gap:15px;margin-bottom:20px;padding:20px;background:white;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.06)}
    .status-icon{width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:24px}
    .status-icon.pending{background:#fff3cd;color:#f39c12}
    .status-info h1{margin:0;color:#2c3e50;font-size:28px}
    .status-info p{margin:5px 0 0 0;color:#7f8c8d;font-size:16px}
    .data-count-info {background:#e8f6f3;padding:10px 15px;border-radius:6px;margin-bottom:15px;font-size:14px;color:#2c3e50;border-left:4px solid #16A085;}
    
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
    .form-control:focus{outline:none;border-color:#16A085;box-shadow:0 0 0 3px rgba(22, 160, 133, 0.2)}
    .form-hint{color:#7f8c8d;font-size:12px;margin-top:5px;display:flex;align-items:center;gap:5px}
    .approve-modal-actions{display:flex;justify-content:flex-end;gap:12px;margin-top:25px;padding-top:20px;border-top:1px solid #e9ecef}
    .approve-btn{padding:10px 20px;border-radius:8px;border:none;cursor:pointer;font-weight:600;font-size:14px;transition:all 0.2s;display:flex;align-items:center;gap:8px}
    .approve-btn-cancel{background:#95a5a6;color:white}
    .approve-btn-cancel:hover{background:#7f8c8d;transform:translateY(-2px)}
    .approve-btn-submit{background:#27ae60;color:white}
    .approve-btn-submit:hover{background:#229954;transform:translateY(-2px)}
    
    /* Nomor Surat Styles */
    .nomor-surat-container {
        background: linear-gradient(135deg, #e8f6f3 0%, #d1f2eb 100%);
        border: 2px solid #16A085;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        text-align: center;
    }
    
    .nomor-surat-label {
        font-size: 14px;
        font-weight: 600;
        color: #16A085;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .nomor-surat-value {
        font-size: 18px;
        font-weight: 700;
        color: #117864;
        font-family: 'Courier New', monospace;
    }
    
    /* Reject Modal Styles */
    .reject-modal-content{background:white;padding:0;border-radius:15px;max-width:550px;width:95%;max-height:85vh;overflow:hidden;animation:slideIn 0.3s ease;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
    .reject-modal-body{padding:25px}
    .reject-modal-header{background:#e74c3c;color:white;padding:20px 25px;display:flex;justify-content:space-between;align-items:center;border-radius:15px 15px 0 0}
    .reject-modal-header h3{margin:0;font-size:18px;font-weight:600}
    .reject-info-box{background:#fdf2f2;border:1px solid #e74c3c;border-radius:8px;padding:15px;margin-bottom:20px}
    .reject-info-box strong{color:#e74c3c;display:block;margin-bottom:5px}
    .reject-info-box span{color:#2c3e50;font-weight:600}
    
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
    
    .bulk-select-info {
        color: #495057;
        font-size: 14px;
        margin-right: auto;
    }
    
    .bulk-btn {
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .bulk-btn-approve {
        background: #27ae60;
        color: white;
    }
    
    .bulk-btn-approve:hover {
        background: #229954;
        transform: translateY(-2px);
    }
    
    .bulk-btn-reject {
        background: #e74c3c;
        color: white;
    }
    
    .bulk-btn-reject:hover {
        background: #c0392b;
        transform: translateY(-2px);
    }
    
    .bulk-btn:disabled {
        background: #95a5a6;
        cursor: not-allowed;
        transform: none;
    }
    
    .select-all-checkbox {
        margin-right: 10px;
    }
    
    /* Checkbox Styles */
    .row-checkbox {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    
    /* Individual Input Styles for Bulk Actions */
    .bulk-item {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }
    
    .bulk-item-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .bulk-item-title {
        font-weight: 600;
        color: #2c3e50;
        font-size: 14px;
    }
    
    .bulk-item-actions {
        display: flex;
        gap: 8px;
    }
    
    .remove-item {
        background: #e74c3c;
        color: white;
        border: none;
        width: 24px;
        height: 24px;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }
    
    .bulk-items-container {
        max-height: 400px;
        overflow-y: auto;
        margin-bottom: 20px;
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
        .reject-modal-content{width:95%;margin:10px}
        .reject-modal-body{padding:15px}
        .search-container{flex-direction:column}
        .search-box{min-width:100%}
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
        .bulk-select-info {
            margin-right: 0;
            margin-bottom: 10px;
        }
        .bulk-item-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        .bulk-item-actions {
            align-self: flex-end;
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
    <!-- Tombol Kembali -->
    <a href="<?= base_url('sekretariat') ?>" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
    </a>

    <!-- Header Status -->

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
        
        <!-- Bulk Actions -->
        <div class="bulk-actions">
            <div>
                <input type="checkbox" id="selectAll" class="select-all-checkbox" onchange="toggleSelectAll()">
                <label for="selectAll">Pilih Semua</label>
            </div>
            <div class="bulk-select-info">
                <span id="selectedCount">0</span> item terpilih
            </div>
            <button class="bulk-btn bulk-btn-approve" id="bulkApproveBtn" onclick="showBulkApproveModal()" disabled>
                <i class="fa-solid fa-check"></i> Setujui Terpilih
            </button>
            <button class="bulk-btn bulk-btn-reject" id="bulkRejectBtn" onclick="showBulkRejectModal()" disabled>
                <i class="fa-solid fa-times"></i> Tolak Terpilih
            </button>
        </div>
        
        <!-- Info Jumlah Data -->
        <div class="data-count-info">
            <i class="fa-solid fa-info-circle"></i> 
            Menampilkan <strong><?= isset($surat_list) ? count($surat_list) : '0' ?></strong> dari <strong><?= isset($total_surat) ? $total_surat : '0' ?></strong> pengajuan menunggu persetujuan
        </div>
        
        <!-- Search Box -->
        <form method="get" action="<?= base_url('sekretariat/pending') ?>">
            <div class="search-container">
                <div class="search-box">
                    <input 
                        type="text" 
                        name="search" 
                        class="search-input"
                        placeholder="Cari berdasarkan nama kegiatan, penyelenggara, atau jenis pengajuan..."
                        value="<?= $this->input->get('search') ?>"
                    >
                    <div class="search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
                
                <button type="submit" class="btn-secondary" style="white-space:nowrap">
                    <i class="fa-solid fa-search"></i> Cari
                </button>
                
                <?php if($this->input->get('search')): ?>
                <a href="<?= base_url('sekretariat/pending') ?>" class="btn-secondary" style="white-space:nowrap">
                    <i class="fa-solid fa-refresh"></i> Reset
                </a>
                <?php endif; ?>
            </div>
        </form>
        
        <div style="overflow-x:auto">
            <table>
                <thead>
                    <tr>
                        <th style="width:30px">
                            <input type="checkbox" id="tableSelectAll" class="row-checkbox" onchange="toggleTableSelectAll()">
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
                            <input type="checkbox" class="row-checkbox row-select" value="<?= $s->id ?>" data-nama="<?= htmlspecialchars($s->nama_kegiatan ?? '') ?>" onchange="updateSelectedCount()">
                        </td>
                        <td><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($s->nama_kegiatan ?? '-') ?></strong></td>
                        <td><?= htmlspecialchars($s->penyelenggara ?? '-') ?></td>
                        <td><?= $tgl_pengajuan ?></td>
                        <td><?= $tgl_kegiatan ?></td>
                        <td><?= htmlspecialchars($s->jenis_pengajuan ?? '-') ?></td>
                        <td>
                            <span class="badge badge-pending">
                                Menunggu
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <!-- Tombol Status Progress Bar -->
                                <button class="btn btn-status" title="Lihat Status" onclick="showStatusModal(<?= $s->id ?>)">
                                    <i class="fas fa-tasks"></i>
                                </button>
                                <button class="btn btn-detail" onclick="showDetail(<?= $s->id ?? 0 ?>)" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button class="btn btn-approve" onclick="showApproveModal(<?= $s->id ?? 0 ?>, '<?= htmlspecialchars(addslashes($s->nama_kegiatan ?? '')) ?>')" title="Setujui">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                <button class="btn btn-reject" onclick="showRejectModal(<?= $s->id ?? 0 ?>)" title="Tolak">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; 
                    
                    else: ?>
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
                        <i class="fa-solid fa-check"></i> Setujui & Teruskan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bulk Approve Modal -->
<div id="bulkApproveModal" class="modal" onclick="modalClickOutside(event,'bulkApproveModal')">
    <div class="modal-content" onclick="event.stopPropagation()" style="max-width: 700px;">
        <div class="modal-header">
            <h3><i class="fa-solid fa-check-circle"></i> Setujui Pengajuan Terpilih</h3>
            <button class="close-modal" onclick="closeModal('bulkApproveModal')">&times;</button>
        </div>
        <div class="detail-content">
            <div class="approve-info-box">
                <strong><i class="fa-solid fa-info-circle"></i> Informasi:</strong>
                <span id="bulkApproveCount">0 pengajuan</span> akan disetujui. Silakan isi nomor surat untuk masing-masing pengajuan.
            </div>
            
            <form id="bulkApproveForm" method="POST" action="<?= base_url('sekretariat/bulk_approve') ?>">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <input type="hidden" name="ids" id="bulkApproveIds" value="">
                
                <div class="bulk-items-container" id="bulkApproveItems">
                    <!-- Items will be dynamically added here -->
                </div>

                <div class="modal-actions">
                    <button type="button" class="modal-btn modal-btn-close" onclick="closeModal('bulkApproveModal')">
                        <i class="fa-solid fa-times"></i> Batal
                    </button>
                    <button type="button" class="modal-btn modal-btn-approve" onclick="confirmBulkApprove()">
                        <i class="fa-solid fa-check"></i> Setujui Semua
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
        <div class="detail-content">
            <div class="detail-section">
                <div class="detail-section-title">
                    <i class="fa-solid fa-exclamation-triangle"></i> Konfirmasi Penolakan
                </div>
                <p style="color:#7f8c8d;margin-bottom:15px">Berikan alasan penolakan untuk pengajuan ini:</p>
                
                <div class="form-group">
                    <label for="rejectionNotes">
                        <i class="fa-solid fa-comment-dots"></i> Alasan Penolakan <span style="color:#e74c3c">*</span>
                    </label>
                    <textarea 
                        id="rejectionNotes" 
                        name="rejection_notes" 
                        rows="5" 
                        class="form-control" 
                        placeholder="Masukkan alasan penolakan secara detail..."
                        style="resize:vertical"
                    ></textarea>
                    <div class="form-hint">
                        <i class="fa-solid fa-exclamation-circle"></i> Alasan penolakan akan dikirimkan kepada pengaju
                    </div>
                </div>
            </div>

            <div class="modal-actions">
                <button class="modal-btn modal-btn-close" onclick="closeModal('rejectModal')">
                    <i class="fa-solid fa-times"></i> Batal
                </button>
                <button class="modal-btn modal-btn-reject" onclick="confirmReject()">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Penolakan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Reject Modal - FINAL VERSION -->
<div id="bulkRejectModal" class="modal" onclick="modalClickOutside(event,'bulkRejectModal')">
    <div class="modal-content" onclick="event.stopPropagation()" style="max-width: 700px;">
        <div class="modal-header">
            <h3><i class="fa-solid fa-ban"></i> Tolak Pengajuan Terpilih</h3>
            <button class="close-modal" onclick="closeModal('bulkRejectModal')">&times;</button>
        </div>
        <div class="detail-content">
            <div class="approve-info-box">
                <strong><i class="fa-solid fa-info-circle"></i> Informasi:</strong>
                <span id="bulkRejectCount">0 pengajuan</span> akan ditolak. Silakan berikan alasan penolakan untuk masing-masing pengajuan.
            </div>
            
            <!-- Form -->
            <form id="bulkRejectForm" method="POST" action="<?= base_url('sekretariat/bulk_reject') ?>">
                <!-- CSRF Token -->
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                
                <!-- Hidden Input IDs -->
                <input type="hidden" name="ids" id="bulkRejectIds" value="">
                
                <!-- Items Container -->
                <div class="bulk-items-container" id="bulkRejectItems">
                    <!-- Dynamically filled by JavaScript -->
                </div>

                <!-- Action Buttons -->
                <div class="modal-actions">
                    <button type="button" class="modal-btn modal-btn-close" onclick="closeModal('bulkRejectModal')">
                        <i class="fa-solid fa-times"></i> Batal
                    </button>
                    <!-- ✅ Gunakan onclick, bukan type="submit" -->
                    <button type="button" class="modal-btn modal-btn-reject" onclick="submitBulkReject()">
                        <i class="fa-solid fa-paper-plane"></i> Tolak Semua
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
let currentRejectId = null;
let currentApproveId = null;
let selectedIds = [];
let selectedItems = [];
// ✅ FUNCTION submitBulkReject - CLEAN & SIMPLE
function submitBulkReject() {
    console.log('=== SUBMIT BULK REJECT ===');
    
    const form = document.getElementById('bulkRejectForm');
    const idsInput = document.getElementById('bulkRejectIds');
    
    // Validasi form
    if (!form) {
        alert('Error: Form tidak ditemukan!');
        return;
    }
    
    // Set IDs jika kosong
    if (!idsInput.value || idsInput.value.trim() === '') {
        if (selectedIds.length === 0) {
            alert('Error: Tidak ada pengajuan yang dipilih!');
            return;
        }
        idsInput.value = selectedIds.join(',');
    }
    
    console.log('IDs Value:', idsInput.value);
    
    // Validasi textarea
    const textareas = form.querySelectorAll('textarea[name^="rejection_notes"]');
    let allValid = true;
    const errorMessages = [];
    
    textareas.forEach((textarea) => {
        if (!textarea.value.trim()) {
            allValid = false;
            const itemId = textarea.name.match(/\[(.*?)\]/)[1];
            const itemElement = document.getElementById(`reject-item-${itemId}`);
            const itemName = itemElement ? itemElement.querySelector('.bulk-item-title').textContent : 'ID: ' + itemId;
            errorMessages.push(`• ${itemName}`);
        }
    });
    
    if (!allValid) {
        alert('Alasan penolakan harus diisi untuk:\n\n' + errorMessages.join('\n'));
        return;
    }
    
    // Log form data untuk debug
    console.log('=== FORM DATA ===');
    const formData = new FormData(form);
    for (let [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
    }
    
    // Submit form
    console.log('Submitting form to:', form.action);
    form.submit();
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

// Bulk Selection Functions
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.row-select');
    const tableSelectAll = document.getElementById('tableSelectAll');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    tableSelectAll.checked = selectAll.checked;
    
    updateSelectedCount();
}

function toggleTableSelectAll() {
    const tableSelectAll = document.getElementById('tableSelectAll');
    const checkboxes = document.querySelectorAll('.row-select');
    const selectAll = document.getElementById('selectAll');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = tableSelectAll.checked;
    });
    selectAll.checked = tableSelectAll.checked;
    
    updateSelectedCount();
}

function updateSelectedCount() {
    const checkboxes = document.querySelectorAll('.row-select:checked');
    const selectedCount = checkboxes.length;
    
    document.getElementById('selectedCount').textContent = selectedCount;
    
    // Enable/disable bulk action buttons
    const bulkApproveBtn = document.getElementById('bulkApproveBtn');
    const bulkRejectBtn = document.getElementById('bulkRejectBtn');
    
    if (selectedCount > 0) {
        bulkApproveBtn.disabled = false;
        bulkRejectBtn.disabled = false;
    } else {
        bulkApproveBtn.disabled = true;
        bulkRejectBtn.disabled = true;
    }
    
    // Update selected IDs array and items data
    selectedIds = [];
    selectedItems = [];
    
    checkboxes.forEach(checkbox => {
        selectedIds.push(checkbox.value);
        selectedItems.push({
            id: checkbox.value,
            nama: checkbox.getAttribute('data-nama')
        });
    });
}

function showBulkApproveModal() {
    if (selectedIds.length === 0) return;
    
    document.getElementById('bulkApproveCount').textContent = selectedIds.length + ' pengajuan';
    document.getElementById('bulkApproveIds').value = selectedIds.join(',');
    
    const container = document.getElementById('bulkApproveItems');
    container.innerHTML = '';
    
    selectedItems.forEach((item, index) => {
        const itemHtml = `
            <div class="bulk-item" id="approve-item-${item.id}">
                <div class="bulk-item-header">
                    <div class="bulk-item-title">${item.nama}</div>
                    <div class="bulk-item-actions">
                        <button type="button" class="remove-item" onclick="removeBulkItem('${item.id}', 'approve')">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nomor_surat_${item.id}">
                        <i class="fa-solid fa-file-alt"></i> Nomor Surat <span style="color:#e74c3c">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="nomor_surat_${item.id}" 
                        name="nomor_surat[${item.id}]" 
                        class="form-control" 
                        placeholder="Contoh: 001/SKT/FT/2025" 
                        required
                        autocomplete="off"
                    >
                    <div class="form-hint">
                        <i class="fa-solid fa-exclamation-circle"></i> Format: 001/SKT/FT/Tahun
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += itemHtml;
    });
    
    document.getElementById('bulkApproveModal').classList.add('show');
}
// ✅ FUNCTION confirmBulkApprove YANG DIPERBAIKI
function confirmBulkApprove() {
    const form = document.getElementById('bulkApproveForm');
    const inputs = form.querySelectorAll('input[name^="nomor_surat"]');
    
    // Validasi semua input
    let allValid = true;
    const errorMessages = [];
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            allValid = false;
            const itemId = input.name.match(/\[(.*?)\]/)[1];
            const itemElement = document.getElementById(`approve-item-${itemId}`);
            const itemName = itemElement ? itemElement.querySelector('.bulk-item-title').textContent : 'Unknown';
            errorMessages.push(`Nomor surat harus diisi untuk: ${itemName}`);
        }
    });
    
    if (!allValid) {
        alert('Error:\n' + errorMessages.join('\n'));
        return;
    }
    
    // ✅ Submit form yang sudah ada
    form.submit();
}

/// ✅ FUNCTION confirmBulkReject - TANPA CONFIRM DIALOG
function confirmBulkReject(event) {
    console.log('=== CONFIRM BULK REJECT ===');
    
    if (event) {
        event.preventDefault();
    }
    
    const form = document.getElementById('bulkRejectForm');
    if (!form) {
        alert('Error: Form tidak ditemukan!');
        return false;
    }
    
    const idsInput = document.getElementById('bulkRejectIds');
    console.log('IDs Input Element:', idsInput);
    console.log('IDs Input Value:', idsInput ? idsInput.value : 'NULL');
    
    // ✅ Jika hidden input kosong, set ulang dari selectedIds
    if (!idsInput.value || idsInput.value.trim() === '') {
        console.warn('Hidden input kosong! Mencoba set ulang dari selectedIds...');
        
        if (selectedIds.length === 0) {
            alert('Error: Tidak ada pengajuan yang dipilih!\n\nSilakan tutup modal dan pilih pengajuan lagi.');
            return false;
        }
        
        idsInput.value = selectedIds.join(',');
        console.log('Hidden input di-set ulang ke:', idsInput.value);
    }
    
    const textareas = form.querySelectorAll('textarea[name^="rejection_notes"]');
    console.log('Total Textareas:', textareas.length);
    
    // Validasi textarea
    let allValid = true;
    const errorMessages = [];
    
    textareas.forEach((textarea) => {
        if (!textarea.value.trim()) {
            allValid = false;
            const itemId = textarea.name.match(/\[(.*?)\]/)[1];
            const itemElement = document.getElementById(`reject-item-${itemId}`);
            const itemName = itemElement ? itemElement.querySelector('.bulk-item-title').textContent : 'ID: ' + itemId;
            errorMessages.push(`Alasan penolakan harus diisi untuk: ${itemName}`);
        }
    });
    
    if (!allValid) {
        alert('Error:\n' + errorMessages.join('\n'));
        return false;
    }
    
    // ✅ HAPUS CONFIRM DIALOG - Langsung submit
    console.log('=== SUBMITTING FORM ===');
    console.log('Form Action:', form.action);
    console.log('Form Method:', form.method);
    console.log('IDs to submit:', idsInput.value);
    
    // Log all form data
    const formData = new FormData(form);
    console.log('=== FORM DATA ===');
    for (let [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
    }
    
    // Submit form
    form.submit();
    return false;
}
// ✅ FUNCTION showBulkRejectModal - PERBAIKAN FINAL
function showBulkRejectModal() {
    console.log('=== OPENING BULK REJECT MODAL ===');
    
    // ✅ PENTING: Update selected data DULU
    const checkboxes = document.querySelectorAll('.row-select:checked');
    
    selectedIds = [];
    selectedItems = [];
    
    checkboxes.forEach(checkbox => {
        const id = checkbox.value;
        const nama = checkbox.getAttribute('data-nama');
        
        selectedIds.push(id);
        selectedItems.push({
            id: id,
            nama: nama
        });
    });
    
    console.log('Selected IDs:', selectedIds);
    console.log('Selected Items:', selectedItems);
    
    // Validasi
    if (selectedIds.length === 0) {
        alert('Tidak ada pengajuan yang dipilih!');
        return;
    }
    
    // ✅ CRITICAL: Set hidden input VALUE
    const idsString = selectedIds.join(',');
    const hiddenInput = document.getElementById('bulkRejectIds');
    
    if (!hiddenInput) {
        alert('Error: Hidden input "bulkRejectIds" tidak ditemukan!');
        console.error('Hidden input bulkRejectIds not found in DOM');
        return;
    }
    
    hiddenInput.value = idsString;
    
    // Verify
    console.log('IDs String:', idsString);
    console.log('Hidden Input Value AFTER SET:', hiddenInput.value);
    console.log('Hidden Input Element:', hiddenInput);
    
    // Update count display
    document.getElementById('bulkRejectCount').textContent = selectedIds.length + ' pengajuan';
    
    // Build items HTML
    const container = document.getElementById('bulkRejectItems');
    container.innerHTML = '';
    
    selectedItems.forEach((item) => {
        const itemHtml = `
            <div class="bulk-item" id="reject-item-${item.id}">
                <div class="bulk-item-header">
                    <div class="bulk-item-title">${escapeHtml(item.nama)}</div>
                    <div class="bulk-item-actions">
                        <button type="button" class="remove-item" onclick="removeBulkItem('${item.id}', 'reject')">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="rejection_notes_${item.id}">
                        <i class="fa-solid fa-comment-dots"></i> Alasan Penolakan <span style="color:#e74c3c">*</span>
                    </label>
                    <textarea 
                        id="rejection_notes_${item.id}" 
                        name="rejection_notes[${item.id}]" 
                        rows="3" 
                        class="form-control" 
                        placeholder="Masukkan alasan penolakan untuk ${escapeHtml(item.nama)}..."
                        style="resize:vertical"
                        required
                    ></textarea>
                    <div class="form-hint">
                        <i class="fa-solid fa-exclamation-circle"></i> Alasan penolakan akan dikirimkan kepada pengaju
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += itemHtml;
    });
    
    // Show modal
    document.getElementById('bulkRejectModal').classList.add('show');
    
    // ✅ VERIFY AGAIN setelah modal terbuka
    setTimeout(() => {
        const verifyInput = document.getElementById('bulkRejectIds');
        console.log('VERIFICATION - Hidden Input Value:', verifyInput ? verifyInput.value : 'NOT FOUND');
        
        const firstTextarea = document.querySelector('#bulkRejectItems textarea');
        if (firstTextarea) {
            firstTextarea.focus();
        }
    }, 100);
}

// ✅ TAMBAH FUNCTION BARU: Update Selected Data
function updateSelectedData() {
    const checkboxes = document.querySelectorAll('.row-select:checked');
    
    selectedIds = [];
    selectedItems = [];
    
    checkboxes.forEach(checkbox => {
        const id = checkbox.value;
        const nama = checkbox.getAttribute('data-nama');
        
        selectedIds.push(id);
        selectedItems.push({
            id: id,
            nama: nama
        });
    });
    
    console.log('Updated selected data:', {
        ids: selectedIds,
        items: selectedItems
    });
}

// ✅ FUNCTION removeBulkItem YANG SUDAH ADA (pastikan update untuk reject juga)
function removeBulkItem(itemId, type) {
    // Remove from UI
    const itemElement = document.getElementById(`${type}-item-${itemId}`);
    if (itemElement) {
        itemElement.remove();
    }
    
    // Remove from selected arrays
    selectedIds = selectedIds.filter(id => id !== itemId);
    selectedItems = selectedItems.filter(item => item.id !== itemId);
    
    // Update count
    document.getElementById('selectedCount').textContent = selectedIds.length;
    
    // Update modal count and hidden input
    if (type === 'approve') {
        document.getElementById('bulkApproveCount').textContent = selectedIds.length + ' pengajuan';
        document.getElementById('bulkApproveIds').value = selectedIds.join(',');
    } else {
        document.getElementById('bulkRejectCount').textContent = selectedIds.length + ' pengajuan';
        document.getElementById('bulkRejectIds').value = selectedIds.join(',');
    }
    
    // Update checkbox state
    const checkbox = document.querySelector(`.row-select[value="${itemId}"]`);
    if (checkbox) {
        checkbox.checked = false;
    }
    
    // Update selectAll checkbox states
    const selectAll = document.getElementById('selectAll');
    const tableSelectAll = document.getElementById('tableSelectAll');
    const allCheckboxes = document.querySelectorAll('.row-select');
    const checkedCheckboxes = document.querySelectorAll('.row-select:checked');
    
    if (checkedCheckboxes.length === 0) {
        selectAll.checked = false;
        tableSelectAll.checked = false;
    } else if (checkedCheckboxes.length === allCheckboxes.length) {
        selectAll.checked = true;
        tableSelectAll.checked = true;
    } else {
        selectAll.checked = false;
        tableSelectAll.checked = false;
    }
    
    // Disable buttons if no items left
    if (selectedIds.length === 0) {
        document.getElementById('bulkApproveBtn').disabled = true;
        document.getElementById('bulkRejectBtn').disabled = true;
        if (type === 'approve') {
            closeModal('bulkApproveModal');
        } else {
            closeModal('bulkRejectModal');
        }
    }
}
// ✅ FUNCTION showBulkApproveModal YANG DIPERBAIKI
function showBulkApproveModal() {
    if (selectedIds.length === 0) return;
    
    document.getElementById('bulkApproveCount').textContent = selectedIds.length + ' pengajuan';
    document.getElementById('bulkApproveIds').value = selectedIds.join(',');
    
    const container = document.getElementById('bulkApproveItems');
    container.innerHTML = '';
    
    selectedItems.forEach((item, index) => {
        const itemHtml = `
            <div class="bulk-item" id="approve-item-${item.id}">
                <div class="bulk-item-header">
                    <div class="bulk-item-title">${escapeHtml(item.nama)}</div>
                    <div class="bulk-item-actions">
                        <button type="button" class="remove-item" onclick="removeBulkItem('${item.id}', 'approve')">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nomor_surat_${item.id}">
                        <i class="fa-solid fa-file-alt"></i> Nomor Surat <span style="color:#e74c3c">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="nomor_surat_${item.id}" 
                        name="nomor_surat[${item.id}]" 
                        class="form-control" 
                        placeholder="Contoh: 001/SKT/FT/2025" 
                        required
                        autocomplete="off"
                    >
                    <div class="form-hint">
                        <i class="fa-solid fa-exclamation-circle"></i> Format: 001/SKT/FT/Tahun
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += itemHtml;
    });
    
    document.getElementById('bulkApproveModal').classList.add('show');
    
    // ✅ Auto focus ke input pertama
    setTimeout(() => {
        const firstInput = document.querySelector('#bulkApproveItems input[type="text"]');
        if (firstInput) firstInput.focus();
    }, 300);
}

// ✅ FUNCTION showBulkRejectModal YANG DIPERBAIKI
function showBulkRejectModal() {
    if (selectedIds.length === 0) return;
    
    document.getElementById('bulkRejectCount').textContent = selectedIds.length + ' pengajuan';
    const container = document.getElementById('bulkRejectItems');
    container.innerHTML = '';
    
    selectedItems.forEach((item, index) => {
        const itemHtml = `
            <div class="bulk-item" id="reject-item-${item.id}">
                <div class="bulk-item-header">
                    <div class="bulk-item-title">${escapeHtml(item.nama)}</div>
                    <div class="bulk-item-actions">
                        <button type="button" class="remove-item" onclick="removeBulkItem('${item.id}', 'reject')">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="rejection_notes_${item.id}">
                        <i class="fa-solid fa-comment-dots"></i> Alasan Penolakan <span style="color:#e74c3c">*</span>
                    </label>
                    <textarea 
                        id="rejection_notes_${item.id}" 
                        name="rejection_notes[${item.id}]" 
                        rows="3" 
                        class="form-control" 
                        placeholder="Masukkan alasan penolakan untuk ${escapeHtml(item.nama)}..."
                        style="resize:vertical"
                        required
                    ></textarea>
                    <div class="form-hint">
                        <i class="fa-solid fa-exclamation-circle"></i> Alasan penolakan akan dikirimkan kepada pengaju
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += itemHtml;
    });
    
    document.getElementById('bulkRejectModal').classList.add('show');
    
    // ✅ Auto focus ke textarea pertama
    setTimeout(() => {
        const firstTextarea = document.querySelector('#bulkRejectItems textarea');
        if (firstTextarea) firstTextarea.focus();
    }, 300);
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

// PERBAIKAN UTAMA: Function showDetail yang sudah diperbaiki
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
        const response = await fetch(`<?= base_url('sekretariat/getDetailPengajuan/') ?>${id}`);
        const data = await response.json();
        
        if (!data.success) {
            alert('Data tidak ditemukan');
            closeModal('detailModal');
            return;
        }

        const item = data.data;
        
        // Fungsi helper untuk mendapatkan value
        const getVal = (k) => {
            return (item[k] !== undefined && item[k] !== null && item[k] !== '' ? item[k] : '-');
        };

        // Format status dengan badge
        const status = getVal('status');
        let statusBadge = '';
        if (status.toLowerCase() === 'disetujui dekan') {
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
            // Struktur 1: dosen_data dari AJAX response (format baru)
            dosenData = item.dosen_data;
        } else {
            // Fallback: gunakan data default
            dosenData = [{
                nama: getVal('nama_dosen') !== '-' ? getVal('nama_dosen') : 'Data dosen tidak tersedia',
                nip: getVal('nip') !== '-' ? getVal('nip') : '-',
                jabatan: '-',
                divisi: '-'
            }];
        }

        // Debug: Tampilkan data dosen di console
        console.log('Dosen Data untuk ID', id, ':', dosenData);

        // Generate file evidence HTML
        let fileEvidenceHtml = '';
        const evidenValue = getVal('eviden');
        
        if (evidenValue && evidenValue !== '-') {
            let evidenFiles = [];
            
            try {
                // Try to parse as JSON first (for multiple files)
                if (evidenValue.startsWith('[') || evidenValue.startsWith('{')) {
                    const parsed = JSON.parse(evidenValue);
                    if (Array.isArray(parsed)) {
                        evidenFiles = parsed;
                    } else if (parsed.url) {
                        evidenFiles = [parsed.url];
                    }
                } else {
                    // Single file path or URL
                    evidenFiles = [evidenValue];
                }
            } catch (e) {
                // If not JSON, treat as single file path
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
                    // Extract filename dari path/URL
                    let fileName = file;
                    let fileUrl = file;
                    
                    // Jika file adalah path lokal (tidak mengandung http/https)
                    if (!file.startsWith('http://') && !file.startsWith('https://')) {
                        // Ambil hanya nama file dari path
                        fileName = file.split('/').pop();
                        // Buat URL lengkap ke folder uploads/eviden
                        fileUrl = '<?= base_url("uploads/eviden/") ?>' + fileName;
                    } else {
                        // Jika sudah URL lengkap (dari Uploadcare dll)
                        fileName = file.split('/').pop();
                    }
                    
                    // Get file extension untuk menentukan tipe file
                    const ext = fileName.split('.').pop().toLowerCase();
                    let fileIcon = 'fa-file';
                    let canPreview = false;
                    
                    // Tentukan file type dan kemampuan preview
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
                <button class="modal-btn modal-btn-reject" onclick="showRejectModal(${item.id}, '${escapeHtml(item.nama_kegiatan)}'); closeModal('detailModal')">
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

function showRejectModal(id, namaKegiatan) {
    currentRejectId = id;
    document.getElementById('rejectNamaKegiatan').textContent = namaKegiatan;
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

// Auto focus pada search input
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        const searchValue = '<?= $this->input->get('search') ?>';
        if (searchValue) {
            searchInput.focus();
            searchInput.setSelectionRange(searchValue.length, searchValue.length);
        }
    }
    
    // Initialize selected count
    updateSelectedCount();
});
</script>
</body>
</html>