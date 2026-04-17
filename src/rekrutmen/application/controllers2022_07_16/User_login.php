<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: itd15
 * Date: 10/08/2015
 * Time: 9:58
 */
class User_login extends CI_Controller{

    public function __cunstruct(){
        parent:: __construct();
        $this->load->model('darurat');
        $this->load->model('m_user_login');
        $status = $this->darurat->getStatus();
        if($status === 1 && $this->session->userdata('userid') !=='ismo_adm'){
            redirect(site_url('maintenanceControl'));
        }
        
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('userid')){
            redirect('login');
        }
    }

    function index(){
        $this->load->model(array('m_user_login'));
        $data['pesan']="";
        $data['getGrupUser'] = $this->m_user_login->getGrupUser();
        $data['getDept'] = $this->m_user_login->getDept();
        $this->template->display('utility/user_login/index',$data);
    }

    function tambah(){
        if ($this->input->post('txtStatus') == 'K'){
            $stat = 1;
        }elseif ($this->input->post('txtStatus') == 'TK'){
            $stat = 2;
        }else{
            $stat = 3;
        }
        //====================Simpan Data
        $data= array('LoginID'  => strtolower($this->input->post('txtUsername')),
              'NamaUser'         => $this->input->post('txtNamaLengkap'),
              'LoginPassword'    => md5(sha1($this->input->post('txtPassword'))),
              'DeptID'           => strtoupper($this->input->post('txtDept')),
              'GroupID'          => $this->input->post('txtGrupID'),
              'AnggotaScreening' => $this->input->post('txtScreening'),
              'NotActive'        => $this->input->post('txtStatus'),
              'InActive'         => $this->input->post('txtStatus'),
              'PersonalStatus'   => $stat,
              'PersonalId'       => $this->input->post('txtRegno'),
              'CreatedBy'        => strtoupper($this->session->userdata('username')),
              'CreatedDate'      => date('Y-m-d H:i:s')
        );
        $loginID = array( 'LoginID' => strtolower($this->input->post('txtUsername')) );
        $this->load->model('m_user_login');
        $this->m_user_login->saveDetail($loginID);
        $result = $this->m_user_login->save($data);

        if(!$result){
            redirect('user_login/listUserLogin?msg=success_add');
        }else{
            $data['pesan']="<p class='alert alert-danger'>Gagal Tambah User.. </p>";
            $this->template->display('utility/user_login/index',$data);
        }
    }

    function listUserLogin(){
        $this->load->model('m_user_login');
        
        $data['getUserLogin']   = $this->m_user_login->selectUserLogin();
        $data['dtdepartemen']   = $this->m_user_login->get_alldepartemen();

        //$data['getGrupUser'] = $this->m_user_login->selectGrupUser($id);
        
        $this->template->display('utility/user_login/list_userLogin',$data);
    }

    function editUserLogin(){
        $this->load->model('m_user_login'); 

        $id = $this->input->get('id');
        $data['getUser'] = $this->m_user_login->getUserLogin($id);
        $data['getGrupUser'] = $this->m_user_login->getGrupUser();
        $data['getDept'] = $this->m_user_login->getDept();
        $this->template->display('utility/user_login/editUserLogin',$data);

    }

    function deleteUserLogin(){
        $id = $this->input->get('id'); 

        $this->load->model('m_user_login');
        $result = $this->m_user_login->delete($id);
        $this->m_user_login->deleteDetail($id);

        if(!$result){
            redirect('user_login/listUserLogin?msg=success_delete');
        }else{
            redirect('user_login/listUserLogin?msg=failed_delete');
        }
    }

    function ubahPassword(){
        $this->load->model('m_user_login');

        $id = $this->input->get('id');
        $data['pesan']="";
        $data['getUser'] = $this->m_user_login->getUserLogin($id);
        $this->template->display('utility/user_login/ubahPassword',$data);
    }

    function updatePassword(){
        $this->load->model('m_user_login');
        
        $userID = $this->input->post('txtUserID');
        $data = array('LoginPassword'=> md5(sha1($this->input->post('txtNewPass'))),
            'UpdatedBy'=> strtoupper($this->session->userdata('username')),
            'UpdatedDate'=> date('Y-m-d H:i:s')
            );
        $this->m_user_login->ubahPassword($userID,$data);

        redirect('user_login/listUserLogin?msg=ok');
    }
    
    function updateUserLogin(){
        $this->load->model('m_user_login');
        
        $data   = array(
            'NamaUser'         => $this->input->post('txtNamaLengkap'),
            'DeptID'           => strtoupper($this->input->post('txtDept')),
            'GroupID'          => $this->input->post('txtGrupID'),
            'AnggotaScreening' => $this->input->post('txtScreening'),
            'NotActive'        => $this->input->post('txtStatus'),
            'InActive'         => $this->input->post('txtStatus'),
            'UpdatedBy'        => strtoupper($this->session->userdata('username')),
            'UpdatedDate'      => date('Y-m-d H:i:s')
        );
        $userID = array('LoginID'=>$this->input->get('id'));
        
        $result = $this->m_user_login->updateUserLogin($userID,$data);
        if(!$result){
            redirect('user_login/listUserLogin?msg=success_edit');
        }else{
            redirect('user_login/listUserLogin?msg=failed_edit');
        }
    }


    function getmynikKaryawan(){
        $nik = $this->input->post('nik');
        $tipe = $this->input->post('tipe');
        // $datapost       = array(
        //     'nik'      => $nik
        // );
        
        if(is_numeric($nik)==false){
            $data = array('Err'=>1,'Msg'=>'NIK harus dalam format angka 0..9 !! ' . $nik);          
        }else{
            $nikval = $this->db->escape($nik);
            $tipeval = $this->db->escape($tipe);
            $this->load->model('m_user_login');
            // if ($tipe == 'K') {
            //     $query = $this->m_user_login->get_personalkar($datapost);
            // } elseif ($tipe == 'TK') {
            //     $query = $this->m_user_login->get_personaltk($datapost);
            // } else {
            //     $query = '';
            // }
            $query = $this->m_user_login->getinfoNik($nik,$tipe);

            if (count($query) > 0) {
                foreach ($query as $result_personal_row) {
                    $nama       = $result_personal_row->NAMA;
                }

                if($tipe == 'K'){
                    if($nama !=''){
                        $data = array('Err'=>0,'tipe'=>$tipeval,'Msg'=>$query);
                    }else{
                        $data = array('Err'=>1,'Msg'=>'NIK Karyawan tidak ditemukan');
                    }
                }else{
                    if($nama !=''){
                        $data = array('Err'=>0,'tipe'=>$tipeval,'Msg'=>$query);
                    }else{
                        $data = array('Err'=>1,'Msg'=>'NIK Karyawan tidak ditemukan');
                    }
                }
            }else{
                $data = array('Err'=>1,'Msg'=>'NIK tidak ditemukan !');

            }
        }
        echo json_encode($data);
    }

    function savenewuser(){
        $this->load->model('m_user_login');
        $random_hash  = md5(uniqid(rand(), true));
        $auth         = strtoupper(substr($random_hash,0,6));
        $password     = md5(sha1($auth));

        $nik    = $this->input->post('txtNIK');
        $userid = $this->input->post('txtUsername');
        $reg    = $this->input->post('txtRegno');
        $personalstatus    = $this->input->post('txtPersonalStatus');
        $cek    = $this->m_user_login->cekUser($nik,$userid);
        if ($cek == false) {
            $dataa = array(
                'NIK'              => $this->input->post('txtNIK'),
                'NamaUser'         => $this->input->post('txtNama'),
                'LoginPassword'    => md5(sha1($this->input->post('txtPassword'))),
                'DeptID'           => $this->input->post('txtDeptID'),
                'JabatanID'        => $this->input->post('txtJabatanID'),
                'Tipe'             => $this->input->post('selType'),
                'LoginID'          => $this->input->post('txtUsername'),
                'GroupID'          => $this->input->post('txtGrupID'),
                'NotActive'        => $this->input->post('txtStatus'),
                'InActive'         => 0,
                'PersonalId'       => $this->input->post('txtRegno'),
                'PersonalStatus'   => $this->input->post('txtPersonalStatus'),
                'AnggotaScreening' => $this->input->post('txtScreening'),
                'CreatedBy'        => strtoupper($this->session->userdata('username')),
                'CreatedDate'      => date('Y-m-d H:i:s')
            );
            $this->load->model('m_user_login');
            $loginID = array( 'LoginID' => strtolower($this->input->post('txtUsername')) );
            $result = $this->m_user_login->saveAddUserLogin($dataa);
            $this->m_user_login->saveDetail($loginID);
            if($result == null){
                redirect(base_url('user_login/index?msg=success'));
            }else{
                redirect(base_url('user_login/index?msg=failed'));
            }
        }else{
            $datab = array(
                'NIK'              => $this->input->post('txtNIK'),
                'NamaUser'         => $this->input->post('txtNama'),
                'LoginPassword'    => md5(sha1($this->input->post('txtPassword'))),
                'DeptID'           => $this->input->post('txtDeptID'),
                'JabatanID'        => $this->input->post('txtJabatanID'),
                'Tipe'             => $this->input->post('selType'),
                'LoginID'          => $this->input->post('txtUsername'),
                'GroupID'          => $this->input->post('txtGrupID'),
                'NotActive'        => $this->input->post('txtStatus'),
                'InActive'         => 0,
                'PersonalId'       => $this->input->post('txtRegno'),
                'PersonalStatus'   => $this->input->post('txtPersonalStatus'),
                'AnggotaScreening' => $this->input->post('txtScreening'),
                'UpdatedBy'        => strtoupper($this->session->userdata('username')),
                'UpdatedDate'      => date('Y-m-d H:i:s')
            );
            $this->load->model('m_user_login');
            $nik       = $this->input->post('txtNIK');
            $userid       = $this->input->post('txtUsername');
            $result = $this->m_user_login->saveUpdateUserLogin($nik,$userid,$datab);
            if(!$result){
                redirect(base_url('user_login/index?msg=failed_edit'));
            }else{
                redirect(base_url('user_login/index?msg=success_edit'));
            }
        }

    }

    // function tambahuser(){
    //     $nik       = $this->input->post('txtFindBynik');
    //     $this->load->model('m_user_login');
    //     $cek = $this->m_user_login->cekUser($nik);
    //     if ($cek == false) {
    //         $param = array(
    //             'LoginID'           => strtolower($this->input->post('txtUsername')),
    //             'NIK'               => $this->input->post('txtFindBynik'),
    //             'NamaUser'          => $this->input->post('txtNama'),
    //             'LoginPassword'     => md5(sha1($this->input->post('txtPassword'))),
    //             'DeptID'            => $this->input->post('txtDeptID'),
    //             'JabatanID'         => $this->input->post('txtJabatanID'),
    //             'Tipe'              => $this->input->post('txtstatus'),
    //             'GroupID'           => $this->input->post('txtGrupID'),
    //             'NotActive'         => $this->input->post('txtStatusActive'),
    //             'AnggotaScreening'  => $this->input->post('txtScreening'),
    //             'CreatedBy'         => strtoupper($this->session->userdata('username')),
    //             'CreatedDate'       => date('Y-m-d H:i:s')
    //         );
    //         $loginID = array( 'LoginID' => strtolower($this->input->post('txtUsername')) );
    //         $this->load->model('m_user_login');
    //         $this->m_user_login->saveDetail($loginID);
    //         $result = $this->m_user_login->saveUserLogin($param);
    //         if(!$result){
    //             redirect('user_login/listUserLogin?msg=success_add');
    //         }
    //     } else {
    //         $data['pesan']="<p class='alert alert-danger'>Gagal Tambah User.. </p>";
    //         $this->template->display('utility/user_login/index',$data);
    //     }
    // }
}

/* End of file user_login.php */
/* Location: ./application/controllers/user_login.php */