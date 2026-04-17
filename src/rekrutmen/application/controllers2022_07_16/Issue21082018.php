<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class Issue extends CI_Controller{
    
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
        
        $this->load->model('m_issue');
    }
    
    function boronganIndex(){
        $data['getDept'] = $this->m_issue->getDept();
        $data['getPemb'] = $this->m_issue->getPemborong();
        $data['getPend'] = $this->m_issue->getPendidikan();
        $data['getJurs'] = $this->m_issue->getJurusan();
        $data['getSKwn'] = $this->m_issue->getStatusKawin();
        $this->template->display('transaksi/issue_permintaan/borongan/index', $data);
    }
    
    function getBagian(){
        if('IS_AJAX') {
            $dept   = $this->input->post('dept');
            $data['_getBagian'] = $this->m_issue->getPekerjaan($dept);
            $this->load->view('transaksi/issue_permintaan/borongan/getBagian',$data);
        }
    }
            
    function karyawanIndex(){
        $data['getDept'] = $this->m_issue->getDept();
        $data['getJabt'] = $this->m_issue->getJabatan();
        $data['getPend'] = $this->m_issue->getPendidikan();
        $data['getJurs'] = $this->m_issue->getJurusan();
        $data['getSKwn'] = $this->m_issue->getStatusKawin();
        $this->template->display('transaksi/issue_permintaan/karyawan/index', $data);
    }
    
    function saveIssue(){
        $data = array(
            'DeptID'        => $this->input->post('comboDept'),
            'Pemborong'     => $this->input->post('txtPemborong'),
            'PekerjaanID'   => $this->input->post('comboTansaksi'),
            'TKTarget'      => $this->input->post('txtTarget'),
            'TKSedia'       => $this->input->post('txtTersedia'),
            'TKPermintaan'  => $this->input->post('txtPermintaan'),
            'IssueRemark'   => $this->input->post('txtKeterangan'),
            'Umur'          => $this->input->post('txtUmur'),
            'Pendidikan'    => $this->input->post('comboPendidikan'),
            'Jurusan'       => $this->input->post('comboJurusan'),
            'JenisKelamin'  => $this->input->post('comboJekel'),
            'StatusPersonal'=> $this->input->post('comboStatus'),
            'CreatedBy'     => $this->session->userdata('username'),
            'CreatedDate'   => date('Y-m-d H:m:i')
        );
        $this->m_issue->saveIssue($data);
        
        $aksi = $this->uri->segment(3);
        if($aksi == 'borongan'){
            redirect(site_url('issue/boronganIndex/success'));
        }elseif ($aksi == 'karayawan') {
            redirect(site_url('issue/karyawanIndex/success'));
        }
    }
    
    function editIssue(){
        $data['_getIssue'] = $this->m_issue->getIssue();
        $this->template->display('transaksi/issue_permintaan/edit_issue/index',$data);
    }    
    function viewEditIssue(){
        if('IS_AJAX') {
        $id = $this->input->post('kode');
        $data['getDept'] = $this->m_issue->getDept();
        $data['getJbtn'] = $this->m_issue->getJabatan();
        $data['getPemb'] = $this->m_issue->getPemborongAll();
        $data['getPend'] = $this->m_issue->getPendidikan();
        $data['getJurs'] = $this->m_issue->getJurusan();
        $data['getSKwn'] = $this->m_issue->getStatusKawin();
        $data['getTran'] = $this->m_issue->setInfoTranEdit($id)->result();
        $row = $this->m_issue->setInfoTranEdit($id)->row();
        $idDept          = $row->DeptID;
        $data['getKrj']  = $this->m_issue->getPekerjaan($idDept);
        $this->load->view('transaksi/issue_permintaan/edit_issue/editIssue',$data);
        }
    }
    function doEditIssue(){
        $id = $this->input->post('txtID');
        
        if($this->input->post('comboPemborong') == 'PSG'){
            $idKerja    = $this->input->post('comboJabatan');
        }else{
            $idKerja    = $this->input->post('comboTansaksi');
        }
        $data = array(
            'DeptID'        => $this->input->post('comboDept'),
            'Pemborong'     => $this->input->post('comboPemborong'),
            'PekerjaanID'   => $idKerja,
            'TKTarget'      => $this->input->post('txtTarget'),
            'TKSedia'       => $this->input->post('txtTersedia'),
            'TKPermintaan'  => $this->input->post('txtPermintaan'),
            'IssueRemark'   => $this->input->post('txtKeterangan'),
            'Umur'          => $this->input->post('txtUmur'),
            'Pendidikan'    => $this->input->post('comboPendidikan'),
            'Jurusan'       => $this->input->post('comboJurusan'),
            'JenisKelamin'  => $this->input->post('comboJekel'),
            'StatusPersonal'=> $this->input->post('comboStatus'),
            'UpdatedBy'     => $this->session->userdata('username'),
            'UpdatedDate'   => date('Y-m-d H:m:i')
        );
        $this->m_issue->updateTran($id,$data);
        
        redirect(site_url('issue/editIssue'));
    }
}