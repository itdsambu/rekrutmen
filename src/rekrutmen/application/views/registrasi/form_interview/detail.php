<h4 class="row header smaller lighter red">
    <span class="col-sm-8">
        <i class="ace-icon fa fa-bell-o"></i>
        <strong> Informasi Calon Tenaga Kerja</strong>
    </span><!-- /.col -->
</h4>
<?php
    foreach($datatk as $row):
        $hdrid = $row->HeaderID;
    endforeach;
    $namafoto = './dataupload/foto/'.$hdrid.'.jpg';
?>

<div class="row">
    <?php
        foreach($datatk as $row):
    ?>
    <div class="col-sm-12">
        <div class="widget-box transparent">
            <div class="widget-header widget-header-large">
                <h3 class="widget-title grey lighter">
                    <?php echo $row->CVNama;?>
                </h3>
            </div>
            <div class="col-sm-offset-5 col-sm-12">
                <div class="row">
                    <span class="profile-picture">
                        <img id="avatar" width="150" class="editable img-responsive editable-click editable-empty" src="<?php echo base_url($namafoto); ?>" style="display: block;"></img>
                    </span>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main padding-24">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-xs-12 label label-lg label-info arrowed-in arrowed-right">
                                    <b>Informasi Data Pribadi</b>
                                </div>
                            </div>

                            <div>
                                <ul class="list-unstyled spaced">
                                	<li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        ID Reg : <?php echo "#" .$row->HeaderID ;?>
                                    </li>
                                	<li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        NIK : <?php echo $row->NIK;?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Nama : <?php echo $row->Nama;?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Pemborong : <?php echo $row->Pemborong;?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Dept : &nbsp;
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Shift : &nbsp;
                                    </li>
                                </ul>
                            </div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->

                </div>
            </div>	
        </div>
    </div>
    
</div>

<!-- Modal Close Tenaker -->
<!-- <div class="modal fade" id="viewModalClose" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->				
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Close Data Tenaker, <?php echo $sapa.ucwords(strtolower($row->Nama));?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="<?php echo site_url('verifikasi/closeTenaker');?>" role="form" method="post" class="form-horizontal">
                            <input type="hidden" id="txtInputHeaderID" name="txtHeaderID" value="<?php echo $row->HeaderID;?>">
                            <div class="form-group">
                                <label class="control-label col-sm-4">Keterangan</label>
                                <div class="col-sm-6">
                                    <textarea name="txtRemarkClose" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-6">
                                    <button type="submit" name="btnSubmit" class="btn btn-danger btn-sm">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">				
            	<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div> -->
<!-- </div>
<?php endforeach; ?>

<script>
    $(document).ready(function() {        
        $("#btnCloseTenaker").on("click", function() {
            $("#viewModalClose").modal("show");
        });
    });
</script> -->
<script>
    $(document).ready(function() {
        $("#myTable").tablesorter();
        $('[data-rel=tooltip]').tooltip();
        
        $("#btnModalExcel").click(function () {
            $("#modalToExcel").modal("show");
        });
        
        $("#myTable").on("click",".detailInterview",function(){var e=$(this).closest("tr").data("id");$.ajax({url:"<?php echo site_url('wawancaraTujuan/cekRecordInterview');?>",type:"POST",data:"kode="+e,datatype:"json",cache:!1,success:function(e){$("#detailInterview").html(e)}}),$("#viewModalInterview").modal("show")});
        
        $("#myTable").on("click",".detail",function(){var a=$(this).closest("tr").data("id"),t=$(this).data("name"),e=$(this).data("tk");document.getElementById("titleModal").innerHTML="Berkas "+t+" dari saudara, <strong class='green'>"+e+" </strong>",$.ajax({url:"<?php echo site_url('monitor/viewDocs');?>",type:"POST",data:"kode="+a+"&nama="+t,datatype:"json",cache:!1,success:function(a){$("#detail").html(a)}}),$("#viewModal").modal("show")});
        
        $("#myTable").on("click",".detailInfo",function(){var a=$(this).closest("tr").data("id");$.ajax({url:"<?php echo site_url('uploadBerkas/detailtk');?>",type:"POST",data:"kode="+a,datatype:"json",cache:!1,success:function(a){$("#detailInfo").html(a)}}),$("#viewModalInfo").modal("show")});
    });
</script>