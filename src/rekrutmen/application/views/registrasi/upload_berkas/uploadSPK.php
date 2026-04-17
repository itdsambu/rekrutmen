<script src="<?php echo base_url();?>assets/dp/jquery-1.10.2.js"></script>

<div class="page-header">
    <h1>
        REGISTRASI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Upload Berkas Surat Perjanjian Kontrak
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
                <div class="col-xs-10 col-lg-offset-3 col-sm-6 widget-container-col">
                    <div class="widget-box widget-color-blue2 light-border">
                        
                        <div class="widget-header">
                            <h5 class="widget-title smaller">Surat Perjanjian kontrak </h5>
                            <div class="widget-toolbar">
                                <?php 
                                    foreach($databerkas as $rowData):
                                        if (is_null($rowData->SuratKontrak)){ ?>
                                            <span class='badge badge-danger'> Null</span>
                                            <?php 
                                        }else{?>
                                                <span class='badge badge-success'><i class="ace-icon fa fa-check"></i> Saved</span>
                                            <?php   
                                        }
                                    endforeach;
                                ?> 
                            </div>
                        </div>
                        <div class="widget-body center">
                            <div class="widget-main padding-6">
                                <button class="btn btn-app btn-purple btn-sm" onclick="load_area('SuratKontrak')">
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
            <div class="panel-footer">
                <div class="padding-6 clearfix">
                    Minimal Upload <strong>KTP</strong> dan <strong>Berkas Lamaran</strong>
                <?php
                    if ($minimalberkas === 1){ ?>
                        <form action="<?php echo site_url('uploadBerkas/selesai/'.$hdrid);?>">
                            <button class="btn btn-xs btn-success pull-right" type="submit">
                                <span class="bigger-110">Selesai</span>
                                <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                            </button>
                        </form>

                        <?php  
                    } ?>
                </div>
            </div>
        </div>
        
    </div>
</div>
<script type="text/javascript">
    var controller = 'uploadBerkas';
    var base_url = '<?php echo site_url();?>'; //you have to load the "url_helper" to use this function 
    var hdrid = "<?php echo $hdrid;?>";
    var nama = "<?php echo $namapelamar;?>";

    function load_area(tipe){		
        $.ajax({
            url : base_url + '/' + controller + '/uploadarea',
            type : 'POST', //the way you want to send data to your URL
            data : {tipe : tipe, hdrid : hdrid, nama: nama},
            success : function(data){ //probably this request will return anything, it'll be put in var "data"
				// var container = $('#uploadcontainer'); //jquery selector (get element by id)
                if(data){
                    $('#uploadcontainer').html(data);
                }
            }
        });
    }
</script>
