<h4 class="row header smaller lighter green">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-files-o"></i>
        Daftar Pengajuan Perubahan MPP
    </span>
</h4>

<style>
    .summary-card {
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        color: #fff;
    }

    .summary-card.draft {
        background: linear-gradient(135deg, #6c757d, #495057);
    }

    .summary-card.submitted {
        background: linear-gradient(135deg, #ffc107, #e0a800);
        color: #333;
    }

    .summary-card.approved {
        background: linear-gradient(135deg, #28a745, #1e7e34);
    }

    .summary-card.rejected {
        background: linear-gradient(135deg, #dc3545, #c82333);
    }

    .summary-card h2 {
        margin: 0;
        font-size: 32px;
        font-weight: bold;
    }

    .summary-card p {
        margin: 5px 0 0 0;
        opacity: 0.9;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-list"></i> Daftar Pengajuan
                    <a href="<?= base_url('perubahanmpp/create') ?>" class="btn btn-success btn-sm pull-right">
                        <i class="fa fa-plus"></i> Buat Pengajuan Baru
                    </a>
                </h3>
            </div>
            <div class="panel-body">
                <!-- Filter Section -->
                <div class="row" style="margin-bottom:15px;">
                    <div class="col-md-3">
                        <label>Filter Status</label>
                        <select id="filterStatus" class="form-control">
                            <option value="">-- Semua Status --</option>
                            <option value="0">Draft</option>
                            <option value="1">Submitted</option>
                            <option value="6">Pending</option>
                            <option value="2">Approved</option>
                            <option value="5">Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Filter Departemen</label>
                        <select id="filterDept" class="form-control" data-live-search="true">
                            <option value="">-- Semua Dept --</option>
                            <?php if (isset($getDept)) foreach ($getDept as $row) { ?>
                                <option value="<?= $row->deptabbr ?>"><?= $row->deptabbr ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Dari Tanggal</label>
                        <input type="date" id="startDate" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label>Sampai Tanggal</label>
                        <input type="date" id="endDate" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <div>
                            <button id="btnFilter" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Filter</button>
                            <button id="btnReset" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Reset</button>
                        </div>
                    </div>
                </div>

                <hr>

                <table id="tblPerubahanMPP" class="table table-striped table-hover table-bordered" style="width:100%;">
                    <thead>
                        <tr>
                            <th width="30">No</th>
                            <th width="100">Aksi</th>
                            <th>No. Pengajuan</th>
                            <th>Divisi</th>
                            <th>Departemen</th>
                            <th>Jabatan</th>
                            <th>Tipe</th>
                            <th>Sifat</th>
                            <th>Status</th>
                            <th>Approval Pimpinan Dept</th>
                            <th>Approval Divisi</th>
                            <th>Approval HRD</th>
                            <th>Tanggal</th>
                            <th>Dibuat Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="<?= base_url() ?>assets/js/toastr.min.js"></script>
<script src="<?= base_url() ?>assets/jsadd/sweetalert.min.js"></script>

<script>
    const base_url = '<?= base_url() ?>';

    var table = $('#tblPerubahanMPP').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [],
        ajax: {
            url: base_url + 'perubahanmpp/show',
            type: 'POST',
            data: function(d) {
                d.filter_status = $('#filterStatus').val();
                d.filter_dept = $('#filterDept').val();
                d.start_date = $('#startDate').val();
                d.end_date = $('#endDate').val();
            }
        },
        language: {
            searchPlaceholder: "Cari...",
            processing: '<i class="fa fa-spinner fa-spin fa-2x"></i>',
            emptyTable: "Tidak ada data",
            zeroRecords: "Tidak ada data yang cocok"
        },
        lengthMenu: [10, 25, 50, 100],
        pageLength: 10,
        columnDefs: [{
            targets: [0, 1],
            orderable: false
        }]
    });

    $('#btnFilter').on('click', function() {
        table.ajax.reload();
    });

    $('#btnReset').on('click', function() {
        $('#filterStatus, #filterDept, #startDate, #endDate').val('');
        if ($.fn.selectpicker) $('#filterDept').selectpicker('refresh');
        table.ajax.reload();
    });



    function deleteData(id) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menghapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + 'perubahanmpp/delete',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.Err == 0) {
                            Swal.fire('Berhasil!', res.Msg, 'success');
                            table.ajax.reload(null, false);
                        } else {
                            Swal.fire('Gagal!', res.Msg, 'error');
                        }
                    }
                });
            }
        });
    }
</script>