<?php if (! defined('BASEPATH')) exit ('No direct script access allowed');

/**
 *  ITD 31
 */
class MonitoringPsychological extends CI_Controller
{
	
	public function __construct()
	{
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
        
        $this->load->model('m_MonitoringPsychological');
	}

	function index(){
        $data['list'] = $this->m_MonitoringPsychological->getList();
		$this->template->display('monitoringPsychological/index', $data);
	}

	function getKaryawan(){
        $nama = $this->uri->segment(3);
        $data['getData']  = $this->m_MonitoringPsychological->getKaryawan($nama);
        $this->load->view('monitoringPsychological/ajaxCari',$data);
    }

    function getNama(){
        $id = $this->uri->segment(3);
        // $data['getLogin'] = $this->m_MonitoringPsychological->getPrivacy();
        $data['getDuration'] = $this->m_MonitoringPsychological->getPsychologyData($id);
        $data['getData']  = $this->m_MonitoringPsychological->getPsycho($id);
        $this->load->view('monitoringPsychological/getNama',$data);
        // echo "<pre>";
        // print_r($data);
        // echo "<pre>";
    }
}