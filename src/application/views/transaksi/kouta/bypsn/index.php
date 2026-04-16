<div class="page-header">
    <h1>
        Transaksi
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Kouta Pemboronga
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12" id="controlsetup">
        <div class="panel panel-primary">
	        <div class="panel-heading">
		        <h3 class="panel-title">Monitor Kouta Pemborong - <?php echo strtoupper($this->session->userdata('userid'));?></h3>
		    </div>
		    <div class="panel-body">
		    	<div class="row">
		    		<?php if($this->session->flashdata('_message')):?>
                    <div class="alert <?= ($_GET['success'] == 'ok'? 'alert-success':'alert-danger')?> alert-dismissible" rolw="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                        <strong><?= ($_GET['success'] == 'ok'? 'Well done':'Oh snap')?>!</strong> <?= $this->session->flashdata('_message')?>
                    </div>
                    <?php endif;?>
		    		<div class="col-sm-12">
		    			<table id="dataTables" class="table table-bordered table-hover table-primary">
		    				<thead class="bg-primary">
		    					<tr>
		    						<th style="text-align: center;" rowspan="2">Action</th>
		    						<th style="text-align: center;" rowspan="2">Perusahaan/CV</th>
		    						<th style="text-align: center;" rowspan="2">Pemborong</th>
		    						<th style="text-align: center;" rowspan="2">Periode</th>
		    						<th style="text-align: center;" colspan="2">Non Pendidikan</th>
		    						<th style="text-align: center;" rowspan="2">Start Input</th>
		    						<th style="text-align: center;" rowspan="2">Batas Input</th>
		    					</tr>
		    					<tr>
		    						<th style="text-align: center;">Kuota</th>
		    						<th style="text-align: center;">Status</th>
		    					</tr>
		    				</thead>
		    				<tbody>
		    					<?php foreach($_getKouta as $row){?>
		    					<tr data-id="<?php echo $row->id;?>">
		    						<td>
		    							<a href="javascript:;" data-rel="tooltip" data-toggle="modal" class="edit btn btn-info btn-xs" title="Edit Kouta"><i class="fa fa-pencil"></i></a></td>
		    						<td>
		    							<?= $row->CVNama;?>
		    						</td>
		    						<td>
		    							<?= $row->Pemborong;?>
		    						</td>
		    						<td>
		    							<?= $row->Periode;?>
		    						</td>
		    						<td>
		    							<?= $row->KuotaNonPendidikan;?>
		    						</td>
		    						<td>
		    							<!-- <?= $row->StsKuotaPendidikan?> -->
		    							<?php if($row->StsKuotaPendidikan == 0){?>
		    							<a href="#" class="btn btn-primary btn-xs" title="Lock Kouta"><i class="fa fa-unlock"></i> Unlock</a>
		    							<?php } else { ?>
		    							<a href="#" class="btn btn-danger btn-xs" title="Unlock Kouta"><i class="fa fa-lock"></i> Lock</a>
		    							<?php } ?>
		    						</td>
		    						<td>
		    							<?= date('H:i',strtotime($row->StartInput));?>
		    						</td>
		    						<td>
		    							<?= date('H:i',strtotime($row->BatasInput))?>
		    						</td>
		    					</tr>
		    					<?php } ?>
		    				</tbody>
		    			</table>
		    		</div>
		    	</div>
		    </div>
		</div>
	</div>
</div>
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dinamiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> Edit Kouta Pemborong</h4>
            </div>
            <div class="modal-body">
            	<input type="hidden" name="idedit" id="inputedit">
            	<div id="edit" class="well">
            		
            	</div>
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables').dataTable({
		"order": [[0,'desc']]
	});
    });
</script>
<script>
	$(document).ready(function(){
		$('[data-rel=tooltip]').tooltip();
		$('#dataTables').on("click", ".edit", function(){
			var id = $(this).closest('tr').data('id');
			$.ajax({
				url 	: "<?php echo site_url('transaksi/editKounta');?>",
				type	: "POST",
				data 	: "kode="+id,
				datatype: "json",
				cache	: false,
				success	: function(msg){
					$("#edit").html(msg);
				}
			});
			$('#viewModal').modal("show");
		});
	})
</script>
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
</script>