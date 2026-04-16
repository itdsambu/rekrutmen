<select class="form-control" name="txtSubPemborong" id="subpemborong">
    <?php if(count($_getTK)>1){$selected ='';}else{$selected='selected';} ?>                                   
    <option value="">- Pilih -</option>
    <?php foreach($_getTK as $pbr){
        echo "<option value='".$pbr->IDSubPemborong."' ".$selected.">".$pbr->NamaSub."</option>";
    }?>
</select>