<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_onelogin_logout extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library(array('user_agent'));
        $browser    = $this->agent->browser();
        if($browser == 'Internet Explorer'){
            redirect(site_url('maintenanceControl/notSupport'));
        }
        
        date_default_timezone_set("Asia/Jakarta");
        if($this->session->userdata('userid')){
            //redirect('welcome');
        }
    }

    public function index(){
        $this->load->model('m_login');
        $signid = $this->session->userdata('signid');

        if ($signid <> ''){
                $this->m_login->simpan_log_out($signid);
        }

        $this->session->unset_userdata('userid');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('groupuser');
        $this->session->unset_userdata('teamscreen');
        $this->session->unset_userdata('dept');
        $this->session->unset_userdata('idpemborong');
        $this->session->unset_userdata('pemborong');
        $this->session->sess_destroy();
        echo '<script>window.close();</script>';
        echo '<div align="center" style="width:100%;background-color:#F08519;"><img height="100%" src="'.base_url().'/assets/out.png" alt=""></div>';
        //redirect('login/loginnew');
    }

    function invalidaccess() {
        $this->session->sess_destroy();
        echo '<div align="center" style="width:100%;background-color:#F08519;"><img height="100%" src="'.base_url().'/assets/403.png" alt=""></div>';
        exit();
    } 
	
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */