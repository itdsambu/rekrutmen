<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : Ismo
 */

class M_login extends CI_Model
{

    private $table_name = 'vwUtlUserLogin';
    private $username = 'LoginID';
    private $password = 'LoginPassword';

    function __construct()
    {
        parent::__construct();
    }

    function log_in($userID)
    {
        $this->db->where($this->username, $userID);
        echo $this->db->last_query();
        return $this->db->get('vwUtlUserLogin');
    }

    function cekpass($userID, $passID)
    {
        $this->db->where($this->username, $userID);
        $this->db->where($this->password, $passID);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function log_in2($userID)
    {
        $this->db->where($this->username, $userID);
        // echo $this->db->last_query();
        return $this->db->get('vwUtlUserLogin');
    }

    function cekpass2($userID, $passID)
    {
        $this->db->where($this->username, $userID);
        $this->db->where($this->password, $passID);
        $query = $this->db->get($this->table_name);
        // print_r($query->result());
        // die;
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //===== untuk ubah password =====
    public function getUserLogin($id)
    {
        $this->db->where($this->username, $id);
        $query = $this->db->get($this->table_name);
        return $query->result();
    }
    function ubahPassword($userID, $data)
    {
        $this->db->where('LoginID', $userID);
        $this->db->update($this->table_name, $data);
    }

    //====== Simpan Log
    function simpan_log($info)
    {
        $this->db->trans_start();
        $this->db->insert('tblUtl_LogOnline', $info);
        $signid = $this->db->insert_id();
        $this->db->trans_complete();
        return $signid;
    }

    function simpan_log_out($signid)
    {
        $this->db->trans_start();
        $this->db->query('Update tblUtl_LogOnline Set SignOut=GetDate() Where SignID=' . $signid);
        $this->db->trans_complete();
    }

    function login_onelogin($personalid, $personalstatus)
    {
        // var_dump($personalid,$personalstatus); die;
        $datapost       = array(
            'personalid'     => $personalid,
            'personalstatus' => $personalstatus
        );

        // cek status personal aktif
        $q2 = json_decode($this->curl->simple_post(setAPI() . "get_byno_personal", $datapost, array(CURLOPT_BUFFERSIZE => 10)));

        // cek status online onelogin
        $q3 = json_decode($this->curl->simple_post(setAPI() . "get_useron_onelogin", $datapost, array(CURLOPT_BUFFERSIZE => 10)));

        // cek status user app
        // if(count($q2) > 0) {
        if (count($q2) > 0 && count($q3) > 0) {
            $this->db->where('personalid', $personalid);
            $this->db->where('personalstatus', $personalstatus);
            return $this->db->get('vwUtlUserLogin');
        } else {
            return false;
        }
    }

    function login_sea($personalid, $personalstatus)
    {
        $this->db->where('personalid', $personalid);
        $this->db->where('personalstatus', $personalstatus);
        return $this->db->get('vwUtlUserLogin');
    }
}

/* End of file m_login.php */
/* Location: ./application/models/m_login.php */