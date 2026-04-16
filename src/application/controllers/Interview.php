<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


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

class Interview extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('darurat', 'M_Interview'));
        $this->load->helper('path');
        //        $status = 1;
        $status = $this->darurat->getStatus();
        if ($status === 1 && $this->session->userdata('userid') !== 'ismo_adm') {
            redirect(site_url('maintenanceControl'));
        }

        date_default_timezone_set("Asia/Jakarta");
        if (!$this->session->userdata('userid')) {
            redirect('login');
        }
        $this->load->library(array('template', 'form_validation'));
    }

    function index()
    {
        $dataSelect             = $this->uri->segment(3);
        $num                    = $this->uri->segment(4);
        if ($num == FALSE && $dataSelect == FALSE) {
            redirect('interview/index/0/1');
        } elseif ($num == FALSE) {
            redirect('interview/index/' . $dataSelect . '/1');
        }

        $numStart               = $num - 1;
        $start                  = 1;
        $end                    = 0;
        $startPaging            = (int)$numStart . $start;
        $endPaging              = (int)$num . $end;
        if ($dataSelect == 0) {
            $total                  = $this->M_Interview->countAllInterviewTenaker();
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->M_Interview->selectAllInterviewTenaker($startPaging, $endPaging);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
        } elseif ($dataSelect == 1) {
            $total                  = $this->M_Interview->countLulusInterviewTenaker();
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->M_Interview->selectLulusInterviewTenaker($startPaging, $endPaging);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
        } elseif ($dataSelect == 2) {
            $total                  = $this->M_Interview->countGagalInterviewTenaker();
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->M_Interview->selectGagalInterviewTenaker($startPaging, $endPaging);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
        } else {
            $total                  = NULL;
            $data['_selected']      = NULL;
            $data['_selectWhere']   = NULL;
            $data['_pagination']    = NULL;
        }

        $this->template->display('monitor/interview/index', $data);
    }

    function indexGet()
    {
        $dataFilter = $this->input->post('selDataFilter');

        $this->session->unset_userdata('w_noreg');
        $this->session->unset_userdata('w_nama');
        $this->session->unset_userdata('w_dept');
        $this->session->unset_userdata('w_tanggal');

        if ($this->input->post('txtRegno') == NULL && $this->input->post('txtNama') == NULL && $this->input->post('txtDept') == NULL && $this->input->post('txtTangal') == NULL) {
            redirect('interview/index/' . $dataFilter);
        }

        $this->session->set_userdata('w_noreg', $this->input->post('txtRegno'));
        $this->session->set_userdata('w_nama', $this->input->post('txtNama'));
        $this->session->set_userdata('w_dept', $this->input->post('txtDept'));
        $this->session->set_userdata('w_tanggal', $this->input->post('txtTangal'));

        redirect('interview/indexWhere/' . $dataFilter . '/1');
    }

    function indexWhere()
    {
        $dataSelect             = $this->uri->segment(3);
        $num                    = $this->uri->segment(4);

        $noreg           = $this->session->userdata('w_noreg');
        $nama           = $this->session->userdata('w_nama');
        $dept           = $this->session->userdata('w_dept');
        $tanggal           = $this->session->userdata('w_tanggal');

        $numStart               = $num - 1;
        $start                  = 1;
        $end                    = 0;
        $startPaging            = (int)$numStart . $start;
        $endPaging              = (int)$num . $end;

        if ($dataSelect == 0) {
            $total                  = $this->M_Interview->countAllInterviewTenakerWhere($noreg, $nama, $dept, $tanggal);
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->M_Interview->selectAllInterviewTenakerWhere($startPaging, $endPaging, $noreg, $nama, $dept, $tanggal);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
        } elseif ($dataSelect == 1) {
            $total                  = $this->M_Interview->countLulusInterviewTenakerWhere($noreg, $nama, $dept, $tanggal);
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->M_Interview->selectLulusInterviewTenakerWhere($startPaging, $endPaging, $noreg, $nama, $dept, $tanggal);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
        } elseif ($dataSelect == 2) {
            $total                  = $this->M_Interview->countGagalInterviewTenakerWhere($noreg, $nama, $dept, $tanggal);
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->M_Interview->selectGagalInterviewTenakerWhere($startPaging, $endPaging, $noreg, $nama, $dept, $tanggal);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
        } else {
            $total                  = NULL;
            $data['_selected']      = NULL;
            $data['_selectWhere']   = NULL;
            $data['_pagination']    = NULL;
        }
        $this->template->display('monitor/interview/index', $data);
    }

    function viewBNI()
    {
        ob_start();
        $hdrid = $this->uri->segment(3);
        $data['getDetail'] = $this->M_Interview->getResult($hdrid);
        $data['tglPrint']   = date("d M Y");

        $this->load->view('monitor/interview/print/SuratBNI', $data);
        $html    = ob_get_contents();
        ob_end_clean();

        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P', 'A4', 'en');
        $pdf->writeHTML($html);
        $pdf->Output('Surat Pernyataan BNI.pdf');
    }

    function SPTP()
    {
        ob_start();
        $hdrid = $this->uri->segment(3);
        $data['getDetail'] = $this->M_Interview->getResult($hdrid);
        $data['tglPrint']   = date("d M Y");

        $this->load->view('monitor/interview/print/SPTP', $data);
        $html    = ob_get_contents();
        ob_end_clean();

        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P', 'A4', 'en');
        $pdf->writeHTML($html);
        $pdf->Output('SPTP.pdf');
    }

    function Kontrak()
    {
        ob_start();
        $hdrid = $this->uri->segment(3);
        $data['getDetail'] = $this->M_Interview->getResult($hdrid);
        $data['tglPrint']   = date("d M Y");

        $this->load->view('monitor/interview/print/Kontrak', $data);
        $html    = ob_get_contents();
        ob_end_clean();

        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P', 'A4', 'en');
        $pdf->writeHTML($html);
        $pdf->Output('Kontrak.pdf');
    }

    function ttsurat()
    {
        $this->load->view('monitor/interview/ttdsurat');
    }

    function simpan_foto()
    {
        $id = $this->input->post('Nofix');
        // $nik = $this->input->post('NIK');
        $upload_dir = "dataupload/datakar/TTD_TK/";
        $file = $upload_dir . $this->input->post('Nofix') . ".png";
        // $upload_dir = "dataupload/ttd/";
        // $upload_dir_mod = "dataupload/ttdbynik/";
        // $file = $upload_dir . $this->input->post('HeaderID') . ".png";
        // $file2 = $upload_dir . $this->input->post('NIK') . ".png";

        $img = $this->input->post('hidden_data');
        $imges = str_replace('data:image/png;base64,', '', $img);
        $imge = str_replace(' ', '+', $imges);
        $image = base64_decode($imge);
        $success = file_put_contents($file, $image);
        // $success = file_put_contents($file2,$image);
        if ($image != false) {
            imagejpeg($image, $file);
        }
        $data = array(
            'Sts_ttd'     => 1
        );
        $result = $this->M_Interview->updatedata($id, $data);
        if (!$result) {
            redirect('interview/index/0/1/' . $id);
        } else {
            redirect('interview/index/0/1/' . $id);
        }
    }

    function pagination($page = 1, $per_page = 10, $row = 0)
    {
        $total = $row;
        $adjacents = "2";

        $page = ($page == 0 ? 1 : $page);
        $start = ($page - 1) * $per_page;

        $prev = $page - 1;
        $next = $page + 1;
        $lastpage = ceil($total / $per_page);
        $lpm1 = $lastpage - 1;

        $pagination = "";
        if ($lastpage > 1) {
            $pagination .= "<ul class='pagination'>";
            $pagination .= "<li><a>Page $page of $lastpage</a></li>";
            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<li class='active'><a>$counter</a></li>";
                    } else {
                        $pagination .= "<li><a href='$counter'>$counter</a></li>";
                    }
                }
            } elseif ($lastpage > 5 + ($adjacents * 2)) {
                if ($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page) {
                            $pagination .= "<li class='active'><a class='active'>$counter</a></li>";
                        } else {
                            $pagination .= "<li><a href='$counter'>$counter</a></li>";
                        }
                    }
                    $pagination .= "<li class='dot'><a>...</a></li>";
                    $pagination .= "<li><a href='$lpm1'>$lpm1</a></li>";
                    $pagination .= "<li><a href='$lastpage'>$lastpage</a></li>";
                } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination .= "<li><a href='1'>1</a></li>";
                    $pagination .= "<li><a href='2'>2</a></li>";
                    $pagination .= "<li class='dot'><a>...</a></li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li class='active'><a class='active'>$counter</a></li>";
                        else
                            $pagination .= "<li><a href='$counter'>$counter</a></li>";
                    }
                    $pagination .= "<li class='dot'><a>...</a></li>";
                    $pagination .= "<li><a href='$lpm1'>$lpm1</a></li>";
                    $pagination .= "<li><a href='$lastpage'>$lastpage</a></li>";
                } else {
                    $pagination .= "<li><a href='1'>1</a></li>";
                    $pagination .= "<li><a href='2'>2</a></li>";
                    $pagination .= "<li class='dot'><a>...</a></li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li class='active'><a class='active'>$counter</a></li>";
                        else
                            $pagination .= "<li><a href='$counter'>$counter</a></li>";
                    }
                }
            }

            if ($page < $counter - 1) {
                $pagination .= "<li><a href='$next'>Next</a></li>";
                $pagination .= "<li><a href='$lastpage'>Last</a></li>";
            } else {
                $pagination .= "<li><a class='current'>Next</a></li>";
                $pagination .= "<li><a class='current'>Last</a></li>";
            }
            $pagination .= "</ul>\n";
        }
        return $pagination;
    }

    public function downloadInterview()
    {
        // $this->load->library("Excel/PHPExcel");

        $export = $this->input->post('selDataExport');
        // select data from database
        $periode    = $this->input->post('dttanggal');

        if ($export == 'all') {
            $title  = 'List Semua TK Interview';
            $data   = $this->M_Interview->toExcelSemuainterviewTK($periode);
        } elseif ($export == 'lulus') {
            $title  = 'List TK Interview Lulus';
            $data   = $this->M_Interview->toExcellulusinterviewTK($periode);
        } elseif ($export == 'gagal') {
            $title  = 'List TK Interview Gagal';
            $data   = $this->M_Interview->toExcelgagalinterviewTK($periode);
        } else {
            $data   = NULL;
            $title  = NULL;
        }

        // $objPHPExcel    = new PHPExcel();
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(36);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(18);

        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('000');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', $title . ' : ' . $periode)

            ->setCellValue('A3', 'No.')
            ->setCellValue('B3', 'RegisID')
            ->setCellValue('C3', 'Nama')
            ->setCellValue('D3', 'Pemborong')
            ->setCellValue('E3', 'CV Nama')
            ->setCellValue('F3', 'Perusahaan')
            ->setCellValue('G3', 'Departemen')
            ->setCellValue('H3', 'Bagian')
            ->setCellValue('I3', 'Shift')
            ->setCellValue('J3', 'Hasil Wawancara')
            ->setCellValue('K3', 'Tanggal wawancara');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $no = 1;
        $counter = 4;
        foreach ($data as $row) {
            $ex->setCellValue('A' . $counter, $no++);
            $ex->setCellValue('B' . $counter, $row->HeaderID);
            $ex->setCellValue('C' . $counter, $row->Nama);
            $ex->setCellValue('D' . $counter, $row->Pemborong);
            $ex->setCellValue('E' . $counter, $row->CVNama);
            $ex->setCellValue('F' . $counter, $row->Pemborong);
            $ex->setCellValue('G' . $counter, $row->Departemen);
            $ex->setCellValue('H' . $counter, $row->Transaksi);
            $ex->setCellValue('I' . $counter, $row->Shift);
            if ($row->HasilWawancara == 1) {
                $ex->setCellValue('J' . $counter, 'LULUS');
            } else {
                $ex->setCellValue('J' . $counter, 'GAGAL');
            }
            $ex->setCellValue('K' . $counter, date('d M Y', strtotime($row->Tanggal)));
            $counter = $counter + 1;
        }

        // $objPHPExcel->getActiveSheet()->setTitle('LaporanInterviewTenaker');

        // $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        // header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        // header('Chace-Control: no-store, no-cache, must-revalation');
        // header('Chace-Control: post-check=0, pre-check=0', FALSE);
        // header('Pragma: no-cache');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="Lap_InterviewTenaker('.$periode.').xls"');

        // $objWriter->save('php://output');

        $writer = new Xlsx($objPHPExcel);

        header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Lap_InterviewTenaker(' . $periode . ').xlsx"');

        $writer->save('php://output');
        exit;
    }
}
