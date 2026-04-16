<script type="text/javascript" src="<?php echo base_url();?>assets/toExcel/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/toExcel/jquery.battatech.excelexport.js"></script>

<div class="page-header">
    <h1>
        MONITOR
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Blacklist By Pass
        </small>
    </h1>
</div>
<?php
if($this->input->get('msg')== 'ok'){
    echo "<p class='alert alert-info'>Password berhasil dirubah..</p>";
}elseif ($this->input->get('msg')== 'notMacth') {
    echo "<p class='alert alert-danger'>Password lama anda tidak sesuai..</p>";
}elseif($this->input->get('msg') == 'success_edit'){
    echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
    <i class='ace-icon fa fa-times'></i></button>Edit data berhasil..</p>";
}elseif ($this->input->get('msg') == 'failed_edit') {
    echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
    <i class='ace-icon fa fa-times'></i></button>Edit data tidak berhasil..</p>";
}elseif ($this->input->get('msg') == 'success_delete') {
    echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
    <i class='ace-icon fa fa-times'></i></button>Data behasil dihapus..</p>";
}elseif ($this->input->get('msg') == 'failed_delete') {
    echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
    <i class='ace-icon fa fa-times'></i></button>Data tidak behasil dihapus..</p>";
}elseif ($this->input->get('msg') == 'success_add') {
    echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
    <i class='ace-icon fa fa-times'></i></button>Data behasil ditambahkan..</p>";
}elseif ($this->input->get('msg') == 'failed_add') {
    echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
    <i class='ace-icon fa fa-times'></i></button>Mohon Maaf NIK sudah di BLACKLIST ..</p>";
}else{
    echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
    </button><strong>Warning!!</strong> menu PRINT masih tahap perngerjaan. .<br>";
}
?>
<div class="no-border padding-24">
    <div>
        <div class="row">
            <div class="col-xs-12">
                <div class="widget-box">
                    <div class="widget-header">
                        <h5 class="widget-title">List Blacklist By Pass</h5>
                        <div class="widget-toolbar no-border">
                            <span id="moExcel">
                                <button class="btn btn-minier btn-success" id="btnModalExcel">
                                    <i class="ace-icon fa fa-file-excel-o"></i> Export to Excel
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="table-responsive">                            
                                <table id="dataTables-blacklistbypass" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
											<th>#</th>
                                            <th>NIK</th>
                                            <th>NAMA</th>
                                            <th>Perusahaan / CV</th>
                                            <th>PEMBORONG</th>
                                            <th>Department</th>
											<th>TANGGAL LAHIR</th>
											<th>DAERAH ASAL</th>
                                            <th>TANGGAL MASUK</th>
                                            <th>TANGGAL KELUAR</th>
                                            <th>KETERANGAN</th>
                                            <th>NAMA IBU</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									if(isset($getBlacklistByPass)){
                                    $no=0; foreach ($getBlacklistByPass as $row){$no++;
                                        ?>
                                        <tr>
											<td><?php echo $no;?></td>
                                            <td><?php echo $row->NIK;?></td>
                                            <td><?php echo $row->Nama;?></td>
                                            <td><?php echo $row->Perusahaan;?></td>
                                            <td><?php echo $row->Pemborong;?></td>
                                            <td><?php echo $row->DeptAbbr;?></td>
											<td><?php echo $row->TGLLAHIR;?></td>
											<td><?php echo $row->DaerahAsal;?></td>
                                            <td><?php echo $row->TGLMASUK;?></td>
                                            <td><?php echo $row->TGLKELUAR;?></td>
                                            <td><?php echo $row->Remark;?></td>
                                            <td><?php echo $row->NamaIbuKandung;?></td>
                                            <td>
                                                <a title="View Issue" data-rel="tooltip" href="#" class="bypass btn btn-minier btn-round btn-primary"><i class="ace-icon fa fa-files-o bigger-100"></i> Detail</a>
                                            </td>
                                        </tr>
                                    <?php } }else {; ?>
										<tr>
											<td colspan="13" class="center">Data kosong !!!</td>
										</tr>
									<?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="widget-toolbox padding-8 clearfix">
                            <a href="<?php echo base_url("blacklist/blacklistbypass");?>" class="btn btn-xs btn-primary btn-bold pull-left">
                                <i class="ace-icon fa fa-floppy-o bigger-120"></i>
                                Tambah
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="viewModalByPass" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">View Detail By Pass</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="inputdetail" name="iddetail">
                <div id="bypass" class="well">
                    <!-- load table dari file detailbypass.php melalui javascript -->
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
                    <form class="form-horizontal" id="formExportExcel" action="<?php echo site_url('toExcel/downloadExcelTenaker');?>" method="POST">
                        <div class="form-group">
                            <label class="col-sm-5 control-label right" for="inputDataExport">Data export</label>
                            <select name="selDataExport" id="inputDataExport" class="col-md-3">
                                <option value="karyawan">Karyawan</option>
                                <option value="tenaker">Tenaga Kerja</option>
                            </select>
                        </div>
                        <div class="center">
                            <button type="submit" class="btn btn-mini btn-success">
                                <i class="ace-icon fa fa-download"></i> Download
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#dataTables-blacklistbypass').on("click", ".bypass", function(){
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url:"<?php echo site_url('blacklist/detailByPass');?>",
                type:"POST",
                data:"kode="+id,
                datatype:"json",
                cache:false,
                success:function(msg){
                    $("#bypass").html(msg);
                }
            });
            $("#viewModalByPass").modal("show");
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-blacklistK').dataTable({
        "order": [[0,'desc']]
    });
    });

    $("#btnModalExcel").click(function () {
            $("#modalToExcel").modal("show");
        });
</script>

<!-- <script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-blacklistTK').dataTable({
        "order": [[0,'desc']]
    });
    });
</script> -->
<!-- <script>
    $(document).ready(function() {
        $('#dataTables-blacklistTK').dataTable({
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

        $("#btnExportTenaker").click(function () {
            $("#tblExport").battatech_excelexport({
                containerid: "dataTables-blacklistTK"
               , datatype: 'table'
            });
        });
    });
</script> -->


<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-blacklistTK').dataTable({
            "order": [[0,'desc']]
        });
        
        $("#btnExportTenaker").click(function () {
            $("#tblExport").battatech_excelexport({
                containerid: "dataTables-blacklistTK"
               , datatype: 'table'
            });
        });
    });
</script>

