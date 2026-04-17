<div class="page-header">
    <h1>
        SCREENING
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Return Screening Oleh Personalia
        </small>
    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12" id="controlsetup">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">List Tenaga Kerja Baru yang Telah Discreening Oleh PSN</h3>
            </div>
            <div class="panel-body">
            	<form class="form-horizontal" role="form" method="POST" action="<?php echo site_url('returnscreening/getdataperperiode'); ?>">
            		<div class="col-xs-12">
            			<div class="form-group">
            				<label class="control-label col-sm-3">Periode</label>
            				<div class="col-sm-4">
            					<div class="input-group">
                                    <!-- mengambil bulan dan tahun pada kalender -->
	                                <input class="form-control date-picker" name="txtPeriode" id="id-date-picker-1" type="text" data-date-format="mm-yyyy" value=""/> 
	                                <span class="input-group-addon">
	                                    <i class="fa fa-calendar bigger-110"></i>
	                                </span>
	                            </div>
            				</div>
            				<div class="col-sm-1 text-left">
            					<button class="btn btn-xs btn-primary">Refresh</button>
            				</div>
            			</div>
            		</div>
            	</form>
            </div>
            <div class="panel-body">
            	<div class="row">
            		<div class="col-md-12">
            			<div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success">
                                    <h5>Periode Aktif : <input type="hidden" name="periode" value="<?php echo $periodeaktif; ?>"> <?php echo $periodeaktif; ?></h5>
                                </div>
                            </div>
                        </div>
                        <form action="<?= base_url('Returnscreening/savescreening')?>" method="POST" role="form" class="form-horizontal">
                			<table id="dataTables" class="table table-striped table-bordered table-hover">
                				<thead class="bg-primary">
                					<tr>
                						<th class="text-center" width="10px">
                                            <label class="pos-rel">
                                                <input type="checkbox" class="ace" onclick="checkUncheckAll(this);">
                                                <span class="lbl"></span>
                                            </label>
                                        </th>
                						<th>RequestID</th>
                						<th>Nama</th>
                						<th>Tujuan Dept</th>
                						<th>Pemborong</th>
                						<th>Tanggal Lahir</th>
                						<th>Jenis Kelamin</th>
                						<th>Status</th>
                						<th>Screening Remark</th>
                						<th>Register</th>
                					</tr>
                				</thead>
                                <tbody>
                                    <?php if(empty($getdata)){?>
                                    
                                    <?php } else { foreach($getdata as $r){?>
                                    <tr data-id="<?php echo $r->HeaderID;?>">
                                        <td class="text-center">
                                            <div class="checkbox">
                                            <label class="pos-rel">
                                                <input name="HeaderID" type="checkbox" class="ace" value="<?php echo $r->HeaderID;?>" >
                                                <span class="lbl"></span>
                                            </label>
                                            </div>
                                        </td>
                                        <td><?php echo $r->HeaderID;?></td>
                                        <td><?php echo $r->Nama;?></td>
                                        <td><?php echo $r->DeptTujuan;?></td>
                                        <td><?php echo $r->Pemborong;?></td>
                                        <td><?php echo $r->Tempat_Lahir.' ,'.date('d-m-Y',strtotime($r->Tgl_Lahir));?></td>
                                        <td><?php echo $r->Jenis_Kelamin;?></td>
                                        <td><?php if($r->SpecialScreening == 1 || $r->ScreeningHasil == 1){echo '<span class="label label-sm label-success">Lulus Screening</span>';}else{echo '<span class="label label-sm label-danger">Gagal Screening</span>';}?></td>
                                        <td><?php echo $r->SpecialScreeningRemark?></td>
                                        <td><?php echo $r->CreatedBy;?><br><small><?php echo date('d-m-Y',strtotime($r->CreatedDate));?></small></td>
                                    </tr>
                                    <?php } } ?>
                                </tbody>
                			</table>
                            <div class="widget-toolbox padding-8 clearfix">
                                <div class="well text-center">
                                    <input type="submit" value="Simpan" name="Submit" class="btn btn-success" >
                                </div>
                            </div>
                        </form>
            		</div>
            	</div>
            </div>
        </div>
    </div>
</div>
<?php if ($this->session->userdata('userid') == 'prog_nia'){echo 'ada';?>
<div class="row">
    <div class="col-sm-12">
        <form class="form-horizontal" enctype="multipart/form-data" action="<?= site_url('Returnscreening/replacephoto')?>" method="post">
            <table id="dataTables2" class="table table-striped table-bordered table-hover">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-center" width="10px">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace">
                                <span class="lbl"></span>
                            </label>
                        </th>
                        <th>Header ID</th>
                        <th>Fix No</th>
                        <th>base64</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($getttd as $row){?>
                    <tr>
                        <td class="text-center">
                            <div class="checkbox">
                            <label class="pos-rel">
                                <input name="checkbox[]" type="checkbox" class="ace" value="<?php echo $row->HeaderID;?>">
                                <span class="lbl"></span>
                            </label>
                            </div>
                        </td>
                        <td><input type="text" value="<?= $row->HeaderID ?>" name="txtheaderid[]" id="headerid"></td>
                        <td><input type="text" value="<?= $row->FixNo ?>" name="txtfixno[]" id="fixno"></td>
                        <td>
                            <input type="text" name="ttdtenaker[]" value="data:image/png;base64,<?php echo base64_encode(file_get_contents("dataupload/ttd/".$row->HeaderID.".png")) ?>" />
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div class="widget-toolbox padding-8 clearfix">
                <div class="well text-center">
                    <input type="submit" value="Replace" name="Submit" class="btn btn-success" >
                </div>
            </div>
        </form>
    </div>
</div>
<?php } ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" />

<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-timepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/moment.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/toExcel/jquery-1.10.2.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
	jQuery(function($) {
        $('#dataTables').dataTable({
            "order": [[0,'desc']]
        });
        // $('#dataTables2').dataTable({
        //     pageLength : 100
        // });
		$('.date-picker').datepicker({
			autoclose: true,
			todayHighlight: true,
			format: 'mm-yyyy'
		});

        // var active_class = 'active';
        // $('#dataTables2 > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
        //     var th_checked = this.checked;//checkbox inside "TH" table header
        //     $(this).closest('table').find('tbody > tr').each(function(){
        //         var row = this;
        //         if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
        //         else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
        //     });
        // });
	});
</script>