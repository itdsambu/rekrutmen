<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
            color: #000;
        }

        table {
            font-size: 10px;
            border-collapse: collapse;
        }

        .header-title {
            font-size: 26px;
            font-weight: bold;
            color: #1b3c8b;
        }

        .small {
            font-size: 9px;
            color: #1b3c8b;
        }

        .italic-hint {
            font-size: 9px;
            color: gray;
            font-style: italic;
        }

        .bold {
            font-weight: bold;
        }

        /* Field row: label kiri, value kanan full width */
        .tbl-field {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .tbl-field td.lbl {
            font-weight: bold;
            width: 185px;
            padding: 5px 6px 5px 0;
            vertical-align: middle;
        }

        .tbl-field td.val {
            border: 1px solid #000;
            padding: 5px 8px;
            height: 24px;
            vertical-align: middle;
        }

        .tbl-field tr:not(:last-child) td.val {
            border-bottom: none;
        }

        /* Box textarea besar */
        .area-box {
            border: 1px solid #000;
            min-height: 85px;
            padding: 5px 8px;
            font-size: 10px;
            width: 100%;
        }

        /* Checkbox via td */
        td.cb-box {
            width: 13px;
            height: 13px;
            border: 1px solid #000;
            background: #fff;
            vertical-align: middle;
            padding: 0;
        }

        td.cb-box-filled {
            width: 13px;
            height: 13px;
            border: 1px solid #000;
            background: #000;
            vertical-align: middle;
            padding: 0;
        }

        td.cb-label {
            padding-left: 5px;
            vertical-align: middle;
            white-space: nowrap;
        }

        /* Kotak angka jumlah pemangku */
        td.num-box {
            width: 26px;
            height: 18px;
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
            padding: 1px;
        }

        /* Tanda tangan */
        td.ttd-box {
            width: 140px;
            height: 80px;
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
        }

        .sec-head {
            font-weight: bold;
            padding: 4px 0 2px 0;
            font-size: 10px;
        }

        /* Hubungan row */
        .tbl-hub {
            width: 100%;
            border-collapse: collapse;
        }

        .tbl-hub td.hub-lbl {
            width: 185px;
            font-weight: bold;
            font-size: 10px;
            vertical-align: top;
            padding: 4px 6px 4px 0;
        }

        .tbl-hub td.hub-val {
            border: 1px solid #000;
            padding: 5px 8px;
            min-height: 28px;
            vertical-align: middle;
        }

        .tbl-hub tr:not(:last-child) td.hub-val {
            border-bottom: none;
        }
    </style>
</head>

<body>

    <!-- ============================================================ -->
    <!-- HALAMAN 1: FORM UTAMA                                        -->
    <!-- ============================================================ -->

    <table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tr>
            <td width="120" align="center" valign="middle" rowspan="2" style="padding-right:10px;">
                <img src="<?= FCPATH ?>assets/images/logo_terbaru.png" width="90" height="90" />
            </td>
            <td valign="top" style="padding-bottom:2px;">
                <span class="header-title">PT PULAU SAMBU</span>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <table width="100%" border="0" cellpadding="1" cellspacing="0">
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

    <p class="small" align="center" style="margin:3px 0;">website: www.sambugroup.com</p>
    <hr style="border:none; border-top:2px solid #1b3c8b; margin:3px 0 6px 0;" />

    <table border="1" cellpadding="6" cellspacing="0" style="width:65%; margin:4px auto; border-collapse:collapse;">
        <tr>
            <th align="center" style="font-weight:bold; font-size:11px;">FORM PERMINTAAN PERUBAHAN ORGANISASI</th>
        </tr>
    </table>

    <br>

    <!-- DIVISI ~ SUBJABATAN -->
    <table class="tbl-field">
        <tr>
            <td class="lbl">DIVISI</td>
            <td class="val"><?= $header->Divisi ?></td>
        </tr>
        <tr>
            <td class="lbl">DEPARTEMEN</td>
            <td class="val"><?= $header->Departemen ?></td>
        </tr>
        <tr>
            <td class="lbl">
                SUB DEPARTEMEN<br>
                <span class="italic-hint">(contoh MP1, MP2, MPM)</span>
            </td>
            <td class="val"><?= $header->SubDepartemen ?></td>
        </tr>
        <tr>
            <td class="lbl">JABATAN</td>
            <td class="val"><?= $header->Jabatan ?></td>
        </tr>
        <tr>
            <td class="lbl">SUBJABATAN</td>
            <td class="val" style="border-bottom:1px solid #000;"><?= $header->SubJabatan ?></td>
        </tr>
    </table>

    <br>

    <!-- STATUS JABATAN -->
    <table width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
            <td style="width:185px; vertical-align:top; font-weight:bold;">
                STATUS JABATAN<br>
                <span class="italic-hint">(beri tanda pada kolom samping)</span>
            </td>
            <td style="width:175px; vertical-align:top;">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="<?= $header->TipePerubahan == 1 ? 'cb-box-filled' : 'cb-box' ?>">&nbsp;</td>
                        <td class="cb-label"><b>BARU*</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"><span class="italic-hint">(belum ada di MPP)</span></td>
                    </tr>
                </table>
            </td>
            <td style="width:175px; vertical-align:top;">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="<?= $header->TipePerubahan == 2 ? 'cb-box-filled' : 'cb-box' ?>">&nbsp;</td>
                        <td class="cb-label"><b>LAMA**</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"><span class="italic-hint">(sudah ada di MPP)</span></td>
                    </tr>
                </table>
            </td>
            <td style="vertical-align:top;">
                <span class="italic-hint">*) Mengisi Lampiran A<br>**) Mengisi Lampiran B</span>
            </td>
        </tr>
    </table>

    <!-- JUMLAH PEMANGKU JABATAN -->
    <table width="100%" border="0" cellpadding="3" cellspacing="0" style="margin-top:4px;">
        <tr>
            <td style="width:185px; vertical-align:top; font-weight:bold;">
                JUMLAH PEMANGKU JABATAN<br>
                <span class="italic-hint">(isi jumlah orang pada kolom samping)</span>
            </td>
            <td style="width:175px; vertical-align:top;">
                <table border="0" cellpadding="0" cellspacing="2">
                    <tr>
                        <td class="num-box"><?= $header->JumlahSebelum ?></td>
                        <td style="padding-left:4px; vertical-align:middle; font-weight:bold;">SEBELUM</td>
                    </tr>
                    <tr>
                        <td colspan="2"><span class="italic-hint">(jumlah orang di MPP)</span></td>
                    </tr>
                </table>
            </td>
            <td style="vertical-align:top;">
                <table border="0" cellpadding="0" cellspacing="2">
                    <tr>
                        <td class="num-box"><?= $header->JumlahSesudah ?></td>
                        <td style="padding-left:4px; vertical-align:middle; font-weight:bold;">SESUDAH</td>
                    </tr>
                    <tr>
                        <td colspan="2"><span class="italic-hint">(jumlah orang yang diajukan)</span></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- SIFAT PERUBAHAN -->
    <table width="100%" border="0" cellpadding="3" cellspacing="0" style="margin-top:4px;">
        <tr>
            <td style="width:185px; vertical-align:top; font-weight:bold;">
                SIFAT PERUBAHAN<br>
                <span class="italic-hint">(beri tanda pada kolom samping)</span>
            </td>
            <td style="width:175px; vertical-align:top;">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="<?= $header->SifatPerubahan == 'PENAMBAHAN' ? 'cb-box-filled' : 'cb-box' ?>">&nbsp;</td>
                        <td class="cb-label"><b>PENAMBAHAN</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"><span class="italic-hint">(menambah jumlah total MPP)</span></td>
                    </tr>
                </table>
            </td>
            <td style="width:175px; vertical-align:top;">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="<?= $header->SifatPerubahan == 'TETAP' ? 'cb-box-filled' : 'cb-box' ?>">&nbsp;</td>
                        <td class="cb-label"><b>TETAP</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"><span class="italic-hint">(tidak merubah jumlah total MPP)</span></td>
                    </tr>
                </table>
            </td>
            <td style="vertical-align:top;">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="<?= $header->SifatPerubahan == 'PENGURANGAN' ? 'cb-box-filled' : 'cb-box' ?>">&nbsp;</td>
                        <td class="cb-label"><b>PENGURANGAN</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"><span class="italic-hint">(mengurangi jumlah total MPP)</span></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- LATAR BELAKANG -->
    <div class="sec-head" style="margin-top:8px;">
        LATAR BELAKANG PERUBAHAN<br>
        <span class="italic-hint">(uraikan latar belakang perubahan organisasi)</span>
    </div>
    <div class="area-box"><?= $header->LatarBelakang ?></div>

    <!-- PROYEKSI DAMPAK -->
    <div class="sec-head" style="margin-top:8px;">
        PROYEKSI DAMPAK/VALUE<br>
        <span class="italic-hint">(dampak perubahan terhadap operasional saat ini dan perusahaan kedepannya)</span>
    </div>
    <div class="area-box"><?= $header->ProyeksiDampak ?></div>

    <!-- STRUKTUR ORGANISASI -->
    <div class="sec-head" style="margin-top:8px;">
        STRUKTUR ORGANISASI<br>
        <span class="italic-hint">(gambarkan struktur organisasi setelah perubahan, jika tidak mengubah struktur organisasi tetap digambarkan letak jabatannya)</span>
    </div>
    <div class="area-box"><?= $header->StrukturOrganisasi ?></div>

    <!-- KUALIFIKASI KANDIDAT -->
    <div class="sec-head" style="margin-top:8px;">
        KUALIFIKASI KANDIDAT<br>
        <span class="italic-hint">yang dibutuhkan untuk pengisi jabatan</span>
    </div>

    <table class="tbl-field" style="margin-top:2px;">
        <tr>
            <td class="lbl">Latar belakang pendidikan dan jurusan</td>
            <td style="width:10px; padding:0 5px; vertical-align:middle;">:</td>
            <td class="val"><?= $header->KualifikasiPendidikan ?></td>
        </tr>
        <tr>
            <td class="lbl">Pengalaman bekerja</td>
            <td style="width:10px; padding:0 5px;">:</td>
            <td class="val"><?= $header->KualifikasiPengalaman ?></td>
        </tr>
        <tr>
            <td class="lbl">Pengalaman manajerial</td>
            <td style="width:10px; padding:0 5px;">:</td>
            <td class="val"><?= $header->KualifikasiManajerial ?></td>
        </tr>
        <tr>
            <td class="lbl">Kompetensi teknis dan non teknis</td>
            <td style="width:10px; padding:0 5px;">:</td>
            <td class="val"><?= $header->KualifikasiKompetensi ?></td>
        </tr>
        <tr>
            <td class="lbl">Sertifikasi/Izin</td>
            <td style="width:10px; padding:0 5px;">:</td>
            <td class="val"><?= $header->KualifikasiSertifikasi ?></td>
        </tr>
        <tr>
            <td class="lbl">Lain-lain</td>
            <td style="width:10px; padding:0 5px;">:</td>
            <td class="val" style="border-bottom:1px solid #000;"><?= $header->KualifikasiLainnya ?></td>
        </tr>
    </table>

    <!-- TANDA TANGAN -->
    <table width="100%" border="0" cellpadding="4" cellspacing="0" style="margin-top:22px;">
        <tr>
            <td style="width:185px;"></td>
            <td colspan="5" align="right" style="font-weight:bold; font-size:10px;">
                Desa Air Tawar, <?= tgl_indo(date('Y-m-d')) ?>
            </td>
        </tr>
        <tr>
            <td style="width:185px;"></td>
            <td style="width:140px; font-weight:bold;">Mengetahui,</td>
            <td style="width:18px;"></td>
            <td style="width:140px; font-weight:bold;">Menyetujui,</td>
            <td style="width:18px;"></td>
            <td style="width:140px; font-weight:bold;">Pemohon,</td>
        </tr>
        <tr>
            <td style="width:185px;"></td>
            <td class="ttd-box">
                <?php if ($header->AppStatus3 == 1) : ?>
                    <img src="<?= FCPATH ?>assets/img/approved2.png" width="80">
                <?php endif; ?>
            </td>
            <td></td>
            <td class="ttd-box">
                <?php if ($header->AppStatus2 == 1) : ?>
                    <img src="<?= FCPATH ?>assets/img/approved2.png" width="80">
                <?php endif; ?>
            </td>
            <td></td>
            <td class="ttd-box">
                <?php if ($header->AppStatus == 1) : ?>
                    <img src="<?= FCPATH ?>assets/img/approved2.png" width="80">
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td align="center" style="font-weight:bold; text-decoration:underline;"><?= $header->Approved3By ?></td>
            <td></td>
            <td align="center" style="font-weight:bold; text-decoration:underline;"><?= $header->Approved2By ?></td>
            <td></td>
            <td align="center" style="font-weight:bold; text-decoration:underline;"><?= $header->ApprovedBy ?></td>
        </tr>
        <tr>
            <td></td>
            <td align="center" style="font-size:8px; color:gray;"><em>Tanda tangan dan tuliskan nama jelas<br>dan jabatan tertinggi HR</em></td>
            <td></td>
            <td align="center" style="font-size:8px; color:gray;"><em>Tanda tangan dan tuliskan nama jelas<br>dan jabatan tertinggi Divisi</em></td>
            <td></td>
            <td align="center" style="font-size:8px; color:gray;"><em>Tanda tangan dan tuliskan nama jelas<br>dan jabatan pimpinan departemen</em></td>
        </tr>
    </table>


    <!-- ============================================================ -->
    <!-- HALAMAN 2: LAMPIRAN A                                        -->
    <!-- ============================================================ -->
    <?php if ($lampiranA) : ?>
        <pagebreak />

        <p style="font-style:italic; font-weight:bold; font-size:12px; margin:0 0 2px 0;">LAMPIRAN A</p>
        <p style="font-weight:bold; font-size:11px; margin:0 0 8px 0;">Uraian Penambahan Sub Jabatan Baru</p>

        <table class="tbl-field">
            <tr>
                <td class="lbl" style="font-size:11px;">Nama Sub Jabatan</td>
                <td class="val"><?= $lampiranA->NamaSubJabatan ?></td>
            </tr>
            <tr>
                <td class="lbl" style="font-size:11px;">Level Jabatan</td>
                <td class="val" style="border-bottom:1px solid #000;"><?= $lampiranA->LevelJabatan ?></td>
            </tr>
        </table>

        <br>

        <table width="100%" border="0" cellpadding="3" cellspacing="0">
            <tr>
                <td style="width:185px; vertical-align:top; font-weight:bold; font-size:11px;">
                    Pengisi Sub Jabatan<br>
                    <span class="italic-hint">(mohon beri catatan untuk promosi/rotasi apakah jabatan lama ybs akan mengalami perubahan MPP)</span>
                </td>
                <td style="width:130px; vertical-align:middle;">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="<?= $lampiranA->PengisiSubJabatan == 'Promosi' ? 'cb-box-filled' : 'cb-box' ?>">&nbsp;</td>
                            <td class="cb-label"><b>Promosi</b></td>
                        </tr>
                    </table>
                </td>
                <td style="width:120px; vertical-align:middle;">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="<?= $lampiranA->PengisiSubJabatan == 'Rotasi' ? 'cb-box-filled' : 'cb-box' ?>">&nbsp;</td>
                            <td class="cb-label"><b>Rotasi</b></td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align:middle;">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="<?= $lampiranA->PengisiSubJabatan == 'Rekrut Baru' ? 'cb-box-filled' : 'cb-box' ?>">&nbsp;</td>
                            <td class="cb-label"><b>Rekrut Baru</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:6px;">
            <tr>
                <td style="width:185px;"></td>
                <td style="border:1px solid #000; padding:6px 8px; min-height:60px; vertical-align:top;">
                    <b>Catatan:</b><br>
                    <span style="font-weight:normal;"><?= $lampiranA->Catatan ?></span>
                </td>
            </tr>
        </table>

        <div class="sec-head" style="margin-top:10px; font-size:11px;">
            Tugas &amp; Tanggung Jawab<br>
            <span class="italic-hint">(Dibuat list secara detail yang menjadi tugas harian dan tugas tambahan dari pemegang jabatan)</span>
        </div>
        <div class="area-box"><?= $lampiranA->TugasTanggungJawab ?></div>

        <div class="sec-head" style="margin-top:8px; font-size:11px;">
            Wewenang<br>
            <span class="italic-hint">(Kewenangan pemegang jabatan di posisi baru)</span>
        </div>
        <div class="area-box"><?= $lampiranA->Wewenang ?></div>

        <div class="sec-head" style="margin-top:8px; font-size:11px;">
            Target Kerja<br>
            <span class="italic-hint">(Indikator keberhasilan dan target kunci dari pemegang jabatan)</span>
        </div>
        <div class="area-box"><?= $lampiranA->TargetKerja ?></div>

        <br>

        <table class="tbl-hub" style="margin-top:4px;">
            <tr>
                <td class="hub-lbl">
                    Hubungan atasan bawahan<br>
                    <span class="italic-hint">(uraikan jumlah atasan, bawahan, hingga tim kerja jabatan terkait)</span>
                </td>
                <td class="hub-val"><?= $lampiranA->HubunganAtasanBawahan ?></td>
            </tr>
            <tr>
                <td class="hub-lbl">
                    Hubungan Internal<br>
                    <span class="italic-hint">(pihak di dalam departemen terkait yang akan sering berhubungan dengan jabatan baru)</span>
                </td>
                <td class="hub-val"><?= $lampiranA->HubunganInternal ?></td>
            </tr>
            <tr>
                <td class="hub-lbl">
                    Hubungan Eksternal<br>
                    <span class="italic-hint">(pihak di luar departemen terkait yang akan sering berhubungan dengan jabatan baru)</span>
                </td>
                <td class="hub-val" style="border-bottom:1px solid #000;"><?= $lampiranA->HubunganEksternal ?></td>
            </tr>
        </table>
    <?php endif; ?>


    <!-- ============================================================ -->
    <!-- HALAMAN 3: LAMPIRAN B                                        -->
    <!-- ============================================================ -->
    <?php if ($lampiranB) : ?>
        <pagebreak />

        <p style="font-style:italic; font-weight:bold; font-size:12px; margin:0 0 2px 0;">LAMPIRAN B</p>
        <p style="font-weight:bold; font-size:11px; margin:0 0 8px 0;">Uraian Penambahan Sub Jabatan Lama</p>

        <table class="tbl-field">
            <tr>
                <td class="lbl" style="font-size:11px;">Nama Sub Jabatan</td>
                <td class="val"><?= $lampiranB->NamaSubJabatan ?></td>
            </tr>
            <tr>
                <td class="lbl" style="font-size:11px;">Level Jabatan</td>
                <td class="val" style="border-bottom:1px solid #000;"><?= $lampiranB->LevelJabatan ?></td>
            </tr>
        </table>

        <br>

        <table width="100%" border="0" cellpadding="3" cellspacing="0">
            <tr>
                <td style="width:185px; vertical-align:top; font-weight:bold; font-size:11px;">
                    Pengisi Sub Jabatan<br>
                    <span class="italic-hint">(mohon beri catatan untuk promosi/rotasi apakah jabatan lama ybs akan mengalami perubahan MPP)</span>
                </td>
                <td style="width:130px; vertical-align:middle;">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="<?= $lampiranB->PengisiSubJabatan == 'Promosi' ? 'cb-box-filled' : 'cb-box' ?>">&nbsp;</td>
                            <td class="cb-label"><b>Promosi</b></td>
                        </tr>
                    </table>
                </td>
                <td style="width:120px; vertical-align:middle;">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="<?= $lampiranB->PengisiSubJabatan == 'Rotasi' ? 'cb-box-filled' : 'cb-box' ?>">&nbsp;</td>
                            <td class="cb-label"><b>Rotasi</b></td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align:middle;">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="<?= $lampiranB->PengisiSubJabatan == 'Rekrut Baru' ? 'cb-box-filled' : 'cb-box' ?>">&nbsp;</td>
                            <td class="cb-label"><b>Rekrut Baru</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:6px;">
            <tr>
                <td style="width:185px;"></td>
                <td style="border:1px solid #000; padding:6px 8px; min-height:60px; vertical-align:top;">
                    <b>Catatan:</b><br>
                    <span style="font-weight:normal;"><?= $lampiranB->Catatan ?></span>
                </td>
            </tr>
        </table>

        <div class="sec-head" style="margin-top:10px; font-size:11px;">
            Tugas &amp; Tanggung Jawab<br>
            <span class="italic-hint">(Dibuat list secara detail yang menjadi tugas harian dan tugas tambahan dari pemegang jabatan)</span>
        </div>
        <div class="area-box"><?= $lampiranB->TugasTanggungJawab ?></div>

        <div class="sec-head" style="margin-top:8px; font-size:11px;">
            Wewenang<br>
            <span class="italic-hint">(Kewenangan pemegang jabatan di posisi baru)</span>
        </div>
        <div class="area-box"><?= $lampiranB->Wewenang ?></div>

        <div class="sec-head" style="margin-top:8px; font-size:11px;">
            Koordinasi<br>
            <span class="italic-hint">(Bagaimana antar pemegang jabatan ini berinteraksi atau berkolaborasi (Misal: ada yang fokus pada operasional, yang lain pada dokumen atau lainnya)</span>
        </div>
        <div class="area-box"><?= $lampiranB->Koordinasi ?></div>

        <div class="sec-head" style="margin-top:8px; font-size:11px;">
            Pelaporan*<br>
            <span class="italic-hint">
                *hanya untuk jabatan manajerial/memiliki anak buah<br>
                (Bagaimana tim kerja di bawah posisi ini akan melapor? Pembagian porsi leadership dengan pemegang jabatan yang sama sebelumnya)
            </span>
        </div>
        <div class="area-box"><?= $lampiranB->Pelaporan ?></div>

    <?php endif; ?>

</body>

</html>