<?php
/* 
 * Author : Tengku
 */
?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/toExcel/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/toExcel/jquery.battatech.excelexport.js"></script>
<div class="page-header">
    <h1>
        MONITOR
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Status Progress
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <!-- Design Disini -->
        <div class="row">
            <div class="col-xs-12">
                <div class="widget-box">
                    <div class="widget-header">
                        <div class="col-md-4">
                            <h4 class="widget-title">List Tenaga Kerja </h4>
                        </div>

                        <?php if ($idpemborong > 0) { ?>

                            <div class="col-md-4">
                                <form class="form-horizontal" style="margin-top: 3px;" id="form_cari_data" role="form" method="POST" action="<?php echo base_url('monitor/viewListByPBR'); ?>">

                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-6">
                                            <select class="form-control on_cari_data" name="selTenaker" id="selTenaker">
                                                <option value="all" <?= $selTenaker == 'all' ? 'selected' : '' ?>>All (Semua)</option>
                                                <option value="proses" <?= $selTenaker == 'proses' ? 'selected' : '' ?>>Proses</option>
                                                <option value="belum_bisa_proses" <?= $selTenaker == 'belum_bisa_proses' ? 'selected' : '' ?>>Belum bisa proses</option>
                                                <option value="interview" <?= $selTenaker == 'interview' ? 'selected' : '' ?>>Interview</option>
                                                <option value="mcu" <?= $selTenaker == 'mcu' ? 'selected' : '' ?>>MCU</option>
                                                <option value="blacklist" <?= $selTenaker == 'blacklist' ? 'selected' : '' ?>><?= $idpemborong > 0 ? 'Tidak Lulus Screening' : 'Blacklist' ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php if ($selTenaker == 'proses_all' || $selTenaker == 'all') { ?>

                                    <?php } else { ?>
                                        <div class="col-sm-4">
                                            <h4>Tanggal</h4>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="input-daterange input-group">
                                                <input type="text" class="input-sm form-control datepick tanggal" id="tanggal" name="tanggal" value="<?= date('d-m-Y', strtotime($tanggal)) ?>" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-3">
                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-8 right">
                                                    <input type="submit" name="btnCari" id="inputCari" value="Refresh" class="btn btn-mini btn-block btn-round btn-info" />
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                                </div>
                                <div class="widget-toolbar no-border">
                                    <button class="btn btn-minier btn-success" id="btnExport">
                                        <i class="ace-icon fa fa-file-excel-o bigger-120"></i> Export to Excel
                                    </button>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-5">
                                <form class="form-horizontal" style="margin-top: 3px;" id="form_cari_data" role="form" method="POST" action="<?php echo base_url('monitor/viewListByPBR'); ?>">
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-6">
                                            <select class="form-control on_cari_data" name="selTenaker" id="selTenaker">
                                                <option value="all" <?= $selTenaker == 'all' ? 'selected' : '' ?>>All (Semua)</option>
                                                <option value="proses_all" <?= $selTenaker == 'proses_all' ? 'selected' : '' ?>>Proses All</option>
                                                <option value="proses" <?= $selTenaker == 'proses' ? 'selected' : '' ?>>Proses</option>
                                                <option value="belum_bisa_proses" <?= $selTenaker == 'belum_bisa_proses' ? 'selected' : '' ?>>Belum bisa proses</option>
                                                <option value="interview" <?= $selTenaker == 'interview' ? 'selected' : '' ?>>Interview</option>
                                                <option value="mcu" <?= $selTenaker == 'mcu' ? 'selected' : '' ?>>MCU</option>
                                                <option value="blacklist" <?= $selTenaker == 'blacklist' ? 'selected' : '' ?>><?= $idpemborong > 0 ? 'Tidak Lulus Screening' : 'Blacklist' ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php if ($selTenaker == 'proses_all' || $selTenaker == 'all') { ?>

                                    <?php } else { ?>
                                        <div class="col-sm-4">
                                            <h4>Tanggal</h4>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="input-daterange input-group">
                                                <input type="text" class="input-sm form-control datepick tanggal" id="tanggal" name="tanggal" value="<?= date('d-m-Y', strtotime($tanggal)) ?>" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-3">
                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-8 right">
                                                    <input type="submit" name="btnCari" id="inputCari" value="Refresh" class="btn btn-mini btn-block btn-round btn-info" />
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                </form>
                            </div>
                            <div class="col-md-3">
                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                                </div>
                                <div class="widget-toolbar no-border">
                                    <button class="btn btn-minier btn-success" id="btnExport">
                                        <i class="ace-icon fa fa-file-excel-o bigger-120"></i> Export to Excel
                                    </button>
                                </div>
                            </div>
                        <?php } ?>
                    </div>



                    <?php if ($idpemborong  > 0) { ?>
                        <!-- <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-warning">
                                    <h5 class="uppercase"><strong>Untuk sementara waktu, menu ini tidak dapat diakses !!</strong></h5>
                                </div>
                            </div>
                        </div> -->


                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="table table-responsive">
                                    <table id="dataTables-listTK" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">ID</th>
                                                <th rowspan="2">Nama</th>
                                                <th rowspan="2">Pemborong</th>
                                                <th rowspan="2">Sub Pemborong</th>
                                                <th rowspan="2">Tangga Lahir</th>
                                                <th rowspan="2">Jenis Kelamin</th>
                                                <th rowspan="2">Jadwal Interview</th>
                                                <th rowspan="2">Jadwal MCU</th>
                                                <th colspan="4" class="text-center">Status Progress</th>
                                                <th rowspan="2">
                                                    <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By
                                                </th>
                                                <th rowspan="2">Opsi</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">Interviewed</th>
                                                <th class="text-center">MCU</th>
                                                <th class="text-center">ID CARD</th>
                                                <th class="text-center">Keterangan</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            foreach ($_getTenaker as $set) :
                                            ?>
                                                <?php
                                                echo '<tr data-id="' . $set->HeaderID . '" class="rowdetail" >';
                                                ?>
                                                <td style="width: 50px " class="text-right"><?php echo $set->HeaderID; ?></td>
                                                <td><?php echo $set->Nama; ?></td>
                                                <td><?php echo $set->Pemborong; ?></td>
                                                <td><?php echo $set->SubPemborong; ?></td>
                                                <td class="text-right"><?php echo date('d-M-Y',  strtotime($set->Tgl_Lahir)); ?></td>
                                                <td><?php
                                                    $jekel = $set->Jenis_Kelamin;
                                                    if ($jekel == 'M' || $jekel == 'LAKI-LAKI') {
                                                        echo 'Laki-laki';
                                                    } elseif ($jekel == 'F' || $jekel == 'PEREMPUAN') {
                                                        echo 'Perempuan';
                                                    } else {
                                                        echo 'Gx Jelas';
                                                    }
                                                    ?></td>
                                                <td><?php echo $set->JadwalInterview == NULL ? '' : date('d-M-Y',  strtotime($set->JadwalInterview)); ?></td>
                                                <td>
                                                    <?php //if ($set->PostingData == 1) {
                                                    // // echo $set->TanggalPosting == NULL ? '' : date('d-M-Y',  strtotime($set->TanggalPosting . ' + 1 days'));
                                                    // if ($set->TanggalPosting != NULL) {
                                                    //     if ($set->HariMinggu == 1 || $set->Libur == 1) {
                                                    //         echo date('d-M-Y',  strtotime($set->TanggalPosting . ' + 2 days'));
                                                    // } elseif (($set->Libur == 1 && ($set->TanggalSetelahPosting . ' + 1 days' && $set->HariMinggu == 1)) || ($set->HariMinggu == 1 && ($set->TanggalSetelahPosting . ' + 1 days' && $set->Libur == 1))) {
                                                    //     echo date('d-M-Y',  strtotime($set->TanggalPosting . ' + 3 days'));
                                                    //         } else {
                                                    //             echo date('d-M-Y',  strtotime($set->TanggalPosting . ' + 1 days'));
                                                    //         }
                                                    //     }
                                                    // } else if (isset($set->WawancaraKe)) {
                                                    //     echo 'On Progress';
                                                    // }
                                                    ?>

                                                    <?php if ($set->SpecialScreeningDate != NULL) { ?>
                                                        <?php if ($set->HariMinggu == 1 || $set->Libur == 1) { ?>
                                                            <?= date('d-M-Y',  strtotime($set->SpecialScreeningDate . ' + 2 days')); ?>
                                                        <?php } else { ?>
                                                            <?= date('d-M-Y',  strtotime($set->SpecialScreeningDate . ' + 1 days')); ?>
                                                        <?php } ?>
                                                    <?php } elseif (isset($set->WawancaraKe)) { ?>
                                                        On Progress
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    if ($set->WawancaraKe == NULL) {
                                                        echo 'Belum Pernah';
                                                    } else {
                                                    ?>
                                                        <?php if ($idpemborong > 0) { ?>
                                                            <?php echo $set->WawancaraKe . ' kali'; ?>
                                                        <?php } else { ?>
                                                            <a title="View Detail" data-rel="tooltip" href="#" class="detailInterview btn btn-minier btn-white btn-block">
                                                                <i class="ace-icon fa fa-files-o bigger-100"></i> <?php echo $set->WawancaraKe . ' kali'; ?>
                                                            </a>
                                                        <?php } ?>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($set->apvdokterby == NULL) {
                                                        echo '<span class="label label-default">✘</span>';
                                                    } else {
                                                        echo '<span class="label label-success">✔</span>';
                                                    } ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($set->UdahDiAmbil == 1 && $set->Nofix != null) {
                                                        echo '<span class="label label-success">✔</span>';
                                                    } else {
                                                        echo '<span class="label label-default">✘</span>';
                                                    } ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($set->WawancaraKe != NULL && $set->apvdokterby != NULL && $set->UdahDiAmbil == 1 && $set->Nofix != null) {
                                                        echo '<span class="label label-success">Complete</span>';
                                                    } else {
                                                        if ($idpemborong > 0 && ($set->KeteranganKirim == 'blacklist' || $set->KeteranganKirim == 'blacklist_2_bln')) {
                                                            echo "Tidak Lulus Screening";
                                                        } else {
                                                            echo $set->KeteranganKirim;
                                                        }
                                                    } ?></td>
                                                <td>
                                                    <div class="text-left"><?php echo $set->RegisteredBy; ?></div>
                                                    <div class="text-right smaller-90"><?php echo $set->RegisteredDate; ?></div>
                                                </td>
                                                <td class="text-center">
                                                    <a title="show detail" href="#" class="detail">
                                                        <button class="btn btn-minier btn-primary">
                                                            <i class="ace-icon fa fa-list-alt bigger-100"></i>Detail
                                                        </button>
                                                    </a>
                                                </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="table table-responsive">
                                    <table id="dataTables-listTK" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">ID</th>
                                                <th rowspan="2">Nama</th>
                                                <th rowspan="2">Pemborong</th>
                                                <th rowspan="2">Sub Pemborong</th>
                                                <th rowspan="2">Tangga Lahir</th>
                                                <th rowspan="2">Jenis Kelamin</th>
                                                <th rowspan="2">Jadwal Interview</th>
                                                <th rowspan="2">Jadwal MCU</th>
                                                <th colspan="4" class="text-center">Status Progress</th>
                                                <th rowspan="2">
                                                    <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By
                                                </th>
                                                <th rowspan="2">Opsi</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">Interviewed</th>
                                                <th class="text-center">MCU</th>
                                                <th class="text-center">ID CARD</th>
                                                <th class="text-center">Keterangan</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            foreach ($_getTenaker as $set) :
                                            ?>
                                                <?php
                                                echo '<tr data-id="' . $set->HeaderID . '" class="rowdetail" >';
                                                ?>
                                                <td style="width: 50px " class="text-right"><?php echo $set->HeaderID; ?></td>
                                                <td><?php echo $set->Nama; ?></td>
                                                <td><?php echo $set->Pemborong; ?></td>
                                                <td><?php echo $set->SubPemborong; ?></td>
                                                <td class="text-right"><?php echo date('d-M-Y',  strtotime($set->Tgl_Lahir)); ?></td>
                                                <td><?php
                                                    $jekel = $set->Jenis_Kelamin;
                                                    if ($jekel == 'M' || $jekel == 'LAKI-LAKI') {
                                                        echo 'Laki-laki';
                                                    } elseif ($jekel == 'F' || $jekel == 'PEREMPUAN') {
                                                        echo 'Perempuan';
                                                    } else {
                                                        echo 'Gx Jelas';
                                                    }
                                                    ?></td>
                                                <td><?php echo $set->JadwalInterview == NULL ? '' : date('d-M-Y',  strtotime($set->JadwalInterview)); ?></td>
                                                <td>
                                                    <?php //if ($set->PostingData == 1) {
                                                    // echo $set->TanggalPosting == NULL ? '' : date('d-M-Y',  strtotime($set->TanggalPosting . ' + 1 days'));
                                                    // if ($set->TanggalPosting != NULL) {
                                                    //     if ($set->HariMinggu == 1 || $set->Libur == 1) {
                                                    //         echo date('d-M-Y',  strtotime($set->TanggalPosting . ' + 2 days'));
                                                    // } elseif (($set->Libur == 1 && ($set->TanggalSetelahPosting . ' + 1 days' && $set->HariMinggu == 1)) || ($set->HariMinggu == 1 && ($set->TanggalSetelahPosting . ' + 1 days' && $set->Libur == 1))) {
                                                    //     echo date('d-M-Y',  strtotime($set->TanggalPosting . ' + 3 days'));
                                                    //         } else {
                                                    //             echo date('d-M-Y',  strtotime($set->TanggalPosting . ' + 1 days'));
                                                    //         }
                                                    //     }
                                                    // } else if (isset($set->WawancaraKe)) {
                                                    //     echo 'On Progress';
                                                    // }
                                                    // 
                                                    ?>

                                                    <?php if ($set->SpecialScreeningDate != NULL) { ?>
                                                        <?php if ($set->HariMinggu == 1 || $set->Libur == 1) { ?>
                                                            <?= date('d-M-Y',  strtotime($set->SpecialScreeningDate . ' + 2 days')); ?>
                                                        <?php } else { ?>
                                                            <?= date('d-M-Y',  strtotime($set->SpecialScreeningDate . ' + 1 days')); ?>
                                                        <?php } ?>
                                                    <?php } elseif (isset($set->WawancaraKe)) { ?>
                                                        On Progress
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    if ($set->WawancaraKe == NULL) {
                                                        echo 'Belum Pernah';
                                                    } else {
                                                    ?>
                                                        <?php if ($idpemborong > 0) { ?>
                                                            <?php echo $set->WawancaraKe . ' kali'; ?>
                                                        <?php } else { ?>
                                                            <a title="View Detail" data-rel="tooltip" href="#" class="detailInterview btn btn-minier btn-white btn-block">
                                                                <i class="ace-icon fa fa-files-o bigger-100"></i> <?php echo $set->WawancaraKe . ' kali'; ?>
                                                            </a>
                                                        <?php } ?>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($set->apvdokterby == NULL) {
                                                        echo '<span class="label label-default">✘</span>';
                                                    } else {
                                                        echo '<span class="label label-success">✔</span>';
                                                    } ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($set->UdahDiAmbil == 1 && $set->Nofix != null) {
                                                        echo '<span class="label label-success">✔</span>';
                                                    } else {
                                                        echo '<span class="label label-default">✘</span>';
                                                    } ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($set->WawancaraKe != NULL && $set->apvdokterby != NULL && $set->UdahDiAmbil == 1 && $set->Nofix != null) {
                                                        echo '<span class="label label-success">Complete</span>';
                                                    } else {
                                                        if ($idpemborong > 0 && $set->KeteranganKirim == 'blacklist') {
                                                            echo "Tidak Lulus Screening";
                                                        } else {
                                                            echo $set->KeteranganKirim;
                                                        }
                                                    } ?></td>
                                                <td>
                                                    <div class="text-left"><?php echo $set->RegisteredBy; ?></div>
                                                    <div class="text-right smaller-90"><?php echo $set->RegisteredDate; ?></div>
                                                </td>
                                                <td class="text-center">
                                                    <a title="show detail" href="#" class="detail">
                                                        <button class="btn btn-minier btn-primary">
                                                            <i class="ace-icon fa fa-list-alt bigger-100"></i>Detail
                                                        </button>
                                                    </a>
                                                </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    <?php } ?>


                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal View -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Informasi Data Karyawan</h4>
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

<!-- Modal View -->
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
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" />
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        $('.datepick').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    });

    $(document).ready(function() {
        $('#dataTables-listTK').dataTable({
            "order": [0, 'desc']
        });

        $('.on_cari_data').change(function() {
            $('#form_cari_data').submit();
        });

        $("#btnExport").click(function() {
            $("#tblExport").battatech_excelexport({
                containerid: "dataTables-listTK",
                datatype: 'table'
            });
        });

        $("#all").click(function() {
            alert("all")
        });

        $("#dataTables-listTK").on("click", ".detail", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url: "<?php echo site_url('monitor/detailtk'); ?>",
                type: "POST",
                data: "kode=" + id,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#detail").html(msg);
                }
            });
            $("#viewModal").modal("show");
        });

        $("#dataTables-listTK").on("click", ".detailInterview", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url: "<?php echo site_url('wawancaraTujuan/cekRecordInterview'); ?>",
                type: "POST",
                data: "kode=" + id,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#detailInterview").html(msg);
                }
            });
            $("#viewModalInterview").modal("show");
        });

        /**
         * automaticUpdateData() adalah fungsi yang di gunakan untuk
         * pengecekan otomatis apabila TK tidak melakukan MCU atau mengambil ID Card
         * dalam kurun waktu 8 hari sejak tanggal posting, maka TK akan dikembalikan ke 
         * menu registrasi Daftar CTKB
         * 
         * Note by Kiki
         */
        automaticUpdateData()

    });



    function automaticUpdateData() {
        var test = 'test'
        $.ajax({
            url: "<?php echo site_url('monitor/AutomaticCheck'); ?>",
            type: "POST",
            datatype: "json",
            data: test,
            cache: false,
            success: function(msg) {
                console.log(msg);
            },
            error: function(e, error) {
                console.log(error);
            }
        })
    }
</script>