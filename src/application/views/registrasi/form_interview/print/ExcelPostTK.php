<?php

$this->load->library("Excel/PHPExcel");

$objPHPExcel    = new PHPExcel();
$style_col = array(
    'font'      => array(
        'bold' => FALSE,
        'name' => 'Times New Roman',
        'size' => '11'
    ), // Set font nya jadi bold  
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'wrap' => true, // Set text jadi ditengah secara horizontal (center)    
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ),
    'borders' => array(
        'left'   => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis   
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis    
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis    
        'top'  => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis  
    )
);

$header3 = array(
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT), // Set text jadi di tengah secara horizontal (middle)  ), 
    'font' => array('bold' => false, 'name' => 'Times New Roman', 'size' => '11'),
    'borders' => array(
        'top'   => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis   
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis    
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis    
        'left'  => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis  
    )
);


$header4 = array(
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), // Set text jadi di tengah secara horizontal (middle)  ), 
    'font' => array('bold' => false, 'name' => 'Times New Roman', 'size' => '14'),
    'borders' => array(
        'top'   => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis   
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis    
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis    
        'left'  => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis  
    )
);

$header5 = array(
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), // Set text jadi di tengah secara horizontal (middle)  ), 
    'font' => array('bold' => false, 'name' => 'Times New Roman', 'size' => '11'),
    'borders' => array(
        'top'   => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis   
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis    
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis    
        'left'  => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis  
    ),
);

$Bold = array(
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), // Set text jadi di tengah secara horizontal (middle)  ), 
    'font' => array('bold' => true, 'name' => 'Times New Roman', 'size' => '11', 'italic' => false),
    'borders' => array(
        'top'   => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis   
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis    
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis    
        'left'  => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis  
    )
);

$start_row = 1;

$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(25);
// $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setRowHeight(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);

$objPHPExcel->getActiveSheet()->getRowDimension($start_row + 1)->setRowHeight(30);


$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A' . ($start_row + 1), 'No')
    ->setCellValue('B' . ($start_row + 1), 'Nama')
    ->setCellValue('C' . ($start_row + 1), 'Kelamin')
    ->setCellValue('D' . ($start_row + 1), 'Tanggal Lahir')
    ->setCellValue('E' . ($start_row + 1), 'Kota Lahir')
    ->setCellValue('F' . ($start_row + 1), 'No KTP')
    ->setCellValue('G' . ($start_row + 1), 'EXP KTP')
    ->setCellValue('H' . ($start_row + 1), 'Kota KTP')
    ->setCellValue('I' . ($start_row + 1), 'Gelar SBL')
    ->setCellValue('J' . ($start_row + 1), 'Gelar SDH')
    ->setCellValue('K' . ($start_row + 1), 'Ibu Kandung')
    ->setCellValue('L' . ($start_row + 1), 'Alamat 1')
    ->setCellValue('M' . ($start_row + 1), 'Alamat 2')
    ->setCellValue('N' . ($start_row + 1), 'Kode Pos')
    ->setCellValue('O' . ($start_row + 1), 'CIF NO')
    ->setCellValue('P' . ($start_row + 1), 'PRODUK')
    ->setCellValue('Q' . ($start_row + 1), 'CURRENCY')
    ->setCellValue('R' . ($start_row + 1), 'PEKERJAAN')
    ->setCellValue('S' . ($start_row + 1), 'JABATAN')
    ->setCellValue('T' . ($start_row + 1), 'EMPLOYER')
    ->setCellValue('U' . ($start_row + 1), 'Tanggal Mulai')
    ->setCellValue('V' . ($start_row + 1), 'Kode Industri')
    ->setCellValue('W' . ($start_row + 1), 'Gaji')
    ->setCellValue('X' . ($start_row + 1), 'Pen Lain')
    ->setCellValue('Y' . ($start_row + 1), 'Telpon Rumah')
    ->setCellValue('Z' . ($start_row + 1), 'Warga Negara')
    ->setCellValue('AA' . ($start_row + 1), 'Status Kawin')
    ->setCellValue('AB' . ($start_row + 1), 'Tujuan Buka Rekening')
    ->setCellValue('AC' . ($start_row + 1), 'Biaya Admin Khusus')
    ->setCellValue('AD' . ($start_row + 1), 'Kode Cabang')
    ->setCellValue('AE' . ($start_row + 1), 'Bansos Type')
    ->setCellValue('AF' . ($start_row + 1), 'NPWP')
    ->setCellValue('AG' . ($start_row + 1), 'No Telp')
    ->setCellValue('AH' . ($start_row + 1), 'Email');



$objPHPExcel->getActiveSheet()->getStyle('A2:AH2')->applyFromArray($header4);

$row = $start_row + 2;
foreach ($getDetail as $key => $get) {

    $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':AH' . $row)->applyFromArray($style_col);

    $objPHPExcel->getActiveSheet()
        ->getStyle('F' . $row)
        ->getNumberFormat()
        ->setFormatCode(
            PHPExcel_Style_NumberFormat::FORMAT_TEXT
        );

    $objPHPExcel->getActiveSheet()
        ->getStyle('AG' . $row)
        ->getNumberFormat()
        ->setFormatCode(
            PHPExcel_Style_NumberFormat::FORMAT_TEXT
        );

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $row, $key + 1)
        ->setCellValue('B' . $row, $get->Nama)
        ->setCellValue('C' . $row, $get->Jenis_Kelamin == 'PEREMPUAN' ? 'P' : 'L')
        ->setCellValue('D' . $row, date('d-m-Y', strtotime($get->Tgl_Lahir)))
        ->setCellValue('E' . $row, $get->Tempat_Lahir)
        ->setCellValue('F' . $row, "'" . (string)$get->No_Ktp)
        ->setCellValue('G' . $row, '')
        ->setCellValue('H' . $row, $get->Kabupaten_KotaName) //  Link ke master kota
        ->setCellValue('I' . $row, '') // Gelar sbl
        ->setCellValue('J' . $row, '') // Gelar sdh
        ->setCellValue('K' . $row, $get->NamaIbuKandung)
        ->setCellValue('L' . $row, $get->Alamat)
        ->setCellValue('M' . $row, 'RT : ' . $get->RT . '/ RW : ' . $get->RW)
        ->setCellValue('N' . $row, '29255') // kode pos
        ->setCellValue('O' . $row, '0') // Cif no
        ->setCellValue('P' . $row, 'TABFP-4') // produk
        ->setCellValue('Q' . $row, 'IDR') // currency
        ->setCellValue('R' . $row, 'PSW') // Pekerjaaan
        ->setCellValue('S' . $row, '09') // Jabatan
        ->setCellValue('T' . $row, 'PT PULAU SAMBU -TRAINEE') // Jabatan
        ->setCellValue('U' . $row, date('d-m-Y', strtotime($get->ClosingDate)))
        ->setCellValue('V' . $row, '03') // kode industri
        ->setCellValue('W' . $row, '241.162') // gaji
        ->setCellValue('X' . $row, '0') // pen lain
        ->setCellValue('Y' . $row, 'TIDAK MEMILIKI') // telp rumah
        ->setCellValue('Z' . $row, '0') // warga negara
        ->setCellValue('AA' . $row, $get->Status_Personal)
        ->setCellValue('AB' . $row, 'A')
        ->setCellValue('AC' . $row, '8000')
        ->setCellValue('AD' . $row, "'10832")
        ->setCellValue('AE' . $row, "")  //bansos type
        ->setCellValue('AF' . $row, "")  // npwp
        ->setCellValue('AG' . $row, '+62' . substr($get->NoHP, 1))
        ->setCellValue('AH' . $row, $get->Account_email);

    $row++;
}


// $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

// header('Last-Modified:' . gmdate("D, d M Y H:i:s") . 'GMT');
// header('Chace-Control: no-store, no-cache, must-revalation');
// header('Chace-Control: post-check=0, pre-check=0', FALSE);
// header('Pragma: no-cache');
// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: attachment;filename="Post Tenaker.xlsx"');

// $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

// $objWriter->save('php://output');
sleep(2);
ob_clean();
header('Content-Type: text/html; charset=utf-8');
header('Content-type: application/vnd.ms-excel');
// header('Content-Disposition: attachment;filename=' . $frmnm . '.xls');
header('Content-Disposition: attachment;filename="Post Tenaker.xls"');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit();
ob_end_clean();
