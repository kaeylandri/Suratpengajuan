<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Penugasan Banyak Panitia</title>

    <style>
        @page {
            margin: 80px 80px 120px 80px;
        }
        
        /* === GLOBAL FONT: CALIBRI === */
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

        h5 {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .surat-title {
            text-align: center;
            text-transform: uppercase;
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 2px;
            text-decoration: underline; 
            text-underline-offset: 4px;
        }
        
        .surat-number {
            text-align: center;
            font-size: 13px;
            margin-top: -2px;
            margin-bottom: 25px;
        }

        /* Paragraf styling - TANPA INDENT */
        .content p {
            margin-bottom: 10px;
            text-align: justify;
            text-indent: 0;
        }

        p, th, td, b {
            font-family: Calibri, Arial, sans-serif;
        }
        
        /* List dengan indent khusus */
        .list-item {
            margin-bottom: 8px;
            text-indent: -15px;
            padding-left: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px 10px;
        }

        th {
            background: #f0f0f0;
        }

        .section-title {
            margin: 15px 0 10px 0;
            font-weight: normal;
        }

        .qr-centered {
            width: 90px;
            margin-bottom: 6px;
        }

        /* QR Code selalu menyatu dengan tanda tangan */
        .qr-box {
            position: absolute;
            right: 0;
            top: 0;
            width: 100px;
            page-break-inside: avoid;
        }

        img.qr-img {
            width: 140px;
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

        .qr-bottom-box {
            margin-top: 5px;
        }

        .qr-bottom {
            width: 90px;
            margin-bottom: 6px;
        }

        .signature-bottom-text {
            margin-top: 5px;
            font-weight: bold;
            text-decoration: underline;
            line-height: 1;
            margin-bottom: 2px;   
        }
        
        .signature-position {
            margin-top: 2px;
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
        <div class="surat-title">SURAT TUGAS</div>
        <div class="surat-number">Nomor : <?= $surat->nomor_surat ?? '-' ?></div>

        <p>
            Pada hari Jumat tanggal 17 bulan Oktober tahun 2025 bertempat di Fakultas Industri Kreatif
            (FIK) Universitas Telkom, dengan mempertimbangkan hal-hal sebagai berikut :
        </p>

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

        <p class="section-title">Menugaskan kepada Dosen dan TPA yang tercantum dalam lampiran surat tugas ini, sebagai <b><?= $surat->jenis_penugasan_kelompok ?? '-' ?></b> di kegiatan <b><?= $surat->nama_kegiatan ?? '-' ?></b></p>

        <p>Surat tugas ini berlaku mulai tanggal sesuai tanggal kegiatan.</p>
        <p>Demikian penugasan ini untuk dilaksanakan dengan penuh tanggung jawab.</p>

        <p class="date">Bandung, 17 Oktober 2025</p>

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
            1. Wakil Dekan Bidang Akaademik dan Dukungan Peneliltian FIK<br>
            2. Wakil Dekan Bidang Keuangan dan Sumber Daya dan Kemahasiswaan FIK<br>
            3. Kaprodi S1 Desain Produk
        </p>
        
        <p><b>Lampiran Surat Tugas Nomor <?= $surat->nomor_surat ?? '-' ?></b></p>
    </div>

    <!-- PAGE BREAK untuk halaman lampiran -->
    <div style="page-break-before: always;"></div>

    <!-- LAMPIRAN TABEL -->
    <div class="content">
        <h5><b><?= $surat->jenis_penugasan_kelompok ?? '-' ?> kegiatan <?= $surat->nama_kegiatan ?? '-' ?></b></h5>
        
        <table>
            <thead>
                <tr>
                    <th style="width:40px;">No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Divisi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($surat->dosen_data)): ?>
                    <?php foreach ($surat->dosen_data as $i => $d): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($d['nip']) ?></td>
                        <td><?= htmlspecialchars($d['nama']) ?></td>
                        <td><?= htmlspecialchars($d['jabatan']) ?></td>
                        <td><?= htmlspecialchars($d['divisi']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">Tidak ada data dosen</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <p class="date">Bandung, <?= tgl_indo($surat->created_at ?? date('Y-m-d')) ?></p>

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
    </div>
</body>
</html>