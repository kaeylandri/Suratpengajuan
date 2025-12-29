<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Total Pengajuan - Dashboard Sekretariat</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    /* ============================================
       STYLE DASAR (SAMA SEPERTI DASHBOARD)
    ============================================ */
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;background:#f5f7fa;}
    .navbar{background:#16A085;color:white;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
    .navbar h2{font-size:20px;}
    .container{max-width:1200px;margin:30px auto;padding:0 20px;}
    .card{background:white;border-radius:10px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,0.06);margin-bottom:20px}
    .card-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid #eee}
    table{width:100%;border-collapse:collapse}
    thead{background:#f4f6f7}
    th,td{padding:12px;border-bottom:1px solid #ecf0f1;text-align:left;font-size:14px}
    tbody tr:hover{background:#fbfcfd}
    .badge{display:inline-block;padding:6px 10px;border-radius:999px;font-weight:600;font-size:12px}
    .badge-pending{background:#fff3cd;color:#856404}
    .badge-approved{background:#d4edda;color:#155724}
    .badge-rejected{background:#f8d7da;color:#721c24}
    .badge-completed{background:#d1ecf1;color:#0c5460}
    .btn{padding:6px 10px;border-radius:6px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s}
    .btn:hover{transform:scale(1.05)}
    .btn-approve{background:#27ae60;color:#fff}
    .btn-approve:hover{background:#229954}
    .btn-reject{background:#e74c3c;color:#fff}
    .btn-reject:hover{background:#c0392b}
    .btn-detail{background:#3498db;color:#fff}
    .btn-detail:hover{background:#2980b9}
    .filter-container{display:flex;gap:15px;margin-bottom:20px;flex-wrap:wrap}
    .filter-select{padding:10px 15px;border-radius:8px;border:2px solid #ddd;font-weight:600;cursor:pointer;min-width:200px}
    
    /* ============================================
       TOMBOL DASHBOARD (SAMA SEPERTI DASHBOARD)
    ============================================ */
    
    /* Tombol Eviden - WARNA HIJAU */
    .btn-eviden {
        background: #28a745 !important;
        color: white !important;
        border: none !important;
        border-radius: 5px !important;
        padding: 6px 10px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        transition: 0.2s ease-in-out;
        font-size: 14px;
        height: 32px;
    }

    .btn-eviden i {
        font-size: 14px;
    }

    .btn-eviden:hover {
        background: #218838 !important;
        transform: scale(1.05);
    }
    
    /* Tombol Return - WARNA ORANGE/KUNING */
    .btn-return {
        background: #ff9800 !important;
        color: white !important;
        border: none !important;
        border-radius: 5px !important;
        padding: 6px 10px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        transition: 0.2s ease-in-out;
        font-size: 14px;
        height: 32px;
    }

    .btn-return i {
        font-size: 14px;
    }

    .btn-return:hover {
        background: #f57c00 !important;
        transform: scale(1.05);
    }
    
    /* Tombol Edit - WARNA KUNING */
    .btn-warning {
        background: #ffc107 !important;
        color: #000 !important;
        border: none !important;
        border-radius: 5px !important;
        padding: 6px 10px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        transition: 0.2s ease-in-out;
        font-size: 14px;
        height: 32px;
        text-decoration: none !important;
    }

    .btn-warning:hover {
        background: #e0a800 !important;
        transform: scale(1.05);
        color: #000 !important;
        text-decoration: none !important;
    }
    
    /* Tombol Masukkan Nomor Surat - WARNA BIRU */
    .btn-nomor {
        background: #3498db !important;
        color: white !important;
        border: none !important;
        border-radius: 5px !important;
        padding: 6px 10px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        transition: 0.2s ease-in-out;
        font-size: 14px;
        height: 32px;
    }

    .btn-nomor i {
        font-size: 14px;
    }

    .btn-nomor:hover {
        background: #2980b9 !important;
        transform: scale(1.05);
    }

    /* Tombol Cetak - WARNA UNGU */
    .btn-cetak {
        background: #9b59b6 !important;
        color: white !important;
        border: none !important;
        border-radius: 5px !important;
        padding: 6px 10px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        transition: 0.2s ease-in-out;
        font-size: 14px;
        height: 32px;
    }

    .btn-cetak i {
        font-size: 14px;
    }

    .btn-cetak:hover {
        background: #8e44ad !important;
        transform: scale(1.05);
    }

    /* Tombol Download PDF - WARNA HIJAU */
    .btn-download {
        background: #2ecc71 !important;
        color: white !important;
        border: none !important;
        border-radius: 5px !important;
        padding: 6px 10px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        transition: 0.2s ease-in-out;
        font-size: 14px;
        height: 32px;
        text-decoration: none !important;
    }

    .btn-download:hover {
        background: #27ae60 !important;
        transform: scale(1.05);
        text-decoration: none !important;
    }
    
    /* ============================================
       DISPOSISI STYLES (SAMA SEPERTI DASHBOARD)
    ============================================ */
    .btn-disposisi {
        background:#f1c40f;
        color:#000;
        border:none;
        padding:6px 12px;
        border-radius:5px;
        cursor:pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .disposisi-card {
        background: #ffffff;
        padding: 18px 20px;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.12);
        margin-top: 10px;
        border: 1px solid #eee;
        display: none;
    }
    
    .label-disposisi {
        font-weight: 600;
        color: #333;
        font-size: 14px;
        margin-bottom: 6px;
        display: block;
    }
    
    .select-disposisi {
        width: 100%;
        padding: 10px 12px;
        border-radius: 10px;
        border: 2px solid #ddd;
        background: #fafafa;
        font-size: 15px;
        outline: none;
        transition: .2s;
    }
    
    .textarea-disposisi {
        width: 100%;
        padding: 12px;
        height: 100px;
        border-radius: 10px;
        border: 2px solid #ddd;
        background: #fafafa;
        resize: vertical;
        font-size: 14px;
        transition: .2s;
        margin-top: 5px;
        display: none;
    }
    
    /* Disposisi Info Box dengan timestamp */
    .disposisi-info-box {
        margin-top: 8px;
        padding: 8px;
        background: #f8f9fa;
        border-radius: 6px;
        border-left: 3px solid #16A085;
    }

    .disposisi-status-text {
        display: block;
        margin-bottom: 4px;
    }

    .disposisi-status-text strong {
        color: #16A085;
    }

    .disposisi-status-text span {
        color: #2c3e50;
        font-weight: 600;
    }

    .disposisi-timestamp {
        display: block;
        color: #7f8c8d;
        font-size: 11px;
        margin-bottom: 4px;
    }

    .disposisi-catatan-text {
        display: block;
        color: #7f8c8d;
        font-size: 11px;
        font-style: italic;
        margin-top: 4px;
        padding: 4px 6px;
        background: white;
        border-radius: 4px;
    }

    .approval-status-box {
        margin-top: 8px;
        padding: 6px 8px;
        border-radius: 4px;
    }

    .approval-status-box.approved {
        background: #d4edda;
        color: #155724;
    }

    .approval-status-box.rejected {
        background: #f8d7da;
        color: #721c24;
    }

    .approval-timestamp-small {
        display: block;
        color: #6c757d;
        font-size: 10px;
        margin-top: 2px;
    }
    
    /* ============================================
       SEARCH & FILTER (SAMA SEPERTI DASHBOARD)
    ============================================ */
    .search-filter-container{display:flex;align-items:center;gap:15px;margin-bottom:20px;flex-wrap:wrap;background:#f8f9fa;padding:15px;border-radius:10px;border:1px solid #e9ecef}
    .search-box{position:relative;flex:1;min-width:300px}
    .search-input{width:100%;padding:12px 45px 12px 15px;border:1px solid #ddd;border-radius:8px;font-size:14px;transition:all 0.3s;background:white}
    .search-input:focus{outline:none;border-color:#16A085;box-shadow:0 0 0 2px rgba(22,160,133,0.1)}
    .search-icon{position:absolute;right:15px;top:50%;transform:translateY(-50%);color:#6c757d}
    .btn-primary{padding:10px 20px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#16A085;color:#fff}
    .btn-primary:hover{background:#138D75;transform:translateY(-2px)}
    .btn-secondary{padding:10px 20px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#95a5a6;color:#fff}
    .btn-secondary:hover{background:#7f8c8d}
    .back-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#16A085;color:white;text-decoration:none;border-radius:8px;font-weight:600;transition:all 0.3s;margin-bottom:20px}
    .back-btn:hover{background:#138D75;transform:translateY(-2px)}
    
    /* ============================================
       MODAL STYLES (SAMA SEPERTI DASHBOARD)
    ============================================ */
    .modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.45);align-items:center;justify-content:center}
    .modal.show{display:flex}
    .modal-content{background:white;padding:0;border-radius:15px;max-width:1100px;width:95%;max-height:85vh;overflow:hidden;animation:slideIn 0.3s ease;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
    @keyframes slideIn{from{transform:translateY(-50px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-header{background:#16A085;color:white;padding:20px 25px;display:flex;justify-content:space-between;align-items:center;border-radius:15px 15px 0 0}
    .modal-header h3{margin:0;font-size:18px;font-weight:600}
    .close-modal{background:none;border:0;color:white;font-size:24px;cursor:pointer;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background 0.2s}
    .close-modal:hover{background:rgba(255,255,255,0.2)}
    
    /* Detail Content Styles */
    .detail-content{padding:25px;max-height:calc(85vh - 80px);overflow-y:auto}
    .detail-section{margin-bottom:25px;background:#f8f9fa;border-radius:12px;padding:20px;border:1px solid #e9ecef}
    .detail-section:last-child{margin-bottom:0}
    .detail-section-title{font-size:16px;font-weight:700;color:#16A085;margin-bottom:15px;padding-bottom:10px;border-bottom:2px solid #16A085;display:flex;align-items:center;gap:10px}
    .detail-section-title i{font-size:18px}
    .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:15px}
    .detail-row{display:flex;flex-direction:column;margin-bottom:12px}
    .detail-label{font-weight:600;color:#495057;font-size:13px;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.5px}
    .detail-value{color:#212529;font-size:14px;background:white;padding:10px 15px;border-radius:8px;border:1px solid #e9ecef;min-height:40px;display:flex;align-items:center}
    .detail-value-empty{color:#6c757d;font-style:italic;background:#f8f9fa !important}
    
    /* Dosen list in detail */
    .dosen-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .dosen-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 12px;
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 6px;
    }

    .dosen-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #16A085;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 12px;
        font-weight: 600;
    }

    .dosen-info {
        flex: 1;
    }

    .dosen-name {
        font-weight: 600;
        color: #212529;
        font-size: 14px;
    }

    .dosen-details {
        font-size: 12px;
        color: #6c757d;
    }
    
    /* File Evidence Styles */
    .file-evidence{margin-top:10px}
    .file-item{display:flex;align-items:center;gap:12px;padding:12px 15px;background:white;border:1px solid #e9ecef;border-radius:8px;transition:all 0.2s}
    .file-item:hover{background:#e8f6f3;border-color:#16A085}
    .file-icon{width:24px;height:24px;display:flex;align-items:center;justify-content:center;color:#16A085;font-size:16px}
    .file-info{flex:1}
    .file-name{font-weight:600;color:#212529;font-size:14px;cursor:pointer}
    .file-name:hover{color:#16A085}
    .file-size{font-size:12px;color:#6c757d}
    .preview-btn{background:#3498db;color:white;border:none;padding:8px 16px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;transition:background 0.2s;display:flex;align-items:center;gap:6px;text-decoration:none}
    .preview-btn:hover{background:#2980b9;color:white;text-decoration:none}
    .preview-btn.disabled{background:#bdc3c7;cursor:not-allowed;opacity:0.6}
    .preview-btn.disabled:hover{background:#bdc3c7}
    .download-btn{background:#16A085;color:white;border:none;padding:8px 16px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;transition:background 0.2s;display:flex;align-items:center;gap:6px;text-decoration:none}
    .download-btn:hover{background:#138D75;color:white;text-decoration:none}

    /* Preview Modal Styles */
    .preview-modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.8);z-index:10000;justify-content:center;align-items:center;padding:20px}
    .preview-modal.show{display:flex}
    .preview-content{background:white;border-radius:12px;width:90%;max-width:900px;max-height:90vh;overflow:hidden;display:flex;flex-direction:column}
    .preview-header{background:#16A085;color:white;padding:15px 20px;display:flex;justify-content:space-between;align-items:center}
    .preview-header h3{margin:0;font-size:16px;font-weight:600}
    .preview-close{background:none;border:none;color:white;font-size:24px;cursor:pointer;padding:0;width:30px;height:30px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background 0.2s}
    .preview-close:hover{background:rgba(255,255,255,0.2)}
    .preview-body{flex:1;padding:0;display:flex;justify-content:center;align-items:center;background:#f8f9fa;min-height:400px}
    .preview-iframe{width:100%;height:70vh;border:none}
    .preview-image{max-width:100%;max-height:70vh;object-fit:contain}
    .preview-unsupported{text-align:center;padding:40px;color:#6c757d}
    .preview-unsupported i{font-size:48px;margin-bottom:15px;color:#16A085}
    
    /* Action Buttons in Modal */
    .modal-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:20px;padding-top:20px;border-top:1px solid #e9ecef}
    .modal-btn{padding:10px 20px;border-radius:8px;border:none;cursor:pointer;font-weight:600;font-size:14px;transition:all 0.2s;display:flex;align-items:center;gap:8px}
    .modal-btn-close{background:#6c757d;color:white}
    .modal-btn-close:hover{background:#5a6268;transform:translateY(-2px)}
    .modal-btn-approve{background:#27ae60;color:white}
    .modal-btn-approve:hover{background:#229954;transform:translateY(-2px)}
    .modal-btn-reject{background:#e74c3c;color:white}
    .modal-btn-reject:hover{background:#c0392b;transform:translateY(-2px)}
    
    /* Rejection Notes Styles */
    .rejection-notes{background:#fff5f5;border:1px solid #f8d7da;border-radius:8px;padding:20px;margin-top:15px}
    .rejection-notes .detail-label{color:#dc3545;font-weight:700}
    .rejection-notes .detail-value{background:#fff5f5;border-color:#f8d7da;color:#721c24;font-size:14px;line-height:1.5;min-height:auto;padding:12px}
    
    /* Approve Modal Sederhana */
    .approve-modal-content{background:white;padding:0;border-radius:15px;max-width:450px;width:95%;max-height:85vh;overflow:hidden;animation:slideIn 0.3s ease;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
    .approve-modal-body{padding:25px}
    .approve-modal-header{background:#27ae60;color:white;padding:20px 25px;display:flex;justify-content:space-between;align-items:center;border-radius:15px 15px 0 0}
    .approve-modal-header h3{margin:0;font-size:18px;font-weight:600}
    .approve-info-box{background:#e8f6f3;border:1px solid #16A085;border-radius:8px;padding:15px;margin-bottom:20px}
    .approve-info-box strong{color:#16A085;display:block;margin-bottom:5px}
    .approve-info-box span{color:#2c3e50;font-weight:600}
    .form-group{margin-bottom:20px}
    .form-group label{display:block;margin-bottom:8px;font-weight:600;color:#2c3e50;font-size:14px}
    .form-control{width:100%;padding:12px 15px;border:2px solid #ddd;border-radius:8px;font-family:inherit;font-size:14px;transition:border-color 0.2s}
    .form-control:focus{outline:none;border-color:#3498db;box-shadow:0 0 0 3px rgba(52, 152, 219, 0.2)}
    .form-hint{color:#7f8c8d;font-size:12px;margin-top:5px;display:flex;align-items:center;gap:5px}
    .approve-modal-actions{display:flex;justify-content:flex-end;gap:12px;margin-top:25px;padding-top:20px;border-top:1px solid #e9ecef}
    .approve-btn{padding:10px 20px;border-radius:8px;border:none;cursor:pointer;font-weight:600;font-size:14px;transition:all 0.2s;display:flex;align-items:center;gap:8px}
    .approve-btn-cancel{background:#95a5a6;color:white}
    .approve-btn-cancel:hover{background:#7f8c8d;transform:translateY(-2px)}
    .approve-btn-submit{background:#27ae60;color:white}
    .approve-btn-submit:hover{background:#229954;transform:translateY(-2px)}
    
    /* Eviden Modal Styles */
    .eviden-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .eviden-modal.show {
        display: flex;
    }

    .eviden-content {
        background: white;
        border-radius: 12px;
        width: 90%;
        max-width: 800px;
        padding: 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .eviden-header {
        background: #28a745;
        color: white;
        padding: 20px;
        border-radius: 12px 12px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .eviden-header h3 {
        margin: 0;
        font-size: 18px;
    }

    .close-eviden {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background 0.2s;
    }

    .close-eviden:hover {
        background: rgba(255,255,255,0.2);
    }

    .eviden-body {
        padding: 25px;
        max-height: 70vh;
        overflow-y: auto;
    }
    
    /* PIN Modal Styles */
    .pin-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.45);
        backdrop-filter: blur(3px);
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }
    
    .modal-pin-box {
        background: #ffffff;
        width: 360px;
        padding: 28px;
        border-radius: 14px;
        text-align: center;
        box-shadow: 0 12px 35px rgba(0,0,0,0.18);
        animation: fadeInUp 0.25s ease-out;
    }

    @keyframes fadeInUp {
        from {opacity: 0; transform: translateY(15px);}
        to   {opacity: 1; transform: translateY(0);}
    }

    .modal-pin-title {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 5px;
        color: #2c3e50;
    }

    .modal-pin-title i {
        color: #16A085;
        margin-right: 6px;
    }

    .modal-pin-sub {
        font-size: 12px;
        color: #7f8c8d;
        margin-bottom: 20px;
    }

    .pin-field {
        margin-bottom: 12px;
    }

    .pin-field input {
        width: 100%;
        padding: 12px 14px;
        border: 2px solid #dfe6e9;
        border-radius: 8px;
        font-size: 15px;
        transition: 0.25s;
    }

    .pin-field input:focus {
        border-color: #16A085;
        outline: none;
        box-shadow: 0 0 0px 3px rgba(22,160,133,0.12);
    }

    .modal-pin-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-top: 18px;
    }

    .btn-save {
        background: #16A085;
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-save:hover {
        background: #138a70;
    }

    .btn-cancel {
        background: #b2bec3;
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-cancel:hover {
        background: #a4aeb3;
    }
    
    /* Modal Nomor Surat Specific Styles */
    #nomorSuratInfoBox {
        background: #e8f6f3;
        border: 1px solid #16A085;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }

    #nomorSuratInfoBox strong {
        color: #16A085;
        display: block;
        margin-bottom: 8px;
    }

    #nomorSuratInfoBox p {
        color: #2c3e50;
        margin-bottom: 4px;
        font-size: 13px;
    }

    #nomorSuratError {
        background: #fff5f5;
        border: 1px solid #f8cccc;
        border-radius: 6px;
        padding: 10px;
        margin-top: 10px;
    }

    /* Success Modal Nomor Surat */
    #successNomorValue {
        background: white;
        border: 2px dashed #3498db;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        margin: 10px 0;
        font-family: 'Courier New', monospace;
        letter-spacing: 1px;
    }
    
    /* ============================================
       CLICKABLE ROW STYLES (SAMA SEPERTI DASHBOARD)
    ============================================ */
    .clickable-row {
        cursor: pointer !important;
        transition: all 0.2s ease;
    }

    .clickable-row:hover {
        background-color: #f0f8ff !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .clickable-row:active {
        background-color: #e3f2fd !important;
        transform: scale(0.998);
    }

    /* Highlight untuk baris yang sedang dipilih */
    .clickable-row.selected {
        background-color: #e8f6f3 !important;
    }

    /* Pastikan tombol di dalam row tidak ter-affected */
    .clickable-row button,
    .clickable-row select,
    .clickable-row textarea,
    .clickable-row input {
        pointer-events: all;
    }
    
    /* ============================================
       SUCCESS MODAL STYLES (SAMA SEPERTI DASHBOARD)
    ============================================ */
    /* Card wrapper */
    .bulk-modal-content {
        background: white;
        padding: 0;
        border-radius: 15px;
        max-width: 600px;
        width: 95%;
        max-height: 85vh;
        overflow: hidden;
        animation: slideIn 0.3s ease;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }

    /* Dosen List di Success Modal - WARNA UNGU */
    .success-dosen-container {
        background: #f5eef8;
        border: 1px solid #d7bde2;
        border-radius: 8px;
        padding: 15px;
        margin: 15px 0;
    }

    .success-dosen-title {
        font-weight: 600;
        color: #16A085;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .success-dosen-count {
        background: #16A085;
        color: white;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 12px;
    }

    .success-dosen-list {
        max-height: 150px;
        overflow-y: auto;
        margin-bottom: 10px;
    }

    .success-dosen-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 10px;
        background: white;
        border: 1px solid #e8daef;
        border-radius: 4px;
        margin-bottom: 5px;
    }

    .success-dosen-item:last-child {
        margin-bottom: 0;
    }

    .success-dosen-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #16A085;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 11px;
        font-weight: 600;
        flex-shrink: 0;
    }

    .success-dosen-info {
        flex: 1;
        min-width: 0;
    }

    .success-dosen-name {
        font-weight: 600;
        color: #212529;
        font-size: 13px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .success-dosen-details {
        font-size: 11px;
        color: #6c757d;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .success-dosen-more-btn {
        background: #8E44AD;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 6px 12px;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        width: 100%;
        transition: background 0.2s;
    }

    .success-dosen-more-btn:hover {
        background: #16A085;
    }

    .success-dosen-hidden {
        display: none;
    }

    .success-dosen-show-all .success-dosen-item {
        display: flex !important;
    }
    
    /* Tombol bulk style */
    .btn-bulk {
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-bulk:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    /* ============================================
       REJECT MODAL STYLES
    ============================================ */
    .reject-modal-content {
        background: white;
        padding: 0;
        border-radius: 15px;
        max-width: 550px;
        width: 95%;
        max-height: 85vh;
        overflow: hidden;
        animation: slideIn 0.3s ease;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }

    .reject-modal-body {
        padding: 25px;
    }

    .reject-modal-header {
        background: #e74c3c;
        color: white;
        padding: 20px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 15px 15px 0 0;
    }

    .reject-modal-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .reject-info-box {
        background: #fff5f5;
        border: 1px solid #f8cccc;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .reject-info-box strong {
        color: #e74c3c;
        display: block;
        margin-bottom: 5px;
    }

    .reject-info-box span {
        color: #2c3e50;
        font-weight: 600;
    }

    .reject-modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }

    .reject-btn {
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .reject-btn-cancel {
        background: #95a5a6;
        color: white;
    }

    .reject-btn-cancel:hover {
        background: #7f8c8d;
        transform: translateY(-2px);
    }

    .reject-btn-submit {
        background: #e74c3c;
        color: white;
    }

    .reject-btn-submit:hover {
        background: #c0392b;
        transform: translateY(-2px);
    }

    /* Textarea khusus untuk reject modal */
    .reject-textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #f8cccc;
        border-radius: 8px;
        font-family: inherit;
        font-size: 14px;
        transition: border-color 0.2s;
        resize: vertical;
        min-height: 100px;
    }

    .reject-textarea:focus {
        outline: none;
        border-color: #e74c3c;
        box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.2);
    }

    .reject-textarea::placeholder {
        color: #bdc3c7;
    }

    .reject-form-hint {
        color: #e74c3c;
        font-size: 12px;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    /* ============================================
       RESPONSIVE
    ============================================ */
    @media (max-width:768px){
        .detail-grid{grid-template-columns:1fr}
        .modal-content{width:95%;margin:10px}
        .detail-content{padding:15px}
        .modal-actions{flex-direction:column}
        .modal-btn{justify-content:center}
        .approve-modal-content{width:95%;margin:10px}
        .approve-modal-body{padding:15px}
        .approve-modal-actions{flex-direction:column}
        .approve-btn{justify-content:center}
        .reject-modal-content{width:95%;margin:10px}
        .reject-modal-body{padding:15px}
        .search-filter-container{flex-direction:column}
        .search-box{min-width:100%}
        .filter-select{width:100%}
        .modal-pin-box {
            width: 95%;
            padding: 20px;
        }
    }

    /* Ensure buttons are clickable */
    #tableBody button,
    #tableBody a.btn-warning {
        position: relative;
        z-index: 10;
        pointer-events: auto !important;
        cursor: pointer !important;
    }

    #tableBody tr.clickable-row {
        position: relative;
        z-index: 1;
    }

    /* Disposisi elements */
    .disposisi-card {
        position: relative;
        z-index: 20;
    }

    .disposisi-card select,
    .disposisi-card textarea,
    .disposisi-card button {
        pointer-events: auto !important;
        z-index: 21;
    }
</style>
</head>
<body>

<div class="navbar">
    <h2><i class="fa-solid fa-clipboard-list"></i> Dashboard Sekretariat</h2>
    <div></div>
</div>

<div class="container">
    <!-- Tombol Kembali -->
    <a href="<?= base_url('sekretariat') ?>" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
    </a>

    <?php if($this->session->flashdata('success')): ?>
    <div class="card" style="border-left:4px solid #27ae60;margin-bottom:18px">
        <div style="color:#155724;font-weight:700"><?php echo $this->session->flashdata('success'); ?></div>
    </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
    <div class="card" style="border-left:4px solid #e74c3c;margin-bottom:18px">
        <div style="color:#721c24;font-weight:700"><?php echo $this->session->flashdata('error'); ?></div>
    </div>
    <?php endif; ?>

    <!-- Tabel Total Pengajuan -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-table"></i> Total Pengajuan Surat - Sekretariat</h3>
            <div>
                <span id="filterInfo" style="color:#7f8c8d;font-size:13px">
                    Menampilkan: 
                    <?php 
                    $filter_info = "Semua Data";
                    if($this->input->get('status') == 'pending') $filter_info = "Menunggu";
                    if($this->input->get('status') == 'approved') $filter_info = "Disetujui";
                    if($this->input->get('status') == 'rejected') $filter_info = "Ditolak";
                    if($this->input->get('status') == 'dekan_approved') $filter_info = "Disetujui Dekan";
                    if($this->input->get('status') == 'dekan_rejected') $filter_info = "Ditolak Dekan";
                    
                    // Filter Jenis Penugasan
                    $jenis_penugasan_info = "";
                    if($this->input->get('jenis_penugasan') == 'perorangan') {
                        $jenis_penugasan_info = " [Perorangan]";
                    } elseif($this->input->get('jenis_penugasan') == 'kelompok') {
                        $jenis_penugasan_info = " [Kelompok]";
                    } elseif($this->input->get('jenis_penugasan') == 'lainnya') {
                        $jenis_penugasan_info = " [Lainnya]";
                    }
                    
                    echo $filter_info . $jenis_penugasan_info . " (" . (isset($total_surat) ? $total_surat : '0') . " data)";
                    ?>
                </span>
            </div>
        </div>
        
        <!-- Search + Filter -->
        <form method="get" action="<?= base_url('sekretariat/semua') ?>">
            <input type="hidden" name="from" value="semua">
            
            <div class="search-filter-container">
                <div class="search-box">
                    <input 
                        type="text" 
                        name="search" 
                        class="search-input"
                        placeholder="Cari nama kegiatan atau penyelenggara..."
                        value="<?= $this->input->get('search') ?>"
                    >
                    <div class="search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
                
                <!-- Filter Status -->
                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="pending" <?= ($this->input->get('status')=='pending') ? 'selected' : '' ?>>Menunggu</option>
                    <option value="approved" <?= ($this->input->get('status')=='approved') ? 'selected' : '' ?>>Disetujui</option>
                    <option value="rejected" <?= ($this->input->get('status')=='rejected') ? 'selected' : '' ?>>Ditolak</option>
                    <option value="dekan_approved" <?= ($this->input->get('status')=='dekan_approved') ? 'selected' : '' ?>>Disetujui Dekan</option>
                    <option value="dekan_rejected" <?= ($this->input->get('status')=='dekan_rejected') ? 'selected' : '' ?>>Ditolak Dekan</option>
                </select>
                
                <!-- FILTER BARU: Jenis Penugasan -->
                <select name="jenis_penugasan" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Jenis Penugasan</option>
                    <option value="perorangan" <?= ($this->input->get('jenis_penugasan') == 'perorangan') ? 'selected' : '' ?>>Perorangan</option>
                    <option value="kelompok" <?= ($this->input->get('jenis_penugasan') == 'kelompok') ? 'selected' : '' ?>>Kelompok</option>
                    <option value="lainnya" <?= ($this->input->get('jenis_penugasan') == 'lainnya') ? 'selected' : '' ?>>Lainnya</option>
                </select>
                
                <button type="submit" class="btn-primary" style="white-space:nowrap">
                    <i class="fa-solid fa-filter"></i> Terapkan
                </button>
                
                <a href="<?= base_url('sekretariat/semua') ?>" class="btn-secondary" style="white-space:nowrap">
                    <i class="fa-solid fa-refresh"></i> Reset
                </a>
            </div>
        </form>
        
        <div style="overflow-x:auto">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Nomor Surat</th>
                        <th>Penyelenggara</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Tanggal Kegiatan</th>
                        <th>Jenis</th>
                        <th>Disposisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php 
                    if(isset($surat_list) && is_array($surat_list) && !empty($surat_list)): 
                        $no = 1; 
                        foreach($surat_list as $s): 
                            // LOGIKA STATUS YANG DIPERBAIKI (SAMA SEPERTI DASHBOARD)
                            $status = $s->status ?? '';
                            $st_key = 'unknown';
                            $badge_text = ucwords($status);
                            
                            if ($status == 'disetujui KK') {
                                $st_key = 'pending';
                                $badge = '<span class="badge badge-pending">Menunggu Sekretariat</span>';
                            } elseif ($status == 'disetujui sekretariat') {
                                $st_key = 'approved';
                                $badge = '<span class="badge badge-approved">Disetujui Sekretariat</span>';
                            } elseif ($status == 'ditolak sekretariat') {
                                $st_key = 'rejected';
                                $badge = '<span class="badge badge-rejected">Ditolak Sekretariat</span>';
                            } elseif ($status == 'disetujui dekan') {
                                $st_key = 'completed';
                                $badge = '<span class="badge badge-completed">Disetujui Dekan</span>';
                            } elseif ($status == 'ditolak dekan') {
                                $st_key = 'rejected';
                                $badge = '<span class="badge badge-rejected">Ditolak Dekan</span>';
                            } elseif (strpos($status, 'pengajuan') !== false || strpos($status, 'pending') !== false || strpos($status, 'menunggu') !== false) {
                                $st_key = 'pending';
                                $badge = '<span class="badge badge-pending">' . $badge_text . '</span>';
                            } elseif (strpos($status, 'setuju') !== false || strpos($status, 'approved') !== false) {
                                $st_key = 'approved';
                                $badge = '<span class="badge badge-approved">' . $badge_text . '</span>';
                            } elseif (strpos($status, 'tolak') !== false || strpos($status, 'rejected') !== false) {
                                $st_key = 'rejected';
                                $badge = '<span class="badge badge-rejected">' . $badge_text . '</span>';
                            } else {
                                $st_key = 'other';
                                $badge = '<span class="badge badge-pending">' . $badge_text . '</span>';
                            }

                            $tgl_pengajuan = isset($s->created_at) && $s->created_at ? date('d M Y', strtotime($s->created_at)) : '-';
                            // REVISI: Kolom Tanggal Kegiatan - Tampilkan Periode atau Tanggal (SAMA SEPERTI DASHBOARD)
                            $jenis_date = isset($s->jenis_date) ? $s->jenis_date : '';
                            $tanggal_kegiatan_display = '-';
                            
                            if ($jenis_date === 'Periode') {
                                $periode_value = isset($s->periode_value) && !empty($s->periode_value) ? $s->periode_value : '-';
                                $tanggal_kegiatan_display = '<span class="badge" style="background: #e3f2fd; color: #1976d2; padding: 6px 12px; border-radius: 15px; font-size: 12px; font-weight: 600;">';
                                $tanggal_kegiatan_display .= '<i class="fas fa-calendar-alt"></i> ' . htmlspecialchars($periode_value);
                                $tanggal_kegiatan_display .= '</span>';
                            } else {
                                $tanggal_kegiatan = '';
                                if (isset($s->tanggal_kegiatan) && !empty($s->tanggal_kegiatan)) {
                                    $tanggal_kegiatan = $s->tanggal_kegiatan;
                                } elseif (isset($s->tanggal_awal_kegiatan) && !empty($s->tanggal_awal_kegiatan)) {
                                    $tanggal_kegiatan = $s->tanggal_awal_kegiatan;
                                } elseif (isset($s->tanggal_mulai) && !empty($s->tanggal_mulai)) {
                                    $tanggal_kegiatan = $s->tanggal_mulai;
                                } elseif (isset($s->created_at) && !empty($s->created_at)) {
                                    $tanggal_kegiatan = $s->created_at;
                                }
                                
                                if (!empty($tanggal_kegiatan) && $tanggal_kegiatan !== '-') {
                                    try {
                                        $tanggal_obj = new DateTime($tanggal_kegiatan);
                                        $hari = $tanggal_obj->format('j');
                                        $bulan = $tanggal_obj->format('n');
                                        
                                        $bulan_indonesia = [
                                            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                                            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
                                            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                                        ];
                                        
                                        $bulan_nama = $bulan_indonesia[$bulan] ?? 'Desember';
                                        $tahun = $tanggal_obj->format('Y');
                                        
                                        $tanggal_kegiatan_display = htmlspecialchars($hari . ' ' . $bulan_nama . ' ' . $tahun);
                                    } catch (Exception $e) {
                                        $tanggal_kegiatan_display = htmlspecialchars($tanggal_kegiatan);
                                    }
                                } else {
                                    $tanggal_kegiatan_display = '-';
                                }
                            }
                    ?>
                    <tr class="clickable-row" data-id="<?= $s->id ?>" data-status="<?= $st_key ?>">
                        <td><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($s->nama_kegiatan ?? '-') ?></strong></td>
                        <td><?= htmlspecialchars($s->nomor_surat ?? '-') ?></td>
                        <td><?= htmlspecialchars($s->penyelenggara ?? '-') ?></td>
                        <td><?= $tgl_pengajuan ?></td>
                        <td><?= $tanggal_kegiatan_display ?></td>
                        <td><?= htmlspecialchars($s->jenis_pengajuan ?? '-') ?></td>
                        <td onclick="event.stopPropagation()">
                            <!-- Tombol Tentukan Disposisi (SAMA SEPERTI DASHBOARD) -->
                            <button 
                                class="btn-disposisi" 
                                onclick="openPinModal(<?= $s->id ?>, event)"
                                style="background:#f1c40f;color:#000;border:none;padding:6px 12px;border-radius:5px;cursor:pointer"
                            >
                                <i class="fas fa-shuffle"></i> Tentukan
                            </button>

                            <!-- Dropdown Disposisi (disembunyikan sampai PIN benar) -->
                            <div id="disposisiBox<?= $s->id ?>" class="disposisi-card" style="display:none;">
                                <label class="label-disposisi">Pilih Disposisi</label>
                                <select id="disposisiSelect<?= $s->id ?>"
                                        class="select-disposisi"
                                        onchange="onDisposisiChange(<?= $s->id ?>)">
                                    <option value="">-- Pilih Disposisi --</option>
                                    <option value="Lanjut Proses ✔">Lanjut Proses</option>
                                    <option value="Hold/Pending">Hold/Pending</option>
                                    <option value="Batal">Batal</option>
                                </select>

                                <label id="labelCatatan<?= $s->id ?>" 
                                    class="label-disposisi" 
                                    style="display:none;margin-top:10px;">
                                    Catatan
                                </label>

                                <textarea id="catatanDisposisi<?= $s->id ?>"
                                        class="textarea-disposisi"
                                        placeholder="Catatan diperlukan..."
                                        style="display:none;">
                                </textarea>

                                <button class="btn-disposisi" 
                                        onclick="saveDisposisi(<?= $s->id ?>)" 
                                        id="btnSaveDisposisi<?= $s->id ?>"
                                        style="display:none; width: 100%; margin-top: 10px;">
                                    Simpan
                                </button>
                            </div>
                            <br>

                             <!-- Info Disposisi (SAMA DENGAN DASHBOARD) -->
                            <?php if (!empty($s->disposisi_status)): ?>
                                <div class="disposisi-info-box">
                                    <?php if (in_array($s->disposisi_status, ['Modify By Sekretariat', 'Modify By User'])): ?>
                                        <small class="disposisi-status-text">
                                            <strong style="color:#16A085;">Status :</strong> 
                                            <span style="color:#2c3e50;font-weight:600;">none</span>
                                        </small>
                                    <?php else: ?>
                                        <small class="disposisi-status-text">
                                            <strong style="color:#16A085;">Status :</strong> 
                                            <span style="color:#2c3e50;font-weight:600;"><?= htmlspecialchars($s->disposisi_status) ?></span>
                                        </small>
                                    <?php endif; ?>
                                    
                                    <?php if (in_array($s->disposisi_status, ['Modify By Sekretariat', 'Modify By User'])): ?>
                                        <small style="display:block;color:#ff9800;font-size:11px;margin-bottom:4px;">
                                            <i class="fas fa-pen"></i> 
                                            <strong><?= htmlspecialchars($s->disposisi_status) ?></strong><br>
                                            <?= date('d M Y H:i', strtotime($s->updated_at)) ?>
                                        </small>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($s->disposisi_updated_at)): ?>
                                        <small class="disposisi-timestamp">
                                            <i class="far fa-clock"></i> 
                                            <?= date('d M Y H:i', strtotime($s->disposisi_updated_at)) ?>
                                        </small>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($s->disposisi_catatan) && !in_array($s->disposisi_status, ['Modify By Sekretariat', 'Modify By User'])): ?>
                                        <small class="disposisi-catatan-text">
                                            <i class="far fa-comment"></i> 
                                            <?= htmlspecialchars($s->disposisi_catatan) ?>
                                        </small>
                                    <?php endif; ?>
                                    
                                    <?php if (($s->disposisi_status === 'Lanjut Proses ✔' || $s->disposisi_status === 'Batal') && !empty($s->status)): ?>
                                        <?php if (in_array($s->status, ['disetujui sekretariat', 'ditolak sekretariat', 'disetujui dekan', 'ditolak dekan'])): ?>
                                            <div class="approval-status-box <?= in_array($s->status, ['disetujui sekretariat', 'disetujui dekan']) ? 'approved' : 'rejected' ?>">
                                                <small style="display:block;font-weight:700;color:<?= in_array($s->status, ['disetujui sekretariat', 'disetujui dekan']) ? '#155724' : '#721c24' ?>;">
                                                    <i class="fas fa-<?= in_array($s->status, ['disetujui sekretariat', 'disetujui dekan']) ? 'check-circle' : 'times-circle' ?>"></i>
                                                    <?= $s->status === 'disetujui sekretariat' ? 'Telah Disubmit' : 
                                                    ($s->status === 'ditolak sekretariat' ? 'Ditolak Sekretariat' : 
                                                    ($s->status === 'disetujui dekan' ? 'Disetujui Dekan' : 
                                                    ($s->status === 'ditolak dekan' ? 'Ditolak Dekan' : $s->status))) ?>
                                                </small>
                                                <?php if (!empty($s->updated_at)): ?>
                                                    <small class="approval-timestamp-small">
                                                        <?= date('d M Y H:i', strtotime($s->updated_at)) ?>
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td onclick="event.stopPropagation()">
                            <div style="display:flex;gap:6px">
                                <!-- Tombol Lihat Eviden -->
                                <button class="btn btn-eviden" title="Lihat Eviden" onclick="showEvidenModal(<?= $s->id; ?>, event)">
                                    <i class="fas fa-file-image"></i>
                                </button>
                                
                                <!-- TOMBOL MATA: Untuk menampilkan preview surat (iframe) -->
                                <button class="btn btn-detail" onclick="showSuratPreview(<?= $s->id ?>)" title="Lihat Surat">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                
                                <!-- TOMBOL EDIT (untuk disetujui KK, disetujui sekretariat, ditolak sekretariat) -->
                                <?php if(in_array($s->status, ['disetujui KK', 'disetujui sekretariat', 'ditolak sekretariat'])): ?>
                                    <a href="<?= site_url('sekretariat/edit_surat_sekretariat/' . $s->id) ?>" 
                                    class="btn btn-warning" 
                                    title="Edit Pengajuan"
                                    onclick="event.stopPropagation(); return true;">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <!-- LOGIKA BARU: Tombol Approve hanya untuk status "disetujui KK" dengan disposisi "Lanjut Proses" -->
                                <?php if($status == 'disetujui KK' && $s->disposisi_status == 'Lanjut Proses ✔'): ?>
                                    <button class="btn btn-approve" onclick="event.stopPropagation(); showApproveModal(<?= $s->id ?>, '<?= htmlspecialchars(addslashes($s->nama_kegiatan ?? '')) ?>', event)" title="Approve">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                    
                                <!-- LOGIKA BARU: Tombol Return untuk status "disetujui sekretariat" atau "ditolak sekretariat" -->
                                <?php elseif(in_array($s->status, ['disetujui sekretariat', 'ditolak sekretariat'])): ?>
                                    <button class="btn btn-return" onclick="event.stopPropagation(); showReturnModal(<?= $s->id ?>, '<?= htmlspecialchars($s->nama_kegiatan ?? '', ENT_QUOTES) ?>', event)" title="Return">
                                        <i class="fa-solid fa-undo"></i>
                                    </button>
                                <?php endif; ?>
                                
                                <!-- Tombol edit khusus untuk ditolak dekan -->
                                <?php if($status == 'ditolak dekan' && $s->disposisi_status == 'Lanjut Proses ✔'): ?>
                                    <a href="<?= site_url('sekretariat/edit_surat/' . $s->id) ?>" 
                                    class="btn btn-warning" 
                                    title="Edit & Ajukan Ulang ke Dekan"
                                    onclick="event.stopPropagation(); return true;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <!-- TOMBOL: TAMBAH NOMOR SURAT (hanya untuk status disetujui dekan) -->
                                <?php if($status == 'disetujui dekan'): ?>
                                    <button class="btn btn-nomor" 
                                            onclick="event.stopPropagation(); openNomorSuratModal(<?= $s->id ?>, '<?= htmlspecialchars(addslashes($s->nama_kegiatan ?? '')) ?>', event)"
                                            title="Masukkan Nomor Surat">
                                        <i class="fa-solid fa-hashtag"></i>
                                    </button>
                                <?php endif; ?>
                                
                                <!-- TOMBOL: CETAK SURAT (hanya jika nomor surat sudah terisi) -->
                                <?php if($status == 'disetujui dekan' && !empty($s->nomor_surat) && $s->nomor_surat !== '-' && $s->nomor_surat !== 'null'): ?>
                                    <button class="btn btn-cetak" 
                                            onclick="event.stopPropagation(); window.open('<?= site_url('surat/cetak/' . $s->id) ?>', '_blank')"
                                            title="Cetak Surat">
                                        <i class="fa-solid fa-print"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="9" style="text-align:center;padding:40px;color:#7f8c8d">
                            <i class="fa-solid fa-inbox" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
                            <strong>
                                <?php if(!isset($surat_list)): ?>
                                    Variabel $surat_list tidak terdefinisi
                                <?php elseif(empty($surat_list)): ?>
                                    Tidak ada data pengajuan yang sesuai dengan filter
                                <?php else: ?>
                                    Data tidak valid
                                <?php endif; ?>
                            </strong>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-info" style="margin-top: 20px; text-align: center; color: #7f8c8d; font-size: 13px;">
            Menampilkan: 
            <?php 
            $filter_info = "Semua Data";
            if($this->input->get('status') == 'pending') $filter_info = "Menunggu";
            if($this->input->get('status') == 'approved') $filter_info = "Disetujui";
            if($this->input->get('status') == 'rejected') $filter_info = "Ditolak";
            if($this->input->get('status') == 'dekan_approved') $filter_info = "Disetujui Dekan";
            if($this->input->get('status') == 'dekan_rejected') $filter_info = "Ditolak Dekan";
            
            // Filter Jenis Penugasan
            $jenis_penugasan_info = "";
            if($this->input->get('jenis_penugasan') == 'perorangan') {
                $jenis_penugasan_info = " [Perorangan]";
            } elseif($this->input->get('jenis_penugasan') == 'kelompok') {
                $jenis_penugasan_info = " [Kelompok]";
            } elseif($this->input->get('jenis_penugasan') == 'lainnya') {
                $jenis_penugasan_info = " [Lainnya]";
            }
            
            echo $filter_info . $jenis_penugasan_info . " (" . (isset($total_surat) ? $total_surat : '0') . " data)";
            ?>
        </div>
    </div>
</div>

<!-- ============================================
MODAL-MODAL (SAMA SEPERTI DASHBOARD)
============================================ -->

<!-- Preview Modal (untuk eviden) -->
<div id="previewModal" class="preview-modal">
    <div class="preview-content">
        <div class="preview-header">
            <h3 id="previewTitle">Preview File</h3>
            <button class="preview-close" onclick="closePreviewModal()">&times;</button>
        </div>
        <div class="preview-body" id="previewBody">
            <!-- Preview content akan diisi oleh JavaScript -->
        </div>
    </div>
</div>

<!-- Detail Modal (untuk KLIK BARIS) - Menampilkan detail pengajuan -->
<div id="detailModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-alt"></i> Detail Pengajuan Surat Tugas</h3>
            <button class="close-modal" onclick="closeModal('detailModal')">&times;</button>
        </div>
        <div class="detail-content" id="detailContent">
            <!-- Content akan diisi oleh JavaScript -->
        </div>
    </div>
</div>

<!-- Modal Surat Preview (untuk TOMBOL MATA) - Menampilkan surat dalam iframe -->
<div id="suratPreviewModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-pdf"></i> Preview Surat Tugas</h3>
            <button class="close-modal" onclick="closeModal('suratPreviewModal')">&times;</button>
        </div>
        <div class="detail-content" id="suratPreviewContent">
            <!-- Content akan diisi oleh JavaScript -->
        </div>
    </div>
</div>

<!-- Approve Modal Sederhana -->
<div id="approveModal" class="modal">
<div class="approve-modal-content" style="max-width: 450px;">
    <div class="approve-modal-header">
        <h3><i class="fa-solid fa-check-circle"></i> Konfirmasi Persetujuan</h3>
        <button class="close-modal" onclick="closeModal('approveModal')">&times;</button>
    </div>
    <div class="approve-modal-body">
        <div style="text-align:center;margin-bottom:20px">
            <i class="fa-solid fa-question-circle" style="font-size:48px;color:#27ae60;margin-bottom:15px"></i>
            <h4 style="color:#2c3e50;margin-bottom:10px">Setujui Pengajuan?</h4>
            <p id="approveNamaKegiatan" style="font-weight:600;color:#7f8c8d;margin-bottom:20px"></p>
        </div>
        
        <div class="approve-modal-actions">
            <button type="button" class="approve-btn approve-btn-cancel" onclick="closeModal('approveModal')">
                <i class="fa-solid fa-times"></i> Batal
            </button>
            <button type="button" class="approve-btn approve-btn-submit" onclick="submitApprove()">
                <i class="fa-solid fa-check"></i> Ya, Setujui
            </button>
        </div>
    </div>
</div>
</div>

<!-- Modal Nomor Surat -->
<div id="nomorSuratModal" class="modal">
<div class="approve-modal-content" style="max-width: 500px;">
    <div class="approve-modal-header">
        <h3><i class="fa-solid fa-hashtag"></i> Masukkan Nomor Surat</h3>
        <button class="close-modal" onclick="closeModal('nomorSuratModal')">&times;</button>
    </div>
    <div class="approve-modal-body">
        <div class="approve-info-box" id="nomorSuratInfoBox">
            <!-- Info akan diisi oleh JavaScript -->
        </div>
        
        <form id="nomorSuratForm">
            <input type="hidden" id="nomorSuratId" value="">
            
            <div class="form-group">
                <label for="nomorSuratInput">
                    <i class="fa-solid fa-file-alt"></i> Nomor Surat <span style="color:#e74c3c">*</span>
                </label>
                <input 
                    type="text" 
                    id="nomorSuratInput" 
                    name="nomor_surat" 
                    class="form-control" 
                    placeholder="Contoh: 001/SKT/FT/2025" 
                    required
                    autocomplete="off"
                >
                <div class="form-hint">
                    <i class="fa-solid fa-exclamation-circle"></i> Format: XXX/SKT/FT/Tahun
                </div>
                <div id="nomorSuratError" style="color:#e74c3c;font-size:12px;margin-top:5px;display:none">
                    <!-- Error message -->
                </div>
            </div>

            <div class="approve-modal-actions">
                <button type="button" class="approve-btn approve-btn-cancel" onclick="closeModal('nomorSuratModal')">
                    <i class="fa-solid fa-times"></i> Batal
                </button>
                <button type="submit" class="approve-btn approve-btn-submit">
                    <i class="fa-solid fa-save"></i> Simpan Nomor Surat
                </button>
            </div>
        </form>
    </div>
</div>
</div>

<!-- Success Modal untuk Nomor Surat -->
<div id="successNomorSuratModal" class="modal">
<div class="bulk-modal-content" style="max-width: 500px;">
    <div class="modal-header" style="background: #3498db;">
        <h3><i class="fa-solid fa-check-circle"></i> Nomor Surat Berhasil Disimpan</h3>
        <button class="close-modal" onclick="closeModal('successNomorSuratModal')">&times;</button>
    </div>
    <div style="padding:25px;text-align:center">
        <div style="width:80px;height:80px;border-radius:50%;background:#d6eaf8;margin:0 auto 20px;display:flex;align-items:center;justify-content:center">
            <i class="fas fa-check" style="font-size:40px;color:#3498db"></i>
        </div>
        
        <h3 style="color:#3498db;margin-bottom:10px" id="successNomorTitle"></h3>
        <p style="color:#666;margin-bottom:10px">
            Nomor surat berhasil disimpan untuk pengajuan:
        </p>
        
        <div style="background:#e8f4fc;border:1px solid #3498db;border-radius:8px;padding:15px;margin:15px 0">
            <div style="font-weight:600;color:#2980b9;margin-bottom:8px;display:flex;align-items:center;justify-content:space-between">
                <span>Informasi Surat</span>
                <span id="successNomorItemCount" style="background:#3498db;color:white;padding:3px 10px;border-radius:20px;font-size:11px">1 item</span>
            </div>
            <div id="successNomorList" style="text-align:left">
                <!-- List akan diisi oleh JavaScript -->
            </div>
        </div>
        
        <div style="background:#d4edda;border:1px solid #c3e6cb;border-radius:8px;padding:12px;margin:15px 0">
            <div style="font-weight:600;color:#155724;margin-bottom:5px">
                <i class="fa-solid fa-hashtag"></i> Nomor Surat
            </div>
            <div style="font-size:18px;font-weight:700;color:#117864;font-family:'Courier New',monospace" id="successNomorValue">
                <!-- Nomor surat akan diisi -->
            </div>
        </div>
        
        <div style="display:flex;gap:10px;justify-content:center;margin-top:20px">
            <button class="btn-bulk" onclick="closeModal('successNomorSuratModal'); refreshPage();" style="background:#3498db;color:white;padding:10px 24px;border:none;border-radius:6px;cursor:pointer;font-weight:600;display:flex;align-items:center;gap:6px">
                <i class="fa-solid fa-rotate"></i> Tutup 
            </button>
        </div>
    </div>
</div>
</div>

<!-- Reject Modal -->
<div id="rejectConfirmModal" class="modal">
    <div class="reject-modal-content">
        <div class="reject-modal-header">
            <h3><i class="fa-solid fa-ban"></i> Konfirmasi Penolakan</h3>
            <button class="close-modal" onclick="closeModal('rejectConfirmModal')">&times;</button>
        </div>
        <div class="reject-modal-body">
            <div class="reject-info-box">
                <strong><i class="fa-solid fa-exclamation-triangle"></i> Anda akan menolak pengajuan:</strong>
                <span id="rejectNamaKegiatan">-</span>
            </div>
            
            <p style="margin-bottom:15px;color:#7f8c8d">
                <i class="fa-solid fa-info-circle"></i> 
                Berikan alasan penolakan untuk pengajuan ini:
            </p>
            
            <form id="rejectForm" method="POST" action="">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                
                <div class="form-group">
                    <textarea 
                        id="rejectionReason" 
                        name="rejection_notes" 
                        class="reject-textarea" 
                        placeholder="Masukkan alasan penolakan pengajuan ini..."
                        required
                    ></textarea>
                    <div class="reject-form-hint">
                        <i class="fa-solid fa-asterisk"></i> Alasan penolakan wajib diisi
                    </div>
                </div>
                
                <div class="reject-modal-actions">
                    <button type="button" class="reject-btn reject-btn-cancel" onclick="closeModal('rejectConfirmModal')">
                        <i class="fa-solid fa-times"></i> Batal
                    </button>
                    <button type="submit" class="reject-btn reject-btn-submit">
                        <i class="fa-solid fa-ban"></i> Ya, Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Result Modal untuk Reject -->
<div id="successRejectModal" class="modal">
    <div class="bulk-modal-content" style="max-width: 600px;">
        <div class="modal-header" style="background: #e74c3c;">
            <h3><i class="fa-solid fa-ban"></i> <span id="successRejectTitle">Pengajuan Berhasil Ditolak</span></h3>
            <button class="close-modal" onclick="closeModal('successRejectModal')">&times;</button>
        </div>
        <div style="padding:25px;text-align:center">
            <div style="width:100px;height:100px;border-radius:50%;background:#f8d7da;margin:0 auto 20px;display:flex;align-items:center;justify-content:center">
                <i class="fas fa-times-circle" style="font-size:50px;color:#e74c3c"></i>
            </div>
            
            <h3 style="color:#e74c3c;margin-bottom:10px">Berhasil Ditolak</h3>
            <p style="color:#666;margin-bottom:5px">
                <i class="fa-solid fa-clock"></i> Ditolak pada: <strong id="rejectTimestamp">-</strong>
            </p>
            
            <div style="background:#f8d7da;border:1px solid #f5c6cb;border-radius:8px;padding:15px;margin:20px 0">
                <div style="font-weight:600;color:#721c24;margin-bottom:10px;display:flex;align-items:center;justify-content:space-between">
                    <span>Daftar Pengajuan</span>
                    <span id="rejectItemCount" style="background:#e74c3c;color:white;padding:4px 12px;border-radius:20px;font-size:12px">0 item</span>
                </div>
                <div id="rejectList" style="max-height:250px;overflow-y:auto;text-align:left">
                    <!-- List akan diisi oleh JavaScript -->
                </div>
            </div>
            
            <div style="display:flex;gap:10px;justify-content:center;margin-top:20px">
                <button class="btn-bulk" onclick="closeModal('successRejectModal'); refreshPage();" style="background:#e74c3c;color:white;padding:10px 24px;border:none;border-radius:6px;cursor:pointer;font-weight:600;display:flex;align-items:center;gap:6px">
                    <i class="fa-solid fa-rotate"></i> Tutup & Refresh
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Eviden Modal (untuk multiple files) -->
<div id="evidenModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-image"></i> File Evidence</h3>
            <button class="close-modal" onclick="closeModal('evidenModal')">&times;</button>
        </div>
        <div class="detail-content" id="evidenContent">
            <!-- Content akan diisi oleh JavaScript -->
        </div>
    </div>
</div>

 <!-- Modal PIN -->
        <div id="pinModal" 
            style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;
            background:rgba(0,0,0,0.45);backdrop-filter:blur(3px);
            align-items:center;justify-content:center;z-index:9999">

            <div style="
                background:#ffffff;
                padding:28px;
                border-radius:14px;
                width:360px;
                text-align:center;
                animation: fadeIn 0.25s ease;
                box-shadow:0 12px 30px rgba(0,0,0,0.25);
            ">
                <h3 style="margin-bottom:18px;color:#333;font-weight:700;font-size:20px;">
                    <i class="fas fa-shield-alt" style="margin-right:8px;color:#16A085;"></i>
                    Verifikasi PIN
                </h3>

                <!-- Input PIN -->
                <div class="pin-input-container" style="position:relative;display:flex;justify-content:center;">
                    <i class="fas fa-key pin-icon" 
                    style="position:absolute;left:30px;top:50%;transform:translateY(-50%);color:#16A085;"></i>

                    <input type="password"
                        id="pinInput"
                        maxlength="6"
                        style="
                            width:220px;
                            padding:12px 40px;
                            border:2px solid #16A085;
                            border-radius:8px;
                            font-size:18px;
                            text-align:center;
                            letter-spacing:6px;
                            outline:none;
                        "
                        placeholder="••••••"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>

                <!-- Tombol -->
                <div style="display:flex;gap:12px;justify-content:center;margin-top:25px;">
                    <button onclick="checkPin()" 
                        style="
                            background:#16A085;
                            color:white;
                            border:none;
                            padding:10px 22px;
                            border-radius:7px;
                            cursor:pointer;
                            font-weight:600;
                        ">
                        <i class="fas fa-check"></i> Lanjut
                    </button>

                    <button onclick="closePinModal()"
                        style="
                            background:#7f8c8d;
                            color:white;
                            border:none;
                            padding:10px 22px;
                            border-radius:7px;
                            cursor:pointer;
                            font-weight:600;
                        ">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </div>
        <button onclick="openUbahPinModal()" 
                style="background:none;border:none;color:#16A085;margin-top:10px;cursor:pointer;font-weight:600;">
            Ubah PIN?
        </button>

                <p style="margin-top:15px;font-size:12px;color:#7f8c8d;">
                    <i class="fas fa-info-circle"></i> PIN terdiri dari 6 digit angka
                </p>
            </div>
        </div>

        <style>
        @keyframes fadeIn {
            from { opacity:0; transform: scale(0.94); }
            to   { opacity:1; transform: scale(1); }
        }
        </style>
        <!-- Modal Ubah PIN -->
        <div id="ubahPinModal" 
            style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;
            background:rgba(0,0,0,0.5);align-items:center;justify-content:center;z-index:9999">

            <div style="background:#fff;width:380px;padding:25px;border-radius:14px;
                box-shadow:0 15px 35px rgba(0,0,0,0.25);text-align:center;">

                <h2 style="margin-bottom:10px;color:#333;font-weight:700;">
                    <i class="fas fa-key" style="color:#16A085;margin-right:8px;"></i>
                    Ubah PIN
                </h2>

                <p style="font-size:13px;color:#777;margin-bottom:20px;">
                    Masukkan PIN lama dan PIN baru (6 digit).
                </p>

                <div style="text-align:left;margin-bottom:12px;">
                    <label>PIN Lama</label>
                    <input type="password" id="oldPin" maxlength="6"
                        style="width:100%;padding:10px;border:1px solid #ccc;border-radius:8px;margin-top:5px;"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                </div>

                <div style="text-align:left;">
                    <label>PIN Baru</label>
                    <input type="password" id="newPin" maxlength="6"
                        style="width:100%;padding:10px;border:1px solid #ccc;border-radius:8px;margin-top:5px;"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                </div>

                <div style="display:flex;gap:10px;margin-top:25px;justify-content:center;">
                    <button onclick="submitUbahPin()" 
                        style="background:#16A085;color:white;border:none;padding:10px 20px;
                        border-radius:8px;cursor:pointer;font-weight:600;">
                        Simpan
                    </button>

                    <button onclick="closeUbahPinModal()" 
                        style="background:#7f8c8d;color:white;border:none;padding:10px 20px;
                        border-radius:8px;cursor:pointer;font-weight:600;">
                        Batal
                    </button>
                </div>

                <p id="pinMsg" style="margin-top:12px;color:red;font-size:13px;"></p>

            </div>
        </div>


<!-- Return Modal -->
<div id="returnConfirmModal" class="modal">
    <div class="approve-modal-content">
        <div class="approve-modal-header" style="background: #ff9800;">
            <h3><i class="fa-solid fa-undo"></i> Konfirmasi Pengembalian</h3>
            <button class="close-modal" onclick="closeModal('returnConfirmModal')">&times;</button>
        </div>
        <div class="approve-modal-body">
            <div class="approve-info-box" style="background: #fff3e0; border-color: #ff9800;">
                <strong style="color: #ff9800;"><i class="fa-solid fa-exclamation-triangle"></i> Peringatan</strong>
                <span id="returnNamaKegiatan">-</span>
            </div>
            
            <p style="margin-bottom:20px;color:#e65100;font-weight:600">
                ⚠️ Pengajuan ini akan dikembalikan ke status sebelumnya dan dapat diajukan ulang.
            </p>
            
            <div class="approve-modal-actions">
                <button type="button" class="approve-btn approve-btn-cancel" onclick="closeModal('returnConfirmModal')">
                    <i class="fa-solid fa-times"></i> Batal
                </button>
                <button type="button" class="approve-btn" style="background: #ff9800;" onclick="confirmReturn()">
                    <i class="fa-solid fa-undo"></i> Ya, Kembalikan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Result Modal untuk Return -->
<div id="successReturnModal" class="modal">
    <div class="bulk-modal-content" style="max-width: 600px;">
        <div class="modal-header" style="background: #ff9800;">
            <h3><i class="fa-solid fa-undo"></i> <span id="successReturnTitle">Pengajuan Berhasil Dikembalikan</span></h3>
            <button class="close-modal" onclick="closeModal('successReturnModal')">&times;</button>
        </div>
        <div style="padding:25px;text-align:center">
            <div style="width:100px;height:100px;border-radius:50%;background:#fff3e0;margin:0 auto 20px;display:flex;align-items:center;justify-content:center">
                <i class="fas fa-undo" style="font-size:50px;color:#ff9800"></i>
            </div>
            
            <h3 style="color:#ff9800;margin-bottom:10px">Berhasil Dikembalikan</h3>
            <p style="color:#666;margin-bottom:5px">
                <i class="fa-solid fa-clock"></i> Dikembalikan pada: <strong id="returnTimestamp">-</strong>
            </p>
            
            <div style="background:#fff3e0;border:1px solid #ffcc80;border-radius:8px;padding:15px;margin:20px 0">
                <div style="font-weight:600;color:#e65100;margin-bottom:10px;display:flex;align-items:center;justify-content:space-between">
                    <span>Daftar Pengajuan</span>
                    <span id="returnItemCount" style="background:#ff9800;color:white;padding:4px 12px;border-radius:20px;font-size:12px">0 item</span>
                </div>
                <div id="returnList" style="max-height:250px;overflow-y:auto;text-align:left">
                    <!-- List akan diisi oleh JavaScript -->
                </div>
            </div>
            
            <div style="display:flex;gap:10px;justify-content:center;margin-top:20px">
                <button class="btn-bulk" onclick="closeModal('successReturnModal'); refreshPage();" style="background:#ff9800;color:white;padding:10px 24px;border:none;border-radius:6px;cursor:pointer;font-weight:600;display:flex;align-items:center;gap:6px">
                    <i class="fa-solid fa-rotate"></i> Tutup & Refresh
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Result Modal untuk Edit Sekretariat -->
<div id="successEditModal" class="modal">
<div class="bulk-modal-content" style="max-width: 600px;">
<div class="modal-header" style="background: #ff9800;">
    <h3><i class="fa-solid fa-pen-to-square"></i> <span id="successEditTitle">Edit Berhasil Disimpan</span></h3>
    <button class="close-modal" onclick="closeModal('successEditModal')">&times;</button>
</div>
<div style="padding:25px;text-align:center">
    <div style="width:100px;height:100px;border-radius:50%;background:#fff3e0;margin:0 auto 20px;display:flex;align-items:center;justify-content:center">
        <i class="fas fa-check" style="font-size:50px;color:#ff9800"></i>
    </div>
    
    <h3 style="color:#ff9800;margin-bottom:10px">Berhasil Diperbarui</h3>
    <p style="color:#666;margin-bottom:5px">
        <i class="fa-solid fa-clock"></i> Diperbarui pada: <strong id="editTimestamp">-</strong>
    </p>
    
    <div style="background:#fff3e0;border:1px solid #ffcc80;border-radius:8px;padding:15px;margin:20px 0">
        <div style="font-weight:600;color:#e65100;margin-bottom:10px;display:flex;align-items:center;justify-content:space-between">
            <span>Data Pengajuan</span>
            <span id="editItemCount" style="background:#ff9800;color:white;padding:4px 12px;border-radius:20px;font-size:12px">1 item</span>
        </div>
        <div id="editList" style="max-height:250px;overflow-y:auto;text-align:left">
            <!-- List akan diisi oleh JavaScript -->
        </div>
    </div>
    
    <div style="display:flex;gap:10px;justify-content:center;margin-top:20px">
        <button class="btn-bulk" onclick="closeModal('successEditModal'); refreshPage();" style="background:#ff9800;color:white;padding:10px 24px;border:none;border-radius:6px;cursor:pointer;font-weight:600;display:flex;align-items:center;gap:6px">
            <i class="fa-solid fa-rotate"></i> Tutup & Refresh
        </button>
    </div>
</div>
</div>
</div>

<!-- Success Result Modal untuk Revisi (Ditolak Dekan) -->
<div id="successRevisionModal" class="modal">
<div class="bulk-modal-content" style="max-width: 600px;">
<div class="modal-header" style="background: #17a2b8;">
    <h3><i class="fa-solid fa-paper-plane"></i> <span id="successRevisionTitle">Revisi Berhasil Dikirim</span></h3>
    <button class="close-modal" onclick="closeModal('successRevisionModal')">&times;</button>
</div>
<div style="padding:25px;text-align:center">
    <div style="width:100px;height:100px;border-radius:50%;background:#d1ecf1;margin:0 auto 20px;display:flex;align-items:center;justify-content:center">
        <i class="fas fa-paper-plane" style="font-size:50px;color:#17a2b8"></i>
    </div>
    
    <h3 style="color:#17a2b8;margin-bottom:10px">Berhasil Dikirim ke Dekan</h3>
    <p style="color:#666;margin-bottom:5px">
        <i class="fa-solid fa-clock"></i> Dikirim pada: <strong id="revisionTimestamp">-</strong>
    </p>
    
    <div style="background:#d1ecf1;border:1px solid #bee5eb;border-radius:8px;padding:15px;margin:20px 0">
        <div style="font-weight:600;color:#0c5460;margin-bottom:10px;display:flex;align-items:center;justify-content:space-between">
            <span>Data Pengajuan</span>
            <span id="revisionItemCount" style="background:#17a2b8;color:white;padding:4px 12px;border-radius:20px;font-size:12px">1 item</span>
        </div>
        <div id="revisionList" style="max-height:250px;overflow-y:auto;text-align:left">
            <!-- List akan diisi oleh JavaScript -->
        </div>
    </div>
    
    <div style="display:flex;gap:10px;justify-content:center;margin-top:20px">
        <button class="btn-bulk" onclick="closeModal('successRevisionModal'); refreshPage();" style="background:#17a2b8;color:white;padding:10px 24px;border:none;border-radius:6px;cursor:pointer;font-weight:600;display:flex;align-items:center;gap:6px">
            <i class="fa-solid fa-rotate"></i> Tutup & Refresh
        </button>
    </div>
</div>
</div>
</div>

<!-- Success Result Modal -->
<div id="successResultModal" class="modal">
    <div class="bulk-modal-content" style="max-width: 600px;">
        <div class="modal-header" style="background: #27ae60;">
            <h3><i class="fa-solid fa-check-circle"></i> <span id="successResultTitle">Pengajuan Berhasil Disetujui</span></h3>
            <button class="close-modal" onclick="closeModal('successResultModal')">&times;</button>
        </div>
        <div style="padding:25px;text-align:center">
            <div style="width:100px;height:100px;border-radius:50%;background:#d4edda;margin:0 auto 20px;display:flex;align-items:center;justify-content:center">
                <i class="fas fa-check" style="font-size:50px;color:#27ae60"></i>
            </div>
            
            <h3 style="color:#27ae60;margin-bottom:10px">Berhasil Disetujui</h3>
            <p style="color:#666;margin-bottom:5px">
                <i class="fa-solid fa-clock"></i> Disetujui pada: <strong id="successTimestamp">-</strong>
            </p>
            
            <div style="background:#d4edda;border:1px solid #c3e6cb;border-radius:8px;padding:15px;margin:20px 0">
                <div style="font-weight:600;color:#155724;margin-bottom:10px;display:flex;align-items:center;justify-content:space-between">
                    <span>Daftar Pengajuan</span>
                    <span id="successItemCount" style="background:#27ae60;color:white;padding:4px 12px;border-radius:20px;font-size:12px">0 item</span>
                </div>
                <div id="successList" style="max-height:250px;overflow-y:auto;text-align:left">
                    <!-- List akan diisi oleh JavaScript -->
                </div>
            </div>
            
            <div style="display:flex;gap:10px;justify-content:center;margin-top:20px">
                <button class="btn-bulk" onclick="closeModal('successResultModal'); refreshPage();" style="background:#27ae60;color:white;padding:10px 24px;border:none;border-radius:6px;cursor:pointer;font-weight:600;display:flex;align-items:center;gap:6px">
                    <i class="fa-solid fa-rotate"></i> Tutup & Refresh
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// ============================================
// VARIABEL GLOBAL (SAMA SEPERTI DASHBOARD)
// ============================================
let currentRejectId = null;
let currentRejectNamaKegiatan = null;   
let currentApproveId = null;
let currentNomorSuratId = null;
let currentNomorSuratNama = null;
let currentReturnId = null;
let currentReturnNamaKegiatan = null;
let selectedSurat = null;

// ============================================
// FUNGSI DISPOSISI (SAMA SEPERTI DASHBOARD)
// ============================================

// OPEN PIN POPUP
function openPinModal(id, event) {
    if (event) event.stopPropagation();
    selectedSurat = id;
    document.getElementById("pinModal").style.display = "flex";
    document.getElementById("pinInput").focus();
}

// CLOSE PIN POPUP
function closePinModal() {
    document.getElementById("pinModal").style.display = "none";
    document.getElementById("pinInput").value = "";
}

function checkPin() {
    let pin = document.getElementById("pinInput").value;

    // Validasi input
    if (!pin) {
        alert("PIN harus diisi!");
        return;
    }

    if (pin.length !== 6) {
        alert("PIN harus 6 digit!");
        return;
    }

    if (!/^[0-9]{6}$/.test(pin)) {
        alert("PIN harus berupa angka!");
        return;
    }

    // Kirim request
    fetch("<?= base_url('sekretariat/cek_pin') ?>", {
        method: "POST",
        headers: { 
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: JSON.stringify({ pin: pin })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('HTTP error! status: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.status === "success") {
            
            // Tampilkan dropdown disposisi
            if (selectedSurat) {
                document.getElementById("disposisiBox" + selectedSurat).style.display = "block";
            }
            
            // Tutup modal PIN
            closePinModal();
        } else {
            // PIN salah
            alert(data.message || "PIN salah!");
            document.getElementById("pinInput").value = "";
            document.getElementById("pinInput").focus();
        }
    })
    .catch(error => {
        console.error("Fetch Error:", error);
        alert("Terjadi kesalahan: " + error.message);
    });
}

// PADA SAAT MEMILIH DISPOSISI
function onDisposisiChange(id) {
    let val = document.getElementById("disposisiSelect" + id).value;
    let catatanLabel = document.getElementById("labelCatatan" + id);
    let catatanTextarea = document.getElementById("catatanDisposisi" + id);
    let btnSave = document.getElementById("btnSaveDisposisi" + id);

    // Reset dulu
    btnSave.style.display = "none";
    catatanLabel.style.display = "none";
    catatanTextarea.style.display = "none";
    
    // Kosongkan textarea setiap kali pilihan berubah
    if (catatanTextarea) catatanTextarea.value = "";
    
    // Untuk disposisi yang memerlukan catatan
    if (val === "Hold/Pending" || val === "Batal" ) {
        if (catatanLabel) catatanLabel.style.display = "block";
        if (catatanTextarea) {
            catatanTextarea.style.display = "block";
            btnSave.style.display = "block";

        // Set placeholder berdasarkan pilihan
        if (val === "Hold/Pending") {
            catatanTextarea.placeholder = "Berikan alasan mengapa perlu ditahan/ditunda...";
        } else if (val === "Batal") {
            catatanTextarea.placeholder = "Berikan alasan pembatalan...";
        }
        // Fokus ke textarea
        setTimeout(() => {
            if (catatanTextarea) catatanTextarea.focus();
        }, 100);
        }
    } else if (val === "Lanjut Proses ✔"){
        if (btnSave) btnSave.style.display = "block";
    }
}

// SIMPAN DISPOSISI - UPDATED
function saveDisposisi(id) {
    let disposisi = document.getElementById("disposisiSelect" + id).value;
    let catatanTextarea = document.getElementById("catatanDisposisi" + id);
    let catatan = catatanTextarea ? catatanTextarea.value : "";

    if (!disposisi) {
        alert("Pilih disposisi dulu!");
        return;
    }

    if ((disposisi === "Hold/Pending" || disposisi === "Batal") && catatan === "") {
        alert("Wajib Mengisi Catatan!");
        return;
    }

    // Konfirmasi khusus untuk disposisi Batal
    if (disposisi === "Batal") {
        if (!confirm("⚠️ Pengajuan ini akan DITOLAK oleh Sekretariat.\n\nLanjutkan?")) {
            return;
        }
    }

    fetch("<?= base_url('sekretariat/set_disposisi') ?>", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            id: id,
            disposisi: disposisi,
            catatan: catatan
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            if (disposisi === "Batal") {
                alert("✅ Disposisi tersimpan!\n\n📌 Status pengajuan diubah menjadi: DITOLAK SEKRETARIAT");
            } else {
                alert("✅ Disposisi tersimpan!");
            }
            location.reload();
        } else {
            alert("❌ Gagal menyimpan disposisi. Silakan coba lagi.");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("❌ Terjadi kesalahan. Silakan coba lagi.");
    });
}

// ============================================
// FUNGSI UTAMA: PERBEDAAN KLIK BARIS vs TOMBOL MATA
// ============================================

// 1. FUNGSI UNTUK KLIK BARIS (Detail Pengajuan)
async function showDetailFromRow(id) {
    try {
        document.getElementById('detailContent').innerHTML = `
            <div style="text-align:center;padding:40px;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#16A085"></i>
                <p style="margin-top:10px;color:#7f8c8d">Memuat detail pengajuan...</p>
            </div>
        `;
        
        document.getElementById('detailModal').classList.add('show');
        
        // Ambil data via AJAX
        const response = await fetch('<?= site_url("sekretariat/getDetailPengajuan/") ?>' + id);
        const data = await response.json();
        
        if (!data.success) {
            throw new Error('Data tidak ditemukan');
        }
        
        const detailHtml = generateDetailContent(data.data);
        document.getElementById('detailContent').innerHTML = detailHtml;
        
    } catch (error) {
        console.error('Error loading detail:', error);
        document.getElementById('detailContent').innerHTML = `
            <div style="text-align:center;padding:40px;color:#e74c3c">
                <i class="fa-solid fa-exclamation-triangle" style="font-size:48px;margin-bottom:10px"></i>
                <p>Gagal memuat detail: ${error.message}</p>
                <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal')" style="margin-top:20px">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
            </div>
        `;
    }
}

// 2. FUNGSI UNTUK TOMBOL MATA (Preview Surat - Iframe)
function showSuratPreview(id) {
    const viewUrl = "<?= base_url('sekretariat/view_surat_pengajuan/') ?>" + id; // HTML
    const pdfUrl  = "<?= base_url('sekretariat/download_pdf/') ?>" + id;        // PDF asli

    document.getElementById('suratPreviewContent').innerHTML = `
        <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
            
            <!-- TOMBOL DOWNLOAD -->
            <button onclick="downloadPDF('${pdfUrl}')"
                style="padding:8px 15px; background:#16A085; color:white; border:none; border-radius:6px; cursor:pointer;">
                <i class="fa fa-download"></i> Download
            </button>

            <!-- TOMBOL PRINT -->
            <button onclick="printPDF('${pdfUrl}')"
                style="padding:8px 15px; background:#2c3e50; color:white; border:none; border-radius:6px; cursor:pointer;">
                <i class="fa fa-print"></i> Print
            </button>
        </div>

        <!-- VIEW HTML -->
        <iframe id="pdfFrame"
            src="${viewUrl}"
            style="width:100%; height:85vh; border:none; border-radius:10px;"
            
                    onload="adjustIframeHeight()">
        </iframe>
    `;

    document.getElementById("suratPreviewModal").classList.add("show");
}

// Fungsi untuk menyesuaikan tinggi iframe berdasarkan konten
function adjustIframeHeight() {
    const iframe = document.getElementById('pdfFrame');
    if (!iframe) return;
    
    try {
        // Tunggu sedikit untuk konten selesai dimuat
        setTimeout(() => {
            try {
                const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                const body = iframeDoc.body;
                const html = iframeDoc.documentElement;
                
                // Hitung tinggi maksimum
                const height = Math.max(
                    body.scrollHeight,
                    body.offsetHeight,
                    html.clientHeight,
                    html.scrollHeight,
                    html.offsetHeight
                );
                
                // Set tinggi iframe
                iframe.style.height = (height + 50) + 'px'; // Tambah margin
                
                console.log('Iframe height adjusted to:', height);
            } catch (e) {
                console.error('Error adjusting iframe height:', e);
                // Fallback: set tinggi tetap
                iframe.style.height = '1000px';
            }
        }, 500); // Tunggu 500ms untuk konten selesai dimuat
    } catch (e) {
        console.error('Error accessing iframe content:', e);
    }
}
function printPDF(url) {
    fetch(url)
        .then(res => res.blob())
        .then(blob => {
            const blobUrl = URL.createObjectURL(blob);
            const iframe = document.createElement("iframe");
            iframe.style.display = "none";
            iframe.src = blobUrl;
            document.body.appendChild(iframe);

            iframe.onload = function () {
                iframe.contentWindow.print();
            };
        });
}

function downloadPDF(url) {
    window.location.href = url;
}

// ============================================
// FUNGSI GENERATE DETAIL CONTENT (untuk klik baris)
// ============================================

function generateDetailContent(item) {
    const getVal = (k) => {
        const value = (item[k] !== undefined && item[k] !== null && item[k] !== '' ? item[k] : '-');
        return value;
    };

    let statusBadge = '';
    const status = getVal('status').toLowerCase();

    if (status.includes('setuju')) {
        statusBadge = `<span class="badge badge-approved">${getVal('status')}</span>`;
    } else if (status.includes('tolak')) {
        statusBadge = `<span class="badge badge-rejected">${getVal('status')}</span>`;
    } else {
        statusBadge = `<span class="badge badge-pending">${getVal('status')}</span>`;
    }

    const dosenData = item.dosen_data || [];

      // ✅ Generate HTML untuk data dosen DENGAN FOTO (TANPA INITIAL)
let dosenHtml = '';
if (dosenData && dosenData.length > 0) {
    dosenHtml = `
    <div class="dosen-list">
        ${dosenData.map((dosen, index) => {
            const initial = dosen.nama ? dosen.nama.charAt(0).toUpperCase() : '?';
            const foto = dosen.foto || '';
            const hasFoto = foto && foto.trim() !== '' && foto !== 'null';
            
            console.log(`Dosen ${index + 1}:`, dosen.nama, 'Foto:', foto, 'Has Foto:', hasFoto); // ✅ DEBUG
            
            return `
        <div class="dosen-item">
            <div class="dosen-avatar" style="width: 32px; height: 32px; border-radius: 50%; background: #8E44AD; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; font-weight: 600; overflow: hidden; position: relative;">
                ${hasFoto ? `
                    <img src="${escapeHtml(foto)}" 
                         alt="${escapeHtml(dosen.nama)}" 
                         style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: 2;"
                         onerror="console.error('Image load error:', this.src); this.style.display='none'; this.parentElement.style.background='#8E44AD';">
                ` : `
                    <span style="position: relative; z-index: 1;">${initial}</span>
                `}
            </div>
            <div class="dosen-info">
                <div class="dosen-name">${escapeHtml(dosen.nama)}</div>
                <div class="dosen-details">
                    NIP: ${escapeHtml(dosen.nip)} | ${escapeHtml(dosen.jabatan)} | Divisi: ${escapeHtml(dosen.divisi)}
                </div>
            </div>
        </div>
            `;
        }).join('')}
    </div>`;
} else {
    dosenHtml = `
    <div class="dosen-item">
        <div class="dosen-avatar" style="width: 32px; height: 32px; border-radius: 50%; background: #8E44AD; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; font-weight: 600;">
            <span>?</span>
        </div>
        <div class="dosen-info">
            <div class="dosen-name">Data dosen tidak tersedia</div>
            <div class="dosen-details">Informasi dosen tidak ditemukan</div>
        </div>
    </div>`;
}

    let nomorSuratHtml = '';
    if (getVal('nomor_surat') && getVal('nomor_surat') !== '-') {
        nomorSuratHtml = `
        <div style="background:#e8f6f3;border:2px solid #16A085;border-radius:10px;padding:15px;margin-bottom:20px;text-align:center">
            <div style="font-size:14px;font-weight:600;color:#16A085;margin-bottom:5px;text-transform:uppercase;letter-spacing:1px">
                <i class="fa-solid fa-file-signature"></i> Nomor Surat
            </div>
            <div style="font-size:18px;font-weight:700;color:#117864;font-family:'Courier New',monospace">
                ${escapeHtml(getVal('nomor_surat'))}
            </div>
        </div>`;
    }

    let rejectionHtml = '';
    if (getVal('catatan_penolakan') && getVal('catatan_penolakan') !== '-') {
        rejectionHtml = `
        <div style="background:#fff5f5;border:1px solid #f8d7da;border-radius:8px;padding:20px;margin-top:15px">
            <div style="font-weight:600;color:#dc3545;margin-bottom:8px">
                <i class="fa-solid fa-comment-dots"></i> Catatan Penolakan
            </div>
            <div style="background:#fff5f5;border-color:#f8d7da;color:#721c24;font-size:14px;line-height:1.5;padding:12px;border-radius:8px">
                ${escapeHtml(getVal('catatan_penolakan'))}
            </div>
        </div>`;
    }

    const jenisDate = getVal('jenis_date');
    const periodeValue = getVal('periode_value');
    const tanggalKegiatan = getVal('tanggal_kegiatan');
    const akhirKegiatan = getVal('akhir_kegiatan');

    let periodeDisplay = '-';
    let tanggalMulaiDisplay = '-';
    let tanggalAkhirDisplay = '-';

    if (jenisDate === 'Periode') {
        periodeDisplay = periodeValue !== '-' && periodeValue ? periodeValue : '-';
        tanggalMulaiDisplay = '-';
        tanggalAkhirDisplay = '-';
    } else if (jenisDate === 'Custom') {
        periodeDisplay = '-';
        if (tanggalKegiatan !== '-' && tanggalKegiatan) {
            tanggalMulaiDisplay = formatDate(tanggalKegiatan);
        }
        if (akhirKegiatan !== '-' && akhirKegiatan) {
            tanggalAkhirDisplay = formatDate(akhirKegiatan);
        }
    } else {
        if (periodeValue && periodeValue !== '-') {
            periodeDisplay = periodeValue;
        } else if (tanggalKegiatan && tanggalKegiatan !== '-') {
            tanggalMulaiDisplay = formatDate(tanggal_kegiatan);
            if (akhirKegiatan && akhirKegiatan !== '-') {
                tanggalAkhirDisplay = formatDate(akhirKegiatan);
            }
        }
    }

    return `
    ${nomorSuratHtml}
    
    <div class="detail-section">
        <div class="detail-section-title">
            <i class="fa-solid fa-info-circle"></i> Informasi Utama
        </div>
        <div class="detail-grid">
            <div class="detail-row">
                <div class="detail-label">Nama Kegiatan</div>
                <div class="detail-value">${escapeHtml(getVal('nama_kegiatan'))}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Status Pengajuan</div>
                <div class="detail-value">${statusBadge}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Jenis Pengajuan</div>
                <div class="detail-value">${escapeHtml(getVal('jenis_pengajuan'))}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Lingkup Penugasan</div>
                <div class="detail-value">${escapeHtml(getVal('lingkup_penugasan'))}</div>
            </div>
        </div>
    </div>
    
    <div class="detail-section">
        <div class="detail-section-title">
            <i class="fa-solid fa-users"></i> Dosen Terkait
        </div>
        ${dosenHtml}
    </div>
    
    <div class="detail-section">
        <div class="detail-section-title">
            <i class="fa-solid fa-calendar-alt"></i> Informasi Waktu & Tempat
        </div>
        <div class="detail-grid">
            <div class="detail-row">
                <div class="detail-label">Penyelenggara</div>
                <div class="detail-value">${escapeHtml(getVal('penyelenggara'))}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Jenis Tanggal</div>
                <div class="detail-value">${escapeHtml(jenisDate !== '-' ? jenisDate : '-')}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Periode Kegiatan</div>
                <div class="detail-value ${periodeDisplay === '-' ? 'detail-value-empty' : ''}">${escapeHtml(periodeDisplay)}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Tanggal Mulai</div>
                <div class="detail-value ${tanggalMulaiDisplay === '-' ? 'detail-value-empty' : ''}">${tanggalMulaiDisplay}</div>
            </div>
            ${tanggalAkhirDisplay !== '-' ? `
            <div class="detail-row">
                <div class="detail-label">Tanggal Akhir</div>
                <div class="detail-value">${tanggalAkhirDisplay}</div>
            </div>
            ` : ''}
            <div class="detail-row">
                <div class="detail-label">Tempat Kegiatan</div>
                <div class="detail-value">${escapeHtml(getVal('tempat_kegiatan'))}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Tanggal Pengajuan</div>
                <div class="detail-value">${formatDate(getVal('created_at'))}</div>
            </div>
        </div>
    </div>
    
    ${rejectionHtml}
    
    <div class="modal-actions">
        <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal')">
            <i class="fa-solid fa-times"></i> Tutup
        </button>
    </div>`;
}

// ============================================
// FUNGSI EVIDEN (SAMA SEPERTI DASHBOARD)
// ============================================

// Preview File Functions
function previewFile(fileUrl, fileName) {
    const previewModal = document.getElementById('previewModal');
    const previewTitle = document.getElementById('previewTitle');
    const previewBody = document.getElementById('previewBody');
    
    previewTitle.textContent = 'Preview: ' + fileName;
    previewBody.innerHTML = `
        <div style="text-align: center; padding: 40px;">
            <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #16A085;"></i>
            <p style="margin-top: 15px; color: #6c757d;">Memuat preview...</p>
        </div>
    `;
    
    previewModal.classList.add('show');

    const fileExtension = fileName.split('.').pop().toLowerCase();
    const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
    const pdfExtensions = ['pdf'];
    
    setTimeout(() => {
        if (imageExtensions.includes(fileExtension)) {
            const img = new Image();
            img.onload = function() {
                previewBody.innerHTML = `<img src="${fileUrl}" class="preview-image" alt="${fileName}">`;
            };
            img.onerror = function() {
                showUnsupportedPreview(fileUrl, fileName);
            };
            img.src = fileUrl;
        } else if (pdfExtensions.includes(fileExtension)) {
            previewBody.innerHTML = `
                <iframe 
                    src="${fileUrl}" 
                    class="preview-iframe" 
                    frameborder="0"
                ></iframe>
            `;
        } else {
            showUnsupportedPreview(fileUrl, fileName);
        }
    }, 100);
}

function showUnsupportedPreview(fileUrl, fileName) {
    document.getElementById('previewBody').innerHTML = `
        <div class="preview-unsupported">
            <i class="fas fa-eye-slash"></i>
            <h4>Preview Tidak Tersedia</h4>
            <p>File "${escapeHtml(fileName)}" tidak dapat dipreview di browser.</p>
            <a href="${fileUrl}" class="download-btn" download="${fileName}" target="_blank" style="margin-top: 15px;">
                <i class="fas fa-download"></i> Download File
            </a>
        </div>
    `;
}

function closePreviewModal() {
    document.getElementById('previewModal').classList.remove('show');
}

// Fungsi untuk menampilkan modal eviden
async function showEvidenModal(suratId, event) {
    if (event) event.stopPropagation();
    
    try {
        // Ambil data detail via AJAX
        const response = await fetch('<?= site_url("sekretariat/getDetailPengajuan/") ?>' + suratId);
        const data = await response.json();
        
        if (!data.success) {
            alert('Data tidak ditemukan');
            return;
        }

        const item = data.data;
        // Ambil dan proses data eviden
        const evidenFiles = getEvidenFilesFromData(item);
        
        if (evidenFiles.length === 0) {
            alert('Tidak ada file eviden untuk pengajuan ini.');
            return;
        }
        
        // LOGIKA BARU: Jika hanya 1 file, langsung preview
        if (evidenFiles.length === 1) {
            const file = evidenFiles[0];
            previewFile(file.url, file.name);
        } else {
            // Jika lebih dari 1 file, tampilkan modal daftar file
            showMultipleEvidenModal(item, evidenFiles);
        }
        
    } catch (error) {
        console.error('Error loading eviden:', error);
        alert('Gagal memuat eviden: ' + error.message);
    }
}

// Fungsi helper untuk mendapatkan array file eviden dari data
function getEvidenFilesFromData(item) {
    const getVal = (k) => {
        const value = (item[k] !== undefined && item[k] !== null && item[k] !== '' ? item[k] : '-');
        return value;
    };

    const evidenValue = getVal('eviden');
    const baseUrl = '<?= base_url() ?>';
    let evidenFiles = [];
    
    if (evidenValue && evidenValue !== '-') {
        try {
            // Coba parse JSON jika eviden adalah array
            if (Array.isArray(evidenValue)) {
                evidenValue.forEach(file => {
                    if (file && file !== '-' && file !== 'null') {
                        const fileName = getFileNameFromPath(file);
                        const fileUrl = getFileUrl(file, baseUrl);
                        evidenFiles.push({
                            name: fileName,
                            url: fileUrl,
                            ext: fileName.split('.').pop().toLowerCase()
                        });
                    }
                });
            } else if (typeof evidenValue === 'string' && evidenValue.startsWith('[')) {
                const parsed = JSON.parse(evidenValue);
                if (Array.isArray(parsed)) {
                    parsed.forEach(file => {
                        if (file && file !== '-' && file !== 'null') {
                            const fileName = getFileNameFromPath(file);
                            const fileUrl = getFileUrl(file, baseUrl);
                            evidenFiles.push({
                                name: fileName,
                                url: fileUrl,
                                ext: fileName.split('.').pop().toLowerCase()
                            });
                        }
                    });
                }
            } else {
                // Single file string
                const fileName = getFileNameFromPath(evidenValue);
                const fileUrl = getFileUrl(evidenValue, baseUrl);
                evidenFiles.push({
                    name: fileName,
                    url: fileUrl,
                    ext: fileName.split('.').pop().toLowerCase()
                });
            }
        } catch (e) {
            // Fallback: treat as single file
            const fileName = getFileNameFromPath(evidenValue);
            const fileUrl = getFileUrl(evidenValue, baseUrl);
            evidenFiles.push({
                name: fileName,
                url: fileUrl,
                ext: fileName.split('.').pop().toLowerCase()
            });
        }
    }
    
    return evidenFiles;
}

// Helper function untuk mendapatkan nama file dari path
function getFileNameFromPath(path) {
    if (!path) return 'file';
    return path.split('/').pop().split('\\').pop();
}

// Helper function untuk mendapatkan URL file yang lengkap
function getFileUrl(filePath, baseUrl) {
    if (!filePath) return '#';
    
    // Jika sudah URL lengkap
    if (filePath.startsWith('http://') || filePath.startsWith('https://') || filePath.startsWith('<?= base_url() ?>')) {
        return filePath;
    }
    
    // Coba beberapa kemungkinan path
    const fileName = getFileNameFromPath(filePath);
    const possiblePaths = [
        'uploads/eviden/' + fileName,
        'eviden/' + fileName,
        'assets/eviden/' + fileName,
        'uploads/' + fileName,
        filePath  // original path
    ];
    
    // Gunakan path pertama
    return baseUrl + possiblePaths[0];
}

// Fungsi untuk menampilkan modal multiple eviden (lebih dari 1 file)
function showMultipleEvidenModal(item, evidenFiles) {
    // Tampilkan loading
    document.getElementById('evidenContent').innerHTML = `
        <div style="text-align:center;padding:40px;">
            <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#16A085"></i>
            <p style="margin-top:10px;color:#7f8c8d">Memuat eviden...</p>
    `;
    
    document.getElementById('evidenModal').classList.add('show');
    
    // Generate content
    const content = generateMultipleEvidenContent(item, evidenFiles);
    document.getElementById('evidenContent').innerHTML = content;
}

// Fungsi untuk generate konten multiple eviden (lebih dari 1 file)
function generateMultipleEvidenContent(item, evidenFiles) {
    // Helper function
    const getVal = (k) => {
        const value = (item[k] !== undefined && item[k] !== null && item[k] !== '' ? item[k] : '-');
        return value;
    };

    // Generate file evidence HTML untuk multiple files
    let fileEvidenceHtml = '';
    
    if (evidenFiles.length > 0) {
        fileEvidenceHtml = `
        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fa-solid fa-paperclip"></i> File Evidence (${evidenFiles.length} file)
            </div>
            <div class="file-evidence">`;
        
        evidenFiles.forEach((file, index) => {
            const ext = file.ext;
            let fileIcon = 'fa-file';
            let canPreview = false;
            
            if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(ext)) {
                fileIcon = 'fa-file-image';
                canPreview = true;
            } else if (ext === 'pdf') {
                fileIcon = 'fa-file-pdf';
                canPreview = true;
            } else if (['doc', 'docx'].includes(ext)) {
                fileIcon = 'fa-file-word';
            } else if (['xls', 'xlsx'].includes(ext)) {
                fileIcon = 'fa-file-excel';
            }
            
            fileEvidenceHtml += `
                <div class="file-item">
                    <div class="file-icon">
                        <i class="fa-solid ${fileIcon}"></i>
                    </div>
                    <div class="file-info" ${canPreview ? `onclick="previewFile('${file.url}', '${file.name}')" style="cursor: pointer;"` : ''}>
                        <div class="file-name" ${canPreview ? 'title="Klik untuk preview"' : ''}>${escapeHtml(file.name)}</div>
                        <div class="file-size">File ${index + 1} - ${ext.toUpperCase()}</div>
                    </div>
                    ${canPreview ? 
                        `<button class="preview-btn" onclick="previewFile('${file.url}', '${file.name}')">
                            <i class="fa-solid fa-eye"></i> Preview
                        </button>` :
                        `<button class="preview-btn disabled" disabled title="Preview tidak tersedia">
                            <i class="fa-solid fa-eye-slash"></i> Preview
                        </button>`
                    }
                    <a href="${file.url}" target="_blank" class="download-btn" download="${file.name}">
                        <i class="fa-solid fa-download"></i> Download
                    </a>
                </div>`;
        });
        
        fileEvidenceHtml += `
            </div>
        </div>`;
    } else {
        fileEvidenceHtml = `
        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fa-solid fa-paperclip"></i> File Evidence
            </div>
            <div style="text-align:center;padding:40px;color:#6c757d">
                <i class="fa-solid fa-file" style="font-size:48px;margin-bottom:15px;opacity:0.3"></i>
                <p>Tidak ada file eviden untuk pengajuan ini.</p>
            </div>
        </div>`;
    }

    return `       
        ${fileEvidenceHtml}
        
        <div class="modal-actions">
            <button class="modal-btn modal-btn-close" onclick="closeModal('evidenModal')">
                <i class="fa-solid fa-times"></i> Tutup
            </button>
        </div>
    `;
}

// ============================================
// FUNGSI APPROVE & REJECT (SAMA SEPERTI DASHBOARD)
// ============================================

function showApproveModal(id, namaKegiatan, event) {
    if (event) event.stopPropagation();
    currentApproveId = id;
    document.getElementById('approveNamaKegiatan').textContent = '"' + namaKegiatan + '"';
    document.getElementById('approveModal').classList.add('show');
}

function submitApprove() {
    if (!currentApproveId) return;
    
    // Kirim request tanpa nomor surat
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= base_url("sekretariat/approve/") ?>' + currentApproveId;
    
    const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
    const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
    
    // Tambahkan CSRF token saja
    const inpCsrf = document.createElement('input');
    inpCsrf.type = 'hidden';
    inpCsrf.name = csrfName;
    inpCsrf.value = csrfHash;
    form.appendChild(inpCsrf);
    
    document.body.appendChild(form);
    form.submit();
}

function showRejectModalNew(id, namaKegiatan) {
    currentRejectId = id;
    currentRejectNamaKegiatan = namaKegiatan;
    
    // Set data ke modal
    document.getElementById('rejectNamaKegiatan').textContent = namaKegiatan;
    document.getElementById('rejectionReason').value = '';
    document.getElementById('rejectForm').action = '<?= base_url("sekretariat/reject/") ?>' + id;
    
    // Tampilkan modal
    document.getElementById('rejectConfirmModal').classList.add('show');
}

// ============================================
// FUNGSI RETURN (SAMA SEPERTI DASHBOARD)
// ============================================

// Fungsi untuk menampilkan return modal
function showReturnModal(id, namaKegiatan, event) {
    if (event) event.stopPropagation();
    currentReturnId = id;
    currentReturnNamaKegiatan = namaKegiatan;
    
    // Set data ke modal
    document.getElementById('returnNamaKegiatan').textContent = namaKegiatan;
    
    // Tampilkan modal yang benar (returnConfirmModal, bukan returnModal)
    document.getElementById('returnConfirmModal').classList.add('show');
}

// Fungsi untuk konfirmasi return
function confirmReturn() {
    if (!currentReturnId) return;
    
    // Buat form dan submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= base_url("sekretariat/return_pengajuan/") ?>' + currentReturnId;
    
    const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
    const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
    
    // Tambahkan CSRF token
    const inpCsrf = document.createElement('input');
    inpCsrf.type = 'hidden';
    inpCsrf.name = csrfName;
    inpCsrf.value = csrfHash;
    form.appendChild(inpCsrf);
    
    document.body.appendChild(form);
    form.submit();
}

// ============================================
// FUNGSI NOMOR SURAT (SAMA SEPERTI DASHBOARD)
// ============================================

// Fungsi untuk membuka modal nomor surat
async function openNomorSuratModal(id, namaKegiatan, event) {
    if (event) event.stopPropagation();
    
    currentNomorSuratId = id;
    currentNomorSuratNama = namaKegiatan;

    // Tampilkan loading
    document.getElementById('nomorSuratInfoBox').innerHTML = `
        <div style="text-align:center;padding:10px">
            <i class="fa-solid fa-spinner fa-spin" style="color:#16A085"></i>
            <p style="color:#7f8c8d;margin-top:5px">Memuat data...</p>
        </div>
    `;

    // Reset form
    document.getElementById('nomorSuratInput').value = '';
    document.getElementById('nomorSuratError').style.display = 'none';
    document.getElementById('nomorSuratError').textContent = '';

    // Tampilkan modal
    document.getElementById('nomorSuratModal').classList.add('show');

    try {
        // Ambil data surat via AJAX
        const response = await fetch('<?= site_url("sekretariat/get_data_for_nomor_surat/") ?>' + id);
        const data = await response.json();
        
        if (data.success) {
            const suratData = data.data;
            
            // Update info box
            let nomorStatus = '';
            if (suratData.nomor_surat) {
                nomorStatus = `<span style="color:#27ae60;font-weight:600">${escapeHtml(suratData.nomor_surat)}</span>`;
            } else {
                nomorStatus = '<span style="color:#e74c3c;font-weight:600">Belum diisi</span>';
            }
            
            document.getElementById('nomorSuratInfoBox').innerHTML = `
                <strong><i class="fa-solid fa-info-circle"></i> Informasi Surat</strong>
                <p style="margin:8px 0 5px 0">
                    <strong>Nama Kegiatan:</strong> ${escapeHtml(suratData.nama_kegiatan)}
                </p>
                <p style="margin:5px 0">
                    <strong>Status:</strong> <span class="badge badge-approved" style="display:inline-block">${escapeHtml(suratData.status)}</span>
                </p>
                <p style="margin:5px 0">
                    <strong>Nomor Surat Saat Ini:</strong> ${nomorStatus}
                </p>
            `;
            
            // Isi input jika sudah ada nomor surat
            if (suratData.nomor_surat) {
                document.getElementById('nomorSuratInput').value = suratData.nomor_surat;
            }
            
            // Set hidden ID
            document.getElementById('nomorSuratId').value = id;
            
            // Focus ke input
            setTimeout(() => {
                document.getElementById('nomorSuratInput').focus();
            }, 300);
            
        } else {
            document.getElementById('nomorSuratInfoBox').innerHTML = `
                <div style="color:#e74c3c;text-align:center;padding:10px">
                    <i class="fa-solid fa-exclamation-triangle"></i>
                    <p>${data.message || 'Gagal memuat data surat.'}</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error loading surat data:', error);
        document.getElementById('nomorSuratInfoBox').innerHTML = `
            <div style="color:#e74c3c;text-align:center;padding:10px">
                <i class="fa-solid fa-exclamation-triangle"></i>
                <p>Terjadi kesalahan saat memuat data.</p>
            </div>
        `;
    }
}

// ============================================
// FUNGSI CLOSE MODAL
// ============================================

function closeModal(id) { 
    document.getElementById(id).classList.remove('show'); 
}

// ============================================
// HELPER FUNCTIONS
// ============================================

function formatDate(d) {
    if (!d || d === '-' || d === '0000-00-00') return '-';
    const t = new Date(d);
    if (isNaN(t)) return d;
    return t.toLocaleDateString('id-ID', { day:'2-digit', month: 'short', year:'numeric' });
}

function escapeHtml(unsafe) {
    if (unsafe === null || unsafe === undefined) return '-';
    return String(unsafe)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

function refreshPage() {
    window.location.reload();
}

// ============================================
// EVENT HANDLERS & INITIALIZATION
// ============================================

function makeRowsClickable() {
    const rows = document.querySelectorAll('#tableBody tr.clickable-row');
    
    rows.forEach(row => {
        const suratId = row.getAttribute('data-id');
        
        if (suratId) {
            row.addEventListener('click', function(e) {
                // Cek apakah yang diklik adalah element yang tidak boleh trigger row click
                const clickedElement = e.target;
                const isClickableElement = 
                    clickedElement.closest('button') || 
                    clickedElement.closest('a') || 
                    clickedElement.closest('select') ||
                    clickedElement.closest('textarea') ||
                    clickedElement.closest('input') ||
                    clickedElement.closest('.btn') ||
                    clickedElement.closest('.btn-disposisi') ||
                    clickedElement.closest('.disposisi-card') ||
                    clickedElement.closest('.file-info') ||
                    clickedElement.closest('.preview-btn') ||
                    clickedElement.closest('.download-btn');
                
                if (isClickableElement) {
                    return;
                }
                
                // Highlight baris yang dipilih
                rows.forEach(r => r.classList.remove('selected'));
                this.classList.add('selected');
                
                // Tampilkan modal detail pengajuan
                showDetailFromRow(suratId);
            });
            
            row.style.cursor = 'pointer';
        }
    });
}

function initializeEventListeners() {
    makeRowsClickable();
    
    // Event listener untuk form nomor surat
    document.getElementById('nomorSuratForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();

        const id = document.getElementById('nomorSuratId').value;
        const nomorSurat = document.getElementById('nomorSuratInput').value.trim();
        const errorDiv = document.getElementById('nomorSuratError');

        // Reset error
        errorDiv.style.display = 'none';
        errorDiv.textContent = '';

        if (!nomorSurat) {
            errorDiv.textContent = 'Nomor surat harus diisi!';
            errorDiv.style.display = 'block';
            return;
        }

        // Disable submit button
        const submitBtn = this.querySelector('.approve-btn-submit');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';
        submitBtn.disabled = true;

        try {
            // Kirim data via AJAX
            const formData = new FormData();
            formData.append('nomor_surat', nomorSurat);
            formData.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');
            
            const response = await fetch('<?= site_url("sekretariat/tambah_nomor_surat_ajax/") ?>' + id, {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Tampilkan success modal
                showSuccessNomorSuratModal(currentNomorSuratNama, data.nomor_surat);
            } else {
                // Tampilkan error
                errorDiv.textContent = data.message || 'Gagal menyimpan nomor surat.';
                errorDiv.style.display = 'block';
                
                // Enable button kembali
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
            
        } catch (error) {
            console.error('Error saving nomor surat:', error);
            errorDiv.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
            errorDiv.style.display = 'block';
            
            // Enable button kembali
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    });
    
    // Event untuk reject form
    document.getElementById('rejectForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const notes = document.getElementById('rejectionReason').value.trim();
        if (!notes) { 
            alert('Alasan penolakan harus diisi'); 
            return; 
        }
        
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url("sekretariat/reject/") ?>' + currentRejectId;
        
        const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
        const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
        const inpCsrf = document.createElement('input');
        inpCsrf.type='hidden'; 
        inpCsrf.name=csrfName; 
        inpCsrf.value=csrfHash;
        form.appendChild(inpCsrf);
        
        const inpNotes = document.createElement('input');
        inpNotes.type='hidden'; 
        inpNotes.name='rejection_notes'; 
        inpNotes.value=notes;
        form.appendChild(inpNotes);
        
        document.body.appendChild(form);
        form.submit();
    });
}

// Fungsi untuk menampilkan success modal nomor surat
function showSuccessNomorSuratModal(namaKegiatan, nomorSurat) {
    const modal = document.getElementById('successNomorSuratModal');
    const title = document.getElementById('successNomorTitle');
    const listContainer = document.getElementById('successNomorList');
    const nomorValue = document.getElementById('successNomorValue');

    title.textContent = 'Nomor Surat Tersimpan';

    // Populate list
    listContainer.innerHTML = `
        <div style="display:flex;align-items:center;gap:8px;padding:10px;background:white;border-radius:6px;margin-bottom:8px">
            <i class="fas fa-file-alt" style="color:#3498db;font-size:18px;flex-shrink:0"></i>
            <div style="flex:1">
                <div style="font-weight:600;color:#212529;font-size:14px">${escapeHtml(namaKegiatan)}</div>
                <div style="font-size:12px;color:#6c757d">Status: <span class="badge badge-approved" style="display:inline-block">Disetujui Dekan</span></div>
            </div>
        </div>
    `;

    // Tampilkan nomor surat
    nomorValue.textContent = nomorSurat;

    modal.classList.add('show');
}

document.addEventListener('DOMContentLoaded', function() {
    initializeEventListeners();
    
    // Tambahkan CSS untuk mencegah selection pada klik
    document.head.insertAdjacentHTML('beforeend', `
        <style>
            #tableBody button, #tableBody a, #tableBody select, #tableBody textarea, #tableBody input {
                user-select: none;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
            }
            
            .clickable-row {
                position: relative;
            }
            
            .clickable-row::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 1;
                pointer-events: none;
            }
            
            .clickable-row td > * {
                position: relative;
                z-index: 2;
            }
        </style>
    `);
});
function openUbahPinModal() {
                document.getElementById("ubahPinModal").style.display = "flex";
            }

            function closeUbahPinModal() {
                document.getElementById("ubahPinModal").style.display = "none";
                document.getElementById("pinMsg").innerHTML = "";
            }

            function submitUbahPin() {
                let oldPin = document.getElementById("oldPin").value;
                let newPin = document.getElementById("newPin").value;

                if (oldPin.length !== 6 || newPin.length !== 6) {
                    document.getElementById("pinMsg").innerHTML = "PIN harus 6 digit!";
                    return;
                }

                fetch("<?= base_url('sekretariat/updatePin') ?>", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `old_pin=${encodeURIComponent(oldPin)}&new_pin=${encodeURIComponent(newPin)}`
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById("pinMsg").innerHTML = data.message;

                    if (data.status) {
                        setTimeout(() => {
                            closeUbahPinModal();
                            location.reload();
                        }, 800);
                    }
                })
                .catch(() => {
                    document.getElementById("pinMsg").innerHTML = "Terjadi kesalahan!";
                });
            }

</script>
</body>
</html>