<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengajuan Menunggu Persetujuan - Dashboard Dekan</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    /* STYLE UTAMA (SAMA DENGAN DASHBOARD) */
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;background:#f5f7fa;}
    .navbar{background:#FB8C00;color:white;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
    .navbar h2{font-size:20px;}
    .container{max-width:1200px;margin:30px auto;padding:0 20px;}
    
    /* Back Button */
    .back-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#FB8C00;color:white;text-decoration:none;border-radius:8px;font-weight:600;transition:all 0.3s;margin-bottom:20px}
    .back-btn:hover{background:#e67e22;transform:translateY(-2px)}
    
    /* Card Styles (SAMA DENGAN DASHBOARD) */
    .card{background:white;border-radius:10px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,0.06);margin-bottom:20px}
    .card-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid #eee}
    
    /* Table Styles (SAMA DENGAN DASHBOARD) */
    table{width:100%;border-collapse:collapse}
    thead{background:#f4f6f7}
    th,td{padding:12px;border-bottom:1px solid #ecf0f1;text-align:left;font-size:14px}
    tbody tr:hover{background:#fbfcfd}
    
    /* Badge Styles (SAMA DENGAN DASHBOARD) */
    .badge{display:inline-block;padding:6px 10px;border-radius:999px;font-weight:600;font-size:12px}
    .badge-pending{background:#fff3cd;color:#856404}
    .badge-approved{background:#d4edda;color:#155724}
    .badge-rejected{background:#f8d7da;color:#721c24}
    
    /* Button Styles (SAMA DENGAN DASHBOARD) */
    .btn{padding:6px 10px;border-radius:6px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s}
    .btn:hover{transform:scale(1.05)}
    .btn-approve{background:#27ae60;color:#fff}
    .btn-approve:hover{background:#229954}
    .btn-reject{background:#e74c3c;color:#fff}
    .btn-reject:hover{background:#c0392b}
    .btn-detail{background:#3498db;color:#fff}
    .btn-detail:hover{background:#2980b9}
    
    /* Tombol Eviden Hijau (SAMA DENGAN DASHBOARD) */
    .btn-eviden {
        background: #28a745 !important;
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

    .btn-eviden i {
        font-size: 14px;
    }

    .btn-eviden:hover {
        background: #218838 !important;
        transform: scale(1.05);
    }
    
    /* Pagination Info */
    .pagination-info{margin-top:15px;color:#7f8c8d;font-size:14px;text-align:right}
    
    /* Modal Styles - SAMA DENGAN DASHBOARD */
    .modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.45);align-items:center;justify-content:center}
    .modal.show{display:flex}
    .modal-content{background:white;padding:0;border-radius:15px;max-width:800px;width:95%;max-height:85vh;overflow:hidden;animation:slideIn 0.3s ease;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
    @keyframes slideIn{from{transform:translateY(-50px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-header{background:#FB8C00;color:white;padding:20px 25px;display:flex;justify-content:space-between;align-items:center;border-radius:15px 15px 0 0}
    .modal-header h3{margin:0;font-size:18px;font-weight:600}
    .close-modal{background:none;border:0;color:white;font-size:24px;cursor:pointer;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background 0.2s}
    .close-modal:hover{background:rgba(255,255,255,0.2)}
    
    /* Detail Content Styles - SAMA DENGAN DASHBOARD */
    .detail-content{padding:25px;max-height:calc(85vh - 80px);overflow-y:auto}
    .detail-section{margin-bottom:25px;background:#f8f9fa;border-radius:12px;padding:20px;border:1px solid #e9ecef}
    .detail-section:last-child{margin-bottom:0}
    .detail-section-title{font-size:16px;font-weight:700;color:#FB8C00;margin-bottom:15px;padding-bottom:10px;border-bottom:2px solid #FB8C00;display:flex;align-items:center;gap:10px}
    .detail-section-title i{font-size:18px}
    .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:15px}
    .detail-row{display:flex;flex-direction:column;margin-bottom:12px}
    .detail-label{font-weight:600;color:#495057;font-size:13px;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.5px}
    .detail-value{color:#212529;font-size:14px;background:white;padding:10px 15px;border-radius:8px;border:1px solid #e9ecef;min-height:40px;display:flex;align-items:center}
    .detail-value-empty{color:#6c757d;font-style:italic;background:#f8f9fa !important}
    
    /* Dosen list in detail - SAMA DENGAN DASHBOARD */
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
    
    /* File Evidence Styles - SAMA DENGAN DASHBOARD */
    .file-evidence{margin-top:10px}
    .file-item{display:flex;align-items:center;gap:12px;padding:12px 15px;background:white;border:1px solid #e9ecef;border-radius:8px;transition:all 0.2s}
    .file-item:hover{background:#fef9e7;border-color:#FB8C00}
    .file-icon{width:24px;height:24px;display:flex;align-items:center;justify-content:center;color:#FB8C00;font-size:16px}
    .file-info{flex:1}
    .file-name{font-weight:600;color:#212529;font-size:14px;cursor:pointer}
    .file-name:hover{color:#FB8C00}
    .file-size{font-size:12px;color:#6c757d}
    .preview-btn{background:#3498db;color:white;border:none;padding:8px 16px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;transition:background 0.2s;display:flex;align-items:center;gap:6px;text-decoration:none}
    .preview-btn:hover{background:#2980b9;color:white;text-decoration:none}
    .preview-btn.disabled{background:#bdc3c7;cursor:not-allowed;opacity:0.6}
    .preview-btn.disabled:hover{background:#bdc3c7}
    .download-btn{background:#FB8C00;color:white;border:none;padding:8px 16px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;transition:background 0.2s;display:flex;align-items:center;gap:6px;text-decoration:none}
    .download-btn:hover{background:#E67E22;color:white;text-decoration:none}

    /* Preview Modal Styles - SAMA DENGAN DASHBOARD */
    .preview-modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.8);z-index:10000;justify-content:center;align-items:center;padding:20px}
    .preview-modal.show{display:flex}
    .preview-content{background:white;border-radius:12px;width:90%;max-width:900px;max-height:90vh;overflow:hidden;display:flex;flex-direction:column}
    .preview-header{background:#FB8C00;color:white;padding:15px 20px;display:flex;justify-content:space-between;align-items:center}
    .preview-header h3{margin:0;font-size:16px;font-weight:600}
    .preview-close{background:none;border:none;color:white;font-size:24px;cursor:pointer;padding:0;width:30px;height:30px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background 0.2s}
    .preview-close:hover{background:rgba(255,255,255,0.2)}
    .preview-body{flex:1;padding:0;display:flex;justify-content:center;align-items:center;background:#f8f9fa;min-height:400px}
    .preview-iframe{width:100%;height:70vh;border:none}
    .preview-image{max-width:100%;max-height:70vh;object-fit:contain}
    .preview-unsupported{text-align:center;padding:40px;color:#6c757d}
    .preview-unsupported i{font-size:48px;margin-bottom:15px;color:#FB8C00}
    
    /* Action Buttons in Modal - SAMA DENGAN DASHBOARD */
    .modal-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:20px;padding-top:20px;border-top:1px solid #e9ecef}
    .modal-btn{padding:10px 20px;border-radius:8px;border:none;cursor:pointer;font-weight:600;font-size:14px;transition:all 0.2s;display:flex;align-items:center;gap:8px}
    .modal-btn-close{background:#6c757d;color:white}
    .modal-btn-close:hover{background:#5a6268;transform:translateY(-2px)}
    .modal-btn-approve{background:#27ae60;color:white}
    .modal-btn-approve:hover{background:#229954;transform:translateY(-2px)}
    .modal-btn-reject{background:#e74c3c;color:white}
    .modal-btn-reject:hover{background:#c0392b;transform:translateY(-2px)}
    
    /* Rejection Notes Styles - SAMA DENGAN DASHBOARD */
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
        transform: translateY(-2px);
    }
    
    .btn-bulk-reject {
        background: #e74c3c;
        color: white;
    }
    
    .btn-bulk-reject:hover {
        background: #c0392b;
        transform: translateY(-2px);
    }
    
    .btn-bulk:disabled {
        background: #bdc3c7;
        cursor: not-allowed;
        transform: none;
    }
    
    /* Search Box Styles */
    .search-container{margin-bottom:20px}
    .search-label{display:block;margin-bottom:8px;color:#6c757d;font-size:14px;font-weight:500}
    .search-box{display:flex;gap:10px;align-items:center;width:100%}
    .search-input-wrapper{position:relative;flex:1}
    .search-input{width:100%;padding:12px 45px 12px 15px;border:1px solid #e9ecef;border-radius:8px;font-size:14px;transition:all 0.3s;background:white;color:#495057}
    .search-input:focus{outline:none;border-color:#FB8C00;box-shadow:0 0 0 2px rgba(251,140,0,0.1)}
    .search-input::placeholder{color:#6c757d}
    .search-icon{position:absolute;right:15px;top:50%;transform:translateY(-50%);color:#6c757d;font-size:16px}
    .btn-cari{padding:12px 24px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#FB8C00;color:#fff;white-space:nowrap}
    .btn-cari:hover{background:#e67e22;transform:translateY(-1px)}
    .btn-reset{padding:12px 24px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#95a5a6;color:#fff;white-space:nowrap;text-decoration:none}
    .btn-reset:hover{background:#7f8c8d;transform:translateY(-1px);color:white;text-decoration:none}
    
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
    
    /* Approve Modal Styles (SAMA DENGAN DASHBOARD) */
    .approve-modal-content {
        background: white;
        padding: 0;
        border-radius: 15px;
        max-width: 500px;
        width: 95%;
        max-height: 85vh;
        overflow: hidden;
        animation: slideIn 0.3s ease;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }
    
    .approve-modal-body {
        padding: 25px;
    }
    
    .approve-modal-header {
        background: #27ae60;
        color: white;
        padding: 20px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 15px 15px 0 0;
    }
    
    .approve-modal-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }
    
    .approve-info-box {
        background: #e8f5e9;
        border: 1px solid #27ae60;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
    
    .approve-info-box strong {
        color: #27ae60;
        display: block;
        margin-bottom: 5px;
    }
    
    .approve-info-box span {
        color: #2c3e50;
        font-weight: 600;
    }
    
    .approve-modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }
    
    .approve-btn {
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .approve-btn-cancel {
        background: #95a5a6;
        color: white;
    }
    
    .approve-btn-cancel:hover {
        background: #7f8c8d;
        transform: translateY(-2px);
    }
    
    .approve-btn-submit {
        background: #27ae60;
        color: white;
    }
    
    .approve-btn-submit:hover {
        background: #229954;
        transform: translateY(-2px);
    }
    
    /* Reject Modal Styles (SAMA DENGAN DASHBOARD) */
    .reject-modal-content {
        background: white;
        padding: 0;
        border-radius: 15px;
        max-width: 550px;
        width: 95%;
        max-height: 85vh;
        overflow: hidden;
        animation: slideIn 0.3s ease;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }
    
    .reject-modal-body {
        padding: 25px;
    }
    
    .reject-modal-header {
        background: #e74c3c;
        color: white;
        padding: 20px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 15px 15px 0 0;
    }
    
    .reject-modal-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }
    
    .reject-info-box {
        background: #fff5f5;
        border: 1px solid #f8cccc;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
    
    .reject-info-box strong {
        color: #e74c3c;
        display: block;
        margin-bottom: 5px;
    }
    
    .reject-info-box span {
        color: #2c3e50;
        font-weight: 600;
    }
    
    .reject-modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }
    
    .reject-btn {
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .reject-btn-cancel {
        background: #95a5a6;
        color: white;
    }
    
    .reject-btn-cancel:hover {
        background: #7f8c8d;
        transform: translateY(-2px);
    }
    
    .reject-btn-submit {
        background: #e74c3c;
        color: white;
    }
    
    .reject-btn-submit:hover {
        background: #c0392b;
        transform: translateY(-2px);
    }
    
    /* Textarea khusus untuk reject modal */
    .reject-textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #f8cccc;
        border-radius: 8px;
        font-family: inherit;
        font-size: 14px;
        transition: border-color 0.2s;
        resize: vertical;
        min-height: 100px;
    }
    
    .reject-textarea:focus {
        outline: none;
        border-color: #e74c3c;
        box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.2);
    }
    
    .reject-textarea::placeholder {
        color: #bdc3c7;
    }
    
    .reject-form-hint {
        color: #e74c3c;
        font-size: 12px;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    /* Dosen List di Success Modal (SAMA DENGAN DASHBOARD) */
    .success-dosen-container {
        background: #e8f5e9;
        border: 1px solid #c3e6cb;
        border-radius: 8px;
        padding: 15px;
        margin: 15px 0;
    }
    
    .success-dosen-title {
        font-weight: 600;
        color: #155724;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .success-dosen-count {
        background: #27ae60;
        color: white;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 12px;
    }
    
    .success-dosen-list {
        max-height: 150px;
        overflow-y: auto;
        margin-bottom: 10px;
    }
    
    .success-dosen-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 10px;
        background: white;
        border: 1px solid #d4edda;
        border-radius: 4px;
        margin-bottom: 5px;
    }
    
    .success-dosen-item:last-child {
        margin-bottom: 0;
    }
    
    .success-dosen-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #27ae60;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 11px;
        font-weight: 600;
        flex-shrink: 0;
    }
    
    .success-dosen-info {
        flex: 1;
        min-width: 0;
    }
    
    .success-dosen-name {
        font-weight: 600;
        color: #212529;
        font-size: 13px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .success-dosen-details {
        font-size: 11px;
        color: #6c757d;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .success-dosen-more-btn {
        background: #27ae60;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 6px 12px;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        width: 100%;
        transition: background 0.2s;
    }
    
    .success-dosen-more-btn:hover {
        background: #229954;
    }
    
    .success-dosen-hidden {
        display: none;
    }
    
    .success-dosen-show-all .success-dosen-item {
        display: flex !important;
    }
    
    /* Eviden Modal */
    .eviden-modal-content {
        background: white;
        padding: 0;
        border-radius: 15px;
        max-width: 800px;
        width: 95%;
        max-height: 85vh;
        overflow: hidden;
        animation: slideIn 0.3s ease;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }
    
    /* Clickable Row Styles - SAMA DENGAN DASHBOARD */
    .clickable-row {
        cursor: pointer !important;
        transition: all 0.2s ease;
    }

    .clickable-row:hover {
        background-color: #fef9e7 !important;
        box-shadow: 0 2px 4px rgba(251, 140, 0, 0.1);
    }

    .clickable-row:active {
        background-color: #fdebd0 !important;
        transform: scale(0.998);
    }

    /* Highlight untuk baris yang sedang dipilih */
    .clickable-row.selected {
        background-color: #fef9e7 !important;
        border-left: 4px solid #FB8C00;
    }

    /* Pastikan tombol di dalam row tidak ter-affected */
    .clickable-row button,
    .clickable-row select,
    .clickable-row textarea,
    .clickable-row input {
        pointer-events: all;
    }
    
    /* Responsive */
    @media (max-width:768px){
        .detail-grid{grid-template-columns:1fr}
        .modal-content{width:95%;margin:10px}
        .detail-content{padding:15px}
        .modal-actions{flex-direction:column}
        .modal-btn{justify-content:center}
        .search-box{flex-direction:column}
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

    <!-- Tabel Pengajuan Menunggu -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-table"></i> Daftar Pengajuan Menunggu Persetujuan</h3>
            <div>
                <span id="filterInfo" style="color:#7f8c8d;font-size:13px">
                    Menampilkan: Semua Data (<?= isset($total_surat) ? $total_surat : '0' ?>)
                </span>
            </div>
        </div>
        
        <!-- Bulk Actions -->
        <div class="bulk-actions" id="bulkActions" style="display: none;">
            <input type="checkbox" id="selectAll" class="bulk-checkbox" onchange="toggleSelectAll()">
            <div class="bulk-info" id="selectedCount">0 item dipilih</div>
            <button class="btn-bulk btn-bulk-approve" onclick="processBulkApprove()" id="bulkApproveBtn">
                <i class="fa-solid fa-check"></i> Setujui yang Dipilih
            </button>
            <button class="btn-bulk btn-bulk-reject" onclick="showBulkRejectModalNew()" id="bulkRejectBtn">
                <i class="fa-solid fa-times"></i> Tolak yang Dipilih
            </button>
            <button class="btn-bulk" onclick="clearSelection()" style="background: #95a5a6; color: white;">
                <i class="fa-solid fa-times"></i> Batal
            </button>
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
                <a href="<?= base_url('dekan/halaman_pending') ?>" class="btn-reset">
                    <i class="fa-solid fa-refresh"></i> Reset
                </a>
                <?php endif; ?>
            </div>
        </div>
        
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
                    if (isset($surat_list) && is_array($surat_list) && count($surat_list) > 0): 
                        $i = 1; 
                        foreach ($surat_list as $s): 
                            // Format tanggal
                            $tgl_pengajuan = isset($s['created_at']) && $s['created_at'] ? date('d M Y', strtotime($s['created_at'])) : '-';
                            $tgl_kegiatan = isset($s['tanggal_kegiatan']) && $s['tanggal_kegiatan'] ? date('d M Y', strtotime($s['tanggal_kegiatan'])) : '-';
                    ?>
                    <tr onclick="showRowDetail(<?= $s['id'] ?>)" style="cursor: pointer;" class="clickable-row">
                        <td onclick="event.stopPropagation()">
                            <input type="checkbox" class="row-checkbox" value="<?= $s['id'] ?? 0 ?>" onchange="updateBulkActions()">
                        </td>
                        <td><?= $i ?></td>
                        <td><strong><?= htmlspecialchars($s['nama_kegiatan'] ?? '-') ?></strong></td>
                        <td><?= htmlspecialchars($s['penyelenggara'] ?? '-') ?></td>
                        <td><?= $tgl_pengajuan ?></td>
                        <td><?= $tgl_kegiatan ?></td>
                        <td><?= htmlspecialchars($s['jenis_pengajuan'] ?? '-') ?></td>
                        <td>
                            <span class="badge badge-pending">
                                Menunggu
                            </span>
                        </td>
                        <td onclick="event.stopPropagation()">
                            <div style="display:flex;gap:6px">
                                <!-- Tombol Eviden Hijau -->
                                <button class="btn btn-eviden" onclick="showEvidenModal(<?= $s['id']; ?>)" title="Lihat Eviden">
                                    <i class="fas fa-file-image"></i>
                                </button>
                                
                                <!-- Tombol Lihat Detail -->
                                <button class="btn btn-detail" onclick="event.stopPropagation(); showDetail(<?= (int)$s['id'] ?>)" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                
                                <!-- Tombol Approve & Reject -->
                                <button class="btn btn-approve" onclick="event.stopPropagation(); showApproveModal(<?= (int)$s['id'] ?>, '<?= htmlspecialchars(addslashes($s['nama_kegiatan'])) ?>')" title="Setujui">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                <button class="btn btn-reject" onclick="event.stopPropagation(); showRejectModalNew(<?= (int)$s['id'] ?>, '<?= htmlspecialchars(addslashes($s['nama_kegiatan'])) ?>')" title="Tolak">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php $i++; endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" style="text-align:center;padding:40px;color:#7f8c8d">
                                <i class="fa-solid fa-clock" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
                                <strong>Tidak ada pengajuan yang menunggu persetujuan</strong>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-info">
            <?php
            echo "Menampilkan: Semua Data (" . (isset($total_surat) ? $total_surat : '0') . " data)";
            ?>
        </div>
    </div>
</div>

<!-- Preview Modal - SAMA DENGAN DASHBOARD -->
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

<!-- Detail Modal - SAMA DENGAN DASHBOARD -->
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

<!-- Eviden Modal - SAMA DENGAN DASHBOARD -->
<div id="evidenModal" class="modal" onclick="modalClickOutside(event,'evidenModal')">
    <div class="eviden-modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-image"></i> File Evidence</h3>
            <button class="close-modal" onclick="closeModal('evidenModal')">&times;</button>
        </div>
        <div class="detail-content" id="evidenContent">
            <!-- Content akan diisi oleh JavaScript -->
        </div>
    </div>
</div>

<!-- Approve Modal - SAMA DENGAN DASHBOARD -->
<div id="approveModal" class="modal" onclick="modalClickOutside(event,'approveModal')">
    <div class="approve-modal-content" onclick="event.stopPropagation()">
        <div class="approve-modal-header">
            <h3><i class="fa-solid fa-check-circle"></i> Konfirmasi Persetujuan</h3>
            <button class="close-modal" onclick="closeModal('approveModal')">&times;</button>
        </div>
        <div class="approve-modal-body">
            <div class="approve-info-box">
                <strong><i class="fa-solid fa-info-circle"></i> Anda akan menyetujui pengajuan:</strong>
                <span id="approveNamaKegiatan"></span>
            </div>
            
            <p style="color:#7f8c8d;margin-bottom:20px">
                <i class="fa-solid fa-exclamation-triangle"></i> 
                Tindakan ini tidak dapat dibatalkan. Pastikan Anda telah memeriksa semua detail pengajuan.
            </p>
            
            <form id="approveForm" method="POST" action="">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                
                <div class="approve-modal-actions">
                    <button type="button" class="approve-btn approve-btn-cancel" onclick="closeModal('approveModal')">
                        <i class="fa-solid fa-times"></i> Batal
                    </button>
                    <button type="submit" class="approve-btn approve-btn-submit">
                        <i class="fa-solid fa-check"></i> Ya, Setujui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal - SAMA DENGAN DASHBOARD -->
<div id="rejectConfirmModal" class="modal" onclick="modalClickOutside(event,'rejectConfirmModal')">
    <div class="reject-modal-content" onclick="event.stopPropagation()">
        <div class="reject-modal-header">
            <h3><i class="fa-solid fa-ban"></i> Konfirmasi Penolakan</h3>
            <button class="close-modal" onclick="closeModal('rejectConfirmModal')">&times;</button>
        </div>
        <div class="reject-modal-body">
            <div class="reject-info-box">
                <strong><i class="fa-solid fa-exclamation-triangle"></i> Anda akan menolak pengajuan:</strong>
                <span id="rejectNamaKegiatan">-</span>
            </div>
            
            <p style="margin-bottom:15px;color:#7f8c8d">
                <i class="fa-solid fa-info-circle"></i> 
                Berikan alasan penolakan untuk pengajuan ini:
            </p>
            
            <form id="rejectForm" method="POST" action="">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                
                <div class="form-group">
                    <textarea 
                        id="rejectionReason" 
                        name="rejection_notes" 
                        class="reject-textarea" 
                        placeholder="Masukkan alasan penolakan pengajuan ini..."
                        required
                    ></textarea>
                    <div class="reject-form-hint">
                        <i class="fa-solid fa-asterisk"></i> Alasan penolakan wajib diisi
                    </div>
                </div>
                
                <div class="reject-modal-actions">
                    <button type="button" class="reject-btn reject-btn-cancel" onclick="closeModal('rejectConfirmModal')">
                        <i class="fa-solid fa-times"></i> Batal
                    </button>
                    <button type="submit" class="reject-btn reject-btn-submit">
                        <i class="fa-solid fa-ban"></i> Ya, Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Result Modal - SAMA DENGAN DASHBOARD -->
<div id="successResultModal" class="modal" onclick="modalClickOutside(event,'successResultModal')">
    <div class="bulk-modal-content" onclick="event.stopPropagation()" style="max-width: 600px;">
        <div class="modal-header" style="background: #27ae60;">
            <h3><i class="fa-solid fa-check-circle"></i> <span id="successResultTitle">Pengajuan Berhasil Disetujui</span></h3>
            <button class="close-modal" onclick="closeModal('successResultModal')">&times;</button>
        </div>
        <div style="padding:25px;text-align:center">
            <div style="width:100px;height:100px;border-radius:50%;background:#d4edda;margin:0 auto 20px;display:flex;align-items:center;justify-content:center">
                <i class="fas fa-check" style="font-size:50px;color:#27ae60"></i>
            </div>
            
            <h3 style="color:#27ae60;margin-bottom:10px">Berhasil Disetujui</h3>
            <p style="color:#666;margin-bottom:5px">
                <i class="fa-solid fa-clock"></i> Disetujui pada: <strong id="successTimestamp">-</strong>
            </p>
            
            <div style="background:#d4edda;border:1px solid #c3e6cb;border-radius:8px;padding:15px;margin:20px 0">
                <div style="font-weight:600;color:#155724;margin-bottom:10px;display:flex;align-items:center;justify-content:space-between">
                    <span>Daftar Pengajuan</span>
                    <span id="successItemCount" style="background:#27ae60;color:white;padding:4px 12px;border-radius:20px;font-size:12px">0 item</span>
                </div>
                <div id="successList" style="max-height:250px;overflow-y:auto;text-align:left">
                    <!-- List akan diisi oleh JavaScript -->
                </div>
            </div>
            
            <div style="display:flex;gap:10px;justify-content:center;margin-top:20px">
                <button class="btn-bulk" onclick="refreshPage()" style="background:#27ae60;color:white;padding:10px 24px;border:none;border-radius:6px;cursor:pointer;font-weight:600;display:flex;align-items:center;gap:6px">
                    <i class="fa-solid fa-rotate"></i> Refresh Halaman
                </button>
                <button class="btn-bulk" onclick="closeModal('successResultModal')" style="background:#6c757d;color:white;padding:10px 24px;border:none;border-radius:6px;cursor:pointer;font-weight:600;display:flex;align-items:center;gap:6px">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Reject Modal - SAMA DENGAN DASHBOARD -->
<div id="successRejectModal" class="modal" onclick="modalClickOutside(event,'successRejectModal')">
    <div class="bulk-modal-content" onclick="event.stopPropagation()" style="max-width: 600px;">
        <div class="modal-header" style="background: #e74c3c;">
            <h3><i class="fa-solid fa-ban"></i> <span id="successRejectTitle">Pengajuan Berhasil Ditolak</span></h3>
            <button class="close-modal" onclick="closeModal('successRejectModal')">&times;</button>
        </div>
        <div style="padding:25px;text-align:center">
            <div style="width:100px;height:100px;border-radius:50%;background:#f8d7da;margin:0 auto 20px;display:flex;align-items:center;justify-content:center">
                <i class="fas fa-times-circle" style="font-size:50px;color:#e74c3c"></i>
            </div>
            
            <h3 style="color:#e74c3c;margin-bottom:10px">Berhasil Ditolak</h3>
            <p style="color:#666;margin-bottom:5px">
                <i class="fa-solid fa-clock"></i> Ditolak pada: <strong id="rejectTimestamp">-</strong>
            </p>
            
            <div style="background:#f8d7da;border:1px solid #f5c6cb;border-radius:8px;padding:15px;margin:20px 0">
                <div style="font-weight:600;color:#721c24;margin-bottom:10px;display:flex;align-items:center;justify-content:space-between">
                    <span>Daftar Pengajuan</span>
                    <span id="rejectItemCount" style="background:#e74c3c;color:white;padding:4px 12px;border-radius:20px;font-size:12px">0 item</span>
                </div>
                <div id="rejectList" style="max-height:250px;overflow-y:auto;text-align:left">
                    <!-- List akan diisi oleh JavaScript -->
                </div>
            </div>
            
            <div style="display:flex;gap:10px;justify-content:center;margin-top:20px">
                <button class="btn-bulk" onclick="refreshPage()" style="background:#e74c3c;color:white;padding:10px 24px;border:none;border-radius:6px;cursor:pointer;font-weight:600;display:flex;align-items:center;gap:6px">
                    <i class="fa-solid fa-rotate"></i> Refresh Halaman
                </button>
                <button class="btn-bulk" onclick="closeModal('successRejectModal')" style="background:#6c757d;color:white;padding:10px 24px;border:none;border-radius:6px;cursor:pointer;font-weight:600;display:flex;align-items:center;gap:6px">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Multi Approve Confirmation Modal -->
<div id="multiApproveConfirmModal" class="modal" onclick="modalClickOutside(event,'multiApproveConfirmModal')">
    <div class="bulk-modal-content" onclick="event.stopPropagation()">
        <div class="modal-header" style="background: #9b59b6;">
            <h3><i class="fa-solid fa-info-circle"></i> Konfirmasi Multi Approve</h3>
            <button class="close-modal" onclick="closeModal('multiApproveConfirmModal')">&times;</button>
        </div>
        <div style="padding:25px;text-align:center">
            <div style="width:80px;height:80px;border-radius:50%;background:#fef5e7;margin:0 auto 20px;display:flex;align-items:center;justify-content:center">
                <i class="fas fa-exclamation" style="font-size:40px;color:#f39c12"></i>
            </div>
            
            <h3 style="color:#7d6608;margin-bottom:10px">Konfirmasi Multi Approve</h3>
            <p style="color:#666;margin-bottom:20px">Anda akan menyetujui <strong id="multiApproveCount">0</strong> pengajuan sekaligus</p>
            
            <div style="background:#f8f9fa;border:1px solid #e9ecef;border-radius:8px;padding:15px;margin-bottom:20px">
                <div style="font-weight:600;color:#495057;margin-bottom:10px;display:flex;align-items:center;justify-content:space-between">
                    <span>📋 Daftar Pengajuan yang Akan Disetujui:</span>
                    <span id="multiApproveItemCount" style="background:#27ae60;color:white;padding:4px 12px;border-radius:20px;font-size:12px">0 item</span>
                </div>
                <div id="multiApproveList" style="max-height:200px;overflow-y:auto">
                    <!-- List akan diisi oleh JavaScript -->
                </div>
            </div>
            
            <div style="display:flex;gap:10px;justify-content:center">
                <button class="btn-bulk" onclick="closeModal('multiApproveConfirmModal')" style="background:#95a5a6;color:white;padding:10px 24px">
                    <i class="fa-solid fa-times"></i> Batal
                </button>
                <button class="btn-bulk btn-bulk-approve" onclick="confirmMultiApprove()" style="padding:10px 24px">
                    <i class="fa-solid fa-check"></i> Ya, Setujui Semua
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Reject Modal -->
<div id="bulkRejectModal" class="modal" onclick="modalClickOutside(event,'bulkRejectModal')">
    <div class="reject-modal-content" onclick="event.stopPropagation()">
        <div class="reject-modal-header">
            <h3><i class="fa-solid fa-ban"></i> Tolak Pengajuan Terpilih</h3>
            <button class="close-modal" onclick="closeModal('bulkRejectModal')">&times;</button>
        </div>
        <div class="reject-modal-body">
            <div class="reject-info-box">
                <strong><i class="fa-solid fa-exclamation-triangle"></i> Anda akan menolak:</strong>
                <span id="bulkRejectCount">0 pengajuan</span>
            </div>
            
            <p style="margin-bottom:15px;color:#7f8c8d">
                <i class="fa-solid fa-info-circle"></i> 
                Berikan alasan penolakan untuk masing-masing pengajuan:
            </p>
            
            <div id="individualRejectionContainer" style="max-height:400px;overflow-y:auto;padding-right:10px;margin-bottom:15px">
                <!-- Container untuk individual rejection notes -->
            </div>
            
            <div class="reject-modal-actions">
                <button type="button" class="reject-btn reject-btn-cancel" onclick="closeModal('bulkRejectModal')">
                    <i class="fa-solid fa-times"></i> Batal
                </button>
                <button type="button" class="reject-btn reject-btn-submit" onclick="confirmBulkReject()">
                    <i class="fa-solid fa-ban"></i> Ya, Tolak Semua
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Data dari controller
const suratList = <?= isset($surat_list) ? json_encode($surat_list) : '[]' ?>;
let currentRejectId = null;
let currentRejectNamaKegiatan = null;
let currentApproveId = null;
let currentApproveNamaKegiatan = null;
let currentSearchTerm = '';
let selectedIds = [];

// ============================================
// BULK ACTION FUNCTIONS
// ============================================

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

// ============================================
// MODAL FUNCTIONS (SAMA DENGAN DASHBOARD)
// ============================================

// Fungsi untuk menampilkan approve modal (SAMA DENGAN DASHBOARD)
function showApproveModal(id, namaKegiatan) {
    currentApproveId = id;
    currentApproveNamaKegiatan = namaKegiatan;
    
    document.getElementById('approveNamaKegiatan').textContent = namaKegiatan;
    document.getElementById('approveForm').action = '<?= base_url("dekan/approve/") ?>' + id;
    document.getElementById('approveModal').classList.add('show');
}

// Fungsi untuk menampilkan reject modal baru (SAMA DENGAN DASHBOARD)
function showRejectModalNew(id, namaKegiatan) {
    currentRejectId = id;
    currentRejectNamaKegiatan = namaKegiatan;
    
    // Set data ke modal
    document.getElementById('rejectNamaKegiatan').textContent = namaKegiatan;
    document.getElementById('rejectionReason').value = '';
    document.getElementById('rejectForm').action = '<?= base_url("dekan/reject/") ?>' + id;
    
    // Tampilkan modal
    document.getElementById('rejectConfirmModal').classList.add('show');
}

// Fungsi untuk menampilkan bulk reject modal baru
function showBulkRejectModalNew() {
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
            rejectionDiv.style.cssText = 'margin-bottom:15px;padding:15px;border:1px solid #e9ecef;border-radius:8px;background:#f8f9fa';
            rejectionDiv.innerHTML = `
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;padding-bottom:8px;border-bottom:1px solid #dee2e6">
                    <div style="font-weight:600;color:#495057;flex-grow:1">
                        <strong>${escapeHtml(surat.nama_kegiatan || '-')}</strong>
                        <div style="font-size:12px;color:#6c757d">${escapeHtml(surat.penyelenggara || '-')}</div>
                    </div>
                </div>
                <textarea 
                    style="width:100%;padding:10px;border:1px solid #ced4da;border-radius:6px;font-family:inherit;resize:vertical;min-height:80px;font-size:14px"
                    placeholder="Masukkan alasan penolakan untuk pengajuan ini..."
                    data-id="${id}"
                ></textarea>
            `;
            container.appendChild(rejectionDiv);
        }
    });
    
    modal.classList.add('show');
}

// CONFIRM BULK REJECT
function confirmBulkReject() {
    // Validasi semua textarea
    const textareas = document.querySelectorAll('#individualRejectionContainer textarea');
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
    form.action = '<?= base_url("dekan/process_multi_reject") ?>';
    
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

// PROCESS BULK APPROVE
function processBulkApprove() {
    if (selectedIds.length === 0) {
        alert('Tidak ada pengajuan yang dipilih');
        return;
    }
    
    // Update count
    document.getElementById('multiApproveCount').textContent = selectedIds.length;
    document.getElementById('multiApproveItemCount').textContent = `${selectedIds.length} item`;
    
    // Populate list
    const listContainer = document.getElementById('multiApproveList');
    listContainer.innerHTML = '';
    
    selectedIds.forEach((id, index) => {
        const surat = suratList.find(s => Number(s.id) === Number(id));
        if (surat) {
            const itemDiv = document.createElement('div');
            itemDiv.style.cssText = 'display:flex;align-items:center;gap:10px;padding:10px;background:white;border:1px solid #e9ecef;border-radius:6px;margin-bottom:8px';
            itemDiv.innerHTML = `
                <span style="background:#9b59b6;color:white;width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:600;flex-shrink:0">${index + 1}</span>
                <div style="flex:1;text-align:left">
                    <div style="font-weight:600;color:#212529;font-size:14px">${escapeHtml(surat.nama_kegiatan || '-')}</div>
                    <div style="font-size:12px;color:#6c757d">📅 ${formatDate(surat.tanggal_kegiatan)} | 📍 ${escapeHtml(surat.penyelenggara || '-')}</div>
                </div>
                <span class="badge badge-pending" style="flex-shrink:0">Menunggu</span>
            `;
            listContainer.appendChild(itemDiv);
        }
    });
    
    document.getElementById('multiApproveConfirmModal').classList.add('show');
}

function confirmMultiApprove() {
    if (selectedIds.length === 0) return;
    
    closeModal('multiApproveConfirmModal');
    
    // Buat form dan submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= base_url("dekan/process_multi_approve") ?>';
    
    // CSRF Token
    const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
    const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
    const inpCsrf = document.createElement('input');
    inpCsrf.type = 'hidden'; 
    inpCsrf.name = csrfName; 
    inpCsrf.value = csrfHash;
    form.appendChild(inpCsrf);
    
    // Tambahkan setiap selected ID
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

// ============================================
// DETAIL MODAL FUNCTIONS (SAMA DENGAN DASHBOARD)
// ============================================

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
            <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #FB8C00;"></i>
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

// Fungsi untuk menampilkan modal eviden
async function showEvidenModal(suratId) {
    try {
        // Ambil data detail via AJAX
        const item = await getSuratDetail(suratId);
        
        if (!item) {
            alert('Data tidak ditemukan');
            return;
        }

        // Ambil dan proses data eviden
        const evidenFiles = getEvidenFilesFromData(item);
        
        if (evidenFiles.length === 0) {
            alert('Tidak ada file eviden untuk pengajuan ini.');
            return;
        }
        
        // LOGIKA BARU: Jika hanya 1 file, langsung preview
        if (evidenFiles.length === 1) {
            const file = evidenFiles[0];
            previewFile(file.url, file.name);
        } else {
            // Jika lebih dari 1 file, tampilkan modal daftar file
            showMultipleEvidenModal(item, evidenFiles);
        }
        
    } catch (error) {
        console.error('Error loading eviden:', error);
        alert('Gagal memuat eviden: ' + error.message);
    }
}

// Fungsi helper untuk mendapatkan array file eviden dari data
function getEvidenFilesFromData(item) {
    const getVal = (k) => {
        const value = (item[k] !== undefined && item[k] !== null && item[k] !== '' ? item[k] : '-');
        return value;
    };

    const evidenValue = getVal('eviden');
    const baseUrl = '<?= base_url() ?>';
    let evidenFiles = [];
    
    if (evidenValue && evidenValue !== '-') {
        try {
            // Coba parse JSON jika eviden adalah array
            if (Array.isArray(evidenValue)) {
                evidenValue.forEach(file => {
                    if (file && file !== '-' && file !== 'null') {
                        const fileName = getFileNameFromPath(file);
                        const fileUrl = getFileUrl(file, baseUrl);
                        evidenFiles.push({
                            name: fileName,
                            url: fileUrl,
                            ext: fileName.split('.').pop().toLowerCase()
                        });
                    }
                });
            } else if (typeof evidenValue === 'string' && evidenValue.startsWith('[')) {
                const parsed = JSON.parse(evidenValue);
                if (Array.isArray(parsed)) {
                    parsed.forEach(file => {
                        if (file && file !== '-' && file !== 'null') {
                            const fileName = getFileNameFromPath(file);
                            const fileUrl = getFileUrl(file, baseUrl);
                            evidenFiles.push({
                                name: fileName,
                                url: fileUrl,
                                ext: fileName.split('.').pop().toLowerCase()
                        });
                        }
                    });
                }
            } else {
                // Single file string
                const fileName = getFileNameFromPath(evidenValue);
                const fileUrl = getFileUrl(evidenValue, baseUrl);
                evidenFiles.push({
                    name: fileName,
                    url: fileUrl,
                    ext: fileName.split('.').pop().toLowerCase()
                });
            }
        } catch (e) {
            // Fallback: treat as single file
            const fileName = getFileNameFromPath(evidenValue);
            const fileUrl = getFileUrl(evidenValue, baseUrl);
            evidenFiles.push({
                name: fileName,
                url: fileUrl,
                ext: fileName.split('.').pop().toLowerCase()
            });
        }
    }
    
    return evidenFiles;
}

// Helper function untuk mendapatkan nama file dari path
function getFileNameFromPath(path) {
    if (!path) return 'file';
    return path.split('/').pop().split('\\').pop();
}

// Helper function untuk mendapatkan URL file yang lengkap
function getFileUrl(filePath, baseUrl) {
    if (!filePath) return '#';
    
    // Jika sudah URL lengkap
    if (filePath.startsWith('http://') || filePath.startsWith('https://') || filePath.startsWith('<?= base_url() ?>')) {
        return filePath;
    }
    
    // Coba beberapa kemungkinan path
    const fileName = getFileNameFromPath(filePath);
    const possiblePaths = [
        'uploads/eviden/' + fileName,
        'eviden/' + fileName,
        'assets/eviden/' + fileName,
        'uploads/' + fileName,
        filePath  // original path
    ];
    
    // Gunakan path pertama
    return baseUrl + possiblePaths[0];
}

// Fungsi untuk menampilkan modal multiple eviden (lebih dari 1 file)
function showMultipleEvidenModal(item, evidenFiles) {
    // Tampilkan loading
    document.getElementById('evidenContent').innerHTML = `
        <div style="text-align:center;padding:40px;">
            <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#FB8C00"></i>
            <p style="margin-top:10px;color:#7f8c8d">Memuat eviden...</p>
        </div>
    `;
    
    document.getElementById('evidenModal').classList.add('show');
    
    // Generate content
    const content = generateMultipleEvidenContent(item, evidenFiles);
    document.getElementById('evidenContent').innerHTML = content;
}

// Fungsi untuk generate konten multiple eviden (lebih dari 1 file)
function generateMultipleEvidenContent(item, evidenFiles) {
    // Helper function
    const getVal = (k) => {
        const value = (item[k] !== undefined && item[k] !== null && item[k] !== '' ? item[k] : '-');
        return value;
    };

    // Generate file evidence HTML untuk multiple files
    let fileEvidenceHtml = '';
    
    if (evidenFiles.length > 0) {
        fileEvidenceHtml = `
        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fa-solid fa-paperclip"></i> File Evidence (${evidenFiles.length} file)
            </div>
            <div class="file-evidence">`;
        
        evidenFiles.forEach((file, index) => {
            const ext = file.ext;
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
                    <div class="file-info" ${canPreview ? `onclick="previewFile('${file.url}', '${file.name}')" style="cursor: pointer;"` : ''}>
                        <div class="file-name" ${canPreview ? 'title="Klik untuk preview"' : ''}>${escapeHtml(file.name)}</div>
                        <div class="file-size">File ${index + 1} - ${ext.toUpperCase()}</div>
                    </div>
                    ${canPreview ? 
                        `<button class="preview-btn" onclick="previewFile('${file.url}', '${file.name}')">
                            <i class="fa-solid fa-eye"></i> Preview
                        </button>` :
                        `<button class="preview-btn disabled" disabled title="Preview tidak tersedia">
                            <i class="fa-solid fa-eye-slash"></i> Preview
                        </button>`
                    }
                    <a href="${file.url}" target="_blank" class="download-btn" download="${file.name}">
                        <i class="fa-solid fa-download"></i> Download
                    </a>
                </div>`;
        });
        
        fileEvidenceHtml += `
            </div>
        </div>`;
    } else {
        fileEvidenceHtml = `
        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fa-solid fa-paperclip"></i> File Evidence
            </div>
            <div style="text-align:center;padding:40px;color:#6c757d">
                <i class="fa-solid fa-file" style="font-size:48px;margin-bottom:15px;opacity:0.3"></i>
                <p>Tidak ada file eviden untuk pengajuan ini.</p>
            </div>
        </div>`;
    }

    return `       
        ${fileEvidenceHtml}
        
        <div class="modal-actions">
            <button class="modal-btn modal-btn-close" onclick="closeModal('evidenModal')">
                <i class="fa-solid fa-times"></i> Tutup
            </button>
        </div>
    `;
}

// Fungsi untuk menampilkan detail (SAMA DENGAN DASHBOARD)
async function showDetail(id) {
    try {
        // Tampilkan loading
        document.getElementById('detailContent').innerHTML = `
            <div style="text-align:center;padding:40px;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#FB8C00"></i>
                <p style="margin-top:10px;color:#7f8c8d">Memuat surat pengajuan...</p>
            </div>
        `;
        document.getElementById('detailModal').classList.add('show');

        // Load surat pengajuan via iframe
        const suratUrl = '<?= base_url("dekan/view_surat_pengajuan/") ?>' + id;
        document.getElementById('detailContent').innerHTML = `
            <iframe 
                src="${suratUrl}" 
                style="width:100%; height:70vh; border:none; border-radius:8px;"
                onload="this.style.opacity=1"
                style="opacity:0; transition: opacity 0.3s;"
            ></iframe>
            <div class="modal-actions">
                <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal')">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
            </div>
        `;
        
    } catch (error) {
        console.error('Error loading surat:', error);
        document.getElementById('detailContent').innerHTML = `
            <div style="text-align:center;padding:40px;color:#e74c3c">
                <i class="fa-solid fa-exclamation-triangle" style="font-size:48px;margin-bottom:10px"></i>
                <p>Gagal memuat surat: ${error.message}</p>
                <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal')" style="margin-top:20px">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
            </div>
        `;
    }
}

// Fungsi untuk menampilkan row detail (SAMA DENGAN DASHBOARD)
async function showRowDetail(id) {
    try {
        // Tampilkan loading
        document.getElementById('detailContent').innerHTML = `
            <div style="text-align:center;padding:40px;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#FB8C00"></i>
                <p style="margin-top:10px;color:#7f8c8d">Memuat detail pengajuan...</p>
            </div>
        `;
        
        // Tampilkan modal
        document.getElementById('detailModal').classList.add('show');
        
        // Ambil data detail via AJAX
        const data = await getSuratDetail(id);
        
        if (!data) {
            throw new Error('Data tidak ditemukan');
        }
        
        // Generate HTML untuk detail pengajuan ENHANCED
        const detailHtml = generateDetailContentEnhanced(data);
        document.getElementById('detailContent').innerHTML = detailHtml;
        
    } catch (error) {
        console.error('Error loading detail:', error);
        document.getElementById('detailContent').innerHTML = `
            <div style="text-align:center;padding:40px;color:#e74c3c">
                <i class="fa-solid fa-exclamation-triangle" style="font-size:48px;margin-bottom:10px"></i>
                <p>Gagal memuat detail: ${error.message}</p>
                <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal')" style="margin-top:20px">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
            </div>
        `;
    }
}

// Fungsi untuk generate konten detail (SAMA DENGAN DASHBOARD)
function generateDetailContentEnhanced(item) {
    const getVal = (k) => {
        const value = (item[k] !== undefined && item[k] !== null && item[k] !== '' ? item[k] : '-');
        return value;
    };

    // Format status badge
    let statusBadge = '';
    const status = getVal('status').toLowerCase();

    if (status.includes('setuju')) {
        statusBadge = `<span class="badge badge-approved">${getVal('status')}</span>`;
    } else if (status.includes('tolak')) {
        statusBadge = `<span class="badge badge-rejected">${getVal('status')}</span>`;
    } else {
        statusBadge = `<span class="badge badge-pending">${getVal('status')}</span>`;
    }

    // Ambil data dosen
    const dosenData = item.dosen_data || [];

    // Generate HTML untuk data dosen
    let dosenHtml = '';
    if (dosenData && dosenData.length > 0) {
        dosenHtml = `
        <div class="dosen-list">
            ${dosenData.map((dosen, index) => `
            <div class="dosen-item">
                <div class="dosen-avatar">
                    ${dosen.nama ? dosen.nama.charAt(0).toUpperCase() : '?'}
                </div>
                <div class="dosen-info">
                    <div class="dosen-name">${escapeHtml(dosen.nama)}</div>
                    <div class="dosen-details">
                        NIP: ${escapeHtml(dosen.nip)} | ${escapeHtml(dosen.jabatan)} | Divisi: ${escapeHtml(dosen.divisi)}
                    </div>
                </div>
            </div>
            `).join('')}
        </div>`;
    } else {
        dosenHtml = `
        <div class="dosen-item">
            <div class="dosen-avatar">
                ?
            </div>
            <div class="dosen-info">
                <div class="dosen-name">Data dosen tidak tersedia</div>
                <div class="dosen-details">Informasi dosen tidak ditemukan</div>
            </div>
        </div>`;
    }

    // Tampilkan nomor surat jika sudah disetujui
    let nomorSuratHtml = '';
    if (getVal('nomor_surat') && getVal('nomor_surat') !== '-') {
        nomorSuratHtml = `
        <div class="nomor-surat-container">
            <div class="nomor-surat-label">
                <i class="fa-solid fa-file-signature"></i> Nomor Surat
            </div>
            <div class="nomor-surat-value">
                ${escapeHtml(getVal('nomor_surat'))}
            </div>
        </div>`;
    }

    // Tampilkan catatan penolakan jika ada
    let rejectionHtml = '';
    if (getVal('catatan_penolakan') && getVal('catatan_penolakan') !== '-') {
        rejectionHtml = `
        <div class="rejection-notes">
            <div class="detail-label">
                <i class="fa-solid fa-comment-dots"></i> Catatan Penolakan
            </div>
            <div class="detail-value">
                ${escapeHtml(getVal('catatan_penolakan'))}
            </div>
        </div>`;
    }

    // LOGIKA BARU: Tentukan tampilan berdasarkan jenis_date
    const jenisDate = getVal('jenis_date');
    const periodeValue = getVal('periode_value');
    const tanggalKegiatan = getVal('tanggal_kegiatan');
    const akhirKegiatan = getVal('akhir_kegiatan');

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
    
    return `
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
                <div class="detail-value">${statusBadge}</div>
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
            <i class="fa-solid fa-users"></i> Dosen Terkait
        </div>
        ${dosenHtml}
    </div>
    
    <div class="detail-section">
        <div class="detail-section-title">
            <i class="fa-solid fa-calendar-alt"></i> Informasi Waktu & Tempat
        </div>
        <div class="detail-grid">
            <div class="detail-row">
                <div class="detail-label">Penyelenggara</div>
                <div class="detail-value">${escapeHtml(getVal('penyelenggara'))}</div>
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
                <div class="detail-label">Tempat Kegiatan</div>
                <div class="detail-value">${escapeHtml(getVal('tempat_kegiatan'))}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Tanggal Pengajuan</div>
                <div class="detail-value">${formatDate(getVal('created_at'))}</div>
            </div>
        </div>
    </div>
    
    ${rejectionHtml}
    
    <div class="modal-actions">
        <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal')">
            <i class="fa-solid fa-times"></i> Tutup
        </button>
        ${getVal('status') === 'disetujui sekretariat' ? `
<div style="display:flex;gap:10px;margin-left:auto">
    <button class="modal-btn modal-btn-reject" onclick="event.stopPropagation(); closeModal('detailModal'); showRejectModalNew(${item.id}, '${escapeHtml(getVal('nama_kegiatan'))}')">
        <i class="fa-solid fa-times"></i> Tolak
    </button>
    <button class="modal-btn modal-btn-approve" onclick="event.stopPropagation(); closeModal('detailModal'); showApproveModal(${item.id}, '${escapeHtml(getVal('nama_kegiatan'))}')">
        <i class="fa-solid fa-check"></i> Setujui
    </button>
</div>
` : ''}
    </div>`;
}

// PERBAIKAN: Fungsi untuk mengambil data detail via AJAX
function getSuratDetail(id) {
    return fetch('<?= site_url("dekan/getDetailPengajuan/") ?>' + id)
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

// ============================================
// SEARCH FUNCTIONALITY
// ============================================

function handleSearch() {
    const searchInput = document.getElementById('searchInput');
    currentSearchTerm = searchInput.value.toLowerCase();
    applyFilters();
}

function applyFilters() {
    const rows = document.querySelectorAll('#tableBody tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        if (row.cells.length < 9) return; // Skip empty row
        
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
            paginationInfo.textContent = `Menampilkan: ${visibleCount} data (difilter)`;
            filterInfo.textContent = `Menampilkan: ${visibleCount} data (difilter)`;
        } else {
            paginationInfo.textContent = `Menampilkan: Semua Data (${visibleCount} data)`;
            filterInfo.textContent = `Menampilkan: Semua Data (${visibleCount})`;
        }
    }
}

// ============================================
// SUCCESS MODAL FUNCTIONS (SAMA DENGAN DASHBOARD)
// ============================================

function refreshPage() {
    window.location.reload();
}

// Fungsi untuk menampilkan success modal (dipanggil dari controller via session)
function showSuccessModal(count, items, isSingle = false) {
    const modal = document.getElementById('successResultModal');
    const title = document.getElementById('successResultTitle');
    const timestamp = document.getElementById('successTimestamp');
    const itemCount = document.getElementById('successItemCount');
    const listContainer = document.getElementById('successList');
    
    title.textContent = isSingle ? 'Pengajuan Berhasil Disetujui' : 'Pengajuan Berhasil Disetujui (Multiple)';
    
    // Format timestamp
    const now = new Date();
    timestamp.textContent = now.toLocaleDateString('id-ID', { 
        day: '2-digit', 
        month: 'long', 
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }) + ' WIB';
    
    itemCount.textContent = `${count} item`;
    
    // Populate list dengan data
    listContainer.innerHTML = '';
    items.forEach((item, index) => {
        const itemDiv = document.createElement('div');
        itemDiv.style.cssText = 'background:white;border:1px solid #c3e6cb;border-radius:6px;margin-bottom:8px;overflow:hidden';
        
        // Ambil data dosen dari item
        const dosenData = item.dosen_data || [];
        const dosenHtml = generateDosenHtmlForSuccessModal(dosenData);
        
        itemDiv.innerHTML = `
            <div style="display:flex;align-items:center;gap:10px;padding:10px;border-bottom:1px solid #f0f0f0;">
                <i class="fas fa-check-circle" style="color:#27ae60;font-size:20px;flex-shrink:0"></i>
                <div style="flex:1;text-align:left">
                    <div style="font-weight:600;color:#212529;font-size:14px">${escapeHtml(item.nama)}</div>
                    <div style="font-size:12px;color:#6c757d">${item.details}</div>
                </div>
                <span class="badge badge-approved" style="flex-shrink:0">${isSingle ? 'Disetujui' : 'Disetujui (Multi)'}</span>
            </div>
            ${dosenHtml}
        `;
        listContainer.appendChild(itemDiv);
    });
    
    modal.classList.add('show');
    
    // Inisialisasi toggle dosen setelah modal ditampilkan
    setTimeout(initSuccessDosenList, 100);
}

// Fungsi untuk menampilkan success reject modal (SAMA DENGAN DASHBOARD)
function showSuccessRejectModal(count, items, isSingle = false) {
    const modal = document.getElementById('successRejectModal');
    const title = document.getElementById('successRejectTitle');
    const timestamp = document.getElementById('rejectTimestamp');
    const itemCount = document.getElementById('rejectItemCount');
    const listContainer = document.getElementById('rejectList');
    
    title.textContent = isSingle ? 'Pengajuan Berhasil Ditolak' : 'Pengajuan Berhasil Ditolak (Multiple)';
    
    // Format timestamp
    const now = new Date();
    timestamp.textContent = now.toLocaleDateString('id-ID', { 
        day: '2-digit', 
        month: 'long', 
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }) + ' WIB';
    
    itemCount.textContent = `${count} item`;
    
    // Populate list dengan data
    listContainer.innerHTML = '';
    items.forEach((item, index) => {
        const itemDiv = document.createElement('div');
        itemDiv.style.cssText = 'background:white;border:1px solid #f5c6cb;border-radius:6px;margin-bottom:8px;overflow:hidden';
        
        // Generate HTML untuk data tambahan jika ada
        let additionalInfo = '';
        if (item.rejection_notes) {
            additionalInfo = `
            <div style="background:#fff5f5;border-top:1px solid #f0f0f0;padding:10px;font-size:12px;">
                <div style="font-weight:600;color:#e74c3c;margin-bottom:5px">Alasan Penolakan:</div>
                <div style="color:#721c24">${escapeHtml(item.rejection_notes)}</div>
            </div>`;
        }
        
        itemDiv.innerHTML = `
            <div style="display:flex;align-items:center;gap:10px;padding:10px;border-bottom:1px solid #f0f0f0;">
                <i class="fas fa-times-circle" style="color:#e74c3c;font-size:20px;flex-shrink:0"></i>
                <div style="flex:1;text-align:left">
                    <div style="font-weight:600;color:#212529;font-size:14px">${escapeHtml(item.nama)}</div>
                    <div style="font-size:12px;color:#6c757d">${item.details}</div>
                </div>
                <span class="badge badge-rejected" style="flex-shrink:0">${isSingle ? 'Ditolak Dekan' : 'Ditolak Dekan (Multi)'}</span>
            </div>
            ${additionalInfo}
        `;
        listContainer.appendChild(itemDiv);
    });
    
    modal.classList.add('show');
}

// Fungsi untuk generate HTML dosen di success modal
function generateDosenHtmlForSuccessModal(dosenData) {
    if (!dosenData || dosenData.length === 0) {
        return '';
    }
    
    const maxVisible = 3; // Tampilkan maksimal 3 dosen secara default
    const isOverLimit = dosenData.length > maxVisible;
    const visibleDosen = isOverLimit ? dosenData.slice(0, maxVisible) : dosenData;
    const hiddenDosen = isOverLimit ? dosenData.slice(maxVisible) : [];
    const uniqueId = 'dosen-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
    
    return `
    <div class="success-dosen-container">
        <div class="success-dosen-title">
            <span>Dosen Terlibat</span>
            <span class="success-dosen-count">${dosenData.length} Dosen</span>
        </div>
        
        <div class="success-dosen-list" id="${uniqueId}">
            ${visibleDosen.map((dosen, index) => `
            <div class="success-dosen-item" data-index="${index}">
                <div class="success-dosen-avatar">
                    ${dosen.nama ? dosen.nama.charAt(0).toUpperCase() : '?'}
                </div>
                <div class="success-dosen-info">
                    <div class="success-dosen-name">${escapeHtml(dosen.nama)}</div>
                    <div class="success-dosen-details">
                        ${escapeHtml(dosen.nip)} | ${escapeHtml(dosen.jabatan)}
                    </div>
                </div>
            </div>
            `).join('')}
            
            ${hiddenDosen.map((dosen, index) => `
            <div class="success-dosen-item success-dosen-hidden" data-index="${maxVisible + index}">
                <div class="success-dosen-avatar">
                    ${dosen.nama ? dosen.nama.charAt(0).toUpperCase() : '?'}
                </div>
                <div class="success-dosen-info">
                    <div class="success-dosen-name">${escapeHtml(dosen.nama)}</div>
                    <div class="success-dosen-details">
                        ${escapeHtml(dosen.nip)} | ${escapeHtml(dosen.jabatan)}
                    </div>
                </div>
            </div>
            `).join('')}
        </div>
        
        ${isOverLimit ? `
        <button class="success-dosen-more-btn" onclick="toggleSuccessDosenList('${uniqueId}', this)">
            <i class="fa-solid fa-chevron-down"></i>
            <span>Tampilkan ${hiddenDosen.length} Dosen Lainnya</span>
        </button>
        ` : ''}
    </div>`;
}

// Fungsi untuk toggle show more/less dosen di success modal
function toggleSuccessDosenList(containerId, button) {
    const container = document.getElementById(containerId);
    const hiddenItems = container.querySelectorAll('.success-dosen-hidden');
    const icon = button.querySelector('i');
    const textSpan = button.querySelector('span');
    
    if (container.classList.contains('success-dosen-show-all')) {
        // Collapse - sembunyikan dosen setelah 3
        container.classList.remove('success-dosen-show-all');
        icon.className = 'fa-solid fa-chevron-down';
        textSpan.textContent = `Tampilkan ${hiddenItems.length} Dosen Lainnya`;
    } else {
        // Expand - tampilkan semua dosen
        container.classList.add('success-dosen-show-all');
        icon.className = 'fa-solid fa-chevron-up';
        textSpan.textContent = 'Sembunyikan';
    }
}

// Fungsi untuk inisialisasi dosen list di success modal
function initSuccessDosenList() {
    const containers = document.querySelectorAll('.success-dosen-list');
    containers.forEach(container => {
        const hiddenItems = container.querySelectorAll('.success-dosen-hidden');
        const button = container.parentElement.querySelector('.success-dosen-more-btn');
        
        if (button && hiddenItems.length > 0) {
            const textSpan = button.querySelector('span');
            if (textSpan) {
                textSpan.textContent = `Tampilkan ${hiddenItems.length} Dosen Lainnya`;
            }
        }
    });
}

// ============================================
// HELPER FUNCTIONS (SAMA DENGAN DASHBOARD)
// ============================================

function closeModal(id) { 
    document.getElementById(id).classList.remove('show'); 
}

function modalClickOutside(evt, id) { 
    if (evt.target && evt.target.id === id) closeModal(id); 
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

// ============================================
// INITIALIZATION
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    // Apply filters
    applyFilters();
    
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
    
    // Check if there's success data from session
    <?php if($this->session->flashdata('approved_items')): ?>
        const approvedItems = <?= json_encode($this->session->flashdata('approved_items')) ?>;
        const isSingle = <?= json_encode($this->session->flashdata('is_single_approve')) ?>;
        setTimeout(function() {
            showSuccessModal(approvedItems.length, approvedItems, isSingle);
        }, 500);
    <?php endif; ?>
    
    // Check for success reject modal data
    <?php if($this->session->flashdata('rejected_items')): ?>
        const rejectedItems = <?= json_encode($this->session->flashdata('rejected_items')) ?>;
        const isSingleReject = <?= json_encode($this->session->flashdata('is_single_reject')) ?>;
        setTimeout(function() {
            showSuccessRejectModal(rejectedItems.length, rejectedItems, isSingleReject);
        }, 500);
    <?php endif; ?>
    
    // Event listener untuk preview modal
    window.addEventListener('click', function(e) {
        if (e.target.id === 'previewModal') {
            closePreviewModal();
        }
    });
    
    // Make rows clickable
    makeRowsClickable();
});

// Fungsi untuk membuat baris tabel clickable
function makeRowsClickable() {
    const rows = document.querySelectorAll('#tableBody tr');
    
    rows.forEach(row => {
        // Skip jika row kosong atau sudah memiliki onclick
        if (row.cells.length < 9 || row.hasAttribute('onclick')) return;
        
        // Tambahkan class clickable
        row.classList.add('clickable-row');
        
        // Cari ID dari checkbox
        const checkbox = row.querySelector('.row-checkbox');
        if (checkbox) {
            const suratId = checkbox.value;
            
            // Tambahkan onclick attribute
            row.setAttribute('onclick', `showRowDetail(${suratId})`);
            
            // Event listener untuk handle klik pada elemen yang bukan tombol
            row.addEventListener('click', function(e) {
                // Jangan trigger jika yang diklik adalah checkbox, tombol, atau link
                if (e.target.closest('input[type="checkbox"]') || 
                    e.target.closest('button') || 
                    e.target.closest('a') || 
                    e.target.closest('select') ||
                    e.target.closest('textarea') ||
                    e.target.closest('input')) {
                    return;
                }
                
                // Remove highlight dari row lain
                rows.forEach(r => r.classList.remove('selected'));
                
                // Add highlight ke row yang diklik
                this.classList.add('selected');
            });
        }
    });
}
</script>
</body>
</html>