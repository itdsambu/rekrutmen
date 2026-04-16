<page style="font-size: 12px; font-family: freeserif;" backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
<?php
    foreach ($_getDetail as $row):
        $hdrid = $row->HeaderID;
    endforeach;
    $namafoto = 'dataupload/foto/'.$hdrid.'.jpg';
?>
    <table style="width: 100%;" border='1'>
        <tr>
            <td style="width: 25%;">
                <table cellspacing="0" style="width: 100%;">
                    <tr style="background: #CECECE">
                        <td></td>
                        <td valign="middle" style="width: 80%; font-size: 18px; font-weight: bold; text-align: center;"><?php echo $row->CVNama;?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table style="width: 100%;">
                                <tr>
                                    <td></td>
                                    <td>Reg. ID / NIK</td>
                                    <td>: <?php echo "#" .$row->HeaderID ;?> /  
                                        <?php
                                            if($row->NIK == NULL){
                                                echo ' ____________';
                                            }else{
                                                echo $row->NIK;
                                            }
                                        ?>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="width: 5px;"></td>
                                    <td style="width: 75px;">Nama</td>
                                    <td>: <?php echo substr($row->Nama,0,30);?> </td>
                                    <td style="width: 5px;"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Dept/Bag</td>
                                    <td>: </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Shift</td>
                                    <td>: </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td valign="middle" rowspan="6" style="width: auto; height: auto; text-align: center; border: black"> <img width="70" src="<?php echo base_url($namafoto); ?>"> </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr style="text-align: center">
                                    <td></td>
                                    <td><?php echo date('l, d-m-Y'); ?></td>
                                    <td></td>
                                </tr>
                                <tr style="text-align: center">
                                    <td></td>
                                    <td>&nbsp;</td>
                                    <td></td>
                                </tr>
                                <tr style="text-align: center">
                                    <td></td>
                                    <td>&nbsp;</td>
                                    <td></td>
                                </tr>
                                <tr style="text-align: center">
                                    <td></td>
                                    <td>____________</td>
                                    <td></td>
                                </tr>
                                <tr style="text-align: center">
                                    <td></td>
                                    <td><?php echo substr($row->Pemborong,0,30);?></td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</page>