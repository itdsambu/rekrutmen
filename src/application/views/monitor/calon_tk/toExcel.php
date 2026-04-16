<table id="exportToExcel" class="table table-bordered" hidden="">
    <thead>
        <tr>
            <th>#</th>
            <th>Regis IDa</th>
            <th>Nama</th>
            <th>Pemborong</th>
            <th>Perusahaan</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>RT</th>
            <th>RW</th>
            <th>Handphone</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Tinggal Dengan</th>
            <th>Hubungan Dengan Pelamar</th>
            <th>Tinggi Badan</th>
            <th>Berat Badan</th>
            <th>Suku</th>
            <th>Daerah Asal</th>
            <th>Bahasa Daerah</th>
            <th>Agama</th>
            <th>Status Perkawianan</th>

            <th>Nama Pasangan</th>
            <th>Tanggal Lahir Pasangan</th>
            <th>Pekerjaan Pasangan</th>
            <th>Alamat Pasangan</th>
            <th>Jumlah Anak</th>

            <th>Nama Ayah</th>
            <th>Nama Ibu</th>
            <th>Pekerjaan Ortu</th>
            <th>Anak Ke</th>
            <th>Jumlah saudara</th>

            <th>Pendidikan Terakhir</th>
            <th>Jurusan</th>
            <th>Nama Univ/ Sekolah</th>
            <th>Rata Nilai</th>
            <th>Tahun Masuk</th>
            <th>Tahun Lulus</th>

            <th>Pengalaman Kerja</th>
            <th>Skill/ Keahlian</th>
            <th>Pernah Kerja di SAMBU</th>
            <th>Bagian/ Department</th>

            <th>Hobby</th>
            <th>Kegiatan Ekstra</th>
            <th>Kegiatan Organisasi</th>
            <th>Keadaan Fisik</th>
            <th>Idap Penyakit</th>
            <th>Penyakit Apa</th>
            <th>Pernah Terlibat Kriminal</th>
            <th>Perkara Apa</th>
            <th>Bertato</th>
            <th>Bertindik</th>
            <th>Sedia Rambut Pendek
            <th>
            <th>Sedia Diberhentikan
            <th>

            <th>Facebook
            <th>
            <th>Twitter
            <th>
            <th>Register By
            <th>
            <th>Register Date
            <th>
        </tr>
    </thead>
    <tbody>
        <?php $noUrut = 1;
        foreach ($_getTenaker as $row) : ?>
            <tr>
                <td><?php echo $noUrut++; ?></td>
                <td><?php echo $row->Nama; ?></td>
                <td><?php echo $row->Pemborong; ?></td>
                <td><?php echo $row->CVNama; ?></td>
                <td><?php if ($row->Jenis_Kelamin == 'M') {
                        echo 'Laki-laki';
                    } else {
                        echo 'Perempuan';
                    } ?></td>
                <td><?php echo $row->Alamat; ?></td>
                <td><?php echo $row->RT; ?></td>
                <td><?php echo $row->RW; ?></td>
                <td><?php echo $row->NoHP; ?></td>
                <td><?php echo $row->Tempat_Lahir; ?></td>
                <td><?php echo date('d M Y', strtotime($row->Tgl_Lahir)); ?></td>
                <td><?php echo $row->TinggalDengan; ?></td>
                <td><?php echo $row->HubunganDenganTK; ?></td>
                <td><?php echo $row->TinggiBadan; ?></td>
                <td><?php echo $row->BeratBadan; ?></td>
                <td><?php echo $row->Suku; ?></td>
                <td><?php echo $row->Daerah_Asal; ?></td>
                <td><?php echo $row->BahasaDaerah; ?></td>
                <td><?php echo $row->Agama; ?></td>
                <td><?php echo $row->Status_Personal; ?></td>

                <td><?php echo $row->NamaSuamiIstri; ?></td>
                <td><?php echo date('d M Y', strtotime($row->TglLahirSuamiIstri)); ?></td>
                <td><?php echo $row->PekerjaanSuamiIstri; ?></td>
                <td><?php echo $row->AlamatSuamiIstri; ?></td>
                <td><?php echo $row->JumlahAnak; ?></td>

                <td><?php echo $row->NamaBapak; ?></td>
                <td><?php echo $row->NamaIbuKandung; ?></td>
                <td><?php echo $row->ProfesiOrangTua; ?></td>
                <td><?php echo $row->AnakKe; ?></td>
                <td><?php echo $row->JumlahSaudara; ?></td>

                <td><?php echo $row->Pendidikan; ?></td>
                <td><?php echo $row->Jurusan; ?></td>
                <td><?php echo $row->Universitas; ?></td>
                <td><?php echo $row->IPK; ?></td>
                <td><?php echo $row->TahunMasuk; ?></td>
                <td><?php echo $row->TahunLulus; ?></td>

                <td><?php echo $row->PengalamanKerja; ?></td>
                <td><?php echo $row->Keahlian; ?></td>
                <td><?php echo $row->PernahKerjaDiSambu; ?></td>
                <td><?php echo $row->KerjadiBagian; ?></td>

                <td><?php echo $row->Hobby; ?></td>
                <td><?php echo $row->KegiatanEkstra; ?></td>
                <td><?php echo $row->KegiatanOrganisasi; ?></td>
                <td><?php echo $row->KeadaanFisik; ?></td>
                <td><?php echo $row->PernahIdapPenyakit; ?></td>
                <td><?php echo $row->PenyakitApa; ?></td>
                <td><?php echo $row->Kriminal; ?></td>
                <td><?php echo $row->PerkaraApa; ?></td>
                <td><?php echo $row->Bertato; ?></td>
                <td><?php echo $row->Bertindik; ?></td>
                <td><?php echo $row->SediaPotongRambut; ?>
                <td>
                <td><?php echo $row->Sediadiberhentikan; ?>
                <td>

                <td><?php echo $row->AccountFacebook; ?>
                <td>
                <td><?php echo $row->AccountTwitter; ?>
                <td>
                <td><?php echo $row->CreatedBy; ?>
                <td>
                <td><?php echo $row->CreatedDate; ?>
                <td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>