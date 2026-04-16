<?php
    $this->load->view('template/sweetAlert');
    $this->load->view('template/formPicker');
    $this->load->view('template/formValidation');
?>
<div class="page-header">
    <h1>
        Transaksi
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Kuota Pemboronga
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12" id="controlsetup">
        <div class="panel panel-primary">
	        <div class="panel-heading">
		        <h3 class="panel-title">Update Kouta Pemborong</h3>
		    </div>
		    <div class="panel-body">
		    	<div class="row">
		    		<div class="col-sm-12">
		    			<form id="kuota" class="form-horizontal" role="form" method="POST">
		    				<div class="form-group">
		    					<label class="control-label col-sm-4">Periode</label>
		    					<div class="col-sm-4">
									<div class="input-group">
										<input class="form-control date-picker" name="txtPeriode" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" value="<?= $_periode;?>"/>
										<span class="input-group-addon">
											<i class="fa fa-calendar bigger-110"></i>
										</span>
									</div>

								</div>
		    				</div>
		    				<div class="form-group">
		    					<label class="control-label col-sm-4">CV</label>
		    					<div class="col-sm-4">
		    						<select class="form-control" name="txtPerusahaan" id="inputPerusahaan">
	                                    <option value=""> -- Silahkan Pilih Perusahaan</option>
	                                    <?php foreach ($_getPSGPemorong as $rowCV): ?>
	                                    <option value='<?php echo $rowCV->Perusahaan; ?>'><?php echo $rowCV->Perusahaan; ?></option>
	                                    <?php endforeach; ?>
	                                </select>
		    					</div>
		    				</div>
		    				<div class="form-group">
                                <label class="col-sm-4 control-label"> Pemborong </label>
                                <div class="col-sm-4">
                                    <div id="pt">
                                        <input type="text" id="inputPemborong" name="txtPemborong" placeholder="Pemborong Auto Value" class="form-control" readonly="" required=""/>
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                $("#inputPerusahaan").change(function () {
                                    var selectValues = $("#inputPerusahaan").val();
                                    if (selectValues === 0) {
                                        var msg = "<input class=\"form-control\" name=\"txtPemborong\" id=\"inputPemborong\" placeholder=\"Nama Perusahaan\" type=\"text\" value='' readonly />";
                                        $('#pt').html(msg);
                                    } else {
                                        var pemborong = {pemborong: $("#inputPerusahaan").val()};
                                        $.ajax({
                                            type: "POST",
                                            url: "<?php echo site_url('registrasi/selectPemborong') ?>",
                                            data: pemborong,
                                            success: function (msg) {
                                                $('#pt').html(msg);
                                            }
                                        });
                                    }
                                });
                            </script>
		    				<div class="form-group">
		    					<label class="control-label col-sm-4">Jumlah Kouta</label>
		    					<div class="col-sm-4">
		    						<input type="text" name="txtJmlKouta" onkeypress="return isNumber(event)" id="inputkouta" class="form-control">
		    					</div>
		    				</div>
		    				<div class="form-group">
		    					<label class="control-label col-sm-4">Batas Penginputan</label>
		    					<div class="col-sm-4">
		    						<!-- <div class="input-group bootstrap-timepicker">
										<input id="timepicker1" type="text" name="txtBatasInput" class="form-control" />
										<span class="input-group-addon">
											<i class="fa fa-clock-o bigger-110"></i>
										</span>
									</div> -->
		    					</div>
		    				</div>
		    				<!-- <div class="form-group">
		    					<label class="control-label col-sm-4">Jadwal</label>
		    					<div class="col-sm-4">
		    						<select class="form-control" name="txtJadwal" id="form-field-select-1">
										<option value="">-- pilih --</option>
										<option value="Pagi">Pagi</option>
										<option value="Siang">Siang</option>
									</select>
		    					</div>
		    				</div> -->
		    				<div class="clearfix form-actions">
                            	<div class="col-md-offset-5 col-md-7">
                            		<button type="button" class="btn btn-info" id="btnSimpan">
                            			<i class="ace-icon fa fa-check bigger-110"></i>
                            			Submit
                            		</button>
                            		<button type="reset" class="btn">
                            			<i class="ace-icon fa fa-undo bigger-110">
                            				Reset
                            			</i>
                            		</button>
                            	</div>
                            </div>
		    			</form>
		    		</div>
		    	</div>
		    </div>
	    </div>
	</div>
</div>
<div class="row">
    <div class="col-xs-12" id="controlsetup">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Update Kouta Pemborong</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form id="kuota" class="form-horizontal" role="form" method="POST">
                            <div class="form-group">
                                <label class="control-label col-sm-4">Periode</label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input class="form-control date-picker" name="txtPeriode" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" value="<?= $_periode;?>"/>
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Start Input</label>
                                <div class="col-sm-2">
                                    <div class="input-group bootstrap-timepicker">
                                        <input id="timepicker1" type="text" name="txtStartInput" class="form-control" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-clock-o bigger-110"></i>
                                        </span>
                                    </div>
                                </div>
                                <label class="control-label col-sm-2">End Input</label>
                                <div class="col-sm-2">
                                    <div class="input-group bootstrap-timepicker">
                                        <input id="timepicker2" type="text" name="txtBatasInput" class="form-control" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-clock-o bigger-110"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-primary table-colored table-hover">
                                        <thead>
                                            <tr>
                                                <th>CV</th>
                                                <th>Pemborong</th>
                                                <th>Kuota Pendidikan</th>
                                                <th>Kuota Non Pendidikan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($_getdatekuota as $r){?>
                                            <tr>
                                                <td><input type="hidden" name="txtPerusahaan[]" id="inputPerusahaan" value="<?= $r->Perusahaan;?>"><?= $r->Perusahaan;?></td>
                                                <td><input type="hidden" name="txtPerusahaan[]" id="inputPerusahaan" value="<?= $r->Perusahaan;?>"><?= $r->Pemborong;?></td>
                                                <td><input type="text" name="txtKuotaPendidikan[]" id="inputKuotaPendidikan"></td>
                                                <td><input type="text" name="txtKuotaNonPendidikan[]" id="inputKuotaNonPendidikan"></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="clearfix form-actions">
                                    <div class="col-md-offset-5 col-md-7">
                                        <button type="button" class="btn btn-info" id="btnSimpan">
                                            <i class="ace-icon fa fa-check bigger-110"></i>
                                            Submit
                                        </button>
                                        <button type="reset" class="btn">
                                            <i class="ace-icon fa fa-undo bigger-110">
                                                Reset
                                            </i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var urlSubmit = '<?= base_url()?>Transaksi/saveKouta'
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" />

<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-timepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/moment.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/toExcel/jquery-1.10.2.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">
    $(".inputPerusahaan").change(function () {
        var selectValues = $(".inputPerusahaan").val();
        if (selectValues === 0) {
            var msg = "<input class=\"form-control inputPemborong\" name=\"txtPemborong[]\" id=\"inputPemborong\" placeholder=\"Nama Perusahaan\" type=\"text\" value='' readonly />";
            $('#pt').html(msg);
        } else {
            var pemborong = {pemborong: $(".inputPerusahaan").val()};
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('transaksi/selectPemborong') ?>",
                data: pemborong,
                success: function (msg) {
                    $('#pt').html(msg);
                }
            });
        }
    });
</script>

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

        $('#timepicker2').timepicker({
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
<script>
jQuery(document).ready(function(){
    $('#btnSimpan').click(function(){
        $('#kuota').attr('action',urlSubmit);
        swal({
            title: "Data akan disimpan?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true
        },function(isConfirm){
            if(isConfirm){
                $('#kuota').submit();
                if($('#kuota').parsley().validate()){
                    $('#kuota').submit();
                }
            }
            $('#kuota').attr('action','');
        });
    });  
});
</script>
<script>
    function isNumber(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if(charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>