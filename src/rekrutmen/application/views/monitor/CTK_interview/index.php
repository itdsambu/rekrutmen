<?php
/* 
 */
?>
<script type="text/javascript" src="<?php echo base_url();?>assets/toExcel/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/toExcel/jquery.battatech.excelexport.js"></script>
<div class="page-header">
    <h1>
        MONITOR
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
                List Vaksin Karyawan
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
                                        <th>No</th>
                                        <th>REGNO</th>
                                        <th>Nama</th>
                                        <th>Departemen</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tanggal Lahir</th>                                    
                                        <th>Tanggal Masuk</th>                                    
                                        <th>Tanggal Vaksin 1</th>                                    
                                        <th>Tanggal Vaksin 2</th>                                    
                                        <th>Tanggal Vaksin 3</th>                                    
                                        <th>Jenis Vaksin</th>
                                        <th>No KTP</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php
                                $no = 0;
                                foreach ($_getTK as $set):
                                    $no++
                                ?>
                                    <?php
					                    echo '<tr data-id="'.$set->HeaderID.'" class="rowdetail" >';
                                    ?>
                                    
                                        <td style="width: 50px " class="text-right"><?php echo $no;?></td>
                                        <td style="width: 50px " class="text-right"><?php echo $set->RegNo;?></td>
                                       
                                        <td><?php echo $set->Nama;?></td>
                                        <td><?php echo $set->DeptTujuan;?></td>
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
                                        <td class="text-right" ><?php echo date('d-M-Y',  strtotime($set->Tgl_Lahir));?></td>
                                        <td class="text-right" ><?php echo date('d-M-Y',  strtotime($set->RegisteredDate));?></td>
                                        <td class="text-right" ><?php $tgl_vaksin = $set->TanggalVaksin; if($tgl_vaksin == '' ){ } else{echo date('d-M-Y',  strtotime($set->TanggalVaksin));} ?></td>
                                        <td class="text-right" ><?php $tgl_vaksin2 = $set->TanggalVaksin2; if($tgl_vaksin2 == '' ){ } else{echo date('d-M-Y',  strtotime($set->TanggalVaksin2));} ?></td>
                                        <td class="text-right" ><?php $tgl_vaksin3 = $set->TanggalVaksin3; if($tgl_vaksin3 == '' ){ } else{echo date('d-M-Y',  strtotime($set->TanggalVaksin3));} ?></td>
                                        <td>
                                            <?php echo $set->JenisVaksin;?>
                                        </td>
                                        <td><?php echo $set->No_Ktp;?></td>
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