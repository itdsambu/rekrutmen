<?php 
defined('BASEPATH') or exit('No Direct Script access Allowed');

class Monitoringtenagakerjanew extends CI_Controller{
    function __construct(){
        parent:: __construct();
        $this->load->model('m_monitoringtenagakerjanew');
    }

    function index(){
        $data['get_pemborong']         = $this->m_monitoringtenagakerjanew->getPemborong();
        $data['get_typependidikan']    = $this->m_monitoringtenagakerjanew->getTypependidikan();
        $data['get_jurusan']           = $this->m_monitoringtenagakerjanew->getMasterJurusan();

        $this->template->display('monitor/calon_tk/monitoringtenagakerjanew');
    }

}
?>