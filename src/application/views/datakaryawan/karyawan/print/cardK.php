<page style="font-size: 12px; font-family: arial;" backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
<?php
    foreach ($_getDetail as $row):
	$nik = $row->NIK;
	endforeach;
	$namafoto = 'dataupload/Blacklist/'.trim($nik).'.jpg';
?>
    <table style="width: 100%; border: solid 1px black;">
        <tr>
            <td style="width: 100%;">
<?php
    foreach ($_getDetail as $row):
?>
      <table style="width: 100%;" >
        <tr> 
          <td colspan="4" style="width: 100%; font-size: 18px; text-align: center; text-decoration: underline;">Data 
            Karyawan</td>
        </tr>
        <tr> 
          <td colspan="4" style="width: 5%; height: 110px; border: solid 0px #000000; text-align: center;"> 
          <!-- foto tidak bisa muncul karena narik file menggunakan nik bukan regno -->
            <!-- <img id="avatar" width="180" height="180" src="<?php echo base_url($namafoto);?>" />  -->
          </td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;" colspan="4">&nbsp;</td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;" colspan="4">&nbsp;</td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;" colspan="4">&nbsp;</td>
        </tr>
        <tr> 
          <td width="26%" style="border: solid 0px #000000;">NAMA</td>
          <td width="74%" colspan="2" style="border: solid 0px #000000;">: <?php echo $row->NAMA;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">No. KTP</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->NoKTP;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Jenis Kelamin</td>
          <td style="border: solid 0px #000000;">: 
            <?php if($row->Sex == 'L'){echo 'Laki-laki';}else{echo 'Perempuan';}?>
          </td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Tempat/Tanggal Lahir</td>
          <td style="border: solid 0px #000000;">: <?php echo ucwords(strtolower($row->TEMPATLHR)).' / '.date('M, d Y',  strtotime($row->TGLLAHIR));?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Umur</td>
          <td style="border: solid 0px #000000;">: <?php echo $_umur;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Phone</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->NoHP;?></td>
        </tr>
		<tr> 
          <td style="border: solid 0px #000000;">Alamat</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->ALAMATS;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Status</td>
          <td style="border: solid 0px #000000;">: 
            <?php if($row->STS == 1){echo 'Bujang';} elseif($row->STS == 2){echo 'Gadis';}  elseif($row->STS == 3){echo 'Duda';} elseif($row->STS == 4){echo 'Janda';} elseif($row->STS == 5){echo 'Nikah';} else{echo '';} ?>
          </td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Nama Istri/Suami</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->SUAMIISTRI;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Nama Ibu Kandung</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->NamaIbuKandung;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Daerah Asal</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->ALAMATR;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Suku</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->NamaSuku;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Agama</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->AGAMA;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Pendidikan</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->Pendidikan;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Jurusan</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->Jurusan;?></td>
        </tr>
      </table>
<?php endforeach;?>
            </td>
        </tr>
    </table>

</page>