<h4 class="row header smaller lighter red">
    <span class="col-sm-8">
        <i class="ace-icon fa fa-bell-o"></i>
        <strong> Jika ingin pindah Issue Permintaan</strong>
    </span>
</h4>
<?php $att = array('class'=>'form-horizontal', 'role'=>'form', 'id'=>'formSetDept');
    echo form_open('postingTenaker/updateDeptTujuan',$att);
?>
    <div class="form-group">
        <input name="txtHdrID" type="hidden" value="<?php foreach($datatk as $row){ echo $row->HeaderID; }?>"
    </div>
    <div class="form-group">
        <label class="col-sm-3 text-right">Pilih Tujuan</label>
        <div class="col-sm-6">
            <select class="form-control" name="txtTransID" id="inputIDDetail">
                <option value="">Pilih</option>
                <?php foreach ($_selectIssue as $rowDept): ?>
                <option value="<?php echo $rowDept->DetailID;?>">
                    <?php echo $rowDept->DeptAbbr."(".$rowDept->DetailID.") ".$rowDept->Pemborong." - ".$rowDept->TKPermintaan." orang - ".$rowDept->Pekerjaan;?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-6">
            <label class="col-sm-12">Permintaan Lama</label>
            <div class="col-sm-12">
                <div class="well well-sm">
                    <?php if($_rowIssue->Pemborong == 'PSG'){ $jenis  = "Posisi"; }else{ $jenis  = "Pekerjaan"; }?>
                    <?php echo $jenis.' : '.$_rowIssue->Pekerjaan;?><br/>
                    Keterangan : <?php echo $_rowIssue->IssueRemark;?><br/>
                    Jenis Kelamin : <?php echo $_rowIssue->JenisKelamin;?>, 
                    Umur : <?php echo $_rowIssue->Umur;?><br/>
                    Status : <?php echo $_rowIssue->StatusPersonal;?><br/>
                    Pendidikan : <?php echo $_rowIssue->Pendidikan;?>, Jurusan : <?php echo $_rowIssue->Jurusan;?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <label class="col-sm-12">Permintaan Baru</label>
            <div class="col-sm-12">
                <div class="well well-sm" id="txtKeteranganNew">
                    &nbsp;
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="col-sm-offset-3 col-sm-6">
            <button class="btn btn-mini btn-primary" type="submit" name="btnSave">
                <i class="ace-icon fa fa-save"></i> Simpan
            </button>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('#inputIDDetail').change(function (){
            var idDetail    = $(this).val();
            
            $.ajax({
                url: "<?php echo site_url('PostingTenaker/ajaxGetKeteranganIssue');?>",
                type: 'POST',
                data: "txtDetailID="+idDetail,
                dataType: 'json',
                success: function (data) {
                    $('#txtKeteranganNew').html(data);
                }
            });
        });
    });
</script>
<br/>
<br/>
<br/>
<br/>

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
    <div class="col-sm-12">
        <form name="formReset" method="post" action="<?php echo site_url('postingTenaker/resetToIndentifikasi');?>">
            <input name="txtHeaderID" type="hidden" value="<?php echo $row->HeaderID;?>" readonly="" />
            <button name="update" type="submit" class="btn btn-primary btn-mini btn-block" <?php echo ($row->WawancaraKe == 3 ? 'disabled': '');?> >
                <i class="ace-icon fa fa-arrow-circle-o-left"></i> Reset to Identification
            </button>                
        </form>
    </div>
    
    <div class="col-sm-12">
        <div class="widget-box transparent">
            <div class="widget-header widget-header-large">
                <h3 class="widget-title grey lighter">
                    <i class="ace-icon fa fa-users green"></i>
                    <?php 
                    if($row->Jenis_Kelamin == "M" || $row->Jenis_Kelamin == 'LAKI-LAKI'){
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
                            Vaksin 1: <?php echo $row->TanggalVaksin;?>
                        </li>
                         <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Vaksin 2: <?php echo $row->TanggalVaksin2;?>
                        </li>
                         <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Vaksin 3: <?php echo $row->TanggalVaksin3;?>
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

            <!-- /section:pages/invoice -->
    </div>
    <?php
        endforeach;
    ?>
</div>