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
    <table style="font-size: 15px; font-family: Arial;" backtop="7mm" backbottom="10mm" backleft="5mm" backright="5mm">
        <tr>
            <td style="text-align: center;"><strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MONITORING CICILAN </strong></td>
        </tr>
    </table>
    <br>
    <br>
    <table class="tbl1" style="font-size: 9px; font-family: Arial;" backtop="7mm" backbottom="10mm" backleft="3mm" backright="3mm">
        <tr>
            <td style="width: 2%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; font-weight: bold;">No.</td>
            <td style="width: 4%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; font-weight: bold;">FixNo</td>
            <td style="width: 8%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; font-weight: bold;">Nama</td>
            <td style="width: 4%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; font-weight: bold;">Nik</td>
            <td style="width: 4%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; font-weight: bold;">Dept</td>
            <td style="width: 5%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; font-weight: bold;">Tanggal</td>
            <td style="width: 8%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; font-weight: bold;">Item Cicilan</td>
            <td style="width: 3%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; font-weight: bold;">Qty</td>
            <td style="width: 8%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; font-weight: bold;">Harga Total</td>
            <td style="width: 5%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; font-weight: bold;">DP</td>
            <td style="width: 5%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; font-weight: bold;">Harga Yang Harus Dibayar</td>
            <td style="width: 5%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; font-weight: bold;">Jumlah Periode Cicilan (x)</td>
            <td style="width: 5%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; font-weight: bold;">Periode Potong</td>
            <td style="width: 5%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; font-weight: bold;">Nominal Cicilan</td>
            <td style="width: 5%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; font-weight: bold;">Total Periode Yang Sudah Tercicil (x)</td>
            <td style="width: 5%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; font-weight: bold;">Total Periode Yang Belum Tercicil (x)</td>
            <td style="width: 5%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; font-weight: bold;">Sisa Cicilan Yang Harus Dilunasi</td>

        </tr>
        <?php 
        $no = 1;
        foreach($_getDataTrnCicilanhdr as $get){?>
        <tr>
            <td style="width: 2%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; "><?php echo $no++;?></td>
            <td style="width: 4%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; "><?php echo $get->Nofix;?></td>
            <td style="width: 8%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; "><?php echo $get->Nama;?></td>
            <td style="width: 4%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; "><?php echo $get->Nik;?></td>
            <td style="width: 4%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; "><?php echo $get->Bagian;?></td>
            <td style="width: 5%; border-right: 1;border-bottom: 1;text-align: center;height: 15px; ">
                <table class="table table-bordered">
                    <?php foreach($_getDataTrnCicilan as $key){
                    if($get->Nofix == $key->Nofix){?>
                        <tr>
                            <td style="width: 100%; border-right: 1;border-left: 1;border-bottom: 1;border-top: 1;text-align: center;height: 15px; "><?php echo date('d-M-Y',strtotime($key->Tanggal));?></td>
                        </tr>
                    <?php }}?>
                </table>
            </td>
            <td style="width: 8%; border-right: 1;border-bottom: 1;text-align: center;height: 30px;">
                <table class="table table-bordered">
                    <?php foreach($_getDataTrnCicilan as $key){
                    if($get->Nofix == $key->Nofix){?>
                        <tr>
                            <td style="width: 90px; border-right: 1;border-left: 1;border-bottom: 1;border-top: 1;text-align: center;height: 15px; "><?php echo $key->NamaCicilan;?></td>
                        </tr>
                    <?php }}?>
                </table>
            </td>
            <td style="width: 3%; border-right: 1;border-bottom: 1;text-align: center;height: 30px;">
                <table class="table table-bordered">
                    <?php foreach($_getDataTrnCicilan as $key){
                    if($get->Nofix == $key->Nofix){?>
                        <tr>
                            <td style="width: 20px; border-right: 1;border-left: 1;border-bottom: 1;border-top: 1;text-align: center;height: 15px; "><?php echo $key->Quantity;?></td>
                        </tr>
                    <?php }}?>
                </table>
            </td>
            <td style="width: 8%; border-right: 1;border-bottom: 1;text-align: center;height: 30px;">
                <table class="table table-bordered">
                <?php foreach($_getDataTrnCicilan as $key){
                    if($get->Nofix == $key->Nofix){?>
                        <tr>
                            <td style="width: 50px; border-right: 1;border-left: 1;border-bottom: 1;border-top: 1;text-align: center;height: 15px; ">Rp.<?php echo number_format($key->Harga,0,",",".");?></td>
                        </tr>
                    <?php }}?>
                </table>
            </td>
            <td style="width: 5%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; ">
                <table class="table table-bordered">
                <?php foreach($_getDataTrnCicilan as $key){
                    if($get->Nofix == $key->Nofix){?>
                        <tr>
                            <td style="width: 100%; border-right: 1;border-left: 1;border-bottom: 1;border-top: 1;text-align: center;height: 15px; ">Rp.<?php echo number_format($key->DP,0,",",".");?></td>
                        </tr>
                    <?php }}?></table>
            </td>
            <td style="width: 5%; border-right: 1;border-bottom: 1;text-align: center;height: 30px;">
                <table class="table table-bordered">
                <?php foreach($_getDataTrnCicilan as $key){
                    if($get->Nofix == $key->Nofix){?>
                        <tr>
                            <td style="width: 100%; border-right: 1;border-left: 1;border-bottom: 1;border-top: 1;text-align: center;height: 15px; ">Rp.<?php echo number_format($key->Harga - $key->DP,0,",",".");?></td>
                        </tr>
                    <?php }}?>
                </table>
            </td>
            <td style="width: 5%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; ">
                <table class="table table-bordered">
                    <?php foreach($_getDataTrnCicilan as $key){
                        if($get->Nofix == $key->Nofix){?>
                            <tr>
                                <td  style="width: 20px; border-right: 1;border-left: 1;border-bottom: 1;border-top: 1;text-align: center;height: 15px; "><?php echo $key->Cicilan;?></td>
                            </tr>
                        <?php }
                    }?>
                </table>
            </td>
            <td style="width: 5%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; ">
                <table class="table table-bordered">
                    <?php foreach($_getDataTrnCicilan as $key){
                        if($get->Nofix == $key->Nofix){?>
                            
                            <tr>
                                <td style="width: 40px; border-right: 1;border-left: 1;border-bottom: 1;border-top: 1;text-align: center;height: 15px; "><?php if($key->PeriodeDipotong == 1){
                                        echo "1";
                                    }elseif($key->PeriodeDipotong == 2){
                                        echo "2";
                                    }else{
                                        echo "1 dan 2";
                                    }?> 
                                </td>
                            </tr>
                        <?php }
                    }?>
                </table>
            </td>
            <td style="width: 5%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; ">
                <table class="table table-bordered">
                    <?php foreach($_getDataTrnCicilan as $key){
                        if($get->Nofix == $key->Nofix){?>
                            <tr>
                                <td style="width: 100%; border-right: 1;border-left: 1;border-bottom: 1;border-top: 1;text-align: center;height: 15px; ">Rp.<?php echo number_format($key->HargaCicilan,0,",",".");?></td>
                            </tr>
                        <?php }
                    }?>
                </table>
            </td>
            <td style="width: 5%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; ">
                <table class="table table-bordered">
                    <?php foreach($_getDataTrnCicilan as $key){
                        if($get->Nofix == $key->Nofix){?>
                            <tr>
                                <td style="width: 20px; border-right: 1;border-left: 1;border-bottom: 1;border-top: 1;text-align: center;height: 15px; "><?php if($key->JmlCicilanLunas == NULL){echo "0";}else{echo $key->JmlCicilanLunas;};?></td>
                            </tr>
                        <?php }
                    }?>
                </table>
            </td>
            <td style="width: 5%; border-right: 1;border-bottom: 1;text-align: center;height: 30px;">
                <table class="table table-bordered">
                    <?php foreach($_getDataTrnCicilan as $key){
                        if($get->Nofix == $key->Nofix){?>
                            <tr>
                                <td style="width: 20px; border-right: 1;border-left: 1;border-bottom: 1;border-top: 1;text-align: center;height: 15px; "><?php if($key->Durasi == NULL){echo "0";}else{echo $key->Durasi;};?></td>
                            </tr>
                        <?php }
                    }?>
                </table>
            </td>
            <td style="width: 5%; border-right: 1;border-bottom: 1;text-align: center;height: 30px; ">
                <table class="table table-bordered">
                    <?php foreach($_getDataTrnCicilan as $key){
                        if($get->Nofix == $key->Nofix){?>
                            <tr>
                                <td style="width: 100%; border-right: 1;border-left: 1;border-bottom: 1;border-top: 1;text-align: center;height: 15px; ">Rp.<?php echo number_format($key->Harga - $key->dipotong,0,",",".");?></td>
                            </tr>
                        <?php }
                    }?>
                </table>
            </td>
        </tr>
        <?php }?>
    </table>
</page>