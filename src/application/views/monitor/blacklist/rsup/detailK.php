<h4 class="row header smaller lighter red">
	<span class="col-sm-8">
		<i class="ace-icon fa fa-bell-o"></i>
		<strong> Informasi Data Karyawan Bermasalah RSUP</strong>
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
										<img id="avatar" class="img-responsive" width="180" height="180" alt="<?php echo trim($row->RegNo);?>'s avatar" src="http://192.168.12.235/rekrutmen/dataupload/poto/<?php echo trim($row->RegNo);?>.bmp"></img>
										<div class="tools tools-right" id="photo">
											<a href="#" title="Change Photo" class="changePhoto" data-id="<?php echo trim($row->RegNo);?>">
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
										NIK : <b class="red"> <?php echo $row->NIK;?></b>
									</li>
									<li>
										RegNo : <b class="red"> <?php echo $row->RegNo;?></b>
									</li>
									<li>
										NAMA : <b class="red"> <?php echo $row->NAMA;?></b>
									</li>
									<li>
										TANGGAL LAHIR : <b class="red"><?php echo strtoupper($row->TEMPATLHR);?>,<?php echo date('d-m-Y',strtotime($row->TGLLAHIR));?></b>
									</li>
									<li>
										Perusahaan : <b class="red"> PT.RIAU SAKTI UNITED PLANTATIONS</b>
									</li>
									<li>
										Tanggal Masuk : <b class="red"> <?php echo date('d-m-Y', strtotime($row->TGLMASUK));?></b>
									</li>
									<li>
										Tanggal Keluar : <b class="red"> <?php echo date('d-m-Y', strtotime($row->TGLKELUAR));?></b>
									</li>
									<li>
										DAERAH ASAL : <b class="red"> <?php echo $row->ALAMATR;?></b>
									</li>
									<li>
										Suku : <b class="red"> <?php echo $row->SUKU;?></b>
									</li>
									<li>
										KETERANGAN : <b class="red"> <?php echo $row->Blacklist_ket;?></b>
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