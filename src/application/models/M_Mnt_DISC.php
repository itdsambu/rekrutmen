<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD24
 */

class M_Mnt_DISC extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }

    function _getDataHdr($tanggal){
        $query = $this->db->query("SELECT A.*,B.Nama,B.Jenis_Kelamin,DATEDIFF(YEAR,b.Tgl_Lahir,GETDATE()) as Usia FROM tblTrnHasilTesHdr as A left join tblTrnCalonTenagaKerja as B ON A.RegisterID = B.HeaderID
            WHERE A.TanggalTes = '$tanggal'");
        return $query->result();
    }

    function _getDataHdrByID($id){
        $query = $this->db->query("SELECT A.*,B.Nama,B.Jenis_Kelamin,DATEDIFF(YEAR,b.Tgl_Lahir,GETDATE()) as Usia FROM tblTrnHasilTesHdr as A left join tblTrnCalonTenagaKerja as B ON A.RegisterID = B.HeaderID
            WHERE A.HasilHdrID = '$id'");
        return $query->result();
    }
    function _getDataDtlByID($id){
        $query = $this->db->query("SELECT A.HasilHdrID,A.GroupTesID,A.Jawaban_P,A.Jawaban_X,B.P,B.X FROM tblTrnHasilTesDtl as A left join tblMstPertanyaanTes as B ON A.PertanyaanID = B.PertanyaanID 
            where A.HasilHdrID = '$id'");
        return $query->result();
    }

    function _hslBag1($id){
        $query = $this->db->query("SELECT A.DISC,B.jml_p,C.jml_x FROM tblMstDISC as A left join (SELECT P,COUNT(Jawaban_P) as jml_p FROM tblTrnHasilTesDtl where HasilHdrID = '$id' and GroupTesID between '1' and '8' GROUP BY P) as B ON A.DISC = B.P
            left join (SELECT X,COUNT(Jawaban_X) as jml_x FROM tblTrnHasilTesDtl where HasilHdrID = '$id' and GroupTesID between '1' and '8' GROUP BY X) as C ON A.DISC = C.X");   
        return $query->result();
    }
    function _hslBag2($id){
        $query = $this->db->query("SELECT A.DISC,B.jml_p,C.jml_x FROM tblMstDISC as A left join (SELECT P,COUNT(Jawaban_P) as jml_p FROM tblTrnHasilTesDtl where HasilHdrID = '$id' and GroupTesID between '9' and '16' GROUP BY P) as B ON A.DISC = B.P
            left join (SELECT X,COUNT(Jawaban_X) as jml_x FROM tblTrnHasilTesDtl where HasilHdrID = '$id' and GroupTesID between '9' and '16' GROUP BY X) as C ON A.DISC = C.X");   
        return $query->result();
    }
    function _hslBag3($id){
        $query = $this->db->query("SELECT A.DISC,B.jml_p,C.jml_x FROM tblMstDISC as A left join (SELECT P,COUNT(Jawaban_P) as jml_p FROM tblTrnHasilTesDtl where HasilHdrID = '$id' and GroupTesID between '17' and '24' GROUP BY P) as B ON A.DISC = B.P
            left join (SELECT X,COUNT(Jawaban_X) as jml_x FROM tblTrnHasilTesDtl where HasilHdrID = '$id' and GroupTesID between '17' and '24' GROUP BY X) as C ON A.DISC = C.X");   
        return $query->result();
    }

    // Hasil Gambaran Diri

    function _getGambaranDiri($hdrid){
        $query = $this->db->query("WITH CTE AS (SELECT 'GROUP_A' AS [Group], A.DISC,B.jml_p,C.jml_x FROM tblMstDISC as A left join (SELECT P,COUNT(Jawaban_P) as jml_p FROM tblTrnHasilTesDtl where HasilHdrID = '$hdrid' and GroupTesID between '1' and '8' GROUP BY P) as B ON A.DISC = B.P
            left join (SELECT X,COUNT(Jawaban_X) as jml_x FROM tblTrnHasilTesDtl where HasilHdrID = '$hdrid' and GroupTesID between '1' and '8' GROUP BY X) as C ON A.DISC = C.X
            UNION ALL
            SELECT 'GROUP_B',A.DISC,B.jml_p,C.jml_x FROM tblMstDISC as A left join (SELECT P,COUNT(Jawaban_P) as jml_p FROM tblTrnHasilTesDtl where HasilHdrID = '$hdrid' and GroupTesID between '9' and '$hdrid' GROUP BY P) as B ON A.DISC = B.P
                        left join (SELECT X,COUNT(Jawaban_X) as jml_x FROM tblTrnHasilTesDtl where HasilHdrID = '$hdrid' and GroupTesID between '9' and '$hdrid' GROUP BY X) as C ON A.DISC = C.X
            UNION ALL
            SELECT 'GROUP_C',A.DISC,B.jml_p,C.jml_x FROM tblMstDISC as A left join (SELECT P,COUNT(Jawaban_P) as jml_p FROM tblTrnHasilTesDtl where HasilHdrID = '$hdrid' and GroupTesID between '17' and '24' GROUP BY P) as B ON A.DISC = B.P
                        left join (SELECT X,COUNT(Jawaban_X) as jml_x FROM tblTrnHasilTesDtl where HasilHdrID = '$hdrid' and GroupTesID between '17' and '24' GROUP BY X) as C ON A.DISC = C.X
            ) 

            SELECT TOP(1) DISC,COUNT(DISC) as jml  FROM (
            SELECT MAX(ISNULL(A.jml_p,0) + ISNULL(A.jml_x,0)) AS TTL,A.[Group]   FROM CTE A 
            GROUP BY A.[Group]  ) AS A LEFT JOIN
            CTE AS B ON A.[Group] = B.[Group] AND A.TTL =ISNULL(B.jml_p,0) + ISNULL(B.jml_x,0)
            GROUP BY DISC
            ORDER BY jml desc");
        return $query->result();
    }
}