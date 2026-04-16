<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by Dwi Fitriadi Sukmawan : ITD-RSUP
 */

class BontoExcel extends CI_Controller
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

            $newdata = array(
                    'periode'  => $this->input->post('selectperiod'),
                    'bon'      => $this->input->post('Pemborong'),
            );

            $this->session->set_userdata($newdata);
    }

    public function excel(){
        $param=$this->uri->segment(3);
        $this->load->model('m_bonpiutang');
        $this->load->library("Excel/PHPExcel");

        //-------------------- Manggil Periode ---------------------------
        $periode_bon            = $this->session->userdata('periode');

        // $periode_bon_pemborong  = date('Y-m-d', strtotime($periode_bon));

        $idperiodegajian  = $this->session->userdata('periode');
        $idpemborong      = $this->session->userdata('bon');
        $totalsum         = $this->m_bonpiutang->gettotalsum($idpemborong,$idperiodegajian);
        $total_bon        = 'Total Bon';

        //-------------------- Manggil Pemborong --------------------------
        $pemborong_bon    = $this->session->userdata('bon');
        $getbon           = $this->m_bonpiutang->getPemborong_Bon($pemborong_bon);
        $namapemborong    = $getbon  ? $getbon->Pemborong : '';

        $title            = 'LAPORAN BON TENAGA KERJA BULAN';
        $pemborong        = 'Nama Pemborong';

        $data = $this->m_bonpiutang->laporan_default($periode_bon, $pemborong_bon);

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

            $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('000');
            $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
            $objPHPExcel->getActiveSheet()->mergeCells('F1:G1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:H2');

                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', $title.' : '.$periode_bon )
                        ->setCellValue('F1', $pemborong.' : '.$namapemborong)
                        ->setCellValue('H1', $total_bon.' : '.$totalsum)

                        ->setCellValue('A3', 'No.')
                        ->setCellValue('B3', 'Departmen')
                        ->setCellValue('C3', 'NoFix')
                        ->setCellValue('D3', 'Nik')
                        ->setCellValue('E3', 'Nama')
                        ->setCellValue('F3', 'Jabatan')
                        ->setCellValue('G3', 'Pekerjaan')
                        ->setCellValue('H3', 'Potongan');

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
                        $ex->setCellValue('H'.$counter, $row->Potongan);

                    $counter = $counter+1;
                    endforeach;

                $objPHPExcel->getActiveSheet()->setTitle('Excel Pertama');
              
                header('Content-Type: application/vnd.ms-excel');
                $file_name = "BonTK-".date("Y-m-d_H:i:s").".xls";
                header("Content-Disposition: attachment; filename=$file_name");
                // If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
    }
}

?>