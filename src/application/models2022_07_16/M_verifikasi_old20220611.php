<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_verifikasi extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }

    function countAllTenaker(){
        $query = $this->db->query("SELECT HdrID FROM vwListBerkas_NEW_2022 WHERE GeneralStatus = 0 AND Verified NOT IN (1) ORDER BY Verified ASC");
        return $query->num_rows(); 
    }

    function selectAllTenaker($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY Verified ASC) AS ROW, * FROM vwListBerkas_NEW_2022 WHERE GeneralStatus = 0 AND Verified NOT IN (1)) vwListBerkas_NEW_2022 WHERE ROW >= ".$start." AND ROW <= ".$end." ");
        return $query->result();
    }

    function countAllTenakerWhere($pemborong,$nama,$noreg){
        $query = $this->db->query("SELECT HdrID FROM vwListBerkas_NEW_2022 WHERE HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' AND Pemborong LIKE '%".$pemborong."%' AND GeneralStatus = 0 AND Verified NOT IN (1) ORDER BY Verified ASC");
        return $query->num_rows();
    }

    function selectAllTenakerWhere($start,$end,$pemborong,$noreg,$nama){
        $query = $this->db->query("SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY Verified ASC) AS ROW, * FROM vwListBerkas_NEW_2022 WHERE HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' AND Pemborong LIKE '%".$pemborong."%' AND GeneralStatus = 0 AND Verified NOT IN (1)) vwListBerkas_NEW_2022 WHERE ROW >= ".$start." AND ROW <= ".$end." ");
        return $query->result();
    }

    function countBerkasLengkapTenaker(){
        $query = $this->db->query("SELECT HdrID FROM vwListBerkas_NEW_2022 WHERE GeneralStatus = 0 AND Verified NOT IN (1) AND KTP IS NOT NULL AND Lamaran IS NOT NULL AND CV IS NOT NULL AND Ijazah IS NOT NULL AND Transkrip IS NOT NULL ORDER BY Verified ASC");
        return $query->num_rows();
    }

    function selectBerkasLengkapTenaker($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY Verified ASC) AS ROW, * FROM vwListBerkas_NEW_2022 WHERE GeneralStatus = 0 AND Verified NOT IN (1) AND KTP IS NOT NULL AND Lamaran IS NOT NULL AND CV IS NOT NULL AND Ijazah IS NOT NULL AND Transkrip IS NOT NULL) vwListBerkas_NEW_2022 WHERE ROW >= ".$start." AND ROW <= ".$end." ");
        return $query->result();
    }

    function countBerkasLengkapTenakerWhere($pemborong,$nama,$noreg){
        $query = $this->db->query("SELECT HdrID FROM vwListBerkas_NEW_2022 WHERE HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' AND Pemborong LIKE '%".$pemborong."%' AND GeneralStatus = 0 AND Verified NOT IN (1) AND KTP IS NOT NULL AND Lamaran IS NOT NULL AND CV IS NOT NULL AND Ijazah IS NOT NULL AND Transkrip IS NOT NULL ORDER BY Verified ASC");
        return $query->num_rows();
    }

    function selectBerkasLengkapTenakerWhere($start,$end,$pemborong,$noreg,$nama){
        $query = $this->db->query("SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY Verified ASC) AS ROW, * FROM vwListBerkas_NEW_2022 WHERE HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' AND Pemborong LIKE '%".$pemborong."%' AND GeneralStatus = 0 AND Verified NOT IN (1) AND KTP IS NOT NULL AND Lamaran IS NOT NULL AND CV IS NOT NULL AND Ijazah IS NOT NULL AND Transkrip IS NOT NULL) vwListBerkas_NEW_2022 WHERE ROW >= ".$start." AND ROW <= ".$end." ");
        return $query->result();
    }

    function countMinimalBerkasTenaker(){
        $query = $this->db->query("SELECT HdrID FROM vwListBerkas_NEW_2022 WHERE GeneralStatus = 0 AND Verified NOT IN (1) AND KTP IS NOT NULL ORDER BY Verified ASC");
        return $query->num_rows();
    }

    function selectMinimalBerkasTenaker($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY Verified ASC) AS ROW, * FROM vwListBerkas_NEW_2022 WHERE GeneralStatus = 0 AND Verified NOT IN (1) AND KTP IS NOT NULL) vwListBerkas_NEW_2022 WHERE ROW >= ".$start." AND ROW <= ".$end." ");
        return $query->result();
    }

    function countMinimalBerkasTenakerWhere($pemborong,$nama,$noreg){
        $query = $this->db->query("SELECT HdrID FROM vwListBerkas_NEW_2022 WHERE HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' AND Pemborong LIKE '%".$pemborong."%' AND GeneralStatus = 0 AND Verified NOT IN (1) AND KTP IS NOT NULL ORDER BY Verified ASC");
        return $query->num_rows();
    }

    function selectMinimalBerkasTenakerWhere($start,$end,$pemborong,$noreg,$nama){
        $query = $this->db->query("SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY Verified ASC) AS ROW, * FROM vwListBerkas_NEW_2022 WHERE HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' AND Pemborong LIKE '%".$pemborong."%' AND GeneralStatus = 0 AND Verified NOT IN (1) AND KTP IS NOT NULL) vwListBerkas_NEW_2022 WHERE ROW >= ".$start." AND ROW <= ".$end." ");
        return $query->result();
    }

    function countTidakLengkapTenaker(){
        $query = $this->db->query("SELECT HdrID FROM vwListBerkas_NEW_2022 WHERE GeneralStatus = 0 AND Verified NOT IN (1) AND KTP IS NULL AND Lamaran IS NULL AND CV IS NULL AND Ijazah IS NULL AND Transkrip IS NULL ORDER BY Verified ASC");
        return $query->num_rows();
    }

    function selectTidakLengkapTenaker($start,$end){ 
        $query = $this->db->query("SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY Verified ASC) AS ROW, * FROM vwListBerkas_NEW_2022 WHERE GeneralStatus = 0 AND Verified NOT IN (1) AND KTP IS NULL AND Lamaran IS NULL AND CV IS NULL AND Ijazah IS NULL AND Transkrip IS NULL) vwListBerkas_NEW_2022 WHERE ROW >= ".$start." AND ROW <= ".$end." ");
        return $query->result();
    }

    function countTidakLengkapTenakerWhere($pemborong,$nama,$noreg){
        $query = $this->db->query("SELECT HdrID FROM vwListBerkas_NEW_2022 WHERE HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' AND Pemborong LIKE '%".$pemborong."%' AND GeneralStatus = 0 AND Verified NOT IN (1) AND KTP IS NULL AND Lamaran IS NULL AND CV IS NULL AND Ijazah IS NULL AND Transkrip IS NULL ORDER BY Verified ASC");
        return $query->num_rows();
    }

    function selectTidakLengkapTenakerWhere($start,$end,$pemborong,$noreg,$nama){
        $query = $this->db->query("SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY Verified ASC) AS ROW, * FROM vwListBerkas_NEW_2022 WHERE HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' AND Pemborong LIKE '%".$pemborong."%' AND GeneralStatus = 0 AND Verified NOT IN (1) AND KTP IS NULL AND Lamaran IS NULL AND CV IS NULL AND Ijazah IS NULL AND Transkrip IS NULL) vwListBerkas_NEW_2022 WHERE ROW >= ".$start." AND ROW <= ".$end." ");
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
        return $this->db->get_where('vwTrnCalonTenagaKarantina',array('HeaderID'=>$hdrid));
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