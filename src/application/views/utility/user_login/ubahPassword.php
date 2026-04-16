<div class="page-header">
    <h1>
        MANAGEMENT USER
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Reset Password Login
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <!-- Design Disini -->
        <?php $att = array('class'=>'form-horizontal', 'role'=>'form');
        echo form_open('user_login/updatePassword', $att);
        foreach ($getUser as $row):
            ?>
            <fieldset>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="widget-box"
                            >
                            <div class="widget-header">
                                <h4 class="widget-title">Reset Password Login <strong><?php echo $row->NamaUser; ?></strong></h4>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <?php echo $pesan; ?>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                            Kembali ke Password Default </label>

                                        <div class="col-sm-9">
                                            <input type="hidden" id="inputUserID" name="txtUserID" value="<?php echo
                                            $row->LoginID; ?>" class="col-xs-12 col-sm-10" required="required"/>

                                            <input type="text" id="inputOldPass" name="txtNewPass"
                                                   value="pass1234" class="col-xs-12 col-sm-10" readonly=""/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-3 col-md-9">
                                            <input class="btn btn-info" type="submit" name="simpan" value="Reset">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </fieldset>
        <?php endforeach; ?>
        </form>

    </div>
</div>