<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title><?php echo $this->config->item("nama_app"); ?> | Login</title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel='shortcut icon' type='image icon' href="<?php echo base_url(); ?>assets/img/psg-logo.png" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.css" />

    <!-- text fonts -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-fonts.css" />

    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace.css" />

    <!--[if lte IE 9]>
                <link rel="stylesheet" href="../assets/css/ace-part2.css" />
        <![endif]-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-rtl.css" />

    <!--[if lte IE 9]>
          <link rel="stylesheet" href="../assets/css/ace-ie.css" />
        <![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
        <script src="../assets/js/html5shiv.js"></script>
        <script src="../assets/js/respond.js"></script>
        <![endif]-->

    <style>
        .login-container {
            width: 400px;
        }
    </style>
</head>

<body class="login-layout light-login">
    <div class="main-container">
        <div class="main-content">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1" style="margin-top: 40px ;">
                    <div class="login-container">
                        <div class="center">
                            <h3>
                                <i class="ace-icon fa fa-leaf green"></i>
                                <span class="red">Recruitment</span>
                                <span class="white" id="id-text2">Management Systems</span>
                            </h3>
                        </div>

                        <div class="space-6"></div>

                        <div class="position-relative">
                            <div id="login-box" class="login-box visible widget-box no-border">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <h4 class="header blue lighter bigger">
                                            <i class="ace-icon fa fa-lock green"></i>
                                            Silahkan Login
                                        </h4>

                                        <?php
                                        if ($this->session->flashdata('message')) :
                                            echo $this->session->flashdata('message');
                                        endif;
                                        ?>

                                        <div class="space-6"></div>

                                        <?php echo form_open('login/login_user2'); ?>
                                        <fieldset>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="text" class="form-control" placeholder="Username" name="txtUserID" autocomplete="off" />
                                                    <i class="ace-icon fa fa-user"></i>
                                                </span>
                                            </label>

                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="password" class="form-control" placeholder="Password" name="txtPass" autocomplete="off" />
                                                    <i class="ace-icon fa fa-lock"></i>
                                                </span>
                                            </label>

                                            <div class="space"></div>

                                            <div class="clearfix">
                                                <!-- <label class="inline">
                                                            <input type="checkbox" class="ace" />
                                                            <span class="lbl"> Remember Me</span>
                                                        </label>-->
                                                <span class="block input-icon input-icon-right">
                                                    <input class="btn btn-sm btn-block btn-success" type="submit" name="login" value="Login" />
                                                </span>

                                            </div>

                                            <div class="space-4"></div>
                                        </fieldset>
                                        </form>

                                    </div><!-- /.widget-main -->
                                    <div class="toolbar clearfix center" style="padding: 10px ;">
                                        <a href="#" class="forgot-password-link">
                                            &copy; PT Pulau Sambu di Guntung - <?= date('Y'); ?>
                                        </a>
                                    </div>
                                    <!-- <div class="toolbar center">
                                            <a href="#" data-target="#forgot-box" class="forgot-password-link">
                                                <i class="ace-icon fa fa-info-circle"></i>
                                                About
                                            </a>
                                        </div>-->

                                </div><!-- /.widget-body -->
                            </div><!-- /.login-box -->
                            <!--
                                <div id="forgot-box" class="forgot-box widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header red lighter bigger">
                                                <i class="ace-icon fa fa-key"></i>
                                                Retrieve Password
                                            </h4>

                                            <div class="space-6"></div>
                                            <p>
                                                Enter your email and to receive instructions
                                            </p>

                                            <form>
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="email" class="form-control" placeholder="Email" />
                                                            <i class="ace-icon fa fa-envelope"></i>
                                                        </span>
                                                    </label>

                                                    <div class="clearfix">
                                                        <button type="button" class="width-35 pull-right btn btn-sm btn-danger">
                                                            <i class="ace-icon fa fa-lightbulb-o"></i>
                                                            <span class="bigger-110">Send Me!</span>
                                                        </button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div> /.widget-main

                                        <div class="toolbar center">
                                            <a href="#" data-target="#login-box" class="back-to-login-link">
                                                Back to login
                                                <i class="ace-icon fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div> /.widget-body
                                </div> /.forgot-box -->
                        </div><!-- /.position-relative -->

                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.main-content -->
    </div><!-- /.main-container -->

    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script type="text/javascript">
        window.jQuery || document.write("<script src='<?php echo base_url(); ?>assets/js/jquery.js'>" + "<" + "/script>");
    </script>

    <!-- <![endif]-->

    <!--[if IE]>
        <script type="text/javascript">
        window.jQuery || document.write("<script src='../assets/js/jquery1x.js'>"+"<"+"/script>");
        </script>
        <![endif]-->
    <script type="text/javascript">
        if ('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url(); ?>assets/js/jquery.mobile.custom.js'>" + "<" + "/script>");
    </script>

    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        jQuery(function($) {
            $(document).on('click', '.toolbar a[data-target]', function(e) {
                e.preventDefault();
                var target = $(this).data('target');
                $('.widget-box.visible').removeClass('visible'); //hide others
                $(target).addClass('visible'); //show target
            });
        });
    </script>

    <!-- Disabled -->
    <script src="<?= base_url(); ?>assets/js/disable.js"></script>

    <script>
        var a = <?= ENVIRONMENT == 'development' ? 'true' : 'false' ?>;

        if (!a) {
            DisableDevtool({
                disableMenu: false,
            });
        }
    </script>

</body>

</html>