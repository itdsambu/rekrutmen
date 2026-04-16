<script src="<?php echo base_url(); ?>assets/dp/jquery-1.10.2.js"></script>

<div class="page-header">
    <h1>
        REGISTRASI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Upload Berkas Lamaran
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Upload berkas atas Nama : <strong><?php echo ucwords(strtolower($namapelamar)); ?></strong></div>
            <div class="panel-body">
                <div class="alert alert-block alert-danger">
                    Format data yang diizinkan untuk diupload hanya PDF, dan Maximal Berkas 5 MB.
                </div>
                <div>
                    <?php echo $errormsg; ?>
                </div>
                <?php
                // if ($groupuser != '93') { 
                ?>
                <div class="col-xs-10 col-lg-offset-1 col-sm-2 widget-container-col">
                    <div class="widget-box widget-color-blue2 light-border">
                        <div class="widget-header">
                            <h5 class="widget-title smaller">KTP </h5>
                            <div class="widget-toolbar">
                                <?php
                                foreach ($databerkas as $rowData) :
                                    if (is_null($rowData->KTP)) { ?>
                                        <span class='badge badge-danger'> Null</span>
                                    <?php
                                    } else { ?>
                                        <span class='badge badge-success'><i class="ace-icon fa fa-check"></i> Saved</span>
                                <?php
                                    }
                                endforeach;
                                ?>
                            </div>
                        </div>
                        <div class="widget-body center">
                            <div class="widget-main padding-6">
                                <button class="btn btn-app btn-purple btn-sm" onclick="load_area('ktp')">
                                    <i class="ace-icon fa fa-cloud-upload bigger-200"></i>
                                    Upload
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                // }
                ?>
                <div class="col-xs-10 col-sm-2 widget-container-col">
                    <div class="widget-box widget-color-blue2 light-border">
                        <div class="widget-header">
                            <h5 class="widget-title smaller">CV </h5>
                            <div class="widget-toolbar">
                                <?php
                                foreach ($databerkas as $rowData) :
                                    if (is_null($rowData->CV)) { ?>
                                        <span class='badge badge-danger'> Null</span>
                                    <?php
                                    } else { ?>
                                        <span class='badge badge-success'><i class="ace-icon fa fa-check"></i> Saved</span>
                                <?php
                                    }
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
                            <h5 class="widget-title smaller">Berkas Lamaran </h5>
                            <div class="widget-toolbar">
                                <?php
                                foreach ($databerkas as $rowData) :
                                    if (is_null($rowData->Lamaran)) { ?>
                                        <span class='badge badge-danger'> Null</span>
                                    <?php
                                    } else { ?>
                                        <span class='badge badge-success'><i class="ace-icon fa fa-check"></i> Saved</span>
                                <?php
                                    }
                                endforeach;
                                ?>
                            </div>
                        </div>
                        <div class="widget-body center">
                            <div class="widget-main padding-6">
                                <button class="btn btn-app btn-purple btn-sm" onclick="load_area('lamaran')">
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
                                foreach ($databerkas as $rowData) :
                                    if (is_null($rowData->Ijazah)) { ?>
                                        <span class='badge badge-danger'> Null</span>
                                    <?php
                                    } else { ?>
                                        <span class='badge badge-success'><i class="ace-icon fa fa-check"></i> Saved</span>
                                <?php
                                    }
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
                            <h5 class="widget-title smaller">Transkrip Nilai </h5>
                            <div class="widget-toolbar">
                                <?php
                                foreach ($databerkas as $rowData) :
                                    if (is_null($rowData->Transkrip)) { ?>
                                        <span class='badge badge-danger'> Null</span>
                                    <?php
                                    } else { ?>
                                        <span class='badge badge-success'><i class="ace-icon fa fa-check"></i> Saved</span>
                                <?php
                                    }
                                endforeach;
                                ?>
                            </div>
                        </div>
                        <div class="widget-body center">
                            <div class="widget-main padding-6">
                                <button class="btn btn-app btn-purple btn-sm" onclick="load_area('transkrip')">
                                    <i class="ace-icon fa fa-cloud-upload bigger-200"></i>
                                    Upload
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <br /><br /><br /><br /><br /> <br /><br /><br /><br /><br />
                <!-- vaksin -->
                <div class="col-xs-14 col-lg-offset-1 col-sm-2 widget-container-col">
                    <div class="widget-box widget-color-blue2 light-border">
                        <div class="widget-header">
                            <h5 class="widget-title smaller">Berkas Pendukung</h5>
                            <!-- <h5 class="widget-title smaller">Sertifikat Vaksin 1</h5> -->
                            <div class="widget-toolbar">
                                <?php
                                foreach ($databerkas as $rowData) :
                                    if (is_null($rowData->Vaksin1)) { ?>
                                        <span class='badge badge-danger'> Null</span>
                                    <?php
                                    } else { ?>
                                        <span class='badge badge-success'><i class="ace-icon fa fa-check"></i> Saved</span>
                                <?php
                                    }
                                endforeach;
                                ?>
                            </div>
                        </div>
                        <div class="widget-body center">
                            <div class="widget-main padding-6">
                                <button class="btn btn-app btn-purple btn-sm" onclick="load_area('Vaksin1')">
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
                            <h5 class="widget-title smaller">Sertifikat Vaksin 2</h5>
                            <div class="widget-toolbar">
                                <?php
                                foreach ($databerkas as $rowData) :
                                    if (is_null($rowData->Vaksin2)) { ?>
                                        <span class='badge badge-danger'> Null</span>
                                    <?php
                                    } else { ?>
                                        <span class='badge badge-success'><i class="ace-icon fa fa-check"></i> Saved</span>
                                <?php
                                    }
                                endforeach;
                                ?>
                            </div>
                        </div>
                        <div class="widget-body center">
                            <div class="widget-main padding-6">
                                <button class="btn btn-app btn-purple btn-sm" onclick="load_area('Vaksin2')">
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
                            <h5 class="widget-title smaller">Sertifikat Vaksin 3</h5>
                            <div class="widget-toolbar">
                                <?php
                                foreach ($databerkas as $rowData) :
                                    if (is_null($rowData->Vaksin3)) { ?>
                                        <span class='badge badge-danger'> Null</span>
                                    <?php
                                    } else { ?>
                                        <span class='badge badge-success'><i class="ace-icon fa fa-check"></i> Saved</span>
                                <?php
                                    }
                                endforeach;
                                ?>
                            </div>
                        </div>
                        <div class="widget-body center">
                            <div class="widget-main padding-6">
                                <button class="btn btn-app btn-purple btn-sm" onclick="load_area('Vaksin3')">
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
                            <h5 class="widget-title smaller">KK</h5>
                            <div class="widget-toolbar">
                                <?php
                                foreach ($databerkas as $rowData) :
                                    if (is_null($rowData->KK)) { ?>
                                        <span class='badge badge-danger'> Null</span>
                                    <?php
                                    } else { ?>
                                        <span class='badge badge-success'><i class="ace-icon fa fa-check"></i> Saved</span>
                                <?php
                                    }
                                endforeach;
                                ?>
                            </div>
                        </div>
                        <div class="widget-body center">
                            <div class="widget-main padding-6">
                                <button class="btn btn-app btn-purple btn-sm" onclick="load_area('KK')">
                                    <i class="ace-icon fa fa-cloud-upload bigger-200"></i>
                                    Upload
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 
                    created By ITD 035
                    10-Oktober-2022 11:00 WIB
                 -->
                <div class="col-xs-10 col-sm-2 widget-container-col">
                    <div class="widget-box widget-color-blue2 light-border">
                        <div class="widget-header">
                            <h5 class="widget-title smaller">SKCK</h5>
                            <div class="widget-toolbar">
                                <?php
                                foreach ($databerkas as $rowData) :
                                    if (is_null($rowData->SKCK)) { ?>
                                        <span class='badge badge-danger'> Null</span>
                                    <?php
                                    } else { ?>
                                        <span class='badge badge-success'><i class="ace-icon fa fa-check"></i> Saved</span>
                                <?php
                                    }
                                endforeach;
                                ?>
                            </div>
                        </div>
                        <div class="widget-body center">
                            <div class="widget-main padding-6">
                                <button class="btn btn-app btn-purple btn-sm" onclick="load_area('SKCK')">
                                    <i class="ace-icon fa fa-cloud-upload bigger-200"></i>
                                    Upload
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <br /><br /><br /><br /><br /> <br /><br /><br /><br /><br />
                <div id="uploadcontainer">

                </div>

            </div>
            <div class="panel-footer">
                <div class="padding-6 clearfix">
                    Minimal Upload <strong>KTP</strong> dan <strong>Berkas Lamaran</strong>
                    <?php
                    if ($minimalberkas === 1) { ?>
                        <form action="<?php echo site_url('uploadBerkas/selesai/' . $hdrid); ?>">
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
    let controller = 'uploadBerkas';
    let base_url = '<?php echo site_url(); ?>'; //you have to load the "url_helper" to use this function
    let hdrid = "<?php echo $hdrid; ?>";
    let nama = "<?php echo $namapelamar; ?>";

    function load_area(tipe) {
        $.ajax({
            url: base_url + controller + '/uploadarea',
            type: 'POST', //the way you want to send data to your URL
            data: {
                tipe: tipe,
                hdrid: hdrid,
                nama: nama
            },
            success: function(data) { //probably this request will return anything, it'll be put in var "data"
                // var container = $('#uploadcontainer'); //jquery selector (get element by id)
                if (data) {
                    $('#uploadcontainer').html(data);
                }
            }
        });
    }
</script>