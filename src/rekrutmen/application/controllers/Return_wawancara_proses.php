<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD24
 */

class Return_wawancara_proses extends CI_Controller{
    
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
        
        $this->load->model('M_Return_wawancara_proses');
    }

    function index(){
        $data['_getFormID']      = $this->input->get('id');
        $data['_getData'] = $this->M_Return_wawancara_proses->get_dataGagalWawancaraProses();
        $this->template->display('returndata/wawancara_proses/index',$data);
    }

    function simpan_return(){
        $headerid = $this->uri->segment(3);

        $data = array(
            'DeptTujuan' => NULL,
            'DeptTujuanBy' => NULL,
            'DeptTujuanDate' => NULL,
            'GeneralStatus' => 0
        );

        $this->M_Return_wawancara_proses->update($headerid,$data);
        redirect('Return_wawancara_proses');
    }
}