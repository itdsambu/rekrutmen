<style>
    table {
        border-collapse: collapse;
        table-layout: fixed;
    }

    td {
        font-size: 10px;
        vertical-align: top;
    }

    .center {
        text-align: center;
    }

    .bold {
        font-weight: bold;
    }

    .underline {
        text-decoration: underline;
    }
</style>

<page backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">

    <table border="1" width="100%">
        <tr>
            <td>

                <?php foreach ($_getDetail as $row) : ?>

                    <!-- HEADER -->
                    <table width="100%">
                        <tr>
                            <td width="80" rowspan="2" class="center">
                                <img src="<?= FCPATH ?>assets/img/rsup-logo.png" width="60">
                            </td>
                            <td width="400"></td>
                            <td width="100" class="center">Confidential</td>
                        </tr>
                        <tr>
                            <td class="center bold underline" style="font-size:16px;">
                                MEDICAL CHECK UP
                            </td>
                            <td></td>
                        </tr>
                    </table>

                    <br>

                    <!-- IDENTITAS -->
                    <table width="100%">
                        <tr>
                            <td width="80"></td>
                            <td width="120">NAMA</td>
                            <td width="250">: <?= $row->Nama ?></td>
                            <td width="120">BAGIAN</td>
                            <td width="230">: <?= $row->DeptTujuan ?> / <?= $row->Pemborong ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>UMUR</td>
                            <td>: <?= $_umur ?></td>
                            <td>PERUSAHAAN</td>
                            <td>: PT. RSUP INDUSTRY</td>
                        </tr>
                    </table>

                    <hr>

                    <!-- I. ANAMNESA -->
                    <table width="100%">
                        <tr>
                            <td width="30" class="bold center">I.</td>
                            <td width="250" class="underline bold">ANAMNESA</td>
                            <td width="50" class="center">YA</td>
                            <td width="50" class="center">TIDAK</td>
                            <td width="30"></td>
                            <td width="250"></td>
                            <td width="50" class="center">YA</td>
                            <td width="50" class="center">TIDAK</td>
                        </tr>

                        <?php
                        $list1 = [
                            "Astmha Bronchale",
                            "Diabetes Melitus",
                            "Eczeem",
                            "Ulcus pepticus"
                        ];

                        $list2 = [
                            "TBC Paru",
                            "Hepatitis",
                            "Hernia",
                            "Haemorhoid",
                            "Epilepsi"
                        ];

                        for ($i = 0; $i < 5; $i++) :
                        ?>
                            <tr>
                                <td></td>
                                <td><?= ($i + 1) . '. ' . ($list1[$i] ?? '') ?></td>
                                <td class="center">☐</td>
                                <td class="center">☐</td>

                                <td></td>
                                <td><?= ($i + 5) . '. ' . ($list2[$i] ?? '') ?></td>
                                <td class="center">☐</td>
                                <td class="center">☐</td>
                            </tr>
                        <?php endfor; ?>

                        <tr>
                            <td colspan="4">
                                Keterangan diatas adalah benar, apabila ditemukan pelanggaran saya siap menerima sanksi.
                            </td>
                            <td></td>
                            <td colspan="3" class="center">
                                Saya yang menyatakan<br><br>
                                <b><u><?= strtoupper($row->Nama) ?></u></b>
                            </td>
                        </tr>
                    </table>

                    <hr>

                    <!-- II -->
                    <table width="100%">
                        <tr>
                            <td width="30" class="bold center">II.</td>
                            <td width="200">Tinggi Badan</td>
                            <td width="100">cm</td>
                            <td width="200">Tekanan Darah</td>
                            <td width="100">mmhg</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Berat Badan</td>
                            <td>kg</td>
                            <td>Denyut Nadi</td>
                            <td>x/menit</td>
                        </tr>
                    </table>

                    <hr>

                    <!-- III -->
                    <table width="100%">
                        <tr>
                            <td width="30" class="bold center">III.</td>
                            <td colspan="4" class="underline bold">PEMERIKSAAN FISIK</td>
                        </tr>

                        <?php
                        $fisik = [
                            "Keadaan Umum", "Kepala", "Mata", "Jarak Pandang", "Buta Warna",
                            "Hidung", "Gigi/Rongga Mulut", "Telinga", "Leher", "Paru-paru",
                            "Jantung", "Hati dan Limpa", "Perut", "Anus dan Kelamin", "Anggota Badan"
                        ];
                        $no = 1;
                        foreach ($fisik as $f) :
                        ?>
                            <tr>
                                <td></td>
                                <td width="30"><?= $no++ ?>.</td>
                                <td width="200"><?= $f ?></td>
                                <td width="20">:</td>
                                <td>______________________________</td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                    <hr>

                    <!-- IV -->
                    <table width="100%">
                        <tr>
                            <td width="30" class="bold center">IV.</td>
                            <td colspan="4" class="underline bold">PEMERIKSAAN KHUSUS</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>-</td>
                            <td>Drug Testing</td>
                            <td>:</td>
                            <td>__________________________</td>
                        </tr>
                    </table>

                    <hr>

                    <!-- FOOT -->
                    <table width="100%">
                        <tr>
                            <td width="200">Kesimpulan</td>
                            <td width="20">:</td>
                            <td width="250">__________________</td>
                            <td width="200">Pulau Burung,</td>
                        </tr>
                    </table>

                    <br><br>

                    <table width="100%">
                        <tr>
                            <td width="400">Catatan/ Pesan Klinik :</td>
                            <td width="200" class="center"></td>
                        </tr>
                        <tr>
                            <td>______________________________</td>
                        </tr>
                        <tr>
                            <td>______________________________</td>
                        </tr>
                        <tr>
                            <td>______________________________</td>
                            <td class="center underline">Ka. Poliklinik</td>
                        </tr>
                    </table>

                <?php endforeach; ?>

            </td>
        </tr>
    </table>

    <table border="1" width="100%">
        <tr>
            <td width="50%">Tanggal Efektif : 27 Januari 2014</td>
            <td width="50%" align="right">FRM-HRD-002-01</td>
        </tr>
    </table>

</page>