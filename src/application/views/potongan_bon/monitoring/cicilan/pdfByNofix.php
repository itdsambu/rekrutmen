<style type="text/css">
    .hdr{
        width: 100%;
    }
    .kop{
        font-size: 25px;
        width: 85%;
        text-align: center;

    }
    .judul{
        font-size: 30px;
        font-weight: bold;
        text-align: center;
    }
    .tbl2{
        width: 100%;
        border-top: 1;
        border-bottom: 1;
        border-right: 3;
        border-left: 3;
        border-spacing: 0;
        border-style: dotted;
    }
    .txt1{
        font-size: 12;
    }
    .tbl1{
        width: 100%;
        border: 1;
    }
    .tbl3{
        width: 100%;
    }
    .font {
        font-family: Times New Roman, Helvetica, sans-serif;
        font-size: 12;
        text-align: justify;
    }
</style>

<page style="font-size: 15px; font-family: Arial;" backtop="7mm" backbottom="10mm" backleft="5mm" backright="5mm">
    <table>
        <tr>
            <td style="text-align: center;"><strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REKAP CICILAN TENAGA KERJA </strong></td>
        </tr>
    </table>
    <br>
    <br>
    <table>
        <tr>
            <td style="text-align: justify;"> Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $_getDataTrnCicilan->Nama;?></td>
        </tr>
        <tr>
            <!-- <td style="text-align: justify;"> Nofix &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $_getDataTrnCicilan->Nofix;?></td> -->
        </tr>
        <tr>
            <td style="text-align: justify;"> NIK &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $_getDataTrnCicilan->Nik;?></td>
        </tr>
        <tr>
            <td style="text-align: justify;"> Departemen  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $_getDataTrnCicilan->BagianAbbr;?></td>
        </tr>
        <tr>
            <td style="text-align: justify;"> Pemborong &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $_getDataTrnCicilan->Pemborong;?></td>
        </tr>
        <tr>
            <td style="text-align: justify;"> CV. Perusahaan  &nbsp;:&nbsp;<?php echo $_getDataTrnCicilan->Perusahaan;?></td>
        </tr>
    </table>
    <br>
    
    <table class="tbl1" style="font-size: 9px; font-family: Arial;" backtop="7mm" backbottom="10mm" backleft="5mm" backright="5mm">
        <tr>
            <td style="width: 3%; border-right: 1;border-top: 1;border-left: 1;text-align: center;height: 30px; font-weight: bold;">No.</td>
            <td style="width: 8%; border-right: 1;border-top: 1;text-align: center;height: 30px; font-weight: bold;">Tanggal</td>
            <td style="width: 15%; border-right: 1;border-top: 1;text-align: center;height: 30px; font-weight: bold;">Nama Cicilan</td>
            <td style="width: 3%; border-right: 1;border-top: 1;text-align: center;height: 30px; font-weight: bold;">Qty</td>
            <td style="width: 10%; border-right: 1;border-top: 1;text-align: center;height: 30px; font-weight: bold;">Harga Total</td>
            <td style="width: 10%; border-right: 1;border-top: 1;text-align: center;height: 30px; font-weight: bold;">DP</td>
            <td style="width: 10%; border-right: 1;border-top: 1;text-align: center;height: 30px; font-weight: bold;">Harga Yang Harus Dibayar</td>
            <td style="width: 5%; border-right: 1;border-top: 1;text-align: center;height: 30px; font-weight: bold;">Jumlah Periode Cicilan (x)</td>
            <td style="width: 8%; border-right: 1;border-top: 1;text-align: center;height: 30px; font-weight: bold;">Periode Potong</td>
            <td style="width: 8%; border-right: 1;border-top: 1;text-align: center;height: 30px; font-weight: bold;">Nominal Cicilan</td>
            <td style="width: 6%; border-right: 1;border-top: 1;text-align: center;height: 30px; font-weight: bold;">Total Periode Yang Sudah Tercicil (x)</td>
            <td style="width: 6%; border-right: 1;border-top: 1;text-align: center;height: 30px; font-weight: bold;">Total Periode Yang Belum Tercicil (x)</td>
            <td style="width: 8%; border-right: 1;border-top: 1;text-align: center;height: 30px; font-weight: bold;">Sisa Cicilan Yang Harus Dilunasi</td>
        </tr>
         <?php 
            $no=1;

            foreach ($_getDataTrnCicilanDtl as $key) {?>
                <tr>
                    <td style="width: 3%; border-right: 1;text-align: center;border-top: 1;border-left: 1;border-bottom: 1"><?php echo $no++;?></td>
                    <td style="width: 8%; border-right: 1;border-top: 1;border-bottom: 1;text-align: center;"><?php echo date('d-m-Y',strtotime($key->Tanggal))?></td>
                    <td style="width: 15%; border-right: 1;border-top: 1;border-bottom: 1;text-align: left"><?php echo $key->NamaCicilan?></td>
                    <td style="width: 3%; border-right: 1;border-top: 1;border-bottom: 1;text-align: center"><?php echo $key->Quantity?></td>
                    <td style="width: 10%; border-right: 1;border-top: 1;border-bottom: 1;text-align: center">Rp.<?php echo number_format($key->Harga ,0,",",".");?>
                    </td>
                    <td style="width: 10%; border-right: 1;border-top: 1;border-bottom: 1;text-align: center">Rp.<?php echo number_format($key->DP ,0,",",".");?></td>
                    <td style="width: 10%; border-right: 1;border-top: 1;border-bottom: 1;text-align: center">Rp.<?php echo number_format($key->Harga - $key->DP ,0,",",".");?></td>
                    <td style="width: 5%; border-right: 1;border-top: 1;border-bottom: 1;text-align: center"><?php echo number_format($key->Cicilan ,0,",",".");?></td>
                    <td style="width: 8%; border-right: 1;border-top: 1;border-bottom: 1;text-align: center"><?php if($key->PeriodeDipotong == 1){
                                    echo "1";
                                }elseif($key->PeriodeDipotong == 2){
                                    echo "2";
                                }else{
                                    echo "1 dan 2";
                                }?> </td>
                    <td style="width: 8%; border-right: 1;border-top: 1;border-bottom: 1;text-align: center">Rp.<?php echo number_format($key->HargaCicilan ,0,",",".");?></td>
                    <td style="width: 6%; border-right: 1;border-top: 1;border-bottom: 1;text-align: center"><?php if($key->JmlCicilanLunas == NULL){echo "0";}else{echo $key->JmlCicilanLunas;};?></td>
                    <td style="width: 6%; border-right: 1;border-top: 1;border-bottom: 1;text-align: center"><?php if($key->Durasi == NULL){echo "0";}else{echo $key->Durasi;};?></td>
                    <td style="width: 8%; border-right: 1;border-top: 1;border-bottom: 1;text-align: center">Rp.<?php echo number_format($key->Harga - $key->dipotong,0,",",".");?></td>
                </tr>
            <?php }
         ?>
         
    </table>
</page>