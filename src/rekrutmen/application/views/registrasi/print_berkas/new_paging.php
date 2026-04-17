<?php
// print_r($_selectWhere);
//die; 
?>


<div class="page-header">
    <h1>
        REGISTRASI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Print Berkas Karyawan DEV
        </small>
    </h1>
</div><!-- /.page-header -->
<style>
    .form-group {
        margin-bottom: 6px;
    }

    .input-daterange .form-control {
        height: 30px;
    }

    .datepicker {
        z-index: 99999 !important;
    }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>

                <div class="widget-toolbar no-border">
                    <a href="" target="_blank" class="btn btn-sm btn-success" id="ExportExcel">Export to Excel</a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-xs-12">
                            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PrintControl/filterData'); ?>">

                                <div class="col-md-4">

                                    <!-- Filter -->
                                    <div class="form-group">
                                        <label for="inputDataFilter">Filter Data</label>
                                        <select name="selDataFilter" id="inputDataFilter" class="form-control input-sm">
                                            <option value="0">Telah Posting</option>
                                            <option value="1">Lulus Wawancara</option>
                                            <option value="2">Telah Discreening HRD</option>
                                        </select>
                                    </div>

                                    <!-- Periode -->
                                    <div class="form-group onHide">
                                        <label>Periode</label>
                                        <div class="input-daterange input-group" style="width:100%;">
                                            <input type="text" class="form-control input-sm datepick start_date" id="start_date" name="start_date" autocomplete="off">
                                            <span class="input-group-addon">
                                                <i class="fa fa-exchange"></i>
                                            </span>
                                            <input type="text" class="form-control input-sm datepick end_date" id="end_date" name="end_date" autocomplete="off">
                                        </div>
                                    </div>

                                    <!-- Refresh -->
                                    <div class="form-group">
                                        <button type="button" name="btnCari" id="inputCari" value="Refresh" class="btn btn-info btn-sm" style="width:100%;"> <i class="fa fa-reload"></i> Refresh</button>
                                    </div>
                                    <div class="form-group">
                                        <a id="printCheckedValue" disabled href="" data-rel="tooltip" target="_blank" class="btn btn-danger btn-sm" style="width:100%;">
                                            <i class="fa fa-file"></i> Print Mandiri
                                        </a>
                                    </div>

                                </div>

                            </form>
                        </div>

                        <!-- Print -->
                        <!-- <div class="col-xs-12" style="margin-top: 6px;">
                            <a id="printCheckedValue" disabled href="" data-rel="tooltip" target="_blank" class="btn btn-danger btn-sm">
                                <i class="fa fa-file"></i> Print Mandiri
                            </a>
                        </div> -->

                        <div class="col-xs-12 table-responsive">
                            <table id="dataTables-listTK" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Departemen</th>
                                        <th>Tipe TenaKer</th>
                                        <th>Tangga Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Berkas</th>
                                        <th>
                                            <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Posted By
                                        </th>
                                        <th>Screening By HRD</th>
                                        <th>Hasil Interview</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                </tbody>

                                <tfoot>


                                </tfoot>
                            </table>
                        </div>
                    </div>
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

<!-- Modal View Berkas-->
<div class="modal fade" id="viewModalBerkas" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titleModal"></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="berkas" class="well">
                    <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
    var jqOld = $.noConflict(true);

    jqOld(function() {
        jqOld('.datepick').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    });
</script>

<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/jqv/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/moment.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/datetime-moment.js"></script>



<script type="text/javascript">
    $(document).ready(function() {
        //$('#dataTables-listTK').dataTable();
        $('[data-rel=tooltip]').tooltip();

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

        $("#dataTables-listTK").on("click", ".detail", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url: "<?php echo site_url('uploadBerkas/detailtk'); ?>",
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

        $("#dataTables-listTK").on("click", ".berkas", function() {
            var id = $(this).closest('tr').data('id');
            var name = $(this).data('name');
            var tk = $(this).data('tk');

            document.getElementById('titleModal').innerHTML = "Berkas " + name + " dari saudara, <strong class='green'>" + tk + "</strong>";
            $.ajax({
                url: "<?php echo site_url('monitor/viewDocs'); ?>",
                type: "POST",
                data: "kode=" + id + "&nama=" + name,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#berkas").html(msg);
                }
            });
            $("#viewModalBerkas").modal("show");
        });
    });
</script>


<!-- test -->


<script type="text/javascript">
    // jQuery(function($) {
    //     $('.datepick').datepicker({
    //         autoclose: true,
    //         format: 'dd-mm-yyyy'
    //     });
    // });
</script>
<script>
    $('#printCheckedValue').click(function() {
        var val = [];
        var url = "<?php echo site_url('printControl/viewMandiriChecked/') ?>"
        $(':checkbox:checked').each(function(i) {
            val[i] = $(this).val();
        });
        var arrStr = encodeURIComponent(JSON.stringify(val));
        $(this).attr("href", url + arrStr)
    });

    $(document).on('change', '.chkBox', function() {
        var cek = false;
        $(':checkbox:checked').each(function(i) {
            cek = true
        });

        if (cek) {
            $('#printCheckedValue').removeAttr('disabled');
        } else {
            $('#printCheckedValue').attr("disabled", "disabled");
        }
    });

    // $('.chkBox').click(function() {


    //     var cek = false;
    //     $(':checkbox:checked').each(function(i) {
    //         cek = true
    //     });

    //     if (cek) {
    //         $('#printCheckedValue').removeAttr('disabled');
    //     } else {
    //         $('#printCheckedValue').attr("disabled", "disabled");
    //     }
    // })

    $('#ExportExcel').click(function() {
        var tanggalAwal = $('#start_date').val()
        var tanggalAkhir = $('#end_date').val()
        var dataSelect = $('#inputDataFilter').val()
        var val = [];
        val[0] = tanggalAwal
        val[1] = tanggalAkhir
        val[2] = dataSelect
        var url = "<?php echo site_url('printControl/EksportExcel/') ?>"
        console.log(tanggalAwal, tanggalAkhir);

        var arrStr = encodeURIComponent(JSON.stringify(val));
        $(this).attr("href", url + arrStr)
    });


    // #AJAX DATATABLES
    const site_url = '<?= site_url() ?>';
    const base_url = '<?= base_url() ?>';
    const tes = 'portal.psg.co.id/rekrutmen/'

    $("#dataTables-listTK").DataTable({
        processing: true,
        responsive: true,
        order: [],
        serverSide: true,
        // ordering: false // Menonaktifkan pengurutan
        ajax: {
            url: base_url + "PrintControl/show",
            type: "POST",
            data: function(d) {
                console.log(d);
                d.selDataFilter = $('#inputDataFilter').val();
                d.start_date = $('#start_date').val();
                d.end_date = $('#end_date').val();
                // console.log('seldatafilter : ', d.selDataFilter);

            },
            beforeSend: function() {
                $('#loading').show(); // Tampilkan loading spinner sebelum request
            },
            complete: function() {
                $('#loading').hide(); // Sembunyikan loading spinner setelah request selesai                
            }

        },
        createdRow: function(row, data, dataIndex) {
            // data[1] = HeaderID (sesuai urutan column)
            $(row).attr('data-id', data[1]);
        },
        orderMulti: false, // Hanya menyortir data di halaman saat ini
        language: {
            // url: base_url + 'assets/stexo/plugins/datatables/language/id.json',
            searchPlaceholder: "Cari..."
        },
        drawCallback: function() {
            initDatepicker();
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

    $('#inputCari').on('click', function(e) {
        e.preventDefault()
        console.log('click...');

        $("#dataTables-listTK").DataTable().ajax.reload();
    })

    function initDatepicker() {
        $('.datepick').datepicker('destroy').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            todayHighlight: true
        });
    }


    $(document).ready(function() {
        // $('.onHide').hide();
        // $('#inputDataFilter').on('change', function() {
        //     var val = $(this).val();
        //     if (val == '2') {
        //         $('.onHide').show();
        //     } else {
        //         $('.onHide').hide();
        //     }
        // });
    });
</script>