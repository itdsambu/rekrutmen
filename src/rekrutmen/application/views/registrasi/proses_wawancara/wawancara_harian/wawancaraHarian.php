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
$att = array('class' => 'form-horizontal', 'role' => 'form', 'name' => 'doWawancara');
if ($_getMP == 1) {
    $att = array('class' => 'form-horizontal', 'role' => 'form', 'name' => 'doWawancara', 'onSubmit' => 'return cekSubmit();');
}
echo form_open('wawancaraProses/simpanWawancaraHarian', $att);
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
                    <td><?php echo $row->Nama; ?><input name="txtDetailID" type="hidden" value="<?php echo $row->TransID; ?>"></td>
                    <td><?php echo $row->DeptAbbr; ?><input name="txtDept" id="txtDept" type="hidden" value="<?php echo $row->DeptAbbr; ?>"></td>
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
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center" rowspan="3" style="width: 10px">NO</th>
                <th class="text-center" rowspan="3">Penilaian</th>
                <th class="text-center" colspan="10">Nilai</th>
            </tr>
            <tr>
                <th class="text-center" colspan="5">Jelek</th>
                <th class="text-center" colspan="5">Baik</th>
            </tr>
            <tr>
                <th class="text-center">01</th>
                <th class="text-center">02</th>
                <th class="text-center">03</th>
                <th class="text-center">04</th>
                <th class="text-center">05</th>
                <th class="text-center">06</th>
                <th class="text-center">07</th>
                <th class="text-center">08</th>
                <th class="text-center">09</th>
                <th class="text-center">10</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $no1 = 1;
            $no2 = 1;
            $no3 = 1;
            $no4 = 1;
            $no5 = 1;
            $no6 = 1;
            $no7 = 1;
            $no8 = 1;
            $no9 = 1;
            $no10 = 1;
            $no21 = 1;
            $no22 = 1;
            $no23 = 1;
            $no24 = 1;
            $no25 = 1;
            $no26 = 1;
            $no27 = 1;
            $no28 = 1;
            $no29 = 1;
            $no210 = 1;
            foreach ($_getKualifikasi as $rowNilai) :
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $rowNilai->Uraian; ?><input class="form-control" type="hidden" name="txtItem" value="<?php echo $rowNilai->Item; ?>" /></td>
                    <td class="text-center">
                        <label class="pos-rel">
                            <input id="txtNilai<?php echo $no21++; ?>" name="txtNilai<?php echo $no1++; ?>" type="radio" class="ace" value="10" onclick="return changeVal()">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td class="text-center">
                        <label class="pos-rel">
                            <input id="txtNilai<?php echo $no22++; ?>" name="txtNilai<?php echo $no2++; ?>" type="radio" class="ace" value="20" onclick="return changeVal()">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td class="text-center">
                        <label class="pos-rel">
                            <input id="txtNilai<?php echo $no23++; ?>" name="txtNilai<?php echo $no3++; ?>" type="radio" class="ace" value="30" onclick="return changeVal()">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td class="text-center">
                        <label class="pos-rel">
                            <input id="txtNilai<?php echo $no24++; ?>" name="txtNilai<?php echo $no4++; ?>" type="radio" class="ace" value="40" onclick="return changeVal()">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td class="text-center">
                        <label class="pos-rel">
                            <input id="txtNilai<?php echo $no25++; ?>" name="txtNilai<?php echo $no5++; ?>" type="radio" class="ace" value="50" onclick="return changeVal()">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td class="text-center">
                        <label class="pos-rel">
                            <input id="txtNilai<?php echo $no26++; ?>" name="txtNilai<?php echo $no6++; ?>" type="radio" class="ace" value="60" onclick="return changeVal()">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td class="text-center">
                        <label class="pos-rel">
                            <input id="txtNilai<?php echo $no27++; ?>" name="txtNilai<?php echo $no7++; ?>" type="radio" class="ace" value="70" onclick="return changeVal()">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td class="text-center">
                        <label class="pos-rel">
                            <input id="txtNilai<?php echo $no28++; ?>" name="txtNilai<?php echo $no8++; ?>" type="radio" class="ace" value="80" onclick="return changeVal()">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td class="text-center">
                        <label class="pos-rel">
                            <input id="txtNilai<?php echo $no29++; ?>" name="txtNilai<?php echo $no9++; ?>" type="radio" class="ace" value="90" onclick="return changeVal()">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td class="text-center">
                        <label class="pos-rel">
                            <input id="txtNilai<?php echo $no210++; ?>" name="txtNilai<?php echo $no10++; ?>" type="radio" class="ace" value="100" onclick="return changeVal()">
                            <span class="lbl"></span>
                        </label>
                    </td>
                </tr>
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
<?php
if ($_getMP == 1) {
    $display    = "block";
} else {
    $display    = "none";
}
?>

<?php //if ($this->session->userdata('userid') == 'riyan' || $this->session->userdata('userid') == 'KIKI') { 
?>
<!-- <div class="well well-sm" style="display: <?php echo $display; ?>;"> -->
<div class="well well-sm">
    <h5 class="row header smaller lighter blue">
        <span class="col-sm-8">
            <i class="ace-icon fa fa-gavel"></i>
            Penempatan Kerja
        </span>
    </h5>
    <div id="mpOnly" class="form-group">
        <label for="txtJenisKerja" class="col-sm-2 no-padding-right text-right">Jenis Pekerjaan &nbsp; </label>
        <select name="txtJenisKerja" id="txtJenisKerja" class="col-sm-9" required disabled>
            <option value="">-- Pilih</option>
            <!-- <option value="HARIAN">HARIAN</option> -->
            <?php foreach ($_getHarian as $rowHarian) : ?>
                <!-- <option value="<?php echo $rowHarian->Pekerjaan; ?>"><?php echo $rowHarian->Pekerjaan; ?></option> -->
            <?php endforeach; ?>

            <?php foreach ($_getPekerjaan as $rowKer) : ?>
                <option value="<?= $rowKer->Pekerjaan; ?>"><?php echo $rowKer->Pekerjaan; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div id="mpOnly" class="form-group">
        <label for="txtSubKerja" class="col-sm-2 no-padding-right text-right">Sub Pekerjaan &nbsp; </label>
        <select name="txtSubKerja" id="txtSubKerja" class="col-sm-9" required disabled>
            <option value="">-- Pilih</option>
            <?php foreach ($_getSubPekerjaan as $rowSubPekerjaan) : ?>
                <option value="<?php echo $rowSubPekerjaan->SubPekerjaan; ?>"><?php echo $rowSubPekerjaan->SubPekerjaan; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div id="mpOnly" class="form-group">
        <label for="txtJabatan" class="col-sm-2 no-padding-right text-right">Jabatan &nbsp; </label>
        <select name="txtJabatan" id="txtJabatan" class="col-sm-9" required disabled>
            <option value="">-- Pilih</option>
            <?php foreach ($_getJabatan as $row) : ?>
                <option value="<?php echo $row->IDJabatan . ',' . $row->Jabatan ?>" data-id-jabatan="<?= $row->IDJabatan ?>"><?php echo $row->Jabatan; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div id="mpOnly" class="form-group">
        <label for="txtSubJabatan" class="col-sm-2 no-padding-right text-right">Sub Jabatan &nbsp; </label>
        <select name="txtSubJabatan" id="txtSubJabatan" class="col-sm-9" required disabled>
            <option value="">-- Pilih</option>
        </select>
    </div>
    <div id="mpOnly" class="form-group">
        <label for="txtLiburMingguan" class="col-sm-2 no-padding-right text-right">Libur Mingguan &nbsp; </label>
        <select name="txtLiburMingguan" id="txtLiburMingguan" class="col-sm-9" required disabled>
            <option value="">-- Pilih</option>
            <?php foreach ($_getLiburMingguan as $rowgetLiburMingguan) : ?>
                <option value="<?php echo $rowgetLiburMingguan->NamaLiburMingguan; ?>"><?php echo $rowgetLiburMingguan->NamaLiburMingguan; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div id="mpOnly" class="form-group">
        <label for="txtKepala" class="col-sm-2 no-padding-right text-right">Shift &nbsp; </label>
        <select id="txtShift" name="txtShift" class="col-sm-9" required disabled>
            <option value="">-- Pilih</option>
            <option value="A">Shift A</option>
            <option value="B">Shift B</option>
            <option value="C">Shift C</option>
            <option value="Z">Non Shift</option>
        </select>
    </div>
    <!-- <div id="mpOnly" class="form-group">
            <label for="txtKepala" class="col-sm-2 no-padding-right text-right">Kepala Shift &nbsp; </label>
            <input id="txtKepala" name="txtKepala" type="text" class="col-sm-9">
        </div> -->
</div>
<?php //} 
?>

<div class="form-group">
    <label>Catatan</label>
    <textarea name="txtCatatan" class="form-control"></textarea>
</div>
<div class="form-group">
    <input class="btn btn-sm btn-primary" type="submit" value="Simpan" name="btnSimpan" />
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
        // var val1 = parseInt(document.querySelector('input[name="txtNilai1"]:checked').value || 0);
        // var val2 = parseInt(document.querySelector('input[name="txtNilai2"]:checked').value || 0);
        // var val3 = parseInt(document.querySelector('input[name="txtNilai3"]:checked').value || 0);
        // var val4 = parseInt(document.querySelector('input[name="txtNilai4"]:checked').value || 0);
        // var val5 = parseInt(document.querySelector('input[name="txtNilai5"]:checked').value || 0);
        // var val6 = parseInt(document.querySelector('input[name="txtNilai6"]:checked').value || 0);

        var val1 = getCheckedValue('txtNilai1');
        var val2 = getCheckedValue('txtNilai2');
        var val3 = getCheckedValue('txtNilai3');
        var val4 = getCheckedValue('txtNilai4');
        var val5 = getCheckedValue('txtNilai5');
        var val6 = getCheckedValue('txtNilai6');
        console.log({
            val1,
            val2,
            val3,
            val4,
            val5,
            val6,
        });


        var total = val1 + val2 + val3 + val4 + val5 + val6;
        var rata = total / 6;
        var grade = "";
        if (rata >= 60) {
            grade = "Lulus";
            //membuat pilihan menjadi bisa di klik saat kondisi lulus
            $('#txtJenisKerja').prop('disabled', false)
            $('#txtSubKerja').prop('disabled', false)
            $('#txtJabatan').prop('disabled', false)
            $('#txtSubJabatan').prop('disabled', false)
            $('#txtLiburMingguan').prop('disabled', false)
            $('#txtShift').prop('disabled', false)
        } else {
            grade = "Gagal";
            //menonaktifkan required agar bisa di simpan saat kondisi gagal
            $('#txtSubKerja').prop('required', false)
            $('#txtLiburMingguan').prop('required', false)
            $('#txtShift').prop('required', false)
            //membuat pilihan menjadi tidak bisa di klik saat kondisi gagal
            $('#txtJenisKerja').prop('disabled', true)
            $('#txtSubKerja').prop('disabled', true)
            $('#txtJabatan').prop('disabled', true)
            $('#txtSubJabatan').prop('disabled', true)
            $('#txtLiburMingguan').prop('disabled', true)
            $('#txtShift').prop('disabled', true)
        }
        document.getElementById('txtTotal').value = total;
        document.getElementById('txtRata').value = Math.round(rata * 100) / 100;
        document.getElementById('txtGrade').value = grade;
    }

    function getCheckedValue(name) {
        let el = document.querySelector(`input[name="${name}"]:checked`);
        return el ? parseInt(el.value) : 0;
    }

    var val1 = getCheckedValue('txtNilai1');
    var val2 = getCheckedValue('txtNilai2');
    var val3 = getCheckedValue('txtNilai3');
    var val4 = getCheckedValue('txtNilai4');
    var val5 = getCheckedValue('txtNilai5');
    var val6 = getCheckedValue('txtNilai6');


    function cekSubmit() {
        // alert(123)
        var a = document.forms["doWawancara"]["txtJenisKerja"].value;
        var b = document.forms["doWawancara"]["txtShift"].value;
        var c = document.forms["doWawancara"]["txtKepala"].value;
        if (a == null || a == "") {
            alert("Pilih Jenis Pekerjaan");
            return false;
        } else if (b == null || b == "") {
            alert("Pilih Shift");
            return false;
        } else if (c == null || c == "") {
            alert("Input Kepala Shift");
            return false;
        }
        return false;
        return true;
    }

    $(document).on('change', '#txtJabatan', function() {
        let q = $(this);
        let idJabatan = $(this).find(':selected').data('id-jabatan');
        let jabatanName = $(this).find(':selected').val();
        let dept = $('#txtDept').val()
        console.log('id jabatan :', idJabatan);
        console.log(dept);
        if (dept != '' && idJabatan != '') {
            $.ajax({
                url: "<?php echo site_url('WawancaraProses/getSubJabatan'); ?>",
                method: "POST",
                data: {
                    dept: dept,
                    idJabatan: idJabatan,
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.status == 200) {
                        $('#txtSubJabatan').html(data.data)
                    } else {
                        alert(`Sub Jabatan Tidak Ditemukan Untuk jabatan ${jabatanName} dengan departemen ${dept} `)
                        q.val('')
                        $('#txtSubJabatan').html('<option value="">-- Pilih</option>')
                    }

                }
            })

        }


    })
</script>
<?php //if ($this->session->userdata('userid') == 'riyan' || $this->session->userdata('userid') == 'KIKI') { 
?>
<script>
    $("form").validate({
        submitHandler: function(form, event) {
            // event.preventDefault();
            Swal.fire({
                title: 'Simpan data ?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Simpan'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        }
    });
</script>
<?php //} 
?>