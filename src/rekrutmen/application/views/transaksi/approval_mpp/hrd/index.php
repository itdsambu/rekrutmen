<h4 class="row header smaller lighter green">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-files-o"></i>
        Approval MPP HRD
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

    .modal-xxl {
        width: 95%;
        max-width: 1600px;
        /* bebas, bisa 1400–1800 */
    }

    .modal-full {
        width: 100%;
        margin: 10px;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-list"></i> Approval MPP HRD

                </h3>
            </div>
            <div class="panel-body">
                <!-- Filter Section -->
                <div class="row" style="margin-bottom:15px;">
                    <!-- <div class="col-md-3">
                        <label>Filter Status</label>
                        <select id="filterStatus" class="form-control">
                            <option value="">-- Semua Status --</option>
                            <option value="0">Draft</option>
                            <option value="1">Submitted</option>
                            <option value="2">Approved</option>
                            <option value="3">Rejected</option>
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
                    </div> -->
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
                            <th width="30">
                                <label class="pos-rel">
                                    <input type="checkbox" id="checkAll" class="ace">
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            <th>No. Pengajuan</th>
                            <th>Divisi</th>
                            <th>Departemen</th>
                            <th>Jabatan</th>
                            <th>Tipe</th>
                            <th>Sifat</th>
                            <!-- <th>Status</th> -->
                            <th>Approval Pimpinan Dept</th>
                            <th>Approval Divisi</th>
                            <th>Approval HRD</th>
                            <th>Tanggal</th>
                            <th>Dibuat Oleh</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <br>
                <button id="btnApprove" class="btn btn-success bt-2"><i class="fa fa-check"></i> Approve All</button>
                <button id="btnDisapprove" class="btn btn-danger bt-2"><i class="fa fa-times"></i> Disapprove All</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal View -->

<div class="modal fade" id="viewModalApproval" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xxl">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Approval HRD by <strong class="green"><?php echo $this->session->userdata('username'); ?></strong></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="approval" class="well">
                    <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal View-->

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
            url: base_url + 'approval_mpp/show_app_hrd',
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

    $("#tblPerubahanMPP").on("click", ".approval-btn", function() {
        let id = $(this).data('id');

        $.ajax({
            url: "<?php echo site_url('approval_mpp/viewApprovalHrd'); ?>",
            type: "POST",
            data: "kode=" + id,
            datatype: "json",
            cache: false,
            success: function(msg) {
                $("#approval").html(msg);
            }
        });
        $("#viewModalApproval").modal("show");
    });

    $(document).on('submit', '#approvalForm', function(e) {
        e.preventDefault();

        var formData = $(this).serialize();
        $.ajax({
            url: '<?= base_url("approval_mpp/approve_hrd") ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(res) {
                if (res.status) {
                    toastr.success('Approval berhasil');
                    $('#viewModalApproval').find('button').blur();
                    $('#viewModalApproval').modal('hide');
                } else {
                    toastr.error(res.message);
                }

                table.ajax.reload();
            },
            error: function() {
                toastr.error('Terjadi kesalahan');
            }
        });
    })

    // CHECK ALL → CHECK / UNCHECK SEMUA ROW
    $(document).on('change', '#checkAll', function() {
        var isChecked = this.checked;
        $('tbody .checkRow').each(function() {
            this.checked = isChecked;
        });
    });

    // ROW → KONTROL CHECK ALL
    $(document).on('change', 'tbody .checkRow', function() {
        var total = $('tbody .checkRow').length;
        var checked = $('tbody .checkRow:checked').length;

        var checkAll = $('#checkAll').get(0);

        if (checked === 0) {
            checkAll.checked = false;
            checkAll.indeterminate = false;
        } else if (checked === total) {
            checkAll.checked = true;
            checkAll.indeterminate = false;
        } else {
            checkAll.checked = false;
            checkAll.indeterminate = true;
        }
    });


    $(document).on('click', '#btnApprove', function() {

        var ids = $('.checkRow:checked').map(function() {
            return $(this).val();
        }).get();

        if (ids.length === 0) {
            Swal.fire('Peringatan', 'Silakan pilih data yang ingin di Approve', 'warning');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin approve data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Ya, Approve!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + 'approval_mpp/approve_all_hrd',
                    type: 'POST',
                    data: {
                        ids: ids
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status) {
                            Swal.fire('Berhasil!', res.message, 'success');
                            table.ajax.reload(null, false);
                        } else {
                            Swal.fire('Gagal!', res.message, 'error');
                        }
                    }
                });
            }
        });
    });

    $(document).on('click', '#btnDisapprove', function() {

        var ids = $('.checkRow:checked').map(function() {
            return $(this).val();
        }).get();

        if (ids.length === 0) {
            Swal.fire('Peringatan', 'Silakan pilih data yang ingin di Disapprove', 'warning');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin disapprove data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Ya, Disapprove!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + 'approval_mpp/disapprove_all_hrd',
                    type: 'POST',
                    data: {
                        ids: ids
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status) {
                            Swal.fire('Berhasil!', res.message, 'success');
                            table.ajax.reload(null, false);
                        } else {
                            Swal.fire('Gagal!', res.message, 'error');
                        }
                    }
                });
            }
        });
    });
</script>