<?php
foreach ($riwayat_kerja as $row) {
    $FixNo = $row->FixNo;
    $Nama = $row->Nama;
    $deptAbbr = $row->DeptAbbr;
    $bagianAbbr = $row->BagianAbbr;
    $bagianAbbr = $row->BagianAbbr;
    $ket = $row->ResignRemark;
    $TanggalKeluar = $row->TanggalKeluar != NULL ? date('d-m-Y', strtotime($row->TanggalKeluar)) : 'Belum Keluar';
    $TanggalKeluarTemp = $row->TanggalKeluarTemp != NULL ? date('d-m-Y', strtotime($row->TanggalKeluarTemp)) : '-';


    // if ($field->Status == 1) {
    //     if (file_exists(base_url() . 'fotos/Karyawan_regno new/' . $field->PersonalID . '.png')) {
    //         $url = base_url() . 'fotos/Karyawan_regno new/' . $field->PersonalID . '.png';
    //     } else {
    //         $url = base_url() . 'fotos/Karyawan_regno/' . $field->PersonalID . '.jpg';
    //     }
    // } else {

    $url =  base_url() . 'fotos/BORO_FIXNO/' . $FixNo . '.jpg';
    // }

    $img =  '<img alt="Tidak Ada Foto" src="' . $url . '" class="img-thumbnail rounded w-10 h-10" style="width: 137px; height: 200px;">';
}
?>
<div class="widget-body">
    <div class="widget-main padding-24">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-xs-12 label label-lg label-info arrowed-in arrowed-right">
                        <b>Informasi Riwayat Kerja di Sambu</b>
                    </div>
                </div>

                <div>
                    <!-- <?= $img ?> -->
                    <ul class="list-unstyled spaced">
                        <li>
                            <i class="ace-icon fa fa-caret-right blue"></i>
                            Nama : <?= $Nama; ?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right blue"></i>
                            Departemen : <?= $deptAbbr; ?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right blue"></i>
                            Bagian : <?= $bagianAbbr; ?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right blue"></i>
                            Keterangan Keluar : <?= $ket; ?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right blue"></i>
                            Tanggal Keluar : <?= $TanggalKeluar; ?>
                        </li>
                        <li>
                            <i class="ace-icon fa fa-caret-right blue"></i>
                            Tanggal Keluar Temp: <?= $TanggalKeluarTemp; ?>
                        </li>

                    </ul>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div>
</div>