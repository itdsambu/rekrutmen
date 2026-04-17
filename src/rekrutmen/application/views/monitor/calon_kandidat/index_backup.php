<div class="page-header">
	<h1>
		Monitor
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			List Data Kandidat
		</small>
	</h1>
</div>
<?php
if ($this->input->get('msg') == 'success_edit') {
	echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
    <i class='ace-icon fa fa-times'></i></button>Edit data berhasil..</p>";
} elseif ($this->input->get('msg') == 'failed_edit') {
	echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
    <i class='ace-icon fa fa-times'></i></button>Edit data tidak berhasil..</p>";
} elseif ($this->input->get('msg') == 'success_delete') {
	echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
    <i class='ace-icon fa fa-times'></i></button>Data behasil dihapus..</p>";
} elseif ($this->input->get('msg') == 'failed_delete') {
	echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
    <i class='ace-icon fa fa-times'></i></button>Data tidak behasil dihapus..</p>";
} else {
}
?>
<div class="row">
	<div class="col-xs-12">
		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-info">
					<div class="panel-heading"><b> List Calon Kandidat</b></div>
					<div class="panel-body">
						<?php if ($this->session->flashdata('_message')) : ?>
							<div class="alert <?= ($_GET['success'] == 'ok' ? 'alert-success' : 'alert-danger') ?> alert-dismissible" rolw="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
								<strong><?= ($_GET['success'] == 'ok' ? 'Well done' : 'Oh snap') ?>!</strong> <?= $this->session->flashdata('_message') ?>
							</div>
						<?php endif; ?>
						<div class="alert alert-block alert-success">
							Menu Upload Berkas Sudah Bisa Di Gunakan.
						</div>
						<div class="row">
							<div class="col-sm-11">
								<form id="form-calon-kandidat" role="form" class="form-horizontal" action="<?= base_url('Monitor/setFilterCalonKandidat') ?>" method="POST">
									<div class="col-md-2">
										<div class="dataTables_length">
											<label class="control-label">Show</label>
											<div class="col-md-2">
												<select id="pagismotion-length" class="form-control input-sm">
													<option value="10">10</option>
													<option value="20">20</option>
													<option value="50">50</option>
													<option value="100">100</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-5"></div>
									<div class="form-group">
										<div class="col-md-2">
											<input name="txtFilterNama" type="text" class="form-control input-sm" placeholder="Find Nama">
										</div>
										<div class="col-sm-3">
											<div class="input-group">
												<input name="txtperiode" class="form-control datepick" type="text" placeholder="Periode" />
												<span class="input-group-btn">
													<button class="btn btn-xs btn-primary" type="submit">
														<i class="ace-icon fa fa-send-o"></i>Submit
													</button>
												</span>
											</div>
										</div>
									</div>
								</form>
							</div>
							<div class="col-sm-1">
								<button class="btn btn-primary btn-sm " id="btnModalExcel"><i class="fa fa-file-excel-o m-r-5"></i> Excel</button>
							</div>
							<div class="col-sm-12">
								<div class="card-box table-responsive">
									<table id="calonkandidat" class="table table-striped table-hover table-bordered">
										<thead class="bg-info">
											<th>No</th>
											<th>Nama</th>
											<th>Jenis Kelamin</th>
											<th>TTL</th>
											<th>No. KTP</th>
											<th>No. HP</th>
											<th>Email</th>
											<th>Posisi</th>
											<th>Level</th>
											<th>Dept</th>
											<th>Divisi</th>
											<th>Pendidikan</th>
											<th>Jurusan</th>
											<th>Jadwal Test</th>
											<th>Status</th>
											<th>Status Test</th>
											<th>Transport</th>
											<th>Biaya Transport</th>
											<th>Sumber Pelamar</th>
											<th>Keterangan</th>
											<th>Create By</th>
											<th>Opsi</th>
										</thead>
										<tbody>
											<?php $no = 0;
											foreach ($_getData as $row) { ?>
												<tr class="info" data-id="<?php echo $row->ID; ?>">
													<td><?= ++$no; ?></td>
													<td><?= $row->Nama; ?></td>
													<td><?php if ($row->JK == 'L') {
															echo 'Laki-laki';
														} else {
															echo 'Perempuan';
														}; ?></td>
													<td><?= $row->Tempat_Lhr; ?>, <?= date('d-m-Y', strtotime($row->Tanggal_Lhr)) == '01-01-1970' ? '' : date('d-m-Y', strtotime($row->Tanggal_Lhr)); ?></td>
													<td><?= $row->NoKTP; ?></td>
													<td><?= $row->NoHP; ?></td>
													<td><?= $row->Email; ?></td>
													<td><?= $row->Posisi; ?></td>
													<td><?= $row->Level; ?></td>
													<td><?= $row->DeptAbbr; ?></td>
													<td><?= $row->NamaDivisi; ?></td>
													<td><?= $row->Pendidikan; ?></td>
													<td><?= $row->Jurusan; ?></td>
													<td><?= $row->JadwalTest; ?></td>
													<td>
														<?php
														if ($row->Status == 'TL') {
															echo "<span class='label label-sm label-danger'>Tidak Lulus</span>";
														} elseif ($row->Status == 'L') {
															echo "<span class='label label-sm label-primary'>Lulus</span>";
														} else {
															echo "";
														} ?>
													</td>
													<td><?php if ($row->StsTest == 'Test') {
															echo "<span class='label label-sm label-primary'>Test</span>";
														} elseif ($row->StsTest == 'Non Test') {
															echo "<span class='label label-sm label-danger'>Tidak Test</span>";
														} ?></td>
													<td><?php if ($row->Transport == 'Diganti') {
															echo "<span class='label label-sm label-primary'>Diganti</span>";
														} elseif ($row->Transport == 'Tidak Diganti') {
															echo "<span class='label label-sm label-danger'>Tidak Diganti</span>";
														} ?></td>
													<td><?= $row->Biaya; ?></td>
													<td><?= $row->SumberPelamar; ?></td>
													<td><?= $row->Keterangan; ?></td>
													<td><?= $row->CreatedBy; ?><br><small><?= date('d-m-Y', strtotime($row->CreatedDate)); ?></small></td>
													<td>
														<a class="edit btn btn-primary btn-xs" title="Edit Calon Kandidat"><i class="fa fa-edit"></i></a>
														<a href="<?= site_url('Monitor/hapusdataCK?id=' . $row->ID); ?>" class="btn btn-danger btn-xs hapusCK" title="Hapus Calon Kandidat"><i class="glyphicon glyphicon-trash"></i></a>
														<a title="Upload berkas" class="btn btn-minier btn-round btn-success" href="<?php echo site_url('Monitor/uploadberkas') . "?id=" . $row->ID . "&nama=" . $row->Nama; ?>">
															Upload
														</a>
													</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-footer text-center">
						<?= $_pagination; ?>
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
					<h4 class="modal-title"> Edit Calon Kandidat</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" name="idedit" id="inputedit">
					<div id="edit" class="well">

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
						<form class="form-horizontal" id="formExportExcel" action="<?php echo site_url('toExcel/downloadExcelCalonKandidat'); ?>" method="POST">
							<div class="form-group">
								<label class="col-sm-5 control-label right" for="inputDataExport">Data export</label>
								<select name="selDataExport" id="inputDataExport" class="col-md-3">
									<option value=""> - Pilih - </option>
									<option value="all">Semua</option>
									<option value="lulus">Lulus</option>
									<option value="tidaklulus">Tidak Lulus</option>
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
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" />

	<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-timepicker.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/date-time/moment.js"></script>
	<script type="text/javascript">
		var urlPaging = ['<?= base_url($this->uri->segment(1) . '/' . $this->uri->segment(2)) ?>', '<?= $this->uri->segment(4) ?>', '<?= $this->uri->segment(3) ?>'];
	</script>
	<script>
		jQuery(document).ready(function() {
			$('#pagismotion-length').val(urlPaging[2]);
			$('#pagismotion-length').change(function() {
				window.location = urlPaging[0] + '/' + $(this).val() + '/' + urlPaging[1];
			});
		});
	</script>
	<script>
		$(document).ready(function() {
			$('#calonkandidat').on("click", ".edit", function() {
				var id = $(this).closest('tr').data('id');
				$.ajax({
					url: "<?php echo site_url('Registrasi/editDataCK'); ?>",
					type: "POST",
					data: "kode=" + id,
					datatype: "json",
					cache: false,
					success: function(msg) {
						$("#edit").html(msg);
					}
				});
				$('#viewModal').modal("show");
			});

			$('.hapusCK').on('click', function() {
				var getLink = $(this).attr('href');
				swal({
					title: 'Alert',
					text: 'Hapus Data ?',
					html: true,
					confirmButtonCollor: '#d9534f',
					showCancelButton: true,
				}, function() {
					window.location.href = getLink
				});
				return false;
			});
		})
	</script>
	<script type="text/javascript">
		jQuery(function($) {
			$('.datepick').datepicker({
				autoclose: true,
				format: 'm-yyyy'
			});

			$("#btnModalExcel").click(function() {
				$("#modalToExcel").modal("show");
			});
		});
	</script>