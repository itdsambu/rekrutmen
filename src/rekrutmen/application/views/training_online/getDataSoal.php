<div class="row">
	<div class="col-xs-12">
		<?php 
		$no = 1;
		$jb = 0;
		foreach ($getSoal as $row) { ?>
			<input type="hidden" name="txtSoal" id="soal_id_<?= $jb; ?>" value="<?php echo $row->IDSoal; ?>" class="txt form-control">
			<input type="hidden" name="txtHdrSoal" id="hdr_soal_id_" value="<?php echo $row->IdMstSoalHdr; ?>" class="txt form-control">
			<input type="hidden" name="txtHdrJawaban" id="hdr_id_jawaban" value="<?php echo $hdrid; ?>" class="txt form-control">
			<div class="card m-b-20">
				<div class="card-body">
					<div class="form-group form-md-radios">
						<label for="example-search-input" class="col-sm-12 col-form-label">
							<strong><?php echo $no++ . '. ' . $row->Soal; ?> &nbsp;
								<?php if ($row->Link == NULL) {
									echo "";
								} else {
									$s = 1;
									if ($jenis_soal == 1) { ?>
										<div class="">
											<img src="<?php echo base_url('assets/ttdtraining/GambarSoal/PreTest/' . $row->ID . '.JPG'); ?>" class="img-fluid d-block mx-auto" alt="Responsive image" style="width: 500px;height: 300px;">
										</div>
										<?php 
									} else { ?>
										<div>
											<img src="<?php echo base_url('assets/ttdtraining/GambarSoal/PostTest/' . $row->ID . '.JPG'); ?>" style="width: 500px;height: auto;">
										</div>
										<?php
									}
								} ?>
							</strong>
							
							<?php
							$this->load->model("M_TrainingOnline");
							$jawaban = $this->M_TrainingOnline->_getJawaban();
							foreach ($jawaban as $key) {
								if ($key->IDSoal == $row->IDSoal) { ?>
									<div class="md-radio-list">
										<input type="radio" id="objectif_id<?php echo $key->IDSoal; ?>" name="objectif<?php echo $key->IDSoal ?>" class="md-radiobtn txtobjectif_<?= $jb; ?>" value="<?php echo $key->IDObjectif; ?>">
										<input type="hidden" name="txtDetailID" id="detailid" class="form-control detail_id_<?= $jb; ?>" value="<?php echo $row->DetailID ?>">
										<?php if ($key->Link == NULL) {
											echo $key->Objectif;
										} else {
											if ($jenis_soal == 1) { ?>
												<img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PreTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br>
												<?php 
											} else { ?>
												<img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PostTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br><br>
												<?php 
											}
										} ?>
									</div>
									<?php
								}
							} ?>
						</label>
					</div>
				</div>
			</div>
			<?php 
			$jb++;
		} ?>
	</div>
</div>
<div class="row col-xs-12">
	<label for="example-search-input" class="col-sm-0 col-form-label"></label>
	<br>
	<br>
	<div class="col-sm-12 btn_ttd" align="center">
		<button class="btn btn-lg btn-primary" onclick="viewttd();">Tanda Tangan</button>
		<a href="#" class="btn btn-lg btn-danger">Batal</a>
	</div>
</div>