<div class="page-header">
    <h1>
        MANAGEMENT PEMBORONG
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Pemborong Access
        </small>
    </h1>
</div>
<!-- /.page-header -->
<?php if ( $akses) { ?>
    <div class="row">
        <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PemborongAkses/save'); ?>">
            <fieldset>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4 class="widget-title">Tambah Pemborong Access</h4>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Pilih Group User </label>
                                        <div class="col-sm-8">
                                            <select class="col-xs-12 col-sm-10" name="txtGroupID" id="dropdownGrupUser" required>
                                                <option value=""> -- Silahkan pilih group user</option>
                                                <?php
                                                    foreach ($_getGrupUser as $row):
                                                ?>
                                                <option value="<?php echo $row->GroupID;?>"><?php echo $row->GroupName;?></option>
                                                <?php
                                                    endforeach;
                                                ?>
                                            </select>
                                            <input type="hidden" id="txtGroupName" name="txtGroupName" placeholder="Group Name" class="col-xs-12 col-sm-10" value="" required="required"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Pilih Nama Pemborong </label>
                                        <div class="col-sm-8">
                                            <select class="col-xs-12 col-sm-10 GrupPemborong" name="txtGroupPemborong" id="dropdownGrupPemborong" required>
                                                <option value=""> -- Silahkan pilih nama pemborong</option>
                                                <?php
                                                    foreach ($_getGrupPemborong as $row):
                                                ?>
                                                <option value="<?php echo $row->IDPemborong . ' - ' . $row->IDPerusahaan;?>"><?php echo $row->Pemborong;?></option>
                                                <?php
                                                    endforeach;
                                                ?>
                                            </select>
                                            <input type="hidden" id="inputIDPerusahaan" name="inputIDPerusahaan" placeholder="ID Perusahaan" class="col-xs-12 col-sm-10" value="" required="required"/>
                                            <input type="hidden" id="inputIDPemborong" name="inputIDPemborong" placeholder="ID Pemborong" class="col-xs-12 col-sm-10" value="" required="required"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nama CV </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="txtNameCv" name="txtNameCv" placeholder="ID Perusahaan" class="col-xs-12 col-sm-10" value="" readonly required/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Status </label>

                                        <div class="col-sm-9">
                                            <div class="radio">
                                                <label>
                                                    <input name="txtStatus" type="radio" class="ace" value="0" required="" checked/>
                                                    <span class="lbl"> Active</span>
                                                </label>
                                            </div>

                                            <div class="radio">
                                                <label>
                                                    <input name="txtStatus" type="radio" class="ace" value="1"/>
                                                    <span class="lbl"> Not Active</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-3 col-md-9">
                                            <input class="btn btn-sm btn-info" type="submit" name="simpan" value="Submit">
                                            <a class="btn btn-sm btn-info" href="index">Cancel</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                                                    
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <?php
} else { ?>
    <div class="row">
        <div class="col-xs-12" id="controlsetup">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="row">
                        <div class="alert alert-danger">
                            <div class="alert-data">
                                <div class="alert-content">
                                    Maaf, anda tidak memiliki akses untuk halaman ini.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} ?>

<script type="text/javascript">
    $('#dropdownGrupPemborong').change(function(){
        let id = $(this).val();
        let idpemborong = id.split(" - ");
        $('#inputIDPemborong').val(idpemborong[0]);
        $('#inputIDPerusahaan').val(idpemborong[1]);

        let cv    = $('#inputIDPerusahaan').val();
        let owner = $('#inputIDPemborong').val();
        $.ajax({
            type: "post",
            url : "<?php echo site_url('PemborongAkses/getNamePerusahaan')?>",
            data: {
                cv: cv,
                owner: owner
            },
            dataType: "json",
            success: function (response) {
                let name = response[0].Perusahaan;
                $('#txtNameCv').val(name);
            }
        });
    });

    $('#dropdownGrupUser').change(function(){
        let IDGroup = $(this).val();
        $.ajax({
            type: "post",
            url : "<?php echo site_url('PemborongAkses/getGroupame')?>",
            data: {
                IDGroup: IDGroup
            },
            dataType: "json",
            success: function (response) {
                let name = response[0].GroupName;
                $('#txtGroupName').val(name);
            }
        });
    });
</script>