<select class='col-xs-12 col-sm-10' name='txtSubPemborong' id='inputPerusahaan' required>
	<option value=''> -- Silahkan Pilih Perusahaan</option>
	<?php foreach ($namasubpt as $rowCV) : ?>
		<!-- <option value='<?= $rowCV->NamaSubPemborong  ?>'><?= $rowCV->NamaSubPemborong ?> </option> -->

		<option value='<?= $rowCV->NamaSubPemborong . ',' . $rowCV->SubPemborongID  ?>'><?= $rowCV->NamaSubPemborong ?> </option>

	<?php endforeach; ?>
</select>