<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Return_printberkas extends CI_Controller{
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
        
        $this->load->model('m_return_printberkas');
    }

    function mcuForm(){
        $data['_getFormID']      = $this->input->get('id');
        $data['getData'] = $this->m_return_printberkas->getDataMcuForm();
        $this->template->display('returndata/print_berkas/mcuForm/index',$data);
    }

    function ajaxBerkasMcuForm(){
        $bulan    = $this->uri->segment(3);
        $tahun    = $this->uri->segment(4);

        // echo $bulan.'-'.$tahun;
        $data['getData'] = $this->m_return_printberkas->getDataAjaxMcuForm($bulan,$tahun);
        $this->load->view('returndata/print_berkas/mcuForm/dataMcuForm',$data);
    }

    function simpanData(){
        $id = $this->input->post('txthdrid');

        $hitung = count($id);
        for ($i=0; $i < $hitung; $i++) { 
            $data = array(
                'PrintMCUForm'      => 0,
                'PrintMCUFormBY'    => NULL,
                'PrintMCUFormDate'  => NULL,
            );
            
            $this->m_return_printberkas->update($id[$i],$data);
            redirect('Return_printberkas/mcuForm');
        }
    }

    // MCU CARD 

    function mcuCard(){
        $data['_getFormID']      = $this->input->get('id');
        $data['getData'] = $this->m_return_printberkas->getDataMcuCard();
        $this->template->display('returndata/print_berkas/mcuCard/index',$data);
    }

    function ajaxBerkasMcuCard(){
        $bulan    = $this->uri->segment(3);
        $tahun    = $this->uri->segment(4);

        // echo $bulan.'-'.$tahun;
        $data['getData'] = $this->m_return_printberkas->getDataAjaxMcuCard($bulan,$tahun);
        $this->load->view('returndata/print_berkas/mcuCard/dataMcuCard',$data); 
    }

    function simpanDataMCUCard(){
      $id = $this->input->post('txthdrid');

        $hitung = count($id);
        for ($i=0; $i < $hitung; $i++) { 
            $data = array(
                'PrintMCUCard'      => 0,
                'PrintMCUCardBY'    => NULL,
                'PrintMCUCardDate'  => NULL,
            );
           
            $this->m_return_printberkas->update($id[$i],$data);
            redirect('Return_printberkas/mcuCard');
        }  
    }

    // SPMK

    function spmk(){

        $data['_getFormID']      = $this->input->get('id');
        $data['getData'] = $this->m_return_printberkas->getDataSPMK();
        $this->template->display('returndata/print_berkas/spmk/index',$data);
    }

    function ajaxBerkasspmk(){
        $bulan    = $this->uri->segment(3);
        $tahun    = $this->uri->segment(4);

        // echo $bulan.'-'.$tahun;
        $data['getData'] = $this->m_return_printberkas->getDataAjaxSPMK($bulan,$tahun);
        $this->load->view('returndata/print_berkas/spmk/dataSpmk',$data); 
    }

    function simpanDataSpmk(){
      $id = $this->input->post('txthdrid');

        $hitung = count($id);
        for ($i=0; $i < $hitung; $i++) { 
            $data = array(
                'PrintSPMK'      => 0,
                'PrintSPMKBy'    => NULL,
                'PrintSPMKDate'  => NULL,
            );
           
            $this->m_return_printberkas->update($id[$i],$data);
            redirect('Return_printberkas/spmk');
        }  
    }

    // KPB Card

    function kpbCard(){
        $data['_getFormID']      = $this->input->get('id');
        $data['getData'] = $this->m_return_printberkas->getDataKpbCard();
        $this->template->display('returndata/print_berkas/kpbCard/index',$data);
    }

    function ajaxBerkasKpbCard(){
        $bulan    = $this->uri->segment(3);
        $tahun    = $this->uri->segment(4);

        // echo $bulan.'-'.$tahun;
        $data['getData'] = $this->m_return_printberkas->getDataAjaxKpbCard($bulan,$tahun);
        $this->load->view('returndata/print_berkas/kpbCard/dataKpbCard',$data); 
    }

    function simpanDataKpbCard(){
      $id = $this->input->post('txthdrid');

        $hitung = count($id);
        for ($i=0; $i < $hitung; $i++) { 
            $data = array(
                'PrintKPBCard'      => 0,
                'PrintKPBCardBy'    => NULL,
                'PrintKPBCardDate'  => NULL,
            );
           
            $this->m_return_printberkas->update($id[$i],$data);
            redirect('Return_printberkas/kpbCard');
        }  
    }
}