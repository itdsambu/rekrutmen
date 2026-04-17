<script type="text/javascript" src="<?php echo base_url();?>assets/toExcel/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/toExcel/jquery.battatech.excelexport.js"></script>

<div class="page-header">
    <h1>
        Statistic 
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Rekap Issue Permintaan
        </small>
    </h1>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Rekap Issue Permintaan</h4>
                
                <div class="widget-toolbar no-border">
                    <button class="btn btn-minier btn-success" id="btnExport">
                        <i class="ace-icon fa fa-file-excel-o bigger-120"></i> Export to Excel
                    </button>
                </div>
            </div>

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
                    <div id="tblIssued" class="table-responsive">
                        <table id="dataTables-issue" class="table table-bordered" style="white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">ID</th>
                                    <th rowspan="2">Dept/Bagian</th>
                                    <th rowspan="2">Tujuan Lamaran</th>
                                    <th rowspan="2">Pekerjaan</th>
                                    <th colspan="3" class="text-center">Tenaga Kerja</th>
                                    <th rowspan="2">Pendidikan</th>
                                    <th rowspan="2">Jurusan</th>
                                    <th rowspan="2">Remark</th>
                                    <th rowspan="2">Umur</th>
                                    <th rowspan="2">Jenis Kelamin</th>
                                    <th rowspan="2">Status Personal</th>
                                    <th rowspan="2">Status</th>
                                    <th rowspan="2">Keterangan</th>
                                    <th rowspan="2">Created Date</th>
                                    <th rowspan="2">Detail</th>
                                </tr>
                                <tr>
                                    <th>Permintaan</th>
                                    <th>Terpenuhi</th>
                                    <th>Sisa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $noUrut = 1; 
                                foreach ($_getIssue as $row): 
                                    $target = $row->TKTarget;
                                    $sedia  = $row->TKSedia;
                                    $minta  = $row->TKPermintaan;

                                    $sisa   = $target-$sedia;
                                    $penuhi = $sisa-$minta;
                                ?>
                                <tr data-id="<?php echo $row->DetailID;?>">
                                    <td><?php echo $noUrut++;?></td>
                                    <td><?php echo $row->DetailID;?></td>
                                    <td><?php echo $row->DeptAbbr;?></td>
                                    <td><?php echo $row->Pemborong;?></td>
                                    <td><?php echo $row->Pekerjaan;?></td>
                                    <td><?php echo $sisa;?></td>
                                    <td><?php echo $penuhi;?></td>
                                    <td><?php echo $minta;?></td>
                                    <td><?php echo $row->Pendidikan;?></td>
                                    <td><?php echo $row->Jurusan;?></td>
                                    <td>
                                        <textarea style="width: 300px;border:0;height: 25px;background: transparent;resize: none;" readonly=""><?php echo $row->IssueRemark;?></textarea>
                                        </td>
                                    <td><?php echo $row->Umur;?></td>
                                    <td><?php echo $row->JenisKelamin;?></td>
                                    <td><?php echo $row->StatusPersonal;?></td>
                                    <td><?php if($row->Pemborong == 'PSG'){
                                         echo 'Karyawan';
                                        }else{ echo 'Borongan';}?></td>
                                    <td><?php if($minta == 0){ echo 'Complete';}else{ echo 'On Proses';}?></td>
                                    <td><?php echo date('d-m-Y', strtotime($row->CreatedDate));?></td>
                                    <td class="text-center">
                                        <a title="View Detail Review" data-rel="tooltip" href="#" class="detailReview btn btn-minier btn-white btn-block">
                                            <i class="ace-icon fa fa-files-o bigger-100"></i> Review
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

<!-- Modal View -->
<div class="modal fade" id="viewModalReview" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Review Tenaga Kerja yang memenuhi Permintaan</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="detailReview" class="well">
                        <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">				
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-issue').dataTable({
            "sScrollY": "500px",
            "sScrollX": "100%",
            "sScrollXInner": "100%",
            "bScrollCollapse": true,
            "bPaginate": true,
            "bFilter": true,
            "bInfo": true,
            "bSort": true,
            fixedColumns: {
                leftColumns: 3
            }
        });
        
        $("#btnExport").click(function () {
            $("#tblExport").battatech_excelexport({
                containerid: "dataTables-issue"
               , datatype: 'table'
            });
        });
        
        $("#dataTables-issue").on("click", ".detailReview", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url:"<?php echo site_url('statistic/reviewTenaker');?>",
                type:"POST",
                data:"kode="+id,
                datatype:"json",
                cache:false,
                success:function(msg){
                    $("#detailReview").html(msg);
                }				
            });
            $("#viewModalReview").modal("show");
        });
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