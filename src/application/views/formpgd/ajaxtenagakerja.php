<?php if($_cekData > 0):?>
	<?php foreach ($_getData as $row):?>
		<!-- <pre>
			<?php print_r($row)?>
		</pre> -->
		<div class="col-xs-6">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> NAMA</label>
				<div class="col-sm-9">
					<input type="hidden" name="fixno" id="fixno" class="form-control" value="<?php echo $row->FixNo;?>" readonly>
					<input type="text" name="txtnama" id="nama" placeholder="NAMA" class="form-control" value="<?php echo $row->Nama;?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> NIK</label>
				<div class="col-sm-9">
					<input type="text" name="txtFindBynik" id="findBynik" placeholder="NIK" class="form-control" value="<?php echo $row->Nik;?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> DEPARTEMEN</label>
				<div class="col-sm-9">
					<input type="text" name="txtdept" id="dept" placeholder="DEPARTEMEN" class="form-control" value="<?php echo $row->DeptAbbr;?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> JABATAN</label>
				<div class="col-sm-9">
					<input type="text" name="txtjabatan" id="jabatan" placeholder="JABATAN" class="form-control" value="<?php echo $row->Jabatan;?>" readonly>
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> PERUSAHAAN/CV</label>
				<div class="col-sm-9">
					<input type="text" name="txtperusahaan" id="perusahaan" placeholder="PERUSAHAAN/CV" class="form-control" value="<?php echo $row->Perusahaan;?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> PEMBORONG</label>
				<div class="col-sm-9">
					<input type="text" name="txtpemborong" id="pemborong" placeholder="PEMBORONG" class="form-control" value="<?php echo $row->Pemborong;?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> TANGGAL MASUK</label>
				<div class="col-sm-9">
					<input type="text" name="txttglmasuk" id="tglmasuk" placeholder="TANGGAL MASUK" class="form-control" value="<?php echo $row->TanggalMasuk;?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> MESS/BLOK</label>
				<div class="col-sm-9">
					<input type="text" name="txtalamat" id="alamat" placeholder=MESS/BLOK class="form-control" value="<?php echo $row->Alamat;?>" readonly>
				</div>
			</div>
		</div>
	<?php endforeach;
	else:
	?>
	<div class="alert alert-danger">NIK yang dicari tidak ditemukan. .
		<button type='button' class='close' data-dismiss='alert'><i class="ace-icon fa fa-times"></i></button>
	</div>
<?php endif;?>