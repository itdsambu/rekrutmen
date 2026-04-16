<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class calon_kandidat extends CI_Controller{
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
        $this->load->model('m_calon_kandidat');
        }

	function index(){
        $idpemborong = $this->session->userdata('idpemborong');
        if($idpemborong == NULL){
            $data['get_dataPemborong'] = $this->m_calon_kandidat->get_pemborong();
        }else{
            $data['get_dataPemborong'] = $this->m_calon_kandidat->getPemborong($idpemborong);
        }
		$this->template->display('registrasi/registrasi_calonkandidat/index',$data);
	} 
}