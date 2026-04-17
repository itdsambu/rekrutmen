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
        /*border: 1;*/
        font-size: 14;
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
    }

    .tbl3 {
        width: 100%;
        text-align: left;
        font-size: 14;
        font-family: Arial, Helvetica, sans-serif;
    }

    .font {
        font-family: Times New Roman, Helvetica, sans-serif;
        font-size: 14;
        text-align: justify;
    }
</style>

<page style="font-size: 15px; font-family: Arial;" backtop="7mm" backbottom="10mm" backleft="6mm" backright="6mm">
    <table style="font-size: 15px; font-family: Arial;" backtop="7mm" backbottom="10mm" backleft="5mm" backright="5mm">
        <tr>
            <td style="text-align: center;"><strong>LIST BELANJA SEMBAKO</strong></td>
        </tr>
    </table>
    <br>
    <br>
    <table class="tbl3" backtop="7mm" backbottom="10mm" backleft="4mm" backright="4mm">
        <?php foreach ($_getDataPrintSlipHdr as $hdr) { ?>
            <tr>
                <td>&nbsp;Tanggal</td>
                <td>: <?php echo date('d-m-Y', strtotime($hdr->Tanggal)); ?></td>
            </tr>
            <tr>
                <td>&nbsp;Nama</td>
                <td>: <?php echo $hdr->Nama; ?></td>
            </tr>
            <tr>
                <td>&nbsp;Nik</td>
                <td>: <?php echo $hdr->Nik; ?></td>
            </tr>
            <tr>
                <td>&nbsp;Bagian</td>
                <td>: <?php echo $hdr->BagianAbbr; ?></td>
            </tr>
            <tr>
                <td>&nbsp;Pemborong</td>
                <td>: <?php echo $hdr->Pemborong; ?></td>
            </tr>
            <!-- <tr>
                <td>&nbsp;Sub Pemborong</td>
                <td>: <?php echo $hdr->NamaSub; ?></td>
            </tr> -->
        <?php } ?>
    </table>
    <!-- <hr style="width: 10%;"> -->
    <br>
    <table class="tbl1" backtop="7mm" backbottom="10mm" backleft="4mm" backright="4mm">
        <tr>
            <td style="width: 20%;height: 5%;">Nama Item</td>
            <td style="width: 10%;">Quantity</td>
            <td style="width: 10%;">Satuan</td>
            <td style="width: 20%;">Total</td>
        </tr>
        <br>
        <br>
        <?php foreach ($_getDataPrintSlipDtl as $dtl) { ?>
            <tr>
                <td style="width: 20%;height: 3%;"><?php echo $dtl->NamaItem; ?></td>
                <td style="width: 10%;"><?php echo $dtl->Quantity; ?></td>
                <td style="width: 10%;"><?php echo $dtl->NamaSatuan; ?></td>
                <td style="width: 20%;">Rp.<?php echo number_format($dtl->Harga, 0, ",", "."); ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td></td>
        </tr>
    </table>
    <br>
    <br>
    <table class="tbl3" backtop="7mm" backbottom="10mm" backleft="4mm" backright="4mm">
        <tr>
            <td>&nbsp;Grand</td>
            <td>: Rp.<?php foreach ($_getTotalBelanja as $get) {
                            echo number_format($get->GrandTotal, 0, ",", ".");
                        }; ?></td>
        </tr>
        <tr>
            <td>&nbsp;Sisa Periode Lalu</td>
            <td>: Rp. <?php foreach ($_sisa as $ssa) {
                            $sisa = $ssa->SisaPeriodeSebelumnya;
                            echo number_format($sisa, 0, ",", ".");
                        } ?></td>
        </tr>
        <tr>
            <td>&nbsp;Total Periode Ini</td>
            <td>: Rp. <?php foreach ($_totalPeriodeIni as $row) {
                            // echo number_format($row->Pot_Sembako,0,",",".");
                            $ttl_periode_ini = $row->Pot_Sembako;
                            echo number_format($ttl_periode_ini, 0, ",", ".");
                        } ?></td>
        </tr>
        <tr>
            <td>&nbsp;Total Cicilan Periode Ini</td>
            <td>: Rp. <?php
                        if ($_totalCicilanPeriodeIni == NULL) {
                            $pot_cicilan = 0;
                            echo number_format($pot_cicilan, 0, ",", ".");
                        } else {
                            foreach ($_totalCicilanPeriodeIni as $key) {
                                $pot_cicilan = $key->Pot_Cicilan;
                                echo number_format($pot_cicilan, 0, ",", ".");
                            }
                        } ?></td>
        </tr>
        <tr>
            <td>&nbsp;Grand Total</td>
            <td>: Rp. <?php echo number_format($sisa + $ttl_periode_ini + $pot_cicilan, 0, ",", "."); ?></td>
        </tr>

    </table>
</page>