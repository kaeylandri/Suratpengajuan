<?php
// edit_surat.php - Versi Revisi dengan tampilan dan fitur sama seperti edit.php sekretariat
defined('BASEPATH') OR exit('No direct script access allowed');

// Tentukan mode revisi
$current_status = isset($surat['status']) ? strtolower($surat['status']) : '';
$is_revision = false;
$rejected_by = '';
$alert_class = 'alert-info';
$alert_icon = 'fa-info-circle';
$alert_title = 'Edit Pengajuan Surat';
$alert_message = 'Anda sedang mengedit pengajuan surat.';
$additional_message = '';

if ($current_status === 'ditolak kk') {
    $is_revision = true;
    $rejected_by = 'Kepala Kelompok (Kaprodi)';
    $alert_class = 'alert-warning';
    $alert_icon = 'fa-exclamation-triangle';
    $alert_title = 'Mode Revisi - Pengajuan Ulang';
    $alert_message = 'Surat ini ditolak oleh ' . $rejected_by . '.';
    $additional_message = 'Setelah Anda mengedit dan menyimpan, pengajuan akan dikirim kembali ke ' . $rejected_by . ' untuk disetujui ulang.';
} elseif ($current_status === 'ditolak sekretariat') {
    $is_revision = true;
    $rejected_by = 'Sekretariat';
    $alert_class = 'alert-warning';
    $alert_icon = 'fa-exclamation-triangle';
    $alert_title = 'Mode Revisi - Pengajuan Ulang';
    $alert_message = 'Surat ini ditolak oleh ' . $rejected_by . '.';
    $additional_message = 'Setelah Anda mengedit dan menyimpan, pengajuan akan dikirim kembali ke ' . $rejected_by . ' untuk disetujui ulang.';
} elseif ($current_status === 'ditolak dekan') {
    $is_revision = true;
    $rejected_by = 'Dekan';
    $alert_class = 'alert-warning';
    $alert_icon = 'fa-exclamation-triangle';
    $alert_title = 'Mode Revisi - Pengajuan Ulang';
    $alert_message = 'Surat ini ditolak oleh ' . $rejected_by . '.';
    $additional_message = 'Setelah Anda mengedit dan menyimpan, pengajuan akan dikirim kembali ke ' . $rejected_by . ' untuk disetujui ulang.';
}

// Tentukan form action
$form_action = site_url('surat/edit/' . ($surat['id'] ?? ''));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Surat - Pengajuan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Uploadcare CSS -->
    <link rel="stylesheet" href="https://ucarecdn.com/libs/widget/3.x/uploadcare.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
        }

        /* Header */
        .header-title {
            background: #FF8C00;
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 700;
            font-size: 24px;
            box-shadow: 0 4px 12px rgba(255, 140, 0, 0.3);
        }

        /* Form Container */
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        /* Form Sections */
        .form-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            border-left: 5px solid #FF8C00;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .form-section h5 {
            color: #FF8C00;
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #FF8C00;
            box-shadow: 0 0 0 3px rgba(255, 140, 0, 0.2);
        }

        /* Required Field */
        .required-field::after {
            content: " *";
            color: #e74c3c;
        }

        /* Table Styling */
        .table-responsive {
            overflow-x: auto;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        thead {
            background: #fff3e0;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #e9ecef;
            text-align: left;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary {
            background: #FF8C00;
            color: white;
        }

        .btn-primary:hover {
            background: #e67e00;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 140, 0, 0.3);
        }

        .btn-success {
            background: #27ae60;
            color: white;
        }

        .btn-success:hover {
            background: #229954;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #7f8c8d;
            color: white;
        }

        .btn-secondary:hover {
            background: #6c757d;
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 13px;
        }

        .remove-row {
            color: #e74c3c;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            transition: all 0.3s;
        }

        .remove-row:hover {
            background: #f8d7da;
            transform: scale(1.1);
        }

        /* File Evidence Styles */
        #uploaded-files-display {
            margin-top: 20px;
        }

        .file-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            background: white;
            border-radius: 6px;
            margin-bottom: 8px;
            border: 1px solid #e9ecef;
            transition: all 0.2s ease;
        }

        .file-item:hover {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-color: #FF8C00;
        }

        .file-icon {
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e9ecef;
            border-radius: 6px;
        }

        .file-info {
            flex: 1;
            min-width: 0;
        }

        .file-name {
            font-size: 14px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 4px;
        }

        .file-url {
            font-size: 11px;
            color: #6c757d;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .btn-remove {
            padding: 6px 12px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s ease;
        }

        .btn-remove:hover {
            background: #c82333;
            transform: scale(1.05);
        }

        .btn-view {
            padding: 6px 12px;
            background: #17a2b8;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s ease;
            text-decoration: none;
            margin-right: 5px;
        }

        .btn-view:hover {
            background: #138496;
            transform: scale(1.05);
        }

        /* Optional Field Styling */
        .optional-field {
            color: #6c757d;
            font-weight: normal;
        }

        .optional-field::after {
            content: " (Opsional)";
            font-size: 12px;
            color: #6c757d;
            font-weight: normal;
        }

        /* Uploadcare Panel Styling */
        #eviden-panel {
            min-height: 420px;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
        }

        #file-count-indicator {
            margin-left: 15px;
            font-size: 14px;
            color: #6c757d;
        }

        /* Date Picker Styling */
        .date-section {
            display: none;
        }

        .date-section.active {
            display: block;
        }

        .flatpickr-input {
            background-color: white !important;
            cursor: pointer !important;
            padding: 12px 15px !important;
            border: 2px solid #ddd !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            width: 100% !important;
            color: #333 !important;
        }

        .flatpickr-input:focus {
            border-color: #FF8C00 !important;
            box-shadow: 0 0 0 3px rgba(255, 140, 0, 0.2) !important;
            outline: none !important;
        }

        .flatpickr-calendar {
            border-radius: 12px !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15) !important;
            border: 1px solid #e0e0e0 !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }

        .flatpickr-day.selected {
            background: #FF8C00 !important;
            border-color: #FF8C00 !important;
            color: white !important;
            font-weight: bold;
        }

        .flatpickr-day.selected.startRange {
            background: #FF8C00 !important;
            border-color: #FF8C00 !important;
        }

        .flatpickr-day.selected.endRange {
            background: #e67e00 !important;
            border-color: #e67e00 !important;
        }

        .flatpickr-day.inRange {
            background: rgba(255, 140, 0, 0.1) !important;
            border-color: rgba(255, 140, 0, 0.2) !important;
            box-shadow: -5px 0 0 rgba(255, 140, 0, 0.1), 5px 0 0 rgba(255, 140, 0, 0.1) !important;
        }

        /* Info Message Styling */
        .info-message {
            color: #0d6efd;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .info-message i {
            margin-right: 5px;
        }

        .success-message {
            color: #198754;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        /* Error Message Styling */
        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: none;
            padding: 8px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            animation: fadeIn 0.3s ease;
        }

        .error-message i {
            margin-right: 5px;
        }

        /* Konfirmasi Tanggal Styling */
        #konfirmasi_tanggal {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 8px 10px;
            border-left: 3px solid #28a745;
            margin-top: 10px;
            display: none;
        }

        #konfirmasi_tanggal .small {
            font-size: 12px;
        }

        .badge.bg-info {
            font-size: 10px;
            padding: 3px 8px;
            font-weight: 600;
            background-color: #0dcaf0 !important;
            color: white;
        }

        /* Auto-filled input styling */
        .auto-filled {
            background-color: #f0f8ff !important;
            border-left: 3px solid #007bff !important;
        }

        @keyframes highlight {
            0% { background-color: #fff3cd; }
            100% { background-color: #f0f8ff; }
        }

        .highlight-animation {
            animation: highlight 1s ease;
        }

        /* Progress Bar */
        #upload-progress {
            margin-top: 20px;
        }

        .progress-bar {
            height: 8px;
            background-color: #28a745;
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        /* Modal Preview */
        .file-preview-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #202124;
            z-index: 10000;
        }

        .file-preview-modal.show {
            display: flex;
            flex-direction: column;
        }

        .pdf-viewer-header {
            background: linear-gradient(135deg, #7b5e9f 0%, #9370b8 100%);
            color: white;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .pdf-viewer-body {
            flex: 1;
            overflow: auto;
            background: #202124;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }
        
        .badge-warning { background: #ffc107; color: #000; }
        .badge-success { background: #28a745; color: white; }
        .badge-danger { background: #dc3545; color: white; }
        .badge-info { background: #17a2b8; color: white; }
        .badge-secondary { background: #6c757d; color: white; }

        /* Alert Box for Revision Mode */
        .alert-revision {
            background: #fff3cd;
            border: 2px solid #ffc107;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.2);
            animation: fadeIn 0.5s ease;
        }

        .alert-revision-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .alert-revision-icon {
            background: #ffc107;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .alert-revision-icon i {
            color: #856404;
            font-size: 24px;
        }

        .rejection-reason {
            margin-top: 12px;
            padding: 12px;
            background: white;
            border-radius: 8px;
            border-left: 4px solid #dc3545;
        }

        /* Alert Box for Normal Edit Mode */
        .alert-normal {
            background: #e8f6f3;
            border: 2px solid #16A085;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(22, 160, 133, 0.2);
        }

        .alert-normal-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .alert-normal-icon {
            background: #16A085;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .alert-normal-icon i {
            color: white;
            font-size: 24px;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }

            .form-section {
                padding: 15px;
            }

            .file-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .btn-view, .btn-remove {
                width: 100%;
                justify-content: center;
                margin: 5px 0;
            }

            .file-name {
                white-space: normal;
                word-break: break-all;
            }

            /* Responsive untuk date picker */
            .flatpickr-calendar {
                width: 90vw !important;
                left: 5vw !important;
                transform: none !important;
            }
        }

        /* Additional Styles for Editable Dosen Fields */
        .table-dosen .form-control-sm {
            padding: 8px 10px;
            font-size: 13px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .table-dosen .form-control-sm:focus {
            border-color: #e67e00 !important;
            background: #ffffff !important;
            box-shadow: 0 0 0 3px rgba(255, 140, 0, 0.15);
            transform: scale(1.02);
        }

        .table-dosen .form-control-sm:hover {
            border-color: #e67e00;
        }

        .btn-add-dosen {
            background: linear-gradient(135deg, #FF8C00 0%, #e67e00 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 15px;
        }

        .btn-add-dosen:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 140, 0, 0.3);
        }

        .btn-remove-dosen {
            padding: 8px 12px;
            background: #dc3545;
            color: white;
            border-radius: 6px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
        }

        .btn-remove-dosen:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        /* Customize field styling */
        .customize-note {
            font-size: 11px;
            color: #6c757d;
            margin-top: 4px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header-title">
            <i class="fas fa-edit"></i> Edit Pengajuan Surat
            <?php if(isset($surat['status'])): ?>
                <div style="font-size: 14px; margin-top: 10px; opacity: 0.9;">
                    <i class="fas fa-tag"></i> Status: 
                    <span class="status-badge <?= 
                        strpos($current_status, 'diajukan') !== false ? 'badge-info' : 
                        (strpos($current_status, 'disetujui') !== false ? 'badge-success' : 
                        (strpos($current_status, 'ditolak') !== false ? 'badge-danger' : 'badge-warning')) 
                    ?>">
                        <?= htmlspecialchars($surat['status']) ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Alert Info untuk Mode Revisi/Normal -->
        <?php if($is_revision): ?>
        <div class="alert-revision">
            <div class="alert-revision-content">
                <div class="alert-revision-icon">
                    <i class="fas <?= $alert_icon ?>"></i>
                </div>
                <div style="flex: 1;">
                    <h4 style="margin: 0 0 8px 0; color: #856404; font-size: 18px; font-weight: 700;">
                        <i class="fas fa-redo-alt"></i> <?= $alert_title ?>
                    </h4>
                    <p style="margin: 0; color: #856404; font-size: 14px; line-height: 1.6;">
                        <strong><?= $alert_message ?></strong>
                        <br><?= $additional_message ?>
                    </p>
                    
                    <?php if(!empty($surat['catatan_penolakan'])): ?>
                    <div class="rejection-reason">
                        <strong style="color: #dc3545; display: block; margin-bottom: 5px;">
                            <i class="fas fa-comment-dots"></i> Alasan Penolakan:
                        </strong>
                        <p style="margin: 0; color: #666; font-size: 13px; font-style: italic;">
                            "<?= htmlspecialchars($surat['catatan_penolakan']); ?>"
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="alert-normal">
            <div class="alert-normal-content">
                <div class="alert-normal-icon">
                    <i class="fas <?= $alert_icon ?>"></i>
                </div>
                <div style="flex: 1;">
                    <h4 style="margin: 0 0 8px 0; color: #0c5460; font-size: 18px; font-weight: 700;">
                        <i class="fas fa-edit"></i> <?= $alert_title ?>
                    </h4>
                    <p style="margin: 0; color: #0c5460; font-size: 14px; line-height: 1.6;">
                        <?= $alert_message ?>
                        <?= $additional_message ?>
                    </p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <form action="<?= $form_action ?>" method="post" enctype="multipart/form-data" id="editForm">
            <!-- Informasi Kegiatan -->
            <div class="form-section">
                <h5><i class="fas fa-info-circle"></i> Informasi Kegiatan</h5>
                
                <div class="form-group">
                    <label class="required-field">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" 
                           value="<?= htmlspecialchars($surat['nama_kegiatan'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label class="optional-field">Tanggal Pengajuan</label>
                    <input type="text" class="form-control" 
                           value="<?= htmlspecialchars($surat['created_at'] ?? '-'); ?>" readonly 
                           style="background-color: #f8f9fa;">
                </div>

                <!-- JENIS TANGGAL -->
                <div class="form-group">
                    <label class="optional-field">Jenis Tanggal</label>
                    <select name="jenis_date" id="jenis_date" class="form-control">
                        <option value="" disabled>Pilih Jenis Tanggal (opsional)</option>
                        <option value="Periode" <?= (isset($surat['jenis_date']) && $surat['jenis_date'] == 'Periode') ? 'selected' : '' ?>>Periode</option>
                        <option value="Custom" <?= (isset($surat['jenis_date']) && ($surat['jenis_date'] == 'Custom' || $surat['jenis_date'] == 'custom')) ? 'selected' : '' ?>>Custom</option>
                    </select>
                </div>

                <!-- SECTION CUSTOM DATE -->
                <div id="custom_date_section" class="date-section <?= (isset($surat['jenis_date']) && ($surat['jenis_date'] == 'Custom' || $surat['jenis_date'] == 'custom')) ? 'active' : '' ?>">
                    <div class="row">
                        <!-- Tanggal Kegiatan (Date Range) -->
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label class="optional-field">Tanggal Kegiatan</label>
                                <input type="text" id="datepicker" class="form-control flatpickr-input"
                                       autocomplete="off" inputmode="none" readonly
                                       placeholder="Klik untuk pilih tanggal (opsional)">
                                <label id="lbl_mulai" class="optional-field">Tanggal Awal s/d Akhir</label>

                                <!-- Hidden input -->
                                <input type="hidden" id="tanggal_awal_kegiatan" name="tanggal_kegiatan" 
                                       value="<?= htmlspecialchars($surat['tanggal_kegiatan'] ?? '') ?>">
                                <input type="hidden" id="tanggal_akhir_kegiatan" name="akhir_kegiatan"
                                       value="<?= htmlspecialchars($surat['akhir_kegiatan'] ?? '') ?>">

                                <!-- Konfirmasi tanggal -->
                                <div id="konfirmasi_tanggal" class="small mt-2" style="display: none;">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-success">✓ Tanggal dipilih:</span>
                                        <span id="day_counter" class="badge bg-info"></span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span id="konfirmasi_awal" class="text-muted small"></span>
                                        <span id="konfirmasi_akhir" class="text-muted small"></span>
                                    </div>
                                </div>

                                <div class="info-message small mt-1" id="range_info">
                                    Klik tanggal awal, lalu klik tanggal akhir (opsional)
                                </div>
                                
                                <!-- Pesan error untuk validasi tanggal -->
                                <div id="date_error" class="error-message" style="display: none;">
                                    <i class="fas fa-exclamation-triangle"></i> <span id="error_text"></span>
                                </div>
                                
                                <!-- Info batas 60 hari -->
                                <div id="day_limit_info" class="info-message small" style="display: none;">
                                    <i class="fas fa-info-circle"></i> Maksimal 60 hari dari tanggal awal
                                </div>
                            </div>
                        </div>

                        <!-- Periode penugasan -->
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <input type="text" name="periode_penugasan" id="datepicker3"
                                       class="form-control flatpickr-input"
                                       autocomplete="off" inputmode="none" readonly
                                       placeholder="Otomatis terisi">

                                <label id="lbl_mulai1" class="optional-field">Periode Penugasan</label>
                                <div class="info-message small" id="info_periode">Akan terisi otomatis</div>
                            </div>
                        </div>

                        <!-- Akhir penugasan -->
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <input type="text" name="akhir_periode_penugasan" id="datepicker4"
                                       class="form-control flatpickr-input"
                                       autocomplete="off" inputmode="none" readonly
                                       placeholder="Otomatis terisi">

                                <label id="lbl_akhir1" class="optional-field">Akhir Penugasan</label>
                                <div class="info-message small" id="info_akhir">Akan terisi otomatis</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION PERIODE -->
                <div id="periode_date_section" class="date-section <?= (isset($surat['jenis_date']) && $surat['jenis_date'] == 'Periode') ? 'active' : '' ?>">
                    <div class="form-group">
                        <label class="optional-field">Pilih Periode</label>
                        <select name="periode_value" id="periode_value" class="form-control">
                            <option value="" disabled>Pilih Periode (opsional)</option>
                            <?php
                            $years = ["2024/2025", "2025/2026", "2026/2027", "2027/2028", "2028/2029", "2029/2030"];
                            $selected_periode = $surat['periode_value'] ?? '';
                            foreach ($years as $y) {
                                $g = $y . ' Ganjil';
                                $p = $y . ' Genap';
                                echo '<option value="' . htmlspecialchars($g) . '" ' . ($selected_periode == $g ? 'selected' : '') . '>' . htmlspecialchars($g) . '</option>';
                                echo '<option value="' . htmlspecialchars($p) . '" ' . ($selected_periode == $p ? 'selected' : '') . '>' . htmlspecialchars($p) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="optional-field">Tempat Kegiatan</label>
                    <input type="text" name="tempat_kegiatan" class="form-control" 
                           value="<?= htmlspecialchars($surat['tempat_kegiatan'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label class="optional-field">Penyelenggara</label>
                    <input type="text" name="penyelenggara" class="form-control" 
                           value="<?= htmlspecialchars($surat['penyelenggara'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label class="optional-field">Customize</label>
                    <input type="text" name="customize" class="form-control" 
                           value="<?= htmlspecialchars($surat['customize'] ?? ''); ?>">
                    <div class="customize-note">
                        <i class="fas fa-info-circle"></i> Isi untuk custom informasi tambahan pada surat
                    </div>
                </div>
            </div>

            <!-- Jenis Pengajuan -->
            <div class="form-section">
                <h5><i class="fas fa-tasks"></i> Jenis Pengajuan</h5>
                <div class="form-group">
                    <label class="required-field">Jenis Pengajuan</label>
                    <select name="jenis_pengajuan" id="jenis_pengajuan" class="form-control" required>
                        <option value="" disabled>Pilih Jenis Pengajuan</option>
                        <option value="Perorangan" <?= (isset($surat['jenis_pengajuan']) && $surat['jenis_pengajuan'] == 'Perorangan') ? 'selected' : '' ?>>Perorangan</option>
                        <option value="Kelompok" <?= (isset($surat['jenis_pengajuan']) && $surat['jenis_pengajuan'] == 'Kelompok') ? 'selected' : '' ?>>Kelompok</option>
                    </select>
                </div>

                <!-- Lingkup Penugasan -->
                <div class="form-group">
                    <label class="required-field">Lingkup Penugasan</label>
                    <select name="lingkup_penugasan" id="lingkup_penugasan" class="form-control" required>
                        <option value="" disabled>Pilih Lingkup Penugasan</option>
                        <option value="Dosen" <?= (isset($surat['lingkup_penugasan']) && $surat['lingkup_penugasan'] == 'Dosen') ? 'selected' : '' ?>>Dosen</option>
                        <option value="TPA" <?= (isset($surat['lingkup_penugasan']) && $surat['lingkup_penugasan'] == 'TPA') ? 'selected' : '' ?>>TPA</option>
                        <option value="Dosen dan TPA" <?= (isset($surat['lingkup_penugasan']) && $surat['lingkup_penugasan'] == 'Dosen dan TPA') ? 'selected' : '' ?>>Dosen dan TPA</option>
                    </select>
                </div>

                <!-- Jenis Penugasan Perorangan -->
                <div id="jenis_penugasan_perorangan_container" style="<?= (isset($surat['jenis_pengajuan']) && $surat['jenis_pengajuan'] == 'Perorangan') ? '' : 'display:none;'; ?>">
                    <div class="form-group">
                        <label class="required-field">Jenis Penugasan (Perorangan)</label>
                        <select name="jenis_penugasan_perorangan" id="jenis_penugasan_perorangan" class="form-control" required>
                            <option value="" disabled>Pilih Jenis Penugasan</option>
                            <?php 
                            $opsi_per = ["Juri", "Pembicara", "Narasumber", "Penugasan Lainnya"];
                            foreach ($opsi_per as $o) {
                                $selected = (isset($surat['jenis_penugasan_perorangan']) && $surat['jenis_penugasan_perorangan'] == $o) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($o) . '" ' . $selected . '>' . htmlspecialchars($o) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group" id="penugasan_lainnya_perorangan_container" style="<?= (isset($surat['jenis_penugasan_perorangan']) && $surat['jenis_penugasan_perorangan'] == 'Penugasan Lainnya') ? '' : 'display:none;'; ?>">
                        <label class="required-field">Isi Penugasan Lainnya</label>
                        <input type="text" name="penugasan_lainnya_perorangan" id="penugasan_lainnya_perorangan" 
                               class="form-control" value="<?= htmlspecialchars($surat['penugasan_lainnya_perorangan'] ?? ''); ?>" required>
                    </div>
                </div>

                <!-- Jenis Penugasan Kelompok -->
                <div id="jenis_penugasan_kelompok_container" style="<?= (isset($surat['jenis_pengajuan']) && $surat['jenis_pengajuan'] == 'Kelompok') ? '' : 'display:none;'; ?>">
                    <div class="form-group">
                        <label class="required-field">Jenis Penugasan (Kelompok)</label>
                        <select name="jenis_penugasan_kelompok" id="jenis_penugasan_kelompok" class="form-control" required>
                            <option value="" disabled>Pilih Jenis Penugasan</option>
                            <?php 
                            $opsi_kel = ["Tim", "Kepanitiaan", "Penugasan Lainnya"];
                            foreach ($opsi_kel as $o) {
                                $selected = (isset($surat['jenis_penugasan_kelompok']) && $surat['jenis_penugasan_kelompok'] == $o) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($o) . '" ' . $selected . '>' . htmlspecialchars($o) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group" id="penugasan_lainnya_kelompok_container" style="<?= (isset($surat['jenis_penugasan_kelompok']) && $surat['jenis_penugasan_kelompok'] == 'Penugasan Lainnya') ? '' : 'display:none;'; ?>">
                        <label class="required-field">Isi Penugasan Lainnya</label>
                        <input type="text" name="penugasan_lainnya_kelompok" id="penugasan_lainnya_kelompok" 
                               class="form-control" value="<?= htmlspecialchars($surat['penugasan_lainnya_kelompok'] ?? ''); ?>" required>
                    </div>
                </div>
            </div>

            <!-- Dosen Terkait Section -->
            <div class="form-section">
                <h5><i class="fas fa-users"></i> Dosen Terkait</h5>
                
                <div class="table-responsive">
                    <table class="table-dosen">
                        <thead>
                            <tr>
                                <th>NIP <small class="required-field">*</small></th>
                                <th>Nama Dosen <small class="required-field">*</small></th>
                                <th>Jabatan</th>
                                <th>Divisi</th>
                                <th class="peran-column" style="<?= (isset($surat['jenis_pengajuan']) && $surat['jenis_pengajuan'] == 'Kelompok') ? '' : 'display:none;' ?>">Peran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="dosenTableBody">
                            <?php if (!empty($dosen_data)): ?>
                                <?php foreach ($dosen_data as $index => $dosen): ?>
                                    <?php
                                    // Parse data jabatan dan peran dari column peran
                                    $peran_data = null;
                                    $jabatan_value = $dosen['jabatan'] ?? '-';
                                    $peran_value = '-';
                                    
                                    // Cek apakah ada data peran yang tersimpan
                                    if (isset($dosen['peran']) && $dosen['peran'] !== '-') {
                                        // Jika peran adalah JSON object dengan jabatan dan peran
                                        $decoded = json_decode($dosen['peran'], true);
                                        if (is_array($decoded) && isset($decoded['jabatan'])) {
                                            $jabatan_value = $decoded['jabatan'];
                                            $peran_value = $decoded['peran'] ?? '-';
                                        } else {
                                            // Fallback: jika hanya string biasa (data lama)
                                            $peran_value = $dosen['peran'];
                                        }
                                    }
                                    ?>
                                    <tr class="dosen-row" data-index="<?= $index ?>">
                                        <td>
                                            <!-- NIP BISA DIEDIT DENGAN AUTOCOMPLETE -->
                                            <input type="text" 
                                                   name="nip[]" 
                                                   value="<?= htmlspecialchars($dosen['nip']) ?>" 
                                                   class="form-control form-control-sm nip-input" 
                                                   data-index="<?= $index ?>"
                                                   placeholder="Ketik NIP (opsional)"
                                                   >
                                        </td>
                                        <td>
                                            <!-- NAMA DOSEN BISA DIEDIT DENGAN AUTOCOMPLETE -->
                                            <input type="text" 
                                                   name="nama_dosen[]" 
                                                   value="<?= htmlspecialchars($dosen['nama']) ?>" 
                                                   class="form-control form-control-sm nama-dosen-input" 
                                                   placeholder="Ketik Nama Dosen (opsional)"
                                                  >
                                        </td>
                                        <td>
                                            <!-- JABATAN BISA DIEDIT DENGAN AUTOCOMPLETE -->
                                            <input type="text" 
                                                   name="jabatan[]" 
                                                   value="<?= htmlspecialchars($jabatan_value) ?>" 
                                                   class="form-control form-control-sm jabatan-input" 
                                                   placeholder="Contoh: Lektor (opsional)"
                                                   >
                                        </td>
                                        <td>
                                            <!-- DIVISI BISA DIEDIT DENGAN AUTOCOMPLETE -->
                                            <input type="text" 
                                                   name="divisi[]" 
                                                   value="<?= htmlspecialchars($dosen['divisi']) ?>" 
                                                   class="form-control form-control-sm divisi-input" 
                                                   placeholder="Contoh: DI (opsional)"
                                                   >
                                        </td>
                                        <td>
                                            <!-- PERAN BISA DIEDIT -->
                                            <input type="text" 
                                                   name="peran[]" 
                                                   value="<?= htmlspecialchars($peran_value) ?>" 
                                                   class="form-control form-control-sm peran-input" 
                                                   placeholder="Contoh: Ketua Tim (opsional)"
                                                   >
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm btn-remove-dosen" onclick="removeDosen(this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada dosen terkait (opsional)</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <button type="button" class="btn-add-dosen" onclick="addDosenRow()">
                    <i class="fas fa-plus"></i> Tambah Dosen
                </button>
            </div>

            <!-- File Eviden -->
            <div class="form-section">
                <h5><i class="fas fa-file-alt"></i> File Eviden</h5>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 10px; color: #333;">
                        <i class="fas fa-cloud-upload-alt"></i> Upload File Eviden
                    </label>
                    <p style="font-size: 13px; color: #6c757d; margin-bottom: 15px;">
                        Anda dapat menambah atau menghapus file eviden yang sudah diupload.
                    </p>
                    
                    <!-- Validation Message -->
                    <div id="validation-message" class="validation-message" style="display: none;">
                        <i class="fas fa-exclamation-circle"></i> <span id="validation-text"></span>
                    </div>
                </div>

                <!-- Existing Files Display -->
                <div id="existing-files-container">
                    <?php
                    $existing_files = [];
                    if (!empty($eviden) && is_array($eviden)) {
                        foreach ($eviden as $file) {
                            if (is_string($file) && trim($file) !== '') {
                                $existing_files[] = $file;
                            } elseif (is_array($file)) {
                                // Handle array format
                                foreach ($file as $f) {
                                    if (is_string($f) && trim($f) !== '') {
                                        $existing_files[] = $f;
                                    }
                                }
                            }
                        }
                    }
                    ?>
                    <input type="hidden" name="existing_eviden_json" id="existing_eviden_json" 
                           value="<?= htmlspecialchars(json_encode($existing_files)) ?>">
                </div>

                <!-- Upload Section -->
                <div style="margin-bottom: 20px;">
                    <button type="button" id="upload-btn" class="btn btn-primary" 
                            style="padding: 10px 20px; border-radius: 8px; background: #FF8C00; border: none; color: white; cursor: pointer; font-weight: 500; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fas fa-plus-circle"></i> Tambah File Baru
                    </button>
                    <span id="file-count-indicator" style="margin-left: 15px; font-size: 14px; color: #6c757d;">
                        <i class="fas fa-file"></i> <span id="current-file-count"><?= count($existing_files) ?></span> file tersedia
                    </span>
                </div>

                <!-- Uploadcare Panel -->
                <div id="eviden-panel"></div>

                <!-- Hidden input untuk simpan URL -->
                <input type="hidden" name="eviden" id="eviden" value="<?= htmlspecialchars(json_encode($existing_files)) ?>">
                
                <!-- Display uploaded files -->
                <div id="uploaded-files-display" style="<?= count($existing_files) > 0 ? '' : 'display:none;' ?>">
                    <div style="background: #f8f9fa; border-radius: 8px; padding: 15px; border: 1px solid #dee2e6;">
                        <h6 style="font-weight: 600; margin-bottom: 10px; color: #495057;">
                            <i class="fas fa-check-circle" style="color: #28a745;"></i> File yang sudah diupload (<span id="total-files"><?= count($existing_files) ?></span>):
                        </h6>
                        <div id="files-list">
                            <?php foreach ($existing_files as $index => $url): ?>
                                <?php
                                $filename = basename(parse_url($url, PHP_URL_PATH) ?: $url);
                                $filename = htmlspecialchars($filename);
                                ?>
                                <div class="file-item" data-index="<?= $index ?>">
                                    <div class="file-icon">
                                        <?= getFileIcon($url) ?>
                                    </div>
                                    <div class="file-info">
                                        <div class="file-name"><?= $filename ?></div>
                                        <div class="file-url"><?= htmlspecialchars($url) ?></div>
                                    </div>
                                    <div style="display: flex; gap: 5px;">
                                        <button type="button" onclick="previewFile('<?= htmlspecialchars($url) ?>', '<?= $filename ?>')" class="btn-view">
                                            <i class="fas fa-eye"></i> Lihat
                                        </button>
                                        <button type="button" onclick="removeFile(<?= $index ?>)" class="btn-remove">
                                            <i class="fas fa-times"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Upload Progress -->
                <div id="upload-progress" style="display: none; margin-top: 20px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="flex: 1; background-color: #e9ecef; height: 8px; border-radius: 4px; overflow: hidden;">
                            <div id="progress-bar" style="width: 0%; height: 100%; background-color: #28a745; transition: width 0.3s ease;"></div>
                        </div>
                        <span id="progress-text" style="font-size: 12px; color: #6c757d;">0%</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="form-section">
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="<?= base_url('sekretariat') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke List Surat
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Preview File -->
    <div id="file-preview-modal" class="file-preview-modal">
        <div class="modal-content-fullscreen" style="width: 100%; height: 100%; display: flex; flex-direction: column; background: #202124;">
            <!-- Header -->
            <div class="pdf-viewer-header">
                <div class="pdf-header-left" style="display: flex; align-items: center; gap: 15px; flex: 1; min-width: 0;">
                    <button type="button" class="header-icon-btn" onclick="closePreviewModal()" title="Close" 
                            style="background: transparent; border: none; color: white; width: 40px; height: 40px; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s; font-size: 18px;">
                        <i class="fas fa-times"></i>
                    </button>
                    <span class="pdf-title" id="modal-file-title" style="font-size: 16px; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: white;">Preview: document.pdf</span>
                </div>
                <div class="pdf-header-right" style="display: flex; gap: 5px; align-items: center;">
                    <a id="btn-download-file" href="#" target="_blank" download class="header-icon-btn" title="Download" 
                       style="background: transparent; border: none; color: white; width: 40px; height: 40px; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s; font-size: 18px; text-decoration: none;">
                        <i class="fas fa-download"></i>
                    </a>
                </div>
            </div>

            <!-- Content Area -->
            <div class="pdf-viewer-body">
                <div id="preview-content" class="preview-container" style="width: 100%; max-width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100%;">
                    <div class="loading-spinner" style="border: 4px solid rgba(255, 255, 255, 0.3); border-top: 4px solid white; border-radius: 50%; width: 50px; height: 50px; animation: spin 1s linear infinite; margin: 100px auto;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        UPLOADCARE_PUBLIC_KEY = "3438a2ee1b7dd183914c";
    </script>
    <script src="https://ucarecdn.com/libs/widget/3.x/uploadcare.full.min.js"></script>
    
    <?php
    // Helper function untuk icon file
    function getFileIcon($url) {
        $ext = pathinfo(parse_url($url, PHP_URL_PATH) ?: $url, PATHINFO_EXTENSION);
        $ext = strtolower($ext ?: '');
        
        $icons = [
            'jpg' => 'fa-file-image',
            'jpeg' => 'fa-file-image',
            'png' => 'fa-file-image',
            'gif' => 'fa-file-image',
            'webp' => 'fa-file-image',
            'svg' => 'fa-file-image',
            'pdf' => 'fa-file-pdf',
            'doc' => 'fa-file-word',
            'docx' => 'fa-file-word',
            'xls' => 'fa-file-excel',
            'xlsx' => 'fa-file-excel',
            'zip' => 'fa-file-archive',
            'rar' => 'fa-file-archive',
            '7z' => 'fa-file-archive'
        ];
        
        $icon = $icons[$ext] ?? 'fa-file-alt';
        return '<i class="fas ' . $icon . '" style="font-size: 20px; color: #FF8C00;"></i>';
    }
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ========================================
            // 1. TANGGAL KEGIATAN FUNCTIONALITY
            // ========================================
            
            // Variabel untuk menyimpan tanggal awal yang dipilih
            let selectedStartDate = null;
            const MAX_DAYS_LIMIT = 60;

            // Fungsi untuk menghitung tanggal 30 hari yang lalu dari hari ini
            function getMinAllowedDate() {
                const today = new Date();
                const minDate = new Date(today);
                minDate.setDate(today.getDate() - 30);
                return minDate;
            }

            // Fungsi untuk format tanggal ke format Indonesia
            function formatDateIndonesian(date) {
                const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                               'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                
                const dayName = days[date.getDay()];
                const day = date.getDate();
                const month = months[date.getMonth()];
                const year = date.getFullYear();
                
                return `${dayName}, ${day} ${month} ${year}`;
            }

            // Fungsi untuk format tanggal ke YYYY-MM-DD
            function formatDateLocal(date) {
                const y = date.getFullYear();
                const m = (date.getMonth() + 1).toString().padStart(2, "0");
                const d = date.getDate().toString().padStart(2, "0");
                return `${y}-${m}-${d}`;
            }

            // Fungsi untuk menghitung selisih hari antara dua tanggal
            function calculateDayDifference(startDate, endDate) {
                const oneDay = 24 * 60 * 60 * 1000;
                const diffDays = Math.round(Math.abs((endDate - startDate) / oneDay));
                return diffDays;
            }

            // Set initial dates jika ada
            const tanggalAwal = document.getElementById('tanggal_awal_kegiatan').value;
            const tanggalAkhir = document.getElementById('tanggal_akhir_kegiatan').value;
            let initialDate = [];
            
            if (tanggalAwal && tanggalAkhir) {
                initialDate = [tanggalAwal, tanggalAkhir];
                
                // Set value pada datepicker
                document.getElementById('datepicker').value = `${tanggalAwal} s/d ${tanggalAkhir}`;
                
                // Tampilkan konfirmasi tanggal
                const konfirmasiDiv = document.getElementById("konfirmasi_tanggal");
                const dayCounter = document.getElementById("day_counter");
                const rangeInfo = document.getElementById("range_info");
                
                const awal = new Date(tanggalAwal);
                const akhir = new Date(tanggalAkhir);
                const dayDifference = calculateDayDifference(awal, akhir);
                
                dayCounter.textContent = `${dayDifference} hari`;
                document.getElementById("konfirmasi_awal").innerHTML = `<strong>Awal:</strong> ${formatDateIndonesian(awal)}`;
                document.getElementById("konfirmasi_akhir").innerHTML = `<strong>Akhir:</strong> ${formatDateIndonesian(akhir)}`;
                konfirmasiDiv.style.display = 'block';
                rangeInfo.style.display = 'none';
                
                // Auto-fill tanggal penugasan
                document.getElementById("datepicker3").value = tanggalAwal;
                document.getElementById("datepicker4").value = tanggalAkhir;
                document.getElementById("info_periode").innerHTML = "Terisi otomatis ✓";
                document.getElementById("info_akhir").innerHTML = "Terisi otomatis ✓";
                
                // Tambahkan efek visual
                document.getElementById("datepicker3").classList.add("auto-filled");
                document.getElementById("datepicker4").classList.add("auto-filled");
            }
            // Inisialisasi flatpickr
            const minAllowedDate = getMinAllowedDate();
            
            const datepicker = flatpickr("#datepicker", {
                mode: "range",
                dateFormat: "Y-m-d",
                allowInput: false,
                minDate: minAllowedDate,
                locale: {
                    firstDayOfWeek: 1
                },
                defaultDate: initialDate,
                onChange: function(selectedDates, dateStr, instance) {
                    const konfirmasiDiv = document.getElementById("konfirmasi_tanggal");
                    const dayCounter = document.getElementById("day_counter");
                    const rangeInfo = document.getElementById("range_info");
                    const dayLimitInfo = document.getElementById("day_limit_info");
                    
                    // Tampilkan/sembunyikan info batas hari
                    if (selectedDates.length === 1) {
                        dayLimitInfo.style.display = 'block';
                        selectedStartDate = selectedDates[0];
                    } else {
                        dayLimitInfo.style.display = 'none';
                        selectedStartDate = null;
                    }
                    
                    if (selectedDates.length === 2) {
                        const awal = selectedDates[0];
                        const akhir = selectedDates[1];
                        const dayDifference = calculateDayDifference(awal, akhir);
                        
                        // Simpan tanggal awal untuk kalkulasi
                        selectedStartDate = awal;
                        
                        // Format untuk hidden inputs
                        const awalFormatted = formatDateLocal(awal);
                        const akhirFormatted = formatDateLocal(akhir);
                        
                        // Format untuk display
                        const awalDisplay = formatDateIndonesian(awal);
                        const akhirDisplay = formatDateIndonesian(akhir);
                        
                        // Set hidden inputs
                        document.getElementById("tanggal_awal_kegiatan").value = awalFormatted;
                        document.getElementById("tanggal_akhir_kegiatan").value = akhirFormatted;
                        
                        // Set auto-filled inputs
                        document.getElementById("datepicker3").value = awalFormatted;
                        document.getElementById("datepicker4").value = akhirFormatted;
                        
                        // Update day counter
                        dayCounter.textContent = `${dayDifference} hari`;
                        
                        // Tampilkan konfirmasi tanggal
                        document.getElementById("konfirmasi_awal").innerHTML = `<strong>Awal:</strong> ${awalDisplay}`;
                        document.getElementById("konfirmasi_akhir").innerHTML = `<strong>Akhir:</strong> ${akhirDisplay}`;
                        konfirmasiDiv.style.display = 'block';
                        rangeInfo.style.display = 'none';
                        dayLimitInfo.style.display = 'none';
                        
                        // Update info messages
                        document.getElementById("info_periode").innerHTML = "Terisi otomatis ✓";
                        document.getElementById("info_akhir").innerHTML = "Terisi otomatis ✓";
                        
                        // Tambahkan efek visual
                        document.getElementById("datepicker3").classList.add("auto-filled", "highlight-animation");
                        document.getElementById("datepicker4").classList.add("auto-filled", "highlight-animation");
                        
                        // Hapus animasi setelah selesai
                        setTimeout(() => {
                            document.getElementById("datepicker3").classList.remove("highlight-animation");
                            document.getElementById("datepicker4").classList.remove("highlight-animation");
                        }, 1000);
                        
                    } else if (selectedDates.length === 1) {
                        // Jika hanya satu tanggal yang dipilih (tanggal awal)
                        const awalDisplay = formatDateIndonesian(selectedDates[0]);
                        
                        selectedStartDate = selectedDates[0];
                        document.getElementById("konfirmasi_awal").innerHTML = `<strong>Tanggal awal:</strong> ${awalDisplay}`;
                        document.getElementById("konfirmasi_akhir").innerHTML = `<strong>Tanggal akhir:</strong> Pilih tanggal akhir (maks ${MAX_DAYS_LIMIT} hari)`;
                        konfirmasiDiv.style.display = 'block';
                        dayCounter.textContent = '';
                        rangeInfo.style.display = 'none';
                        dayLimitInfo.style.display = 'block';
                        
                        // Refresh calendar untuk update disabled dates
                        instance.redraw();
                    } else {
                        // Jika tanggal di-reset
                        selectedStartDate = null;
                        konfirmasiDiv.style.display = 'none';
                        dayCounter.textContent = '';
                        rangeInfo.style.display = 'block';
                        dayLimitInfo.style.display = 'none';
                        
                        // Reset auto-filled inputs
                        document.getElementById("datepicker3").value = "";
                        document.getElementById("datepicker4").value = "";
                        document.getElementById("info_periode").innerHTML = "Akan terisi otomatis";
                        document.getElementById("info_akhir").innerHTML = "Akan terisi otomatis";
                        
                        // Hapus class styling
                        document.getElementById("datepicker3").classList.remove("auto-filled");
                        document.getElementById("datepicker4").classList.remove("auto-filled");
                        
                        // Refresh calendar
                        instance.redraw();
                    }
                },
                onOpen: function(selectedDates, dateStr, instance) {
                    // Update info tentang batasan tanggal
                    const minDate = getMinAllowedDate();
                    const infoElement = instance._input.nextElementSibling;
                    if (infoElement && infoElement.classList.contains('info-message')) {
                        infoElement.innerHTML = `Tidak bisa memilih tanggal sebelum ${formatDateIndonesian(minDate)}<br>Maksimal ${MAX_DAYS_LIMIT} hari dari tanggal awal`;
                    }
                    
                    // Jika sudah memilih tanggal awal, tampilkan info
                    if (selectedDates.length === 1) {
                        const dayLimitInfo = document.getElementById("day_limit_info");
                        if (dayLimitInfo) {
                            dayLimitInfo.style.display = 'block';
                        }
                    }
                },
                onClose: function(selectedDates, dateStr, instance) {
                    // Sembunyikan info batas hari saat calendar ditutup
                    const dayLimitInfo = document.getElementById("day_limit_info");
                    if (dayLimitInfo) {
                        dayLimitInfo.style.display = 'none';
                    }
                    
                    // Jika hanya memilih satu tanggal (awal), jangan reset
                    if (selectedDates.length === 1) {
                        selectedStartDate = selectedDates[0];
                    } else if (selectedDates.length === 0) {
                        selectedStartDate = null;
                    }
                }
            });

            // Inisialisasi datepicker untuk input lainnya
            flatpickr("#datepicker3", {
                dateFormat: "Y-m-d",
                allowInput: false
            });

            flatpickr("#datepicker4", {
                dateFormat: "Y-m-d",
                allowInput: false
            });

            // Handler untuk dropdown jenis tanggal
            document.getElementById("jenis_date").addEventListener("change", function () {
                const customSection = document.getElementById("custom_date_section");
                const periodeSection = document.getElementById("periode_date_section");
                
                const isCustom = this.value === "Custom";
                const isPeriode = this.value === "Periode";
                
                customSection.classList.toggle('active', isCustom);
                periodeSection.classList.toggle('active', isPeriode);
                
                // Jika memilih Custom, reset tanggal dan tampilkan info batas 60 hari
                if (isCustom) {
                    // Tampilkan info awal
                    const rangeInfo = document.getElementById("range_info");
                    if (rangeInfo) {
                        const minDate = getMinAllowedDate();
                        rangeInfo.innerHTML = `Klik tanggal awal, lalu klik tanggal akhir (opsional)<br>
                                              <small style="color: #666;">• Tidak bisa memilih tanggal sebelum ${formatDateIndonesian(minDate)}</small><br>
                                              <small style="color: #666;">• Maksimal ${MAX_DAYS_LIMIT} hari dari tanggal awal</small>`;
                    }
                }
            });

            // Tambahkan info batasan tanggal di halaman load
            const rangeInfo = document.getElementById("range_info");
            const dayLimitInfo = document.getElementById("day_limit_info");
            
            if (rangeInfo) {
                const minDate = getMinAllowedDate();
                rangeInfo.innerHTML = `Klik tanggal awal, lalu klik tanggal akhir (opsional)<br>
                                      <small style="color: #666;">• Tidak bisa memilih tanggal sebelum ${formatDateIndonesian(minDate)}</small><br>
                                      <small style="color: #666;">• Maksimal ${MAX_DAYS_LIMIT} hari dari tanggal awal</small>`;
            }
            
            if (dayLimitInfo) {
                dayLimitInfo.innerHTML = `<i class="fas fa-info-circle"></i> Maksimal ${MAX_DAYS_LIMIT} hari dari tanggal awal`;
            }

            // ========================================
            // 2. JENIS PENGAJUAN FUNCTIONALITY
            // ========================================
            
            // Toggle jenis penugasan
            document.getElementById('jenis_pengajuan').addEventListener('change', function() {
                const isPerorangan = this.value === 'Perorangan';
                const isKelompok = this.value === 'Kelompok';
                
                document.getElementById('jenis_penugasan_perorangan_container').style.display = 
                    isPerorangan ? 'block' : 'none';
                document.getElementById('jenis_penugasan_kelompok_container').style.display = 
                    isKelompok ? 'block' : 'none';
                
                // Toggle kolom peran
                togglePeranColumn(isKelompok);
            });

            // Function untuk toggle kolom peran
            function togglePeranColumn(show) {
                const peranColumns = document.querySelectorAll('.peran-column');
                peranColumns.forEach(col => {
                    col.style.display = show ? '' : 'none';
                });
                
                // Clear peran values if switching to Perorangan
                if (!show) {
                    document.querySelectorAll('.peran-input').forEach(input => {
                        input.value = '';
                    });
                }
            }

            // Initialize peran column berdasarkan jenis pengajuan saat load
            const initialJenisPengajuan = document.getElementById('jenis_pengajuan').value;
            togglePeranColumn(initialJenisPengajuan === 'Kelompok');

            // Handle "Lainnya" option untuk penugasan perorangan
            document.getElementById('jenis_penugasan_perorangan')?.addEventListener('change', function() {
                const lainnyaContainer = document.getElementById('penugasan_lainnya_perorangan_container');
                if (lainnyaContainer) {
                    lainnyaContainer.style.display = this.value === 'Penugasan Lainnya' ? 'block' : 'none';
                    if (this.value !== 'Penugasan Lainnya') {
                        document.getElementById('penugasan_lainnya_perorangan').value = '';
                    }
                }
            });

            // Handle "Lainnya" option untuk penugasan kelompok
            document.getElementById('jenis_penugasan_kelompok')?.addEventListener('change', function() {
                const lainnyaContainer = document.getElementById('penugasan_lainnya_kelompok_container');
                if (lainnyaContainer) {
                    lainnyaContainer.style.display = this.value === 'Penugasan Lainnya' ? 'block' : 'none';
                    if (this.value !== 'Penugasan Lainnya') {
                        document.getElementById('penugasan_lainnya_kelompok').value = '';
                    }
                }
            });

            // Trigger change on load
            document.getElementById('jenis_pengajuan').dispatchEvent(new Event('change'));

            // ========================================
            // 3. DOSEN TERKAIT FUNCTIONALITY
            // ========================================
            
            // Fungsi untuk menambah baris dosen baru
            window.addDosenRow = function() {
                const tbody = document.getElementById('dosenTableBody');
                const index = tbody.querySelectorAll('tr.dosen-row').length;
                const isKelompok = document.getElementById('jenis_pengajuan').value === 'Kelompok';
                
                // Hapus row "Belum ada dosen" jika ada
                const emptyRow = tbody.querySelector('tr td[colspan="6"]');
                if (emptyRow) {
                    emptyRow.closest('tr').remove();
                }
                
                const newRow = document.createElement('tr');
                newRow.className = 'dosen-row';
                newRow.dataset.index = index;
                newRow.innerHTML = `
                    <td>
                        <input type="text" 
                               name="nip[]" 
                               class="form-control form-control-sm nip-input" 
                               data-index="${index}"
                               placeholder="Ketik NIP"
                               required
                               style="border: 2px solid #FF8C00; background: #fff3e0;">
                    </td>
                    <td>
                        <input type="text" 
                               name="nama_dosen[]" 
                               class="form-control form-control-sm nama-dosen-input" 
                               placeholder="Ketik Nama Dosen"
                               required
                               style="border: 2px solid #FF8C00; background: #fff3e0;">
                    </td>
                    <td>
                        <input type="text" 
                               name="jabatan[]" 
                               class="form-control form-control-sm jabatan-input" 
                               placeholder="Contoh: Lektor"
                               style="border: 2px solid #FF8C00; background: #fff3e0;">
                    </td>
                    <td>
                        <input type="text" 
                               name="divisi[]" 
                               class="form-control form-control-sm divisi-input" 
                               placeholder="Contoh: DI"
                               style="border: 2px solid #FF8C00; background: #fff3e0;">
                    </td>
                    <td class="peran-column" style="${isKelompok ? '' : 'display:none;'}">
                        <input type="text" 
                               name="peran[]" 
                               class="form-control form-control-sm peran-input" 
                               placeholder="Ketua/Anggota/dll"
                               style="border: 2px solid #FF8C00; background: #fff3e0;">
                    </td>
                    <td>
                        <button type="button" class="btn-remove-dosen" onclick="removeDosen(this)">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </td>
                `;
                
                tbody.appendChild(newRow);
                
                // Initialize autocomplete untuk row baru
                setTimeout(() => {
                    initAutocompleteForRow(newRow);
                    
                    // Animasi
                    newRow.style.opacity = '0';
                    newRow.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        newRow.style.transition = 'all 0.3s ease';
                        newRow.style.opacity = '1';
                        newRow.style.transform = 'translateY(0)';
                    }, 10);
                }, 10);
            };

            // Fungsi untuk menghapus baris dosen
            window.removeDosen = function(button) {
                const row = button.closest('tr');
                const tbody = document.getElementById('dosenTableBody');
                
                // Animasi fade out
                row.style.opacity = '0';
                row.style.transform = 'translateX(20px)';
                
                setTimeout(() => {
                    row.remove();
                    
                    // Jika tidak ada row tersisa, tambahkan placeholder
                    if (tbody.querySelectorAll('tr.dosen-row').length === 0) {
                        const emptyRow = document.createElement('tr');
                        emptyRow.innerHTML = '<td colspan="6" class="text-center text-muted">Belum ada dosen terkait</td>';
                        tbody.appendChild(emptyRow);
                    }
                }, 300);
            };

            // ========================================
            // 4. FILE EVIDEN FUNCTIONALITY
            // ========================================
            
            const evidenInput = document.getElementById("eviden");
            const uploadedDisplay = document.getElementById("uploaded-files-display");
            const filesList = document.getElementById("files-list");
            const uploadBtn = document.getElementById("upload-btn");
            const evidenPanel = document.getElementById("eviden-panel");
            const totalFilesSpan = document.getElementById("total-files");
            const validationMessage = document.getElementById("validation-message");
            const validationText = document.getElementById("validation-text");
            const currentFileCount = document.getElementById("current-file-count");
            const uploadProgress = document.getElementById("upload-progress");
            const progressBar = document.getElementById("progress-bar");
            const progressText = document.getElementById("progress-text");
            
            // Parse existing files
            let uploadedFiles = [];
            try {
                const existingJson = document.getElementById('existing_eviden_json').value;
                if (existingJson) {
                    uploadedFiles = JSON.parse(existingJson);
                }
            } catch (e) {
                console.error('Error parsing existing files:', e);
            }
            
            let currentPanel = null;
            let isUploading = false;

            // Update button state
            function updateButtonState() {
                const fileCount = uploadedFiles.length;
                currentFileCount.textContent = fileCount;
                totalFilesSpan.textContent = fileCount;
                
                if (fileCount > 0) {
                    uploadedDisplay.style.display = 'block';
                    validationText.textContent = `${fileCount} file telah diupload.`;
                    validationMessage.className = "validation-message info";
                    validationMessage.style.display = 'flex';
                } else {
                    uploadedDisplay.style.display = 'none';
                    validationText.textContent = "Belum ada file diupload.";
                    validationMessage.className = "validation-message info";
                    validationMessage.style.display = 'flex';
                }
                
                // Update hidden input
                evidenInput.value = JSON.stringify(uploadedFiles);
            }

            // Initialize
            updateButtonState();

            // Function to get file icon HTML
            function getFileIconHtml(url) {
                const ext = url.split('.').pop().toLowerCase().split('?')[0];
                
                if (['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'].includes(ext)) {
                    return '<i class="fas fa-file-image" style="font-size: 20px; color: #17a2b8;"></i>';
                } else if (['pdf'].includes(ext)) {
                    return '<i class="fas fa-file-pdf" style="font-size: 20px; color: #dc3545;"></i>';
                } else if (['doc', 'docx'].includes(ext)) {
                    return '<i class="fas fa-file-word" style="font-size: 20px; color: #2b579a;"></i>';
                } else if (['xls', 'xlsx'].includes(ext)) {
                    return '<i class="fas fa-file-excel" style="font-size: 20px; color: #217346;"></i>';
                } else if (['zip', 'rar', '7z'].includes(ext)) {
                    return '<i class="fas fa-file-archive" style="font-size: 20px; color: #ffc107;"></i>';
                } else {
                    return '<i class="fas fa-file-alt" style="font-size: 20px; color: #6c757d;"></i>';
                }
            }

            // Function to remove file
            window.removeFile = function(index) {
                if (confirm('Apakah Anda yakin ingin menghapus file ini?')) {
                    uploadedFiles.splice(index, 1);
                    updateButtonState();
                    
                    // Update display
                    filesList.innerHTML = '';
                    uploadedFiles.forEach((url, idx) => {
                        const filename = url.split('/').pop().split('?')[0];
                        filesList.innerHTML += `
                            <div class="file-item" data-index="${idx}">
                                <div class="file-icon">
                                    ${getFileIconHtml(url)}
                                </div>
                                <div class="file-info">
                                    <div class="file-name">${filename}</div>
                                    <div class="file-url">${url}</div>
                                </div>
                                <div style="display: flex; gap: 5px;">
                                    <button type="button" onclick="previewFile('${url}', '${filename}')" class="btn-view">
                                        <i class="fas fa-eye"></i> Lihat
                                    </button>
                                    <button type="button" onclick="removeFile(${idx})" class="btn-remove">
                                        <i class="fas fa-times"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        `;
                    });
                }
            };

            // Open upload panel
            function openUploadPanel() {
                if (isUploading) {
                    alert("Mohon tunggu, proses upload sedang berlangsung...");
                    return;
                }
                
                if (currentPanel) {
                    try {
                        currentPanel.reject();
                    } catch (e) {
                        console.log("Panel sudah tertutup");
                    }
                }

                evidenPanel.style.display = 'block';
                evidenPanel.innerHTML = '';

                currentPanel = uploadcare.openPanel('#eviden-panel', null, {
                    multiple: true,
                    multipleMax: 10,
                    multipleMin: 1,
                    previewStep: true,
                    tabs: "file url camera dropbox gdrive",
                    publicKey: "3438a2ee1b7dd183914c",
                    imagesOnly: false,
                    clearable: true
                });

                // Handle upload completion
                currentPanel.done(function (fileGroup) {
                    isUploading = true;
                    uploadProgress.style.display = 'block';
                    progressBar.style.width = '0%';
                    progressText.textContent = '0%';
                    
                    const files = fileGroup.files();
                    const totalFiles = files.length;
                    let processedFiles = 0;
                    
                    files.forEach((filePromise, index) => {
                        filePromise.done(fileInfo => {
                            uploadedFiles.push(fileInfo.cdnUrl);
                            
                            processedFiles++;
                            const progressPercent = Math.round((processedFiles / totalFiles) * 100);
                            progressBar.style.width = progressPercent + '%';
                            progressText.textContent = progressPercent + '%';
                            
                            if (processedFiles === totalFiles) {
                                updateButtonState();
                                
                                // Update display
                                filesList.innerHTML = '';
                                uploadedFiles.forEach((url, idx) => {
                                    const filename = url.split('/').pop().split('?')[0];
                                    filesList.innerHTML += `
                                        <div class="file-item" data-index="${idx}">
                                            <div class="file-icon">
                                                ${getFileIconHtml(url)}
                                            </div>
                                            <div class="file-info">
                                                <div class="file-name">${filename}</div>
                                                <div class="file-url">${url}</div>
                                            </div>
                                            <div style="display: flex; gap: 5px;">
                                                <button type="button" onclick="previewFile('${url}', '${filename}')" class="btn-view">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </button>
                                                <button type="button" onclick="removeFile(${idx})" class="btn-remove">
                                                    <i class="fas fa-times"></i> Hapus
                                                </button>
                                            </div>
                                        </div>
                                    `;
                                });
                                
                                setTimeout(() => {
                                    uploadProgress.style.display = 'none';
                                    isUploading = false;
                                }, 500);
                                
                                validationText.textContent = `✓ ${totalFiles} file berhasil ditambahkan!`;
                                validationMessage.className = "validation-message success";
                                validationMessage.style.display = 'flex';
                            }
                        }).fail(function(error) {
                            console.error("Error uploading file:", error);
                            processedFiles++;
                            
                            const progressPercent = Math.round((processedFiles / totalFiles) * 100);
                            progressBar.style.width = progressPercent + '%';
                            progressText.textContent = progressPercent + '%';
                            
                            if (processedFiles === totalFiles) {
                                updateButtonState();
                                setTimeout(() => {
                                    uploadProgress.style.display = 'none';
                                    isUploading = false;
                                }, 500);
                            }
                        });
                    });

                    setTimeout(() => {
                        evidenPanel.style.display = 'none';
                        evidenPanel.innerHTML = '';
                    }, 500);
                });

                // Handle cancel
                currentPanel.fail(function() {
                    evidenPanel.style.display = 'none';
                    evidenPanel.innerHTML = '';
                    isUploading = false;
                });
            }

            // Event listener untuk tombol upload
            uploadBtn.addEventListener('click', function(e) {
                e.preventDefault();
                openUploadPanel();
            });

            // ========================================
            // 5. AUTOCOMPLETE FUNCTIONALITY UNTUK DOSEN
            // ========================================
            
            const BASE_URL = '<?= rtrim(base_url(), "/") ?>';
            
            let currentAutocompleteBox = null;
            let currentKeydownHandler = null;
            let currentClickHandler = null;
            let currentInputElement = null;
            let currentAutocompleteItems = [];
            let isSelectingAutocomplete = false;

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
                return text.replace(regex, '<span style="color: #FF8C00; font-weight: bold;">$1</span>');
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
                currentAutocompleteItems = [];
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

            // Initialize autocomplete for a row
            function initAutocompleteForRow(rowEl) {
                if (!rowEl) return;
                
                const inputNip = rowEl.querySelector('.nip-input');
                const inputNama = rowEl.querySelector('.nama-dosen-input');
                const inputJabatan = rowEl.querySelector('.jabatan-input');
                const inputDivisi = rowEl.querySelector('.divisi-input');

                if (!inputNip || !inputNama) {
                    return;
                }

                function fillRowWith(item, fieldType) {
                    if (!item) return;
                    
                    isSelectingAutocomplete = true;
                    
                    // Fill all fields based on the selected item
                    if (fieldType === 'nip' || fieldType === 'nama_dosen') {
                        if (inputNip) inputNip.value = item.nip || '';
                        if (inputNama) inputNama.value = item.nama_dosen || '';
                        if (inputJabatan) inputJabatan.value = item.jabatan || '';
                        if (inputDivisi) inputDivisi.value = item.divisi || '';
                    } else if (fieldType === 'jabatan') {
                        if (inputJabatan) inputJabatan.value = item.jabatan || '';
                    } else if (fieldType === 'divisi') {
                        if (inputDivisi) inputDivisi.value = item.divisi || '';
                    }
                    
                    removeAutocompleteBox();
                    
                    setTimeout(() => {
                        isSelectingAutocomplete = false;
                    }, 300);
                }

                function createAutocompleteHandler(fieldType, inputElement) {
                    const handler = debounce(async function() {
                        if (isSelectingAutocomplete) {
                            return;
                        }
                        
                        const val = this.value.trim();
                        
                        if (val.length < 2 || document.activeElement !== this) {
                            removeAutocompleteBox();
                            return;
                        }

                        const suggestions = await fetchSuggestions(val, fieldType);
                        showSuggestionBox(inputElement, suggestions, (item) => fillRowWith(item, fieldType), fieldType);
                    }, 250);

                    if (inputElement._currentHandler) {
                        inputElement.removeEventListener('input', inputElement._currentHandler);
                    }
                    
                    inputElement._currentHandler = handler;
                    inputElement.addEventListener('input', handler);
                    
                    inputElement.addEventListener('focus', () => {
                        const val = inputElement.value.trim();
                        if (val.length >= 2) {
                            setTimeout(() => {
                                if (document.activeElement === inputElement && !isSelectingAutocomplete) {
                                    const event = new Event('input', { bubbles: true });
                                    inputElement.dispatchEvent(event);
                                }
                            }, 100);
                        }
                    });
                    
                    inputElement.addEventListener('blur', () => {
                        if (!isSelectingAutocomplete) {
                            setTimeout(() => {
                                removeAutocompleteBox();
                            }, 150);
                        }
                    });
                }

                // Create autocomplete handlers for each field
                createAutocompleteHandler('nip', inputNip);
                createAutocompleteHandler('nama_dosen', inputNama);
                createAutocompleteHandler('jabatan', inputJabatan);
                createAutocompleteHandler('divisi', inputDivisi);
            }

            // Show suggestion box
            function showSuggestionBox(inputEl, items, onSelect, fieldType) {
                removeAutocompleteBox();

                const rect = inputEl.getBoundingClientRect();
                const box = document.createElement('div');
                box.className = 'autocomplete-box-fixed';
                box.style.position = 'fixed';
                box.style.left = rect.left + 'px';
                box.style.top = (rect.bottom + 4) + 'px';
                box.style.width = Math.max(rect.width, 350) + 'px';
                box.style.background = '#fff';
                box.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';
                box.style.borderRadius = '8px';
                box.style.zIndex = '9999999';
                box.style.maxHeight = '400px';
                box.style.overflowY = 'auto';
                box.style.padding = '8px 0';

                if (!items || !items.length) {
                    const empty = document.createElement('div');
                    empty.className = 'autocomplete-empty';
                    empty.innerHTML = '<i class="fas fa-search" style="margin-right: 8px; opacity: 0.6;"></i>Tidak ada data ditemukan';
                    box.appendChild(empty);
                    document.body.appendChild(box);
                    currentAutocompleteBox = box;
                    currentInputElement = inputEl;
                    setTimeout(() => removeAutocompleteBox(), 2000);
                    return;
                }

                const query = inputEl.value.trim();
                let selectedIndex = -1;
                currentAutocompleteItems = items;

                items.forEach((item, idx) => {
                    const option = document.createElement('div');
                    option.className = `autocomplete-item type-${fieldType}`;
                    option.dataset.index = idx;
                    
                    let primaryText = '';
                    let secondaryText = '';
                    
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
                    }

                    option.innerHTML = `
                        <div style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; cursor: pointer; transition: background 0.2s;">
                            <div style="width: 20px; height: 20px; color: #FF8C00;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="font-weight: 600; color: #202124;">${primaryText || '-'}</div>
                                <div style="font-size: 12px; color: #5f6368;">${secondaryText}</div>
                            </div>
                        </div>
                    `;
                    
                    option.addEventListener('mousedown', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        onSelect(item);
                    });
                    
                    option.addEventListener('mouseenter', () => {
                        option.style.backgroundColor = '#f8f9fa';
                    });
                    
                    option.addEventListener('mouseleave', () => {
                        option.style.backgroundColor = '';
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
                        
                        opts.forEach(o => o.style.backgroundColor = '');
                        
                        if (opts[selectedIndex]) {
                            opts[selectedIndex].style.backgroundColor = '#f8f9fa';
                            opts[selectedIndex].scrollIntoView({ block: 'nearest' });
                        }
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        selectedIndex = Math.max(selectedIndex - 1, 0);
                        
                        opts.forEach(o => o.style.backgroundColor = '');
                        
                        if (opts[selectedIndex]) {
                            opts[selectedIndex].style.backgroundColor = '#f8f9fa';
                            opts[selectedIndex].scrollIntoView({ block: 'nearest' });
                        }
                    } else if (e.key === 'Enter') {
                        e.preventDefault();
                        if (selectedIndex >= 0 && opts[selectedIndex] && currentAutocompleteItems[selectedIndex]) {
                            onSelect(currentAutocompleteItems[selectedIndex]);
                        } else if (opts.length > 0 && currentAutocompleteItems[0]) {
                            onSelect(currentAutocompleteItems[0]);
                        }
                    } else if (e.key === 'Escape') {
                        removeAutocompleteBox();
                    }
                };
                
                document.addEventListener('keydown', currentKeydownHandler);

                currentClickHandler = function(ev) {
                    if (currentAutocompleteBox && !currentAutocompleteBox.contains(ev.target) && ev.target !== currentInputElement) {
                        if (!isSelectingAutocomplete) {
                            removeAutocompleteBox();
                        }
                    }
                };
                document.addEventListener('click', currentClickHandler);
            }

            // Initialize autocomplete for existing rows
            document.querySelectorAll('.dosen-row').forEach(row => {
                initAutocompleteForRow(row);
            });

            // ========================================
            // 6. FILE PREVIEW FUNCTIONALITY
            // ========================================
            
            window.previewFile = function(url, filename) {
                const modal = document.getElementById('file-preview-modal');
                const modalTitle = document.getElementById('modal-file-title');
                const previewContent = document.getElementById('preview-content');
                const downloadBtn = document.getElementById('btn-download-file');
                
                modalTitle.textContent = 'Preview: ' + filename;
                downloadBtn.href = url;
                downloadBtn.download = filename;
                
                modal.classList.add('show');
                
                previewContent.innerHTML = '<div class="loading-spinner"></div>';
                
                const ext = url.split('.').pop().toLowerCase().split('?')[0];
                
                setTimeout(() => {
                    if (['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'].includes(ext)) {
                        const img = new Image();
                        img.onload = function() {
                            previewContent.innerHTML = `
                                <img src="${url}" alt="${filename}" style="max-width: 90%; max-height: 85vh; height: auto; width: auto; border-radius: 4px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.7); background: transparent;">
                            `;
                        };
                        img.onerror = function() {
                            previewContent.innerHTML = `
                                <div style="text-align: center; padding: 60px 40px; background: #3c3f43; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4); max-width: 500px; border: 1px solid #5f6368;">
                                    <div style="font-size: 100px; margin-bottom: 25px; opacity: 0.9; color: #e8eaed;">
                                        <i class="fas fa-exclamation-triangle" style="color: #ff6b6b;"></i>
                                    </div>
                                    <div style="font-size: 20px; font-weight: 600; color: #e8eaed; margin-bottom: 12px; word-break: break-all;">Gagal Memuat Gambar</div>
                                    <p style="color: #999; font-size: 14px;">
                                        Tidak dapat menampilkan gambar ini.<br>
                                        Silakan coba download file.
                                    </p>
                                </div>
                            `;
                        };
                        img.src = url;
                    } else if (ext === 'pdf') {
                        previewContent.innerHTML = `
                            <iframe src="${url}" frameborder="0" style="width: 100%; height: calc(100vh - 120px); border: none; background: white; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);"></iframe>
                        `;
                    } else {
                        previewContent.innerHTML = `
                            <div style="text-align: center; padding: 60px 40px; background: #3c3f43; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4); max-width: 500px; border: 1px solid #5f6368;">
                                <div style="font-size: 100px; margin-bottom: 25px; opacity: 0.9; color: #e8eaed;">
                                    ${getFileIconHtml(url)}
                                </div>
                                <div style="font-size: 20px; font-weight: 600; color: #e8eaed; margin-bottom: 12px; word-break: break-all;">${filename}</div>
                                <p style="color: #999; font-size: 14px; line-height: 1.6;">
                                    Preview tidak tersedia untuk tipe file ini.<br>
                                    Klik tombol "Download" di header untuk mengunduh.
                                </p>
                                <a href="${url}" target="_blank" style="display: inline-block; margin-top: 20px; padding: 12px 24px; background: #1a73e8; color: white; text-decoration: none; border-radius: 6px; font-weight: 500; font-size: 14px; transition: all 0.2s ease; box-shadow: 0 2px 8px rgba(26, 115, 232, 0.3);">
                                    <i class="fas fa-external-link-alt"></i> Buka di Tab Baru
                                </a>
                            </div>
                        `;
                    }
                }, 300);
            };

            window.closePreviewModal = function() {
                const modal = document.getElementById('file-preview-modal');
                modal.classList.remove('show');
                
                setTimeout(() => {
                    document.getElementById('preview-content').innerHTML = '<div class="loading-spinner"></div>';
                }, 300);
            };

            // Close modal when clicking outside
            document.getElementById('file-preview-modal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closePreviewModal();
                }
            });

            // Close modal with ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const modal = document.getElementById('file-preview-modal');
                    if (modal.classList.contains('show')) {
                        closePreviewModal();
                    }
                }
            });

            // ========================================
            // 7. FORM SUBMIT VALIDATION
            // ========================================
            
            document.getElementById('editForm').addEventListener('submit', function(e) {
                // Validasi field yang required
                const namaKegiatan = document.getElementById('nama_kegiatan').value;
                if (!namaKegiatan.trim()) {
                    e.preventDefault();
                    alert('Mohon isi Nama Kegiatan');
                    document.getElementById('nama_kegiatan').focus();
                    return false;
                }
                
                const jenisPengajuan = document.getElementById('jenis_pengajuan').value;
                if (!jenisPengajuan) {
                    e.preventDefault();
                    alert('Mohon pilih Jenis Pengajuan');
                    document.getElementById('jenis_pengajuan').focus();
                    return false;
                }
                
                const lingkupPenugasan = document.getElementById('lingkup_penugasan').value;
                if (!lingkupPenugasan) {
                    e.preventDefault();
                    alert('Mohon pilih Lingkup Penugasan');
                    document.getElementById('lingkup_penugasan').focus();
                    return false;
                }
                
                // Validasi dosen
                const nipInputs = document.querySelectorAll('.nip-input');
                const namaDosenInputs = document.querySelectorAll('.nama-dosen-input');
                
                for (let i = 0; i < nipInputs.length; i++) {
                    if (!nipInputs[i].value.trim()) {
                        e.preventDefault();
                        alert('Mohon isi NIP untuk semua dosen');
                        nipInputs[i].focus();
                        return false;
                    }
                    if (!namaDosenInputs[i].value.trim()) {
                        e.preventDefault();
                        alert('Mohon isi Nama Dosen untuk semua dosen');
                        namaDosenInputs[i].focus();
                        return false;
                    }
                }
                
                return true;
            });
        });
    </script>
</body>
</html>