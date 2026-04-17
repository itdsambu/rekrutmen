<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class M_Approval extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function getTransForDept()
    {
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL A WHERE DEPTApproval Is NULL AND "
            . "DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara B WHERE GroupID =" . $grupID . " AND A.Pemborong = B.tipe) AND DEPTStatus Is NULL");
        return $query->result();
    }

    //UPDATED FOR PERMINTAAN
    function getTranForDivisi()
    {
        $grupID = $this->session->userdata('groupuser');
        $sql = "SELECT DISTINCT * FROM vwTrnApprovalALL WHERE DIVISIApproval Is NULL AND "
            . "DeptID IN (SELECT DISTINCT z.DeptID FROM vwTrnDeptWawancara z WHERE z.GroupID =" . $grupID . " AND z.tipe = Pemborong) AND DIVISIStatus Is NULL "
            . "AND DEPTApproval Is Not NULL AND DEPTStatus = 1 AND DetailID not in ("
            . " select d.IDrequest
                from tblTrnPermintaanMemoDtl d
                join tblMstKuotaPermintaanMemo m on m.IDMemo = d.IDMemo
                where ISNULL(m.IsComplete,0)=0 )";

        // $sql = "SELECT DISTINCT * FROM vwTrnApprovalALL WHERE DIVISIApproval Is NULL AND "
        //     . "DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =" . $grupID . ") AND DIVISIStatus Is NULL "
        //     . "AND DEPTApproval Is Not NULL AND DEPTStatus = 1 ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function getTranForPsn()
    {
        $sql = "SELECT DISTINCT * FROM vwTrnApprovalALL WHERE PSNApproval Is NULL AND PSNStatus Is NULL "
            . "AND DEPTApproval Is Not NULL AND DEPTStatus = 1 "
            . "AND DIVISIApproval Is Not NULL AND DIVISIStatus = 1"
            . " UNION  "
            . "SELECT DISTINCT * FROM vwTrnApprovalALL WHERE PSNApproval Is NULL AND PSNStatus Is NULL  "
            . " AND DEPTApproval Is Not NULL AND DEPTStatus = 1 "
            . " and DetailID in ( "
            . " select d.IDrequest "
            . " from tblTrnPermintaanMemoDtl d "
            . " Join tblMstKuotaPermintaanMemo m on m.IDMemo = d.IDMemo "
            . " where ISNULL(m.IsComplete,0)=0 )";

        $query = $this->db->query($sql);
        return $query->result();
    }

    function getTranForAgm()
    {
        $sql = "SELECT DISTINCT * FROM vwTrnApprovalALL WHERE AGMApproval Is NULL AND AGMStatus Is NULL "
            . "AND DEPTApproval Is Not NULL AND DEPTStatus = 1 "
            . "AND DIVISIApproval Is Not NULL AND DIVISIStatus = 1 "
            . "AND PSNApproval Is Not NULL AND PSNStatus = 1 ";
        //add for kuota permintaan   

        $sqlfilter = "and ((Pemborong='ALL PEMBORONG' AND  DeptAbbr not IN  " .
            "( SELECT v.bordeptname from vwKuotaKryTK v " .
            " join tblMstKuotaPermintaanMemo m on m.ForDept=v.krybor " .
            " where m.IsComplete=0 and m.IsKry=0 " .
            " and m.Jumlah>0 " .
            ") " .
            ") or " .
            "  ( " .
            " (Pemborong='PSG' AND 	DeptAbbr not IN  " .
            " 	( " .
            " SELECT v.bordeptname " .
            "from vwKuotaKryTK v " .
            "join tblMstKuotaPermintaanMemo m on m.ForDept=v.krybor " .
            "where m.IsComplete=0 and m.IsKry=1 " .
            " and m.Jumlah>0 " .
            ") ) ))";

        //$sql = $sql . " " . $sqlfilter;
        /*
         " AND DetailID NOT IN (" 
                    . "select d.IDrequest from tblTrnPermintaanMemoDtl d "
                                             . "join tblMstKuotaPermintaanMemo m on m.IDMemo = d.IDMemo " 
                                             . "where ISNULL(m.IsComplete,0)=0"
                    . ")";
        */
        $query = $this->db->query($sql);
        return $query->result();
    }

    function getTranForVgm()
    {
        $sql = "SELECT DISTINCT * FROM vwTrnApprovalALL WHERE VGMApproval Is NULL AND VGMStatus Is NULL "
            . "AND DEPTApproval Is Not NULL AND DEPTStatus = 1 "
            . "AND DIVISIApproval Is Not NULL AND DIVISIStatus = 1 "
            . "AND PSNApproval Is Not NULL AND PSNStatus = 1 "
            . "AND AGMApproval Is Not NULL AND AGMStatus = 1";
        //add for kuota permintaan         
        $sql = $sql . " AND DetailID NOT IN ("
            . "select d.IDrequest from tblTrnPermintaanMemoDtl d "
            . "join tblMstKuotaPermintaanMemo m on m.IDMemo = d.IDMemo "
            . "where ISNULL(m.IsComplete,0)=0"
            . ")";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function getDept($dept)
    {
        $query = $this->db->query("SELECT TOP 1 * FROM tblMstDepartemenNew WHERE DeptID = " . $dept);
        return $query->result();
    }

    function setInfoTran($id)
    {
        $query = $this->db->query("SELECT * FROM tblTrnRequest WHERE DetailID = '" . $id . "'");
        return $query->result();
    }

    function updateTran($id, $data)
    {
        $this->db->trans_start();
        $this->db->where('DetailID', $id);
        $this->db->update('tblTrnRequest', $data);
        $this->db->trans_complete();
    }

    function updateTranMemoPermintaan($param)
    {
        $this->exec_sql('UpdateMemoDetail', $param);
        return;
    }
}
