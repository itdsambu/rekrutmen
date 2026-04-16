<!-- <page backtop="15mm" backbottom="15mm"> -->
<page backtop="3mm" backbottom="15mm" backleft="6mm" backright="0mm">
    <style type="text/css">
        .header-title {
            font-size: 36px;
            font-weight: bold;
            color: #1b3c8b;
        }

        .small {
            font-size: 10px;
            color: #1b3c8b;
        }

        .line {
            border-top: 2px solid #1b3c8b;
            margin-top: 5px;
        }

        .box {
            width: 30px;
            height: 30px;
            border: 1px solid black;
            margin: auto;
            box-sizing: border-box;
            align-items: flex-start;
        }


        /* Baru */
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
        }

        table {
            font-size: 10px;
        }

        .small {
            font-size: 9px;
        }

        .header-title {
            font-size: 28px;
            /* dari 36px */
        }
    </style>
    <div id="pdf-wrapper">




        <table width="100%" border="0">
            <tr>
                <!-- LOGO -->
                <td width="140" align="center" valign="center" style="padding-top:20px;">
                    <img src="<?= FCPATH ?>assets/images/logo_terbaru.png" width="120" height="120" />
                </td>

                <!-- CONTENT -->
                <td>
                    <table width="100%" border="0">
                        <tr>
                            <td colspan="3" class="header-title" align="left" valign="top">
                                PT PULAU SAMBU
                            </td>
                        </tr>

                        <tr>
                            <td width="33%" class="small" valign="top">
                                <b>Kantor Pusat:</b><br>
                                Jakarta<br>
                                Jl. Rawa Bebek No. 26 (Gedong Panjang)<br>
                                RT/RW 003/010, Penjaringan<br>
                                Jakarta Utara 14440<br>
                                Telp: +62 21 6603926 / 6604026<br>
                                Fax: +62 21 6609426<br>
                                Email: psj-general@sambu.co.id
                            </td>

                            <td width="33%" class="small" valign="top">
                                <b>Lokasi Unit Usaha:</b><br>
                                Kuala Enok<br>
                                Desa Tanah Merah<br>
                                Kab. Indragiri Hilir, Riau 29271<br>
                                Telp: +62 768 21609 (Hunting)<br>
                                Fax: +62 768 22445<br>
                                Email: psk-general@sambu.co.id
                            </td>

                            <td width="34%" class="small" valign="top">
                                <b>Sungai Guntung</b><br>
                                Air Tawar<br>
                                Desa/Kelurahan Air Tawar<br>
                                Kec. Kateman<br>
                                Kab. Indragiri Hilir, Riau<br>
                                Telp: +62 779 552888<br>
                                Fax: +62 779 552000<br>
                                Email: general@spsg.co.id
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <p class="small" align="center" style="margin-left: 0px;">
            website: www.sambugroup.com
        </p>
        <div class="line" style="margin-left: 0px;"></div>
        <table border="" width="65%" align="center" cellpadding="6" cellspacing="0">
            <tr>
                <th align="center" style="font-weight:bold;">
                    FORM PERMINTAAN PERUBAHAN ORGANISASI
                </th>
            </tr>
        </table>
        <br>
        <table width="100%" cellpadding="9" cellspacing="">
            <tr>
                <th align="left" style="font-weight:bold;width: 212px;">
                    DIVISI
                </th>
                <th align="left" style="font-weight:bold;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black; width: 400px; padding: 8px;">
                    <?= $header->Divisi ?>
                </th>
            </tr>
            <tr>
                <th align="left" style="font-weight:bold;width: 200px;">
                    DEPARTEMEN
                </th>
                <th align="left" style="font-weight:bold; border-left: 1px solid black;border-right: 1px solid black;border-top:1px solid black; width: 400px; padding: 8px;">
                    <?= $header->Departemen ?>
                </th>
            </tr>
            <tr>
                <th align="left" style="font-weight:bold;width: 200px;">
                    SUB DEPARTEMEN <br>
                    (contoh MP1, MP2, MPM)
                </th>
                <th align="left" style="font-weight:bold; border-left: 1px solid black;border-right: 1px solid black;border-top:1px solid black; width: 400px; padding: 8px;">
                    <?= $header->SubDepartemen ?>
                </th>
            </tr>
            <tr>
                <th align="left" style="font-weight:bold;width: 200px;">
                    JABATAN
                </th>
                <th align="left" style="font-weight:bold; border-left: 1px solid black;border-right: 1px solid black;border-top:1px solid black; width: 400px; padding: 8px;">
                    <?= $header->Jabatan ?>
                </th>
            </tr>
            <tr>
                <th align="left" style="font-weight:bold;width: 200px;">
                    SUBJABATAN
                </th>
                <th align="left" style="font-weight:bold; border-left: 1px solid black;border-right: 1px solid black;border-top:1px solid black;border-bottom:1px solid black; width: 400px; padding: 8px;">
                    <?= $header->SubJabatan ?>
                </th>
            </tr>
        </table>

        <!-- STATUS JABATAN -->
        <table width="100%" cellpadding="4" cellspacing="0" style="margin-top: 10px; table-layout:fixed" border="0">
            <tr>
                <!-- STATUS JABATAN -->
                <td style="width:206; vertical-align:top;">
                    <b>STATUS JABATAN</b><br>
                    <em style="font-size:11px;color:gray;">
                        (beri tanda pada kolom samping)
                    </em>
                </td>

                <!-- BARU -->
                <td style="width:183px; vertical-align:top;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="width:20px;">
                                <div style="width:16px;height:16px;border:1px solid #000; background:<?= $header->TipePerubahan == 1 ? '#000' : '#fff' ?>;"> </div>
                            </td>
                            <td style="padding-left:6px;">
                                <b>BARU*</b><br>
                                <em style="font-size:11px;color:gray;">
                                    (belum ada di MPP)
                                </em>
                            </td>
                        </tr>
                    </table>
                </td>

                <!-- LAMA -->
                <td style="width:150px; vertical-align:top;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="width:20px;">
                                <div style="width:16px;height:16px;border:1px solid #000;
                                background:<?= $header->TipePerubahan == 2 ? '#000' : '#fff' ?>;"></div>
                            </td>
                            <td style="padding-left:6px;">
                                <b>LAMA**</b><br>
                                <em style="font-size:11px;color:gray;">
                                    (sudah ada di MPP)
                                </em>
                            </td>
                        </tr>
                    </table>
                </td>

                <!-- KETERANGAN -->
                <td style="width:160px; vertical-align:top;">
                    <em style="font-size:11px;color:gray;">
                        *) Mengisi Lampiran A<br>
                        **) Mengisi Lampiran B
                    </em>
                </td>
            </tr>

        </table>

        <!-- PEMANGKU JABATAN -->
        <table cellpadding="4" cellspacing="0" border="0" style="table-layout:fixed; width:720px;">
            <tr>
                <td style="width:206px; vertical-align:top;">
                    <b>JUMLAH PEMANGKU JABATAN</b><br>
                    <em style="font-size:11px;color:gray;">
                        (isi jumlah orang pada kolom samping)
                    </em>
                </td>

                <td style="width:183px; vertical-align:top;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="width:20px;">
                                <div style="width:16px;height:16px;border:1px solid #000;" align="center">
                                    <?= $header->JumlahSebelum ?>
                                </div>
                            </td>
                            <td style="padding-left:6px;">
                                <b>SEBELUM</b><br>
                                <em style="font-size:11px;color:gray;">
                                    (jumlah orang di MPP)
                                </em>
                            </td>
                        </tr>
                    </table>
                </td>

                <td style="width:230px; vertical-align:top;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="width:20px;">
                                <div style="width:16px;height:16px;border:1px solid #000;" align="center">
                                    <?= $header->JumlahSesudah ?>
                                </div>
                            </td>
                            <td style="padding-left:6px;">
                                <b>SESUDAH</b><br>
                                <em style="font-size:11px;color:gray;">
                                    (jumlah orang yang diajukan)
                                </em>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- SIFAT PERUBAHAN -->
        <table cellpadding="4" cellspacing="0" border="0" style="table-layout:fixed; width:720px; ">
            <tr>
                <td style="width:206; vertical-align:top;">
                    <b>SIFAT PERUBAHAN</b><br>
                    <em style="font-size:11px;color:gray;">
                        (beri tanda pada kolom samping)
                    </em>
                </td>

                <td style="width:170px; vertical-align:top;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="width:20px;">
                                <div style="width:16px;height:16px;border:1px solid #000;
                                background:<?= $header->SifatPerubahan == 'PENAMBAHAN' ? '#000' : '#fff' ?>;"></div>
                            </td>
                            <td style="padding-left:6px;">
                                <b>PENAMBAHAN</b><br>
                                <em style="font-size:11px;color:gray;">
                                    (menambah jumlah total MPP)
                                </em>
                            </td>
                        </tr>
                    </table>
                </td>

                <td style="width:150px; vertical-align:top;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="width:20px;">
                                <div style="width:16px;height:16px;border:1px solid #000;
                                background:<?= $header->SifatPerubahan == 'TETAP' ? '#000' : '#fff' ?>;"></div>
                            </td>
                            <td style="padding-left:6px;">
                                <b>TETAP</b><br>
                                <em style="font-size:11px;color:gray;">
                                    (tidak merubah jumlah total MPP)
                                </em>
                            </td>
                        </tr>
                    </table>
                </td>

                <td style="width:160px; vertical-align:top;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="width:20px;">
                                <div style="width:16px;height:16px;border:1px solid #000;
                                background:<?= $header->SifatPerubahan == 'PENGURANGAN' ? '#000' : '#fff' ?>;"></div>
                            </td>
                            <td style="padding-left:6px;">
                                <b>PENGURANGAN</b><br>
                                <em style="font-size:11px;color:gray;">
                                    (mengurangi jumlah <br>
                                    total MPP)
                                </em>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table cellpadding="4" cellspacing="0" border="0" style="table-layout:fixed; width:720px; margin-top:8px;">
            <tr>
                <th align="left">
                    <b>LATAR BELAKANG PERUBAHAN</b><br>
                    <em style="font-size:11px;color:gray;">
                        (uraikan latar belakang perubahan organisasi)
                    </em>
                </th>
            </tr>
            <tr>
                <td>
                    <div style="height:100px;border:solid black 1px; padding:4px;">
                        <?= $header->LatarBelakang ?>
                    </div>
                </td>
            </tr>
        </table>
        <table cellpadding="4" cellspacing="0" border="0" style="table-layout:fixed; width:720px; margin-top:8px;">
            <tr>
                <th align="left">
                    <b>PROYEKSI DAMPAK/VALUE</b><br>
                    <em style="font-size:11px;color:gray;">
                        (dampak perubahan terhadap operasional saat ini dan perusahaan kedepannya)
                    </em>
                </th>
            </tr>
            <tr>
                <td>
                    <div style="height:100px;border:solid black 1px; padding:4px;">
                        <?= $header->ProyeksiDampak ?>
                    </div>
                </td>
            </tr>
        </table>
        <table cellpadding="4" cellspacing="0" border="0" style="table-layout:fixed; width:720px; margin-top:8px;">
            <tr>
                <th align="left">
                    <b>STRUKTUR ORGANISASI</b><br>
                    <em style="font-size:11px;color:gray;">
                        (gambarkan struktur organisasi setelah perubahan, jika tidak mengubah struktur organisasi tetap diganbarkanletak jabatannya)
                    </em>
                </th>
            </tr>
            <tr>
                <td>
                    <div style="height:100px;border:solid black 1px; padding:4px;">
                        <?= $header->StrukturOrganisasi ?>
                    </div>
                </td>
            </tr>
        </table>
        <table cellpadding="4" cellspacing="0" border="0" style="table-layout:fixed; width:720px; margin-top:8px;">
            <tr>
                <th align="left">
                    <b>KUALIFIKASI KANDIDAT</b><br>
                    <em style="font-size:11px;color:gray;">
                        yang dibutuhkan untuk pengisi jabatan
                    </em>
                </th>
            </tr>

        </table>

        <table width="100%" cellpadding="9" cellspacing="" style="margin-top: 8px;">
            <tr>
                <th align=" left" style="font-weight:bold;width: 212px;">
                    Latar belakang pendidikan dan jurusan
                </th>
                <th style="width: 20px;">:</th>
                <th align="left" style="font-weight:bold;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black; width: 400px; padding: 8px;">
                    <?= $header->KualifikasiPendidikan ?>
                </th>
            </tr>
            <tr>
                <th align="left" style="font-weight:bold;width: 200px;">
                    Pengalaman bekerja
                </th>
                <th>:</th>
                <th align="left" style="font-weight:bold; border-left: 1px solid black;border-right: 1px solid black;border-top:1px solid black; width: 400px; padding: 8px;">
                    <?= $header->KualifikasiPendidikan ?>
                </th>
            </tr>
            <tr>
                <th align="left" style="font-weight:bold;width: 200px;">
                    Pengalaman manajerial
                </th>
                <th>:</th>
                <th align="left" style="font-weight:bold; border-left: 1px solid black;border-right: 1px solid black;border-top:1px solid black; width: 400px; padding: 8px;">
                    <?= $header->KualifikasiManajerial ?>
                </th>
            </tr>
            <tr>
                <th align="left" style="font-weight:bold;width: 200px;">
                    Kompetensi teknis dan non teknis
                </th>
                <th>:</th>
                <th align="left" style="font-weight:bold; border-left: 1px solid black;border-right: 1px solid black;border-top:1px solid black; width: 400px; padding: 8px;">
                    <?= $header->KualifikasiKompetensi ?>
                </th>
            </tr>
            <tr>
                <th align="left" style="font-weight:bold;width: 200px;">
                    Sertifikasi/Izin
                </th>
                <th>:</th>
                <th align="left" style="font-weight:bold; border-left: 1px solid black;border-right: 1px solid black;border-top:1px solid black; width: 400px; padding: 8px;">
                    <?= $header->KualifikasiSertifikasi ?>
                </th>
            </tr>
            <tr>
                <th align="left" style="font-weight:bold;width: 200px;">
                    Lain-lain
                </th>
                <th>:</th>
                <th align="left" style="font-weight:bold; border-left: 1px solid black;border-right: 1px solid black;border-top:1px solid black;border-bottom:1px solid black; width: 400px; padding: 8px;">
                    <?= $header->KualifikasiLainnya ?>
                </th>
            </tr>
        </table>

        <table cellpadding="6" cellspacing="0" style="margin-top:30px; margin-left:166px;">
            <!-- ROW TANGGAL -->
            <tr>
                <td colspan="5" style="text-align:right; font-weight:bold;">
                    Desa Air Tawar, <?= tgl_indo(date('Y-m-d')) ?>
                </td>
            </tr>

            <!-- ROW JUDUL -->
            <tr>
                <td style="width:150px; text-align:left; font-weight:bold;">Mengetahui,</td>
                <td style="width:20px;"></td>
                <td style="width:150px; text-align:left; font-weight:bold;">Menyetujui,</td>
                <td style="width:20px;"></td>
                <td style="width:150px; text-align:left; font-weight:bold;">Pemohon,</td>
            </tr>

            <!-- ROW TANDA TANGAN -->
            <tr>
                <td style="width:150px; height:90px; border:1px solid #000; text-align:center;">
                    <?php if ($header->AppStatus3 == 1) : ?>
                        <img src="<?= FCPATH ?>assets/img/approved2.png" width="96" style="margin-top:20px;">
                    <?php endif; ?>
                </td>

                <td style="width:20px;"></td>
                <td style="width:150px; height:90px; border:1px solid #000; text-align:center;">
                    <?php if ($header->AppStatus2 == 1) : ?>
                        <img src="<?= FCPATH ?>assets/img/approved2.png" width="96" style="margin-top:20px;">
                    <?php endif; ?>
                </td>
                <td style="width:20px;"></td>
                <td style="width:150px; height:90px; border:1px solid #000; text-align:center;">
                    <?php if ($header->AppStatus == 1) : ?>
                        <img src="<?= FCPATH ?>assets/img/approved2.png" width="96" style="margin-top:20px;">
                    <?php endif; ?>
                </td>
            </tr>

            <!-- ROW NAMA -->
            <tr>
                <td style="width:150px; text-align:center; font-weight:bold; text-decoration:underline;">
                    <?= $header->Approved3By ?>
                </td>
                <td></td>
                <td style="width:150px; text-align:center; font-weight:bold; text-decoration:underline;">
                    <?= $header->Approved2By ?>
                </td>
                <td></td>
                <td style="width:150px; text-align:center; font-weight:bold; text-decoration:underline;">
                    <?= $header->ApprovedBy ?>
                </td>
            </tr>

            <!-- ROW KETERANGAN -->
            <tr>
                <td style="width:150px; font-size:8px; color:gray; text-align:center;">
                    <em>Tanda tangan dan tuliskan nama jelas<br>dan jabatan tertinggi HR</em>
                </td>
                <td></td>
                <td style="width:150px; font-size:8px; color:gray; text-align:center;">
                    <em>Tanda tangan dan tuliskan nama jelas<br>dan jabatan tertinggi Divisi</em>
                </td>
                <td></td>
                <td style="width:150px; font-size:8px; color:gray; text-align:center;">
                    <em>Tanda tangan dan tuliskan nama jelas<br>dan jabatan pimpinan departemen</em>
                </td>
            </tr>
        </table>


    </div>


</page>

<!-- LAMPIRAN A -->
<?php if ($lampiranA) { ?>
    <page backtop="3mm" backbottom="15mm" backleft="6mm" backright="0mm">
        <table width="100%" border="0" cellpadding="9" cellspacing="6">
            <tr>
                <th style="font-weight: bold; font-size: 12px;" align="left">
                    <em>LAMPIRAN A<br> </em>
                </th>
            </tr>
            <tr>
                <th style="font-weight: bold; font-size: 12px;" align="left">
                    Uraian Penambahan Sub Jabatan Baru
                </th>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="9" cellspacing="6" style="margin-top: 10px;;">
            <tr>
                <td style="font-weight: bold; font-size: 12px; width:200px;" align="left">
                    Nama Sub Jabatan
                </td>
                <td style="border:1px solid black; width:493px; height: 20px;font-weight: bold; padding: 2px;">
                    <?= $lampiranA->NamaSubJabatan ?>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; font-size: 12px; width:200px;" align="left">
                    Level Jabatan
                </td>
                <td style="border:1px solid black; width:400px; height: 20px; font-weight: bold; padding: 2px;">
                    <?= $lampiranA->LevelJabatan ?>
                </td>
            </tr>
        </table>

        <table width="100%" cellpadding="9" cellspacing="6" style="margin-top: 10px;" border="0">
            <tr>

                <td style="font-weight: bold; font-size: 12px; width:200px;" align="left">
                    <b>Pengisi Sub Jabatan</b><br>
                    <em style="font-size:8px;color:gray;">
                        (mohon beri catatan untuk promosi/rotasi apakah <br> jabatan lama ybs akan mengalami perubahan MPP)
                    </em>
                </td>


                <td style="width:150px; vertical-align:top;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="width:20px;">
                                <div style="width:16px;height:16px;border:1px solid #000; background:<?= $lampiranA->PengisiSubJabatan == 'Promosi' ? '#000' : '#fff' ?>;"> </div>
                            </td>
                            <td style="padding-left:6px;">
                                <b>Pomosi</b>
                            </td>
                        </tr>
                    </table>
                </td>


                <td style="width:150px; vertical-align:top;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="width:20px;">
                                <div style="width:16px;height:16px;border:1px solid #000;
                                background:<?= $lampiranA->PengisiSubJabatan == 'Rotasi' ? '#000' : '#fff' ?>;"></div>
                            </td>
                            <td style="padding-left:6px;">
                                <b>Rotasi</b>
                            </td>
                        </tr>
                    </table>
                </td>

                <td style="width:160px; vertical-align:top;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="width:20px;">
                                <div style="width:16px;height:16px;border:1px solid #000;
                                background:<?= $lampiranA->PengisiSubJabatan == 'Rekrut Baru' ? '#000' : '#fff' ?>;"></div>
                            </td>
                            <td style="padding-left:6px;">
                                <b>Rekrut Baru</b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>
        <table cellpadding="9" cellspacing="6" border="0">
            <tr>
                <td style="width: 200px;">

                </td>
                <td style="border:1px solid black; width:493px; height: 60px;font-weight: bold; padding: 2px;vertical-align:top;;" align="left">
                    Catatan: <br>
                    <p style="font-weight: normal;"><?= $lampiranA->Catatan ?></p>
                </td>
            </tr>
        </table>
        <table cellpadding="4" cellspacing="0" border="0" style="table-layout:fixed; width:720px; margin-top:8px;">
            <tr>
                <th align="left" style="font-size: 12px;">
                    <b>Tugas & Tanggung Jawab</b><br>
                    <em style="font-size:11px;color:gray;">
                        (Dibuat list secara detail yang menjadi tugas harian dan tugas tambahan dari pemegang jabatan)
                    </em>
                </th>
            </tr>
            <tr>
                <td>
                    <div style="height:100px;border:solid black 1px; padding:4px;">
                        <?= $lampiranA->TugasTanggungJawab ?>
                    </div>
                </td>
            </tr>
        </table>
        <table cellpadding="4" cellspacing="0" border="0" style="table-layout:fixed; width:720px; margin-top:8px;">
            <tr>
                <th align="left" style="font-size: 12px;">
                    <b>Wewenang</b><br>
                    <em style="font-size:11px;color:gray;">
                        (Kewenangan pemegang jabatan di posisi baru)
                    </em>
                </th>
            </tr>
            <tr>
                <td>
                    <div style="height:100px;border:solid black 1px; padding:4px;">
                        <?= $lampiranA->Wewenang ?>
                    </div>
                </td>
            </tr>
        </table>
        <table cellpadding="4" cellspacing="0" border="0" style="table-layout:fixed; width:720px; margin-top:8px;">
            <tr>
                <th align="left" style="font-size: 12px;">
                    <b>Target Kerja</b><br>
                    <em style="font-size:11px;color:gray;">
                        (Indikator keberhasilan dan target kunci dari pemegang jabatan)
                    </em>
                </th>
            </tr>
            <tr>
                <td>
                    <div style="height:100px;border:solid black 1px; padding:4px;">
                        <?= $lampiranA->TargetKerja ?>
                    </div>
                </td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="9" cellspacing="6" style="margin-top: 10px;;">
            <tr>
                <td style="font-weight: bold; font-size: 12px; width:200px;" align="left">
                    Hubungan atasan bawahan <br>
                    <em style="font-size: 8px;color:gray;">
                        (uraikan jumlah atasan, bawahan, hingga tim kerja <br>
                        jabatan terkait)
                    </em>
                </td>
                <td style="border:1px solid black; width:493px; height: 20px;font-weight: bold; padding: 2px;">
                    <?= $lampiranA->HubunganAtasanBawahan ?>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; font-size: 12px; width:200px;" align="left">
                    Hubungan Internal <br>
                    <em style="font-size: 8px;color:gray;">
                        (pihak di dalam departemen terkait yang akan sering <br>
                        berhubungan dengan jabatan baru) </em>
                </td>
                <td style="border:1px solid black; width:400px; height: 20px; font-weight: bold; padding: 2px;">
                    <?= $lampiranA->HubunganInternal ?>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; font-size: 12px; width:200px;" align="left">
                    Hubungan Eksternal <br>
                    <em style="font-size: 8px;color:gray;">
                        (pihak di dalam departemen terkait yang akan sering <br>
                        berhubungan dengan jabatan baru) </em>
                </td>
                <td style="border:1px solid black; width:400px; height: 20px; font-weight: bold; padding: 2px;">
                    <?= $lampiranA->HubunganEksternal ?>
                </td>
            </tr>
        </table>
    </page>
<?php } ?>

<!-- LAMPIRAN B -->
<?php if ($lampiranB) { ?>
    <page backtop="3mm" backbottom="15mm" backleft="6mm" backright="0mm">
        <table width="100%" border="0" cellpadding="9" cellspacing="6">
            <tr>
                <th style="font-weight: bold; font-size: 12px;" align="left">
                    <em>LAMPIRAN B<br> </em>
                </th>
            </tr>
            <tr>
                <th style="font-weight: bold; font-size: 12px;" align="left">
                    Uraian Penambahan Sub Jabatan Lama
                </th>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="9" cellspacing="6" style="margin-top: 10px;;">
            <tr>
                <td style="font-weight: bold; font-size: 12px; width:200px;" align="left">
                    Nama Sub Jabatan
                </td>
                <td style="border:1px solid black; width:493px; height: 20px;font-weight: bold; padding: 2px;">
                    <?= $lampiranB->NamaSubJabatan ?>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; font-size: 12px; width:200px;" align="left">
                    Level Jabatan
                </td>
                <td style="border:1px solid black; width:400px; height: 20px; font-weight: bold; padding: 2px;">
                    <?= $lampiranB->LevelJabatan ?>
                </td>
            </tr>
        </table>

        <table width="100%" cellpadding="9" cellspacing="6" style="margin-top: 10px;" border="0">
            <tr>

                <td style="font-weight: bold; font-size: 12px; width:200px;" align="left">
                    <b>Pengisi Sub Jabatan</b><br>
                    <em style="font-size:8px;color:gray;">
                        (mohon beri catatan untuk promosi/rotasi apakah <br> jabatan lama ybs akan mengalami perubahan MPP)
                    </em>
                </td>


                <td style="width:150px; vertical-align:top;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="width:20px;">
                                <div style="width:16px;height:16px;border:1px solid #000; background:<?= $lampiranB->PengisiSubJabatan == 'Promosi' ? '#000' : '#fff' ?>;"> </div>
                            </td>
                            <td style="padding-left:6px;">
                                <b>Promosi</b>
                            </td>
                        </tr>
                    </table>
                </td>


                <td style="width:150px; vertical-align:top;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="width:20px;">
                                <div style="width:16px;height:16px;border:1px solid #000;
                                background:<?= $lampiranB->PengisiSubJabatan == 'Rotasi' ? '#000' : '#fff' ?>;"></div>
                            </td>
                            <td style="padding-left:6px;">
                                <b>Rotasi</b>
                            </td>
                        </tr>
                    </table>
                </td>

                <td style="width:160px; vertical-align:top;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="width:20px;">
                                <div style="width:16px;height:16px;border:1px solid #000;
                                background:<?= $lampiranB->PengisiSubJabatan == 'Rekrut Baru' ? '#000' : '#fff' ?>;"></div>
                            </td>
                            <td style="padding-left:6px;">
                                <b>Rekrut Baru</b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>
        <table cellpadding="9" cellspacing="6" border="0">
            <tr>
                <td style="width: 200px;">

                </td>
                <td style="border:1px solid black; width:493px; height: 60px;font-weight: bold; padding: 2px;vertical-align:top;;" align="left">
                    Catatan: <br>
                    <p style="font-weight: normal;"><?= $lampiranB->Catatan ?></p>
                </td>
            </tr>
        </table>
        <table cellpadding="4" cellspacing="0" border="0" style="table-layout:fixed; width:720px; margin-top:8px;">
            <tr>
                <th align="left" style="font-size: 12px;">
                    <b>Tugas & Tanggung Jawab</b><br>
                    <em style="font-size:11px;color:gray;">
                        (Dibuat list secara detail yang menjadi tugas harian dan tugas tambahan dari pemegang jabatan)
                    </em>
                </th>
            </tr>
            <tr>
                <td>
                    <div style="height:100px;border:solid black 1px; padding:4px;">
                        <?= $lampiranB->TugasTanggungJawab ?>
                    </div>
                </td>
            </tr>
        </table>
        <table cellpadding="4" cellspacing="0" border="0" style="table-layout:fixed; width:720px; margin-top:8px;">
            <tr>
                <th align="left" style="font-size: 12px;">
                    <b>Wewenang</b><br>
                    <em style="font-size:11px;color:gray;">
                        (Kewenangan pemegang jabatan di posisi baru)
                    </em>
                </th>
            </tr>
            <tr>
                <td>
                    <div style="height:100px;border:solid black 1px; padding:4px;">
                        <?= $lampiranB->Wewenang ?>
                    </div>
                </td>
            </tr>
        </table>
        <table cellpadding="4" cellspacing="0" border="0" style="table-layout:fixed; width:720px; margin-top:8px;">
            <tr>
                <th align="left" style="font-size: 12px;">
                    <b>Koordinasi</b><br>
                    <em style="font-size:11px;color:gray;">
                        (Bagaimana antar pemegang jabatan ini berinteraksi atau berkolaborasi (Misal: ada yang fokus pada operasional, yang <br>
                        lain pada dokumen atau lainnya)
                    </em>
                </th>
            </tr>
            <tr>
                <td>
                    <div style="height:100px;border:solid black 1px; padding:4px;">
                        <?= $lampiranB->Koordinasi ?>
                    </div>
                </td>
            </tr>
        </table>
        <table cellpadding="4" cellspacing="0" border="0" style="table-layout:fixed; width:720px; margin-top:8px;">
            <tr>
                <th align="left" style="font-size: 12px;">
                    <b>Pelaporan*</b><br>
                    <em style="font-size:11px;color:gray;">
                        *hanya untuk jabatan manajerial/memiliki anak buah <br>
                        (Bagaimana tim kerja di bawah posisi ini akan melapor? Pembagian porsi leadership dengan pemegang jabatan yang <br>
                        sama sebelumnya)
                    </em>
                </th>
            </tr>
            <tr>
                <td>
                    <div style="height:100px;border:solid black 1px; padding:4px;">
                        <?= $lampiranB->Pelaporan ?>
                    </div>
                </td>
            </tr>
        </table>

    </page>
<?php } ?>