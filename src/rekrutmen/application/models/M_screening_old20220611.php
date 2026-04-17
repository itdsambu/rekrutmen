<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_screening extends CI_Model{
    
    public function __construct() {
        parent::__construct(); 
    }
    
    //======= Screening TIM
    function listTenagaKerja($nowOL,$dept,$isDiv=NULL){
        if ($isDiv == NULL){
            $where = "AND ScreeningComplete Is Null AND ((b.kodedivisi = 7 AND AppDivStatus = 1) OR (b.kodedivisi <> 7 OR b.kodedivisi IS NULL))";
        } else if ($isDiv == 2){
            $where = "AND a.status_p2k3 = 1 AND (AppP2K3Status <> 1 OR AppP2K3Status IS NULL)";
        }else{
            $where = "AND b.kodedivisi = 7 
                      AND ( (a.status_p2k3 = 1 AND AppP2K3Status = 1 AND ( AppDivStatus <> 1 OR AppDivStatus IS NULL )) OR ( a.status_p2k3 = 0 AND ( AppDivStatus <> 1 OR AppDivStatus IS NULL ) ) )"; 
        }
        $query = $this->db->query("SELECT DISTINCT
                                        a.HeaderID,
                                        a.Nama,
                                        a.CVNama,
                                        a.Pemborong,
                                        a.Tgl_Lahir,
                                        a.Jenis_Kelamin,
                                        a.ScreeningComplete,
                                        a.RegisteredBy,
                                        a.RegisteredDate,
                                        a.AppDivStatus,
                                        a.DeptTujuan,
                                        a.TransID,
                                        c.Pekerjaan,
                                    CASE
                                            
                                            WHEN b.kodedivisi = 7 THEN
                                            1 ELSE 0 
                                        END AS AppDivNeeded,
                                        a.status_p2k3,
                                        d.status_karantina,
                                        d.tgl_klr_karantina,
                                        d.hasil_tes_karantina 
                                    FROM
                                        tblTrnCalonTenagaKerja a
                                        LEFT JOIN ( SELECT DISTINCT DeptKary, kodedivisi FROM vwMstDivisi ) b ON a.DeptTujuan = b.DeptKary
                                        LEFT JOIN vwTrnApprovalAll AS c ON a.TransID = c.DetailID 
                                        LEFT JOIN tblTrnKarantina_dtl AS d ON a.HeaderID = d.registrasi_id
                                    WHERE
                                        Verified = '1' 
                                        AND UdahDiAmbil = '0'
                                        AND a.GeneralStatus = '0'
                                        AND d.status_karantina = '1'
                                        AND d.hasil_tes_karantina IS NOT NULL
                                        AND d.tgl_klr_karantina IS NOT NULL
                                        AND HeaderID NOT IN(SELECT HeaderID FROM tblTrnScreening WHERE Dept = '$dept')
                                        ".$where." ORDER BY a.HeaderID ASC");
        return $query->result();
    }
    
    function getDetailTK($hdrid){
        return $this->db->get_where('vwTrnCalonTenagaKarantina',array('HeaderID'=>$hdrid));
    }
    
    function simpanScreeningTim($data){
        $this->db->trans_start();
        $this->db->insert('tblTrnScreening',$data);
        $sID = $this->db->insert_id();
        $this->db->trans_complete();
        return $sID;
    }
    
    function rowTeamScreening(){
        $query  = $this->db->query("SELECT * FROM tblMstDeptScreening");
        return $query->num_rows();
    }
    
    function getHasilScreen($hrdID){
        $this->db->where('HeaderID',$hrdID);
        $q = $this->db->get('tblTrnScreening');
        $row = $this->rowTeamScreening() - 2;
        if($q->num_rows() > $row){
            $hasil = 'complite';
        }else{
            $hasil = NULL;
        }
        return $hasil;
    }
    
    function getHasilLulus($hrdID){
        $this->db->where('HeaderID',$hrdID);
        $this->db->where('Lulus',1);
        $q = $this->db->get('tblTrnScreening');
        $hasil = $q->num_rows();
        return $hasil;
    }
    function getHasilTIdakLulus($hrdID){
        $this->db->where('HeaderID',$hrdID);
        $this->db->where('Lulus',0);
        $q = $this->db->get('tblTrnScreening');
        $hasil = $q->num_rows();
        return $hasil;
    }
            
    function updateLulus($hrdID, $info){
        $this->db->where('HeaderID',$hrdID);
        $this->db->update('tblTrnCalonTenagaKerja',$info);   
    }


    //================================== Screening PSN ==========================================
    function listTKScreenedTim(){
        $query = $this->db->query("SELECT DISTINCT
                                        a.*,
                                        b.KTP,
                                        b.CV,
                                        b.Lamaran,
                                        b.Ijazah,
                                        b.Transkrip,
                                        b.Vaksin1,
                                        b.Vaksin2,
                                        b.Vaksin3 
                                    FROM
                                        vwTenakerForScreenPSN_karantina AS a
                                        INNER JOIN vwListBerkas_NEW_2022 AS b ON b.HdrID= a.HeaderID 
                                    ORDER BY
                                        HeaderID ASC");
        return $query->result();  
    }
    
    function getDocs($userID){
        $query = $this->db->query("SELECT * FROM tblTrnBerkas WHERE HeaderID='".$userID."'");
        return $query->result();
    }
    
    function resultScreen($hdrid){
        return $this->db->get_where('tblTrnScreening',array('HeaderID'=>$hdrid));
    }
    
    function resultInterview($hdrid){
        return $this->db->get_where('tblTrnWawancara',array('HeaderID'=>$hdrid));
    }
            
    function screenByPsn($hrdID, $info){
        $this->db->where('HeaderID',$hrdID);
        $this->db->update('tblTrnCalonTenagaKerja',$info);
    }





    function countScreeningLulus(){
        $query = $this->db->query("SELECT HeaderID FROM vwTenakerScreeningByPsn_karantina_2022 WHERE SpecialScreening = 1 and ScreeningComplete = 1 and ScreeningHasil = 1 and GeneralStatus = 0 ORDER BY HeaderID ASC");
        return $query->num_rows();
    }

    function selectScreeningLulus($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
                . "* FROM vwTenakerScreeningByPsn_karantina_2022 AS tbl WHERE SpecialScreening = 1 and ScreeningComplete = 1 and ScreeningHasil = 1 and GeneralStatus = 0) "
                . "vwTenakerScreeningByPsn_karantina_2022 WHERE  Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }

    function countScreeningTidakLulus(){
        $query = $this->db->query("SELECT HeaderID FROM vwTenakerScreeningByPsn_karantina_2022 WHERE SpecialScreening = 0 and ScreeningComplete = 1 and ScreeningHasil = 0 and GeneralStatus = 1 ORDER BY HeaderID ASC");
        return $query->num_rows();
    }

    function selectScreeningTidakLulus($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
                . "* FROM vwTenakerScreeningByPsn_karantina_2022 AS tbl WHERE SpecialScreening = 0 and ScreeningComplete = 1 and ScreeningHasil = 0 and GeneralStatus = 1) "
                . "vwTenakerScreeningByPsn_karantina_2022 WHERE  Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }

    function countScreeningAll(){
        $query = $this->db->query("SELECT HeaderID FROM vwTenakerScreeningByPsn_karantina_2022 ORDER BY HeaderID ASC");
        return $query->num_rows();
    }

    function selectScreeningAll($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
                . "* FROM vwTenakerScreeningByPsn_karantina_2022 AS tbl) "
                . "vwTenakerScreeningByPsn_karantina_2022 WHERE  Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }



    function countScreeningLulusWhere($nama){
        $query = $this->db->query("SELECT HeaderID FROM vwTenakerScreeningByPsn_karantina_2022 WHERE SpecialScreening = 1 and ScreeningComplete = 1 and ScreeningHasil = 1 and GeneralStatus = 0 and Nama LIKE '%".$nama."%' ORDER BY HeaderID ASC");
        return $query->num_rows();
    }

    function selectScreeningLulusWhere($start,$end,$nama){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
                . "* FROM vwTenakerScreeningByPsn_karantina_2022 AS tbl WHERE SpecialScreening = 1 and ScreeningComplete = 1 and ScreeningHasil = 1 and GeneralStatus = 0 and Nama LIKE '%".$nama."%') "
                . "vwTenakerScreeningByPsn_karantina_2022 WHERE  Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }

    function countScreeningTidakLulusWhere($nama){
        $query = $this->db->query("SELECT HeaderID FROM vwTenakerScreeningByPsn_karantina_2022 WHERE SpecialScreening = 0 and ScreeningComplete = 1 and ScreeningHasil = 0 and GeneralStatus = 1 and Nama LIKE '%".$nama."%' ORDER BY HeaderID ASC");
        return $query->num_rows();
    }

    function selectScreeningTidakLulusWhere($start,$end,$nama){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
                . "* FROM vwTenakerScreeningByPsn_karantina_2022 AS tbl WHERE SpecialScreening = 0 and ScreeningComplete = 1 and ScreeningHasil = 0 and GeneralStatus = 1 and Nama LIKE '%".$nama."%') "
                . "vwTenakerScreeningByPsn_karantina_2022 WHERE  Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }

    function countScreeningAllWhere($nama){
        $query = $this->db->query("SELECT HeaderID FROM vwTenakerScreeningByPsn_karantina_2022 WHERE Nama LIKE '%".$nama."%'ORDER BY HeaderID ASC");
        return $query->num_rows();
    }

    function selectScreeningAllWhere($start,$end,$nama){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
                . "* FROM vwTenakerScreeningByPsn_karantina_2022 AS tbl WHERE Nama LIKE '%".$nama."%') "
                . "vwTenakerScreeningByPsn_karantina_2022 WHERE  Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
}

/* End of file m_screening.php */
/* Location: ./application/models/m_screening.php */