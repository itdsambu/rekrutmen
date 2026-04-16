<?php 

$this->load->library("Excel/PHPExcel");

$objPHPExcel    = new PHPExcel();
$style_col = array(  
    'font'      => array('bold' => FALSE,
                         'name' => 'Times New Roman',
                         'size' => '11'
                        ), // Set font nya jadi bold  
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'wrap' =>true, // Set text jadi ditengah secara horizontal (center)    
    'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
 ),
'borders' => array(    
    'left'   => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis   
    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis    
    'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis    
    'top'  => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis  
    )
);

$header3= array(
        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT ),// Set text jadi di tengah secara horizontal (middle)  ), 
        'font'=> array('bold'=> false,'name' => 'Times New Roman','size' => '11'), 
        'borders' => array(    
            'top'   => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis   
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis    
            'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis    
            'left'  => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis  
            )
        );


$header4= array(
        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER ),// Set text jadi di tengah secara horizontal (middle)  ), 
        'font'=> array('bold'=> false,'name' => 'Times New Roman','size' => '14'), 
        'borders' => array(    
            'top'   => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis   
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis    
            'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis    
            'left'  => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis  
            )
        );

$header5 = array(
        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER ),// Set text jadi di tengah secara horizontal (middle)  ), 
        'font'=> array('bold'=> false,'name' => 'Times New Roman','size' => '11'), 
        'borders' => array(    
            'top'   => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis   
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis    
            'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis    
            'left'  => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis  
            ),
        );

 $Bold= array(
        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER ),// Set text jadi di tengah secara horizontal (middle)  ), 
        'font'=> array('bold'=> true,'name' => 'Times New Roman','size' => '11','italic'=> false), 
        'borders' => array(    
            'top'   => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis   
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis    
            'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis    
            'left'  => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis  
            )
        );
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(9,29);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25,29);

        //Marge Cells
         $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');

         $objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($header4);

         $objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($header4);        
         $objPHPExcel->getActiveSheet()->getStyle('A5:D5')->applyFromArray($style_col);        
         $objPHPExcel->getActiveSheet()->getStyle('A5:A5')->applyFromArray($style_col);        
         $objPHPExcel->getActiveSheet()->getStyle('B5:B5')->applyFromArray($style_col);        
         $objPHPExcel->getActiveSheet()->getStyle('C5:C5')->applyFromArray($style_col);        
         $objPHPExcel->getActiveSheet()->getStyle('D5:D5')->applyFromArray($style_col);        

         $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2','HASIL INPUT HARGA DI ITEM BARANG OLEH PEMBORONG') 
                ->setCellValue('A5','NO')
                ->setCellValue('B5','Pemborong')
                ->setCellValue('C5','Sub Pemborong')
                ->setCellValue('D5','Jumlah')
                
        ;
        
        $row=6;
        foreach($_getData as $get=> $key){

            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':A'.$row)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$row.':B'.$row)->applyFromArray($header3);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$row.':C'.$row)->applyFromArray($header3);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$row.':D'.$row)->applyFromArray($style_col);

            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.$row,$get+1)
                        ->setCellValue('B'.$row,$key->Pemborong)
                        ->setCellValue('C'.$row,$key->NamaSub)
                        ->setCellValue('D'.$row,$key->Jumlah)
                        
            ;

            $row++;
        }

        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="List Hasil Input Harga.xlsx"');

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        
        $objWriter->save('php://output');
?>