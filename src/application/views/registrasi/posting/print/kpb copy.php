<page style="font-size: 12px; font-family: freeserif;" backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
<?php
    foreach ($_getDetail as $row):
?>
    <table style="width: 100%;" border='1'>
        <tr>
            <td style="width: 45%;" valign='top'>
                <table cellspacing="0" style="width: 100%;">
                    <tr>
                        <td style="width: 20%; height: 40px; border: black; text-align: center;">
                            <img src="<?php echo base_url();?>assets/img/kpb-logo.png" width="45" height="40" alt="kpb-logo"/>
                        </td>
                        <td valign="middle" style="width: 80%; border: black; font-size: 18px; font-weight: bold; text-align: center;"><?php echo $row->CVNama;?></td>
                    </tr>
                    <tr>
                        <td style="text-decoration: underline; text-align: center;" colspan="2">KARTU PENGANTAR BEROBAT</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table style="width: 100%;">
                                <tr>
                                    <td valign="middle" rowspan="6" style="width: 60px; height: 80px; text-align: center; border: black;"> Photo </td>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="width: 5px;"></td>
                                    <td style="width: 75px;">Nama</td>
                                    <td>: <?php echo substr($row->Nama,0,15);?> </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>NIK</td>
                                    <td>: 
                                        <?php
                                            if($row->NIK == NULL){
                                                echo ' ____________';
                                            }else{
                                                echo $row->NIK;
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Tanggal Lahir</td>
                                    <td>: <?php echo date('d M Y', strtotime($row->Tgl_Lahir));?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Dept/Bag</td>
                                    <td>: <?php echo $row->DeptTujuan;?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>&nbsp;</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3">&nbsp;</td>
                                    <td style="width: 120px; text-align: center;">Tanda Tangan</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 10%; text-align: center;">-</td>
            <td style="width: 45%; height: 190px;" valign='top'>
                <table cellspacing="0" style="width: 100%;">
                    <tr>
                        <td style="width: 70%;">DAFTAR KELUARGA</td>
                        <td style="width: 30%; font-weight: bold;">No. FF : ______</td>
                    </tr>
                </table>
                <br/>
                <table cellspacing="0" style="width: 100%;">
                    <tr>
                        <td style="width: 20%;"></td>
                        <td style="width: 35%; font-weight: bold;">&nbsp;&nbsp;Nama</td>
                        <td style="width: 10%; text-align: center; font-weight: bold;">L/P</td>
                        <td style="width: 35%; font-weight: bold;">Tgl. Lahir</td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">Istri/Suami</td>
                        <td style="width: 35%;">: 
                            <?php 
                                if($row->NamaSuamiIstri == " "){
                                    echo ' _________';
                                }else{
                                    echo ucwords(strtolower(substr($row->NamaSuamiIstri, 0, 15)));
                                }
                            ?>
                        </td>
                        <td style="width: 10%; text-align: center;">
                            <?php 
                                if($row->NamaSuamiIstri == " "){
                                    echo ' L/P';
                                }elseif($row->Jenis_Kelamin == 'M'){
                                    echo ' P';
                                }else{
                                    echo ' L';
                                }
                            ?>
                        </td>
                        <td style="width: 35%;"> 
                            <?php 
                                if($row->TglLahirSuamiIstri == NULL){
                                    echo ' _________';
                                }else{
                                    echo date('d M Y',strtotime($row->TglLahirSuamiIstri));
                                }
                            ?>
                        </td>
                    </tr>
                    
                    <?php if($row->JumlahAnak == 0):?>
                    <tr>
                        <td style="width: 20%;">Anak Ke 1</td>
                        <td style="width: 35%;">: _________</td>
                        <td style="width: 10%; text-align: center;">L/P</td>
                        <td style="width: 35%;"> _________</td>
                    </tr>
                    <?php else:?>
                    <?php
                    $no=1;
                    foreach ($_getAnak as $rowAnak): ?>
                    <tr>
                        <td style="width: 20%;">Anak Ke <?php echo $no++;?></td>
                        <td style="width: 35%;">: <?php echo $rowAnak->Nama;?></td>
                        <td style="width: 10%; text-align: center;"><?php if($rowAnak->JenisKelamin == 'M'){echo "L";}else{echo "P";}?></td>
                        <td style="width: 35%;"> <?php echo date('d M Y',  strtotime($rowAnak->TglLahir));?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif;?>
                    
                </table>
                <br/>
                <br/>
                <table cellspacing="0" style="width: 100%;">
                    <tr>
                        <td colspan="2">PERHATIAN:</td>
                    </tr>
                    <tr>
                        <td style="width: 4%; text-align: center;"> - </td>
                        <td style="width: 96%; font-size: 11px;"> Tiap kali berobat harus membawa kartu ini. </td>
                    </tr>
                    <tr>
                        <td style="width: 4%; text-align: center;"> - </td>
                        <td style="width: 96%; font-size: 11px;"> Penyalahgunaan bagi yang tidak berhak dan berobat tanpa membawa kartu ini akan dikenakan biaya pengobatan. </td>
                    </tr>
                    <tr>
                        <td style="width: 4%; text-align: center;"> - </td>
                        <td style="width: 96%; font-size: 11px;">Bila kartu ini hilang harap segera lapor ke Adm. Pemborong.</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
<?php endforeach; ?>
</page>