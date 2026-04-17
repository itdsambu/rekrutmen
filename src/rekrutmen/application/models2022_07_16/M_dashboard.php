<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : Ismo
 */

class M_dashboard extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    function itungAllTK(){
        $this->db->from('tblTrnCalonTenagaKerja');
		$crow = $this->db->count_all_results();
        return $crow;
    }
    
    function todayReg(){
        $now    = date('d-m-Y');
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE convert(date,RegisteredDate,105)=convert(date,'".$now."',105)");
        echo $query->num_rows();
    }
    
    function getLastRecord(){
        $query = $this->db->query("SELECT TOP 5 * FROM tblTrnCalonTenagaKerja ORDER BY HeaderID DESC");
        return $query->result();
    }
    
    function getLogLoginView($userID){
        $query = $this->db->query("SELECT TOP 100 * FROM tblUtl_LogOnline ORDER BY Tanggal DESC");
        return $query->result();
    }
    
    function getStatusScreenTeam(){
        $user   = $this->session->userdata('userid');
        $status = 0;
        $query = $this->db->query("SELECT * FROM tblUtlLogin WHERE LoginID = '".$user."'")->result();
        
        foreach ($query as $row):
            $status = $row->AnggotaScreening;
        endforeach;
        
        return $status;
    }
    function getDeptScreenTeam($dept){
        $query = $this->db->query("SELECT * FROM tblMstDeptScreening WHERE Dept = '".$dept."'");
        if ($query->num_rows() > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function getBlacklist(){
        $query = $this->db->query("SELECT * FROM tblTrnBlacklist ORDER BY NIK ASC");
        return $query->result();
    }
    function getProfileBlacklist($NIK){
        $query = $this->db->query("SELECT * FROM tblTrnBlacklist WHERE NIK ='".$NIK."'");
        return $query->result();
    }

    function itunguserOnline(){
        $this->db->where('Status','Online');
        
        $this->db->from('tblUtl_LogOnline');
        // $this->db->query("SELECT * FROM tblUtl_LogOnline WHERE Status='Online' AND SignOut IS NULL");
        $crow = $this->db->count_all_results();
        return $crow;
    }
}

/* End of file m_dashboard.php */
/* Location: ./application/models/m_dashboard.php */