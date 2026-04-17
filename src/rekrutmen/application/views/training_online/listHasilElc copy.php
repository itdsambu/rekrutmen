<!DOCTYPE html>
<html lang="en">

<head>
    <title>PostTest/PreTest Training Online</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel='shortcut icon' type='image icon' href="<?php echo base_url(); ?>assets/img/psg-logo.png" />

    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700" rel="stylesheet"> -->

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

    <link href="<?php echo base_url('assets/psikotes/myRepo/css/mystyle.css'); ?>" rel="stylesheet">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="">Post Test / Pre Test Training Online</a>
            <img class="navbar-toggler" src="<?php echo base_url(); ?>assets/img/psg-logo.png" alt="image icon" srcset="image icon" style="width: 50px; height: 50px;">

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <img src="<?php echo base_url(); ?>assets/img/psg-logo.png" alt="image icon" srcset="image icon" style="width: 50px; height: 50px;">
                    </li>
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
                            $sDept  = $dept->DeptAbbr;
                            echo "<span>Departmen :</span>";
                        } ?>
                        <h1 class="mb-4" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><?php echo $deptnm; ?></h1>
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
                    <?php foreach ($_getData as $get) {
                        $name         = $get->Nama;
                        $dept         = $get->DeptTraining;
                        $materi       = $get->NamaMateri;
                        $waktu        = $get->SettingWaktu . ' Menit ';
                        $NamaRuangan  = $get->NamaRuangan;

                        if ($get->JenisSoal == 1) {
                            $JenisSoal = 'Pre Test';
                        } else {
                            $JenisSoal = 'Post Test';
                        }

                        // $Lokasi       = $get->Lokasi;
                        if ($get->Lokasi == 1) {
                            $Lokasi = "Ruang Training Internal Departemen";
                        } else if ($get->Lokasi == 2) {
                            $Lokasi = "Ruang Training PSN";
                        } else if ($get->Lokasi == 3) {
                            $Lokasi = "Ditentukan Oleh Dept/Bagian Masing-Masing";
                        }
                    } ?>
                    <form id="data_diri" class="appointment-form">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <?php if ($status_tk == 1) {
                                        $tkNya = 'Tenaga Kerja';
                                    } else if ($status_tk == 2) {
                                        $tkNya = 'Non Tenaga Kerja';
                                    } ?>
                                    <div class="icon"><span class="icon-paper-plane"></span></div>
                                    <input type="text" class="form-control" placeholder="Status Pekerja" name="txtStatus" id="sts_pekerja" value="<?= $tkNya; ?>" disabled />
                                    <!-- <input type="text" class="form-control" placeholder="Status Pekerja" name="txtStatus" id="sts_pekerja" disabled/> -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php if ($nik != '') { ?>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="icon"><span class="icon-id-card"></span></div>
                                        <input type="text" class="form-control" placeholder="Nik" name="txtNik" id="nik" value="<?php echo $nik; ?>" disabled />
                                    </div>
                                </div>
                            <?php
                            } else { ?>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="icon"><span class="icon-id-card"></span></div>
                                        <input type="text" class="form-control" placeholder="Input ID" name="txtId" id="id_register" value="<?php echo $id_register; ?>" disabled />
                                    </div>
                                </div>
                            <?php
                            } ?>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="icon"><span class="icon-user"></span></div>
                                    <input type="text" class="form-control" placeholder="Nama Lengkap" name="txtxtNama" id="nama_lengkap" value="<?php echo $nama; ?>" disabled />
                                </div>
                            </div>
                        </div>
                        <?php if ($position != '') { ?>
                            <div class="row">
                                <div class="col-sm-6 bagian">
                                    <div class="form-group">
                                        <div class="icon"><span class="icon-work"></span></div>
                                        <input type="text" class="form-control" placeholder="Bagian" name="txtBagian" id="bag" value="<?php echo $dept; ?>" disabled>
                                        <input type="hidden" class="form-control" placeholder="Bagian Auto" name="txtBagianID" id="bagianID" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-6 jabatan">
                                    <div class="form-group">
                                        <div class="icon"><span class="icon-work"></span></div>
                                        <input type="text" class="form-control" placeholder="Jabatan" name="txtJabatan" id="jabatan" value="<?php echo $position; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        <?php
                        } ?>
                    </form>
                </div>
                <!-- KRITERIA SOAL  -->
                <div class="col-md-6 color-3 p-4">
                    <h3 class="mb-2">KRITERIA SOAL</h3>
                    <hr>
                    <form id="frm_soal" class="appointment-form">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="icon"><span class="icon-home"></span></div>
                                    <input type="text" class="form-control" placeholder="Departemen" name="txtDept" id="dept" value="<?= $dept; ?>" disabled />
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="icon"><span class="icon-link"></span></div>
                                    <input type="text" class="form-control" placeholder="Jenis Soal" name="txtJenisSoal" id="jenis_soal" value="<?= $JenisSoal; ?>" disabled />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="icon"><span class="icon-book"></span></div>
                                    <input type="text" class="form-control" placeholder="Materi" value="<?= $materi; ?>" disabled />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="icon"><span class="icon-paper-plane"></span></div>
                                    <input type="text" class="form-control" placeholder="Ruangan/Lokasi" value="<?= $Lokasi; ?>" disabled />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <?php if ($NamaRuangan != '') { ?>
                                <div class="col-sm-6" style="display: block;">
                                    <div class="form-group">
                                        <div class="icon"><span class="icon-home"></span></div>
                                        <input type="text" class="form-control" placeholder="Ruangan" value="<?= $NamaRuangan ?>" disabled />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="icon"><span class="icon-alarm"></span></div>
                                        <input type="text" class="form-control" placeholder="Waktu Pengerjaan" value="<?= $waktu; ?>" disabled />
                                    </div>
                                </div>
                            <?php
                            } else { ?>
                                <div class="col-sm-6" style="display: none;">
                                    <div class="form-group">
                                        <div class="icon"><span class="icon-home"></span></div>
                                        <input type="text" class="form-control" placeholder="Ruangan" disabled />
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="icon"><span class="icon-alarm"></span></div>
                                        <input type="text" class="form-control" placeholder="Waktu Pengerjaan" value="<?= $waktu; ?>" disabled />
                                    </div>
                                </div>
                            <?php
                            } ?>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <!-- Lembar Soal & Tanda tangan -->
    <section class="ftco-section">
        <div class="container frame_soal">
            <div class="alert alert-primary">
                <h2 class="mt-0 header-title"><b>
                        <center>JAWABAN ANDA</center>
                    </b></h2>
            </div>
            <h6 class="mt-0 header-title dagdigdug"><b> Pilihlah salah satu jawaban yang paling benar. </b></h6>
            <hr>
            <br>
            <div class="col-md-12 text-center heading-section">
                <?php $no = 1;
                foreach ($_getSoal as $row) { ?>
                    <h2 class="mb-3 text-left pertayaan">
                        <?php echo $no++ . '. ' . $row->Soal; ?> &nbsp;
                        <?php if ($row->Link == NULL) {
                            echo "";
                        } else {
                            $s = 1;
                            if ($jenis_soal == 1) { ?>
                                <div class="">
                                    <img src="<?php echo base_url('assets/ttdtraining/GambarSoal/PreTest/' . $row->ID . '.JPG'); ?>" class="img-fluid d-block mx-auto" alt="Responsive image" style="width: 500px;height: 300px;">
                                </div>
                            <?php
                            } else { ?>
                                <div>
                                    <img src="<?php echo base_url('assets/ttdtraining/GambarSoal/PostTest/' . $row->ID . '.JPG'); ?>" style="width: 500px;height: auto;">
                                </div>
                        <?php
                            }
                        } ?>
                    </h2>
                    <hr>

                    <!-- <input type="hidden" name="txtSoal" id="soal_id_<?= $jb; ?>" value="<?php echo $row->IDSoal; ?>" class="txt form-control"> -->
                    <input type="hidden" name="txtHdrSoal" id="hdr_soal_id_" value="<?php echo $row->IdMstSoalHdr; ?>" class="txt form-control">
                    <input type="hidden" name="txtHdrJawaban" id="hdr_id_jawaban" value="<?php echo $hdrid; ?>" class="txt form-control">

                    <?php
                    $this->load->model("M_TrainingOnline");
                    $jawaban = $this->M_TrainingOnline->_getJawaban($row->IDSoal);
                    $jawaban_benar = $this->M_TrainingOnline->_getJawabanBenar($hdrid);
                    // print_r($jawaban_benar);
                    // die;
                    foreach ($jawaban_benar as $jb) {
                        if ($jb->IDSoal == $row->IDSoal) {
                            foreach ($jawaban as $key) {
                                if ($key->IDSoal == $row->IDSoal) { ?>
                                    <label class='container text-left'>
                                        <?php if ($key->IDObjectif == $jb->IDBenar) {
                                            if ($jb->Benar == 1) { ?>
                                                <input type="radio" id="objectif_di<?php echo $key->IDSoal; ?>" name="objectif<?php echo $key->IDSoal ?>" class="md-radiobtn" value="<?php echo $key->IDObjectif; ?>" checked>
                                                <input type="hidden" name="txtDetailID" id="detailid" class="form-control" value="<?php echo $row->DetailID ?>">
                                                <span class='checkmark'></span>
                                                <span style="color: lightgreen;">
                                                    <?php if ($key->Link == NULL) {
                                                        echo $key->Objectif;
                                                    } else {
                                                        if ($jenis_soal == 1) { ?>
                                                            <img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PreTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br>
                                                        <?php
                                                        } else { ?>
                                                            <img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PostTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br><br>
                                                    <?php
                                                        }
                                                    } ?>
                                                </span>
                                                <span class="icon-check"></span>
                                            <?php
                                            } else { ?>
                                                <input type="radio" id="objectif_id<?php echo $key->IDSoal; ?>" name="objectif<?php echo $key->IDSoal ?>" class="md-radiobtn txtobjectif_<?= $jb; ?>" value="<?php echo $key->IDObjectif; ?>" disabled>
                                                <!-- <input type="hidden" name="txtDetailID" id="detailid" class="form-control detail_id_<?= $jb; ?>" value="<?php echo $row->DetailID ?>"> -->
                                                <span class='checkmark'></span>
                                                <span style="color: lightgreen;">
                                                    <?php if ($key->Link == NULL) {
                                                        echo $key->Objectif;
                                                    } else {
                                                        if ($jenis_soal == 1) { ?>
                                                            <img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PreTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br>
                                                        <?php
                                                        } else { ?>
                                                            <img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PostTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br><br>
                                                    <?php
                                                        }
                                                    } ?>
                                                </span>
                                                <span class="icon-check"></span>
                                            <?php
                                            }
                                        } elseif ($key->IDObjectif == $jb->IDObjectif) {
                                            if ($jb->Benar == 0) { ?>
                                                <input type="radio" id="objectif_id<?php echo $key->IDSoal; ?>" name="objectif<?php echo $key->IDSoal ?>" class="md-radiobtn" value="<?php echo $key->IDObjectif; ?>" checked>
                                                <!-- <input type="hidden" name="txtDetailID" id="detailid" class="form-control detail_id_<?= $jb; ?>" value="<?php echo $row->DetailID ?>"> -->
                                                <span class='checkmark'></span>
                                                <span style="color: red;">
                                                    <?php if ($key->Link == NULL) {
                                                        echo $key->Objectif;
                                                    } else {
                                                        if ($jenis_soal == 1) { ?>
                                                            <img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PreTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br>
                                                        <?php
                                                        } else { ?>
                                                            <img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PostTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br><br>
                                                    <?php
                                                        }
                                                    } ?>
                                                </span>
                                                <span class="icon-close"></span>
                                            <?php
                                            } else { ?>
                                                <input type="radio" id="objectif_id<?php echo $key->IDSoal; ?>" name="objectif<?php echo $key->IDSoal ?>" class="md-radiobtn" value="<?php echo $key->IDObjectif; ?>">
                                                <input type="hidden" name="txtDetailID" id="detailid" class="form-control detail_id_<?= $jb; ?>" value="<?php echo $row->DetailID ?>">
                                                <span class='checkmark'></span>
                                                <?php if ($key->Link == NULL) {
                                                    echo $key->Objectif;
                                                } else {
                                                    if ($jenis_soal == 1) { ?>
                                                        <img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PreTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br>
                                                    <?php
                                                    } else { ?>
                                                        <img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PostTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br><br>
                                                <?php
                                                    }
                                                } ?>
                                                <span class="icon-check"></span>
                                            <?php
                                            }
                                        } else { ?>
                                            <input type="radio" id="objectif_id<?php echo $key->IDSoal; ?>" name="objectif<?php echo $key->IDSoal ?>" class="md-radiobtn txtobjectif_<?= $jb; ?>" value="<?php echo $key->IDObjectif; ?>" disabled>
                                            <input type="hidden" name="txtDetailID" id="detailid" class="form-control detail_id_<?= $jb; ?>" value="<?php echo $row->DetailID ?>">
                                            <span class='checkmark'></span>
                                            <?php if ($key->Link == NULL) {
                                                echo $key->Objectif;
                                            } else {
                                                if ($jenis_soal == 1) { ?>
                                                    <img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PreTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br>
                                                <?php
                                                } else { ?>
                                                    <img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PostTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br><br>
                                            <?php
                                                }
                                            } ?>
                                        <?php
                                        } ?>
                                    </label>
                <?php
                                }
                            }
                        }
                    }
                } ?>
            </div>
            <br>

            <div class="row ttd_view">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="alert alert-primary">
                                        <h4 class="mt-0 header-title"><b>
                                                <center>Dibuat Oleh,</center>
                                            </b></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" border="6">
                                            <thead style="text-align: center;" class="bg-gradient-light">
                                                <!-- <tr>
                                                        <th class="align-middle text-center" rowspan="1" colspan="2"></th>
                                                    </tr> -->
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: center;" colspan="2">
                                                        <?php if ($status == 1) { ?>
                                                            <img src="<?php echo base_url('assets/ttdtraining/Regno/' . $fixregno . '.png'); ?>" style="width:200px; height:150px; background-size:100%; border: 1px;" alt=""><br>
                                                        <?php
                                                        } else if ($status == 2) { ?>
                                                            <img src="<?php echo base_url('assets/ttdtraining/Fixno/' . $fixregno . '.png'); ?>" style="width:200px; height:150px; background-size:100%; border: 1px;" alt=""><br>
                                                        <?php
                                                        } else { ?>
                                                            <img src="<?php echo base_url('assets/ttdtraining/NonTK/' . $id_register . '.png'); ?>" style="width:200px; height:150px; background-size:100%; border: 1px;" alt=""><br>
                                                        <?php
                                                        } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left">Nama</td>
                                                    <td style="text-align: left"> <?= $nama; ?></td>
                                                </tr>
                                            </tbody>
                                            <!-- <tfoot>
                                                    <tr class="bg-gradient-light">
                                                        <th colspan="6"></th>
                                                    </tr>
                                                </tfoot> -->
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <footer class="ftco-footer ftco-bg-dark ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    &copy; PT Pulau Sambu Guntung - <script>
                        document.write(new Date().getFullYear());
                    </script>
                </div>
            </div>
        </div>
    </footer>

    <!-- Javascript -->
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
    <!-- End Javascript -->
    <script>
        const h2 = document.getElementsByClassName('pertayaan');
        for (let index = 0; index < h2.length; index++) {
            h2[index].style.fontSize = "large";
        }
    </script>
</body>

</html>