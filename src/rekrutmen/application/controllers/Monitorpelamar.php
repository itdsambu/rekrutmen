<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monitorpelamar extends CI_Controller{
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
        
        $this->load->model('M_monitorpelamar');
    }

    function index(){

        $this->template->display('transaksi/monitorpelamar/index');
    }

    function ajaxPelamar(){
        $statusid = $this->input->post('statusid');

        $data['getData']    = $this->M_monitorpelamar->getDataPelamar($statusid);
        $this->load->view('transaksi/monitorpelamar/ajaxpelamar',$data);
    }

    function AjaxTampilDetail(){
        $headerid   = $this->input->get('id');

        $data['datatk'] = $this->M_monitorpelamar->get_DetailTK($headerid);
        $this->load->view('transaksi/monitorpelamar/Detail',$data);
    }
}