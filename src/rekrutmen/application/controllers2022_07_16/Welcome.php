<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Author by ITD15
     */
    
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

        $this->load->model('m_dashboard');
        $this->load->library('table');
        $this->load->helper('smiley');
    }
        
    public function index(){
        $prefs = array (
            'start_day' => 'monday',
            'month_type'=> 'long',
            'day_type'  => 'long',
            'template'  => 'border=1px;'
        );
        $this->load->library('calendar',$prefs);
        $data['cal']    = $this->calendar->generate();
        $userID = $this->session->userdata('userid');
        $data['_getLast'] = $this->m_dashboard->getLastRecord();
        // $data['_getProfile'] = $this->m_dashboard->getProfileBlacklist($NIK);
        $data['_getBlacklistRecord'] = $this->m_dashboard->getBlacklist();
        $data['_getLastlogin'] = $this->m_dashboard->getLogLoginView($userID);
        
        $image_array = get_clickable_smileys(base_url() . 'assets/emot/', 'txtMessage');
        $col_array = $this->table->make_columns($image_array, 6);
        $data['smiley_table'] = $this->table->generate($col_array);
        $this->template->display('dashboard',$data);
        
    }
        
    function notAksesScreen(){
        $this->template->display('notAksesScreening');
    }
    
    function viewUbahPassword(){
        $this->template->display('utility/ubah_pass/ubahPass');
    }
        
    function updatePassword(){
        $this->load->model('m_login');
        $id = $this->input->post('txtUserID');
        $data['getUser'] = $this->m_login->getUserLogin($id);
        foreach ($this->m_login->getUserLogin($id) as $row):
            if($this->input->post('simpan')){
                $oldPass = md5(sha1($this->input->post('txtOldPass')));
                if($oldPass == $row->LoginPassword){
                    $userID = $this->input->post('txtUserID');
                    $data = array(
                        'LoginPassword'=> md5(sha1($this->input->post('txtNewPass'))),
                        'UpdatedBy'=> strtoupper($this->session->userdata('username')),
                        'UpdatedDate'=> date('Y-m-d H:i:s'),
                        'LastUpdatePassword' => date('Y-m-d H:i:s'),
                        );
                    $this->m_login->ubahPassword($userID,$data);
                    redirect('welcome/viewUbahPassword?msg=ok');
                }else{
                    redirect('welcome/viewUbahPassword?msg=notMacth');
                }
            }
        endforeach;
    }
                
    function logout(){
        $this->load->model('m_login');
        $signid = $this->session->userdata('signid');

        if ($signid <> ''){
                $this->m_login->simpan_log_out($signid);
        }

        $this->session->unset_userdata('userid');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('groupuser');
        $this->session->unset_userdata('teamscreen');
        $this->session->unset_userdata('dept');
        $this->session->unset_userdata('idpemborong');
        $this->session->unset_userdata('pemborong');
        //redirect('login/loginnew');
        redirect('login');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */