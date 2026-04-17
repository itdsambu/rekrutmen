<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class ScreeningByTim extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model(array('darurat','m_dashboard'));
        $status = $this->darurat->getStatus();
        if($status === 1 && $this->session->userdata('userid') !=='ismo_adm'){
            redirect(site_url('maintenanceControl'));
        }
        
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('userid')){
            redirect('login');
        }
        
        $screenTeam = $this->m_dashboard->getStatusScreenTeam();
        $dept   = $this->session->userdata('dept');
        $cekDept    = $this->m_dashboard->getDeptScreenTeam($dept);
        if($screenTeam == 0 || $cekDept == FALSE && $this->session->userdata('userid') != 'jamal'){
            redirect('welcome/notAksesScreen');
        }
        
        $this->load->model('m_screening');
    }
    
    public function index(){
        $nowOL = $this->session->userdata('username');
        $dept   = $this->session->userdata('dept');
        $data['_getTK'] = $this->m_screening->listTenagaKerja($nowOL,$dept);
        $this->template->display('registrasi/screening/tim',$data);
    }
    
    function screenTim(){
        if('IS_AJAX') {
        $kode=$this->input->post('kode');
        $data['datatk'] = $this->m_screening->getDetailTK($kode)->result();
        $data['hasilLulus'] = $this->m_screening->getHasilLulus($kode);
        $data['hasilTLulus'] = $this->m_screening->getHasilTIdakLulus($kode);
        $this->load->view('registrasi/screening/screenTim',$data);
        }
    }
    
    function simpan(){
        $data = array(
            'HeaderID'      => $this->input->post('txtHeaderID'),
            'Dept'          => $this->input->post('txtDept'),
            'ScreeningBy'   => $this->input->post('txtName'),
            'ScreeningDate' => date('Y-m-d H:m:i'),
            'ScreeningKet'  => $this->input->post('txtKeterangan'),
            'Kenal'         => $this->input->post('txtKenal'),
            'PernahKerja'   => $this->input->post('txtKerja'),
            'Lulus'         => $this->input->post('txtRekomen'),
            'Jeda'          => $this->input->post('txtJeda')
        );
        
        $this->m_screening->simpanScreeningTim($data);
        
        $hrdID  = $this->input->post('txtHeaderID');
        $lulus  = $this->m_screening->getHasilLulus($hrdID);
        $gagal  = $this->m_screening->getHasilTIdakLulus($hrdID);
        
        if($lulus >= $gagal){
            $info   = array (
                'ScreeningHasil' => 1
                );
            $this->m_screening->updateLulus($hrdID, $info);
        }else{
            $info   = array (
                'ScreeningHasil' => 0
                );
            $this->m_screening->updateLulus($hrdID, $info);
        }
        $hasilScreen = $this->m_screening->getHasilScreen($hrdID);
        
        if($hasilScreen == 'complite'){
            $info   = array (
                'ScreeningComplete' => 1
                );
            $this->m_screening->updateLulus($hrdID, $info);
        }
        
        redirect('screeningByTim/index?msg=Success');
    }


    // ========= List Tenaga KErja
    function detailtk(){
        if('IS_AJAX') {
        $kode=$this->input->post('kode');
        $data['datatk'] = $this->m_screening->getDetailTK($kode)->result();
        $this->load->view('registrasi/screening/detail',$data);
        }
    }
}

/* End of file screeningByTim.php */
/* Location: ./application/controllers/screeningByTim.php */