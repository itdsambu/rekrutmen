<h4 class="row header smaller lighter orange">
    <span class="col-sm-8">
        <i class="ace-icon fa fa-files-o"></i>
        Wawancara terhadap <strong><?php foreach ($datatk as $set) {
                                        echo ucwords(strtolower($set->Nama));
                                    } ?></strong>,
        <?php foreach ($datatk as $set) {
            if ($set->WawancaraKe == NULL) {
                echo "yang Pertama";
            } elseif ($set->WawancaraKe == 1) {
                echo "yang Kedua";
            } elseif ($set->WawancaraKe == 2) {
                echo "yang Kedua";
            }
        } ?>
    </span><!-- /.col -->
</h4>
<?php
$att = array('class' => 'form-horizontal', 'role' => 'form');
echo form_open('wawancaraProses/simpanWawancaraKaryawan', $att);
?>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Dept Tujuan</th>
                <th>Jenis Kelamin</th>
                <th>Pendidikan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datatenaker as $row) : ?>
                <tr>
                    <td><?php echo $row->HeaderID; ?><input name="HeaderID" type="hidden" value="<?php echo $row->HeaderID; ?>"></td>
                    <td><?php echo $row->Nama; ?></td>
                    <td><?php echo $row->DeptAbbr; ?><input name="txtDept" type="hidden" value="<?php echo $row->DeptAbbr; ?>"></td>
                    <td><?php
                        if ($row->Jenis_Kelamin == "M" || $row->Jenis_Kelamin == "LAKI-LAKI") {
                            echo 'Laki-laki';
                        } elseif ($row->Jenis_Kelamin == "F" || $row->Jenis_Kelamin == "PEREMPUAN") {
                            echo 'Perempuan';
                        } else {
                            echo 'Gx Jelas';
                        }
                        ?></td>
                    <td><?php echo $row->Pendidikan; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="table-responsive">
    <table class=" table table-bordered">
        <thead>
            <tr>
                <th colspan="5" class="text-center">Range Nilai</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>A = Sangat Baik (90-100)</td>
                <td>B = Baik (75-89)</td>
                <td>C = Cukup (60-74)</td>
                <td>D = Kurang (50-59)</td>
                <td>E = Sangat Kurang (00-49)</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center" style="width: 10px">NO</th>
                <th class="text-center col-3">Penilaian</th>
                <th class="text-center col-3">Nilai (10-100)</th>
                <th class="text-center col-3">Catatan</th>
                <th class="text-center col-3">Grade</th>
                <th class="text-center col-3">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $no1 = 1;
            $no11 = 1;
            $no2 = 1;
            $no3 = 1;
            $no21 = 1;
            $no22 = 1;
            $no33 = 1;
            foreach ($_getKualifikasi as $rowNilai) :
            ?>
                <?php
                if ($rowNilai->Head == 1) {
                ?>
                    <tr>
                        <td colspan="6"><?php echo $rowNilai->Uraian; ?>
                            <input name="txtVal<?php echo $no21++; ?>" id="txtVal<?php echo $no22++; ?>" type="number" class="pull-right" readonly="">
                        </td>
                    </tr>
                <?php
                } else {
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $rowNilai->Uraian; ?></td>
                        <td class="text-center">
                            <label class="pos-rel">
                                <input name="txtNilai<?php echo $no1++; ?>" id="txtNilai<?php echo $no11++; ?>" type="number" class="form-control" onChange="changeVal(this.value)">
                                <span class="lbl"></span>
                            </label>
                        </td>
                        <td>
                            <label class="pos-rel">
                                <input name="txtPenjelasan<?php echo $no33++; ?>" type="text" class="form-control">
                                <span class="lbl"></span>
                            </label>
                        </td>
                        <td class="text-center">
                            <label class="pos-rel">
                                <input id="txtGrade<?php echo $no2++; ?>" type="text" class="form-control" readonly="">
                                <span class="lbl"></span>
                            </label>
                        </td>
                        <td class="text-center">
                            <label class="pos-rel">
                                <input id="txtKet<?php echo $no3++; ?>" type="text" class="form-control" readonly="">
                                <span class="lbl"></span>
                            </label>
                        </td>
                    </tr>
                <?php } ?>
            <?php
            endforeach;
            ?>
        </tbody>
    </table>
</div>
<div class="well well-sm">
    <h5 class="row header smaller lighter blue">
        <span class="col-sm-8">
            <i class="ace-icon fa fa-area-chart"></i>
            Hasil Penilaian
        </span>
    </h5>
    <div id="hasil" class="form-group center">
        <label for="txtTotal">Total</label>
        <input id="txtTotal" name="txtTotal" type="text" class="" readonly="">
        <label for="txtRata">Rata-rata</label>
        <input id="txtRata" name="txtRata" type="text" class="" readonly="">
        <label for="txtGrade">Kesimpulan</label>
        <input id="txtGrade" name="txtGrade" type="text" class="" readonly="">
    </div>
</div>

<!-- tes -->
<div class="well well-sm">
    <h5 class="row header smaller lighter blue">
        <span class="col-sm-8">
            <i class="ace-icon fa fa-gavel"></i>
            Jabatan
        </span>
    </h5>
    <div id="mpOnly" class="form-group">
        <label for="txtJabatan" class="col-sm-2 no-padding-right text-right">Jabatan &nbsp; </label>
        <select name="txtJabatan" id="txtJabatan" class="col-sm-9" required>
            <option value="">-- Pilih --</option>
            <!-- <option value="HARIAN">HARIAN</option> -->
            <?php foreach ($_getJabatan as $jbt) : ?>
                <option value="<?= $jbt->JabatanID ?>,<?php echo $jbt->JabatanName; ?>"><?php echo $jbt->JabatanName; ?> ( <?= $jbt->JabatanID ?> )</option>
            <?php endforeach; ?>


        </select>
    </div>

    <div id="mpOnly" class="form-group">
        <label for="txtSubJabatan" class="col-sm-2 no-padding-right text-right">Sub Jabatan &nbsp; </label>
        <select name="txtSubJabatan" id="txtSubJabatan" class="col-sm-9" required>
            <option value="">-- Pilih --</option>
        </select>
    </div>



</div>

<div class="form-group">
    <label>Catatan</label>
    <textarea id="txtCatatan" name="txtCatatan" class="form-control" onclick=""></textarea>
</div>
<div class="form-group">
    <input class="btn btn-sm btn-primary" type="submit" value="Simpan" id="btnSimpan" name="btnSimpan" disabled />
</div>
</form>


<?php
foreach ($datatk as $row) :
    $hdrid = $row->HeaderID;
endforeach;
$namafoto = './dataupload/foto/' . $hdrid . '.jpg';
?>
<h4 class="row header smaller lighter red">
    <span class="col-sm-8">
        <i class="ace-icon fa fa-bell-o"></i>
        <strong> Informasi Calon Tenaga Kerja</strong>
    </span><!-- /.col -->
    <span class="col-sm-4 text-right">
        <a href="<?php echo site_url('wawancaraProses/printData/' . $hdrid); ?>" class="btn btn-xs btn-success" target="_blank"><i class="ace-icon fa fa-print"></i> Print</a>
    </span>
</h4>
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
                                            if ($row->AccountFacebook != " ") {
                                            ?>
                                                <i class="ace-icon fa fa-facebook-square"></i><a href=="http://facebook.com/<?php echo $row->AccountFacebook; ?>" target="_blank">Facebook</a>
                                            <?php } elseif ($row->AccountTwitter != " ") { ?>
                                                <i class="ace-icon fa fa-twitter-square"></i><a href=="http://facebook.com/<?php echo $row->AccountTwitter; ?>" target="_blank">Facebook</a>
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
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Jenis Vaksin : <?php echo $row->JenisVaksin; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Vaksin 1 : <?php echo $row->TanggalVaksin; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Vaksin 2 : <?php echo $row->TanggalVaksin2; ?>
                            </li>
                            <li>
                                <i class="ace-icon fa fa-caret-right purple"></i>
                                Vaksin 3 : <?php echo $row->TanggalVaksin3; ?>
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
<script>
    function changeVal(val) {
        var val1 = parseInt(document.getElementById('txtNilai1').value);
        if (val1 >= 90) {
            document.getElementById('txtGrade1').value = "A";
            document.getElementById('txtKet1').value = "Sangat Baik";
        } else if (val1 >= 75) {
            document.getElementById('txtGrade1').value = "B";
            document.getElementById('txtKet1').value = "Baik";
        } else if (val1 >= 60) {
            document.getElementById('txtGrade1').value = "C";
            document.getElementById('txtKet1').value = "Cukup";
        } else if (val1 >= 50) {
            document.getElementById('txtGrade1').value = "D";
            document.getElementById('txtKet1').value = "Kurang";
        } else if (val1 <= 49) {
            document.getElementById('txtGrade1').value = "E";
            document.getElementById('txtKet1').value = "Sangat Kurang";
        } else if (val1 === "") {
            document.getElementById('txtGrade1').value = "";
            document.getElementById('txtKet1').value = "";
        }

        var val2 = parseInt(document.getElementById('txtNilai2').value);
        if (val2 >= 90) {
            document.getElementById('txtGrade2').value = "A";
            document.getElementById('txtKet2').value = "Sangat Baik";
        } else if (val2 >= 75) {
            document.getElementById('txtGrade2').value = "B";
            document.getElementById('txtKet2').value = "Baik";
        } else if (val2 >= 60) {
            document.getElementById('txtGrade2').value = "C";
            document.getElementById('txtKet2').value = "Cukup";
        } else if (val2 >= 50) {
            document.getElementById('txtGrade2').value = "D";
            document.getElementById('txtKet2').value = "Kurang";
        } else if (val2 <= 49) {
            document.getElementById('txtGrade2').value = "E";
            document.getElementById('txtKet2').value = "Sangat Kurang";
        } else if (val2 === "") {
            document.getElementById('txtGrade2').value = "";
            document.getElementById('txtKet2').value = "";
        }

        var val3 = parseInt(document.getElementById('txtNilai3').value);
        if (val3 >= 90) {
            document.getElementById('txtGrade3').value = "A";
            document.getElementById('txtKet3').value = "Sangat Baik";
        } else if (val3 >= 75) {
            document.getElementById('txtGrade3').value = "B";
            document.getElementById('txtKet3').value = "Baik";
        } else if (val3 >= 60) {
            document.getElementById('txtGrade3').value = "C";
            document.getElementById('txtKet3').value = "Cukup";
        } else if (val3 >= 50) {
            document.getElementById('txtGrade3').value = "D";
            document.getElementById('txtKet3').value = "Kurang";
        } else if (val3 <= 49) {
            document.getElementById('txtGrade3').value = "E";
            document.getElementById('txtKet3').value = "Sangat Kurang";
        } else if (val3 === "") {
            document.getElementById('txtGrade3').value = "";
            document.getElementById('txtKet3').value = "";
        }

        var val4 = parseInt(document.getElementById('txtNilai4').value);
        if (val4 >= 90) {
            document.getElementById('txtGrade4').value = "A";
            document.getElementById('txtKet4').value = "Sangat Baik";
        } else if (val4 >= 75) {
            document.getElementById('txtGrade4').value = "B";
            document.getElementById('txtKet4').value = "Baik";
        } else if (val4 >= 60) {
            document.getElementById('txtGrade4').value = "C";
            document.getElementById('txtKet4').value = "Cukup";
        } else if (val4 >= 50) {
            document.getElementById('txtGrade4').value = "D";
            document.getElementById('txtKet4').value = "Kurang";
        } else if (val4 <= 49) {
            document.getElementById('txtGrade4').value = "E";
            document.getElementById('txtKet4').value = "Sangat Kurang";
        } else if (val4 === "") {
            document.getElementById('txtGrade4').value = "";
            document.getElementById('txtKet4').value = "";
        }

        var val5 = parseInt(document.getElementById('txtNilai5').value);
        if (val5 >= 90) {
            document.getElementById('txtGrade5').value = "A";
            document.getElementById('txtKet5').value = "Sangat Baik";
        } else if (val5 >= 75) {
            document.getElementById('txtGrade5').value = "B";
            document.getElementById('txtKet5').value = "Baik";
        } else if (val5 >= 60) {
            document.getElementById('txtGrade5').value = "C";
            document.getElementById('txtKet5').value = "Cukup";
        } else if (val5 >= 50) {
            document.getElementById('txtGrade5').value = "D";
            document.getElementById('txtKet5').value = "Kurang";
        } else if (val5 <= 49) {
            document.getElementById('txtGrade5').value = "E";
            document.getElementById('txtKet5').value = "Sangat Kurang";
        } else if (val5 === "") {
            document.getElementById('txtGrade5').value = "";
            document.getElementById('txtKet5').value = "";
        }

        var val6 = parseInt(document.getElementById('txtNilai6').value);
        if (val6 >= 90) {
            document.getElementById('txtGrade6').value = "A";
            document.getElementById('txtKet6').value = "Sangat Baik";
        } else if (val6 >= 75) {
            document.getElementById('txtGrade6').value = "B";
            document.getElementById('txtKet6').value = "Baik";
        } else if (val6 >= 60) {
            document.getElementById('txtGrade6').value = "C";
            document.getElementById('txtKet6').value = "Cukup";
        } else if (val6 >= 50) {
            document.getElementById('txtGrade6').value = "D";
            document.getElementById('txtKet6').value = "Kurang";
        } else if (val6 <= 49) {
            document.getElementById('txtGrade6').value = "E";
            document.getElementById('txtKet6').value = "Sangat Kurang";
        } else if (val6 === "") {
            document.getElementById('txtGrade6').value = "";
            document.getElementById('txtKet6').value = "";
        }

        var val7 = parseInt(document.getElementById('txtNilai7').value);
        if (val7 >= 90) {
            document.getElementById('txtGrade7').value = "A";
            document.getElementById('txtKet7').value = "Sangat Baik";
        } else if (val7 >= 75) {
            document.getElementById('txtGrade7').value = "B";
            document.getElementById('txtKet7').value = "Baik";
        } else if (val7 >= 60) {
            document.getElementById('txtGrade7').value = "C";
            document.getElementById('txtKet7').value = "Cukup";
        } else if (val7 >= 50) {
            document.getElementById('txtGrade7').value = "D";
            document.getElementById('txtKet7').value = "Kurang";
        } else if (val7 <= 49) {
            document.getElementById('txtGrade7').value = "E";
            document.getElementById('txtKet7').value = "Sangat Kurang";
        } else if (val7 === "") {
            document.getElementById('txtGrade7').value = "";
            document.getElementById('txtKet7').value = "";
        }

        var val8 = parseInt(document.getElementById('txtNilai8').value);
        if (val8 >= 90) {
            document.getElementById('txtGrade8').value = "A";
            document.getElementById('txtKet8').value = "Sangat Baik";
        } else if (val8 >= 75) {
            document.getElementById('txtGrade8').value = "B";
            document.getElementById('txtKet8').value = "Baik";
        } else if (val8 >= 60) {
            document.getElementById('txtGrade8').value = "C";
            document.getElementById('txtKet8').value = "Cukup";
        } else if (val8 >= 50) {
            document.getElementById('txtGrade8').value = "D";
            document.getElementById('txtKet8').value = "Kurang";
        } else if (val8 <= 49) {
            document.getElementById('txtGrade8').value = "E";
            document.getElementById('txtKet8').value = "Sangat Kurang";
        } else if (val8 === "") {
            document.getElementById('txtGrade8').value = "";
            document.getElementById('txtKet8').value = "";
        }

        var val9 = parseInt(document.getElementById('txtNilai9').value);
        if (val9 >= 90) {
            document.getElementById('txtGrade9').value = "A";
            document.getElementById('txtKet9').value = "Sangat Baik";
        } else if (val9 >= 75) {
            document.getElementById('txtGrade9').value = "B";
            document.getElementById('txtKet9').value = "Baik";
        } else if (val9 >= 60) {
            document.getElementById('txtGrade9').value = "C";
            document.getElementById('txtKet9').value = "Cukup";
        } else if (val9 >= 50) {
            document.getElementById('txtGrade9').value = "D";
            document.getElementById('txtKet9').value = "Kurang";
        } else if (val9 <= 49) {
            document.getElementById('txtGrade9').value = "E";
            document.getElementById('txtKet9').value = "Sangat Kurang";
        } else if (val9 === "") {
            document.getElementById('txtGrade9').value = "";
            document.getElementById('txtKet9').value = "";
        }

        var val10 = parseInt(document.getElementById('txtNilai10').value);
        if (val10 >= 90) {
            document.getElementById('txtGrade10').value = "A";
            document.getElementById('txtKet10').value = "Sangat Baik";
        } else if (val10 >= 75) {
            document.getElementById('txtGrade10').value = "B";
            document.getElementById('txtKet10').value = "Baik";
        } else if (val10 >= 60) {
            document.getElementById('txtGrade10').value = "C";
            document.getElementById('txtKet10').value = "Cukup";
        } else if (val10 >= 50) {
            document.getElementById('txtGrade10').value = "D";
            document.getElementById('txtKet10').value = "Kurang";
        } else if (val10 <= 49) {
            document.getElementById('txtGrade10').value = "E";
            document.getElementById('txtKet10').value = "Sangat Kurang";
        } else if (val10 === "") {
            document.getElementById('txtGrade10').value = "";
            document.getElementById('txtKet10').value = "";
        }

        var val11 = parseInt(document.getElementById('txtNilai11').value);
        if (val11 >= 90) {
            document.getElementById('txtGrade11').value = "A";
            document.getElementById('txtKet11').value = "Sangat Baik";
        } else if (val11 >= 75) {
            document.getElementById('txtGrade11').value = "B";
            document.getElementById('txtKet11').value = "Baik";
        } else if (val11 >= 60) {
            document.getElementById('txtGrade11').value = "C";
            document.getElementById('txtKet11').value = "Cukup";
        } else if (val11 >= 50) {
            document.getElementById('txtGrade11').value = "D";
            document.getElementById('txtKet11').value = "Kurang";
        } else if (val11 <= 49) {
            document.getElementById('txtGrade11').value = "E";
            document.getElementById('txtKet11').value = "Sangat Kurang";
        } else if (val11 === "") {
            document.getElementById('txtGrade11').value = "";
            document.getElementById('txtKet11').value = "";
        }

        var val12 = parseInt(document.getElementById('txtNilai12').value);
        if (val12 >= 90) {
            document.getElementById('txtGrade12').value = "A";
            document.getElementById('txtKet12').value = "Sangat Baik";
        } else if (val12 >= 75) {
            document.getElementById('txtGrade12').value = "B";
            document.getElementById('txtKet12').value = "Baik";
        } else if (val12 >= 60) {
            document.getElementById('txtGrade12').value = "C";
            document.getElementById('txtKet12').value = "Cukup";
        } else if (val12 >= 50) {
            document.getElementById('txtGrade12').value = "D";
            document.getElementById('txtKet12').value = "Kurang";
        } else if (val12 <= 49) {
            document.getElementById('txtGrade12').value = "E";
            document.getElementById('txtKet12').value = "Sangat Kurang";
        } else if (val12 === "") {
            document.getElementById('txtGrade12').value = "";
            document.getElementById('txtKet12').value = "";
        }

        if (val2 !== "") {
            var nilai1 = parseFloat((val1 + val2) / 2);
            document.getElementById('txtVal1').value = Math.round(nilai1 * 100) / 100;
        }

        if (val5 !== "") {
            var nilai1 = parseFloat((val3 + val4 + val5) / 3);
            document.getElementById('txtVal2').value = Math.round(nilai1 * 100) / 100;
        }

        if (val8 !== "") {
            var nilai1 = parseFloat((val6 + val7 + val8) / 3);
            document.getElementById('txtVal3').value = Math.round(nilai1 * 100) / 100;
        }

        if (val10 !== "") {
            var nilai1 = parseInt((val9 + val10) / 2);
            document.getElementById('txtVal4').value = Math.round(nilai1 * 100) / 100;
        }

        if (val12 !== "") {
            var nilai1 = parseFloat((val11 + val12) / 2);
            document.getElementById('txtVal5').value = Math.round(nilai1 * 100) / 100;
        }

        if (val12 !== "") {
            var nilai1 = parseFloat((val1 + val2) / 2);
            var nilai2 = parseFloat((val3 + val4 + val5) / 3);
            var nilai3 = parseFloat((val6 + val7 + val8) / 3);
            var nilai4 = parseInt((val9 + val10) / 2);
            var nilai5 = parseFloat((val11 + val12) / 2);

            var total = parseFloat(nilai1 + nilai2 + nilai3 + nilai4 + nilai5);
            var rata = parseFloat(total / 5);
            var grade = "";
            if (rata >= 60) {
                grade = "Lulus";
                //$("#hasil").form-group("has-success");
            } else {
                grade = "Gagal";
                //$("#hasil").form-group("has-error");
            }

            document.getElementById('txtTotal').value = Math.round(total * 100) / 100;
            document.getElementById('txtRata').value = Math.round(rata * 100) / 100;
            document.getElementById('txtGrade').value = grade;
        }


    }

    $(document).ready(function() {
        $("#txtCatatan").on("click", ".cek", function() {
            var rata = document.getElementById('txtGrade').value;

            if (rata === "Lulus") {
                $("#hasil").form - group("has-success");
            } else {
                $("#hasil").form - group("has-error");
            }

        });
    });

    $(document).on('change', '#txtJabatan', function() {
        var jabatan = $(this).val();
        let id = jabatan.split(",")[0];
        console.log(id);

        $.ajax({
            url: "<?php echo base_url(); ?>wawancaraProses/getSubJabatanPayroll",
            method: "POST",
            data: {
                jabatan: id
            },
            dataType: 'json',
            success: function(data) {
                $('#txtSubJabatan').html(data.data);
                console.log(data);

                // $('#txtGaji').val(data.Gaji);
            }
        });

    })

    $(document).on('change', '#txtSubJabatan, #txtJabatan', function() {
        var subJabatan = $('#txtSubJabatan').val();
        var txtJabatan = $('#txtJabatan').val();

        console.log({
            subJabatan: subJabatan,
            txtJabatan: txtJabatan
        });

        if (subJabatan == '' || txtJabatan == '') {
            $('#btnSimpan').prop('disabled', true);
        } else {
            $('#btnSimpan').prop('disabled', false);
        }
    })
</script>