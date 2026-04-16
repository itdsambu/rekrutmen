<!-- <link rel="stylesheet" href="asss/path/to/compiled/flipclock.css" /> -->
<link href="<?php echo base_url(); ?>assets/plugins/FlipClock-master/compiled/flipclock.css" rel="stylesheet" type="text/css" />
<!-- <script src="<?php echo base_url(); ?>assets/plugins/FlipClock-master/compiled/flipclock.min.js"></script>
 -->
<div id="successid">
	<form class="form-horizontal" role="form" method="POST" id="formSave">
		<div class="row">
			<div class="col-12">
				<div class="card m-b-20">
					<div class="card-body">
						<div class="alert alert-primary">
							<h4 class="mt-0 header-title"><b> <center>DATA DIRI</center> </b></h4>
						</div>
						<br>
						<div id="ajaxfrommodal">
							<?php foreach ($_getData as $get) {
								$Materi = $get->NamaMateri; ?>
								<div class="form-group row">
									<label for="example-search-input" class="col-sm-2 col-form-label">NIK</label>
									<div class="col-sm-4">
										: <span><?php echo $get->Nik ?></span>
									</div>
								</div>
								<div class="form-group row">
									<label for="example-search-input" class="col-sm-2 col-form-label">Nama</label>
									<div class="col-sm-4">
										: <span><?php echo $get->Nama ?></span>
									</div>
								</div>
								<div class="form-group row">
									<label for="example-search-input" class="col-sm-2 col-form-label">Bagian</label>
									<div class="col-sm-4">
										: <span><?php echo $get->dept ?></span>
									</div>
								</div>
								<div class="form-group row">
									<label for="example-search-input" class="col-sm-2 col-form-label">Jabatan</label>
									<div class="col-sm-4">
										: <span><?php echo $get->Jabatan ?></span>
									</div>
								</div>
								<br>
								<br>
								<div class="alert alert-primary">
									<h4 class="mt-0 header-title"><b>
											<center>KRITERIA SOAL </center>
										</b></h4>
								</div>
								<br>
								<div class="form-group row">
									<label for="example-search-input" class="col-sm-2 col-form-label">Departemen</label>
									<div class="col-sm-4">
										: <span><?php echo $get->DeptTraining ?></span>
									</div>
								</div>
								<div class="form-group row">
									<label for="example-search-input" class="col-sm-2 col-form-label">Jenis Soal</label>
									<div class="col-sm-4"> :
										<span>
											<?php if ($get->JenisSoal == 1) {
												echo "Pre Test";
											} else {
												echo "Post Test";
											} ?>
										</span>
									</div>
								</div>
								<div class="form-group row">
									<label for="example-search-input" class="col-sm-2 col-form-label">Materi</label>
									<div class="col-sm-4">
										: <span><?php echo $get->NamaMateri ?></span>
									</div>
								</div>
								<div class="form-group row">
									<label for="example-search-input" class="col-sm-2 col-form-label">Lokasi</label>
									<div class="col-sm-4"> :
										<span>
											<?php if ($get->Lokasi == 1) {
												echo "Ruang Training Internal Departemen";
											} elseif ($get->Lokasi == 2) {
												echo "Ruang Training PSN";
											} elseif ($get->Lokasi == 3) {
												echo "Ditentukan Oleh Dept/Bagian Masing-Masing";
											} ?>

										</span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 col-form-label" for="example-search-input">Ruangan</label>
									<div class="col-sm-4">
										: <span><?php echo $get->NamaRuangan ?></span>
									</div>
								</div>
								<div class="form-group row">
									<label for="example-search-input" class="col-sm-2 col-form-label">Waktu Pengerjaan</label>
									<div class="col-sm-4">
										: <span><?php echo $get->SettingWaktu ?> Menit</span>
									</div>
								</div>
								<?php 
							} ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<?php
				$no = 1;
				foreach ($_getSoal as $row) { ?>
					<div class="card m-b-20">
						<div class="card-body">
							<div class="form-group form-md-radios">
								<label for="example-search-input" class="col-sm-4 col-form-label">
									<strong><?php echo $no++ . '. ' . $row->Soal; ?> &nbsp;
										<?php if ($row->Link == NULL) {
											echo "";
										} else {
											$s = 1;
											if ($row->JenisSoal == 1) { ?>
												<div class="">
													<img src="<?php echo base_url('assets/ttdtraining/GambarSoal/PreTest/' . $row->ID . '.JPG'); ?>" class="img-fluid d-block mx-auto" alt="Responsive image" style="width: 500px;height: 300px;">
												</div>
											<?php } else { ?>
												<div>
													<img src="<?php echo base_url('assets/ttdtraining/GambarSoal/PostTest/' . $row->ID . '.JPG'); ?>" style="width: 500px;height: auto;">
												</div>
										<?php }
										} ?>
								</label>
								<hr>
								<div class="col-sm-4">
									<?php
									$this->load->model("M_TrainingOnline");
									$jawaban = $this->M_TrainingOnline->_getJawaban();
									$jawaban_benar = $this->M_TrainingOnline->_getJawabanBenar($hdrid);
									foreach ($jawaban_benar as $jb) {
										if ($jb->IDSoal == $row->IDSoal) {
											foreach ($jawaban as $key) {
												if ($key->IDSoal == $row->IDSoal) { ?>
													<div class="md-radio-list">
														<?php
														if ($key->IDObjectif == $jb->IDBenar) {
															if ($jb->Benar == 1) { ?>
																<input type="radio" id="objectif_id<?php echo $key->IDSoal; ?>" name="objectif<?php echo $key->IDSoal ?>" class="md-radiobtn?>" value="<?php echo $key->IDObjectif; ?>" checked>
																<span style="color:green;">
																	<?php if ($key->Link == NULL) {
																		echo $key->Objectif;
																	} else {
																		if ($row->JenisSoal == 1) { ?>
																			<img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PreTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br>
																		<?php } else { ?>
																			<img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PostTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br><br>
																	<?php }
																	} ?>
																</span>
																<i class="fa fa-check"></i>
																<?php 
															} else { ?>
																<input type="radio" id="objectif_id<?php echo $key->IDSoal; ?>" name="objectif<?php echo $key->IDSoal ?>" class="md-radiobtn?>" value="<?php echo $key->IDObjectif; ?>" checked>
																<span style="color:red;">
																	<?php if ($key->Link == NULL) {
																		echo $key->Objectif;
																	} else {
																		if ($row->JenisSoal == 1) { ?>
																			<img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PreTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br>
																		<?php } else { ?>
																			<img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PostTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br><br>
																	<?php }
																	} ?>
																</span>
																<i class="ion-close"></i>
																<?php 
															}
														} elseif ($key->IDObjectif == $jb->IDObjectif) {
															if ($jb->Benar == 0) { ?>
																<input type="radio" id="objectif_id<?php echo $key->IDSoal; ?>" name="objectif<?php echo $key->IDSoal ?>" class="md-radiobtn?>" value="<?php echo $key->IDObjectif; ?>" disabled>
																<span style="color:green;">
																	<?php if ($key->Link == NULL) {
																		echo $key->Objectif;
																	} else {
																		if ($row->JenisSoal == 1) { ?>
																			<img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PreTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br>
																		<?php } else { ?>
																			<img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PostTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br><br>
																	<?php }
																	} ?>
																</span>
																<i class="fa fa-check"></i>
																<?php 
															} else { ?>
																<input type="radio" id="objectif_id<?php echo $key->IDSoal; ?>" name="objectif<?php echo $key->IDSoal ?>" class="md-radiobtn?>" value="<?php echo $key->IDObjectif; ?>" disabled>
																<span style="color:red;">
																	<?php if ($key->Link == NULL) {
																		echo $key->Objectif;
																	} else {
																		if ($row->JenisSoal == 1) { ?>
																			<img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PreTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br>
																		<?php } else { ?>
																			<img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PostTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br><br>
																	<?php }
																	} ?>
																</span>
																<i class="ion-close"></i>
																<?php 
															}
														} else { ?>
															<input type="radio" id="objectif_id<?php echo $key->IDSoal; ?>" name="objectif<?php echo $key->IDSoal ?>" class="md-radiobtn?>" value="<?php echo $key->IDObjectif; ?>" disabled>
															<span>
																<?php if ($key->Link == NULL) {
																	echo $key->Objectif;
																} else {
																	if ($row->JenisSoal == 1) { ?>
																		<img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PreTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br>
																	<?php } else { ?>
																		<img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PostTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br><br>
																<?php }
																} ?>
															</span>
															<?php 
														} ?>
													</div>
													<?php 
												}
											}
										}
									}
									?>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-sm-3">
				<div class="table-responsive">
					<table class="table table-bordered table-striped" border="6">
						<thead style="text-align: center;" class="bg-gradient-light">
							<tr>
								<th class="align-middle text-center" rowspan="1" colspan="2">Dibuat Oleh,</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="text-align: center;" colspan="2">
									<?php if ($status == 1) { ?>
										<img src="<?php echo base_url('assets/ttdtraining/Regno/' . $fixregno . '.png'); ?>" style="width:200px; height:150px; background-size:100%; border: 1px;" alt=""><br>
									<?php } else if ($status == 2) { ?>
										<img src="<?php echo base_url('assets/ttdtraining/Fixno/' . $fixregno . '.png'); ?>" style="width:200px; height:150px; background-size:100%; border: 1px;" alt=""><br>
									<?php } ?>
								</td>
							</tr>
							<tr>
								<td style="text-align: left">Nama</td>
								<td style="text-align: left">: <?= $nama; ?></td>
							</tr>
						</tbody>
						<tfoot>
							<tr class="bg-gradient-light">
								<th colspan="6"></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
	// $('.navbar-header .navbar-brand small').prop('style', 'display:none');
	$('.navbar-buttons').prop('style', 'display:none');
	$('#menu-toggler').prop('style', 'display:none');
	$('head title').text('PostTest/PreTest Training Online');
	$('.navbar-header .navbar-brand small').empty().append('Hasil Training Materi <?php echo ucfirst($Materi) ?>');
</script>