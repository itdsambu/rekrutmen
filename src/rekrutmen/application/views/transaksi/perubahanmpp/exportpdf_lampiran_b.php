<!-- VIEW: transaksi/perubahanmpp/exportpdf_lampiran_b.php -->
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10px;
    }

    table {
        font-size: 10px;
        border-collapse: collapse;
    }

    .italic-hint {
        font-size: 9px;
        color: gray;
        font-style: italic;
    }
</style>

<table width="100%" border="0" cellpadding="4" cellspacing="0">
    <tr>
        <th align="left" style="font-size:12px; font-style:italic;">LAMPIRAN B</th>
    </tr>
    <tr>
        <th align="left" style="font-size:12px; font-weight:bold;">Uraian Penambahan Sub Jabatan Lama</th>
    </tr>
</table>

<table width="100%" border="0" cellpadding="4" cellspacing="0" style="margin-top:8px;">
    <tr>
        <td style="width:200px; font-weight:bold; font-size:12px;">Nama Sub Jabatan</td>
        <td style="border:1px solid #000; padding:4px;"><?= $lampiranB->NamaSubJabatan ?></td>
    </tr>
    <tr>
        <td style="font-weight:bold; font-size:12px;">Level Jabatan</td>
        <td style="border:1px solid #000; padding:4px;"><?= $lampiranB->LevelJabatan ?></td>
    </tr>
</table>

<!-- PENGISI SUB JABATAN -->
<table width="100%" border="0" cellpadding="4" cellspacing="0" style="margin-top:8px;">
    <tr>
        <td style="width:200px; font-weight:bold; font-size:12px; vertical-align:top;">
            Pengisi Sub Jabatan<br>
            <span class="italic-hint">(mohon beri catatan untuk promosi/rotasi apakah jabatan lama ybs akan mengalami perubahan MPP)</span>
        </td>
        <td style="width:140px; vertical-align:top;">
            <table border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <td>
                        <div style="width:14px;height:14px;border:1px solid #000;background:<?= $lampiranB->PengisiSubJabatan == 'Promosi' ? '#000' : '#fff' ?>;">&nbsp;</div>
                    </td>
                    <td style="padding-left:4px;"><b>Promosi</b></td>
                </tr>
            </table>
        </td>
        <td style="width:140px; vertical-align:top;">
            <table border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <td>
                        <div style="width:14px;height:14px;border:1px solid #000;background:<?= $lampiranB->PengisiSubJabatan == 'Rotasi' ? '#000' : '#fff' ?>;">&nbsp;</div>
                    </td>
                    <td style="padding-left:4px;"><b>Rotasi</b></td>
                </tr>
            </table>
        </td>
        <td style="vertical-align:top;">
            <table border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <td>
                        <div style="width:14px;height:14px;border:1px solid #000;background:<?= $lampiranB->PengisiSubJabatan == 'Rekrut Baru' ? '#000' : '#fff' ?>;">&nbsp;</div>
                    </td>
                    <td style="padding-left:4px;"><b>Rekrut Baru</b></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- CATATAN -->
<table width="100%" border="0" cellpadding="4" cellspacing="0" style="margin-top:4px;">
    <tr>
        <td style="width:200px;"></td>
        <td style="border:1px solid #000; padding:4px; min-height:60px; vertical-align:top;">
            <b>Catatan:</b><br>
            <span style="font-weight:normal;"><?= $lampiranB->Catatan ?></span>
        </td>
    </tr>
</table>

<!-- TUGAS & TANGGUNG JAWAB -->
<table width="100%" border="0" cellpadding="3" cellspacing="0" style="margin-top:8px;">
    <tr>
        <th align="left" style="font-size:12px;">
            <b>Tugas &amp; Tanggung Jawab</b><br>
            <span class="italic-hint">(Dibuat list secara detail yang menjadi tugas harian dan tugas tambahan dari pemegang jabatan)</span>
        </th>
    </tr>
    <tr>
        <td>
            <div style="min-height:80px; border:1px solid #000; padding:4px;"><?= $lampiranB->TugasTanggungJawab ?></div>
        </td>
    </tr>
</table>

<!-- WEWENANG -->
<table width="100%" border="0" cellpadding="3" cellspacing="0" style="margin-top:8px;">
    <tr>
        <th align="left" style="font-size:12px;">
            <b>Wewenang</b><br>
            <span class="italic-hint">(Kewenangan pemegang jabatan di posisi baru)</span>
        </th>
    </tr>
    <tr>
        <td>
            <div style="min-height:80px; border:1px solid #000; padding:4px;"><?= $lampiranB->Wewenang ?></div>
        </td>
    </tr>
</table>

<!-- KOORDINASI -->
<table width="100%" border="0" cellpadding="3" cellspacing="0" style="margin-top:8px;">
    <tr>
        <th align="left" style="font-size:12px;">
            <b>Koordinasi</b><br>
            <span class="italic-hint">(Bagaimana antar pemegang jabatan ini berinteraksi atau berkolaborasi (Misal: ada yang fokus pada operasional, yang lain pada dokumen atau lainnya)</span>
        </th>
    </tr>
    <tr>
        <td>
            <div style="min-height:80px; border:1px solid #000; padding:4px;"><?= $lampiranB->Koordinasi ?></div>
        </td>
    </tr>
</table>

<!-- PELAPORAN -->
<table width="100%" border="0" cellpadding="3" cellspacing="0" style="margin-top:8px;">
    <tr>
        <th align="left" style="font-size:12px;">
            <b>Pelaporan*</b><br>
            <span class="italic-hint">
                *hanya untuk jabatan manajerial/memiliki anak buah<br>
                (Bagaimana tim kerja di bawah posisi ini akan melapor? Pembagian porsi leadership dengan pemegang jabatan yang sama sebelumnya)
            </span>
        </th>
    </tr>
    <tr>
        <td>
            <div style="min-height:80px; border:1px solid #000; padding:4px;"><?= $lampiranB->Pelaporan ?></div>
        </td>
    </tr>
</table>