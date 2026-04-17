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

class C_export_excel_blackilst_tenaker_cancel extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_wawancara'));
    }

    public function exportxls()
    {
        // $this->load->library("Excel/PHPExcel");
        $this->load->model(array('M_monitor', 'M_blacklist'));
        $style = $this->excelStyle();

        // print_r($style['PTStyle']);
        // die;


        $id = $this->uri->segment(4);
        $tk_cancel = $this->M_blacklist->get_tenaker_cancel_excel();



        // $objPHPExcel    = new PHPExcel();
        $objPHPExcel = new Spreadsheet();
        // Membuat sheet pertama
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0)->setTitle('List Tenaker Cancel');
        $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(3.14);

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
        $sheet->getPageMargins()->setLeft(0.5);
        $sheet->getPageMargins()->setRight(0.5);
        $sheet->getPageMargins()->setBottom(0.5);
        $sheet->getPageMargins()->setTop(0.5);
        $sheet->getPageSetup()->setFitToWidth(1);
        // $sheet->getPageSetup()->setScale(90);



        $start = 1;
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($start + 2) . ':BH' . ($start + 3));
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . ($start + 2), 'LIST TENAGA KERJA CANCEL');

        $sheet->getStyle('A' . ($start + 2) . ':BH' . ($start + 3))->applyFromArray($style['headerStyle']);



        $header_row = $start + 3;
        $sheet->mergeCells('A' . ($header_row + 2) . ':A' . ($header_row + 2))->setCellValue('A' . ($header_row + 2), 'NO');
        $sheet->mergeCells('B' . ($header_row + 2) . ':D' . ($header_row + 2))->setCellValue('B' . ($header_row + 2), 'ID');
        $sheet->mergeCells('E' . ($header_row + 2) . ':M' . ($header_row + 2))->setCellValue('E' . ($header_row + 2), 'NAMA');
        $sheet->mergeCells('N' . ($header_row + 2) . ':W' . ($header_row + 2))->setCellValue('N' . ($header_row + 2), 'No KTP');
        $sheet->mergeCells('X' . ($header_row + 2) . ':AF' . ($header_row + 2))->setCellValue('X' . ($header_row + 2), 'Perusahaan');
        $sheet->mergeCells('AG' . ($header_row + 2) . ':AO' . ($header_row + 2))->setCellValue('AG' . ($header_row + 2), 'Tgl Lahir');
        $sheet->mergeCells('AP' . ($header_row + 2) . ':AX' . ($header_row + 2))->setCellValue('AP' . ($header_row + 2), 'NAMA IBU');
        $sheet->mergeCells('AY' . ($header_row + 2) . ':BH' . ($header_row + 2))->setCellValue('AY' . ($header_row + 2), 'Keterangan');

        $sheet->getStyle('A' . ($header_row + 0) . ':A' . ($header_row + 2))->applyFromArray($style['headerStyleLeft']);
        $sheet->getStyle('BH' . ($header_row + 0) . ':BH' . ($header_row + 2))->applyFromArray($style['headerStyleRight']);
        $sheet->getStyle('A' . ($header_row + 2) . ':BH' . ($header_row + 2))->applyFromArray($style['headerStyle']);

        $detail_row = $header_row + 2;
        foreach ($tk_cancel as $key => $dt) {
            $detail_row++;

            $sheet->mergeCells('A' . ($detail_row + 0) . ':A' . ($detail_row + 0))->setCellValue('A' . ($detail_row + 0), ($key + 1));
            $sheet->mergeCells('B' . ($detail_row + 0) . ':D' . ($detail_row + 0))->setCellValue('B' . ($detail_row + 0), $dt->NIK);
            $sheet->mergeCells('E' . ($detail_row + 0) . ':M' . ($detail_row + 0))->setCellValue('E' . ($detail_row + 0), $dt->Nama);
            $sheet->mergeCells('N' . ($detail_row + 0) . ':W' . ($detail_row + 0))->setCellValue('N' . ($detail_row + 0), "`" . $dt->No_Ktp);
            $sheet->mergeCells('X' . ($detail_row + 0) . ':AF' . ($detail_row + 0))->setCellValue('X' . ($detail_row + 0), $dt->CV_Nama);
            $sheet->mergeCells('AG' . ($detail_row + 0) . ':AO' . ($detail_row + 0))->setCellValue('AG' . ($detail_row + 0), date('d-m-Y', strtotime($dt->Tgl_Lahir)));
            $sheet->mergeCells('AP' . ($detail_row + 0) . ':AX' . ($detail_row + 0))->setCellValue('AP' . ($detail_row + 0), $dt->Nama_Ibu);
            $sheet->mergeCells('AY' . ($detail_row + 0) . ':BH' . ($detail_row + 0))->setCellValue('AY' . ($detail_row + 0), $dt->Keterangan);

            $sheet->getStyle('A' . ($detail_row + 0) . ':BH' . ($detail_row + 0))->applyFromArray($style['bodyStyle']);
        }


        // $obj = $objPHPExcel->setActiveSheetIndex(0);
        // $obj->setCellValue('A3', 'NO.');
        // $obj->mergeCells('B3:I3')->setCellValue('B3', 'Item');
        // $obj->mergeCells('J3:S3')->setCellValue('J3', '');
        // $objPHPExcel->getActiveSheet()->getStyle('A1:S2')->applyFromArray($style['PTStyle']);
        // $objPHPExcel->getActiveSheet()->getStyle('A3:S3')->applyFromArray($style['DetailheaderStyle']);


        $counter = 4;
        $no = 1;
        // foreach ($item as $key => $row) :
        //     $obj->setCellValue('A' . $counter, $key + 1);
        //     $obj->mergeCells('B' . $counter . ':I' . $counter)->setCellValue('B' . $counter, $row['item'] . ((($key + 1) != 35) && ($key + 1) != 47 && ($key + 1) != 48 && ($key + 1) != 49 && ($key + 1) != 57 && ($key + 1) != 58 ? ' *)' : ''));
        //     if (($key + 1) >= 64) {

        //         $obj->mergeCells('J' . $counter . ':O' . $counter)->setCellValue('J' . $counter, (($key + 1) == 3 ? '`' : '') . $row['value']);
        //     } else {
        //         $obj->mergeCells('J' . $counter . ':S' . $counter)->setCellValue('J' . $counter, (($key + 1) == 3 ? '`' : '') . $row['value']);
        //     }
        //     $objPHPExcel->getActiveSheet()->getStyle('A' . $counter . ':S' . $counter)->applyFromArray($style['DetailheaderStyle']);
        //     $objPHPExcel->getActiveSheet()->getStyle('B' . $counter . ':B' . $counter)->applyFromArray($style['headerStyleLeft']);
        //     $objPHPExcel->getActiveSheet()->getStyle('J' . $counter . ':J' . $counter)->applyFromArray($style['headerStyleLeft']);

        //     $counter++;
        //     $no++;
        // endforeach;
        // $obj->mergeCells('P67:S67')->setCellValue('P67', 'Diverifikasi');
        // $obj->mergeCells('P68:S68')->setCellValue('P68', 'By : ');
        // $obj->mergeCells('P69:S69')->setCellValue('P69', 'Tgl :  ');
        // $obj->mergeCells('P70:S70')->setCellValue('P70', 'Paraf : ');

        // $counterb = $counter + 0;

        // $obj->mergeCells('A' . ($counterb + 0) . ':B' . ($counterb + 6))->setCellValue('A' . ($counterb + 0), 'PHOTO');
        // $obj->mergeCells('C' . ($counterb + 0) . ':E' . ($counterb + 0))->setCellValue('C' . ($counterb + 0), 'Lampiran dan keterangan');
        // $obj->mergeCells('C' . ($counterb + 1) . ':E' . ($counterb + 1))->setCellValue('C' . ($counterb + 1), '- TRANSKIP NILAI');
        // $obj->mergeCells('C' . ($counterb + 2) . ':E' . ($counterb + 2))->setCellValue('C' . ($counterb + 2), '-  *) HARUS DIISI');

        // $obj->mergeCells('N' . ($counterb + 0) . ':O' . ($counterb + 0))->setCellValue('N' . ($counterb + 0), 'Tanggal Data');
        // $obj->mergeCells('P' . ($counterb + 0) . ':Q' . ($counterb + 0))->setCellValue('P' . ($counterb + 0), ': ' . date('d-m-Y'));
        // $obj->mergeCells('A' . ($counterb + 7) . ':S' . ($counterb + 7))->setCellValue('A' . ($counterb + 7), 'Demikian Daftar Riwayat Hidup ini saya buat dengan sebenarnya');

        // $objPHPExcel->getActiveSheet()->getStyle('A' . ($counterb + 0) . ':B' . ($counterb + 6))->applyFromArray($style['DetailheaderStyle']);
        // $objPHPExcel->getActiveSheet()->getStyle('C' . ($counterb + 0) . ':S' . ($counterb + 6))->applyFromArray($style['noborderStyle']);
        // $objPHPExcel->getActiveSheet()->getStyle('A' . ($counterb + 7) . ':S' . ($counterb + 7))->applyFromArray($style['DetailheaderStyle']);
        // $objPHPExcel->getActiveSheet()->getStyle('P67:P70')->applyFromArray($style['headerStyleLeft']);

        // $objPHPExcel->getActiveSheet()->getStyle('S' . ($counterb + 0) . ':S' . ($counterb + 6))->applyFromArray($style['headerStyleRight']);



        // $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        // header('Last-Modified:' . gmdate("D, d M Y H:i:s") . 'GMT');
        // header('Chace-Control: no-store, no-cache, must-revalation');
        // header('Chace-Control: post-check=0, pre-check=0', FALSE);
        // header('Pragma: no-cache');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="List Tenaker Cancel ' . date('d-m-Y H:i:s') . '.xlsx"');

        // $objWriter->save('php://output');
        // batas
        // print_r($dt_detail);

        // ob_clean();
        // header('Content-Type: text/html; charset=utf-8');
        // header('Content-type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="CV (' . $nama_lengkap . ').xlsx"');

        // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        // $objWriter->save('php://output');
        // exit();
        // ob_end_clean();
        $writer = new Xlsx($objPHPExcel);

        header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="List Tenaker Cancel ' . date('d-m-Y H:i:s') . '.xlsx"');

        $writer->save('php://output');
        exit;
    }

    public function index()
    {
        // $this->load->library("Excel/PHPExcel");

        $dt_detail   = $this->m_wawancara->getTenagaKerja();

        // $objPHPExcel    = new PHPExcel();
        $objPHPExcel = new Spreadsheet();
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


    function excelStyle()
    {


        $DiagonalBorder = (array(
            'borders' => array(
                'diagonal' => array(
                    'style' => Border::BORDER_THIN,
                ),
                'diagonaldirection' => Borders::DIAGONAL_DOWN,
            ),
        ));


        $PTStyle = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => true,
                'name' => 'Times New Roman',
                'size' => 14
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_THIN),
                'right'  => array('style' => Border::BORDER_THIN),
                'left'   => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $DetailheaderDetDashStyle = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_THIN),
                'right'  => array('style' => Border::BORDER_DASHDOTDOT),
                'left'   => array('style' => Border::BORDER_DASHDOTDOT),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $justBorderStyle = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 12
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_THIN),
                'right'  => array('style' => Border::BORDER_THIN),
                'left'   => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
        ));

        $borderJustBottomStyle = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 12
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_THIN),
            ),
        ));


        $PTStyleNoRightBorder = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold' => true,
                'name' => 'Times New Roman',
                'size' => 14
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_THIN),
                'left'   => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $headerStyle = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => true,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'allborders' => [
                    'style' => Border::BORDER_THIN,
                ],
                // 'bottom' => array('style' => Border::BORDER_THIN),
                // 'right'  => array('style' => Border::BORDER_THIN),
                // 'left'   => array('style' => Border::BORDER_THIN),
                // 'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $headerStyleRight = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $headerStyleRightcenter = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $headerStyleRightleftcenter = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'left'  => array('style' => Border::BORDER_THIN),
                'right'  => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $StyleBottom = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom'  => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $StyleBorderTop = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'top'  => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $StyleBottomunderline = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11,
                // 'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom'  => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $headerStyleLeft = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'left'  => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $headerStyleLeftRight = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'left'  => array('style' => Border::BORDER_THIN),
                'right'  => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $headerStyleLeftRight2 = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'left'  => array('style' => Border::BORDER_THIN),
                'right'  => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $headerStyleRightTop = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $headerStyleLeftTop = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'left'  => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $headerStyleRightbottom = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN),
                'bottom'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $headerStyleRightbottomcenter = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN),
                'bottom'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $headerStyleRightleftbottomcenter = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN),
                'bottom'    => array('style' => Border::BORDER_THIN),
                'left'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $headerStyleRightleftbottom = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN),
                'bottom'    => array('style' => Border::BORDER_THIN),
                'left'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $headerStyleLeftBottom = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'left'  => array('style' => Border::BORDER_THIN),
                'bottom'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $headerStyleRightBottomTop = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN),
                'bottom'    => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $StyleRightBottomTop = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN),
                'bottom'    => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $Style14 = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 14
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));


        $headerStyleLeftBottomTop = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'left'  => array('style' => Border::BORDER_THIN),
                'bottom'    => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $headerStyleLeftRightTop = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'left'  => array('style' => Border::BORDER_THIN),
                'right' => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $headerStyleTopBottom = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $justBottom = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $justTop = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'top' => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $justRight = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right' => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $justLeft = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'left' => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $StyleLeftBottomTop = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'left'  => array('style' => Border::BORDER_THIN),
                'bottom'    => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $StyleBottomTop = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom'    => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $noborderStyle = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));


        $rightborderStyle = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $leftborderStyle = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'left'  => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $DetailheaderStyle = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_THIN),
                'right'  => array('style' => Border::BORDER_THIN),
                'left'   => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $DetailheaderStyleBold = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => true,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_THIN),
                'right'  => array('style' => Border::BORDER_THIN),
                'left'   => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $DetailheaderStyleleft = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => true,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_THIN),
                'left'   => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $DetailheaderStyleleftNoBorder = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => true,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            // 'borders' => array(
            //   'bottom' => array('style' => Border::BORDER_THIN),
            //   'left'   => array('style' => Border::BORDER_THIN),
            //   'top'    => array('style' => Border::BORDER_THIN)
            // ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $DetailheaderStyletopbottom = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $DetailheaderStyleright = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_THIN),
                'right'   => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $DetailheaderVerticalStyle = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_THIN),
                'right'  => array('style' => Border::BORDER_THIN),
                'left'   => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_BOTTOM,
                'wrap'       => true
            ),
        ));

        $DetailheaderRightTopStyle = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => true,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $DetailheaderRightBottomStyle = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => true,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN),
                'bottom'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $DetailheaderRightStyle = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => true,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $DetailheaderLeftStyle = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => true,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'left'  => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $footerStyleRightbottom = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN),
                'bottom'    => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $footerStyleRightTop = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $footerStyleRightbottom2 = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN),
                'bottom'    => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $footerStyleRightbottom3 = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN),
                'bottom'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $footerStyleRight = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $footerStyleRightLeftbottom = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN),
                'left'   => array('style' => Border::BORDER_THIN),
                'bottom' => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $footerRightLeftbottom = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'right'  => array('style' => Border::BORDER_THIN),
                'left'   => array('style' => Border::BORDER_THIN),
                'bottom' => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $footerStyleLeftbottom = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'top'  => array('style' => Border::BORDER_THIN),
                'left'  => array('style' => Border::BORDER_THIN),
                'bottom'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $footerStyleLeft = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'left'  => array('style' => Border::BORDER_THIN),
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $footerStylebottomtop = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom'    => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $footerStylebottom = (array(
            'fill'   => array(
                'type'    => Fill::FILL_SOLID
            ),
            'font' => array(
                'bold'    => false,
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code'    => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $bodyStyle = (array(
            'fill'   => array(
                'type'  => Fill::FILL_SOLID,
                'color' => array('argb' => 'FFFFFFFF')
            ),
            'font'   => array(
                'name' => 'Times New Roman',
                'size'  => 11
            ),
            'numberformat'   => array(
                'code' => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom'  => array('style' => Border::BORDER_THIN),
                'right'   => array('style' => Border::BORDER_THIN),
                'left'    => array('style' => Border::BORDER_THIN),
                'top'     => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrap'     => true
            ),
        ));

        $bodyStylewithDoth = (array(
            'fill'   => array(
                'type'  => Fill::FILL_SOLID,
                'color' => array('argb' => 'FFFFFFFF')
            ),
            'font'   => array(
                'name' => 'Times New Roman',
                'size'  => 11
            ),
            'numberformat'   => array(
                'code' => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom'  => array('style' => Border::BORDER_DOTTED),
                'right'   => array('style' => Border::BORDER_THIN),
                'left'    => array('style' => Border::BORDER_THIN),
                'top'     => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrap'     => true
            ),
        ));

        $bodyStylewithNoBorderTop = (array(
            'fill'   => array(
                'type'  => Fill::FILL_SOLID,
                'color' => array('argb' => 'FFFFFFFF')
            ),
            'font'   => array(
                'name' => 'Times New Roman',
                'size'  => 11
            ),
            'numberformat'   => array(
                'code' => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom'  => array('style' => Border::BORDER_THIN),
                'right'   => array('style' => Border::BORDER_THIN),
                'left'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrap'     => true
            ),
        ));

        $bodyStyleLeft = (array(
            'fill'   => array(
                'type'  => Fill::FILL_SOLID,
                'color' => array('argb' => 'FFFFFFFF')
            ),
            'font'   => array(
                'name' => 'Times New Roman',
                'size'  => 11
            ),
            'numberformat'   => array(
                'code' => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom'  => array('style' => Border::BORDER_THIN),
                'right'   => array('style' => Border::BORDER_THIN),
                'left'    => array('style' => Border::BORDER_THIN),
                'top'     => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $doubleLeft = (array(
            'fill'   => array(
                'type'  => Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFFFFFF')
            ),
            'font'   => array(
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code' => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_THIN),
                'right'  => array('style' => Border::BORDER_THIN),
                'left'   => array('style' => Border::BORDER_DOUBLE),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $doubleLeftBottom = (array(
            'fill'   => array(
                'type'  => Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFFFFFF')
            ),
            'font'   => array(
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code' => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_DOUBLE),
                'right'  => array('style' => Border::BORDER_THIN),
                'left'   => array('style' => Border::BORDER_DOUBLE),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $doubleSolidTop = (array(
            'fill'   => array(
                'type'  => Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFFFFFF')
            ),
            'font'   => array(
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code' => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'top' => array('style' => Border::BORDER_THICK)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $doubleSolidBottom = (array(
            'fill'   => array(
                'type'  => Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFFFFFF')
            ),
            'font'   => array(
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code' => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_THICK),
                'right'  => array('style' => Border::BORDER_THIN),
                'left'   => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $doubleBottom = (array(
            'fill'   => array(
                'type'  => Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFFFFFF')
            ),
            'font'   => array(
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code' => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_DOUBLE),
                'right'  => array('style' => Border::BORDER_THIN),
                'left'   => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $doubleBottomBold = (array(
            'fill'   => array(
                'type'  => Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFFFFFF')
            ),
            'font'   => array(
                'name' => 'Times New Roman',
                'size' => 11,
                'bold' => true
            ),
            'numberformat'   => array(
                'code' => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_DOUBLE),
                'right'  => array('style' => Border::BORDER_THIN),
                'left'   => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $noborderTop = (array(
            'fill'   => array(
                'type'  => Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFFFFFF')
            ),
            'font'   => array(
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code' => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_DOUBLE),
                'right'  => array('style' => Border::BORDER_THIN),
                'left'   => array('style' => Border::BORDER_THIN),
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $noborderTop2 = (array(
            'fill'   => array(
                'type'  => Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFFFFFF')
            ),
            'font'   => array(
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code' => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_DOUBLE),
                'right'  => array('style' => Border::BORDER_THIN),
                'left'   => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_THIN),
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $noborderTop3 = (array(
            'fill'   => array(
                'type'  => Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFFFFFF')
            ),
            'font'   => array(
                'name' => 'Times New Roman',
                'size' => 11
            ),
            'numberformat'   => array(
                'code' => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_THIN),
                'right'  => array('style' => Border::BORDER_THIN),
                'left'   => array('style' => Border::BORDER_THIN),
                'top'    => array('style' => Border::BORDER_DOUBLE),
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));
        $boderdottedbottom = (array(
            'fill'   => array(
                'type'  => Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFFFFFF'),

            ),
            'font'   => array(
                'name' => 'Times New Roman',
                'size' => 11,
                'bold'    => true,
            ),
            'numberformat'   => array(
                'code' => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom' => array('style' => Border::BORDER_DOTTED),

            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrap'       => true
            ),
        ));

        $leftBottomTop = (array(
            'fill'   => array(
                'type'  => Fill::FILL_SOLID,
                'color' => array('argb' => 'FFFFFFFF')
            ),
            'font'   => array(
                'name' => 'Times New Roman',
                'size'  => 11
            ),
            'numberformat'   => array(
                'code' => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom'  => array('style' => Border::BORDER_THIN),
                // 'right'   => array('style' => Border::BORDER_THIN),
                'left'    => array('style' => Border::BORDER_THIN),
                'top'     => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrap'     => true
            ),
        ));
        $rightBottomTop = (array(
            'fill'   => array(
                'type'  => Fill::FILL_SOLID,
                'color' => array('argb' => 'FFFFFFFF')
            ),
            'font'   => array(
                'name' => 'Times New Roman',
                'size'  => 11
            ),
            'numberformat'   => array(
                'code' => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom'  => array('style' => Border::BORDER_THIN),
                'right'   => array('style' => Border::BORDER_THIN),
                // 'left'    => array('style' => Border::BORDER_THIN),
                'top'     => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrap'     => true
            ),
        ));
        $BottomTop = (array(
            'fill'   => array(
                'type'  => Fill::FILL_SOLID,
                'color' => array('argb' => 'FFFFFFFF')
            ),
            'font'   => array(
                'name' => 'Times New Roman',
                'size'  => 11
            ),
            'numberformat'   => array(
                'code' => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom'  => array('style' => Border::BORDER_THIN),
                // 'right'   => array('style' => Border::BORDER_THIN),
                // 'left'    => array('style' => Border::BORDER_THIN),
                'top'     => array('style' => Border::BORDER_THIN)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrap'     => true
            ),
        ));

        $bodyStylewithDot = (array(
            'fill'   => array(
                'type'  => Fill::FILL_SOLID,
                'color' => array('argb' => 'FFFFFFFF')
            ),
            'font'   => array(
                'name' => 'Times New Roman',
                'size'  => 11
            ),
            'numberformat'   => array(
                'code' => NumberFormat::FORMAT_TEXT
            ),
            'borders' => array(
                'bottom'  => array('style' => Border::BORDER_DOTTED),
                'right'   => array('style' => Border::BORDER_DOTTED),
                'left'    => array('style' => Border::BORDER_DOTTED),
                'top'     => array('style' => Border::BORDER_DOTTED)
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrap'     => true
            ),
        ));


        return [
            'PTStyle'                          => $PTStyle,
            'DetailheaderDetDashStyle'         => $DetailheaderDetDashStyle,
            'justBorderStyle'                  => $justBorderStyle,
            'PTStyleNoRightBorder'             => $PTStyleNoRightBorder,
            'headerStyle'                      => $headerStyle,
            'DetailheaderStyle'                => $DetailheaderStyle,
            'DetailheaderStyleBold'            => $DetailheaderStyleBold,
            'DetailheaderStyleleft'            => $DetailheaderStyleleft,
            'DetailheaderStyleleftNoBorder'    => $DetailheaderStyleleftNoBorder,
            'DetailheaderStyletopbottom'       => $DetailheaderStyletopbottom,
            'DetailheaderStyleright'           => $DetailheaderStyleright,
            'DetailheaderVerticalStyle'        => $DetailheaderVerticalStyle,
            'bodyStyle'                        => $bodyStyle,
            'doubleLeft'                       => $doubleLeft,
            'doubleLeftBottom'                 => $doubleLeftBottom,
            'doubleBottom'                     => $doubleBottom,
            'doubleBottomBold'                 => $doubleBottomBold,
            'doubleSolidTop'                   => $doubleSolidTop,
            'doubleSolidBottom'                => $doubleSolidBottom,
            'noborderTop'                      => $noborderTop,
            'noborderTop2'                     => $noborderTop2,
            'noborderTop3'                     => $noborderTop3,
            'headerStyleRight'                 => $headerStyleRight,
            'headerStyleRightcenter'           => $headerStyleRightcenter,
            'headerStyleRightleftcenter'       => $headerStyleRightleftcenter,
            'headerStyleLeft'                  => $headerStyleLeft,
            'headerStyleLeftRight'             => $headerStyleLeftRight,
            'headerStyleLeftRight2'            => $headerStyleLeftRight2,
            'headerStyleRightTop'              => $headerStyleRightTop,
            'headerStyleLeftTop'               => $headerStyleLeftTop,
            'headerStyleRightbottom'           => $headerStyleRightbottom,
            'headerStyleRightbottomcenter'     => $headerStyleRightbottomcenter,
            'headerStyleRightleftbottomcenter' => $headerStyleRightleftbottomcenter,
            'headerStyleRightleftbottom'       => $headerStyleRightleftbottom,
            'headerStyleLeftBottom'            => $headerStyleLeftBottom,
            'headerStyleRightBottomTop'        => $headerStyleRightBottomTop,
            'headerStyleLeftBottomTop'         => $headerStyleLeftBottomTop,
            'headerStyleLeftRightTop'          => $headerStyleLeftRightTop,
            'headerStyleTopBottom'             => $headerStyleTopBottom,
            'StyleLeftBottomTop'               => $StyleLeftBottomTop,
            'StyleRightBottomTop'              => $StyleRightBottomTop,
            'Style14'                          => $Style14,
            'StyleBottomTop'                   => $StyleBottomTop,
            'StyleBottom'                      => $StyleBottom,
            'StyleBorderTop'                   => $StyleBorderTop,
            'StyleBottomunderline'             => $StyleBottomunderline,
            'borderJustBottomStyle'            => $borderJustBottomStyle,
            'noborderStyle'                    => $noborderStyle,
            'rightborderStyle'                 => $rightborderStyle,
            'leftborderStyle'                  => $leftborderStyle,
            'DetailheaderRightTopStyle'        => $DetailheaderRightTopStyle,
            'DetailheaderRightStyle'           => $DetailheaderRightStyle,
            'DetailheaderLeftStyle'            => $DetailheaderLeftStyle,
            'DetailheaderRightBottomStyle'     => $DetailheaderRightBottomStyle,
            'footerStyleRightbottom'           => $footerStyleRightbottom,
            'footerStyleRightbottom2'          => $footerStyleRightbottom2,
            'footerStyleRightbottom3'          => $footerStyleRightbottom3,
            'footerStyleRightTop'              => $footerStyleRightTop,
            'footerStyleRight'                 => $footerStyleRight,
            'footerStyleRightLeftbottom'       => $footerStyleRightLeftbottom,
            'footerRightLeftbottom'            => $footerRightLeftbottom,
            'footerStyleLeftbottom'            => $footerStyleLeftbottom,
            'footerStyleLeft'                  => $footerStyleLeft,
            'footerStylebottomtop'             => $footerStylebottomtop,
            'footerStylebottom'                => $footerStylebottom,
            'boderdottedbottom'                => $boderdottedbottom,
            'bodyStyleLeft'                    => $bodyStyleLeft,
            'bodyStylewithDoth'                => $bodyStylewithDoth,
            'bodyStylewithDot'                => $bodyStylewithDot,
            'bodyStylewithNoBorderTop'         => $bodyStylewithNoBorderTop,
            'justBottom'                       => $justBottom,
            'justTop'                          => $justTop,
            'justRight'                        => $justRight,
            'justLeft'                         => $justLeft,
            'leftBottomTop'                    => $leftBottomTop,
            'rightBottomTop'                   => $rightBottomTop,
            'BottomTop'                        => $BottomTop,
            'DiagonalBorder'                   => $DiagonalBorder,
        ];
    }

    // function excelStyle()
    // {


    //     $DiagonalBorder = (array(
    //         'borders' => array(
    //             'diagonal' => array(
    //                 'style' => PHPExcel_Style_Border::BORDER_THIN,
    //             ),
    //             'diagonaldirection' => PHPExcel_Style_Borders::DIAGONAL_DOWN,
    //         ),
    //     ));


    //     $PTStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => true,
    //             'name' => 'Times New Roman',
    //             'size' => 14
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $DetailheaderDetDashStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_DASHDOTDOT),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_DASHDOTDOT),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $justBorderStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 12
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //     ));

    //     $borderJustBottomStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 12
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //         ),
    //     ));


    //     $PTStyleNoRightBorder = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold' => true,
    //             'name' => 'Times New Roman',
    //             'size' => 14
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $headerStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => true,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'allborders' => [
    //                 'style' => PHPExcel_Style_Border::BORDER_THIN,
    //             ],
    //             // 'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             // 'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             // 'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             // 'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $headerStyleRight = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $headerStyleRightcenter = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $headerStyleRightleftcenter = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $StyleBottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $StyleBorderTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'top'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $StyleBottomunderline = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11,
    //             // 'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $headerStyleLeft = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $headerStyleLeftRight = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $headerStyleLeftRight2 = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $headerStyleRightTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $headerStyleLeftTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $headerStyleRightbottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $headerStyleRightbottomcenter = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $headerStyleRightleftbottomcenter = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $headerStyleRightleftbottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $headerStyleLeftBottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $headerStyleRightBottomTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $StyleRightBottomTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $Style14 = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 14
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));


    //     $headerStyleLeftBottomTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $headerStyleLeftRightTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $headerStyleTopBottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $justBottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $justTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $justRight = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $justLeft = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $StyleLeftBottomTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $StyleBottomTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $noborderStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));


    //     $rightborderStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $leftborderStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $DetailheaderStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $DetailheaderStyleBold = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => true,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $DetailheaderStyleleft = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => true,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $DetailheaderStyleleftNoBorder = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => true,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         // 'borders' => array(
    //         //   'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //         //   'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //         //   'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         // ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $DetailheaderStyletopbottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $DetailheaderStyleright = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $DetailheaderVerticalStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_BOTTOM,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $DetailheaderRightTopStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => true,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $DetailheaderRightBottomStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => true,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $DetailheaderRightStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => true,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $DetailheaderLeftStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => true,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $footerStyleRightbottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $footerStyleRightTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $footerStyleRightbottom2 = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $footerStyleRightbottom3 = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $footerStyleRight = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $footerStyleRightLeftbottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $footerRightLeftbottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $footerStyleLeftbottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'top'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $footerStyleLeft = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $footerStylebottomtop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $footerStylebottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $bodyStyle = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('argb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size'  => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'     => true
    //         ),
    //     ));

    //     $bodyStylewithDoth = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('argb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size'  => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_DOTTED),
    //             'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'     => true
    //         ),
    //     ));

    //     $bodyStylewithNoBorderTop = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('argb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size'  => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'     => true
    //         ),
    //     ));

    //     $bodyStyleLeft = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('argb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size'  => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $doubleLeft = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $doubleLeftBottom = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $doubleSolidTop = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'top' => array('style' => PHPExcel_Style_Border::BORDER_THICK)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $doubleSolidBottom = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THICK),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $doubleBottom = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $doubleBottomBold = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11,
    //             'bold' => true
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $noborderTop = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $noborderTop2 = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $noborderTop3 = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE),
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $boderdottedbottom = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF'),

    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11,
    //             'bold'    => true,
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED),

    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $leftBottomTop = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('argb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size'  => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             // 'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'     => true
    //         ),
    //     ));
    //     $rightBottomTop = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('argb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size'  => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             // 'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'     => true
    //         ),
    //     ));
    //     $BottomTop = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('argb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size'  => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             // 'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             // 'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'     => true
    //         ),
    //     ));


    //     return [
    //         'PTStyle'                          => $PTStyle,
    //         'DetailheaderDetDashStyle'         => $DetailheaderDetDashStyle,
    //         'justBorderStyle'                  => $justBorderStyle,
    //         'PTStyleNoRightBorder'             => $PTStyleNoRightBorder,
    //         'headerStyle'                      => $headerStyle,
    //         'DetailheaderStyle'                => $DetailheaderStyle,
    //         'DetailheaderStyleBold'            => $DetailheaderStyleBold,
    //         'DetailheaderStyleleft'            => $DetailheaderStyleleft,
    //         'DetailheaderStyleleftNoBorder'    => $DetailheaderStyleleftNoBorder,
    //         'DetailheaderStyletopbottom'       => $DetailheaderStyletopbottom,
    //         'DetailheaderStyleright'           => $DetailheaderStyleright,
    //         'DetailheaderVerticalStyle'        => $DetailheaderVerticalStyle,
    //         'bodyStyle'                        => $bodyStyle,
    //         'doubleLeft'                       => $doubleLeft,
    //         'doubleLeftBottom'                 => $doubleLeftBottom,
    //         'doubleBottom'                     => $doubleBottom,
    //         'doubleBottomBold'                 => $doubleBottomBold,
    //         'doubleSolidTop'                   => $doubleSolidTop,
    //         'doubleSolidBottom'                => $doubleSolidBottom,
    //         'noborderTop'                      => $noborderTop,
    //         'noborderTop2'                     => $noborderTop2,
    //         'noborderTop3'                     => $noborderTop3,
    //         'headerStyleRight'                 => $headerStyleRight,
    //         'headerStyleRightcenter'           => $headerStyleRightcenter,
    //         'headerStyleRightleftcenter'       => $headerStyleRightleftcenter,
    //         'headerStyleLeft'                  => $headerStyleLeft,
    //         'headerStyleLeftRight'             => $headerStyleLeftRight,
    //         'headerStyleLeftRight2'            => $headerStyleLeftRight2,
    //         'headerStyleRightTop'              => $headerStyleRightTop,
    //         'headerStyleLeftTop'               => $headerStyleLeftTop,
    //         'headerStyleRightbottom'           => $headerStyleRightbottom,
    //         'headerStyleRightbottomcenter'     => $headerStyleRightbottomcenter,
    //         'headerStyleRightleftbottomcenter' => $headerStyleRightleftbottomcenter,
    //         'headerStyleRightleftbottom'       => $headerStyleRightleftbottom,
    //         'headerStyleLeftBottom'            => $headerStyleLeftBottom,
    //         'headerStyleRightBottomTop'        => $headerStyleRightBottomTop,
    //         'headerStyleLeftBottomTop'         => $headerStyleLeftBottomTop,
    //         'headerStyleLeftRightTop'          => $headerStyleLeftRightTop,
    //         'headerStyleTopBottom'             => $headerStyleTopBottom,
    //         'StyleLeftBottomTop'               => $StyleLeftBottomTop,
    //         'StyleRightBottomTop'              => $StyleRightBottomTop,
    //         'Style14'                          => $Style14,
    //         'StyleBottomTop'                   => $StyleBottomTop,
    //         'StyleBottom'                      => $StyleBottom,
    //         'StyleBorderTop'                   => $StyleBorderTop,
    //         'StyleBottomunderline'             => $StyleBottomunderline,
    //         'borderJustBottomStyle'            => $borderJustBottomStyle,
    //         'noborderStyle'                    => $noborderStyle,
    //         'rightborderStyle'                 => $rightborderStyle,
    //         'leftborderStyle'                  => $leftborderStyle,
    //         'DetailheaderRightTopStyle'        => $DetailheaderRightTopStyle,
    //         'DetailheaderRightStyle'           => $DetailheaderRightStyle,
    //         'DetailheaderLeftStyle'            => $DetailheaderLeftStyle,
    //         'DetailheaderRightBottomStyle'     => $DetailheaderRightBottomStyle,
    //         'footerStyleRightbottom'           => $footerStyleRightbottom,
    //         'footerStyleRightbottom2'          => $footerStyleRightbottom2,
    //         'footerStyleRightbottom3'          => $footerStyleRightbottom3,
    //         'footerStyleRightTop'              => $footerStyleRightTop,
    //         'footerStyleRight'                 => $footerStyleRight,
    //         'footerStyleRightLeftbottom'       => $footerStyleRightLeftbottom,
    //         'footerRightLeftbottom'            => $footerRightLeftbottom,
    //         'footerStyleLeftbottom'            => $footerStyleLeftbottom,
    //         'footerStyleLeft'                  => $footerStyleLeft,
    //         'footerStylebottomtop'             => $footerStylebottomtop,
    //         'footerStylebottom'                => $footerStylebottom,
    //         'boderdottedbottom'                => $boderdottedbottom,
    //         'bodyStyleLeft'                    => $bodyStyleLeft,
    //         'bodyStylewithDoth'                => $bodyStylewithDoth,
    //         'bodyStylewithNoBorderTop'         => $bodyStylewithNoBorderTop,
    //         'justBottom'                       => $justBottom,
    //         'justTop'                          => $justTop,
    //         'justRight'                        => $justRight,
    //         'justLeft'                         => $justLeft,
    //         'leftBottomTop'                    => $leftBottomTop,
    //         'rightBottomTop'                   => $rightBottomTop,
    //         'BottomTop'                        => $BottomTop,
    //         'DiagonalBorder'                   => $DiagonalBorder,
    //     ];
    // }
}
