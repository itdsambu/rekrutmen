<?php 
defined('BASEPATH') or exit('No Direct Script access Allowed');

class Monitoringtenagakerja extends CI_Controller{
        function __construct() {
                parent::__construct();
                $this->load->model('m_monitoringtenagakerja');
                }

    function index(){
            $data['get_pemborong']         = $this->m_monitoringtenagakerja->getPemborong();
            $data['get_typependidikan']    = $this->m_monitoringtenagakerja->getTypependidikan();
            $data['get_jurusan']           = $this->m_monitoringtenagakerja->getMasterJurusan();
            
        $this->template->display('monitor/calon_tk/Monitoringtenagakerja1',$data);
        
    }

        function AjaxView(){
                
                $tahun                  = $this->uri->segment(4);
                $bulan                  = $this->uri->segment(3);
                $filter                 = $this->input->post('filter');
                $pemborong              = $this->input->post('pemborong');
                $jeniskelamin           = $this->input->post('jeniskelamin');
                $pendidikan             = $this->input->post('pendidikan');
                $jurusan                = $this->input->post('jurusan');
                // $txtid                  = $this->input->post('txtid');

                $data['tahun']          = $tahun;
                $data['bulan']          = $bulan;
                $data['filter']         = $filter;
                $data['pemborong']      = $pemborong;
                $data['jeniskelamin']   = $jeniskelamin;
                $data['pendidikan']     = $pendidikan;
                $data['jurusan']        = $jurusan;
                // $data['txtid']          = $txtid;
                
                // echo $bulan .'-';
                // echo $tahun.'-';
                // echo $filter.'-';
                // echo $pemborong .'-'; 
                // echo $jeniskelamin.'-';
                // echo $pendidikan.'-';
                // echo $jurusan.'-';
                // echo $txtid;
                if($filter == 1){
                        $data['DataAll'] = $this->m_monitoringtenagakerja->getDataPosting($bulan,$tahun,$pemborong,$jeniskelamin,$pendidikan,$jurusan);   
                }elseif($filter == 2){
                        $data['DataAll'] = $this->m_monitoringtenagakerja->getDataGagalScreening($bulan,$tahun,$pemborong,$jeniskelamin,$pendidikan,$jurusan);
                }elseif($filter == 3){
                        $data['DataAll'] = $this->m_monitoringtenagakerja->getDataBelumWawancara($bulan,$tahun,$pemborong,$jeniskelamin,$pendidikan,$jurusan);
                }elseif($filter == 4){
                        $data['DataAll'] = $this->m_monitoringtenagakerja->getDataTelahWawancara($bulan,$tahun,$pemborong,$jeniskelamin,$pendidikan,$jurusan);
                }elseif($tahun == 1){
                        $data['DataAll'] = $this->m_monitoringtenagakerja->getSemuaTahun();
                }else{
                        $data['DataAll'] = $this->m_monitoringtenagakerja->get_viewall($bulan,$tahun,$pemborong,$jeniskelamin,$pendidikan,$jurusan);
                }
                $this->load->view('monitor/calon_tk/AjaxDataViewAll',$data);
        }

        function tkPemborong(){
            $Tahun        = $this->input->post('selTahun');
            $Bulan        = $this->input->post('selBulan');
            $blnthn       = $Bulan."-".$Tahun;

            $data['_getData']   = $this->m_monitoringtenagakerja->countPemborongTgl($Tahun,$Bulan);
            // $data['_getCount']  = $this->m_monitor->countPemborong();
            
        $this->template->display('monitor/calon_tk/tkPemborong',$data);
    }
}
?>