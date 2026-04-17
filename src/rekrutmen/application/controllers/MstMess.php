<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MstMess extends CI_Controller{
    
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
        
        $this->load->model('M_MstMess');
    }

    function index(){

        $data['_getData'] = $this->M_MstMess->get_dataMsterMess();
        $this->template->display('master/mess/index',$data);
    }

    function tambah(){

        $this->template->display('master/mess/tambah');
    }

    function simpan(){
        $alamat     = $this->input->post('txtAlamat');
        $jml_kamar  = $this->input->post('txtJumlahKamar');
        $kapasitas  = $this->input->post('txtKapasitasKamar');
        $jenis_mess = $this->input->post('selJenisMess');
        $status     = $this->input->post('txtStatus');

        $data = array(
          'Alamat_Mess'     => $alamat,
          'Jumlah_Kamar'    => $jml_kamar,
          'Kapasitas_Kamar' => $kapasitas,
          'Jenis_Mess'      => $jenis_mess,
          'Status'          => $status,
          'CreatedBy'       => $this->session->userdata('username'),
          'CreatedDate'     => date('Y-m-d H:i:s')
        );

        $result = $this->M_MstMess->simpan($data);
        if(!$result){
            redirect('MstMess?msg=success');
        }else{
            redirect('MstMess?msg=failed');
        }
    }

    function edit(){
        $id = $this->uri->segment(3);

        $data['_getData'] =  $this->M_MstMess->get_dataMsterMessByid($id);
        $this->template->display('master/mess/edit',$data);
    }

    function update(){
        $messid     = $this->input->post('txtmessid');
        $alamat     = $this->input->post('txtAlamat');
        $jml_kamar  = $this->input->post('txtJumlahKamar');
        $kapasitas  = $this->input->post('txtKapasitasKamar');
        $jenis_mess = $this->input->post('selJenisMess');
        $status     = $this->input->post('txtStatus');

        $data = array(
          'Alamat_Mess'     => $alamat,
          'Jumlah_Kamar'    => $jml_kamar,
          'Kapasitas_Kamar' => $kapasitas,
          'Jenis_Mess'      => $jenis_mess,
          'Status'          => $status,
          'UpdateBy'        => $this->session->userdata('username'),
          'UpdateDate'      => date('Y-m-d H:i:s')
        );

        // echo $messid;
        // print_r($data);
        $result = $this->M_MstMess->update($id,$data);
        if(!$result){
            redirect('MstMess?msg=success');
        }else{
            redirect('MstMess?msg=failed');
        }
    }
}