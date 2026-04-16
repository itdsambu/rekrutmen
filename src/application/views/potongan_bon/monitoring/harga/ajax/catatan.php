<?php foreach($getCatatan as $get){
if($get->Catatan == NULL){?>
	<div class="row">
		<div class="col-lg-12">
			<div class="form-group">
				<label class="col-lg-2 control-label">Catatan</label>
				<div class="col-sm-8">
					<input type="hidden" name="txtDtlHarga" id="dtlharga" value="<?php echo $id_harga;?>">
					<textarea class="form-control" name="txtCatatan" id="catatan"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label"></label>
				<div class="col-sm-8">
					<button class="btn btn-sm btn-round btn-primary">Simpan</button>
					<a href="" class="btn btn-sm btn-round btn-danger">Batal</a>
				</div>
			</div>
			<hr>
		</div>
	</div>
<?php }else{?>
	<div class="row">
		<div class="col-lg-12">
			<div class="form-group">
				<label class="col-lg-2 control-label">Catatan</label>
				<div class="col-sm-8">
					<input type="hidden" name="txtDtlHarga" id="dtlharga" value="<?php echo $id_harga;?>">
					<textarea class="form-control" name="txtCatatan" id="catatan"><?php echo $get->Catatan;?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label"></label>
				<div class="col-sm-8">
					<button class="btn btn-sm btn-round btn-primary">Simpan</button>
					<a href="" class="btn btn-sm btn-round btn-danger">Batal</a>
				</div>
			</div>
			<hr>
		</div>
	</div>
<?php	}
}