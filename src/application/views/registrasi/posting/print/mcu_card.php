<page style="font-size: 12px; font-family: arial;" backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
    
    <table style="width: 100%; border: solid 1px black;">
        <tr>
            <td style="width: 100%;">
<?php
    foreach ($_getDetail as $row):
?>
    <table style="width: 100%;" >
        <tr>
            <td colspan="5" style="width: 100%; font-size: 18px; text-align: center; text-decoration: underline;">KARTU MEDICAL CHECK UP</td>
        </tr>
        <tr>
            <td style="width: 5%;"></td>
            <td rowspan="5"  style="width: 12%; height: 110px; border: solid 1px #000000; text-align: center;"> Photo </td>
            <td style="width: 15%;"></td>
            <td style="width: 13%;">NAMA</td>
            <td style="width: 55%;">: <?php echo $row->Nama;?> </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>NIK</td>
            <td>: ______________</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>DEPT/ BAG</td>
            <td>: <?php echo $row->DeptTujuan;?> </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>JABATAN</td>
            <td>: Opr </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>PEMBORONG</td>
            <td>: <?php echo $row->Pemborong;?> </td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
    </table>
    
    <table cellspacing="0" style="padding: 1px; width: 100%; font-size: 11px; text-align: center;">
        <tr>
            <td rowspan="2" style="width: 4%; border: solid 1px #000000;">NO</td>
            <td rowspan="2" style="width: 12%; border: solid 1px #000000;">MDC</td>
            <td rowspan="2" style="width: 12%; border: solid 1px #000000;">WIDAL</td>
            <td rowspan="2" style="width: 12%; border: solid 1px #000000;">DARAH RUTIN</td>
            <td rowspan="2" style="width: 12%; border: solid 1px #000000;">URINE</td>
            <td colspan="3" style="width: 36%; border: solid 1px #000000;">KIMIA DARAH</td>
            <td rowspan="2" style="width: 12%; border: solid 1px #000000;">KET</td>
        </tr>
        <tr>
            <td style="width: 12%; border: solid 1px #000000;">GULA</td>
            <td style="width: 12%; border: solid 1px #000000;">KOLESTEROL</td>
            <td style="width: 12%; border: solid 1px #000000;">ASAM URAT</td>
        </tr>
        <tr>
            <td style="border: solid 1px #000000;">1.</td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
        </tr>
        <tr>
            <td style="border: solid 1px #000000;">2.</td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
        </tr>
        <tr>
            <td style="border: solid 1px #000000;">3.</td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
        </tr>
        <tr>
            <td style="border: solid 1px #000000;">4.</td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
        </tr>
        <tr>
            <td style="border: solid 1px #000000;">5.</td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
        </tr>
        <tr>
            <td style="border: solid 1px #000000;">6.</td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
        </tr>
        <tr>
            <td style="border: solid 1px #000000;">7.</td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
        </tr>
        <tr>
            <td style="border: solid 1px #000000;">8.</td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
        </tr>
        <tr>
            <td style="border: solid 1px #000000;">9.</td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
        </tr>
        <tr>
            <td style="border: solid 1px #000000;">10.</td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
        </tr>
        <tr>
            <td style="border: solid 1px #000000;">11.</td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
        </tr>
        <tr>
            <td style="border: solid 1px #000000;">12.</td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
            <td style="border: solid 1px #000000;"></td>
        </tr>
    </table>
<?php endforeach;?>
            </td>
        </tr>
    </table>

</page>