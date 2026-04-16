<div class="row">
	<div class="col-xs-12">
		<?php 
		    $att = array('class'=>'form-horizontal', 'role'=>'form');
		    echo form_open('transaksi/UpdateKuota', $att);
		    foreach ($setKouta as $row):
		?>
		<input name="txtID" value="<?php echo $row->DayNumber;?>" type="hidden" readonly/>
		<div class="form-group">
			<label class="control-label col-sm-3">Hari</label>
			<div class="col-sm-7">
				<input type="text" class="form-control input-sm" name="txtHari" value="<?= $row->DayName?>" readonly>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-3">Kuota</label>
			<div class="col-sm-7">
				<input type="text" class="form-control input-sm" onkeypress="return isNumber(event)" name="txtKuota" value="<?= $row->Kuota?>">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-3">Start Input</label>
			<div class="col-sm-7">
				<div class="input-group bootstrap-timepicker">
					<input id="timepicker1" type="text" name="txtStartInput" class="form-control input-sm" value="<?= date('H:i',strtotime($row->StartInput))?>"/>
					<span class="input-group-addon">
						<i class="fa fa-clock-o bigger-110"></i>
					</span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-3">Batas Input</label>
			<div class="col-sm-7">
				<div class="input-group bootstrap-timepicker">
					<input id="timepicker2" type="text" name="txtBatasInput" class="form-control input-sm" value="<?= date('H:i',strtotime($row->BatasInput))?>"/>
					<span class="input-group-addon">
						<i class="fa fa-clock-o bigger-110"></i>
					</span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-3">Pengumuman</label>
			<div class="col-sm-7">
				<input type="text" class="form-control" name="txtAlert" value="<?= $row->Alert?>">
				<!-- <textarea class="form-control" name="txtAlert" value="<?= $row->Alert?>"></textarea> -->
			</div>
		</div>
		<div class="form-group">
		    <div class="col-md-offset-3 col-md-9">
		        <input class="btn btn-sm btn-info" type="submit" name="simpan" value="Setting">
		    </div>
		</div>
		<?php endforeach;?>
	</div>
</div>
<script>
    function isNumber(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if(charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
<script type="text/javascript">
	jQuery(function($) {
		$('#timepicker1').timepicker({
			minuteStep: 1,
			showSeconds: false,
			showMeridian: false,
			disableFocus: false,
			icons: {
				up: 'fa fa-chevron-up',
				down: 'fa fa-chevron-down'
			}
		}).on('focus', function() {
			$('#timepicker1').timepicker('showWidget');
		}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
		
		('#timepicker2').timepicker({
			minuteStep: 1,
			showSeconds: false,
			showMeridian: false,
			disableFocus: false,
			icons: {
				up: 'fa fa-chevron-up',
				down: 'fa fa-chevron-down'
			}
		}).on('focus', function() {
			$('#timepicker2').timepicker('showWidget');
		}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});

	});
</script>
<!-- <script type="text/javascript">
	jQuery(function($) {
		$('.date-picker').datepicker({
			autoclose: true,
			todayHighlight: true
		});
		$('#timepicker1').timepicker({
			minuteStep: 1,
			showSeconds: false,
			showMeridian: false,
			disableFocus: false,
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
</script> -->