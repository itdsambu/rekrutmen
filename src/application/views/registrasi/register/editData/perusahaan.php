<div class="form-group">
	<div class="col-sm-9">
		<?php
		foreach ($namapt as $namapemborong) { ?>
			<input type="text" id="inputPemborong" name="txtPemborong" class="col-xs-7 col-sm-7" value="<?= $namapemborong->Pimpinan ?>" readonly="">
			<input class='col-xs-12 col-sm-10' name='txtIDPemborong' id='inputIDPemborong' type='hidden' value='<?= $namapemborong->IDPemborong ?>' readonly />
		<?php }
		// echo "<input class='col-xs-12 col-sm-10' name='txtPemborong' id='inputPemborong' type='text' value='$namapt' readonly />";
		?>
	</div>
</div>
<!--<input type="text" id="inputPerusahaan" name="txtPerusahaan" placeholder="Perusahaan" class="col-xs-12 col-sm-10" />-->