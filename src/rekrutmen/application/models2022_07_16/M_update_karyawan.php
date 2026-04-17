<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class M_update_karyawan extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    function getTK($hdrID){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE HeaderID='".$hdrID."'");
        return $query->result();
    }
    
    function getSuku(){
        $query = $this->db->get('tblMstSuku');
        return $query->result();
    }
    
    function getAgama(){
        $query = $this->db->get('tblMstAgama');
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
    
    function getAnakTK($hdrID){
        $query = $this->db->query("SELECT * FROM tblTrnAnak WHERE HeaderID='".$hdrID."'");
        return $query->result();
    }
    
    function getAnak($id){
        $query = $this->db->query("SELECT * FROM tblTrnAnak WHERE DetailID='".$id."'");
        return $query->result();
    }
    
    function getKelTK($hdrID){
        $query = $this->db->query("SELECT * FROM tblTrnKeluarga WHERE HeaderID='".$hdrID."'");
        return $query;
    }
    
    function getKel($id){
        $query = $this->db->query("SELECT * FROM tblTrnKeluarga WHERE DetailID='".$id."'");
        return $query->result();
    }
    
    function updateAnak($id,$detail){
        $this->db->where('DetailID',$id);
        $this->db->update('tblTrnAnak',$detail);
    }
    
    function updateKeluarga($id,$detail){
        $this->db->where('DetailID',$id);
        $this->db->update('tblTrnKeluarga',$detail);
    }
    
    function updateData($hrdID,$info){
        $this->db->where('HeaderID',$hrdID);
        $this->db->update('tblTrnCalonTenagaKerja',$info);
    }
}