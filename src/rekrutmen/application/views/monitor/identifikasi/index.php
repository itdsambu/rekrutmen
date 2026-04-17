<div class="page-header">
	<h1>
		MONITOR
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			Identifikasi Calon Tenaga Kerja
		</small>
	</h1>
</div>
<div class="row">
    <div class="col-xs-12" id="controlsetup">
        <div class="widget-box">
			<div class="widget-header">
                <h4 class="widget-title">List Identifikasi Calon Tenaga Kerja </h4>
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
		    			<form action="" method="POST" role="form" class="form-horizontal">
		    				<div class="col-sm-12">
								<div class="form-group">
									<label class="control-label no-padding-right col-sm-4">Periode</label>
									<div class="col-sm-6">
										<div class="col-sm-6">
	                                        <div class="input-group">
	                                            <input name="txtperiode" class="form-control datepick" type="text" value="<?php echo date('d-m-Y', strtotime($_getperiode));?>" />
	                                            <span class="input-group-btn">
	                                                <button class="btn btn-xs btn-primary" type="submit">
	                                                    <i class="ace-icon fa fa-send-o"></i>Submit
	                                                </button>
	                                            </span>
	                                        </div>
	                                    </div>
									</div>
								</div>
                            </div>
		    			</form>
		    			<div class="row">
		    				<div class="col-sm-12">
		    					<div class="table-responsive">
		    						<table id="dataTables" class="table table-striped table-hover table-bordered">
		    							<thead>
		    								<tr>
		    									<th>ID</th>
		    									<th>Nama</th>
		    									<th>Perusahaan / CV</th>
		    									<th>Pemborong</th>
		    									<th>Departemen</th>
		    									<th>Bagian</th>
		    								</tr>
		    							</thead>
		    							<tbody>
		    								<?php foreach($_select as $r){?>
		    								<tr>
		    									<td><?php echo $r->HeaderID;?></td>
		    									<td><?php echo $r->Nama;?></td>
		    									<td><?php echo $r->CVNama;?></td>
		    									<td><?php echo $r->Pemborong;?></td>
		    									<td><?php echo $r->DeptTujuan;?></td>
		    									<td><?php echo $r->Transaksi;?></td>
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
		</div>
	</div>
</div>

<div class="modal fade" id="modalToExcel" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titleExcel"> Export to Excel</h4>
            </div>
            <div class="modal-body">
                <div class="center">
                    <form class="form-horizontal" id="formExportExcel" action="<?php echo site_url('monitor/downloadIdentifikasi');?>" method="POST">
                        <div class="form-group">
                            <label class="col-sm-5 control-label right" for="inputTahun">Pilih Tanggal</label>
							<div class="col-sm-6">
								<div class="input-daterange input-group">
									<input type="text" class="input-sm form-control datepick" name="dttanggal" id="inputtanggal" autocomplete="off">
								</div>
							</div>
                        </div>
                        <div class="center">
                            <button type="submit" class="btn btn-mini btn-success">
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
        $('.datepick').datepicker({
            autoclose:true,
            format: 'yyyy-mm-dd'
        });
    });
</script>