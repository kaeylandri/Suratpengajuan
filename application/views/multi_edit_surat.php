<?php
// Fungsi decode aman untuk menghindari error json_decode array
function safe_json($data) {
    if (is_array($data)) return $data;
    if ($data === null || $data === '' || $data === '-') return [];
    $decoded = json_decode($data, true);
    return (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : [];
}

// Pastikan $surat_list selalu terdefinisi (hindari warning)
if (!isset($surat_list) || !is_array($surat_list)) {
    $surat_list = [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi Edit Surat</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    *{margin:0;padding:0;box-sizing:border-box;}
    body{font-family:'Montserrat',sans-serif;background:#f8f9fa;padding:20px;color:#333;}
    .container-custom{max-width:1600px;margin:0 auto;}
    
    /* Header Styles */
    .header{
        background: linear-gradient(135deg, #ff8c00, #ff6b00);
        padding: 25px 30px;
        border-radius: 16px;
        margin-bottom: 25px;
        box-shadow: 0 6px 20px rgba(255, 140, 0, 0.25);
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: rgba(255,255,255,0.3);
    }
    .header h1{
        font-size: 28px;
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
        font-weight: 700;
    }
    .header .badge{
        background: rgba(255,255,255,0.25);
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        backdrop-filter: blur(5px);
    }
    
    /* Button Styles */
    .btn{
        padding: 12px 24px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        align-items: center;
    }
    .btn-primary{
        background: #ff8c00;
        color: #fff;
        box-shadow: 0 4px 12px rgba(255, 140, 0, 0.3);
    }
    .btn-primary:hover{
        background: #e67e00;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(255, 140, 0, 0.4);
    }
    .btn-secondary{
        background: #6c757d;
        color: white;
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.2);
    }
    .btn-secondary:hover{
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(108, 117, 125, 0.3);
    }
    
    /* Info Box */
    .info-box{
        background: white;
        border-left: 5px solid #ff8c00;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .info-box p{
        margin: 0;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
    .info-box i{
        color: #ff8c00;
        margin-top: 3px;
    }
    
    /* Card Styles */
    .edit-card{
        background: white;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border-left: 6px solid #ff8c00;
        position: relative;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .edit-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }
    .card-number{
        position: absolute;
        top: -12px;
        left: -12px;
        background: #ff8c00;
        color: white;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
        box-shadow: 0 4px 10px rgba(255, 140, 0, 0.4);
        z-index: 1;
    }
    
    /* Card Header */
    .card-header-custom{
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        padding-bottom: 18px;
        border-bottom: 1px solid #eee;
    }
    .card-title{
        font-size: 20px;
        font-weight: 700;
        color: #333;
        margin-bottom: 5px;
    }
    .card-subtitle{
        font-size: 14px;
        color: #666;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .item-id{
        font-size: 13px;
        color: #888;
        background: #f8f9fa;
        padding: 6px 12px;
        border-radius: 6px;
        border: 1px solid #e9ecef;
    }
    
    /* Section Titles */
    .form-section-title{
        background: linear-gradient(to right, #fff8f0, #fff4e6);
        color: #ff8c00;
        padding: 14px 18px;
        border-radius: 10px;
        font-weight: 700;
        margin: 25px 0 20px;
        border-left: 5px solid #ff8c00;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
    }
    
    /* Form Controls */
    .form-control{
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #ddd;
        transition: all 0.3s;
        font-size: 14px;
    }
    .form-control:focus{
        border-color: #ff8c00;
        box-shadow: 0 0 0 0.2rem rgba(255, 140, 0, 0.25);
    }
    label{
        font-weight: 600;
        margin-bottom: 8px;
        color: #444;
        font-size: 14px;
    }
    
    /* Table Styles */
    .table-custom{
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 0 1px #e9ecef;
    }
    .table-custom thead{
        background: linear-gradient(to right, #ff8c00, #ff6b00);
        color: white;
    }
    .table-custom th{
        padding: 15px 12px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
    }
    .table-custom td{
        padding: 12px;
        border: 1px solid #e9ecef;
        vertical-align: middle;
    }
    .table-custom tbody tr:nth-child(even){
        background-color: #f8f9fa;
    }
    .table-custom tbody tr:hover{
        background-color: #fff8f0;
    }
    
    /* Button Add Row */
    .btn-add-row{
        background: #ff8c00;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        font-weight: 600;
        margin-top: 15px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(255, 140, 0, 0.3);
    }
    .btn-add-row:hover{
        background: #e67e00;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 140, 0, 0.4);
    }
    
    /* Remove Row */
    .remove-row{
        cursor: pointer;
        color: #dc3545;
        font-weight: bold;
        font-size: 22px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }
    .remove-row:hover{
        background: #f8d7da;
        transform: scale(1.1);
    }
    
    /* Submit Section */
    .submit-section{
        background: white;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 35px;
        border-top: 4px solid #ff8c00;
    }
    .submit-info{
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        color: #28a745;
        font-size: 16px;
    }
    
    /* Date Error */
    .date-error{
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
        display: none;
        font-weight: 500;
    }
    .is-invalid{
        border-color: #dc3545 !important;
    }
    .date-group{
        position: relative;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
        .card-header-custom {
            flex-direction: column;
            gap: 10px;
        }
        .submit-section {
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }
    }
    </style>
</head>

<body>

<div class="container-custom">

    <div class="header">
        <h1><i class="fa fa-edit"></i> Multi Edit Surat
            <span class="badge"><?= count($surat_list); ?> Item</span>
        </h1>
        <div>
            <a href="<?= site_url('surat'); ?>" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
    </div>

    <div class="info-box">
        <p><strong><i class="fa fa-info-circle"></i> Panduan Multi Edit:</strong></p>
        <p><i class="fa fa-check-circle"></i> Edit setiap item secara individual</p>
        <p><i class="fa fa-check-circle"></i> Semua perubahan disimpan sekaligus</p>
        <p><i class="fa fa-check-circle"></i> Tanggal akhir tidak boleh lebih awal dari tanggal mulai</p>
        <p><i class="fa fa-check-circle"></i> Akhir periode tidak boleh lebih awal dari periode penugasan</p>
        <p><i class="fa fa-check-circle"></i> Maksimal periode 60 hari untuk semua tanggal</p>
    </div>

    <form method="POST" action="<?= site_url('surat/save_multi_edit'); ?>" id="multiEditForm">

        <?php foreach ($surat_list as $index => $surat): ?>

        <?php
        // Pastikan field tersedia & decode aman
        $nip_array     = safe_json($surat->nip ?? []);
        $nama_array    = safe_json($surat->nama_dosen ?? []);
        $jabatan_array = safe_json($surat->jabatan ?? []);
        $divisi_array  = safe_json($surat->divisi ?? []);
        ?>

        <div class="edit-card">
            <!-- Nomor urut card -->
            <div class="card-number"><?= $index + 1 ?></div>

            <div class="card-header-custom">
                <div>
                    <div class="card-title"><?= htmlspecialchars($surat->nama_kegiatan ?? '-'); ?></div>
                    <div class="card-subtitle">
                        <i class="fa fa-file-alt"></i> <?= htmlspecialchars($surat->jenis_pengajuan ?? '-'); ?> • 
                        <i class="fa fa-calendar"></i> <?= !empty($surat->created_at) && $surat->created_at !== '-' ? date('d M Y', strtotime($surat->created_at)) : '-'; ?>
                    </div>
                </div>
                <div class="item-id">ID: <?= htmlspecialchars($surat->id); ?></div>
            </div>

            <input type="hidden" name="items[<?= $index ?>][id]" value="<?= htmlspecialchars($surat->id); ?>">

            <div class="form-section-title"><i class="fas fa-calendar-alt"></i> Informasi Kegiatan</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nama Kegiatan</label>
                    <input type="text" class="form-control"
                           name="items[<?= $index ?>][nama_kegiatan]"
                           value="<?= htmlspecialchars($surat->nama_kegiatan ?? ''); ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Jenis Tanggal</label>
                    <select class="form-control jenis-date-select" data-index="<?= $index ?>"
                            name="items[<?= $index ?>][jenis_date]">
                        <option value="custom"  <?= isset($surat->jenis_date) && $surat->jenis_date=='custom'?'selected':'' ?>>Custom</option>
                        <option value="periode" <?= isset($surat->jenis_date) && $surat->jenis_date=='periode'?'selected':'' ?>>Periode</option>
                    </select>
                </div>
            </div>

            <div id="custom_<?= $index ?>" style="<?= (isset($surat->jenis_date) && $surat->jenis_date=='custom') ? '' : 'display:none' ?>">
                <div class="row mt-3">
                    <div class="col-md-6 mb-3 date-group">
                        <label>Tanggal Mulai</label>
                        <input type="date" class="form-control tanggal-kegiatan"
                               data-index="<?= $index ?>"
                               name="items[<?= $index ?>][tanggal_kegiatan]"
                               value="<?= (!empty($surat->tanggal_kegiatan) && $surat->tanggal_kegiatan!='-') ? htmlspecialchars($surat->tanggal_kegiatan) : '' ?>">
                        <div class="date-error" id="error_tanggal_<?= $index ?>">Tanggal mulai tidak valid</div>
                    </div>
                    <div class="col-md-6 mb-3 date-group">
                        <label>Tanggal Akhir</label>
                        <input type="date" class="form-control akhir-kegiatan"
                               data-index="<?= $index ?>"
                               name="items[<?= $index ?>][akhir_kegiatan]"
                               value="<?= (!empty($surat->akhir_kegiatan) && $surat->akhir_kegiatan!='-') ? htmlspecialchars($surat->akhir_kegiatan) : '' ?>">
                        <div class="date-error" id="error_akhir_<?= $index ?>">Tanggal akhir tidak boleh lebih awal dari tanggal mulai</div>
                    </div>
                    <div class="col-md-6 mb-3 date-group">
                        <label>Periode Penugasan</label>
                        <input type="date" class="form-control periode-penugasan"
                               data-index="<?= $index ?>"
                               name="items[<?= $index ?>][periode_penugasan]"
                               value="<?= (!empty($surat->periode_penugasan) && $surat->periode_penugasan!='-') ? htmlspecialchars($surat->periode_penugasan) : '' ?>">
                        <div class="date-error" id="error_periode_<?= $index ?>">Tanggal periode tidak valid</div>
                    </div>
                    <div class="col-md-6 mb-3 date-group">
                        <label>Akhir Periode</label>
                        <input type="date" class="form-control akhir-periode-penugasan"
                               data-index="<?= $index ?>"
                               name="items[<?= $index ?>][akhir_periode_penugasan]"
                               value="<?= (!empty($surat->akhir_periode_penugasan) && $surat->akhir_periode_penugasan!='-') ? htmlspecialchars($surat->akhir_periode_penugasan) : '' ?>">
                        <div class="date-error" id="error_akhir_periode_<?= $index ?>">Tanggal akhir periode tidak boleh lebih awal dari periode penugasan</div>
                    </div>
                </div>
            </div>

            <div id="periode_<?= $index ?>" style="<?= (isset($surat->jenis_date) && $surat->jenis_date=='periode') ? '' : 'display:none' ?>" class="mt-3">
                <label>Pilih Periode</label>
                <select class="form-control" name="items[<?= $index ?>][periode_value]">
                    <?php
                    $years = ["2024/2025","2025/2026","2026/2027","2027/2028","2028/2029","2029/2030"];
                    foreach ($years as $y):
                        foreach (["Ganjil","Genap"] as $smt):
                            $val = $y . ' ' . $smt;
                            $sel = (isset($surat->periode_value) && $surat->periode_value == $val) ? 'selected' : '';
                            echo "<option value='".htmlspecialchars($val)."' $sel>".htmlspecialchars($val)."</option>";
                        endforeach;
                    endforeach;
                    ?>
                </select>
            </div>

            <div class="form-section-title"><i class="fas fa-file-alt"></i> Jenis Pengajuan</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Jenis Pengajuan</label>
                    <select class="form-control jenis-pengajuan-select" data-index="<?= $index ?>"
                            name="items[<?= $index ?>][jenis_pengajuan]">
                        <option value="Perorangan" <?= isset($surat->jenis_pengajuan) && $surat->jenis_pengajuan=='Perorangan'?'selected':'' ?>>Perorangan</option>
                        <option value="Kelompok"   <?= isset($surat->jenis_pengajuan) && $surat->jenis_pengajuan=='Kelompok'?'selected':'' ?>>Kelompok</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Format</label>
                    <select class="form-control" name="items[<?= $index ?>][format]">
                        <option value="Online"  <?= isset($surat->format) && $surat->format=='Online'?'selected':'' ?>>Online</option>
                        <option value="Offline" <?= isset($surat->format) && $surat->format=='Offline'?'selected':'' ?>>Offline</option>
                        <option value="Hybrid"  <?= isset($surat->format) && $surat->format=='Hybrid'?'selected':'' ?>>Hybrid</option>
                    </select>
                </div>
            </div>

            <div id="perorangan_<?= $index ?>" style="<?= (isset($surat->jenis_pengajuan) && $surat->jenis_pengajuan=='Perorangan') ? '' : 'display:none' ?>" class="mt-3">
                <label>Jenis Penugasan (Perorangan)</label>
                <select class="form-control jenis-penugasan-per-select mb-3" data-index="<?= $index ?>"
                        name="items[<?= $index ?>][jenis_penugasan_perorangan]">
                    <?php foreach(["Juri","Pembicara","Narasumber","Lainnya"] as $o): 
                        $sel = (isset($surat->jenis_penugasan_perorangan) && $surat->jenis_penugasan_perorangan == $o) ? 'selected' : '';
                    ?>
                        <option value="<?= htmlspecialchars($o) ?>" <?= $sel ?>><?= htmlspecialchars($o) ?></option>
                    <?php endforeach ?>
                </select>

                <div id="lainnya_per_<?= $index ?>" class="mt-2"
                     style="<?= (isset($surat->jenis_penugasan_perorangan) && $surat->jenis_penugasan_perorangan=='Lainnya') ? '' : 'display:none' ?>">
                    <label>Isi Lainnya</label>
                    <input type="text" class="form-control"
                           name="items[<?= $index ?>][penugasan_lainnya_perorangan]"
                           value="<?= htmlspecialchars($surat->penugasan_lainnya_perorangan ?? '') ?>">
                </div>
            </div>

            <div id="kelompok_<?= $index ?>" style="<?= (isset($surat->jenis_pengajuan) && $surat->jenis_pengajuan=='Kelompok') ? '' : 'display:none' ?>" class="mt-3">
                <label>Jenis Penugasan (Kelompok)</label>
                <select class="form-control jenis-penugasan-kel-select" data-index="<?= $index ?>"
                        name="items[<?= $index ?>][jenis_penugasan_kelompok]">
                    <?php foreach(["Tim","Kepanitiaan","Lainnya"] as $o): 
                        $sel = (isset($surat->jenis_penugasan_kelompok) && $surat->jenis_penugasan_kelompok == $o) ? 'selected' : '';
                    ?>
                        <option value="<?= htmlspecialchars($o) ?>" <?= $sel ?>><?= htmlspecialchars($o) ?></option>
                    <?php endforeach ?>
                </select>

                <div id="lainnya_kel_<?= $index ?>" class="mt-2"
                     style="<?= (isset($surat->jenis_penugasan_kelompok) && $surat->jenis_penugasan_kelompok=='Lainnya') ? '' : 'display:none' ?>">
                    <label>Isi Lainnya</label>
                    <input type="text" class="form-control"
                           name="items[<?= $index ?>][penugasan_lainnya_kelompok]"
                           value="<?= htmlspecialchars($surat->penugasan_lainnya_kelompok ?? '') ?>">
                </div>
            </div>

            <div class="form-section-title"><i class="fas fa-users"></i> Dosen Terkait</div>

            <div class="table-responsive">
                <table class="table-custom dosen-table" data-index="<?= $index ?>">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama Dosen</th>
                            <th>Jabatan</th>
                            <th>Divisi</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if (!empty($nip_array)): ?>
                        <?php foreach ($nip_array as $i => $nip): ?>
                            <tr>
                                <td><input type="text" class="form-control" name="items[<?= $index ?>][nip][]" value="<?= htmlspecialchars($nip) ?>"></td>
                                <td><input type="text" class="form-control" name="items[<?= $index ?>][nama_dosen][]" value="<?= htmlspecialchars(isset($nama_array[$i]) ? $nama_array[$i] : '') ?>"></td>
                                <td><input type="text" class="form-control" name="items[<?= $index ?>][jabatan][]" value="<?= htmlspecialchars(isset($jabatan_array[$i]) ? $jabatan_array[$i] : '') ?>"></td>
                                <td><input type="text" class="form-control" name="items[<?= $index ?>][divisi][]" value="<?= htmlspecialchars(isset($divisi_array[$i]) ? $divisi_array[$i] : '') ?>"></td>
                                <td class="text-center"><span class="remove-row">&times;</span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td><input type="text" class="form-control" name="items[<?= $index ?>][nip][]"></td>
                            <td><input type="text" class="form-control" name="items[<?= $index ?>][nama_dosen][]"></td>
                            <td><input type="text" class="form-control" name="items[<?= $index ?>][jabatan][]"></td>
                            <td><input type="text" class="form-control" name="items[<?= $index ?>][divisi][]"></td>
                            <td class="text-center"><span class="remove-row">&times;</span></td>
                        </tr>
                    <?php endif ?>

                    </tbody>
                </table>
            </div>

            <button type="button" class="btn-add-row" data-index="<?= $index ?>">
                <i class="fa fa-plus"></i> Tambah Dosen
            </button>

        </div>

        <?php endforeach ?>

        <div class="submit-section">
            <div class="submit-info">
                <i class="fa fa-check-circle"></i>
                Siap menyimpan <?= count($surat_list) ?> item
            </div>

            <div>
                <a href="<?= site_url('surat'); ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Semua</button>
            </div>
        </div>

    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// JavaScript code remains exactly the same as in your original code
// Only CSS has been improved for better visual design
$(document).ready(() => {

    // === SWITCH CUSTOM/PERIODE ===
    $(document).on('change', '.jenis-date-select', function() {
        const i = $(this).data('index');
        const v = $(this).val();
        $('#custom_'+i).toggle(v === 'custom');
        $('#periode_'+i).toggle(v === 'periode');
    });

    // === SWITCH PERORANGAN / KELOMPOK ===
    $(document).on('change', '.jenis-pengajuan-select', function() {
        const i = $(this).data('index');
        const v = $(this).val();
        $('#perorangan_'+i).toggle(v === 'Perorangan');
        $('#kelompok_'+i).toggle(v === 'Kelompok');
    });

    $(document).on('change', '.jenis-penugasan-per-select', function() {
        const i = $(this).data('index');
        $('#lainnya_per_'+i).toggle($(this).val() === 'Lainnya');
    });

    $(document).on('change', '.jenis-penugasan-kel-select', function() {
        const i = $(this).data('index');
        $('#lainnya_kel_'+i).toggle($(this).val() === 'Lainnya');
    });

    // === TAMBAH ROW DOSEN ===
    $(document).on('click', '.btn-add-row', function() {
        const i = $(this).data('index');
        const tbody = $('.dosen-table[data-index="'+i+'"] tbody');
        const row = `
            <tr>
                <td><input type="text" class="form-control" name="items[${i}][nip][]"></td>
                <td><input type="text" class="form-control" name="items[${i}][nama_dosen][]"></td>
                <td><input type="text" class="form-control" name="items[${i}][jabatan][]"></td>
                <td><input type="text" class="form-control" name="items[${i}][divisi][]"></td>
                <td class="text-center"><span class="remove-row">&times;</span></td>
            </tr>
        `;
        tbody.append(row);
    });

    $(document).on('click', '.remove-row', function() {
        // jika hanya 1 row tersisa, kosongkan inputnya agar tidak menghapus struktur form
        const tbody = $(this).closest('tbody');
        if (tbody.find('tr').length <= 1) {
            tbody.find('tr').first().find('input').val('');
            return;
        }
        $(this).closest('tr').remove();
    });

    // ============================================
    //     VALIDASI TANGGAL - PERBAIKAN UTAMA
    // ============================================

    // Fungsi untuk validasi tanggal
    function validateDates(index) {
        let isValid = true;
        
        // Reset semua error message
        $(`#error_tanggal_${index}, #error_akhir_${index}, #error_periode_${index}, #error_akhir_periode_${index}`)
            .hide().prev().removeClass('is-invalid');
        
        // Validasi 1: Tanggal Kegiatan & Akhir Kegiatan
        const tanggalKegiatan = $(`.tanggal-kegiatan[data-index="${index}"]`).val();
        const akhirKegiatan = $(`.akhir-kegiatan[data-index="${index}"]`).val();
        
        if (tanggalKegiatan && akhirKegiatan) {
            if (new Date(akhirKegiatan) < new Date(tanggalKegiatan)) {
                $(`#error_akhir_${index}`).show().prev().addClass('is-invalid');
                isValid = false;
            }
        }
        
        // Validasi 2: Periode Penugasan & Akhir Periode - PERBAIKAN UTAMA
        const periodePenugasan = $(`.periode-penugasan[data-index="${index}"]`).val();
        const akhirPeriode = $(`.akhir-periode-penugasan[data-index="${index}"]`).val();
        
        if (periodePenugasan && akhirPeriode) {
            if (new Date(akhirPeriode) < new Date(periodePenugasan)) {
                $(`#error_akhir_periode_${index}`).show().prev().addClass('is-invalid');
                isValid = false;
            }
        }
        
        return isValid;
    }

    // Fungsi untuk set min date pada tanggal akhir - PERBAIKAN UTAMA
    function updateMinDates(index) {
        const tanggalKegiatan = $(`.tanggal-kegiatan[data-index="${index}"]`).val();
        const periodePenugasan = $(`.periode-penugasan[data-index="${index}"]`).val();
        
        // Set min date untuk akhir kegiatan
        if (tanggalKegiatan) {
            $(`.akhir-kegiatan[data-index="${index}"]`).attr('min', tanggalKegiatan);
        } else {
            $(`.akhir-kegiatan[data-index="${index}"]`).removeAttr('min');
        }
        
        // Set min date untuk akhir periode - PERBAIKAN UTAMA
        if (periodePenugasan) {
            $(`.akhir-periode-penugasan[data-index="${index}"]`).attr('min', periodePenugasan);
        } else {
            $(`.akhir-periode-penugasan[data-index="${index}"]`).removeAttr('min');
        }
    }

    // Event handlers untuk perubahan tanggal - PERBAIKAN UTAMA
    $(document).on('change', '.tanggal-kegiatan', function() {
        const index = $(this).data('index');
        updateMinDates(index);
        validateDates(index);
        
        // Auto-correction untuk akhir kegiatan
        const akhirKegiatan = $(`.akhir-kegiatan[data-index="${index}"]`).val();
        if (akhirKegiatan && new Date(akhirKegiatan) < new Date($(this).val())) {
            $(`.akhir-kegiatan[data-index="${index}"]`).val($(this).val());
            validateDates(index);
        }
    });

    $(document).on('change', '.periode-penugasan', function() {
        const index = $(this).data('index');
        updateMinDates(index);
        validateDates(index);
        
        // Auto-correction untuk akhir periode - PERBAIKAN UTAMA
        const akhirPeriode = $(`.akhir-periode-penugasan[data-index="${index}"]`).val();
        if (akhirPeriode && new Date(akhirPeriode) < new Date($(this).val())) {
            $(`.akhir-periode-penugasan[data-index="${index}"]`).val($(this).val());
            validateDates(index);
        }
    });

    $(document).on('change', '.akhir-kegiatan', function() {
        const index = $(this).data('index');
        validateDates(index);
    });

    $(document).on('change', '.akhir-periode-penugasan', function() {
        const index = $(this).data('index');
        // Validasi real-time saat user mengubah akhir periode
        const periodePenugasan = $(`.periode-penugasan[data-index="${index}"]`).val();
        const akhirPeriode = $(this).val();
        
        if (periodePenugasan && akhirPeriode && new Date(akhirPeriode) < new Date(periodePenugasan)) {
            // Auto-correction jika user memilih tanggal yang lebih awal
            $(this).val(periodePenugasan);
        }
        validateDates(index);
    });

    // Validasi form sebelum submit
    $('#multiEditForm').on('submit', function(e) {
        let allValid = true;
        
        // Validasi semua item
        $('.edit-card').each(function() {
            const index = $(this).find('.jenis-date-select').data('index');
            if (!validateDates(index)) {
                allValid = false;
                // Scroll ke card yang error
                $(this).get(0).scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
        
        if (!allValid) {
            e.preventDefault();
            alert('Terdapat kesalahan dalam pengisian tanggal. Harap periksa kembali:\n\n• Tanggal akhir tidak boleh lebih awal dari tanggal mulai\n• Akhir periode tidak boleh lebih awal dari periode penugasan');
            return false;
        }
        
        return true;
    });

    // ============================================
    //     AUTO-ADJUST 60 HARI VALIDATION
    // ============================================

    function addDays(date, days) {
        let d = new Date(date);
        d.setDate(d.getDate() + days);
        return d.toISOString().split('T')[0];
    }

    // 1. tanggal_kegiatan → akhir_kegiatan
    $(document).on("change", ".tanggal-kegiatan, .akhir-kegiatan", function() {
        let i = $(this).data('index');
        let start = $(`.tanggal-kegiatan[data-index="${i}"]`).val();
        let end   = $(`.akhir-kegiatan[data-index="${i}"]`).val();
        if (!start || !end) return;

        let maxEnd = addDays(start, 60);

        if (end > maxEnd) {
            $(`.akhir-kegiatan[data-index="${i}"]`).val(maxEnd);
            validateDates(i);
        }
    });

    // 2. periode_penugasan → akhir_periode_penugasan - PERBAIKAN UTAMA
    $(document).on("change", ".periode-penugasan, .akhir-periode-penugasan", function() {
        let i = $(this).data('index');
        let start = $(`.periode-penugasan[data-index="${i}"]`).val();
        let end   = $(`.akhir-periode-penugasan[data-index="${i}"]`).val();
        if (!start || !end) return;

        let maxEnd = addDays(start, 60);

        if (end > maxEnd) {
            $(`.akhir-periode-penugasan[data-index="${i}"]`).val(maxEnd);
            validateDates(i);
        }
        
        // Validasi tambahan untuk memastikan akhir periode tidak lebih awal
        if (end < start) {
            $(`.akhir-periode-penugasan[data-index="${i}"]`).val(start);
            validateDates(i);
        }
    });

    // Inisialisasi min dates saat load
    $('.edit-card').each(function() {
        const index = $(this).find('.jenis-date-select').data('index');
        updateMinDates(index);
    });

    // Pencegahan input manual yang tidak valid
    $(document).on('input', '.akhir-periode-penugasan', function() {
        const index = $(this).data('index');
        const periodePenugasan = $(`.periode-penugasan[data-index="${index}"]`).val();
        const currentValue = $(this).val();
        
        if (periodePenugasan && currentValue) {
            setTimeout(() => {
                if (new Date(currentValue) < new Date(periodePenugasan)) {
                    $(this).val(periodePenugasan);
                    validateDates(index);
                }
            }, 100);
        }
    });

});
</script>

</body>
</html>