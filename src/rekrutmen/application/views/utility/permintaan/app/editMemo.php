<div class="row">
	<div class="col-xs-12">
		<?php foreach($_data as $row){
			$att = array('class'=>'form-horizontal', 'role'=>'form', 'method'=>'post');
			echo form_open('Memopermintaan/updateMemo?id='.$row->IDMemo, $att);
		?>
			<div class="form-group">
				<label class="control-label col-sm-4">IDMemo</label>
				<div class="col-sm-5">
					<input class="form-control" id="inputmemo" name="txtidmemo" value="<?php echo $row->IDMemo;?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-4">Doc</label>
				<div class="col-sm-5">
					<input class="form-control" id="inputdoc" name="txtdoc" value="<?php echo $row->Doc;?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-4">Departement</label>
				<div class="col-sm-5">
					<input class="form-control" id="inputdept" name="txtdept" value="<?php echo $row->DeptAbbr;?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-4">Type</label>
				<div class="col-sm-5">
					<input class="form-control" id="inputtype" name="txttype" value="<?php if($row->IsKry == 1){echo 'Karyawan';}else{echo 'TK';}?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-4">Jumlah ideal sekarang</label>
				<div class="col-sm-5">
					<input class="form-control" id="inputIdealS" name="txtIdealS" value="<?= $row->IsKry==0 ? $row->IBor : $row->IKry?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-4">Jumlah ideal tambahan</label>
				<div class="col-sm-5">
					<input class="form-control" id="inputTambah" name="txtTambah" value="<?= $row->IsKry==0 ? $row->Jumlah-$row->IBor : $row->Jumlah-$row->IKry?>">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-4">Total</label>
				<div class="col-sm-5">
					<input class="form-control" onclick="ideal(this.value);" id="inputTotal" name="txtTotal" value="<?= $row->IsKry==0 ? $row->Jumlah+$row->Jumlah-$row->IBor : $row->Jumlah+$row->Jumlah-$row->IKry?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-4">Keterangan</label>
				<div class="col-sm-5">
					<textarea class="form-control" id="inputKet" name="txtKet"></textarea>
				</div>
			</div>
			<div class="widget-toolbox padding-8 clearfix">
				<div class="text-center">
					<button type="submit" class="btn btn-danger btn-sm btn-rounded w-md m-b-5" ><i class="mdi mdi-flopy"></i> Update</button>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<script type="text/javascript">
  function ideal(objek){
    if (objek === '1') {
      var idealbor    = parseInt(document.getElementById('inputIdealS').value);
      var addidealbor = parseInt(document.getElementById('inputTambah').value);
      var totaltk     = idealbor + addidealbor;

      document.getElementById('inputTotal').value = totaltk;
    }else{
      var idealkry    = parseInt(document.getElementById('inputIdealS').value);
      var addidealkry = parseInt(document.getElementById('inputTambah').value);
      var totalkry    =  idealkry + addidealkry;

      document.getElementById('inputTotal').value = totalkry;
    }
  }
</script>