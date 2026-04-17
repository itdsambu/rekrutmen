<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/select2.css" />
<div class="preloader" hidden>
    <div class="loading">
        <img src="<?= base_url(); ?>assets/images/NewLoading.gif" width="100%">
    </div>
</div>
<style type="text/css">
    .preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background-color: #fff;
    }

    .preloader .loading {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        font: 14px arial;
    }
</style>

<div class="row"> 
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">TAMBAH MASTER ITEM</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class='alert alert-danger'>
                <strong>PERHATIAN !!!</strong> HARAP DI CEK TERLEBIH DAHULU MASTER ITEM YANG SUDAH ADA PADA TOMBOL "View Master Item" ...!!
                <br>
                <strong>Jika master item yang anda inginkan sudah ada. Silahkan tambah harga dengan master item tersebut..!!</strong>
            </div>
            <div class="col-lg-12">
                <?php if ($this->input->get('msg') == "success") {
                    echo "<div class='alert alert-success'>";
                    echo "<strong>Sukses !!!</strong> Data berhasil di Simpan.";
                    echo "</div>";
                } elseif ($this->input->get('msg') == "failed") {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong>Gagal !!!</strong> Data Sudah Pernah Diinput ...!!";
                    echo "</div>";
                } ?>
            </div>
            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PotonganBon/simpan_mst_item'); ?>">
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-3 col-xs-12 control-label">Kode Barcode</label>
                                    <div class="col-lg-4 col-sm-9 col-xs-12">
                                        <input type="text" name="txtBarcode" id="txtBarcode" class="form-control" onkeyup="getKodeBarcode();" autocomplete="off" placeholder="Barcode">
                                    </div>
                                    <!-- <div class="col-sm-4">
                                    <button type="button" class="btn btn-sm btn-success" id="carikode">Cari Barcode</button>
                                </div> -->
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-xs-12" id="getListPra">
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-3 col-xs-12 control-label">Kode Item (Auto)</label>
                                    <div class="col-lg-4 col-sm-9 col-xs-12">
                                        <input type="hidden" name="txtTanggal" class="form-control" value="<?php echo date('Y-m-d') ?>">
                                        <input type="text" name="txtKodeItem" class="form-control" readonly="" value="<?php echo sprintf("%05s", $kodeitem) ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-3 col-xs-12 control-label">Nama Item</label>
                                    <div class="col-lg-4 col-sm-9 col-xs-12">
                                        <input type="text" name="txtNamaItem" class="form-control" placeholder="Nama Item" autocomplete="off" onkeyup="getSearchItem(this.value);" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-3 col-xs-12 control-label" for="satuanid">Satuan</label>
                                    <div class="col-lg-4 col-sm-9 col-xs-12">
                                        <select class="form-control select2" name="txtSatuan" id="satuanid" required>
                                            <option selected disabled value="">- Pilih -</option>
                                            <?php foreach ($_getMstSatuan as $stn) {
                                                echo "<option value='" . $stn->SatuanID . "'>" . $stn->SingkatanSatuan . "</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-3 col-xs-12 control-label">Kategori</label>
                                    <div class="col-lg-4 col-sm-9 col-xs-12">
                                        <select class="form-control select2" name="txtKategori" id="kategoriid">
                                            <option value="">- Pilih -</option>
                                            <?php foreach ($_getMstKategori as $ktg) {
                                                echo "<option value='" . $ktg->KategoriID . "'>" . $ktg->NamaKategori . "</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-3 col-xs-12 control-label">Harga</label>
                                    <div class="col-lg-4 col-sm-9 col-xs-12">
                                        <input type="text" name="txtHarga" id="Harga" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="tandaPemisahTitik(this);" placeholder="Harga">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-3 col-xs-12 control-label"></label>
                                    <div class="col-lg-4 col-sm-9 col-xs-12">
                                        <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-xs-12">
                                        <a href="<?php echo site_url('PotonganBon/MstItem') ?>" class="btn btn-sm btn-primary"><i class="fa fa-folder"></i> View Master Item</a>
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

<div class="row" id="dataItem" hidden>
    <div class="col-sm-12 col-lg-12 col-12">
        <div class="form-group">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Kode Item</th>
                            <th class="text-center">Nama Item</th>
                            <th class="text-center">Satuan</th>
                            <th class="text-center">Kategori</th>
                            <th class="text-center">Barcode</th>
                            <th class="text-center">dibuat oleh</th>
                        </tr>
                    </thead>
                    <tbody id="bodyTable">
                        <tr>
                            <td colspan="5" class="text-center">Sedang mencari data item...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>