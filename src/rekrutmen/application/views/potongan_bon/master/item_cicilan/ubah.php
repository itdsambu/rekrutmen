<link rel="stylesheet" href="<?php echo base_url()?>assets/class/select2.css"/>
<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">UBAH MASTER ITEM CICILAN</h4>
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
            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PotonganBon/update_mst_item_cicilan');?>">
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php foreach($_getDataItem as $get){?>
                                    <input type="hidden" name="txtItemID" value="<?php echo $get->CicilanID?>">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Kode Item</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="txtKodeItem" class="form-control" readonly="" value="<?php echo $get->KodeCicilanID?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Nama Item</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="txtNamaItem" class="form-control" placeholder="Nama Item" value="<?php echo $get->NamaCicilan?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Satuan</label>
                                        <div class="col-sm-4">
                                            <select class="form-control select2" name="txtSatuan" id="satuanid">
                                                <option value="">- Pilih -</option>
                                                <?php foreach ($_getMstSatuan as $stn) {
                                                    if($get->SatuanID == $stn->SatuanID){
                                                        echo "<option value='".$stn->SatuanID."' selected>".$stn->NamaSatuan."</option>";
                                                    }else{
                                                        echo "<option value='".$stn->SatuanID."'>".$stn->NamaSatuan."</option>";
                                                    }
                                                }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Kategori</label>
                                        <div class="col-sm-4">
                                            <select class="form-control select2" name="txtKategori" id="kategoriid">
                                                <option value="">- Pilih -</option>
                                                <?php foreach ($_getMstKategori as $ktg) {
                                                    if($get->KategoriCicilanID == $ktg->KategoriCicilanID){
                                                        echo "<option value='".$ktg->KategoriCicilanID."' selected>".$ktg->NamaKategori."</option>";
                                                    }else{
                                                        echo "<option value='".$ktg->KategoriCicilanID."'>".$ktg->NamaKategori."</option>";
                                                    }

                                                }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Kode Barcode</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="txtBarcode" class="form-control"  value="<?php echo $get->Barcode?>" placeholder="Barcode">
                                        </div>
                                    </div>
                                <?php }?>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label"></label>
                                    <div class="col-sm-4">
                                        <button class="btn btn-sm btn-success">Update</button>
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

    // $(function(){
    //   $('.select2').select2();
    // });
</script>