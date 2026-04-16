<script src="<?php echo base_url();?>assets/zebra/lib/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/zebra/lib/zebra_datepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/zebra/lib/css/default.css">

<div class="page-header">
    <h1>
        REGISTRASI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Input Tenaga Kerja Bermasalah
        </small>
    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">
        <?php $att = array('class' => 'form-horizontal', 'role' => 'form');
        echo form_open('Blacklist/saveTK', $att);?>
    	<form id="formRegistrasi" class="form-horizontal" method="POST">
            <input type="hidden" name="txtConfirm" id="inputConfirm" value="0" readonly="">
            <fieldset>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="alert alert-block alert-danger"></button>
                            <i class="ace-icon fa fa-warning red"></i>
                            <strong>Warning!!</strong> Registrasi Tenaga Kerja Bermasalah masih tahap pengembangan..<br>
                        </div>
                    </div>   
                    <div class="col-xs-12">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4 class="widget-title">Registrasi Tenaga Kerja Bermasalah</h4>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="widget-body">
                                <div class="widget-main">
                                    <div class="form-group">
                                    	<label class="col-sm-2 control-label margin">Cari Tenaga Kerja by NIK</label>
                                    	<div class="col-sm-9 input-group margin">
                                    		<input type="text" class="form-control" required="required" placeholder="Input NIK (Nomor Induk Karyawan)" autocomplete="off" name="txtFindBynik" id="findBynik">
                                    		<span class="input-group-btn">
                                    			<button type="button" id="btnFind" class="btn btn-success btn-flat"> Go!</button>
                                    		</span>
                                    	</div>
                                    </div>
                                    <div class="row" id="ajaxFormHeader">
                                    	<div class="col-xs-6">
                                    		<div class="form-group">
                                    			<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> NAMA</label>
                                    			<div class="col-sm-9">
                                    				<input type="text" name="txtnama" id="nama" placeholder="NAMA" class="form-control" readonly>
                                    			</div>
                                    		</div>
                                    		<div class="form-group">
                                    			<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> NIK</label>
                                    			<div class="col-sm-9">
                                    				<input type="text" name="txtFindBynik" id="findBynik" placeholder="NIK" class="form-control" readonly>
                                    			</div>
                                    		</div>
                                    		<div class="form-group">
                                    			<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> PERUSAHAAN/CV</label>
                                    			<div class="col-sm-9">
                                    				<input type="text" name="txtperusahaan" id="perusahaan" placeholder="PERUSAHAAN/CV" class="form-control" readonly>
                                    			</div>
                                    		</div>
                                    		<div class="form-group">
                                    			<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> PEMBORONG</label>
                                    			<div class="col-sm-9">
                                    				<input type="text" name="txtpemborong" id="pemborong" placeholder="PEMBORONG" class="form-control" readonly>
                                    			</div>
                                    		</div>
                                    	</div>
                                    	<div class="col-xs-6">
                                    		<div class="form-group">
                                    			<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> DEPARTEMEN
                                    			</label>
                                    			<div class="col-sm-9">
                                    				<input type="text" name="txtdept" id="dept" placeholder="DEPARTEMEN" class="form-control" readonly>
                                    			</div>
                                    		</div>
                                    		<div class="form-group">
                                    			<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> TANGGAL MASUK</label>
                                    			<div class="col-sm-9">
                                    				<input type="text" name="txttglmasuk" id="tglmasuk" placeholder="TANGGAL MASUK" class="form-control" readonly>
                                    			</div>
                                    		</div>
                                    		<div class="form-group">
                                    			<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> TANGGAL KELUAR</label>
                                    			<div class="col-sm-9">
                                    				<input type="text" name="txttglkeluar" id="tglkeluar" placeholder="TANGGAL KELUAR" class="form-control" readonly>
                                    			</div>
                                    		</div>
                                    		<div class="form-group">
                                    			<label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> NAMA IBU KANDUNG</label>
                                    			<div class="col-sm-9">
                                    				<input type="text" name="txtnmibukandung" id="nmibukandung" placeholder="NAMA IBU KANDUNG" class="form-control" readonly>
                                    			</div>
                                    		</div>
                                    	</div>
                                    	<div class="col-xs-12">
                                    		<div class="form-group">
                                    			<label class="col-sm-2 control-label no-padding-right" for="form-field-1" style="text-align: left;"> KETERANGAN</label>
                                    			<div class="col-sm-10">
                                    				<input name="txtketerangan" id="keterangan" placeholder="KETERANGAN" class="form-control">
                                    			</div>
                                    		</div>
                                    	</div>
                                    </div>
                                </div>
                                <div class="clearfix form-actions">
                                	<div class="col-md-offset-5 col-md-7">
                                		<button type="submit" class="btn btn-info" id="btnSimpan" disabled="true">
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
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<!-- <script type="text/javascript">
	$("#btnFind").click(function(){
		var nik = document.getElementById('findByNIK').value;
		if(nik == ''){
		}else{
			$.ajax({
				type: "POST",
				url : "<?php echo site_url('Blacklist/ajaxblacklist')?>"+"/"+nik,
				success: function(msg){
					$('#ajaxFormHeader').html(msg);
				}
			});
			document.getElementById('btnSimpan').disabled = false;
		}
	});
</script> -->

<script type="text/javascript">
    $("#btnFind").click(function(){
        var nik = $('#findBynik').val();
//        alert("<?php // echo site_url('IssueIjinCuti/ajaxFormHeader')?>"+"/"+nik);
        if(nik == ''){

        }else{
            $.ajax({
                type: "POST",
                url : "<?php echo site_url('Blacklist/ajaxblacklistTK')?>"+"/"+nik,
                success: function(msg){
                    $('#ajaxFormHeader').html(msg);
                }
            });
            document.getElementById('btnSimpan').disabled = false;
        }
        
    });
</script>