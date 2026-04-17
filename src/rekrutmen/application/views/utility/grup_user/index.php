<div class="page-header">
    <h1>
        MANAGEMENT USER
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Input Grup User
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <!-- Design Disini -->
        <?php $att = array('class'=>'form-horizontal', 'role'=>'form');
        echo form_open('grup_user/tambah', $att);?>
            <fieldset>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4 class="widget-title">Input Grup User</h4>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <?php echo $pesan; ?>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Grup User </label>

                                        <div class="col-sm-9">
                                            <input type="text" id="inputGrupUser" name="txtGrupUser"
                                                   placeholder="Grup User" class="col-xs-12 col-sm-10" required="required"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Grup </label>

                                        <div class="col-sm-9">
                                            <input type="text" id="inputNamaGrup" name="txtNamaGrup"
                                                   placeholder="Nama Grup" class="col-xs-12 col-sm-10" required="required"/>
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
                                            <a class="btn btn-sm btn-info" href="listGrupUser">Cancel</a>
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
</div>
