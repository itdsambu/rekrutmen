<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/css/components.css">
<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/css/core.css">
<!-- <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/css/icons.css"> -->
<style>
  .blink {
  animation: blink 5s steps(5, start) infinite;
  -webkit-animation: blink 2s steps(5, start) infinite;
  color:#000000;
  font-weight: bold;
}
@keyframes blink {
  to { visibility: hidden; }
}
@-webkit-keyframes blink {
  to { visibility: hidden; }
</style>
<div class="page-header">
    <h1>
        Transaksi
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Kouta Pemborong
        </small>
    </h1>
</div>
<?php if ($_MsgAlert != NULL || $_MsgAlert !=''){?>
<div class="row">
    <div class="col-sm-12 text-center">
        <div class="alert alert-danger">
            <div class="alert-data">
                <div class="alert-content">
                    <h1 class="blink"><b><?= $_MsgAlert?></b></h1>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php //if(date('H:i') < '09:00'){?>
<?php if(date('H:i') < date('H:i',strtotime($_StartInput))){?>
<div class="row">
    <div class="col-xs-12">
        <div class="alert alert-info">
            <div class="alert-data">
                <div class="alert-content">
                    <h3><i class="fa fa-warning"></i> Maaf halaman masih dilock !</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } elseif($_BatasInput <= date('H:i')) { ?>
<div class="row">
    <div class="col-xs-12">
        <div class="alert alert-danger">
            <div class="alert-data">
                <div class="alert-content">
                    Maaf waktu untuk penginputan sudah habis, mohon tunggu untuk sesi berikutnya !
                </div>
            </div>
        </div>
    </div>
</div>
<?php } else {?>
<div class="row">
    <div class="col-ms-12">
        <div class="panel panel-color panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">Input TK Interview</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-3 col-ms-12">
                        <div class="alert widget-box-two <?= (($_totalKuota-$_kuotaHariIni) > ($_totalKuota/3)? 'widget-two-teal': ($_kuotaHariIni >= $_totalKuota? 'widget-two-danger': 'widget-two-warning'))?>">
                            <i class="fa fa-inbox widget-two-icon"></i>
                            <div class="widget-two-content">
                                <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Sisa Kuota</p>
                                <h2 class="<?= (($_totalKuota-$_kuotaHariIni) > ($_totalKuota/3) ? 'text-success':'text-danger')?>"><span date-plugin="counterup"><?= ($_totalKuota-$_kuotaHariIni)?></span></h2>
                                <!-- <p class="text-muted m-0"><b>Total Kuota:</b> <?= $_totalKuota?></p> -->
                                <p class="text-muted m-0"><b>Batas Input Kuota:</b> <?= date('H:i',strtotime($_BatasInput))?></p>
                            </div>
                        </div>
                    </div>
                    <?php if(($_totalKuota-$_kuotaHariIni) == '0' || ($_totalKuota-$_kuotaHariIni) <= '0'){?>
                    <div class="col-lg-9 col-sm-12 text-center">
                        <div class="alert alert-info">
                            <div class="alert-data">
                                <div class="alert-content">
                                    <h3>Maaf Kuota sudah pernuh, mohon tunggu untuk sesi berikutnya !</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="col-lg-9 col-sm-12 text-center">
                        <?php if($this->session->flashdata('_message')):?>
                            <div class="alert <?= (isset($_GET['success'])? 'alert-success':'alert-danger')?> alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <strong><?= (isset($_GET['success'])?'Well done':'Oh snap')?>!</strong> <?= $this->session->flashdata('_message')?>
                            </div>
                        <?php endif;?>
                    </div>
                    <div class="col-lg-9 col-sm-12 text-center">
                        <form action="<?php echo site_url('transaksi/addkuotakhusus');?>" method="POST" role="form" class="form-horizontal">
                            <div class="col-sm-12 alert-container">
                                <div class="alert alert-info">
                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    Find by IDReg
                                                </span>
                                                <?php if(($_totalKuota-$_kuotaHariIni) <= 0){?>
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
                    <?php } ?>
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
            </div>
        </div>
    </div>
</div>
<?php } ?>
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