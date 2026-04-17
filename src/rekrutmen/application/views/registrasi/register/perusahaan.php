<?php
foreach ($namapt as $namapemborong) { ?>
	<input class='col-xs-12 col-sm-10' name='txtPemborong' id='inputPemborong' type='text' value='<?= $namapemborong->Pimpinan ?>' readonly />
	<input class='col-xs-12 col-sm-10' name='txtIDPemborong' id='inputIDPemborong' type='hidden' value='<?= $namapemborong->IDPemborong ?>' readonly />
<?php }
// echo "<input class='col-xs-12 col-sm-10' name='txtPemborong' id='inputPemborong' type='text' value='$namapt' readonly />";
?>
<!--<input type="text" id="inputPerusahaan" name="txtPerusahaan" placeholder="Perusahaan" class="col-xs-12 col-sm-10" />-->