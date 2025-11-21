<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Validasi Surat</title>
<style>
    body {
        font-family: Arial, sans-serif;
        padding: 30px;
    }
    .card {
        max-width: 600px;
        margin: auto;
        border: 1px solid #ccc;
        padding: 25px;
        border-radius: 8px;
    }
    h2 { text-align: center; margin-bottom: 20px; }
    .notfound { text-align:center; color:red; }
</style>
</head>
<body>

<div class="card">

<?php if (!$found): ?>
    <h2>Validasi Dokumen</h2>
    <p class="notfound"><b>❌ Dokumen tidak ditemukan atau tidak valid.</b></p>

<?php else: ?>

    <h2>Regulation Validation</h2>

    <p><b>Nama RegulasI :</b> Surat Tugas</p>
    <p><b>Nomor Dokumen :</b> <?= $surat->nomor_surat ?></p>
    <p><b>Tanggal :</b> <?= $surat->tanggal_kegiatan ?></p>

    <p><b>Penandatangan :</b><br>
       Dandi Yunidar, S.Sn., M.Ds., Ph.D.<br>
       Dekan Fakultas Industri Kreatif
    </p>

    <hr>

    <p style="text-align:center; font-size:12px; color:#666;">
        Regulation Validation ©2025<br>
        Information System Directorate<br>
        Telkom University
    </p>

<?php endif; ?>

</div>

</body>
</html>
