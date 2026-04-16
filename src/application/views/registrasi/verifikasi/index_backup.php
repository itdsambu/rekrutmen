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
                                <input type="hidden" class="input-sm form-control page_aktif" name="page_aktif" value="<?= $page_aktif ?>">
                                <br>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right">Periode</label>
                                            <div class="col-sm-8">
                                                <div class="input-daterange input-group">
                                                    <input type="text" class="input-sm form-control datepick" name="start_date" value="<?= date('d-m-Y',  strtotime($start_date)) ?? '' ?>">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-exchange"></i>
                                                    </span>
                                                    <input type="text" class="input-sm form-control datepick" name="end_date" value="<?= date('d-m-Y',  strtotime($end_date)) ?? '' ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right">Filter Data</label>
                                            <div class="col-sm-8">
                                                <select name="selDataFilter" id="inputDataFilter" class="form-control input-sm on_cari_data">
                                                    <option value="0" <?= $selDataFilter == 0 ? 'selected' : '' ?>>Semua Data</option>
                                                    <option value="1" <?= $selDataFilter == 1 ? 'selected' : '' ?>>Berkas Lengkap</option>
                                                    <option value="2" <?= $selDataFilter == 2 ? 'selected' : '' ?>>Minimal Berkas</option>
                                                    <option value="3" <?= $selDataFilter == 3 ? 'selected' : '' ?>>Tidak Lengkap</option>
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
                                                <input type="number" name="txtNoreg" id="inputNoreg" class="form-control input-sm" autocomplete="off" value="<?= $noreg ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right">Nama</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="txtNama" id="inputNama" class="form-control input-sm" autocomplete="off" value="<?= $nama ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right">Pemborong</label>
                                            <div class="col-sm-8">
                                                <input name="txtPemborong" id="inputPemborong" type="text" class="form-control input-sm" autocomplete="off" value="<?= $pemborong ?>" />
                                                <ul class="dropdown-menu txtpemborong" style="margin-left:15px;margin-right:0px;" role="menu" aria-labelledby="dropdownMenu" id="DropdownPemborong"></ul>
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
                                    <?php if ($_selectWhere == NULL) {
                                        echo '<tr><td colspan="11" class="center">Not select data</td></tr>';
                                    } else { ?>
                                        <?php foreach ($_selectWhere as $row) : ?>
                                            <tr class="info" data-id="<?php echo $row->HeaderID ?>">
                                                <td class="text-center">
                                                    <div class="checkbox">
                                                        <label class="pos-rel">
                                                            <input type="checkbox" name="checkVerifi[]" class="ace" value="<?php echo $row->HeaderID; ?>">
                                                            <span class="lbl"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-right" style="width: 50px;"><?php echo $row->HeaderID; ?></td>
                                                <td><?php echo $row->Nama; ?></td>
                                                <td><?php echo $row->Pemborong; ?></td>
                                                <td class="text-right"><?php echo date('d-M-Y', strtotime($row->Tgl_Lahir)) ?></td>
                                                <td>
                                                    <?php
                                                    $jekel = $row->Jenis_Kelamin;
                                                    if ($jekel == 'M' || $jekel == 'LAKI-LAKI') {
                                                        echo 'Laki-laki';
                                                    } elseif ($jekel == 'F' || $jekel == 'PEREMPUAN') {
                                                        echo 'Perempuan';
                                                    } else {
                                                        echo 'Gak Jelas';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if (strtoupper($row->Pendidikan) == 'NAN') {
                                                        echo 'Tidak Sekolah';
                                                    } else {
                                                        echo $row->Pendidikan;
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $Gs = $row->Verified;
                                                    if ($Gs == 1) {
                                                        echo "<span class='label label-sm label-info arrowed-right arrowed-in'>Telah Verifikasi</span>";
                                                    } else {
                                                        echo "<span class='label label-sm label-danger arrowed-right arrowed-in'>Belum Verifikasi</span>";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row->KTP != NULL && $row->Lamaran != NULL && $row->CV != NULL && $row->Ijazah != NULL && $row->Transkrip != NULL) {
                                                        echo "<span class='label label-sm label-success arrowed'>Berkas Lengkap</span>";
                                                    } elseif ($row->KTP != NULL) {
                                                        echo "<span class='label label-sm label-info arrowed'>Minimal Berkas</span>";
                                                    } else {
                                                        echo "<span class='label label-sm label-danger arrowed'>Tidak Lengkap </span>";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="text-left"><?php echo $row->RegisteredBy; ?></div>
                                                    <div class="text-right smaller-80"><?php echo $row->RegisteredDate; ?></div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle">
                                                            Berkas
                                                            <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-default">
                                                            <li>
                                                                <?php if ($row->KTP != NULL) { ?>
                                                                    <a title="show KTP" data-rel="tooltip" href="#" class="berkas" data-name="KTP" data-tk="<?php echo ucwords(strtolower($row->Nama)); ?>">KTP</a>
                                                                <?php
                                                                } else {
                                                                    echo "<a><small><i>KTP is NULL</i></small></a>";
                                                                } ?>
                                                            </li>
                                                            <li>
                                                                <?php if ($row->KK != NULL) { ?>
                                                                    <a title="show KK" data-rel="tooltip" href="#" class="berkas" data-name="KK" data-tk="<?php echo ucwords(strtolower($row->Nama)); ?>">KK</a>
                                                                <?php
                                                                } else {
                                                                    echo "<a><small><i>KK is NULL</i></small></a>";
                                                                } ?>
                                                            </li>
                                                            <li>
                                                                <?php if ($row->SKCK != NULL) { ?>
                                                                    <a title="show SKCK" data-rel="tooltip" href="#" class="berkas" data-name="SKCK" data-tk="<?php echo ucwords(strtolower($row->Nama)); ?>">SKCK</a>
                                                                <?php
                                                                } else {
                                                                    echo "<a><small><i>SKCK is NULL</i></small></a>";
                                                                } ?>
                                                            </li>
                                                            <li>
                                                                <?php if ($row->Lamaran != NULL) { ?>
                                                                    <a title="show Lamaran" data-rel="tooltip" href="#" class="berkas" data-name="Lamaran" data-tk="<?php echo ucwords(strtolower($row->Nama)); ?>">Lamaran</a>
                                                                <?php
                                                                } else {
                                                                    echo "<a><small><i>Lamaran is NULL</i></small></a>";
                                                                } ?>
                                                            </li>
                                                            <li>
                                                                <?php if ($row->CV != NULL) { ?>
                                                                    <a title="show CV" data-rel="tooltip" href="#" class="berkas" data-name="CV" data-tk="<?php echo ucwords(strtolower($row->Nama)); ?>">Curiculum Vitae</a>
                                                                <?php
                                                                } else {
                                                                    echo "<a><small><i>Curiculum Vitae is NULL</i></small></a>";
                                                                } ?>
                                                            </li>
                                                            <li>
                                                                <?php if ($row->Ijazah != NULL) { ?>
                                                                    <a title="show Ijazah" data-rel="tooltip" href="#" class="berkas" data-name="Ijazah" data-tk="<?php echo ucwords(strtolower($row->Nama)); ?>">Ijazah</a>
                                                                <?php
                                                                } else {
                                                                    echo "<a><small><i>Ijazah is NULL</i></small></a>";
                                                                } ?>
                                                            </li>
                                                            <li>
                                                                <?php if ($row->Transkrip != NULL) { ?>
                                                                    <a title="show Transkrip" data-rel="tooltip" href="#" class="berkas" data-name="Transkrip" data-tk="<?php echo ucwords(strtolower($row->Nama)); ?>">Transkrip Nilai</a>
                                                                <?php
                                                                } else {
                                                                    echo "<a><small><i>Transkrip is NULL</i></small></a>";
                                                                } ?>
                                                            </li>
                                                            <li>
                                                                <?php if ($row->Vaksin1 != NULL) { ?>
                                                                    <a title="show Vaksin1" data-rel="tooltip" href="#" class="berkas" data-name="Vaksin1" data-tk="<?php echo ucwords(strtolower($row->Nama)); ?>">Vaksin 1</a>
                                                                <?php
                                                                } else {
                                                                    echo "<a><small><i>Vaksin1 is NULL</i></small></a>";
                                                                } ?>
                                                            </li>
                                                            <li>
                                                                <?php if ($row->Vaksin1 != NULL) { ?>
                                                                    <a title="show Vaksin2" data-rel="tooltip" href="#" class="berkas" data-name="Vaksin2" data-tk="<?php echo ucwords(strtolower($row->Nama)); ?>">Vaksin 2</a>
                                                                <?php
                                                                } else {
                                                                    echo "<a><small><i>Vaksin2 is NULL</i></small></a>";
                                                                } ?>
                                                            </li>
                                                            <li>
                                                                <?php if ($row->Vaksin3 != NULL) { ?>
                                                                    <a title="show Vaksin3" data-rel="tooltip" href="#" class="berkas" data-name="Vaksin3" data-tk="<?php echo ucwords(strtolower($row->Nama)); ?>">Vaksin 3</a>
                                                                <?php
                                                                } else {
                                                                    echo "<a><small><i>Vaksin1 is NULL</i></small></a>";
                                                                } ?>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <a title="View Detail" data-rel="tooltip" href="#" class="detail btn btn-minier btn-round btn-primary">
                                                        <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                                                    </a>
                                                </td>
                                            </tr>
                                    <?php endforeach;
                                    } ?>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td colspan="11" class="center"><?php echo $_peganation; ?></td>
                                    </tr>
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

<!-- js group -->
<script>
    $('.on_cari_data').change(function() {
        $('#form_cari_data').submit();
    });

    $('.ke_page').click(function() {
        $('.page_aktif').val($(this).text());
        $('#form_cari_data').submit();
    });
</script>

<!-- <script>
    $('#inputDataFilter').change(function(){
        var val = this.value;
        window.location = '<?php // echo site_url();
                            ?>verifikasi/index/'+val;
    })
</script> -->

<!-- <script>
    $(document).ready(function() {
        $("#inputPemborong").keyup(function() {
            $.ajax({
                type:"POST",
                url:"<?php // echo base_url(); 
                        ?>autocomplete/getPemborong",
                data:{keyword:$("#inputPemborong").val()},
                dataType:"json",
                success:function(o) { 
                    o.length > 0 ? ($("#DropdownPemborong").empty(),
                    $("#inputPemborong").attr("data-toggle","dropdown"),
                    $("#DropdownPemborong").dropdown("toggle")):0==o.length&&$("#inputPemborong").attr("data-toggle",""),
                    $.each(o,function(n,e) {
                        o.length>=0&&$("#DropdownPemborong").append('<li role="presentation" ><a role="menuitem dropdownnameli" class="dropdownlivalue">'+e.Pemborong+"</a></li>")})
                }
            });
        }),
            $("ul.txtpemborong").on("click","li a",function() {
                $("#inputPemborong").val($(this).text())
            });
    });
</script> -->

<script type="text/javascript">
    $(document).ready(function() {
        $('#myTable').dataTable();
        $('[data-rel=tooltip]').tooltip();

        $("#myTable").on("click", ".detail", function() {
            var id = $(this).closest('tr').data('id');
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
            let id = $(this).closest('tr').data('id');
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