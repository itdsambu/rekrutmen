<script src="<?php echo base_url();?>assets/dp/jquery-1.10.2.js"></script>

<div class="page-header">
    <h1>
        REGISTRASI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Upload Berkas Calon Kandidat
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Upload berkas atas Nama : <strong><?php echo ucwords(strtolower($namapelamar));?></strong></div>
            <div class="panel-body">
                <div class="alert alert-block alert-info">
                    Format data yang diizinkan untuk diupload hanya PDF, dan Maximal Berkas 5 MB.
                </div>
                <div>
                    <?php echo $errormsg;?>
                </div>
                <div class="col-xs-10 col-sm-2 widget-container-col">
                    <div class="widget-box widget-color-blue2 light-border">
                        <div class="widget-header">
                            <h5 class="widget-title smaller">CV </h5>
                            <div class="widget-toolbar">
                                <?php 
                                    foreach($databerkas as $rowData):
                                        if (is_null($rowData->CV)){
                                ?>
                                    <span class='badge badge-danger'> Null</span>
                                <?php }else{?>
                                    <span class='badge badge-success'><i class="ace-icon fa fa-check"></i> Saved</span>
                                <?php   }
                                    endforeach;
                                ?> 
                            </div>
                        </div>
                        <div class="widget-body center">
                            <div class="widget-main padding-6">
                                <button class="btn btn-app btn-purple btn-sm" onclick="load_area('cv')">
                                    <i class="ace-icon fa fa-cloud-upload bigger-200"></i>
                                    Upload
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-10 col-sm-2 widget-container-col">
                    <div class="widget-box widget-color-blue2 light-border">
                        <div class="widget-header">
                            <h5 class="widget-title smaller">Ijazah </h5>
                            <div class="widget-toolbar">
                                <?php 
                                    foreach($databerkas as $rowData):
                                        if (is_null($rowData->Ijazah)){
                                ?>
                                    <span class='badge badge-danger'> Null</span>
                                <?php }else{?>
                                    <span class='badge badge-success'><i class="ace-icon fa fa-check"></i> Seved</span>
                                <?php   }
                                    endforeach;
                                ?> 
                            </div>
                        </div>
                        <div class="widget-body center">
                            <div class="widget-main padding-6">
                                <button class="btn btn-app btn-purple btn-sm" onclick="load_area('ijazah')">
                                    <i class="ace-icon fa fa-cloud-upload bigger-200"></i>
                                    Upload
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-10 col-sm-2 widget-container-col">
                    <div class="widget-box widget-color-blue2 light-border">
                        <div class="widget-header">
                            <h5 class="widget-title smaller">Riwayat Hidup </h5>
                            <div class="widget-toolbar">
                                <?php 
                                    foreach($databerkas as $rowData):
                                        if (is_null($rowData->RiwayatHidup)){
                                ?>
                                    <span class='badge badge-danger'> Null</span>
                                <?php }else{?>
                                    <span class='badge badge-success'><i class="ace-icon fa fa-check"></i> Seved</span>
                                <?php   }
                                    endforeach;
                                ?> 
                            </div>
                        </div>
                        <div class="widget-body center">
                            <div class="widget-main padding-6">
                                <button class="btn btn-app btn-purple btn-sm" onclick="load_area('riwayathidup')">
                                    <i class="ace-icon fa fa-cloud-upload bigger-200"></i>
                                    Upload
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                <div id="uploadcontainer">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var controller = 'Monitor';
    var base_url = '<?php echo site_url();?>'; //you have to load the "url_helper" to use this function 
    var id = "<?php echo $id;?>";
    var nama = "<?php echo $namapelamar;?>";

    function load_area(tipe){		
        $.ajax({
            url : base_url +  controller + '/uploadarea',
            type : 'POST', //the way you want to send data to your URL
            data : {tipe : tipe, id : id, nama: nama},
            success : function(data){ //probably this request will return anything, it'll be put in var "data"
//				var container = $('#uploadcontainer'); //jquery selector (get element by id)
                if(data){
                    $('#uploadcontainer').html(data);
                }
            }
        });
    }
</script>
