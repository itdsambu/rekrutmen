<?php
/* 
 * Author : Ismo___
 */
?>
<script type="text/javascript" src="<?php echo base_url();?>assets/toExcel/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/toExcel/jquery.battatech.excelexport.js"></script>
<div class="page-header">
    <h1>
        MONITOR
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Screening Progress
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
                        <h4 class="widget-title">List Tenaga Kerja </h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                        </div>
                        <div class="widget-toolbar no-border">
                            <button class="btn btn-minier btn-success" id="btnExport">
                                <i class="ace-icon fa fa-file-excel-o bigger-120"></i> Export to Excel
                            </button>
                        </div>
                    </div>
                    
                    <!-- <div class="widget-body">
                        <div class="widget-main">
                            <input type="text" placeholder="Filter Bulan Registrasi" id="txtTanggal" class="form-control pull-right" onchange="dateChange()" value="<?php echo $monthfilter; ?>"> -->


<!-- View Range Bulan -->

            <div class="widget-body">
                <div class="widget-main">
                    <div class="row" style="padding-bottom: 20px">
                        <div class="col-xs-12">
                            <form action="<?php echo current_url();?>" role="form" method="POST" class="form-horizontal">
                                <div class="form-group-sm">
                                    <label class="control-label col-sm-1">Periode</label>
                                    
                                    <div class="col-sm-4">
                                        <div class="input-daterange input-group">
                                            <input type="text" class="input-sm form-control datepick" name="txtDateA" value="<?php echo date('d-m-Y', strtotime($_getDateA))?>">
                                            <span class="input-group-addon">
                                                <i class="fa fa-exchange"></i>
                                            </span>
                                            <input type="text" class="input-sm form-control datepick" name="txtDateZ" value="<?php echo date('d-m-Y', strtotime($_getDateZ))?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <button id="btnFilterRekap" class="btn btn-xs btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                            <div class="table table-responsive">
                            <table id="dataTables-listTK" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Pemborong</th>
                                        <th>Tangga Lahir</th>                                    
                                        <th>Jenis Kelamin</th>
                                        <th>Dept Screened</th>
                                        <th>Status</th>
                                        <th>
                                            <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By
                                        </th>
                                        <th>
                                            <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Registered Date
                                        </th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php
                                foreach ($_getTK as $set):
                                ?>
                                    <?php
					                    echo '<tr data-id="'.$set->HeaderID.'" class="rowdetail" >';
                                    ?>
                                        <td style="width: 50px " class="text-right"><?php echo $set->HeaderID;?></td>
                                        <td><?php echo $set->Nama;?></td>
                                        <td><?php echo $set->Pemborong;?></td>
                                        <td class="text-right" ><?php echo date('d-M-Y',  strtotime($set->Tgl_Lahir));?></td>
                                        <td><?php 
                                        $jekel = $set->Jenis_Kelamin;
                                            if($jekel == 'M' || $jekel == 'LAKI-LAKI'){
                                                echo 'Laki-laki';
                                            }elseif ($jekel == 'F' || $jekel == 'PEREMPUAN') {
                                                echo 'Perempuan';
                                            }  else {
                                                echo 'Gx Jelas';
                                            }
                                        ?></td>
                                        <td>
                                            <?php echo $set->History;?>
                                        </td>
                                        <td><?php 
                                        $Sh = $set->ScreeningHasil;
                                        $Sc = $set->ScreeningComplete;
                                        $Ss = $set->SpecialScreening;
                                        $Fa = $set->Verified;
                                        $Pd = $set->PostingData;
                                            if($Pd == 1){
                                                echo "<span class='label label-sm label-success'>Has bee Posted</span>";
                                            }elseif($Ss == NULL && $Sc == 1){
                                                echo "<span class='label label-sm label-success'>Screening PSN on Progress</span>";
                                            }elseif($Sh == 1 && $Ss == 1){
                                                echo "<span class='label label-sm label-info'>Screening TIM is Complete</span>";
                                            }elseif($Sh == 0 && $Fa == 1){
                                                echo "<span class='label label-sm label-warning'>Screening TEAM on Progress</span>";
                                            }else{
                                                echo "<span class='label label-sm label-danger'>Yet Verification</span>";
                                            }
                                        ?></td>
                                        <td><?php echo $set->RegisteredBy;?></td>
                                        <td class="text-right"><?php echo $set->RegisteredDate;?></td>
                                        <td class="text-center">
                                            <a title="show detail" href="#" class="detail">
                                                <button class="btn btn-minier btn-primary">
                                                    <i class="ace-icon fa fa-list-alt bigger-100"></i>Detail
                                                </button>
                                            </a>
                                        </td>
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

<!-- Modal View  -->

<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #008cba">                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Informasi Data Karyawan</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="detail" class="well">
                        <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">              
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="<?php echo base_url();?>assets/css/datepicker.css" />
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script type="text/javascript">

    // function dateChange()
    // {
    //     window.location.href ='<?php echo base_url();?>monitor/screeningProses?monthyear='+$('#txtTanggal').val();
    // }
    $(document).ready(function() {

        // $("#txtTanggal").datepicker( {
        //     format: "mm-yyyy",
        //     viewMode: "months", 
        //     minViewMode: "months",
        //     autoclose: true
        // });

        $('#dataTables-listTK').dataTable();
        
        $("#btnExport").click(function () {
            $("#tblExport").battatech_excelexport({
                containerid: "dataTables-listTK"
               , datatype: 'table'
            });
        });
        
        $("#dataTables-listTK").on("click", ".detail", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url:"<?php echo site_url('monitor/detailScreened');?>",
                type:"POST",
                data:"kode="+id,
                datatype:"json",
                cache:false,
                success:function(msg){
                    console.log(msg);
                    $("#detail").html(msg);
                }				
            });
            $("#viewModal").modal("show");
        });        
    });
</script>


<script type="text/javascript">
    jQuery(function($) {
        $('.datepick').datepicker({
            autoclose:true,
            format: 'dd-mm-yyyy'
        });
    });
</script>