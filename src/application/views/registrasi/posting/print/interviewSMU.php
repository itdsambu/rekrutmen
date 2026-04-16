<page style="font-size: 11px; font-family: freeserif;" backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">

    <table style="width:100%; border:1px solid black;" cellspacing="0">

        <!-- HEADER -->
        <tr>
            <td rowspan="3" style="width:12%; text-align:center; border-right:1px solid black;">
                <img src="<?php echo FCPATH . 'assets/img/rsup-logo.png'; ?>" width="50">
            </td>

            <td style="width:58%;">PT. RSUP - INDUSTRY (P. BURUNG)</td>

            <td style="width:10%; border-left:1px solid black;">No</td>
            <td style="width:5%;">:</td>
            <td style="width:15%;">________</td>
        </tr>

        <tr>
            <td rowspan="2" style="text-align:center;">
                <b style="font-size:16px;">LAPORAN HASIL WAWANCARA</b><br />
                Kategori : SMP/SMU
            </td>

            <td style="border-left:1px solid black;">Sifat</td>
            <td>:</td>
            <td>Confidential</td>
        </tr>

        <tr>
            <td style="border-left:1px solid black;">Hal</td>
            <td>:</td>
            <td>1 dari 1</td>
        </tr>

        <!-- BODY -->
        <tr>
            <td colspan="5" style="padding:5px;">

                <!-- DATA -->
                <table style="width:100%;">
                    <tr>
                        <td style="width:22%;">Nama Calon</td>
                        <td style="width:3%;">:</td>
                        <td style="width:25%; border-bottom:1px solid black;"></td>

                        <td style="width:22%;">Calon u/ Dept</td>
                        <td style="width:3%;">:</td>
                        <td style="width:25%; border-bottom:1px solid black;"></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td style="border-bottom:1px solid black;"></td>

                        <td>Tanggal Wawancara</td>
                        <td>:</td>
                        <td style="border-bottom:1px solid black;"></td>
                    </tr>
                    <tr>
                        <td>Pendidikan</td>
                        <td>:</td>
                        <td style="border-bottom:1px solid black;"></td>

                        <td>Nama Pewawancara</td>
                        <td>:</td>
                        <td style="border-bottom:1px solid black;"></td>
                    </tr>
                    <tr>
                        <td>Jabatan dilamar</td>
                        <td>:</td>
                        <td style="border-bottom:1px solid black;"></td>
                    </tr>
                </table>

                <br />

                <!-- HEADER NILAI -->
                <table style="width:100%;" cellspacing="0">
                    <tr>
                        <td style="width:60%; font-weight:bold;">FAKTOR-FAKTOR YANG DINILAI</td>

                        <td style="width:8%; text-align:center; border:1px solid black;">sgt<br />kurang</td>
                        <td style="width:8%; text-align:center; border:1px solid black;">kurang</td>
                        <td style="width:8%; text-align:center; border:1px solid black;">cukup</td>
                        <td style="width:8%; text-align:center; border:1px solid black;">baik</td>
                        <td style="width:8%; text-align:center; border:1px solid black;">sgt<br />baik</td>
                    </tr>

                    <tr>
                        <td></td>
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <td style="text-align:center; border:1px solid black;"><?php echo $i; ?></td>
                        <?php endfor; ?>
                    </tr>
                </table>

                <br />

                <!-- FUNCTION ITEM -->
                <?php
                function rowPenilaian($no, $judul, $desc)
                {
                ?>
                    <table style="width:100%;">
                        <tr>
                            <td style="width:5%;"><b><?php echo $no; ?>.</b></td>
                            <td style="width:55%;"><b><?php echo $judul; ?></b></td>

                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <td style="width:8%; text-align:center; border:1px solid black;"><?php echo $i; ?></td>
                            <?php endfor; ?>
                        </tr>

                        <tr>
                            <td></td>
                            <td colspan="6" style="border-bottom:1px solid black;">
                                <?php echo $desc; ?><br />
                                Catatan :
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td colspan="6" style="border-bottom:1px solid black; height:15px;"></td>
                        </tr>
                    </table>
                    <br />
                <?php } ?>

                <?php
                rowPenilaian(1, "PENDIDIKAN", "Macam, jurusan, prestasi, nilai, kursus, training");
                rowPenilaian(2, "KEMAMPUAN", "IQ, bakat, keterampilan, komunikasi");
                rowPenilaian(3, "MOTIVASI", "Semangat dan ambisi kerja");
                rowPenilaian(4, "KEPRIBADIAN", "Stabilitas emosi dan tanggung jawab");
                rowPenilaian(5, "KESEHATAN/FISIK", "Kesehatan umum dan penampilan");
                rowPenilaian(6, "________________ (tulis jika ada)", "");
                ?>

                <!-- TOTAL -->
                <table style="width:100%;">
                    <tr>
                        <td style="width:70%;"></td>
                        <td>Total Nilai</td>
                        <td style="border-bottom:1px solid black; width:15%;"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Rata-rata</td>
                        <td style="border-bottom:1px solid black;"></td>
                    </tr>
                </table>

                <br />

                <!-- FOOTER BOX -->
                <table style="width:100%;" border="1">
                    <tr>
                        <td style="width:33%;">
                            Kesimpulan <i>(*Lingkari yg sesuai)</i><br /><br />
                            A. Disarankan<br />
                            B. Disarankan dgn catatan<br />
                            C. Ditolak
                        </td>
                        <td style="width:33%;">
                            Dibuat oleh,<br /><br /><br />
                            Nama<br />
                            Jabatan<br />
                            Tanggal
                        </td>
                        <td style="width:33%;">
                            Disetujui oleh,<br /><br /><br />
                            Nama<br />
                            Jabatan<br />
                            Tanggal
                        </td>
                    </tr>
                </table>

                <br />

                <!-- CATATAN -->
                <table style="width:100%; font-size:10px;">
                    <tr>
                        <td><i>Catatan :</i></td>
                    </tr>
                    <tr>
                        <td>1. Pertimbangkan isi jawaban, cara menjawab, dan sikap.</td>
                    </tr>
                    <tr>
                        <td>2. Bisa ditambah tes tertulis jika diperlukan.</td>
                    </tr>
                </table>

            </td>
        </tr>

    </table>

</page>