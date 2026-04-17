<!-- Twitter Bootstrap -->
<!--<link rel="stylesheet" href="<?php echo base_url();?>assets/pdf-viewer/lib/twitter-bootstrap/css/bootstrap.css">
 Font Awesome -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/pdf-viewer/lib/font-awesome/css/font-awesome.css">
<!-- Bootstrap PDF Viewer -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/pdf-viewer/css/bootstrap-pdf-viewer.css">

<?php
    foreach ($_getViewDocs as $row):
?>
<?php
    if ($_jenisBerkas == "CV"){
?>
<div class="form-line">
    <a href="<?php echo site_url($row->CV);?>" class="btn btn-mini btn-success pull-right" target="_blank"><i class="ace-icon fa fa-print"></i> Print</a> 
</div>
<div id="viewer" class="pdf-viewer" data-url="<?php echo base_url($row->CV);?>"></div>
<?php
    }elseif ($_jenisBerkas == "Lamaran") {
?>
<div class="form-line">
    <a href="<?php echo site_url($row->Lamaran);?>" class="btn btn-mini btn-success pull-right" target="_blank"><i class="ace-icon fa fa-print"></i> Print</a> 
</div>
<div id="viewer" class="pdf-viewer" data-url="<?php echo base_url($row->Lamaran);?>"></div>
<?php
    }elseif ($_jenisBerkas == "KTP") {
?>
<div class="form-line">
    <a href="<?php echo site_url($row->KTP);?>" class="btn btn-mini btn-success pull-right" target="_blank"><i class="ace-icon fa fa-print"></i> Print</a> 
</div>
<div id="viewer" class="pdf-viewer" data-url="<?php echo base_url($row->KTP);?>"></div>
<?php
    }elseif ($_jenisBerkas == "Ijazah") {
?>
<div class="form-line">
    <a href="<?php echo site_url($row->Ijazah);?>" class="btn btn-mini btn-success pull-right" target="_blank"><i class="ace-icon fa fa-print"></i> Print</a> 
</div>
<div id="viewer" class="pdf-viewer" data-url="<?php echo base_url($row->Ijazah);?>"></div>
<?php
    }elseif ($_jenisBerkas == "Transkrip") {
?>
<div class="form-line">
    <a href="<?php echo site_url($row->Transkrip);?>" class="btn btn-mini btn-success pull-right" target="_blank"><i class="ace-icon fa fa-print"></i> Print</a> 
</div>
<div id="viewer" class="pdf-viewer" data-url="<?php echo base_url($row->Transkrip);?>"></div>
<?php
    }elseif ($_jenisBerkas == "SuratKontrak") {
?>
<div class="form-line">
    <a href="<?php echo site_url($row->SuratKontrak);?>" class="btn btn-mini btn-success pull-right" target="_blank"><i class="ace-icon fa fa-print"></i> Print</a> 
</div>
<div id="viewer" class="pdf-viewer" data-url="<?php echo base_url($row->SuratKontrak);?>"></div>
<?php
    }
?>
<?php 
    endforeach;
?>

<script src="<?php echo base_url();?>assets/pdf-viewer/lib/pdf.js"></script>
<script src="<?php echo base_url();?>assets/pdf-viewer/js/bootstrap-pdf-viewer.js"></script>
<script>
  var viewer;
  $(function() {
    viewer = new PDFViewer($('#viewer'));
  });
</script>