<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class MaintenanceControl extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->library(array('user_agent'));
        date_default_timezone_set("Asia/Jakarta");
    }
    
    public function index(){
        $browser    = $this->agent->browser();
        if($browser == 'Internet Explorer'){
            redirect(site_url('maintenanceControl/notSupport'));
        }else{
            $this->load->view('page_maintenance');
        }
    }
    
    public function notSupport(){
        $this->load->view('browserNotSupport');
    }
    
}