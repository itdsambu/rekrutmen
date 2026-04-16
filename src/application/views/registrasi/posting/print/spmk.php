<style>
    table {
        border-collapse: collapse;
        table-layout: fixed;
    }

    td {
        vertical-align: top;
        word-wrap: break-word;
        font-size: 11px;
    }

    .judul {
        font-size: 16px;
        font-weight: bold;
        text-align: center;
    }

    .kop {
        text-align: center;
        font-size: 12px;
    }

    .id {
        text-align: right;
        font-size: 10px;
    }
</style>

<?php foreach ($_getDetail as $row) : ?>

    <div class="id">ID : <?= $row->HeaderID ?></div>

    <table border="1" width="100%">
        <tr>
            <td>

                <!-- HEADER -->
                <table width="100%">
                    <tr>
                        <td width="80">
                            <img src="<?= FCPATH ?>assets/img/psg-logo.png" width="60">
                        </td>

                        <td width="320" class="kop">
                            PT. PULAU SAMBU - GUNTUNG<br>
                            <div class="judul">SURAT PENGANTAR MASUK KERJA</div>
                            <div class="judul">(HARI KERJA PERTAMA)</div>
                        </td>

                        <td width="200">
                            <table>
                                <tr>
                                    <td width="70">Bagian</td>
                                    <td width="10">:</td>
                                    <td><?= $row->DeptTujuan ?></td>
                                </tr>
                                <tr>
                                    <td>Pemborong</td>
                                    <td>:</td>
                                    <td><?= $row->CVNama ?></td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td>
                                        <?php foreach ($_getInterV as $set) {
                                            echo date("d M Y", strtotime($set->Tanggal));
                                        } ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <br>

                Disampaikan kepada PENGAWAS, agar dapat diterima masuk kerja, TENAGA KERJA BARU dibawah ini :

                <br><br>

                <!-- DATA -->
                <table width="100%">
                    <tr>
                        <td width="80">Nama</td>
                        <td width="10">:</td>
                        <td width="300"><b><?= $row->Nama ?></b></td>
                        <td width="100" rowspan="4" style="border:1px solid #000; text-align:center;">
                            Photo
                        </td>
                    </tr>

                    <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td>................................</td>
                    </tr>

                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td>
                            <?php foreach ($_getInterV as $set) {
                                echo ($set->JenisKerja) ? $set->JenisKerja : '..............';
                            } ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Shift</td>
                        <td>:</td>
                        <td>
                            <?php foreach ($_getInterV as $set) {
                                echo ($set->Shift) ? $set->Shift : '..............';
                            } ?>
                        </td>
                    </tr>
                </table>

                <br>

                Dan perlu kami beritahukan bahwa seluruh persyaratan proses administrasi menyangkut :

                <br><br>

                <!-- CHECKLIST -->
                <table width="100%">
                    <tr>
                        <td width="20"><img src="<?= FCPATH ?>assets/img/Checked.PNG" width="10"></td>
                        <td width="600">Aplikasi/Blangko-blangko TK Kontrak</td>
                    </tr>
                    <tr>
                        <td><img src="<?= FCPATH ?>assets/img/Checked.PNG" width="10"></td>
                        <td>Kualifikasi calon tenaga kerja Kontrak</td>
                    </tr>
                    <tr>
                        <td><img src="<?= FCPATH ?>assets/img/UnChecked.PNG" width="10"></td>
                        <td>Kelengkapan Surat-surat Mutasi (Jika yang Bersangkutan sebagai TK Mutasian)</td>
                    </tr>
                </table>

                <br>

                Telah SELESAI dan LENGKAP.<br>
                Blangko diterima pengawas tanggal : ...................... (diisi oleh Pengawas)


                <br><br>

                <!-- TTD -->
                <table width="100%">
                    <tr align="center">
                        <td>Dibuat Oleh</td>
                        <td>Disetujui Oleh</td>
                        <td>Diserahkan Oleh</td>
                        <td>Diterima Oleh</td>
                    </tr>

                    <tr>
                        <td height="60"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Nama : <?= $adm ?></td>
                        <td>Nama : ______</td>
                        <td>Nama : KASHIFT</td>
                        <td>Nama : ______</td>
                    </tr>

                    <tr>
                        <td>Jabatan : ADM</td>
                        <td>Jabatan : ______</td>
                        <td>Jabatan : KASHIFT</td>
                        <td>Jabatan : PENGAWAS</td>
                    </tr>

                    <tr>
                        <td>Tanggal : <?= $tglPrint ?></td>
                        <td>Tanggal : ______</td>
                        <td>Tanggal : ______</td>
                        <td>Tanggal : ______</td>
                    </tr>
                </table>

                <br><br>

                <hr>

                Catatan :

                <table width="100%">
                    <tr>
                        <td width="20">1.</td>
                        <td> Tenaga kerja baru/ Mutasian yang pada hari pertama masuk kerja tidak membawa
                            Surat Pengantar maka tidak ada pembayaran gajinya, dan penga yang mengijinkan masuk akan diberikan sanksi.</td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td>ADM, memberikan tanda Conteng pada kotak setiap item apabila sudah lengkap, jika belum ADM tidak
                            diperbolehkan membuat surat pengantar ini.</td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

<?php endforeach; ?>