<input type="hidden" name="txtSubPemborong" id="subpemborong" class="form-control" value="<?= $_getDataSub[0]->IDSubPemborong ?>" readonly required>
<input type="text" class="form-control" value="<?= $_getDataSub[0]->Perusahaan ?>" readonly required>

<script>
    $(document).ready(function() {
        get_item_pemborong();
    });
</script>