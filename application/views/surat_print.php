<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Penugasan</title>

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
            top: -100px;
            left: 0;
            right: 0;
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
    left: -80px;  /* Disesuaikan dengan margin left @page */
    right: -80px; /* Disesuaikan dengan margin right @page */
    bottom: -120px;
    height: 180px;
    width: calc(100% + 160px); /* 80px kiri + 80px kanan = 160px */
}

            /* Footer Text - Info Kampus */
            .footer-info {
                position: absolute;
                bottom: 80px;
                left: 40px;
                right: 40px;
                font-size: 8px;
                line-height: 1.4;
                text-align: center;
                color: #333;
                font-family: Arial, sans-serif;
            }

        .footer-info strong {
            font-weight: bold;
        }

        .footer-info .campus-name {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .footer-website {
            font-weight: bold;
            font-size: 9px;
            margin-top: 5px;
            color: #000;
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
        }

        /* Footer Wave Background */
        .footer-wave {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 65px;
        object-fit: fill;
    }

        /* === CONTENT === */
        .content {
            margin: 0;
            position: relative;
            z-index: 1;
        }

        /* Judul Surat */
        .surat-title {
            text-align: center;
            text-transform: uppercase;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
            letter-spacing: 2px;
        }

        .surat-number {
            text-align: center;
            font-size: 12px;
            margin-bottom: 25px;
        }

        /* Paragraf styling - TANPA INDENT */
        .content p {
            margin-bottom: 10px;
            text-align: justify;
            text-indent: 0;
        }

        /* List dengan indent khusus */
        .list-item {
            margin-left: 20px;
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

        /* Tabel styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 11px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background: #ffffff;
            font-weight: bold;
            text-align: center;
        }

        td {
            text-align: left;
        }

        .table-number {
            width: 35px;
            text-align: center !important;
        }

        .table-nip {
            width: 90px;
        }

        .table-prodi {
            width: 80px;
        }

        /* Section title */
        .section-title {
            margin: 15px 0 10px 0;
            font-weight: normal;
        }

        /* Tanda tangan */
        .signature-section {
            margin-top: 40px;
            position: relative;
        }

        .signature-text {
            text-align: left;
            line-height: 1.6;
        }

        .signature-name {
            text-decoration: underline;
            font-weight: bold;
        }

        .qr-box {
            position: absolute;
            right: 0;
            top: 0;
            width: 100px;
        }

        img.qr-img {
            width: 100px;
            height: auto;
        }

        b {
            font-weight: bold;
        }

        .date {
            margin-top: 20px;
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
?>

<body>
    <!-- HEADER -->
    <div class="header">
        <?php if (!empty($logo_base64)): ?>
            <img src="data:image/jpeg;base64,<?= $logo_base64 ?>" class="header-logo" alt="Telkom University Logo">
        <?php else: ?>
            <img src="<?= base_url('assets/Tel-U_logo.jpg') ?>" class="header-logo" alt="Telkom University Logo">
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
    <div class="content">
        <!-- Judul Surat -->
        <div class="surat-title">SURAT TUGAS</div>
        <div class="surat-number">Nomor : <?= $surat->nomor_surat ?? '-' ?></div>

        <!-- Pembukaan -->
        <p>
            Pada hari <b>Jumat</b> tanggal <b>17</b> bulan <b>Oktober</b> tahun <b>2025</b> 
            bertempat di <b>Fakultas Industri Kreatif (FIK) Universitas Telkom</b>, dengan 
            mempertimbangkan hal-hal sebagai berikut :
        </p>

        <!-- Poin Pertimbangan -->
        <p class="list-item">a)&nbsp;&nbsp;Tri dharma Perguruan Tinggi meliputi Pendidikan, Penelitian, Pengabdian Masyarakat wajib dilakukan oleh setiap dosen;</p>
        <p class="list-item">b)&nbsp;&nbsp;Permohonan Surat Tugas dari Wakil Dekan Bidang Akademik dan Dukungan Penelitian FIK melalui NDE nomor <b>ND.22127/UM04/YPT-TUN/2025</b> tanggal <b><?= tgl_indo($surat->created_at ?? '-') ?></b>.</p>

        <!-- Penandatangan -->
        <p>Saya yang bertanda tangan di bawah ini :</p>
        
        <div class="identity">
            <div class="identity-row">
                <div class="identity-label">Nama</div>
                <div class="identity-separator">:</div>
                <div class="identity-value"><b>Dandi Yunidar, S.Sn., M.Ds., Ph.D.</b></div>
            </div>
            <div class="identity-row">
                <div class="identity-label">NIP</div>
                <div class="identity-separator">:</div>
                <div class="identity-value"><b>14760039</b></div>
            </div>
            <div class="identity-row">
                <div class="identity-label">Jabatan</div>
                <div class="identity-separator">:</div>
                <div class="identity-value"><b>Dekan Fakultas Industri Kreatif</b></div>
            </div>
        </div>

        <!-- Menugaskan Kepada -->
        <p class="section-title">Menugaskan kepada :</p>

        <table>
            <thead>
                <tr>
                    <th class="table-number">No</th>
                    <th>Nama</th>
                    <th class="table-nip">NIP</th>
                    <th class="table-prodi">Prodi/Unit</th>
                    <th>Sebagai</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($surat->dosen_data)): ?>
                    <?php foreach ($surat->dosen_data as $i => $d): ?>
                    <tr>
                        <td class="table-number"><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($d['nama'] ?? '-') ?></td>
                        <td class="table-nip"><?= htmlspecialchars($d['nip'] ?? '-') ?></td>
                        <td class="table-prodi"><?= htmlspecialchars($d['divisi'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($d['jabatan'] ?? '-') ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">Tidak ada data dosen</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Untuk Menghadiri Kegiatan -->
        <p>
            sebagai <b>menghadiri</b> dalam kegiatan <b><?= $surat->nama_kegiatan ?? '-' ?></b> 
            yang diselenggarakan oleh <b><?= $surat->penyelenggara ?? '-' ?></b> 
            pada tanggal <b><?= tgl_indo($surat->tanggal_kegiatan ?? '-') ?></b> 
            di <b><?= $surat->tempat_kegiatan ?? '-' ?></b>.
        </p>

        <p>Surat tugas ini berlaku sesuai tanggal kegiatan di atas.</p>

        <!-- Penutup -->
        <p>Demikian penugasan ini untuk dilaksanakan dengan penuh tanggung jawab.</p>

        <!-- Tanggal -->
        <p class="date">Bandung, 17 Oktober 2025</p><br>

        <!-- SIGNATURE + QR -->
        <div class="signature-section">
            <?php if (!empty($qr_base64)): ?>
            <div class="qr-box">
                <img class="qr-img" src="data:image/png;base64,<?= $qr_base64 ?>" alt="QR Code">
            </div>
            <?php endif; ?>

            <div class="signature-text">
                <span class="signature-name">Dandi Yunidar, S.Sn., M.Ds., Ph.D.</span><br>
                <b>Dekan Fakultas Industri Kreatif</b>
            </div>
        </div>
    </div>
</body>
</html>