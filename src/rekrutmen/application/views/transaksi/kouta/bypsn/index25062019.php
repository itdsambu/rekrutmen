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
		    						<th>Action</th>
		    						<th>Perusahaan/CV</th>
		    						<th>Pemborong</th>
		    						<th>Periode</th>
		    						<th>Jumlah Kouta</th>
		    						<th>Batas Input</th>
		    						<th>Status</th>
		    					</tr>
		    				</thead>
		    				<tbody>
		    					<?php foreach($_getKouta as $row){?>
		    					<tr data-id="<?php echo $row->id;?>">
		    						<td>
		    							<a href="javascript:;" data-rel="tooltip" data-toggle="modal" class="edit btn btn-info btn-xs" title="Edit Kouta"><i class="fa fa-pencil"></i></a></td>
		    						<td><?php echo $row->CVNama;?></td>
		    						<td><?php echo $row->Pemborong;?></td>
		    						<td><?php echo $row->Periode;?></td>
		    						<td><?php echo $row->JmlKouta;?></td>
		    						<td><?php echo $row->BatasInput;?></td>
		    						<td>
		    							<?php if($row->Status == "UNLOCK"){?>
		    							<a href="<?php echo site_url('transaksi/lockKouta')."?id=".$row->id;?>" class="btn btn-primary btn-xs" title="Lock Kouta"><i class="fa fa-unlock"></i></a>
		    							<?php } else { ?>
		    							<a href="<?php echo site_url('transaksi/unlockKouta')."?id=".$row->id;?>" class="btn btn-danger btn-xs" title="Unlock Kouta"><i class="fa fa-lock"></i></a>
		    							<?php } ?>
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