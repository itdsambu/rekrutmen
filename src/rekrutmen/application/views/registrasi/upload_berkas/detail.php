<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Dept</th>
                <th>Screening by</th>
                <th class="text-center">Kenal?</th>
                <th class="text-center">Pernah Kerja</th>
                <th class="text-center">Direcomen</th>
                <th class="text-center">Jeda?</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultScreen as $row) : ?>
                <tr>
                    <td style="width: 50px">
                        <?php echo $row->Dept; ?>
                        <!-- <?php echo $row->HeaderID; ?>
                        <?php echo $row->DetailID; ?> -->
                    </td>
                    <td>
                        <?php echo $row->ScreeningBy; ?>
                    </td>
                    <td class="text-center" style="width: 100px">
                        <?php
                        if ($row->Kenal == 1) {
                            echo 'YA';
                        } else {
                            echo 'TIDAK';
                        }
                        ?>
                    </td>
                    <td class="text-center" style="width: 100px">
                        <?php
                        if ($row->PernahKerja == 1) {
                            echo 'YA';
                        } else {
                            echo 'TIDAK';
                        }
                        ?>
                    </td>
                    <td class="text-center" style="width: 100px">
                        <?php
                        if ($row->Lulus == 1) {
                            echo 'YA';
                        } else {
                            echo 'TIDAK';
                        }
                        ?>
                    </td>
                    <td class="text-center" style="width: 100px">
                        <?php
                        if ($row->Jeda == 1) {
                            echo 'YA';
                        } else {
                            echo 'TIDAK';
                        }
                        ?>
                    </td>
                    <td class="col-sm-3">
                        <?php echo $row->ScreeningKet; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
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
foreach ($datatk as $row) :
    $hdrid = $row->HeaderID;
endforeach;
$namafoto = '/dataupload/foto/' . $hdrid . '.jpg';
$file_path = FCPATH . $namafoto; // full local path
?>

<div class="row">
    <?php
    foreach ($datatk as $row) :
    ?>
        <?php
        if (($this->session->userdata('groupuser') == '79') || ($this->session->userdata('groupuser') == '1') || ($this->session->userdata('groupuser') == '44') || ($this->session->userdata('groupuser') == '13') || ($this->session->userdata('groupuser') == '93')) { ?>
            <div class="col-sm-6">
                <button id="btnCloseTenaker" class="btn btn-danger btn-mini btn-block"><i class="ace-icon fa fa-times"></i> Close</button>
            </div>
            <div class="col-sm-6">
                <a href="<?php echo site_url('ubahDataKaryawan/index/' . $row->HeaderID); ?>" class="btn btn-success btn-mini btn-block">
                    <i class="ace-icon fa fa-edit"></i> Edit
                </a>
            </div>
        <?php } else { ?>
            <div class="col-sm-12">
                <a href="<?php echo site_url('ubahDataKaryawan/index/' . $row->HeaderID); ?>" class="btn btn-success btn-mini btn-block">
                    <i class="ace-icon fa fa-edit"></i> Edit
                </a>
            </div>
        <?php } ?>
        <div class="col-sm-12">
            <div class="widget-box transparent">
                <div class="widget-header widget-header-large">
                    <h3 class="widget-title grey lighter">
                        <i class="ace-icon fa fa-users green"></i>
                        <?php
                        if ($row->Jenis_Kelamin == "M" || $row->Jenis_Kelamin == 'LAKI-LAKI') {
                            $sapa = 'Mr. ';
                            $jekel = 'Laki-laki';
                        } else {
                            $sapa = 'Mrs. ';
                            $jekel = 'Perempuan';
                        }
                        echo $sapa . ucwords(strtolower($row->Nama)); ?>
                    </h3>

                    <div class="widget-toolbar no-border invoice-info">
                        <span class="invoice-info-label">ID Reg:</span>
                        <span class="red"><?php echo "#" . $row->HeaderID; ?></span>

                        <br />
                        <span class="invoice-info-label">Date Reg:</span>
                        <span class="blue"><?php echo date('M, d Y',  strtotime($row->RegisteredDate)); ?></span>
                    </div>
                </div>
                <div class="col-sm-offset-5 col-sm-12">
                    <div class="row">
                        <span class="profile-picture">
                            <?php if (file_exists($file_path)) { ?>
                                <img id="avatar" width="150" class="editable img-responsive editable-click editable-empty" src="<?php echo base_url($namafoto); ?>" style="display: block;"></img>
                            <?php } else { ?>
                                Foto tidak tersedia !!
                            <?php } ?>
                        </span>
                        <!-- <ul class="ace-thumbnails clearfix">
                        <li>
                            <img id="avatar" class="img-responsive" width="180" height="180" alt="<?php echo $row->Nama; ?>'s Avatar" src="<?php echo base_url($namafoto); ?>"></img>
                            <div id="photo" class="tools tools-right">
                                <a href="<?php echo site_url('monitor/ubahfotokaryawan?id=' . $row->HeaderID); ?>" title="Change Photo" class="changePhoto" data-id="<?php echo $row->HeaderID; ?>">
                                    <i class="ace-icon fa fa-edit"></i>
                                </a>
                            </div>
                        </li>
                    </ul> -->
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
                                            Perusahaan : <?php echo $row->CVNama; ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right blue"></i>
                                            Pemborong : <?php echo $row->Pemborong; ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right blue"></i>
                                            Sub Pemborong : <?php echo $row->SubPemborong; ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right blue"></i>
                                            No. KTP : <?php echo $row->No_Ktp; ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right blue"></i>
                                            No. KK : <?php echo $row->No_KK; ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right blue"></i>
                                            Alamat e-KTP : <?php echo ucwords(strtolower($row->Alamat_KTP)); ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right blue"></i>
                                            Alamat Sekarang : <?php echo ucwords(strtolower($row->Alamat)) . " RT: " . $row->RT . " RW: " . $row->RW; ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right blue"></i>
                                            Jenis Kelamin : <?php echo $jekel; ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right blue"></i>
                                            Tempat/Tanggal Lahir : <?php echo ucwords(strtolower($row->Tempat_Lahir)) . ' / ' . date('d-m-Y',  strtotime($row->Tgl_Lahir)); ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right blue"></i>
                                            Phone :
                                            <b class="red"><?php echo $row->NoHP; ?></b>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right blue"></i>
                                            Sosial Media :
                                            <?php
                                            if ($row->AccountFacebook != "" || $row->Account_email != "" || $row->AccountTwitter != "") {
                                            ?>
                                                <i class="ace-icon fa fa-facebook-square bigger-120"></i><a href="http://facebook.com/<?php echo $row->AccountFacebook; ?>" target="_blank">Facebook</a>

                                                <i class="ace-icon fa fa-twitter-square bigger-120"></i><a href="http://twitter.com/<?php echo $row->AccountTwitter; ?>" target="_blank">Twitter</a>

                                                <i class="ace-icon fa fa-envelope bigger-120"></i><a href="mailto<?php echo $row->Account_email; ?>" target="_blank"><?php echo $row->Account_email; ?></a>
                                            <?php } else {
                                                echo 'Tidak Ada';
                                            } ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right blue"></i>
                                            Kerabat : <?php echo $row->Kerabat_Nama; ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right blue"></i>
                                            No.HP Kerabat :
                                            <b class="red"><?php echo $row->Kerabat_Telepon; ?> </b>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right blue"></i>
                                            Hubungan dgn Kerabat : <?php echo $row->Kerabat_Hubungan; ?>
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
                                        <!-- izin ye bang kiki hehe -->
                                        <!-- <li>
                                            <i class="ace-icon fa fa-caret-right green"></i>
                                            Status : <?php echo ucwords(strtolower($row->Status_Personal)); ?>
                                        </li> -->
                                        <!-- 15/04/2025 -->
                                        <li>
                                            <i class="ace-icon fa fa-caret-right green"></i>
                                            Status :
                                            <?php
                                            $statusMap = [
                                                1 => "Bujang",
                                                2 => "Gadis",
                                                3 => "Duda",
                                                4 => "Janda",
                                                5 => "Nikah"
                                            ];

                                            $statusID = $row->Status_Personal;
                                            echo $statusMap[$statusID] ?? ucwords(strtolower($statusID));
                                            ?>
                                        </li>

                                        <?php if ($row->Status_Personal != 'BUJANG' && $row->Status_Personal != 'GADIS') {
                                            echo '<li>
                                        <i class="ace-icon fa fa-caret-right green"></i>
                                        Jumlah Anak : ' . $row->JumlahAnak . '</li>';
                                        }
                                        ?>

                                        <li>
                                            <i class="ace-icon fa fa-caret-right green"></i>
                                            Nama Istri/Suami : <?php
                                                                if ($row->NamaSuamiIstri == NULL) {
                                                                    echo 'Tidak Beristri/Bersuami';
                                                                } else {
                                                                    echo ucwords(strtolower($row->NamaSuamiIstri));
                                                                }
                                                                ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right green"></i>
                                            Pekerjaan Istri/Suami : <?php
                                                                    if ($row->PekerjaanSuamiIstri == NULL) {
                                                                        echo 'Tidak Beristri/Bersuami';
                                                                    } else {
                                                                        echo ucwords(strtolower($row->PekerjaanSuamiIstri));
                                                                    }
                                                                    ?>
                                        </li>
                                    </ul>
                                    <ul class="list-unstyled  spaced">
                                        <li>
                                            <i class="ace-icon fa fa-caret-right green"></i>
                                            Nama Ayah : <?php echo $row->NamaBapak; ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right green"></i>
                                            Nama Ibu : <?php echo $row->NamaIbuKandung; ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right green"></i>
                                            Pekerjaan Orang Tua : <?php echo $row->ProfesiOrangTua; ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right green"></i>
                                            Anak Ke : <?php echo $row->AnakKe . ' dari ' . $row->JumlahSaudara . ' bersaudara'; ?>
                                        </li>
                                    </ul>
                                </div>

                            </div><!-- /.col -->
                            <div class="table table-responsive" style="display: block;">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="center">NAMA SAUDARA</th>
                                            <th class="center">UMUR</th>
                                            <th class="center">JURUSAN</th>
                                            <th class="center">PEKERJAAN</th>
                                            <th class="center">PERUSAHAAN</th>
                                            <th class="center">JABATAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $dt = $this->m_upload_berkas->getListSaudara($row->HeaderID);
                                        foreach ($dt as $key) {
                                            # code...

                                        ?>
                                            <tr>
                                                <td class="center">
                                                    <?php echo $key->Nama; ?>
                                                </td>
                                                <td class="center">
                                                    <?php if ($key->JenisKelamin == 1) {
                                                        echo 'L';
                                                    } else {
                                                        echo 'P';
                                                    } ?>
                                                </td>
                                                <td class="center">
                                                    <?php echo $key->Umur; ?>
                                                </td>
                                                <td class="center">
                                                    <?php echo $key->Pekerjaan; ?>
                                                </td>
                                                <td class="center">
                                                    <?php echo $key->Perusahaan; ?>
                                                </td>
                                                <td class="center">
                                                    <?php echo $key->Jabatan; ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- /.row -->

                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-xs-12 label label-lg label-info arrowed-in arrowed-right">
                            <b>Informasi Ahli Waris</b>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-unstyled spaced">
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Nama Ahli Waris : <?= $row->AhliWaris_Nama; ?>
                            </li>
                        </ul>
                        <ul class="list-unstyled spaced">
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Jenis Kelamin Ahli Waris : <?= $row->AhliWaris_Jekel; ?>
                            </li>
                        </ul>
                        <ul class="list-unstyled spaced">
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Alamat Ahli Waris : <?= $row->AhliWaris_Alamat; ?>
                            </li>
                        </ul>
                        <ul class="list-unstyled spaced">
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Hubungan Ahli Waris : <?= $row->AhliWaris_Hubungan; ?>
                            </li>
                        </ul>
                        <ul class="list-unstyled spaced">
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                No HP. Ahli Waris : <?= $row->AhliWaris_NoHP; ?>
                            </li>
                        </ul>
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
                                Daerah Asal : <?= $row->Daerah_Asal; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Provinsi : <?= $row->Provinsi; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Kabupaten : <?= $row->KabupatenKota; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Kecamatan: <?= $row->Kecamatan; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Bahasa Daerah : <?= $row->BahasaDaerah; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Suku : <?= $row->Suku; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Agama : <?= $row->Agama; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Hobby : <?= $row->Hobby; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Kegiatan Extra : <?= $row->KegiatanEkstra; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Vaksin : <?php if ($row->Vaksin == 'SUDAH') {
                                                echo $row->Vaksin;
                                            } else {
                                                echo 'BELUM';
                                            } ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Jenis Vaksin : <?= $row->JenisVaksin; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Vaksin 1 : <?php if ($row->TanggalVaksin != '' || $row->TanggalVaksin != NULL) {
                                                echo date('d-m-Y', strtotime($row->TanggalVaksin));
                                            } else {
                                                echo '-';
                                            } ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Vaksin 2 : <?php if ($row->TanggalVaksin2 != '' || $row->TanggalVaksin2 != NULL) {
                                                echo date('d-m-Y', strtotime($row->TanggalVaksin2));
                                            } else {
                                                echo '-';
                                            } ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Vaksin 3 : <?php if ($row->TanggalVaksin3 != '' || $row->TanggalVaksin3 != NULL) {
                                                echo date('d-m-Y', strtotime($row->TanggalVaksin3));
                                            } else {
                                                echo '-';
                                            } ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Screening : <?php echo $row->AppDivBy; ?>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-unstyled spaced">
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Kegiatan Organisasi : <?php echo $row->KegiatanOrganisasi; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Pengalaman Kerja : <?php echo $row->PengalamanKerja; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Keahlian (Skill) : <?php echo $row->Keahlian; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Pernah Kerja di PT. SAMBU : <?php echo $row->PernahKerjaDiSambu; ?>
                            </li>
                            <?php
                            if ($row->PernahKerjaDiSambu == 'YA') {
                                echo '<li><i class="ace-icon fa fa-caret-right purple"></i>
                            Department/Bagaian : ' . $row->KerjadiBagian . '</li>';
                            }
                            ?>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Tinggi Badan : <?php echo $row->TinggiBadan . ' cm'; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Berat Badan : <?php echo $row->BeratBadan . ' kg'; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Keadaan Fisik : <?php echo $row->KeadaanFisik; ?>
                            </li>
                            <?php
                            if (strtoupper($row->KeadaanFisik) == "CACAT") {
                                echo '<li><i class="ace-icon fa fa-caret-right purple"></i>
                            Cacat yang dialami : ' . $row->CacatApa . '</li>';
                            }
                            ?>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Idap Penyakit : <?php echo $row->PernahIdapPenyakit; ?>
                            </li>
                            <?php
                            if ($row->PernahIdapPenyakit == "YA") {
                                echo '<li><i class="ace-icon fa fa-caret-right purple"></i>
                            Penyakit yang dimiliki : ' . $row->PenyakitApa . '</li>';
                            }
                            ?>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Terlibat Kriminal : <?php echo $row->Kriminal; ?>
                            </li>
                            <?php
                            if ($row->Kriminal == "YA") {
                                echo '<li><i class="ace-icon fa fa-caret-right purple"></i>
                            Perkara yang pernah dilakukan : ' . $row->PerkaraApa . '</li>';
                            }
                            ?>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Bertindik : <?php echo $row->Bertindik; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Bertato : <?php echo $row->Bertato; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Sedia Potong Rambut : <?php echo $row->SediaPotongRambut; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Sedia Diberhentikan : <?php echo $row->Sediadiberhentikan; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Pembekalan P2K3 : <?php echo $row->AppP2K3By; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Catatan By P2K3 : <?php echo $row->AppP2K3Catatan; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Pembekalan ELC : <?php echo $row->AppELCBy; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Catatan By ELC : <?php echo $row->AppELCCatatan; ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 label label-lg label-danger arrowed-in arrowed-right">
                    <i class="ace-icon fa fa-university"></i> <b>Informasi Pendidikan</b>
                </div>
                <div class="col-sm-12">
                    <table width="100%">
                        <!--  <tbody>
                        <tr>
                            <td width="25%">Pendidikan Terakhir</td><td>: <?php echo $row->Pendidikan; ?></td>
                        </tr>
                        <tr>
                            <td width="25%">Sekolah/ Universitas</td><td>: <?php echo $row->Universitas; ?></td>
                        </tr>
                        <tr>
                            <td width="25%">Jurusan</td><td>: <?php echo $row->Jurusan; ?></td>
                        </tr>
                        <tr>
                            <td width="25%">Ijazah Terakhir</td><td>: <?php echo $row->Pendidikan; ?></td>
                        </tr>

                    </tbody> -->
                    </table>
                    <!-- <ul class="list-unstyled spaced">
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Pendidikan Terakhir : <?php echo $row->Pendidikan; ?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Jurusan : <?php echo $row->Jurusan; ?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Sekolah/ Universitas : <?php echo $row->Universitas; ?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Nilai Rata-rata/ IPK (Skalas 4.00) : <?php echo $row->IPK; ?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Tahun Masuk: <?php echo $row->TahunMasuk; ?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right purple"></i>
                            Tahun Lulus : <?php echo $row->TahunLulus; ?>
                        </li>
                        
                    </ul> -->
                </div><br>
                <div class="table table-responsive">
                    <!--  <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="center">TINGKAT</th>
                            <th class="center">NAMA SEKOLAH / TEMPAT</th>
                            <th class="center">JURUSAN</th>
                            <th class="center">Tahun Masuk</th>
                            <th class="center">Tahun Keluar</th>
                            <th class="center">Tahun Lulus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dt = $this->m_upload_berkas->getRiwayatPendidikan($row->HeaderID);
                        foreach ($dt as $key) {
                            # code...

                        ?>
                        <tr>
                            <td class="center">
                                <?php echo $key->Tingkat; ?>
                            </td>
                            <td class="center">
                                <?php echo $key->Nama; ?>
                            </td>
                            <td class="center">
                                <?php echo $key->Jurusan; ?>
                            </td>
                            <td class="center"><?php echo $key->TahunMasuk; ?></td>
                            <td class="center"><?php echo $key->TahunKeluar; ?></td>
                            <td class="center"><?php echo $key->Lulus; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table> -->
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
                                    <?php echo $row->Pendidikan; ?>
                                </td>
                                <td>
                                    <?php echo $row->Jurusan; ?>
                                </td>
                                <td>
                                    <?php echo $row->Universitas; ?>
                                </td>
                                <td>
                                    <?php echo $row->IPK; ?>
                                </td>
                                <td><?php echo $row->TahunMasuk; ?></td>
                                <td><?php echo $row->TahunLulus; ?></td>
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
<!-- Modal Close Tenaker -->
<div class="modal fade" id="viewModalClose" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Close Data Tenaker, <?php echo $sapa . ucwords(strtolower($row->Nama)); ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="<?php echo site_url('monitor/closeTenaker'); ?>" role="form" method="post" class="form-horizontal">
                            <input type="hidden" id="txtInputHeaderID" name="txtHeaderID" value="<?php echo $row->HeaderID; ?>">
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
<script>
    $(document).ready(function() {
        $("#btnCloseTenaker").on("click", function() {
            $("#viewModalClose").modal("show");
        });

        $("#photo").on("click", ".changePhoto", function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?php echo site_url('user_profil/photo'); ?>",
                type: "POST",
                data: "kode=" + id,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#formUpload").html(msg);
                }
            });
            $("#viewChagePhoto").modal("show");
        });
    });
</script>