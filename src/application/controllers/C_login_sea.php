<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_login_sea extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('user_agent'));
        $browser    = $this->agent->browser();
        if ($browser == 'Internet Explorer') {
            redirect(site_url('maintenanceControl/notSupport'));
        }

        date_default_timezone_set("Asia/Jakarta");
        if ($this->session->userdata('userid')) {
            redirect('welcome');
        }
        $this->load->model('m_login');
        $this->load->library('onelogin');
        $this->onelogin->keys = 'psgonelogin12345psgonelogin12345';
    }

    public function index($personalid = NULL, $personalstatus = NULL)
    {
        // $personalid     = $this->input->get('personalid');
        // $personalstatus = $this->input->get('personalstatus');
        // $appkey         = $this->input->get('appkey');
        // print_r($personalstatus);
        // die;

        $result = $this->m_login->login_sea($personalid, $personalstatus);
        if ($result != false && $result->num_rows() > 0) {
            $row = $result->row();
            $this->session->set_userdata('userid', $row->LoginID);
            $this->session->set_userdata('teamscreen', $row->AnggotaScreening);
            $this->session->set_userdata('username', $row->NamaUser);
            $this->session->set_userdata('nik', $row->NIK);  //mengambil field UserName untuk disimpan di session
            $this->session->set_userdata('groupuser', $row->GroupID);
            $this->session->set_userdata('dept', $row->DeptAbbr);
            $this->session->set_userdata('personalstatus', $row->PersonalStatus);
            $this->set_info_pemborong($row->GroupID);
            $this->set_info_device();
            $this->simpan_log();
            redirect('welcome');
        } else {
            redirect('/C_onelogin_logout/invalidaccess', 'refresh');
            exit;
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
            'Tanggal'   => date('Y-m-d H:i:s'),
            'SignIn'    => date('Y-m-d H:i:s'),
            'UserID'    => strtoupper($this->session->userdata('userid')),
            'Hostname'    => $this->session->userdata('hostname'),
            'IPAddress'    => $this->session->userdata('ipaddress'),
            'Device'    => $deviceType,
            'Browser'    => $agent,
            'Platform'    => $this->misc->platform(),
            'User_Agent' => $this->agent->agent_string(),
            'Status'    => 'Online'
        );

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
    }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */