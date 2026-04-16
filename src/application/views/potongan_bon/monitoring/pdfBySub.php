<style type="text/css">
    .hdr {
        width: 100%;
    }

    .kop {
        font-size: 25px;
        width: 85%;
        text-align: center;

    }

    .judul {
        font-size: 30px;
        font-weight: bold;
        text-align: center;
    }

    .tbl2 {
        width: 100%;
        border-top: 1;
        border-bottom: 1;
        border-right: 3;
        border-left: 3;
        border-spacing: 0;
        border-style: dotted;
    }

    .txt1 {
        font-size: 12;
    }

    .tbl1 {
        width: 100%;
        border: 1;
    }

    .tbl3 {
        width: 100%;
    }

    .font {
        font-family: Times New Roman, Helvetica, sans-serif;
        font-size: 12;
        text-align: justify;
    }
</style>

<page style="font-size: 15px; font-family: Arial;" backtop="7mm" backbottom="10mm" backleft="10mm" backright="18mm">
    <table>
        <tr>
            <td style="text-align: center;"><strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REKAP BON TENAGA KERJA </strong></td>
        </tr>
    </table>
    <br>
    <br>
    <table class="tbl1" style="font-size: 9px; font-family: Arial;" backtop="7mm" backbottom="10mm" backleft="5mm" backright="5mm">
        <tr>
            <td style="width: 5%; border-right: 1;text-align: center;height: 30px; font-weight: bold;">No.</td>
            <!-- <td style="width: 8%; border-right: 1;text-align: center;height: 30px; font-weight: bold;">Nofix</td> -->
            <td style="width: 8%; border-right: 1;text-align: center;height: 30px; font-weight: bold;">NIK</td>
            <td style="width: 15%; border-right: 1;text-align: center;height: 30px; font-weight: bold;">Nama Lengkap</td>
            <td style="width: 5%; border-right: 1;text-align: center;height: 30px; font-weight: bold;">Dept</td>
            <td style="width: 10%; border-right: 1;text-align: center;height: 30px; font-weight: bold;">CV. Perusahaan</td>
            <td style="width: 10%; border-right: 1;text-align: center;height: 30px; font-weight: bold;">Potongan Sembako</td>
            <td style="width: 10%; border-right: 1;text-align: center;height: 30px; font-weight: bold;">Potongan Cicilan</td>
            <td style="width: 10%; border-right: 1;text-align: center;height: 30px; font-weight: bold;">Total</td>
            <td style="width: 10%; border-right: 1;text-align: center;height: 30px; font-weight: bold;">Dipotong saat kalkulasi</td>
            <td style="width: 10%; border-right: 1;text-align: center;height: 30px; font-weight: bold;">Sisa</td>

        </tr>
        <?php
        $no              = 1;
        $total_sembako   = 0;
        $total_cicilan   = 0;
        $grand_total     = 0;
        $total_kalkulasi = 0;
        $total_sisa      = 0;
        $sisa            = 0;

        foreach ($_getDataCicilan as $key) {
            $total_sembako    += $key->Pot_Sembako;
            $total_cicilan    += $key->Pot_Cicilan;
            $grand_total      += $key->Pot_Cicilan + $key->Pot_Sembako;
            $total_kalkulasi  += $key->DiPotongPeriodeIni_Sembako + $key->DiPotong_Periode_iniCicilan;
            if ($key->PasTigaBulan <= 3 && $key->PasTigaBulan >= 0) {
                $sisa = $key->Sisa_PeriodeSebelumnya_tkbaru;
            } else if (isset($key->Sisa_PeriodeSebelumnya_tkbaru) && isset($key->SisaPeriodeSebelumnya_tklama)) {
                $sisa = $key->SisaPeriodeSebelumnya_tklama + $key->Sisa_PeriodeSebelumnya_tkbaru;
            } else {
                $sisa = $key->SisaPeriodeSebelumnya_tklama;
            }
            $total_sisa       += ($key->Pot_Sembako + $key->Pot_Cicilan) + $sisa  - ($key->DiPotongPeriodeIni_Sembako + $key->DiPotong_Periode_iniCicilan);
        ?>
            <tr>
                <td style="width: 5%; border-right: 1;text-align: center;border-top: 1;height: 15px;"><?php echo $no++; ?></td>
                <!-- <td style="width: 8%; border-right: 1;border-top: 1;text-align: center;height: 15px;"><?php echo $key->Nofix ?></td> -->
                <td style="width: 8%; border-right: 1;border-top: 1;text-align: left"><?php echo $key->Nik ?></td>
                <td style="width: 15%; border-right: 1;border-top: 1;text-align: left"><?php echo $key->Nama ?></td>
                <td style="width: 5%; border-right: 1;border-top: 1;text-align: center"><?php echo $key->BagianAbbr ?></td>
                <td style="width: 10%; border-right: 1;border-top: 1;text-align: center"><?php echo $key->Perusahaan ?></td>
                <td style="width: 10%; border-right: 1;border-top: 1;text-align: center">Rp.<?php echo number_format($key->Pot_Sembako, 0, ",", "."); ?></td>
                <td style="width: 10%; border-right: 1;border-top: 1;text-align: center">Rp.<?php echo number_format($key->Pot_Cicilan, 0, ",", "."); ?></td>
                <td style="width: 10%; border-right: 1;border-top: 1;text-align: center">Rp.<?php echo number_format($key->Pot_Cicilan + $key->Pot_Sembako, 0, ",", "."); ?></td>
                <td style="width: 10%; border-right: 1;border-top: 1;text-align: center">Rp.<?php echo number_format($key->DiPotongPeriodeIni_Sembako + $key->DiPotong_Periode_iniCicilan, 0, ",", "."); ?></td>
                <td style="width: 10%; border-right: 1;border-top: 1;text-align: center;"><?php
                                                                                            if (($key->Pot_Sembako + $key->Pot_Cicilan) + $sisa - ($key->DiPotongPeriodeIni_Sembako + $key->DiPotong_Periode_iniCicilan) < 0) {
                                                                                                echo "Rp. 0";
                                                                                            } else {
                                                                                                echo "Rp." . number_format(($key->Pot_Sembako + $key->Pot_Cicilan) + $sisa - ($key->DiPotongPeriodeIni_Sembako + $key->DiPotong_Periode_iniCicilan), 0, ",", ".");
                                                                                            }
                                                                                            ?></td>
            </tr>
        <?php }
        ?>
        <tr>
            <td style="width: 10%; border-right: 1;text-align: center;border-top: 1;height: 15px;" colspan="5">Total</td>
            <td style="width: 12%; border-right: 1;border-top: 1;text-align: center">Rp.<?= number_format($total_sembako, 2, ",", ".") ?></td>
            <td style="width: 12%; border-right: 1;border-top: 1;text-align: center">Rp.<?= number_format($total_cicilan, 2, ",", ".") ?></td>
            <td style="width: 12%; border-right: 1;border-top: 1;text-align: center">Rp.<?= number_format($grand_total, 2, ",", ".") ?></td>
            <td style="width: 12%; border-right: 1;border-top: 1;text-align: center">Rp.<?= number_format($total_kalkulasi, 2, ",", ".") ?></td>
            <td style="width: 12%; border-right: 1;border-top: 1;text-align: center;"><?php
                                                                                        if (($key->Pot_Sembako + $key->Pot_Cicilan) + $sisa - ($key->DiPotongPeriodeIni_Sembako + $key->DiPotong_Periode_iniCicilan) < 0) {
                                                                                            echo "Rp. 0";
                                                                                        } else {
                                                                                            echo "Rp." . number_format($total_sisa, 2, ",", ".");
                                                                                        } ?></td>
        </tr>

    </table>
</page>