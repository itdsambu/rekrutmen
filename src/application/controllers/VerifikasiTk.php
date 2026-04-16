<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class VerifikasiTk extends CI_Controller{
    
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
        
        $this->load->model('M_VerifikasiTk');
    }

    function index(){

    	$this->template->display('registrasi/verifikasi_tk/index');
    }
}