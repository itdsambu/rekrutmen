<!DOCTYPE html>
<html lang="en">

<head>
    <title>PostTest/PreTest Training Online</title>
    <!-- <title><?php echo $this->config->item("nama_app"); ?></title> -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel='shortcut icon' type='image icon' href="<?php echo base_url(); ?>assets/img/psg-logo.png" />

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/psikotes/plugin/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/psikotes/plugin/css/animate.css">

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/psikotes/plugin/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/psikotes/plugin/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/psikotes/plugin/css/magnific-popup.css">

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/psikotes/plugin/css/aos.css">

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/psikotes/plugin/css/ionicons.min.css">

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/psikotes/plugin/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/psikotes/plugin/css/jquery.timepicker.css">


    <link rel="stylesheet" href="<?php echo base_url() ?>assets/psikotes/plugin/css/flaticon.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/psikotes/plugin/css/icomoon.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/psikotes/plugin/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/psikotes/plugin/vendor/bootstrap-validator/css/bootstrapValidator.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/psikotes/plugin/vendor/bootstrap-select/css/bootstrap-select.min.css'); ?>">
    <link href="<?php echo base_url('asset/vendor/bootstrap-table/bootstrap-table.min.css'); ?>" rel="stylesheet">

    <style>
        input[type="text"]:disabled {
            background: #ccc;
        }

        /* The container */
        .container {
            display: block;
            position: relative;
            padding-left: 40px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 16px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default radio button */
        .container label input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #eee;
            border-radius: 50%;
        }

        /* On mouse-over, add a grey background color */
        .container:hover input~.checkmark {
            background-color: #ccc;
        }

        /* When the radio button is checked, add a blue background */
        .container input:checked~.checkmark {
            background-color: #2878fa;
        }

        /* Create the indicator (the dot/circle - hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the indicator (dot/circle) when checked */
        .container input:checked~.checkmark:after {
            display: block;
        }

        /* Style the indicator (dot/circle) */
        .container .checkmark:after {
            top: 7px;
            left: 7px;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: white;
        }

        .funkyradio div {
            clear: both;
            overflow: hidden;
        }

        .funkyradio label {
            width: 90%;
            border-radius: 3px;
            border: 1px solid #D1D3D4;
            font-weight: normal;
        }

        .funkyradio input[type="radio"]:empty,
        .funkyradio input[type="checkbox"]:empty {
            display: none;
        }

        .funkyradio input[type="radio"]:empty~label,
        .funkyradio input[type="checkbox"]:empty~label {
            position: relative;
            line-height: 2em;
            text-indent: 3em;
            margin-top: 0em;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }


        .funkyradio input[type="radio"]:empty~label:before,
        .funkyradio input[type="checkbox"]:empty~label:before {
            position: absolute;
            display: block;
            top: 0;
            bottom: 0;
            left: 0;
            content: '';
            width: 2.5em;
            background: #D1D3D4;
            border-radius: 3px 0 0 3px;
        }

        .funkyradio input[type="radio"]:hover:not(:checked)~label,
        .funkyradio input[type="checkbox"]:hover:not(:checked)~label {
            color: #888;
        }

        .funkyradio input[type="radio"]:hover:not(:checked)~label:before,
        .funkyradio input[type="checkbox"]:hover:not(:checked)~label:before {
            content: '\2714';
            text-indent: .9em;
            color: #C2C2C2;
        }

        .funkyradio input[type="radio"]:checked~label,
        .funkyradio input[type="checkbox"]:checked~label {
            color: #777;
        }

        .funkyradio input[type="radio"]:checked~label:before,
        .funkyradio input[type="checkbox"]:checked~label:before {
            content: '\2714';
            text-indent: .9em;
            color: #333;
            background-color: #ccc;
        }

        .funkyradio input[type="radio"]:focus~label:before,
        .funkyradio input[type="checkbox"]:focus~label:before {
            box-shadow: 0 0 0 3px #999;
        }

        .funkyradio-success input[type="radio"]:checked~label:before,
        .funkyradio-success input[type="checkbox"]:checked~label:before {
            color: #fff;
            background-color: #5cb85c;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="">Post Test / Pre Test Training Online</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item cta"><a href="#" class="nav-link" data-toggle="modal" data-target="#modalTata_cara"><span>Tata Cara</span></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="home-slider owl-carousel">
        <div class="slider-item" style="background-image: url('<?php echo base_url() ?>assets/psikotes/plugin/images/background.jpg'); height: 600px;">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text align-items-center" data-scrollax-parent="true">
                    <div class="col-md-6 col-sm-12 ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
                        <?php foreach ($_dept as $dept) {
                            $deptnm = $dept->Nama;
                            $dpetid = $dept->DeptID;
                            echo "<span>Departmen :</span>";
                        } ?>
                        <?php if ($dpetid == '12') {
                            $deptnm = explode(" ", $dept->Nama);
                            $deptOwner    = $deptnm[0];
                            $deptOwner1   = $deptnm[1];
                        ?>
                            <h1 class="mb-4 text-meduim" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><?php echo $deptOwner; ?> </h1>
                        <?php
                        } else { ?>
                            <h1 class="mb-4 text-meduim" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><?php echo $deptnm; ?> </h1>
                        <?php
                        } ?>
                        <!-- <img src="<?php echo base_url(); ?>assetspsikotes//img/psg-logo.png" alt="logo" width="250px" height="250px" align="center"> -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-intro">
        <div class="container">
            <div class="row no-gutters">
                <!-- DATA DIRI -->
                <div class="col-md-6 color-3 p-4">
                    <h3 class="mb-2">DATA DIRI</h3>
                    <hr>
                    <form id="data_diri" class="appointment-form">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group row status">
                                    <label for="Materi" class="col-sm-6 col-form-label"><span class="icon-paper-plane"></span> Status Pekerja</label>
                                    <select class="selectpicker col-sm-11" name="txtStatus" id="sts_pekerja">
                                        <option value="">- Pilih Status TK -</option>
                                        <option value="1">Tenaga Kerja</option>
                                        <option value="2">Non Tenaga Kerja</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 NIK">
                                <div class="form-group">
                                    <div class="icon"><span class="icon-id-card"></span></div>
                                    <input type="text" class="form-control" placeholder="Nik" name="txtNik" id="nik" maxlength="10" autocomplete="off">
                                    <input type="hidden" class="form-control" placeholder="fixreg" name="txtfixReg" id="fixreg" readonly required>
                                    <input type="hidden" class="form-control" placeholder="idPerson" name="txtPerson" id="idPerson" readonly required>
                                    <input type="hidden" class="form-control" placeholder="karyawanSt" name="txtStatusPerson" id="karyawanSt" readonly required>
                                </div>
                            </div>
                            <div class="col-sm-6 ID">
                                <div class="form-group">
                                    <div class="icon"><span class="icon-id-card"></span></div>
                                    <input type="text" class="form-control" placeholder="Input ID" name="txtId" id="id_register" maxlength="10" autocomplete="off">
                                    <input type="hidden" class="form-control" placeholder="Position" name="txtPosition" id="position" readonly required>
                                </div>
                            </div>

                            <div class="col-sm-6 name">
                                <div class="form-group">
                                    <div class="icon"><span class="icon-user"></span></div>
                                    <input type="text" class="form-control" placeholder="Nama Auto" name="txtNama" id="nama_lengkap" data-bv-notempty="true" data-bv-notempty-message="Nama tidak boleh kosong" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 bagian">
                                <div class="form-group">
                                    <div class="icon"><span class="icon-work"></span></div>
                                    <input type="text" class="form-control" placeholder="Bagian Auto" name="txtBagian" id="bag" readonly>
                                    <input type="hidden" class="form-control" placeholder="Bagian Auto" name="txtBagianID" id="bagianID" readonly required>
                                </div>
                            </div>

                            <div class="col-sm-6 jabatan">
                                <div class="form-group">
                                    <div class="icon"><span class="icon-work"></span></div>
                                    <input type="text" class="form-control" placeholder="Jabatan Auto" name="txtJabatan" id="jabatan" readonly required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- KRITERIA SOAL  -->
                <div class="col-md-6 color-3 p-4">
                    <h3 class="mb-2">KRITERIA SOAL</h3>
                    <hr>
                    <form id="frm_soal" class="appointment-form">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="Departemen" class="col-sm-6 col-form-label" style="font-size: 15px;"><span class="icon-home"></span> Departemen</label>
                                    <select class="selectpicker col-sm-11" name="txtDept" id="dept" data-bv-notempty="true" data-bv-notempty-message="Departemen belum dipilih">
                                        <?php foreach ($_dept as $dept) {
                                            echo "<option value='$dept->DeptID'>" . $dept->DeptAbbr . "</option>";
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="Jenis Soal" class="col-sm-6 col-form-label"><span class="icon-link"></span> Jenis Soal</label>
                                    <select class="selectpicker col-sm-11" name="txtJenisSoal" id="jenis_soal">
                                        <?php if ($jenis_soal == 1) {
                                            echo "<option value= '1' selected> Pre Test </option>
                                                    <option value='2'>Post Test</option>";
                                        } elseif ($jenis_soal == 2) {
                                            echo '<option value="1">Pre Test</option>
                                                    <option value="2" selected>Post Test</option>';
                                        } else {
                                            echo '<option value="1">Pre Test</option>
						            			    <option value="2">Post Test</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <?php foreach ($_dept as $dept) {
                            $id = $dept->DeptID;
                        } ?>
                        <?php if ($id == '46') { ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="Bagian" class="col-sm-6 col-form-label"><span class="icon-book"></span> Bagian</label>
                                        <input type="text" class="form-control" name="txtBagian2" id="bagian2" value="" disabled>
                                    </div>
                                </div>
                            </div>
                        <?php
                        } ?>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="Materi" class="col-sm-6 col-form-label"><span class="icon-book"></span> Materi</label>
                                    <?php foreach ($materi as $mtr) { ?>
                                        <input type="text" class="form-control" name="txtMateri" id="materi_id" value="<?php echo $mtr->JudulMateri; ?>" disabled>
                                        <input type="hidden" class="form-control" name="txtMateriid" id="materidtl_id" value="<?php echo $mtr->IKPMateriDtl; ?>" disabled>
                                        <input type="hidden" class="form-control" name="txtIdKategoriMateri" id="idKategoriMateri" value="<?php echo $mtr->KategoriMateri; ?>" disabled>
                                    <?php
                                    } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="Materi" class="col-sm-6 col-form-label"><span class="icon-paper-plane"></span> Ruangan/Lokasi</label>
                                    <select class="selectpicker col-sm-11" name="txtRuangan" id="ruangan" data-bv-notempty="true" data-bv-notempty-message="Ruangan/Lokasi belum dipilih">
                                        <option value="">- Pilih Ruangan -</option>
                                        <option value="1">Ruang Training Internal Departemen</option>
                                        <option value="2">Ruang Training HRD</option>
                                        <option value="3">Ditentukan Oleh Dept/Bagian Masing-Masing</option>
                                    </select>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group row" id="ruangan_id">
                                        <input type="text" class="form-control" placeholder="Masukan detail lokasi ruangan anda" name="txtMatxtNamaRuanganteri" id="nama_ruangan" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if (isset($getSoal)) {
                            foreach ($getSoal as $row) {
                                $soalID = $row->IdMstSoalHdr;
                            } ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <input type="hidden" class="form-control" name="txtHdrSoali" id="txtHdrSoal" value="<?php echo $soalID; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        <?php
                        } ?>
                    </form>
                </div>
                <!-- Waktu -->
                <div class="col-md-12 color-1 p-4">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group row">
                                <label for="Materi" class="col-sm-6 col-form-label"><span class="icon-alarm"></span> Waktu Pengerjaan</label>
                                <?php foreach ($_getWaktu as $key) {
                                    $durasi             = $key->SettingWaktu;
                                    $waktu              = date('H:i:s', strtotime($key->WaktuPublish . '+' . $durasi . ' minute'));
                                    $tanggal_sekarang   = date('M d, Y');
                                    $tanggal_publis     = date('M d, Y', strtotime($key->WaktuPublish));
                                } ?>
                                <input type="hidden" class="form-control" name="txtWaktu" id="waktu" value="<?php echo $waktu; ?>" disabled>
                                <input type="hidden" class="form-control" name="txtTanggal" id="Tanggal" value="<?php echo date('M d, Y', strtotime($key->WaktuPublish)); ?>" disabled>
                                <input type="hidden" class="form-control" name="txtWaktuPublish" id="waktuPublish" value="<?php echo date('H:i:s', strtotime($key->WaktuPublish)); ?>" disabled>
                                <input type="hidden" class="form-control" name="txtJamSekarang" id="JamSekarang" value="<?php echo date('H:i:00'); ?>" disabled>
                                <?php
                                $tes = date('Y', strtotime($key->WaktuPublish));
                                // print_r($tanggal_sekarang);
                                // die;
                                if ($tes != '1970') {
                                    if ($tanggal_publis == $tanggal_sekarang) { ?>
                                        <div class="form-group" id="startTest">
                                            <div class="col-sm-12 p-4">
                                                <button type="submit" class="btn btn-md btn-success blink_me" id="start">START</button>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                } else { ?>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <h3 class="alert-heading font-18 blink_me" style="text-align: center;"></h3>
                                            <h3 class="alert-heading font-18 blink_me" style="text-align:center;font-weight: bold;">HALAMAN INI TIDAK DAPAT DI AKSES..!!</h3>
                                            <p class="mb-0" style="text-align:center;"></p>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        function blinker() {
                                            $('.blink_me').fadeOut(1000);
                                            $('.blink_me').fadeIn(1000);
                                        }
                                        setInterval(blinker, 1000);
                                    </script>
                                <?php
                                } ?>
                            </div>
                            <div class="form-group">
                                <!-- <button type="submit" class="btn btn-md btn-success blink_me" id="start">START</button> -->
                                <div class="col-sm-12">
                                    Registration closes in <span id="time">02:00</span> minutes!
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Lembar Soal & Tanda tangan -->
    <section class="ftco-section">
        <div class="container frame_soal"> </div>
    </section>

    <footer class="ftco-footer ftco-bg-dark ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    &copy; PT Pulau Sambu Guntung - <script>
                        document.write(new Date().getFullYear());
                    </script>
                    <!-- &copy; PT Pulau Sambu Guntung - <?= date('Y'); ?> -->
                </div>
            </div>
        </div>
    </footer>

    <div class="modal fade" id="modalTata_cara" tabindex="-1" role="dialog" aria-labelledby="modalRequestLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12 d-flex">
                        <div class="about-wrap">
                            <div class="heading-section heading-section-white mb-5 ftco-animate">
                                <h2 class="mb-2">Tata Cara Training Online</h2>
                            </div>
                            <div class="list-services d-flex ftco-animate">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <span class="icon-check2"></span>
                                </div>
                                <div class="text">
                                    <h3>Daftar Akun / Peserta </h3>
                                    <p>Untuk daftarkan Akun / Peserta Silahkan menghubungi <b>ADMIN</b> dept atau <b>HRD</b>.</p>
                                </div>
                            </div>
                            <div class="list-services d-flex ftco-animate">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <span class="icon-check2"></span>
                                </div>
                                <div class="text">
                                    <h3>Data Diri</h3>
                                    <p>Pilih Status Pekerja. <br> Untuk (<b><i>Tenaga Kerja</i></b>), bagi <b>Karyawan</b> atau pun <b>Harian</b> yang sudah bekerja di <b>PT PULAU SAMBU</b>.<br>(<b><i>Non Tenaga Kerja</i></b>), untuk pelamar.</p>
                                </div>
                            </div>
                            <div class="list-services d-flex ftco-animate">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <span class="icon-check2"></span>
                                </div>
                                <div class="text">
                                    <h3>Input ID</h3>
                                    <p>ID untuk <b>Calon Tenaga Kerja</b> Baru, akan di beri oleh <b>HRD</b>.</p>
                                </div>
                            </div>
                            <div class="list-services d-flex ftco-animate">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <span class="icon-check2"></span>
                                </div>
                                <div class="text">
                                    <h3>Kerjakan Soal Test</h3>
                                    <p>kerjakan Soal Test ,Pilih jawaban yang menurut anda benar.(Waktu pengerjaan Maksimal 60 menit jika melebih maka sistem akan berhenti secara otomatis).<br><i>waktu pengerjaan bisa saja berubah tergantung kebijakan departemen</i>.</p>
                                </div>
                            </div>
                            <div class="list-services d-flex ftco-animate">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <span class="icon-check2"></span>
                                </div>
                                <div class="text">
                                    <h3>Lihat Hasil</h3>
                                    <p>Setelah mengerjakan test maka hasil akan langsung keluar dan anda dapat langsung mencetak Hasil Tes. </p>
                                    <!-- <p>Setelah mengerjakan test maka hasil akan langsung keluar dan anda dapat langsung mencetak Hasil Tes.Hasil Tes juga dapat di buka melalui menu cari data. </p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="<?php echo base_url() ?>assets/psikotes/plugin/js/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/psikotes/plugin/js/jquery-migrate-3.0.1.min.js"></script>
    <script src="<?php echo base_url() ?>assets/psikotes/plugin/js/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets/psikotes/plugin/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/psikotes/plugin/js/jquery.easing.1.3.js"></script>
    <script src="<?php echo base_url() ?>assets/psikotes/plugin/js/jquery.waypoints.min.js"></script>
    <script src="<?php echo base_url() ?>assets/psikotes/plugin/js/jquery.stellar.min.js"></script>
    <script src="<?php echo base_url() ?>assets/psikotes/plugin/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url() ?>assets/psikotes/plugin/js/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo base_url() ?>assets/psikotes/plugin/js/aos.js"></script>
    <script src="<?php echo base_url() ?>assets/psikotes/plugin/js/jquery.animateNumber.min.js"></script>
    <script src="<?php echo base_url() ?>assets/psikotes/plugin/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url() ?>assets/psikotes/plugin/js/jquery.timepicker.min.js"></script>
    <script src="<?php echo base_url() ?>assets/psikotes/plugin/js/scrollax.min.js"></script>

    <script src="<?php echo base_url() ?>assets/psikotes/plugin/js/main.js"></script>
    <script src="<?php echo base_url() ?>assets/psikotes/plugin/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo base_url('assets/psikotes/plugin/vendor/bootstrap-validator/js/bootstrapValidator.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/psikotes/plugin/vendor/bootstrap-select/js/bootstrap-select.js'); ?>"></script>

    <!-- DOM -->
    <script type="text/javascript">
        /*
         * Setup hidden colomn
         */
        const nik = document.querySelector('.NIK');
        const id = document.querySelector('.ID');
        const name = document.querySelector('.name');
        const bagian = document.querySelector('.bagian');
        const jabatan = document.querySelector('.jabatan');

        nik.style.display = 'none';
        id.style.display = 'none';
        bagian.style.display = 'none';
        jabatan.style.display = 'none';
        name.style.display = 'none';

        const status = document.querySelector("div.status select");
        status.addEventListener('change', function() {
            const materidtl = $('#materidtl_id').val();

            if (this.value == 1) {
                nik.style.display = 'block';
                id.style.display = 'none';
                name.style.display = 'block';
                bagian.style.display = 'block';
                jabatan.style.display = 'block';

                // $.ajax({
                //     type: "POST",
                //     url: `<?php echo site_url('TrainingOnline_v2/getKategoriMateri'); ?>`,
                //     data: {
                //         data: this.value,
                //         materidtl
                //     },
                //     dataType: "json",
                //     success: function (response) {
                //         if (response.status == true) {
                //             $('#idKategoriMateri').val(response.data[0].KategoriMateri);
                //             $('#materi_id').val(response.data[0].NamaMateri);
                //             $('#materidtl_id').val(response.data[0].IKPMateriDtl);
                //         } else {
                //             Swal.fire('Oops!', `Materi untuk Tenaga Kerja Belum ada ..!!`, `warning`).then((result) => {
                //                 window.location.reload();
                //             });
                //         }
                //     }
                // });

            } else if (this.value == 2) {
                id.style.display = 'block';
                nik.style.display = 'none';
                name.style.display = 'block';
                bagian.style.display = 'none';
                jabatan.style.display = 'none';

                // $.ajax({
                //     type: "POST",
                //     url: `<?php echo site_url('TrainingOnline_v2/getKategoriMateri'); ?>`,
                //     data: {data: this.value},
                //     dataType: "json",
                //     success: function (response) {
                //         if (response.status == true) {
                //             $('#idKategoriMateri').val(response.data[0].KategoriMateri);
                //             $('#materi_id').val(response.data[0].NamaMateri);
                //             $('#materidtl_id').val(response.data[0].IKPMateriDtl);
                //         } else {
                //             Swal.fire('Oops!', `Materi untuk Tenaga Kerja Belum ada ..!!`, `warning`).then((result) => {
                //                 window.location.reload();
                //             });
                //         }
                //     }
                // });


            } else {
                id.style.display = 'none';
                nik.style.display = 'none';
                name.style.display = 'none';
                bagian.style.display = 'none';
                jabatan.style.display = 'none';

                $('#idKategoriMateri').val('');
                $('#materi_id').val('');
                $('#materidtl_id').val('');
            }
        });

        const nkCard = document.querySelector('div.NIK input#nik');
        nkCard.addEventListener('change', function() {
            getPekerja();
        });

        const idCard = document.querySelector('div.ID input#id_register');
        idCard.addEventListener('change', function() {
            getPekerja();
        });

        /*
         * Setup Lokasi ruangan
         */
        const Locations = document.querySelector('div select#ruangan');
        const dtLocations = document.querySelector('div#ruangan_id');

        dtLocations.style.display = 'none';
        Locations.addEventListener('change', function() {
            if (this.value == 1) {
                dtLocations.style.display = 'none';
            } else if (this.value == 2) {
                dtLocations.style.display = 'none';
            } else if (this.value == 3) {
                dtLocations.style.display = 'block';
            } else {
                dtLocations.style.display = 'none';
            }
        });

        /*
         *  Setting hidden Frame Soal dan ttd.
         *  Sementara kita kasih display none dulu, karena belum pasti.
         *  kita kombinasi semua frame dengan button start.
         */

        const frameBtn = document.querySelector("div#startTest");

        // Using Date() method
        let d = Date();
        // Converting the number value to string
        a = d.toString();
        let dateNow = a.split(" ");

        let dateFilter = `${dateNow[1]} ${dateNow[2]}, ${dateNow[3]}`;

        let waktuPublish = $('#Tanggal').val();
        console.log('waktu p :', waktuPublish);
        console.log('dateFilter :', dateFilter);


        if (waktuPublish == dateFilter) {
            frameBtn.addEventListener('click', function(e) {
                e.preventDefault();
                let materi = $('#materidtl_id').val();
                let idKategory = $('#idKategoriMateri').val();
                let jenis_soal = $('#jenis_soal').val();
                let idHdrSoal = $('#txtHdrSoal').val();
                let jam = $('#waktuPublish').val();
                let jam_sekarang = $('#JamSekarang').val();
                let jam_akhir = $('#waktu').val();
                let nik_id = $('#nik').val().trim();
                let dept = $('#dept').val();
                let bagian = $('#bagianID').val();
                let ruangan = $('#ruangan').val();

                console.log('dept : ', dept);
                console.log('bagian : ', bagian);


                let nmRuangan = $('#nama_ruangan').val();

                let karyawanSt = $("#karyawanSt").val();
                let fixReg = $("#fixreg").val();
                let id_register = $('#id_register').val();
                let position = $('#position').val();
                let fixreg = $('#fixreg').val();

                if (nik_id != '') {
                    console.log('masukkkkk');

                    if (jam_sekarang >= jam) {
                        console.log('masukkkkk 2');
                        if (dept == bagian) {
                            console.log('masukkkkk 3');
                            if (ruangan != '') {
                                console.log('masukkkkk 4');
                                $.ajax({
                                    type: "POST",
                                    dataType: "html",
                                    url: `<?php echo site_url('TrainingOnline_v2/getDataSoal') ?>/${materi}/${idKategory}/${jenis_soal}/${idHdrSoal}/${nik_id}/${fixreg}`,
                                    success: function(msg) {
                                        console.log('iniiiii: ', msg);

                                        $('.frame_soal').html(msg);
                                        waktu_pengerjaan();
                                    },
                                    error: function(err) {
                                        console.log('err : ', err);
                                        Swal.fire('Oops!', `Terjadi kesalahan pada server..!!`, `error`).then((result) => {
                                            window.location.reload();
                                        });
                                    }
                                });
                            } else {
                                Swal.fire('HARAP ISI RUANGAN TERLEBIH DAHULU..!!', ``, `warning`).then((result) => {
                                    window.location.reload();
                                });
                            }
                        }
                    } else {
                        Swal.fire('HALAMAN INI TIDAK DAPAT DI AKSES', `Silahkan hubungi HRD untuk mengakses halaman ini..!!`, `warning`).then((result) => {
                            window.location.reload();
                        });
                    }
                } else if (id_register != '') {
                    if (jam_sekarang >= jam) {
                        if (dept == 13) {
                            if (ruangan != '') {
                                $.ajax({
                                    type: "POST",
                                    dataType: "html",
                                    url: `<?php echo site_url('TrainingOnline_v2/getDataSoal2/') ?>/${materi}/${position}/${jenis_soal}/${idHdrSoal}/${id_register}/${idKategory}`,
                                    success: function(msg) {
                                        $('.frame_soal').html(msg);
                                        waktu_pengerjaan();
                                    }
                                });
                            } else {
                                Swal.fire('HARAP ISI RUANGAN TERLEBIH DAHULU..!!', ``, `warning`).then((result) => {
                                    window.location.reload();
                                });
                            }
                        }
                    } else {
                        Swal.fire('HALAMAN INI TIDAK DAPAT DI AKSES', `Silahkan hubungi HRD untuk mengakses halaman ini..!!`, `warning`).then((result) => {
                            window.location.reload();
                        });
                    }

                } else {
                    Swal.fire('Oops!', `Kolom NIK / ID tidak boleh kosong..!!`, `warning`).then((result) => {
                        window.location.reload();
                    });
                }
            });
        }

        function waktu_pengerjaan() {
            let setting_waktu = $('#waktu').val();
            let tanggal = $('#Tanggal').val();

            // let tgl = tanggal + " " + setting_waktu;

            let tgl = `${tanggal} ${setting_waktu}`;

            let countDownDate = new Date(tgl).getTime();

            // // Update the count down every 1 second
            let x = setInterval(function() {

                // Get today's date and time
                let now = new Date().getTime();
                // Find the distance between now and the count down date
                let distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Output the result in an element with id="demo"
                document.getElementById("time").innerHTML = minutes + "m " + seconds + "s ";
                document.getElementById("times2").innerHTML = minutes + "m " + seconds + "s ";

                // If the count down is over, write some text 
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("time").innerHTML = "EXPIRED";
                    simpan();
                    Swal.fire('WAKTU HABIS', `Data akan tersimpan otomatis`, `success`).then((result) => {
                        window.location.reload();
                    });
                }
            }, 1000);
        }
    </script>
    <!-- jquery -->
    <script type="text/javascript">
        function getPekerja() {
            let nik = $('#nik').val();
            let dept = $('#dept').val();
            let dept_text = $('#dept').find('option:selected').text();
            let status_tk = $('.status').find('option:selected').val();
            let id_register = $('#id_register').val();

            if (status_tk == 1 && dept != '') {
                $.ajax({
                    type: "POST",
                    url: `<?php echo site_url('TrainingOnline_v2/getTenagaKerja'); ?>`,
                    data: {
                        nik,
                        dept
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status == true) {
                            console.log(response);

                            // console.log(response.data.RegnoFixno);
                            $('#bagian2').val(response.data.bagian);
                            // $('#fixreg').val(response.data.RegFixno);
                            $('#fixreg').val(response.data.RegnoFixno);
                            $('#idPerson').val(response.data.PersonID);
                            $('#karyawanSt').val(response.data.StatusPerson);
                            console.log('status st : ', response.data.StatusPerson);

                            $('#nama_lengkap').val(response.data.Nama);
                            $('#bag').val(response.data.DeptAbbr);
                            $('#bagianID').val(response.data.DeptID);
                            $('#jabatan').val(response.data.jabatan_nama);
                        } else {
                            Swal.fire('403', `Anda Tidak Terdaftar Sebagai Peserta...!!`, `warning`).then((result) => {
                                window.location.reload();
                            });
                        }
                    }
                });
            } else if (dept == 13) {
                $.ajax({
                    type: "POST",
                    url: `<?php echo site_url('TrainingOnline_v2/getCalonTk'); ?>`,
                    data: {
                        id_register,
                        dept_text
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status == true) {
                            $.each(response.data, function(index, value) {
                                let nameTkb = value.Nama;
                                $('#nama_lengkap').val(nameTkb);
                                $('#position').val(value.Transaksi);
                            });
                        } else {
                            Swal.fire('ID TIDAK TERDAFTAR', `untuk mengikuti PostTest/PreTest Training Online ..!!`, `warning`).then((result) => {
                                window.location.reload();
                            });
                        }
                    }
                });
            } else {
                Swal.fire('404', `Halaman ini tidak dapat di akses ..!!`, `warning`).then((result) => {
                    window.location.reload();
                });
            }
        }
    </script>
    <!-- State -->
    <script type="text/javascript">
        $('#sts_pekerja').change(function() {
            if (this.value == 1) {

                $('#nama_lengkap').val('');

            } else if (this.value == 2) {

                $('#nama_lengkap').val('');
                $('#bag').val('');
                $('#bagianID').val('');
                $('#jabatan').val('')
                $('#nik').val('');
                $('#fixreg').val('');
                $('#idPerson').val('');
                $('#karyawanSt').val('');
                $('#materi_id').text('');

            } else {
                window.location.reload();
            }
        });

        function simpan() {
            let jmlBaris = document.getElementsByClassName('txt').length;
            let nik_id = document.getElementById("nik");
            // console.log(nik_id.value);
            // return

            let karyawanSt = document.getElementById("karyawanSt");
            let idPerson = document.getElementById("idPerson");
            let dept = document.getElementById("dept");
            let bagianID = document.getElementById("bagianID");
            let jenis_soal = document.getElementById("jenis_soal");
            let materidtl_id = document.getElementById("materidtl_id");
            let ruangan = document.getElementById("ruangan");
            let txtHdrSoal = document.getElementById("txtHdrSoal");
            let hdrid_jawaban = document.getElementById("hdr_id_jawaban");
            let txtfixReg = document.getElementById("fixreg");
            let nama_lengkap = document.getElementById("nama_lengkap");
            let position = document.getElementById("jabatan");
            let status_tk = document.getElementById("sts_pekerja");
            let id_register = document.getElementById("id_register");

            let canvas = document.getElementById("can");
            let dataURL = canvas.toDataURL("image/png");
            let hidden_data = document.getElementById('hidden_data').value = dataURL;

            let data_jawaban = [];
            for (let i = 0; i <= jmlBaris; i++) {
                let soal_id = document.getElementById(`soal_id_${i}`);
                let jawaban = document.getElementsByClassName(`txtobjectif_${i}`);
                let detailid = document.getElementsByClassName(`detail_id_${i}`);
                for (let j = 0; j < jawaban.length; j++) {
                    if (jawaban[j].checked) {
                        data_jawaban.push({
                            "soal_id": soal_id.value,
                            "jawaban": jawaban[j].value,
                            "detailid": detailid[j].value
                        });
                    }

                }
            }
            if (nik_id.value != '') {
                $.ajax({
                    url: "<?php echo base_url(); ?>TrainingOnline_v2/simpan",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        "nik_id": nik_id.value,
                        "karyawanSt": karyawanSt.value,
                        "idPerson": idPerson.value,
                        "dept": dept.value,
                        "bagianID": bagianID.value,
                        "data_jawaban": data_jawaban,
                        "jenis_soal": jenis_soal.value,
                        "materidtl_id": materidtl_id.value,
                        "ruangan": ruangan.value,
                        "txtHdrSoal": txtHdrSoal.value,
                        "hdrid_jawaban": hdrid_jawaban.value,
                        "data_jawaban": data_jawaban,
                        "hidden_data": hidden_data,
                        "fixreg": txtfixReg.value,
                        "position": position.value,
                        "status_tk": status_tk.value
                    },
                    error: function() {
                        Swal.fire('Gagal', `Server tidak merespon`, `error`).then((result) => {
                            window.location.reload();
                        });
                    },
                    success: function(pesan) {
                        if (pesan > 0) {
                            Swal.fire('Berhasil', `Data Berhasil Disimpan`, `success`).then((result) => {
                                // Swal.fire('Success', `Terimakasih anda telah menjawab semua soal !!`, `success`).then((result) => {
                                //     window.location.reload();
                                // });
                                window.location.href = `<?php echo base_url() ?>TrainingOnline_v2`;
                                const url = `<?php echo base_url() ?>TrainingOnline_v2/lihat_hasil?hdrid=${hdrid_jawaban.value}&status=${karyawanSt.value}&fixregno=${fixreg.value}&nama=${nama_lengkap.value}&nik=${nik_id.value}&position=${position.value}&status_tk=${status_tk.value}&dept=${dept.value}`;
                                window.location.href = `${url}`;
                            });
                        } else if (pesan == "lebih3x") {
                            Swal.fire('Gagal', `Anda sudah melebihi batas maximal, Silahkan menghubungi pimpinan dept untuk melakukan Remedial.`, `error`).then((result) => {
                                window.location.reload();
                            });
                            // Swal.fire('Gagal', `Data gagal Disimpan NIK sudah input 3x`, `error`).then((result) => {
                            //     window.location.reload();
                            // });
                        } else if (pesan == "bedadept") {
                            Swal.fire('Gagal', `Mohon maaf anda tidak terdaftar di Dept`, `error`).then((result) => {
                                window.location.reload();
                            });
                        } else {
                            alert("GAGAL");
                        }
                    }
                });
            } else {
                $.ajax({
                    url: "<?php echo base_url(); ?>TrainingOnline_v2/simpan_nontk",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        "id_register": id_register.value,
                        "dept": dept.value,
                        "bagianID": bagianID.value,
                        "data_jawaban": data_jawaban,
                        "jenis_soal": jenis_soal.value,
                        "materidtl_id": materidtl_id.value,
                        "ruangan": ruangan.value,
                        "txtHdrSoal": txtHdrSoal.value,
                        "hdrid_jawaban": hdrid_jawaban.value,
                        "data_jawaban": data_jawaban,
                        "hidden_data": hidden_data,
                        "status_tk": status_tk.value
                    },
                    error: function() {
                        Swal.fire('Gagal', `Server tidak merespon`, `error`).then((result) => {
                            window.location.reload();
                        });
                    },
                    success: function(pesan) {
                        if (pesan > 0) {
                            Swal.fire('Berhasil', `Data Berhasil Disimpan`, `success`).then((result) => {
                                window.location.href = `<?php echo base_url() ?>TrainingOnline_v2/lihat_hasil_nonTK?hdrid=${hdrid_jawaban.value}&nama=${nama_lengkap.value}&id_register=${id_register.value}&status_tk=${status_tk.value}`;
                            });
                        } else if (pesan == "lebih3x") {
                            Swal.fire('Gagal', `Data gagal Disimpan NIK sudah input 1x`, `error`).then((result) => {
                                window.location.reload();
                            });
                        } else if (pesan == "bedadept") {
                            Swal.fire('Gagal', `Mohon maaf anda tidak terdaftar di Dept Electrical`, `error`).then((result) => {
                                window.location.reload();
                            });
                        }
                    }
                });
            }
        }

        function simpan_v2() {
            let jmlBaris = document.getElementsByClassName('txt').length;
            let nik_id = document.getElementById("nik_id");
            let karyawanSt = document.getElementById("karyawanSt");
            let idPerson = document.getElementById("idPerson");
            let dept = document.getElementById("dept");
            let bagianID = document.getElementById("bagianID");
            let jenis_soal = document.getElementById("jenis_soal");
            let materidtl_id = document.getElementById("materidtl_id");
            let ruangan = document.getElementById("ruangan");
            let txtHdrSoal = document.getElementById("txtHdrSoal");
            let hdrid_jawaban = document.getElementById("hdr_id_jawaban");
            let txtfixReg = document.getElementById("fixreg");
            let nama_lengkap = document.getElementById("nama_lengkap");
            let id_register = document.getElementById("id_register");

            let canvas = document.getElementById("can");
            let dataURL = canvas.toDataURL("image/png");
            let hidden_data = document.getElementById('hidden_data').value = dataURL;

            let data_jawaban = [];
            for (let i = 0; i <= jmlBaris; i++) {
                let soal_id = document.getElementById(`soal_id_${i}`);
                let jawaban = document.getElementsByClassName(`txtobjectif_${i}`);
                let detailid = document.getElementsByClassName(`detail_id_${i}`);
                for (let j = 0; j < jawaban.length; j++) {
                    if (jawaban[j].checked) {
                        data_jawaban.push({
                            "soal_id": soal_id.value,
                            "jawaban": jawaban[j].value,
                            "detailid": detailid[j].value
                        });
                    }
                }
            }
            $.ajax({
                url: "<?php echo base_url(); ?>TrainingOnline_v2/simpan_v2",
                type: "POST",
                dataType: "JSON",
                data: {
                    // "nik_id": nik_id.value,
                    "karyawanSt": karyawanSt.value,
                    "idPerson": idPerson.value,
                    "dept": dept.value,
                    "bagianID": bagianID.value,
                    "data_jawaban": data_jawaban,
                    "jenis_soal": jenis_soal.value,
                    "materidtl_id": materidtl_id.value,
                    "ruangan": ruangan.value,
                    "txtHdrSoal": txtHdrSoal.value,
                    "hdrid_jawaban": hdrid_jawaban.value,
                    "data_jawaban": data_jawaban,
                    "hidden_data": hidden_data,
                    "fixreg": txtfixReg.value,
                    "id_register": id_register.value
                },
                error: function() {
                    Swal.fire('Gagal', `Server tidak merespon`, `error`).then((result) => {
                        window.location.reload();
                    });
                },
                success: function(pesan) {
                    if (pesan > 0) {
                        Swal.fire('Berhasil', `Data Berhasil Disimpan`, `success`).then((result) => {
                            window.location.href = `<?php echo base_url() ?>TrainingOnline_v2/lihat_hasil_v2?hdrid=${hdrid_jawaban.value}&status=${karyawanSt.value}&fixregno=${fixreg.value}&nama=${nama_lengkap.value}#`;
                        });
                    } else if (pesan == "lebih3x") {
                        Swal.fire('Gagal', `Data gagal Disimpan NIK sudah input 3x`, `error`).then((result) => {
                            window.location.reload();
                        });
                    } else if (pesan == "bedadept") {
                        Swal.fire('Gagal', `Mohon maaf anda tidak terdaftar di Dept`, `error`).then((result) => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire('Gagal', `Terjadi kesalahan !!!`, `error`).then((result) => {
                            window.location.reload();
                        });
                        // alert("GAGAL");
                    }
                }
            });
        }
    </script>
</body>

</html>