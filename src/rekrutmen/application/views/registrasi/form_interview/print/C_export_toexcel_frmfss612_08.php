<?php
date_default_timezone_set('Asia/Jakarta');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//    session_start(); //Memanggil fungsi session Codeigniter
class C_export_toexcel_frmfss612_08 extends CI_Controller {

    function __construct() {
        parent::__construct();
        $frmkode = $this->uri->segment(4);
        $frmvrs = $this->uri->segment(5);
        $this->load->model(array('M_user', 'master/M_form', 'M_menu', 'form_input/M_forminput', 'form_input/M_form' . $frmkode . '_' . $frmvrs));
        $this->load->library(array('table', 'form_validation', 'excel', 'fpdf'));
        $this->load->helper('form');
    }

    function exportxls() {

        $session_data                     = $this->session->userdata('logged_in');
        $data['username']                 = $session_data['username'];
        $data['password']                 = $session_data['password'];
        $data['jabid']                    = $session_data['jabid'];
        $data['leveluserid']              = $session_data['leveluserid'];
        $data['nmdepan']                  = $session_data['nmdepan'];
        $data['levelusernm']              = $session_data['levelusernm'];
        $data['bagnm']                    = $session_data['bagnm'];
        $data['jabnm']                    = $session_data['jabnm'];
        $data['bagnm']                    = $session_data['bagnm'];
        $data['nmdepan']                  = $session_data['nmdepan'];
        $data['deptid']                   = $session_data['deptid'];
        $data['deptabbr']                 = $session_data['deptabbr'];
        $data['bagian_akses']             = $session_data['bagian_akses'];
        $data['ori_akses']                = $session_data['ori_akses'];
        $data['audit_akses']              = $session_data['audit_akses'];
        $data['mode_akses']               = $session_data['mode_akses'];
        $data['Titel']                    = 'Home';
        $btns                             = $this->M_menu->getLevelBtn($session_data['leveluserid']);
        $data['allakses_update_header']   = $btns->btn_update_header;

        $mode_akses                       = $session_data['mode_akses'];
        $LevelUser                        = $session_data['leveluserid'];
        $UserName                         = $session_data['username'];
        $LevelUserNm                      = $session_data['levelusernm'];

        $cekLevelUserNm                   = substr($LevelUserNm,0,7);
        $data['cekLevelUserNm']           = substr($LevelUserNm,0,7);
        $menus                            = $this->M_menu->menus($LevelUser);
        $data2                            = array('menus' => $menus);

        $frmkode                          = $this->uri->segment(4);
        $frmvrs                           = $this->uri->segment(5);
        $id                               = $this->uri->segment(6);
        $dtstart                          = $this->uri->segment(7);
        $dtfinish                         = $this->uri->segment(8);

        $dtfrm                            = $this->M_forminput->get_dtform($frmkode, $frmvrs);
        $data3                            = array('dtfrm' => $dtfrm);

        foreach ($dtfrm as $datafrm) {
            $frmkd                        = $datafrm->formkd;
            $frmjdl                       = $datafrm->formjudul;
            $frmnm                        = $datafrm->formnm;
            $frmversi                     = $datafrm->formversi;
            $frm_efect                    = substr($datafrm->formefective, 8, 2) . '-' . substr($datafrm->formefective, 5, 2) . '-' . substr($datafrm->formefective, 0, 4);
            $approval_frekuensi           = $datafrm->approval_frekuensi;
            $approval_parameter           = $datafrm->approval_parameter;
        }

        $frmcop                           = $this->config->item("nama_perusahaan");

        $model                            = 'M_form'.$frmkd.'_'.$frmvrs;
        $this->load->library('excel');

        $PTStyle                          = new PHPExcel_Style();
        $headerStyle                      = new PHPExcel_Style();
        $DetailheaderStyle                = new PHPExcel_Style();
        $DetailheaderStyleLeft            = new PHPExcel_Style();
        $DetailheaderStyleRight           = new PHPExcel_Style();
        $DetailheaderVerticalStyle        = new PHPExcel_Style();
        $bodyStyle                        = new PHPExcel_Style();
        $bodyStyle2                       = new PHPExcel_Style();
        $bodyStyle3                       = new PHPExcel_Style();
        $bodyStyleLeft                    = new PHPExcel_Style();
        $bodyStyleRight                   = new PHPExcel_Style();
        $cellred                          = new PHPExcel_Style();
        $headerStyleOutline               = new PHPExcel_Style();
        $headerStyleRight                 = new PHPExcel_Style();
        $headerStyleLeft                  = new PHPExcel_Style();
        $headerStyleLeft2                 = new PHPExcel_Style();
        $headerStyleLeftRight             = new PHPExcel_Style();
        $headerStyleRightTop              = new PHPExcel_Style();
        $headerStyleLeftTop               = new PHPExcel_Style();
        $headerStyleRightbottom           = new PHPExcel_Style();
        $headerStyleLeftBottom            = new PHPExcel_Style();
        $headerStyleRightBottomTop        = new PHPExcel_Style();
        $headerStyleLeftBottomTop         = new PHPExcel_Style();
        $headerStyleBottom                = new PHPExcel_Style();

        $noborderStyle                    = new PHPExcel_Style();
        $noborderStyleBold                = new PHPExcel_Style();
        $definitionborderStyle            = new PHPExcel_Style();
        $definitionborderStyleLeft        = new PHPExcel_Style();
        $rightborderStyle                 = new PHPExcel_Style();
        $DetailheaderRightTopStyle        = new PHPExcel_Style();
        $DetailheaderRightStyle           = new PHPExcel_Style();
        $DetailheaderLeftStyle            = new PHPExcel_Style();
        $DetailheaderRightBottomStyle     = new PHPExcel_Style();

        $footerStyleRightbottom           = new PHPExcel_Style();
        $footerStyleLeftbottom            = new PHPExcel_Style();

        $PTStyle->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => true,
             'name' => 'Times New Roman',
             'size' => 12
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $headerStyle->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => true,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );
        $headerStyleRight->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => true,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $headerStyleLeft->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => false,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $headerStyleLeft2->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => true,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $headerStyleLeftRight->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => false,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );


        $headerStyleRightTop->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => false,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $headerStyleLeftTop->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => false,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $headerStyleRightbottom->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => false,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $headerStyleLeftBottom->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => false,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $headerStyleRightBottomTop->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => false,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $headerStyleLeftBottomTop->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => false,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $headerStyleBottom->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => false,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $noborderStyle->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => false,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $noborderStyleBold->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => true,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $definitionborderStyle->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => false,
             'italic'  => true,
             'name' => 'Times New Roman',
             'size' => 10
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $definitionborderStyleLeft->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => false,
             'italic'  => true,
             'name' => 'Times New Roman',
             'size' => 10
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $rightborderStyle->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => false,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $DetailheaderStyle->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => true,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $DetailheaderStyleLeft->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => true,
             'name' => 'Times New Roman',
             'size' => 8
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $DetailheaderStyleRight->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => true,
             'name' => 'Times New Roman',
             'size' => 8
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $DetailheaderVerticalStyle->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => false,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_BOTTOM,
                            'wrap'       => true
                           ),
            )
        );

        $DetailheaderRightTopStyle->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => true,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );
        $DetailheaderRightBottomStyle->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => true,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );
        $DetailheaderRightStyle->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => true,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $DetailheaderLeftStyle->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => true,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $footerStyleRightbottom->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => false,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $footerStyleLeftbottom->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => false,
             'name' => 'Times New Roman',
             'size' => 9
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );

        $bodyStyle->applyFromArray(
            array('fill'   => array(
                                'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('argb' => 'FFFFFFFF')
                              ),
                   'font'   => array(
                                'name' => 'Times New Roman',
                                'size'  => 8),
                   'numberformat'   => array(
                                        'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
                   'borders' => array(
                                    'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                    'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                    'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                    'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                                ),
                   'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                    'wrap'     => true
                                  ),
            )
        );
        $bodyStyle2->applyFromArray(
            array('fill'   => array(
                                'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('argb' => 'FFFFFFFF')
                              ),
                   'font'   => array(
                                'bold' => false,
                                'name' => 'Times New Roman',
                                'size'  => 8),
                   'numberformat'   => array(
                                        'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
                   'borders' => array(
                                    'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                    'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                    'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                    'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                                ),
                   'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                    'wrap'     => true
                                  ),
            )
        );

        $bodyStyle3->applyFromArray(
            array('fill'   => array(
                                'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('argb' => 'FFFFFFFF')
                              ),
                   'font'   => array(
                                'bold' => false,
                                'name' => 'Times New Roman',
                                'size'  => 8),
                   'numberformat'   => array(
                                        'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
                   'borders' => array(
                                    'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                    'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                    'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                    'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                                ),
                   'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                    'wrap'     => true
                                  ),
            )
        );

        $bodyStyleLeft->applyFromArray(
            array('fill'   => array(
                                'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('argb' => 'FFFFFFFF')
                              ),
                   'font'   => array(
                                'name' => 'Times New Roman',
                                'size'  => 8),
                   'numberformat'   => array(
                                        'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
                   'borders' => array(
                                    'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                    'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                    'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                                ),
                   'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                    'wrap'     => true
                                  ),
            )
        );

        $bodyStyleRight->applyFromArray(
            array('fill'   => array(
                                'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('argb' => 'FFFFFFFF')
                              ),
                   'font'   => array(
                                'name' => 'Times New Roman',
                                'size'  => 8),
                   'numberformat'   => array(
                                        'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
                   'borders' => array(
                                    'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                    'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                    'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                                ),
                   'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                    'wrap'     => true
                                  ),
            )
        );

        $cellred->applyFromArray(

            array('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID,
                           'color'   => array('rgb' => 'ff0000')
                              ),
            'font'   => array(
                           'bold'    => true),
             'numberformat'   => array(
                           'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
             'borders' => array(
                            'bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'left'      => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                               ),
              'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'     => true
                                 ),


            )
        );


        function getColRange($start_letter, $row_number, $count)
        {
            $range = array();
            $rangeCol = "BZ";
            for ($y = "A", $rangeCol++; $y != $rangeCol; $y++) {
                $range[] = $y;
            }
            $start_idx = array_search(
                $start_letter,
                $range
            );

            return sprintf(
                "%s%s:%s%s",
                $start_letter,
                $row_number,
                $range[$start_idx + $count],
                $row_number
            );
        }
        $obj = new Excel();

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('assets/images/xPSG_logo_2022.png');

        $objDrawing2 = new PHPExcel_Worksheet_Drawing();
        $objDrawing2->setPath('assets/images/xPSG_logo_2022.png');

       $dtheader = $this->$model->get_header_byid($id);

        foreach($dtheader as $dtheaderrow){
           $doc           = $dtheaderrow->doc;
           $create_date   = $dtheaderrow->create_date;
           $app1_by       = $dtheaderrow->app1_by;
           $app1_position = $dtheaderrow->app1_position;
           $app1_date     = $dtheaderrow->app1_date;
           $app1_status   = $dtheaderrow->app1_status;
           $app2_by       = $dtheaderrow->app2_by;
           $app2_position = $dtheaderrow->app2_position;
           $app2_date     = $dtheaderrow->app2_date;
           $app2_status   = $dtheaderrow->app2_status;
           $app3_by       = $dtheaderrow->app3_by;
           $app3_position = $dtheaderrow->app3_position;
           $app3_date     = $dtheaderrow->app3_date;
           $app3_status   = $dtheaderrow->app3_status;
           $app4_by       = $dtheaderrow->app4_by;
           $app4_position = $dtheaderrow->app4_position;
           $app4_date     = $dtheaderrow->app4_date;
           $app4_status   = $dtheaderrow->app4_status;
           $app5_by       = $dtheaderrow->app5_by;
           $app5_position = $dtheaderrow->app5_position;
           $app5_date     = $dtheaderrow->app5_date;
           $app5_status   = $dtheaderrow->app5_status;
           $app6_by       = $dtheaderrow->app6_by;
           $app6_position = $dtheaderrow->app6_position;
           $app6_date     = $dtheaderrow->app6_date;
           $app6_status   = $dtheaderrow->app6_status;
           $app7_by       = $dtheaderrow->app7_by;
           $app7_position = $dtheaderrow->app7_position;
           $app7_date     = $dtheaderrow->app7_date;
           $app7_status   = $dtheaderrow->app7_status;
           $app8_by       = $dtheaderrow->app8_by;
           $app8_position = $dtheaderrow->app8_position;
           $app8_date     = $dtheaderrow->app8_date;
           $app8_status   = $dtheaderrow->app8_status;

          if(trim($dtheaderrow->$approval_parameter)!=''){
            $set_app_date = $dtheaderrow->$approval_parameter;
            if($approval_frekuensi=='Hari'){
              $val_app_date = date('d-m-Y', strtotime('+2 days '.$set_app_date.''));
            }elseif($approval_frekuensi=='Bulan'){
              $val_app_date =  date('d-m-Y', strtotime('+1 days '.date("d-m-Y", strtotime($set_app_date)).''));
            }elseif($approval_frekuensi=='Minggu'){
              $val_app_date = date('d-m-Y', strtotime('+2 days '.$set_app_date.''));
            }else{
              $val_app_date = date('d-m-Y', $set_app_date);
            }
          }else{
            $set_app_date = '';
            $val_app_date = '';
          }
        }

        if(trim($val_app_date)!=''){
            if($app1_status=='1'){$app1date = $val_app_date;}else{if(trim($app1_date)!=''){$app1date = substr($app1_date, 8, 2) . '-' . substr($app1_date, 5, 2) . '-' . substr($app1_date, 0, 4);}else{$app1date ='';}}
            if($app2_status=='1'){$app2date = $val_app_date;}else{if(trim($app2_date)!=''){$app2date = substr($app2_date, 8, 2) . '-' . substr($app2_date, 5, 2) . '-' . substr($app2_date, 0, 4);}else{$app2date ='';}}
            if($app3_status=='1'){$app3date = $val_app_date;}else{if(trim($app3_date)!=''){$app3date = substr($app3_date, 8, 2) . '-' . substr($app3_date, 5, 2) . '-' . substr($app3_date, 0, 4);}else{$app3date ='';}}
            if($app4_status=='1'){$app4date = $val_app_date;}else{if(trim($app4_date)!=''){$app4date = substr($app4_date, 8, 2) . '-' . substr($app4_date, 5, 2) . '-' . substr($app4_date, 0, 4);}else{$app4date ='';}}
            if($app5_status=='1'){$app5date = $val_app_date;}else{if(trim($app5_date)!=''){$app5date = substr($app5_date, 8, 2) . '-' . substr($app5_date, 5, 2) . '-' . substr($app5_date, 0, 4);}else{$app5date ='';}}
            if($app5_status=='1'){$app6date = $val_app_date;}else{if(trim($app6_date)!=''){$app6date = substr($app6_date, 8, 2) . '-' . substr($app6_date, 5, 2) . '-' . substr($app6_date, 0, 4);}else{$app6date ='';}}
            if($app5_status=='1'){$app7date = $val_app_date;}else{if(trim($app7_date)!=''){$app7date = substr($app7_date, 8, 2) . '-' . substr($app7_date, 5, 2) . '-' . substr($app7_date, 0, 4);}else{$app7date ='';}}
            if($app5_status=='1'){$app8date = $val_app_date;}else{if(trim($app8_date)!=''){$app8date = substr($app8_date, 8, 2) . '-' . substr($app8_date, 5, 2) . '-' . substr($app8_date, 0, 4);}else{$app8date ='';}}
    }

        $tgl = substr($create_date, 8, 2) . '-' . substr($create_date, 5, 2) . '-' . substr($create_date, 0, 4);


        if($session_data['mode_akses']=="mode_audit"){
            $dtdetail  = $this->M_formfrmfss612_08->get_detail_byidx($id);
            $dtdetail2 = $this->M_formfrmfss612_08->get_detail_byid_bx($id);
            $dtdetail3 = $this->M_formfrmfss612_08->get_detail_byid_dx($id);
            $dtdetail4 = $this->M_formfrmfss612_08->get_detail_byid_cx($id);
        }else{
            $dtdetail  = $this->M_formfrmfss612_08->get_detail_byid($id);
            $dtdetail2 = $this->M_formfrmfss612_08->get_detail_byid_b($id);
            $dtdetail3 = $this->M_formfrmfss612_08->get_detail_byid_d($id);
            $dtdetail4 = $this->M_formfrmfss612_08->get_detail_byid_c($id);
        }

        $ndt_item    = $this->M_formfrmfss612_08->get_all_item_cheklist_excel($create_date);
        foreach($ndt_item as $ndt_item_row){
            $arr1_item1[]  = $ndt_item_row->item1;
            $arr1_item2[]  = $ndt_item_row->item2;
        }

        if(isset($dtdetail)){
              $number1   = 0;
              $nocek     = 0;
              $val_nocek = -2;
              foreach($dtdetail as $dtdetail_row){
                if($dtdetail_row->point_control=='TIME'){
                  $nocek++;
                  $val_nocek++;
                  $arr1_valtgl_dt_line[] = $dtdetail_row->tgl_dt_line;
                  $arr1_nocek[]          = $val_nocek;
                    if($dtdetail_row->shift=='SHIFT 1'){
                        $shift1               = 'I';
                        $arr1_valtime_sf1[]   = $dtdetail_row->time;
                    }
                    if($dtdetail_row->shift=='SHIFT 2'){
                        $shift2               = 'II';
                        $arr1_valtime_sf2[]   = $dtdetail_row->time;
                    }
                    if($dtdetail_row->shift=='SHIFT 3'){
                        $shift3               = 'III';
                        $arr1_valtime_sf3[]   = $dtdetail_row->time;
                    }
                }else{
                    $number1++;
                    $arr1_number1[]         = $number1;
                    $arr1_point_control[]   = $dtdetail_row->point_control;
                    $arr1_point_control_2[] = $dtdetail_row->point_control_2;
                    $arr1_shift[]           = $dtdetail_row->shift;
                    $arr1_time[]            = $dtdetail_row->time;
                    $arr1_spec[]            = $dtdetail_row->spec;
                    $arr1_spec_min[]        = $dtdetail_row->spec_min;
                    $arr1_spec_max[]        = $dtdetail_row->spec_max;
                    $arr1_spec_satuan[]     = $dtdetail_row->spec_satuan;
                    $arr1_spec_visual[]     = $dtdetail_row->spec_visual;
                    $arr1_visual_option[]   = $dtdetail_row->visual_option;

                    if($dtdetail_row->shift=='SHIFT 1'){
                        $arr1_dtl_check_sf1[] = $dtdetail_row->dtl_check;

                        unset($ndt_spek_dtl_check_sf1);
                        unset($nautoinspek_dtl_check_sf1);
                            if(is_numeric($dtdetail_row->spec_max) && is_numeric($dtdetail_row->dtl_check) && $dtdetail_row->dtl_check > $dtdetail_row->spec_max){
                                $ndt_spek_dtl_check_sf1    = '1';
                                $nautoinspek_dtl_check_sf1 = $dtdetail_row->spec_max;
                            }elseif(is_numeric($dtdetail_row->spec_min) && is_numeric($dtdetail_row->dtl_check) && $dtdetail_row->dtl_check < $dtdetail_row->spec_min){
                                $ndt_spek_dtl_check_sf1    = '2';
                                $nautoinspek_dtl_check_sf1 = $dtdetail_row->spec_min;
                            }else{
                                $ndt_spek_dtl_check_sf1    = '0';
                                $nautoinspek_dtl_check_sf1 = $dtdetail_row->dtl_check;
                            }
                        $dt_spek_dtl_check_sf1[]    = $ndt_spek_dtl_check_sf1;
                        $autoinspek_dtl_check_sf1[] = $nautoinspek_dtl_check_sf1;
                    }

                    if($dtdetail_row->shift=='SHIFT 2'){
                        $arr1_dtl_check_sf2[] = $dtdetail_row->dtl_check;

                        unset($ndt_spek_dtl_check_sf2);
                        unset($nautoinspek_dtl_check_sf2);
                            if(is_numeric($dtdetail_row->spec_max) && is_numeric($dtdetail_row->dtl_check) && $dtdetail_row->dtl_check > $dtdetail_row->spec_max){
                                $ndt_spek_dtl_check_sf2    = '1';
                                $nautoinspek_dtl_check_sf2 = $dtdetail_row->spec_max;
                            }elseif(is_numeric($dtdetail_row->spec_min) && is_numeric($dtdetail_row->dtl_check) && $dtdetail_row->dtl_check < $dtdetail_row->spec_min){
                                $ndt_spek_dtl_check_sf2    = '2';
                                $nautoinspek_dtl_check_sf2 = $dtdetail_row->spec_min;
                            }else{
                                $ndt_spek_dtl_check_sf2    = '0';
                                $nautoinspek_dtl_check_sf2 = $dtdetail_row->dtl_check;
                            }
                        $dt_spek_dtl_check_sf2[]    = $ndt_spek_dtl_check_sf2;
                        $autoinspek_dtl_check_sf2[] = $nautoinspek_dtl_check_sf2;
                    }

                    if($dtdetail_row->shift=='SHIFT 3'){
                        $arr1_dtl_check_sf3[] = $dtdetail_row->dtl_check;

                        unset($ndt_spek_dtl_check_sf3);
                        unset($nautoinspek_dtl_check_sf3);
                            if(is_numeric($dtdetail_row->spec_max) && is_numeric($dtdetail_row->dtl_check) && $dtdetail_row->dtl_check > $dtdetail_row->spec_max){
                                $ndt_spek_dtl_check_sf3    = '1';
                                $nautoinspek_dtl_check_sf3 = $dtdetail_row->spec_max;
                            }elseif(is_numeric($dtdetail_row->spec_min) && is_numeric($dtdetail_row->dtl_check) && $dtdetail_row->dtl_check < $dtdetail_row->spec_min){
                                $ndt_spek_dtl_check_sf3    = '2';
                                $nautoinspek_dtl_check_sf3 = $dtdetail_row->spec_min;
                            }else{
                                $ndt_spek_dtl_check_sf3    = '0';
                                $nautoinspek_dtl_check_sf3 = $dtdetail_row->dtl_check;
                            }
                        $dt_spek_dtl_check_sf3[]    = $ndt_spek_dtl_check_sf3;
                        $autoinspek_dtl_check_sf3[] = $nautoinspek_dtl_check_sf3;
                    }
                }
              }
              $jml_arr         = count($arr1_point_control);
              $jml_header      = $nocek;
              $jml_data_percol = $jml_arr/$nocek;
        }else{
              $ndt_item    = $this->M_formfrmfss612_08->get_all_item_cheklist_excel($create_date);

              foreach($ndt_item as $ndt_item_row){
                $arr1_point_control[]   = $ndt_item_row->item1;
                $arr1_point_control_2[] = $ndt_item_row->item2;
                if((trim($ndt_item_row->item_spec_min)!='') && (trim($ndt_item_row->item_spec_max)!='')){
                    $arr1_spec[] = trim($ndt_item_row->item_spec_min).' - '.trim($ndt_item_row->item_spec_max).' '.trim($ndt_item_row->item_spec_satuan);
                }else if((trim($ndt_item_row->item_spec_min)!='') && (trim($ndt_item_row->item_spec_max)=='')){
                    $arr1_spec[] = 'Min '.trim($ndt_item_row->item_spec_min).' '.trim($ndt_item_row->item_spec_satuan);
                }else if((trim($ndt_item_row->item_spec_min)=='') && (trim($ndt_item_row->item_spec_max)!='')){
                    $arr1_spec[] = 'Max '.trim($ndt_item_row->item_spec_max).' '.trim($ndt_item_row->item_spec_satuan);
                }else{
                    $arr1_spec[] = trim($ndt_item_row->item_spec_visual);
                }
              }

              $nocek                = 0;
              $arr1_valtime_sf1[]   = '';
              $arr1_valtime_sf2[]   = '';
              $arr1_valtime_sf3[]   = '';
              $arr1_nocek[]         = '';
              $arr1_number1[]       = '';
              $arr1_shift[]         = '';
              $arr1_time[]          = '';
              $arr1_spec[]          = '';
              $arr1_spec_min[]      = '';
              $arr1_spec_max[]      = '';
              $arr1_spec_satuan[]   = '';
              $arr1_spec_visual[]   = '';
              $arr1_visual_option[] = '';
              $arr1_jml_row[]       = '';
              $arr1_rownum[]        = '';
              $jml_header           = 1;
              $jml_data_percol      = count($arr1_point_control)+1;
        }


        if(isset($dtdetail2)){
              $number2 = 0;
              foreach($dtdetail2 as $dtdetail2_row){ $number2++;
                $arr2_number2[]         = $number2;
                $arr2_shift_b[]         = $dtdetail2_row->shift_b;
                $arr2_time_b[]          = $dtdetail2_row->time_b;
                $arr2_non_conformance[] = $dtdetail2_row->non_conformance;
                $arr2_action[]          = $dtdetail2_row->action;
                $arr2_action_by[]       = $dtdetail2_row->action_by;
              }
        }else{
                $arr2_number2[]         = '';
                $arr2_shift_b[]         = '';
                $arr2_time_b[]          = '';
                $arr2_non_conformance[] = '';
                $arr2_action[]          = '';
                $arr2_action_by[]       = '';
        }

        if(isset($dtdetail3)){
              $number3 = 0;
              foreach($dtdetail3 as $dtdetail3_row){ $number3++;
                $arr3_number3[]          = $number3;
                $arr3_dtl_d_kolom[]      = $dtdetail3_row->dtl_d_kolom;
                $arr3_dtl_d_check[]      = $dtdetail3_row->dtl_d_check;
                $arr3_dtl_d_keterangan[] = $dtdetail3_row->dtl_d_keterangan;
              }
        }else{
                $arr3_number3[]          = '';
                $arr3_dtl_d_kolom[]      = '';
                $arr3_dtl_d_check[]      = '';
                $arr3_dtl_d_keterangan[] = '';
        }

        if(isset($dtdetail4)){
              $number4 = 0;
              foreach($dtdetail4 as $dtdetail4_row){ $number4++;
                $arr4_number4[]  = $number4;
                $arr4_shift_c[]  = $dtdetail4_row->shift_c;
                $arr4_tt_start[] = $dtdetail4_row->tt_start;
                $arr4_tt_stop[]  = $dtdetail4_row->tt_stop;
                $arr4_fe_start[] = $dtdetail4_row->fe_start;
                $arr4_fe_stop[]  = $dtdetail4_row->fe_stop;
                $arr4_dd_start[] = $dtdetail4_row->dd_start;
                $arr4_dd_stop[]  = $dtdetail4_row->dd_stop;
              }
        }else{
                $arr4_number3[]  = '';
                $arr4_shift_c[]  = '';
                $arr4_tt_start[] = '';
                $arr4_tt_stop[]  = '';
                $arr4_fe_start[] = '';
                $arr4_fe_stop[]  = '';
                $arr4_dd_start[] = '';
                $arr4_dd_stop[]  = '';
        }

        $count1 = count($arr1_point_control);
        $jml_data_perpage = $jml_data_percol*24;
        if($count1<$jml_data_perpage){
            $jml_page1 = 1;
        }else{
            if(($count1 % $jml_data_perpage)==0){ $jml_page1 = $count1/$jml_data_perpage;}
            else{
                $jml_page1 = floor(($count1/$jml_data_perpage))+1;
                }
        }

        $count2 = count($dtdetail2);
        $jml_data_perpage2 = 8;
        if($count2<$jml_data_perpage2){
            $jml_page2 = 1;
        }else{
            if(($count2 % $jml_data_perpage2)==0){ $jml_page2 = $count2/$jml_data_perpage2;}
            else{
                $jml_page2 = floor(($count2/$jml_data_perpage2))+1;
                }
        }

        $count4 = count($dtdetail3);
        $jml_data_perpage4 = 8;
        if($count4<$jml_data_perpage4){
            $jml_page4 = 1;
        }else{
            if(($count4 % $jml_data_perpage4)==0){ $jml_page4 = $count4/$jml_data_perpage4;}
            else{
                $jml_page4 = floor(($count4/$jml_data_perpage4))+1;
                }
        }

        $count3 = count($arr1_valtime_sf1);
        $jml_data_perpage3 = 24;
        if($count3<$jml_data_perpage3){
            $jml_page3 = 1;
        }else{
            if(($count3 % $jml_data_perpage3)==0){$jml_page3 = $count3/$jml_data_perpage3;}
            else{
                $jml_page3 = floor(($count3/$jml_data_perpage3))+1;
            }
        }

        $jml_page = max($jml_page1,$jml_page2);

        $jml_row_perpage = 59;

        $objPHPExcel = $obj->createSheet(0);

        $objPHPExcel->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getPageSetup()->setFitToHeight(0);
        //$objPHPExcel->setTitle("Cream Report");

        $range = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

        foreach ($range as $columnID) {
            $objPHPExcel->getRowDimension($columnID)->setRowHeight(17);
            $objPHPExcel->getColumnDimension($columnID)->setWidth(8);
        }
            $objPHPExcel->getRowDimension('A')->setRowHeight(17);
            $objPHPExcel->getColumnDimension('A')->setWidth(2);
            $objPHPExcel->getColumnDimension('AG')->setWidth(2);
            $objPHPExcel->getRowDimension('B')->setRowHeight(17);
            $objPHPExcel->getColumnDimension('B')->setWidth(6);
            $objPHPExcel->getRowDimension('H')->setRowHeight(17);
            $objPHPExcel->getColumnDimension('H')->setWidth(9);
            // $objPHPExcel->getRowDimension('I')->setRowHeight(17);
            // $objPHPExcel->getColumnDimension('I')->setWidth(6);
            $objPHPExcel->getColumnDimension('AZ')->setWidth(2);
            $objPHPExcel->getColumnDimension('C')->setWidth(4);
            $objPHPExcel->getColumnDimension('D')->setWidth(11);
            $objPHPExcel->getColumnDimension('E')->setWidth(18);
            // $objPHPExcel->getColumnDimension('AE')->setWidth(0);

        for($i1=0;$i1<$jml_page;$i1++){

            $start_row      = ($i1*$jml_row_perpage)+1;
            $finish_row     = ((($i1*$jml_row_perpage)+1)+($jml_row_perpage));

            $start_detail   = ($i1*$jml_data_perpage);
            $finish_detail  = (($i1*$jml_data_perpage)+($jml_data_perpage-1));

            $start_detail2  = ($i1*$jml_data_perpage2);
            $finish_detail2 = (($i1*$jml_data_perpage2)+($jml_data_perpage2-1));

            $start_detail3  = ($i1*$jml_data_perpage3);
            $finish_detail3 = (($i1*$jml_data_perpage3)+($jml_data_perpage3-1));

            $start_detail4  = ($i1*$jml_data_perpage4);
            $finish_detail4 = (($i1*$jml_data_perpage4)+($jml_data_perpage4-1));

            $gbr = '$objDrawing'.$i1;

            $gbr = new PHPExcel_Worksheet_Drawing();
            $gbr->setPath('assets/images/xPSG_logo_2022.png');
            $gbr->setWorksheet($objPHPExcel);
            $gbr->setCoordinates('B'.$start_row);


            $objPHPExcel->mergeCells('A' . $start_row . ':C' . ($start_row + 1));
            $objPHPExcel->mergeCells('D' . $start_row . ':AC' . ($start_row + 1))->setCellValue('D' . $start_row, $frmcop);
            $objPHPExcel->mergeCells('AD' . $start_row . ':AD' . $start_row)->setCellValue('AD' . $start_row, 'DOC');
            $objPHPExcel->mergeCells('AE' . $start_row . ':AG' . $start_row)->setCellValue('AE' . $start_row, ': ' . $doc);

            $objPHPExcel->mergeCells('AD' . ($start_row + 1) . ':AD' . ($start_row + 1))->setCellValue('AD' . ($start_row + 1), 'DATE');
            $objPHPExcel->mergeCells('AE' . ($start_row + 1) . ':AG' . ($start_row + 1))->setCellValue('AE' . ($start_row + 1), ': ' . $tgl);

            $objPHPExcel->mergeCells('A' . ($start_row + 2) . ':C' . ($start_row + 2))->setCellValue('A' . ($start_row + 2), 'TITLE');
            $objPHPExcel->mergeCells('D' . ($start_row + 2) . ':AC' . ($start_row + 2))->setCellValue('D' . ($start_row + 2), $frmjdl);
            $objPHPExcel->mergeCells('AD' . ($start_row + 2) . ':AD' . ($start_row + 2))->setCellValue('AD' . ($start_row + 2), 'PAGE');
            $objPHPExcel->mergeCells('AE' . ($start_row + 2) . ':AG' . ($start_row + 2))->setCellValue('AE' . ($start_row + 2), ': ' . ($i1 + 1) . ' of ' . $jml_page);

            $objPHPExcel->setSharedStyle($headerStyle, 'A' . $start_row . ':C' . ($start_row + 2));
            $objPHPExcel->setSharedStyle($PTStyle, 'D' . $start_row . ':AC' . ($start_row + 1));
            $objPHPExcel->setSharedStyle($headerStyleLeft2, 'D' . ($start_row + 2) . ':AC' . ($start_row + 2));

            $objPHPExcel->setSharedStyle($headerStyleLeftTop, 'AD' . $start_row . ':AD' . $start_row);
            $objPHPExcel->setSharedStyle($headerStyleLeftBottomTop, 'AD' . ($start_row + 1) . ':AD' . ($start_row + 2));
            $objPHPExcel->setSharedStyle($headerStyleRightTop, 'AE' . $start_row . ':AG' . $start_row);
            $objPHPExcel->setSharedStyle($headerStyleRightBottomTop, 'AE' . ($start_row + 1) . ':AG' . ($start_row + 1));
            $objPHPExcel->setSharedStyle($headerStyleRightbottom, 'AE' . ($start_row + 2) . ':AG' . ($start_row + 2));

            $objPHPExcel->setSharedStyle($headerStyleLeft, 'A' . ($start_row + 3) . ':A' . ($start_row + 3));
            $objPHPExcel->setSharedStyle($noborderStyle, 'A' . ($start_row + 3) . ':AG' . ($start_row + 3));
            $objPHPExcel->setSharedStyle($headerStyleRight, 'AG' . ($start_row + 3) . ':AG' . ($start_row + 3));

            $objPHPExcel->mergeCells('B' . ($start_row + 3) . ':AF' . ($start_row + 3))->setCellValue('B' . ($start_row + 3), "");

            $row_no_b = $start_row + 3;

            $objPHPExcel->mergeCells('B' . ($row_no_b + 1) . ':C' . (($row_no_b + 2)))->setCellValue('B' . ($row_no_b + 1), "No.");
            $objPHPExcel->mergeCells('D' . ($row_no_b + 1) . ':F' . (($row_no_b + 2)))->setCellValue('D' . ($row_no_b + 1), "Shift");
            $objPHPExcel->mergeCells('G' . ($row_no_b + 1) . ':L' . (($row_no_b + 1)))->setCellValue('G' . ($row_no_b + 1), "T/T");
            $objPHPExcel->mergeCells('G' . ($row_no_b + 2) . ':I' . (($row_no_b + 2)))->setCellValue('G' . ($row_no_b + 2), "Start");
            $objPHPExcel->mergeCells('J' . ($row_no_b + 2) . ':L' . (($row_no_b + 2)))->setCellValue('J' . ($row_no_b + 2), "Stop");
            $objPHPExcel->mergeCells('M' . ($row_no_b + 1) . ':R' . (($row_no_b + 1)))->setCellValue('M' . ($row_no_b + 1), "FE");
            $objPHPExcel->mergeCells('M' . ($row_no_b + 2) . ':O' . (($row_no_b + 2)))->setCellValue('M' . ($row_no_b + 2), "Start");
            $objPHPExcel->mergeCells('P' . ($row_no_b + 2) . ':R' . (($row_no_b + 2)))->setCellValue('P' . ($row_no_b + 2), "Stop");
            $objPHPExcel->mergeCells('S' . ($row_no_b + 1) . ':X' . (($row_no_b + 1)))->setCellValue('S' . ($row_no_b + 1), "DD");
            $objPHPExcel->mergeCells('S' . ($row_no_b + 2) . ':U' . (($row_no_b + 2)))->setCellValue('S' . ($row_no_b + 2), "Start");
            $objPHPExcel->mergeCells('V' . ($row_no_b + 2) . ':X' . (($row_no_b + 2)))->setCellValue('V' . ($row_no_b + 2), "Stop");

            $objPHPExcel->setSharedStyle($headerStyleLeft, 'A' . ($row_no_b + 1) . ':A' . ($row_no_b + 2));
            $objPHPExcel->setSharedStyle($DetailheaderStyle, 'B' . ($row_no_b + 1) . ':X' . ($row_no_b + 2));
            $objPHPExcel->setSharedStyle($noborderStyle, 'Y' . ($row_no_b + 1) . ':AF' . ($row_no_b + 2));
            $objPHPExcel->setSharedStyle($headerStyleRight, 'AG' . ($row_no_b + 1) . ':AG' . ($row_no_b + 2));

            $row_dtl_b = $row_no_b + 2;
            for ($arr4 = $start_detail4; $arr4 <= $finish_detail4; $arr4++) {
                $row_dtl_b++;

                if (isset($arr4_number4[$arr4])) {
                    $dt3_number3[$arr4] = $arr4_number4[$arr4];
                } else {
                    $dt3_number3[$arr4] = '';
                }
                if (isset($arr4_shift_c[$arr4])) {
                    if (trim($arr4_shift_c[$arr4]        != '')) {
                        $dt3_shift_c[$arr4] = $arr4_shift_c[$arr4];
                    } else {
                        $dt3_shift_c[$arr4] = '-';
                    }
                } else {
                    $dt3_shift_c[$arr4] = '';
                }
                if (isset($arr4_tt_start[$arr4])) {
                    if (trim($arr4_tt_start[$arr4]        != '')) {
                        $dt3_tt_start[$arr4] = $arr4_tt_start[$arr4];
                    } else {
                        $dt3_tt_start[$arr4] = '-';
                    }
                } else {
                    $dt3_tt_start[$arr4] = '';
                }
                if (isset($arr4_tt_stop[$arr4])) {
                    if (trim($arr4_tt_stop[$arr4]        != '')) {
                        $dt3_tt_stop[$arr4] = $arr4_tt_stop[$arr4];
                    } else {
                        $dt3_tt_stop[$arr4] = '-';
                    }
                } else {
                    $dt3_tt_stop[$arr4] = '';
                }
                if (isset($arr4_fe_start[$arr4])) {
                    if (trim($arr4_fe_start[$arr4]        != '')) {
                        $dt3_fe_start[$arr4] = $arr4_fe_start[$arr4];
                    } else {
                        $dt3_fe_start[$arr4] = '-';
                    }
                } else {
                    $dt3_fe_start[$arr4] = '';
                }
                if (isset($arr4_fe_stop[$arr4])) {
                    if (trim($arr4_fe_stop[$arr4]        != '')) {
                        $dt3_fe_stop[$arr4] = $arr4_fe_stop[$arr4];
                    } else {
                        $dt3_fe_stop[$arr4] = '-';
                    }
                } else {
                    $dt3_fe_stop[$arr4] = '';
                }
                if (isset($arr4_dd_start[$arr4])) {
                    if (trim($arr4_dd_start[$arr4]        != '')) {
                        $dt3_dd_start[$arr4] = $arr4_dd_start[$arr4];
                    } else {
                        $dt3_dd_start[$arr4] = '-';
                    }
                } else {
                    $dt3_dd_start[$arr4] = '';
                }
                if (isset($arr4_dd_stop[$arr4])) {
                    if (trim($arr4_dd_stop[$arr4]        != '')) {
                        $dt3_dd_stop[$arr4] = $arr4_dd_stop[$arr4];
                    } else {
                        $dt3_dd_stop[$arr4] = '-';
                    }
                } else {
                    $dt3_dd_stop[$arr4] = '';
                }

                $objPHPExcel->setSharedStyle($headerStyleLeft, 'A' . $row_dtl_b . ':A' . $row_dtl_b);
                $objPHPExcel->setSharedStyle($bodyStyle, 'B' . $row_dtl_b . ':X' . $row_dtl_b);
                $objPHPExcel->setSharedStyle($noborderStyle, 'Y' . $row_dtl_b . ':AF' . $row_dtl_b);
                $objPHPExcel->setSharedStyle($headerStyleRight, 'AG' . $row_dtl_b . ':AG' . $row_dtl_b);

                $objPHPExcel->mergeCells('B' . $row_dtl_b . ':C' . ($row_dtl_b))->setCellValue('B' . $row_dtl_b, $dt3_number3[$arr4]);
                $objPHPExcel->mergeCells('D' . $row_dtl_b . ':F' . ($row_dtl_b))->setCellValue('D' . $row_dtl_b, $dt3_shift_c[$arr4]);
                $objPHPExcel->mergeCells('G' . $row_dtl_b . ':I' . ($row_dtl_b))->setCellValue('G' . $row_dtl_b, $dt3_tt_start[$arr4]);
                $objPHPExcel->mergeCells('J' . $row_dtl_b . ':L' . ($row_dtl_b))->setCellValue('J' . $row_dtl_b, $dt3_tt_stop[$arr4]);
                $objPHPExcel->mergeCells('M' . $row_dtl_b . ':O' . ($row_dtl_b))->setCellValue('M' . $row_dtl_b, $dt3_fe_start[$arr4]);
                $objPHPExcel->mergeCells('P' . $row_dtl_b . ':R' . ($row_dtl_b))->setCellValue('P' . $row_dtl_b, $dt3_fe_stop[$arr4]);
                $objPHPExcel->mergeCells('S' . $row_dtl_b . ':U' . ($row_dtl_b))->setCellValue('S' . $row_dtl_b, $dt3_dd_start[$arr4]);
                $objPHPExcel->mergeCells('V' . $row_dtl_b . ':X' . ($row_dtl_b))->setCellValue('V' . $row_dtl_b, $dt3_dd_stop[$arr4]);
            }

            $row_no_a = $row_dtl_b + 1;

            $objPHPExcel->setSharedStyle($headerStyleLeft, 'A' . $row_no_a . ':A' . $row_no_a);
            $objPHPExcel->setSharedStyle($noborderStyle, 'B' . $row_no_a . ':AF' . $row_no_a);
            $objPHPExcel->setSharedStyle($headerStyleRight, 'AG' . $row_no_a . ':AG' . $row_no_a);

            $objPHPExcel->mergeCells('A' . ($row_no_a + 1) . ':A' . ($row_no_a + 3))->setCellValue('A' . ($row_no_a + 1), "");
            $objPHPExcel->mergeCells('B' . ($row_no_a + 1) . ':B' . ($row_no_a + 3))->setCellValue('B' . ($row_no_a + 1), "No.");
            $objPHPExcel->mergeCells('C' . ($row_no_a + 1) . ':H' . ($row_no_a + 3))->setCellValue('C' . ($row_no_a + 1), "POINT OF CONTROL");

            $objPHPExcel->mergeCells('I' . ($row_no_a + 1) . ':AF' . ($row_no_a + 1))->setCellValue('I' . ($row_no_a + 1), "TIME");

            $objPHPExcel->mergeCells('I' . ($row_no_a + 2) . ':P' . ($row_no_a + 2))->setCellValue('I' . ($row_no_a + 2), '1 st Shift ' . $shift1);
            $objPHPExcel->mergeCells('Q' . ($row_no_a + 2) . ':X' . ($row_no_a + 2))->setCellValue('Q' . ($row_no_a + 2), '2 st Shift ' . $shift2);
            $objPHPExcel->mergeCells('Y' . ($row_no_a + 2) . ':AF' . ($row_no_a + 2))->setCellValue('Y' . ($row_no_a + 2), '3 st Shift ' . $shift3);

            for ($arr3 = $start_detail3; $arr3 <= $finish_detail3; $arr3++) {
                if (isset($arr1_valtime_sf1[$arr3])) {
                    if (trim($arr1_valtime_sf1[$arr3] != '')) {
                        $dt4_valtime_sf1[$arr3] = $arr1_valtime_sf1[$arr3];
                    } else {
                        $dt4_valtime_sf1[$arr3] = '-';
                    }
                } else {
                    $dt4_valtime_sf1[$arr3] = '';
                }
                if (isset($arr1_valtime_sf2[$arr3])) {
                    if (trim($arr1_valtime_sf2[$arr3] != '')) {
                        $dt4_valtime_sf2[$arr3] = $arr1_valtime_sf2[$arr3];
                    } else {
                        $dt4_valtime_sf2[$arr3] = '-';
                    }
                } else {
                    $dt4_valtime_sf2[$arr3] = '';
                }
                if (isset($arr1_valtime_sf3[$arr3])) {
                    if (trim($arr1_valtime_sf3[$arr3] != '')) {
                        $dt4_valtime_sf3[$arr3] = $arr1_valtime_sf3[$arr3];
                    } else {
                        $dt4_valtime_sf3[$arr3] = '-';
                    }
                } else {
                    $dt4_valtime_sf3[$arr3] = '';
                }
            }

            $objPHPExcel->mergeCells('I' . ($row_no_a + 3) . ':I' . ($row_no_a + 3))->setCellValue('I' . ($row_no_a + 3), $dt4_valtime_sf1[$start_detail3]);
            $objPHPExcel->mergeCells('J' . ($row_no_a + 3) . ':J' . ($row_no_a + 3))->setCellValue('J' . ($row_no_a + 3), $dt4_valtime_sf1[$start_detail3 + 1]);
            $objPHPExcel->mergeCells('K' . ($row_no_a + 3) . ':K' . ($row_no_a + 3))->setCellValue('K' . ($row_no_a + 3), $dt4_valtime_sf1[$start_detail3 + 2]);
            $objPHPExcel->mergeCells('L' . ($row_no_a + 3) . ':L' . ($row_no_a + 3))->setCellValue('L' . ($row_no_a + 3), $dt4_valtime_sf1[$start_detail3 + 3]);
            $objPHPExcel->mergeCells('M' . ($row_no_a + 3) . ':M' . ($row_no_a + 3))->setCellValue('M' . ($row_no_a + 3), $dt4_valtime_sf1[$start_detail3 + 4]);
            $objPHPExcel->mergeCells('N' . ($row_no_a + 3) . ':N' . ($row_no_a + 3))->setCellValue('N' . ($row_no_a + 3), $dt4_valtime_sf1[$start_detail3 + 5]);
            $objPHPExcel->mergeCells('O' . ($row_no_a + 3) . ':O' . ($row_no_a + 3))->setCellValue('O' . ($row_no_a + 3), $dt4_valtime_sf1[$start_detail3 + 6]);
            $objPHPExcel->mergeCells('P' . ($row_no_a + 3) . ':P' . ($row_no_a + 3))->setCellValue('P' . ($row_no_a + 3), $dt4_valtime_sf1[$start_detail3 + 7]);

            $objPHPExcel->mergeCells('Q' . ($row_no_a + 3) . ':Q' . ($row_no_a + 3))->setCellValue('Q' . ($row_no_a + 3), $dt4_valtime_sf2[$start_detail3 + 0]);
            $objPHPExcel->mergeCells('R' . ($row_no_a + 3) . ':R' . ($row_no_a + 3))->setCellValue('R' . ($row_no_a + 3), $dt4_valtime_sf2[$start_detail3 + 1]);
            $objPHPExcel->mergeCells('S' . ($row_no_a + 3) . ':S' . ($row_no_a + 3))->setCellValue('S' . ($row_no_a + 3), $dt4_valtime_sf2[$start_detail3 + 2]);
            $objPHPExcel->mergeCells('T' . ($row_no_a + 3) . ':T' . ($row_no_a + 3))->setCellValue('T' . ($row_no_a + 3), $dt4_valtime_sf2[$start_detail3 + 3]);
            $objPHPExcel->mergeCells('U' . ($row_no_a + 3) . ':U' . ($row_no_a + 3))->setCellValue('U' . ($row_no_a + 3), $dt4_valtime_sf2[$start_detail3 + 4]);
            $objPHPExcel->mergeCells('V' . ($row_no_a + 3) . ':V' . ($row_no_a + 3))->setCellValue('V' . ($row_no_a + 3), $dt4_valtime_sf2[$start_detail3 + 5]);
            $objPHPExcel->mergeCells('W' . ($row_no_a + 3) . ':W' . ($row_no_a + 3))->setCellValue('W' . ($row_no_a + 3), $dt4_valtime_sf2[$start_detail3 + 6]);
            $objPHPExcel->mergeCells('X' . ($row_no_a + 3) . ':X' . ($row_no_a + 3))->setCellValue('X' . ($row_no_a + 3), $dt4_valtime_sf2[$start_detail3 + 7]);

            $objPHPExcel->mergeCells('Y' . ($row_no_a + 3) . ':Y' . ($row_no_a + 3))->setCellValue('Y' . ($row_no_a + 3), $dt4_valtime_sf3[$start_detail3 + 0]);
            $objPHPExcel->mergeCells('Z' . ($row_no_a + 3) . ':Z' . ($row_no_a + 3))->setCellValue('Z' . ($row_no_a + 3), $dt4_valtime_sf3[$start_detail3 + 1]);
            $objPHPExcel->mergeCells('AA' . ($row_no_a + 3) . ':AA' . ($row_no_a + 3))->setCellValue('AA' . ($row_no_a + 3), $dt4_valtime_sf3[$start_detail3 + 2]);
            $objPHPExcel->mergeCells('AB' . ($row_no_a + 3) . ':AB' . ($row_no_a + 3))->setCellValue('AB' . ($row_no_a + 3), $dt4_valtime_sf3[$start_detail3 + 3]);
            $objPHPExcel->mergeCells('AC' . ($row_no_a + 3) . ':AC' . ($row_no_a + 3))->setCellValue('AC' . ($row_no_a + 3), $dt4_valtime_sf3[$start_detail3 + 4]);
            $objPHPExcel->mergeCells('AD' . ($row_no_a + 3) . ':AD' . ($row_no_a + 3))->setCellValue('AD' . ($row_no_a + 3), $dt4_valtime_sf3[$start_detail3 + 5]);
            $objPHPExcel->mergeCells('AE' . ($row_no_a + 3) . ':AE' . ($row_no_a + 3))->setCellValue('AE' . ($row_no_a + 3), $dt4_valtime_sf3[$start_detail3 + 6]);
            $objPHPExcel->mergeCells('AF' . ($row_no_a + 3) . ':AF' . ($row_no_a + 3))->setCellValue('AF' . ($row_no_a + 3), $dt4_valtime_sf3[$start_detail3 + 7]);

            // $objPHPExcel->setSharedStyle($noborderStyle, 'A'.($row_no_a+2).':AG'.($row_no_a+28));
            $objPHPExcel->setSharedStyle($headerStyleLeft, 'A' . ($row_no_a + 1) . ':A' . ($row_no_a + 3));
            $objPHPExcel->setSharedStyle($DetailheaderStyle, 'B' . ($row_no_a + 1) . ':AF' . ($row_no_a + 3));
            $objPHPExcel->setSharedStyle($headerStyleRight, 'AG' . ($row_no_a + 1) . ':AG' . ($row_no_a + 3));

            $row_no4 = $row_no_a + 3;

            $jml_col_sf1 = ['I', 'J', 'K', 'L', 'M', 'N', 'O', 'P'];
            $jml_col_sf2 = ['Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X'];
            $jml_col_sf3 = ['Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF'];

            for ($arr1 = $start_detail; $arr1 <= $finish_detail; $arr1++) {

                if (isset($arr1_number1[$arr1])) {
                    $dt1_number1[$arr1]                            = $arr1_number1[$arr1];
                } else {
                    $dt1_number1[$arr1] = '';
                }
                if (isset($arr1_point_control[$arr1])) {
                    if (trim($arr1_point_control[$arr1]      != '')) {
                        $dt1_point_control[$arr1] = $arr1_point_control[$arr1];
                    } else {
                        $dt1_point_control[$arr1] = '-';
                    }
                } else {
                    $dt1_point_control[$arr1] = '';
                }
                if (isset($arr1_point_control_2[$arr1])) {
                    if (trim($arr1_point_control_2[$arr1]  != '')) {
                        $dt1_point_control_2[$arr1] = $arr1_point_control_2[$arr1];
                    } else {
                        $dt1_point_control_2[$arr1] = '-';
                    }
                } else {
                    $dt1_point_control_2[$arr1] = '';
                }
                if (isset($arr1_shift[$arr1])) {
                    if (trim($arr1_shift[$arr1]                      != '')) {
                        $dt1_shift[$arr1] = $arr1_shift[$arr1];
                    } else {
                        $dt1_shift[$arr1] = '-';
                    }
                } else {
                    $dt1_shift[$arr1] = '';
                }
                if (isset($arr1_time[$arr1])) {
                    if (trim($arr1_time[$arr1]                        != '')) {
                        $dt1_time[$arr1] = $arr1_time[$arr1];
                    } else {
                        $dt1_time[$arr1] = '-';
                    }
                } else {
                    $dt1_time[$arr1] = '';
                }
                if (isset($arr1_spec[$arr1])) {
                    if (trim($arr1_spec[$arr1]                        != '')) {
                        $dt1_spec[$arr1] = $arr1_spec[$arr1];
                    } else {
                        $dt1_spec[$arr1] = '-';
                    }
                } else {
                    $dt1_spec[$arr1] = '';
                }
                if (isset($arr1_spec_min[$arr1])) {
                    if (trim($arr1_spec_min[$arr1]                != '')) {
                        $dt1_spec_min[$arr1] = $arr1_spec_min[$arr1];
                    } else {
                        $dt1_spec_min[$arr1] = '-';
                    }
                } else {
                    $dt1_spec_min[$arr1] = '';
                }
                if (isset($arr1_spec_max[$arr1])) {
                    if (trim($arr1_spec_max[$arr1]                != '')) {
                        $dt1_spec_max[$arr1] = $arr1_spec_max[$arr1];
                    } else {
                        $dt1_spec_max[$arr1] = '-';
                    }
                } else {
                    $dt1_spec_max[$arr1] = '';
                }
                if (isset($arr1_spec_satuan[$arr1])) {
                    if (trim($arr1_spec_satuan[$arr1]          != '')) {
                        $dt1_spec_satuan[$arr1] = $arr1_spec_satuan[$arr1];
                    } else {
                        $dt1_spec_satuan[$arr1] = '-';
                    }
                } else {
                    $dt1_spec_satuan[$arr1] = '';
                }
                if (isset($arr1_spec_visual[$arr1])) {
                    if (trim($arr1_spec_visual[$arr1]          != '')) {
                        $dt1_spec_visual[$arr1] = $arr1_spec_visual[$arr1];
                    } else {
                        $dt1_spec_visual[$arr1] = '-';
                    }
                } else {
                    $dt1_spec_visual[$arr1] = '';
                }
                if (isset($arr1_visual_option[$arr1])) {
                    if (trim($arr1_visual_option[$arr1]      != '')) {
                        $dt1_visual_option[$arr1] = $arr1_visual_option[$arr1];
                    } else {
                        $dt1_visual_option[$arr1] = '-';
                    }
                } else {
                    $dt1_visual_option[$arr1] = '';
                }

                if (isset($arr1_rownum[$arr1])) {
                    if (trim($arr1_rownum[$arr1]                    != '')) {
                        $dt1_rownum[$arr1] = $arr1_rownum[$arr1];
                    } else {
                        $dt1_rownum[$arr1] = '-';
                    }
                } else {
                    $dt1_rownum[$arr1] = '';
                }

                if (isset($arr1_dtl_check_sf1[$arr1])) {
                    if (trim($arr1_dtl_check_sf1[$arr1]      != '')) {
                        $dt1_dtl_check_sf1[$arr1] = $arr1_dtl_check_sf1[$arr1];
                    } else {
                        $dt1_dtl_check_sf1[$arr1] = '-';
                    }
                } else {
                    $dt1_dtl_check_sf1[$arr1] = '';
                }
                if (isset($arr1_dtl_check_sf2[$arr1])) {
                    if (trim($arr1_dtl_check_sf2[$arr1]      != '')) {
                        $dt1_dtl_check_sf2[$arr1] = $arr1_dtl_check_sf2[$arr1];
                    } else {
                        $dt1_dtl_check_sf2[$arr1] = '-';
                    }
                } else {
                    $dt1_dtl_check_sf2[$arr1] = '';
                }
                if (isset($arr1_dtl_check_sf3[$arr1])) {
                    if (trim($arr1_dtl_check_sf3[$arr1]      != '')) {
                        $dt1_dtl_check_sf3[$arr1] = $arr1_dtl_check_sf3[$arr1];
                    } else {
                        $dt1_dtl_check_sf3[$arr1] = '-';
                    }
                } else {
                    $dt1_dtl_check_sf3[$arr1] = '';
                }

                if (isset($dt_spek_dtl_check_sf1[$arr1])) {
                    $vdt_spek_dtl_check_sf1[$arr1]       = $dt_spek_dtl_check_sf1[$arr1];
                } else {
                    $vdt_spek_dtl_check_sf1[$arr1] = '';
                }
                if (isset($dt_spek_dtl_check_sf2[$arr1])) {
                    $vdt_spek_dtl_check_sf2[$arr1]       = $dt_spek_dtl_check_sf2[$arr1];
                } else {
                    $vdt_spek_dtl_check_sf2[$arr1] = '';
                }
                if (isset($dt_spek_dtl_check_sf3[$arr1])) {
                    $vdt_spek_dtl_check_sf3[$arr1]       = $dt_spek_dtl_check_sf3[$arr1];
                } else {
                    $vdt_spek_dtl_check_sf3[$arr1] = '';
                }

                if (isset($autoinspek_dtl_check_sf1[$arr1])) {
                    $vautoinspek_dtl_check_sf1[$arr1] = $autoinspek_dtl_check_sf1[$arr1];
                } else {
                    $vautoinspek_dtl_check_sf1[$arr1] = '';
                }
                if (isset($autoinspek_dtl_check_sf2[$arr1])) {
                    $vautoinspek_dtl_check_sf2[$arr1] = $autoinspek_dtl_check_sf2[$arr1];
                } else {
                    $vautoinspek_dtl_check_sf2[$arr1] = '';
                }
                if (isset($autoinspek_dtl_check_sf3[$arr1])) {
                    $vautoinspek_dtl_check_sf3[$arr1] = $autoinspek_dtl_check_sf3[$arr1];
                } else {
                    $vautoinspek_dtl_check_sf3[$arr1] = '';
                }
            }

            $row_no    = $row_no_a + 3;
            $dtno1     = -1;
            $arr_item1 = -1;
            $no        = 0;
            for ($n1 = $start_detail; $n1 < ($start_detail + ($jml_data_percol)); $n1++) {
                $arr_item1++;
                $row_no++;
                $dtno1++;
                $no++;

                $objPHPExcel->setSharedStyle($bodyStyle, 'B' . $row_no . ':AF' . $row_no);
                $objPHPExcel->setSharedStyle($bodyStyle2, 'C' . $row_no . ':E' . $row_no);
                $objPHPExcel->setSharedStyle($bodyStyle2, 'F' . $row_no . ':H' . $row_no);
                $objPHPExcel->setSharedStyle($headerStyleLeft, 'A' . $row_no . ':A' . $row_no);
                $objPHPExcel->setSharedStyle($headerStyleRight, 'AG' . $row_no . ':AG' . $row_no);

                $arr1_dtno1  = ($start_detail + ($jml_data_percol * 0) + $dtno1);
                $arr1_dtno2  = ($start_detail + ($jml_data_percol * 1) + $dtno1);
                $arr1_dtno3  = ($start_detail + ($jml_data_percol * 2) + $dtno1);
                $arr1_dtno4  = ($start_detail + ($jml_data_percol * 3) + $dtno1);
                $arr1_dtno5  = ($start_detail + ($jml_data_percol * 4) + $dtno1);
                $arr1_dtno6  = ($start_detail + ($jml_data_percol * 5) + $dtno1);
                $arr1_dtno7  = ($start_detail + ($jml_data_percol * 6) + $dtno1);
                $arr1_dtno8  = ($start_detail + ($jml_data_percol * 7) + $dtno1);
                $arr1_dtno9  = ($start_detail + ($jml_data_percol * 8) + $dtno1);

                if ($dt1_number1[$n1] != '') {
                    $objPHPExcel->mergeCells('B' . $row_no . ':B' . $row_no)->setCellValue('B' . $row_no, $no);
                    $objPHPExcel->mergeCells('C' . $row_no . ':E' . $row_no)->setCellValue('C' . $row_no, $dt1_point_control[$n1]);
                    $objPHPExcel->mergeCells('F' . $row_no . ':G' . $row_no)->setCellValue('F' . $row_no, $dt1_point_control_2[$n1]);
                    $objPHPExcel->mergeCells('H' . $row_no . ':H' . $row_no)->setCellValue('H' . $row_no, $arr1_spec[$n1]);

                    for ($col = 0; $col < count($jml_col_sf1); $col++) {
                        for ($shift = 1; $shift <= 3; $shift++) {
                            if ($mode_akses == 'mode_audit' && ${'vdt_spek_dtl_check_sf' . $shift}[$arr1_dtno1] > 0) {
                                $objPHPExcel->mergeCells(getColRange(${'jml_col_sf' . $shift}[$col], $row_no, 0))->setCellValue(${'jml_col_sf' . $shift}[$col] . $row_no, ${'vautoinspek_dtl_check_sf' . $shift}[${'arr1_dtno' . ($col + 1)}]);
                            } elseif (${'vdt_spek_dtl_check_sf' . $shift}[${'arr1_dtno' . ($col + 1)}] > 0) {
                                $objPHPExcel->getStyle(getColRange(${'jml_col_sf' . $shift}[$col], $row_no, 0))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                                $objPHPExcel->getStyle(getColRange(${'jml_col_sf' . $shift}[$col], $row_no, 0))->getFill()->getStartColor()->setRGB('CC0000');
                                $objPHPExcel->mergeCells(getColRange(${'jml_col_sf' . $shift}[$col], $row_no, 0))->setCellValue(${'jml_col_sf' . $shift}[$col] . $row_no, ${'dt1_dtl_check_sf' . $shift}[${'arr1_dtno' . ($col + 1)}]);
                            } else {
                                $objPHPExcel->mergeCells(getColRange(${'jml_col_sf' . $shift}[$col], $row_no, 0))->setCellValue(${'jml_col_sf' . $shift}[$col] . $row_no, ${'dt1_dtl_check_sf' . $shift}[${'arr1_dtno' . ($col + 1)}]);
                            }
                        }
                    }
                } else {
                    if (isset($arr1_item1[$arr_item1])) {
                        $objPHPExcel->mergeCells('C' . $row_no . ':E' . $row_no)->setCellValue('C' . $row_no, $arr1_item1[$arr_item1]);
                        $objPHPExcel->mergeCells('F' . $row_no . ':G' . $row_no)->setCellValue('F' . $row_no, $arr1_item2[$arr_item1]);
                        $objPHPExcel->mergeCells('H' . $row_no . ':H' . $row_no)->setCellValue('H' . $row_no, $arr1_spec[$arr_item1]);

                        for ($col = 0; $col < count($jml_col_sf1); $col++) {
                            for ($shift = 1; $shift <= 3; $shift++) {
                                $objPHPExcel->mergeCells(getColRange(${'jml_col_sf' . $shift}[$col], $row_no, 0))->setCellValue(${'jml_col_sf' . $shift}[$col] . $row_no, '');
                            }
                        }
                    } else {
                        $objPHPExcel->mergeCells('C' . $row_no . ':E' . $row_no)->setCellValue('C' . $row_no, '');
                        $objPHPExcel->mergeCells('F' . $row_no . ':G' . $row_no)->setCellValue('F' . $row_no, '');
                        $objPHPExcel->mergeCells('H' . $row_no . ':H' . $row_no)->setCellValue('H' . $row_no, '');
                        for ($col = 0; $col < count($jml_col_sf1); $col++) {
                            for ($shift = 1; $shift <= 3; $shift++) {
                                $objPHPExcel->mergeCells(getColRange(${'jml_col_sf' . $shift}[$col], $row_no, 0))->setCellValue(${'jml_col_sf' . $shift}[$col] . $row_no, '');
                            }
                        }
                    }
                }
            }

            $objPHPExcel->mergeCells('A' . ($row_no + 1) . ':AF' . ($row_no + 1))->setCellValue('A' . ($row_no + 1), '');

            $objPHPExcel->mergeCells('A' . ($row_no + 2) . ':A' . ($row_no + 2))->setCellValue('A' . ($row_no + 2), '');
            $objPHPExcel->mergeCells('B' . ($row_no + 2) . ':D' . ($row_no + 2))->setCellValue('B' . ($row_no + 2), 'DESCRIPTION :');
            $objPHPExcel->mergeCells('V' . ($row_no + 2) . ':AF' . ($row_no + 2))->setCellValue('V' . ($row_no + 2), '');

            $objPHPExcel->mergeCells('A' . ($row_no + 3) . ':A' . ($row_no + 3))->setCellValue('A' . ($row_no + 3), '');
            $objPHPExcel->mergeCells('B' . ($row_no + 3) . ':G' . ($row_no + 3))->setCellValue('B' . ($row_no + 3), '-  (Strip) : No checking activity');

            $objPHPExcel->mergeCells('B' . ($row_no + 4) . ':G' . ($row_no + 4))->setCellValue('B' . ($row_no + 4), '');

            $objPHPExcel->mergeCells('B' . ($row_no + 5) . ':G' . ($row_no + 5))->setCellValue('B' . ($row_no + 5), '');

            $objPHPExcel->mergeCells('B' . ($row_no + 6) . ':G' . ($row_no + 6))->setCellValue('B' . ($row_no + 6), "");

            $objPHPExcel->mergeCells('B' . ($row_no + 7) . ':G' . ($row_no + 7))->setCellValue('B' . ($row_no + 7), "");

            $objPHPExcel->mergeCells('B' . ($row_no + 8) . ':G' . ($row_no + 8))->setCellValue('B' . ($row_no + 8), "");

            $objPHPExcel->mergeCells('B' . ($row_no + 9) . ':G' . ($row_no + 9))->setCellValue('B' . ($row_no + 9), "");

            $objPHPExcel->mergeCells('B' . ($row_no + 10) . ':G' . ($row_no + 10))->setCellValue('B' . ($row_no + 10), '');

            $objPHPExcel->mergeCells('B' . ($row_no + 11) . ':G' . ($row_no + 11))->setCellValue('B' . ($row_no + 11), '');

            $objPHPExcel->mergeCells('B' . ($row_no + 12) . ':G' . ($row_no + 12))->setCellValue('B' . ($row_no + 12), '');

            $objPHPExcel->mergeCells('I' . ($row_no + 2) . ':L' . ($row_no + 2))->setCellValue('I' . ($row_no + 2), 'NON CONFORMANCE :');

            $objPHPExcel->mergeCells('I' . ($row_no + 3) . ':K' . ($row_no + 4))->setCellValue('I' . ($row_no + 3), 'Time');
            $objPHPExcel->mergeCells('L' . ($row_no + 3) . ':L' . ($row_no + 4))->setCellValue('L' . ($row_no + 3), 'Shift');
            $objPHPExcel->mergeCells('M' . ($row_no + 3) . ':U' . ($row_no + 4))->setCellValue('M' . ($row_no + 3), 'Non Conformance');
            $objPHPExcel->mergeCells('V' . ($row_no + 3) . ':AD' . ($row_no + 4))->setCellValue('V' . ($row_no + 3), 'Corective Action');
            $objPHPExcel->mergeCells('AE' . ($row_no + 3) . ':AF' . ($row_no + 4))->setCellValue('AE' . ($row_no + 3), "Action By\n( Name / Sign )");

            $objPHPExcel->setSharedStyle($headerStyleLeft, 'A' . ($row_no + 1) . ':A' . ($row_no + 12));
            $objPHPExcel->setSharedStyle($noborderStyle, 'B' . ($row_no + 1) . ':AF' . ($row_no + 12));
            $objPHPExcel->setSharedStyle($headerStyleRight, 'AG' . ($row_no + 1) . ':AG' . ($row_no + 12));
            $objPHPExcel->setSharedStyle($headerStyle, 'I' . ($row_no + 3) . ':AF' . ($row_no + 4));
            $objPHPExcel->setSharedStyle($noborderStyleBold, 'F' . ($row_no + 2) . ':AG' . ($row_no + 2));
            $objPHPExcel->setSharedStyle($headerStyleRight, 'AG' . ($row_no + 2) . ':AG' . ($row_no + 2));

            $row_no2 = $row_no + 4;
            for ($arr2 = $start_detail2; $arr2 <= $finish_detail2; $arr2++) {
                $row_no2++;

                if (isset($arr2_number2[$arr2])) {
                    $dt2_number2[$arr2]                           = $arr2_number2[$arr2];
                } else {
                    $dt2_number2[$arr2] = '';
                }
                if (isset($arr2_time_b[$arr2])) {
                    if (trim($arr2_time_b[$arr2]                   != '')) {
                        $dt2_time_b[$arr2] = $arr2_time_b[$arr2];
                    } else {
                        $dt2_time_b[$arr2] = '-';
                    }
                } else {
                    $dt2_time_b[$arr2] = '';
                }
                if (isset($arr2_shift_b[$arr2])) {
                    if (trim($arr2_shift_b[$arr2]                 != '')) {
                        $dt2_shift_b[$arr2] = $arr2_shift_b[$arr2];
                    } else {
                        $dt2_shift_b[$arr2] = '-';
                    }
                } else {
                    $dt2_shift_b[$arr2] = '';
                }
                if (isset($arr2_non_conformance[$arr2])) {
                    if (trim($arr2_non_conformance[$arr2] != '')) {
                        $dt2_non_conformance[$arr2] = $arr2_non_conformance[$arr2];
                    } else {
                        $dt2_non_conformance[$arr2] = '-';
                    }
                } else {
                    $dt2_non_conformance[$arr2] = '';
                }
                if (isset($arr2_action[$arr2])) {
                    if (trim($arr2_action[$arr2]                   != '')) {
                        $dt2_action[$arr2] = $arr2_action[$arr2];
                    } else {
                        $dt2_action[$arr2] = '-';
                    }
                } else {
                    $dt2_action[$arr2] = '';
                }
                if (isset($arr2_action_by[$arr2])) {
                    if (trim($arr2_action_by[$arr2]             != '')) {
                        $dt2_action_by[$arr2] = $arr2_action_by[$arr2];
                    } else {
                        $dt2_action_by[$arr2] = '-';
                    }
                } else {
                    $dt2_action_by[$arr2] = '';
                }

                $objPHPExcel->setSharedStyle($bodyStyle, 'I' . $row_no2 . ':AF' . $row_no2);

                if (trim($dt2_number2[$arr2]) != '') {
                    $objPHPExcel->mergeCells('I' . $row_no2 . ':K' . $row_no2)->setCellValue('I' . $row_no2, $dt2_time_b[$arr2]);
                    $objPHPExcel->mergeCells('L' . $row_no2 . ':L' . $row_no2)->setCellValue('L' . $row_no2, $dt2_shift_b[$arr2]);
                    $objPHPExcel->mergeCells('M' . $row_no2 . ':U' . $row_no2)->setCellValue('M' . $row_no2, $dt2_non_conformance[$arr2]);
                    $objPHPExcel->mergeCells('V' . $row_no2 . ':AD' . $row_no2)->setCellValue('V' . $row_no2, $dt2_action[$arr2]);
                    $objPHPExcel->mergeCells('AE' . $row_no2 . ':AF' . $row_no2)->setCellValue('AE' . $row_no2, $dt2_action_by[$arr2]);
                } else {
                    $objPHPExcel->mergeCells('I' . $row_no2 . ':K' . $row_no2)->setCellValue('I' . $row_no2, '');
                    $objPHPExcel->mergeCells('L' . $row_no2 . ':L' . $row_no2)->setCellValue('L' . $row_no2, '');
                    $objPHPExcel->mergeCells('M' . $row_no2 . ':U' . $row_no2)->setCellValue('M' . $row_no2, '');
                    $objPHPExcel->mergeCells('V' . $row_no2 . ':AD' . $row_no2)->setCellValue('V' . $row_no2, '');
                    $objPHPExcel->mergeCells('AE' . $row_no2 . ':AF' . $row_no2)->setCellValue('AE' . $row_no2, '');
                }
            }

            $objPHPExcel->mergeCells('I' . ($row_no2 + 1) . ':AF' . ($row_no2 + 1))->setCellValue('I' . ($row_no2 + 1), '');

            $objPHPExcel->mergeCells('I' . ($row_no2 + 2) . ':Q' . ($row_no2 + 2))->setCellValue('I' . ($row_no2 + 2), 'Created by,');
            $objPHPExcel->mergeCells('R' . ($row_no2 + 2) . ':Z' . ($row_no2 + 2))->setCellValue('R' . ($row_no2 + 2), 'Checked by,');
            $objPHPExcel->mergeCells('AA' . ($row_no2 + 2) . ':AC' . ($row_no2 + 2))->setCellValue('AA' . ($row_no2 + 2), 'Confirmed by,');
            $objPHPExcel->mergeCells('AD' . ($row_no2 + 2) . ':AF' . ($row_no2 + 2))->setCellValue('AD' . ($row_no2 + 2), 'Approved by,');

            $objPHPExcel->mergeCells('I' . ($row_no2 + 3) . ':I' . ($row_no2 + 3))->setCellValue('I' . ($row_no2 + 3), '1st Shift');
            $objPHPExcel->mergeCells('I' . ($row_no2 + 4) . ':I' . ($row_no2 + 5))->setCellValue('I' . ($row_no2 + 4), '');
            $objPHPExcel->mergeCells('J' . ($row_no2 + 3) . ':K' . ($row_no2 + 5))->setCellValue('J' . ($row_no2 + 3), '');

            $objPHPExcel->mergeCells('L' . ($row_no2 + 3) . ':L' . ($row_no2 + 3))->setCellValue('L' . ($row_no2 + 3), '2nd Shift');
            $objPHPExcel->mergeCells('L' . ($row_no2 + 4) . ':L' . ($row_no2 + 5))->setCellValue('L' . ($row_no2 + 4), '');
            $objPHPExcel->mergeCells('M' . ($row_no2 + 3) . ':N' . ($row_no2 + 5))->setCellValue('M' . ($row_no2 + 3), '');

            $objPHPExcel->mergeCells('O' . ($row_no2 + 3) . ':O' . ($row_no2 + 3))->setCellValue('O' . ($row_no2 + 3), '3rd Shift');
            $objPHPExcel->mergeCells('O' . ($row_no2 + 4) . ':O' . ($row_no2 + 5))->setCellValue('O' . ($row_no2 + 4), '');
            $objPHPExcel->mergeCells('P' . ($row_no2 + 3) . ':Q' . ($row_no2 + 5))->setCellValue('P' . ($row_no2 + 3), '');

            $objPHPExcel->mergeCells('R' . ($row_no2 + 3) . ':R' . ($row_no2 + 3))->setCellValue('R' . ($row_no2 + 3), '1st Shift');
            $objPHPExcel->mergeCells('R' . ($row_no2 + 4) . ':R' . ($row_no2 + 5))->setCellValue('R' . ($row_no2 + 4), '');
            $objPHPExcel->mergeCells('S' . ($row_no2 + 3) . ':T' . ($row_no2 + 5))->setCellValue('S' . ($row_no2 + 3), '');

            $objPHPExcel->mergeCells('U' . ($row_no2 + 3) . ':U' . ($row_no2 + 3))->setCellValue('U' . ($row_no2 + 3), '2nd Shift');
            $objPHPExcel->mergeCells('U' . ($row_no2 + 4) . ':U' . ($row_no2 + 5))->setCellValue('U' . ($row_no2 + 4), '');
            $objPHPExcel->mergeCells('V' . ($row_no2 + 3) . ':W' . ($row_no2 + 5))->setCellValue('V' . ($row_no2 + 3), '');

            $objPHPExcel->mergeCells('X' . ($row_no2 + 3) . ':X' . ($row_no2 + 3))->setCellValue('X' . ($row_no2 + 3), '3rd Shift');
            $objPHPExcel->mergeCells('X' . ($row_no2 + 4) . ':X' . ($row_no2 + 5))->setCellValue('X' . ($row_no2 + 4), '');
            $objPHPExcel->mergeCells('Y' . ($row_no2 + 3) . ':Z' . ($row_no2 + 5))->setCellValue('Y' . ($row_no2 + 3), '');

            $objPHPExcel->mergeCells('AA' . ($row_no2 + 3) . ':AC' . ($row_no2 + 5))->setCellValue('AA' . ($row_no2 + 3), '');
            $objPHPExcel->mergeCells('AD' . ($row_no2 + 3) . ':AF' . ($row_no2 + 5))->setCellValue('AD' . ($row_no2 + 3), '');

            if (isset($app1_status)) {
                if (file_exists(FCPATH . "assets/ttd/" . $app1_by . ".png")) {
                    $sign_img1 = '$objDrawing' . $i1;
                    $sign_img1 = new PHPExcel_Worksheet_Drawing();
                    $sign_img1->setPath('assets/ttd/' . $app1_by . '.png');
                    $sign_img1->setWidthAndHeight(80, 80);
                    $sign_img1->setResizeProportional(true);
                    $sign_img1->setWorksheet($objPHPExcel);
                    $sign_img1->setCoordinates('J' . ($row_no2 + 3));
                }
            }
            if (isset($app2_status)) {
                if (file_exists(FCPATH . "assets/ttd/" . $app2_by . ".png")) {
                    $sign_img2 = '$objDrawing' . $i1;
                    $sign_img2 = new PHPExcel_Worksheet_Drawing();
                    $sign_img2->setPath('assets/ttd/' . $app2_by . '.png');
                    $sign_img2->setWidthAndHeight(80, 80);
                    $sign_img2->setResizeProportional(true);
                    $sign_img2->setWorksheet($objPHPExcel);
                    $sign_img2->setCoordinates('M' . ($row_no2 + 3));
                }
            }
            if (isset($app3_status)) {
                if (file_exists(FCPATH . "assets/ttd/" . $app3_by . ".png")) {
                    $sign_img3 = '$objDrawing' . $i1;
                    $sign_img3 = new PHPExcel_Worksheet_Drawing();
                    $sign_img3->setPath('assets/ttd/' . $app3_by . '.png');
                    $sign_img3->setWidthAndHeight(80, 80);
                    $sign_img3->setResizeProportional(true);
                    $sign_img3->setWorksheet($objPHPExcel);
                    $sign_img3->setCoordinates('P' . ($row_no2 + 3));
                }
            }
            if (isset($app4_status)) {
                if (file_exists(FCPATH . "assets/ttd/" . $app4_by . ".png")) {
                    $sign_img4 = '$objDrawing' . $i1;
                    $sign_img4 = new PHPExcel_Worksheet_Drawing();
                    $sign_img4->setPath('assets/ttd/' . $app4_by . '.png');
                    $sign_img4->setWidthAndHeight(80, 80);
                    $sign_img4->setResizeProportional(true);
                    $sign_img4->setWorksheet($objPHPExcel);
                    $sign_img4->setCoordinates('S' . ($row_no2 + 3));
                }
            }
            if (isset($app5_status)) {
                if (file_exists(FCPATH . "assets/ttd/" . $app5_by . ".png")) {
                    $sign_img5 = '$objDrawing' . $i1;
                    $sign_img5 = new PHPExcel_Worksheet_Drawing();
                    $sign_img5->setPath('assets/ttd/' . $app5_by . '.png');
                    $sign_img5->setWidthAndHeight(80, 80);
                    $sign_img5->setResizeProportional(true);
                    $sign_img5->setWorksheet($objPHPExcel);
                    $sign_img5->setCoordinates('V' . ($row_no2 + 3));
                }
            }
            if (isset($app6_status)) {
                if (file_exists(FCPATH . "assets/ttd/" . $app6_by . ".png")) {
                    $sign_img6 = '$objDrawing' . $i1;
                    $sign_img6 = new PHPExcel_Worksheet_Drawing();
                    $sign_img6->setPath('assets/ttd/' . $app6_by . '.png');
                    $sign_img6->setWidthAndHeight(80, 80);
                    $sign_img6->setResizeProportional(true);
                    $sign_img6->setWorksheet($objPHPExcel);
                    $sign_img6->setCoordinates('Y' . ($row_no2 + 3));
                }
            }
            if (isset($app7_status)) {
                if (file_exists(FCPATH . "assets/ttd/" . $app7_by . ".png")) {
                    $sign_img7 = '$objDrawing' . $i1;
                    $sign_img7 = new PHPExcel_Worksheet_Drawing();
                    $sign_img7->setPath('assets/ttd/' . $app7_by . '.png');
                    $sign_img7->setWidthAndHeight(80, 80);
                    $sign_img7->setResizeProportional(true);
                    $sign_img7->setWorksheet($objPHPExcel);
                    $sign_img7->setCoordinates('AB' . ($row_no2 + 3));
                }
            }
            if (isset($app8_status)) {
                if (file_exists(FCPATH . "assets/ttd/" . $app8_by . ".png")) {
                    $sign_img8 = '$objDrawing' . $i1;
                    $sign_img8 = new PHPExcel_Worksheet_Drawing();
                    $sign_img8->setPath('assets/ttd/' . $app8_by . '.png');
                    $sign_img8->setWidthAndHeight(80, 80);
                    $sign_img8->setResizeProportional(true);
                    $sign_img8->setWorksheet($objPHPExcel);
                    $sign_img8->setCoordinates('AE' . ($row_no2 + 3));
                }
            }
            // $objPHPExcel->getRowDimension($row_no2+6)->setRowHeight(24); 
            $objPHPExcel->mergeCells('I' . ($row_no2 + 6) . ':I' . ($row_no2 + 6))->setCellValue('I' . ($row_no2 + 6), 'Name');
            $objPHPExcel->mergeCells('J' . ($row_no2 + 6) . ':K' . ($row_no2 + 6))->setCellValue('J' . ($row_no2 + 6), ': ' . $app1_by);
            $objPHPExcel->mergeCells('L' . ($row_no2 + 6) . ':L' . ($row_no2 + 6))->setCellValue('L' . ($row_no2 + 6), 'Name');
            $objPHPExcel->mergeCells('M' . ($row_no2 + 6) . ':N' . ($row_no2 + 6))->setCellValue('M' . ($row_no2 + 6), ': ' . $app2_by);
            $objPHPExcel->mergeCells('O' . ($row_no2 + 6) . ':O' . ($row_no2 + 6))->setCellValue('O' . ($row_no2 + 6), 'Name');
            $objPHPExcel->mergeCells('P' . ($row_no2 + 6) . ':Q' . ($row_no2 + 6))->setCellValue('P' . ($row_no2 + 6), ': ' . $app3_by);
            $objPHPExcel->mergeCells('R' . ($row_no2 + 6) . ':R' . ($row_no2 + 6))->setCellValue('R' . ($row_no2 + 6), 'Name');
            $objPHPExcel->mergeCells('S' . ($row_no2 + 6) . ':T' . ($row_no2 + 6))->setCellValue('S' . ($row_no2 + 6), ': ' . $app4_by);
            $objPHPExcel->mergeCells('U' . ($row_no2 + 6) . ':U' . ($row_no2 + 6))->setCellValue('U' . ($row_no2 + 6), 'Name');
            $objPHPExcel->mergeCells('V' . ($row_no2 + 6) . ':W' . ($row_no2 + 6))->setCellValue('V' . ($row_no2 + 6), ': ' . $app5_by);
            $objPHPExcel->mergeCells('X' . ($row_no2 + 6) . ':X' . ($row_no2 + 6))->setCellValue('X' . ($row_no2 + 6), 'Name');
            $objPHPExcel->mergeCells('Y' . ($row_no2 + 6) . ':Z' . ($row_no2 + 6))->setCellValue('Y' . ($row_no2 + 6), ': ' . $app6_by);
            $objPHPExcel->mergeCells('AA' . ($row_no2 + 6) . ':AA' . ($row_no2 + 6))->setCellValue('AA' . ($row_no2 + 6), 'Name');
            $objPHPExcel->mergeCells('AB' . ($row_no2 + 6) . ':AC' . ($row_no2 + 6))->setCellValue('AB' . ($row_no2 + 6), ': ' . $app7_by);
            $objPHPExcel->mergeCells('AD' . ($row_no2 + 6) . ':AD' . ($row_no2 + 6))->setCellValue('AD' . ($row_no2 + 6), 'Name');
            $objPHPExcel->mergeCells('AE' . ($row_no2 + 6) . ':AF' . ($row_no2 + 6))->setCellValue('AE' . ($row_no2 + 6), ': ' . $app8_by);

            $objPHPExcel->mergeCells('I' . ($row_no2 + 7) . ':I' . ($row_no2 + 7))->setCellValue('I' . ($row_no2 + 7), 'Position');
            $objPHPExcel->mergeCells('J' . ($row_no2 + 7) . ':K' . ($row_no2 + 7))->setCellValue('J' . ($row_no2 + 7), ': ' . $app1_position);
            $objPHPExcel->mergeCells('L' . ($row_no2 + 7) . ':L' . ($row_no2 + 7))->setCellValue('L' . ($row_no2 + 7), 'Position');
            $objPHPExcel->mergeCells('M' . ($row_no2 + 7) . ':N' . ($row_no2 + 7))->setCellValue('M' . ($row_no2 + 7), ': ' . $app2_position);
            $objPHPExcel->mergeCells('O' . ($row_no2 + 7) . ':O' . ($row_no2 + 7))->setCellValue('O' . ($row_no2 + 7), 'Position');
            $objPHPExcel->mergeCells('P' . ($row_no2 + 7) . ':Q' . ($row_no2 + 7))->setCellValue('P' . ($row_no2 + 7), ': ' . $app3_position);
            $objPHPExcel->mergeCells('R' . ($row_no2 + 7) . ':R' . ($row_no2 + 7))->setCellValue('R' . ($row_no2 + 7), 'Position');
            $objPHPExcel->mergeCells('S' . ($row_no2 + 7) . ':T' . ($row_no2 + 7))->setCellValue('S' . ($row_no2 + 7), ': ' . $app4_position);
            $objPHPExcel->mergeCells('U' . ($row_no2 + 7) . ':U' . ($row_no2 + 7))->setCellValue('U' . ($row_no2 + 7), 'Position');
            $objPHPExcel->mergeCells('V' . ($row_no2 + 7) . ':W' . ($row_no2 + 7))->setCellValue('V' . ($row_no2 + 7), ': ' . $app5_position);
            $objPHPExcel->mergeCells('X' . ($row_no2 + 7) . ':X' . ($row_no2 + 7))->setCellValue('X' . ($row_no2 + 7), 'Position');
            $objPHPExcel->mergeCells('Y' . ($row_no2 + 7) . ':Z' . ($row_no2 + 7))->setCellValue('Y' . ($row_no2 + 7), ': ' . $app6_position);
            $objPHPExcel->mergeCells('AA' . ($row_no2 + 7) . ':AA' . ($row_no2 + 7))->setCellValue('AA' . ($row_no2 + 7), 'Position');
            $objPHPExcel->mergeCells('AB' . ($row_no2 + 7) . ':AC' . ($row_no2 + 7))->setCellValue('AB' . ($row_no2 + 7), ': ' . $app7_position);
            $objPHPExcel->mergeCells('AD' . ($row_no2 + 7) . ':AD' . ($row_no2 + 7))->setCellValue('AD' . ($row_no2 + 7), 'Position');
            $objPHPExcel->mergeCells('AE' . ($row_no2 + 7) . ':AF' . ($row_no2 + 7))->setCellValue('AE' . ($row_no2 + 7), ': ' . $app8_position);

            $objPHPExcel->mergeCells('I' . ($row_no2 + 8) . ':I' . ($row_no2 + 8))->setCellValue('I' . ($row_no2 + 8), 'Date');
            $objPHPExcel->mergeCells('J' . ($row_no2 + 8) . ':K' . ($row_no2 + 8))->setCellValue('J' . ($row_no2 + 8), ': ' . $app1date);
            $objPHPExcel->mergeCells('L' . ($row_no2 + 8) . ':L' . ($row_no2 + 8))->setCellValue('L' . ($row_no2 + 8), 'Date');
            $objPHPExcel->mergeCells('M' . ($row_no2 + 8) . ':N' . ($row_no2 + 8))->setCellValue('M' . ($row_no2 + 8), ': ' . $app2date);
            $objPHPExcel->mergeCells('O' . ($row_no2 + 8) . ':O' . ($row_no2 + 8))->setCellValue('O' . ($row_no2 + 8), 'Date');
            $objPHPExcel->mergeCells('P' . ($row_no2 + 8) . ':Q' . ($row_no2 + 8))->setCellValue('P' . ($row_no2 + 8), ': ' . $app3date);
            $objPHPExcel->mergeCells('R' . ($row_no2 + 8) . ':R' . ($row_no2 + 8))->setCellValue('R' . ($row_no2 + 8), 'Date');
            $objPHPExcel->mergeCells('S' . ($row_no2 + 8) . ':T' . ($row_no2 + 8))->setCellValue('S' . ($row_no2 + 8), ': ' . $app4date);
            $objPHPExcel->mergeCells('U' . ($row_no2 + 8) . ':U' . ($row_no2 + 8))->setCellValue('U' . ($row_no2 + 8), 'Date');
            $objPHPExcel->mergeCells('V' . ($row_no2 + 8) . ':W' . ($row_no2 + 8))->setCellValue('V' . ($row_no2 + 8), ': ' . $app5date);
            $objPHPExcel->mergeCells('X' . ($row_no2 + 8) . ':X' . ($row_no2 + 8))->setCellValue('X' . ($row_no2 + 8), 'Date');
            $objPHPExcel->mergeCells('Y' . ($row_no2 + 8) . ':Z' . ($row_no2 + 8))->setCellValue('Y' . ($row_no2 + 8), ': ' . $app6date);
            $objPHPExcel->mergeCells('AA' . ($row_no2 + 8) . ':AA' . ($row_no2 + 8))->setCellValue('AA' . ($row_no2 + 8), 'Date');
            $objPHPExcel->mergeCells('AB' . ($row_no2 + 8) . ':AC' . ($row_no2 + 8))->setCellValue('AB' . ($row_no2 + 8), ': ' . $app7date);
            $objPHPExcel->mergeCells('AD' . ($row_no2 + 8) . ':AD' . ($row_no2 + 8))->setCellValue('AD' . ($row_no2 + 8), 'Date');
            $objPHPExcel->mergeCells('AE' . ($row_no2 + 8) . ':AF' . ($row_no2 + 8))->setCellValue('AE' . ($row_no2 + 8), ': ' . $app8date);

            $objPHPExcel->setSharedStyle($headerStyleLeft, 'A' . ($row_no2 + 1) . ':A' . ($row_no2 + 8));
            $objPHPExcel->setSharedStyle($noborderStyle, 'B' . ($row_no2 + 1) . ':AF' . ($row_no2 + 8));
            $objPHPExcel->setSharedStyle($headerStyleRight, 'AG' . ($row_no2 + 1) . ':AG' . ($row_no2 + 8));

            $objPHPExcel->setSharedStyle($headerStyle, 'I' . ($row_no2 + 2) . ':AF' . ($row_no2 + 2));
            $objPHPExcel->setSharedStyle($headerStyleLeftTop, 'I' . ($row_no2 + 3) . ':I' . ($row_no2 + 3));
            $objPHPExcel->setSharedStyle($headerStyleLeftBottom, 'I' . ($row_no2 + 4) . ':I' . ($row_no2 + 5));
            $objPHPExcel->setSharedStyle($headerStyleLeft, 'I' . ($row_no2 + 6) . ':I' . ($row_no2 + 8));
            $objPHPExcel->setSharedStyle($headerStyleRightbottom, 'J' . ($row_no2 + 3) . ':K' . ($row_no2 + 5));
            $objPHPExcel->setSharedStyle($headerStyleRight, 'J' . ($row_no2 + 6) . ':K' . ($row_no2 + 8));
            $objPHPExcel->setSharedStyle($headerStyleRightbottom, 'M' . ($row_no2 + 3) . ':N' . ($row_no2 + 5));
            $objPHPExcel->setSharedStyle($headerStyleLeftBottom, 'L' . ($row_no2 + 4) . ':L' . ($row_no2 + 5));
            $objPHPExcel->setSharedStyle($headerStyleRight, 'M' . ($row_no2 + 6) . ':N' . ($row_no2 + 8));
            $objPHPExcel->setSharedStyle($headerStyleRightbottom, 'P' . ($row_no2 + 3) . ':Q' . ($row_no2 + 5));
            $objPHPExcel->setSharedStyle($headerStyleLeftBottom, 'O' . ($row_no2 + 4) . ':O' . ($row_no2 + 5));
            $objPHPExcel->setSharedStyle($headerStyleRight, 'P' . ($row_no2 + 6) . ':Q' . ($row_no2 + 8));
            $objPHPExcel->setSharedStyle($headerStyleRightbottom, 'S' . ($row_no2 + 3) . ':T' . ($row_no2 + 5));
            $objPHPExcel->setSharedStyle($headerStyleLeftBottom, 'R' . ($row_no2 + 4) . ':R' . ($row_no2 + 5));
            $objPHPExcel->setSharedStyle($headerStyleRight, 'S' . ($row_no2 + 6) . ':T' . ($row_no2 + 8));
            $objPHPExcel->setSharedStyle($headerStyleRightbottom, 'V' . ($row_no2 + 3) . ':W' . ($row_no2 + 5));
            $objPHPExcel->setSharedStyle($headerStyleLeftBottom, 'U' . ($row_no2 + 4) . ':U' . ($row_no2 + 5));
            $objPHPExcel->setSharedStyle($headerStyleRight, 'V' . ($row_no2 + 6) . ':W' . ($row_no2 + 8));
            $objPHPExcel->setSharedStyle($headerStyleRightbottom, 'Y' . ($row_no2 + 3) . ':Z' . ($row_no2 + 5));
            $objPHPExcel->setSharedStyle($headerStyleLeftBottom, 'X' . ($row_no2 + 4) . ':X' . ($row_no2 + 5));
            $objPHPExcel->setSharedStyle($headerStyleRight, 'Y' . ($row_no2 + 6) . ':Z' . ($row_no2 + 8));
            $objPHPExcel->setSharedStyle($headerStyleRightbottom, 'AB' . ($row_no2 + 3) . ':AC' . ($row_no2 + 5));
            $objPHPExcel->setSharedStyle($headerStyleLeftBottom, 'AA' . ($row_no2 + 4) . ':AA' . ($row_no2 + 5));
            $objPHPExcel->setSharedStyle($headerStyleRight, 'AB' . ($row_no2 + 6) . ':AC' . ($row_no2 + 8));
            $objPHPExcel->setSharedStyle($headerStyleRightbottom, 'AE' . ($row_no2 + 3) . ':AF' . ($row_no2 + 5));
            $objPHPExcel->setSharedStyle($headerStyleLeftBottom, 'AD' . ($row_no2 + 4) . ':AD' . ($row_no2 + 5));
            $objPHPExcel->setSharedStyle($headerStyleRight, 'AE' . ($row_no2 + 6) . ':AF' . ($row_no2 + 8));

            $objPHPExcel->mergeCells('A' . ($row_no2 + 9) . ':N' . ($row_no2 + 9))->setCellValue('A' . ($row_no2 + 9), 'Effective Date ' . $frm_efect);
            $objPHPExcel->getStyle('O' . ($row_no2 + 9) . ':AG' . ($row_no2 + 9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->mergeCells('O' . ($row_no2 + 9) . ':AG' . ($row_no2 + 9))->setCellValue('O' . ($row_no2 + 9), $frmnm . '-' . $frmversi);

            $objPHPExcel->setSharedStyle($footerStyleLeftbottom, 'A' . ($row_no2 + 9) . ':N' . ($row_no2 + 9));
            $objPHPExcel->setSharedStyle($footerStyleRightbottom, 'O' . ($row_no2 + 9) . ':AG' . ($row_no2 + 9));

            $objPHPExcel->setBreak('A' . ($row_no2 + 9),  PHPExcel_Worksheet::BREAK_ROW);
        }
        ob_clean();
        header('Content-Type: text/html; charset=utf-8');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $frmnm . '.xls');
        //   header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($obj, 'Excel5');
        $objWriter->save('php://output');
        exit();
        ob_end_clean();

    }

}