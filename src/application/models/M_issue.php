<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class M_issue extends MY_Model
{



    function getDept()
    {
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM vwMstDepartemen_new WHERE IDDept IN " . "(SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =" . $grupID . ") ORDER BY DeptAbbr");
        // $query = $this->db->query("SELECT DeptID as IDDept, * FROM PSGPayroll..tblMstDepartemen ORDER BY DeptAbbr");
        // $query = $this->db->query("SELECT
        //                                 * 
        //                             FROM
        //                                 vwMstBagian 
        //                             WHERE
        //                                 IDDeptAll IN ( SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = '$grupID' ) 
        //                                 AND IDDept IS NOT NULL
        //                             ORDER BY
        //                                 BagianAbbr
        //                             ");
        // $query = $this->db->query("SELECT
        //                                 * 
        //                             FROM
        //                                 vwMstBagian 
        //                             WHERE
        //                                 IDDeptAll IN ( SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = '$grupID' ) 
        //                                 AND IDBagian NOT IN ( '16', '56', '57', '27', '64', '65', '66', '67', '74', '68' ) 
        //                                 AND IDDept IS NOT NULL 
        //                             ORDER BY
        //                                 BagianAbbr
        //                             ");
        // $query = $this->db->query("SELECT
        //                                 * 
        //                             FROM
        //                                 [192.168.3.32].PSGBorongan.dbo.tblMstDepartemen
        //                             WHERE
        //                                 IDDept IN ( SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = '$grupID' ) 
        //                                 AND IDBagian IS NOT NULL
        //                             ORDER BY
        //                                 DeptAbbr
        //                             ");
        // $query = $this->db->query("SELECT
        //                                 * 
        //                             FROM
        //                                 vwMstBagian 
        //                             WHERE
        //                                 IDDept IN ( SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = '93' ) 
        //                                 AND IDBagian NOT IN ( '16', '56', '57', '27', '64', '65', '66', '67', '74', '68', '47', '77' ) 
        //                                 AND IDDept IS NOT NULL 
        //                             ORDER BY
        //                                 BagianAbbr
        //                             ");
        return $query->result();
    }

    function getPekerjaan($dept)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM vwMstPekerjaanDept WHERE IDDept = '" . $dept . "'");
        return $query->result();
    }

    function getJabatan()
    {
        $query = $this->db->query("SELECT DISTINCT * FROM tblMstJabatan WHERE Jabatan <> 'TRAINEE' ORDER BY Jabatan ");
        return $query->result();
    }

    function getPemborong()
    {
        $query = $this->db->query("SELECT * FROM [192.168.3.32].PSGBorongan.dbo.tblMstPerusahaan ");
        return $query->result();
    }
    function getPemborongKaryawan()
    {
        $query = $this->db->query("SELECT * FROM vwMstPemborong WHERE Pemborong = 'RSUP' ");
        return $query->result();
    }

    function getStatusKawin()
    {
        $query = $this->db->get('tblMstStatusKawin');
        return $query->result();
    }

    function getPendidikan()
    {
        $query = $this->db->get('tblMstPendidikan');
        return $query->result();
    }

    function getJurusan()
    {
        $query = $this->db->get('tblMstJurusan');
        return $query->result();
    }

    function getPemborongAll()
    {
        $query = $this->db->query("SELECT * FROM vwMstPemborong ORDER BY Pemborong ASC");
        return $query->result();
    }
    function setInfoTran($id)
    {
        $query = $this->db->query("SELECT * FROM vwTrnApprovalAll WHERE DetailID = '" . $id . "'");
        return $query->result();
    }
    function setInfoTranEdit($id)
    {
        $query = $this->db->query("SELECT * FROM vwTrnApprovalAll WHERE DetailID = '" . $id . "'");
        return $query;
    }

    function saveIssue($data)
    {
        $this->db->trans_start();
        $this->db->insert('tblTrnRequest', $data);
        $this->db->trans_complete();
    }

    function isValidPermintaanBorongan($data)
    {
        // sementara 56 adalah id cwc baru 46 adalah id cwc lama yang sudah masuk di database, nanti diperbaiki rian.
        if ($data['DeptID'] == 56) {
            $data['DeptID'] = 46;
        }

        if ($data['DeptID'] == 35 || $data['DeptID'] == 40 || $data['DeptID'] == 39) { // PIW, PCW, CPW
            $data['DeptID'] = 67;
        }

        if ($data['DeptID'] == 31 || $data['DeptID'] == 24) { // TBN, PWH
            $data['DeptID'] = 58;
        }
        $ierror = 0;
        $ids = strval($data['SubJabatanID']);
        $deptId = $data['DeptID'];
        // print_r($data);
        // print_r($ids);
        // die;

        // $sql = ' SELECT DISTINCT k.*,totalpermintaan =  ' .
        //     " (SELECT  Permintaan = ISNULL(SUM(TKPermintaan),0) FROM vwTrnApprovalALL WHERE Pemborong='ALL PEMBORONG' and (GeneralStatus = 1 OR  GeneralStatus is null) " .
        //     ' AND DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara) ' .
        //     ' AND DeptID=' .  $data['DeptID'] . ') ' .
        //     'FROM vwIdealKryTk  k ' .
        //     'where deptbor=' . $data['DeptID'] . 'order by Periode desc';
        // $sql = ' SELECT DISTINCT k.*,totalpermintaan =  ' .
        //     " (SELECT  Permintaan = ISNULL(SUM(TKPermintaan),0) FROM vwTrnApprovalALL WHERE Pemborong='ALL PEMBORONG' and (GeneralStatus = 1 OR  GeneralStatus is null) " .
        //     ' AND DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara) ' .
        //     ' AND DeptID=' .  $data['DeptID'] . ' AND IDSubJabatan = $ids) ' .
        //     'FROM vwIdealKryTk_bor  k ' .
        //     'where deptbor=' . $data['DeptID'] . ' AND ID = $ids order by Periode desc';
        $sql = "SELECT DISTINCT
                    k.*,
                    totalpermintaan = (
                        SELECT
                        Permintaan = ISNULL(SUM(TKPermintaan), 0) 
                        FROM
                        vwTrnApprovalALL 
                        WHERE
                        Pemborong = 'ALL PEMBORONG' 
                        AND (GeneralStatus = 1 OR GeneralStatus IS NULL) 
                        AND DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara) 
                        AND DeptID = $deptId
                    AND IDSubJabatan = '$ids') 
                    FROM
                    vwIdealKryTk_bor k 
                    WHERE
                    deptbor = $deptId 
                    AND IDSubJabatan = '$ids' 
                    ORDER BY
                    Periode DESC";
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
        // print_r($row->IBor);
        // die;
        if ($data['TKPermintaan'] <= 0) {
            return array('error' => 2);
        } elseif ($data['TKPermintaan'] > $kebutuhan) {
            $iserror = 1;
            return array('psb' => $row->totalpermintaan, 'jp' => $kebutuhan, 'error' => $iserror);
        } else {
            return array('error' => 0);
        }
    }

    function isValidPermintaanBorongan_($data)
    {
        if ($data['DeptID'] == 35 || $data['DeptID'] == 40 || $data['DeptID'] == 39) { // PIW, PCW, CPW
            $data['DeptID'] = 67;
        }
        if ($data['DeptID'] == 31 || $data['DeptID'] == 24) { // TBN, PWH
            $data['DeptID'] = 58;
        }

        $ids = strval($data['SubJabatanID']);
        $deptId = $data['DeptID'];
        $id_target_bongkar = $data['id_target_bongkar'];
        $sql = "SELECT DISTINCT
                    k.*,
                    totalpermintaan = (
                        SELECT
                        Permintaan = ISNULL(SUM(TKPermintaan), 0) 
                        FROM
                        vwTrnApprovalALL 
                        WHERE
                        Pemborong = 'ALL PEMBORONG' 
                        AND (GeneralStatus = 1 OR GeneralStatus IS NULL) 
                        AND DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara) 
                        AND DeptID = $deptId
                    AND IDSubJabatan = '$ids') 
                    FROM
                    vwIdealKryTk_new k 
                    WHERE
                    DeptIDBor = $deptId 
                    AND IDSubJabatan_Bor = '$ids' 
                    AND id_master_bongkar_kelapa = '$id_target_bongkar'
                    ORDER BY
                    Periode DESC";

        $query = $this->db->query($sql);
        $row = $query->row();
        $kebutuhan = $row->IKry - ($row->TotalKryTk + $row->totalpermintaan);

        if ($data['TKPermintaan'] <= 0) {
            return array('error' => 2);
        } elseif ($data['TKPermintaan'] > $kebutuhan) {
            $iserror = 1;
            return array('psb' => $row->totalpermintaan, 'jp' => $kebutuhan, 'error' => $iserror);
        } else {
            return array('error' => 0);
        }
    }

    function isValidPermintaanKaryawan($data)
    {
        $ierror = 0;

        $sql = 'SELECT k.*,totalpermintaan =  ' .
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

        $query = $this->exec_sql('getValidPermintaanKaryawan', array($data['DeptID']));
        $row = $query->row();
        $kebutuhan = $row->IKry - ($row->RKry + $row->totalpermintaan);
        if ($data['TKPermintaan'] <= 0) {
            return array('error' => 2);
        } elseif ($data['TKPermintaan'] > $kebutuhan) {
            $iserror = 1;
            return array('psb' => $row->totalpermintaan, 'jp' => $kebutuhan, 'error' => $iserror);
        } else {
            return array('error' => 0);
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
    function isValidPermintaanKaryawan_($data)
    {
        $ierror = 0;

        $sql = 'SELECT k.*,totalpermintaan =  ' .
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

        $query = $this->exec_sql('getValidPermintaanKaryawan_', array($data['DeptID']));
        $row = $query->row();
        $kebutuhan = $row->IKry - ($row->RKry + $row->totalpermintaan);
        // $kebutuhan = 60;
        if ($data['TKPermintaan'] <= 0) {
            return array('error' => 2);
        } elseif ($data['TKPermintaan'] > $kebutuhan) {
            $iserror = 1;
            return array('psb' => $row->totalpermintaan, 'jp' => $kebutuhan, 'error' => $iserror);
        } else {
            return array('error' => 0);
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

    function isValidPermintaanKaryawan_new($data)
    {
        $ierror = 0;
        $ids = strval($data['SubJabatanID']);
        $deptId = $data['DeptID'];
        $id_target_bongkar = $data['id_target_bongkar'];
        if ($deptId == 46) { // TBN,
            $deptId = 69; // PWP
        }
        $sql = "SELECT DISTINCT
                    k.*,
                    totalpermintaan = (
                        SELECT
                        Permintaan = ISNULL(SUM(TKPermintaan), 0) 
                        FROM
                        vwTrnApprovalALL 
                        WHERE
                        Pemborong = 'PSG' 
                        AND (GeneralStatus = 1 OR GeneralStatus IS NULL) 
                        AND DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara) 
                        AND DeptID = $deptId
                    AND IDSubJabatan = '$ids') 
                    FROM
                    vwIdealKryTk_new k 
                    WHERE
                    DeptID = $deptId 
                    AND IDSubJabatan_Kar = '$ids' 
                    AND id_master_bongkar_kelapa = '$id_target_bongkar'
                    ORDER BY
                    Periode DESC";


        $query = $this->db->query($sql);
        $row = $query->row();
        $kebutuhan = $row->IKry - ($row->TotalKryTk + $row->totalpermintaan);
        // $kebutuhan = 60;
        if ($data['TKPermintaan'] <= 0) {
            return array('error' => 2);
        } elseif ($data['TKPermintaan'] > $kebutuhan) {
            $iserror = 1;
            return array('psb' => $row->totalpermintaan, 'jp' => $kebutuhan, 'error' => $iserror);
        } else {
            return array('error' => 0);
        }
    }

    function getIssue()
    {
        $query = $this->db->query("SELECT * FROM vwTrnApprovalAll WHERE GeneralStatus = 1 ");
        return $query->result();
    }

    function updateTran($id, $data)
    {
        $this->db->trans_start();
        $this->db->where('DetailID', $id);
        $this->db->update('tblTrnRequest', $data);
        $this->db->trans_complete();
    }

    function getdatakuotakry($id)
    {
        $this->db->where('deptbor', $id);
        $this->db->order_by('periode', 'desc');
        $query = $this->db->get('vwIdealKryTk');
        $row = $query->row();

        //----- cek tabel kuota
        //$this->db->where('krydeptname',$deptabbr);
        //$query = $this->db->get('vwKuotaKryTK');
        //$row = $query->row();
        return $row;
    }

    function getdatakuotakry_($id)
    {
        $this->db->where('deptbor', $id);
        $this->db->order_by('periode', 'desc');
        $query = $this->db->get('vw_idealtkkry');
        $row = $query->row();

        //----- cek tabel kuota
        //$this->db->where('krydeptname',$deptabbr);
        //$query = $this->db->get('vwKuotaKryTK');
        //$row = $query->row();
        return $row;
    }

    function getdatakuotakry_new($id, $subJabatanID, $id_targetBongkar)
    {
        if ($id == 46) { // TBN, PWH
            $id = 69;
        }
        // if ($id == 35 || $id == 40 || $id == 39) { // PIW, PCW, CPW
        //     $id = 67;
        // }
        // if ($id == 56) { //cwc
        //     $id = 46;
        // }

        $this->db->where('DeptID', $id);
        $this->db->where('IDSubJabatan_Kar', $subJabatanID);
        $this->db->where('id_master_bongkar_kelapa', $id_targetBongkar);
        $this->db->order_by('periode', 'desc');
        $query = $this->db->get('vwIdealKryTk_new');
        $row = $query->row();

        return $row;
    }

    function getdatakuotabor($id)
    {
        $this->db->distinct();
        if ($id == 56) {
            $depAbbr = 'CWC';
            $this->db->where('DeptAbbr', $depAbbr);
        } else {
            $id = $id;
            $this->db->where('deptbor', $id);
        }
        // $this->db->where('deptbor', $id);
        $this->db->order_by('periode', 'desc');
        $query = $this->db->get('vwIdealKryTk');
        $row = $query->row();
        //$deptabbr = $row->DeptAbbr;

        //----- cek tabel kuota
        //$this->db->where('bordeptname',$deptabbr);
        // $query = $this->db->get('vwKuotaKryTK');
        // $row = $query->row();
        return $row;
    }

    function getdatakuotabor_($id, $subJabatanID)
    {
        $this->db->distinct();
        // if ($id == 56) {
        //     $depAbbr = 'CWC';
        //     $this->db->where('DeptAbbr', $depAbbr);
        // } else {
        //     $id = $id;
        //     $this->db->where('deptbor', $id);
        // }

        if ($id == 35 || $id == 40 || $id == 39) { // PIW, PCW, CPW
            $id = 67;
        }

        if ($id == 31 || $id == 24) { // TBN, PWH
            $id = 58;
        }
        if ($id == 56) { //cwc
            $id = 46;
        }
        $this->db->where('deptbor', $id);
        $this->db->where('IDSubJabatan', $subJabatanID);
        $this->db->order_by('periode', 'desc');
        $query = $this->db->get('vw_idealtkbor');
        $row = $query->row();
        //$deptabbr = $row->DeptAbbr;

        //----- cek tabel kuota
        //$this->db->where('bordeptname',$deptabbr);
        // $query = $this->db->get('vwKuotaKryTK');
        // $row = $query->row();
        return $row;
    }

    function getdatakuotabor_new($id, $subJabatanID, $idTargetBongkar)
    {
        if ($id == 35 || $id == 40 || $id == 39) { // PIW, PCW, CPW
            $id = 67;
        }
        if ($id == 31) {
            $id = 58;
        }
        $this->db->distinct();
        $this->db->where('DeptIDBor', $id);
        $this->db->where('IDSubJabatan_Bor', $subJabatanID);
        $this->db->where('id_master_bongkar_kelapa', $idTargetBongkar);
        $this->db->order_by('periode', 'desc');
        $query = $this->db->get('vwIdealKryTk_new');
        $row = $query->row();
        return $row;
    }

    function getJabatanPsgBor($id = null)
    {
        if ($id != null && $id != '') {

            if ($id == 35 || $id == 40 || $id == 39) { // PIW, PCW, CPW
                $id = 67;
            }

            if ($id == 31 || $id == 24) { // TBN, PWH
                $id = 58;
            }

            $con = "WHERE IDDept = $id";
        } else {
            $con = "";
        }
        $query = $this->db->query(
            "SELECT
                            A.Jabatan AS Pekerjaan,
                            A.* 
                            FROM
                            [192.168.3.32].PSGBorongan.dbo.tblMstJabatan A 
                            WHERE
                            IDJabatan IN (
                            SELECT IDJabatan FROM [192.168.3.32].PSGBorongan.dbo.tblMstSubJabatan $con
                            )"
        );
        return $query->result();
    }

    function getSubJabatan($idJabatan, $IDdept)
    {

        // if ($dept == 'TBN' || $dept == 'PWH') {
        //     $dept = 'PWP';
        // }

        // if ($dept == 'CPW' || $dept == 'PIW' || $dept == 'PCW') {
        //     $dept = 'CWR';
        // }

        if ($IDdept == 35 || $IDdept == 40 || $IDdept == 39) { // PIW, PCW, CPW
            $IDdept = 67;
        }
        if ($IDdept == 31 || $IDdept == 24) { // TBN, PWH
            $IDdept = 58;
        }

        $query = $this->db->query("SELECT
                                        B.DeptAbbr,
                                        A.SubjabatanName AS SubPekerjaan,
                                        A.* 
                                    FROM
                                        [192.168.3.32].PSGBorongan.dbo.tblMstSubJabatan A
                                    LEFT JOIN [192.168.3.32].PSGBorongan.dbo.tblMstDepartemen B ON A.IDDept = B.IDDept
                                    WHERE B.IDDept = '$IDdept'
                                    AND A.IDJabatan = '$idJabatan'
                                    ORDER BY
                                        A.SubJabatanName;");
        return $query->result();
    }

    function getTargetBongkar()
    {
        $this->db->select('id, jumlah');
        $query = $this->db->get('tblMstBongkarKelapa');
        return $query->result();
    }

    function getJabatanPayroll()
    {

        $q = $this->db->query("SELECT
                            * 
                            FROM
                            PSGPayroll.dbo.tblMstJabatan 
                            WHERE
                            JabatanID <> 0 
                            AND JabatanName <> 'TRAINEE'");
        return $q->result();
    }
    function getSubJabatanPayroll($id)
    {
        $q = $this->db->query("SELECT
                                * 
                                FROM
                                PSGPayroll.dbo.tblMstSubJabatan 
                                WHERE
                                JabatanID =  '$id'");
        return $q->result();
    }

    function getDeptPayroll()
    {
        $q = $this->db->query("SELECT
                                * 
                                FROM
                                PSGPayroll.dbo.vwMstDepartemen WHERE
                                DeptID <> 0");
        return $q->result();
    }
    function getTargetBongkarMst($id)
    {
        $q = $this->db->query("SELECT
                                id_master_bongkar_kelapa 
                                FROM
                                tblmsttargetbongkar WHERE id = $id");
        return $q->row()->id_master_bongkar_kelapa;
    }

    function updateTargetBongkar($id, $data)
    {
        $this->db->trans_begin();

        $this->db->where('id', $id);
        $this->db->update('tblmsttargetbongkar', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
}
