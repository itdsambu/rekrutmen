<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : Ismo
 */

class UploadBerkas extends CI_Controller {

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
        $this->load->helper(array('url','form'));
        $this->load->model(array('m_register','m_upload_berkas'));
        $this->load->library(array('template','form_validation'));
    }
    
    function index(){        
        $hdrid = $this->session->flashdata("regid"); 
        //redirect("uploadBerkas/listTKforUploadDoc");; 
        $hdrid = $this->session->flashdata("regid");
        $nama = $this->session->flashdata("regnama");
        $this->session->keep_flashdata("regid");
        $this->session->keep_flashdata("regnama");
        
        $data['hdrid']=$hdrid;
        $data['namapelamar']=$nama;
        $data['errormsg']=""; 

        $data['databerkas']= $this->m_upload_berkas->get_db_berkas($hdrid)->result();
        $data['minimalberkas']= $this->m_upload_berkas->minimal_berkas($hdrid);
        
        $this->template->display('registrasi/upload_berkas/index',$data);
    }
    
    function uploadarea(){		
        $tipe = $this->input->post("tipe");
        $data["hdrid"] = $this->input->post("hdrid");
        $data["namapelamar"] = $this->input->post("nama");
        $data['errormsg']="";

        switch ($tipe) {
            case 'ktp':
                $namaberkas = "KTP";
                break;
            case 'cv':
                $namaberkas = "Daftar Riwayat Hidup";
                break;
            case 'lamaran':
                $namaberkas = "Surat Lamaran";
                break;
            case 'ijazah':
                $namaberkas = "Ijazah";				
                break;
            case 'transkrip':
                $namaberkas = "Transkrip Nilai";				
                break;
            case 'SuratKontrak':
                $namaberkas = "Surat Perjanjian Kontrak";				
                break;
            case 'Vaksin1':
                $namaberkas = "Sertifikat Vaksin 1";				
                break;
            case 'Vaksin2':
                $namaberkas = "Sertifikat Vaksin 2";				
                break;
            case 'Vaksin3':
                $namaberkas = "Sertifikat Vaksin 3";				
                break;
            case 'KK':
                $namaberkas = "Kartu Keluarga";				
                break;
                
            default:
                $this->template->display('registrasi/upload_berkas/index',$data);
                break;
        }

        $data['jenisberkas']    =$tipe;
        $data['namaberkas']     =$namaberkas;
        if ($tipe === "ktp"){
                $this->load->view('registrasi/upload_berkas/formKTP',$data);
        }else{
                $this->load->view('registrasi/upload_berkas/formUpload',$data);
        }
    }
    
    function do_upload($berkas){
        switch ($berkas) {
            case "ktp":
                $url = './dataupload/berkas/ktp';
                $namaberkas = "KTP";
                break;			
            case "cv":
                $url = './dataupload/berkas/cv';
                $namaberkas = "Daftar Riwayat Hidup";
                break;
            case "lamaran":
                $url = './dataupload/berkas/lamaran';
                $namaberkas = "Surat Lamaran";
                break;
            case "ijazah":
                $url = './dataupload/berkas/ijazah';
                $namaberkas = "Ijazah";
                break;
            case "transkrip":
                $url = './dataupload/berkas/transkrip';
                $namaberkas = "Transkrip Nilai";
                break;
            case "SuratKontrak":
                $url = './dataupload/berkas/spk';
                $namaberkas = "Surat Perjanjian Kontrak";
                break;
            case "Vaksin1":
                $url = './dataupload/berkas';
                $namaberkas = "Sertifikat Vaksin 1";
                break;
            case "Vaksin2":
                $url = './dataupload/berkas';
                $namaberkas = "Sertifikat Vaksin 2";
                break;
            case "Vaksin3":
                $url = './dataupload/berkas';
                $namaberkas = "Sertifikat Vaksin 3";
                break;
            case "KK":
                $url = './dataupload/berkas';
                $namaberkas = "KK";
                break;
            default:
                $url = './dataupload/berkas';
                $namaberkas = "Lain-Lain";
                break;
        }
		
        $hdrid = $this->input->post("txthdrid");
        $namapelamar = $this->input->post("txtnamapelamar");
        $namafile = $hdrid.'_'.$berkas;

        $data['namapelamar']        = $namapelamar;
        $config['upload_path']      = $url;
        $config['allowed_types']    = 'pdf';
        $config['allow_scale_up']   = true;
        $config['overwrite']        = true;
        $config['file_name']        = $namafile;
        $config['max_size']         = '5120';

        $this->load->library('upload');
        $this->upload->initialize($config);

        if( $this->upload->do_upload('txtfile')){
            $this->upload->data();
            $data['errormsg']="<div class='alert alert-success'><a class='close' data-dismiss='alert'>×</a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Berkas $namaberkas Berhasil</strong></div>";
            $this->m_upload_berkas->update_db_berkas($hdrid,$berkas,$url.'/'.$namafile.'.pdf');
        }else{
            $error = $this->upload->display_errors();
            $data['errormsg']="<div class='alert alert-danger'><a class='close' data-dismiss='alert'><i class='fa fa-times'>&nbsp;</i></a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Berkas $namaberkas Gagal</strong><br/>$error</div>";
        }
        
        $data['databerkas']     = $this->m_upload_berkas->get_db_berkas($hdrid)->result();
        $data['minimalberkas']  = $this->m_upload_berkas->minimal_berkas($hdrid);
        $data['hdrid']  = $hdrid;
        if($berkas == 'SuratKontrak'){
            $this->template->display('registrasi/upload_berkas/uploadSPK',$data);
        }else{
            $this->template->display('registrasi/upload_berkas/index',$data);
        }
		
    }
    
    function selesai($hdrid){
        $data['message']="<div class='alert alert-success'><a class='close' data-dismiss='alert'>×</a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Data dan Foto Berhasil</strong></div>";
        $data['hdrid']=$hdrid;
        $data['filefoto']="foto/".$hdrid;
        $data['datatk']=$this->m_register->get_tenagakerja($hdrid)->result();

        $this->template->display('registrasi/register/hasil',$data);
    }
    
    function listTKforUploadDoc(){
        $dept           = $this->session->userdata("groupuser");
        $segment        = $this->uri->segment(3);
        $filter_status  = $this->uri->segment(4);
        $idpemborong    = $this->session->userdata('idpemborong');
        // var_dump($idpemborong); die;
        if($segment == 1){
            $data['_selected']  = 1;
            $data['_filter_selected']  = $filter_status;
            $data['hidden_pemborong'] = $idpemborong;
            $data['getListTK'] = $this->m_upload_berkas->getTenakerUploadSPK($idpemborong,$filter_status);
        }else{
            $data['_selected']  = 0;
            $data['_filter_selected']  = $filter_status;
            $data['hidden_pemborong'] = $idpemborong;
            $data['getListTK'] = $this->m_upload_berkas->getListTK($idpemborong,$filter_status); 
        }
        
        $this->template->display('registrasi/upload_berkas/uploadBerkas',$data); 
    }
    
    function doEditBerkas(){
        $hdrid  = $this->input->get('id');
        $nama   = $this->input->get('nama');
        $this->session->set_flashdata("regid",$hdrid);
        $this->session->set_flashdata("regnama",$nama);
        
        redirect('UploadBerkas/index');
    }
    
    function doUploadSPK(){
        $hdrid  = $this->input->get('id');
        $nama   = $this->input->get('nama');
        $this->session->set_flashdata("regid",$hdrid);
        $this->session->set_flashdata("regnama",$nama);
        
        redirect('UploadBerkas/viewUploadSPK');
    }
    function viewUploadSPK(){
        $hdrid = $this->session->flashdata("regid");
        $nama = $this->session->flashdata("regnama");
        $this->session->keep_flashdata("regid");
        $this->session->keep_flashdata("regnama");
        
        $data['hdrid']=$hdrid;
        $data['namapelamar']=$nama;
        $data['errormsg']="";
        $data['databerkas']= $this->m_upload_berkas->get_db_berkas($hdrid)->result();
        $data['minimalberkas']= $this->m_upload_berkas->minimal_berkas($hdrid);
        
        $this->template->display('registrasi/upload_berkas/uploadSPK',$data);
    }
            
    function doEditFoto(){
        $hdrid  = $this->input->get('id');
        $nama   = $this->input->get('nama');
        $this->session->set_flashdata("regid",$hdrid);
        $this->session->set_flashdata("regnama",$nama); 
        
        redirect('registrasi/uploadFoto');
    }
    
    
    // ========= List Tenaga KErja
    function detailtk(){
        if('IS_AJAX') {
        $kode=$this->input->post('kode');
        $data['datatk'] = $this->m_upload_berkas->get_detailtk($kode)->result();
        $this->load->view('registrasi/upload_berkas/detail',$data);
        }
    }

}

/* End of file uploadBerkas.php */
/* Location: ./application/controllers/uploadBerkas.php */