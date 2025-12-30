<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Ditolak - Dashboard Dekan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* SAMA PERSIS DENGAN halaman_total.php TAPI WARNA UNGU DAN TANPA STYLE FILTER */
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;background:#f5f7fa;}
        .navbar{background:#8E44AD;color:white;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
        .navbar h2{font-size:20px;}
        .container{max-width:1200px;margin:30px auto;padding:0 20px;}
        
        /* Back Button */
        .back-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#8E44AD;color:white;text-decoration:none;border-radius:8px;font-weight:600;transition:all 0.3s;margin-bottom:20px}
        .back-btn:hover{background:#7D3C98;transform:translateY(-2px)}
        
        /* Card Styles */
        .card{background:white;border-radius:10px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,0.06);margin-bottom:20px}
        .card-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid #eee}
        
        /* Search Box Styles - TETAP ADA */
        .search-container{margin-bottom:20px}
        .search-label{display:block;margin-bottom:8px;color:#6c757d;font-size:14px;font-weight:500}
        .search-box{display:flex;gap:10px;align-items:center;width:100%}
        .search-input-wrapper{position:relative;flex:1}
        .search-input{width:100%;padding:12px 45px 12px 15px;border:1px solid #e9ecef;border-radius:8px;font-size:14px;transition:all 0.3s;background:white;color:#495057}
        .search-input:focus{outline:none;border-color:#8E44AD;box-shadow:0 0 0 2px rgba(142,68,173,0.1)}
        .search-input::placeholder{color:#6c757d}
        .search-icon{position:absolute;right:15px;top:50%;transform:translateY(-50%);color:#6c757d;font-size:16px}
        .btn-cari{padding:12px 24px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#8E44AD;color:#fff;white-space:nowrap}
        .btn-cari:hover{background:#7D3C98;transform:translateY(-1px)}
        
        /* Table Styles */
        table{width:100%;border-collapse:collapse}
        thead{background:#f4f6f7}
        th,td{padding:12px;border-bottom:1px solid #ecf0f1;text-align:left;font-size:14px}
        tbody tr:hover{background:#fbfcfd}
        
        /* Badge Styles */
        .badge{display:inline-block;padding:6px 10px;border-radius:999px;font-weight:600;font-size:12px}
        .badge-rejected{background:#f8d7da;color:#721c24}
        
        /* Button Styles */
        .btn{padding:6px 10px;border-radius:6px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s}
        .btn:hover{transform:scale(1.05)}
        .btn-detail{background:#3498db;color:#fff}
        .btn-detail:hover{background:#2980b9}
        
        /* Tombol Eviden - SAMA DENGAN TOTAL */
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

        /* Tombol Return - WARNA ORANGE/KUNING SEPERTI DI DASHBOARD */
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

        /* HAPUS TOMBOL STATUS STYLE */
        
        /* Pagination Info */
        .pagination-info{margin-top:15px;color:#7f8c8d;font-size:14px;text-align:right}
        
         /* Modal Styles */
    .modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.45);align-items:center;justify-content:center}
    .modal.show{display:flex}
    .modal-content{background:white;padding:0;border-radius:15px;max-width:1100px;width:95%;max-height:85vh;overflow:hidden;animation:slideIn 0.3s ease;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
    @keyframes slideIn{from{transform:translateY(-50px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-header{background:#FB8C00;color:white;padding:20px 25px;display:flex;justify-content:space-between;align-items:center;border-radius:15px 15px 0 0}
    .modal-header h3{margin:0;font-size:18px;font-weight:600}
    .close-modal{background:none;border:0;color:white;font-size:24px;cursor:pointer;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background 0.2s}
    .close-modal:hover{background:rgba(255,255,255,0.2)}
        
/* Detail Content Styles - IMPROVED (SAMA DENGAN DASHBOARD SEKRETARIAT) */
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
        
        /* Dosen list in detail - SAMA DENGAN TOTAL */
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
        
        /* File Evidence Styles - SAMA DENGAN TOTAL */
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

        /* Preview Modal Styles - SAMA DENGAN TOTAL */
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
        
        /* Eviden Modal Styles - SAMA DENGAN TOTAL */
        .eviden-modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.45);align-items:center;justify-content:center}
        .eviden-modal.show{display:flex}
        
        /* Action Buttons in Modal - SAMA DENGAN TOTAL */
        .modal-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:20px;padding-top:20px;border-top:1px solid #e9ecef}
        .modal-btn{padding:10px 20px;border-radius:8px;border:none;cursor:pointer;font-weight:600;font-size:14px;transition:all 0.2s;display:flex;align-items:center;gap:8px}
        .modal-btn-close{background:#6c757d;color:white}
        .modal-btn-close:hover{background:#5a6268;transform:translateY(-2px)}
        .modal-btn-return{background:#ff9800;color:white}
        .modal-btn-return:hover{background:#f57c00;transform:translateY(-2px)}
        
        /* Rejection Notes Styles - SAMA DENGAN TOTAL */
        .rejection-notes{background:#fff5f5;border:1px solid #f8d7da;border-radius:8px;padding:20px;margin-top:15px}
        .rejection-notes .detail-label{color:#dc3545;font-weight:700}
        .rejection-notes .detail-value{background:#fff5f5;border-color:#f8d7da;color:#721c24;font-size:14px;line-height:1.5;min-height:auto;padding:12px}
        
        /* Clickable Row Styles - SAMA DENGAN TOTAL */
        .clickable-row {
            cursor: pointer !important;
            transition: all 0.2s ease;
        }

        .clickable-row:hover {
            background-color: #f5eef8 !important;
            box-shadow: 0 2px 4px rgba(142, 68, 173, 0.1);
        }

        .clickable-row:active {
            background-color: #e8daef !important;
            transform: scale(0.998);
        }

        /* Highlight untuk baris yang sedang dipilih */
        .clickable-row.selected {
            background-color: #f5eef8 !important;
            border-left: 4px solid #8E44AD;
        }

        /* Pastikan tombol di dalam row tidak ter-affected */
        .clickable-row button,
        .clickable-row select,
        .clickable-row textarea,
        .clickable-row input {
            pointer-events: all;
        }
        
        /* Nomor Surat Styles - SAMA DENGAN TOTAL */
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
        
        /* Surat Tugas Modal Styles - SAMA DENGAN TOTAL */
        #suratTugasModal .modal-content {
            max-width: 900px;
            width: 95%;
            height: 85vh;
        }
        
        #suratTugasContent {
            padding: 0 !important;
            height: calc(85vh - 130px) !important;
            overflow: hidden !important;
        }
        
        #suratIframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        
        /* Tombol aksi surat */
        .surat-actions {
            padding: 15px 25px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8f9fa;
            border-radius: 0 0 15px 15px;
        }
        
        /* Return Modal Styles - SEDERHANA SEPERTI DI DASHBOARD */
        .return-simple-modal-content {
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

        .return-simple-modal-body {
            padding: 25px;
        }

        .return-simple-modal-header {
            background: #ff9800;
            color: white;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 15px 15px 0 0;
        }

        .return-simple-modal-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }

        .return-simple-info-box {
            background: #fff3e0;
            border: 1px solid #ffb74d;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .return-simple-info-box strong {
            color: #ff9800;
            display: block;
            margin-bottom: 5px;
        }

        .return-simple-info-box span {
            color: #2c3e50;
            font-weight: 600;
        }

        .return-simple-modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .return-simple-btn {
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

        .return-simple-btn-cancel {
            background: #95a5a6;
            color: white;
        }

        .return-simple-btn-cancel:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
        }

        .return-simple-btn-submit {
            background: #ff9800;
            color: white;
        }

        .return-simple-btn-submit:hover {
            background: #f57c00;
            transform: translateY(-2px);
        }
        
        /* Success Result Modal untuk Return - SEDERHANA */
        .success-return-modal-content {
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
        
        /* Responsive */
        @media (max-width:768px){
            .detail-grid{grid-template-columns:1fr}
            .modal-content{width:95%;margin:10px}
            .detail-content{padding:15px}
            .modal-actions{flex-direction:column}
            .modal-btn{justify-content:center}
            #suratTugasModal .modal-content {
                max-width: 95%;
                height: 90vh;
            }
            #suratTugasContent {
                height: calc(90vh - 130px) !important;
            }
        }
    </style>
</head>
<body>

<div class="navbar">
    <h2><i class="fa-solid fa-user-tie"></i> Dashboard Dekan</h2>
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

    <!-- Tabel Pengajuan Ditolak - HANYA SEARCH, TANPA FILTER -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-table"></i> Daftar Pengajuan Ditolak</h3>
            <div>
                <span id="filterInfo" style="color:#7f8c8d;font-size:13px">
                    <?php
                    $total_data = isset($total_surat) ? $total_surat : (isset($surat_list) ? count($surat_list) : (isset($data_pengajuan) ? count($data_pengajuan) : '0'));
                    echo "Menampilkan: Semua Data (" . $total_data . " data)";
                    ?>
                </span>
            </div>
        </div>
        
        <!-- Search Box - TETAP ADA -->
        <div class="search-container">
            <label class="search-label">Cari berdasarkan nama kegiatan, penyelenggara, atau jenis pengajuan...</label>
            <div class="search-box">
                <div class="search-input-wrapper">
                    <input 
                        type="text" 
                        id="searchInput"
                        class="search-input"
                        placeholder="Ketik untuk mencari..."
                        value="<?= htmlspecialchars($this->input->get('search') ?? '') ?>"
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
                    // Data dari controller atau data statis
                    if (isset($surat_list) && is_array($surat_list) && count($surat_list) > 0): 
                        $i = 1; 
                        foreach ($surat_list as $s): 
                            $st_raw = isset($s['status']) ? trim($s['status']) : '';
                            $st_l = strtolower($st_raw);
                            
                            // Hanya tampilkan yang statusnya ditolak
                            if ($st_l === 'ditolak dekan' || $st_l === 'ditolak' || strpos($st_l, 'ditolak') !== false) {
                                $badge = '<span class="badge badge-rejected">Ditolak Dekan</span>';
                            } else {
                                continue; // Skip jika bukan status ditolak
                            }
                            
                            $tgl_pengajuan = isset($s['created_at']) && $s['created_at'] ? date('d M Y', strtotime($s['created_at'])) : '-';
                            $tgl_kegiatan = isset($s['tanggal_kegiatan']) && $s['tanggal_kegiatan'] ? date('d M Y', strtotime($s['tanggal_kegiatan'])) : '-';
                    ?>
                    <tr onclick="showRowDetail(<?= (int)$s['id'] ?>)" style="cursor: pointer;" class="clickable-row" data-search="<?= htmlspecialchars(strtolower(($s['nama_kegiatan'] ?? '') . ' ' . ($s['penyelenggara'] ?? '') . ' ' . ($s['jenis_pengajuan'] ?? ''))) ?>">
                        <td><?= $i ?></td>
                        <td><strong><?= htmlspecialchars($s['nama_kegiatan'] ?? '-') ?></strong></td>
                        <td><?= htmlspecialchars($s['penyelenggara'] ?? '-') ?></td>
                        <td><?= $tgl_pengajuan ?></td>
                        <td><?= $tgl_kegiatan ?></td>
                        <td><?= htmlspecialchars($s['jenis_pengajuan'] ?? '-') ?></td>
                        <td><?= $badge ?></td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <!-- Tombol Eviden -->
                                <button class="btn btn-eviden" onclick="event.stopPropagation(); showEvidenModal(<?= (int)$s['id'] ?>)" title="Lihat Eviden">
                                    <i class="fas fa-file-image"></i>
                                </button>

                                <!-- Tombol Mata (Surat Tugas) -->
                                <button class="btn btn-detail" onclick="event.stopPropagation(); showDetail(<?= (int)$s['id'] ?>)" title="Lihat Surat Tugas">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                
                                <!-- TAMBAHKAN TOMBOL RETURN SEPERTI DI DASHBOARD -->
                                <button class="btn btn-return" onclick="event.stopPropagation(); showReturnModalSimple(<?= (int)$s['id'] ?>, '<?= htmlspecialchars(addslashes($s['nama_kegiatan'] ?? '-')) ?>')" title="Kembalikan Pengajuan">
                                    <i class="fa-solid fa-undo"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php $i++; endforeach; ?>
                    <?php else: ?>
                        <!-- Data statis fallback jika tidak ada data dari controller -->
                        <?php if(isset($data_pengajuan) && is_array($data_pengajuan)): ?>
                            <?php $i = 1; foreach($data_pengajuan as $s): ?>
                            <tr onclick="showRowDetail(<?= (int)$s['id'] ?>)" style="cursor: pointer;" class="clickable-row" data-search="<?= htmlspecialchars(strtolower(($s['nama_kegiatan'] ?? '') . ' ' . ($s['penyelenggara'] ?? '') . ' ' . ($s['jenis_pengajuan'] ?? ''))) ?>">
                                <td><?= $i ?></td>
                                <td><strong><?= htmlspecialchars($s['nama_kegiatan'] ?? '-') ?></strong></td>
                                <td><?= htmlspecialchars($s['penyelenggara'] ?? '-') ?></td>
                                <td><?= isset($s['created_at']) ? date('d M Y', strtotime($s['created_at'])) : '-' ?></td>
                                <td><?= isset($s['tanggal_kegiatan']) ? date('d M Y', strtotime($s['tanggal_kegiatan'])) : '-' ?></td>
                                <td><?= htmlspecialchars($s['jenis_pengajuan'] ?? '-') ?></td>
                                <td>
                                    <span class="badge badge-rejected">Ditolak Dekan</span>
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px">
                                        <button class="btn btn-eviden" onclick="event.stopPropagation(); showEvidenModal(<?= (int)$s['id'] ?>)" title="Lihat Eviden">
                                            <i class="fas fa-file-image"></i>
                                        </button>
                                        <button class="btn btn-detail" onclick="event.stopPropagation(); showSuratTugasModal(<?= (int)$s['id'] ?>)" title="Lihat Surat Tugas">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <!-- TAMBAHKAN TOMBOL RETURN -->
                                        <button class="btn btn-return" onclick="event.stopPropagation(); showReturnModalSimple(<?= (int)$s['id'] ?>, '<?= htmlspecialchars(addslashes($s['nama_kegiatan'] ?? '-')) ?>')" title="Kembalikan Pengajuan">
                                            <i class="fa-solid fa-undo"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php $i++; endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align:center;padding:40px;color:#7f8c8d">
                                    <i class="fa-solid fa-times-circle" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
                                    <strong>
                                        <?php if($this->input->get('search')): ?>
                                            Tidak ada data yang sesuai dengan pencarian
                                        <?php else: ?>
                                            Belum ada pengajuan yang ditolak
                                        <?php endif; ?>
                                    </strong>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-info">
            <span id="paginationText">
                <?php
                $total_data = isset($total_surat) ? $total_surat : (isset($surat_list) ? count($surat_list) : (isset($data_pengajuan) ? count($data_pengajuan) : '0'));
                $search_term = $this->input->get('search') ?? '';
                
                if($search_term) {
                    echo "Menampilkan hasil pencarian untuk: \"" . htmlspecialchars($search_term) . "\" (" . $total_data . " data)";
                } else {
                    echo "Menampilkan: Semua Data (" . $total_data . " data)";
                }
                ?>
            </span>
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

<!-- Eviden Modal -->
<div id="evidenModal" class="modal" onclick="modalClickOutside(event,'evidenModal')">
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

<!-- Return Modal SEDERHANA - SAMA DENGAN DASHBOARD (TANPA CATATAN) -->
<div id="returnSimpleModal" class="modal">
    <div class="return-simple-modal-content" onclick="event.stopPropagation()">
        <div class="return-simple-modal-header">
            <h3><i class="fa-solid fa-undo"></i> Konfirmasi Pengembalian</h3>
            <button class="close-modal" onclick="closeModal('returnSimpleModal')">&times;</button>
        </div>
        <div class="return-simple-modal-body">
            <div class="return-simple-info-box">
                <strong><i class="fa-solid fa-exclamation-triangle"></i> Peringatan</strong>
                <span id="returnSimpleNamaKegiatan">-</span>
            </div>
            
            <p style="margin-bottom:20px;color:#e65100;font-weight:600">
                ⚠️ Pengajuan ini akan dikembalikan ke status sebelumnya dan dapat diajukan ulang.
            </p>
            
            <form id="returnSimpleForm" method="POST" action="">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                
                <div class="return-simple-modal-actions">
                    <button type="button" class="return-simple-btn return-simple-btn-cancel" onclick="closeModal('returnSimpleModal')">
                        <i class="fa-solid fa-times"></i> Batal
                    </button>
                    <button type="submit" class="return-simple-btn return-simple-btn-submit">
                        <i class="fa-solid fa-undo"></i> Ya, Kembalikan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Result Modal untuk Return - SEDERHANA -->
<div id="successReturnSimpleModal" class="modal">
    <div class="success-return-modal-content" onclick="event.stopPropagation()">
        <div class="modal-header" style="background: #ff9800;">
            <h3><i class="fa-solid fa-undo"></i> <span id="successReturnSimpleTitle">Pengajuan Berhasil Dikembalikan</span></h3>
            <button class="close-modal" onclick="closeModal('successReturnSimpleModal')">&times;</button>
        </div>
        <div style="padding:25px;text-align:center">
            <div style="width:100px;height:100px;border-radius:50%;background:#fff3e0;margin:0 auto 20px;display:flex;align-items:center;justify-content:center">
                <i class="fas fa-undo" style="font-size:50px;color:#ff9800"></i>
            </div>
            
            <h3 style="color:#ff9800;margin-bottom:10px">Berhasil Dikembalikan</h3>
            <p style="color:#666;margin-bottom:5px">
                <i class="fa-solid fa-clock"></i> Dikembalikan pada: <strong id="returnSimpleTimestamp">-</strong>
            </p>
            
            <p style="color:#666;margin-bottom:20px">
                Pengajuan telah dikembalikan ke status "Diajukan ke Dekan" dan dapat diproses ulang.
            </p>
            
            <div style="display:flex;gap:10px;justify-content:center;margin-top:20px">
                <button class="btn" onclick="closeModal('successReturnSimpleModal'); window.location.reload();" style="background:#6c757d;color:white;padding:10px 24px;border:none;border-radius:6px;cursor:pointer;font-weight:600;display:flex;align-items:center;gap:6px">
                    <i class="fa-solid fa-check"></i> OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Surat Tugas Modal -->
<div id="suratTugasModal" class="modal" onclick="modalClickOutside(event,'suratTugasModal')">
    <div class="modal-content" style="max-width: 900px;" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-contract"></i> Surat Tugas</h3>
            <button class="close-modal" onclick="closeModal('suratTugasModal')">&times;</button>
        </div>
        <div class="detail-content" id="suratTugasContent" style="padding: 0;">
            <div id="suratLoading" style="text-align:center;padding:40px; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size:48px;color:#8E44AD"></i>
                <p style="margin-top:20px;color:#7f8c8d">Memuat surat tugas...</p>
            </div>
            <iframe 
                id="suratIframe" 
                style="width:100%; height:100%; border:none; display:none;"
                sandbox="allow-same-origin allow-scripts allow-popups allow-forms"
                allow="fullscreen"
            ></iframe>
        </div>
        <div class="surat-actions">
            <div>
                <button class="btn btn-primary" onclick="cetakSurat()" style="padding:8px 16px;">
                    <i class="fa-solid fa-print"></i> Cetak
                </button>
                <button class="btn btn-success" onclick="downloadSurat()" style="padding:8px 16px; margin-left:10px;">
                    <i class="fa-solid fa-download"></i> Download
                </button>
            </div>
            <button class="modal-btn modal-btn-close" onclick="closeModal('suratTugasModal')">
                <i class="fa-solid fa-times"></i> Tutup
            </button>
        </div>
    </div>
</div>

<script>
// Data dari controller atau data statis
const suratList = <?= isset($surat_list) && !empty($surat_list) ? json_encode($surat_list) : (isset($data_pengajuan) ? json_encode($data_pengajuan) : '[]') ?>;
let currentSuratId = null;
let currentReturnSimpleId = null;

// ============================================
// FUNGSI RETURN SEDERHANA (TANPA CATATAN) - SEPERTI DI DASHBOARD
// ============================================

// Fungsi untuk menampilkan return modal sederhana
function showReturnModalSimple(id, namaKegiatan) {
    currentReturnSimpleId = id;
    
    // Set data ke modal
    document.getElementById('returnSimpleNamaKegiatan').textContent = namaKegiatan;
    document.getElementById('returnSimpleForm').action = '<?= base_url("dekan/return_pengajuan/") ?>' + id;
    
    // Tampilkan modal
    document.getElementById('returnSimpleModal').classList.add('show');
}

// Fungsi untuk menampilkan success return modal sederhana
function showSuccessReturnSimpleModal() {
    const modal = document.getElementById('successReturnSimpleModal');
    const timestamp = document.getElementById('returnSimpleTimestamp');
    
    // Format timestamp
    const now = new Date();
    timestamp.textContent = now.toLocaleDateString('id-ID', { 
        day: '2-digit', 
        month: 'long', 
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }) + ' WIB';
    
    modal.classList.add('show');
}

// Fungsi untuk update tombol return di tabel
function updateReturnButtons() {
    // Update semua tombol return di tabel
    const returnButtons = document.querySelectorAll('button[onclick*="showReturnModal"]');
    returnButtons.forEach(button => {
        const onclickAttr = button.getAttribute('onclick');
        if (onclickAttr) {
            // Cek pattern untuk showReturnModalSimple(id, namaKegiatan)
            const match = onclickAttr.match(/showReturnModalSimple\((\d+),\s*'([^']+)'\)/);
            if (match) {
                const id = match[1];
                const namaKegiatan = match[2];
                
                // Update onclick attribute ke modal baru
                button.setAttribute('onclick', `event.stopPropagation(); showReturnModalSimple(${id}, '${escapeHtml(namaKegiatan.replace(/'/g, "\\'"))}')`);
            } else {
                // Cek pattern lama showReturnModal(id)
                const match2 = onclickAttr.match(/showReturnModal\((\d+)\)/);
                if (match2) {
                    const id = match2[1];
                    const row = button.closest('tr');
                    const namaKegiatan = row.querySelector('td:nth-child(2) strong')?.textContent || 'Nama Kegiatan';
                    
                    // Update onclick attribute ke modal baru
                    button.setAttribute('onclick', `event.stopPropagation(); showReturnModalSimple(${id}, '${escapeHtml(namaKegiatan)}')`);
                }
            }
        }
    });
    
    // Update tombol return di modal detail
    const modalReturnButtons = document.querySelectorAll('button[style*="background: #ff9800"][onclick*="showReturnModal"]');
    modalReturnButtons.forEach(button => {
        const onclickAttr = button.getAttribute('onclick');
        if (onclickAttr) {
            const match = onclickAttr.match(/showReturnModalSimple\((\d+),\s*'([^']+)'\)/);
            if (match) {
                const id = match[1];
                const namaKegiatan = match[2];
                
                button.setAttribute('onclick', `event.stopPropagation(); closeModal('detailModal'); showReturnModalSimple(${id}, '${escapeHtml(namaKegiatan.replace(/'/g, "\\'"))}')`);
            }
        }
    });
}

// ============================================
// FUNGSI UTAMA UNTUK SURAT TUGAS MODAL
// ============================================

// Fungsi untuk membuka surat tugas dalam modal popup
function showSuratTugasModal(id) {
    try {
        currentSuratId = id;
        
        // Tampilkan modal
        const modal = document.getElementById('suratTugasModal');
        if (!modal) {
            console.error('Modal suratTugasModal tidak ditemukan!');
            // Fallback: buka di tab baru
            const suratUrl = '<?= site_url("dekan/view_surat_print/") ?>' + id;
            window.open(suratUrl, '_blank');
            return;
        }
        
        modal.classList.add('show');
        
        // Reset dan tampilkan loading
        const loading = document.getElementById('suratLoading');
        const iframe = document.getElementById('suratIframe');
        
        if (loading) {
            loading.style.display = 'flex';
            loading.innerHTML = `
                <div style="text-align:center;padding:40px;">
                    <i class="fa-solid fa-spinner fa-spin" style="font-size:48px;color:#8E44AD"></i>
                    <p style="margin-top:20px;color:#7f8c8d">Memuat surat tugas...</p>
                </div>
            `;
        }
        
        if (iframe) {
            iframe.style.display = 'none';
            iframe.src = '';
        }
        
        // Bangun URL surat tugas
        const suratUrl = '<?= site_url("dekan/view_surat_print/") ?>' + id;
        
        // Set timeout untuk memuat iframe
        setTimeout(() => {
            if (iframe) {
                iframe.src = suratUrl;
                
                // Event ketika iframe selesai load
                iframe.onload = function() {
                    if (loading) loading.style.display = 'none';
                    iframe.style.display = 'block';
                };
                
                // Event jika error loading iframe
                iframe.onerror = function() {
                    if (loading) {
                        loading.style.display = 'flex';
                        loading.innerHTML = `
                            <div style="color:#e74c3c; text-align:center;">
                                <i class="fa-solid fa-exclamation-triangle" style="font-size:48px;margin-bottom:10px"></i>
                                <p>Gagal memuat surat tugas</p>
                                <button class="btn btn-primary" onclick="window.open('${suratUrl}', '_blank')" style="margin-top:15px">
                                    <i class="fa-solid fa-external-link-alt"></i> Buka di Tab Baru
                                </button>
                            </div>
                        `;
                    }
                };
            }
        }, 100);
        
    } catch (error) {
        console.error('Error loading surat:', error);
        alert('Gagal memuat surat tugas: ' + error.message);
    }
}

// Fungsi untuk mencetak surat
function cetakSurat() {
    const iframe = document.getElementById('suratIframe');
    if (iframe && iframe.contentWindow) {
        try {
            iframe.contentWindow.print();
        } catch (e) {
            // Fallback: buka di tab baru lalu print
            window.open(iframe.src, '_blank').print();
        }
    }
}

// Fungsi untuk mendownload surat
function downloadSurat() {
    const iframe = document.getElementById('suratIframe');
    if (iframe && iframe.src) {
        // Buat link download
        const link = document.createElement('a');
        link.href = iframe.src;
        link.target = '_blank';
        link.download = `surat_tugas_${currentSuratId}.pdf`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

// Fungsi untuk menutup modal surat
function closeSuratModal() {
    const modal = document.getElementById('suratTugasModal');
    const iframe = document.getElementById('suratIframe');
    const loading = document.getElementById('suratLoading');
    
    if (iframe) {
        iframe.src = '';
        iframe.style.display = 'none';
    }
    
    if (loading) {
        loading.style.display = 'flex';
        loading.innerHTML = `
            <div style="text-align:center;padding:40px;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size:48px;color:#8E44AD"></i>
                <p style="margin-top:20px;color:#7f8c8d">Memuat surat tugas...</p>
            </div>
        `;
    }
    
    if (modal) {
        modal.classList.remove('show');
    }
}

// ============================================
// FUNGSI-FUNGSI LAINNYA
// ============================================

// Fungsi untuk mengambil data detail via AJAX
function getSuratDetail(id) {
    return fetch('<?= site_url("dekan/getDetailPengajuan/") ?>' + id)
        .then(response => {
            const contentType = response.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                return response.text().then(text => {
                    console.error('Server mengembalikan non-JSON:', text.substring(0, 500));
                    throw new Error('Server mengembalikan format tidak valid');
                });
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
            // Fallback ke data lokal
            const localData = suratList.find(s => Number(s.id) === Number(id));
            if (localData) {
                console.log('Menggunakan data dari array lokal');
                return Promise.resolve(localData);
            }
            throw error;
        });
}

// Fungsi untuk menampilkan detail saat row diklik
async function showRowDetail(id) {
    try {
        document.getElementById('detailContent').innerHTML = `
            <div style="text-align:center;padding:40px;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#8E44AD"></i>
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

// Fungsi untuk generate konten detail
function generateDetailContentEnhanced(item) {
    const getVal = (k) => {
        const value = (item[k] !== undefined && item[k] !== null && item[k] !== '' ? item[k] : '-');
        return value;
    };

    let statusBadge = '';
    const status = getVal('status').toLowerCase();

    if (status === 'ditolak dekan' || status.includes('ditolak')) {
        statusBadge = `<span class="badge badge-rejected">Ditolak Dekan</span>`;
    } else {
        statusBadge = `<span class="badge badge-rejected">Ditolak</span>`;
    }

    const dosenData = item.dosen_data || [];

   // Generate HTML untuk data dosen - DENGAN FOTO PROFIL
let dosenHtml = '';
if (dosenData && dosenData.length > 0) {
    dosenHtml = `
    <div class="detail-section">
        <div class="dosen-list">
            ${dosenData.map((dosen, index) => {
                // Pastikan data dosen valid
                const nama = escapeHtml(dosen.nama || 'Data tidak tersedia');
                const nip = escapeHtml(dosen.nip || '-');
                const jabatan = escapeHtml(dosen.jabatan || 'Dosen');
                const divisi = escapeHtml(dosen.divisi || '-');
                const foto = dosen.foto || '';
                
                // Generate foto URL atau initial
                let avatarContent = '';
                if (foto && foto !== '' && foto !== '-') {
                    const fotoUrl = '<?= base_url("uploads/foto/") ?>' + foto;
                    avatarContent = `<img src="${fotoUrl}" alt="${nama}" style="width:100%; height:100%; object-fit:cover; border-radius:50%;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                   <div style="display:none; width:100%; height:100%; align-items:center; justify-content:center; background:#FB8C00; color:white; font-size:12px; font-weight:600; border-radius:50%;">
                                       ${nama ? nama.charAt(0).toUpperCase() : '?'}
                                   </div>`;
                } else {
                    avatarContent = nama ? nama.charAt(0).toUpperCase() : '?';
                }
                
                return `
                <div class="dosen-item">
                    <div class="dosen-avatar">
                        ${avatarContent}
                    </div>
                    <div class="dosen-info">
                        <div class="dosen-name">${nama}</div>
                        <div class="dosen-details">
                            NIP: ${nip} | ${jabatan} | Divisi: ${divisi}
                        </div>
                    </div>
                </div>
                `;
            }).join('')}
        </div>
    </div>`;
} else {
    // Fallback jika tidak ada data dosen
    dosenHtml = `
    <div class="detail-section">
        <div class="detail-section-title">
            <i class="fa-solid fa-user-graduate"></i> Dosen Terkait
        </div>
        <div class="dosen-list">
            <div class="dosen-item">
                <div class="dosen-avatar">
                    ?
                </div>
                <div class="dosen-info">
                    <div class="dosen-name">Data dosen tidak tersedia</div>
                    <div class="dosen-details">
                        NIP: - | Dosen | Divisi: -
                    </div>
                </div>
            </div>
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
        <div class="rejection-notes">
            <div class="detail-section-title">
                <i class="fa-solid fa-exclamation-triangle"></i> Alasan Penolakan
            </div>
            <div class="detail-row">
                <div class="detail-label">Catatan Penolakan</div>
                <div class="detail-value">${escapeHtml(getVal('catatan_penolakan'))}</div>
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
        <button class="modal-btn modal-btn-return" onclick="event.stopPropagation(); closeModal('detailModal'); showReturnModalSimple(${item.id}, '${escapeHtml(getVal('nama_kegiatan'))}')">
            <i class="fa-solid fa-undo"></i> Kembalikan Pengajuan
        </button>
    </div>`;
}

// Fungsi showEvidenModal
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
    document.getElementById('evidenContent').innerHTML = `
        <div style="text-align:center;padding:40px;">
            <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#8E44AD"></i>
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

// Preview file function
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
// FUNGSI HELPER
// ============================================

function closeModal(id) { 
    if (id === 'suratTugasModal') {
        closeSuratModal();
    } else {
        document.getElementById(id).classList.remove('show'); 
    }
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
// FUNGSI SEARCHING
// ============================================

let currentSearchTerm = '<?= htmlspecialchars($this->input->get('search') ?? '') ?>';

// Fungsi untuk menangani pencarian
function handleSearch() {
    const searchInput = document.getElementById('searchInput');
    currentSearchTerm = searchInput.value.toLowerCase().trim();
    
    // Jika search kosong, reload halaman tanpa parameter search
    if (!currentSearchTerm) {
        window.location.href = '<?= base_url("dekan/halaman_ditolak") ?>';
        return;
    }
    
    // Reload halaman dengan parameter search
    const url = new URL(window.location.href);
    url.searchParams.set('search', currentSearchTerm);
    window.location.href = url.toString();
}

// Update info pagination
function updatePaginationInfo(visibleCount, totalCount) {
    const paginationText = document.getElementById('paginationText');
    const filterInfo = document.getElementById('filterInfo');
    
    if (currentSearchTerm) {
        paginationText.textContent = `Menampilkan hasil pencarian untuk: "${currentSearchTerm}" (${visibleCount} data)`;
        filterInfo.textContent = `Menampilkan hasil pencarian untuk: "${currentSearchTerm}" (${visibleCount})`;
    } else {
        paginationText.textContent = `Menampilkan: Semua Data (${totalCount} data)`;
        filterInfo.textContent = `Menampilkan: Semua Data (${totalCount})`;
    }
}

// Enter key support for search
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                handleSearch();
            }
        });
    }
    
    // Isi search input dengan nilai dari URL jika ada
    const urlParams = new URLSearchParams(window.location.search);
    const searchParam = urlParams.get('search');
    if (searchParam && searchInput) {
        searchInput.value = searchParam;
        currentSearchTerm = searchParam;
    }
    
    // Initialize pagination info
    const totalCount = <?= isset($total_surat) ? $total_surat : (isset($surat_list) ? count($surat_list) : (isset($data_pengajuan) ? count($data_pengajuan) : '0')) ?>;
    updatePaginationInfo(totalCount, totalCount);
    
    // Update tombol return
    updateReturnButtons();
});

// ============================================
// FUNGSI UNTUK MEMBUAT ROWS CLICKABLE
// ============================================

function makeRowsClickable() {
    const rows = document.querySelectorAll('#tableBody tr:not(#emptyRow)');
    
    rows.forEach(row => {
        row.classList.add('clickable-row');
        
        const onclickAttr = row.getAttribute('onclick');
        if (onclickAttr) {
            const match = onclickAttr.match(/showRowDetail\((\d+)\)/);
            
            if (match) {
                const suratId = match[1];
                
                row.addEventListener('click', function(e) {
                    if (e.target.closest('button') || 
                        e.target.closest('a') || 
                        e.target.closest('select') ||
                        e.target.closest('textarea') ||
                        e.target.closest('input')) {
                        return;
                    }
                    
                    rows.forEach(r => r.classList.remove('selected'));
                    
                    this.classList.add('selected');
                    
                    showRowDetail(suratId);
                });
                
                row.style.cursor = 'pointer';
            }
        }
    });
}

// ============================================
// INISIALISASI SAAT DOM LOADED
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    makeRowsClickable();

    window.addEventListener('click', function(e) {
        if (e.target.id === 'previewModal') {
            closePreviewModal();
        }
        if (e.target.id === 'suratTugasModal') {
            closeModal('suratTugasModal');
        }
    });

    // Check for success return modal data
    <?php if($this->session->flashdata('return_success')): ?>
        setTimeout(function() {
            showSuccessReturnSimpleModal();
        }, 800);
    <?php endif; ?>
});



// Fungsi showDetail untuk menampilkan surat pengajuan dengan scroll lengkap
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

        // Load surat pengajuan via iframe TANPA batasan tinggi
        const suratUrl = '<?= base_url("dekan/view_surat_pengajuan/") ?>' + id;
        
        document.getElementById('detailContent').innerHTML = `
            <div style="width:100%; overflow:hidden; border-radius:8px;">
                <iframe 
                    id="suratIframe"
                    src="${suratUrl}" 
                    style="width:100%; height:70vh; border:none;"
                    onload="adjustIframeHeight()"
                ></iframe>
            </div>
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

// Fungsi untuk menyesuaikan tinggi iframe berdasarkan konten
function adjustIframeHeight() {
    const iframe = document.getElementById('suratIframe');
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

function showDetailModal(id) {
    try {
        document.getElementById('detailContent').innerHTML = `
            <div style="text-align:center;padding:40px;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#8E44AD"></i>
                <p style="margin-top:10px;color:#7f8c8d">Memuat detail pengajuan...</p>
            </div>
        `;
        document.getElementById('detailModal').classList.add('show');

        const data = getSuratDetail(id);
        
        if (!data) {
            alert('Data tidak ditemukan');
            closeModal('detailModal');
            return;
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
</script>
</body>
</html>