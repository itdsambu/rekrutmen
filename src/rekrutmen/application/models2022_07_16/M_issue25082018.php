<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class M_issue extends MY_Model{
    
   
    
    function getDept(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM vwMstDepartemen WHERE IDDept IN "
                . "(SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.") ORDER BY DeptAbbr");
        return $query->result();
    }
    
    function getPekerjaan($dept){
        $query = $this->db->query("SELECT DISTINCT * FROM vwMstPekerjaanDept WHERE IDDept = '".$dept."'");
        return $query->result();
    }
    
    function getJabatan(){
        $query = $this->db->query("SELECT DISTINCT * FROM tblMstJabatan ORDER BY Jabatan");
        return $query->result();
    }
            
    function getPemborong(){
        $query = $this->db->query("SELECT * FROM PSGBorongan.dbo.tblMstPerusahaan ");
        return $query->result();
    }
    function getPemborongKaryawan(){
        $query = $this->db->query("SELECT * FROM vwMstPemborong WHERE Pemborong = 'RSUP' ");
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
    
    function getPemborongAll(){
        $query = $this->db->query("SELECT * FROM vwMstPemborong ORDER BY Pemborong ASC");
        return $query->result();
    }
    function setInfoTran($id){
        $query = $this->db->query("SELECT * FROM vwTrnApprovalAll WHERE DetailID = '".$id."'");
        return $query->result();
    }
    function setInfoTranEdit($id){
        $query = $this->db->query("SELECT * FROM vwTrnApprovalAll WHERE DetailID = '".$id."'");
        return $query;
    }
            
    function saveIssue($data){
        $this->db->trans_start();
        $this->db->insert('tblTrnRequest',$data);
        $this->db->trans_complete();
    }

    function isValidPermintaanBorongan($data){
        $ierror=0;
        $sql = "select * from vwKuotaKryTK where krybor=" . $data['DeptID'];
        $query = $this->db->query($sql);
        $row = $query->row();
        if($row->RBor + $data['TKPermintaan'] > $row->IBor){
            $ndata = $row->IBor - $row->RBor; 
            $iserror=1;
            return array('jp'=>$ndata,'error'=>$iserror);
        }else{
            return array('error'=>0);
        }
    }

    function isValidPermintaanKaryawan($data){
        $ierror=0;
        $sql = "select * from vwKuotaKryTK where krybor=" . $data['DeptID'];
        $query = $this->db->query($sql);
        $row = $query->row();
        if($row->RKry + $data['TKPermintaan'] > $row->IKry){
            $ndata = $row->IKry - $row->RKry; 
            $iserror=1;
            return array('jp'=>$ndata,'error'=>$iserror);
        }else{
            return array('error'=>0);
        }
    }
    
    function getIssue(){
        $query = $this->db->query("SELECT * FROM vwTrnApprovalAll WHERE GeneralStatus = 1 ");
        return $query->result();
    }
    
    function updateTran($id,$data){
        $this->db->trans_start();
        $this->db->where('DetailID',$id);
        $this->db->update('tblTrnRequest',$data);
        $this->db->trans_complete();
    }
    
}