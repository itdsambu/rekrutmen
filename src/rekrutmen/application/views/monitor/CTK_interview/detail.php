<?php if (($this->session->userdata('userid') == 'psn_lisa') or ($this->session->userdata('userid') == 'sec_joko') or ($this->session->userdata('userid') == 'rmp_mana') or ($this->session->userdata('userid') == 'psn_gia') or ($this->session->userdata('userid') == 'mp1_erdaningsih') or ($this->session->userdata('userid') == 'mp2_erdaningsih')):?>
    <h4 class="row header smaller lighter orange">
        <span class="col-sm-8">
            <i class="ace-icon fa fa-files-o"></i>
            Catatan terhadap <strong><?php foreach ($datatk as $set){ echo ucwords(strtolower($set->Nama));}?></strong>
        </span>
    </h4>
    <?php
        $att = array('class'=>'form-horizontal', 'role'=>'form');
        echo form_open('Verifikasi/simpan', $att);
    ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2">Dept</th>
                    <th rowspan="2">Screening by</th>
                    <th rowspan="2">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 50px"><?php echo $this->session->userdata('dept');?>
                        <input name="txtDept" type="hidden" value="<?php echo $this->session->userdata('dept');?>" readonly="">
                    </td>
                    <td><?php echo $this->session->userdata('username');?>
                        <input name="txtHeaderID" type="hidden" value="<?php foreach ($datatk as $set){ echo $set->HeaderID;}?>" readonly="">
                        <input name="txtName" type="hidden" value="<?php echo $this->session->userdata('username');?>" readonly="">
                    </td>
                    <td class="col-sm-8">
                        <textarea id="inputKeterangan" name="txtKeterangan" class="form-control" required=""></textarea>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="form-group" >
        <input id="btnSubmitScreening" class="btn btn-sm btn-primary" type="submit" value="Simpan" name="btnSimpan"/>
    </div>
<?php else:?>
    <h4 class="row header smaller lighter orange" hidden>
        <span class="col-sm-8">
            <i class="ace-icon fa fa-files-o"></i>
            Catatan terhadap <strong><?php foreach ($datatk as $set){ echo ucwords(strtolower($set->Nama));}?></strong>
        </span>
    </h4>
    <!-- <?php
        $att = array('class'=>'form-horizontal', 'role'=>'form');
        echo form_open('screeningByTim/simpan', $att);
    ?> -->
    <div class="table-responsive" hidden>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2">Dept</th>
                    <th rowspan="2">Screening by</th>
                    <th rowspan="2">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 50px"><?php echo $this->session->userdata('dept');?>
                        <input name="txtDept" type="hidden" value="<?php echo $this->session->userdata('dept');?>" readonly="">
                    </td>
                    <td><?php echo $this->session->userdata('username');?>
                        <input name="txtHeaderID" type="hidden" value="<?php foreach ($datatk as $set){ echo $set->HeaderID;}?>" readonly="">
                        <input name="txtName" type="hidden" value="<?php echo $this->session->userdata('username');?>" readonly="">
                    </td>
                    <td class="col-sm-8">
                        <textarea id="inputKeterangan" name="txtKeterangan" class="form-control" required=""></textarea>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="form-group" hidden>
        <input id="btnSubmitScreening" class="btn btn-sm btn-primary" type="submit" value="Simpan" name="btnSimpan"/>
    </div>
<?php endif;?>

<h4 class="row header smaller lighter green">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-info-circle"></i>
        <?php
        foreach($datatk as $set):
            echo "Hasil Catatan dari TEAM terhadap <strong>".ucwords(strtolower($set->Nama))."</strong>";
        endforeach;
        ?>
    </span><!-- /.col -->
</h4>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th >Dept</th>
                <th >Screening by</th>
                <th >Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultScreen as $row):?>
            <tr>
                <td style="width: 50px">
                    <?php echo $row->Dept;?>
                </td>
                <td>
                    <?php echo $row->VirifiedBy;?>                    
                </td>
                <td class="col-sm-3">
                    <?php echo $row->VirifiedKet;?>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
<h4 class="row header smaller lighter red">
    <span class="col-sm-8">
        <i class="ace-icon fa fa-bell-o"></i>
        <strong> Informasi Calon Tenaga Kerja</strong>
    </span><!-- /.col -->
</h4>
<?php
    foreach($datatk as $row):
        $hdrid = $row->HeaderID;
    endforeach;
    $namafoto = './dataupload/foto/'.$hdrid.'.jpg';
?>

<div class="row">
    <?php
        foreach($datatk as $row):
    ?>
    <div class="col-sm-6">
<!--        <a href="<?php //echo site_url('verifikasi/closeTenaker/'.$row->HeaderID);?>" class="btn btn-danger btn-mini btn-block">
            <i class="ace-icon fa fa-times"></i> Close
        </a>-->
        <button id="btnCloseTenaker" class="btn btn-danger btn-mini btn-block"><i class="ace-icon fa fa-times"></i> Close</button>
    </div>
    <div class="col-sm-6">
        <a href="<?php echo site_url('ubahDataKaryawan/index/'.$row->HeaderID);?>" class="btn btn-success btn-mini btn-block">
            <i class="ace-icon fa fa-edit"></i> Edit
        </a>
    </div>
    <div class="col-sm-12">
        <div class="widget-box transparent">
            <div class="widget-header widget-header-large">
                <h3 class="widget-title grey lighter">
                    <i class="ace-icon fa fa-users green"></i>
                    <?php 
                    if($row->Jenis_Kelamin == "M" || $row->Jenis_Kelamin == "LAKI-LAKI"){
                        $sapa = 'Mr. ';
                        $jekel= 'Laki-laki';
                    }  else {
                        $sapa = 'Mrs. ';
                        $jekel= 'Perempuan';
                    }
                    echo $sapa.ucwords(strtolower($row->Nama));?>
                </h3>

                <div class="widget-toolbar no-border invoice-info">
                    <span class="invoice-info-label">ID Reg:</span>
                    <span class="red"><?php echo "#".$row->HeaderID;?></span>

                    <br />
                    <span class="invoice-info-label">Date Reg:</span>
                    <span class="blue"><?php echo date('M, d Y',  strtotime($row->RegisteredDate));?></span>
                </div>
            </div>
            <div class="col-sm-offset-5 col-sm-12">
                <div class="row">
                    <span class="profile-picture">
                        <img id="avatar" width="150" class="editable img-responsive editable-click editable-empty" src="<?php echo base_url($namafoto); ?>" style="display: block;"></img>
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
                                        Perusahaan : <?php echo $row->CVNama;?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Pemborong : <?php echo $row->Pemborong;?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        No. KTP : <?php echo $row->No_Ktp;?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Alamat : <?php echo ucwords(strtolower($row->Alamat))." RT: ".$row->RT." RW: ".$row->RW;?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Jenis Kelamin : <?php echo $jekel;?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Tempat/Tanggal Lahir : <?php echo ucwords(strtolower($row->Tempat_Lahir)).' / '.date('M, d Y',  strtotime($row->Tgl_Lahir));?>
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
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Sosial Media : 
                                        <?php 
                                            if($row->AccountFacebook != " "){
                                        ?>
                                        <i class="ace-icon fa fa-facebook-square bigger-120"></i><a href="http://facebook.com/<?php echo $row->AccountFacebook;?>" target="_blank">Facebook</a>
                                        <?php }elseif ($row->AccountTwitter != " ") { ?>
                                        <i class="ace-icon fa fa-twitter-square bigger-120"></i><a href="http://twitter.com/<?php echo $row->AccountTwitter;?>" target="_blank">Twitter</a>
                                        <?php }elseif($row->Account_email != " ") {?>
                                        <i class="ace-icon fa fa-envelope bigger-120"></i><a href="mailto<?php echo $row->Account_email;?>" target="_blank">Email</a>
                                        <?php }  else {
                                         echo 'Tidak Ada';
                                        }?>
                                    </li>
                                    
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Kerabat : <?php echo $row->Kerabat_Nama;?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        No.HP Kerabat : 
                                        <b class="red"><?php echo $row->Kerabat_Telepon;?> </b>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Hubungan dgn Kerabat : <?php echo $row->Kerabat_Hubungan;?> 
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
                                        Status : <?php echo ucwords(strtolower($row->Status_Personal));?>
                                    </li>
                                    <?php if($row->Status_Personal != 'BUJANG' && $row->Status_Personal != 'GADIS'){
                                     echo '<li>
                                        <i class="ace-icon fa fa-caret-right green"></i>
                                        Jumlah Anak : '.$row->JumlahAnak.'</li>';
                                    }
                                            ?>
                                    
                                    <li>
                                        <i class="ace-icon fa fa-caret-right green"></i>
                                        Nama Istri/Suami : <?php 
                                        if($row->NamaSuamiIstri == NULL){
                                            echo 'Tidak Beristri/Bersuami';
                                        }  else {
                                            echo ucwords(strtolower($row->NamaSuamiIstri));
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right green"></i>
                                        Pekerjaan Istri/Suami : <?php 
                                        if($row->PekerjaanSuamiIstri == NULL){
                                            echo 'Tidak Beristri/Bersuami';
                                        }else{
                                            echo ucwords(strtolower($row->PekerjaanSuamiIstri));
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
                                        Nama Ibu : <?php echo $row->NamaIbuKandung;?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right green"></i>
                                        Pekerjaan Orang Tua : <?php echo $row->ProfesiOrangTua;?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right green"></i>
                                        Anak Ke : <?php echo $row->AnakKe.' dari '.$row->JumlahSaudara.' bersaudara';?>
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
                            Daerah Asal : <?php echo $row->Daerah_Asal;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>							
                            Provinsi : <?php echo $row->ProvinsiName;?>
                        </li>
						<li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Kabupaten : <?php echo $row->Kabupaten_KotaName;?>
                        </li>
						<li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Kecamatan : <?php echo $row->KecamatanName;?>
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
                            Kegiatan Extra : <?php echo $row->KegiatanEkstra;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Kegiatan Organisasi : <?php echo $row->KegiatanOrganisasi;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Pengalaman Kerja : <?php echo $row->PengalamanKerja;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Keahlian (Skill) : <?php echo $row->Keahlian;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Pernah Kerja di PT. SAMBU : <?php echo $row->PernahKerjaDiSambu;?>
                        </li>
                        <?php
                           if($row->PernahKerjaDiSambu == 'YA'){
                               echo '<li><i class="ace-icon fa fa-caret-right purple"></i>
                            Department/Bagaian : '.$row->KerjadiBagian.'</li>';
                           }
                        ?>
                        
                    </ul>
                </div>
                <div class="col-sm-6">
                    <ul class="list-unstyled spaced">
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Tinggi Badan : <?php echo $row->TinggiBadan.' cm';?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Berat Badan : <?php echo $row->BeratBadan.' kg';?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Keadaan Fisik : <?php echo $row->KeadaanFisik;?>
                        </li>
                        <?php
                        if(strtoupper($row->KeadaanFisik) == "CACAT"){
                            echo '<li><i class="ace-icon fa fa-caret-right purple"></i>
                            Cacat yang dialami : '.$row->CacatApa.'</li>';
                        }
                        ?>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Idap Penyakit : <?php echo $row->PernahIdapPenyakit;?>
                        </li>
                        <?php
                        if($row->PernahIdapPenyakit == "YA"){
                            echo '<li><i class="ace-icon fa fa-caret-right purple"></i>
                            Penyakit yang dimiliki : '.$row->PenyakitApa.'</li>';
                        }
                        ?>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Terlibat Kriminal : <?php echo $row->Kriminal;?>
                        </li>
                        <?php
                        if($row->Kriminal == "YA"){
                            echo '<li><i class="ace-icon fa fa-caret-right purple"></i>
                            Perkara yang pernah dilakukan : '.$row->PerkaraApa.'</li>';
                        }
                        ?>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Bertindik : <?php echo $row->Bertindik;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Bertato : <?php echo $row->Bertato;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Sedia Potong Rambut : <?php echo $row->SediaPotongRambut;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Sedia Diberhentikan : <?php echo $row->Sediadiberhentikan;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Jenis Vaksin : <?php echo $row->JenisVaksin;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Vaksin 1 : <?php echo $row->TanggalVaksin;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Vaksin 2 : <?php echo $row->TanggalVaksin2;?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Vaksin 3 : <?php echo $row->TanggalVaksin3;?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xs-12 label label-lg label-danger arrowed-in arrowed-right">
                <i class="ace-icon fa fa-university"></i> <b>Informasi Pendidikan</b>
            </div>
            <div class="table table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="center">Pendidikan</th>
                            <th>Jurusan</th>
                            <th>Sekolah/ Universitas</th>
                            <th>Nilai Rata-rata/ IPK (Skalas 4.00)</th>
                            <th>Tahun Masuk</th>
                            <th>Tahun Lulus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="center">
                                <?php echo $row->Pendidikan;?>
                            </td>
                            <td>
                                <?php echo $row->Jurusan;?>
                            </td>
                            <td>
                                <?php echo $row->Universitas;?>
                            </td>
                            <td>
                                <?php echo $row->IPK;?>
                            </td>
                            <td><?php echo $row->TahunMasuk;?></td>
                            <td><?php echo $row->TahunLulus;?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>

<!-- Modal Close Tenaker -->
<div class="modal fade" id="viewModalClose" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Close Data Tenaker, <?php echo $sapa.ucwords(strtolower($row->Nama));?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="<?php echo site_url('verifikasi/closeTenaker');?>" role="form" method="post" class="form-horizontal">
                            <input type="hidden" id="txtInputHeaderID" name="txtHeaderID" value="<?php echo $row->HeaderID;?>">
                            <div class="form-group">
                                <label class="control-label col-sm-4">Keterangan</label>
                                <div class="col-sm-6">
                                    <textarea name="txtRemarkClose" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-6">
                                    <button type="submit" name="btnSubmit" class="btn btn-danger btn-sm">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">              
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<script>
    $(document).ready(function() {        
        $("#btnCloseTenaker").on("click", function() {
            $("#viewModalClose").modal("show");
        });
    });
</script>

<script type="text/javascript">
    $('form').on('submit', function () {
        $('#btnSubmitScreening').prop('disabled', true);
    });

</script>