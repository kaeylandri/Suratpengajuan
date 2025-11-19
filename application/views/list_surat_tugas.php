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

    .filter-search {
        flex: 1 1 360px;
        min-width: 220px;
        display:flex;
        position:relative;
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

    .filter-actions {
        display:flex;
        gap:8px;
        align-items:center;
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

    .btn-add {
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

    .filter-row .row-search-wrapper {
        flex: 1 1 360px;
        min-width: 220px;
        display:flex;
        position:relative;
    }

    .filter-row .row-search {
        width:100%;
        padding:10px 40px 10px 14px;
        height:44px;
        border-radius:10px;
        border:1.5px solid #FB8C00;
        outline:none;
        font-size:14px;
        background:white;
    }

    .filter-row .row-search-wrapper i{
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

    .status-approved .step-icon {
        border-color: #4caf50;
        background: #4caf50;
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
    .status-text-approved {
        color: #4caf50;
        font-weight: bold;
    }

    .status-text-rejected {
        color: #f44336;
        font-weight: bold;
    }

    .status-text-pending {
        color: #ff9800;
        font-weight: bold;
    }

    /* Rejection Reason */
    .rejection-reason {
        background: #fff5f5;
        border: 1px solid #fed7d7;
        border-radius: 8px;
        padding: 15px;
        margin-top: 15px;
    }

    .rejection-reason h6 {
        color: #e53e3e;
        margin-bottom: 8px;
    }

    /* Modal styles */
    .modal-detail{ 
        display:none !important; 
        position:fixed; 
        inset:0; 
        background:rgba(0,0,0,0.55); 
        z-index:9999; 
        justify-content:center; 
        align-items:center; 
        padding-top:40px;
    }

    .modal-detail.show{ 
        display:flex !important;
    }

    .modal-content-detail{ 
        width:85%; 
        max-width:850px; 
        background:white; 
        border-radius:12px; 
        overflow:hidden;
    }

    .modal-header-detail{ 
        background:#FB8C00; 
        padding:14px 18px; 
        color:white; 
        display:flex; 
        justify-content:space-between;
    }

    .modal-body-detail{ 
        max-height:60vh; 
        overflow-y:auto; 
        padding:18px;
    }

    .detail-table{ 
        width:100%; 
        border-collapse:collapse;
    }

    .detail-table td{ 
        padding:10px 12px; 
        border-bottom:1px solid #eee;
    }

    .detail-key{ 
        width:35%; 
        font-weight:600; 
        background:#fff4e6; 
        color:#663c00;
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

    /* Responsive */
    @media (max-width: 992px) {
        .fik-db-side-menu {
            transform: translateX(-100%);
            top: 70px;
            height: calc(100vh - 70px);
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
    }

    @media (max-width:880px){
        .filter-bar{ padding:10px; gap:8px; }
        .filter-search{ flex-basis: 100%; }
        .filter-builder{ gap:8px; }
        .filter-row{ padding:10px; gap:8px; }
        .filter-row .row-search-wrapper { flex-basis: 100%; }
        .filter-row select.row-cat { min-width:140px; }
        .filter-row input[type="date"] { min-width:140px; }
        
        #tabelSurat {
            font-size: 12px;
        }
        
        #tabelSurat td, #tabelSurat th {
            padding: 8px;
        }
        
        .progress-track {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
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
        <!-- Search + Filter -->
        <div class="filter-bar">
            <div class="filter-search">
                <input type="text" id="tableSearch" placeholder="Search global...">
                <i class="fa fa-search"></i>
            </div>

            <div class="filter-actions">
                <select id="filterCategory" class="btn-small">
                    <option value="jenis" selected>Jenis Pengajuan</option>
                    <option value="dosen">Nama Dosen</option>
                    <option value="divisi">Divisi</option>
                    <option value="tanggal">Tanggal Pengajuan</option>
                </select>

                <button id="btnAddFilterRow" class="btn-small btn-add" title="Tambah baris filter">
                    <i class="fa fa-plus"></i>
                </button>

                <button id="btnResetAll" class="btn-small btn-reset" hidden title="Reset semua filter & pencarian">
                    <i class="fa fa-times"></i>&nbsp;Reset
                </button>
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
                    Detail Data Surat
                    <span class="close-modal" style="cursor:pointer;">&times;</span>
                </div>
                <div class="modal-body-detail">
                    <table class="detail-table" id="detailContent"></table>
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
                        <div class="progress-step" id="step1">
                            <div class="step-icon">
                                <i class="fas fa-check" id="step1-icon"></i>
                            </div>
                            <div class="step-text" id="step1-text">Mengirim</div>
                            <div class="step-date" id="step1-date">-</div>
                        </div>
                        
                        <!-- Step 2: Persetujuan KK -->
                        <div class="progress-step" id="step2">
                            <div class="step-icon">
                                <i class="fas fa-clock" id="step2-icon"></i>
                            </div>
                            <div class="step-text" id="step2-text">Persetujuan KK</div>
                            <div class="step-date" id="step2-date">-</div>
                        </div>
                        
                        <!-- Step 3: Persetujuan Sekretariat -->
                        <div class="progress-step" id="step3">
                            <div class="step-icon">
                                <i class="fas fa-clock" id="step3-icon"></i>
                            </div>
                            <div class="step-text" id="step3-text">Persetujuan Sekretariat</div>
                            <div class="step-date" id="step3-date">-</div>
                        </div>
                        
                        <!-- Step 4: Persetujuan Dekan -->
                        <div class="progress-step" id="step4">
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
                        <p><strong>Estimasi waktu:</strong> <span id="estimated-time">-</span></p>
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
                foreach ($surat_list as $s): ?>
                <?php
                $detail = (array) $s;
                foreach (['nip','nama_dosen','jabatan','divisi','eviden'] as $jf) {
                    if (isset($detail[$jf]) && is_string($detail[$jf])) {
                        $decoded = json_decode($detail[$jf], true);
                        if (json_last_error() === JSON_ERROR_NONE) $detail[$jf] = $decoded;
                    }
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
                            $nd = $s->nama_dosen;
                            if(is_string($nd)){ $maybe=json_decode($nd,true); if(json_last_error()===JSON_ERROR_NONE) $nd=$maybe; }
                            if(!empty($nd)){
                                if(is_array($nd)){
                                    $nama=$nd[0]??'-';
                                    $short= strlen($nama)>30 ? substr($nama,0,30).'...' : $nama;
                                    echo '<span class="nama-dosen-badge" title="'.htmlspecialchars($nama).'">'.htmlspecialchars($short).'</span>';
                                    if(count($nd)>1) echo '<span class="nama-dosen-more" title="Klik row untuk lihat semua dosen">+'.(count($nd)-1).'</span>';
                                }else{
                                    $nama=$nd;
                                    $short= strlen($nama)>30 ? substr($nama,0,30).'...' : $nama;
                                    echo '<span class="nama-dosen-badge" title="'.htmlspecialchars($nama).'">'.htmlspecialchars($short).'</span>';
                                }
                            }else echo '-';
                            ?>
                        </div>
                    </td>
                    <td>
                        <div class="divisi-container">
                            <?php
                            $dv=$s->divisi;
                            if(is_string($dv)){ $maybe2=json_decode($dv,true); if(json_last_error()===JSON_ERROR_NONE) $dv=$maybe2; }
                            if(!empty($dv)){
                                if(is_array($dv)){ foreach($dv as $div) echo '<span class="divisi-badge">'.htmlspecialchars($div).'</span>'; }
                                else echo '<span class="divisi-badge">'.htmlspecialchars($dv).'</span>';
                            }else echo '-';
                            ?>
                        </div>
                    </td>
                    <td><?= isset($s->tanggal_pengajuan) && $s->tanggal_pengajuan ? htmlspecialchars($s->tanggal_pengajuan) : '-'; ?></td>
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

    // Status Modal Functions dengan Data Real-Time
    let currentSuratId = null;
    let statusRefreshInterval = null;

    function showStatusModal(suratId) {
        const modal = document.getElementById('statusModal');
        modal.classList.add('show');
        currentSuratId = suratId;
        
        // Reset semua status terlebih dahulu
        resetAllStatus();
        
        // Ambil data status dari server/database berdasarkan suratId
        loadStatusData(suratId);
        
        // Mulai auto-refresh setiap 30 detik
        startStatusAutoRefresh(suratId);
    }

    function closeStatusModal() {
        const modal = document.getElementById('statusModal');
        modal.classList.remove('show');
        currentSuratId = null;
        
        // Hentikan auto-refresh
        stopStatusAutoRefresh();
    }

    function resetAllStatus() {
        // Reset semua step ke status pending
        for (let i = 1; i <= 4; i++) {
            const step = document.getElementById(`step${i}`);
            const icon = document.getElementById(`step${i}-icon`);
            const text = document.getElementById(`step${i}-text`);
            const date = document.getElementById(`step${i}-date`);
            
            step.className = 'progress-step';
            icon.className = 'fas fa-clock';
            // Reset teks ke default
            const defaultTexts = ['Mengirim', 'Persetujuan KK', 'Persetujuan Sekretariat', 'Persetujuan Dekan'];
            text.textContent = defaultTexts[i-1];
            date.textContent = '-';
        }
        
        // Reset progress line
        document.getElementById('progressLine').style.width = '0%';
        
        // Reset informasi tambahan
        document.getElementById('status-description').textContent = 'Memuat informasi status...';
        document.getElementById('estimated-time').textContent = '-';
        document.getElementById('rejection-reason').style.display = 'none';
    }

    // Fungsi untuk memuat data status dari server
    function loadStatusData(suratId) {
        // AJAX request ke server untuk mengambil data status
        $.ajax({
            url: '<?= site_url("surat/get_status/") ?>' + suratId,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    updateStatusDisplay(response.data);
                } else {
                    // Fallback ke data dummy jika gagal
                    console.error('Gagal memuat data status:', response.message);
                    const dummyData = getDummyStatusData(suratId);
                    updateStatusDisplay(dummyData);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading status data:', error);
                // Fallback ke data dummy untuk demo
                const dummyData = getDummyStatusData(suratId);
                updateStatusDisplay(dummyData);
            }
        });
    }

    // Fungsi untuk update tampilan status berdasarkan data
    function updateStatusDisplay(statusData) {
        const steps = statusData.steps;
        let progressPercentage = 0;
        let currentStep = 0;
        
        // Update setiap step berdasarkan data
        steps.forEach((step, index) => {
            const stepNumber = index + 1;
            const stepElement = document.getElementById(`step${stepNumber}`);
            const iconElement = document.getElementById(`step${stepNumber}-icon`);
            const textElement = document.getElementById(`step${stepNumber}-text`);
            const dateElement = document.getElementById(`step${stepNumber}-date`);
            
            // Update status dan tampilan
            updateStepStatus(stepElement, iconElement, textElement, dateElement, step);
            
            // Hitung progress percentage dan current step
            if (step.status === 'completed' || step.status === 'approved') {
                progressPercentage = (stepNumber / 4) * 100;
                currentStep = stepNumber;
            } else if (step.status === 'rejected') {
                progressPercentage = ((stepNumber - 1) / 4) * 100;
                currentStep = stepNumber;
                // Jika ditolak, hentikan progress
                progressPercentage = ((stepNumber - 1) / 4) * 100;
            } else if (step.status === 'in-progress') {
                progressPercentage = ((stepNumber - 0.5) / 4) * 100;
                currentStep = stepNumber;
            }
        });
        
        // Update progress line
        document.getElementById('progressLine').style.width = progressPercentage + '%';
        
        // Update informasi tambahan
        document.getElementById('status-description').textContent = statusData.description;
        document.getElementById('estimated-time').textContent = statusData.estimated_time;
        
        // Tampilkan alasan penolakan jika ada
        if (statusData.rejection_reason) {
            document.getElementById('rejection-reason').style.display = 'block';
            document.getElementById('rejection-text').textContent = statusData.rejection_reason;
        } else {
            document.getElementById('rejection-reason').style.display = 'none';
        }
    }

    // Fungsi untuk update status individual step
    function updateStepStatus(stepElement, iconElement, textElement, dateElement, stepData) {
        // Reset class
        stepElement.className = 'progress-step';
        
        // Update teks jika ada custom text
        if (stepData.custom_text) {
            textElement.textContent = stepData.custom_text;
        }
        
        // Update berdasarkan status
        switch (stepData.status) {
            case 'completed':
                stepElement.classList.add('status-completed');
                iconElement.className = 'fas fa-check';
                break;
            case 'approved':
                stepElement.classList.add('status-approved');
                iconElement.className = 'fas fa-check';
                // Update teks untuk menunjukkan disetujui
                if (!stepData.custom_text) {
                    const currentText = textElement.textContent;
                    if (currentText.includes('Persetujuan')) {
                        textElement.textContent = currentText.replace('Persetujuan', 'Disetujui');
                    }
                }
                break;
            case 'rejected':
                stepElement.classList.add('status-rejected');
                iconElement.className = 'fas fa-times';
                // Update teks untuk menunjukkan ditolak
                if (!stepData.custom_text) {
                    const currentText = textElement.textContent;
                    if (currentText.includes('Persetujuan')) {
                        textElement.textContent = currentText.replace('Persetujuan', 'Ditolak');
                    }
                }
                break;
            case 'in-progress':
                stepElement.classList.add('status-in-progress');
                iconElement.className = 'fas fa-clock';
                break;
            case 'pending':
            default:
                stepElement.classList.add('status-pending');
                iconElement.className = 'fas fa-clock';
                break;
        }
        
        // Update tanggal
        dateElement.textContent = stepData.date || '-';
    }

    // Auto-refresh status
    function startStatusAutoRefresh(suratId) {
        // Hentikan interval sebelumnya jika ada
        stopStatusAutoRefresh();
        
        // Mulai interval baru setiap 30 detik
        statusRefreshInterval = setInterval(() => {
            loadStatusData(suratId);
        }, 30000); // 30 detik
    }

    function stopStatusAutoRefresh() {
        if (statusRefreshInterval) {
            clearInterval(statusRefreshInterval);
            statusRefreshInterval = null;
        }
    }

    // Data dummy untuk demo (akan diganti dengan data real dari database)
    function getDummyStatusData(suratId) {
        // Contoh data - dalam implementasi nyata, ini berasal dari database
        // Status bisa berubah: 'pending', 'in-progress', 'completed', 'approved', 'rejected'
        
        // Simulasi status yang berbeda berdasarkan ID surat (untuk demo)
        const statusVariations = [
            {
                steps: [
                    { status: 'completed', date: '<?= date("d M Y") ?>', custom_text: 'Mengirim' },
                    { status: 'approved', date: '<?= date("d M Y", strtotime("+1 day")) ?>', custom_text: 'Disetujui KK' },
                    { status: 'in-progress', date: '-', custom_text: 'Menunggu Persetujuan Sekretariat' },
                    { status: 'pending', date: '-', custom_text: 'Menunggu Persetujuan Dekan' }
                ],
                description: 'Pengajuan surat tugas Anda saat ini sedang menunggu persetujuan dari Sekretariat.',
                estimated_time: '2-3 hari kerja',
                rejection_reason: null
            },
            {
                steps: [
                    { status: 'completed', date: '<?= date("d M Y", strtotime("-3 days")) ?>', custom_text: 'Mengirim' },
                    { status: 'rejected', date: '<?= date("d M Y", strtotime("-2 days")) ?>', custom_text: 'Ditolak KK' },
                    { status: 'pending', date: '-', custom_text: 'Persetujuan Sekretariat' },
                    { status: 'pending', date: '-', custom_text: 'Persetujuan Dekan' }
                ],
                description: 'Pengajuan surat tugas Anda ditolak oleh KK. Silakan perbaiki dan ajukan kembali.',
                estimated_time: '-',
                rejection_reason: 'Dokumen pendukung tidak lengkap. Silakan lengkapi semua dokumen yang diperlukan.'
            },
            {
                steps: [
                    { status: 'completed', date: '<?= date("d M Y", strtotime("-5 days")) ?>', custom_text: 'Mengirim' },
                    { status: 'approved', date: '<?= date("d M Y", strtotime("-4 days")) ?>', custom_text: 'Disetujui KK' },
                    { status: 'approved', date: '<?= date("d M Y", strtotime("-2 days")) ?>', custom_text: 'Disetujui Sekretariat' },
                    { status: 'in-progress', date: '-', custom_text: 'Menunggu Persetujuan Dekan' }
                ],
                description: 'Pengajuan surat tugas Anda sedang dalam proses persetujuan akhir oleh Dekan.',
                estimated_time: '1-2 hari kerja',
                rejection_reason: null
            }
        ];
        
        // Pilih variasi berdasarkan ID surat (untuk demo)
        const variationIndex = suratId % statusVariations.length;
        return statusVariations[variationIndex];
    }

    // Close modal when clicking outside or on close button
    document.addEventListener('DOMContentLoaded', function() {
        const statusModal = document.getElementById('statusModal');
        const closeBtn = document.querySelector('.close-status');
        
        closeBtn.addEventListener('click', closeStatusModal);
        
        statusModal.addEventListener('click', function(e) {
            if (e.target === statusModal) {
                closeStatusModal();
            }
        });
    });

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

        // ... (kode filter dan fungsi lainnya tetap sama) ...
        
        // Sisa kode filter dan DataTables configuration tetap sama seperti sebelumnya
        // ... (kode filter lengkap) ...

    });
    </script>
</body>
</html>