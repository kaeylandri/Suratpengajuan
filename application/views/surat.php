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

    <!-- Lab. FIK Main Style -->
    <link rel="stylesheet" href="https://ifik.telkomuniversity.ac.id/assets/css/style.css">





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
        }

        .action-btn:hover {
            background: #FB8C00;
        }

        .btn-secondary {
            border: 1px solid #ccc;
            background: transparent;
            color: #555;
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
        }


        .nice-select.open {
            border-color: #FB8C00;
            box-shadow: 0 0 0 0.2rem rgba(92, 184, 92, 0.25);
        }

        .nice-select .list {
            border-radius: 8px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            border-color: #e5e7eb;
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
            <div class="divider show-mobile" style="margin-top:20px"></div>
            <div class="card">
                <a href="https://ifik.telkomuniversity.ac.id/Pic_kk/index" class="btn"><span class="fas fa-palette"></span> List Surat Tugas</a>
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
    <script src="https://cdn.tiny.cloud/1/q9tneu2aax9fp91cvqlh7mqvx44p6ph4jb63xq6lax2ybita/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea.mytextarea1',
            plugins: 'save autosave preview autolink lists media table print',
            toolbar: 'export table bold italic underline bullist numlist alignleft aligncenter alignright alignjustify fontsizeselect forecolor lineheight h1 h2 h3 h4 h5 ',
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            height: '450',

            // he
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
          <input type="text" name="tanggal_kegiatan" id="datepicker" class="form-control custom-form-control" required autocomplete="off">
          <label id="lbl_mulai">Mulai kegiatan</label>
        </div>
      </div>

      <div class="col-md-3 mt-3">
        <div class="form-group">
          <input type="text" name="akhir_kegiatan" id="datepicker2" class="form-control custom-form-control" required autocomplete="off">
          <label id="lbl_akhir">Berakhir kegiatan</label>
        </div>
      </div>

      <div class="col-md-3 mt-3">
        <div class="form-group">
          <input type="text" name="periode_penugasan" id="datepicker3" class="form-control custom-form-control" required autocomplete="off">
          <label id="lbl_mulai1">Periode Penugasan</label>
        </div>
      </div>

      <div class="col-md-3 mt-3">
        <div class="form-group">
          <input type="text" name="akhir_periode_penugasan" id="datepicker4" class="form-control custom-form-control" required autocomplete="off">
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
</style>

<!-- JS -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const jenisDate = document.getElementById('jenis_date');
  const periodeSection = document.getElementById('periode_section');
  const periodeSelect = document.getElementById('periode_value');

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
      // Hapus margin saat disembunyikan
      periodeSection.classList.remove('open-margin');
    }
  }

  // Jika menggunakan NiceSelect
  if (typeof $ !== 'undefined' && typeof $.fn.niceSelect !== 'undefined') {
    $('select#periode_value').niceSelect();

    // Tambah margin saat dropdown dibuka dengan delay lebih smooth
    $('select#periode_value').parent().on("click", function () {
      setTimeout(() => {
        if ($(this).hasClass("open")) {
          periodeSection.classList.add("open-margin");
        } else {
          periodeSection.classList.remove("open-margin");
        }
      }, 50);
    });

    // Hapus margin saat dropdown ditutup
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
        <div class="form-group has-select mb-3">
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
        <div class="form-group has-select mb-3">
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
            <div class="row g-3 align-items-end panitia-row">

                <div class="col-md-2 position-relative">
                    <label>NIP</label>
                    <input type="text" name="nip[]" class="form-control nip-input" autocomplete="off" required>
                </div>

                <div class="col-md-3 position-relative">
                    <label>Nama Dosen</label>
                    <input type="text" name="nama_dosen[]" class="form-control nama_dosen" autocomplete="off" required>
                </div>

                <div class="col-md-3 position-relative">
                    <label>Jabatan</label>
                    <input type="text" name="jabatan[]" class="form-control jabatan" autocomplete="off" required>
                </div>

                <div class="col-md-3 position-relative">
                    <label>Divisi</label>
                    <input type="text" name="divisi[]" class="form-control divisi" autocomplete="off" required>
                </div>

                <!-- TOMBOL (+) / (-) -->
                <div class="col-md-1 text-center button-cell">
                    <button type="button" class="btn btn-success addRow" title="Tambah Baris">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

            </div>
        </div>

    </div>
</fieldset>

<style>
.button-cell {
    display: none;
    justify-content: center;
    align-items: center;
}
.addRow, .removeRow {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    padding: 0;
}

/* Animasi untuk panitia row */
.panitia-row {
    transition: all 0.3s ease;
    opacity: 1;
    transform: translateY(0);
}

.panitia-row.removing {
    opacity: 0;
    transform: translateX(20px);
}

/* AUTOCOMPLETE BOX - EXACT GOOGLE SEARCH STYLE */
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

/* Icon search seperti Google */
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

/* Content wrapper */
.autocomplete-content {
    display: flex;
    flex-direction: column;
    gap: 2px;
    padding: 12px 16px 12px 0;
    flex: 1;
    min-width: 0;
}

/* Text styling seperti Google */
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

/* Bold text untuk query match */
.query-match {
    font-weight: 600;
}

/* First item with blue left border */
.autocomplete-item:first-child {
    border-left: 3px solid #1a73e8;
}

/* Loading dan empty state */
.autocomplete-loading,
.autocomplete-empty {
    padding: 16px 20px;
    text-align: center;
    color: #70757a;
    font-size: 13px;
}

.autocomplete-loading {
    font-style: normal;
}

/* Scrollbar styling - Google Style */
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

/* Ensure scrollability - FORCE IT */
.autocomplete-box-fixed {
    overflow-y: scroll !important;
    overflow-x: hidden !important;
    -webkit-overflow-scrolling: touch;
    overscroll-behavior: contain;
}

/* ensure important parents don't clip */
.multi-step-form, fieldset, .container {
    overflow: visible !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const panitiaContainer = document.getElementById('panitiaContainer');
    const jenisPengajuan = document.getElementById('jenis_pengajuan');

    // tampilkan tombol + saat Kelompok
    jenisPengajuan.addEventListener('change', function () {
        const buttons = document.querySelectorAll('.button-cell');
        if (this.value === 'Kelompok') {
            buttons.forEach(btn => btn.style.display = 'flex');
        } else {
            buttons.forEach(btn => btn.style.display = 'none');
        }
    });

    // EVENT DELEGATION: tambah/hapus baris
    let isAdding = false; // Flag untuk prevent double click
    
    panitiaContainer.addEventListener('click', function (e) {
        e.stopPropagation();
        
        const addBtn = e.target.closest('.addRow');
        const removeBtn = e.target.closest('.removeRow');

        if (addBtn) {
            e.preventDefault();
            
            // Prevent double execution
            if (isAdding) return false;
            isAdding = true;
            
            const row = addBtn.closest('.panitia-row');
            const clone = row.cloneNode(true);

            // Clear all inputs
            clone.querySelectorAll('input').forEach(input => {
                input.value = '';
                input.removeAttribute('data-initialized');
                input.removeAttribute('data-autocomplete-init');
            });
            
            clone.removeAttribute('data-autocomplete-init');

            // Change button from add to remove
            const btn = clone.querySelector('.addRow');
            if (btn) {
                btn.classList.remove('btn-success', 'addRow');
                btn.classList.add('btn-danger', 'removeRow');
                btn.innerHTML = '<i class="fas fa-minus"></i>';
                btn.setAttribute('title', 'Hapus Baris');
            }

            panitiaContainer.appendChild(clone);
            
            // ANIMASI SMOOTH SAAT TAMBAH
            setTimeout(() => {
                clone.style.opacity = '0';
                clone.style.transform = 'translateY(-10px)';
                clone.offsetHeight; // Trigger reflow
                clone.style.transition = 'all 0.3s ease';
                clone.style.opacity = '1';
                clone.style.transform = 'translateY(0)';
            }, 10);
            
            // Initialize autocomplete untuk row baru
            initAutocompleteForRow(clone);
            
            // Reset flag after short delay
            setTimeout(() => {
                isAdding = false;
            }, 300);
            
            return false;
        }

        if (removeBtn) {
            e.preventDefault();
            
            const rowEl = removeBtn.closest('.panitia-row');
            if (rowEl && panitiaContainer.querySelectorAll('.panitia-row').length > 1) {
                // ANIMASI SMOOTH SAAT HAPUS
                rowEl.style.opacity = '0';
                rowEl.style.transform = 'translateX(20px)';
                
                setTimeout(() => {
                    rowEl.remove();
                }, 300);
            }
            
            return false;
        }
    }, true); // Use capture phase

    initAutocompleteForRow(document.querySelector('.panitia-row'));

    // Debounce helper
    function debounce(fn, delay = 300) {
        let t;
        return function (...args) {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    // Create and show suggestion box with improved HTML structure
    function showSuggestionBox(inputEl, items, onSelect, fieldType) {
        removeAllSuggestionBoxes();

        const rect = inputEl.getBoundingClientRect();
        const box = document.createElement('div');
        box.className = 'autocomplete-box-fixed';
        box.style.left = rect.left + 'px';
        box.style.top = (rect.bottom + 4) + 'px';
        box.style.width = Math.max(rect.width, 300) + 'px';

        if (!items || items.length === 0) {
            const empty = document.createElement('div');
            empty.className = 'autocomplete-empty';
            empty.textContent = 'Tidak ada data ditemukan';
            box.appendChild(empty);
            document.body.appendChild(box);
            
            setTimeout(() => {
                removeAllSuggestionBoxes();
            }, 2000);
            return;
        }

        let selectedIndex = -1;

        items.forEach((it, idx) => {
            const option = document.createElement('div');
            option.className = `autocomplete-item type-${fieldType}`;
            
            const icon = `
                <div class="autocomplete-icon">
                    <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                    </svg>
                </div>
            `;
            
            let htmlContent = '';
            
            switch(fieldType) {
                case 'nip':
                    const nipValue = (it.nip !== undefined && it.nip !== null && it.nip !== '') 
                        ? String(it.nip) 
                        : 'NIP tidak tersedia';
                    const namaValue = it.nama_dosen || '';
                    
                    htmlContent = `
                        ${icon}
                        <div class="autocomplete-content">
                            <div class="item-primary">${nipValue}</div>
                            ${namaValue ? '<div class="item-secondary">' + namaValue + '</div>' : ''}
                        </div>
                    `;
                    break;
                    
                case 'nama':
                    htmlContent = `
                        ${icon}
                        <div class="autocomplete-content">
                            <div class="item-primary">${it.nama_dosen || '-'}</div>
                            ${it.nip || it.jabatan ? '<div class="item-secondary">' + 
                                (it.nip ? 'NIP: ' + it.nip : '') + 
                                (it.nip && it.jabatan ? ' • ' : '') + 
                                (it.jabatan ? it.jabatan : '') + 
                            '</div>' : ''}
                        </div>
                    `;
                    break;
                    
                case 'jabatan':
                    htmlContent = `
                        ${icon}
                        <div class="autocomplete-content">
                            <div class="item-primary">${it.jabatan || '-'}</div>
                            ${it.nama_dosen ? '<div class="item-secondary">' + it.nama_dosen + (it.nip ? ' • NIP: ' + it.nip : '') + '</div>' : ''}
                        </div>
                    `;
                    break;
                    
                case 'divisi':
                    htmlContent = `
                        ${icon}
                        <div class="autocomplete-content">
                            <div class="item-primary">${it.divisi || '-'}</div>
                            ${it.nama_dosen || it.jabatan ? '<div class="item-secondary">' + 
                                (it.nama_dosen ? it.nama_dosen : '') + 
                                (it.nama_dosen && it.jabatan ? ' • ' : '') + 
                                (it.jabatan ? it.jabatan : '') + 
                            '</div>' : ''}
                        </div>
                    `;
                    break;
            }
            
            option.innerHTML = htmlContent;

            option.addEventListener('click', (ev) => {
                ev.stopPropagation();
                onSelect(it);
                removeAllSuggestionBoxes();
            });
            box.appendChild(option);
        });

        // Keyboard navigation
        function onKey(e) {
            const opts = box.querySelectorAll('.autocomplete-item');
            if (!opts.length) return;
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                selectedIndex = Math.min(selectedIndex + 1, opts.length - 1);
                opts.forEach((o,i) => o.classList.toggle('active', i === selectedIndex));
                opts[selectedIndex].scrollIntoView({block:'nearest'});
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                selectedIndex = Math.max(selectedIndex - 1, 0);
                opts.forEach((o,i) => o.classList.toggle('active', i === selectedIndex));
                opts[selectedIndex].scrollIntoView({block:'nearest'});
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (selectedIndex >= 0 && opts[selectedIndex]) {
                    opts[selectedIndex].click();
                }
            } else if (e.key === 'Escape') {
                removeAllSuggestionBoxes();
            }
        }

        document.body.appendChild(box);
        box._sourceInput = inputEl;
        inputEl.addEventListener('keydown', onKey);

        const offClick = (ev) => {
            if (!box.contains(ev.target) && ev.target !== inputEl) {
                removeAllSuggestionBoxes();
            }
        };
        setTimeout(() => document.addEventListener('click', offClick), 0);

        box._cleanup = function () {
            inputEl.removeEventListener('keydown', onKey);
            document.removeEventListener('click', offClick);
        };
    }

    function removeAllSuggestionBoxes() {
        document.querySelectorAll('.autocomplete-box-fixed').forEach(b => {
            if (b._cleanup) b._cleanup();
            b.remove();
        });
    }

    // Fetch suggestions from server
    async function fetchSuggestions(q) {
        if (!q || q.trim().length < 1) return [];
        try {
            const res = await fetch("<?= base_url('surat/autocomplete-nip') ?>?q=" + encodeURIComponent(q));
            if (!res.ok) return [];
            const data = await res.json();
            
            return (Array.isArray(data) ? data : []).map(it => {
                let nipValue = '';
                const possibleNipFields = ['nip', 'NIP', 'nip_karyawan', 'employee_number', 'nip_dosen', 'id'];
                
                for (let field of possibleNipFields) {
                    if (it[field] !== undefined && it[field] !== null && it[field] !== '') {
                        nipValue = String(it[field]);
                        break;
                    }
                }
                
                return {
                    nip: nipValue,
                    nama_dosen: it.nama_dosen || it.nama || it.name || it.nama_lengkap || it.full_name || '',
                    jabatan: it.jabatan || it.position || it.job_title || it.title || '',
                    divisi: it.divisi || it.division || it.fakultas || it.prodi || it.department || ''
                };
            });
        } catch (err) {
            console.error('fetchSuggestions err', err);
            return [];
        }
    }

    // Fetch by exact NIP
    async function fetchByNip(nip) {
        if (!nip || nip.trim().length < 1) return null;
        try {
            const res = await fetch("<?= base_url('get-dosen') ?>?nip=" + encodeURIComponent(nip));
            if (!res.ok) return null;
            const data = await res.json();
            
            let nipValue = '';
            if (data.nip !== undefined && data.nip !== null) {
                nipValue = String(data.nip);
            } else if (data.NIP !== undefined && data.NIP !== null) {
                nipValue = String(data.NIP);
            } else {
                nipValue = nip;
            }
            
            return {
                nip: nipValue,
                nama_dosen: data.nama_dosen || data.nama || '',
                jabatan: data.jabatan || data.position || '',
                divisi: data.divisi || data.division || ''
            };
        } catch (err) {
            console.error('fetchByNip err', err);
            return null;
        }
    }

    // Initialize autocomplete for a row
    function initAutocompleteForRow(rowEl) {
        if (!rowEl) return;
        
        if (rowEl.hasAttribute('data-autocomplete-init')) {
            return;
        }
        
        rowEl.setAttribute('data-autocomplete-init', 'true');

        const inputNip = rowEl.querySelector('.nip-input');
        const inputNama = rowEl.querySelector('.nama_dosen');
        const inputJabatan = rowEl.querySelector('.jabatan');
        const inputDivisi = rowEl.querySelector('.divisi');
        
        if (!inputNip || !inputNama || !inputJabatan || !inputDivisi) {
            return;
        }

        function fillRowWith(item) {
            if (!item) return;
            if (inputNip) inputNip.value = item.nip || '';
            if (inputNama) inputNama.value = item.nama_dosen || '';
            if (inputJabatan) inputJabatan.value = item.jabatan || '';
            if (inputDivisi) inputDivisi.value = item.divisi || '';
        }

        // NIP Input Handler
        const onNipInput = debounce(async function (ev) {
            const v = ev.target.value.trim();
            if (v.length < 1) {
                removeAllSuggestionBoxes();
                return;
            }
            const list = await fetchSuggestions(v);
            showSuggestionBox(inputNip, list, fillRowWith, 'nip');
        }, 250);

        if (inputNip._nipInputHandler) {
            inputNip.removeEventListener('input', inputNip._nipInputHandler.fn);
        }
        inputNip._nipInputHandler = { fn: onNipInput };
        inputNip.addEventListener('input', onNipInput);

        const onNipBlur = async function () {
            setTimeout(async () => {
                removeAllSuggestionBoxes();
                const val = inputNip.value.trim();
                if (!val) return;
                const data = await fetchByNip(val);
                if (data) fillRowWith(data);
            }, 150);
        };
        
        if (inputNip._nipBlurHandler) {
            inputNip.removeEventListener('blur', inputNip._nipBlurHandler.fn);
        }
        inputNip._nipBlurHandler = { fn: onNipBlur };
        inputNip.addEventListener('blur', onNipBlur);

        // NAMA DOSEN Input Handler
        const onNamaInput = debounce(async function (ev) {
            const v = ev.target.value.trim();
            if (v.length < 1) { 
                removeAllSuggestionBoxes(); 
                return; 
            }
            const list = await fetchSuggestions(v);
            showSuggestionBox(inputNama, list, fillRowWith, 'nama');
        }, 250);

        if (inputNama._namaInputHandler) {
            inputNama.removeEventListener('input', inputNama._namaInputHandler.fn);
        }
        inputNama._namaInputHandler = { fn: onNamaInput };
        inputNama.addEventListener('input', onNamaInput);

        // JABATAN Input Handler
        const onJabatanInput = debounce(async function (ev) {
            const v = ev.target.value.trim();
            if (v.length < 1) { 
                removeAllSuggestionBoxes(); 
                return; 
            }
            const list = await fetchSuggestions(v);
            showSuggestionBox(inputJabatan, list, fillRowWith, 'jabatan');
        }, 250);

        if (inputJabatan._jabatanInputHandler) {
            inputJabatan.removeEventListener('input', inputJabatan._jabatanInputHandler.fn);
        }
        inputJabatan._jabatanInputHandler = { fn: onJabatanInput };
        inputJabatan.addEventListener('input', onJabatanInput);

        // DIVISI Input Handler
        const onDivisiInput = debounce(async function (ev) {
            const v = ev.target.value.trim();
            if (v.length < 1) { 
                removeAllSuggestionBoxes(); 
                return; 
            }
            const list = await fetchSuggestions(v);
            showSuggestionBox(inputDivisi, list, fillRowWith, 'divisi');
        }, 250);

        if (inputDivisi._divisiInputHandler) {
            inputDivisi.removeEventListener('input', inputDivisi._divisiInputHandler.fn);
        }
        inputDivisi._divisiInputHandler = { fn: onDivisiInput };
        inputDivisi.addEventListener('input', onDivisiInput);
    }

    // Init existing rows
    document.querySelectorAll('.panitia-row').forEach(r => initAutocompleteForRow(r));

    window.addEventListener('resize', removeAllSuggestionBoxes);
    
    let scrollTimeout;
    window.addEventListener('scroll', function(e) {
        const activeBox = document.querySelector('.autocomplete-box-fixed');
        if (!activeBox) return;
        
        const isScrollingInsideBox = activeBox.contains(e.target) || e.target === activeBox;
        if (isScrollingInsideBox) {
            e.stopPropagation();
            return;
        }
        
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            if (activeBox && activeBox._sourceInput) {
                const rect = activeBox._sourceInput.getBoundingClientRect();
                activeBox.style.left = rect.left + 'px';
                activeBox.style.top = (rect.bottom + 4) + 'px';
            }
        }, 10);
    }, true);
    
    document.body.addEventListener('wheel', function(e) {
        const activeBox = document.querySelector('.autocomplete-box-fixed');
        if (activeBox && activeBox.contains(e.target)) {
            const isAtTop = activeBox.scrollTop === 0;
            const isAtBottom = activeBox.scrollHeight - activeBox.scrollTop === activeBox.clientHeight;
            
            if ((isAtTop && e.deltaY < 0) || (isAtBottom && e.deltaY > 0)) {
                e.preventDefault();
            }
        }
    }, { passive: false });
});
</script>
<!-- ===== UPLOADCARE CDN ===== -->
<script>
    UPLOADCARE_PUBLIC_KEY = "demopublickey"; 
    UPLOADCARE_LOCALE = "en";
</script>
<script src="https://ucarecdn.com/libs/widget/3.x/uploadcare.full.min.js"></script>

<!-- ===== STYLE UNTUK UI STEP 3 ===== -->
<style>
/* Card container */
.upload-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 28px 32px;
    border: 1px solid #e6e6e6;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    max-width: 620px;
    margin: auto;
    transition: 0.3s ease;
}
.upload-card:hover {
    box-shadow: 0 8px 22px rgba(0,0,0,0.10);
    transform: translateY(-2px);
}

/* Title */
.upload-title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 6px;
    text-align: center;
    color: #333;
}

/* Description */
.upload-desc {
    font-size: 14px;
    color: #666;
    text-align: center;
    margin-bottom: 25px;
}

/* Uploadcare button customization */
.uploadcare--widget__button,
.ucare-widget__button {
    background: #FB8C00 !important;
    border-radius: 12px !important;
    font-size: 14px !important;
    padding: 11px 20px !important;
    font-weight: 600;
    transition: 0.25s ease;
}

.uploadcare--widget__button:hover {
    background: #e07000 !important;
}

/* Error text */
#chk-error {
    color: #e53935;
    font-size: 13px;
    margin-top: 10px;
    display: block;
    text-align: center;
}
</style>

<!-- ===== STEP 3 ===== -->
<fieldset>
    <div class="container" style="min-height: 270px; display: flex; justify-content: center;">

        <div class="upload-card">

            <div class="upload-title">Upload File Eviden</div>
            <div class="upload-desc">
                Unggah foto atau dokumen pendukung. Anda dapat memilih lebih dari satu file.
            </div>

            <input 
                type="hidden"
                name="eviden"
                id="evidenUploader"
                role="uploadcare-uploader"

                data-multiple="true"
                data-multiple-max="0"
                data-multiple-min="1"
                data-clearable="true"

                data-preview-step="true"
                data-images-only="false"

                data-tabs="file url camera dropbox gdrive"
                data-multiple-upload="true"
            />

            <span id="chk-error"></span>

        </div>

    </div>
</fieldset>

<!-- ===== BUTTON AREA ===== -->
<div class="button-area" style="margin-top:25px; text-align:center;">
    <button type="button" class="btn btn-primary prev-btn rounded-pill btn-sm" style="padding: 6px 20px;">Back</button>
    <button type="button" class="action-btn next-btn rounded-pill btn-sm" style="padding: 6px 20px;">Continue</button>
</div>

<!-- ===== SCRIPT VALIDASI ===== -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const nextBtn = document.querySelector(".next-btn");
    const prevBtn = document.querySelector(".prev-btn");
    const uploader = document.querySelector("#evidenUploader");
    const err = document.getElementById("chk-error");

    // Tombol Back
    prevBtn.addEventListener("click", function () {
        console.log("Going back...");
    });

    // Validasi Continue
    nextBtn.addEventListener("click", function () {

        const value = uploader.value;

        if (!value || value.trim() === "") {
            err.textContent = "Mohon upload minimal 1 file eviden!";
            return;
        }

        err.textContent = "";
        console.log("Files:", value);
        console.log("Continuing...");
    });

});
</script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

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

<!-- ===== STYLE ===== -->
<style>
.custom-search-container{display:flex;gap:10px;margin-bottom:15px;max-width:800px;align-items:center}
.input-icon-wrapper{position:relative;flex:1}
.filter-category{position:relative;min-width:200px}
.input-icon-wrapper input,.input-icon-wrapper select,.filter-category select{width:100%;border:1.5px solid #FB8C00;border-radius:25px;padding:10px 40px 10px 15px;outline:none;font-size:14px;background:white;height:42px}
input[type="date"]::-webkit-calendar-picker-indicator{opacity:0;cursor:pointer;position:absolute;right:0;width:100%;height:100%}
.input-icon-wrapper i,.filter-category i{position:absolute;right:15px;top:50%;transform:translateY(-50%);font-size:16px;color:#FB8C00;pointer-events:none}
.input-icon-wrapper input:focus,.input-icon-wrapper select:focus,.filter-category select:focus{box-shadow:0 0 8px #FB8C00}
#tabelSurat{width:100%;border-collapse:collapse;background:white;border-radius:8px;overflow:hidden;font-size:14px;box-shadow:0 4px 12px rgba(0,0,0,0.1)}
#tabelSurat thead{background:#FB8C00;color:white}
#tabelSurat td,#tabelSurat th{padding:12px;border:1px solid #ddd;vertical-align:middle}
#tabelSurat td:nth-child(4),#tabelSurat td:nth-child(5){min-width:180px;max-width:280px}
.dosen-container,.divisi-container{display:flex;flex-wrap:wrap;gap:5px;align-items:center}
.nama-dosen-badge{display:inline-block;background:#fff4e6;color:#663c00;padding:6px 12px;border-radius:15px;font-size:12px;border:1px solid #FB8C00;white-space:nowrap;max-width:250px;overflow:hidden;text-overflow:ellipsis}
.nama-dosen-more{display:inline-block;background:#FB8C00;color:white;padding:6px 12px;border-radius:15px;font-size:12px;font-weight:600;cursor:pointer;white-space:nowrap;transition:all 0.3s}
.nama-dosen-more:hover{background:#e67e00;transform:scale(1.05)}
.divisi-badge{display:inline-block;background:#e3f2fd;color:#0d47a1;padding:6px 12px;border-radius:15px;font-size:12px;border:1px solid #2196F3;white-space:nowrap}
.modal-detail{display:none !important;position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:9999;justify-content:center;align-items:center;padding-top:40px}
.modal-detail.show{display:flex !important}
.modal-content-detail{width:85%;max-width:850px;background:white;border-radius:12px;overflow:hidden}
.modal-header-detail{background:#FB8C00;padding:14px 18px;color:white;display:flex;justify-content:space-between}
.modal-body-detail{max-height:60vh;overflow-y:auto;padding:18px}
.detail-table{width:100%;border-collapse:collapse}
.detail-table td{padding:10px 12px;border-bottom:1px solid #eee}
.detail-key{width:35%;font-weight:600;background:#fff4e6;color:#663c00}
.dataTables_wrapper .dataTables_paginate .paginate_button{background:#FB8C00;color:white !important;border-radius:5px;padding:5px 10px}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover{background:#e67e00}
.btn-reset{background:#FB8C00;color:white;border:none;border-radius:25px;padding:10px 20px;cursor:pointer;font-size:14px;height:42px;white-space:nowrap}
.btn-reset:hover{background:#e67e00}
</style>

<!-- ===== SEARCH + FILTER ===== -->
<div class="custom-search-container">
    <div class="input-icon-wrapper">
        <input type="text" id="tableSearch" placeholder="Search...">
        <i class="fa fa-search"></i>
    </div>

    <div class="filter-category">
        <select id="filterCategory">
            <option value="">Pilih Kategori Filter</option>
            <option value="jenis">Jenis Pengajuan</option>
            <option value="dosen">Nama Dosen</option>
            <option value="divisi">Divisi</option>
            <option value="tanggal">Tanggal Pengajuan</option>
        </select>
        <i class="fa fa-filter"></i>
    </div>

    <div class="input-icon-wrapper" id="filterValueContainer" style="display:none;">
        <select id="filterValue" style="display:none;"><option value="">Pilih...</option></select>
        <input type="date" id="filterTanggalMulai" style="display:none;">
        <input type="date" id="filterTanggalSelesai" style="display:none;">
        <i class="fa fa-check-circle"></i>
    </div>

    <button class="btn-reset" id="btnReset" style="display:none;"><i class="fa fa-times"></i> Reset</button>
</div>

<!-- ===== MODAL DETAIL ===== -->
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

<!-- ===== TABLE ===== -->
<table id="tabelSurat" class="display nowrap">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Kegiatan</th>
            <th>Jenis Pengajuan</th>
            <th>Nama Dosen</th>
            <th>Divisi</th>
            <th>Tanggal Pengajuan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($surat_list as $s): ?>
            <?php
            // Prepare a detail array with decoded JSON fields to ensure JS receives proper types
            $detail = (array) $s;

            // decode fields that might be stored as JSON strings
            foreach (['nip','nama_dosen','jabatan','divisi','eviden'] as $jf) {
                if (isset($detail[$jf]) && is_string($detail[$jf])) {
                    $decoded = json_decode($detail[$jf], true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $detail[$jf] = $decoded;
                    } else {
                        // leave as original string (fallback)
                        $detail[$jf] = $detail[$jf];
                    }
                }
            }

            // json_encode and escape for data-detail attribute
            $data_detail_attr = htmlspecialchars(json_encode($detail, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8');
            ?>
        <tr class="row-detail" data-detail='<?= $data_detail_attr; ?>'>
            <td><?= $s->id; ?></td>
            <td><?= htmlspecialchars($s->nama_kegiatan); ?></td>
            <td><?= htmlspecialchars($s->jenis_pengajuan); ?></td>
            <td>
                <div class="dosen-container">
                    <?php
                    $nd = $s->nama_dosen;
                    if (is_string($nd)) {
                        $maybe = json_decode($nd, true);
                        if (json_last_error() === JSON_ERROR_NONE) $nd = $maybe;
                    }
                    if (!empty($nd)) {
                        if (is_array($nd)) {
                            $nama = $nd[0] ?? '-';
                            $short = strlen($nama) > 30 ? substr($nama,0,30).'...' : $nama;
                            echo '<span class="nama-dosen-badge" title="'.htmlspecialchars($nama).'">'.htmlspecialchars($short).'</span>';
                            if (count($nd) > 1) {
                                echo '<span class="nama-dosen-more" title="Klik row untuk lihat semua dosen">+'.(count($nd)-1).'</span>';
                            }
                        } else {
                            $nama = $nd;
                            $short = strlen($nama) > 30 ? substr($nama,0,30).'...' : $nama;
                            echo '<span class="nama-dosen-badge" title="'.htmlspecialchars($nama).'">'.htmlspecialchars($short).'</span>';
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
                    $dv = $s->divisi;
                    if (is_string($dv)) {
                        $maybe2 = json_decode($dv, true);
                        if (json_last_error() === JSON_ERROR_NONE) $dv = $maybe2;
                    }
                    if (!empty($dv)) {
                        if (is_array($dv)) {
                            foreach ($dv as $div) {
                                echo '<span class="divisi-badge">'.htmlspecialchars($div).'</span>';
                            }
                        } else {
                            echo '<span class="divisi-badge">'.htmlspecialchars($dv).'</span>';
                        }
                    } else {
                        echo '-';
                    }
                    ?>
                </div>
            </td>
            <td><?= isset($s->tanggal_pengajuan) && $s->tanggal_pengajuan ? htmlspecialchars($s->tanggal_pengajuan) : '-'; ?></td>
            <td>
                <a href="<?= site_url('surat/edit/'.$s->id); ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="<?= site_url('surat/delete/'.$s->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
$(document).ready(function () {

    let table = $('#tabelSurat').DataTable({
        responsive: true,
        pageLength: 5,
        dom: 'rtp',
        columnDefs: [{ orderable: false, targets: -1 }]
    });

    // ==== FILTER DATA PREP ====
    const filterData = {
        jenis: <?= json_encode(array_values(array_unique(array_map(function($s){ return $s->jenis_pengajuan; }, $surat_list)))); ?>,
        dosen: <?= json_encode(array_values(array_unique(array_reduce($surat_list, function($carry, $s){
            if(isset($s->nama_dosen) && !empty($s->nama_dosen)) {
                $nd = $s->nama_dosen;
                if (is_string($nd)) {
                    $maybe = json_decode($nd, true);
                    if (json_last_error() === JSON_ERROR_NONE) $nd = $maybe;
                }
                if(is_array($nd)) foreach($nd as $d) $carry[] = trim($d);
                else $carry[] = trim($nd);
            }
            return $carry;
        }, [])))); ?>,
        divisi: <?= json_encode(array_values(array_unique(array_reduce($surat_list, function($carry, $s){
            if(isset($s->divisi) && !empty($s->divisi)) {
                $dv = $s->divisi;
                if (is_string($dv)) {
                    $maybe2 = json_decode($dv, true);
                    if (json_last_error() === JSON_ERROR_NONE) $dv = $maybe2;
                }
                if(is_array($dv)) foreach($dv as $d) $carry[] = trim($d);
                else $carry[] = trim($dv);
            }
            return $carry;
        }, [])))); ?>
    };

    $('#tableSearch').keyup(() => table.search($('#tableSearch').val()).draw());

    $('#filterCategory').change(function() {
        const category = $(this).val();
        $('#filterValue, #filterTanggalMulai, #filterTanggalSelesai').hide().val('');

        if (category === '') {
            $('#filterValueContainer, #btnReset').hide();
            table.columns([2,3,4]).search('').draw();
            if ($.fn.dataTable.ext.search.length > 0) $.fn.dataTable.ext.search.pop();
            table.draw();
            return;
        }

        $('#filterValueContainer, #btnReset').show();

        if (category === 'tanggal') {
            $('#filterTanggalMulai, #filterTanggalSelesai').show();

            if ($.fn.dataTable.ext.search.length === 0) {
                $.fn.dataTable.ext.search.push(function(settings, data) {
                    let start = $('#filterTanggalMulai').val();
                    let end = $('#filterTanggalSelesai').val();
                    let tgl = data[5] || '';
                    if (!start && !end) return true;
                    if (start && tgl < start) return false;
                    if (end && tgl > end) return false;
                    return true;
                });
            }
        } else {
            if ($.fn.dataTable.ext.search.length > 0) $.fn.dataTable.ext.search.pop();

            $('#filterValue').show().empty().append('<option value="">Pilih...</option>');
            const data = filterData[category] || [];
            data.sort().forEach(item => {
                const short = item.length > 50 ? item.substring(0,50) + '...' : item;
                $('#filterValue').append(`<option value="${item}" title="${item}">${short}</option>`);
            });
        }
    });

    $('#filterValue').change(function() {
        const category = $('#filterCategory').val();
        const value = $(this).val();

        let columnIndex = 2;
        if (category === 'dosen') columnIndex = 3;
        else if (category === 'divisi') columnIndex = 4;

        table.columns([2,3,4]).search('');
        table.column(columnIndex).search(value).draw();
    });

    $('#filterTanggalMulai, #filterTanggalSelesai').change(() => table.draw());

    $('#btnReset').click(function() {
        $('#filterCategory, #filterValue, #filterTanggalMulai, #filterTanggalSelesai').val('');
        $('#filterValueContainer, #btnReset').hide();
        $('#filterValue, #filterTanggalMulai, #filterTanggalSelesai').hide();
        table.columns([2,3,4]).search('').draw();
        if ($.fn.dataTable.ext.search.length > 0) $.fn.dataTable.ext.search.pop();
        table.draw();
    });

    // ===== POPUP DETAIL WITH ROBUST EVIDEN HANDLING =====
    const BASE_URL = '<?= rtrim(base_url(), "/"); ?>';

    $('#tabelSurat tbody').on('click', 'tr.row-detail', function(e) {
        if ($(e.target).closest('a').length) return;

        let raw = $(this).attr('data-detail') || '{}';
        let data;
        try {
            data = JSON.parse(raw);
        } catch (err) {
            console.error('Invalid data-detail JSON', err, raw);
            data = {};
        }

        let html = '';

        Object.entries(data).forEach(([k, v]) => {
            let display = v;

            if (display === null || display === undefined || (typeof display === 'string' && display.trim() === '')) {
                display = '-';
            }

            // ======== FIX: FORCE DOWNLOAD EVIDEN ========
            if (k === 'eviden') {

                if (typeof display === 'string') {
                    try { display = JSON.parse(display); } catch (e) {}
                }

                if (Array.isArray(display) && display.length > 0) {
                    let list = '<ul style="margin:0;padding-left:18px;">';

                    display.forEach(item => {

                        let url = '';
                        let name = '';

                        if (typeof item === 'string') {
                            url = item;
                            name = item.split('/').pop().split('?')[0];
                        } else if (typeof item === 'object' && item !== null) {
                            if (item.cdnUrl) url = item.cdnUrl;
                            else if (item.path) {
                                url = item.path.charAt(0) === '/' || item.path.startsWith('http') ? item.path : '/' + item.path;
                                if (!url.startsWith('http')) url = BASE_URL + url;
                            } else if (item.url) url = item.url;
                            name = item.nama_asli || item.name || (url ? url.split('/').pop().split('?')[0] : 'file');
                        }

                        if (url && !url.match(/^https?:\/\//i)) {
                            if (!url.startsWith('/')) url = '/' + url;
                            url = BASE_URL + url;
                        }

                        const escName = $('<div/>').text(name).html();
                        const escUrl = $('<div/>').text(url).html();

                        list += `
                            <li style="margin-bottom:6px;">
                                <a href="#" class="force-download"
                                   data-url="${escUrl}"
                                   data-name="${escName}"
                                   style="color:#FB8C00;font-weight:600;text-decoration:none;">
                                   📄 ${escName}
                                </a>
                            </li>`;
                    });

                    list += '</ul>';
                    display = list;

                } else {
                    display = '-';
                }
            }
            // ========= END FIX =========

            else if (Array.isArray(display)) {
                display = display.map(x => $('<div/>').text(String(x)).html()).join('<br>');
            } else {
                if (typeof display === 'string') display = $('<div/>').text(display).html();
            }

            html += `
            <tr>
                <td class="detail-key">${k.replace(/_/g,' ')}</td>
                <td>${display}</td>
            </tr>`;
        });

        $('#detailContent').html(html);
        $('#modalDetail').addClass('show');
    });

    // ===== FORCE DOWNLOAD HANDLER =====
    $(document).on("click", ".force-download", function(e){
        e.preventDefault();

        const url = $(this).data("url");
        const name = $(this).data("name");

        const link = document.createElement("a");
        link.href = url + "?download=1";
        link.download = name || "file";

        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

    $('.close-modal').click(() => $('#modalDetail').removeClass('show'));
    $(window).click(e => { 
        if (e.target.id === 'modalDetail') $('#modalDetail').removeClass('show'); 
    });
});
</script>

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
    <script src="https://cdn.tiny.cloud/1/q9tneu2aax9fp91cvqlh7mqvx44p6ph4jb63xq6lax2ybita/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'save autosave preview autolink lists media table print',
            toolbar: 'export table bold italic underline bullist numlist alignleft aligncenter alignright alignjustify fontsizeselect forecolor lineheight h1 h2 h3 h4 h5 h6 ',
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            height: '450',

            // he
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
</script>




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