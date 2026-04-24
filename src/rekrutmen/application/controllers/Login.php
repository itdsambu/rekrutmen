<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('user_agent'));
        $browser = $this->agent->browser();
        if ($browser == 'Internet Explorer') {
            redirect(site_url('maintenanceControl/notSupport'));
        }

        date_default_timezone_set("Asia/Jakarta");
        if ($this->session->userdata('userid')) {
            redirect('welcome');
        }

        $this->load->library('onelogin');
        $this->onelogin->keys = 'psgonelogin12345psgonelogin12345';
    }

    public function index()
    {

        $isonelogin = false;
        $mparam = $this->input->get('mparam');
        if (isset($mparam)) {
            if ($this->onelogin->getsecurecode($mparam)) {
                $isonelogin = true;
            }
        }

        if (!$isonelogin) {
            //$this->load->view('login');
            $this->load->view('login_v2');
        } else {
            $this->loginOnelogin();
        }
    }

    public function index2()
    {

        $isonelogin = false;
        $mparam = $this->input->get('mparam');
        if (isset($mparam)) {
            if ($this->onelogin->getsecurecode($mparam)) {
                $isonelogin = true;
            }
        }

        if (!$isonelogin) {
            $this->load->view('login_v2');
        } else {
            $this->loginOnelogin();
        }
    }

    private function loginOnelogin()
    {
        $userID = $this->onelogin->secuser;
        $passID = $this->onelogin->secpass;


        if (strtoupper($userID) == "PUBLIK" and strtoupper($passID) == "PUBLIK") {
            $this->session->set_flashdata('message', "<div class='alert alert-danger'><i class='fa fa-warning'>&nbsp;</i><strong>User Sudah Tidak Aktif Lagi.</strong></div>");
            redirect('login');
        } else {
            $lo = $this->cekLogin($userID, $passID);
            switch ($lo) {
                case 0:
                    redirect('login');
                    break;
                case 1:
                    redirect('login');
                    break;
                case 2:
                    redirect('login');
                    break;
                case 3:
                    redirect('login');
                    break;
                case 100:
                    redirect('welcome');
                    break;
            }
        }
    }

    public function loginNew()
    {
        $this->load->view('login_new');
    }

    // function teas(){
    //     $a = 12345;
    //     echo md5(sha1($a));

    // } //untuk bongkar md5


    function login_user()
    {
        $userID = $this->input->post('txtUserID');
        $passID = md5(sha1($this->input->post('txtPass')));

        if (strtoupper($userID) == "PUBLIK" and strtoupper($passID) == "PUBLIK") {
            $this->session->set_flashdata('message', "<div class='alert alert-danger'><i class='fa fa-warning'>&nbsp;</i><strong>User Sudah Tidak Aktif Lagi.</strong></div>");
            redirect('login');
        } else {
            $lo = $this->cekLogin($userID, $passID);
            switch ($lo) {
                case 0:
                    redirect('login');
                    break;
                case 1:
                    redirect('login');
                    break;
                case 2:
                    redirect('login');
                    break;
                case 3:
                    redirect('login');
                    break;
                case 100:
                    redirect('welcome');
                    break;
                case 300:
                    $message =
                        '<div class="alert alert-warning alert-dismissible fade in text-center" role="alert">
                        <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                            <span aria-hidden="true">x</span>
                        </button>
                        <strong>Password Kadaluarsa, silahkan perbarui password</strong>
                    </div>';
                    $this->session->set_flashdata('message', $message);
                    $this->template->display('utility/ubah_pass/ubahPass');
            }
        }
    }

    function login_user2()
    {
        // require_once(APPPATH . 'controllers/Applicant_registration.php');
        // $app_regis = new Applicant_registration();

        $userID = $this->input->post('txtUserID');
        $passID = md5(sha1($this->input->post('txtPass')));

        if (strtoupper($userID) == "PUBLIK" and strtoupper($passID) == "PUBLIK") {
            $this->session->set_flashdata('message', "<div class='alert alert-danger'><i class='fa fa-warning'>&nbsp;</i><strong>User Sudah Tidak Aktif Lagi.</strong></div>");
            redirect('login');
        } else {
            $lo = $this->cekLogin2($userID, $passID);


            switch ($lo) {
                case 0:
                    redirect('login');
                    break;
                case 1:
                    redirect('login');
                    break;
                case 2:
                    redirect('login');
                    break;
                case 3:
                    redirect('login');
                    break;
                case 4:
                    redirect('login');
                    break;
                case 100:
                    redirect('welcome');
                    break;
                case 300:
                    $message =
                        '<div class="alert alert-warning alert-dismissible fade in text-center" role="alert">
                        <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                            <span aria-hidden="true">x</span>
                        </button>
                        <strong>Password Kadaluarsa, silahkan perbarui password</strong>
                    </div>';
                    $this->session->set_flashdata('message', $message);
                    $this->template->display('utility/ubah_pass/ubahPass');
            }
        }
    }

    function login2()
    {
        $userID = $this->input->get('username');
        $passID = $this->input->get('password');
        if (strtoupper($userID) == "PUBLIK" and strtoupper($passID) == "PUBLIK") {
            $this->session->set_flashdata('message', "<div class='alert alert-danger'><i class='fa fa-warning'>&nbsp;</i><strong>User Sudah Tidak Aktif Lagi.</strong></div>");
            redirect('login');
        } else {
            $lo = $this->cekLogin2($userID, $passID);
            switch ($lo) {
                case 0:
                    redirect('login');
                    break;
                case 1:
                    redirect('login');
                    break;
                case 2:
                    redirect('login');
                    break;
                case 3:
                    redirect('login');
                    break;
                case 100:
                    redirect('welcome');
                    break;
                case 300:
                    $message =
                        '<div class="alert alert-warning alert-dismissible fade in text-center" role="alert">
                        <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                            <span aria-hidden="true">x</span>
                        </button>
                        <strong>Password Kadaluarsa, silahkan perbarui password</strong>
                    </div>';
                    $this->session->set_flashdata('message', $message);
                    $this->template->display('utility/ubah_pass/ubahPass');
                    break;
            }
        }
    }

    function cekLogin($userID, $passID)
    {
        $this->load->model('m_login');
        $log    = $this->m_login->log_in($userID);
        $cek    = $this->m_login->cekpass($userID, $passID);

        if ($log->num_rows() > 0) {
            $row = $log->row();
            if ($row->NotActive === 1) {
                redirect('C_onelogin_verifikasi');
                exit();
                return 1;
            } else if ($cek === true) {
                $this->session->set_userdata('userid', $userID);
                $this->session->set_userdata('teamscreen', $row->AnggotaScreening);
                $this->session->set_userdata('username', $row->NamaUser);
                $this->session->set_userdata('nik', $row->NIK);  //mengambil field UserName untuk disimpan di session
                $this->session->set_userdata('groupuser', $row->GroupID);
                $this->session->set_userdata('groupname', $row->GroupName);
                $this->session->set_userdata('dept', $row->DeptAbbr);
                $this->session->set_userdata('personalstatus', $row->PersonalStatus);
                $this->set_info_pemborong($row->GroupID);
                $this->set_info_device();
                $this->simpan_log();
                $exp_date = date('Ymd', strtotime($row->LastUpdatePassword));
                $now_date = date('Ymd');
                // if ($passID == '123456' ||$passID == '1234' || $passID == '123' || ($exp_date + 300) < $now_date){
                //     return 300;
                // }else{
                return 100;
                // }
            } else {
                $this->session->set_flashdata('message', "<div class='alert alert-danger'><i class='fa fa-warning'>&nbsp;</i><strong>Password Anda Salah.</strong></div>");
                return 3;
            }
        } else {
            $this->session->set_flashdata('message', "<div class='alert alert-danger'><i class='fa fa-warning'>&nbsp;</i><strong>User $userID Tidak Terdaftar.</strong></div>");
            return 0;
        }
    }

    function cekLogin2($userID, $passID)
    {
        $this->load->model('m_login');
        $log    = $this->m_login->log_in2($userID);
        $cek    = $this->m_login->cekpass2($userID, $passID);
        // $checkLogedIn    = $this->m_login->checkLogInaAnotherDevice($userID);
        if ($log->num_rows() > 0) {
            $row = $log->row();
            if ($row->InActive === 1) {
                redirect('C_onelogin_verifikasi');
                // print_r('test');
                // die;
                exit();
                return 1;
                // } elseif ($checkLogedIn) {
                //     $this->session->set_flashdata('message', "<div class='alert alert-danger'><i class='fa fa-warning'>&nbsp;</i><strong>Anda sudah login di device lain.</strong></div>");
                //     return 1;
            } else if ($cek === true) {
                // print_r($row);
                // die;
                // if ($row->login_token != null || $row->login_token != '') {
                //     $this->session->set_flashdata(
                //         'message',
                //         "<div class='alert alert-warning'>
                //     <i class='fa fa-warning'></i>
                //     <strong>Akun sedang login di browser lain.</strong><br>
                //     Silahkan logout dulu atau tunggu session expired.
                // </div>"
                //     );
                //     return 4; // sudah login di tempat lain
                // }
                $token = bin2hex(random_bytes(32));
                $this->session->set_userdata('userid', $userID);
                $this->session->set_userdata('teamscreen', $row->AnggotaScreening);
                $this->session->set_userdata('username', $row->NamaUser);
                $this->session->set_userdata('nik', $row->NIK);  //mengambil field UserName untuk disimpan di session
                $this->session->set_userdata('groupuser', $row->GroupID);
                $this->session->set_userdata('groupname', $row->GroupName);
                $this->session->set_userdata('dept', $row->DeptAbbr);
                $this->session->set_userdata('personalstatus', $row->PersonalStatus);
                $this->session->set_userdata('login_token', $token);
                $this->set_info_pemborong($row->GroupID);
                $this->set_info_device();
                $this->simpan_log();
                $exp_date = date('Ymd', strtotime($row->LastUpdatePassword));
                $now_date = date('Ymd');

                $this->db->where('LoginID', $userID);
                $this->db->update('tblUtlLogin', [
                    'login_token' => $token,
                    'last_login'  => date("Y-m-d H:i:s")
                ]);
                // if ($passID == '123456' ||$passID == '1234' || $passID == '123' || ($exp_date + 300) < $now_date){
                //     return 300;
                // }else{
                return 100;
                // }
            } else {
                $this->session->set_flashdata('message', "<div class='alert alert-danger'><i class='fa fa-warning'>&nbsp;</i><strong>Password Anda Salah.</strong></div>");
                return 3;
            }
            // $this->load->library('Mobile_Detect');
            // $detect = new Mobile_detect();

            // $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? '' : '') : 'PC');

            // if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS() || $row->PersonalStatus == 3){
            //     if ($row->InActive != 1 && $cek === true){
            //         $this->session->set_userdata('userid',$userID);
            //         $this->session->set_userdata('teamscreen',$row->AnggotaScreening);
            //         $this->session->set_userdata('username',$row->NamaUser);
            //         $this->session->set_userdata('nik',$row->NIK);  //mengambil field UserName untuk disimpan di session
            //         $this->session->set_userdata('groupuser',$row->GroupID);
            //         $this->session->set_userdata('dept',$row->DeptAbbr);
            //         $this->session->set_userdata('personalstatus',$row->PersonalStatus);
            //         $this->set_info_pemborong($row->GroupID);
            //         $this->set_info_device();
            //         $this->simpan_log();
            //         $exp_date = date('Ymd',strtotime($row->LastUpdatePassword));
            //         $now_date = date('Ymd');
            //         if ($passID == '123456' ||$passID == '1234' || $passID == '123' || ($exp_date + 300) < $now_date){
            //             return 300;
            //         }else{
            //             return 100;
            //         }
            //     }else{
            //         $this->session->set_flashdata('message',"<div class='alert alert-danger'><i class='fa fa-warning'>&nbsp;</i><strong>Password Anda Salah.</strong></div>");
            //         return 3;
            //     }
            // }else{
            //     redirect('C_onelogin_verifikasi');exit();
            //     return 1;
            // }
        } else {
            $this->session->set_flashdata('message', "<div class='alert alert-danger'><i class='fa fa-warning'>&nbsp;</i><strong>User $userID Tidak Terdaftar.</strong></div>");
            return 0;
        }
    }

    function simpan_log()
    {
        $this->load->model('m_login');
        $this->load->library(array('user_agent', 'mobile_Detect', 'misc'));

        $detect = new Mobile_Detect();

        $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? '' : '') : 'PC');

        foreach ($detect->getRules() as $name => $regex) :
            $check = $detect->{'is' . $name}();
            if ($check == 'true') {
                $deviceType .= $name . ' ';
            }
        endforeach;

        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }

        $info = array(
            'Tanggal'       => date('Y-m-d H:i:s'),
            'SignIn'        => date('Y-m-d H:i:s'),
            'UserID'        => strtoupper($this->session->userdata('userid')),
            'Hostname'      => $this->session->userdata('hostname'),
            'IPAddress'     => $this->session->userdata('ipaddress'),
            'Device'        => $deviceType,
            'Browser'       => $agent,
            'Platform'      => $this->misc->platform(),
            'User_Agent'    => $this->agent->agent_string(),
            'Status'        => 'Online'
        );
        // print_r($info);
        // exit;
        $signid = $this->m_login->simpan_log($info);
        if ($signid === 0) {
            $this->session->set_userdata('signid', 0);
        } else {
            $this->session->set_userdata('signid', $signid);
        }
    }

    function simpan_log_failed()
    {
        $this->load->model('m_login');
        $this->load->library(array('user_agent', 'mobile_Detect', 'misc'));

        $detect = new Mobile_Detect();

        $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? '' : '') : 'PC');

        foreach ($detect->getRules() as $name => $regex) :
            $check = $detect->{'is' . $name}();
            if ($check == 'true') {
                $deviceType .= $name . ' ';
            }
        endforeach;

        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }

        $info = array(
            'Tanggal'       => date('Y-m-d H:i:s'),
            'SignIn'        => date('Y-m-d H:i:s'),
            'UserID'        => strtoupper($this->session->userdata('userid')),
            'Hostname'      => $this->session->userdata('hostname'),
            'IPAddress'     => $this->session->userdata('ipaddress'),
            'Device'        => $deviceType,
            'Browser'       => $agent,
            'Platform'      => $this->misc->platform(),
            'User_Agent'    => $this->agent->agent_string(),
            'Status'        => 'Online'
        );
        // print_r($info);
        // exit;
        $signid = $this->m_login->simpan_log($info);
        if ($signid === 0) {
            $this->session->set_userdata('signid', 0);
        } else {
            $this->session->set_userdata('signid', $signid);
        }
    }

    function set_info_device()
    {
        $ipaddr = $_SERVER['REMOTE_ADDR'];
        $this->session->set_userdata('ipaddress', $ipaddr);

        $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $this->session->set_userdata('hostname', $hostname);
    }

    function set_info_pemborong($groupuser)
    {
        switch ($groupuser) {
            case 132:
                $this->session->set_userdata('idpemborong', 1);
                $this->session->set_userdata('pemborong', 'CV. CSR');
                break;
            case 112:
                $this->session->set_userdata('idpemborong', 2);
                $this->session->set_userdata('pemborong', 'CV. HML');
                break;
            case 113:
                $this->session->set_userdata('idpemborong', 3);
                $this->session->set_userdata('pemborong', 'CV. MHB');
                break;
            case 114:
                $this->session->set_userdata('idpemborong', 4);
                $this->session->set_userdata('pemborong', 'CV. LGJ');
                break;
            case 115:
                $this->session->set_userdata('idpemborong', 5);
                $this->session->set_userdata('pemborong', 'CV. MHR');
                break;
            case 116:
                $this->session->set_userdata('idpemborong', 6);
                $this->session->set_userdata('pemborong', 'CV. JKP');
                break;
            case 117:
                $this->session->set_userdata('idpemborong', 7);
                $this->session->set_userdata('pemborong', 'CV. PIN');
                break;
            case 118:
                $this->session->set_userdata('idpemborong', 8);
                $this->session->set_userdata('pemborong', 'CV. AKT');
                break;
            case 119:
                $this->session->set_userdata('idpemborong', 9);
                $this->session->set_userdata('pemborong', 'CV. HPT');
                break;
            case 120:
                $this->session->set_userdata('idpemborong', 10);
                $this->session->set_userdata('pemborong', 'CV. TRH');
                break;
            case 121:
                $this->session->set_userdata('idpemborong', 11);
                $this->session->set_userdata('pemborong', 'CV. BST');
                break;
            case 122:
                $this->session->set_userdata('idpemborong', 12);
                $this->session->set_userdata('pemborong', 'CV. TDY');
                break;
            case 123:
                $this->session->set_userdata('idpemborong', 13);
                $this->session->set_userdata('pemborong', 'CV. HZM');
                break;
            case 124:
                $this->session->set_userdata('idpemborong', 14);
                $this->session->set_userdata('pemborong', 'PT.AAA');
                break;
            case 125:
                $this->session->set_userdata('idpemborong', 15);
                $this->session->set_userdata('pemborong', 'CV. MDR');
                break;
            case 126:
                $this->session->set_userdata('idpemborong', 16);
                $this->session->set_userdata('pemborong', 'CV. MBH');
                break;
            case 127:
                $this->session->set_userdata('idpemborong', 17);
                $this->session->set_userdata('pemborong', 'CV. LTS');
                break;
            case 128:
                $this->session->set_userdata('idpemborong', 18);
                $this->session->set_userdata('pemborong', 'CV. SHP');
                break;
            case 135:
                $this->session->set_userdata('idpemborong', 21);
                $this->session->set_userdata('pemborong', 'CV. SA');
                break;
            case 136:
                $this->session->set_userdata('idpemborong', 21);
                $this->session->set_userdata('pemborong', 'CV. RLP');
                break;
            default:
                $this->session->set_userdata('idpemborong', 0);
                $this->session->set_userdata('pemborong', '');
        }

        // print_r($this->session->userdata('idpemborong'));
        // exit;
    }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */