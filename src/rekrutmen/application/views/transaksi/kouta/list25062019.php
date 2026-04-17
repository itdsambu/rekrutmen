<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/css/components.css">
<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/css/core.css">
<!-- <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/css/icons.css"> -->
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
    <div class="col-ms-12">
        <div class="panel panel-color panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">Input TK Interview <?= $this->session->userdata('dept') ?></h4>
            </div>
<!--            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-3 col-ms-12">
                        <div class="alert widget-box-two <?= (($_totalKuota-$_kuotaHariIni) > ($_totalKuota/3)? 'widget-two-teal': ($_kuotaHariIni >= $_totalKuota? 'widget-two-danger': 'widget-two-warning'))?>">
                            <i class="fa fa-inbox widget-two-icon"></i>
                            <div class="widget-two-content">
                                <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Sisa Kuota</p>
                                <h2 class="<?= (($_totalKuota-$_kuotaHariIni) > ($_totalKuota/3) ? 'text-success':'text-danger')?>"><span date-plugin="counterup"><?= ($_totalKuota-$_kuotaHariIni)?></span></h2>
                                <p class="text-muted m-0"><b>Total Kuota:</b> <?= $_totalKuota?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-sm-12 text-center">
                        <?php if($this->session->flashdata('_message')):?>
                            <div class="alert <?= (isset($_GET['success'])? 'alert-success':'alert-danger')?> alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <strong><?= (isset($_GET['success'])?'Well done':'Oh snap')?>!</strong> <?= $this->session->flashdata('_message')?>
                            </div>
                        <?php endif;?>
                    </div>
                    <div class="col-lg-9 col-sm-12 text-center">
                        <form action="<?php echo site_url('transaksi/add');?>" method="POST" role="form" class="form-horizontal">
                            <div class="col-sm-12 alert-container">
                                <div class="alert alert-info">
                                    <div class="form-group">
                                        <div class="col-sm-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    Find by IDReg
                                                </span>
                                                <?php if(($_totalKuota-$_kuotaHariIni) == 0){?>
                                                <input type="text" class="form-control input-sm search-query" name="txtFindByid" id="findByid" placeholder="Find by IDReg" readonly />
                                                <span class="input-group-btn">
                                                    <button type="button" id="btnFind" class="btn btn-purple btn-sm" onclick="myFunction()">
                                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                                    </button>
                                                </span>
                                                <?php } else { ?>
                                                <input type="text" class="form-control input-sm search-query" name="txtFindByid" id="findByid" placeholder="Find by IDReg" />
                                                <span class="input-group-btn">
                                                    <button type="button" id="btnFind" class="btn btn-purple btn-sm">
                                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                                    </button>
                                                </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="ajaxFormHeader">
                                        <div class="form-group">
                                            <div class="col-sm-3">
                                                <input type="text" name="txtFindByid" id="findByid" class="form-control input-sm" placeholder="RegID" readonly/>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="text" name="txtnama" id="nama" class="form-control input-sm" placeholder="Nama" readonly/>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="text" name="txtcv" id="cv" class="form-control input-sm" placeholder="CV" readonly/>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" name="txtPeriode" id="inputPeriode" class="datepick-month col-sm-12 form-control input-sm" value="<?php echo $_getDate;?>" readonly/>
                                            </div>
                                            <div class="col-sm-1">
                                                <button type="submit" id="btnSimpan" class="btn btn-success btn-sm">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Update Kouta Pemborong</h3>
                                    </div>
                                    <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-bordered table-colored table-primary">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>RegID</th>
                                                            <th>Nama</th>
                                                            <th>CVNama</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no=0; foreach($dataKouta as $r){?>
                                                        <tr>
                                                            <td><?php echo ++$no;?></td>
                                                            <td><?php echo $r->HeaderID?></td>
                                                            <td><?php echo $r->Nama?></td>
                                                            <td><?php echo $r->CVNama?></td>
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
            </div>-->
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row" style="padding-bottom: 20px">
                        <div class="col-xs-12">
                            <form action="<?php echo current_url();?>" role="form" method="POST" class="form-horizontal">
                                <div class="form-group-sm">
                                    <label class="control-label col-sm-5">Periode</label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input name="txtPeriode" class="form-control datepick-month" type="text" value="<?php echo $_getDate?>" />
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
					<?php foreach($kouta as $r):?>
                        <?php if($r->Status == 'LOCK' || $r->BatasInput <= date('H:i:s')){?>
                         <div class="row">
                            <div class="col-xs-12">
                                <div class="alert alert-danger">
                                    <div class="alert-data">
                                        <div class="alert-content">
                                            Maaf sesi input sudah habis
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }else{?>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="portel-body">
                                    <div class="form-horizontal">
                                        <div class="col-sm-2 alert-container">
                                            <div class="alert alert-danger">
                                                <div class="alert-data">
                                                    <div class="alert-content"><small>Total Kouta</small> : <?php echo $r->JmlKouta;?> </div>
                                                    <span class="alert-data-number"></span>
                                                    <div class="alert-content">Sisa Kouta : <h2><strong><?php echo $r->SisaKouta;?></strong></h2> </div>
                                                    <div class="alert-content"><small>periode</small> : <?php echo $r->Periode;?> </div>
                                                    <div class="alert-content"><small>Batas Input</small> : <?php echo date('H:i:s',strtotime($r->BatasInput));?> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="<?php echo site_url('transaksi/add');?>" method="POST" role="form" class="form-horizontal">
                                        <div class="col-sm-10 alert-container">
                                            <div class="alert alert-info">
                                                <div class="form-group">
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                Find by IDReg
                                                            </span>
                                                            <?php if($r->SisaKouta == 0){?>
                                                            <input type="text" class="form-control search-query" name="txtFindByid" id="findByid" placeholder="Find by IDReg" readonly />
                                                            <span class="input-group-btn">
                                                                <button type="button" id="btnFind" class="btn btn-purple btn-sm" onclick="myFunction()">
                                                                    <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                                                </button>
                                                            </span>
                                                            <?php } else { ?>
                                                            <input type="text" class="form-control search-query" name="txtFindByid" id="findByid" placeholder="Find by IDReg" />
                                                            <span class="input-group-btn">
                                                                <button type="button" id="btnFind" class="btn btn-purple btn-sm">
                                                                    <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                                                </button>
                                                            </span>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="ajaxFormHeader">
                                                    <div class="form-group">
                                                        <div class="col-sm-4">
                                                            <input type="text" name="txtFindByid" id="findByid" class="form-control" placeholder="RegID" readonly/>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <input type="text" name="txtnama" id="nama" class="form-control" placeholder="Nama" readonly/>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <input type="text" name="txtcv" id="cv" class="form-control" placeholder="CV" readonly/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="ajaxFormHeader">
                                                    <div class="form-group">
                                                        <div class="col-sm-4">
                                                            <input type="text" name="txtPeriode" id="inputPeriode" class="datepick-month col-sm-12" value="<?php echo $_getDate;?>" readonly/>
                                                        </div>
                                                        <div class="col-sm-1">
                                                            <button type="submit" id="btnSimpan" class="btn btn-success btn-sm">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <pre><?php print_r($r->BatasInput);?></pre>
                                </div>
                            </div>
                        </div>
                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Update Kouta Pemborong</h3>
                                            </div>
                                            <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-bordered table-colored table-primary">
                                                            <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>RegID</th>
                                                                    <th>Nama</th>
                                                                    <th>CVNama</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $no=0; foreach($dataKouta as $r){?>
                                                                <tr>
                                                                    <td><?php echo ++$no;?></td>
                                                                    <td><?php echo $r->HeaderID?></td>
                                                                    <td><?php echo $r->Nama?></td>
                                                                    <td><?php echo $r->CVNama?></td>
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
                        <?php } ?>
                    <?php endforeach; ?>
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
<script>
    $('#btnFind').click(function(){
        var id = $('#findByid').val();
        if(id == ''){
        }else{
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('transaksi/ajaxlist')?>"+"/"+id,
                success:function(msg){
                    $('#ajaxFormHeader').html(msg);
                }
            });
            document.getElementById('btnSimpan').disabled=false;
        }
    });
</script>
<script>
function myFunction() {
    alert("Maaf Kouta sudah pernuh, mohon tunggu untuk sesi berikutnya !");
}
</script>
<script type="text/javascript">
    jQuery(function($) {
        $('.datepick-month').datepicker({
            autoclose:true,
            format: 'dd-mm-yyyy'
        });
    });
</script>