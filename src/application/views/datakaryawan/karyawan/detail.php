<h4 class="row header smaller lighter red">
    <span class="col-sm-8">
        <i class="ace-icon fa fa-bell-o"></i>
        <strong> Informasi Tenaga Kerja</strong>
    </span><!-- /.col -->
</h4>
<?php
    foreach($datak as $row):
        $nik = $row->NIK;
    endforeach;
    // $namafoto = "file=//192.168.1.5//appl//ID%20CARD//IMAGES//BORONGAN//".trim($nik).".JPG";
    $namafoto = 'dataupload/Blacklist/'.trim($nik).'.jpg';
    // $namafoto = 'dataupload/foto/'.trim($nik).'.jpg';
	//$namafotoTK='dataupload/Blacklist/BORONGAN/'.trim($NIK).'.JPG';
?>

<div class="row">
    <?php
        foreach($datak as $row):
    ?>
    <div class="col-sm-12">
        <div class="widget-box transparent">
            <div class="widget-header widget-header-large">
                <h3 class="widget-title grey lighter">
                    <i class="ace-icon fa fa-users green"></i>
                    <?php 
                    if($row->Sex == "L"){
                        $sapa = 'Mr. ';
                        $jekel= 'Laki-laki';
                    }  else {
                        $sapa = 'Mrs. ';
                        $jekel= 'Perempuan';
                    }
                    echo $sapa.ucwords(strtolower($row->NAMA));?>
                </h3>
            </div>
            <div class="col-sm-offset-5 col-sm-12">
                <div class="row">
                    <span class="profile-picture">
                        <!-- <img id="avatar" width="150" class="editable img-responsive editable-click editable-empty" src="<?php echo ('file://192.168.1.5/appl/ID CARD/IMAGES/BORONGAN/'.trim($nik).'.JPG') ?>" style="display: block;"></img> -->
                        <img id="avatar" width="150" class="editable img-responsive editable-click editable-empty" src="<?php echo base_url($namafoto) ?>"></img>
                    </span>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main padding-24">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-xs-12 label label-lg label-info arrowed-in arrowed-right">
                                    <b>Informasi Data Pribadi</b>
                                </div>
                            </div>

                            <div>
                                <ul class="list-unstyled spaced">
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        No. KTP : <?php echo $row->NoKTP;?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Alamat : <?php echo ucwords(strtolower($row->ALAMATS));?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Jenis Kelamin : 
										<?php 
										if($row->Sex == 'L'){
											echo 'Laki-laki';
										}else{
											echo 'Perempuan';
										}?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Tempat/Tanggal Lahir : <?php echo ucwords(strtolower($row->TEMPATLHR)).' / '.date('M, d Y',  strtotime($row->TGLLAHIR));?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Umur : <?php echo $_umur;?> Tahun
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Phone : 
                                        <b class="red"><?php echo $row->NoHP;?></b>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- /.col -->

                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-xs-12 label label-lg label-success arrowed-in arrowed-right">
                                    <b>Informasi Keluarga</b>
                                </div>
                            </div>
                            <div class="row">
                                <ul class="list-unstyled  spaced">
                                    <li>
                                        <i class="ace-icon fa fa-caret-right green"></i>
										Status :
										<?php
											if($row->STS == 1){echo 'Bujang';}
											elseif($row->STS == 2){echo 'Gadis';}
											elseif($row->STS == 3){echo 'Duda';}
											elseif($row->STS == 4){echo 'Janda';}
											elseif($row->STS == 5){echo 'Nikah';}
											else{echo '';}
										?>
                                    </li>
                                    
                                    <li>
                                        <i class="ace-icon fa fa-caret-right green"></i>
                                        Nama Istri/Suami : 
										<?php 
                                        if($row->SUAMIISTRI == ''){
                                            echo 'Tidak Beristri/Bersuami';
                                        }  else {
                                            echo ucwords(strtolower($row->SUAMIISTRI));
                                        }
                                        ?>
                                    </li>
                                </ul>
                                <ul class="list-unstyled  spaced">
                                    <li>
                                        <i class="ace-icon fa fa-caret-right green"></i>
                                        Nama Ibu : <?php echo $row->NamaIbuKandung;?>
                                    </li>
                                </ul>
                            </div>

                        </div><!-- /.col -->
                        
                    </div><!-- /.row -->

                </div>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-xs-12 label label-lg label-purple arrowed-in arrowed-right">
                        <b>Informasi Lainnya</b>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ul class="list-unstyled spaced">
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Daerah Asal : <?php echo $row->ALAMATR;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Suku : <?php echo $row->NamaSuku;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Agama : <?php echo $row->AGAMA;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Pendidikan : <?php echo $row->Pendidikan;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Jurusan : <?php echo $row->Jurusan;?>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
</div>
<?php endforeach; ?>