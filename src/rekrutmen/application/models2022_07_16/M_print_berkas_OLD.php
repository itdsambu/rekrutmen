<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author bt ITD15
 */

class M_print_berkas extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    function getTenakerPosted(){
        $query = $this->db->query("SELECT TOP 50 * FROM vwTrnPosted ORDER BY CreatedDate DESC");
        return $query->result();
    }
    function getTenakerPostedWhere($startDate, $endDate){
        $query = $this->db->query("SELECT * FROM vwTrnPosted WHERE CONVERT(date,CreatedDate) BETWEEN '".$startDate."' AND '".$endDate."' ORDER BY HeaderID DESC");
        return $query->result();
    }
    
    // ###=== For Paging ===###
    // == Tenaker Posted
    function selectTenakerPostedPrintPaging($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
                . "* FROM vwTrnPosted AS tbl ) vwTrnPosted WHERE Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countTenakerPostedPrintPaging(){
        $query = $this->db->query("SELECT HeaderID FROM vwTrnPosted ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    // == Tenaker Posted Condotion Filter
    function selectTenakerPostedPrintPagingWhere($start,$end,$pemborong,$noreg,$nama){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
                . "* FROM vwTrnPosted AS tbl WHERE Pemborong LIKE '%".$pemborong."%' AND "
                . "HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%') "
                . "vwTrnPosted WHERE  Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countTenakerPostedPrintPagingWhere($pemborong,$noreg,$nama){
        $query = $this->db->query("SELECT HeaderID FROM vwTrnPosted WHERE Pemborong LIKE '%".$pemborong."%' AND "
                . "HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    
    // == Tenaker Interviewed
    function selectTenakerInterviewedPrintPaging($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
                . "* FROM vwTrnLulusInterview AS tbl ) vwTrnLulusInterview WHERE Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countTenakerInterviewedPrintPaging(){
        $query = $this->db->query("SELECT HeaderID FROM vwTrnLulusInterview ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    // == Tenaker Interviewed Condition Filter
    function selectTenakerInterviewedPrintPagingWhere($start,$end,$pemborong,$noreg,$nama){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
                . "* FROM vwTrnLulusInterview AS tbl WHERE Pemborong LIKE '%".$pemborong."%' AND "
                . "HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%') "
                . "vwTrnLulusInterview WHERE  Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countTenakerInterviewedPrintPagingWhere($pemborong,$noreg,$nama){
        $query = $this->db->query("SELECT HeaderID FROM vwTrnLulusInterview WHERE Pemborong LIKE '%".$pemborong."%' AND "
                . "HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }


    // ==================== Ambil Data Detail Karyawan dan Anaknya ===========================
    function getResult($hdrID){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE HeaderID ='".$hdrID."'");
        return $query->result();
    }
    function getInterV($hdrID){
        $query = $this->db->query("SELECT TOP 1 * FROM tblTrnWawancara WHERE HeaderID ='".$hdrID."' ORDER BY Tanggal DESC");
        return $query->result();
    }
    function getAnak($hdrID){
        $query = $this->db->query("SELECT TOP 2 * FROM tblTrnAnak WHERE HeaderID ='".$hdrID."' ORDER BY TglLahir DESC");
        return $query->result();
    }
}