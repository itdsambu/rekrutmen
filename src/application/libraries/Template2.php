<?php

class Template2{
    protected $_CI;
    function __construct(){
        $this->_CI=&get_instance();
    }
    
    function display($template,$data=null){
        $this->_CI->load->model('m_menuSidebar');
        $this->_CI->load->model('m_user_profil');
        $loginID    = $this->_CI->session->userdata('userid');
        $data['_getProfil'] = $this->_CI->m_user_profil->getProfile($loginID);
        $data['_getMenu1'] = $this->_CI->m_menuSidebar->selectMenu1($this->_CI->session->userdata('groupuser'));
        $data['_getMenu2'] = $this->_CI->m_menuSidebar->selectMenu2($this->_CI->session->userdata('groupuser'));
        $data['_getMenu3'] = $this->_CI->m_menuSidebar->selectMenu3($this->_CI->session->userdata('groupuser'));        

        $data['_content']=$this->_CI->load->view($template,$data,true);
	      $data['_navbar']=$this->_CI->load->view('template/navbar',$data,true);
          $data['_sidebar']=$this->_CI->load->view('template/sidebar',$data,true);
	      $data['_footer']=$this->_CI->load->view('template/footer',$data,true);
        $this->_CI->load->view('/template2.php',$data);
    }
    
}