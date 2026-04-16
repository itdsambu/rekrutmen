<h4 class="row header smaller lighter green">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-files-o"></i>
        Utility Permintaan Karyawan dan TK
    </span>
</h4>
<style>
    .bordering {
        border: solid 2px #1ca8c5;
        padding: 20px;
    }

    #tblsettingkrytk_ tbody tr:hover,
    #tblsettingkry_ tbody tr:hover {
        cursor: pointer;
        background-color: #f5f5f5;
        /* opsional: kasih efek highlight */
    }
</style>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="controlsetup">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Management Permintaan Karyawan dan TK</h3>
            </div>
        </div>

        <div class="panel-body">
            <section id="">
                <div class="col-sm-12">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label for="filterDept">Filter Dept</label>
                            <select id="filterDept" class="form-control">
                                <option value="">-- Semua Dept --</option>
                                <?php foreach ($data['getDept'] as $key => $value) { ?>
                                    <option value="<?= $value->DeptAbbr ?>"><?= $value->DeptAbbr ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="filter">Target</label>
                            <select id="filter" class="form-control">
                                <option value="">-- Choose --</option>
                                <?php foreach ($data['target'] as $key => $value) { ?>
                                    <option value="<?= $value->id ?>"><?= $value->jumlah ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label>&nbsp;</label>
                            <button id="btnReset" class="btn btn-secondary btn-sm btn-block">Reset</button>
                        </div>
                        <?php if ($this->session->userdata('userid') == 'KIKI') { ?>
                            <div class="col-sm-2">
                                <label>&nbsp;</label>
                                <button id="btnExport" class="btn btn-success btn-sm btn-block">Export</button>
                            </div>

                            <div class="col-xs-4">
                                <div class="widget-box">

                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div class="card shadow-lg border-0 rounded">
                                                <div class="card-header bg-primary text-white text-center">
                                                    <h4 class="mb-0">Import Data Excel</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div id="result"></div>
                                                    <br>
                                                    <style>
                                                        .custom-height {
                                                            height: 44px;
                                                            /* Sesuaikan dengan tinggi input Bootstrap 3 */
                                                            line-height: 44px;
                                                            /* Menyamakan tinggi teks dengan tombol */
                                                        }

                                                        .btn-center {
                                                            display: flex;
                                                            align-items: center;
                                                            justify-content: center;
                                                            padding: 0 15px;
                                                            /* Memberi ruang agar teks tidak terlalu mepet */
                                                        }

                                                        /* Untuk menyamakan teks di tengah input file */
                                                        #file_excel {
                                                            display: flex;
                                                            align-items: center;
                                                            text-align: center;
                                                            /* Menengahkan teks secara horizontal */
                                                        }
                                                    </style>



                                                    <form id="importForm">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <div class="input-group">
                                                                    <input type="file" class="form-control custom-height text-center" id="file_excel" name="file_excel" required style="width: 300px;">
                                                                    <span class="input-group-btn">
                                                                        <button type="submit" class="btn btn-success custom-height btn-center" id="btn-upload">
                                                                            Upload & Import
                                                                        </button>

                                                                    </span>
                                                                    <span class="input-group-btn">
                                                                        <a href="<?= base_url('assets/format-upload/FORMAT_UPLOAD_IMPORT.xlsx'); ?>" class="btn btn-warning custom-height btn-center" id="format-upload">
                                                                            Download Format Upload
                                                                        </a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <br>

                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-striped active" role="progressbar" style="width: 0%;">0%</div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        <?php } ?>
                    </div>
                    <br>
                    <table id="tblsettingkrytk_test" class="table table-striped table-hover  table-colored" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Dept</th>
                                <th>Ideal Kry/TK</th>
                                <th>Real Kar</th>
                                <th>Real TK</th>
                                <th>Total Real Kar/TK</th>
                                <th>Sub Jabatan</th>
                                <th>Target</th>
                                <th>Req. Kar Approve</th>
                                <th>Req. Kar Pending</th>
                                <th>Req. TK Approve</th>
                                <th>Req. TK Pending</th>
                                <th>Periode</th>
                                <th>Update By</th>
                                <th>Update Date</th>
                                <th>ID</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <!-- <th style="text-align:left">Grand Total:</th>
                                <th></th> -->
                                <!-- <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th> -->
                            </tr>
                        </tfoot>
                    </table>

                </div>
                <br>
                <div class="col-sm-12">
                    <div class="row">
                        <!-- ############################## KRY  TK-->
                        <div class="col-sm-6" id="inputdataform">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Update Data Ideal Kry/Tk</h3>
                                </div>
                                <div class="panel-body" id="formtk">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form action="" name="frmkry" id="frmkry" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                                <input type="hidden" id="idkry" name="idkry">
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Dept</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" id="txtdeptkry" name="txtdeptkry" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Jmlh. Kry Real</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" id="txtrealkry" name="txtrealkry" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Jmlh. Kry Ideal</label>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="txtidealkry" name="txtidealkry" readonly>
                                                        </div>
                                                        <label class="col-sm-2 control-label">Update</label>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="txtidealtkry" name="txtidealtkry" accept="application/pdf" required maxlength="5" value="0">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-3"></div>
                                                        <div class="col-sm-9">
                                                            <button type="submit" id="btnuploadmemokry" class="btn btn-primary btn-sm">Simpan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- <script src="<?= base_url() ?>assets/js/jsadd/autoNumeric.min.js"></script>
<script src="<?= base_url() ?>assets/js/jsadd/sweetalert.min.js"></script>
<script src="<?= base_url() ?>assets/js/jsadd/bootstrap-select.min.js"></script>
<script src="<?= base_url() ?>assets/js/jsadd/underscore-min.js"></script>
<script src="<?= base_url() ?>assets/js/jsadd/backbone-min.js"></script>
<script src="<?= base_url() ?>assets/js/jsadd/backdatatableserver2.js"></script> -->

<!-- Add -->
<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/jqv/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/moment.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/datetime-moment.js"></script>

<!-- Toastr -->
<script src="<?= base_url() ?>assets/js/toastr.min.js"></script>
<script>
    const site_url = '<?= site_url() ?>';
    const base_url = '<?= base_url() ?>';

    $('#tblsettingkrytk_test').DataTable().clear().destroy();
    var table_test = $("#tblsettingkrytk_test").DataTable({
        processing: true,
        responsive: true,
        order: [],
        serverSide: true,
        ajax: {
            url: base_url + "Configpermintaan/show_kry_new",
            type: "POST",
            data: function(d) {
                d.dept = $('#filterDept').val();
                d.id_bongkar = $('#filter').val();

            },

        },
        orderMulti: false, // Hanya menyortir data di halaman saat ini
        language: {
            searchPlaceholder: "Cari..."
        },
        lengthMenu: [5, 10, 25, 50, 100],
        // Mengatur tampilan default menjadi 10
        pageLength: 10,
        columnDefs: [{
                targets: [14],
                visible: false,
                searchable: false
            } // misalnya col ke-14 disembunyikan
        ]
    });



    // Button Filter
    $('#filterDept').on('change', function() {
        table_test.ajax.reload();
    });

    $('#filter').on('change', function() {
        table_test.ajax.reload();
    });

    // Button Reset
    $('#btnReset').on('click', function() {
        $('#filterDept').val('');
        $('#filter').val('');
        table_test.ajax.reload();
    });



    $('#tblsettingkrytk_test tbody').on('click', 'tr', function() {
        const data = $('#tblsettingkrytk_test').DataTable().row(this).data();
        $('#txtdeptkry').val(data[0])
        $('#txtidealkry').val(data[1])
        $('#txtrealkry').val(data[2])
        $('#idkry').val(data[14])
    });


    $(document).on('submit', '#frmkry', function(e) {
        e.preventDefault()
        let data = $(this).serialize();
        // return
        $.ajax({
            // url: '<?= base_url() ?>Configpermintaan/updatedatakry',
            url: '<?= base_url() ?>Configpermintaan/update',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(res) {
                if (res.status) {
                    toastr.success(res.message, 'Success', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 5000
                    });
                } else {
                    toastr.error(res.message, 'Error', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 5000
                    });
                }
                table_test.ajax.reload();
            }
        });

    })

    $('#btnExport').on('click', function() {
        var dept = $('#filterDept').val();
        var target = $('#filter').val();

        var url = '<?= base_url("ToExcel/exportExcel") ?>' +
            '?target=' + encodeURIComponent(target) +
            '&dept=' + encodeURIComponent(dept);
        window.open(url, '_blank');
    });


    $("#file_excel").on("change", function() {
        $("#btn-upload").prop("disabled", !this.files.length);
    });

    $("#importForm").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $(".progress").show();

        $.ajax({
            url: "<?= base_url('configpermintaan/importExcel') ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $(".progress-bar").css("width", "0%").text("0%");
            },
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                        $(".progress-bar").css("width", percentComplete + "%").text(percentComplete + "%");
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                $("#result").html(response);
                $(".progress-bar").css("width", "100%").text("100%");
                $("#list-imported-tk-table").DataTable().ajax.reload()
            },
            error: function() {
                alert("Gagal mengupload file!");
                $(".progress-bar").css("width", "0%").text("0%");

            }
        });
    });
</script>