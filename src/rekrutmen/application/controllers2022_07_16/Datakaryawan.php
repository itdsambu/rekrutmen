<?php
class Datakaryawan extends CI_Controller{
    public function __construct() {
        parent:: __construct();
        $this->load->model("m_datakaryawan");
        $this->load->library("pagination");
        $this->load->helper(array("url","form"));
    }


    function viewDocs(){
        if('IS_AJAX') {
            $userID=$this->input->post('kode');
            $berkas=$this->input->post('nama');
            $fixno=$this->input->post('fixno');
            $data['_jenisBerkas'] = $berkas;
            $urlktp = $this->m_datakaryawan->getDocs($fixno);
            if ($urlktp->HeaderID != null) {
                $data['_urlktp'] = $urlktp->KTP;
            } else {
                $data['_urlktp'] = './dataupload/berkas/ktp_fixno/2_'.$fixno.'_ktp.pdf';
            }
            $this->load->view('datakaryawan/listuploadktp/viewDocs',$data);  
        }
    }

    function viewDocsKaryawan(){
        if('IS_AJAX') {
            $userID=$this->input->post('kode');
            $berkas=$this->input->post('nama');
            $regno=$this->input->post('regno');
            $data['_jenisBerkas'] = $berkas;
            $urlktp = $this->m_datakaryawan->getDocsKaryawan($regno);
            if ($urlktp->HeaderID != null) {
                $data['_urlktp'] = $urlktp->KTP;
            } else {
                $data['_urlktp'] = './dataupload/berkas/ktp_fixno/1_'.$regno.'_ktp.pdf';
            }
            $this->load->view('datakaryawan/listuploadktp/viewDocs',$data);  
        }
    }

// --------------- List Upload KTP Harian --------
    function listuploadktp() {
        $dataSelect       = $this->uri->segment(3);
        $num              = $this->uri->segment(4);

        if($num == FALSE && $dataSelect == FALSE){
            redirect('datakaryawan/listuploadktp/0/1');
        } elseif ($num == FALSE){
            redirect('datakaryawan/listuploadktp/'.$dataSelect.'/1');
        }

        $data['all_dept'] = $this->m_datakaryawan->getdept_payboro();

        $numStart           = $num-1;
        $start              = 1;
        $end                = 0;
        $startPaging        = ((int)$numStart*50).$start;
        $endPaging          = ((int)$num*50).$end;

        if($dataSelect == 0){ //All Data TenagaKerja
            $total                  = $this->m_datakaryawan->countAllTenaker();
            $data['_selected']      = $dataSelect;
            $data['_selectedDept']  = '';
            $data['_selectWhere']   = $this->m_datakaryawan->selectAllTenakerKTP($startPaging,$endPaging);
            $data['_pagination']    = $this->pagination2($page = $num, 500, $total);
        } else if($dataSelect == 1){ // Data Tenaga Kerja Reg ID ter-register/ter-daftar
            $total                  = $this->m_datakaryawan->countRegisteredTenaker();
            $data['_selected']      = $dataSelect;
            $data['_selectedDept']  = '';
            $data['_selectWhere']   = $this->m_datakaryawan->selectTenakerKTPRegistered($startPaging,$endPaging);
            $data['_pagination']    = $this->pagination2($page = $num, 500, $total);
        } else if($dataSelect == 2){ // Data Tenaga Kerja Reg ID unregister/tidak terdaftar
            $total                  = $this->m_datakaryawan->countUnRegisteredTenaker();
            $data['_selected']      = $dataSelect;
            $data['_selectedDept']  = '';
            $data['_selectWhere']   = $this->m_datakaryawan->selectTenakerKTPUnRegistered($startPaging,$endPaging);
            $data['_pagination']    = $this->pagination2($page = $num, 500, $total);
        } else {
            $total                  = NULL;
            $data['_selected']      = NULL;
            $data['_selectedDept']  = NULL;
            $data['_selectWhere']   = NULL;
            $data['_pagination']    = NULL;
        }

        $this->template->display('datakaryawan/listuploadktp/index',$data);
    }

    function filterdata() {
        $this->session->unset_userdata('w_nofix');
        $this->session->unset_userdata('w_dept');

        if($this->input->post('txtNofix') == NULL && $this->input->post('txtDept') == NULL){
            redirect('datakaryawan/listuploadktp/0/1');
        }

        $this->session->set_userdata('w_nofix', $this->input->post('txtNofix'));
        $this->session->set_userdata('w_dept', $this->input->post('txtDept'));

        $dataSelect = $this->input->post('txtStatusKtp');

        redirect('datakaryawan/listuploadktpWhere/'.$dataSelect.'/1');
    }

    function listuploadktpWhere(){
        $dataSelect             = $this->uri->segment(3);
        $num                    = $this->uri->segment(4);

        $data['all_dept'] = $this->m_datakaryawan->getdept_payboro();
        
        $nofix  = $this->session->userdata('w_nofix');
        $dept   = $this->session->userdata('w_dept');
        
        $numStart               = $num-1;
        $start                  = 1;
        $end                    = 0;
        $startPaging            = ((int)$numStart*50).$start;
        $endPaging              = ((int)$num*50).$end;
        
        if($dataSelect == 0){ //All Data TenagaKerja
            $total                 = $this->m_datakaryawan->countAllTenakerWhere($nofix,$dept);
            $data['_selected']     = $dataSelect; 
            $data['_selectedDept'] = $dept;
            $data['_selectWhere']  = $this->m_datakaryawan->selectAllTenakerKTPWhere($startPaging,$endPaging,$nofix,$dept);
            $data['_pagination']   = $this->pagination2($page = $num, 500, $total);
        } else if($dataSelect == 1){ // Data Tenaga Kerja Reg ID ter-register/ter-daftar
            $total                 = $this->m_datakaryawan->countRegisteredTenakerWhere($nofix,$dept);
            $data['_selected']     = $dataSelect;
            $data['_selectedDept'] = $dept;
            $data['_selectWhere']  = $this->m_datakaryawan->selectTenakerKTPRegisteredWhere($startPaging,$endPaging,$nofix,$dept);
            $data['_pagination']   = $this->pagination2($page = $num, 500, $total);
        } else if($dataSelect == 2){ // Data Tenaga Kerja Reg ID unregister/tidak terdaftar
            $total                 = $this->m_datakaryawan->countUnRegisteredTenakerWhere($nofix,$dept);
            $data['_selected']     = $dataSelect;
            $data['_selectedDept'] = $dept;
            $data['_selectWhere']  = $this->m_datakaryawan->selectTenakerKTPUnRegisteredWhere($startPaging,$endPaging,$nofix,$dept);
            $data['_pagination']   = $this->pagination2($page = $num, 500, $total);
        } else{
            $total                 = NULL;
            $data['_selected']     = NULL;
            $data['_selectedDept'] = NULL;
            $data['_selectWhere']  = NULL;
            $data['_pagination']   = NULL;
        }

        $this->template->display('datakaryawan/listuploadktp/index',$data);
    }

    function doUploadKTP() {
        $hdrid           = $this->input->get('id');
        $nama            = $this->input->get('nama');
        $fixno           = $this->input->get('fixno');

        $this->session->set_flashdata("hdrid",$hdrid);
        $this->session->set_flashdata("namatk",$nama);
        $this->session->set_flashdata("fixno",$fixno);

        redirect('datakaryawan/HalUploadKTP');
    }

    function HalUploadKTP() {
        $fixno          = $this->session->flashdata("fixno");
        $hdrid          = $this->session->flashdata("hdrid");
        $nama           = $this->session->flashdata("namatk");

        $this->session->keep_flashdata("hdrid");
        $this->session->keep_flashdata("fixno");
        $this->session->keep_flashdata("namatk");

        $data['hdrid']  = $hdrid;
        $data['fixno']  = $fixno;
        $data['namatk'] = $nama;
        if ($fixno != "" || $fixno != NULL) {
         $this->template->display('datakaryawan/Upload_KTP/upload_ktp',$data);       
        } else {
         redirect('datakaryawan/listuploadktp');
        }
        
    }

    function do_upload(){
        $hdrid                    = $this->input->post("txtHeaderID");
        $fixno                    = $this->input->post("txtFixNo");
        $namatk                   = $this->input->post("txtNamaTK");

        $berkas                   = 'ktp';
        $namaberkas               = "KTP";
        
        if ($hdrid != '' || $hdrid != null) { //Untuk data yang teregistrasi di RO
            $url  = './dataupload/berkas/ktp';
            $namafile = $hdrid.'_'.$berkas;
        } else { //TenagaKerja = 2
            $url  = './dataupload/berkas/ktp_fixno';
            $namafile = '2_'.$fixno.'_'.$berkas;
        }
        
        $data['namatk']           = $namatk;

        $config['upload_path']    = $url;
        $config['allowed_types']  = 'pdf';
        $config['allow_scale_up'] = TRUE;
        $config['overwrite']      = TRUE;
        $config['file_name']      = $namafile;
        $config['max_size']       = '5120';

        $this->load->library('upload', $config);
        // var_dump( $this->upload->do_upload('userfile2')); die;
        // $this->upload->initialize($config);

        if( $this->upload->do_upload('userfile2')){ //Untuk data yang teregistrasi di RO update tblberkas
            $this->upload->data();
            if ($hdrid != '' || $hdrid != null) {
                $this->m_datakaryawan->update_db_berkas($hdrid,$berkas,$url.'/'.$namafile.'.pdf');
            }
            echo "<script>alert('Simpan Berkas $namaberkas Berhasil !!');</script>";
        }else{
            $error = $this->upload->display_errors();
            echo "<script>alert('Simpan Berkas $namaberkas Gagal !!');</script>";
            
        }  

        redirect('datakaryawan/listuploadktp', 'refresh');
    }

// --------------- List Upload KTP Karyawan --------
     function listuploadktpkaryawan() {
        $dataSelect       = $this->uri->segment(3);
        $num              = $this->uri->segment(4);

        if($num == FALSE && $dataSelect == FALSE){
            redirect('datakaryawan/listuploadktpkaryawan/0/1');
        } elseif ($num == FALSE){
            redirect('datakaryawan/listuploadktpkaryawan/'.$dataSelect.'/1');
        }

        $data['all_dept'] = $this->m_datakaryawan->getdept_payroll(); //get departemen

        $numStart           = $num-1;
        $start              = 1;
        $end                = 0;
        $startPaging        = ((int)$numStart*50).$start;
        $endPaging          = ((int)$num*50).$end;

        if($dataSelect == 0){ //All Data Karyawan
            $total                  = $this->m_datakaryawan->countKaryawanAktifAll();
            $data['_selected']      = $dataSelect;
            $data['_selectedDept']  = ''; 
            $data['_selectWhere']   = $this->m_datakaryawan->selectKTPAllKaryawan($startPaging,$endPaging);
            $data['_pagination']    = $this->pagination2($page = $num, 500, $total);
        } else if($dataSelect == 1){ // Data Karyawan Reg ID ter-register/ter-daftar
            $total                  = $this->m_datakaryawan->countKaryawanRegistered();
            $data['_selected']      = $dataSelect;
            $data['_selectedDept']  = ''; 
            $data['_selectWhere']   = $this->m_datakaryawan->selectKTPRegisteredKaryawan($startPaging,$endPaging);
            $data['_pagination']    = $this->pagination2($page = $num, 500, $total);
        } else if($dataSelect == 2){ // Data Karyawan Reg ID unregister/tidak terdaftar
            $total                  = $this->m_datakaryawan->countKaryawanUnRegistered();
            $data['_selected']      = $dataSelect;
            $data['_selectedDept']  = ''; 
            $data['_selectWhere']   = $this->m_datakaryawan->selectKTPUnRegisteredKaryawan($startPaging,$endPaging);
            $data['_pagination']    = $this->pagination2($page = $num, 500, $total);
        } else {
            $total                  = NULL;
            $data['_selected']      = NULL;
            $data['_selectedDept']  = NULL; 
            $data['_selectWhere']   = NULL;
            $data['_pagination']    = NULL;
        }

        $this->template->display('datakaryawan/listuploadktp/index_karyawan',$data);
    }

    function filterkaryawandata() {
        $this->session->unset_userdata('w_regno');
        $this->session->unset_userdata('w_dept');

        if($this->input->post('txtRegno') == NULL && $this->input->post('txtDept') == NULL){
            redirect('datakaryawan/listuploadktpkaryawan/0/1');
        }

        $this->session->set_userdata('w_regno', $this->input->post('txtRegno'));
        $this->session->set_userdata('w_dept', $this->input->post('txtDept'));
        $dataSelect = $this->input->post('txtStatusKtp');

        redirect('datakaryawan/listuploadktpKaryawanWhere/'.$dataSelect.'/1');
    }

    function listuploadktpKaryawanWhere(){
        $dataSelect             = $this->uri->segment(3);
        $num                    = $this->uri->segment(4);

        
        $regno  = $this->session->userdata('w_regno');
        $dept   = $this->session->userdata('w_dept');

        $data['all_dept'] = $this->m_datakaryawan->getdept_payroll(); //get departemen
        
        $numStart               = $num-1;
        $start                  = 1;
        $end                    = 0;
        $startPaging            = ((int)$numStart*50).$start;
        $endPaging              = ((int)$num*50).$end;
        
        if($dataSelect == 0){ //All Data Karyawan
            $total                 = $this->m_datakaryawan->countKaryawanAllAktifWhere($regno,$dept);
            $data['_selected']     = $dataSelect; 
            $data['_selectedDept'] = $dept; 
            $data['_selectWhere']  = $this->m_datakaryawan->selectKTPAllKaryawanWhere($startPaging,$endPaging,$regno,$dept);
            $data['_pagination']   = $this->pagination($page = $num, 500, $total);
        } else if($dataSelect == 1){ // Data Karyawan Reg ID ter-register/ter-daftar
            $total                  = $this->m_datakaryawan->countKaryawanRegisteredWhere($regno,$dept);
            $data['_selected']      = $dataSelect;
            $data['_selectedDept']  = $dept; 
            $data['_selectWhere']   = $this->m_datakaryawan->selectKTPRegisteredKaryawanWhere($startPaging,$endPaging,$regno,$dept);
            $data['_pagination']    = $this->pagination2($page = $num, 500, $total);
        } else if($dataSelect == 2){ // Data Karyawan Reg ID unregister/tidak terdaftar
            $total                  = $this->m_datakaryawan->countKaryawanUnRegisteredWhere($regno,$dept);
            $data['_selected']      = $dataSelect;
            $data['_selectedDept']  = $dept; 
            $data['_selectWhere']   = $this->m_datakaryawan->selectKTPUnRegisteredKaryawanWhere($startPaging,$endPaging,$regno,$dept);
            $data['_pagination']    = $this->pagination2($page = $num, 500, $total);
        } else{ 
            $total                 = NULL;
            $data['_selected']     = NULL;
            $data['_selectedDept'] = NULL; 
            $data['_selectWhere']  = NULL;
            $data['_pagination']   = NULL;
        }

        $this->template->display('datakaryawan/listuploadktp/index_karyawan',$data);
    }

    function doUploadKaryawanKTP() {
        $hdrid           = $this->input->get('id');
        $nama            = $this->input->get('nama');
        $regno           = $this->input->get('regno');

        $this->session->set_flashdata("hdrid",$hdrid);
        $this->session->set_flashdata("namatk",$nama);
        $this->session->set_flashdata("regno",$regno);

        redirect('datakaryawan/HalUploadKaryawanKTP');
    }

    function HalUploadKaryawanKTP() {
        $regno          = $this->session->flashdata("regno");
        $hdrid          = $this->session->flashdata("hdrid");
        $nama           = $this->session->flashdata("namatk");

        $this->session->keep_flashdata("hdrid");
        $this->session->keep_flashdata("regno");
        $this->session->keep_flashdata("namatk");

        $data['hdrid']  = $hdrid;
        $data['regno']  = $regno;
        $data['namatk'] = $nama;
        if ($regno != "" || $regno != NULL) {
         $this->template->display('datakaryawan/Upload_KTP/upload_karyawanktp',$data);       
        } else {
         redirect('datakaryawan/listuploadktpkaryawan');
        }
        
    }

    function do_upload_karyawan(){
        $hdrid                    = $this->input->post("txtHeaderID");
        $regno                    = $this->input->post("txtRegNo");
        $namatk                   = $this->input->post("txtNamaTK");

        $berkas                   = 'ktp';
        $namaberkas               = "KTP";
        
        if ($hdrid != '' || $hdrid != null) { //Untuk data yang teregistrasi di RO
            $url  = './dataupload/berkas/ktp';
            $namafile = $hdrid.'_'.$berkas;
        } else { //Karyawan = 1
            $url  = './dataupload/berkas/ktp_fixno';
            $namafile = '1_'.$regno.'_'.$berkas;
        }
        
        $data['namatk']           = $namatk;

        $config['upload_path']    = $url;
        $config['allowed_types']  = 'pdf';
        $config['allow_scale_up'] = TRUE;
        $config['overwrite']      = TRUE;
        $config['file_name']      = $namafile;
        $config['max_size']       = '5120';

        $this->load->library('upload', $config);
        // var_dump( $this->upload->do_upload('userfile2')); die;
        // $this->upload->initialize($config);

        if( $this->upload->do_upload('userfile3')){ //Untuk data yang teregistrasi di RO update tblberkas
            $this->upload->data();
            if ($hdrid != '' || $hdrid != null) {
                $this->m_datakaryawan->update_db_berkas($hdrid,$berkas,$url.'/'.$namafile.'.pdf');
            }
            echo "<script>alert('Simpan Berkas $namaberkas Berhasil !!');</script>";
        }else{
            $error = $this->upload->display_errors();
            echo "<script>alert('Simpan Berkas $namaberkas Gagal !!');</script>";
            
        }  

        redirect('datakaryawan/listuploadktpkaryawan', 'refresh');
    }

// --------------- KARYAWAN ---------------

    function karyawan(){
        // var_dump($_SESSION); die;
		
        $dataselect         = $this->uri->segment(3);
        $num                = $this->uri->segment(4);
        if($num == FALSE && $dataselect == FALSE){
            redirect('datakaryawan/karyawan/0/1');
        } elseif ($num == FALSE){
            redirect('datakaryawan/karyawan/'.$dataselect.'/1');
        }

        $numStart           = $num-1;
        $start              = 1;
        $end                = 0;
        $startPaging        = (int)$numStart.$start;
        $endPaging          = (int)$num.$end;
        if($dataselect == 0){
            $total                  = $this->m_datakaryawan->countAllKaryawan();
            $data['_selected']      = $dataselect;
            $data['_selectWhere']   = $this->m_datakaryawan->selectAllKaryawan($startPaging,$endPaging);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
        } elseif($dataselect == 1){
            $total                  = $this->m_datakaryawan->countPriaKaryawan();
            $data['_selected']      = $dataselect;
            $data['_selectWhere']   = $this->m_datakaryawan->selectPriaKaryawan($startPaging,$endPaging);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
        } elseif($dataselect == 2){
            $total                  = $this->m_datakaryawan->countWanitaKaryawan();
            $data['_selected']      = $dataselect;
            $data['_selectWhere']   = $this->m_datakaryawan->selectWanitaKaryawan($startPaging,$endPaging);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
        } else {
            $total                  = NULL;
            $data['_selected']      = NULL;
            $data['_selectWhere']   = NULL;
            $data['_pagination']    = NULL;
        }

        $this->template->display('datakaryawan/karyawan/index',$data);
    }

    function karyawantest(){
        $dataFilter = $this->input->post('SelDataFilter');
        redirect('datakaryawan/karyawanWhere/'.$dataFilter.'/1');
    }

    function karyawanWhere(){
        $dataselect                 = $this->uri->segment(3);
        $num                        = $this->uri->segment(4);

        $numStart           = $num-1;
        $start              = 1;
        $end                = 0;
        $startPaging        = (int)$numStart.$start;
        $endPaging          = (int)$num.$end;      
        
        if($dataselect == 0){
            $total                  = $this->m_datakaryawan->countAllKaryawan();
            $data['_selected']      = $dataselect;
            $data['_selectWhere']   = $this->m_datakaryawan->selectAllKaryawan($startPaging,$endPaging);
            $data['_pagination']    = pagination($page = $num, 10, $total);
        } elseif($dataselect == 1){
            $total                  = $this->m_datakaryawan->countPriaKaryawan();
            $data['_selected']      = $dataselect;
            $data['_selectWhere']   = $this->m_datakaryawan->selectPriaKaryawan($startPaging,$endPaging);
            $data['_pagination']    = pagination($page = $num, 10, $total);
        } elseif($dataselect == 2){
            $total                  = $this->m_datakaryawan->countWanitaKaryawan();
            $data['_selected']      = $dataselect;
            $data['_selectWhere']   = $this->m_datakaryawan->selectWanitaKaryawan($startPaging,$endPaging);
            $data['_pagination']    = pagination($page = $num, 10, $total);
        } else {
            $total                  = NULL;
            $data['_selected']      = NULL;
            $data['_selectWhere']   = NULL;
            $data['_pagination']    = NULL;
        }
        $this->template->display('datakaryawan/karyawan/index',$data);  
    }
	

// --------------- HARIAN ---------------
	
    function harian(){
        $dataSelect         = $this->uri->segment(3);
        $num                = $this->uri->segment(4);
        if($num == FALSE && $dataSelect == FALSE){
            redirect('datakaryawan/harian/0/1');
        } elseif ($num == FALSE){
            redirect('datakaryawan/harian/'.$dataSelect.'/1');
        }

        $numStart           = $num-1;
        $start              = 1;
        $end                = 0;
        $startPaging        = (int)$numStart.$start;
        $endPaging          = (int)$num.$end;
        if($dataSelect == 0){
            $total                  = $this->m_datakaryawan->countAllTenaker();
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->m_datakaryawan->selectAllTenaker($startPaging,$endPaging);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
        } elseif($dataSelect == 1){
            $total                  = $this->m_datakaryawan->countPriaTenaker();
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->m_datakaryawan->selectPriaTenaker($startPaging,$endPaging);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
        } elseif($dataSelect == 2){
            $total                  = $this->m_datakaryawan->countWanitaTenaker();
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->m_datakaryawan->selectWanitaTenaker($startPaging,$endPaging);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
        } else {
            $total                  = NULL;
            $data['_selected']      = NULL;
            $data['_selectWhere']   = NULL;
            $data['_pagination']    = NULL;
        }

        $this->template->display('datakaryawan/harian/index',$data);
    }

    function hariantest(){
        $dataFilter = $this->input->post('SelDataFilter');
        redirect('datakaryawan/harianWhere/'.$dataFilter.'/1');
    }

    function harianWhere(){
        $dataSelect                 = $this->uri->segment(3);
        $num                        = $this->uri->segment(4);

        $numStart           = $num-1;
        $start              = 1;
        $end                = 0;
        $startPaging        = (int)$numStart.$start;
        $endPaging          = (int)$num.$end;      
        
        if($dataSelect == 0){
            $total                  = $this->m_datakaryawan->countAllTenaker();
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->m_datakaryawan->selectAllTenaker($startPaging,$endPaging);
            $data['_pagination']    = pagination($page = $num, 10, $total);
        } elseif($dataSelect == 1){
            $total                  = $this->m_datakaryawan->countPriaTenaker();
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->m_datakaryawan->selectPriaTenaker($startPaging,$endPaging);
            $data['_pagination']    = pagination($page = $num, 10, $total);
        } elseif($dataSelect == 2){
            $total                  = $this->m_datakaryawan->countWanitaTenaker();
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->m_datakaryawan->selectWanitaTenaker($startPaging,$endPaging);
            $data['_pagination']    = pagination($page = $num, 10, $total);
        } else {
            $total                  = NULL;
            $data['_selected']      = NULL;
            $data['_selectWhere']   = NULL;
            $data['_pagination']    = NULL;
        }
        $this->template->display('datakaryawan/harian/index',$data);  
    }

	
	function detailtk(){
        if('IS_AJAX') {
            $kode=$this->input->post('kode');
            $data['datatk'] = $this->m_datakaryawan->get_detailtk($kode)->result();
            foreach ($this->m_datakaryawan->get_detailtk($kode)->result() as $row):
                $tglLahir   = $row->TglLahir;
            endforeach;
            $data['_umur']  = $this->hitungUmur(date('Y-m-d', strtotime($tglLahir)));
            // $data['resultScreen'] = $this->m_datakaryawan->resultScreen($kode)->result();
            $this->load->view('datakaryawan/harian/detail',$data);
        }
    }
	
	function detailk(){
        if('IS_AJAX') {
            $kode=$this->input->post('kode');
            $data['datak'] = $this->m_datakaryawan->get_detailk($kode)->result();
            foreach ($this->m_datakaryawan->get_detailk($kode)->result() as $row):
                $tglLahir   = $row->TGLLAHIR;
            endforeach;
            $data['_umur']  = $this->hitungUmur(date('Y-m-d', strtotime($tglLahir)));
            // $data['resultScreen'] = $this->m_datakaryawan->resultScreen($kode)->result();
            $this->load->view('datakaryawan/karyawan/detail',$data);
        }
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
	
    function pagination($page = 1, $per_page = 10, $row = 0){
        $total = $row;
        $adjacents = "2"; 

        $page = ($page == 0 ? 1 : $page);  
        $start = ($page - 1) * $per_page;                               
        
        $prev = $page - 1;                          
        $next = $page + 1;
        $lastpage = ceil($total/$per_page);
        $lpm1 = $lastpage - 1;
        
        $pagination = "";
        if ($lastpage > 1) {
            $pagination .= "<ul class='pagination'>";
            $pagination .= "<li><a>Page $page of $lastpage</a></li>";
            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page){
                        $pagination.= "<li class='active'><a>$counter</a></li>";
                    }else{
                        $pagination.= "<li><a href='$counter'>$counter</a></li>";
                    }
                }
            }
            elseif ($lastpage > 5 + ($adjacents * 2)) {
                if ($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page){
                            $pagination.= "<li class='active'><a class='active'>$counter</a></li>";
                        }else{
                            $pagination.= "<li><a href='$counter'>$counter</a></li>";
                        }
                    }
                    $pagination.= "<li class='dot'><a>...</a></li>";
                    $pagination.= "<li><a href='$lpm1'>$lpm1</a></li>";
                    $pagination.= "<li><a href='$lastpage'>$lastpage</a></li>";
                }
                elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination.= "<li><a href='1'>1</a></li>";
                    $pagination.= "<li><a href='2'>2</a></li>";
                    $pagination.= "<li class='dot'><a>...</a></li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<li class='active'><a class='active'>$counter</a></li>";
                        else
                            $pagination.= "<li><a href='$counter'>$counter</a></li>";
                    }
                    $pagination.= "<li class='dot'><a>...</a></li>";
                    $pagination.= "<li><a href='$lpm1'>$lpm1</a></li>";
                    $pagination.= "<li><a href='$lastpage'>$lastpage</a></li>";
                }
                else {
                    $pagination.= "<li><a href='1'>1</a></li>";
                    $pagination.= "<li><a href='2'>2</a></li>";
                    $pagination.= "<li class='dot'><a>...</a></li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<li class='active'><a class='active'>$counter</a></li>";
                        else
                            $pagination.= "<li><a href='$counter'>$counter</a></li>";
                    }
                }
            }

            if ($page < $counter - 1) {
                $pagination.= "<li><a href='$next'>Next</a></li>";
                $pagination.= "<li><a href='$lastpage'>Last</a></li>";
            } else {
                $pagination.= "<li><a class='current'>Next</a></li>";
                $pagination.= "<li><a class='current'>Last</a></li>";
            }
            $pagination.= "</ul>\n";
        }
        return $pagination;
    }

    function pagination2($page = 1, $per_page = 500, $row = 0){
        $total = $row;
        $adjacents = "2"; 

        $page = ($page == 0 ? 1 : $page);  
        $start = ($page - 1) * $per_page;                               
        
        $prev = $page - 1;                          
        $next = $page + 1;
        $lastpage = ceil($total/$per_page);
        $lpm1 = $lastpage - 1;
        
        $pagination = "";
        if ($lastpage > 1) {
            $pagination .= "<ul class='pagination'>";
            $pagination .= "<li><a>Page $page of $lastpage</a></li>";
            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page){
                        $pagination.= "<li class='active'><a>$counter</a></li>";
                    }else{
                        $pagination.= "<li><a href='$counter'>$counter</a></li>";
                    }
                }
            }
            elseif ($lastpage > 5 + ($adjacents * 2)) {
                if ($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page){
                            $pagination.= "<li class='active'><a class='active'>$counter</a></li>";
                        }else{
                            $pagination.= "<li><a href='$counter'>$counter</a></li>";
                        }
                    }
                    $pagination.= "<li class='dot'><a>...</a></li>";
                    $pagination.= "<li><a href='$lpm1'>$lpm1</a></li>";
                    $pagination.= "<li><a href='$lastpage'>$lastpage</a></li>";
                }
                elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination.= "<li><a href='1'>1</a></li>";
                    $pagination.= "<li><a href='2'>2</a></li>";
                    $pagination.= "<li class='dot'><a>...</a></li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<li class='active'><a class='active'>$counter</a></li>";
                        else
                            $pagination.= "<li><a href='$counter'>$counter</a></li>";
                    }
                    $pagination.= "<li class='dot'><a>...</a></li>";
                    $pagination.= "<li><a href='$lpm1'>$lpm1</a></li>";
                    $pagination.= "<li><a href='$lastpage'>$lastpage</a></li>";
                }
                else {
                    $pagination.= "<li><a href='1'>1</a></li>";
                    $pagination.= "<li><a href='2'>2</a></li>";
                    $pagination.= "<li class='dot'><a>...</a></li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<li class='active'><a class='active'>$counter</a></li>";
                        else
                            $pagination.= "<li><a href='$counter'>$counter</a></li>";
                    }
                }
            }

            if ($page < $counter - 1) {
                $pagination.= "<li><a href='$next'>Next</a></li>";
                $pagination.= "<li><a href='$lastpage'>Last</a></li>";
            } else {
                $pagination.= "<li><a class='current'>Next</a></li>";
                $pagination.= "<li><a class='current'>Last</a></li>";
            }
            $pagination.= "</ul>\n";
        }
        return $pagination;
    }
	
	function viewTenaker(){
        ob_start();
        $nik  = $this->uri->segment(3);
        $data['_getDetailTK'] = $this->m_datakaryawan->getResultTK($nik);
		foreach ($this->m_datakaryawan->getResultTK($nik) as $row):
            $tglLahir   = $row->TglLahir;
        endforeach;
        $data['_umur']  = $this->hitungUmur(date('Y-m-d', strtotime($tglLahir)));
        
        $this->load->view("datakaryawan/harian/print/cardTK",$data);
        $html   = ob_get_contents();
        ob_end_clean();
        
        require_once ('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P','A4','en');
        $pdf->writeHTML($html, isset($_GET['vuehtml']));
        $pdf->Output('TK Card - '.$nik.'.pdf');
    }
	
	function viewKaryawan(){
        ob_start();
        $nik  = $this->uri->segment(3);
        $data['_getDetail'] = $this->m_datakaryawan->getResultK($nik);
        foreach ($this->m_datakaryawan->getResultK($nik) as $row):
            $tglLahir   = $row->TGLLAHIR;
        endforeach;
        $data['_umur']  = $this->hitungUmur(date('Y-m-d', strtotime($tglLahir)));
        
        $this->load->view("datakaryawan/karyawan/print/cardK",$data);
        $html   = ob_get_contents();
        ob_end_clean();
        
        require_once ('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P','A4','en');
        $pdf->writeHTML($html, isset($_GET['vuehtml']));
        $pdf->Output('K Card - '.$nik.'.pdf');
    }

}