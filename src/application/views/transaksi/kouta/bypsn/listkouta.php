<div class="page-header">
    <h1>
        Transaksi
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            List Kouta TK Pemboronga
        </small>
    </h1>
</div>
<?php if(($this->session->userdata('groupuser') == '85')&&($this->session->userdata('groupuser') == '50')){?>
<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
		        <h3 class="widget-title">List Kouta TK Pemborong</h3>
				<div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
                <div class="widget-toolbar no-border">
                    <span id="moExcel">
                        <button class="btn btn-minier btn-success" id="btnModalExcel">
                            <i class="ace-icon fa fa-file-excel-o"></i> Export to Excel
                        </button>
                    </span>
                </div>
		    </div>
		    <div class="panel-body">
		    	<div class="row">
		    		<div class="col-sm-12">
	                    <form class="form-horizontal" role="form" action="<?php echo site_url('transaksi/TransAksi');?>">
			    			<table id="dataTables" class="table table-bordered table-hover table-primary">
			    				<thead class="bg-primary">
			    					<tr>
			    						<th>RegID</th>
	                                    <th>Nama</th>
	                                    <th>CVNama</th>
										<th>Periode</th>
			    					</tr>
			    				</thead>
			    				<tbody>
			    					<?php foreach($_getList as $row){?>
			    					<tr>
			    						<td><?php echo $row->HeaderID?></td>
			    						<td><?php echo $row->Nama?></td>
			    						<td><?php echo $row->CVNama?></td>
										<td><?php echo $row->Periode?></td>
			    					</tr>
			    					<?php } ?>
			    				</tbody>
			    			</table>
				        </form>
		    		</div>
		    	</div>
		    </div>
		</div>
	</div>
</div>
<?php } else { ?>
<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
		        <h3 class="widget-title">List Kouta TK Pemborong</h3>
				<div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
                <div class="widget-toolbar no-border">
                    <span id="moExcel">
                        <button class="btn btn-minier btn-success" id="btnModalExcel">
                            <i class="ace-icon fa fa-file-excel-o"></i> Export to Excel
                        </button>
                    </span>
                </div>
		    </div>
		    <div class="panel-body">
		    	<div class="row">
		    		<div class="col-sm-12">
	                    <form class="form-horizontal" role="form" method="post" action="<?php echo site_url('transaksi/TransAksi');?>">
			    			<table id="dataTables" class="table table-bordered table-hover table-primary">
			    				<thead class="bg-primary">
			    					<tr>
			    						<th>&#10004;</th>
			    						<th>RegID</th>
	                                    <th>Nama</th>
	                                    <th>CVNama</th>
										<th>Periode</th>
			    					</tr>
			    				</thead>
			    				<tbody>
			    					<?php foreach($_getList as $row){?>
			    					<tr>
			    						<td class="text-center">
	                                        <div class="checkbox">
	                                            <label class="pos-rel">
	                                                <input type="checkbox" name="checkVerifi[]" class="ace" value="<?php echo $row->HeaderID;?>">
	                                                <span class="lbl"></span>
	                                            </label>
	                                        </div>
	                                    </td>
			    						<td><?php echo $row->HeaderID?></td>
			    						<td><?php echo $row->Nama?></td>
			    						<td><?php echo $row->CVNama?></td>
										<td><?php echo $row->Periode?></td>
			    					</tr>
			    					<?php } ?>
			    				</tbody>
			    			</table>
						    <div class="widget-toolbox padding-8 clearfix">
				                <div class="well text-center">
				                    <input type="submit" name="Verifi" value="Remove" class="btn btn-danger">
				                </div>
				            </div>
				        </form>
		    		</div>
		    	</div>
		    </div>
		</div>
	</div>
</div>
<?php } ?>
<div class="modal fade" id="modalToExcel" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titleExcel"> Export to Excel</h4>
            </div>
            <div class="modal-body">
                <div class="center">
                    <form class="form-horizontal" id="formExportExcel" action="<?php echo site_url('transaksi/downloadKuotaPBR');?>" method="POST">
					    <div class="form-group">
					        <label class="col-sm-5 control-label right" for="inputTahun">Pilih Tanggal</label>
							<div class="col-sm-6">
								<div class="input-daterange input-group">
									<input type="text" class="input-sm form-control datepick-month" name="txtPeiode" id="inputPeiode" autocomplete="off">
								</div>
							</div>
					    </div>
					    <div class="center">
					        <button class="btn btn-mini btn-success">
					            <i class="ace-icon fa fa-download"></i> Download
					        </button>
					    </div>
					</form>
                </div>
            </div>
        </div>
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
	$(document).ready(function(){
		$('#dataTables').dataTable({
			"order": [[0,'desc']]
		});
		$("#btnModalExcel").click(function () {
            $("#modalToExcel").modal("show");
        });
	})
</script>
<script type="text/javascript">
    jQuery(function($) {
        $('.datepick-month').datepicker({
            autoclose:true,
            format: 'dd-mm-yyyy'
        });
    });
</script>