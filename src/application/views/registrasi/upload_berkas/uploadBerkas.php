<div class="page-header">
    <h1>
        REGISTRASI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            List Tenaga Kerja Baru
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <div id="loading" class="spinner-overlay">
            <div class="spinner"></div>
        </div>
        <!-- Design Disini -->
        <div class="row">
            <div class="col-xs-12">
                <!-- <div class="widget-box"> -->
                <div class="widget-header">
                    <h4 class="widget-title">List Tenaga Kerja Baru untuk Upload Document/ Berkas</h4>

                    <div class="widget-toolbar">
                        <select id="filter_status">
                            <option>-Pilih-</option>
                            <option value="tidak_lengkap">Tidak Lengkap</option>
                            <option value="minimal">Minimal Berkas</option>
                            <option value="lengkap">Berkas Lengkap</option>
                        </select>

                    </div>
                    <div class="widget-toolbar">
                        <select id="selList">
                            <option value="0">Default</option>
                            <option value="1">Surat Kontrak</option>
                        </select>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <?php if ($this->input->get('msg') == 'success_edit') {
                            echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'> <i class='ace-icon fa fa-times'></i></button>Edit data berhasil..</p>";
                        } elseif ($this->input->get('msg') == 'failed_edit') {
                            echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'> <i class='ace-icon fa fa-times'></i></button>Edit data tidak berhasil..</p>";
                        } elseif ($this->input->get('msg') == 'success_delete') {
                            echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'> <i class='ace-icon fa fa-times'></i></button>Data behasil dihapus..</p>";
                        } elseif ($this->input->get('msg') == 'failed_delete') {
                            echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'> <i class='ace-icon fa fa-times'></i></button>Data tidak behasil dihapus..</p>";
                        } ?>
                        <div class="table-responsive">
                            <table id="dataTables-listTK" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Pemborong</th>
                                        <th>Tangga Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Status</th>
                                        <th> <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By </th>
                                        <th> <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Registered Date </th>
                                        <th>do Upload</th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
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

<script type="text/javascript">
    $(document).ready(function() {
        // hidden filter berkas untuk selain pemborong
        let hidden_pemborong = <?= $hidden_pemborong ?>;
        if (hidden_pemborong == '0') {
            $("#filter_status").prop("hidden", "true");
        }


        // $('#dataTables-listTK').dataTable();
        $('[data-rel=tooltip]').tooltip();

        $("#dataTables-listTK").on("click", ".detailInfo", function() {
            let id = $(this).closest('tr').find('#headerID').val();
            $.ajax({
                url: "<?php echo site_url('UploadBerkas/detailtk'); ?>",
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

        $("#dataTables-listTK").on("click", ".berkas, .detail", function() {
            // let id = $(this).closest('tr').data('id');
            let id = $(this).closest('tr').find('#headerID').val();
            let name = $(this).data('name');
            let tk = $(this).data('tk');

            document.getElementById('titleModal').textContent = "Berkas " + name + " dari saudara, " + tk + "";
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

        // Datatable
        const site_url = '<?= site_url() ?>';
        const base_url = '<?= base_url() ?>';

        $("#dataTables-listTK").DataTable({
            processing: false,
            responsive: true,
            order: [],
            serverSide: true,
            // ordering: false // Menonaktifkan pengurutan
            ajax: {
                url: base_url + "UploadBerkas/show_upload_berkas",
                type: "POST",
                data: function(d) {
                    // console.log(d);
                    d.filter_status = $('#filter_status').val();
                    d.selList = $('#selList').val();

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
            lengthMenu: [10, 25, 50, 100],
            // Mengatur tampilan default menjadi 10
            pageLength: 10,
            rowCallback: function(row, data, index) {
                // Tambahkan kelas highlight jika inputonline === 1
                if (data.inputonline === 1) {
                    $(row).addClass('rowdetail');
                    $(row).addClass('success');
                }
            },
            columns: [{
                    data: "HdrID"
                },
                {
                    data: "Nama"
                },
                {
                    data: "Pemborong"
                },
                {
                    data: 'Tgl_Lahir',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return row.Tgl_Lahir_b; // Gunakan kolom Tgl_Lahir_b untuk tampilan
                        }
                        return data; // Tetap dalam format asli (YYYY-MM-DD) untuk sorting
                    }
                },
                {
                    data: "Jenis_Kelamin"
                },
                {
                    data: "status"
                },
                {
                    data: "RegisteredBy"
                },
                {
                    data: 'RegisteredDate',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return row.RegisteredDate_b; // Gunakan kolom Tgl_Lahir_b untuk tampilan
                        }
                        return data; // Tetap dalam format asli (YYYY-MM-DD) untuk sorting
                    }
                },
                {
                    data: "berkas"
                }
            ],

        });
        // $(document).on('change', '#inputPemborong', '')
        $('#filter_status, #selList').on('change', function(e) {
            e.preventDefault()
            $("#dataTables-listTK").DataTable().ajax.reload();
        })
    });
</script>