<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Penugasan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            font-size: 14px;
            line-height: 1.6;
        }

        h3 {
            text-align: center;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        
        h6 {
            text-align: center;
            margin-top: 0;
        }

        p {
            margin: 8px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }

        .section-title {
            margin-top: 20px;
            font-weight: bold;
        }
        
        .qr-wrapper {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
            margin-left: 500px;
        }
        
        .no-break {
            page-break-inside: avoid;
        }
        
        .signature-area {
            margin-top: 80px;
        }
    </style>
</head>

<body onload="window.print()">

    <h3 class="title">SURAT TUGAS</h3>
    <h6 class="subtitle">Nomor : <?= isset($surat->nomor_surat) ? $surat->nomor_surat : '-' ?></h6>

    <p>
        Pada hari Jumat tanggal 17 bulan Oktober tahun 2025 bertempat di Fakultas Industri Kreatif
        (FIK) Universitas Telkom, dengan mempertimbangkan hal-hal sebagai berikut :
    </p>

    <p>a) Tri dharma Perguruan Tinggi meliputi Pendidikan, Penelitian, Pengabdian Masyarakat wajib dilakukan oleh setiap dosen;</p>
    <p>b) Permohonan Surat Tugas dari Wakil Dekan Bidang Akademik dan Dukungan Penelitian FIK melalui NDE nomor ND.22127/UM04/YPT-TUN/2025 tanggal 13 Oktober 2025.</p>

    <br>

    <p>
        Saya yang bertanda tangan di bawah ini:<br>
        Nama&nbsp;&nbsp;&nbsp;&nbsp;: Dandi Yunidar, S.Sn., M.Ds., Ph.D.<br>
        NIP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 14760039<br>
        Jabatan&nbsp;: Dekan Fakultas Industri Kreatif
    </p>

    <p class="section-title">Menugaskan kepada:</p>

    <?php  
    // Pastikan variabel ada sebelum mengakses
    $nama_dosen = isset($surat->nama_dosen) ? $surat->nama_dosen : [];
    $nip = isset($surat->nip) ? $surat->nip : [];
    $divisi = isset($surat->divisi) ? $surat->divisi : [];
    ?>

    <table>
        <thead>
            <tr>
                <th style="width:40px;">No</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Prodi/Unit</th>
            </tr>
        </thead>
        <tbody>
            <?php if (is_array($nama_dosen) && count($nama_dosen) > 0): ?>
                <?php for ($i = 0; $i < count($nama_dosen); $i++): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= isset($nama_dosen[$i]) ? htmlspecialchars($nama_dosen[$i]) : '-' ?></td>
                    <td><?= isset($nip[$i]) ? htmlspecialchars($nip[$i]) : '-' ?></td>
                    <td><?= isset($divisi[$i]) ? htmlspecialchars($divisi[$i]) : '-' ?></td>
                </tr>
                <?php endfor; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada data dosen</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p class="section-title">Untuk menghadiri kegiatan:</p>

    <p>
        <b><?= isset($surat->nama_kegiatan) ? htmlspecialchars($surat->nama_kegiatan) : 'Nama kegiatan tidak tersedia' ?></b><br>
        yang diselenggarakan oleh <b><?= isset($surat->penyelenggara) ? htmlspecialchars($surat->penyelenggara) : 'Penyelenggara tidak tersedia' ?></b><br>
        Pada tanggal <b><?= isset($surat->tanggal_kegiatan) ? htmlspecialchars($surat->tanggal_kegiatan) : 'Tanggal tidak tersedia' ?></b> sampai dengan 
        <b><?= isset($surat->akhir_kegiatan) ? htmlspecialchars($surat->akhir_kegiatan) : 'Tanggal akhir tidak tersedia' ?></b><br>
        Bertempat di <b><?= isset($surat->tempat_kegiatan) ? htmlspecialchars($surat->tempat_kegiatan) : 'Tempat tidak tersedia' ?></b>.
    </p>

    <p>Demikian penugasan ini untuk dilaksanakan dengan penuh tanggung jawab.</p>

    <br>

    <p>Bandung, 17 Oktober 2025</p>

    <div class="signature-area">
        <b>Dandi Yunidar, S.Sn., M.Ds., Ph.D.</b><br>
        Dekan Fakultas Industri Kreatif
    </div>

    <?php if (isset($qr_base64) && !empty($qr_base64)): ?>
    <div class="qr-wrapper">
        <img src="data:image/png;base64,<?= $qr_base64 ?>" width="140" alt="QR Code">
    </div>
    <?php endif; ?>

</body>
</html>