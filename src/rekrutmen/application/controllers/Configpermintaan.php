<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by Heriyanto
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
use PhpOffice\PhpSpreadsheet\IOFactory;

require_once APPPATH . 'core/BaseController.php';

class Configpermintaan extends BaseController
{

    protected function loadingmodel()
    {
        $this->load->model('M_configpermintaan');
        $this->load->model('M_grupDept');
        $this->load->model('M_user_login');
    }

    public function setpermintaan()
    {
        redirect('configpermintaan/index');
    }

    public function index()
    {
        // die;
        $cssadd = array('sweetalert.css', 'bootstrap-select.min.css', 'addcss/buttons.bootstrap.min.css', 'addcss/fixdb.css');
        $jsadd = array(
            'jsadd/autoNumeric.min.js', 'jsadd/sweetalert.min.js', 'jsadd/bootstrap-select.min.js', 'jsadd/underscore-min.js', 'jsadd/backbone-min.js', 'jsadd/backdatatableserver2.js'
        );
        // $this->template2->display('utility/permintaan/viewconfigpermintaan', array('cssadd' => $cssadd));
        $data['getDept'] = $this->M_configpermintaan->getDept_();
        $data['target'] = $this->M_configpermintaan->getTarget();



        $this->template->display('utility/permintaan/viewconfigpermintaan', array('cssadd' => $cssadd, 'data' => $data));
        // if ($this->session->userdata('userid') == 'KIKI' || $this->session->userdata('userid') == 'YULI1234') {
        //     // if ($this->session->userdata('userid') == 'KIKI') {
        // } else {
        //     $this->template->display('utility/permintaan/viewconfigpermintaan', array('cssadd' => $cssadd, 'data' => $data));
        // }
    }

    public function index2()
    {
        // die;
        $cssadd = array('sweetalert.css', 'bootstrap-select.min.css', 'addcss/buttons.bootstrap.min.css', 'addcss/fixdb.css');
        $jsadd = array(
            'jsadd/autoNumeric.min.js', 'jsadd/sweetalert.min.js', 'jsadd/bootstrap-select.min.js', 'jsadd/underscore-min.js', 'jsadd/backbone-min.js', 'jsadd/backdatatableserver2.js'
        );
        // $this->template2->display('utility/permintaan/viewconfigpermintaan', array('cssadd' => $cssadd));
        $data['getDept'] = $this->M_configpermintaan->getDept();
        $this->template->display('utility/permintaan/viewconfigpermintaan_v2', array('cssadd' => $cssadd, 'data' => $data));
    }

    public function test()
    {
        // die;
        $cssadd = array('sweetalert.css', 'bootstrap-select.min.css', 'addcss/buttons.bootstrap.min.css', 'addcss/fixdb.css');

        $jsadd = array(
            'jsadd/autoNumeric.min.js', 'jsadd/sweetalert.min.js', 'jsadd/bootstrap-select.min.js', 'jsadd/underscore-min.js', 'jsadd/backbone-min.js', 'jsadd/backdatatableserver2.js'
        );
        $data['getDept'] = $this->M_configpermintaan->getDept();
        $this->template->display('utility/permintaan/viewconfigpermintaan_test', array('cssadd' => $cssadd, 'data' => $data));
    }

    public function getajaxsummary()
    {
        $dept = $this->input->get('dept');
        $param['dept'] = $dept ?? null;
        $data = $this->M_configpermintaan->gettotalall($param);
        $summary = $data->result_array();
        echo json_encode(array('data' => $summary));
    }

    public function getajaxsummarydept()
    {
        $dept = $this->M_user_login->getDept();
        $deptlist = $this->M_grupDept->getDeptAbbrFromGrupBor($this->session->userdata('groupuser'));
        $daftardept = array();
        foreach ($deptlist as $val) {
            $daftardept[] = $val->DeptAbbr;
        }
        $adata = implode("','", $daftardept);
        $param['dept'] = $adata;
        $data = $this->M_configpermintaan->gettotalall($param);
        $summary = $data->result_array();
        echo json_encode(array('data' => $summary));
    }

    public function monitorpermintaanbydept()
    {
        $cssadd = array('sweetalert.css', 'bootstrap-select.min.css', 'addcss/buttons.bootstrap.min.css', 'addcss/fixdb.css');
        $jsadd = array(
            'jsadd/autoNumeric.min.js', 'jsadd/sweetalert.min.js', 'jsadd/bootstrap-select.min.js', 'jsadd/underscore-min.js', 'jsadd/backbone-min.js', 'jsadd/backdatatableserver2.js',
            'jsadd/configpermintaan/configpermintaanbydept.js'
        );
        //$data['jsadd']=$jsadd;
        $data['cssadd'] = $cssadd;
        $this->template2->display('utility/permintaan/viewconfigpermintaanbydept', $data);
    }

    public function getdatacountkrytk()
    {
        $param = $this->GetRequestFromDataTable();
        $param['coresearch'] = 'DeptAbbr like @1 OR Periode like @1';
        $query = $this->M_configpermintaan->getdatavwkaryawan($param);
        // $query = [];
        echo json_encode($query);
    }

    public function getdatacountkrytkdept()
    {
        $param = $this->GetRequestFromDataTable();
        $dept = $this->M_user_login->getDept();
        $deptlist = $this->M_grupDept->getDeptAbbrFromGrupBor($this->session->userdata('groupuser'));
        $daftardept = array();
        foreach ($deptlist as $val) {
            $daftardept[] = $val->DeptAbbr;
        }
        $adata = implode("','", $daftardept);
        $param['dept'] = $adata;
        $query = $this->M_configpermintaan->getdatavwkaryawandept($param);
        echo json_encode($query);
    }

    public function updatedata()
    {
        $ndata = $this->input->raw_input_stream;
        $idkry = $this->input->post('idkrydept');
        $upideal = $this->input->post('stxtidealkry');
        $upideal = preg_replace("/[^0-9]/", "", $upideal);
        $deptname = $idkry;
        // print_r($upideal);
        // exit;
        if (!is_numeric($deptname)) {
            echo json_encode(array('Err' => 1, 'Msg' => 'Data format departemen salah-- silahkan refresh dan coba kembali'));
        } else {
            //save file first
            // $returndata = $this->UpLoadFile('stxtmemokry','./dataupload/idealkarytk/','pdf');
            // if($returndata['Err']!=''){
            //     echo json_encode(array('Err'=>1,'Msg'=>$returndata['Err']));
            // }else{
            //save to database
            //     $locationfile = './dataupload/idealkarytk/' .  $returndata['filename'];
            $locationfile = '';
            $param = array($deptname, 1, $upideal, $locationfile, $this->session->userdata('userid'));
            // print_r($param);
            // die;
            $query = $this->M_configpermintaan->UpdateIdealKaryawan($param);
            echo json_encode(array('Err' => 0, 'Msg' => 'Data berhasil diupdate'));
            // }   
        }
    }

    public function updatedatatk()
    {
        $ndata = $this->input->raw_input_stream;
        $idkry = $this->input->post('idkrrybor');
        $upideal = $this->input->post('txtidealtks');
        $upideal = preg_replace("/[^0-9]/", "", $upideal);
        $deptname = decode_str($idkry);

        if (!is_numeric($idkry)) {
            echo json_encode(array('Err' => 1, 'Msg' => 'Data format departemen salah-- tk silahkan refresh dan coba kembali'));
        } else {
            //save file first
            //$returndata = $this->UpLoadFile('txtmemotk','./dataupload/idealkarytk/','pdf');
            //if($returndata['Err']!=''){
            //    echo json_encode(array('Err'=>1,'Msg'=>$returndata['Err']));
            //}else{
            //save to database
            $locationfile = ''; //'./dataupload/idealkarytk/' .  $returndata['filename'];
            $param = array($idkry, 0, $upideal, $locationfile, $this->session->userdata('userid'));

            $query = $this->M_configpermintaan->UpdateIdealKaryawan($param);
            echo json_encode(array('Err' => 0, 'Msg' => 'Data berhasil diupdate'));
            // }   
        }
    }

    public function updatedatatk_()
    {
        $ndata = $this->input->raw_input_stream;
        $idkry = $this->input->post('idkrrybor');
        $upideal = $this->input->post('txtidealtks');
        $idsubjabatan = $this->input->post('txtidsubjabatan');
        $upideal = preg_replace("/[^0-9]/", "", $upideal);
        $deptname = decode_str($idkry);

        if (!is_numeric($idkry)) {
            echo json_encode(array('Err' => 1, 'Msg' => 'Data format departemen salah-- tk silahkan refresh dan coba kembali'));
        } else {
            //save file first
            //$returndata = $this->UpLoadFile('txtmemotk','./dataupload/idealkarytk/','pdf');
            //if($returndata['Err']!=''){
            //    echo json_encode(array('Err'=>1,'Msg'=>$returndata['Err']));
            //}else{
            //save to database
            $locationfile = ''; //'./dataupload/idealkarytk/' .  $returndata['filename'];
            $param = array($idkry, 0, $upideal, $locationfile, $this->session->userdata('userid'), $idsubjabatan);

            $query = $this->M_configpermintaan->UpdateIdealKaryawan_($param);
            echo json_encode(array('Err' => 0, 'Msg' => 'Data berhasil diupdate'));
            // }   
        }
    }
    public function updatedatakry()
    {
        $ndata = $this->input->raw_input_stream;
        $idkry = $this->input->post('idkry');
        $upideal = $this->input->post('txtidealtkry');
        $upideal = preg_replace("/[^0-9]/", "", $upideal);
        $deptname = decode_str($idkry);

        if (!is_numeric($idkry)) {
            echo json_encode(array('Err' => 1, 'Msg' => 'Data format departemen salah-- tk silahkan refresh dan coba kembali'));
        } else {
            //save file first
            //$returndata = $this->UpLoadFile('txtmemotk','./dataupload/idealkarytk/','pdf');
            //if($returndata['Err']!=''){
            //    echo json_encode(array('Err'=>1,'Msg'=>$returndata['Err']));
            //}else{
            //save to database
            $locationfile = ''; //'./dataupload/idealkarytk/' .  $returndata['filename'];
            $param = array($idkry, 1, $upideal, $locationfile, $this->session->userdata('userid'));

            $query = $this->M_configpermintaan->UpdateIdealKaryawan_($param);
            echo json_encode(array('Err' => 0, 'Msg' => 'Data berhasil diupdate'));
            // }   
        }
    }

    public function monitoringmemo()
    {
        $cssadd = array('sweetalert.css', 'bootstrap-select.min.css', 'addcss/buttons.bootstrap.min.css', 'addcss/fixdb.css');
        // $jsadd = array(
        //     'jsadd/autoNumeric.min.js', 'jsadd/sweetalert.min.js', 'jsadd/bootstrap-select.min.js', 'jsadd/underscore-min.js', 'jsadd/backbone-min.js', 'jsadd/backdatatableserver2.js',
        //     'jsadd/configpermintaan/monitorpermintaan.js'
        // );
        $jsadd = array(
            'jsadd/autoNumeric.min.js', 'jsadd/sweetalert.min.js', 'jsadd/bootstrap-select.min.js', 'jsadd/underscore-min.js', 'jsadd/backbone-min.js', 'jsadd/backdatatableserver2.js',

        );

        if ($this->session->userdata('userid') == 'KIKI') {
            $this->template2->display('utility/permintaan/monitormemopermintaan', array('jsadd' => $jsadd, 'cssadd' => $cssadd));
        } else {
            $this->template2->display('utility/permintaan/monitormemopermintaan', array('jsadd' => $jsadd, 'cssadd' => $cssadd));
        }
    }

    public function viewmemos()
    {
        $id = $this->input->get('idmemo');
        $eid = decode_str($id);
        $filedoc = $this->M_configpermintaan->getfilememo($eid);
        $myfile = FCPATH . 'dataupload/idealkarytk/' . basename($filedoc);
        $cssadd = array('sweetalert.css', 'bootstrap-select.min.css', 'addcss/buttons.bootstrap.min.css', 'addcss/fixdb.css');
        $jsadd = array(
            'jsadd/autoNumeric.min.js', 'jsadd/sweetalert.min.js', 'jsadd/bootstrap-select.min.js', 'jsadd/underscore-min.js', 'jsadd/backbone-min.js',
            'jsadd/configpermintaan/viewmonper.js'
        );
        $data['_pesanerror'] = 0;
        $data['jsadd'] = $jsadd;
        $data['cssadd'] = $cssadd;
        if (file_exists($myfile)) {
            $doc64 = base64_encode(file_get_contents($myfile));
            $data['_datapdf'] = $doc64;
        } else {
            $data['_pesanerror'] = 'File memo tidak ditemukan !!';
        }
        $this->template2->display('utility/permintaan/viewmemopermintaan.php', $data);
    }

    public function getmonitormemo()
    {
        $param = $this->GetRequestFromDataTable();
        array_unshift($param['coreorder'], 'IDMemo');
        $param['coreorder'] = array('IDMemo', 'IDMemo', 'Doc', 'DeptAbbr', 'IsKry', 'Jumlah', 'IsComplete', 'CreatedDate');
        $param['coresearch'] = 'IDMemo like @1 OR DeptAbbr like @1 OR Doc like @1';
        $deptlist = $this->M_grupDept->getDeptAbbrFromGrupBor($this->session->userdata('groupuser'));
        $daftardept = array();
        foreach ($deptlist as $val) {
            $daftardept[] = $val->DeptAbbr;
        }
        $param['deptlist'] = implode("','", $daftardept);
        $query = $this->M_configpermintaan->getMonitoringMemos($param);
        echo json_encode($query);
    }

    public function viewmemo()
    {
        $id = $this->input->get('idmemo');
        if (null != $id) {
            $query = $this->M_configpermintaan->getfilememo(array($id));
            $row = $query->row();
            $data['_dataHeader'] = $row;
            $data['_dataContent'] = '';
            $this->load->library(array('Fpdf'));
            $this->load->view('utility/permintaan/viewmemopermintaan', $data);
        } else {
            echo json_encode(array('pesan' => 'data memo tidak ditemukan!'));
        }
    }

    //inpui memo dari dept
    public function memopermintaan()
    {
        $cssadd = array('sweetalert.css', 'bootstrap-select.min.css', 'addcss/buttons.bootstrap.min.css', 'addcss/fixdb.css');
        $jsadd = array(
            'jsadd/autoNumeric.min.js', 'jsadd/sweetalert.min.js', 'jsadd/bootstrap-select.min.js', 'jsadd/underscore-min.js', 'jsadd/backbone-min.js', 'jsadd/backdatatableserver2.js',
            'jsadd/configpermintaan/inputpermintaandept.js'
        );
        $dept = $this->M_grupDept->getDept($this->session->userdata('groupuser'));

        $data['jsadd'] = $jsadd;
        $data['cssadd'] = $cssadd;
        $data['dept'] = $dept;
        $this->template2->display('utility/permintaan/memoidealdept', $data);
    }
    //post dari ddept 
    public function updatedatakrytk()
    {
        $ndata   = $this->input->raw_input_stream;
        $dept    = $this->input->post('selectdept');
        $noref   = $this->input->post('txtnoref');
        $tipe    = $this->input->post('selecttipe');
        $jumlah  = $this->input->post('txttotalideal');
        $alasan  = $this->input->post('txtketerangan');
        if ($noref == '')
            $noref = '0';

        if ($tipe == 'tk')
            $iskry = 0;
        else
            $iskry = 1;

        //$param = array(0,$noref,$dept,$iskry,$this->session->userdata('userid'),$jumlah,$alasan);
        $param = array($dept, $iskry, $alasan, $this->session->userdata('userid'), $jumlah);
        $query = $this->M_configpermintaan->UpdateMemo($param);
        $row = $query->row();
        echo json_encode(array('Err' => 0, 'Msg' => 'Data berhasil diupdate', 'ref' => $row->Ref));
    }
    //update memo dari psn
    public function updatememo()
    {
        $ref = $this->input->get('noref');
        $ref = decode_str($ref);

        $datakuota = $this->M_configpermintaan->getmstkuotapermintaan($ref);
        $datareal = $this->M_configpermintaan->getkuotapermintaanbydept($datakuota->DeptAbbr, $datakuota->IsKry);

        $cssadd = array('sweetalert.css', 'bootstrap-select.min.css', 'addcss/buttons.bootstrap.min.css', 'addcss/fixdb.css');
        $jsadd = array('jsadd/autoNumeric.min.js', 'jsadd/sweetalert.min.js', 'jsadd/bootstrap-select.min.js');
        $data['jsadd'] = $jsadd;
        $data['cssadd'] = $cssadd;
        $data['datamemo'] = $datakuota;
        $data['datareal'] = $datareal->row();
        $this->template2->display('utility/permintaan/vpermintaan', $data);
    }

    //receive post data from updatememo by ps
    public function updatedatamemopsn()
    {
        $allpostdata = $this->input->post(NULL, TRUE);
        if ($allpostdata['noref'] != '') {
            $row = $this->M_configpermintaan->getmstkuotapermintaan($allpostdata['noref']);
            $param = array(
                $row->ForDept,
                $row->IsKry,
                $allpostdata['stxtidealkry'],
                '',
                $this->session->userdata('username'),
                $allpostdata['noref']
            );
            $query = $this->M_configpermintaan->UpdateIdealKaryawan($param);

            $row = $query->row();
            if ($row->Err == 0) {
                $this->session->set_flashdata('Msg', 'Proses update noref ' .  $allpostdata['noref'] . ' berhasil');
            } else {
                $this->session->set_flashdata('Msg', 'Proses update noref ' . $allpostdata['noref'] . ' gagal ');
            }
        } else {
            $this->session->set_flashdata('Msg', 'Proses update noref ' . $allpostdata['noref'] . ' gagal, data tidak ditemukan ');
        }
        redirect('configpermintaan/monitoringmemo');
    }

    function getDataIdeal()
    {
        $dept = $this->input->post('selDept');
        $dataideal = $this->M_configpermintaan->getdataIdeal($dept);
        foreach ($dataideal as $row) {
            $data1 = $row['IKry'];
            $data2 = $row['IBor'];
            echo $data1 . ", " . $data2;
        }
    }

    // #####################################################################################

    public function show()
    {

        if ($this->input->is_ajax_request()) {
            //  
            $list = $this->M_configpermintaan->get_datatables();
            $data = array();
            $no   = $_POST['start'];
            foreach ($list as $field) {


                if ($field->IsKry == '1') {
                    $isKry = 'Kry';
                    $jumlah = $field->Jumlah . ' ' . $isKry;
                } else {
                    $isKry = 'Tk';
                    $jumlah = $field->Jumlah . ' ' . $isKry;
                }

                if ($field->IsComplete == '1') {
                    $isComplete = 'Sudah Complete';
                    $opsi = '';
                } else {
                    $isComplete = 'Belum Complete';
                    $opsi = '<a href="' . base_url() . "configpermintaan/updatememo?noref="
                        . encode_str($field->IDMemo) . '" class="btn btn-primary btn-sm btn-icon">Edit</a>';
                }

                $tanggal = '<div class="text-right smaller-80">' . $field->CreatedDate . '</div>';
                $s = '<a target="_blank" href="./viewmemo?idmemo=' . $field->IDMemo . '" class="btncollapse btninfo btn btn-icon btn-xs btnnoborder btnnobackground">Memo</a>';

                $no++;
                $row   = array();
                $row[] = $opsi;
                $row[] = $field->IDMemo;
                $row[] = $field->Doc;
                $row[] = $field->DeptAbbr;
                $row[] = $isKry;
                $row[] = $jumlah;
                $row[] = $isComplete .  $tanggal;
                // $row[] = $tanggal;
                $row[] = $s;

                $data[] = $row;
            }

            $output = array(
                "draw"            => $_POST['draw'],
                "recordsTotal"    => $this->M_configpermintaan->count_all(),
                "recordsFiltered" => $this->M_configpermintaan->count_filtered(),
                "data"            => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        }
    }

    // ####################################################################
    public function show_bor()
    {

        if ($this->input->is_ajax_request()) {
            $list = $this->M_configpermintaan->get_datatables_bor();
            $data = array();
            $no   = $_POST['start'];
            foreach ($list as $field) {

                $no++;
                $row   = array();
                $row[] = $field->DeptAbbr;
                $row[] = $field->IBor;
                $row[] = $field->RBor;
                $row[] = $field->IDSubJabatan;
                $row[] = $field->SubJabatanAbbr;
                $row[] = $field->PERMINTAANBORApp;
                $row[] = $field->PERMINTAANBORPending;
                $row[] = $field->bperiode;
                $row[] = $field->UpdatedBy;
                $row[] = $field->UpdatedDate;
                $row[] = $field->DeptBor;
                $data[] = $row;
            }

            $output = array(
                "draw"            => $_POST['draw'],
                "recordsTotal"    => $this->M_configpermintaan->count_all_bor(),
                "recordsFiltered" => $this->M_configpermintaan->count_filtered_bor(),
                "data"            => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        }
    }

    public function show_kry()
    {

        if ($this->input->is_ajax_request()) {
            $list = $this->M_configpermintaan->get_datatables_kry();
            $data = array();
            $no   = $_POST['start'];
            foreach ($list as $field) {

                $no++;
                $row   = array();
                $row[] = $field->DeptAbbr;
                $row[] = $field->IKry;
                $row[] = $field->RKry;
                $row[] = $field->PERMINTAANKARApp;
                $row[] = $field->PERMINTAANKARPending;
                $row[] = $field->bperiode;
                $row[] = $field->UpdatedBy;
                $row[] = $field->UpdatedDate;
                $row[] = $field->DeptKry;
                $data[] = $row;
            }

            $output = array(
                "draw"            => $_POST['draw'],
                "recordsTotal"    => $this->M_configpermintaan->count_all_kry(),
                "recordsFiltered" => $this->M_configpermintaan->count_filtered_kry(),
                "data"            => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        }
    }

    public function show_kry_new()
    {

        if ($this->input->is_ajax_request()) {
            $list = $this->M_configpermintaan->get_datatables_kry_new();
            $data = array();
            $no   = $_POST['start'];
            foreach ($list as $field) {

                $no++;
                $row   = array();
                $row[] = $field->DeptAbbr;
                $row[] = $field->IKry;
                $row[] = $field->RKry;
                $row[] = $field->RBor;
                $row[] = $field->TotalKryTk;
                $row[] = $field->SubJabatanKry ? $field->SubJabatanKry : ($field->SubJabatanTk ? $field->SubJabatanTk : $field->SubJabatanKry);
                $row[] = $field->jumlah;
                $row[] = $field->PERMINTAANKARApp;
                $row[] = $field->PERMINTAANKARPending;
                $row[] = $field->PERMINTAANBORApp;
                $row[] = $field->PERMINTAANBORPending;
                $row[] = $field->Periode;
                $row[] = $field->UpdatedBy;
                $row[] = $field->UpdatedDate;
                $row[] = $field->ID;
                $data[] = $row;
            }

            $output = array(
                "draw"            => $_POST['draw'],
                "recordsTotal"    => $this->M_configpermintaan->count_all_kry_new(),
                "recordsFiltered" => $this->M_configpermintaan->count_filtered_kry_new(),
                "data"            => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        }
    }

    function update()
    {
        $idkry = $this->input->post('idkry');
        $txtidealtkry = $this->input->post('txtidealtkry');

        $data = [
            'IDEALKARYAWAN' => $txtidealtkry,
            'UpdatedBy'    => $this->session->userdata('userid'),
            'UpdatedDate'  => date('Y-m-d H:i:s'),
        ];

        $isUpdated = $this->M_configpermintaan->update_data_kry($idkry, $data);

        if ($isUpdated) {
            echo json_encode([
                'status' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Update gagal'
            ]);
        }
    }

    // function importExcel()
    // {

    //     $this->load->library("Excel/PHPExcel");

    //     if (!isset($_FILES['file_excel']['name'])) {
    //         echo "<div class='alert alert-danger'>File tidak ditemukan</div>";
    //         return;
    //     }

    //     $file = $_FILES['file_excel']['tmp_name'];
    //     $objPHPExcel = PHPExcel_IOFactory::load($file);
    //     $sheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

    //     $data = [];
    //     foreach ($sheet as $index => $row) {
    //         if ($index == 1 || $index == 2) continue; // Lewati header
    //         $data[] = [
    //             'dept' => $row['B'],
    //             'nama_sub' => $row['C'],
    //             'A' => $row['D'],
    //             'B' => $row['E'],
    //             'C' => $row['F'],
    //             'D' => $row['G'],
    //             'E' => $row['H'],
    //             'F' => $row['I'],
    //             'G' => $row['J'],
    //             'H' => $row['K'],
    //             'I' => $row['L'],
    //             'J' => $row['M'],
    //             'K' => $row['N'],
    //         ];
    //     }

    //     $insert = $this->M_configpermintaan->insert_batch($data);
    //     if ($insert) {
    //         $this->db->query(
    //             "EXEC sp_InsertKuotaPermintaan ?, ?",
    //             [date('Y'), $this->session->userdata('userid')]
    //         );
    //     }

    //     $this->db->trans_complete();

    //     if ($this->db->trans_status() === FALSE) {
    //         echo "<div class='alert alert-danger'>Gagal proses.</div>";
    //     } else {
    //         echo "<div class='alert alert-success'>Import & SP berhasil.</div>";
    //     }
    // }

    function importExcel()
    {
        if (!isset($_FILES['file_excel']['name']) || empty($_FILES['file_excel']['tmp_name'])) {
            echo "<div class='alert alert-danger'>File tidak ditemukan</div>";
            return;
        }

        $file = $_FILES['file_excel']['tmp_name'];

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        } catch (\Exception $e) {
            echo "<div class='alert alert-danger'>Gagal baca file: " . $e->getMessage() . "</div>";
            return;
        }

        $data = [];
        foreach ($sheet as $index => $row) {
            if ($index == 1 || $index == 2) continue; // Lewati header

            // Skip baris kosong
            if (empty($row['B']) && empty($row['C'])) continue;

            $data[] = [
                'dept'     => $row['B'],
                'nama_sub' => $row['C'],
                'A' => $row['D'],
                'B' => $row['E'],
                'C' => $row['F'],
                'D' => $row['G'],
                'E' => $row['H'],
                'F' => $row['I'],
                'G' => $row['J'],
                'H' => $row['K'],
                'I' => $row['L'],
                'J' => $row['M'],
                'K' => $row['N'],
            ];
        }

        if (empty($data)) {
            echo "<div class='alert alert-warning'>Tidak ada data untuk diimport.</div>";
            return;
        }

        $this->db->trans_start();

        $this->M_configpermintaan->insert_batch($data);

        $this->db->query(
            "EXEC sp_InsertKuotaPermintaan ?, ?",
            [date('Y'), $this->session->userdata('userid')]
        );

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo "<div class='alert alert-danger'>Gagal proses.</div>";
        } else {
            echo "<div class='alert alert-success'>Import & SP berhasil.</div>";
        }
    }
}
