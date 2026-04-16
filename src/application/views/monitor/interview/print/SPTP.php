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
foreach ($getDetail as $row) :
?>
	<table style="width: 100%;">
		<tr>
			<td>
				<table style="width: 100%; margin-top:20px;">
					<tr>
						<td style="text-align: center; font-size:12px; width: 100%;" class="kop">SERIKAT PEKERJA TINGKAT PERUSAHAAN(SPTP)</td>
					</tr>
					<tr>
						<td style="text-align: center; font-size:12px; width: 100%;" class="kop">PT. PULAU SAMBU</td>
					</tr>
					<tr>
						<td style="text-align: center; font-size:10px; width: 100%;" class="kop">Alamat : Sungai Guntung, Kec.Kateman, Inhil Riau</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table style="width: 100%;">
					<tr>
						<td style="text-align: center; font-size:12px; width: 100%;" class="kop"><u>FORMULIR PENDAFTARAN ANGGOTA SPTP PT.PULAU SAMBU</u></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table style="width: 100%;">
					<tr>
						<td style="text-align: left; font-size:12px; width: 100%;" class="kop">Kepada Yth,<br>Penguruns SPTP PT.Pulau Sambu<br>Di-<br>&nbsp;Pulau Sambu<br>Dengan Hormat,<br>Saya yang bertanda tangan dibawah ini</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table style="width: 100%;">
					<tr>
						<td style="text-align: left; font-size:12px; width: 20%;" class="kop">Nama</td>
						<td>:</td>
						<td style="text-align: left; font-size:12px; width: 30%;" class="kop"><?php echo $row->Nama; ?></td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:12px; width: 20%;" class="kop">NIK</td>
						<td>:</td>
						<td style="text-align: left; font-size:12px; width: 30%;" class="kop"><?php echo $row->Nik; ?></td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:12px; width: 20%;" class="kop">Ditempatkan di</td>
						<td>:</td>
						<td style="text-align: left; font-size:12px; width: 30%;" class="kop"><?php echo $row->Departemen; ?></td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:12px; width: 20%;" class="kop">Tempat/Tanggal Lahir</td>
						<td>:</td>
						<td style="text-align: left; font-size:12px; width: 30%;" class="kop"><?php echo $row->Tempat_Lahir; ?>/<?php echo date('d-m-Y', strtotime($row->Tgl_Lahir)) ?></td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:12px; width: 20%;" class="kop">Status</td>
						<td>:</td>
						<td style="text-align: left; font-size:12px; width: 30%;" class="kop"><?php echo $row->Status_Personal; ?></td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:12px; width: 20%;" class="kop">Agama</td>
						<td>:</td>
						<td style="text-align: left; font-size:12px; width: 30%;" class="kop"><?php echo $row->Agama; ?></td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:12px; width: 20%;" class="kop">Suku</td>
						<td>:</td>
						<td style="text-align: left; font-size:12px; width: 30%;" class="kop"><?php echo $row->Suku; ?></td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:12px; width: 20%;" class="kop">Pendidikan terakhir</td>
						<td>:</td>
						<td style="text-align: left; font-size:12px; width: 30%;" class="kop"><?php echo $row->Pendidikan; ?></td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:12px; width: 20%;" class="kop">Alamat</td>
						<td>:</td>
						<td style="text-align: left; font-size:12px; width: 30%;" class="kop"><?php echo $row->Alamat; ?></td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:12px; width: 20%;" class="kop">No. telp/HP</td>
						<td>:</td>
						<td style="text-align: left; font-size:12px; width: 30%;" class="kop"><?php echo $row->NoHP; ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table style="width: 100%;">
					<tr>
						<td style="text-align: left; font-size:12px; width: 100%;" class="kop">
							Memohon untuk didaftarkan menjadi anggota Serikat Pekerjaan Tingkat Perusahaan (SPTP) PT. Pulau Sambu.<br>
							Dengan ini saya menyatakan dengan sesungguhnya:<br>
							&nbsp;&nbsp;1. Bahwa saat ini saya tidak menjadi anggota serikat / buruh / federasi serikat pekerja / buruh / konfederasi serikat pekerja / buruh manapun.<br>
							&nbsp;&nbsp;2. Bahwa saya mematuhi AD / ART SPTP PT. Pulau Sambu dan peraturan lain yang di tetapkan Oleh pengurus SPTP PT.Pulau Sambu.
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table style="width: 100%;">
					<tr>
						<td style="text-align: left; font-size:12px; width: 100%;" class="kop">
							Demikian permohonan ini saya buat dengan sesungguhnya tanpa ada unsur paksaan dan tekanan dari pihak manapun Atas perhatian dan kerjasamanya diucapkan terima kasih.<br>
							Pulau Sambu, <?php echo date('d M Y') ?>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td>
				<table style="width: 100%;">
					<tr>
						<td style="text-align: center; font-size:12px; width: 50%;" class="kop">
							<br>Pemohon
						</td>
						<td style="text-align: center; font-size:12px; width: 50%;" class="kop">
							Disetujui oleh,<br>Pengurus SPTP PT. Pulau Sambu
						</td>
					</tr>
					<tr>
						<td style="text-align: center; font-size:12px; width: 50%;" class="kop">
							<?php
							$coba = base_url() . "dataupload/datakar/TTD_TK/" . trim($row->Nofix) . ".png";
							if (file_exists($coba) && is_file($coba2)) { ?>
								<img src="<?= $coba ?>" id="avatar" width="150" class="img-responsive" />
							<?php } else {
								// echo "Belum Ada Tanda Tangan";
							} ?>
						</td>
						<td style="text-align: center; font-size:12px; width: 50%;" class="kop">
							<img src="<?php echo base_url(); ?>assets/tanda_tangan/32764.png" id="avatar" width="150" class="img-responsive" />
						</td>
					</tr>
					<tr>
						<td style="text-align: center; font-size:12px; width: 50%;" class="kop">
							<?php echo $row->Nama; ?>
						</td>
						<td style="text-align: center; font-size:12px; width: 50%;" class="kop">
							(DENNY F. SIANIPAR)
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
<?php endforeach; ?>