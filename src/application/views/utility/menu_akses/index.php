<div class="page-header">
    <h1>
        MANAGEMENT USER
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Menu Access
        </small>
    </h1>
</div><!-- /.page-header -->
<?php

if ($akses) { ?>
    <div class="row">
        <!-- Design Disini -->
        <?php $att = array('class' => 'form-horizontal', 'role' => 'form');
        echo form_open('menuAkses/simpan', $att); ?>
        <fieldset>
            <div class="row">
                <div class="col-xs-12">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="widget-title">Input User</h4>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Pilih Group User </label>
                                    <div class="col-sm-8">
                                        <select class="col-xs-12 col-sm-10" name="txtGroupID" id="dropdownGrupUser">
                                            <option value=""> -- Silahkan pilih group user</option>
                                            <?php
                                            foreach ($_getGrupUser as $row) :
                                            ?>
                                                <option value="<?php echo $row->GroupID; ?>"><?php echo $row->GroupName; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-sm-6">
                                        <div id="tbllist">
                                            <table class="table table-striped table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 100px" class="text-center">
                                                            <label class="pos-rel">
                                                                <input type="checkbox" class="ace">
                                                                <span class="lbl"></span>
                                                            </label>
                                                        </th>
                                                        <th>Menu</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
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
<?php } else { ?>
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
<?php } ?>
<script type="text/javascript">
    $("#dropdownGrupUser").change(function() {
        var selectValues = $("#dropdownGrupUser").val();
        if (selectValues === 0) {
            var msg = "<table class='table table-striped table-hover table-bordered'><thead><tr><th>Pilih</th><th>Menu</th></tr></thead></table>";
            $('#tbllist').html(msg);
        } else {
            var grupid = {
                grupid: $("#dropdownGrupUser").val()
            };
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('menuAkses/get_listMenu') ?>",
                data: grupid,
                success: function(msg) {
                    $('#tbllist').html(msg);
                }
            });
        }


    });
</script>