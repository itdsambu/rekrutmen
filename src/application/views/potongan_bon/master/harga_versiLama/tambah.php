<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/select2.css" />
<!-- <script src="<?php echo base_url(); ?>assets/js/select2.js"></script> -->
<!-- <?php echo  $this->session->userdata('username'); ?> -->

<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">TAMBAH MASTER HARGA</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <br>
            <div class="col-lg-12">
                <?php if ($this->input->get('msg') == "success") {
                    echo "<div class='alert alert-success'>";
                    echo "<strong>Sukses !!!</strong> Data berhasil di Simpan.";
                    echo "</div>";
                } elseif ($this->input->get('msg') == "failed") {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong>Gagal !!!</strong> Data Sudah Pernah Diregistrasi..!!";
                    echo "</div>";
                } ?>

            </div>
            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PotonganBon/simpan_mst_harga'); ?>">
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Tanggal</label>
                                    <div class="col-sm-4">
                                        <input type="date" name="txtTanggal" class="form-control" value="<?php echo date('Y-m-d') ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Pemborong</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="txtPemborong" id="pemborong" onchange="callAjax()" onload="callAjax()">
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
                                    <label class="col-lg-2 control-label">Sub Pemborong</label>
                                    <div class="col-sm-4" id="tblSub">
                                        <select class="form-control" name="txtSubPemborong" id="subpemborong" onchange="ajax_mstItem()">
                                            <?php if (count($_getDataSub) > 1) {
                                                $selected = '';
                                            } else {
                                                $selected = 'selected';
                                            } ?>
                                            <option value="">- Pilih -</option>
                                            <?php foreach ($_getDataSub as $pbr) {
                                                echo "<option value='" . $pbr->IDSubPemborong . "' " . $selected . ">" . $pbr->NamaSub . "</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Kategori</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="txtKategori" id="kategori" onchange="ajax_kategori()">
                                            <option value="0">- Pilih Kategori -</option>
                                            <?php foreach ($_getMstKategori as $ktg) {
                                                echo "<option value='$ktg->KategoriID'>" . $ktg->NamaKategori . "</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="itemid">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Nama Item</label>
                                        <div class="col-sm-4">
                                            <!-- <select class="form-control" name="txtItem" id="item">
                                                <option value="0">- Pilih Nama Item -</option>
                                                <?php foreach ($_getDataItem as $itm) {
                                                    echo "<option value='$ktg->ItemID'>" . $ktg->NamaItem . "</option>";
                                                } ?>
                                            </select> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label"></label>
                                    <div class="col-sm-4">
                                        <a href="#" class="btn btn-sm btn-round btn-primary" onclick="CariHarga()"><i class="fa fa-search"></i> Cari Data</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive" id="tbllist">

                                </div>
                            </div>
                        </div>
                        <hr>
                        <button class="btn btn-sm btn-success">Simpan</button>
                        <a href="" class="btn btn-sm btn-default">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/select2.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables').dataTable({
            paging: false,
            searching: false,
        });
        callAjax();
        let jmlData = "<?php echo count($_getDataSub); ?>";
        if (jmlData == 1) {

            console.log("jalan langsung");
        }

    });

    function callAjax() {
        let pemborong = $('#pemborong').val();

        console.log(pemborong);

        if (pemborong == '') {

        } else {
            $.ajax({
                type: "GET",
                dataType: "html",
                url: "<?php echo base_url('PotonganBon/subpbr') ?>" + "/" + pemborong,
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

    // Cara Orang Terdahulu kala :D
    // function callAjax() {
    //     var pemborong = $('#pemborong').val();

    //     if (pemborong == '') {

    //     } else {
    //         $.ajax({
    //             type: "GET",
    //             dataType: "html",
    //             url: "<?php echo base_url('PotonganBon/subpbr') ?>" + "/" + pemborong,
    //             success: function(msg) {
    //                 if (msg == '') {
    //                     alert('Tidak ada data');
    //                 } else {
    //                     $("#tblSub").html(msg);
    //                 }
    //             }
    //         });

    //     }
    // }

    function ajax_mstItem() {
        var pbr = $('#pemborong').val();
        var sub = $('#subpemborong').val();

        console.log(pbr);
        console.log(sub);

        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/getMstItemPerSub') ?>" + "/" + pbr + "/" + sub,
            success: function(msg) {
                if (msg == '') {
                    alert('Tidak ada data');
                } else {
                    $("#itemid").html(msg);
                }
            }
        });
    }

    function ajax_kategori() {
        var kategori = $('#kategori').val();
        var pbr = $('#pemborong').val();
        var sub = $('#subpemborong').val();

        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/getMstItemPerKategori') ?>" + "/" + kategori + "/" + pbr + "/" + sub,
            success: function(msg) {
                if (msg == '') {
                    alert('Tidak ada data');
                } else {
                    $("#itemid").html(msg);
                }
            }
        });
    }

    function CariHarga() {
        var pbr = $('#pemborong').val();
        var sub = $('#subpemborong').val();
        var kategori = $('#kategori').val();
        var item = $('#item').val();
        $('#tbllist').html('<p style="text-align:center;"><img src="<?php echo base_url(); ?>assets/images/8REG.gif"></p>');

        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajax_pemborong') ?>" + "/" + pbr + "/" + sub + "/" + kategori + "/" + item,
            success: function(msg) {
                if (msg == '') {
                    alert('Tidak ada data');
                } else {
                    $("#tbllist").html(msg);
                }
            }
        });
    }
</script>