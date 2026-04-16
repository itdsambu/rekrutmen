<?php
/* 
 * Author : Ismo___
 */
?>
<div class="page-header">
    <h1>
        ISSUE PERMINTAAN
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Edit Issue Permintaan
        </small>
    </h1>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">List Permintaan </h4>

                <div class="widget-toolbar">
                                            
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div id="data" class="table table-responsive">
                        <table id="dataTables-permintaan" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th rowspan="2">ID</th>
                                    <th rowspan="2">Tipe Issue</th>
                                    <th rowspan="2">Departemen</th>
                                    <th rowspan="2">Posisi/Pekerjaan</th>
                                    <th class="text-center" colspan="3">Realisasi</th>
                                    <th rowspan="2">Status</th>
                                    <th rowspan="2">
                                        <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Requested By
                                    </th>
                                    <th rowspan="2" class="text-center">Detail</th>
                                </tr>
                                <tr>
                                    <th>Minta</th>
                                    <th>Success</th>
                                    <th>Sisa</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php
                            foreach ($_getIssue as $row):
                            ?>
                            <?php
                                echo '<tr data-id="'.$row->DetailID.'" class="rowdetail" >';
                                $target = $row->TKTarget;
                                $sedia  = $row->TKSedia;
                                $minta  = $row->TKPermintaan;

                                $sisa   = $target-$sedia;
                                $penuhi = $sisa-$minta;
                            ?>
                                    <td class="text-right"><?php echo $row->DetailID;?></td>
                                    <td>
                                        <?php 
                                        if($row->Pemborong == 'PSG'){
                                            echo 'Karyawan';
                                        }else{
                                            echo 'Borongan';
                                        }
                                            ?>
                                    </td>
                                    <td><?php echo $row->DeptAbbr;?></td>
                                    <td class=""><?php echo $row->Pekerjaan;?></td>
                                    <td class="text-center"><?php echo $sisa;?></td>
                                    <td class="text-center"><?php echo $penuhi;?></td>
                                    <td class="text-center"><?php echo $minta;?></td>
                                    <td class="text-center"><?php if($row->GeneralStatus == 1){ echo '<span class="label label-sm label-success">Approved</span>';}
                                    elseif($row->GeneralStatus == 2){ echo '<span class="label label-sm label-danger">Canceled</span>';}
                                    elseif($row->GeneralStatus == 3){ echo '<span class="label label-sm label-default">Closed</span>';}
                                    else { echo '<span class="label label-sm label-warning">Pending</span>';}?></td>
                                    <td>
                                        <div class="text-left"><?php echo $row->CreatedBy;?></div>
                                        <div class="text-right smaller-90"><?php echo $row->CreatedDate;?></div>
                                    </td>
                                    <td class="text-center">
                                        <?php if($penuhi > 0):?>
                                        <i>Can't Edit</i>
                                        <?php else:?>
                                            <a title="View Detail" data-rel="tooltip" href="#" class="detail btn btn-minier btn-white btn-block">
                                                <i class="ace-icon fa fa-files-o bigger-100"></i> Edit
                                            </a>
                                        <?php endif;?>
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

<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Detail Info Permintaan</h4>
            </div>
            <div class="modal-body">
                <div id="detailInfo" class="well">
                        <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-permintaan').dataTable();
        
        $("#dataTables-permintaan").on("click", ".detail", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url:"<?php echo site_url('issue/viewEditIssue');?>",
                type:"POST",
                data:"kode="+id,
                datatype:"json",
                cache:false,
                success:function(msg){
                    $("#detailInfo").html(msg);
                }				
            });
            $("#viewModal").modal("show");
        });
    });
</script>