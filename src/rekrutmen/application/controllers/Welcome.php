<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->check_idle();
        $this->load->model('darurat');
        $status = $this->darurat->getStatus();
        if ($status === 1 && $this->session->userdata('userid') !== 'ismo_adm') {
            redirect(site_url('maintenanceControl'));
        }

        date_default_timezone_set("Asia/Jakarta");
        if (!$this->session->userdata('userid')) {
            // if ($_SERVER['HTTP_HOST'] == '192.168.3.5') {
            //     # code...
            // }
            redirect('login');
            // print_r($_SERVER['HTTP_HOST']);
            // die;
        }

        $this->load->model('m_dashboard');
        $this->load->library('table');
        $this->load->helper('smiley');
    }

    public function index()
    {

        // if ($this->session->userdata('userid') != 'Riyan') {
        //     redirect(site_url('maintenanceControl'));
        //     die;
        // }
        $prefs = array(
            'start_day'  => 'monday',
            'month_type' => 'long',
            'day_type'   => 'long',
            'template'   => 'border = 1px;'
        );
        $this->load->library('calendar', $prefs);
        $data['cal']  = $this->calendar->generate();
        $userID = $this->session->userdata('userid');
        $data['_getLast'] = $this->m_dashboard->getLastRecord();
        // $data['_getProfile'] = $this->m_dashboard->getProfileBlacklist($NIK);
        $data['_getBlacklistRecord'] = $this->m_dashboard->getBlacklist();
        $data['_getLastlogin'] = $this->m_dashboard->getLogLoginView($userID);

        $image_array = get_clickable_smileys(base_url() . 'assets/emot/', 'txtMessage');
        $col_array = $this->table->make_columns($image_array, 6);
        $data['smiley_table'] = $this->table->generate($col_array);
        $this->template->display('dashboard', $data);
    }

    function notAksesScreen()
    {
        $this->template->display('notAksesScreening');
    }

    function viewUbahPassword()
    {
        $this->template->display('utility/ubah_pass/ubahPass');
    }

    function updatePassword()
    {
        $this->load->model('m_login');
        $id = $this->input->post('txtUserID');
        $data['getUser'] = $this->m_login->getUserLogin($id);
        foreach ($this->m_login->getUserLogin($id) as $row) :
            if ($this->input->post('simpan')) {
                $oldPass = md5(sha1($this->input->post('txtOldPass')));
                if ($oldPass == $row->LoginPassword) {
                    $userID = $this->input->post('txtUserID');
                    $data = array(
                        'LoginPassword' => md5(sha1($this->input->post('txtNewPass'))),
                        'UpdatedBy' => strtoupper($this->session->userdata('username')),
                        'UpdatedDate' => date('Y-m-d H:i:s'),
                        'LastUpdatePassword' => date('Y-m-d H:i:s'),
                    );
                    $this->m_login->ubahPassword($userID, $data);
                    redirect('welcome/viewUbahPassword?msg=ok');
                } else {
                    redirect('welcome/viewUbahPassword?msg=notMacth');
                }
            }
        endforeach;
    }

    public function ping_session()
    {
        // wajib AJAX
        if (!$this->input->is_ajax_request()) {
            show_error('No direct access allowed', 403);
        }

        // kalau user belum login
        if (!$this->session->userdata('userid')) {
            echo json_encode([
                'status' => 'logout'
            ]);
            return;
        }

        // refresh session activity
        $this->session->set_userdata('last_activity_time', time());

        echo json_encode([
            'status' => 'active',
            'time'   => time()
        ]);
    }

    private function check_idle()
    {
        $timeout = $this->config->item('sess_expiration');

        if (!$this->session->userdata('userid')) {
            return;
        }

        $last = $this->session->userdata('last_activity_time');

        if ($last && (time() - $last > $timeout)) {
            $this->session->sess_destroy();
            redirect('welcome/logout?msg=timeout');
            exit;
        }

        // jangan update terus disini, nanti dianggap aktif terus
        // update hanya lewat AJAX ping dari JS
    }


    // function logout()
    // {
    //     $this->load->model('m_login');
    //     $signid = $this->session->userdata('signid');
    //     $msg = $this->session->flashdata('message'); // ambil dulu pesannya

    //     if ($signid <> '') {
    //         $this->m_login->simpan_log_out($signid);
    //     }
    //     $login_id = $this->session->userdata('userid');
    //     if ($login_id) {
    //         $this->db->where('LoginID', $login_id);
    //         $this->db->update('tblUtlLogin', [
    //             'login_token' => NULL
    //         ]);
    //     }

    //     $this->session->unset_userdata('userid');
    //     $this->session->unset_userdata('username');
    //     $this->session->unset_userdata('groupuser');
    //     $this->session->unset_userdata('teamscreen');
    //     $this->session->unset_userdata('dept');
    //     $this->session->unset_userdata('idpemborong');
    //     $this->session->unset_userdata('pemborong');

    //     $this->load->helper('cookie');

    //     $cookie_name = $this->config->item('sess_cookie_name');


    //     $this->session->sess_destroy();
    //     $this->session->set_flashdata('message', $msg); // pasang lagi

    //     setcookie($cookie_name, '', time() - 3600, '/');
    //     //redirect('login/loginnew');
    //     redirect('C_onelogin_logout/out', 'refresh');
    // }

    function logout()
    {
        $this->load->model('m_login');
        $signid = $this->session->userdata('signid');

        // simpan pesan dulu
        $msg = $this->session->flashdata('message');

        if ($signid <> '') {
            $this->m_login->simpan_log_out($signid);
        }

        $login_id = $this->session->userdata('userid');
        if ($login_id) {
            $this->db->where('LoginID', $login_id);
            $this->db->update('tblUtlLogin', [
                'login_token' => NULL
            ]);
        }

        // bersihkan session user
        $this->session->unset_userdata('userid');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('groupuser');
        $this->session->unset_userdata('teamscreen');
        $this->session->unset_userdata('dept');
        $this->session->unset_userdata('idpemborong');
        $this->session->unset_userdata('pemborong');
        $this->session->unset_userdata('signid');

        // pasang flash message lagi
        if (!empty($msg)) {
            $this->session->set_flashdata('message', $msg);
        }
        $msgget = $this->input->get('msg'); // ambil msg dari url


        // SIMPAN PESAN SEBELUM DESTROY
        if ($msgget == "otherlogin") {
            $this->session->set_flashdata(
                'message',
                "<div class='alert alert-warning'>
                <i class='fa fa-warning'></i>
                <strong>Akun sedang login di browser lain.</strong><br>
                Silahkan logout dulu atau tunggu session expired.
            </div>"
            );
        }

        redirect('C_onelogin_logout/out', 'refresh');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */