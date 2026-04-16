<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class Panggilan extends CI_Controller{
    
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
        $this->load->model(array('m_panggilan'));
    }
    
    public function index(){
        $data['getListTK'] = $this->m_panggilan->getListTK();
        $this->template->display('registrasi/panggilan/index',$data);
    }
    
    function panggilAksi(){
        if(isset($_POST['Panggil'])){
            $checked = $this->input->post('checkPanggil');
            $itung = count($checked);
            for($i=0; $i<$itung; $i++){
                $this->m_panggilan->updateGeneralStatus($checked[$i]);
            }
            redirect(site_url('panggilan/index'));
        }
        elseif (isset($_POST['Cancel'])) {
            $checked = $this->input->post('checkPanggil');
            $itung = count($checked);
            for($i=0; $i<$itung; $i++){
                $this->m_panggilan->batalPanggil($checked[$i]);
            }
            redirect(site_url('panggilan/index'));
        }
        
    }
    
    function detailtk(){
        if('IS_AJAX') {
        $kode=$this->input->post('kode');
        $data['datatk'] = $this->m_panggilan->get_detailtk($kode)->result();
        $this->load->view('registrasi/panggilan/detail',$data);
        }
    }
}

/* End of file panggilan.php */
/* Location: ./application/controllers/panggilan.php */