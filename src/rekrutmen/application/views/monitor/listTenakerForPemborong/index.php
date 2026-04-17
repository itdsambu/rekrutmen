<?php
/* 
 * Author : Tengku
 */

$idpemborong = $this->session->userdata('idpemborong');
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
                            <h4 class="widget-title">List Tenaga Kerja</h4>
                        </div>

                        <div class="col-md-4">
                            <!-- <form class="form-horizontal" style="margin-top: 3px;" id="form_cari_data" role="form" method="POST" action="<?php echo base_url('monitor/viewListByPBR'); ?>">

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-6">
                                        <select class="form-control on_cari_data" name="selTenaker" id="selTenaker">
                                            <option value="all">All (Semua)</option>
                                            <?php if ($idpemborong == 0) { ?>
                                                <option value="proses_all">Proses All</option>
                                            <?php } ?>
                                            <option value="proses">Proses</option>
                                            <option value="belum_bisa_proses">Belum bisa proses</option>
                                            <option value="interview">Interview</option>
                                            <option value="mcu">MCU</option>
                                            <option value="blacklist"><?= $idpemborong > 0 ? 'Tidak Lulus Screening' : 'Blacklist' ?></option>
                                            <option value="id_lama">ID LAMA</option>
                                        </select>
                                    </div>
                                </div>

                            </form> -->
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

                    </div>
                    <!-- <div class="col-sm-4 onHide">
                        <h4>Tanggal</h4>
                    </div>
                    <div class="col-sm-3 onHide">
                        <div class="input-daterange input-group">
                            <input type="text" class="input-sm form-control datepick tanggal" id="tanggal" name="tanggal" value="<?= date('d-m-Y') ?>" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 onHide">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8 right">
                                <input type="submit" name="btnCari" id="inputCari" value="Refresh" class="btn btn-mini btn-block btn-round btn-info" />
                            </div>
                        </div>
                    </div> -->



                    <div id="loading" class="spinner-overlay">
                        <div class="spinner"></div>
                    </div>

                    <div class="row warning">
                        <div class="col-md-12">
                            <div class="alert alert-warning text-center">
                                <h5 class="uppercase"><strong>MOHON UNTUK TIDAK DIDAFTARKAN KEMBALI APABILA INGIN MENDAFTAR SILAHKAN INPUT ULANG !!</strong></h5>
                            </div>
                        </div>
                    </div>


                    <div class="widget-body">
                        <div class="widget-main">

                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="selTenaker">-Pilih Kategori-</label>
                                        <select class="form-control on_cari_data" name="selTenaker" id="selTenaker">
                                            <option value="all">All (Semua)</option>
                                            <?php if ($idpemborong == 0) { ?>
                                                <option value="proses_all">Proses All</option>
                                            <?php } ?>
                                            <option value="proses">Proses</option>
                                            <option value="belum_bisa_proses">Belum bisa proses</option>
                                            <option value="interview">Interview</option>
                                            <option value="mcu">MCU</option>
                                            <option value="blacklist"><?= $idpemborong > 0 ? 'Tidak Lulus Screening' : 'Blacklist' ?></option>
                                            <option value="id_lama">ID LAMA</option>
                                        </select>
                                    </div>
                                    <div class="form-group onHide">
                                        <label for="tanggal">Tanggal</label>
                                        <input type="text" class="form-control datepick tanggal" id="tanggal" name="tanggal" autocomplete="off">
                                    </div>
                                    <input type="button" name="btnCari" id="inputCari" value="Refresh" class="btn btn-info onHide" style="width: 100%;" />
                                </div>
                            </div>
                            <br>


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
                                            <th rowspan="2">Hasil MCU</th>
                                            <th rowspan="2">Print Hasil MCU</th>
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
        const site_url = '<?= site_url() ?>';
        const base_url = '<?= base_url() ?>';

        // $('#dataTables-listTK').dataTable({
        //     "order": [0, 'desc']
        // });

        // $('.on_cari_data').change(function() {
        //     $('#form_cari_data').submit();
        // });

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
            var id = $(this).closest('tr').find('#headerID').val();
            console.log('iiini :', id);
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
            var id = $(this).closest('tr').find('#headerID').val();
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


        console.log(site_url + "monitor/show_list_for_pbr");
        $("#dataTables-listTK").DataTable({
            processing: false,
            responsive: true,
            order: [],
            serverSide: true,
            ajax: {
                // url: site_url + "monitor/show_list_for_pbr",
                url: base_url + "monitor/show_list_for_pbr",
                type: "POST",
                data: function(d) {
                    d.selTenaker = $('#selTenaker').val()
                    d.tanggal = $('#tanggal').val()
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
            lengthMenu: [5, 10, 25, 50, 100],
            // Mengatur tampilan default menjadi 10
            pageLength: 10,
        });
        // $("#dataTables-listTK").DataTable({
        //     processing: false,
        //     responsive: true,
        //     order: [],
        //     serverSide: true,
        //     ajax: {
        //         url: "<?php echo site_url('monitor/show_list_for_pbr'); ?>",
        //         // url: site_url + "monitor/show_list_for_pbr",
        //         type: "POST",
        //         datatype: "json",
        //         data: {
        //             selTenaker: $('#selTenaker').val(),
        //             tanggal: $('#tanggal').val()
        //         },
        //         beforeSend: function() {
        //             $('#loading').show();
        //         },
        //         complete: function() {
        //             $('#loading').hide();
        //         },
        //         error: function(xhr, error, thrown) {
        //             console.log("AJAX Error:", error, thrown);
        //             console.log("Response Text:", xhr.responseText);
        //             alert("Terjadi kesalahan saat mengambil data!");
        //         }
        //     }
        // });



        $('.warning').hide()
        $('.onHide').hide()
        $(document).on('change', '#selTenaker', function(e) {
            e.preventDefault()
            $('#tanggal').val('')
            $("#dataTables-listTK").DataTable().ajax.reload()

            if ($(this).val() == 'id_lama') {
                $('.warning').show()
            } else {
                $('.warning').hide()
            }

            if ($(this).val() == 'proses_all' || $(this).val() == 'all') {
                $('.onHide').hide()
            } else {
                $('.onHide').show()
            }

        })

        $(document).on('click', '#inputCari', function() {
            $("#dataTables-listTK").DataTable().ajax.reload()
        })


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

    $(document).on('click', '.reschedule', function() {
        var id = $(this).closest('tr').find('#headerID').val()
        console.log(id);

        // var x = confirm('Kembalikan ?')

        Swal.fire({
            title: "Anda yakin ?",
            text: "Kembalikan ke Process to MCU ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Kembalikan!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo site_url('monitor/sendToMCU'); ?>",
                    type: "POST",
                    datatype: "json",
                    data: {
                        id
                    },
                    success: function(msg) {
                        $("#dataTables-listTK").DataTable().ajax.reload()
                        console.log(msg);
                    },
                    error: function(e, error) {
                        console.log(error);
                    }
                })

            }
        });

    })
</script>