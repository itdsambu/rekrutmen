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

    function updateBorongan(){
        $Nik        = $this->input->post('txtFindBynik');
        $nama       = $this->input->post('txtnama');
        $tgllahir   = $this->input->post('txttgllahir');
        $namaibu    = $this->input->post('txtnmibukandung');
        $perusahaan = $this->input->post('txtperusahaan');
        $pemborong  = $this->input->post('txtpemborong');
        $dept       = $this->input->post('txtdept');
        $tglmasuk   = $this->input->post('txttglmasuk');
        $tglkeluar  = $this->input->post('txttglkeluar');
        $keterangan = $this->input->post('txtketerangan');
        $type       = $this->input->post('txttype');
        $fixno      = $this->input->post('txtfixno');
        // $headerid = $this->input->post('headerid');

                //-------------------------------- HEADER -----------------------------------------//
            $data= array(

                'CVNama'         => $perusahaan,
                'Pemborong'      => $pemborong,
                'NIK'            => $this->input->post('txtFindBynik'),
                'BagianAbbr'     => $dept,
                'TglMasuk'       => $tglmasuk,
                'TglKeluar'      => $tglkeluar,
                'Remark'         => $keterangan,
                'NamaIbuKandung' => $namaibu,
                'created_by'     => strtoupper($this->session->userdata('username')),
                'created_date'   => date('Y-m-d H:i:s'),
                'Nama'           => $nama,
                'Status'         => 1,
                // 'Sosmed'
                'TanggalLahir'   => $tgllahir,
                'TypeTK'         => 0,
                'FixNo'          => $fixno,
            );
        // echo $Nik;
        $result  = $this->m_blacklist->tambah_datablacklistborongan($data);
        // echo $Nik;
        if(!$result){
            redirect('blacklist/vwkaryawan?msg=success_add','refresh');
        }else{
            redirect('blacklist/vwkaryawan?msg=failed_add','refresh');
        }
    }

    function tambahdatabalcklistcalontk(){
        $headerid   = $this->input->post('txtFindBynik');
        $nik        = $this->input->post('txtnik');
        $nama       = $this->input->post('txtnama');
        $tgllahir   = $this->input->post('txttgllahir');
        $namaibu    = $this->input->post('txtnmibukandung');
        $perusahaan = $this->input->post('txtperusahaan');
        $pemborong  = $this->input->post('txtpemborong');
        $dept       = $this->input->post('txtdept');
        $tglmasuk   = $this->input->post('txttglmasuk');
        $tglkeluar  = $this->input->post('txttglkeluar');
        $keterangan = $this->input->post('txtketerangan');
         //-------------------------------- HEADER -----------------------------------------//
            $data= array(

                'HeaderID'          => $this->input->post('txtFindBynik'),
                'NIK'               => $nik,
                'Nama'              => $nama,
                'NamaIbuKandung'    => $namaibu,
                'TanggalLahir'      => $tgllahir,
                'TanggalMasuk'      => $tglmasuk,
                'TanggalKeluar'     => $tglkeluar,
                'Pemborong'         => $pemborong,
                'NamaCV'            => $perusahaan,
                'Keterangan'        => $keterangan,
                'Created_by'        => strtoupper($this->session->userdata('username')),
                'Created_date'      => date('Y-m-d H:i:s'),
                'Blacklist'         => 1,
                'Blacklist_by'      => strtoupper($this->session->userdata('username')),
                'Blacklist_date'    => date('Y-m-d')
            );
            // echo $headerid;
            // echo $nik;
        $result  = $this->m_blacklist->tambah_balcklistcalonTK($data);
        // // echo $Nik;
        if(!$result){
            redirect('blacklist/vwkaryawan?msg=success_add','refresh');
        }else{
            redirect('blacklist/vwkaryawan?msg=failed_add','refresh');
        }
    }
        
    function save(){
        $cek = $this->db->query("SELECT * FROM tblTrnBlacklist WHERE NIK='".$this->input->post('txtFindBynik')."'")->num_rows();
        if($cek<=0){
        $data= array(
            'Nama'           => $this->input->post('txtnama'),
            'NIK'            => strtolower($this->input->post('txtFindBynik')),
            'CVNama'         => $this->input->post('txtperusahaan'),
            'Pemborong'      => $this->input->post('txtpemborong'),
            'DeptAbbr'       => $this->input->post('txtdept'),
            'TglMasuk'       => date('Y-m-d', strtotime($this->input->post('txttglmasuk'))),
            'TglKeluar'      => date('Y-m-d', strtotime($this->input->post('txttglkeluar'))),
            'NamaIbuKandung' => $this->input->post('txtnmibukandung'),
            'Remark'         => $this->input->post('txtketerangan'),
            'created_by'     => strtoupper($this->session->userdata('username')),
            'created_date'   => date('Y-m-d H:i:s'),
            'sosmed'         => $this->input->post('txtsosmed'),
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

    function vwkaryawan(){
        $this->load->model('m_blacklist');
        $data['getBlacklistK']           = $this->m_blacklist->selectBlacklistK();
        $data['getBlacklistTK']          = $this->m_blacklist->selectBlacklistTK();
        $data['get_blacklistCalonTK']    = $this->m_blacklist->selectcalonblacklist();
        
        $this->template->display('monitor/blacklist/vwkaryawan',$data);
    }

    function detail(){
        if('IS_AJAX') {
            $kode=$this->input->post('kode');
            $data['datatk'] = $this->m_blacklist->get_detailtk($kode)->result();
            $this->load->view('monitor/blacklist/detail',$data);
        }
    }

    function updateKaryawan(){
            $nik            = $this->input->post('txtFindBynik');
            $regno          = $this->input->post('txtregno');
            $nama           = $this->input->post('txtnama');
            $tgllahir       = $this->input->post('txttgllahir');
            $perusahaan     = $this->input->post('txtperusahaan');
            $departemen     = $this->input->post('txtdept');
            $tglmasuk       = $this->input->post('txttglmasuk');
            $tglkeluar      = $this->input->post('txttglkeluar');
            $keterangan     = $this->input->post('txtketerangan');
            $blacklist      = $this->input->post('txttype');

            $data = array(
                // 'TGLKELUAR'         => date('Y-m-d', strtotime($tglkeluar)),
                'Blacklist'         => 1,
                'Blacklist_ket'     => $keterangan,
                'Blacklist_by'      => strtoupper($this->session->userdata('username')),
                'Blacklist_date'    => date('Y-m-d H:i:s')
            );
        // echo $nik.'-'.$regno.'-'.$nama.'-'.$tgllahir.'-'.$perusahaan.'-'.$departemen.'-'.$tglmasuk.'-'.$tglkeluar.'-'.$keterangan.'-'.$blacklist;
        $result = $this->m_blacklist->update_blacklist($regno,$data);
        if(!$result){
            redirect('blacklist/vwkaryawan?msg=success_add','refresh');
        }else{
            redirect('blacklist/vwkaryawan?msg=failed_add','refresh');
        }
    }

    function editBlacklist(){
        $this->load->model('m_blacklist');

        $id = $this->input->get('id');
        $data['getUser'] = $this->m_blacklist->getBlacklist($id);
        $this->template->display('monitor/blacklist/editBlacklist',$data);
    }

    function editBlacklistK(){
        $this->load->model('m_blacklist');

        $id = $this->input->get('id');
        $data['getUser'] = $this->m_blacklist->getBlacklistK($id);
        $this->template->display('monitor/blacklist/editBlacklistK',$data);
    }

    function editCalonBlacklist(){
        $this->load->model('m_blacklist');

        $id = $this->uri->segment(3);

        // echo $id;
        $data['getUser'] = $this->m_blacklist->getCalonBlacklist($id);
        $this->template->display('monitor/blacklist/editCalonBlacklistTK',$data);
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

    function ajaxblacklistcalontk(){
        // $hdrid          = $this->input->post('nik');
        $hdrid = $this->uri->segment(3);
        $data['hdrid']  = $hdrid;

        $data['_getData']   = $this->m_blacklist->getDataCalonTenagaKerja($hdrid);
        $data['_cekData']   = $this->m_blacklist->getDataCalonTenagaKerja($hdrid);
        $this->load->view('registrasi/blacklist/ajaxCalonBlacklist', $data);   
    }

    function Karyawan(){
        $data['get_Data'] = $this->m_blacklist->karyawankeluar();

        $this->template->display('registrasi/blacklist/karyawan',$data);
    }

    function borongan(){
        $this->template->display('registrasi/blacklist/borongan');
    }

     function tambahBalklistCalonTK(){
        $this->template->display('registrasi/blacklist/BlacklistCalonTK');
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

    function ExportToExcel(){
        $this->load->library("Excel/PHPExcel");
       
        $data['getExcelTenagaKerja']          = $this->m_blacklist->get_excel1();

        $this->load->view('monitor/blacklist/ExportToExcell1',$data);
    }
    function ExportToExcel2(){
        $this->load->library("Excel/PHPExcel");
       
        $data['getExcelTenagaKerja2']     = $this->m_blacklist->get_excel2();

        $this->load->view('monitor/blacklist/ExportToExcell2',$data);
    }
    function ExportToExcel3(){
        $this->load->library("Excel/PHPExcel");
       
        $data['getExcelTenagaKerja3']          = $this->m_blacklist->get_excel3();

        $this->load->view('monitor/blacklist/ExportToExcell3',$data);
    }

    function blacklistpsg(){

        $data['getBlacklistPSGtK']  = $this->m_blacklist->get_dataBlacklistKPSG();
        $data['getBlacklistPSGTK']  = $this->m_blacklist->get_dataBlacklistTKPSG();

        $this->template->display('monitor/blacklist/listblacklistpsg',$data);
    }

    function get_dataBlacklistK(){
        $id = $this->input->get('id');
        $data['get_Data'] = $this->m_blacklist->get_DatablacklistK($id);

        $this->template->display('monitor/blacklist/detailblacklistPSGK',$data);
    }

    function get_dataBlacklistTK(){
        $id = $this->input->get('id');
        $data['get_Data'] = $this->m_blacklist->get_DatablacklistTK($id);

        $this->template->display('monitor/blacklist/detailblacklistPSGTK',$data);
    }
}