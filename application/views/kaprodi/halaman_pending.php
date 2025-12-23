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
    .status-info h1{margin:0;color:#2c3e50;font-size:28px}
    .status-info p{margin:5px 0 0 0;color:#7f8c8d;font-size:16px}
    
    /* Tombol eviden hijau */
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

    /* Clickable Row Styles */
    .clickable-row:hover {
        background-color: #f0f8ff !important;
        box-shadow: inset 0 0 0 2px #3498db;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .clickable-row:active {
        background-color: #e3f2fd !important;
        transform: scale(0.995);
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
    
    /* Rejection Notes Styles */
    .rejection-notes{background:#fff5f5;border:1px solid #f8d7da;border-radius:8px;padding:20px;margin-top:15px}
    .rejection-notes .detail-label{color:#dc3545;font-weight:700}
    .rejection-notes .detail-value{background:#fff5f5;border-color:#f8d7da;color:#721c24;font-size:14px;line-height:1.5;min-height:auto;padding:12px}
    
    /* Reject Modal Styles */
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
    
    /* Eviden Modal Styles */
    .eviden-modal-content {
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
        .reject-modal-actions{flex-direction:column}
        .reject-btn{justify-content:center}
        
        /* Table responsive */
        .clickable-row {
            display: block;
            margin-bottom: 10px;
            border: 1px solid #eee;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .clickable-row td {
            display: block;
            text-align: right;
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
        }
        
        .clickable-row td::before {
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            color: #7f8c8d;
        }
        
        .clickable-row td:last-child {
            border-bottom: none;
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

    <!-- Tabel Pengajuan Menunggu -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-table"></i> Daftar Pengajuan Menunggu Persetujuan</h3>
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
                    <!-- BARIS TABEL BISA DIKLIK UNTUK DETAIL -->
                    <tr onclick="showRowDetail(<?= $s->id ?? 0 ?>)" style="cursor: pointer;" class="clickable-row">
                        <td data-label="No"><?= $no++ ?></td>
                        <td data-label="Nama Kegiatan"><strong><?= htmlspecialchars($s->nama_kegiatan ?? '-') ?></strong></td>
                        <td data-label="Penyelenggara"><?= htmlspecialchars($s->penyelenggara ?? '-') ?></td>
                        <td data-label="Tanggal Pengajuan"><?= $tgl_pengajuan ?></td>
                        <td data-label="Tanggal Kegiatan"><?= $tgl_kegiatan ?></td>
                        <td data-label="Jenis"><?= htmlspecialchars($s->jenis_pengajuan ?? '-') ?></td>
                        <td data-label="Status"><span class="badge badge-pending"><?= ucwords($s->status ?? 'Menunggu') ?></span></td>
                        <!-- TOMBOL AKSI - TOMBOL DETAIL MENJADI LIHAT SURAT, TAMBAH TOMBOL EVIDEN -->
                        <td data-label="Aksi">
                            <div style="display:flex;gap:6px">
                                <!-- Tombol Eviden (Hijau) -->
                                <button class="btn btn-eviden" onclick="event.stopPropagation(); showEvidenModal(<?= $s->id ?? 0 ?>)" title="Lihat Eviden">
                                    <i class="fas fa-file-image"></i>
                                </button>
                                
                                <!-- Tombol Approve (Hijau) -->
                                <button class="btn btn-approve" onclick="event.stopPropagation(); showApproveModal(<?= $s->id ?? 0 ?>, '<?= htmlspecialchars($s->nama_kegiatan ?? '') ?>')" title="Setujui">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                
                                <!-- Tombol Reject (Merah) -->
                                <button class="btn btn-reject" onclick="event.stopPropagation(); showRejectModalNew(<?= $s->id ?? 0 ?>, '<?= htmlspecialchars($s->nama_kegiatan ?? '') ?>')" title="Tolak">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="8" style="text-align:center;padding:40px;color:#7f8c8d">
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

<!-- Preview Modal (untuk single file preview) -->
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

<!-- Detail Modal (untuk klik baris) -->
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

<!-- Surat Modal (untuk tombol lihat detail - melihat surat) -->
<div id="suratModal" class="modal" onclick="modalClickOutside(event,'suratModal')">
    <div class="modal-content" onclick="event.stopPropagation()" style="max-width: 1100px;">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-invoice"></i> Surat Pengajuan</h3>
            <button class="close-modal" onclick="closeModal('suratModal')">&times;</button>
        </div>
        <div class="detail-content" id="suratContent">
            <!-- Surat akan diisi oleh JavaScript -->
        </div>
    </div>
</div>

<!-- Eviden Modal (untuk multiple files) -->
<div id="evidenModal" class="modal" onclick="modalClickOutside(event,'evidenModal')">
    <div class="modal-content" onclick="event.stopPropagation()" style="max-width: 600px;">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-image"></i> File Evidence</h3>
            <button class="close-modal" onclick="closeModal('evidenModal')">&times;</button>
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
            <button class="close-modal" onclick="closeModal('approveModal')">&times;</button>
        </div>
        <div class="approve-modal-body">
            <div class="approve-info-box">
                <strong><i class="fa-solid fa-info-circle"></i> Informasi: Surat ini masih dalam bentuk pengajuan</strong>
                <span id="approveNamaKegiatan"></span>
            </div>
            
            <p style="margin-bottom:20px;color:#7f8c8d">Apakah Anda yakin ingin menyetujui pengajuan ini?</p>
            
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

<!-- Reject Modal -->
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

<script>
// ============================================
// VARIABLES GLOBAL
// ============================================
const suratList = <?= isset($surat_list) && !empty($surat_list) ? json_encode($surat_list) : '[]' ?>;
let currentRejectId = null;
let currentRejectNamaKegiatan = null;
let currentApproveId = null;

// ============================================
// FUNGSI UTAMA UNTUK TOMBOL DAN KLIK BARIS
// ============================================

// Fungsi untuk menampilkan detail saat baris diklik
async function showRowDetail(id) {
    try {
        // Tampilkan loading
        document.getElementById('detailContent').innerHTML = `
            <div style="text-align:center;padding:40px;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#8E44AD"></i>
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
        
        // Generate HTML untuk detail pengajuan
        const detailHtml = generateDetailContent(data);
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

// Fungsi untuk menampilkan surat pengajuan (tombol mata)
async function showSurat(id) {
    try {
        // Tampilkan loading
        document.getElementById('suratContent').innerHTML = `
            <div style="text-align:center;padding:40px;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#8E44AD"></i>
                <p style="margin-top:10px;color:#7f8c8d">Memuat surat pengajuan...</p>
            </div>
        `;
        
        // Tampilkan modal
        document.getElementById('suratModal').classList.add('show');
        
        // Load surat pengajuan via iframe
        const suratUrl = '<?= base_url("kaprodi/view_surat_pengajuan/") ?>' + id;
        document.getElementById('suratContent').innerHTML = `
            <iframe 
                src="${suratUrl}" 
                style="width:100%; height:70vh; border:none; border-radius:8px;"
                onload="this.style.opacity=1"
                style="opacity:0; transition: opacity 0.3s;"
            ></iframe>
            <div class="modal-actions">
                <button class="modal-btn modal-btn-close" onclick="closeModal('suratModal')">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
            </div>
        `;
        
    } catch (error) {
        console.error('Error loading surat:', error);
        document.getElementById('suratContent').innerHTML = `
            <div style="text-align:center;padding:40px;color:#e74c3c">
                <i class="fa-solid fa-exclamation-triangle" style="font-size:48px;margin-bottom:10px"></i>
                <p>Gagal memuat surat: ${error.message}</p>
                <button class="modal-btn modal-btn-close" onclick="closeModal('suratModal')" style="margin-top:20px">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
            </div>
        `;
    }
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
        
        // LOGIKA: Jika hanya 1 file, langsung preview
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

// ============================================
// FUNGSI GENERATE DETAIL CONTENT
// ============================================

function generateDetailContent(item) {
    // Helper function untuk mendapatkan nilai
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
    
    // LOGIKA: Tentukan tampilan berdasarkan jenis_date
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
        ${getVal('status') === 'pengajuan' ? `
        <div style="display:flex;gap:10px;margin-left:auto">
            <button class="modal-btn modal-btn-reject" onclick="event.stopPropagation(); closeModal('detailModal'); showRejectModalNew(${item.id}, '${escapeHtml(getVal('nama_kegiatan'))}')">
                <i class="fa-solid fa-times"></i> Tolak
            </button>
            <button class="modal-btn modal-btn-approve" onclick="event.stopPropagation(); showApproveModal(${item.id}, '${escapeHtml(getVal('nama_kegiatan'))}')">
                <i class="fa-solid fa-check"></i> Setujui
            </button>
        </div>
        ` : ''}
    </div>`;
}

// ============================================
// FUNGSI UNTUK EVIDEN
// ============================================

// Fungsi untuk mendapatkan array file eviden dari data
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
            <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#8E44AD"></i>
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

// ============================================
// FUNGSI APPROVE MODAL
// ============================================

function showApproveModal(id, namaKegiatan) {
    currentApproveId = id;
    document.getElementById('approveNamaKegiatan').textContent = namaKegiatan;
    document.getElementById('approveForm').action = '<?= base_url("kaprodi/approve/") ?>' + id;
    document.getElementById('approveModal').classList.add('show');
}

// ============================================
// FUNGSI REJECT MODAL
// ============================================

// Fungsi untuk menampilkan reject modal baru
function showRejectModalNew(id, namaKegiatan) {
    currentRejectId = id;
    currentRejectNamaKegiatan = namaKegiatan;
    
    // Set data ke modal
    document.getElementById('rejectNamaKegiatan').textContent = namaKegiatan;
    document.getElementById('rejectionReason').value = '';
    document.getElementById('rejectForm').action = '<?= base_url("kaprodi/reject/") ?>' + id;
    
    // Tampilkan modal
    document.getElementById('rejectConfirmModal').classList.add('show');
}

// ============================================
// PREVIEW FILE FUNCTIONS
// ============================================

function previewFile(fileUrl, fileName) {
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
// HELPER FUNCTIONS
// ============================================

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
       .replace(/"/,"&#039;")
}

// ============================================
// EVENT LISTENERS
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    // Event listener untuk preview modal
    window.addEventListener('click', function(e) {
        if (e.target.id === 'previewModal') {
            closePreviewModal();
        }
    });
    
    // Search functionality
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            if (!searchInput.value.trim()) {
                e.preventDefault();
            }
        });
    }
    
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