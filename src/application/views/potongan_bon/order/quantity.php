<form class="form-horizontal" role="form" method="POST" action="#">
	<div class="row">
		<div class="col-lg-12">
			<br>
			<div class="form-group">
				<label class="col-lg-1 control-label"></label>
				<div class="col-sm-2">
					<input type="number" name="txtQuantity" id="quantity"><!-- 
					<input type="hidden" name="txtHarga" id="harga" value="<?php foreach($GetHarga as $get){ echo $get->Harga;}?>">
					<input type="hidden" name="txtHargaID" id="hargaid" value="<?php foreach($GetHarga as $get){ echo $get->DetailHargaID;}?>">
					<input type="hidden" name="txtSatuan" id="satuanid" value="<?php foreach($GetHarga as $get){ echo $get->SatuanID;}?>">
					<input type="hidden" name="txtKategori" id="kategoriid" value="<?php foreach($GetHarga as $get){ echo $get->KategoriID;}?>"> -->
					<input type="hidden" name="txtItem" id="itemid" value="<?php echo $itemid?>">
					<input type="hidden" name="txtPemborong" id="pbrid" value="<?php echo $pbrid?>">
					<input type="hidden" name="txtHeader" id="hdrid" value="<?php echo $hdrid?>">
					<input type="hidden" name="txtNofix" id="nofix" value="<?php echo $nofix?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-1 control-label"></label>
				<div class="col-sm-2">
					<a class="btn btn-sm btn-success" onclick="simpan_pesanan()">Simpan</a>
				</div>
			</div>
			<hr>
		</div>
	</div>
</form>

<script type="text/javascript">
	function simpan_pesanan(){
    var qty    = $('#quantity').val();
    var harga  = $('harga').val();
    var harga  = $('harga').val();

    alert(qty);
    alert(harga);

     // $.ajax({
     //    type: "POST",
     //    dataType: "html",
     //    url: "<?php echo base_url('Pra_pelamar/infokepmh')?>"+"/"+info+"/"+id,
     //    success: function(msg){
     //    }
     //  }); 
  }
</script>