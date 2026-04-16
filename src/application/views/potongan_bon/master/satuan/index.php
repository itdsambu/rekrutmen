<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">LIST MASTER SATUAN</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <br>
            <div class="col-lg-12">
                <?php if ($this->input->get('msg') == "success") {
                    echo "<div class='alert alert-success'>";
                    echo "<strong>Sukses !!!</strong> Data berhasil di Simpan.";
                    echo "</div>";
                } elseif ($this->input->get('msg') == "failed") {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong>Gagal !!!</strong> Data Sudah Pernah Diregistrasi..!!";
                    echo "</div>";
                } ?>

            </div>
            <form class="form-horizontal" role="form" method="POST">
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-lg-12">
                                <a href="<?php echo site_url('PotonganBon/tambah_mst_satuan') ?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Satuan</a>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12" id="tbllist">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTables">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Nama Satuan</th>
                                                <th class="text-center">Singkatan</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Created By</th>
                                                <th class="text-center">Updated By</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($_getDataSatuan as $get) { ?>
                                                <tr>
                                                    <td><?php echo $get->NamaSatuan ?></td>
                                                    <td><?php echo $get->SingkatanSatuan ?></td>
                                                    <td class="text-center">
                                                        <?php if ($get->Status == 1) {
                                                            echo "<span class='label label-sm label-round label-success'>Aktif</span>";
                                                        } elseif ($get->Status == 0) {
                                                            echo "<span class='label label-sm label-round label-success'>Tidak Aktif</span>";
                                                        } else {
                                                            echo "";
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <div class="text-center"><?php echo $get->CreatedBy ?></div>
                                                        <div class="text-center smaller-80"><?php echo date('d-M-Y', strtotime($get->CreatedDate)) ?></div>
                                                    </td>
                                                    <td>
                                                        <div class="text-center"><?php echo $get->UpdateBy ?></div>
                                                        <div class="text-center smaller-80">
                                                            <?php if ($get->UpdateDate == NULL) {
                                                                echo "";
                                                            } else {
                                                                echo date('d-M-Y', strtotime($get->UpdateDate));
                                                            } ?>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="<?php echo base_url('PotonganBon/edit_mst_satuan?id=' . $get->SatuanID) ?>" class="btn btn-minier btn-round btn-success"><i class="fa fa-edit"></i> Ubah</a>
                                                    </td>
                                                </tr>
                                            <?php
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables').dataTable();
    });
</script>