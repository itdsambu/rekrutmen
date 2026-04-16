<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD24
 */


class m_updateIssuPermintaan extends CI_Model{
    
    public function __construct() {
        parent::__construct();

    }

    function get_IssueRequest(){
    	$tahun = date('Y');
    	$query = $this->db->query("SELECT distinct * FROM vwApprovalAll as A left join (SELECT DISTINCT DeptID,DeptAbbr,NamaDept FROM tblMstDepartemenNew where NotActive = '0') as B ON A.DeptID = B.DeptID where A.GeneralStatus = '1' and YEAR(A.CreatedDate) = '$tahun'");
    	return $query->result();
    }

    function get_IssueRequestId($id){
    	$query = $this->db->query("SELECT * FROM vwApprovalAll  as A left join (SELECT DISTINCT DeptID,DeptAbbr,NamaDept FROM tblMstDepartemenNew where NotActive = '0') as B ON A.DeptID = B.DeptID where A.GeneralStatus = '1' and A.DetailID = '$id'");
    	return $query->result();
    }

    function update($id,$data){
    	$this->db->where('DetailID',$id);
    	$this->db->update('tblTrnRequest',$data);
    }

    function getAjaxFilter($filter){
        $tahun = date('Y');
    	$query = $this->db->query("SELECT distinct * FROM vwApprovalAll  as A left join (SELECT DISTINCT DeptID,DeptAbbr,NamaDept FROM tblMstDepartemenNew where NotActive = '0') as B ON A.DeptID = B.DeptID where A.GeneralStatus = '1' and YEAR(A.CreatedDate) = '$tahun' and A.Pemborong = '$filter'");
    	return $query->result();
    }
}