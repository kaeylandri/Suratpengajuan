<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengajuan Ditolak - Dashboard Sekretariat</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    /* STYLE UTAMA (SAMA DENGAN DASHBOARD DAN DISETUJUI) */
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;background:#f5f7fa;}
    .navbar{background:#16A085;color:white;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
    .navbar h2{font-size:20px;}
    .container{max-width:1200px;margin:30px auto;padding:0 20px;}
    
    /* Back Button */
    .back-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#16A085;color:white;text-decoration:none;border-radius:8px;font-weight:600;transition:all 0.3s;margin-bottom:20px}
    .back-btn:hover{background:#138D75;transform:translateY(-2px)}
    
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
    .badge-approved{background:#d4edda;color:#155724}
    .badge-sekretariat{background:#d1ecf1;color:#0c5460}
    .badge-rejected{background:#f8d7da;color:#721c24}
    .badge-pending{background:#fff3cd;color:#856404}
    
    /* Button Styles (SAMA DENGAN DASHBOARD) */
    .btn{padding:6px 10px;border-radius:6px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s}
    .btn:hover{transform:scale(1.05)}
    .btn-detail{background:#3498db;color:#fff}
    .btn-detail:hover{background:#2980b9}
    
    /* Tombol Eviden - WARNA HIJAU */
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

    /* Tombol Return - WARNA ORANGE/KUNING */
    .btn-return {
        background: #ff9800 !important;
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

    .btn-return i {
        font-size: 14px;
    }

    .btn-return:hover {
        background: #f57c00 !important;
        transform: scale(1.05);
    }

    /* Tombol Edit - WARNA KUNING */
    .btn-edit {
        background: #ffc107 !important;
        color: #000 !important;
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
        text-decoration: none;
    }

    .btn-edit:hover {
        background: #e0a800 !important;
        transform: scale(1.05);
        text-decoration: none;
    }

    /* Tombol Disposisi - WARNA KUNING */
    .btn-disposisi {
        background: #f1c40f !important;
        color: #000 !important;
        border: none !important;
        border-radius: 5px !important;
        padding: 6px 12px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        transition: 0.2s ease-in-out;
        font-size: 14px;
        height: 32px;
        cursor: pointer;
    }

    .btn-disposisi:hover {
        background: #d4ac0d !important;
        transform: scale(1.05);
    }

    /* Tombol Masukkan Nomor Surat - WARNA BIRU */
    .btn-nomor {
        background: #3498db !important;
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

    .btn-nomor i {
        font-size: 14px;
    }

    .btn-nomor:hover {
        background: #2980b9 !important;
        transform: scale(1.05);
    }

    /* Tombol Cetak - WARNA UNGU */
    .btn-cetak {
        background: #9b59b6 !important;
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

    .btn-cetak i {
        font-size: 14px;
    }

    .btn-cetak:hover {
        background: #8e44ad !important;
        transform: scale(1.05);
    }

    /* Tombol Download PDF - WARNA HIJAU */
    .btn-download {
        background: #2ecc71 !important;
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
        text-decoration: none !important;
    }

    .btn-download:hover {
        background: #27ae60 !important;
        transform: scale(1.05);
        text-decoration: none !important;
    }

    /* Pagination Info */
    .pagination-info{margin-top:15px;color:#7f8c8d;font-size:14px;text-align:right}
    
    /* Modal Styles - SAMA DENGAN DASHBOARD */
    .modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.45);align-items:center;justify-content:center}
    .modal.show{display:flex}
    .modal-content{background:white;padding:0;border-radius:15px;max-width:800px;width:95%;max-height:85vh;overflow:hidden;animation:slideIn 0.3s ease;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
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
    
    /* File Evidence Styles - SAMA DENGAN DASHBOARD */
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

    /* Preview Modal Styles - SAMA DENGAN DASHBOARD */
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
    
    /* Action Buttons in Modal - SAMA DENGAN DASHBOARD */
    .modal-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:20px;padding-top:20px;border-top:1px solid #e9ecef}
    .modal-btn{padding:10px 20px;border-radius:8px;border:none;cursor:pointer;font-weight:600;font-size:14px;transition:all 0.2s;display:flex;align-items:center;gap:8px}
    .modal-btn-close{background:#6c757d;color:white}
    .modal-btn-close:hover{background:#5a6268;transform:translateY(-2px)}
    
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

    /* Disposisi Card Styles - SAMA DENGAN DASHBOARD */
    .disposisi-card {
        background: #ffffff;
        padding: 18px 20px;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.12);
        margin-top: 10px;
        border: 1px solid #eee;
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

    .select-disposisi:focus {
        border-color: #0080ff;
        background: #fff;
        box-shadow: 0 0 5px rgba(0,128,255,0.2);
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
    }

    .textarea-disposisi:focus {
        border-color: #0080ff;
        background: #fff;
        box-shadow: 0 0 5px rgba(0,128,255,0.2);
    }

    /* Styling untuk info disposisi dengan timestamp - SAMA DENGAN DASHBOARD */
    .disposisi-info-box {
        margin-top: 8px;
        padding: 8px;
        background: #f8f9fa;
        border-radius: 6px;
        border-left: 3px solid #16A085;
    }

    .disposisi-status-text {
        display: block;
        margin-bottom: 4px;
    }

    .disposisi-status-text strong {
        color: #16A085;
    }

    .disposisi-status-text span {
        color: #2c3e50;
        font-weight: 600;
    }

    .disposisi-timestamp {
        display: block;
        color: #7f8c8d;
        font-size: 11px;
        margin-bottom: 4px;
    }

    .disposisi-catatan-text {
        display: block;
        color: #7f8c8d;
        font-size: 11px;
        font-style: italic;
        margin-top: 4px;
        padding: 4px 6px;
        background: white;
        border-radius: 4px;
    }

    .approval-status-box {
        margin-top: 8px;
        padding: 6px 8px;
        border-radius: 4px;
    }

    .approval-status-box.approved {
        background: #d4edda;
        color: #155724;
    }

    .approval-status-box.rejected {
        background: #f8d7da;
        color: #721c24;
    }

    .approval-timestamp-small {
        display: block;
        color: #6c757d;
        font-size: 10px;
        margin-top: 2px;
    }

    /* Search Box Styles - SAMA DENGAN DASHBOARD */
    .search-container{margin-bottom:20px}
    .search-label{display:block;margin-bottom:8px;color:#6c757d;font-size:14px;font-weight:500}
    .search-box{display:flex;gap:10px;align-items:center;width:100%}
    .search-input-wrapper{position:relative;flex:1}
    .search-input{width:100%;padding:12px 45px 12px 15px;border:1px solid #e9ecef;border-radius:8px;font-size:14px;transition:all 0.3s;background:white;color:#495057}
    .search-input:focus{outline:none;border-color:#16A085;box-shadow:0 0 0 2px rgba(22,160,133,0.1)}
    .search-input::placeholder{color:#6c757d}
    .search-icon{position:absolute;right:15px;top:50%;transform:translateY(-50%);color:#6c757d;font-size:16px}
    .btn-cari{padding:12px 24px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#16A085;color:#fff;white-space:nowrap}
    .btn-cari:hover{background:#138D75;transform:translateY(-1px)}
    .btn-reset{padding:12px 24px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#95a5a6;color:#fff;white-space:nowrap;text-decoration:none}
    .btn-reset:hover{background:#7f8c8d;transform:translateY(-1px);color:white;text-decoration:none}
    
    /* Clickable Row Styles - SAMA DENGAN DASHBOARD */
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

    /* Highlight untuk baris yang sedang dipilih */
    .clickable-row.selected {
        background-color: #e8f6f3 !important;
    }

    /* Pastikan tombol di dalam row tidak ter-affected */
    .clickable-row button,
    .clickable-row select,
    .clickable-row textarea,
    .clickable-row input {
        pointer-events: all;
    }
    
    /* Modal PIN Styles - SAMA DENGAN DASHBOARD */
    .modal-pin-box {
        background: #ffffff;
        width: 360px;
        padding: 28px;
        border-radius: 14px;
        text-align: center;
        box-shadow: 0 12px 35px rgba(0,0,0,0.18);
        animation: fadeInUp 0.25s ease-out;
    }

    @keyframes fadeInUp {
        from {opacity: 0; transform: translateY(15px);}
        to   {opacity: 1; transform: translateY(0);}
    }

    .modal-pin-title {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 5px;
        color: #2c3e50;
    }

    .modal-pin-title i {
        color: #16A085;
        margin-right: 6px;
    }

    .modal-pin-sub {
        font-size: 12px;
        color: #7f8c8d;
        margin-bottom: 20px;
    }

    .pin-field {
        margin-bottom: 12px;
    }

    .pin-field input {
        width: 100%;
        padding: 12px 14px;
        border: 2px solid #dfe6e9;
        border-radius: 8px;
        font-size: 15px;
        transition: 0.25s;
    }

    .pin-field input:focus {
        border-color: #16A085;
        outline: none;
        box-shadow: 0 0 0px 3px rgba(22,160,133,0.12);
    }

    .modal-pin-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-top: 18px;
    }

    .btn-save {
        background: #16A085;
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-save:hover {
        background: #138a70;
    }

    .btn-cancel {
        background: #b2bec3;
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-cancel:hover {
        background: #a4aeb3;
    }

    /* Data Count Info */
    .data-count-info {
        background: #fdf2f2;
        padding: 10px 15px;
        border-radius: 6px;
        margin-bottom: 15px;
        font-size: 14px;
        color: #721c24;
        border-left: 4px solid #e74c3c;
    }

    /* Status Header */
    .status-header-page {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .status-icon-page {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .status-icon-page.rejected {
        background: #f8d7da;
        color: #e74c3c;
    }

    .status-info-page h1 {
        margin: 0;
        color: #2c3e50;
        font-size: 28px;
    }

    .status-info-page p {
        margin: 5px 0 0 0;
        color: #7f8c8d;
        font-size: 16px;
    }

    /* Responsive */
    @media (max-width:768px){
        .detail-grid{grid-template-columns:1fr}
        .modal-content{width:95%;margin:10px}
        .detail-content{padding:15px}
        .modal-actions{flex-direction:column}
        .modal-btn{justify-content:center}
        .search-box{flex-direction:column}
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
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard Utama
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

    <!-- Status Header -->
    <div class="status-header-page">
        <div class="status-icon-page rejected">
            <i class="fa-solid fa-times-circle"></i>
        </div>
        <div class="status-info-page">
            <h1>Pengajuan Ditolak</h1>
            <p>Daftar pengajuan surat tugas yang telah ditolak</p>
        </div>
    </div>

    <!-- Tabel Pengajuan Ditolak -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-table"></i> Daftar Pengajuan Ditolak</h3>
            <div>
                <span id="filterInfo" style="color:#7f8c8d;font-size:13px">
                    Menampilkan: Semua Data (<?= isset($pengajuan_ditolak) ? count($pengajuan_ditolak) : '0' ?> data)
                </span>
            </div>
        </div>
        
        <!-- Info Jumlah Data -->
        <div class="data-count-info">
            <i class="fa-solid fa-info-circle"></i> 
            Menampilkan <strong><?= isset($pengajuan_ditolak) ? count($pengajuan_ditolak) : '0' ?></strong> dari <strong><?= isset($total_surat) ? $total_surat : '0' ?></strong> pengajuan yang ditolak
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
                <a href="<?= base_url('sekretariat/ditolak') ?>" class="btn-reset">
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
                        <th>Nomor Surat</th>
                        <th>Penyelenggara</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Tanggal Kegiatan</th>
                        <th>Jenis</th>
                        <th>Disposisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php if(isset($pengajuan_ditolak) && !empty($pengajuan_ditolak)): $no=1; foreach($pengajuan_ditolak as $s): 
                        // Handle both array and object access
                        $is_object = is_object($s);
                        
                        // Get tanggal pengajuan
                        $created_at = $is_object ? ($s->created_at ?? null) : ($s['created_at'] ?? null);
                        $tgl_pengajuan = $created_at ? date('d M Y', strtotime($created_at)) : '-';
                        
                        // Format tanggal kegiatan (SAMA DENGAN DASHBOARD)
                        $jenis_date = $is_object ? ($s->jenis_date ?? null) : ($s['jenis_date'] ?? null);
                        $periode_value = $is_object ? ($s->periode_value ?? null) : ($s['periode_value'] ?? null);
                        $tanggal_kegiatan = $is_object ? ($s->tanggal_kegiatan ?? null) : ($s['tanggal_kegiatan'] ?? null);
                        
                        // Determine tanggal kegiatan display (SAMA DENGAN DASHBOARD)
                        $tgl_kegiatan_display = '-';
                        if ($jenis_date === 'Periode') {
                            $periode_value_display = $periode_value && $periode_value !== '-' ? $periode_value : '-';
                            $tgl_kegiatan_display = '<span class="badge" style="background: #e3f2fd; color: #1976d2; padding: 6px 12px; border-radius: 15px; font-size: 12px; font-weight: 600;">
                                <i class="fas fa-calendar-alt"></i> ' . htmlspecialchars($periode_value_display) . '
                            </span>';
                        } else {
                            $tanggal_display = '-';
                            if ($tanggal_kegiatan && $tanggal_kegiatan !== '-') {
                                try {
                                    $tanggal_obj = new DateTime($tanggal_kegiatan);
                                    $hari = $tanggal_obj->format('j');
                                    $bulan = $tanggal_obj->format('n');
                                    $bulan_indonesia = [
                                        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
                                        7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                                    ];
                                    $bulan_nama = $bulan_indonesia[$bulan] ?? 'Des';
                                    $tahun = $tanggal_obj->format('Y');
                                    $tanggal_display = htmlspecialchars($hari . ' ' . $bulan_nama . ' ' . $tahun);
                                } catch (Exception $e) {
                                    $tanggal_display = htmlspecialchars($tanggal_kegiatan);
                                }
                            }
                            $tgl_kegiatan_display = $tanggal_display;
                        }
                        
                        // Get other data
                        $id = $is_object ? ($s->id ?? 0) : ($s['id'] ?? 0);
                        $nama_kegiatan = $is_object ? ($s->nama_kegiatan ?? '-') : ($s['nama_kegiatan'] ?? '-');
                        $nomor_surat = $is_object ? ($s->nomor_surat ?? '-') : ($s['nomor_surat'] ?? '-');
                        $penyelenggara = $is_object ? ($s->penyelenggara ?? '-') : ($s['penyelenggara'] ?? '-');
                        $jenis_pengajuan = $is_object ? ($s->jenis_pengajuan ?? '-') : ($s['jenis_pengajuan'] ?? '-');
                        $status = $is_object ? ($s->status ?? '') : ($s['status'] ?? '');
                        $disposisi_status = $is_object ? ($s->disposisi_status ?? '') : ($s['disposisi_status'] ?? '');
                        $disposisi_catatan = $is_object ? ($s->disposisi_catatan ?? '') : ($s['disposisi_catatan'] ?? '');
                        $disposisi_updated_at = $is_object ? ($s->disposisi_updated_at ?? '') : ($s['disposisi_updated_at'] ?? '');
                        $updated_at = $is_object ? ($s->updated_at ?? '') : ($s['updated_at'] ?? '');
                        
                        // Tentukan badge status
                        $status_display = 'Ditolak';
                        $badge_class = 'badge-rejected';
                        
                        if ($status == 'ditolak sekretariat') {
                            $status_display = 'Ditolak Sekretariat';
                            $badge_class = 'badge-rejected';
                        } elseif ($status == 'ditolak dekan') {
                            $status_display = 'Ditolak Dekan';
                            $badge_class = 'badge-rejected';
                        }
                    ?>
                    <tr class="clickable-row" data-id="<?= $id ?>">
                        <td><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($nama_kegiatan) ?></strong></td>
                        <td><?= htmlspecialchars($nomor_surat) ?></td>
                        <td><?= htmlspecialchars($penyelenggara) ?></td>
                        <td><?= $tgl_pengajuan ?></td>
                        <td><?= $tgl_kegiatan_display ?></td>
                        <td><?= htmlspecialchars($jenis_pengajuan) ?></td>
                        <td onclick="event.stopPropagation()">
                            <!-- Tombol Tentukan Disposisi (hanya untuk status tertentu) -->
                            <?php if(in_array($status, ['disetujui KK', 'disetujui sekretariat', 'ditolak sekretariat'])): ?>
                                <button 
                                    class="btn-disposisi" 
                                    onclick="openPinModal(<?= $id ?>)">
                                    <i class="fas fa-shuffle"></i> Tentukan
                                </button>
                            <?php endif; ?>

                            <!-- Dropdown Disposisi (disembunyikan sampai PIN benar) -->
                            <div id="disposisiBox<?= $id ?>" class="disposisi-card" style="display:none;">
                                <label class="label-disposisi">Pilih Disposisi</label>
                                <select id="disposisiSelect<?= $id ?>"
                                        class="select-disposisi"
                                        onchange="onDisposisiChange(<?= $id ?>)">
                                    <option value="">-- Pilih Disposisi --</option>
                                    <option value="Lanjut Proses ✔">Lanjut Proses</option>
                                    <option value="Hold/Pending">Hold/Pending</option>
                                    <option value="Batal">Batal</option>
                                </select>

                                <label id="labelCatatan<?= $id ?>" 
                                    class="label-disposisi" 
                                    style="display:none;margin-top:10px;">
                                    Catatan
                                </label>

                                <textarea id="catatanDisposisi<?= $id ?>"
                                        class="textarea-disposisi"
                                        placeholder="Catatan diperlukan..."
                                        style="display:none;">
                                </textarea>

                                <button class="btn-save" 
                                        onclick="saveDisposisi(<?= $id ?>)" 
                                        id="btnSaveDisposisi<?= $id ?>"
                                        style="display:none;width:100%;margin-top:10px;">
                                    Simpan Disposisi
                                </button>
                            </div>

                            <!-- LOGIKA: Tampilkan disposisi_status -->
                            <?php if (!empty($disposisi_status)): ?>
                                <div class="disposisi-info-box">
                                    <!-- LOGIKA: Jika disposisi_status adalah Modify By Sekre atau Modify By User, tampilkan "none" di tampilan -->
                                    <?php if (in_array($disposisi_status, ['Modify By Sekretariat', 'Modify By User'])): ?>
                                        <small class="disposisi-status-text">
                                            <strong>Status :</strong> 
                                            <span>none</span>
                                        </small>
                                    <?php else: ?>
                                        <small class="disposisi-status-text">
                                            <strong>Status :</strong> 
                                            <span><?= htmlspecialchars($disposisi_status) ?></span>
                                        </small>
                                    <?php endif; ?>
                                    
                                    <!-- Tampilkan pesan Modify By dan timestamp jika ada -->
                                    <?php if (in_array($disposisi_status, ['Modify By Sekretariat', 'Modify By User'])): ?>
                                        <small style="display:block;color:#ff9800;font-size:11px;margin-bottom:4px;">
                                            <i class="fas fa-pen"></i> 
                                            <strong><?= htmlspecialchars($disposisi_status) ?></strong><br>
                                            <?= date('d M Y H:i', strtotime($updated_at)) ?>
                                        </small>
                                    <?php endif; ?>
                                    
                                    <!-- TIMESTAMP DISPOSISI -->
                                    <?php if (!empty($disposisi_updated_at)): ?>
                                        <small class="disposisi-timestamp">
                                            <i class="far fa-clock"></i> 
                                            <?= date('d M Y H:i', strtotime($disposisi_updated_at)) ?>
                                        </small>
                                    <?php endif; ?>
                                    
                                    <!-- CATATAN DISPOSISI (tampilkan hanya jika bukan Modify status) -->
                                    <?php if (!empty($disposisi_catatan) && !in_array($disposisi_status, ['Modify By Sekretariat', 'Modify By User'])): ?>
                                        <small class="disposisi-catatan-text">
                                            <i class="far fa-comment"></i> 
                                            <?= htmlspecialchars($disposisi_catatan) ?>
                                        </small>
                                    <?php endif; ?>
                                    
                                    <!-- APPROVAL STATUS SEKRETARIAT (jika disposisi = Lanjut Proses dan sudah disetujui/ditolak) -->
                                    <?php if (($disposisi_status === 'Lanjut Proses ✔' || $disposisi_status === 'Batal') && !empty($status)): ?>
                                        <?php if (in_array($status, ['disetujui sekretariat', 'ditolak sekretariat', 'disetujui dekan', 'ditolak dekan'])): ?>
                                            <div class="approval-status-box <?= in_array($status, ['disetujui sekretariat', 'disetujui dekan']) ? 'approved' : 'rejected' ?>">
                                                <small style="display:block;font-weight:700;">
                                                    <i class="fas fa-<?= in_array($status, ['disetujui sekretariat', 'disetujui dekan']) ? 'check-circle' : 'times-circle' ?>"></i>
                                                    <?= $status === 'disetujui sekretariat' ? 'Telah Disubmit' : 
                                                    ($status === 'ditolak sekretariat' ? 'Ditolak Sekretariat' : 
                                                    ($status === 'disetujui dekan' ? 'Disetujui Dekan' : 
                                                    ($status === 'ditolak dekan' ? 'Ditolak Dekan' : $status))) ?>
                                                </small>
                                                <?php if (!empty($updated_at)): ?>
                                                    <small class="approval-timestamp-small">
                                                        <?= date('d M Y H:i', strtotime($updated_at)) ?>
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td onclick="event.stopPropagation()">
                            <div style="display:flex;gap:6px">
                                <!-- Tombol Lihat Eviden -->
                                <button class="btn btn-eviden" title="Lihat Eviden" onclick="showEvidenModal(<?= $id; ?>)">
                                    <i class="fas fa-file-image"></i>
                                </button>
                                
                                <!-- Tombol Lihat Detail -->
                                <button class="btn btn-detail" onclick="showDetail(<?= $id ?>)" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                
                                <!-- TOMBOL EDIT (untuk disetujui KK, disetujui sekretariat, ditolak sekretariat) -->
                                <?php if(in_array($status, ['disetujui KK', 'disetujui sekretariat', 'ditolak sekretariat'])): ?>
                                    <a href="<?= site_url('sekretariat/edit_surat_sekretariat/' . $id) ?>" 
                                    class="btn-edit" 
                                    title="Edit Pengajuan">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <!-- LOGIKA BARU: Tombol Return untuk status "disetujui sekretariat" atau "ditolak sekretariat" -->
                                <?php if(in_array($status, ['disetujui sekretariat', 'ditolak sekretariat'])): ?>
                                    <button class="btn-return" onclick="event.stopPropagation(); showReturnModal(<?= $id ?>, '<?= htmlspecialchars($nama_kegiatan, ENT_QUOTES) ?>')" title="Return">
                                        <i class="fa-solid fa-undo"></i>
                                    </button>
                                <?php endif; ?>
                                
                                <!-- Tombol edit khusus untuk ditolak dekan -->
                                <?php if($status == 'ditolak dekan' && $disposisi_status == 'Lanjut Proses ✔'): ?>
                                    <a href="<?= site_url('sekretariat/edit_surat/' . $id) ?>" 
                                    class="btn-edit" 
                                    title="Edit & Ajukan Ulang ke Dekan">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="9" style="text-align:center;padding:40px;color:#7f8c8d">
                            <i class="fa-solid fa-times-circle" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
                            <strong>Tidak ada pengajuan yang ditolak</strong>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-info">
            Menampilkan: Pengajuan Ditolak (<?= isset($total_surat) ? $total_surat : '0' ?> data)
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
<div id="detailModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-alt"></i> Detail Pengajuan Surat Tugas</h3>
            <button class="close-modal" onclick="closeModal('detailModal')">&times;</button>
        </div>
        <div class="detail-content" id="detailContent">
            <!-- Content akan diisi oleh JavaScript -->
        </div>
    </div>
</div>

 <!-- Modal PIN -->
        <div id="pinModal" 
            style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;
            background:rgba(0,0,0,0.45);backdrop-filter:blur(3px);
            align-items:center;justify-content:center;z-index:9999">

            <div style="
                background:#ffffff;
                padding:28px;
                border-radius:14px;
                width:360px;
                text-align:center;
                animation: fadeIn 0.25s ease;
                box-shadow:0 12px 30px rgba(0,0,0,0.25);
            ">
                <h3 style="margin-bottom:18px;color:#333;font-weight:700;font-size:20px;">
                    <i class="fas fa-shield-alt" style="margin-right:8px;color:#16A085;"></i>
                    Verifikasi PIN
                </h3>

                <!-- Input PIN -->
                <div class="pin-input-container" style="position:relative;display:flex;justify-content:center;">
                    <i class="fas fa-key pin-icon" 
                    style="position:absolute;left:30px;top:50%;transform:translateY(-50%);color:#16A085;"></i>

                    <input type="password"
                        id="pinInput"
                        maxlength="6"
                        style="
                            width:220px;
                            padding:12px 40px;
                            border:2px solid #16A085;
                            border-radius:8px;
                            font-size:18px;
                            text-align:center;
                            letter-spacing:6px;
                            outline:none;
                        "
                        placeholder="••••••"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>

                <!-- Tombol -->
                <div style="display:flex;gap:12px;justify-content:center;margin-top:25px;">
                    <button onclick="checkPin()" 
                        style="
                            background:#16A085;
                            color:white;
                            border:none;
                            padding:10px 22px;
                            border-radius:7px;
                            cursor:pointer;
                            font-weight:600;
                        ">
                        <i class="fas fa-check"></i> Lanjut
                    </button>

                    <button onclick="closePinModal()"
                        style="
                            background:#7f8c8d;
                            color:white;
                            border:none;
                            padding:10px 22px;
                            border-radius:7px;
                            cursor:pointer;
                            font-weight:600;
                        ">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </div>
        <button onclick="openUbahPinModal()" 
                style="background:none;border:none;color:#16A085;margin-top:10px;cursor:pointer;font-weight:600;">
            Ubah PIN?
        </button>

                <p style="margin-top:15px;font-size:12px;color:#7f8c8d;">
                    <i class="fas fa-info-circle"></i> PIN terdiri dari 6 digit angka
                </p>
            </div>
        </div>

        <style>
        @keyframes fadeIn {
            from { opacity:0; transform: scale(0.94); }
            to   { opacity:1; transform: scale(1); }
        }
        </style>
        <!-- Modal Ubah PIN -->
        <div id="ubahPinModal" 
            style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;
            background:rgba(0,0,0,0.5);align-items:center;justify-content:center;z-index:9999">

            <div style="background:#fff;width:380px;padding:25px;border-radius:14px;
                box-shadow:0 15px 35px rgba(0,0,0,0.25);text-align:center;">

                <h2 style="margin-bottom:10px;color:#333;font-weight:700;">
                    <i class="fas fa-key" style="color:#16A085;margin-right:8px;"></i>
                    Ubah PIN
                </h2>

                <p style="font-size:13px;color:#777;margin-bottom:20px;">
                    Masukkan PIN lama dan PIN baru (6 digit).
                </p>

                <div style="text-align:left;margin-bottom:12px;">
                    <label>PIN Lama</label>
                    <input type="password" id="oldPin" maxlength="6"
                        style="width:100%;padding:10px;border:1px solid #ccc;border-radius:8px;margin-top:5px;"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                </div>

                <div style="text-align:left;">
                    <label>PIN Baru</label>
                    <input type="password" id="newPin" maxlength="6"
                        style="width:100%;padding:10px;border:1px solid #ccc;border-radius:8px;margin-top:5px;"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                </div>

                <div style="display:flex;gap:10px;margin-top:25px;justify-content:center;">
                    <button onclick="submitUbahPin()" 
                        style="background:#16A085;color:white;border:none;padding:10px 20px;
                        border-radius:8px;cursor:pointer;font-weight:600;">
                        Simpan
                    </button>

                    <button onclick="closeUbahPinModal()" 
                        style="background:#7f8c8d;color:white;border:none;padding:10px 20px;
                        border-radius:8px;cursor:pointer;font-weight:600;">
                        Batal
                    </button>
                </div>

                <p id="pinMsg" style="margin-top:12px;color:red;font-size:13px;"></p>

            </div>
        </div>



<!-- Return Modal -->
<div id="returnConfirmModal" class="modal">
    <div class="modal-content" style="max-width: 450px;">
        <div class="modal-header" style="background: #ff9800;">
            <h3><i class="fa-solid fa-undo"></i> Konfirmasi Pengembalian</h3>
            <button class="close-modal" onclick="closeModal('returnConfirmModal')">&times;</button>
        </div>
        <div class="detail-content">
            <div style="background: #fff3e0; border:1px solid #ff9800; border-radius:8px;padding:15px;margin-bottom:20px">
                <strong style="color: #ff9800;"><i class="fa-solid fa-exclamation-triangle"></i> Peringatan</strong>
                <div id="returnNamaKegiatan" style="color:#2c3e50;font-weight:600;margin-top:5px"></div>
            </div>
            
            <p style="margin-bottom:20px;color:#e65100;font-weight:600">
                ⚠️ Pengajuan ini akan dikembalikan ke status sebelumnya dan dapat diajukan ulang.
            </p>
            
            <div class="modal-actions">
                <button type="button" class="modal-btn modal-btn-close" onclick="closeModal('returnConfirmModal')">
                    <i class="fa-solid fa-times"></i> Batal
                </button>
                <button type="button" class="modal-btn" style="background: #ff9800;" onclick="confirmReturn()">
                    <i class="fa-solid fa-undo"></i> Ya, Kembalikan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Data dan variabel global
let selectedSurat = null;
let currentReturnId = null;

// ============================================
// FUNGSI DISPOSISI (SAMA DENGAN DASHBOARD)
// ============================================

function openPinModal(id) {
    selectedSurat = id;
    document.getElementById('pinModal').classList.add('show');
    document.getElementById('pinInput').value = '';
    document.getElementById('pinInput').focus();
}

function closePinModal() {
    document.getElementById('pinModal').classList.remove('show');
    document.getElementById('pinInput').value = '';
}

function checkPin() {
    let pin = document.getElementById("pinInput").value;

    if (!pin) {
        alert("PIN harus diisi!");
        return;
    }

    if (pin.length !== 6) {
        alert("PIN harus 6 digit!");
        return;
    }

    if (!/^[0-9]{6}$/.test(pin)) {
        alert("PIN harus berupa angka!");
        return;
    }

    fetch("<?= base_url('sekretariat/cek_pin') ?>", {
        method: "POST",
        headers: { 
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: JSON.stringify({ pin: pin })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            if (selectedSurat) {
                document.getElementById("disposisiBox" + selectedSurat).style.display = "block";
            }
            closePinModal();
        } else {
            alert(data.message || "PIN salah!");
            document.getElementById("pinInput").value = "";
            document.getElementById("pinInput").focus();
        }
    })
    .catch(error => {
        console.error("Fetch Error:", error);
        alert("Terjadi kesalahan: " + error.message);
    });
}
function openUbahPinModal() {
                document.getElementById("ubahPinModal").style.display = "flex";
            }

            function closeUbahPinModal() {
                document.getElementById("ubahPinModal").style.display = "none";
                document.getElementById("pinMsg").innerHTML = "";
            }

            function submitUbahPin() {
                let oldPin = document.getElementById("oldPin").value;
                let newPin = document.getElementById("newPin").value;

                if (oldPin.length !== 6 || newPin.length !== 6) {
                    document.getElementById("pinMsg").innerHTML = "PIN harus 6 digit!";
                    return;
                }

                fetch("<?= base_url('sekretariat/updatePin') ?>", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `old_pin=${encodeURIComponent(oldPin)}&new_pin=${encodeURIComponent(newPin)}`
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById("pinMsg").innerHTML = data.message;

                    if (data.status) {
                        setTimeout(() => {
                            closeUbahPinModal();
                            location.reload();
                        }, 800);
                    }
                })
                .catch(() => {
                    document.getElementById("pinMsg").innerHTML = "Terjadi kesalahan!";
                });
            }
function onDisposisiChange(id) {
    let val = document.getElementById("disposisiSelect" + id).value;
    let catatanLabel = document.getElementById("labelCatatan" + id);
    let catatanTextarea = document.getElementById("catatanDisposisi" + id);
    let btnSave = document.getElementById("btnSaveDisposisi" + id);

    btnSave.style.display = "none";
    catatanLabel.style.display = "none";
    catatanTextarea.style.display = "none";
    catatanTextarea.value = "";
    
    if (val === "Hold/Pending" || val === "Batal") {
        catatanLabel.style.display = "block";
        catatanTextarea.style.display = "block";
        btnSave.style.display = "block";

        if (val === "Hold/Pending") {
            catatanTextarea.placeholder = "Berikan alasan mengapa perlu ditahan/ditunda...";
        } else if (val === "Batal") {
            catatanTextarea.placeholder = "Berikan alasan pembatalan...";
        }
        
        setTimeout(() => {
            catatanTextarea.focus();
        }, 100);
    } else if (val === "Lanjut Proses ✔"){
        btnSave.style.display = "block";
    }
}

function saveDisposisi(id) {
    let disposisi = document.getElementById("disposisiSelect" + id).value;
    let catatan = document.getElementById("catatanDisposisi" + id).value;

    if (!disposisi) {
        alert("Pilih disposisi dulu!");
        return;
    }

    if ((disposisi === "Hold/Pending" || disposisi === "Batal") && catatan === "") {
        alert("Wajib Mengisi Catatan!");
        return;
    }

    if (disposisi === "Batal") {
        if (!confirm("⚠️ Pengajuan ini akan DITOLAK oleh Sekretariat.\n\nLanjutkan?")) {
            return;
        }
    }

    fetch("<?= base_url('sekretariat/set_disposisi') ?>", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            id: id,
            disposisi: disposisi,
            catatan: catatan
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            if (disposisi === "Batal") {
                alert("✅ Disposisi tersimpan!\n\n📌 Status pengajuan diubah menjadi: DITOLAK SEKRETARIAT");
            } else {
                alert("✅ Disposisi tersimpan!");
            }
            location.reload();
        } else {
            alert("❌ Gagal menyimpan disposisi. Silakan coba lagi.");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("❌ Terjadi kesalahan. Silakan coba lagi.");
    });
}

// ============================================
// FUNGSI RETURN (SAMA DENGAN DASHBOARD)
// ============================================

function showReturnModal(id, namaKegiatan) {
    currentReturnId = id;
    
    document.getElementById('returnNamaKegiatan').textContent = namaKegiatan;
    
    document.getElementById('returnConfirmModal').classList.add('show');
}

function confirmReturn() {
    if (!currentReturnId) return;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= base_url("sekretariat/return_pengajuan/") ?>' + currentReturnId;
    
    const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
    const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
    
    const inpCsrf = document.createElement('input');
    inpCsrf.type = 'hidden';
    inpCsrf.name = csrfName;
    inpCsrf.value = csrfHash;
    form.appendChild(inpCsrf);
    
    document.body.appendChild(form);
    form.submit();
}

// ============================================
// FUNGSI DETAIL & EVIDEN (SAMA DENGAN DASHBOARD)
// ============================================

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

async function showDetail(id) {
    try {
        const viewUrl = "<?= base_url('sekretariat/view_surat_pengajuan/') ?>" + id;
        const pdfUrl  = "<?= base_url('sekretariat/download_pdf/') ?>" + id;

        document.getElementById('detailContent').innerHTML = `
            <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                <button onclick="downloadPDF('${pdfUrl}')"
                    style="padding:8px 15px; background:#16A085; color:white; border:none; border-radius:6px; cursor:pointer;">
                    <i class="fa fa-download"></i> Download
                </button>
                <button onclick="printPDF('${pdfUrl}')"
                    style="padding:8px 15px; background:#2c3e50; color:white; border:none; border-radius:6px; cursor:pointer;">
                    <i class="fa fa-print"></i> Print
                </button>
            </div>
            <iframe id="pdfFrame"
                src="${viewUrl}"
                style="width:100%; height:85vh; border:none; border-radius:10px;"
                    onload="adjustIframeHeight()">
            </iframe>
        `;

        document.getElementById("detailModal").classList.add("show");
        
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

// Fungsi untuk menyesuaikan tinggi iframe berdasarkan konten
function adjustIframeHeight() {
    const iframe = document.getElementById('pdfFrame');
    if (!iframe) return;
    
    try {
        // Tunggu sedikit untuk konten selesai dimuat
        setTimeout(() => {
            try {
                const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                const body = iframeDoc.body;
                const html = iframeDoc.documentElement;
                
                // Hitung tinggi maksimum
                const height = Math.max(
                    body.scrollHeight,
                    body.offsetHeight,
                    html.clientHeight,
                    html.scrollHeight,
                    html.offsetHeight
                );
                
                // Set tinggi iframe
                iframe.style.height = (height + 50) + 'px'; // Tambah margin
                
                console.log('Iframe height adjusted to:', height);
            } catch (e) {
                console.error('Error adjusting iframe height:', e);
                // Fallback: set tinggi tetap
                iframe.style.height = '1000px';
            }
        }, 500); // Tunggu 500ms untuk konten selesai dimuat
    } catch (e) {
        console.error('Error accessing iframe content:', e);
    }
}
function printPDF(url) {
    fetch(url)
        .then(res => res.blob())
        .then(blob => {
            const blobUrl = URL.createObjectURL(blob);
            const iframe = document.createElement("iframe");
            iframe.style.display = "none";
            iframe.src = blobUrl;
            document.body.appendChild(iframe);

            iframe.onload = function () {
                iframe.contentWindow.print();
            };
        });
}

function downloadPDF(url) {
    window.location.href = url;
}

async function showEvidenModal(suratId) {
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
            previewFile(file.url, file.name);
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
    
    return baseUrl + possiblePaths[0];
}

function showMultipleEvidenModal(item, evidenFiles) {
    document.getElementById('detailContent').innerHTML = `
        <div style="text-align:center;padding:40px;">
            <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#16A085"></i>
            <p style="margin-top:10px;color:#7f8c8d">Memuat eviden...</p>
        </div>
    `;
    
    document.getElementById('detailModal').classList.add('show');
    
    const content = generateMultipleEvidenContent(item, evidenFiles);
    document.getElementById('detailContent').innerHTML = content;
}

function generateMultipleEvidenContent(item, evidenFiles) {
    const getVal = (k) => {
        const value = (item[k] !== undefined && item[k] !== null && item[k] !== '' ? item[k] : '-');
        return value;
    };

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
            <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal')">
                <i class="fa-solid fa-times"></i> Tutup
            </button>
        </div>
    `;
}

function previewFile(fileUrl, fileName) {
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

// ============================================
// FUNGSI UTILITY
// ============================================

function closeModal(id) { 
    document.getElementById(id).classList.remove('show'); 
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
// FUNGSI SEARCH
// ============================================

let currentSearchTerm = '';

function handleSearch() {
    const searchInput = document.getElementById('searchInput');
    currentSearchTerm = searchInput.value.toLowerCase();
    applySearch();
}

function applySearch() {
    const rows = document.querySelectorAll('#tableBody tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        if (row.cells.length < 9) return;
        
        const text = row.textContent.toLowerCase();
        
        let matchesSearch = true;
        
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
            const total = <?= isset($total_surat) ? $total_surat : '0' ?>;
            paginationInfo.textContent = `Menampilkan: Pengajuan Ditolak (${total} data)`;
            filterInfo.textContent = `Menampilkan: Semua Data (${visibleCount} data)`;
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
        applySearch();
    }
});

// ============================================
// FUNGSI CLICKABLE ROWS
// ============================================

async function showRowDetailViaClick(id) {
    try {
        document.getElementById('detailContent').innerHTML = `
            <div style="text-align:center;padding:40px;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#16A085"></i>
                <p style="margin-top:10px;color:#7f8c8d">Memuat detail pengajuan...</p>
            </div>
        `;
        
        document.getElementById('detailModal').classList.add('show');
        
        const data = await getSuratDetail(id);
        
        if (!data) {
            throw new Error('Data tidak ditemukan');
        }
        
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

function generateDetailContentEnhanced(item) {
    const getVal = (k) => {
        const value = (item[k] !== undefined && item[k] !== null && item[k] !== '' ? item[k] : '-');
        return value;
    };

    let statusBadge = '';
    const status = getVal('status').toLowerCase();

    if (status.includes('setuju')) {
        statusBadge = `<span class="badge badge-approved">${getVal('status')}</span>`;
    } else if (status.includes('tolak')) {
        statusBadge = `<span class="badge badge-rejected">${getVal('status')}</span>`;
    } else {
        statusBadge = `<span class="badge badge-pending">${getVal('status')}</span>`;
    }

    const dosenData = item.dosen_data || [];

      // ✅ Generate HTML untuk data dosen DENGAN FOTO (TANPA INITIAL)
let dosenHtml = '';
if (dosenData && dosenData.length > 0) {
    dosenHtml = `
    <div class="dosen-list">
        ${dosenData.map((dosen, index) => {
            const initial = dosen.nama ? dosen.nama.charAt(0).toUpperCase() : '?';
            const foto = dosen.foto || '';
            const hasFoto = foto && foto.trim() !== '' && foto !== 'null';
            
            console.log(`Dosen ${index + 1}:`, dosen.nama, 'Foto:', foto, 'Has Foto:', hasFoto); // ✅ DEBUG
            
            return `
        <div class="dosen-item">
            <div class="dosen-avatar" style="width: 32px; height: 32px; border-radius: 50%; background: #8E44AD; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; font-weight: 600; overflow: hidden; position: relative;">
                ${hasFoto ? `
                    <img src="${escapeHtml(foto)}" 
                         alt="${escapeHtml(dosen.nama)}" 
                         style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: 2;"
                         onerror="console.error('Image load error:', this.src); this.style.display='none'; this.parentElement.style.background='#8E44AD';">
                ` : `
                    <span style="position: relative; z-index: 1;">${initial}</span>
                `}
            </div>
            <div class="dosen-info">
                <div class="dosen-name">${escapeHtml(dosen.nama)}</div>
                <div class="dosen-details">
                    NIP: ${escapeHtml(dosen.nip)} | ${escapeHtml(dosen.jabatan)} | Divisi: ${escapeHtml(dosen.divisi)}
                </div>
            </div>
        </div>
            `;
        }).join('')}
    </div>`;
} else {
    dosenHtml = `
    <div class="dosen-item">
        <div class="dosen-avatar" style="width: 32px; height: 32px; border-radius: 50%; background: #8E44AD; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; font-weight: 600;">
            <span>?</span>
        </div>
        <div class="dosen-info">
            <div class="dosen-name">Data dosen tidak tersedia</div>
            <div class="dosen-details">Informasi dosen tidak ditemukan</div>
        </div>
    </div>`;
}

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

    let rejectionHtml = '';
    if (getVal('catatan_penolakan') && getVal('catatan_penolakan') !== '-') {
        rejectionHtml = `
        <div style="background:#fff5f5;border:1px solid #f8d7da;border-radius:8px;padding:20px;margin-top:15px">
            <div style="font-weight:600;color:#dc3545;margin-bottom:8px">
                <i class="fa-solid fa-comment-dots"></i> Catatan Penolakan
            </div>
            <div style="background:#fff5f5;border-color:#f8d7da;color:#721c24;font-size:14px;line-height:1.5;padding:12px;border-radius:8px">
                ${escapeHtml(getVal('catatan_penolakan'))}
            </div>
        </div>`;
    }

    const jenisDate = getVal('jenis_date');
    const periodeValue = getVal('periode_value');
    const tanggalKegiatan = getVal('tanggal_kegiatan');
    const akhirKegiatan = getVal('akhir_kegiatan');

    let periodeDisplay = '-';
    let tanggalMulaiDisplay = '-';
    let tanggalAkhirDisplay = '-';

    if (jenisDate === 'Periode') {
        periodeDisplay = periodeValue !== '-' && periodeValue ? periodeValue : '-';
        tanggalMulaiDisplay = '-';
        tanggalAkhirDisplay = '-';
    } else if (jenisDate === 'Custom') {
        periodeDisplay = '-';
        if (tanggalKegiatan !== '-' && tanggalKegiatan) {
            tanggalMulaiDisplay = formatDate(tanggalKegiatan);
        }
        if (akhirKegiatan !== '-' && akhirKegiatan) {
            tanggalAkhirDisplay = formatDate(akhirKegiatan);
        }
    } else {
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
    </div>`;
}

function formatDate(d) {
    if (!d || d === '-' || d === '0000-00-00') return '-';
    const t = new Date(d);
    if (isNaN(t)) return d;
    return t.toLocaleDateString('id-ID', { day:'2-digit', month: 'short', year:'numeric' });
}

// ============================================
// INISIALISASI SAAT DOM LOADED
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    applySearch();
    
    // Make rows clickable
    const rows = document.querySelectorAll('#tableBody tr.clickable-row');
    
    rows.forEach(row => {
        if (row.cells.length < 9) return;
        
        const rowId = row.getAttribute('data-id');
        if (rowId) {
            row.addEventListener('click', function(e) {
                if (e.target.closest('input[type="checkbox"]') || 
                    e.target.closest('button') || 
                    e.target.closest('a') || 
                    e.target.closest('select') ||
                    e.target.closest('textarea') ||
                    e.target.closest('input')) {
                    return;
                }
                
                rows.forEach(r => r.classList.remove('selected'));
                
                this.classList.add('selected');
                
                showRowDetailViaClick(rowId);
            });
        }
    });
});
</script>
</body>
</html>