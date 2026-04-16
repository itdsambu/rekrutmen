<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">LIST MASTER KATEGORI CICILAN</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <br>
            <div class="col-lg-12">
                <?php if($this->input->get('msg') == "success"){
                    echo "<div class='alert alert-success'>";
                    echo "<strong>Sukses !!!</strong> Data berhasil di Simpan.";
                    echo "</div>";
                }elseif($this->input->get('msg') == "failed"){
                    echo "<div class='alert alert-danger'>";
                    echo "<strong>Gagal !!!</strong> Data Sudah Pernah Diregistrasi..!!";
                    echo "</div>";
                }?>
            </div>
            <form class="form-horizontal" role="form" method="POST" >
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-lg-12" id="tbllist">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTables">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Urutan Prioritas</th>
                                            <th class="text-center">Nama Kategori</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Created By</th>
                                            <th class="text-center">Updated By</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($_getDataCicilan as $ktg){?>
                                            <tr>
                                                <td><?php echo $ktg->Prioritas?></td>
                                                <td><?php echo $ktg->NamaKategori?></td>
                                                <td>
                                                    <?php if($ktg->Status == 1){
                                                        echo "Aktif";
                                                    }elseif($ktg->Status == 0){
                                                        echo "Tidak Aktif";
                                                    }else{
                                                        echo "";
                                                    }?>
                                                </td>
                                                <td>
                                                    <div class="text-center"><?php echo $ktg->CreatedBy?></div>
                                                    <div class="text-right smaller-80"><?php echo date('d-M-Y',strtotime($ktg->CreatedDate))?></div>
                                                </td>
                                                <td>
                                                    <div class="text-center"><?php echo $ktg->UpdatedBy?></div>
                                                    <div class="text-right smaller-80">
                                                        <?php if($ktg->UpdatedDate == NULL){echo "";}else{echo date('d-M-Y',strtotime($ktg->UpdatedDate));}?>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?php echo base_url('PotonganBon/edit_mst_cicilan?id='.$ktg->KategoriCicilanID)?>" class="btn btn-minier btn-round btn-success"><i class="fa fa-edit"></i> Ubah</a>
                                                </td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <a href="<?php echo site_url('PotonganBon/tambah_mst_cicilan')?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Item</a>
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
