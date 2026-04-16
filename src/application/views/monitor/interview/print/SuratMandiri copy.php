<style type="text/Css">
  tbody{
    font-size: 14px;
}
.kop{
    font-size: 12px;
}
.judul{
    font-size: 18px;
    font-weight: bold;
}
.id{
    text-align: right;
}
p{
    margin-left: 20px;
  text-align: justify;
}
.margin10{
    margin-left: 20px;
    margin-right: 10px;
}

table #tabel, #tabel  td, #tabel th {
  border: 1px solid;
}

table #tabel{
  width: 100%;
  border-collapse: collapse;
}

#tabel th {
  width: 200px;
}
</style>
<table style="width: 100%;">
  <tr>
    <td>
      <table style="width: 100%; margin-top:50px;">
        <tr>
          <td>Sei Guntung, <?php echo date('d M Y') ?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Kepada Yth <br>
            Pemimpin PT. Bank Mandiri (Persero) Tbk <br>
            Kantor Layanan Pulau Sambu <br>
            di-</td>
        </tr>
        <tr>
          <td>&nbsp; &nbsp; &nbsp; Guntung</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Dengan hormat,</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Mohon bantuannya buat Pengurusan pembuatan rekening Mandiri, tenaga kerja di bawah ini. <br>
            Untuk keperluan penyetoran gaji Tenaga kerja tersebut</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table id="tabel">
        <tr align="center">
          <th>NAMA</th>
          <th>DEPT</th>
          <th>NIK KTP</th>
        </tr>
        <?php foreach ($getDetail as $key) { ?>
          <tr>
            <td><?= $key->Nama ?></td>
            <td><?= $key->DeptTujuan ?></td>
            <td><?= $key->No_Ktp ?></td>
          </tr>
        <?php } ?>

      </table>
      <br>
      <table>
        <tr>
          <td>Demikian permohonan kami, atas perhatian dan kerjasamanya<br>kami ucapkan terima kasih</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Departemen HRD</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Larnadimi Wagia <br>
            Kadep HRD</td>
          <!-- <td>Lisa Kusuma Dewi <br>
            Wakadep HRD</td> -->
        </tr>
      </table>
    </td>
  </tr>
</table>