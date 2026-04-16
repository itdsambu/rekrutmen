<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class M_Approval extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    function getTransForDept(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL WHERE DEPTApproval Is NULL AND "
                . "DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.") AND DEPTStatus Is NULL");
        return $query->result();
    }
    
    function getTranForDivisi(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL WHERE DIVISIApproval Is NULL AND "
                . "DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.") AND DIVISIStatus Is NULL "
                . "AND DEPTApproval Is Not NULL AND DEPTStatus = 1");
        return $query->result();
    }
    
    function getTranForPsn(){
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL WHERE PSNApproval Is NULL AND PSNStatus Is NULL "
                . "AND DEPTApproval Is Not NULL AND DEPTStatus = 1 "
                . "AND DIVISIApproval Is Not NULL AND DIVISIStatus = 1");
        return $query->result();
    }
    
    function getTranForAgm(){
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL WHERE AGMApproval Is NULL AND AGMStatus Is NULL "
                . "AND DEPTApproval Is Not NULL AND DEPTStatus = 1 "
                . "AND DIVISIApproval Is Not NULL AND DIVISIStatus = 1 "
                . "AND PSNApproval Is Not NULL AND PSNStatus = 1 ");
        return $query->result();
    }
    
    function getTranForVgm(){
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL WHERE VGMApproval Is NULL AND VGMStatus Is NULL "
                . "AND DEPTApproval Is Not NULL AND DEPTStatus = 1 "
                . "AND DIVISIApproval Is Not NULL AND DIVISIStatus = 1 "
                . "AND PSNApproval Is Not NULL AND PSNStatus = 1 "
                . "AND AGMApproval Is Not NULL AND AGMStatus = 1");
        return $query->result();
    }
    
    function getDept($dept){
        $query = $this->db->query("SELECT TOP 1 * FROM tblMstDepartemenNew WHERE DeptID = ".$dept);
        return $query->result();
    }
    function setInfoTran($id){
        $query = $this->db->query("SELECT * FROM tblTrnRequest WHERE DetailID = '".$id."'");
        return $query->result();
    }
    
    function updateTran($id,$data){
        $this->db->trans_start();
        $this->db->where('DetailID',$id);
        $this->db->update('tblTrnRequest',$data);
        $this->db->trans_complete();
    }
}