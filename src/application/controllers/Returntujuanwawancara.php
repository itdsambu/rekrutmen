<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class returntujuanwawancara extends CI_Controller{
    function __construct() {
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
        
        $this->load->model('m_returntujuanwawancara');
    }

    function index(){
        $data['_getFormID']         = $this->input->get('id');
        $this->template->display('returndata/return_tujuanwawancara/index',$data);
    }

    function AjaxReturnTujuanWawancara(){
    	$thn    = $this->uri->segment(3);
        $bln    = $this->uri->segment(4);

        $data['getData'] = $this->m_returntujuanwawancara->get_DataReturnTujuanWawancara($bln,$thn);

        $this->load->view('returndata/return_tujuanwawancara/list',$data);
    }

    function simpanData(){
    	$requestID = $this->input->post('txtrequestid');
    	$jmlh   = count($requestID);
        for($i=0; $i < $jmlh;$i++){
            $data = array(
                'TransID'            	=> NULL,
                'DeptTujuan'            => NULL,
                'DeptTujuanBy'          => NULL,
                'DeptTujuanDate'        => NULL,
                'DetailIdDeptTujuan'    => NULL,
            );

            // echo $requestID[$i];
            $this->m_returntujuanwawancara->simpan($requestID[$i],$data);
            redirect('returntujuanwawancara');
        }
    }
}