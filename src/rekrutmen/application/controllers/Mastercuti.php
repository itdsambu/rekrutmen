<?php defined('BASEPATH') OR exit('No direct script access allowed');


require_once APPPATH . 'core/BaseController.php';

class Mastercuti extends BaseController{


    protected function loadingmodel(){
        $this->load->model('Mdl_Mastercuti');
    }

    function index(){
        $data['_addcss'] =array('css/datatables.min.css','css/cuti.css','css/bootstrap-select.min.css','css/sweetalert2.min.css');
        $tblparam = $this->datatablesql->data_html('tblmonmastercuti','tblmstcuti','./getmastercutidata','mstcuticol',
                           function(){
                               $tableheader = array('Nik','Nama','Tgl Masuk','Dept','Jabatan','Periode','Jatah Cuti','Sisa Cuti');
                               return $tableheader;
                           },
                           function(){
                               $ardata = array(
                                array('data'=>'NIK'),	
                                array('data'=>'NAMA'),    
                                array('data'=>'TGLMASUK'),                           
                                array('data'=>'DeptAbbr'),
                                array('data'=>'JabatanName','className'=>'text-center'),
                                array('data'=>'Periode','className'=>'text-center'),
                                array('data'=>'JatahCuti','className'=>'text-center'),
                                array('data'=>'SisaCuti','className'=>'text-center')
                               );
                               return $ardata;
                           }                            
                    );
        $data['_dbtable'] = $tblparam;	
        $datacuti = $this->Mdl_Mastercuti->getyearcuti();
        $data['_dbyearcuti'] = $datacuti;
        $this->template->display('karyawan/master/cuti/viewcuti',$data);
    }

    function getmastercutidata(){
        $param = $this->GetRequestFromDataTable();
        $param['coresearch'] = 'NIK LIKE @1 OR NAMA LIKE @1 OR DeptAbbr LIKE @1';
        $query = $this->Mdl_Mastercuti->get_mastercutidb($param);
        echo json_encode($query);
    }

    function updatecuti(){
        $model = json_decode($this->input->post('model'));
        $id = decode_str($model->id);
        $periode = $model->pd;
        $jatahcuti = $model->jc;
        $sisacuti=$model->sc;
        $user=$this->session->userdata('u_user');
        if($jatahcuti=='') $jatahcuti = 0;
        if($sisacuti=='') $sisacuti = 0;
        $param = array($id,$periode,$jatahcuti,$sisacuti,$user);
        $row = $this->Mdl_Mastercuti->update_jatahcuti($param);
        echo json_encode(array('Err'=>$row->Err));
    }

    function findnik(){
        $nik = $this->input->get('nik');
        $periode = $this->input->get('periode');
        if(is_numeric($nik)==false){
			$data = array('Err'=>1,'Msg'=>'NIK harus dalam format numerik ' . $nik);
			echo json_encode($data);
			return;
		}	
        $findnik = $this->Mdl_Mastercuti->find_kry($nik,$periode);
        if($findnik->num_rows()>0){
            $hasil = $findnik->result_array();
            $hasil[0]['idrow'] =encode_str($hasil[0]['NIK']);
            $data = array('Err'=>0,'data'=>$hasil);				
            echo json_encode($data);
          }else{
            $data = array('Err'=>1,'Msg'=>'Data Karyawan tidak ditemukan');
            echo json_encode($data);	
          }
    }

}