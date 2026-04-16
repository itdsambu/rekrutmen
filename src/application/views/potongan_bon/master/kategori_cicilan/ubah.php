
<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">UBAH MASTER KATEGORI</h4>
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
            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PotonganBon/update_mst_cicilan');?>">
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <?php foreach($_getDataCicilan as $get){?>
                                <input type="hidden" name="txtKategoriCicilanID" value="<?php echo $get->KategoriCicilanID?>">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Nama Kategori</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="txtNamaKategori" class="form-control" placeholder="Nama Kategori" value="<?php echo $get->NamaKategori?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    <label class="col-lg-2 control-label">Urutan Prioritas</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="txtPrioritas" class="form-control" placeholder="Prioritas" value="<?php echo $get->Prioritas;?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Status</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="txtStatus">
                                                <?php if($get->Status == 1){?>
                                                    <option value="1" selected="">Aktif</option>
                                                    <option value="0">Tidak Aktif</option>
                                                <?php }elseif($get->Status == 0){?>
                                                    <option value="1">Aktif</option>
                                                    <option value="0" selected="">Tidak Aktif</option>
                                                <?php }else{?>
                                                    <option value="1">Aktif</option>
                                                    <option value="0">Tidak Aktif</option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label"></label>
                                        <div class="col-sm-4">
                                            <button class="btn btn-sm btn-success">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
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