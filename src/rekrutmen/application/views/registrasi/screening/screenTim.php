<?php if ($isDiv == 0) { ?>

    <h4 class="row header smaller lighter orange">
        <span class="col-sm-8">
            <i class="ace-icon fa fa-files-o"></i>
            Screening terhadap <strong><?php foreach ($datatk as $set) {
                                            echo ucwords(strtolower($set->Nama));
                                        } ?></strong>
        </span><!-- /.col -->
    </h4>
    <?php
    $att = array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'form-screening');
    echo form_open('screeningByTim/simpan', $att);
    ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2">Dept</th>
                    <th rowspan="2">Screening by</th>
                    <th class="text-center" colspan="2">Kenal?</th>
                    <th class="text-center" colspan="2">Pernah Kerja</th>
                    <th class="text-center" colspan="2">Direcomen</th>
                    <th class="text-center" colspan="2">Jeda?</th>
                    <th rowspan="2">Keterangan</th>
                </tr>
                <tr>
                    <th class="text-center">Ya</th>
                    <th class="text-center">Tidak</th>
                    <th class="text-center">Ya</th>
                    <th class="text-center">Tidak</th>
                    <th class="text-center">Ya</th>
                    <th class="text-center">Tidak</th>
                    <th class="text-center">Ya</th>
                    <th class="text-center">Tidak</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 50px"><?php echo $this->session->userdata('dept'); ?>
                        <input name="txtDept" type="hidden" value="<?php echo $this->session->userdata('dept'); ?>" readonly="">
                    </td>
                    <td><?php echo $this->session->userdata('username'); ?>
                        <input name="txtHeaderID" type="hidden" value="<?php foreach ($datatk as $set) {
                                                                            echo $set->HeaderID;
                                                                        } ?>" readonly="">
                        <input name="txtName" type="hidden" value="<?php echo $this->session->userdata('username'); ?>" readonly="">
                    </td>
                    <td class="text-center" style="width: 50px">
                        <label class="pos-rel">
                            <input name="txtKenal" type="radio" class="ace" value="1" required="">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td class="text-center" style="width: 50px">
                        <label class="pos-rel">
                            <input name="txtKenal" type="radio" class="ace" value="0">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td class="text-center" style="width: 50px">
                        <label class="pos-rel">
                            <input name="txtKerja" type="radio" class="ace" value="1" required="">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td class="text-center" style="width: 50px">
                        <label class="pos-rel">
                            <input name="txtKerja" type="radio" class="ace" value="0">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td class="text-center" style="width: 50px">
                        <label class="pos-rel">
                            <input name="txtRekomen" type="radio" class="ace" value="1" required="">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td class="text-center" style="width: 50px">
                        <label class="pos-rel">
                            <input name="txtRekomen" type="radio" class="ace" value="0">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td class="text-center" style="width: 50px">
                        <label class="pos-rel">
                            <input name="txtJeda" type="radio" class="ace" value="1" required="">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td class="text-center" style="width: 50px">
                        <label class="pos-rel">
                            <input name="txtJeda" type="radio" class="ace" value="0">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td class="col-sm-3">
                        <textarea id="inputKeterangan" name="txtKeterangan" class="form-control" required=""></textarea>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="form-group">
        <input id="btnSubmitScreening" class="btn btn-sm btn-primary" type="submit" value="Simpan" name="btnSimpan" />
    </div>
    </form>
<?php } ?>
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
                        echo $sapa . ucwords(strtolower($row->Nama)); ?>&nbsp;
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
                                            No. KK : <?php echo $row->No_KK; ?>
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
                                            if (isset($row->AccountFacebook)) {
                                            ?>
                                                <i class="ace-icon fa fa-facebook-square"></i><a href="http://facebook.com/<?php echo $row->AccountFacebook; ?>" target="_blank">Facebook</a>
                                            <?php } elseif (isset($row->AccountTwitter)) { ?>
                                                <i class="ace-icon fa fa-twitter-square"></i><a href="http://twitter.com/<?php echo $row->AccountTwitter; ?>" target="_blank">Twitter</a>
                                            <?php } elseif (isset($row->Account_email)) { ?>
                                                <i class="ace-icon fa fa-envelope"><?= $row->Account_email ?></i>
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
                                Nama Ahli Waris : <?php echo $row->AhliWaris_Nama; ?>
                            </li>
                        </ul>
                        <ul class="list-unstyled spaced">
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Jenis Kelamin Ahli Waris : <?php echo $row->AhliWaris_Jekel; ?>
                            </li>
                        </ul>
                        <ul class="list-unstyled spaced">
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Alamat Ahli Waris : <?php echo $row->AhliWaris_Alamat; ?>
                            </li>
                        </ul>
                        <ul class="list-unstyled spaced">
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Hubungan Ahli Waris : <?php echo $row->AhliWaris_Hubungan; ?>
                            </li>
                        </ul>
                        <ul class="list-unstyled spaced">
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                No HP. Ahli Waris : <?php echo $row->AhliWaris_NoHP; ?>
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
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Jenis Vaksin : <?php echo $row->JenisVaksin; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Vaksin 1: <?php echo $row->TanggalVaksin; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Vaksin 2: <?php echo $row->TanggalVaksin2; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Vaksin 3: <?php echo $row->TanggalVaksin3; ?>
                            </li>
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
    <?php if ($isDiv == 1) { ?>
        <a class="btn btn-primary btn-block" href="<?php echo 'AppDiv?headerid=' . $row->HeaderID ?>"><i class="fa fa-check"></i>APPROVE DIVISI</a>
    <?php } else if ($isDiv == 2) { ?>
        <form action="<?= base_url('screeningByTim/AppP2K3') ?>" method="post">
            <input type="hidden" name="P2K3HeaderID" id="HeaderID" value="<?= $row->HeaderID ?>" readonly>
            <textarea name="AppP2K3Catatan" id="AppP2K3Catatan" placeholder="Catatan By P2K3" class="form-control" required=""></textarea>
            <br>
            <div align="center" class="row">
                <button type="submit" class="btn btn-primary float-right btn-inline" value="btn_app" name='btnproses' onclick="return confirm('Approve?')">APPROVE P2K3</button>
            </div>
            <br>
            <div align="center" class="row">
                <button type="submit" class="btn btn-danger float-right btn-inline" value="btn_disapp" name='btnproses' onclick="return confirm('Disapprove?');">DISAPPROVE P2K3</button>
            </div>

        </form>
    <?php } else if ($isDiv == 3) { ?>
        <form action="<?= base_url('screeningByTim/AppELC') ?>" method="post">
            <input type="hidden" name="ELCHeaderID" id="HeaderID" value="<?= $row->HeaderID ?>" readonly>
            <textarea name="AppELCCatatan" id="AppELCCatatan" placeholder="Catatan By ELC" class="form-control" required=""></textarea>
            <br>
            <div align="center" class="row">
                <button type="submit" class="btn btn-primary float-right btn-inline">APPROVE ELC</button>
            </div>

        </form>
    <?php }  ?>
</div>

<script type="text/javascript">
    $('form').on('submit', function() {
        $('#btnSubmitScreening').prop('disabled', true);
    });
</script>