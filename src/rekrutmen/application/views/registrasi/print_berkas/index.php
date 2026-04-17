<div class="page-header">
    <h1>
        REGISTRASI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Print Berkas Karyawan
        </small>
    </h1>
</div><!-- /.page-header -->


<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">List Tenaga Kerja yang Telah di Posting</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                    <div class="col-xs-12 col-sm-offset-3 col-sm-6">
                        <form class="form-horizontal" role="form" action="<?php echo site_url()?>printControl/index" method="POST">
                            <div class="form-group">
                                <label class="control-label col-xs-2" for="txtUser">Date Range</label>
                                <div class="col-xs-7">
                                    <div class="input-daterange input-group">
                                        <input type="text" class="form-control" name="startDate">
                                        <span class="input-group-addon">
                                            <i class="fa fa-exchange"></i>
                                        </span>
                                        <input type="text" class="form-control" name="endDate" id="endDate">
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-xs-12 table-responsive">
                        <table id="dataTables-listTK" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Departemen</th>
                                <th>Tipe TenaKer</th>
                                <th>Posisi/Pekerjaan</th>
                                <th>Tangga Lahir</th>                                    
                                <th>Jenis Kelamin</th>
                                <th>Berkas</th>
                                <th>
                                    <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Posted By
                                </th>
                                <th>Hasil Interview</th>
                                <th>Opsi</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            foreach ($_listTenaker as $set):
                                ?>
                                <?php
                                    echo '<tr data-id="'.$set->HeaderID.'" class="rowdetail info" >';
                                ?>
                                    <td style="width: 50px " class="text-right"><?php echo $set->HeaderID;?></td>
                                    <td><?php echo $set->Nama;?></td>
                                    <td><?php echo $set->DeptTujuan;?></td>
                                    <td>
                                        <?php if($set->TipeKaryawan == 1){ echo 'Karyawan';}else{ echo 'Borongan/Harian';}?>
                                    </td>
                                    <td><?php echo $set->Pekerjaan;?></td>
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
                                        <?php
                                            if ($set->KTP != NULL && $set->Lamaran != NULL && $set->CV != NULL && $set->Ijazah != NULL && $set->Transkrip != NULL) {   
                                                echo "<span class='label label-sm label-success arrowed'>Berkas Lengkap</span>";
                                            }elseif($set->KTP != NULL){
                                                echo "<span class='label label-sm label-info arrowed'>Minimal Berkas</span>";
                                            }  else {
                                                echo "<span class='label label-sm label-danger arrowed'>Tidak Lengkap </span>";
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="text-left"><?php echo $set->CreatedBy;?></div>
                                        <div class="text-right smaller-90"><?php echo $set->CreatedDate;?></div>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                            if($set->WawancaraKe == NULL){
                                                echo 'Belum Pernah';
                                            }else{
                                        ?>
                                            <a title="View Detail" data-rel="tooltip" href="#" class="detailInterview btn btn-minier btn-white btn-block">
                                                <i class="ace-icon fa fa-files-o bigger-100"></i> <?php echo $set->WawancaraKe.' kali';?>
                                            </a>
                                        <?php
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-mini btn-round btn-success dropdown-toggle">
                                                Print
                                                <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-default">
                                                <li>
                                                    <a title="print Surat Pengantar Masuk Kerja" data-rel="tooltip" href="<?php echo site_url('printControl/viewSPMK/'.$set->HeaderID);?>" target="_blank">SPMK</a>
                                                </li>
                                                <li>
                                                    <a title="print Formulir Medical Check Up" data-rel="tooltip" href="<?php echo site_url('printControl/viewFormMCU/'.$set->HeaderID);?>" target="_blank">MCU Form</a>
                                                </li>
                                                <li>
                                                    <a title="print Kartu Medical Check Up" data-rel="tooltip" href="<?php echo site_url('printControl/viewCardMCU/'.$set->HeaderID);?>" target="_blank">MCU Card</a>
                                                </li>
                                                <li>
                                                    <a title="print Kartu Pengantar Berobat" data-rel="tooltip" href="<?php echo site_url('printControl/viewKPB/'.$set->HeaderID);?>" target="_blank">KPB Card</a>
                                                </li>
                                            </ul>
                                        </div>                                          
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle">
                                                Berkas
                                                <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-default">
                                                <li>
                                                    <?php if ($set->KTP != NULL){?>
                                                    <a title="show KTP" data-rel="tooltip" href="#" class="berkas" data-name="KTP" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">KTP</a>
                                                    <?php }else{ echo "<a><small><i>KTP is NULL</i></small></a>"; }?>
                                                </li>
                                                <li>
                                                    <?php if ($set->Lamaran != NULL){?>
                                                    <a title="show Lamaran" data-rel="tooltip" href="#" class="berkas" data-name="Lamaran" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Lamaran</a>
                                                    <?php }else{ echo "<a><small><i>Lamaran is NULL</i></small></a>"; }?>
                                                </li>
                                                <li>
                                                    <?php if ($set->CV != NULL){?>
                                                    <a title="show CV" data-rel="tooltip" href="#" class="berkas" data-name="CV" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Curiculum Vitae</a>
                                                    <?php }else{ echo "<a><small><i>Curiculum Vitae is NULL</i></small></a>"; }?>
                                                </li>
                                                <li>
                                                    <?php if ($set->Ijazah != NULL){?>
                                                    <a title="show Ijazah" data-rel="tooltip" href="#" class="berkas" data-name="Ijazah" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Ijazah</a>
                                                    <?php }else{ echo "<a><small><i>Ijazah is NULL</i></small></a>"; }?>
                                                </li>
                                                <li>
                                                    <?php if ($set->Transkrip != NULL){?>
                                                    <a title="show Transkrip" data-rel="tooltip" href="#" class="berkas" data-name="Transkrip" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Transkrip Nilai</a>
                                                    <?php }else{ echo "<a><small><i>Transkrip is NULL</i></small></a>"; }?>
                                                </li>
                                                <li>
                                                    <?php if ($set->SuratKontrak != NULL){?>
                                                    <a title="show Surat Kontrak" data-rel="tooltip" href="#" class="berkas" data-name="SuratKontrak" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Surat Kontrak</a>
                                                    <?php }else{ echo "<a><small><i>Surat Kontrak is NULL</i></small></a>"; }?>
                                                </li>
                                            </ul>
                                        </div>
                                        <a title="View Detail" data-rel="tooltip" href="#" class="detail btn btn-minier btn-round btn-primary">
                                            <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
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

<!-- Modal View -->
<div class="modal fade" id="viewModalInterview" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Informasi Record Wawancara</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="detailInterview" class="well">
                        <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">				
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal View -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->				
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

<!-- Modal View Berkas-->
<div class="modal fade" id="viewModalBerkas" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titleModal"></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="berkas" class="well">
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
        $('#dataTables-listTK').dataTable();
        $('[data-rel=tooltip]').tooltip();
        
        $("#dataTables-listTK").on("click", ".detailInterview", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url:"<?php echo site_url('wawancaraTujuan/cekRecordInterview');?>",
                type:"POST",
                data:"kode="+id,
                datatype:"json",
                cache:false,
                success:function(msg){
                    $("#detailInterview").html(msg);
                }				
            });
            $("#viewModalInterview").modal("show");
        });
        
        $("#dataTables-listTK").on("click", ".detail", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url:"<?php echo site_url('uploadBerkas/detailtk');?>",
                type:"POST",
                data:"kode="+id,
                datatype:"json",
                cache:false,
                success:function(msg){
                    $("#detail").html(msg);
                }				
            });
            $("#viewModal").modal("show");
        });
        
        $("#dataTables-listTK").on("click", ".berkas", function() {
                var id = $(this).closest('tr').data('id');
                var name = $(this).data('name');
                var tk = $(this).data('tk');
                
                document.getElementById('titleModal').innerHTML = "Berkas "+name+" dari saudara, <strong class='green'>"+tk+"</strong>";
                $.ajax({
                    url:"<?php echo site_url('monitor/viewDocs');?>",
                    type:"POST",
                    data:"kode="+id+"&nama="+name,
                    datatype:"json",
                    cache:false,
                    success:function(msg){
                        $("#berkas").html(msg);
                    }				
                });
            $("#viewModalBerkas").modal("show");
        });
    });
</script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" />

<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-timepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/moment.js"></script>
                
<script type="text/javascript">
    jQuery(function($) {
        $('.input-daterange').datepicker({
            autoclose:true,
            format: 'dd-mm-yyyy'
        });
    });
</script>
