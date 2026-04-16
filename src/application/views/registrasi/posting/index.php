<div class="page-header">
    <h1>
        REGISTRASI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Posting Tenaga Kerja
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <!-- Design Disini -->
        <div class="row">
            <div class="col-xs-12">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">List Tenaga Kerja Baru </h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <?php $att = array('class' => 'form-horizontal', 'role' => 'form');
                    echo form_open('postingTenaker/doPosting', $att);
                    ?>
                    <div class="widget-body">
                        <div class="widget-main">
                            <p class='alert <?php echo $label; ?>'><button type='button' class='close' data-dismiss='alert'>
                                    <i class='ace-icon fa fa-times'></i></button><?php echo $pesan; ?>
                            </p>
                            <div class="table-responsive">
                                <table id="dataTables-listTK" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                #
                                                <!-- <label class="pos-rel">
                                                    <input type="checkbox" class="ace">
                                                    <span class="lbl"></span>
                                                </label> -->
                                            </th>
                                            <th>ID</th>
                                            <th>Nama</th>
                                            <th>Dept Tujuan</th>
                                            <th>Pemborong</th>
                                            <th>Tangga Lahir</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Berkas</th>
                                            <th>
                                                <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By
                                            </th>

                                            <th></th>

                                            <th>Opsi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        foreach ($_listTenaker as $set) :
                                        ?>
                                            <?php
                                            $xxx = '';
                                            if ($set->IdentifikasiValid == 'Salah') {
                                                $xxx = 'style="background-color: #ff9999;"';
                                            }
                                            echo '<tr ' . $xxx . ' data-id="' . $set->HeaderID . '" class="rowdetail" >';
                                            ?>

                                            <td class="text-center">
                                                <div class="checkbox">
                                                    <label class="pos-rel">
                                                        <input name="chkPosting[]" type="checkbox" class="ace chkHdrID" value="<?php echo $set->HeaderID; ?>">
                                                        <span class="lbl"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td style="width: 50px " class="text-right">
                                                <?php echo $set->HeaderID; ?>

                                                <div class="checkbox" style="display: none;">
                                                    <label class="pos-rel">
                                                        <input name="Nofix[]" type="checkbox" class="ace Nofix" value="<?php echo $set->Nofix; ?>">
                                                        <span class="lbl"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td><?php echo $set->Nama; ?> <?= $set->Nofix != '' ? '( ' . $set->Nofix . ' )' : '' ?></td>
                                            <td>
                                                <?php if ($set->TransID == NULL || $set->TransID == '') {
                                                    echo 'Unidentified';
                                                } else { ?>
                                                    <div class="text-left"><?php echo $set->TransID . ". " . $set->DeptTujuan; ?></div>
                                                    <div class="text-right smaller-80"><?php echo $set->Transaksi; ?></div>
                                                <?php } ?>
                                            </td>
                                            <td><?php echo $set->Pemborong; ?>
                                                <?php if ($set->Pemborong == 'YAO HSING') {
                                                    $tipe = 1;
                                                } else {
                                                    $tipe = 0;
                                                } ?>
                                                <input name="txtTipe[]" type="hidden" value="<?php echo $tipe; ?>" readonly="">
                                            </td>
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
                                            <td>
                                                <?php
                                                if ($set->KTP != NULL && $set->Lamaran != NULL && $set->CV != NULL && $set->Ijazah != NULL && $set->Transkrip != NULL) {
                                                    echo "<span class='label label-sm label-success arrowed'>Berkas Lengkap</span>";
                                                } elseif ($set->KTP != NULL && $set->CV != NULL) {
                                                    echo "<span class='label label-sm label-info arrowed'>Minimal Berkas</span>";
                                                } else {
                                                    echo "<span class='label label-sm label-danger arrowed'>Tidak Lengkap </span>";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <div class="text-left"><?php echo $set->RegisteredBy; ?></div>
                                                <div class="text-right smaller-90"><?php echo $set->RegisteredDate; ?></div>
                                            </td>

                                            <td>
                                                <div style="display : none"><input name="txt_p2k3[]" value="<?php echo $set->status_p2k3 ?>"></input></div>
                                                <div style="display : none"><input name="departemen[]" value="<?php echo $set->DeptTujuan ?>"></input></div>
                                            </td>

                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown" class="btn btn-mini btn-round btn-success dropdown-toggle">
                                                        Print
                                                        <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-default">
                                                        <li>
                                                            <a title="print Surat Pengantar Masuk Kerja" data-rel="tooltip" href="<?php echo site_url('printControl/viewSPMK/' . $set->HeaderID); ?>" target="_blank">SPMK</a>
                                                        </li>
                                                        <li>
                                                            <a title="print Formulir Medical Check Up" data-rel="tooltip" href="<?php echo site_url('printControl/viewFormMCU/' . $set->HeaderID); ?>" target="_blank">MCU Form</a>
                                                        </li>
                                                        <li>
                                                            <a title="print Kartu Medical Check Up" data-rel="tooltip" href="<?php echo site_url('printControl/viewCardMCU/' . $set->HeaderID); ?>" target="_blank">MCU Card</a>
                                                        </li>
                                                        <li>
                                                            <a title="print Kartu Pengantar Berobat" data-rel="tooltip" href="<?php echo site_url('printControl/viewKPB/' . $set->HeaderID); ?>" target="_blank">KPB Card</a>
                                                        </li>
                                                        <li>
                                                            <a title="print Hasil Wawancara" data-rel="tooltip" href="<?php echo site_url('printControl/viewIntervewResultSMA/' . $set->HeaderID); ?>" target="_blank">Hasil Interview</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle">
                                                        Berkas
                                                        <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-default">
                                                        <li>
                                                            <?php if ($set->KTP != NULL) { ?>
                                                                <a title="show KTP" data-rel="tooltip" href="#" class="berkas" data-name="KTP" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">KTP</a>
                                                            <?php } else {
                                                                echo "<a><small><i>KTP is NULL</i></small></a>";
                                                            } ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($set->Lamaran != NULL) { ?>
                                                                <a title="show Lamaran" data-rel="tooltip" href="#" class="berkas" data-name="Lamaran" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Lamaran</a>
                                                            <?php } else {
                                                                echo "<a><small><i>Lamaran is NULL</i></small></a>";
                                                            } ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($set->CV != NULL) { ?>
                                                                <a title="show CV" data-rel="tooltip" href="#" class="berkas" data-name="CV" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Curiculum Vitae</a>
                                                            <?php } else {
                                                                echo "<a><small><i>Curiculum Vitae is NULL</i></small></a>";
                                                            } ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($set->Ijazah != NULL) { ?>
                                                                <a title="show Ijazah" data-rel="tooltip" href="#" class="berkas" data-name="Ijazah" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Ijazah</a>
                                                            <?php } else {
                                                                echo "<a><small><i>Ijazah is NULL</i></small></a>";
                                                            } ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($set->Transkrip != NULL) { ?>
                                                                <a title="show Transkrip" data-rel="tooltip" href="#" class="berkas" data-name="Transkrip" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Transkrip Niali</a>
                                                            <?php } else {
                                                                echo "<a><small><i>Transkrip is NULL</i></small></a>";
                                                            } ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <a title="View Detail" data-dept="<?php echo $set->DeptTujuan; ?>" data-pekerjaan="<?php echo $set->Transaksi; ?>" data-idtrans="<?php echo $set->TransID; ?>" data-rel="tooltip" href="#" class="detail btn btn-minier btn-round btn-primary">
                                                    <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                                                </a>
                                            </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="widget-toolbox padding-8 clearfix">
                        <div class="well text-center">
                            <input type="submit" value="Posting" name="btnPosting" class="btn btn-success">
                        </div>
                    </div>
                    </form>
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
                <h4 class="modal-title" id="titleModal">Tambah Penghuni Borongan</h4>
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
        $('[data-rel=tooltip]').tooltip();

        $("#dataTables-listTK").on("click", ".detail", function() {
            var id = $(this).closest('tr').data('id');
            var dept = $(this).data('dept');
            var pkrj = $(this).data('pekerjaan');
            var transID = $(this).data('idtrans');
            console.log('tes')
            console.log(transID)
            $.ajax({
                url: "<?php echo site_url('PostingTenaker/detailtk'); ?>",
                type: "POST",
                data: "kode=" + id + "&dept=" + dept + "&pkrj=" + pkrj + "&transID=" + transID,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#detail").html(msg);
                }
            });
            $("#viewModal").modal("show");
        });

        $("#dataTables-listTK").on("click", ".berkas", function() {
            var id = $(this).closest('tr').data('id');
            var name = $(this).data('name');
            var tk = $(this).data('tk');

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

        var active_class = 'active';
        $('#dataTables-listTK > thead > tr > th input[type=checkbox]').eq(0).on('click', function() {
            var th_checked = this.checked; //checkbox inside "TH" table header
            $(this).closest('table').find('tbody > tr').each(function() {
                var row = this;
                if (th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
            });
        });

        $(document).on('click', '.chkHdrID', function() {
            var that = $(this)
            if (that.prop('checked')) {
                that.closest('tr').find('.Nofix').prop('checked', true)
                console.log('checked');
            } else {
                that.closest('tr').find('.Nofix').prop('checked', false)

                console.log('unchecked');
            }
        })
    });
</script>