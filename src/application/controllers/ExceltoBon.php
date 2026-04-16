<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by Dwi Fitriadi Sukmawan : ITD-RSUP
 */

class ExceltoBon extends CI_Controller
{
    public function index(){
    $this->load->view('vbontk');
    }
    public function tanpa(){
    $this->load->view('tanpa_excel');
    }
    public function dengan(){
        $param=$this->uri->segment(3);
        $this->load->model('m_bonpiutang');
        $this->load->library("Excel/PHPExcel");

        //-------------------- Manggil Periode ---------------------------
        $periode_bon            = $this->input->post('selectperiod');
        // $periode_bon_pemborong  = date('Y-m-d', strtotime($periode_bon));

        //-------------------- Manggil Pemborong --------------------------
        $pemborong_bon    = $this->input->post('Pemborong');
        $getbon           = $this->m_bonpiutang->getPemborong_Bon($pemborong_bon);
        $namapemborong    = $getbon  ? $getbon->Pemborong : '';

        $title            = 'LAPORAN TENAGA KERJA DI PEMBORONG';
        $periode          = 'BULAN';

        $data = $this->m_bonpiutang->laporan_ExceltoBon($periode_bon, $pemborong_bon);

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);
            // $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

            $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('000');
            $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
            $objPHPExcel->getActiveSheet()->mergeCells('F1:G1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:G2');

                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', $title.' : '.$namapemborong)
                        ->setCellValue('F1', $periode.' : '.$periode_bon)

                        ->setCellValue('A3', 'No.')
                        ->setCellValue('B3', 'Departmen')
                        ->setCellValue('C3', 'NoFix')
                        ->setCellValue('D3', 'Nik')
                        ->setCellValue('E3', 'Nama')
                        ->setCellValue('F3', 'Jabatan')
                        ->setCellValue('G3', 'Pekerjaan');
                        // ->setCellValue('H3', 'Potongan');

                $ex = $objPHPExcel->setActiveSheetIndex(0);
                    $no = 1;
                    $counter = 4;
                    foreach ($data as $row):
                        $ex->setCellValue('A'.$counter, $no++);
                        $ex->setCellValue('B'.$counter, $row->BagianAbbr);
                        $ex->setCellValue('C'.$counter, $row->Nofix);
                        $ex->setCellValue('D'.$counter, $row->Nik);
                        $ex->setCellValue('E'.$counter, $row->Nama);
                        $ex->setCellValue('F'.$counter, $row->Jabatan);
                        $ex->setCellValue('G'.$counter, $row->Pekerjaan);
                        // $ex->setCellValue('H'.$counter, $row->Potongan);

                    $counter = $counter+1;
                    endforeach;

                $objPHPExcel->getActiveSheet()->setTitle('Excel Pertama');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                header("Cache-Control: no-store, no-cache, must-revalidate");
                header("Cache-Control: post-check=0, pre-check=0", false);
                header("Pragma: no-cache");
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="hasilExcelBon('.$periode_bon.').xlsx"');
                $objWriter->save("php://output");
     
    }
}

?>