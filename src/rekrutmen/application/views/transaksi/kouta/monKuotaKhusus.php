<div class="page-header">
    <h1>
        Transaksi
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            List Kouta TK Pemborong
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12" id="controlsetup">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">List Kouta TK Pemborong</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="dataTables" class="table table-bordered table-hover table-primary">
                            <thead class="bg-primary">
                                <tr>
                                    <th>RegID</th>
                                    <th>Nama</th>
                                    <th>CVNama</th>
                                    <th>Periode</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($_getDataKuota as $row){?>
                                <tr data-id="<?php echo $row->HeaderID?>">
                                    <td><?php echo $row->HeaderID?></td>
                                    <td><?php echo $row->Nama?></td>
                                    <td><?php echo $row->CVNama?></td>
                                    <td><?php echo date('d-m-Y',strtotime($row->Periode))?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle">
                                                Berkas
                                                <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-default">
                                                <li>
                                                    <?php if ($row->KTP != NULL){?>
                                                    <a title="show KTP" data-rel="tooltip" href="#" class="berkas" data-name="KTP" data-tk="<?php echo ucwords(strtolower($row->Nama));?>">KTP</a>
                                                    <?php }else{ echo "<a><small><i>KTP is NULL</i></small></a>"; }?>
                                                </li>
                                                <li>
                                                    <?php if ($row->Lamaran != NULL){?>
                                                    <a title="show Lamaran" data-rel="tooltip" href="#" class="berkas" data-name="Lamaran" data-tk="<?php echo ucwords(strtolower($row->Nama));?>">Lamaran</a>
                                                    <?php }else{ echo "<a><small><i>Lamaran is NULL</i></small></a>"; }?>
                                                </li>
                                                <li>
                                                    <?php if ($row->CV != NULL){?>
                                                    <a title="show CV" data-rel="tooltip" href="#" class="berkas" data-name="CV" data-tk="<?php echo ucwords(strtolower($row->Nama));?>">Curiculum Vitae</a>
                                                    <?php }else{ echo "<a><small><i>Curiculum Vitae is NULL</i></small></a>"; }?>
                                                </li>
                                                <li>
                                                    <?php if ($row->Ijazah != NULL){?>
                                                    <a title="show Ijazah" data-rel="tooltip" href="#" class="berkas" data-name="Ijazah" data-tk="<?php echo ucwords(strtolower($row->Nama));?>">Ijazah</a>
                                                    <?php }else{ echo "<a><small><i>Ijazah is NULL</i></small></a>"; }?>
                                                </li>
                                                <li>
                                                    <?php if ($row->Transkrip != NULL){?>
                                                    <a title="show Transkrip" data-rel="tooltip" href="#" class="berkas" data-name="Transkrip" data-tk="<?php echo ucwords(strtolower($row->Nama));?>">Transkrip Nilai</a>
                                                    <?php }else{ echo "<a><small><i>Transkrip is NULL</i></small></a>"; }?>
                                                </li>
                                                
                                            <li><a title="print daftar riwayat hidup" href="<?= site_url('toExcel/printdrh')."?id=".$row->HeaderID;?>" data-name="Daftar Riwayat Hidup" data-tk="<?php echo ucwords(strtolower($row->HeaderID));?>"><small>Daftar Riwayat Hidup</small></a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <span id="moExcel">
                    <button class="btn btn-minier btn-success" id="btnModalExcel">
                        <i class="ace-icon fa fa-file-excel-o"></i> Export to Excel
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>
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
<div class="modal fade" id="modalToExcel" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titleExcel"> Export to Excel</h4>
            </div>
            <div class="modal-body">
                <div class="center">
                    <form class="form-horizontal" id="formExportExcel" action="<?php echo site_url('transaksi/downloadKuotaPBR');?>" method="POST">
                        <div class="form-group">
                            <label class="col-sm-5 control-label right" for="inputTahun">Pilih Tanggal</label>
                            <div class="col-sm-6">
                                <div class="input-daterange input-group">
                                    <input type="text" class="input-sm form-control datepick-month" name="txtPeiode" id="inputPeiode" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="center">
                            <button class="btn btn-mini btn-success">
                                <i class="ace-icon fa fa-download"></i> Download
                            </button>
                        </div>
                    </form>
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
<script type="text/javascript">
    $(document).ready(function(){
        $('#dataTables').dataTable({
            "order": [[0,'desc']]
        });
        $("#btnModalExcel").click(function () {
            $("#modalToExcel").modal("show");
        });
        $("#dataTables").on("click", ".berkas", function() {
                var id = $(this).closest('tr').data('id');
                var name = $(this).data('name');
                var tk = $(this).data('tk');
                
                document.getElementById('titleModal').textContent = "Berkas "+name+" dari saudara, "+tk+"";
                $.ajax({
                    url:"<?php echo site_url('transaksi/viewDocs');?>",
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
    })
</script>
<script type="text/javascript">
    jQuery(function($) {
        $('.datepick-month').datepicker({
            autoclose:true,
            format: 'dd-mm-yyyy'
        });
    });
</script>