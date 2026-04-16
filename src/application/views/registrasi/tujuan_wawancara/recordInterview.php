<h4 class="row header smaller lighter blue">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-info-circle"></i>
        Record Interview dari saudara <strong><?php foreach ($datatk as $row) {
                                                    echo $row->Nama;
                                                } ?></strong>
    </span><!-- /.col -->
</h4>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Dept</th>
                <th>Interview by</th>
                <th>Interview date</th>
                <th>Jabatan</th>
                <th>Sub Jabatan</th>
                <th class="text-center">Hasil Interview</th>
                <th class="text-center">Total Nilai</th>
                <th class="text-center">Rata-rata</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultInterV as $rowV) : ?>
                <tr>
                    <td style="width: 50px">
                        <?= $rowV->Departemen; ?>
                    </td>
                    <td>
                        <?= $rowV->WawancaraBy; ?>
                    </td>
                    <td>
                        <?= date('F d, Y H:i', strtotime($rowV->Tanggal)); ?>
                    </td>
                    <td>
                        <?= $rowV->JabatanName; ?>
                    </td>
                    <td>
                        <?= $rowV->SubJabatanName; ?>
                    </td>
                    <td class="text-center" style="width: 100px">
                        <?php
                        if ($rowV->HasilWawancara == 1) {
                            echo 'LULUS';
                        } else {
                            echo 'GAGAL';
                        }
                        ?>
                    </td>
                    <td class="text-center" style="width: 100px">
                        <?= $rowV->TotalNilai; ?>
                    </td>
                    <td class="text-center" style="width: 100px">
                        <?= $rowV->RataNilai; ?>
                    </td>
                    <?php if ($rowV->JenisKerja != '') { ?>
                        <td class="col-sm-3">
                            <?= $rowV->Keterangan; ?>, <?= $rowV->JenisKerja; ?>, <?= $rowV->SubPekerjaan; ?>, <?= $rowV->LiburMingguan; ?>, <?= $rowV->Shift == 'Z' ? "Non Shift" : $rowV->Shift; ?>
                        </td>
                    <?php   } else { ?>
                        <td class="col-sm-3">
                            <?= $rowV->Keterangan; ?>
                        </td>
                    <?php  } ?>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>