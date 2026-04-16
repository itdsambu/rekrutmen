<?php
// print_r($_selectWhere);
//die; 
?>


<div class="page-header">
    <h1>
        REGISTRASI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Print Berkas Karyawan
        </small>
    </h1>
</div><!-- /.page-header -->


<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">List Tenaga Kerja yang <?php echo ($_selected == 0 ? 'Telah di Posting' : ($_selected == 1 ? 'Lulus Interview' : 'Telah Discreening HRD')); ?></h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
                <div class="widget-toolbar no-border">
                    <a href="<?php echo base_url('PrintControl/newPaging') ?>" class="btn btn-sm btn-info">Refresh</a>
                </div>
                <div class="widget-toolbar no-border">
                    <a href="" target="_blank" class="btn btn-sm btn-success" id="ExportExcel">Export to Excel</a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-xs-12">
                            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PrintControl/filterData'); ?>">
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right">Filter Data</label>
                                        <div class="col-sm-8">
                                            <select name="selDataFilter" id="inputDataFilter" class="form-control input-sm">
                                                <option value="0" <?php if ($_selected == 0) {
                                                                        echo 'selected';
                                                                    } ?>>Telah Posting</option>
                                                <option value="1" <?php if ($_selected == 1) {
                                                                        echo 'selected';
                                                                    } ?>>Lulus Wawancara</option>
                                                <option value="2" <?php if ($_selected == 2) {
                                                                        echo 'selected';
                                                                    } ?>>Telah Discreening HRD</option>
                                            </select>
                                        </div>
                                        <script>
                                            $('#inputDataFilter').change(function() {
                                                var val = this.value;
                                                // if (val == 0) {
                                                window.location = '<?php echo site_url(); ?>PrintControl/newPaging/' + val + '/';
                                                // }
                                            });
                                        </script>
                                    </div>
                                </div>
                                <!-- <button>apa</button> -->
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right">No. Reg</label>
                                        <div class="col-sm-8">
                                            <input name="txtNoreg" id="inputNoreg" type="number" class="form-control input-sm" autocomplete="off" value="<?= isset($_noreg) ? $_noreg : '' ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right">Nama</label>
                                        <div class="col-sm-8">
                                            <input name="txtNama" id="inputNama" type="text" class="form-control input-sm" autocomplete="off" value="<?= isset($_nama) ? $_nama : '' ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right">Pemborong</label>
                                        <div class="col-sm-8">
                                            <input name="txtPemborong" id="inputPemborong" type="text" class="form-control input-sm" autocomplete="off" />
                                            <ul class="dropdown-menu txtpemborong" style="margin-left:15px;margin-right:0px;" role="menu" aria-labelledby="dropdownMenu" id="DropdownPemborong"></ul>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                $("#inputPemborong").keyup(function() {
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "<?php echo base_url(); ?>autocomplete/getPemborong",
                                                        data: {
                                                            keyword: $("#inputPemborong").val()
                                                        },
                                                        dataType: "json",
                                                        success: function(o) {
                                                            o.length > 0 ? ($("#DropdownPemborong").empty(), $("#inputPemborong").attr("data-toggle", "dropdown"), $("#DropdownPemborong").dropdown("toggle")) : 0 == o.length && $("#inputPemborong").attr("data-toggle", ""), $.each(o, function(n, e) {
                                                                o.length >= 0 && $("#DropdownPemborong").append('<li role="presentation" ><a role="menuitem dropdownnameli" class="dropdownlivalue">' + e.Pimpinan + "</a></li>")
                                                            })
                                                        }
                                                    })
                                                }), $("ul.txtpemborong").on("click", "li a", function() {
                                                    $("#inputPemborong").val($(this).text())
                                                })
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4" <?php echo ($this->uri->segment(3) == '0' || $this->uri->segment(3) == '2' ? '' : 'style="display: none;"') ?>>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right">Range</label>
                                        <div class="col-sm-8">
                                            <div class="input-daterange input-group">
                                                <input type="text" class="input-sm form-control input-daterange " <?php echo ($this->uri->segment(3) == '0' || $this->uri->segment(3) == '2' ? 'required' : '') ?> name="txtDateA" id="txtDateA" value="<?= (isset($tglA) ? $tglA : '2023-12-01') ?>">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-exchange"></i>
                                                </span>
                                                <input type="text" class="input-sm form-control input-daterange " <?php echo ($this->uri->segment(3) == '0' || $this->uri->segment(3) == '2' ? 'required' : '') ?> name="txtDateZ" id="txtDateZ" value="<?= (isset($tglZ) ? $tglZ : date('Y-m-d', strtotime(date('Y-m-d') . ' +2 days'))) ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-8 right">
                                            <input name="btnCari" id="inputcari" type="submit" value="Filter" class="btn btn-mini btn-block" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xs-12" style="margin-bottom: 10px;">
                            <div class="col-6 ">
                                <a id="printCheckedValue" disabled href="" data-rel="tooltip" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-file"></i> Print Mandiri</a>
                            </div>
                        </div>

                        <div class="col-xs-12 table-responsive">
                            <table id="dataTables-listTK" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Departemen</th>
                                        <th>Tipe TenaKer</th>
                                        <th>Tangga Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Berkas</th>
                                        <th>
                                            <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Posted By
                                        </th>
                                        <th>Screening By HRD</th>
                                        <th>Hasil Interview</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($_selectWhere as $set) :
                                    ?>
                                        <?php
                                        echo '<tr data-id="' . $set->HeaderID . '" class="rowdetail info" >';
                                        ?>
                                        <td>
                                            <div class="checkbox">
                                                <label class="pos-rel">
                                                    <input name="checkVerifi[<?= $i++ ?>]" type="checkbox" class="ace chkBox" value="<?php echo $set->HeaderID; ?>">
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td style="width: 50px " class="text-right"><?php echo $set->HeaderID; ?></td>
                                        <td><?php echo $set->Nama; ?></td>
                                        <td><?php echo $set->DeptTujuan; ?></td>
                                        <td>
                                            <?php echo ($_selected == 0 ? ($set->TipeKaryawan == 1 ? 'Karyawan' : 'Borongan/Harian') : ($set->Pemborong == 'YAO HSING' ? 'Karyawan' : 'Borongan/Harian')); ?>
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
                                            } elseif ($set->KTP != NULL) {
                                                echo "<span class='label label-sm label-info arrowed'>Minimal Berkas</span>";
                                            } else {
                                                echo "<span class='label label-sm label-danger arrowed'>Tidak Lengkap </span>";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="text-left"><?php echo $set->CreatedBy; ?></div>
                                            <div class="text-right smaller-90"><?php echo date('F, d Y H:i:s', strtotime(($_selected == 0 ? $set->CreatedDate : $set->RegisteredDate))); ?></div>
                                        </td>
                                        <td>
                                            <div class="text-left"><?php echo $set->SpecialScreeningBy; ?></div>
                                            <div class="text-right smaller-90"><?php echo date('F, d Y H:i:s', strtotime($set->SpecialScreeningDate)); ?></div>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            if ($set->WawancaraKe == NULL) {
                                                echo 'Belum Pernah';
                                            } else {
                                            ?>
                                                <a title="View Detail" data-rel="tooltip" href="#" class="detailInterview btn btn-minier btn-white btn-block">
                                                    <i class="ace-icon fa fa-files-o bigger-100"></i> <?php echo $set->WawancaraKe . ' kali'; ?>
                                                </a>
                                            <?php
                                            }
                                            ?>
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
                                                        <a href="<?php echo site_url('printControl/viewBNI/' . $set->HeaderID) ?>" data-rel="tooltip" target="_blank" class="print"><small>Surat Penyataan BNI</small></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo site_url('printControl/viewMandiri/' . $set->HeaderID) ?>" data-rel="tooltip" target="_blank" class="print">Print Mandiri</a>
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
                                                            <a title="show Transkrip" data-rel="tooltip" href="#" class="berkas" data-name="Transkrip" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Transkrip Nilai</a>
                                                        <?php } else {
                                                            echo "<a><small><i>Transkrip is NULL</i></small></a>";
                                                        } ?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->SuratKontrak != NULL) { ?>
                                                            <a title="show Surat Kontrak" data-rel="tooltip" href="#" class="berkas" data-name="SuratKontrak" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Surat Kontrak</a>
                                                        <?php } else {
                                                            echo "<a><small><i>Surat Kontrak is NULL</i></small></a>";
                                                        } ?>
                                                    </li>
                                                </ul>
                                            </div>
                                            <a title="View Detail" data-rel="tooltip" href="#" class="detail btn btn-minier btn-round btn-primary">
                                                <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                                            </a>
                                        </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="10" class="center"><?php echo $_pagination; ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal View -->
<div class="modal fade" id="viewModalInterview" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Informasi Record Wawancara</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="detailInterview" class="well">
                    <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
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
        //$('#dataTables-listTK').dataTable();
        $('[data-rel=tooltip]').tooltip();

        $("#dataTables-listTK").on("click", ".detailInterview", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url: "<?php echo site_url('wawancaraTujuan/cekRecordInterview'); ?>",
                type: "POST",
                data: "kode=" + id,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#detailInterview").html(msg);
                }
            });
            $("#viewModalInterview").modal("show");
        });

        $("#dataTables-listTK").on("click", ".detail", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url: "<?php echo site_url('uploadBerkas/detailtk'); ?>",
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
<script>
    $('#printCheckedValue').click(function() {
        var val = [];
        var url = "<?php echo site_url('printControl/viewMandiriChecked/') ?>"
        $(':checkbox:checked').each(function(i) {
            val[i] = $(this).val();
        });
        var arrStr = encodeURIComponent(JSON.stringify(val));
        $(this).attr("href", url + arrStr)
    });

    $('.chkBox').click(function() {


        var cek = false;
        $(':checkbox:checked').each(function(i) {
            cek = true
        });

        if (cek) {
            $('#printCheckedValue').removeAttr('disabled');
        } else {
            $('#printCheckedValue').attr("disabled", "disabled");
        }
    })

    $('#ExportExcel').click(function() {
        var tanggalAwal = $('#txtDateA').val()
        var tanggalAkhir = $('#txtDateZ').val()
        var dataSelect = $('#inputDataFilter').val()
        var val = [];
        val[0] = tanggalAwal
        val[1] = tanggalAkhir
        val[2] = dataSelect
        var url = "<?php echo site_url('printControl/EksportExcel/') ?>"
        console.log(tanggalAwal, tanggalAkhir);

        var arrStr = encodeURIComponent(JSON.stringify(val));
        $(this).attr("href", url + arrStr)
    });
</script>