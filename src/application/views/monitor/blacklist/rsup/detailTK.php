<h4 class="row header smaller lighter red">
	<span class="col-sm-8">
		<i class="ace-icon fa fa-bell-o"></i>
		<strong> Informasi Data Tenaga Kerja Bermasalah RSUP</strong>
	</span>
</h4>
<div class="row">
	<?php foreach($data as $row):?>
	<div class="col-xs-12">
		<div class="widget-box transparent">
			<div class="widget-body">
				<div class="widget-main padding-24">
					<div class="row">
						<div class="col-sm-4">
							<span class="profile-picture">
		                        <!-- <?php if($row->AdaPhotoOnline == NULL):?>
			                    	<ul class="ace-thumbnails clearfix">
			                    		<li>
			                    			<img id="avatar" class="img-responsive" width="180" height="180" alt="<?php echo $row->RegNo;?>'s avatar" src="<?php echo base_url();?>/assets/avatar/profile-pic.jpg"></img>
			                    			<div class="tools tools-right" id="photo">
			                    				<a href="#" title="Change Photo" class="changePhoto" data-id="<?php echo trim($row->RegNo);?>">
			                    					<i class="ace-icon fa fa-edit"></i>
			                    				</a>
			                    			</div>
			                    		</li>
			                    	</ul>
			                    <?php else:?>
			                    	<ul class="ace-thumbnails clearfix">
			                    		<li>
			                    			<img id="avatar" class="img-responsive" width="180" height="180" alt="<?php echo trim($row->RegNo);?>'s avatar" src="<?php echo base_url();?>dataupload/bypass/<?php echo trim($row->Detail);?>.jpg"></img>
			                    			<div class="tools tools-right" id="photo">
			                    				<a href="#" title="Change Photo" class="changePhoto" data-id="<?php echo trim($row->RegNo);?>">
			                    					<i class="ace-icon fa fa-edit"></i>
			                    				</a>
			                    			</div>
			                    		</li>
			                    	</ul>
			                    <?php endif;?> -->
								<ul class="ace-thumbnails clearfix">
									<li>
										<img id="avatar" class="img-responsive" width="180" height="180" alt="<?php echo trim($row->RequestID);?>'s avatar" src="http://192.168.12.235/rekrutmen/dataupload/foto/<?php echo trim($row->RequestID);?>.jpg"></img>
										<div class="tools tools-right" id="photo">
											<a href="#" title="Change Photo" class="changePhoto" data-id="<?php echo trim($row->RequestID);?>">
												<i class="ace-icon fa fa-edit"></i>
											</a>
										</div>
									</li>
								</ul>
		                    </span>
						</div>
						<div class="col-sm-8">
							<div>
								<ul class="list-unstyled spaced">
									<li>
										NIK : <b class="red"> <?php echo $row->Nik;?></b>
									</li>
									<li>
										Requets ID : <b class="red"> <?php echo $row->RequestID;?></b>
									</li>
									<li>
										No.Fix : <b class="red"> <?php echo $row->Nofix;?></b>
									</li>
									<li>
										NAMA : <b class="red"> <?php echo $row->Nama;?></b>
									</li>
									<li>
										TANGGAL LAHIR : <b class="red"><?php echo strtoupper($row->TempatLahir);?>,<?php echo date('d-m-Y',strtotime($row->TanggalLahir));?></b>
									</li>
									<li>
										Perusahaan : <b class="red"> <?php echo $row->Perusahaan;?></b>
									</li>
									<li>
										Pemborong : <b class="red"> <?php echo $row->Pemborong;?></b>
									</li>
									<li>
										Departement : <b class="red"> <?php echo $row->Bagian;?></b>
									</li>
									<li>
										Tanggal Masuk : <b class="red"> <?php echo date('d-m-Y', strtotime($row->TanggalMasuk));?></b>
									</li>
									<li>
										Tanggal Keluar : <b class="red"> <?php if ($row->TanggalKeluar == NULL){echo '';}else{echo date('d-m-Y', strtotime($row->TanggalKeluar));};?></b>
									</li>
									<li>
										Tanggal Keluar Temporary: <b class="red"> <?php if ($row->TanggalKeluarTemporary == NULL){echo '';}else{echo date('d-m-Y', strtotime($row->TanggalKeluarTemporary));};?></b>
									</li>
									<li>
										Nama Ibu : <b class="red"> <?php echo $row->NamaIbuKandung;?></b>
									</li>
									<li>
										KETERANGAN : <b class="red"> <?php echo $row->ketKeluar;?></b>
									</li>
									<!--li>
										Status : <b class="red"> <?php echo $row->Status;?></b>
									</li> -->
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach;?>
</div>