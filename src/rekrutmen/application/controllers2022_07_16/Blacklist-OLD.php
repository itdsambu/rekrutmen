<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blacklist extends CI_Controller{
	
    public function __construct(){
        parent::__construct();
        $this->load->model(array('darurat','m_blacklist'));
//        $status = 1;
        $status = $this->darurat->getStatus();
        if($status === 1 && $this->session->userdata('userid') !=='ismo_adm'){
            redirect(site_url('maintenanceControl'));
        }
        
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('userid')){
            redirect('login');
        }
        $this->load->library(array('template','form_validation'));
    }
	
    function index(){
        $this->load->model('m_blacklist');
        
        $data['getDept'] = $this->m_blacklist->getDept();
		$data['gettgllahir'] = $this->m_blacklist->getDeptgetTGLLAHIR();
        $data['getData'] = $this->m_blacklist->getData();
        $idpemborong = $this->session->userdata('idpemborong');
// //        $data['_getPemborong']= $this->m_blacklist->get_pemborong_bygroup($idpemborong)->result();
        $data['_getPSGPemorong'] = $this->m_blacklist->getPSGPemborong($idpemborong);
        
        $this->session->set_flashdata("regid",0);
//         //echo $idpemborong;
        $this->template->display('registrasi/blacklist/index',$data);
    }

    function selectPemborong(){
        $this->load->model('m_blacklist');
        if('IS_AJAX') {
            $data['namapt'] = $this->m_blacklist->getPemborong();
            $this->load->view('registrasi/blacklist/perusahaan',$data);
        }
    }

    function tambah(){
        //====================Simpan Data
        $data= array('NIK'      => strtolower($this->input->post('txtNIK')),
            'CVNama'            => $this->input->post('txtPerusahaan'),
            'Pemborong'         => $this->input->post('txtPemborong'),
            'DeptID'            => strtoupper($this->input->post('comboDept')),
			'TglLahir'          => $this->input->post('txttgllahir'),
			'DaerahAsal'        => $this->input->post('txtdaerahasal'),
            'TglMasuk'          => $this->input->post('txtMasuk'),
            'TglKeluar'         => $this->input->post('txtKeluar'),
            'NamaIbuKandung'    => $this->input->post('txtNamaIbu'),
            'Remark'            => $this->input->post('txtKeterangan'),
            'created_by'        => strtoupper($this->session->userdata('username')),
            'created_date'      => date('Y-m-d H:i:s')
        );
        $NIK = array( 'NIK' => strtolower($this->input->post('txtNIK')) );
        $this->load->model('m_blacklist');
        // $this->m_blacklist->saveDetail($NIK);
        $result = $this->m_blacklist->save($data);

        if(!$result){
            redirect('blacklist/listBlacklist?msg=success_add');
        }else{
            $data['pesan']="<p class='alert alert-danger'>Gagal Tambah User.. </p>";
            $this->template->display('registrasi/blacklist/index',$data);
        }
    }

    function save(){
        $cek = $this->db->query("SELECT * FROM tblTrnBlacklist WHERE NIK='".$this->input->post('txtFindBynik')."'")->num_rows();
        if($cek<=0){
        $data= array('Nama'  => $this->input->post('txtnama'),
            'NIK'            => strtolower($this->input->post('txtFindBynik')),
            'CVNama'         => $this->input->post('txtperusahaan'),
            'Pemborong'      => $this->input->post('txtpemborong'),
            'DeptAbbr'       => $this->input->post('txtdept'),
			'TglLahir'       => date('Y-m-d', strtotime($this->input->post('txttgllahir'))),
			'DaerahAsal'     => $this->input->post('txtdaerahasal'),
            'TglMasuk'       => date('Y-m-d', strtotime($this->input->post('txttglmasuk'))),
            'TglKeluar'      => date('Y-m-d', strtotime($this->input->post('txttglkeluar'))),
            'NamaIbuKandung' => $this->input->post('txtnmibukandung'),
            'Remark'         => $this->input->post('txtketerangan'),
            'created_by'     => strtoupper($this->session->userdata('username')),
            'created_date'   => date('Y-m-d H:i:s'),
			'Status'         => 'Blacklist'
        );
        $NIK = array( 'NIK' => strtolower($this->input->post('txtFindBynik')) );
        $this->load->model('m_blacklist');
        // $this->m_blacklist->saveDetail($NIK);
        $result = $this->m_blacklist->save($data);

        $this->session->set_flashdata('message','<div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    Data Berhasil di Tambah...!!!
                </div>');
        redirect('blacklist/listBlacklist?msg=success_add','refresh');
    } else {
        $this->session->set_flashdata('message', 
                '<div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    Mohon Maaf NIP sudah Terdaftar...!!!
                </div>');
            redirect('blacklist/listBlacklist?msg=failed_add','refresh');
    }
        // if(!$result){
        //     redirect('blacklist/listBlacklist?msg=success_add');
        // }else{
        //     $data['pesan']="<p class='alert alert-danger'>Gagal Tambah User.. </p>";
        //     $this->template->display('registrasi/blacklist/index',$data);
        // }
    }

    function listBlacklist(){
        $this->load->model('m_blacklist');
        $data['getBlacklistK'] = $this->m_blacklist->selectBlacklistK();
        $data['getBlacklistTK'] = $this->m_blacklist->selectBlacklistTK();
        //$data['getGrupUser'] = $this->m_user_login->selectGrupUser($id);
        
        $this->template->display('monitor/blacklist/index',$data);
    }
	
	

    function detail(){
        if('IS_AJAX') {
            $kode=$this->input->post('kode');
            $data['datatk'] = $this->m_blacklist->get_detailtk($kode)->result();
            $this->load->view('monitor/blacklist/detail',$data);
        }
    }

    function editBlacklistK(){
        $this->load->model('m_blacklist');

        $id = $this->input->get('id');
		$data['getUserK'] = $this->m_blacklist->getBlacklistK($id);
        $this->template->display('monitor/blacklist/editBlacklistK',$data);
    }
	
	//function editBlacklistTK(){
    //    $this->load->model('m_blacklist');

    //    $id = $this->input->get('id');
    //    $data['getUserTK'] = $this->m_blacklist->getBlacklistTK($id);
    //    $this->load->view('monitor/blacklist/editBlacklistTK',$data);
    //}
	
	function editBlacklistTK(){
        if('IS_AJAX') {
            $id=$this->input->post('kode');
            $data['getUserTK'] = $this->m_blacklist->getBlacklistTK($id)->result();
            $this->load->view('monitor/blacklist/editBlacklistTK',$data);
        }
    }

    function photo(){
        if('IS_AJAX') {
            $data['NIK'] = $this->input->post('kode');
            //$data['datatk'] = $this->m_wawancara->getDetailTK($kode)->result();
            $this->load->view('monitor/blacklist/changePhoto',$data);
        }
    }

    function doEditFoto(){
        $NIK  = $this->input->get('id');
        $this->session->set_flashdata("NIK",$NIK);
        
        redirect('blacklist/uploadFoto');
    }

    function uploadAksi(){
        $this->load->model('m_blacklist');
        $this->load->library('image_moo');

        $url = './dataupload/fotoBlacklist/';
        $NIK = $this->input->post("txtNIK");
        $filefoto = $NIK;

        $config['upload_path']      = $url;
        $config['allowed_types']    = 'jpeg|jpg|png|gif';
        $config['allow_scale_up']   = true;
        $config['overwrite']        = true;
        $config['max_size']         = '0';
        $config['file_name']        = $filefoto.'.jpg'; //Filename harus pakai headerID pelamar

        $font = "./assets/DroidSans.ttf";
        $watermarkbg = "./assets/watermarkbg.png";

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
                ->resize(300,300)
                ->round(10)
                ->load_watermark($watermarkbg,0,0)
                ->watermark(2,-1)
                ->make_watermark_text("REQ.".$filefoto,$font,14,"#FFFF00")
                ->watermark(2)
                ->save($fileNameResize,true)
                ;

            if ($this->image_moo->errors){
                $error = $files['file_name']."<br/>".$this->image_moo->display_errors();
                $data['errormsg']="<div class='alert alert-danger'><a class='close' data-dismiss='alert'>×</a><i class='fa fa-info-circle'>&nbsp;</i><strong>Image Moo Failed</strong><br/>$error</div>";
                $data['NIK']=$NIK;

                $this->template->display('registrasi/blacklist/upload_foto',$data);

            }else{
                $this->m_blacklist->update_status_foto($NIK);
                $this->image_moo->clear();
                $this->session->set_flashdata("regid",$NIK);
                redirect("blacklist/listBlacklist");
            }
        }else{
                $error = $this->upload->display_errors();
                $data['errormsg']="<div class='alert alert-danger'><a class='close' data-dismiss='alert'>×</a><i class='fa fa-info-circle'>&nbsp;</i><strong>Unggah Foto Gagal</strong><br/>$error</div>";
                $data['NIK']=$NIK;

                $this->template->display('registrasi/blacklist/upload_foto',$data);

        }

        $this->image_moo->clear();
    }

    function ajaxblacklistK($nik){               
        $data['_getData']   = $this->m_blacklist->getDataBlacklistK($nik);
        $data['_cekData']   = $this->m_blacklist->getDataBlacklistK($nik);
        $this->load->view('registrasi/blacklist/ajaxblacklistK', $data);   
    }

    function ajaxblacklistTK($nik){               
        $data['_getData']   = $this->m_blacklist->getDataBlacklistTK($nik);
        $data['_cekData']   = $this->m_blacklist->getDataBlacklistTK($nik);
        $this->load->view('registrasi/blacklist/ajaxblacklistTK', $data);   
    }
	
	function ajaxeditblacklistTK($nik){
		$data['_getData']   = $this->m_blacklist->getDataBlacklistTK($nik);
        $data['_cekData']   = $this->m_blacklist->getDataBlacklistTK($nik);
		$this->load->view('registrasi/blacklist/editTK', $data);  
	}

    function Karyawan(){
        // $this->db->model('m_blacklist');
        // $data['_getKaryawan'] = $this->m_blacklist->getkaryawan();
        $this->template->display('registrasi/blacklist/karyawan');
    }

    function TenagaKerja(){
        // $this->db->model('m_blacklist');
        // $data['_getKaryawan'] = $this->m_blacklist->getkaryawan();
        $this->template->display('registrasi/blacklist/TenagaKerja');
    }

    function getDataKaryawanByNIK(){
        $nik    = $this->input->post('txtFindByNIK');
        $check  = $this->Mdl_SuratSakit->getMstAllKaryByNIK($nik)->num_rows();
    }

    function cekKBlacklist($nik){
        if($this->m_blacklist->chekedKBlacklist($nik,$nama) == TRUE){
            $this->form_validation->set_message('cekKBlacklist',"$nik sudah di BLACKLIST oleh perusahaan");
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
	function detailByPass(){
        $this->load->model('m_blacklist');

        $id = $this->input->get('id');
        $data['getByPass'] = $this->m_blacklist->getBlacklistbypass($id);
		$nik   = $this->input->post('txtFindNIK');
		$data['databypass'] = $this->m_blacklist->get_detailbypass($nik)->result();
        $this->load->view('monitor/blacklist/detailByPass',$data);
    }
	
	function listBlacklistByPass(){
        $this->load->model('m_blacklist');
        $data['getBlacklistByPass'] = $this->m_blacklist->selectBlacklistByPass();
        $this->template->display('monitor/blacklist/listBlacklistbypass',$data);
    }
	
	function blacklistbypass(){
        $idpemborong = $this->session->userdata('idpemborong');
        $data['_getPSGPemorong'] = $this->m_blacklist->getPSGPemborong($idpemborong);
        $this->template->display('registrasi/blacklist/blacklistbypass',$data);
    }
	
	function savebypass(){
        $cek = $this->db->query("SELECT * FROM tblTrnBlacklistTemporary WHERE NIK='".$this->input->post('txtFindBynik')."'")->num_rows();
        if($cek<=0){
        $data= array('Nama'  => $this->input->post('txtnama'),
            'NIK'            => strtolower($this->input->post('txtFindBynik')),
            'Perusahaan'     => $this->input->post('txtPerusahaan'),
            'Pemborong'      => $this->input->post('txtPemborong'),
            'DeptAbbr'       => $this->input->post('txtdept'),
			'TGLLAHIR'       => date('Y-m-d', strtotime($this->input->post('txttgllahir'))),
			'DaerahAsal'     => $this->input->post('txtdaerahasal'),
			'DeptAbbr'       => $this->input->post('txtdept'),
            'TGLMASUK'       => date('Y-m-d', strtotime($this->input->post('txttglmasuk'))),
            'TGLKELUAR'      => date('Y-m-d', strtotime($this->input->post('txttglkeluar'))),
            'NamaIbuKandung' => $this->input->post('txtnmibukandung'),
            'Remark'         => $this->input->post('txtketerangan'),
            'createdBy'     => strtoupper($this->session->userdata('username')),
            'createdDate'   => date('Y-m-d H:i:s')
        );
        $Pemborong  = array( 'Pemborong' => strtoupper($this->input->post('txtperusahaan')) );
        $NIK = array( 'NIK' => strtolower($this->input->post('txtFindBynik')) );
        $this->load->model('m_blacklist');
        $result = $this->m_blacklist->savebypass($data);

        $this->session->set_flashdata('message','<div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    Data Berhasil di Tambah...!!!
                </div>');
        redirect('blacklist/listBlacklistbypass?msg=success_add','refresh');
        } else {
            $this->session->set_flashdata('message', 
                    '<div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        Mohon Maaf NIP sudah Terdaftar...!!!
                    </div>');
                redirect('blacklist/listBlacklistbypass?msg=failed_add','refresh');
        }
    }
}