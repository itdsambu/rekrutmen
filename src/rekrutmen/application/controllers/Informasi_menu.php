<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Informasi_menu extends CI_Controller{
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
        $this->load->model('M_informasi_menu');
        }

    function index(){
        $data['menuLv1'] = $this->M_informasi_menu->get_mnulv1();
        $data['menuLv2'] = $this->M_informasi_menu->get_mnulv2();
        $data['menuLv3'] = $this->M_informasi_menu->get_mnulv3();
        $data['getKet'] = $this->M_informasi_menu->get_ket();
        $data['getData'] = $this->M_informasi_menu->get_dataMenu();
        $this->template->display('master/informasi_menu/index',$data);
    } 

    function tambahData(){

        $data['menuLv1'] = $this->M_informasi_menu->get_mnulv1();
        $data['menuLv2'] = $this->M_informasi_menu->get_mnulv2();
        $data['menuLv3'] = $this->M_informasi_menu->get_mnulv3();
        $this->template->display('master/informasi_menu/input',$data);
    }

    function tambahInfo(){
        $id = $this->input->get('id');

        $data['id'] = $id;
        $data['getData'] = $this->M_informasi_menu->get_data($id);
        $this->load->view('master/informasi_menu/modal/info',$data);
    }

    function simpanData(){
        $menuid     = $this->input->post('txtmenuid');
        $id         = $this->input->post('txtid');
        $keterangan = $this->input->post('txtInformasi');

        $cekData = $this->M_informasi_menu->cek_data($menuid);
        if($cekData == NULL){
            $data = array(
                'MenuID'            => $menuid,
                'Keterangan_menu'    => $keterangan,
                'CreatedBy'         => $this->session->userdata('username'),
                'CreatedDate'       => date('Y-m-d H:i:s')
            );
            $this->M_informasi_menu->simpan($data);
        }else{
            $data = array(
                'MenuID'           => $menuid,
                'Keterangan_menu'  => $keterangan,
                'UpdateBy'         => $this->session->userdata('username'),
                'UpdateDate'       => date('Y-m-d H:i:s')
            );
            $this->M_informasi_menu->update($id,$data);
        }
        redirect('Informasi_menu/tambahData');
    }
}