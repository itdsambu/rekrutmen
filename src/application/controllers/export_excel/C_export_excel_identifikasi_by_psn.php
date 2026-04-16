<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Borders;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class C_export_excel_identifikasi_by_psn extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_wawancara'));
    }

    public function index()
    {
        // $this->load->library("Excel/PHPExcel");

        $dt_detail   = $this->m_wawancara->getTenagaKerja();

        $objPHPExcel    = new Spreadsheet();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(100);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);

        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('000');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Identifikasi By PSN - List Tenaga Kerja Baru / ' . date("d-m-Y H:i:s"))
            ->setCellValue('A3', 'No.')
            ->setCellValue('B3', 'RegisID')
            ->setCellValue('C3', 'Nama')
            ->setCellValue('D3', 'Jenis Kelamin')
            ->setCellValue('E3', 'Pemborong')
            ->setCellValue('F3', 'Asal')
            ->setCellValue('G3', 'Terakhir Verifikasi Oleh');

        $obj = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 4;
        foreach ($dt_detail as $key => $row) :
            $obj->setCellValue('A' . $counter, $key + 1);
            $obj->setCellValue('B' . $counter, $row->HeaderID);
            $obj->setCellValue('C' . $counter, $row->Nama);
            $obj->setCellValue('D' . $counter, $row->Jenis_Kelamin);
            $obj->setCellValue('E' . $counter, $row->Pemborong . ' - ' . $row->CVNama);
            $obj->setCellValue('F' . $counter, $row->Alamat);
            $obj->setCellValue('G' . $counter, $row->VerifiedBy . ' (' . date("d-m-Y", strtotime($row->VerifiedDate)) . ')');
            $counter++;
        endforeach;

        // $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        // header('Last-Modified:' . gmdate("D, d M Y H:i:s") . 'GMT');
        // header('Chace-Control: no-store, no-cache, must-revalation');
        // header('Chace-Control: post-check=0, pre-check=0', FALSE);
        // header('Pragma: no-cache');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="Identifikasi By PSN (' . date("d-m-Y His") . ').xlsx"');

        // $objWriter->save('php://output');

        $writer = new Xlsx($objPHPExcel);

        header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Identifikasi By PSN (' . date("d-m-Y His") . ').xlsx"');

        $writer->save('php://output');
        exit;
    }
}
