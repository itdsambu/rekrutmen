<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : Kiki Irfansyah
 */

class Applicant_registration extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');  // Load helper form untuk menampilkan CSRF token di form
        $this->load->helper('security');  // Load library security untuk token CSRF
        $this->load->model('darurat');
        $this->load->model('m_register');
        $status = $this->darurat->getStatus();
        if ($status === 1 && $this->session->userdata('userid') !== 'ismo_adm') {
            redirect(site_url('maintenanceControl'));
        }

        date_default_timezone_set("Asia/Jakarta");
        // if (!$this->session->userdata('userid')) {
        //     redirect('login');
        // }
        $this->load->model('m_applicant_registration', 'User_model');
        $this->load->library('form_validation');
        // Load library untuk mengirim email
        $this->load->library('email');

        // Load helper URL untuk fungsi redirect dan URL lainnya
        $this->load->helper('url');
    }



    // Generate CSRF Hash
    private function generateCsrfHash()
    {
        return bin2hex(random_bytes(32)); // Menghasilkan hash acak
    }

    // Method untuk pengecekan token CSRF untuk POST
    private function check_csrf_for_post()
    {
        $csrf_token = $this->input->post('csrf_token'); // Ambil token dari request

        if (!$this->checkCsrfToken($csrf_token)) {
            // Jika token tidak valid, kembalikan respon error
            echo json_encode(array('error' => 'Invalid CSRF Token'));
            exit; // Stop eksekusi
        }
    }

    // Cek token CSRF
    private function checkCsrfToken($token)
    {
        return $token === $this->session->userdata('csrf_hash');
    }


    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('form-registration');
        }
        $data['title'] = 'Register';
        $this->load->view('applicant_registration/register', $data);
    }

    public function register_action()
    {
        // Aturan validasi
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('nik_ktp', 'NIK KTP', 'required');

        // Memeriksa apakah email sudah ada
        if ($this->User_model->is_email_exists($this->input->post('email'))) {
            $this->form_validation->set_message('is_unique', 'Email sudah terdaftar.');
            $this->form_validation->set_rules('email', 'Email', 'is_unique[tblUtlUsers.email]');
        }

        // Memeriksa apakah NIK KTP sudah ada
        if ($this->User_model->is_nik_exists($this->input->post('nik_ktp'))) {
            $this->form_validation->set_message('is_unique', 'NIK KTP sudah terdaftar.');
            $this->form_validation->set_rules('nik_ktp', 'NIK KTP', 'is_unique[tblUtlUsers.nik_ktp]');
        }

        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('applicant_registration/register'); // Kembali ke form jika validasi gagal
        } else {
            // Ambil data dari form
            $data = array(
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'nik_ktp' => $this->input->post('nik_ktp'),
                'fullname' => $this->input->post('fullname'),
                'is_verified' => 0, // Nilai default
                'verification_code' => bin2hex(random_bytes(16)), // Buat kode verifikasi acak
                'created_at' => date('Y-m-d H:i:s'), // Waktu sekarang
                'updated_at' => NULL, // Waktu sekarang
                'user_type' => 3,
            );

            // Simpan data ke database
            $this->User_model->insert_user($data);
            // Kirim email verifikasi
            $this->_send_verification_email($data['email'], $data['verification_code'], $data['fullname']);

            $this->session->set_flashdata('success', 'Registrasi berhasil! Silahkan cek email Anda untuk verifikasi.');
            redirect('login'); // Redirect ke halaman login setelah sukses
        }
    }

    private function _send_verification_email($email, $verification_code, $fullname)
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'warkaman071@gmail.com', // Ganti dengan email Anda
            'smtp_pass' => 'pmqrnsxvugjgaauo', // Ganti dengan password email Anda
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );

        $this->email->initialize($config);
        $this->email->set_newline("\r\n");

        $this->email->from('recruitment@psg.co.id', 'PSG Rekrutmen'); // Ganti dengan nama aplikasi Anda
        $this->email->to($email);
        $this->email->subject('Verifikasi Akun Anda');

        $verification_link = base_url() . "verify/" . $verification_code;
        // Subject Email
        $subject = 'Verifikasi Email - PSG Rekrutmen';

        // Template Email HTML
        $message = '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Email Verifikasi PSG Rekrutmen</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f4f4f4;
                            margin: 0;
                            padding: 0;
                            color: #333;
                        }
                        .email-container {
                            max-width: 600px;
                            margin: 0 auto;
                            background-color: #ffffff;
                            border: 1px solid #dddddd;
                            padding: 20px;
                        }
                        .email-header {
                            text-align: center;
                            background-color: #0044cc;
                            padding: 10px;
                            color: white;
                        }
                        .email-header h1 {
                            margin: 0;
                            font-size: 24px;
                        }
                        .email-content {
                            padding: 20px;
                        }
                        .email-content h2 {
                            font-size: 20px;
                            color: #333;
                        }
                        .email-content p {
                            font-size: 16px;
                            line-height: 1.6;
                            color: #555;
                        }
                        .btn {
                            display: inline-block;
                            padding: 10px 20px;
                            margin: 20px 0;
                            background-color: #28a745;
                            color: #ffffff;
                            text-decoration: none;
                            border-radius: 5px;
                        }
                        .btn:hover {
                            background-color: #218838;
                        }
                        .email-footer {
                            text-align: center;
                            padding: 10px;
                            background-color: #f4f4f4;
                            color: #777;
                            font-size: 12px;
                        }
                        .email-footer p {
                            margin: 5px 0;
                        }
                    </style>
                </head>
                <body>
                    <div class="email-container">
                        <!-- Email Header -->
                        <div class="email-header">
                            <h1>PSG Rekrutmen</h1>
                        </div>

                        <!-- Email Content -->
                        <div class="email-content">
                            <h2>Halo, ' . $fullname . '!</h2>
                            <p>
                                Terima kasih telah mendaftar di <strong>PSG Rekrutmen</strong>. Kami sangat senang Anda bergabung bersama kami.
                                Untuk melanjutkan proses pendaftaran, silakan verifikasi alamat email Anda dengan mengklik tautan di bawah ini:
                            </p>
                            <p style="text-align: center;">
                                <a href="https://web-api.psg.co.id/rekrutmen/verify-email/' . $verification_code . '" class="btn" style="color:white">Verifikasi Akun Saya</a>
                            </p>
                            <p>
                                Jika Anda mengalami kesulitan saat mengklik tautan di atas, salin dan tempel URL berikut ke browser Anda:
                                <br>
                                <a href="https://web-api.psg.co.id/rekrutmen/verify-email/' . $verification_code . '" style="color: #0044cc;">https://web-api.psg.co.id/rekrutmen/verify-email/' . $verification_code . '</a>
                            </p>
                            <p>
                                Setelah email Anda diverifikasi, Anda dapat masuk ke akun PSG Rekrutmen dan melanjutkan proses lamaran pekerjaan.
                            </p>
                            <p>
                                Jika Anda tidak pernah mendaftar di PSG Rekrutmen, abaikan email ini.
                            </p>
                        </div>

                        <!-- Email Footer -->
                        <div class="email-footer">
                            <p>Butuh bantuan? Hubungi kami di <a href="mailto:recruitment@psg.co.id">recruitment@psg.co.id</a>.</p>
                            <p>&copy; 2024 PSG Rekrutmen. All rights reserved.</p>
                        </div>
                    </div>
                </body>
                </html>
                ';



        $this->email->message($message);

        if ($this->email->send()) {
            return true;
        } else {
            show_error($this->email->print_debugger());
        }
    }

    public function verify_email($verification_code)
    {
        $user = $this->User_model->get_user_by_verification_code($verification_code);

        if ($user) {
            // Jika kode verifikasi valid, set is_verified menjadi 1
            $this->User_model->verify_user($user['email']);
            $this->session->set_flashdata('success', 'Email berhasil diverifikasi. Silakan login.');
            redirect('login');
        } else {
            $this->session->set_flashdata('error', 'Kode verifikasi tidak valid atau sudah digunakan.');
            redirect('login');
        }
    }


    public function login()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('form-registration');
        }
        $data['title'] = 'Login';
        $this->load->view('applicant_registration/login', $data);
    }

    // Halaman login
    public function checkLogin()
    {


        $email = $this->input->post('email');
        $checkUserType = $this->User_model->check_user_type($email);
        if ($checkUserType && $checkUserType['tipe_user'] == '1') {
            $this->login_user2();
        } else {

            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == false) {
                $this->load->view('login_view');
            } else {
                $email = $this->input->post('email');
                $password = $this->input->post('password');

                $user = $this->User_model->check_login($email);

                if ($user) {
                    // Cek apakah user sudah terverifikasi
                    if ($user['is_verified'] == 1) {
                        // Cek apakah password benar
                        if (password_verify($password, $user['password'])) {
                            $userdata = [
                                'user_id' => $user['id'],
                                'fullname' => $user['fullname'],
                                'email' => $user['email'],
                                'ktp' => $user['nik_ktp'],
                                'logged_in' => true
                            ];
                            $this->session->set_userdata($userdata);
                            redirect('form-registration');
                        } else {
                            $this->session->set_flashdata('error', 'Password salah!');
                            redirect('login');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Akun belum terverifikasi!');
                        redirect('login');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Akun tidak ditemukan!');
                    redirect('login');
                }
            }
        } // end if --



    }

    // Logout
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login-act');
    }

    // Halaman Lupa Password
    public function forgot_password()
    {
        $data['title'] = 'Forgot Password';
        $this->load->view('applicant_registration/forgot_password', $data);
    }
    // Proses Lupa Password
    public function forgot_password_action()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('applicant_registration/forgot_password');
        } else {
            $email = $this->input->post('email');
            $user = $this->User_model->get_user_by_email($email);

            if ($user) {
                // Buat token reset password
                $reset_token = bin2hex(random_bytes(16));

                // Simpan token ke database
                $this->User_model->set_reset_token($email, $reset_token);

                // Kirim email untuk reset password
                $this->send_reset_password_email($email, $reset_token);

                $this->session->set_flashdata('success', 'Email reset password telah dikirim ke email Anda.');
                redirect('login');
            } else {
                $this->session->set_flashdata('error', 'Email tidak ditemukan.');
                redirect('applicant_registration/forgot_password');
            }
        }
    }

    // Halaman Reset Password
    public function reset_password($token)
    {
        $data['title'] = 'Reset Password';
        $user = $this->User_model->get_user_by_token($token);
        if ($user) {
            $data['token'] = $token;
            $this->load->view('applicant_registration/reset_password', $data);
        } else {
            $this->session->set_flashdata('error', 'Token tidak valid atau sudah kadaluarsa.');
            redirect('login');
        }
    }

    // Proses Reset Password
    public function reset_password_action()
    {
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        $token = $this->input->post('token');
        $user = $this->User_model->get_user_by_token($token);

        if ($this->form_validation->run() == FALSE) {
            $data['token'] = $token;
            $this->load->view('applicant_registration/reset_password', $data);
        } else {
            // Update password
            $new_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $this->User_model->update_password($user['email'], $new_password);
            $this->User_model->clear_reset_token($user['email']);

            $this->session->set_flashdata('success', 'Password berhasil direset.');
            redirect('login');
        }
    }

    // Kirim email untuk reset password
    private function send_reset_password_email($email, $token)
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com', // Atau gunakan smtp.gmail.com
            'smtp_port' => 465,
            'smtp_user' => 'warkaman071@gmail.com', // Ganti dengan email Anda
            'smtp_pass' => 'pmqrnsxvugjgaauo', // Ganti dengan App Password
            // 'smtp_pass' => 'ofbcrghgoglqmmrq', // Ganti dengan App Password
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n",
            'wordwrap'  => TRUE
        );

        $this->email->initialize($config);

        $subject = 'Reset Password - PSG Rekrutmen';
        $message = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Reset Password</title>
        </head>
        <body>
            <p>Halo,</p>
            <p>Anda menerima email ini karena ada permintaan untuk mereset password Anda pada aplikasi PSG Rekrutmen. Silakan klik tautan di bawah ini untuk mereset password Anda:</p>
            <p><a href="https://web-api.psg.co.id/rekrutmen/reset-password/' . $token . '">Reset Password</a></p>
            <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
            <p>&copy; 2024 PSG Rekrutmen</p>
        </body>
        </html>
        ';

        $this->email->from('recruitment@psg.co.id', 'PSG Rekrutmen');
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }

    public function form_registration()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        // die;

        $check = $this->User_model->check_data(trim($this->session->userdata('ktp')));
        // print_r($check);
        // die;
        if ($check && trim($this->session->userdata('ktp')) != '1671135607980003') {
            redirect('success');
        }
        $data['nmlengkap']       = $this->session->userdata('fullname');
        $data['ktp']             = $this->session->userdata('ktp');
        $data['email']           = $this->session->userdata('email');

        $data['title']           = 'Form Registasi';
        $data['_getprovinsi']    = $this->m_register->getProvinsi();
        $data['_getSuku']        = $this->m_register->getSuku();
        $data['_getAgama']       = $this->m_register->getAgama();
        $data['_getJurusan']     = $this->m_register->getJurusan();
        $data['_getPendidikan']  = $this->m_register->getPendidikan();
        $data['_getStatusKawin'] = $this->m_register->getStatusKawin();
        $data['csrfName'] = 'csrf_token'; // Nama token
        $data['csrfHash'] = $this->generateCsrfHash(); // Generate hash
        $this->session->set_userdata('csrf_hash', $data['csrfHash']);
        if ($data['nmlengkap'] == 'KIKI IRVANSYAH#') {
            # code...
            $this->load->view('applicant_registration/form_registration_dev', $data);
            return;
        }
        $this->load->view('applicant_registration/form_registration', $data);
    }

    function getkabupaten()
    {
        $this->check_csrf_for_post(); // Panggil pemeriksaan CSRF

        $this->load->model('m_register');
        $prov = $this->input->post('idprov');
        $data = $this->m_register->getKabupaten($prov);
        echo json_encode(array('data' => $data->result_array(), 'err' => 0));
    }

    function getkecamatan()
    {
        $this->check_csrf_for_post(); // Panggil pemeriksaan CSRF

        $this->load->model('m_register');
        $prov = $this->input->post('idprov');
        $kab  = $this->input->post('idkab');
        $data = $this->m_register->getkecamatan($prov, $kab);
        echo json_encode(array('data' => $data->result_array(), 'err' => 0));
    }


    function submit_form()
    {
        // Check if the request is an AJAX request
        if (!$this->input->is_ajax_request()) {
            // Return an error response if it's not an AJAX request
            $response = [
                'status' => 'error',
                'message' => 'Invalid request method.',
            ];
            echo json_encode($response);
            return;
        }

        // rules for validation
        $this->_set_rules();

        if ($this->form_validation->run() == FALSE) {
            // Get all validation errors
            $validation_errors = validation_errors();
            $error_array = explode('<br>', $validation_errors);
            $error_count = count($error_array);

            // Prepare to show only 3 errors at a time
            $errors_to_show = array_slice($error_array, 0, 3); // Get the first 3 errors
            $error_message = implode('<br>', $errors_to_show);

            $response = [
                'status' => 'error',
                'message' => $error_message,
                'total_errors' => $error_count, // Send total errors count for front-end handling
            ];
            echo json_encode($response);
            return;
        }

        $confirm = $this->input->post('txtConfirm'); // ===== deklarasi Confrim Text
        $nama    = trim(strtoupper($this->input->post('txtNama'))); // ===== deklarasi Nama Pelamar
        $namaTK  = TRIM(preg_replace("/[^a-zA-Z]/", " ", $nama));

        // ===== cek KeadaanFisik
        if ($this->input->post('txtKeadaanFisik') === 'CACAT' || $this->input->post('txtKeadaanFisik') === 'cacat') {
            $cacatapa = strtoupper($this->input->post('txtCacatApa'));
        } else {
            $cacatapa = 'TIDAK ADA';
        }
        // ===== cek Penyakit
        if ($this->input->post('txtPernahPenyakit') === 'YA') {
            $penyakitapa = strtoupper($this->input->post('txtPenyakit'));
        } else {
            $penyakitapa = 'TIDAK ADA';
        }
        // ===== cek Tato
        if ($this->input->post('txtBertato') === 'YA') {
            $tatoDimana = strtoupper($this->input->post('txtTatoDimana'));
        } else {
            $tatoDimana = 'TIDAK ADA';
        }
        // ===== cek Kriminal
        if ($this->input->post('txtPernahKriminal') === 'YA') {
            $perkaraapa = strtoupper($this->input->post('txtKriminal'));
        } else {
            $perkaraapa = 'TIDAK ADA';
        }
        // ===== cek Jumlah Anak
        if ($this->input->post('txtJumlahAnak') === '') {
            $jumlahanak = '';
        } else {
            $jumlahanak = $this->input->post('txtJumlahAnak');
        }
        // ===== cek Jurusan
        if ($this->input->post('txtJurusan') == '') {
            $jurusan = '-';
        } else {
            $jurusan = strtoupper($this->input->post('txtJurusan'));
        }
        // ===== cek Vaksin
        $TanggalVaksin  = $this->input->post('txtTanggalVaksin');
        $TanggalVaksin2 = $this->input->post('txtTanggalVaksin2');
        $TanggalVaksin3 = $this->input->post('txtTanggalVaksin3');

        if ($this->input->post('txtVaksin') === 'SUDAH') {
            $Vaksin      = $this->input->post('txtVaksin');
            $JenisVaksin = strtoupper($this->input->post('txtJenisVaksin'));
            if ($TanggalVaksin != '') {
                $TanggalVaksin = date('Y-m-d', strtotime($TanggalVaksin));
            } else {
                $TanggalVaksin = NULL;
            }

            if ($TanggalVaksin2 != '') {
                $TanggalVaksin2 = date('Y-m-d', strtotime($TanggalVaksin2));
            } else {
                $TanggalVaksin2 = NULL;
            }

            if ($TanggalVaksin3 != '') {
                $TanggalVaksin3 = date('Y-m-d', strtotime($TanggalVaksin3));
            } else {
                $TanggalVaksin3 = NULL;
            }
        } else {
            $Vaksin         = 'BELUM';
            $JenisVaksin    = 'TIDAK ADA';
            $TanggalVaksin  = NULL;
            $TanggalVaksin2 = NULL;
            $TanggalVaksin3 = NULL;
        }

        $namaAnak  = $this->input->post('txtNamaAnak');
        $itungAnak = $this->cekAnak($namaAnak);
        $jmlAnak   = $this->input->post('txtJumlahAnak');

        if ($jmlAnak == "") {
            if (strtoupper($this->input->post('txtStatus')) == 'BUJANG' || strtoupper($this->input->post('txtStatus')) == 'GADIS') {
                $anak = 0;
            } elseif ($namaAnak == "") {
                $anak = 0;
            } elseif ($itungAnak > 0) {
                $anak = $itungAnak;
            } else {
                $anak = 0;
            }
        } elseif ($jmlAnak > 0) {
            if (strtoupper($this->input->post('txtStatus')) == 'BUJANG' || strtoupper($this->input->post('txtStatus')) == 'GADIS') {
                $anak = 0;
            } elseif ($namaAnak == "") {
                $anak = 0;
            } else {
                $anak = $itungAnak;
            }
        } else {
            $anak = $itungAnak;
        }

        $pasangan = $this->input->post('txtNamaPasangan');
        if (strtoupper($this->input->post('txtStatus')) == 'BUJANG' || strtoupper($this->input->post('txtStatus')) == 'GADIS' || $pasangan == '') {
            $tglPasangan = NULL;
        } else {
            $tglPasangan = date('Y-m-d', strtotime($this->input->post('txtTglLahirPasangan')));
        }

        if ($this->input->post('txtShcool') == "") {
            $univ = $this->input->post('txtUniv');
        } else {
            $univ = $this->input->post('txtShcool');
        }

        if ($this->input->post('txtNilai') == "") {
            $ipk = $this->input->post('txtIPK');
        } else {
            $ipk = $this->input->post('txtNilai');
        }

        if (strtoupper($this->input->post('txtPendidikan')) == 'TIDAK SEKOLAH') {
            $pendidikan = "NaN";
        } else {
            $pendidikan = strtoupper($this->input->post('txtPendidikan'));
        }
        $pisah          = explode(',', $this->input->post('txtSubPemborong'));
        $subpemborong   = trim($pisah[0]);
        $idsubpemborong = trim($pisah[1]);

        $agamaValue            = $this->input->post('txtAgama');
        list($IDAgama, $Agama) = explode(',', $agamaValue);

        $info = array(
            'CVNama'              => $this->input->post('txtPerusahaan'),
            'Pemborong'           => $this->input->post('txtPemborong'),
            'IDPemborong'         => $this->input->post('txtIDPemborong'),
            'SubPemborong'        => $subpemborong,
            'IDSubPemborong'      => $idsubpemborong,
            'Nama'                => str_replace("'", "`", trim(strtoupper($this->input->post('txtNama')))),
            'Tgl_Lahir'           => date('Y-m-d', strtotime($this->input->post('txtTanggalLahir'))),
            'Tempat_Lahir'        => str_replace("'", "`", strtoupper($this->input->post('txtTempatLahir'))),
            'NamaIbuKandung'      => strtoupper($this->input->post('txtNamaIbu')),
            'BeratBadan'          => $this->input->post('txtBeratBadan'),
            'TinggiBadan'         => $this->input->post('txtTinggiBadan'),
            'IDAgama'             => $IDAgama,
            'Agama'               => $Agama,
            'Suku'                => strtoupper($this->input->post('txtSuku')),
            'Jenis_Kelamin'       => strtoupper($this->input->post('txtJekel')),
            'Pendidikan'          => $pendidikan,
            'Jurusan'             => $jurusan,
            'Universitas'         => $univ,
            'IPK'                 => $ipk,
            'Status_Personal'     => strtoupper($this->input->post('txtStatus')),
            'No_Ktp'              => $this->input->post('txtNoKTP'),
            'No_KK'               => $this->input->post('txtNoKK'),
            'Alamat_KTP'          => strtoupper($this->input->post('txtAlamatKTP')),
            'Alamat'              => strtoupper($this->input->post('txtAlamat')),
            'RT'                  => $this->input->post('txtRT'),
            'RW'                  => $this->input->post('txtRW'),
            'TinggalDengan'       => $this->input->post('txtTinggalDengan'),
            'HubunganDenganTK'    => $this->input->post('txtHubungan'),
            'NoHP'                => $this->input->post('txtNoPonsel'),
            'Daerah_Asal'         => strtoupper($this->input->post('txtDaerahAsal')),
            'PernahKerja'         => strtoupper($this->input->post('txtPernahRSUP')),
            'KerjaDi'             => strtoupper($this->input->post('txtBagian')),
            'Kriminal'            => $this->input->post('txtPernahKriminal'),
            'PerkaraApa'          => $perkaraapa,
            'JumlahAnak'          => $anak,
            'NamaSuamiIstri'      => str_replace("'", "`", strtoupper($this->input->post('txtNamaPasangan'))),
            'TglLahirSuamiIstri'  => $tglPasangan,
            'PekerjaanSuamiIstri' => strtoupper($this->input->post('txtPekerjaanPasangan')),
            'AlamatSuamiIstri'    => strtoupper($this->input->post('txtAlamatPasangan')),
            'NamaBapak'           => str_replace("'", "`", strtoupper($this->input->post('txtNamaBapak'))),
            'ProfesiOrangTua'     => strtoupper($this->input->post('txtPekerjaanOrtu')),
            'JumlahSaudara'       => $this->input->post('txtJumlahSaudara'),
            'AnakKe'              => $this->input->post('txtAnakKe'),
            'BahasaDaerah'        => strtoupper($this->input->post('txtBahasaDaerah')),
            'TahunMasuk'          => $this->input->post('txtTahunMasuk'),
            'TahunLulus'          => $this->input->post('txtTahunLulus'),
            'Hobby'               => strtoupper($this->input->post('txtHobby')),
            'KegiatanEkstra'      => $this->input->post('txtKegiatanEkstra'),
            'KegiatanOrganisasi'  => $this->input->post('txtOrgnanisasi'),
            'KeadaanFisik'        => $this->input->post('txtKeadaanFisik'),
            'CacatApa'            => $cacatapa,
            'PernahIdapPenyakit'  => $this->input->post('txtPernahPenyakit'),
            'PenyakitApa'         => $penyakitapa,
            'PengalamanKerja'     => $this->input->post('txtPengalamanKerja'),
            'Keahlian'            => $this->input->post('txtKeahlian'),
            'PernahKerjaDiSambu'  => $this->input->post('txtPernahRSUP'),
            'KerjadiBagian'       => strtoupper($this->input->post('txtBagian')),
            'Bertato'             => $this->input->post('txtBertato'),
            'TatoDimana'          => $tatoDimana,
            'Bertindik'           => $this->input->post('txtBertindik'),
            'SediaPotongRambut'   => $this->input->post('txtRambutPendek'),
            'Sediadiberhentikan'  => $this->input->post('txtBerhentikan'),
            'AccountFacebook'     => $this->input->post('txtFacebook'),
            'AccountTwitter'      => $this->input->post('txtTwitter'),
            'Account_email'       => $this->input->post('txtgmail'),
            'CreatedBy'           => strtoupper($this->session->userdata('username')),
            'CreatedDate'         => date('Y-m-d H:i:s'),
            'InputOnline'         => 1,
            'RegisteredBy'        => strtoupper($this->session->userdata('userid')),
            'RegisteredDate'      => date('Y-m-d H:i:s'),
            'ProvinsiID'          => $this->input->post('txtProvinsi'),
            'KabKotaID'           => $this->input->post('txtKabupaten'),
            'KecamatanID'         => $this->input->post('txtKecamatan'),
            'Kerabat_Nama'        => str_replace("'", "`", $this->input->post('txtkerabatterdekat')),
            'Kerabat_Telepon'     => $this->input->post('txtnohpkerabat'),
            'Kerabat_Hubungan'    => $this->input->post('txthubungan'),
            'Kerabat_Alamat'      => $this->input->post('txtAlamatKerabat'),
            'AhliWaris_Nama'      => str_replace("'", "`", $this->input->post('txtAhliWaris')),
            'AhliWaris_Jekel'     => $this->input->post('txtJekelAhliWaris'),
            'AhliWaris_Hubungan'  => $this->input->post('txtHubunganAhliWaris'),
            'AhliWaris_NoHP'      => $this->input->post('txtnohpkerabatAhliWaris'),
            'AhliWaris_Alamat'    => $this->input->post('txtAlamatAhliWaris'),
            'Kelurahan'           => strtoupper($this->input->post('txtKelurahan')),
            'Vaksin'              => $Vaksin,
            'JenisVaksin'         => $JenisVaksin,
            'TanggalVaksin'       => $TanggalVaksin,
            'TanggalVaksin2'      => $TanggalVaksin2,
            'TanggalVaksin3'      => $TanggalVaksin3,
            'Umur'                => $this->input->post('txtUmur'),
            'input_mandiri'       => 1,
        );

        // Terapkan htmlspecialchars pada semua elemen array
        $info = array_map(function ($value) {
            return is_string($value) ? htmlspecialchars($value, ENT_QUOTES) : $value;
        }, $info);

        $adaKeluarga = $this->input->post('txtAdaKeluarga');
        if ($adaKeluarga == 'YA') {
            $jumkel = count($this->input->post('kelnama'));
        } else {
            $jumkel = 0;
        }
        $kelnama      = $this->input->post('kelnama');
        $kelbagian    = $this->input->post('kelbagian');
        $kelpemborong = $this->input->post('kelpemborong');
        $kelhubungan  = $this->input->post('kelhubungan');
        $kelalamat    = $this->input->post('kelalamat');

        $annama         = $this->input->post('txtNamaAnak');
        $antempatlahir  = $this->input->post('txtTempatLahirAnak');
        $antgllahir     = $this->input->post('txtTanggalLahirAnak');
        $anjeniskelamin = $this->input->post('txtJekelAnak');
        $analamat       = $this->input->post('txtAlamatAnak');

        $pemborong = strtoupper($this->input->post('txtPemborong'));
        $tglLahir  = TRIM(date('Y-m-d', strtotime($this->input->post('txtTanggalLahir'))));
        // $namaIbu                          = strtoupper($this->input->post('txtNamaIbu'));
        $namaIbu = TRIM(preg_replace("/[^a-zA-Z]/", " ", $this->input->post('txtNamaIbu')));
        // $namaAyah                         = strtoupper($this->input->post('txtNamaBapak'));
        $namaAyah = TRIM(preg_replace("/[^a-zA-Z]/", " ", $this->input->post('txtNamaBapak')));

        $noKTP             = trim($this->input->post('txtNoKTP'));

        if ($confirm == 0) {

            // 1. cek apakah user ada di list blacklist atau tidak
            $cek_black_list = $this->m_register->cekTK($namaTK, $namaIbu);;

            // 2. cek pelamar yang pernah bekerja/melamar dan dinyatakan TIDAK LULUS
            $cekScreen = $this->m_register->cekRegScreeningReject($tglLahir, $namaIbu, $namaAyah);

            // 3.  cek Pernah Masih Aktif sebagai karyawan atau tidak
            $cekTKAktif = $this->m_register->cekRegAktif($namaTK, $tglLahir, $namaIbu, $namaAyah);


            // 4.  cek masih dalam masa jeda (TanggalKeluarTemporary di pemborong yang sama) 
            $cekRegInTempSamePemborong = $this->m_register->cekRegInTempSamePemborong($tglLahir, $namaIbu, $namaAyah, $pemborong);

            // 5.  cek masih dalam masa jeda (TanggalKeluarTemporary di pemborong yang berbeda) 
            $cekRegInTempDiffPemborong = $this->m_register->cekRegInTempDiffPemborong($tglLahir, $namaIbu, $namaAyah, $pemborong);

            // 6. cek apakah tk sudah pernah melamar di pemborong ini ?
            $cekTKPem = $this->m_register->cekRegTKPem($namaTK, $pemborong, $tglLahir, $namaIbu, $namaAyah);

            // 7. Cek TK apakah sudah pernah melamar di pemborong lain ?
            //!! TODO: query cek tk ke pemborong lain
            $cekTK = $this->m_register->cekRegTK($namaTK, $pemborong, $tglLahir, $namaIbu, $namaAyah);

            // 8. Cek TK apakah sedang diblacklist 3 bulan karena pernah mendaftar tapi cancel sendiri
            $cekTKCancel = $this->m_register->cekBlacklistByCancel($noKTP);

            if ($cek_black_list) {
                $response = [
                    'status' => 'error',
                    'message' => 'Code 1, Maaf anda Tidak Bisa melanjutkan Pendaftaran',
                    'error_code' => '1',
                ];
                echo json_encode($response);
                return;
            }

            if ($cekScreen) {
                $response = [
                    'status' => 'error',
                    'message' => 'Code 2, Maaf anda Tidak Bisa elanjutkan Pendaftaran',
                    'error_code' => '2',
                ];
                echo json_encode($response);
                return;
            }

            if ($cekTKAktif) {
                $response = [
                    'status' => 'error',
                    'message' => 'Code 3 Maaf anda Tidak Bisa elanjutkan Pendaftaran',
                    'error_code' => '3',
                ];
                echo json_encode($response);
                return;
            }
            if ($cekRegInTempSamePemborong) {
                $response = [
                    'status' => 'error',
                    'message' => 'Code 4 Maaf anda Tidak Bisa elanjutkan Pendaftaran',
                    'error_code' => '4',
                ];
                echo json_encode($response);
                return;
            }
            if ($cekRegInTempDiffPemborong) {
                $response = [
                    'status' => 'error',
                    'message' => 'Code 5 Maaf anda Tidak Bisa elanjutkan Pendaftaran',
                    'error_code' => '5',
                ];
                echo json_encode($response);
                return;
            }

            if ($cekTKPem) {
                $response = [
                    'status' => 'error',
                    'message' => 'Code 6 Maaf anda Tidak Bisa elanjutkan Pendaftaran',
                    'error_code' => '6',
                ];
                echo json_encode($response);
                return;
            }

            if ($cekTK) {
                $response = [
                    'status' => 'error',
                    'message' => 'Code 7 Maaf anda Tidak Bisa Melanjutkan Pendaftaran',
                    'error_code' => '7',
                ];
                echo json_encode($response);
                return;
            }

            if ($cekTKCancel) {
                $response = [
                    'status' => 'error',
                    'message' => 'Code 8 Maaf anda Tidak Bisa Melanjutkan Pendaftaran',
                    'error_code' => '8',
                ];
                echo json_encode($response);
                return;
            }

            if ($cekTKPem == TRUE) {
                $response = [
                    'status' => 'error',
                    'message' => 'Code 8 Maaf anda Tidak Bisa Melanjutkan Pendaftaran',
                    'error_code' => '9',
                ];
                echo json_encode($response);
                return;
            } else {
                $this->load->model('m_register');
                $hdrID = $this->User_model->simpanTK($info);
                if ($hdrID != 0) {
                    // === Cek Data Anak, Jika Ada Disimpan
                    for ($i = 0; $i < $anak; $i++) {
                        if (is_array($annama) && array_key_exists($i, $annama)) {
                            $infoanak = array(
                                'HeaderID'     => $hdrID,
                                'HeaderIDTemp' => 0,
                                'Nama'         => str_replace("'", "`", strtoupper($annama[$i])),
                                'TempatLahir'  => strtoupper($antempatlahir[$i]),
                                'TglLahir'     => date('Y-m-d', strtotime($antgllahir[$i])),
                                'JenisKelamin' => strtoupper($anjeniskelamin[$i]),
                                'Alamat'       => strtoupper($analamat[$i]),
                                'CreatedBy'    => strtoupper($this->session->userdata('userid')),
                                'CreatedDate'  => date('Y-m-d H:i:s'),
                            );
                            if (!$annama[$i] == '') {
                                $this->simpan_dataanak($hdrID, 0, $annama[$i], $infoanak);
                            }
                        }
                    }
                    // === Cek Data Keluarga, Jika Ada Simpan
                    for ($i = 0; $i < $jumkel; $i++) {
                        $infokel = array(
                            'HeaderID'         => $hdrID,
                            'HeaderIDTemp'     => 0,
                            'Nama'             => str_replace("'", "`", strtoupper($kelnama[$i])),
                            'Departemen'       => strtoupper($kelbagian[$i]),
                            'Pemborong'        => strtoupper($kelpemborong[$i]),
                            'HubunganKeluarga' => strtoupper($kelhubungan[$i]),
                            'Alamat'           => strtoupper($kelalamat[$i]),
                        );
                        if (!$kelnama[$i] == '') {
                            $this->simpan_datakeluarga($hdrID, 0, $kelnama[$i], $infokel);
                        }
                    }

                    // Data riwayat pendidikan
                    $jml = count($this->input->post('txtTingkatanPendidikan'));

                    $tingkatPendidikan = $this->input->post('txtTingkatanPendidikan');
                    $namaSekolah       = $this->input->post('txtNmSekolahPendidikan');
                    $jurusanSekolah    = $this->input->post('txtJurusanPendidikan');
                    $tahunMasuk        = $this->input->post('txtThnMasukPendidikan');
                    $tahunKeluar       = $this->input->post('txtThnLulusPendidikan');
                    $kelulusan         = $this->input->post('txtLulusPendidikan');

                    for ($i = 0; $i < $jml; $i++) {
                        $riwayatPendidikan = array(
                            'HeaderID'    => $hdrID,
                            'Tingkat'     => $tingkatPendidikan[$i],
                            'Nama'        => $namaSekolah[$i],
                            'Jurusan'     => $jurusanSekolah[$i],
                            'TahunMasuk'  => $tahunMasuk[$i],
                            'TahunKeluar' => $tahunKeluar[$i],
                            'Lulus'       => $kelulusan[$i],
                        );

                        $this->simpan_info_pendidikan($riwayatPendidikan);
                    }
                    // Data Saudara Kandung
                    $jmlSaudara = count($this->input->post('txtNamaSaudara'));

                    $namaSaudara = $this->input->post('txtNamaSaudara');
                    $jenisKelamin       = $this->input->post('txtJekelSaudara');
                    $umurSaudara    = $this->input->post('txtUmurSaudara');
                    $pekerjaanSaudara        = $this->input->post('txtPekerjaanSaudara');
                    $perusahaanSaudara       = $this->input->post('txtPrusahaanSaudara');
                    $jabatanSaudara         = $this->input->post('txtJabatanSaudara');

                    for ($i = 0; $i < $jmlSaudara; $i++) {
                        $dataSaudara = array(
                            'HeaderID'    => $hdrID,
                            'Nama'        => $namaSaudara[$i],
                            'JenisKelamin'     => $jenisKelamin[$i],
                            'Umur'  => $umurSaudara[$i],
                            'Pekerjaan' => $pekerjaanSaudara[$i],
                            'Perusahaan'       => $perusahaanSaudara[$i],
                            'Jabatan'       => $jabatanSaudara[$i],
                        );

                        $this->simpan_info_saudara($dataSaudara);
                    }

                    $this->load->model('m_upload_berkas');
                    $berkas   = 'ktp';
                    // $url      = './dataupload/berkas/ktp';
                    $url = $_SERVER['DOCUMENT_ROOT'] . '/eqsd/rekrutmen/berkas/ktp/';
                    // eqsd\rekrutmen\berkas\ktp
                    $namafile = $hdrID . '_' . $berkas . '.pdf';
                    // $namafile = 'tes232323.pdf';

                    // Konfigurasi upload
                    $config['upload_path']    = $url;
                    $config['allowed_types']  = 'pdf';
                    $config['allow_scale_up'] = TRUE;
                    $config['overwrite']      = TRUE;
                    $config['file_name']      = $namafile;
                    $config['max_size']       = '5120';

                    if ($this->input->post('txtPerusahaan') == 'PT PULAU SAMBU') {

                        // Inisialisasi dan melakukan upload
                        $this->load->library('upload', $config);
                        if ($this->upload->do_upload('txtFileKTP')) {
                            $uploadData = $this->upload->data();

                            // $relativePath = $url . '/' . $uploadData['file_name'];
                            $pathBerkas = './dataupload/berkas/ktp/' . $uploadData['file_name'];

                            $dataBerkas = array(
                                'HeaderID' => $hdrID,
                                $berkas    => $pathBerkas,
                            );
                            $result     = $this->m_upload_berkas->insert_db_berkas($dataBerkas);

                            if ($result === 0) {
                                $response = [
                                    'status' => 'error',
                                    'message' => 'Gagal menyimpan data berkas. Berkas dengan HeaderID yang sama sudah ada !!',
                                    'error_code' => '10',
                                ];
                                echo json_encode($response);
                                return;
                            }
                        } else {
                            // $this->User_model->delete_data($hdrID);
                            $dataBerkas = array(
                                'HeaderID' => $hdrID,
                            );

                            $result     = $this->m_upload_berkas->insert_db_berkas($dataBerkas);
                            $error            = $this->upload->display_errors();
                            $response = [
                                'status' => 'error',
                                'message' => 'Gagal mengunggah berkas: ' . $error,
                                'error_code' => '10',
                            ];
                            echo json_encode($response);

                            return;
                        }
                    } else {
                        // Inisialisasi dan melakukan upload
                        $this->load->library('upload', $config);
                        if ($this->upload->do_upload('txtFileKTP')) {
                            $uploadData = $this->upload->data();

                            $relativePath = $url . '/' . $uploadData['file_name'];

                            $dataBerkas = array(
                                'HeaderID' => $hdrID,
                                $berkas    => $relativePath,
                            );
                            $result     = $this->m_upload_berkas->insert_db_berkas($dataBerkas);

                            if ($result === 0) {
                                $response = [
                                    'status' => 'error',
                                    'message' => 'Gagal menyimpan data berkas. Berkas dengan HeaderID yang sama sudah ada !!',
                                    'error_code' => '10',
                                ];
                                echo json_encode($response);
                                return;
                            }
                        } else {
                            $error            = $this->upload->display_errors();
                            $response = [
                                'status' => 'error',
                                'message' => $error,
                                'error_code' => '10',
                            ];
                            echo json_encode($response);
                            return;
                        }
                    }

                    $response = [
                        'status' => 'success',
                        'message' => 'Sukses menyimpan data',
                    ];
                    echo json_encode($response);
                    return;
                } else {
                    // Tambahkan logging untuk mengetahui penyebab kegagalan
                    log_message('error', 'Gagal menyimpan data. Info: ' . json_encode($info));

                    // Ambil error dari database jika ada
                    $error = $this->db->error();
                    if ($error['code'] != 0) {
                        log_message('error', 'Database Error: ' . json_encode($error));
                    }

                    $response = [
                        'status' => 'error',
                        'message' => 'Gagal menyimpan data, Hubungi HRD !!',
                        'error_code' => '9',
                        'db_error' => $error['message'] ?? 'Tidak ada error spesifik',
                    ];

                    echo json_encode($response);
                    return;
                } // end if
            } // end if
        } // end if confirm


        // $response = [
        //     'status' => 'success',
        //     'message' => 'Sukses menyimpan data',
        // ];
        // echo json_encode($response);
    }

    private function _set_rules()
    {
        // Atur aturan validasi
        $this->form_validation->set_rules('txtNama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('txtNoKTP', 'No KTP', 'required|trim|regex_match[/^\d{16}$/]');
        $this->form_validation->set_rules('txtNoKK', 'No KK', 'required|trim|regex_match[/^\d{16}$/]');
        $this->form_validation->set_rules('txtAlamatKTP', 'Alamat Sesuai KTP', 'required|trim');
        $this->form_validation->set_rules('txtAlamat', 'Alamat Sekarang', 'required|trim');
        $this->form_validation->set_rules('txtRT', 'RT', 'required|trim');
        $this->form_validation->set_rules('txtRW', 'RW', 'required|trim');
        $this->form_validation->set_rules('txtKelurahan', 'Kelurahan', 'required|trim');
        $this->form_validation->set_rules('txtTinggalDengan', 'Tinggal Dengan', 'required');
        $this->form_validation->set_rules('txtHubungan', 'Hubungan dengan Calon Pelamar', 'required');
        $this->form_validation->set_rules('txtNoPonsel', 'Nomor Ponsel', 'required|regex_match[/^[0-9]{10,13}$/]', [
            'regex_match' => 'Nomor ponsel harus terdiri dari 10-13 digit angka.'
        ]);

        // $this->_error_validate();

        $this->form_validation->set_rules('txtTempatLahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('txtTanggalLahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('txtUmur', 'Usia', 'required');
        $this->form_validation->set_rules('txtJekel', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('txtTinggiBadan', 'Tinggi Badan', 'numeric');
        $this->form_validation->set_rules('txtBeratBadan', 'Berat Badan', 'numeric');
        $this->form_validation->set_rules('txtSuku', 'Suku', 'required');

        // $this->_error_validate();

        $this->form_validation->set_rules('txtDaerahAsal', 'Daerah Asal', 'required');
        $this->form_validation->set_rules('txtProvinsi', 'Provinsi', 'required');
        $this->form_validation->set_rules('txtKabupaten', 'Kabupaten', 'required');
        $this->form_validation->set_rules('txtKecamatan', 'Kecamatan', 'required');
        $this->form_validation->set_rules('txtBahasaDaerah', 'Bahasa Daerah', 'trim');
        $this->form_validation->set_rules('txtAgama', 'Agama', 'required');
        $this->form_validation->set_rules('txtStatus', 'Status Perkawinan', 'required');
        $this->form_validation->set_rules('txtkerabatterdekat', 'Kerabat Terdekat', 'required');
        $this->form_validation->set_rules('txtnohpkerabat', 'Nomor HP. Kerabat', 'required|regex_match[/^[0-9]{10,13}$/]', [
            'regex_match' => 'Nomor hp kerabat harus terdiri dari 10-13 digit angka.'
        ]);
        $this->form_validation->set_rules('txthubungan', 'Hubungan dgn. Kerabat', 'required');
        $this->form_validation->set_rules('txtAlamatKerabat', 'Alamat Kerabat', 'trim');

        // $this->_error_validate();

        $this->form_validation->set_rules('txtNamaPasangan', 'Nama Suami/Istri', 'trim');
        $this->form_validation->set_rules('txtTglLahirPasangan', 'Tanggal Lahir Suami/Istri', 'trim');
        $this->form_validation->set_rules('txtPekerjaanPasangan', 'Pekerjaan Suami/Istri', 'trim');
        $this->form_validation->set_rules('txtAlamatPasangan', 'Alamat Suami/Istri', 'trim');
        $this->form_validation->set_rules('txtJumlahAnak', 'Jumlah Anak', 'trim');

        // Validasi untuk anak
        if ($this->input->post('txtJumlahAnak') > 0) {
            for ($i = 0; $i < $this->input->post('txtJumlahAnak'); $i++) {
                $this->form_validation->set_rules("txtNamaAnak[$i]", 'Nama Anak', 'trim');
                $this->form_validation->set_rules("txtTempatLahirAnak[$i]", 'Tempat Lahir Anak', 'trim');
                $this->form_validation->set_rules("txtTanggalLahirAnak[$i]", 'Tanggal Lahir Anak', 'trim');
                $this->form_validation->set_rules("txtJekelAnak[$i]", 'Jenis Kelamin Anak', 'trim');
                $this->form_validation->set_rules("txtAlamatAnak[$i]", 'Alamat Anak', 'trim');
            }
        }

        // $this->_error_validate();

        $this->form_validation->set_rules('txtNamaBapak', 'Nama Bapak Kandung', 'trim|required');
        $this->form_validation->set_rules('txtNamaIbu', 'Nama Ibu Kandung', 'trim|required');
        $this->form_validation->set_rules('txtPekerjaanOrtu', 'Pekerjaan Orang Tua', 'trim|required');
        $this->form_validation->set_rules('txtJumlahSaudara', 'Jumlah Saudara', 'trim|required');
        $this->form_validation->set_rules('txtAnakKe', 'Anak ke', 'trim|required|integer');

        // $this->_error_validate();

        // Set rules for validation
        $this->form_validation->set_rules('txtPendidikan', 'Pendidikan Terakhir', 'required');
        $this->form_validation->set_rules('txtShcool', 'Nama Sekolah', 'trim');
        $this->form_validation->set_rules('txtUniv', 'Nama Universitas', 'trim');

        // $this->form_validation->set_rules('txtShcool', 'Nama Sekolah', 'trim|callback_check_school_univ');
        // $this->form_validation->set_rules('txtUniv', 'Nama Universitas', 'trim|callback_check_school_univ');
        // $this->form_validation->set_rules('txtJurusan', 'Jurusan', 'required');
        $this->form_validation->set_rules('txtIjsTerakhir', 'Ijazah Terakhir', 'trim');


        // Validate each entry in the education table
        $count = $this->input->post('txtTingkatanPendidikan'); // Get the number of education entries
        for ($i = 0; $i < count($count); $i++) {
            $this->form_validation->set_rules("txtTingkatanPendidikan[$i]", 'Tingkatan Pendidikan ' . ($i + 1), 'required');
            $this->form_validation->set_rules("txtNmSekolahPendidikan[$i]", 'Nama Sekolah/Tempat ' . ($i + 1), 'required|trim');
            // $this->form_validation->set_rules("txtJurusanPendidikan[$i]", 'Jurusan ' . ($i + 1), 'required');
            $this->form_validation->set_rules("txtThnMasukPendidikan[$i]", 'Tahun Masuk ' . ($i + 1), 'required|exact_length[4]');
            $this->form_validation->set_rules("txtThnLulusPendidikan[$i]", 'Tahun Keluar ' . ($i + 1), 'required|exact_length[4]');
            $this->form_validation->set_rules("txtLulusPendidikan[$i]", 'Lulus ' . ($i + 1), 'required');
        }

        // $this->_error_validate();

        // Set rules for validation
        $this->form_validation->set_rules('txtPengalamanKerja', 'Pengalaman Kerja', 'trim');
        $this->form_validation->set_rules('txtKeahlian', 'Keahlian/Keterampilan', 'trim');
        $this->form_validation->set_rules('txtPernahRSUP', 'Pernah Kerja di SAMBU GROUP', 'required');
        $this->form_validation->set_rules('txtBagian', 'Bagian/Department', 'callback_check_bagian[txtPernahRSUP,YA]'); // Hanya diperlukan jika Pernah di SAMBU GROUP
        $this->form_validation->set_rules('txtAdaKeluarga', 'Ada Keluarga yang Bekerja di SAMBU GROUP', 'trim');

        // Validasi untuk tabel keluarga jika ada
        $countKeluarga = $this->input->post('kelnama'); // Ambil data nama keluarga
        if ($this->input->post('txtAdaKeluarga') == 'YA') {
            foreach ($countKeluarga as $index => $kelnama) {
                $this->form_validation->set_rules("kelnama[$index]", 'Nama Keluarga', 'required|trim');
                $this->form_validation->set_rules("kelbagian[$index]", 'Bagian Keluarga', 'required|trim');
                $this->form_validation->set_rules("kelpemborong[$index]", 'Pemborong Keluarga', 'required|trim');
                $this->form_validation->set_rules("kelalamat[$index]", 'Alamat Keluarga', 'required|trim');
            }
        }

        // $this->_error_validate();

        // 
        $this->form_validation->set_rules('txtHobby', 'Hobby/ Kegemaran', 'trim');
        $this->form_validation->set_rules('txtKegiatanEkstra', 'Kegiatan Ekstra', 'trim');
        $this->form_validation->set_rules('txtOrgnanisasi', 'Kegiatan Organisasi', 'trim');


        $this->form_validation->set_rules('txtKeadaanFisik', 'Keadaan Fisik', 'required');
        $this->form_validation->set_rules('txtCacatApa', 'Cacat apa', 'trim|callback_check_cacat'); // Callback untuk cacat

        $this->form_validation->set_rules('txtPernahPenyakit', 'Pernah Mengidap Penyakit', 'required');
        $this->form_validation->set_rules('txtPenyakit', 'Penyakit apa', 'trim|callback_check_penyakit'); // Callback untuk penyakit

        $this->form_validation->set_rules('txtPernahKriminal', 'Pernah Terlibat Kriminal', 'required');
        $this->form_validation->set_rules('txtKriminal', 'Tindakan Kriminal Apa', 'trim|callback_check_kriminal'); // Callback untuk kriminal

        $this->form_validation->set_rules('txtBertato', 'Apakah Bertato', 'required');
        $this->form_validation->set_rules('txtTatoDimana', 'Tato dibagian apa', 'trim|callback_check_tato'); // Callback untuk tato


        // $this->_error_validate();
        // Set validation rules
        $this->form_validation->set_rules('txtBertindik', 'Apakah Bertindik', 'required');
        $this->form_validation->set_rules('txtRambutPendek', 'Bersedia rambut pendek', 'required');
        $this->form_validation->set_rules('txtBerhentikan', 'Bersedia Diberhentikan', 'required');
        $this->form_validation->set_rules('txtVaksin', 'Apakah Sudah Vaksin', 'required');

        // Optional: Validate "Jenis Vaksin" only if the "txtVaksin" value is "SUDAH"
        if ($this->input->post('txtVaksin') == 'SUDAH') {
            $this->form_validation->set_rules('txtJenisVaksin', 'Jenis Vaksin', 'required');
            $this->form_validation->set_rules('txtTanggalVaksin', 'Vaksin 1', 'required');
        }

        // $this->_error_validate();
        // Set validation rules
        $this->form_validation->set_rules('txtAhliWaris', 'Nama Ahli Waris', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('txtJekelAhliWaris', 'Jenis Kelamin Ahli Waris', 'required');
        $this->form_validation->set_rules('txtAlamatAhliWaris', 'Alamat Ahli Waris', 'required|trim');
        $this->form_validation->set_rules('txtHubunganAhliWaris', 'Hubungan Ahli Waris', 'required|trim');
        $this->form_validation->set_rules('txtnohpkerabatAhliWaris', 'Nomor HP Ahli Waris', 'required|trim');

        // $this->_error_validate();
    }

    private function _error_validate()
    {
        if ($this->form_validation->run() == FALSE) {
            $response = [
                'status' => 'error',
                'message' => validation_errors(),
            ];
            echo json_encode($response);
            return;
        }
    }

    public function check_school_univ()
    {
        $school = $this->input->post('txtShcool');
        $univ = $this->input->post('txtUniv');

        // Jika Nama Sekolah diisi tapi Nama Universitas kosong
        if (!empty($school) && empty($univ)) {
            $this->form_validation->set_message('check_school_univ', 'Nama Universitas diperlukan jika Nama Sekolah diisi.');
            return FALSE;
        }

        // Jika Nama Universitas diisi tapi Nama Sekolah kosong
        if (!empty($univ) && empty($school)) {
            $this->form_validation->set_message('check_school_univ', 'Nama Sekolah diperlukan jika Nama Universitas diisi.');
            return FALSE;
        }

        // Jika kedua field kosong, tidak ada yang perlu divalidasi
        return TRUE;
    }

    public function check_bagian($bagian)
    {
        $pernahRSUP = $this->input->post('txtPernahRSUP');

        // Periksa apakah Pernah Kerja di SAMBU GROUP diisi dengan "YANG"
        if ($pernahRSUP === 'YA' && empty($bagian)) {
            // Pesan kesalahan yang sesuai
            $this->form_validation->set_message('check_bagian', 'Bagian/Department diperlukan jika Anda pernah kerja di SAMBU GROUP.');
            return FALSE; // Validasi gagal
        }

        return TRUE; // Validasi berhasil
    }

    public function check_cacat($cacat)
    {
        $keadaanFisik = $this->input->post('txtKeadaanFisik');

        if ($keadaanFisik === 'CACAT' && empty($cacat)) {
            $this->form_validation->set_message('check_cacat', 'Cacat apa diperlukan jika keadaan fisik adalah cacat.');
            return FALSE;
        }

        return TRUE;
    }

    public function check_penyakit($penyakit)
    {
        $pernahPenyakit = $this->input->post('txtPernahPenyakit');

        if ($pernahPenyakit === 'YA' && empty($penyakit)) {
            $this->form_validation->set_message('check_penyakit', 'Penyakit apa diperlukan jika Anda pernah mengidap penyakit.');
            return FALSE;
        }

        return TRUE;
    }

    public function check_kriminal($kriminal)
    {
        $pernahKriminal = $this->input->post('txtPernahKriminal');

        if ($pernahKriminal === 'YA' && empty($kriminal)) {
            $this->form_validation->set_message('check_kriminal', 'Tindakan kriminal apa diperlukan jika Anda pernah terlibat kriminal.');
            return FALSE;
        }

        return TRUE;
    }

    public function check_tato($tato)
    {
        $bertato = $this->input->post('txtBertato');

        if ($bertato === 'YA' && empty($tato)) {
            $this->form_validation->set_message('check_tato', 'Tato dibagian apa diperlukan jika Anda bertato.');
            return FALSE;
        }

        return TRUE;
    }

    function cekAnak($namaAnak)
    {
        $jml_isi = 0;
        for ($a = 0; $a < count($namaAnak); $a++) {
            if ($namaAnak[$a] != NULL) {
                $jml_isi++;
            }
        }
        return $jml_isi;
    }

    function simpan_datakeluarga($hdrID, $hdridtemp, $kelnama, $infokel)
    {
        $detailid = $this->m_register->cek_datakeluarga($hdrID, $hdridtemp, $kelnama);

        if ($detailid == 0) {
            $this->m_register->simpan_datakeluarga($infokel);
        } else {
            $this->m_register->update_datakeluarga($detailid, $infokel);
        }
    }

    function simpan_dataanak($hdrID, $hdridtemp, $anaknama, $infoanak)
    {
        $detailid = $this->m_register->cek_dataanak($hdrID, $hdridtemp, $anaknama);

        if ($detailid == 0) {
            $this->m_register->simpan_dataanak($infoanak);
        } else {
            $this->m_register->update_dataanak($detailid, $infoanak);
        }
    }

    function simpan_info_pendidikan($data)
    {

        $this->m_register->simpan_datapendidikan($data);
    }

    function simpan_info_saudara($data)
    {

        $this->m_register->simpan_info_saudara($data);
    }

    function success()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $data['nmlengkap'] = $this->session->userdata('fullname');
        $data['title']           = 'Success';
        $this->load->view('applicant_registration/success', $data);
    }

    // ################################################################### Login Aplikasi Rekrutmen

    function cekLogin2($userID, $passID)
    {
        $this->load->model('m_login');
        $log    = $this->m_login->log_in2($userID);
        $cek    = $this->m_login->cekpass2($userID, $passID);
        if ($log->num_rows() > 0) {
            $row = $log->row();
            if ($row->InActive === 1) {
                redirect('C_onelogin_verifikasi');
                // print_r('test');
                // die;
                exit();
                return 1;
            } else if ($cek === true) {
                $this->session->set_userdata('userid', $userID);
                $this->session->set_userdata('teamscreen', $row->AnggotaScreening);
                $this->session->set_userdata('username', $row->NamaUser);
                $this->session->set_userdata('nik', $row->NIK);  //mengambil field UserName untuk disimpan di session
                $this->session->set_userdata('groupuser', $row->GroupID);
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

    function login_user2()
    {
        // require_once(APPPATH . 'controllers/Applicant_registration.php');
        // $app_regis = new Applicant_registration();

        // $userID = $this->input->post('txtUserID');
        // $passID = md5(sha1($this->input->post('txtPass')));

        $userID = $this->input->post('email');
        $passID = md5(sha1($this->input->post('password')));

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
            }
        }
    }
}

/* End of file Applicant registration.php */
/* Location: ./application/controllers/Applicant registration.php */