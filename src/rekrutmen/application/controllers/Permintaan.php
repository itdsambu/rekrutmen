<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class permintaan extends CI_Controller{
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
        $this->load->model('m_permintaan');
        }

	function index()
	{
		$data['dept'] = $this->m_permintaan->get_departemen();
		$this->template->display('transaksi/permintaan/index', $data);
	} 
	function save1()
	{
		$IdDept 		= $this->input->post('IdDept');
		$realkaryawan 	= $this->input->post('realkaryawan');
		$idealkaryawan 	= $this->input->post('idealkaryawan');
		$realtk	 		= $this->input->post('realtk');
		$idealtk	 	= $this->input->post('idealtk');

		$data = array(
			'IDDepartemen' 			=> $IdDept,
			'IdealKaryawan' 		=> $idealkaryawan,
			'RealKaryawan' 			=> $realkaryawan,
			'RealKaryawanUpdate'	=> $realkaryawan,
			'IdealTK'				=> $idealtk,
			'RealTK' 				=> $realtk,
			'RealTKUpdate' 			=> $realtk,
		);

		$this->m_permintaan->savekary($data);
		redirect('permintaan');
		// echo "<pre>";
		// print_r($_POST);
		// echo "<pre>";
	}
}
?>