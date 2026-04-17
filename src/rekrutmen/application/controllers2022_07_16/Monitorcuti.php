<?php defined('BASEPATH') OR exit('No direct script access allowed');


require_once APPPATH . 'core/BaseController.php';

class Monitorcuti extends BaseController{

    protected function loadingmodel(){
        $this->load->model('Mdl_Monitorcuti');
    }


    public function index(){
        $data['_addcss'] =array('css/datatables.min.css','css/cuti.css');

        $tblparam = $this->datatablesql->data_html('tblmonitorsisacuti','tblsisacuti','./monitorcuti/getmonitorsisacuti','sisacuticol'
		        ,function(){
					$rowhead = array('Regno','Nik','Nama','Dept','Jabatan','Tgl.Masuk','Periode Akhir','Jatah Cuti','Sisa Cuti');
					return $rowhead;
				}				
				,function(){
					$arcol = array(
					              array('data'=>'RegNo'),	
								  array('data'=>'NIK','className'=>'text-center'),
								  array('data'=>'NAMA'),
								  array('data'=>'DeptName'),
								  array('data'=>'JabatanName'),
								  array('data'=>'TGLMASUK','className'=>'text-center'),
								  array('data'=>'CurrentPeriode','className'=>'text-center'),
								  array('data'=>'JC','className'=>'text-center'),
								  array('data'=>'SISACUTI','className'=>'text-center')								  
					          );
					return $arcol;
				});
		$data['_dbtable'] = $tblparam;		

        $this->template->display('karyawan/cuti_izin/monitorsisacuti',$data);
    }

    public function monitorsisacuti(){
        redirect('monitorcuti');
    }

    public function getmonitorsisacuti(){
        $param = $this->GetRequestFromDataTable();
        $query = $this->Mdl_Monitorcuti->getmonitorsisacuti($param);
        echo json_encode($query);
        
    }

}