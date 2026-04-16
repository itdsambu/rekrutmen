<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_MstMess extends CI_Model{

	function simpan($data){
		$this->db->insert('tblMstMess',$data);
	}

	function get_dataMsterMess(){
		$query = $this->db->query("SELECT * FROM vwMstMess");
		return $query->result();
	}

	function get_dataMsterMessByid($id){
		$query = $this->db->query("SELECT * FROM tblMstMess where MessID = '$id'");
		return $query->result();
	}

	function update($id,$data){
		$this->db->where('MessID',$id);
		$this->db->update('tblMstMess',$data);
	}
}