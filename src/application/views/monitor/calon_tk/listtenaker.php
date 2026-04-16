<style>
    #loading {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 20px;
        color: #000;
        z-index: 9999;
    }

    .spinner-overlay {
        display: none;
        position: absolute;
        top: 80%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(255, 255, 255, 0.8);
        border-radius: 10px;
        padding: 20px;
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        border: 12px solid #f3f3f3;
        /* Light grey */
        border-top: 12px solid #3498db;
        /* Blue */
        border-radius: 50%;
        width: 80px;
        height: 80px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<!-- <link rel="stylesheet" href="<?= base_url() ?>assets/css/load-all.min.css"> -->

<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">List Calon Tenaga Kerja</h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
                <div class="widget-toolbar no-border">
                    <span id="moExcel">
                        <button class="btn btn-minier btn-success" id="btnModalExcel">
                            <i class="ace-icon fa fa-file-excel-o"></i> Export to Excel
                        </button>
                    </span>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <!-- <div class="col-xs-12" style="padding-bottom: 15px;">
                            <div class="alert alert-info">Modul ini masih dalam tahap uji coba, untuk menanggulangi terlalu lama (lelet) load data..</div>
                        </div> -->
                        <div class="col-xs-12">
                            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('monitor/testtest'); ?>">
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right">Filter Data</label>
                                        <div class="col-sm-8">
                                            <select name="selDataFilter" id="inputDataFilter" class="form-control input-sm">
                                                <option value="0" <?php if ($_selected == 0) {
                                                                        echo 'selected';
                                                                    } ?>>Semua Data</option>
                                                <option value="1" <?php if ($_selected == 1) {
                                                                        echo 'selected';
                                                                    } ?>>Dalam Proses</option>
                                                <option value="2" <?php if ($_selected == 2) {
                                                                        echo 'selected';
                                                                    } ?>>Telah Close</option>
                                                <option value="3" <?php if ($_selected == 3) {
                                                                        echo 'selected';
                                                                    } ?>>Telah Posting</option>
                                            </select>
                                        </div>
                                        <!-- <script>
                                            $('#inputDataFilter').change(function() {
                                                let val = this.value;
                                                console.log(val);
                                                window.location = '<?php echo site_url(); ?>monitor/monitor/testtest/' + val;
                                            });
                                        </script> -->
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right">No. Reg</label>
                                        <div class="col-sm-8">
                                            <input name="txtNoreg" id="inputNoreg" type="number" class="form-control input-sm" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right">Nama</label>
                                        <div class="col-sm-8">
                                            <input name="txtNama" id="inputNama" type="text" class="form-control input-sm" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right">Pemborong</label>
                                        <div class="col-sm-8">
                                            <input name="txtPemborong" id="inputPemborong" type="text" class="form-control input-sm" autocomplete="off" />
                                            <ul class="dropdown-menu txtpemborong" style="margin-left:15px;margin-right:0px;" role="menu" aria-labelledby="dropdownMenu" id="DropdownPemborong"></ul>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                $("#inputPemborong").keyup(function() {
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "<?php echo base_url(); ?>autocomplete/getPemborong",
                                                        data: {
                                                            keyword: $("#inputPemborong").val()
                                                        },
                                                        dataType: "json",
                                                        success: function(o) {
                                                            o.length > 0 ? ($("#DropdownPemborong").empty(), $("#inputPemborong").attr("data-toggle", "dropdown"), $("#DropdownPemborong").dropdown("toggle")) : 0 == o.length && $("#inputPemborong").attr("data-toggle", ""), $.each(o, function(n, e) {
                                                                o.length >= 0 && $("#DropdownPemborong").append('<li role="presentation" ><a role="menuitem dropdownnameli" class="dropdownlivalue">' + e.Perusahaan + "</a></li>")
                                                            })
                                                        }
                                                    })
                                                }), $("ul.txtpemborong").on("click", "li a", function() {
                                                    $("#inputPemborong").val($(this).text())
                                                })
                                            });
                                        </script>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right">Pendidikan</label>
                                        <div class="col-sm-8">
                                            <input name="txtPendidikan" id="inputPendidikan" type="text" class="form-control input-sm" autocomplete="off" />
                                            <ul class="dropdown-menu txtpendidikan" style="margin-left:15px;margin-right:0px;" role="menu" aria-labelledby="dropdownMenu" id="DropdownPendidikan"></ul>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                $("#inputPendidikan").keyup(function() {
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "<?php echo base_url(); ?>autocomplete/getPendidikan",
                                                        data: {
                                                            keyword: $("#inputPendidikan").val()
                                                        },
                                                        dataType: "json",
                                                        success: function(n) {
                                                            n.length > 0 ? ($("#DropdownPendidikan").empty(), $("#inputPendidikan").attr("data-toggle", "dropdown"), $("#DropdownPendidikan").dropdown("toggle")) : 0 == n.length && $("#inputPemborong").attr("data-toggle", ""), $.each(n, function(e, d) {
                                                                n.length >= 0 && $("#DropdownPendidikan").append('<li role="presentation" ><a role="menuitem dropdownnameli" class="dropdownlivalue">' + d.Pendidikan + "</a></li>")
                                                            })
                                                        }
                                                    })
                                                }), $("ul.txtpendidikan").on("click", "li a", function() {
                                                    $("#inputPendidikan").val($(this).text())
                                                })
                                            });
                                        </script>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right">Type</label>
                                        <div class="col-sm-8">
                                            <select name="tipe" id="tipe" class="form-control input-sm">
                                                <option value="">-Pilih-</option>
                                                <option value="K" <?php if ($_tipe == "K") {
                                                                        echo 'selected';
                                                                    } ?>>Karyawan</option>
                                                <option value="TK" <?php if ($_tipe == "TK") {
                                                                        echo 'selected';
                                                                    } ?>>Tenaga Kerja</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right">Jenis Kelamin</label>
                                        <div class="col-sm-8">
                                            <!--<input name="txtJekel" id="inputJekel" type="text" class="col-xs-12" placeholder="Laki-laki / Perempuan"/>-->
                                            <select class="form-control input-sm" name="txtJekel" id="selJekel">
                                                <option value=""> -- Pilih</option>
                                                <option>Laki-laki</option>
                                                <option>Perempuan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right">Jurusan</label>
                                        <div class="col-sm-8">
                                            <input name="txtJurusan" id="inputJurusan" type="text" class="form-control input-sm" autocomplete="off" />
                                            <ul class="dropdown-menu txtjurusan" style="margin-left:15px; margin-right:0px; max-height: 300px; overflow-y: scroll;" role="menu" aria-labelledby="dropdownMenu" id="DropdownJurusan"></ul>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                $("#inputJurusan").keyup(function() {
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "<?php echo base_url(); ?>autocomplete/getJurusan",
                                                        data: {
                                                            keyword: $("#inputJurusan").val()
                                                        },
                                                        dataType: "json",
                                                        success: function(n) {
                                                            n.length > 0 ? ($("#DropdownJurusan").empty(), $("#inputJurusan").attr("data-toggle", "dropdown"), $("#DropdownJurusan").dropdown("toggle")) : 0 == n.length && $("#inputJurusan").attr("data-toggle", ""), $.each(n, function(u, t) {
                                                                n.length >= 0 && $("#DropdownJurusan").append('<li role="presentation" ><a role="menuitem dropdownnameli" class="dropdownlivalue">' + t.Jurusan + "</a></li>")
                                                            })
                                                        }
                                                    })
                                                }), $("ul.txtjurusan").on("click", "li a", function() {
                                                    $("#inputJurusan").val($(this).text())
                                                })
                                            });
                                        </script>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right">No. KTP</label>
                                        <div class="col-sm-8">
                                            <input name="txtNoKtp" id="inputKtp" type="number" class="form-control input-sm" autocomplete="off" />
                                        </div>
                                    </div>


                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right">Status Personal</label>
                                        <div class="col-sm-8">
                                            <!--<input name="txtStatus" id="inputStatus" type="text" class="col-xs-12" />-->
                                            <select class="form-control input-sm" name="txtStatus" id="selStatus">
                                                <option value=""> -- Pilih</option>
                                                <option>Bujang</option>
                                                <option>Gadis</option>
                                                <option>Duda</option>
                                                <option>Janda</option>
                                                <option>Nikah</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right">Tahun Lahir</label>
                                        <div class="col-sm-8">
                                            <input name="txtThnLahir" id="inputThnLahir" type="text" class="form-control input-sm" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-8 right">
                                            <input name="btnCari" id="inputcari" type="submit" value="Refresh" class="btn btn-mini btn-block" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div id="data" class="col-xs-12 table-responsive">

                            <!-- <div id="loading" style="display: none;">Loading...</div> -->
                            <!-- <div id="loading" style="display: none;">
                                <i class="fa fa-spinner fa-spin" style="font-size: 40px; color: #000;"></i>
                            </div> -->
                            <div id="loading" class="spinner-overlay">
                                <div class="spinner"></div>
                            </div>
                            <table id="myTable" class="toExcel table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Pemborong</th>
                                        <th>Sub Pemborong</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>No KTP</th>
                                        <th>Screened PSN</th>
                                        <th>
                                            <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> <?php echo ($_selected == 2 ? 'Closed By' : 'Registered By'); ?>
                                        </th>
                                        <th>Interviewed</th>
                                        <?php if ($this->session->userdata('dept') == 'ITD' || $this->session->userdata('dept') == 'HRD') { ?>
                                            <th>Salmonella Carrier</th>
                                        <?php } ?>
                                        <th>Riwayat Kerja</th>
                                        <?php if ($this->session->userdata('userid') != 'PTADM') { ?>
                                            <th>Opsi</th>
                                        <?php } ?>
                                        <?php if ($this->session->userdata('dept') == 'ITD' || $this->session->userdata('dept') == 'HRD') { ?>
                                            <th>Keterangan</th>
                                        <?php } ?>
                                        <?php if ($this->session->userdata('userid') == 'PTADM' || $this->session->userdata('dept') == 'ITD') { ?>
                                            <th>Detail</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Export to Excel -->
<div class="modal fade" id="modalToExcel" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titleExcel"> Export to Excel</h4>
            </div>
            <div class="modal-body">
                <div class="center">
                    <form class="form-horizontal" id="formExportExcel" action="<?php echo site_url('toExcel/downloadExcel'); ?>" method="POST">
                        <div class="form-group">
                            <label class="col-sm-5 control-label right" for="inputTahun">Pilih Tahun</label>
                            <select name="selTahun" id="inputTahun" class="col-md-3">
                                <?php
                                $tgl    = date('Y-m');
                                $thn    = substr($tgl, 0, 4);
                                $bln    = substr($tgl, 5, 2);
                                for ($i = 2014; $i <= $thn; $i++) :
                                    if ($i == $thn) {
                                        echo '<option values ="' . $i . '" selected>' . $i . '</option>';
                                    } else {
                                        echo '<option values ="' . $i . '">' . $i . '</option>';
                                    }
                                endfor;
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label right" for="inputBulan">Pilih Bulan</label>
                            <select name="selBulan" id="inputBulan" class="col-md-3">
                                <?php
                                $bulanAbbr  = array('Pilih Bulan', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
                                for ($i = 0; $i <= 12; $i++) : ?>
                                    <?php if ($i == $bln) : ?>
                                        <option value="<?php echo $i; ?>" selected><?php echo $bulanAbbr[$i]; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $i; ?>"><?php echo $bulanAbbr[$i]; ?></option>
                                    <?php endif; ?>
                                <?php
                                endfor;
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label right" for="inputDataExport">Data export</label>
                            <select name="selDataExport" id="inputDataExport" class="col-md-3">
                                <option value="all">Semua Tenaker</option>
                                <option value="post">Tenaker telah Posting</option>
                            </select>
                        </div>
                        <div class="center">
                            <button type="submit" class="btn btn-mini btn-success">
                                <i class="ace-icon fa fa-download"></i> Download
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal View Report Interview -->
<div class="modal fade" id="viewModalInterview" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Informasi Record Wawancara</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="detailInterview" class="well">
                    <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal View Berkas Tenaker -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titleModal"></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="detail" class="well">
                    <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal View Informasi Tenaker -->
<div class="modal fade" id="viewModalInfo" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Informasi Data Karyawan</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="detailInfo" class="well">
                    <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal View Screening-->
<div class="modal fade" id="viewModalWawancara" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Hasil Interview </h3>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="wawancaraHarian" class="well">
                    <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/jqv/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/moment.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/datetime-moment.js"></script>

<script>
    $(document).ready(function() {
        // $.fn.dataTable.moment('DD/MM/YYYY');
        // $('#myTable').DataTable({
        //     "aaSorting": [
        //         [0, "desc"]
        //     ]
        // });
        $("#myTable").tablesorter();
        $('[data-rel=tooltip]').tooltip();

        $("#btnModalExcel").click(function() {
            $("#modalToExcel").modal("show");
        });

        $("#myTable").on("click", ".detailInterview", function() {
            let e = $(this).closest("tr").find('#data-id').data("id");
            console.log(e);
            $.ajax({
                url: "<?php echo site_url('wawancaraTujuan/cekRecordInterview'); ?>",
                type: "POST",
                data: "kode=" + e,
                datatype: "json",
                cache: !1,
                success: function(e) {
                    $("#detailInterview").html(e)
                }
            }), $("#viewModalInterview").modal("show")
        });

        $("#myTable").on("click", ".detail", function() {
            let a = $(this).closest("tr").find('#data-id').data("id"),
                t = $(this).data("name"),
                e = $(this).data("tk");
            document.getElementById("titleModal").innerHTML = "Berkas " + t + " dari saudara, <strong class='green'>" + e + " </strong>", $.ajax({
                url: "<?php echo site_url('monitor/viewDocs'); ?>",
                type: "POST",
                data: "kode=" + a + "&nama=" + t,
                datatype: "json",
                cache: !1,
                success: function(a) {
                    // console.log(a);
                    $("#detail").html(a)
                }
            }), $("#viewModal").modal("show")
        });

        $("#myTable").on("click", ".detailInfo", function() {
            let a = $(this).closest("tr").find('#data-id').data("id");
            console.log('id: ', a);


            $.ajax({
                url: "<?php echo site_url('uploadBerkas/detailtk'); ?>",
                type: "POST",
                data: "kode=" + a,
                datatype: "json",
                cache: !1,
                success: function(a) {
                    $("#detailInfo").html(a)
                }
            }), $("#viewModalInfo").modal("show")
        });

        $("#myTable").on("click", ".riwayat_kerja", function() {
            let nofix = $(this).data("nofix");
            let ktp = $(this).data("ktp");

            $.ajax({
                url: "<?php echo site_url('monitor/riwayat_kerja'); ?>",
                type: "POST",
                data: {
                    nofix,
                    ktp
                },
                datatype: "json",
                cache: !1,
                success: function(data) {

                    // parsejson = JSON.parse(data);
                    if (data) {
                        $("#detailInfo").html(data)
                        $("#viewModalInfo").modal("show")
                    }
                    if (!data) {
                        $("#detailInfo").html(element())
                        $("#viewModalInfo").modal("show")
                    }


                }
            })
        });

        function element() {
            var html = `<div class="widget-body">
                            <div class="widget-main padding-24">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-xs-12 label label-lg label-info arrowed-in arrowed-right">
                                                <b>Informasi Riwayat Kerja di Sambu</b>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center" align="center">
                                            <br>
                                            <strong>Tidak Ada Data !!!</strong>
                                        </div>
                                    </div><!-- /.col -->
                                </div><!-- /.row -->

                            </div>
                        </div>`

            return html
        }
    });


    var urlSaveKeterangan = '<?= base_url() ?>Monitor/updateKeterangan';


    $(document).ready(function() {
        $(document).on('click', '.simpan', function(e) {
            var keterangan = $(this).closest('tr').find('.keterangan').val()
            var headerID = $(this).closest('tr').find('#data-id').val()
            console.log(headerID);
            $.ajax({
                type: "POST",
                url: urlSaveKeterangan,
                dataType: 'json',
                data: {
                    headerID,
                    keterangan
                },
                success: function(data) {
                    console.log(data);
                    Swal.fire(
                        data.msg,
                        'Data ' + data.msg + ' disimpan!',
                        data.type
                    )
                    $("#myTable").DataTable().ajax.reload();
                }
            });
        })

        // $('.simpan').click(function(event) {
        //     var keterangan = $(this).closest('tr').find('.keterangan').val()
        //     var headerID = $(this).closest('tr').find('.headerid').text()
        //     console.log(headerID);
        //     $.ajax({
        //         type: "POST",
        //         url: urlSaveKeterangan,
        //         dataType: 'json',
        //         data: {
        //             headerID,
        //             keterangan
        //         },
        //         success: function(data) {
        //             console.log(data);
        //             Swal.fire(
        //                 data.msg,
        //                 'Data ' + data.msg + ' disimpan!',
        //                 data.type
        //             )
        //             $("#myTable").DataTable().ajax.reload();
        //         }
        //     });

        // });

        console.log(base_url + "monitor/showTenakerNew");



    });

    const site_url = '<?= site_url() ?>';
    const base_url = '<?= base_url() ?>';
    const tes = 'portal.psg.co.id/rekrutmen/'

    $("#myTable").DataTable({
        processing: false,
        responsive: true,
        order: [],
        serverSide: true,
        // ordering: false // Menonaktifkan pengurutan
        ajax: {
            url: base_url + "monitor/showTenakerNew",
            type: "POST",
            data: function(d) {
                console.log(d);
                d.selDataFilter = $('#inputDataFilter').val();
                d.pemborong = $('#inputPemborong').val();
                d.pendidikan = $('#inputPendidikan').val();
                d.tipePekerja = $('#tipe').val();
                d.noreg = $('#inputNoreg').val();
                d.gender = $('#selJekel').val();
                d.jurusan = $('#inputJurusan').val();
                d.nama = $('#inputNama').val();
                d.statusPersonal = $('#selStatus').val();
                d.tglLahir = $('#inputThnLahir').val();
                d.inputKtp = $('#inputKtp').val();

            },
            beforeSend: function() {
                $('#loading').show(); // Tampilkan loading spinner sebelum request
            },
            complete: function() {
                $('#loading').hide(); // Sembunyikan loading spinner setelah request selesai                
            }

        },
        orderMulti: false, // Hanya menyortir data di halaman saat ini
        language: {
            // url: base_url + 'assets/stexo/plugins/datatables/language/id.json',
            searchPlaceholder: "Cari..."
        },
        lengthMenu: [5, 10, 25, 50, 100],
        // Mengatur tampilan default menjadi 10
        pageLength: 10,
        columnDefs: [{
                type: 'date-eu',
                targets: 4
            } // Mengatur kolom indeks ke-4 (indeks dimulai dari 0) sebagai tipe data tanggal
        ]
    });


    // Debugging: Log data yang dimuat
    $('#myTable').DataTable().on('xhr.dt', function(e, settings, json, xhr) {
        console.log('test :', json);
    });


    // $(document).on('change', '#inputPemborong', '')
    $('#inputcari').on('click', function(e) {
        e.preventDefault()
        $("#myTable").DataTable().ajax.reload();
    })

    $(document).on('click', '.hasil-interview', function() {
        var id = $(this).closest('tr').find('#data-id').val()
        $.ajax({
            url: "<?php echo site_url('monitor/hasilInterview'); ?>",
            type: "POST",
            data: "kode=" + id,
            datatype: "json",
            cache: false,
            success: function(msg) {
                $("#wawancaraHarian").html(msg);
            }
        });
        $("#viewModalWawancara").modal("show");
    })
</script>