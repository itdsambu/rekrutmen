<?php
	foreach($datatk as $row):
		$hdrid = $row->HeaderID;
//		$hdrid = $hdrid.'jpg';
	endforeach;
?>

<?php
	$namafoto = './dataupload/foto/'.$hdrid.'.jpg';
	if (file_exists($namafoto)){
		echo '<img src="'.base_url($namafoto).'" class="img-thumbnail" width="150px" height="150px" style="display:block; margin-left: auto; margin-right: auto">';
	}else{
		echo '<img src="'.base_url().'assets/img/NoImage.png" class="img-thumbnail" width="150px" height="150px" style="display:block; margin-left: auto; margin-right: auto">';
	}
?>
<table id="tabeldetail" class="table table-hover">
	<tr><td width="20%">Perusahaan</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->CVNama; endforeach; ?></td></tr>
	<tr><td width="20%">Pemborong</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->Pemborong; endforeach; ?></td></tr>
	<tr><td width="20%">Nama</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->Nama; endforeach; ?></td></tr>
	<tr><td width="20%">Alamat Lengkap</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->Alamat; endforeach; ?></td></tr>
	<tr><td width="20%">Jenis Kelamin</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->Jenis_Kelamin; endforeach; ?></td></tr>
	<tr><td width="20%">Tempat, Tgl Lahir</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->Tempat_Lahir.", ".tgl_ind($row->Tgl_Lahir); endforeach; ?></td></tr>
	<tr><td width="20%">Status</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->Status_Personal; endforeach; ?></td></tr>
	<tr><td width="20%">Jumlah Anak</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->JumlahAnak; endforeach; ?></td></tr>
	<tr><td width="20%">Nama Suami/Istri</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->NamaSuamiIstri; endforeach; ?></td></tr>
	<tr><td width="20%">Nama Bapak</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->NamaBapak; endforeach; ?></td></tr>
	<tr><td width="20%">Nama Ibu</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->NamaIbuKandung; endforeach; ?></td></tr>
	<tr><td width="20%">Profesi Orang Tua</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->ProfesiOrangTua; endforeach; ?></td></tr>
	<tr><td width="20%">Jumlah Saudara</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->JumlahSaudara; endforeach; ?></td></tr>
	<tr><td width="20%">Anak Ke</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->AnakKe; endforeach; ?></td></tr>
	<tr><td width="20%">Daerah Asal</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->Daerah_Asal; endforeach; ?></td></tr>
	<tr><td width="20%">Bahasa Daerah</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->BahasaDaerah; endforeach; ?></td></tr>
	<tr><td width="20%">Suku</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->Suku; endforeach; ?></td></tr>
	<tr><td width="20%">Agama</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->Agama; endforeach; ?></td></tr>
	<tr><td width="20%">Pendidikan</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->Pendidikan; endforeach; ?></td></tr>
	<tr><td width="20%">Jurusan</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->Jurusan; endforeach; ?></td></tr>
	<tr><td width="20%">Tahun Masuk</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->TahunMasuk; endforeach; ?></td></tr>
	<tr><td width="20%">Tahun Lulus</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->TahunLulus; endforeach; ?></td></tr>
	<tr><td width="20%">Hobby</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->Hobby; endforeach; ?></td></tr>
	<tr><td width="20%">Kegiatan Ekstra</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->KegiatanEkstra; endforeach; ?></td></tr>
	<tr><td width="20%">Keadaan Fisik</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->KeadaanFisik; endforeach; ?></td></tr>
	<tr><td width="20%">Tinggi Badan</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->TinggiBadan; endforeach; ?></td></tr>
	<tr><td width="20%">Berat Badan</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->BeratBadan; endforeach; ?></td></tr>
	<tr><td width="20%">Idap Penyakit</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->PernahIdapPenyakit; endforeach; ?></td></tr>
	<tr><td width="20%">Penyakit Apa</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->PenyakitApa; endforeach; ?></td></tr>
	<tr><td width="20%">Pengalaman Kerja</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->PengalamanKerja; endforeach; ?></td></tr>
	<tr><td width="20%">Keahlian</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->Keahlian; endforeach; ?></td></tr>
	<tr><td width="20%">Pernah Kerja di SAMBU</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->PernahKerjaDiSambu; endforeach; ?></td></tr>
	<tr><td width="20%">Jenis Vaksin</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->JenisVaksin; endforeach; ?></td></tr>
	<tr><td width="20%">Vaksin 1</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->TanggalVaksin; endforeach; ?></td></tr>
	<tr><td width="20%">Vaksin 2</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->TanggalVaksin2; endforeach; ?></td></tr>
	<tr><td width="20%">Vaksin 3</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->TanggalVaksin3; endforeach; ?></td></tr>
	<tr><td width="20%">Bagian/Dept</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->KerjadiBagian; endforeach; ?></td></tr>
	<tr><td width="20%">No.Telp</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->NoHP; endforeach; ?></td></tr>
	<tr><td width="20%">Facebook</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->AccountFacebook; endforeach; ?></td></tr>
	<tr><td width="20%">Twitter</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->AccountTwitter; endforeach; ?></td></tr>	
	<tr><td width="20%">EMAIL</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->Account_email; endforeach; ?></td></tr>	
	<tr><td width="20%">Terlibat Kriminal</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->Kriminal; endforeach; ?></td></tr>
	<tr><td width="20%">Perkara Apa</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->PerkaraApa; endforeach; ?></td></tr>
	<tr><td width="20%">Bertato</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->Bertato; endforeach; ?></td></tr>
	<tr><td width="20%">Bertindik</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->Bertindik; endforeach; ?></td></tr>
	<tr><td width="20%">Potong Rambut</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->SediaPotongRambut; endforeach; ?></td></tr>
	<tr><td width="20%">Sedia Diberhentikan</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->Sediadiberhentikan; endforeach; ?></td></tr>
	<tr class="success"><td width="20%">Registered By</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo $row->RegisteredBy; endforeach; ?></td></tr>
	<tr class="success"><td width="20%">Registered Date</td><td width="5px">:</td>
		<td><?php foreach($datatk as $row): echo datetime_ind($row->RegisteredDate); endforeach; ?></td></tr>
</table>
