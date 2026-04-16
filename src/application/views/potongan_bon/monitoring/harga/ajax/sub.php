<div class="form-group">
    <label class="col-lg-2 control-label">CV Perusahaan</label>
    <div class="col-sm-4" id="tblSub">
        <!-- <select class="form-control" name="txtSubPemborong" id="subpemborong">
            <option value="">-- Pilih Sub Pemborong --</option>';
            <?php foreach($_getSubPemborong as $sub){
                echo "<option value='$sub->IDSubPemborong'>$sub->NamaSub</option>";
            } ?>
        </select> -->
        <input type="hidden" name="txtSubPemborong" id="subpemborong" class="form-control" value="<?= $_getSubPemborong[0]->IDSubPemborong ?>" readonly required>
    <input type="text" class="form-control" value="<?= $_getSubPemborong[0]->Perusahaan ?>" readonly required>
    </div>
</div>