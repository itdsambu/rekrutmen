<?php 

class Laporan_excel extends CI_Controller {

   public function laporan() {

      include APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel.php';
      include APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';

      $obj = new PHPExcel();

      $obj->getProperties()->setCreator("Pulau Sambu");
      $obj->getProperties()->setLastModifiedBy("Pulau Sambu"); 
      $obj->getProperties()->setTitle("Data Karantina");

      $obj->setActiveSheetIndex(0);

      // styling
      $style1 = [

         'font'      => ['bold'=> true, 'name'=> 'Time New Roman', 'size'=> '14'],
         'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'wrap' =>true,
                         'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER],
   
         'borders'   => [    
                        'top'   => ['style'  => PHPExcel_Style_Border::BORDER_THIN], // Set border top dengan garis tipis   
                        'right' => ['style'  => PHPExcel_Style_Border::BORDER_THIN],  // Set border right dengan garis tipis    
                        'bottom'=> ['style'  => PHPExcel_Style_Border::BORDER_THIN], // Set border bottom dengan garis tipis    
                        'left'  => ['style'  => PHPExcel_Style_Border::BORDER_THIN] // Set border left dengan garis tipis  
                        ]
                  ];

      $style2 = [  

         'font'      => [ 'bold'=> true, 'name'=> 'Times New Roman', 'size'=> '12' ],
         'alignment' => [ 'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'wrap' => true,
                           'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER],
         'borders'   => [    
                           'top'   => ['style'  => PHPExcel_Style_Border::BORDER_THIN], // Set border top dengan garis tipis   
                           'right' => ['style'  => PHPExcel_Style_Border::BORDER_THIN],  // Set border right dengan garis tipis    
                           'bottom'=> ['style'  => PHPExcel_Style_Border::BORDER_THIN], // Set border bottom dengan garis tipis    
                           'left'  => ['style'  => PHPExcel_Style_Border::BORDER_THIN] // Set border left dengan garis tipis  
                           ]
                  ];

      $style3  = [

         'font'      => ['bold'=> true, 'name'=> 'Time New Roman', 'size'=> '6'],

         'borders'   => [    
                           'top'   => ['style'  => PHPExcel_Style_Border::BORDER_THIN], // Set border top dengan garis tipis   
                           'right' => ['style'  => PHPExcel_Style_Border::BORDER_THIN],  // Set border right dengan garis tipis    
                           'bottom'=> ['style'  => PHPExcel_Style_Border::BORDER_THIN], // Set border bottom dengan garis tipis    
                           'left'  => ['style'  => PHPExcel_Style_Border::BORDER_THIN] // Set border left dengan garis tipis  
                           ]];
      
      $obj->getActiveSheet()->mergeCells('A2:R2')->setCellValue('A2', 'DAFTAR KARANTINA PERTANGGAL');
      $obj->getActiveSheet()->mergeCells('A3:B3')->setCellValue('A3', 'BULAN');
      $obj->getActiveSheet()->mergeCells('C3:R3')->setCellValue('C3', date('d-m-Y'));
      $obj->getActiveSheet()->mergeCells('A4:B4')->setCellValue('A4', 'TANGGAL');
      $obj->getActiveSheet()->mergeCells('A5:B5')->setCellValue('A5', 'TOTAL');
      $obj->getActiveSheet()->mergeCells('A6:B6')->setCellValue('A6', 'S1');
      $obj->getActiveSheet()->mergeCells('A7:B7')->setCellValue('A7', 'D3');
      $obj->getActiveSheet()->mergeCells('A8:B8')->setCellValue('A8', 'SMK');
      $obj->getActiveSheet()->mergeCells('A9:B9')->setCellValue('A9', 'TK');
    
      $obj->getActiveSheet()->setCellValue('C4', '9');
      $obj->getActiveSheet()->setCellValue('D4', '10');
      $obj->getActiveSheet()->setCellValue('E4', '11');
      $obj->getActiveSheet()->setCellValue('F4', '12');
      $obj->getActiveSheet()->setCellValue('G4', '13');
      $obj->getActiveSheet()->setCellValue('H4', '14');
      $obj->getActiveSheet()->setCellValue('I4', '15');
      $obj->getActiveSheet()->setCellValue('J4', '16');
      $obj->getActiveSheet()->mergeCells('K4:N4')->setCellValue('K4', 'Total Masuk Karantina Tanggal 1 - 8');
      $obj->getActiveSheet()->mergeCells('O4:R4')->setCellValue('O4', 'Total Belum Selesai Karantina');
      $obj->getActiveSheet()->mergeCells('K5:N9')->setCellValue('K5', '');
      $obj->getActiveSheet()->mergeCells('O5:R9')->setCellValue('O5', '');
     
      $obj->getActiveSheet()->getStyle('A2:R2')->applyFromArray($style1);
      $obj->getActiveSheet()->getStyle('A3:B3')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('C3:R3')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('A4:B4')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('A5:B5')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('A6:B6')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('A7:B7')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('A8:B8')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('A9:B9')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('C4')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('D4')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('E4')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('F4')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('G4')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('H4')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('I4')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('J4')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('K4:N4')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('O4:R4')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('C5')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('C6')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('C7')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('C8')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('C9')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('D5')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('D6')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('D7')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('D8')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('D9')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('E5')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('E6')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('E7')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('E8')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('E9')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('F5')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('F6')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('F7')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('F8')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('F9')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('G5')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('G6')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('G7')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('G8')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('G9')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('H5')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('H6')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('H7')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('H8')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('H9')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('I5')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('I6')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('I7')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('I8')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('I9')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('J5')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('J6')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('J7')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('J8')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('J9')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('K5:N9')->applyFromArray($style2);
      $obj->getActiveSheet()->getStyle('O5:R9')->applyFromArray($style2);
      

      // $baris = 9;
      // $no = 1;
      // foreach ($data['grinder'] as $gd) 
      // {
      //    // $obj->getActiveSheet()->setCellValue('A' .$baris, $no++);
      //    // $obj->getActiveSheet()->setCellValue('B' .$baris, $gd['tanggal']);
      //    $obj->getActiveSheet()->setCellValue('A' .$baris, $gd['jam'])->getStyle('A9')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('B' .$baris, $gd['gpb1'])->getStyle('B9')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('C' .$baris, $gd['gpb2'])->getStyle('C9')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('D' .$baris, $gd['gpb3'])->getStyle('D9')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('E' .$baris, $gd['gpb4'])->getStyle('E9')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('F' .$baris, $gd['gpb5'])->getStyle('F9')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('G' .$baris, $gd['regulator1'])->getStyle('G9:H9')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('I' .$baris, $gd['regulator2'])->getStyle('I9:J9')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('K' .$baris, $gd['regulator3'])->getStyle('K9')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('L' .$baris, $gd['regulator4'])->getStyle('L9')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('M' .$baris, $gd['regulator5'])->getStyle('M9')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('N' .$baris, $gd['main_motor'])->getStyle('N9')->applyFromArray($style1);

      //    $baris++;
         
      // }


      
      // // $a=$baris++;
      // $obj->getActiveSheet()->getStyle('A10:N20')->applyFromArray($style1);


      // $data['spraywater'] = $this->Spraywater_model->getAllSpray();
      // $baris1 = 26;
      // foreach($data['spraywater'] as $sp)
      // {
      //    $obj->getActiveSheet()->setCellValue('A' .$baris1, $sp['jam'])->getStyle('A26')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('B' .$baris1, $sp['spray_water_sh07'])->getStyle('B26')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('C' .$baris1, $sp['gpb6'])->getStyle('C26')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('D' .$baris1, $sp['gpb7'])->getStyle('D26')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('E' .$baris1, $sp['gpb8'])->getStyle('E26')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('F' .$baris1, $sp['gpb9'])->getStyle('F26')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('G' .$baris1, $sp['regulator1'])->getStyle('G26')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('I' .$baris1, $sp['regulator2'])->getStyle('I26')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('K' .$baris1, $sp['regulator3'])->getStyle('K26')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('L' .$baris1, $sp['regulator4'])->getStyle('L26')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('M' .$baris1, $sp['regulator5'])->getStyle('M26')->applyFromArray($style1);
      //    $obj->getActiveSheet()->setCellValue('N' .$baris1, $sp['main_motor'])->getStyle('N26')->applyFromArray($style1);
      // }

      // // $b=$baris++;
      // $obj->getActiveSheet()->getStyle('A37:N40')->applyFromArray($style3);
      // $obj->getActiveSheet()->mergeCells('A39:N39')->setCellValue('A39', 'Keterangan :');
      // $obj->getActiveSheet()->getStyle('A41:N41')->applyFromArray($style3);
      // $obj->getActiveSheet()->mergeCells('A41:N41')->setCellValue('A41', 'Mulai Berlaku :');


      $filename = "Data Karantina".'.xlsx';

      // $objSheet = new PHPExcel_Worksheet_Drawing();
      // $objSheet->setName('test');
      // $objSheet->setDescription('test');
      // $objSheet->setPath(base_url('third_party/PSG.png'));
      // $objSheet->setCoordinates('A1');
      // $objSheet->getWorksheet($obj->getActiveSheet());

      
      $obj->getActiveSheet()->setTitle('Data Karantina');

      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachement; filename="'.$filename. '"');
      header('Cache-Control: max-age=0');

      $writer = PHPExcel_IOFactory::createWriter($obj, 'Excel2007');
      $writer->save('php://output');

      exit;
   }
}