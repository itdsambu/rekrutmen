<!-- VIEW: transaksi/perubahanmpp/exportpdf_main.php -->
<!-- Dirender sebagai string HTML lalu di-writeHTML() ke TCPDF per halaman -->
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10px;
    }

    table {
        font-size: 10px;
        border-collapse: collapse;
    }

    .header-title {
        font-size: 28px;
        font-weight: bold;
        color: #1b3c8b;
    }

    .small {
        font-size: 9px;
        color: #1b3c8b;
    }

    .line {
        border-top: 2px solid #1b3c8b;
        margin-top: 4px;
        margin-bottom: 6px;
    }

    .label {
        font-weight: bold;
    }

    .italic-hint {
        font-size: 9px;
        color: gray;
        font-style: italic;
    }

    .box {
        width: 14px;
        height: 14px;
        border: 1px solid #000;
        display: inline-block;
    }

    .box-filled {
        background-color: #000;
    }

    td,
    th {
        font-size: 10px;
    }
</style>

<!-- HEADER -->
<table width="100%" border="0" cellpadding="3" cellspacing="0">
    <tr>
        <td width="130" align="center" valign="middle">
            <img src="<?= FCPATH ?>assets/images/logo_terbaru.png" width="90" height="90" />
        </td>
        <td valign="top">
            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <td colspan="3" class="header-title">PT PULAU SAMBU</td>
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

<p class="small" align="center" style="margin: 2px 0;">website: www.sambugroup.com</p>
<hr style="border: 1px solid #1b3c8b; margin: 4px 0;" />

<!-- JUDUL FORM -->
<table width="65%" align="center" border="1" cellpadding="4" cellspacing="0" style="border-collapse:collapse; margin: 4px auto;">
    <tr>
        <th align="center" style="font-weight:bold; font-size:11px; border:1px solid #000;">
            FORM PERMINTAAN PERUBAHAN ORGANISASI
        </th>
    </tr>
</table>
<br>

<!-- DATA DIVISI dst -->
<table width="100%" border="0" cellpadding="4" cellspacing="0">
    <tr>
        <td style="width:200px; font-weight:bold;">DIVISI</td>
        <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; padding:4px; width:420px;"><?= $header->Divisi ?></td>
    </tr>
    <tr>
        <td style="font-weight:bold;">DEPARTEMEN</td>
        <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; padding:4px;"><?= $header->Departemen ?></td>
    </tr>
    <tr>
        <td style="font-weight:bold;">
            SUB DEPARTEMEN<br>
            <span class="italic-hint">(contoh MP1, MP2, MPM)</span>
        </td>
        <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; padding:4px;"><?= $header->SubDepartemen ?></td>
    </tr>
    <tr>
        <td style="font-weight:bold;">JABATAN</td>
        <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; padding:4px;"><?= $header->Jabatan ?></td>
    </tr>
    <tr>
        <td style="font-weight:bold;">SUBJABATAN</td>
        <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; border-bottom:1px solid #000; padding:4px;"><?= $header->SubJabatan ?></td>
    </tr>
</table>

<br>

<!-- STATUS JABATAN -->
<table width="100%" border="0" cellpadding="3" cellspacing="0">
    <tr>
        <td style="width:200px; vertical-align:top; font-weight:bold;">
            STATUS JABATAN<br>
            <span class="italic-hint">(beri tanda pada kolom samping)</span>
        </td>
        <td style="width:180px; vertical-align:top;">
            <table border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <td>
                        <div style="width:14px;height:14px;border:1px solid #000;background:<?= $header->TipePerubahan == 1 ? '#000' : '#fff' ?>;">&nbsp;</div>
                    </td>
                    <td style="padding-left:4px;"><b>BARU*</b><br><span class="italic-hint">(belum ada di MPP)</span></td>
                </tr>
            </table>
        </td>
        <td style="width:180px; vertical-align:top;">
            <table border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <td>
                        <div style="width:14px;height:14px;border:1px solid #000;background:<?= $header->TipePerubahan == 2 ? '#000' : '#fff' ?>;">&nbsp;</div>
                    </td>
                    <td style="padding-left:4px;"><b>LAMA**</b><br><span class="italic-hint">(sudah ada di MPP)</span></td>
                </tr>
            </table>
        </td>
        <td style="vertical-align:top;">
            <span class="italic-hint">
                *) Mengisi Lampiran A<br>
                **) Mengisi Lampiran B
            </span>
        </td>
    </tr>
</table>

<!-- JUMLAH PEMANGKU JABATAN -->
<table width="100%" border="0" cellpadding="3" cellspacing="0" style="margin-top:4px;">
    <tr>
        <td style="width:200px; vertical-align:top; font-weight:bold;">
            JUMLAH PEMANGKU JABATAN<br>
            <span class="italic-hint">(isi jumlah orang pada kolom samping)</span>
        </td>
        <td style="width:180px; vertical-align:top;">
            <table border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <td>
                        <div style="width:14px;height:14px;border:1px solid #000;" align="center"><?= $header->JumlahSebelum ?></div>
                    </td>
                    <td style="padding-left:4px;"><b>SEBELUM</b><br><span class="italic-hint">(jumlah orang di MPP)</span></td>
                </tr>
            </table>
        </td>
        <td style="vertical-align:top;">
            <table border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <td>
                        <div style="width:14px;height:14px;border:1px solid #000;" align="center"><?= $header->JumlahSesudah ?></div>
                    </td>
                    <td style="padding-left:4px;"><b>SESUDAH</b><br><span class="italic-hint">(jumlah orang yang diajukan)</span></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- SIFAT PERUBAHAN -->
<table width="100%" border="0" cellpadding="3" cellspacing="0" style="margin-top:4px;">
    <tr>
        <td style="width:200px; vertical-align:top; font-weight:bold;">
            SIFAT PERUBAHAN<br>
            <span class="italic-hint">(beri tanda pada kolom samping)</span>
        </td>
        <td style="width:170px; vertical-align:top;">
            <table border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <td>
                        <div style="width:14px;height:14px;border:1px solid #000;background:<?= $header->SifatPerubahan == 'PENAMBAHAN' ? '#000' : '#fff' ?>;">&nbsp;</div>
                    </td>
                    <td style="padding-left:4px;"><b>PENAMBAHAN</b><br><span class="italic-hint">(menambah jumlah total MPP)</span></td>
                </tr>
            </table>
        </td>
        <td style="width:160px; vertical-align:top;">
            <table border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <td>
                        <div style="width:14px;height:14px;border:1px solid #000;background:<?= $header->SifatPerubahan == 'TETAP' ? '#000' : '#fff' ?>;">&nbsp;</div>
                    </td>
                    <td style="padding-left:4px;"><b>TETAP</b><br><span class="italic-hint">(tidak merubah jumlah total MPP)</span></td>
                </tr>
            </table>
        </td>
        <td style="vertical-align:top;">
            <table border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <td>
                        <div style="width:14px;height:14px;border:1px solid #000;background:<?= $header->SifatPerubahan == 'PENGURANGAN' ? '#000' : '#fff' ?>;">&nbsp;</div>
                    </td>
                    <td style="padding-left:4px;"><b>PENGURANGAN</b><br><span class="italic-hint">(mengurangi jumlah total MPP)</span></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- LATAR BELAKANG -->
<table width="100%" border="0" cellpadding="3" cellspacing="0" style="margin-top:6px;">
    <tr>
        <th align="left" style="font-weight:bold;">
            LATAR BELAKANG PERUBAHAN<br>
            <span class="italic-hint">(uraikan latar belakang perubahan organisasi)</span>
        </th>
    </tr>
    <tr>
        <td>
            <div style="min-height:80px; border:1px solid #000; padding:4px;"><?= $header->LatarBelakang ?></div>
        </td>
    </tr>
</table>

<!-- PROYEKSI DAMPAK -->
<table width="100%" border="0" cellpadding="3" cellspacing="0" style="margin-top:6px;">
    <tr>
        <th align="left" style="font-weight:bold;">
            PROYEKSI DAMPAK/VALUE<br>
            <span class="italic-hint">(dampak perubahan terhadap operasional saat ini dan perusahaan kedepannya)</span>
        </th>
    </tr>
    <tr>
        <td>
            <div style="min-height:80px; border:1px solid #000; padding:4px;"><?= $header->ProyeksiDampak ?></div>
        </td>
    </tr>
</table>

<!-- STRUKTUR ORGANISASI -->
<table width="100%" border="0" cellpadding="3" cellspacing="0" style="margin-top:6px;">
    <tr>
        <th align="left" style="font-weight:bold;">
            STRUKTUR ORGANISASI<br>
            <span class="italic-hint">(gambarkan struktur organisasi setelah perubahan, jika tidak mengubah struktur organisasi tetap digambarkan letak jabatannya)</span>
        </th>
    </tr>
    <tr>
        <td>
            <div style="min-height:80px; border:1px solid #000; padding:4px;"><?= $header->StrukturOrganisasi ?></div>
        </td>
    </tr>
</table>

<!-- KUALIFIKASI KANDIDAT -->
<table width="100%" border="0" cellpadding="3" cellspacing="0" style="margin-top:6px;">
    <tr>
        <th align="left" style="font-weight:bold;">
            KUALIFIKASI KANDIDAT<br>
            <span class="italic-hint">yang dibutuhkan untuk pengisi jabatan</span>
        </th>
    </tr>
</table>

<table width="100%" border="0" cellpadding="4" cellspacing="0" style="margin-top:4px;">
    <tr>
        <td style="width:200px; font-weight:bold;">Latar belakang pendidikan dan jurusan</td>
        <td style="width:10px;">:</td>
        <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; padding:4px;"><?= $header->KualifikasiPendidikan ?></td>
    </tr>
    <tr>
        <td style="font-weight:bold;">Pengalaman bekerja</td>
        <td>:</td>
        <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; padding:4px;"><?= $header->KualifikasiPengalaman ?></td>
    </tr>
    <tr>
        <td style="font-weight:bold;">Pengalaman manajerial</td>
        <td>:</td>
        <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; padding:4px;"><?= $header->KualifikasiManajerial ?></td>
    </tr>
    <tr>
        <td style="font-weight:bold;">Kompetensi teknis dan non teknis</td>
        <td>:</td>
        <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; padding:4px;"><?= $header->KualifikasiKompetensi ?></td>
    </tr>
    <tr>
        <td style="font-weight:bold;">Sertifikasi/Izin</td>
        <td>:</td>
        <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; padding:4px;"><?= $header->KualifikasiSertifikasi ?></td>
    </tr>
    <tr>
        <td style="font-weight:bold;">Lain-lain</td>
        <td>:</td>
        <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; border-bottom:1px solid #000; padding:4px;"><?= $header->KualifikasiLainnya ?></td>
    </tr>
</table>

<!-- TANDA TANGAN -->
<table border="0" cellpadding="4" cellspacing="0" style="margin-top:20px; width:100%;">
    <tr>
        <td style="width:200px;"></td>
        <td colspan="5" align="right" style="font-weight:bold; font-size:10px;">
            Desa Air Tawar, <?= tgl_indo(date('Y-m-d')) ?>
        </td>
    </tr>
    <tr>
        <td style="width:200px;"></td>
        <td style="width:140px; font-weight:bold; text-align:left;">Mengetahui,</td>
        <td style="width:20px;"></td>
        <td style="width:140px; font-weight:bold; text-align:left;">Menyetujui,</td>
        <td style="width:20px;"></td>
        <td style="width:140px; font-weight:bold; text-align:left;">Pemohon,</td>
    </tr>
    <tr>
        <td style="width:200px;"></td>
        <td style="width:140px; height:80px; border:1px solid #000; text-align:center; vertical-align:middle;">
            <?php if ($header->AppStatus3 == 1) : ?>
                <img src="<?= FCPATH ?>assets/img/approved2.png" width="80">
            <?php endif; ?>
        </td>
        <td></td>
        <td style="width:140px; height:80px; border:1px solid #000; text-align:center; vertical-align:middle;">
            <?php if ($header->AppStatus2 == 1) : ?>
                <img src="<?= FCPATH ?>assets/img/approved2.png" width="80">
            <?php endif; ?>
        </td>
        <td></td>
        <td style="width:140px; height:80px; border:1px solid #000; text-align:center; vertical-align:middle;">
            <?php if ($header->AppStatus == 1) : ?>
                <img src="<?= FCPATH ?>assets/img/approved2.png" width="80">
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td style="text-align:center; font-weight:bold; text-decoration:underline; font-size:10px;"><?= $header->Approved3By ?></td>
        <td></td>
        <td style="text-align:center; font-weight:bold; text-decoration:underline; font-size:10px;"><?= $header->Approved2By ?></td>
        <td></td>
        <td style="text-align:center; font-weight:bold; text-decoration:underline; font-size:10px;"><?= $header->ApprovedBy ?></td>
    </tr>
    <tr>
        <td></td>
        <td style="text-align:center; font-size:8px; color:gray;"><em>Tanda tangan dan tuliskan nama jelas<br>dan jabatan tertinggi HR</em></td>
        <td></td>
        <td style="text-align:center; font-size:8px; color:gray;"><em>Tanda tangan dan tuliskan nama jelas<br>dan jabatan tertinggi Divisi</em></td>
        <td></td>
        <td style="text-align:center; font-size:8px; color:gray;"><em>Tanda tangan dan tuliskan nama jelas<br>dan jabatan pimpinan departemen</em></td>
    </tr>
</table>