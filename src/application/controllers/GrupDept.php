<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class GrupDept extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('darurat');
        $status = $this->darurat->getStatus();
        // if($status === 1 && $this->session->userdata('userid') !=='ismo_adm'){
        if($status === 1 && $this->session->userdata('userid') !=='riyan'){
            redirect(site_url('maintenanceControl'));
        }
        
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('userid')){
            redirect('login');
        }
        $this->load->model(array('m_grup_user','m_grupDept'));
    }
    
    public function index(){
        $data['_getGrupUser'] = $this->m_grup_user->selectGrupUser();
        
        $this->template->display('utility/grup_dept/index',$data);
    }
    
    function simpan(){
        $groupid    = $this->input->post('txtGroupID');
        $chkid      = $this->input->post('checkList');
        $jummenu    = count($this->input->post('checkList'));
        // var_dump($jummenu); die;

        if (!empty($chkid)){			
            $this->m_grupDept->hapus_menuakses($groupid);
            for($i=0; $i < $jummenu; $i++)
            {
                if (isset($chkid[$i]))
                {
                    $menuid = $chkid[$i];
                    $this->m_grupDept->simpanAkses($groupid,$menuid);
                }
            }
        }

        redirect('grupDept/index'); 
    }
            
    function get_listDept(){
        if('IS_AJAX') {
            $grupID = $this->input->post('grupid');
            $data['_getDept'] = $this->m_grupDept->getDept($grupID);
            
            $this->load->view('utility/grup_dept/list_dept',$data);
        }
    }
}

/* End of file menuAkses.php */
/* Location: ./application/controllers/menuAkses.php */