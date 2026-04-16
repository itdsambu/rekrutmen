<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bontkkeluar extends CI_Controller{
     function __construct() {
        parent::__construct();
        $this->load->model('darurat');
//        $status = 1;
        $status = $this->darurat->getStatus();
        if($status === 1 && $this->session->userdata('userid') !=='ismo_adm'){
            redirect(site_url('maintenanceControl'));
        }
        
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('userid')){
            redirect('login');
        }
        $this->load->model('m_bontkkeluar');
    }
    
    function index(){
        $data['getDataPbr']     = $this->m_bontkkeluar->get_DataPbr();
        // $data['getDataTK']  = $this->m_bontkkeluar->get_DataTK();

        $this->template->display('transaksi/bontkkeluar/index',$data);
    }

    function AjaxDataBon(){
        $id         = $this->uri->segment(3);
        $thn        = $this->uri->segment(4);
        $bln        = $this->uri->segment(5);
      
        $data['idPemborong']  = $id;
        $data['getTahun']     = $thn;
        $data['getBulan']     = $bln;

        // echo $id.'-';
        // echo $thn.'-';
        // echo $bln;
        $data['getData']    = $this->m_bontkkeluar->get_DataTK($id,$thn,$bln);
        $this->load->view('transaksi/bontkkeluar/AjaxData',$data);
    }

    function simpanData(){
        $tanggal    = $this->input->post('txttanggal');
        $nofix      = $this->input->post('txtnofix');
        $bontk      = $this->input->post('txtbontk');

        

        $jmlh   = count($nofix);
        for($i=0; $i < $jmlh;$i++){
            $data = array(
                'PeriodeGajian' => $tanggal[$i],
                'FixNo'         => $nofix[$i],
                'Potongan'      => $bontk[$i],
                'CreatedBy'     => $this->session->userdata('username'),
                'CreatedDate'   => date('Y-m-d H:m:i')
            );
            echo $tanggal[$i].'-';
            echo $nofix[$i].'-';
            echo $bontk[$i];
            $this->m_bontkkeluar->simpan($data);
        }
    }
}