<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Memopermintaan extends CI_Controller{

	public function __construct(){
        parent::__construct();
        $this->load->model(array('darurat','M_memopermintaan','M_configpermintaan'));
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

	function detailMemo(){
		if('IS_AJAX'){
            $kode = $this->input->post('kode');
            $data['_data'] = $this->M_memopermintaan->getfilememo($kode)->result();
            $this->load->view('utility/permintaan/app/memo',$data);
        }
	}
	
	function editMemo(){
		if('IS_AJAX'){
            $kode = $this->input->post('kode');
            $data['_data'] = $this->M_memopermintaan->getfilememo($kode)->result();
            $this->load->view('utility/permintaan/app/editMemo',$data);
        }
	}
	
	function updateMemo(){
		$id = $this->input->post('txtidmemo');
		$data = array(
			'Jumlah'	=> $this->input->post('txtTotal',TRUE),
			'Keterangan'=> $this->input->post('txtKet',TRUE),
		);
		$result = $this->M_memopermintaan->editMemo($id,$data);
		if($result){
			redirect('Memopermintaan/appmanagement?msg=success');
		}else{
			redirect('Memopermintaan/appmanagement?msg=failed');
		}
	}

// start Approve Pimpinan
	function apppimpinan(){
		$dept = $this->session->userdata('groupuser');
        $data['getmemodept'] = $this->M_memopermintaan->getdatamemodept($dept);
		$this->template->display('utility/permintaan/app/pimpinan',$data);
	}


	function multiApprovalDept(){
		if($this->input->post('Submit') == 'Approve'){
            $id = $this->input->post('IDMemo');
            $itung  = count($id);
            for($i=0; $i<$itung; $i++){
                $data   = array(
					'Approved1By'   => $this->session->userdata('username'),
					'Approved1Date' => date('Y-m-d H:m:i'),
					'Approved1Sts'  => 1
                ); 
                $this->M_memopermintaan->updatedata($id[$i],$data);
            }
            redirect('Memopermintaan/apppimpinan');
            
        }elseif($this->input->post('Submit') == 'Decline'){
            $id = $this->input->post('IDMemo');
            $itung  = count($id);
            for($i=0; $i<$itung; $i++){
                $data   = array(
					'Approved1By'   => $this->session->userdata('username'),
					'Approved1Date' => date('Y-m-d H:m:i'),
					'Approved1Sts'  => 2
                ); 
                $this->M_memopermintaan->updatedata($id[$i],$data);
            }
            redirect('Memopermintaan/apppimpinan');
            
        }
	}
// and Approve Pimpinan

// start Approve Divisi
	function appdivisi(){
		$dept = $this->session->userdata('groupuser');
        $data['getmemodiv'] = $this->M_memopermintaan->getdatamemodivisi($dept);
		$this->template->display('utility/permintaan/app/divisi',$data);
	}

	function multiApprovalDivisi(){
		if($this->input->post('Submit') == 'Approve'){
            $id = $this->input->post('IDMemo');
            $itung  = count($id);
            for($i=0; $i<$itung; $i++){
                $data   = array(
					'Approved2By'   => $this->session->userdata('username'),
					'Approved2Date' => date('Y-m-d H:m:i'),
					'Approved2Sts'  => 1
                ); 
                $this->M_memopermintaan->updatedata($id[$i],$data);
            }
            redirect('Memopermintaan/appdivisi');
            
        }elseif($this->input->post('Submit') == 'Decline'){
            $id = $this->input->post('IDMemo');
            $itung  = count($id);
            for($i=0; $i<$itung; $i++){
                $data   = array(
					'Approved2By'   => $this->session->userdata('username'),
					'Approved2Date' => date('Y-m-d H:m:i'),
					'Approved2Sts'  => 2
                ); 
                $this->M_memopermintaan->updatedata($id[$i],$data);
            }
            redirect('Memopermintaan/appdivisi');
            
        }
	}
// and Approve Divisi

// start Approve Management
	function appmanagement(){
		$dept = $this->session->userdata('groupuser');
        $data['getmemodiv'] = $this->M_memopermintaan->getdatamemomanagement($dept);
		$this->template->display('utility/permintaan/app/management',$data);
	}

	function multiApprovalManagement(){
		if($this->input->post('Submit') == 'Approve'){
            $id = $this->input->post('IDMemo');
            $itung  = count($id);
            for($i=0; $i<$itung; $i++){
                $data   = array(
					'Approved3By'   => $this->session->userdata('username'),
					'Approved3Date' => date('Y-m-d H:m:i'),
					'Approved3Sts'  => 1
                ); 
                $this->M_memopermintaan->updatedatamanagement($id[$i],$data);
            }
            redirect('Memopermintaan/appmanagement');
            
        }elseif($this->input->post('Submit') == 'Decline'){
            $id = $this->input->post('IDMemo');
            $itung  = count($id);
            for($i=0; $i<$itung; $i++){
                $data   = array(
					'Approved3By'   => $this->session->userdata('username'),
					'Approved3Date' => date('Y-m-d H:m:i'),
					'Approved3Sts'  => 2
                ); 
                $this->M_memopermintaan->updatedatamanagement($id[$i],$data);
            }
            redirect('Memopermintaan/appmanagement');
            
        }
	}
// and Approve Management
}