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
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15,29);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25,29);

        //Marge Cells
         $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');

         $objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($header4);
         
          $objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($header4);
          $objPHPExcel->getActiveSheet()->getStyle('A12:D12')->applyFromArray($style_col);
          $objPHPExcel->getActiveSheet()->getStyle('A12:A12')->applyFromArray($style_col);        
          $objPHPExcel->getActiveSheet()->getStyle('B12:B12')->applyFromArray($style_col);        
          $objPHPExcel->getActiveSheet()->getStyle('C12:C12')->applyFromArray($style_col);        
          $objPHPExcel->getActiveSheet()->getStyle('D12:D12')->applyFromArray($style_col);         
        
         $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2','Rekap Bon Tenaga Kerja') 
                ->setCellValue('A4','Periode :')
                ->setCellValue('A5','Nama :')
                ->setCellValue('A6','NIK :')
                ->setCellValue('A7','Nofix :')
                ->setCellValue('A8','Departemen :')
                ->setCellValue('A9','Pemborong :')
                ->setCellValue('A10','Sub Pemborong :')
                
        ;

        $objPHPExcel->getActiveSheet()->getStyle('A12:D12')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('A12:A12')->applyFromArray($style_col);        
        $objPHPExcel->getActiveSheet()->getStyle('B12:B12')->applyFromArray($style_col);        
        $objPHPExcel->getActiveSheet()->getStyle('C12:C12')->applyFromArray($style_col);        
        $objPHPExcel->getActiveSheet()->getStyle('D12:D12')->applyFromArray($style_col);        

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A12','No') 
                ->setCellValue('B12','NAMA ITEM')
                ->setCellValue('C12','SEMBAKO(Rp.)')
                ->setCellValue('D12','CICILAN(Rp.)')                
        ;

        foreach($getDataKaryawan as $key){

            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('B4',date('d-m-Y',strtotime($key->PeriodeGajian)))
                        ->setCellValue('B5',$key->Nama)
                        ->setCellValue('B6',$key->Nik)
                        ->setCellValue('B7',$key->Nofix.' ')
                        ->setCellValue('B8',$key->Bagian)
                        ->setCellValue('B9',$key->Pemborong)
                        ->setCellValue('B10',$key->NamaSub)
            ;
        }

        $total_sembako_all = 0;
        $total_cicilan_all = 0;
        $row=13;
        foreach($getDataPemborong as $key=> $get){

                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':A'.$row)->applyFromArray($style_col);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$row.':B'.$row)->applyFromArray($style_col);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$row.':C'.$row)->applyFromArray($style_col);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$row.':D'.$row)->applyFromArray($style_col);  

                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$row,$key+1)
                            ->setCellValue('B'.$row,$get->NamaItem)
                            // ->setCellValue('C'.$row,str_replace(",", ".", number_format($get->Total_s,0,".",",")) )
                            ->setCellValue('C'.$row,number_format($get->Total_s,0,".",","))
                            ->setCellValue('D'.$row,number_format($get->Total_c,0,".",","))
                ;
                $total_sembako_all += $get->Total_s;
                $total_cicilan_all += $get->Total_c;
                $row++;

        }

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B'.$row,'TOTAL')
                ->setCellValue('C'.$row,'Rp.'.number_format($total_sembako_all,0,".",","))
                ->setCellValue('D'.$row,'Rp.'.number_format($total_cicilan_all,0,".",","))
        ;

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B'.($row+1),'TOTAL DIPOTONG')
                //->setCellValue('C'.($row+1),$total_sembako_all)
                //->setCellValue('D'.($row+1),$total_cicilan_all)
        ;

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B'.($row+2),'SISA POTONGAN')
                // ->setCellValue('C'.$row,$total_sembako_all)
                // ->setCellValue('D'.$row,$total_cicilan_all)
        ;

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B'.($row+3),'TOTAL SISA')
                // ->setCellValue('C'.$row,$total_sembako_all)
                // ->setCellValue('D'.$row,$total_cicilan_all)
        ;

        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Rekap Bon TK.xlsx"');

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        
        $objWriter->save('php://output');
?>