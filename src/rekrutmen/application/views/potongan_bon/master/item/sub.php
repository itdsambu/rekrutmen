  <select class="form-control" name="txtSubPemborong" id="subpemborong" onchange="Cariitem()" readonly>
    <?php if(count($_getDataSub)>1){
        $selected ='';
    } else {
        $selected='selected';
    } ?>   
    <option value="">- Pilih -</option>
    <?php foreach($_getDataSub as $pbr){
        echo "<option value='".$pbr->IDSubPemborong."' ".$selected.">".$pbr->Perusahaan."</option>";
        // echo "<option value='".$pbr->IDSubPemborong."' ".$selected.">".$pbr->IDSubPemborong."</option>";
    } ?>
</select>
<script>
    $(document).ready(function() {
        Cariitem();
    });
</script>