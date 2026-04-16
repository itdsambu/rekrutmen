<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class M_issue extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    function getDept(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT DISTINCT DeptID, DeptAbbr FROM tblMstDepartemenNew WHERE DeptID IN "
                . "(SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.") ORDER BY DeptAbbr");
        return $query->result();
    }
    
    function getPekerjaan($dept){
        $query = $this->db->query("SELECT DISTINCT * FROM vwMstPekerjaanDept WHERE DeptID = '".$dept."'");
        return $query->result();
    }
    
    function getJabatan(){
        $query = $this->db->query("SELECT * FROM vwMstJabatan ORDER BY JabatanName");
        return $query->result();
    }
            
    function getPemborong(){
        $query = $this->db->query("SELECT * FROM vwMstPemborong WHERE Pemborong != 'RSUP' ");
        return $query->result();
    }
    function getPemborongKaryawan(){
        $query = $this->db->query("SELECT * FROM vwMstPemborong WHERE Pemborong = 'RSUP' ");
        return $query->result();
    }
    function getPemborongAll(){
        $query = $this->db->query("SELECT * FROM vwMstPemborong ORDER BY Pemborong ASC");
        return $query->result();
    }
    
    function getStatusKawin(){
        $query = $this->db->get('tblMstStatusKawin');
        return $query->result();
    }
    
    function getPendidikan(){
        $query = $this->db->get('tblMstPendidikan');
        return $query->result();
    }
    
    function getJurusan(){
        $query = $this->db->get('tblMstJurusan');
        return $query->result();
    }
            
    function saveIssue($data){
        $this->db->trans_start();
        $this->db->insert('tblTrnRequest',$data);
        $this->db->insert_id();
        $this->db->trans_complete();
    }
    
    function getIssue(){
        $query = $this->db->query("SELECT * FROM vwApprovalAll WHERE GeneralStatus = 1 ");
        return $query->result();
    }
    
    function setInfoTran($id){
        $query = $this->db->query("SELECT * FROM vwApprovalAll WHERE DetailID = '".$id."'");
        return $query;
    }
    function countSuccessPermin($id){
        $this->db->where('TransID',$id);
        $get    = $this->db->get('vwTrnReportPosted');
        return $get->num_rows();
    }
            
    function updateTran($id,$data){
        $this->db->trans_start();
        $this->db->where('DetailID',$id);
        $this->db->update('tblTrnRequest',$data);
        $this->db->trans_complete();
    }

    //  function getCekData(){
    //     $grupID = $this->session->userdata('groupuser');
    //     // $tahun = date('Y');
    //     $query = $this->db->query("select * from vwApprovalAll where GeneralStatus <> 3 and Pemborong in ('RSUP') and DeptID in (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = '$grupID')");
    //     return $query->result();
    // }

    // function getCekDataTK(){
    //     $grupID = $this->session->userdata('groupuser');
    //     $query = $this->db->query("select * from vwApprovalAll where GeneralStatus <> 3 and Pemborong in ('ALL PEMBORONG') and DeptID in (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = '$grupID' )");
    //     return $query->result();
    // }
    
}