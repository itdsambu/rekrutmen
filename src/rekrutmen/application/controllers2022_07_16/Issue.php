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

    function cekfirstbor(){
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
        
        $cek = 0;
        $msg='';
        $cek  = $this->m_issue->isValidPermintaanBorongan($data); 
        if($cek['error']==1){
           $msg = 'Jumlah permintaan melebihi batas ideal,' . 
                  ' total permintaan dalam proses '. $cek['psb'] . ' org, proses cancel';
        }elseif($cek['error']==2){
            $msg = 'Jumlah permintaan <= 0, proses cancel';  
        }elseif($cek['error']>0){
            $msg = 'Jumlah permintaan melebihi batas ideal, proses cancel';
        }
        echo json_encode(array('Err'=>$cek['error'],'Msg'=>$msg));
    }

    function cekfirstkar(){
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
        
        $cek = 0;
        $msg='';
        
        $cek  = $this->m_issue->isValidPermintaanKaryawan($data); 
        if($cek['error']==1){
            $msg = 'Jumlah permintaan melebihi batas ideal,' . 
                   ' total permintaan dalam proses '. $cek['psb'] . ' org, proses cancel';
        }elseif($cek['error']==2){
            $msg = 'Jumlah permintaan <= 0, proses cancel';               
        }elseif($cek['error']>0){
            $msg = 'Jumlah total permintaan melebihi batas, cancel permintaan anda sebelumnya.';
        }
        echo json_encode(array('Err'=>$cek['error'],'Msg'=>$msg));
    }

    function get_idealkry(){
        $id = $this->input->get('id');
        $row = $this->m_issue->getdatakuotakry($id);
        echo json_encode(array('ideal'=>$row->IKry,'real'=>$row->RKry));
    }

    function get_idealbor(){
        $id = $this->input->get('id');
        $row = $this->m_issue->getdatakuotabor($id);
        echo json_encode(array('ideal'=>$row->IBor,'real'=>$row->RBor));
    }
    
    function saveIssue(){
        $data = array(
            'DeptID'        => $this->input->post('comboDept'),
            'Pemborong'     => $this->input->post('txtPemborong'),
            'PekerjaanID'   => $this->input->post('comboTansaksi'),
            'TKTarget'      => $this->input->post('txtPermintaan'),//$this->input->post('txtTarget'),
            'TKSedia'       => 0, //$this->input->post('txtTersedia')
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
        

        $mdata = $data;    

       

        $aksi = $this->uri->segment(3);
        if($aksi== 'borongan'){
            $cek  = $this->m_issue->isValidPermintaanBorongan($data);
            if($cek['error']>0){
                return;
            } 
        }else{
            $cek  = $this->m_issue->isValidPermintaanKaryawan($data);
            if($cek['error']>0){
                return;
            } 
        }        
     
        
        $this->m_issue->saveIssue($mdata);
        //return;
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