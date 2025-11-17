
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Surat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            background: #fff7ef;
        }
        .header-title {
            background: #ff8c00;
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: bold;
            text-align:center;
        }
        .form-section {
            padding: 20px;
            background: white;
            border-radius: 12px;
            margin-bottom: 25px;
            border-left: 5px solid #ff8c00;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .form-section h5 {
            color: #ff8c00;
            font-weight: 700;
            margin-bottom: 15px;
        }
        label {
            font-weight: 600;
        }
        .btn-primary {
            background: #ff8c00;
            border-color: #ff8c00;
        }
        .btn-primary:hover {
            background: #e27a00;
            border-color: #e27a00;
        }
        .btn-success {
            background:#28a745;
        }
        .remove-row {
            cursor:pointer;
            color:red;
            font-weight:bold;
        }

        /* STYLE UNTUK EVIDEN - IMPROVED */
        .existing-file-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: all 0.3s;
            position: relative;
        }

        .existing-file-item:hover {
            background: #e9ecef;
            border-color: #ff8c00;
            box-shadow: 0 2px 8px rgba(255, 140, 0, 0.1);
        }

        .file-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ff8c00 0%, #ff6b00 100%);
            color: white;
            border-radius: 10px;
            font-size: 22px;
            flex-shrink: 0;
            box-shadow: 0 2px 4px rgba(255, 140, 0, 0.2);
        }

        .file-info {
            flex: 1;
            min-width: 0;
        }

        .file-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 14px;
        }

        .file-size {
            font-size: 12px;
            color: #6c757d;
            font-weight: 500;
        }

        .file-actions {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }

        .btn-delete-existing,
        .btn-view-file,
        .btn-download-file {
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }

        .btn-delete-existing {
            background: #dc3545;
            color: white;
        }

        .btn-delete-existing:hover {
            background: #c82333;
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }

        .btn-view-file {
            background: #17a2b8;
            color: white;
        }

        .btn-view-file:hover {
            background: #138496;
            color: white;
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(23, 162, 184, 0.3);
        }

        .btn-download-file {
            background: #28a745;
            color: white;
        }

        .btn-download-file:hover {
            background: #218838;
            color: white;
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        }

        /* New Upload Container */
        #newEvidenContainer .upload-item-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            padding: 12px;
            background: #f9f9f9;
            border-radius: 8px;
            border: 2px dashed #e0e0e0;
            transition: all 0.3s;
        }

        #newEvidenContainer .upload-item-wrapper:hover {
            border-color: #ff8c00;
            background: #fff4e6;
        }

        #newEvidenContainer .upload-item-wrapper input[type="file"] {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            background: white;
        }

        #newEvidenContainer .btn-icon-action {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all 0.3s;
            flex-shrink: 0;
        }

        #newEvidenContainer .btn-add-file {
            background: #ff8c00;
            color: white;
        }

        #newEvidenContainer .btn-add-file:hover {
            background: #e67e00;
            transform: scale(1.15) rotate(90deg);
            box-shadow: 0 4px 12px rgba(255, 140, 0, 0.3);
        }

        #newEvidenContainer .btn-remove-file {
            background: #f44336;
            color: white;
        }

        #newEvidenContainer .btn-remove-file:hover {
            background: #d32f2f;
            transform: scale(1.15);
            box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3);
        }

        /* File Deleted State */
        .file-deleted {
            opacity: 0.4;
            text-decoration: line-through;
            pointer-events: none;
            background: #f8d7da !important;
            border-color: #dc3545 !important;
        }

        .file-deleted .file-icon {
            background: #dc3545 !important;
        }

        /* Error Message */
        #chk-error {
            color: #dc3545;
            font-size: 13px;
            display: block;
            margin-top: 8px;
            font-weight: 600;
        }

        /* Alert Info */
        .alert-info {
            background: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
            padding: 12px 15px;
            border-radius: 8px;
            border-left: 4px solid #17a2b8;
        }

        /* Responsive */
        @media(max-width: 768px) {
            .form-section { 
                padding: 15px; 
            }
            
            .existing-file-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .file-actions {
                width: 100%;
                flex-wrap: wrap;
            }
            
            .btn-view-file,
            .btn-download-file,
            .btn-delete-existing {
                flex: 1;
                justify-content: center;
            }
            
            .file-name {
                white-space: normal;
                word-break: break-all;
            }
        }
    </style>
</head>
<body>

<div class="container mt-4 mb-5">

    <div class="header-title">Edit Pengajuan Surat</div>

    <form action="<?= site_url('surat/edit/' . $surat['id']); ?>" method="post" enctype="multipart/form-data">

        <!-- ======================= INFORMASI KEGIATAN ======================= -->
        <div class="form-section">
            <h5>Informasi Kegiatan</h5>

            <div class="form-group">
                <label>Nama Kegiatan</label>
                <input type="text" name="nama_kegiatan" class="form-control"
                       value="<?= $surat['nama_kegiatan']; ?>" required>
            </div>

            <div class="form-group">
                <label>Tanggal Pengajuan (readonly)</label>
                <input type="text" class="form-control" value="<?= $surat['tanggal_pengajuan'] ?? '-'; ?>" readonly>
            </div>

            <div class="form-group">
                <label>Jenis Tanggal</label>
                <select name="jenis_date" id="jenis_date" class="form-control">
                    <option value="custom" <?= $surat['jenis_date']=='custom'?'selected':'' ?>>Custom</option>
                    <option value="periode" <?= $surat['jenis_date']=='periode'?'selected':'' ?>>Periode</option>
                </select>
            </div>

            <!-- CUSTOM DATE -->
            <div id="custom_date" style="<?= $surat['jenis_date']=='custom'?'':'display:none;' ?>">
                <div class="form-group">
                    <label>Tanggal Mulai Kegiatan</label>
                    <input type="date" name="tanggal_kegiatan" class="form-control"
                           value="<?= $surat['tanggal_kegiatan'] !== '-' ? $surat['tanggal_kegiatan'] : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Tanggal Akhir Kegiatan</label>
                    <input type="date" name="akhir_kegiatan" class="form-control"
                           value="<?= $surat['akhir_kegiatan'] !== '-' ? $surat['akhir_kegiatan'] : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Periode Penugasan</label>
                    <input type="date" name="periode_penugasan" class="form-control"
                           value="<?= $surat['periode_penugasan'] !== '-' ? $surat['periode_penugasan'] : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Akhir Periode Penugasan</label>
                    <input type="date" name="akhir_periode_penugasan" class="form-control"
                           value="<?= $surat['akhir_periode_penugasan'] !== '-' ? $surat['akhir_periode_penugasan'] : ''; ?>">
                </div>
            </div>

            <!-- PERIODE SELECT -->
            <div id="periode_date" style="<?= $surat['jenis_date']=='periode'?'':'display:none;' ?>">
                <div class="form-group">
                    <label>Pilih Periode</label>
                    <select name="periode_value" class="form-control">
                        <?php
                            $years = ["2024/2025","2025/2026","2026/2027","2027/2028","2028/2029","2029/2030"];
                            foreach ($years as $y) {
                                $g = $y.' Ganjil';
                                $p = $y.' Genap';
                                echo '<option value="'.$g.'" '.($surat['periode_value']==$g?'selected':'').'>'.$g.'</option>';
                                echo '<option value="'.$p.'" '.($surat['periode_value']==$p?'selected':'').'>'.$p.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Tempat Kegiatan</label>
                <input type="text" name="tempat_kegiatan" class="form-control" value="<?= $surat['tempat_kegiatan']; ?>">
            </div>

            <div class="form-group">
                <label>Penyelenggara</label>
                <input type="text" name="penyelenggara" class="form-control" value="<?= $surat['penyelenggara']; ?>">
            </div>
        </div>

        <!-- ======================= JENIS PENGAJUAN ======================= -->
        <div class="form-section">
            <h5>Jenis Pengajuan</h5>

            <div class="form-group">
                <label>Jenis Pengajuan</label>
                <select name="jenis_pengajuan" id="jenis_pengajuan" class="form-control">
                    <option value="Perorangan" <?= $surat['jenis_pengajuan']=='Perorangan'?'selected':'' ?>>Perorangan</option>
                    <option value="Kelompok" <?= $surat['jenis_pengajuan']=='Kelompok'?'selected':'' ?>>Kelompok</option>
                </select>
            </div>

            <!-- PERORANGAN -->
            <div id="perorangan_box" style="<?= $surat['jenis_pengajuan']=='Perorangan'?'':'display:none;' ?>">
                <div class="form-group">
                    <label>Jenis Penugasan (Perorangan)</label>
                    <select name="jenis_penugasan_perorangan" id="jenis_penugasan_perorangan" class="form-control">
                        <?php
                            $opsi_per = ["Juri", "Pembicara", "Narasumber", "Lainnya"];
                            foreach ($opsi_per as $o) {
                                echo '<option value="'.$o.'" '.($surat['jenis_penugasan_perorangan']==$o?'selected':'').'>'.$o.'</option>';
                            }
                        ?>
                    </select>
                </div>

                <div class="form-group" id="lainnya_perorangan_box" style="<?= $surat['jenis_penugasan_perorangan']=='Lainnya'?'':'display:none;' ?>">
                    <label>Isi Penugasan Lainnya</label>
                    <input type="text" name="penugasan_lainnya_perorangan" class="form-control"
                           value="<?= $surat['penugasan_lainnya_perorangan']; ?>">
                </div>
            </div>

            <!-- KELOMPOK -->
            <div id="kelompok_box" style="<?= $surat['jenis_pengajuan']=='Kelompok'?'':'display:none;' ?>">

                <div class="form-group">
                    <label>Jenis Penugasan (Kelompok)</label>
                    <select name="jenis_penugasan_kelompok" id="jenis_penugasan_kelompok" class="form-control">
                        <?php
                            $opsi_kel = ["Tim", "Kepanitiaan", "Lainnya"];
                            foreach ($opsi_kel as $o) {
                                echo '<option value="'.$o.'" '.($surat['jenis_penugasan_kelompok']==$o?'selected':'').'>'.$o.'</option>';
                            }
                        ?>
                    </select>
                </div>

                <div class="form-group" id="lainnya_kelompok_box" style="<?= $surat['jenis_penugasan_kelompok']=='Lainnya'?'':'display:none;' ?>">
                    <label>Isi Penugasan Lainnya</label>
                    <input type="text" name="penugasan_lainnya_kelompok" class="form-control"
                           value="<?= $surat['penugasan_lainnya_kelompok']; ?>">
                </div>
            </div>
        </div>

        <!-- ======================= DOSEN ======================= -->
        <div class="form-section">
            <h5>Dosen Terkait</h5>

            <div class="table-responsive">
                <table class="table table-bordered" id="dosen_table">
                    <thead class="thead-light">
                    <tr>
                        <th>NIP</th>
                        <th>Nama Dosen</th>
                        <th>Jabatan</th>
                        <th>Divisi</th>
                        <th width="5%">Aksi</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php if (!empty($surat['nip']) && is_array($surat['nip'])): ?>
                        <?php foreach ($surat['nip'] as $i => $nip): ?>
                            <tr>
                                <td><input type="text" name="nip[]" class="form-control" value="<?= htmlspecialchars($nip) ?>"></td>
                                <td><input type="text" name="nama_dosen[]" class="form-control" value="<?= htmlspecialchars($surat['nama_dosen'][$i] ?? '') ?>"></td>
                                <td><input type="text" name="jabatan[]" class="form-control" value="<?= htmlspecialchars($surat['jabatan'][$i] ?? '') ?>"></td>
                                <td><input type="text" name="divisi[]" class="form-control" value="<?= htmlspecialchars($surat['divisi'][$i] ?? '') ?>"></td>
                                <td><span class="remove-row">X</span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <button type="button" id="addRow" class="btn btn-primary btn-sm">Tambah Dosen</button>
        </div>

        <!-- ======================= EVIDEN ======================= -->
        <div class="form-section">
            <h5><i class="fas fa-file-alt"></i> File Eviden</h5>

            <!-- File yang Sudah Ada -->
            <div class="mb-4">
                <label class="font-weight-bold mb-3">File yang Sudah Diupload:</label>
                <div id="existingFilesContainer">
                    <?php 
                    // Debug: uncomment untuk cek isi eviden
                    // echo '<pre>Eviden Data: '; print_r($eviden); echo '</pre>';
                    
                    if (!empty($eviden) && is_array($eviden) && count($eviden) > 0): 
                        foreach ($eviden as $idx => $file): 
                            // Pastikan $file tidak kosong
                            if (empty($file) || trim($file) === '') continue;
                            
                            // Cek apakah file adalah URL atau nama file lokal
                            $is_url = filter_var($file, FILTER_VALIDATE_URL);
                            
                            // Jika UploadCare, buat URL lengkap
                            if (!$is_url && strpos($file, 'ucarecdn.com') === false && strpos($file, '~') !== false) {
                                // Kemungkinan ini adalah UUID UploadCare tanpa full URL
                                // Cek di database apakah ada full URL
                                $is_url = false;
                                $is_uploadcare_uuid = true;
                            } else {
                                $is_uploadcare_uuid = false;
                            }
                            
                            // Get file extension
                            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            $icon = 'fa-file';
                            
                            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])) {
                                $icon = 'fa-file-image';
                            } elseif ($ext == 'pdf') {
                                $icon = 'fa-file-pdf';
                            } elseif (in_array($ext, ['doc', 'docx'])) {
                                $icon = 'fa-file-word';
                            } elseif (in_array($ext, ['xls', 'xlsx'])) {
                                $icon = 'fa-file-excel';
                            }
                            
                            // Get file path dan ukuran
                            if ($is_url) {
                                // Jika file adalah URL (UploadCare)
                                $filepath = $file;
                                $filesize = 'External';
                                $file_url = $file;
                                $display_name = basename(parse_url($file, PHP_URL_PATH));
                            } elseif ($is_uploadcare_uuid) {
                                // UUID UploadCare tanpa full URL
                                $filepath = null;
                                $filesize = 'UploadCare';
                                $file_url = '#'; // Tidak bisa diakses langsung
                                $display_name = $file;
                            } else {
                                // Jika file lokal
                                $filepath = './uploads/eviden/' . $file;
                                $filesize = 'N/A';
                                
                                if (file_exists($filepath)) {
                                    $size_bytes = filesize($filepath);
                                    if ($size_bytes < 1024) {
                                        $filesize = $size_bytes . ' B';
                                    } elseif ($size_bytes < 1048576) {
                                        $filesize = round($size_bytes / 1024, 2) . ' KB';
                                    } else {
                                        $filesize = round($size_bytes / 1048576, 2) . ' MB';
                                    }
                                }
                                
                                $file_url = base_url('uploads/eviden/' . $file);
                                $display_name = basename($file);
                            }
                    ?>
                    <div class="existing-file-item" data-file-index="<?= $idx ?>" data-filename="<?= htmlspecialchars($file) ?>">
                        <div class="file-icon">
                            <i class="fas <?= $icon ?>"></i>
                        </div>
                        <div class="file-info">
                            <div class="file-name" title="<?= htmlspecialchars($display_name) ?>">
                                <?= htmlspecialchars($display_name) ?>
                            </div>
                            <div class="file-size"><?= $filesize ?></div>
                        </div>
                        <div class="file-actions">
                            <?php if ($is_url || file_exists($filepath)): ?>
                                <a href="<?= $file_url ?>" target="_blank" class="btn-view-file">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <a href="<?= site_url('surat/download_eviden/' . urlencode($file)) ?>" class="btn-download-file">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            <?php endif; ?>
                            <button type="button" class="btn-delete-existing" onclick="deleteExistingFile(<?= $idx ?>, '<?= htmlspecialchars($file, ENT_QUOTES) ?>')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                        <!-- Hidden input untuk tracking file yang masih ada -->
                        <input type="hidden" name="existing_eviden[]" value="<?= htmlspecialchars($file) ?>" class="existing-file-input">
                        <!-- Hidden input untuk flag file yang akan dihapus -->
                        <input type="hidden" name="delete_eviden[]" value="" class="delete-flag">
                    </div>
                    <?php 
                        endforeach; 
                    else:
                    ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Belum ada file eviden yang diupload
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <hr>

            <!-- Upload File Baru -->
            <div class="mb-3">
                <label class="font-weight-bold mb-3">Upload File Baru (Opsional):</label>
                <div id="newEvidenContainer">
                    <div class="upload-item-wrapper" data-index="0">
                        <input type="file" name="new_eviden[]" class="form-control eviden-input" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">
                        <button type="button" class="btn-icon-action btn-add-file" title="Tambah File">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <span id="chk-error"></span>
                <small class="form-text text-muted">
                    <i class="fas fa-info-circle"></i> Tipe file: JPG, PNG, PDF, DOC, DOCX, XLS, XLSX. Maksimal 10MB per file
                </small>
            </div>
        </div>

        <button type="submit" class="btn btn-success px-4">
            <i class="fas fa-save"></i> Simpan Perubahan
        </button>
        <a href="<?= site_url('surat'); ?>" class="btn btn-secondary px-4">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    /**
     * Download Helper Function
     */
    function downloadFile(url, filename) {
        // Create invisible iframe untuk download
        const iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = url;
        document.body.appendChild(iframe);
        
        // Remove iframe after 1 minute
        setTimeout(() => {
            document.body.removeChild(iframe);
        }, 60000);
        
        // Show notification
        const errorSpan = document.getElementById('chk-error');
        if (errorSpan) {
            errorSpan.style.color = '#28a745';
            errorSpan.textContent = '✓ Download dimulai...';
            setTimeout(() => {
                errorSpan.textContent = '';
                errorSpan.style.color = '#dc3545';
            }, 3000);
        }
    }

    // ===== Delete Existing File =====
    function deleteExistingFile(index, filename) {
        if (!confirm('Yakin ingin menghapus file "' + filename + '"?')) {
            return;
        }

        const fileItem = document.querySelector(`.existing-file-item[data-file-index="${index}"]`);
        if (!fileItem) return;
        
        const deleteFlag = fileItem.querySelector('.delete-flag');
        const existingInput = fileItem.querySelector('.existing-file-input');
        
        // Mark for deletion
        deleteFlag.value = filename;
        
        // Remove dari existing list (agar tidak disubmit sebagai file yang masih ada)
        if (existingInput) {
            existingInput.remove();
        }
        
        // Visual feedback
        fileItem.classList.add('file-deleted');
        fileItem.style.opacity = '0';
        fileItem.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            fileItem.style.display = 'none';
        }, 300);
    }

    $(document).ready(function() {

        // ===== Handle Download Button Click =====
        $(document).on('click', '.btn-download-file', function(e) {
            e.preventDefault();
            const downloadUrl = $(this).attr('href');
            const filename = $(this).closest('.existing-file-item').find('.file-name').text().trim();
            
            downloadFile(downloadUrl, filename);
        });

        // ===== Jenis tanggal =====
        $("#jenis_date").change(function() {
            if ($(this).val() === "custom") {
                $("#custom_date").show();
                $("#periode_date").hide();
            } else {
                $("#custom_date").hide();
                $("#periode_date").show();
            }
        });

        // ===== Tampilkan jenis pengajuan =====
        $("#jenis_pengajuan").change(function() {
            if ($(this).val() === "Perorangan") {
                $("#perorangan_box").show();
                $("#kelompok_box").hide();
            } else {
                $("#perorangan_box").hide();
                $("#kelompok_box").show();
            }
        });

        // ===== Perorangan: Lainnya =====
        $("#jenis_penugasan_perorangan").change(function() {
            if ($(this).val() === "Lainnya") {
                $("#lainnya_perorangan_box").show();
            } else {
                $("#lainnya_perorangan_box").hide();
            }
        });

        // ===== Kelompok: Lainnya =====
        $("#jenis_penugasan_kelompok").change(function() {
            if ($(this).val() === "Lainnya") {
                $("#lainnya_kelompok_box").show();
            } else {
                $("#lainnya_kelompok_box").hide();
            }
        });

        // ===== Tambah Dosen =====
        $("#addRow").click(function() {
            const newRow = `
                <tr style="opacity: 0; transform: translateY(-10px);">
                    <td><input type="text" name="nip[]" class="form-control"></td>
                    <td><input type="text" name="nama_dosen[]" class="form-control"></td>
                    <td><input type="text" name="jabatan[]" class="form-control"></td>
                    <td><input type="text" name="divisi[]" class="form-control"></td>
                    <td><span class="remove-row">X</span></td>
                </tr>
            `;
            
            const $newRow = $(newRow).appendTo("#dosen_table tbody");
            
            setTimeout(() => {
                $newRow.css({
                    'transition': 'all 0.3s ease',
                    'opacity': '1',
                    'transform': 'translateY(0)'
                });
            }, 10);
        });

        // ===== Hapus row =====
        $(document).on("click", ".remove-row", function() {
            const $row = $(this).closest("tr");
            $row.css({
                'opacity': '0',
                'transform': 'translateX(20px)'
            });
            
            setTimeout(() => {
                $row.remove();
            }, 300);
        });

        // ===== NEW EVIDEN UPLOAD LOGIC =====
        const newEvidenContainer = document.getElementById('newEvidenContainer');
        let evidenIndex = 0;

        if (newEvidenContainer) {
            newEvidenContainer.addEventListener('click', function(e) {
                // Tombol Add File
                if (e.target.closest('.btn-add-file')) {
                    evidenIndex++;
                    
                    const newUploadItem = document.createElement('div');
                    newUploadItem.className = 'upload-item-wrapper';
                    newUploadItem.setAttribute('data-index', evidenIndex);
                    newUploadItem.innerHTML = `
                        <input type="file" name="new_eviden[]" class="form-control eviden-input" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">
                        <button type="button" class="btn-icon-action btn-remove-file" title="Hapus File">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                    
                    newEvidenContainer.appendChild(newUploadItem);
                    
                    // Animasi smooth
                    setTimeout(() => {
                        newUploadItem.style.opacity = '0';
                        newUploadItem.style.transform = 'translateY(-10px)';
                        newUploadItem.offsetHeight;
                        newUploadItem.style.transition = 'all 0.3s ease';
                        newUploadItem.style.opacity = '1';
                        newUploadItem.style.transform = 'translateY(0)';
                    }, 10);
                }
                
                // Tombol Remove File
                if (e.target.closest('.btn-remove-file')) {
                    const uploadItem = e.target.closest('.upload-item-wrapper');
                    
                    uploadItem.style.opacity = '0';
                    uploadItem.style.transform = 'translateX(20px)';
                    
                    setTimeout(() => {
                        uploadItem.remove();
                        
                        // Jika semua item dihapus, buat item pertama kembali
                        if (newEvidenContainer.children.length === 0) {
                            evidenIndex = 0;
                            const firstItem = document.createElement('div');
                            firstItem.className = 'upload-item-wrapper';
                            firstItem.setAttribute('data-index', 0);
                            firstItem.innerHTML = `
                                <input type="file" name="new_eviden[]" class="form-control eviden-input" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">
                                <button type="button" class="btn-icon-action btn-add-file" title="Tambah File">
                                    <i class="fas fa-plus"></i>
                                </button>
                            `;
                            newEvidenContainer.appendChild(firstItem);
                        }
                    }, 300);
                }
            });

            // Validasi file
            newEvidenContainer.addEventListener('change', function(e) {
                if (e.target.classList.contains('eviden-input')) {
                    const file = e.target.files[0];
                    const errorSpan = document.getElementById('chk-error');
                    
                    if (file) {
                        const fileSize = (file.size / 1024 / 1024).toFixed(2);
                        
                        // Cek ukuran file (maksimal 10MB)
                        if (fileSize > 10) {
                            errorSpan.textContent = '⚠️ File terlalu besar! Maksimal 10MB';
                            e.target.value = '';
                            return;
                        }
                        
                        // Cek tipe file
                        const allowedTypes = [
                            'image/jpeg', 
                            'image/jpg', 
                            'image/png', 
                            'image/gif',
                            'application/pdf', 
                            'application/msword', 
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        ];
                        
                        if (!allowedTypes.includes(file.type)) {
                            errorSpan.textContent = '⚠️ Tipe file tidak diizinkan! Hanya JPG, PNG, PDF, DOC, DOCX, XLS, XLSX';
                            e.target.value = '';
                            return;
                        }
                        
                        // Clear error dan tampilkan info file
                        errorSpan.textContent = '';
                        errorSpan.style.color = '#28a745';
                        errorSpan.textContent = `✓ File "${file.name}" siap diupload (${fileSize} MB)`;
                        
                        // Reset warna error setelah 3 detik
                        setTimeout(() => {
                            errorSpan.textContent = '';
                            errorSpan.style.color = '#dc3545';
                        }, 3000);
                        
                        console.log(`File selected: ${file.name} (${fileSize} MB)`);
                    }
                }
            });
        }
    });
</script>

</body>
</html>