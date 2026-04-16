<div class="page-header">
    <h1>
        MANAGEMENT PEMBORONG
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Edit Management Akses
        </small>
    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
                <!-- Design Disini -->
        <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PemborongAkses/editAksesGroup'); ?>">
            <?php foreach($getID as $row): ?>
            <fieldset>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4 class="widget-title">Edit Management Akses</h4>
                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <div class="form-group">
                                        <input type="hidden" id="txtID" name="txtID" placeholder="Group Name" class="col-xs-12 col-sm-10" value="<?= $row->ID ?>" required="required" readonly/>
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Group User </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="txtGroupName" name="txtGroupName" placeholder="Group Name" class="col-xs-12 col-sm-10" value="<?= $row->GroupName ?>" required="required" readonly/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nama Pemborong </label>
                                        <div class="col-sm-4">
                                            <?php if ($row->IDPemborong == 1){
                                                $nama = 'MUKHTAR';
                                            } elseif ($row->IDPemborong == '2') {
                                                $nama = 'SAROFI';
                                            } elseif ($row->IDPemborong == '3') {
                                                $nama = 'IBNU';
                                            } elseif ($row->IDPemborong == '4') {
                                                $nama = 'ANDI DARMA TAUFIK';
                                            } elseif ($row->IDPemborong == '5') {
                                                $nama = 'AMRANSYAH';
                                            } elseif ($row->IDPemborong == '6') {
                                                $nama = 'SAMURI';
                                            } elseif ($row->IDPemborong == '7') {
                                                $nama = 'SARMAN';
                                            } elseif ($row->IDPemborong == '8') {
                                                $nama = 'HENDRI';
                                            } elseif ($row->IDPemborong == '9') {
                                                $nama = 'RUSLAN';
                                            } elseif ($row->IDPemborong == '10') {
                                                $nama = 'SUPAR TRIYANTO';
                                            } elseif ($row->IDPemborong == '11') {
                                                $nama = 'JUANTO';
                                            } elseif ($row->IDPemborong == '12') {
                                                $nama = 'SUPRIHADI';
                                            } elseif ($row->IDPemborong == '13') {
                                                $nama = 'SYAFRIANTO';
                                            } elseif ($row->IDPemborong == '14') {
                                                $nama = 'HENNY';
                                            } elseif ($row->IDPemborong == '15') {
                                                $nama = 'FAHMI';
                                            } elseif ($row->IDPemborong == '16') {
                                                $nama = 'FIRMAN';
                                            } elseif ($row->IDPemborong == '17') {
                                                $nama = 'UNTUNG';
                                            } elseif ($row->IDPemborong == '18') {
                                                $nama = 'ROSDIANA';
                                            } elseif ($row->IDPemborong == '19') {
                                                $nama = 'PSG';
                                            } elseif ($row->IDPemborong == '21') {
                                                $nama = 'H. KETUT RUDIYANTO';
                                            } else {
                                                $nama = '';
                                            }?>
                                            <input type="text" id="txtGroupName" name="txtGroupName" placeholder="Group Name" class="col-xs-12 col-sm-10" value="<?= $nama ?>" required="required" readonly/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nama CV </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="txtGroupName" name="txtGroupName" placeholder="Group Name" class="col-xs-12 col-sm-10" value="<?= $row->TokoName ?>" required="required" readonly/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Status </label>
                                        <?php if($row->NotActive === 0){
                                            $Ac = "checked";
                                            $Na = "";
                                        }
                                        elseif($row->NotActive === 1){
                                            $Ac = "";
                                            $Na = "checked";
                                        } else {
                                            $Ac = "";
                                            $Na = "";
                                        } ?>
                                        <div class="col-sm-9">
                                            <div class="radio">
                                                <label>
                                                    <input name="txtStatus" type="radio" class="ace" value="0" <?php echo
                                                    $Ac;
                                                    ?>/>
                                                    <span class="lbl"> Active</span>
                                                </label>
                                            </div>

                                            <div class="radio">
                                                <label>
                                                    <input name="txtStatus" type="radio" class="ace" value="1" <?php echo
                                                    $Na;
                                                    ?>/>
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
            <?php endforeach; ?>
        </form>
    </div>
</div>