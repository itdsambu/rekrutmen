<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Maintenance Page</title>

        <meta name="description" content="User login page" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link rel='shortcut icon' type='image icon' href="<?php echo base_url(); ?>assets/img/maintenance.png"/>

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.css" />

        <!-- text fonts -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-fonts.css" />

        <!-- ace styles -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace.css" />

        <!--[if lte IE 9]>
                <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-part2.css" />
        <![endif]-->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-rtl.css" />

        <!--[if lte IE 9]>
          <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-ie.css" />
        <![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!--[if lt IE 9]>
        <script src="<?php echo base_url();?>assets/js/html5shiv.js"></script>
        <script src="<?php echo base_url();?>assets/js/respond.js"></script>
        <![endif]-->
    </head>

    <body class="login-layout blur-login">
        <div class="main-container">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="center white">
                            <h1 class="grey lighter smaller">
                                <span class="blue bigger-125">
                                <i class="ace-icon fa fa-random"></i>
                                500
                                </span>
                                Something Went Wrong
                            </h1>
                            <hr />
                            <h3 class="lighter smaller">
                                Mohon maaf, Aplikasi sedang dalam perbaikan.
                                <i class="ace-icon fa fa-wrench icon-animated-wrench bigger-125"></i>
                                Harap bersabar!
                            </h3>
                            <div class="space"></div>
                            <div>
                                <!--<p>Untuk kenyamana bersama, Silahkan kunjungi lagi web Rekrutmen Pada Tanggal 30 Sept 2015, Pukul 11:30 WIB</p>-->
                                <h4 class="lighter smaller">Jika mendasak, silahkan hubungi :</h4>
                                <ul class="list-unstyled spaced inline bigger-110 margin-15">
                                    <li>
                                        <i class="ace-icon fa fa-hand-o-right blue"></i>
                                        <!-- via Email : <a href="mailto:Gatot Broto Ismoyo">Ismo__ <i class="ace-icon fa fa-mail"></i> </a> -->
                                        via Email : <a href="mailto:P1.ITD28">Riyan <i class="ace-icon fa fa-mail"></i> </a>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-hand-o-right blue"></i>
                                        Atau hubungi IT Department - PSG
                                    </li>
                                </ul>
                            </div>
                            <div class="space-10"></div>
                            <a href="<?php echo site_url();?>" class="btn btn-mini btn-round btn-primary">
                                <i class="ace-icon fa fa-refresh"></i>
                                Reload
                            </a>
                        </div>

                        <div class="space-6"></div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.main-content -->
        </div><!-- /.main-container -->

        <!-- basic scripts -->

        <!--[if !IE]> -->
        <script type="text/javascript">
                window.jQuery || document.write("<script src='<?php echo base_url();?>assets/js/jquery.js'>"+"<"+"/script>");
        </script>

        <!-- <![endif]-->

        <!--[if IE]>
<script type="text/javascript">
window.jQuery || document.write("<script src='<?php echo base_url();?>assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->
        <script type="text/javascript">
                if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url();?>assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
        </script>

        <!-- inline scripts related to this page -->
        <script type="text/javascript">
            jQuery(function($) {
             $(document).on('click', '.toolbar a[data-target]', function(e) {
                e.preventDefault();
                var target = $(this).data('target');
                $('.widget-box.visible').removeClass('visible');//hide others
                $(target).addClass('visible');//show target
             });
            });



            //you don't need this, just used for changing background
            jQuery(function($) {
             $('#btn-login-dark').on('click', function(e) {
                $('body').attr('class', 'login-layout');
                $('#id-text2').attr('class', 'white');
                $('#id-company-text').attr('class', 'blue');

                e.preventDefault();
             });
             $('#btn-login-light').on('click', function(e) {
                $('body').attr('class', 'login-layout light-login');
                $('#id-text2').attr('class', 'grey');
                $('#id-company-text').attr('class', 'blue');

                e.preventDefault();
             });
             $('#btn-login-blur').on('click', function(e) {
                $('body').attr('class', 'login-layout blur-login');
                $('#id-text2').attr('class', 'white');
                $('#id-company-text').attr('class', 'light-blue');

                e.preventDefault();
             });

            });
        </script>
    </body>
</html>
