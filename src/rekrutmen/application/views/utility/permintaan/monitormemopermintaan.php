<h4 class="row header smaller lighter green">
	<span class="col-sm-12">
		<i class="ace-icon fa fa-files-o"></i>
		Monitoring Memo Permintaan
	</span>
</h4>
<style>
	.bordering {
		border: solid 2px #1ca8c5;
		padding: 20px;
	}
</style>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="controlsetup">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Monitoring Memo Permintaan</h3>
			</div>
		</div>

		<div class="panel-body">
			<section id="viewtabel">
				<div class="col-sm-12">
					<table id="tblsettingkrytk" class="table table-striped table-hover table-nowrap table-colored" style="width:100%;">
						<thead>
							<tr>
								<th>Opsi</th>
								<th>IdRef</th>
								<th>Doc</th>
								<th>Dept</th>
								<th>Type</th>
								<th>Jumlah Ideal</th>
								<th>Status</th>
								<th>Memo</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					<div id="formupdate"></div>
				</div>
			</section>
		</div>
	</div>
</div><!-- end row -->

<script>
	var mpesan = '';
	<?php if (null != $this->session->flashdata('Msg')) { ?>
		mpesan = '<?= $this->session->flashdata('Msg') ?>';
	<?php } ?>


	$(document).ready(function() {
		const site_url = '<?= site_url() ?>';
		const base_url = '<?= base_url() ?>';


		if ($.fn.DataTable.isDataTable('#tblsettingkrytk')) {
			$('#tblsettingkrytk').DataTable().clear().destroy();
		}

		var table = $("#tblsettingkrytk").DataTable({
			processing: false,
			responsive: true,
			order: [],
			serverSide: true,
			// ordering: false // Menonaktifkan pengurutan
			ajax: {
				url: base_url + "Configpermintaan/show",
				type: "POST",
				data: function(d) {

				},
				beforeSend: function() {
					$('#loading').show(); // Tampilkan loading spinner sebelum request
				},
				complete: function() {
					$('#loading').hide(); // Sembunyikan loading spinner setelah request selesai                
				}

			},
			orderMulti: false, // Hanya menyortir data di halaman saat ini
			language: {
				// url: base_url + 'assets/stexo/plugins/datatables/language/id.json',
				searchPlaceholder: "Cari..."
			},
			lengthMenu: [5, 10, 25, 41, 50, 100],
			// Mengatur tampilan default menjadi 10
			pageLength: 10,

		});



	})
</script>