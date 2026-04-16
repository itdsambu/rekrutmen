<div class="page-header">
	<h1>
		MONITOR
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			Ideal Karyawan dan Tenaga Kerja
		</small>
	</h1>
</div>
<div class="row">
    <div class="col-md-12">                    
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="caption">                            
                    <span class="caption-subject font-green-sharp bold uppercase">Ideal Karyawan dan Tenaga Kerja</span>
                </div>
            </div>
            <div class="panel-body">
            	<div class="row" style="padding-bottom: 20px">
                    <div class="col-xs-12">
                        <form action="<?php echo current_url();?>" role="form" method="POST" class="form-horizontal">
                            <div class="form-group-sm">
                                <label class="control-label col-sm-5">Periode</label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input name="txtPeriode" class="form-control datepick-month input-sm" type="text" placeholder="pilih tahun" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-xs btn-primary" type="submit">
                                                <i class="ace-icon fa fa-send-o"></i>Submit
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success">
                            <h5 class="uppercase"><strong>Periode Aktif : <?php echo $periodeaktif; ?></strong></h5>
                        </div>
                    </div>
                </div>
                <div id="tblIssued" class="table-responsive">
                	<table id="dataTables-issue" class="table table-bordered table-striped table-condensed flip-content flip-scroll">
                        <thead class="flip-content">
                            <tr>
                                <th>Dept</th>
	          			        <th>Ideal Kry</th>
	          			        <th>Existing</th>
	                            <th>Req. Kry Approve</th>
								<th>Req. Kry Pending</th>
	                            <th>Ideal TK</th>
	                            <th>Real TK</th>
	                            <th>Req. TK Approve</th>
								<th>Req. TK Pending</th>
								<th>Periode</th>
								<th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php 
                        	$Ikar = 0; $RKar = 0; $Kapp = 0; $Kpen = 0; $IBor = 0; $RBor = 0; $Bapp = 0; $Bpen = 0; foreach($_getData as $row){
                        	$Ikar += $row->IKry; $RKar += $row->RKry; $Kapp += $row->PERMINTAANKARApp; $Kpen += $row->PERMINTAANKARPending; $IBor += $row->IBor; $RBor += $row->RBor; $Bapp += $row->PERMINTAANBORApp; $Bpen += $row->PERMINTAANBORPending;
                        	?>
                        	<tr data-id="<?php echo $row->DeptAbbr;?>">
                        		<td><?php echo $row->DeptAbbr?></td>
                        		<td><?php echo $row->IKry?></td>
	          			        <td><?php echo $row->RKry?></td>
	                            <td><?php echo $row->PERMINTAANKARApp?></td>
								<td><?php echo $row->PERMINTAANKARPending?></td>
	                            <td><?php echo $row->IBor?></td>
	                            <td><?php echo $row->RBor?></td>
	                            <td><?php echo $row->PERMINTAANBORApp?></td>
								<td><?php echo $row->PERMINTAANBORPending?></td>
								<td><?php echo $row->Periode?></td>
								<td><a data-rel="tooltip" class="detailReview btn btn-minier btn-white btn-block btn-sm"><i class="ace-icon fa fa-files-o bigger-100"></i> Detail</a></td>
                        	</tr>
                        	<?php } ?>
                        </tbody>
                        <tfoot>
	    			    	<tr>
	          			        <th  style="text-align:left">Grand Total:</th>
	          			        <th><?php echo $Ikar;?></th>
	          			        <th><?php echo $RKar;?></th>
	                            <th><?php echo $Kapp;?></th>
								<th><?php echo $Kpen;?></th>
	                            <th><?php echo $IBor;?></th>
	          			        <th><?php echo $RBor;?></th>
	                            <th><?php echo $Bapp;?></th>
								<th><?php echo $Bpen;?></th>
								<th></th>
								<th></th>
	       				    </tr>
	    			    </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="viewModalReview" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Review Tenaga Kerja yang memenuhi Permintaan</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="detailReview" class="well">
                        <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">				
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-issue').dataTable();
    });

    $("#dataTables-issue").on("click", ".detailReview", function() {
        var id = $(this).closest('tr').data('id');
        $.ajax({
            url:"<?php echo site_url('Monitor/reviewIdeal');?>",
            type:"POST",
            data:"kode="+id,
            datatype:"json",
            cache:false,
            success:function(msg){
                $("#detailReview").html(msg);
            }				
        });
        $("#viewModalReview").modal("show");
    });
</script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" />

<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-timepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/moment.js"></script>
                
<script type="text/javascript">
    jQuery(function($) {
        $('.datepick-month').datepicker({
            autoclose:true,
            format: 'yyyy'
        });
    });
</script>