<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by Heriyanto
 */

require_once APPPATH . 'core/BaseController.php';

class Configpermintaan extends BaseController
{    
	
	protected function loadingmodel(){
        $this->load->model('M_configpermintaan');
        $this->load->model('M_grupDept');
        $this->load->model('M_user_login');
	}

    public function setpermintaan(){
        redirect('configpermintaan/index');
    }

    public function index(){
        $cssadd = array('sweetalert.css','bootstrap-select.min.css','addcss/buttons.bootstrap.min.css','addcss/fixdb.css');
        $jsadd = array('jsadd/autoNumeric.min.js','jsadd/sweetalert.min.js','jsadd/bootstrap-select.min.js','jsadd/underscore-min.js','jsadd/backbone-min.js'
                       ,'jsadd/backdatatableserver2.js',
		               'jsadd/configpermintaan/configpermintaan.js');
        $this->template2->display('utility/permintaan/viewconfigpermintaan',array('jsadd'=>$jsadd,'cssadd'=>$cssadd));
    }

    public function monitorpermintaanbydept(){
        $cssadd = array('sweetalert.css','bootstrap-select.min.css','addcss/buttons.bootstrap.min.css','addcss/fixdb.css');
        $jsadd = array('jsadd/autoNumeric.min.js','jsadd/sweetalert.min.js','jsadd/bootstrap-select.min.js','jsadd/underscore-min.js','jsadd/backbone-min.js'
                       ,'jsadd/backdatatableserver2.js',
                       'jsadd/configpermintaan/configpermintaanbydept.js');       
        $data['jsadd']=$jsadd;
        $data['cssadd']=$cssadd;
        $this->template2->display('utility/permintaan/viewconfigpermintaanbydept',$data);        
    }

    public function getdatacountkrytk(){
        $param = $this->GetRequestFromDataTable();
        $query = $this->M_configpermintaan->getdatavwkaryawan($param);
        echo json_encode($query);
    }

    public function getdatacountkrytkdept(){
        $param = $this->GetRequestFromDataTable();
        $dept = $this->M_user_login->getDept();
        $deptlist = $this->M_grupDept->getDeptAbbrFromGrup($this->session->userdata('groupuser'));        
        $daftardept=array();
        foreach($deptlist as $val){
            $daftardept[] = $val->DeptAbbr;
        }
        $adata = implode("','",$daftardept);
        $param['dept'] = $adata;
        $query = $this->M_configpermintaan->getdatavwkaryawandept($param);
        echo json_encode($query);
    }

    public function updatedata(){
        $ndata = $this->input->raw_input_stream;
        $idkry= $this->input->post('idkrydept');
        $upideal = $this->input->post('stxtidealkry');
        $upideal = preg_replace("/[^0-9]/", "", $upideal);
        $deptname = decode_str($idkry);
        if ( !is_numeric($deptname) ) {
            echo json_encode(array('Err'=>1,'Msg'=>'Data format departemen salah-- silahkan refresh dan coba kembali'));
        }else{
            //save file first
            $returndata = $this->UpLoadFile('stxtmemokry','./dataupload/idealkarytk/','pdf');
            if($returndata['Err']!=''){
                echo json_encode(array('Err'=>1,'Msg'=>$returndata['Err']));
            }else{
                //save to database
                $locationfile = './dataupload/idealkarytk/' .  $returndata['filename'];
                $param = array($deptname,1,$upideal,$locationfile,$this->session->userdata('userid'));
                $query = $this->M_configpermintaan->UpdateIdealKaryawan($param);
                echo json_encode(array('Err'=>0,'Msg'=>'Data berhasil diupdate'));
            }   
        }
    }

    public function updatedatatk(){
        $ndata = $this->input->raw_input_stream;
        $idkry= $this->input->post('idkrrybor');
        $upideal = $this->input->post('txtidealtks');
        $deptname = decode_str($idkry);

        if ( !is_numeric($deptname) ) {
            echo json_encode(array('Err'=>1,'Msg'=>'Data format departemen salah-- tk silahkan refresh dan coba kembali'));
        }else{
            //save file first
            $returndata = $this->UpLoadFile('txtmemotk','./dataupload/idealkarytk/','pdf');
            if($returndata['Err']!=''){
                echo json_encode(array('Err'=>1,'Msg'=>$returndata['Err']));
            }else{
                //save to database
                $locationfile = './dataupload/idealkarytk/' .  $returndata['filename'];
                $param = array($deptname,0,$upideal,$locationfile,$this->session->userdata('userid'));
                $query = $this->M_configpermintaan->UpdateIdealKaryawan($param);
                echo json_encode(array('Err'=>0,'Msg'=>'Data berhasil diupdate'));
            }   
        }
    }

    public function monitoringmemo(){
        $cssadd = array('sweetalert.css','bootstrap-select.min.css','addcss/buttons.bootstrap.min.css','addcss/fixdb.css');
        $jsadd = array('jsadd/autoNumeric.min.js','jsadd/sweetalert.min.js','jsadd/bootstrap-select.min.js','jsadd/underscore-min.js','jsadd/backbone-min.js'
                       ,'jsadd/backdatatableserver2.js',                       
                       'jsadd/configpermintaan/monitorpermintaan.js');
        $this->template2->display('utility/permintaan/monitormemopermintaan.php',array('jsadd'=>$jsadd,'cssadd'=>$cssadd));
    }

    public function viewmemo(){
        $id = $this->input->get('idmemo');
        $eid = decode_str($id);
        $filedoc = $this->M_configpermintaan->getfilememo($eid);
        $myfile = FCPATH . 'dataupload/idealkarytk/' . basename($filedoc);
        $cssadd = array('sweetalert.css','bootstrap-select.min.css','addcss/buttons.bootstrap.min.css','addcss/fixdb.css');
        $jsadd = array('jsadd/autoNumeric.min.js','jsadd/sweetalert.min.js','jsadd/bootstrap-select.min.js','jsadd/underscore-min.js','jsadd/backbone-min.js',                       
                       'jsadd/configpermintaan/viewmonper.js');
        $data['_pesanerror']=0;
        $data['jsadd']=$jsadd;
        $data['cssadd']=$cssadd;
        if(file_exists($myfile)){          
          $doc64 = base64_encode(file_get_contents($myfile));
          $data['_datapdf']=$doc64;
        }else{
            $data['_pesanerror']='File memo tidak ditemukan !!'; 
        } 
        $this->template2->display('utility/permintaan/viewmemopermintaan.php',$data);     

    }

    public function getmonitormemo(){
        $param = $this->GetRequestFromDataTable();
        array_unshift($param['coreorder'],'IDMemo');
        $param['coreorder']=array('IDMemo','IDMemo','DeptAbbr','IsKry','Jumlah','IsComplete','UploadDate');
        $param['coresearch'] = 'IDMemo like @1 OR DeptAbbr like @1 '; 
        $deptlist = $this->M_grupDept->getDeptAbbrFromGrup($this->session->userdata('groupuser'));        
        $daftardept=array();
        foreach($deptlist as $val){
            $daftardept[] = $val->DeptAbbr;
        }
        $param['deptlist']=implode("','",$daftardept);
        $query = $this->M_configpermintaan->getMonitoringMemos($param);
        echo json_encode($query);
    }

    //inpui memo dari dept
    public function memopermintaan(){

        $cssadd = array('sweetalert.css','bootstrap-select.min.css','addcss/buttons.bootstrap.min.css','addcss/fixdb.css');
        $jsadd = array('jsadd/autoNumeric.min.js','jsadd/sweetalert.min.js','jsadd/bootstrap-select.min.js','jsadd/underscore-min.js','jsadd/backbone-min.js'
                       ,'jsadd/backdatatableserver2.js',
                       'jsadd/configpermintaan/inputpermintaandept.js');
        $dept = $this->M_grupDept->getDeptAbbrFromGrup($this->session->userdata('groupuser'));
        
        $data['jsadd']=$jsadd;
        $data['cssadd']=$cssadd;
        $data['dept']=$dept;
        $this->template2->display('utility/permintaan/memoidealdept',$data);       
    }
    //post dari ddept 
    public function updatedatakrytk(){
        $ndata = $this->input->raw_input_stream;
        $dept= $this->input->post('selectdept');
        $tipe = $this->input->post('selecttipe');
        $noref= $this->input->post('txtnoref');
        if($noref=='')
           $noref='0';
        
        if($tipe=='tk')
          $iskry=0;
        else
          $iskry=1;       


        
            //save file first
            $returndata = $this->UpLoadFile('txtupload','./dataupload/idealkarytk/','pdf');
            if($returndata['Err']!=''){
                echo json_encode(array('Err'=>1,'Msg'=>$returndata['Err']));
            }else{
                //save to database
                $locationfile = './dataupload/idealkarytk/' .  $returndata['filename'];
                $param = array($dept,$iskry,$this->session->userdata('userid'),0,$noref,$locationfile);
                $query = $this->M_configpermintaan->UpdateMemo($param);
                $row = $query->row();
                echo json_encode(array('Err'=>0,'Msg'=>'Data berhasil diupdate','ref'=>$row->Ref));
            }   
       
    }
    //update memo dari psn
    public function updatememo(){
        $ref = $this->input->get('noref');
        $ref = decode_str($ref);

        $datakuota = $this->M_configpermintaan->getmstkuotapermintaan($ref);
        $datareal = $this->M_configpermintaan->getkuotapermintaanbydept($datakuota->DeptAbbr,$datakuota->IsKry);

        $cssadd = array('sweetalert.css','bootstrap-select.min.css','addcss/buttons.bootstrap.min.css','addcss/fixdb.css');
        $jsadd = array('jsadd/autoNumeric.min.js','jsadd/sweetalert.min.js','jsadd/bootstrap-select.min.js');
        $data['jsadd']=$jsadd;
        $data['cssadd']=$cssadd;
        $data['datamemo']=$datakuota;
        $data['datareal']=$datareal->row();
        $this->template2->display('utility/permintaan/vpermintaan',$data);

    }

    //receive post data from updatememo by ps
    public function updatedatamemopsn(){
        $allpostdata = $this->input->post(NULL, TRUE);
        if($allpostdata['noref']!=''){
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
            if($row->Err==0){
                $this->session->set_flashdata('Msg','Proses update noref ' .  $allpostdata['noref'] .' berhasil');
            }else{
                $this->session->set_flashdata('Msg','Proses update noref ' . $allpostdata['noref'] . ' gagal ');
            }
        }else{
            $this->session->set_flashdata('Msg','Proses update noref ' . $allpostdata['noref'] . ' gagal, data tidak ditemukan ');
        }
        redirect('configpermintaan/monitoringmemo');
        
    }
}