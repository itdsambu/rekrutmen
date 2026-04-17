<div class="page-header">
    <h1>
        MANAGEMENT BLACKLIST
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            List Blacklist
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
                        <h4 class="widget-title">List User Login</h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
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
                                }else{
                                    echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
                                            <i class='ace-icon fa fa-times'></i></button><strong>Warning!!</strong> List Karyawan / Tenaga Kerja Blacklist masih tahap pengembangan..<br>";
                                }
                            ?>
                            <div class="table-responsive">                            
                                <table id="dataTables-userLogin" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>PEMBORONG</th>
                                        <th>Department</th>
                                        <th>TANGGAL MASUK</th>
                                        <th>TANGGAL KELUAR</th>
                                        <th>KETERANGAN</th>
                                        <th>NAMA IBU</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    foreach ($getBlacklist as $row):
                                        ?>
                                        <tr>
                                            <td><?php echo $row->NIK;?></td>
                                            <td><?php echo $row->Pemborong;?></td>
                                            <td><?php echo $row->DeptAbbr;?></td>
                                            <td><?php echo $row->TglMasuk;?></td>
                                            <td><?php echo $row->TglKeluar;?></td>
                                            <td><?php echo $row->Remark;?></td>
                                            <td><?php echo $row->NamaIbuKandung;?></td>
                                            <td>
                                                <!-- <a title="Upload foto" class="btn btn-minier btn-round btn-primary" href="<?php echo site_url('blacklist/doEditFoto')."?id=".$row->NIK; ?>">Edit Foto</a> -->
                                                <a title="Edit" class="btn btn-minier btn-round btn-info" href="<?php echo site_url('blacklist/editBlacklist')."?id=".$row->NIK; ?>">Detail</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="widget-toolbox padding-8 clearfix">
                            <a href="<?php echo base_url("blacklist/index");?>" class="btn btn-xs btn-primary btn-bold pull-left">
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-userLogin').dataTable();
        
        $('[data-rel=tooltip]').tooltip();
    });
</script>
<script src="<?php echo base_url();?>assets/js/bootbox.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        $("#dataTables-userLogin").on("click", ".delete", function() {
            var id = $(this).data('id');
            bootbox.confirm("Apakah anda yakin untuk menghapus User Login dengan UserID =  "+id+" ?", function(result) {
                if(result) {
                    window.location='deleteUserLogin?id='+id;
                }
            });
        });
    });
</script>