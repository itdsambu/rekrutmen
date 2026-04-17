<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class Statistic extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('darurat');
        $status = $this->darurat->getStatus();
        if($status === 1 && $this->session->userdata('userid') !=='ismo_adm'){
            redirect(site_url('maintenanceControl'));
        }
        
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('userid')){
            redirect('login');
        }
        
        $this->load->model('m_statistic');
    }
    
    function statRegistered(){
        // if(isset($_POST['txtTglSelect'])){
        //     $tgl = date('Y-m-d', strtotime($this->input->post('txtTglSelect')));
        //     $data['_getData']   = $this->m_statistic->countPemborongTgl($tgl);
        //     $data['_getBuln']   = $this->m_statistic->countPemborongBln($tgl);
        //     $data['_getTgl']    = $tgl;
        // }else{
        //     $tgl = date('Y-m-d');
        //     $data['_getData']   = $this->m_statistic->countPemborongTgl($tgl);
        //     $data['_getBuln']   = $this->m_statistic->countPemborongBln($tgl);
        //     $data['_getTgl']    = $tgl;
        // }
//        $data['_getData'] = $this->m_statistic->countPemborongTgl($tgl = date('Y-m-d'));
//        $data['_getBuln'] = $this->m_statistic->countPemborongBln($tgl = date('Y-m-d'));
        $tanggala   = date('Y-m-d',  strtotime($this->input->post('txtDateA')));
        $tanggalz   = date('Y-m-d',  strtotime($this->input->post('txtDateZ')));
        $tgl = date('Y-m-d');
        $data['_getData']   = $this->m_statistic->countPemborongTgl($tanggala,$tanggalz);
        $data['_getBuln']   = $this->m_statistic->countPemborongBln($tgl);
        $data['_getTgl']    = $tanggala.' s/d '.$tanggalz;
        $this->template->display('statistic/registered/index',$data);
    }
    function setPemborong(){
        if('IS_AJAX') {
            $tgl = date('Y-m-d', strtotime($this->input->post('tgl')));
            $data['_getData']   = $this->m_statistic->countPemborongTgl($tgl);
            $data['_getTgl']    = $tgl;
            $this->load->view('statistic/registered/statPemborong',$data);
        }
    }
            
    function statPosted(){
        $this->template->display('statistic/posted/index');
    }
    function setPosted(){
        
    }
            
    function statIssue(){
        $tanggal    = date('Y-m-d');
        if($this->input->post('txtPeriode')){
            $tanggal    = date('Y-m-d',  strtotime($this->input->post('txtPeriode')));
        }
        $data['_getIssue']  = $this->m_statistic->getIssue($tanggal);
        $data['_getDate']   = $tanggal;
        $this->template->display('statistic/request_issue/index',$data);
    }
    
    function reviewTenaker(){
        if('IS_AJAX') {
            $issueID    = $this->input->post('kode');
            $cekData    = $this->m_statistic->getReviewTenaker($issueID);
            $data['_getTenaker']   = $this->m_statistic->getReviewTenaker($issueID)->result();
            $this->load->view('statistic/request_issue/review',$data);
            // if($cekData->num_rows > 0):
            //     $data['_getTenaker']   = $this->m_statistic->getReviewTenaker($issueID)->result();
            //     $this->load->view('statistic/request_issue/review',$data);
            // else:
            //     $this->load->view('statistic/request_issue/review',$data);
            // endif;
        }
    }

    // New Rekap Issue Permintaan
    function rekapIssueRequest(){
        $tanggalz   = date('Y-m-t');
        $tanggala   = date('Y-m-d', strtotime($tanggalz.' -3 months'));
        if($this->input->post('txtDateA')){
            $tanggala   = date('Y-m-d',  strtotime($this->input->post('txtDateA')));
            $tanggalz   = date('Y-m-d',  strtotime($this->input->post('txtDateZ')));
        }
        $data['_getIssue']  = $this->m_statistic->getRekapIssueRequest($tanggala,$tanggalz);
        $data['_getDateA']   = $tanggala;
        $data['_getDateZ']   = $tanggalz;
        $this->template->display('statistic/rekapIssue/index',$data); 
    }

    function UpdatedIssue(){
        $dataSelect = $this->input->get('jenis');
        $this->session->set_flashdata("jenis",$dataSelect);

        redirect('Statistic/getdataissue');
    }

    function getdataissue(){
        $dataSelect = $this->session->flashdata("jenis");
        $this->session->keep_flashdata("jenis");

        $data['_getJenis']   = $dataSelect;
        $data['_selected']   = $dataSelect;

        if ($dataSelect == 'ALL PEMBORONG') {
            $data['coutn'] = $this->m_statistic->countIssuepermintaanAllPemborong();
            $data['_selectData'] = $this->m_statistic->getIssuepermintaanAllPemborong();
        }elseif ($dataSelect == 'PSG') {
            $data['coutn'] = $this->m_statistic->countIssuepermintaanPSG();
            $data['_selectData'] = $this->m_statistic->getIssuepermintaanPSG();
        }else{
            $data['coutn'] = $this->m_statistic->countIssuepermintaan();
            $data['_selectData'] = $this->m_statistic->getIssuepermintaan();
        }

        $this->template->display('statistic/updatedissue/index',$data);
    }

    function viewEditIssue(){
        if('IS_AJAX') {
            $id = $this->input->post('kode');
            $data['getissue']  = $this->m_statistic->getDetailIssue($id);
            $this->load->view('statistic/updatedissue/settingissue',$data);
        }
    }

    function updatestatusissue(){
        $id = $this->input->get('id');
        $param = array(
            'PenjelasanBelumPenuh' => $this->input->post('txtPenjelasan'),
            'Solusi'               => $this->input->post('txtSolisi'),
            'StatusPemenuhan'      => date('d-m-Y',strtotime($this->input->post('txtPemenuhan')))
        );
        $result = $this->m_statistic->updatedreqissue($id,$param);
        if (!$result) {
            redirect('statistic/getdataissue?msg=success','refresh');
        } else {
            redirect('statistic/getdataissue?msg=failed','refresh');
        }
    }

    function downloadissue(){
        $exl = $this->input->get('jenis');
        $this->session->set_flashdata("jenis",$exl);

        redirect('Statistic/getdataissueExcel');
    }

    function getdataissueExcel(){  
        $this->load->library("Excel/PHPExcel");
        
        $export = $this->input->post('selDataExport');
        $title  = 'Daftar Riwayat Hidup';
        $exl = $this->session->flashdata("jenis");
        $this->session->keep_flashdata("jenis");
        if ($exl == 'PSG') {
            $coutndata = $this->m_statistic->countIssuepermintaanAllPemborong();
            $data = $this->m_statistic->getIssuepermintaanPSG();
        } elseif ($exl == 'ALL PEMBORONG') {
            $coutndata = $this->m_statistic->countIssuepermintaanPSG();
            $data = $this->m_statistic->getIssuepermintaanAllPemborong();
        } else {
            $coutndata = $this->m_statistic->countIssuepermintaan();
            $data = $this->m_statistic->getIssuepermintaan();
        }
        // $no=0;
        // $tot_sisa = 0;
        // $tot_penuhi = 0;
        // $tot_minta = 0;
        // foreach ($data as $row) {$no++;
        //     $dtno[]       = $no;
        //     $pekerjaan[]  = $row->Pekerjaan;
        //     $divisi[]     = $row->NamaDivisi;
        //     $dept[]       = $row->DeptAbbr;
        //     $minta[]      = $row->TKPermintaan;
        //     $sisa[]       = $row->TKTarget - $row->TKSedia;
        //     $penuhi[]     = $row->TKTarget - $row->TKSedia - $row->TKPermintaan;
        //     $penjelasan[] = $row->PenjelasanBelumPenuh;
        //     $solusi[]     = $row->Solusi;
        //     $tgl[]        = $row->StatusPemenuhan;

        //     $tot_sisa += $row->TKTarget - $row->TKSedia;
        //     $tot_penuhi += $row->TKTarget - $row->TKSedia - $row->TKPermintaan;
        //     $tot_minta += $row->TKPermintaan;
        // }
        
        
        $objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(19);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(21);

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Photo');
        $objDrawing->setDescription('Photo');
        $objDrawing->setPath('assets/img/logo.png');
        $objDrawing->setHeight(65);
        $objDrawing->setCoordinates('A1'); 
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        
            
        // $objPHPExcel->getActiveSheet()->getStyle('J6')->getNumberFormat()->setFormatCode('0');
        // $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(True);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(TRUE)->setSize(15);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(TRUE)->setSize(20);
        $objPHPExcel->getActiveSheet()->getStyle('A1:R3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        // $objPHPExcel->getActiveSheet()->getStyle('A4:H5'))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        // $objPHPExcel->getActiveSheet()->getStyle('A3:S70')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A4:T7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A4:T7')->getFont()->setBold(TRUE)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('S1:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
        $objPHPExcel->getActiveSheet()->getStyle('A1:B2')->getAlignment()->applyFromArray(
        array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'rotation'   => 0,
            'wrap'       => true
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A4:T7')->getAlignment()->applyFromArray(
        array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'rotation'   => 0,
            'wrap'       => true
        ));
        $objPHPExcel->getActiveSheet()->getStyle('C1:R1')->getAlignment()->applyFromArray(
         array(
             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             'rotation'   => 0,
             'wrap'       => true
         ));
        $objPHPExcel->getActiveSheet()->getStyle('A71:B76')->getAlignment()->applyFromArray(
         array(
             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             'rotation'   => 0,
             'wrap'       => true
        ));
        
        $objPHPExcel->getActiveSheet()->getStyle("S1:T1")->applyFromArray(array(
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("S2:T2")->applyFromArray(array(
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("S3:T3")->applyFromArray(array(
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle("A4:H7")->applyFromArray(array(
            'borders' => array(
                'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle("I4:K4")->applyFromArray(array(
            'borders' => array(
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("I5:K5")->applyFromArray(array(
            'borders' => array(
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle("I6:I6")->applyFromArray(array(
            'borders' => array(
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("I7:I7")->applyFromArray(array(
            'borders' => array(
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle("J6:J6")->applyFromArray(array(
            'borders' => array(
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("J7:J7")->applyFromArray(array(
            'borders' => array(
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle("K6:K6")->applyFromArray(array(
            'borders' => array(
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("K7:K7")->applyFromArray(array(
            'borders' => array(
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle("L4:O5")->applyFromArray(array(
            'borders' => array(
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("L6:O7")->applyFromArray(array(
            'borders' => array(
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle("P4:R5")->applyFromArray(array(
            'borders' => array(
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("P6:R7")->applyFromArray(array(
            'borders' => array(
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle("S4:T5")->applyFromArray(array(
            'borders' => array(
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("S6:T7")->applyFromArray(array(
            'borders' => array(
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
                
        $objPHPExcel->getActiveSheet()->mergeCells('A1:B3');
        $objPHPExcel->getActiveSheet()->mergeCells('C1:R1');
        $objPHPExcel->getActiveSheet()->mergeCells('C2:R3');
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'PT. PULAU SAMBU');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', 'RECRUITMENT UPDATE');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', 'Section');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', ': HRD');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S2', 'Updated');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T2', ': '.date('d-m-Y'));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S3', 'Page');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T3', ': ');

        $objPHPExcel->getActiveSheet()->mergeCells('A4:A7')->setCellValue('A4', 'NO');
        $objPHPExcel->getActiveSheet()->mergeCells('B4:C7')->setCellValue('B4', 'POSITION (POSISI)');
        $objPHPExcel->getActiveSheet()->mergeCells('D4:E7')->setCellValue('D4', 'LEVEL');
        $objPHPExcel->getActiveSheet()->mergeCells('F4:G7')->setCellValue('F4', 'DIVISI');
        $objPHPExcel->getActiveSheet()->mergeCells('H4:H7')->setCellValue('H4', 'DEPT.');
        $objPHPExcel->getActiveSheet()->mergeCells('I4:K4')->setCellValue('I4', 'NUMBER PERSONNEL');
        $objPHPExcel->getActiveSheet()->mergeCells('I5:K5')->setCellValue('I5', '(JUMLAH ORANG)');
        $objPHPExcel->getActiveSheet()->mergeCells('I6:I6')->setCellValue('I6', "TOTAL NEEDED");
        $objPHPExcel->getActiveSheet()->mergeCells('I7:I7')->setCellValue('I7', "(JUMLAH KEBUTUHAN)");
        $objPHPExcel->getActiveSheet()->mergeCells('J6:J6')->setCellValue('J6', 'FULLFILLED');
        $objPHPExcel->getActiveSheet()->mergeCells('J7:J7')->setCellValue('J7', '(SUDAH TERPENUHI)');
        $objPHPExcel->getActiveSheet()->mergeCells('K6:K6')->setCellValue('K6', 'UNFILLED');
        $objPHPExcel->getActiveSheet()->mergeCells('K7:K7')->setCellValue('K7', '(BELUM TERPENUHI)');
        $objPHPExcel->getActiveSheet()->mergeCells('L4:O5')->setCellValue('L4', 'EXPLANATION FOR UNFULFILLED');
        $objPHPExcel->getActiveSheet()->mergeCells('L6:O7')->setCellValue('L6', '(PENJELASAN KENAPA BELUM TERPENUHI)');
        $objPHPExcel->getActiveSheet()->mergeCells('P4:R5')->setCellValue('P4', 'SOLUTIONS (IF APLICABLE)');
        $objPHPExcel->getActiveSheet()->mergeCells('P6:R7')->setCellValue('P6', '(SOLUSI)');
        $objPHPExcel->getActiveSheet()->mergeCells('S4:T5')->setCellValue('S4', 'DATES OF FULFILLMENT');
        $objPHPExcel->getActiveSheet()->mergeCells('S6:T7')->setCellValue('S6', '(RENCANA WAKTU PEMENUHAN)');        

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $no = 1;
        $counter = 8;
        $tot_sisa = 0;
        $tot_penuhi = 0;
        $tot_minta = 0;
        foreach ($data as $row):
            $minta  = $row->TKPermintaan;
            $sisa   = $row->TKTarget - $row->TKSedia;
            $penuhi = $row->TKTarget - $row->TKSedia - $row->TKPermintaan;

            $tot_sisa += $row->TKTarget - $row->TKSedia;
            $tot_penuhi += $row->TKTarget - $row->TKSedia - $row->TKPermintaan;
            $tot_minta += $row->TKPermintaan;

            $ex->setCellValue('A'.$counter, $no++);
            $ex->mergeCells('B'.$counter.':C'.$counter)->setCellValue('B'.$counter, $row->Pekerjaan);
            $ex->mergeCells('D'.$counter.':E'.$counter)->setCellValue('D'.$counter, '');
            $ex->mergeCells('F'.$counter.':G'.$counter)->setCellValue('F'.$counter, $row->NamaDivisi);
            $ex->setCellValue('H'.$counter, $row->DeptAbbr);
            $ex->setCellValue('I'.$counter, $sisa);
            $ex->setCellValue('J'.$counter, $penuhi);
            $ex->setCellValue('K'.$counter, $minta);
            $ex->mergeCells('L'.$counter.':O'.$counter)->setCellValue('L'.$counter, '');
            $ex->mergeCells('P'.$counter.':R'.$counter)->setCellValue('P'.$counter, '');
            $ex->mergeCells('S'.$counter.':T'.$counter)->setCellValue('S'.$counter, '');
            $counter = $counter+1;
            $objPHPExcel->getActiveSheet()->getStyle('A'.($counter-2).':T'.($counter))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        endforeach;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($counter).':H'.($counter))->setCellValue('A'.($counter), 'Total');
        $objPHPExcel->getActiveSheet()->setCellValue('I'.($counter), $tot_sisa);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.($counter), $tot_penuhi);
        $objPHPExcel->getActiveSheet()->setCellValue('K'.($counter), $tot_minta);
        $objPHPExcel->getActiveSheet()->mergeCells('L'.($counter).':T'.($counter));
        
        $objPHPExcel->getActiveSheet()->setTitle('RECRUITMENT UPDATE');
        
        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Lap_('.$exl.').xlsx"');
        
        $objWriter->save('php://output');
    }
}