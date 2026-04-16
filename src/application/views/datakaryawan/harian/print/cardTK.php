<page style="font-size: 12px; font-family: arial;" backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
<?php
    foreach ($_getDetailTK as $row):
    $nik = $row->Nik;
    endforeach;
    $namafoto = 'dataupload/Blacklist/BORONGAN/'.trim($nik).'.jpg';
?>
    <table style="width: 100%; border: solid 1px black;">
        <tr>
            <td style="width: 100%;">
<?php
    foreach ($_getDetailTK as $row):
?>
      <table style="width: 100%;" >
        <tr> 
          <td colspan="4" style="width: 100%; font-size: 18px; text-align: center; text-decoration: underline;">Data 
            Tenaga Kerja</td>
        </tr>
        <tr> 
          <td colspan="4" style="width: 5%; height: 110px; border: solid 0px #000000; text-align: center;"> 
            <img id="avatar" width="180" height="180" src="<?php echo base_url($namafoto);?>" />
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
          <td width="19%" style="border: solid 0px #000000;">NAMA</td>
          <td width="81%" style="border: solid 0px #000000;">: <?php echo $row->Nama;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">No. KTP</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->NOKTP;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Alamat</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->Alamat;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Jenis Kelamin</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->JenisKelamin;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Tempat/Tanggal Lahir</td>
          <td style="border: solid 0px #000000;">: <?php echo ucwords(strtolower($row->TempatLahir)).' / '.date('M, d Y',  strtotime($row->TglLahir));?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Umur</td>
          <td style="border: solid 0px #000000;">: <?php echo $_umur;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">No. HP</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->NoHP;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Status</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->StatusPerkawinan;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Jumlah Anak</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->JmlAnak;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Nama Istri / Suami</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->NamaIstriSuami;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Nama Ayah</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->NamaBapak;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Nama Ibu</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->NamaIbu;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Pekerjaan Orang Tua</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->PekerjaanOrtu;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Anak Ke</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->AnakKe;?> dari <?php echo $row->JmlSaudara;?> bersaudara</td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Daerah Asal</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->DaerahAsal;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Bahasa Daerah</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->BahasaDaerah;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Agama</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->Agama;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Hobby</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->Hobby;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Kegiatan Extra</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->KegExtra;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Kegiatan Organisasi</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->KegOrganisasi;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Pengalaman Kerja</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->PengalamanKerja;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Skil</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->Keahlian;?></td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Tinggi Badan</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->TB;?> Cm</td>
        </tr>
        <tr> 
          <td style="border: solid 0px #000000;">Berat Badan</td>
          <td style="border: solid 0px #000000;">: <?php echo $row->BB;?> Kg</td>
        </tr>
      </table>
<?php endforeach;?>
            </td>
        </tr>
    </table>

</page>