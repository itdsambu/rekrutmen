<div class="page-header">
    <h1>
        MONITOR
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Blacklist
        </small>
    </h1>
</div>
<div class="row">
    <div class="tabbable">
        <ul class="nav nav-tabs padding-18">
            <li class="active">
                <a data-toggle="tab" href="#karyawan" aria-expanded="true">
                    <i class="green ace-icon fa fa-users bigger-120"></i> Karyawan
                </a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#tenagakerja" aria-expanded="false">
                    <i class="orange ace-icon fa fa-users bigger-120"></i> Tenaga Kerja
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="tab-content no-border padding-24">
    <div id="karyawan" class="tab-pane active">
        <div class="row">
            <div class="col-xs-12">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">List Karyawan Blacklist</h4>

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
                                    echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                                            </button><strong>Warning!!</strong> List Karyawan / Tenaga Kerja Blacklist sudah bisa di gunakan..<br>";
                                }
                            ?>
                            <div class="table-responsive">                            
                                <table id="dataTables-userLogin" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>NAMA</th>
                                        <th>Perusahaan / CV</th>
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
                                    foreach ($getBlacklistK as $row):
                                        ?>
                                        <tr>
                                            <td><?php echo $row->NIK;?></td>
                                            <td><?php echo $row->Nama;?></td>
                                            <td><?php echo $row->CVNama;?></td>
                                            <td><?php echo $row->Pemborong;?></td>
                                            <td><?php echo $row->DeptAbbr;?></td>
                                            <td><?php echo $row->TglMasuk;?></td>
                                            <td><?php echo $row->TglKeluar;?></td>
                                            <td><?php echo $row->Remark;?></td>
                                            <td><?php echo $row->NamaIbuKandung;?></td>
                                            <td>
                                                <!-- <a title="Upload foto" class="btn btn-minier btn-round btn-primary" href="<?php echo site_url('blacklist/doEditFoto')."?id=".$row->NIK; ?>">Edit Foto</a> -->
                                                <a title="Edit" class="btn btn-minier btn-round btn-info" target="_black"  href="<?php echo site_url('blacklist/editBlacklist')."?id=".$row->NIK; ?>">Detail</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="widget-toolbox padding-8 clearfix">
                            <a href="<?php echo base_url("blacklist/karyawan");?>" class="btn btn-xs btn-primary btn-bold pull-left">
                                <i class="ace-icon fa fa-floppy-o bigger-120"></i>
                                Tambah
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="tenagakerja" class="tab-pane">
        <div class="row">
            <div class="col-xs-12">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">List Tenaga Kerja Blacklist</h4>

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
                                            <i class='ace-icon fa fa-times'></i></button>Data user behasil ditambahkan..</p>";
                                }else{
                                    echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
                                            <i class='ace-icon fa fa-times'></i></button><strong>Warning!!</strong> List Karyawan / Tenaga Kerja Blacklist sudah bisa di gunakan..<br>";
                                }
                            ?>
                            <div class="table-responsive">                            
                                <table id="dataTables-userLogin" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>NIK</th>
                                            <th>NAMA</th>
                                            <th>Perusahaan / CV</th>
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
                                    foreach ($getBlacklistTK as $row):
                                        ?>
                                        <tr>
                                            <td><?php echo $row->NIK;?></td>
                                            <td><?php echo $row->Nama;?></td>
                                            <td><?php echo $row->CVNama;?></td>
                                            <td><?php echo $row->Pemborong;?></td>
                                            <td><?php echo $row->DeptAbbr;?></td>
                                            <td><?php echo $row->TglMasuk;?></td>
                                            <td><?php echo $row->TglKeluar;?></td>
                                            <td><?php echo $row->Remark;?></td>
                                            <td><?php echo $row->NamaIbuKandung;?></td>
                                            <td>
                                                <!-- <a title="Upload foto" class="btn btn-minier btn-round btn-primary" href="<?php echo site_url('blacklist/doEditFoto')."?id=".$row->NIK; ?>">Edit Foto</a> -->
                                                <a title="Edit" class="btn btn-minier btn-round btn-info" target="_black"  href="<?php echo site_url('blacklist/editBlacklist')."?id=".$row->NIK; ?>">Detail</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="widget-toolbox padding-8 clearfix">
                            <a href="<?php echo base_url("blacklist/tenagakerja");?>" class="btn btn-xs btn-primary btn-bold pull-left">
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