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
        h4{
            text-align: center;
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
    </style>
</head>

<body onload="window.print()">

<h3 class="title">SURAT TUGAS</h3>
    <h4 class="subtitle">Nomor : 611/SKRO3/IK-DEK/2025</h4>

    <p>
        Pada hari Jumat tanggal 17 bulan Oktober tahun 2025 bertempat di Fakultas Industri Kreatif
        (FIK) Universitas Telkom, dengan mempertimbangkan hal-hal sebagai berikut :
    </p>

    <p>a) Tri dharma Perguruan Tinggi meliputi Pendidikan, Penelitian, Pengabdian Masyarakat wajib dilakukan &nbsp;&nbsp;&nbsp;&nbsp;oleh setiap dosen;</p>
    <p>b) Permohonan Surat Tugas dari Wakil Dekan Bidang Akademik dan Dukungan Penelitian FIK melalui &nbsp;&nbsp;&nbsp;&nbsp;NDE nomor ND.22127/UM04/YPT-TUN/2025 tanggal 13 Oktober 2025.</p>

    <br>

<p>
    Saya yang bertanda tangan di bawah ini:<br>
    Nama&nbsp;&nbsp;&nbsp;&nbsp;: Dandi Yunidar, S.Sn., M.Ds., Ph.D.<br>
    NIP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 14760039<br>
    Jabatan&nbsp;: Dekan Fakultas Industri Kreatif
</p>

<p class="section-title">Menugaskan kepada:</p>

<?php  
$nama_dosen = $surat->nama_dosen;
$nip        = $surat->nip;
$divisi     = $surat->divisi;
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
        <?php for ($i = 0; $i < count($nama_dosen); $i++): ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= $nama_dosen[$i] ?></td>
            <td><?= $nip[$i] ?></td>
            <td><?= $divisi[$i] ?></td>
        </tr>
        <?php endfor; ?>
    </tbody>
</table>



<p>
    Untuk menghadiri kegiatan <b><?= $surat->nama_kegiatan ?></b>
    yang diselenggarakan oleh <b><?= $surat->penyelenggara ?></b> 
    Pada tanggal <b><?= $surat->tanggal_kegiatan ?></b> sampai dengan 
    <b><?= $surat->akhir_kegiatan ?></b>    
    Bertempat di <b><?= $surat->tempat_kegiatan ?></b>.
</p>
<br><br>
<p>Demikian penugasan ini untuk dilaksanakan dengan penuh tanggung jawab.</p>

    

    <p>Bandung, 17 Oktober 2025</p>

    <br><br><br>

    <b>Dandi Yunidar, S.Sn., M.Ds., Ph.D.</b><br>
    Dekan Fakultas Industri Kreatif

</body>
</html>