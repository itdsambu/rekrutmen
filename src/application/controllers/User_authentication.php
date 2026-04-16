<?php

/* 
 * Author by ISmo
 */

ob_start();
session_start();

class User_Authentication extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }
    
    public function index(){
        $this->load->view('login');
    }
    
    public function user_login_process(){
        $session_set_value  = $this->session->all_userdata();
        
        if(isset($session_set_value['remember_me']) && $session_set_value['remember_me'] == 1){
            redirect('welcome');
        }else{
            $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            
            if($this->form_validation->run() == FALSE){
                redirect('user_authentication');
            }else{
                $user   = $this->input->post('username');
                $pass   = $this->input->post('password');
                
                if ($user == "ismo" && $pass == "123"){
                    $remember   = $this->input->post('remember_me');
                    if($remember){
                        $this->session->set_userdata('remember_me',TRUE);
                    }
                    $sess_data = array(
                        'username'  => $user,
                        'password'  => $pass
                    );
                    $this->session->set_userdata('logged_in',$sess_data);
                    redirect('welcome');
                }else{
                    $data['error_msg'] = "Invalid Username or Password";
                    redirect('user_authentication',$data);
                }
            }
        }
    }
}