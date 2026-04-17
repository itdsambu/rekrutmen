<?php

/* 
 * Author by Kiki Irfansyah
 */

class M_applicant_registration extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Fungsi untuk menyimpan user baru
    public function insert_user($data)
    {
        return $this->db->insert('tblUtlUsers', $data);
    }

    // Fungsi untuk memeriksa apakah email sudah terdaftar
    public function is_email_exists($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('tblUtlUsers');

        return $query->num_rows() > 0; // Mengembalikan true jika email sudah ada
    }

    // Fungsi untuk memeriksa apakah NIK KTP sudah terdaftar
    public function is_nik_exists($nik_ktp)
    {
        $this->db->where('nik_ktp', $nik_ktp);
        $query = $this->db->get('tblUtlUsers');

        return $query->num_rows() > 0; // Mengembalikan true jika NIK KTP sudah ada
    }

    // Fungsi untuk memeriksa apakah email ada dan mengambil data user
    public function check_login($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('tblUtlUsers'); // Pastikan nama tabel sesuai dengan database

        if ($query->num_rows() == 1) {
            return $query->row_array(); // Mengembalikan data user
        } else {
            return false; // Jika user tidak ditemukan
        }
    }

    // Fungsi untuk memeriksa apakah user sudah terverifikasi
    public function is_verified($email)
    {
        $this->db->select('is_verified');
        $this->db->where('email', $email);
        $query = $this->db->get('tblUtlUsers');

        if ($query->num_rows() == 1) {
            return $query->row()->is_verified;
        } else {
            return false;
        }
    }

    public function get_user_by_verification_code($verification_code)
    {
        $this->db->where('verification_code', $verification_code);
        return $this->db->get('tblUtlUsers')->row_array();
    }

    public function verify_user($email)
    {
        $this->db->set('is_verified', 1);
        $this->db->where('email', $email);
        return $this->db->update('tblUtlUsers');
    }

    public function get_user_by_email($email)
    {
        return $this->db->get_where('tblUtlUsers', array('email' => $email))->row_array();
    }

    public function set_reset_token($email, $token)
    {
        $data = array(
            'reset_token' => $token,
            'reset_token_created_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('email', $email);
        $this->db->update('tblUtlUsers', $data);
    }

    public function get_user_by_token($token)
    {
        $this->db->where('reset_token', $token);
        $this->db->where('reset_token_created_at >=', date('Y-m-d H:i:s', strtotime('-1 hour'))); // Token valid 1 jam
        return $this->db->get('tblUtlUsers')->row_array();
    }

    public function update_password($email, $new_password)
    {
        $data = array(
            'password' => $new_password,
            'reset_token' => NULL,
            'reset_token_created_at' => NULL
        );
        $this->db->where('email', $email);
        $this->db->update('tblUtlUsers', $data);
    }

    public function clear_reset_token($email)
    {
        $data = array(
            'reset_token' => NULL,
            'reset_token_created_at' => NULL
        );
        $this->db->where('email', $email);
        $this->db->update('tblUtlUsers', $data);
    }

    function simpanTK($info)
    {
        // $this->db->trans_start();
        // $this->db->insert('tblTrnCalonTenagaKerja', $info);
        // $hdrID = $this->db->insert_id();
        // $this->db->trans_complete();

        // // Memeriksa apakah transaksi berhasil
        // if ($this->db->trans_status() === FALSE) {
        //     return 0; // Jika gagal, kembalikan 0
        // }

        // return $hdrID; // Jika berhasil, kembalikan hdrID


        $this->db->trans_start();
        $this->db->insert('tblTrnCalonTenagaKerja', $info);

        // Log error jika ada
        $error = $this->db->error();
        if (!empty($error['message'])) {
            log_message('error', 'Insert error: ' . print_r($error, true));
        }

        $hdrID = $this->db->insert_id();
        $this->db->trans_complete();

        // Log isi $info untuk pengecekan
        log_message('debug', 'Insert data: ' . print_r($info, true));

        if ($this->db->trans_status() === FALSE) {
            return 0;
        }

        return $hdrID;
    }

    public function check_data($ktp)
    {
        $ktp = trim($ktp);

        // Cek apakah data dengan No_Ktp ada
        $this->db->where('No_Ktp', $ktp);
        $this->db->order_by('HeaderID', 'DESC');
        $this->db->limit(1);
        $cek_ktp = $this->db->get('tblTrnCalonTenagaKerja');

        if ($cek_ktp->num_rows() > 0) {
            // // Cek apakah RegisteredDate <= 3 bulan yang lalu
            $cek_tanggal = $this->db->query("
                WITH T1 AS (
                    SELECT TOP 1 *
                    FROM tblTrnCalonTenagaKerja
                    WHERE No_Ktp = '$ktp'
                    ORDER BY HeaderID DESC
                )
                SELECT * FROM T1
                WHERE No_Ktp = '$ktp'
                AND RegisteredDate <= DATEADD(MONTH, -3, GETDATE())
            ")->result();
            // print_r($cek_tanggal);
            // die;
            if (empty($cek_tanggal)) {
                return false;
            } else {
                return true;
            }
        } else {
            // return 'c';
            return false;
        }
    }

    public function delete_data($id)
    {

        $this->db->trans_start();
        $this->db->where('HeaderID', $id);
        $success = $this->db->delete('tblTrnCalonTenagaKerja');
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE || !$success) {
            // Jika gagal, kembalikan pesan kesalahan
            return false;
        } else {
            // Jika berhasil, kembalikan pesan sukses
            return true;
        }
    }

    public function check_user_type($email)
    {
        $this->db->where('LoginID', $email);
        $query =  $this->db->get('vw_checkUserType')->row_array();
        if ($query) {
            return $query; // data ditemukan, kembalikan datanya
        } else {
            return false;  // data tidak ditemukan
        }
    }
}


/* End of file M_applicant_registration.php */
/* Location: ./application/controllers/M_applicant_registration.php */