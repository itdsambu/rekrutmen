<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class M_kepala_shift extends CI_Model
{

	function simpan($data){
		$this->db->insert('tblMstKepalaShift',$data);
	}

	function get_data(){
		$query = $this->db->query("SELECT * FROM tblMstKepalaShift");
		return $query->result();
	}
}