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
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> DEPARTEMEN</label>
				<div class="col-sm-9">
					<input type="text" name="txtdept" id="dept" placeholder="DEPARTEMEN" class="form-control" value="<?php echo $row->DeptAbbr;?>" readonly>
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> TANGGAL LAHIR</label>
				<div class="col-sm-9">
					<input type="text" name="txttgllahir" id="tgllahir" placeholder="TANGGAL LAHIR" class="form-control" value="<?php echo date('d-M-Y', strtotime($row->TglLahir))?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> DAERAH ASAL</label>
				<div class="col-sm-9">
					<input type="text" name="txtdaerahasal" id="daerahasal" placeholder="DAERAH ASAL" class="form-control" value="<?php echo $row->DaerahAsal;?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> TANGGAL MASUK</label>
				<div class="col-sm-9">
					<input type="text" name="txttglmasuk" id="tglmasuk" placeholder="TANGGAL MASUK" class="form-control" value="<?php echo date('d-M-Y', strtotime($row->TanggalMasuk))?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> TANGGAL KELUAR</label>
				<div class="col-sm-9">
					<input type="text" name="txttglkeluar" id="tglkeluar" placeholder="TANGGAL KELUAR" class="form-control" value="<?php echo date('d-M-Y', strtotime($row->TanggalKeluar));?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> NAMA IBU KANDUNG</label>
				<div class="col-sm-9">
					<input type="text" name="txtnmibukandung" id="nmibukandung" placeholder="NAMA IBU KANDUNG" class="form-control" value="<?php echo $row->NamaIbu;?>" readonly>
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1" style="text-align: left;"> KETERANGAN</label>
				<div class="col-sm-10">
					<input name="txtketerangan" id="keterangan" placeholder="KETERANGAN" class="form-control" value="<?php echo $row->ResignRemark;?>">
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