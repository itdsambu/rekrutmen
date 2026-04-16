<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/select2.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dp/smoothness.datepick.css" />

<!--<script src="<?php echo base_url(); ?>assets/dp/jquery-1.10.2.js"></script>-->
<script src="<?php echo base_url(); ?>assets/dp/jquery.datepick.js"></script>
<script src="<?php echo base_url(); ?>assets/dp/jquery.plugin.js"></script>

<!-- page specific plugin scripts -->
<script src="<?php echo base_url(); ?>assets/js/fuelux/fuelux.wizard.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/additional-methods.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootbox.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.maskedinput.js"></script>
<script src="<?php echo base_url(); ?>assets/js/select2.js"></script>


<script type="text/javascript">
    jQuery(function($) {
        $.mask.definitions['~'] = '[+-]';
        //	$('#inputNoPonsel').mask('099999999999');
        $('#inputTahunMasuk').mask('9999');
        $('#inputTahunLulus').mask('9999');
        $('#inputIPK').mask('9.99');

        jQuery.validator.addMethod("phone", function(value, element) {
            return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{4}( x\d{1,6})?$/.test(value);
        }, "Enter a valid phone number.");

        $('#formUpdateData').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",

            rules: {
                txtNama: {
                    required: true
                },
                txtNoKTP: {
                    required: true,
                    number: true
                },
                txtTahunMasuk: {
                    number: true
                },
                txtTahunLulus: {
                    number: true
                },
                txtSuku: {
                    required: true
                },
                txtStatus: {
                    required: true
                },
                txtAgama: {
                    required: true
                },
                txtPendidikan: {
                    required: true
                },
                txtKeadaanFisik: {
                    required: true
                },
                txtPerusahaan: {
                    required: true
                },
                txtIPK: {
                    number: true
                },
                txtNilai: {
                    number: true
                },
                txtAhliWaris: {
                    required: true
                },
                txtJekelAhliWaris: {
                    required: true
                },
                txtAlamatAhliWaris: {
                    required: true
                },
                txtHubunganAhliWaris: {
                    required: true
                },
                txtnohpAhliWaris: {
                    required: true
                }
            },

            messages: {
                txtNama: {
                    required: "Harap input Nama Lengkap!",
                    pattern: "Harap input dengan Huruf Alfabet (a-z A-Z)"
                },
                txtNoKTP: {
                    required: "Harap input NIK!",
                    number: "Value harus Numeric (0-9)"
                },
                txtTahunMasuk: {
                    required: "Harap input Tahun Anda Masuk!",
                    number: "Value harus Numeric (0-9)"
                },
                txtTahunLulus: {
                    required: "Harap input Tahun Amda Lulus!",
                    number: "Value harus Numeric (0-9)"
                },
                txtIPK: {
                    number: "Value harus Numeric (0-9)"
                },
                txtNilai: {
                    number: "Value harus Numeric (0-9)"
                },
                txtJumlahSaudara: "Harap Diisi",
                txtAnakKe: "Harap Diisi",
                txtPerusahaan: "Silahkan Pilih Perusahaan/CV",
                txtAlamat: "Harap input Alamat Anda!",
                txtTinggalDengan: "Harap input Anda Tinggal dengan Siapa!",
                txtHubungan: "Harap input hubungan dengan Calon Pelamar!",
                txtNoPonsel: "Harap input Nomor Handphone Anda!",
                txtTempatLahir: "Harap input Tempat Lahir Anda!",
                txtTanggalLahir: "Harap input Tanggal Lahir Anda!",
                txtJekel: "Harap Pilih Jenis Kelamin!",
                txtSuku: "Harap Pilih Suku Anda!",
                txtDaerahAsal: "Harap Input Asal Daerah Anda!",
                txtAgama: "Harap Pilih Agama Anda!",
                txtStatus: "Harap Pilih Status Perkawinan Anda!",
                txtNamaBapak: "Harap Input Nama Bapak Anda!",
                txtNamaIbu: "Harap Input Nama Ibu Anda!",
                txtPekerjaanOrtu: "Harap Input Pekerjaan Orang Tua Anda!",
                txtPendidikan: "Harap Pilih Pendidikan Terakhir Anda!",
                txtPernahRSUP: "Harap Pilih !",
                txtAdaKeluarga: "Harap Pilih !",
                txtKeadaanFisik: "Harap Pilih Keadaan Fisik Anda!",
                txtAlamatKerabat: 'Harap isi alamat kerabat terdekat',
                txtAhliWaris: 'Harap isi data ahli waris',
                txtJekelAhliWaris: 'Harap isi data ahli waris',
                txtAlamatAhliWaris: 'Harap isi data ahli waris',
                txtHubunganAhliWaris: 'Harap isi data ahli waris',
                txtnohpAhliWaris: 'Harap isi data ahli waris'

            },


            highlight: function(e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },

            success: function(e) {
                $(e).closest('.form-group').removeClass('has-error'); //.addClass('has-info');
                $(e).remove();
            },

            errorPlacement: function(error, element) {
                if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                    var controls = element.closest('div[class*="col-"]');
                    if (controls.find(':checkbox,:radio').length > 1) controls.append(error);
                    else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
                } else if (element.is('.select2')) {
                    error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
                } else if (element.is('.chosen-select')) {
                    error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                } else error.insertAfter(element.parent());
            }

            //                submitHandler: function (form) {
            //                },
            //                invalidHandler: function (form) {
            //                }
        });
    });
</script>

<div class="page-header">
    <h1>
        Verifikasi
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Perubahan Data
        </small>
    </h1>
</div><!-- /.page-header -->
<?php foreach ($_getData as $row) :
    // $_SESSION['Pemborong']      = ucwords(strtolower($row->Pemborong));
    // $_SESSION['namaTK']         = ucwords(strtolower($row->Nama));
    // $_SESSION['No_Ktp']         = ucwords(strtolower($row->No_Ktp));
    // $_SESSION['No_KK']          = ucwords(strtolower($row->No_KK));
    // $_SESSION['Tempat_Lahir']   = ucwords(strtolower($row->Tempat_Lahir));
    // $_SESSION['Tgl_Lahir']      = ucwords(strtolower($row->Tgl_Lahir));
    // $_SESSION['NamaBapak']      = ucwords(strtolower($row->NamaBapak));
    // $_SESSION['NamaIbuKandung'] = ucwords(strtolower($row->NamaIbuKandung));
?>

    <div class="row">
        <div class="col-xs-12">
            <?php
            if ($this->input->get('msg') == 'UpdateAnakOK') {
                echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                    <i class='ace-icon fa fa-times'></i></button>Pembaruan Data Anak Sukses!</p>";
            } else if ($this->input->get('msg') == 'UpdateKelOK') {
                echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                    <i class='ace-icon fa fa-times'></i></button>Pembaruan Data Keluarga Sukses!</p>";
            } else if ($this->input->get('msg') == 'Success') {
                echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                    <i class='ace-icon fa fa-times'></i></button>Pembaruan Data Calon Tenaga Kerja Sukses!</p>";
            }
            ?>

            <form id="formUpdateData" class="form-horizontal" role="form" method="POST" action="<?php echo site_url('ubahDataKaryawan/updateData'); ?>">
                <input name="txtHeaderID" type="hidden" value="<?php echo $row->HeaderID; ?>" readonly="" />
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title green"><i class="ace-icon fa fa-bookmark bigger-140"></i> Tujuan Lamaran</h4>
                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="inputPerusahaan"> Perusahaan/CV Sebelumnya </label>
                                <div class="col-sm-9">
                                    <input type="text" id="inputPerusahaanOld" name="txtPerusahaanOld" class="col-xs-10 col-sm-5" value="<?php echo $row->CVNama; ?>" readonly="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="inputPemborong"> Pemborong Sebelumnya </label>
                                <div class="col-sm-9">
                                    <input type="text" id="inputPemborongOld" name="txtPemborongOld" class="col-xs-10 col-sm-5" value="<?php echo $row->Pemborong; ?>" readonly="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="form-field-1"> Perusahaan/ CV </label>
                                <div class="col-sm-9">
                                    <select class="col-xs-10 col-sm-5" name="txtPerusahaan" id="inputPerusahaan">
                                        <option value=""> -- Silahkan Pilih Perusahaan</option>
                                        <?php foreach ($_getPSGPemborong as $rowCV) : ?>
                                            <?php if ($row->CVNama == $rowCV->Perusahaan) : ?>
                                                <option value='<?php echo $rowCV->Perusahaan; ?>' selected="TRUE"><?php echo $rowCV->Perusahaan; ?></option>
                                            <?php else : ?>
                                                <option value='<?php echo $rowCV->Perusahaan; ?>'><?php echo $rowCV->Perusahaan; ?></option>
                                            <?php endif; ?>

                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Pemborong </label>
                                <div class="col-sm-9">
                                    <div id="pt">
                                        <input type="text" id="inputPemborong" name="txtPemborong" placeholder="Pemborong Auto Value" value="<?php echo $row->Pemborong; ?>" class="col-xs-10 col-sm-5" readonly="" required="" />
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                $("#inputPerusahaan").change(function() {
                                    var selectValues = $("#inputPerusahaan").val();
                                    if (selectValues === 0) {
                                        var msg = "<input class=\"form-control\" name=\"txtPemborong\" id=\"inputPemborong\" placeholder=\"Nama Perusahaan\" type=\"text\" value='' readonly />";
                                        $('#pt').html(msg);
                                    } else {
                                        var pemborong = {
                                            pemborong: $("#inputPerusahaan").val()
                                        };
                                        //												$('#inputPerusahaan').attr("disabled",true);
                                        $.ajax({
                                            type: "POST",
                                            url: "<?php echo site_url('ubahDataKaryawan/selectPemborong') ?>",
                                            data: pemborong,
                                            success: function(msg) {
                                                $('#pt').html(msg);
                                            }
                                        });
                                    }
                                });

                                $("#inputPerusahaan").change(function() {
                                    var selectValues = $("#inputPerusahaan").val();
                                    if (selectValues === 0) {
                                        var msg = "<input class=\"form-control\" name=\"txtSubPemborong\" id=\"inputSubPemborong\" placeholder=\"Nama Perusahaan\" type=\"text\" value='' readonly />";
                                        $('#pt').html(msg);
                                    } else {
                                        var subpemborong = {
                                            subpemborong: $("#inputPerusahaan").val()
                                        };
                                        //                                              $('#inputPerusahaan').attr("disabled",true);
                                        $.ajax({
                                            type: "POST",
                                            url: "<?php echo site_url('registrasi/selectSubPemborong') ?>",
                                            data: subpemborong,
                                            success: function(msg) {
                                                $('#subpt').html(msg);
                                            }
                                        });
                                    }
                                });
                            </script>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Sub Pemborong </label>
                                <div class="col-sm-9">
                                    <div id="subpt">
                                        <select class="form-control" name="txtSubPemborong" id="inputSubPemborong">
                                            <?php foreach ($_getSubPemborong as $sp) { ?>
                                                <option value="<?= $sp->NamaSubPemborong . ',' . $sp->SubPemborongID ?>" <?= $row->IDSubPemborong == $sp->SubPemborongID ? 'selected' : '' ?>><?= $sp->NamaSubPemborong ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12">
                    <h4 class="header smaller lighter green">
                        <i class="ace-icon fa fa-user bigger-140"></i>
                        Data Pribadi
                    </h4>
                </div>
                <?php if ($this->session->userdata('dept') == 'HRD') { ?>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="inputNamaLengkap"> Nama Lengkap </label>
                            <div class="col-sm-10">
                                <input type="text" id="inputNamaLengkap" name="txtNamalengkap" class="col-xs-10" value="<?php echo ucwords(strtolower($row->Nama)); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="inputNoKTP"> NO.KTP </label>
                            <div class="col-sm-10">
                                <input type="text" id="inputNoKTP" name="txtNoKTP" class="col-xs-10" value="<?php echo $row->No_Ktp; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="inputNoKK"> NO.KK </label>
                            <div class="col-sm-10">
                                <input type="text" id="inputNoKK" name="txtNoKK" class="col-xs-10" value="<?php echo $row->No_KK; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="col-sm-2 control-label no-padding-right" for="inputAlamat"> Alamat Sesuai e-KTP </small>
                            <div class="col-sm-10">
                                <textarea type="text" id="inputAlamatKTP" name="txtAlamatKTP" class="col-xs-10"><?php echo ucwords(strtolower($row->Alamat_KTP)); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="inputAlamat"> Alamat Sekarang </label>
                            <div class="col-sm-10">
                                <textarea type="text" id="inputAlamat" name="txtAlamat" class="col-xs-10"><?php echo ucwords(strtolower($row->Alamat)); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="inputRT"> RT </label>
                            <div class="col-sm-2">
                                <input type="text" id="inputRT" name="txtRT" class="col-xs-12" value="<?php echo $row->RT; ?>">
                            </div>
                            <label class="col-sm-1 control-label no-padding-right" for="inputRW"> RW </label>
                            <div class="col-sm-2">
                                <input type="text" id="inputRW" name="txtRW" class="col-xs-12" value="<?php echo $row->RW; ?>">
                            </div>
                            <label class="col-sm-1 control-label no-padding-right" for="inputKelurahan" style="font-size: 13px">Kelurahan*</label>
                            <div class="col-sm-2">
                                <input type="text" id="inputKelurahan" name="txtKelurahan" class="col-xs-12" value="<?php echo $row->Kelurahan; ?>" onkeypress="return /[a-zA-Z ]/i.test(event.key)" required>
                            </div>
                        </div>
                        <script>
                            $(document).on('keyup', '#inputKelurahan', function() {
                                var val = $(this).val();
                                if (val.trim() == '') {
                                    $(this).val('');
                                    $(this).focus();
                                }
                            });
                        </script>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="inputTempatLahir"> Tempat Lahir </label>
                            <div class="col-sm-10">
                                <input type="text" id="inputTempatLahir" name="txtTempatLahir" class="col-xs-10" value="<?php echo ucwords(strtolower($row->Tempat_Lahir)); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="inputTanggalLahir"> Tanggal Lahir </label>
                            <div class="col-sm-10">
                                <?php

                                ?>
                                <input type="text" id="inputTanggalLahir" name="txtTanggalLahir" class="col-xs-10" value="<?php echo date("d-m-Y", strtotime($row->Tgl_Lahir)); ?>">
                            </div>
                        </div>
                        <script>
                            $(function() {
                                $('#inputTanggalLahir').datepick({
                                    minDate: '-60Y',
                                    maxDate: '-18Y',
                                    dateFormat: 'dd-mm-yyyy'
                                });
                            });
                        </script>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="inputJekel"> Jenis Kelamin </label>
                            <div class="col-sm-10">
                                <?php
                                if ($row->Jenis_Kelamin == 'LAKI-LAKI') {
                                    $jM = "checked";
                                    $jF = "";
                                } else {
                                    $jM = "";
                                    $jF = "checked";
                                }
                                ?>
                                <div class="radio">
                                    <label>
                                        <input id="inputJekel" name="txtJekel" type="radio" class="ace" value="LAKI-LAKI" <?php echo $jM; ?>>
                                        <span class="lbl"> Laki-laki</span>
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input id="inputJekel" name="txtJekel" type="radio" class="ace" value="PEREMPUAN" <?php echo $jF; ?>>
                                        <span class="lbl"> Perempuan</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="inputNoPonsel"> Nomor Ponsel </label>
                            <div class="col-sm-10">
                                <input type="text" id="inputNoPonsel" name="txtNoPonsel" class="col-xs-10" value="<?php echo $row->NoHP; ?>">
                            </div>
                        </div>

                        <?php $this->load->view('registrasi/template/addkerabat'); ?>

                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="inputTinggalDengan"> Tinggal dengan </label>
                            <div class="col-sm-10">
                                <input type="text" id="inputTinggalDengan" name="txtTinggalDengan" class="col-xs-10" value="<?php echo $row->TinggalDengan; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="inputHubungan"> <small>Hubungan dengan Pelamar</small> </label>
                            <div class="col-sm-10">
                                <input type="text" id="inputHubungan" name="txtHubungan" class="col-xs-10" value="<?php echo $row->HubunganDenganTK; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="inputTinggiBadan"> Tinggi Badan </label>
                            <div class="col-sm-10">
                                <input type="text" id="inputTinggiBadan" name="txtTinggiBadan" class="col-xs-10" value="<?php echo $row->TinggiBadan; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="inputBeratBadan"> Berat Badan </label>
                            <div class="col-sm-10">
                                <input type="text" id="inputBeratBadan" name="txtBeratBadan" class="col-xs-10" value="<?php echo $row->BeratBadan; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="inputSuku"> Suku </label>
                            <div class="col-sm-10">
                                <select id="inputSuku" name="txtSuku" class="col-xs-10">
                                    <option value="">-- Pilih Suku</option>
                                    <?php foreach ($_getSuku as $rowSuku) : ?>
                                        <?php if ($row->Suku == $rowSuku->Suku) : ?>
                                            <option value="<?php echo $rowSuku->Suku; ?>" selected=""> <?php echo $rowSuku->Suku; ?> </option>
                                        <?php else : ?>
                                            <option value="<?php echo $rowSuku->Suku; ?>"> <?php echo $rowSuku->Suku; ?> </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="inputDaerahAsal"> Daerah Asal </label>
                            <div class="col-sm-10">
                                <input type="text" id="inputDaerahAsal" name="txtDaerahAsal" class="col-xs-10" value="<?php echo ucwords(strtolower($row->Daerah_Asal)); ?>">
                            </div>
                        </div>
                    <?php
                } else { ?>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputNamaLengkap"> Nama Lengkap </label>
                                <div class="col-sm-10">
                                    <input type="text" id="inputNamaLengkap" name="txtNamalengkap" class="col-xs-10" value="<?php echo ucwords(strtolower($row->Nama)); ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputNoKTP"> NO.KTP </label>
                                <div class="col-sm-10">
                                    <input type="text" id="inputNoKTP" name="txtNoKTP" class="col-xs-10" value="<?php echo $row->No_Ktp; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputNoKK"> NO.KK </label>
                                <div class="col-sm-10">
                                    <input type="text" id="inputNoKK" name="txtNoKK" class="col-xs-10" value="<?php echo $row->No_KK; ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <small class="col-sm-2 control-label no-padding-right" for="inputAlamat"> Alamat Sesuai e-KTP </small>
                                <div class="col-sm-10">
                                    <textarea type="text" id="inputAlamatKTP" name="txtAlamatKTP" class="col-xs-10"><?php echo ucwords(strtolower($row->Alamat_KTP)); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputAlamat"> Alamat Sekarang </label>
                                <div class="col-sm-10">
                                    <textarea type="text" id="inputAlamat" name="txtAlamat" class="col-xs-10"><?php echo ucwords(strtolower($row->Alamat)); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputRT"> RT </label>
                                <div class="col-sm-2">
                                    <input type="text" id="inputRT" name="txtRT" class="col-xs-12" value="<?php echo $row->RT; ?>">
                                </div>
                                <label class="col-sm-1 control-label no-padding-right" for="inputRW"> RW </label>
                                <div class="col-sm-2">
                                    <input type="text" id="inputRW" name="txtRW" class="col-xs-12" value="<?php echo $row->RW; ?>">
                                </div>
                                <label class="col-sm-1 control-label no-padding-right" for="inputKelurahan" style="font-size: 13px">Kelurahan*</label>
                                <div class="col-sm-2">
                                    <input type="text" id="inputKelurahan" name="txtKelurahan" class="col-xs-12" value="<?php echo $row->Kelurahan; ?>" onkeypress="return /[a-zA-Z ]/i.test(event.key)" required>
                                </div>
                            </div>
                            <script>
                                $(document).on('keyup', '#inputKelurahan', function() {
                                    var val = $(this).val();
                                    if (val.trim() == '') {
                                        $(this).val('');
                                        $(this).focus();
                                    }
                                });
                            </script>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputTempatLahir"> Tempat Lahir </label>
                                <div class="col-sm-10">
                                    <input type="text" id="inputTempatLahir" name="txtTempatLahir" class="col-xs-10" value="<?php echo ucwords(strtolower($row->Tempat_Lahir)); ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputTanggalLahir"> Tanggal Lahir </label>
                                <div class="col-sm-10">
                                    <?php

                                    ?>
                                    <input type="text" id="inputTanggalLahir" name="txtTanggalLahir" class="col-xs-10" value="<?php echo date("d-m-Y", strtotime($row->Tgl_Lahir)); ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputJekel"> Jenis Kelamin </label>
                                <div class="col-sm-10">
                                    <?php
                                    if ($row->Jenis_Kelamin == 'LAKI-LAKI') {
                                        $jM = "checked";
                                        $jF = "";
                                    } else {
                                        $jM = "";
                                        $jF = "checked";
                                    }
                                    ?>
                                    <div class="radio">
                                        <label>
                                            <input id="inputJekel" name="txtJekel" type="radio" class="ace" value="LAKI-LAKI" <?php echo $jM; ?>>
                                            <span class="lbl"> Laki-laki</span>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input id="inputJekel" name="txtJekel" type="radio" class="ace" value="PEREMPUAN" <?php echo $jF; ?>>
                                            <span class="lbl"> Perempuan</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputNoPonsel"> Nomor Ponsel </label>
                                <div class="col-sm-10">
                                    <input type="text" id="inputNoPonsel" name="txtNoPonsel" class="col-xs-10" value="<?php echo $row->NoHP; ?>">
                                </div>
                            </div>

                            <?php $this->load->view('registrasi/template/addkerabat'); ?>

                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputTinggalDengan"> Tinggal dengan </label>
                                <div class="col-sm-10">
                                    <input type="text" id="inputTinggalDengan" name="txtTinggalDengan" class="col-xs-10" value="<?php echo $row->TinggalDengan; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputHubungan"> <small>Hubungan dengan Pelamar</small> </label>
                                <div class="col-sm-10">
                                    <input type="text" id="inputHubungan" name="txtHubungan" class="col-xs-10" value="<?php echo $row->HubunganDenganTK; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputTinggiBadan"> Tinggi Badan </label>
                                <div class="col-sm-10">
                                    <input type="text" id="inputTinggiBadan" name="txtTinggiBadan" class="col-xs-10" value="<?php echo $row->TinggiBadan; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputBeratBadan"> Berat Badan </label>
                                <div class="col-sm-10">
                                    <input type="text" id="inputBeratBadan" name="txtBeratBadan" class="col-xs-10" value="<?php echo $row->BeratBadan; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputSuku"> Suku </label>
                                <div class="col-sm-10">
                                    <select id="inputSuku" name="txtSuku" class="col-xs-10">
                                        <option value="">-- Pilih Suku</option>
                                        <?php foreach ($_getSuku as $rowSuku) : ?>
                                            <?php if ($row->Suku == $rowSuku->Suku) : ?>
                                                <option value="<?php echo $rowSuku->Suku; ?>" selected=""> <?php echo $rowSuku->Suku; ?> </option>
                                            <?php else : ?>
                                                <option value="<?php echo $rowSuku->Suku; ?>"> <?php echo $rowSuku->Suku; ?> </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputDaerahAsal"> Daerah Asal </label>
                                <div class="col-sm-10">
                                    <input type="text" id="inputDaerahAsal" name="txtDaerahAsal" class="col-xs-10" value="<?php echo ucwords(strtolower($row->Daerah_Asal)); ?>">
                                </div>
                            </div>

                        <?php
                    } ?>
                        <?php $this->load->view('registrasi/template/addprovinsi'); ?>

                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="inputBahasaDaerah"> Bahasa Daerah </label>
                            <div class="col-sm-10">
                                <input type="text" id="inputBahasaDaerah" name="txtBahasaDaerah" class="col-xs-10" value="<?php echo ucwords(strtolower($row->BahasaDaerah)); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="inputAgama"> Agama </label>
                            <div class="col-sm-10">
                                <select id="inputAgama" name="txtAgama" class="col-xs-10">
                                    <option value="">-- Pilih Agama</option>
                                    <?php foreach ($_getAgama as $rowAgama) : ?>
                                        <?php if (strtoupper($row->Agama) == strtoupper($rowAgama->Agama)) : ?>
                                            <option value="<?php echo $rowAgama->Agama; ?>" selected=""> <?php echo $rowAgama->Agama; ?> </option>
                                        <?php else : ?>
                                            <option value="<?php echo $rowAgama->Agama; ?>"> <?php echo $rowAgama->Agama; ?> </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right" for="inputStatusPersonal"> Status Perkawinan </label>
                            <div class="col-sm-10">
                                <select id="inputStatusPersonal" name="txtStatusPersonal" class="col-xs-10" onchange="StatusChange(this.value)">
                                    <option value="">-- Pilih Status</option>
                                    <?php foreach ($_getStatus as $rowStatus) : ?>
                                        <?php if (strtoupper($row->Status_Personal) == strtoupper($rowStatus->StatusKawin)) : ?>
                                            <option value="<?php echo $rowStatus->StatusKawin; ?>" selected=""> <?php echo $rowStatus->StatusKawin; ?> </option>
                                        <?php else : ?>
                                            <option value="<?php echo $rowStatus->StatusKawin; ?>"> <?php echo $rowStatus->StatusKawin; ?> </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        </div>

                        <div class="col-xs-12 col-sm-6">
                            <h4 class="header smaller lighter green">
                                <i class="ace-icon fa fa-users bigger-140"></i>
                                Data Suami/Istri
                            </h4>
                            <?php
                            if ($row->Status_Personal == "BUJANG" || $row->Status_Personal == "GADIS") {
                                $tglPasangan    = "";
                                $dis            = "disabled";
                            } else {
                                $tglPasangan    = date("d-m-Y", strtotime($row->TglLahirSuamiIstri));
                                $dis            = "";
                            }
                            ?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputNamaPasangan"> Nama Pasangan </label>
                                <div class="col-sm-10">
                                    <input type="text" id="inputNamaPasangan" name="txtNamaPasangan" class="col-xs-10" value="<?php echo ucwords(strtolower($row->NamaSuamiIstri)); ?>" <?php echo $dis; ?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputTglLahirPasangan"> Tanggal Lahir Pasangan </label>
                                <div class="col-sm-10">
                                    <input type="text" id="inputTglLahirPasangan" name="txtTglLahirPasangan" class="col-xs-10" value="<?php echo $tglPasangan; ?>" <?php echo $dis; ?>>
                                </div>
                                <script>
                                    $(function() {
                                        $('#inputTglLahirPasangan').datepick({
                                            minDate: '-60Y',
                                            maxDate: '-16Y',
                                            dateFormat: 'dd-mm-yyyy'
                                        });
                                    });
                                </script>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputPekerjaanPasangan"> Pekerjaan Pasangan </label>
                                <div class="col-sm-10">
                                    <input type="text" id="inputPekerjaanPasangan" name="txtPekerjaanPasangan" class="col-xs-10" value="<?php echo ucwords(strtolower($row->PekerjaanSuamiIstri)); ?>" <?php echo $dis; ?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputAlamatPasangan"> Alamat Pasangan </label>
                                <div class="col-sm-10">
                                    <textarea type="text" id="inputAlamatPasangan" name="txtAlamatPasangan" class="col-xs-10" <?php echo $dis; ?>><?php echo ucwords(strtolower($row->AlamatSuamiIstri)); ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <h4 class="header smaller lighter green">
                                <i class="ace-icon fa fa-users bigger-140"></i>
                                Data Anak
                            </h4>
                            <div class="table table-responsive">
                                <table id="tblListAnak" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Tempat Lahir</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Alamat</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $noA = 1; ?>
                                        <?php foreach ($_getDataAnak as $rowAnak) : ?>
                                            <tr>
                                                <td><?php echo $noA++; ?></td>
                                                <td><?php echo $rowAnak->Nama; ?></td>
                                                <td><?php echo $rowAnak->TempatLahir; ?></td>
                                                <td><?php echo date("M, d Y", strtotime($rowAnak->TglLahir)); ?></td>
                                                <td><?php
                                                    if ($rowAnak->JenisKelamin == "M") {
                                                        echo 'Laki-laki';
                                                    } else {
                                                        echo 'Perempuan';
                                                    }
                                                    ?></td>
                                                <td><?php echo $rowAnak->Alamat; ?></td>
                                                <td>
                                                    <a title="Edit Data Anak" data-rel="tooltip" href="<?php echo site_url("ubahDataKaryawan/anak/$row->HeaderID/" . $rowAnak->DetailID); ?>">
                                                        <i class="ace-icon fa fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12">
                            <h4 class="header smaller lighter green">
                                <i class="ace-icon fa fa-users bigger-140"></i>
                                Data Keluarga
                            </h4>
                            <?php if ($this->session->userdata('dept') == 'HRD') {  ?>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="inputNamaBapak"> Nama Ayah Kandung </label>
                                    <div class="col-sm-8">
                                        <input type="text" id="inputNamaBapak" name="txtNamaBapak" class="col-xs-6" value="<?php echo ucwords(strtolower($row->NamaBapak)); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="inputNamaIbu"> Nama Ibu Kandung </label>
                                    <div class="col-sm-8">
                                        <input type="text" id="inputNamaIbu" name="txtNamaIbu" class="col-xs-6" value="<?php echo ucwords(strtolower($row->NamaIbuKandung)); ?>">
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="inputNamaBapak"> Nama Ayah Kandung </label>
                                    <div class="col-sm-8">
                                        <input type="text" id="inputNamaBapak" name="txtNamaBapak" class="col-xs-6" value="<?php echo ucwords(strtolower($row->NamaBapak)); ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="inputNamaIbu"> Nama Ibu Kandung </label>
                                    <div class="col-sm-8">
                                        <input type="text" id="inputNamaIbu" name="txtNamaIbu" class="col-xs-6" value="<?php echo ucwords(strtolower($row->NamaIbuKandung)); ?>" readonly>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="inputPekerjaanOrtu"> Profesi Orang Tua </label>
                                <div class="col-sm-8">
                                    <input type="text" id="inputPekerjaanOrtu" name="txtPekerjaanOrtu" class="col-xs-6" value="<?php echo ucwords(strtolower($row->ProfesiOrangTua)); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="inputJumlahSaudara"> Jumlah Saudara </label>
                                <div class="col-sm-8">
                                    <input type="text" id="inputJumlahSaudara" name="txtJumlahSaudara" class="col-xs-6" value="<?php echo $row->JumlahSaudara; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="inputAnakKe"> Anak ke </label>
                                <div class="col-sm-8">
                                    <input type="text" id="inputAnakKe" name="txtAnakKe" class="col-xs-6" value="<?php echo $row->AnakKe; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <h4 class="header smaller lighter green">
                                <i class="ace-icon fa fa-university bigger-140"></i>
                                Pendidikan Terakhir
                            </h4>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputPendidikan"> Jenjang Pendidikan </label>
                                <div class="col-sm-10">
                                    <select id="inputPendidikan" name="txtPendidikan" class="col-xs-10" onclick="PendidikanChange(this.value)">
                                        <option value="">-- Pilih Pendidikan</option>
                                        <?php if ($row->Pendidikan == 'NaN') {
                                            $Pendidikan = 'TIDAK SEKOLAH';
                                        } else {
                                            $Pendidikan = $row->Pendidikan;
                                        } ?>
                                        <?php foreach ($_getPendidikan as $rowPendikan) : ?>
                                            <?php if (strtoupper($Pendidikan) == strtoupper($rowPendikan->Pendidikan)) : ?>
                                                <option value="<?php echo $rowPendikan->Pendidikan; ?>" selected=""> <?php echo $rowPendikan->Pendidikan; ?> </option>
                                            <?php else : ?>
                                                <option value="<?php echo $rowPendikan->Pendidikan; ?>"> <?php echo $rowPendikan->Pendidikan; ?> </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputJurusan"> Jurusan </label>
                                <div class="col-sm-10">
                                    <select id="inputJurusan" name="txtJurusan" class="col-xs-10">
                                        <option value="">-- Pilih Jurusan</option>
                                        <?php foreach ($_getJurusan as $rowJurusan) : ?>
                                            <?php if (strtoupper($row->Jurusan) == strtoupper($rowJurusan->Jurusan)) : ?>
                                                <option value="<?php echo $rowJurusan->Jurusan; ?>" selected=""> <?php echo $rowJurusan->Jurusan; ?> </option>
                                            <?php else : ?>
                                                <option value="<?php echo $rowJurusan->Jurusan; ?>"> <?php echo $rowJurusan->Jurusan; ?> </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <!--                ====================================================== -->
                            <div id="inputSekolah" style="display: block">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="inputShcool"> Nama Sekolah </label>
                                    <div class="col-sm-10">
                                        <input type="text" id="inputShcool" name="txtShcool" class="col-xs-10" value="<?php echo strtoupper($row->Universitas); ?>" onclick="PendidikanChange()">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="inputNilai"> Nilai Rata-rata </label>
                                    <div class="col-sm-10">
                                        <input type="text" id="inputNilai" name="txtNilai" class="col-xs-10" value="<?php echo $row->IPK; ?>">
                                    </div>
                                </div>
                            </div>
                            <div id="inputUniversitas" style="display: none">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="inputUniv"> Universitas </label>
                                    <div class="col-sm-10">
                                        <input type="text" id="inputUniv" name="txtUniv" class="col-xs-10" value="<?php echo strtoupper($row->Universitas); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="inputIPK"> IPK (Skala 4.00) </label>
                                    <div class="col-sm-10">
                                        <input type="text" id="inputIPK" name="txtIPK" class="col-xs-10" value="<?php echo $row->IPK; ?>">
                                    </div>
                                </div>
                            </div>
                            <!--                ====================================================== -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputTahunMasuk"> Tahun Masuk </label>
                                <div class="col-sm-10">
                                    <input type="text" id="inputTahunMasuk" name="txtTahunMasuk" class="col-xs-10" value="<?php echo $row->TahunMasuk; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputTahunLulus"> Tahun Lulus </label>
                                <div class="col-sm-10">
                                    <input type="text" id="inputTahunLulus" name="txtTahunLulus" class="col-xs-10" value="<?php echo $row->TahunLulus; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <h4 class="header smaller lighter green">
                                <i class="ace-icon fa fa-gavel bigger-140"></i>
                                Riwayat Pekerjaan
                            </h4>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputPengalamanKerja"> Pengalaman Kerja </label>
                                <div class="col-sm-10">
                                    <input type="text" id="inputPengalamanKerja" name="txtPengalamanKerja" class="col-xs-10" value="<?php echo strtoupper($row->PengalamanKerja); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputKeahlian"> <small>Keahlian/ Keterampilan yang dikuasai</small> </label>
                                <div class="col-sm-10">
                                    <textarea type="text" id="inputKeahlian" name="txtKeahlian" class="col-xs-10"><?php echo ucwords(strtolower($row->Keahlian)); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputPernahSambu"> <small>Pernah Kerja Di <strong>Sambu Group</strong></small> </label>
                                <div class="col-sm-10">
                                    <?php
                                    if ($row->PernahKerjaDiSambu == "YA") {
                                        $yPS    = "checked";
                                        $tPS    = "";
                                    } else {
                                        $yPS    = "";
                                        $tPS    = "checked";
                                    }
                                    ?>
                                    <div class="radio">
                                        <label>
                                            <input id="inputPernahSambu" name="txtPernahSambu" type="radio" class="ace" value="YA" <?php echo $yPS; ?> onclick="cekPS(this.value)">
                                            <span class="lbl"> YA </span>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input id="inputPernahSambu" name="txtPernahSambu" type="radio" class="ace" value="TIDAK" <?php echo $tPS; ?> onclick="cekPS(this.value)">
                                            <span class="lbl"> TIDAK </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="fieldBagian" style="display: none">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="inputBagian"> Bagian/ Department </label>
                                    <div class="col-sm-10">
                                        <input type="text" id="inputBagian" name="txtBagian" class="col-xs-10" <?php echo $row->KerjadiBagian; ?>>
                                    </div>
                                </div>
                            </div>
                            <script>
                                function cekPS(valPS) {
                                    if (valPS === "YA") {
                                        document.getElementById('fieldBagian').style.display = "block";
                                    } else {
                                        document.getElementById('fieldBagian').style.display = "none";
                                    }
                                }
                            </script>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="inputAdaKeluarga"> <small>Ada Keluarga yg Bekerja di <strong>Sambu Group</strong></small> </label>
                                <div class="col-sm-10">
                                    <?php
                                    if ($_gelKel == "ADA") {
                                        $yKel   = "checked";
                                        $tKel   = "";
                                    } else {
                                        $yKel   = "";
                                        $tKel   = "checked";
                                    }
                                    ?>
                                    <div class="radio">
                                        <label>
                                            <input id="inputAdaKeluarga" name="txtAdaKeluarga" type="radio" class="ace" value="YA" <?php echo $yKel; ?>>
                                            <span class="lbl"> YA </span>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input id="inputAdaKeluarga" name="txtAdaKeluarga" type="radio" class="ace" value="TIDAK" <?php echo $tKel; ?>>
                                            <span class="lbl"> TIDAK </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="tblListKel" class="table table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Bagian</th>
                                            <th>Pemborong</th>
                                            <th>Hubungan</th>
                                            <th>Alamat</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $noK = 1; ?>
                                        <?php foreach ($_getDataKel as $rowKel) : ?>
                                            <tr data-id="<?php echo $rowKel->DetailID; ?>">
                                                <td><?php echo $noK++; ?></td>
                                                <td><?php echo $rowKel->Nama; ?></td>
                                                <td><?php echo $rowKel->Departemen; ?></td>
                                                <td><?php echo $rowKel->Pemborong; ?></td>
                                                <td><?php echo $rowKel->HubunganKeluarga; ?></td>
                                                <td><?php echo $rowKel->Alamat; ?></td>
                                                <td>
                                                    <a title="Edit Data Keluarga" data-rel="tooltip" href="#" class="editKel">
                                                        <i class="ace-icon fa fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="col-xs-12">
                            <h4 class="header smaller lighter green">
                                <i class="ace-icon fa fa-user bigger-140"></i>
                                Ahli Waris
                            </h4>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="inputAhliWaris"> Nama </label>
                                    <div class="col-sm-9">
                                        <input type="text" id="inputAhliWaris" name="txtAhliWaris" class="col-xs-10" value="<?php echo strtoupper($row->AhliWaris_Nama); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Jenis Kelamin Ahli Waris* </label>
                                    <div class="col-sm-9">
                                        <?php
                                        if ($row->AhliWaris_Jekel == 'LAKI-LAKI') {
                                            $jM = "checked";
                                            $jF = "";
                                        } else {
                                            $jM = "";
                                            $jF = "checked";
                                        }
                                        ?>
                                        <div class="radio">
                                            <label>
                                                <input id="inputJekelAhliWaris" name="txtJekelAhliWaris" type="radio" class="ace" value="LAKI-LAKI" <?php echo $jM; ?>>
                                                <span class="lbl"> Laki-laki</span>
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input id="inputJekelAhliWaris" name="txtJekelAhliWaris" type="radio" class="ace" value="PEREMPUAN" <?php echo $jF; ?>>
                                                <span class="lbl"> Perempuan</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="inputAlamatAhliWaris"> Alamat </label>
                                    <div class="col-sm-9">
                                        <textarea id="inputAlamatAhliWaris" name="txtAlamatAhliWaris" class="col-xs-10"><?php echo ucwords(strtolower($row->AhliWaris_Alamat)); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="inputHubunganAhliWaris"> Hubungan </label>
                                    <div class="col-sm-9">
                                        <input type="text" id="inputHubunganAhliWaris" name="txtHubunganAhliWaris" class="col-xs-10" value="<?php echo ucwords(strtolower($row->AhliWaris_Hubungan)); ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="txtnohpkerabatAhliWaris"> No. HP </label>
                                    <div class="col-sm-9">
                                        <input type="text" id="txtnohpkerabatAhliWaris" name="txtnohpkerabatAhliWaris" class="col-xs-10" value="<?php echo ucwords(strtolower($row->AhliWaris_NoHP)); ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <h4 class="header smaller lighter green">
                                <i class="ace-icon fa fa-info-circle bigger-140"></i>
                                Informasi Lainnya
                            </h4>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="inputHobby"> Hobby </label>
                                    <div class="col-sm-10">
                                        <textarea id="inputHobby" name="txtHobby" class="col-xs-10"><?php echo ucwords(strtolower($row->Hobby)); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="inputKegiatanEkstra"> Kegiatan Ekstra </label>
                                    <div class="col-sm-10">
                                        <textarea id="inputKegiatanEkstra" name="txtKegiatanEkstra" class="col-xs-10"><?php echo ucwords(strtolower($row->KegiatanEkstra)); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="inputOrganisasi"> Kegiatan Organisasi </label>
                                    <div class="col-sm-10">
                                        <textarea id="inputOrganisasi" name="txtOrganisasi" class="col-xs-10"> <?php echo $row->KegiatanOrganisasi; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="AccountFacebook">Facebook</label>
                                    <div class="col-sm-10">
                                        <label>
                                            <div class="input-group">
                                                <input type="text" id="AccountFacebook" name="txt_facebook" class="col-xs-10" size="20" value="<?php echo $row->AccountFacebook; ?>">
                                            </div>
                                        </label>
                                    </div>
                                    <label class="col-sm-2 control-label no-padding-right" for="AccountTwitter">Twitter</label>
                                    <div class="col-sm-10">
                                        <label>
                                            <div class="input-group">
                                                <input type="text" id="AccountTwitter" name="txt_twitter" class="col-xs-10" size="20" value="<?php echo $row->AccountTwitter; ?>">
                                            </div>
                                        </label>
                                    </div>
                                    <label class="col-sm-2 control-label no-padding-right" for="Account_email">E-mail</label>
                                    <div class="col-sm-10">
                                        <label>
                                            <div class="input-group">
                                                <input type="text" id="Account_email" name="txt_email" class="col-xs-10" size="20" value="<?php echo $row->Account_email; ?>">
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="inputKeadaanFisik"> Keadaan Fisik </label>
                                    <div class="col-sm-10">
                                        <?php
                                        if (strtoupper($row->KeadaanFisik) == "CACAT") {
                                            $yC    = "checked";
                                            $tC    = "";
                                            $dC    = "";
                                        } else {
                                            $yC    = "";
                                            $tC    = "checked";
                                            $dC    = "disabled";
                                        }
                                        ?>
                                        <div class="radio">
                                            <label>
                                                <input id="inputKeadaanFisik" name="txtKeadaanFisik" type="radio" class="ace" value="CACAT" <?php echo $yC; ?> onclick="DisabledInput(this.value,'inputCacatApa');">
                                                <span class="lbl"> Cacat </span>
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input id="inputKeadaanFisik" name="txtKeadaanFisik" type="radio" class="ace" value="NORMAL" <?php echo $tC; ?> onclick="DisabledInput(this.value,'inputCacatApa');">
                                                <span class="lbl"> Tidak Cacat </span>
                                            </label>
                                        </div>
                                        <input type="text" id="inputCacatApa" name="txtCacatApa" class="col-xs-10" value="<?php echo $row->CacatApa; ?>" <?php echo $dC; ?>>
                                    </div>
                                    <!--                        <div class="col-sm-10">
                            <select id="inputKeadaanFisik" name="txtKeadaanFisik" class="col-xs-10">
                                <option value="">-- Pilih</option>
                                <?php
                                //                                if(strtoupper($row->KeadaanFisik) == "CACAT"){
                                //                                    $yC = "selected";
                                //                                    $tC = "";
                                //                                }else{
                                //                                    $yC = "";
                                //                                    $tC = "selected";
                                //                                }
                                ?>
                                
                                <option value="CACAT" <?php // echo $yC;
                                                        ?>>CACAT</option>
                                <option value="NORMAL" <?php // echo $tC;
                                                        ?>>TIDAK CACAT</option>
                            </select>
                        </div>-->
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="inputIdapPenyakit"> Idap Penyakit </label>
                                    <div class="col-sm-10">
                                        <?php
                                        if ($row->PernahIdapPenyakit == "YA") {
                                            $yIP    = "checked";
                                            $tIP    = "";
                                            $dIP    = "";
                                        } else {
                                            $yIP    = "";
                                            $tIP    = "checked";
                                            $dIP    = "disabled";
                                        }
                                        ?>
                                        <div class="radio">
                                            <label>
                                                <input id="inputIdapPenyakit" name="txtIdapPenyakit" type="radio" class="ace" value="YA" <?php echo $yIP; ?> onclick="DisabledInput(this.value,'inputPenyakit');">
                                                <span class="lbl"> YA </span>
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input id="inputIdapPenyakit" name="txtIdapPenyakit" type="radio" class="ace" value="TIDAK" <?php echo $tIP; ?> onclick="DisabledInput(this.value,'inputPenyakit');">
                                                <span class="lbl"> TIDAK </span>
                                            </label>
                                        </div>
                                        <input type="text" id="inputPenyakit" name="txtPenyakit" class="col-xs-10" value="<?php echo $row->PenyakitApa; ?>" <?php echo $dIP; ?>>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="inputKriminal"> Terlibat kriminal </label>
                                    <div class="col-sm-10">
                                        <?php
                                        if ($row->Kriminal == "YA") {
                                            $yK    = "checked";
                                            $tK    = "";
                                            $dK    = "";
                                        } else {
                                            $yK    = "";
                                            $tK    = "checked";
                                            $dK    = "disabled";
                                        }
                                        ?>
                                        <div class="radio">
                                            <label>
                                                <input id="inputKriminal" name="txtKriminal" type="radio" class="ace" value="YA" <?php echo $yK; ?> onclick="DisabledInput(this.value,'inputPerkara');">
                                                <span class="lbl"> YA </span>
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input id="inputKriminal" name="txtKriminal" type="radio" class="ace" value="TIDAK" <?php echo $tK; ?> onclick="DisabledInput(this.value,'inputPerkara');">
                                                <span class="lbl"> TIDAK </span>
                                            </label>
                                        </div>
                                        <input type="text" id="inputPerkara" name="txtPerkara" class="col-xs-10" value="<?php echo $row->PerkaraApa; ?>" <?php echo $dK; ?>>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="inputVaksin"> Apakah Sudah Vaksin ? </label>
                                    <div class="col-sm-10">
                                        <?php
                                        if ($row->Vaksin == "SUDAH") {
                                            $yVaksin    = "checked";
                                            $tVaksin    = "";
                                            $dVaksin    = "";
                                        } else {
                                            $yVaksin    = "";
                                            $tVaksin    = "checked";
                                            $dVaksin    = "disabled";
                                        }
                                        ?>
                                        <div class="radio">
                                            <label>
                                                <input id="inputVaksin" name="txtVaksin" type="radio" class="ace" value="SUDAH" <?php echo $yVaksin; ?> onclick="DisabledInputVaksin(this.value,'inputJenisVaksin','inputTanggalVaksin','inputTanggalVaksin2');">
                                                <span class="lbl"> SUDAH </span>
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input id="inputVaksin" name="txtVaksin" type="radio" class="ace" value="BELUM" <?php echo $tVaksin; ?> onclick="DisabledInputVaksin(this.value,'inputJenisVaksin','inputTanggalVaksin','inputTanggalVaksin2');">
                                                <span class="lbl"> BELUM </span>
                                            </label>
                                        </div>
                                        <input type="text" id="inputJenisVaksin" name="txtJenisVaksin" class="col-xs-10" value="<?php echo $row->JenisVaksin; ?>" <?php echo $dVaksin; ?>>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="Vaksin1">Vaksin 1 </label>
                                    <div class="col-sm-10">
                                        <label>
                                            <div class="input-group">
                                                <input type="date" name="txtTanggalVaksin" id="inputTanggalVaksin" class="form-control txtTanggalVaksin" value="<?php if (isset($row->TanggalVaksin)) {
                                                                                                                                                                    echo date('Y-m-d', strtotime($row->TanggalVaksin));
                                                                                                                                                                } else {
                                                                                                                                                                    echo $row->TanggalVaksin;
                                                                                                                                                                } ?>" autocomplete="off" <?php echo $dVaksin; ?>>
                                            </div>
                                        </label>
                                    </div>
                                    <label class="col-sm-2 control-label no-padding-right" for="Vaksin2">Vaksin 2 </label>
                                    <div class="col-sm-10">
                                        <label>
                                            <div class="input-group">
                                                <input type="date" name="txtTanggalVaksin2" id="inputTanggalVaksin2" class="form-control txtTanggalVaksin2" value="<?php if (isset($row->TanggalVaksin2)) {
                                                                                                                                                                        echo date('Y-m-d', strtotime($row->TanggalVaksin2));
                                                                                                                                                                    } else {
                                                                                                                                                                        echo $row->TanggalVaksin2;
                                                                                                                                                                    } ?>" autocomplete="off">
                                            </div>
                                        </label>
                                    </div>
                                    <label class="col-sm-2 control-label no-padding-right" for="Vaksin3">Vaksin 3 </label>
                                    <div class="col-sm-10">
                                        <label>
                                            <div class="input-group">
                                                <input type="date" name="txtTanggalVaksin3" id="inputTanggalVaksin3" class="form-control txtTanggalVaksin3" value="<?php if (isset($row->TanggalVaksin3)) {
                                                                                                                                                                        echo date('Y-m-d', strtotime($row->TanggalVaksin3));
                                                                                                                                                                    } else {
                                                                                                                                                                        echo $row->TanggalVaksin3;
                                                                                                                                                                    } ?>" autocomplete="off">
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="inputBertato"> Apakah Bertato </label>
                                    <div class="col-sm-12">
                                        <?php
                                        if ($row->Bertato == "YA") {
                                            $yTT    = "checked";
                                            $tTT    = "";
                                            $dTT    = "";
                                        } else {
                                            $yTT    = "";
                                            $tTT    = "checked";
                                            $dTT    = "disabled";
                                        }
                                        ?>
                                        <div class="radio">
                                            <label>
                                                <input id="inputBertato" name="txtBertato" type="radio" class="ace" value="YA" <?php echo $yTT; ?> onclick="DisabledInput(this.value,'inputTatoDimana');">
                                                <span class="lbl"> YA </span>
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input id="inputBertato" name="txtBertato" type="radio" class="ace" value="TIDAK" <?php echo $tTT; ?> onclick="DisabledInput(this.value,'inputTatoDimana');">
                                                <span class="lbl"> TIDAK </span>
                                            </label>
                                        </div>
                                        <input type="text" id="inputTatoDimana" name="txtTatoDimana" class="col-xs-10" value="<?php echo $row->TatoDimana; ?>" <?php echo $dTT; ?>>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputBertindik"> Apakah Bertindik </label>
                                    <div class="col-sm-12">
                                        <?php
                                        if ($row->Bertindik == "YA") {
                                            $yTD    = "checked";
                                            $tTD    = "";
                                        } else {
                                            $yTD    = "";
                                            $tTD    = "checked";
                                        }
                                        ?>
                                        <div class="radio">
                                            <label>
                                                <input id="inputBertindik" name="txtBertindik" type="radio" class="ace" value="YA" <?php echo $yTD; ?>>
                                                <span class="lbl"> YA </span>
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input id="inputBertindik" name="txtBertindik" type="radio" class="ace" value="TIDAK" <?php echo $tTD; ?>>
                                                <span class="lbl"> TIDAK </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="inputRambutPendek"> <small>Bersedia Rambut Pendek (Pria)</small> </label>
                                    <div class="col-sm-12">
                                        <?php
                                        if ($row->SediaPotongRambut == "YA") {
                                            $yRP    = "checked";
                                            $tRP    = "";
                                        } else {
                                            $yRP    = "";
                                            $tRP    = "checked";
                                        }
                                        ?>
                                        <div class="radio">
                                            <label>
                                                <input id="inputRambutPendek" name="txtRambutPendek" type="radio" class="ace" value="YA" <?php echo $yRP; ?>>
                                                <span class="lbl"> YA </span>
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input id="inputRambutPendek" name="txtRambutPendek" type="radio" class="ace" value="TIDAK" <?php echo $tRP; ?>>
                                                <span class="lbl"> TIDAK </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputReadyStop"> <small>Bersedia dibehentikan, Jika kinerja Kurang</small> </label>
                                    <div class="col-sm-12">
                                        <?php
                                        if ($row->Sediadiberhentikan == "YA") {
                                            $yRS    = "checked";
                                            $tRS    = "";
                                        } else {
                                            $yRS    = "";
                                            $tRS    = "checked";
                                        }
                                        ?>
                                        <div class="radio">
                                            <label>
                                                <input id="inputReadyStop" name="txtReadyStop" type="radio" class="ace" value="YA" <?php echo $yRS; ?>>
                                                <span class="lbl"> YA </span>
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input id="inputReadyStop" name="txtReadyStop" type="radio" class="ace" value="TIDAK" <?php echo $tRS; ?>>
                                                <span class="lbl"> TIDAK </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hr hr-24"></div>
                        <div class="col-xs-12">
                            <div class="clearfix form-actions">
                                <div class="center">
                                    <button class="btn btn-block btn-info" type="submit">
                                        <i class="ace-icon fa fa-check bigger-110"></i>
                                        Update
                                    </button>
                                </div>
                            </div>
                        </div>
            </form>
        </div>

    </div>

    <!-- Modal View Edit Anak-->
    <div class="modal fade" id="viewModalEditDataKel" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!--style="background-color: #008cba">-->
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Edit Data Keluarga dari Sdr. <strong class="green"><?php echo ucwords(strtolower($row->Nama)); ?></strong></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="inputdetail" name="iddetail">
                    <div id="editDataKel" class="well">
                        <!--load tabel dari file detail.php melalui javascript-->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('[data-rel=tooltip]').tooltip();

        $("#tblListKel").on("click", ".editKel", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url: "<?php echo site_url('ubahDataKaryawan/keluarga'); ?>",
                type: "POST",
                data: "kode=" + id,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#editDataKel").html(msg);
                }
            });
            $("#viewModalEditDataKel").modal("show");
        });
    });
</script>

<script language="javascript">
    function addRowAnak() {
        var table = document.getElementById('dataTable1');
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);
        var colCount = table.rows[0].cells.length;

        for (var i = 0; i < colCount; i++) {

            var newcell = row.insertCell(i);

            newcell.innerHTML = table.rows[0].cells[i].innerHTML;
            //alert(newcell.childNodes);
            switch (newcell.childNodes[0].type) {
                case "text":
                    newcell.childNodes[0].value = "";
                    break;
                case "checkbox":
                    newcell.childNodes[0].checked = false;
                    break;
                case "select-one":
                    newcell.childNodes[0].selectedIndex = 0;
                    break;
            }

        }
        document.getElementById('inputJumlahAnak').value = rowCount + 1;
    }

    function deleteRowAnak() {
        try {
            var table = document.getElementById('dataTable1');
            var rowCount = table.rows.length;

            for (var i = 0; i < rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if (null != chkbox && true == chkbox.checked) {
                    if (rowCount <= 1) {
                        alert("Tidak bisa semua baris dihapus!");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }
                document.getElementById('inputJumlahAnak').value = rowCount;
            }
        } catch (e) {
            alert(e);
        }
    }

    // addRow Keluarga
    function addRow(tableID) {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);
        var colCount = table.rows[0].cells.length;

        for (var i = 0; i < colCount; i++) {

            var newcell = row.insertCell(i);

            newcell.innerHTML = table.rows[0].cells[i].innerHTML;
            //alert(newcell.childNodes);
            switch (newcell.childNodes[0].type) {
                case "text":
                    newcell.childNodes[0].value = "";
                    break;
                case "checkbox":
                    newcell.childNodes[0].checked = false;
                    break;
                case "select-one":
                    newcell.childNodes[0].selectedIndex = 0;
                    break;
            }

        }
    }

    function deleteRow(tableID) {
        try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;

            for (var i = 0; i < rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if (null != chkbox && true == chkbox.checked) {
                    if (rowCount <= 1) {
                        alert("Tidak bisa semua baris dihapus!");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }
            }
        } catch (e) {
            alert(e);
        }
    }
</script>

<script language="JavaScript">
    function StatusChange(vstatus) {
        if (vstatus === "Nikah") {
            document.getElementById('listAnak').style.display = "block";

            document.getElementById('inputNamaPasangan').disabled = false;
            document.getElementById('inputTglLahirPasangan').disabled = false;
            document.getElementById('inputPekerjaanPasangan').disabled = false;
            document.getElementById('inputAlamatPasangan').disabled = false;
        } else if (vstatus === "Duda" || vstatus === "Janda") {
            document.getElementById('listAnak').style.display = "block";

            document.getElementById('inputNamaPasangan').disabled = false;
            document.getElementById('inputTglLahirPasangan').disabled = false;
            document.getElementById('inputPekerjaanPasangan').disabled = false;
            document.getElementById('inputAlamatPasangan').disabled = false;
        } else {
            document.getElementById('inputNamaPasangan').value = "";
            document.getElementById('inputTglLahirPasangan').value = "";
            document.getElementById('inputPekerjaanPasangan').value = "";
            document.getElementById('inputAlamatPasangan').value = "";

            document.getElementById('listAnak').style.display = "none";

            document.getElementById('inputNamaPasangan').disabled = true;
            document.getElementById('inputTglLahirPasangan').disabled = true;
            document.getElementById('inputPekerjaanPasangan').disabled = true;
            document.getElementById('inputAlamatPasangan').disabled = true;
        }
    }

    function PernahRSUPChange(object) {
        if (object === "YA") {
            document.getElementById('inputBagian').disabled = false;
        } else {
            document.getElementById('inputBagian').disabled = true;
            document.getElementById('inputBagian').value = '';
        }
    }

    function KeluargaDiRSUP(object) {
        if (object === "YA") {
            document.getElementById('listkeluarga').style.display = "block";
        } else {
            document.getElementById('listkeluarga').style.display = "none";
        }
    }

    function PendidikanChange() {
        var objvalue = document.getElementById('inputPendidikan').value;

        if (objvalue === '' || objvalue === "TIDAK SEKOLAH" || objvalue === "SD" || objvalue === "SMP" || objvalue === "MTS") {
            document.getElementById('inputJurusan').value = '';
            document.getElementById('inputJurusan').disabled = true;
        } else {
            document.getElementById('inputJurusan').disabled = false;
        }

        if (objvalue === "D1" || objvalue === "D2" || objvalue === "D3" || objvalue === "S1" || objvalue === "S2" || objvalue === "S3") {
            document.getElementById('inputSekolah').style.display = "none";
            document.getElementById('inputUniversitas').style.display = "block";
        } else {
            document.getElementById('inputSekolah').style.display = "block";
            document.getElementById('inputUniversitas').style.display = "none";
        }
    }

    function DisabledInput(object, input_id) {
        var el = document.getElementById(input_id);
        if (object === "YA" || object === "CACAT") {
            el.disabled = false;
        } else {
            el.disabled = true;
            el.value = 'TIDAK ADA';
        }
    }

    function DisabledInputVaksin(object, input_id, input_id2, input_id3) {
        var el = document.getElementById(input_id);
        var tgl = document.getElementById(input_id2);
        var tgl2 = document.getElementById(input_id3);

        if (object === "SUDAH") {
            el.disabled = false;
            el.required = true;
            el.value = '';
            tgl.disabled = false;
            tgl.required = true;
            tgl.value = '';
            tgl2.disabled = false;
            tgl2.value = '';
        } else {
            el.disabled = true;
            el.value = 'TIDAK ADA';
            tgl.disabled = true;
            tgl.required = false;
            tgl.value = null;
            tgl2.disabled = true;
            tgl2.value = null;
        }
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>