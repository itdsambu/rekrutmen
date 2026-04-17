<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class Errors extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->library(array('user_agent'));
        date_default_timezone_set("Asia/Jakarta");
    }
    
    public function index(){
        $browser    = $this->agent->browser();
        if($browser == 'Internet Explorer'){
            redirect(site_url('errors/notSupport'));
        }else{
            redirect(site_url('errors/error_404'));
        }
    }
    
    function error_404(){
        $this->load->view('errors/error_404');
    }
    function error_db(){
        redirect(site_url('errors/error_404'));
        //$this->load->view('errors/error_db');
    }

    public function notSupport(){
        $this->load->view('browserNotSupport');
    }
    
}