<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_screening extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    //======= Screening TIM
    function listTenagaKerja($nowOL, $dept, $isDiv = NULL)
    {
        if ($isDiv == NULL) {
            $where = "AND A.ScreeningComplete IS NULL";
            // $where = "AND ScreeningComplete Is Null AND ((b.kodedivisi = 25 AND AppDivStatus = 1) OR (b.kodedivisi <> 25 OR b.kodedivisi IS NULL))";
        } else if ($isDiv == 2) {
            $where = "AND a.status_p2k3 = 1 AND (AppP2K3Status not in(0,1) OR AppP2K3Status IS NULL)"; //perubahan pada AppP2K3Status,dimana 0 = DisApprove dan 1 = Approve
        } else if ($isDiv == 3) {
            $where = "AND a.status_elc = 1 AND (AppELCStatus <> 1 OR AppELCStatus IS NULL)";
        } else if ($isDiv == 4) {
            $where = "AND a.status_hed = 1 AND (AppHEDStatus <> 1 OR AppHEDStatus IS NULL)";
        } else {
            $where = "AND b.kodedivisi = 25 
                    -- AND ( (a.status_p2k3 = 1 AND AppP2K3Status = 1 AND ( AppDivStatus <> 1 OR AppDivStatus IS NULL )) OR ( a.status_p2k3 = 0 AND a.status_elc = 0  AND ( AppDivStatus <> 1 OR AppDivStatus IS NULL ) )  OR ( a.status_elc = 1 AND AppELCStatus = 1  AND ( AppDivStatus <> 1 OR AppDivStatus IS NULL ) ) OR ( a.status_p2k3 = 0 AND a.status_elc = 1 AND ( AppDivStatus <> 1 OR AppDivStatus IS NULL ) )  )
                    AND (
                        (AppDivStatus <> 1 OR AppDivStatus IS NULL)
                        AND (
                            (a.status_p2k3 = 1 AND AppP2K3Status = 1)
                            OR (a.status_elc = 1 AND AppELCStatus = 1)
                            OR (a.status_hed = 1 AND AppHEDStatus = 1)
                            OR (a.status_p2k3 = 0 AND a.status_elc = 0 AND a.status_hed = 0)
                            OR (a.status_p2k3 = 0 AND a.status_elc = 0 AND a.status_hed = 1)
                            OR (a.status_p2k3 = 0 AND a.status_elc = 1 AND a.status_hed = 0)
                            OR (a.status_p2k3 = 1 AND a.status_elc = 0 AND a.status_hed = 0)
                        )
                    )
                    ";
        }
        //penambahan tgl register per 2022-01-01 
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
                                        d.SKCK,
                                        d.KK,
                                        d.KTP,
                                        d.CV,
                                        d.Lamaran,
                                        d.Ijazah,
                                        d.Transkrip,
                                        d.Vaksin1,
                                        d.Vaksin2,
                                        d.Vaksin3, 
                                        CASE WHEN b.kodedivisi = 25 
                                        THEN 1 
                                        ELSE 0 END AS AppDivNeeded,
                                        a.status_p2k3,
                                        a.status_elc
                                    FROM
                                        tblTrnCalonTenagaKerja a
                                        LEFT JOIN vwListBerkas d ON a.HeaderID = d.HeaderID 
                                        LEFT JOIN ( SELECT DISTINCT DeptKary, kodedivisi FROM vwMstDivisi ) b ON a.DeptTujuan = b.DeptKary
                                        LEFT JOIN vwTrnApprovalAll AS c ON a.TransID = c.DetailID 
                                    WHERE
                                        a.Verified = '1' 
                                        AND a.UdahDiAmbil = '0'
                                        AND a.GeneralStatus = '0'
                                        AND a.RegisteredDate >= '2022-01-01'
                                        AND a.HeaderID NOT IN(SELECT 
                                                                HeaderID 
                                                            FROM 
                                                                tblTrnScreening 
                                                            WHERE 
                                                                Dept = '$dept')
                                        $where
                                    ORDER BY 
                                        a.HeaderID ASC");
        return $query->result();
    }

    function getDetailTK($hdrid)
    {
        return $this->db->get_where('vwTrnCalonTenagaKerja2', array('HeaderID' => $hdrid));
    }

    function simpanScreeningTim($data)
    {
        $this->db->trans_start();
        $this->db->insert('tblTrnScreening', $data);
        $sID = $this->db->insert_id();
        $this->db->trans_complete();
        return $sID;
    }

    function rowTeamScreening()
    {
        $query  = $this->db->query("SELECT * FROM tblMstDeptScreening");
        return $query->num_rows();
    }

    function getHasilScreen($hrdID)
    {
        $this->db->where('HeaderID', $hrdID);
        $q = $this->db->get('tblTrnScreening');
        $row = $this->rowTeamScreening() - 1;
        if ($q->num_rows() == $row) {
            $hasil = 'complite';
        } else {
            $hasil = NULL;
        }
        return $hasil;
    }

    function getHasilLulus($hrdID)
    {
        $this->db->where('HeaderID', $hrdID);
        $this->db->where('Lulus', 1);
        $q = $this->db->get('tblTrnScreening');
        $hasil = $q->num_rows();
        return $hasil;
    }
    function getHasilTIdakLulus($hrdID)
    {
        $this->db->where('HeaderID', $hrdID);
        $this->db->where('Lulus', 0);
        $q = $this->db->get('tblTrnScreening');
        $hasil = $q->num_rows();
        return $hasil;
    }

    function updateLulus($hrdID, $info)
    {
        $this->db->where('HeaderID', $hrdID);
        $update = $this->db->update('tblTrnCalonTenagaKerja', $info);

        if ($update) {
            return true;
        } else {
            return false;
        }
    }


    //================================== Screening PSN ==========================================
    function listTKScreenedTim()
    {

        /* 
        * Screening By PSN :
        1. kalau nggak diceklist p2k3 atau To ELC dan bukan divisi Utility selesai nilai di technical description dan screening by tim langsung masuk ke screening by psn
        2. Kalau identifikasi by PSN deptnya divisi utility maka setelah dinilai,screening by tim tapi belum approval divisi. maka belum masuk ke screening by PSN harus diapprval divisi dulu baru masuk ke screening by PSN
        3. Kalau Identifikasi di ceklist p2k3, setelah selesai dinilai dan screening by tim tapi belum diapproval p2k3, belum masuk ke screening by PSN. Harus diapproval P2K3 baru  masuk ke screening by PSN
        4. Kalau Identifikasi di ceklist To ELC, setelah selesai dinilai dan screening by tim tapi belum diapproval ELC, belum masuk ke screening by PSN. Harus diapproval ELC baru  masuk ke screening by PSN
        5. Kalau Identifikasi ke Dept Divisi Utility dan p2k3. setelah selesai dinilai dan screening by tim tapi belum diapproval p2k3 dan approval divisi, belum masuk ke screening by PSN. Harus diapproval P2K3 dan divisi baru  masuk ke screening by PSN
        6. Kalau Identifikasi ke Dept Divisi Utility dan To ELC. setelah selesai dinilai dan screening by tim tapi belum diapproval To ELC dan approval divisi, belum masuk ke screening by PSN. Harus diapproval ELC dan divisi baru  masuk ke screening by PSN
        7. Kalau Identifikasi ke all dept dan diceklist To HED. Setelah selesai dinilai dan screening by tim tapo belum approval To HED maka belum masuk ke Screening By PSN. Harus diapproval HED baru masuk ke screening by PSN
        */

        $query = $this->db->query("WITH CTE AS (
                                            -- Divisi Utility
                                            -- SELECT 'HED' AS DeptAbbr
                                            -- UNION ALL SELECT 'TBN'
                                            -- UNION ALL SELECT 'BMD'
                                            -- UNION ALL SELECT 'CAC'
                                            -- UNION ALL SELECT 'DWP'
                                            -- UNION ALL SELECT 'ELC'
                                            -- UNION ALL SELECT 'IPL'
                                            -- UNION ALL SELECT 'PRU'
                                            -- UNION ALL SELECT 'PWH'
                                            -- UNION ALL SELECT 'WTD'
                                            SELECT
                                            deptabbr as DeptAbbr
                                            FROM
                                            Personalia.dbo.vwDeptdanDivisi 
                                            WHERE
                                            NamaDivisi = 'UTILITY'
                                            )
                                                
                                                
                                            SELECT DISTINCT
                                                a.*,
                                                b.KTP,
                                                b.CV,
                                                b.Lamaran,
                                                b.Ijazah,
                                                b.SKCK,
                                                b.Transkrip,
                                                b.Vaksin1,
                                                b.Vaksin2,
                                                b.Vaksin3
                                            FROM vwTenakerForScreenPSN_karantina a
                                            INNER JOIN vwListBerkas b 
                                                ON b.HdrID = a.HeaderID
                                            WHERE
                                                a.ScreeningComplete = 1
                                                AND (

                                                    -- Tidak Utility, tidak P2K3, tidak ELC, tidak HED, dan sudah wawancara hasil
                                                    ( 
                                                        a.DeptTujuan NOT IN (SELECT DeptAbbr FROM CTE)
                                                        AND (ISNULL(a.status_p2k3,0) = 0 AND ISNULL(a.status_elc,0) = 0 AND ISNULL(a.status_hed,0) = 0)         
                                                        AND a.WawancaraHasil IS NOT NULL
                                                    )

                                                    OR
                                            -- 
                                            --         -- Utility saja
                                                    (
                                                        a.DeptTujuan IN (SELECT DeptAbbr FROM CTE)
                                                        AND ISNULL(a.AppDivStatus,0) = 1
                                                        AND ISNULL(a.AppP2K3Status,0) = 0
                                                        AND ISNULL(a.AppELCStatus,0) = 0
                                                        AND ISNULL(a.AppHEDStatus,0) = 0
                                                    )
                                            -- 
                                                    OR
                                            -- 
                                                    -- P2K3
                                                    (
                                                        ISNULL(AppP2K3Status,0) = 1 
                                                        AND ISNULL(AppELCStatus,0) = 0 
                                                        AND ISNULL(AppDivStatus,0) = 0
                                                        AND ISNULL(a.AppHEDStatus,0) = 0

                                                        AND a.DeptTujuan NOT IN (SELECT DeptAbbr FROM CTE)
                                                    )
                                            -- 
                                                    OR

                                                    -- ELC
                                                    (
                                                        ISNULL(AppP2K3Status,0) = 0 
                                                        AND ISNULL(AppELCStatus,0) = 1 
                                                        AND ISNULL(AppDivStatus,0) = 0
                                                        AND ISNULL(a.AppHEDStatus,0) = 0
                                                        AND a.DeptTujuan NOT IN (SELECT DeptAbbr FROM CTE)
                                                    )

                                                    OR
                                                    -- HED
                                                    (
                                                        ISNULL(AppP2K3Status,0) = 0 
                                                        AND ISNULL(AppELCStatus,0) = 0 
                                                        AND ISNULL(AppDivStatus,0) = 0
                                                        AND ISNULL(a.AppHEDStatus,0) = 1
                                                        -- AND a.DeptTujuan NOT IN (SELECT DeptAbbr FROM CTE)
                                                    )
                                            -- 
                                                    OR

                                                    -- Utility + P2K3
                                                    (
                                                        a.DeptTujuan IN (SELECT DeptAbbr FROM CTE)
                                                        AND ISNULL(a.AppDivStatus,0) = 1
                                                        AND ISNULL(a.AppP2K3Status,0) = 1
                                                    )
                                            -- 
                                                    OR

                                                    -- Utility + ELC
                                                    (
                                                        a.DeptTujuan IN (SELECT DeptAbbr FROM CTE)
                                                        AND ISNULL(a.AppDivStatus,0) = 1
                                                        AND ISNULL(a.AppELCStatus,0) = 1
                                                    )
                                                    OR

                                                    -- Utility + HED
                                                    (
                                                        a.DeptTujuan IN (SELECT DeptAbbr FROM CTE)
                                                        AND ISNULL(a.AppDivStatus,0) = 1
                                                        AND ISNULL(a.AppHEDStatus,0) = 1
                                                    )
                                                    OR

                                                    -- P2K3 + HED
                                                    (
                                                        a.DeptTujuan IN (SELECT DeptAbbr FROM CTE)
                                                        AND ISNULL(a.AppP2K3Status,0) = 1
                                                        AND ISNULL(a.AppHEDStatus,0) = 1
                                                    )
                                                    OR

                                                    -- ELC + HED
                                                    (
                                                        a.DeptTujuan IN (SELECT DeptAbbr FROM CTE)
                                                        AND ISNULL(a.AppELCStatus,0) = 1
                                                        AND ISNULL(a.AppHEDStatus,0) = 1
                                                    )

                                                ) ORDER BY HeaderID ASC;");

        return $query->result();
    }
    function listTKScreenedTim_backup()
    {


        $query = $this->db->query("SELECT DISTINCT
                                        a.*,
                                        b.KTP,
                                        b.CV,
                                        b.Lamaran,
                                        b.Ijazah,
                                        b.SKCK,
                                        b.Transkrip,
                                        b.Vaksin1,
                                        b.Vaksin2,
                                        b.Vaksin3 
                                    FROM
                                        vwTenakerForScreenPSN_karantina AS a
                                        
                                        INNER JOIN vwListBerkas AS b ON b.HdrID= a.HeaderID 
                                    WHERE
                                        ( AppDivStatus = 1 AND A.ScreeningComplete = 1 AND a.DeptTujuan = 'HED')
                                        OR ( AppDivStatus = 1 AND A.ScreeningComplete = 1 AND a.DeptTujuan != 'HED') 
                                        OR ( AppP2K3Status = 1 AND A.ScreeningComplete = 1 AND a.DeptTujuan != 'HED') 
                                        OR (A.ScreeningComplete = 1 AND a.DeptTujuan <> 'HED' AND a.DeptTujuan <> 'TBN' AND a.DeptTujuan <> 'BLR' AND a.DeptTujuan <>'BMD' AND a.DeptTujuan <> 'CAC' 
                                        AND a.DeptTujuan <> 'DWP' AND a.DeptTujuan <> 'ELC' AND a.DeptTujuan <> 'IPAL' AND a.DeptTujuan <> 'PRU' AND a.DeptTujuan <> 'PWH' AND a.DeptTujuan <> 'WTD')
                                    ORDER BY
                                        HeaderID ASC");

        return $query->result();
    }

    function getDocs($userID)
    {
        $query = $this->db->query("SELECT * FROM tblTrnBerkas WHERE HeaderID='" . $userID . "'");
        return $query->result();
    }

    function resultScreen($hdrid)
    {
        return $this->db->get_where('tblTrnScreening', array('HeaderID' => $hdrid));
    }

    function resultInterview($hdrid)
    {
        return $this->db->get_where('tblTrnWawancara', array('HeaderID' => $hdrid));
    }

    function screenByPsn($hrdID, $info)
    {
        $this->db->where('HeaderID', $hrdID);
        $this->db->update('tblTrnCalonTenagaKerja', $info);
    }





    function countScreeningLulus()
    {
        $query = $this->db->query("SELECT HeaderID FROM vwTenakerScreeningByPsn_karantina_2022 WHERE SpecialScreening = 1 and ScreeningComplete = 1 and ScreeningHasil = 1 and GeneralStatus = 0 ORDER BY HeaderID ASC");
        return $query->num_rows();
    }

    function selectScreeningLulus($start, $end)
    {
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
            . "* FROM vwTenakerScreeningByPsn_karantina_2022 AS tbl WHERE SpecialScreening = 1 and ScreeningComplete = 1 and ScreeningHasil = 1 and GeneralStatus = 0) "
            . "vwTenakerScreeningByPsn_karantina_2022 WHERE  Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }

    function countScreeningTidakLulus()
    {
        $query = $this->db->query("SELECT HeaderID FROM vwTenakerScreeningByPsn_karantina_2022 WHERE SpecialScreening = 0 and ScreeningComplete = 1 and ScreeningHasil = 0 and GeneralStatus = 1 ORDER BY HeaderID ASC");
        return $query->num_rows();
    }

    function selectScreeningTidakLulus($start, $end)
    {
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
            . "* FROM vwTenakerScreeningByPsn_karantina_2022 AS tbl WHERE SpecialScreening = 0 and ScreeningComplete = 1 and ScreeningHasil = 0 and GeneralStatus = 1) "
            . "vwTenakerScreeningByPsn_karantina_2022 WHERE  Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }

    function countScreeningAll()
    {
        $query = $this->db->query("SELECT HeaderID FROM vwTenakerScreeningByPsn_karantina_2022 ORDER BY HeaderID ASC");
        return $query->num_rows();
    }

    function selectScreeningAll($start, $end)
    {
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
            . "* FROM vwTenakerScreeningByPsn_karantina_2022 AS tbl) "
            . "vwTenakerScreeningByPsn_karantina_2022 WHERE  Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }



    function countScreeningLulusWhere($nama)
    {
        $query = $this->db->query("SELECT HeaderID FROM vwTenakerScreeningByPsn_karantina_2022 WHERE SpecialScreening = 1 and ScreeningComplete = 1 and ScreeningHasil = 1 and GeneralStatus = 0 and Nama LIKE '%" . $nama . "%' ORDER BY HeaderID ASC");
        return $query->num_rows();
    }

    function selectScreeningLulusWhere($start, $end, $nama)
    {
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
            . "* FROM vwTenakerScreeningByPsn_karantina_2022 AS tbl WHERE SpecialScreening = 1 and ScreeningComplete = 1 and ScreeningHasil = 1 and GeneralStatus = 0 and Nama LIKE '%" . $nama . "%') "
            . "vwTenakerScreeningByPsn_karantina_2022 WHERE  Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }

    function countScreeningTidakLulusWhere($nama)
    {
        $query = $this->db->query("SELECT HeaderID FROM vwTenakerScreeningByPsn_karantina_2022 WHERE SpecialScreening = 0 and ScreeningComplete = 1 and ScreeningHasil = 0 and GeneralStatus = 1 and Nama LIKE '%" . $nama . "%' ORDER BY HeaderID ASC");
        return $query->num_rows();
    }

    function selectScreeningTidakLulusWhere($start, $end, $nama)
    {
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
            . "* FROM vwTenakerScreeningByPsn_karantina_2022 AS tbl WHERE SpecialScreening = 0 and ScreeningComplete = 1 and ScreeningHasil = 0 and GeneralStatus = 1 and Nama LIKE '%" . $nama . "%') "
            . "vwTenakerScreeningByPsn_karantina_2022 WHERE  Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }

    function countScreeningAllWhere($nama)
    {
        $query = $this->db->query("SELECT HeaderID FROM vwTenakerScreeningByPsn_karantina_2022 WHERE Nama LIKE '%" . $nama . "%'ORDER BY HeaderID ASC");
        return $query->num_rows();
    }

    function selectScreeningAllWhere($start, $end, $nama)
    {
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
            . "* FROM vwTenakerScreeningByPsn_karantina_2022 AS tbl WHERE Nama LIKE '%" . $nama . "%') "
            . "vwTenakerScreeningByPsn_karantina_2022 WHERE  Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }
}

/* End of file m_screening.php */
/* Location: ./application/models/m_screening.php */