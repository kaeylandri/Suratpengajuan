<?php
// edit_surat.php - Revisi lengkap dengan preview eviden
// Pastikan controller mengirim $surat (array) dan $eviden (array) ke view.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Surat</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap & FontAwesome -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
body { background: #fff7ef; }
.header-title { background: #ff8c00; color: #fff; padding: 15px; border-radius: 10px; margin-bottom: 25px; font-weight: bold; text-align: center; }
.form-section { padding: 20px; background: #fff; border-radius: 12px; margin-bottom: 25px; border-left: 5px solid #ff8c00; box-shadow: 0 2px 6px rgba(0,0,0,0.05); }
.form-section h5 { color: #ff8c00; font-weight: 700; margin-bottom: 15px; }
label { font-weight: 600; }
.btn-primary { background: #ff8c00; border-color: #ff8c00; }
.btn-primary:hover { background: #e27a00; border-color: #e27a00; }
.btn-success { background: #28a745; border-color: #28a745; }
.remove-row { cursor: pointer; color: red; font-weight: bold; }

/* File Eviden */
.existing-file-item, #newEvidenContainer .upload-item-wrapper {
    display: flex; align-items: center; gap: 12px; padding: 12px 15px; border-radius: 8px; margin-bottom: 10px;
    position: relative; background: #f8f9fa; border: 1px solid #dee2e6; transition: all 0.3s;
}
.existing-file-item:hover { background: #e9ecef; border-color: #ff8c00; box-shadow: 0 2px 8px rgba(255,140,0,0.1); }
.file-icon { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg,#ff8c00 0%,#ff6b00 100%); color: #fff; border-radius: 10px; font-size: 22px; }
.file-info { flex: 1; min-width: 0; }
.file-name { font-weight: 600; color: #333; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 14px; }
.file-size { font-size: 12px; color: #6c757d; font-weight: 500; }
.file-actions { display: flex; gap: 8px; flex-shrink: 0; }
.btn-delete-existing, .btn-view-file {
    border: none; padding: 8px 14px; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600;
    display: inline-flex; align-items: center; gap: 5px; text-decoration: none; transition: all 0.3s;
}
.btn-delete-existing { background: #dc3545; color: #fff; }
.btn-delete-existing:hover { background: #c82333; transform: scale(1.05); box-shadow: 0 2px 8px rgba(220,53,69,0.3); }
.btn-view-file { background: #17a2b8; color: #fff; }
.btn-view-file:hover { background: #138496; transform: scale(1.05); box-shadow: 0 2px 8px rgba(23,162,184,0.3); }

#newEvidenContainer .upload-item-wrapper input[type="file"] { flex: 1; padding: 10px 15px; border-radius: 6px; border: 1px solid #ddd; font-size: 14px; background: #fff; }
#newEvidenContainer .btn-icon-action { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; cursor: pointer; transition: all 0.3s; flex-shrink: 0; }
#newEvidenContainer .btn-add-file { background: #ff8c00; color: #fff; }
#newEvidenContainer .btn-add-file:hover { background: #e67e00; transform: scale(1.15) rotate(90deg); }
#newEvidenContainer .btn-remove-file { background: #f44336; color: #fff; }
#newEvidenContainer .btn-remove-file:hover { background: #d32f2f; transform: scale(1.15); }

.file-deleted { opacity: 0.4; text-decoration: line-through; pointer-events: none; background: #f8d7da !important; border-color: #dc3545 !important; }
.file-deleted .file-icon { background: #dc3545 !important; }
#chk-error { color: #dc3545; font-size: 13px; margin-top: 8px; font-weight: 600; display:block; }

/* Modal Preview */
#previewModal .modal-body { max-height: 80vh; overflow: auto; }
#previewModal .modal-body img { max-width: 100%; }
#previewModal .modal-body iframe { width: 100%; height: 70vh; border: none; }
#previewModal .modal-body .unsupported-file { padding: 40px; text-align: center; background: #f8f9fa; border-radius: 8px; }
#previewModal .modal-body .unsupported-file i { font-size: 48px; color: #6c757d; margin-bottom: 15px; }

@media(max-width:768px){
    .form-section { padding: 15px; }
    .existing-file-item { flex-direction: column; align-items: flex-start; }
    .file-actions { width: 100%; flex-wrap: wrap; }
    .btn-view-file,.btn-delete-existing { flex:1; justify-content:center; }
    .file-name { white-space: normal; word-break: break-all; }
}
/* Google-style Autocomplete */
.autocomplete-box-fixed {
    position: fixed;
    background: #fff;
    border: none;
    z-index: 9999999;
    max-height: 400px;
    overflow-y: auto;
    box-shadow: 0 4px 6px rgba(32,33,36,0.28);
    border-radius: 24px;
    font-size: 14px;
    padding: 8px 0;
    margin-top: 8px;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
    min-width: 300px;
}

.autocomplete-item {
    padding: 0;
    cursor: pointer;
    transition: background-color 0.1s ease;
    border: none;
    line-height: 1.4;
    display: flex;
    align-items: center;
    gap: 16px;
    position: relative;
}

.autocomplete-item:hover,
.autocomplete-item.active {
    background: #f8f9fa;
}

.autocomplete-icon {
    width: 20px;
    height: 20px;
    margin-left: 16px;
    flex-shrink: 0;
    opacity: 0.54;
}

.autocomplete-icon svg {
    width: 20px;
    height: 20px;
    fill: #5f6368;
}

.autocomplete-content {
    display: flex;
    flex-direction: column;
    gap: 2px;
    padding: 12px 16px 12px 0;
    flex: 1;
    min-width: 0;
}

.autocomplete-item .item-primary {
    font-size: 14px;
    color: #202124;
    font-weight: 400;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.autocomplete-item .item-secondary {
    font-size: 12px;
    color: #70757a;
    font-weight: 400;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.query-match {
    font-weight: 600;
    color: #ff8c00;
}

.autocomplete-item:first-child {
    border-left: 3px solid #ff8c00;
}

.autocomplete-loading,
.autocomplete-empty {
    padding: 16px 20px;
    text-align: center;
    color: #70757a;
    font-size: 13px;
}

.autocomplete-box-fixed::-webkit-scrollbar {
    width: 10px;
}

.autocomplete-box-fixed::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.autocomplete-box-fixed::-webkit-scrollbar-thumb {
    background: #dadce0;
    border-radius: 10px;
    border: 2px solid #fff;
}

.autocomplete-box-fixed::-webkit-scrollbar-thumb:hover {
    background: #bdc1c6;
}
</style>
</head>
<body>

<div class="container mt-4 mb-5">
<div class="header-title">Edit Pengajuan Surat</div>
<form action="<?= site_url('surat/edit/' . (isset($surat['id']) ? $surat['id'] : '')); ?>" method="post" enctype="multipart/form-data">

<!-- Informasi Kegiatan -->
<div class="form-section">
<h5>Informasi Kegiatan</h5>
<div class="form-group">
<label>Nama Kegiatan</label>
<input type="text" name="nama_kegiatan" class="form-control" value="<?= htmlspecialchars($surat['nama_kegiatan'] ?? ''); ?>" required>
</div>
<div class="form-group">
<label>Tanggal Pengajuan (readonly)</label>
<input type="text" class="form-control" value="<?= htmlspecialchars($surat['created_at'] ?? '-'); ?>" readonly>
</div>
<div class="form-group">
<label>Jenis Tanggal</label>
<select name="jenis_date" id="jenis_date" class="form-control">
<option value="custom" <?= (isset($surat['jenis_date']) && $surat['jenis_date']=='custom') ? 'selected' : '' ?>>Custom</option>
<option value="periode" <?= (isset($surat['jenis_date']) && $surat['jenis_date']=='periode') ? 'selected' : '' ?>>Periode</option>
</select>
</div>

<div id="custom_date" style="<?= (isset($surat['jenis_date']) && $surat['jenis_date']=='custom') ? '' : 'display:none;'; ?>">
<div class="form-group">
<label>Tanggal Mulai Kegiatan</label>
<input type="date" name="tanggal_kegiatan" class="form-control" value="<?= htmlspecialchars($surat['tanggal_kegiatan'] ?? ''); ?>">
</div>
<div class="form-group">
<label>Tanggal Akhir Kegiatan</label>
<input type="date" name="akhir_kegiatan" class="form-control" value="<?= htmlspecialchars($surat['akhir_kegiatan'] ?? ''); ?>">
</div>
<div class="form-group">
<label>Periode Penugasan</label>
<input type="date" name="periode_penugasan" class="form-control" value="<?= htmlspecialchars($surat['periode_penugasan'] ?? ''); ?>">
</div>
<div class="form-group">
<label>Akhir Periode Penugasan</label>
<input type="date" name="akhir_periode_penugasan" class="form-control" value="<?= htmlspecialchars($surat['akhir_periode_penugasan'] ?? ''); ?>">
</div>
</div>

<div id="periode_date" style="<?= (isset($surat['jenis_date']) && $surat['jenis_date']=='periode') ? '' : 'display:none;'; ?>">
<div class="form-group">
<label>Pilih Periode</label>
<select name="periode_value" class="form-control">
<?php
$years = ["2024/2025","2025/2026","2026/2027","2027/2028","2028/2029","2029/2030"];
foreach($years as $y){
    $g = $y.' Ganjil';
    $p = $y.' Genap';
    echo '<option value="'.htmlspecialchars($g).'" '.((isset($surat['periode_value']) && $surat['periode_value']==$g)?'selected':'').'>'.htmlspecialchars($g).'</option>';
    echo '<option value="'.htmlspecialchars($p).'" '.((isset($surat['periode_value']) && $surat['periode_value']==$p)?'selected':'').'>'.htmlspecialchars($p).'</option>';
}
?>
</select>
</div>
</div>

<div class="form-group">
<label>Tempat Kegiatan</label>
<input type="text" name="tempat_kegiatan" class="form-control" value="<?= htmlspecialchars($surat['tempat_kegiatan'] ?? ''); ?>">
</div>
<div class="form-group">
<label>Penyelenggara</label>
<input type="text" name="penyelenggara" class="form-control" value="<?= htmlspecialchars($surat['penyelenggara'] ?? ''); ?>">
</div>
</div>

<!-- Jenis Pengajuan -->
<div class="form-section">
<h5>Jenis Pengajuan</h5>
<div class="form-group">
<label>Jenis Pengajuan</label>
<select name="jenis_pengajuan" id="jenis_pengajuan" class="form-control">
<option value="Perorangan" <?= (isset($surat['jenis_pengajuan']) && $surat['jenis_pengajuan']=='Perorangan') ? 'selected' : '' ?>>Perorangan</option>
<option value="Kelompok" <?= (isset($surat['jenis_pengajuan']) && $surat['jenis_pengajuan']=='Kelompok') ? 'selected' : '' ?>>Kelompok</option>
</select>
</div>

<div id="perorangan_box" style="<?= (isset($surat['jenis_pengajuan']) && $surat['jenis_pengajuan']=='Perorangan') ? '' : 'display:none;'; ?>">
<div class="form-group">
<label>Jenis Penugasan (Perorangan)</label>
<select name="jenis_penugasan_perorangan" id="jenis_penugasan_perorangan" class="form-control">
<?php $opsi_per=["Juri","Pembicara","Narasumber","Lainnya"];
foreach($opsi_per as $o) echo '<option value="'.htmlspecialchars($o).'" '.((isset($surat['jenis_penugasan_perorangan']) && $surat['jenis_penugasan_perorangan']==$o)?'selected':'').'>'.htmlspecialchars($o).'</option>'; ?>
</select>
</div>
<div class="form-group" id="lainnya_perorangan_box" style="<?= (isset($surat['jenis_penugasan_perorangan']) && $surat['jenis_penugasan_perorangan']=='Lainnya') ? '' : 'display:none;'; ?>">
<label>Isi Penugasan Lainnya</label>
<input type="text" name="penugasan_lainnya_perorangan" class="form-control" value="<?= htmlspecialchars($surat['penugasan_lainnya_perorangan'] ?? ''); ?>">
</div>
</div>

<div id="kelompok_box" style="<?= (isset($surat['jenis_pengajuan']) && $surat['jenis_pengajuan']=='Kelompok') ? '' : 'display:none;'; ?>">
<div class="form-group">
<label>Jenis Penugasan (Kelompok)</label>
<select name="jenis_penugasan_kelompok" id="jenis_penugasan_kelompok" class="form-control">
<?php $opsi_kel=["Tim","Kepanitiaan","Lainnya"];
foreach($opsi_kel as $o) echo '<option value="'.htmlspecialchars($o).'" '.((isset($surat['jenis_penugasan_kelompok']) && $surat['jenis_penugasan_kelompok']==$o)?'selected':'').'>'.htmlspecialchars($o).'</option>'; ?>
</select>
</div>
<div class="form-group" id="lainnya_kelompok_box" style="<?= (isset($surat['jenis_penugasan_kelompok']) && $surat['jenis_penugasan_kelompok']=='Lainnya') ? '' : 'display:none;'; ?>">
<label>Isi Penugasan Lainnya</label>
<input type="text" name="penugasan_lainnya_kelompok" class="form-control" value="<?= htmlspecialchars($surat['penugasan_lainnya_kelompok'] ?? ''); ?>">
</div>
</div>
</div>

<!-- Dosen -->
<div class="form-section">
<h5>Dosen Terkait</h5>
<div class="table-responsive">
<table class="table table-bordered" id="dosen_table">
<thead class="thead-light">
<tr><th>NIP</th><th>Nama Dosen</th><th>Jabatan</th><th>Divisi</th><th width="5%">Aksi</th></tr>
</thead>
<tbody>
<?php
if (!empty($dosen_data) && is_array($dosen_data)):
    foreach($dosen_data as $i => $dosen):
?>
<tr class="dosen-row" data-row-index="<?= $i ?>">
<td>
    <input type="text" 
           name="nip[]" 
           class="form-control nip-input" 
           value="<?= htmlspecialchars($dosen['nip'] ?? '') ?>" 
           autocomplete="off"
           required>
</td>
<td>
    <input type="text" 
           name="nama_dosen[]"
           class="form-control nama-dosen-input" 
           value="<?= htmlspecialchars($dosen['nama_dosen'] ?? '') ?>" 
           autocomplete="off"
           required>
</td>
<td>
    <input type="text" 
           name="jabatan[]"
           class="form-control jabatan-input" 
           value="<?= htmlspecialchars($dosen['jabatan'] ?? '') ?>" 
           autocomplete="off">
</td>
<td>
    <input type="text" 
           name="divisi[]"
           class="form-control divisi-input" 
           value="<?= htmlspecialchars($dosen['divisi'] ?? '') ?>" 
           autocomplete="off">
</td>
<td><span class="remove-row" style="cursor:pointer;color:red;font-weight:bold;">X</span></td>
</tr>
<?php
    endforeach;
else:
?>
<tr class="dosen-row" data-row-index="0">
<td>
    <input type="text" name="nip[]" class="form-control nip-input" required>
</td>
<td>
    <input type="text" name="nama_dosen[]" class="form-control nama-dosen-input" required>
</td>
<td>
    <input type="text" name="jabatan[]" class="form-control jabatan-input">
</td>
<td>
    <input type="text" name="divisi[]" class="form-control divisi-input">
</td>
<td><span class="remove-row" style="cursor:pointer;color:red;font-weight:bold;">X</span></td>
</tr>
<?php endif; ?>
</tbody>
</table>
</div>
<button type="button" id="addRow" class="btn btn-primary btn-sm">Tambah Dosen</button>
</div>

<!-- Eviden -->
<div class="form-section">
<h5><i class="fas fa-file-alt"></i> File Eviden</h5>
<div class="mb-4">
<label class="font-weight-bold mb-3">File yang Sudah Diupload:</label>
<div id="existingFilesContainer">
<?php
// $eviden diharapkan sudah disiapkan oleh controller sebagai array
if (!empty($eviden) && is_array($eviden) && count($eviden) > 0):
    foreach($eviden as $idx => $fileRaw):
        if (empty($fileRaw)) continue;

        // Jika element adalah array, cari nilai yang mengandung path/nama
        $file = $fileRaw;
        if (is_array($fileRaw)) {
            // keys kemungkinan: file, filename, nama, nama_file, name, 0
            $candidates = ['file','filename','nama','nama_file','name',0];
            $file = null;
            foreach ($candidates as $k) {
                if (isset($fileRaw[$k]) && is_string($fileRaw[$k]) && trim($fileRaw[$k]) !== '') {
                    $file = $fileRaw[$k];
                    break;
                }
            }
            // fallback to first string value
            if ($file === null) {
                foreach ($fileRaw as $v) {
                    if (is_string($v) && trim($v) !== '') { $file = $v; break; }
                }
            }
        }

        // jika bukan string setelah semua upaya, skip
        if (!is_string($file) || trim($file) === '') continue;

        $file = trim($file);

        // cek apakah external URL
        $is_external = filter_var($file, FILTER_VALIDATE_URL) ? true : false;

        // cek apakah sudah berisi 'uploads/' (mis. 'uploads/surat/xxx.png')
        $contains_uploads = (strpos($file, 'uploads/') !== false) || (strpos($file, '/uploads/') !== false);

        // tentukan label & tautan untuk view/download
        if ($is_external) {
            $label = basename($file);
            $view_link = $file; // external dapat ditampilkan langsung
        } else {
            if ($contains_uploads) {
                // bersihkan leading slash
                $clean_path = ltrim($file, '/');
                $label = basename($clean_path);
                $view_link = base_url($clean_path);
            } else {
                // default: file dianggap nama file di folder uploads/eviden/
                $label = basename($file);
                $view_link = base_url('uploads/eviden/' . $file);
            }
        }

        // ekstensi aman
        $ext = strtolower(pathinfo($label, PATHINFO_EXTENSION) ?: '');

        $icon = 'fa-file';
        if (in_array($ext, ['jpg','jpeg','png','gif','bmp','webp'])) $icon = 'fa-file-image';
        elseif ($ext == 'pdf') $icon = 'fa-file-pdf';
        elseif (in_array($ext, ['doc','docx'])) $icon = 'fa-file-word';
        elseif (in_array($ext, ['xls','xlsx'])) $icon = 'fa-file-excel';

        // filesize show jika ada file lokal
        $filesize = 'N/A';
        if (!$is_external) {
            if (!isset($filepath)) {
                $filepath = './uploads/eviden/' . $file;
            }
            if (file_exists($filepath)) {
                $filesize = round(filesize($filepath) / 1048576, 2) . ' MB';
            } else {
                $filesize = 'N/A';
            }
        } else {
            $filesize = 'External';
        }
?>
<div class="existing-file-item" data-file-index="<?= htmlspecialchars($idx) ?>" data-filename="<?= htmlspecialchars($file) ?>">
    <div class="file-icon">
        <i class="fas <?= htmlspecialchars($icon) ?>"></i>
    </div>
    <div class="file-info">
        <div class="file-name" title="<?= htmlspecialchars($file) ?>"><?= htmlspecialchars($label) ?></div>
        <div class="file-size"><?= htmlspecialchars($filesize) ?></div>
    </div>
    <div class="file-actions">
        <button type="button" class="btn-view-file btn btn-info btn-sm" data-src="<?= htmlspecialchars($view_link) ?>" data-type="<?= htmlspecialchars($ext) ?>" data-toggle="modal" data-target="#previewModal">
            <i class="fas fa-eye"></i> Lihat
        </button>
        <button type="button" class="btn-delete-existing btn btn-danger btn-sm" onclick="deleteExistingFile(<?= htmlspecialchars($idx) ?>,'<?= htmlspecialchars($file, ENT_QUOTES) ?>')">
            <i class="fas fa-trash"></i> Hapus
        </button>
    </div>

    <input type="hidden" name="existing_eviden[]" value="<?= htmlspecialchars($file) ?>" class="existing-file-input">
    <input type="hidden" name="delete_eviden[]" value="" class="delete-flag">
</div>
<?php
    endforeach;
else:
?>
<div class="alert alert-info"><i class="fas fa-info-circle"></i> Belum ada file eviden yang diupload</div>
<?php endif; ?>
</div>
</div>

<!-- Upload File Baru -->
<div class="mb-3">
<label class="font-weight-bold mb-3">Upload File Baru (Opsional):</label>
<div id="newEvidenContainer">
    <div class="upload-item-wrapper" data-index="0">
        <input type="file" name="new_eviden[]" class="form-control eviden-input" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">
        <button type="button" class="btn-icon-action btn-add-file" title="Tambah File"><i class="fas fa-plus"></i></button>
    </div>
</div>
<span id="chk-error"></span>
<small class="form-text text-muted"><i class="fas fa-info-circle"></i> Tipe file: JPG, PNG, PDF. Maks 10MB per file</small>
</div>
</div>

<button type="submit" class="btn btn-success px-4"><i class="fas fa-save"></i> Simpan Perubahan</button>
<a href="<?= base_url('list-surat-tugas') ?>" class="btn btn-secondary px-4"><i class="fas fa-arrow-left"></i> Kembali</a>

</form>
</div>

<!-- Modal Preview File -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="previewModalLabel">Preview File</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body text-center" id="previewContent">
<!-- Konten preview akan diisi secara dinamis -->
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
</div>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
/**
 * JavaScript interactions with Autocomplete
 */
const BASE_URL = '<?= rtrim(base_url(), "/") ?>';

// ===== AUTOCOMPLETE FUNCTIONALITY =====
let currentAutocompleteBox = null;
let currentKeydownHandler = null;
let currentClickHandler = null;
let currentInputElement = null;

// Debounce function
function debounce(fn, delay = 300) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => fn.apply(this, args), delay);
    };
}

// Highlight matching text
function highlightMatch(text, query) {
    if (!query || !text) return text;
    const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    const regex = new RegExp(`(${escapedQuery})`, 'gi');
    return text.replace(regex, '<span class="query-match">$1</span>');
}

// Remove existing autocomplete box
function removeAutocompleteBox() {
    if (currentAutocompleteBox) {
        currentAutocompleteBox.remove();
        currentAutocompleteBox = null;
    }
    if (currentKeydownHandler) {
        document.removeEventListener('keydown', currentKeydownHandler);
        currentKeydownHandler = null;
    }
    if (currentClickHandler) {
        document.removeEventListener('click', currentClickHandler);
        currentClickHandler = null;
    }
    currentInputElement = null;
}

// Fetch suggestions from database
async function fetchSuggestions(query, fieldType = 'nip') {
    if (!query) return [];
    
    try {
        const response = await fetch(`${BASE_URL}/surat/autocomplete_nip?q=${encodeURIComponent(query)}&field=${fieldType}`);
        
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        
        const data = await response.json();
        return Array.isArray(data) ? data : [];
    } catch (error) {
        console.error('Autocomplete error:', error);
        return [];
    }
}

// Show suggestion box
function showSuggestionBox(inputEl, items, onSelect, fieldType) {
    removeAutocompleteBox();

    const rect = inputEl.getBoundingClientRect();
    const box = document.createElement('div');
    box.className = 'autocomplete-box-fixed';
    box.style.left = rect.left + 'px';
    box.style.top = (rect.bottom + 4) + 'px';
    box.style.width = Math.max(rect.width, 300) + 'px';

    if (!items || !items.length) {
        const empty = document.createElement('div');
        empty.className = 'autocomplete-empty';
        empty.textContent = 'Tidak ada data ditemukan';
        box.appendChild(empty);
        document.body.appendChild(box);
        currentAutocompleteBox = box;
        currentInputElement = inputEl;
        setTimeout(() => removeAutocompleteBox(), 2000);
        return;
    }

    const query = inputEl.value.trim();
    let selectedIndex = -1;

    items.forEach((item, idx) => {
        const option = document.createElement('div');
        option.className = `autocomplete-item type-${fieldType}`;
        
        let primaryText, secondaryText;
        
        switch(fieldType) {
            case 'nip':
                primaryText = highlightMatch(item.nip, query);
                secondaryText = item.nama_dosen;
                break;
            case 'nama_dosen':
                primaryText = highlightMatch(item.nama_dosen, query);
                secondaryText = `NIP: ${item.nip}`;
                break;
            case 'jabatan':
                primaryText = highlightMatch(item.jabatan, query);
                secondaryText = `${item.nama_dosen} (${item.nip})`;
                break;
            case 'divisi':
                primaryText = highlightMatch(item.divisi, query);
                secondaryText = `${item.nama_dosen} (${item.nip})`;
                break;
            default:
                primaryText = highlightMatch(item.nip, query);
                secondaryText = item.nama_dosen;
        }

        option.innerHTML = `
            <div class="autocomplete-icon">
                <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                </svg>
            </div>
            <div class="autocomplete-content">
                <div class="item-primary">${primaryText || '-'}</div>
                ${secondaryText ? '<div class="item-secondary">' + secondaryText + '</div>' : ''}
            </div>
        `;
        
        option.addEventListener('click', (e) => {
            e.stopPropagation();
            onSelect(item);
            removeAutocompleteBox();
        });
        
        box.appendChild(option);
    });

    document.body.appendChild(box);
    currentAutocompleteBox = box;
    currentInputElement = inputEl;

    // Keyboard navigation
    currentKeydownHandler = function(e) {
        if (!currentAutocompleteBox) return;
        
        const opts = currentAutocompleteBox.querySelectorAll('.autocomplete-item');
        if (!opts.length) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            selectedIndex = Math.min(selectedIndex + 1, opts.length - 1);
            opts.forEach((o, i) => o.classList.toggle('active', i === selectedIndex));
            if (opts[selectedIndex]) {
                opts[selectedIndex].scrollIntoView({ block: 'nearest' });
            }
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            selectedIndex = Math.max(selectedIndex - 1, 0);
            opts.forEach((o, i) => o.classList.toggle('active', i === selectedIndex));
            if (opts[selectedIndex]) {
                opts[selectedIndex].scrollIntoView({ block: 'nearest' });
            }
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (selectedIndex >= 0 && opts[selectedIndex]) {
                opts[selectedIndex].click();
            }
        } else if (e.key === 'Escape') {
            removeAutocompleteBox();
        }
    };
    
    document.addEventListener('keydown', currentKeydownHandler);

    // Close on outside click
    currentClickHandler = function(ev) {
        if (currentAutocompleteBox && !currentAutocompleteBox.contains(ev.target) && ev.target !== currentInputElement) {
            removeAutocompleteBox();
        }
    };
    document.addEventListener('click', currentClickHandler);
}

// Initialize autocomplete for a row
function initAutocompleteForRow(rowEl) {
    const inputNip = rowEl.querySelector('.nip-input');
    const inputNama = rowEl.querySelector('.nama-dosen-input');
    const inputJabatan = rowEl.querySelector('.jabatan-input');
    const inputDivisi = rowEl.querySelector('.divisi-input');

    if (!inputNip || !inputNama || !inputJabatan || !inputDivisi) {
        return;
    }

    // Fill all fields when item is selected
    function fillRowWith(item) {
        if (!item) return;
        
        inputNip.value = item.nip || '';
        inputNama.value = item.nama_dosen || '';
        inputJabatan.value = item.jabatan || '';
        inputDivisi.value = item.divisi || '';
    }

    // Create autocomplete handlers for each field
    function createAutocompleteHandler(fieldType, inputElement) {
        const handler = debounce(async function() {
            const val = this.value.trim();
            
            if (val.length < 2 || document.activeElement !== this) {
                removeAutocompleteBox();
                return;
            }

            const suggestions = await fetchSuggestions(val, fieldType);
            showSuggestionBox(inputElement, suggestions, fillRowWith, fieldType);
        }, 300);

        // Remove old event listener if exists
        if (inputElement._currentHandler) {
            inputElement.removeEventListener('input', inputElement._currentHandler);
        }
        
        // Save reference to new handler
        inputElement._currentHandler = handler;
        // Attach new event listener
        inputElement.addEventListener('input', handler);

        // Focus handlers
        inputElement.addEventListener('focus', () => {
            removeAutocompleteBox();
        });
        
        inputElement.addEventListener('blur', () => {
            setTimeout(() => {
                if (document.activeElement !== inputElement && 
                    (!currentAutocompleteBox || !currentAutocompleteBox.contains(document.activeElement))) {
                    removeAutocompleteBox();
                }
            }, 150);
        });
    }

    // Initialize autocomplete for all fields
    createAutocompleteHandler('nip', inputNip);
    createAutocompleteHandler('nama_dosen', inputNama);
    createAutocompleteHandler('jabatan', inputJabatan);
    createAutocompleteHandler('divisi', inputDivisi);
}

// ===== EXISTING FUNCTIONS =====
function deleteExistingFile(index, filename) {
    if (!confirm('Yakin ingin menghapus file "'+filename+'"?')) return;
    const fileItem = document.querySelector(`.existing-file-item[data-file-index="${index}"]`);
    if (!fileItem) return;
    const deleteFlag = fileItem.querySelector('.delete-flag');
    const existingInput = fileItem.querySelector('.existing-file-input');
    if (deleteFlag) deleteFlag.value = filename;
    if (existingInput) existingInput.remove();
    fileItem.classList.add('file-deleted');
    fileItem.style.opacity = '0';
    fileItem.style.transform = 'translateX(-20px)';
    setTimeout(()=>fileItem.style.display='none', 300);
}

function previewFile(fileSrc, fileType, fileName) {
    const previewContent = document.getElementById('previewContent');
    
    previewContent.innerHTML = '';
    
    if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(fileType.toLowerCase())) {
        const img = document.createElement('img');
        img.src = fileSrc;
        img.alt = 'Preview ' + fileName;
        img.className = 'img-fluid';
        img.style.maxHeight = '70vh';
        previewContent.appendChild(img);
    } else if (fileType.toLowerCase() === 'pdf') {
        const iframe = document.createElement('iframe');
        iframe.src = fileSrc;
        iframe.width = '100%';
        iframe.height = '600';
        previewContent.appendChild(iframe);
    } else {
        const unsupportedDiv = document.createElement('div');
        unsupportedDiv.className = 'unsupported-file';
        unsupportedDiv.innerHTML = `
            <i class="fas fa-file"></i>
            <h5>Preview tidak tersedia</h5>
            <p>File ${fileType.toUpperCase()} tidak dapat ditampilkan preview-nya.</p>
            <p>Silakan gunakan aplikasi yang sesuai untuk membuka file ini.</p>
        `;
        previewContent.appendChild(unsupportedDiv);
    }
}

$(document).ready(function(){
    // Initialize autocomplete for existing rows
    document.querySelectorAll('.dosen-row').forEach(row => {
        initAutocompleteForRow(row);
    });

    // Toggle sections based on selections
    $("#jenis_date").change(function(){ 
        $("#custom_date").toggle(this.value==="custom"); 
        $("#periode_date").toggle(this.value==="periode"); 
    });
    
    $("#jenis_pengajuan").change(function(){ 
        $("#perorangan_box").toggle(this.value==="Perorangan"); 
        $("#kelompok_box").toggle(this.value==="Kelompok"); 
    });
    
    $("#jenis_penugasan_perorangan").change(function(){ 
        $("#lainnya_perorangan_box").toggle(this.value==="Lainnya"); 
    });
    
    $("#jenis_penugasan_kelompok").change(function(){ 
        $("#lainnya_kelompok_box").toggle(this.value==="Lainnya"); 
    });

    // Add new dosen row with autocomplete
    $("#addRow").click(function(){
        const rowIndex = $('#dosen_table tbody tr').length;
        const newRow = $(`<tr class="dosen-row" style="opacity:0;transform:translateY(-10px);" data-row-index="${rowIndex}">
            <td><input type="text" name="nip[]" class="form-control nip-input" required></td>
            <td><input type="text" name="nama_dosen[]" class="form-control nama-dosen-input" required></td>
            <td><input type="text" name="jabatan[]" class="form-control jabatan-input"></td>
            <td><input type="text" name="divisi[]" class="form-control divisi-input"></td>
            <td><span class="remove-row" style="cursor:pointer;color:red;font-weight:bold;">X</span></td>
        </tr>`).appendTo("#dosen_table tbody");
        
        setTimeout(()=>{ 
            newRow.css({'transition':'all 0.3s ease','opacity':'1','transform':'translateY(0)'});
            // Initialize autocomplete for the new row
            initAutocompleteForRow(newRow[0]);
        }, 10);
    });

    // Remove row
    $(document).on("click", ".remove-row", function(){
        const $row = $(this).closest("tr"); 
        $row.css({'opacity':'0','transform':'translateX(20px)'}); 
        setTimeout(()=>{$row.remove();},300);
    });

    // File upload handlers
    let evidenIndex = 0;
    $('#newEvidenContainer').on('click', '.btn-add-file', function(){
        evidenIndex++;
        const newItem = document.createElement('div');
        newItem.className = 'upload-item-wrapper';
        newItem.dataset.index = evidenIndex;
        newItem.innerHTML = `<input type="file" name="new_eviden[]" class="form-control eviden-input" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">
            <button type="button" class="btn-icon-action btn-remove-file" title="Hapus File"><i class="fas fa-trash"></i></button>`;
        document.getElementById('newEvidenContainer').appendChild(newItem);
    });

    $('#newEvidenContainer').on('click', '.btn-remove-file', function(){
        $(this).closest('.upload-item-wrapper').remove();
    });

    $('#newEvidenContainer').on('change', '.eviden-input', function(){
        const file = this.files[0];
        const errorSpan = document.getElementById('chk-error');
        if (file) {
            const sizeMB = (file.size / 1024 / 1024);
            if (sizeMB > 10) { 
                errorSpan.textContent = '⚠️ File terlalu besar! Maks 10MB'; 
                this.value = ''; 
                return; 
            }
            const allowed = ['image/jpeg','image/jpg','image/png','image/gif','application/pdf','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            if (!allowed.includes(file.type)) { 
                errorSpan.textContent = '⚠️ Tipe file tidak diizinkan!'; 
                this.value = ''; 
                return; 
            }
            errorSpan.style.color = '#28a745'; 
            errorSpan.textContent = `✓ File "${file.name}" siap diupload (${(sizeMB).toFixed(2)} MB)`;
            setTimeout(()=>{ 
                errorSpan.textContent = ''; 
                errorSpan.style.color='#dc3545'; 
            }, 3000);
        }
    });

    // Preview modal handlers
    $(document).on('click', '.btn-view-file', function(){
        let src = $(this).data('src') || '';
        const fileType = $(this).data('type') || '';
        let fileName = $(this).closest('.existing-file-item').find('.file-name').text().trim() || 'file';
        
        if (!src) { 
            $('#previewContent').html('<div class="alert alert-danger">File tidak ditemukan</div>');
            return; 
        }

        if (!/^https?:\/\//i.test(src)) {
            src = src.replace(/^\/+/, '');
            src = BASE_URL + '/' + src;
        }
        
        $('#previewModalLabel').text('Preview: ' + fileName);
        previewFile(src, fileType, fileName);
    });

    $('#previewModal').on('hidden.bs.modal', function () {
        $('#previewContent').empty();
        $('#previewModalLabel').text('Preview File');
    });

    // Close autocomplete when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.autocomplete-box-fixed') && 
            !e.target.closest('.nip-input') && 
            !e.target.closest('.nama-dosen-input') && 
            !e.target.closest('.jabatan-input') && 
            !e.target.closest('.divisi-input')) {
            removeAutocompleteBox();
        }
    });

    // Close autocomplete on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            removeAutocompleteBox();
        }
    });
});
</script>
</body>
</html>