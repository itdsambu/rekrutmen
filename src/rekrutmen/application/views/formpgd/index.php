<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/css/components.css">
<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/css/core.css">
<?php
    $this->load->view('template/sweetAlert');
    $this->load->view('template/formPicker');
    $this->load->view('template/formValidation');
?>
<div class="page-header">
    <h1>
        INPUT
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Input Surat PGD
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><b> Entry TK Berhenti</b></div>
            <div class="panel-body">
                <?php if($this->session->flashdata('_message')):?>
                    <div class="alert <?= ($_GET['success'] == 'ok'? 'alert-success':'alert-danger')?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                        <strong><?= ($_GET['success']=='ok'? 'Well done':'Oh snap')?>!</strong><?= $this->session->flashdata('_message')?>
                    </div>
                <?php endif;?>
                <!-- <form class="form-horizontal" id="tkpgd" role="form" method="post" > -->
                <?php $att = array('class' => 'form-horizontal', 'role' => 'form');
                echo form_open('Suratpgd/savesuratPGD', $att);?>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label col-md-4">NIK</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" class="form-control input-sm search-query" name="txtFindByid" id="findByid" placeholder="Find by NIK" />
                                    <span class="input-group-btn">
                                        <button type="button" id="btnFind" class="btn btn-purple btn-sm">
                                            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">NIK</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control input-sm search-query" name="txtNIK" id="inputNIK" placeholder="NIK" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">NAMA</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control input-sm search-query" name="txtNAMA" id="inputNAMA" placeholder="NAMA" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">DEPARTEMEN</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control input-sm search-query" name="txtDEPARTEMEN" id="inputDEPARTEMEN" placeholder="DEPARTEMEN" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">JABATAN</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control input-sm search-query" name="txtJABATAN" id="inputJABATAN" placeholder="JABATAN" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">PERUSAHAAN/CV</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control input-sm search-query" name="txtPERUSAHAAN" id="inputPERUSAHAAN" placeholder="PERUSAHAAN/CV" readonly />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">PEMBORONG</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control input-sm search-query" name="txtPEMBORONG" id="inputPEMBORONG" placeholder="PEMBORONG" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">TANGGAL MASUK</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control input-sm search-query" name="txtTANGGALMASUK" id="inputTANGGALMASUK" placeholder="TANGGAL MASUK" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">MESS/BLOK</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control input-sm search-query" name="txtMESS" id="inputMESS" placeholder="MESS/BLOK" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">TANGGAL KELUAR</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control input-sm search-query datepick" name="txtTANGGALKELUAR" id="inputTANGGALKELUAR" placeholder="TANGGAL KELUAR" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">KETERANGAN</label>
                            <div class="col-sm-6">
                                <textarea type="text" class="form-control input-sm search-query" name="txtKETERANGAN" id="inputKETERANGAN" placeholder="KETERANGAN"></textarea>
                            </div>  
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-5 col-md-7">
                                <button type="submit" class="btn btn-info btn-sm" id="btnSimpan">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Submit
                                </button>
                                <button type="reset" class="btn btn-danger btn-sm">
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
<script type="text/javascript">
    jQuery(document).ready(function(){
        $('#btnFind').on('click',function(e){
            var nik = $('#findByid').val();
            if (nik == '') {
                swal({
                    title: "NIK tidak boleh kosong !",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonText: "OK",
                    closeOnConfirm: true
                });
            }else{
                $.ajax({
                    data:{nik:$('#findByid').val(), 'tipe':'B'},
                    type:'POST',
                    dataType:'json',
                    url:'./getmynikBorongan',
                    success: function(d,r,x){
                        $('#inputNIK').val('');
                        $('#inputNAMA').val('');
                        $('#inputDEPARTEMEN').val('');
                        $('#inputJABATAN').val('');
                        $('#inputPERUSAHAAN').val('');
                        $('#inputPEMBORONG').val('');
                        $('#inputTANGGALMASUK').val('');
                        $('#inputMESS').val('');
                        if(d.Err==0){
                            inputnik        = d.Msg[0].Nik;
                            inputnama       = d.Msg[0].Nama;
                            inputdept       = d.Msg[0].DeptAbbr;
                            inputjab        = d.Msg[0].Jabatan;
                            inputperusahaan = d.Msg[0].Perusahaan;
                            inputpemborong  = d.Msg[0].Pemborong;
                            inputtglmasuk   = d.Msg[0].TanggalMasuk;
                            inputmess       = d.Msg[0].Alamat;
                            $('#inputNIK').val(inputnik);
                            $('#inputNAMA').val(inputnama);
                            $('#inputDEPARTEMEN').val(inputdept);
                            $('#inputJABATAN').val(inputjab);
                            $('#inputPERUSAHAAN').val(inputperusahaan);
                            $('#inputPEMBORONG').val(inputpemborong);
                            $('#inputTANGGALMASUK').val(inputtglmasuk);
                            $('#inputMESS').val(inputmess);
                        }else{
                            swal(d.Msg,'Error','error');
                        }
                    }
                });
            }
        });
    });
    $('.datepick').datepicker({
        autoclose:true,
        format: 'dd-mm-yyyy'
    });
</script>