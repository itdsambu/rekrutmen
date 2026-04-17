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
    <span class="col-sm-4 text-right">
        <a href="<?php echo site_url('monitor/print_hasil_interview_karyawan/' . $hdrid); ?>" class="btn btn-xs btn-success" target="_blank"><i class="ace-icon fa fa-print"></i> Print</a>
    </span>
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
                <th>Jabatan</th>
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
                    <td><?php echo $row->JabatanName; ?></td>
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

                $totalNilai = $rowNilai->TotalNilai;
                $RataNilai = $rowNilai->RataNilai;
                $Grade = $rowNilai->Grade;
                $Catatan = $rowNilai->Catatan;
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
                                <input name="txtNilai<?php echo $no1++; ?>" id="txtNilai<?php echo $no11++; ?>" type="number" class="form-control txtNilai" readonly value="<?= $rowNilai->Nilai ?>" onChange="changeVal(this.value)">
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
                                <input id="txtGrade<?php echo $no2++; ?>" type="text" class="form-control txtGrade" readonly="">
                                <span class="lbl"></span>
                            </label>
                        </td>
                        <td class="text-center">
                            <label class="pos-rel">
                                <input id="txtKet<?php echo $no3++; ?>" type="text" class="form-control txtKet" readonly="">
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
        <input id="txtTotal" name="txtTotal" type="text" class="" readonly="" value="<?= $totalNilai ?>">
        <label for="txtRata">Rata-rata</label>
        <input id="txtRata" name="txtRata" type="text" class="" readonly="" value="<?= $RataNilai ?>">
        <label for="txtGrade">Kesimpulan</label>
        <input id="txtGrade" name="txtGrade" type="text" class="" readonly="" value="<?= $Grade ?>">
    </div>
</div>

<div class="form-group">
    <label>Catatan</label>
    <textarea id="txtCatatan" name="txtCatatan" class="form-control" onclick="" readonly><?= $Catatan ?></textarea>
</div>
<!-- <div class="form-group">
    <input class="btn btn-sm btn-primary" type="submit" value="Simpan" name="btnSimpan" />
</div> -->
</form>


<?php
foreach ($datatk as $row) :
    $hdrid = $row->HeaderID;
endforeach;
$namafoto = './dataupload/foto/' . $hdrid . '.jpg';
?>

<script>
    function changeVal(q) {
        var nilai = q.val()
        var grade, ket
        if (nilai >= 90) {
            grade = 'A'
            ket = 'Sangat Baik'
        } else if (nilai >= 75) {
            grade = 'B'
            ket = 'Baik'
        } else if (nilai >= 60) {
            grade = 'C'
            ket = 'Cukup'
        } else if (nilai >= 50) {
            grade = 'D'
            ket = 'Kurang'
        } else if (nilai <= 49) {
            grade = 'E'
            ket = 'Sangat Kurang'
        } else if (nilai === "") {
            grade = ''
            ket = ''
        }

        q.closest('tr').find('.txtGrade').val(grade)
        q.closest('tr').find('.txtKet').val(ket)
    }

    // function changeVal(val) {
    //     console.log('hahaahh');
    //     var val1 = parseInt(document.getElementById('txtNilai1').value);
    //     if (val1 >= 90) {
    //         document.getElementById('txtGrade1').value = "A";
    //         document.getElementById('txtKet1').value = "Sangat Baik";
    //     } else if (val1 >= 75) {
    //         document.getElementById('txtGrade1').value = "B";
    //         document.getElementById('txtKet1').value = "Baik";
    //     } else if (val1 >= 60) {
    //         document.getElementById('txtGrade1').value = "C";
    //         document.getElementById('txtKet1').value = "Cukup";
    //     } else if (val1 >= 50) {
    //         document.getElementById('txtGrade1').value = "D";
    //         document.getElementById('txtKet1').value = "Kurang";
    //     } else if (val1 <= 49) {
    //         document.getElementById('txtGrade1').value = "E";
    //         document.getElementById('txtKet1').value = "Sangat Kurang";
    //     } else if (val1 === "") {
    //         document.getElementById('txtGrade1').value = "";
    //         document.getElementById('txtKet1').value = "";
    //     }

    //     var val2 = parseInt(document.getElementById('txtNilai2').value);
    //     console.log(val2);
    //     // if (val2 >= 90) {
    //     //     document.getElementById('txtGrade2').value = "A";
    //     //     document.getElementById('txtKet2').value = "Sangat Baik";
    //     // } else if (val2 >= 75) {
    //     //     document.getElementById('txtGrade2').value = "B";
    //     //     document.getElementById('txtKet2').value = "Baik";
    //     // } else if (val2 >= 60) {
    //     //     document.getElementById('txtGrade2').value = "C";
    //     //     document.getElementById('txtKet2').value = "Cukup";
    //     // } else if (val2 >= 50) {
    //     //     document.getElementById('txtGrade2').value = "D";
    //     //     document.getElementById('txtKet2').value = "Kurang";
    //     // } else if (val2 <= 49) {
    //     //     document.getElementById('txtGrade2').value = "E";
    //     //     document.getElementById('txtKet2').value = "Sangat Kurang";
    //     // } else if (val2 === "") {
    //     //     document.getElementById('txtGrade2').value = "";
    //     //     document.getElementById('txtKet2').value = "";
    //     // }

    //     // var val3 = parseInt(document.getElementById('txtNilai3').value);
    //     // if (val3 >= 90) {
    //     //     document.getElementById('txtGrade3').value = "A";
    //     //     document.getElementById('txtKet3').value = "Sangat Baik";
    //     // } else if (val3 >= 75) {
    //     //     document.getElementById('txtGrade3').value = "B";
    //     //     document.getElementById('txtKet3').value = "Baik";
    //     // } else if (val3 >= 60) {
    //     //     document.getElementById('txtGrade3').value = "C";
    //     //     document.getElementById('txtKet3').value = "Cukup";
    //     // } else if (val3 >= 50) {
    //     //     document.getElementById('txtGrade3').value = "D";
    //     //     document.getElementById('txtKet3').value = "Kurang";
    //     // } else if (val3 <= 49) {
    //     //     document.getElementById('txtGrade3').value = "E";
    //     //     document.getElementById('txtKet3').value = "Sangat Kurang";
    //     // } else if (val3 === "") {
    //     //     document.getElementById('txtGrade3').value = "";
    //     //     document.getElementById('txtKet3').value = "";
    //     // }

    //     // var val4 = parseInt(document.getElementById('txtNilai4').value);
    //     // if (val4 >= 90) {
    //     //     document.getElementById('txtGrade4').value = "A";
    //     //     document.getElementById('txtKet4').value = "Sangat Baik";
    //     // } else if (val4 >= 75) {
    //     //     document.getElementById('txtGrade4').value = "B";
    //     //     document.getElementById('txtKet4').value = "Baik";
    //     // } else if (val4 >= 60) {
    //     //     document.getElementById('txtGrade4').value = "C";
    //     //     document.getElementById('txtKet4').value = "Cukup";
    //     // } else if (val4 >= 50) {
    //     //     document.getElementById('txtGrade4').value = "D";
    //     //     document.getElementById('txtKet4').value = "Kurang";
    //     // } else if (val4 <= 49) {
    //     //     document.getElementById('txtGrade4').value = "E";
    //     //     document.getElementById('txtKet4').value = "Sangat Kurang";
    //     // } else if (val4 === "") {
    //     //     document.getElementById('txtGrade4').value = "";
    //     //     document.getElementById('txtKet4').value = "";
    //     // }

    //     // var val5 = parseInt(document.getElementById('txtNilai5').value);
    //     // if (val5 >= 90) {
    //     //     document.getElementById('txtGrade5').value = "A";
    //     //     document.getElementById('txtKet5').value = "Sangat Baik";
    //     // } else if (val5 >= 75) {
    //     //     document.getElementById('txtGrade5').value = "B";
    //     //     document.getElementById('txtKet5').value = "Baik";
    //     // } else if (val5 >= 60) {
    //     //     document.getElementById('txtGrade5').value = "C";
    //     //     document.getElementById('txtKet5').value = "Cukup";
    //     // } else if (val5 >= 50) {
    //     //     document.getElementById('txtGrade5').value = "D";
    //     //     document.getElementById('txtKet5').value = "Kurang";
    //     // } else if (val5 <= 49) {
    //     //     document.getElementById('txtGrade5').value = "E";
    //     //     document.getElementById('txtKet5').value = "Sangat Kurang";
    //     // } else if (val5 === "") {
    //     //     document.getElementById('txtGrade5').value = "";
    //     //     document.getElementById('txtKet5').value = "";
    //     // }

    //     // var val6 = parseInt(document.getElementById('txtNilai6').value);
    //     // if (val6 >= 90) {
    //     //     document.getElementById('txtGrade6').value = "A";
    //     //     document.getElementById('txtKet6').value = "Sangat Baik";
    //     // } else if (val6 >= 75) {
    //     //     document.getElementById('txtGrade6').value = "B";
    //     //     document.getElementById('txtKet6').value = "Baik";
    //     // } else if (val6 >= 60) {
    //     //     document.getElementById('txtGrade6').value = "C";
    //     //     document.getElementById('txtKet6').value = "Cukup";
    //     // } else if (val6 >= 50) {
    //     //     document.getElementById('txtGrade6').value = "D";
    //     //     document.getElementById('txtKet6').value = "Kurang";
    //     // } else if (val6 <= 49) {
    //     //     document.getElementById('txtGrade6').value = "E";
    //     //     document.getElementById('txtKet6').value = "Sangat Kurang";
    //     // } else if (val6 === "") {
    //     //     document.getElementById('txtGrade6').value = "";
    //     //     document.getElementById('txtKet6').value = "";
    //     // }

    //     // var val7 = parseInt(document.getElementById('txtNilai7').value);
    //     // if (val7 >= 90) {
    //     //     document.getElementById('txtGrade7').value = "A";
    //     //     document.getElementById('txtKet7').value = "Sangat Baik";
    //     // } else if (val7 >= 75) {
    //     //     document.getElementById('txtGrade7').value = "B";
    //     //     document.getElementById('txtKet7').value = "Baik";
    //     // } else if (val7 >= 60) {
    //     //     document.getElementById('txtGrade7').value = "C";
    //     //     document.getElementById('txtKet7').value = "Cukup";
    //     // } else if (val7 >= 50) {
    //     //     document.getElementById('txtGrade7').value = "D";
    //     //     document.getElementById('txtKet7').value = "Kurang";
    //     // } else if (val7 <= 49) {
    //     //     document.getElementById('txtGrade7').value = "E";
    //     //     document.getElementById('txtKet7').value = "Sangat Kurang";
    //     // } else if (val7 === "") {
    //     //     document.getElementById('txtGrade7').value = "";
    //     //     document.getElementById('txtKet7').value = "";
    //     // }

    //     // var val8 = parseInt(document.getElementById('txtNilai8').value);
    //     // if (val8 >= 90) {
    //     //     document.getElementById('txtGrade8').value = "A";
    //     //     document.getElementById('txtKet8').value = "Sangat Baik";
    //     // } else if (val8 >= 75) {
    //     //     document.getElementById('txtGrade8').value = "B";
    //     //     document.getElementById('txtKet8').value = "Baik";
    //     // } else if (val8 >= 60) {
    //     //     document.getElementById('txtGrade8').value = "C";
    //     //     document.getElementById('txtKet8').value = "Cukup";
    //     // } else if (val8 >= 50) {
    //     //     document.getElementById('txtGrade8').value = "D";
    //     //     document.getElementById('txtKet8').value = "Kurang";
    //     // } else if (val8 <= 49) {
    //     //     document.getElementById('txtGrade8').value = "E";
    //     //     document.getElementById('txtKet8').value = "Sangat Kurang";
    //     // } else if (val8 === "") {
    //     //     document.getElementById('txtGrade8').value = "";
    //     //     document.getElementById('txtKet8').value = "";
    //     // }

    //     // var val9 = parseInt(document.getElementById('txtNilai9').value);
    //     // if (val9 >= 90) {
    //     //     document.getElementById('txtGrade9').value = "A";
    //     //     document.getElementById('txtKet9').value = "Sangat Baik";
    //     // } else if (val9 >= 75) {
    //     //     document.getElementById('txtGrade9').value = "B";
    //     //     document.getElementById('txtKet9').value = "Baik";
    //     // } else if (val9 >= 60) {
    //     //     document.getElementById('txtGrade9').value = "C";
    //     //     document.getElementById('txtKet9').value = "Cukup";
    //     // } else if (val9 >= 50) {
    //     //     document.getElementById('txtGrade9').value = "D";
    //     //     document.getElementById('txtKet9').value = "Kurang";
    //     // } else if (val9 <= 49) {
    //     //     document.getElementById('txtGrade9').value = "E";
    //     //     document.getElementById('txtKet9').value = "Sangat Kurang";
    //     // } else if (val9 === "") {
    //     //     document.getElementById('txtGrade9').value = "";
    //     //     document.getElementById('txtKet9').value = "";
    //     // }

    //     // var val10 = parseInt(document.getElementById('txtNilai10').value);
    //     // if (val10 >= 90) {
    //     //     document.getElementById('txtGrade10').value = "A";
    //     //     document.getElementById('txtKet10').value = "Sangat Baik";
    //     // } else if (val10 >= 75) {
    //     //     document.getElementById('txtGrade10').value = "B";
    //     //     document.getElementById('txtKet10').value = "Baik";
    //     // } else if (val10 >= 60) {
    //     //     document.getElementById('txtGrade10').value = "C";
    //     //     document.getElementById('txtKet10').value = "Cukup";
    //     // } else if (val10 >= 50) {
    //     //     document.getElementById('txtGrade10').value = "D";
    //     //     document.getElementById('txtKet10').value = "Kurang";
    //     // } else if (val10 <= 49) {
    //     //     document.getElementById('txtGrade10').value = "E";
    //     //     document.getElementById('txtKet10').value = "Sangat Kurang";
    //     // } else if (val10 === "") {
    //     //     document.getElementById('txtGrade10').value = "";
    //     //     document.getElementById('txtKet10').value = "";
    //     // }

    //     // var val11 = parseInt(document.getElementById('txtNilai11').value);
    //     // if (val11 >= 90) {
    //     //     document.getElementById('txtGrade11').value = "A";
    //     //     document.getElementById('txtKet11').value = "Sangat Baik";
    //     // } else if (val11 >= 75) {
    //     //     document.getElementById('txtGrade11').value = "B";
    //     //     document.getElementById('txtKet11').value = "Baik";
    //     // } else if (val11 >= 60) {
    //     //     document.getElementById('txtGrade11').value = "C";
    //     //     document.getElementById('txtKet11').value = "Cukup";
    //     // } else if (val11 >= 50) {
    //     //     document.getElementById('txtGrade11').value = "D";
    //     //     document.getElementById('txtKet11').value = "Kurang";
    //     // } else if (val11 <= 49) {
    //     //     document.getElementById('txtGrade11').value = "E";
    //     //     document.getElementById('txtKet11').value = "Sangat Kurang";
    //     // } else if (val11 === "") {
    //     //     document.getElementById('txtGrade11').value = "";
    //     //     document.getElementById('txtKet11').value = "";
    //     // }

    //     // var val12 = parseInt(document.getElementById('txtNilai12').value);
    //     // if (val12 >= 90) {
    //     //     document.getElementById('txtGrade12').value = "A";
    //     //     document.getElementById('txtKet12').value = "Sangat Baik";
    //     // } else if (val12 >= 75) {
    //     //     document.getElementById('txtGrade12').value = "B";
    //     //     document.getElementById('txtKet12').value = "Baik";
    //     // } else if (val12 >= 60) {
    //     //     document.getElementById('txtGrade12').value = "C";
    //     //     document.getElementById('txtKet12').value = "Cukup";
    //     // } else if (val12 >= 50) {
    //     //     document.getElementById('txtGrade12').value = "D";
    //     //     document.getElementById('txtKet12').value = "Kurang";
    //     // } else if (val12 <= 49) {
    //     //     document.getElementById('txtGrade12').value = "E";
    //     //     document.getElementById('txtKet12').value = "Sangat Kurang";
    //     // } else if (val12 === "") {
    //     //     document.getElementById('txtGrade12').value = "";
    //     //     document.getElementById('txtKet12').value = "";
    //     // }

    //     // if (val2 !== "") {
    //     //     var nilai1 = parseFloat((val1 + val2) / 2);
    //     //     document.getElementById('txtVal1').value = Math.round(nilai1 * 100) / 100;
    //     // }

    //     // if (val5 !== "") {
    //     //     var nilai1 = parseFloat((val3 + val4 + val5) / 3);
    //     //     document.getElementById('txtVal2').value = Math.round(nilai1 * 100) / 100;
    //     // }

    //     // if (val8 !== "") {
    //     //     var nilai1 = parseFloat((val6 + val7 + val8) / 3);
    //     //     document.getElementById('txtVal3').value = Math.round(nilai1 * 100) / 100;
    //     // }

    //     // if (val10 !== "") {
    //     //     var nilai1 = parseInt((val9 + val10) / 2);
    //     //     document.getElementById('txtVal4').value = Math.round(nilai1 * 100) / 100;
    //     // }

    //     // if (val12 !== "") {
    //     //     var nilai1 = parseFloat((val11 + val12) / 2);
    //     //     document.getElementById('txtVal5').value = Math.round(nilai1 * 100) / 100;
    //     // }

    //     // if (val12 !== "") {
    //     //     var nilai1 = parseFloat((val1 + val2) / 2);
    //     //     var nilai2 = parseFloat((val3 + val4 + val5) / 3);
    //     //     var nilai3 = parseFloat((val6 + val7 + val8) / 3);
    //     //     var nilai4 = parseInt((val9 + val10) / 2);
    //     //     var nilai5 = parseFloat((val11 + val12) / 2);

    //     //     var total = parseFloat(nilai1 + nilai2 + nilai3 + nilai4 + nilai5);
    //     //     var rata = parseFloat(total / 5);
    //     //     var grade = "";
    //     //     if (rata >= 60) {
    //     //         grade = "Lulus";
    //     //         //$("#hasil").form-group("has-success");
    //     //     } else {
    //     //         grade = "Gagal";
    //     //         //$("#hasil").form-group("has-error");
    //     //     }

    //     //     document.getElementById('txtTotal').value = Math.round(total * 100) / 100;
    //     //     document.getElementById('txtRata').value = Math.round(rata * 100) / 100;
    //     //     document.getElementById('txtGrade').value = grade;
    //     // }


    // }

    $(document).ready(function() {

        $('[class*="txtNilai"]').each(function() {
            changeVal($(this))
        });
    });


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
</script>