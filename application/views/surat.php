<!DOCTYPE html>
<html lang="en-id">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>pic kk</title>

    <!-- Bootstrap & Nice Select -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/jquery-nice-select@1.1.0/css/nice-select.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Lab. FIK Main Style -->
    <link rel="stylesheet" href="https://ifik.telkomuniversity.ac.id/assets/css/style.css">

    <!-- Google Fonts - Sama seperti views kedua -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- JQuery 3.3.1 -->
    <script src="https://ifik.telkomuniversity.ac.id/assets/vendor/jquery.min.js"></script>

    <link rel="stylesheet" href="https://ifik.telkomuniversity.ac.id/assets/vendor/fontawesome-free-5.13.0-web/css/all.min.css">

    <!-- JS Vendor -->
    <script src="https://ifik.telkomuniversity.ac.id/assets/vendor/owl-carousel/owl.carousel.min.js"></script>
    <script type="text/javascript" src="https://ifik.telkomuniversity.ac.id/assets/js/booking.js"></script>
    <link rel="icon" href="https://ifik.telkomuniversity.ac.id/assets/img/logo/favicon.png" type="image/gif">

    <style>
        body {
            background-color: #f6f9fb;
            font-family: 'Poppins', sans-serif;
        }

        .multi-step-form {
            max-width: 700px;
            margin: 50px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            padding: 35px;
            position: relative;
            overflow: hidden;
            font-family: 'Poppins', sans-serif;
        }

        /* Progressbar container */
        .progress-container {
            position: relative;
            height: 8px;
            background-color: #e9ecef;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .progress-bar-animated {
            position: absolute;
            height: 8px;
            background: #FB8C00;
            width: 0%;
            border-radius: 5px;
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Step animation */
        fieldset {
            display: none;
            border: none;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        fieldset.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .action-btn {
            background: #FB8C00;
            color: #fff;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
        }

        .action-btn:hover {
            background: #FB8C00;
        }

        .btn-secondary {
            border: 1px solid #ccc;
            background: transparent;
            color: #555;
            font-family: 'Poppins', sans-serif;
        }

        .btn-secondary:hover {
            background: #FB8C00;
            color: #fff;
            border-color: #FB8C00;
        }

        .nice-select {
            width: 100%;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--bs-body-color, #333);
            background-color: var(--bs-body-bg, #fff);
            background-clip: padding-box;
            border: var(--bs-border-width, 1px) solid var(--bs-border-color, #d1d5db);
            border-radius: var(--bs-border-radius, 8px);
            padding: .375rem .75rem;
            
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out, all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .nice-select.open {
            border-color: #FB8C00;
            box-shadow: 0 0 0 0.2rem rgba(92, 184, 92, 0.25);
        }

        .nice-select .list {
            border-radius: 8px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            border-color: #e5e7eb;
            font-family: 'Poppins', sans-serif;
        }

        .nice-select .option.focus,
        .nice-select .option.selected.focus {
            background-color: #FB8C00;
            color: #fff;
        }

        .step-counter {
            text-align: right;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 15px;
            font-family: 'Poppins', sans-serif;
        }

        /* Static button area inside form */
        .button-area {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            gap: 15px;
            position: relative;
        }

        @media (max-width: 575px) {
            .button-area {
                flex-direction: column;
                align-items: center;
            }
        }

        /* Font untuk semua elemen - sama seperti views kedua */
        h1, h2, h3, h4, h5, h6, p, span, div, input, textarea, select, button, label, a {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Font untuk navbar */
        .navbar, .fik-navbar-menu, .fik-username, .fik-login-dropdown, .dropdown-menu {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Font untuk modal */
        .modal, .modal-title, .modal-body, .modal-footer {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Font untuk side menu */
        .fik-db-side-menu, .card, .btn {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Font untuk form */
        .custom-form, .form-group, .form-control, .form-check, .form-check-label {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Font untuk table */
        table, th, td, .table, .badge {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Font untuk footer */
        .footer, .fik-footer, .credit {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Form group styling */
        .form-group { 
            margin-bottom: 20px; 
        }

        /* wrapper periode */
        #periode_section {
            position: relative;
            z-index: 9999 !important;
            transition: margin-bottom 0.3s ease;
        }

        /* dropdown nice-select */
        .nice-select {
            z-index: 99999 !important;
        }

        /* dropdown saat open = paling depan */
        .nice-select.open {
            z-index: 999999 !important;
        }

        /* Tambah margin yang lebih besar saat dropdown dibuka */
        #periode_section.open-margin {
            margin-bottom: 250px !important;
        }

        /* Tambah padding bottom untuk memberikan ruang lebih */
        #periode_section .nice-select.open + .list {
            margin-bottom: 20px;
        }

        /* sembunyikan select asli */
        .has-select select.nice-original {
          display: none !important;
        }

        /* Pastikan list dropdown tidak terpotong */
        .nice-select .list {
            max-height: 200px;
            overflow-y: auto;
        }

        /* Animasi smooth untuk spacing */
        #periode_section {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Style untuk error message */
        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .form-group.has-error input {
            border-color: #dc3545;
        }

        /* Style untuk info message */
        .info-message {
            color: #0d6efd;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        /* Style untuk success message */
        .success-message {
            color: #198754;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        /* Style untuk disabled dates di datepicker */
        .ui-datepicker td.ui-state-disabled {
            opacity: 0.3;
        }

        .ui-datepicker td.ui-state-disabled span {
            cursor: not-allowed !important;
        }

        /* Highlight untuk tanggal yang valid */
        .ui-datepicker td.valid-date a {
            background-color: #e8f5e8 !important;
            color: #198754 !important;
            font-weight: bold;
        }

        /* Style untuk tanggal yang melebihi batas */
        .ui-datepicker td.over-limit-date a {
            background-color: #fff3cd !important;
            color: #856404 !important;
            text-decoration: line-through;
        }

        /* tambahan visual warning kelas */
        .ui-datepicker td.warning a {
            box-shadow: 0 0 0 1px #ffc107 inset;
        }

        /* Style untuk tanggal yang benar-benar tidak bisa dipilih */
        .ui-datepicker td.force-disabled a {
            background-color: #f8d7da !important;
            color: #721c24 !important;
            text-decoration: line-through;
            cursor: not-allowed !important;
        }

        /* Button cell styling */
        .button-cell { display: none; justify-content: center; align-items: center; }
        .add-row-btn, .remove-row-btn { width: 35px; height: 35px; border-radius: 50%; padding: 0; }
        .panitia-row { transition: all 0.3s ease; opacity: 1; transform: translateY(0); }
        .panitia-row.removing { opacity: 0; transform: translateX(20px); }

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
            font-family: 'Poppins', sans-serif;
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
        }

        .autocomplete-item:first-child {
            border-left: 3px solid #1a73e8;
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

        .multi-step-form, fieldset, .container {
            overflow: visible !important;
        }

        /* Perbaikan untuk tampilan form */
        .form-group.has-select {
            margin-bottom: 1rem;
        }

        .form-control.custom-form-control {
            margin-top: 12px;
        }

        .panitia-row {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .panitia-row:last-child {
            border-bottom: none;
        }
        /* PERBAIKAN FONT AWESOME */
.fas, .far, .fab, .fa {
    font-family: "Font Awesome 6 Free" !important;
    font-weight: 900;
}

/* Pastikan icon tidak disembunyikan */
[class*="fa-"]:before {
    display: inline-block;
    font-style: normal;
    font-variant: normal;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
}

/* Override any hiding styles */
i[class*="fa-"] {
    display: inline-block !important;
    opacity: 1 !important;
    visibility: visible !important;
}

/* Icon colors untuk berbagai konteks */
.input-group-text i {
    color: #6c757d;
    width: 16px;
}

.btn i {
    margin-right: 5px;
}

.step-counter i {
    color: #FB8C00;

}
/* ===== LOADING SCREEN ===== */
.loading-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.85);
    z-index: 999999;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

.loading-overlay.active {
    display: flex;
    animation: fadeIn 0.3s ease;
}

.loading-spinner {
    width: 60px;
    height: 60px;
    border: 5px solid rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    border-top-color: #FB8C00;
    animation: spin 1s linear infinite;
    margin-bottom: 20px;
}

.loading-text {
    color: white;
    font-size: 18px;
    font-weight: 600;
    margin-top: 20px;
    text-align: center;
}

.loading-details {
    color: rgba(255, 255, 255, 0.8);
    font-size: 14px;
    margin-top: 10px;
    text-align: center;
    max-width: 400px;
    line-height: 1.5;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
    </style>
</head>

<body>
    <nav class="navbar fixed-top">
        <div class="container loss">
            <a class="db-menu-trigger show-mobile"><span class="fas fa-th-large"></span></a>
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

    <div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Logout</h5>
                </div>
                <div class="modal-body">
                    Anda yakin akan keluar?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" onclick="location.href='https://ifik.telkomuniversity.ac.id/auth/logout';" class="btn btn-primary">Keluar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="fik-db-side-menu">
        <div id="accordion">
            <div class="card show-mobile profil">
                <div class="img-wrapper">
                    <img src="https://ifik.telkomuniversity.ac.id/assets/img/profile/default.jpg">
                </div>
                <b>PIC MEDCRAFT</b>
                <span>pic kk</span>
            </div>
             <!-- FONT AWESOME - HARUS DITARUH DI ATAS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer">

            <div class="divider show-mobile" style="margin-top:20px"></div>
            <div class="card">
                <a href="<?= base_url('list-surat-tugas') ?>" class="btn"><span class="fas fa-palette"></span> List Surat Tugas</a>
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

    <div class="modal fade" id="termcondition" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        <p><a href="#"><u>Ketentuan Peminjaman</u></a></p>
                    </h5>
                </div>
                <div class="modal-body">
                    <ol>
                        <div style="margin-left:20px;margin-bottom:10px;"><b>
                                <li>Peminjaman melalui Ifik hanya booking ruangan </li>
                            </b></div>
                        <div style="margin-left:20px;margin-bottom:10px;"><b>
                                <li>Teknis dan operasional silahkan menghubungi Bpk. Yayan (081219639375)</li>
                            </b></div>
                        <div style="margin-left:20px;margin-bottom:10px;"><b>
                                <li>Pengajuan peminjaman ruangan minimal 3 hari sebelum pelaksanaan kegiatan </li>
                            </b></div>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button data-toggle="modal" type="button" data-target="#makebooking" class="btn btn-primary">Dimengerti dan Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>


    <!-- End Side Menu -->
    <div class="modal fade" id="makebooking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog wide" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Buat Peminjaman</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="https://ifik.telkomuniversity.ac.id/booking/bookingplace" method="POST" enctype="multipart/form-data">
                        <div class="custom-form">
                            <div class="form-group" style="margin-bottom:12px">
                                <input type="text" name="name" class="form-control" placeholder="" required="required" value="PIC MEDCRAFT" autocomplete="off" />
                                <label>Nama Lengkap</label>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="id_ruangan" id="ruangan" onchange="disablemodals()" disabled required>
                                    <option disabled selected>Pilih Ruangan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <textarea name="keterangan" class="form-control" placeholder="" required="required" autocomplete="off"></textarea>
                                <label>Keterangan</label>
                            </div>
                            <div class="form-group">
                                <input type="date" name="tanggal" id="tanggal" onchange="Bookingmodals()" class="form-control" disabled placeholder="" required="required" autocomplete="off" />
                                <label>Tanggal Peminjaman</label>
                            </div>
                            <div class="form-group" style="margin-bottom:0">
                                <div class="form-control waktu">Waktu</div>
                            </div>
                        </div><br>
                        <div class="jadwal-ruangan" id="jadwal">
                            <table border="0" class="table bookings" id="booking">
                                <tbody>
                                    <tr class="display" style="background:transparent">
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" name="id_peminjam" class="form-control" placeholder="" value="632045c808b1c" required="required" autocomplete="off" />
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-pill btn-sm" id="createbookingmodals">Kirim Permintaan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="maketicketing" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog wide" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Buat Ticketing</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="https://ifik.telkomuniversity.ac.id/pic_kk/input_ticketing" method="POST" enctype="multipart/form-data">
                        <div class="custom-form">
                            <div class="form-group" style="margin-bottom:12px">
                                <input type="text" name="name" class="form-control" placeholder="" required="required" value="PIC MEDCRAFT" autocomplete="off" />
                                <label>Nama Lengkap</label>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="sub_kategori" id="kategori_ticketing" onchange="disablemodals()" disabled required>
                                    <option disabled selected>Pilih Kategori</option>
                                </select>
                            </div>
                            <div style="padding:10px" id="keuangan">
                                <label><b>Kelengkapan dokumen yang wajib di upload</b></label><br>
                                <div class="form-check">
                                    <input type="checkbox" id="fenomena" name="kelayakan2[]" value="">
                                    <label for="fenomena">Daftar honor mengajar per Prodi yang di generate oleh LAA per tgl 15 setiap bulannya</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="identifikasi" name="kelayakan2[]" value="">
                                    <label for="identifikasi">Rekap Kehadiran Dosen LB</label>
                                </div>
                            </div>
                            <div style="padding:10px" id="keuangan2">
                                <div class="form-check">
                                    <input type="checkbox" id="justifikasi" name="kelayakan2[]" value="">
                                    <label for="justifikasi">Form Justifikasi/Proposal Kegiatan (Sudah lengkap ttd basah/Asli)</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="undangan_kesediaan" name="kelayakan2[]" value="">
                                    <label for="undangan_kesediaan">Undangan kesediaan sebagai pembicara / narasumber</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="undangan_peserta" name="kelayakan2[]" value="">
                                    <label for="undangan_peserta">Surat undangan peserta / poster kegiatan</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="ftcp_narsum" name="kelayakan2[]" value="">
                                    <label for="ftcp_narsum">Fotocopy Materi</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="cv_pembicara" name="kelayakan2[]" value="">
                                    <label for="cv_pembicara">CV Pembicara / narasumber</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="ftcp_npwp_narsum" name="kelayakan2[]" value="">
                                    <label for="ftcp_npwp_narsum">Fotocopy NPWP Pembicara / narasumber</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="daftar_hadir_narsum" name="kelayakan2[]" value="">
                                    <label for="daftar_hadir_narsum">Daftar hadir pembicara/narasumber ttd basah/asli (jika onsite), Screenshoot zoom (jika Online/Daring)</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="daftar_hadir_peserta" name="kelayakan2[]" value="">
                                    <label for="daftar_hadir_peserta">Daftar hadir peserta ttd basah/asli (jika onsite), screenshoot zoom (jika online/daring)</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="daftar_honor" name="kelayakan2[]" value="">
                                    <label for="daftar_honor">Daftar honor (Dikenakan potongan pajak, jika WNI dikenakan PPH PSL 21 sebesar 5%, Jika WNA dikenakan PPH PSL 26 sebesar 20%)</label>
                                </div>
                            </div>
                            <div style="padding:10px" id="keuangan3">
                                <div class="form-check">
                                    <input type="checkbox" id="undangan_rapat3" name="kelayakan2[]" value="">
                                    <label for="undangan_rapat3">Undangan Rapat</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="daftar_hadir_peserta3" name="kelayakan2[]" value="">
                                    <label for="daftar_hadir_peserta3">Daftar Hadir Peserta</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="konsumsi3" name="kelayakan2[]" value="">
                                    <label for="konsumsi3">Pembelian Konsumsi (Snack/Makan) harus melalui Kantin Tel-U</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="kuitansi3" name="kelayakan2[]" value="">
                                    <label for="kuitansi3">Kuitansi dan Struk/Nota/Bon/Invoice (lengkap ttd, nama, cap stempel )</label>
                                </div>
                            </div>
                            <div style="padding:10px" id="keuangan4">
                                <div class="form-check">
                                    <input type="checkbox" id="justifikasi4" name="kelayakan2[]" value="">
                                    <label for="justifikasi4">Form Justifikasi/Proposal Kegiatan (Sudah lengkap ttd basah/Asli)</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="nde_user_dekan4" name="kelayakan2[]" value="">
                                    <label for="nde_user_dekan4">NDE Ijin Kegiatan User ke Dekan</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="nde_dekan_warek4" name="kelayakan2[]" value="">
                                    <label for="nde_dekan_warek4">NDE Ijin Kegiatan Dekan ke Warek II</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="undangan_luar4" name="kelayakan2[]" value="">
                                    <label for="undangan_luar4">Undangan dari luar</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="surat_tugas4" name="kelayakan2[]" value="">
                                    <label for="surat_tugas4">Surat Tugas</label>
                                </div>
                            </div>
                            <div style="padding:10px" id="keuangan5">
                                <div class="form-check">
                                    <input type="checkbox" id="justifikasi5" name="kelayakan2[]" value="">
                                    <label for="justifikasi5">Justifikasi Pelatihan / Sertifikasi yang diketahui dan disetujui oleh Kaprodi, KK, Wadek II dan Dekan</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="surat_tugas5" name="kelayakan2[]" value="">
                                    <label for="surat_tugas5">Surat Tugas Dekan</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="penawaran5" name="kelayakan2[]" value="">
                                    <label for="penawaran5">Surat Penawaran/Poster</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="kuitansi5" name="kelayakan2[]" value="">
                                    <label for="kuitansi5">Kuitansi dan Struk/Nota/Bon/Invoice (lengkap ttd, nama, cap stempel )</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="surat_tugas_digitrain5" name="kelayakan2[]" value="">
                                    <label for="surat_tugas_digitrain5">Surat Tugas Digi-Train</label>
                                </div>
                            </div>
                            <div style="padding:10px" id="keuangan6">
                                <div class="form-check">
                                    <input type="checkbox" id="justifikasi6" name="kelayakan2[]" value="">
                                    <label for="justifikasi5">Form Justifikasi Pengadaan Barang/Proposal Kegiatan (Sudah lengkap ttd basah/Asli)</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="kuitansi6" name="kelayakan2[]" value="">
                                    <label for="kuitansi6">Kuitansi dan Struk/Nota/Bon/Invoice (lengkap ttd, nama, cap stempel )</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="ft_barang" name="kelayakan2[]" value="">
                                    <label for="ft_barang">Foto barang</label>
                                </div>
                            </div>
                            <div style="padding:10px" id="keuangan7">
                                <div class="form-check">
                                    <input type="checkbox" id="justifikasi7" name="kelayakan2[]" value="">
                                    <label for="justifikasi7">Form Justifikasi FIK/Proposal Kegiatan (Sudah lengkap ttd basah/Asli)</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="invoice7" name="kelayakan2[]" value="">
                                    <label for="invoice7">Invoice / Surat permohonan pembayaran</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="kuitansi7" name="kelayakan2[]" value="">
                                    <label for="kuitansi7">Kuitansi</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="npwp7" name="kelayakan2[]" value="">
                                    <label for="npwp7">NPWP Pihak ke-3</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="ba7" name="kelayakan2[]" value="">
                                    <label for="ba7">Berita Acara Serah Terima</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="ft_barang7" name="kelayakan2[]" value="">
                                    <label for="ft_barang7">Foto Sebelum dan Sesudah</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea name="isi_ticketing" class="mytextarea1"></textarea>
                                <label>Isi Ticket</label>
                            </div>
                            <div style="margin-bottom:12px">
                                <label for="eviden" style="margin-left: 16px;"><b>File Pendukung</b></label>
                                <input type="file" name="images[]" class="form-control" style="padding:13px 16px">
                                <span id="chk-error"></span>
                            </div>
                        </div>
                </div><br>
                <input type="hidden" name="id_user" class="form-control" placeholder="" value="632045c808b1c" required="required" autocomplete="off" />
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-pill btn-sm">Kirim Permintaan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#kategoriruanganmhs').change(function() {
                document.getElementById("ruangan").disabled = false;
                var id_kategori = $('#kategoriruanganmhs').val();

                if (id_kategori != '') {
                    $.ajax({
                        url: "https://ifik.telkomuniversity.ac.id/booking/fetchRuanganMhs",
                        method: "POST",
                        data: {
                            id_kategori: id_kategori
                        },
                        success: function(data) {
                            $('#ruangan').html(data);
                        }
                    })
                }
            });
            $('#kategoriruangandsn').change(function() {
                document.getElementById("ruangan").disabled = false;
                var id_kategori = $('#kategoriruangandsn').val();

                if (id_kategori != '') {
                    $.ajax({
                        url: "https://ifik.telkomuniversity.ac.id/booking/fetchRuanganDsn",
                        method: "POST",
                        data: {
                            id_kategori: id_kategori
                        },
                        success: function(data) {
                            $('#ruangan').html(data);
                        }
                    })
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#unit_mhs').change(function() {
                document.getElementById("kategori_ticketing").disabled = false;
                var id_kategori = $('#unit_mhs').val();

                if (id_kategori != '') {
                    $.ajax({
                        url: "https://ifik.telkomuniversity.ac.id/booking/fetchTicketingMhs",
                        method: "POST",
                        data: {
                            id_kategori: id_kategori
                        },
                        success: function(data) {
                            $('#kategori_ticketing').html(data);
                        }
                    })
                }
            });
            $('#unit_dosen').change(function() {
                document.getElementById("kategori_ticketing").disabled = false;
                var id_kategori = $('#unit_dosen').val();

                if (id_kategori != '') {
                    $.ajax({
                        url: "https://ifik.telkomuniversity.ac.id/booking/fetchTicketingDsn",
                        method: "POST",
                        data: {
                            id_kategori: id_kategori
                        },
                        success: function(data) {
                            $('#kategori_ticketing').html(data);
                        }
                    })
                }
            });
        });
        jQuery(function() {
            jQuery("#keuangan").hide()
            jQuery("#keuangan2").hide()
            jQuery("#keuangan3").hide()
            jQuery("#keuangan4").hide()
            jQuery("#keuangan5").hide()
            jQuery("#keuangan6").hide()
            jQuery("#keuangan7").hide()
            jQuery("#kategori_ticketing").change(function() {
                //  jQuery(this).val() == 'select' ? jQuery("#textarea").hide() : jQuery("#textarea").show();
                var value = jQuery(this).val();
                if (value == "Pertanggungan Honor Mengajar Dosen Luar Biasa (LB)") {
                    $("#keuangan").show();
                    $("#keuangan2").hide();
                    $("#keuangan3").hide();
                    $("#keuangan4").hide();
                    $("#keuangan5").hide();
                    $("#keuangan6").hide();
                    $("#keuangan7").hide();
                } else if (value == "Pertanggungan Honor Pembicara Tamu / Narasumber") {
                    $("#keuangan2").show();
                    $("#keuangan").hide();
                    $("#keuangan3").hide();
                    $("#keuangan4").hide();
                    $("#keuangan5").hide();
                    $("#keuangan6").hide();
                    $("#keuangan7").hide();
                } else if (value == "Pertanggungan Konsumsi (Snack/Makan)") {
                    $("#keuangan3").show();
                    $("#keuangan").hide();
                    $("#keuangan2").hide();
                    $("#keuangan4").hide();
                    $("#keuangan5").hide();
                    $("#keuangan6").hide();
                    $("#keuangan7").hide();
                } else if (value == "Pertanggungan SPPD") {
                    $("#keuangan4").show();
                    $("#keuangan").hide();
                    $("#keuangan2").hide();
                    $("#keuangan3").hide();
                    $("#keuangan5").hide();
                    $("#keuangan6").hide();
                    $("#keuangan7").hide();
                } else if (value == "Pertanggungan Biaya Pelatihan/Sertifikasi/Asosiasi") {
                    $("#keuangan5").show();
                    $("#keuangan").hide();
                    $("#keuangan2").hide();
                    $("#keuangan3").hide();
                    $("#keuangan4").hide();
                    $("#keuangan6").hide();
                    $("#keuangan7").hide();
                } else if (value == "Pertanggungan Pembelian Barang Habis Pakai") {
                    $("#keuangan6").show();
                    $("#keuangan").hide();
                    $("#keuangan2").hide();
                    $("#keuangan3").hide();
                    $("#keuangan4").hide();
                    $("#keuangan5").hide();
                    $("#keuangan7").hide();
                } else if (value == "Penggunaan Jasa Pihak ke 3 (Sewa, Pembuatan Barang, Maintenance)") {
                    $("#keuangan7").show();
                    $("#keuangan").hide();
                    $("#keuangan2").hide();
                    $("#keuangan3").hide();
                    $("#keuangan4").hide();
                    $("#keuangan5").hide();
                    $("#keuangan6").hide();
                } else {
                    jQuery("#keuangan").hide()
                    jQuery("#keuangan2").hide()
                    jQuery("#keuangan3").hide()
                    jQuery("#keuangan4").hide()
                    jQuery("#keuangan5").hide()
                    jQuery("#keuangan6").hide()
                    jQuery("#keuangan7").hide()
                }
            });
        });
    </script>

    <main class="akun-container">
        <div class="fik-section-title2"></div>
        <section class="multi-step-form">
            <form id="msform" method="post" action="<?php echo site_url('surat/submit'); ?>" enctype="multipart/form-data">

                <div class="text-center mb-4">
                    <h3>Verification Process</h3>
                    <p class="text-muted">Complete these steps to verify your account.</p>
                </div>

                <!-- Progress bar -->
                <div class="progress-container">
                    <div class="progress-bar-animated" id="progressBar"></div>
                </div>

                <div class="step-counter">
                    Step <span id="currentStep">1</span> of <span id="totalSteps">3</span>
                </div>
<!-- Step 1 -->
<fieldset class="active">
  <div class="custom-form" style="position: relative; z-index: 1;">
    <input type="hidden" name="user_id" id="user_id" value="632045c808b1c">

    <div class="form-group mb-4">
      <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" required autocomplete="off">
      <label>Nama Kegiatan</label>
    </div>

    <!-- Pilihan jenis tanggal -->
    <div class="form-group has-select mb-4">
      <select class="nice form-control" name="jenis_date" id="jenis_date" required>
        <option disabled selected value="">Tanggal Pengajuan</option>
        <option value="Periode">Periode</option>
        <option value="Custom">Custom</option>
      </select>
    </div>

    <!-- Form tanggal -->
    <div class="row">
      <div class="col-md-3 mt-3">
        <div class="form-group">
          <input type="text" name="tanggal_kegiatan" id="datepicker" class="form-control custom-form-control" required autocomplete="off" readonly>
          <label id="lbl_mulai">Mulai kegiatan</label>
        </div>
      </div>

      <div class="col-md-3 mt-3">
        <div class="form-group">
          <input type="text" name="akhir_kegiatan" id="datepicker2" class="form-control custom-form-control" required autocomplete="off" readonly>
          <label id="lbl_akhir">Berakhir kegiatan</label>
        </div>
      </div>

      <div class="col-md-3 mt-3">
        <div class="form-group">
          <input type="text" name="periode_penugasan" id="datepicker3" class="form-control custom-form-control" required autocomplete="off" readonly>
          <label id="lbl_mulai1">Periode Penugasan</label>
        </div>
      </div>

      <div class="col-md-3 mt-3">
        <div class="form-group">
          <input type="text" name="akhir_periode_penugasan" id="datepicker4" class="form-control custom-form-control" required autocomplete="off" readonly>
          <label id="lbl_akhir1">Akhir Penugasan</label>
        </div>
      </div>
    </div>

    <!-- Dropdown Periode -->
    <div id="periode_section" class="form-group has-select" style="display:none; position:relative; margin-top: 20px; margin-bottom: 60px;">
      <select class="nice form-control" name="periode_value" id="periode_value">
        <option disabled selected value="">Pilih Periode</option>
        <option value="2024/2025 Ganjil">2024/2025 Ganjil</option>
        <option value="2024/2025 Genap">2024/2025 Genap</option>
        <option value="2025/2026 Ganjil">2025/2026 Ganjil</option>
        <option value="2025/2026 Genap">2025/2026 Genap</option>
      </select>
    </div>

    <!-- Form lainnya -->
    <div class="form-group mb-4">
      <input type="text" name="tempat_kegiatan" class="form-control custom-form-control" required autocomplete="off">
      <label>Tempat Kegiatan</label>
    </div>

    <div class="form-group mb-4">
      <input type="text" name="penyelenggara" class="form-control custom-form-control" required autocomplete="off">
      <label>Penyelenggara</label>
    </div>
  </div>
</fieldset>

<!-- CSS -->
<style>
.form-group { 
    margin-bottom: 20px; 
}

/* wrapper periode */
#periode_section {
    position: relative;
    z-index: 9999 !important;
    transition: margin-bottom 0.3s ease;
}

/* dropdown nice-select */
.nice-select {
    z-index: 99999 !important;
}

/* dropdown saat open = paling depan */
.nice-select.open {
    z-index: 999999 !important;
}

/* Tambah margin yang lebih besar saat dropdown dibuka */
#periode_section.open-margin {
    margin-bottom: 250px !important;
}

/* Tambah padding bottom untuk memberikan ruang lebih */
#periode_section .nice-select.open + .list {
    margin-bottom: 20px;
}

/* sembunyikan select asli */
.has-select select.nice-original {
  display: none !important;
}

/* Pastikan list dropdown tidak terpotong */
.nice-select .list {
    max-height: 200px;
    overflow-y: auto;
}

/* Animasi smooth untuk spacing */
#periode_section {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Style untuk error message */
.error-message {
    color: #dc3545;
    font-size: 12px;
    margin-top: 5px;
    display: none;
}

.form-group.has-error input {
    border-color: #dc3545;
}

/* Style untuk info message */
.info-message {
    color: #0d6efd;
    font-size: 12px;
    margin-top: 5px;
    display: none;
}

/* Style untuk success message */
.success-message {
    color: #198754;
    font-size: 12px;
    margin-top: 5px;
    display: none;
}

/* Style untuk disabled dates di datepicker */
.ui-datepicker td.ui-state-disabled {
    opacity: 0.3;
}

.ui-datepicker td.ui-state-disabled span {
    cursor: not-allowed !important;
}

/* Highlight untuk tanggal yang valid */
.ui-datepicker td.valid-date a {
    background-color: #e8f5e8 !important;
    color: #198754 !important;
    font-weight: bold;
}

/* Style untuk tanggal yang melebihi batas */
.ui-datepicker td.over-limit-date a {
    background-color: #fff3cd !important;
    color: #856404 !important;
    text-decoration: line-through;
}

/* tambahan visual warning kelas */
.ui-datepicker td.warning a {
    box-shadow: 0 0 0 1px #ffc107 inset;
}

/* Style untuk tanggal yang benar-benar tidak bisa dipilih */
.ui-datepicker td.force-disabled a {
    background-color: #f8d7da !important;
    color: #721c24 !important;
    text-decoration: line-through;
    cursor: not-allowed !important;
}
</style>

<!-- JS -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const jenisDate = document.getElementById('jenis_date');
  const periodeSection = document.getElementById('periode_section');
  const periodeSelect = document.getElementById('periode_value');
  
  // Datepicker elements
  const datepicker1 = document.getElementById('datepicker');
  const datepicker2 = document.getElementById('datepicker2');
  const datepicker3 = document.getElementById('datepicker3');
  const datepicker4 = document.getElementById('datepicker4');

  // Variabel untuk menyimpan batas tanggal
  let maxEndDate = null;
  let maxPenugasanDate = null;

  // ===== Aturan baru untuk Mulai Kegiatan (datepicker) =====
  // Hanya dapat memilih tanggal dalam rentang: (today - 30 days) .. today
  const today = new Date();
  today.setHours(0,0,0,0);
  const minStartDate = (function() {
    const d = new Date(today);
    d.setDate(d.getDate() - 30);
    d.setHours(0,0,0,0);
    return d;
  })();

  // Fungsi untuk menambahkan hari ke tanggal
  function addDays(date, days) {
    const result = new Date(date);
    result.setDate(result.getDate() + days);
    return result;
  }

  // Fungsi untuk format tanggal ke string yyyy-mm-dd
  function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  }

  // Fungsi untuk menghitung selisih hari (date2 - date1)
  function daysDifference(date1, date2) {
    const oneDay = 24 * 60 * 60 * 1000;
    // normalisasi jam supaya akurat
    const d1 = new Date(date1); d1.setHours(0,0,0,0);
    const d2 = new Date(date2); d2.setHours(0,0,0,0);
    return Math.round((d2 - d1) / oneDay);
  }

  // Fungsi untuk menampilkan error
  function showError(input, message) {
    const formGroup = input.closest('.form-group');
    formGroup.classList.add('has-error');
    
    let errorDiv = formGroup.querySelector('.error-message');
    if (!errorDiv) {
      errorDiv = document.createElement('div');
      errorDiv.className = 'error-message';
      formGroup.appendChild(errorDiv);
    }
    errorDiv.textContent = message;
    errorDiv.style.display = 'block';
  }

  // Fungsi untuk menampilkan info
  function showInfo(input, message) {
    const formGroup = input.closest('.form-group');
    
    let infoDiv = formGroup.querySelector('.info-message');
    if (!infoDiv) {
      infoDiv = document.createElement('div');
      infoDiv.className = 'info-message';
      formGroup.appendChild(infoDiv);
    }
    infoDiv.textContent = message;
    infoDiv.style.display = 'block';
  }

  // Fungsi untuk menampilkan success
  function showSuccess(input, message) {
    const formGroup = input.closest('.form-group');
    
    let successDiv = formGroup.querySelector('.success-message');
    if (!successDiv) {
      successDiv = document.createElement('div');
      successDiv.className = 'success-message';
      formGroup.appendChild(successDiv);
    }
    successDiv.textContent = message;
    successDiv.style.display = 'block';
  }

  // Fungsi untuk menghapus semua message
  function clearMessages(input) {
    const formGroup = input.closest('.form-group');
    formGroup.classList.remove('has-error');
    
    const errorDiv = formGroup.querySelector('.error-message');
    if (errorDiv) {
      errorDiv.style.display = 'none';
    }
    
    const infoDiv = formGroup.querySelector('.info-message');
    if (infoDiv) {
      infoDiv.style.display = 'none';
    }
    
    const successDiv = formGroup.querySelector('.success-message');
    if (successDiv) {
      successDiv.style.display = 'none';
    }
  }

  // Setup datepicker dengan jQuery UI (pastikan jQuery & jQuery UI sudah terload)
  if (typeof $ !== 'undefined' && typeof $.fn.datepicker !== 'undefined') {
    
    // Datepicker 1 - Mulai Kegiatan (ATURAN BARU: hanya boleh antara minStartDate .. today)
    $('#datepicker').datepicker({
      dateFormat: 'yy-mm-dd',
      autoclose: true,
      minDate: minStartDate,
      maxDate: today,
      beforeShowDay: function(date) {
        // normalisasi
        const d = new Date(date); d.setHours(0,0,0,0);
        // jika lebih kecil dari minStartDate
        if (d < minStartDate) {
          return [false, 'ui-state-disabled force-disabled', `Tidak boleh lebih dari 30 hari sebelum hari ini (${formatDate(minStartDate)})`];
        }
        // jika lebih besar dari today (future)
        if (d > today) {
          return [false, 'ui-state-disabled force-disabled', 'Tidak boleh memilih tanggal di masa depan'];
        }
        // valid
        const daysFromMin = daysDifference(minStartDate, d);
        // highlight hari-hari mendekati batas (opsional)
        if (daysFromMin <= 3) {
          return [true, 'valid-date warning', `Tanggal valid`];
        }
        return [true, 'valid-date', 'Tanggal valid'];
      },
      onSelect: function(dateText) {
        clearMessages(datepicker1);
        clearMessages(datepicker2);

        // parsing tanggal mulai
        const startDate = new Date(dateText);
        startDate.setHours(0,0,0,0);

        // cek manual validasi tambahan: harus dalam rentang minStartDate..today
        if (startDate < minStartDate) {
          // tidak boleh -> kosongkan dan beri error
          datepicker1.value = '';
          showError(datepicker1, `Tanggal mulai tidak boleh lebih dari 30 hari sebelum hari ini (${formatDate(minStartDate)}).`);
          $(this).datepicker('hide');
          return;
        }
        if (startDate > today) {
          datepicker1.value = '';
          showError(datepicker1, 'Tanggal mulai tidak boleh di masa depan.');
          $(this).datepicker('hide');
          return;
        }

        // Set aturan untuk datepicker2 (akhir kegiatan)
        const minEndDate = new Date(startDate);
        const maxAllowed = addDays(startDate, 60); // maksimal 60 hari dari tanggal mulai
        maxEndDate = maxAllowed;

        // PERBAIKAN: Set minDate dan maxDate secara eksplisit
        $('#datepicker2').datepicker('option', 'minDate', minEndDate);
        $('#datepicker2').datepicker('option', 'maxDate', maxEndDate);

        // Reset datepicker2 jika perlu
        if (datepicker2.value) {
          const currentEndDate = new Date(datepicker2.value);
          currentEndDate.setHours(0,0,0,0);

          if (currentEndDate < startDate || currentEndDate > maxEndDate) {
            datepicker2.value = '';
            showInfo(datepicker2, 'Silakan pilih ulang tanggal berakhir kegiatan (sesuai batas 60 hari).');
          }
        }

        showInfo(datepicker1, `Batas tanggal mulai: minimal ${formatDate(minStartDate)} — maksimal ${formatDate(today)}. Batas akhir kegiatan: ${formatDate(maxEndDate)} (60 hari dari mulai).`);

        $(this).datepicker('hide');
      }
    });

    // Datepicker 2 - Akhir Kegiatan (Dengan PERATURAN KETAT: harus >= mulai, <= mulai+60)
    $('#datepicker2').datepicker({
      dateFormat: 'yy-mm-dd',
      autoclose: true,
      minDate: null,
      maxDate: null,
      beforeShowDay: function(date) {
        if (!datepicker1.value) {
          return [false, 'ui-state-disabled force-disabled', 'Pilih tanggal mulai terlebih dahulu'];
        }

        const startDate = new Date(datepicker1.value);
        startDate.setHours(0,0,0,0);

        const checkDate = new Date(date);
        checkDate.setHours(0,0,0,0);

        const maxAllowedDate = addDays(startDate, 60);
        maxAllowedDate.setHours(0,0,0,0);

        // TIDAK BISA memilih tanggal sebelum tanggal mulai
        if (checkDate < startDate) {
          return [false, 'ui-state-disabled force-disabled', 'Tidak bisa memilih tanggal sebelum tanggal mulai'];
        }

        // Batas 60 hari - tanggal dalam range valid
        if (checkDate >= startDate && checkDate <= maxAllowedDate) {
          const daysFromStart = daysDifference(startDate, checkDate);
          const daysLeft = 60 - daysFromStart;

          // Highlight tanggal yang mendekati batas
          if (daysLeft <= 7) {
            return [true, 'valid-date warning', `Sisa ${daysLeft} hari dari batas 60 hari`];
          }
          return [true, 'valid-date', `${daysFromStart} hari dari tanggal mulai`];
        }

        // Tanggal melebihi 60 hari - TIDAK BISA DIPILIH (PERBAIKAN: force disabled)
        return [false, 'ui-state-disabled force-disabled', 'Melebihi batas maksimal 60 hari - TIDAK DIPERBOLEHKAN'];
      },
      onSelect: function(dateText) {
        clearMessages(datepicker2);

        if (datepicker1.value) {
          const startDate = new Date(datepicker1.value);
          const endDate = new Date(dateText);
          const maxAllowedDate = addDays(startDate, 60);

          // Validasi: Tanggal akhir tidak boleh lebih awal
          if (endDate < startDate) {
            datepicker2.value = '';
            showError(datepicker2, 'Tanggal berakhir tidak boleh lebih awal dari tanggal mulai');
            $(this).datepicker('hide');
            return;
          }

          // Validasi: Maksimal 60 hari - TIDAK ADA AUTO CORRECT, HARUS TEPAT
          if (endDate > maxAllowedDate) {
            datepicker2.value = '';
            showError(datepicker2, `Tanggal berakhir tidak boleh melebihi ${formatDate(maxAllowedDate)} (60 hari dari tanggal mulai)`);
            $(this).datepicker('hide');
            return;
          }

          const daysUsed = daysDifference(startDate, endDate);
          const daysLeft = 60 - daysUsed;
          showSuccess(datepicker2, `Durasi kegiatan: ${daysUsed} hari. Sisa: ${daysLeft} hari dari 60 hari maksimal`);
        }

        $(this).datepicker('hide');
      }
    });

    // Datepicker 3 - Periode Penugasan
    $('#datepicker3').datepicker({
      dateFormat: 'yy-mm-dd',
      autoclose: true,
      onSelect: function(dateText) {
        clearMessages(datepicker3);
        clearMessages(datepicker4);

        const startDate = new Date(dateText);
        const minEndDate = new Date(dateText); // Minimal sama dengan tanggal mulai
        maxPenugasanDate = addDays(startDate, 60); // Maksimal 60 hari dari tanggal mulai

        // Update datepicker4 dengan batasan baru
        $('#datepicker4').datepicker('option', 'minDate', minEndDate);
        $('#datepicker4').datepicker('option', 'maxDate', maxPenugasanDate);

        // Reset datepicker4 jika perlu
        if (datepicker4.value) {
          const currentEndDate = new Date(datepicker4.value);

          if (currentEndDate < startDate || currentEndDate > maxPenugasanDate) {
            datepicker4.value = '';
            showInfo(datepicker4, 'Silakan pilih ulang akhir penugasan (sesuai batas 60 hari).');
          }
        }

        showInfo(datepicker3, `Batas akhir penugasan: ${formatDate(maxPenugasanDate)} (60 hari dari periode penugasan)`);

        $(this).datepicker('hide');
      }
    });

    // Datepicker 4 - Akhir Penugasan (Dengan PERATURAN KETAT)
    $('#datepicker4').datepicker({
      dateFormat: 'yy-mm-dd',
      autoclose: true,
      minDate: null,
      maxDate: null,
      beforeShowDay: function(date) {
        if (!datepicker3.value) {
          return [false, 'ui-state-disabled force-disabled', 'Pilih periode penugasan terlebih dahulu'];
        }

        const startDate = new Date(datepicker3.value);
        startDate.setHours(0,0,0,0);

        const checkDate = new Date(date);
        checkDate.setHours(0,0,0,0);

        const maxAllowedDate = addDays(startDate, 60);
        maxAllowedDate.setHours(0,0,0,0);

        // TIDAK BISA memilih tanggal di belakang periode penugasan
        if (checkDate < startDate) {
          return [false, 'ui-state-disabled force-disabled', 'Tidak bisa memilih tanggal sebelum periode penugasan'];
        }

        // Batas 60 hari - tanggal dalam range valid
        if (checkDate >= startDate && checkDate <= maxAllowedDate) {
          const daysFromStart = daysDifference(startDate, checkDate);
          const daysLeft = 60 - daysFromStart;

          // Highlight tanggal yang mendekati batas
          if (daysLeft <= 7) {
            return [true, 'valid-date warning', `Sisa ${daysLeft} hari dari batas 60 hari`];
          }
          return [true, 'valid-date', `${daysFromStart} hari dari periode penugasan`];
        }

        // Tanggal melebihi 60 hari - TIDAK BISA DIPILIH (PERBAIKAN: force disabled)
        return [false, 'ui-state-disabled force-disabled', 'Melebihi batas maksimal 60 hari - TIDAK DIPERBOLEHKAN'];
      },
      onSelect: function(dateText) {
        clearMessages(datepicker4);

        if (datepicker3.value) {
          const startDate = new Date(datepicker3.value);
          const endDate = new Date(dateText);
          const maxAllowedDate = addDays(startDate, 60);

          // Validasi: Akhir periode tidak boleh lebih awal
          if (endDate < startDate) {
            datepicker4.value = '';
            showError(datepicker4, 'Akhir penugasan tidak boleh lebih awal dari periode penugasan');
            $(this).datepicker('hide');
            return;
          }

          // Validasi: Maksimal 60 hari - TIDAK ADA AUTO CORRECT, HARUS TEPAT
          if (endDate > maxAllowedDate) {
            datepicker4.value = '';
            showError(datepicker4, `Akhir penugasan tidak boleh melebihi ${formatDate(maxAllowedDate)} (60 hari dari periode penugasan)`);
            $(this).datepicker('hide');
            return;
          }

          const daysUsed = daysDifference(startDate, endDate);
          const daysLeft = 60 - daysUsed;
          showSuccess(datepicker4, `Durasi penugasan: ${daysUsed} hari. Sisa: ${daysLeft} hari dari 60 hari maksimal`);
        }

        $(this).datepicker('hide');
      }
    });

    // PERBAIKAN: Validasi real-time yang lebih ketat
    $('#datepicker2').on('focus', function() {
      if (!datepicker1.value) {
        $(this).blur();
        showError(datepicker2, 'Pilih tanggal mulai kegiatan terlebih dahulu');
        return false;
      }
      
      // Force refresh datepicker options
      const startDate = new Date(datepicker1.value);
      const maxAllowed = addDays(startDate, 60);
      $(this).datepicker('option', 'minDate', startDate);
      $(this).datepicker('option', 'maxDate', maxAllowed);
    });

    $('#datepicker4').on('focus', function() {
      if (!datepicker3.value) {
        $(this).blur();
        showError(datepicker4, 'Pilih periode penugasan terlebih dahulu');
        return false;
      }
      
      // Force refresh datepicker options
      const startDate = new Date(datepicker3.value);
      const maxAllowed = addDays(startDate, 60);
      $(this).datepicker('option', 'minDate', startDate);
      $(this).datepicker('option', 'maxDate', maxAllowed);
    });

    // Validasi real-time untuk input manual - PERBAIKAN: lebih ketat
    $('#datepicker2').on('change', function() {
      if (datepicker1.value && this.value) {
        const startDate = new Date(datepicker1.value);
        const endDate = new Date(this.value);
        const maxAllowedDate = addDays(startDate, 60);

        if (endDate < startDate) {
          showError(this, 'Tanggal berakhir tidak boleh lebih awal dari tanggal mulai');
          this.value = '';
        } else if (endDate > maxAllowedDate) {
          showError(this, `Tanggal berakhir tidak boleh melebihi ${formatDate(maxAllowedDate)} (60 hari dari tanggal mulai)`);
          this.value = '';
        } else {
          clearMessages(this);
        }
      }
    });

    $('#datepicker4').on('change', function() {
      if (datepicker3.value && this.value) {
        const startDate = new Date(datepicker3.value);
        const endDate = new Date(this.value);
        const maxAllowedDate = addDays(startDate, 60);

        if (endDate < startDate) {
          showError(this, 'Akhir penugasan tidak boleh lebih awal dari periode penugasan');
          this.value = '';
        } else if (endDate > maxAllowedDate) {
          showError(this, `Akhir penugasan tidak boleh melebihi ${formatDate(maxAllowedDate)} (60 hari dari periode penugasan)`);
          this.value = '';
        } else {
          clearMessages(this);
        }
      }
    });

    // Validasi tambahan untuk datepicker1
    $('#datepicker').on('change', function() {
      if (this.value) {
        const v = new Date(this.value);
        v.setHours(0,0,0,0);
        if (v < minStartDate) {
          showError(this, `Tanggal mulai tidak boleh lebih dari 30 hari sebelum hari ini (${formatDate(minStartDate)})`);
          this.value = '';
        } else if (v > today) {
          showError(this, 'Tanggal mulai tidak boleh di masa depan');
          this.value = '';
        } else {
          clearMessages(this);
        }
      }
    });

    // PERBAIKAN: Force reset datepicker2 ketika datepicker1 berubah
    $('#datepicker').on('change', function() {
      if (datepicker2.value) {
        const startDate = new Date(this.value);
        const endDate = new Date(datepicker2.value);
        const maxAllowedDate = addDays(startDate, 60);

        if (endDate < startDate || endDate > maxAllowedDate) {
          datepicker2.value = '';
          showInfo(datepicker2, 'Tanggal berakhir direset karena tidak sesuai dengan batas 60 hari dari tanggal mulai baru');
        }
      }
    });

    // PERBAIKAN: Force reset datepicker4 ketika datepicker3 berubah
    $('#datepicker3').on('change', function() {
      if (datepicker4.value) {
        const startDate = new Date(this.value);
        const endDate = new Date(datepicker4.value);
        const maxAllowedDate = addDays(startDate, 60);

        if (endDate < startDate || endDate > maxAllowedDate) {
          datepicker4.value = '';
          showInfo(datepicker4, 'Akhir penugasan direset karena tidak sesuai dengan batas 60 hari dari periode penugasan baru');
        }
      }
    });

  } // end if jquery-ui available

  // Fungsi untuk toggle periode section
  function togglePeriodeSection(value) {
    const niceWrapper = periodeSection.querySelector('.nice-select');
    const originalSelect = periodeSelect;

    if (value === 'Periode') {
      periodeSection.style.display = 'block';
      if (niceWrapper) niceWrapper.style.display = 'block';
      originalSelect.classList.add('nice-original');
      periodeSelect.setAttribute('required', 'required');
    } else {
      periodeSection.style.display = 'none';
      if (niceWrapper) niceWrapper.style.display = 'none';
      originalSelect.classList.add('nice-original');
      periodeSelect.removeAttribute('required');
      periodeSelect.value = '';
      periodeSection.classList.remove('open-margin');
    }
  }

  // Jika menggunakan NiceSelect
  if (typeof $ !== 'undefined' && typeof $.fn.niceSelect !== 'undefined') {
    $('select#periode_value').niceSelect();

    $('select#periode_value').parent().on("click", function () {
      setTimeout(() => {
        if ($(this).hasClass("open")) {
          periodeSection.classList.add("open-margin");
        } else {
          periodeSection.classList.remove("open-margin");
        }
      }, 50);
    });

    $(document).on('click', function(e) {
      if (!$(e.target).closest('#periode_section').length) {
        periodeSection.classList.remove("open-margin");
      }
    });

    $('select#jenis_date').on('change', function () {
      togglePeriodeSection(this.value);
    });
  }

  // fallback
  jenisDate.addEventListener('change', function () {
    togglePeriodeSection(this.value);
  });

  // PERBAIKAN: Tambahan validasi form submit
  const msform = document.getElementById('msform');
  if (msform) {
    msform.addEventListener('submit', function(e) {
      let isValid = true;
      
      // Validasi datepicker2
      if (datepicker1.value && datepicker2.value) {
        const startDate = new Date(datepicker1.value);
        const endDate = new Date(datepicker2.value);
        const maxAllowedDate = addDays(startDate, 60);
        
        if (endDate > maxAllowedDate) {
          showError(datepicker2, `Tanggal berakhir melebihi batas 60 hari. Maksimal: ${formatDate(maxAllowedDate)}`);
          isValid = false;
        }
      }
      
      // Validasi datepicker4
      if (datepicker3.value && datepicker4.value) {
        const startDate = new Date(datepicker3.value);
        const endDate = new Date(datepicker4.value);
        const maxAllowedDate = addDays(startDate, 60);
        
        if (endDate > maxAllowedDate) {
          showError(datepicker4, `Akhir penugasan melebihi batas 60 hari. Maksimal: ${formatDate(maxAllowedDate)}`);
          isValid = false;
        }
      }
      
      if (!isValid) {
        e.preventDefault();
        showNotification('error', 'Periksa kembali tanggal yang dimasukkan!');
      }
    });
  }

  // Helper function untuk notification
  function showNotification(type, message) {
    const notification = document.createElement('div');
    notification.style.cssText = `
      position: fixed;
      top: 20px;
      right: 20px;
      background: ${type === 'error' ? '#dc3545' : '#28a745'};
      color: white;
      padding: 15px 20px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      z-index: 10000;
      font-weight: 600;
      animation: slideInRight 0.3s ease;
    `;
    notification.innerHTML = `
      <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'}"></i> ${message}
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
      notification.style.animation = 'slideOutRight 0.3s ease';
      setTimeout(() => notification.remove(), 300);
    }, 3000);
  }
});
</script>
<!-- Step 2 -->
<fieldset>
    <div class="container">

        <!-- Jenis Pengajuan & Status -->
        <div class="row mb-3">
            <div class="col-md-6">
                <select class="form-control" name="jenis_pengajuan" id="jenis_pengajuan" required>
                    <option disabled selected value="">Jenis Pengajuan</option>
                    <option value="Kelompok">Kelompok</option>
                    <option value="Perorangan">Perorangan</option>
                </select>
            </div>

            <div class="col-md-6">
                <select class="form-control" name="lingkup_penugasan" id="lingkup_penugasan" required>
                    <option disabled selected value="">Status Kepegawaian</option>
                    <option value="Dosen">Dosen</option>
                    <option value="TPA">TPA</option>
                    <option value="Dosen dan TPA">Dosen dan TPA</option>
                </select>
            </div>
        </div>

        <!-- Jenis Penugasan Perorangan -->
        <div class="form-group has-select mb-3" id="jenis_penugasan_perorangan_container">
            <select class="form-control" name="jenis_penugasan" id="jenis_penugasan_perorangan">
                <option disabled selected value="">Jenis Penugasan</option>
                <option value="Juri">Juri</option>
                <option value="Pembicara">Pembicara</option>
                <option value="Narasumber">Narasumber</option>
                <option value="Penugasan Lainnya">Lainnya</option>
            </select>

            <input type="text" class="form-control custom-form-control"
                   name="penugasan_lainnya_perorangan" id="penugasan_lainnya_perorangan"
                   placeholder="Masukan Jenis Penugasan Lainnya"
                   style="margin-top:12px; display:none;">
        </div>

        <!-- Jenis Penugasan Kelompok -->
        <div class="form-group has-select mb-3" id="jenis_penugasan_kelompok_container">
            <select class="form-control" name="jenis_penugasan_kelompok" id="jenis_penugasan_kelompok">
                <option disabled selected value="">Jenis Penugasan</option>
                <option value="Tim">Tim</option>
                <option value="Kepanitiaan">Kepanitiaan</option>
                <option value="Penugasan Lainnya">Lainnya</option>
            </select>

            <input type="text" class="form-control custom-form-control"
                   name="penugasan_lainnya_kelompok" id="penugasan_lainnya_kelompok"
                   placeholder="Masukan Jenis Penugasan Lainnya"
                   style="margin-top:12px; display:none;">
        </div>

        <!-- Format -->
        <div id="selectformat" class="mb-3">
            <input class="form-check-input" type="radio" name="format" value="1" checked>
            <a href="https://ifik.telkomuniversity.ac.id/assets/eviden/format1.pdf" target="_blank"
               class="badge badge-success text-light">Lihat contoh format kepanitiaan 1</a>

            &nbsp;&nbsp;

            <input class="form-check-input" type="radio" name="format" value="2">
            <a href="https://ifik.telkomuniversity.ac.id/assets/eviden/format2.pdf" target="_blank"
               class="badge badge-info text-light">Lihat contoh format kepanitiaan 2</a>
        </div>

        <!-- FORM PANITIA -->
        <div id="panitiaContainer" class="mt-4">
            <div class="row g-3 align-items-end panitia-row" data-row-index="0">

                <div class="col-md-2 position-relative">
                    <label>NIP</label>
                    <input type="text" name="nip[]" class="form-control nip-input" autocomplete="off" required>
                </div>

                <div class="col-md-3 position-relative">
                    <label>Nama Dosen</label>
                    <input type="text" name="nama_dosen[]" class="form-control nama-dosen-input" autocomplete="off" required>
                </div>

                <div class="col-md-3 position-relative">
                    <label>Jabatan</label>
                    <input type="text" name="jabatan[]" class="form-control jabatan-input" autocomplete="off" required>
                </div>

                <div class="col-md-3 position-relative">
                    <label>Divisi</label>
                    <input type="text" name="divisi[]" class="form-control divisi-input" autocomplete="off" required>
                </div>

                <div class="col-md-1 text-center button-cell">
                    <button type="button" class="btn btn-success add-row-btn" title="Tambah Baris">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

            </div>
        </div>

    </div>
</fieldset>

<style>
.button-cell { display: none; justify-content: center; align-items: center; }
.add-row-btn, .remove-row-btn { width: 35px; height: 35px; border-radius: 50%; padding: 0; }
.panitia-row { transition: all 0.3s ease; opacity: 1; transform: translateY(0); }
.panitia-row.removing { opacity: 0; transform: translateX(20px); }

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
    font-family: arial, sans-serif;
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
}

.autocomplete-item:first-child {
    border-left: 3px solid #1a73e8;
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

.multi-step-form, fieldset, .container {
    overflow: visible !important;
}

/* Perbaikan untuk tampilan form */
.form-group.has-select {
    margin-bottom: 1rem;
}

.form-control.custom-form-control {
    margin-top: 12px;
}

.panitia-row {
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.panitia-row:last-child {
    border-bottom: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const panitiaContainer = document.getElementById('panitiaContainer');
    const jenisPengajuan = document.getElementById('jenis_pengajuan');
    const jenisPenugasanPeroranganContainer = document.getElementById('jenis_penugasan_perorangan_container');
    const jenisPenugasanKelompokContainer = document.getElementById('jenis_penugasan_kelompok_container');
    
    let rowCounter = 1;

    // Mock data untuk testing
    const mockData = [
        { nip: '17770081', nama_dosen: 'Dr. Moh Isa Pramana Koesoemadinata, S.Sn, M.Sn.', jabatan: 'Dosen', divisi: 'DKV' },
        { nip: '14800004', nama_dosen: 'Bijaksana Prabawa, S.Ds., M.M.', jabatan: 'Dosen', divisi: 'DKV' },
        { nip: '14810009', nama_dosen: 'Dr. Ira Wirasari, S.Sos., M.Ds.', jabatan: 'Dosen', divisi: 'DKV' },
        { nip: '19860001', nama_dosen: 'Mahendra Nur Hadiansyah, S.T., M.Ds.', jabatan: 'Dosen', divisi: 'DI' },
        { nip: '19850010', nama_dosen: 'Diena Yudiarti, S.Ds., M.S.M.', jabatan: 'Dosen', divisi: 'DKV' },
        { nip: '20940012', nama_dosen: 'Ganesha Puspa Nabila, S.Sn., M.Ds.', jabatan: 'Dosen', divisi: 'DI' },
        { nip: '20950008', nama_dosen: 'Hana Faza Surya Rusyda, ST., M.Ars.', jabatan: 'Dosen', divisi: 'DI' },
        { nip: '20920049', nama_dosen: 'Angelia Lionardi, S.Sn., M.Ds.', jabatan: 'Dosen', divisi: 'DKV' },
        { nip: '15870029', nama_dosen: 'Ica Ramawisari, S.T., M.T.', jabatan: 'Dosen', divisi: 'DP' },
        { nip: '82196019', nama_dosen: 'Alisa Rahadiasmurti Isfandiari, S.A.B., M.M.', jabatan: 'Dosen', divisi: 'Admin KK' }
    ];

    // Global state untuk autocomplete
    let currentAutocompleteBox = null;
    let currentKeydownHandler = null;
    let currentClickHandler = null;
    let currentInputElement = null;

    // Toggle visibility jenis penugasan berdasarkan jenis pengajuan
    function toggleJenisPenugasan() {
        if (jenisPengajuan.value === 'Perorangan') {
            jenisPenugasanPeroranganContainer.style.display = 'block';
            jenisPenugasanKelompokContainer.style.display = 'none';
        } else if (jenisPengajuan.value === 'Kelompok') {
            jenisPenugasanPeroranganContainer.style.display = 'none';
            jenisPenugasanKelompokContainer.style.display = 'block';
        } else {
            jenisPenugasanPeroranganContainer.style.display = 'none';
            jenisPenugasanKelompokContainer.style.display = 'none';
        }
    }

    // Toggle button visibility based on jenis pengajuan
    jenisPengajuan.addEventListener('change', function () {
        document.querySelectorAll('.button-cell').forEach(btn => {
            btn.style.display = (this.value === 'Kelompok') ? 'flex' : 'none';
        });
        toggleJenisPenugasan();
    });

    // Inisialisasi awal
    toggleJenisPenugasan();

    // Handle "Lainnya" option untuk penugasan perorangan
    document.getElementById('jenis_penugasan_perorangan').addEventListener('change', function() {
        const lainnyaInput = document.getElementById('penugasan_lainnya_perorangan');
        lainnyaInput.style.display = this.value === 'Penugasan Lainnya' ? 'block' : 'none';
        if (this.value !== 'Penugasan Lainnya') {
            lainnyaInput.value = '';
        }
    });

    // Handle "Lainnya" option untuk penugasan kelompok
    document.getElementById('jenis_penugasan_kelompok').addEventListener('change', function() {
        const lainnyaInput = document.getElementById('penugasan_lainnya_kelompok');
        lainnyaInput.style.display = this.value === 'Penugasan Lainnya' ? 'block' : 'none';
        if (this.value !== 'Penugasan Lainnya') {
            lainnyaInput.value = '';
        }
    });

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
            // Mock data untuk testing
            await new Promise(resolve => setTimeout(resolve, 200));
            const lowerQuery = query.toLowerCase();
            return mockData.filter(item => {
                const searchIn = item[fieldType] ? item[fieldType].toLowerCase() : '';
                return searchIn.includes(lowerQuery);
            });
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
        // Hapus flag initialization sebelumnya
        delete rowEl.dataset.autocompleteInitialized;

        const inputNip = rowEl.querySelector('.nip-input');
        const inputNama = rowEl.querySelector('.nama-dosen-input');
        const inputJabatan = rowEl.querySelector('.jabatan-input');
        const inputDivisi = rowEl.querySelector('.divisi-input');

        if (!inputNip || !inputNama || !inputJabatan || !inputDivisi) {
            console.log('Input elements not found in row:', rowEl);
            return;
        }

        console.log('Initializing autocomplete for row:', rowEl.dataset.rowIndex);

        // Fill all fields when item is selected
        function fillRowWith(item) {
            if (!item) return;
            
            console.log('Filling row with data:', item);
            
            // Set values untuk semua field
            inputNip.value = item.nip || '';
            inputNama.value = item.nama_dosen || '';
            inputJabatan.value = item.jabatan || '';
            inputDivisi.value = item.divisi || '';
            
            // Trigger input events untuk validasi
            inputNip.dispatchEvent(new Event('input', { bubbles: true }));
            inputNama.dispatchEvent(new Event('input', { bubbles: true }));
            inputJabatan.dispatchEvent(new Event('input', { bubbles: true }));
            inputDivisi.dispatchEvent(new Event('input', { bubbles: true }));
        }

        // Create input handler untuk setiap field
        function createAutocompleteHandler(fieldType, inputElement) {
            const handler = debounce(async function() {
                const val = this.value.trim();
                console.log(`Input detected in ${fieldType}:`, val);
                
                // Hanya tampilkan autocomplete jika user aktif mengetik
                if (val.length < 2 || document.activeElement !== this) {
                    removeAutocompleteBox();
                    return;
                }

                const suggestions = await fetchSuggestions(val, fieldType);
                console.log(`Suggestions for ${fieldType}:`, suggestions);
                showSuggestionBox(inputElement, suggestions, fillRowWith, fieldType);
            }, 300);

            // Hapus event listener lama jika ada
            if (inputElement._currentHandler) {
                inputElement.removeEventListener('input', inputElement._currentHandler);
            }
            
            // Simpan reference ke handler baru
            inputElement._currentHandler = handler;
            // Pasang event listener baru
            inputElement.addEventListener('input', handler);
            
            console.log(`Handler attached to ${fieldType}`);
        }

        // Initialize autocomplete untuk semua field dalam row ini
        createAutocompleteHandler('nip', inputNip);
        createAutocompleteHandler('nama_dosen', inputNama);
        createAutocompleteHandler('jabatan', inputJabatan);
        createAutocompleteHandler('divisi', inputDivisi);

        // Focus handlers untuk close autocomplete
        [inputNip, inputNama, inputJabatan, inputDivisi].forEach(input => {
            input.addEventListener('focus', () => {
                removeAutocompleteBox();
            });
            
            // Tambahkan event untuk blur (kehilangan fokus)
            input.addEventListener('blur', () => {
                // Delay sedikit sebelum menutup autocomplete untuk memberi waktu klik opsi
                setTimeout(() => {
                    if (document.activeElement !== input && 
                        (!currentAutocompleteBox || !currentAutocompleteBox.contains(document.activeElement))) {
                        removeAutocompleteBox();
                    }
                }, 150);
            });
        });

        // Set flag bahwa row sudah diinisialisasi
        rowEl.dataset.autocompleteInitialized = 'true';
    }

    // Add new row function
    function addNewRow() {
        const originalRow = document.querySelector('.panitia-row');
        const newRow = originalRow.cloneNode(true);
        
        // Update row index
        newRow.dataset.rowIndex = rowCounter++;
        
        // Clear all input values
        newRow.querySelectorAll('input').forEach(input => {
            input.value = '';
        });
        
        // Change add button to remove button
        const addBtn = newRow.querySelector('.add-row-btn');
        if (addBtn) {
            addBtn.classList.remove('btn-success', 'add-row-btn');
            addBtn.classList.add('btn-danger', 'remove-row-btn');
            addBtn.innerHTML = '<i class="fas fa-minus"></i>';
            addBtn.setAttribute('title', 'Hapus Baris');
        }
        
        // Add to container
        panitiaContainer.appendChild(newRow);
        
        // Initialize autocomplete untuk row baru
        setTimeout(() => {
            initAutocompleteForRow(newRow);
        }, 100);
        
        // Add animation
        animateNewRow(newRow);
        
        console.log('New row added:', newRow.dataset.rowIndex);
    }

    function removeRowWithAnimation(rowEl) {
        rowEl.style.opacity = '0';
        rowEl.style.transform = 'translateX(20px)';
        setTimeout(() => {
            if (rowEl.parentNode) {
                rowEl.remove();
            }
        }, 300);
    }

    function animateNewRow(rowEl) {
        rowEl.style.opacity = '0';
        rowEl.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            rowEl.style.transition = 'all 0.3s ease';
            rowEl.style.opacity = '1';
            rowEl.style.transform = 'translateY(0)';
        }, 10);
    }

    // Add/Remove row handlers
    panitiaContainer.addEventListener('click', function (e) {
        const addBtn = e.target.closest('.add-row-btn');
        const removeBtn = e.target.closest('.remove-row-btn');

        if (addBtn) {
            e.preventDefault();
            e.stopPropagation();
            addNewRow();
        }

        if (removeBtn) {
            e.preventDefault();
            e.stopPropagation();
            const rowEl = removeBtn.closest('.panitia-row');
            if (rowEl && panitiaContainer.querySelectorAll('.panitia-row').length > 1) {
                removeRowWithAnimation(rowEl);
            }
        }
    });

    // Initialize autocomplete untuk semua existing rows
    function initializeAllRows() {
        const rows = panitiaContainer.querySelectorAll('.panitia-row');
        console.log('Initializing all rows:', rows.length);
        
        rows.forEach((row, index) => {
            row.dataset.rowIndex = index;
            initAutocompleteForRow(row);
        });
    }

    // Initialize saat DOM ready
    setTimeout(() => {
        initializeAllRows();
    }, 100);

    // Close autocomplete ketika klik di luar
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.autocomplete-box-fixed') && 
            !e.target.closest('.nip-input') && 
            !e.target.closest('.nama-dosen-input') && 
            !e.target.closest('.jabatan-input') && 
            !e.target.closest('.divisi-input')) {
            removeAutocompleteBox();
        }
    });

    // Juga close autocomplete ketika tekan ESC di mana saja
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            removeAutocompleteBox();
        }
    });
});
</script>
<!-- ===== UPLOADCARE CDN ===== -->
<script>
UPLOADCARE_PUBLIC_KEY = "3438a2ee1b7dd183914c";
</script>
<script src="https://ucarecdn.com/libs/widget/3.x/uploadcare.full.min.js"></script>

<fieldset>
    <div style="width: 100%;">
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 10px; color: #333;">
                <i class="fas fa-cloud-upload-alt"></i> Upload File Eviden
            </label>
        </div>

        <!-- KONTAINER UPLOADCARE (harus div kosong) -->
        <div id="eviden-panel" style="min-height: 420px; border:1px solid #ddd; border-radius:10px;"></div>

        <!-- Hidden input untuk simpan URL -->
        <input type="hidden" name="eviden" id="eviden" value="[]">
        
        <!-- Display uploaded files -->
        <div id="uploaded-files-display" style="margin-top: 20px; display: none;">
            <div style="background: #f8f9fa; border-radius: 8px; padding: 15px; border: 1px solid #dee2e6;">
                <h6 style="font-weight: 600; margin-bottom: 10px; color: #495057;">
                    <i class="fas fa-check-circle" style="color: #28a745;"></i> File yang sudah diupload:
                </h6>
                <div id="files-list"></div>
            </div>
        </div>
    </div>
</fieldset>

<!-- BUTTON AREA -->
<div class="button-area" style="margin-top:25px; text-align:center;">
    <button type="button" class="btn btn-primary prev-btn rounded-pill btn-sm" style="padding: 6px 20px;">Back</button>
    <button type="button" class="action-btn next-btn rounded-pill btn-sm" style="padding: 6px 20px;">Continue</button>
</div>

<script>
// ========================================
// PERBAIKAN UPLOADCARE - SIMPAN URL KE DATABASE
// ========================================

document.addEventListener("DOMContentLoaded", function () {
    const evidenInput = document.getElementById("eviden");
    const msform = document.getElementById("msform");
    const uploadedDisplay = document.getElementById("uploaded-files-display");
    const filesList = document.getElementById("files-list");
    
    // Pastikan default selalu array kosong (bukan string kosong)
    if (!evidenInput.value || evidenInput.value === "") {
        evidenInput.value = "[]";
    }

    // Array untuk menyimpan semua URL yang di-upload
    let uploadedFiles = [];

    // Function untuk update display files
    function updateFilesDisplay() {
        if (uploadedFiles.length === 0) {
            uploadedDisplay.style.display = 'none';
            return;
        }

        uploadedDisplay.style.display = 'block';
        filesList.innerHTML = '';

        uploadedFiles.forEach((url, index) => {
            const filename = url.split('/').pop().split('?')[0]; // Extract filename dari URL
            const fileItem = document.createElement('div');
            fileItem.style.cssText = 'display: flex; align-items: center; gap: 10px; padding: 8px; background: white; border-radius: 6px; margin-bottom: 8px; border: 1px solid #e9ecef;';
            
            fileItem.innerHTML = `
                <div style="flex-shrink: 0;">
                    <i class="fas fa-file-alt" style="font-size: 20px; color: #6c757d;"></i>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <strong style="font-size: 13px; color: #495057;">File ${index + 1}</strong>
                    <div style="font-size: 11px; color: #6c757d; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${filename}</div>
                </div>
                <button type="button" 
                        onclick="removeFile(${index})" 
                        style="padding: 4px 8px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 11px;">
                    <i class="fas fa-times"></i> Hapus
                </button>
            `;
            
            filesList.appendChild(fileItem);
        });
    }

    // Function untuk remove file
    window.removeFile = function(index) {
        uploadedFiles.splice(index, 1);
        evidenInput.value = JSON.stringify(uploadedFiles);
        updateFilesDisplay();
        console.log("🗑 File dihapus. Total file:", uploadedFiles.length);
    };

    // Inisialisasi Uploadcare Panel
    const panel = uploadcare.openPanel('#eviden-panel', null, {
        multiple: true,
        previewStep: true,
        tabs: "file url camera dropbox gdrive",
        publicKey: "3438a2ee1b7dd183914c"
    });

    // Event ketika user selesai upload file
    panel.done(function (fileGroup) {
        console.log("✅ Upload selesai! File group:", fileGroup);
        
        // Proses semua file yang di-upload
        fileGroup.files().forEach(filePromise => {
            filePromise.done(fileInfo => {
                console.log("📁 File info:", fileInfo);
                
                // Tambahkan URL ke array
                uploadedFiles.push(fileInfo.cdnUrl);
                
                // Update hidden input dengan format JSON array
                evidenInput.value = JSON.stringify(uploadedFiles);
                
                // Update display
                updateFilesDisplay();
                
                console.log("💾 Eviden tersimpan:", evidenInput.value);
                console.log("📊 Total files:", uploadedFiles.length);
            });
        });
    });

    // ========================================
    // PERBAIKAN FORM SUBMIT
    // ========================================
    
    // Cegah submit default di tombol "Finish"
    const nextBtn = document.querySelector('.next-btn');
    const fieldsets = document.querySelectorAll('fieldset');
    let currentStep = 0;

    if (nextBtn) {
        nextBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const totalSteps = fieldsets.length;
            
            // Jika masih ada step berikutnya
            if (currentStep < totalSteps - 1) {
                fieldsets[currentStep].classList.remove('active');
                currentStep++;
                fieldsets[currentStep].classList.add('active');
                
                // Update progress bar
                const percent = ((currentStep + 1) / totalSteps) * 100;
                document.getElementById('progressBar').style.width = percent + '%';
                document.getElementById('currentStep').textContent = currentStep + 1;
                
                // Toggle tombol back
                document.querySelector('.prev-btn').style.display = currentStep > 0 ? 'inline-block' : 'none';
                
                // Update text tombol
                nextBtn.textContent = currentStep === totalSteps - 1 ? 'Finish' : 'Continue';
            } 
            // Jika sudah di step terakhir (Finish)
            else {
                console.log("🚀 Submitting form...");
                console.log("📎 Final eviden value:", evidenInput.value);
                
                // Validasi: pastikan eviden tidak kosong jika wajib
                if (uploadedFiles.length === 0) {
                    alert("⚠ Silakan upload minimal 1 file eviden!");
                    return false;
                }
                
                // Submit form
                msform.submit();
            }
        });
    }

    // Tombol Back
    const prevBtn = document.querySelector('.prev-btn');
    if (prevBtn) {
        prevBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (currentStep > 0) {
                fieldsets[currentStep].classList.remove('active');
                currentStep--;
                fieldsets[currentStep].classList.add('active');
                
                // Update progress
                const totalSteps = fieldsets.length;
                const percent = ((currentStep + 1) / totalSteps) * 100;
                document.getElementById('progressBar').style.width = percent + '%';
                document.getElementById('currentStep').textContent = currentStep + 1;
                
                prevBtn.style.display = currentStep > 0 ? 'inline-block' : 'none';
                nextBtn.textContent = currentStep === totalSteps - 1 ? 'Finish' : 'Continue';
            }
        });
    }
});

// ========================================
// DEBUG HELPER - CEK ISI FORM SEBELUM SUBMIT
// ========================================
document.getElementById("msform").addEventListener("submit", function(e) {
    const evidenValue = document.getElementById("eviden").value;
    console.log("📤 Form akan di-submit dengan eviden:", evidenValue);
    
    // Cek apakah eviden kosong
    try {
        const parsed = JSON.parse(evidenValue);
        if (!Array.isArray(parsed) || parsed.length === 0) {
            console.warn("⚠ WARNING: Eviden kosong!");
        } else {
            console.log("✅ Eviden berisi", parsed.length, "file(s)");
        }
    } catch (err) {
        console.error("❌ ERROR: Format eviden tidak valid!", err);
    }
});
</script>
</div>
</form>
</section>
</main>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<div class="akun-container">
    <?php if ($this->session->flashdata('success')): ?>
        <p style="color:green;"><?php echo $this->session->flashdata('success'); ?></p>
        <?php elseif ($this->session->flashdata('error')): ?>
            <p style="color:red;"><?php echo $this->session->flashdata('error'); ?></p>
        <?php endif; ?>




<!-- FONT AWESOME ICON -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">




    <script type="text/javascript">
        $(document).ready(function() {
            $('#nama_kegiatan').autocomplete({
                source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nama_kegiatan",
                select: function(event, ui) {
                    $('[name="nama_kegiatan"]').val(ui.item.label);
                }
            });
            $('#no_ememo').autocomplete({
                source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_ememo",
                select: function(event, ui) {
                    $('[name="no_ememo"]').val(ui.item.label);
                }
            });
            $('#periode_penugasan').autocomplete({
                source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_periode_penugasan",
                select: function(event, ui) {
                    $('[name="periode_penugasan"]').val(ui.item.label);
                }
            });
            $('#nip').autocomplete({
                source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                select: function(event, ui) {
                    $('[name="nip"]').val(ui.item.label);
                    $('[name="nama_dosen"]').val(ui.item.name);
                    $('[name="jabatan"]').val(ui.item.jabatan);
                }
            });

        });
        var dateToday = new Date();
        $(document).ready(function() {
            $("#datepicker").datepicker({
                minDate: -49,
                dateFormat: 'dd-mm-yy'
            });
            $(function() {
                $("#datepicker2").datepicker({
                    minDate: -49,
                    maxDate: 180,
                    dateFormat: 'dd-mm-yy'
                });
            });
            $(function() {
                $("#datepicker3").datepicker({
                    minDate: -49,
                    dateFormat: 'dd-mm-yy'
                });
            });
            $(function() {
                $("#datepicker4").datepicker({
                    minDate: -49,
                    maxDate: 180,
                    dateFormat: 'dd-mm-yy'
                });
            });
            //periode penugasan
            $(function() {
                $("#periode_penugasan").datepicker({
                    dateFormat: 'dd M yy'
                });
            });
            $(function() {
                $("#periode_penugasan1").datepicker({
                    dateFormat: 'dd M yy'
                });
            });

            function toggleRequired() {
                $('input[required], select[required]').each(function() {
                    if ($(this).is(':visible')) {
                        $(this).prop('required', true);
                    } else {
                        $(this).prop('required', false);
                    }
                });
            }

            toggleRequired();

            $('.next').click(function() {
                toggleRequired();
            });

            $('.previous_button').click(function() {
                toggleRequired();
            });
        });

        //Tambah NIP
        $(document).ready(function() {
            var rowIdx = 0;
            $('#addBtn').on('click', function() {
                $('#tbody').append(`<div id="R${++rowIdx}" >
            
            <div class="show-index" id="showIndex">
                <div class="delete-index" id="remove">
                    <div class="form-group" style="margin-bottom:12px">
                        <div class="row">
                            <div class="col-md-2">
                                <input type="text" name="nip[]" class="autocomplete${rowIdx} form-control custom-form-control " id="nip" required="required" place="nip${rowIdx}">
                                <label style="margin-left:16px">NIP</label>
                            </div>
                            <div class="col-md-3">
                            <input type="text" name="nama_dosen" id="nama${rowIdx}" class=" form-control custom-form-control col-md-11" place="nama${rowIdx}" >
                            <label>Nama</label>
                            </div>
                            <div class="col-md-3">
                            <input type="text" name="jabatan" class=" form-control custom-form-control col-md-11" id="jabatan" place="jabatan${rowIdx}" >
                            <label>Jabatan</label>
                            </div>
                            <div class="col-md-3">
                            <input type="text" name="divisi[]" id="divisi" class="form-control custom-form-control col-md-11"  required="required"autocomplete="off" ><label>Divisi</label>
                            </div>
                            <div class="col-md-1">
                                <i id ="minus" class="fas fa-trash-alt " style="margin-top: 12px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			</div>`)

                $('.autocomplete1').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama1" ]').val(ui.item.name);
                        $('[place="jabatan1"]').val(ui.item.jabatan);
                    }
                });
                $('.autocomplete2').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama2" ]').val(ui.item.name);
                        $('[place="jabatan2"]').val(ui.item.jabatan);
                    }
                });
                $('.autocomplete3').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama3" ]').val(ui.item.name);
                        $('[place="jabatan3"]').val(ui.item.jabatan);
                    }
                });
                $('.autocomplete4').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama4" ]').val(ui.item.name);
                        $('[place="jabatan4"]').val(ui.item.jabatan);
                    }
                });
                $('.autocomplete5').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama5" ]').val(ui.item.name);
                        $('[place="jabatan5"]').val(ui.item.jabatan);
                    }
                });
                $('.autocomplete6').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama6" ]').val(ui.item.name);
                        $('[place="jabatan6"]').val(ui.item.jabatan);
                    }
                });
                $('.autocomplete7').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama7" ]').val(ui.item.name);
                        $('[place="jabatan7"]').val(ui.item.jabatan);
                    }
                });
                $('.autocomplete8').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama8" ]').val(ui.item.name);
                        $('[place="jabatan8"]').val(ui.item.jabatan);
                    }
                });
                $('.autocomplete9').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama9" ]').val(ui.item.name);
                        $('[place="jabatan9"]').val(ui.item.jabatan);
                    }
                });
                $('.autocomplete10').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama10" ]').val(ui.item.name);
                        $('[place="jabatan10"]').val(ui.item.jabatan);
                    }
                });
                $('.autocomplete11').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama11" ]').val(ui.item.name);
                        $('[place="jabatan11"]').val(ui.item.jabatan);
                    }
                });
                $('.autocomplete12').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama12" ]').val(ui.item.name);
                        $('[place="jabatan12"]').val(ui.item.jabatan);
                    }
                });
                $('.autocomplete13').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama13" ]').val(ui.item.name);
                        $('[place="jabatan13"]').val(ui.item.jabatan);
                    }
                });
                $('.autocomplete14').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama14" ]').val(ui.item.name);
                        $('[place="jabatan14"]').val(ui.item.jabatan);
                    }
                });
                $('.autocomplete15').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama15" ]').val(ui.item.name);
                        $('[place="jabatan15"]').val(ui.item.jabatan);
                    }
                });
                $('.autocomplete16').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama16" ]').val(ui.item.name);
                        $('[place="jabatan16"]').val(ui.item.jabatan);
                    }
                });
                $('.autocomplete17').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama17" ]').val(ui.item.name);
                        $('[place="jabatan17"]').val(ui.item.jabatan);
                    }
                });
                $('.autocomplete18').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama18" ]').val(ui.item.name);
                        $('[place="jabatan18"]').val(ui.item.jabatan);
                    }
                });
                $('.autocomplete19').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama19" ]').val(ui.item.name);
                        $('[place="jabatan19"]').val(ui.item.jabatan);
                    }
                });
                $('.autocomplete20').autocomplete({
                    source: "https://ifik.telkomuniversity.ac.id/autocomplete/get_nip",
                    select: function(event, ui) {
                        $('[place="nama20" ]').val(ui.item.name);
                        $('[place="jabatan20"]').val(ui.item.jabatan);
                    }
                });
            });
        });
        $(document).on('click', '#minus', function() {
            var myobj = document.getElementById("remove");
            myobj.remove();
        });

        //addEviden
        $(document).ready(function() {
            $('#addEviden').on('click', function() {
                $('#tambahEviden').append(`
            <div class="form-group" style="margin-bottom:12;" id="removeEviden">
                <div class="row">
                <div class="col-md-11">
                        <input type="file" name="eviden[]" id="eviden" class="form-control" style="padding:13px 16px" value="">
                        <span id="chk-error"></span>
                        <label style="margin-left:16px"></label>
                    </div>
                    <div class="col-md-1">
                        <i id="hapus" class="fas fa-trash-alt" ></i>
                    </div>
                </div>
            </div>`)
            });
        });
        $(document).on('click', '#hapus', function() {
            var myobj = document.getElementById("removeEviden");
            myobj.remove();
        });
    </script>
    <script>
        jQuery(function() {
            jQuery("#tambahPanitia").hide()
            jQuery("#tambahDivisi").hide()
            jQuery("#kepanitiaan").hide()
            jQuery("#divisi").hide()
            jQuery("#lbldivisi").hide()
            jQuery("#selectformat").hide()
            jQuery("#jenis_pengajuan").change(function() {
                var value = jQuery(this).val();
                if (value == "Kelompok") {
                    $("#tambahDivisi").show();
                    $("#kepanitiaan").show();
                    $("#tambahPanitia").show()
                    $("#divisi").show()
                    $("#lbldivisi").show()
                    $("#selectformat").show()
                } else {
                    jQuery("#tambahDivisi").hide()
                    jQuery("#tambahPanitia").hide()
                    jQuery("#kepanitiaan").hide()
                    jQuery("#divisi").hide()
                    jQuery("#lbldivisi").hide()
                    jQuery("#selectformat").hide()
                }
            });
        });
    </script>
    <script>
        jQuery(function() {
            // jQuery("#jenis_pengajuan").hide()
            jQuery("#jenis_penugasan_kelompok").hide()

            jQuery("#jenis_penugasan_perorangan").hide()
            jQuery("#jenis_pengajuan").change(function() {
                var value = jQuery(this).val();
                if (value == "Perorangan") {
                    jQuery("#jenis_penugasan_perorangan").hide()
                    $("#jenis_penugasan_perorangan").show();
                    jQuery("#penugasan_lainnya_kelompok").hide()
                } else {
                    jQuery("#jenis_penugasan_perorangan").hide()
                }
            });
        });
    </script>
    <script>
        jQuery(function() {
            // jQuery("#jenis_pengajuan").hide()
            // jQuery("#penugasan_lainnya_perorangan").hide()
            // jQuery("#penugasan_lainnya_kelompok").hide()
            jQuery("#jenis_penugasan_perorangan").hide()

            jQuery("#jenis_penugasan_kelompok").hide()
            jQuery("#jenis_pengajuan").change(function() {
                var value = jQuery(this).val();
                if (value == "Kelompok") {
                    jQuery("#jenis_penugasan_kelompok").hide()
                    $("#jenis_penugasan_kelompok").show();
                    jQuery("#penugasan_lainnya_perorangan").hide()
                } else {
                    jQuery("#jenis_penugasan_kelompok").hide()
                }
            });
        });
    </script>
    <script>
        jQuery(function() {
            jQuery("#penugasan_lainnya_perorangan").hide()
            jQuery("#jenis_penugasan_perorangan").change(function() {
                //  jQuery(this).val() == 'select' ? jQuery("#textarea").hide() : jQuery("#textarea").show();
                var value = jQuery(this).val();
                if (value == "Penugasan Lainnya") {
                    jQuery("#penugasan_lainnya_perorangan").hide()
                    $("#penugasan_lainnya_perorangan").show();
                } else {
                    jQuery("#penugasan_lainnya_perorangan").hide()
                }
            });
        });
    </script>
    <script>
        jQuery(function() {
            jQuery("#penugasan_lainnya_kelompok").hide()
            jQuery("#jenis_penugasan_kelompok").change(function() {
                //  jQuery(this).val() == 'select' ? jQuery("#textarea").hide() : jQuery("#textarea").show();
                var value = jQuery(this).val();
                if (value == "Penugasan Lainnya") {
                    jQuery("#penugasan_lainnya_kelompok").hide()
                    $("#penugasan_lainnya_kelompok").show();
                } else {
                    jQuery("#penugasan_lainnya_kelompok").hide()
                }
            });
        });
    </script>
    <script>
        jQuery(function() {
            // jQuery("#jenis_pengajuan").hide()
            jQuery("#datepicker").hide()
            jQuery("#datepicker2").hide()
            jQuery("#datepicker3").hide()
            jQuery("#datepicker4").hide()
            jQuery("#periode_value").hide()
            jQuery("#lbl_mulai").hide()
            jQuery("#lbl_mulai1").hide()
            jQuery("#lbl_akhir").hide()
            jQuery("#lbl_akhir1").hide()
            jQuery("#jenis_date").change(function() {
                var value = jQuery(this).val();
                if (value == "Custom") {
                    $("#periode_value").hide();
                    $("#lbl_mulai").show();
                    $("#lbl_mulai1").show();
                    $("#lbl_akhir").show();
                    $("#lbl_akhir1").show();
                    $("#datepicker").show();
                    $("#datepicker2").show();
                    $("#datepicker3").show();
                    $("#datepicker4").show();
                    // jQuery("#penugasan_lainnya_kelompok").hide()
                } else {
                    $("#lbl_mulai").hide();
                    $("#datepicker").hide();
                    $("#datepicker2").hide();
                    $("#datepicker3").hide();
                    $("#datepicker4").hide();
                    $("#periode_value").show();
                }
            });
        });
    </script>
    <!-- Footer -->
    <div class="footer">
        <div class="padding-t50"></div>
        <footer class="fik-footer">
            <div class="credit" style="text-align:left;padding-left:285px;border-top:1px solid #ddd;background-color:#f8f8fa">Laboratorium, Bengkel &amp; Studio FIK &copy; 2020</div>
        </footer>
    </div>

    <!-- End Footer -->

    <!-- ✅ Then load jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.min.js"></script>

    <!-- Other plugins (after jQuery UI) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.2/js/intlTelInput.min.js"></script>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-nice-select@1.1.0/js/jquery.nice-select.min.js"></script>

    <!-- Bootstrap Datepicker CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css">

    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>

    <!-- (Opsional) Bahasa Indonesia -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/locales/bootstrap-datepicker.id.min.js"></script>

    <!-- Your custom scripts (load last) -->
    <script src="https://ifik.telkomuniversity.ac.id/assets/js/tambahan.js"></script>
    <script src="./js/script.js"></script>
    <script>
        $(document).ready(function() {
            $('#chatSection').TrackpadScrollEmulator();
        });
    </script>

<script>
$(document).ready(function() {

    // 1️⃣ Inisialisasi Nice Select untuk semua select yang pakai class .nice
    $('select.nice').niceSelect();

    // 2️⃣ Hide semua elemen tanggal & periode awal
    $("#datepicker, #datepicker2, #datepicker3, #datepicker4, #lbl_mulai, #lbl_mulai1, #lbl_akhir, #lbl_akhir1").hide();
    $("#periode_value").closest('.nice-select').hide(); // hide wrapper Nice Select

    // 3️⃣ Fungsi toggle untuk #jenis_date
    function toggleJenisDate(value) {
        if (value === "Custom") {
            $("#periode_value").closest('.nice-select').hide(); 
            $("#lbl_mulai, #lbl_mulai1, #lbl_akhir, #lbl_akhir1, #datepicker, #datepicker2, #datepicker3, #datepicker4").show();
        } else {
            $("#periode_value").closest('.nice-select').show();
            $("#lbl_mulai, #lbl_mulai1, #lbl_akhir, #lbl_akhir1, #datepicker, #datepicker2, #datepicker3, #datepicker4").hide();
        }
    }

    // 4️⃣ Bind change event untuk #jenis_date
    $('#jenis_date').on('change', function() {
        toggleJenisDate($(this).val());
    });

    // 5️⃣ Multi-step form setup
    const fieldsets = $('fieldset');
    const totalSteps = fieldsets.length;
    let currentStep = 0;

    const updateProgress = () => {
        const percent = ((currentStep + 1) / totalSteps) * 100;
        $('#progressBar').css('width', percent + '%');
        $('#currentStep').text(currentStep + 1);

        // Tombol Back hanya muncul jika bukan langkah pertama
        $('.prev-btn').toggle(currentStep > 0);

        // Ganti teks tombol Next jadi Finish di langkah terakhir
        $('.next-btn').text(currentStep === totalSteps - 1 ? 'Finish' : 'Continue');
    };

    updateProgress();

    $('.next-btn').click(function() {
        if (currentStep < totalSteps - 1) {
            // Pindah ke step berikutnya
            fieldsets.eq(currentStep).removeClass('active');
            currentStep++;
            fieldsets.eq(currentStep).addClass('active');
            updateProgress();
        } else {
            // Step terakhir → submit form
            $('#msform').submit(); 
        }
    });

    $('.prev-btn').click(function() {
        if (currentStep > 0) {
            fieldsets.eq(currentStep).removeClass('active');
            currentStep--;
            fieldsets.eq(currentStep).addClass('active');
            updateProgress();
        }
    });

    // 6️⃣ Jika ada select tambahan yang ingin toggle lain, bisa bind di sini
    $('#periode_value').on('change', function() {
        const value = $(this).val();
        console.log("Periode dipilih:", value);
        // Tambahkan logika tambahan jika perlu
    });

});

// ========================================
// 1. FUNGSI LOADING SCREEN
// ========================================
function showLoadingScreen(message = 'Mengirim Pengajuan Surat Tugas...') {
    const loadingOverlay = document.getElementById('loadingOverlay');
    if (loadingOverlay) {
        loadingOverlay.querySelector('.loading-text').textContent = message;
        loadingOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        console.log('🔄 Loading screen aktif:', message);
    }
}

function hideLoadingScreen() {
    const loadingOverlay = document.getElementById('loadingOverlay');
    if (loadingOverlay) {
        loadingOverlay.classList.remove('active');
        document.body.style.overflow = '';
        console.log('✅ Loading screen non-aktif');
    }
}

// ========================================
// 2. HAPUS PESAN "LEAVE SITE?"
// ========================================
window.onbeforeunload = null;

// ========================================
// 4. MULTI-STEP NAVIGATION DENGAN VALIDASI
// ========================================
let currentStep = 0;
const fieldsets = $('fieldset');
const totalSteps = fieldsets.length;
let isSubmitting = false;

function updateProgress() {
    const percent = ((currentStep + 1) / totalSteps) * 100;
    $('#progressBar').css('width', percent + '%');
    $('#currentStep').text(currentStep + 1);
    $('#totalSteps').text(totalSteps);
    
    // Toggle tombol Back
    $('.prev-btn').toggle(currentStep > 0);
    
    // Update teks tombol Next
    const nextBtn = $('.next-btn');
    if (currentStep === totalSteps - 1) {
        nextBtn.text('Finish');
        nextBtn.removeClass('btn-primary').addClass('btn-success');
    } else {
        nextBtn.text('Continue');
        nextBtn.removeClass('btn-success').addClass('btn-primary');
    }
}

// Tombol Back
$('.prev-btn').off('click').on('click', function(e) {
    e.preventDefault();
    
    if (currentStep > 0) {
        fieldsets.eq(currentStep).removeClass('active');
        currentStep--;
        fieldsets.eq(currentStep).addClass('active');
        updateProgress();
        
        // Scroll ke atas form
        $('html, body').animate({
            scrollTop: $('.multi-step-form').offset().top - 100
        }, 300);
    }
});

// ========================================
// 5. AJAX FORM SUBMIT DENGAN LOADING SCREEN
// ========================================
$('#msform').off('submit').on('submit', function(e) {
    e.preventDefault();
    
    console.log('🚀 Form submit diproses...');
    
    // Cegah double submit
    if (isSubmitting) {
        console.log('⚠ Form sedang diproses, tunggu...');
        return false;
    }

    isSubmitting = true;
    
    // Tampilkan loading screen
    showLoadingScreen('Mengirim pengajuan surat tugas...');
    
    // Siapkan form data
    const formData = new FormData(this);
    
    // Debug: log data yang akan dikirim
    console.log('📤 Data yang akan dikirim:');
    for (let pair of formData.entries()) {
        if (pair[0] === 'eviden') {
            console.log('📎 Eviden:', pair[1]);
        } else {
            console.log(pair[0] + ': ' + pair[1]);
        }
    }
    
    // Kirim via AJAX
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        timeout: 30000, // 30 detik timeout
        beforeSend: function() {
            console.log('🔄 Mengirim request ke server...');
        },
        success: function(response, status, xhr) {
            console.log('✅ Response sukses:', response);
            hideLoadingScreen();
            isSubmitting = false;
            
            // Cek jika response adalah JSON
            let responseData;
            try {
                responseData = typeof response === 'string' ? JSON.parse(response) : response;
            } catch (e) {
                responseData = { success: true, message: 'Pengajuan berhasil dikirim!' };
            }
            
            // Tampilkan pesan sukses
            if (responseData.success) {
                // Redirect ke halaman list surat tugas
                setTimeout(function() {
                    window.location.href = "<?= base_url('list-surat-tugas') ?>?success=1&id=" + (responseData.id || '');
                }, 1500);
                
                // Tampilkan pesan sementara
                $('.multi-step-form').html(`
                    <div class="text-center py-5">
                        <div style="font-size: 80px; color: #28a745; margin-bottom: 20px;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3 class="text-success">Pengajuan Berhasil!</h3>
                        <p class="text-muted">Surat tugas Anda telah berhasil diajukan.</p>
                        <p class="text-muted"><small>Mengalihkan ke halaman daftar surat...</small></p>
                    </div>
                `);
            } else {
                alert('❌ ' + (responseData.message || 'Terjadi kesalahan pada server'));
                hideLoadingScreen();
                isSubmitting = false;
            }
        },
        error: function(xhr, status, error) {
            console.error('❌ Error AJAX:', status, error);
            hideLoadingScreen();
            isSubmitting = false;
            
            let errorMessage = 'Terjadi kesalahan saat mengirim pengajuan. ';
            
            if (xhr.status === 0) {
                errorMessage += 'Koneksi internet terputus atau server tidak merespon.';
            } else if (xhr.status === 400) {
                errorMessage += 'Data yang dikirim tidak valid.';
            } else if (xhr.status === 500) {
                errorMessage += 'Terjadi kesalahan internal server.';
            } else {
                errorMessage += 'Error ' + xhr.status + ': ' + (xhr.responseText || error);
            }
            
            alert('❌ ' + errorMessage);
            
            // Enable form kembali
            $('button[type="submit"]').prop('disabled', false);
        },
        complete: function() {
            console.log('✅ Request selesai');
        }
    });
});

// ========================================
// 6. INITIAL SETUP SAAT DOM READY
// ========================================
$(document).ready(function() {
    console.log('📄 Document ready, initializing form...');
    
    // Inisialisasi progress
    updateProgress();
    
    // Hapus beforeunload handler
    window.onbeforeunload = null;
    
    // Setup Nice Select
    if ($.fn.niceSelect) {
        $('select.nice').niceSelect();
    }
    
    // Inisialisasi datepicker (jika belum)
    if ($.fn.datepicker) {
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true
        });
    }
    
    // Setup event untuk jenis_date
    $('#jenis_date').on('change', function() {
        const value = $(this).val();
        const periodeSection = $('#periode_section');
        const customDateSection = $('.row .col-md-3.mt-3');
        
        if (value === 'Periode') {
            periodeSection.show();
            customDateSection.hide();
        } else if (value === 'Custom') {
            periodeSection.hide();
            customDateSection.show();
        }
    });
    
    // Setup event untuk jenis_pengajuan
    $('#jenis_pengajuan').on('change', function() {
        const value = $(this).val();
        const buttonCells = $('.button-cell');
        
        if (value === 'Kelompok') {
            buttonCells.css('display', 'flex');
            $('#jenis_penugasan_kelompok_container').show();
            $('#jenis_penugasan_perorangan_container').hide();
        } else {
            buttonCells.css('display', 'none');
            $('#jenis_penugasan_kelompok_container').hide();
            $('#jenis_penugasan_perorangan_container').show();
        }
    });
    
    // Setup untuk "Lainnya" option
    $('#jenis_penugasan_perorangan, #jenis_penugasan_kelompok').on('change', function() {
        const value = $(this).val();
        const isPerorangan = $(this).attr('id') === 'jenis_penugasan_perorangan';
        const lainnyaInput = isPerorangan ? $('#penugasan_lainnya_perorangan') : $('#penugasan_lainnya_kelompok');
        
        if (value === 'Penugasan Lainnya') {
            lainnyaInput.show().focus();
        } else {
            lainnyaInput.hide().val('');
        }
    });
    
    // Sembunyikan loading jika ada pesan dari session
    <?php if ($this->session->flashdata('error') || $this->session->flashdata('success')): ?>
        setTimeout(function() {
            hideLoadingScreen();
            isSubmitting = false;
        }, 100);
    <?php endif; ?>
    
    console.log('✅ Form initialization complete');
});

// ========================================
// 8. HANDLE UPLOADCARE SUCCESS
// ========================================
// Fungsi ini akan dipanggil oleh Uploadcare ketika upload selesai
window.updateEvidenList = function(files) {
    console.log('📁 File diupload:', files);
    
    // Update display
    const uploadedFiles = [];
    const filesList = $('#files-list');
    filesList.empty();
    
    files.forEach((file, index) => {
        uploadedFiles.push(file.cdnUrl);
        
        const fileName = file.name || `File ${index + 1}`;
        const fileSize = file.size ? `(${(file.size / 1024 / 1024).toFixed(2)} MB)` : '';
        
        const fileItem = $(`
            <div class="file-item mb-2 p-2 border rounded" style="background: #f8f9fa;">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-file-alt text-muted me-2"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold">${fileName}</div>
                        <small class="text-muted">${fileSize}</small>
                    </div>
                    <div class="flex-shrink-0">
                        <button type="button" class="btn btn-sm btn-danger remove-file" data-index="${index}">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        `);
        
        filesList.append(fileItem);
    });
    
    // Update hidden input
    $('#eviden').val(JSON.stringify(uploadedFiles));
    
    // Tampilkan container jika ada file
    if (uploadedFiles.length > 0) {
        $('#uploaded-files-display').show();
    }
    
    // Event untuk tombol hapus
    $('.remove-file').off('click').on('click', function() {
        const index = $(this).data('index');
        files.splice(index, 1);
        window.updateEvidenList(files);
    });
};

// ========================================
// 9. RESET FORM FLAG JIKA PAGE DIBUKA KEMBALI
// ========================================
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        // Page di-load dari cache (back/forward)
        hideLoadingScreen();
        isSubmitting = false;
        console.log('🔄 Page di-load dari cache, reset flag');
    }
});
</script>

<!-- ============================ -->
<!-- LOADING SCREEN HTML          -->
<!-- ============================ -->
<div id="loadingOverlay" class="loading-overlay">
    <div class="loading-spinner"></div>
    <div class="loading-text">Mengirim Pengajuan Surat Tugas</div>
    <div class="loading-details">
        <p><i class="fas fa-sync-alt fa-spin"></i> Mohon tunggu sejenak. Pengajuan surat tugas sedang diproses.</p>
        <p><i class="fas fa-exclamation-circle"></i> Jangan tutup atau refresh halaman ini.</p>
        <p><small>Proses mungkin memakan waktu beberapa detik...</small></p>
    </div>
</div>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

</body>

</html>