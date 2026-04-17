<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Kepala_shift extends CI_Controller
{
	
	public function __construct(){ 
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
		$this->load->model('M_kepala_shift');
	}

	function index(){

		$data['_getData'] = $this->M_kepala_shift->get_data();
		$this->template->display('master/kepala_shift/index',$data);
	}

	function simpan(){
		$nama  = $this->input->post('txtNama');
		$shift = $this->input->post('selShift');

		$data = array(
			'Nama' 			=> $nama,
			'Shift' 		=> $shift,
			'CreatedBy' 	=> $this->session->userdata('username'),
			'CreatedDate' 	=> date('Y-m-d H:i:s')
		);

		$result = $this->M_kepala_shift->simpan($data);
		if(!$result){
			redirect('Kepala_shift?msg=success');
		}else{
			redirect('Kepala_shift?msg=failed');
		}
	}

	function edit(){

		$this->template->display('master/kepala_shift/edit');
	}
}