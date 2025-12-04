<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Surat - Sekretariat</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;background:#f5f7fa;}
    
    /* Header */
    .header-title {
        background: #16A085;
        color: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
        text-align: center;
        font-weight: 700;
        font-size: 24px;
        box-shadow: 0 4px 12px rgba(22, 160, 133, 0.3);
    }
    
    /* Form Container */
    .container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 0 20px;
    }
    
    /* Form Sections */
    .form-section {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        border-left: 5px solid #16A085;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    .form-section h5 {
        color: #16A085;
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    /* Form Elements */
    .form-group {
        margin-bottom: 20px;
    }
    
    label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        display: block;
        font-size: 14px;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        transition: border-color 0.3s;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #16A085;
        box-shadow: 0 0 0 3px rgba(22, 160, 133, 0.2);
    }
    
    /* Table Styling */
    .table-responsive {
        overflow-x: auto;
        margin-bottom: 15px;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    
    thead {
        background: #e8f6f3;
    }
    
    th, td {
        padding: 12px;
        border-bottom: 1px solid #e9ecef;
        text-align: left;
    }
    
    tbody tr:hover {
        background: #f8f9fa;
    }
    
    /* Buttons */
    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    
    .btn-primary {
        background: #16A085;
        color: white;
    }
    
    .btn-primary:hover {
        background: #138D75;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(22, 160, 133, 0.3);
    }
    
    .btn-success {
        background: #27ae60;
        color: white;
    }
    
    .btn-success:hover {
        background: #229954;
        transform: translateY(-2px);
    }
    
    .btn-secondary {
        background: #7f8c8d;
        color: white;
    }
    
    .btn-secondary:hover {
        background: #6c757d;
        transform: translateY(-2px);
    }
    
    .btn-sm {
        padding: 8px 16px;
        font-size: 13px;
    }
    
    .remove-row {
        color: #e74c3c;
        font-weight: bold;
        cursor: pointer;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        transition: all 0.3s;
    }
    
    .remove-row:hover {
        background: #f8d7da;
        transform: scale(1.1);
    }
    
    /* File Evidence Styles */
    .existing-file-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        margin-bottom: 10px;
        transition: all 0.3s;
    }
    
    .existing-file-item:hover {
        background: #e8f6f3;
        border-color: #16A085;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(22, 160, 133, 0.1);
    }
    
    .file-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #16A085 0%, #138D75 100%);
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    
    .file-info {
        flex: 1;
        min-width: 0;
    }
    
    .file-name {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 4px;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .file-size {
        font-size: 12px;
        color: #7f8c8d;
    }
    
    .file-actions {
        display: flex;
        gap: 10px;
        flex-shrink: 0;
    }
    
    .btn-view-file, .btn-delete-existing {
        padding: 8px 15px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-view-file {
        background: #3498db;
        color: white;
    }
    
    .btn-view-file:hover {
        background: #2980b9;
        transform: scale(1.05);
    }
    
    .btn-delete-existing {
        background: #e74c3c;
        color: white;
    }
    
    .btn-delete-existing:hover {
        background: #c0392b;
        transform: scale(1.05);
    }
    
    /* New File Upload */
    .upload-item-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }
    
    .btn-icon-action {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        cursor: pointer;
        border: none;
        transition: all 0.3s;
        flex-shrink: 0;
    }
    
    .btn-add-file {
        background: #16A085;
        color: white;
    }
    
    .btn-add-file:hover {
        background: #138D75;
        transform: scale(1.1) rotate(90deg);
    }
    
    .btn-remove-file {
        background: #e74c3c;
        color: white;
    }
    
    .btn-remove-file:hover {
        background: #c0392b;
        transform: scale(1.1);
    }
    
    /* Error Message */
    #chk-error {
        color: #e74c3c;
        font-size: 13px;
        margin-top: 8px;
        font-weight: 600;
        display: block;
    }
    
    .file-deleted {
        opacity: 0.5;
        background: #f8d7da !important;
        border-color: #f5c6cb !important;
        text-decoration: line-through;
        pointer-events: none;
    }
    
    /* Modal Preview */
    .preview-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        z-index: 10000;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }
    
    .preview-modal.show {
        display: flex;
    }
    
    .preview-content {
        background: white;
        border-radius: 12px;
        width: 90%;
        max-width: 900px;
        max-height: 90vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    
    .preview-header {
        background: #16A085;
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .preview-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }
    
    .preview-close {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background 0.2s;
    }
    
    .preview-close:hover {
        background: rgba(255,255,255,0.2);
    }
    
    .preview-body {
        flex: 1;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f8f9fa;
        min-height: 400px;
    }
    
    .preview-iframe {
        width: 100%;
        height: 70vh;
        border: none;
    }
    
    .preview-image {
        max-width: 100%;
        max-height: 70vh;
        object-fit: contain;
    }
    
    .preview-unsupported {
        text-align: center;
        padding: 40px;
        color: #6c757d;
    }
    
    .preview-unsupported i {
        font-size: 48px;
        margin-bottom: 15px;
        color: #16A085;
    }
    
    /* Alert Box for Revision Mode */
    .alert-revision {
        background: #fff3cd;
        border: 2px solid #ffc107;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.2);
    }
    
    .alert-revision-content {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .alert-revision-icon {
        background: #ffc107;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .alert-revision-icon i {
        color: white;
        font-size: 24px;
    }
    
    .alert-rejection-reason {
        margin-top: 15px;
        padding: 12px;
        background: white;
        border-radius: 8px;
        border-left: 4px solid #dc3545;
    }
    
    /* Google-style Autocomplete - SEKRETARIAT THEME */
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
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
        color: #16A085; /* Warna tema sekretariat */
    }
    
    .autocomplete-item:first-child {
        border-left: 3px solid #16A085;
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
    
    /* Responsive */
    @media (max-width: 768px) {
        .container {
            padding: 0 15px;
        }
        
        .form-section {
            padding: 15px;
        }
        
        .existing-file-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .file-actions {
            width: 100%;
            flex-wrap: wrap;
        }
        
        .btn-view-file,
        .btn-delete-existing {
            flex: 1;
            justify-content: center;
        }
        
        .file-name {
            white-space: normal;
            word-break: break-all;
        }
        
        .upload-item-wrapper {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .btn-icon-action {
            align-self: flex-start;
        }
        
        .autocomplete-box-fixed {
            width: 90vw !important;
            left: 5vw !important;
        }
    }
</style>
</head>
<body>

<div class="container">
    <div class="header-title">
        <i class="fas fa-edit"></i> Edit Pengajuan Surat - Sekretariat
    </div>
    
    <?php 
    // Cek apakah ini revisi setelah penolakan
    $is_revision = false;
    $rejected_by = '';
    $current_status = isset($surat['status']) ? strtolower($surat['status']) : '';
    
    if ($current_status === 'ditolak dekan') {
        $is_revision = true;
        $rejected_by = 'Dekan';
    } elseif ($current_status === 'ditolak sekretariat') {
        $is_revision = true;
        $rejected_by = 'Sekretariat';
    }
    ?>
    
    <?php if ($is_revision): ?>
    <div class="alert-revision">
        <div class="alert-revision-content">
            <div class="alert-revision-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div style="flex: 1;">
                <h4 style="margin: 0 0 8px 0; color: #856404; font-size: 18px; font-weight: 700;">
                    <i class="fas fa-redo-alt"></i> Mode Revisi - Pengajuan Ulang
                </h4>
                <p style="margin: 0; color: #856404; font-size: 14px; line-height: 1.6;">
                    <strong>Surat ini ditolak oleh <?= $rejected_by; ?>.</strong><br>
                    Setelah Anda mengedit dan menyimpan, pengajuan akan <strong>dikirim kembali ke <?= $rejected_by; ?></strong> untuk disetujui ulang.
                </p>
                
                <?php if (!empty($surat['catatan_penolakan'])): ?>
                <div class="alert-rejection-reason">
                    <strong style="color: #dc3545; display: block; margin-bottom: 5px;">
                        <i class="fas fa-comment-dots"></i> Alasan Penolakan:
                    </strong>
                    <p style="margin: 0; color: #666; font-size: 13px; font-style: italic;">
                        "<?= htmlspecialchars($surat['catatan_penolakan']); ?>"
                    </p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <form action="<?= site_url('sekretariat/update_surat/' . (isset($surat['id']) ? $surat['id'] : '')); ?>" method="post" enctype="multipart/form-data">
        
        <!-- Informasi Kegiatan -->
        <div class="form-section">
            <h5><i class="fas fa-info-circle"></i> Informasi Kegiatan</h5>
            <div class="form-group">
                <label>Nomor Surat <span style="color:#e74c3c">*</span></label>
                <input type="text" name="nomor_surat" class="form-control" value="<?= htmlspecialchars($surat['nomor_surat'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label>Nama Kegiatan <span style="color:#e74c3c">*</span></label>
                <input type="text" name="nama_kegiatan" class="form-control" value="<?= htmlspecialchars($surat['nama_kegiatan'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Tanggal Pengajuan</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($surat['created_at'] ?? '-'); ?>" readonly>
            </div>
            
            <div class="form-group">
                <label>Jenis Tanggal</label>
                <select name="jenis_date" id="jenis_date" class="form-control">
                    <option value="Custom" <?= (isset($surat['jenis_date']) && $surat['jenis_date']=='Custom') ? 'selected' : '' ?>>Custom</option>
                    <option value="Periode" <?= (isset($surat['jenis_date']) && $surat['jenis_date']=='Periode') ? 'selected' : '' ?>>Periode</option>
                </select>
            </div>
            
            <div id="custom_date" style="<?= (isset($surat['jenis_date']) && $surat['jenis_date']=='custom') ? '' : 'display:none;'; ?>">
                <div class="form-group">
                    <label>Tanggal Mulai Kegiatan</label>
                    <input type="date" name="tanggal_kegiatan" class="form-control" value="<?= htmlspecialchars($surat['tanggal_kegiatan'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Tanggal Akhir Kegiatan</label>
                    <input type="date" name="akhir_kegiatan" class="form-control" value="<?= htmlspecialchars($surat['akhir_kegiatan'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Periode Penugasan</label>
                    <input type="date" name="periode_penugasan" class="form-control" value="<?= htmlspecialchars($surat['periode_penugasan'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Akhir Periode Penugasan</label>
                    <input type="date" name="akhir_periode_penugasan" class="form-control" value="<?= htmlspecialchars($surat['akhir_periode_penugasan'] ?? ''); ?>">
                </div>
            </div>
            
            <div id="periode_date" style="<?= (isset($surat['jenis_date']) && $surat['jenis_date']=='Periode') ? '' : 'display:none;'; ?>">
                <div class="form-group">
                    <label>Pilih Periode</label>
                    <select name="periode_value" class="form-control">
                        <?php
                        $years = ["2024/2025","2025/2026","2026/2027","2027/2028","2028/2029","2029/2030"];
                        foreach($years as $y){
                            $g = $y.' Ganjil';
                            $p = $y.' Genap';
                            echo '<option value="'.htmlspecialchars($g).'" '.((isset($surat['periode_value']) && $surat['periode_value']==$g)?'selected':'').'>'.htmlspecialchars($g).'</option>';
                            echo '<option value="'.htmlspecialchars($p).'" '.((isset($surat['periode_value']) && $surat['periode_value']==$p)?'selected':'').'>'.htmlspecialchars($p).'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label>Tempat Kegiatan</label>
                <input type="text" name="tempat_kegiatan" class="form-control" value="<?= htmlspecialchars($surat['tempat_kegiatan'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label>Penyelenggara</label>
                <input type="text" name="penyelenggara" class="form-control" value="<?= htmlspecialchars($surat['penyelenggara'] ?? ''); ?>">
            </div>
        </div>
        
        <!-- Jenis Pengajuan -->
        <div class="form-section">
            <h5><i class="fas fa-tasks"></i> Jenis Pengajuan</h5>
            <div class="form-group">
                <label>Jenis Pengajuan</label>
                <select name="jenis_pengajuan" id="jenis_pengajuan" class="form-control">
                    <option value="Perorangan" <?= (isset($surat['jenis_pengajuan']) && $surat['jenis_pengajuan']=='Perorangan') ? 'selected' : '' ?>>Perorangan</option>
                    <option value="Kelompok" <?= (isset($surat['jenis_pengajuan']) && $surat['jenis_pengajuan']=='Kelompok') ? 'selected' : '' ?>>Kelompok</option>
                </select>
            </div>
            
            <!-- Lingkup Penugasan -->
            <div class="form-group">
                <label>Lingkup Penugasan</label>
                <select name="lingkup_penugasan" class="form-control">
                    <option value="Dosen" <?= (isset($surat['lingkup_penugasan']) && $surat['lingkup_penugasan']=='Dosen') ? 'selected' : '' ?>>Dosen</option>
                    <option value="TPA" <?= (isset($surat['lingkup_penugasan']) && $surat['lingkup_penugasan']=='TPA') ? 'selected' : '' ?>>TPA</option>
                    <option value="Dosen dan TPA" <?= (isset($surat['lingkup_penugasan']) && $surat['lingkup_penugasan']=='Dosen dan TPA') ? 'selected' : '' ?>>Dosen dan TPA</option>
                </select>
            </div>
            
            <div id="perorangan_box" style="<?= (isset($surat['jenis_pengajuan']) && $surat['jenis_pengajuan']=='Perorangan') ? '' : 'display:none;'; ?>">
                <div class="form-group">
                    <label>Jenis Penugasan (Perorangan)</label>
                    <select name="jenis_penugasan_perorangan" id="jenis_penugasan_perorangan" class="form-control">
                        <?php $opsi_per=["Juri","Pembicara","Narasumber","Lainnya"];
                        foreach($opsi_per as $o) echo '<option value="'.htmlspecialchars($o).'" '.((isset($surat['jenis_penugasan_perorangan']) && $surat['jenis_penugasan_perorangan']==$o)?'selected':'').'>'.htmlspecialchars($o).'</option>'; ?>
                    </select>
                </div>
                <div class="form-group" id="lainnya_perorangan_box" style="<?= (isset($surat['jenis_penugasan_perorangan']) && $surat['jenis_penugasan_perorangan']=='Lainnya') ? '' : 'display:none;'; ?>">
                    <label>Isi Penugasan Lainnya</label>
                    <input type="text" name="penugasan_lainnya_perorangan" class="form-control" value="<?= htmlspecialchars($surat['penugasan_lainnya_perorangan'] ?? ''); ?>">
                </div>
            </div>
            
            <div id="kelompok_box" style="<?= (isset($surat['jenis_pengajuan']) && $surat['jenis_pengajuan']=='Kelompok') ? '' : 'display:none;'; ?>">
                <div class="form-group">
                    <label>Jenis Penugasan (Kelompok)</label>
                    <select name="jenis_penugasan_kelompok" id="jenis_penugasan_kelompok" class="form-control">
                        <?php $opsi_kel=["Tim","Kepanitiaan","Lainnya"];
                        foreach($opsi_kel as $o) echo '<option value="'.htmlspecialchars($o).'" '.((isset($surat['jenis_penugasan_kelompok']) && $surat['jenis_penugasan_kelompok']==$o)?'selected':'').'>'.htmlspecialchars($o).'</option>'; ?>
                    </select>
                </div>
                <div class="form-group" id="lainnya_kelompok_box" style="<?= (isset($surat['jenis_penugasan_kelompok']) && $surat['jenis_penugasan_kelompok']=='Lainnya') ? '' : 'display:none;'; ?>">
                    <label>Isi Penugasan Lainnya</label>
                    <input type="text" name="penugasan_lainnya_kelompok" class="form-control" value="<?= htmlspecialchars($surat['penugasan_lainnya_kelompok'] ?? ''); ?>">
                </div>
            </div>
        </div>
        
        <!-- Dosen Terkait -->
        <div class="form-section">
            <h5><i class="fas fa-user-tie"></i> Dosen Terkait</h5>
            <div class="table-responsive">
                <table class="table" id="dosen_table">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama Dosen</th>
                            <th>Jabatan</th>
                            <th>Divisi</th>
                            <th width="5%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($dosen_data) && is_array($dosen_data)):
                            foreach($dosen_data as $i => $dosen):
                        ?>
                        <tr class="dosen-row" data-row-index="<?= $i ?>">
                            <td>
                                <input type="text" 
                                       name="nip[]" 
                                       class="form-control nip-input" 
                                       value="<?= htmlspecialchars($dosen['nip'] ?? '') ?>" 
                                       autocomplete="off"
                                       required>
                            </td>
                            <td>
                                <input type="text" 
                                       name="nama_dosen[]"
                                       class="form-control nama-dosen-input" 
                                       value="<?= htmlspecialchars($dosen['nama_dosen'] ?? '') ?>" 
                                       autocomplete="off"
                                       required>
                            </td>
                            <td>
                                <input type="text" 
                                       name="jabatan[]"
                                       class="form-control jabatan-input" 
                                       value="<?= htmlspecialchars($dosen['jabatan'] ?? '') ?>" 
                                       autocomplete="off">
                            </td>
                            <td>
                                <input type="text" 
                                       name="divisi[]"
                                       class="form-control divisi-input" 
                                       value="<?= htmlspecialchars($dosen['divisi'] ?? '') ?>" 
                                       autocomplete="off">
                            </td>
                            <td class="text-center">
                                <span class="remove-row">
                                    <i class="fas fa-trash"></i>
                                </span>
                            </td>
                        </tr>
                        <?php
                            endforeach;
                        else:
                        ?>
                        <tr class="dosen-row" data-row-index="0">
                            <td>
                                <input type="text" name="nip[]" class="form-control nip-input" required>
                            </td>
                            <td>
                                <input type="text" name="nama_dosen[]" class="form-control nama-dosen-input" required>
                            </td>
                            <td>
                                <input type="text" name="jabatan[]" class="form-control jabatan-input">
                            </td>
                            <td>
                                <input type="text" name="divisi[]" class="form-control divisi-input">
                            </td>
                            <td class="text-center">
                                <span class="remove-row">
                                    <i class="fas fa-trash"></i>
                                </span>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <button type="button" id="addRow" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Dosen
            </button>
        </div>
        
        <!-- File Eviden -->
        <div class="form-section">
            <h5><i class="fas fa-file-alt"></i> File Eviden</h5>
            
            <div class="mb-4">
                <label class="font-weight-bold mb-3">File yang Sudah Diupload:</label>
                <div id="existingFilesContainer">
                    <?php
                    if (!empty($eviden) && is_array($eviden) && count($eviden) > 0):
                        foreach($eviden as $idx => $fileRaw):
                            if (empty($fileRaw)) continue;
                            
                            $file = $fileRaw;
                            if (is_array($fileRaw)) {
                                $candidates = ['file','filename','nama','nama_file','name',0];
                                $file = null;
                                foreach ($candidates as $k) {
                                    if (isset($fileRaw[$k]) && is_string($fileRaw[$k]) && trim($fileRaw[$k]) !== '') {
                                        $file = $fileRaw[$k];
                                        break;
                                    }
                                }
                                if ($file === null) {
                                    foreach ($fileRaw as $v) {
                                        if (is_string($v) && trim($v) !== '') { $file = $v; break; }
                                    }
                                }
                            }
                            
                            if (!is_string($file) || trim($file) === '') continue;
                            $file = trim($file);
                            
                            $is_external = filter_var($file, FILTER_VALIDATE_URL) ? true : false;
                            $contains_uploads = (strpos($file, 'uploads/') !== false) || (strpos($file, '/uploads/') !== false);
                            
                            if ($is_external) {
                                $label = basename($file);
                                $view_link = $file;
                            } else {
                                if ($contains_uploads) {
                                    $clean_path = ltrim($file, '/');
                                    $label = basename($clean_path);
                                    $view_link = base_url($clean_path);
                                } else {
                                    $label = basename($file);
                                    $view_link = base_url('uploads/eviden/' . $file);
                                }
                            }
                            
                            $ext = strtolower(pathinfo($label, PATHINFO_EXTENSION) ?: '');
                            $icon = 'fa-file';
                            if (in_array($ext, ['jpg','jpeg','png','gif','bmp','webp'])) $icon = 'fa-file-image';
                            elseif ($ext == 'pdf') $icon = 'fa-file-pdf';
                            elseif (in_array($ext, ['doc','docx'])) $icon = 'fa-file-word';
                            elseif (in_array($ext, ['xls','xlsx'])) $icon = 'fa-file-excel';
                            
                            $filesize = 'N/A';
                            if (!$is_external) {
                                $filepath = './uploads/eviden/' . $file;
                                if (file_exists($filepath)) {
                                    $filesize = round(filesize($filepath) / 1048576, 2) . ' MB';
                                } else {
                                    $filesize = 'N/A';
                                }
                            } else {
                                $filesize = 'External';
                            }
                    ?>
                    <div class="existing-file-item" data-file-index="<?= htmlspecialchars($idx) ?>" data-filename="<?= htmlspecialchars($file) ?>">
                        <div class="file-icon">
                            <i class="fas <?= htmlspecialchars($icon) ?>"></i>
                        </div>
                        <div class="file-info">
                            <div class="file-name" title="<?= htmlspecialchars($file) ?>"><?= htmlspecialchars($label) ?></div>
                            <div class="file-size"><?= htmlspecialchars($filesize) ?></div>
                        </div>
                        <div class="file-actions">
                            <button type="button" class="btn-view-file" data-src="<?= htmlspecialchars($view_link) ?>" data-type="<?= htmlspecialchars($ext) ?>">
                                <i class="fas fa-eye"></i> Lihat
                            </button>
                            <button type="button" class="btn-delete-existing" onclick="deleteExistingFile(<?= htmlspecialchars($idx) ?>,'<?= htmlspecialchars($file, ENT_QUOTES) ?>')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                        
                        <input type="hidden" name="existing_eviden[]" value="<?= htmlspecialchars($file) ?>" class="existing-file-input">
                        <input type="hidden" name="delete_eviden[]" value="" class="delete-flag">
                    </div>
                    <?php
                        endforeach;
                    else:
                    ?>
                    <div class="existing-file-item">
                        <div class="file-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="file-info">
                            <div class="file-name">Belum ada file eviden yang diupload</div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Upload File Baru -->
            <div class="mb-4">
                <label class="font-weight-bold mb-3">Upload File Baru (Opsional):</label>
                <div id="newEvidenContainer">
                    <div class="upload-item-wrapper" data-index="0">
                        <input type="file" name="new_eviden[]" class="form-control eviden-input" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">
                        <button type="button" class="btn-icon-action btn-add-file" title="Tambah File">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <span id="chk-error"></span>
                <small class="form-text text-muted"><i class="fas fa-info-circle"></i> Tipe file: JPG, PNG, PDF, DOC, XLS. Maks 10MB per file</small>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="form-section">
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="<?= base_url('sekretariat') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </form>
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

<script>
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

// ===== EXISTING FUNCTIONS =====
function deleteExistingFile(index, filename) {
    if (!confirm('Yakin ingin menghapus file "'+filename+'"?')) return;
    const fileItem = document.querySelector(`.existing-file-item[data-file-index="${index}"]`);
    if (!fileItem) return;
    const deleteFlag = fileItem.querySelector('.delete-flag');
    const existingInput = fileItem.querySelector('.existing-file-input');
    if (deleteFlag) deleteFlag.value = filename;
    if (existingInput) existingInput.remove();
    fileItem.classList.add('file-deleted');
    fileItem.style.opacity = '0';
    fileItem.style.transform = 'translateX(-20px)';
    setTimeout(()=>fileItem.style.display='none', 300);
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
            <a href="${fileUrl}" class="btn btn-primary" download="${fileName}" target="_blank" style="margin-top: 15px;">
                <i class="fas fa-download"></i> Download File
            </a>
        </div>
    `;
}

function closePreviewModal() {
    document.getElementById('previewModal').classList.remove('show');
}

// Helper function
function escapeHtml(unsafe) {
    if (unsafe === null || unsafe === undefined) return '-';
    return String(unsafe)
       .replace(/&/g, "&amp;")
       .replace(/</g, "&lt;")
       .replace(/>/g, "&gt;")
       .replace(/"/g, "&quot;")
       .replace(/'/g, "&#039;");
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize autocomplete for existing rows
    document.querySelectorAll('.dosen-row').forEach(row => {
        initAutocompleteForRow(row);
    });

    // Toggle sections based on selections
    document.getElementById('jenis_date').addEventListener('change', function() { 
        document.getElementById('custom_date').style.display = this.value === 'Custom' ? 'block' : 'none';
        document.getElementById('periode_date').style.display = this.value === 'Periode' ? 'block' : 'none';
    });
    
    document.getElementById('jenis_pengajuan').addEventListener('change', function() { 
        document.getElementById('perorangan_box').style.display = this.value === 'Perorangan' ? 'block' : 'none';
        document.getElementById('kelompok_box').style.display = this.value === 'Kelompok' ? 'block' : 'none';
    });
    
    if (document.getElementById('jenis_penugasan_perorangan')) {
        document.getElementById('jenis_penugasan_perorangan').addEventListener('change', function() { 
            document.getElementById('lainnya_perorangan_box').style.display = this.value === 'Lainnya' ? 'block' : 'none';
        });
    }
    
    if (document.getElementById('jenis_penugasan_kelompok')) {
        document.getElementById('jenis_penugasan_kelompok').addEventListener('change', function() { 
            document.getElementById('lainnya_kelompok_box').style.display = this.value === 'Lainnya' ? 'block' : 'none';
        });
    }

    // Add new dosen row with autocomplete
    document.getElementById('addRow').addEventListener('click', function() {
        const rowIndex = document.querySelectorAll('#dosen_table tbody tr').length;
        const newRow = document.createElement('tr');
        newRow.className = 'dosen-row';
        newRow.dataset.rowIndex = rowIndex;
        newRow.innerHTML = `
            <td>
                <input type="text" name="nip[]" class="form-control nip-input" required>
            </td>
            <td>
                <input type="text" name="nama_dosen[]" class="form-control nama-dosen-input" required>
            </td>
            <td>
                <input type="text" name="jabatan[]" class="form-control jabatan-input">
            </td>
            <td>
                <input type="text" name="divisi[]" class="form-control divisi-input">
            </td>
            <td class="text-center">
                <span class="remove-row">
                    <i class="fas fa-trash"></i>
                </span>
            </td>
        `;
        
        document.querySelector('#dosen_table tbody').appendChild(newRow);
        
        setTimeout(() => { 
            newRow.style.opacity = '1';
            newRow.style.transform = 'translateY(0)';
            newRow.style.transition = 'all 0.3s ease';
            // Initialize autocomplete for the new row
            initAutocompleteForRow(newRow);
        }, 10);
    });

    // Remove row
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            const row = e.target.closest('tr');
            row.style.opacity = '0';
            row.style.transform = 'translateX(20px)';
            setTimeout(() => row.remove(), 300);
        }
    });

    // File upload handlers
    let evidenIndex = 0;
    document.getElementById('newEvidenContainer').addEventListener('click', function(e) {
        if (e.target.closest('.btn-add-file')) {
            evidenIndex++;
            const newItem = document.createElement('div');
            newItem.className = 'upload-item-wrapper';
            newItem.dataset.index = evidenIndex;
            newItem.innerHTML = `<input type="file" name="new_eviden[]" class="form-control eviden-input" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">
                <button type="button" class="btn-icon-action btn-remove-file" title="Hapus File">
                    <i class="fas fa-trash"></i>
                </button>`;
            this.appendChild(newItem);
        }
        
        if (e.target.closest('.btn-remove-file')) {
            e.target.closest('.upload-item-wrapper').remove();
        }
    });

    document.getElementById('newEvidenContainer').addEventListener('change', function(e) {
        if (e.target.classList.contains('eviden-input')) {
            const file = e.target.files[0];
            const errorSpan = document.getElementById('chk-error');
            if (file) {
                const sizeMB = (file.size / 1024 / 1024);
                if (sizeMB > 10) { 
                    errorSpan.textContent = '⚠️ File terlalu besar! Maks 10MB'; 
                    e.target.value = ''; 
                    return; 
                }
                const allowed = [
                    'image/jpeg','image/jpg','image/png','image/gif',
                    'application/pdf',
                    'application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ];
                if (!allowed.includes(file.type)) { 
                    errorSpan.textContent = '⚠️ Tipe file tidak diizinkan!'; 
                    e.target.value = ''; 
                    return; 
                }
                errorSpan.style.color = '#28a745'; 
                errorSpan.textContent = `✓ File "${file.name}" siap diupload (${sizeMB.toFixed(2)} MB)`;
                setTimeout(()=>{ 
                    errorSpan.textContent = ''; 
                    errorSpan.style.color='#dc3545'; 
                }, 3000);
            }
        }
    });

    // Preview file handlers
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-view-file')) {
            const btn = e.target.closest('.btn-view-file');
            const src = btn.dataset.src || '';
            const fileType = btn.dataset.type || '';
            const fileName = btn.closest('.existing-file-item').querySelector('.file-name').textContent.trim() || 'file';
            
            if (!src) { 
                alert('File tidak ditemukan');
                return; 
            }

            let finalSrc = src;
            if (!/^https?:\/\//i.test(src)) {
                finalSrc = BASE_URL + '/' + src.replace(/^\/+/, '');
            }
            
            previewFile(finalSrc, fileName);
        }
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