<div class="row">
    <div class="col-lg-offset-3 col-xs-6">
        <form class="form-horizontal" role="form" method="POST" id="form-updateProfile" action="<?php echo site_url('user_profil/updateProfile');?>">
            <h4 class="row header smaller lighter orange">
                <span class="col-sm-8">
                    <i class="ace-icon fa fa-user"></i>
                    Data Diri
                </span>
            </h4>
            <?php foreach ($_getProfilSendiri as $row): ?>
            <div class="form-group">
                <label for="inputNamaDepan">First Name</label>
                <input class="form-control" type="text" id="inputNamaDepan" name="txtNamaDepan" value="<?php echo $row->NamaDepan;?>"/>
            </div>
            <div class="form-group">
                <label for="inputNamaBelakang">Last Name</label>
                <input class="form-control" type="text" id="inputNamaBelakang" name="txtNamaBelakang" value="<?php echo $row->NamaBelakang;?>"/>
            </div>
            <div class="form-group">
                <label for="inputTglLahir">Tanggal Lahir</label>
                <input class="form-control" type="date" id="inputTglLahir" name="txtTglLahir" value="<?php echo $row->TanggalLahir;?>"/>
            </div>
            <?php
            if($row->JenisKelamin == 'M'){
                $m  = 'checked';
                $f  = '';
            }else{
                $m  = '';
                $f  = 'checked';
            }
            ?>
            <div class="form-group">
                <label for="inputJekel">Jenis Kelamin</label>
                <div class="radio">
                    <label>
                        <input id="inputJekel" name="txtJekel" type="radio" class="ace" value="M" <?php echo $m;?> >
                        <span class="lbl"> Laki-laki</span>
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input id="inputJekel" name="txtJekel" type="radio" class="ace" value="F" <?php echo $f;?> >
                        <span class="lbl"> Perempuan</span>
                    </label>
                </div>
            </div>
            <h4 class="row header smaller lighter blue">
                <span class="col-sm-8">
                    <i class="ace-icon fa fa-bullhorn"></i>
                    Infomasi Lainnya
                </span>
            </h4>
            <div class="input-group">
                <span class="input-group-addon ">
                    <i class="ace-icon fa fa-envelope-square bigger-130"></i>
                </span>
                <input class="form-control" type="text" id="inputEmail" name="txtEmail" placeholder="Input Email Anda..." value="<?php echo $row->Email;?>"/>
            </div>
            <div class="space-6"></div>
            <div class="input-group">
                <span class="input-group-addon ">
                    <i class="ace-icon fa fa-globe bigger-130"></i>
                </span>
                <input class="form-control" type="text" id="inputWebPage" name="txtWebPage" placeholder="Input Web Page Anda..." value="<?php echo $row->URL;?>"/>
            </div>
            <div class="space-6"></div>
            <div class="input-group">
                <span class="input-group-addon ">
                    <i class="ace-icon fa fa-facebook-square blue primary bigger-130"></i>
                </span>
                <input class="form-control" type="text" id="inputWebPage" name="txtFacebook" placeholder="Facebook Account" value="<?php echo $row->Facebook;?>"/>
            </div>
            <div class="input-group">
                <span class="input-group-addon ">
                    <i class="ace-icon fa fa-twitter-square light-blue bigger-130"></i>
                </span>
                <input class="form-control" type="text" id="inputWebPage" name="txtTwitter" placeholder="Twitter Account" value="<?php echo $row->Twitter;?>"/>
            </div>
            <div class="input-group">
                <span class="input-group-addon ">
                    <i class="ace-icon fa fa-google-plus-square red bigger-130"></i>
                </span>
                <input class="form-control" type="text" id="inputWebPage" name="txtGooglePlus" placeholder="Google Plus Account" value="<?php echo $row->GooglePlus;?>"/>
            </div>
            <?php endforeach; ?>
            <div class="space-6"></div>
            <div class="center">
                <input class="btn btn-mini btn-primary btn-round btn-block" type="submit" id="btnSubmit" name="btnSubmit" value="Update"/>
            </div>
        </form>
    </div>
</div>