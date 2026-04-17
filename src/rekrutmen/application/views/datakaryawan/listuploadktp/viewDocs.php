<!-- Twitter Bootstrap -->
<!--<link rel="stylesheet" href="<?php echo base_url();?>assets/pdf-viewer/lib/twitter-bootstrap/css/bootstrap.css">
 Font Awesome -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/pdf-viewer/lib/font-awesome/css/font-awesome.css">
<!-- Bootstrap PDF Viewer -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/pdf-viewer/css/bootstrap-pdf-viewer.css">

<div class="form-line">
    <a href="<?php echo site_url($_urlktp);?>" class="btn btn-mini btn-success pull-right" target="_blank"><i class="ace-icon fa fa-print"></i> Print</a> 
</div>
<div id="viewer" class="pdf-viewer" data-url="<?php echo base_url($_urlktp);?>"></div>

<script src="<?php echo base_url();?>assets/pdf-viewer/lib/pdf.js"></script>
<script src="<?php echo base_url();?>assets/pdf-viewer/js/bootstrap-pdf-viewer.js"></script>
<script>
  var viewer;
  $(function() {
    viewer = new PDFViewer($('#viewer'));
  });
</script>