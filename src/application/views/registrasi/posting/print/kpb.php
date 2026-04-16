<page style="font-size: 11px; font-family: freeserif;" backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">

    <?php foreach ($_getDetail as $row) : ?>

        <table style="width: 100%;" border="1">
            <tr>

                <!-- ================= LEFT ================= -->
                <td style="width: 48%; vertical-align: top; padding:5px;">

                    <!-- HEADER -->
                    <table style="width:100%;">
                        <tr>
                            <td style="width:20%; text-align:center;">
                                <img src="<?php echo FCPATH . 'assets/img/kpb-logo.png'; ?>" width="40">
                            </td>
                            <td style="width:80%; text-align:center; font-size:14px; font-weight:bold;">
                                <?php echo $row->CVNama; ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center; text-decoration:underline; font-size:11px;">
                                KARTU PENGANTAR BEROBAT
                            </td>
                        </tr>
                    </table>

                    <br />

                    <!-- DATA + FOTO -->
                    <table style="width:100%;">
                        <tr>
                            <!-- FOTO -->
                            <td style="width:30%; text-align:center; border:1px solid black;">
                                Photo
                            </td>

                            <!-- DATA -->
                            <td style="width:70%;">
                                <table style="width:100%;">
                                    <tr>
                                        <td style="width:40%;">Nama</td>
                                        <td style="width:60%;">: <?php echo substr($row->Nama, 0, 15); ?></td>
                                    </tr>
                                    <tr>
                                        <td>NIK</td>
                                        <td>: <?php echo $row->NIK ? $row->NIK : '__________'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Lahir</td>
                                        <td>: <?php echo date('d M Y', strtotime($row->Tgl_Lahir)); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Dept/Bag</td>
                                        <td>: <?php echo $row->DeptTujuan; ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <br /><br />

                    <!-- TTD -->
                    <table style="width:100%;">
                        <tr>
                            <td style="text-align:center;">Tanda Tangan</td>
                        </tr>
                    </table>

                </td>

                <!-- ================= TENGAH ================= -->
                <td style="width:4%; text-align:center; vertical-align:middle;">
                    -
                </td>

                <!-- ================= RIGHT ================= -->
                <td style="width:48%; vertical-align: top; padding:5px;">

                    <!-- HEADER -->
                    <table style="width:100%;">
                        <tr>
                            <td style="width:60%;">DAFTAR KELUARGA</td>
                            <td style="width:40%; text-align:right;">
                                <b>No. FF : ______</b>
                            </td>
                        </tr>
                    </table>

                    <br />

                    <!-- TABLE HEADER -->
                    <table style="width:100%;">
                        <tr>
                            <td style="width:30%;"></td>
                            <td style="width:30%; font-weight:bold;">Nama</td>
                            <td style="width:10%; text-align:center; font-weight:bold;">L/P</td>
                            <td style="width:30%; font-weight:bold;">Tgl. Lahir</td>
                        </tr>

                        <!-- SUAMI / ISTRI -->
                        <tr>
                            <td>Istri/Suami</td>
                            <td>: <?php echo $row->NamaSuamiIstri ?: '_______'; ?></td>
                            <td style="text-align:center;">
                                <?php echo ($row->Jenis_Kelamin == 'M') ? 'P' : 'L'; ?>
                            </td>
                            <td>
                                <?php echo $row->TglLahirSuamiIstri ? date('d M Y', strtotime($row->TglLahirSuamiIstri)) : '_______'; ?>
                            </td>
                        </tr>

                        <!-- ANAK -->
                        <?php if ($row->JumlahAnak == 0) : ?>
                            <tr>
                                <td>Anak Ke 1</td>
                                <td>: ______</td>
                                <td style="text-align:center;">L/P</td>
                                <td>______</td>
                            </tr>
                        <?php else : ?>
                            <?php $no = 1;
                            foreach ($_getAnak as $anak) : ?>
                                <tr>
                                    <td>Anak Ke <?php echo $no++; ?></td>
                                    <td>: <?php echo $anak->Nama; ?></td>
                                    <td style="text-align:center;"><?php echo ($anak->JenisKelamin == 'M') ? 'L' : 'P'; ?></td>
                                    <td><?php echo date('d M Y', strtotime($anak->TglLahir)); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </table>

                    <br /><br />

                    <!-- PERHATIAN -->
                    <table style="width:100%;">
                        <tr>
                            <td><b>PERHATIAN:</b></td>
                        </tr>
                        <tr>
                            <td>- Tiap kali berobat harus membawa kartu ini.</td>
                        </tr>
                        <tr>
                            <td>- Penyalahgunaan akan dikenakan biaya pengobatan.</td>
                        </tr>
                        <tr>
                            <td>- Jika hilang segera lapor Adm. Pemborong.</td>
                        </tr>
                    </table>

                </td>

            </tr>
        </table>

    <?php endforeach; ?>

</page>