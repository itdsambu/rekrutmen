<?php
$Sisa = 0;
foreach ($_getDataCicilan as $get) {
    if ($_getDataCicilan->DiPotongPeriodeIni_Sembako > '200000') {
        if ($_getDataCicilan->Sisa_periode_sebelumnya <  $_getDataCicilan->Sisa_PeriodeSebelumnya_tkbaru) {
            $Sisa = $_getDataCicilan->Sisa_PeriodeSebelumnya_tkbaru;
        } else {

            $Sisa = $_getDataCicilan->Sisa_periode_sebelumnya;
        }
    } else {
        $Sisa = $_getDataCicilan->Sisa_PeriodeSebelumnya_tkbaru;
    }
} ?>
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
    <table>
        <tr>
            <td style="text-align: justify;"> Periode &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align: justify;"> Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $_getDataCicilan->Nama; ?></td>
        </tr>
        <tr>
            <td style="text-align: justify;"> NIK &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $_getDataCicilan->Nik; ?></td>
        </tr>
        <tr>
            <td style="text-align: justify;"> Departemen &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $_getDataCicilan->BagianAbbr; ?></td>
        </tr>
        <tr>
            <td style="text-align: justify;"> Pemborong &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $_getDataCicilan->Pemborong; ?></td>
        </tr>
        <tr>
            <td style="text-align: justify;"> Sub Pemborong &nbsp;:&nbsp;<?php echo $_getDataCicilan->NamaSub; ?></td>
        </tr>
    </table>
    <br>

    <table class="tbl1" style="font-size: 9px; font-family: Arial;" backtop="7mm" backbottom="10mm" backleft="5mm" backright="5mm">
        <tr>
            <td style="width: 5%; border-right: 1;border-top: 1;border-left: 1;text-align: center;height: 30px; font-weight: bold;">No.</td>
            <td style="width: 15%; border-right: 1;border-top: 1;text-align: center;height: 30px; font-weight: bold;">Tanggal</td>
            <td style="width: 50%; border-right: 1;border-top: 1;text-align: center;height: 30px; font-weight: bold;">Nama Cicilan</td>
            <td style="width: 5%; border-right: 1;border-top: 1;text-align: center;height: 30px; font-weight: bold;">Qty</td>
            <td style="width: 15%; border-right: 1;border-top: 1;text-align: center;height: 30px; font-weight: bold;">Cicilan</td>
        </tr>
        <?php
        $no = 1;
        $total = 0;
        foreach ($getCicilan as $key) {
            $total += $key->HargaCicilan; ?>
            <tr>
                <td style="width: 5%; border-right: 1;text-align: center;border-top: 1;border-left: 1;border-bottom: 1"><?php echo $no++; ?></td>
                <td style="width: 15%; border-right: 1;border-top: 1;border-bottom: 1;text-align: center;"><?php echo date('d-m-Y', strtotime($key->Tanggal)) ?></td>
                <td style="width: 50%; border-right: 1;border-top: 1;border-bottom: 1;text-align: left"><?php echo $key->NamaCicilan ?></td>
                <td style="width: 5%; border-right: 1;border-top: 1;border-bottom: 1;text-align: center"><?php echo $key->Quantity ?></td>
                <td style="width: 15%; border-right: 1;border-top: 1;border-bottom: 1;text-align: center">Rp.<?php echo number_format($key->HargaCicilan, 0, ",", "."); ?></td>
            </tr>
        <?php }
        ?>
        <tr>
            <td colspan="4" style="width: 75%; border-right: 1;border-top: 1;border-left: 1;border-bottom: 1;text-align: center;height: 10px; font-weight: bold;">Total</td>
            <td style="width: 15%; border-right: 1;border-top: 1;border-left: 1;border-bottom: 1;text-align: center;height: 10px; font-weight: bold;">Rp.<?php echo number_format($_getDataCicilan->Pot_Cicilan, 0, ",", "."); ?></td>
        </tr>
        <br>
        <br>
        <tr>

            <td colspan="4" style="width: 50%; border-right: 1;border-top: 1;border-left: 1;border-bottom: 1;text-align: center;height: 10px; font-weight: bold;">Grand Total</td>
            <td style="width: 15%; border-right: 1;border-top: 1;height: 10px;border-bottom: 1;text-align: center">Rp.<?php echo number_format($_getDataCicilan->Pot_Sembako + $_getDataCicilan->Pot_Cicilan, 0, ",", "."); ?></td>
        </tr>
        <tr>
            <td colspan="4" style="width: 50%; border-right: 1;border-top: 1;border-left: 1;border-bottom: 1;text-align: center;height: 10px; font-weight: bold;">Sisa periode sebelumnya </td>
            <td style="width: 15%; border-right: 1;border-top: 1;height: 10px;border-bottom: 1;text-align: center">Rp.<?php echo number_format($Sisa, 0, ",", "."); ?></td>
        </tr>
        <tr>
            <td colspan="4" style="width: 50%; border-right: 1;border-top: 1;border-left: 1;border-bottom: 1;text-align: center;height: 10px; font-weight: bold;">Total Dipotong </td>
            <td style="width: 15%; border-right: 1;border-top: 1;height: 10px;border-bottom: 1;text-align: center">Rp.<?php echo number_format($_getDataCicilan->DiPotongPeriodeIni_Sembako + $_getDataCicilan->DiPotongPeriodeIni_Cicilan, 0, ",", "."); ?></td>
        </tr>
        <tr>
            <td colspan="4" style="width: 50%; border-right: 1;border-top: 1;border-left: 1;border-bottom: 1;text-align: center;height: 10px; font-weight: bold;">Sisa Potongan </td>
            <td style="width: 15%; border-right: 1;border-top: 1;height: 10px;border-bottom: 1;text-align: center">
                <?php
                if (($_getDataCicilan->Pot_Sembako + $total) + $_getDataCicilan->Sisa_PeriodeSebelumnya_tkbaru - ($_getDataCicilan->DiPotongPeriodeIni_Sembako + $_getDataCicilan->DiPotongPeriodeIni_Cicilan) < 0 ||  $_getDataCicilan->DiPotongPeriodeIni_Cicilan == null) {
                    echo "Rp. 0";
                } else {
                    // echo "Rp." . number_format(($_getDataCicilan->Pot_Sembako + $_getDataCicilan->Pot_Cicilan) + $_getDataCicilan->Sisa_PeriodeSebelumnya_tkbaru - ($_getDataCicilan->DiPotongPeriodeIni_Sembako + $_getDataCicilan->DiPotongPeriodeIni_Cicilan), 0, ",", ".");
                    echo "Rp." . number_format(($_getDataCicilan->Pot_Sembako + $total) + $_getDataCicilan->Sisa_PeriodeSebelumnya_tkbaru - ($_getDataCicilan->DiPotongPeriodeIni_Sembako + $_getDataCicilan->DiPotongPeriodeIni_Cicilan), 0, ",", ".");
                    // echo "Rp." . number_format($Sisa, 0, ",", ".");
                } ?>
            </td>
        </tr>
    </table>
</page>