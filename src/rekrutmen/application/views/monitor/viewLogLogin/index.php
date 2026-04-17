<?php
/* 
 * Author : Ismo___
 */
?>
<!-- bootstrap & fontawesome -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.css" />

<!-- page specific plugin styles -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.custom.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/chosen.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/datepicker.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/daterangepicker.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/colorpicker.css" />

<!-- text fonts -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-fonts.css" />

<!-- ace styles -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-skins.css" id="ace-skins-stylesheet"  type="text/css">

<!--[if lte IE 9]>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-part2.css" class="ace-main-stylesheet" />
<![endif]-->

<!--[if lte IE 9]>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-ie.css" />
<![endif]-->

<!-- inline styles related to this page -->

<!-- ace settings handler -->
<script src="<?php echo base_url();?>assets/js/ace-extra.js"></script>

<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

<!--[if lte IE 8]>
<script src="<?php echo base_url();?>assets/js/html5shiv.js"></script>
<script src="<?php echo base_url();?>assets/js/respond.js"></script>
<![endif]-->
<script type="text/javascript">
        window.jQuery || document.write("<script src='<?php echo base_url();?>/assets/js/jquery.js'>"+"<"+"/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
window.jQuery || document.write("<script src='<?php echo base_url();?>assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->
<script type="text/javascript">
        if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url();?>assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
</script>
<script src="<?php echo base_url();?>assets/js/bootstrap.js"></script>

<!-- page specific plugin scripts -->
<script src="<?php echo base_url();?>assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="<?php echo base_url();?>assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
<script src="<?php echo base_url();?>assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>


<div class="page-header">
    <h1>
        MONITOR
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Log Login
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <!-- Design Disini -->
        <div class="row">
            <div class="col-xs-12">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">Lihat Log Login Anda</h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    
                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="table-responsive">
                            <table id="dataTables-listTK" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>Waktu Login</th>
                                    <th><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>Waktu Logout</th>
                                    <th>Hostname</th>                                    
                                    <th>IP</th>
                                    <th>Browser</th>
                                    <th>Platform</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                $no = 1;
                                foreach ($_getViewLogLogin as $set):
                                ?>
                                    <tr>
                                        <td style="width: 50px " class="text-right"><?php echo $no++;?></td>
                                        <td><?php echo $set->UserID;?></td>
                                        <td><?php echo $set->Tanggal;?></td>
                                        <td><?php 
                                        if($set->SignOut == NULL){
                                            echo '<i>NULL</i>';
                                        }  else {
                                            echo $set->SignOut;
                                        }
                                        ?></td>
                                        <td><?php echo $set->Hostname;?></td>
                                        <td><?php echo $set->IPAddress;?></td>
                                        <td><?php echo $set->Browser;?></td>
                                        <td><?php echo $set->Platform;?></td>
                                    </tr>
                                <?php endforeach; ?>
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-listTK').dataTable();
    });
</script>