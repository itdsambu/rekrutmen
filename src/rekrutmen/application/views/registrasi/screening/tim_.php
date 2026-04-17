<div class="page-header">
    <h1>
        SCREENING
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            <?php if (!isset($isDiv)) {
                echo 'Screening Oleh Tim Screening';
            } else if ($isDiv == 2) {
                echo 'Approval Divisi P2K3';
            } else if ($isDiv == 3) {
                echo 'Approval Divisi ELC';
            } else {
                echo 'Approval Divisi Utility';
            } ?>
        </small>
    </h1>
</div><!-- /.page-header -->
<?= $this->session->userdata('dept') ?> -
<?= $this->session->userdata('username') ?>
<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><?php if (!isset($isDiv)) {
                                                echo 'List Tenaga Kerja Baru';
                                            } else {
                                                echo 'List TK Lulus Wawancara Dept';
                                            } ?></h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <?php
                    if ($this->input->get('msg') == 'Success') {
                        echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                                    <i class='ace-icon fa fa-times'></i></button>Screening by TEAM Success!</p>";
                    }
                    if ($this->input->get('msg') == 'Successs') {
                        echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                                    <i class='ace-icon fa fa-times'></i></button>TK Telah Approve oleh Divisi!</p>";
                    }

                    if ($this->input->get('msg') == 'Successss') {
                        echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                                    <i class='ace-icon fa fa-times'></i></button>TK Telah Approve oleh P2K3!</p>";
                    }

                    if ($this->input->get('msg') == 'SuccessssS') {
                        echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                                    <i class='ace-icon fa fa-times'></i></button>TK Telah Approve oleh ELC!</p>";
                    }
                    ?>
                    <div class="table-responsive">
                        <table id="dataTables-listTK" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Tujuan Lamaran</th>

                                    <?php if (isset($isDiv) && $isDiv == '1') { ?>
                                        <th>Dept Tujuan</th>
                                    <?php } ?>

                                    <th>Pemborong</th>
                                    <th>Tangga Lahir</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status</th>
                                    <th>
                                        <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By
                                    </th>
                                    <th>
                                        <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Registered Date
                                    </th>
                                    <!-- <th>Dept Tujuan</th> -->
                                    <th>Opsi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($_getTK as $set) :
                                ?>
                                    <?php
                                    echo '<tr data-id="' . $set->HeaderID . '" class="rowdetail info" >';
                                    ?>
                                    <td style="width: 50px " class="text-right"><?php echo $set->HeaderID; ?></td>
                                    <td><?php echo $set->Nama; ?></td>
                                    <td><?php echo $set->CVNama; ?></td>
                                    <?php if (isset($isDiv) && $isDiv == '1') { ?>
                                        <td>
                                            <div class="text-left"><?php echo $set->TransID . ". " . $set->DeptTujuan; ?></div>
                                            <div class="text-right smaller-80"><?php echo $set->Pekerjaan; ?></div>
                                        </td>
                                    <?php } ?>
                                    <td><?php echo $set->Pemborong; ?></td>
                                    <td class="text-right"><?php echo date('d-M-Y',  strtotime($set->Tgl_Lahir)); ?></td>
                                    <td><?php
                                        $jekel = $set->Jenis_Kelamin;
                                        if ($jekel == 'M' || $jekel == 'LAKI-LAKI') {
                                            echo 'Laki-laki';
                                        } elseif ($jekel == 'F' || $jekel == 'PEREMPUAN') {
                                            echo 'Perempuan';
                                        } else {
                                            echo 'Gx Jelas';
                                        }
                                        ?></td>
                                    <td><?php
                                        $Gs = $set->ScreeningComplete;
                                        if ($Gs == 1) {
                                            echo "<span class='label label-sm label-info'>Done</span>";
                                        } else {
                                            echo "<span class='label label-sm label-warning'>On Progress</span>";
                                        }
                                        ?></td>

                                    <td><?php echo $set->RegisteredBy; ?></td>
                                    <td class="text-right"><?php echo $set->RegisteredDate; ?></td>
                                    <?php if (!isset($isDiv)) { ?><?php } else { ?><?php } ?>
                                    <!-- <td class="text-center">
                                    <?php //echo $set->DeptTujuan;
                                    ?>
                                </td> -->
                                    <td class="text-center">
                                        <a title="do <?php if (!isset($isDiv)) {
                                                            echo 'Screening';
                                                        } else {
                                                            echo 'Approval';
                                                        } ?>" href="#" class="screening">
                                            <button class="btn btn-minier btn-primary">
                                                <i class="ace-icon fa fa-files-o bigger-100"></i>
                                                <?php if (!isset($isDiv)) {
                                                    echo 'Screening';
                                                } else {
                                                    echo 'Approval';
                                                } ?>
                                            </button>
                                        </a>
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle">
                                                Berkas
                                                <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-default">
                                                <?php if (($this->session->userdata('username') == 'TENGKU RIYAN RAMADHAN') || ($this->session->userdata('username') == 'BAMBANG IRAWAN') || ($this->session->userdata('username') == 'BAHARUDIN') || ($this->session->userdata('username') != 'KIKI IRVANSYAH')) {  ?>
                                                    <li>
                                                        <?php if ($set->KTP != NULL) { ?>
                                                            <a title="show KTP" data-rel="tooltip" href="#" class="berkas" data-name="KTP" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">KTP</a>
                                                        <?php
                                                        } else {
                                                            echo "<a><small><i>SKCK is NULL</i></small></a>";
                                                        } ?>

                                                    </li>
                                                    <li>
                                                        <?php if ($set->KK != NULL) { ?>
                                                            <a title="show KK" data-rel="tooltip" href="#" class="berkas" data-name="KK" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">KK</a>
                                                        <?php
                                                        } else {
                                                            echo "<a><small><i>KK is NULL</i></small></a>";
                                                        } ?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->SKCK != NULL) { ?>
                                                            <a title="show SKCK" data-rel="tooltip" href="#" class="berkas" data-name="SKCK" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">SKCK</a>
                                                        <?php
                                                        } else {
                                                            echo "<a><small><i>SKCK is NULL</i></small></a>";
                                                        } ?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->Lamaran != NULL) { ?>
                                                            <a title="show Lamaran" data-rel="tooltip" href="#" class="berkas" data-name="Lamaran" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Lamaran</a>
                                                        <?php
                                                        } else {
                                                            echo "<a><small><i>Lamaran is NULL</i></small></a>";
                                                        } ?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->CV != NULL) { ?>
                                                            <a title="show CV" data-rel="tooltip" href="#" class="berkas" data-name="CV" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">CV</a>
                                                        <?php
                                                        } else {
                                                            echo "<a><small><i>CV is NULL</i></small></a>";
                                                        } ?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->Ijazah != NULL) { ?>
                                                            <a title="show Ijazah" data-rel="tooltip" href="#" class="berkas" data-name="Ijazah" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Ijazah</a>
                                                        <?php
                                                        } else {
                                                            echo "<a><small><i>Ijazah is NULL</i></small></a>";
                                                        } ?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->Transkrip != NULL) { ?>
                                                            <a title="show Transkrip" data-rel="tooltip" href="#" class="berkas" data-name="Transkrip" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Transkrip</a>
                                                        <?php
                                                        } else {
                                                            echo "<a><small><i>Transkrip is NULL</i></small></a>";
                                                        } ?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->Vaksin1 != NULL) { ?>
                                                            <a title="show Berkas Pendukung" data-rel="tooltip" href="#" class="berkas" data-name="Vaksin1" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Vaksin1</a>
                                                        <?php
                                                        } else {
                                                            echo "<a><small><i>Berkas Pendukung is NULL</i></small></a>";
                                                        } ?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->Vaksin3 != NULL) { ?>
                                                            <a title="show Vaksin2" data-rel="tooltip" href="#" class="berkas" data-name="Vaksin2" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Vaksin2</a>
                                                        <?php
                                                        } else {
                                                            echo "<a><small><i>Vaksin2 is NULL</i></small></a>";
                                                        } ?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->Vaksin3 != NULL) { ?>
                                                            <a title="show Vaksin3" data-rel="tooltip" href="#" class="berkas" data-name="Vaksin3" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Vaksin3</a>
                                                        <?php
                                                        } else {
                                                            echo "<a><small><i>Vaksin3 is NULL</i></small></a>";
                                                        } ?>
                                                    </li>
                                                <?php } ?>

                                            </ul>
                                        </div>
                                    </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal View Detail-->
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

<!-- Modal View Screening-->

<div class="modal fade" id="viewModalScreening" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Screening Tim by <strong class="green"><?php echo $this->session->userdata('username'); ?></strong></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="screening" class="well">
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
        $('#dataTables-listTK').dataTable();

        $("#dataTables-listTK").on("click", ".detail", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url: "<?php echo site_url('screeningByTim/detailtk'); ?>",
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

        $("#dataTables-listTK").on("click", ".screening", function() {
            var id = $(this).closest('tr').data('id');
            <?php if (!isset($isDiv)) { ?>
                var kd = 0;
            <?php } else if ($isDiv == 3) { ?>
                var kd = 3;
            <?php } else if ($isDiv == 2) { ?>
                var kd = 2;
            <?php } else { ?>
                var kd = 1;
            <?php } ?>
            console.log(kd);
            $.ajax({
                url: "<?php echo site_url('screeningByTim/screenTim'); ?>",
                type: "POST",
                data: "kode=" + id + "&div=" + kd,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#screening").html(msg);
                }
            });
            $("#viewModalScreening").modal("show");
        });


        var active_class = 'active';
        $('#dataTables-listTK > thead > tr > th input[type=checkbox]').eq(0).on('click', function() {
            var th_checked = this.checked; //checkbox inside "TH" table header
            $(this).closest('table').find('tbody > tr').each(function() {
                var row = this;
                if (th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
            });
        });
    });


    $(document).ready(function() {
        $('#dataTables-listTK').dataTable();
        $('[data-rel=tooltip]').tooltip();

        $("#dataTables-listTK").on("click", ".detail", function() {
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

        $("#dataTables-listTK").on("click", ".berkas", function() {
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
        $('#dataTables-listTK > thead > tr > th input[type=checkbox]').eq(0).on('click', function() {
            let th_checked = this.checked; //checkbox inside "TH" table header
            $(this).closest('table').find('tbody > tr').each(function() {
                let row = this;
                if (th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
            });
        });
    });

    var currentTr = null; // inisialisasi variabel

    $(document).on('click', '.screening', function() {
        currentTr = $(this).closest('tr'); // ambil tr yang diklik
        console.log('currentTr isi: ', currentTr);

        // Kalau mau langsung hapus setelah klik
    });

    $(document).on('click', '#btnSubmitScreening', function(e) {
        e.preventDefault()
        let formData = $('#form-screening').serialize()
        $.ajax({
            url: "<?php echo site_url('ScreeningByTim/save'); ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(data) {
                console.log('print : ', data);

                if (data.status == 'success') {
                    toastr.success('Data berhasil disimpan!');
                    currentTr.remove();
                    $('#viewModalScreening').modal('hide');
                } else {
                    toastr.error('Gagal: ' + data.message);
                }
            }
        })
        // console.log('data : ', data);

    })
</script>