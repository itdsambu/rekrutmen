<page style="font-size: 13px; font-family: freeserif;" backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
    <table style="width: 100%; border: solid 1px black;">
        <tr>
            <td style="width: 100%;">
<?php
    foreach ($_getDetail as $row):
?>
    <table style="width: 100%;">
        <tr>
            <td rowspan="2" align='center' style="width: 15%;">
                <img src="<?php echo base_url();?>assets/img/rsup-logo.png" width="70" height="70" alt="rsup-logo"/>
            </td>
            <td style="width: 70%;">&nbsp;</td>
            <td style="width: 15%;">Confidencial</td>
        </tr>
        <tr>
            <td style="width: 70%; text-align: center; font-size: 18px; font-weight: bold; text-decoration: underline;">
                MEDICAL CHECK UP
            </td>
            <td style="width: 15%;">&nbsp;</td>
        </tr>
    </table>
    <table style="width: 100%;">
        <tr>
            <td style="width: 5%; font-weight: bold;"></td>
            <td style="width: 15%;">NAMA</td>
            <td style="width: 32.5%;">: <?php echo $row->Nama;?></td>
            <td style="width: 15%;">BAGIAN</td>
            <td style="width: 32.5%;">: <?php echo $row->DeptTujuan." / ".$row->Pemborong;?></td>
        </tr>
        <tr>
            <td style="width: 5%; font-weight: bold;"></td>
            <td>UMUR</td>
            <td>: <?php echo $_umur;?></td>
            <td>PERUSAHAAN</td>
            <td>: PT. RSUP INDUSTRY</td>
        </tr>
    </table>
    <hr/>
    <table style="width: 100%;">
        <tr valign='top'>
            <td rowspan="8" style="width: 5%; font-weight: bold;" align='center'>I.</td>
            <td colspan="2" style="width: 30%; text-decoration: underline;">ANAMNESA</td>
            <td align='center'>YA</td>
            <td align='center'>TIDAK</td>
            <td colspan="2" style="width: 30%;"></td>
            <td align='center'>YA</td>
            <td align='center'>TIDAK</td>
        </tr>
        <tr>
            <td style="width: 3%;">1.</td>
            <td style="width: 27%;">Astmha Bronchale (sesak nafas berbunyi)</td>
            <td style="width: 8.75%; text-align: center;"><img src="<?php echo base_url();?>assets/img/UnChecked.PNG" width="16" height="16" alt="UnChecked"/></td>
            <td style="width: 8.75%; text-align: center;"><img src="<?php echo base_url();?>assets/img/UnChecked.PNG" width="16" height="16" alt="UnChecked"/></td>
            <td style="width: 3%;">5.</td>
            <td style="width: 27%;">TBC Paru (sering batuk dan batuk darah)</td>
            <td style="width: 8.75%; text-align: center;"><img src="<?php echo base_url();?>assets/img/UnChecked.PNG" width="16" height="16" alt="UnChecked"/></td>
            <td style="width: 8.75%; text-align: center;"><img src="<?php echo base_url();?>assets/img/UnChecked.PNG" width="16" height="16" alt="UnChecked"/></td>
        </tr>
        <tr>
            <td style="width: 3%;">2.</td>
            <td style="width: 27%;">Diabetes Melitus (Kencing Manis)</td>
            <td style="width: 8.75%; text-align: center;"><img src="<?php echo base_url();?>assets/img/UnChecked.PNG" width="16" height="16" alt="UnChecked"/></td>
            <td style="width: 8.75%; text-align: center;"><img src="<?php echo base_url();?>assets/img/UnChecked.PNG" width="16" height="16" alt="UnChecked"/></td>
            <td style="width: 3%;">6.</td>
            <td style="width: 27%;">Hepatities (Sakit Kuning)</td>
            <td style="width: 8.75%; text-align: center;"><img src="<?php echo base_url();?>assets/img/UnChecked.PNG" width="16" height="16" alt="UnChecked"/></td>
            <td style="width: 8.75%; text-align: center;"><img src="<?php echo base_url();?>assets/img/UnChecked.PNG" width="16" height="16" alt="UnChecked"/></td>
        </tr>
        <tr>
            <td style="width: 3%;">3.</td>
            <td style="width: 27%;">Eczeem (Eksim)</td>
            <td style="width: 8.75%; text-align: center;"><img src="<?php echo base_url();?>assets/img/UnChecked.PNG" width="16" height="16" alt="UnChecked"/></td>
            <td style="width: 8.75%; text-align: center;"><img src="<?php echo base_url();?>assets/img/UnChecked.PNG" width="16" height="16" alt="UnChecked"/></td>
            <td style="width: 3%;">7.</td>
            <td style="width: 27%;">Hernia (Burut/usus turun)</td>
            <td style="width: 8.75%; text-align: center;"><img src="<?php echo base_url();?>assets/img/UnChecked.PNG" width="16" height="16" alt="UnChecked"/></td>
            <td style="width: 8.75%; text-align: center;"><img src="<?php echo base_url();?>assets/img/UnChecked.PNG" width="16" height="16" alt="UnChecked"/></td>
        </tr>
        <tr>
            <td style="width: 3%;">4.</td>
            <td style="width: 27%;">Ulcus pepticus (tukak lambung/ muntah darah)</td>
            <td style="width: 8.75%; text-align: center;"><img src="<?php echo base_url();?>assets/img/UnChecked.PNG" width="16" height="16" alt="UnChecked"/></td>
            <td style="width: 8.75%; text-align: center;"><img src="<?php echo base_url();?>assets/img/UnChecked.PNG" width="16" height="16" alt="UnChecked"/></td>
            <td style="width: 3%;">8.</td>
            <td style="width: 27%;">Haemorheid (Berak darah menetes/ wasir)</td>
            <td style="width: 8.75%; text-align: center;"><img src="<?php echo base_url();?>assets/img/UnChecked.PNG" width="16" height="16" alt="UnChecked"/></td>
            <td style="width: 8.75%; text-align: center;"><img src="<?php echo base_url();?>assets/img/UnChecked.PNG" width="16" height="16" alt="UnChecked"/></td>
        </tr>
        <tr>
            <td style="width: 3%;"></td>
            <td style="width: 27%;"></td>
            <td style="width: 8.75%;"></td>
            <td style="width: 8.75%;"></td>
            <td style="width: 3%;">9.</td>
            <td style="width: 27%;">Epilepsi</td>
            <td style="width: 8.75%; text-align: center;"><img src="<?php echo base_url();?>assets/img/UnChecked.PNG" width="16" height="16" alt="UnChecked"/></td>
            <td style="width: 8.75%; text-align: center;"><img src="<?php echo base_url();?>assets/img/UnChecked.PNG" width="16" height="16" alt="UnChecked"/></td>
        </tr>
        <tr>
            <td rowspan="2" colspan="5" style="width: 50.5%;">
                Keterangan diatas adalah benar, apabila dalam jangka waktu 1 (satu) tahun ditemukan penyakit/ hal tersebut kecuali item 1,2,3 
            (tidak ada batas waktu) saya bersedia menerima tindakan/ sanksi dari perusahaan
            </td>
            <td colspan="3" style="width: 44.5%;" align='center'>Saya yang menyatakan</td>
        </tr>
        <tr>
            <td colspan="3" style="width: 44.5%; font-weight: bold; text-decoration: underline;" align='center'>( <?php echo ucwords(strtolower($row->Nama));?> )</td>
        </tr>
        <tr>
            <td style="font-weight: bold;" align='center' valign='top'></td>
            <td colspan="8"><hr/></td>
        </tr>
        <tr>
            <td rowspan="2" style="font-weight: bold;" align='center' valign='top'>II.</td>
            <td colspan="2">Tinggi Badan</td>
            <td colspan="2">cm.</td>
            <td colspan="3">Tekanan Darah</td>
            <td>mmhg</td>
        </tr>
        <tr>
            <td colspan="2">Berat Badan</td>
            <td colspan="2">kg.</td>
            <td colspan="3">Denyut Nadi</td>
            <td>x/menit</td>
        </tr>
        <tr>
            <td style="font-weight: bold;" align='center' valign='top'></td>
            <td colspan="8"><hr/></td>
        </tr>
        <tr>
            <td rowspan="16" style="font-weight: bold;" align='center' valign='top'>III.</td>
            <td colspan="8" style="text-decoration: underline;">PEMERIKSAAN FISIK</td>
        </tr>
        <tr>
            <td>1.</td>
            <td>Keadaan Umum</td>
            <td align='center'>:</td>
            <td colspan="5">__________________________________________</td>
        </tr>
        <tr>
            <td>2.</td>
            <td>Kepala</td>
            <td align='center'>:</td>
            <td colspan="5">__________________________________________</td>
        </tr>
        <tr>
            <td>3.</td>
            <td>Mata</td>
            <td align='center'>:</td>
            <td colspan="5">__________________________________________</td>
        </tr>
        <tr>
            <td></td>
            <td>a. Jarak Pandang</td>
            <td align='center'>:</td>
            <td colspan="5">__________________________________________</td>
        </tr>
        <tr>
            <td></td>
            <td>b. Buta Warna</td>
            <td align='center'>:</td>
            <td colspan="5">__________________________________________</td>
        </tr>
        <tr>
            <td>4.</td>
            <td>Hidung</td>
            <td align='center'>:</td>
            <td colspan="5">__________________________________________</td>
        </tr>
        <tr>
            <td>5.</td>
            <td>Gigi/ Rongga Mulut</td>
            <td align='center'>:</td>
            <td colspan="5">__________________________________________</td>
        </tr>
        <tr>
            <td>6.</td>
            <td>Telinga</td>
            <td align='center'>:</td>
            <td colspan="5">__________________________________________</td>
        </tr>
        <tr>
            <td>7.</td>
            <td>Leher</td>
            <td align='center'>:</td>
            <td colspan="5">__________________________________________</td>
        </tr>
        <tr>
            <td>8.</td>
            <td>Paru-paru</td>
            <td align='center'>:</td>
            <td colspan="5">__________________________________________</td>
        </tr>
        <tr>
            <td>9.</td>
            <td>Jantung</td>
            <td align='center'>:</td>
            <td colspan="5">__________________________________________</td>
        </tr>
        <tr>
            <td>10.</td>
            <td>Hati dan Limpa</td>
            <td align='center'>:</td>
            <td colspan="5">__________________________________________</td>
        </tr>
        <tr>
            <td>11.</td>
            <td>Perut</td>
            <td align='center'>:</td>
            <td colspan="5">__________________________________________</td>
        </tr>
        <tr>
            <td>12.</td>
            <td>Anus dan Kelamin</td>
            <td align='center'>:</td>
            <td colspan="5">__________________________________________</td>
        </tr>
        <tr>
            <td>13.</td>
            <td>Anggota Badan</td>
            <td align='center'>:</td>
            <td colspan="5">__________________________________________</td>
        </tr>
        <tr>
            <td style="font-weight: bold;" align='center' valign='top'></td>
            <td colspan="8"><hr/></td>
        </tr>
        <tr>
            <td rowspan="2" style="font-weight: bold;" align='center' valign='top'>IV.</td>
            <td colspan="8" style="text-decoration: underline;">PEMERIKSAAN KHUSUS</td>
        </tr>
        <tr>
            <td align='center'>-</td>
            <td>Drug Testing</td>
            <td align='center'>:</td>
            <td colspan="5">__________________________________________</td>
        </tr>
        <tr>
            <td style="font-weight: bold;" align='center' valign='top'></td>
            <td colspan="8"><hr/></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Kesimpulan</td>
            <td align='center'>:</td>
            <td colspan="5">_______________________&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pulau Burung, </td>
        </tr>
    </table>
    <br/>
    <br/>
    <table style="width: 100%;">
        <tr>
            <td style="width: 70%;">Catatan/ Pesan Klinik :</td>
            <td style="width: 20%; text-align: center;"></td>
        </tr>
        <tr>
            <td>__________________________________________</td>
        </tr>
        <tr>
            <td>__________________________________________</td>
        </tr>
        <tr>
            <td>__________________________________________</td>
            <td rowspan="5" style="text-align: center; text-decoration: underline;">Ka. Poliklinik</td>
        </tr>
        
    </table>
    <br/>
    <br/>
<?php
    endforeach; 
?>
                <br/><br/><br/>
            </td>
        </tr>
    </table>
    <table style="width: 100%; border: solid 1px black;">
        <tr>
            <td style="text-align: left;    width: 50%">Tanggal Efektif : 27 Januari 2014</td>
            <td style="text-align: right;    width: 50%">FRM-HRD-002-01</td>
        </tr>
    </table>
</page>