<h5 class="row header smaller lighter red">
	<span class="col-sm-8">
		<i class="ace-icon fa fa-bell-o"></i>
		<strong> Informasi Tenaga Kerja Bermasalah</strong>
	</span><!-- /.col -->
</h5>
<?php
foreach ($data as $row) :
	$nik = $row->NIK;
	$regno = $row->FixNo;

	if ($row->CVNAMA == 'PT. PULAU SAMBU GUNTUNG') {
		if (file_exists(base_url() . 'fotos/Karyawan_regno new/' . $row->FixNo . '.png')) {
			$url = 'fotos/Karyawan_regno new/' . $row->FixNo . '.png';
		} else {
			$url = 'fotos/Karyawan_regno/' . $row->FixNo . '.jpg';
		}
	} else {

		$url =  'fotos/BORO_FIXNO/' . $row->FixNo . '.jpg';
	}
endforeach;
// $namafoto = 'dataupload/Blacklist/foto_kar/BORO/'.trim($nik).'.jpg';
$namafoto = $url;
?>
<div class="row">
	<?php foreach ($data as $row) : ?>
		<div class="col-sm-12">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-large">
					<h4 class="widget-title gray lighterer">
						<i class="ace-icon fa fa-users green"></i>
						<?php
						if ($row->SEX == "L") {
							$sapa = 'Mr. ';
							$jekel = 'Laki-laki';
						} else {
							$sapa = 'Mrs. ';
							$jekel = 'Perempuan';
						}
						echo $sapa . ucwords(strtolower($row->NAMA)); ?>
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
									Perusahaan : <b><?php echo $row->CVNAMA ?></b>
								</li>
								<li>
									<i class="ace-icon fa fa-caret-right blue"></i>
									Pemborong : <b><?php echo $row->PEMBORONG ?></b>
								</li>
								<li>
									<i class="ace-icon fa fa-caret-right blue"></i>
									NIK : <b><?php echo $row->NIK ?></b>
								</li>
								<li>
									<i class="ace-icon fa fa-caret-right blue"></i>
									Nama : <b><?php echo $row->NAMA ?></b>
								</li>
								<li>
									<i class="ace-icon fa fa-caret-right blue"></i>
									Departement : <b><?php echo $row->DEPT ?></b>
								</li>
								<li>
									<i class="ace-icon fa fa-caret-right blue"></i>
									Tanggal Lahir : <b><?php echo date('d-m-Y', strtotime($row->TGLLAHIR)) ?></b>
								</li>
								<li>
									<i class="ace-icon fa fa-caret-right blue"></i>
									Daerah Asal : <b><?php echo $row->DAERAHASAL ?></b>
								</li>
								<li>
									<i class="ace-icon fa fa-caret-right blue"></i>
									Suku : <b><?php echo $row->SUKU ?></b>
								</li>
								<li>
									<i class="ace-icon fa fa-caret-right blue"></i>
									Nama Ibu : <b><?php echo $row->NAMAIBU ?></b>
								</li>
								<li>
									<i class="ace-icon fa fa-caret-right blue"></i>
									Tanggal Masuk : <b><?php echo date('d-m-Y', strtotime($row->TGLMASUK)) ?></b>
								</li>
								<li>
									<i class="ace-icon fa fa-caret-right blue"></i>
									Tanggal Keluar : <b><?php echo date('d-m-Y', strtotime($row->TGLKELUAR)) ?></b>
								</li>
								<li>
									<i class="ace-icon fa fa-caret-right blue"></i>
									Keterangan : <b><?php echo $row->REMARK ?></b>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>