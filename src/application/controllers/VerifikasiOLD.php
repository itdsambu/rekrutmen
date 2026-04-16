<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class Verifikasi extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('darurat');
        $status = $this->darurat->getStatus();
//        $status = 1;
        if($status === 1 && $this->session->userdata('userid') !=='ismo_adm'){
            redirect(site_url('maintenanceControl'));
        }
        
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('userid')){
            redirect('login');
        }
        
        $this->load->model(array('m_verifikasi'));
    }
    
    function index(){
        // $data['getListTK'] = $this->m_verifikasi->getListTK();

        $start  = date('Y-m-d', strtotime($this->input->post('startDate')));
        $end    = date('Y-m-d', strtotime($this->input->post('endDate')));
        
        if($this->input->post('startDate')){
            $data['getListTK']    = $this->m_verifikasi->getListTKWhere($start, $end);
        }else{
            $data['getListTK']    = $this->m_verifikasi->getListTK();
        }

        $this->template->display('registrasi/verifikasi/index',$data);
    }

    function simpan(){
        $data = array(
            'HeaderID'      => $this->input->post('txtHeaderID'),
            'Dept'          => $this->input->post('txtDept'),
            'VirifiedBy'    => $this->input->post('txtName'),
            'VirifiedDate'  => date('Y-m-d H:m:i'),
            'VirifiedKet'   => $this->input->post('txtKeterangan')
        );
        
        $this->m_verifikasi->simpanVerifikasiTim($data);
        
        redirect('verifikasi/index?msg=success_add_komentar');
    }
    
    function verifiAksi(){
        if(isset($_POST['Verifi'])){
            $checked = $this->input->post('checkVerifi');
            $itung = count($checked);
            for($i=0; $i<$itung; $i++){
                $this->m_verifikasi->updateVerified($checked[$i]);
            }
            redirect(site_url('verifikasi/index'));
        }
        elseif (isset($_POST['Cancel'])) {
            $checked = $this->input->post('checkVerifi');
            $itung = count($checked);
            for($i=0; $i<$itung; $i++){
                $this->m_verifikasi->batalVerified($checked[$i]);
            }
            redirect(site_url('verifikasi/index'));
        }
    }
    
    function detailtk(){
        if('IS_AJAX') {
            $kode=$this->input->post('kode');
            $data['datatk'] = $this->m_verifikasi->get_detailtk($kode)->result();
            foreach ($this->m_verifikasi->get_detailtk($kode)->result() as $row):
                $tglLahir   = $row->Tgl_Lahir;
            endforeach;
            $data['_umur']  = $this->hitungUmur(date('Y-m-d', strtotime($tglLahir)));
            $data['resultScreen'] = $this->m_verifikasi->resultScreen($kode)->result();
            $this->load->view('registrasi/verifikasi/detail',$data);
        }
    }
    
    function closeTenaker(){
        $hdrID = $this->input->post('txtHeaderID');
        $remark= $this->input->post('txtRemarkClose');
        $this->m_verifikasi->closeTenaker($hdrID,$remark);
        redirect(site_url('verifikasi/index'));
    }

    function hitungUmur($tglLahir = "1991-02-01"){
        $thn    = substr($tglLahir, 0, 4);
        $bln    = substr($tglLahir, 5, 2);
        $day    = substr($tglLahir, 8, 2);
        
        $nowY   = date("Y");
        $nowM   = date("m");
        $nowD   = date("d");
        
        $hariLahir  = gregoriantojd($bln, $day, $thn);
        $today      = gregoriantojd($nowM, $nowD, $nowY);
        
        $umur   = $today-$hariLahir;
        $tahun  = substr($umur/365, 0, 2);
        
        return $tahun;
    }
}

/* End of file verifikasi.php */
/* Location: ./application/controllers/verifikasi.php */