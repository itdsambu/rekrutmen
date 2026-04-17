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
</style>

<?php
    foreach ($getDetail as $row):
?>
<table style="width: 100%;">
    <tr>
        <td>
            <table style="width: 100%; margin-top:50px;" >
                <tr>
                    <td style="text-align: center; font-size:25px; width: 100%;" class="kop"><strong><u>SURAT PERNYATAAN</u></strong></td>
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
                    <td>&nbsp;</td>
                </tr>
			</table>
			<p>Yang bertanda tangan dibawah ini :</p>
			<table style="width: 100%;" class="margin10">
                <tr>
                    <td style="width: 20%;">Nama</td>
					<td style="width: 1%;">:</td>
					<td style="width: 50%;"> <?php echo $row->Nama;?></td>
                </tr>
				<tr>
                    <td style="width: 20%;">NIK</td>
					<td style="width: 1%;">:</td>
					<td style="width: 50%;"> <?php echo $row->Nik;?></td>
                </tr>
				<tr>
                    <td style="width: 20%;">Tempat, Tanggal lahir</td>
					<td style="width: 1%;">:</td>
					<td style="width: 50%;"> <?php echo $row->Tempat_Lahir;?>,<?php echo date('d M Y', strtotime($row->Tgl_Lahir));?></td>
                </tr>
				<tr>
                    <td style="width: 20%;">Alamat</td>
					<td style="width: 1%;">:</td>
					<td style="width: 50%;"> <?php echo $row->Alamat;?></td>
                </tr>
			</table>
			<p>Menyatakan bahwa apabila saya sudah tidak bekerja di <?php echo $row->CVNama;?>.<br>
			saya bersedia jika pihak Bank BNI memblokir dan menutup nomor rekening yang digunakan<br>
			sebagai sistem penggajian.<br><br>Demikian surat pernyataan ini Saya buat tanpa adanya paksaan dan tekanan dari pihak manapun.</p>
			<br>
			<br>
			<p>Pulau Sambu, <?php echo date('d M Y') ?><br>Yang membuat pernyataan,<br>
			<?php if($row->Sts_ttd == 1){?>
			<img src="<?php echo base_url();?>dataupload/datakar/TDD_REKRUTMEN/<?php echo trim($row->HeaderID)?>.png" id="avatar" width="150" class="img-responsive"/>
			<?php } else { ?>
			<br>
			<br>
			<br>
			<br>
			<br>
			<?php } ?>
			<br/><u><?php echo $row->Nama;?></u></p>
		</td>
	</tr>
</table>
<?php endforeach;