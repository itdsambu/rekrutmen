<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tambahidealkaryawan extends CI_Controller{
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
        
        $this->load->model('M_tambahidealkaryawan');
    }

    function index(){
        $data['getDept'] = $this->M_tambahidealkaryawan->get_Dept();
        $data['getData'] = $this->M_tambahidealkaryawan->get_Data();
        $data['getDataK'] = $this->M_tambahidealkaryawan->get_DataK();
        $data['getDataTk'] = $this->M_tambahidealkaryawan->get_DataTK();
        $this->template->display('transaksi/tambah_permintaan/index',$data);
    }

    function simpanIdealkaryawan(){
        $dept       = $this->input->post('txtDept');
        $idealK     = $this->input->post('txtIdealK');
        $realK      = $this->input->post('txtRealK');
        $idealTK    = $this->input->post('txtIdealTK');
        $realTK     = $this->input->post('txtRealTK');

        $cekData = $this->M_tambahidealkaryawan->cek_Data($dept);
        
        if($cekData == NULL){
            $data = array(
                'DeptID'            => $dept,
                'Idealkaryawan'     => $idealK,
                'Realkaryawan'      => $realK,
                'Idealtenagakerja'  => $idealTK,
                'Realtenagakerja'   => $realTK,
                'CreatedBy'         => $this->session->userdata('username'),
                'CreatedDate'       => date('Y-m-d H:i:s'),
            );

            $this->M_tambahidealkaryawan->Simpan_idealkaryawan($data);
            redirect('tambahidealkaryawan');
        }else{
            $id         = $this->input->post('txtPermintaan');

            $dataUpdate = array(
                'Idealkaryawan'     => $idealK,
                'Realkaryawan'      => $realK,
                'Idealtenagakerja'  => $idealTK,
                'Realtenagakerja'   => $realTK,
                'CreatedBy'         => $this->session->userdata('username'),
                'CreatedDate'       => date('Y-m-d H:i:s'),
            );
            
            $this->M_tambahidealkaryawan->Update($id,$dataUpdate);
            redirect('tambahidealkaryawan');
        }
    } 

    function AjaxUpdateDataIdeal(){
        $deptID = $this->input->post('DeptID');
        $data['getData'] = $this->M_tambahidealkaryawan->get_dataIdeal($deptID);

        $this->load->view('transaksi/tambah_permintaan/AjaxUpdateIdeal',$data);
    }
}