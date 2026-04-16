<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class MenuAkses extends CI_Controller{
    
    public function __construct() {
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
        $this->load->model(array('m_grup_user','m_menuAkses'));
    }
    
    public function index(){
        $data['_getGrupUser'] = $this->m_grup_user->selectGrupUser();
        
        $this->template->display('utility/menu_akses/index',$data);
    }
    
    function simpan(){
        $groupid    = $this->input->post('txtGroupID');
        $chkid      = $this->input->post('checkList');
        $jummenu    = count($this->input->post('checkList'));
        // var_dump($groupid,$jummenu,$chkid); die;

        if (!empty($chkid)){			
            $this->m_menuAkses->hapus_menuakses($groupid);
            for($i=0; $i < $jummenu; $i++)
            {
                if (isset($chkid[$i]))
                {
                    $menuid = $chkid[$i];
                    $this->m_menuAkses->simpanAkses($groupid,$menuid);
                }
            }
        }

        redirect('menuAkses/index'); 
    }
            
    function get_listMenu(){
        if('IS_AJAX') {
            $groupID = $this->input->post('grupid');
            $data['_getMenu1'] = $this->m_menuAkses->selectMenu1($groupID);
            $data['_getMenu2'] = $this->m_menuAkses->selectMenu2($groupID);
            $data['_getMenu3'] = $this->m_menuAkses->selectMenu3($groupID);
            
            $this->load->view('utility/menu_akses/list_menu',$data);
        }
    }
}

/* End of file menuAkses.php */
/* Location: ./application/controllers/menuAkses.php */