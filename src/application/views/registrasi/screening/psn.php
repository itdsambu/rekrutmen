<div class="page-header">
    <h1>
        SCREENING
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Screening Oleh Personalia
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">List Tenaga Kerja Baru yang Telah Discreening Oleh TIM</h4>

                <div class="widget-toolbar">

                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <?php
                        if ($this->input->get('msg') == 'Success') {
                            echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                                        <i class='ace-icon fa fa-times'></i></button>Screening by Persconalia Success!</p>";
                        }
                        ?>
                        <div class="col-xs-12">
                            <!-- <from class="form-horizontal" role="form" method="POST" action="<?php echo base_url('ScreeningByPsn/screeningfilter'); ?>">
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right">Filter Data</label>
                                        <div class="col-sm-8">
                                            <select name="txtFilter" id="inputFilter" class="form-control input-sm btn btn-primary btn-sm">
                                                <option value="2" <?php if ($_selected == 2) {
                                                                        echo 'selected';
                                                                    } ?>> -- pilih -- </option>
                                                <option value="1" <?php if ($_selected == 1) {
                                                                        echo 'selected';
                                                                    } ?>>Lulus</option>
                                                <option value="0" <?php if ($_selected == 0) {
                                                                        echo 'selected';
                                                                    } ?>>Tidak Lulus</option>
                                            </select>
                                            <script>
                                                $('#inputFilter').change( function (){
                                                    var val = this.value;
                                                    window.location = '<?php echo site_url(); ?>ScreeningByPsn/screening/'+val;
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4"></div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right">Filter Nama</label>
                                        <div class="col-sm-8">
                                            <input name="txtNama" id="inputNama" type="text" class="form-control input-sm" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-8 right">
                                            <input name="btnCari" id="inputcari" type="submit" value="Refresh" class="btn btn-mini btn-block" />
                                        </div>                                        
                                    </div>
                                </div>
                            </from>
                        </div> -->
                            <div class="col-xs-12 table-responsive">
                                <table id="dataTables-listTK" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama</th>
                                            <th>CV/Pemborong</th>
                                            <th>Dept Tujuan</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Jenis Kelamin</th>
                                            <th>AppP2K3</th>
                                            <th>
                                                <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By
                                            </th>
                                            <th>
                                                <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Registered Date
                                            </th>
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
                                            <td>
                                                <?php if ($set->TransID == NULL || $set->TransID == '') {
                                                    echo 'Unidentified';
                                                } else { ?>
                                                    <div class="text-left"><?php echo $set->TransID . ". " . $set->DeptAbbr; ?></div>
                                                    <div class="text-right smaller-80"><?php echo $set->Pekerjaan; ?></div>
                                                <?php } ?>
                                            </td>
                                            <td class="text-right"><?php echo date('d-M-Y',  strtotime($set->Tgl_Lahir)); ?></td>
                                            <td><?php
                                                $jekel = $set->Jenis_Kelamin;
                                                if ($jekel == 'M'  || $jekel == 'LAKI-LAKI') {
                                                    echo 'Laki-laki';
                                                } elseif ($jekel == 'F' || $jekel == 'PEREMPUAN') {
                                                    echo 'Perempuan';
                                                } else {
                                                    echo 'Gx Jelas';
                                                }
                                                ?></td>
                                            <td><?php echo $set->AppP2K3By . ' / ' . $set->AppP2K3Date; ?></td>
                                            <td><?php echo $set->CreatedBy; ?></td>
                                            <td class="text-right"><?php echo $set->CreatedDate; ?></td>
                                            <td class="text-center">
                                                <a title="do Screening" href="#" class="screening">
                                                    <button class="btn btn-minier btn-primary">
                                                        <i class="ace-icon fa fa-files-o bigger-100"></i> Screening</button>
                                                </a>
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle">
                                                        Berkas
                                                        <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-default">
                                                        <li>
                                                            <?php if ($set->KTP != NULL) { ?>
                                                                <a title="show detail" href="javascript:;" class="detailberkas" data-name="KTP" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">KTP</a>
                                                            <?php } else {
                                                                echo "<a><small><i>KTP is NULL</i></small></a>";
                                                            } ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($set->Lamaran != NULL) { ?>
                                                                <a title="show detail" href="javascript:;" class="detailberkas" data-name="Lamaran" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Lamaran</a>
                                                            <?php } else {
                                                                echo "<a><small><i>Lamaran is NULL</i></small></a>";
                                                            } ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($set->CV != NULL) { ?>
                                                                <a title="show detail" href="javascript:;" class="detailberkas" data-name="CV" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Curiculum Vitae</a>
                                                            <?php } else {
                                                                echo "<a><small><i>Curiculum Vitae is NULL</i></small></a>";
                                                            } ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($set->SKCK != NULL) { ?>
                                                                <a title="show detail" href="javascript:;" class="detailberkas" data-name="SKCK" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">SKCK</a>
                                                            <?php
                                                            } else {
                                                                echo "<a><small><i>SKCK is NULL</i></small></a>";
                                                            } ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($set->Ijazah != NULL) { ?>
                                                                <a title="show detail" href="javascript:;" class="detailberkas" data-name="Ijazah" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Ijazah</a>
                                                            <?php } else {
                                                                echo "<a><small><i>Ijazah is NULL</i></small></a>";
                                                            } ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($set->Transkrip != NULL) { ?>
                                                                <a title="show detail" href="javascript:;" class="detailberkas" data-name="Transkrip" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Transkrip Nilai</a>
                                                            <?php } else {
                                                                echo "<a><small><i>Transkrip is NULL</i></small></a>";
                                                            } ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($set->Vaksin1 != NULL) { ?>
                                                                <a title="show detail" href="javascript:;" class="detailberkas" data-name="Vaksin1" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Vaksin 1</a>
                                                            <?php } else {
                                                                echo "<a><small><i>Vaksin1 is NULL</i></small></a>";
                                                            } ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($set->Vaksin2 != NULL) { ?>
                                                                <a title="show detail" href="javascript:;" class="detailberkas" data-name="Vaksin2" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Vaksin 2</a>
                                                            <?php } else {
                                                                echo "<a><small><i>Vaksin2 is NULL</i></small></a>";
                                                            } ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($set->Vaksin3 != NULL) { ?>
                                                                <a title="show detail" href="javascript:;" class="detailberkas" data-name="Vaksin3" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Vaksin 3</a>
                                                            <?php } else {
                                                                echo "<a><small><i>Vaksin3 is NULL</i></small></a>";
                                                            } ?>
                                                        </li>
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
                    <h4 class="modal-title">Screening Personalia by <strong class="green"><?php echo $this->session->userdata('username'); ?></strong></h4>
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

    <div class="modal fade" id="viewModalberkas" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!--style="background-color: #008cba">-->
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="titleModal"></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="inputdetail" name="iddetail">
                    <div id="detailberkas" class="well">
                        <!--load tabel dari file detail.php melalui javascript-->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/jqv/jquery.tablesorter.min.js"></script>
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
                $.ajax({
                    url: "<?php echo site_url('screeningByPsn/screenPsn'); ?>",
                    type: "POST",
                    data: "kode=" + id,
                    datatype: "json",
                    cache: false,
                    success: function(msg) {
                        $("#screening").html(msg);
                    }
                });
                $("#viewModalScreening").modal("show");
            });

            $("#dataTables-listTK").on("click", ".detailberkas", function() {
                var a = $(this).closest("tr").data("id"),
                    t = $(this).data("name"),
                    e = $(this).data("tk");
                document.getElementById("titleModal").innerHTML = "Berkas " + t + " dari saudara, <strong class='green'>" + e + " </strong>";
                $.ajax({
                    url: "<?php echo site_url('ScreeningByPsn/viewDocs'); ?>",
                    type: "POST",
                    data: "kode=" + a + "&nama=" + t,
                    datatype: "json",
                    cache: !1,
                    success: function(a) {
                        $("#detailberkas").html(a)
                    }
                });
                $("#viewModalberkas").modal("show");
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
    </script>