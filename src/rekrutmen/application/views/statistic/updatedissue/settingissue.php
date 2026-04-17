<div class="row">
	<div class="col-xs-12">
		<?php foreach ($getissue as $row):
		$att = array('class'=>'form-horizontal', 'role'=>'form');
		echo form_open('statistic/updatestatusissue?id='.$row->DetailID, $att);
			$target           = $row->TKTarget;
            $sedia            = $row->TKSedia;
            $minta            = $row->TKPermintaan;
            $jumlahID         = $row->Identifikasi;
            
            $sisa             = $target-$sedia;
            $penuhi           = $sisa-$minta;
            $diidentifikasi   = $jumlahID-($penuhi);
        ?>
		<from class="form-horizontal" method="POST" role="form" action="<?php echo site_url('statistic/updatestatusissue');?>">			
            <input type="hidden" name="txtDetailID" id="inputDetailID" value="<?php echo $row->DetailID;?>">
			<div class="col-xs-12">
				<div class="form-group">
					<label class="col-sm-4 control-label">Departemen</label>
					<div class="col-sm-5">
						<input type="text" class="form-control input-sm" name="txtDept" value="<?php echo $row->DeptAbbr;?>" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Division</label>
					<div class="col-sm-5">
						<input type="text" class="form-control input-sm" name="txtDiv" value="<?php echo $row->NamaDivisi;?>" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Position</label>
					<div class="col-sm-5">
						<input type="text" class="form-control input-sm" name="txtPosisi" value="<?php echo $row->Pekerjaan;?>" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Total Needed</label>
					<div class="col-sm-5">
						<input type="text" class="form-control input-sm" name="txtMinta" value="<?php echo $minta;?>" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Full Filled</label>
					<div class="col-sm-5">
						<input type="text" class="form-control input-sm" name="txtPenuhi" value="<?php echo $penuhi;?>" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Unfilled</label>
					<div class="col-sm-5">
						<input type="text" class="form-control input-sm" name="txtSisa" value="<?php echo $sisa;?>" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Explanation For Unfulfilled</label>
					<div class="col-sm-5">
						<textarea type="text" class="form-control input-sm" name="txtPenjelasan"></textarea> 
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Solution (IF Aplicable)</label>
					<div class="col-sm-5">
						<textarea type="text" class="form-control input-sm" name="txtSolisi"></textarea> 
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Date Of Fulfillment</label>
					<div class="col-sm-5">
						<input type="text" class="form-control input-sm date-picker" name="txtPemenuhan" id="id-date-picker-1">
					</div>
				</div>
			</div>
			<div class="col-sm-12 text-right">
                <hr style="border:0;height:1px;background-image:linear-gradient(to right,rgba(0,0,0,0),rgba(125,115,191,1),rgba(0,0,0,0));">
                <button id="btnSubmit" type="submit" class="btn btn-sm btn-primary"> <b>Simpan</b></button>
                <button id="btnCancel" type="reset" class="btn btn-sm btn-danger"> <b>Batal</b></button>
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
	});
</script>