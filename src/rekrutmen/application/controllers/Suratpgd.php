<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suratpgd extends CI_Controller{
	
    public function __construct(){
        parent::__construct();
        $this->load->model(array('darurat','M_suratpgd'));
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

    function inputpgd(){
    	$this->template->display('formpgd/index');
    }

    function getmynikBorongan(){
        $nik = $this->input->post('nik');
        $tipe = $this->input->post('tipe');
        if (is_numeric($nik)==false) {
            $data = array('Err'=>1,'Msg'=>'NIK harus dalam format angka 0..9 !! ' . $nik);
        }else{
            $nikval = $this->db->escape($nik);
            $tipeval = $this->db->escape($tipe);
            $query = $this->M_suratpgd->getinfoNik($nik,$tipe);
            if($query->num_rows()>0){
                $row = $query->row();
                if($row->Nama!=''){
                    $data = array('Err'=>0,'tipe'=>$tipeval,'Msg'=>$query->result_array());
                }else{
                    $data = array('Err'=>1,'Msg'=>'NIK tidak ditemukan');
                }
            }
            else
                $data = array('Err'=>1,'Msg'=>'NIK tidak ditemukan !');   
        }
        echo json_encode($data);
    }

    function listsuratpgd(){
        $data['getdatapgd'] = $this->M_suratpgd->getmonpermohonanpgd();
        $this->template->display('formpgd/monitorpgd',$data);
    }

    function ajaxtenagakerja($nik){               
        $data['_getData']   = $this->M_suratpgd->getDatatenagakerja($nik);
        $data['_cekData']   = $this->M_suratpgd->getDatatenagakerja($nik);
        $this->load->view('formpgd/ajaxtenagakerja', $data);   
    }

    function savesuratPGD(){
        $nik = $this->input->post('txtNIK');
        $tglkeluar = date('Y-m-d',strtotime($this->input->post('txtTANGGALKELUAR')));
        $keterangan = $this->input->post('txtKETERANGAN');
        $user = $this->session->userdata('username');

        $data = $this->M_suratpgd->save($nik,$tglkeluar,$keterangan,$user);
        if(!$data){
            $this->session->set_flashdata('_message', 'Gagal disimpan.');
            redirect(base_url('suratpgd/inputpgd?err=header'));
        }else{
            redirect(base_url('suratpgd/ttd?id='.$nik));
        }
    }

    function detail(){
        if('IS_AJAX'){
            $this->load->model('M_suratpgd');
            $kode = $this->input->post('kode');
            $data['data'] = $this->M_suratpgd->get_tenakerPGD($kode)->result();
            $this->load->view('formpgd/detail',$data);
        }
    }

    function ttd()
    {
        $id = $this->input->get('id');
        $this->session->set_flashdata("id",$id);

        redirect('Suratpgd/ttdpemohon');
    }

    function ttdpemohon()
    {
        $id = $this->session->flashdata("id");
        $this->session->keep_flashdata("id");
        $data['_rifid'] = $id;
        $data['id'] = $id;
        $data['_ref']= $id;
        $data['_status'] = 0; //no need but must exists
        $data['_getkode'] = 0; // no need but must exists
        $data['_getdata'] = $this->M_suratpgd->getdatattd($id);
        $this->template->display('formpgd/app/pemohon',$data);
    }

    function ttddept()
    {

        $id = $this->session->userdata('nik');

        $data['_ref']= $id;

        $kode_data = array('regno'=>'',
                           'nik'=>'',
                           'nama'=>'',
                           'jabatan'=>'');
        $query = $this->M_suratpgd->GetdataDept($this->session->userdata('nik'));
        $rrow = $query->result();
        if($query->num_rows()>0){
            $r = $query->row();
            $kode_data['regno']=$r->RegNo;
            $kode_data['nik'] = $r->NIK;
            $kode_data['nama'] = $r->NAMA;
            $kode_data['jabatan']=$r->Jabatan;    
        };
        $data['_getdata'] = $kode_data;

        $data['getdatapgd'] = $this->M_suratpgd->getdatapermohonanpgd();
        $this->template->display('formpgd/app/dept',$data);
    }

    function ttsuratpgd(){
         $this->load->view('formpgd/ttdsurat');
    }

    function simpan_foto() {
        $id = $this->input->post('refid');

        $upload_dir = "dataupload/ttdpgd/";
        $file = $upload_dir . $this->input->post('refid') . ".png";

        $img = $this->input->post('hidden_data');
        $imges = str_replace('data:image/png;base64,', '', $img);
        $imge = str_replace(' ', '+', $imges);
        $image = imagecreatefromstring(base64_decode($imge));
        if ($image != false) {
            imagejpeg($image, $file); 
        }

        $ttd = $this->input->post('hidden_data');
        $user = $this->session->userdata('username');
        $jab = $this->session->userdata('groupuser');

        $result = $this->M_suratpgd->updatedata($id,$user,$jab,$ttd);
        if(!$result){
            redirect('Suratpgd/ttddept/'.$id);
        }else{
            redirect('Suratpgd/ttddept/'.$id);
        }
    }

    function approvekonfirmasikontrakDeptMulti(){
        $nik = $this->input->post('txtnik');
        $chknik = $this->input->post('chkNIK');
        if ($nik == '') {
            redirect('suratpgd/ttddept?msg=failed_approve');
        }else{
            $cekapp = $this->db->query("SELECT * FROM vwAksesApprovePGD WHERE NIK='".$nik."'")->result();
            if ($cekapp == true) {
                for ($i=0; $i < count($chknik); $i++) { 
                    $data = array(
                        'DEPTApproval' => $this->input->post('txtnama'), 
                        'DEPTJabatan'  => $this->input->post('txtjabatan'), 
                        'DEPTDate'     => date('Y-m-d H:i:s'), 
                        'DEPTStatus'   => 1
                    );
                    $param = $this->M_suratpgd->approveddata($chknik[$i],$data);
                    if (!$param) {
                        redirect('suratpgd/ttddept?msg=failed');
                    }else{
                        redirect('suratpgd/ttddept?msg=success');
                    }
                }
            }else{
                redirect('suratpgd/ttddept?msg=failed_approve');
            }
        }
    }

    function rejectkonfirmasikontrakDeptMulti(){
        $nik = $this->input->post('txtnik');
        $chknik = $this->input->post('chkNIK');
        if ($nik == '') {
            redirect('suratpgd/ttddept?msg=failed_approve');
        }else{
            $cekapp = $this->db->query("SELECT * FROM vwAksesApprovePGD WHERE NIK='".$nik."'")->result();
            if ($cekapp == true) {
                for ($i=0; $i < count($chknik); $i++) { 
                    $data = array(
                        'DEPTApproval' => $this->input->post('txtnama'), 
                        'DEPTJabatan'  => $this->input->post('txtjabatan'), 
                        'DEPTDate'     => date('Y-m-d H:i:s'), 
                        'DEPTStatus'   => 0
                    );
                    $param = $this->M_suratpgd->approveddata($chknik[$i],$data);
                    if (!$param) {
                        redirect('suratpgd/ttddept?msg=failed');
                    }else{
                        redirect('suratpgd/ttddept?msg=success');
                    }
                }
            }else{
                redirect('suratpgd/ttddept?msg=failed_approve');
            }
        }
    }

    function ttdppk()
    {
        $idpemborong = $this->session->userdata('idpemborong');
        if($idpemborong == 0){
            $data['getdata'] = $this->M_suratpgd->approvedatapbr();
        }else{
            $data['getdata'] = $this->M_suratpgd->approvedatapbr($idpemborong);
        }
        $this->template->display('formpgd/app/ppk',$data);
    }

    function approvekonfirmasikontrakPPKMulti(){
        $chknik = $this->input->post('chkNIK');
        for ($i=0; $i < count($chknik); $i++) { 
            $data = array(
                'PemborongApproval' => strtoupper($this->session->userdata('username')), 
                'PemborongJabatan'  => 'Ka. Pmbrg', 
                'PemborongDate'     => date('Y-m-d H:i:s'), 
                'PemborongStatus'   => 1
            );
            $param = $this->M_suratpgd->approveddata($chknik[$i],$data);
            if (!$param) {
                redirect('suratpgd/ttdppk?msg=failed');
            }else{
                redirect('suratpgd/ttdppk?msg=success');
            }
        }
    }

    function rejectkonfirmasikontrakPPKMulti(){
        $chknik = $this->input->post('chkNIK');
        for ($i=0; $i < count($chknik); $i++) { 
            $data = array(
                'PemborongApproval' => strtoupper($this->session->userdata('username')), 
                'PemborongJabatan'  => 'Ka. Pmbrg', 
                'PemborongDate'     => date('Y-m-d H:i:s'), 
                'PemborongStatus'   => null
            );
            $param = $this->M_suratpgd->approveddata($chknik[$i],$data);
            if (!$param) {
                redirect('suratpgd/ttdppk?msg=failed');
            }else{
                redirect('suratpgd/ttdppk?msg=success');
            }
        }
    }

    function ttdpsn()
    {
        $id = $this->session->userdata('nik');

        $data['_ref']= $id;

        $kode_data = array('regno'=>'',
                           'nik'=>'',
                           'nama'=>'',
                           'jabatan'=>'');
        $query = $this->M_suratpgd->GetdataDept($this->session->userdata('nik'));
        $rrow = $query->result();
        if($query->num_rows()>0){
            $r = $query->row();
            $kode_data['regno']=$r->RegNo;
            $kode_data['nik'] = $r->NIK;
            $kode_data['nama'] = $r->NAMA;
            $kode_data['jabatan']=$r->Jabatan;    
        };
        $data['_getdata'] = $kode_data;
        $data['getdata'] = $this->M_suratpgd->approvedatapsn();
        $this->template->display('formpgd/app/psn',$data);
    }

    function approvekonfirmasikontrakPSNMulti(){
        $chknik = $this->input->post('chkNIK');
        for ($i=0; $i < count($chknik); $i++) {
            $data = array(
                'PSNApproval' => $this->input->post('txtnama'), 
                'PSNJabatan'  => $this->input->post('txtjabatan'), 
                'PSNDate'     => date('Y-m-d H:i:s'), 
                'PSNStatus'   => 1
            );
            $param = $this->M_suratpgd->approvedatapsn($chknik[$i], $data);
            if (!$param) {
                redirect('suratpgd/ttdpsn?msg=failed');
            }else{
                redirect('suratpgd/ttdpsn?msg=success');
            }
            
        }

    }

    function rejectkonfirmasikontrakPSNMulti(){
        $chknik = $this->input->post('chkNIK');
        for ($i=0; $i < count($chknik); $i++) {
            $data = array(
                'PSNApproval' => $this->input->post('txtnama'), 
                'PSNJabatan'  => $this->input->post('txtjabatan'), 
                'PSNDate'     => date('Y-m-d H:i:s'), 
                'PSNStatus'   => 0
            );
            $param = $this->M_suratpgd->approvedatapsn($chknik[$i], $data);
            if (!$param) {
                redirect('suratpgd/ttdpsn?msg=failed');
            }else{
                redirect('suratpgd/ttdpsn?msg=success');
            }
            
        }
    }

}