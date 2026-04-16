<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MstIdeal extends CI_Controller{
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
        $this->load->model('M_MstIdeal');
        }

    function index(){
       
        $data['getData'] = $this->M_MstIdeal->get_list();
        $this->template->display('master/ideal/index',$data);
    }
    function tambah(){
         $data['getDept'] = $this->M_MstIdeal->get_departemen();
        $this->template->display('master/ideal/tambah',$data);
    } 
    function simpan(){
        $dept          = $this->input->post('selDept');
        $jml_ideal_bor = $this->input->post('txtIdealBorongan');
        $jml_ideal_kar = $this->input->post('txtIdealKaryawan');
        $status        = $this->input->post('txtStatus');

        $data = array(
            'DeptID'          => $dept,
            'Jumlah_IdealBor' => $jml_ideal_bor,
            'Jumlah_IdealKar' => $jml_ideal_kar,
            'Status'          => $status,
            'CreatedBy'       => $this->session->userdata('username'),
            'CreatedDate'     => date('Y-m-d H:i:s')
        );

        $this->M_MstIdeal->simpan($data);
        // $cek = $this->M_MstIdeal->cek_data($dept);
        // if($cek == NULL){
        //     $this->M_MstIdeal->simpan($data);
            redirect('MstIdeal?msg=success');
        // }else{
        //     redirect('MstIdeal?msg=failed');
        // }
    }

    function hapus(){
        $id = $this->input->get('id');
        $this->M_MstIdeal->hapus($id);
        redirect('MstIdeal?msg=success2');
    }
}