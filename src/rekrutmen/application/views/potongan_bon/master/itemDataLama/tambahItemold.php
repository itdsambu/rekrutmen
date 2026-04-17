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
<!-- <script type="text/javascript">
    $("#carikode").click(function(){
        var Barcode = $('#txtBarcode').val();
 
         //alert(Barcode);
        // alert(pemborong);
        if(Barcode == ''){
            
        }else{
             $.ajax({
                type: "POST",
                url : "<?php echo site_url('PotonganBon/getBykode') ?>",
                data: {
                    'KodeBarkode' : Barcode,
                },
                beforeSend:function()
                {
                    $(".preloader").attr("hidden",false);
                },
                success: function(msg){
                        $(".preloader").attr("hidden",true);
                    if(msg == 0){
                        alert("Produk tidak ditemukan!");
                    }else{
                        $('#getListPra').html(msg);                       
                    }
                }
            });
            document.getElementById('carikode').disabled = false;
        }
    });
</script> -->

<script type="text/javascript">
    $(document).ready(function() {

        // Fungsi Ketika Input Barcode Diisi
        $('#Barcode').on('keydown', function(event) {
            // Jika tombol Enter
            if (event.keyCode === 13) {
                alert('bar')


                event.preventDefault();
                // Ambil Isi Barcode
                var barCode = $('#Barcode').val();

            }
        });

        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });


    $(document).ready(function() {
        $('#dataTables').dataTable();
    });

    var timerExecution;

    function getKodeBarcode() {
        clearTimeout(timerExecution);
        timerExecution = setTimeout(function() {
            // alert("Gass pollll");
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('PotonganBon/getBykode') ?>",
                data: {
                    'KodeBarkode': $('#txtBarcode').val(),

                },
                beforeSend: function() {
                    $(".preloader").attr("hidden", false);
                },
                success: function(msg) {
                    $(".preloader").attr("hidden", true);
                    if (msg == 0) {
                        alert("Produk tidak ditemukan!");
                    } else {
                        $('#getListPra').html(msg);
                    }
                }
            });
        }, 3000);
    }

    function getSearchItem(item) {
        if (item.length >= 3) {
            $.ajax({
                url: "<?= base_url() ?>PotonganBon/get_search_item",
                type: "POST",
                data: {
                    item: item,
                },
                dataType: "JSON",
                error: function() {
                    $("#dataItem").attr("hidden", false);
                },
                success: function(response) {
                    var tbody;
                    $("#dataItem").attr("hidden", false);
                    if (response.length == 0) {
                        tbody += `<
                  <tr>
                    <td colspan="5" class="text-center">Data item tidak ditemukan...</td>
                  </tr>`;
                    } else {
                        console.log(response);
                        for (i = 0; i < response.length; i++) {
                            tbody += `<
                    <tr>
                      <tr>
                          <td class="text-center">${response[i].KodeItem}</td>
                          <td>${response[i].NamaItem}</td>
                          <td class="text-center">${response[i].SingkatanSatuan}</td>
                          <td class="text-center">${response[i].NamaKategori}</td>
                          <td class="text-center">${response[i].KodeBarkode}</td>
                          <td>
                              <div class="text-left">${response[i].CreatedBy}</div>
                              <div class="text-right smaller-80">${response[i].CreatedDate}</div>
                          </td>                               
                      </tr>
                    </tr>`;
                        }
                    }
                    $("#bodyTable").html(tbody);
                }
            });
        } else {
            $("#dataItem").attr("hidden", true);
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables').dataTable();
    });

    function tandaPemisahTitik(b) {
        var _minus = false;
        if (b < 0) _minus = true;
        b = b.toString();
        b = b.replace(".", "");

        c = "";
        panjang = b.length;
        j = 0;
        for (i = panjang; i > 0; i--) {
            j = j + 1;
            if (((j % 3) == 1) && (j != 1)) {
                c = b.substr(i - 1, 1) + "." + c;
            } else {
                c = b.substr(i - 1, 1) + c;
            }
        }
        if (_minus) c = "-" + c;
        return c;
    }

    function numbersonly(ini, e) {
        if (e.keyCode >= 49) {
            if (e.keyCode <= 57) {
                a = ini.value.toString().replace(".", "");
                b = a.replace(/[^\d]/g, "");
                b = (b == "0") ? String.fromCharCode(e.keyCode) : b + String.fromCharCode(e.keyCode);
                ini.value = tandaPemisahTitik(b);
                return false;
            } else if (e.keyCode <= 105) {
                if (e.keyCode >= 96) {
                    //e.keycode = e.keycode - 47;
                    a = ini.value.toString().replace(".", "");
                    b = a.replace(/[^\d]/g, "");
                    b = (b == "0") ? String.fromCharCode(e.keyCode - 48) : b + String.fromCharCode(e.keyCode - 48);
                    ini.value = tandaPemisahTitik(b);
                    //alert(e.keycode);
                    return false;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else if (e.keyCode == 48) {
            a = ini.value.replace(".", "") + String.fromCharCode(e.keyCode);
            b = a.replace(/[^\d]/g, "");
            if (parseFloat(b) != 0) {
                ini.value = tandaPemisahTitik(b);
                return false;
            } else {
                return false;
            }
        } else if (e.keyCode == 95) {
            a = ini.value.replace(".", "") + String.fromCharCode(e.keyCode - 48);
            b = a.replace(/[^\d]/g, "");
            if (parseFloat(b) != 0) {
                ini.value = tandaPemisahTitik(b);
                return false;
            } else {
                return false;
            }
        } else if (e.keyCode == 8 || e.keycode == 46) {
            a = ini.value.replace(".", "");
            b = a.replace(/[^\d]/g, "");
            b = b.substr(0, b.length - 1);
            if (tandaPemisahTitik(b) != "") {
                ini.value = tandaPemisahTitik(b);
            } else {
                ini.value = "";
            }

            return false;
        } else if (e.keyCode == 9) {
            return true;
        } else if (e.keyCode == 17) {
            return true;
        } else {
            //alert (e.keyCode);
            return false;
        }

    }
</script>