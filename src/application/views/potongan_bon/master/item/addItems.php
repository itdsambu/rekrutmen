<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">TAMBAH HARGA PER ITEM</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <br>
            <div class="col-lg-12">
                <?php if ($this->input->get('msg') == "success1") {
                    echo "<div class='alert alert-success'>";
                    echo "<strong>Sukses !!!</strong> Data Item dan Harga telah berhasil di Simpan.";
                    echo "</div>";
                } elseif ($this->input->get('msg') == "success2") {
                    echo "<div class='alert alert-success'>";
                    echo "<strong>Sukses !!!</strong> Data Item Sudah Ada dan Harga telah berhasil di Simpan.";
                    echo "</div>";
                } elseif ($this->input->get('msg') == "failed") {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong>Gagal !!!</strong> Data Sudah Pernah Diregistrasi..!!";
                    echo "</div>";
                } ?>

            </div>
            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PotonganBon/simpan_harga_perItem'); ?>">
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Kode Item</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="txtKodeItem" class="form-control" placeholder="Kode Item">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Nama Item</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="txtNamaItem" class="form-control" placeholder="Nama Item">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Satuan</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="txtSatuan" class="form-control" placeholder="Satuan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Kategori</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="txtKategori" class="form-control" placeholder="Kategori">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Barcode</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="txtBarcode" class="form-control" placeholder="Barcode">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-lg-2 control-label"></label>
                                    <div class="col-sm-4">
                                        <button class="btn btn-sm btn-success">Simpan</button>
                                    </div>
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