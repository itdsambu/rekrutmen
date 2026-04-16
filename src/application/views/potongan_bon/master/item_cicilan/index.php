<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">LIST MASTER ITEM CICILAN</h4>
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
                                            <th class="text-center">Kode Item</th>
                                            <th class="text-center">Nama Item</th>
                                            <th class="text-center">Satuan</th>
                                            <th class="text-center">Kategori</th>
                                            <th class="text-center">Barcode</th>
                                            
                                            <th class="text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($dataCicilan as $get){?>
                                            <tr>
                                                <td class="text-center"><?php echo $get->KodeCicilanID ?></td>
                                                <td><?php echo $get->NamaCicilan ?></td>
                                                <td class="text-center"><?php echo $get->SingkatanSatuan ?></td>
                                                <td class="text-center"><?php echo $get->NamaKategori ?></td>
                                                <td class="text-center"><?php echo $get->Barcode ?></td>
                                               
                                                <td class="text-center">
                                                        <a href="<?php echo base_url('PotonganBon/edit_mst_item_cicilan?id='.$get->CicilanID)?>" class="btn btn-minier btn-round btn-success"><i class="fa fa-edit" ></i> Ubah</a>
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
                                <a href="<?php echo site_url('PotonganBon/tambah_mst_item_cicilan')?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Item</a>
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
