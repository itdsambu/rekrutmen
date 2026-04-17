<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class M_grupDept extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    function getDept($grupID){
        $query = $this->db->query("SELECT GroupID, DeptID, DeptAbbr, NamaDept, Act = 1 FROM dbo.vwGrupDept WHERE GroupID = ".$grupID."
        UNION ALL 
        SELECT DISTINCT GroupID = NULL, IDDept AS DeptID, DeptAbbr, NamaDept, Atc = 0 FROM dbo.vwMstDepartemen 
        WHERE IDDept NOT IN (SELECT DeptID FROM dbo.tblUtlGrupDept WHERE GroupID = ".$grupID.") ORDER BY DeptAbbr");
        return $query->result();
    }
    
    //===== simpan menu akses
    function simpanAkses($grupid,$menuid){
        $info = array(
            'GroupID'	=> $grupid,
            'DeptID'	=> $menuid
        );

        $this->db->trans_start();
        $cek = $this->db->get_where('tblUtlGrupDept',$info);

        if ($cek->num_rows() == 0){		
                $this->db->insert('tblUtlGrupDept',$info);
        }
        $this->db->trans_complete();
    }
    
    function hapus_menuakses($grupid){
        $this->db->delete('tblUtlGrupDept',array('GroupID'=>$grupid));
    }
    
    function getDeptFromGrup($grupID){
        $query = $this->db->query("SELECT * FROM tblUtlGrupDept WHERE GroupID = '".$grupID."'");
        return $query->result();
    }
}