<?php
defined('BASEPATH') or exit('No Direct Script Access Allowed');

class m_monitoringtenagakerjanew  extends CI_Model{

	function getPemborong(){
		return $this->db->query("select * from vwMstPemborong")->result();
	}

	function getTypependidikan(){
		return $this->db->query("select * from tblTypePendidikan")->result();
	}

	function getMasterJurusan(){
		return $this->db->query("select * from tblMstJurusan")->result();
	}

}
?>