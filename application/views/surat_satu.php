<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $surat->nama_kegiatan ?? '-' ?></title>

    <style>
        @page {
            margin: 80px 80px 120px 80px;
        }
        
        body {
            font-family: Calibri, Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            line-height: 1.5;
            color: #000;
        }

        /* === HEADER === */
        .header {
            position: fixed;
            top: -70px;
            left: 0;
            right: -90px;
            height: 100px;
            text-align: right;
            padding-right: 40px;
        }

        .header-logo {
            height: 80px;
            margin-top: 10px;
        }

        /* === FOOTER CONTAINER === */
        .footer {
            position: fixed;
            left: -80px;
            right: -80px;
            bottom: -120px;
            height: 90px;
            width: calc(100% + 160px);
        }

        /* Footer Text as Image */
        .footer-text-img {
            position: absolute;
            bottom: 52px;
            left: 50%;
            transform: translateX(-50%);
            width: auto;
            max-width: 95%;
            height: 85px;
            object-fit: contain;
            margin-bottom: -20px;
        }

        /* Footer Wave Background */
        .footer-wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 30px;
            object-fit: fill;
        }

        /* === CONTENT === */
        .content {
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .surat-title {
        text-align: center;
        text-transform: uppercase;
        font-size: 25px;        /* sedikit lebih besar */
        font-weight: bold;
        margin-bottom: 2px;     /* lebih rapat ke nomor */
        text-decoration: underline; 
        text-underline-offset: 4px;   /* jarak garis ke teks */
    }
        .surat-number {
        text-align: center;
        font-size: 13px;        /* sedikit lebih besar dari sebelumnya */
        margin-top: -2px;       /* menaikkan sedikit agar lebih dekat */
        margin-bottom: 25px;    /* jarak ke isi */
    }

        /* Paragraf styling - TANPA INDENT */
        .content p {
            margin-bottom: 10px;
            text-align: justify;
            text-indent: 0;
        }

        /* List dengan indent khusus */
        .list-item {
            margin-bottom: 8px;
            text-indent: -15px;
            padding-left: 15px;
        }

        /* Identity section */
        .identity {
            margin: 15px 0;
            line-height: 1.6;
        }

        .identity-row {
            display: table;
            width: 100%;
            margin-bottom: 3px;
        }

        .identity-label {
            display: table-cell;
            width: 100px;
        }

        .identity-separator {
            display: table-cell;
            width: 20px;
        }

        .identity-value {
            display: table-cell;
        }

        /* Section title */
        .section-title {
            margin: 15px 0 10px 0;
            font-weight: normal;
        }

        .signature-bottom-text {
        margin-top: 5px;
        font-weight: bold;
        text-decoration: underline;
        line-height: 1;      /* jarak vertikal lebih rapat */
        margin-bottom: 2px;   
        }
        .signature-position {
        margin-top: 2px;
        font-weight: bold;
    }
        .qr-centered {
            width: 90px;
            margin-bottom: 6px; /* jarak QR ke nama */
            margin-top: 20px;
        }

        .qr-box {
            position: absolute;
            right: 0;
            top: 0;
            width: 100px;
            page-break-inside: avoid;
        }
        .qr-bottom-box {
        margin-top: 5px;
        }

        .qr-bottom {
            width: 90px;   /* ukuran sama seperti QR atas */
            margin-bottom: 6px;
        }

        img.qr-img {
            width: 100px;
            height: auto;
        }

        b {
            font-weight: bold;
        }

        .date {
            margin-top: 15px;
            margin-bottom: 60px;
        }
    </style>

</head>
<?php
function tgl_indo($tanggal) {
    if(empty($tanggal) || $tanggal == '-') return '-';
    
    $tanggal = substr($tanggal, 0, 10); 
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    $pecah = explode('-', $tanggal);
    if(count($pecah) == 3) {
        return $pecah[2] . ' ' . $bulan[(int)$pecah[1]] . ' ' . $pecah[0];
    }
    return $tanggal;
}

// Function untuk format tanggal berdasarkan jenis_date
function format_tanggal_surat($surat) {
    $jenis_date = $surat->jenis_date ?? 'custom';
    
    if ($jenis_date === 'periode') {
        // Untuk periode, tampilkan periode_value
        return $surat->periode_value ?? '-';
    } else {
        // Untuk custom, tampilkan tanggal_kegiatan dan akhir_kegiatan
        $tanggal_mulai = tgl_indo($surat->tanggal_kegiatan ?? '-');
        $tanggal_akhir = tgl_indo($surat->akhir_kegiatan ?? '-');
        
        if ($tanggal_akhir && $tanggal_akhir !== '-' && $tanggal_akhir !== $tanggal_mulai) {
            return $tanggal_mulai . ' sampai dengan ' . $tanggal_akhir;
        } else {
            return $tanggal_mulai;
        }
    }
}

// Function untuk format periode penugasan
function format_periode_penugasan($surat) {
    $jenis_date = $surat->jenis_date ?? 'custom';
    
    if ($jenis_date === 'periode') {
        // Untuk periode, tampilkan periode_value
        return 'selama periode ' . ($surat->periode_value ?? '-');
    } else {
        // Untuk custom, tampilkan periode_penugasan dan akhir_periode_penugasan
        $periode_mulai = tgl_indo($surat->periode_penugasan ?? '-');
        $periode_akhir = tgl_indo($surat->akhir_periode_penugasan ?? '-');
        
        if ($periode_akhir && $periode_akhir !== '-' && $periode_akhir !== $periode_mulai) {
            return 'pada tanggal ' . $periode_mulai . ' sampai dengan ' . $periode_akhir;
        } else if ($periode_mulai && $periode_mulai !== '-') {
            return 'pada tanggal ' . $periode_mulai;
        } else {
            return 'sesuai dengan tanggal kegiatan';
        }
    }
}
?>

<body>
    <!-- HEADER -->
    <div class="header">
        <?php if (!empty($logo_base64)): ?>
            <img src="data:image/jpeg;base64,<?= $logo_base64 ?>" class="header-logo" alt="Telkom University Logo">
        <?php else: ?>
            <img src="<?= base_url('assets/Tel-U_logo.png') ?>" class="header-logo" alt="Telkom University Logo">
        <?php endif; ?>
    </div>

    <!-- FOOTER dengan Text Info -->
    <div class="footer">
        <!-- Text Info Kampus -->
        <?php if (!empty($footer_text_base64)): ?>
            <img src="data:image/png;base64,<?= $footer_text_base64 ?>" class="footer-text-img" alt="Footer Text">
        <?php else: ?>
            <img src="<?= base_url('assets/footer_text.png') ?>" class="footer-text-img" alt="Footer text">
        <?php endif; ?>
        <!-- Wave Merah -->
        <?php if (!empty($footer_bg_base64)): ?>
            <img src="data:image/jpeg;base64,<?= $footer_bg_base64 ?>" class="footer-wave" alt="Footer Wave">
        <?php else: ?>
            <img src="<?= base_url('assets/footer_asset.jpg') ?>" class="footer-wave" alt="Footer Wave">
        <?php endif; ?>
    </div>

    <!-- CONTENT -->
     <br><br><br>
    <div class="content">
        <!-- Judul Surat -->
        <div class="surat-title">SURAT TUGAS</div>
        <div class="surat-number">Nomor : <?= $surat->nomor_surat ?? '-' ?></div>

        <!-- Pembukaan -->
        <p>
            Pada tanggal <?php
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
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        echo date('d', $timestamp) . ' ' . $bulan[(int)date('n', $timestamp)] . ' ' . date('Y', $timestamp);
        ?>
            bertempat di Fakultas Industri Kreatif (FIK) Universitas Telkom, dengan 
            mempertimbangkan hal-hal sebagai berikut :
        </p>
        <!-- Penandatangan -->
        <p>Saya yang bertanda tangan di bawah ini :</p>
        
        <div class="identity">
            <div class="identity-row">
                <div class="identity-label">Nama</div>
                <div class="identity-separator">:</div>
                <div class="identity-value">Dandi Yunidar, S.Sn., M.Ds., Ph.D.</div>
            </div>
            <div class="identity-row">
                <div class="identity-label">NIP</div>
                <div class="identity-separator">:</div>
                <div class="identity-value">14760039</div>
            </div>
            <div class="identity-row">
                <div class="identity-label">Jabatan</div>
                <div class="identity-separator">:</div>
                <div class="identity-value">Dekan Fakultas Industri Kreatif</div>
            </div>
        </div>

        <!-- Menugaskan Kepada (Format Sama dengan Dekan) -->
        <p class="section-title">Menugaskan kepada :</p>

        <?php if (!empty($surat->dosen_data) && count($surat->dosen_data) > 0): ?>
            <?php $dosen = $surat->dosen_data[0]; ?>
            <div class="identity">
                <div class="identity-row">
                    <div class="identity-label">Nama</div>
                    <div class="identity-separator">:</div>
                    <div class="identity-value"><?= htmlspecialchars($dosen['nama'] ?? '-') ?></div>
                </div>
                <div class="identity-row">
                    <div class="identity-label">NIP</div>
                    <div class="identity-separator">:</div>
                    <div class="identity-value"><?= htmlspecialchars($dosen['nip'] ?? '-') ?></div>
                </div>
                <div class="identity-row">
                    <div class="identity-label">Jabatan</div>
                    <div class="identity-separator">:</div>
                    <div class="identity-value"><?= htmlspecialchars($dosen['jabatan'] ?? '-') ?></div>
                </div>
            </div>
        <?php else: ?>
            <p style="text-align:center;">Tidak ada data dosen</p>
        <?php endif; ?>

        <!-- Untuk Menghadiri Kegiatan -->
        <p>
            sebagai <b><?= $surat->jenis_penugasan_kelompok ?? 'menghadiri' ?></b> dalam kegiatan <b><?= $surat->nama_kegiatan ?? '-' ?></b> 
            yang diselenggarakan oleh <b><?= $surat->penyelenggara ?? '-' ?></b> 
            <?php if (($surat->jenis_date ?? 'custom') === 'periode'): ?>
                selama periode <b><?= $surat->periode_value ?? '-' ?></b>
            <?php else: ?>
                pada tanggal <b><?= tgl_indo($surat->tanggal_kegiatan ?? '-') ?></b> 
                <?php if (!empty($surat->akhir_kegiatan) && $surat->akhir_kegiatan !== '-'): ?>
                sampai dengan <b><?= tgl_indo($surat->akhir_kegiatan) ?></b> 
                <?php endif; ?>
            <?php endif; ?>
            di <b><?= $surat->tempat_kegiatan ?? '-' ?></b>.
        </p>

        <!-- Periode Penugasan -->
        <?php if (($surat->jenis_date ?? 'custom') === 'custom' && (!empty($surat->periode_penugasan) && $surat->periode_penugasan !== '-')): ?>
            <p>Surat tugas ini berlaku sesuai tanggal kegiatan di atas.</p>
    
        <?php else: ?>
        <p>Surat tugas ini berlaku sesuai tanggal kegiatan di atas.</p>
        <?php endif; ?>

        <!-- Penutup -->
        <p>Demikian penugasan ini untuk dilaksanakan dengan penuh tanggung jawab.</p>

        <!-- Tanggal -->
        <p class="date">Bandung, <?php
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
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        echo date('d', $timestamp) . ' ' . $bulan[(int)date('n', $timestamp)] . ' ' . date('Y', $timestamp);
        ?></p>

        <!-- SIGNATURE + QR -->
         <div class="signature-bottom">

    <?php if (!empty($qr_base64)): ?>
    <div class="qr-bottom-box">
        <img class="qr-bottom" src="data:image/png;base64,<?= $qr_base64 ?>" alt="QR Code">
    </div>
    <?php endif; ?>

    <div class="signature-bottom-text">
        <b>Dandi Yunidar, S.Sn., M.Ds., Ph.D.</b><br>
    </div>
        <div class="signature-position">Dekan Fakultas Industri Kreatif</div>
</div>
<p>
    <b>Tembusan</b><br>
1.	Wakil Dekan Bidang Akaademik dan Dukungan Peneliltian FIK<br>
2.	Wakil Dekan Bidang Keuangan dan Sumber Daya dan Kemahasiswaan FIK<br>
3.	Kaprodi S1 Desain Produk
</p>
    </div>
</body>
</html>