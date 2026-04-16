<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: itd15
 * Date: 10/08/2015
 * Time: 13:32
 */
class M_user_login extends CI_Model
{

    private $primary_key = 'LoginID';
    private $table_name = 'tblUtlLogin';
    private $table_GrupUser = 'tblUtlGroupUser';

    function __construct()
    {
        parent::__construct();
    }
    function save($data)
    {
        $this->db->insert($this->table_name, $data);
        $hdrid = $this->db->insert_id();
        return $hdrid;
    }
    function saveDetail($loginID)
    {
        $this->db->insert('tblUtlUserDetail', $loginID);
        $hdrid = $this->db->insert_id();
        return $hdrid;
    }

    public function getGrupUser()
    {
        $query = $this->db->query('Select * from tblUtlGroupUser');
        $this->db->order_by('GroupName', 'ASC');
        return $query->result();
    }

    public function getDept()
    {
        $query = $this->db->query('Select * from vwMstDepartemen_new');
        $this->db->order_by('DeptAbbr');
        return $query->result();
    }

    function update($LoginID, $NamaUser, $GrupID, $Status, $UBy, $UDate)
    {
        //$this->db->where('LoginID',$userID);
        //$this->db->update($this->table_name,$data);

        $data = array(
            'NamaUser' => $NamaUser, 'GroupID' => $GrupID, 'NotActive' => $Status, 'UpdatedBy' => $UBy,
            'UpdatedDate' => $UDate
        );
        $this->db->where($LoginID);
        $this->db->update('tblUtlLogin', $data);
    }

    function updateUserLogin($userID, $data)
    {
        $this->db->where($userID);
        $this->db->update($this->table_name, $data);
    }

    function delete($id)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->delete($this->table_name);
    }
    function deleteDetail($id)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->delete('tblUtlUserDetail');
    }

    public function selectGrupUser($id)
    {
        $this->db->where('GroupID', $id);
        $query = $this->db->get($this->table_GrupUser);
        return $query->result();
    }

    function get_alldepartemen()
    {
        return json_decode($this->curl->simple_get(setAPI2() . "p1_get_all_departemen"));
    }

    public function selectUserLogin()
    {
        // $q = $this->db->query("Select * from vwUtlUserLogin")->result();
        // $this->db->select("*");
        $q = $this->db->get('vwUtlUserLogin')->result();


        $final = array();
        if (count($q) > 0) {
            foreach ($q as $row) {
                $datapost       = array(
                    'personalid'     => $row->PersonalId,
                    'personalstatus' => $row->PersonalStatus
                );

                // cek status personal aktif
                $q2 = json_decode($this->curl->simple_post(setAPI() . "get_byno_personal", $datapost, array(CURLOPT_BUFFERSIZE => 10)));
                $row->children = $q2;

                // cek status akun onelogin
                $q3 = json_decode($this->curl->simple_post(setAPI() . "get_byno_onelogin", $datapost, array(CURLOPT_BUFFERSIZE => 10)));
                $row->children2 = $q3;

                array_push($final, $row);
            }
        }
        return $final;
    }

    //===== get ID u/ Edit
    public function getUserLogin($id)
    {
        // $query = $this->db->query("Select * from vwUtlUserLogin where LoginID = '$id'");
        $this->db->where('LoginID', $id);
        $query =  $this->db->get('vwUtlUserLogin');

        return $query->result();
    }

    function ubahPassword($userID, $data)
    {
        $this->db->where('LoginID', $userID);
        $this->db->update($this->table_name, $data);
    }


    function getinfoNik($nik, $tipe)
    {
        // $arparam = array($nik,$tipe);
        $query = $this->db->query("exec getUserLogin '$nik','$tipe'")->result();
        return $query;
    }

    // Get USER API NEW

    function get_personalkar($datapost)
    {
        return json_decode($this->curl->simple_post(setAPI() . "get_bynik_karyawan", $datapost, array(CURLOPT_BUFFERSIZE => 10)));
    }

    function get_personaltk($datapost)
    {
        return json_decode($this->curl->simple_post(setAPI() . "get_bynik_tkerja", $datapost, array(CURLOPT_BUFFERSIZE => 10)));
    }

    // CLOSE

    function cekUser($nik, $userid)
    {
        $query = $this->db->query("SELECT * FROM tblUtlLogin WHERE NIK = '" . $nik . "' AND LoginID ='" . $userid . "'");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function saveUserLogin($param)
    {
        $this->db->insert('tblUtlLogin', $param);
        $hdrid = $this->db->insert_id();
        return $hdrid;
    }

    function saveAddUserLogin($dataa)
    {
        $this->db->insert('tblUtlLogin', $dataa);
        $hdrid = $this->db->insert_id();
        $this->db->trans_complete();
        return $hdrid;
    }

    function saveUpdateUserLogin($nik, $userid, $datab)
    {
        $this->db->where('NIK', $nik);
        $this->db->where('LoginID', $userid);
        $query = $this->db->update('tblUtlLogin', $datab);
        return $query;
    }
}

/* End of file m_user_login.php */
/* Location: ./application/models/m_user_login.php */