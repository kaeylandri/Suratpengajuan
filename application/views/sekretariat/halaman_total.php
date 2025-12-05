<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Total Pengajuan - Dashboard Sekretariat</title>
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
    .filter-container{display:flex;gap:15px;margin-bottom:20px;flex-wrap:wrap}
    .filter-select{padding:10px 15px;border-radius:8px;border:2px solid #ddd;font-weight:600;cursor:pointer;min-width:200px}
    
    /* Tombol Eviden */
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
    
    /* Tombol Status */
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

    /* Disposisi Styles */
    .btn-disposisi {
        background:#f1c40f;
        color:#000;
        border:none;
        padding:6px 12px;
        border-radius:5px;
        cursor:pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .disposisi-card {
        background: #ffffff;
        padding: 18px 20px;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.12);
        margin-top: 10px;
        border: 1px solid #eee;
        display: none;
    }
    
    .label-disposisi {
        font-weight: 600;
        color: #333;
        font-size: 14px;
        margin-bottom: 6px;
        display: block;
    }
    
    .select-disposisi {
        width: 100%;
        padding: 10px 12px;
        border-radius: 10px;
        border: 2px solid #ddd;
        background: #fafafa;
        font-size: 15px;
        outline: none;
        transition: .2s;
    }
    
    .textarea-disposisi {
        width: 100%;
        padding: 12px;
        height: 100px;
        border-radius: 10px;
        border: 2px solid #ddd;
        background: #fafafa;
        resize: vertical;
        font-size: 14px;
        transition: .2s;
        margin-top: 5px;
        display: none;
    }
    
    /* Search Filter */
    .search-filter-container{display:flex;align-items:center;gap:15px;margin-bottom:20px;flex-wrap:wrap;background:#f8f9fa;padding:15px;border-radius:10px;border:1px solid #e9ecef}
    .search-box{position:relative;flex:1;min-width:300px}
    .search-input{width:100%;padding:12px 45px 12px 15px;border:1px solid #ddd;border-radius:8px;font-size:14px;transition:all 0.3s;background:white}
    .search-input:focus{outline:none;border-color:#16A085;box-shadow:0 0 0 2px rgba(22,160,133,0.1)}
    .search-icon{position:absolute;right:15px;top:50%;transform:translateY(-50%);color:#6c757d}
    .btn-primary{padding:10px 20px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#16A085;color:#fff}
    .btn-primary:hover{background:#138D75;transform:translateY(-2px)}
    .btn-secondary{padding:10px 20px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#95a5a6;color:#fff}
    .btn-secondary:hover{background:#7f8c8d}
    .back-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#16A085;color:white;text-decoration:none;border-radius:8px;font-weight:600;transition:all 0.3s;margin-bottom:20px}
    .back-btn:hover{background:#138D75;transform:translateY(-2px)}
    
    /* Modal Styles - SAMA DENGAN DASHBOARD */
    .modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.45);align-items:center;justify-content:center}
    .modal.show{display:flex}
    .modal-content{background:white;padding:0;border-radius:15px;max-width:1100px;width:95%;max-height:85vh;overflow:hidden;animation:slideIn 0.3s ease;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
    @keyframes slideIn{from{transform:translateY(-50px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-header{background:#16A085;color:white;padding:20px 25px;display:flex;justify-content:space-between;align-items:center;border-radius:15px 15px 0 0}
    .modal-header h3{margin:0;font-size:18px;font-weight:600}
    .close-modal{background:none;border:0;color:white;font-size:24px;cursor:pointer;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background 0.2s}
    .close-modal:hover{background:rgba(255,255,255,0.2)}
    
    /* Detail Content Styles - SAMA DENGAN DASHBOARD */
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
    .approve-modal-header{background:#27ae60;color:white;padding:20px 25px;display:flex;justify-content:space-between;align-items:center;border-radius:15px 15px 0 0}
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
    
    /* Reject Modal Styles */
    .reject-modal-content{background:white;padding:0;border-radius:15px;max-width:550px;width:95%;max-height:85vh;overflow:hidden;animation:slideIn 0.3s ease;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
    .reject-modal-body{padding:25px}
    .reject-modal-header{background:#e74c3c;color:white;padding:20px 25px;display:flex;justify-content:space-between;align-items:center;border-radius:15px 15px 0 0}
    .reject-modal-header h3{margin:0;font-size:18px;font-weight:600}
    .reject-info-box{background:#fdf2f2;border:1px solid #e74c3c;border-radius:8px;padding:15px;margin-bottom:20px}
    .reject-info-box strong{color:#e74c3c;display:block;margin-bottom:5px}
    .reject-info-box span{color:#2c3e50;font-weight:600}
    
    /* Eviden Modal Styles */
    .eviden-modal {
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

    .eviden-modal.show {
        display: flex;
    }

    .eviden-content {
        background: white;
        border-radius: 12px;
        width: 90%;
        max-width: 800px;
        padding: 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .eviden-header {
        background: #28a745;
        color: white;
        padding: 20px;
        border-radius: 12px 12px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .eviden-header h3 {
        margin: 0;
        font-size: 18px;
    }

    .close-eviden {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background 0.2s;
    }

    .close-eviden:hover {
        background: rgba(255,255,255,0.2);
    }

    .eviden-body {
        padding: 25px;
        max-height: 70vh;
        overflow-y: auto;
    }
    
    /* PIN Modal Styles */
    .pin-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.4);
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }
    
    .pin-input-container {
        position: relative;
        margin: 15px 0;
    }

    .pin-input-with-icon {
        width: 100%;
        padding: 12px 12px 12px 40px;
        font-size: 20px;
        letter-spacing: 6px;
        text-align: center;
        border: 2px solid #dadada;
        border-radius: 8px;
        outline: none;
        transition: .2s;
    }

    .pin-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
        font-size: 20px;
    }

    .pin-input-with-icon:focus {
        border-color: #0066ff;
        box-shadow: 0 0 6px rgba(0,102,255,0.3);
    }
    
    /* Clickable Row Styles */
    .clickable-row {
        cursor: pointer !important;
        transition: all 0.2s ease;
    }

    .clickable-row:hover {
        background-color: #f0f8ff !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .clickable-row:active {
        background-color: #e3f2fd !important;
        transform: scale(0.998);
    }

    .clickable-row.selected {
        background-color: #e8f6f3 !important;
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
        .search-filter-container{flex-direction:column}
        .search-box{min-width:100%}
        .filter-select{width:100%}
    }

    /* Ensure buttons are clickable */
#tableBody button,
#tableBody a.btn-warning {
    position: relative;
    z-index: 10;
    pointer-events: auto !important;
    cursor: pointer !important;
}

#tableBody tr.clickable-row {
    position: relative;
    z-index: 1;
}

/* Disposisi elements */
.disposisi-card {
    position: relative;
    z-index: 20;
}

.disposisi-card select,
.disposisi-card textarea,
.disposisi-card button {
    pointer-events: auto !important;
    z-index: 21;
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
            <h3><i class="fa-solid fa-table"></i> Total Pengajuan Surat - Sekretariat</h3>
            <div>
                <span id="filterInfo" style="color:#7f8c8d;font-size:13px">
                    Menampilkan: 
                    <?php 
                    $filter_info = "Semua Data";
                    if($this->input->get('status') == 'pending') $filter_info = "Menunggu";
                    if($this->input->get('status') == 'approved') $filter_info = "Disetujui";
                    if($this->input->get('status') == 'rejected') $filter_info = "Ditolak";
                    if($this->input->get('status') == 'dekan_approved') $filter_info = "Disetujui Dekan";
                    if($this->input->get('status') == 'dekan_rejected') $filter_info = "Ditolak Dekan";
                    
                    // Filter Jenis Penugasan
                    $jenis_penugasan_info = "";
                    if($this->input->get('jenis_penugasan') == 'perorangan') {
                        $jenis_penugasan_info = " [Perorangan]";
                    } elseif($this->input->get('jenis_penugasan') == 'kelompok') {
                        $jenis_penugasan_info = " [Kelompok]";
                    } elseif($this->input->get('jenis_penugasan') == 'lainnya') {
                        $jenis_penugasan_info = " [Lainnya]";
                    }
                    
                    echo $filter_info . $jenis_penugasan_info . " (" . (isset($total_surat) ? $total_surat : '0') . " data)";
                    ?>
                </span>
            </div>
        </div>
        
        <!-- Search + Filter -->
        <form method="get" action="<?= base_url('sekretariat/semua') ?>">
            <input type="hidden" name="from" value="semua">
            
            <div class="search-filter-container">
                <div class="search-box">
                    <input 
                        type="text" 
                        name="search" 
                        class="search-input"
                        placeholder="Cari nama kegiatan atau penyelenggara..."
                        value="<?= $this->input->get('search') ?>"
                    >
                    <div class="search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
                
                <!-- Filter Status -->
                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="pending" <?= ($this->input->get('status')=='pending') ? 'selected' : '' ?>>Menunggu</option>
                    <option value="approved" <?= ($this->input->get('status')=='approved') ? 'selected' : '' ?>>Disetujui</option>
                    <option value="rejected" <?= ($this->input->get('status')=='rejected') ? 'selected' : '' ?>>Ditolak</option>
                    <option value="dekan_approved" <?= ($this->input->get('status')=='dekan_approved') ? 'selected' : '' ?>>Disetujui Dekan</option>
                    <option value="dekan_rejected" <?= ($this->input->get('status')=='dekan_rejected') ? 'selected' : '' ?>>Ditolak Dekan</option>
                </select>
                
                <!-- FILTER BARU: Jenis Penugasan -->
                <select name="jenis_penugasan" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Jenis Penugasan</option>
                    <option value="perorangan" <?= ($this->input->get('jenis_penugasan') == 'perorangan') ? 'selected' : '' ?>>Perorangan</option>
                    <option value="kelompok" <?= ($this->input->get('jenis_penugasan') == 'kelompok') ? 'selected' : '' ?>>Kelompok</option>
                    <option value="lainnya" <?= ($this->input->get('jenis_penugasan') == 'lainnya') ? 'selected' : '' ?>>Lainnya</option>
                </select>
                
                <button type="submit" class="btn-primary" style="white-space:nowrap">
                    <i class="fa-solid fa-filter"></i> Terapkan
                </button>
                
                <a href="<?= base_url('sekretariat/semua') ?>" class="btn-secondary" style="white-space:nowrap">
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
                        <th>Disposisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php 
                    if(isset($surat_list) && is_array($surat_list) && !empty($surat_list)): 
                        $no = 1; 
                        foreach($surat_list as $s): 
                            // LOGIKA STATUS YANG DIPERBAIKI
                            $status = $s->status ?? '';
                            $st_key = 'unknown';
                            $badge_text = ucwords($status);
                            
                            if ($status == 'disetujui KK') {
                                $st_key = 'pending';
                                $badge = '<span class="badge badge-pending">Menunggu Sekretariat</span>';
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
                                $st_key = 'other';
                                $badge = '<span class="badge badge-pending">' . $badge_text . '</span>';
                            }

                            $tgl_pengajuan = isset($s->created_at) && $s->created_at ? date('d M Y', strtotime($s->created_at)) : '-';
                            $tgl_kegiatan = isset($s->tanggal_kegiatan) && $s->tanggal_kegiatan ? date('d M Y', strtotime($s->tanggal_kegiatan)) : '-';
                    ?>
                    <tr class="clickable-row" data-status="<?= $st_key ?>">
                        <td><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($s->nama_kegiatan ?? '-') ?></strong></td>
                        <td><?= htmlspecialchars($s->penyelenggara ?? '-') ?></td>
                        <td><?= $tgl_pengajuan ?></td>
                        <td><?= $tgl_kegiatan ?></td>
                        <td><?= htmlspecialchars($s->jenis_pengajuan ?? '-') ?></td>
                        <td>
                            <!-- Tombol Tentukan Disposisi -->
                            <button 
                                class="btn-disposisi" 
                                onclick="openPinModal(<?= $s->id ?>, event)"
                            >
                                <i class="fas fa-shuffle"></i> Tentukan
                            </button>

                            <!-- Dropdown Disposisi -->
                            <div id="disposisiBox<?= $s->id ?>" class="disposisi-card">
                                <label class="label-disposisi">Pilih Disposisi</label>
                                <select id="disposisiSelect<?= $s->id ?>"
                                        class="select-disposisi"
                                        onchange="onDisposisiChange(<?= $s->id ?>, event)">
                                    <option value="">-- Pilih Disposisi --</option>
                                    <option value="Lanjut Proses ✔">Lanjut Proses</option>
                                    <option value="Hold/Pending">Hold/Pending</option>
                                    <option value="Batal">Batal</option>
                                </select>

                                <label id="labelCatatan<?= $s->id ?>" 
                                    class="label-disposisi" 
                                    style="display:none;margin-top:10px;">
                                    Catatan
                                </label>

                                <textarea id="catatanDisposisi<?= $s->id ?>"
                                        class="textarea-disposisi"
                                        placeholder="Catatan diperlukan..."
                                        style="display:none;">
                                </textarea>

                                <button class="btn-disposisi" 
                                        onclick="saveDisposisi(<?= $s->id ?>, event)" 
                                        id="btnSaveDisposisi<?= $s->id ?>"
                                        style="display:none; width: 100%; margin-top: 10px;">
                                    Simpan
                                </button>
                            </div>

                            <!-- Tampilkan status bila sudah ada -->
                            <?php if (!empty($s->disposisi_status)): ?>
                                <small><strong>Status:</strong> <?= $s->disposisi_status ?></small><br>
                                <?php if (!empty($s->disposisi_catatan)): ?>
                                    <em style="color:#7f8c8d">Catatan: <?= $s->disposisi_catatan ?></em>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <!-- Tombol Lihat Eviden -->
                                <button class="btn btn-eviden" 
                                        title="Lihat Eviden" 
                                        onclick="event.stopPropagation(); showEvidenModal(<?= $s->id; ?>, event)">
                                    <i class="fas fa-file-image"></i>
                                </button>
                                
                                <!-- Tombol Lihat Surat Tugas -->
                                <button class="btn btn-detail" 
                                        onclick="event.stopPropagation(); showSuratTugasFromButton(<?= $s->id ?>, event)" 
                                        title="Lihat Surat Tugas">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                
                                <?php if($status == 'disetujui KK' && $s->disposisi_status == 'Lanjut Proses ✔'): ?>
                                    <button class="btn btn-approve" 
                                            onclick="event.stopPropagation(); showApproveModal(<?= $s->id ?>, '<?= htmlspecialchars(addslashes($s->nama_kegiatan ?? '')) ?>', 'semua', event)" 
                                            title="Setujui & Teruskan ke Dekan">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                    <button class="btn btn-reject" 
                                            onclick="event.stopPropagation(); showRejectModal(<?= $s->id ?>, '<?= htmlspecialchars(addslashes($s->nama_kegiatan ?? '')) ?>', 'semua', event)" 
                                            title="Tolak Pengajuan">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                <?php endif; ?>
                                
                                <?php if($status == 'ditolak dekan' && $s->disposisi_status == 'Lanjut Proses ✔'): ?>
                                    <a href="<?= site_url('sekretariat/edit_surat/' . $s->id) ?>" 
                                    class="btn btn-warning" 
                                    title="Edit & Ajukan Ulang ke Dekan"
                                    onclick="event.stopPropagation(); return true;"
                                    style="background:#ffc107;color:#000;border:none;border-radius:5px;padding:6px 10px;display:inline-flex;align-items:center;justify-content:center;gap:5px;transition:0.2s ease-in-out;font-size:14px;height:32px;text-decoration:none;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="8" style="text-align:center;padding:40px;color:#7f8c8d">
                            <i class="fa-solid fa-inbox" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
                            <strong>
                                <?php if(!isset($surat_list)): ?>
                                    Variabel $surat_list tidak terdefinisi
                                <?php elseif(empty($surat_list)): ?>
                                    Tidak ada data pengajuan yang sesuai dengan filter
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
            Menampilkan: 
            <?php 
            $filter_info = "Semua Data";
            if($this->input->get('status') == 'pending') $filter_info = "Menunggu";
            if($this->input->get('status') == 'approved') $filter_info = "Disetujui";
            if($this->input->get('status') == 'rejected') $filter_info = "Ditolak";
            if($this->input->get('status') == 'dekan_approved') $filter_info = "Disetujui Dekan";
            if($this->input->get('status') == 'dekan_rejected') $filter_info = "Ditolak Dekan";
            
            // Filter Jenis Penugasan
            $jenis_penugasan_info = "";
            if($this->input->get('jenis_penugasan') == 'perorangan') {
                $jenis_penugasan_info = " [Perorangan]";
            } elseif($this->input->get('jenis_penugasan') == 'kelompok') {
                $jenis_penugasan_info = " [Kelompok]";
            } elseif($this->input->get('jenis_penugasan') == 'lainnya') {
                $jenis_penugasan_info = " [Lainnya]";
            }
            
            echo $filter_info . $jenis_penugasan_info . " (" . (isset($total_surat) ? $total_surat : '0') . " data)";
            ?>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div id="previewModal" class="preview-modal">
    <div class="preview-content">
        <div class="preview-header">
            <h3 id="previewTitle">Preview File</h3>
            <button class="preview-close" onclick="closePreviewModal(event)">&times;</button>
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
            <button class="close-modal" onclick="closeModal('detailModal', event)">&times;</button>
        </div>
        <div class="detail-content" id="detailContent">
            <!-- Content akan diisi oleh JavaScript -->
        </div>
    </div>
</div>

<!-- Eviden Modal -->
<div id="evidenModal" class="modal" onclick="modalClickOutside(event,'evidenModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-image"></i> File Evidence</h3>
            <button class="close-modal" onclick="closeModal('evidenModal', event)">&times;</button>
        </div>
        <div class="detail-content" id="evidenContent">
            <!-- Content akan diisi oleh JavaScript -->
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div id="approveModal" class="modal" onclick="modalClickOutside(event,'approveModal')">
    <div class="approve-modal-content" onclick="event.stopPropagation()">
        <div class="approve-modal-header">
            <h3><i class="fa-solid fa-check-circle"></i> Setujui Pengajuan</h3>
            <button class="close-modal" onclick="closeModal('approveModal', event)">&times;</button>
        </div>
        <div class="approve-modal-body">
            <div class="approve-info-box">
                <strong><i class="fa-solid fa-info-circle"></i> Informasi: Silahkan isi Nomor Surat sebelum disetujui</strong>
                <span id="approveNamaKegiatan"></span>
            </div>
            
            <form id="approveForm" method="POST" action="">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <input type="hidden" id="currentPage" name="from" value="semua">
                <input type="hidden" name="tahun" value="<?= $this->input->get('tahun') ?? date('Y') ?>">
                <input type="hidden" name="bulan" value="<?= $this->input->get('bulan') ?? 'all' ?>">
                <input type="hidden" name="search" value="<?= $this->input->get('search') ?>">
                <input type="hidden" name="status" value="<?= $this->input->get('status') ?>">
                <input type="hidden" name="jenis_penugasan" value="<?= $this->input->get('jenis_penugasan') ?>">
                
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
                    <button type="button" class="approve-btn approve-btn-cancel" onclick="closeModal('approveModal', event)">
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
    <div class="reject-modal-content" onclick="event.stopPropagation()">
        <div class="reject-modal-header">
            <h3><i class="fa-solid fa-ban"></i> Tolak Pengajuan</h3>
            <button class="close-modal" onclick="closeModal('rejectModal', event)">&times;</button>
        </div>
        <div class="reject-modal-body">
            <div class="reject-info-box">
                <strong><i class="fa-solid fa-info-circle"></i> Informasi:</strong>
                <span id="rejectNamaKegiatan"></span>
            </div>
            
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

            <div class="approve-modal-actions">
                <button type="button" class="approve-btn approve-btn-cancel" onclick="closeModal('rejectModal', event)">
                    <i class="fa-solid fa-times"></i> Batal
                </button>
                <button type="button" class="approve-btn modal-btn-reject" onclick="confirmReject(event)">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Penolakan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- PIN Modal -->
<div id="pinModal" class="pin-modal">
    <div style="background:#fff;padding:25px;border-radius:12px;width:350px;text-align:center;box-shadow:0 10px 25px rgba(0,0,0,0.2);">
        <h3 style="margin-bottom:15px;color:#333;">
            <i class="fas fa-lock" style="margin-right:8px;color:#16A085;"></i>Masukkan PIN
        </h3>
        
        <div class="pin-input-container">
            <i class="fas fa-key pin-icon"></i>
            <input type="password" 
                   id="pinInput" 
                   maxlength="4"
                   class="pin-input-with-icon"
                   placeholder="••••"
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>
        
        <div style="display:flex;gap:10px;justify-content:center;margin-top:20px;">
            <button onclick="checkPin()" 
                    class="btn btn-primary"
                    style="background:#16A085;color:white;border:none;padding:10px 20px;border-radius:6px;cursor:pointer;font-weight:600;">
                <i class="fas fa-check"></i> Lanjut
            </button>
            <button onclick="closePinModal()" 
                    class="btn btn-secondary"
                    style="background:#95a5a6;color:white;border:none;padding:10px 20px;border-radius:6px;cursor:pointer;font-weight:600;">
                <i class="fas fa-times"></i> Batal
            </button>
        </div>
        
        <p style="margin-top:15px;font-size:12px;color:#7f8c8d;">
            <i class="fas fa-info-circle"></i> PIN terdiri dari 4 digit angka
        </p>
    </div>
</div>

<script>
let currentRejectId = null;
let currentApproveId = null;
let currentPage = 'semua';
let selectedSurat = null;

// ============================================
// FUNGSI DISPOSISI
// ============================================

function openPinModal(id, event) {
    if (event) event.stopPropagation();
    selectedSurat = id;
    document.getElementById("pinModal").style.display = "flex";
    document.getElementById("pinInput").focus();
}

function closePinModal() {
    document.getElementById("pinModal").style.display = "none";
    document.getElementById("pinInput").value = "";
}

function checkPin() {
    let pin = document.getElementById("pinInput").value;

    if (pin !== "1234") {
        alert("PIN salah!");
        document.getElementById("pinInput").value = "";
        document.getElementById("pinInput").focus();
        return;
    }

    if (document.getElementById("disposisiBox" + selectedSurat)) {
        document.getElementById("disposisiBox" + selectedSurat).style.display = "block";
    }
    closePinModal();
}

function onDisposisiChange(id, event) {
    if (event) event.stopPropagation();
    let val = document.getElementById("disposisiSelect" + id).value;
    let catatanLabel = document.getElementById("labelCatatan" + id);
    let catatanTextarea = document.getElementById("catatanDisposisi" + id);
    let btnSave = document.getElementById("btnSaveDisposisi" + id);

    if (btnSave) btnSave.style.display = "none";
    if (catatanLabel) catatanLabel.style.display = "none";
    if (catatanTextarea) {
        catatanTextarea.style.display = "none";
        catatanTextarea.value = "";
    }
    
    if (val === "Hold/Pending" || val === "Batal") {
        if (catatanLabel) catatanLabel.style.display = "block";
        if (catatanTextarea) {
            catatanTextarea.style.display = "block";
            if (val === "Hold/Pending") {
                catatanTextarea.placeholder = "Berikan alasan mengapa perlu ditahan/ditunda...";
            } else if (val === "Batal") {
                catatanTextarea.placeholder = "Berikan alasan pembatalan...";
            }
        }
        if (btnSave) btnSave.style.display = "block";
        setTimeout(() => {
            if (catatanTextarea) catatanTextarea.focus();
        }, 100);
    } else if (val === "Lanjut Proses ✔") {
        if (btnSave) btnSave.style.display = "block";
    }
}

function saveDisposisi(id, event) {
    if (event) event.stopPropagation();
    
    let disposisiSelect = document.getElementById("disposisiSelect" + id);
    let catatanTextarea = document.getElementById("catatanDisposisi" + id);
    
    if (!disposisiSelect) {
        alert("Element disposisi tidak ditemukan!");
        return;
    }
    
    let disposisi = disposisiSelect.value;
    let catatan = catatanTextarea ? catatanTextarea.value : "";

    if (!disposisi) {
        alert("Pilih disposisi dulu!");
        return;
    }

    if ((disposisi === "Hold/Pending" || disposisi === "Batal") && catatan === "") {
        alert("Wajib Mengisi Catatan!");
        if (catatanTextarea) catatanTextarea.focus();
        return;
    }

    fetch("<?= base_url('sekretariat/set_disposisi') ?>", {
        method: "POST",
        headers: { 
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: JSON.stringify({
            id: id,
            disposisi: disposisi,
            catatan: catatan,
            <?= $this->security->get_csrf_token_name() ?>: "<?= $this->security->get_csrf_hash() ?>"
        })
    })
    .then(res => {
        if (!res.ok) {
            throw new Error('Network response was not ok');
        }
        return res.json();
    })
    .then(data => {
        if (data.success) {
            alert("Disposisi tersimpan!");
            location.reload();
        } else {
            alert(data.message || "Gagal menyimpan disposisi");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Terjadi kesalahan saat menyimpan disposisi");
    });
}

// ============================================
// FUNGSI LAINNYA
// ============================================

function getSuratDetail(id) {
    return fetch('<?= site_url("sekretariat/getDetailPengajuan/") ?>' + id)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
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
function previewFile(fileUrl, fileName, event) {
    if (event) event.stopPropagation();
    
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
                previewBody.innerHTML = `<img src="${fileUrl}" class="preview-image" alt="${fileName}">`;
            };
            img.onerror = function() {
                showUnsupportedPreview(fileUrl, fileName);
            };
            img.src = fileUrl;
        } else if (pdfExtensions.includes(fileExtension)) {
            previewBody.innerHTML = `
                <iframe 
                    src="${fileUrl}" 
                    class="preview-iframe" 
                    frameborder="0"
                    title="Preview PDF: ${fileName}"
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

function closePreviewModal(event) {
    if (event) event.stopPropagation();
    document.getElementById('previewModal').classList.remove('show');
}

// Fungsi untuk menampilkan modal eviden
async function showEvidenModal(suratId, event) {
    if (event) event.stopPropagation();
    
    try {
        const item = await getSuratDetail(suratId);
        
        if (!item) {
            alert('Data tidak ditemukan');
            return;
        }

        const evidenFiles = getEvidenFilesFromData(item);
        
        if (evidenFiles.length === 0) {
            alert('Tidak ada file eviden untuk pengajuan ini.');
            return;
        }
        
        if (evidenFiles.length === 1) {
            const file = evidenFiles[0];
            previewFile(file.url, file.name, event);
        } else {
            showMultipleEvidenModal(item, evidenFiles);
        }
        
    } catch (error) {
        console.error('Error loading eviden:', error);
        alert('Gagal memuat eviden: ' + error.message);
    }
}

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
                const fileName = getFileNameFromPath(evidenValue);
                const fileUrl = getFileUrl(evidenValue, baseUrl);
                evidenFiles.push({
                    name: fileName,
                    url: fileUrl,
                    ext: fileName.split('.').pop().toLowerCase()
                });
            }
        } catch (e) {
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

function getFileNameFromPath(path) {
    if (!path) return 'file';
    return path.split('/').pop().split('\\').pop();
}

function getFileUrl(filePath, baseUrl) {
    if (!filePath) return '#';
    
    if (filePath.startsWith('http://') || filePath.startsWith('https://') || filePath.startsWith('<?= base_url() ?>')) {
        return filePath;
    }
    
    const fileName = getFileNameFromPath(filePath);
    const possiblePaths = [
        'uploads/eviden/' + fileName,
        'eviden/' + fileName,
        'assets/eviden/' + fileName,
        'uploads/' + fileName,
        filePath
    ];
    
    for (const path of possiblePaths) {
        const fullUrl = baseUrl + path;
        return fullUrl;
    }
    
    return baseUrl + possiblePaths[0];
}

function showMultipleEvidenModal(item, evidenFiles) {
    document.getElementById('evidenContent').innerHTML = `
        <div style="text-align:center;padding:40px;">
            <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#16A085"></i>
            <p style="margin-top:10px;color:#7f8c8d">Memuat eviden...</p>
        </div>
    `;
    
    document.getElementById('evidenModal').classList.add('show');
    
    const content = generateMultipleEvidenContent(item, evidenFiles);
    document.getElementById('evidenContent').innerHTML = content;
}

function generateMultipleEvidenContent(item, evidenFiles) {
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
            
            const previewHandler = canPreview ? `onclick="previewFile('${file.url}', '${file.name}', event)"` : '';
            
            fileEvidenceHtml += `
                <div class="file-item">
                    <div class="file-icon">
                        <i class="fa-solid ${fileIcon}"></i>
                    </div>
                    <div class="file-info" ${previewHandler} style="${canPreview ? 'cursor: pointer;' : ''}">
                        <div class="file-name" ${canPreview ? 'title="Klik untuk preview"' : ''}>${escapeHtml(file.name)}</div>
                        <div class="file-size">File ${index + 1} - ${ext.toUpperCase()}</div>
                    </div>
                    ${canPreview ? 
                        `<button class="preview-btn" onclick="previewFile('${file.url}', '${file.name}', event)">
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
            <button class="modal-btn modal-btn-close" onclick="closeModal('evidenModal', event)">
                <i class="fa-solid fa-times"></i> Tutup
            </button>
        </div>
    `;
}

// ============================================
// FUNGSI UTAMA
// ============================================

// FUNGSI 1: Klik BARIS - Menampilkan DETAIL PENGAJUAN
async function showDetailPengajuan(id, event) {
    if (event) event.stopPropagation();
    
    try {
        document.getElementById('detailContent').innerHTML = `
            <div style="text-align:center;padding:40px;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#16A085"></i>
                <p style="margin-top:10px;color:#7f8c8d">Memuat detail pengajuan...</p>
            </div>
        `;
        
        // Ganti judul modal menjadi "Detail Pengajuan"
        document.querySelector('#detailModal .modal-header h3').innerHTML = `
            <i class="fa-solid fa-info-circle"></i> Detail Pengajuan
        `;
        
        // Tampilkan modal
        document.getElementById('detailModal').classList.add('show');

        const response = await fetch('<?= site_url("sekretariat/getDetailPengajuan/") ?>' + id);
        const result = await response.json();
        
        if (!result.success) {
            throw new Error(result.message || 'Gagal memuat data');
        }

        const data = result.data;
        
        const formatDate = (dateStr) => {
            if (!dateStr || dateStr === '-' || dateStr === '0000-00-00') return '-';
            const date = new Date(dateStr);
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });
        };

        const getStatusBadge = (status) => {
            if (!status) return '<span class="badge badge-pending">-</span>';
            
            const statusLower = status.toLowerCase();
            if (statusLower.includes('disetujui') && statusLower.includes('kk')) {
                return '<span class="badge badge-pending">Menunggu Sekretariat</span>';
            } else if (statusLower.includes('disetujui') && statusLower.includes('sekretariat')) {
                return '<span class="badge badge-approved">Disetujui Sekretariat</span>';
            } else if (statusLower.includes('ditolak') && statusLower.includes('sekretariat')) {
                return '<span class="badge badge-rejected">Ditolak Sekretariat</span>';
            } else if (statusLower.includes('disetujui') && statusLower.includes('dekan')) {
                return '<span class="badge badge-completed">Disetujui Dekan</span>';
            } else if (statusLower.includes('ditolak') && statusLower.includes('dekan')) {
                return '<span class="badge badge-rejected">Ditolak Dekan</span>';
            } else if (statusLower.includes('pending') || statusLower.includes('menunggu')) {
                return '<span class="badge badge-pending">' + status + '</span>';
            } else if (statusLower.includes('setuju') || statusLower.includes('approved')) {
                return '<span class="badge badge-approved">' + status + '</span>';
            } else if (statusLower.includes('tolak') || statusLower.includes('rejected')) {
                return '<span class="badge badge-rejected">' + status + '</span>';
            }
            return '<span class="badge badge-pending">' + status + '</span>';
        };

        let detailHtml = `
            <div class="detail-section">
                <div class="detail-section-title">
                    <i class="fa-solid fa-info-circle"></i> Informasi Pengajuan
                </div>
                <div class="detail-grid">
                    <div class="detail-row">
                        <div class="detail-label">Nama Kegiatan</div>
                        <div class="detail-value">${escapeHtml(data.nama_kegiatan || '-')}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Penyelenggara</div>
                        <div class="detail-value">${escapeHtml(data.penyelenggara || '-')}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Jenis Pengajuan</div>
                        <div class="detail-value">${escapeHtml(data.jenis_pengajuan || '-')}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Jenis Penugasan</div>
                        <div class="detail-value">${escapeHtml(data.jenis_penugasan || '-')}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Status</div>
                        <div class="detail-value">${getStatusBadge(data.status)}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Tanggal Pengajuan</div>
                        <div class="detail-value">${formatDate(data.created_at)}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Tanggal Kegiatan</div>
                        <div class="detail-value">${formatDate(data.tanggal_kegiatan)}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Lokasi Kegiatan</div>
                        <div class="detail-value">${escapeHtml(data.lokasi_kegiatan || '-')}</div>
                    </div>
                </div>
            </div>
            
            <div class="detail-section">
                <div class="detail-section-title">
                    <i class="fa-solid fa-user"></i> Informasi Dosen
                </div>
                <div class="detail-grid">
        `;

        if (data.jenis_penugasan === 'perorangan') {
            detailHtml += `
                <div class="detail-row">
                    <div class="detail-label">Nama Dosen</div>
                    <div class="detail-value">${escapeHtml(data.nama_dosen || '-')}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">NIDN/NIDK</div>
                    <div class="detail-value">${escapeHtml(data.nidn || data.nidk || '-')}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Jabatan Fungsional</div>
                    <div class="detail-value">${escapeHtml(data.jabatan_fungsional || '-')}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Program Studi</div>
                    <div class="detail-value">${escapeHtml(data.prodi || '-')}</div>
                </div>
            `;
        } else if (data.jenis_penugasan === 'kelompok') {
            try {
                const dosenList = typeof data.dosen === 'string' ? JSON.parse(data.dosen) : data.dosen;
                if (Array.isArray(dosenList) && dosenList.length > 0) {
                    detailHtml += `<div class="detail-row" style="grid-column: 1 / -1;">
                        <div class="detail-label">Dosen Kelompok</div>
                        <div class="dosen-list">`;
                    
                    dosenList.forEach((dosen, index) => {
                        detailHtml += `
                            <div class="dosen-item">
                                <div class="dosen-avatar">${(index + 1)}</div>
                                <div class="dosen-info">
                                    <div class="dosen-name">${escapeHtml(dosen.nama || '-')}</div>
                                    <div class="dosen-details">
                                        NIDN: ${escapeHtml(dosen.nidn || '-')} | 
                                        Jabatan: ${escapeHtml(dosen.jabatan_fungsional || '-')}
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    detailHtml += `</div></div>`;
                } else {
                    detailHtml += `<div class="detail-row" style="grid-column: 1 / -1;">
                        <div class="detail-value detail-value-empty">Tidak ada data dosen</div>
                    </div>`;
                }
            } catch (e) {
                detailHtml += `<div class="detail-row" style="grid-column: 1 / -1;">
                    <div class="detail-value detail-value-empty">Format data dosen tidak valid</div>
                </div>`;
            }
        }

        detailHtml += `
                </div>
            </div>
            
            <div class="detail-section">
                <div class="detail-section-title">
                    <i class="fa-solid fa-file-alt"></i> Informasi Surat
                </div>
                <div class="detail-grid">
                    <div class="detail-row">
                        <div class="detail-label">Nomor Surat (Jika Ada)</div>
                        <div class="detail-value">${escapeHtml(data.nomor_surat || '-')}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Perihal</div>
                        <div class="detail-value">${escapeHtml(data.perihal || '-')}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Tujuan Surat</div>
                        <div class="detail-value">${escapeHtml(data.tujuan_surat || '-')}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Disposisi</div>
                        <div class="detail-value">${escapeHtml(data.disposisi_status || '-')}</div>
                    </div>
                    ${data.disposisi_catatan ? `
                    <div class="detail-row">
                        <div class="detail-label">Catatan Disposisi</div>
                        <div class="detail-value">${escapeHtml(data.disposisi_catatan)}</div>
                    </div>` : ''}
                </div>
            </div>
        `;

        if (data.notes && data.status && data.status.toLowerCase().includes('ditolak')) {
            detailHtml += `
                <div class="detail-section rejection-notes">
                    <div class="detail-section-title">
                        <i class="fa-solid fa-exclamation-triangle"></i> Alasan Penolakan
                    </div>
                    <div class="detail-row">
                        <div class="detail-value">${escapeHtml(data.notes)}</div>
                    </div>
                </div>
            `;
        }

        detailHtml += `
            <div class="modal-actions">
                <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal', event)">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
                
                <button class="modal-btn btn-detail" onclick="showSuratTugas(${id}, event)">
                    <i class="fa-solid fa-eye"></i> Lihat Surat Tugas
                </button>
        `;

        if (data.status === 'disetujui KK' && data.disposisi_status === 'Lanjut Proses ✔') {
            detailHtml += `
                <button class="modal-btn modal-btn-reject" onclick="showRejectModal(${id}, '${escapeHtml(data.nama_kegiatan || '')}', 'semua', event)">
                    <i class="fa-solid fa-times"></i> Tolak
                </button>
                <button class="modal-btn modal-btn-approve" onclick="showApproveModal(${id}, '${escapeHtml(data.nama_kegiatan || '')}', 'semua', event)">
                    <i class="fa-solid fa-check"></i> Setujui
                </button>
            `;
        }
        
        detailHtml += `
                <button class="modal-btn modal-btn-close" onclick="showEvidenModal(${id}, event)">
                    <i class="fa-solid fa-file-image"></i> Lihat Eviden
                </button>
            </div>
        `;

        document.getElementById('detailContent').innerHTML = detailHtml;
        
    } catch (error) {
        console.error('Error loading detail:', error);
        document.getElementById('detailContent').innerHTML = `
            <div style="text-align:center;padding:40px;color:#e74c3c">
                <i class="fa-solid fa-exclamation-triangle" style="font-size:48px;margin-bottom:10px"></i>
                <p>Gagal memuat data: ${error.message}</p>
                <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal', event)" style="margin-top:20px">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
            </div>
        `;
    }
}

// FUNGSI 2: Tombol MATA - Menampilkan SURAT TUGAS (iframe)
function showSuratTugas(id, event) {
    if (event) event.stopPropagation();
    
    try {
        document.getElementById('detailContent').innerHTML = `
            <div style="text-align:center;padding:40px;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#16A085"></i>
                <p style="margin-top:10px;color:#7f8c8d">Memuat surat tugas...</p>
            </div>
        `;
        
        // Ganti judul modal menjadi "Surat Tugas"
        document.querySelector('#detailModal .modal-header h3').innerHTML = `
            <i class="fa-solid fa-file-alt"></i> Surat Tugas
        `;
        
        // Tampilkan modal
        document.getElementById('detailModal').classList.add('show');
        
        setTimeout(() => {
            const suratUrl = '<?= base_url("sekretariat/view_surat_pengajuan/") ?>' + id;
            document.getElementById('detailContent').innerHTML = `
                <iframe 
                    src="${suratUrl}" 
                    style="width:100%; height:70vh; border:none; border-radius:8px; opacity:0; transition: opacity 0.3s;"
                    onload="this.style.opacity=1"
                    title="Surat Tugas"
                ></iframe>
                <div class="modal-actions">
                    <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal', event)">
                        <i class="fa-solid fa-times"></i> Tutup
                    </button>
                </div>
            `;
        }, 300);
        
    } catch (error) {
        console.error('Error loading surat tugas:', error);
        document.getElementById('detailContent').innerHTML = `
            <div style="text-align:center;padding:40px;color:#e74c3c">
                <i class="fa-solid fa-exclamation-triangle" style="font-size:48px;margin-bottom:10px"></i>
                <p>Gagal memuat surat tugas: ${error.message}</p>
                <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal', event)" style="margin-top:20px">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
            </div>
        `;
    }
}

// ============================================
// FUNGSI BUTTON DI TABEL
// ============================================

function showSuratTugasFromButton(id, event) {
    if (event) event.stopPropagation();
    showSuratTugas(id, event);
}

// ============================================
// FUNGSI APPROVE & REJECT
// ============================================

function showApproveModal(id, namaKegiatan, page = 'semua', event) {
    if (event) event.stopPropagation();
    currentApproveId = id;
    currentPage = page;
    document.getElementById('approveNamaKegiatan').textContent = namaKegiatan;
    document.getElementById('nomorSurat').value = '';
    document.getElementById('approveForm').action = '<?= base_url("sekretariat/approve/") ?>' + id;
    document.getElementById('currentPage').value = page;
    document.getElementById('approveModal').classList.add('show');
    
    setTimeout(() => {
        document.getElementById('nomorSurat').focus();
    }, 300);
}

function showRejectModal(id, namaKegiatan, page = 'semua', event) {
    if (event) event.stopPropagation();
    currentRejectId = id;
    currentPage = page;
    document.getElementById('rejectNamaKegiatan').textContent = namaKegiatan;
    document.getElementById('rejectionNotes').value = '';
    document.getElementById('rejectModal').classList.add('show');
    
    setTimeout(() => {
        document.getElementById('rejectionNotes').focus();
    }, 300);
}

function confirmReject(event) {
    if (event) event.stopPropagation();
    
    const notes = document.getElementById('rejectionNotes').value.trim();
    if (!notes) { 
        alert('Alasan penolakan harus diisi'); 
        document.getElementById('rejectionNotes').focus();
        return; 
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= base_url("sekretariat/reject/") ?>' + currentRejectId;
    form.style.display = 'none';
    
    const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
    const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
    const inpCsrf = document.createElement('input');
    inpCsrf.type='hidden'; 
    inpCsrf.name=csrfName; 
    inpCsrf.value=csrfHash;
    form.appendChild(inpCsrf);
    
    const params = {
        'from': currentPage,
        'tahun': '<?= $this->input->get('tahun') ?? date('Y') ?>',
        'bulan': '<?= $this->input->get('bulan') ?? 'all' ?>',
        'search': '<?= $this->input->get('search') ?>',
        'status': '<?= $this->input->get('status') ?>',
        'jenis_penugasan': '<?= $this->input->get('jenis_penugasan') ?>'
    };
    
    for (const key in params) {
        if (params[key] !== undefined && params[key] !== null) {
            const inp = document.createElement('input');
            inp.type='hidden'; 
            inp.name=key; 
            inp.value=params[key];
            form.appendChild(inp);
        }
    }
    
    const inpNotes = document.createElement('input');
    inpNotes.type='hidden'; 
    inpNotes.name='rejection_notes'; 
    inpNotes.value=notes;
    form.appendChild(inpNotes);
    
    document.body.appendChild(form);
    form.submit();
}

function closeModal(id, event) { 
    if (event) event.stopPropagation();
    document.getElementById(id).classList.remove('show'); 
}

function modalClickOutside(evt, id) { 
    if (evt.target && evt.target.id === id) closeModal(id); 
}

// ============================================
// HELPER FUNCTIONS
// ============================================

function formatDate(d) {
    if (!d || d === '-' || d === '0000-00-00' || d === '0000-00-00 00:00:00') return '-';
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
// EVENT HANDLERS & INITIALIZATION
// ============================================

function makeRowsClickable() {
    const rows = document.querySelectorAll('#tableBody tr.clickable-row');
    
    rows.forEach(row => {
        // Cari ID surat dari data baris
        let suratId = null;
        
        // Coba cari dari tombol disposisi
        const disposisiBtn = row.querySelector('.btn-disposisi[onclick*="openPinModal"]');
        if (disposisiBtn) {
            const onclickAttr = disposisiBtn.getAttribute('onclick');
            const match = onclickAttr.match(/openPinModal\((\d+)/);
            if (match) {
                suratId = match[1];
            }
        }
        
        // Jika tidak ditemukan, coba dari tombol eviden
        if (!suratId) {
            const evidenBtn = row.querySelector('.btn-eviden[onclick*="showEvidenModal"]');
            if (evidenBtn) {
                const onclickAttr = evidenBtn.getAttribute('onclick');
                const match = onclickAttr.match(/showEvidenModal\((\d+)/);
                if (match) {
                    suratId = match[1];
                }
            }
        }
        
        // Jika masih tidak ditemukan, coba dari tombol mata
        if (!suratId) {
            const detailBtn = row.querySelector('.btn-detail[onclick*="showSuratTugasFromButton"]');
            if (detailBtn) {
                const onclickAttr = detailBtn.getAttribute('onclick');
                const match = onclickAttr.match(/showSuratTugasFromButton\((\d+)/);
                if (match) {
                    suratId = match[1];
                }
            }
        }
        
        // Jika ID ditemukan, tambahkan event listener
        if (suratId) {
            row.addEventListener('click', function(e) {
                // Cek apakah yang diklik adalah element yang tidak boleh trigger row click
                const clickedElement = e.target;
                const isClickableElement = 
                    clickedElement.closest('button') || 
                    clickedElement.closest('a') || 
                    clickedElement.closest('select') ||
                    clickedElement.closest('textarea') ||
                    clickedElement.closest('input') ||
                    clickedElement.closest('.btn') ||
                    clickedElement.closest('.btn-disposisi') ||
                    clickedElement.closest('.file-info') ||
                    clickedElement.closest('.preview-btn') ||
                    clickedElement.closest('.download-btn');
                
                if (isClickableElement) {
                    return;
                }
                
                // Highlight baris yang dipilih
                rows.forEach(r => r.classList.remove('selected'));
                this.classList.add('selected');
                
                // Tampilkan detail pengajuan
                showDetailPengajuan(suratId, e);
            });
            
            row.style.cursor = 'pointer';
        }
    });
}

function initializeEventListeners() {
    makeRowsClickable();
    
    // Tambahkan event listener untuk semua element di dalam tabel
    document.querySelectorAll('#tableBody button, #tableBody a, #tableBody select, #tableBody textarea, #tableBody input').forEach(element => {
        element.addEventListener('click', function(e) {
            e.stopPropagation();
        });
        
        element.addEventListener('mousedown', function(e) {
            e.stopPropagation();
        });
        
        element.addEventListener('touchstart', function(e) {
            e.stopPropagation();
        });
    });
    
    // Event untuk PIN input (Enter key)
    document.getElementById('pinInput')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            checkPin();
        }
    });
    
    // Event untuk nomor surat input (Enter key)
    document.getElementById('nomorSurat')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('approveForm').dispatchEvent(new Event('submit'));
        }
    });
    
    // Event untuk rejection notes (Enter key dengan Ctrl)
    document.getElementById('rejectionNotes')?.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.ctrlKey) {
            e.preventDefault();
            confirmReject(e);
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    initializeEventListeners();
    
    // Tambahkan CSS untuk mencegah selection pada klik
    document.head.insertAdjacentHTML('beforeend', `
        <style>
            #tableBody button, #tableBody a, #tableBody select, #tableBody textarea, #tableBody input {
                user-select: none;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
            }
            
            .clickable-row {
                position: relative;
            }
            
            .clickable-row::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 1;
                pointer-events: none;
            }
            
            .clickable-row td > * {
                position: relative;
                z-index: 2;
            }
        </style>
    `);
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modals = ['detailModal', 'evidenModal', 'approveModal', 'rejectModal', 'previewModal', 'pinModal'];
        modals.forEach(modalId => {
            if (document.getElementById(modalId)?.classList.contains('show')) {
                closeModal(modalId);
            }
        });
    }
});
</script>
</body>
</html>