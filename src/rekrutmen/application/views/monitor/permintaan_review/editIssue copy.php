<h4 class="row header smaller lighter blue">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-info-circle"></i>
        Approval oleh Department, Divisi, Personalia, AGM dan VGM
    </span>
</h4>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Approval</th>
                <th><i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Approved By</th>
                <th><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Approved Date</th>
                <th>Keputusan</th>
                <th>Other Information</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($getTran as $row) : ?>
                <tr>
                    <td>Department</td>
                    <td><?php echo $row->DEPTApproval; ?></td>
                    <td><?php echo $row->DEPTDate; ?></td>
                    <td>
                        <?php if ($row->DEPTStatus == 1) : ?>
                            <span class="label label-sm label-success">Disetujui</span>
                        <?php elseif ($row->DEPTStatus == 2) : ?>
                            <span class="label label-sm label-danger">Ditolak</span>
                        <?php else : ?>
                            <span class="label label-sm label-warning">Pending</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $row->DEPTRemark; ?></td>
                </tr>
                <tr>
                    <td>Divisi</td>
                    <td><?php echo $row->DIVISIApproval; ?></td>
                    <td><?php echo $row->DIVISIDate; ?></td>
                    <td>
                        <?php if ($row->DIVISIStatus == 1) : ?>
                            <span class="label label-sm label-success">Disetujui</span>
                        <?php elseif ($row->DIVISIStatus == 2) : ?>
                            <span class="label label-sm label-danger">Ditolak</span>
                        <?php else : ?>
                            <span class="label label-sm label-warning">Pending</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $row->DIVISIRemark; ?></td>
                </tr>
                <tr>
                    <td>Personalia</td>
                    <td><?php echo $row->PSNApproval; ?></td>
                    <td><?php echo $row->PSNDate; ?></td>
                    <td>
                        <?php if ($row->PSNStatus == 1) : ?>
                            <span class="label label-sm label-success">Disetujui</span>
                        <?php elseif ($row->PSNStatus == 2) : ?>
                            <span class="label label-sm label-danger">Ditolak</span>
                        <?php else : ?>
                            <span class="label label-sm label-warning">Pending</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $row->PSNRemark; ?></td>
                </tr>
                <tr>
                    <td>AGM</td>
                    <td><?php echo $row->AGMApproval; ?></td>
                    <td><?php echo $row->AGMDate; ?></td>
                    <td>
                        <?php if ($row->AGMStatus == 1) : ?>
                            <span class="label label-sm label-success">Disetujui</span>
                        <?php elseif ($row->AGMStatus == 2) : ?>
                            <span class="label label-sm label-danger">Ditolak</span>
                        <?php else : ?>
                            <span class="label label-sm label-warning">Pending</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $row->AGMRemark; ?></td>
                </tr>
                <tr>
                    <td>VGM</td>
                    <td><?php echo $row->VGMApproval; ?></td>
                    <td><?php echo $row->VGMDate; ?></td>
                    <td>
                        <?php if ($row->VGMStatus == 1) : ?>
                            <span class="label label-sm label-success">Disetujui</span>
                        <?php elseif ($row->VGMStatus == 2) : ?>
                            <span class="label label-sm label-danger">Ditolak</span>
                        <?php else : ?>
                            <span class="label label-sm label-warning">Pending</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $row->VGMRemark; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<h4 class="row header smaller lighter blue">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-info-circle"></i>
        Keterangan lainnya
    </span>
</h4>
<div class="table-responsive">
    <table class="table table-striped">
        <?php foreach ($getTran as $row) : ?>
            <?php
            if ($row->Pemborong == "PSG") {
                $disKerja = 'none';
                $disJabat = 'block';
            } else {
                $disKerja = 'block';
                $disJabat = 'none';
            }
            ?>
            <tr>
                <th>
                    ID
                </th>
                <td>
                    <?php echo "#" . $row->DetailID; ?>
                </td>
            </tr>
            <tr>
                <th class="col-md-2">
                    Pemborong
                </th>
                <td>
                    <?php echo $row->Pemborong; ?>
                </td>
            </tr>
            <tr>
                <th>
                    Departemen
                </th>
                <td>
                    <?php echo $row->DeptAbbr; ?>
                </td>
            </tr>
            <tr>
                <th>
                    Pekerjaan
                </th>
                <td>
                    <?php echo $row->Pekerjaan; ?>
                </td>
            </tr>
            <tr>
                <th>
                    Umur
                </th>
                <td>
                    <?php echo $row->Umur; ?>
                </td>
            </tr>
            <tr>
                <th>
                    Pendidikan
                </th>
                <td>
                    <?php echo $row->Pendidikan; ?>
                </td>
            </tr>
            <tr>
                <th>
                    Jurusan
                </th>
                <td>
                    <?php echo $row->Jurusan; ?>
                </td>
            </tr>
            <tr>
                <th>
                    Jenis Kelamin
                </th>
                <td>
                    <?php echo $row->JenisKelamin; ?>
                </td>
            </tr>
            <tr>
                <th>
                    Status Perkawinan
                </th>
                <td>
                    <?php echo $row->StatusPersonal; ?>
                </td>
            </tr>
            <tr>
                <th>
                    Keterangan Lainnya
                </th>
                <td>
                    <?php echo $row->IssueRemark; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<h4 class="row header smaller lighter blue">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-files-o"></i>
        Edit Issue dengan ID <strong>#<?php foreach ($getTran as $row) {
                                            echo $row->DetailID;
                                        } ?></strong>
    </span>
</h4>
<?php
$att = array('class' => 'form-horizontal', 'role' => 'form');
echo form_open('monitor/doEditIssue', $att);
foreach ($getTran as $row) :
?>
    <input name="txtID" value="<?php echo $row->DetailID; ?>" type="hidden" readonly />
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            Pilih Pemborong
        </label>
        <div class="col-sm-8">
            <select class="form-control" id="inputPemborong" name="comboPemborong">
                <option value=""> -- Pilih </option>
                <option value="PSG" <?php if ($row->Pemborong == 'PSG') {
                                        echo 'selected';
                                    } ?>> PSG </option>
                <option value="ALL PEMBORONG" <?php if ($row->Pemborong == 'ALL PEMBORONG') {
                                                    echo 'selected';
                                                } ?>> ALL PEMBORONG </option>
            </select>
        </div>
    </div>
    <script type="text/javascript">
        $("#inputPemborong").change(function() {
            var sel = $("#inputPemborong").val();

            if (sel === 'PSG') {
                document.getElementById('divPekerjaan').style.display = "none";
                document.getElementById('divJabatan').style.display = "block";
            } else {
                document.getElementById('divPekerjaan').style.display = "block";
                document.getElementById('divJabatan').style.display = "none";
            }
        });
    </script>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            Pilih Departemen
        </label>
        <div class="col-sm-8">
            <select class="form-control" id="inputDept" name="comboDept">
                <option value=""> -- Pilih </option>
                <?php foreach ($getDept as $rowDept) : ?>
                    <option value="<?php echo $rowDept->IDDept; ?>" <?php if ($rowDept->IDDept == $row->DeptID) {
                                                                        echo 'selected';
                                                                    } ?>>
                        <?php echo $rowDept->DeptAbbr; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group" id="divPekerjaan" style="display: <?php echo $disKerja; ?>;">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            Jenis Pekerjaan
        </label>
        <div id="bagian" class="col-sm-8">
            <select class="form-control" id="inputTransaksi" name="comboTansaksi">
                <option value=""> -- Pilih </option>
                <option value="1" <?php if ($row->PekerjaanID == 1) {
                                        echo 'selected';
                                    } ?>> HARIAN </option>
                <?php foreach ($getKrj as $rowKerja) : ?>
                    <?php if ($rowKerja->IDPekerjaan == $row->PekerjaanID) : ?>
                        <option value="<?php echo $rowKerja->IDPekerjaan; ?>" selected> <?php echo $rowKerja->Pekerjaan; ?> </option>
                    <?php else : ?>
                        <option value="<?php echo $rowKerja->IDPekerjaan; ?>"> <?php echo $rowKerja->Pekerjaan; ?> </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <script type="text/javascript">
        $("#inputDept").change(function() {
            var selectValues = $("#inputDept").val();
            if (selectValues === 0) {
                var msg = '<select class="form-control" id="inputTransaksi" name="comboTansaksi"><option value=""> -- Pilih </option></select>';
                $('#bagian').html(msg);
            } else {
                var dept = {
                    dept: $("#inputDept").val()
                };
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('monitor/getBagian') ?>",
                    data: dept,
                    success: function(msg) {
                        $('#bagian').html(msg);
                    }
                });
            }
        });
    </script>

    <div class="form-group" id="divJabatan" style="display: <?php echo $disJabat; ?>;">
        <label class="col-sm-3 control-label no-padding-right" for="inputJabatan">
            Pilih Jabatan
        </label>
        <div class="col-sm-8">
            <select class="form-control" id="inputJabatan" name="comboJabatan">
                <option value=""> -- Pilih </option>
                <?php foreach ($getJbtn as $rowJbtn) : ?>
                    <?php if ($rowJbtn->IDJabatan == $row->JabatanID) : ?>
                        <option value="<?php echo $rowJbtn->IDJabatan; ?>" selected=""><?php echo $rowJbtn->Jabatan; ?></option>
                    <?php else : ?>
                        <option value="<?php echo $rowJbtn->IDJabatan; ?>"><?php echo $rowJbtn->Jabatan; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Target </label>
        <div class="col-sm-9">
            <input type="number" id="inputTarget" name="txtTarget" onchange="changePermintaan()" value="<?php echo $row->TKTarget; ?>" placeholder="Input Target" class="col-xs-12 col-sm-10" required="required" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Tersedia </label>
        <div class="col-sm-9">
            <input type="number" id="inputTersedia" name="txtTersedia" onchange="changePermintaan()" value="<?php echo $row->TKSedia; ?>" placeholder="Input Karyawan yang tersedia" class="col-xs-12 col-sm-10" required="required" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Permintaan </label>
        <div class="col-sm-9">
            <input type="number" id="inputPermintaan" name="txtPermintaan" value="<?php echo $row->TKPermintaan; ?>" class="col-xs-12 col-sm-10" readonly="" required="required" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            Keterangan </label>
        <div class="col-sm-9">
            <textarea id="inputKeterangan" name="txtKeterangan" class="col-xs-12 col-sm-10" onclick="changePermintaan()"><?php echo $row->IssueRemark; ?></textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            Umur <small>(optional)</small> </label>
        <div class="col-sm-9">
            <input type="text" id="inputUmur" name="txtUmur" value="<?php echo $row->Umur; ?>" placeholder="Input Umur" class="col-xs-12 col-sm-10" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            Pilih Pendidikan <small>(optional)</small>
        </label>
        <div class="col-sm-8">
            <select class="form-control" id="inputPemborong" name="comboPendidikan">
                <option value=""> -- Pilih Pendidikan </option>
                <option value="Semua" <?php if ($row->Pendidikan == 'Semua') {
                                            echo 'selected';
                                        } ?>> Semua Jenjang Pendidikan </option>
                <?php foreach ($getPend as $rowPend) : ?>
                    <option value="<?php echo $rowPend->Pendidikan; ?>" <?php if ($rowPend->Pendidikan == $row->Pendidikan) {
                                                                            echo 'selected';
                                                                        } ?>>
                        <?php echo $rowPend->Pendidikan; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            Pilih Jurusan <small>(optional)</small>
        </label>
        <div class="col-sm-9">
            <textarea id="inputPemborong" name="comboJurusan" class="col-xs-12 col-sm-10" onclick="changePermintaan()"><?php echo $row->Jurusan; ?></textarea>

        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            Pilih Jenis Kelamin <small>(optional)</small>
        </label>
        <div class="col-sm-8">
            <select class="form-control" id="inputPemborong" name="comboJekel">
                <option value=""> -- Pilih Jenis Kelamin </option>
                <option value="Semua" <?php if ($row->JenisKelamin == 'Semua') {
                                            echo 'selected';
                                        } ?>> Semua </option>
                <option value="Pria" <?php if ($row->JenisKelamin == 'Pria') {
                                            echo 'selected';
                                        } ?>> Hanya Laki-laki </option>
                <option value="Wanita" <?php if ($row->JenisKelamin == 'Wanita') {
                                            echo 'selected';
                                        } ?>> Hanya Perempuan </option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            Pilih Status Personal <small>(optional)</small>
        </label>
        <div class="col-sm-8">
            <select class="form-control" id="inputStatus" name="comboStatus">
                <option value=""> -- Pilih Status Personal </option>
                <option value="Semua" <?php if ($row->StatusPersonal == 'Semua') {
                                            echo 'selected';
                                        } ?>> Semua </option>
                <?php foreach ($getSKwn as $rowSKwn) : ?>
                    <option value="<?php echo $rowSKwn->StatusKawin; ?>" <?php if ($rowSKwn->StatusKawin == $row->StatusPersonal) {
                                                                                echo 'selected';
                                                                            } ?>>
                        <?php echo $rowSKwn->StatusKawin; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
<?php endforeach; ?>
<div class="form-group">
    <div class="col-md-offset-3 col-md-9">
        <input class="btn btn-sm btn-info" type="submit" name="simpan" value="Save">
    </div>
</div>
</form>
<script>
    function changePermintaan() {
        var target = parseInt(document.getElementById('inputTarget').value);
        var sedia = parseInt(document.getElementById('inputTersedia').value);
        var minta = 0;

        minta = target - sedia;

        document.getElementById('inputPermintaan').value = minta;
    }
</script>