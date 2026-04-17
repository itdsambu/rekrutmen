<?php

class C_tandatangan extends CI_Controller
{

    var $data = array();

    function __construct()
    {

        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');

        $this->load->model(array('M_menu', 'master/user/M_menu_user', 'master/M_userlevel', 'master/M_tandatangan'));
    }

    function index()
    {
        if ($this->session->userdata('logged_in')) {
            $session_data            = $this->session->userdata('logged_in');
            $data['username']        = $session_data['username'];
            $data['password']        = $session_data['password'];
            $data['jabid']           = $session_data['jabid'];
            $data['leveluserid']     = $session_data['leveluserid'];
            $data['nmdepan']         = $session_data['nmdepan'];
            $data['levelusernm']     = $session_data['levelusernm'];
            $data['bagnm']           = $session_data['bagnm'];
            $data['jabnm']           = $session_data['jabnm'];

            $LevelUser      = $session_data['leveluserid'];
            $UserName       = $session_data['username'];
            $LevelUserNm    = $session_data['levelusernm'];

            $cekLevelUserNm = substr($LevelUserNm, 0, 7);
            $data['cekLevelUserNm'] = substr($LevelUserNm, 0, 7);
            $Bagian = $session_data['bagnm'];

            $menus = $this->M_menu->menus($LevelUser);
            $data2 = array('menus' => $menus);

            switch ($Bagian) {
                case $Bagian == 'ITD':
                    $dtbag = "";
                    break;
                default:
                    $dtbag = "WHERE bagnm like '%" . $Bagian . "%'";
                    break;
            }

            $this->data['query'] = $this->M_menu_user->get_allrecords($dtbag);
            $this->load->view('master/user/V_menu_user', array_merge($data, $data2, $this->data));
        } else {
            //Jika tidak ada session di kembalikan ke halaman login
            redirect('C_login', 'refresh');
        }
    }

    function sign()
    {
        if ($this->session->userdata('logged_in')) {
            $session_data              = $this->session->userdata('logged_in');
            $data['username']          = $session_data['username'];
            $data['password']          = $session_data['password'];
            $data['jabid']             = $session_data['jabid'];
            $data['leveluserid']       = $session_data['leveluserid'];
            $data['nmdepan']           = $session_data['nmdepan'];
            $data['levelusernm']       = $session_data['levelusernm'];
            $data['bagnm']             = $session_data['bagnm'];
            $data['jabnm']             = $session_data['jabnm'];


            $LevelUser      = $session_data['leveluserid'];
            $UserName       = $session_data['username'];
            $LevelUserNm    = $session_data['levelusernm'];

            $cekLevelUserNm         = substr($LevelUserNm, 0, 7);
            $data['cekLevelUserNm'] = substr($LevelUserNm, 0, 7);
            $Bagian                 = $session_data['bagnm'];

            $menus = $this->M_menu->menus($LevelUser);
            $data2 = array('menus' => $menus);

            //ambil variabel URL
            $id                   = $this->uri->segment(4);
            $nmlengkap            = $this->uri->segment(5);

            $dtdepartemen = $this->M_menu_user->get_alldepartemen();
            $data_departemen = array('dtdepartemen' => $dtdepartemen);

            $dtbagian = $this->M_menu_user->get_allbagian();
            $data_bagian = array('dtbagian' => $dtbagian);

            $dtjabatan = $this->M_menu_user->get_alljabatan();
            $data_jabatan = array('dtjabatan' => $dtjabatan);

            $dt_user = $this->M_tandatangan->get_data_user($id);
            $dt_nmlengkap = $this->M_tandatangan->get_data_nm($nmlengkap);
            $data3 = array('dt_user' => $dt_user);
            $data4 = array('dt_nmlengkap' => $dt_nmlengkap);

            $this->load->view('master/V_tandatangan_user', array_merge($data, $data2, $data3, $data4, $data_departemen, $data_bagian, $data_jabatan));
        } else {
            redirect('C_login', 'refresh');
        }
    }

    function simpan_ttddokumen()
    {

        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $data['username']            = $session_data['username'];
            $data['password']            = $session_data['password'];
            $data['jabid']               = $session_data['jabid'];
            $data['leveluserid']         = $session_data['leveluserid'];
            $data['nmdepan']             = $session_data['nmdepan'];
            $data['levelusernm']         = $session_data['levelusernm'];
            $data['bagnm']               = $session_data['bagnm'];
            $data['jabnm']               = $session_data['jabnm'];
            $data['personalid']          = $session_data['personalid'];


            $LevelUser      = $session_data['leveluserid'];
            $UserName       = $session_data['username'];
            $LevelUserNm    = $session_data['levelusernm'];



            $cekLevelUserNm         = substr($LevelUserNm, 0, 7);
            $data['cekLevelUserNm'] = substr($LevelUserNm, 0, 7);
            $Bagian                 = $session_data['bagnm'];

            $menus = $this->M_menu->menus($LevelUser);
            $data2 = array('menus' => $menus);

            $upload_dir = "assets/ttd/";
            $img = $this->input->post('hidden_data');
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);


            $file = $upload_dir . $this->input->post('refpersonalstatus') . '_' . $this->input->post('refpersonalid') . ".png";
            $success = file_put_contents($file, $data);
            // print $success ? $file : $file.'Unable to save the file.';

            redirect('master/user/C_menu_user', 'refresh');

            /*if($result){
                    redirect('master/C_tandatangan', 'refresh');
                }else{
                    redirect('master/C_tandatangan/ttd_dokumen?id='.$idfoto.'&nama='.$regnama);
                }*/
        } else {
            //Jika tidak ada session di kembalikan ke halaman login
            redirect('C_login', 'refresh');
        }
    }

    function simpan_ttd()
    {
        echo "<script>alert('Data berhasil disimpan....!!!! ');</script>";

        if ($this->session->userdata('logged_in')) {
            $session_data               = $this->session->userdata('logged_in');
            $data['username']           = $session_data['username'];
            $data['password']           = $session_data['password'];
            $data['jabid']              = $session_data['jabid'];
            $data['leveluserid']        = $session_data['leveluserid'];
            $data['nmdepan']            = $session_data['nmdepan'];
            $data['levelusernm']        = $session_data['levelusernm'];
            $data['bagnm']              = $session_data['bagnm'];
            $data['jabnm']              = $session_data['jabnm'];


            $LevelUser      = $session_data['leveluserid'];
            $UserName       = $session_data['username'];
            $LevelUserNm    = $session_data['levelusernm'];

            $cekLevelUserNm         = substr($LevelUserNm, 0, 7);
            $data['cekLevelUserNm'] = substr($LevelUserNm, 0, 7);
            $Bagian                 = $session_data['bagnm'];

            $menus = $this->M_menu->menus($LevelUser);
            $data2 = array('menus' => $menus);

            $NamaLengkap           = $this->input->post('Nama');

            $upload_dir = "assets/ttd/";
            $img = $this->input->post('hidden_data');
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);


            $file = $upload_dir . $this->input->post('Nama') . ".png";
            $success = file_put_contents($file, $data);
            // print $success ? $file : 'Unable to save the file.';
        } else {
            redirect('C_login', 'refresh');
        }
    }
}
