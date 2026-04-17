<div id="navbar" class="navbar navbar-default navbar-fixed-top">
    <script type="text/javascript">
        try {
            ace.settings.check('navbar', 'fixed');
        } catch (e) {}
    </script>
    <div class="navbar-container" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="navbar-header pull-left">
            <a href="<?php echo base_url(); ?>" class="navbar-brand">
                <small>
                    <i class="fa fa-users"></i>
                    <?php echo $this->config->item("nama_app"); ?>
                </small>
            </a>
        </div>
        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="grey">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <?php
                        foreach ($_getProfil as $row) :
                            if ($row->AdaPhoto == 1) :
                        ?>
                                <img class="nav-user-photo" src="<?php echo base_url(); ?>/dataupload/fotoProfil/<?php echo $row->LoginID; ?>.png" alt="<?php echo htmlspecialchars($row->NamaBelakang, ENT_QUOTES, 'UTF-8'); ?>'s Photo" />
                            <?php else : ?>

                                <img class="nav-user-photo" src="<?php echo base_url(); ?>/assets/avatars/profile-pic.jpg" alt="User's Photo" />
                        <?php
                            endif;
                        endforeach;
                        ?>
                        <span class="user-info">
                            <small>Welcome,</small>
                            <?php echo
                            html_escape(preg_replace('/[^a-zA-Z0-9\s]/', '', $this->session->userdata('username')))
                            ?>
                        </span>
                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="<?php echo base_url('welcome/viewUbahPassword'); ?>">
                                <i class="ace-icon fa fa-cog"></i>
                                Ubah Password
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('user_profil/index'); ?>">
                                <i class="ace-icon fa fa-user"></i>
                                Profile
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo base_url('welcome/logout'); ?>">
                                <i class="ace-icon fa fa-power-off"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
