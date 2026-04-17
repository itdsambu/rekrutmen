<h5 class="row header smaller lighter red">
	<span class="col-sm-8">
		<i class="ace-icon fa fa-bell-o"></i>
		<strong> Informasi Tenaga Kerja Bermasalah</strong>
	</span><!-- /.col -->
</h5>
<?php
foreach ($data as $row) {

	$nik = $row->NIK;
}
// $namafoto = 'dataupload/Blacklist/foto_kar/BORO/' . trim($nik) . '.jpg';
$namafoto = 'dataupload/foto/' . trim($nik) . '.jpg';
?>
<div class="row">
	<?php foreach ($data as $row) : ?>
		<div class="col-sm-12">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-large">
					<h4 class="widget-title gray lighterer">
						<!-- <i class="ace-icon fa fa-users green"></i>
						<?php
						if ($row->SEX == "L") {
							$sapa = 'Mr. ';
							$jekel = 'Laki-laki';
						} else {
							$sapa = 'Mrs. ';
							$jekel = 'Perempuan';
						}
						echo $sapa . ucwords(strtolower($row->Nama)); ?> -->
					</h4>
				</div>
				<div class="col-sm-offset-5 col-sm-12">
					<div class="row">
						<span class="profil-picture">
							<img id="avatar" width="150" class="editable img-responsive editable-click editable-empty" src="<?php echo base_url($namafoto) ?>"></img>
						</span>
					</div>
				</div>
				<div class="widget-body">
					<div class="widget-main padding-24">
						<div class="row">
							<div class="col-xs-12 label label-lg label-info arrowed-in arrowed-right">
								<b>Infomasi Data</b>
							</div>
						</div>
						<div>
							<ul class="list-unstyled spaced">
								<li>
									<i class="ace-icon fa fa-caret-right blue"></i>
									Perusahaan : <b><?php echo $row->CV_Nama ?></b>
								</li>
								<li>
									<i class="ace-icon fa fa-caret-right blue"></i>
									Pemborong : <b><?php echo $row->Pemborong ?></b>
								</li>
								<li>
									<i class="ace-icon fa fa-caret-right blue"></i>
									NIK : <b><?php echo $row->NIK ?></b>
								</li>
								<li>
									<i class="ace-icon fa fa-caret-right blue"></i>
									Nama : <b><?php echo $row->Nama ?></b>
								</li>
								<li>
									<i class="ace-icon fa fa-caret-right blue"></i>
									Tanggal Lahir : <b><?php echo date('d-m-Y', strtotime($row->Tgl_Lahir)) ?></b>
								</li>
								<li>
									<i class="ace-icon fa fa-caret-right blue"></i>
									Daerah Asal : <b><?php echo $row->Daerah_Asal ?></b>
								</li>
								<li>
									<i class="ace-icon fa fa-caret-right blue"></i>
									Suku : <b><?php echo $row->Suku ?></b>
								</li>
								<li>
									<i class="ace-icon fa fa-caret-right blue"></i>
									Nama Ibu : <b><?php echo $row->Nama_Ibu ?></b>
								</li>


							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>