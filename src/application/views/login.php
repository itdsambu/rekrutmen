<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Recruitment Management System - Login</title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/img/user_accounts.png') ?>" />

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/ace-fonts.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/ace.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/ace-rtl.css') ?>" />

    <!-- Inline style with nonce -->
    <style nonce="<?= $csp_nonce ?>">
        .login-container {
            width: 400px;
        }
    </style>
</head>

<body class="login-layout light-login">

    <div class="main-container">
        <div class="main-content">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="login-container">

                        <div class="center">
                            <h3>
                                <i class="ace-icon fa fa-leaf green"></i>
                                <span class="red">Recruitment</span>
                                <!-- <span class="white" id="id-text2">Management System</span> -->
                            </h3>
                            <h4 class="grey" id="id-company-text">&copy;</h4>
                        </div>

                        <div class="space-6"></div>

                        <div class="position-relative">

                            <div id="login-box" class="login-box visible widget-box no-border">
                                <div class="widget-body">
                                    <div class="widget-main">

                                        <h4 class="header blue lighter bigger">
                                            <i class="ace-icon fa fa-lock green"></i>
                                            Please Enter Your Information
                                        </h4>

                                        <div class="space-6"></div>

                                        <?= form_open('login/login_user'); ?>
                                        <fieldset>

                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="text" class="form-control" placeholder="Username"
                                                        name="txtUserID" autocomplete="off" />
                                                    <i class="ace-icon fa fa-user"></i>
                                                </span>
                                            </label>

                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="password" class="form-control" placeholder="Password"
                                                        name="txtPass" autocomplete="off" />
                                                    <i class="ace-icon fa fa-lock"></i>
                                                </span>
                                            </label>

                                            <div class="space"></div>

                                            <div class="clearfix">
                                                <input class="btn btn-sm btn-block btn-success"
                                                    type="submit" name="login" value="Login" />
                                            </div>

                                            <div class="space-4"></div>
                                        </fieldset>

                                        <?php if ($this->session->flashdata('message')) : ?>
                                            <?= html_escape($this->session->flashdata('message')) ?>
                                        <?php endif; ?>

                                        </form>

                                    </div>
                                </div>
                            </div>

                            <!-- ABOUT BOX -->
                            <div id="forgot-box" class="forgot-box widget-box no-border">
                                <div class="widget-body">
                                    <div class="widget-main">

                                        <h4 class="header red lighter bigger">
                                            <i class="ace-icon fa fa-info"></i> About
                                        </h4>

                                        <div class="space-6"></div>
                                        <p>Rekrutmen</p>

                                        <div class="text-center">
                                            <span class="profile-picture">
                                                <img class="editable img-responsive"
                                                    alt="Author Avatar"
                                                    src="<?= base_url('assets/avatars/prog-pic.jpg') ?>" />
                                            </span>

                                            <div class="space-4"></div>

                                            <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                                <a href="mailto:ismo.lhavic@gmail.com"
                                                    class="user-title-label dropdown-toggle">
                                                    <i class="ace-icon fa fa-circle light-green"></i>
                                                    <span class="white">Author</span>
                                                </a>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="toolbar center">
                                        <a href="#" data-target="#login-box" class="back-to-login-link">
                                            Back to login
                                            <i class="ace-icon fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= JS FILES ================= -->

    <script src="<?= base_url('assets/js/jquery.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.mobile.custom.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.js') ?>"></script>
    <script src="<?= base_url('assets/js/ace.js') ?>"></script>

    <!-- Inline JS with nonce -->
    <script nonce="<?= $csp_nonce ?>">
        jQuery(function($) {
            $(document).on('click', '.toolbar a[data-target]', function(e) {
                e.preventDefault();
                var target = $(this).data('target');
                $('.widget-box.visible').removeClass('visible');
                $(target).addClass('visible');
            });
        });
    </script>

</body>

</html>
