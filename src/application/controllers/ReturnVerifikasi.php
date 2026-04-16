<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ReturnVerifikasi extends CI_Controller{
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
        
        $this->load->model('M_returnVerifikasi');
    }

    function index(){
        $data['_getFormID']         = $this->input->get('id');
        $this->template->display('returndata/returnVerifikasi/V_index',$data);
    }

    function AjaxReturnVerifikasi(){
        $thn    = $this->uri->segment(3);
        $bln    = $this->uri->segment(4);

        $data['getData'] = $this->M_returnVerifikasi->getData($bln,$thn);

        $this->load->view('returndata/returnVerifikasi/V_list',$data);
    }

    function simpanData(){
        $requestID = $this->input->post('txtrequestid');
        $jmlh   = count($requestID);
        for($i=0; $i < $jmlh;$i++){
            $data = array(
                'Verified'               => NULL,
                'VerifiedBy'            => NULL,
                'VerifiedDate'          => NULL,
            );

            // echo $requestID[$i];
            $this->M_returnVerifikasi->simpan($requestID[$i],$data);
        }
           redirect('returnVerifikasi');

    }

}