<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Sekretariat</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;background:#f5f7fa;}
    .navbar{background:#16A085;color:white;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
    .navbar h2{font-size:20px;}
    .container{max-width:1200px;margin:30px auto;padding:0 20px;}
    .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:20px;}
    .stat-card{background:white;padding:20px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.06);border-left:4px solid #3498db;transition:all 0.3s ease;cursor:pointer;text-decoration:none;display:block;color:inherit}
    .stat-card:hover{transform:translateY(-5px);box-shadow:0 8px 16px rgba(0,0,0,0.12)}
    .stat-card h3{color:#7f8c8d;font-size:13px;margin-bottom:8px;text-transform:uppercase}
    .stat-card .number{font-size:28px;font-weight:700;color:#2c3e50}
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
    .chart-container{position:relative;height:450px;padding:10px;}
    .filter-container{display:flex;gap:15px;margin-bottom:20px;flex-wrap:wrap}
    .filter-select{padding:10px 15px;border-radius:8px;border:2px solid #ddd;font-weight:600;cursor:pointer;min-width:200px}
    
    /* Modal Styles */
    .modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.45);align-items:center;justify-content:center}
    .modal.show{display:flex}
    .modal-content{background:white;padding:0;border-radius:15px;max-width:1100px;width:95%;max-height:85vh;overflow:hidden;animation:slideIn 0.3s ease;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
    @keyframes slideIn{from{transform:translateY(-50px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-header{background:#16A085;color:white;padding:20px 25px;display:flex;justify-content:space-between;align-items:center;border-radius:15px 15px 0 0}
    .modal-header h3{margin:0;font-size:18px;font-weight:600}
    .close-modal{background:none;border:0;color:white;font-size:24px;cursor:pointer;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background 0.2s}
    .close-modal:hover{background:rgba(255,255,255,0.2)}
    
    /* Detail Content Styles - IMPROVED (SAMA DENGAN DASHBOARD DEKAN) */
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
    
    /* Dosen list in detail - NEW STYLES (SAMA DENGAN DASHBOARD DEKAN) */
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
    
    /* File Evidence Styles (SAMA DENGAN DASHBOARD DEKAN) */
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
    
    /* Action Buttons in Modal (SAMA DENGAN DASHBOARD DEKAN) */
    .modal-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:20px;padding-top:20px;border-top:1px solid #e9ecef}
    .modal-btn{padding:10px 20px;border-radius:8px;border:none;cursor:pointer;font-weight:600;font-size:14px;transition:all 0.2s;display:flex;align-items:center;gap:8px}
    .modal-btn-close{background:#6c757d;color:white}
    .modal-btn-close:hover{background:#5a6268;transform:translateY(-2px)}
    .modal-btn-approve{background:#27ae60;color:white}
    .modal-btn-approve:hover{background:#229954;transform:translateY(-2px)}
    .modal-btn-reject{background:#e74c3c;color:white}
    .modal-btn-reject:hover{background:#c0392b;transform:translateY(-2px)}
    
    /* Rejection Notes Styles (SAMA DENGAN DASHBOARD DEKAN) */
    .rejection-notes{background:#fff5f5;border:1px solid #f8d7da;border-radius:8px;padding:20px;margin-top:15px}
    .rejection-notes .detail-label{color:#dc3545;font-weight:700}
    .rejection-notes .detail-value{background:#fff5f5;border-color:#f8d7da;color:#721c24;font-size:14px;line-height:1.5;min-height:auto;padding:12px}
    
    /* Approve Modal Styles */
    .approve-modal-content{background:white;padding:0;border-radius:15px;max-width:550px;width:95%;max-height:85vh;overflow:hidden;animation:slideIn 0.3s ease;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
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
    
    /* Tombol Eviden - WARNA HIJAU TETAP */
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

    .eviden-file-container {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .eviden-file-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #dee2e6;
    }

    .eviden-file-header h4 {
        margin: 0;
        color: #28a745;
    }

    .eviden-preview {
        background: white;
        border-radius: 8px;
        padding: 15px;
        border: 1px solid #dee2e6;
        margin-bottom: 15px;
    }

    .eviden-image {
        max-width: 100%;
        max-height: 400px;
        object-fit: contain;
        border-radius: 5px;
        display: block;
        margin: 0 auto;
    }

    .eviden-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .download-eviden-btn {
        background: #28a745;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        font-size: 14px;
    }

    .download-eviden-btn:hover {
        background: #218838;
        color: white;
        text-decoration: none;
    }

    /* Progress Bar Styles - DITAMBAHKAN UNTUK DETAIL MODAL */
    .progress-track {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin: 40px 0;
    }

    .progress-track::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 0;
        width: 100%;
        height: 4px;
        background: #e0e0e0;
        z-index: 1;
    }

    .progress-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    .step-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        margin-bottom: 10px;
        border: 3px solid #e0e0e0;
        background: white;
    }

    .step-text {
        font-size: 12px;
        text-align: center;
        max-width: 100px;
        color: #666;
    }

    .step-date {
        font-size: 11px;
        color: #999;
        margin-top: 5px;
        display: none !important;
    }

    /* Progress Line */
    .progress-line {
        position: absolute;
        top: 20px;
        left: 0;
        height: 4px;
        background: #4caf50;
        z-index: 2;
        transition: width 0.5s ease;
    }

    /* Status Colors */
    .progress-step.completed .step-icon {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
    }

    .progress-step.status-completed i {
        color: white !important;
    }

    .progress-step.in-progress .step-icon {
        background: #ffc107;
        border-color: #ffc107;
        color: white;
    }

    .progress-step.rejected .step-icon {
        background: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    .progress-step.pending .step-icon {
        background: #e0e0e0;
        border-color: #e0e0e0;
        color: #666;
    }

    .progress-estimasi {
        width: 100%;
        text-align: center;
        margin-top: 5px;
        font-size: 12px;
        color: #777;
    }

    .rejection-reason {
        background: #fff5f5;
        border: 1px solid #f8cccc;
        padding: 15px;
        border-radius: 10px;
        margin-top: 15px;
    }

    .rejection-reason h6 {
        color: #e63946;
        font-weight: 700;
        margin-bottom: 8px;
    }
    
    /* Nomor Surat Styles (SAMA DENGAN DASHBOARD DEKAN) */
    .nomor-surat-container {
        background: linear-gradient(135deg, #e8f6f3 0%, #d1f2eb 100%);
        border: 2px solid #16A085;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        text-align: center;
    }
    
    .nomor-surat-label {
        font-size: 14px;
        font-weight: 600;
        color: #16A085;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .nomor-surat-value {
        font-size: 18px;
        font-weight: 700;
        color: #117864;
        font-family: 'Courier New', monospace;
    }
    
    /* Responsive */
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
        .progress-track {
            flex-direction: column;
            align-items: flex-start;
            gap: 30px;
            padding: 0 10px;
        }
        .progress-track::before {
            display: none;
        }
        .progress-step {
            flex-direction: row;
            align-items: center;
            gap: 15px;
            width: 100%;
        }
        .step-text {
            text-align: left;
            max-width: none;
            flex: 1;
        }
    }
    /* Overlay Latar Belakang */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.55);
    backdrop-filter: blur(2px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

/* Box Modal */
.modal-box {
    background: #fff;
    padding: 30px 35px;
    width: 350px;
    border-radius: 14px;
    text-align: center;
    box-shadow: 0 8px 25px rgba(0,0,0,0.25);
    animation: fadeIn .25s ease;
}

.modal-box h2 {
    margin-bottom: 18px;
    font-size: 22px;
    font-weight: 700;
    color: #222;
}

/* Input PIN */
.pin-input {
    width: 100%;
    padding: 12px;
    font-size: 20px;
    letter-spacing: 6px;
    text-align: center;
    border: 2px solid #dadada;
    border-radius: 8px;
    outline: none;
    transition: .2s;
}

.pin-input:focus {
    border-color: #0066ff;
    box-shadow: 0 0 6px rgba(0,102,255,0.3);
}

/* Tombol */
.modal-actions {
    margin-top: 22px;
    display: flex;
    justify-content: center;
    gap: 10px;
}

.btn-primary,
.btn-secondary {
    padding: 8px 20px;
    font-size: 15px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: .2s;
}

/* Tombol Lanjut */
.btn-primary {
    background: #0066ff;
    color: #fff;
}

.btn-primary:hover {
    background: #0052cc;
}

/* Tombol Batal */
.btn-secondary {
    background: #f0f0f0;
}

.btn-secondary:hover {
    background: #e0e0e0;
}

/* Animasi */
@keyframes fadeIn {
    from { opacity: 0; transform: scale(.95); }
    to   { opacity: 1; transform: scale(1); }
}
/* Card wrapper */
.disposisi-card {
    background: #ffffff;
    padding: 18px 20px;
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.12);
    margin-top: 10px;
    border: 1px solid #eee;
}

/* Label */
.label-disposisi {
    font-weight: 600;
    color: #333;
    font-size: 14px;
    margin-bottom: 6px;
    display: block;
}

/* Dropdown */
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

.select-disposisi:focus {
    border-color: #0080ff;
    background: #fff;
    box-shadow: 0 0 5px rgba(0,128,255,0.2);
}

/* Textarea */
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
}

.textarea-disposisi:focus {
    border-color: #0080ff;
    background: #fff;
    box-shadow: 0 0 5px rgba(0,128,255,0.2);
}

/* Tombol */
.btn-disposisi {
    margin-top: 10px;
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 10px;
    background: #007bff;
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: .2s;
}

.btn-disposisi:hover {
    background: #0066d6;
}
/* Gaya tambahan untuk PIN */
    .pin-input-container {
        position: relative;
        margin: 15px 0;
    }

    .pin-input-with-icon {
        width: 100%;
        padding: 12px 12px 12px 40px;
        font-size: 20px;
        letter-spacing: 6px;
        text-align: center;
        border: 2px solid #dadada;
        border-radius: 8px;
        outline: none;
        transition: .2s;
    }

    .pin-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
        font-size: 20px;
    }

    .pin-input-with-icon:focus {
        border-color: #0066ff;
        box-shadow: 0 0 6px rgba(0,102,255,0.3);
    }

    /* Gaya untuk catatan panjang */
    .catatan-container {
        margin-top: 10px;
    }

    .catatan-content {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 12px;
        max-height: 150px;
        overflow-y: auto;
        font-size: 14px;
        line-height: 1.5;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .catatan-panjang {
        display: block;
        max-height: none;
        overflow-y: visible;
    }

</style>
</head>
<body>

<div class="navbar">
    <h2><i class="fa-solid fa-clipboard-list"></i> Dashboard Sekretariat</h2>
    <div></div>
</div>

<div class="container">
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

    <?php
    $total_all = isset($total_surat) ? (int)$total_surat : 0;
    $pending_count = isset($pending_count) ? (int)$pending_count : 0;
    $approved_count = isset($approved_count) ? (int)$approved_count : 0;
    $rejected_count = isset($rejected_count) ? (int)$rejected_count : 0;
    ?>

<!-- Statistik Grid yang Diperkecil -->
<div class="stats-grid" style="gap: 10px; margin-bottom: 15px;">
    <!-- Total Pengajuan -->
    <a href="<?= base_url('sekretariat/semua') ?>" class="stat-card" style="
        border-left-color:#3498db;
        padding: 12px 15px;
        text-align: center;
        min-height: 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    ">
        <h3 style="font-size: 10px; margin-bottom: 4px; letter-spacing: 0.5px;">
            <i class="fa-solid fa-folder" style="font-size: 9px;"></i> TOTAL PENGAJUAN
        </h3>
        <div class="number" style="font-size: 20px; font-weight: 800; color: #5e5e5eff;">
            <?= $total_all ?>
        </div>
    </a>
    
    <!-- Menunggu Persetujuan -->
    <a href="<?= base_url('sekretariat/pending') ?>" class="stat-card" style="
        border-left-color:#f39c12;
        padding: 12px 15px;
        text-align: center;
        min-height: 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    ">
        <h3 style="font-size: 10px; margin-bottom: 4px; letter-spacing: 0.5px;">
            <i class="fa-solid fa-clock" style="font-size: 9px;"></i> MENUNGGU PERSETUJUAN
        </h3>
        <div class="number" style="font-size: 20px; font-weight: 800; color: #5e5e5eff;">
            <?= $pending_count ?>
        </div>
    </a>
    
    <!-- Disetujui -->
    <a href="<?= base_url('sekretariat/disetujui') ?>" class="stat-card" style="
        border-left-color:#27ae60;
        padding: 12px 15px;
        text-align: center;
        min-height: 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    ">
        <h3 style="font-size: 10px; margin-bottom: 4px; letter-spacing: 0.5px;">
            <i class="fa-solid fa-check-circle" style="font-size: 9px;"></i> DISETUJUI
        </h3>
        <div class="number" style="font-size: 20px; font-weight: 800; color: #5e5e5eff;">
            <?= $approved_count ?>
        </div>
    </a>
    
    <!-- Ditolak -->
    <a href="<?= base_url('sekretariat/ditolak') ?>" class="stat-card" style="
        border-left-color:#e74c3c;
        padding: 12px 15px;
        text-align: center;
        min-height: 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    ">
        <h3 style="font-size: 10px; margin-bottom: 4px; letter-spacing: 0.5px;">
            <i class="fa-solid fa-times-circle" style="font-size: 9px;"></i> DITOLAK
        </h3>
        <div class="number" style="font-size: 20px; font-weight: 800; color: #5e5e5eff;">
            <?= $rejected_count ?>
        </div>
    </a>
</div>
    <!-- Filter -->
    <div class="filter-container">
        <div>
            <label style="display:block;margin-bottom:5px;font-weight:600;color:#7f8c8d">
                <i class="fa-solid fa-calendar"></i> Filter Tahun
            </label>
            <select class="filter-select" id="tahunSelect" onchange="updateTahun(this.value)">
                <?php 
                    $currentYear = date('Y');
                    $selectedYear = isset($tahun) ? $tahun : $currentYear;
                    for ($y = $currentYear; $y >= $currentYear - 5; $y--): 
                ?>
                    <option value="<?= $y ?>" <?= ($selectedYear == $y ? 'selected' : '') ?>>Tahun <?= $y ?></option>
                <?php endfor; ?>
            </select>
        </div>
        
        <div>
            <label style="display:block;margin-bottom:5px;font-weight:600;color:#7f8c8d">
                <i class="fa-solid fa-calendar-alt"></i> Filter Bulan
            </label>
            <select class="filter-select" id="bulanSelect" onchange="filterByBulan(this.value)">
                <option value="all">Semua Bulan</option>
                <option value="1" <?= (isset($bulan) && $bulan == 1 ? 'selected' : '') ?>>Januari</option>
                <option value="2" <?= (isset($bulan) && $bulan == 2 ? 'selected' : '') ?>>Februari</option>
                <option value="3" <?= (isset($bulan) && $bulan == 3 ? 'selected' : '') ?>>Maret</option>
                <option value="4" <?= (isset($bulan) && $bulan == 4 ? 'selected' : '') ?>>April</option>
                <option value="5" <?= (isset($bulan) && $bulan == 5 ? 'selected' : '') ?>>Mei</option>
                <option value="6" <?= (isset($bulan) && $bulan == 6 ? 'selected' : '') ?>>Juni</option>
                <option value="7" <?= (isset($bulan) && $bulan == 7 ? 'selected' : '') ?>>Juli</option>
                <option value="8" <?= (isset($bulan) && $bulan == 8 ? 'selected' : '') ?>>Agustus</option>
                <option value="9" <?= (isset($bulan) && $bulan == 9 ? 'selected' : '') ?>>September</option>
                <option value="10" <?= (isset($bulan) && $bulan == 10 ? 'selected' : '') ?>>Oktober</option>
                <option value="11" <?= (isset($bulan) && $bulan == 11 ? 'selected' : '') ?>>November</option>
                <option value="12" <?= (isset($bulan) && $bulan == 12 ? 'selected' : '') ?>>Desember</option>
            </select>
        </div>
    </div>

    <!-- Grafik 3D -->
    <div class="card" style="background: linear-gradient(135deg, #ffffffff 0%, #f7f7f7ff 100%);">
        <div class="card-header" style="border-bottom-color: rgba(16, 11, 11, 0.1)">
            <strong style="color: #030707ff"><i class="fa-solid fa-chart-bar"></i> Grafik Pengajuan — 
                <?php 
                    if(isset($bulan) && $bulan != 'all') {
                        $namaBulan = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                        echo $namaBulan[$bulan] . ' ';
                    }
                ?>
                Tahun <?= isset($tahun) ? $tahun : date('Y') ?>
            </strong>
        </div>
        <div class="chart-container">
            <canvas id="grafikSurat"></canvas>
        </div>
    </div>

    <!-- Tabel -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-table"></i> Daftar Pengajuan Surat</h3>
            <div>
                <span id="filterInfo" style="color:#7f8c8d;font-size:13px">Menampilkan: Semua Data (<?= $total_all ?> data)</span>
            </div>
        </div>
        
        <div style="overflow-x:auto">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Penyelenggara</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Tanggal Kegiatan</th>
                        <th>Jenis</th>
                        <th>Disposisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php if(isset($surat_list) && !empty($surat_list)): $no=1; foreach($surat_list as $s): 
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
                            $st_key = 'unknown';
                            $badge = '<span class="badge badge-pending">' . $badge_text . '</span>';
                        }

                        $tgl_pengajuan = isset($s->created_at) && $s->created_at ? date('d M Y', strtotime($s->created_at)) : '-';
                        $tgl_kegiatan = isset($s->tanggal_kegiatan) && $s->tanggal_kegiatan ? date('d M Y', strtotime($s->tanggal_kegiatan)) : '-';
                    ?>
                    <tr data-status="<?= $st_key ?>">
                        <td><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($s->nama_kegiatan) ?></strong></td>
                        <td><?= htmlspecialchars($s->penyelenggara) ?></td>
                        <td><?= $tgl_pengajuan ?></td>
                        <td><?= $tgl_kegiatan ?></td>
                        <td><?= htmlspecialchars($s->jenis_pengajuan) ?></td>
                        <td>
                        <!-- Tombol Tentukan -->
                        <button 
                            class="btn btn-disposisi" 
                            onclick="openPinModal(<?= $s->id ?>)" 
                            style="background:#f1c40f;color:#000;border:none;padding:6px 12px;border-radius:5px;cursor:pointer">
                            <i class="fas fa-shuffle"></i> Tentukan
                        </button>

                        <!-- Dropdown Disposisi (disembunyikan sampai PIN benar) -->
                        <div id="disposisiBox<?= $s->id ?>" class="disposisi-card" style="display:none;">

                            <label class="label-disposisi">Pilih Disposisi</label>
                            <select id="disposisiSelect<?= $s->id ?>" 
                                    class="select-disposisi"
                                    onchange="onDisposisiChange(<?= $s->id ?>)">
                                <option value="">-- Pilih Disposisi --</option>
                                <option value="Lanjut Proses">Lanjut Proses</option>
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
                                    style="display:none;">
                                Simpan
                            </button>
                        </div>
                        <br>

                        <!-- Tampilkan status bila sudah ada -->
                        <?php if (!empty($s->disposisi_status)): ?>
                            <small><strong>Status:</strong> <?= $s->disposisi_status ?></small><br>
                            <?php if (!empty($s->disposisi_catatan)): ?>
                                <em style="color:#7f8c8d">Catatan: <?= $s->disposisi_catatan ?></em>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>

                        <td>
                            <div style="display:flex;gap:6px">
                                <!-- Tombol Lihat Eviden (DIGANTI DARI STATUS) -->
                                <button class="btn btn-eviden" title="Lihat Eviden" onclick="showEvidenModal(<?= $s->id; ?>)">
                                    <i class="fas fa-file-image"></i>
                                </button>
                                
                                <!-- Tombol Lihat Detail -->
                                <button class="btn btn-detail" onclick="showDetail(<?= $s->id ?>)" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                
                                <?php if($status == 'disetujui KK' && $s->disposisi_status == 'Lanjut Proses'): ?>
                                    <button class="btn btn-approve" onclick="showApproveModal(<?= $s->id ?>, '<?= htmlspecialchars(addslashes($s->nama_kegiatan)) ?>')" title="Setujui & Teruskan ke Dekan">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                    <button class="btn btn-reject" onclick="showRejectModal(<?= $s->id ?>)" title="Tolak Pengajuan">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                <?php endif; ?>
                                
                                <?php if($status == 'ditolak dekan' && $s->disposisi_status == 'Lanjut Proses'): ?>
                                    <a href="<?= site_url('sekretariat/edit_surat/' . $s->id) ?>" 
                                       class="btn btn-warning" 
                                       title="Edit & Ajukan Ulang ke Dekan"
                                       style="background:#ffc107;color:#000;border:none;border-radius:5px;padding:6px 10px;display:inline-flex;align-items:center;justify-content:center;gap:5px;transition:0.2s ease-in-out;font-size:14px;height:32px;text-decoration:none;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr id="emptyRow">
                        <td colspan="8" style="text-align:center;padding:40px;color:#7f8c8d">
                            <i class="fa-solid fa-inbox" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
                            <strong>Belum ada pengajuan</strong>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Preview Modal -->
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

<!-- Detail Modal -->
<div id="detailModal" class="modal" onclick="modalClickOutside(event,'detailModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-alt"></i> Detail Pengajuan Surat Tugas</h3>
            <button class="close-modal" onclick="closeModal('detailModal')">&times;</button>
        </div>
        <div class="detail-content" id="detailContent">
            <!-- Content akan diisi oleh JavaScript -->
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div id="approveModal" class="modal" onclick="modalClickOutside(event,'approveModal')">
    <div class="approve-modal-content" onclick="event.stopPropagation()">
        <div class="approve-modal-header">
            <h3><i class="fa-solid fa-check-circle"></i> Setujui Pengajuan</h3>
            <button class="close-modal" onclick="closeModal('approveModal')">&times;</button>
        </div>
        <div class="approve-modal-body">
            <div class="approve-info-box">
                <strong><i class="fa-solid fa-info-circle"></i> Informasi: Silahkan isi Nomor Surat sebelum disetujui</strong>
                <span id="approveNamaKegiatan"></span>
            </div>
            
            <form id="approveForm" method="POST" action="">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                
                <div class="form-group">
                    <label for="nomorSurat">
                        <i class="fa-solid fa-file-alt"></i> Nomor Surat <span style="color:#e74c3c">*</span>
                    </label>
                    <input 
                    type="text" 
                    id="nomorSurat" 
                    name="nomor_surat" 
                    class="form-control" 
                    placeholder="Contoh: 001 SKT FT 2025" 
                    required
                    autocomplete="off"
                >
                    <div class="form-hint">
                        <i class="fa-solid fa-exclamation-circle"></i> Format: 001/SKT/FT/Tahun
                    </div>
                </div>

                <div class="approve-modal-actions">
                    <button type="button" class="approve-btn approve-btn-cancel" onclick="closeModal('approveModal')">
                        <i class="fa-solid fa-times"></i> Batal
                    </button>
                    <button type="submit" class="approve-btn approve-btn-submit">
                        <i class="fa-solid fa-check"></i> Setujui & Teruskan ke Dekan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="modal" onclick="modalClickOutside(event,'rejectModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-ban"></i> Tolak Pengajuan</h3>
            <button class="close-modal" onclick="closeModal('rejectModal')">&times;</button>
        </div>
        <div style="padding:25px">
            <p style="margin-bottom:10px;color:#7f8c8d">Berikan alasan penolakan:</p>
            <textarea id="rejectionNotes" rows="5" placeholder="Masukkan alasan penolakan..." style="width:100%;padding:12px;border:2px solid #ddd;border-radius:8px;font-family:inherit;resize:vertical"></textarea>
            <div style="text-align:right;margin-top:12px">
                <button class="btn btn-reject" onclick="confirmReject()">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Penolakan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Eviden Modal (untuk multiple files) -->
<div id="evidenModal" class="modal" onclick="modalClickOutside(event,'evidenModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-image"></i> File Evidence</h3>
            <button class="close-modal" onclick="closeModal('evidenModal')">&times;</button>
        </div>
        <div class="detail-content" id="evidenContent">
            <!-- Content akan diisi oleh JavaScript -->
        </div>
    </div>
</div>
<!-- Modal PIN yang diperbarui -->
<div id="pinModal" 
     style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;
     background:rgba(0,0,0,0.4);align-items:center;justify-content:center;z-index:9999">

    <div style="background:#fff;padding:25px;border-radius:12px;width:350px;text-align:center;box-shadow:0 10px 25px rgba(0,0,0,0.2);">
        <h3 style="margin-bottom:15px;color:#333;">
            <i class="fas fa-lock" style="margin-right:8px;color:#16A085;"></i>Masukkan PIN
        </h3>
        
        <div class="pin-input-container">
            <i class="fas fa-key pin-icon"></i>
            <input type="password" 
                   id="pinInput" 
                   maxlength="4"
                   class="pin-input-with-icon"
                   placeholder="••••"
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>
        
        <div style="display:flex;gap:10px;justify-content:center;margin-top:20px;">
            <button onclick="checkPin()" 
                    class="btn btn-primary"
                    style="background:#16A085;color:white;border:none;padding:10px 20px;border-radius:6px;cursor:pointer;font-weight:600;">
                <i class="fas fa-check"></i> Lanjut
            </button>
            <button onclick="closePinModal()" 
                    class="btn btn-secondary"
                    style="background:#95a5a6;color:white;border:none;padding:10px 20px;border-radius:6px;cursor:pointer;font-weight:600;">
                <i class="fas fa-times"></i> Batal
            </button>
        </div>
        
        <p style="margin-top:15px;font-size:12px;color:#7f8c8d;">
            <i class="fas fa-info-circle"></i> PIN terdiri dari 4 digit angka
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Data dari controller
const suratList = <?= isset($surat_list) && !empty($surat_list) ? json_encode($surat_list) : '[]' ?>;
let currentRejectId = null;
let currentApproveId = null;

// Buat variabel global untuk chart
let chartInstance = null;

// Plugin untuk efek 3D - SAMA SEPERTI DI DEKAN
const fusionStyle3DPlugin = {
    id: 'fusionStyle3d',
    beforeDatasetsDraw: (chart) => {
        const ctx = chart.ctx;
        chart.data.datasets.forEach((dataset, datasetIndex) => {
            const meta = chart.getDatasetMeta(datasetIndex);
            if (!meta.hidden) {
                meta.data.forEach((bar) => {
                    const x = bar.x, y = bar.y, base = bar.base, width = bar.width, height = base - y;
                    if (height <= 1) return;
                    const offsetX = 15, offsetY = -15;
                    ctx.save();
                    const rightGradient = ctx.createLinearGradient(x + width/2, y, x + width/2 + offsetX, y + offsetY);
                    let darkColor = datasetIndex === 0 ? 'rgba(0, 177, 253, 0.6)' : (datasetIndex === 1 ? 'rgba(46, 204, 113, 0.85)' : 'rgba(231, 76, 60, 0.85)');
                    rightGradient.addColorStop(0, darkColor);
                    rightGradient.addColorStop(1, 'rgba(0, 0, 0, 0.2)');
                    ctx.fillStyle = rightGradient;
                    ctx.beginPath();
                    ctx.moveTo(x + width/2, y);
                    ctx.lineTo(x + width/2 + offsetX, y + offsetY);
                    ctx.lineTo(x + width/2 + offsetX, base + offsetY);
                    ctx.lineTo(x + width/2, base);
                    ctx.closePath();
                    ctx.fill();
                    const topGradient = ctx.createLinearGradient(x - width/2, y, x + width/2 + offsetX, y + offsetY);
                    let lightColor = datasetIndex === 0 ? 'rgba(162, 217, 206, 0.9)' : (datasetIndex === 1 ? 'rgba(200, 247, 197, 0.9)' : 'rgba(245, 183, 177, 0.9)');
                    topGradient.addColorStop(0, lightColor);
                    topGradient.addColorStop(1, 'rgba(255, 255, 255, 0.2)');
                    ctx.fillStyle = topGradient;
                    ctx.beginPath();
                    ctx.moveTo(x - width/2, y);
                    ctx.lineTo(x + width/2, y);
                    ctx.lineTo(x + width/2 + offsetX, y + offsetY);
                    ctx.lineTo(x - width/2 + offsetX, y + offsetY);
                    ctx.closePath();
                    ctx.fill();
                    ctx.restore();
                });
            }
        });
    }
};

// Fungsi untuk membuat atau memperbarui grafik
function initChart() {
    const ctx = document.getElementById('grafikSurat');
    
    // Pastikan elemen canvas ada
    if (!ctx) {
        console.error('Canvas element #grafikSurat tidak ditemukan!');
        return;
    }
    
    // Pastikan context tersedia
    const chartCtx = ctx.getContext('2d');
    if (!chartCtx) {
        console.error('Tidak bisa mendapatkan context dari canvas');
        return;
    }
    
    // Hapus chart sebelumnya jika ada
    if (chartInstance) {
        chartInstance.destroy();
        chartInstance = null;
    }
    
    // Cek apakah ada filter bulan
    const bulanSelect = document.getElementById('bulanSelect');
    const selectedBulan = bulanSelect ? bulanSelect.value : 'all';
    
    // Data dari PHP (pastikan tidak null/undefined)
    const chartTotal = <?= json_encode(isset($chart_total) ? $chart_total : array_fill(0,12,0)) ?>;
    const chartPending = <?= json_encode(isset($chart_pending) ? $chart_pending : array_fill(0,12,0)) ?>;
    const chartApproved = <?= json_encode(isset($chart_approved) ? $chart_approved : array_fill(0,12,0)) ?>;
    const chartRejected = <?= json_encode(isset($chart_rejected) ? $chart_rejected : array_fill(0,12,0)) ?>;
    
    console.log('Data Chart Sekretariat:', {
        total: chartTotal,
        pending: chartPending,
        approved: chartApproved,
        rejected: chartRejected,
        bulan: selectedBulan
    });
    
    // Label bulan
    const monthLabels = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
    
    // Jika filter bulan dipilih (bukan "all"), tampilkan hanya data bulan tersebut
    let displayLabels = monthLabels;
    let displayData = {
        labels: displayLabels,
        datasets: [
            {
                label: "Total", 
                data: chartTotal, 
                backgroundColor: 'rgba(0, 177, 253, 0.6)', 
                borderColor: 'rgba(4, 146, 207, 0.6)', 
                borderWidth: 2, 
                borderRadius: 6
            },
            {
                label: "Disetujui", 
                data: chartApproved, 
                backgroundColor: 'rgba(46, 204, 113, 0.85)', 
                borderColor: 'rgba(46, 204, 113, 1)', 
                borderWidth: 2, 
                borderRadius: 6
            },
            {
                label: "Ditolak", 
                data: chartRejected, 
                backgroundColor: 'rgba(231, 76, 60, 0.85)', 
                borderColor: 'rgba(231, 76, 60, 1)', 
                borderWidth: 2, 
                borderRadius: 6
            }
        ]
    };
    
    if (selectedBulan !== 'all') {
        const bulanIndex = parseInt(selectedBulan) - 1; // Konversi ke index 0-based
        
        // Ambil data untuk bulan yang dipilih
        const monthData = {
            total: chartTotal[bulanIndex] || 0,
            approved: chartApproved[bulanIndex] || 0,
            rejected: chartRejected[bulanIndex] || 0
        };
        
        // Buat data untuk satu bulan saja
        displayLabels = [monthLabels[bulanIndex]];
        displayData = {
            labels: displayLabels,
            datasets: [
                {
                    label: "Total", 
                    data: [monthData.total], 
                    backgroundColor: 'rgba(0, 177, 253, 0.6)', 
                    borderColor: 'rgba(4, 146, 207, 0.6)', 
                    borderWidth: 2, 
                    borderRadius: 6,
                },
                {
                    label: "Disetujui", 
                    data: [monthData.approved], 
                    backgroundColor: 'rgba(46, 204, 113, 0.85)', 
                    borderColor: 'rgba(46, 204, 113, 1)', 
                    borderWidth: 2, 
                    borderRadius: 6
                },
                {
                    label: "Ditolak", 
                    data: [monthData.rejected], 
                    backgroundColor: 'rgba(231, 76, 60, 0.85)', 
                    borderColor: 'rgba(231, 76, 60, 1)', 
                    borderWidth: 2, 
                    borderRadius: 6
                }
            ]
        };
        
        console.log('Filter Bulan Sekretariat:', {
            bulanIndex: bulanIndex,
            monthData: monthData,
            displayData: displayData
        });
    }
    
    try {
        // Buat chart baru
        chartInstance = new Chart(chartCtx, {
            type: 'bar',
            data: displayData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top', 
                        labels: {
                            padding: 20, 
                            font: {size: 14, weight: '700'}, 
                            color: '#000000ff'
                        }
                    }, 
                    tooltip: {
                        backgroundColor: 'rgba(44, 62, 80, 0.95)', 
                        padding: 16
                    }
                },
                scales: {
                    x: {
                        grid: {display: false}, 
                        ticks: {color: '#000000ff'}
                    }, 
                    y: {
                        beginAtZero: true, 
                        grid: {color: 'rgba(12, 7, 7, 0.08)'}, 
                        ticks: {color: '#95a5a6'}
                    }
                },
                animation: {
                    duration: 1800, 
                    easing: 'easeInOutQuart'
                }
            },
            plugins: [fusionStyle3DPlugin]
        });
        
        console.log('Chart Sekretariat berhasil dibuat!');
    } catch (error) {
        console.error('Error membuat chart:', error);
        
        // Fallback: tampilkan pesan error
        const container = document.querySelector('.chart-container');
        if (container) {
            container.innerHTML = `
                <div style="text-align:center;padding:40px;color:#e74c3c">
                    <i class="fa-solid fa-exclamation-triangle" style="font-size:48px;margin-bottom:10px"></i>
                    <h4>Gagal Memuat Grafik</h4>
                    <p>Error: ${error.message}</p>
                    <p style="margin-top:10px;color:#7f8c8d">
                        Data: Total=${JSON.stringify(chartTotal)}, 
                        Pending=${JSON.stringify(chartPending)}, 
                        Disetujui=${JSON.stringify(chartApproved)}, 
                        Ditolak=${JSON.stringify(chartRejected)}
                    </p>
                </div>
            `;
        }
    }
}

// Inisialisasi chart saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM siap, inisialisasi chart...');
    setTimeout(initChart, 100);
});

// Fungsi untuk filter berdasarkan bulan
function filterByBulan(bulan) {
    const tahun = document.getElementById('tahunSelect').value;
    
    // Jika memilih "Semua Bulan", redirect ke URL tanpa parameter bulan
    if (bulan === 'all') {
        window.location.href = "<?= base_url('sekretariat?tahun=') ?>" + tahun;
    } else {
        // Redirect dengan parameter tahun dan bulan
        window.location.href = "<?= base_url('sekretariat?tahun=') ?>" + tahun + "&bulan=" + bulan;
    }
}

// Fungsi update tahun yang sudah ada, modifikasi untuk handle bulan
function updateTahun(year) {
    const bulan = document.getElementById('bulanSelect').value;
    if (bulan === 'all') {
        window.location.href = "<?= base_url('sekretariat?tahun=') ?>" + year;
    } else {
        window.location.href = "<?= base_url('sekretariat?tahun=') ?>" + year + "&bulan=" + bulan;
    }
}

// =================================================================
// FUNGSI-FUNGSI UNTUK MODAL DETAIL DAN EVIDEN (SAMA SEPERTI DEKAN)
// =================================================================

// PERBAIKAN: Fungsi untuk mengambil data detail via AJAX
function getSuratDetail(id) {
    return fetch('<?= site_url("sekretariat/getDetailPengajuan/") ?>' + id)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                return data.data;
            } else {
                throw new Error(data.message || 'Gagal memuat data');
            }
        })
        .catch(error => {
            console.error('Error fetching detail:', error);
            throw error;
        });
}

// Preview File Functions
function previewFile(fileUrl, fileName) {
    console.log('Preview File:', {
        fileName: fileName,
        fileUrl: fileUrl,
        fullUrl: fileUrl
    });
    
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
                console.log('Image loaded successfully');
                previewBody.innerHTML = `<img src="${fileUrl}" class="preview-image" alt="${fileName}">`;
            };
            img.onerror = function() {
                console.error('Error loading image:', fileUrl);
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
async function showEvidenModal(suratId) {
    try {
        // Ambil data detail via AJAX
        const item = await getSuratDetail(suratId);
        
        if (!item) {
            alert('Data tidak ditemukan');
            return;
        }

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
        </div>
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

// GANTI fungsi showDetail() menjadi seperti di dekan:
async function showDetail(id) {
    try {
        // Tampilkan loading
        document.getElementById('detailContent').innerHTML = `
            <div style="text-align:center;padding:40px;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#16A085"></i>
                <p style="margin-top:10px;color:#7f8c8d">Memuat surat pengajuan...</p>
            </div>
        `;
        document.getElementById('detailModal').classList.add('show');

        // Load surat pengajuan via iframe (SAMA SEPERTI DEKAN)
        const suratUrl = '<?= base_url("sekretariat/view_surat_pengajuan/") ?>' + id;
        document.getElementById('detailContent').innerHTML = `
            <iframe 
                src="${suratUrl}" 
                style="width:100%; height:70vh; border:none; border-radius:8px;"
                onload="this.style.opacity=1"
                style="opacity:0; transition: opacity 0.3s;"
            ></iframe>
            <div class="modal-actions">
                <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal')">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
            </div>
        `;
        
    } catch (error) {
        console.error('Error loading surat:', error);
        // Error handling...
    }
}

// Fungsi untuk generate konten detail dengan progress bar
function generateDetailContent(item) {
    // Helper function
    const getVal = (k) => {
        const value = (item[k] !== undefined && item[k] !== null && item[k] !== '' ? item[k] : '-');
        return value;
    };

    // Format status dengan badge
    const status = getVal('status');
    let statusBadge = '';
    if (status.toLowerCase() === 'disetujui dekan') {
        statusBadge = '<span class="badge badge-completed" style="margin-left:10px">Disetujui Dekan</span>';
    } else if (status.toLowerCase() === 'disetujui sekretariat') {
        statusBadge = '<span class="badge badge-approved" style="margin-left:10px">Disetujui Sekretariat</span>';
    } else if (status.toLowerCase() === 'disetujui kk') {
        statusBadge = '<span class="badge badge-pending" style="margin-left:10px">Menunggu Sekretariat</span>';
    } else if (status.toLowerCase().includes('ditolak sekretariat')) {
        statusBadge = '<span class="badge badge-rejected" style="margin-left:10px">Ditolak Sekretariat</span>';
    } else if (status.toLowerCase().includes('ditolak dekan')) {
        statusBadge = '<span class="badge badge-rejected" style="margin-left:10px">Ditolak Dekan</span>';
    } else if (status.toLowerCase().includes('ditolak')) {
        statusBadge = '<span class="badge badge-rejected" style="margin-left:10px">Ditolak</span>';
    } else {
        statusBadge = '<span class="badge badge-pending" style="margin-left:10px">Menunggu</span>';
    }

    // Generate dosen data
    let dosenData = [];
    if (item.dosen_data && Array.isArray(item.dosen_data) && item.dosen_data.length > 0) {
        dosenData = item.dosen_data;
    } else {
        dosenData = [{
            nama: getVal('nama_dosen') !== '-' ? getVal('nama_dosen') : 'Data dosen tidak tersedia',
            nip: getVal('nip') !== '-' ? getVal('nip') : '-',
            jabatan: '-',
            divisi: '-'
        }];
    }

    // Generate progress bar dari timeline data
    let progressBarHtml = '';
    if (item.progress_timeline) {
        const timeline = item.progress_timeline;
        const steps = ['mengirim', 'kaprodi', 'sekretariat', 'dekan'];
        const stepNames = ['Mengirim', 'Kaprodi', 'Sekretariat', 'Dekan'];
        const stepIcons = ['fa-paper-plane', 'fa-user-tie', 'fa-clipboard-list', 'fa-university'];
        
        progressBarHtml = `
        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fa-solid fa-tasks"></i> Progress Approval
            </div>
            <div class="progress-track">
        `;
        
        // Hitung progress persentase
        let completedSteps = 0;
        steps.forEach(step => {
            if (timeline[step] && timeline[step].status === 'completed') {
                completedSteps++;
            }
        });
        const progressPercentage = Math.round((completedSteps / steps.length) * 100);
        
        // Progress line
        progressBarHtml += `<div class="progress-line" style="width: ${progressPercentage}%"></div>`;
        
        // Steps
        steps.forEach((step, index) => {
            const stepData = timeline[step] || { status: 'pending', display_time: '-' };
            const statusClass = stepData.status || 'pending';
            const displayTime = stepData.display_time || '-';
            
            progressBarHtml += `
                <div class="progress-step ${statusClass}">
                    <div class="step-icon">
                        <i class="fas ${stepIcons[index]}"></i>
                    </div>
                    <div class="step-text">${stepNames[index]}</div>
                    <div class="step-date">${displayTime}</div>
                </div>
            `;
        });
        
        progressBarHtml += `
            </div>
            <div style="text-align:center;margin-top:15px;font-size:14px;color:#6c757d">
                <i class="fa-solid fa-info-circle"></i> Progress: ${progressPercentage}% (${completedSteps} dari ${steps.length} tahap)
            </div>
        </div>`;
    }

    // Tampilkan Nomor Surat jika sudah ada
    let nomorSuratHtml = '';
    const nomorSurat = getVal('nomor_surat');
    if (nomorSurat && nomorSurat !== '-') {
        nomorSuratHtml = `
        <div class="nomor-surat-container">
            <div class="nomor-surat-label">
                <i class="fa-solid fa-file-signature"></i> Nomor Surat
            </div>
            <div class="nomor-surat-value">${escapeHtml(nomorSurat)}</div>
        </div>`;
    }

    // Generate content
    return `
    

        ${ (item.status && item.status.toLowerCase() === 'disetujui kk') ? `
        <div class="modal-actions">
            <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal')">
                <i class="fa-solid fa-times"></i> Tutup
            </button>
            <button class="modal-btn modal-btn-reject" onclick="showRejectModal(${item.id}); closeModal('detailModal')">
                <i class="fa-solid fa-times"></i> Tolak
            </button>
            <button class="modal-btn modal-btn-approve" onclick="showApproveModal(${item.id}, '${escapeHtml(item.nama_kegiatan)}'); closeModal('detailModal')">
                <i class="fa-solid fa-check"></i> Setujui
            </button>
        </div>
        ` : `
        <div class="modal-actions">
            <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal')">
                <i class="fa-solid fa-times"></i> Tutup
            </button>
        </div>
        ` }
    `;
}

function showApproveModal(id, namaKegiatan) {
    currentApproveId = id;
    document.getElementById('approveNamaKegiatan').textContent = namaKegiatan;
    document.getElementById('nomorSurat').value = '';
    document.getElementById('approveForm').action = '<?= base_url("sekretariat/approve/") ?>' + id;
    document.getElementById('approveModal').classList.add('show');
    
    // Auto focus ke input nomor surat
    setTimeout(() => {
        document.getElementById('nomorSurat').focus();
    }, 300);
}

function showRejectModal(id) {
    currentRejectId = id;
    document.getElementById('rejectionNotes').value = '';
    document.getElementById('rejectModal').classList.add('show');
}

function confirmReject() {
    const notes = document.getElementById('rejectionNotes').value.trim();
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
}

function closeModal(id) { 
    document.getElementById(id).classList.remove('show'); 
}

function modalClickOutside(evt, id) { 
    if (evt.target && evt.target.id === id) closeModal(id); 
}

// Helper functions
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
let selectedSurat = null;

// OPEN PIN POPUP
function openPinModal(id) {
    selectedSurat = id;
    document.getElementById("pinModal").style.display = "flex";
}

// CLOSE PIN POPUP
function closePinModal() {
    document.getElementById("pinModal").style.display = "none";
    document.getElementById("pinInput").value = "";
}

// CEK PIN
function checkPin() {
    let pin = document.getElementById("pinInput").value;

    if (pin !== "1234") {
        alert("PIN salah!");
        return;
    }

    // PIN benar → tampilkan dropdown disposisi
    document.getElementById("disposisiBox" + selectedSurat).style.display = "block";

    closePinModal();
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
    catatanTextarea.value = "";
    
    // Untuk disposisi yang memerlukan catatan
    if (val === "Hold/Pending" || val === "Batal" || val === "Lanjut Proses") {
        catatanLabel.style.display = "block";
        catatanTextarea.style.display = "block";
        btnSave.style.display = "block";
        
        // Set placeholder berdasarkan pilihan
        if (val === "Hold/Pending") {
            catatanTextarea.placeholder = "Berikan alasan mengapa perlu ditahan/ditunda...";
        } else if (val === "Batal") {
            catatanTextarea.placeholder = "Berikan alasan pembatalan...";
        } else if (val === "Lanjut Proses") {
            catatanTextarea.placeholder = "Tambahkan catatan jika diperlukan...";
        }
        
        // Fokus ke textarea
        setTimeout(() => {
            catatanTextarea.focus();
        }, 100);
    }
}


// SIMPAN DISPOSISI
function saveDisposisi(id) {

    let disposisi = document.getElementById("disposisiSelect" + id).value;
    let catatan = document.getElementById("catatanDisposisi" + id).value;

    if (!disposisi) {
        alert("Pilih disposisi dulu!");
        return;
    }

    if ((disposisi === "Hold/Pending" || disposisi === "Batal") && catatan === "") {
        alert("Wajib Mengisi Catatan!");
        return;
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
        alert("Disposisi tersimpan!");
        location.reload();
    });
}
</script>
</body>
</html>