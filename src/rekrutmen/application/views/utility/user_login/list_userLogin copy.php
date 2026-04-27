<div class="page-header">
    <h1>
        MANAGEMENT USER
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            List User Login
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
                        <h4 class="widget-title">List User Login</h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
                            <?php if ($this->session->flashdata('_message')): ?>
                                <div class="alert <?= ($_GET['success'] == 'ok' ? 'alert-success' : 'alert-danger') ?> alert-dismissible" rolw="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                                    <strong><?= ($_GET['success'] == 'ok' ? 'Well done' : 'Oh snap') ?>!</strong> <?= $this->session->flashdata('_message') ?>
                                </div>
                            <?php endif; ?>
                            <div class="table-responsive">
                                <table id="dataTables-userLogin" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Username (ID)</th>
                                            <th>NIK</th>
                                            <th>Nama User (Pengguna)</th>
                                            <th>Department</th>
                                            <th>Grup User</th>
                                            <th>Status Personal</th>
                                            <th>Status User</th>
                                            <th>Screen Team</th>
                                            <th>
                                                <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Created Date
                                            </th>
                                            <th>
                                                <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Updated Date
                                            </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        foreach ($getUserLogin as $setUser):
                                            foreach ($dtdepartemen as $row) {
                                                if ($row->deptid == $setUser->DeptID) {
                                                    $DeptAbbrNEW = $row->deptabbr;
                                                }
                                            }
                                        ?>
                                            <tr>
                                                <td><?php echo $setUser->LoginID; ?></td>
                                                <td><?php echo $setUser->NIK; ?></td>
                                                <!-- <td><?php echo $setUser->NamaUser; ?></td> -->
                                                <td><?= html_escape(preg_replace('/[^a-zA-Z0-9\s]/', '', $setUser->NamaUser)) ?>
                                                </td>
                                                <td><?php echo $setUser->DeptAbbr; ?></td>
                                                <td><?php echo $setUser->GroupDescription; ?></td>
                                                <td><?php if ($setUser->PersonalStatus == '1') {
                                                        echo 'KARYAWAN ';
                                                    } else if ($setUser->PersonalStatus == '2') {
                                                        echo 'TENAGA KERJA ';
                                                    } else if ($setUser->PersonalStatus == '3') {
                                                        echo 'TAMU ';
                                                    } else {
                                                        echo '<i>unregistered</i>';
                                                    } ?></td>
                                                <td><?php
                                                    /// catatan :
                                                    /// ===
                                                    /// status user Karyawan/ Tenaga Kerja akan aktif hanya jika :
                                                    /// 1. terdaftar sebagai karyawan/ tenaga kerja aktif.
                                                    /// 2. terdaftar sebagai user aktif di onelogin.
                                                    /// 3. terdaftar sebagai user aktif di aplikasi ini.
                                                    /// ===
                                                    /// status user tamu akan aktif hanya jika :
                                                    /// 1. terdaftar sebagai user aktif di aplikasi ini.
                                                    /// ===
                                                    if ($setUser->NotActive == '0' && count($setUser->children) > 0 && $setUser->PersonalStatus != '3') {
                                                        foreach ($setUser->children2 as $children2_row) {
                                                            if ($children2_row->userOnelogin == 1) {
                                                                echo "<span class='label label-sm label-primary'>Active</span>";
                                                                break;
                                                            } else {
                                                                echo "<span class='label label-sm label-danger'>Not Active</span>";
                                                            }
                                                        }
                                                    } else if ($setUser->NotActive == '0' && $setUser->PersonalStatus == '3') {
                                                        echo "<span class='label label-sm label-primary'>Active</span>";
                                                    } else {
                                                        echo "<span class='label label-sm label-danger'>Not Active</span>";
                                                    } ?></td>
                                                <td class="text-center"><?php if ($setUser->AnggotaScreening === 1) {
                                                                            echo "<span class='label label-sm label-primary'>YES <i class='ace-icon glyphicon glyphicon-ok'></i></span>";
                                                                        } else {
                                                                            echo "<span class='label label-sm label-danger'>NOT <i class='ace-icon glyphicon glyphicon-remove'></i></span>";
                                                                        } ?>
                                                </td>
                                                <td><?php echo $setUser->CreatedDate; ?></td>
                                                <td><?php if ($setUser->UpdatedDate == NULL) {
                                                        echo "Belum Terupdate";
                                                    } else {
                                                        echo
                                                        $setUser->UpdatedDate;
                                                    } ?></td>
                                                <td>
                                                    <a class="green tooltip-success" href="<?php echo site_url('user_login/editUserLogin') . "?id=" . $setUser->LoginID; ?>"
                                                        title="Edit User!" data-rel="tooltip"><i class="ace-icon fa fa-pencil bigger-130"></i>
                                                    </a>
                                                    <a class="blue tooltip-info" href="<?php echo site_url('user_login/ubahPassword') . "?id=" . $setUser->LoginID; ?>"
                                                        title="Ubah password!" data-rel="tooltip"><i class="ace-icon fa fa-key bigger-130"></i>
                                                    </a>
                                                    <a href="#" data-act="bootbox-delete" class="delete red tooltip-error" data-id="<?php echo $setUser->LoginID; ?>" title="Delete User!" data-rel="tooltip">
                                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="widget-toolbox padding-8 clearfix">
                            <a href="<?php echo base_url("user_login/index"); ?>" class="btn btn-xs btn-primary btn-bold pull-left">
                                <i class="ace-icon fa fa-floppy-o bigger-120"></i>
                                Tambah User
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-userLogin').dataTable();

        $('[data-rel=tooltip]').tooltip();
    });
</script>
<script src="<?php echo base_url(); ?>assets/js/bootbox.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        $("#dataTables-userLogin").on("click", ".delete", function() {
            var id = $(this).data('id');
            bootbox.confirm("Apakah anda yakin untuk menghapus User Login dengan UserID =  " + id + " ?", function(result) {
                if (result) {
                    window.location = 'deleteUserLogin?id=' + id;
                }
            });
        });
    });
</script>
