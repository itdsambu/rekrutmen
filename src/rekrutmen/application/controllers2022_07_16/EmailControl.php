<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class EmailControl extends CI_Controller{
    public function __construct() {
        parent::__construct();
        
        $this->load->library('email');
    }
    
    function send(){
        $this->email->from('ismo_ci@example.com', 'Your Name');
        $this->email->to('ismo.lhavic@gmail.com'); 

        $this->email->subject('Email Test From CI Class Email');
        $this->email->message('Testing the email class.');

        $this->email->send();

        echo $this->email->print_debugger();
    }
}