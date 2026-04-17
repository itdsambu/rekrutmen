<div class="page-header">
	<h1>
		MONITOR
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			BlackList Tenaga Kerja Dua Bulan
		</small>
	</h1>
</div>
<?php
if($this->input->get('msg')== 'ok'){
    echo "<p class='alert alert-info'>Password berhasil dirubah..</p>";
}elseif ($this->input->get('msg')== 'notMacth') {
    echo "<p class='alert alert-danger'>Password lama anda tidak sesuai..</p>";
}elseif($this->input->get('msg') == 'success_edit'){
    echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
    <i class='ace-icon fa fa-times'></i></button>Edit data berhasil..</p>";
}elseif ($this->input->get('msg') == 'failed_edit') {
    echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
    <i class='ace-icon fa fa-times'></i></button>Edit data tidak berhasil..</p>";
}elseif ($this->input->get('msg') == 'success_delete') {
    echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
    <i class='ace-icon fa fa-times'></i></button>Data behasil dihapus..</p>";
}elseif ($this->input->get('msg') == 'failed_delete') {
    echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
    <i class='ace-icon fa fa-times'></i></button>Data tidak behasil dihapus..</p>";
}elseif ($this->input->get('msg') == 'success_add') {
    echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
    <i class='ace-icon fa fa-times'></i></button>Data behasil ditambahkan..</p>";
}elseif ($this->input->get('msg') == 'failed_add') {
    echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
    <i class='ace-icon fa fa-times'></i></button>Mohon Maaf NIK sudah di BLACKLIST ..</p>";
}else{
    // echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
    // </button><strong>Warning!!</strong> menu PRINT masih tahap perngerjaan. .<br>";
}
?>
<div class="row">
	<div class="col-xs-12">
		<div class="widget-box">
			<div class="widget-header">
				<h5 class="widget-title">BlackList Tenaga Kerja Dua Bulan</h5>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					<div class="table-responsive">
						<table id="dataTablesTK" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>NIK</th>
                  <th>NAMA</th>
                  <th>PERUSAHAAN</th>
                  <th>PEMBORONG</th>
                  <th>DEPARTEMEN</th>
									<th>TANGGAL LAHIR</th>
									<th>DAERAH ASAL</th>
                  <th>TANGGAL MASUK</th>
                  <th>TANGGAL KELUAR</th>
                  <th>KETERANGAN</th>
                  <th>NAMA IBU</th>
                  <th>ACTION</th>
								</tr>
							</thead>
							<tbody>
							<?php
							foreach ($blok_dua_bulan as $row):
							?>
								<tr class="info" data-id="<?php echo $row->NIK;?>">
									<td>
										<?php echo $row->NIK;?>
									</td>
                  <td>
                  	<?php echo $row->NAMA;?>
                	</td>
                  <td>
                  	<?php echo $row->CVNAMA;?>
                	</td>
                  <td>
                  	<?php echo $row->PEMBORONG;?>
                	</td>	
                  <td>
                  	<?php echo $row->DEPT;?>
                	</td>
									<td>
										<?php echo date('M, d Y', strtotime($row->TGLLAHIR))?>
									</td>
									<td>
										<?php echo $row->DAERAHASAL;?>
									</td>
                  <td>
                  	<?php echo substr($row->TGLMASUK, 0, 10);?>
                	</td>
									<td>
										<?php echo substr($row->TGLKELUAR, 0, 10);?>
									</td>
                  <td>
                  	<?php echo $row->REMARK;?>
                  </td>
                  <td>
                  	<?php echo $row->NAMAIBU;?>
                	</td>
                  <td>
                  	<a href="#" title="Detail Tenaga Kerja Bermasalah" class="detail btn btn-minier btn-round btn-info"><i class="ace-icon fa fa-files-o bigger-100"></i>Detail</a>
                  </td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dinamiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> Informasi Tenaga Kerja Blacklist</h4>
            </div>
            <div class="modal-body">
            	<input type="hidden" name="iddetail" id="inputdetail">
            	<div id="detail" class="well">
            		
            	</div>
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalToExcel" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titleExcel"> Export to Excel</h4>
            </div>
            <div class="modal-body">
                <div class="center">
                    <form class="form-horizontal" id="formExportExcel" action="<?php echo site_url('toExcel/downloadExcelTenaker');?>" method="POST">
                        <div class="form-group">
                            <label class="col-sm-5 control-label right" for="inputDataExport">Data export</label>
                            <select name="selDataExport" id="inputDataExport" class="col-md-3">
                                <option value="tenaker">Tenaga Kerja</option>
                            </select>
                        </div>
                        <div class="center">
                            <button type="submit" class="btn btn-mini btn-success">
                                <i class="ace-icon fa fa-download"></i> Download
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqv/jquery.tablesorter.min.js"></script>
<script>
	$(document).ready(function(){
		$('dataTablesTK').tablesorter();
		$('[data-rel=tooltip]').tooltip();
		$('#dataTablesTK').on("click", ".detail", function(){
			var id = $(this).closest('tr').data('id');
			// console.log(id);
			$.ajax({
				url 	: "<?php echo site_url('blacklist/detailTK');?>",
				type	: "POST",
				data 	: "kode="+id,
				datatype: "json",
				cache	: false,
				success	: function(msg){
					$("#detail").html(msg);
				}
			});
			$('#viewModal').modal("show");
		});
	})
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#dataTablesTK').dataTable({
			"order": [[0,'asc']]
		});

		$("#btnModalExcel").click(function(){
			$("#modalToExcel").modal("show");
		});

		$("#btnExportTenaker").click(function () {
			$("#tblExport").battatech_excelexport({
				containerid: "dataTablesTK"
				, datatype: 'table'
			});
		});
	})
</script>