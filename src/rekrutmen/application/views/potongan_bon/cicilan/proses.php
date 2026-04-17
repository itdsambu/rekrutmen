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
<link rel="stylesheet" href="<?php echo base_url() ?>assets/class/select2.css" />
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
<link href="<?php echo base_url(); ?>assets/sweetalert2-11.3.6/dist/sweetalert2.min.css" rel="stylesheet">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><i class="glyphicon glyphicon-shopping-cart"></i>PROSES TRANSAKSI CICILAN </h4>
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
                } ?>

            </div>
            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PotonganBon/simpan_trn_potongan_cicilan'); ?>">
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php foreach ($_getTrnHeader as $hdr) { ?>
                                    <input type="hidden" name="txtHeaderID" id="headerid" value="<?php echo $hdr->HeaderID ?>">

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Tanggal Transaksi</label>
                                        <div class="col-sm-4">
                                            <input type="date" name="txtTanggal" class="form-control" value="<?php echo date('Y-m-d') ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Pemborong</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" value="<?= $hdr->Pemborong; ?>" id="pemborong" readonly>
                                            <input type="hidden" name="txtPemborong" value="<?= $hdr->IDPemborong; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">CV. Perusahaan</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" value="<?= $hdr->NamaSub; ?>" id="sub-pemborong" readonly>
                                            <input type="hidden" name="txtSubPemborong" value="<?= $hdr->IDSubPemborong; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">NIK</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="nik" id="nik" placeholder="Input Nik" class="form-control" value="<?php echo $hdr->Nik; ?>" readonly>
                                            <input type="hidden" name="txtNofix" id="nofix" placeholder="Input Nik" class="form-control" value="<?php echo $hdr->Nofix ?>" readonly>
                                        </div>
                                    </div>
                                    <div id="otpid">
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Nama Lengkap</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="txtNama" class="form-control" readonly value="<?php echo $hdr->Nama; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Bagian/Dept</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="txtDept" class="form-control" readonly="" value="<?php echo $hdr->BagianAbbr; ?>">
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
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
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 100px;">Qty</th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 150px;">Satuan</th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 150px;">Kategori</th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 100px;">Periode Cicilan (x)</th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 100px;">Sisa Durasi Cicilan (x)</th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 100px;">Mulai Cicilan </th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 100px;">Periode diPotong</th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 100px;">Total</th>
                                                <th class="text-center" style="background-color: #d9edf7;min-width: 100px;">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="">
                                            <?php
                                            foreach ($_getTrnDetail as $key => $dtl) {
                                                $no = ($key + 1);
                                            ?>
                                                <tr class="txtBaris">
                                                    <td class="text-center">
                                                        <a href="#" id="<?= $dtl->DetailID ?>" class="btn btn-minier btn-round btn-danger" onclick="viewHapus(this.id)"><i class="fa fa-trash"></i></a>
                                                        <!-- <button type="button" onclick="hapus_baris(this)" class="btn btn-minier btn-danger"><i class="fa fa-trash"></i></button> -->
                                                        <input type="hidden" name="txtDetailID[]" value="<?= $dtl->DetailID; ?>">
                                                    </td>
                                                    <td style="width: 350px;">
                                                        <div>
                                                            <select class="form-control select2-item txt" name="txtItem[]" id="item<?= $no; ?>" onchange="ajax_harga(this.id)" disabled>
                                                                <option value="">- Pilih -</option>
                                                                <?php foreach ($_getListItem as $itm) {
                                                                    if ($dtl->CicilanID != $itm->CicilanID) {
                                                                        echo "<option value='" . $itm->CicilanID . "'>" . $itm->NamaCicilan . "</option>";
                                                                    } else {
                                                                        echo "<option value='" . $itm->CicilanID . "' selected>" . $itm->NamaCicilan . "</option>";
                                                                    }
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td id="idItem<?= $no; ?>">
                                                        <input type="text" class="form-control" id="harga<?= $no; ?>" value="<?= $dtl->Harga; ?>" onkeyup="konversi_angka(<?= $no; ?>);hitung(<?= $no; ?>)">
                                                        <input id="realHarga<?= $no; ?>" type="hidden" name="txtHarga[]" value="<?= $dtl->Harga; ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="dp<?= $no; ?>" value="<?= $dtl->DP; ?>" onkeyup="konversi_angka(<?= $no; ?>);hitung(<?= $no; ?>)">
                                                        <input id="realDp<?= $no; ?>" type="hidden" name="txtDp[]" value="<?= $dtl->DP; ?>">
                                                    </td>
                                                    <td>
                                                        <input type="number" min="0" class="form-control" value="<?= $dtl->Quantity; ?>" name="txtQuantity[]" id="quantity<?= $no; ?>" onkeyup="hitung(<?= $no; ?>)">
                                                    </td>
                                                    <td>
                                                        <select name="txtSatuanid[]" id="satuanid<?= $no; ?>" class="form-control select2-element" data-placeholder="Pilih Satuan" disabled>
                                                            <?= $option_satuan; ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select2-element" name="txtKategoriid[]" id="kategoriid<?= $no; ?>" data-placeholder="Pilih Kategori" disabled>
                                                            <?= $option_kategori; ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="txtPeriode[]" id="periode<?= $no; ?>" value="<?= $dtl->Cicilan; ?>" onkeyup="hitung(<?= $no; ?>)">
                                                        <input type="hidden" class="form-control" name="txtPeriodeke[]" id="periodeke<?= $no; ?>" value="<?= $dtl->CicilanKe; ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="txtDurasi[]" id="Durasi<?= $no; ?>" value="<?= $dtl->SisaDurasi; ?>" onkeyup="hitung(<?= $no; ?>)">
                                                    </td>
                                                    <td><input type="date" class="form-control" name="txtMulai[]" id="mulai<?= $no; ?>" value="<?= $dtl->TanggalMulai; ?>"></td>
                                                    <td>
                                                        <select class="form-control" name="txtperiodepotong[]" id="periodepotong<?= $no; ?>" required>


                                                            <?php if ($dtl->PeriodeDipotong == '1') {
                                                                echo "<option value='1' selected>1</option>";
                                                                echo "<option value='2'>2</option>";
                                                                echo "<option value='3'>1 dan 2</option>";
                                                            } elseif ($dtl->PeriodeDipotong == '2') {
                                                                echo "<option value='2' selected >2</option>";
                                                                echo "<option value='1'>1</option>";
                                                                echo "<option value='3'>1 dan 2</option>";
                                                            } elseif ($dtl->PeriodeDipotong == '3') {
                                                                echo "<option value='3' selected >1 dan 2</option>";
                                                                echo "<option value='1'>1</option>";
                                                                echo "<option value='2'>2</option>";
                                                            } else {
                                                                echo "<option value='1'>1</option>";
                                                                echo "<option value='2'>2</option>";
                                                                echo "<option value='3'>1 dan 2</option>";
                                                            } ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="total<?= $no; ?>" value="<?= number_format($dtl->HargaCicilan, 0, ',', '.'); ?>" readonly="">
                                                        <input id="realTotal<?= $no; ?>" type="hidden" name="txtTotal[]" value="<?= $dtl->HargaCicilan; ?>">
                                                    </td>
                                                    <td>
                                                        <?php if (isset($dtl->Keterangan)) { ?>
                                                            <input type="text" class="form-control uppercase" name="txtKeterangan[]" id="Keterangan<?= $no; ?>" value="<?= $dtl->Keterangan; ?>">
                                                        <?php
                                                        } else { ?>
                                                            <input type="text" class="form-control uppercase" name="txtKeterangan[]" id="Keterangan<?= $no; ?>" value="">
                                                        <?php
                                                        } ?>
                                                    </td>
                                                </tr>
                                                <script>
                                                    $(document).ready(function() {
                                                        konversi_angka(<?= $no; ?>);
                                                        $(`#satuanid<?= $no; ?>`).val(<?= $dtl->SatuanID; ?>);
                                                        $(`#kategoriid<?= $no; ?>`).val(<?= $dtl->KategoriCicilanID; ?>);
                                                    });
                                                </script>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="10" class="text-center"><strong>Grand Total</strong></td>
                                                <td>
                                                    <input type="text" class="form-control" name="txtGrandTotal" id="grandTotal" value="<?php foreach ($_getGrandTotal as $gtl) {
                                                                                                                                            echo number_format($gtl->GrandTotal, 0, ",", ".");
                                                                                                                                        } ?>" readonly>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                        <a href="<?= base_url(); ?>PotonganBon/Cicilan?id=4500" class="btn btn-sm btn-default">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    // $(document).ready(function() {
    //     $('.select2-element').select2();
    //     $('.select2-item').select2();
    // });
    $(".uppercase").on("keyup", function() {
        let text = $(this).val()
        let uppercase = text.toUpperCase()
        $(this).val(uppercase)
    });

    function tambah_baris() {
        // alert('hahaha');
        var jum = document.getElementsByClassName('txtBaris');
        var l = jum.length + 1;

        var no = l + 1;
        var num = 1;
        for (var i = 0; i < num; i++) {
            $('table[id="dataTables"] tbody').append(`
                <tr class="txtBaris">
                    <td class="text-center">
                        <type="button" onclick="hapus_baris(this)" class="btn btn-minier btn-danger"><i class="fa fa-trash"></i></button>
                        <input type="hidden" name="txtDetailID[]" value="">
                    </td>
                    <td style="width: 350px;">
                        <div>
                            <select class="form-control select2-item txt" name="txtItem[]" id="item${l}" onchange="ajax_harga(this.id)">
                                <option value="">- Pilih -</option>
                                <?php foreach ($_getListItem as $itm) {
                                    echo "<option value='" . $itm->CicilanID . ", " . $itm->NamaCicilan . "'>" . $itm->NamaCicilan . "</option>";
                                } ?>
                            </select>
                        </div>
                    </td>
                    <td id="idItem${l}">
                        <input type="text" class="form-control" id="harga${l}" value="" onkeyup="konversi_angka(${l});hitung(${l})">
                        <input id="realHarga${l}" type="hidden" name="txtHarga[]">
                    </td>
                    <td>
                        <input type="text" class="form-control" id="dp${l}" value="" onkeyup="konversi_angka(${l});hitung(${l})">
                        <input id="realDp${l}" type="hidden" name="txtDp[]">
                    </td>
                    <td>
                        <input type="number" min="0" class="form-control" name="txtQuantity[]" id="quantity${l}" value="0" onkeyup="hitung(1)">
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
                    <td><input type="date" class="form-control" name="txtMulai[]" id="mulai" value="0" ></td>
                    <td>
                        <select class="form-control" name="txtperiodepotong[]" id="periodepotong${l}" required>
                           
                            <option value="1" selected>1</option>
                            <option value="2">2</option>
                            <option value="3">1 dan 2</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control"  id="total${l}" value="0" readonly="" onkeyup="hitung(${l})">
                        <input id="realTotal${l}" type="hidden" name="txtTotal[]" >
                    </td>
                </tr>
            `);
        }

        // $('.select2-element').select2();
        // $('.select2-item').select2({
        //     tags : true,
        //     createTag: function (params) {
        //         return {
        //             id: params.term,
        //             text: params.term,
        //             newOption: true
        //         }
        //     },
        //     templateResult: function (data) {
        //         var $result = $("<span></span>");

        //         $result.text(data.text);

        //         if (data.newOption) {
        //             $result.append(" <em>(Baru)</em>");
        //         }

        //         return $result;
        //     }
        // });
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
            var jumlah = ((hrg - dp) * quantity) / periode;
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

    //function hapus_item(id){
    //    var dtlid = id;
    //
    //    $.ajax({
    //        type: "POST",
    //        dataType: "html",
    //        url: "<?php //echo base_url('PotonganBon/hapus_item')
                    ?>//"+"/"+dtlid,
    //        success: function(msg){
    //            location.reload();
    //        }
    //    });
    //}

    function viewHapus(id) {
        let id_ = id
        // console.log(id_)
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(id_)
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: {
                        id: id_
                    },
                    url: "<?php echo base_url('PotonganBon/HapusDataPotCicilanDtl') ?>",
                    success: function(msg) {
                        // alert(msg)
                        Swal.fire({
                            title: 'Data Sudah Terhapus!!!',
                            text: "You won't be able to revert this!",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'OK!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })

                        console.log(msg)

                    },
                    error: function() {
                        Swal.fire(
                            'GAGALL!',
                            'Data tidak terhapus!',
                            'error'
                        )
                    }
                });

            }
        })
    }
</script>