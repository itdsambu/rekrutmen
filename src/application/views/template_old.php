<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8">
	<title><?php echo $this->config->item("nama_app"); ?></title>
	
	<meta name="description" content="overview &amp; stats" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link rel='shortcut icon' type='image icon' href="<?php echo base_url(); ?>assets/img/psg-logo.png"/>

	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.css" />

        <!-- page specific plugin styles -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/sp/scroll-persen.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.custom.css" />
<!--        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/chosen.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/datepicker.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-timepicker.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/daterangepicker.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/colorpicker.css" />-->
        
	<!-- text fonts -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-fonts.css" />

	<!-- ace styles -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-skins.css" id="ace-skins-stylesheet"  type="text/css">
	
	<!--[if lte IE 9]>
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-part2.css" class="ace-main-stylesheet" />
	<![endif]-->

	<!--[if lte IE 9]>
	  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-ie.css" />
	<![endif]-->

	<!-- inline styles related to this page -->

	<!-- ace settings handler -->
	<script src="<?php echo base_url();?>assets/js/ace-extra.js"></script>

	<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

	<!--[if lte IE 8]>
	<script src="<?php echo base_url();?>assets/js/html5shiv.js"></script>
	<script src="<?php echo base_url();?>assets/js/respond.js"></script>
	<![endif]-->
	
        

        <script src="<?php echo base_url();?>assets/dp/jquery-1.10.2.js"></script>
        <!-- <script src="<?php echo base_url();?>assets/dp/jquery.datepick.js"></script> -->
        <script src="<?php echo base_url();?>assets/dp/jquery.plugin.js"></script>

<!-- basic scripts -->

	<!--[if !IE]> -->
	<script type="text/javascript">
            window.jQuery || document.write("<script src='<?php echo base_url();?>/assets/js/jquery.js'>"+"<"+"/script>");
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
	<script src="<?php echo base_url();?>assets/js/bootstrap.js"></script>

	<!-- page specific plugin scripts -->        
        <script src="<?php echo base_url();?>assets/sp/scroll-persen.js"></script>
        <script src="<?php echo base_url();?>assets/js/dataTables/jquery.dataTables.js"></script>
        <script src="<?php echo base_url();?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url();?>assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
        <script src="<?php echo base_url();?>assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
        
	<!--        <script src="<?php echo base_url();?>assets/js/chosen.jquery.js"></script>
        <script src="<?php echo base_url();?>assets/js/fuelux/fuelux.spinner.js"></script>
        <script src="<?php echo base_url();?>assets/js/date-time/bootstrap-datepicker.js"></script>
        <script src="<?php echo base_url();?>assets/js/date-time/bootstrap-timepicker.js"></script>
        <script src="<?php echo base_url();?>assets/js/date-time/moment.js"></script>
        <script src="<?php echo base_url();?>assets/js/date-time/daterangepicker.js"></script>
        <script src="<?php echo base_url();?>assets/js/date-time/bootstrap-datetimepicker.js"></script>
        <script src="<?php echo base_url();?>assets/js/bootstrap-colorpicker.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.knob.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.autosize.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.inputlimiter.1.3.1.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.maskedinput.js"></script>
        <script src="<?php echo base_url();?>assets/js/bootstrap-tag.js"></script>-->

	<!--[if lte IE 8]>
	  <script src="<?php echo base_url();?>assets/js/excanvas.js"></script>
	<![endif]-->
	<script src="<?php echo base_url();?>assets/js/jquery-ui.custom.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.ui.touch-punch.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.easypiechart.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.sparkline.js"></script>
	<script src="<?php echo base_url();?>assets/js/flot/jquery.flot.js"></script>
	<script src="<?php echo base_url();?>assets/js/flot/jquery.flot.pie.js"></script>
	<script src="<?php echo base_url();?>assets/js/flot/jquery.flot.resize.js"></script>

	<!-- ace scripts -->
	<script src="<?php echo base_url();?>assets/js/ace/elements.scroller.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/elements.colorpicker.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/elements.fileinput.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/elements.typeahead.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/elements.wysiwyg.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/elements.spinner.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/elements.treeview.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/elements.wizard.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/elements.aside.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/ace.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/ace.ajax-content.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/ace.touch-drag.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/ace.sidebar.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/ace.sidebar-scroll-1.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/ace.submenu-hover.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/ace.widget-box.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/ace.settings.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/ace.settings-rtl.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/ace.settings-skin.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/ace.widget-on-reload.js"></script>
	<script src="<?php echo base_url();?>assets/js/ace/ace.searchbox-autocomplete.js"></script>
        <!-- <script src="<?php echo base_url();?>assets/pdf-viewer/lib/pdf.js"></script>
		<script src="<?php echo base_url();?>assets/pdf-viewer/js/bootstrap-pdf-viewer.js"></script> -->
</head>

<body class="skin-3 no-skin">
    <div id="scroll"></div>
	<?php echo $_navbar;?>
	
	<div class="main-container" id="main-container">
            <?php echo $_sidebar;?>

            <div class="main-content">
                <div class="main-content-inner">
                    <!-- breadcrumbs here -->
                    <div class="page-content">
                            <?php echo $_content;?>
                    </div>
                </div>
            </div>

            <?php echo $_footer;?>

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                    <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
	</div>
	
	
</body>

</html>