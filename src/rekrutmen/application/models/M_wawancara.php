<?php

/* 
 * Author by ITD15
 */

class M_wawancara extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // ============================ TUJUAN WAWANCARA =================
    function getCVNama()
    {
        $query = $this->db->query("SELECT DISTINCT(CVNama) FROM tblTrnCalonTenagaKerja WHERE GeneralStatus = 0 AND Verified = 1 AND DeptTujuan IS NULL ORDER BY CVNama DESC");
        return $query->result();
    }

    function getTenagaKerja()
    {
        $query = $this->db->query("SELECT 
                                    TOP 800
                                        * 
                                    FROM
                                        tblTrnCalonTenagaKerja 
                                    WHERE
                                        tblTrnCalonTenagaKerja.GeneralStatus = '0' 
                                        AND tblTrnCalonTenagaKerja.Verified = '1' 
                                        AND tblTrnCalonTenagaKerja.DeptTujuan IS NULL 
                                        -- AND tblTrnCalonTenagaKerja.CVNama = 'PT PULAU SAMBU' 
                                    ORDER BY
                                        HeaderID DESC");
        return $query->result();
    }
    function getTenagaKerja_($filter_status2)
    {
        $query = $this->db->query("SELECT
                                        * 
                                    FROM
                                        tblTrnCalonTenagaKerja 
                                    WHERE
                                        tblTrnCalonTenagaKerja.GeneralStatus = '0' 
                                        AND tblTrnCalonTenagaKerja.Verified = '1' 
                                        AND tblTrnCalonTenagaKerja.DeptTujuan IS NULL 
                                        -- AND tblTrnCalonTenagaKerja.cancel_status IS NULL -- baru ditambahkan 05/07/2025
                                        AND tblTrnCalonTenagaKerja.CVNama = '" . $filter_status2 . "' 
                                    ORDER BY
                                        HeaderID ASC");
        return $query->result();
    }
    function getDepartment()
    {
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL WHERE GeneralStatus = 1 ");
        // $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalAll_new WHERE GeneralStatus = 1 ");
        return $query->result();
    }
    function getDepartment2($jenis)
    {   // Query asli
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL WHERE Pemborong='$jenis' and  GeneralStatus = 1 ");
        // Batas Query asli   
        // $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalAll_new WHERE Pemborong='$jenis' and  GeneralStatus = 1 ");
        //  Diubah sementara untuk menampilkan dept RMP
        // $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL_temp_v2 WHERE Pemborong='$jenis' and  GeneralStatus = 1 ");
        return $query->result();
    }
    function getDept($idDetail)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL WHERE DetailID = '" . $idDetail . "'");
        // $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalAll_new WHERE DetailID = '" . $idDetail . "'");
        return $query->result();
    }
    function quota($transID)
    {
        $query = $this->db->query("SELECT TransID, COUNT(HeaderID) AS Quota FROM tblTrnCalonTenagaKerja WHERE "
            . "TransID = " . $transID . " AND TransID Is Not NULL GROUP BY TransID");
        return $query->result();
    }

    function updateDeptTujuan($hdrID, $data)
    {
        $this->db->trans_start();
        $this->db->where('HeaderID', $hdrID);
        $this->db->update('tblTrnCalonTenagaKerja', $data);
        $this->db->trans_complete();
    }
    function updateTempMinta($detailID, $temp)
    {
        $this->db->trans_start();
        $this->db->where('DetailID', $detailID);
        $this->db->update('tblTrnRequest', array('TempSetTenaker' => $temp));
        $this->db->trans_complete();
    }

    function getDetailTK($hdrid)
    {
        return $this->db->get_where('tblTrnCalonTenagaKerja', array('HeaderID' => $hdrid));
    }

    function getDetailTenaker($hdrid)
    {
        // return $this->db->get_where('vwTenakerForInterview', array('HeaderID' => $hdrid));
        $query = $this->db->query("SELECT
                                        A.HeaderID,
                                        A.Nama,
                                        A.DeptTujuan,
                                        A.Jenis_Kelamin,
                                        A.Pendidikan,
                                        B.JabatanName,
                                        C.DeptAbbr ,
                                        A.TransID 
                                    FROM
                                        dbo.tblTrnCalonTenagaKerja A
                                        LEFT JOIN  dbo.tblTrnWawancara B ON A.HeaderID = B.HeaderID
                                        INNER JOIN dbo.vwTrnApprovalAll C ON A.TransID = C.DetailID 
                                        WHERE A.HeaderID = '$hdrid'");
        return $query;
        // return $this->db->get_where('vwTenakerForInterview_temp', array('HeaderID' => $hdrid));
    }

    //=============== PROSES WAWANCARA HARIAN==============
    function getKualifikasiDasar()
    {
        $query = $this->db->query("SELECT * FROM tblMstListKualifikasi");
        return $query->result();
    }

    function getTenakerHarian()
    {
        $grupID = $this->session->userdata('groupuser');
        // var_dump($grupID); die;
        // 
        if ($grupID == '29') { //Kondisi Hidden Overtime khusus
            $query = $this->db->query("SELECT datediff(day,SendedDate,GETDATE()) as overtime,*
                                            FROM
                                                vwTenakerForInterview 
                                            WHERE
                                                GeneralStatus = 0 
                                                AND Pemborong != 'YAO HSING' 
                                                AND Pemborong <> 'PT PULAU SAMBU'
                                                AND WawancaraHasil IS NULL 
                                                AND DeptID IN ( SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = " . $grupID . " ) AND datediff(day,SendedDate,GETDATE()) <= 6");
        } else {
            $query = $this->db->query("SELECT 
                                        * 
                                    FROM 
                                        -- Diubah sementara untuk menampilkan dept RMP
                                        -- vwTenakerForInterview_temp 
                                        vwTenakerForInterview 
                                    WHERE 
                                        GeneralStatus = 0 
                                        AND Pemborong != 'YAO HSING' 
                                        AND Pemborong <> 'PT PULAU SAMBU'
                                        AND WawancaraHasil Is NULL 
                                        AND DeptID IN (SELECT 
                                                        DISTINCT DeptID 
                                                    FROM 
                                                        -- Diubah sementara untuk menampilkan dept RMP
                                                        -- vwTrnDeptWawancara_temp 
                                                        vwTrnDeptWawancara 
                                                    WHERE 
                                                        GroupID =" . $grupID . " AND tipe = 'ALL PEMBORONG')");
        }

        //echo $this->db->last_query();
        return $query->result();
    }
    function cekMP($HrdID)
    {
        $kondisi    = 0;
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE HeaderID = '" . $HrdID . "' AND DeptTujuan LIKE 'MP%'");
        if ($query->num_rows() > 0) {
            $kondisi = 1;
        } else {
            $kondisi = 0;
        }
        return $kondisi;
    }
    function getPekerjaan($department)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM vwMsrPekerjaanDept WHERE DeptAbbr = '" . $department . "'");
        return $query->result();
    }
    function getPekerjaanGO()
    {
        //         $query = $this->db->query("SELECT  DISTINCT b.DeptID, b.DeptAbbr, a.IDPekerjaan, a.Pekerjaan, b.BagianIDBorongan
        // FROM [192.168.3.32].PSGBorongan.dbo.tblMstPekerjaan AS a INNER JOIN dbo.tblMstDepartemenNew AS b ON a.IDPekerjaan = b.BagianIDBorongan WHERE b.DeptAbbr LIKE '%MP%'");

        // $query = $this->db->query("SELECT  DISTINCT b.DeptID, b.DeptAbbr, a.IDPekerjaan, a.Pekerjaan, b.BagianIDBorongan
        // FROM [192.168.3.32].PSGBorongan.dbo.tblMstPekerjaan AS a INNER JOIN dbo.tblMstDepartemenNew AS b ON a.IDPekerjaan = b.BagianIDBorongan");

        $query = $this->db->query("SELECT * from [192.168.3.32].PSGBorongan.dbo.tblMstPekerjaan");

        return $query->result();
    }

    function getSubPekerjaan()
    {
        $query = $this->db->query("SELECT * FROM [192.168.3.32].PSGBorongan.dbo.tblMstSubPekerjaan ORDER BY SubPekerjaan");
        return $query->result();
    }

    function getJabatan()
    {
        $query = $this->db->query("SELECT  A.Jabatan as Pekerjaan, A.* FROM [192.168.3.32].PSGBorongan.dbo.tblMstJabatan A ");
        return $query->result();
    }

    function getSubJabatan($idJabatan, $dept)
    {

        if ($dept == 'TBN' || $dept == 'PWH') {
            $dept = 'PWP';
        }

        if ($dept == 'CPW' || $dept == 'PIW' || $dept == 'PCW') {
            $dept = 'CWR';
        }

        $query = $this->db->query("SELECT
                                        B.DeptAbbr,
                                        A.SubjabatanName AS SubPekerjaan,
                                        A.* 
                                    FROM
                                        [192.168.3.32].PSGBorongan.dbo.tblMstSubJabatan A
                                    LEFT JOIN [192.168.3.32].PSGBorongan.dbo.tblMstDepartemen B ON A.IDDept = B.IDDept
                                    WHERE B.DeptAbbr = '$dept'
                                    AND A.IDJabatan = '$idJabatan'
                                    ORDER BY
                                        A.SubJabatanName;");
        return $query->result();
    }

    function getSubJabatan_($idJabatan, $dept)
    {

        // if ($dept == 'TBN' || $dept == 'PWH') {
        //     $dept = 'PWP';
        // }
        if ($dept == 'PWH') {
            $dept = 'PWP';
        }

        if ($dept == 'CPW' || $dept == 'PIW' || $dept == 'PCW') {
            $dept = 'CWR';
        }

        $query = $this->db->query("SELECT DISTINCT
                                    A.SubJabatanTk,
                                    B.IDSubJabatan,
                                    B.SubJabatanAbbr AS SubJabatanName,
                                    A.DeptAbbr,
                                    B.IDJabatan 
                                    FROM
                                    vwIdealKryTk_new A
                                    LEFT JOIN [192.168.3.32].PSGBorongan.dbo.tblMstSubJabatan B ON A.IDSubJabatan_Bor = B.IDSubJabatan 
                                    WHERE
                                    A.SubJabatanTk IS NOT NULL 
                                    AND B.IDSubJabatan IS NOT NULL 
                                    AND A.Deptabbr = '$dept' 
                                    AND B.IDJabatan = '$idJabatan'  
                                    GROUP BY
                                    A.SubJabatanTk,
                                    B.IDSubJabatan,
                                    B.SubJabatanAbbr,
                                    A.DeptAbbr,
                                    B.IDJabatan 
                                    ORDER BY
                                    A.SubJabatanTk
                                    ");
        return $query->result();
    }

    function getLiburMingguan()
    {
        $query = $this->db->query("SELECT  * FROM [192.168.3.32].PSGBorongan.dbo.tblMstLiburMingguan");
        return $query->result();
    }

    function getPekerjaanHarian()
    {
        $query = $this->db->query("SELECT * FROM [192.168.3.32].PSGBorongan.dbo.tblMstPekerjaan ");
        return $query->result();
    }

    function getHasil($hrdID)
    {
        $query = $this->db->query("SELECT AVG(RataNilai) AS Total FROM tblTrnWawancara WHERE HeaderID =" . $hrdID);
        return $query->result();
    }


    //=============== PROSES WAWANCARA STRATA==============
    function getKualifikasiKaryawan()
    {
        $query = $this->db->query("SELECT * FROM tblMstListKualifikasiKaryawan");
        return $query->result();
    }
    function getKualifikasiSMU()
    {
        $query = $this->db->query("SELECT * FROM tblMstListKualifikasiKaryawanSMU");
        return $query->result();
    }

    function getTenaker()
    {
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM vwTenakerForInterview WHERE GeneralStatus = 0 AND Pemborong IN ( 'PT PULAU SAMBU','YAO HSING ')  AND "
            . "WawancaraHasil Is NULL AND DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =" . $grupID . ")");
        return $query->result();
    }


    //=================PROSES WAWANCARA SMU===================
    function getKualifikasiKaryawanSMU()
    {
        $query = $this->db->query("SELECT * FROM tblMstListKualifikasiKaryawan");
        return $query->result();
    }


    // ============================= SIMPAN PROSES WAWANCARA ===================
    function insertWawancara($data)
    {
        $this->db->trans_start();
        $this->db->insert('tblTrnWawancara', $data);
        $wID = $this->db->insert_id();
        $this->db->trans_complete();
        return $wID;
    }

    function insertDetailWawancara($data)
    {
        $this->db->trans_start();
        $this->db->insert('tblTrnWawancaraDetail', $data);
        $this->db->insert_id();
        $this->db->trans_complete();
    }

    function updateWawancaraTenaker($hrdID, $info)
    {
        $this->db->where('HeaderID', $hrdID);
        $this->db->update('tblTrnCalonTenagaKerja', $info);
    }

    function getMstJabatanPayroll()
    {
        $query = $this->db->query("SELECT
                                        * 
                                    FROM
                                        [PSGPayroll].[dbo].[tblMstJabatan] ORDER BY JabatanName ASC");
        return $query->result();
    }

    function getSubJabatanPayroll($id)
    {
        $query = $this->db->query("SELECT
                                        * 
                                    FROM
                                        [PSGPayroll].[dbo].[tblMstSubJabatan] 
                                    WHERE JabatanID = '$id'
                                    ORDER BY SubJabatanName ASC");
        return $query->result();
    }

    function getSubJabatanPayroll_($id)
    {
        $query = $this->db->query(" SELECT
                                    A.SubJabatanKry AS SubJabatanName,
                                    A.IDSubJabatan_Kar AS SubJabatanID,
                                    B.JabatanID 
                                    FROM
                                    vwIdealKryTk_new A
                                    LEFT JOIN [PSGPayroll].[dbo].[tblMstSubJabatan] B ON A.IDSubJabatan_Kar = B.SubJabatanID 
                                    WHERE
                                    A.SubJabatanKry IS NOT NULL 
                                    AND A.IDSubJabatan_Kar IS NOT NULL 
                                    AND B.JabatanID = '$id' 
                                    GROUP BY
                                    A.SubJabatanKry,
                                    A.IDSubJabatan_Kar,
                                    B.JabatanID 
                                    ORDER BY
                                    A.SubJabatanKry");
        return $query->result();
    }

    //============== auto update list interview if > 3 =================

}


/* End of file m_wawancara.php */
/* Location: ./application/controllers/m_wawancara.php */