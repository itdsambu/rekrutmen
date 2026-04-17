<div class="page-header">
    <h1>
        USER
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            User Profile
        </small>
    </h1>
</div>

<div class="row">
    <div class="tabbable">
        <ul class="nav nav-tabs padding-18">
            <li class="active">
                <a data-toggle="tab" href="#home" aria-expanded="true">
                    <i class="green ace-icon fa fa-user bigger-120"></i> Profile
                </a>
            </li>
            <!-- <li class="">
                <a data-toggle="tab" href="#agenda" aria-expanded="false">
                    <i class="orange ace-icon fa fa-calendar bigger-120"></i> Agenda
                </a>
            </li> -->
        </ul>
        <div class="tab-content no-border padding-24">
            <div id="home" class="tab-pane active">
                <div class="col-xs-12">
                    <div class="col-xs-12 col-sm-5 center">
                        <div>
                            <span class="profile-picture">
                                <?php
                                if ($profil->AdaPhoto == NULL) :
                                ?>
                                    <ul class="ace-thumbnails clearfix">
                                        <li>
                                            <img id="avatar" class="img-responsive" width="180" height="180" alt="<?php echo $profil->NamaBelakang; ?>'s Avatar" src="<?php echo base_url(); ?>/assets/avatars/profile-pic.jpg"></img>
                                            <div id="photo" class="tools tools-right">
                                                <a href="#" title="Change Photo" class="changePhoto" data-id="<?php echo $profil->LoginID; ?>">
                                                    <i class="ace-icon fa fa-edit"></i>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                <?php else : ?>
                                    <ul class="ace-thumbnails clearfix">
                                        <li>
                                            <img id="avatar" class="img-responsive" width="180" height="180" alt="<?php echo $profil->NamaBelakang; ?>'s Avatar" src="<?php echo base_url(); ?>/dataupload/fotoProfil/<?php echo $profil->LoginID; ?>.png"></img>
                                            <div id="photo" class="tools tools-right">
                                                <a href="#" title="Change Photo" class="changePhoto" data-id="<?php echo $profil->LoginID; ?>">
                                                    <i class="ace-icon fa fa-edit"></i>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                <?php endif; ?>
                            </span>
                            <div class="space-4"></div>

                            <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                <div class="inline position-relative">
                                    <div class="user-title-label dropdown-toggle">
                                        <i class="ace-icon fa fa-circle light-green"></i>
                                        &nbsp;
                                        <span class="white"><?php echo $profil->NamaUser; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space-6"></div>

                    </div>
                    <div class="col-xs-12 col-sm-7">
                        <div class="space-12"></div>
                        <!-- #section:pages/profile.info -->
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Username </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="username"><?php echo $profil->NamaUser; ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Nama Lengkap </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="username"><?php echo $profil->NamaDepan . " " . $profil->NamaBelakang; ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Department </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="username"><?php echo strtoupper($profil->DeptAbbr); ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Group User </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="username"><?php echo ucwords(strtolower($profil->GroupDescription)); ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Joined </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="signup"><?php echo $profil->CreatedDate; ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Last Online </div>
                                <div class="profile-info-value">
                                    <?php foreach ($_getLastLogin as $rowLast) : ?>
                                        <span class="editable editable-click" id="login"><?php echo $rowLast->Tanggal; ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <!-- /section:pages/profile.info -->
                        <div class="space-20"></div>
                    </div>
                </div>
            </div>
            <div id="agenda" class="tab-pane">
                <?php
                if ($_isMobile == 1) {
                    $display    = 'none';
                } else {
                    $display    = 'block';
                }
                ?>
                <!-- <div class="col-xs-12" style="display: <?php echo $display; ?>; border: none;">
                    <iframe class="col-xs-12" height="500" src="<?php echo site_url('mynotes'); ?>"></iframe>
                </div> -->
            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="viewChagePhoto" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Change Photo, <strong class="green"><?php echo $this->session->userdata('username'); ?></strong></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="formUpload" class="well">
                    <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewSetting" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Sunting Profile, <strong class="green"><?php echo $this->session->userdata('username'); ?></strong></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="formSetting" class="well">
                    <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(function($) {
        $('a[ data-original-title]').tooltip();

        $("#photo").on("click", ".changePhoto", function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?php echo site_url('user_profil/photo'); ?>",
                type: "POST",
                data: "kode=" + id,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#formUpload").html(msg);
                }
            });
            $("#viewChagePhoto").modal("show");
        });

        $("#setting").on("click", ".setting", function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?php echo site_url('user_profil/setting'); ?>",
                type: "POST",
                data: "kode=" + id,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#formSetting").html(msg);
                }
            });
            $("#viewSetting").modal("show");
        });
    });
</script>