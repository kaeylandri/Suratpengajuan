<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Penugasan</title>

    <style>
        /* === GLOBAL FONT: CALIBRI === */
        body {
            font-family: Calibri, Arial, sans-serif;
            margin: 40px;
            font-size: 14px;
            line-height: 1.6;
        }

        h3 {
            text-align: center;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-family: Calibri, Arial, sans-serif;
        }

        h6 {
            text-align: center;
            margin-top: 0;
            font-family: Calibri, Arial, sans-serif;
        }

        p, th, td, b {
            font-family: Calibri, Arial, sans-serif;
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
            margin-top: 20px;
            font-weight: bold;
        }

        /* === QR & SIGNATURE GROUP === */
        .signature-section {
            margin-top: 50px;
            position: relative;
            page-break-inside: avoid;  /* QR & tanda tangan tetap 1 halaman */
        }

        /* Posisi tanda tangan */
        .signature-text {
            float: left;
            text-align: left;
            margin-top: 21px;
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

        /* Hindari QR pindah halaman */
        @media print {
            .signature-section, .qr-box {
                page-break-inside: avoid !important;
            }
        }
    </style>

</head>
<?php
function tgl_indo($tanggal) {
     $tanggal = substr($tanggal, 0, 10); 
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    $pecah = explode('-', $tanggal);

    // Format tanggal harus Y-m-d
    return $pecah[2] . ' ' . $bulan[(int)$pecah[1]] . ' ' . $pecah[0];
}
?>

<body onload="window.print()">

    <h3>SURAT TUGAS</h3>
    <h6>Nomor : <?= $surat->nomor_surat ?? '-' ?></h6>

    <p>
        Pada hari Jumat tanggal 17 bulan Oktober tahun 2025 bertempat di Fakultas Industri Kreatif
        (FIK) Universitas Telkom, dengan mempertimbangkan hal-hal sebagai berikut :
    </p>

    <p>a) Tri dharma Perguruan Tinggi meliputi Pendidikan, Penelitian, Pengabdian Masyarakat wajib dilakukan oleh setiap dosen;</p>
    <p>b) Permohonan Surat Tugas dari Wakil Dekan Bidang Akademik dan Dukungan Penelitian FIK melalui NDE nomor ND.22127/UM04/YPT-TUN/2025 Tanggal <b><?= tgl_indo($surat->created_at ?? '-') ?></b> </p>


    <p>
        Saya yang bertanda tangan di bawah ini:<br>
        Nama&nbsp;&nbsp;&nbsp;&nbsp;: Dandi Yunidar, S.Sn., M.Ds., Ph.D.<br>
        NIP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 14760039<br>
        Jabatan&nbsp;: Dekan Fakultas Industri Kreatif
    </p>

    <p class="section-title">Menugaskan kepada Dosen dan TPA yang tercantum dalam lampiran surat tugas ini, sebagai <?= $surat->jenis_penugasan_kelompok ?? '-' ?></p>
    
<br>
    <p>Demikian penugasan ini untuk dilaksanakan dengan penuh tanggung jawab.</p>


    <p>Bandung, 17 Oktober 2025</p>

    <!-- ==============================
         SIGNATURE + QR SAMA HALAMAN
    =============================== -->
    <div class="signature-section">

        <?php if (!empty($qr_base64)): ?>
        <div class="qr-box">
            <img class="qr-img" src="data:image/png;base64,<?= $qr_base64 ?>" alt="QR Code">
        </div>
        <?php endif; ?>

        <div class="signature-text">
            <b>Dandi Yunidar, S.Sn., M.Ds., Ph.D.</b><br>
            Dekan Fakultas Industri Kreatif
        </div>
    </div>
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
</body>
</html>
