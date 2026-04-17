<div class="page-header">
    <h1>
        REGISTRASI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Input Karyawan Bermasalah
        </small>
    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">
    	<form id="formRegistrasi" class="form-horizontal" method="POST">
            <input type="hidden" name="txtConfirm" id="inputConfirm" value="0" readonly="">
            <fieldset>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="alert alert-block alert-danger"></button>
                            <i class="ace-icon fa fa-warning red"></i>
                            <strong>Warning!!</strong> Registrasi Karyawan Bermasalah masih tahap pengembangan..<br>
                        </div>
                    </div>   
                    <div class="col-xs-12">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4 class="widget-title">Registrasi Karyawan Bermasalah</h4>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="widget-body">
                                <div class="widget-main">
                                    <div class="well-sm">
                                    	<div class="row">
                                    		<div class="col-xs-12 col-sm-6 col-md-3"></div>
                                    		<div class="col-xs-12 col-sm-6 col-md-6">
                                    			<div class="input-group">
                                    				<input  type="text" maxlength="6" id="findByNIK" name="txtFindByNIK" autocomplete="off" placeholder="Input NIK (Nomor Induk Karyawan)" class="form-control" required="required"/>
                                    				<div class="input-group-btn">
                                    					<button type="button" class="btn btn-default no-border btn-sm" id="btnFind">
                                    						<i class="ace-icon fa fa-search icon-on-right bigger-110"></i>
                                    					</button>
                                    				</div>
                                    			</div>
                                    		</div>
                                    		<div class="col-xs-12 col-sm-6 col-md-3"></div>
                                    	</div>
                                    	<div class="hr hr-dotted"></div>
                                    	<div class="row" id="ajaxFormHeader">
                                    		<div class="col-xs-12">
                                    			<form class="form-horizontal" role="form">
                                    				<div class="form-group">
                                    					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> NAMA </label>
                                    					<div class="col-sm-8">
                                    						<input type="text" id="inputNAMA" name="txtNAMA" placeholder="NAMA" class="col-xs-10 col-sm-6" required=""  readonly="" />
                                    					</div>
                                    				</div>
                                    				<div class="form-group">
                                    					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Perusahaan/ CV </label>
                                    					<div class="col-sm-8">
                                    						<input type="text" id="inputPerusahaan" name="txtPerusahaan" placeholder="Perusahaan/ CV" class="col-xs-10 col-sm-6" required=""  readonly="" value="PT. PULAU SAMBU GUNTUNG" />
                                    					</div>
                                    				</div>
                                    				<div class="form-group">
                                    					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Pemborong </label>
                                    					<div class="col-sm-8">
                                    						<input type="text" id="inputPemborong" name="txtPemborong" placeholder="Perusahaan/ CV" class="col-xs-10 col-sm-6" required=""  readonly="" value="YAO HSING" />
                                    					</div>
                                    				</div>
                                    				<div class="form-group">
                                    					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Departement </label>
                                    					<div class="col-sm-8">
                                    						<input type="text" id="inputDept" name="txtDept" placeholder="Departement" class="col-xs-10 col-sm-6" required=""  readonly="" />
                                    					</div>
                                    				</div>
                                    				<div class="form-group">
                                    					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Tanggal Masuk </label>
                                    					<div class="col-sm-8">
                                    						<input type="text" id="inputTglMasuk" name="txtTglMasuk" placeholder="Tanggal Masuk" class="col-xs-10 col-sm-6" required=""  readonly="" />
                                    					</div>
                                    				</div>
                                    				<div class="form-group">
                                    					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Tanggal Keluar </label>
                                    					<div class="col-sm-8">
                                    						<input type="text" id="inputTglKeluar" name="txtTglKeluar" placeholder="Tanggal Keluar" class="col-xs-10 col-sm-6" required=""  readonly="" />
                                    					</div>
                                    				</div>
                                    				<div class="form-group">
                                    					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Nama Ibu Kandung </label>
                                    					<div class="col-sm-8">
                                    						<input type="text" id="inputNamaIbuKandung" name="txtNamaIbuKandung" placeholder="Nama Ibu Kandung" class="col-xs-10 col-sm-6" required=""  readonly="" />
                                    					</div>
                                    				</div>
                                    				<div class="form-group">
                                    					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Keterangan </label>
                                    					<div class="col-sm-8">
                                    						<textarea name="txtRemark" id="inputRemark" class="col-xs-10 col-sm-6"></textarea>
                                    					</div>
                                    				</div>
                                    			</form>
                                    		</div>
                                    	</div>
                                    	<div class="clearfix form-actions">
                                        <div class="col-md-offset-5 col-md-6">
                                            <button class="btn btn-info" type="submit" id="btnSimpan">
                                                <i class="ace-icon fa fa-check bigger-110"></i>
                                                Submit
                                            </button>
                                            <button class="btn" type="reset">
                                                <i class="ace-icon fa fa-undo bigger-110"></i>
                                                Reset
                                            </button>
                                        </div>
                                    </div>
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
<script>
	var urlGetData = = '<?= base_url() ?>Blacklist/getDataKaryawanByNIK';
</script>