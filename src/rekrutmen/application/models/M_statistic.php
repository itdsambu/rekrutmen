<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class M_Statistic extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    // function countPemborongTgl($tgl){
    //     $query = $this->db->query("(SELECT CVNama, Pemborong, Tanggal, TotalDaftar FROM vwMonStatistikPbr 
    //         Where Tanggal = '".$tgl."'
    //         Union All
    //         Select CVNama = Perusahaan, Pemborong, Tanggal = null, TotalDaftar = 0 From vwMstPemborong
    //         Where Pemborong Not in ('PSG')
    //         And Pemborong Not In (Select Pemborong From vwMonStatistikPbr Where Tanggal='".$tgl."')) ORDER BY Pemborong ASC");
    //     return $query->result();
    // }

    function countPemborongTgl($tglA,$tglZ){
        $query = $this->db->query("select * from (
SELECT CVNama, Pemborong, Tanggal, TotalDaftar FROM vwMonStatistikPbr Where Tanggal between '".$tglA."' and '".$tglZ."'
union all
Select CVNama = Perusahaan, Pemborong, Tanggal = null, TotalDaftar = 0 From vwMstPemborong Where Pemborong Not in ('PSG') And Pemborong Not In (Select Pemborong From vwMonStatistikPbr Where Tanggal between '".$tglA."' and '".$tglZ."')) as A order by A.Pemborong asc");
        return $query->result();
    }
    
    function countPemborongBln($tanggal){
        $thn    = substr($tanggal, 0, 4);
        $bln    = substr($tanggal, 5, 2);
        $awal   = $thn."-".$bln."-01";
        
        $query = $this->db->query("(SELECT CVNama, Pemborong = Pemborong COLLATE SQL_Latin1_General_CP1_CI_AS, COUNT(HeaderID) AS TotalDaftar FROM tblTrnCalonTenagaKerja 
            WHERE (Pemborong NOT IN ('PSG','YAO HSING')) AND (InputOnline = 1) AND 
            CONVERT (date, RegisteredDate,103) between '".$awal."' AND '".$tanggal."' 
            GROUP BY CVNama, Pemborong
            Union All
            Select CVNama = Perusahaan, Pemborong, TotalDaftar = 0 From VwMstPemborong 
            Where Pemborong COLLATE SQL_Latin1_General_CP1_CI_AS Not in ('PSG','YAO HSING') AND 
            Pemborong COLLATE SQL_Latin1_General_CP1_CI_AS Not In (Select Pemborong FROM dbo.tblTrnCalonTenagaKerja 
                WHERE (Pemborong NOT IN ('PSG','YAO HSING')) AND (InputOnline = 1) AND 
                CONVERT (date, RegisteredDate,103) between '".$awal."' AND '".$tanggal."' 
                GROUP BY  Pemborong)) ORDER BY Pemborong ASC");
        return $query->result();
    }
    
    function getIssue($tanggal){
        $thn    = substr($tanggal, 0, 4);
        $bln    = substr($tanggal, 5, 2);
        $thisMon= $thn."-".$bln;
        $query = $this->db->query("SELECT * FROM vwTrnApprovalAll WHERE GeneralStatus = 3 AND 
            DetailID in (SELECT DetailID FROM vwGetTglPostedIssue WHERE Tanggal LIKE '".$thisMon."%')");
//        $query = $this->db->query("SELECT * FROM vwTrnApprovalAll WHERE GeneralStatus = 1 ORDER BY DetailID");
        return $query->result();
    }
    
    function getReviewTenaker($issueID){
        $query = $this->db->query("SELECT
    tblTrnCalonTenagaKerja.*,
    vwTrnApprovalAll.VGMDate,
    tblTrnPosting.CreatedDate as tgl_posting
FROM
    tblTrnCalonTenagaKerja
    JOIN vwTrnApprovalAll ON tblTrnCalonTenagaKerja.TransID = vwTrnApprovalAll.DetailID
    JOIN tblTrnPosting ON tblTrnCalonTenagaKerja.HeaderID = tblTrnPosting.HeaderID 
WHERE
    tblTrnCalonTenagaKerja.TransID = ".$issueID." 
    AND " . " tblTrnCalonTenagaKerja.HeaderID IN ( SELECT HeaderID FROM tblTrnPosting )");

        return $query;
    }

    // ##== New Model Rekap 
    function getRekapIssueRequest($start,$end){
        $get = $this->db->query("SELECT * FROM vwRekapIssuePermintaan WHERE GeneralStatus IN (0, 1) AND CreatedDate BETWEEN '".$start."' AND '".$end."'");
        return $get->result();
    }

    function getIssuepermintaanAllPemborong(){
        $query = $this->db->query("SELECT DISTINCT * FROM vwUpdateIssuePermintaan WHERE Pemborong='ALL PEMBORONG'");
        return $query->result();
    }

    function getIssuepermintaanPSG(){
        $query = $this->db->query("SELECT DISTINCT * FROM vwUpdateIssuePermintaan WHERE Pemborong='PSG'");
        return $query->result();
    }

    function getIssuepermintaan(){
        $query = $this->db->query("SELECT DISTINCT * FROM vwUpdateIssuePermintaan");
        return $query->result();
    }

    function countIssuepermintaanAllPemborong(){
        $query = $this->db->query("SELECT DISTINCT DetailID FROM vwUpdateIssuePermintaan WHERE Pemborong='ALL PEMBORONG'");
        return $query->num_rows();
    }

    function countIssuepermintaanPSG(){
        $query = $this->db->query("SELECT DISTINCT DetailID FROM vwUpdateIssuePermintaan WHERE Pemborong='PSG'");
        return $query->num_rows();
    }

    function countIssuepermintaan(){
        $query = $this->db->query("SELECT DISTINCT DetailID FROM vwUpdateIssuePermintaan");
        return $query->num_rows();
    }

    function getDetailIssue($id){
        $query = $this->db->query("SELECT DISTINCT * FROM vwUpdateIssuePermintaan where DetailID='$id'");
        return $query->result();
    }

    function updatedreqissue($id,$param){
        $this->db->trans_start();
        $this->db->where('DetailID',$id);
        $this->db->update('tblTrnRequest',$param);
        $this->db->trans_complete();
    }
}