<div class="row">
    <div class="col-xs-12">
        <?php foreach ($_getKel as $rowKel): ?>
        <form class="form-horizontal" role="form" name="updateAnak" method="POST" action="<?php echo base_url("ubahDataKaryawan/updateKeluarga");?>">
            <div class="col-xs-12 col-sm-12">
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="inputNamaKel"> Nama </label>
                    <div class="col-sm-8">
                        <input type="text" id="inputNamaKel" name="txtNamaKel" class="col-xs-6" value="<?php echo ucwords(strtolower($rowKel->Nama));?>">
                        <input type="hidden" name="detailID" value="<?php echo $rowKel->DetailID;?>">
                        <input type="hidden" name="txtHdrID" value="<?php echo $rowKel->HeaderID;?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="inputDepartemen"> Departemen </label>
                    <div class="col-sm-8">
                        <input type="text" id="inputDepartemen" name="txtDepartemen" class="col-xs-6" value="<?php echo ucwords(strtolower($rowKel->Departemen));?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="inputPemborong"> Pemborong </label>
                    <div class="col-sm-8">
                        <input type="text" id="inputPemborong" name="txtPemborong" class="col-xs-6" value="<?php echo ucwords(strtolower($rowKel->Pemborong));?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="inputHubunganKeluarga"> Hubungan Keluarga </label>
                    <div class="col-sm-8">
                        <input type="text" id="inputHubunganKeluarga" name="txtHubungan" class="col-xs-6" value="<?php echo ucwords(strtolower($rowKel->HubunganKeluarga));?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="inputAlamat"> Alamat </label>
                    <div class="col-sm-8">
                        <textarea id="inputAlamat" name="txtAlamat" class="col-xs-6" ><?php echo ucwords(strtolower($rowKel->Alamat));?></textarea>
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