<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengajuan Menunggu - Dashboard Kaprodi</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    /* Reset */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    
    /* Body */
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; }
    
    /* Navbar */
    .navbar { background: #8E44AD; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .navbar h2 { font-size: 20px; }
    
    /* Container */
    .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
    
    /* Card */
    .card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 20px; }
    .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #eee; }
    
    /* Table */
    table { width: 100%; border-collapse: collapse; }
    thead { background: #f4f6f7; }
    th, td { padding: 12px; border-bottom: 1px solid #ecf0f1; text-align: left; font-size: 14px; }
    tbody tr:hover { background: #fbfcfd; }
    
    /* Badges */
    .badge { display: inline-block; padding: 6px 10px; border-radius: 999px; font-weight: 600; font-size: 12px; }
    .badge-pending { background: #fff3cd; color: #856404; }
    .badge-approved { background: #d4edda; color: #155724; }
    .badge-rejected { background: #f8d7da; color: #721c24; }
    .badge-completed { background: #d1ecf1; color: #0c5460; }
    
    /* Buttons */
    .btn { padding: 6px 10px; border-radius: 6px; border: 0; cursor: pointer; font-weight: 600; transition: all 0.2s; }
    .btn:hover { transform: scale(1.05); }
    .btn-approve { background: #27ae60; color: #fff; }
    .btn-approve:hover { background: #229954; }
    .btn-reject { background: #e74c3c; color: #fff; }
    .btn-reject:hover { background: #c0392b; }
    .btn-detail { background: #3498db; color: #fff; }
    .btn-detail:hover { background: #2980b9; }
    .btn-status { background: #66bb6a !important; color: white !important; border: none !important; border-radius: 5px !important; padding: 6px 10px !important; display: inline-flex; align-items: center; justify-content: center; gap: 5px; transition: 0.2s ease-in-out; font-size: 14px; height: 32px; }
    .btn-status i { font-size: 14px; }
    .btn-status:hover { background: #4caf50 !important; transform: scale(1.05); }
    
    /* Search */
    .search-container { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; flex-wrap: wrap; background: #f8f9fa; padding: 15px; border-radius: 10px; border: 1px solid #e9ecef; }
    .search-box { position: relative; flex: 1; min-width: 300px; }
    .search-input { width: 100%; padding: 12px 45px 12px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; transition: all 0.3s; background: white; }
    .search-input:focus { outline: none; border-color: #8E44AD; box-shadow: 0 0 0 2px rgba(142,68,173,0.1); }
    .search-icon { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #6c757d; }
    
    /* Secondary Button */
    .btn-secondary { padding: 10px 20px; border-radius: 8px; border: 0; cursor: pointer; font-weight: 600; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px; background: #95a5a6; color: #fff; text-decoration: none; }
    .btn-secondary:hover { background: #7f8c8d; }
    
    /* Pagination Info */
    .pagination-info { margin-top: 15px; color: #7f8c8d; font-size: 14px; text-align: right; }
    
    /* Back Button */
    .back-btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #3498db; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.3s; margin-bottom: 20px; }
    .back-btn:hover { background: #2980b9; transform: translateY(-2px); }
    
    /* Status Header */
    .status-header { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
    .status-icon { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; }
    .status-icon.pending { background: #fff3cd; color: #f39c12; }
    .status-info h1 { margin: 0; color: #2c3e50; font-size: 28px; }
    .status-info p { margin: 5px 0 0 0; color: #7f8c8d; font-size: 16px; }
    
    /* Modal */
    .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.45); align-items: center; justify-content: center; }
    .modal.show { display: flex; }
    .modal-content { background: white; padding: 0; border-radius: 15px; max-width: 800px; width: 95%; max-height: 85vh; overflow: hidden; animation: slideIn 0.3s ease; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
    @keyframes slideIn { from { transform: translateY(-50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .modal-header { background: #8E44AD; color: white; padding: 20px 25px; display: flex; justify-content: space-between; align-items: center; border-radius: 15px 15px 0 0; }
    .modal-header h3 { margin: 0; font-size: 18px; font-weight: 600; }
    .close-modal { background: none; border: 0; color: white; font-size: 24px; cursor: pointer; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: background 0.2s; }
    .close-modal:hover { background: rgba(255,255,255,0.2); }
    
    /* Detail Content */
    .detail-content { padding: 25px; max-height: calc(85vh - 80px); overflow-y: auto; }
    .detail-section { margin-bottom: 25px; background: #f8f9fa; border-radius: 12px; padding: 20px; border: 1px solid #e9ecef; }
    .detail-section:last-child { margin-bottom: 0; }
    .detail-section-title { font-size: 16px; font-weight: 700; color: #8E44AD; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #8E44AD; display: flex; align-items: center; gap: 10px; }
    .detail-section-title i { font-size: 18px; }
    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
    .detail-row { display: flex; flex-direction: column; margin-bottom: 12px; }
    .detail-label { font-weight: 600; color: #495057; font-size: 13px; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px; }
    .detail-value { color: #212529; font-size: 14px; background: white; padding: 10px 15px; border-radius: 8px; border: 1px solid #e9ecef; min-height: 40px; display: flex; align-items: center; }
    .detail-value-empty { color: #6c757d; font-style: italic; }
    
    /* Dosen List */
    .dosen-list { display: flex; flex-direction: column; gap: 8px; }
    .dosen-item { display: flex; align-items: center; gap: 10px; padding: 8px 12px; background: white; border: 1px solid #e9ecef; border-radius: 6px; }
    .dosen-avatar { width: 32px; height: 32px; border-radius: 50%; background: #8E44AD; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; font-weight: 600; }
    .dosen-info { flex: 1; }
    .dosen-name { font-weight: 600; color: #212529; font-size: 14px; }
    .dosen-details { font-size: 12px; color: #6c757d; }
    
    /* File Evidence */
    .file-evidence { margin-top: 10px; }
    .file-item { display: flex; align-items: center; gap: 12px; padding: 12px 15px; background: white; border: 1px solid #e9ecef; border-radius: 8px; transition: all 0.2s; }
    .file-item:hover { background: #f5eef8; border-color: #8E44AD; }
    .file-icon { width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; color: #8E44AD; font-size: 16px; }
    .file-info { flex: 1; }
    .file-name { font-weight: 600; color: #212529; font-size: 14px; cursor: pointer; }
    .file-name:hover { color: #8E44AD; }
    .file-size { font-size: 12px; color: #6c757d; }
    .preview-btn { background: #3498db; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 600; transition: background 0.2s; display: flex; align-items: center; gap: 6px; text-decoration: none; }
    .preview-btn:hover { background: #2980b9; color: white; text-decoration: none; }
    .preview-btn.disabled { background: #bdc3c7; cursor: not-allowed; opacity: 0.6; }
    .preview-btn.disabled:hover { background: #bdc3c7; }
    .download-btn { background: #8E44AD; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 600; transition: background 0.2s; display: flex; align-items: center; gap: 6px; text-decoration: none; }
    .download-btn:hover { background: #7D3C98; color: white; text-decoration: none; }
    
    /* Preview Modal */
    .preview-modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 10000; justify-content: center; align-items: center; padding: 20px; }
    .preview-modal.show { display: flex; }
    .preview-content { background: white; border-radius: 12px; width: 90%; max-width: 900px; max-height: 90vh; overflow: hidden; display: flex; flex-direction: column; }
    .preview-header { background: #8E44AD; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
    .preview-header h3 { margin: 0; font-size: 16px; font-weight: 600; }
    .preview-close { background: none; border: none; color: white; font-size: 24px; cursor: pointer; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: background 0.2s; }
    .preview-close:hover { background: rgba(255,255,255,0.2); }
    .preview-body { flex: 1; padding: 0; display: flex; justify-content: center; align-items: center; background: #f8f9fa; min-height: 400px; }
    .preview-iframe { width: 100%; height: 70vh; border: none; }
    .preview-image { max-width: 100%; max-height: 70vh; object-fit: contain; }
    .preview-unsupported { text-align: center; padding: 40px; color: #6c757d; }
    .preview-unsupported i { font-size: 48px; margin-bottom: 15px; color: #8E44AD; }
    
    /* Action Buttons in Modal */
    .modal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; padding-top: 20px; border-top: 1px solid #e9ecef; }
    .modal-btn { padding: 10px 20px; border-radius: 8px; border: none; cursor: pointer; font-weight: 600; font-size: 14px; transition: all 0.2s; display: flex; align-items: center; gap: 8px; }
    .modal-btn-close { background: #6c757d; color: white; }
    .modal-btn-close:hover { background: #5a6268; transform: translateY(-2px); }
    .modal-btn-approve { background: #27ae60; color: white; }
    .modal-btn-approve:hover { background: #229954; transform: translateY(-2px); }
    .modal-btn-reject { background: #e74c3c; color: white; }
    .modal-btn-reject:hover { background: #c0392b; transform: translateY(-2px); }
    
    /* Approve Modal */
    .approve-modal-content { background: white; padding: 0; border-radius: 15px; max-width: 550px; width: 95%; max-height: 85vh; overflow: hidden; animation: slideIn 0.3s ease; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
    .approve-modal-body { padding: 25px; }
    .approve-modal-header { background: #8E44AD; color: white; padding: 20px 25px; display: flex; justify-content: space-between; align-items: center; border-radius: 15px 15px 0 0; }
    .approve-modal-header h3 { margin: 0; font-size: 18px; font-weight: 600; }
    .approve-info-box { background: #f5eef8; border: 1px solid #8E44AD; border-radius: 8px; padding: 15px; margin-bottom: 20px; }
    .approve-info-box strong { color: #8E44AD; display: block; margin-bottom: 5px; }
    .approve-info-box span { color: #2c3e50; font-weight: 600; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50; font-size: 14px; }
    .form-control { width: 100%; padding: 12px 15px; border: 2px solid #ddd; border-radius: 8px; font-family: inherit; font-size: 14px; transition: border-color 0.2s; }
    .form-control:focus { outline: none; border-color: #3498db; box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2); }
    .form-hint { color: #7f8c8d; font-size: 12px; margin-top: 5px; display: flex; align-items: center; gap: 5px; }
    .approve-modal-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 25px; padding-top: 20px; border-top: 1px solid #e9ecef; }
    .approve-btn { padding: 10px 20px; border-radius: 8px; border: none; cursor: pointer; font-weight: 600; font-size: 14px; transition: all 0.2s; display: flex; align-items: center; gap: 8px; }
    .approve-btn-cancel { background: #95a5a6; color: white; }
    .approve-btn-cancel:hover { background: #7f8c8d; transform: translateY(-2px); }
    .approve-btn-submit { background: #27ae60; color: white; }
    .approve-btn-submit:hover { background: #229954; transform: translateY(-2px); }
    
    /* Rejection Notes */
    .rejection-notes { background: #fff5f5; border: 1px solid #f8d7da; border-radius: 8px; padding: 20px; margin-top: 15px; }
    .rejection-notes .detail-label { color: #dc3545; font-weight: 700; }
    .rejection-notes .detail-value { background: #fff5f5; border-color: #f8d7da; color: #721c24; font-size: 14px; line-height: 1.5; min-height: auto; padding: 12px; }
    
    /* Bulk Actions */
    .bulk-actions { display: flex; gap: 10px; margin-bottom: 15px; padding: 15px; background: #f8f9fa; border-radius: 8px; border: 1px solid #e9ecef; align-items: center; }
    .bulk-checkbox { margin-right: 10px; transform: scale(1.2); }
    .bulk-info { flex-grow: 1; color: #495057; font-size: 14px; }
    .btn-bulk { padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; font-weight: 600; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; }
    .btn-bulk-approve { background: #27ae60; color: white; }
    .btn-bulk-approve:hover { background: #229954; }
    .btn-bulk-reject { background: #e74c3c; color: white; }
    .btn-bulk-reject:hover { background: #c0392b; }
    .btn-bulk:disabled { background: #bdc3c7; cursor: not-allowed; transform: none; }
    
    /* Bulk Modal */
    .bulk-modal-content { background: white; padding: 0; border-radius: 15px; max-width: 600px; width: 95%; max-height: 85vh; overflow: hidden; animation: slideIn 0.3s ease; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
    .bulk-list { max-height: 300px; overflow-y: auto; margin: 15px 0; border: 1px solid #e9ecef; border-radius: 8px; padding: 10px; }
    .bulk-item { padding: 10px; border-bottom: 1px solid #f1f1f1; display: flex; align-items: center; }
    .bulk-item:last-child { border-bottom: none; }
    .bulk-item-name { flex-grow: 1; }
    
    /* Individual Rejection */
    .individual-rejection-container { max-height: 400px; overflow-y: auto; padding-right: 10px; margin-bottom: 15px; }
    .individual-rejection { margin-bottom: 15px; padding: 15px; border: 1px solid #e9ecef; border-radius: 8px; background: #f8f9fa; }
    .individual-rejection-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; padding-bottom: 8px; border-bottom: 1px solid #dee2e6; }
    .individual-rejection-title { font-weight: 600; color: #495057; flex-grow: 1; }
    .individual-rejection-textarea { width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; font-family: inherit; resize: vertical; min-height: 80px; font-size: 14px; }
    .individual-rejection-textarea:focus { outline: none; border-color: #5b5b5bff; box-shadow: 0 0 0 2px rgba(142,68,173,0.1); }
    
    /* Scrollbar */
    .individual-rejection-container::-webkit-scrollbar { width: 8px; }
    .individual-rejection-container::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .individual-rejection-container::-webkit-scrollbar-thumb { background: #5b5b5bff; border-radius: 10px; }
    .individual-rejection-container::-webkit-scrollbar-thumb:hover { background: #5b5b5bff; }
    
    /* Status Modal */
    .status-modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center; }
    .status-modal.show { display: flex; }
    .status-content { background: white; border-radius: 12px; width: 90%; max-width: 600px; padding: 0; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
    .status-header { background: #8E44AD; color: white; padding: 20px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center; }
    .status-header h3 { margin: 0; font-size: 18px; }
    .close-status { background: none; border: none; color: white; font-size: 24px; cursor: pointer; }
    
    /* Progress Bar */
    .progress-track { display: flex; justify-content: space-between; position: relative; margin: 40px 0; }
    .progress-track::before { content: ''; position: absolute; top: 20px; left: 0; width: 100%; height: 4px; background: #e0e0e0; z-index: 1; }
    .progress-step { display: flex; flex-direction: column; align-items: center; position: relative; z-index: 2; }
    .step-icon { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; margin-bottom: 10px; border: 3px solid #e0e0e0; background: white; }
    .step-text { font-size: 12px; text-align: center; max-width: 100px; color: #666; }
    .step-date { font-size: 11px; color: #999; margin-top: 5px; display: none !important; }
    .progress-line { position: absolute; top: 20px; left: 0; height: 4px; background: #4caf50; z-index: 2; transition: width 0.5s ease; }
    .progress-step.completed .step-icon { background-color: #28a745; border-color: #28a745; color: white; }
    .progress-step.status-completed i { color: white !important; }
    .progress-step.in-progress .step-icon { background: #ffc107; border-color: #ffc107; color: white; }
    .progress-step.rejected .step-icon { background: #dc3545; border-color: #dc3545; color: white; }
    .progress-step.pending .step-icon { background: #e0e0e0; border-color: #e0e0e0; color: #666; }
    .progress-estimasi { width: 100%; text-align: center; margin-top: 5px; font-size: 12px; color: #777; }
    .rejection-reason { background: #fff5f5; border: 1px solid #f8cccc; padding: 15px; border-radius: 10px; margin-top: 15px; }
    .rejection-reason h6 { color: #e63946; font-weight: 700; margin-bottom: 8px; }
    
    /* Success Modal Styles - NEW */
    .success-item { display: flex; align-items: center; padding: 12px 15px; background: white; border: 1px solid #d4edda; border-radius: 8px; margin-bottom: 10px; transition: all 0.2s; }
    .success-item:hover { background: #f0fff4; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(39, 174, 96, 0.1); }
    .success-item-icon { width: 40px; height: 40px; background: #d4edda; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 15px; color: #155724; font-size: 16px; }
    .success-item-info { flex: 1; }
    .success-item-name { font-weight: 600; color: #2c3e50; font-size: 14px; margin-bottom: 4px; }
    .success-item-details { display: flex; gap: 15px; font-size: 12px; color: #6c757d; }
    .success-item-detail { display: flex; align-items: center; gap: 5px; }
    .success-item-detail i { font-size: 11px; }
    .success-badge { background: #d4edda; color: #155724; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; margin-left: 10px; }
    .empty-approved { text-align: center; padding: 40px 20px; color: #6c757d; }
    .empty-approved i { font-size: 48px; margin-bottom: 15px; color: #27ae60; opacity: 0.3; }
    
    /* Success Modal Animation */
    @keyframes slideInSuccess { from { transform: translateY(-30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .success-item { animation: slideInSuccess 0.3s ease; animation-fill-mode: both; }
    .success-item:nth-child(1) { animation-delay: 0.1s; }
    .success-item:nth-child(2) { animation-delay: 0.2s; }
    .success-item:nth-child(3) { animation-delay: 0.3s; }
    .success-item:nth-child(4) { animation-delay: 0.4s; }
    .success-item:nth-child(5) { animation-delay: 0.5s; }
    
    /* Loading Spinner */
    .loading-spinner { display: none; text-align: center; padding: 40px; color: #8E44AD; }
    .loading-spinner i { font-size: 48px; margin-bottom: 15px; }
    
    /* Error Message */
    .error-message { text-align: center; padding: 40px; color: #e74c3c; }
    .error-message i { font-size: 48px; margin-bottom: 15px; }
    
    /* Responsive */
    @media (max-width: 768px) {
        .detail-grid { grid-template-columns: 1fr; }
        .modal-content, .approve-modal-content { width: 95%; margin: 10px; }
        .detail-content { padding: 15px; }
        .modal-actions, .approve-modal-actions { flex-direction: column; }
        .modal-btn, .approve-btn { justify-content: center; }
        .progress-track { flex-direction: column; align-items: flex-start; gap: 30px; padding: 0 10px; }
        .progress-track::before { display: none; }
        .progress-step { flex-direction: row; align-items: center; gap: 15px; width: 100%; }
        .step-text { text-align: left; max-width: none; flex: 1; }
        .bulk-actions { flex-direction: column; align-items: flex-start; }
        .bulk-info { margin: 10px 0; }
        .success-item-details { flex-direction: column; gap: 5px; }
        .success-item { padding: 10px; }
        .success-item-icon { width: 35px; height: 35px; margin-right: 10px; }
        .search-box { min-width: 100%; }
    }
</style>
</head>
<body>

<div class="navbar">
    <h2><i class="fa-solid fa-user-tie"></i> Dashboard Kaprodi</h2>
    <div></div>
</div>

<div class="container">
    <!-- Tombol Kembali -->
    <a href="<?= base_url('kaprodi') ?>" class="back-btn">
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

    <!-- Tabel Pengajuan Menunggu -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-table"></i> Daftar Pengajuan Menunggu Persetujuan</h3>
        </div>
        
        <!-- Bulk Actions -->
        <div class="bulk-actions" id="bulkActions" style="display: none;">
            <input type="checkbox" id="selectAll" class="bulk-checkbox" onchange="toggleSelectAll()">
            <div class="bulk-info" id="selectedCount">0 item dipilih</div>
            <button class="btn-bulk btn-bulk-approve" onclick="processBulkApprove()" id="bulkApproveBtn">
                <i class="fa-solid fa-check"></i> Setujui yang Dipilih
            </button>
            <button class="btn-bulk btn-bulk-reject" onclick="showBulkRejectModal()" id="bulkRejectBtn">
                <i class="fa-solid fa-times"></i> Tolak yang Dipilih
            </button>
            <button class="btn-bulk" onclick="clearSelection()" style="background: #95a5a6; color: white;">
                <i class="fa-solid fa-times"></i> Batal
            </button>
        </div>
        
        <!-- Search Box -->
        <form method="get" action="<?= base_url('kaprodi/pending') ?>" id="searchForm">
            <div class="search-container">
                <div class="search-box">
                    <input 
                        type="text" 
                        name="search" 
                        class="search-input"
                        placeholder="Cari berdasarkan nama kegiatan, penyelenggara, jenis pengajuan, atau NIP..."
                        value="<?= $this->input->get('search') ?>"
                        id="searchInput"
                    >
                    <div class="search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
                
                <button type="submit" class="btn-secondary" style="white-space:nowrap">
                    <i class="fa-solid fa-search"></i> Cari
                </button>
                
                <?php if($this->input->get('search')): ?>
                <a href="<?= base_url('kaprodi/pending') ?>" class="btn-secondary" style="white-space:nowrap">
                    <i class="fa-solid fa-refresh"></i> Reset
                </a>
                <?php endif; ?>
            </div>
        </form>
        
        <div style="overflow-x:auto">
            <table>
                <thead>
                    <tr>
                        <th width="40">
                            <input type="checkbox" id="selectAllHeader" onchange="toggleSelectAllHeader()">
                        </th>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Penyelenggara</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Tanggal Kegiatan</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php 
                    if(isset($surat_list) && is_array($surat_list) && !empty($surat_list)): 
                        $no = 1; 
                        foreach($surat_list as $s): 
                            $tgl_pengajuan = isset($s->created_at) && $s->created_at ? date('d M Y', strtotime($s->created_at)) : '-';
                            $tgl_kegiatan = isset($s->tanggal_kegiatan) && $s->tanggal_kegiatan ? date('d M Y', strtotime($s->tanggal_kegiatan)) : '-';
                    ?>
                    <tr>
                        <td>
                            <input type="checkbox" class="row-checkbox" value="<?= $s->id ?? 0 ?>" onchange="updateBulkActions()">
                        </td>
                        <td><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($s->nama_kegiatan ?? '-') ?></strong></td>
                        <td><?= htmlspecialchars($s->penyelenggara ?? '-') ?></td>
                        <td><?= $tgl_pengajuan ?></td>
                        <td><?= $tgl_kegiatan ?></td>
                        <td><?= htmlspecialchars($s->jenis_pengajuan ?? '-') ?></td>
                        <td><span class="badge badge-pending"><?= ucwords($s->status ?? 'Menunggu') ?></span></td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <button class="btn btn-sm btn-status" title="Lihat Status" onclick="showStatusModal(<?= $s->id ?? 0; ?>)">
                                    <i class="fas fa-tasks"></i>
                                </button>
                                <button class="btn btn-detail" onclick="showDetail(<?= $s->id ?? 0 ?>)" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button class="btn btn-approve" onclick="showApproveModal(<?= $s->id ?? 0 ?>, '<?= htmlspecialchars($s->nama_kegiatan ?? '') ?>')" title="Setujui">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                <button class="btn btn-reject" onclick="showRejectModal(<?= $s->id ?? 0 ?>)" title="Tolak">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="9" style="text-align:center;padding:40px;color:#7f8c8d">
                            <i class="fa-solid fa-clock" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
                            <strong>
                                <?php if(!isset($surat_list)): ?>
                                    Variabel $surat_list tidak terdefinisi
                                <?php elseif(empty($surat_list)): ?>
                                    <?php if($this->input->get('search')): ?>
                                        Tidak ada pengajuan yang sesuai dengan pencarian "<?= htmlspecialchars($this->input->get('search')) ?>"
                                    <?php else: ?>
                                        Tidak ada pengajuan yang menunggu persetujuan
                                    <?php endif; ?>
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

        <div class="pagination-info">
            Menampilkan: Pengajuan Menunggu Persetujuan 
            <?php if($this->input->get('search')): ?>
                (Hasil pencarian: "<?= htmlspecialchars($this->input->get('search')) ?>")
            <?php else: ?>
                (<?= isset($total_surat) ? $total_surat : '0' ?> data)
            <?php endif; ?>
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
            <!-- Loading state -->
            <div class="loading-spinner" id="detailLoading">
                <i class="fa-solid fa-spinner fa-spin"></i>
                <p>Memuat data...</p>
            </div>
            
            <!-- Error state -->
            <div class="error-message" id="detailError" style="display:none">
                <i class="fa-solid fa-exclamation-triangle"></i>
                <p id="errorText">Terjadi kesalahan saat memuat data</p>
                <button class="btn btn-detail" onclick="retryLoadDetail()" style="margin-top:15px">
                    <i class="fa-solid fa-refresh"></i> Coba Lagi
                </button>
            </div>
            
            <!-- Success content akan diisi oleh JavaScript -->
        </div>
    </div>
</div>

<!-- Approve Modal (SINGLE APPROVE) -->
<div id="approveModal" class="modal" onclick="modalClickOutside(event,'approveModal')">
    <div class="approve-modal-content" onclick="event.stopPropagation()">
        <div class="approve-modal-header">
            <h3><i class="fa-solid fa-check-circle"></i> Setujui Pengajuan</h3>
            <button class="close-modal" onclick="closeModal('approveModal')">&times;</button>
        </div>
        <div class="approve-modal-body">
            <div class="approve-info-box">
                <strong><i class="fa-solid fa-info-circle"></i> Informasi:</strong>
                <span id="approveNamaKegiatan"></span>
            </div>
            
            <form id="approveForm" method="POST" action="">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                
                <div class="approve-modal-actions">
                    <button type="button" class="approve-btn approve-btn-cancel" onclick="closeModal('approveModal')">
                        <i class="fa-solid fa-times"></i> Batal
                    </button>
                    <button type="submit" class="approve-btn approve-btn-submit">
                        <i class="fa-solid fa-check"></i> Setujui
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

<!-- Bulk Reject Modal -->
<div id="bulkRejectModal" class="modal" onclick="modalClickOutside(event,'bulkRejectModal')">
    <div class="bulk-modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-ban"></i> Tolak Pengajuan Terpilih</h3>
            <button class="close-modal" onclick="closeModal('bulkRejectModal')">&times;</button>
        </div>
        <div style="padding:25px">
            <div style="background:#f5eef8;border:1px solid #8E44AD;border-radius:8px;padding:15px;margin-bottom:20px">
                <strong><i class="fa-solid fa-info-circle"></i> Anda akan menolak:</strong>
                <span id="bulkRejectCount">0 pengajuan</span>
            </div>
            
            <div class="bulk-notes-info">
                <i class="fa-solid fa-info-circle"></i>
                Berikan alasan penolakan untuk masing-masing pengajuan:
            </div>
            
            <div id="individualRejectionContainer" class="individual-rejection-container">
                <!-- Container untuk individual rejection notes -->
            </div>
            
            <div style="text-align:right;margin-top:12px">
                <button class="btn btn-reject" onclick="confirmBulkReject()">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Penolakan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Status Modal -->
<div id="statusModal" class="status-modal">
    <div class="status-content">
        <div class="status-header">
            <h3>Status Pengajuan Surat Tugas</h3>
            <button class="close-status">&times;</button>
        </div>
        <div class="status-body">
            <div class="progress-track">
                <div class="progress-line" id="progressLine"></div>

                <!-- Step 1: Mengirim -->
                <div class="progress-step status-completed" id="step1">
                    <div class="step-icon">
                        <i class="fas fa-check" id="step1-icon"></i>
                    </div>
                    <div class="step-text" id="step1-text">Mengirim</div>
                    <div class="step-date" id="step1-date">-</div>
                </div>
                <div class="progress-estimasi">
                    <span id="est1">-</span>
                </div>

                <!-- Step 2: Persetujuan KK -->
                <div class="progress-step status-in-progress" id="step2">
                    <div class="step-icon">
                        <i class="fas fa-clock" id="step2-icon"></i>
                    </div>
                    <div class="step-text" id="step2-text">Persetujuan KK</div>
                    <div class="step-date" id="step2-date">-</div>
                </div>
                <div class="progress-estimasi">
                    <span id="est2">-</span>
                </div>

                <!-- Step 3: Persetujuan Sekretariat -->
                <div class="progress-step status-pending" id="step3">
                    <div class="step-icon">
                        <i class="fas fa-clock" id="step3-icon"></i>
                    </div>
                    <div class="step-text" id="step3-text">Persetujuan Sekretariat</div>
                    <div class="step-date" id="step3-date">-</div>
                </div>
                <div class="progress-estimasi">
                    <span id="est3">-</span>
                </div>

                <!-- Step 4: Persetujuan Kaprodi -->
                <div class="progress-step status-pending" id="step4">
                    <div class="step-icon">
                        <i class="fas fa-clock" id="step4-icon"></i>
                    </div>
                    <div class="step-text" id="step4-text">Persetujuan Kaprodi</div>
                    <div class="step-date" id="step4-date">-</div>
                </div>
            </div>

            <div class="status-info mt-4">
                <h5>Informasi Status:</h5>
                <p id="status-description">Memuat informasi status...</p>
                <div id="rejection-reason" class="rejection-reason" style="display: none;">
                    <h6>Alasan Penolakan:</h6>
                    <p id="rejection-text"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Approval Modal -->
<div id="successModal" class="modal" onclick="modalClickOutside(event,'successModal')">
    <div class="modal-content" onclick="event.stopPropagation()" style="max-width: 700px;">
        <div class="modal-header" style="background: #27ae60;">
            <h3><i class="fa-solid fa-check-circle"></i> Pengajuan Berhasil Disetujui</h3>
            <button class="close-modal" onclick="closeModal('successModal')">&times;</button>
        </div>
        <div class="detail-content" style="padding: 25px;">
            <div style="text-align: center; margin-bottom: 20px;">
                <div style="width: 80px; height: 80px; background: #d4edda; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                    <i class="fa-solid fa-check" style="font-size: 36px; color: #155724;"></i>
                </div>
                <h4 style="color: #155724; margin-bottom: 5px;">Berhasil Disetujui</h4>
                <p style="color: #7f8c8d; font-size: 13px; margin-top: 5px;">
                    <i class="fa-solid fa-clock"></i> Disetujui pada: 
                    <span id="approvalTime" style="font-weight: 600;"></span>
                </p>
            </div>
            
            <div style="background: #f8f9fa; border-radius: 10px; padding: 20px; margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h5 style="color: #2c3e50; margin: 0;">Daftar Pengajuan</h5>
                    <span id="approvalCount" style="background: #27ae60; color: white; padding: 4px 12px; border-radius: 20px; font-size: 14px; font-weight: 600;">0 item</span>
                </div>
                
                <div id="approvedList" style="max-height: 300px; overflow-y: auto;">
                    <!-- Daftar approved items akan diisi oleh JavaScript -->
                </div>
            </div>
            
            <div style="display: flex; justify-content: center; gap: 15px; margin-top: 25px;">
                <button class="modal-btn modal-btn-approve" onclick="closeModal('successModal'); location.reload();">
                    <i class="fa-solid fa-refresh"></i> Refresh Halaman
                </button>
                <button class="modal-btn modal-btn-close" onclick="closeModal('successModal')">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Confirm Modal -->
<div id="bulkConfirmModal" class="modal" onclick="modalClickOutside(event,'bulkConfirmModal')">
    <div class="modal-content" onclick="event.stopPropagation()" style="max-width: 600px;">
        <div class="modal-header">
            <h3><i class="fa-solid fa-question-circle"></i> Konfirmasi Multi Approve</h3>
            <button class="close-modal" onclick="closeModal('bulkConfirmModal')">&times;</button>
        </div>
        <div class="detail-content" style="padding: 25px;">
            <div style="text-align: center; margin-bottom: 20px;">
                <div style="width: 60px; height: 60px; background: #fff3cd; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                    <i class="fa-solid fa-exclamation" style="font-size: 28px; color: #856404;"></i>
                </div>
                <h4 style="color: #856404; margin-bottom: 5px;">Konfirmasi Multi Approve</h4>
                <p style="color: #7f8c8d; font-size: 14px; margin-top: 5px;">
                    Anda akan menyetujui <strong id="confirmCount">0</strong> pengajuan sekaligus
                </p>
            </div>
            
            <div style="background: #f8f9fa; border-radius: 10px; padding: 15px; margin-bottom: 20px;">
                <h5 style="color: #2c3e50; margin: 0 0 10px 0; font-size: 15px;">
                    <i class="fa-solid fa-list-check"></i> Daftar Pengajuan yang Akan Disetujui:
                </h5>
                <div id="confirmList" style="max-height: 200px; overflow-y: auto;">
                    <!-- Daftar konfirmasi akan diisi oleh JavaScript -->
                </div>
            </div>
            
            <div style="display: flex; justify-content: center; gap: 15px; margin-top: 25px;">
                <button class="modal-btn modal-btn-close" onclick="closeModal('bulkConfirmModal')">
                    <i class="fa-solid fa-times"></i> Batal
                </button>
                <button class="modal-btn modal-btn-approve" onclick="confirmBulkApprove()">
                    <i class="fa-solid fa-check"></i> Ya, Setujui Semua
                </button>
            </div>
        </div>
    </div>
</div>

<script>
const suratList = <?= isset($surat_list) && !empty($surat_list) ? json_encode($surat_list) : '[]' ?>;
let currentRejectId = null;
let currentApproveId = null;
let currentDetailId = null;
let selectedIds = [];
let isSubmitting = false;

// Fungsi untuk mengambil data detail via AJAX
function getSuratDetail(id) {
    return fetch('<?= site_url("kaprodi/getDetailPengajuan/") ?>' + id)
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
    const previewModal = document.getElementById('previewModal');
    const previewTitle = document.getElementById('previewTitle');
    const previewBody = document.getElementById('previewBody');
    
    previewTitle.textContent = 'Preview: ' + fileName;
    previewBody.innerHTML = `
        <div style="text-align: center; padding: 40px;">
            <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #8E44AD;"></i>
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

// Bulk Action Functions
function toggleSelectAllHeader() {
    const selectAll = document.getElementById('selectAllHeader').checked;
    const checkboxes = document.querySelectorAll('.row-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll;
    });
    
    updateBulkActions();
}

function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll').checked;
    const checkboxes = document.querySelectorAll('.row-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll;
    });
    
    updateBulkActions();
}

function updateBulkActions() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    selectedIds = [];
    
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            selectedIds.push(checkbox.value);
        }
    });
    
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    const selectAllHeader = document.getElementById('selectAllHeader');
    const selectAllBulk = document.getElementById('selectAll');
    
    if (selectedIds.length > 0) {
        bulkActions.style.display = 'flex';
        selectedCount.textContent = `${selectedIds.length} item dipilih`;
        
        const allChecked = selectedIds.length === checkboxes.length;
        selectAllHeader.checked = allChecked;
        selectAllBulk.checked = allChecked;
    } else {
        bulkActions.style.display = 'none';
        selectAllHeader.checked = false;
        selectAllBulk.checked = false;
    }
}

function clearSelection() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    updateBulkActions();
}

// Function untuk menampilkan modal success dengan daftar pengajuan yang disetujui
function showSuccessModal(approvedItems, isMulti = false) {
    const modal = document.getElementById('successModal');
    const countElement = document.getElementById('approvalCount');
    const listElement = document.getElementById('approvedList');
    const timeElement = document.getElementById('approvalTime');
    
    // Update waktu approval
    if (timeElement) {
        const now = new Date();
        const dateStr = now.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
        const timeStr = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
        });
        timeElement.textContent = `${dateStr}, ${timeStr} WIB`;
    }
    
    // Update judul modal berdasarkan apakah single atau multi
    if (isMulti) {
        modal.querySelector('h3').innerHTML = '<i class="fa-solid fa-check-double"></i> Pengajuan Berhasil Disetujui (Multiple)';
    } else {
        modal.querySelector('h3').innerHTML = '<i class="fa-solid fa-check-circle"></i> Pengajuan Berhasil Disetujui';
    }
    
    // Update count
    countElement.textContent = `${approvedItems.length} item`;
    
    // Populate list
    if (approvedItems.length > 0) {
        let html = '';
        approvedItems.forEach((item, index) => {
            const tglKegiatan = item.tanggal_kegiatan ? formatDate(item.tanggal_kegiatan) : '-';
            const jenis = item.jenis_pengajuan || '-';
            const penyelenggara = item.penyelenggara || '-';
            
            html += `
                <div class="success-item">
                    <div class="success-item-icon">
                        <i class="fa-solid ${isMulti ? 'fa-check-double' : 'fa-check'}"></i>
                    </div>
                    <div class="success-item-info">
                        <div class="success-item-name">
                            ${escapeHtml(item.nama_kegiatan || 'Pengajuan')}
                            <span class="success-badge">${isMulti ? 'Disetujui (Multi)' : 'Disetujui'}</span>
                        </div>
                        <div class="success-item-details">
                            <div class="success-item-detail">
                                <i class="fa-solid fa-calendar"></i>
                                <span>${tglKegiatan}</span>
                            </div>
                            <div class="success-item-detail">
                                <i class="fa-solid fa-tag"></i>
                                <span>${escapeHtml(jenis)}</span>
                            </div>
                            <div class="success-item-detail">
                                <i class="fa-solid fa-building"></i>
                                <span>${escapeHtml(penyelenggara)}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        listElement.innerHTML = html;
    } else {
        listElement.innerHTML = `
            <div class="empty-approved">
                <i class="fa-solid fa-inbox"></i>
                <p>Tidak ada data pengajuan</p>
            </div>
        `;
    }
    
    // Tampilkan modal
    modal.classList.add('show');
}

// PERBAIKAN UTAMA: Function untuk submit single approval (dari modal approve) - DENGAN DUA POPUP
function submitSingleApprove() {
    if (isSubmitting || !currentApproveId) return;
    
    isSubmitting = true;
    
    // Temukan item yang disetujui
    const selectedItem = suratList.find(s => Number(s.id) === Number(currentApproveId));
    if (!selectedItem) {
        alert('Data pengajuan tidak ditemukan');
        isSubmitting = false;
        return;
    }
    
    // Tampilkan popup success terlebih dahulu
    showSuccessModal([selectedItem], false);
    
    // Tutup modal approve
    closeModal('approveModal');
    
    // Tunggu 3 detik agar user bisa melihat modal success, baru submit form
    setTimeout(() => {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url("kaprodi/approve/") ?>' + currentApproveId;
        
        // CSRF Token
        const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
        const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
        const inpCsrf = document.createElement('input');
        inpCsrf.type = 'hidden'; 
        inpCsrf.name = csrfName; 
        inpCsrf.value = csrfHash;
        form.appendChild(inpCsrf);
        
        document.body.appendChild(form);
        form.submit();
        
        // Reset isSubmitting setelah form submit
        setTimeout(() => {
            isSubmitting = false;
        }, 100);
    }, 3000); // 3 detik delay untuk melihat modal
}

// PERBAIKAN UTAMA: Function untuk submit bulk approval - DENGAN DUA POPUP
function confirmBulkApprove() {
    if (isSubmitting) return;
    
    isSubmitting = true;
    
    // Kumpulkan data pengajuan yang akan disetujui
    const selectedSurat = suratList.filter(s => selectedIds.includes(String(s.id)));
    
    // Tutup modal konfirmasi
    closeModal('bulkConfirmModal');
    
    // Tampilkan popup success terlebih dahulu
    showSuccessModal(selectedSurat, true);
    
    // Tunggu 3 detik agar user bisa melihat modal success, baru submit form
    setTimeout(() => {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url("kaprodi/process_multi_approve") ?>';
        
        // CSRF Token
        const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
        const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
        const inpCsrf = document.createElement('input');
        inpCsrf.type = 'hidden'; 
        inpCsrf.name = csrfName; 
        inpCsrf.value = csrfHash;
        form.appendChild(inpCsrf);
        
        // Tambahkan setiap selected ID sebagai input terpisah (ARRAY)
        selectedIds.forEach(id => {
            const inpId = document.createElement('input');
            inpId.type = 'hidden';
            inpId.name = 'selected_ids[]';
            inpId.value = id;
            form.appendChild(inpId);
        });
        
        document.body.appendChild(form);
        form.submit();
        
        // Reset isSubmitting setelah form submit
        setTimeout(() => {
            isSubmitting = false;
        }, 100);
    }, 3000); // 3 detik delay untuk melihat modal
}

// PERBAIKAN UTAMA: Bulk Approve Function - Kini memiliki DUA POPUP KONFIRMASI
function processBulkApprove() {
    if (isSubmitting) return;
    
    if (selectedIds.length === 0) {
        alert('Tidak ada pengajuan yang dipilih');
        return;
    }
    
    // Tampilkan modal konfirmasi bulk approve
    showBulkConfirmModal();
}

// PERBAIKAN UTAMA: Single Approve - Klik tombol approve di baris tabel
function showApproveModal(id, namaKegiatan) {
    currentApproveId = id;
    document.getElementById('approveNamaKegiatan').textContent = namaKegiatan;
    document.getElementById('approveModal').classList.add('show');
}

// TAMPILKAN MODAL KONFIRMASI untuk multi approve
function showBulkConfirmModal() {
    if (selectedIds.length === 0) {
        alert('Tidak ada pengajuan yang dipilih');
        return;
    }
    
    // Kumpulkan data pengajuan yang akan disetujui
    const selectedSurat = suratList.filter(s => selectedIds.includes(String(s.id)));
    
    // Update modal konfirmasi
    document.getElementById('confirmCount').textContent = selectedIds.length;
    
    const confirmList = document.getElementById('confirmList');
    let confirmHtml = '<div style="display: flex; flex-direction: column; gap: 8px;">';
    
    selectedSurat.forEach((surat, index) => {
        confirmHtml += `
            <div style="display: flex; align-items: center; padding: 10px; background: white; border-radius: 6px; border: 1px solid #e9ecef;">
                <div style="width: 24px; height: 24px; background: #f5eef8; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 10px; font-size: 12px; font-weight: 600; color: #8E44AD;">
                    ${index + 1}
                </div>
                <div style="flex: 1;">
                    <div style="font-weight: 600; color: #2c3e50; font-size: 14px;">${escapeHtml(surat.nama_kegiatan || 'Pengajuan')}</div>
                    <div style="font-size: 12px; color: #6c757d; display: flex; gap: 10px; margin-top: 4px;">
                        <span><i class="fa-solid fa-building"></i> ${escapeHtml(surat.penyelenggara || '-')}</span>
                        <span><i class="fa-solid fa-tag"></i> ${escapeHtml(surat.jenis_pengajuan || '-')}</span>
                    </div>
                </div>
                <div class="badge badge-pending" style="font-size: 11px;">Menunggu</div>
            </div>
        `;
    });
    
    confirmHtml += '</div>';
    confirmList.innerHTML = confirmHtml;
    
    // Tampilkan modal konfirmasi
    document.getElementById('bulkConfirmModal').classList.add('show');
}

// PERBAIKAN UTAMA: Event listener untuk form approve (SINGLE APPROVE)
document.addEventListener('DOMContentLoaded', function() {
    const approveForm = document.getElementById('approveForm');
    if (approveForm) {
        approveForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Selalu cegah submit default
            
            // Validasi apakah ada currentApproveId
            if (!currentApproveId) {
                alert('Tidak ada ID pengajuan yang valid');
                return;
            }
            
            // Panggil fungsi untuk submit single approval
            submitSingleApprove();
        });
    }
});

// Bulk Reject Functions
function showBulkRejectModal() {
    if (selectedIds.length === 0) {
        alert('Tidak ada pengajuan yang dipilih');
        return;
    }
    
    const modal = document.getElementById('bulkRejectModal');
    const countSpan = document.getElementById('bulkRejectCount');
    const container = document.getElementById('individualRejectionContainer');
    
    countSpan.textContent = `${selectedIds.length} pengajuan`;
    
    // Populate individual rejection notes
    container.innerHTML = '';
    selectedIds.forEach(id => {
        const surat = suratList.find(s => Number(s.id) === Number(id));
        if (surat) {
            const rejectionDiv = document.createElement('div');
            rejectionDiv.className = 'individual-rejection';
            rejectionDiv.innerHTML = `
                <div class="individual-rejection-header">
                    <div class="individual-rejection-title">
                        <strong>${escapeHtml(surat.nama_kegiatan || '-')}</strong>
                        <div style="font-size:12px;color:#6c757d">${escapeHtml(surat.penyelenggara || '-')}</div>
                    </div>
                </div>
                <textarea 
                    class="individual-rejection-textarea" 
                    placeholder="Masukkan alasan penolakan untuk pengajuan ini..."
                    data-id="${id}"
                ></textarea>
            `;
            container.appendChild(rejectionDiv);
        }
    });
    
    modal.classList.add('show');
}

function confirmBulkReject() {
    if (isSubmitting) return;
    
    // Validasi semua textarea
    const textareas = document.querySelectorAll('.individual-rejection-textarea');
    let allFilled = true;
    const rejectionData = [];
    
    textareas.forEach(textarea => {
        const id = textarea.getAttribute('data-id');
        const notes = textarea.value.trim();
        
        if (!notes) {
            allFilled = false;
            textarea.style.borderColor = '#e74c3c';
        } else {
            textarea.style.borderColor = '';
            rejectionData.push({
                id: id,
                notes: notes
            });
        }
    });
    
    if (!allFilled) {
        alert('Semua alasan penolakan harus diisi');
        return;
    }
    
    if (!confirm(`Apakah Anda yakin ingin menolak ${rejectionData.length} pengajuan terpilih?`)) {
        return;
    }
    
    isSubmitting = true;
    
    // Tutup modal terlebih dahulu
    closeModal('bulkRejectModal');
    
    // Buat form dan submit secara tradisional (bukan AJAX)
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= base_url("kaprodi/process_multi_reject") ?>';
    
    // CSRF Token
    const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
    const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
    const inpCsrf = document.createElement('input');
    inpCsrf.type = 'hidden'; 
    inpCsrf.name = csrfName; 
    inpCsrf.value = csrfHash;
    form.appendChild(inpCsrf);
    
    // Tambahkan setiap selected ID dan rejection notes sebagai input terpisah
    rejectionData.forEach(item => {
        const inpId = document.createElement('input');
        inpId.type = 'hidden';
        inpId.name = 'selected_ids[]';
        inpId.value = item.id;
        form.appendChild(inpId);
        
        const inpNotes = document.createElement('input');
        inpNotes.type = 'hidden';
        inpNotes.name = 'rejection_notes[]';
        inpNotes.value = item.notes;
        form.appendChild(inpNotes);
    });
    
    document.body.appendChild(form);
    form.submit();
    
    setTimeout(() => {
        isSubmitting = false;
    }, 2000);
}

// Status Modal Functions
function showStatusModal(suratId) {
    const modal = document.getElementById('statusModal');
    modal.style.display = 'flex';
    resetAllStatus();
    loadStatusData(suratId);
}

function resetAllStatus() {
    for (let i = 1; i <= 4; i++) {
        const step = document.getElementById(`step${i}`);
        const icon = document.getElementById(`step${i}-icon`);
        const text = document.getElementById(`step${i}-text`);
        const date = document.getElementById(`step${i}-date`);
        
        step.className = 'progress-step pending';
        icon.className = 'fas fa-clock';

        const defaultTexts = [
            'Mengirim',
            'Persetujuan KK',
            'Persetujuan Sekretariat',
            'Persetujuan Kaprodi'
        ];
        text.textContent = defaultTexts[i-1];
        date.textContent = '-';
    }

    document.getElementById('progressLine').style.width = '0%';
    const desc = document.getElementById("status-description");
    desc.textContent = "Memuat informasi status...";
    desc.style.color = "black";
}

function loadStatusData(suratId) {
    fetch('<?= site_url("surat/get_status/") ?>' + suratId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateStatusDisplay(data.data);
                updateEstimasiWaktu(data.data);
            } else {
                alert('Gagal memuat status: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error loading status data:', error);
            alert('Terjadi kesalahan saat memuat status');
        });
}

function updateStatusDisplay(statusData) {
    const steps = statusData.steps;

    steps.forEach((step, index) => {
        const stepNumber = index + 1;
        const stepElement = document.getElementById(`step${stepNumber}`);
        const iconElement = document.getElementById(`step${stepNumber}-icon`);
        const textElement = document.getElementById(`step${stepNumber}-text`);
        const dateElement = document.getElementById(`step${stepNumber}-date`);

        stepElement.className = 'progress-step';

        // STATUS WARNA
        switch (step.status) {
            case 'completed':
                stepElement.classList.add('completed');
                iconElement.className = 'fas fa-check';
                break;

            case 'rejected':
                stepElement.classList.add('rejected');
                iconElement.className = 'fas fa-times';
                break;

            case 'in-progress':
                stepElement.classList.add('in-progress');
                iconElement.className = 'fas fa-spinner fa-spin';
                break;

            default:
                stepElement.classList.add('pending');
                iconElement.className = 'fas fa-clock';
        }

        textElement.textContent = step.step_name;
        dateElement.textContent = step.date;
    });

    // Update progress bar panjang
    document.getElementById('progressLine').style.width = 
        (statusData.progress_percentage || 0) + '%';

    // Update informasi status
    const desc = document.getElementById("status-description");
    const finalStatus = statusData.current_status.toLowerCase();

    if (finalStatus === "disetujui kaprodi") {
        desc.textContent = "Pengajuan ini sudah disetujui.";
        desc.style.color = "green";
    }
    else if (finalStatus.includes("ditolak")) {
        desc.textContent = "Pengajuan ini tidak disetujui.";
        desc.style.color = "red";
    }
    else {
        desc.textContent = "Pengajuan ini masih dalam proses persetujuan.";
        desc.style.color = "black";
    }
    
    // Tampilkan alasan penolakan
    const rejectionBox = document.getElementById("rejection-reason");
    const rejectionText = document.getElementById("rejection-text");

    if (finalStatus.includes("ditolak")) {
        rejectionBox.style.display = "block";
        rejectionText.textContent = statusData.catatan_penolakan || "Tidak ada catatan penolakan.";
    } else {
        rejectionBox.style.display = "none";
    }
}

function updateEstimasiWaktu(statusData) {
    const d = statusData.durasi;
    document.getElementById("est1").textContent = d.durasi_1 || "-";
    document.getElementById("est2").textContent = d.durasi_2 || "-";
    document.getElementById("est3").textContent = d.durasi_3 || "-";
}

// Event listener untuk close modal status
document.addEventListener('DOMContentLoaded', function() {
    const closeBtn = document.querySelector('.close-status');
    const modal = document.getElementById('statusModal');
    
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }

    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
        if (e.target.id === 'previewModal') {
            closePreviewModal();
        }
    });
});

// Function showDetail yang sudah diperbaiki dengan PERIODE
async function showDetail(id) {
    try {
        currentDetailId = id;
        
        // Tampilkan loading
        document.getElementById('detailContent').innerHTML = `
            <div class="loading-spinner" id="detailLoading">
                <i class="fa-solid fa-spinner fa-spin"></i>
                <p>Memuat data...</p>
            </div>
            <div class="error-message" id="detailError" style="display:none">
                <i class="fa-solid fa-exclamation-triangle"></i>
                <p id="errorText">Terjadi kesalahan saat memuat data</p>
                <button class="btn btn-detail" onclick="retryLoadDetail()" style="margin-top:15px">
                    <i class="fa-solid fa-refresh"></i> Coba Lagi
                </button>
            </div>
        `;
        document.getElementById('detailModal').classList.add('show');

        // Ambil data detail via AJAX
        const item = await getSuratDetail(id);
        
        if (!item) {
            showDetailError('Data tidak ditemukan');
            return;
        }

        // Fungsi helper untuk mendapatkan value
        const getVal = (k) => {
            return (item[k] !== undefined && item[k] !== null && item[k] !== '' ? item[k] : '-');
        };

        // Format status dengan badge
        const status = getVal('status');
        let statusBadge = '';
        if (status.toLowerCase() === 'disetujui kaprodi') {
            statusBadge = '<span class="badge badge-completed" style="margin-left:10px">Disetujui</span>';
        } else if (status.toLowerCase() === 'disetujui sekretariat') {
            statusBadge = '<span class="badge badge-approved" style="margin-left:10px">Disetujui Sekretariat</span>';
        } else if (status.toLowerCase().includes('ditolak')) {
            statusBadge = '<span class="badge badge-rejected" style="margin-left:10px">Ditolak</span>';
        } else {
            statusBadge = '<span class="badge badge-pending" style="margin-left:10px">Menunggu</span>';
        }

        // Gunakan langsung dosen_data dari response
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

        // Generate file evidence HTML
        let fileEvidenceHtml = '';
        const evidenValue = getVal('eviden');
        
        if (evidenValue && evidenValue !== '-') {
            let evidenFiles = [];
            
            try {
                if (evidenValue.startsWith('[') || evidenValue.startsWith('{')) {
                    const parsed = JSON.parse(evidenValue);
                    if (Array.isArray(parsed)) {
                        evidenFiles = parsed;
                    } else if (parsed.url) {
                        evidenFiles = [parsed.url];
                    }
                } else {
                    evidenFiles = [evidenValue];
                }
            } catch (e) {
                evidenFiles = [evidenValue];
            }
            
            if (evidenFiles.length > 0) {
                fileEvidenceHtml = `
                <div class="detail-section">
                    <div class="detail-section-title">
                        <i class="fa-solid fa-paperclip"></i> File Evidence (${evidenFiles.length} file)
                    </div>
                    <div class="file-evidence">`;
                
                evidenFiles.forEach((file, index) => {
                    let fileName = file;
                    let fileUrl = file;
                    
                    if (!file.startsWith('http://') && !file.startsWith('https://')) {
                        fileName = file.split('/').pop();
                        fileUrl = '<?= base_url("uploads/eviden/") ?>' + fileName;
                    } else {
                        fileName = file.split('/').pop();
                    }
                    
                    const ext = fileName.split('.').pop().toLowerCase();
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
                            <div class="file-info" ${canPreview ? `onclick="previewFile('${fileUrl}', '${fileName}')" style="cursor: pointer;"` : ''}>
                                <div class="file-name" ${canPreview ? 'title="Klik untuk preview"' : ''}>${escapeHtml(fileName)}</div>
                                <div class="file-size">File ${index + 1} • ${ext.toUpperCase()}</div>
                            </div>
                            ${canPreview ? 
                                `<button class="preview-btn" onclick="previewFile('${fileUrl}', '${fileName}')">
                                    <i class="fa-solid fa-eye"></i> Preview
                                </button>` :
                                `<button class="preview-btn disabled" disabled title="Preview tidak tersedia">
                                    <i class="fa-solid fa-eye-slash"></i> Preview
                                </button>`
                            }
                            <a href="${fileUrl}" target="_blank" class="download-btn" download="${fileName}">
                                <i class="fa-solid fa-download"></i> Download
                            </a>
                        </div>`;
                });
                
                fileEvidenceHtml += `
                    </div>
                </div>`;
            }
        }

        // Format Periode Kegiatan berdasarkan jenis_date
        const jenisDate = getVal('jenis_date');
        const periodeKegiatan = getVal('periode_kegiatan');
        const tanggalKegiatan = getVal('tanggal_kegiatan');
        const akhirKegiatan = getVal('akhir_kegiatan');
        
        let periodeDisplay = '-';
        if (jenisDate === 'Periode') {
            periodeDisplay = periodeKegiatan !== '-' ? periodeKegiatan : '-';
        } else if (jenisDate === 'Custom') {
            if (tanggalKegiatan !== '-' && akhirKegiatan !== '-') {
                periodeDisplay = formatDate(tanggalKegiatan) + ' - ' + formatDate(akhirKegiatan);
            }
        }

        const tanggalMulaiDisplay = tanggalKegiatan !== '-' ? formatDate(tanggalKegiatan) : '-';

        const content = `
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
                        <div class="detail-value" style="display:flex;align-items:center">
                            ${escapeHtml(status)} ${statusBadge}
                        </div>
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
                    <i class="fa-solid fa-user-tie"></i> Dosen Terkait
                    <span style="font-size:12px;color:#6c757d;margin-left:auto">(${dosenData.length} dosen)</span>
                </div>
                <div class="dosen-list">
                    ${dosenData.map((dosen, index) => {
                        const nama = dosen.nama || 'Data tidak tersedia';
                        const initial = nama && nama !== 'Data tidak tersedia' ? nama.charAt(0).toUpperCase() : '?';
                        const nip = dosen.nip || '-';
                        const jabatan = dosen.jabatan || '-';
                        const divisi = dosen.divisi || '-';
                        
                        return `
                        <div class="dosen-item">
                            <div class="dosen-avatar">${initial}</div>
                            <div class="dosen-info">
                                <div class="dosen-name">${escapeHtml(nama)}</div>
                                <div class="dosen-details">
                                    NIP: ${escapeHtml(nip)} | 
                                    Jabatan: ${escapeHtml(jabatan)} | 
                                    Divisi: ${escapeHtml(divisi)}
                                </div>
                            </div>
                        </div>
                        `;
                    }).join('')}
                </div>
            </div>

            <div class="detail-section">
                <div class="detail-section-title">
                    <i class="fa-solid fa-calendar-alt"></i> Informasi Waktu & Tempat
                </div>
                <div class="detail-grid">
                    <div class="detail-row">
                        <div class="detail-label">Tanggal Pengajuan</div>
                        <div class="detail-value">${formatDate(getVal('created_at'))}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Jenis Tanggal</div>
                        <div class="detail-value">${escapeHtml(jenisDate !== '-' ? jenisDate : '-')}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Periode Kegiatan</div>
                        <div class="detail-value">${escapeHtml(periodeDisplay)}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Tanggal Mulai</div>
                        <div class="detail-value">${tanggalMulaiDisplay}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Penyelenggara</div>
                        <div class="detail-value">${escapeHtml(getVal('penyelenggara'))}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Tempat Kegiatan</div>
                        <div class="detail-value">${escapeHtml(getVal('tempat_kegiatan'))}</div>
                    </div>
                </div>
            </div>

            ${fileEvidenceHtml}

            ${getVal('catatan_penolakan') && getVal('catatan_penolakan') !== '-' ? `
            <div class="detail-section rejection-notes">
                <div class="detail-section-title">
                    <i class="fa-solid fa-exclamation-triangle"></i> Catatan Penolakan
                </div>
                <div class="detail-row">
                    <div class="detail-label">Alasan Penolakan</div>
                    <div class="detail-value">${escapeHtml(getVal('catatan_penolakan'))}</div>
                </div>
            </div>
            ` : ''}

            <div class="modal-actions">
                <button class="modal-btn modal-btn-approve" onclick="showApproveModal(${item.id}, '${escapeHtml(item.nama_kegiatan)}'); closeModal('detailModal')">
                    <i class="fa-solid fa-check"></i> Setujui
                </button>
                <button class="modal-btn modal-btn-reject" onclick="showRejectModal(${item.id}); closeModal('detailModal')">
                    <i class="fa-solid fa-times"></i> Tolak
                </button>
                <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal')">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
            </div>
        `;
        
        document.getElementById('detailContent').innerHTML = content;
        
    } catch (error) {
        console.error('Error loading detail:', error);
        showDetailError('Gagal memuat data: ' + error.message);
    }
}

function showDetailError(message) {
    document.getElementById('detailContent').innerHTML = `
        <div class="error-message" id="detailError">
            <i class="fa-solid fa-exclamation-triangle"></i>
            <p id="errorText">${message}</p>
            <button class="btn btn-detail" onclick="retryLoadDetail()" style="margin-top:15px">
                <i class="fa-solid fa-refresh"></i> Coba Lagi
            </button>
        </div>
    `;
}

function retryLoadDetail() {
    if (currentDetailId) {
        showDetail(currentDetailId);
    }
}

function showRejectModal(id) {
    currentRejectId = id;
    document.getElementById('rejectionNotes').value = '';
    document.getElementById('rejectModal').classList.add('show');
}

function confirmReject() {
    if (isSubmitting) return;
    
    const notes = document.getElementById('rejectionNotes').value.trim();
    if (!notes) { 
        alert('Alasan penolakan harus diisi'); 
        return; 
    }
    
    if (!confirm('Apakah Anda yakin ingin menolak pengajuan ini?')) {
        return;
    }
    
    isSubmitting = true;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= base_url("kaprodi/reject/") ?>' + currentRejectId;
    
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
    
    setTimeout(() => {
        isSubmitting = false;
    }, 2000);
}

function closeModal(id) { 
    document.getElementById(id).classList.remove('show'); 
}

function modalClickOutside(evt, id) { 
    if (evt.target && evt.target.id === id) closeModal(id); 
}

// Helper functions
function formatDate(d) {
    if (!d || d === '-') return '-';
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

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    
    // Prevent form submission when pressing Enter in search input
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            if (!searchInput.value.trim()) {
                e.preventDefault();
            }
        });
    }
    
    // Auto focus pada search input
    if (searchInput) {
        const searchValue = '<?= $this->input->get('search') ?>';
        if (searchValue) {
            searchInput.focus();
            searchInput.setSelectionRange(searchValue.length, searchValue.length);
        }
    }
});
</script>
</body>
</html>