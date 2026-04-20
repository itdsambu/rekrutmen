<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Proses data
$nama = '';
$kesimpulanCU = '';
$pesanklinik = '';
$tanggal_mcu = '';

// if (isset($dtdetail)) {
//     foreach ($dtdetail as $row) {
//         $nama = $row->Nama;
//         $kesimpulanCU = $row->kesimpulanCU;
//         $tanggal_mcu = date("d-m-Y", strtotime($row->mcu_date));

//         $pattern = '/[“"]([^“”"]+)[”"]|“([^“”"]+)”/';
//         preg_match_all($pattern, $row->pesanklinik, $matches);
//         $results = array_filter(array_merge($matches[1], $matches[2]), fn ($v) => !empty($v));

//         $count = count($results);
//         if ($count == 2) {
//             $pesanklinik = implode(' dan ', $results);
//         } elseif ($count > 2) {
//             $last = array_pop($results);
//             $pesanklinik = implode(', ', $results) . ', dan ' . $last;
//         } elseif ($count == 1) {
//             $pesanklinik = reset($results);
//         }
//     }
// }
if (isset($dtdetail)) {
    foreach ($dtdetail as $row) {
        $nama         = $row->Nama;
        $kesimpulanCU = $row->kesimpulanCU;
        $tanggal_mcu  = date("d-m-Y", strtotime($row->mcu_date));

        $text = $row->pesanklinik;

        // Split per baris, ambil yang diawali bullet •
        $lines = preg_split('/\r\n|\r|\n/', $text);
        $results = [];

        foreach ($lines as $line) {
            // Cari baris yang dimulai dengan bullet • (UTF-8: E2 80 A2)
            if (preg_match('/^\s*•\s*(.+)$/u', trim($line), $m)) {
                $item = trim($m[1]);
                if (!empty($item)) {
                    $results[] = $item;
                }
            }
        }

        $count = count($results);
        if ($count == 2) {
            $pesanklinik = implode(' dan ', $results);
        } elseif ($count > 2) {
            $last = array_pop($results);
            $pesanklinik = implode(', ', $results) . ', dan ' . $last;
        } elseif ($count == 1) {
            $pesanklinik = reset($results);
        } else {
            $pesanklinik = '';
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "times", Times, serif;
            font-size: 12pt;
            margin: 0;
            padding: 0;
        }

        .box {
            border: 1px solid #000;
            padding: 20px;
        }

        .title {
            font-size: 16pt;
            font-weight: bold;
            text-align: center;
        }

        .subtitle {
            font-size: 16pt;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .content p {
            margin: 4px 0;
        }

        .highlight {
            color: red;
        }

        .ttd {
            margin-top: 30px;
            padding-left: 430px;
        }
    </style>
</head>

<body>
    <div class="box">
        <div class="title">FORM KONTROL ULANG MCU</div>
        <div class="subtitle">CALON TK/KARYAWAN BARU</div>

        <div class="content">
            <p><strong>Berdasarkan Hasil MCU AN <?= htmlspecialchars($nama) ?> tanggal <?= $tanggal_mcu ?></strong></p>
            <p>dinyatakan "<strong><?= htmlspecialchars($kesimpulanCU) ?></strong>" karena</p>
            <p class="highlight"><strong>"<?= htmlspecialchars($pesanklinik) ?>"</strong></p>
            <p>Perlu kontrol ulang sampai dinyatakan sehat oleh Tim Medis</p>
        </div>

        <div class="ttd">
            <strong>HRD</strong>
        </div>
    </div>
</body>

</html>