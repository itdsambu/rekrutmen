<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PemborongAkses extends CI_Controller {

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
        $this->load->library('form_validation');
        $this->load->model('M_pemborongAkses', 'm_grup_user');
    }

    function index(){
        $this->load->model('M_pemborongAkses');
        $data['getGroupAkses'] = $this->M_pemborongAkses->selectGroupAkses();
        $this->template->display('utility/pemborong_akses/main', $data);
    }

    function add(){
        $this->load->model('M_pemborongAkses');
        $data['_getGrupUser']         = $this->m_grup_user->selectGrupUser();
        $data['_getGrupPemborong']    = $this->M_pemborongAkses->selectGroupPemborong();
        $list_group_akses = ['13', '15', '44', '79', '139', '36', '71', '2', '93', '1'];
        $akses = false;
        if (in_array($this->session->userdata('groupuser'), $list_group_akses)) {
            $akses = true;
        }
        $data['akses'] = $akses;
        $this->template->display('utility/pemborong_akses/addAksesGroup',$data);
    }

    function getGroupame(){
        $IDGroup = $this->input->post('IDGroup');
        $this->load->model('M_pemborongAkses');
        $data = $this->M_pemborongAkses->getGroupame($IDGroup);
        echo json_encode($data);
    }

    function getNamePerusahaan(){
        $this->load->model('M_pemborongAkses');
        $cv       = $this->input->post('cv');
        $owner    = $this->input->post('owner');
        $data = $this->M_pemborongAkses->getNamePerusahaan($cv, $owner);
        echo json_encode($data);
    }

    function save(){
        //==================== Simpan Data Bos Que=============
        $data = array(
            'GroupID'         => $this->input->post('txtGroupID'),
            'GroupName'       => $this->input->post('txtGroupName'),
            'IDPerusahaan'    => $this->input->post('inputIDPerusahaan'),
            'IDToko'          => $this->input->post('inputIDPerusahaan'),
            'TokoName'        => $this->input->post('txtNameCv'),
            'IDPemborong'     => $this->input->post('inputIDPemborong'),
            'NotActive'       => $this->input->post('txtStatus'),
            'CreatedBy'       => strtoupper($this->session->userdata('userid')),
            'CreatedDate'     => date('Y-m-d H:i:s')
        );

        $this->load->model('M_pemborongAkses');
        $result = $this->M_pemborongAkses->save($data);

        if($result){
            $d['pesan']= "<p class='alert alert-info'>Tambah Access Pemborong Berhasil.. Lihat data Grup Pemborong, klik ".anchor('PemborongAkses/index,','disini')."</p>";
            $data['getGroupAkses'] = $this->M_pemborongAkses->selectGroupAkses();
            $this->template->display('utility/pemborong_akses/main',$data, $d);
        }else{
            $d['pesan']= "<p class='alert alert-danger'>Gagal Tambah Access Pemborong</p>";
            $this->template->display('utility/pemborong_akses/main',$d);
        }
    }

    function editAksesGroup(){
        $this->load->model('M_pemborongAkses');
        $id = $this->input->get('id');
        $data['getID'] = $this->M_pemborongAkses->getGrupAkses($id);
        $this->template->display('utility/pemborong_akses/editAksesGroup',$data);

        if($this->input->post('simpan')){
            $id   = $this->input->post('txtID');
            $data = array(
                'NotActive'     =>$this->input->post('txtStatus'),
                'UpdatedBy'     => strtoupper($this->session->userdata('userid')),
                'UpdatedDate'   => date('Y-m-d H:i:s')
            );

            $result = $this->M_pemborongAkses->update($id,$data);
            if(!$result){
                echo "<script>alert('Data Gagal di Simpan !')</script>";
            }else{
                echo "<script>alert('Data Berhasil di Simpan !')</script>";
            }
            redirect('PemborongAkses/index?msg=success_edit');
        }
    }

    function deleteAkses(){
        $this->load->model('M_pemborongAkses');
        $id = $this->input->get('id');
        $result = $this->M_pemborongAkses->delete($id);

        if(!$result){
            redirect('PemborongAkses/index?msg=success_delete');
        }else{
            redirect('PemborongAkses/index?msg=failed_delete');
        }
    }

}

/* End of file PemborongAkses.php */
