<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mnt_DISC extends CI_Controller{
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
        $this->load->model('M_Mnt_DISC');
        }

	function index(){

		$this->template->display('psychological_assisment/mnt_disc/index');
	} 

    function ajax_data_test(){
        $tanggal = $this->uri->segment(3);

        $data['_getDataHdr'] = $this->M_Mnt_DISC->_getDataHdr($tanggal);
        $this->load->view('psychological_assisment/mnt_disc/ajax_list',$data);
    }

    function lihat_hasil_test(){
        $id = $this->input->get('id');

        $data['_getDataHdr'] = $this->M_Mnt_DISC->_getDataHdrByID($id);
        $data['_getDataDtl'] = $this->M_Mnt_DISC->_getDataDtlByID($id);
        $data['Bag1']      = $this->M_Mnt_DISC->_hslBag1($id);
        $data['Bag2']      = $this->M_Mnt_DISC->_hslBag2($id);
        $data['Bag3']      = $this->M_Mnt_DISC->_hslBag3($id);
        $this->load->view('psychological_assisment/mnt_disc/ajax_lihat_hasil',$data);
    }

    function hasil_gambaran_diri(){
        $hdrid = $this->input->get('id');

        // echo $hdrid;

        $gambaran_diri = $this->M_Mnt_DISC->_getGambaranDiri($hdrid);
        foreach($gambaran_diri as $get){
            if($get->DISC == 'D'){
                $this->load->view('psychological_assisment/mnt_disc/gambaran_diri_D');
            }elseif($get->DISC == 'I'){
                $this->load->view('psychological_assisment/mnt_disc/gambaran_diri_I');
            }elseif($get->DISC == 'S'){
                $this->load->view('psychological_assisment/mnt_disc/gambaran_diri_S');
            }elseif($get->DISC == 'C'){
                $this->load->view('psychological_assisment/mnt_disc/gambaran_diri_C');
            }
        }
    }

    function hasil_gambaran_diriNew(){
        $hdrid = $this->input->get('id');

        // echo $hdrid;

        $gambaran_diri = $this->M_Mnt_DISC->_getGambaranDiri($hdrid);
        foreach($gambaran_diri as $get){
            if($get->DISC == 'D'){
                $this->template->display('psychological_assisment/mnt_disc/gambaran_diri_D');
            }elseif($get->DISC == 'I'){
                $this->template->display('psychological_assisment/mnt_disc/gambaran_diri_I');
            }elseif($get->DISC == 'S'){
                $this->template->display('psychological_assisment/mnt_disc/gambaran_diri_S');
            }elseif($get->DISC == 'C'){
                $this->template->display('psychological_assisment/mnt_disc/gambaran_diri_C');
            }
        }
    }
}