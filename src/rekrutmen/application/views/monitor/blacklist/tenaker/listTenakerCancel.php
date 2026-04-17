<div class="page-header">
	<h1>
		MONITOR
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			Tenaga Kerja Cancel
		</small>
	</h1>
</div>

<div class="widget-body">
	<div class="widget-main">
		<form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('Blacklist/filterdatalisttenaker'); ?>">
			<div class="row">
				<div class="col-xs-12 col-sm-8"></div>
				<div class="col-xs-12 col-sm-4">
					<!-- <div class="form-group">
						<label class="col-sm-4 control-label no-padding-right">Nama</label>
						<div class="col-sm-8">
							<input name="txtNama" id="inputNama" type="text" class="form-control input-sm" autocomplete="off" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label no-padding-right"></label>
						<div class="col-sm-8">
							<input name="btnCari" id="inputcari" type="submit" value="Cari" class="btn btn-mini btn-block" />
						</div>
					</div> -->
				</div>
			</div>
		</form>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="widget-box">
			<div class="widget-header">
				<h5 class="widget-title">List Tenaga Kerja Cancel</h5>
				<!-- <div class="widget-toolbar">
					<a class="btn btn-minier btn-danger" href="<?php echo base_url("blacklist/TenagaKerja"); ?>">
						<i class="ace-icon fa fa-floppy-o"></i> Tambah
					</a>
					<span id="moExcel">
						<button class="btn btn-minier btn-success" id="btnModalExcel">
							<i class="ace-icon fa fa-file-excel-o"></i> Export to Excel
						</button>
					</span>
				</div> -->
			</div>
			<div class="widget-body">
				<div class="widget-main">
					<a title="Export Excel" target="_blank" data-rel="tooltip" href="<?= base_url("export_excel/C_export_excel_blackilst_tenaker_cancel/exportxls/") . 1000 ?> " class="btn btn-minier btn-sm btn-success mb-3">
						<i class="ace-icon fa fa-file-excel-o bigger-100"></i> Export Excel
					</a>
					<br>
					<div class="table-responsive">
						<table id="dataTablesTK" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>NIK</th>
									<th>NAMA</th>
									<th>NO KTP</th>
									<th>Perusahaan / CV</th>
									<th>PEMBORONG</th>
									<th>TANGGAL LAHIR</th>
									<th>DAERAH ASAL</th>
									<th>NAMA IBU</th>
									<th>RECORD INTERVIEW</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($getBlacklistTK as $row) :
								?>
									<tr class="info" data-id="<?php echo $row->NIK; ?>">
										<td>
											<input type="hidden" id="headerid" value="<?= $row->NIK ?>">
											<?php echo $row->NIK; ?>
										</td>
										<td>
											<?php echo $row->Nama; ?>
										</td>
										<td>
											<?php echo $row->No_Ktp; ?>
										</td>
										<td>
											<?php echo $row->CV_Nama; ?>
										</td>
										<td>
											<?php echo $row->Pemborong; ?>
										</td>

										<td data-order="<?php echo $row->Tgl_Lahir; ?>">
											<?php echo date('d-m-Y', strtotime($row->Tgl_Lahir)) ?>
										</td>
										<td>
											<?php echo $row->Daerah_Asal; ?>
										</td>
										<td>
											<?php echo $row->Nama_Ibu; ?>
										</td>
										<td>
											<a title="View Detail" data-rel="tooltip" href="#" class="detailInterview btn btn-minier btn-white btn-block">
												<i class="ace-icon fa fa-files-o bigger-100"></i> Record Interview
											</a>
										</td>
										<td>
											<a href="#" title="Detail Tenaga Kerja Bermasalah" class="detail btn btn-minier btn-round btn-info"><i class="ace-icon fa fa-files-o bigger-100"></i>Detail</a>
											<?php if ($this->session->userdata('userid') == 'kiki' || $this->session->userdata('userid') == 'KIKI' || $this->session->userdata('userid') == 'psn_lisa' || $this->session->userdata('userid') == 'psn_lisa2' || $this->session->userdata('userid') == 'psn_lisa3' || $this->session->userdata('userid') == 'psn_gia' || $this->session->userdata('userid') == 'YULI1234') { ?>
												<button class="cancel btn btn-minier btn-round btn-warning"><i class="ace-icon fa fa-sign-out bigger-100"></i>Keluarkan Dari Blacklist</button>
											<?php } ?>
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
			<div class="modal-header">
				<!--style="background-color: #008cba">-->
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titleExcel"> Export to Excel</h4>
			</div>
			<div class="modal-body">
				<div class="center">
					<form class="form-horizontal" id="formExportExcel" action="<?php echo site_url('toExcel/downloadExcelTenaker'); ?>" method="POST">
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

<!-- Modal View Report Interview -->
<div class="modal fade" id="viewModalInterview" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<!--style="background-color: #008cba">-->
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Informasi Record Wawancara</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="inputdetail" name="iddetail">
				<div id="detailInterview" class="well">
					<!--load tabel dari file detail.php melalui javascript-->
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/jqv/jquery.tablesorter.min.js"></script>
<script>
	$(document).ready(function() {
		$('dataTablesTK').tablesorter();
		$('[data-rel=tooltip]').tooltip();
		$('#dataTablesTK').on("click", ".detail", function() {
			var id = $(this).closest('tr').data('id');
			console.log(id);
			$.ajax({
				url: "<?php echo site_url('blacklist/detailTKCancel'); ?>",
				type: "POST",
				data: "kode=" + id,
				datatype: "json",
				cache: false,
				success: function(msg) {
					$("#detail").html(msg);
				}
			});
			$('#viewModal').modal("show");
		});
	})
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#dataTablesTK').dataTable({
			"order": [
				[1, 'asc']
			]
		});

		$("#btnModalExcel").click(function() {
			$("#modalToExcel").modal("show");
		});

		$("#btnExportTenaker").click(function() {
			$("#tblExport").battatech_excelexport({
				containerid: "dataTablesTK",
				datatype: 'table'
			});
		});
	})


	$(document).on('click', '.cancel', function() {

		var id = $(this).closest('tr').data('id')
		if (id != '') {
			Swal.fire({
				title: 'Anda Yakin?',
				text: 'Keluarkan Dari List Blaclist ?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Update!'
			}).then((result) => {
				if (result.isConfirmed) {
					console.log('update...');
					updateStatusCancel(id)
				}
			})
		}

	})

	function updateStatusCancel(id) {
		$.ajax({
			url: "<?php echo site_url('blacklist/updateStatusCancel'); ?>",
			type: "POST",
			data: {
				id
			},
			dataType: "json",
			success: function(msg) {
				// var msg = JSON.parse(msg)
				console.log(msg.status);
				if (msg.status === 200) {
					Swal.fire(
						'Berhasil',
						'Data Berhasil dikeluarkan dari Blacklikst!',
						'success'
					)
					setTimeout(() => {
						// 
						window.location.reload()
					}, 2000)
				} else {
					Swal.fire(
						'Gagal',
						'Data Gagal diupdate!',
						'danger'
					)
				}
			}
		});
	}


	$("#dataTablesTK").on("click", ".detailInterview", function() {
		let e = $(this).closest("tr").find('#headerid').val()
		console.log(e);
		$.ajax({
			url: "<?php echo site_url('wawancaraTujuan/cekRecordInterview'); ?>",
			type: "POST",
			data: "kode=" + e,
			datatype: "json",
			cache: !1,
			success: function(e) {
				$("#detailInterview").html(e)
			}
		}), $("#viewModalInterview").modal("show")
	});
</script>