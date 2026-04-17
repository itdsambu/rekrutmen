<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Browser Not Support</title>

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

    <body class="login-layout">
        <div class="main-container">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="center white">
                            <!--<marquee >-->
                                <h1 class="grey lighter smaller">
                                    <span class="blue bigger-125">
                                    <i class="ace-icon fa fa-random"></i>
                                    500
                                    </span>
                                    Something Went Wrong
                                </h1>
                            <!--</marquee>-->
                                
                            <hr />
                            <h3 class="lighter smaller">
                                <i class="ace-icon fa fa-warning red bigger-125"></i>
                                <strong>Mohon maaf,</strong> Aplikasi tidak dapat diakses oleh Browser anda!
                            </h3>
                            <div class="space"></div>
                            <div>
                                <!--<p>Untuk kenyamana bersama, Silahkan kunjungi lagi web Rekrutmen Pada Tanggal 30 Sept 2015, Pukul 11:30 WIB</p>-->
                                <h4 class="lighter smaller">Solusi tercepat yang bisa anda lakukan:</h4>
                                <ul class="list-unstyled spaced inline bigger-110 margin-15">
                                    <li>
                                        <i class="ace-icon fa fa-hand-o-right blue"></i>
                                        Gunakan browser lain pada perangkat anda!
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-hand-o-right blue"></i>
                                        Rekomendasi browser dari kami adalah 
                                        <img src="<?php echo base_url();?>assets/img/Chrome-Logo.PNG" width="20" height="20" alt="Chrome"/>Chrome atau 
                                        <img src="<?php echo base_url();?>assets/img/Firefox-Logo.PNG" width="20" height="20" alt="Firefox"/>Firefox
                                    </li>
<!--                                    <li>
                                        <i class="ace-icon fa fa-hand-o-right blue"></i>
                                        Atau download browser pada link dibawah :
                                    </li>
                                    <ul class="list-unstyled spaced inline margin-15">
                                        <li>untuk PC klik <a href="<?php // echo base_url();?>assets/UCBrowser_V5.4.4237.1032_windows_pf101_(Build15082410).rar">disini</a> </li>
                                        <li>untuk Mobile klik disini</li>
                                    </ul>-->
                                </ul>
                            </div>
                            <div class="space-10"></div>
                            <div>
                                Atas pengertiannya kami ucapkan terima kasih. <strong>~ ITD PSG ~</strong>
                            </div>
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

    </body>
</html>
