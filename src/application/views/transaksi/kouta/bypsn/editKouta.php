<div class="row">
	<div class="col-sm-12">
		<?php foreach ($data as $row):
		$att = array('class'=>'form-horizontal', 'role'=>'form');
		echo form_open('transaksi/updateKouta?id='.$row->id, $att);
		?>
		<div class="page-content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-12">
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-horizontal">
										<div class="form-group">
											<label class="control-label col-md-3">Periode</label>
											<div class="input-group col-md-7">
												<input class="form-control date-picker" readonly name="txtPeriode" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" value="<?php echo $row->Periode;?>"/>
												<span class="input-group-addon">
													<i class="fa fa-calendar bigger-110"></i>
												</span>
											</div>
										</div>
										<div class="form-group">
					    					<label class="control-label col-sm-3">Jumlah Kouta</label>
					    					<div class="input-group col-sm-7">
					    						<input type="number" name="txtJmlKouta" onkeypress="return isNumber(event)" value="<?php echo $row->JmlKouta;?>" id="inputkouta" class="form-control">
					    					</div>
					    				</div>
										<div class="form-group">
											<label class="control-label col-sm-4">Batas Penginputan</label>
											<div class="col-sm-4">
												<div class="input-group bootstrap-timepicker">
													<input id="timepicker1" type="text" name="txtBatasInput" value="<?php echo $row->BatasInput;?>" class="form-control" />
													<span class="input-group-addon">
														<i class="fa fa-clock-o bigger-110"></i>
													</span>
												</div>
											</div>
										</div>
					    				<div class="form-group">
					    					<label class="control-label col-sm-9"></label>
					    					<div class="col-sm-3">
					    						<button type="submit" class="btn btn-sm btn-danger right">Save</button>
					    					</div>
					    				</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach;?>
	</div>
</div>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" />

<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-timepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/moment.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/toExcel/jquery-1.10.2.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
	jQuery(function($) {
		$('.date-picker').datepicker({
			autoclose: true,
			todayHighlight: true
		});
		$('#timepicker1').timepicker({
			minuteStep: 1,
			showSeconds: false,
			showMeridian: false,
			icons: {
				up: 'fa fa-chevron-up',
				down: 'fa fa-chevron-down'
			}
		}).on('focus', function() {
			$('#timepicker1').timepicker('showWidget');
		}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});

	});
</script>