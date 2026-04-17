<div class="page-header">
    <h1>
        MANAGEMENT USER
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Edit User Login
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <!-- Design Disini -->
        <?php
        foreach ($getUser as $row) :
            $att = array('class' => 'form-horizontal', 'role' => 'form');
            echo form_open('user_login/updateUserLogin?id=' . $row->LoginID, $att);

        ?>
            <fieldset>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4 class="widget-title">Edit User Login</h4>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                            Username </label>

                                        <div class="col-sm-9">
                                            <input type="text" id="inputUsername" name="txtLoginID" value="<?php echo
                                                                                                            $row->LoginID; ?>" placeholder="Username" class="col-xs-12 col-sm-10" required="required" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                            Nama Lengkap </label>

                                        <div class="col-sm-9">
                                            <input type="text" id="inputNamaLengkap" name="txtNamaLengkap" value="<?php echo
                                                                                                                    $row->NamaUser; ?>" placeholder="Nama Grup" class="col-xs-12 col-sm-10" required="required" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                            Department </label>

                                        <div class="col-sm-9">
                                            <select class="form-control" id="inputDept" name="txtDept">
                                                <?php foreach ($getDept as $set) :
                                                    if ($set->IDDept == $row->DeptID) {
                                                ?>
                                                        <option value="<?php echo $set->IDDept; ?>" selected><?php echo
                                                                                                                $set->DeptAbbr . " - " . $set->NamaDept; ?></option>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <option value="<?php echo $set->IDDept; ?>"><?php echo
                                                                                                    $set->DeptAbbr . " - " . $set->NamaDept; ?></option>
                                                <?php
                                                    }
                                                endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                            Grup User </label>

                                        <div class="col-sm-9">
                                            <select class="form-control" id="inputGrupID" name="txtGrupID">
                                                <?php foreach ($getGrupUser as $set) :
                                                    if ($set->GroupID == $row->GroupID) {
                                                ?>
                                                        <option value="<?php echo $set->GroupID; ?>" selected><?php echo
                                                                                                                $set->GroupName; ?></option>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <option value="<?php echo $set->GroupID; ?>"><?php echo
                                                                                                        $set->GroupName; ?></option>
                                                <?php
                                                    }
                                                endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Anggota Screening </label>
                                        <?php
                                        if ($row->AnggotaScreening === 1) {
                                            $Ac = "checked";
                                            $Na = "";
                                        } elseif ($row->AnggotaScreening === 0) {
                                            $Ac = "";
                                            $Na = "checked";
                                        }
                                        ?>
                                        <div class="col-sm-9">
                                            <div class="radio">
                                                <label>
                                                    <input name="txtScreening" type="radio" class="ace" value="1" <?php echo
                                                                                                                    $Ac; ?> />
                                                    <span class="lbl"> YES</span>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input name="txtScreening" type="radio" class="ace" value="0" <?php echo
                                                                                                                    $Na; ?> />
                                                    <span class="lbl"> NO</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Status </label>
                                        <?php
                                        if ($row->NotActive === 0) {
                                            $Ac = "checked";
                                            $Na = "";
                                        } elseif ($row->NotActive === 1) {
                                            $Ac = "";
                                            $Na = "checked";
                                        }
                                        ?>
                                        <div class="col-sm-9">
                                            <div class="radio">
                                                <label>
                                                    <input name="txtStatus" type="radio" class="ace" value="0" <?php echo
                                                                                                                $Ac; ?> />
                                                    <span class="lbl"> Active</span>
                                                </label>
                                            </div>

                                            <div class="radio">
                                                <label>
                                                    <input name="txtStatus" type="radio" class="ace" value="1" <?php echo
                                                                                                                $Na; ?> />
                                                    <span class="lbl"> Not Active</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Akses Notifikasi Telegram</label>
                                        <?php
                                        if ($row->notifaccess == 1) {
                                            $Ac = "checked";
                                            $Na = "";
                                        } elseif ($row->notifaccess == 0) {
                                            $Ac = "";
                                            $Na = "checked";
                                        }
                                        ?>
                                        <div class="col-sm-9">
                                            <div class="radio">
                                                <label>

                                                    <input name="txtnotifaccess" type="radio" class="ace" value="1" <?php echo
                                                                                                                    $Ac; ?> />
                                                    <span class="lbl"> Active</span>
                                                </label>
                                            </div>

                                            <div class="radio">
                                                <label>
                                                    <input name="txtnotifaccess" type="radio" class="ace" value="0" <?php echo
                                                                                                                    $Na; ?> />
                                                    <span class="lbl">Not Active</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tele Notif Screening by HRD </label>
                                        <?php
                                        if ($row->telenotif == 1) {
                                            $Ac = "checked";
                                            $Na = "";
                                        } elseif ($row->telenotif == 0) {
                                            $Ac = "";
                                            $Na = "checked";
                                        }
                                        ?>
                                        <div class="col-sm-9">
                                            <div class="radio">
                                                <label>

                                                    <input name="txtTelenotif" type="radio" class="ace" value="1" <?php echo
                                                                                                                    $Ac; ?> />
                                                    <span class="lbl"> Active</span>
                                                </label>
                                            </div>

                                            <div class="radio">
                                                <label>
                                                    <input name="txtTelenotif" type="radio" class="ace" value="0" <?php echo
                                                                                                                    $Na; ?> />
                                                    <span class="lbl">Not Active</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tele Notif Screening by TIM </label>
                                        <?php
                                        if ($row->telenotiftim == 1) {
                                            $Ac = "checked";
                                            $Na = "";
                                        } elseif ($row->telenotiftim == 0) {
                                            $Ac = "";
                                            $Na = "checked";
                                        }
                                        ?>
                                        <div class="col-sm-9">
                                            <div class="radio">
                                                <label>
                                                    <input name="txtTelenotifTim" type="radio" class="ace" value="1" <?php echo
                                                                                                                        $Ac; ?> />
                                                    <span class="lbl"> Active</span>
                                                </label>
                                            </div>

                                            <div class="radio">
                                                <label>
                                                    <input name="txtTelenotifTim" type="radio" class="ace" value="0" <?php echo
                                                                                                                        $Na; ?> />
                                                    <span class="lbl"> Not Active</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-offset-3 col-md-9">
                                            <input class="btn btn-sm btn-info" type="submit" name="simpan" value="Submit">
                                            <a class="btn btn-sm btn-info" href="listUserLogin">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </fieldset>

            </form>
        <?php endforeach; ?>

    </div>
</div>