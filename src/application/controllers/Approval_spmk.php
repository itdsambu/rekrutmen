<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Approval_spmk extends CI_Controller
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
		$this->load->model(array('M_approval_spmk','M_memo_tenaga_kerja'));
        $this->load->library('Excel/PHPExcel');
	}

	function pimpinan(){
		$tanggal = date('Y-m-d');

		$data['_getDataTk'] = $this->M_approval_spmk->get_tenagakerja($tanggal);
		$data['_getDataK']  = $this->M_approval_spmk->get_karyawan($tanggal);
		$this->template->display('Approval/approval_spmk/pimpinan/index',$data);
	}

	function ajaxData_pimpinan(){
		$tanggal = $this->uri->segment(3);

		$data['_getDataTk'] = $this->M_approval_spmk->get_tenagakerja($tanggal);
		$data['_getDataK']  = $this->M_approval_spmk->get_karyawan($tanggal);
		$this->load->view('Approval/approval_spmk/pimpinan/ajax/data',$data);
	}

	function ajaxData_pimpinan2(){
		$tanggal = $this->uri->segment(3);

		$data['_getDataTk'] = $this->M_approval_spmk->get_tenagakerja($tanggal);
		$data['_getDataK']  = $this->M_approval_spmk->get_karyawan($tanggal);
		$this->load->view('Approval/approval_spmk/pimpinan/ajax/data2',$data);
	}

	function approve_pimpinan(){
		$check = $this->input->post('cek');
		$hitung = count($check);

		for ($i=0; $i < $hitung; $i++) { 
			$data = array(
				'ApproveSPMKPimpinan' 		=> 1,
			    'ApproveSPMKPimpinanBy' 	=> $this->session->userdata('username'),
			    'ApproveSPMKPimpinanDate' 	=> date('Y-m-d H:i:s')
			);

			$result = $this->M_memo_tenaga_kerja->simpan($check[$i],$data);
		}

		if (!$result) {
			redirect('Approval_spmk/pimpinan?msg=success');
		}else{
			redirect('Approval_spmk/pimpinan?msg=failed');
		}
	}

	function approve_pimpinan2(){
		$check = $this->input->post('cek');
		$hitung = count($check);

		for ($i=0; $i < $hitung; $i++) { 
			$data = array(
				'ApproveSPMKPimpinan' 		=> 1,
			    'ApproveSPMKPimpinanBy' 	=> $this->session->userdata('username'),
			    'ApproveSPMKPimpinanDate' 	=> date('Y-m-d H:i:s'),
			    'ApproveSPMKKasift' 		=> 1,
			    'ApproveSPMKKasiftBy' 		=> $this->session->userdata('username'),
			    'ApproveSPMKKasiftDate' 	=> date('Y-m-d H:i:s')
			);

			$result = $this->M_memo_tenaga_kerja->simpan($check[$i],$data);
		}

		if (!$result) {
			redirect('Approval_spmk/pimpinan?msg=success');
		}else{
			redirect('Approval_spmk/pimpinan?msg=failed');
		}
	}

	function kasift(){
		$tanggal = date('Y-m-d');

		$data['tanggal'] = $tanggal;
		$data['_getDataTk'] = $this->M_approval_spmk->get_tenagakerja_kasift($tanggal);
		$data['_getDataK']  = $this->M_approval_spmk->get_karyawan_kasift($tanggal);
		$this->template->display('Approval/approval_spmk/kasift/index',$data);
	}

	function ajaxData_kasift(){
		$tanggal = $this->uri->segment(3);

		$data['_getDataTk'] = $this->M_approval_spmk->get_tenagakerja_kasift($tanggal);
		$data['_getDataK']  = $this->M_approval_spmk->get_karyawan_kasift($tanggal);
		$this->load->view('Approval/approval_spmk/kasift/ajax/data',$data);
	}

	function approve_kasift(){
		$check = $this->input->post('cek');
		$hitung = count($check);

		for ($i=0; $i < $hitung; $i++) { 
			$data = array(
				'ApproveSPMKKasift' 	=> 1,
			    'ApproveSPMKKasiftBy' 	=> $this->session->userdata('username'),
			    'ApproveSPMKKasiftDate' => date('Y-m-d H:i:s')
			);

			$result = $this->M_memo_tenaga_kerja->simpan($check[$i],$data);
		}

		if (!$result) {
			redirect('Approval_spmk/kasift?msg=success');
		}else{
			redirect('Approval_spmk/kasift?msg=failed');
		}
	}

	function monApprovalSpmk(){
		$tanggal = date('Y-m-d');

		$data['_getDataTk'] = $this->M_approval_spmk->get_mon_tenagakerja($tanggal);
		$data['_getDataK']  = $this->M_approval_spmk->get_mon_karyawan($tanggal);
		$this->template->display('monitor/mon_spmk/index',$data);
	}

	function ajaxData(){
		$tgl_awal = $this->uri->segment(3);
		$tgl_akhir = $this->uri->segment(4);

		$data['_getDataTk'] = $this->M_approval_spmk->get_ajax_tenagakerja($tgl_awal,$tgl_akhir);
		$data['_getDataK'] = $this->M_approval_spmk->get_ajax_karyawan($tgl_awal,$tgl_akhir);
		// print_r($data['_getDataK']);
		$this->load->view('monitor/mon_spmk/ajax/data',$data);
	}

	function export_to_excel_kasif(){
		$tanggal = $this->input->post('tanggal');

		$data['_getDataTk'] = $this->M_approval_spmk->get_tenagakerja_kasift($tanggal);
		$this->load->view("Approval/approval_spmk/kasift/excel",$data);
	}
}