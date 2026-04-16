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

<?php //if ($this->session->userdata('userid') == 'riyan' || $this->session->userdata('userid') == 'KIKI') { 
?>
<!-- <div class="well well-sm" style="display: <?php echo $display; ?>;"> -->

<?php //} 
?>

<div class="form-group">
    <label>Catatan</label>
    <textarea name="txtCatatan" class="form-control" readonly></textarea>
</div>

</form>


<?php
foreach ($datatk as $row) :
    $hdrid = $row->HeaderID;
endforeach;
$namafoto = './dataupload/foto/' . $hdrid . '.jpg';
?>


<script>
    function changeVal(val) {
        var val1 = parseInt(document.querySelector('input[name="txtNilai1"]:checked').value);
        var val2 = parseInt(document.querySelector('input[name="txtNilai2"]:checked').value);
        var val3 = parseInt(document.querySelector('input[name="txtNilai3"]:checked').value);
        var val4 = parseInt(document.querySelector('input[name="txtNilai4"]:checked').value);
        var val5 = parseInt(document.querySelector('input[name="txtNilai5"]:checked').value);
        var val6 = parseInt(document.querySelector('input[name="txtNilai6"]:checked').value);

        var total = val1 + val2 + val3 + val4 + val5 + val6;
        var rata = total / 6;
        var grade = "";
        if (rata >= 60) {
            grade = "Lulus";
            //membuat pilihan menjadi bisa di klik saat kondisi lulus
            $('#txtJenisKerja').prop('disabled', false)
            $('#txtSubKerja').prop('disabled', false)
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
            $('#txtLiburMingguan').prop('disabled', true)
            $('#txtShift').prop('disabled', true)
        }
        document.getElementById('txtTotal').value = total;
        document.getElementById('txtRata').value = Math.round(rata * 100) / 100;
        document.getElementById('txtGrade').value = grade;
    }

    function cekSubmit() {
        alert(123)
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