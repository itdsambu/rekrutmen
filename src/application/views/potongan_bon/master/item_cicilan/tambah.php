<link rel="stylesheet" href="<?php echo base_url()?>assets/class/select2.css"/>
<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">TAMBAH MASTER ITEM CICILAN</h4>
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
            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PotonganBon/simpan_mst_item_cicilan');?>">
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Kode Item (Auto)</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="txtKodeItem" class="form-control" readonly="" value="<?php echo sprintf("%05s",$kodeitem)?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Nama Item</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="txtNamaItem" class="form-control" placeholder="Nama Item" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Satuan</label>
                                    <div class="col-sm-4">
                                        <select class="form-control select2" name="txtSatuan" id="satuanid">
                                            <option value="">- Pilih -</option>
                                            <?php foreach ($_getMstSatuan as $stn) {
                                                echo "<option value='".$stn->SatuanID."'>".$stn->SingkatanSatuan."</option>";
                                            }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Kategori Cicilan</label>
                                    <div class="col-sm-4">
                                        <select class="form-control select2" name="txtKategori" id="kategoriid">
                                            <option value="">- Pilih -</option>
                                            <?php foreach ($_getMstKategori as $ktg) {
                                                echo "<option value='".$ktg->KategoriCicilanID."'>".$ktg->NamaKategori."</option>";
                                            }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Kode Barcode</label>
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

    $(document).on('keyup', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });
        
    // $(function(){
    //   $('.select2').select2();
    // });
</script>