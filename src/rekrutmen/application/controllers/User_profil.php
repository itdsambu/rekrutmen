<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_Profil extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('darurat');
        $status = $this->darurat->getStatus();
        if ($status === 1 && $this->session->userdata('userid') !== 'ismo_adm') {
            redirect(site_url('maintenanceControl'));
        }
        $this->load->library(array('user_agent'));

        date_default_timezone_set("Asia/Jakarta");
        if (!$this->session->userdata('userid')) {
            redirect('login');
        }

        $this->load->model('m_user_profil');
    }

    public function index()
    {
        $loginID                   = $this->session->userdata('userid');
        $data['profil'] = $this->m_user_profil->getProfileRow($loginID);
        $data['_getLastLogin']     = $this->m_user_profil->getLastLogin($loginID);

        if ($this->agent->is_mobile()) {
            $mobile = 1;
        } else {
            $mobile = 0;
        }

        $data['_isMobile']  = $mobile;
        $this->template->display('utility/user_profil/index', $data);
    }

    function hitungUmur($tglLahir = "1991-02-01")
    {
        $thn    = substr($tglLahir, 0, 4);
        $bln    = substr($tglLahir, 5, 2);
        $day    = substr($tglLahir, 8, 2);

        $nowY   = date("Y");
        $nowM   = date("m");
        $nowD   = date("d");

        $hariLahir  = gregoriantojd($bln, $day, $thn);
        $today      = gregoriantojd($nowM, $nowD, $nowY);

        $umur   = $today - $hariLahir;
        $tahun  = substr($umur / 365, 0, 3);

        return $tahun;
        /*        $sisa   = $umur%365;
//        
//        $bulan  = $sisa/30;
//        $hari   = $sisa%30;
        
//        print $tahun."<br/>";
//        print $sisa."<br/>";
//        print $bulan."<br/>";
//        print $hari."<br/>"; */
    }

    function photo()
    {
        if ('IS_AJAX') {
            $data['loginID'] = $this->input->post('kode');
            //$data['datatk'] = $this->m_wawancara->getDetailTK($kode)->result();
            $this->load->view('utility/user_profil/changePhoto', $data);
        }
    }

    // function uploadPhoto()
    // {
    //     $this->load->library('image_moo');

    //     $url = './dataupload/fotoProfil/';
    //     $loginID    = $this->input->post("txtLoginID");
    //     $filefoto = $loginID;

    //     $config['upload_path']      = $url;
    //     $config['allowed_types']    = 'jpeg|jpg|png|gif';
    //     $config['allow_scale_up']   = true;
    //     $config['overwrite']        = true;
    //     $config['max_size']         = '1024';
    //     $config['file_name']        = $filefoto . '.png';    //Filename harus pakai headerID pelamar

    //     $this->load->library('upload');
    //     $this->upload->initialize($config);

    //     if ($this->upload->do_upload('fileFoto1') == "") {
    //         $file = $this->upload->do_upload('fileFoto2');
    //     } else {
    //         $file = $this->upload->do_upload('fileFoto1');
    //     }
    //     if ($file) {
    //         $files = $this->upload->data();
    //         $fileNameResize = $config['upload_path'] . $files['file_name'];

    //         $this->image_moo
    //             ->load($fileNameResize)
    //             ->set_background_colour('#fff')
    //             ->resize(200, 200, TRUE)
    //             ->save($fileNameResize, true);

    //         if ($this->image_moo->errors) {
    //             redirect("user_profil/index?failed");
    //         } else {
    //             $this->m_user_profil->update_status_foto($loginID);
    //             $this->image_moo->clear();
    //             redirect("user_profil/index");
    //         }
    //     } else {
    //         redirect("user_profil/index?failed");
    //     }
    //     $this->image_moo->clear();
    // }

    function uploadPhoto()
    {
        $this->load->library('image_moo');
        $this->load->helper('security');

        $url = './dataupload/fotoProfil/';
        $loginID = $this->input->post("txtLoginID", true);

        if (!$loginID) {
            redirect("user_profil/index?failed");
            exit;
        }

        // ====== Pilih file yang diupload ======
        $fieldUpload = null;

        if (!empty($_FILES['fileFoto1']['name'])) {
            $fieldUpload = 'fileFoto1';
        } elseif (!empty($_FILES['fileFoto2']['name'])) {
            $fieldUpload = 'fileFoto2';
        } else {
            redirect("user_profil/index?failed");
            exit;
        }

        // ====== Proteksi tambahan: cek extension manual ======
        $ext = strtolower(pathinfo($_FILES[$fieldUpload]['name'], PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($ext, $allowedExt)) {
            redirect("user_profil/index?failed_ext");
            exit;
        }

        // ====== Config Upload ======
        $config['upload_path']        = $url;
        $config['allowed_types']      = 'jpg|jpeg|png|gif';
        $config['max_size']           = 1024; // KB
        $config['overwrite']          = true;
        $config['encrypt_name']       = false;

        // Force file name based on loginID
        $config['file_name']          = $loginID . '.png';

        // Tambahan keamanan CI3
        $config['detect_mime']        = true;
        $config['file_ext_tolower']   = true;
        $config['remove_spaces']      = true;

        $this->load->library('upload');
        $this->upload->initialize($config);

        // ====== Upload file ======
        if (!$this->upload->do_upload($fieldUpload)) {
            // optional debug:
            // echo $this->upload->display_errors(); die;

            redirect("user_profil/index?failed_upload");
            exit;
        }

        $files = $this->upload->data();
        $filePath = $files['full_path'];

        // ====== Validasi gambar asli (ANTI JS/PHP RENAMED) ======
        $imgCheck = @getimagesize($filePath);

        if ($imgCheck === false) {
            // File bukan gambar walaupun extension nya image
            @unlink($filePath);
            redirect("user_profil/index?failed_not_image");
            exit;
        }

        // ====== Resize + Re-encode ======
        $this->image_moo
            ->load($filePath)
            ->set_background_colour('#fff')
            ->resize(200, 200, TRUE)
            ->save($filePath, true);

        if ($this->image_moo->errors) {
            @unlink($filePath);
            redirect("user_profil/index?failed_resize");
            exit;
        }

        // ====== Update DB ======
        $this->m_user_profil->update_status_foto($loginID);

        $this->image_moo->clear();

        redirect("user_profil/index");
    }


    function setting()
    {
        if ('IS_AJAX') {
            $loginID    = $this->session->userdata('userid');
            $data['_getProfilSendiri'] = $this->m_user_profil->getProfile($loginID);
            $this->load->view('utility/user_profil/updateProfil', $data);
        }
    }

    function updateProfile()
    {
        $loginID    = $this->session->userdata('userid');
        $data       = array(
            'NamaDepan'       => $this->input->post('txtNamaDepan'),
            'NamaBelakang'    => $this->input->post('txtNamaBelakang'),
            'JenisKelamin'    => $this->input->post('txtJekel'),
            'TanggalLahir'    => $this->input->post('txtTglLahir'),
            'Facebook'        => $this->input->post('txtFacebook'),
            'Twitter'         => $this->input->post('txtTwitter'),
            'GooglePlus'      => $this->input->post('txtGooglePlus'),
            'Email'           => $this->input->post('txtEmail'),
            'URL'             => $this->input->post('txtWebPage')
        );

        $this->m_user_profil->updateProfile($loginID, $data);
        redirect('user_profil/index');
    }
}
