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
                <div class="row">
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
                            <div class="col-sm-2">
                                <label>&nbsp;</label>
                                <button id="btnReset" class="btn btn-secondary btn-sm btn-block">Reset</button>
                            </div>
                        </div>
                        <br>
                        <table id="tblsettingkrytk_" class="table table-striped table-hover  table-colored" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Dept</th>
                                    <th>Ideal TK</th>
                                    <th>Real TK</th>
                                    <th>ID Sub Jabatan</th>
                                    <th>Sub Jabatan</th>
                                    <th>Req. TK Approve</th>
                                    <th>Req. TK Pending</th>
                                    <th>Periode</th>
                                    <th>Update By</th>
                                    <th>Update Date</th>
                                    <th>ID Dept</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6" id="inputdataform">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Update Data Ideal TK</h3>
                                    </div>
                                    <div class="panel-body" id="formtk">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <form action="<?= base_url('configpermintaan/updatedatatk_') ?>" name="frmtk" id="frmtk" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                                    <input type="hidden" id="idkrrybor" name="idkrrybor">
                                                    <input type="hidden" id="txtidsubjabatan" name="txtidsubjabatan">
                                                    <div class="form-horizontal">
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Dept</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" class="form-control" id="txtdepttk" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Sub Jabatan</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" class="form-control" id="txtsubjabatan" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Jmlh. TK Real</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" class="form-control" id="txtrealtk" name="txtrealtk" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Jmlh. TK Ideal</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control" id="txtidealtk" name="txtidealtk" readonly>
                                                            </div>
                                                            <label class="col-sm-2 control-label">Update</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control" id="txtidealtks" name="txtidealtks" accept="application/pdf" required maxlength="5" value="0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-3"></div>
                                                            <div class="col-sm-9">
                                                                <button type="submit" id="btnuploadmemotk" class="btn btn-primary btn-sm">Simpan</button>
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
                </div>
            </section>
        </div>
    </div>
</div>

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
    $('#tblsettingkrytk_').DataTable().clear().destroy();
    var table = $("#tblsettingkrytk_").DataTable({
        processing: true,
        responsive: true,
        order: [],
        serverSide: true,
        // ordering: false // Menonaktifkan pengurutan
        ajax: {
            url: base_url + "Configpermintaan/show_bor",
            type: "POST",
            data: function(d) {
                console.log(d);
                d.dept = $('#filterDept').val();

            },

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
                targets: [3, 10],
                visible: false,
                searchable: false
            } // misalnya col ke-10 disembunyikan
        ]
    });
    $('#tblsettingkry_').DataTable().clear().destroy();
    var tableKry = $("#tblsettingkry_").DataTable({
        processing: true,
        responsive: true,
        order: [],
        serverSide: true,
        // ordering: false // Menonaktifkan pengurutan
        ajax: {
            url: base_url + "Configpermintaan/show_kry",
            type: "POST",
            data: function(d) {},

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
                targets: [8],
                visible: false,
                searchable: false
            } // misalnya col ke-10 disembunyikan
        ]
    });

    // Button Filter
    $('#filterDept').on('change', function() {
        table.ajax.reload();
    });

    // Button Reset
    $('#btnReset').on('click', function() {
        $('#filterDept').val('');
        // $('#filterPeriode').val('');
        table.ajax.reload();
    });

    $('#tblsettingkrytk_ tbody').on('click', 'tr', function() {
        const data = $('#tblsettingkrytk_').DataTable().row(this).data();
        $('#txtdepttk').val(data[0])
        $('#txtidealtk').val(data[1])
        $('#txtrealtk').val(data[2])
        $('#txtsubjabatan').val(data[4])
        $('#txtidsubjabatan').val(data[3])
        $('#idkrrybor').val(data[10])
        console.log(data); // termasuk kolom hidden
    });

    $('#tblsettingkry_ tbody').on('click', 'tr', function() {
        const data = $('#tblsettingkry_').DataTable().row(this).data();
        $('#txtdeptkry').val(data[0])
        $('#txtidealkry').val(data[1])
        $('#txtrealkry').val(data[2])
        $('#idkry').val(data[8])
        console.log(data); // termasuk kolom hidden
    });


    $(document).on('submit', '#frmtk', function(e) {
        e.preventDefault()
        let data = $(this).serialize();
        console.log(data);
        $.ajax({
            url: '<?= base_url() ?>Configpermintaan/updatedatatk_',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(res) {
                if (res.Err == 0) {
                    toastr.success(res.Msg, 'Success', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 5000
                    });
                } else {
                    toastr.error(res.Msg, 'Error', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 5000
                    });
                }
                table.ajax.reload();
                console.log('Response:', res);
            }
        });

    })

    $(document).on('submit', '#frmkry', function(e) {
        e.preventDefault()
        let data = $(this).serialize();
        console.log(data);
        // return
        $.ajax({
            url: '<?= base_url() ?>Configpermintaan/updatedatakry',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(res) {
                if (res.Err == 0) {
                    toastr.success(res.Msg, 'Success', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 5000
                    });
                } else {
                    toastr.error(res.Msg, 'Error', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 5000
                    });
                }
                tableKry.ajax.reload();
                console.log('Response:', res);
            }
        });

    })
</script>