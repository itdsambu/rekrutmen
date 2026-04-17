<?php if($_cekData > 0)?>
	<?php foreach ($_getData as $row):?>
		<pre>
			<?php print_r($row)?>
		</pre>
	<?php endforeach;?>
<?php } else { ?>
	tidak ada
<?php } ?>