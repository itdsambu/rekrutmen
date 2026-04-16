<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/checkboxall.js"></script>
<div class="page-header">
    <h1>
        TRANSAKSI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Approval Request by Department
        </small>
    </h1>
</div><!-- /.page-header -->

<?php
$att = array('class' => 'form-horizontal', 'role' => 'form');
echo form_open('approval/multiApprovalDept', $att);
?>
<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Requisition who want approved</h4>

                <div class="widget-toolbar">
                    <a href="" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <?php
                    if ($this->input->get('msg') == 'Success') {
                        echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                                    <i class='ace-icon fa fa-times'></i></button>Screening by TEAM Success!</p>";
                    }
                    ?>
                    <div class="table-responsive">
                        <table id="dataTables-listTK" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" rowspan="2">
                                        <label class="pos-rel">
                                            <input type="checkbox" class="ace" onclick="checkUncheckAll(this);">
                                            <span class="lbl"></span>
                                        </label>
                                    </th>
                                    <th rowspan="2">ID</th>
                                    <th rowspan="2">Departemen</th>
                                    <th rowspan="2">Posisi/ Pekerajaan</th>
                                    <th rowspan="2">Pemborong</th>
                                    <th colspan="3" class="text-center">Permintaan</th>
                                    <th rowspan="2">
                                        <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Requested By
                                    </th>
                                    <th rowspan="2">
                                        <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Requested Date
                                    </th>
                                    <th rowspan="2" class="text-center">Opsi</th>
                                </tr>
                                <tr>
                                    <th>Target</th>
                                    <th>Tersedia</th>
                                    <th>Permintaan</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($_getTran as $set) :
                                ?>
                                    <?php
                                    echo '<tr data-id="' . $set->DetailID . '" class="rowdetail info" >';
                                    ?>
                                    <td class="text-center">
                                        <div class="checkbox">
                                            <label class="pos-rel">
                                                <input name="ckDetailID[]" type="checkbox" class="ace" value="<?php echo $set->DetailID; ?>">
                                                <span class="lbl"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td style="width: 50px; " class="text-right"><?php echo $set->DetailID; ?></td>
                                    <td><?php echo $set->DeptAbbr; ?></td>
                                    <td><?php echo $set->Pekerjaan; ?></td>
                                    <td><?php echo $set->Pemborong; ?></td>
                                    <td><?php echo $set->TKTarget; ?></td>
                                    <td><?php echo $set->TKSedia; ?></td>
                                    <td><?php echo $set->TKPermintaan; ?></td>
                                    <td><?php echo $set->CreatedBy; ?></td>
                                    <td class="text-right"><?php echo $set->CreatedDate; ?></td>
                                    <td class="text-center">
                                        <a title="View Issue" data-rel="tooltip" href="#" class="detail btn btn-minier btn-round btn-primary">
                                            <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                                        </a>
                                        <span title="View Issue" data-rel="tooltip" class="approval btn btn-minier btn-round btn-primary">
                                            <i class="ace-icon fa fa-files-o bigger-100"></i> Approval
                                        </span>
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
                    <input type="submit" value="Approve" name="Submit" class="btn btn-success">
                    <input type="submit" value="Decline" name="Submit" class="btn btn-danger">
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<!-- Modal View Screening-->

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

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-listTK').dataTable();

        var active_class = 'active';
        $('#dataTables-listTK > thead > tr > th input[type=checkbox]').eq(0).on('click', function() {
            var th_checked = this.checked; //checkbox inside "TH" table header
            $(this).closest('table').find('tbody > tr').each(function() {
                var row = this;
                if (th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
            });
        });

        $("#dataTables-listTK").on("click", ".approval", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url: "<?php echo site_url('approval/viewApprovalDept'); ?>",
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


        $("#dataTables-listTK").on("click", ".detail", function() {
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