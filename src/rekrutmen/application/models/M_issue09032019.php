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
        $query = $this->db->query("SELECT * FROM [192.168.3.32].PSGBorongan.dbo.tblMstPerusahaan ");
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

        $sql = ' SELECT k.*,totalpermintaan =  ' .
               " (SELECT  Permintaan = ISNULL(SUM(TKPermintaan),0) FROM vwTrnApprovalALL WHERE Pemborong='ALL PEMBORONG' and (GeneralStatus = 1 OR  GeneralStatus is null) " .
               ' AND DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara) ' .
               ' AND DeptID=' .  $data['DeptID'] . ') ' .
               'FROM vwIdealKryTk  k ' .
               'where deptbor=' . $data['DeptID'] . 'order by Periode desc';
        /*
        $sql = " select IBor,RBor, " .
               "    Sisa = isnull( ".
               " (select SUM(TKPermintaan) 	from tblTrnRequest r where (isnull(GeneralStatus,0) < 2) and CreatedDate > '2018-08-25'
                  and DeptID=K.krybor) ".
          ",0)"
       ",Kebutuhan = IBor-RBor " .
       "from vwKuotaKryTK k " .
       "where  krybor=" . $data['DeptID'];
        */

        $query = $this->db->query($sql);
        $row = $query->row();
        $kebutuhan = $row->IBor - ($row->RBor + $row->totalpermintaan);
        if($data['TKPermintaan']<=0){
            return array('error'=>2);
        }
        elseif($data['TKPermintaan'] > $kebutuhan){           
            $iserror=1;
            return array('psb'=>$row->totalpermintaan,'jp'=>$kebutuhan,'error'=>$iserror);
        }else{
            return array('error'=>0);
        }
    }

    function isValidPermintaanKaryawan($data){
        $ierror=0;

        $sql = ' SELECT k.*,totalpermintaan =  ' .
               " (SELECT  Permintaan = ISNULL(SUM(TKPermintaan),0) FROM vwTrnApprovalALL WHERE Pemborong='PSG' and (GeneralStatus = 1 OR  GeneralStatus is null) " .
               ' AND DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara) ' .
               ' AND DeptID=' .  $data['DeptID'] . ') ' .
               'FROM vwIdealKryTk k ' .
               'where deptkry=' . $data['DeptID'] . ' order by Periode desc';
        /*
        $sql = " select IBor,RBor, " .
               "    Sisa = isnull( ".
               " (select SUM(TKPermintaan) 	from tblTrnRequest r where (isnull(GeneralStatus,0) < 2) and CreatedDate > '2018-08-25'
                  and DeptID=K.krydept) ".
          ",0)".
       ",Kebutuhan = IKry-RKry " .
       "from vwKuotaKryTK k " .
       "where  krybor=" . $data['DeptID'];
       */
        
        $query = $this->db->query($sql);
        $row = $query->row();
        $kebutuhan = $row->IKry - ($row->RKry + $row->totalpermintaan);
        if($data['TKPermintaan']<=0){
            return array('error'=>2);
        }
        elseif($data['TKPermintaan'] > $kebutuhan){           
            $iserror=1;
            return array('psb'=>$row->totalpermintaan,'jp'=>$kebutuhan,'error'=>$iserror);
        }else{
            return array('error'=>0);
        }
        /*
        $ierror=0;
        $sql = "select * from vwKuotaKryTK where krybor=" . $data['DeptID'];
        $query = $this->db->query($sql);
        $row = $query->row();
        if($data['TKPermintaan']<=0){
            return array('error'=>2);
        }elseif($row->RKry + $data['TKPermintaan'] > $row->IKry){
            $ndata = $row->IKry - $row->RKry; 
            $iserror=1;
            return array('jp'=>$ndata,'error'=>$iserror);
        }else{
            return array('error'=>0);
        }
        */
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

    function getdatakuotakry($id){
        $this->db->where('deptbor',$id);
        $this->db->order_by('periode','desc');
        $query = $this->db->get('vwIdealKryTk');
        $row = $query->row();

        //----- cek tabel kuota
        //$this->db->where('krydeptname',$deptabbr);
        //$query = $this->db->get('vwKuotaKryTK');
        //$row = $query->row();
        return $row;
    }

    function getdatakuotabor($id){
        $this->db->where('deptbor',$id);
        $this->db->order_by('periode','desc');
        $query = $this->db->get('vwIdealKryTk');
        $row = $query->row();
        //$deptabbr = $row->DeptAbbr;

        //----- cek tabel kuota
        //$this->db->where('bordeptname',$deptabbr);
       // $query = $this->db->get('vwKuotaKryTK');
       // $row = $query->row();
        return $row;
    }
    
}