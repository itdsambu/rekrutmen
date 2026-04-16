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
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

        //Marge Cells
         $objPHPExcel->getActiveSheet()->mergeCells('A2:H2');

         $objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($header4);

         $objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($header4);        
         $objPHPExcel->getActiveSheet()->getStyle('A5:D5')->applyFromArray($style_col);        
         $objPHPExcel->getActiveSheet()->getStyle('A5:A5')->applyFromArray($style_col);        
         $objPHPExcel->getActiveSheet()->getStyle('B5:B5')->applyFromArray($style_col);        
         $objPHPExcel->getActiveSheet()->getStyle('C5:C5')->applyFromArray($style_col);        
         $objPHPExcel->getActiveSheet()->getStyle('D5:D5')->applyFromArray($style_col);
         $objPHPExcel->getActiveSheet()->getStyle('E5:E5')->applyFromArray($style_col);
         $objPHPExcel->getActiveSheet()->getStyle('F5:F5')->applyFromArray($style_col);
         $objPHPExcel->getActiveSheet()->getStyle('G5:G5')->applyFromArray($style_col);
         $objPHPExcel->getActiveSheet()->getStyle('H5:H5')->applyFromArray($style_col);
        //  $objPHPExcel->getActiveSheet()->getStyle('I5:I5')->applyFromArray($style_col);
             

         $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2','LIST POTONGAN BON BELUM PROSES') 
                ->setCellValue('A5','NO')
                ->setCellValue('B5','TANGGAL')
                // ->setCellValue('C5','NOFIX')
                ->setCellValue('C5','NIK')
                ->setCellValue('D5','NAMA')
                ->setCellValue('F5','CV')
                ->setCellValue('G5','PEMBORONG')
                // ->setCellValue('H5','SUB PEMBORONG')
                ->setCellValue('H5','GRAND TOTAL')
                
        ;
        
        $objPHPExcel->getActiveSheet()->mergeCells('D5:E5');
        $row =7;
         foreach($_getDataExcel as $get=> $key){

            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':A'.$row)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$row.':B'.$row)->applyFromArray($header3);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$row.':C'.$row)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$row.':D'.$row)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$row.':E'.$row)->applyFromArray($header3);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$row.':F'.$row)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$row.':G'.$row)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$row.':H'.$row)->applyFromArray($style_col);
            // $objPHPExcel->getActiveSheet()->getStyle('I'.$row.':I'.$row)->applyFromArray($style_col);
            
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.$row,$get+1)
                        ->setCellValue('B'.$row,date('d-m-Y',strtotime($key->Tanggal)))
                        // ->setCellValue('C'.$row,$key->Nofix)
                        ->setCellValue('C'.$row,$key->Nik)
                        ->setCellValue('D'.$row,$key->Nama)
                        ->setCellValue('F'.$row,$key->Perusahaan)
                        ->setCellValue('G'.$row,$key->Pemborong)
                        // ->setCellValue('H'.$row,$key->NamaSub)
                        ->setCellValue('H'.$row,number_format(($key->GrandTotal),0,".",","))
                        
            ;
            $objPHPExcel->getActiveSheet()->mergeCells('D'.$row.':E'.$row);
           
            $row++;
        }
        
        
        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="List Potongan Bon Belum Proses.xlsx"');

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        
        $objWriter->save('php://output');
?>