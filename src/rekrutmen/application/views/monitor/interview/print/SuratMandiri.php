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
            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #000;
        }

        .wrap {
            margin: 50px 40px 40px 40px;
        }

        p {
            margin: 0 0 6px 0;
            line-height: 1.6;
        }

        .spacer {
            height: 14px;
        }

        .spacer-lg {
            height: 24px;
        }

        /* Tabel data karyawan */
        table.tbl-data {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        table.tbl-data th {
            border: 1px solid #000;
            padding: 5px 10px;
            font-weight: bold;
            text-align: center;
            background: #fff;
        }

        table.tbl-data td {
            border: 1px solid #000;
            padding: 5px 10px;
        }

        table.tbl-data th:nth-child(1),
        table.tbl-data td:nth-child(1) {
            width: 220px;
        }

        table.tbl-data th:nth-child(2),
        table.tbl-data td:nth-child(2) {
            width: 100px;
        }
    </style>
</head>

<body>
    <div class="wrap">

        <p>Sei Guntung, <?= date('d M Y') ?></p>

        <div class="spacer"></div>

        <p>
            Kepada Yth<br>
            Pemimpin PT. Bank Mandiri (Persero) Tbk<br>
            Kantor Layanan Pulau Sambu<br>
            di-<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guntung
        </p>

        <div class="spacer"></div>

        <p>Dengan hormat,</p>

        <div class="spacer"></div>

        <p>
            Mohon bantuannya buat Pengurusan pembuatan rekening Mandiri, tenaga kerja di bawah ini.<br>
            Untuk keperluan penyetoran gaji Tenaga kerja tersebut
        </p>

        <div class="spacer"></div>

        <table class="tbl-data">
            <tr>
                <th>NAMA</th>
                <th>DEPT</th>
                <th>NIK KTP</th>
            </tr>
            <?php foreach ($getDetail as $key) : ?>
                <tr>
                    <td><?= $key->Nama ?></td>
                    <td><?= $key->DeptTujuan ?></td>
                    <td><?= $key->No_Ktp ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="spacer"></div>

        <p>
            Demikian permohonan kami, atas perhatian dan kerjasamanya<br>
            kami ucapkan terima kasih
        </p>

        <div class="spacer"></div>

        <p>Departemen HRD</p>

        <div class="spacer-lg"></div>
        <div class="spacer-lg"></div>
        <div class="spacer-lg"></div>

        <p>
            Larnadimi Wagia<br>
            Kadep HRD
        </p>

    </div>
</body>

</html>