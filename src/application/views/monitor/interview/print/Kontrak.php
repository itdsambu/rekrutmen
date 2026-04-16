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
				<table style="width: 100%; margin-top:5px;">
					<tr>
						<td style="text-align: center; font-size:14px; width: 100%;" class="kop"><u>PERJANJIAN KONTRAK KERJA</u></td>
					</tr>
					<tr>
						<td style="text-align: center; font-size:10px; width: 100%;">NO : <?php echo date('d/m/y', strtotime($row->TanggalKontrak)); ?>/1/ <?php echo ucwords(strtoupper(substr($row->Singkatan, 3, 5))) ?>/<?php echo $row->Departemen; ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table style="width: 100%; font-size:11px;">
					<tr>
						<td>Yang bertandatangan di bawah ini:</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 20%;">Nama</td>
						<td>:</td>
						<td style="text-align: left; font-size:10px; width: 30%;"><?php echo $row->Pemborong; ?></td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 20%;">Tempat/Tanggal Lahir</td>
						<td>:</td>
						<td style="text-align: left; font-size:10px; width: 30%;"><?php echo $row->TempatLahirP; ?>/<?php echo date('d-m-Y', strtotime($row->TanggalLahirP)) ?></td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 20%;">Jenis Kelamin</td>
						<td>:</td>
						<td style="text-align: left; font-size:10px; width: 30%;"><?php echo $row->JenisKelaminP; ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table style="width: 100%;">
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							dalam hal ini bertindak dan untuk atas nama <?= $row->CVNama ?> yang beralamat Di Sungai Guntung, Kecamatan Kateman Kab. Indragiri Hilir Riau, yang bergerak pada usaha jasa outsourcing yang menerima pekerjaan dari perusahaan pemberi kerja yang sifat pekerjaanya dipengaruhi oleh musim, yang untuk selanjutnya di sebut <b>Pihak Pertama</b>
						</td>
					</tr>
				</table>
				<table style="width: 100%;">
					<tr>
						<td style="text-align: left; font-size:10px; width: 20%;">Nama</td>
						<td>:</td>
						<td style="text-align: left; font-size:10px; width: 30%;"><?php echo $row->Nama; ?></td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 20%;">Tempat/Tanggal Lahir</td>
						<td>:</td>
						<td style="text-align: left; font-size:10px; width: 30%;"><?php echo $row->Tempat_Lahir; ?>/<?php echo date('d-m-Y', strtotime($row->Tgl_Lahir)) ?></td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 20%;">Jenis Kelamin</td>
						<td>:</td>
						<td style="text-align: left; font-size:10px; width: 30%;"><?php echo $row->Jenis_Kelamin; ?></td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 20%;">Alamat</td>
						<td>:</td>
						<td style="text-align: left; font-size:10px; width: 30%;"><?php echo $row->Alamat; ?></td>
					</tr>
				</table>
				<table style="width: 100%;">
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							dalam hal ini bertindak untuk dan atas namanya sendiri, untuk selanjutnya disebut dengan <b>Pihak Kedua </b>
						</td>
					</tr>
				</table>
				<table style="width: 100%;">
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							<b><u>KESEPAKATAN DAN KONDISI UMUM</u></b><br>
							Pada hari ini <?= date('d-m-Y', strtotime($row->TanggalKontrak)) ?> kedua belah pihak sepakat untuk membuat kontrak kerja sebagai berikut :<br>
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							1. Pihak kedua telah setuju untuk bekerja dipihak pertama dengan status Tenaga Kerja Kontrak dengan masa kontrak yang disepakati<br>
							&nbsp;&nbsp;&nbsp;&nbsp;adalah: 1 bulan terhitung mulai <?= date('d-m-Y', strtotime($row->TanggalKontrak)) ?> sampai dengan tanggal <?= date('d-m-Y', strtotime('+ 1 month', strtotime($row->TanggalKontrak))) ?> Jika masing-masing pihak setuju<br>
							&nbsp;&nbsp;&nbsp;&nbsp;perjanjian ini dapat diperpanjang dengan mengabaikan masa tenggang 30 hari ( Kep. Men 100/VI/2004 pasal 3 ayat 8 )
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							2. Kedua belah pihak setuju Perjanjian Kontrak Kerja ini berakhir secara otomatis, apabila Kontrak Kerja Pihak Pertama dengan mitra<br>&nbsp;&nbsp;&nbsp;&nbsp;kerjanya berakhir atau terjadi pemutusan kontrak kerja antara pihak pertama dengan mitra kerjanya.
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							3. Apabila masing-masing pihak menghendaki kontrak kerja dilanjutkan, kedua belah pihak setuju untuk mengabaikan waktu jeda 30 hari.
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							4. Pihak kedua menerima upah sesuai dengan SPK ( Surat Perintah Kerja ) yang ditandatangani antara pihak pertama dengan mitra<br>
							&nbsp;&nbsp;&nbsp;&nbsp;kerjanya.
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							5. Dalam menjalankan tugas sehari-hari, tanggung jawab pihak kedua tercantum dalam operational manual mitra kerja Pihak Pertama dan<br>
							&nbsp;&nbsp;&nbsp;&nbsp;pihak kedua setuju untuk patuh pada instruksi atasan dan atau wakil dari mitra kerja pihak pertama.
						</td>
					</tr>
				</table>
				<table style="width: 100%;">
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							<b><u>KESEPAKATAN DAN KONDISI LAINNYA</u></b>
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							1. Demi untuk kepentingan Pihak Pertama, maka Pihak Kedua bersedia untuk rotasi, atau mutasi ke bagian lainnya baik sementara waktu
							<br>&nbsp;&nbsp;&nbsp;&nbsp;maupun sesuai dengan kebutuhan Pihak Pertama.
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							2. Pihak Kedua sanggup untuk bekerja sesuai dengan jam kerja yang telah diatur oleh Pihak Pertama, berdisiplin serta bersedia untuk
							<br>&nbsp;&nbsp;&nbsp;&nbsp;mengikuti semua ketentuan dan peraturan yang berlaku ditempat kerja dan yang akan diberlakukan kemudian. Pihak Kedua bersedia
							<br>&nbsp;&nbsp;&nbsp;&nbsp;untuk diberikan sanksi sesuai dengan peraturan yang berlaku bila terbukti melakukan pelanggaran.
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							3. Pihak Kedua setuju apabila sewaktu-waktu diminta lembur termasuk dihari libur ( hari mingguan / libur nasional ) sesuai dengan tuntutan
							<br>&nbsp;&nbsp;&nbsp;&nbsp;pekerjaan dan dibayar uang lembur sesuai dengan peraturan yang berlaku.
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							4. Pihak Kedua setuju untuk mewakilkan penandatanganan absensi kehadiran kepada petugas administrasi yang ditunjuk oleh Pihak
							<br>&nbsp;&nbsp;&nbsp;&nbsp;Pertama.
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							5. Pihak Pertama tidak berkewajiban menyediakan fasilitas Mess / Tempat Tinggal untuk Pihak Kedua.
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							6. Dalam masa kontrak kerja, Pihak Pertama berhak memutuskan kontrak kerja ini tanpa konpensasi apapun, jika :
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							&nbsp;&nbsp;&nbsp;&nbsp;a. Pihak Kedua diketahui memberikan keterangan palsu seperti pendidikan, keahlian, kesehatan, dan lain-lain serta bertindak tidak layak yang dapat
							<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;merugikan Pihak Pertama
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							&nbsp;&nbsp;&nbsp;&nbsp;b. Pihak Kedua karena keteledoranya maupun alasan kesehatan tidak mampu memenuhi kewajiban kontrak.
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							&nbsp;&nbsp;&nbsp;&nbsp;c. Pihak Kedua melakukan penyimpangan secara sengaja atas tugas, khususnya mengabaikan perintah yang diberikan oleh Wakil Pihak Pertama dan
							<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;atau wakil dari mitra kerjanya.
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							&nbsp;&nbsp;&nbsp;&nbsp;d. Tidak masuk kerja selama 5 (lima) hari berturut-turut atau 10 (sepuluh) hari tidak berturut-turut dalam 1 (satu) bulan tanpa mengajukan alasan, bukti
							<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;yang sah dan dapat dipertanggungjawaban.
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							&nbsp;&nbsp;&nbsp;&nbsp;e. Pihak Kedua melakukan kesalahan berat sebagaimana ketentuan persyaratan perundang-undangan yang berlaku.
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							7. Pihak Kedua bersedia menerima alat kerja sebagaimana ketentuan di dalam SPK yang telah ditandatangai oleh Pihak Pertama dengan mitranya.
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							8. Pihak Kedua dalam bekerja berkomitmen menjalankan ketentuan yang tertuang dalam Kebijakan Bisnis integrity Pihak Pertama
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							9. Jika Pihak Kedua memutuskan kontrak kerja dalam masa kontrak, maka Pihak Kedua harus membayar kepada Pihak Pertama ganti rugi sebesar upah
							<br>&nbsp;&nbsp;&nbsp;&nbsp;Pihak Kedua sampai masa kontrak selesai, demikian juga sebaliknya jika Pihak Pertama memutuskan kontrak kerja dengan Pihak Kedua diluar
							<br>&nbsp;&nbsp;&nbsp;&nbsp;ketentuan nomor (6) tersebut diatas Pihak Pertama juga harus membayar kepada Pihak Kedua ganti rugi sebesar upah Pihak Kedua sampai masa
							<br>&nbsp;&nbsp;&nbsp;&nbsp;kontrak selesai.
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							10. Mitra kerja Pihak Pertama menyediakan Klinik yang dapat dipakai oleh Keluarga Pihak Kedua ( satu istri yang sah dan dua orang anak ) dengan
							<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ketentuan biaya berobat Pihak Kedua sekana di klinik ditanggung sepenuhnya oleh Pihak Pertama dan biaya berobat keluarga Pihak Kedua selama di
							<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;klinik dibebankan 50% kepada Pihak Kedua.
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							11. Apabila Pihak Kedua dirujuk ke balai pengobatan lain, Pihak Pertama akan memberikan bantuan maksimal sebesar Rp. 2.000.000,- ( dua juta rupiah ) selama priode
							<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;satu tahun. Sedang untuk keluarga Pihak Kedua ( satu istri yang sah dan dua orang anak ) maksimal Rp. 1.000.000,- ( satu juta rupiah ) selama periode satu tahun.
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							12. Ketentuan nomor (9) dan (10) tersebut diatas tidak dapat diberikan dalam bentuk uang apabila Pihak Kedua / Keluarga Pihak Kedua tidak memanfaatkan fasilitas
							<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;dan mengikuti prosedur yang telah ditentukan.
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							13. Pihak Kedua wajib membaca semua ketentuan dan tata tertib di tempat kerja dan dianggap telah mengerti dan wajib melaksanakannya.
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							14. Semua biaya-biaya yang timbul bagi pelaksanaan pembuatan perjanjian kontrak kerja ini ditanggung oleh Pihak Pertama,
						</td>
					</tr>
				</table>
				<table style="width: 100%;">
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;">
							Perjanjian ini telah mendapat persetujuan kedua belah pihak untuk dapat berlaku surut sesuai tanggal tanda tangan. Bila dikemudian hari terdapat kesalahpahaman atas perjanjian kontak kerja ini akan dikaukan perundingan secara musyawarah untuk mufakat. Persyaratan dan kondisi kontrak diatas dapat diterima oleh keduabelah pihak tanpa paksaan dari pihak manapun.
							Ditantatangi di Pulau Sambu Guntung, <?= date('d-m-Y', strtotime($row->TanggalKontrak)) ?>
						</td>
					</tr>
				</table>
				<table style="width: 100%;">
					<tr>
						<td style="text-align: center; font-size:10px; width: 50%;" class="kop">
							Pihak Pertama
						</td>
						<td style="text-align: center; font-size:10px; width: 50%;" class="kop">
							Pihak Kedua
						</td>
					</tr>
					<tr>
						<td style="text-align: center; font-size:10px; width: 50%;" class="kop">
							<!-- <img src="<?php echo base_url(); ?>assets/tanda_tangan/<?php echo $row->Pemborong; ?>.png" id="avatar" width="80" class="img-responsive"/> -->
							<?php
							$coba = base_url() . "assets/tanda_tangan/" . trim($row->Pemborong) . ".png";
							if (file_exists($coba)) { ?>
								<img src="<?php echo base_url() ?>assets/tanda_tangan/<?php echo trim($row->Pemborong) ?>.png" id="avatar" width="150" class="img-responsive" />
							<?php } else {
								// echo "Belum Ada Tanda Tangan";
							} ?>
						</td>
						<td style="text-align: center; font-size:10px; width: 50%;" class="kop">
							<!-- <img src="<?php echo base_url(); ?>dataupload/datakar/TDD_REKRUTMEN/<?php echo trim($row->HeaderID) ?>.png" id="avatar" width="80" class="img-responsive" /> -->
							<?php
							$coba2 = base_url() . "dataupload/datakar/TDD_REKRUTMEN/" . trim($row->HeaderID) . ".png";
							if (file_exists($coba2) && is_file($coba2)) { ?>
								<img src="<?php echo base_url() ?>dataupload/datakar/TDD_REKRUTMEN/<?php echo trim($row->HeaderID) ?>.png" id="avatar" width="150" class="img-responsive" />
							<?php } else {
								// echo "Belum Ada Tanda Tangan";
							} ?>
						</td>
					</tr>
					<tr>
						<td style="text-align: center; font-size:10px; width: 50%;" class="kop">
							(<?php echo $row->Pemborong; ?>)
						</td>
						<td style="text-align: center; font-size:10px; width: 50%;" class="kop">
							(<?php echo $row->Nama; ?>)
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table style="width: 100%;">
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;" class="kop">
							Saksi :
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size:10px; width: 100%;" class="kop">
							1. <?php echo strtoupper($row->VerifiedBy); ?><br>
							2. <?php echo strtoupper($row->WawancaraBy); ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
<?php endforeach; ?>