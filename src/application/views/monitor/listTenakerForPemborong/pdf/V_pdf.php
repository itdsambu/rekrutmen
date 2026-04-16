<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
//    session_start(); //Memanggil fungsi session Codeigniter
require_once APPPATH . "/third_party/FPDF.php";

class ISI extends FPDF
{
    // Page header
    function Header()
    {
        $this->SetTitle("SURAT KETERANGAN HASIL MCU");
        $this->SetLineWidth(0.3);
        $y = $this->GetY();

        $this->SetAutoPageBreak(true);
    }
}

$pdf = new ISI('P', 'mm', 'A4');
// $pdf = new ISI('P', 'mm', array(300, 300));



if (isset($dtdetail)) {
    $no = 0;
    foreach ($dtdetail as $dtdetail_row) {
        $pdf->nama = $dtdetail_row->Nama;
        $pdf->kesimpulanCU = $dtdetail_row->kesimpulanCU;

        // String yang berisi teks dengan tanda kutip lurus
        $text = $dtdetail_row->pesanklinik;

        // // Pola regex untuk menangkap teks di dalam tanda kutip lurus
        // $pattern = '/“([^”]+)”/';

        // Pola regex untuk menangkap teks di dalam tanda kutip lurus (“ ”) atau tanda kutip biasa (" ")
        $pattern = '/[“"]([^“”"]+)[”"]|“([^“”"]+)”/';


        // Array untuk menyimpan hasil pencocokan
        $matches = [];

        // Melakukan pencocokan pola dalam teks
        preg_match_all($pattern, $text, $matches);

        // // Hasil pencocokan ada pada indeks ke-1 dari array hasil
        // $results = $matches[1];

        // Hasil pencocokan ada pada indeks ke-1 dari array hasil
        $results = array_filter(array_merge($matches[1], $matches[2]), function ($value) {
            return !empty($value);
        });

        // // Menampilkan hasil
        // $pdf->pesanklinik  = '';
        // foreach ($results as $result) {
        //     $pdf->pesanklinik .=  $result . ', ';
        // }

        // Menggabungkan hasil pencocokan dengan format yang diinginkan
        $formattedResults = '';
        $countResults = count($results);

        if ($countResults == 2) {
            $formattedResults = implode(' dan ', $results);
        } elseif ($countResults > 2) {
            $lastItem = array_pop($results); // Ambil elemen terakhir
            $formattedResults = implode(', ', $results) . ', dan ' . $lastItem;
        } elseif ($countResults == 1) {
            $formattedResults = reset($results); // Hanya ada satu elemen
        }

        // Menyimpan hasil dalam PDF atau menampilkan
        $pdf->pesanklinik = $formattedResults;

        $pdf->tanggal_mcu   = date("d-m-Y", strtotime($dtdetail_row->mcu_date));


        $jml_data = count($dtdetail);
    }
}


$pdf->AddPage();
$pdf->SetXY(5, 5);
$pdf->Cell(200, 80, '', 1, 0, 'C');
$title = "FORM KONTROL ULANG MCU";
$title2 = "CALON TK/KARYAWAN BARU";
$pdf->Ln(10);
$pdf->SetX(35);
$pdf->SetFont('Times', 'B', 16); //size huruf header 1
$pdf->cell(137, 6, $title, 0, 1, 'C', 0); // header1
$pdf->SetX(35);
$pdf->cell(137, 10, $title2, 'B', 1, 'C', 0); // header1
$pdf->SetFont('Times', 'B', 12); //size huruf header 1
$pdf->SetX(35);
$pdf->cell(137, 10, 'Berdasarkan Hasil MCU AN ' . $pdf->nama . ' tanggal ' . $pdf->tanggal_mcu . '', 0, 1, 'L', 0); // header1
$pdf->SetX(35);
$pdf->cell(137, 6, 'dinyatakan "' . $pdf->kesimpulanCU . '" karena', 0, 1, 'L', 0); // header1
$pdf->SetX(35);
$pdf->SetTextColor(255, 0, 0);
$pdf->cell(137, 6, '"' . $pdf->pesanklinik . '"', 0, 1, 'L', 0); // header1
$pdf->SetTextColor(0, 0, 0);
$pdf->SetX(35);
$pdf->cell(137, 6, 'Perlu kontrol ulang sampai dinyatakan sehat oleh Tim Medis', 0, 1, 'L', 0); // header1
$pdf->Ln(8);
$pdf->SetX(163);
$pdf->cell(16, 6, 'HRD', 0, 1, 'L', 0); // header1
// $pdf->SetFont('Times', 'BU', 12); //size huruf header 2
// $pdf->Cell(137, 33, $title2, 0, 0, 'C');

// $pdf->SetX(35);
// $pdf->SetFont('Times', 'B', '', 12); //size huruf header 2
// $pdf->Cell(137, 43, '' . 'TES', 0, 0, 'C');

// $pdf->SetFillColor(255, 255, 255);
// $pdf->SetFont('Times', '', 11);

$pdf->Ln(25);

$pdf->Output();

// function  judul1($pdf, $title1, $title2, $result1, $result2)
// {
//     $pdf->Ln(7);
//     $pdf->SetXY(26, $pdf->GetY()); //objek1
//     $pdf->Cell(25, 5, $title1, 0, 'L');
//     $pdf->SetXY(48, $pdf->GetY()); //tanda titik
//     $pdf->Cell(2, 5, ': ', 0, 'L');
//     $pdf->SetXY(50, $pdf->GetY()); //parameter 1
//     $pdf->Cell(35, 5, $result1, 0, 'L');
//     $pdf->SetXY(110, $pdf->GetY()); //objek 2
//     $pdf->Cell(34, 5, $title2, 0, 'L');
//     $pdf->SetXY(145, $pdf->GetY()); //tanda titik 
//     $pdf->Cell(2, 5, ': ', 0, 'L');
//     $pdf->SetXY(147, $pdf->GetY()); //parameter 2
//     $pdf->Cell(57, 5, $result2, 0, 'L');
//     return $pdf;
// }

// function  judul2($pdf, $title1, $title2, $title3, $result1, $result2, $result3)
// {
//     $pdf->Ln(5);
//     $pdf->SetXY(11, $pdf->GetY());
//     $pdf->Cell(25, 5, $title1, 0, 'L');
//     $pdf->SetXY(35, $pdf->GetY());
//     $pdf->Cell(2, 5, ': ', 0, 'L');
//     $pdf->SetXY(37, $pdf->GetY());
//     $pdf->Cell(60, 5, $result1, 0, 'L');
//     $pdf->SetXY(80, $pdf->GetY());
//     $pdf->Cell(34, 5, $title2, 0, 'L');
//     $pdf->SetXY(105, $pdf->GetY());
//     $pdf->Cell(2, 5, ': ', 0, 'L');
//     $pdf->SetXY(107, $pdf->GetY());
//     $pdf->Cell(57, 5, $result2, 0, 'L');
//     $pdf->SetXY(140, $pdf->GetY()); //objek 2
//     $pdf->Cell(34, 5, $title3, 0, 'L');
//     $pdf->SetXY(160, $pdf->GetY()); //tanda titik 
//     $pdf->Cell(2, 5, ': ', 0, 'L');
//     $pdf->SetXY(162, $pdf->GetY()); //parameter 2
//     $pdf->Cell(57, 5, $result3, 0, 'L');
//     return $pdf;
// }

// function  judul3($pdf, $title1, $result1, $title2, $result2)
// {
//     $pdf->Ln(5);
//     $pdf->SetXY(11, $pdf->GetY());
//     $pdf->Cell(25, 5, $title1, 0, 'L');
//     $pdf->SetXY(35, $pdf->GetY());
//     $pdf->Cell(2, 5, ': ', 0, 'L');
//     $pdf->SetXY(37, $pdf->GetY());
//     $pdf->Cell(60, 5, $result1, 0, 'L');
//     $pdf->SetXY(80, $pdf->GetY());
//     $pdf->Cell(34, 5, $title2, 0, 'L');
//     $pdf->SetXY(105, $pdf->GetY());
//     $pdf->Cell(2, 5, ': ', 0, 'L');
//     $pdf->SetXY(107, $pdf->GetY());
//     $pdf->Cell(57, 5, $result2, 0, 'L');
//     return $pdf;
// }

// function  judul4($pdf, $title1, $title2, $result1, $result2)
// {
//     $pdf->Ln(7);
//     $pdf->SetXY(6, $pdf->GetY()); //objek1
//     $pdf->Cell(25, 5, $title1, 0, 'L');
//     $pdf->SetXY(51, $pdf->GetY()); //tanda titik
//     $pdf->Cell(2, 5, ': ', 0, 'L');
//     $pdf->SetXY(54, $pdf->GetY()); //parameter 1
//     $pdf->Cell(60, 5, $result1, 0, 'L');
//     $pdf->SetXY(115, $pdf->GetY()); //objek 2
//     $pdf->Cell(34, 5, $title2, 0, 'L');
//     $pdf->SetXY(155, $pdf->GetY()); //tanda titik 
//     $pdf->Cell(2, 5, ': ', 0, 'L');
//     $pdf->SetXY(158, $pdf->GetY()); //parameter 2
//     $pdf->Cell(57, 5, $result2, 0, 'L');
//     return $pdf;
// }

// function  judul5($pdf, $title1, $title2, $result1, $result2)
// {
//     $pdf->Ln(7);
//     $pdf->SetXY(11, $pdf->GetY()); //objek1
//     $pdf->Cell(25, 5, $title1, 0, 'L');
//     $pdf->SetXY(48, $pdf->GetY()); //tanda titik
//     $pdf->Cell(2, 5, ': ', 0, 'L');
//     $pdf->SetXY(50, $pdf->GetY()); //parameter 1
//     $pdf->Cell(60, 5, $result1, 0, 'L');
//     $pdf->SetXY(100, $pdf->GetY()); //objek 2
//     $pdf->Cell(34, 5, $title2, 0, 'L');
//     $pdf->SetXY(135, $pdf->GetY()); //tanda titik 
//     $pdf->Cell(2, 5, ': ', 0, 'L');
//     $pdf->SetXY(140, $pdf->GetY()); //parameter 2
//     $pdf->Cell(57, 5, $result2, 0, 'L');
//     return $pdf;
// }

// function  judul6($pdf, $title1, $title2, $result1, $result2)
// {
//     $pdf->Ln(5);
//     $pdf->SetXY(26, $pdf->GetY()); //objek1
//     $pdf->Cell(25, 5, $title1, 0, 'L');
//     $pdf->SetXY(48, $pdf->GetY()); //tanda titik
//     $pdf->Cell(2, 5, ': ', 0, 'L');
//     $pdf->SetXY(50, $pdf->GetY()); //parameter 1
//     $pdf->Cell(60, 5, $result1, 0, 'L');
//     $pdf->SetXY(110, $pdf->GetY()); //objek 2
//     $pdf->Cell(34, 5, $title2, 0, 'L');
//     $pdf->SetXY(145, $pdf->GetY()); //tanda titik 
//     $pdf->Cell(2, 5, ': ', 0, 'L');
//     $pdf->SetXY(147, $pdf->GetY()); //parameter 2
//     $pdf->Cell(57, 5, $result2, 0, 'L');
//     return $pdf;
// }

// function  running($pdf, $title1, $result1)
// {
//     $pdf->Ln(5);
//     $pdf->SetXY(26, $pdf->GetY());
//     $pdf->Cell(25, 5, $title1, 0, 'L');
//     $pdf->SetXY(92, $pdf->GetY());
//     $pdf->Cell(2, 5, ': ', 0, 'L');
//     $pdf->SetXY(95, $pdf->GetY());
//     $pdf->Cell(60, 5, $result1, 0, 'L');
//     return $pdf;
// }

// function  coret($pdf, $title1)
// {
//     $pdf->Ln(7);
//     $pdf->SetXY(11, $pdf->GetY());
//     $pdf->Cell(25, 5, $title1, 0, 'L');
//     return $pdf;
// }

// function  coret1($pdf, $title1)
// {
//     $pdf->Ln(7);
//     $pdf->SetXY(6, $pdf->GetY());
//     $pdf->Cell(25, 5, $title1, 0, 'L');
//     return $pdf;
// }
// function  coret1_miring($pdf, $text2, $miring2 = false)
// {
//     $pdf->SetFont('Times', $miring2 ? 'I' : '', 11);
//     $pdf->Ln(7);
//     $pdf->SetXY(6, $pdf->GetY());
//     $pdf->Cell(25, 5, $text2, 0, 'L');
//     return $pdf;
// }

// function coret5($pdf, $text, $miring = false)
// {
//     $pdf->Ln(5);
//     $pdf->SetFont('Times', '', 11);
//     $pdf->SetXY(6, $pdf->GetY());
//     if ($miring) {
//         $pdf->SetFont('Times', 'I', 11);
//     }

//     $pdf->Cell(0, 5, $text, 0, 1, 'L');

//     $pdf->SetFont('Times', '', 11);

//     return $pdf;
// }

// function coret_miring($pdf, $text1, $miring1 = false)
// {
//     $pdf->SetFont('Times', $miring1 ? 'I' : '', 11);
//     // $pdf->SetXY(15, $pdf->GetY());
//     $pdf->Ln(7);
//     $pdf->Cell(0, 5, $text1);
//     $pdf->SetFont('Times', '', 11);
// }
// function coret_miring2($pdf, $text1, $miring1 = false)
// {
//     $pdf->SetFont('Times', $miring1 ? 'I' : '', 11);
//     $pdf->Ln(7);
//     $pdf->SetXY(6, $pdf->GetY());
//     $pdf->Cell(25, 5, $text1);
//     $pdf->SetFont('Times', '', 11);
// }
