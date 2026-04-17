<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class blacklistpsg extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model(array('darurat','m_blacklistpsg'));
//        $status = 1;
        $status = $this->darurat->getStatus();
        if($status === 1 && $this->session->userdata('userid') !=='ismo_adm'){
            redirect(site_url('maintenanceControl'));
        }
        
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('userid')){
            redirect('login');
        }
        $this->load->library(array('template','form_validation'));
    }
}
