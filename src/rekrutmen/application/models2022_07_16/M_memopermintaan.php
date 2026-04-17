<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_memopermintaan extends CI_Model {

    function __construct() {
        parent:: __construct();
    }

    public function getdatamemo(){
        $query = $this->db->query("SELECT * FROM vwPermintaanKryTKMemo");
        return $query->result();
    }
    public function getdatamemodept($dept){
        $query = $this->db->query("SELECT * FROM vwPermintaanKryTKMemo WHERE ForDept IN(SELECT DISTINCT DeptID FROM vwGrupDept WHERE GroupID=".$dept.") AND Approved1Sts is NULL");
        return $query->result();
    }

    public function getdatamemodivisi($dept){
        $query = $this->db->query("SELECT * FROM vwPermintaanKryTKMemo WHERE ForDept IN(SELECT DISTINCT DeptID FROM vwGrupDept WHERE GroupID=".$dept.") AND Approved1Sts=1 AND Approved2Sts IS NULL");
        return $query->result();
    }

    public function getdatamemomanagement($dept){
        $query = $this->db->query("SELECT * FROM vwPermintaanKryTKMemo WHERE ForDept IN(SELECT DISTINCT DeptID FROM vwGrupDept WHERE GroupID=".$dept.") AND Approved1Sts=1 AND Approved2Sts=1 AND Approved3Sts IS NULL");
        return $query->result();
    }
	
	function editMemo($id,$data){
		$this->db->where('IDMemo',$id);
		$query = $this->db->update('tblMstKuotaPermintaanMemo',$data);
		return $query; 
	}

    function updatedata($id,$data){
        $this->db->where('IDMemo',$id);
        $this->db->update('tblMstKuotaPermintaanMemo',$data);
    }
	
	function updatedatamanagement($id,$data){
        $this->db->where('IDMemo',$id);
        $this->db->update('tblMstKuotaPermintaanMemo',$data);
    }
	
	public function getfilememo($idmemo){
        return $this->db->get_where('vwMstKuotaPermintaanMemo',array('IDMemo'=>$idmemo));
    }

}