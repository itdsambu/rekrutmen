<h4 class="row header smaller lighter green">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-info-circle"></i>
        <?php
        foreach ($datatk as $set) :
            echo "Hasil Screening dari TEAM terhadap <strong>" . ucwords(strtolower($set->Nama)) . "</strong>";
        endforeach;
        ?>
    </span><!-- /.col -->
</h4>
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
        <strong> Informasi Calon Tenaga Kerja</strong>#
    </span><!-- /.col -->
</h4>
<?php
foreach ($datatk as $row) :
    $hdrid = $row->HeaderID;
endforeach;
$namafoto = './dataupload/foto/' . $hdrid . '.jpg';
?>

<div class="row">
    <?php
    foreach ($datatk as $row) :
    ?>
        <div class="col-sm-12">
            <div class="widget-box transparent">
                <div class="widget-header widget-header-large">
                    <h3 class="widget-title grey lighter">
                        <i class="ace-icon fa fa-users green"></i>
                        <?php
                        if ($row->Jenis_Kelamin == "M" || $row->Jenis_Kelamin == "LAKI-LAKI") {
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
                                            Perusahaan : <?php echo $row->CVNama; ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right blue"></i>
                                            Pemborong : <?php echo $row->Pemborong; ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right blue"></i>
                                            No. KTP : <?php echo $row->No_Ktp; ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right blue"></i>
                                            Alamat : <?php echo ucwords(strtolower($row->Alamat)) . " RT: " . $row->RT . " RW: " . $row->RW; ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right blue"></i>
                                            Jenis Kelamin : <?php echo $jekel; ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right blue"></i>
                                            Tempat/Tanggal Lahir : <?php echo ucwords(strtolower($row->Tempat_Lahir)) . ' / ' . date('M, d Y',  strtotime($row->Tgl_Lahir)); ?>
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

                                                <i class="ace-icon fa fa-envelope bigger-120"></i><a href="mailto<?php echo $row->Account_email; ?>" target="_blank">Email</a>
                                            <?php } else {
                                                echo 'Tidak Ada';
                                            } ?>
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
                                            Status : <?php echo ucwords(strtolower($row->Status_Personal)); ?>
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
                                                                if ($row->NamaSuamiIstri == " ") {
                                                                    echo 'Tidak Beristri/Bersuami';
                                                                } else {
                                                                    echo ucwords(strtolower($row->NamaSuamiIstri));
                                                                }
                                                                ?>
                                        </li>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right green"></i>
                                            Pekerjaan Istri/Suami : <?php
                                                                    if ($row->PekerjaanSuamiIstri == " ") {
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
                                Daerah Asal : <?php echo $row->Daerah_Asal; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Bahasa Daerah : <?php echo $row->BahasaDaerah; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Suku : <?php echo $row->Suku; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Agama : <?php echo $row->Agama; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Hobby : <?php echo $row->Hobby; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Kegiatan Extra : <?php echo $row->KegiatanEkstra; ?>
                            </li>
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

                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-unstyled spaced">
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