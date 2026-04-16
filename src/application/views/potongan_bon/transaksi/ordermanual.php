<link href="<?php echo base_url(); ?>assets/sweetalert2-11.3.6/dist/sweetalert2.min.css" rel="stylesheet">
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><i class="glyphicon glyphicon-shopping-cart"></i> TRANSAKSI PESANAN</h4>
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
                } elseif ($this->input->get('msg') == "gagal") {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong>Gagal !!!</strong> Data gagal di Proses. Silahkan input ulang";
                    echo "</div>";
                }?>

            </div>
            <?php 
            $tahun = date("Y");
            $bulansekarang = date("m");
            $bulanselanjutnya = date("m") + 1;
            if ($bulansekarang == 12) {
                $bulanselanjutnya = '01';
            }else{
                $bulanselanjutnya = date("m") + 1;
            }
            ?>
            <form class="form-horizontal" id="formSave" role="form" method="POST" action="">
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <center><label class="coba" style="margin-bottom: 30px;">Periode 1 = TRANSAKSI DI TANGGAL 27-<?= $bulansekarang == '01' ?  '12' : $bulansekarang?>-<?= $tahun== date("Y") && $bulansekarang == '01' ?  date("Y") - 1 : date("Y") ?> SAMPAI TGL.13-<?= $bulansekarang=='01' ? $bulansekarang :$bulanselanjutnya?>-<?=$tahun ?> DI POTONG TANGGAL 20 <br>
                                                                                         Periode 2 = TRANSAKSI DI TANGGAL 14-<?= $bulansekarang ."-".$tahun ?> SAMPAI TGL.26-<?= $bulanselanjutnya ."-".$tahun ?> DI POTONG TANGGAL 05</label></center>
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-3 col-xs-3 control-label">Tanggal Transaksi</label>
                                    <div class="col-lg-4 col-sm-4 col-xs-9">
                                        <input type="date" name="txtTanggal" class="form-control" value="<?php echo date('Y-m-d') ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-3 col-xs-3 control-label">Pemborong</label>
                                    <div class="col-lg-4 col-sm-4 col-xs-9">
                                        <select class="form-control" name="txtPemborong" id="pemborong" onchange="CariSub()" required>
                                            <?php if (count($_getDataPemborong) > 1) {
                                                $selected = '';
                                            } else {
                                                $selected = 'selected';
                                            } ?>
                                            <option value="">- Pilih -</option>
                                            <?php foreach ($_getDataPemborong as $pbr) {
                                                echo "<option value='" . $pbr->IDPemborong . "' " . $selected . ">" . $pbr->Pemborong . "</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-3 col-xs-3 control-label">CV Perusahaan</label>
                                    <div class="col-lg-4 col-sm-4 col-xs-9" id="tblSub">
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                <input type="hidden" name="nik" id="nik" placeholder="Input Nik" class="form-control" readonly>
                                    <!-- <label class="col-lg-2 col-sm-3 col-xs-3 control-label">Nofix</label>
                                    <div class="col-lg-4 col-sm-4 col-xs-7">
                                        <input type="text" name="nik" id="nik" placeholder="Input Nik" class="form-control" readonly required>
                                    </div> -->
                                    <div class="col-md-2"></div>
                                    <div class="col-lg-4">
                                        <a href="#myModalCari" data-toggle="modal" id="btnFindTk" class="btn btn-success btn-block"><b>Cari</b> <i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                                <div id="otpid">
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-3 col-xs-3 control-label">Nama Lengkap</label>
                                        <div class="col-lg-4 col-sm-4 col-xs-9">
                                            <input type="text" name="txtNama" class="form-control" readonly required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-3 col-xs-3 control-label">Nik</label>
                                        <div class="col-lg-4 col-sm-4 col-xs-9">
                                            <input type="text" name="txtNik" class="form-control" readonly required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-3 col-xs-3 control-label">Bagian/Dept</label>
                                        <div class="col-lg-4 col-sm-4 col-xs-9">
                                            <input type="text" name="txtDept" class="form-control" readonly required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Sisa Periode Sebelumnya (Rp.)</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="txtSisa" class="form-control" readonly required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12" id="listid"></div>
                        </div>
                        <hr>
                        <a href="#" data-toggle="modal"  class="btn btn-success btn-sm btn_save">Simpan</a>
                        <a href="" class="btn btn-sm btn-default">Kembali</a>
                        <!-- <a href="<?php echo site_url('PotonganBon/TransaksiPotonganBon') ?>" class="btn btn-sm btn-primary">
                            <span>Transaksi belum proses</span>
                            <span class="badge"><?= $_getCount->total ?></span>
                        </a> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalCari" tabindex="-1" role="dialog" aria-labelledby="view" aria-hidden="true">
    <div class="modal-dialog" style="width:97%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">DAFTAR TENAGA KERJA</h4>
            </div>
            <div class="modal-body">
                <div id="lihat_detail" class="well">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-lg-3 col-sm-3 col-xs-3 control-label no-padding-right" for="form-field-1"> NIK / Nama * </label>
                            <div class="col-lg-7 col-sm-7 col-xs-7">
                                <input type="text" class="form-control" name="txtPraID" id="txtPraID" required="" autocomplete="off">
                            </div>
                            <div class="col-lg-2 col-sm-2 col-xs-2">
                                <button type="button" id="btnCari" class="btn btn-success btn-sm col-lg-12 col-sm-12 col-xs-12"> Refresh</button>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <div id="getListPra" class="col-lg-12 col-sm-12 col-xs-12">
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
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#btnCari").click(function() {
        var Nik = $('#txtPraID').val();
        var pemborong = $('#pemborong').val();
        var subpemborong = $('#subpemborong').val();
        // alert(Nik);
        // alert(pemborong);
        if (Nik == '') {
            // alert('hahahaha');
        } else {
            // alert('wkwkwkwk');
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('PotonganBon/cari_tenagakerja') ?>",
                data: {
                    'Nik': Nik,
                    'pemborong': pemborong,
                    'subpemborong': subpemborong,
                },
                success: function(msg) {
                    $('#getListPra').html(msg);
                }
            });
            document.getElementById('btnCari').disabled = false;
        }
    });
</script>
</div>

<div class="modal fade" id="myModalInfo" tabindex="-2" role="dialog" aria-labelledby="view" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Apakah Anda Ingin Melakukan Print Slip Belanja ??</h4>
            </div>
            <div id="lihat_detail">
                <div class="modal-body">
                    <form class="form-horizontal" id="formSave" role="form" method="POST" action="<?php echo base_url('PotonganBon/printSlipBelanja') ?>">
                        <input type="hidden" name="txthdrid" id="hdrid" value="" required>
                        <button type="submit" class="btn btn-sm btn-primary">Ya</button>
                        <a href="" class="btn btn-sm btn-danger">Tidak</a>
                    </form>
                </div>
                <hr>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(".btn_save").click(function(e) { // passing down the event
                  Swal.fire({
                    title: 'Apakah anda yakin ingin menyimpan transaksi ini??',
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        
                        $.ajax({
                                url: "<?php echo base_url(); ?>PotonganBon/simpan_trn_manual_potongan_pemborong",
                                type: 'POST',
                                // dataType : 'JSON',
                                data: $('#formSave input, select').serialize(),
                                success: function(pesan) {
                                    console.log(pesan);
                                   
                                    $('#hdrid').val(pesan.trim());
                                   
                                            Swal.fire({
                                                        title: 'Berhasil Menyimpan data!',
                                                        text: "",
                                                        icon: 'success',
                                                        showCancelButton: false,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'OK!!'
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                               
                                                                jQuery('#myModalInfo').modal('show').on('hide.bs.modal', function(e){
                                                                e.preventDefault();
                                                                });
                                                            
                                                            // $('#myModalInfo').modal("show");
                                                        }
                                                        })
                                },
                                error: function() {
                                    alert("Fail")
                                }
                            });
                            e.preventDefault(); // could also use: return false;
                    }
                    })
           
        });
    </script>
</div>
<script type="text/javascript">
    function tambah_baris() {
        // alert('hahaha');
        let jum = document.getElementsByClassName('txt');
        let l = jum.length + 1;

        let no = l + 1;
        let num = 1;
        for (let i = 0; i < num; i++) {
            $(`table[id="dataTables"]`).append(`
                <tbody id="dataTable1">
                    <tr>
                        <td class="text-center">
                            <a id="hapus ${l}" class="btn btn-minier btn-danger" onclick="hapus_baris(this)"><i class="fa fa-trash"></i></a>
                            <input type="hidden" name="txtDetailID[]" id="detailid" value="">
                        </td>
                        <td class="text-center">
                            <select id="item ${l}" name="txtItem[]" class="form-control  txt" onchange="ajax_harga(this.id)"></select>
                        </td>
                        <td class="text-center" id="idItem ${l}" >
                           <input type="text" class="form-control" id="harga ${l}" name="txtHarga[]" value="0" onkeydown="return numbersonly(this, event);" onkeyup="tandaPemisahTitik(this);" readonly="">
                           <input type="hidden" class="form-control" name="txtHargaid[]" id="hargaid ${l}" value="" readonly="">
                        </td>
                        <td class="text-center">
                            <input type="text" name="txtQuantity[]" id="quantity ${l}" class="form-control" value="0" onkeyup="hitung( ${l})">
                        </td>
                        <td class="text-center">
                            <input type="text" name="txtSatuan[]" id="satuan ${l}" class="form-control" readonly="">
                            <input type="hidden" name="txtSatuanid[]" id="satuanid ${l}" class="form-control" readonly="">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="txtKategori[]" id="kategori ${l}" readonly="">
                            <input type="hidden" class="form-control" name="txtKategoriid[]" id="kategoriid ${l}" readonly="">
                        </td>
                        <td class="text-center">
                            <input type="text" name="txtTotal[]" id="total ${l}" value="0" class="form-control" onkeyup="hitung( ${l})" readonly=""/>
                        </td>
                    </tr>
                </tbody>
            `);
        }

        $('#item1 option').clone().appendTo('#item' + l);
    }

    function kelapKelip() {
    $('.coba').fadeOut(); //fungsi mehilangkan
    $('.coba').fadeIn(); //fungsi munculkan
    }
    setInterval(kelapKelip, 2000); //set waktu berkala 1 detik, jadi setiap 1 detik sekali akan menjalankan function kelapKelip dimana dalam function tersebut terdapat fungsi fadeOut dan fadeIn


    function hitung(id) {
        // alert(id);
        let jmlBaris = document.getElementsByClassName('txt').length;
        let hrg = $('#harga' + id).val();
        let harga = hrg.replace(".", "");
        let quantity = $('#quantity' + id).val();

        // alert(hrg);

        jumlah = harga * quantity;
        // alert(jumlah);
        document.getElementById('total' + id).value = jumlah;

        let grand = 0;
        for (let i = 1; i <= jmlBaris; i++) {
            grand += parseInt($('#total' + i).val());

        }

        grandTotal = Math.ceil(grand);

        document.getElementById("grandTotal").value = tandaPemisahTitik(grandTotal);
    }

    function hapus_baris(ip) {
        let tr = ip.parentNode.parentNode;
        tr.parentNode.removeChild(tr);
        location.reload();
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
        let _minus = false;
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
        let idBaris = id.substr(4);
        let jmlBaris = document.getElementsByClassName('txt').length;
        let item = $('#' + id).val();
        let pbr = $('#pemborong1').val();

        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajax_satuan') ?>" + "/" + item + "/" + pbr,
            success: function(msg) {
                if (msg == '') {
                    alert('Tidak ada data');
                } else {
                    $("#satuan" + idBaris).val(msg);
                }
            }
        });

        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajax_satuanid') ?>" + "/" + item + "/" + pbr,
            success: function(msg) {
                if (msg == '') {
                    alert('Tidak ada data');
                } else {
                    $("#satuanid" + idBaris).val(msg);
                }
            }
        });

        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajax_kategori') ?>" + "/" + item + "/" + pbr,
            success: function(msg) {
                if (msg == '') {
                    alert('Tidak ada data');
                } else {
                    $("#kategori" + idBaris).val(msg);
                }
            }
        });
        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajax_kategoriid') ?>" + "/" + item + "/" + pbr,
            success: function(msg) {
                if (msg == '') {
                    alert('Tidak ada data');
                } else {
                    $("#kategoriid" + idBaris).val(msg);
                }
            }
        });
    }

    function hapus_item(id) {
        let dtlid = id;

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
    $(document).ready(function() {
        $('#dataTables').dataTable();
        let jmlData = "<?php echo count($_getDataPemborong); ?>";
        if (jmlData == 1) {

            console.log("jalan");
        }
    });

    function CariSub() {
        let pemborong = $('#pemborong').val();

        if (pemborong == '') {

        } else {
            $.ajax({
                type: "GET",
                dataType: "html",
                url: "<?php echo base_url('PotonganBon/ajax_subPemborong') ?>" + "/" + pemborong,
                success: function(msg) {
                    if (msg == '') {
                        alert('Tidak ada data');
                    } else {
                        $("#tblSub").html(msg);
                    }
                }
            });
        }
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables').dataTable();
        CariSub();
        let jmlData = "<?php echo count($_getDataSub); ?>";
        if (jmlData == 1) {
            console.log("jalan langsung");
        }

        validasiFormSave();
    });

    function get_item_pemborong() {

        let sub = $('#subpemborong').val();

        //alert(sub);
        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajax_list_item') ?>" + "/" + sub,
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
    function send_data() {
        let nik = $('#nik').val();
        let subpemborong = $('#subpemborong').val();

        if (nik == 0) {
            alert('Nik Harap Diisi..!!');
        } else {
            $.ajax({
                type: "GET",
                dataType: "html",
                url: "<?php echo base_url('PotonganBon/send_data') ?>" + "/" + nik + "/" + pemborong + "/" + subpemborong,
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
        let pemborong = $('#subpemborong').val();
        let subpemborong = $('#subpemborong').val();

        if (nik == 0) {
            alert('Nik Harap Diisi..!!');
        } else {
            $.ajax({
                type: "GET",
                dataType: "html",
                url: "<?php echo base_url('PotonganBon/send_data') ?>" + "/" + nik + "/" + pemborong + "/" + subpemborong,
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

    function validasiFormSave() {
        $('#formSave').submit(function(event) {
            let statusQuantity = 0,
                statusHarga = 0;

            let rowQuantity = 1;
            $('.classQuantity').each(function() {
                if ($(this).val() <= 0) {
                    Swal.fire(`Quantity Tidak Sesuai`, `Inputan Quantity baris ke ${rowQuantity} tidak boleh dibawah 0 (Nol) atau Nol!`, 'warning');
                    statusQuantity = 1;
                }
                rowQuantity = parseInt(rowQuantity) + 1;
            });

            let rowHarga = 1;
            $('.classHarga').each(function() {
                if ($(this).val() <= 0) {
                    Swal.fire(`Harga Tidak Sesuai`, `Inputan Harga baris ke ${rowHarga} tidak boleh dibawah 0 (Nol) atau Nol!`, 'warning');
                    statusHarga = 1;
                }
                rowHarga = parseInt(rowHarga) + 1;
            });

            if (statusQuantity == 1 || statusHarga == 1) {
                event.preventDefault();
            }
        });
    }
</script>

<script type="text/javascript">

</script>