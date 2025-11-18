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

    .btn {
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        display: inline-block;
        margin: 0 2px;
    }

    .btn-warning {
        background: #ffa726;
        color: white;
    }

    .btn-warning:hover {
        background: #fb8c00;
    }

    .btn-danger {
        background: #ef5350;
        color: white;
    }

    .btn-danger:hover {
        background: #e53935;
    }

    .btn-info {
        background: #29b6f6;
        color: white;
    }

    .btn-info:hover {
        background: #039be5;
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
                        <a href="<?= site_url('surat/edit/'.$s->id); ?>" class="btn btn-warning">Edit</a>
                        <a href="<?= site_url('surat/delete/'.$s->id); ?>" class="btn btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
                        <a href="<?= base_url('surat/cetak/' . $s->id) ?>" target="_blank" class="btn btn-info btn-sm">Cetak</a>
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
            
            const form = $('<form>', {
                method: 'POST',
                action: '<?= site_url("surat/multi_delete"); ?>'
            });
            
            selectedIds.forEach(id => {
                form.append($('<input>', {
                    type: 'hidden',
                    name: 'ids[]',
                    value: id
                }));
            });
            
            $('body').append(form);
            form.submit();
        });

        // ===== FILTER FUNCTIONALITY =====
        const filterData = {
            jenis: <?= json_encode(array_values(array_unique(array_map(function($s){ return $s->jenis_pengajuan; }, $surat_list)))); ?>,
            dosen: <?= json_encode(array_values(array_unique(array_reduce($surat_list, function($carry,$s){
                if(isset($s->nama_dosen) && !empty($s->nama_dosen)){
                    $nd=$s->nama_dosen;
                    if(is_string($nd)){ $maybe=json_decode($nd,true); if(json_last_error()===JSON_ERROR_NONE) $nd=$maybe; }
                    if(is_array($nd)) foreach($nd as $d) $carry[]=trim($d); else $carry[]=trim($nd);
                }
                return $carry;
            },[])))); ?>,
            divisi: <?= json_encode(array_values(array_unique(array_reduce($surat_list,function($carry,$s){
                if(isset($s->divisi)&&!empty($s->divisi)){
                    $dv=$s->divisi;
                    if(is_string($dv)){ $maybe2=json_decode($dv,true); if(json_last_error()===JSON_ERROR_NONE) $dv=$maybe2; }
                    if(is_array($dv)) foreach($dv as $d) $carry[]=trim($d); else $carry[]=trim($dv);
                }
                return $carry;
            },[])))); ?>
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

            const $searchWrapper = $(`<div class="row-search-wrapper"></div>`);
            const $search = $(`<input type="text" class="row-search" placeholder="Search..." />`);
            const $searchIcon = $(`<i class="fa fa-search"></i>`);
            
            const $dateStart = $(`<input type="date" class="row-date-start" style="display:none" />`);
            const $dateEnd = $(`<input type="date" class="row-date-end" style="display:none" />`);

            $searchWrapper.append($search).append($searchIcon);

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
                    $searchWrapper.hide();
                    $dateStart.show();
                    $dateEnd.show();
                } else {
                    $searchWrapper.show();
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

            $wr.append($searchWrapper).append($dateStart).append($dateEnd).append($cat).append($btnAdd).append($btnRemove);
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

        // ===== POPUP DETAIL =====
        $('#tabelSurat tbody').on('click','tr.row-detail',function(e){
            if($(e.target).closest('input, a, button').length) return;
            
            let raw=$(this).attr('data-detail')||'{}';
            let data={};
            try{ data=JSON.parse(raw);}catch(err){ console.error(err);}
            let html='';
            Object.entries(data).forEach(([k,v])=>{
                let display=v;
                if(display===null||display===undefined||(typeof display==='string'&&display.trim()==='')) display='-';
                if(k==='eviden'){
                    if(typeof display==='string'){ try{display=JSON.parse(display);}catch(e){} }
                    if(Array.isArray(display)&&display.length>0){
                        let list='<ul style="margin:0;padding-left:18px;">';
                        display.forEach(item=>{
                            let url='', name='';
                            if(typeof item==='string'){ url=item; name=item.split('/').pop().split('?')[0]; }
                            else if(typeof item==='object'&&item!==null){
                                url=item.cdnUrl||item.path||item.url||'';
                                if(item.nama_asli) name=item.nama_asli;
                                else if(item.name) name=item.name;
                                else name=url.split('/').pop().split('?')[0];
                                if(url && !url.match(/^https?:\/\//i)) url=BASE_URL + (url.startsWith('/')?'':'/')+url;
                            }
                            const escName=$('<div/>').text(name).html();
                            const escUrl=$('<div/>').text(url).html();
                            list+=`<li style="margin-bottom:6px;"><a href="#" class="force-download" data-url="${escUrl}" data-name="${escName}" style="color:#FB8C00;font-weight:600;text-decoration:none;">📄 ${escName}</a></li>`;
                        });
                        list+='</ul>';
                        display=list;
                    } else display='-';
                } else if(Array.isArray(display)){
                    display=display.map(x=>$('<div/>').text(String(x)).html()).join('<br>');
                } else { if(typeof display==='string') display=$('<div/>').text(display).html(); }
                html+=`<tr><td class="detail-key">${k.replace(/_/g,' ')}</td><td>${display}</td></tr>`;
            });
            $('#detailContent').html(html);
            $('#modalDetail').addClass('show');
        });

        $(document).on("click",".force-download",function(e){
            e.preventDefault();
            const url=$(this).data("url");
            const name=$(this).data("name");
            const link=document.createElement("a");
            link.href=url+"?download=1";
            link.download=name||"file";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        $('.close-modal').click(()=>$('#modalDetail').removeClass('show'));
        $(window).click(e=>{ if(e.target.id==='modalDetail') $('#modalDetail').removeClass('show'); });

    });
    </script>
</body>
</html>