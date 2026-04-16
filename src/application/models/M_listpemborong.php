<?php defined('BASEPATH') or exit('No Direct Script Access Allowed');

class m_listpemborong extends CI_Model{

	function simpanData($data){
        $this->db->insert('tblMstPemborong',$data);
        $hdrid = $this->db->insert_id();
        return $hdrid;
	}

	function update($idpemborong,$data){
		$this->db->where('IDPemborong',$idpemborong);
		$this->db->update('tblMstPemborong',$data);
	}

	function get_DataPemborong(){
		return $this->db->query("select IDPemborong,Pemborong from RSUPBorongan2010..tblMstPemborong where Status = '1'")->result();
	}

	function get_DataMst(){
		return $this->db->query("select IDPemborong, Status from tblMstPemborong")->result();
	}

}?>