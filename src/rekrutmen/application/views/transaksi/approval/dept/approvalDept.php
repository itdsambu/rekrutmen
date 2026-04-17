<h4 class="row header smaller lighter green">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-files-o"></i>
        Approval terhadap ID Issue <strong><?php foreach ($getTran as $row){ echo $row->DetailID;}?></strong>
    </span>
</h4>
<?php 
    $att = array('class'=>'form-horizontal', 'role'=>'form');
    echo form_open('approval/approvalDept', $att);
?>
<input name="txtID" value="<?php foreach ($getTran as $row){ echo $row->DetailID;}?>" type="hidden" />
<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right bolder" for="form-field-1"> Approval </label>
    <div class="col-sm-8">
        <div class="radio">
            <label>
                <input name="txtHasil" type="radio" class="ace" value="1" required="" checked/>
                <span class="lbl"> Disetujui</span>
            </label>
        </div>
        <div class="radio">
            <label>
                <input name="txtHasil" type="radio" class="ace" value="2" />
                <span class="lbl"> Ditolak</span>
            </label>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right bolder" for="form-field-1"> Keterangan/ Catatan </label>
    <div class="col-sm-8">
        <textarea id="inputKeterangan" name="txtKeterangan" class="col-xs-12 col-sm-10" ></textarea>
    </div>
</div>
<div class="form-group">
    <input class="btn btn-sm btn-primary" type="submit" value="Simpan" name="btnSimpan" />
</div>
</form>

<h4 class="row header smaller lighter blue">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-info-circle"></i>
        Keterangan lainnya
    </span>
</h4>
<div class="table-responsive">
    <table class="table table-striped">
        <?php foreach ($getTran as $row):?>
        <tr>
            <th class="col-sm-2">Ketentuan</th>
            <td>
                <?php echo $row->IssueRemark;?>
            </td>
        </tr>
        <tr>
            <th class="col-sm-2">Batasan Umur</th>
            <td>
                <?php echo $row->Umur;?>
            </td>
        </tr>
        <tr>
            <th class="col-sm-2">Pedidikan</th>
            <td>
                <?php echo $row->Pendidikan;?>
            </td>
        </tr>
        <tr>
            <th class="col-sm-2">Jurusan</th>
            <td>
                <?php echo $row->Jurusan;?>
            </td>
        </tr>
        <tr>
            <th class="col-sm-2">Gender</th>
            <td>
                <?php echo $row->JenisKelamin;?>
            </td>
        </tr>
        <tr>
            <th class="col-sm-2">Status Pernikahan</th>
            <td>
                <?php echo $row->StatusPersonal;?>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
</div>

<h4 class="row header smaller lighter blue">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-files-o"></i>
        Edit ID Issue <strong><?php foreach ($getTran as $row){ echo $row->DetailID;}?></strong>
    </span>
</h4>
<?php 
    echo form_open('approval/updateIssueByDept', $att);
?>
    <input name="txtID" value="<?php foreach ($getTran as $row){ echo $row->DetailID;}?>" type="hidden" />
    <?php foreach ($getTran as $row): ?>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            Target </label>
        <div class="col-sm-9">
            <input type="number" id="inputTarget" name="txtTarget" onchange="changePermintaan()"
                   placeholder="Input Target" class="col-xs-12 col-sm-10" required="required" value="<?php echo $row->TKTarget?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            Tersedia </label>
        <div class="col-sm-9">
            <input type="number" id="inputTersedia" name="txtTersedia" onchange="changePermintaan()" value="<?php echo $row->TKSedia?>"
                   placeholder="Input Karyawan yang tersedia" class="col-xs-12 col-sm-10" required="required"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            Permintaan </label>
        <div class="col-sm-9">
            <input type="number" id="inputPermintaan" name="txtPermintaan"  value="<?php echo $row->TKPermintaan?>"
                   class="col-xs-12 col-sm-10" readonly="" required="required"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            Keterangan </label>
        <div class="col-sm-9">
            <textarea id="inputKeterangan" name="txtKeterangan" class="col-xs-12 col-sm-10" onclick="changePermintaan()" ><?php echo $row->IssueRemark?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            Umur <small>(optional)</small> </label>
        <div class="col-sm-9">
            <input type="text" id="inputUmur" name="txtUmur" value="<?php echo $row->Umur?>"
                   placeholder="Input Umur" class="col-xs-12 col-sm-10" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            Pilih Pendidikan <small>(optional)</small>
        </label>
        <div class="col-sm-8">
            <select class="form-control" id="inputPemborong" name="comboPendidikan">
                <option value=""> -- Pilih Pendidikan </option>
                <option value="Semua" <?php if($row->Pendidikan == 'Semua'){ echo 'selected';}?> > Semua Jenjang Pendidikan </option>
                <?php foreach ($getPend as $rowPend): ?>
                <option value="<?php echo $rowPend->Pendidikan; ?>"  <?php if($rowPend->Pendidikan == $row->Pendidikan){ echo 'selected';}else{ echo '';}?> ><?php echo $rowPend->Pendidikan;
                    ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            Pilih Jurusan <small>(optional)</small>
        </label>
        <div class="col-sm-8">
            <select class="form-control" id="inputPemborong" name="comboJurusan">
                <option value=""> -- Pilih Jurusan </option>
                <option value="Semua" <?php if($row->Jurusan == 'Semua'){ echo 'selected';}?> > Semua Jurusan </option>
                <?php foreach ($getJurs as $rowJurs): ?>
                <option value="<?php echo $rowJurs->Jurusan; ?>" <?php if($rowJurs->Jurusan == $row->Jurusan){ echo 'selected';}else{ echo '';}?> ><?php echo $rowJurs->Jurusan;
                    ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            Pilih Jenis Kelamin <small>(optional)</small>
        </label>
        <div class="col-sm-8">
            <select class="form-control" id="inputPemborong" name="comboJekel">
                <option value=""> -- Pilih Jenis Kelamin </option>
                <option value="Semua" <?php if($row->JenisKelamin == 'Semua'){ echo 'selected';}?> > Semua </option>
                <option value="Pria" <?php if($row->JenisKelamin == 'Pria'){ echo 'selected';}?> > Hanya Laki-laki </option>
                <option value="Wanita" <?php if($row->JenisKelamin == 'Wanita'){ echo 'selected';}?> > Hanya Perempuan </option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            Pilih Status Personal <small>(optional)</small>
        </label>
        <div class="col-sm-8">
            <select class="form-control" id="inputStatus" name="comboStatus">
                <option value=""> -- Pilih Status Personal </option>
                <option value="Semua" <?php if($row->StatusPersonal == 'Semua'){ echo 'selected';}?> > Semua </option>
                <?php foreach ($getSKwn as $rowSKwn): ?>
                <option value="<?php echo $rowSKwn->StatusKawin; ?>" <?php if($rowSKwn->StatusKawin == $row->StatusPersonal){ echo 'selected';}else{ echo '';}?> ><?php echo $rowSKwn->StatusKawin;
                    ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <?php endforeach; ?>
    <div class="form-group">
        <input class="btn btn-sm btn-primary" type="submit" value="Edit" name="btnSimpan" />
    </div>
</form>
<script>
    function changePermintaan(){
        var target  = parseInt(document.getElementById('inputTarget').value);
        var sedia   = parseInt(document.getElementById('inputTersedia').value);
        var minta   = 0;
        
        minta = target-sedia;
        
        document.getElementById('inputPermintaan').value = minta;
    }
</script>
