<h4 class="row header smaller lighter red">
    <span class="col-sm-8">
        <i class="ace-icon fa fa-bell-o"></i>
        <strong> Informasi Tenaga Kerja</strong>
    </span><!-- /.col -->
</h4>
<?php
    foreach($datatk as $row):
        $nik = $row->Nik;
    endforeach;
    // $namafoto = "file=//192.168.1.5//appl//ID%20CARD//IMAGES//BORONGAN//".trim($nik).".JPG";
    $namafoto = 'dataupload/Blacklist/BORONGAN/'.trim($nik).'.jpg';
	//$namafotoTK='dataupload/Blacklist/BORONGAN/'.trim($NIK).'.JPG';
?>

<div class="row">
    <?php
        foreach($datatk as $row):
    ?>
    <div class="col-sm-12">
        <div class="widget-box transparent">
            <div class="widget-header widget-header-large">
                <h3 class="widget-title grey lighter">
                    <i class="ace-icon fa fa-users green"></i>
                    <?php 
                    if($row->JenisKelamin == "M" || $row->JenisKelamin == "LAKI-LAKI"){
                        $sapa = 'Mr. ';
                        $jekel= 'Laki-laki';
                    }  else {
                        $sapa = 'Mrs. ';
                        $jekel= 'Perempuan';
                    }
                    echo $sapa.ucwords(strtolower($row->Nama));?>
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
                                        No. KTP : <?php echo $row->NOKTP;?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Alamat : <?php echo ucwords(strtolower($row->Alamat));?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Jenis Kelamin : <?php echo $jekel;?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Tempat/Tanggal Lahir : <?php echo ucwords(strtolower($row->TempatLahir)).' / '.date('M, d Y',  strtotime($row->TglLahir));?>
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
                                        Status : <?php echo ucwords(strtolower($row->StatusPerkawinan));?>
                                    </li>
                                    <?php if($row->StatusPerkawinan != 'BUJANG' && $row->StatusPerkawinan != 'GADIS'){
                                     echo '<li>
                                        <i class="ace-icon fa fa-caret-right green"></i>
                                        Jumlah Anak : '.$row->JmlAnak.'</li>';
                                    }
                                            ?>
                                    
                                    <li>
                                        <i class="ace-icon fa fa-caret-right green"></i>
                                        Nama Istri/Suami : <?php 
                                        if($row->NamaIstriSuami == NULL){
                                            echo 'Tidak Beristri/Bersuami';
                                        }  else {
                                            echo ucwords(strtolower($row->NamaIstriSuami));
                                        }
                                        ?>
                                    </li>
                                </ul>
                                <ul class="list-unstyled  spaced">
                                    <li>
                                        <i class="ace-icon fa fa-caret-right green"></i>
                                        Nama Ayah : <?php echo $row->NamaBapak;?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right green"></i>
                                        Nama Ibu : <?php echo $row->NamaIbu;?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right green"></i>
                                        Pekerjaan Orang Tua : <?php echo $row->PekerjaanOrtu;?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right green"></i>
                                        Anak Ke : <?php echo $row->AnakKe.' dari '.$row->JmlSaudara.' bersaudara';?>
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
                            Daerah Asal : <?php echo $row->DaerahAsal;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Bahasa Daerah : <?php echo $row->BahasaDaerah;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Suku : <?php echo $row->Suku;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Agama : <?php echo $row->Agama;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Hobby : <?php echo $row->Hobby;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Kegiatan Extra : <?php echo $row->KegExtra;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Kegiatan Organisasi : <?php echo $row->KegOrganisasi;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Pengalaman Kerja : <?php echo $row->PengalamanKerja;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Keahlian (Skill) : <?php echo $row->Keahlian;?>
                        </li>
                        
                    </ul>
                </div>
                <div class="col-sm-6">
                    <ul class="list-unstyled spaced">
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Tinggi Badan : <?php echo $row->TB.' cm';?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Berat Badan : <?php echo $row->BB.' kg';?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
</div>
<?php endforeach; ?>