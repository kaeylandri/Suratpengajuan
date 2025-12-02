<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Regulation Validation</title>
<style>
    body {
        font-family: Arial, sans-serif;
        padding: 20px;
        background-color: #f5f5f5;
        margin: 0;
    }
    .card {
        max-width: 650px;
        margin: auto;
        background: white;
        border: 1px solid #ddd;
        padding: 35px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .header {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 15px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e0e0e0;
    }
    .header-logo {
        max-width: 150px;
        height: auto;
    }
    .header-title {
        font-size: 22px;
        font-weight: bold;
        color: #333;
        margin: 0;
    }
    h2 { 
        text-align: center; 
        margin-bottom: 30px;
        color: #333;
        font-size: 20px;
    }
    .notfound { 
        text-align: center; 
        color: red;
        font-size: 18px;
        padding: 20px;
    }
    .info-row {
        display: flex;
        margin-bottom: 15px;
        line-height: 1.6;
    }
    .info-label {
        min-width: 150px;
        font-weight: normal;
        color: #333;
    }
    .info-separator {
        margin: 0 10px;
    }
    .info-value {
        flex: 1;
        color: #333;
    }
    .footer-text {
        text-align: center;
        font-size: 12px;
        color: #666;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #ddd;
    }
    .section-title {
        font-weight: bold;
        margin-top: 25px;
        margin-bottom: 15px;
        color: #333;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    /* Dosen Card Styles */
    .dosen-section {
        margin-top: 25px;
        margin-bottom: 20px;
    }
    
    .dosen-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.2s ease;
    }
    
    .dosen-card:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border-color: #d0d0d0;
    }
    
    .dosen-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f39c12, #e67e22);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
        flex-shrink: 0;
    }
    
    .dosen-info {
        flex: 1;
    }
    
    .dosen-nama {
        font-weight: bold;
        color: #333;
        margin-bottom: 4px;
        font-size: 15px;
    }
    
    .dosen-detail {
        color: #666;
        font-size: 13px;
        line-height: 1.4;
    }
    
    .dosen-nip {
        color: #888;
        font-size: 12px;
    }
    
    .icon-dosen {
        font-size: 20px;
    }
    
    /* New style for dosen list like penandatangan */
    .dosen-list-item {
        margin-bottom: 10px;
    }
    
    .dosen-nama-value {
        font-weight: bold;
        margin-bottom: 2px;
    }
    
    .dosen-nip-value {
        color: #666;
        font-size: 14px;
    }
</style>
</head>
<body>

<div class="card">

<!-- HEADER -->
<div class="header">
    <?php if (!empty($logo_base64)): ?>
        <img src="data:image/jpeg;base64,<?= $logo_base64 ?>" class="header-logo" alt="Telkom University Logo">
    <?php else: ?>
        <img src="<?= base_url('assets/Tel-U_logo.png') ?>" class="header-logo" alt="Telkom University Logo">
    <?php endif; ?>
    <h1 class="header-title">Regulation Validation</h1>
</div>

<?php if (!$found): ?>
    <p class="notfound"><b>❌ Dokumen tidak ditemukan atau tidak valid.</b></p>

<?php else: ?>

    <div class="info-row">
        <span class="info-label">Nama Regulasi</span>
        <span class="info-separator">:</span>
        <span class="info-value">KEPUTUSAN DEKAN FAKULTAS INDUSTRI KREATIF UNIVERSITAS TELKOM</span>
    </div>

    <div class="info-row">
        <span class="info-label">Nomor Dokumen</span>
        <span class="info-separator">:</span>
        <span class="info-value"><?= ($surat->nomor_surat) ?></span>
    </div>

<div class="info-row">
    <span class="info-label">Tanggal Pengesahan</span>
    <span class="info-separator">:</span>
    <span class="info-value">
        <?php
        // Default tanggal
        $tanggalPengesahan = $surat->created_at ?? date('Y-m-d');
        
        // Jika approval_status berisi data mentah seperti contoh
        if (!empty($surat->approval_status)) {
            // Cari pattern tanggal (YYYY-MM-DD) setelah "dekan"
            if (preg_match('/dekan["\']?\s*:\s*["\']?(\d{4}-\d{2}-\d{2})/', $surat->approval_status, $matches)) {
                $tanggalPengesahan = $matches[1];
            }
        }
        
        // Format tanggal
        $timestamp = strtotime($tanggalPengesahan);
        $bulan = [
            1 => 'JANUARI', 2 => 'FEBRUARI', 3 => 'MARET', 4 => 'APRIL',
            5 => 'MEI', 6 => 'JUNI', 7 => 'JULI', 8 => 'AGUSTUS',
            9 => 'SEPTEMBER', 10 => 'OKTOBER', 11 => 'NOVEMBER', 12 => 'DESEMBER'
        ];
        echo date('d', $timestamp) . ' ' . $bulan[(int)date('n', $timestamp)] . ' ' . date('Y', $timestamp);
        ?>
    </span>
</div>

    <?php if ($surat->jenis_date === 'custom'): ?>
    <div class="info-row">
        <span class="info-label">Tanggal Kegiatan</span>
        <span class="info-separator">:</span>
        <span class="info-value">
            <?php
            $timestamp = strtotime($surat->tanggal_kegiatan);
            echo date('d', $timestamp) . ' ' . $bulan[(int)date('n', $timestamp)] . ' ' . date('Y', $timestamp);
            ?>
        </span>
    </div>
    <?php else: ?>
    <div class="info-row">
        <span class="info-label">Periode Kegiatan</span>
        <span class="info-separator">:</span>
        <span class="info-value"><?= ($surat->periode_value ?? '-') ?></span>
    </div>
    <?php endif; ?>

    <div class="info-row">
        <span class="info-label">Perihal</span>
        <span class="info-separator">:</span>
        <span class="info-value"><?= ($surat->nama_kegiatan) ?></span>
    </div>

    <!-- DOSEN TERKAIT SECTION (UPDATED FORMAT) -->
    <?php if (!empty($dosen_list) && count($dosen_list) > 0): ?>
    <div class="info-row">
        <span class="info-label">Dosen Terkait</span>
        <span class="info-separator">:</span>
        <span class="info-value">
            <?php foreach ($dosen_list as $index => $dosen): ?>
            <div class="dosen-list-item">
                <div class="dosen-nama-value"><?= ($dosen['nama_dosen']) ?></div>
                <div class="dosen-nip-value">NIP: <?= ($dosen['nip']) ?></div>
            </div>
            <?php endforeach; ?>
        </span>
    </div>
    <?php endif; ?>

    <!-- Penandatangan Section -->
    <div class="info-row">
        <span class="info-label">Penandatangan</span>
        <span class="info-separator">:</span>
        <span class="info-value">
            Dandi Yunidar, S.Sn., M.Ds., Ph.D<br>
            (DEKAN FAKULTAS INDUSTRI KREATIF (FIK))
        </span>
    </div>

    <!-- Pekerjaan Section -->
    <div class="info-row">
        <span class="info-label">Pekerjaan</span>
        <span class="info-separator">:</span>
        <span class="info-value">URUSAN AKADEMIK (FIK)</span>
    </div>

    <div class="footer-text">
        Regulation Validation ©<?= date('Y') ?><br>
        School Of Creative Industries<br>
        Telkom University
    </div>

<?php endif; ?>

</div>

</body>
</html>