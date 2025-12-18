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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* ===== NAVBAR & SIDEBAR STYLES ===== */
        body {
            background-color: #f6f9fb;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* HEADER/NAVBAR */
        .navbar {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
            z-index: 1030;
            height: 70px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
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
            width: 40px;
            height: 40px;
            cursor: pointer;
            color: #FB8C00;
            font-size: 24px;
            background: none;
            border: none;
            align-items: center;
            justify-content: center;
        }

        /* SIDEBAR MODERN STYLE */
        .fik-db-side-menu {
            position: fixed;
            left: 0;
            top: 70px;
            width: 260px;
            height: calc(100vh - 70px);
            background: linear-gradient(180deg, #FF8C00 0%, #FB8C00 100%);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            z-index: 1020;
            display: flex;
            flex-direction: column;
            transform: translateX(0);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fik-db-side-menu::-webkit-scrollbar {
            width: 5px;
        }

        .fik-db-side-menu::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .fik-db-side-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .fik-db-side-menu .card.profil {
            text-align: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.15);
            display: none;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .fik-db-side-menu .card.profil .img-wrapper {
            margin-bottom: 10px;
        }

        .fik-db-side-menu .card.profil .img-wrapper img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.5);
            object-fit: cover;
        }

        .fik-db-side-menu .card.profil b {
            display: block;
            color: white;
            font-size: 15px;
            margin-bottom: 3px;
        }

        .fik-db-side-menu .card.profil span {
            color: rgba(255, 255, 255, 0.8);
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
            text-decoration: none;
        }

        .fik-db-side-menu .btn:hover,
        .fik-db-side-menu .btn:focus {
            background: rgba(255, 255, 255, 0.15);
            border-left-color: white;
            text-decoration: none;
            padding-left: 24px;
        }

        .fik-db-side-menu .btn.active {
            background: rgba(255, 255, 255, 0.2);
            border-left-color: white;
        }

        .fik-db-side-menu .btn i,
        .fik-db-side-menu .btn span.fas,
        .fik-db-side-menu .btn span.fa {
            width: 20px;
            text-align: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .menu-text {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .collapse-arrow {
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        .btn[aria-expanded="true"] .collapse-arrow {
            transform: rotate(180deg);
        }

        .fik-db-side-menu .collapse {
            background: rgba(0, 0, 0, 0.15);
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
            color: rgba(255, 255, 255, 0.9);
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
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding-left: 56px;
        }

        .divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
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
            background: rgba(255, 255, 255, 0.2);
        }

        /* Sidebar Overlay for Mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 70px;
            left: 0;
            width: 100%;
            height: calc(100vh - 70px);
            background: rgba(0, 0, 0, 0.5);
            z-index: 1010;
            cursor: pointer;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Body lock when sidebar is open */
        body.sidebar-open {
            overflow: hidden;
        }

        .main-content {
            margin-left: 260px;
            margin-top: 70px;
            padding: 30px;
            transition: margin-left 0.3s ease, width 0.3s ease;
            min-height: 100vh;
            width: calc(100% - 260px);
            box-sizing: border-box;
        }

        /* ===== REVISI: Header Action Buttons ===== */
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 0 10px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin: 0;
        }

        /* REVISI: Action buttons group dengan layout baru */
        .action-buttons-group {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        /* REVISI: Tombol Tambah Surat - lebih mencolok */
        .btn-add-surat {
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 15px;
            background: linear-gradient(135deg, #FB8C00 0%, #FF9800 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(251, 140, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-add-surat:hover {
            background: linear-gradient(135deg, #e67e00 0%, #F57C00 100%);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(251, 140, 0, 0.4);
            text-decoration: none;
        }

        .btn-add-surat:active {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(251, 140, 0, 0.3);
        }

        .btn-add-surat i {
            font-size: 16px;
        }

        /* REVISI: Tombol Kembali di pojok kanan */
        .btn-back {
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
            background: #6c757d;
            color: white;
        }

        .btn-back:hover {
            background: #5a6268;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-decoration: none;
        }

        /* ===== TABLE FILTER STYLES ===== */
        .filter-bar {
            width: 100%;
            background: #ffffff;
            padding: 12px 14px;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 14px;
            border: 1px solid #f0f0f0;
            flex-wrap: wrap;
        }

        .filter-actions {
            display: flex;
            gap: 8px;
            align-items: center;
            order: 1;
        }

        .filter-search {
            flex: 1 1 360px;
            min-width: 220px;
            display: flex;
            position: relative;
            order: 2;
            margin-left: auto;
        }

        .filter-search input {
            width: 100%;
            padding: 10px 40px 10px 14px;
            height: 44px;
            border-radius: 10px;
            border: 1.5px solid #FB8C00;
            outline: none;
            font-size: 14px;
        }

        .filter-search i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #FB8C00;
            pointer-events: none;
        }

        .btn-small {
            height: 44px;
            min-width: 44px;
            border-radius: 10px;
            border: 1.5px solid #FB8C00;
            padding: 0 12px;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: white;
        }

        .btn-small-add {
            background: #FB8C00;
            color: white;
        }

        .btn-reset {
            background: #FB8C00;
            color: white;
            border: 1.5px solid #FB8C00;
            border-radius: 10px;
            padding: 0 14px;
            height: 44px;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-reset[hidden] {
            display: none;
        }

        .filter-builder {
            display: flex;
            gap: 10px;
            align-items: center;
            width: 100%;
            flex-wrap: wrap;
            margin-bottom: 14px;
        }

        .filter-row {
            width: 100%;
            background: #ffffff;
            padding: 12px 14px;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
            display: flex;
            gap: 12px;
            align-items: center;
            border: 1px solid #f0f0f0;
            flex-wrap: wrap;
        }

        .filter-row-actions {
            display: flex;
            gap: 8px;
            align-items: center;
            order: 1;
        }

        .filter-row-search {
            flex: 1 1 360px;
            min-width: 220px;
            display: flex;
            position: relative;
            order: 2;
            margin-left: auto;
        }

        .filter-row-search input {
            width: 100%;
            padding: 10px 40px 10px 14px;
            height: 44px;
            border-radius: 10px;
            border: 1.5px solid #FB8C00;
            outline: none;
            font-size: 14px;
            background: white;
        }

        .filter-row-search i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #FB8C00;
            pointer-events: none;
        }

        .filter-row select.row-cat {
            height: 44px;
            min-width: 44px;
            border-radius: 10px;
            border: 1.5px solid #FB8C00;
            padding: 0 14px;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: white;
            outline: none;
        }

        .filter-row input[type="date"] {
            height: 44px;
            padding: 0 14px;
            border-radius: 10px;
            border: 1.5px solid #FB8C00;
            background: white;
            font-size: 14px;
            min-width: 160px;
            outline: none;
        }

        .filter-row .row-btn {
            height: 44px;
            min-width: 44px;
            border-radius: 10px;
            border: 1.5px solid #FB8C00;
            padding: 0 14px;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: white;
        }

        .filter-row .row-btn.add {
            background: #FB8C00;
            color: #fff;
        }

        .filter-row .row-btn.add:hover {
            background: #e67e00;
        }

        .filter-row .row-btn.remove {
            background: #FB8C00;
            color: white;
        }

        .filter-row .row-btn.remove:hover {
            background: #e67e00;
        }

        /* ===== REVISI: Multi-action buttons (disembunyikan) ===== */
        .multi-actions {
            display: none !important;
        }

        /* Table styles */
        #tabelSurat {
            width: 100% !important;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-family: 'Montserrat', sans-serif;
            table-layout: auto;
            max-width: 100%;
        }

        #tabelSurat_wrapper {
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: auto !important;
        }

        #tabelSurat thead {
            background: #FB8C00;
            color: white;
        }

        #tabelSurat td,
        #tabelSurat th {
            padding: 12px;
            border: 1px solid #eee;
            vertical-align: middle;
            text-align: center;
            overflow: hidden;
            white-space: normal;
            word-wrap: break-word;
        }

        /* ===== REVISI: Column widths (dengan perubahan kolom) ===== */
        #tabelSurat th:nth-child(1),
        #tabelSurat td:nth-child(1) {
            width: 4%;
            max-width: 50px;
        }

        #tabelSurat th:nth-child(2),
        #tabelSurat td:nth-child(2) {
            width: 5%;
            max-width: 60px;
        }

        #tabelSurat th:nth-child(3),
        #tabelSurat td:nth-child(3) {
            width: 25%;
            min-width: 200px;
            text-align: left;
        }

        #tabelSurat th:nth-child(4),
        #tabelSurat td:nth-child(4) {
            width: 12%;
            min-width: 120px;
        }

        #tabelSurat th:nth-child(5),
        #tabelSurat td:nth-child(5) {
            width: 20%;
            min-width: 180px;
        }

        /* REVISI: Kolom 6: Status (menggantikan Divisi) */
        #tabelSurat th:nth-child(6),
        #tabelSurat td:nth-child(6) {
            width: 15%;
            min-width: 150px;
        }

        /* REVISI: Kolom 7: Tanggal Kegiatan (menggantikan Tanggal Pengajuan) */
        #tabelSurat th:nth-child(7),
        #tabelSurat td:nth-child(7) {
            width: 12%;
            min-width: 120px;
        }

        #tabelSurat th:nth-child(8),
        #tabelSurat td:nth-child(8) {
            width: 12%;
            min-width: 150px;
        }

        #tabelSurat td:nth-child(3) {
            white-space: normal;
            overflow: visible;
            text-overflow: clip;
            cursor: pointer;
            max-height: 60px;
            overflow-y: hidden;
        }

        #tabelSurat td:nth-child(3):hover {
            background-color: #fffaf5;
        }

        #tabelSurat tbody tr.row-detail {
            cursor: pointer;
            transition: background 0.2s;
        }

        #tabelSurat tbody tr.row-detail:hover {
            background: #fffaf5;
        }

        #tabelSurat tbody tr.row-detail.selected {
            background: #fff4e6;
        }

        .row-checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #FB8C00;
        }

        #checkAll {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #FB8C00;
        }

        /* ===== REVISI: Styling khusus untuk kolom nama dosen ===== */
        .dosen-container {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            align-items: center;
            justify-content: center;
            max-width: 100%;
            cursor: pointer;
            transition: all 0.2s ease;
            padding: 8px;
            border-radius: 8px;
        }

        .dosen-container:hover {
            background-color: #fff4e6;
            transform: translateY(-1px);
        }

        .dosen-container.clickable {
            cursor: pointer;
            position: relative;
        }

        .dosen-container.clickable::after {
            content: '👁️';
            font-size: 10px;
            margin-left: 5px;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .dosen-container.clickable:hover::after {
            opacity: 1;
        }

        .nama-dosen-badge {
            display: inline-block;
            background: #fff4e6;
            color: #663c00;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            border: 1px solid #FB8C00;
            white-space: nowrap;
            max-width: 250px;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: all 0.2s;
            cursor: pointer;
        }

        .dosen-container:hover .nama-dosen-badge {
            background: #FB8C00;
            color: white;
            box-shadow: 0 2px 5px rgba(251, 140, 0, 0.2);
        }
/* Style untuk dosen tunggal (tanpa modal) */
.dosen-container.single-dosen {
    cursor: default !important;
}

.dosen-container.single-dosen .nama-dosen-badge {
    cursor: default !important;
    background: #e9ecef !important;
    color: #495057 !important;
    border: 1px solid #dee2e6 !important;
}

.dosen-container.single-dosen .nama-dosen-badge:hover {
    background: #e9ecef !important;
    color: #495057 !important;
    transform: none !important;
    box-shadow: none !important;
}

.dosen-container.single-dosen::after {
    content: none !important;
}

/* Pointer cursor hanya untuk multiple dosen */
.dosen-container.clickable {
    cursor: pointer !important;
}

.dosen-container.clickable .nama-dosen-badge {
    cursor: pointer !important;
}
        .nama-dosen-more {
            display: inline-block;
            background: #FB8C00;
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .nama-dosen-more:hover {
            transform: scale(1.03);
            background: #e67e00;
            box-shadow: 0 3px 8px rgba(230, 126, 0, 0.3);
        }

        /* ===== REVISI: Modal Popup Detail Dosen - NEW STYLE ===== */
        .dosen-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 10010;
            justify-content: center;
            align-items: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .dosen-modal.show {
            display: flex;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .dosen-modal-content {
            background: white;
            border-radius: 16px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .dosen-modal.show .dosen-modal-content {
            animation: slideUp 0.4s ease;
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .dosen-modal-header {
            background: linear-gradient(135deg, #FB8C00 0%, #FF9800 100%);
            color: white;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dosen-modal-title {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dosen-modal-title i {
            font-size: 20px;
        }

        .dosen-modal-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .dosen-modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .dosen-modal-body {
            padding: 25px;
            overflow-y: auto;
            max-height: 60vh;
        }

        /* ===== NEW STYLE: Format seperti contoh image.png ===== */
        .dosen-section {
            margin-bottom: 25px;
        }

        .dosen-section-title {
            font-size: 18px;
            font-weight: 700;
            color: #FB8C00;
            margin-bottom: 20px;
            padding-bottom: 8px;
            border-bottom: 2px solid #FB8C00;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dosen-section-title i {
            font-size: 20px;
        }

        .dosen-item {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-bottom: 10px;
            background: #f8f9fa;
        }

        .dosen-info {
            display: flex;
            flex-direction: column;
        }

        .dosen-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .dosen-details div {
            font-size: 14px;
            margin-bottom: 3px;
            color: #444;
        }


        .dosen-detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #495057;
            line-height: 1.5;
        }

        .dosen-detail-item i {
            width: 20px;
            text-align: center;
            color: #FB8C00;
            font-size: 16px;
        }

        .dosen-detail-label {
            font-weight: 600;
            color: #495057;
            min-width: 60px;
        }

        .dosen-detail-value {
            color: #212529;
        }

        .no-dosen {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .no-dosen i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #adb5bd;
        }

        .no-dosen h4 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #495057;
        }

        .dosen-modal-footer {
            padding: 15px 25px;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
            text-align: center;
        }

        .dosen-total {
            font-size: 14px;
            color: #6c757d;
            font-weight: 600;
        }

        .dosen-total strong {
            color: #FB8C00;
            font-size: 16px;
        }

        .dosen-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 14px 18px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            margin-bottom: 12px;
            background: #ffffff;
        }

        .dosen-avatar {
            width: 40px;
            height: 40px;
            background: #ff9800;
            color: white;
            font-weight: bold;
            font-size: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dosen-card-info {
            display: flex;
            flex-direction: column;
        }

        .dosen-card-name {
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 4px;
        }

        .dosen-card-detail {
            font-size: 13px;
            color: #5b5b5b;
        }

        /* Hapus icon mata otomatis dari elemen dosen */
        .dosen-container::after,
        .dosen-container::before,
        .nama-dosen-badge::after,
        .nama-dosen-badge::before,
        .nama-dosen-more::after,
        .nama-dosen-more::before {
            content: none !important;
            display: none !important;
        }


        /* ===== REVISI: Status Badge Styles ===== */
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            min-width: 100px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .status-disetujui {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-ditolak {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-proses {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        /* ===== REVISI: Action buttons dengan layout baru ===== */
        .action-buttons-container {
            display: flex;
            gap: 6px;
            justify-content: center;
            align-items: center;
            width: 100%;
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
            flex-shrink: 0;
            text-decoration: none;
        }

        .btn-icon-action:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-edit {
            background: #ffa726;
            color: white;
        }

        .btn-edit:hover {
            background: #fb8c00;
        }

        .btn-edit-disabled {
            opacity: 0.5 !important;
            cursor: not-allowed !important;
            pointer-events: auto !important;
            background: #6c757d !important;
        }

        .btn-edit-disabled:hover {
            transform: none !important;
            box-shadow: none !important;
            background: #6c757d !important;
        }

        .btn-delete {
            background: #ef5350;
            color: white;
        }

        .btn-delete:hover {
            background: #e53935;
        }

        .btn-print {
            background: #29b6f6;
            color: white;
        }

        .btn-print:hover {
            background: #039be5;
        }

        .btn-status {
            background: #66bb6a;
            color: white;
        }

        .btn-status:hover {
            background: #4caf50;
        }

        .btn-print-disabled {
            opacity: 0.5 !important;
            cursor: not-allowed !important;
            pointer-events: none !important;
            background: #6c757d !important;
        }

        .btn-print-disabled:hover {
            transform: none !important;
            box-shadow: none !important;
            background: #6c757d !important;
        }

        .btn-icon-action[disabled] {
            opacity: 0.5;
            cursor: not-allowed !important;
            pointer-events: none;
        }

        .btn-icon-action[disabled]:hover {
            transform: none !important;
            box-shadow: none !important;
        }

        /* ===== PERBAIKAN: Status Modal Styles - NO SCROLL ===== */
        .status-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .status-modal.show {
            display: flex;
        }

        .status-content {
            background: white;
            border-radius: 12px;
            width: 700px;
            max-width: 700px;
            padding: 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-height: 85vh;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .status-header {
            background: #FB8C00;
            color: white;
            padding: 20px;
            border-radius: 12px 12px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .status-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }

        .close-status {
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

        .close-status:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .status-body {
            padding: 25px;
        }

        /* ===== REVISI: Progress Bar sesuai image.png ===== */
        .progress-container {
            margin: 20px 0 30px;
        }

        .progress-track {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-bottom: 15px;
            min-width: 650px;
        }

        /* Garis latar belakang - DIUBAH: dipindah ke tengah lingkaran */
        .progress-track::before {
            content: '';
            position: absolute;
            top: 40px;
            /* Sejajar dengan tengah lingkaran */
            left: 60px;
            right: 60px;
            height: 4px;
            background: #e0e0e0;
            z-index: 1;
            border-radius: 2px;
        }

        /* Garis progress aktif - DIUBAH: dipindah ke tengah lingkaran */
        .progress-line {
            position: absolute;
            top: 40px;
            /* Sejajar dengan tengah lingkaran */
            left: 60px;
            height: 4px;
            background: #4CAF50;
            z-index: 2;
            border-radius: 2px;
            transition: width 0.5s ease;
        }

        /* Step Container */
        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 3;
            width: 140px;
            min-width: 140px;
            flex-shrink: 0;
        }

        /* Step Icon Container */
        .step-icon-container {
            position: relative;
            margin-bottom: 8px;
        }

        .step-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            border: 3px solid #e0e0e0;
            background: white;
            position: relative;
            z-index: 4;
            transition: all 0.3s ease;
        }

        /* Step Text */
        .step-text {
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            color: #333;
            margin-bottom: 4px;
            line-height: 1.3;
            min-height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        .step-date {
            font-size: 11px;
            color: #666;
            text-align: center;
            display: block;
            width: 100%;
        }

        /* Estimasi Waktu - DIUBAH: Dipindah ke atas lingkaran */
        .step-estimasi {
            position: absolute;
            top: -25px;
            /* Di atas lingkaran */
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            color: #666;
            border: 1px solid #e0e0e0;
            white-space: nowrap;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            z-index: 5;
            width: 100px;
            text-align: center;
        }

        /* Status Colors */
        .progress-step.completed .step-icon {
            background-color: #4CAF50;
            border-color: #4CAF50;
            color: white;
        }

        .progress-step.in-progress .step-icon {
            background: #FF9800;
            border-color: #FF9800;
            color: white;
            animation: pulse 2s infinite;
        }

        .progress-step.rejected .step-icon {
            background: #F44336;
            border-color: #F44336;
            color: white;
        }

        .progress-step.pending .step-icon {
            background: white;
            border-color: #e0e0e0;
            color: #999;
        }

        /* Icon Colors */
        .progress-step.completed .step-icon i {
            color: white;
        }

        .progress-step.in-progress .step-icon i {
            color: white;
        }

        .progress-step.rejected .step-icon i {
            color: white;
        }

        .progress-step.pending .step-icon i {
            color: #999;
        }

        /* Animation for in-progress */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 152, 0, 0.4);
            }

            70% {
                box-shadow: 0 0 0 6px rgba(255, 152, 0, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(255, 152, 0, 0);
            }
        }

        /* Status Information */
        .status-info {
            margin-top: 30px;
            padding: 18px;
            background: #f8f9fa;
            border-radius: 10px;
            border: 1px solid #e9ecef;
            width: 100%;
            box-sizing: border-box;
        }

        .status-info h5 {
            color: #FB8C00;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-info h5 i {
            font-size: 18px;
        }

        .status-info p {
            color: #495057;
            font-size: 14px;
            line-height: 1.5;
            margin: 0;
        }

        /* Rejection Reason */
        .rejection-reason {
            background: #fff5f5;
            border: 1px solid #f8cccc;
            padding: 12px;
            border-radius: 8px;
            margin-top: 12px;
            width: 100%;
            box-sizing: border-box;
        }

        .rejection-reason h6 {
            color: #e63946;
            font-weight: 700;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
        }

        .rejection-reason h6 i {
            font-size: 16px;
        }

        .rejection-reason p {
            color: #495057;
            font-size: 13px;
            line-height: 1.4;
            margin: 0;
        }

        /* Detail Modal Styles */
        .modal-detail {
            display: none !important;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-detail.show {
            display: flex !important;
        }

        .modal-content-detail {
            width: 90%;
            max-width: 800px;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header-detail {
            background: #FB8C00;
            padding: 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
            font-weight: 600;
        }

        .modal-body-detail {
            padding: 30px;
            background: #f8f9fa;
        }

        /* Form-like detail styles */
        .detail-section {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
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

        .dosen-item-detail {
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

        .dosen-name-detail {
            font-weight: 600;
            color: #212529;
            font-size: 14px;
        }

        .dosen-details-detail {
            font-size: 12px;
            color: #6c757d;
        }

        /* ===== FILE EVIDENCE STYLES ===== */
        .file-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .file-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            transition: all 0.2s;
            border-left: 4px solid #FB8C00;
        }

        .file-item:hover {
            background: #fffaf5;
            border-color: #FB8C00;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .file-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            flex-shrink: 0;
        }

        .file-icon-pdf {
            background: #e74c3c;
        }

        .file-icon-image {
            background: #3498db;
        }

        .file-icon-doc {
            background: #2980b9;
        }

        .file-icon-xls {
            background: #27ae60;
        }

        .file-icon-ppt {
            background: #e67e22;
        }

        .file-icon-zip {
            background: #8e44ad;
        }

        .file-icon-unknown {
            background: #95a5a6;
        }

        .file-info {
            flex: 1;
            min-width: 0;
            cursor: pointer;
        }

        .file-name {
            font-weight: 600;
            color: #212529;
            font-size: 14px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            margin-bottom: 4px;
        }

        .file-details {
            display: flex;
            gap: 15px;
            font-size: 12px;
            color: #6c757d;
        }

        .file-type {
            background: #e9ecef;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 600;
        }

        .file-size {
            color: #6c757d;
        }

        .file-actions {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }

        .download-btn {
            background: #FB8C00;
            color: white;
            border: none;
            padding: 8px 16px;
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
            transform: translateY(-1px);
        }

        .preview-btn {
            background: #3498db;
            color: white;
            border: none;
            padding: 8px 16px;
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

        .preview-btn:hover {
            background: #2980b9;
            text-decoration: none;
            color: white;
            transform: translateY(-1px);
        }

        .preview-btn.disabled {
            background: #bdc3c7;
            cursor: not-allowed;
            transform: none;
        }

        .preview-btn.disabled:hover {
            background: #bdc3c7;
            transform: none;
        }

        /* No files message */
        .no-files {
            text-align: center;
            padding: 30px;
            color: #6c757d;
            background: #f8f9fa;
            border-radius: 8px;
            border: 2px dashed #dee2e6;
        }

        .no-files i {
            font-size: 48px;
            margin-bottom: 10px;
            color: #adb5bd;
        }

        /* Preview Modal Styles */
        .preview-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
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
            background: rgba(255, 255, 255, 0.2);
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
            background: rgba(255, 255, 255, 0.2);
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
            transition: padding-left 0.3s ease;
        }

        .credit {
            color: #666;
            font-size: 14px;
        }

        /* ===== PERBAIKAN: Responsive Fixes for Status Modal ===== */
        @media (max-width: 768px) {
            .status-content {
                width: 95%;
                max-width: 95%;
                margin: 10px;
                max-height: 80vh;
            }

            .status-body {
                padding: 20px;
            }

            .progress-track {
                min-width: 100%;
                flex-wrap: nowrap;
                overflow-x: auto;
                overflow-y: hidden;
                padding-bottom: 10px;
                justify-content: flex-start;
                gap: 0;
            }

            .progress-track::-webkit-scrollbar {
                height: 4px;
            }

            .progress-track::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 2px;
            }

            .progress-track::-webkit-scrollbar-thumb {
                background: #FB8C00;
                border-radius: 2px;
            }

            .progress-step {
                width: 120px;
                min-width: 120px;
            }

            .step-icon {
                width: 50px;
                height: 50px;
                font-size: 18px;
                border-width: 2px;
            }

            .step-text {
                font-size: 11px;
                min-height: 30px;
            }

            .step-date {
                font-size: 10px;
            }

            .step-estimasi {
                font-size: 9px;
                top: -22px;
                padding: 2px 6px;
                width: 80px;
            }

            .progress-track::before {
                top: 35px;
                /* Diperbaiki untuk mobile */
                left: 50px;
                right: 50px;
            }

            .progress-line {
                top: 35px;
                /* Diperbaiki untuk mobile */
                left: 50px;
            }

            .status-info h5 {
                font-size: 15px;
            }

            .status-info p {
                font-size: 13px;
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

            /* Responsive Dosen Modal */
            .dosen-modal-content {
                width: 95%;
                margin: 10px;
            }

            .dosen-modal-body {
                padding: 15px;
            }

            .dosen-item {
                padding: 15px;
            }

            .dosen-name {
                font-size: 15px;
            }

            .dosen-detail-item {
                font-size: 13px;
            }

            .nama-dosen-badge {
                max-width: 180px;
            }
        }

        @media (max-width: 576px) {
            .progress-track {
                min-width: 500px;
            }

            .progress-step {
                width: 100px;
                min-width: 100px;
            }

            .step-icon {
                width: 45px;
                height: 45px;
                font-size: 16px;
            }

            .step-text {
                font-size: 10px;
            }

            .step-date {
                font-size: 9px;
            }

            .step-estimasi {
                width: 70px;
                font-size: 8px;
                top: -20px;
            }

            .progress-track::before {
                top: 32px;
                /* Diperbaiki untuk mobile kecil */
                left: 45px;
                right: 45px;
            }

            .progress-line {
                top: 32px;
                /* Diperbaiki untuk mobile kecil */
                left: 45px;
            }

            .hide-mobile {
                display: none !important;
            }

            .show-mobile {
                display: block !important;
            }

            .fik-footer {
                padding-left: 20px;
                text-align: center;
            }

            /* Responsive Dosen Modal */
            .dosen-modal-header {
                padding: 15px;
            }

            .dosen-modal-title {
                font-size: 16px;
            }

            .dosen-section-title {
                font-size: 16px;
            }

            .dosen-name {
                font-size: 14px;
            }

            .dosen-detail-item {
                font-size: 12px;
            }

            .nama-dosen-badge {
                max-width: 150px;
                font-size: 11px;
            }
        }

        /* ===== RESPONSIVE STYLES ===== */
        @media (max-width: 1200px) {
            .main-content {
                padding: 20px;
                margin-left: 260px;
                width: calc(100% - 260px);
            }

            #tabelSurat th:nth-child(3),
            #tabelSurat td:nth-child(3) {
                width: 22%;
                min-width: 180px;
            }

            #tabelSurat th:nth-child(5),
            #tabelSurat td:nth-child(5) {
                width: 18%;
                min-width: 160px;
            }

            #tabelSurat th:nth-child(6),
            #tabelSurat td:nth-child(6) {
                width: 14%;
                min-width: 130px;
            }
        }

        @media (max-width: 992px) {

            /* MOBILE SIDEBAR FIX */
            .fik-db-side-menu {
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .fik-db-side-menu.active {
                transform: translateX(0);
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            }

            .sidebar-overlay.active {
                display: block;
            }

            .db-menu-trigger {
                display: flex;
                margin-right: 15px;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 15px;
            }

            .main-content.shifted {
                margin-left: 260px;
                width: calc(100% - 260px);
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

            /* Responsive action buttons */
            .action-buttons-container {
                gap: 4px;
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

            .filter-bar {
                padding: 10px;
                gap: 8px;
            }

            .filter-search {
                flex-basis: 100%;
            }

            .filter-builder {
                gap: 8px;
            }

            .filter-row {
                padding: 10px;
                gap: 8px;
            }

            .filter-row .filter-row-search {
                flex-basis: 100%;
            }

            .filter-row select.row-cat {
                min-width: 140px;
            }

            .filter-row input[type="date"] {
                min-width: 140px;
            }

            #tabelSurat {
                font-size: 12px;
            }

            #tabelSurat td,
            #tabelSurat th {
                padding: 8px;
            }

            /* Table column adjustments for tablet */
            #tabelSurat th:nth-child(1),
            #tabelSurat td:nth-child(1) {
                width: 5%;
                max-width: 40px;
            }

            #tabelSurat th:nth-child(2),
            #tabelSurat td:nth-child(2) {
                width: 6%;
                max-width: 50px;
            }

            #tabelSurat th:nth-child(3),
            #tabelSurat td:nth-child(3) {
                width: 25%;
                min-width: 150px;
            }

            #tabelSurat th:nth-child(4),
            #tabelSurat td:nth-child(4) {
                width: 15%;
                min-width: 100px;
            }

            #tabelSurat th:nth-child(5),
            #tabelSurat td:nth-child(5) {
                width: 20%;
                min-width: 140px;
            }

            #tabelSurat th:nth-child(6),
            #tabelSurat td:nth-child(6) {
                width: 16%;
                min-width: 120px;
            }

            #tabelSurat th:nth-child(7),
            #tabelSurat td:nth-child(7) {
                width: 12%;
                min-width: 100px;
            }

            #tabelSurat th:nth-child(8),
            #tabelSurat td:nth-child(8) {
                width: 11%;
                min-width: 120px;
            }

            /* Responsive file items */
            .file-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .file-actions {
                width: 100%;
                justify-content: space-between;
            }

            .download-btn,
            .preview-btn {
                flex: 1;
                justify-content: center;
            }

            /* Responsive Dosen Container */
            .dosen-container {
                padding: 6px;
            }

            .nama-dosen-badge {
                max-width: 180px;
                font-size: 11px;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 10px;
            }

            #tabelSurat {
                font-size: 11px;
            }

            #tabelSurat td,
            #tabelSurat th {
                padding: 6px 4px;
            }

            #tabelSurat_wrapper {
                overflow-x: auto;
            }

            .nama-dosen-badge {
                max-width: 120px;
                font-size: 10px;
                padding: 4px 8px;
            }

            .status-badge {
                min-width: 80px;
                font-size: 10px;
                padding: 4px 8px;
            }

            .btn-icon-action {
                width: 28px;
                height: 28px;
                font-size: 10px;
            }

            /* Hide checkbox column on small mobile */
            #tabelSurat th:nth-child(1),
            #tabelSurat td:nth-child(1) {
                display: none;
            }

            /* Hide jenis pengajuan column on small mobile */
            #tabelSurat th:nth-child(4),
            #tabelSurat td:nth-child(4) {
                display: none;
            }

            /* Action buttons layout for mobile */
            .action-buttons-container {
                flex-direction: column;
                gap: 3px;
            }

            /* Dosen Modal adjustments */
            .dosen-modal {
                padding: 10px;
            }

            .dosen-modal-body {
                max-height: 70vh;
            }

            .dosen-section-title {
                font-size: 15px;
            }
        }

        @media (max-width: 576px) {

            /* Very small screens */
            .fik-db-side-menu {
                width: 85%;
                max-width: 280px;
            }

            .main-content.shifted {
                margin-left: 85%;
                max-width: calc(100% - 85%);
            }

            #tabelSurat th:nth-child(5),
            #tabelSurat td:nth-child(5) {
                width: 25%;
                min-width: 100px;
            }

            #tabelSurat th:nth-child(6),
            #tabelSurat td:nth-child(6) {
                width: 18%;
                min-width: 90px;
            }

            #tabelSurat th:nth-child(7),
            #tabelSurat td:nth-child(7) {
                width: 15%;
                min-width: 80px;
            }

            .action-buttons-container {
                flex-direction: row;
                gap: 3px;
            }

            .menu-text {
                font-size: 13px;
            }

            .fik-db-side-menu .btn {
                padding: 14px 16px;
                font-size: 13px;
            }

            .fik-db-side-menu .collapse ul li a {
                padding-left: 50px;
                font-size: 11px;
            }

            /* Dosen container untuk mobile sangat kecil */
            .dosen-container {
                flex-direction: column;
                align-items: center;
                gap: 3px;
            }

            .nama-dosen-badge {
                max-width: 100px;
                font-size: 9px;
            }
        }

        /* Desktop: ensure sidebar is always visible */
        @media (min-width: 993px) {
            .fik-db-side-menu {
                transform: translateX(0) !important;
                display: block !important;
            }

            .sidebar-overlay {
                display: none !important;
            }

            .main-content {
                margin-left: 260px;
                width: calc(100% - 260px);
            }
        }

        /* Style untuk tombol dalam modal dosen */
        .dosen-modal-footer .btn-add-surat {
            padding: 8px 16px;
            font-size: 14px;
            margin-right: 8px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .dosen-modal-footer .btn-back {
            padding: 8px 16px;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* Hover effect untuk tombol modal */
        .dosen-modal-footer .btn-add-surat:hover {
            transform: translateY(-2px);
        }

        .dosen-modal-footer .btn-back:hover {
            transform: translateY(-2px);
        }

        /* ===== MODAL CUSTOM STYLES ===== */
        .custom-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 10020;
            justify-content: center;
            align-items: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .custom-modal.show {
            display: flex;
            animation: fadeIn 0.3s ease;
        }

        .custom-modal-content {
            background: white;
            border-radius: 16px;
            width: 90%;
            max-width: 500px;
            max-height: 80vh;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .custom-modal-header {
            background: linear-gradient(135deg, #FB8C00 0%, #FF9800 100%);
            color: white;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .custom-modal-title {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .custom-modal-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .custom-modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .custom-modal-body {
            padding: 25px;
            overflow-y: auto;
            max-height: 50vh;
        }

        .custom-modal-footer {
            padding: 15px 25px;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Form elements */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: #FB8C00;
            outline: none;
        }

        .text-muted {
            color: #6c757d !important;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        /* Buttons in modal */
        .btn-submit {
            background: #FB8C00;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-submit:hover {
            background: #e67e00;
            transform: translateY(-2px);
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-cancel:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-delete:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        /* List group for deletion */
        .list-group {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            overflow: hidden;
        }

        .list-group-item {
            padding: 12px 15px;
            border-bottom: 1px solid #e9ecef;
            cursor: pointer;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }

        .list-group-item.selected {
            background-color: #fff3e0;
            border-left: 4px solid #FB8C00;
        }

        .list-group-item input[type="radio"] {
            margin-right: 10px;
        }

        .list-group-item .dosen-info {
            flex: 1;
        }

        .list-group-item .dosen-name {
            font-weight: 600;
            color: #333;
        }

        .list-group-item .dosen-nip {
            font-size: 12px;
            color: #6c757d;
        }

        /* Search results */
        .search-result {
            padding: 10px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-top: 10px;
            background: #f8f9fa;
        }

        .search-result .found {
            color: #28a745;
            font-weight: 600;
        }

        .search-result .not-found {
            color: #dc3545;
            font-weight: 600;
        }

        /* Style untuk radio button yang bisa diklik */
        .radio-option {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.2s;
            background: white;
        }

        .radio-option:hover {
            background: #f8f9fa;
            border-color: #FB8C00;
        }

        .radio-option.selected {
            background: #fff3e0;
            border-color: #FB8C00;
            border-left: 4px solid #FB8C00;
        }

        .radio-option input[type="radio"] {
            margin-right: 12px;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .radio-option label {
            flex: 1;
            margin: 0;
            cursor: pointer;
            font-weight: 500;
        }

        .dosen-detail-small {
            font-size: 12px;
            color: #6c757d;
            margin-top: 3px;
        }

        .no-dosen-message {
            text-align: center;
            padding: 30px;
            color: #6c757d;
        }

        .no-dosen-message i {
            font-size: 48px;
            margin-bottom: 10px;
            color: #adb5bd;
        }

        .no-dosen-message p {
            margin: 5px 0;
        }

        /* ===== MULTIPLE DOSEN STYLES ===== */
        .selected-dosen-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: all 0.2s;
        }

        .selected-dosen-item:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
            border-color: #FB8C00;
        }

        /* Autocomplete styles */
        .autocomplete-item {
            padding: 10px 15px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s;
        }

        .autocomplete-item:hover {
            background-color: #f8f9fa;
        }

        .autocomplete-item:last-child {
            border-bottom: none;
        }

        .autocomplete-item.selected {
            background-color: #e8f4ff;
            border-left: 3px solid #FB8C00;
        }

        /* Badge styles */
        .badge-primary {
            background: #FB8C00;
            color: white;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Button states */
        .btn-submit:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Progress bar in modal */
        #progressBar {
            transition: width 0.3s ease;
        }

        /* Alert customization */
        .alert {
            border-radius: 8px;
            border: none;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border-left: 4px solid #ffc107;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }

        /* Scrollbar customization */
        #selectedDosenList::-webkit-scrollbar {
            width: 6px;
        }

        #selectedDosenList::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        #selectedDosenList::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 3px;
        }

        #selectedDosenList::-webkit-scrollbar-thumb:hover {
            background: #aaa;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .selected-dosen-item {
                padding: 10px;
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .selected-dosen-item>div:first-child {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }
        }

        /* ===== STYLES UNTUK MODAL KURANGI DOSEN (DENGAN MULTI HAPUS) ===== */
        .dosen-item-hapus {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 10px;
            background: white;
            transition: all 0.2s;
        }

        .dosen-item-hapus:hover {
            border-color: #FB8C00;
            background: #fffaf5;
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .dosen-item-hapus.selected {
            background: #fff3e0;
            border-color: #FB8C00;
            border-left: 4px solid #FB8C00;
        }

        .dosen-avatar-hapus {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FB8C00 0%, #FF9800 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 16px;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .dosen-info-hapus {
            flex: 1;
        }

        .dosen-nama-hapus {
            font-weight: 600;
            color: #212529;
            margin-bottom: 4px;
            font-size: 14px;
        }

        .dosen-detail-hapus {
            font-size: 12px;
            color: #6c757d;
        }

        .checkbox-hapus {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #dc3545;
            margin-right: 10px;
        }

        /* ===== STYLE UNTUK MULTI HAPUS HEADER ===== */
        .multi-hapus-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .multi-hapus-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .multi-hapus-count {
            background: #dc3545;
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .btn-select-all {
            background: #FB8C00;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-select-all:hover {
            background: #e67e00;
            transform: translateY(-1px);
        }

        /* ===== PERBAIKAN: Modal Konfirmasi Penghapusan (MULTI) ===== */
        .konfirmasi-hapus-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 10030;
            justify-content: center;
            align-items: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .konfirmasi-hapus-modal.show {
            display: flex;
            animation: fadeIn 0.3s ease;
        }

        .konfirmasi-hapus-content {
            background: white;
            border-radius: 16px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            z-index: 10031;
        }

        .konfirmasi-hapus-header {
            background: #dc3545;
            color: white;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .konfirmasi-hapus-title {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .konfirmasi-hapus-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .konfirmasi-hapus-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .konfirmasi-hapus-body {
            padding: 25px;
            overflow-y: auto;
            max-height: 50vh;
        }

        .konfirmasi-hapus-footer {
            padding: 15px 25px;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .info-dosen-hapus {
            background: #fff3e0;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 4px solid #FB8C00;
        }

        .info-dosen-hapus strong {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
            color: #212529;
        }

        .info-dosen-hapus div {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        /* ===== STYLE UNTUK DAFTAR MULTI HAPUS ===== */
        .dosen-list-hapus {
            max-height: 300px;
            overflow-y: auto;
            margin: 10px 0;
        }

        .dosen-hapus-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #eee;
            background: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .dosen-hapus-item:last-child {
            border-bottom: none;
        }

        .dosen-hapus-initial {
            width: 30px;
            height: 30px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .dosen-hapus-info {
            flex: 1;
        }

        .dosen-hapus-nama {
            font-weight: 600;
            font-size: 14px;
            color: #333;
        }

        .dosen-hapus-nip {
            font-size: 12px;
            color: #666;
        }
        /* ===== MODAL STYLES UNTUK SUCCESS ===== */
.modal {
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
    padding: 20px;
}

.modal.show {
    display: flex;
}

.bulk-modal-content {
    background: white;
    border-radius: 15px;
    max-width: 600px;
    width: 95%;
    max-height: 85vh;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from { transform: translateY(-50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.modal-header {
    background: #27ae60;
    color: white;
    padding: 20px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 15px 15px 0 0;
}

.modal-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
}

.close-modal {
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

.close-modal:hover {
    background: rgba(255,255,255,0.2);
}

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

.badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 999px;
    font-weight: 600;
    font-size: 11px;
}

.badge-success {
    background: #d4edda;
    color: #155724;
}

.badge-warning {
    background: #fff3cd;
    color: #856404;
}

.badge-info {
    background: #d1ecf1;
    color: #0c5460;
}
/* ===== STYLE UNTUK SUCCESS MODAL DOSEN ===== */
.dosen-success-section {
    background: #f5eef8;
    border: 1px solid #d7bde2;
    border-radius: 10px;
    padding: 15px;
    margin: 15px 0;
    transition: all 0.3s ease;
}

.dosen-success-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px;
    background: white;
    border: 1px solid #e8daef;
    border-radius: 8px;
    margin-bottom: 8px;
    transition: all 0.2s ease;
    cursor: default;
}

.dosen-success-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    border-color: #16A085;
}

.dosen-success-item-hidden {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px;
    background: white;
    border: 1px solid #e8daef;
    border-radius: 8px;
    margin-bottom: 8px;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Styling untuk modal success */
#editList {
    max-height: 400px;
    overflow-y: auto;
    padding-right: 5px;
}

#editList::-webkit-scrollbar {
    width: 6px;
}

#editList::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

#editList::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 3px;
}

#editList::-webkit-scrollbar-thumb:hover {
    background: #aaa;
}
/* Styling untuk perubahan */
.change-item {
    border-left: 3px solid #ff9800;
    padding: 10px;
    margin-bottom: 8px;
    background: #fff;
    border-radius: 0 6px 6px 0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.change-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
}

.change-icon {
    width: 24px;
    height: 24px;
    background: #ff9800;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

.change-title {
    font-weight: 600;
    color: #333;
    font-size: 13px;
}

.change-values {
    display: flex;
    gap: 10px;
    margin-top: 5px;
}

.old-value {
    flex: 1;
    background: #fff3cd;
    padding: 6px 8px;
    border-radius: 4px;
}

.new-value {
    flex: 1;
    background: #d4edda;
    padding: 6px 8px;
    border-radius: 4px;
}

.value-label {
    color: #856404;
    font-weight: 600;
    font-size: 11px;
    margin-bottom: 2px;
}

.value-content {
    color: #333;
    font-size: 12px;
}

.change-timestamp {
    font-size: 11px;
    color: #6c757d;
    margin-top: 5px;
    text-align: right;
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
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        <div id="accordion">
            <!-- Profile Section (mobile only) -->
            <div class="card show-mobile profil">
                <div class="img-wrapper">
                    <img src="https://ifik.telkomuniversity.ac.id/assets/img/profile/default.jpg" alt="Profile">
                </div>
                <b>PIC MEDCRAFT</b>
                <span>pic kk</span>
            </div>
            <div class="divider show-mobile" style="margin-top:20px"></div>

            <!-- Menu Items -->
            <div class="card">
                <a href="<?= base_url('list-surat-tugas') ?>" class="btn active">
                    <span class="fas fa-palette"></span>
                    <span class="menu-text">List Pengajuan</span>
                </a>
            </div>

            <div class="card">
                <a href="https://ifik.telkomuniversity.ac.id/Pic_kk/input_surat" class="btn">
                    <span class="fas fa-envelope-open-text"></span>
                    <span class="menu-text">Surat Tugas</span>
                </a>
            </div>

            <div class="divider"></div>

            <!-- Peminjaman Ruangan (Collapsible) -->
            <div class="card">
                <a href="#" class="btn collapsed" data-bs-toggle="collapse" data-bs-target="#collapse2"
                    aria-expanded="false" aria-controls="collapse2">
                    <span class="fas fa-door-open"></span>
                    <span class="menu-text">Peminjaman Ruangan</span>
                    <span class="collapse-arrow fas fa-chevron-down"></span>
                </a>
                <div id="collapse2" class="collapse" data-bs-parent="#accordion">
                    <ul>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#termcondition">Buat Peminjaman</a></li>
                        <li><a href="https://ifik.telkomuniversity.ac.id/users/daftarsemuatempat">Daftar Ruangan</a></li>
                        <li><a href="https://ifik.telkomuniversity.ac.id/Pic_kk/riwayat">Riwayat</a></li>
                    </ul>
                </div>
            </div>

            <!-- Ticketing (Collapsible) -->
            <div class="card">
                <a href="#" class="btn collapsed" data-bs-toggle="collapse" data-bs-target="#ticketing"
                    aria-expanded="false" aria-controls="ticketing">
                    <span class="fas fa-door-open"></span>
                    <span class="menu-text">Ticketing</span>
                    <span class="collapse-arrow fas fa-chevron-down"></span>
                </a>
                <div id="ticketing" class="collapse" data-bs-parent="#accordion">
                    <ul>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#maketicketing">Input ticketing</a></li>
                        <li><a href="https://ifik.telkomuniversity.ac.id/users/daftarsemuatempat">Daftar Ruangan</a></li>
                        <li><a href="https://ifik.telkomuniversity.ac.id/pic_kk/riwayat_ticketing">Riwayat</a></li>
                    </ul>
                </div>
            </div>

            <!-- Helpdesk (mobile only) -->
            <div class="card show-mobile">
                <a href="https://ifik.telkomuniversity.ac.id/main/helpdesk" class="btn">
                    <span class="fas fa-life-ring"></span>
                    <span class="menu-text">Helpdesk</span>
                </a>
            </div>

            <!-- Logout -->
            <div class="card logout">
                <button class="btn" data-bs-toggle="modal" data-bs-target="#logout">
                    <span class="fas fa-sign-out-alt"></span>
                    <span class="menu-text">Logout</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 5px solid #28a745;">
                <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 5px solid #dc3545;">
                <i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- REVISI: Header Actions dengan layout baru -->
        <div class="header-actions">
            <h1 class="page-title">List Pengajuan</h1>
            <div class="action-buttons-group">
                <!-- REVISI: Tombol Tambah Surat - lebih mencolok -->
                <a href="<?= site_url('surat/') ?>" class="btn-add-surat">
                    <i class="fas fa-plus-circle"></i> Tambah Surat Tugas
                </a>

                <!-- REVISI: Tombol Kembali di pojok kanan -->
                <button class="btn-back" onclick="goBack()">
                    <i class="fas fa-arrow-left"></i> Kembali
                </button>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar">
            <div class="filter-actions">
                <select id="filterCategory" class="btn-small">
                    <option value="jenis" selected>Jenis Pengajuan</option>
                    <option value="dosen">Nama Dosen</option>
                    <option value="status">Status</option>
                    <option value="tanggal">Tanggal Kegiatan</option>
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

        <!-- ===== REVISI: Modal Popup Detail Dosen - NEW STYLE WITH BUTTONS ===== -->
        <div id="dosenModal" class="dosen-modal">
            <div class="dosen-modal-content">
                <div class="dosen-modal-header">
                    <h3 class="dosen-modal-title">
                        <i class="fas fa-user-graduate"></i>
                        <span id="dosenModalTitle">Detail Dosen</span>
                    </h3>
                    <button class="dosen-modal-close" id="closeDosenModal">&times;</button>
                </div>
                <div class="dosen-modal-body">
                    <div class="dosen-section">
                        <div class="dosen-section-title">
                            <i class="fas fa-users"></i>
                            <span id="kegiatanTitle"></span>
                        </div>
                        <div id="dosenListContainer">
                            <!-- Dosen list akan diisi oleh JavaScript -->
                        </div>
                    </div>
                </div>
                <div class="dosen-modal-footer">
                    <div class="dosen-total">
                        Total: <strong id="dosenTotalCount">0</strong> Dosen
                    </div>
                    <div id="dosenActionButtons" style="display: none; margin-top: 10px; gap: 10px;">
                        <button id="btnTambahDosen" class="btn-add-surat"
                            style="padding: 8px 16px; font-size: 14px;">
                            <i class="fas fa-plus"></i> Tambah Dosen
                        </button>
                        <button id="btnKurangDosen" class="btn-back"
                            style="padding: 8px 16px; font-size: 14px;">
                            <i class="fas fa-minus"></i> Kurangi Dosen
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== MODAL TAMBAH DOSEN MULTIPLE ===== -->
        <div id="modalTambahDosen" class="custom-modal">
            <div class="custom-modal-content" style="max-width: 700px;">
                <div class="custom-modal-header">
                    <h3 class="custom-modal-title">
                        <i class="fas fa-user-plus"></i>
                        Tambah Dosen
                    </h3>
                    <button class="custom-modal-close" id="closeTambahModal">&times;</button>
                </div>
                <div class="custom-modal-body">
                    <!-- PENCARIAN DOSEN -->
                    <div class="form-group">
                        <label for="inputNipTambah">
                            <i class="fas fa-search"></i> Cari Dosen
                        </label>
                        <div style="position: relative;">
                            <input type="text" id="inputNipTambah" class="form-control"
                                placeholder="Masukkan NIP atau nama dosen" 
                                autocomplete="off"
                                data-autocomplete-url="<?= site_url('surat/autocomplete_dosen') ?>">
                            <div id="autocompleteResults" 
                                style="display: none; 
                                    position: absolute; 
                                    top: 100%; 
                                    left: 0; 
                                    right: 0; 
                                    background: white; 
                                    border: 1px solid #ddd; 
                                    border-radius: 8px; 
                                    max-height: 200px; 
                                    overflow-y: auto; 
                                    z-index: 1000; 
                                    box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                <!-- Hasil autocomplete akan muncul di sini -->
                            </div>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> 
                            Mulai ketik NIP atau nama dosen. Pilih dosen untuk ditambahkan ke daftar.
                        </small>
                    </div>

                    <!-- DAFTAR DOSEN YANG AKAN DITAMBAHKAN -->
                    <div class="form-group">
                        <label>
                            <i class="fas fa-list"></i> Daftar Dosen yang Akan Ditambahkan
                            <span id="selectedCount" class="badge badge-primary" style="margin-left: 10px;">0</span>
                        </label>
                        
                        <div id="selectedDosenList" style="
                            max-height: 250px;
                            overflow-y: auto;
                            border: 1px solid #dee2e6;
                            border-radius: 8px;
                            padding: 10px;
                            margin-top: 10px;
                            background: #f8f9fa;
                        ">
                            <!-- Dosen yang dipilih akan muncul di sini -->
                            <div id="emptySelectionMessage" style="
                                text-align: center;
                                padding: 30px;
                                color: #6c757d;
                            ">
                                <i class="fas fa-user-plus" style="font-size: 48px; margin-bottom: 10px;"></i>
                                <p>Belum ada dosen yang dipilih.</p>
                                <small>Pilih dosen dari kolom pencarian di atas.</small>
                            </div>
                        </div>
                        
                        <small class="text-muted" style="display: block; margin-top: 8px;">
                            <i class="fas fa-exclamation-circle"></i> 
                            Maksimal 10 dosen dapat ditambahkan dalam satu kali proses.
                        </small>
                    </div>

                    <!-- INFO PENGAJUAN -->
                    <div class="alert alert-info" style="margin: 15px 0;">
                        <i class="fas fa-info-circle"></i>
                        <strong>Informasi:</strong> Anda akan menambahkan dosen ke pengajuan: 
                        <strong id="currentPengajuanName">-</strong>
                        <br>
                        <small>
                            Saat ini ada <strong id="currentDosenCount">0</strong> dosen dalam pengajuan ini.
                        </small>
                    </div>

                    <div id="hasilPencarian" style="margin-top: 15px;"></div>
                </div>
                <div class="custom-modal-footer" style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <button class="btn-cancel" onclick="hapusSemuaDosen()" id="btnClearAll" style="display: none;">
                            <i class="fas fa-trash"></i> Hapus Semua
                        </button>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button class="btn-cancel" onclick="tutupModalTambah()">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button class="btn-submit" onclick="prosesTambahMultipleDosen()" id="btnTambahSubmit" disabled>
                            <i class="fas fa-plus"></i> Tambah <span id="tambahCount">0</span> Dosen
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== MODAL KURANG DOSEN - DENGAN FITUR MULTI HAPUS ===== -->
        <div id="modalKurangDosen" class="custom-modal">
            <div class="custom-modal-content" style="max-width: 700px;">
                <div class="custom-modal-header">
                    <h3 class="custom-modal-title">
                        <i class="fas fa-user-minus"></i>
                        Kurangi Dosen - Pilih Multiple
                    </h3>
                    <button class="custom-modal-close" id="closeKurangModal">&times;</button>
                </div>
                <div class="custom-modal-body">
                    <div class="alert alert-info" style="margin-bottom: 15px;">
                        <i class="fas fa-info-circle"></i>
                        <strong>Informasi:</strong> Pilih satu atau lebih dosen yang akan dihapus dari daftar.
                        <div style="margin-top: 5px; font-size: 13px;">
                            Minimal harus ada 1 dosen tersisa dalam pengajuan. Dosen pertama tidak dapat dihapus.
                        </div>
                    </div>
                    
                    <!-- HEADER MULTI HAPUS -->
                    <div id="multiHapusHeader" class="multi-hapus-header" style="display: none;">
                        <div class="multi-hapus-info">
                            <span id="selectedHapusCount">0</span> dosen terpilih
                            <span class="multi-hapus-count" id="multiHapusCount">0</span>
                        </div>
                        <button class="btn-select-all" onclick="toggleSelectAllDosen()">
                            <i class="fas fa-check-square"></i> Pilih Semua
                        </button>
                    </div>
                    
                    <!-- DAFTAR DOSEN YANG DAPAT DIHAPUS -->
                    <div id="listDosenHapus" style="max-height: 350px; overflow-y: auto;">
                        <!-- Daftar dosen akan diisi oleh JavaScript -->
                    </div>
                    
                    <div id="pesanDosenKosong" class="empty-dosen-message" style="display: none;">
                        <i class="fas fa-user-slash"></i>
                        <p>Tidak ada dosen yang dapat dihapus.</p>
                        <small>Minimal harus ada 1 dosen tersisa dalam pengajuan.</small>
                    </div>
                </div>
                <div class="custom-modal-footer">
                    <button class="btn-cancel" onclick="tutupModalKurang()">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button class="btn-delete" onclick="showKonfirmasiHapusMultiModal()" id="btnHapusDosen" disabled>
                        <i class="fas fa-trash"></i> Hapus Dosen Terpilih (<span id="countHapus">0</span>)
                    </button>
                </div>
            </div>
        </div>

        <!-- ===== MODAL KONFIRMASI PENGHAPUSAN MULTI ===== -->
        <div id="konfirmasiHapusModal" class="konfirmasi-hapus-modal">
            <div class="konfirmasi-hapus-content">
                <div class="konfirmasi-hapus-header">
                    <h3 class="konfirmasi-hapus-title">
                        <i class="fas fa-exclamation-triangle"></i>
                        Konfirmasi Penghapusan Multiple
                    </h3>
                    <button class="konfirmasi-hapus-close" onclick="tutupKonfirmasiHapus()">&times;</button>
                </div>
                <div class="konfirmasi-hapus-body">
                    <div id="singleHapusInfo" style="display: none;">
                        <p>Anda akan menghapus dosen berikut:</p>
                        <div id="dosenHapusInfo" class="info-dosen-hapus">
                            <!-- Informasi dosen tunggal akan diisi oleh JavaScript -->
                        </div>
                    </div>
                    
                    <div id="multiHapusInfo" style="display: none;">
                        <p>Anda akan menghapus <strong id="jumlahDosenHapus">0</strong> dosen berikut:</p>
                        <div class="dosen-list-hapus" id="listDosenKonfirmasi">
                            <!-- Daftar dosen multiple akan diisi oleh JavaScript -->
                        </div>
                    </div>
                    
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <strong>Peringatan:</strong> Aksi ini tidak dapat dibatalkan.
                    </div>
                </div>
                <div class="konfirmasi-hapus-footer">
                    <button class="btn-cancel" onclick="tutupKonfirmasiHapus()">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button class="btn-delete" onclick="prosesHapusDosenMulti()" id="btnKonfirmasiHapus">
                        <i class="fas fa-trash"></i> Ya, Hapus Sekarang
                    </button>
                </div>
            </div>
        </div>
<!-- ===== SUCCESS MODAL UNTUK EDIT SURAT - WITH CHANGES DETAIL ===== -->
<div id="successEditModal" class="modal">
    <div class="bulk-modal-content" onclick="event.stopPropagation()" style="max-width: 900px; height: 85vh; display: flex; flex-direction: column;">
        <div class="modal-header" style="background: #ff9800; flex-shrink: 0;">
            <h3><i class="fa-solid fa-pen-to-square"></i> Edit Berhasil Disimpan</h3>
            <button class="close-modal" onclick="closeModal('successEditModal')">&times;</button>
        </div>
        
        <!-- Scrollable Content Area -->
        <div style="flex: 1; overflow-y: auto; padding: 25px;">
            <div style="display:flex;align-items:center;gap:20px;margin-bottom:20px; flex-shrink: 0;">
                <div style="width:80px;height:80px;border-radius:50%;background:#fff3e0;flex-shrink:0;display:flex;align-items:center;justify-content:center">
                    <i class="fas fa-check" style="font-size:40px;color:#ff9800"></i>
                </div>
                <div style="text-align:left;flex:1">
                    <h3 style="color:#ff9800;margin-bottom:8px;font-size:22px">Berhasil Diperbarui</h3>
                    <p style="color:#666;margin-bottom:5px;font-size:14px">
                        <i class="fa-solid fa-clock"></i> Diperbarui pada: <strong id="editTimestamp">-</strong>
                    </p>
                    <p style="color:#666;font-size:13px">
                        <i class="fa-solid fa-edit"></i> <span id="editChangesCount">0</span> perubahan berhasil disimpan
                    </p>
                </div>
            </div>
            
            <!-- Data Pengajuan Section -->
            <div style="background:#fff3e0;border:1px solid #ffcc80;border-radius:8px;padding:15px;margin-bottom:15px; flex-shrink: 0;">
                <div style="font-weight:600;color:#e65100;margin-bottom:12px;display:flex;align-items:center;justify-content:space-between">
                    <span><i class="fa-solid fa-file-alt"></i> Informasi Pengajuan</span>
                    <span id="editItemCount" style="background:#ff9800;color:white;padding:4px 12px;border-radius:20px;font-size:12px">1 item</span>
                </div>
                <div id="editList" style="text-align:left; max-height: 200px; overflow-y: auto;">
                    <!-- List akan diisi oleh JavaScript -->
                </div>
            </div>
            
            <!-- Perubahan Detail Section -->
            <div id="editChangesSection" style="background:#f8f9fa;border:1px solid #dee2e6;border-radius:8px;padding:15px;margin-bottom:15px;display:none;">
                <div style="font-weight:600;color:#495057;margin-bottom:12px;display:flex;align-items:center;gap:8px; flex-shrink: 0;">
                    <i class="fa-solid fa-list-check" style="color:#ff9800"></i>
                    <span>Detail Perubahan</span>
                    <span id="editChangesBadge" style="background:#ff9800;color:white;padding:2px 8px;border-radius:10px;font-size:11px;font-weight:600">0 changes</span>
                </div>
                <div id="editChangesList" style="max-height: 400px; overflow-y: auto; padding-right: 5px;">
                    <!-- Changes akan diisi oleh JavaScript -->
                </div>
            </div>
        </div>
        
        <!-- Action Buttons (Fixed at bottom) -->
        <div style="background: #f8f9fa; border-top: 1px solid #dee2e6; padding: 15px 25px; flex-shrink: 0;">
            <div style="display:flex;gap:10px;justify-content:center">
                <button class="btn-bulk" onclick="closeModal('successEditModal')" style="background:#6c757d;color:white;padding:12px 28px;border:none;border-radius:6px;cursor:pointer;font-weight:600;display:flex;align-items:center;gap:8px;box-shadow:0 2px 4px rgba(0,0,0,0.1)">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

        <!-- Modal Detail -->
        <div id="modalDetail" class="modal-detail">
            <div class="modal-content-detail">
                <div class="modal-header-detail">
                    <span>Detail Surat Pengajuan</span>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body-detail">
                    <div id="detailContent">
                        <!-- Content akan diisi oleh JavaScript -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Modal - REVISED CLEAN DESIGN -->
        <div id="statusModal" class="status-modal">
            <div class="status-content">
                <div class="status-header">
                    <h3><i class="fas fa-tasks"></i> Status Pengajuan Surat Tugas</h3>
                    <button class="close-status">&times;</button>
                </div>
                <div class="status-body">
                    <div class="progress-container">
                        <div class="progress-track">
                            <div class="progress-line" id="progressLine"></div>

                            <!-- Step 1: Mengirim -->
                            <div class="progress-step completed" id="step1">
                                <div class="step-estimasi" id="est1">0 hari 0 jam</div>
                                <div class="step-icon-container">
                                    <div class="step-icon">
                                        <i class="fas fa-check" id="step1-icon"></i>
                                    </div>
                                </div>
                                <div class="step-text" id="step1-text">Mengirim</div>
                                <div class="step-date" id="step1-date">02 Dec 2025</div>
                            </div>

                            <!-- Step 2: Disetujui Kaprodi -->
                            <div class="progress-step completed" id="step2">
                                <div class="step-estimasi" id="est2">0 hari 1 jam</div>
                                <div class="step-icon-container">
                                    <div class="step-icon">
                                        <i class="fas fa-check" id="step2-icon"></i>
                                    </div>
                                </div>
                                <div class="step-text" id="step2-text">Disetujui Kaprodi</div>
                                <div class="step-date" id="step2-date">02 Dec 2025</div>
                            </div>

                            <!-- Step 3: Disetujui Sekretariat -->
                            <div class="progress-step completed" id="step3">
                                <div class="step-estimasi" id="est3">0 hari 0 jam</div>
                                <div class="step-icon-container">
                                    <div class="step-icon">
                                        <i class="fas fa-check" id="step3-icon"></i>
                                    </div>
                                </div>
                                <div class="step-text" id="step3-text">Disetujui Sekretariat</div>
                                <div class="step-date" id="step3-date">02 Dec 2025</div>
                            </div>

                            <!-- Step 4: Disetujui Dekan -->
                            <div class="progress-step completed" id="step4">
                                <div class="step-estimasi" id="est4">0 hari 0 jam</div>
                                <div class="step-icon-container">
                                    <div class="step-icon">
                                        <i class="fas fa-check" id="step4-icon"></i>
                                    </div>
                                </div>
                                <div class="step-text" id="step4-text">Disetujui Dekan</div>
                                <div class="step-date" id="step4-date">02 Dec 2025</div>
                            </div>
                        </div>
                    </div>

                    <div class="status-info">
                        <h5><i class="fas fa-info-circle"></i> Informasi Status:</h5>
                        <p id="status-description">Pengajuan ini sudah disetujui.</p>
                        <div id="rejection-reason" class="rejection-reason" style="display: none;">
                            <h6><i class="fas fa-times-circle"></i> Alasan Penolakan:</h6>
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
                    <!-- REVISI: Kolom Divisi diganti Status -->
                    <th>Status</th>
                    <!-- REVISI: Kolom Tanggal Pengajuan diganti Tanggal Kegiatan -->
                    <th>Tanggal Kegiatan</th>
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

                    // ===== PERBAIKAN UTAMA: Handle eviden data dengan benar =====
                    $eviden_data = [];
                    if (isset($detail['eviden'])) {
                        if (is_string($detail['eviden'])) {
                            // Coba decode JSON
                            $decoded = json_decode($detail['eviden'], true);
                            if (json_last_error() === JSON_ERROR_NONE && $decoded !== null) {
                                $eviden_data = $decoded;
                            } else {
                                // Jika bukan JSON, anggap sebagai string URL/file path
                                if (!empty($detail['eviden']) && $detail['eviden'] !== '-' && $detail['eviden'] !== '[]') {
                                    $eviden_data = [$detail['eviden']];
                                }
                            }
                        } else if (is_array($detail['eviden'])) {
                            $eviden_data = $detail['eviden'];
                        }
                    }
                    $detail['eviden'] = $eviden_data;

                    $data_detail_attr = htmlspecialchars(json_encode($detail, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8');

                    // REVISI: Tentukan class status berdasarkan nilai status
                    $status_class = 'status-proses';
                    $status_lower = strtolower($s->status);
                    if (strpos($status_lower, 'disetujui') !== false) {
                        $status_class = 'status-disetujui';
                    } elseif (strpos($status_lower, 'ditolak') !== false) {
                        $status_class = 'status-ditolak';
                    } elseif (strpos($status_lower, 'pending') !== false || strpos($status_lower, 'menunggu') !== false) {
                        $status_class = 'status-pending';
                    }
                ?>
                    <tr class="row-detail" data-detail='<?= $data_detail_attr; ?>' data-id="<?= $s->id; ?>">
                        <td><input type="checkbox" class="row-checkbox" data-id="<?= $s->id; ?>"></td>
                        <td><?= $no++; ?></td>
                        <td>
                            <?= htmlspecialchars($s->nama_kegiatan); ?>
                        </td>
                        <td><?= htmlspecialchars($s->jenis_pengajuan); ?></td>
                        <td>
                        <?php
                        $dosen_count = count($dosen_data);
                        if ($dosen_count > 0):
                            $nama = $dosen_data[0]['nama_dosen'] ?? '-';
                            $short = strlen($nama) > 30 ? substr($nama, 0, 30) . '...' : $nama;
                            
                            if ($dosen_count > 1):
                                // Jika lebih dari 1 dosen, tampilkan dengan modal
                                ?>
                                <div class="dosen-container clickable"
                                    onclick="showDosenModal(event, <?= htmlspecialchars(json_encode($dosen_data), ENT_QUOTES, 'UTF-8') ?>, 
                                '<?= htmlspecialchars($s->nama_kegiatan, ENT_QUOTES, 'UTF-8') ?>', 
                                '<?= $s->id ?>')">
                                    <span class="nama-dosen-badge" title="<?= htmlspecialchars($nama) ?> (Klik untuk lihat semua)"><?= htmlspecialchars($short) ?></span>
                                    <span class="nama-dosen-more" title="Klik untuk lihat semua dosen">+<?= $dosen_count - 1 ?> lainnya</span>
                                </div>
                            <?php else: ?>
                                <!-- Jika hanya 1 dosen, tampilkan tanpa modal -->
                                <div class="dosen-container" style="cursor: default;">
                                    <span class="nama-dosen-badge" title="<?= htmlspecialchars($nama) ?>"><?= htmlspecialchars($short) ?></span>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                        <!-- REVISI: Kolom Status -->
                        <td>
                            <span class="status-badge <?= $status_class ?>">
                                <?= htmlspecialchars($s->status); ?>
                            </span>
                        </td>
                        <!-- REVISI: Kolom Tanggal Kegiatan - Tampilkan Periode atau Tanggal -->
                        <td>
                            <?php
                            // LOGIKA BARU: Cek jenis_date terlebih dahulu
                            $jenis_date = isset($s->jenis_date) ? $s->jenis_date : '';
                            
                            if ($jenis_date === 'Periode') {
                                // Jika jenis_date adalah Periode, tampilkan periode_value
                                $periode_value = isset($s->periode_value) && !empty($s->periode_value) ? $s->periode_value : '-';
                                echo '<span class="badge" style="background: #e3f2fd; color: #1976d2; padding: 6px 12px; border-radius: 15px; font-size: 12px; font-weight: 600;">';
                                echo '<i class="fas fa-calendar-alt"></i> ' . htmlspecialchars($periode_value);
                                echo '</span>';
                                
                            } else {
                                // Jika jenis_date adalah Custom atau lainnya, tampilkan tanggal
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
                                
                                // Format tanggal ke "10 Desember 2025"
                                if (!empty($tanggal_kegiatan) && $tanggal_kegiatan !== '-') {
                                    try {
                                        // Coba parse tanggal
                                        $tanggal_obj = new DateTime($tanggal_kegiatan);
                                        $hari = $tanggal_obj->format('j'); // Tanggal tanpa leading zero
                                        $bulan = $tanggal_obj->format('n'); // Bulan dalam angka
                                        
                                        // Konversi angka bulan ke nama bulan Indonesia
                                        $bulan_indonesia = [
                                            1 => 'Januari',
                                            2 => 'Februari',
                                            3 => 'Maret',
                                            4 => 'April',
                                            5 => 'Mei',
                                            6 => 'Juni',
                                            7 => 'Juli',
                                            8 => 'Agustus',
                                            9 => 'September',
                                            10 => 'Oktober',
                                            11 => 'November',
                                            12 => 'Desember'
                                        ];
                                        
                                        $bulan_nama = $bulan_indonesia[$bulan] ?? 'Desember';
                                        $tahun = $tanggal_obj->format('Y');
                                        
                                        echo htmlspecialchars($hari . ' ' . $bulan_nama . ' ' . $tahun);
                                    } catch (Exception $e) {
                                        // Jika parsing gagal, tampilkan format asli
                                        echo htmlspecialchars($tanggal_kegiatan);
                                    }
                                } else {
                                    echo '-';
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <!-- REVISI: Button aksi dengan layout baru -->
                            <div class="action-buttons-container">
                                <?php
                                // Cek apakah status ditolak
                                $status_lower = strtolower($s->status);
                                $is_rejected = in_array($status_lower, ['ditolak kk', 'ditolak sekretariat', 'ditolak dekan']);
                                $is_approved_dekan = ($s->status === 'disetujui dekan');
                                ?>

                                <!-- Tombol Status -->
                                <button class="btn-icon-action btn-status" title="Lihat Status" onclick="showStatusModal(<?= $s->id; ?>)">
                                    <i class="fas fa-tasks"></i>
                                </button>

                                <!-- Tombol Edit -->
                                <?php if ($is_rejected): ?>
                                    <a href="<?= site_url('surat/edit/' . $s->id); ?>"
                                        class="btn-icon-action btn-edit"
                                        title="Edit & Ajukan Ulang - Ditolak">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                <?php else: ?>
                                    <button class="btn-icon-action btn-edit btn-edit-disabled"
                                        title="Edit hanya untuk surat ditolak"
                                        onclick="showEditAlert('<?= $s->status ?>')"
                                        style="opacity: 0.5; cursor: not-allowed;">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                <?php endif; ?>

                                <!-- Tombol Print -->
                                <?php if ($is_approved_dekan && !empty($s->nomor_surat) && $s->nomor_surat !== '-' && $s->nomor_surat !== 'null'): ?>
                                    <a href="<?= base_url('sekretariat/cetak/' . $s->id)?>"
                                        target="_blank"
                                        class="btn-icon-action btn-print"
                                        title="Cetak Surat Tugas">
                                        <i class="fas fa-print"></i>
                                    </a>
                                <?php else: ?>
                                    <button class="btn-icon-action btn-print btn-print-disabled"
                                        title="Cetak hanya untuk surat disetujui dekan"
                                        onclick="showPrintAlert('<?= $s->status ?>')"
                                        style="opacity: 0.5; cursor: not-allowed;">
                                        <i class="fas fa-print"></i>
                                    </button>
                                <?php endif; ?>
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
// ===== REVISI COMPLETE JAVASCRIPT DENGAN PERBAIKAN SEARCH SEMUA DOSEN =====

// Variabel global
let currentSuratId = null;
let currentDosenList = [];
let selectedDosenList = [];
let currentPengajuanName = '';
let currentDosenCount = 0;
let selectedDosenToDelete = [];
let baseUrl = '<?= site_url() ?>';
let table; // Variabel untuk menyimpan instance DataTable

// Fungsi untuk format tanggal Indonesia
function formatTanggalIndonesia(dateString) {
    if (!dateString || dateString === '-') return '-';
    
    try {
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return dateString;
        
        const hari = date.getDate();
        const bulan = date.getMonth() + 1;
        const tahun = date.getFullYear();
        
        const namaBulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        
        return `${hari} ${namaBulan[bulan - 1]} ${tahun}`;
    } catch (e) {
        return dateString;
    }
}

// ============================================
// SUCCESS MODAL FUNCTIONS - UNTUK EDIT SURAT DENGAN PERUBAHAN
// ============================================
function showSuccessEditModal(count, items, isSingle = false) {
    const modal = document.getElementById('successEditModal');
    const timestamp = document.getElementById('editTimestamp');
    const itemCount = document.getElementById('editItemCount');
    const listContainer = document.getElementById('editList');
    const changesList = document.getElementById('editChangesList');
    const changesCount = document.getElementById('editChangesCount');
    const changesSection = document.getElementById('editChangesSection');
    
    // Format timestamp
    const now = new Date();
    timestamp.textContent = now.toLocaleDateString('id-ID', { 
        day: '2-digit', 
        month: 'long', 
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }) + ' WIB';
    
    itemCount.textContent = `${count} item`;
    
    // Populate list dengan data
    listContainer.innerHTML = '';
    
    // Populate changes list
    changesList.innerHTML = '';
    let totalChanges = 0;
    
    items.forEach((item, index) => {
        const itemDiv = document.createElement('div');
        itemDiv.style.cssText = 'background:white;border:1px solid #ffcc80;border-radius:10px;margin-bottom:12px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.05)';
        
        // Status baru setelah di-edit
        const newStatus = item.new_status || 'pengajuan';
        const oldStatus = item.old_status || '-';
        let statusColor = '#ff9800';
        let statusText = newStatus;
        
        // Format status text
        if (newStatus.includes('disetujui')) {
            statusColor = '#4CAF50';
            statusText = 'Disetujui';
        } else if (newStatus.includes('ditolak')) {
            statusColor = '#F44336';
            statusText = 'Ditolak';
        }
        
        // Generate HTML untuk dosen jika ada data
        const dosenHtml = generateDosenHtmlForSuccessModal(item.dosen_data || []);
        
        itemDiv.innerHTML = `
            <div style="display:flex;align-items:center;gap:12px;padding:15px;border-bottom:1px solid #f0f0f0;background:#fff9e6;">
                <div style="width:40px;height:40px;border-radius:50%;background:#ff9800;color:white;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">
                    <i class="fas fa-pen-to-square"></i>
                </div>
                <div style="flex:1;text-align:left">
                    <div style="font-weight:700;color:#212529;font-size:15px;margin-bottom:3px">${escapeHtml(item.nama)}</div>
                    <div style="font-size:13px;color:#6c757d">${item.details}</div>
                </div>
                <span style="background:${statusColor};color:white;padding:6px 14px;border-radius:20px;font-size:12px;font-weight:600;flex-shrink:0">
                    ${statusText}
                </span>
            </div>
            ${dosenHtml}
        `;
        listContainer.appendChild(itemDiv);
        
        if (item.changes && Array.isArray(item.changes) && item.changes.length > 0) {
            totalChanges += item.changes.length;
            
            // Buat section untuk perubahan item ini
            const changesItemDiv = document.createElement('div');
            changesItemDiv.style.cssText = 'margin-bottom:15px;padding:15px;background:#fff;border:1px solid #e0e0e0;border-radius:8px; flex-shrink: 0;';
            
            // Header untuk perubahan item
            const changesHeader = document.createElement('div');
            changesHeader.style.cssText = 'font-weight:600;color:#ff9800;margin-bottom:10px;display:flex;align-items:center;gap:8px;';
            changesHeader.innerHTML = `<i class="fas fa-sync-alt"></i> ${escapeHtml(item.nama)} - ${item.changes.length} perubahan`;
            changesItemDiv.appendChild(changesHeader);
            
            // Tampilkan setiap perubahan
            item.changes.forEach((change, changeIndex) => {
                const changeDiv = document.createElement('div');
                changeDiv.style.cssText = 'display:flex;align-items:flex-start;gap:10px;padding:10px;background:#f8f9fa;border-radius:6px;margin-bottom:8px;border-left:3px solid #ff9800; flex-shrink: 0;';
                
                // Icon berdasarkan tipe perubahan
                let changeIcon = 'fas fa-edit';
                let changeColor = '#ff9800';
                
                if (change.field === 'status') {
                    changeIcon = 'fas fa-exchange-alt';
                    changeColor = '#2196F3';
                } else if (change.field === 'dosen' || change.field_label.includes('Jabatan') || change.field_label.includes('Peran')) {
                    changeIcon = 'fas fa-user-edit';
                    changeColor = '#4CAF50';
                } else if (change.field === 'eviden') {
                    changeIcon = 'fas fa-file-edit';
                    changeColor = '#9C27B0';
                }
                
                changeDiv.innerHTML = `
                    <div style="width:24px;height:24px;background:${changeColor};color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0;margin-top:2px">
                        <i class="${changeIcon}"></i>
                    </div>
                    <div style="flex:1;min-width:0">
                        <div style="font-weight:600;color:#333;font-size:13px;margin-bottom:5px">${escapeHtml(change.field_label)}</div>
                        <div style="display:flex;gap:10px;font-size:12px;flex-wrap:wrap;">
                            <div style="flex:1;min-width:250px;background:#fff3cd;padding:6px 8px;border-radius:4px;">
                                <div style="color:#856404;font-weight:600;margin-bottom:2px;font-size:11px;">Nilai Lama:</div>
                                <div style="color:#333;word-break:break-word;max-height:100px;overflow-y:auto;padding-right:5px;">${escapeHtml(change.old_value)}</div>
                            </div>
                            <div style="flex:1;min-width:250px;background:#d4edda;padding:6px 8px;border-radius:4px;">
                                <div style="color:#155724;font-weight:600;margin-bottom:2px;font-size:11px;">Nilai Baru:</div>
                                <div style="color:#333;word-break:break-word;max-height:100px;overflow-y:auto;padding-right:5px;">${escapeHtml(change.new_value)}</div>
                            </div>
                        </div>
                        <div style="font-size:11px;color:#6c757d;margin-top:5px;text-align:right">
                            <i class="far fa-clock"></i> ${change.timestamp || 'Baru saja'}
                        </div>
                    </div>
                `;
                changesItemDiv.appendChild(changeDiv);
            });
            
            changesList.appendChild(changesItemDiv);
        }
    });
    
    // Update changes count
    if (changesCount) {
        changesCount.textContent = totalChanges;
    }
    
    // Tampilkan atau sembunyikan section perubahan
    if (changesSection) {
        if (totalChanges > 0) {
            changesSection.style.display = 'block';
        } else {
            changesSection.style.display = 'none';
        }
    }
    
    modal.classList.add('show');
}

// ===== PERBAIKAN FINAL: DOSEN MUNCUL LANGSUNG DI BAWAH - INTEGRATED LIST =====
function generateDosenHtmlForSuccessModal(dosenData) {
    if (!dosenData || !Array.isArray(dosenData) || dosenData.length === 0) {
        return '';
    }
    
    const maxVisible = 3;
    const isOverLimit = dosenData.length > maxVisible;
    const uniqueId = 'dosen-success-' + Date.now();
    
    let html = `
    <div class="dosen-success-section" style="background:#f5eef8;border:1px solid #d7bde2;border-radius:8px;padding:15px;margin:15px 0;">
        <div style="font-weight:600;color:#16A085;margin-bottom:15px;display:flex;align-items:center;justify-content:space-between">
            <span><i class="fas fa-users"></i> Dosen Terlibat</span>
            <span style="background:#16A085;color:white;padding:2px 10px;border-radius:15px;font-size:12px;font-weight:600">
                ${dosenData.length} Dosen
            </span>
        </div>
        
        <!-- Container untuk SEMUA dosen dalam satu list -->
        <div id="${uniqueId}-container" style="display:flex;flex-direction:column;gap:8px;">
    `;
    
    // Loop SEMUA dosen dan tampilkan dalam satu list
    dosenData.forEach((dosen, index) => {
        const nama = dosen.nama_dosen || dosen.nama || 'Tidak diketahui';
        const nip = dosen.nip || '-';
        const jabatan = dosen.jabatan || '-';
        const divisi = dosen.divisi || '-';
        const peran = dosen.peran || '-';
        const initial = nama.charAt(0).toUpperCase();
        
        // Tentukan apakah item ini hidden (index >= 3)
        const isHidden = index >= maxVisible;
        const displayStyle = isHidden ? 'none' : 'flex';
        const hiddenClass = isHidden ? 'dosen-item-hidden' : '';
        
        // Warna gradient berbeda untuk variasi visual
        const bgGradient = index % 2 === 0 
            ? 'linear-gradient(135deg, #16A085 0%, #1ABC9C 100%)' 
            : 'linear-gradient(135deg, #27AE60 0%, #2ECC71 100%)';
        
        html += `
        <div class="dosen-item ${hiddenClass}" 
             data-index="${index}"
             style="display:${displayStyle};align-items:center;gap:12px;padding:12px 15px;background:white;border:1px solid #e8daef;border-radius:8px;transition:all 0.3s ease;cursor:default;">
            
            <!-- Avatar dengan initial -->
            <div style="width:40px;height:40px;border-radius:50%;background:${bgGradient};color:white;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:16px;flex-shrink:0;box-shadow:0 2px 4px rgba(22,160,133,0.3)">
                ${initial}
            </div>
            
            <!-- Info dosen -->
            <div style="flex:1;min-width:0;">
                <div style="font-weight:600;color:#212529;font-size:14px;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                    ${escapeHtml(nama)}
                </div>
                <div style="font-size:12px;color:#6c757d;display:flex;flex-wrap:wrap;gap:8px;line-height:1.5;">
                    <span style="white-space:nowrap;display:inline-flex;align-items:center;gap:4px">
                        <i class="fas fa-id-card" style="font-size:11px"></i> 
                        <strong>NIP:</strong> ${escapeHtml(nip)}
                    </span>
                    ${jabatan !== '-' ? `
                    <span style="white-space:nowrap;display:inline-flex;align-items:center;gap:4px">
                        <i class="fas fa-briefcase" style="font-size:11px"></i> 
                        ${escapeHtml(jabatan)}
                    </span>` : ''}
                    ${divisi !== '-' ? `
                    <span style="white-space:nowrap;display:inline-flex;align-items:center;gap:4px">
                        <i class="fas fa-building" style="font-size:11px"></i> 
                        ${escapeHtml(divisi)}
                    </span>` : ''}
                </div>
                ${peran !== '-' && peran !== '' ? `
                <div style="margin-top:6px">
                    <span style="background:#ffeaa7;color:#2d3436;padding:3px 10px;border-radius:12px;font-size:11px;font-weight:600;white-space:nowrap;display:inline-flex;align-items:center;gap:4px">
                        <i class="fas fa-user-tag"></i> ${escapeHtml(peran)}
                    </span>
                </div>` : ''}
            </div>
        </div>
        `;
    });
    
    html += `</div>`; // Tutup container dosen
    
    // Jika ada dosen yang tersembunyi, tambahkan button toggle
    if (isOverLimit) {
        const hiddenCount = dosenData.length - maxVisible;
        
        html += `
        <button id="${uniqueId}-toggle-btn" 
                onclick="toggleDosenList('${uniqueId}', ${hiddenCount})" 
                data-expanded="false"
                style="background:#16A085;color:white;border:none;border-radius:6px;padding:10px 16px;font-size:13px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;width:100%;margin-top:12px;transition:all 0.2s;font-weight:500;box-shadow:0 2px 4px rgba(22,160,133,0.2)">
            <i class="fas fa-chevron-down" id="${uniqueId}-toggle-icon"></i>
            <span id="${uniqueId}-toggle-text">Tampilkan ${hiddenCount} Dosen Lainnya</span>
        </button>
        `;
    }
    
    html += `</div>`; // Tutup section
    
    return html;
}

// ===== FUNGSI TOGGLE DOSEN LIST - VERSI INTEGRATED =====
function toggleDosenList(uniqueId, hiddenCount) {
    const container = document.getElementById(uniqueId + '-container');
    const button = document.getElementById(uniqueId + '-toggle-btn');
    const icon = document.getElementById(uniqueId + '-toggle-icon');
    const text = document.getElementById(uniqueId + '-toggle-text');
    
    if (!container || !button) {
        console.error('Container atau button tidak ditemukan');
        return;
    }
    
    // Ambil semua item yang hidden
    const hiddenItems = container.querySelectorAll('.dosen-item-hidden');
    
    // Cek state saat ini
    const isExpanded = button.dataset.expanded === 'true';
    
    if (isExpanded) {
        // ===== COLLAPSE: Sembunyikan dosen tambahan =====
        hiddenItems.forEach((item, index) => {
            setTimeout(() => {
                // Fade out dengan smooth transition
                item.style.opacity = '0';
                item.style.transform = 'translateY(-10px)';
                
                // Setelah animasi selesai, hide element
                setTimeout(() => {
                    item.style.display = 'none';
                }, 200);
            }, index * 30); // Staggered animation
        });
        
        // Update button UI
        setTimeout(() => {
            if (icon) icon.className = 'fas fa-chevron-down';
            if (text) text.textContent = `Tampilkan ${hiddenCount} Dosen Lainnya`;
            button.dataset.expanded = 'false';
            button.style.background = '#16A085';
        }, 100);
        
    } else {
        // ===== EXPAND: Tampilkan dosen tambahan =====
        hiddenItems.forEach((item, index) => {
            setTimeout(() => {
                // Set initial state untuk animasi
                item.style.display = 'flex';
                item.style.opacity = '0';
                item.style.transform = 'translateY(-10px)';
                
                // Trigger reflow untuk smooth animation
                item.offsetHeight;
                
                // Animate in
                requestAnimationFrame(() => {
                    item.style.transition = 'all 0.3s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                });
            }, index * 50); // Staggered animation
        });
        
        // Update button UI
        setTimeout(() => {
            if (icon) icon.className = 'fas fa-chevron-up';
            if (text) text.textContent = 'Sembunyikan';
            button.dataset.expanded = 'true';
            button.style.background = '#138D75';
        }, 100);
    }
}

// Fungsi untuk escape HTML
function escapeHtml(unsafe) {
    if (unsafe === null || unsafe === undefined) return '-';
    return String(unsafe)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// Fungsi untuk menutup modal
function closeModal(id) { 
    document.getElementById(id).classList.remove('show'); 
}

// Toggle Sidebar for Mobile
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
}

// Fungsi untuk tombol Kembali
function goBack() {
    window.location.href = '<?= base_url() ?>';
}

// ===== FUNGSI UNTUK SHOW MODAL DOSEN =====
function showDosenModal(event, dosenList, namaKegiatan, suratId) {
    event.stopPropagation();

    // Validasi: hanya tampilkan modal jika ada lebih dari 1 dosen
    if (!dosenList || dosenList.length <= 1) {
        // Tampilkan pesan atau tidak lakukan apa-apa
        console.log('Modal dosen hanya untuk pengajuan dengan lebih dari 1 dosen');
        
        // Atau tampilkan info dosen tunggal di tooltip
        if (dosenList && dosenList.length === 1) {
            const dosen = dosenList[0];
            Swal.fire({
                icon: 'info',
                title: 'Informasi Dosen',
                html: `
                    <div style="text-align: left; padding: 10px;">
                        <div style="margin-bottom: 15px; font-weight: 600; color: #FB8C00;">${namaKegiatan}</div>
                        <div style="display: flex; align-items: center; gap: 15px; background: #f8f9fa; padding: 15px; border-radius: 10px;">
                            <div style="width: 50px; height: 50px; background: #FB8C00; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 20px;">
                                ${(dosen.nama_dosen || '?').charAt(0).toUpperCase()}
                            </div>
                            <div style="flex: 1;">
                                <div style="font-weight: 600; color: #212529; font-size: 16px;">${dosen.nama_dosen || '-'}</div>
                                <div style="font-size: 13px; color: #6c757d;">
                                    <div>NIP: ${dosen.nip || '-'}</div>
                                    <div>Jabatan: ${dosen.jabatan || '-'}</div>
                                    <div>Divisi: ${dosen.divisi || '-'}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                `,
                showConfirmButton: true,
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#FB8C00',
                showCloseButton: true,
                width: 500
            });
        }
        return;
    }

    // Simpan data ke variabel global
    currentSuratId = suratId;
    currentDosenList = dosenList || [];
    currentPengajuanName = namaKegiatan;

    // Update judul dan konten
    document.getElementById("kegiatanTitle").innerText = namaKegiatan || "Kegiatan";
    updateDosenListDisplay();

    // Tampilkan tombol aksi jika ada lebih dari 1 dosen
    const actionButtons = document.getElementById("dosenActionButtons");
    if (currentDosenList.length > 1) {
        actionButtons.style.display = 'flex';
    } else {
        actionButtons.style.display = 'none';
    }

    // Tampilkan modal dengan z-index tinggi
    const dosenModal = document.getElementById("dosenModal");
    dosenModal.classList.add('show');
    dosenModal.style.zIndex = '1055';
}

// ===== FUNGSI UPDATE TAMPILAN DOSEN =====
function updateDosenListDisplay() {
    const container = document.getElementById("dosenListContainer");
    if (!container) return;
    
    container.innerHTML = "";

    if (currentDosenList.length === 0) {
        container.innerHTML = `
        <div class="no-dosen">
            <i class="fas fa-user-slash"></i>
            <h4>Tidak Ada Dosen</h4>
            <p>Belum ada dosen yang ditambahkan ke pengajuan ini.</p>
        </div>
    `;
    } else {
        currentDosenList.forEach((d, index) => {
            const item = document.createElement("div");
            item.className = "dosen-card";
            item.setAttribute('data-index', index);

            const initial = (d.nama_dosen || "-").charAt(0).toUpperCase();

            item.innerHTML = `
            <div class="dosen-avatar">${initial}</div>
            <div class="dosen-card-info">
                <div class="dosen-card-name">${d.nama_dosen || '-'}</div>
                <div class="dosen-card-detail">
                    NIP: ${d.nip || '-'} | 
                    Jabatan: ${d.jabatan || '-'} | 
                    Divisi: ${d.divisi || '-'}
                </div>
            </div>
        `;

            container.appendChild(item);
        });
    }

    // Update total dosen
    const totalCountElement = document.getElementById("dosenTotalCount");
    if (totalCountElement) {
        totalCountElement.innerText = currentDosenList.length;
    }

    // Update tombol aksi
    const actionButtons = document.getElementById("dosenActionButtons");
    if (actionButtons) {
        if (currentDosenList.length > 1) {
            actionButtons.style.display = 'flex';
        } else {
            actionButtons.style.display = 'none';
        }
    }
}

// ===== PERBAIKAN UTAMA: FUNGSI UNTUK MENUTUP SEMUA MODAL =====
function tutupSemuaModalKecuali(modalId = null) {
    const modals = [
        'dosenModal',
        'modalTambahDosen',
        'modalKurangDosen',
        'konfirmasiHapusModal',
        'modalDetail',
        'previewModal',
        'statusModal'
    ];
    
    modals.forEach(id => {
        if (modalId !== id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('show');
                modal.style.zIndex = '';
            }
        }
    });
}

// ===== MODAL TAMBAH DOSEN =====
function bukaModalTambah() {
    if (!currentSuratId) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'ID Surat tidak ditemukan',
            confirmButtonColor: '#FB8C00'
        });
        return;
    }

    // Tutup modal dosen utama terlebih dahulu
    tutupSemuaModalKecuali();
    
    // RESET semua state
    selectedDosenList = [];
    
    // Update data yang ditampilkan
    updateModalTambahData();
    
    // Tampilkan modal dengan z-index tinggi
    const modalTambah = document.getElementById('modalTambahDosen');
    modalTambah.classList.add('show');
    modalTambah.style.zIndex = '1060';
    
    // Fokus ke input pencarian
    setTimeout(() => {
        const input = document.getElementById('inputNipTambah');
        if (input) {
            input.value = '';
            input.focus();
        }
    }, 300);
}

// FUNGSI BANTUAN: Update data modal
function updateModalTambahData() {
    // Update nama pengajuan
    const kegiatanTitle = document.getElementById('kegiatanTitle')?.textContent || 
                        currentPengajuanName || 
                        'Kegiatan';
    document.getElementById('currentPengajuanName').textContent = kegiatanTitle;
    
    // Update jumlah dosen saat ini
    document.getElementById('currentDosenCount').textContent = currentDosenList.length;
    
    // Update tampilan daftar dosen yang dipilih
    updateSelectedDosenList();
    
    // Update state tombol
    updateButtonState();
    
    // Clear hasil pencarian
    document.getElementById('hasilPencarian').innerHTML = '';
    
    // Clear input
    const nipInput = document.getElementById('inputNipTambah');
    if (nipInput) nipInput.value = '';
    
    // Hide autocomplete
    const autocomplete = document.getElementById('autocompleteResults');
    if (autocomplete) autocomplete.style.display = 'none';
}

// ===== FUNGSI TUTUP MODAL TAMBAH =====
function tutupModalTambah() {
    // Reset semua state
    selectedDosenList = [];
    
    // Clear input dan tampilan
    const inputNip = document.getElementById('inputNipTambah');
    if (inputNip) inputNip.value = '';
    
    const hasilPencarian = document.getElementById('hasilPencarian');
    if (hasilPencarian) hasilPencarian.innerHTML = '';
    
    const autocomplete = document.getElementById('autocompleteResults');
    if (autocomplete) autocomplete.style.display = 'none';
    
    const selectedList = document.getElementById('selectedDosenList');
    if (selectedList) {
        selectedList.innerHTML = `
            <div id="emptySelectionMessage" style="text-align: center; padding: 30px; color: #6c757d;">
                <i class="fas fa-user-plus" style="font-size: 48px; margin-bottom: 10px;"></i>
                <p>Belum ada dosen yang dipilih.</p>
                <small>Pilih dosen dari kolom pencarian di atas.</small>
            </div>
        `;
    }
    
    // Reset tombol
    const btnSubmit = document.getElementById('btnTambahSubmit');
    if (btnSubmit) {
        btnSubmit.disabled = true;
        btnSubmit.style.background = '#6c757d';
    }
    
    const btnClearAll = document.getElementById('btnClearAll');
    if (btnClearAll) btnClearAll.style.display = 'none';
    
    // Sembunyikan modal dan reset z-index
    const modal = document.getElementById('modalTambahDosen');
    modal.classList.remove('show');
    modal.style.zIndex = '';
}

// ===== FUNGSI UTAMA TAMBAH MULTIPLE DOSEN =====
function prosesTambahMultipleDosen() {
    if (selectedDosenList.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Tidak ada dosen yang dipilih',
            confirmButtonColor: '#FB8C00'
        });
        return;
    }
    
    if (!currentSuratId) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Surat ID tidak ditemukan',
            confirmButtonColor: '#FB8C00'
        });
        return;
    }
    
    // Cek apakah ada dosen duplikat (sudah ada dalam pengajuan)
    const existingNips = currentDosenList.map(d => d.nip);
    const duplicateDosen = selectedDosenList.filter(d => 
        existingNips.includes(d.nip)
    );
    
    if (duplicateDosen.length > 0) {
        const names = duplicateDosen.map(d => d.nama_dosen).join(', ');
        Swal.fire({
            icon: 'warning',
            title: 'Dosen Sudah Ada',
            html: `
                <p>Berikut dosen sudah ada dalam pengajuan:</p>
                <div style="background: #fff3cd; padding: 10px; border-radius: 5px; margin: 10px 0;">
                    <strong>${names}</strong>
                </div>
                <p>Dosen duplikat akan dilewati.</p>
                <p style="font-size: 14px; color: #6c757d;">
                    <i class="fas fa-info-circle"></i> 
                    Dosen lainnya akan tetap ditambahkan.
                </p>
            `,
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan Tambah',
            cancelButtonText: 'Periksa Ulang',
            confirmButtonColor: '#FB8C00'
        }).then((result) => {
            if (result.isConfirmed) {
                // Hapus duplikat
                const filteredDosen = selectedDosenList.filter(d => 
                    !existingNips.includes(d.nip)
                );
                doTambahMultipleDosen(filteredDosen);
            }
        });
        return;
    }
    
    // Jika tidak ada duplikat, langsung proses
    doTambahMultipleDosen(selectedDosenList);
}

// ===== FUNGSI BANTUAN: PROSES TAMBAH KE SERVER =====
function doTambahMultipleDosen(dosenToAdd) {
    if (dosenToAdd.length === 0) {
        Swal.fire({
            icon: 'info',
            title: 'Tidak Ada yang Baru',
            text: 'Semua dosen yang dipilih sudah ada dalam pengajuan.',
            confirmButtonColor: '#FB8C00'
        });
        return;
    }
    
    // Tampilkan loading dengan progress
    let currentProgress = 0;
    const totalDosen = dosenToAdd.length;
    
    Swal.fire({
        title: 'Memproses...',
        html: `
            <div style="text-align: center;">
                <div style="font-size: 14px; color: #6c757d; margin-bottom: 10px;">
                    Menambahkan dosen: <strong>${currentProgress}/${totalDosen}</strong>
                </div>
                <div style="width: 100%; background: #e9ecef; border-radius: 10px; height: 10px;">
                    <div id="progressBar" style="width: 0%; height: 100%; background: #FB8C00; border-radius: 10px; transition: width 0.3s;"></div>
                </div>
                <div style="margin-top: 15px; font-size: 12px; color: #6c757d;">
                    <i class="fas fa-sync fa-spin"></i> Sedang memproses...
                </div>
            </div>
        `,
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            updateProgressBar(0);
        }
    });
    
    // Kirim semua NIP sekaligus
    const nipList = dosenToAdd.map(d => d.nip);
    
    const formData = new FormData();
    formData.append('surat_id', currentSuratId);
    formData.append('nip_list', JSON.stringify(nipList));
    
    fetch(baseUrl + '/surat/tambah_banyak_dosen', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            successCount = data.added_count || dosenToAdd.length;
            
            // Update progress bar
            updateProgressBar(100);
            
            // Tutup modal setelah delay
            setTimeout(() => {
                Swal.close();
                
                // Tutup modal tambah
                tutupModalTambah();
                
                // Tutup semua modal
                tutupSemuaModalKecuali();
                
                // Tampilkan hasil sukses
                showTambahSuccessMessage(successCount, dosenToAdd);
                
            }, 500);
            
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: data.message || 'Terjadi kesalahan saat menambahkan dosen',
                confirmButtonColor: '#FB8C00'
            });
        }
    })
    .catch(error => {
        console.error('Error batch:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Terjadi kesalahan: ' + error.message,
            confirmButtonColor: '#FB8C00'
        });
    });
    
    // Fungsi update progress bar
    function updateProgressBar(percent) {
        const progressBar = document.getElementById('progressBar');
        if (progressBar) {
            progressBar.style.width = percent + '%';
        }
    }
}

// FUNGSI TAMPILKAN PESAN SUKSES TAMBAH
function showTambahSuccessMessage(successCount, dosenToAdd) {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        html: `
            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: #d4edda; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <i class="fas fa-check" style="font-size: 40px; color: #155724;"></i>
                </div>
                <h4>${successCount} Dosen Ditambahkan</h4>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 15px 0;">
                    <strong>Daftar Dosen:</strong>
                    <div style="max-height: 150px; overflow-y: auto; text-align: left; margin-top: 10px;">
                        ${dosenToAdd.map(d => `
                            <div style="padding: 8px; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 10px;">
                                <div style="width: 24px; height: 24px; background: #28a745; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <strong>${d.nama_dosen}</strong>
                                    <div style="font-size: 12px; color: #666;">NIP: ${d.nip}</div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
                <p style="font-size: 14px; color: #6c757d; margin-top: 10px;">
                    <i class="fas fa-sync-alt"></i> Memperbarui tampilan...
                </p>
            </div>
        `,
        confirmButtonText: 'OK',
        confirmButtonColor: '#FB8C00',
        width: 600,
        willClose: () => {
            // Pastikan semua modal tertutup sebelum refresh
            tutupSemuaModalKecuali();
            // Refresh halaman untuk memastikan data sinkron
            location.reload();
        }
    });
}

// ===== MODAL KURANG DOSEN =====
function bukaModalKurang() {
    // Cek minimal harus ada 2 dosen
    if (currentDosenList.length <= 1) {
        Swal.fire({
            icon: 'warning',
            title: 'Tidak Dapat Mengurangi',
            text: 'Minimal harus ada 1 dosen dalam pengajuan. Tidak dapat mengurangi dosen.',
            confirmButtonColor: '#FB8C00'
        });
        return;
    }

    // Tutup semua modal terlebih dahulu
    tutupSemuaModalKecuali();
    
    // Reset selected dosen untuk multi hapus
    selectedDosenToDelete = [];
    
    // Tampilkan modal hapus dosen dengan z-index tinggi
    showModalKurangDosen();
}

function showModalKurangDosen() {
    // Reset state untuk multi hapus
    selectedDosenToDelete = [];
    
    // Update daftar dosen yang dapat dihapus (semua kecuali dosen pertama)
    updateDosenHapusList();
    
    // Update tombol hapus dan header multi hapus
    updateMultiHapusHeader();
    updateHapusButtonState();
    
    // Tampilkan modal dengan z-index tinggi
    const modalKurang = document.getElementById('modalKurangDosen');
    modalKurang.classList.add('show');
    modalKurang.style.zIndex = '1060';
}

function updateDosenHapusList() {
    const container = document.getElementById('listDosenHapus');
    const emptyMessage = document.getElementById('pesanDosenKosong');
    
    if (!container) return;
    
    // Clear container
    container.innerHTML = '';
    
    // Filter dosen yang dapat dihapus (semua kecuali dosen pertama)
    const dosenBisaDihapus = currentDosenList.slice(1);
    
    if (dosenBisaDihapus.length === 0) {
        if (emptyMessage) emptyMessage.style.display = 'block';
        container.innerHTML = '';
        return;
    }
    
    if (emptyMessage) emptyMessage.style.display = 'none';
    
    // Tampilkan setiap dosen dengan checkbox
    dosenBisaDihapus.forEach((dosen, index) => {
        const actualIndex = index + 1;
        const item = document.createElement('div');
        item.className = 'dosen-item-hapus';
        item.dataset.index = actualIndex;
        item.dataset.nip = dosen.nip;
        
        const initial = (dosen.nama_dosen || "?").charAt(0).toUpperCase();
        const isSelected = selectedDosenToDelete.includes(dosen.nip);
        
        item.innerHTML = `
            <input type="checkbox" class="checkbox-hapus" ${isSelected ? 'checked' : ''}>
            <div class="dosen-avatar-hapus">${initial}</div>
            <div class="dosen-info-hapus">
                <div class="dosen-nama-hapus">${dosen.nama_dosen || '-'}</div>
                <div class="dosen-detail-hapus">
                    NIP: ${dosen.nip || '-'} | 
                    Jabatan: ${dosen.jabatan || '-'} | 
                    Divisi: ${dosen.divisi || '-'}
                </div>
            </div>
        `;
        
        // Tambahkan event listener untuk checkbox
        const checkbox = item.querySelector('.checkbox-hapus');
        checkbox.addEventListener('change', function(e) {
            e.stopPropagation();
            
            const nip = dosen.nip;
            if (this.checked) {
                if (!selectedDosenToDelete.includes(nip)) {
                    selectedDosenToDelete.push(nip);
                }
            } else {
                const index = selectedDosenToDelete.indexOf(nip);
                if (index > -1) {
                    selectedDosenToDelete.splice(index, 1);
                }
            }
            
            // Update UI
            updateItemSelection(item, this.checked);
            updateMultiHapusHeader();
            updateHapusButtonState();
        });
        
        // Juga bisa select dengan klik item
        item.addEventListener('click', function(e) {
            if (e.target === checkbox || e.target.type === 'checkbox') {
                return;
            }
            
            // Toggle checkbox
            checkbox.checked = !checkbox.checked;
            const nip = dosen.nip;
            
            if (checkbox.checked) {
                if (!selectedDosenToDelete.includes(nip)) {
                    selectedDosenToDelete.push(nip);
                }
            } else {
                const index = selectedDosenToDelete.indexOf(nip);
                if (index > -1) {
                    selectedDosenToDelete.splice(index, 1);
                }
            }
            
            // Update UI
            updateItemSelection(item, checkbox.checked);
            updateMultiHapusHeader();
            updateHapusButtonState();
        });
        
        // Set initial selection state
        updateItemSelection(item, isSelected);
        
        container.appendChild(item);
    });
}

function updateItemSelection(item, isSelected) {
    if (isSelected) {
        item.classList.add('selected');
    } else {
        item.classList.remove('selected');
    }
}

function updateMultiHapusHeader() {
    const header = document.getElementById('multiHapusHeader');
    const countElement = document.getElementById('multiHapusCount');
    const selectedCountElement = document.getElementById('selectedHapusCount');
    
    if (selectedDosenToDelete.length > 0) {
        header.style.display = 'flex';
        if (countElement) countElement.textContent = selectedDosenToDelete.length;
        if (selectedCountElement) selectedCountElement.textContent = selectedDosenToDelete.length;
    } else {
        header.style.display = 'none';
    }
}

function toggleSelectAllDosen() {
    const checkboxes = document.querySelectorAll('.checkbox-hapus');
    const allDosen = Array.from(document.querySelectorAll('.dosen-item-hapus')).map(item => ({
        nip: item.dataset.nip,
        element: item
    }));
    
    // Jika ada yang belum terpilih, pilih semua
    const currentlySelected = selectedDosenToDelete.length;
    const totalDosen = allDosen.length;
    
    if (currentlySelected < totalDosen) {
        // Pilih semua
        selectedDosenToDelete = allDosen.map(d => d.nip);
        checkboxes.forEach(cb => cb.checked = true);
        allDosen.forEach(d => updateItemSelection(d.element, true));
    } else {
        // Batalkan semua
        selectedDosenToDelete = [];
        checkboxes.forEach(cb => cb.checked = false);
        allDosen.forEach(d => updateItemSelection(d.element, false));
    }
    
    updateMultiHapusHeader();
    updateHapusButtonState();
}

function updateHapusButtonState() {
    const btnHapus = document.getElementById('btnHapusDosen');
    const countSpan = document.getElementById('countHapus');
    
    if (btnHapus) {
        if (selectedDosenToDelete.length > 0) {
            btnHapus.disabled = false;
            if (countSpan) countSpan.textContent = selectedDosenToDelete.length;
        } else {
            btnHapus.disabled = true;
            if (countSpan) countSpan.textContent = '0';
        }
    }
}

// ===== MODAL KONFIRMASI PENGHAPUSAN MULTI =====
function showKonfirmasiHapusMultiModal() {
    if (selectedDosenToDelete.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Pilih Dosen',
            text: 'Silakan pilih minimal 1 dosen yang akan dihapus',
            confirmButtonColor: '#FB8C00'
        });
        return;
    }
    
    // Cari data dosen yang dipilih
    const dosenToDelete = currentDosenList.filter(d => 
        selectedDosenToDelete.includes(d.nip)
    );
    
    if (dosenToDelete.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Data dosen tidak ditemukan',
            confirmButtonColor: '#FB8C00'
        });
        return;
    }
    
    // Update informasi dosen di modal konfirmasi
    const singleInfo = document.getElementById('singleHapusInfo');
    const multiInfo = document.getElementById('multiHapusInfo');
    const jumlahElement = document.getElementById('jumlahDosenHapus');
    const listContainer = document.getElementById('listDosenKonfirmasi');
    
    if (selectedDosenToDelete.length === 1) {
        // Tampilkan single info
        singleInfo.style.display = 'block';
        multiInfo.style.display = 'none';
        
        const dosen = dosenToDelete[0];
        const dosenInfoElement = document.getElementById('dosenHapusInfo');
        if (dosenInfoElement) {
            dosenInfoElement.innerHTML = `
                <strong>${dosen.nama_dosen || '-'}</strong>
                <div>NIP: ${dosen.nip || '-'}</div>
                <div>Jabatan: ${dosen.jabatan || '-'}</div>
                <div>Divisi: ${dosen.divisi || '-'}</div>
            `;
        }
    } else {
        // Tampilkan multi info
        singleInfo.style.display = 'none';
        multiInfo.style.display = 'block';
        
        if (jumlahElement) jumlahElement.textContent = dosenToDelete.length;
        
        // Clear dan isi list
        listContainer.innerHTML = '';
        dosenToDelete.forEach(dosen => {
            const initial = (dosen.nama_dosen || "?").charAt(0).toUpperCase();
            const item = document.createElement('div');
            item.className = 'dosen-hapus-item';
            item.innerHTML = `
                <div class="dosen-hapus-initial">${initial}</div>
                <div class="dosen-hapus-info">
                    <div class="dosen-hapus-nama">${dosen.nama_dosen || '-'}</div>
                    <div class="dosen-hapus-nip">NIP: ${dosen.nip || '-'}</div>
                </div>
            `;
            listContainer.appendChild(item);
        });
    }
    
    // Tampilkan modal konfirmasi dengan z-index lebih tinggi
    const konfirmasiModal = document.getElementById('konfirmasiHapusModal');
    konfirmasiModal.classList.add('show');
    konfirmasiModal.style.zIndex = '1070';
}

function tutupKonfirmasiHapus() {
    const konfirmasiModal = document.getElementById('konfirmasiHapusModal');
    konfirmasiModal.classList.remove('show');
    konfirmasiModal.style.zIndex = '';
}

function tutupModalKurang() {
    // Reset state
    selectedDosenToDelete = [];
    
    // Sembunyikan modal dan reset z-index
    const modalKurang = document.getElementById('modalKurangDosen');
    modalKurang.classList.remove('show');
    modalKurang.style.zIndex = '';
}

// ===== FUNGSI UTAMA HAPUS DOSEN MULTIPLE =====
function prosesHapusDosenMulti() {
    // Validasi data
    if (selectedDosenToDelete.length === 0 || !currentSuratId) {
        Swal.fire({
            icon: 'error',
            title: 'Data Tidak Lengkap',
            text: 'Data dosen atau surat tidak valid',
            confirmButtonColor: '#FB8C00'
        });
        return;
    }
    
    // Cari data dosen untuk ditampilkan di pesan
    const dosenToDelete = currentDosenList.filter(d => 
        selectedDosenToDelete.includes(d.nip)
    );
    
    // Tutup modal konfirmasi
    tutupKonfirmasiHapus();
    
    // Tampilkan loading
    Swal.fire({
        title: 'Menghapus Dosen...',
        html: `
            <p>Sedang menghapus <strong>${dosenToDelete.length}</strong> dosen:</p>
            <div style="background: #f8f9fa; padding: 10px; border-radius: 8px; margin: 10px 0; max-height: 150px; overflow-y: auto;">
                ${dosenToDelete.map(d => 
                    `<div style="padding: 5px; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 8px;">
                        <div style="width: 20px; height: 20px; background: #dc3545; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px;">
                            <i class="fas fa-user-minus"></i>
                        </div>
                        <span>${d.nama_dosen || d.nip}</span>
                    </div>`
                ).join('')}
            </div>
        `,
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Siapkan data untuk dikirim
    const formData = new FormData();
    formData.append('surat_id', currentSuratId);
    formData.append('nip_list', JSON.stringify(selectedDosenToDelete));
    
    // Kirim request
    fetch(`${baseUrl}/surat/hapus_banyak_dosen`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (response.status === 200) {
            return response.text().then(text => {
                try {
                    return JSON.parse(text);
                } catch (e) {
                    return { status: 'success', message: 'Dosen berhasil dihapus' };
                }
            });
        } else {
            return response.text().then(text => {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            });
        }
    })
    .then(result => {
        // Tutup loading
        Swal.close();
        
        // Cek keberhasilan
        const isSuccess = 
            result.success === true || 
            result.status === 'success' || 
            (result.message && result.message.includes('berhasil')) ||
            response.status === 200;
        
        if (isSuccess) {
            // BERHASIL: Tampilkan pesan sukses dan refresh
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                html: `
                    <div style="text-align: center;">
                        <div style="width: 60px; height: 60px; background: #d4edda; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                            <i class="fas fa-check" style="font-size: 30px; color: #155724;"></i>
                        </div>
                        <h5>${dosenToDelete.length} Dosen Berhasil Dihapus</h5>
                        <p style="margin: 10px 0;">Dosen telah dihapus dari pengajuan.</p>
                        <div style="background: #f8f9fa; padding: 10px; border-radius: 8px; margin: 10px 0; max-height: 150px; overflow-y: auto;">
                            <strong>Daftar dosen:</strong>
                            ${dosenToDelete.map(d => 
                                `<div style="padding: 5px; border-bottom: 1px solid #eee; color: #666; font-size: 13px;">
                                    <i class="fas fa-user-minus" style="color: #dc3545; margin-right: 5px;"></i>
                                    ${d.nama_dosen || d.nip}
                                </div>`
                            ).join('')}
                        </div>
                        <p style="font-size: 14px; color: #6c757d; margin-top: 10px;">
                            <i class="fas fa-sync-alt fa-spin"></i> Memperbarui data...
                        </p>
                    </div>
                `,
                showConfirmButton: false,
                timer: 2000,
                willClose: () => {
                    // Pastikan semua modal tertutup sebelum refresh
                    tutupSemuaModalKecuali();
                    // Refresh halaman untuk sinkronisasi data
                    location.reload();
                }
            });
            
        } else {
            // GAGAL: Tampilkan pesan error
            const errorMsg = result.message || result.error || 'Gagal menghapus dosen. Silakan coba lagi.';
            
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                html: `
                    <p>${errorMsg}</p>
                    <div style="margin-top: 10px; padding: 10px; background: #f8f9fa; border-radius: 5px; font-size: 13px;">
                        <strong>Detail:</strong> Terjadi kesalahan saat menghapus dosen.
                    </div>
                `,
                confirmButtonColor: '#FB8C00',
                willClose: () => {
                    // Refresh halaman untuk sinkronisasi
                    location.reload();
                }
            });
        }
    })
    .catch(error => {
        // Tutup loading
        Swal.close();
        
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: `
                <p>Terjadi kesalahan saat menghapus dosen.</p>
                <div style="margin-top: 10px; padding: 10px; background: #fff3cd; border-radius: 5px; font-size: 13px;">
                    <strong>Detail:</strong> ${error.message}<br>
                    <strong>Solusi:</strong>
                    <ul style="margin: 5px 0 0 15px; text-align: left;">
                        <li>Refresh halaman untuk memastikan status terbaru</li>
                        <li>Periksa koneksi internet</li>
                        <li>Hubungi administrator jika masalah berlanjut</li>
                    </ul>
                </div>
            `,
            confirmButtonColor: '#FB8C00',
            willClose: () => {
                // Refresh halaman untuk sinkronisasi
                location.reload();
            }
        });
    });
}

// ===== FUNGSI HAPUS DOSEN DARI LIST (untuk modal tambah dosen) =====
function hapusDosenDariList(index) {
    if (index >= 0 && index < selectedDosenList.length) {
        const dosen = selectedDosenList[index];
        selectedDosenList.splice(index, 1);
        
        updateSelectedDosenList();
        updateButtonState();
        
        // Tampilkan pesan kecil
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        
        Toast.fire({
            icon: 'info',
            title: `"${dosen.nama_dosen}" dihapus dari daftar`
        });
    }
}

// ===== FUNGSI UPDATE TAMPILAN DOSEN YANG DIPILIH =====
function updateSelectedDosenList() {
    const container = document.getElementById('selectedDosenList');
    if (!container) return;
    
    const emptyMessage = document.getElementById('emptySelectionMessage');
    const selectedCount = document.getElementById('selectedCount');
    const tambahCount = document.getElementById('tambahCount');
    const clearAllBtn = document.getElementById('btnClearAll');
    
    // Update count
    if (selectedCount) selectedCount.textContent = selectedDosenList.length;
    if (tambahCount) tambahCount.textContent = selectedDosenList.length;
    
    // Toggle empty message
    if (selectedDosenList.length === 0) {
        if (emptyMessage) emptyMessage.style.display = 'block';
        if (clearAllBtn) clearAllBtn.style.display = 'none';
        
        container.innerHTML = '';
        if (emptyMessage) container.appendChild(emptyMessage);
        return;
    }
    
    if (emptyMessage) emptyMessage.style.display = 'none';
    if (clearAllBtn) clearAllBtn.style.display = 'inline-flex';
    
    // Clear container
    container.innerHTML = '';
    
    // Buat list dosen
    selectedDosenList.forEach((dosen, index) => {
        const item = document.createElement('div');
        item.className = 'selected-dosen-item';
        item.style.cssText = `
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: all 0.2s;
        `;
        
        item.innerHTML = `
            <div style="
                width: 40px;
                height: 40px;
                background: linear-gradient(135deg, #FB8C00 0%, #FF9800 100%);
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
                font-size: 16px;
                flex-shrink: 0;
            ">
                ${(dosen.nama_dosen || '?').charAt(0).toUpperCase()}
            </div>
            <div style="flex: 1; min-width: 0;">
                <div style="font-weight: 600; color: #333; font-size: 14px; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    ${dosen.nama_dosen || '-'}
                </div>
                <div style="font-size: 12px; color: #6c757d; display: flex; flex-wrap: wrap; gap: 10px;">
                    <span><i class="fas fa-id-card"></i> ${dosen.nip || '-'}</span>
                    <span><i class="fas fa-briefcase"></i> ${dosen.jabatan || '-'}</span>
                    <span><i class="fas fa-building"></i> ${dosen.divisi || '-'}</span>
                </div>
            </div>
            <button type="button" onclick="hapusDosenDariList(${index})" style="
                background: #dc3545;
                color: white;
                border: none;
                width: 32px;
                height: 32px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                flex-shrink: 0;
                transition: background 0.2s;
            ">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        container.appendChild(item);
    });
}

// ===== FUNGSI UPDATE STATE TOMBOL =====
function updateButtonState() {
    const btnSubmit = document.getElementById('btnTambahSubmit');
    if (!btnSubmit) return;
    
    const isValid = selectedDosenList.length > 0;
    
    btnSubmit.disabled = !isValid;
    
    if (isValid) {
        btnSubmit.style.background = 'linear-gradient(135deg, #FB8C00 0%, #FF9800 100%)';
    } else {
        btnSubmit.style.background = '#6c757d';
    }
}

// ===== FUNGSI HAPUS SEMUA DOSEN =====
function hapusSemuaDosen() {
    if (selectedDosenList.length === 0) return;
    
    Swal.fire({
        title: 'Hapus Semua Dosen?',
        html: `
            <div style="text-align: center;">
                <div style="color: #dc3545; font-size: 48px; margin-bottom: 15px;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <p>Anda akan menghapus <strong>${selectedDosenList.length} dosen</strong> dari daftar.</p>
                <p style="font-size: 14px; color: #6c757d;">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus Semua',
        cancelButtonText: 'Batal',
        width: 500
    }).then((result) => {
        if (result.isConfirmed) {
            selectedDosenList = [];
            updateSelectedDosenList();
            updateButtonState();
            
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Semua dosen telah dihapus dari daftar',
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
}

// ===== FUNGSI TAMPILKAN PESAN =====
function showSuccessMessage(message) {
    const resultDiv = document.getElementById('hasilPencarian');
    if (!resultDiv) return;
    
    resultDiv.innerHTML = `
        <div class="alert alert-success alert-dismissible fade show" style="border-radius: 8px; margin: 0;">
            <i class="fas fa-check-circle"></i> ${message}
            <button type="button" class="close" onclick="this.parentElement.style.display='none'">
                <span>&times;</span>
            </button>
        </div>
    `;
    
    setTimeout(() => {
        if (resultDiv.innerHTML.includes('alert-success')) {
            resultDiv.innerHTML = '';
        }
    }, 3000);
}

function showWarningMessage(message) {
    const resultDiv = document.getElementById('hasilPencarian');
    if (!resultDiv) return;
    
    resultDiv.innerHTML = `
        <div class="alert alert-warning alert-dismissible fade show" style="border-radius: 8px; margin: 0;">
            <i class="fas fa-exclamation-triangle"></i> ${message}
            <button type="button" class="close" onclick="this.parentElement.style.display='none'">
                <span>&times;</span>
            </button>
        </div>
    `;
    
    setTimeout(() => {
        if (resultDiv.innerHTML.includes('alert-warning')) {
            resultDiv.innerHTML = '';
        }
    }, 3000);
}

// ===== AUTCOMPLETE FUNGSI UTAMA =====
function setupAutocomplete() {
    const input = document.getElementById('inputNipTambah');
    const resultsContainer = document.getElementById('autocompleteResults');
    
    if (!input || !resultsContainer) {
        console.warn('Elemen autocomplete tidak ditemukan');
        return;
    }

    let selectedIndex = -1;
    let currentResults = [];

    // Event listener untuk input
    input.addEventListener('input', function(e) {
        const query = e.target.value.trim();
        
        if (query.length < 2) {
            resultsContainer.style.display = 'none';
            return;
        }

        // Fetch data dari server
        fetch(baseUrl + '/surat/autocomplete_dosen?q=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                if (data.success && data.results && data.results.length > 0) {
                    currentResults = data.results;
                    displayAutocompleteResults(data.results);
                } else {
                    resultsContainer.style.display = 'none';
                    currentResults = [];
                    
                    // Tampilkan pesan tidak ditemukan
                    resultsContainer.innerHTML = `
                        <div style="padding: 15px; text-align: center; color: #6c757d;">
                            <i class="fas fa-search"></i>
                            <div style="margin-top: 5px;">Tidak ditemukan dosen yang cocok</div>
                        </div>
                    `;
                    resultsContainer.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Autocomplete error:', error);
                resultsContainer.style.display = 'none';
            });
    });

    // Display results
    function displayAutocompleteResults(results) {
        resultsContainer.innerHTML = '';
        
        // Filter out dosen yang sudah dipilih
        const filteredResults = results.filter(dosen => 
            !selectedDosenList.some(selected => selected.nip === dosen.nip)
        );
        
        if (filteredResults.length === 0) {
            resultsContainer.innerHTML = `
                <div style="padding: 15px; text-align: center; color: #6c757d;">
                    <i class="fas fa-check-circle"></i>
                    <div style="margin-top: 5px;">Semua dosen yang cocok sudah dipilih</div>
                </div>
            `;
            resultsContainer.style.display = 'block';
            return;
        }
        
        filteredResults.forEach((dosen, index) => {
            const item = document.createElement('div');
            item.className = 'autocomplete-item';
            item.style.cssText = 'padding: 10px 15px; cursor: pointer; border-bottom: 1px solid #eee; transition: background 0.2s;';
            item.dataset.index = index;
            
            item.innerHTML = `
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 32px; height: 32px; background: #FB8C00; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                        ${(dosen.nama_dosen || '?').charAt(0).toUpperCase()}
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 600; color: #333;">${dosen.nama_dosen || '-'}</div>
                        <div style="font-size: 12px; color: #666;">
                            NIP: ${dosen.nip || '-'} | 
                            ${dosen.jabatan || '-'}
                        </div>
                    </div>
                    <div style="color: #28a745; font-size: 12px;">
                        <i class="fas fa-plus-circle"></i> Pilih
                    </div>
                </div>
            `;
            
            // Hover effect
            item.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8f9fa';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
            
            // Click handler
            item.addEventListener('click', function() {
                selectDosenFromAutocomplete(dosen);
                input.value = '';
                input.focus();
            });
            
            resultsContainer.appendChild(item);
        });
        
        resultsContainer.style.display = 'block';
    }

    // Select dosen dari autocomplete
    function selectDosenFromAutocomplete(dosen) {
        // Cek apakah sudah mencapai batas maksimum
        if (selectedDosenList.length >= 10) {
            Swal.fire({
                icon: 'warning',
                title: 'Batas Maksimum',
                text: 'Maksimal 10 dosen dapat ditambahkan dalam satu kali proses.',
                confirmButtonColor: '#FB8C00'
            });
            return;
        }
        
        // Cek apakah dosen sudah dipilih
        if (selectedDosenList.some(d => d.nip === dosen.nip)) {
            Swal.fire({
                icon: 'info',
                title: 'Dosen Sudah Dipilih',
                text: 'Dosen ini sudah ada dalam daftar yang akan ditambahkan.',
                confirmButtonColor: '#FB8C00'
            });
            return;
        }
        
        // Tambahkan ke array
        selectedDosenList.push(dosen);
        
        // Update tampilan
        updateSelectedDosenList();
        updateButtonState();
        
        // Sembunyikan hasil autocomplete
        resultsContainer.style.display = 'none';
        
        // Tampilkan pesan sukses
        showSuccessMessage(`"${dosen.nama_dosen}" ditambahkan ke daftar`);
    }

    // Keyboard navigation
    input.addEventListener('keydown', function(e) {
        if (!currentResults.length) return;
        
        switch(e.key) {
            case 'ArrowDown':
                e.preventDefault();
                selectedIndex = Math.min(selectedIndex + 1, currentResults.length - 1);
                highlightSelected();
                break;
                
            case 'ArrowUp':
                e.preventDefault();
                selectedIndex = Math.max(selectedIndex - 1, -1);
                highlightSelected();
                break;
                
            case 'Enter':
                e.preventDefault();
                if (selectedIndex >= 0 && selectedIndex < currentResults.length) {
                    selectDosenFromAutocomplete(currentResults[selectedIndex]);
                    input.value = '';
                    selectedIndex = -1;
                }
                break;
                
            case 'Escape':
                resultsContainer.style.display = 'none';
                selectedIndex = -1;
                break;
        }
    });

    function highlightSelected() {
        const items = resultsContainer.querySelectorAll('.autocomplete-item');
        
        items.forEach((item, index) => {
            if (index === selectedIndex) {
                item.style.backgroundColor = '#e8f4ff';
                item.style.borderLeft = '3px solid #FB8C00';
                item.scrollIntoView({ block: 'nearest' });
            } else {
                item.style.backgroundColor = '';
                item.style.borderLeft = 'none';
            }
        });
    }

    // Close autocomplete when clicking outside
    document.addEventListener('click', function(e) {
        if (!input.contains(e.target) && !resultsContainer.contains(e.target)) {
            resultsContainer.style.display = 'none';
            selectedIndex = -1;
        }
    });
}

// ===== EVENT LISTENERS INITIALIZATION =====
document.addEventListener('DOMContentLoaded', function() {
    
    // Close buttons untuk semua modal
    document.getElementById("closeDosenModal")?.addEventListener('click', function() {
        const dosenModal = document.getElementById("dosenModal");
        dosenModal.classList.remove('show');
        dosenModal.style.zIndex = '';
    });
    
    document.getElementById("closeTambahModal")?.addEventListener('click', tutupModalTambah);
    document.getElementById("closeKurangModal")?.addEventListener('click', tutupModalKurang);
    
    // Tombol aksi di modal dosen
    document.getElementById('btnTambahDosen')?.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        bukaModalTambah();
    });
    
    document.getElementById('btnKurangDosen')?.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        bukaModalKurang();
    });

    // Setup autocomplete
    setTimeout(() => {
        setupAutocomplete();
    }, 500);

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // ESC untuk close modal
        if (e.key === 'Escape') {
            if (document.getElementById('modalTambahDosen')?.classList.contains('show')) {
                tutupModalTambah();
            }
            if (document.getElementById('modalKurangDosen')?.classList.contains('show')) {
                tutupModalKurang();
            }
            if (document.getElementById('dosenModal')?.classList.contains('show')) {
                const dosenModal = document.getElementById('dosenModal');
                dosenModal.classList.remove('show');
                dosenModal.style.zIndex = '';
            }
            if (document.getElementById('konfirmasiHapusModal')?.classList.contains('show')) {
                tutupKonfirmasiHapus();
            }
            if (document.getElementById('modalDetail')?.classList.contains('show')) {
                const modalDetail = document.getElementById('modalDetail');
                modalDetail.classList.remove('show');
                modalDetail.style.zIndex = '';
            }
        }
    });
});

// ===== PERBAIKAN UTAMA: DATATABLES DENGAN SEARCH SEMUA DOSEN =====
$(document).ready(function() {
    const BASE_URL = '<?= rtrim(base_url(), "/"); ?>';

    // ===== 1. CUSTOM SEARCH FUNCTION UNTUK SEMUA DOSEN =====
    // Hapus filter lama jika ada
    $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(fn => 
        fn.name !== 'customDosenSearch' && fn.name !== 'customRowsFilter'
    );

    // Custom search untuk mencari semua dosen (dosen pertama, kedua, dst)
    const customDosenSearch = function(settings, data, dataIndex) {
        const globalSearch = $('#tableSearch').val().trim().toLowerCase();
        
        // Jika tidak ada pencarian global, skip
        if (!globalSearch) return true;
        
        const keywords = globalSearch.split(/\s+/).filter(x => x);
        
        // Ambil semua data dosen dari atribut data-detail
        const row = table.row(dataIndex).node();
        const rawData = $(row).attr('data-detail') || '{}';
        let rowData = {};
        try {
            rowData = JSON.parse(rawData);
        } catch (err) {
            return false;
        }
        
        // Gabungkan semua data dosen untuk pencarian
        let searchText = '';
        
        // Nama dosen (semua dosen)
        if (Array.isArray(rowData.nama_dosen)) {
            searchText += rowData.nama_dosen.join(' ').toLowerCase() + ' ';
        }
        
        // NIP dosen (semua NIP)
        if (Array.isArray(rowData.nip)) {
            searchText += rowData.nip.join(' ').toLowerCase() + ' ';
        }
        
        // Data kolom lainnya
        searchText += data.join(' ').toLowerCase();
        
        // Cek semua keyword
        return keywords.every(keyword => searchText.indexOf(keyword) >= 0);
    };

    Object.defineProperty(customDosenSearch, 'name', {
        value: 'customDosenSearch'
    });

    // ===== 2. CUSTOM FILTER UNTUK KATEGORI =====
    const customRowsFilter = function(settings, data) {
        const q = $('#tableSearch').val().trim().toLowerCase();
        if (q) {
            const keywords = q.split(/\s+/).filter(x => x);
            const row = table.row(settings, data).node();
            const rawData = $(row).attr('data-detail') || '{}';
            let rowData = {};
            
            try {
                rowData = JSON.parse(rawData);
            } catch (err) {
                return false;
            }
            
            // Gabungkan semua data untuk pencarian global
            let searchText = '';
            
            // Cari di semua nama dosen
            if (Array.isArray(rowData.nama_dosen)) {
                searchText += rowData.nama_dosen.join(' ').toLowerCase() + ' ';
            }
            
            // Cari di semua NIP dosen
            if (Array.isArray(rowData.nip)) {
                searchText += rowData.nip.join(' ').toLowerCase() + ' ';
            }
            
            // Data kolom lainnya
            searchText += data.join(' ').toLowerCase();
            
            const okText = keywords.every(k => searchText.indexOf(k) >= 0);
            if (!okText) return false;
        }

        for (const r of rows) {
            if (!r || !r.category) continue;

            if (r.category === 'tanggal') {
                const cell = (data[6] || '').trim();
                const start = r.dateStart || '';
                const end = r.dateEnd || '';
                if (!start && !end) continue;
                if (!cell || cell === '-') return false;
                if (start && cell < start) return false;
                if (end && cell > end) return false;
                continue;
            }

            // ===== PERBAIKAN UTAMA: FILTER UNTUK SEMUA DOSEN =====
            if (r.category === 'dosen') {
                const needle = String(r.text).toLowerCase().trim();
                if (!needle) continue;
                
                const row = table.row(settings, data).node();
                const rawData = $(row).attr('data-detail') || '{}';
                let rowData = {};
                try {
                    rowData = JSON.parse(rawData);
                } catch (err) {
                    return false;
                }
                
                const namaDosenArray = rowData.nama_dosen || [];
                const nipArray = rowData.nip || [];
                
                let found = false;
                
                // Cari di semua nama dosen
                if (Array.isArray(namaDosenArray)) {
                    found = namaDosenArray.some(nama => 
                        nama.toLowerCase().indexOf(needle) >= 0
                    );
                }
                
                // Cari di semua NIP
                if (!found && Array.isArray(nipArray)) {
                    found = nipArray.some(nip => 
                        String(nip).toLowerCase().indexOf(needle) >= 0
                    );
                }
                
                if (!found) return false;
                continue;
            }

            // Filter untuk kategori lainnya (jenis, status)
            const colIndex = (r.category === 'jenis') ? 3 :
                            (r.category === 'status') ? 5 : -1;

            if (colIndex === -1) continue;

            const cellRaw = (data[colIndex] || '').toLowerCase();
            if (!r.text || String(r.text).trim() === '') continue;

            const needle = String(r.text).toLowerCase().trim();
            if (cellRaw.indexOf(needle) === -1) return false;
        }

        return true;
    };
    
    Object.defineProperty(customRowsFilter, 'name', {
        value: 'customRowsFilter'
    });

    // ===== 3. INISIALISASI DATATABLE =====
    table = $('#tabelSurat').DataTable({
        responsive: true,
        pageLength: 5,
        dom: 'rtp',
        scrollX: false,
        autoWidth: false,
        columnDefs: [{
                orderable: false,
                targets: [0, -1]
            },
            {
                className: 'dt-center',
                targets: [0, 1, 4, 5, 6, 7]
            },
            {
                className: 'dt-left',
                targets: [2, 3]
            },
            {
                width: '4%',
                targets: 0
            },
            {
                width: '5%',
                targets: 1
            },
            {
                width: '25%',
                targets: 2
            },
            {
                width: '12%',
                targets: 3
            },
            {
                width: '20%',
                targets: 4
            },
            {
                width: '15%',
                targets: 5
            },
            {
                width: '12%',
                targets: 6
            },
            {
                width: '12%',
                targets: 7
            }
        ],
        order: [
            [1, 'asc']
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ entri",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
            infoFiltered: "(disaring dari _MAX_ total entri)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        }
    });

    // ===== 4. TAMBAHKAN CUSTOM SEARCH KE DATATABLES =====
    $.fn.dataTable.ext.search.push(customRowsFilter);
    $.fn.dataTable.ext.search.push(customDosenSearch);

    // Update semua tanggal di tabel
    setTimeout(function() {
        updateAllDates();
    }, 100);

    // ===== 5. UPDATE FUNGSI applyFilters =====
    function applyFilters() {
        // Draw table dengan filter baru
        table.draw();
        const anyFilterActive = rows.length > 0 || $('#tableSearch').val().trim() !== '';
        $('#btnResetAll').prop('hidden', !anyFilterActive);
    }

    // ===== 6. GLOBAL SEARCH EVENT HANDLER =====
    let debounce = null;
    $('#tableSearch').on('input', function() {
        if (debounce) clearTimeout(debounce);
        debounce = setTimeout(() => {
            applyFilters();
        }, 300);
    });

    // ===== 7. FILTER FUNCTIONALITY =====
    const filterData = {
        jenis: <?php
                $jenis_list = array_unique(array_map(function ($s) {
                    return $s->jenis_pengajuan;
                }, $surat_list));
                echo json_encode(array_values($jenis_list));
                ?>,
        dosen: <?php
                // Ambil dari dosen_data
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
        status: <?php
                $status_list = array_unique(array_map(function ($s) {
                    return $s->status;
                }, $surat_list));
                echo json_encode(array_values($status_list));
                ?>
    };

    Object.keys(filterData).forEach(k => {
        filterData[k] = (filterData[k] || []).map(x => String(x || '').trim()).filter(x => x !== '');
        filterData[k] = Array.from(new Set(filterData[k])).sort((a, b) => a.localeCompare(b));
    });

    let rows = [];
    let uid = 0;

    function nextId() {
        return 'r' + (++uid);
    }

    function makeRowDOM(r) {
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
        <option value="status">Status</option>
        <option value="tanggal">Tanggal Kegiatan</option>
    </select>`);

        const $btnAdd = $(`<button class="row-btn add" title="Tambah baris"><i class="fa fa-plus"></i></button>`);
        const $btnRemove = $(`<button class="row-btn remove" title="Hapus baris"><i class="fa fa-times"></i></button>`);

        if (r.category) $cat.val(r.category);
        if (r.text) $search.val(r.text);
        if (r.dateStart) $dateStart.val(r.dateStart);
        if (r.dateEnd) $dateEnd.val(r.dateEnd);

        function refreshInputs() {
            const catVal = $cat.val();
            if (catVal === 'tanggal') {
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

        $search.on('input', function() {
            const id = $wr.data('id');
            const obj = rows.find(x => x.id === id);
            if (!obj) return;
            obj.text = $(this).val() || '';
            applyFilters();
        });

        $dateStart.on('change', function() {
            const id = $wr.data('id');
            const obj = rows.find(x => x.id === id);
            if (!obj) return;
            obj.dateStart = $(this).val() || '';
            applyFilters();
        });
        $dateEnd.on('change', function() {
            const id = $wr.data('id');
            const obj = rows.find(x => x.id === id);
            if (!obj) return;
            obj.dateEnd = $(this).val() || '';
            applyFilters();
        });

        $cat.on('change', function() {
            const id = $wr.data('id');
            const obj = rows.find(x => x.id === id);
            if (!obj) return;
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

        $btnAdd.on('click', function() {
            const id = $wr.data('id');
            const idx = rows.findIndex(x => x.id === id);
            const cur = rows[idx] || {};
            const newRow = {
                id: nextId(),
                category: cur.category || 'jenis',
                text: '',
                dateStart: '',
                dateEnd: ''
            };
            if (idx >= 0 && idx < rows.length - 1) {
                rows.splice(idx + 1, 0, newRow);
            } else {
                rows.push(newRow);
            }
            renderRows();
            applyFilters();
        });

        $btnRemove.on('click', function() {
            const id = $wr.data('id');
            rows = rows.filter(x => x.id !== id);
            renderRows();
            applyFilters();
        });

        $filterRowActions.append($cat).append($btnAdd).append($btnRemove);
        $wr.append($filterRowActions).append($filterRowSearch).append($dateStart).append($dateEnd);
        return $wr;
    }

    function renderRows() {
        const $b = $('#filterBuilder');
        $b.empty();
        rows.forEach(r => {
            $b.append(makeRowDOM(r));
        });
        $('#btnResetAll').prop('hidden', rows.length === 0 && $('#tableSearch').val().trim() === '');
    }

    $('#btnAddFilterRow').click(function() {
        const cat = $('#filterCategory').val() || 'jenis';
        rows.push({
            id: nextId(),
            category: cat,
            text: '',
            dateStart: '',
            dateEnd: ''
        });
        renderRows();
        applyFilters();
    });

    $('#btnResetAll').click(function() {
        rows = [];
        $('#tableSearch').val('');
        renderRows();
        applyFilters();
    });

    // ===== 8. UPDATE ALL DATES FUNCTION =====
    function updateAllDates() {
        document.querySelectorAll('#tabelSurat td:nth-child(7)').forEach(td => {
            const originalDate = td.textContent.trim();
            if (originalDate && originalDate !== '-') {
                const formattedDate = formatTanggalIndonesia(originalDate);
                if (formattedDate !== originalDate) {
                    td.textContent = formattedDate;
                }
            }
        });
    }

    // ===== 9. SUCCESS MODAL TRIGGER =====
    <?php if($this->session->flashdata('added_items')): ?>
        setTimeout(function() {
            const addedItems = <?= json_encode($this->session->flashdata('added_items')) ?>;
            const isSingleAdd = <?= json_encode($this->session->flashdata('is_single_add')) ? true : false ?>;
            
            // Tampilkan modal success
            showSuccessAddModal(addedItems.length, addedItems, isSingleAdd);
            
            // Hapus session flashdata
            <?php $this->session->unset_userdata('added_items'); ?>
            <?php $this->session->unset_userdata('is_single_add'); ?>
        }, 1000);
    <?php endif; ?>
    
    <?php if($this->session->flashdata('edited_items')): ?>
        setTimeout(function() {
            const editedItems = <?= json_encode($this->session->flashdata('edited_items')) ?>;
            const isSingleEdit = <?= json_encode($this->session->flashdata('is_single_edit')) ?>;
            showSuccessEditModal(editedItems.length, editedItems, isSingleEdit);
        }, 800);
    <?php endif; ?>

    // ===== 10. MULTI-SELECT FUNCTIONALITY =====
    let selectedIds = [];

    function updateMultiActions() {
        selectedIds = [];
        $('.row-checkbox:checked').each(function() {
            selectedIds.push($(this).data('id'));
        });

        $('#selectedCount').text(selectedIds.length);

        // Sembunyikan multi actions
        $('#multiActions').removeClass('show');

        const totalCheckboxes = $('.row-checkbox').length;
        const checkedCheckboxes = $('.row-checkbox:checked').length;
        $('#checkAll').prop('checked', totalCheckboxes === checkedCheckboxes && totalCheckboxes > 0);
    }

    $('#checkAll').on('change', function() {
        const isChecked = $(this).is(':checked');
        $('.row-checkbox').prop('checked', isChecked);
        if (isChecked) {
            $('tr.row-detail').addClass('selected');
        } else {
            $('tr.row-detail').removeClass('selected');
        }
        updateMultiActions();
    });

    $(document).on('change', '.row-checkbox', function(e) {
        e.stopPropagation();
        const $row = $(this).closest('tr');
        if ($(this).is(':checked')) {
            $row.addClass('selected');
        } else {
            $row.removeClass('selected');
        }
        updateMultiActions();
    });

    $(document).on('click', '.row-checkbox', function(e) {
        e.stopPropagation();
    });

    // ===== 11. STATUS MODAL FUNCTIONALITY =====
    // Tampilkan modal dan load data
    window.showStatusModal = function(suratId) {
        const modal = document.getElementById('statusModal');
        modal.style.display = 'flex';
        modal.style.zIndex = '1080';

        resetAllStatus();
        loadStatusData(suratId);
    };

    // Reset seluruh tampilan sebelum load data baru
    function resetAllStatus() {
        for (let i = 1; i <= 4; i++) {
            const step = document.getElementById(`step${i}`);
            const icon = document.getElementById(`step${i}-icon`);
            const text = document.getElementById(`step${i}-text`);
            const date = document.getElementById(`step${i}-date`);
            const estimasi = document.getElementById(`est${i}`);

            step.className = 'progress-step pending';
            icon.className = 'fas fa-clock';

            const defaultTexts = [
                'Mengirim',
                'Disetujui Kaprodi',
                'Disetujui Sekretariat',
                'Disetujui Dekan'
            ];
            text.textContent = defaultTexts[i - 1];
            date.textContent = '-';
            estimasi.textContent = '0 hari 0 jam';
        }

        document.getElementById('progressLine').style.width = '0%';

        // Reset informasi status
        const desc = document.getElementById("status-description");
        desc.textContent = "Memuat informasi status...";
        desc.style.color = "black";
    }

    // Load status dari server (AJAX)
    function loadStatusData(suratId) {
        fetch(baseUrl + '/surat/get_status/' + suratId)
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

            textElement.textContent = step.step_name || step.text;
            dateElement.textContent = step.date || '-';
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
        } else if (finalStatus.includes("ditolak")) {
            desc.textContent = "Pengajuan ini tidak disetujui.";
            desc.style.color = "red";
        } else {
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

        document.getElementById("est1").textContent = d.durasi_1 || "0 hari 0 jam";
        document.getElementById("est2").textContent = d.durasi_2 || "0 hari 0 jam";
        document.getElementById("est3").textContent = d.durasi_3 || "0 hari 0 jam";
        document.getElementById("est4").textContent = d.durasi_4 || "0 hari 0 jam";
    }

    // EVENT: CLOSE MODAL
    document.addEventListener('DOMContentLoaded', function() {
        const closeBtn = document.querySelector('.close-status');
        const modal = document.getElementById('statusModal');

        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                modal.style.display = 'none';
                modal.style.zIndex = '';
            });
        }
    });

    // ===== 12. FUNGSI ALERT UNTUK BUTTON DISABLED =====
    window.showEditAlert = function(status) {
        Swal.fire({
            icon: 'warning',
            title: 'Edit Tidak Diizinkan',
            html: `
            <p>Tombol edit hanya dapat digunakan untuk surat yang <strong>ditolak</strong>.</p>
            <div style="background: #f8f9fa; padding: 10px; border-radius: 8px; margin-top: 10px;">
                <strong>Status surat ini:</strong> ${status}
            </div>
            <div style="margin-top: 15px; font-size: 14px; color: #6c757d;">
                <i class="fas fa-info-circle"></i> Hanya surat yang ditolak yang dapat diedit dan diajukan ulang.
            </div>
        `,
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#FB8C00'
        });
    };

    window.showPrintAlert = function(status) {
        Swal.fire({
            icon: 'warning',
            title: 'Cetak Tidak Diizinkan',
            html: `
            <p>Tombol cetak hanya dapat digunakan untuk surat yang sudah <strong>disetujui dekan</strong>.</p>
            <div style="background: #f8f9fa; padding: 10px; border-radius: 8px; margin-top: 10px;">
                <strong>Status surat ini:</strong> ${status}
            </div>
            <div style="margin-top: 15px; font-size: 14px; color: #6c757d;">
                <i class="fas fa-info-circle"></i> Silakan tunggu persetujuan dekan terlebih dahulu.
            </div>
        `,
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#FB8C00'
        });
    };

    // ===== 13. DETAIL MODAL FUNCTIONALITY =====
    $('#tabelSurat tbody').on('click', 'tr.row-detail', function(e) {
        // Mencegah trigger jika klik di kolom nama dosen
        if ($(e.target).closest('.dosen-container').length) {
            return;
        }

        if ($(e.target).closest('input, a, button').length) return;

        let raw = $(this).attr('data-detail') || '{}';
        let data = {};
        try {
            data = JSON.parse(raw);
        } catch (err) {
            console.error(err);
        }
        
        // Fungsi untuk menentukan jenis penugasan
        const getJenisPenugasanDisplay = function(data) {
            const jenisPengajuan = data.jenis_pengajuan || 'Perorangan';
            const jenisPenugasanPerorangan = data.jenis_penugasan_perorangan || '-';
            const jenisPenugasanKelompok = data.jenis_penugasan_kelompok || '-';
            const penugasanLainnyaPerorangan = data.penugasan_lainnya_perorangan || '-';
            const penugasanLainnyaKelompok = data.penugasan_lainnya_kelompok || '-';
            
            // Jika jenis pengajuan Perorangan
            if (jenisPengajuan === 'Perorangan') {
                if (jenisPenugasanPerorangan === 'Lainnya' && penugasanLainnyaPerorangan !== '-') {
                    return penugasanLainnyaPerorangan;
                }
                return jenisPenugasanPerorangan;
            }
            
            // Jika jenis pengajuan Kelompok
            if (jenisPengajuan === 'Kelompok') {
                if (jenisPenugasanKelompok === 'Lainnya' && penugasanLainnyaKelompok !== '-') {
                    return penugasanLainnyaKelompok;
                }
                return jenisPenugasanKelompok;
            }
            
            // Fallback
            return jenisPenugasanPerorangan || jenisPenugasanKelompok || '-';
        };

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
            <div class="detail-label">Tanggal Kegiatan</div>
            <div class="detail-value">${
                data.jenis_date === 'Periode' 
                    ? `<span class="badge" style="background: #e3f2fd; color: #1976d2; padding: 6px 12px; border-radius: 15px; font-size: 12px; font-weight: 600;">
                        <i class="fas fa-calendar-alt"></i> ${escapeHtml(data.periode_value || '-')}
                    </span>`
                    : formatTanggalIndonesia(data.tanggal_kegiatan || data.tanggal_awal_kegiatan || '-')
            }</div>
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
        <div class="detail-value">${escapeHtml(getJenisPenugasanDisplay(data))}</div>
    </div>  
            
            <div class="detail-row">
                <div class="detail-label">Status</div>
                <div class="detail-value">${escapeHtml(data.status || '-')}</div>
            </div>
        </div>
    `;

        // === Dosen Section ===
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
                <div class="dosen-item-detail">
                    <div class="dosen-avatar">${initial}</div>
                    <div class="dosen-info">
                        <div class="dosen-name-detail">${escapeHtml(nama)}</div>
                        <div class="dosen-details-detail">
                            NIP: ${escapeHtml(nip)} | Jabatan: ${escapeHtml(jabatan)} | Divisi: ${escapeHtml(divisi)}
                        </div>
                    </div>
                </div>
            `;
            });

            html += `</div></div>`;
        }

        // === File Evidence Section ===
        if (data.eviden && Array.isArray(data.eviden) && data.eviden.length > 0) {
            html += `
            <div class="detail-section">
                <div class="detail-section-title">
                    <i class="fas fa-file-alt"></i>
                    File Evidence (${data.eviden.length} file)
                </div>
                <div class="file-list">
        `;

            data.eviden.forEach((file, index) => {
                const fileName = getFileName(file);
                const fileUrl = getFileUrl(file);
                const fileIcon = getFileIcon(fileName);
                const fileType = getPreviewableFileType(fileName);
                const canPreview = fileType !== 'unknown';

                // Get file extension for display
                const fileExt = fileName.split('.').pop().toUpperCase() || 'FILE';

                html += `
                <div class="file-item">
                    <div class="${fileIcon}"></div>
                    <div class="file-info">
                        <div class="file-name" title="${escapeHtml(fileName)}">${escapeHtml(fileName)}</div>
                        <div class="file-details">
                            <span class="file-type">${fileExt}</span>
                            <span class="file-size">File ${index + 1}</span>
                        </div>
                    </div>
                    <div class="file-actions">
                        ${canPreview ? `
                            <button class="preview-btn" onclick="previewFile('${escapeHtml(fileUrl)}', '${escapeHtml(fileName)}', '${fileType}')">
                                <i class="fas fa-eye"></i> Preview
                            </button>
                        ` : `
                            <button class="preview-btn disabled" disabled title="Preview tidak tersedia untuk file ini">
                                <i class="fas fa-eye-slash"></i> Preview
                            </button>
                        `}
                    </div>
                </div>
            `;
            });

            html += `</div></div>`;
        } else {
            // Tampilkan pesan jika tidak ada file
            html += `
            <div class="detail-section">
                <div class="detail-section-title">
                    <i class="fas fa-file-alt"></i>
                    File Evidence
                </div>
                <div class="no-files">
                    <i class="fas fa-file-exclamation"></i>
                    <h4>Tidak Ada File Evidence</h4>
                    <p>Belum ada file yang diupload untuk pengajuan ini.</p>
                </div>
            </div>
        `;
        }

        $('#detailContent').html(html);
        const modalDetail = $('#modalDetail');
        modalDetail.addClass('show');
        modalDetail.css('z-index', '1050');
    });

    // ===== 14. FILE PREVIEW FUNCTIONS =====
    // Function untuk mendapatkan file icon berdasarkan tipe file
    function getFileIcon(filename) {
        if (!filename) return 'fas fa-file file-icon-unknown';

        const ext = filename.split('.').pop().toLowerCase();
        const iconMap = {
            // PDF
            'pdf': 'fas fa-file-pdf file-icon-pdf',
            // Images
            'jpg': 'fas fa-file-image file-icon-image',
            'jpeg': 'fas fa-file-image file-icon-image',
            'png': 'fas fa-file-image file-icon-image',
            'gif': 'fas fa-file-image file-icon-image',
            'bmp': 'fas fa-file-image file-icon-image',
            'webp': 'fas fa-file-image file-icon-image',
            'svg': 'fas fa-file-image file-icon-image',
            // Documents
            'doc': 'fas fa-file-word file-icon-doc',
            'docx': 'fas fa-file-word file-icon-doc',
            // Spreadsheets
            'xls': 'fas fa-file-excel file-icon-xls',
            'xlsx': 'fas fa-file-excel file-icon-xls',
            // Presentations
            'ppt': 'fas fa-file-powerpoint file-icon-ppt',
            'pptx': 'fas fa-file-powerpoint file-icon-ppt',
            // Archives
            'zip': 'fas fa-file-archive file-icon-zip',
            'rar': 'fas fa-file-archive file-icon-zip',
            '7z': 'fas fa-file-archive file-icon-zip',
            'tar': 'fas fa-file-archive file-icon-zip',
            'gz': 'fas fa-file-archive file-icon-zip'
        };

        return iconMap[ext] || 'fas fa-file file-icon-unknown';
    }

    // Function untuk mendapatkan tipe file yang bisa dipreview
    function getPreviewableFileType(filename) {
        if (!filename) return 'unknown';

        const ext = filename.split('.').pop().toLowerCase();
        const imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
        const documentTypes = ['pdf'];

        if (imageTypes.includes(ext)) return 'image';
        if (documentTypes.includes(ext)) return 'document';
        return 'unknown';
    }

    // Function untuk mendapatkan nama file dari URL atau object
    function getFileName(file) {
        if (typeof file === 'string') {
            return file.split('/').pop().split('?')[0] || 'File';
        } else if (typeof file === 'object' && file !== null) {
            return file.name || file.nama_asli || (file.url ? file.url.split('/').pop().split('?')[0] : 'File');
        }
        return 'File';
    }

    // Function untuk mendapatkan URL file
    function getFileUrl(file, baseUrl = BASE_URL) {
        let url = '';

        // Jika tipe string = nama file → tambahkan folder uploads/eviden
        if (typeof file === 'string') {
            url = baseUrl + '/uploads/eviden/' + file;
            return url;
        }

        // Jika object (dropzone) → pakai url bawaan
        if (typeof file === 'object' && file !== null) {
            url = file.cdnUrl || file.url || file.path || '';
        }

        // Fix URL jika tidak lengkap
        if (url && !url.match(/^https?:\/\//i) && !url.startsWith('data:')) {
            url = baseUrl + (url.startsWith('/') ? '' : '/') + url;
        }

        return url;
    }

    // Fungsi untuk preview file
    window.previewFile = function(fileUrl, fileName, fileType) {
        const previewModal = $('#previewModal');
        const previewTitle = $('#previewTitle');
        const previewBody = $('#previewBody');

        previewTitle.text('Preview: ' + fileName);
        previewBody.empty();

        // Tampilkan loading
        previewBody.html(`
        <div style="text-align: center; padding: 40px;">
            <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #FB8C00;"></i>
            <p style="margin-top: 15px; color: #6c757d;">Memuat preview...</p>
        </div>
    `);

        previewModal.addClass('show');
        previewModal.css('z-index', '1070');

        // Set timeout untuk memastikan modal sudah terbuka
        setTimeout(() => {
            if (fileType === 'image') {
                // Preview gambar
                const img = new Image();
                img.onload = function() {
                    previewBody.html(`<img src="${fileUrl}" class="preview-image" alt="${fileName}">`);
                };
                img.onerror = function() {
                    showUnsupportedPreview(previewBody, fileUrl, fileName);
                };
                img.src = fileUrl;
            } else if (fileType === 'document') {
                // Preview PDF
                previewBody.html(`
                <iframe 
                    src="${fileUrl}" 
                    class="preview-iframe" 
                    frameborder="0"
                    onload="this.style.visibility='visible'"
                    onerror="this.style.visibility='hidden'; document.getElementById('pdf-fallback').style.display='block'"
                ></iframe>
                <div id="pdf-fallback" style="display: none;">
                    ${showUnsupportedPreview(previewBody, fileUrl, fileName)}
                </div>
            `);
            } else {
                showUnsupportedPreview(previewBody, fileUrl, fileName);
            }
        }, 100);
    };

    function showUnsupportedPreview(previewBody, fileUrl, fileName) {
        previewBody.html(`
        <div class="preview-unsupported">
            <i class="fas fa-eye-slash"></i>
            <h4>Preview Tidak Tersedia</h4>
            <p>File "${escapeHtml(fileName)}" tidak dapat dipreview di browser.</p>
            <p style="font-size: 14px; color: #6c757d; margin-top: 10px;">
                Silakan download file untuk melihat isinya.
            </p>
            <a href="${fileUrl}" class="download-btn" download="${fileName}" target="_blank" style="margin-top: 15px;">
                <i class="fas fa-download"></i> Download File
            </a>
        </div>
    `);
    }

    // Close modals dengan reset z-index
    $('.close-modal').click(function() {
        const modalDetail = $('#modalDetail');
        modalDetail.removeClass('show');
        modalDetail.css('z-index', '');
    });

    $('.preview-close').click(function() {
        const previewModal = $('#previewModal');
        previewModal.removeClass('show');
        previewModal.css('z-index', '');
    });

    // Prevent download link dari menutup modal
    $(document).on('click', '.download-btn, .preview-btn', function(e) {
        e.stopPropagation();
    });
});

// ============================================
// SUCCESS MODAL FUNCTIONS UNTUK TAMBAH
// ============================================
function showSuccessAddModal(count, items, isSingle = false) {
    const modal = document.getElementById('successModal');
    const timestamp = document.getElementById('successTimestamp');
    const itemCount = document.getElementById('successItemCount');
    const listContainer = document.getElementById('successList');
    
    // Format timestamp
    const now = new Date();
    timestamp.textContent = now.toLocaleDateString('id-ID', { 
        day: '2-digit', 
        month: 'long', 
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }) + ' WIB';
    
    itemCount.textContent = `${count} item`;
    
    // Populate list dengan data
    listContainer.innerHTML = '';
    
    items.forEach((item, index) => {
        const itemDiv = document.createElement('div');
        itemDiv.style.cssText = 'background:white;border:1px solid #c3e6cb;border-radius:10px;margin-bottom:12px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.05)';
        
        // Generate HTML untuk dosen jika ada data
        const dosenHtml = generateDosenHtmlForSuccessModal(item.dosen_data || []);
        
        itemDiv.innerHTML = `
            <div style="display:flex;align-items:center;gap:12px;padding:15px;border-bottom:1px solid #f0f0f0;background:#f0fdf4;">
                <div style="width:40px;height:40px;border-radius:50%;background:#27ae60;color:white;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">
                    <i class="fas fa-check"></i>
                </div>
                <div style="flex:1;text-align:left">
                    <div style="font-weight:700;color:#212529;font-size:15px;margin-bottom:3px">${escapeHtml(item.nama)}</div>
                    <div style="font-size:13px;color:#6c757d">${item.details}</div>
                </div>
                <span style="background:#27ae60;color:white;padding:6px 14px;border-radius:20px;font-size:12px;font-weight:600;flex-shrink:0">
                    Pengajuan
                </span>
            </div>
            ${dosenHtml}
        `;
        listContainer.appendChild(itemDiv);
    });
    
    modal.classList.add('show');
}

// Fungsi untuk refresh halaman
function refreshPage() {
    window.location.reload();
}
</script>
<!-- ===== SUCCESS MODAL SETELAH SUBMIT ===== -->
<div id="successModal" class="modal">
    <div class="bulk-modal-content" onclick="event.stopPropagation()" style="max-width: 600px;">
        <div class="modal-header" style="background: #27ae60;">
            <h3><i class="fa-solid fa-circle-check"></i> Pengajuan Berhasil Dibuat</h3>
            <button class="close-modal" onclick="closeModal('successModal')">&times;</button>
        </div>
        <div style="padding:25px;text-align:center">
            <div style="width:100px;height:100px;border-radius:50%;background:#d4edda;margin:0 auto 20px;display:flex;align-items:center;justify-content:center">
                <i class="fas fa-check" style="font-size:50px;color:#27ae60"></i>
            </div>
            
            <h3 style="color:#27ae60;margin-bottom:10px">Berhasil Dibuat</h3>
            <p style="color:#666;margin-bottom:5px">
                <i class="fa-solid fa-clock"></i> Dibuat pada: <strong id="successTimestamp">-</strong>
            </p>
            
            <div style="background:#d4edda;border:1px solid #c3e6cb;border-radius:8px;padding:15px;margin:20px 0">
                <div style="font-weight:600;color:#155724;margin-bottom:10px;display:flex;align-items:center;justify-content:space-between">
                    <span>Daftar Pengajuan</span>
                    <span id="successItemCount" style="background:#27ae60;color:white;padding:4px 12px;border-radius:20px;font-size:12px">1 item</span>
                </div>
                <div id="successList" style="max-height:250px;overflow-y:auto;text-align:left">
                    <!-- List akan diisi oleh JavaScript -->
                </div>
            </div>
            
            <!-- Dosen Section -->
            <div id="successDosenSection" style="display:none;">
                <!-- Akan diisi oleh JavaScript -->
            </div>
            
            <div style="display:flex;gap:10px;justify-content:center;margin-top:20px">

                <button class="btn-bulk" onclick="closeModal('successModal')" style="background:#6c757d;color:white;padding:10px 24px;border:none;border-radius:6px;cursor:pointer;font-weight:600;display:flex;align-items:center;gap:6px">
                    <i class="fa-solid fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
</body>
</html>