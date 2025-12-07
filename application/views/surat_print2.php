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

        /* Judul Surat */
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
    <br><br>
    <!-- CONTENT -->
    <div class="content">
        <!-- Judul Surat -->
        <div class="surat-title">SURAT TUGAS</div>
        <div class="surat-number">Nomor : <?= $surat->nomor_surat ?? '-' ?></div>

    
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

        <!-- Menugaskan Kepada -->
        <p class="section-title">Menugaskan kepada :</p>

        <!-- Tabel Dosen dari list_dosen -->
        <table class="tabel-dosen">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                    <th>Prodi/Unit</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($dosen_data)): ?>
                    <?php $no = 1; foreach ($dosen_data as $dosen): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($dosen['nama'] ?? 'Tidak ada data dosen') ?></td>
                            <td><?= htmlspecialchars($dosen['nip'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($dosen['jabatan'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($dosen['divisi'] ?? '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Tidak ada data dosen</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Untuk Menghadiri Kegiatan -->
<p>
    sebagai <b><?= $surat->jenis_penugasan_kelompok ??  '-' ?></b> dalam kegiatan <b><?= $surat->nama_kegiatan ?? '-' ?></b> 
    yang diselenggarakan oleh <b><?= $surat->penyelenggara ?? '-' ?></b> 
    <?php if (isset($surat->jenis_date) && $surat->jenis_date == 'custom'): ?>
        pada tanggal <b><?= tgl_indo($surat->tanggal_kegiatan ?? '-') ?></b> 
        <?php if (!empty($surat->akhir_kegiatan) && $surat->akhir_kegiatan != $surat->tanggal_kegiatan): ?>
            sampai dengan <b><?= tgl_indo($surat->akhir_kegiatan ?? '-') ?></b>
        <?php endif; ?>
    <?php else: ?>
        selama <b>Periode <?= $surat->periode_value ?? '-' ?></b>
    <?php endif; ?>
    di <b><?= $surat->tempat_kegiatan ?? '-' ?></b>.
</p>
        <p>Surat tugas ini berlaku sesuai tanggal kegiatan di atas.</p>

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
        ?></p><br><br><br>

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