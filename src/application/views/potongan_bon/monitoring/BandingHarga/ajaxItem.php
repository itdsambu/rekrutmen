<div class="form-group">
    <label class="col-lg-2 control-label">Nama Item</label>
    <div class="col-sm-4">
        <select class="form-control select2" name="txtItem" id="item">
            <option value="">- Pilih Nama Item -</option>
            <?php foreach($GetItem as $itm){
                echo "<option value='$itm->ItemID'>".$itm->NamaItem."</option>";
            } ?>
        </select>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>