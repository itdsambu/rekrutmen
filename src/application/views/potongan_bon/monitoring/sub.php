
  <!-- <select class="form-control" name="txtSubPemborong" id="subpemborong">
     <?php if(count($_getDataSub)>1){
        $selected ='';
        }
        else{
            $selected='selected';
            } 
            ?>   
    <option value="">- Pilih -</option>
    <?php foreach($_getDataSub as $pbr){
        echo "<option value='".$pbr->IDSubPemborong."' ".$selected.">".$pbr->Perusahaan."</option>";
    } ?> -->
    <input type="hidden" name="txtSubPemborong" id="subpemborong" class="form-control" value="<?= $_getDataSub[0]->IDSubPemborong ?>" readonly required>
    <input type="text" class="form-control" value="<?= $_getDataSub[0]->Perusahaan ?>" readonly required>
</select>
