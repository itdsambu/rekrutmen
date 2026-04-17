<!-- <page backtop="15mm" backbottom="15mm"> -->

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

    #pdf-wrapper {
        transform: scale(0.85);
        /* perkecil isi */
        transform-origin: top left;
        width: 117%;
        /* kompensasi agar tidak kepotong */
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

    td,
    th {
        padding: 4px;
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

    <p class="small" align="center">
        website: www.sambugroup.com
    </p>
    <div class="line"></div>
    <table border="" width="65%" align="center" cellpadding="6" cellspacing="0">
        <tr>
            <th align="center" style="font-weight:bold;">
                FORM PERMINTAAN PERUBAHAN ORGANISASI
            </th>
        </tr>
    </table>
    <br>
    <table width="100%" cellpadding="4" cellspacing="">
        <tr>
            <th align="left" style="font-weight:bold;width: 212px;">
                DIVISI
            </th>
            <th align="left" style="font-weight:bold;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black; width: 400px; padding: 8px;">
                test
            </th>
        </tr>
        <tr>
            <th align="left" style="font-weight:bold;width: 200px;">
                DEPARTEMEN
            </th>
            <th align="left" style="font-weight:bold; border-left: 1px solid black;border-right: 1px solid black;border-top:1px solid black; width: 400px; padding: 8px;">
                test
            </th>
        </tr>
        <tr>
            <th align="left" style="font-weight:bold;width: 200px;">
                SUB DEPARTEMEN <br>
                (contoh MP1, MP2, MPM)
            </th>
            <th align="left" style="font-weight:bold; border-left: 1px solid black;border-right: 1px solid black;border-top:1px solid black; width: 400px; padding: 8px;">
                test
            </th>
        </tr>
        <tr>
            <th align="left" style="font-weight:bold;width: 200px;">
                JABATAN
            </th>
            <th align="left" style="font-weight:bold; border-left: 1px solid black;border-right: 1px solid black;border-top:1px solid black; width: 400px; padding: 8px;">
                test
            </th>
        </tr>
        <tr>
            <th align="left" style="font-weight:bold;width: 200px;">
                SUBJABATAN
            </th>
            <th align="left" style="font-weight:bold; border-left: 1px solid black;border-right: 1px solid black;border-top:1px solid black;border-bottom:1px solid black; width: 400px; padding: 8px;">
                test
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
                            <div style="width:16px;height:16px;border:1px solid #000;"></div>
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
                            <div style="width:16px;height:16px;border:1px solid #000;"></div>
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
    <table cellpadding="4" cellspacing="0" border="0" style="table-layout:fixed; width:100%;">
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
                            <div style="width:16px;height:16px;border:1px solid #000;"></div>
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
                            <div style="width:16px;height:16px;border:1px solid #000;"></div>
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
    <table cellpadding="4" cellspacing="0" border="0" style="table-layout:fixed; width:100%; ">
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
                            <div style="width:16px;height:16px;border:1px solid #000;"></div>
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
                            <div style="width:16px;height:16px;border:1px solid #000;"></div>
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
                            <div style="width:16px;height:16px;border:1px solid #000;"></div>
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
    <table cellpadding="4" cellspacing="0" border="0" style="table-layout:fixed; width:100%; margin-top:8px;">
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
                <div style="height:100px;border:solid black 1px"></div>
            </td>
        </tr>
    </table>
    <table cellpadding="4" cellspacing="0" border="0" style="table-layout:fixed; width:100%; margin-top:8px;">
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
                <div style="height:100px;border:solid black 1px"></div>
            </td>
        </tr>
    </table>
    <table cellpadding="4" cellspacing="0" border="0" style="table-layout:fixed; width:100%; margin-top:8px;">
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
                <div style="height:100px;border:solid black 1px"></div>
            </td>
        </tr>
    </table>




    <!-- <b>LATAR BELAKANG PERUBAHAN</b><br>
<em style="font-size:11px;color:gray;">
    (uraikan latar belakang perubahan organisasi)
</em>
<div style="border:1px solid #000; height:120px; margin-top:6px;"></div> -->

</div>