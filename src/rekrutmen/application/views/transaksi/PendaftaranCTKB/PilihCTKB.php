<script type="text/javascript" src="<?php echo base_url(); ?>assets/toExcel/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/toExcel/jquery.battatech.excelexport.js"></script>
<div class="page-header">
    <h1>
        TRANSAKSI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Daftar CTKB
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
                        <h4 class="widget-title">List Tenaga Kerja Baru </h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                        </div>

                        <?php
                        if ($this->session->userdata('userid') == 'kiki' || $this->session->userdata('userid') == 'KIKI') {
                            $idpemborong = 0;
                        } else {

                            $idpemborong    = $this->session->userdata('idpemborong');
                        }

                        ?>


                    </div>

                    <br>
                    <div class="tabbable">
                        <ul class="nav nav-tabs padding-18 tab-size-bigger" id="myTab">
                            <li class="active">
                                <a data-toggle="tab" aria-expanded="true" href="#faq-tab-1" class="centered-tab">
                                    <i class="blue ace-icon fa fa-book bigger-120"></i>
                                    <span>Main</span>
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" aria-expanded="true" href="#faq-tab-2" class="centered-tab">
                                    <i class="green ace-icon fa fa-stethoscope bigger-120"></i>
                                    <span>Procces to MCU</span>
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" aria-expanded="true" href="#faq-tab-3" class="centered-tab">
                                    <i class="green ace-icon fa fa-pencil bigger-120"></i>
                                    <span>Procces to interview</span>
                                </a>
                            </li>



                        </ul>
                        <div id="loading" class="spinner-overlay">
                            <div class="spinner"></div>
                        </div>

                        <div class="tab-content no-border padding-24">
                            <!-- ////////////////////////////////////////////////////////////////////////// TAB 1 ////////////////////////////////////////////////////////////////////////////////////////////// -->
                            <div id="faq-tab-1" class="tab-pane fade in active">


                                <?php
                                if ($idpemborong > 0) { ?>
                                    <form class="form-horizontal" id="form_cari_data" role="form" method="POST" action="<?php echo base_url('Registrasi/PilihCTKB'); ?>">
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="table-responsive">
                                                    <table id="dataTables-listTK-forPBR" class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">
                                                                    <label class="pos-rel">
                                                                        <input type="checkbox" class="ace chk_all">
                                                                        <span class="lbl"></span>
                                                                    </label>
                                                                </th>
                                                                <th class="info">ID</th>
                                                                <th class="info">Nama</th>
                                                                <th class="info">Pemborong</th>
                                                                <th class="info">Sub Pemborong</th>
                                                                <th class="info">Tangga Lahir</th>
                                                                <th class="info">Jenis Kelamin</th>
                                                                <th class="info">
                                                                    <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By
                                                                </th>
                                                                <th class="info center">Vaksin</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                <?php } else { ?>
                                    <!-- <form id="form_cari_data" role="form" method="POST" action="<?php echo base_url('Registrasi/PilihCTKB'); ?>">
                                        <div class="col-xs-12 col-sm-4">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label no-padding-right">Range</label>
                                                <div class="col-sm-8">
                                                    <div class="input-daterange input-group">
                                                        <input type="text" class="input-sm form-control datepick start_date" id="start_date" name="start_date" autocomplete="off">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-exchange"></i>
                                                        </span>
                                                        <input type="text" class="input-sm form-control datepick end_date" id="end_date" name="end_date" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-3">
                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-8 right">
                                                    <input type="submit" name="btnCari" id="inputCari" value="Refresh" class="btn btn-mini btn-block btn-round btn-info" />
                                                </div>
                                            </div>
                                        </div>


                                    </form> -->

                                    <div class="row mb-4">
                                        <div class="col-md-4">

                                            <div class="form-group onHide">
                                                <div class="input-daterange input-group" style="width: 100%;">
                                                    <input type="text" class="form-control datepick start_date" id="start_date" name="start_date" autocomplete="off">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-exchange"></i>
                                                    </span>
                                                    <input type="text" class="form-control datepick end_date" id="end_date" name="end_date" autocomplete="off">
                                                </div>
                                            </div>
                                            <input type="button" name="btnCari" id="inputCari" value="Refresh" class="btn btn-info onHide" style="width: 100%;" />

                                            <!-- <button class="btn btn-minier btn-success" id="btnExport" style="width: 100px;">
                                            <i class="ace-icon fa fa-file-excel-o"></i> Export to Excel
                                        </button> -->
                                        </div>
                                    </div>



                                    <br>
                                    <br>
                                    <form class="form-horizontal" id="form_cari_data" role="form" method="POST" action="<?php echo base_url('Registrasi/PilihCTKB'); ?>">
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="table-responsive">
                                                    <button type="button" name="export1" id="export1" value="" class="btn btn-sm btn-success onHide">
                                                        <i class="ace-icon fa fa-file-excel-o"></i> Export
                                                    </button>
                                                    <table id="dataTables-listTK" class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">
                                                                    <label class="pos-rel">
                                                                        <input type="checkbox" class="ace chk_all">
                                                                        <span class="lbl"></span>
                                                                    </label>
                                                                </th>
                                                                <th class="info">ID</th>
                                                                <th class="info">Nama</th>
                                                                <th class="info">Pemborong</th>
                                                                <th class="info">Sub Pemborong</th>
                                                                <th class="info">Tangga Lahir</th>
                                                                <th class="info">Jenis Kelamin</th>
                                                                <th class="info">
                                                                    <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By
                                                                </th>
                                                                <th class="info center">Tgl. Daftar by PBR</th>
                                                                <th class="info center">Vaksin</th>
                                                                <th class="info center">Opsi</th>
                                                                <th class="info center">Keterangan</th>
                                                                <th class="info center">Pilihan Tanda</th>
                                                                <th class="info center">Kualifikasi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>



                                            </div>
                                        </div>
                                    </form>

                                    <div class="widget-toolbox padding-8 clearfix">
                                        <div class="row">
                                            <div class="col-md-6">

                                            </div>
                                            <div class="col-md-6">
                                                <button name="btnKirim" id="btnKirim" class="btnKirim btn btn-success">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                            <!-- ////////////////////////////////////////////////////////////////////////// TAB 2 ////////////////////////////////////////////////////////////////////////////////////////////// -->

                            <div id="faq-tab-2" class="tab-pane fade">

                                <?php if ($idpemborong > 0) { ?>
                                <?php  } else { ?>


                                    <div class="row mb-4">
                                        <div class="col-md-4">

                                            <div class="form-group onHide">
                                                <div class="input-daterange input-group" style="width: 100%;">
                                                    <input type="text" class="form-control datepick start_process_date" id="start_process_date" name="start_date" autocomplete="off">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-exchange"></i>
                                                    </span>
                                                    <input type="text" class="form-control datepick end_process_date" id="end_process_date" name="end_date" autocomplete="off">
                                                </div>
                                            </div>
                                            <input type="button" name="btnCari" id="inputCarib" value="Refresh" class="btn btn-info onHide" style="width: 100%;" />
                                            <br>
                                            <label for="">Note : Range Tanggal By Tanggal Diproses</label>
                                            <!-- <button class="btn btn-minier btn-success" id="btnExport" style="width: 100px;">
                                            <i class="ace-icon fa fa-file-excel-o"></i> Export to Excel
                                        </button> -->
                                        </div>
                                    </div>
                                    <br>
                                    <br>


                                    <form class="form-horizontal" id="form_cari_data" role="form" method="POST" action="<?php echo base_url('Registrasi/PilihCTKB'); ?>">
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="table-responsive">
                                                    <button type="button" name="export2" id="export2" value="" class="btn btn-sm btn-success onHide">
                                                        <i class="ace-icon fa fa-file-excel-o"></i> Export
                                                    </button>

                                                    <table id="dataTables-listTK-MCU" class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">
                                                                    <label class="pos-rel">
                                                                        <input type="checkbox" id="chk2_all" class="ace chk2_all">
                                                                        <span class="lbl"></span>
                                                                    </label>
                                                                </th>
                                                                <th class="info">ID</th>
                                                                <th class="info">Nama</th>
                                                                <th class="info">Pemborong</th>
                                                                <th class="info">Sub Pemborong</th>
                                                                <th class="info">Tangga Lahir</th>
                                                                <th class="info">Jenis Kelamin</th>
                                                                <th class="info">
                                                                    <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By
                                                                </th>
                                                                <th class="info center">Tgl. Daftar by PBR</th>
                                                                <!-- <th class="info center">Tgl. Jadwal Interview</th> -->
                                                                <th class="info center">Vaksin</th>
                                                                <th class="info center">Opsi</th>
                                                                <!-- <th class="info center">Keterangan</th> -->
                                                                <th class="info center">Pilihan Tanda</th>
                                                                <th class="info center">Kualifikasi</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                    <div class="widget-toolbox padding-8 clearfix">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label no-padding-right">Jadwal MCU</label>
                                                    <div class="col-sm-8">
                                                        <div class="input-daterange input-group">
                                                            <input type="text" class="input-sm form-control datepick jadwal_mcu" id="jadwal_mcu" name="jadwal_mcu" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <button name="btnUpdateTglMCU" id="btnUpdateTglMCU" class="btnUpdateTglMCU btn btn-success">Submit</button>
                                            </div>
                                        </div>
                                    </div>

                                <?php  } ?>
                            </div>
                            <!-- ////////////////////////////////////////////////////////////////////////// TAB 3 ////////////////////////////////////////////////////////////////////////////////////////////// -->
                            <div id="faq-tab-3" class="tab-pane fade">

                                <?php if ($idpemborong > 0) { ?>
                                <?php  } else { ?>

                                    <form class="form-horizontal" id="form_cari_data" role="form" method="POST" action="<?php echo base_url('Registrasi/PilihCTKB'); ?>">
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="table-responsive">
                                                    <button type="button" name="export3" id="export3" value="" class="btn btn-sm btn-success onHide">
                                                        <i class="ace-icon fa fa-file-excel-o"></i> Export
                                                    </button>
                                                    <table id="dataTables-listTK2" class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">
                                                                    <label class="pos-rel">
                                                                        <input type="checkbox" id="chk3_all" class="ace chk3_all">
                                                                        <span class="lbl"></span>
                                                                    </label>
                                                                </th>
                                                                <th class="info">ID</th>
                                                                <th class="info">Nama</th>
                                                                <th class="info">Pemborong</th>
                                                                <th class="info">Sub Pemborong</th>
                                                                <th class="info">Tangga Lahir</th>
                                                                <th class="info">Jenis Kelamin</th>
                                                                <th class="info">
                                                                    <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By
                                                                </th>
                                                                <th class="info center">Tgl. Daftar by PBR</th>
                                                                <!-- <th class="info center">Tgl. Jadwal Interview</th> -->
                                                                <th class="info center">Vaksin</th>
                                                                <th class="info center">Opsi</th>
                                                                <th class="info center">Hasil MCU</th>
                                                                <!-- <th class="info center">Keterangan</th> -->
                                                                <th class="info center">Pilihan Tanda</th>
                                                                <th class="info center">Kualifikasi</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                    <div class="widget-toolbox padding-8 clearfix">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label no-padding-right">Jadwal Interview</label>
                                                    <div class="col-sm-8">
                                                        <div class="input-daterange input-group">
                                                            <input type="text" class="input-sm form-control datepick jadwal_interview" id="jadwal_interview" name="jadwal_interview" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <button name="btnUpdateTglInterview" id="btnUpdateTglInterview" class="btnUpdateTglInterview btn btn-success">Submit</button>
                                            </div>
                                        </div>
                                    </div>

                                <?php  } ?>
                            </div>

                        </div>
                    </div>

                    <br>
                    <?php
                    // <?php $att = array('class' => 'form-horizontal', 'role' => 'form');
                    // echo form_open('postingTenaker/doPosting', $att);
                    ?>




                </div>
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

<!-- Modal to Excel -->
<div class="modal fade" id="modalToExcel" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titleModal"> Export to Excel</h4>
            </div>
            <div class="modal-body">
                <div id="showTable">

                </div>
                Isi Body
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

<!-- Modal View -->
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


<script src="<?php echo base_url(); ?>assets/js/buttons/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons JS -->
<script src="<?php echo base_url(); ?>assets/js/buttons/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/buttons/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/buttons/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/buttons/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/buttons/buttons.print.min.js"></script>




<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" />
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        const site_url = '<?= site_url() ?>';
        const base_url = '<?= base_url() ?>';
        // const site_url = 'http://portal.psg.co.id';
        // const base_url = 'http://portal.psg.co.id';

        $("#dataTables-listTK").DataTable({
            processing: false,
            responsive: true,
            order: [],
            serverSide: true,
            ajax: {
                url: site_url + "registrasi/show_main",
                type: "POST",
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                },
                beforeSend: function() {
                    $('#loading').show(); // Tampilkan loading spinner sebelum request
                },
                complete: function() {
                    $('#loading').hide(); // Sembunyikan loading spinner setelah request selesai                
                }
            },
            language: {
                url: base_url + 'assets/stexo/plugins/datatables/language/id.json',
                searchPlaceholder: "Cari..."
            },
            lengthMenu: [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "All"]
            ],
            columnDefs: [{
                    type: 'date-eu',
                    targets: 5
                }, {
                    type: 'date-eu',
                    targets: 8
                }, // Mengatur kolom indeks ke-4 (indeks dimulai dari 0) sebagai tipe data tanggal
            ],
            // Mengatur tampilan default menjadi 10
            pageLength: 10,
            columnDefs: [{
                targets: 0, // indeks kolom pertama
                orderable: false // membuat kolom pertama tidak dapat diurutkan
            }],
            // dom: 'Bfrtip', // Tambahkan opsi dom untuk Buttons
            buttons: [{
                extend: 'excelHtml5',
                title: 'Data Export',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8, 9] // Specify the columns you want to export
                }
            }]
        });

        // Fungsi untuk mengekspor data ke Excel
        $('#export1').on('click', function() {
            $("#dataTables-listTK").DataTable().button('.buttons-excel').trigger();
        });

        $("#dataTables-listTK-forPBR").DataTable({
            processing: false,
            responsive: true,
            order: [],
            serverSide: true,
            ajax: {
                url: site_url + "registrasi/show_main_pbr",
                type: "POST",
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                },
                beforeSend: function() {
                    $('#loading').show(); // Tampilkan loading spinner sebelum request
                },
                complete: function() {
                    $('#loading').hide(); // Sembunyikan loading spinner setelah request selesai                
                }
            },
            language: {
                url: base_url + 'assets/stexo/plugins/datatables/language/id.json',
                searchPlaceholder: "Cari..."
            },
            lengthMenu: [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "All"]
            ],
            // Mengatur tampilan default menjadi 10
            pageLength: 10,
            columnDefs: [{
                targets: 0, // indeks kolom pertama
                orderable: false // membuat kolom pertama tidak dapat diurutkan
            }],
            dom: 'Bfrtip', // Tambahkan opsi dom untuk Buttons
            buttons: [{
                extend: 'excelHtml5',
                title: 'Data Export',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7] // Specify the columns you want to export
                }
            }]
        });

        $("#dataTables-listTK2").DataTable({
            processing: false,
            responsive: true,
            order: [],
            serverSide: true,
            ajax: {
                url: site_url + "registrasi/show_proses",
                type: "POST",
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                },
                beforeSend: function() {
                    $('#loading').show(); // Tampilkan loading spinner sebelum request
                },
                complete: function() {
                    $('#loading').hide(); // Sembunyikan loading spinner setelah request selesai                
                }
            },
            language: {
                url: base_url + 'assets/stexo/plugins/datatables/language/id.json',
                searchPlaceholder: "Cari..."
            },
            lengthMenu: [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "All"]
            ],
            // Mengatur tampilan default menjadi 10
            pageLength: 10,

            // dom: 'Bfrtip', // Tambahkan opsi dom untuk Buttons
            buttons: [{
                extend: 'excelHtml5',
                title: 'Data Export',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7] // Specify the columns you want to export
                }
            }],
            columnDefs: [{
                    type: 'date-eu',
                    targets: 5
                }, {
                    type: 'date-eu',
                    targets: 8
                }, // Mengatur kolom indeks ke-4 (indeks dimulai dari 0) sebagai tipe data tanggal
                {
                    targets: 0, // indeks kolom pertama
                    orderable: false // membuat kolom pertama tidak dapat diurutkan
                }
            ],
        });

        // Fungsi untuk mengekspor data ke Excel
        $('#export3').on('click', function() {
            $("#dataTables-listTK2").DataTable().button('.buttons-excel').trigger();
        });


        $("#dataTables-listTK-MCU").DataTable({
            processing: false,
            responsive: true,
            order: [],
            serverSide: true,
            ajax: {
                url: site_url + "registrasi/show_proses_to_mcu",
                type: "POST",
                data: function(d) {
                    d.start_process_date = $('#start_process_date').val();
                    d.end_process_date = $('#end_process_date').val();
                },
                beforeSend: function() {
                    $('#loading').show(); // Tampilkan loading spinner sebelum request
                },
                complete: function() {
                    $('#loading').hide(); // Sembunyikan loading spinner setelah request selesai                
                }
            },
            language: {
                url: base_url + 'assets/stexo/plugins/datatables/language/id.json',
                searchPlaceholder: "Cari..."
            },
            lengthMenu: [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "All"]
            ],
            // Mengatur tampilan default menjadi 10
            pageLength: 10,
            // dom: 'Bfrtip', // Tambahkan opsi dom untuk Buttons
            buttons: [{
                extend: 'excelHtml5',
                title: 'Data Export',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7] // Specify the columns you want to export
                }
            }],
            columnDefs: [{
                    type: 'date-eu',
                    targets: 5
                }, {
                    type: 'date-eu',
                    targets: 8
                }, // Mengatur kolom indeks ke-4 (indeks dimulai dari 0) sebagai tipe data tanggal
                {
                    targets: 0, // indeks kolom pertama
                    orderable: false // membuat kolom pertama tidak dapat diurutkan
                }
            ],
        });

        // Fungsi untuk mengekspor data ke Excel
        $('#export2').on('click', function() {
            $("#dataTables-listTK-MCU").DataTable().button('.buttons-excel').trigger();
        });

        $('#dataTables-listTK2, #dataTables-listTK , #dataTables-listTK-MCU').css('width', '100%');

        $('#inputCari').click(function(e) {
            e.preventDefault()
            $('#dataTables-listTK').DataTable().ajax.reload();
        });
        $('#inputCarib').click(function(e) {
            e.preventDefault()
            console.log({
                start: $('#start_process_date').val(),
                end: $('#end_process_date').val()
            });
            $('#dataTables-listTK-MCU').DataTable().ajax.reload();
        });



    })

    jQuery(function($) {
        $('.datepick').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    });

    $(document).on('click', '.chk_all', function() {
        if (this.checked) {
            $('.chkPosting').prop('checked', true)
        } else {
            $('.chkPosting').prop('checked', false)
        }

    })

    $(document).on('click', '#chk2_all', function() {
        if (this.checked) {
            $('.chkMCU').prop('checked', true)
        } else {
            $('.chkMCU').prop('checked', false)
        }

    })

    $(document).on('click', '#chk3_all', function() {
        if (this.checked) {
            $('.chkToInterview').prop('checked', true)
        } else {
            $('.chkToInterview').prop('checked', false)
        }

    })

    $(document).ready(function() {
        $('#dataTables-listTK').dataTable();
        $('#dataTables-listTK2').dataTable();
        $('[data-rel=tooltip]').tooltip();


        $("#btnExport").click(function() {
            $("#tblExport").battatech_excelexport({
                containerid: "exportToExcel",
                datatype: 'table'
            });
        });

        $("#btnExportProses").click(function() {
            $("#tblExport").battatech_excelexport({
                containerid: "exportToExcelProses",
                datatype: 'table'
            });
        });

    });







    $(document).ready(function() {
        // view modal
        $("#dataTables-listTK").on("click", ".detailInterview", function() {
            var id = $(this).closest('tr').find('.chkPosting').val();
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


        $("#dataTables-listTK").on("click", ".detail", function() {
            var id = $(this).closest('tr').find('.chkPosting').val();
            var name = $(this).data('name');
            var tk = $(this).data('tk');

            document.getElementById('titleModal').innerHTML = "Berkas " + name + " dari saudara, <strong class='green'>" + tk + " </strong>";
            $.ajax({
                url: "<?php echo site_url('monitor/viewDocs'); ?>",
                type: "POST",
                data: "kode=" + id + "&nama=" + name,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#detail").html(msg);
                }
            });
            $("#viewModal").modal("show");
        });

        $("#dataTables-listTK, #dataTables-listTK-MCU, #dataTables-listTK2").on("click", ".detailInfo", function() {

            // var id = $(this).closest('tr').find('.chkPosting').val()
            var id = $(this).closest('tr').find('.checkbox .pos-rel input').val()
            console.log('ini id :', id);
            $.ajax({
                url: "<?php echo site_url('uploadBerkas/detailtk'); ?>",
                type: "POST",
                data: "kode=" + id,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#detailInfo").html(msg);
                }
            });
            $("#viewModalInfo").modal("show");
        });

        $("#dataTables-listTK2").on("click", ".detailInterview", function() {
            var id = $(this).closest('tr').find('.chkPosting').val();
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

        $("#dataTables-listTK, #dataTables-listTK-MCU, #dataTables-listTK2").on("click", ".detail", function() {
            // var id = $(this).closest('tr').find('.chkPosting').val();
            var id = $(this).closest('tr').find('.checkbox .pos-rel input').val()
            var name = $(this).data('name');
            var tk = $(this).data('tk');

            document.getElementById('titleModal').innerHTML = "Berkas " + name + " dari saudara, <strong class='green'>" + tk + " </strong>";
            $.ajax({
                url: "<?php echo site_url('monitor/viewDocs'); ?>",
                type: "POST",
                data: "kode=" + id + "&nama=" + name,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#detail").html(msg);
                }
            });
            $("#viewModal").modal("show");
        });

        $("#dataTables-listTK2").on("click", ".detailInfo", function() {

            var id = $(this).closest('tr').find('.chkPosting').val();
            $.ajax({
                url: "<?php echo site_url('uploadBerkas/detailtk'); ?>",
                type: "POST",
                data: "kode=" + id,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#detailInfo").html(msg);
                }
            });
            $("#viewModalInfo").modal("show");
        });
        // end view modal

        // Update proses
        var urlSaveKirimPBR = '<?= base_url() ?>Registrasi/updateProses';
        $(document).on('click', '.btnKirim', function() {

            var headerIDKirim = []
            var keterangan = []
            var proses = []

            $('#dataTables-listTK .chkPosting').each(function(i, e) {
                if ($(this).is(':checked')) {
                    headerIDKirim.push($(this).val())
                    keterangan.push($(this).closest('tr').find('.keterangan').val())
                    proses.push($(this).closest('tr').find('.proses').val())
                }
            })

            if (headerIDKirim.length === 0) {
                Swal.fire(
                    'Gagal!',
                    'Tidak ada data yang di pilih !!!',
                    'warning'
                )
                return
            }



            if (proses.includes('')) {
                Swal.fire(
                    'Gagal!',
                    'Anda belum memilih tanda "Proses/Belum Bisa Proses/Tidak Bisa Proses" !!!',
                    'warning'
                )
                return
            }

            Swal.fire({
                title: 'Anda Yakin?',
                text: "Anda yakin ingin memproses daftar nama ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: urlSaveKirimPBR,
                        dataType: 'json',
                        data: {
                            headerID: headerIDKirim,
                            keterangan,
                            proses
                        },
                        success: function(data) {
                            console.log(data.ket);
                            Swal.fire(
                                data.msg,
                                'Data ' + data.msg + ' disimpan!',
                                data.type
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    // location.reload();
                                    $('#dataTables-listTK').DataTable().ajax.reload();
                                    $('#dataTables-listTK2').DataTable().ajax.reload();
                                    $('#dataTables-listTK-forPBR').DataTable().ajax.reload();
                                    $('#dataTables-listTK-MCU').DataTable().ajax.reload();
                                }
                            })
                        }
                    });
                }
            })

        })
        // $('.btnKirim').click(function(event) {
        //     var headerID = []
        //     var keterangan = []
        //     var proses = []

        //     $('#dataTables-listTK .chkPosting').each(function(i, e) {
        //         if ($(this).is(':checked')) {
        //             headerID.push($(this).val())
        //             keterangan.push($(this).closest('tr').find('.keterangan').val())
        //             proses.push($(this).closest('tr').find('.proses').val())
        //         }
        //     })

        //     if (headerID.length === 0) {
        //         Swal.fire(
        //             'Gagal!',
        //             'Tidak ada data yang di pilih !!!',
        //             'warning'
        //         )
        //         return
        //     }



        //     if (proses.includes('')) {
        //         Swal.fire(
        //             'Gagal!',
        //             'Anda belum memilih tanda "Proses/Belum Bisa Proses/Tidak Bisa Proses" !!!',
        //             'warning'
        //         )
        //         return
        //     }

        //     Swal.fire({
        //         title: 'Anda Yakin?',
        //         text: "Anda yakin ingin memproses daftar nama ini ?",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Ya!'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 type: "POST",
        //                 url: urlSaveKirimPBR,
        //                 dataType: 'json',
        //                 data: {
        //                     headerID,
        //                     keterangan,
        //                     proses
        //                 },
        //                 success: function(data) {
        //                     console.log(data.ket);
        //                     Swal.fire(
        //                         data.msg,
        //                         'Data ' + data.msg + ' disimpan!',
        //                         data.type
        //                     ).then((result) => {
        //                         if (result.isConfirmed) {
        //                             location.reload();
        //                         }
        //                     })
        //                 }
        //             });
        //         }
        //     })



        // });

        // Update jadwal MCU
        $(document).on('click', '#btnUpdateTglMCU', function() {

            var headerIDMcu = []
            var jadwal_mcu = $('#jadwal_mcu').val()

            if (jadwal_mcu.trim() == '') {
                Swal.fire(
                    'Gagal!',
                    'Jadwal MCU Tidak Boleh Kosong !!!',
                    'warning'
                )
                return
            }

            $('#dataTables-listTK-MCU .chkMCU').each(function(i, e) {
                if ($(this).is(':checked')) {
                    headerIDMcu.push($(this).val())
                }
            })

            // console.log(headerIDMcu);
            // return

            if (headerIDMcu.length === 0) {
                Swal.fire(
                    'Gagal!',
                    'Tidak ada data yang di pilih !!!',
                    'warning'
                )

                return
            }

            Swal.fire({
                title: 'Anda Yakin?',
                text: "Anda yakin ingin memproses daftar nama ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('Registrasi/updateJdwlMCU') ?>",
                        dataType: 'json',
                        data: {
                            headerID: headerIDMcu,
                            jadwal_mcu
                        },
                        success: function(data) {
                            console.log(data.msg);
                            Swal.fire(
                                data.msg,
                                'Data ' + data.msg + ' disimpan!',
                                data.type
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    // location.reload();
                                    $('#dataTables-listTK').DataTable().ajax.reload();
                                    $('#dataTables-listTK2').DataTable().ajax.reload();
                                    $('#dataTables-listTK-forPBR').DataTable().ajax.reload();
                                    $('#dataTables-listTK-MCU').DataTable().ajax.reload();
                                }
                            })
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            })

        })

        // Update jadwal interview
        $('.btnUpdateTglInterview').click(function(event) {
            var headerIDInt = []
            var jadwalInterview = $('#jadwal_interview').val()

            if (jadwalInterview.trim() == '') {
                Swal.fire(
                    'Gagal!',
                    'Jadwal Interview Tidak Boleh Kosong !!!',
                    'warning'
                )
                return
            }

            $('#dataTables-listTK2 .chkToInterview').each(function(i, e) {
                if ($(this).is(':checked')) {
                    headerIDInt.push($(this).val())
                }
            })

            // console.log(headerIDInt);
            // return

            if (headerIDInt.length === 0) {
                Swal.fire(
                    'Gagal!',
                    'Tidak ada data yang di pilih !!!',
                    'warning'
                )

                return
            }

            Swal.fire({
                title: 'Anda Yakin?',
                text: "Anda yakin ingin memproses daftar nama ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('Registrasi/updateJdwlInterview') ?>",
                        dataType: 'json',
                        data: {
                            headerID: headerIDInt,
                            jadwalInterview
                        },
                        success: function(data) {
                            console.log(data.msg);
                            Swal.fire(
                                data.msg,
                                'Data ' + data.msg + ' disimpan!',
                                data.type
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    // location.reload();
                                    $('#dataTables-listTK').DataTable().ajax.reload();
                                    $('#dataTables-listTK2').DataTable().ajax.reload();
                                    $('#dataTables-listTK-forPBR').DataTable().ajax.reload();
                                    $('#dataTables-listTK-MCU').DataTable().ajax.reload();
                                }
                            })
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            })



        });
    });


    // simpan kualifikasi

    var urlSaveKualifikasi = '<?= base_url() ?>Monitor/updateKualifikasi';
    $(document).on('click', '.simpan', function() {
        var kualifikasi = $(this).closest('tr').find('.kualifikasi').val()
        var headerID = $(this).closest('tr').find('.chkPosting').val()

        $.ajax({
            type: "POST",
            url: urlSaveKualifikasi,
            dataType: 'json',
            data: {
                headerID,
                kualifikasi
            },
            success: function(data) {
                console.log(data);
                Swal.fire(
                    data.msg,
                    'Data ' + data.msg + ' disimpan!',
                    data.type
                )
            }
        });


    })



    $(document).on('change', '#dataTables-listTK .keterangan', function() {
        var keterangan = $(this).val()
        console.log(keterangan);
        if (keterangan == 'blacklist' || keterangan == 'blacklist_2_bln') {
            $(this).closest('tr').find('.proses').val('tidak').trigger('change')
        } else {
            $(this).closest('tr').find('.proses').val('belum').trigger('change')
        }
    })
</script>