
  <select class="form-control" name="txtSubPemborong" id="subpemborong" onchange="CariHarga()" onload="CariHarga()">
     <?php if(count($_getDataSub)>1){$selected ='';}else{$selected='selected';} ?>   
    <option value="">- Pilih -</option>
    <?php foreach($_getDataSub as $pbr){
        echo "<option value='".$pbr->IDSubPemborong."' ".$selected.">".$pbr->Perusahaan."</option>";
    } ?>
</select>
<script>
    $(document).ready(function() {
        CariHarga();
    });
</script>