<?php foreach ($_getData as $key) {?>
    <div class="form-group">
        <label class="col-lg-2 col-sm-3 control-label">Pemborong</label>
        <div class="col-sm-4">
            <input type="text" name="txtPemborong" id="pemborong" class="form-control" value="<?php echo $key[0]->Pemborong?>" readonly>
            <input type="hidden" name="txtNofix" id="nofix" class="form-control" value="<?php echo $key->nofix?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 col-sm-3 control-label">Nama Lengkap</label>
        <div class="col-sm-4">
            <input type="text" name="txtnama" id="nama" class="form-control" value="<?php echo $key[0]->Nama?>" readonly>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 col-sm-3 control-label">Dept/Bagian</label>
        <div class="col-sm-4">
            <input type="text" name="txtdept" id="dept" class="form-control" value="<?php echo $key[0]->Bagian?>" readonly>
        </div>
    </div>
<?php }?>