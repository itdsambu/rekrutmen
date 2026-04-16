<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class Autocomplete extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('M_Autocomplete'); 
    }
    
    function getPemborong(){
        $keyword=$this->input->post('keyword');
        $data=$this->M_Autocomplete->getPemborongFromDB($keyword);        
        echo json_encode($data);
    }
    
    function getPendidikan(){
        $keyword=$this->input->post('keyword');
        $data=$this->M_Autocomplete->getPendidikanFromDB($keyword);        
        echo json_encode($data);
    }
    
    function getJurusan(){
        $keyword=$this->input->post('keyword');
        $data=$this->M_Autocomplete->getJurusanFromDB($keyword);        
        echo json_encode($data);
    }

    function getTahunlahir(){
        $keyword=$this->input->post('keyword');
        $data=$this->M_Autocomplete->getTahunFromDB($keyword);        
        echo json_encode($data);
    }
}