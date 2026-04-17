<?php
/* 
 * Author : Ismo___
 */
?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/toExcel/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/toExcel/jquery.battatech.excelexport.js"></script>
<style>
    .top-right {
        float: right;
        margin-bottom: 10px;
    }
</style>

<div id="loading" class="spinner-overlay">
    <div class="spinner"></div>
</div>
<div class="page-header">
    <h1>
        MONITOR
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Belum di Screening oleh HRD
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
                        <!-- <h4 class="widget-title">List Calon Tenaga Kerja</h4> -->

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                        </div>
                        <div class="widget-toolbar no-border">
                            <!-- <span>
                                <button class="btn btn-minier btn-success" id="btnExport">
                                    <i class="ace-icon fa fa-file-excel-o"></i> Export to Excel
                                </button>
                            </span> -->
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">



                            <div id="data" class="table table-responsive">

                                <!-- <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="selTenaker"></label>
                                            <select class="form-control on_cari_data" name="selTenaker" id="selTenaker">
                                                <option value="all">All (Semua)</option>
                                                <option value="verifi">Unverified</option>
                                                <option value="interview">Interview</option>
                                                <option value="identifi">Belum Identifikasi</option>
                                                <option value="belumposting">Belum Posting</option>
                                                <option value="mcu">MCU</option>
                                                <option value="closed">Closed</option>
                                            </select>
                                        </div>
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
                                        
                                    </div>
                                </div> -->
                                <br>

                                <table id="dataTables-listTK" class="toExcel table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <!-- <th class="text-center">
                                                <label class="pos-rel">
                                                    <input type="checkbox" class="ace chk_all">
                                                    <span class="lbl"></span>
                                                </label>
                                            </th> -->
                                            <th>ID</th>
                                            <th>Dept Tujuan</th>
                                            <th>Nama</th>
                                            <th>Pemborong</th>
                                            <th>Sub Pemborong</th>
                                            <th>Tangga Lahir</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Record Interview</th>
                                            <th>
                                                <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By
                                            </th>
                                            <th>
                                                Tgl. Proses by HRD
                                            </th>
                                            <th>
                                                Tgl. Jadwal Interview
                                            </th>
                                            <th>Opsi</th>

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

        var table = $("#dataTables-listTK").DataTable({
            processing: false,
            responsive: true,
            order: [],
            serverSide: true,
            // ordering: false // Menonaktifkan pengurutan
            ajax: {
                url: base_url + "monitor/show_unscreening_by_hrd",
                type: "POST",
                data: function(d) {
                    d.selTenaker = $('#selTenaker').val();
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
            orderMulti: false, // Hanya menyortir data di halaman saat ini
            language: {
                // url: base_url + 'assets/stexo/plugins/datatables/language/id.json',
                searchPlaceholder: "Cari..."
            },
            lengthMenu: [5, 10, 25, 41, 50, 100],
            // Mengatur tampilan default menjadi 10
            pageLength: 10,
            // dom: 'Bfrtip<"top-right"l>',

            buttons: [{
                extend: 'excelHtml5',
                title: 'Data Export',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 10] // Specify the columns you want to export
                },
            }],
            columnDefs: [{
                    type: 'date-eu',
                    targets: 4
                }, // Mengatur kolom indeks ke-4 (indeks dimulai dari 0) sebagai tipe data tanggal
                {
                    type: 'date-eu',
                    targets: 9
                }, {
                    type: 'date-eu',
                    targets: 10
                }, // Mengatur kolom indeks ke-4 (indeks dimulai dari 0) sebagai tipe data tanggal
                {
                    targets: 0, // indeks kolom pertama
                    orderable: false // membuat kolom pertama tidak dapat diurutkan
                }
            ]
        });

        // Fungsi untuk mengekspor data ke Excel
        $('#btnExport').on('click', function() {
            table.button('.buttons-excel').trigger();
        });




        $(document).on('change', '.cancel', function() {
            var opt = $(this).val()
            var id = $(this).closest('tr').find('.chkPosting').val()
            var pemborong = $(this).closest('tr').find('#pemborong').val()

            if (opt == 1) {
                var msg = 'Anda yakin akan blacklist data ini selama 3 bulan ?'
            } else {
                var msg = 'Kirim kembali ke DAFTAR CTKB ?'
            }
            console.log(id);
            if (id != '' && opt != '' && pemborong != '') {
                Swal.fire({
                    title: 'Anda Yakin?',
                    text: msg,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Update!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log('update...');
                        updateStatusCancel(id, opt, pemborong)
                    }
                })
            }

        })

        function updateStatusCancel(id, opt, pemborong) {
            $.ajax({
                url: "<?php echo site_url('monitor/updateStatusCancel'); ?>",
                type: "POST",
                data: {
                    id,
                    opt,
                    pemborong
                },
                dataType: "json",
                success: function(msg) {
                    // var msg = JSON.parse(msg)
                    console.log(msg.status);
                    if (msg.status === 200) {
                        Swal.fire(
                            'Berhasil',
                            'Data Berhasil diupdate!',
                            'success'
                        )
                        setTimeout(() => {
                            swal.close();
                            $("#dataTables-listTK").DataTable().ajax.reload()
                        }, 2000)
                    } else {
                        Swal.fire(
                            'Gagal',
                            'Data Gagal diupdate!',
                            'danger'
                        )
                    }
                }
            });
        }


        $(document).on('click', '#inputCari', function(e) {
            e.preventDefault()
            $("#dataTables-listTK").DataTable().ajax.reload()
        })
    })


    jQuery(function($) {
        $('.datepick').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    });

    $(document).ready(function() {
        // $('#dataTables-listTK').dataTable();

        // $("#btnExport").click(function() {
        //     $("#tblExport").battatech_excelexport({
        //         containerid: "exportToExcel",
        //         // containerid: "dataTables-listTK",
        //         datatype: 'table'
        //     });
        // });



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

        // $("#btnExport").click(function() {
        //     var select = document.getElementById('select').value;
        //     $.ajax({
        //         url: "<?php echo site_url('monitor/toExcel'); ?>",
        //         type: "POST",
        //         data: "select=" + select,
        //         datatype: "json",
        //         cache: false,
        //         success: function(msg) {
        //             $("#showTable").html(msg);
        //         }
        //     });
        //     document.getElementById('titleModal').innerHTML = select;
        //     $("#modalToExcel").modal("show");
        // });

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

        $("#dataTables-listTK").on("click", ".detailInfo", function() {
            var id = $(this).closest('tr').find('.headerID').val();
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
    });
</script>
<script type="text/javascript">
    // $(document).ready(function() {
    //     $(document).on('change', '#end_date', function() {
    //         let datez = $(".end_date").val()
    //         let datea = $(".start_date").val();
    //         let selTenaker = $("#selTenaker").val();
    //         console.log(datea);
    //         $.ajax({
    //             type: "POST",
    //             // dataType: 'json',
    //             url: "<?= site_url('monitor/selectViewTanggal')  ?>",
    //             data: {
    //                 datea,
    //                 datez,
    //             },
    //             success: function(data) {
    //                 $('#data').html(data);
    //                 // $('#selTenaker').val(selTenaker).trigger('change')
    //             }
    //         })

    //     })
    // })
    // $("#end_date").change(function() {

    // })
</script>

<!-- js group -->
<script>
    // $('.on_cari_data').change(function() {
    //     $('#form_cari_data').submit();
    // });

    $('.ke_page').click(function() {
        $('.page_aktif').val($(this).text());
        $('#form_cari_data').submit();
    });

    var urlSaveKualifikasi = '<?= base_url() ?>Monitor/updateKualifikasi';

    // $(document).ready(function() {

    // });
    $(document).on('click', '.simpan', function() {

        var kualifikasi = $(this).closest('tr').find('.kualifikasi').val()
        var headerID = $(this).closest('tr').find('.chkPosting').val().trim()
        console.log(headerID);
        return
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
    // $('.simpan').click(function(event) {
    //     alert(123)
    //     var kualifikasi = $(this).closest('tr').find('.kualifikasi').val()
    //     var headerID = $(this).closest('tr').find('.headerid').text()
    //     console.log(headerID);
    //     return
    //     $.ajax({
    //         type: "POST",
    //         url: urlSaveKualifikasi,
    //         dataType: 'json',
    //         data: {
    //             headerID,
    //             kualifikasi
    //         },
    //         success: function(data) {
    //             console.log(data);
    //             Swal.fire(
    //                 data.msg,
    //                 'Data ' + data.msg + ' disimpan!',
    //                 data.type
    //             )
    //         }
    //     });

    // });

    $(document).on('click', '.chk_all', function() {
        if (this.checked) {
            $('.chkPosting').prop('checked', true)
        } else {
            $('.chkPosting').prop('checked', false)
        }

    })

    // Update proses (kembalikan TK ke Registrasi CTKB)
    $(document).on('click', '.btnKirim', function() {
        Swal.fire({
            title: 'Anda Yakin?',
            text: "Anda yakin ingin mengirim data ini ke Registrasi CTKB!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kirim!'
        }).then((result) => {
            if (result.isConfirmed) {
                sendToRegister()
            }
        })
    })
    // 


    $(document).on('click', '.btnKirimTransaksi', function() {
        Swal.fire({
            title: 'Anda Yakin?',
            text: "Anda yakin ingin mengirim data ini ke Transaksi Proses?!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kirim!'
        }).then((result) => {
            if (result.isConfirmed) {
                sendToTransaksi()
            }
        })

    });


    function sendToRegister() {
        var url = '<?= base_url() ?>Monitor/sendToRegister';
        var headerID = []

        $('#dataTables-listTK .chkPosting').each(function(i, e) {
            if ($(this).is(':checked')) {
                headerID.push($(this).val())
            }
        })
        if (headerID.length === 0) {
            Swal.fire(
                'Gagal!',
                'Tidak ada data yang di pilih !!!',
                'warning'
            )
            return
        }
        console.log(headerID);
        // return // matikan dulu ok
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {
                headerID,
            },
            success: function(data) {
                console.log(data.msg);
                Swal.fire(
                    data.msg,
                    'Data ' + data.msg + ' dikembalikan ke Registrasi CTKB!',
                    data.type
                ).then((result) => {
                    if (result.isConfirmed) {
                        // location.reload();
                        $("#dataTables-listTK").DataTable().ajax.reload()
                    }
                })
            }
        });
    }

    function sendToTransaksi() {
        var url = '<?= base_url() ?>Monitor/sendToTransaksi';
        var headerID = []

        $('#dataTables-listTK .chkPosting').each(function(i, e) {
            if ($(this).is(':checked')) {
                headerID.push($(this).val())

            }
        })
        if (headerID.length === 0) {
            Swal.fire(
                'Gagal!',
                'Tidak ada data yang di pilih !!!',
                'warning'
            )
            return
        }
        console.log(headerID);
        // return // matikan dulu ok
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {
                headerID,
            },
            success: function(data) {
                console.log(data.msg);
                Swal.fire(
                    data.msg,
                    'Data ' + data.msg + ' dikembalikan ke Transaksi Proses!',
                    data.type
                ).then((result) => {
                    if (result.isConfirmed) {
                        // location.reload();
                        $("#dataTables-listTK").DataTable().ajax.reload()

                    }
                })
            }
        });
    }
</script>