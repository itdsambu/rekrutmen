<?php $nama_sub = $this->session->userdata('username'); ?>
 <select class="form-control" name="txtSubPemborong" id="subpemborong" onchange="Cariitem()">
    <option value="">- Pilih -</option>
    <?php foreach($_getDataSub as $pbr){
        if($nama_sub == $pbr->NamaSub){$selected ='selected';}else{$selected='';}
        echo "<option value='".$pbr->IDSubPemborong."' ".$selected.">".$pbr->NamaSub."</option>";
    } ?>
</select>
<script>
    $(document).ready(function() {
        Cariitem();
    });
</script>