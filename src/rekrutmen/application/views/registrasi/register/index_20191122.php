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
<script src="<?php echo base_url(); ?>assets/js/jquery.inputlimiter.1.3.1.js"></script>


<script type="text/javascript">
    jQuery(function ($) {
        $.mask.definitions['~'] = '[+-]';
//        $('#inputNoPonsel').mask('099999999999');
        $('#inputTahunMasuk').mask('9999');
        $('#inputTahunLulus').mask('9999');
        $('#inputIPK').mask('9.99');
        $('#inputTanggalLahir').mask('99-99-9999');
        $('#inputTglLahirPasangan').mask('99-99-9999');
        $('.tglAnak').mask('99/99/9999');
        $('textarea.limited').inputlimiter({
                remText: '%n character%s remaining...',
                limitText: 'max allowed : %n.'
        });		
		

        jQuery.validator.addMethod("phone", function (value, element) {
            return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{4}( x\d{1,6})?$/.test(value);
        }, "Enter a valid phone number.");

        $('#formRegistrasi').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
                txtPerusahaan: {
                    required: true
                },
                txtNama: {
                    required: true
                },
                txtNoKTP: {
                    required: true
                },
                txtNoPonsel: {
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
                txtPemborong: {
                    required: true
                },
                txtIPK: {
                    number: true
                },
                txtNilai: {
                    number: true
                },
				txtProvinsi: {
					required:true
				},
				txtKabupaten: {
					required:true
				},
				txtKecamatan: {
					required:true
				},
				txtTinggiBadan: {
					required:true
				},
				txtBeratBadan:{
					required:true
				},
                txtkerabatterdekat:{
                    required:{
                        depends:function(){
                            if($.trim($(this).val())=='')
                            {  
                                return true;
                            }else{
                                return false;
                            }
                        }
                    }
                },
                txtnohpkerabat:{
                    required:{
                        depends:function(){
                            if($.trim($(this).val())=='')
                            {  
                                return true;
                            }else{
                                return false;
                            }
                        }
                    }
                },
                txthubungan:{
                    required:{
                        depends:function(){
                            if($.trim($(this).val())=='')
                            {  
                                return true;
                            }else{
                                return false;
                            }
                        }
                    }
                },
                txtAlamatKerabat:{
                    required: true
                },
                txtAhliWaris:{
                    required: true
                },
                txtJekelAhliWaris:{
                    required: true
                },
                txtAlamatAhliWaris:{
                    required: true
                },
                txtHubunganAhliWaris:{
                    required: true
                },
                txtnohpAhliWaris:{
                    required: true
                }

            },
            messages: {
                txtPerusahaan: {
                    required: "Silahkan Pilih Perusahaan/CV"
                },
                txtNama: {
                    required: "Harap input Nama Lengkap!",
                    pattern: "Harap input dengan Huruf Alfabet (a-z A-Z)"
                },
                txtNoKTP: {
                    required: "Harap input NIK!"
                },
                txtNoPonsel: {
                    required: "Harap input Nomor Handphone Anda!",
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
                txtPemborong: "Silahkan Pilih Pemborong",
                txtAlamat: "Harap input Alamat Anda!",
                txtTinggalDengan: "Harap input Anda Tinggal dengan Siapa!",
                txtHubungan: "Harap input hubungan dengan Calon Pelamar!",
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
				txtProvinsi:"Harap Pilih Provinsi",
				txtKabupaten: "Harap pilih Kabupaten",
				txtKecamatan: "Harap pilih Kecamatan",
                txtkerabatterdekat:'Harap isi data kerabat terdekat',
                txtnohpkerabat:'Harap isi no.hp kerabat terdekat',
                txthubungan:'Harap isi hubungan kerabat terdekat',
                txtAlamatKerabat:'Harap isi alamat kerabat terdekat',
				txtTinggiBadan:'Harap isi data tinggi badan',
				txtBeratBadan:'Harap isi data berat badan',
                txtAlamatKerabat:'Harap isi alamat kerabat terdekat',
                txtAhliWaris: 'Harap isi data ahli waris',
                txtJekelAhliWaris: 'Harap isi data ahli waris',
                txtAlamatAhliWaris: 'Harap isi data ahli waris',
                txtHubunganAhliWaris: 'Harap isi data ahli waris',
                txtnohpAhliWaris: 'Harap isi data ahli waris'

            },
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                $(e).remove();
            },
            errorPlacement: function (error, element) {
                if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                    var controls = element.closest('div[class*="col-"]');
                    if (controls.find(':checkbox,:radio').length > 1)
                        controls.append(error);
                    else
                        error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
                }
                else if (element.is('.select2')) {
                    error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
                }
                else if (element.is('.chosen-select')) {
                    error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                }
                else
                    error.insertAfter(element.parent());
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
        REGISTRASI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Pendaftaran Tenaga Kerja Baru
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <!-- Design Disini -->
        <form id="formRegistrasi" class="form-horizontal" action="<?php echo site_url('registrasi/simpanReg'); ?>" method="POST">
            <input type="hidden" name="txtConfirm" id="inputConfirm" value="0" readonly="">
            <fieldset>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h3 class="widget-title">Registrasi Tenaga Kerja Baru</h3>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header smaller lighter green">
                                        <i class="ace-icon fa fa-bookmark bigger-140"></i>
                                        Tujuan Lamaran
                                    </h4>
                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-2 no-padding-right" for="form-field-1"> Perusahaan/ CV </label>
                                        <div class="col-sm-8">
                                            <select class="col-xs-12 col-sm-10" name="txtPerusahaan" id="inputPerusahaan">
                                                <option value=""> -- Silahkan Pilih Perusahaan</option>
                                                <?php
                                                foreach ($_getPSGPemorong as $rowCV):
                                                    ?>
                                                    <option value='<?php echo $rowCV->Perusahaan; ?>'><?php echo $rowCV->Perusahaan; ?></option>
                                                    <?php
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Pemborong </label>
                                        <div class="col-sm-8">
                                            <div id="pt">
                                                <input type="text" id="inputPemborong" name="txtPemborong" placeholder="Pemborong Auto Value" class="col-xs-12 col-sm-10" readonly="" required=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        $("#inputPerusahaan").change(function () {
                                            var selectValues = $("#inputPerusahaan").val();
                                            if (selectValues === 0) {
                                                var msg = "<input class=\"form-control\" name=\"txtPemborong\" id=\"inputPemborong\" placeholder=\"Nama Perusahaan\" type=\"text\" value='' readonly />";
                                                $('#pt').html(msg);
                                            } else {
                                                var pemborong = {pemborong: $("#inputPerusahaan").val()};
//                                              $('#inputPerusahaan').attr("disabled",true);
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo site_url('registrasi/selectPemborong') ?>",
                                                    data: pemborong,
                                                    success: function (msg) {
                                                        $('#pt').html(msg);
                                                    }
                                                });
                                            }
                                        });
                                    </script>

                                    <h4 class="header smaller lighter green">
                                        <i class="ace-icon fa fa-user bigger-140"></i>
                                        Data Pribadi
                                    </h4>

                                    <div class="space-2"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nama Lengkap* </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputNamaLengkap" name="txtNama" placeholder="Input Nama Lengkap" class="col-xs-12 col-sm-10" required="" pattern="[a-z A-Z]*$"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> NO. KTP* </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputNoKTP" name="txtNoKTP" placeholder="Input No. KTP" class="col-xs-12 col-sm-10" required="" minlength="16"  maxlength="16" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Alamat Sekarang* </label>
                                        <div class="col-sm-8">
                                            <textarea class="col-xs-12 col-sm-10" id="inputAlamat" name="txtAlamat" placeholder="Input Alamat Sekarang" required=""></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> RT </label>
                                        <div class="col-sm-3">
                                            <input type="text" id="inputRT" name="txtRT" placeholder="RT"  onkeypress="return isNumber(event)"/>
                                        </div>
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> RW </label>
                                        <div class="col-sm-3">
                                            <input type="text" id="inputRW" name="txtRW" placeholder="RW"  onkeypress="return isNumber(event)"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tinggal dengan* </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputTinggalDengan" name="txtTinggalDengan" placeholder="Tinggal dengan" class="col-xs-12 col-sm-10" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> <small>Hubungan dengan Calon Pelamar*</small></label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputHubungan" name="txtHubungan" placeholder="Hubungan dengan Calon Pelamar" class="col-xs-12 col-sm-10" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nomor Ponsel* </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputNoPonsel" name="txtNoPonsel" placeholder="Input Nomor Ponsel" class="col-xs-12 col-sm-10" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tempat Lahir* </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputTempatLahir" name="txtTempatLahir" placeholder="Input Tempat Lahir" class="col-xs-12 col-sm-10" required=""/>
                                        </div>
                                    </div>

                                    <div class="form-group" id="tglLahir">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tanggal Lahir* </label>
                                        <div class="col-sm-8">
                                            <span class="input-icon">
                                                <input type="text" id="inputTanggalLahir" name="txtTanggalLahir" placeholder="Input Tanggal Lahir" required="" />
                                                <i class="ace-icon fa fa-calendar green"></i>
                                            </span> Format (dd-mm-yyyy)
                                            <span class="">
                                                <input type="text" id="inputUmur" onClick="umur()" name="txtUmur" placeholder="Umur, Klik Disini" readonly="" />
                                            </span> Tahun
                                        </div>
                                    </div>
                                    <script>
                                        $(function () {
                                            $('#inputTanggalLahir').datepick({
                                                minDate: '-60Y',
                                                maxDate: '-18Y',
                                                dateFormat: 'dd-mm-yyyy'
                                            });
                                        });
//                                        window.onload=function(){
//                                            $('#inputTanggalLahir').on('change', function() {
//                                                var dob = new Date(this.value);
//                                                var today = new Date();
//                                                var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
//                                                $('#inputUmur').val(age);
//                                            });
//                                        }
                                        function umur() {
                                            var dob = $("#inputTanggalLahir").val();
                                            var now = new Date();
                                            var birthdate = dob.split("-");
                                            var born = new Date(birthdate[2], birthdate[1] - 1, birthdate[0]);
                                            age = get_age(born, now);
                                            alert(age);
                                            document.getElementById('inputUmur').value = age;
                                            return false;
                                        }
                                        function get_age(born, now) {
                                            var birthday = new Date(now.getFullYear(), born.getMonth(), born.getDate());
                                            if (now >= birthday)
                                                return now.getFullYear() - born.getFullYear();
                                            else
                                                return now.getFullYear() - born.getFullYear() - 1;
                                        }
                                    </script>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jenis Kelamin* </label>
                                        <div class="col-sm-8">
                                            <div class="radio">
                                                <label>
                                                    <input name="txtJekel" type="radio" class="ace" value="LAKI-LAKI" required=""/>
                                                    <span class="lbl"> Laki-laki</span>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input name="txtJekel" type="radio" class="ace" value="PEREMPUAN"/>
                                                    <span class="lbl"> Perempuan</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tinggi Badan </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputTinggiBadan" name="txtTinggiBadan" placeholder="Input Tinggi Badan" class="col-xs-12 col-sm-10" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Berat Badan </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputBeratBadan" name="txtBeratBadan" placeholder="Input Berat Badan" class="col-xs-12 col-sm-10" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Suku* </label>
                                        <div class="col-sm-8">
                                            <select class="col-xs-12 col-sm-10" name="txtSuku" required="">
                                                <option value=""> -- Silahkan pilih Suku</option>
                                                <?php
                                                foreach ($_getSuku as $rowSuku):
                                                    echo "<option value'$rowSuku->Suku'>$rowSuku->Suku</option>";
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Daerah Asal* </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputDaerahAsal" name="txtDaerahAsal" placeholder="Input Daerah Asal" class="col-xs-12 col-sm-10" required="" />
                                        </div>
                                    </div>
									<?php $this->load->view('registrasi/template/addprovinsi');?>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Bahasa Daerah </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputBahasaDaerah" name="txtBahasaDaerah" placeholder="Input Bahasa Daerah" class="col-xs-12 col-sm-10" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Agama* </label>
                                        <div class="col-sm-8">
                                            <select class="col-xs-12 col-sm-10" name="txtAgama">
                                                <option value=""> -- Silahkan pilih Agama</option>
                                                <?php
                                                foreach ($_getAgama as $rowAgama):
                                                    echo "<option value'$rowAgama->IDAgama'>$rowAgama->Agama</option>";
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Status Perkawinan* </label>
                                        <div class="col-sm-8">
                                            <select class="col-xs-12 col-sm-10" name="txtStatus" onChange="StatusChange(this.value);">
                                                <option value=""> -- Silahkan pilih Status Kawin</option>
                                                <?php
                                                foreach ($_getStatusKawin as $rowStatus):
                                                    echo "<option value'$rowStatus->ID'>$rowStatus->StatusKawin</option>";
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!--<?php //$this->load->view('registrasi/template/addkerabat');?>-->
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="txtkerabatterdekat"> Kerabat Terdekat* </label>
										<div class="col-sm-8">
											<input type="text" id="txtkerabatterdekat" name="txtkerabatterdekat" placeholder="Kerabat Terdekat" class="col-xs-12 col-sm-10" required maxlength="50" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="txtnohpkerabat">Nomor HP. Kerabat* </label>
										<div class="col-sm-8">
											<input type="text" id="txtnohpkerabat" name="txtnohpkerabat" placeholder="Nomor telepon" class="col-xs-12 col-sm-10" required maxlength="20" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="txtnohpkerabat">Hubungan dgn. Kerabat* </label>
										<div class="col-sm-8">
											<input type="text" id="txthubungan" name="txthubungan" placeholder="Hubungan" class="col-xs-12 col-sm-10" required maxlength="20" />
										</div>
									</div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Alamat Kerabat </label>
                                        <div class="col-sm-8">
                                            <textarea class="col-xs-12 col-sm-10" id="inputAlamatKerabat" name="txtAlamatKerabat" placeholder="Input Alamat Kerabat" ></textarea>
                                        </div>
                                    </div>

                                    <h4 class="header smaller lighter green">
                                        <i class="ace-icon fa fa-users bigger-140"></i>
                                        Data Suami/ Istri
                                    </h4>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nama Suami/ Istri </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputNamaPasangan" name="txtNamaPasangan" placeholder="Input Nama Suami/ Istri" class="col-xs-12 col-sm-10" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tangal Lahir Suami/ Istri </label>
                                        <div class="col-sm-8">
                                            <span class="input-icon">
                                                <input type="text" id="inputTglLahirPasangan" name="txtTglLahirPasangan" placeholder="Input Tanggal Lahir"/>
                                                <i class="ace-icon fa fa-calendar green"></i>
                                            </span> Format (dd-mm-yyyy)
                                        </div>
                                    </div>
                                    <script>
                                        $(function () {
                                            $("#inputTglLahirPasangan").datepick({
                                                minDate: '-50Y',
                                                maxDate: '-15Y',
                                                dateFormat: 'dd-mm-yyyy'
                                            });
                                        });
                                    </script>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Pekerjaan Suami/ Istri </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputPekerjaanPasangan" name="txtPekerjaanPasangan" placeholder="Input Pekerajaan Suami/ Istri" class="col-xs-12 col-sm-10" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Alamat Suami/ Istri </label>
                                        <div class="col-sm-8">
                                            <textarea class="col-xs-12 col-sm-10" id="inputAlamatPasangan" name="txtAlamatPasangan" placeholder="Input Alamat Suami/ Istri" ></textarea>
                                        </div>
                                    </div>

                                    <h4 class="header smaller lighter green">
                                        <i class="ace-icon fa fa-users bigger-140"></i>
                                        Data Anak
                                    </h4>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jumlah Anak </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputJumlahAnak" name="txtJumlahAnak" placeholder="Jumlah Anak Auto" class="col-xs-12 col-sm-10" readonly=""/>
                                        </div>
                                    </div>
                                    <div id="listAnak" style="display: none">
                                        <div class="col-sm-12">
                                            <input type="button" class="btn btn-xs btn-primary" value="Tambah" onclick="addRowAnak()" />
                                            <input type="button" class="btn btn-xs btn-danger" value="Hapus" onclick="deleteRowAnak()" />
                                        </div>
                                        <div class="col-sm-12 column table table-responsive">
                                            <table class="table table-bordered table-hover" id="dataTable1">
                                                <tbody>
                                                    <tr>
                                                        <td><input type="checkbox" name="chk[]"></td>
                                                        <td >
                                                            <input type="text" id="inputNamaAnak" name="txtNamaAnak[]" placeholder="Nama Anak" class="col-2" />
                                                        </td>
                                                        <td >
                                                            <input type="text" id="inputTempatLahirAnak" name="txtTempatLahirAnak[]" placeholder="Tempat Lahir" class="col-2" />
                                                        </td>
                                                        <td >
                                                            <span class="input-icon">
                                                                <input type="date" id="inputTanggalLahirAnak" name="txtTanggalLahirAnak[]" placeholder="Input Tanggal Lahir" class="col-2 form-control" />
                                                                <i class="ace-icon fa fa-calendar green"></i>
                                                            </span>
                                                        </td>
                                                        <td >
                                                            <select class="col-2" id="inputJekelAnak" name="txtJekelAnak[]" >
                                                                <option value="">-- Pilih Jenis Kelamin</option>
                                                                <option value="M">Laki-laki</option>
                                                                <option value="F">Perempuan</option>
                                                            </select>
                                                        </td>
                                                        <td >
                                                            <input type="text" name='txtAlamatAnak[]' placeholder='Alamat' class="col-2" />
                                                        </td>                                                   
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="alert alert-block alert-info">
                                            <button type="button" class="close" data-dismiss="alert">
                                                <i class="ace-icon fa fa-times"></i>
                                            </button>
                                            <p><i class="ace-icon fa fa-info"></i>&nbsp; Field tibak boleh ada yang kosong!<p>
                                        </div>
                                    </div>

                                    <h4 class="header smaller lighter green">
                                        <i class="ace-icon fa fa-users bigger-140"></i>
                                        Data Keluarga
                                    </h4>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nama Bapak Kandung* </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputNamaBapak" name="txtNamaBapak" placeholder="Input Nama Bapak Kandung" class="col-xs-12 col-sm-10" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nama Ibu Kandung* </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputNamaIbu" name="txtNamaIbu" placeholder="Input Nama Ibu Kandung" class="col-xs-12 col-sm-10" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Pekerjaan Orang Tua* </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputPekerjaanOrtu" name="txtPekerjaanOrtu" placeholder="Input Pekerjaan Orang Tua" class="col-xs-12 col-sm-10" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jumlah Saudara* </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputJumlahSaudara" name="txtJumlahSaudara" placeholder="Input Jumlh Saudara" class="col-xs-12 col-sm-10" onkeypress="return isNumber(event)" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Anak ke* </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputAnakKe" name="txtAnakKe" placeholder="Input Anak ke Berapa" class="col-xs-12 col-sm-10" onkeypress="return isNumber(event)"  required=""/>
                                        </div>
                                    </div>

                                    <h4 class="header smaller lighter green">
                                        <i class="ace-icon fa fa-home bigger-140"></i>
                                        Pendidikan Terakhir
                                    </h4>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jenjang Pendidikan * </label>
                                        <div class="col-sm-8">
                                            <select class="col-xs-12 col-sm-10" id="inputPendidikan" name="txtPendidikan" onchange="PendidikanChange(this.value);" required="">
                                                <option value=""> -- Silahkan pilih Pendidikan Terakhir</option>
                                                <?php
                                                foreach ($_getPendidikan as $rowPendidikan):
                                                    echo "<option value'$rowPendidikan->ID'>$rowPendidikan->Pendidikan</option>";
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jurusan </label>
                                        <div class="col-sm-8">
                                            <select class="col-xs-12 col-sm-10" id="inputJurusan" name="txtJurusan">
                                                <option value=""> -- Silahkan pilih Jurusan</option>
                                                <?php
                                                foreach ($_getJurusan as $rowJurusan):
                                                    echo "<option value'$rowJurusan->ID'>$rowJurusan->Jurusan</option>";
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="inputSekolah" style="display: block">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nama Sekolah </label>
                                            <div class="col-sm-8">
                                                <input type="text" id="inputShcool" name="txtShcool" placeholder="Input Nama Sekolah" class="col-xs-12 col-sm-10" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nilai Rata-rata </label>
                                            <div class="col-sm-8">
                                                <input type="text" id="inputNilai" name="txtNilai" placeholder="Input Nilai Rata-rata" class="col-xs-12 col-sm-10" />
                                            </div>
                                        </div>
                                    </div>
                                    <div id="inputUniversitas" style="display: none">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nama Universitas </label>
                                            <div class="col-sm-8">
                                                <input type="text" id="inputUniv" name="txtUniv" placeholder="Input Nama Universitas" class="col-xs-12 col-sm-10" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> IPK </label>
                                            <div class="col-sm-8">
                                                <input type="text" id="inputIPK" name="txtIPK" placeholder="Input IPK (Skala : 4.00)" class="col-xs-12 col-sm-10" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tahun Masuk </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputTahunMasuk" name="txtTahunMasuk" placeholder="Input Tahun Masuk" class="col-xs-12 col-sm-10" onkeypress="return isNumber(event)" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tahun Lulus </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputTahunLulus" name="txtTahunLulus" placeholder="Input Tahun Lulus" class="col-xs-12 col-sm-10" onkeypress="return isNumber(event)" />
                                        </div>
                                    </div>

                                    <h4 class="header smaller lighter green">
                                        <i class="ace-icon fa fa-gavel bigger-140"></i>
                                        Riwayat Pekerjaan
                                    </h4>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Pengalaman Kerja </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputPengalamanKerja" maxlength='99' name="txtPengalamanKerja" placeholder="Input Pengalaman Kerja" class="col-xs-12 col-sm-10" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> <small>Keahlian/ Keterampilan yang dikuasai</small></label>
                                        <div class="col-sm-8">
                                            <textarea class="col-xs-12 col-sm-10 limited" maxlength='99' id="inputKeahlian" name="txtKeahlian" placeholder="Input Keahlian/ Keterampilan yang dikuasai"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> <small>Pernah Kerja di SAMBU GROUP* </small></label>
                                        <div class="col-sm-8">
                                            <div class="radio">
                                                <label>
                                                    <input name="txtPernahRSUP" type="radio" class="ace" value="YA" required="" onClick="PernahRSUPChange(this.value);"/>
                                                    <span class="lbl"> YA</span>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input name="txtPernahRSUP" type="radio" class="ace" value="TIDAK" checked onClick="PernahRSUPChange(this.value);"/>
                                                    <span class="lbl"> TIDAK </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Bagian/ Department </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputBagian" name="txtBagian" placeholder="Jika Ya, Di Bagian/ Department mana?" class="col-xs-12 col-sm-10" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> <small>Ada Keluarga yg Bekerja di SAMBU GROUP* </small></label>
                                        <div class="col-sm-8">
                                            <div class="radio">
                                                <label>
                                                    <input name="txtAdaKeluarga" type="radio" class="ace" value="YA" required="" onClick="KeluargaDiRSUP(this.value);"/>
                                                    <span class="lbl"> YA</span>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input name="txtAdaKeluarga" type="radio" class="ace" value="TIDAK" checked onClick="KeluargaDiRSUP(this.value);"/>
                                                    <span class="lbl"> TIDAK</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="listkeluarga" style="display: none">
                                        <div class="col-sm-12">
                                            <input type="button" class="btn btn-xs btn-primary" value="Tambah" onclick="addRow('dataTable2')" />
                                            <input type="button" class="btn btn-xs btn-danger" value="Hapus" onclick="deleteRow('dataTable2')" />
                                        </div>
                                        <div class="col-sm-12 column table table-responsive">
                                            <table class="table table-bordered table-hover" id="dataTable2">
                                                <tbody>
                                                    <tr>
                                                        <td><input type="checkbox" name="chk[]"></td>
                                                        <td class="text-center" width="23%">
                                                            <input type="text" name='kelnama[]'  placeholder='Nama' class="col-2"  />
                                                        </td>
                                                        <td class="text-center" width="15%">
                                                            <input type="text" name='kelbagian[]' placeholder='Bagian' class="col-2"  />
                                                        </td>
                                                        <td class="text-center" width="15%">
                                                            <input type="text" name='kelpemborong[]' placeholder='Pemborong' class="col-2" />
                                                        </td>
                                                        <td class="text-center" width="15%">
                                                            <input type="text" name='kelhubungan[]' placeholder='Hubungan Keluarga' class="col-2" />
                                                        </td>
                                                        <td class="text-center" width="30%">
                                                            <input type="text" name='kelalamat[]' placeholder='Alamat' class="col-2" />
                                                        </td>                                                   
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="alert alert-block alert-info">
                                            <button type="button" class="close" data-dismiss="alert">
                                                <i class="ace-icon fa fa-times"></i>
                                            </button>
                                            <p><i class="ace-icon fa fa-info"></i>&nbsp; Field tibak boleh ada yang kosong!<p>
                                        </div>
                                    </div>

                                    <h4 class="header smaller lighter green">
                                        <i class="ace-icon fa fa-info-circle bigger-140"></i>
                                        Informasi lainnya
                                    </h4>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Hobby/ Kegemaran </label>
                                        <div class="col-sm-8">
                                            <textarea class="col-xs-12 col-sm-10 limited" maxlength='99' id="inputHobby" name="txtHobby" placeholder="Input Hobby atau Kegemaran"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Kegiatan Ekstra</label>
                                        <div class="col-sm-8">
                                            <textarea class="col-xs-12 col-sm-10 limited" maxlength='99' id="inputKegiatanEkstra" name="txtKegiatanEkstra" placeholder="Input Kegiatan Ekstra"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Kegiatan Organisasi</label>
                                        <div class="col-sm-8">
                                            <textarea class="col-xs-12 col-sm-10 limited" maxlength='99' id="inputOrganisasi" name="txtOrgnanisasi" placeholder="Input Kegiatan Organisasi"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Keadaan Fisik*</label>
<!--                                        <div class="col-sm-8">
                                            <select class="col-xs-12 col-sm-10" name="txtKeadaanFisik" required="">
                                                <option value="">-- Pilih Keadaan Fisik</option>
                                                <option value="Cacat">Cacat</option>
                                                <option value="Normal">Tidak cacat</option>
                                            </select>
                                        </div>-->
                                        <div class="col-sm-8">
                                            <div class="radio">
                                                <label>
                                                    <input name="txtKeadaanFisik" type="radio" class="ace" value="CACAT" required="" onClick="DisabledInput(this.value, 'inputCacatApa');"/>
                                                    <span class="lbl"> Cacat</span>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input name="txtKeadaanFisik" type="radio" class="ace" value="NORMAL" checked onClick="DisabledInput(this.value, 'inputCacatApa');"/>
                                                    <span class="lbl"> Tidak Cacat </span>
                                                </label>
                                            </div>
                                            <input type="text" id="inputCacatApa" name="txtCacatApa" placeholder="Jika Ya, Cacat apa?" class="col-xs-12 col-sm-10"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Pernah Mengidap Penyakit* </label>
                                        <div class="col-sm-8">
                                            <div class="radio">
                                                <label>
                                                    <input name="txtPernahPenyakit" type="radio" class="ace" value="YA" required="" onClick="DisabledInput(this.value, 'inputPenyakit');"/>
                                                    <span class="lbl"> YA</span>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input name="txtPernahPenyakit" type="radio" class="ace" value="TIDAK" checked onClick="DisabledInput(this.value, 'inputPenyakit');"/>
                                                    <span class="lbl"> TIDAK </span>
                                                </label>
                                            </div>
                                            <input type="text" id="inputPenyakit" name="txtPenyakit" placeholder="Jika Ya, Penyakit apa?" class="col-xs-12 col-sm-10"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Pernah Terlibat Kriminal* </label>
                                        <div class="col-sm-8">
                                            <div class="radio">
                                                <label>
                                                    <input name="txtPernahKriminal" type="radio" class="ace" value="YA" required="" onClick="DisabledInput(this.value, 'inputKriminal');"/>
                                                    <span class="lbl"> YA</span>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input name="txtPernahKriminal" type="radio" class="ace" value="TIDAK" checked onClick="DisabledInput(this.value, 'inputKriminal');"/>
                                                    <span class="lbl"> TIDAK </span>
                                                </label>
                                            </div>
                                            <input type="text" id="inputKriminal" name="txtKriminal" placeholder="Jika IY, Tindakan Kriminal Apa yang Dilakukan?" class="col-xs-12 col-sm-10"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Apakah Bertato?* </label>
                                        <div class="col-sm-8">
                                            <div class="radio">
                                                <label>
                                                    <input name="txtBertato" type="radio" class="ace" value="YA" required="" onClick="DisabledInput(this.value, 'inputTatoDimana');"/>
                                                    <span class="lbl"> YA</span>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input name="txtBertato" type="radio" class="ace" checked value="TIDAK" onClick="DisabledInput(this.value, 'inputTatoDimana');"/>
                                                    <span class="lbl"> TIDAK </span>
                                                </label>
                                            </div>
                                            <input type="text" id="inputTatoDimana" name="txtTatoDimana" placeholder="Jika IY, Tato dibagian apa?" class="col-xs-12 col-sm-10"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Apakah Bertindik?* </label>
                                        <div class="col-sm-8">
                                            <div class="radio">
                                                <label>
                                                    <input name="txtBertindik" type="radio" class="ace" value="YA" required=""/>
                                                    <span class="lbl"> YA</span>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input name="txtBertindik" type="radio" class="ace" checked value="TIDAK"/>
                                                    <span class="lbl"> TIDAK </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> <small>Bersedia rambut pendek (Laki-laki)?* </small></label>
                                        <div class="col-sm-8">
                                            <div class="radio">
                                                <label>
                                                    <input name="txtRambutPendek" type="radio" class="ace" value="YA" checked required=""/>
                                                    <span class="lbl"> YA</span>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input name="txtRambutPendek" type="radio" class="ace" value="TIDAK"/>
                                                    <span class="lbl"> TIDAK </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> <small>Bersedia Diberhentikan, Jika Kinerja Dinilai Kurang?* </small></label>
                                        <div class="col-sm-8">
                                            <div class="radio">
                                                <label>
                                                    <input name="txtBerhentikan" type="radio" class="ace" value="YA" checked required=""/>
                                                    <span class="lbl"> YA</span>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input name="txtBerhentikan" type="radio" class="ace" value="TIDAK"/>
                                                    <span class="lbl"> TIDAK </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
									
                                    <h4 class="header smaller lighter green">
                                        <i class="ace-icon fa fa-user"></i>
                                        Ahli Waris
                                    </h4>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nama Ahli Waris* </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputAhliWaris" maxlength='99' name="txtAhliWaris" placeholder="Input Nama Ahli Waris" class="col-xs-12 col-sm-10" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jenis Kelamin Ahli Waris* </label>
                                        <div class="col-sm-8">
                                            <div class="radio">
                                                <label>
                                                    <input name="txtJekelAhliWaris" type="radio" class="ace" value="LAKI-LAKI" required=""/>
                                                    <span class="lbl"> Laki-laki</span>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input name="txtJekelAhliWaris" type="radio" class="ace" value="PEREMPUAN"/>
                                                    <span class="lbl"> Perempuan</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Alamat Ahli Waris* </label>
                                        <div class="col-sm-8">
                                            <textarea class="col-xs-12 col-sm-10" id="inputAlamatAhliWaris" name="txtAlamatAhliWaris" placeholder="Input Alamat" required=""></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Hubungan Ahli Waris* </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="inputHubunganAhliWaris" maxlength='99' name="txtHubunganAhliWaris" placeholder="Input Hubungan Ahli Waris" class="col-xs-12 col-sm-10" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="txtnohpkerabat">Nomor HP Ahli Waris* </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="txtnohpkerabatAhliWaris" name="txtnohpkerabatAhliWaris" placeholder="Nomor telepon Ahli Waris" class="col-xs-12 col-sm-10" required maxlength="20" />
                                        </div>
                                    </div>
                                    <h4 class="header smaller lighter green">
                                        <i class="ace-icon fa fa-bullhorn"></i>
                                        Sosial Media yang Aktif
                                    </h4>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> </label>
                                        <div class="input-group col-sm-8">
                                            <span class="input-group-addon"><i class="fa fa-facebook-square text-primary bigger-120"></i></span>
                                            <input type="text" id="inputFacebook" name="txtFacebook" placeholder="http://www.facebook.com/_________" class=" form-controlcol-xs-12 col-sm-10" />
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> </label>
                                        <div class="input-group col-sm-8">
                                            <span class="input-group-addon"><i class="fa fa-twitter-square light-blue bigger-120"></i></span>
                                            <input type="text" id="inputTwitter" name="txtTwitter" placeholder="http://www.twitter.com/_________" class=" form-controlcol-xs-12 col-sm-10" />
                                            </span>
                                        </div>
                                    </div>
                                    <div class="clearfix form-actions">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button class="btn btn-info" type="submit">
                                                <i class="ace-icon fa fa-check bigger-110"></i>
                                                Submit
                                            </button>
                                            <button class="btn" type="reset">
                                                <i class="ace-icon fa fa-undo bigger-110"></i>
                                                Reset
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </fieldset>
        </form>

    </div>
</div>

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

    function PendidikanChange(objvalue) {
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

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<script>
    /*
     * Date Format 1.2.3
     * (c) 2007-2009 Steven Levithan <stevenlevithan.com>
     * MIT license
     *
     * Includes enhancements by Scott Trenda <scott.trenda.net>
     * and Kris Kowal <cixar.com/~kris.kowal/>
     *
     * Accepts a date, a mask, or a date and a mask.
     * Returns a formatted version of the given date.
     * The date defaults to the current date/time.
     * The mask defaults to dateFormat.masks.default.
     */

    var dateFormat = function () {
        var token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
                timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
                timezoneClip = /[^-+\dA-Z]/g,
                pad = function (val, len) {
                    val = String(val);
                    len = len || 2;
                    while (val.length < len)
                        val = "0" + val;
                    return val;
                };

        // Regexes and supporting functions are cached through closure
        return function (date, mask, utc) {
            var dF = dateFormat;

            // You can't provide utc if you skip other args (use the "UTC:" mask prefix)
            if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) {
                mask = date;
                date = undefined;
            }

            // Passing date through Date applies Date.parse, if necessary
            date = date ? new Date(date) : new Date;
            if (isNaN(date))
                throw SyntaxError("invalid date");

            mask = String(dF.masks[mask] || mask || dF.masks["default"]);

            // Allow setting the utc argument via the mask
            if (mask.slice(0, 4) == "UTC:") {
                mask = mask.slice(4);
                utc = true;
            }

            var _ = utc ? "getUTC" : "get",
                    d = date[_ + "Date"](),
                    D = date[_ + "Day"](),
                    m = date[_ + "Month"](),
                    y = date[_ + "FullYear"](),
                    H = date[_ + "Hours"](),
                    M = date[_ + "Minutes"](),
                    s = date[_ + "Seconds"](),
                    L = date[_ + "Milliseconds"](),
                    o = utc ? 0 : date.getTimezoneOffset(),
                    flags = {
                        d: d,
                        dd: pad(d),
                        ddd: dF.i18n.dayNames[D],
                        dddd: dF.i18n.dayNames[D + 7],
                        m: m + 1,
                        mm: pad(m + 1),
                        mmm: dF.i18n.monthNames[m],
                        mmmm: dF.i18n.monthNames[m + 12],
                        yy: String(y).slice(2),
                        yyyy: y,
                        h: H % 12 || 12,
                        hh: pad(H % 12 || 12),
                        H: H,
                        HH: pad(H),
                        M: M,
                        MM: pad(M),
                        s: s,
                        ss: pad(s),
                        l: pad(L, 3),
                        L: pad(L > 99 ? Math.round(L / 10) : L),
                        t: H < 12 ? "a" : "p",
                        tt: H < 12 ? "am" : "pm",
                        T: H < 12 ? "A" : "P",
                        TT: H < 12 ? "AM" : "PM",
                        Z: utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
                        o: (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
                        S: ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
                    };

            return mask.replace(token, function ($0) {
                return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
            });
        };
    }();

    // Some common format strings
    dateFormat.masks = {
        "default": "ddd mmm dd yyyy HH:MM:ss",
        shortDate: "m-d-yy",
        mediumDate: "mmm d, yyyy",
        longDate: "mmmm d, yyyy",
        fullDate: "dddd, mmmm d, yyyy",
        shortTime: "h:MM TT",
        mediumTime: "h:MM:ss TT",
        longTime: "h:MM:ss TT Z",
        isoDate: "yyyy-mm-dd",
        isoTime: "HH:MM:ss",
        isoDateTime: "yyyy-mm-dd'T'HH:MM:ss",
        isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
    };

    // Internationalization strings
    dateFormat.i18n = {
        dayNames: [
            "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
            "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
        ],
        monthNames: [
            "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
            "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
        ]
    };

    // For convenience...
    Date.prototype.format = function (mask, utc) {
        return dateFormat(this, mask, utc);
    };





    today = new Date();
    var dateString = today.format("dd-mm-yyyy");
</script>
<script>
  function validateNumber(event) {
     var key = window.event ? event.keyCode : event.which;
     if (event.keyCode === 8 || event.keyCode === 46) {
         return true;
     } else if ( key < 48 || key > 57 ) {
         return false;
     } else {
         return true;
     }
 };

 $(function(){
     $('#txtnohpkerabat').keypress(validateNumber);
 })
</script>