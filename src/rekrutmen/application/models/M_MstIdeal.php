<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_MstIdeal extends CI_Model{

	function get_list(){
		$query = $this->db->query("SELECT A.*,B.DeptAbbr FROM tblMstIdeal as A left join (SELECT distinct DeptID,DeptAbbr from tblMstDepartemenNew) as B ON A.DeptID = B.DeptID");
		return $query->result();
	}

	function get_departemen(){
		$query = $this->db->query("SELECT distinct DeptID,DeptAbbr from tblMstDepartemenNew");
		return $query->result();
	}

	function simpan($data){
		$this->db->insert('tblMstIdeal',$data);
	}

	function cek_data($dept){
		$query = $this->db->query("SELECT * FROM tblMstIdeal");
		return $query->result();
	}

	function update($id,$data){
		$this->db->where('DeptID',$id);
		$this->db->update('tblMstIdeal',$data);
	}

	function hapus($id){
		$this->db->where('IdealID',$id);
		$this->db->delete('tblMstIdeal');
	}
}