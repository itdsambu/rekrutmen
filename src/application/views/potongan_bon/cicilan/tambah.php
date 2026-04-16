<?php
$option_kategori = "<option></option>";
foreach ($_getMstKategori as $value) {
    $option_kategori .= "<option value='{$value->KategoriCicilanID}'>{$value->NamaKategori}</option>" . PHP_EOL;
}

$option_satuan = "<option></option>";
foreach ($_getMstSatuan as $value) {
    $option_satuan .= "<option value='{$value->SatuanID}'>{$value->NamaSatuan}</option>" . PHP_EOL;
}
?>
<style>
    select[readonly].select2-hidden-accessible+.select2-container {
        pointer-events: none;
        touch-action: none;
    }

    select[readonly].select2-hidden-accessible+.select2-container .select2-selection {
        background: #eee !important;
        box-shadow: none;
    }

    select[readonly].select2-hidden-accessible+.select2-container .select2-selection__arrow,
    .select2-selection__clear {
        display: none;
    }
</style>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/class/select2.css" />
<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><i class="glyphicon glyphicon-shopping-cart"></i> TRANSAKSI CICILAN </h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <br>
            <div class="col-lg-12">
                <?php if ($this->input->get('msg') == "success") {
                    echo "<div class='alert alert-success'>";
                    echo "<strong>Sukses !!!</strong> Data berhasil di Proses.";
                    echo "</div>";
                } elseif ($this->input->get('msg') == "failed") {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong>Gagal !!!</strong> Data Sudah diinput..!!";
                    echo "</div>";
                } elseif ($this->input->get('msg') == "failed2") {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong>Gagal !!!</strong> Nama Tenaga Kerja Wajib diisi ..!!!";
                    echo "</div>";
                } elseif ($this->input->get('msg') == "failed3") {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong>Gagal !!!</strong> Maaf Data Sudah Pernah diinput, silahkan dicek ..!!!";
                    echo "</div>";
                } elseif ($this->input->get('msg') == "failed4") {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong>Gagal !!!</strong> Maaf Tanggal Mulai Lebih Besar Dari Periode Gajian ..!!!";
                    echo "</div>";
                } ?>

            </div>
            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PotonganBon/simpan_trn_cicilan'); ?>">
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Tanggal Transaksi</label>
                                    <div class="col-sm-4">
                                        <input type="date" name="txtTanggal" class="form-control" value="<?php echo date('Y-m-d') ?>" readonly>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label class="col-lg-2 control-label">Periode Gajian</label>
                                    <div class="col-sm-4">
                                        <?php $tanggal_cicil = date('j', strtotime(date('Y-m-d')));
                                        $thn = date('Y', strtotime(date('Y-m-d')));
                                        if ($mulai == $thn . '-01-29' || $mulai == $thn . '-01-30' || $mulai == $thn . '-01-31') {
                                            if ($tanggal_cicil >= 14 && $tanggal_cicil <= 26) {
                                                $tanggalMulai = date('Y-m-16', strtotime($mulai));
                                            } else {
                                                if ($tanggal_cicil == 26 || $tanggal_cicil == 27 || $tanggal_cicil == 28 || $tanggal_cicil == 29 || $tanggal_cicil == 30 || $tanggal_cicil == 31) {
                                                    $bln        = date('m', strtotime($mulai)) + 1;
                                                    $tanggalMulai    = date('Y-0' . $bln . '-1', strtotime($mulai));
                                                } else {
                                                    $tanggalMulai = date('Y-m-1', strtotime($mulai));
                                                    echo $tanggalMulai;
                                                }
                                            }
                                        } else {
                                            if ($tanggal_cicil >= 14 && $tanggal_cicil <= 26) {
                                                $tanggalMulai = date('Y-m-16', strtotime($mulai));
                                            } else {
                                                if ($tanggal_cicil == 26 || $tanggal_cicil == 27 || $tanggal_cicil == 28 || $tanggal_cicil == 29 || $tanggal_cicil == 30 || $tanggal_cicil == 31) {
                                                    $bul        = date('Y-m-d', strtotime('+ 1 months')); // penambahan baru 26-12-2022
                                                    $bln        = date('m', strtotime($bul));
                                                    $bln_fix = str_pad($bln, 2, '0');
                                                    $tahun = date('Y', strtotime($bul));
                                                    $tanggalMulai    = date($tahun . '-' . $bln_fix . '-1', strtotime($mulai));
                                                } else {
                                                    $tanggalMulai = date('Y-m-1', strtotime($mulai));
                                                    echo $tanggalMulai;
                                                }
                                            }
                                        } ?>
                                        <input type="date" name="txtTanggal" class="form-control" value="<?php echo $tanggalMulai ?>" readonly>
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Pemborong</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="txtPemborong" id="pemborong" onchange="ajaxCariSubPemborong()" required>
                                            <?php if (count($_getDataPemborong) > 1) {
                                                $selected = '';
                                            } else {
                                                $selected = 'selected';
                                            } ?> <option value="">- Pilih -</option>
                                            <?php foreach ($_getDataPemborong as $pbr) {
                                                echo "<option value='" . $pbr->IDPemborong . "' " . $selected . ">" . $pbr->Pemborong . "</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">CV Perusahaan</label>
                                    <div class="col-sm-4">
                                        <select id="select-sub-pemborong" name="txtSubPemborong" class="form-control" required>
                                            <option value="">-- Pilih Pemborong Terlebih Dulu --</option>
                                        </select>
                                        <!-- <input type="text" class="form-control" readonly> -->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <!-- <label class="col-lg-2 control-label">Nofix</label>
                                    <div class="col-sm-4">
                                        </div> -->
                                    <input type="hidden" name="txtNofix" id="nik" placeholder="" class="form-control" readonly required>
                                    <!-- <a href="#myModalCari"  data-toggle="modal" id="btnFindTk" class="btn btn-success btn-sm"> Cari <i class="fa fa-search"></i></a> -->
                                    <div class="col-md-2"></div>
                                    <div class="col-lg-4">
                                        <a href="#myModalCari" data-toggle="modal" id="btnFindTk" class="btn btn-success btn-block"><b>Cari</b> <i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                                <div id="otpid">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Nama Lengkap</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="txtNama" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Bagian/Dept</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="txtDept" class="form-control" readonly="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive" id="listid">
                                    <button type="button" class="btn btn-sm btn-warning" onclick="tambah_baris()"><i class="fa fa-plus"></i> Tambah Item</button>
                                    <hr>
                                    <table class="table table-bordered" id="dataTables">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="background-color: #d9edf7;"><label class="label label-sm label-default"><i class="fa fa-trash"></i></label>

                                                </th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 200px;">Nama Item</th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 110px;">Harga (Rp.)</th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 110px;">DP (Rp.)</th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 110px;">Harga Untuk dicicil</th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 100px;">Qty</th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 100px;">Total Cicilan</th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 150px;">Satuan</th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 150px;">Kategori</th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 100px;">Periode Cicilan (x)</th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 100px;">Mulai Cicilan </th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 100px;">Periode diPotong</th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 100px;">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="txtBaris">
                                                <td class="text-center">
                                                    <button type="button" onclick="hapus_baris(this)" class="btn btn-minier btn-danger"><i class="fa fa-trash"></i></button>
                                                </td>
                                                <td style="width: 350px;">
                                                    <div>
                                                        <select class="form-control select2-item txt" name="txtItem[]" id="item1" onchange="ajax_harga(this.id)">
                                                            <option value="">- Pilih -</option>
                                                            <?php foreach ($_getListItem as $itm) {
                                                                // echo "<option value='".$itm->CicilanID.",".$itm->NamaCicilan." '>".$itm->NamaCicilan."</option>";
                                                                echo "<option value='" . $itm->CicilanID . "'>" . $itm->NamaCicilan . "</option>";
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td id="idItem1">
                                                    <input type="text" class="form-control" id="harga1" value="" onkeyup="konversi_angka(1);hitung(1)">
                                                    <input id="realHarga1" type="hidden" name="txtHarga[]">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="dp1" value="" onkeyup="konversi_angka(1);hitung(1);hitungtotal(1)">
                                                    <input id="realDp1" type="hidden" name="txtDp[]">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="hargacicil1" value="0" readonly="">
                                                    <input id="realhargacicil1" type="hidden" name="txtHargacicil[]">
                                                </td>
                                                <td>
                                                    <input type="text" min="0" class="form-control" name="txtQuantity[]" id="quantity1" value="0" onkeydown="return numbersonly(this, event);" onkeyup="hitung(1);hitungsemuacicilan(1)">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="totalcicil1" value="0" readonly="">
                                                    <input id="realcicil1" type="hidden" name="txtTotalcicil[]">
                                                </td>
                                                <td>
                                                    <select name="txtSatuanid[]" id="satuanid1" class="form-control select2-element" data-placeholder="Pilih Satuan">
                                                        <?= $option_satuan; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control select2-element" name="txtKategoriid[]" id="kategoriid1" data-placeholder="Pilih Kategori">
                                                        <?= $option_kategori; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="txtPeriode[]" id="periode1" value="0" onkeyup="hitung(1)">
                                                    <input type="hidden" class="form-control" name="txtPeriodeke[]" id="periodeke1" value="1">
                                                </td>
                                                <td><input type="date" class="form-control mulai" name="txtMulai[]" id="mulai" value="<?php echo date('Y-m-d') ?>" required></td>
                                                <td id="idperiodedipotong" class="idperiodedipotong">
                                                    <select class="form-control periodepotong" name="txtperiodepotong" id="periodepotong" required>
                                                        <option value="">- Pilih -</option>
                                                        <option value="1" selected>1</option>
                                                        <option value="2" id="dua">2</option>
                                                        <option value="3">1 dan 2</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="total1" value="0" readonly="">
                                                    <input id="realTotal1" type="hidden" name="txtTotal[]">
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="12" class="text-center"><strong>Grand Total</strong></td>
                                                <td>
                                                    <input type="text" class="form-control" name="txtGrandTotal" id="grandTotal" value="0" readonly="">
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button class="btn btn-sm btn-success">Simpan</button>
                        <a href="<?= site_url('PotonganBon/Cicilan'); ?>" class="btn btn-sm btn-default">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalCari" tabindex="-2" role="dialog" aria-labelledby="view" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">DAFTAR TENAGA KERJA</h4>
            </div>
            <div class="modal-body">
                <div id="lihat_detail" class="well">
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> NIK / Nama * </label>
                        <div class="col-sm-8">
                            <input type="text" class="col-xs-12 col-sm-10" name="txtPraID" id="txtPraID" required="">
                            &nbsp;&nbsp;&nbsp;
                            <button type="button" id="btnCari" class="btn btn-success btn-sm"> Refresh</button>
                            <p class="text-danger" style="margin-top: 10px;" id="error-search"></p>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div id="getListPra">
                        <table class="table table-hover table-striped table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Nik</th>
                                    <th style="text-align: center">Nama Lengkap</th>
                                    <th style="text-align: center">Pemborong</th>
                                    <th style="text-align: center">Dept / Bag</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $("#btnCari").click(function() {
            var KataKunci = $('#txtPraID').val();
            var SubPemborong = $('#select-sub-pemborong').val();
            $('#error-search').text('');

            if (KataKunci.length >= 3 && KataKunci !== "" && SubPemborong !== "") {
                document.getElementById('btnCari').disabled = true;
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('PotonganBon/ajaxCariTenagaKerja') ?>",
                    data: {
                        'ajax_kata_kunci': KataKunci,
                        'ajax_sub_pemborong': SubPemborong,
                    }
                }).done(function(response) {
                    $('#getListPra').html(response);
                    document.getElementById('btnCari').disabled = false;
                });
            } else {
                if (SubPemborong === "") {
                    $('#error-search').text('Sub pemborong harus dipilih.');
                } else {
                    $('#error-search').text('Pencarian minimal 3 karakter');
                }
            }
        });
    </script>
</div>

<script type="text/javascript">
    // $(document).ready(function() {
    //     ajaxCariSubPemborong();
    //     // $('.select2-element').select2();
    //     // $('.select2-item').select2({
    //     //     tags : true,
    //     //     createTag: function (params) {
    //     //         return {
    //     //             id: params.term,
    //     //             text: params.term,
    //     //             newOption: true
    //     //         }
    //     //     },
    //     //     templateResult: function (data) {
    //     //         var $result = $("<span></span>");

    //     //         $result.text(data.text);

    //     //         if (data.newOption) {
    //     //             $result.append(" <em>(Baru)</em>");
    //     //         }

    //     //         return $result;
    //     //     }
    //     // });
    // });

    function ajaxCariSubPemborong() {
        var idPbr = $('#pemborong').val();

        // Cek apakah pemborong diisi atau tidak
        if (idPbr) {
            $.ajax({
                url: '<?= base_url(); ?>PotonganBon/ajaxGetSubPemborong/' + idPbr,
                dataType: 'html'
            }).done(function(response) {
                $('#select-sub-pemborong').html(response);
                cekTanggal();
            });
        } else {
            $('#select-sub-pemborong').html("<option value=''>-- Pilih Pemborong Terlebih Dahulu --</option>")
        }
    }
</script>
<script type="text/javascript">
    function tambah_baris() {
        // alert('hahaha');
        var jum = document.getElementsByClassName('txt');
        var l = jum.length + 1;

        var no = l + 1;
        var num = 1;
        for (var i = 0; i < num; i++) {
            $('table[id="dataTables"] tbody').append(`
                <tr class="txtBaris">
                    <td class="text-center">
                        <type="button" onclick="hapus_baris(this)" class="btn btn-minier btn-danger"><i class="fa fa-trash"></i></button>
                    </td>
                    <td style="width: 350px;">
                        <div>
                            <select class="form-control select2-item txt" name="txtItem[]" id="item${l}" onchange="ajax_harga(this.id)">
                                <option value="">- Pilih -</option>
                                <?php foreach ($_getListItem as $itm) {
                                    // echo "<option value='" . $itm->CicilanID . "," . $itm->NamaCicilan . " '>" . $itm->NamaCicilan . "</option>";
                                    echo "<option value='" . $itm->CicilanID . "'>" . $itm->NamaCicilan . "</option>";
                                } ?>
                            </select>
                        </div>
                    </td>
                    <td id="idItem${l}">
                        <input type="text" class="form-control" id="harga${l}" value="" onkeyup="konversi_angka(${l});hitung(${l})">
                        <input id="realHarga${l}" type="hidden" name="txtHarga[]">
                    </td>
                    <td>
                        <input type="text" class="form-control" id="dp${l}" value="" onkeyup="konversi_angka(${l});hitung(${l});hitungtotal(${l})">
                        <input id="realDp${l}" type="hidden" name="txtDp[]">
                    </td>
                    <td>
                        <input type="text" class="form-control"  id="hargacicil${l}" value="0" readonly="">
                        <input id="realhargacicil${l}" type="hidden" name="txtHargacicil[]">
                    </td>
                    <td>
                        <input type="text" min="0" class="form-control" name="txtQuantity[]" id="quantity${l}" value="0" onkeydown="return numbersonly(this, event);" onkeyup="hitung(${l});hitungsemuacicilan(${l})">
                    </td>
                    <td>
                        <input type="text" class="form-control"  id="totalcicil${l}" value="0" readonly="">
                        <input id="realcicil${l}" type="hidden" name="txtTotalcicil[]">
                    </td>
                    <td>
                        <select name="txtSatuanid[]" id="satuanid${l}" class="form-control select2-element" data-placeholder="Pilih Satuan">
                            <?= $option_satuan; ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-control select2-element" name="txtKategoriid[]" id="kategoriid${l}" data-placeholder="Pilih Kategori">
                            <?= $option_kategori; ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="txtPeriode[]" id="periode${l}" value="0" onkeyup="hitung(${l})">
                        <input type="hidden" class="form-control" name="txtPeriodeke[]" id="periodeke${l}" value="1">
                    </td>
                    <td><input type="date" class="form-control mulai" name="txtMulai[]" id="mulai" value="<?php echo date('Y-m-d') ?>" ></td>
                    <td id="idperiodedipotong" class="idperiodedipotong">
                        <select class="form-control periodepotong" name="txtperiodepotong[]" id="periodepotong${l}">
                            <option value="">- Pilih -</option>
                            <option value="1" selected>1</option>
                            <option value="2">2</option>
                            <option value="3">1 dan 2</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control"  id="total${l}" value="0" readonly="" onkeyup=" hitung(${l})">
                        <input id="realTotal${l}" type="hidden" name="txtTotal[]">
                    </td>
                </tr>
            `);
        }

        $('.select2-element').select2();
        $('.select2-item').select2({
            tags: true,
            createTag: function(params) {
                return {
                    id: params.term,
                    text: params.term,
                    newOption: true
                }
            },
            templateResult: function(data) {
                var $result = $("<span></span>");

                $result.text(data.text);

                if (data.newOption) {
                    $result.append(" <em>(Baru)</em>");
                }

                return $result;
            }
        });
    }

    function konversi_angka(id) {
        var harga = $('#harga' + id).val().replaceAll(".", "");
        $('#realHarga' + id).val(harga);
        $('#harga' + id).val(tandaPemisahTitik(harga));

        var dp = $('#dp' + id).val().replaceAll(".", "");
        $('#realDp' + id).val(dp);
        $('#dp' + id).val(tandaPemisahTitik(dp));

    }

    function hitung(id) {
        // alert(id);
        var jmlBaris = document.getElementsByClassName('txt').length;
        var hrg = $('#realHarga' + id).val();
        var dp = $('#realDp' + id).val();
        var quantity = $('#quantity' + id).val();
        var periode = $('#periode' + id).val();

        // alert(periode);
        if (periode > 0) {
            var jumlah = (hrg - dp) * quantity / periode;
        } else {
            var jumlah = 0;
        }

        // alert(jumlah);
        document.getElementById('total' + id).value = tandaPemisahTitik(Math.round(jumlah));
        document.getElementById('realTotal' + id).value = Math.round(jumlah);

        var grand = 0;
        for (var i = 1; i <= jmlBaris; i++) {
            grand += parseInt($('#realTotal' + i).val());

        }

        grandTotal = Math.ceil(grand);

        document.getElementById("grandTotal").value = tandaPemisahTitik(grandTotal);
    }

    function hitungtotal(id) {
        var jmlBaris = document.getElementsByClassName('txt').length;
        var hrg = $('#realHarga' + id).val();
        var dp = $('#realDp' + id).val();

        //alert(dp);
        if (dp > 0) {
            var HarusBayar = (hrg - dp);
        } else {
            var HarusBayar = hrg;
        }

        document.getElementById('hargacicil' + id).value = tandaPemisahTitik(Math.round(HarusBayar));
        document.getElementById('realhargacicil' + id).value = Math.round(HarusBayar);

        var grand = 0;
        for (var i = 1; i <= jmlBaris; i++) {
            grand += parseInt($('#realhargacicil' + i).val());
        }
    }

    function hitungsemuacicilan(id) {
        var jmlBaris = document.getElementsByClassName('txt').length;
        var hrg = $('#realHarga' + id).val();
        var dp = $('#realDp' + id).val();
        var quantity = $('#quantity' + id).val();

        if (quantity > 0) {
            var semuaCicilan = (hrg * quantity) - dp;
        } else {
            var semuaCicilan = 0;
        }
        document.getElementById('totalcicil' + id).value = tandaPemisahTitik(Math.round(semuaCicilan));
        document.getElementById('realcicil' + id).value = Math.round(semuaCicilan);
        var grand = 0;
        for (var i = 1; i <= jmlBaris; i++) {
            grand += parseInt($('#realcicil1' + i).val());
        }

    }

    function hapus_baris(btn_hapus) {
        $(btn_hapus).closest('tr').remove();
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
</script>

<script type="text/javascript">
    function ajax_harga(id) {
        var idBaris = id.substr(4);
        var item = $('#' + id).val();
        console.log(item);

        // Ajax Get Satuan ID dari Item yang sudah dipilih
        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajax_satuanidNew') ?>" + "/" + item
        }).done(function(msg) {
            if (msg == '') {
                $("#satuanid" + idBaris).val(null).trigger('change');
                $("#satuanid" + idBaris).removeAttr("readonly");
            } else {
                $("#satuanid" + idBaris).val(msg).trigger('change');
                $("#satuanid" + idBaris).attr("readonly", "");
            }
        });

        // Ajax Get Kategori dari item yang sudah dipilih
        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajax_kategoriidNew') ?>" + "/" + item
        }).done(function(msg) {
            if (msg == '') {
                $("#kategoriid" + idBaris).val(null).trigger('change');
                $("#kategoriid" + idBaris).removeAttr("readonly");
            } else {
                $("#kategoriid" + idBaris).val(msg).trigger('change');
                $("#kategoriid" + idBaris).attr("readonly", "");
            }
        });
    }

    function hapus_item(id) {
        var dtlid = id;

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/hapus_item') ?>" + "/" + dtlid,
            success: function(msg) {
                location.reload();
            }
        });
    }
</script>
<script type="text/javascript">
    function send_data() {
        var nik = $('#nik').val();
        var sub_pemborong = $('#select-sub-pemborong').val();

        if (nik == 0) {
            alert('Nik Harap Diisi..!!');
        } else {
            $.ajax({
                type: "GET",
                dataType: "html",
                url: "<?php echo base_url('PotonganBon/send_data') ?>" + "/" + nik + "/" + sub_pemborong,
                success: function(msg) {
                    if (msg == '') {
                        alert('Tidak ada data');
                    } else {
                        $("#otpid").html(msg);
                    }
                }
            });
        }
    }

    function pilih_nik(nik) {
        $('#nik').val(nik);
        var sub_pemborong = $('#select-sub-pemborong').val();

        if (nik == 0) {
            alert('Nik Harap Diisi..!!');
        } else {
            $.ajax({
                type: "GET",
                dataType: "html",
                url: "<?php echo base_url('PotonganBon/send_data') ?>" + "/" + nik + "/" + sub_pemborong,
                success: function(msg) {
                    if (msg == '') {
                        alert('Tidak ada data');
                    } else {
                        $("#otpid").html(msg);
                    }
                }
            });
        }
    }

    function get_item_pemborong() {
        var pbr = $('#pemborong').val();

        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajax_list_item_cicilan') ?>" + "/" + pbr,
            success: function(msg) {
                if (msg == '') {
                    alert('Tidak ada data');
                } else {
                    $("#listid").html(msg);
                }
            }
        });
    }
</script>
<script type="text/javascript">
    $(document).on('change', '.mulai', function() {
        var tanggal_mulai = $(this).val()
        var that = $(this).closest('tr').find('.idperiodedipotong')
        mulai = new Date(tanggal_mulai);
        tgl = mulai.getDate();

        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/getPeriodeDipotong') ?>" + "/" + tgl,
            success: function(msg) {
                if (msg == '') {
                    alert('Tidak ada data');
                } else {
                    that.html(msg);
                }
            }
        });
    })

    function cekTanggal(a) {
        var tanggal_mulai = $("#mulai").val();
        // var tanggal_mulai = a.val();
        console.log($(this))
        let that = $(this).closest('tr').find('#idperiodedipotong')


        mulai = new Date(tanggal_mulai);
        tgl = mulai.getDate();
        // console.log(tgl);
        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/getPeriodeDipotong') ?>" + "/" + tgl,
            success: function(msg) {
                if (msg == '') {
                    alert('Tidak ada data');
                } else {

                    $("#idperiodedipotong").html(msg);
                    that.html(msg);
                }
            }
        });

    }
    $(document).ready(function() {
        $('#mulai').change(function() {
            // alert(123)

        })
    });
</script>