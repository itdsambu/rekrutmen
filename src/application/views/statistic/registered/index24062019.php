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
                    <div class="form-inline">
                        <?php echo form_open('statistic/statRegistered');?>
                        <label for="tglSelect" class="col-md-2 text-right">Tanggal</label>
                        <input class="form-control" id="tglSelect" name="txtTglSelect" type="text" placeholder="Format (dd-mm-yyyy)"/>
                        <script>
                            $(function() {
                                $('#tglSelect').datepick({
                                    dateFormat: 'dd-mm-yyyy'
                                });
                            });
                        </script>
                        <button type="submit" name="refresh" id="btnRefresh">Refresh</button>
                        <?php echo form_close();?>
                    </div>
                    <script type="text/javascript">
//                        $("#btnRefresh").click(function(){
//                            var tgl = document.getElementById('tglSelect').value;
//                            $.ajax({
//                                url:"<?php // echo site_url('statistic/setPemborong');?>",
//                                type:"POST",
//                                data:"tgl="+tgl,
//                                datatype:"json",
//                                cache:false,
//                                success:function(msg){
//                                    $("#tblAll").html(msg);
//                                }
//                            });
//                        });
                    </script>
                    <br/>
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
                                        foreach ($_getData as $row): 
                                        ?>
                                        <tr>
                                            <td><?php echo $row->Pemborong;?></td>
                                            <td><?php echo $row->TotalDaftar;?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
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
                                        foreach ($_getBuln as $row): 
                                        ?>
                                        <tr>
                                            <td><?php echo $row->Pemborong;?></td>
                                            <td><?php echo $row->TotalDaftar;?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
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