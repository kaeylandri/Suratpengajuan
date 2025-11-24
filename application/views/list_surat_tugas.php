<!DOCTYPE html>
<html lang="en-id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PKC MEDCRAFT - List Surat Tugas</title>
    
    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <style>
    /* ===== NAVBAR & SIDEBAR STYLES ===== */
    body {
        background-color: #f6f9fb;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
    }

    /* HEADER/NAVBAR */
    .navbar {
        background: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 10px 0;
        z-index: 1000;
        height: 70px;
    }

    .navbar .container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
        height: 100%;
    }

    .navbar-brand img {
        height: 40px;
    }

    .fik-navbar-menu {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .fik-navbar-menu ul {
        display: flex;
        align-items: center;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 10px;
    }

    .fik-navbar-menu .left img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .fik-username b {
        display: block;
        font-size: 14px;
        color: #333;
    }

    .fik-username span {
        font-size: 12px;
        color: #777;
    }

    .db-menu-trigger {
        display: none;
        font-size: 24px;
        cursor: pointer;
        color: #FB8C00;
    }

    /* SIDEBAR MODERN STYLE */
    .fik-db-side-menu {
        position: fixed;
        left: 0;
        top: 70px;
        width: 260px;
        height: calc(100vh - 70px);
        background: linear-gradient(180deg, #FF8C00 0%, #FB8C00 100%);
        box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        overflow-y: auto;
        z-index: 999;
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .fik-db-side-menu::-webkit-scrollbar {
        width: 5px;
    }

    .fik-db-side-menu::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.1);
    }

    .fik-db-side-menu::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.3);
        border-radius: 10px;
    }

    .fik-db-side-menu .card.profil {
        text-align: center;
        padding: 20px;
        background: rgba(0,0,0,0.15);
        display: none;
        color: white;
        border-bottom: 1px solid rgba(255,255,255,0.2);
    }

    .fik-db-side-menu .card.profil .img-wrapper {
        margin-bottom: 10px;
    }

    .fik-db-side-menu .card.profil .img-wrapper img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        border: 3px solid rgba(255,255,255,0.5);
        object-fit: cover;
    }

    .fik-db-side-menu .card.profil b {
        display: block;
        color: white;
        font-size: 15px;
        margin-bottom: 3px;
    }

    .fik-db-side-menu .card.profil span {
        color: rgba(255,255,255,0.8);
        font-size: 12px;
    }

    .fik-db-side-menu .card {
        border: none;
        border-radius: 0;
        margin-bottom: 0;
        background: transparent;
    }

    .fik-db-side-menu .btn {
        width: 100%;
        text-align: left;
        padding: 16px 20px;
        border: none;
        background: transparent;
        color: white;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 12px;
        border-left: 4px solid transparent;
        cursor: pointer;
    }

    .fik-db-side-menu .btn:hover,
    .fik-db-side-menu .btn:focus {
        background: rgba(255,255,255,0.15);
        border-left-color: white;
        text-decoration: none;
        padding-left: 24px;
    }

    .fik-db-side-menu .btn.active {
        background: rgba(255,255,255,0.2);
        border-left-color: white;
    }

    .fik-db-side-menu .btn i,
    .fik-db-side-menu .btn span.fas,
    .fik-db-side-menu .btn span.fa {
        width: 20px;
        text-align: center;
        font-size: 16px;
    }

    .fik-db-side-menu .collapse {
        background: rgba(0,0,0,0.15);
    }

    .fik-db-side-menu .collapse ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .fik-db-side-menu .collapse ul li {
        padding: 0;
    }

    .fik-db-side-menu .collapse ul li a {
        display: flex;
        align-items: center;
        padding: 12px 20px 12px 52px;
        color: rgba(255,255,255,0.9);
        text-decoration: none;
        font-size: 13px;
        transition: all 0.3s;
        gap: 8px;
    }

    .fik-db-side-menu .collapse ul li a:before {
        content: '›';
        font-size: 18px;
        font-weight: bold;
    }

    .fik-db-side-menu .collapse ul li a:hover {
        background: rgba(255,255,255,0.1);
        color: white;
        padding-left: 56px;
    }

    .divider {
        height: 1px;
        background: rgba(255,255,255,0.2);
        margin: 10px 20px;
    }

    .fik-db-side-menu .card.logout {
        margin-top: auto;
        padding-bottom: 20px;
    }

    .fik-db-side-menu .card.logout .btn {
        color: white;
        font-weight: 600;
    }

    .fik-db-side-menu .card.logout .btn:hover {
        background: rgba(255,255,255,0.2);
    }

    .main-content {
        margin-left: 260px;
        margin-top: 70px;
        padding: 30px;
        transition: margin-left 0.3s ease;
        min-height: 100vh;
    }

    /* Header Action Buttons */
    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding: 0 10px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin: 0;
    }

    .action-buttons-group {
        display: flex;
        gap: 12px;
    }

    .btn-action {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-back {
        background: #6c757d;
        color: white;
    }

    .btn-back:hover {
        background: #5a6268;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .btn-add {
        background: #FB8C00;
        color: white;
    }

    .btn-add:hover {
        background: #e67e00;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    /* ===== TABLE FILTER STYLES ===== */
    .filter-bar {
        width: 100%;
        background: #ffffff;
        padding: 12px 14px;
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 14px;
        border: 1px solid #f0f0f0;
        flex-wrap: wrap;
    }

    .filter-actions {
        display:flex;
        gap:8px;
        align-items:center;
        order: 1;
    }

    .filter-search {
        flex: 1 1 360px;
        min-width: 220px;
        display:flex;
        position:relative;
        order: 2;
        margin-left: auto;
    }

    .filter-search input{
        width:100%;
        padding:10px 40px 10px 14px;
        height:44px;
        border-radius:10px;
        border:1.5px solid #FB8C00;
        outline:none;
        font-size:14px;
    }

    .filter-search i{
        position:absolute;
        right:12px;
        top:50%;
        transform:translateY(-50%);
        color:#FB8C00;
        pointer-events:none;
    }

    .btn-small {
        height:44px;
        min-width:44px;
        border-radius:10px;
        border:1.5px solid #FB8C00;
        padding:0 12px;
        cursor:pointer;
        font-size:14px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        background:white;
    }

    .btn-small-add {
        background:#FB8C00;
        color:white;
    }

    .btn-reset {
        background:#FB8C00;
        color:white;
        border:1.5px solid #FB8C00;
        border-radius:10px;
        padding:0 14px;
        height:44px;
        font-size:14px;
        cursor:pointer;
        display:inline-flex;
        align-items:center;
        gap:6px;
    }

    .btn-reset[hidden] { display:none; }

    .filter-builder {
        display:flex;
        gap:10px;
        align-items:center;
        width:100%;
        flex-wrap:wrap;
        margin-bottom:14px;
    }

    .filter-row {
        width: 100%;
        background: #ffffff;
        padding: 12px 14px;
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
        display: flex;
        gap: 12px;
        align-items: center;
        border: 1px solid #f0f0f0;
        flex-wrap: wrap;
    }

    .filter-row-actions {
        display:flex;
        gap:8px;
        align-items:center;
        order: 1;
    }

    .filter-row-search {
        flex: 1 1 360px;
        min-width: 220px;
        display:flex;
        position:relative;
        order: 2;
        margin-left: auto;
    }

    .filter-row-search input{
        width:100%;
        padding:10px 40px 10px 14px;
        height:44px;
        border-radius:10px;
        border:1.5px solid #FB8C00;
        outline:none;
        font-size:14px;
        background:white;
    }

    .filter-row-search i{
        position:absolute;
        right:12px;
        top:50%;
        transform:translateY(-50%);
        color:#FB8C00;
        pointer-events:none;
    }

    .filter-row select.row-cat {
        height:44px;
        min-width:44px;
        border-radius:10px;
        border:1.5px solid #FB8C00;
        padding:0 14px;
        cursor:pointer;
        font-size:14px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        background:white;
        outline:none;
    }

    .filter-row input[type="date"]{
        height:44px;
        padding:0 14px;
        border-radius:10px;
        border:1.5px solid #FB8C00;
        background:white;
        font-size:14px;
        min-width:160px;
        outline:none;
    }

    .filter-row .row-btn {
        height:44px;
        min-width:44px;
        border-radius:10px;
        border:1.5px solid #FB8C00;
        padding:0 14px;
        cursor:pointer;
        font-size:14px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        flex-shrink:0;
        background:white;
    }

    .filter-row .row-btn.add {
        background:#FB8C00;
        color:#fff;
    }

    .filter-row .row-btn.add:hover {
        background:#e67e00;
    }

    .filter-row .row-btn.remove {
        background:#FB8C00;
        color:white;
    }

    .filter-row .row-btn.remove:hover {
        background:#e67e00;
    }

    /* Multi-action buttons */
    .multi-actions {
        display:none;
        background:#ffffff;
        padding:12px 14px;
        border-radius:12px;
        box-shadow:0 4px 14px rgba(0,0,0,0.06);
        gap:8px;
        align-items:center;
        margin-bottom:14px;
        border:1px solid #f0f0f0;
    }

    .multi-actions.show {
        display:flex;
    }

    .multi-actions .selected-count {
        font-size:14px;
        font-weight:600;
        color:#333;
        margin-right:8px;
    }

    .btn-multi {
        height:40px;
        padding:0 16px;
        border-radius:10px;
        border:none;
        cursor:pointer;
        font-size:14px;
        display:inline-flex;
        align-items:center;
        gap:6px;
        font-weight:600;
        transition:all 0.2s;
    }

    .btn-multi-edit {
        background:#ffa726;
        color:white;
    }

    .btn-multi-edit:hover {
        background:#fb8c00;
    }

    .btn-multi-delete {
        background:#ef5350;
        color:white;
    }

    .btn-multi-delete:hover {
        background:#e53935;
    }

    /* Table styles */
    #tabelSurat{
        width:100%;
        border-collapse:collapse;
        background:white;
        border-radius:8px;
        overflow:hidden;
        font-size:14px;
        box-shadow:0 4px 12px rgba(0,0,0,0.1);
        font-family: 'Montserrat', sans-serif;
    }

    #tabelSurat thead{
        background:#FB8C00;
        color:white;
    }

    #tabelSurat td,#tabelSurat th{
        padding:12px;
        border:1px solid #eee;
        vertical-align:middle;
        text-align: center;
    }

    #tabelSurat td:nth-child(5),#tabelSurat td:nth-child(6){
        min-width:180px;
        max-width:280px;
    }

    #tabelSurat tbody tr.row-detail {
        cursor:pointer;
        transition: background 0.2s;
    }

    #tabelSurat tbody tr.row-detail:hover {
        background:#fffaf5;
    }

    #tabelSurat tbody tr.row-detail.selected {
        background:#fff4e6;
    }

    .row-checkbox {
        width:18px;
        height:18px;
        cursor:pointer;
        accent-color:#FB8C00;
    }

    #checkAll {
        width:18px;
        height:18px;
        cursor:pointer;
        accent-color:#FB8C00;
    }

    .dosen-container,.divisi-container{
        display:flex;
        flex-wrap:wrap;
        gap:5px;
        align-items:center;
        justify-content: center;
    }

    .nama-dosen-badge{
        display:inline-block;
        background:#fff4e6;
        color:#663c00;
        padding:6px 12px;
        border-radius:15px;
        font-size:12px;
        border:1px solid #FB8C00;
        white-space:nowrap;
        max-width:250px;
        overflow:hidden;
        text-overflow:ellipsis;
    }

    .nama-dosen-more{
        display:inline-block;
        background:#FB8C00;
        color:white;
        padding:6px 12px;
        border-radius:15px;
        font-size:12px;
        font-weight:600;
        cursor:pointer;
        white-space:nowrap;
        transition:all 0.2s;
    }

    .nama-dosen-more:hover{ 
        transform:scale(1.03); 
        background:#e67e00; 
    }

    .divisi-badge{
        display:inline-block;
        background:#e3f2fd;
        color:#0d47a1;
        padding:6px 12px;
        border-radius:15px;
        font-size:12px;
        border:1px solid #2196F3;
        white-space:nowrap;
    }

    /* Action buttons with icons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
        align-items: center;
    }

    .btn-icon-action {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 14px;
    }

    .btn-edit {
        background: #ffa726;
        color: white;
    }

    .btn-edit:hover {
        background: #fb8c00;
        transform: scale(1.05);
    }

    .btn-delete {
        background: #ef5350;
        color: white;
    }

    .btn-delete:hover {
        background: #e53935;
        transform: scale(1.05);
    }

    .btn-print {
        background: #29b6f6;
        color: white;
    }

    .btn-print:hover {
        background: #039be5;
        transform: scale(1.05);
    }

    .btn-status {
    background: #66bb6a;
    color: white;
    border: none;
    padding: 10px 14px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 15px;
    cursor: pointer;
    transition: 0.2s;
}

.btn-status:hover {
    background: #4caf50;
    transform: scale(1.05);
}


    /* Status Modal Styles */
    .status-modal {
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

    .status-modal.show {
        display: flex;
    }

    .status-content {
        background: white;
        border-radius: 12px;
        width: 90%;
        max-width: 600px;
        padding: 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .status-header {
        background: #FB8C00;
        color: white;
        padding: 20px;
        border-radius: 12px 12px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .status-header h3 {
        margin: 0;
        font-size: 18px;
    }

    .close-status {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
    }

    .status-body {
        padding: 30px;
    }

    /* Progress Bar Styles */
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

    /* Status Colors */
    .status-pending .step-icon {
        border-color: #ffc107;
        background: #ffc107;
        color: white;
    }

    .status-in-progress .step-icon {
        border-color: #ff9800;
        background: #ff9800;
        color: white;
    }

    .status-rejected .step-icon {
        border-color: #f44336;
        background: #f44336;
        color: white;
    }

    .status-completed .step-icon {
        border-color: #4caf50;
        background: #4caf50;
        color: white;
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

    /* Status Text Colors */
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

    /* Detail Modal Styles */
    .modal-detail{ 
        display:none !important; 
        position:fixed; 
        inset:0; 
        background:rgba(0,0,0,0.55); 
        z-index:9999; 
        justify-content:center; 
        align-items:center; 
        padding:20px;
    }

    .modal-detail.show{ 
        display:flex !important;
    }

    .modal-content-detail{ 
        width:90%; 
        max-width:800px; 
        background:white; 
        border-radius:12px; 
        overflow:hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header-detail{ 
        background:#FB8C00; 
        padding:20px; 
        color:white; 
        display:flex; 
        justify-content:space-between;
        align-items: center;
        font-size: 18px;
        font-weight: 600;
    }

    .modal-body-detail{ 
        padding:30px;
        background: #f8f9fa;
    }

    /* Form-like detail styles */
    .detail-section {
        background: white;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        border: 1px solid #e9ecef;
    }

    .detail-section-title {
        font-size: 16px;
        font-weight: 700;
        color: #FB8C00;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #FB8C00;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .detail-section-title i {
        font-size: 18px;
    }

    .detail-row {
        display: flex;
        margin-bottom: 15px;
        align-items: flex-start;
    }

    .detail-label {
        width: 200px;
        font-weight: 600;
        color: #495057;
        font-size: 14px;
        flex-shrink: 0;
    }

    .detail-value {
        flex: 1;
        color: #212529;
        font-size: 14px;
        background: #f8f9fa;
        padding: 10px 15px;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        min-height: 40px;
        display: flex;
        align-items: center;
    }

    .detail-value-empty {
        color: #6c757d;
        font-style: italic;
    }

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
        background: #FB8C00;
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

    /* File evidence styles - PERBAIKAN */
    .file-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .file-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 15px;
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .file-item:hover {
        background: #fffaf5;
        border-color: #FB8C00;
    }

    .file-icon {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #FB8C00;
        font-size: 16px;
    }

    .file-info {
        flex: 1;
        cursor: pointer;
        min-width: 0;
    }

    .file-name {
        font-weight: 600;
        color: #212529;
        font-size: 14px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .file-size {
        font-size: 12px;
        color: #6c757d;
    }

    .download-btn {
        background: #FB8C00;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        transition: background 0.2s;
        display: flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
    }

    .download-btn:hover {
        background: #e67e00;
        text-decoration: none;
        color: white;
    }

    /* Preview Modal Styles */
    .preview-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        z-index: 10000;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .preview-modal.show {
        display: flex;
    }

    .preview-content {
        background: white;
        border-radius: 12px;
        width: 90%;
        max-width: 900px;
        max-height: 90vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .preview-header {
        background: #FB8C00;
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .preview-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }

    .preview-close {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background 0.2s;
    }

    .preview-close:hover {
        background: rgba(255,255,255,0.2);
    }

    .preview-body {
        flex: 1;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f8f9fa;
        min-height: 400px;
    }

    .preview-iframe {
        width: 100%;
        height: 70vh;
        border: none;
    }

    .preview-image {
        max-width: 100%;
        max-height: 70vh;
        object-fit: contain;
    }

    .preview-unsupported {
        text-align: center;
        padding: 40px;
        color: #6c757d;
    }

    .preview-unsupported i {
        font-size: 48px;
        margin-bottom: 15px;
        color: #FB8C00;
    }

    .close-modal {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background 0.2s;
    }

    .close-modal:hover {
        background: rgba(255,255,255,0.2);
    }

    .hide-mobile {
        display: block;
    }

    .show-mobile {
        display: none;
    }

    /* Footer */
    .footer {
        margin-top: 40px;
        padding: 20px 0;
        background-color: #f8f8fa;
        border-top: 1px solid #ddd;
    }

    .fik-footer {
        text-align: left;
        padding-left: 285px;
    }

    .credit {
        color: #666;
        font-size: 14px;
    }

    .progress-estimasi {
        width: 100%;
        text-align: center;
        margin-top: 5px;
        font-size: 12px;
        color: #777;
    }

    /* Responsive */
    @media (max-width:880px){
        .progress-track {
            flex-direction: column;
            align-items: flex-start;
            gap: 30px;
            padding: 0 10px;
        }
        
        .fik-db-side-menu.active {
            transform: translateX(0);
        }
        
        .main-content {
            margin-left: 0;
            margin-top: 70px;
        }
        
        .db-menu-trigger {
            display: block;
        }
        
        .hide-mobile {
            display: none !important;
        }
        
        .show-mobile {
            display: block !important;
        }
        
        .fik-db-side-menu .card.profil.show-mobile {
            display: block !important;
        }
        
        .fik-footer {
            padding-left: 20px;
            text-align: center;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 5px;
        }
        
        .btn-icon-action {
            width: 32px;
            height: 32px;
            font-size: 12px;
        }

        .header-actions {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        .action-buttons-group {
            width: 100%;
            justify-content: flex-start;
        }

        .detail-row {
            flex-direction: column;
            gap: 8px;
        }

        .detail-label {
            width: 100%;
        }

        .detail-value {
            width: 100%;
        }

        .modal-content-detail {
            width: 95%;
            margin: 10px;
        }

        .modal-body-detail {
            padding: 20px;
        }

        .detail-section {
            padding: 15px;
        }
        
        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-actions {
            order: 1;
            justify-content: space-between;
            width: 100%;
        }
        
        .filter-search {
            order: 2;
            margin-left: 0;
            margin-top: 10px;
        }

        .filter-bar{ padding:10px; gap:8px; }
        .filter-search{ flex-basis: 100%; }
        .filter-builder{ gap:8px; }
        .filter-row{ padding:10px; gap:8px; }
        .filter-row .filter-row-search { flex-basis: 100%; }
        .filter-row select.row-cat { min-width:140px; }
        .filter-row input[type="date"] { min-width:140px; }
        
        #tabelSurat {
            font-size: 12px;
        }
        
        #tabelSurat td, #tabelSurat th {
            padding: 8px;
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
        
        .step-label {
            min-width: 90px;
        }
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar fixed-top">
        <div class="container loss">
            <a class="db-menu-trigger show-mobile" onclick="toggleSidebar()"><span class="fas fa-th-large"></span></a>
            <div class="navbar-brand akun">
                <a href="https://ifik.telkomuniversity.ac.id/"><img src="https://ifik.telkomuniversity.ac.id/assets/img/logo/logo-dummy.png" /></a>
            </div>
            <div class="fik-navbar-menu">
                <ul class="left akun fik-username hide-mobile">
                    <li>
                        <img src="https://ifik.telkomuniversity.ac.id/assets/img/profile/default.jpg">
                    </li>
                    <li>
                        <b>PIC MEDCRAFT</b>
                        <span>pic kk</span>
                    </li>
                </ul>
                <ul class="right akun">
                    <div class="fik-login-dropdown hide-mobile" style="margin-right:22px">
                        <a class="btn btn-sm btn-pill btn-icon btn-icon-left" href="https://ifik.telkomuniversity.ac.id/main/helpdesk">
                            <span class="fas fa-life-ring"></span> Helpdesk
                        </a>
                    </div>
                    <div class="not-dropdown" style="margin-right:14px" id="active">
                        <a class="btn btn-icon" href="https://ifik.telkomuniversity.ac.id/Notification">
                            <span class="fas fa-bell"></span>
                        </a>
                    </div>
                    <div class="dropdown not-dropdown">
                        <a class="btn btn-icon" id="active" data-toggle="dropdown" href="#">
                            <span class="fas fa-cog"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-item regisdropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fa fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" data-toggle="modal" data-target="#logout">
                                    <i class="fa fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400 icon"></i>
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="fik-db-side-menu" id="sidebar">
        <div id="accordion">
            <div class="card show-mobile profil">
                <div class="img-wrapper">
                    <img src="https://ifik.telkomuniversity.ac.id/assets/img/profile/default.jpg">
                </div>
                <b>PIC MEDCRAFT</b>
                <span>pic kk</span>
            </div>
            <div class="divider show-mobile" style="margin-top:20px"></div>
            <div class="card">
                <a href="<?= base_url('list-surat-tugas') ?>" class="btn active"><span class="fas fa-palette"></span> List Surat Tugas</a>
            </div>
            <div class="card">
                <a href="https://ifik.telkomuniversity.ac.id/Pic_kk/input_surat" class="btn"><span class="fas fa-envelope-open-text"></span> Surat Tugas</a>
            </div>
            <div class="divider"></div>
            <div class="card">
                <a href="#" class="btn" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapse2"><span class="fas fa-door-open"></span> Peminjaman Ruangan</a>
                <div id="collapse2" class="collapse" data-parent="#accordion">
                    <ul>
                        <li><a data-toggle="modal" data-target="#termcondition">Buat Peminjaman</a></li>
                        <li><a href="https://ifik.telkomuniversity.ac.id/users/daftarsemuatempat">Daftar Ruangan</a></li>
                        <li><a href="https://ifik.telkomuniversity.ac.id/Pic_kk/riwayat">Riwayat</a></li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <a href="#" class="btn" data-toggle="collapse" data-target="#ticketing" aria-expanded="true" aria-controls="ticketing"><span class="fas fa-door-open"></span> Ticketing</a>
                <div id="ticketing" class="collapse" data-parent="#accordion">
                    <ul>
                        <li><a data-toggle="modal" data-target="#maketicketing">Input ticketing</a></li>
                        <li><a href="https://ifik.telkomuniversity.ac.id/users/daftarsemuatempat">Daftar Ruangan</a></li>
                        <li><a href="https://ifik.telkomuniversity.ac.id/pic_kk/riwayat_ticketing">Riwayat</a></li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <a href="#" class="btn show-mobile"><span class="fas fa-life-ring"></span>Helpdesk</a>
            </div>
            <div class="card logout">
                <button class="btn" data-toggle="modal" data-target="#logout"><span class="fas fa-sign-out-alt"></span> Logout</button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header Actions -->
        <div class="header-actions">
            <h1 class="page-title">List Surat Tugas</h1>
            <div class="action-buttons-group">
                <button class="btn-action btn-back" onclick="goBack()">
                    <i class="fas fa-arrow-left"></i> Kembali
                </button>
                <a href="<?= site_url('surat/') ?>" class="btn-action btn-add">
                    <i class="fas fa-plus"></i> Tambah Surat
                </a>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar">
            <div class="filter-actions">
                <select id="filterCategory" class="btn-small">
                    <option value="jenis" selected>Jenis Pengajuan</option>
                    <option value="dosen">Nama Dosen</option>
                    <option value="divisi">Divisi</option>
                    <option value="tanggal">Tanggal Pengajuan</option>
                </select>

                <button id="btnAddFilterRow" class="btn-small btn-small-add" title="Tambah baris filter">
                    <i class="fa fa-plus"></i>
                </button>

                <button id="btnResetAll" class="btn-small btn-reset" hidden title="Reset semua filter & pencarian">
                    <i class="fa fa-times"></i>&nbsp;Reset
                </button>
            </div>

            <div class="filter-search">
                <input type="text" id="tableSearch" placeholder="Search global...">
                <i class="fa fa-search"></i>
            </div>
        </div>

        <div id="filterBuilder" class="filter-builder"></div>

        <!-- Multi-Action Bar -->
        <div id="multiActions" class="multi-actions">
            <span class="selected-count"><span id="selectedCount">0</span> item terpilih</span>
            <button id="btnMultiEdit" class="btn-multi btn-multi-edit">
                <i class="fa fa-edit"></i> Multi Edit
            </button>
            <button id="btnMultiDelete" class="btn-multi btn-multi-delete">
                <i class="fa fa-trash"></i> Multi Hapus
            </button>
        </div>

        <!-- Modal Detail -->
        <div id="modalDetail" class="modal-detail">
            <div class="modal-content-detail">
                <div class="modal-header-detail">
                    <span>Detail Surat Tugas</span>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body-detail">
                    <div id="detailContent">
                        <!-- Content akan diisi oleh JavaScript -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Modal -->
        <div id="previewModal" class="preview-modal">
            <div class="preview-content">
                <div class="preview-header">
                    <h3 id="previewTitle">Preview File</h3>
                    <button class="preview-close">&times;</button>
                </div>
                <div class="preview-body" id="previewBody">
                    <!-- Preview content akan diisi oleh JavaScript -->
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

                    <!-- Step 4: Persetujuan Dekan -->
                    <div class="progress-step status-pending" id="step4">
                        <div class="step-icon">
                            <i class="fas fa-clock" id="step4-icon"></i>
                        </div>
                        <div class="step-text" id="step4-text">Persetujuan Dekan</div>
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

        <!-- Table -->
        <table id="tabelSurat" class="display nowrap">
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th>No</th>
                    <th>Nama Kegiatan</th>
                    <th>Jenis Pengajuan</th>
                    <th>Nama Dosen</th>
                    <th>Divisi</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach ($surat_list as $s): 
                    // === PERUBAHAN: Ambil data dosen dari relasi ===
                    $dosen_data = isset($s->dosen_data) ? $s->dosen_data : [];
                    
                    // Prepare detail data
                    $detail = (array) $s;
                    
                    // Prepare arrays untuk data-detail attribute
                    $nip_array = [];
                    $nama_dosen_array = [];
                    $jabatan_array = [];
                    $divisi_array = [];
                    
                    foreach ($dosen_data as $dosen) {
                        $nip_array[] = $dosen['nip'];
                        $nama_dosen_array[] = $dosen['nama_dosen'];
                        $jabatan_array[] = $dosen['jabatan'];
                        $divisi_array[] = $dosen['divisi'];
                    }
                    
                    $detail['nip'] = $nip_array;
                    $detail['nama_dosen'] = $nama_dosen_array;
                    $detail['jabatan'] = $jabatan_array;
                    $detail['divisi'] = $divisi_array;
                    
                    // Decode eviden untuk filter
                    if (isset($detail['eviden']) && is_string($detail['eviden'])) {
                        $decoded = json_decode($detail['eviden'], true);
                        if (json_last_error() === JSON_ERROR_NONE) $detail['eviden'] = $decoded;
                    }
                    
                    $data_detail_attr = htmlspecialchars(json_encode($detail, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES), ENT_QUOTES,'UTF-8');
                ?>
                <tr class="row-detail" data-detail='<?= $data_detail_attr; ?>' data-id="<?= $s->id; ?>">
                    <td><input type="checkbox" class="row-checkbox" data-id="<?= $s->id; ?>"></td>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($s->nama_kegiatan); ?></td>
                    <td><?= htmlspecialchars($s->jenis_pengajuan); ?></td>
                    <td>
                        <div class="dosen-container">
                            <?php
                            // === PERUBAHAN: Tampilkan dari dosen_data ===
                            if (!empty($dosen_data)) {
                                $nama = $dosen_data[0]['nama_dosen'] ?? '-';
                                $short = strlen($nama) > 30 ? substr($nama, 0, 30) . '...' : $nama;
                                echo '<span class="nama-dosen-badge" title="' . htmlspecialchars($nama) . '">' . htmlspecialchars($short) . '</span>';
                                
                                if (count($dosen_data) > 1) {
                                    echo '<span class="nama-dosen-more" title="Klik row untuk lihat semua dosen">+' . (count($dosen_data) - 1) . '</span>';
                                }
                            } else {
                                echo '-';
                            }
                            ?>
                        </div>
                    </td>
                    <td>
                        <div class="divisi-container">
                            <?php
                            // === PERUBAHAN: Tampilkan dari dosen_data ===
                            if (!empty($dosen_data)) {
                                // Get unique divisions
                                $divisions = array_unique(array_column($dosen_data, 'divisi'));
                                foreach ($divisions as $div) {
                                    echo '<span class="divisi-badge">' . htmlspecialchars($div) . '</span>';
                                }
                            } else {
                                echo '-';
                            }
                            ?>
                        </div>
                    </td>
                    <td><?= isset($s->created_at) && $s->created_at ? htmlspecialchars($s->created_at) : '-'; ?></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon-action btn-status" title="Lihat Status" onclick="showStatusModal(<?= $s->id; ?>)">
                                <i class="fas fa-tasks"></i>
                            </button>
                            <a href="<?= site_url('surat/edit/'.$s->id); ?>" class="btn-icon-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= base_url('surat/cetak/' . $s->id) ?>" target="_blank" class="btn-icon-action btn-print" title="Cetak">
                                <i class="fas fa-print"></i>
                            </a>
                            <a href="<?= site_url('surat/delete/'.$s->id); ?>" class="btn-icon-action btn-delete" title="Hapus" onclick="return confirm('Hapus data ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <footer class="fik-footer">
            <div class="credit">Laboratorium, Bengkel &amp; Studio FIK &copy; 2020</div>
        </footer>
    </div>

    <!-- Logout Modal -->
    <div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Logout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Anda yakin akan keluar?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" onclick="location.href='https://ifik.telkomuniversity.ac.id/auth/logout';" class="btn btn-primary" style="background: #FB8C00; border-color: #FB8C00;">Keluar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
// Toggle Sidebar for Mobile
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
}

// Close sidebar when clicking outside on mobile
$(document).click(function(e) {
    if ($(window).width() <= 992) {
        if (!$(e.target).closest('.fik-db-side-menu, .db-menu-trigger').length) {
            $('#sidebar').removeClass('active');
        }
    }
});

// Fungsi untuk tombol Kembali
function goBack() {
    window.location.href = '<?= base_url() ?>';
}

// Tampilkan modal dan load data
function showStatusModal(suratId) {
    const modal = document.getElementById('statusModal');
    modal.style.display = 'flex';

    resetAllStatus();
    loadStatusData(suratId);
}

// Reset seluruh tampilan sebelum load data baru
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
            'Persetujuan Dekan'
        ];
        text.textContent = defaultTexts[i-1];
        date.textContent = '-';
    }

    document.getElementById('progressLine').style.width = '0%';

    // Reset informasi status
    const desc = document.getElementById("status-description");
    desc.textContent = "Memuat informasi status...";
    desc.style.color = "black";
}

// Load status dari server (AJAX)
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

// UPDATE STATUS DISPLAY
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
            case 'approved':
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

    // UPDATE INFORMASI STATUS
    const desc = document.getElementById("status-description");
    const finalStatus = statusData.current_status.toLowerCase();

    if (finalStatus === "disetujui dekan") {
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
    
    // TAMPILKAN ALASAN PENOLAKAN
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

// EVENT: CLOSE MODAL
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
    });
});

// ===== JQUERY DOCUMENT READY =====
$(document).ready(function () {
    const BASE_URL = '<?= rtrim(base_url(), "/"); ?>';

    let table = $('#tabelSurat').DataTable({
        responsive:true,
        pageLength:5,
        dom:'rtp',
        columnDefs:[
            {orderable:false, targets:[0, -1]},
            {className: 'dt-center', targets: [0, 1]}
        ],
        order: [[1, 'asc']]
    });

    // ===== MULTI-SELECT FUNCTIONALITY =====
    let selectedIds = [];

    function updateMultiActions() {
        selectedIds = [];
        $('.row-checkbox:checked').each(function(){
            selectedIds.push($(this).data('id'));
        });
        
        $('#selectedCount').text(selectedIds.length);
        
        if(selectedIds.length > 0) {
            $('#multiActions').addClass('show');
        } else {
            $('#multiActions').removeClass('show');
        }
        
        const totalCheckboxes = $('.row-checkbox').length;
        const checkedCheckboxes = $('.row-checkbox:checked').length;
        $('#checkAll').prop('checked', totalCheckboxes === checkedCheckboxes && totalCheckboxes > 0);
    }

    $('#checkAll').on('change', function(){
        const isChecked = $(this).is(':checked');
        $('.row-checkbox').prop('checked', isChecked);
        if(isChecked) {
            $('tr.row-detail').addClass('selected');
        } else {
            $('tr.row-detail').removeClass('selected');
        }
        updateMultiActions();
    });

    $(document).on('change', '.row-checkbox', function(e){
        e.stopPropagation();
        const $row = $(this).closest('tr');
        if($(this).is(':checked')) {
            $row.addClass('selected');
        } else {
            $row.removeClass('selected');
        }
        updateMultiActions();
    });

    $(document).on('click', '.row-checkbox', function(e){
        e.stopPropagation();
    });

    $('#btnMultiEdit').click(function(){
        if(selectedIds.length === 0) {
            alert('Pilih minimal 1 item untuk di-edit');
            return;
        }
        window.location.href = '<?= site_url("surat/multi_edit"); ?>?ids=' + selectedIds.join(',');
    });

    $('#btnMultiDelete').click(function(){
        if(selectedIds.length === 0) {
            alert('Pilih minimal 1 item untuk dihapus');
            return;
        }
        
        const confirmed = confirm('Apakah Anda yakin ingin menghapus ' + selectedIds.length + ' item yang dipilih?');
        if(!confirmed) return;
        
        deleteMultipleSurat(selectedIds);
    });

    // Fungsi untuk menghapus multiple surat
    function deleteMultipleSurat(ids) {
        let successCount = 0;
        let errorCount = 0;
        const total = ids.length;
        
        const originalText = $('#btnMultiDelete').html();
        $('#btnMultiDelete').html('<i class="fa fa-spinner fa-spin"></i> Menghapus...').prop('disabled', true);
        
        ids.forEach((id, index) => {
            setTimeout(() => {
                $.ajax({
                    url: '<?= site_url("surat/delete/") ?>' + id,
                    method: 'GET',
                    success: function(response) {
                        successCount++;
                        $(`tr[data-id="${id}"]`).fadeOut(300, function(){
                            $(this).remove();
                        });
                        
                        if (successCount + errorCount === total) {
                            $('#btnMultiDelete').html(originalText).prop('disabled', false);
                            
                            if (successCount > 0) {
                                alert(successCount + ' data berhasil dihapus' + (errorCount > 0 ? ', ' + errorCount + ' gagal' : ''));
                                updateMultiActions();
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        errorCount++;
                        console.error('Error deleting ID ' + id + ':', error);
                        
                        if (successCount + errorCount === total) {
                            $('#btnMultiDelete').html(originalText).prop('disabled', false);
                            alert(successCount + ' data berhasil dihapus, ' + errorCount + ' gagal');
                            updateMultiActions();
                        }
                    }
                });
            }, index * 200);
        });
    }

    // ===== FILTER FUNCTIONALITY - UPDATED =====
    const filterData = {
        jenis: <?php 
            $jenis_list = array_unique(array_map(function($s){ 
                return $s->jenis_pengajuan; 
            }, $surat_list));
            echo json_encode(array_values($jenis_list));
        ?>,
        dosen: <?php 
            // === PERUBAHAN: Ambil dari dosen_data ===
            $dosen_list = [];
            foreach ($surat_list as $s) {
                if (isset($s->dosen_data) && !empty($s->dosen_data)) {
                    foreach ($s->dosen_data as $dosen) {
                        $dosen_list[] = $dosen['nama_dosen'];
                    }
                }
            }
            $dosen_list = array_unique($dosen_list);
            echo json_encode(array_values($dosen_list));
        ?>,
        divisi: <?php 
            // === PERUBAHAN: Ambil dari dosen_data ===
            $divisi_list = [];
            foreach ($surat_list as $s) {
                if (isset($s->dosen_data) && !empty($s->dosen_data)) {
                    foreach ($s->dosen_data as $dosen) {
                        $divisi_list[] = $dosen['divisi'];
                    }
                }
            }
            $divisi_list = array_unique($divisi_list);
            echo json_encode(array_values($divisi_list));
        ?>
    };

    Object.keys(filterData).forEach(k=>{
        filterData[k] = (filterData[k]||[]).map(x=>String(x||'').trim()).filter(x=>x!=='');
        filterData[k] = Array.from(new Set(filterData[k])).sort((a,b)=>a.localeCompare(b));
    });

    let rows = [];
    let uid = 0;
    function nextId(){ return 'r'+(++uid); }

    function makeRowDOM(r){
        const $wr = $(`<div class="filter-row" data-id="${r.id}"></div>`);

        const $filterRowActions = $(`<div class="filter-row-actions"></div>`);
        const $filterRowSearch = $(`<div class="filter-row-search"></div>`);
        const $search = $(`<input type="text" class="row-search" placeholder="Search..." />`);
        const $searchIcon = $(`<i class="fa fa-search"></i>`);
        
        const $dateStart = $(`<input type="date" class="row-date-start" style="display:none" />`);
        const $dateEnd = $(`<input type="date" class="row-date-end" style="display:none" />`);

        $filterRowSearch.append($search).append($searchIcon);

        const $cat = $(`<select class="row-cat">
            <option value="jenis">Jenis Pengajuan</option>
            <option value="dosen">Nama Dosen</option>
            <option value="divisi">Divisi</option>
            <option value="tanggal">Tanggal Pengajuan</option>
        </select>`);

        const $btnAdd = $(`<button class="row-btn add" title="Tambah baris"><i class="fa fa-plus"></i></button>`);
        const $btnRemove = $(`<button class="row-btn remove" title="Hapus baris"><i class="fa fa-times"></i></button>`);

        if(r.category) $cat.val(r.category);
        if(r.text) $search.val(r.text);
        if(r.dateStart) $dateStart.val(r.dateStart);
        if(r.dateEnd) $dateEnd.val(r.dateEnd);

        function refreshInputs(){
            const catVal = $cat.val();
            if(catVal === 'tanggal'){
                $filterRowSearch.hide();
                $dateStart.show();
                $dateEnd.show();
            } else {
                $filterRowSearch.show();
                $dateStart.hide();
                $dateEnd.hide();
            }
        }
        refreshInputs();

        $search.on('input', function(){
            const id = $wr.data('id');
            const obj = rows.find(x=>x.id===id);
            if(!obj) return;
            obj.text = $(this).val() || '';
            applyFilters();
        });

        $dateStart.on('change', function(){
            const id = $wr.data('id');
            const obj = rows.find(x=>x.id===id);
            if(!obj) return;
            obj.dateStart = $(this).val() || '';
            applyFilters();
        });
        $dateEnd.on('change', function(){
            const id = $wr.data('id');
            const obj = rows.find(x=>x.id===id);
            if(!obj) return;
            obj.dateEnd = $(this).val() || '';
            applyFilters();
        });

        $cat.on('change', function(){
            const id = $wr.data('id');
            const obj = rows.find(x=>x.id===id);
            if(!obj) return;
            obj.category = $(this).val();
            obj.text = '';
            obj.dateStart = '';
            obj.dateEnd = '';
            $search.val('');
            $dateStart.val('');
            $dateEnd.val('');
            refreshInputs();
            applyFilters();
        });

        $btnAdd.on('click', function(){
            const id = $wr.data('id');
            const idx = rows.findIndex(x=>x.id===id);
            const cur = rows[idx] || {};
            const newRow = { id: nextId(), category: cur.category || 'jenis', text:'', dateStart:'', dateEnd:'' };
            if(idx >= 0 && idx < rows.length-1){
                rows.splice(idx+1, 0, newRow);
            } else {
                rows.push(newRow);
            }
            renderRows();
            applyFilters();
        });

        $btnRemove.on('click', function(){
            const id = $wr.data('id');
            rows = rows.filter(x=>x.id !== id);
            renderRows();
            applyFilters();
        });

        $filterRowActions.append($cat).append($btnAdd).append($btnRemove);
        $wr.append($filterRowActions).append($filterRowSearch).append($dateStart).append($dateEnd);
        return $wr;
    }

    function renderRows(){
        const $b = $('#filterBuilder');
        $b.empty();
        rows.forEach(r=>{
            $b.append(makeRowDOM(r));
        });
        $('#btnResetAll').prop('hidden', rows.length === 0 && $('#tableSearch').val().trim()==='');
    }

    $('#btnAddFilterRow').click(function(){
        const cat = $('#filterCategory').val() || 'jenis';
        rows.push({ id: nextId(), category: cat, text:'', dateStart:'', dateEnd:'' });
        renderRows();
        applyFilters();
    });

    $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(fn => fn.name !== 'customRowsFilter');

    const customRowsFilter = function(settings, data){
        const q = $('#tableSearch').val().trim().toLowerCase();
        if(q){
            const keywords = q.split(/\s+/).filter(x=>x);
            const rowText = data.join(' ').toLowerCase();
            const okText = keywords.every(k => rowText.indexOf(k) >= 0);
            if(!okText) return false;
        }

        for(const r of rows){
            if(!r || !r.category) continue;

            if(r.category === 'tanggal'){
                const cell = (data[6] || '').trim();
                const start = r.dateStart || '';
                const end = r.dateEnd || '';
                if(!start && !end) continue;
                if(!cell || cell === '-') return false;
                if(start && cell < start) return false;
                if(end && cell > end) return false;
                continue;
            }

            const colIndex = (r.category === 'jenis') ? 3 : (r.category === 'dosen' ? 4 : 5);
            const cellRaw = (data[colIndex] || '').toLowerCase();

            if(!r.text || String(r.text).trim() === '') continue;

            const needle = String(r.text).toLowerCase().trim();
            if(cellRaw.indexOf(needle) === -1) return false;
        }

        return true;
    };
    Object.defineProperty(customRowsFilter, 'name', { value: 'customRowsFilter' });
    $.fn.dataTable.ext.search.push(customRowsFilter);

    function applyFilters(){
        table.draw();
        const anyFilterActive = rows.length>0 || $('#tableSearch').val().trim()!=='';
        $('#btnResetAll').prop('hidden', !anyFilterActive);
    }

    let debounce = null;
    $('#tableSearch').on('input', function(){
        if(debounce) clearTimeout(debounce);
        debounce = setTimeout(()=> applyFilters(), 180);
    });

    $('#btnResetAll').click(function(){
        rows = [];
        $('#tableSearch').val('');
        renderRows();
        applyFilters();
    });

    // ===== POPUP DETAIL - FORM-LIKE STYLE (UPDATED) =====
    $('#tabelSurat tbody').on('click','tr.row-detail',function(e){
        if($(e.target).closest('input, a, button').length) return;
        
        let raw=$(this).attr('data-detail')||'{}';
        let data={};
        try{ data=JSON.parse(raw);}catch(err){ console.error(err);}
        
        let html = `
            <div class="detail-section">
                <div class="detail-section-title">
                    <i class="fas fa-info-circle"></i>
                    Informasi Kegiatan
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Nama Kegiatan</div>
                    <div class="detail-value">${escapeHtml(data.nama_kegiatan || '-')}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Tanggal Pengajuan</div>
                    <div class="detail-value">${escapeHtml(data.created_at || '-')}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Jenis Tanggal</div>
                    <div class="detail-value">${escapeHtml(data.jenis_date || '-')}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Tempat Kegiatan</div>
                    <div class="detail-value">${escapeHtml(data.tempat_kegiatan || '-')}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Penyelenggara</div>
                    <div class="detail-value">${escapeHtml(data.penyelenggara || '-')}</div>
                </div>
            </div>

            <div class="detail-section">
                <div class="detail-section-title">
                    <i class="fas fa-users"></i>
                    Informasi Pengajuan
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Jenis Pengajuan</div>
                    <div class="detail-value">${escapeHtml(data.jenis_pengajuan || '-')}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Status Kepegawaian</div>
                    <div class="detail-value">${escapeHtml(data.lingkup_penugasan || '-')}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Jenis Penugasan</div>
                    <div class="detail-value">${escapeHtml(data.jenis_penugasan || data.jenis_penugasan_kelompok || '-')}</div>
                </div>
            </div>
        `;

        // === PERUBAHAN: Dosen Section - Menggunakan data dari relasi ===
        if (data.nama_dosen && Array.isArray(data.nama_dosen) && data.nama_dosen.length > 0) {
            html += `
                <div class="detail-section">
                    <div class="detail-section-title">
                        <i class="fas fa-user-graduate"></i>
                        Dosen Terkait
                    </div>
                    <div class="dosen-list">
            `;
            
            data.nama_dosen.forEach((nama, index) => {
                const nip = (data.nip && data.nip[index]) ? data.nip[index] : '-';
                const jabatan = (data.jabatan && data.jabatan[index]) ? data.jabatan[index] : '-';
                const divisi = (data.divisi && data.divisi[index]) ? data.divisi[index] : '-';
                const initial = nama ? nama.charAt(0).toUpperCase() : '?';
                
                html += `
                    <div class="dosen-item">
                        <div class="dosen-avatar">${initial}</div>
                        <div class="dosen-info">
                            <div class="dosen-name">${escapeHtml(nama)}</div>
                            <div class="dosen-details">
                                NIP: ${escapeHtml(nip)} | Jabatan: ${escapeHtml(jabatan)} | Divisi: ${escapeHtml(divisi)}
                            </div>
                        </div>
                    </div>
                `;
            });
            
            html += `</div></div>`;
        }

        // File Evidence Section - PERBAIKAN UTAMA
        if (data.eviden && (Array.isArray(data.eviden) ? data.eviden.length > 0 : data.eviden !== '-')) {
            html += `
                <div class="detail-section">
                    <div class="detail-section-title">
                        <i class="fas fa-file-alt"></i>
                        File Evidence
                    </div>
                    <div class="file-list">
            `;
            
            const evidenFiles = Array.isArray(data.eviden) ? data.eviden : [data.eviden];
            
            evidenFiles.forEach((file, index) => {
                let fileName = '-';
                let fileUrl = '';
                let fileType = 'unknown';
                
                if (typeof file === 'string') {
                    fileUrl = file;
                    fileName = file.split('/').pop().split('?')[0] || 'File ' + (index + 1);
                    fileType = getFileType(fileName);
                } else if (typeof file === 'object' && file !== null) {
                    fileUrl = file.cdnUrl || file.path || file.url || '';
                    fileName = file.nama_asli || file.name || fileUrl.split('/').pop().split('?')[0] || 'File ' + (index + 1);
                    fileType = getFileType(fileName);
                }
                
                // Fix URL jika tidak lengkap
                if (fileUrl && !fileUrl.match(/^https?:\/\//i)) {
                    fileUrl = BASE_URL + (fileUrl.startsWith('/') ? '' : '/') + fileUrl;
                }
                
                // Icon berdasarkan tipe file
                const fileIcon = getFileIcon(fileType);
                
                html += `
                    <div class="file-item">
                        <div class="file-icon">
                            <i class="${fileIcon}"></i>
                        </div>
                        <div class="file-info" onclick="previewFile('${escapeHtml(fileUrl)}', '${escapeHtml(fileName)}', '${fileType}')">
                            <div class="file-name">${escapeHtml(fileName)}</div>
                            <div class="file-size">${fileType.toUpperCase()}</div>
                        </div>
                        <a href="${fileUrl}" class="download-btn" download="${fileName}" target="_blank">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                `;
            });
            
            html += `</div></div>`;
        }

        $('#detailContent').html(html);
        $('#modalDetail').addClass('show');
    });

    // Helper function untuk escape HTML
    function escapeHtml(text) {
        if (!text) return '-';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Helper function untuk menentukan tipe file
    function getFileType(filename) {
        if (!filename) return 'unknown';
        
        const ext = filename.split('.').pop().toLowerCase();
        const imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
        const documentTypes = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];
        const archiveTypes = ['zip', 'rar', '7z', 'tar', 'gz'];
        
        if (imageTypes.includes(ext)) return 'image';
        if (documentTypes.includes(ext)) return 'document';
        if (archiveTypes.includes(ext)) return 'archive';
        return 'unknown';
    }

    // Helper function untuk icon file
    function getFileIcon(fileType) {
        switch(fileType) {
            case 'image':
                return 'fas fa-file-image';
            case 'document':
                return 'fas fa-file-pdf';
            case 'archive':
                return 'fas fa-file-archive';
            default:
                return 'fas fa-file';
        }
    }

    // Fungsi untuk preview file
    window.previewFile = function(fileUrl, fileName, fileType) {
        const previewModal = $('#previewModal');
        const previewTitle = $('#previewTitle');
        const previewBody = $('#previewBody');
        
        previewTitle.text(fileName);
        previewBody.empty();
        
        if (fileType === 'image') {
            // Preview gambar
            previewBody.html(`<img src="${fileUrl}" class="preview-image" alt="${fileName}">`);
        } else if (fileType === 'document' && (fileName.toLowerCase().endsWith('.pdf'))) {
            // Preview PDF
            previewBody.html(`<iframe src="${fileUrl}" class="preview-iframe" frameborder="0"></iframe>`);
        } else {
            // File tidak bisa dipreview
            previewBody.html(`
                <div class="preview-unsupported">
                    <i class="fas fa-eye-slash"></i>
                    <h4>Preview Tidak Tersedia</h4>
                    <p>File ini tidak dapat dipreview. Silakan download untuk melihat isinya.</p>
                    <a href="${fileUrl}" class="download-btn" download="${fileName}" target="_blank">
                        <i class="fas fa-download"></i> Download File
                    </a>
                </div>
            `);
        }
        
        previewModal.addClass('show');
    };

    // Close modals
    $('.close-modal').click(function(){
        $('#modalDetail').removeClass('show');
    });
    
    $('.preview-close').click(function(){
        $('#previewModal').removeClass('show');
    });
    
    $(window).click(function(e){
        if(e.target.id==='modalDetail') $('#modalDetail').removeClass('show');
        if(e.target.id==='previewModal') $('#previewModal').removeClass('show');
    });

    // Prevent download link dari menutup modal
    $(document).on('click', '.download-btn', function(e) {
        e.stopPropagation();
        // Biarkan link download berfungsi normal
    });
});
</script>
</body>
</html>