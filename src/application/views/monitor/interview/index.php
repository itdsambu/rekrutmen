<?php
/*
 * Author : Ismo___
 */
?>
<script type="text/javascript" src="<?= base_url(); ?>assets/toExcel/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/toExcel/jquery.battatech.excelexport.js"></script>
<div class="page-header">
    <h1>
        MONITOR
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            List Interview
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-ms-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">List Interview </h4>
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
                        <div class="col-xs-12">
                            <form class="form-horizontal" role="form" method="POST" action="<?= base_url('interview/indexGet'); ?>">
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right">Filter Data</label>
                                        <div class="col-sm-6">
                                            <select name="selDataFilter" id="inputDataFilter" class="form-control input-sm">
                                                <option value="0" <?php if ($_selected == 0) {
                                                                        echo 'selected';
                                                                    } ?>>Semua</option>
                                                <option value="1" <?php if ($_selected == 1) {
                                                                        echo 'selected';
                                                                    } ?>>Lulus</option>
                                                <option value="2" <?php if ($_selected == 2) {
                                                                        echo 'selected';
                                                                    } ?>>Gagal</option>
                                            </select>
                                        </div>
                                        <script>
                                            $('#inputDataFilter').change(function() {
                                                var val = this.value;
                                                window.location = '<?= site_url(); ?>interview/index/' + val;
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label no-padding-right col-md-3">No. Reg</label>
                                        <div class="col-md-6">
                                            <input name="txtRegno" id="inputRegno" type="text" class="form-control input-sm" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label no-padding-right col-md-3">Nama</label>
                                        <div class="col-md-6">
                                            <input name="txtNama" id="inputNama" type="text" class="form-control input-sm" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label no-padding-right col-md-3">Departemen</label>
                                        <div class="col-md-6">
                                            <input name="txtDept" id="inputDept" type="text" class="form-control input-sm" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label no-padding-right col-sm-3">Tanggal</label>
                                        <div class="col-sm-6">
                                            <div class="input-daterange input-group">
                                                <input type="text" class="input-sm form-control datepick" name="txtTangal" id="inputTanggal" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-4 no-padding-left">
                                            <input name="btnCari" id="inputcari" type="submit" value="Refresh" class="btn btn-mini btn-block" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="data" class="col-xs-12 table-responsive">
                            <table id="myTable" class="toExcel table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>CV Nama</th>
                                        <th>Pemborong</th>
                                        <th>Departemen</th>
                                        <th>Jabatan</th>
                                        <th>Sub Jabatan</th>
                                        <th>Bagian</th>
                                        <th>Shift</th>
                                        <th>Hasil Wawancara</th>
                                        <th>Tanggal Interview</th>
                                        <th>Registered By</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($_selectWhere as $r) { ?>
                                        <tr class="info" data-id="<?= $r->HeaderID; ?>">
                                            <td><?= $r->HeaderID; ?></td>
                                            <td><?= $r->Nama; ?></td>
                                            <td><?= $r->CVNama; ?></td>
                                            <td><?= $r->Pemborong; ?></td>
                                            <td><?= $r->Departemen; ?></td>
                                            <td><?= $r->JabatanName; ?></td>
                                            <td><?= $r->SubJabatanName; ?></td>
                                            <td><?= $r->Transaksi; ?></td>
                                            <td><?= $r->Shift == 'Z' ? "Non Shift" : $r->Shift; ?></td>
                                            <td><?php if ($r->HasilWawancara == 0) {
                                                    echo '<span class="label label-sm label-danger">Gagal</span>';
                                                } else {
                                                    echo '<span class="label label-sm label-success">Lulus</span>';
                                                } ?></td>
                                            <td><?= date('Y-m-d', strtotime($r->Tanggal)) ?></td>
                                            <td><?= date('Y-m-d', strtotime($r->CreatedDate)) ?><br><small><?= $r->CreatedBy; ?></small></td>
                                            <?php if ($r->HasilWawancara == 1) { ?>
                                                <td class="center">
                                                    <div class="btn-group">
                                                        <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle">
                                                            Print
                                                            <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-primary">
                                                            <li>
                                                                <a href="<?= site_url('Interview/viewBNI/' . $r->HeaderID) ?>" target="_blank" class="print"><small>Surat Penyataan BNI</small></a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= site_url('Interview/SPTP/' . $r->HeaderID) ?>" target="_blank" class="print"><small>SPTP</small></a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= site_url('Interview/Kontrak/' . $r->HeaderID) ?>" target="_blank" class="print"><small>Kontrak</small></a>
                                                            </li>
                                                            <?php if ($r->Sts_ttd == NULL) { ?>
                                                                <li>
                                                                    <a href="<?= site_url('Interview/ttsurat/' . $r->Nofix); ?>" target="_blank" class="btn btn-minier btn-round btn-danger btn-sm"> Tanda tangan</a>
                                                                </li>
                                                            <?php } else { ?>

                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </td>
                                            <?php } else { ?>
                                                <td></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td colspan="11" class="center"><?= $_pagination; ?></td>
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
                    <form class="form-horizontal" id="formExportExcel" action="<?= site_url('interview/downloadInterview'); ?>" method="POST">
                        <div class="form-group">
                            <label class="col-sm-5 control-label right" for="inputTahun">Pilih Tanggal</label>
                            <div class="col-sm-6">
                                <div class="input-daterange input-group">
                                    <input type="text" class="input-sm form-control datepick" name="dttanggal" id="inputtanggal" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label right" for="inputDataExport">Data export</label>
                            <select name="selDataExport" id="inputDataExport" class="col-md-3">
                                <option value="all">Semua</option>
                                <option value="lulus">Lulus</option>
                                <option value="gagal">Gagal</option>
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
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/datepicker.css" />

<script src="<?= base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?= base_url(); ?>assets/js/date-time/bootstrap-timepicker.js"></script>
<script src="<?= base_url(); ?>assets/js/date-time/moment.js"></script>

<script type="text/javascript">
    jQuery(function($) {
        $('.datepick').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
    });
</script>
<script type="text/javascript" src="<?= base_url(); ?>assets/jqv/jquery.tablesorter.min.js"></script>
<script>
    $(document).ready(function() {
        $("#myTable").tablesorter();
        $('[data-rel=tooltip]').tooltip();

        $("#btnModalExcel").click(function() {
            $("#modalToExcel").modal("show");
        });
    });
</script>