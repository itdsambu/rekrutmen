<?php
/*
 * Author : Ismo___
 */
?>


<div class="page-header">
    <h1>
        PROSES WAWANCARA
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Wawancara Tenaga Kerja Harian/Borongan
        </small>
    </h1>
</div>

<div class="row">
    <div class="col-xs-12">  
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Wawancara Tenaga Kerja Harian/Borongan </h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <?php
                    if ($this->input->get('msg') == 'Success') {
                        echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                                    <i class='ace-icon fa fa-times'></i></button>Interview Borongan Success!</p>";
                    }
                    ?>
                    <div class="table-responsive">
                        <table id="dataTables-listTK" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Dept Tujuan</th>
                                    <th>Nama</th>
                                    <th>CV Tujuan</th>
                                    <th>Tempat/Tangga Lahir</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Pendidikan</th>
                                    <th>Status</th>
                                    <th>Alamat</th>
                                    <th>Submit Date</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($_getTenagaKerja as $set):  
                                    ?>
                                    <?php
                                    echo '<tr data-id="' . $set->HdrID . '" class="rowdetail info" >';
                                    ?>
                                <td style="width: 40px " class="text-right"><?php echo $set->HeaderID; ?></td>
                                <td>
                                    <div class="text-left"><?php echo $set->DeptAbbr; ?></div>
                                </td>
                                <td><?php echo $set->Nama; ?></td>
                                <td><?php echo $set->CVNama; ?></td>
                                <td>
                                    <div class="text-left"><?php echo ucwords(strtolower($set->Tempat_Lahir)); ?></div>
                                    <div class="text-right smaller-90"><?php echo date('d F Y', strtotime($set->Tgl_Lahir)); ?></div>
                                </td>
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
                                <td><?php echo $set->Pendidikan; ?></td>
                                <td><?php echo ucwords(strtolower($set->Status_Personal)); ?></td>
                                <td class="col-sm-2"><?php echo ucwords(strtolower($set->Alamat)); ?></td>
                                <td>
                                    <?php if($set->SendedBy == NULL):
                                        $saatin = date("Y/m/d", strtotime($set->CreatedDate));
                                        $startTIme = strtotime($saatin);
                                        $hariini = date("Y/m/d");
                                        $endTimeStamp = strtotime($hariini);
                                        $timeDiff = abs($endTimeStamp - $startTIme);
                                        $numDays = $timeDiff / 86400;
                                        $numberDays = intval($numDays);
                                        if($numberDays >= 4):
                                        ?>
                                        <div class="red"><?php echo date('d F Y', strtotime($set->CreatedDate));?> </div>
                                        <div class="text-right"><span class="label label-danger">Over Time</span></div>
                                        <?php else:?>
                                        <div class="green"><?php echo date('d F Y', strtotime($set->CreatedDate));?></div>
                                        <?php endif;?>
                                    <?php else:?>
                                        <?php
                                        $saatin = date("Y/m/d", strtotime($set->SendedDate));
                                        $startTIme = strtotime($saatin);
                                        $hariini = date("Y/m/d");
                                        $endTimeStamp = strtotime($hariini);
                                        $timeDiff = abs($endTimeStamp - $startTIme);
                                        $numDays = $timeDiff / 86400;
                                        $numberDays = intval($numDays);
                                        if($numberDays > 4):
                                        ?>
                                        <div class="red"><?php echo date('d F Y', strtotime($set->SendedDate));?> </div>
                                        <div class="text-right"><span class="label label-danger">Over Time</span></div>
                                        <?php else:?>
                                        <div class="green"><?php echo date('d F Y', strtotime($set->SendedDate));?></div>
                                        <?php endif;?>
                                    <?php endif;?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle">
                                            Docs
                                            <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-default">
                                            <li>
                                                <?php if ($set->KTP != NULL) { ?>
                                                    <a title="show KTP" data-rel="tooltip" href="#" class="detail" data-name="KTP" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">KTP</a>
                                                <?php } else {
                                                    echo "<a><small><i>KTP is NULL</i></small></a>";
                                                } ?>
                                            </li>
                                            <li>
                                                <?php if ($set->Lamaran != NULL) { ?>
                                                    <a title="show Lamaran" data-rel="tooltip" href="#" class="detail" data-name="Lamaran" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Lamaran</a>
                                                <?php } else {
                                                    echo "<a><small><i>Lamaran is NULL</i></small></a>";
                                                } ?>
                                            </li>
                                            <li>
                                                <?php if ($set->CV != NULL) { ?>
                                                    <a title="show CV" data-rel="tooltip" href="#" class="detail" data-name="CV" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Curiculum Vitae</a>
                                                <?php } else {
                                                    echo "<a><small><i>Curiculum Vitae is NULL</i></small></a>";
                                                } ?>
                                            </li>
                                            <li>
                                                <?php if ($set->Ijazah != NULL) { ?>
                                                    <a title="show Ijazah" data-rel="tooltip" href="#" class="detail" data-name="Ijazah" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Ijazah</a>
                                                <?php } else {
                                                    echo "<a><small><i>Ijazah is NULL</i></small></a>";
                                                } ?>
                                            </li>
                                            <li>
                                                <?php if ($set->Transkrip != NULL) { ?>
                                                    <a title="show Transkrip" data-rel="tooltip" href="#" class="detail" data-name="Transkrip" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Transkrip Nilai</a>
                                                <?php } else {
                                                    echo "<a><small><i>Transkrip is NULL</i></small></a>";
                                                } ?>
                                            </li>
                                        </ul>
                                    </div>
                                    <a title="do Interview" data-rel="tooltip" href="#" class="wawancara tooltip-info">
                                        <button class="btn btn-minier btn-round btn-primary">
                                            <i class="ace-icon fa fa-files-o bigger-100"></i> Interview</button>
                                    </a>
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

<!-- Modal View Screening-->
<div class="modal fade" id="viewModalWawancara" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Wawancara by <strong><?php echo $this->session->userdata('username'); ?></strong></h3>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="wawancaraHarian" class="well">
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
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titleModal"></h4>
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

<script type="text/javascript">
    $(document).ready(function () {
        $('#dataTables-listTK').dataTable();  
        $('[data-rel=tooltip]').tooltip();

        $("#dataTables-listTK").on("click", ".wawancara", function () {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url: "<?php echo site_url('wawancaraProses/doWawancaraHarian'); ?>",
                type: "POST",
                data: "kode=" + id,
                datatype: "json",
                cache: false,
                success: function (msg) {
                    // console.log(msg);
                    $("#wawancaraHarian").html(msg);
                }
            });
            $("#viewModalWawancara").modal("show");
        });

        $("#dataTables-listTK").on("click", ".detail", function () {
            var id = $(this).closest('tr').data('id');
            var name = $(this).data('name');
            var tk = $(this).data('tk');

            document.getElementById('titleModal').textContent = "Berkas " + name + " dari saudara, " + tk + "";
            $.ajax({
                url: "<?php echo site_url('monitor/viewDocs'); ?>",
                type: "POST",
                data: "kode=" + id + "&nama=" + name,
                datatype: "json",
                cache: false,
                success: function (msg) {
                    $("#detail").html(msg);
                }
            });
            $("#viewModal").modal("show");
        });
    });
</script>