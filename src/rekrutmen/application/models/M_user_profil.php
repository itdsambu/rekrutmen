<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class M_User_Profil extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function getProfile($loginID)
    {
        $query = $this->db->query("SELECT * FROM vwUtlUserLogin WHERE LoginID ='" . $loginID . "'");
        return $query->result();
    }

    function getProfileRow($loginID)
    {
        $query = $this->db->query("SELECT * FROM vwUtlUserLogin WHERE LoginID ='" . $loginID . "'");
        return $query->row();
    }

    function updateProfile($loginID, $data)
    {
        $this->db->trans_start();
        $this->db->where('LoginID', $loginID);
        $this->db->update('tblUtlUserDetail', $data);
        $this->db->trans_complete();
    }

    function simpanDetail($loginID, $dataSave, $dataUpdate)
    {
        $this->db->where('LoginID', $loginID);
        $q = $this->db->get('tblUtlUserDetail');

        if ($q->num_rows > 0) {
            $this->db->where('LoginID', $loginID);
            $this->db->update('tblUtlUserDetail', $dataUpdate);
        } else {
            $this->db->trans_start();
            $this->db->insert('tblUtlUserDetail', $dataSave);
            $uID = $this->db->insert_id();
            $this->db->trans_complete();
            return $uID;
        }
    }

    function getLastLogin($loginID)
    {
        $query = $this->db->query("SELECT TOP 1 * FROM tblUtl_LogOnline WHERE UserID ='" . $loginID . "' ORDER BY Tanggal DESC");
        return $query->result();
    }

    function update_status_foto($loginID)
    {
        $this->db->trans_start();
        $this->db->where('LoginID', $loginID);
        $this->db->update('tblUtlUserDetail', array('AdaPhoto' => 1));
        $this->db->trans_complete();
    }
}
