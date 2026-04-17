
<?php
$Sisa = 0;
 foreach ($_getDataCicilan as $get) {
    if ($_getDataCicilan->DiPotongPeriodeIni_Sembako > '200000') {
        $Sisa = $_getDataCicilan->Sisa_periode_sebelumnya;
    }
    else {
        $Sisa = $_getDataCicilan->Sisa_PeriodeSebelumnya_tkbaru;
    }
} ?>
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
            <td style="text-align: justify;"> Periode &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo date('d-m-Y',strtotime($_getDataCicilan->PeriodeGajian))?></td>
        </tr>
        <tr>
            <td style="text-align: justify;"> Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $_getDataCicilan->Nama;?></td>
        </tr>
        <tr>
            <!-- <td style="text-align: justify;"> Nofix &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $_getDataCicilan->FixNo;?></td> -->
        </tr>
        <tr>
            <td style="text-align: justify;"> NIK &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $_getDataCicilan->Nik;?></td>
        </tr>
        <tr>
            <td style="text-align: justify;"> Departemen  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $_getDataCicilan->BagianAbbr;?></td>
        </tr>
        <tr>
            <td style="text-align: justify;"> Pemborong &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $_getDataCicilan->Pemborong;?></td>
        </tr>
        <tr>
            <td style="text-align: justify;"> CV. Perusahaan  &nbsp;:&nbsp;<?php echo $_getDataCicilan->Perusahaan;?></td>
        </tr>
    </table>
    <br>
    <table class="tbl1" style="font-size: 9px; font-family: Arial;" backtop="7mm" backbottom="10mm" backleft="5mm" backright="5mm">
        <tr>
            <td style="width: 5%; border-right: 1;text-align: center;height: 30px; font-weight: bold;">No.</td>
            <td style="width: 15%; border-right: 1;text-align: center;height: 30px; font-weight: bold;">Tanggal</td>
            <td style="width: 30%; border-right: 1;text-align: center;height: 30px; font-weight: bold;">Nama Sembako</td>
            <td style="width: 5%; border-right: 1;text-align: center;height: 30px; font-weight: bold;">Qty</td>
            <td style="width: 15%; border-right: 1;text-align: center;height: 30px; font-weight: bold;">Sembako</td>
        </tr>
         <?php 
            $no=1;
             $total_sembako_all = 0;
             $total_cicilan_all = 0;

            foreach ($getDataPemborong as $key) {?>
                <tr>
                    <td style="width: 5%; border-right: 1;text-align: center;border-top: 1;height: 15px;"><?php echo $no++;?></td>
                    <td style="width: 15%; border-right: 1;border-top: 1;text-align: center;height: 15px;"><?php echo date('d-m-Y',strtotime($key->Tanggal))?></td>
                    <td style="width: 50%; border-right: 1;border-top: 1;text-align: left"><?php echo $key->NamaItem?></td>
                    <td style="width: 5%; border-right: 1;border-top: 1;text-align: center"><?php echo $key->Quantity?></td>
                    <td style="width: 15%; border-right: 1;border-top: 1;text-align: center">Rp.<?php echo number_format($key->Total_s ,0,",",".");?></td>
                </tr>
            <?php }
         ?>
         <tr>
            <td colspan="4" style="border-right: 1;border-top: 1;text-align: center;height: 10px;"> Total </td>
            
            <td style="width: 15%;border-right: 1;border-top: 1;border-bottom: 1;text-align: center; font-weight: bold;height: 10px;">Rp.<?php echo number_format($_getDataCicilan->Pot_Sembako ,0,",",".");?></td>
        </tr>
        <tr>
            <td colspan="4" style="width: 50%; border-right: 1;border-top: 1;border-left: 1;border-bottom: 1;text-align: center;height: 10px; font-weight: bold;">Sisa periode sebelumnya </td>
            <td style="width: 15%; border-right: 1;border-top: 1;height: 10px;border-bottom: 1;text-align: center">Rp.<?php echo number_format( $Sisa ,0,",",".");?></td>    
        </tr> 
        <tr>
            <td colspan="4" style="width: 50%; border-right: 1;border-top: 1;border-left: 1;border-bottom: 1;text-align: center;height: 10px; font-weight: bold;">Grand Total</td>
            <td style="width: 15%; border-right: 1;border-top: 1;height: 10px;border-bottom: 1;text-align: center">Rp.<?php echo number_format( $Sisa + $_getDataCicilan->Pot_Sembako ,0,",",".");?></td>    
        </tr> 
        <tr>
            <td colspan="4" style="width: 50%; border-right: 1;border-top: 1;border-left: 1;border-bottom: 1;text-align: center;height: 10px; font-weight: bold;">Total Dipotong </td>
            <td style="width: 15%; border-right: 1;border-top: 1;height: 10px;border-bottom: 1;text-align: center">Rp.<?php echo number_format($_getDataCicilan->DiPotongPeriodeIni_Sembako + $_getDataCicilan->DiPotongPeriodeIni_Cicilan ,0,",",".");?></td>    
        </tr> 
        <tr>
            <td colspan="4" style="width: 50%; border-right: 1;border-top: 1;border-left: 1;border-bottom: 1;text-align: center;height: 10px; font-weight: bold;">Sisa Potongan </td>
            <td style="width: 15%; border-right: 1;border-top: 1;height: 10px;border-bottom: 1;text-align: center">
                <?php 
                    if(($_getDataCicilan->Pot_Sembako + $_getDataCicilan->Pot_Cicilan) +  $Sisa - ($_getDataCicilan->DiPotongPeriodeIni_Sembako + $_getDataCicilan->DiPotongPeriodeIni_Cicilan) < 0){
                        echo "Rp. 0";
                    }else{
                        echo "Rp. ".number_format(($_getDataCicilan->Pot_Sembako + $_getDataCicilan->Pot_Cicilan) +  $Sisa - ($_getDataCicilan->DiPotongPeriodeIni_Sembako + $_getDataCicilan->DiPotongPeriodeIni_Cicilan)  ,0,",",".");
                    }?>
            </td>  
        </tr> 
    </table>
</page>