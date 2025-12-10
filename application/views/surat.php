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
    opacity: 0;
    position: absolute;  /* Non-aktif: absolute */
    width: 100%;
    top: 0;
    left: 0;
}

fieldset.active {
    display: block;
    opacity: 1;
    position: relative;  /* Aktif: relative - INI KUNCI NYA! */
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
             margin-top: -10px !important; /* Atur nilai negatif untuk naik */
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
<!-- MODAL GLOBAL (diletakkan di luar semua fieldset) -->
<div id="global-validation-modal" class="global-validation-modal" style="display: none;">
    <div class="modal-overlay" onclick="closeGlobalModal()"></div>
    <div class="modal-container">
        <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Perhatian</h5>
            <button type="button" class="modal-close-btn" onclick="closeGlobalModal()">×</button>
        </div>
        <div class="modal-body">
            <p>Beberapa kolom belum terisi dengan lengkap:</p>
            <ul id="global-modal-errors"></ul>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="closeGlobalModal()">Mengerti</button>
        </div>
    </div>
</div>

<!-- CONTAINER UNTUK SEMUA STEP -->
<div class="step-container">
    <!-- Step 1 -->
    <fieldset class="active step-1">
        <!-- Validation summary (tidak digunakan untuk modal) -->
        <div class="validation-summary" id="validation-summary-step1" style="display: none;">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Perhatian!</strong> Beberapa kolom belum terisi dengan lengkap:
                <ul id="validation-errors-step1"></ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>

        <!-- Jenis Pengajuan & Status -->
        <div class="row mb-3">
            <div class="col-md-6">
                <select class="form-control" name="jenis_pengajuan" id="jenis_pengajuan" required>
                    <option disabled selected value="">Jenis Pengajuan</option>
                    <option value="Kelompok">Kelompok</option>
                    <option value="Perorangan">Perorangan</option>
                </select>
                <div class="error-message" id="error-jenis_pengajuan"></div>
            </div>

            <div class="col-md-6">
                <select class="form-control" name="lingkup_penugasan" id="lingkup_penugasan" required>
                    <option disabled selected value="">Status Kepegawaian</option>
                    <option value="Dosen">Dosen</option>
                    <option value="TPA">TPA</option>
                    <option value="Dosen dan TPA">Dosen dan TPA</option>
                </select>
                <div class="error-message" id="error-lingkup_penugasan"></div>
            </div>
        </div>

        <!-- Jenis Penugasan Perorangan -->
        <div class="form-group has-select mb-3" id="jenis_penugasan_perorangan_container" style="display: none;">
            <select class="form-control" name="jenis_penugasan" id="jenis_penugasan_perorangan">
                <option disabled selected value="">Jenis Penugasan</option>
                <option value="Juri">Juri</option>
                <option value="Pembicara">Pembicara</option>
                <option value="Narasumber">Narasumber</option>
                <option value="Penugasan Lainnya">Lainnya</option>
            </select>
            <div class="error-message" id="error-jenis_penugasan_perorangan"></div>

            <input type="text" class="form-control custom-form-control"
                   name="penugasan_lainnya_perorangan" id="penugasan_lainnya_perorangan"
                   placeholder="Masukan Jenis Penugasan Lainnya"
                   style="margin-top:12px; display:none;">
            <div class="error-message" id="error-penugasan_lainnya_perorangan"></div>
        </div>

        <!-- Jenis Penugasan Kelompok -->
        <div class="form-group has-select mb-3" id="jenis_penugasan_kelompok_container" style="display: none;">
            <select class="form-control" name="jenis_penugasan_kelompok" id="jenis_penugasan_kelompok">
                <option disabled selected value="">Jenis Penugasan</option>
                <option value="Tim">Tim</option>
                <option value="Kepanitiaan">Kepanitiaan</option>
                <option value="Penugasan Lainnya">Lainnya</option>
            </select>
            <div class="error-message" id="error-jenis_penugasan_kelompok"></div>

            <input type="text" class="form-control custom-form-control"
                   name="penugasan_lainnya_kelompok" id="penugasan_lainnya_kelompok"
                   placeholder="Masukan Jenis Penugasan Lainnya"
                   style="margin-top:12px; display:none;">
            <div class="error-message" id="error-penugasan_lainnya_kelompok"></div>
        </div>

        <!-- FORM PANITIA -->
        <div id="panitiaContainer" class="mt-4">
            <div class="row g-3 align-items-end panitia-row" data-row-index="0">
                <div class="col-md-2 position-relative">
                    <label>NIP</label>
                    <input type="text" name="nip[]" class="form-control nip-input" autocomplete="off" required>
                    <div class="error-message" id="error-nip-0"></div>
                </div>

                <div class="col-md-2 position-relative">
                    <label>Nama Dosen</label>
                    <input type="text" name="nama_dosen[]" class="form-control nama-dosen-input" autocomplete="off" required>
                    <div class="error-message" id="error-nama_dosen-0"></div>
                </div>

                <div class="col-md-2 position-relative">
                    <label>Jabatan</label>
                    <input type="text" name="jabatan[]" class="form-control jabatan-input" autocomplete="off" required>
                    <div class="error-message" id="error-jabatan-0"></div>
                </div>

                <div class="col-md-2 position-relative">
                    <label>Kaprodi</label>
                    <input type="text" name="kaprodi[]" class="form-control kaprodi-input" autocomplete="off" required>
                    <div class="error-message" id="error-kaprodi-0"></div>
                </div>

                <div class="col-md-3 position-relative peran-column">
                    <label>Peran</label>
                    <input type="text" name="peran[]" class="form-control peran-input" autocomplete="off" placeholder="Masukkan peran/posisi">
                    <div class="error-message" id="error-peran-0"></div>
                </div>

                <div class="col-md-1 text-center button-cell">
                    <button type="button" class="btn btn-success add-row-btn" title="Tambah Baris">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Hidden input untuk menangkap peran untuk jenis perorangan -->
        <input type="hidden" name="peran_perorangan" id="peran_perorangan" value="">
    </fieldset>

    <!-- Step 2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <fieldset class="step-2">
      <div class="custom-form">
        <input type="hidden" name="user_id" id="user_id" value="632045c808b1c">

        <!-- Nama kegiatan -->
        <div class="form-group mb-4">
          <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control step2-input" required autocomplete="off">
          <label>Nama Kegiatan</label>
          <div class="error-message" id="error-nama_kegiatan"></div>
        </div>

        <!-- Pilihan jenis tanggal -->
        <div class="form-group has-select mb-4">
          <select class="nice form-control step2-input" name="jenis_date" id="jenis_date" required>
            <option disabled selected value="">Tanggal Kegiatan</option>
            <option value="Periode">Periode</option>
            <option value="Custom">Custom</option>
          </select>
          <div class="error-message" id="error-jenis_date"></div>
        </div>

        <div class="row">
          <!-- Tanggal awal & akhir kegiatan -->
          <div class="col-md-4 mt-3">
            <div class="form-group">
              <input type="text" id="datepicker" class="form-control step2-input custom-form-control"
                     autocomplete="off" inputmode="none" readonly
                     placeholder="Klik untuk pilih tanggal">

              <label id="lbl_mulai">Tanggal Awal s/d Akhir</label>
              <div class="error-message" id="error-datepicker"></div>

              <!-- Hidden input -->
              <input type="hidden" id="tanggal_awal_kegiatan" name="tanggal_awal_kegiatan">
              <input type="hidden" id="tanggal_akhir_kegiatan" name="tanggal_akhir_kegiatan">

              <!-- Konfirmasi tanggal -->
              <div id="konfirmasi_tanggal" class="small mt-2" style="display: none;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <span class="text-success">✓ Tanggal dipilih:</span>
                </div>
                <div class="d-flex flex-column">
                  <span id="konfirmasi_awal" class="text-muted small date-display"></span>
                  <span id="konfirmasi_akhir" class="text-muted small date-display"></span>
                </div>
              </div>

              <div class="info-message small mt-1" id="range_info">
                Klik tanggal awal, lalu klik tanggal akhir
              </div>
            </div>
          </div>

          <!-- Periode penugasan -->
          <div class="col-md-4 mt-3">
            <div class="form-group">
              <input type="text" name="periode_penugasan" id="datepicker3"
                     class="form-control step2-input custom-form-control"
                     autocomplete="off" inputmode="none" readonly
                     placeholder="Otomatis terisi">

              <label id="lbl_mulai1">Periode Penugasan</label>
              <div class="error-message" id="error-periode_penugasan"></div>
              <div class="info-message small" id="info_periode">Akan terisi otomatis</div>
            </div>
          </div>

          <!-- Akhir penugasan -->
          <div class="col-md-4 mt-3">
            <div class="form-group">
              <input type="text" name="akhir_periode_penugasan" id="datepicker4"
                     class="form-control step2-input custom-form-control"
                     autocomplete="off" inputmode="none" readonly
                     placeholder="Otomatis terisi">

              <label id="lbl_akhir1">Akhir Penugasan</label>
              <div class="error-message" id="error-akhir_periode_penugasan"></div>
              <div class="info-message small" id="info_akhir">Akan terisi otomatis</div>
            </div>
          </div>
        </div>

        <!-- Dropdown periode -->
        <div id="periode_section" class="form-group has-select" 
             style="display:none; position:relative; margin-top: 20px; margin-bottom: 60px;">
          <select class="nice form-control step2-input" name="periode_value" id="periode_value">
            <option disabled selected value="">Pilih Periode</option>
            <option value="2024/2025 Ganjil">2024/2025 Ganjil</option>
            <option value="2024/2025 Genap">2024/2025 Genap</option>
            <option value="2025/2026 Ganjil">2025/2026 Ganjil</option>
            <option value="2025/2026 Genap">2025/2026 Genap</option>
          </select>
          <div class="error-message" id="error-periode_value"></div>
        </div>

        <!-- Tempat kegiatan -->
        <div class="form-group mb-4">
          <input type="text" name="tempat_kegiatan" id="tempat_kegiatan" class="form-control step2-input custom-form-control" 
                 required autocomplete="off">
          <label>Tempat Kegiatan</label>
          <div class="error-message" id="error-tempat_kegiatan"></div>
        </div>

        <!-- Penyelenggara -->
        <div class="form-group mb-4">
          <input type="text" name="penyelenggara" id="penyelenggara" class="form-control step2-input custom-form-control" 
                 required autocomplete="off">
          <label>Penyelenggara</label>
          <div class="error-message" id="error-penyelenggara"></div>
        </div>
      </div>
    </fieldset>

<!-- Step 3 (Upload File) -->
<!-- ===== UPLOADCARE CDN ===== -->
<script>
UPLOADCARE_PUBLIC_KEY = "3438a2ee1b7dd183914c";
</script>
<script src="https://ucarecdn.com/libs/widget/3.x/uploadcare.full.min.js"></script>

<fieldset class="step-3">
    <!-- Container untuk pesan validasi Step 3 (akan muncul saat user belum upload file) -->
    <div id="step3-validation-info" class="validation-info-container" style="display: none;">
        <div class="alert alert-warning d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <div>
                <strong>Perhatian!</strong> Anda harus mengupload minimal 1 file eviden sebelum melanjutkan.
            </div>
        </div>
    </div>

    <!-- Modal popup untuk validasi error (akan muncul saat klik Continue tanpa file) -->
    <div id="validation-modal-step3" class="step3-validation-modal" style="display: none;">
        <div class="modal-overlay" onclick="closeStep3ValidationModal()"></div>
        <div class="modal-container">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Validasi Error</h5>
                <button type="button" class="modal-close-btn" onclick="closeStep3ValidationModal()">×</button>
            </div>
            <div class="modal-body">
                <p class="mb-2"><strong>File eviden belum diupload!</strong></p>
                <p>Untuk melanjutkan ke step berikutnya, Anda harus:</p>
                <ol class="mb-0">
                    <li>Klik tombol <strong>"Tambah File"</strong> di bawah</li>
                    <li>Upload minimal 1 file eviden</li>
                    <li>Pastikan file sudah muncul di daftar "File yang sudah diupload"</li>
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="closeStep3ValidationModal()">
                    <i class="fas fa-check me-1"></i> Mengerti
                </button>
            </div>
        </div>
    </div>

    <div class="upload-container">
        <div class="upload-header">
            <label class="upload-title">
                <i class="fas fa-cloud-upload-alt"></i> Upload File Eviden <span class="text-danger">*</span>
            </label>
            <p class="upload-description">
                <strong>Minimal 1 file</strong> harus diupload sebelum melanjutkan. Anda dapat menambahkan beberapa file.
            </p>
            
            <!-- Pesan error real-time -->
            <div class="error-message" id="error-evidens" style="display: none;">
                <i class="fas fa-exclamation-circle me-1"></i>
                <span id="error-evidens-text">Minimal 1 file eviden harus diupload</span>
            </div>
        </div>

        <!-- BUTTON UNTUK UPLOAD FILE -->
        <div class="upload-button-container">
            <button type="button" id="upload-btn" class="btn btn-primary upload-main-btn">
                <i class="fas fa-plus-circle me-1"></i> Tambah File
            </button>
            <small class="upload-hint">Klik untuk menambah file eviden</small>
        </div>

        <!-- KONTAINER UPLOADCARE (akan muncul saat button diklik) -->
        <div id="eviden-panel" class="uploadcare-panel"></div>

        <!-- Hidden input untuk simpan URL -->
        <input type="hidden" name="eviden" id="eviden" value="[]">
        
        <!-- Display uploaded files -->
        <div id="uploaded-files-display" class="uploaded-files-container">
            <div class="uploaded-files-inner">
                <div class="uploaded-files-header">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    <span class="uploaded-files-title">
                        File yang sudah diupload (<span id="total-files" class="file-count">0</span>)
                    </span>
                </div>
                <div id="files-list" class="files-list-container"></div>
                
                <!-- Status upload -->
                <div class="upload-status mt-3" id="upload-status">
                    <div class="status-item" id="status-minimal">
                        <i class="fas fa-times-circle text-danger me-2"></i>
                        <span>Minimal 1 file: <strong>Belum terpenuhi</strong></span>
                    </div>
                    <div class="status-item" id="status-ready">
                        <i class="fas fa-check-circle text-success me-2" style="display: none;"></i>
                        <i class="fas fa-times-circle text-danger me-2"></i>
                        <span>Siap lanjut ke step berikutnya: <strong>Belum</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</fieldset>

<!-- BUTTON AREA -->
<div class="button-area">
    <button type="button" class="btn btn-secondary prev-btn rounded-pill btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back
    </button>
    <button type="button" class="btn btn-primary next-btn rounded-pill btn-sm">
        Continue <i class="fas fa-arrow-right ms-1"></i>
    </button>
</div>

<style>
    
/* ===== GLOBAL MODAL STYLES ===== */
.global-validation-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999999 !important;
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    z-index: 1;
}

.modal-container {
    position: relative;
    z-index: 2;
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow: hidden;
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-header {
    padding: 20px;
    background-color: #fff3cd;
    border-bottom: 1px solid #ffc107;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    color: #856404;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.modal-title i {
    color: #ffc107;
    font-size: 20px;
}

.modal-close-btn {
    background: none;
    border: none;
    font-size: 28px;
    color: #856404;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background-color 0.2s;
}

.modal-close-btn:hover {
    background-color: rgba(0, 0, 0, 0.1);
}

.modal-body {
    padding: 25px;
    max-height: 400px;
    overflow-y: auto;
}

.modal-body p {
    color: #856404;
    font-weight: 500;
    margin-bottom: 15px;
    font-size: 16px;
}

.modal-body ul {
    margin: 0;
    padding-left: 20px;
}

.modal-body li {
    color: #856404;
    margin-bottom: 10px;
    font-size: 14px;
    line-height: 1.5;
}

.modal-footer {
    padding: 20px;
    border-top: 1px solid #dee2e6;
    display: flex;
    justify-content: flex-end;
}

.modal-footer .btn {
    padding: 10px 30px;
    font-weight: 500;
    background-color: #007bff;
    border-color: #007bff;
    color: white;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s;
    border: none;
    font-size: 14px;
}

.modal-footer .btn:hover {
    background-color: #0056b3;
}

/* ===== STEP CONTAINER STYLES ===== */
.step-container {
    position: relative;
    min-height: 400px;
    width: 100%;
}

/* PERBAIKAN: Setiap fieldset harus menempati ruang sendiri */
fieldset {
    width: 100%;
    padding: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border: 1px solid #eaeaea;
    margin-bottom: 20px;
    opacity: 0;
    visibility: hidden;
    height: 0;
    overflow: hidden;
    transition: opacity 0.3s ease, height 0.3s ease;
    position: absolute;
    top: 0;
    left: 0;
}

fieldset.active {
    opacity: 1;
    visibility: visible;
    height: auto;
    position: relative;
    overflow: visible;
}

/* ===== FORM STYLES ===== */
.form-group {
    margin-bottom: 1.5rem;
}

.form-control {
    border-radius: 6px;
    padding: 10px 12px;
    border: 1px solid #ced4da;
    transition: border-color 0.3s;
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* ===== AUTOCOMPLETE STYLES ===== */
.autocomplete-box-fixed {
    position: fixed;
    background: #ffffff;
    border: none;
    z-index: 99999;
    max-height: 400px;
    overflow-y: auto;
    box-shadow: 0 6px 12px rgba(32,33,36,0.35);
    border-radius: 8px;
    font-size: 14px;
    padding: 8px 0;
    margin-top: 4px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    min-width: 320px;
    border: 1px solid #dfe1e5;
}

.autocomplete-item {
    padding: 0;
    cursor: pointer;
    transition: background-color 0.15s ease;
    border: none;
    line-height: 1.5;
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
}

.autocomplete-item:hover,
.autocomplete-item.active {
    background: #f8f9fa;
}

.autocomplete-icon {
    width: 24px;
    height: 24px;
    margin-left: 16px;
    flex-shrink: 0;
    opacity: 0.7;
}

.autocomplete-icon svg {
    width: 20px;
    height: 20px;
    fill: #5f6368;
}

.autocomplete-content {
    display: flex;
    flex-direction: column;
    gap: 4px;
    padding: 12px 16px 12px 0;
    flex: 1;
    min-width: 0;
}

.autocomplete-item .item-primary {
    font-size: 15px;
    color: #202124;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    letter-spacing: 0.2px;
}

.autocomplete-item .item-secondary {
    font-size: 13px;
    color: #5f6368;
    font-weight: 400;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.query-match {
    font-weight: 700;
    color: #1a73e8;
    background-color: rgba(26, 115, 232, 0.1);
    padding: 1px 2px;
    border-radius: 2px;
}

/* Error message styling */
.error-message {
    color: #dc3545;
    font-size: 12px;
    margin-top: 5px;
    display: none;
    padding: 8px 12px;
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    border-radius: 4px;
    font-weight: 500;
}

.form-control.error {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

/* Button styling */
.button-cell { 
    display: none; 
    justify-content: center; 
    align-items: center; 
}

.add-row-btn, .remove-row-btn { 
    width: 35px; 
    height: 35px; 
    border-radius: 50%; 
    padding: 0; 
}

.panitia-row { 
    transition: all 0.3s ease; 
}

/* Validation Styles */
.validation-summary {
    margin-bottom: 20px;
}

.validation-summary .alert {
    border-radius: 8px;
    padding: 15px;
    border: 1px solid #ffc107;
}

.validation-summary ul {
    margin-bottom: 0;
    padding-left: 20px;
    margin-top: 10px;
}

.validation-summary li {
    margin-bottom: 5px;
    font-size: 14px;
    color: #856404;
}

/* Step 2 specific styles */
.custom-form-control {
    padding: 12px 14px;
    font-size: 14px;
    height: 46px;
    border: 1px solid #ced4da;
    border-radius: 6px;
    width: 100%;
    transition: border-color 0.3s, background-color 0.3s;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.step2-input {
    font-size: 14px !important;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
}

.date-display {
    font-size: 13px !important;
    font-weight: 500;
    color: #495057;
}

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

/* Style untuk konfirmasi tanggal */
#konfirmasi_tanggal {
    background-color: #f8f9fa;
    border-radius: 6px;
    padding: 10px 12px;
    border-left: 3px solid #28a745;
    margin-top: 8px;
}

.info-message {
    color: #0d6efd;
    font-size: 12px;
    margin-top: 5px;
    font-weight: 500;
}

/* Hide native datepicker */
input::-webkit-calendar-picker-indicator {
    display: none !important;
    opacity: 0 !important;
    pointer-events: none !important;
}

/* Step 3 Styles */
.upload-container {
    width: 100%;
}

.upload-header {
    margin-bottom: 20px;
}

.upload-header label {
    display: block;
    font-weight: 600;
    margin-bottom: 10px;
    color: #333;
    font-size: 16px;
}

.upload-header label i {
    margin-right: 8px;
}

.upload-description {
    font-size: 13px;
    color: #6c757d;
    margin-bottom: 15px;
}

.upload-button-container {
    margin-bottom: 20px;
}

#upload-btn {
    padding: 10px 20px;
    border-radius: 8px;
    background: #007bff;
    border: none;
    color: white;
    cursor: pointer;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background-color 0.3s;
}

#upload-btn:hover {
    background: #0056b3;
}

.uploadcare-panel {
    display: none;
    min-height: 420px;
    border: 1px solid #ddd;
    border-radius: 10px;
    margin-bottom: 20px;
}

.uploaded-files-container {
    display: none;
}

.uploaded-files-inner {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    border: 1px solid #dee2e6;
}

.uploaded-files-inner h6 {
    font-weight: 600;
    margin-bottom: 10px;
    color: #495057;
    font-size: 14px;
}

.uploaded-files-inner h6 i {
    margin-right: 8px;
}

#files-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.file-item {
    display: flex;
    align-items: center;
    padding: 10px;
    background: white;
    border-radius: 6px;
    border: 1px solid #eaeaea;
    gap: 12px;
}

.file-icon {
    flex-shrink: 0;
}

.file-info {
    flex: 1;
    min-width: 0;
}

.file-name {
    font-weight: 500;
    color: #333;
    margin-bottom: 4px;
    font-size: 14px;
}

.file-url {
    font-size: 12px;
    color: #6c757d;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.btn-remove {
    background: #dc3545;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
    transition: background-color 0.3s;
    display: flex;
    align-items: center;
    gap: 5px;
}

.btn-remove:hover {
    background: #c82333;
}

/* Step 3 Modal Styles */
.step-3 .validation-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 999999 !important;
}

.step-3 .validation-modal .modal-dialog {
    max-width: 500px;
    width: 90%;
    z-index: 999999 !important;
}

.step-3 .validation-modal .modal-content {
    border-radius: 12px;
    overflow: hidden;
    background-color: white;
    z-index: 999999 !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.step-3 .validation-modal .modal-header {
    background-color: #fff3cd;
    border-bottom: 2px solid #ffc107;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.step-3 .validation-modal .modal-body {
    padding: 20px;
    max-height: 350px;
    overflow-y: auto;
}

.step-3 .validation-modal ul {
    margin: 0;
    padding-left: 20px;
}

.step-3 .validation-modal li {
    color: #856404;
    margin-bottom: 8px;
    font-size: 14px;
    padding: 5px 0;
}

.step-3 .validation-modal .modal-footer {
    padding: 15px 20px;
    border-top: 1px solid #dee2e6;
    display: flex;
    justify-content: flex-end;
}

.step-3 .validation-modal .modal-footer .btn {
    padding: 8px 20px;
    background-color: #0d6efd;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 500;
}

/* BUTTON AREA STYLES */
.button-area {
    margin-top: 25px;
    text-align: center;
    position: relative;
    z-index: 1;
    padding: 20px;
    border-top: 1px solid #eaeaea;
    background: white;
    border-radius: 0 0 10px 10px;
}

.prev-btn, .next-btn {
    padding: 8px 24px !important;
    margin: 0 5px;
    font-size: 14px;
}

.prev-btn {
    background: #6c757d;
    border-color: #6c757d;
}

.prev-btn:hover {
    background: #5a6268;
    border-color: #545b62;
}

.next-btn {
    background: #007bff;
    border-color: #007bff;
}

.next-btn:hover {
    background: #0056b3;
    border-color: #004085;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .modal-container {
        width: 95%;
        margin: 10px;
    }
    
    .modal-header {
        padding: 15px;
    }
    
    .modal-body {
        padding: 15px;
    }
    
    .modal-footer {
        padding: 15px;
    }
    
    .modal-footer .btn {
        padding: 8px 20px;
        width: 100%;
    }
    
    .autocomplete-box-fixed {
        min-width: calc(100vw - 40px);
        left: 20px !important;
        font-size: 13px;
    }
    
    .col-md-4, .col-md-3, .col-md-2 {
        flex: 0 0 100%;
        max-width: 100%;
        margin-bottom: 15px;
    }
    
    .custom-form-control {
        height: 44px;
        font-size: 13px;
    }
    
    #konfirmasi_tanggal {
        padding: 8px 10px;
        font-size: 12px;
    }
    
    .date-display {
        font-size: 12px !important;
    }
    
    .button-area {
        padding: 15px;
    }
    
    .prev-btn, .next-btn {
        padding: 6px 16px !important;
        width: 45%;
        margin-bottom: 10px;
    }
    
    fieldset {
        padding: 15px;
    }
    
    .panitia-row > div {
        margin-bottom: 15px;
    }
}
/* Tambahkan CSS ini di bagian style yang ada */

#range_info {
    background-color: #f8f9fa;
    border-radius: 6px;
    padding: 8px 12px;
    margin-top: 8px;
    border-left: 3px solid #0d6efd;
    font-size: 12px;
    color: #0d6efd;
    font-weight: 500;
}

#range_info.error {
    border-left-color: #dc3545;
    color: #dc3545;
}

/* Style untuk kalender yang disable */
.flatpickr-day.disabled, 
.flatpickr-day.disabled:hover, 
.flatpickr-day.prevMonthDay.disabled, 
.flatpickr-day.nextMonthDay.disabled {
    color: #ccc !important;
    background: #f8f9fa !important;
    cursor: not-allowed !important;
    text-decoration: line-through;
}

/* Style untuk tanggal yang berada dalam range yang diizinkan */
.flatpickr-day.inRange {
    background-color: #e7f3ff !important;
    border-color: #e7f3ff !important;
}
</style>

<script>
// ===== GLOBAL MODAL FUNCTIONS =====
function showGlobalModal(errors) {
    console.log('Menampilkan modal dengan errors:', errors);
    const modal = document.getElementById('global-validation-modal');
    const errorList = document.getElementById('global-modal-errors');
    
    if (modal && errorList) {
        errorList.innerHTML = '';
        errors.forEach(error => {
            const li = document.createElement('li');
            li.textContent = error;
            errorList.appendChild(li);
        });
        
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Add ESC key handler
        const escHandler = function(e) {
            if (e.key === 'Escape') {
                closeGlobalModal();
            }
        };
        modal._escHandler = escHandler;
        document.addEventListener('keydown', escHandler);
    }
}

function closeGlobalModal() {
    console.log('Menutup modal');
    const modal = document.getElementById('global-validation-modal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        
        // Remove ESC key handler
        if (modal._escHandler) {
            document.removeEventListener('keydown', modal._escHandler);
            delete modal._escHandler;
        }
    }
}

// ===== GLOBAL FORM NAVIGATION - FIXED VERSION =====
(function() {
    let currentStep = 0;
    const fieldsets = document.querySelectorAll('fieldset');
    const nextBtn = document.querySelector('.next-btn');
    const prevBtn = document.querySelector('.prev-btn');
    
    // Inisialisasi awal
    function initializeSteps() {
        console.log('Initializing steps...');
        fieldsets.forEach((fieldset, index) => {
            if (index === 0) {
                fieldset.classList.add('active');
                console.log('Step 1 set as active');
            } else {
                fieldset.classList.remove('active');
                console.log(`Step ${index + 1} set as inactive`);
            }
        });
        
        currentStep = 0;
        
        if (prevBtn) {
            prevBtn.style.display = 'none';
        }
        
        if (nextBtn) {
            nextBtn.textContent = 'Continue';
        }
    }

    // Fungsi untuk memindahkan ke step berikutnya
    function goToNextStep() {
        const totalSteps = fieldsets.length;
        
        if (currentStep < totalSteps - 1) {
            console.log('Pindah dari step', currentStep + 1, 'ke step', currentStep + 2);
            
            // Sembunyikan step saat ini
            const currentFieldset = fieldsets[currentStep];
            currentFieldset.classList.remove('active');
            
            // Pindah ke step berikutnya
            currentStep++;
            
            // Tampilkan step berikutnya
            const nextFieldset = fieldsets[currentStep];
            nextFieldset.classList.add('active');
            
            console.log(`Current step setelah next: ${currentStep + 1}`);
            
            // Update tombol
            updateButtons();
        } else {
            // Submit form untuk step terakhir
            submitForm();
        }
    }

    // Fungsi untuk memindahkan ke step sebelumnya
    function goToPrevStep() {
        if (currentStep > 0) {
            console.log('Pindah dari step', currentStep + 1, 'ke step', currentStep);
            
            // Sembunyikan step saat ini
            const currentFieldset = fieldsets[currentStep];
            currentFieldset.classList.remove('active');
            
            // Pindah ke step sebelumnya
            currentStep--;
            
            // Tampilkan step sebelumnya
            const prevFieldset = fieldsets[currentStep];
            prevFieldset.classList.add('active');
            
            console.log(`Current step setelah prev: ${currentStep + 1}`);
            
            // Update tombol
            updateButtons();
        }
    }

    // Update tombol berdasarkan current step
    function updateButtons() {
        const totalSteps = fieldsets.length;
        
        if (prevBtn) {
            prevBtn.style.display = currentStep > 0 ? 'inline-block' : 'none';
        }
        
        if (nextBtn) {
            nextBtn.textContent = currentStep === totalSteps - 1 ? 'Submit' : 'Continue';
        }
    }

    // Fungsi untuk submit form
    function submitForm() {
        console.log("🚀 Submitting form...");
        
        // Validasi semua step sebelum submit
        let allValid = true;
        let errorStep = -1;
        
        // Validasi setiap step secara berurutan
        for (let i = 0; i < fieldsets.length; i++) {
            let isValid = false;
            
            // Validasi sesuai step
            switch(i) {
                case 0: 
                    isValid = window.validateStep1AndProceed ? window.validateStep1AndProceed() : true;
                    break;
                case 1: 
                    isValid = window.validateStep2AndProceed ? window.validateStep2AndProceed() : true;
                    break;
                case 2: 
                    isValid = window.validateStep3AndProceed ? window.validateStep3AndProceed() : true;
                    break;
                default: 
                    isValid = true;
            }
            
            if (!isValid) {
                allValid = false;
                errorStep = i;
                break;
            }
        }
        
        if (!allValid && errorStep !== -1) {
            console.log(`Validation failed at step ${errorStep + 1}, navigating to it`);
            
            // Navigasi ke step yang error
            fieldsets[currentStep].classList.remove('active');
            currentStep = errorStep;
            fieldsets[currentStep].classList.add('active');
            
            updateButtons();
            return;
        }
        
        if (!allValid) {
            return;
        }
        
        // Submit form
        const msform = document.getElementById('msform');
        if (msform) {
            console.log("Form submitted!");
            msform.submit();
        }
    }

    // Event listener untuk tombol Continue
    if (nextBtn) {
        nextBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Tombol Continue diklik, currentStep:', currentStep + 1);
            
            // Validasi step saat ini sebelum pindah
            let isValid = false;
            
            switch(currentStep) {
                case 0:
                    isValid = window.validateStep1AndProceed ? window.validateStep1AndProceed() : true;
                    break;
                case 1:
                    isValid = window.validateStep2AndProceed ? window.validateStep2AndProceed() : true;
                    break;
                case 2:
                    isValid = window.validateStep3AndProceed ? window.validateStep3AndProceed() : true;
                    break;
                default:
                    isValid = true;
            }
            
            if (isValid) {
                goToNextStep();
            }
        });
    }

    // Event listener untuk tombol Back
    if (prevBtn) {
        prevBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Tombol Back diklik, currentStep sebelum back:', currentStep + 1);
            
            goToPrevStep();
            
            console.log('currentStep setelah back:', currentStep + 1);
        });
    }

    // Initialize steps on load
    document.addEventListener('DOMContentLoaded', initializeSteps);
    
    // Juga initialize jika DOM sudah siap
    if (document.readyState !== 'loading') {
        setTimeout(initializeSteps, 100);
    }

    // Ekspos fungsi ke global scope
    window.goToNextStep = goToNextStep;
    window.goToPrevStep = goToPrevStep;
    window.getCurrentStep = function() {
        return currentStep;
    };
})();

// ===== STEP 1 VALIDATION & AUTOCOMPLETE =====
(function() {
    const panitiaContainer = document.getElementById('panitiaContainer');
    const jenisPengajuan = document.getElementById('jenis_pengajuan');
    const jenisPenugasanPeroranganContainer = document.getElementById('jenis_penugasan_perorangan_container');
    const jenisPenugasanKelompokContainer = document.getElementById('jenis_penugasan_kelompok_container');
    
    let rowCounter = 1;
    let validationErrors = [];

    // Mock data untuk testing
    const mockData = [
        { nip: '17770081', nama_dosen: 'Dr. Moh Isa Pramana Koesoemadinata, S.Sn, M.Sn.', jabatan: 'Dosen', kaprodi: 'DKV'},
        { nip: '14800004', nama_dosen: 'Bijaksana Prabawa, S.Ds., M.M.', jabatan: 'Dosen', kaprodi: 'DKV'},
        { nip: '14810009', nama_dosen: 'Dr. Ira Wirasari, S.Sos., M.Ds.', jabatan: 'Dosen', kaprodi: 'DKV' },
        { nip: '19860001', nama_dosen: 'Mahendra Nur Hadiansyah, S.T., M.Ds.', jabatan: 'Dosen', kaprodi: 'DI'},
        { nip: '19850010', nama_dosen: 'Diena Yudiarti, S.Ds., M.S.M.', jabatan: 'Dosen', kaprodi: 'DKV'},
        { nip: '20940012', nama_dosen: 'Ganesha Puspa Nabila, S.Sn., M.Ds.', jabatan: 'Dosen', kaprodi: 'DI'},
        { nip: '20950008', nama_dosen: 'Hana Faza Surya Rusyda, ST., M.Ars.', jabatan: 'Dosen', kaprodi: 'DI'},
        { nip: '20920049', nama_dosen: 'Angelia Lionardi, S.Sn., M.Ds.', jabatan: 'Dosen', kaprodi: 'DKV'},
        { nip: '15870029', nama_dosen: 'Ica Ramawisari, S.T., M.T.', jabatan: 'Dosen', kaprodi: 'DP' },
        { nip: '82196019', nama_dosen: 'Alisa Rahadiasmurti Isfandiari, S.A.B., M.M.', jabatan: 'Dosen', kaprodi: 'Admin KK'  }
    ];

    // Global state untuk autocomplete
    let currentAutocompleteBox = null;
    let currentKeydownHandler = null;
    let currentClickHandler = null;
    let currentInputElement = null;

    // Fungsi untuk menampilkan error di field
    function showError(fieldId, message) {
        const errorElement = document.getElementById(`error-${fieldId}`);
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
        
        const inputElement = document.getElementById(fieldId) || document.querySelector(`[name="${fieldId}"]`);
        if (inputElement) {
            inputElement.classList.remove('valid');
            inputElement.classList.add('error');
        }
    }
    
    // Fungsi untuk menghilangkan error
    function hideError(fieldId) {
        const errorElement = document.getElementById(`error-${fieldId}`);
        if (errorElement) {
            errorElement.style.display = 'none';
        }
        
        const inputElement = document.getElementById(fieldId) || document.querySelector(`[name="${fieldId}"]`);
        if (inputElement) {
            inputElement.classList.remove('error');
        }
    }
    
    // Fungsi untuk menandai field valid
    function markAsValid(fieldId) {
        const errorElement = document.getElementById(`error-${fieldId}`);
        if (errorElement) {
            hideError(fieldId);
        }
        
        const inputElement = document.getElementById(fieldId) || document.querySelector(`[name="${fieldId}"]`);
        if (inputElement) {
            inputElement.classList.remove('error');
            inputElement.classList.add('valid');
        }
    }
    
    // Validasi real-time untuk input fields
    function setupRealTimeValidation() {
        // Validasi untuk jenis pengajuan
        jenisPengajuan.addEventListener('change', function() {
            if (this.value) {
                markAsValid('jenis_pengajuan');
            }
        });
        
        // Validasi untuk lingkup penugasan
        document.getElementById('lingkup_penugasan').addEventListener('change', function() {
            if (this.value) {
                markAsValid('lingkup_penugasan');
            }
        });
        
        // Validasi untuk jenis penugasan perorangan
        document.getElementById('jenis_penugasan_perorangan').addEventListener('change', function() {
            if (this.value) {
                markAsValid('jenis_penugasan_perorangan');
                if (this.value === 'Penugasan Lainnya') {
                    const lainnyaInput = document.getElementById('penugasan_lainnya_perorangan');
                    lainnyaInput.addEventListener('input', function() {
                        if (this.value.trim()) {
                            markAsValid('penugasan_lainnya_perorangan');
                        }
                    });
                }
            }
        });
        
        // Validasi untuk jenis penugasan kelompok
        document.getElementById('jenis_penugasan_kelompok').addEventListener('change', function() {
            if (this.value) {
                markAsValid('jenis_penugasan_kelompok');
                if (this.value === 'Penugasan Lainnya') {
                    const lainnyaInput = document.getElementById('penugasan_lainnya_kelompok');
                    lainnyaInput.addEventListener('input', function() {
                        if (this.value.trim()) {
                            markAsValid('penugasan_lainnya_kelompok');
                        }
                    });
                }
            }
        });
        
        // Auto-hide error messages saat user mulai mengisi
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                const fieldName = this.name || this.id;
                if (this.value.trim()) {
                    markAsValid(fieldName);
                }
            });
            
            input.addEventListener('change', function() {
                const fieldName = this.name || this.id;
                if (this.value) {
                    markAsValid(fieldName);
                }
            });
        });
    }
    
    // Fungsi validasi utama step 1
    function validateStep1() {
        validationErrors = [];
        let isValid = true;
        
        // 1. Validasi Jenis Pengajuan (wajib)
        if (!jenisPengajuan.value) {
            showError('jenis_pengajuan', 'Jenis Pengajuan harus dipilih');
            validationErrors.push('Jenis Pengajuan belum dipilih');
            isValid = false;
        } else {
            markAsValid('jenis_pengajuan');
        }
        
        // 2. Validasi Lingkup Penugasan (wajib)
        const lingkupPenugasan = document.getElementById('lingkup_penugasan');
        if (!lingkupPenugasan.value) {
            showError('lingkup_penugasan', 'Status Kepegawaian harus dipilih');
            validationErrors.push('Status Kepegawaian belum dipilih');
            isValid = false;
        } else {
            markAsValid('lingkup_penugasan');
        }
        
        // 3. Validasi Jenis Penugasan berdasarkan jenis pengajuan
        if (jenisPengajuan.value === 'Perorangan') {
            const jenisPenugasanPerorangan = document.getElementById('jenis_penugasan_perorangan');
            const penugasanLainnyaPerorangan = document.getElementById('penugasan_lainnya_perorangan');
            
            if (!jenisPenugasanPerorangan.value) {
                showError('jenis_penugasan_perorangan', 'Jenis Penugasan harus dipilih');
                validationErrors.push('Jenis Penugasan (Perorangan) belum dipilih');
                isValid = false;
            } else {
                markAsValid('jenis_penugasan_perorangan');
                
                // Jika memilih "Lainnya", validasi input lainnya
                if (jenisPenugasanPerorangan.value === 'Penugasan Lainnya') {
                    if (!penugasanLainnyaPerorangan.value.trim()) {
                        showError('penugasan_lainnya_perorangan', 'Jenis penugasan lainnya harus diisi');
                        validationErrors.push('Jenis penugasan lainnya (Perorangan) belum diisi');
                        isValid = false;
                    } else {
                        markAsValid('penugasan_lainnya_perorangan');
                    }
                }
            }
        } 
        else if (jenisPengajuan.value === 'Kelompok') {
            const jenisPenugasanKelompok = document.getElementById('jenis_penugasan_kelompok');
            const penugasanLainnyaKelompok = document.getElementById('penugasan_lainnya_kelompok');
            
            if (!jenisPenugasanKelompok.value) {
                showError('jenis_penugasan_kelompok', 'Jenis Penugasan harus dipilih');
                validationErrors.push('Jenis Penugasan (Kelompok) belum dipilih');
                isValid = false;
            } else {
                markAsValid('jenis_penugasan_kelompok');
                
                // Jika memilih "Lainnya", validasi input lainnya
                if (jenisPenugasanKelompok.value === 'Penugasan Lainnya') {
                    if (!penugasanLainnyaKelompok.value.trim()) {
                        showError('penugasan_lainnya_kelompok', 'Jenis penugasan lainnya harus diisi');
                        validationErrors.push('Jenis penugasan lainnya (Kelompok) belum diisi');
                        isValid = false;
                    } else {
                        markAsValid('penugasan_lainnya_kelompok');
                    }
                }
            }
        }
        
        // 4. Validasi semua baris panitia
        const rows = panitiaContainer.querySelectorAll('.panitia-row');
        rows.forEach((row, index) => {
            const nipInput = row.querySelector('.nip-input');
            const namaInput = row.querySelector('.nama-dosen-input');
            const jabatanInput = row.querySelector('.jabatan-input');
            const kaprodiInput = row.querySelector('.kaprodi-input');
            const peranInput = row.querySelector('.peran-input');
            
            // Validasi NIP (wajib)
            if (!nipInput.value.trim()) {
                showError(`nip-${index}`, 'NIP harus diisi');
                validationErrors.push(`Baris ${index + 1}: NIP belum diisi`);
                isValid = false;
            } else {
                markAsValid(`nip-${index}`);
            }
            
            // Validasi Nama Dosen (wajib)
            if (!namaInput.value.trim()) {
                showError(`nama_dosen-${index}`, 'Nama Dosen harus diisi');
                validationErrors.push(`Baris ${index + 1}: Nama Dosen belum diisi`);
                isValid = false;
            } else {
                markAsValid(`nama_dosen-${index}`);
            }
            
            // Validasi Jabatan (wajib)
            if (!jabatanInput.value.trim()) {
                showError(`jabatan-${index}`, 'Jabatan harus diisi');
                validationErrors.push(`Baris ${index + 1}: Jabatan belum diisi`);
                isValid = false;
            } else {
                markAsValid(`jabatan-${index}`);
            }
            
            // Validasi Kaprodi (wajib)
            if (!kaprodiInput.value.trim()) {
                showError(`kaprodi-${index}`, 'Kaprodi harus diisi');
                validationErrors.push(`Baris ${index + 1}: Kaprodi belum diisi`);
                isValid = false;
            } else {
                markAsValid(`kaprodi-${index}`);
            }
            
            // Validasi Peran (hanya untuk Kelompok)
            if (jenisPengajuan.value === 'Kelompok' && peranInput) {
                if (!peranInput.value.trim()) {
                    showError(`peran-${index}`, 'Peran harus diisi');
                    validationErrors.push(`Baris ${index + 1}: Peran belum diisi`);
                    isValid = false;
                } else {
                    markAsValid(`peran-${index}`);
                }
            }
        });
        
        return { isValid, errors: validationErrors };
    }

    // ===== AUTOCOMPLETE FUNCTIONS =====
    
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
            if (fieldType !== 'nip' && fieldType !== 'nama_dosen') {
                return [];
            }
            
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

        if (fieldType !== 'nip' && fieldType !== 'nama_dosen') {
            return;
        }

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
                default:
                    primaryText = item[fieldType] || '-';
                    secondaryText = `${item.nama_dosen} (${item.nip})`;
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
                
                // Mark as valid setelah memilih dari autocomplete
                const rowEl = inputEl.closest('.panitia-row');
                const index = rowEl.dataset.rowIndex;
                const fieldName = inputEl.name.replace('[]', '');
                markAsValid(`${fieldName}-${index}`);
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
        if (!rowEl) return;
        
        delete rowEl.dataset.autocompleteInitialized;

        const inputNip = rowEl.querySelector('.nip-input');
        const inputNama = rowEl.querySelector('.nama-dosen-input');
        const inputJabatan = rowEl.querySelector('.jabatan-input');
        const inputKaprodi = rowEl.querySelector('.kaprodi-input');
        const inputPeran = rowEl.querySelector('.peran-input');

        if (!inputNip || !inputNama) return;

        function fillRowWith(item) {
            if (!item) return;
            
            inputNip.value = item.nip || '';
            inputNama.value = item.nama_dosen || '';
            
            if (inputJabatan) inputJabatan.value = item.jabatan || '';
            if (inputKaprodi) inputKaprodi.value = item.kaprodi || '';
            
            if (jenisPengajuan.value === 'Kelompok' && inputPeran) {
                inputPeran.value = item.peran || '';
            }
            
            // Real-time validation
            inputNip.dispatchEvent(new Event('input', { bubbles: true }));
            inputNama.dispatchEvent(new Event('input', { bubbles: true }));
            if (inputJabatan) inputJabatan.dispatchEvent(new Event('input', { bubbles: true }));
            if (inputKaprodi) inputKaprodi.dispatchEvent(new Event('input', { bubbles: true }));
            if (jenisPengajuan.value === 'Kelompok' && inputPeran) {
                inputPeran.dispatchEvent(new Event('input', { bubbles: true }));
            }
            
            // Mark as valid
            const index = rowEl.dataset.rowIndex;
            markAsValid(`nip-${index}`);
            markAsValid(`nama_dosen-${index}`);
            markAsValid(`jabatan-${index}`);
            markAsValid(`kaprodi-${index}`);
        }

        function createAutocompleteHandler(fieldType, inputElement) {
            if (fieldType !== 'nip' && fieldType !== 'nama_dosen') return;

            const handler = debounce(async function() {
                const val = this.value.trim();
                
                // Real-time validation saat mengetik
                const index = rowEl.dataset.rowIndex;
                const fieldName = inputElement.name.replace('[]', '');
                if (val.trim()) {
                    markAsValid(`${fieldName}-${index}`);
                }
                
                if (val.length < 2 || document.activeElement !== this) {
                    removeAutocompleteBox();
                    return;
                }

                const suggestions = await fetchSuggestions(val, fieldType);
                showSuggestionBox(inputElement, suggestions, fillRowWith, fieldType);
            }, 300);

            if (inputElement._currentHandler) {
                inputElement.removeEventListener('input', inputElement._currentHandler);
            }
            
            inputElement._currentHandler = handler;
            inputElement.addEventListener('input', handler);
        }

        createAutocompleteHandler('nip', inputNip);
        createAutocompleteHandler('nama_dosen', inputNama);
        
        // Real-time validation untuk semua input
        [inputNip, inputNama, inputJabatan, inputKaprodi].forEach(input => {
            if (input) {
                input.addEventListener('input', function() {
                    const index = rowEl.dataset.rowIndex;
                    const fieldName = this.name.replace('[]', '');
                    if (this.value.trim()) {
                        markAsValid(`${fieldName}-${index}`);
                    }
                });
            }
        });
        
        if (inputPeran) {
            inputPeran.addEventListener('input', function() {
                const index = rowEl.dataset.rowIndex;
                if (this.value.trim()) {
                    markAsValid(`peran-${index}`);
                }
            });
        }

        const inputs = [inputNip, inputNama];
        
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                removeAutocompleteBox();
            });
            
            input.addEventListener('blur', () => {
                setTimeout(() => {
                    if (document.activeElement !== input && 
                        (!currentAutocompleteBox || !currentAutocompleteBox.contains(document.activeElement))) {
                        removeAutocompleteBox();
                        
                        // Validasi saat blur
                        const index = rowEl.dataset.rowIndex;
                        const fieldName = input.name.replace('[]', '');
                        if (!input.value.trim()) {
                            showError(`${fieldName}-${index}`, `${getFieldLabel(fieldName)} harus diisi`);
                        }
                    }
                }, 150);
                });
        });

        rowEl.dataset.autocompleteInitialized = 'true';
    }
    
    // Helper function untuk mendapatkan label field
    function getFieldLabel(fieldName) {
        const labels = {
            'nip': 'NIP',
            'nama_dosen': 'Nama Dosen',
            'jabatan': 'Jabatan',
            'kaprodi': 'Kaprodi',
            'peran': 'Peran'
        };
        return labels[fieldName] || fieldName;
    }

    function initializeFirstRow() {
        const firstRow = document.querySelector('.panitia-row[data-row-index="0"]');
        
        if (!firstRow) return;
        
        if (!firstRow.dataset.autocompleteInitialized) {
            initAutocompleteForRow(firstRow);
        }
    }

    // ===== FORM FUNCTIONS =====

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

    // Toggle kolom peran berdasarkan jenis pengajuan
    function toggleKolomPeran() {
        const peranColumns = document.querySelectorAll('.peran-column');
        const peranInputs = document.querySelectorAll('.peran-input');
        
        if (jenisPengajuan.value === 'Kelompok') {
            peranColumns.forEach(column => {
                column.classList.remove('hidden');
                column.classList.add('visible');
                column.style.display = 'block';
            });
            
            peranInputs.forEach(input => {
                input.required = true;
                input.name = 'peran[]';
            });
        } else {
            peranColumns.forEach(column => {
                column.classList.add('hidden');
                column.classList.remove('visible');
                column.style.display = 'none';
            });
            
            peranInputs.forEach(input => {
                input.required = false;
                input.name = 'peran_hidden[]';
                input.value = '';
            });
        }
    }

    // Toggle button visibility based on jenis pengajuan
    function toggleButtonVisibility() {
        const buttonCells = document.querySelectorAll('.button-cell');
        
        if (jenisPengajuan.value === 'Kelompok') {
            buttonCells.forEach(btn => {
                btn.style.display = 'flex';
            });
        } else {
            buttonCells.forEach(btn => {
                btn.style.display = 'none';
            });
        }
    }

    // Update semua tampilan berdasarkan jenis pengajuan
    function updateViewBasedOnPengajuan() {
        toggleJenisPenugasan();
        toggleKolomPeran();
        toggleButtonVisibility();
        
        if (jenisPengajuan.value === 'Perorangan') {
            setTimeout(() => {
                initializeFirstRow();
            }, 50);
        }
    }

    // Event listener untuk jenis pengajuan
    jenisPengajuan.addEventListener('change', function () {
        updateViewBasedOnPengajuan();
        markAsValid('jenis_pengajuan');
    });

    // Event listener untuk lingkup penugasan
    document.getElementById('lingkup_penugasan').addEventListener('change', function() {
        markAsValid('lingkup_penugasan');
    });

    // Handle "Lainnya" option untuk penugasan perorangan
    document.getElementById('jenis_penugasan_perorangan').addEventListener('change', function() {
        const lainnyaInput = document.getElementById('penugasan_lainnya_perorangan');
        lainnyaInput.style.display = this.value === 'Penugasan Lainnya' ? 'block' : 'none';
        if (this.value !== 'Penugasan Lainnya') {
            lainnyaInput.value = '';
            hideError('penugasan_lainnya_perorangan');
        }
        markAsValid('jenis_penugasan_perorangan');
    });

    // Handle "Lainnya" option untuk penugasan kelompok
    document.getElementById('jenis_penugasan_kelompok').addEventListener('change', function() {
        const lainnyaInput = document.getElementById('penugasan_lainnya_kelompok');
        lainnyaInput.style.display = this.value === 'Penugasan Lainnya' ? 'block' : 'none';
        if (this.value !== 'Penugasan Lainnya') {
            lainnyaInput.value = '';
            hideError('penugasan_lainnya_kelompok');
        }
        markAsValid('jenis_penugasan_kelompok');
    });

    // Inisialisasi awal
    updateViewBasedOnPengajuan();
    setupRealTimeValidation();

    // Add new row function
    function addNewRow() {
        const originalRow = document.querySelector('.panitia-row');
        const newRow = originalRow.cloneNode(true);
        
        newRow.dataset.rowIndex = rowCounter++;
        
        newRow.querySelectorAll('input').forEach(input => {
            input.value = '';
        });
        
        // Update error message IDs
        newRow.querySelectorAll('.error-message').forEach((errorDiv, index) => {
            const oldId = errorDiv.id;
            const baseId = oldId.replace(/-\d+$/, '');
            errorDiv.id = `${baseId}-${newRow.dataset.rowIndex}`;
        });
        
        const addBtn = newRow.querySelector('.add-row-btn');
        if (addBtn) {
            addBtn.classList.remove('btn-success', 'add-row-btn');
            addBtn.classList.add('btn-danger', 'remove-row-btn');
            addBtn.innerHTML = '<i class="fas fa-minus"></i>';
            addBtn.setAttribute('title', 'Hapus Baris');
        }
        
        panitiaContainer.appendChild(newRow);
        
        updateKolomPeranForRow(newRow);
        
        setTimeout(() => {
            initAutocompleteForRow(newRow);
        }, 100);
    }

    function updateKolomPeranForRow(rowEl) {
        const peranColumn = rowEl.querySelector('.peran-column');
        const peranInput = rowEl.querySelector('.peran-input');
        
        if (!peranColumn || !peranInput) return;
        
        if (jenisPengajuan.value === 'Kelompok') {
            peranColumn.classList.remove('hidden');
            peranColumn.classList.add('visible');
            peranColumn.style.display = 'block';
            peranInput.required = true;
            peranInput.name = 'peran[]';
        } else {
            peranColumn.classList.add('hidden');
            peranColumn.classList.remove('visible');
            peranColumn.style.display = 'none';
            peranInput.required = false;
            peranInput.name = 'peran_hidden[]';
            peranInput.value = '';
        }
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

    // Initialize all rows
    function initializeAllRows() {
        const rows = panitiaContainer.querySelectorAll('.panitia-row');
        
        rows.forEach((row, index) => {
            row.dataset.rowIndex = index;
            delete row.dataset.autocompleteInitialized;
            initAutocompleteForRow(row);
        });
    }

    function comprehensiveInitialize() {
        initializeFirstRow();
        
        setTimeout(() => {
            initializeAllRows();
        }, 100);
        
        if (jenisPengajuan.value === 'Perorangan') {
            setTimeout(() => {
                initializeFirstRow();
            }, 200);
        }
    }

    setTimeout(() => {
        comprehensiveInitialize();
    }, 100);

    // Event listeners for autocomplete
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.autocomplete-box-fixed') && 
            !e.target.closest('.nip-input') && 
            !e.target.closest('.nama-dosen-input')) {
            removeAutocompleteBox();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            removeAutocompleteBox();
        }
    });

    // Fungsi untuk validasi form dan menampilkan modal
    window.validateStep1AndProceed = function() {
        const validationResult = validateStep1();
        
        if (validationResult.isValid) {
            return true; // Lanjut ke step berikutnya
        } else {
            // Tampilkan modal global dengan error
            showGlobalModal(validationResult.errors);
            return false; // Jangan lanjut
        }
    };
})();

// ===== STEP 2 VALIDATION & FUNCTIONS =====
(function() {
    // Deklarasi variabel global untuk flatpickr
    let datepickerInstance = null;
    
    // ==================== FUNGSI UTAMA VALIDASI STEP 2 ====================
    window.validateStep2AndProceed = function() {
        console.log('Validating Step 2...');
        const validationResult = validateStep2();
        
        if (validationResult.isValid) {
            console.log('Step 2 validation passed');
            return true; // Lanjut ke step berikutnya
        } else {
            console.log('Step 2 validation failed:', validationResult.errors);
            // Tampilkan modal global dengan error spesifik untuk Step 2
            showGlobalModal(validationResult.errors);
            return false; // Jangan lanjut
        }
    };

    // ==================== FUNGSI VALIDASI DETAIL STEP 2 ====================
    function validateStep2() {
        console.log('Running validateStep2 function...');
        let validationErrorsStep2Array = [];
        let isValid = true;
        
        // Validasi Nama Kegiatan
        const namaKegiatan = document.getElementById('nama_kegiatan');
        if (!namaKegiatan || !namaKegiatan.value.trim()) {
            console.log('Nama Kegiatan is empty');
            showStep2Error('nama_kegiatan', 'Nama Kegiatan harus diisi');
            validationErrorsStep2Array.push('Nama Kegiatan belum diisi');
            isValid = false;
        } else {
            console.log('Nama Kegiatan:', namaKegiatan.value);
            hideStep2Error('nama_kegiatan');
        }
        
        // Validasi Jenis Date
        const jenisDate = document.getElementById('jenis_date');
        if (!jenisDate || !jenisDate.value) {
            console.log('Jenis Date is not selected');
            showStep2Error('jenis_date', 'Tanggal Kegiatan harus dipilih');
            validationErrorsStep2Array.push('Jenis Tanggal Kegiatan belum dipilih');
            isValid = false;
        } else {
            hideStep2Error('jenis_date');
            
            // Validasi tambahan berdasarkan jenis date
            if (jenisDate.value === 'Periode') {
                console.log('Periode selected, checking periode_value');
                const periodeValue = document.getElementById('periode_value');
                if (!periodeValue || !periodeValue.value) {
                    console.log('Periode value is empty');
                    showStep2Error('periode_value', 'Periode harus dipilih');
                    validationErrorsStep2Array.push('Periode belum dipilih');
                    isValid = false;
                } else {
                    hideStep2Error('periode_value');
                }
            } else if (jenisDate.value === 'Custom') {
                console.log('Custom selected, checking datepicker');
                const datepicker = document.getElementById('datepicker');
                if (!datepicker || !datepicker.value) {
                    console.log('Datepicker is empty');
                    showStep2Error('datepicker', 'Tanggal harus dipilih');
                    validationErrorsStep2Array.push('Tanggal Awal & Akhir Kegiatan belum dipilih');
                    isValid = false;
                } else {
                    hideStep2Error('datepicker');
                }
            }
        }
        
        // Validasi Tempat Kegiatan
        const tempatKegiatan = document.getElementById('tempat_kegiatan');
        if (!tempatKegiatan || !tempatKegiatan.value.trim()) {
            console.log('Tempat Kegiatan is empty');
            showStep2Error('tempat_kegiatan', 'Tempat Kegiatan harus diisi');
            validationErrorsStep2Array.push('Tempat Kegiatan belum diisi');
            isValid = false;
        } else {
            hideStep2Error('tempat_kegiatan');
        }
        
        // Validasi Penyelenggara
        const penyelenggara = document.getElementById('penyelenggara');
        if (!penyelenggara || !penyelenggara.value.trim()) {
            console.log('Penyelenggara is empty');
            showStep2Error('penyelenggara', 'Penyelenggara harus diisi');
            validationErrorsStep2Array.push('Penyelenggara belum diisi');
            isValid = false;
        } else {
            hideStep2Error('penyelenggara');
        }
        
        console.log('Step 2 validation result:', { isValid, errors: validationErrorsStep2Array });
        return { isValid, errors: validationErrorsStep2Array };
    }
    
    function showStep2Error(fieldId, message) {
        console.log('Showing Step 2 error for', fieldId, ':', message);
        const errorElement = document.getElementById(`error-${fieldId}`);
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
        
        const inputElement = document.getElementById(fieldId) || 
                            document.querySelector(`[name="${fieldId}"]`);
        if (inputElement) {
            inputElement.classList.add('error');
            inputElement.style.borderColor = '#dc3545';
        }
    }
    
    function hideStep2Error(fieldId) {
        console.log('Hiding Step 2 error for', fieldId);
        const errorElement = document.getElementById(`error-${fieldId}`);
        if (errorElement) {
            errorElement.style.display = 'none';
        }
        
        const inputElement = document.getElementById(fieldId) || 
                            document.querySelector(`[name="${fieldId}"]`);
        if (inputElement) {
            inputElement.classList.remove('error');
            inputElement.style.borderColor = '';
        }
    }

    // ==================== REAL-TIME VALIDATION STEP 2 ====================
    function setupStep2RealTimeValidation() {
        // Real-time validation untuk input di step 2
        const namaKegiatan = document.getElementById('nama_kegiatan');
        if (namaKegiatan) {
            namaKegiatan.addEventListener('input', function() {
                if (this.value.trim()) {
                    hideStep2Error('nama_kegiatan');
                }
            });
        }

        const jenisDate = document.getElementById('jenis_date');
        if (jenisDate) {
            jenisDate.addEventListener('change', function() {
                console.log('Jenis date changed to:', this.value);
                hideStep2Error('jenis_date');
                const periodeSection = document.getElementById('periode_section');
                if (periodeSection) {
                    periodeSection.style.display = this.value === 'Periode' ? 'block' : 'none';
                }
                if (this.value === 'Periode') {
                    hideStep2Error('datepicker');
                } else if (this.value === 'Custom') {
                    hideStep2Error('periode_value');
                }
            });
        }

        const periodeValue = document.getElementById('periode_value');
        if (periodeValue) {
            periodeValue.addEventListener('change', function() {
                if (this.value) {
                    hideStep2Error('periode_value');
                }
            });
        }

        const tempatKegiatan = document.getElementById('tempat_kegiatan');
        if (tempatKegiatan) {
            tempatKegiatan.addEventListener('input', function() {
                if (this.value.trim()) {
                    hideStep2Error('tempat_kegiatan');
                }
            });
        }

        const penyelenggara = document.getElementById('penyelenggara');
        if (penyelenggara) {
            penyelenggara.addEventListener('input', function() {
                if (this.value.trim()) {
                    hideStep2Error('penyelenggara');
                }
            });
        }
    }

    // ==================== FUNGSI FORMAT TANGGAL ====================
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

    function formatDateLocal(date) {
        const y = date.getFullYear();
        const m = (date.getMonth() + 1).toString().padStart(2, "0");
        const d = date.getDate().toString().padStart(2, "0");
        return `${y}-${m}-${d}`;
    }

 // ==================== INISIALISASI FLATPICKR ====================
function initializeFlatpickr() {
    try {
        const datepickerEl = document.getElementById('datepicker');
        if (!datepickerEl) {
            console.log('Datepicker element not found');
            return;
        }

        // Hitung tanggal minimum (30 hari ke belakang dari hari ini)
        const today = new Date();
        const minDate = new Date();
        minDate.setDate(today.getDate() - 30); // 30 hari ke belakang
        
        datepickerInstance = flatpickr("#datepicker", {
            mode: "range",
            dateFormat: "Y-m-d",
            allowInput: false,
            
            // BATASAN TANGGAL - HANYA MINIMUM SAJA
            minDate: minDate, // Tidak bisa pilih lebih dari 30 hari ke belakang
            // HAPUS maxDate agar bisa pilih tanggal di masa depan
            
            // Validasi tambahan
            onChange: function(selectedDates) {
                console.log('Datepicker changed:', selectedDates);
                const konfirmasiDiv = document.getElementById("konfirmasi_tanggal");
                const rangeInfo = document.getElementById("range_info");
                
                if (selectedDates.length === 2) {
                    const awal = selectedDates[0];
                    const akhir = selectedDates[1];
                    
                    // Validasi range tanggal (opsional: maksimal durasi 365 hari)
                    const diffTime = Math.abs(akhir - awal);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    
                    if (diffDays > 365) {
                        alert("Durasi kegiatan tidak boleh lebih dari 365 hari");
                        this.clear();
                        return;
                    }
                    
                    // Validasi: tanggal mulai tidak boleh lebih dari 30 hari ke belakang
                    const today = new Date();
                    const minAllowedDate = new Date();
                    minAllowedDate.setDate(today.getDate() - 30);
                    
                    if (awal < minAllowedDate) {
                        alert("Tanggal awal tidak boleh lebih dari 30 hari ke belakang dari hari ini");
                        this.clear();
                        return;
                    }
                    
                    const awalFormatted = formatDateLocal(awal);
                    const akhirFormatted = formatDateLocal(akhir);
                    
                    const awalDisplay = formatDateIndonesian(awal);
                    const akhirDisplay = formatDateIndonesian(akhir);
                    
                    document.getElementById("tanggal_awal_kegiatan").value = awalFormatted;
                    document.getElementById("tanggal_akhir_kegiatan").value = akhirFormatted;
                    
                    document.getElementById("datepicker3").value = awalFormatted;
                    document.getElementById("datepicker4").value = akhirFormatted;
                    
                    document.getElementById("konfirmasi_awal").innerHTML = `<strong>Awal:</strong> ${awalDisplay}`;
                    document.getElementById("konfirmasi_akhir").innerHTML = `<strong>Akhir:</strong> ${akhirDisplay}`;
                    if (konfirmasiDiv) konfirmasiDiv.style.display = 'block';
                    if (rangeInfo) rangeInfo.style.display = 'none';
                    
                    const infoPeriode = document.getElementById("info_periode");
                    const infoAkhir = document.getElementById("info_akhir");
                    if (infoPeriode) infoPeriode.innerHTML = "Terisi otomatis ✓";
                    if (infoAkhir) infoAkhir.innerHTML = "Terisi otomatis ✓";
                    
                    const datepicker3 = document.getElementById("datepicker3");
                    const datepicker4 = document.getElementById("datepicker4");
                    if (datepicker3) {
                        datepicker3.classList.add("auto-filled", "highlight-animation");
                    }
                    if (datepicker4) {
                        datepicker4.classList.add("auto-filled", "highlight-animation");
                    }
                    
                    hideStep2Error('datepicker');
                    hideStep2Error('periode_penugasan');
                    hideStep2Error('akhir_periode_penugasan');
                    
                    setTimeout(() => {
                        if (datepicker3) datepicker3.classList.remove("highlight-animation");
                        if (datepicker4) datepicker4.classList.remove("highlight-animation");
                    }, 1000);
                    
                } else if (selectedDates.length === 1) {
                    const awalDisplay = formatDateIndonesian(selectedDates[0]);
                    document.getElementById("konfirmasi_awal").innerHTML = `<strong>Tanggal awal:</strong> ${awalDisplay}`;
                    document.getElementById("konfirmasi_akhir").innerHTML = `<strong>Tanggal akhir:</strong> Klik tanggal akhir`;
                    if (konfirmasiDiv) konfirmasiDiv.style.display = 'block';
                    if (rangeInfo) rangeInfo.style.display = 'none';
                    
                    // Validasi jika tanggal awal < minDate
                    const today = new Date();
                    const minAllowedDate = new Date();
                    minAllowedDate.setDate(today.getDate() - 30);
                    
                    if (selectedDates[0] < minAllowedDate) {
                        alert("Tanggal tidak boleh lebih dari 30 hari ke belakang dari hari ini");
                        this.clear();
                        return;
                    }
                } else {
                    if (konfirmasiDiv) konfirmasiDiv.style.display = 'none';
                    if (rangeInfo) rangeInfo.style.display = 'block';
                    
                    const datepicker3 = document.getElementById("datepicker3");
                    const datepicker4 = document.getElementById("datepicker4");
                    if (datepicker3) datepicker3.value = "";
                    if (datepicker4) datepicker4.value = "";
                    
                    const infoPeriode = document.getElementById("info_periode");
                    const infoAkhir = document.getElementById("info_akhir");
                    if (infoPeriode) infoPeriode.innerHTML = "Akan terisi otomatis";
                    if (infoAkhir) infoAkhir.innerHTML = "Akan terisi otomatis";
                    
                    if (datepicker3) datepicker3.classList.remove("auto-filled");
                    if (datepicker4) datepicker4.classList.remove("auto-filled");
                }
            },
            
            // Disable hanya tanggal yang lebih dari 30 hari ke belakang
            disable: [
                function(date) {
                    const today = new Date();
                    const minAllowedDate = new Date();
                    minAllowedDate.setDate(today.getDate() - 30);
                    
                    // Hanya disable tanggal sebelum minAllowedDate
                    return date < minAllowedDate;
                }
            ],
            
            // Lokalisasi bahasa Indonesia
            locale: {
                firstDayOfWeek: 1, // Senin
                weekdays: {
                    shorthand: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
                    longhand: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"]
                },
                months: {
                    shorthand: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
                    longhand: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"]
                }
            },
            
            // Opsi tambahan untuk memastikan tanggal ke depan bisa dipilih
            enableTime: false,
            time_24hr: true
        });
        
        // Update informasi batasan tanggal di info message
        const rangeInfo = document.getElementById("range_info");
        if (rangeInfo) {
            const minDateFormatted = formatDateIndonesian(minDate);
            const todayFormatted = formatDateIndonesian(today);
            rangeInfo.innerHTML = `Batas: Minimal ${minDateFormatted}. Tanggal ke depan bisa dipilih`;
            rangeInfo.style.color = "#0d6efd";
            rangeInfo.style.fontWeight = "500";
        }
        
        console.log('Flatpickr initialized successfully - only past dates restricted');
    } catch (error) {
        console.error('Error initializing flatpickr:', error);
    }
}

// ==================== PERBAIKAN FUNGSI VALIDASI DATE RANGE ====================
function validateDateRange(selectedDates) {
    if (!selectedDates || selectedDates.length < 2) return true;
    
    const today = new Date();
    const minAllowedDate = new Date();
    minAllowedDate.setDate(today.getDate() - 30);
    
    const startDate = selectedDates[0];
    const endDate = selectedDates[1];
    
    // Validasi: tanggal mulai tidak boleh lebih dari 30 hari ke belakang
    if (startDate < minAllowedDate) {
        showStep2Error('datepicker', 'Tanggal awal tidak boleh lebih dari 30 hari ke belakang dari hari ini');
        return false;
    }
    
    // HAPUS validasi untuk tanggal akhir tidak boleh lebih dari hari ini
    // if (endDate > today) {
    //     showStep2Error('datepicker', 'Tanggal akhir tidak boleh lebih dari hari ini');
    //     return false;
    // }
    
    // Validasi: tanggal akhir tidak boleh sebelum tanggal mulai
    if (endDate < startDate) {
        showStep2Error('datepicker', 'Tanggal akhir harus setelah tanggal awal');
        return false;
    }
    
    return true;
}
// ==================== FUNGSI TAMBAHAN UNTUK VALIDASI ====================
function validateDateRange(selectedDates) {
    if (!selectedDates || selectedDates.length < 2) return true;
    
    const today = new Date();
    const minDate = new Date();
    minDate.setDate(today.getDate() - 30);
    
    const startDate = selectedDates[0];
    const endDate = selectedDates[1];
    
    // Validasi: tanggal mulai tidak boleh lebih dari 30 hari ke belakang
    if (startDate < minDate) {
        showStep2Error('datepicker', 'Tanggal awal tidak boleh lebih dari 30 hari ke belakang dari hari ini');
        return false;
    }
    
    // Validasi: tanggal akhir tidak boleh lebih dari hari ini
    if (endDate > today) {
        showStep2Error('datepicker', 'Tanggal akhir tidak boleh lebih dari hari ini');
        return false;
    }
    
    // Validasi: tanggal akhir tidak boleh sebelum tanggal mulai
    if (endDate < startDate) {
        showStep2Error('datepicker', 'Tanggal akhir harus setelah tanggal awal');
        return false;
    }
    
    return true;
}

// ==================== MODIFIKASI FUNGSI VALIDASI STEP 2 ====================
function validateStep2() {
    console.log('Running validateStep2 function...');
    let validationErrorsStep2Array = [];
    let isValid = true;
    
    // ... (kode validasi lainnya tetap sama)
    
    // Validasi Jenis Date
    const jenisDate = document.getElementById('jenis_date');
    if (!jenisDate || !jenisDate.value) {
        console.log('Jenis Date is not selected');
        showStep2Error('jenis_date', 'Tanggal Kegiatan harus dipilih');
        validationErrorsStep2Array.push('Jenis Tanggal Kegiatan belum dipilih');
        isValid = false;
    } else {
        hideStep2Error('jenis_date');
        
        // Validasi tambahan berdasarkan jenis date
        if (jenisDate.value === 'Periode') {
            console.log('Periode selected, checking periode_value');
            const periodeValue = document.getElementById('periode_value');
            if (!periodeValue || !periodeValue.value) {
                console.log('Periode value is empty');
                showStep2Error('periode_value', 'Periode harus dipilih');
                validationErrorsStep2Array.push('Periode belum dipilih');
                isValid = false;
            } else {
                hideStep2Error('periode_value');
            }
        } else if (jenisDate.value === 'Custom') {
            console.log('Custom selected, checking datepicker');
            const datepicker = document.getElementById('datepicker');
            if (!datepicker || !datepicker.value) {
                console.log('Datepicker is empty');
                showStep2Error('datepicker', 'Tanggal harus dipilih');
                validationErrorsStep2Array.push('Tanggal Awal & Akhir Kegiatan belum dipilih');
                isValid = false;
            } else {
                // Validasi range tanggal jika datepicker terisi
                if (datepickerInstance) {
                    const selectedDates = datepickerInstance.selectedDates;
                    if (selectedDates.length === 2) {
                        const dateValidation = validateDateRange(selectedDates);
                        if (!dateValidation) {
                            validationErrorsStep2Array.push('Tanggal yang dipilih melanggar aturan (maks 30 hari ke belakang)');
                            isValid = false;
                        } else {
                            hideStep2Error('datepicker');
                        }
                    }
                }
            }
        }
    }
    
    // ... (kode validasi lainnya tetap sama)
    
    console.log('Step 2 validation result:', { isValid, errors: validationErrorsStep2Array });
    return { isValid, errors: validationErrorsStep2Array };
}

    // ==================== INISIALISASI STEP 2 ====================
    // Inisialisasi ketika DOM siap
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initializing Step 2...');
        
        // Setup real-time validation
        setupStep2RealTimeValidation();
        
        // Initialize flatpickr
        initializeFlatpickr();
        
        // Debug: Cek apakah semua element ada
        console.log('Step 2 initialization complete');
        console.log('validateStep2AndProceed function:', typeof window.validateStep2AndProceed);
    });

    // Juga initialize jika DOM sudah siap
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeFlatpickr);
    } else {
        initializeFlatpickr();
    }
})();

// ===== STEP 3 VALIDATION & FUNCTIONS =====
(function() {
    const evidenInput = document.getElementById("eviden");
    const uploadedDisplay = document.getElementById("uploaded-files-display");
    const filesList = document.getElementById("files-list");
    const uploadBtn = document.getElementById("upload-btn");
    const evidenPanel = document.getElementById("eviden-panel");
    const totalFilesSpan = document.getElementById("total-files");
    const errorEvidens = document.getElementById("error-evidens");
    
    if (!evidenInput.value || evidenInput.value === "") {
        evidenInput.value = "[]";
    }

    let uploadedFiles = [];
    let currentPanel = null;
    
    // ==================== FUNGSI MODAL STEP 3 ====================
    function showStep3ValidationModal(errors) {
        console.log('Showing Step 3 validation modal with errors:', errors);
        const modal = document.getElementById('validation-modal-step3');
        const errorList = document.getElementById('validation-modal-errors-step3');
        
        if (modal && errorList) {
            // Bersihkan daftar error sebelumnya
            errorList.innerHTML = '';
            
            // Tambahkan error spesifik Step 3 ke daftar
            errors.forEach(error => {
                const li = document.createElement('li');
                li.textContent = error;
                errorList.appendChild(li);
            });
            
            // Tampilkan modal
            modal.style.display = 'flex';
            console.log('Modal should be visible now');
            
            // Tambahkan event listener untuk klik di luar modal
            const modalClickHandler = function(event) {
                if (event.target === modal) {
                    closeStep3ValidationModal();
                }
            };
            
            // Hapus listener sebelumnya jika ada
            modal.removeEventListener('click', modalClickHandler);
            modal.addEventListener('click', modalClickHandler);
        } else {
            console.error('Modal or error list not found!');
            console.log('Modal element:', modal);
            console.log('Error list element:', errorList);
        }
    }
    
    function closeStep3ValidationModal() {
        console.log('Closing Step 3 validation modal');
        const modal = document.getElementById('validation-modal-step3');
        
        if (modal) {
            modal.style.display = 'none';
        }
    }
    
    // ==================== VALIDASI STEP 3 ====================
    function validateStep3() {
        let validationErrorsStep3Array = [];
        let isValid = true;
        
        // Validasi file eviden
        if (uploadedFiles.length === 0) {
            showStep3Error('evidens', 'Minimal 1 file eviden harus diupload');
            validationErrorsStep3Array.push('Belum ada file yang diupload');
            isValid = false;
        } else {
            hideStep3Error('evidens');
        }
        
        return { isValid, errors: validationErrorsStep3Array };
    }
    
    function showStep3Error(fieldId, message) {
        const errorElement = document.getElementById(`error-${fieldId}`);
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
            errorElement.style.color = '#dc3545';
            errorElement.style.fontSize = '14px';
            errorElement.style.marginTop = '10px';
            errorElement.style.padding = '10px';
            errorElement.style.backgroundColor = '#f8d7da';
            errorElement.style.borderRadius = '5px';
            errorElement.style.border = '1px solid #f5c6cb';
        }
    }
    
    function hideStep3Error(fieldId) {
        const errorElement = document.getElementById(`error-${fieldId}`);
        if (errorElement) {
            errorElement.style.display = 'none';
        }
    }

    // Function untuk get file type icon
    function getFileIcon(url) {
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

    // Function untuk update display files
    function updateFilesDisplay() {
        if (uploadedFiles.length === 0) {
            uploadedDisplay.style.display = 'none';
            totalFilesSpan.textContent = '0';
            return;
        }

        uploadedDisplay.style.display = 'block';
        totalFilesSpan.textContent = uploadedFiles.length;
        filesList.innerHTML = '';

        uploadedFiles.forEach((url, index) => {
            const filename = url.split('/').pop().split('?')[0];
            const fileItem = document.createElement('div');
            fileItem.className = 'file-item';
            
            fileItem.innerHTML = `
                <div class="file-icon">
                    ${getFileIcon(url)}
                </div>
                <div class="file-info">
                    <div class="file-name">File ${index + 1}: ${filename}</div>
                    <div class="file-url">${url}</div>
                </div>
                <div style="display: flex; gap: 5px;">
                    <button type="button" onclick="removeFile(${index})" class="btn-remove">
                        <i class="fas fa-times"></i> Hapus
                    </button>
                </div>
            `;
            
            filesList.appendChild(fileItem);
        });
    }

    // Function untuk remove file
    window.removeFile = function(index) {
        if (confirm('Apakah Anda yakin ingin menghapus file ini?')) {
            uploadedFiles.splice(index, 1);
            evidenInput.value = JSON.stringify(uploadedFiles);
            updateFilesDisplay();
            
            if (uploadedFiles.length === 0) {
                showStep3Error('evidens', 'Minimal 1 file eviden harus diupload');
            } else {
                hideStep3Error('evidens');
            }
        }
    };

    // Function untuk open upload panel
    function openUploadPanel() {
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

        currentPanel.done(function (fileGroup) {
            console.log("✅ Upload selesai! File group:", fileGroup);
            
            fileGroup.files().forEach(filePromise => {
                filePromise.done(fileInfo => {
                    uploadedFiles.push(fileInfo.cdnUrl);
                    evidenInput.value = JSON.stringify(uploadedFiles);
                    updateFilesDisplay();
                    hideStep3Error('evidens');
                });
            });

            setTimeout(() => {
                evidenPanel.style.display = 'none';
                evidenPanel.innerHTML = '';
            }, 500);
        });

        currentPanel.fail(function() {
            console.log("❌ Upload dibatalkan");
            evidenPanel.style.display = 'none';
            evidenPanel.innerHTML = '';
        });
    }

    // Event listener untuk tombol upload
    if (uploadBtn) {
        uploadBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openUploadPanel();
        });
    }

    // Fungsi untuk validasi step 3 dan menampilkan modal
    window.validateStep3AndProceed = function() {
        const validationResult = validateStep3();
        
        if (validationResult.isValid) {
            return true; // Lanjut submit form
        } else {
            // Tampilkan modal dengan error
            showStep3ValidationModal(validationResult.errors);
            return false; // Jangan lanjut
        }
    };
    
    window.closeStep3ValidationModal = closeStep3ValidationModal;

    try {
        const existingFiles = JSON.parse(evidenInput.value);
        if (Array.isArray(existingFiles) && existingFiles.length > 0) {
            uploadedFiles = existingFiles;
            updateFilesDisplay();
        }
    } catch (e) {
        console.log("No existing files to load");
    }
})();
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