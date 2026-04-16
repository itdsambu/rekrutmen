<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class User_Profil extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('darurat');
        $status = $this->darurat->getStatus();
        if($status === 1 && $this->session->userdata('userid') !=='ismo_adm'){
            redirect(site_url('maintenanceControl'));
        }
        $this->load->library(array('user_agent'));
        
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('userid')){
            redirect('login');
        }

        $this->load->model('m_user_profil');
    }
    
    public function index(){
        $loginID    = $this->session->userdata('userid');
        $data['_getProfilSendiri'] = $this->m_user_profil->getProfile($loginID);
        foreach ($this->m_user_profil->getProfile($loginID) as $row):
            $tglLahir   = $row->TanggalLahir;
        endforeach;
        $data['_umur']  = $this->hitungUmur($tglLahir);
        $data['_getLastLogin']  = $this->m_user_profil->getLastLogin($loginID);
        
        if($this->agent->is_mobile()){
            $mobile = 1;
        }else{
            $mobile = 0;
        }
        $data['_isMobile']  = $mobile;
        $this->template->display('utility/user_profil/index',$data);
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
        $tahun  = substr($umur/365, 0, 3);
        
        return $tahun;
/*        $sisa   = $umur%365;
//        
//        $bulan  = $sisa/30;
//        $hari   = $sisa%30;
        
//        print $tahun."<br/>";
//        print $sisa."<br/>";
//        print $bulan."<br/>";
//        print $hari."<br/>"; */
        
    }
    
    function photo(){
        if('IS_AJAX') {
            $data['loginID'] = $this->input->post('kode');
            //$data['datatk'] = $this->m_wawancara->getDetailTK($kode)->result();
            $this->load->view('utility/user_profil/changePhoto',$data);
        }
    }
    
    function uploadPhoto(){
        $this->load->library('image_moo');
        
        $url = './dataupload/fotoProfil/';
        $loginID    = $this->input->post("txtLoginID");
        $filefoto = $loginID;

        $config['upload_path']      = $url;		
        $config['allowed_types']    = 'jpeg|jpg|png|gif';
        $config['allow_scale_up']   = true;
        $config['overwrite']        = true;
        $config['max_size']         = '1024';
        $config['file_name']        = $filefoto.'.png';	//Filename harus pakai headerID pelamar

        $this->load->library('upload');
        $this->upload->initialize($config);
        
        if($this->upload->do_upload('fileFoto1') == ""){
            $file = $this->upload->do_upload('fileFoto2');
        }  else {
            $file = $this->upload->do_upload('fileFoto1');
        }
        if( $file ){
            $files = $this->upload->data();
            $fileNameResize = $config['upload_path'].$files['file_name'];					

            $this->image_moo
                    ->load($fileNameResize)
                    ->set_background_colour('#fff')
                    ->resize(200,200,TRUE)
                    ->save($fileNameResize,true);

            if ($this->image_moo->errors){
                redirect("user_profil/index?failed");
            }else{				
                $this->m_user_profil->update_status_foto($loginID);
                $this->image_moo->clear();
                redirect("user_profil/index");
            }
        }else{
            redirect("user_profil/index?failed");
        }
        $this->image_moo->clear();
    }
    
    function setting(){
        if('IS_AJAX') {
            $loginID    = $this->session->userdata('userid');
            $data['_getProfilSendiri'] = $this->m_user_profil->getProfile($loginID);
            $this->load->view('utility/user_profil/updateProfil',$data);
        }
    }
    
    function updateProfile(){
        $loginID    = $this->session->userdata('userid');
        $data       = array(
            'NamaDepan'       => $this->input->post('txtNamaDepan'),
            'NamaBelakang'    => $this->input->post('txtNamaBelakang'),
            'JenisKelamin'    => $this->input->post('txtJekel'),
            'TanggalLahir'    => $this->input->post('txtTglLahir'),
            'Facebook'        => $this->input->post('txtFacebook'),
            'Twitter'         => $this->input->post('txtTwitter'),
            'GooglePlus'      => $this->input->post('txtGooglePlus'),
            'Email'           => $this->input->post('txtEmail'),
            'URL'             => $this->input->post('txtWebPage')
        );
        
        $this->m_user_profil->updateProfile($loginID,$data);
        redirect('user_profil/index');
    }
        
}