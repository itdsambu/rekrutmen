<link rel="stylesheet" href="<?php echo base_url();?>assets/css/select2.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/dp/smoothness.datepick.css" />

<script src="<?php echo base_url();?>assets/dp/jquery.datepick.js"></script>
<script src="<?php echo base_url();?>assets/dp/jquery.plugin.js"></script>

<div class="page-header">
    <h1>
        Statistic 
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Pemborong
        </small>
    </h1>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Statistic Pemborong</h4>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div class="row" style="padding-bottom: 20px">
                        <?php echo form_open('statistic/statRegistered');?>
                            <div class="col-xs-12">
                                <label class="control-label col-sm-1 text-right">Tanggal</label>
                                <div class="col-sm-4">
                                    <div class="input-daterange input-group">
                                        <input type="text" class="input-sm form-control datepick" name="txtDateA" placeholder="Format (dd-mm-yyyy)">
                                        <span class="input-group-addon">
                                            <i class="fa fa-exchange"></i>
                                        </span>
                                        <input type="text" class="input-sm form-control datepick" name="txtDateZ" placeholder="Format (dd-mm-yyyy)">
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <button id="btnFilterRekap" class="btn btn-xs btn-primary">Filter</button>
                                </div>
                            </div>
                        <?php echo form_close();?>
                    </div>
                    <div id="tblAll" class="row">
                        <div class="col-xs-6">
                            <div id="tblPemborong" class="table table-responsive">
                                <table id="dataTables-listTK"  class="highchart table table-bordered" data-graph-container="#graphcontainer" data-graph-type="column">
                                    <thead>
                                        <tr>
                                            <th>Nama Pemborong</th>
                                            <th>Total Input Tgl : <?php echo $_getTgl;?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $total = 0;
                                        foreach ($_getData as $row): 
                                            $total += $row->TotalDaftar;
                                        ?>
                                        <tr>
                                            <td><?php echo $row->Pemborong;?></td>
                                            <td><?php echo $row->TotalDaftar;?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <th><?= $total;?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div id="tblPemborongBln" class="table table-responsive" >
                                <table id="dataTables-listTKbln" class="highchart table table-bordered" data-graph-container="#graphcontainerBln" data-graph-type="column">
                                    <?php
                                        $thn    = substr($_getTgl, 0, 4);
                                        $bln    = substr($_getTgl, 5, 2);
                                        $awal   = $thn."-".$bln."-01";
                                    ?>
                                    <thead>
                                        <tr>                                   
                                            <!--<th>No</th>-->
                                            <th>Nama Pemborong</th>
                                            <th>Total Input dari Tgl <?php echo $awal;?> s/d <?php echo $_getTgl;?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total = 0;
                                        foreach ($_getBuln as $row):
                                        $total += $row->TotalDaftar; 
                                        ?>
                                        <tr>
                                            <td><?php echo $row->Pemborong;?></td>
                                            <td><?php echo $row->TotalDaftar;?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <th><?= $total;?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        
                        <div id="graphcontainer" class="col-xs-12"></div>
                        <div id="graphcontainerBln" class="col-xs-12"></div>
                    </div>
                                                
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/hc/js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>assets/hc/js/jquery.highchartTable-min.js"></script>
<script>
    $(document).ready(function(){
        // Do chart before turning table into a datatable
        $('#dataTables-listTK').highchartTable();
        $('#dataTables-listTKbln').highchartTable();
    });
</script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" />

<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-timepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/moment.js"></script>
                
<script type="text/javascript">
    jQuery(function($) {
        $('.datepick').datepicker({
            autoclose:true,
            format: 'dd-mm-yyyy'
        });
    });
</script>