<?php defined('BASEPATH') or exit('No Direct Script Access Allowed');

class m_calon_kandidat extends CI_Model{
	function getPemborong($id){
		$query = $this->db->query(" SELECT * FROM vwMstPemborong where IDPemborong = '$id'");
		return $query->result();
	}

	function get_pemborong(){
		$query = $this->db->query(" SELECT * FROM vwMstPemborong");
		return $query->result();
	}
}