<style>
    #loading {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 20px;
        color: #000;
        z-index: 9999;
    }

    .spinner-overlay {
        display: none;
        position: absolute;
        top: 80%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(255, 255, 255, 0.8);
        border-radius: 10px;
        padding: 20px;
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        border: 12px solid #f3f3f3;
        /* Light grey */
        border-top: 12px solid #3498db;
        /* Blue */
        border-radius: 50%;
        width: 80px;
        height: 80px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<?php
// Tanggal 1 bulan sebelum awal bulan ini
$startDate = date('d-m-Y', strtotime('-1 months', strtotime(date('Y-m-01'))));

// Tanggal akhir bulan sekarang
$endDate = date('d-m-Y', strtotime('last day of this month'));
?>
<div class="page-header">
    <h1>
        REGISTRASI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Verifikasi Calon Tenaga Kerja
        </small>
    </h1>
</div>
<!-- /.page-header -->
<?php if ($this->input->get('msg') == 'ok') {
    echo "<p class='alert alert-info'>Password berhasil dirubah..</p>";
} elseif ($this->input->get('msg') == 'notMacth') {
    echo "<p class='alert alert-danger'>Password lama anda tidak sesuai..</p>";
} elseif ($this->input->get('msg') == 'success_edit') {
    echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'> <i class='ace-icon fa fa-times'></i></button>Edit data berhasil..</p>";
} elseif ($this->input->get('msg') == 'failed_edit') {
    echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'> <i class='ace-icon fa fa-times'></i></button>Edit data tidak berhasil..</p>";
} elseif ($this->input->get('msg') == 'success_delete') {
    echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'> <i class='ace-icon fa fa-times'></i></button>Data behasil dihapus..</p>";
} elseif ($this->input->get('msg') == 'failed_delete') {
    echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'> <i class='ace-icon fa fa-times'></i></button>Data tidak behasil dihapus..</p>";
} elseif ($this->input->get('msg') == 'success_add') {
    echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'> <i class='ace-icon fa fa-times'></i></button>Data user behasil ditambahkan..</p>";
} elseif ($this->input->get('msg') == 'success_add_komentar') {
    echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'> <i class='ace-icon fa fa-times'></i></button>Catatan user behasil ditambahkan..</p>";
} else {
    echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'> <i class='ace-icon fa fa-times'></i></button><strong>Warning!!</strong> Sebelum <b>VERIFIKASI</b> Tenaga Kerja, diharapkan cek data <b>BLACKLIST</b><br>";
} ?>
<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-xs-12">
                            <form class="form-horizontal" id="form_cari_data" role="form" method="POST" action="<?php echo base_url('verifikasi/index'); ?>">

                                <br>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right">Periode</label>
                                            <div class="col-sm-8">
                                                <div class="input-daterange input-group">
                                                    <input type="text" class="input-sm form-control datepick" id="start_date" name="start_date" value="<?= $startDate ?>">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-exchange"></i>
                                                    </span>
                                                    <input type="text" class="input-sm form-control datepick" id="end_date" name="end_date" value="<?= $endDate ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right">Filter Data</label>
                                            <div class="col-sm-8">
                                                <select name="selDataFilter" id="inputDataFilter" class="form-control input-sm on_cari_data">
                                                    <option value="0">Semua Data</option>
                                                    <option value="1">Berkas Lengkap</option>
                                                    <option value="2">Minimal Berkas</option>
                                                    <option value="3">Tidak Lengkap</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right">No. Reg</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="txtNoreg" id="inputNoreg" class="form-control input-sm" autocomplete="off" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right">Nama</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="txtNama" id="inputNama" class="form-control input-sm" autocomplete="off" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right">Pemborong</label>
                                            <div class="col-sm-8">
                                                <input name="txtPemborong" id="inputPemborong" type="text" class="form-control input-sm" autocomplete="off" value="" />
                                                <ul class="dropdown-menu txtpemborong" style="margin-left:15px;margin-right:0px;" role="menu" aria-labelledby="dropdownMenu" id="DropdownPemborong"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-8 right">
                                                <input type="button" name="btnCari" id="inputCari" value="Refresh" class="btn btn-mini btn-block btn-round btn-info" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php $att = array('class' => 'form-horizontal', 'role' => 'form');
                        echo form_open('verifikasi/verifiAksi', $att);
                        ?>
                        <div id="data" class="col-xs-12 table-responsive">
                            <table id="myTable" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <label class="pos-rel">
                                                <input type="checkbox" class="ace">
                                                <span class="lbl"></span>
                                            </label>
                                        </th>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Pemborong</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Pendidikan</th>
                                        <th>Status</th>
                                        <th>Berkas</th>
                                        <th><i class="ace-icon fa fa-user bigger-100 hidden-480"></i> Register By</th>
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
            <div class="widget-toolbox padding-8 clearfix">
                <div class="well text-center">
                    <input type="submit" name="Verifi" value="Submit" class="btn btn-success">
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
<div id="loading" class="spinner-overlay">
    <div class="spinner"></div>
</div>

<!-- js group -->
<script>
    $(document).ready(function() {
        const site_url = '<?= site_url() ?>';
        const base_url = '<?= base_url() ?>';

        console.log('st :', $('#start_date').attr('value'));

        $("#myTable").DataTable({
            processing: false,
            responsive: true,
            order: [],
            serverSide: true,
            ajax: {
                url: site_url + "verifikasi/show",
                type: "POST",
                data: function(d) {
                    d.headerid = $('#inputNoreg').val();
                    d.selDataFilter = $('#inputDataFilter option:selected').val();
                    d.inputNama = $('#inputNama').val();
                    d.inputPemborong = $('#inputPemborong').val();
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
                searchPlaceholder: "Masukkan kata kunci"
            },
            lengthMenu: [5, 10, 25, 50, 100],
            pageLength: 10,
            columnDefs: [{
                orderable: false,
                targets: [0, 7, 8, 9, 10]
            }]
        });

        $('#inputCari').on('click', function(e) {
            console.log('klik');

            e.preventDefault()
            $("#myTable").DataTable().ajax.reload();
        })
    })

    // $('.on_cari_data').change(function() {
    //     $('#form_cari_data').submit();
    // });

    $('.ke_page').click(function() {
        $('.page_aktif').val($(this).text());
        $('#form_cari_data').submit();
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#myTable').dataTable();
        $('[data-rel=tooltip]').tooltip();

        $("#myTable").on("click", ".detail", function() {
            // var id = $(this).closest('tr').data('id');
            var id = $(this).attr('value');
            console.log('id :', id);

            $.ajax({
                url: "<?php echo site_url('verifikasi/detailtk'); ?>",
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

        $("#myTable").on("click", ".berkas", function() {
            // let id = $(this).closest('tr').data('id');
            let id = $(this).data('id');
            let name = $(this).data('name');
            let tk = $(this).data('tk');

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

        let active_class = 'active';
        $('#myTable > thead > tr > th input[type=checkbox]').eq(0).on('click', function() {
            let th_checked = this.checked; //checkbox inside "TH" table header
            $(this).closest('table').find('tbody > tr').each(function() {
                let row = this;
                if (th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
            });
        });
    });
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" />

<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-timepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/moment.js"></script>

<script type="text/javascript">
    jQuery(function($) {
        $('.input-daterange').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    });
</script>