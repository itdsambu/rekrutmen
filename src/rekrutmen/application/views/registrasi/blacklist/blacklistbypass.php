<script src="<?php echo base_url();?>assets/zebra/lib/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/zebra/lib/zebra_datepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/zebra/lib/css/default.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/select2.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dp/smoothness.datepick.css" />

<!--<script src="<?php echo base_url(); ?>assets/dp/jquery-1.10.2.js"></script>-->
<script src="<?php echo base_url(); ?>assets/dp/jquery.datepick.js"></script>
<script src="<?php echo base_url(); ?>assets/dp/jquery.plugin.js"></script>

<!-- page specific plugin scripts -->
<script src="<?php echo base_url(); ?>assets/js/fuelux/fuelux.wizard.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/additional-methods.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootbox.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.maskedinput.js"></script>
<script src="<?php echo base_url(); ?>assets/js/select2.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.inputlimiter.1.3.1.js"></script>


<div class="page-header">
    <h1>
        REGISTRASI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Input Masyarakat Bermasalah By Pass
        </small>
    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">
        <?php $att = array('class' => 'form-horizontal', 'role' => 'form');
        echo form_open('Blacklist/savebypass', $att);?>
        <form id="formRegistrasi" class="form-horizontal" method="POST">
            <input type="hidden" name="txtConfirm" id="inputConfirm" value="0">
            <fieldset>
                <div class="row">
                    <!--<div class="col-xs-12">
                        <div class="alert alert-block alert-danger"></button>
                            <i class="ace-icon fa fa-warning red"></i>
                            <strong>Warning!!</strong> Registrasi Masyarakat Bermasalah By Pass masih tahap pengembangan..<br>
                        </div>
                    </div>-->   
                    <div class="col-xs-12">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4 class="widget-title">Registrasi Masyarakat Bermasalah By Pass</h4>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="widget-body">
                                <div class="widget-main">
                                    <div class="row" id="ajaxFormHeader">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> NAMA</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="txtnama" id="nama" placeholder="NAMA" class="form-control">
                                                </div>
                                            </div>
											<div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> DAERAH ASAL</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="txtdaerahasal" id="daerahasal" placeholder="DAERAH ASAL" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> SUKU</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="txtsuku" id="findBynik" placeholder="SUKU" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
											<div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> TANGGAL LAHIR</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="txttgllahir" id="tgllahir" placeholder="TANGGAL LAHIR" class="form-control" onkeypress="return isNumber(event)">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> NAMA IBU KANDUNG</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="txtnmibukandung" id="nmibukandung" placeholder="NAMA IBU KANDUNG" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1" style="text-align: left;"> KETERANGAN</label>
                                                <div class="col-sm-9">
                                                    <input name="txtketerangan" id="keterangan" placeholder="KETERANGAN" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix form-actions">
                                    <div class="col-md-offset-5 col-md-7">
                                        <button type="submit" class="btn btn-info" id="btnSimpan">
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
//    $("#btnFind").click(function(){
//        var nik = $('#findBynik').val();
//        alert("<?php // echo site_url('IssueIjinCuti/ajaxFormHeader')?>"+"/"+nik);
//        if(nik == ''){

//        }else{
//            $.ajax({
//                type: "POST",
//                url : "<?php echo site_url('Blacklist/ajaxblacklistTK')?>"+"/"+nik,
//                success: function(msg){
//                    $('#ajaxFormHeader').html(msg);
//                }
//            });
//            document.getElementById('btnSimpan').disabled = false;
//       }
        
//    });

	jQuery(function ($) {
        $('#tgllahir').mask('99-99-9999');
		$('#tglmasuk').mask('99-99-9999');
		$('#tglkeluar').mask('99-99-9999');
		});

	function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<script type="text/javascript">
    jQuery(function($) {
        $('#id-input-file-2').ace_file_input({
            no_file:'Attach image from your storage!',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false //| true | large
//            whitelist:'gif|png|jpg|jpeg',
//            blacklist:'exe|php'
            //onchange:''
            //
        });
        //pre-show a file name, for example a previously selected file
        //$('#id-input-file-1').ace_file_input('show_file_list', ['myfile.txt'])

        $('#id-input-file-3').ace_file_input({
            style:'well',
            btn_choose:'Or drop files here..!',
            btn_change:null,
            no_icon:'ace-icon fa fa-cloud-upload',
            droppable:true,
            thumbnail:'small'
//            whitelist:'gif|png|jpg|jpeg',
//            blacklist:'exe|php'
            ////large | fit
            //,icon_remove:null//set null, to hide remove/reset button
            /**,before_change:function(files, dropped) {
                    //Check an example below
                    //or examples/file-upload.html
                    return true;
            }*/
            /**,before_remove : function() {
                    return true;
            }*/
            ,
            preview_error : function(filename, error_code) {
                    //name of the file that failed
                    //error_code values
                    //1 = 'FILE_LOAD_FAILED',
                    //2 = 'IMAGE_LOAD_FAILED',
                    //3 = 'THUMBNAIL_FAILED'
                    //alert(error_code);
            }

        }).on('change', function(){
                //console.log($(this).data('ace_input_files'));
                //console.log($(this).data('ace_input_method'));
        });


        //$('#id-input-file-3')
        //.ace_file_input('show_file_list', [
                //{type: 'image', name: 'name of image', path: 'http://path/to/image/for/preview'},
                //{type: 'file', name: 'hello.txt'}
        //]);

    });
</script>