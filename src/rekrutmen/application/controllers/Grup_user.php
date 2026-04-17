<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Grup_user extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('darurat');
        $status = $this->darurat->getStatus();
        if ($status === 1 && $this->session->userdata('userid') !== 'ismo_adm') {
            redirect(site_url('maintenanceControl'));
        }
        date_default_timezone_set("Asia/Jakarta");
        if (!$this->session->userdata('userid')) {
            redirect('login');
        }

        $this->load->library('form_validation');
    }

    function index()
    {
        $d['pesan'] = "";
        $this->template->display('utility/grup_user/index', $d);
    }

    function tambah()
    {
        //==================== Simpan Data =============
        $data = array(
            'GroupName' => $this->input->post('txtGrupUser'),
            'GroupDescription' => $this->input->post('txtNamaGrup'),
            'NotActive' => $this->input->post('txtStatus'),
            'CreatedBy' => strtoupper($this->session->userdata('userid')),
            'CreatedDate' => date('Y-m-d H:i:s')
        );
        $this->load->model('m_grup_user');
        $result = $this->m_grup_user->save($data);

        if ($result) {
            $d['pesan'] = "<p class='alert alert-info'>Tambah Grup User Berhasil.. Lihat data Grup User, klik " . anchor('grup_user/listGrupUser', 'disini') . "</p>";
            $this->template->display('utility/grup_user/index', $d);
        } else {
            $d['pesan'] = "<p class='alert alert-danger'>Gagal Tambah Grup User</p>";
            $this->template->display('utility/grup_user/index', $d);
        }
    }

    function listGrupUser()
    {
        $this->load->model('m_grup_user');
        $data['getGrupUser'] = $this->m_grup_user->selectGrupUser();
        $this->template->display('utility/grup_user/list_grupUser', $data);
    }

    function editGrupUser()
    {
        $this->load->model('m_grup_user');

        $id = $this->input->get('id');
        $data['getID'] = $this->m_grup_user->getGrupUser($id);
        $this->template->display('utility/grup_user/editGrupUser', $data);

        if ($this->input->post('simpan')) {
            $id = $this->input->post('txtIDGrup');
            $data = array(
                'GroupName' => $this->input->post('txtGrupUser'),
                'GroupDescription' => $this->input->post('txtNamaGrup'),
                'NotActive' => $this->input->post('txtStatus'),
                'UpdatedBy' => strtoupper($this->session->userdata('userid')),
                'UpdatedDate' => date('Y-m-d H:i:s')
            );

            $result = $this->m_grup_user->update($id, $data);
            if (!$result) {
                redirect('grup_user/listGrupUser?msg=success_edit');
            } else {
                redirect('grup_user/listGrupUser?msg=failed_edit');
            }
        }
    }

    function deleteGrupUser()
    {
        $id = $this->input->get('id');

        $this->load->model('m_grup_user');
        $result = $this->m_grup_user->delete($id);

        if (!$result) {
            redirect('grup_user/listGrupUser?msg=success_delete');
        } else {
            redirect('grup_user/listGrupUser?msg=failed_delete');
        }
    }
}

/* End of file grup_user.php */
/* Location: ./application/controllers/grup_user.php */