<input type="hidden" name="txtStatus" id="status_id" value="<?php echo $status_id;?>">
<table id="datatable" class="table table-bordered dt-responsive nowarp dataTable no-footer dtr-inline">
	<thead style="background: #4DB3A2;color: #FFFFFF;">
		<tr>
			<th>Fixno</th>
			<th>NIK</th>
			<th>Nama</th>
			<th>Tanggal Lahir</th>
			<th>Jenis Kelamin</th>
			<th>Dept/Bagian</th>
			<th>Jabatan</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($_getTenagaKerja as $get){
			if($status_id == 0){?>
			<tr id="<?php echo $get->NIK?>" onclick="pilih(this.id)" data-dismiss="modal">
				<td class="text-center"><?php echo $get->RegNo?></td>
				<td class="text-center"><?php echo $get->NIK?></td>
				<td><?php echo $get->NAMA?></td>
				<td class="text-center"><?php echo date('d-m-Y',strtotime($get->TGLLAHIR))?></td>
				<td class="text-center">
					<?php if($get->SEX == 'P'){
						echo "PEREMPUAN";
					}else{
						echo "LAKI - LAKI";
					}?>
				</td>
				<td class="text-center"><?php echo $get->NamaBagian?></td>
				<td class="text-center"><?php echo $get->JabatanName?></td>
			</tr>
		<?php }else{?>
			<tr id="<?php echo $get->Nik?>" onclick="pilih(this.id)" data-dismiss="modal">
				<td class="text-center"><?php echo $get->FixNo?></td>
				<td class="text-center"><?php echo $get->Nik?></td>
				<td><?php echo $get->Nama?></td>
				<td class="text-center"><?php echo date('d-m-Y',strtotime($get->TanggalLahir))?></td>
				<td class="text-center"><?php echo $get->JenisKelamin?></td>
				<td class="text-center"><?php echo $get->Bagian?></td>
				<td class="text-center"><?php echo $get->Jabatan?></td>
			</tr>
		<?php }}?>
	</tbody>
</table>
<script type="text/javascript">
	function pilih(id){
		var nik = id;
		var status = $('#status_id').val();

		// alert(nik);
		// alert(status);
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "<?php echo site_url('TrainingOnline/get_data')?>"+"/"+nik+"/"+status,
			success: function (msg) {
				$('#ajaxfrommodal').html(msg);
			}
		});
	}
</script>