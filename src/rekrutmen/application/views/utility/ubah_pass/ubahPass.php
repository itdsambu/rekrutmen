<div class="page-header">
    <h1>
        MANAGEMENT USER
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Ubah Password <span class="blue bolder"><?php echo $this->session->userdata('username');?></span>
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

      <?php
          echo $this->session->flashdata('message');
      ?>
        <!-- Design Disini -->
        <?php $att = array('class'=>'form-horizontal', 'role'=>'form');
        echo form_open('welcome/updatePassword', $att);
            ?>
            <fieldset>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="widget-box"
                            >
                            <div class="widget-header">
                                <h4 class="widget-title">Ubah Password</h4>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <?php
                                        if($this->input->get('msg')== 'ok'){
                                            echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                                                <i class='ace-icon fa fa-times'></i></button>Password berhasil dirubah..</p>";
                                        }elseif ($this->input->get('msg')== 'notMacth') {
                                            echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
                                                <i class='ace-icon fa fa-times'></i></button>Password lama anda tidak sesuai..</p>";
                                        }
                                    ?>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                            Password Lama </label>

                                        <div class="col-sm-9">
                                            <input type="hidden" id="inputUserID" name="txtUserID" value="<?php echo $this->session->userdata('userid');?>" class="col-xs-12 col-sm-10" required="required"/>

                                            <input type="password" id="inputOldPass" name="txtOldPass"
                                                   placeholder="Password Lama" class="col-xs-12 col-sm-10"
                                                   required="required"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                            Password Baru </label>

                                        <div class="col-sm-9">
                                            <input type="password" id="inputNewPass" name="txtNewPass"
                                                   placeholder="Password Baru" class="col-xs-12 col-sm-10"
                                                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password Minimal 8 Karakter, harus mengandung kombinasi Huruf besar/kecil dan angka." required="" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-3 col-md-9">
                                            <input class="btn btn-info" type="submit" name="simpan" value="Submit">
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