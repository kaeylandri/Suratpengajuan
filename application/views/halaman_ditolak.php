<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengajuan Ditolak - Dashboard Kaprodi</title>
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
    .badge-approved{background:#d4edda;color:#155724}
    .badge-pending{background:#fff3cd;color:#856404}
    .badge-rejected{background:#f8d7da;color:#721c24}
    .badge-completed{background:#d1ecf1;color:#0c5460}
    .btn{padding:6px 10px;border-radius:6px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s}
    .btn:hover{transform:scale(1.05)}
    .btn-detail{background:#3498db;color:#fff}
    .btn-detail:hover{background:#2980b9}
    .pagination-info{margin-top:15px;color:#7f8c8d;font-size:14px;text-align:right}
    .back-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#3498db;color:white;text-decoration:none;border-radius:8px;font-weight:600;transition:all 0.3s;margin-bottom:20px}
    .back-btn:hover{background:#2980b9;transform:translateY(-2px)}
    .status-header{display:flex;align-items:center;gap:15px;margin-bottom:20px;padding:20px;background:white;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.06)}
    .status-icon{width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:24px}
    .status-icon.approved{background:#d4edda;color:#27ae60}
    .status-icon.rejected{background:#f8d7da;color:#e74c3c}
    .status-info h1{margin:0;color:#2c3e50;font-size:28px}
    .status-info p{margin:5px 0 0 0;color:#7f8c8d;font-size:16px}
    .search-container{margin-bottom:20px}
    .search-label{display:block;margin-bottom:8px;color:#6c757d;font-size:14px;font-weight:500}
    .search-box{display:flex;gap:10px;align-items:center;width:100%}
    .search-input-wrapper{position:relative;flex:1}
    .search-input{width:100%;padding:12px 45px 12px 15px;border:1px solid #e9ecef;border-radius:8px;font-size:14px;transition:all 0.3s;background:white;color:#495057}
    .search-input:focus{outline:none;border-color:#8E44AD;box-shadow:0 0 0 2px rgba(142,68,173,0.1)}
    .search-input::placeholder{color:#6c757d}
    .search-icon{position:absolute;right:15px;top:50%;transform:translateY(-50%);color:#6c757d;font-size:16px}
    .btn-cari{padding:12px 24px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#6c757d;color:#fff;white-space:nowrap}
    .btn-cari:hover{background:#5a6268;transform:translateY(-1px)}
    
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
    
    /* Rejection Notes Styles */
    .rejection-notes{background:#fff5f5;border:1px solid #f8d7da;border-radius:8px;padding:20px;margin-top:15px}
    .rejection-notes .detail-label{color:#dc3545;font-weight:700}
    .rejection-notes .detail-value{background:#fff5f5;border-color:#f8d7da;color:#721c24;font-size:14px;line-height:1.5;min-height:auto;padding:12px}
    
    /* Nomor Surat Styles */
    .nomor-surat-container {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        border: 2px solid #e74c3c;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        text-align: center;
    }
    
    .nomor-surat-label {
        font-size: 14px;
        font-weight: 600;
        color: #e74c3c;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .nomor-surat-value {
        font-size: 18px;
        font-weight: 700;
        color: #c0392b;
        font-family: 'Courier New', monospace;
    }
    
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

    /* Clickable Row Styles */
    .clickable-row:hover {
        background-color: #fff5f5 !important;
        box-shadow: inset 0 0 0 2px #e74c3c;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .clickable-row:active {
        background-color: #ffeaea !important;
        transform: scale(0.995);
    }

    /* Return Modal Styles */
    .return-modal-content {
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

    .return-modal-body {
        padding: 25px;
    }

    .return-modal-header {
        background: #ff9800;
        color: white;
        padding: 20px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 15px 15px 0 0;
    }

    .return-modal-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .return-info-box {
        background: #fff3e0;
        border: 1px solid #ffcc80;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .return-info-box strong {
        color: #ff9800;
        display: block;
        margin-bottom: 5px;
    }

    .return-info-box span {
        color: #2c3e50;
        font-weight: 600;
    }

    .return-modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }

    .return-btn {
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

    .return-btn-cancel {
        background: #95a5a6;
        color: white;
    }

    .return-btn-cancel:hover {
        background: #7f8c8d;
        transform: translateY(-2px);
    }

    .return-btn-submit {
        background: #ff9800;
        color: white;
    }

    .return-btn-submit:hover {
        background: #f57c00;
        transform: translateY(-2px);
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
        .modal-actions{flex-direction:column}
        .modal-btn{justify-content:center}
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
        .search-box {
            flex-direction: column;
        }
        .btn-cari {
            width: 100%;
            justify-content: center;
        }
        
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
    <!-- Tabel Pengajuan Ditolak -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-table"></i> Daftar Pengajuan Ditolak</h3>
            <div>
                <span style="color:#7f8c8d;font-size:13px">
                    Total: <?= isset($total_surat) ? $total_surat : '0' ?> data
                </span>
            </div>
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
                        value=""
                        autocomplete="off"
                    >
                    <div class="search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
                <button type="button" class="btn-cari" onclick="handleSearch()">
                    <i class="fa-solid fa-search"></i> Cari
                </button>
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
                    <?php 
                    $total_count = 0;
                    if(isset($surat_list) && is_array($surat_list) && !empty($surat_list)): 
                        $no = 1; 
                        $total_count = count($surat_list);
                        foreach($surat_list as $s): 
                            $tgl_pengajuan = isset($s->created_at) && $s->created_at ? date('d M Y', strtotime($s->created_at)) : '-';
                            
                            // Format tanggal kegiatan - handle range tanggal
                            $tgl_kegiatan = '-';
                            if (isset($s->tanggal_kegiatan) && $s->tanggal_kegiatan) {
                                $tgl_kegiatan = date('d M Y', strtotime($s->tanggal_kegiatan));
                                if (isset($s->akhir_kegiatan) && $s->akhir_kegiatan && $s->akhir_kegiatan !== '-' && $s->akhir_kegiatan !== $s->tanggal_kegiatan) {
                                    $tgl_kegiatan .= ' - ' . date('d M Y', strtotime($s->akhir_kegiatan));
                                }
                            }
                            
                            // Daftar dosen untuk ditampilkan
                            $dosen_display_list = [];
                            if (isset($s->dosen_display_list) && is_array($s->dosen_display_list) && !empty($s->dosen_display_list)) {
                                $dosen_display_list = $s->dosen_display_list;
                            } elseif (isset($s->nama_dosen) && !empty($s->nama_dosen)) {
                                $dosen_display_list = [$s->nama_dosen];
                            } elseif (isset($s->dosen_data) && is_array($s->dosen_data) && !empty($s->dosen_data)) {
                                foreach ($s->dosen_data as $dosen) {
                                    if (isset($dosen['nama']) && !empty($dosen['nama'])) {
                                        $dosen_display_list[] = $dosen['nama'];
                                    }
                                }
                            }
                    ?>
                    <!-- BARIS TABEL BISA DIKLIK UNTUK DETAIL -->
                    <tr onclick="showRowDetail(<?= $s->id ?? 0 ?>)" style="cursor: pointer;" class="clickable-row data-row" 
                        data-nama="<?= strtolower(htmlspecialchars($s->nama_kegiatan ?? '')) ?>" 
                        data-penyelenggara="<?= strtolower(htmlspecialchars($s->penyelenggara ?? '')) ?>" 
                        data-jenis="<?= strtolower(htmlspecialchars($s->jenis_pengajuan ?? '')) ?>"
                        data-id="<?= $s->id ?? 0 ?>">
                        <td class="row-number" data-label="No"><?= $no++ ?></td>
                        <td data-label="Nama Kegiatan"><strong><?= htmlspecialchars($s->nama_kegiatan ?? '-') ?></strong></td>
                        <td data-label="Penyelenggara"><?= htmlspecialchars($s->penyelenggara ?? '-') ?></td>
                        <td data-label="Tanggal Pengajuan"><?= $tgl_pengajuan ?></td>
                        <td data-label="Tanggal Kegiatan"><?= $tgl_kegiatan ?></td>
                        <td data-label="Jenis"><?= htmlspecialchars($s->jenis_pengajuan ?? '-') ?></td>
                        <td data-label="Status">
                            <span class="badge badge-rejected">
                                <?= 
                                    isset($s->status) ? 
                                    (strpos(strtolower($s->status), 'ditolak') !== false ? 
                                        ucwords($s->status) : 
                                        'Ditolak') : 
                                    'Ditolak' 
                                ?>
                            </span>
                        </td>
                        <td data-label="Aksi">
                            <div style="display:flex;gap:6px">
                                <!-- Tombol Eviden (Hijau) -->
                                <button class="btn btn-eviden" onclick="event.stopPropagation(); showEvidenModal(<?= $s->id ?? 0 ?>)" title="Lihat Eviden">
                                    <i class="fas fa-file-image"></i>
                                </button>
                                
                                <!-- Tombol Return (Orange/Kuning) - hanya untuk status 'ditolak KK' -->
                                <?php if($s->status == 'ditolak KK'): ?>
                                <button class="btn btn-return" onclick="event.stopPropagation(); showReturnModal(<?= $s->id ?>, '<?= htmlspecialchars($s->nama_kegiatan, ENT_QUOTES) ?>')" title="Kembalikan Pengajuan">
                                    <i class="fa-solid fa-undo"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr id="emptyRow">
                        <td colspan="8" style="text-align:center;padding:40px;color:#7f8c8d">
                            <i class="fa-solid fa-times-circle" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
                            <strong>
                                <?php if(!isset($surat_list)): ?>
                                    Variabel $surat_list tidak terdefinisi
                                <?php elseif(empty($surat_list)): ?>
                                    Tidak ada pengajuan yang ditolak
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
<div id="detailModal" class="modal">
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

<!-- Eviden Modal (untuk multiple files) -->
<div id="evidenModal" class="modal">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-image"></i> File Evidence</h3>
            <button class="close-modal" onclick="closeModal('evidenModal')">&times;</button>
        </div>
        <div class="detail-content" id="evidenContent">
            <!-- Content akan diisi oleh JavaScript -->
        </div>
    </div>
</div>

<!-- Return Modal -->
<div id="returnModal" class="modal">
    <div class="return-modal-content" onclick="event.stopPropagation()">
        <div class="return-modal-header">
            <h3><i class="fa-solid fa-undo"></i> Konfirmasi Pengembalian</h3>
            <button class="close-modal" onclick="closeModal('returnModal')">&times;</button>
        </div>
        <div class="return-modal-body">
            <div class="return-info-box">
                <strong><i class="fa-solid fa-exclamation-triangle"></i> Peringatan</strong>
                <span id="returnNamaKegiatan">-</span>
            </div>
            
            <p style="margin-bottom:20px;color:#e65100;font-weight:600">
                ⚠️ Pengajuan ini akan dikembalikan ke status sebelumnya dan dapat diajukan ulang.
            </p>
            
            <form id="returnForm" method="POST" action="">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                
                <div class="return-modal-actions">
                    <button type="button" class="return-btn return-btn-cancel" onclick="closeModal('returnModal')">
                        <i class="fa-solid fa-times"></i> Batal
                    </button>
                    <button type="submit" class="return-btn return-btn-submit">
                        <i class="fa-solid fa-undo"></i> Ya, Kembalikan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const suratList = <?= isset($surat_list) && !empty($surat_list) ? json_encode($surat_list) : '[]' ?>;
let currentReturnId = null;

// PAGINATION VARIABLES
let currentPage = 1;
let totalPages = 1;
let pageSize = 10;
let filteredData = [];
let allRows = [];
let currentSearchTerm = '';

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
    currentSearchTerm = searchValue;
    
    filteredData = allRows.filter(row => {
        const rowNama = row.getAttribute('data-nama');
        const rowPenyelenggara = row.getAttribute('data-penyelenggara');
        const rowJenis = row.getAttribute('data-jenis');
        
        // Check search filter
        const searchMatch = !searchValue || 
            rowNama.includes(searchValue) || 
            rowPenyelenggara.includes(searchValue) || 
            rowJenis.includes(searchValue);
        
        return searchMatch;
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
    
    let searchInfo = currentSearchTerm ? ` (Hasil pencarian: "${currentSearchTerm}")` : '';
    
    pageInfoText.textContent = filteredData.length > 0 
        ? `Menampilkan ${startIndex}-${endIndex} dari ${totalData} data${searchInfo}` 
        : `Tidak ada data${searchInfo}`;
    
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

function handleSearch() {
    filterTable();
}

// ============================================
// FUNGSI UTAMA MODAL
// ============================================

function closeModal(id) { 
    document.getElementById(id).classList.remove('show'); 
}

// ============================================
// FUNGSI UNTUK MENGAMBIL DATA DETAIL
// ============================================

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

// ============================================
// FITUR BARU: KLIK BARIS UNTUK DETAIL (showRowDetail)
// ============================================

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
        
        ${item.status === 'ditolak KK' ? `
        <button class="modal-btn" style="background: #ff9800;" onclick="event.stopPropagation(); closeModal('detailModal'); showReturnModal(${item.id}, '${escapeHtml(getVal('nama_kegiatan'))}')">
            <i class="fa-solid fa-undo"></i> Kembalikan
        </button>
        ` : ''}
        
        <button class="btn btn-eviden" style="background: #28a745 !important;" onclick="event.stopPropagation(); closeModal('detailModal'); showEvidenModal(${item.id})">
            <i class="fas fa-file-image"></i> Lihat Eviden
        </button>
    </div>`;
}

// ============================================
// FITUR BARU: TOMBOL EVIDEN (showEvidenModal)
// ============================================

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

// ============================================
// FUNGSI RETURN MODAL
// ============================================

function showReturnModal(id, namaKegiatan) {
    currentReturnId = id;
    
    // Set data ke modal
    document.getElementById('returnNamaKegiatan').textContent = namaKegiatan;
    document.getElementById('returnForm').action = '<?= base_url("kaprodi/return_pengajuan/") ?>' + id;
    
    // Tampilkan modal
    document.getElementById('returnModal').classList.add('show');
}

// ============================================
// PREVIEW FILE FUNCTIONS
// ============================================

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

// ============================================
// HELPER FUNCTIONS
// ============================================

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

// ============================================
// EVENT LISTENERS
// ============================================

// Enter key support for search
document.getElementById('searchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        handleSearch();
    }
});

// Auto reset when input is cleared
document.getElementById('searchInput').addEventListener('input', function(e) {
    if (e.target.value === '') {
        filterTable();
    }
});
</script>
</body>
</html>