<?php defined('BASEPATH') or exit('No Direct Script Access Allowed');

class m_permintaan extends CI_Model{

	function get_departemen(){
		return $this->db->query("SELECT distinct DeptID,DeptAbbr FROM tblMstDepartemenNew")->result();
	}
    function cek($id){
        return $this->db->query("select DeptAbbr from vw_memopermintaan where IDPermintaan = '$id' ")->result();
    }
	function savekary($data){
		$this->db->insert('tblPermintaan',$data);
        $hdrid = $this->db->insert_id();
        return $hdrid;
	}
}

?>