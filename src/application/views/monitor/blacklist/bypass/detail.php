<h4 class="row header smaller lighter red">
	<span class="col-sm-8">
		<i class="ace-icon fa fa-bell-o"></i>
		<strong> Informasi Data Blacklist By Pass</strong>
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
		                        <?php if($row->AdaPhoto == NULL):?>
			                    	<ul class="ace-thumbnails clearfix">
			                    		<li>
			                    			<img id="avatar" class="img-responsive" width="180" height="180" alt="<?php echo $row->Detail;?>'s avatar" src="<?php echo base_url();?>/assets/avatar/profile-pic.jpg"></img>
			                    			<div class="tools tools-right" id="photo">
			                    				<a href="#" title="Change Photo" class="changePhoto" data-id="<?php echo trim($row->Detail);?>">
			                    					<i class="ace-icon fa fa-edit"></i>
			                    				</a>
			                    			</div>
			                    		</li>
			                    	</ul>
			                    <?php else:?>
			                    	<ul class="ace-thumbnails clearfix">
			                    		<li>
			                    			<img id="avatar" class="img-responsive" width="180" height="180" alt="<?php echo trim($row->Detail);?>'s avatar" src="<?php echo base_url();?>dataupload/bypass/<?php echo trim($row->Detail);?>.jpg"></img>
			                    			<div class="tools tools-right" id="photo">
			                    				<a href="#" title="Change Photo" class="changePhoto" data-id="<?php echo trim($row->Detail);?>">
			                    					<i class="ace-icon fa fa-edit"></i>
			                    				</a>
			                    			</div>
			                    		</li>
			                    	</ul>
			                    <?php endif;?>
		                    </span>
						</div>
						<div class="col-sm-8">
							<div>
								<ul class="list-unstyled spaced">
									<li>
										Detail : <b class="red"> <?php echo $row->Detail;?></b>
									</li>
									<li>
										NAMA : <b class="red"> <?php echo $row->Nama;?></b>
									</li>
									<li>
										TANGGAL LAHIR : <b class="red"> <?php echo date('d-m-Y',strtotime($row->Tgl_Lahir));?></b>
									</li>
									<li>
										DAERAH ASAL : <b class="red"> <?php echo $row->Daerah_Asal;?></b>
									</li>
									<li>
										Suku : <b class="red"> <?php echo $row->Suku;?></b>
									</li>
									<li>
										NAMA IBU KANDUNG : <b class="red"> <?php echo $row->Nama_Ibu;?></b>
									</li>
									<li>
										KETERANGAN : <b class="red"> <?php echo $row->Keterangan;?></b>
									</li>
									<li>
										Status : <b class="red"> <?php echo $row->Status;?></b>
									</li>
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