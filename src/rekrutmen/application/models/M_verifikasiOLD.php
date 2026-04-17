<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_Verifikasi extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    function getListTK(){
        $query = $this->db->query("SELECT * FROM vwListBerkas WHERE GeneralStatus = 0 AND Verified NOT IN (1) ORDER BY Verified ASC");
        return $query->result();
    }

    function getListTKwhere($startDate, $endDate){
        $query = $this->db->query("SELECT * FROM vwListBerkas WHERE Verified NOT IN (1) AND GeneralStatus = 0 AND CONVERT(date,RegisteredDate) BETWEEN '".$startDate."' AND '".$endDate."'  ORDER BY Verified ASC");
        return $query->result();
    }
    
    function updateVerified($hdrID){
        $data   = array(
            'Verified'      => 1,
            'VerifiedBy'    => strtoupper($this->session->userdata('username')),
            'VerifiedDate'  => date('Y-m-d H:i:s')
        );
        $this->db->trans_start();
        $this->db->where('HeaderID',$hdrID);
        $this->db->update('tblTrnCalonTenagaKerja',$data);
        $this->db->trans_complete();
    }
    
    function batalVerified($hdrID){
        $this->db->trans_start();
        $this->db->where('HeaderID',$hdrID);
        $this->db->update('tblTrnCalonTenagaKerja',array('Verified'=>0));
        $this->db->trans_complete();
    }
    
    function closeTenaker($hdrID, $remark){
        $data   = array(
            'GeneralStatus' => 1,
            'ClosingRemark' => $remark,
            'ClosingBy'     => strtoupper($this->session->userdata('username')),
            'ClosingDate'   => date('Y-m-d H:i:s')
        );
        $this->db->trans_start();
        $this->db->where('HeaderID',$hdrID);
        $this->db->update('tblTrnCalonTenagaKerja',$data);
        $this->db->trans_complete();
    }
    
    function get_detailtk($hdrid){
        return $this->db->get_where('tblTrnCalonTenagaKerja',array('HeaderID'=>$hdrid));
    }

    function resultScreen($hdrid){
        return $this->db->get_where('tblTrnVerifikasi',array('HeaderID'=>$hdrid));
    }

    function simpanVerifikasiTim($data){
        $this->db->trans_start();
        $this->db->insert('tblTrnVerifikasi',$data);
        $sID = $this->db->insert_id();
        $this->db->trans_complete();
        return $sID;
    }
}

/* End of file m_verifikasi.php */
/* Location: ./application/models/m_verifikasi.php */