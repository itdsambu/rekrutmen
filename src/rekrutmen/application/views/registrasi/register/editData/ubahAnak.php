<link rel="stylesheet" href="<?php echo base_url();?>assets/css/select2.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/dp/smoothness.datepick.css" />

<!--<script src="<?php echo base_url();?>assets/dp/jquery-1.10.2.js"></script>-->
<script src="<?php echo base_url();?>assets/dp/jquery.datepick.js"></script>
<script src="<?php echo base_url();?>assets/dp/jquery.plugin.js"></script>

<!-- page specific plugin scripts -->
<script src="<?php echo base_url();?>assets/js/fuelux/fuelux.wizard.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>assets/js/additional-methods.js"></script>
<script src="<?php echo base_url();?>assets/js/bootbox.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.maskedinput.js"></script>
<script src="<?php echo base_url();?>assets/js/select2.js"></script>

<div class="page-header">
    <h1>
        Perubahan Data
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Anak 
        </small>
    </h1>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php foreach ($_getAnak as $rowAnak): ?>
        <form class="form-horizontal" role="form" name="updateAnak" method="POST" action="<?php echo base_url("ubahDataKaryawan/updateAnak");?>">
            <div class="col-xs-12 col-sm-12">
                <h4 class="header smaller lighter green">
                    <i class="ace-icon fa fa-users bigger-140"></i>
                    Edit Data Anak <strong class="green"><?php foreach ($_getData as $row){ echo ucwords(strtolower($row->Nama));}?></strong>
                    <input type="hidden" name="txtHdrID" value="<?php foreach ($_getData as $row){ echo ucwords(strtolower($row->HeaderID));}?>">
                </h4>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="inputNamaAnak"> Nama Anak </label>
                    <div class="col-sm-8">
                        <input type="text" id="inputNamaAnak" name="txtNamaAnak" class="col-xs-6" value="<?php echo ucwords(strtolower($rowAnak->Nama));?>">
                        <input type="hidden" id="inputdetailID" name="detailID" class="col-xs-6" value="<?php echo $rowAnak->DetailID;?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="inputJekelAnak"> Jenis Kelamin </label>
                    <div class="col-sm-8">
                        <?php
                            if($rowAnak->JenisKelamin == 'M'){
                                $jM = "checked";
                                $jF = "";
                            }  else {
                                $jM = "";
                                $jF = "checked";
                            }
                        ?>
                        <div class="radio">
                            <label>
                                <input id="inputJekelAnak" name="txtJekelAnak" type="radio" class="ace" value="M" <?php echo $jM;?> >
                                <span class="lbl"> Laki-laki</span>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input id="inputJekelAnak" name="txtJekelAnak" type="radio" class="ace" value="F" <?php echo $jF;?> >
                                <span class="lbl"> Perempuan</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="inputTmpLahirAnak"> Tempat Lahir </label>
                    <div class="col-sm-8">
                        <input type="text" id="inputTmpLahirAnak" name="txtTmpLahirAnak" class="col-xs-6" value="<?php echo ucwords(strtolower($rowAnak->TempatLahir));?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="inputTglLahirAnak"> Tanggal Lahir </label>
                    <div class="col-sm-8">
                        <input id="inputTglLahirAnak" type="text"  name="txtTglLahirAnak" class="col-xs-6" value="<?php echo date("d-m-Y", strtotime($rowAnak->TglLahir));?>">
                    </div>
                </div>
                <script>
                    $(function() {
                        $('#inputTglLahirAnak').datepick({
                            dateFormat: 'dd-mm-yyyy'
                        });
                    });
                </script>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="inputAlamatAnak"> Alamat </label>
                    <div class="col-sm-8">
                        <textarea id="inputAlamatAnak" name="txtAlamatAnak" class="col-xs-6" ><?php echo ucwords(strtolower($rowAnak->Alamat));?></textarea>
                    </div>
                </div>
            </div>
            <div class="hr hr-24"></div>
            <div class="col-xs-12">
                <div class="clearfix form-actions">
                    <div class="center">
                        <button class="btn btn-info" type="submit" name="update">
                            <i class="ace-icon fa fa-edit bigger-110"></i>
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <?php endforeach; ?>
    </div>
</div>
