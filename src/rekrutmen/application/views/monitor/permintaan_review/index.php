<?php
/*
 * Author : Ismo___
 */

?>
<div class="page-header">
    <h1>
        MONITOR
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Issue Permintaan
        </small>
    </h1>
</div><!-- /.page-header -->
<?php
if ($this->session->userdata('groupuser') == '13' || $this->session->userdata('groupuser') == '79' || $this->session->userdata('groupuser') == '44' || $this->session->userdata('groupuser') == '139' || $this->session->userdata('groupuser') == '15' || $this->session->userdata('groupuser') == '93') : ?>
    <!-- <div class="row">
    <div class="col-ms-12">
        <div class="col-xs-12">
            <h4 class="widget-title" style="font-family: 12px;"><i class="fa fa-bullhorn"></i> <strong>Information :</strong></h4>
        </div>
        <div class="col-xs-6">
            <table class="table table-bordered" >
                <thead>
                    <tr>
                        <th></th>
                        <th>Request </th>
                        <th>Success</th>
                        <th>Sisa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_getKaryawan as $K) { ?>
                    <tr>
                        <td><strong>Karyawan</strong></td>
                        <td><span class="label label-sm label-primary"><?php echo $K->jmlRequestK . ' Orang' ?></span></td>
                        <td><span class="label label-sm label-warning"><?php echo $K->jmlSuccess . ' Orang' ?></span></td>
                        <td><span class="label label-sm label-danger"><?php echo $K->JmlSisa . ' Orang' ?></span></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-xs-6">
            <table class="table table-bordered" >
                <thead>
                    <tr>
                        <th></th>
                        <th>Request </th>
                        <th>Success</th>
                        <th>Sisa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_getTenaker as $TK) { ?>
                    <tr>
                        <td><strong>Harian / Borongan</strong></td>
                        <td><span class="label label-sm label-primary"><?php echo $TK->JmlRequest . ' Orang' ?></span></td>
                        <td><span class="label label-sm label-warning"><?php echo $TK->JmlSuccess . ' Orang' ?></span></td>
                        <td><span class="label label-sm label-danger"><?php echo $TK->JmlSisa . ' Orang' ?></span></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div> -->
<?php endif; ?>
<div class="row">
    <div class="col-ms-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">List Permintaan</h4>

                <div class="widget-toolbar">
                    <a href="<?php echo base_url('monitor/CetakreviewIssue/' . $jenis . '/' . $_selStatus); ?>" class="btn btn-minier btn-success fa fa-file-excel-o bigger-120" target="_blank">Export to Excel</a>
                </div>
                <div class="widget-toolbar">

                    <form action="<?php echo site_url('monitor/reviewIssue'); ?>" method="POST" class="form-inline">
                        <select name="selStatus" id="inputStatus">
                            <option value="pending">Pending (Default)</option>
                            <option value="approved" <?php if ($_selStatus == 1) {
                                                            echo 'selected';
                                                        } ?>>Approved </option>
                            <option value="canceled" <?php if ($_selStatus == 2) {
                                                            echo 'selected';
                                                        } ?>>Canceled </option>
                            <option value="closed" <?php if ($_selStatus == 3) {
                                                        echo 'selected';
                                                    } ?>>Closed </option>
                        </select>
                        <button class="btn btn-minier btn-primary" name="btnGo" id="btnGo" style="display: inline;">
                            <i class="ace-icon fa fa-arrow-right"></i> Go!
                        </button>
                    </form>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <?php if ($this->session->userdata('userid') == 'psn_gia' || $this->session->userdata('userid') == 'YULI1234') : ?>
                        <?php
                        if ($this->input->get('msg') == 'success_delete') {
                            echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                            <i class='ace-icon fa fa-times'></i></button>Data behasil dihapus..</p>";
                        } elseif ($this->input->get('msg') == 'failed_delete') {
                            echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
                            <i class='ace-icon fa fa-times'></i></button>Data tidak behasil dihapus..</p>";
                        } else {
                            echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                            <i class='ace-icon fa fa-times'></i></button><strong>Pemberitahuan!</strong> Aksi <strong>Delete</strong> sudah ok, silahkan digunakan..  Terima kasih..</p>";
                        }
                        ?>
                    <?php else : ?>
                    <?php endif; ?>
                    <div class="form-group">
                        <div>
                            <div class="radio col-sm-11">
                                <label>
                                    <input name="txtJekel" type="radio" class="ace" value="Harian" onclick="window.location.href ='../monitor/reviewIssue?jenis=harian&status='+$('#inputStatus').val();" <?php if ($jenis == 'harian') {
                                                                                                                                                                                                                echo 'checked="checked"';
                                                                                                                                                                                                            } ?> />
                                    <span class="lbl"> Harian</span>
                                </label>
                            </div>
                            <div class="radio col-sm-11">
                                <label>
                                    <input name="txtJekel" type="radio" class="ace" value="Karyawan" onclick="window.location.href ='../monitor/reviewIssue?jenis=PSG&status='+$('#inputStatus').val();" <?php if ($jenis == 'PSG') {
                                                                                                                                                                                                                echo 'checked="checked"';
                                                                                                                                                                                                            } ?> />
                                    <span class="lbl"> Karyawan</span>
                                </label>
                            </div>
                            <div id="cek_all" align="right">
                                <a title="View All Identifikasi" data-rel="tooltip" onclick="window.open('../monitor/viewallidentifikasiapproved?jenis=PSG&status='+$('#inputStatus').val());" class="cek_all_identifikasi btn btn-minier btn-round btn-danger">
                                    <i class="ace-icon fa fa-users bigger-100"></i> Cek All
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="table table-responsive">
                                <table id="dataTables-Issue" class="table ">
                                    <thead style="font-size: 12px;" class=" sticky-header">
                                        <tr>
                                            <th rowspan="2">ID</th>
                                            <th rowspan="2">Departemen</th>
                                            <th rowspan="2">Posisi/ Pekerjaan</th>
                                            <th class="text-center" colspan="4">Realisasi</th>
                                            <th class="text-center" colspan="5">Approval</th>
                                            <th rowspan="2">Status</th>
                                            <?php if ($_selStatus == '3') { ?>
                                                <th rowspan="2">Tanggal Closed</th>
                                            <?php } ?>
                                            <th rowspan="2">
                                                <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Jabatan
                                            </th>
                                            <th rowspan="2">
                                                <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Sub Jabatan
                                            </th>
                                            <th rowspan="2">
                                                <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Requested By
                                            </th>
                                            <th rowspan="2">
                                                <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Requested Date
                                            </th>
                                            <th rowspan="2" class="text-center">Opsi</th>
                                        </tr>
                                        <tr>
                                            <th>Minta</th>
                                            <th>Success</th>
                                            <th>Sisa</th>
                                            <th>Jumlah yang sudah diidentifikasi</th>
                                            <th>Dept</th>
                                            <th>Divisi</th>
                                            <th>PSN</th>
                                            <th>AGM</th>
                                            <th>VGM</th>
                                        </tr>
                                    </thead>

                                    <tbody id="">
                                        <?php
                                        $tot_sisa = 0;
                                        $tot_penuhi = 0;
                                        $tot_minta = 0;
                                        $tot_identifikasi = 0;
                                        foreach ($_getIssue as $row) :
                                        ?>
                                            <?php
                                            echo '<tr 
                                    data-id="' . $row->DetailID . '" class="rowdetail" >';
                                            $target         = $row->TKTarget;
                                            $sedia          = $row->TKSedia;
                                            $minta          = $row->TKPermintaan;
                                            $jumlahID       = $row->Identifikasi;

                                            $sisa           = $target - $sedia;
                                            $penuhi         = $sisa - $minta;
                                            $diidentifikasi = $jumlahID - $penuhi;

                                            // rumus baru
                                            // astaga pabo, gini aja gak diperbaiki.
                                            $penuhi2 = $row->Success;
                                            $minta2 = $sisa - $penuhi2;
                                            $diidentifikasi2 = $jumlahID - $penuhi2;

                                            $tot_sisa         += $sisa;
                                            $tot_penuhi       += $penuhi2;
                                            $tot_minta        += $minta2;
                                            $tot_identifikasi += $diidentifikasi2;


                                            ?>
                                            <td class="text-right" id=""><?php echo $row->DetailID; ?></td>
                                            <td><?php echo $row->DeptAbbr; ?></td>
                                            <td><?php echo $row->Pekerjaan; ?></td>
                                            <td class="text-center"><?php echo $sisa; ?></td>
                                            <td class="text-center"><?php echo $penuhi2; ?></td>
                                            <td class="text-center"><?php echo $minta2; ?></td>
                                            <td class="text-center"><?php echo ($diidentifikasi2) < 0 ? 0 : ($diidentifikasi2); ?></td>
                                            <td class="text-center">
                                                <div class="text-left">
                                                    <?php if ($row->DEPTStatus == 1) {
                                                        echo $row->DEPTApproval . ' <i class="ace-icon fa fa-check green"></i>';
                                                    } elseif ($row->DEPTStatus == 2) {
                                                        echo $row->DEPTApproval . ' <i class="ace-icon fa fa-times red"></i>';
                                                    } else {
                                                        echo '<span class="label label-sm label-warning">Pending</span>';
                                                    } ?>
                                                    <?php if ($row->DEPTDate != NULL) { ?></div>
                                                <div class="text-right smaller-80"><?php echo date('d M Y H:m:i', strtotime($row->DEPTDate)); ?></div>
                                            <?php } ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="text-left">
                                                    <?php if ($row->DIVISIStatus == 1) {
                                                        echo $row->DIVISIApproval . ' <i class="ace-icon fa fa-check green"></i>';
                                                    } elseif ($row->DIVISIStatus == 2) {
                                                        echo $row->DIVISIApproval . ' <i class="ace-icon fa fa-times red"></i>';
                                                    } else {
                                                        echo '<span class="label label-sm label-warning">Pending</span>';
                                                    } ?>
                                                    <?php if ($row->DIVISIDate != NULL) { ?></div>
                                                <div class="text-right smaller-80"><?php echo date('d M Y H:m:i', strtotime($row->DIVISIDate)); ?></div>
                                            <?php } ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="text-left">
                                                    <?php if ($row->PSNStatus == 1) {
                                                        echo $row->PSNApproval . ' <i class="ace-icon fa fa-check green"></i>';
                                                    } elseif ($row->PSNStatus == 2) {
                                                        echo $row->PSNApproval . ' <i class="ace-icon fa fa-times red"></i>';
                                                    } else {
                                                        echo '<span class="label label-sm label-warning">Pending</span>';
                                                    } ?>
                                                    <?php if ($row->PSNDate != NULL) { ?></div>
                                                <div class="text-right smaller-80"><?php echo date('d M Y H:m:i', strtotime($row->PSNDate)); ?></div>
                                            <?php } ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="text-left">
                                                    <?php if ($row->AGMStatus == 1) {
                                                        echo $row->AGMApproval . ' <i class="ace-icon fa fa-check green"></i>';
                                                    } elseif ($row->AGMStatus == 2) {
                                                        echo $row->AGMApproval . ' <i class="ace-icon fa fa-times red"></i>';
                                                    } else {
                                                        echo '<span class="label label-sm label-warning">Pending</span>';
                                                    } ?>
                                                    <?php if ($row->AGMDate != NULL) { ?></div>
                                                <div class="text-right smaller-80"><?php echo date('d M Y H:m:i', strtotime($row->AGMDate)); ?></div>
                                            <?php } ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="text-left">
                                                    <?php if ($row->VGMStatus == 1) {
                                                        echo $row->VGMApproval . ' <i class="ace-icon fa fa-check green"></i>';
                                                    } elseif ($row->VGMStatus == 2) {
                                                        echo $row->VGMApproval . ' <i class="ace-icon fa fa-times red"></i>';
                                                    } else {
                                                        echo '<span class="label label-sm label-warning">Pending</span>';
                                                    } ?>
                                                    <?php if ($row->VGMDate != NULL) { ?></div>
                                                <div class="text-right smaller-80"><?php echo date('d M Y H:m:i', strtotime($row->VGMDate)); ?></div>
                                            <?php } ?>
                                            </td>
                                            <td class="text-center"><?php
                                                                    if ($row->DEPTStatus == 2 || $row->DIVISIStatus == 2 || $row->PSNStatus == 2 || $row->AGMStatus == 2 || $row->VGMStatus == 2) {
                                                                        echo '<span class="label label-sm label-danger">Canceled</span>';
                                                                    } elseif ($row->GeneralStatus == 1) {
                                                                        echo '<span class="label label-sm label-success">Approved</span>';
                                                                    } elseif ($row->GeneralStatus == 2) {
                                                                        echo '<span class="label label-sm label-danger">Canceled</span>';
                                                                    } elseif ($row->GeneralStatus == 3) {
                                                                        echo '<span class="label label-sm label-default">Closed</span>';
                                                                    } else {
                                                                        echo '<span class="label label-sm label-warning">Pending</span>';
                                                                    } ?></td>
                                            <?php if ($_selStatus == '3') { ?>
                                                <td><?php echo $row->UpadatedPostDate != NULL ? date('d-m-Y H:i:s', strtotime($row->UpadatedPostDate)) : ''; ?></td>
                                            <?php } ?>
                                            <td><?= $row->JabatanName ?></td>
                                            <td><?= $row->SubJabatanName ?></td>
                                            <td><?php echo $row->CreatedBy; ?></td>
                                            <td class="text-right"><?php echo $row->CreatedDate; ?></td>
                                            <td class="text-center">
                                                <a title="View Issue" data-rel="tooltip" href="#" class="approval btn btn-minier btn-round btn-primary">
                                                    <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                                                </a>
                                                <!--<a title="View Issue" data-rel="tooltip" href="#" class="cek btn btn-minier btn-round btn-danger">
											<i class="ace-icon fa fa-users bigger-100"></i> Cek
										</a>-->
                                                <a title="View Issue" data-rel="tooltip" href="<?php echo site_url('monitor/viewcek') . "?id=" . $row->DetailID; ?>" target="_blank" class="cek btn btn-minier btn-round btn-danger">
                                                    <i class="ace-icon fa fa-users bigger-100"></i> Cek
                                                </a>
                                                <span></span>
                                                <?php
                                                if ($this->session->userdata('userid') == 'psn_gia' || $this->session->userdata('userid') == 'psn_lisa' || $this->session->userdata('userid') == 'riyan' || $this->session->userdata('userid') == 'kiki' || $this->session->userdata('userid') == 'YULI1234' || $this->session->userdata('userid') == 'KIKI') : ?>
                                                    <a title="View Issue" data-rel="tooltip" href="#" class="edit btn btn-minier btn-round btn-primary" hidden>
                                                        <i class="ace-icon fa fa-pencil bigger-100"></i> Edit
                                                    </a>
                                                    <a href="#" data-act="bootbox-delete" id="DetailID" class="delete red tooltip-error btn btn-minier btn-round btn-danger" data-id="<?php echo $row->DetailID; ?>" title="Delete Issue!" data-rel="tooltip">
                                                        <i class="ace-icon fa fa-trash-o bigger-130"></i> Hapus
                                                    </a>
                                                <?php else : ?>
                                                <?php endif; ?>
                                            </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <?php if ($this->session->userdata('groupuser') == '13' || $this->session->userdata('groupuser') == '79' || $this->session->userdata('groupuser') == '44' || $this->session->userdata('groupuser') == '139' || $this->session->userdata('groupuser') == '15' || $this->session->userdata('groupuser') == '93') : ?>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3">Total</th>
                                                <th style="text-align: center; vertical-align: middle;"><span class="label label-sm label-primary"><?= $tot_sisa; ?></span></th>
                                                <th style="text-align: center; vertical-align: middle;"><span class="label label-sm label-success"><?= $tot_penuhi; ?></span></th>
                                                <th style="text-align: center; vertical-align: middle;"><span class="label label-sm label-danger"><?= $tot_minta; ?></span></th>
                                                <th style="text-align: center; vertical-align: middle;"><span class="label label-sm label-warning"><?= $tot_identifikasi; ?></span></th>
                                                <th colspan="9"></th>
                                            </tr>
                                        </tfoot>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="viewModalApproval" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <!--style="background-color: #008cba">-->
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Approval Department by <strong class="green"><?php echo $this->session->userdata('username'); ?></strong></h4>
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
        <div class="modal fade" id="viewModalEdit" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <!--style="background-color: #008cba">-->
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Edit Issue Permintaan <strong class="green"><?php echo $this->session->userdata('username'); ?></strong></h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="inputdetail" name="iddetail">
                        <div id="edit" class="well">
                            <!--load tabel dari file detail.php melalui javascript-->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/jqv/jquery.fixedTblHdrLftCol.js"></script>

<script>
$(function() {
    $('table').fixedTblHdrLftCol({
        scroll: {
            height: '200px',
            width: '550px'
        }
    });
});
</script> -->
        <script src="<?php echo base_url(); ?>assets/js/bootbox.js"></script>
        <script type="text/javascript">
            jQuery(function($) {
                $("#dataTables-Issue").on("click", ".delete", function() {
                    var id = $(this).data('id');
                    bootbox.confirm("Apakah anda yakin untuk menghapus Issue Permintaan dengan DetailID =  " + id + " ?", function(result) {
                        if (result) {
                            window.location = 'deleteIssue?id=' + id;
                        }
                    });
                });
            });
        </script>
        <script type="text/javascript">
            $("#selMonth").change(function() {
                var selected = $("#selMonth").val();

                if (selected === 'Default') {
                    location.href = '<?php echo site_url('monitor/reviewIssue'); ?>';
                }
            });

            $("#inputStatus").change(function() {
                var selected = $("#inputStatus").val();

                if (selected === 'pending') {
                    location.href = '<?php echo site_url('monitor/reviewIssue'); ?>';
                }
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#dataTables-Issue').dataTable({
                    "order": [
                        [0, 'desc']
                    ]
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#dataTables-Issue").on("click", ".approval", function() {
                    var id = $(this).closest('tr').data('id');
                    $.ajax({
                        url: "<?php echo site_url('monitor/viewApprovalDetail'); ?>",
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
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#dataTables-Issue").on("click", ".edit", function() {
                    var id = $(this).closest('tr').data('id');
                    $.ajax({
                        url: "<?php echo site_url('monitor/viewEditIssue'); ?>",
                        type: "POST",
                        data: "kode=" + id,
                        datatype: "json",
                        cache: false,
                        success: function(msg) {
                            $("#edit").html(msg);
                        }
                    });
                    $("#viewModalEdit").modal("show");
                });
            });
        </script>
        <!-- List Identifikasi Approved Karyawan ALL -->
        <script type="text/javascript">
            $(document).ready(function() {
                var status = $("#inputStatus").val();
                var jenis_pekerja = $('input[name="txtJekel"]:checked').val();
                console.log(status, jenis_pekerja);
                var asd = <?= $this->session->userdata('groupuser'); ?>;
                if (status != 'approved') {
                    $("#cek_all").prop("hidden", "true");
                } else {
                    if (jenis_pekerja != 'Karyawan') {
                        $("#cek_all").prop("hidden", "true");
                    }
                }

            });
        </script>
        <script type='text/javascript'>
            //<![CDATA[
            $(document).ready(function() {
                // Menentukan elemen yang dijadikan sticky yaitu #NavbarMenuAtas
                /*  var stickyNavTop = $('#NavbarMenuAtas').offset().top; 
                 var stickyNav = function(){
                     var scrollTop = $(window).scrollTop();  
                     // Kondisi jika discroll maka menu akan selalu diatas, dan sebaliknya        
                     if (scrollTop > stickyNavTop) { 
                         $('#NavbarMenuAtas').css({ 'position': 'fixed', 'top':0, 'z-index':9999 });
                     } else {
                         $('#NavbarMenuAtas').css({ 'position': 'absolute', 'top':-9999, 'left':-9999 });
                     }
                 };
                 // Jalankan fungsi
                 stickyNav();
                 $(window).scroll(function() {
                     stickyNav();
                 }); */
            });
            //]]>
        </script>