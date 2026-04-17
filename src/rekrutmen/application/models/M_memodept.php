<?php defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_memodept extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function get_datamemo($id)
    {
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT A.*,B.DeptAbbr FROM tblTrnMemoNew as A left join (SELECT distinct DeptID,DeptAbbr FROM tblMstDepartemenNew where NotActive = 0) as B ON A.DeptID = B.DeptID WHERE A.DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = '$grupID') and A.MemoID = '$id'");
        return $query->result();
    }

    function update_cancelmemodept($id, $data)
    {
        $this->db->where('MemoID', $id);
        $this->db->update('tblTrnMemo', $data);
    }

    function tolakDatamemo($id, $data)
    {
        $this->db->where('MemoID', $id);
        $this->db->update('tblTrnMemoNew', $data);
    }

    function get_memo()
    {
        $bulan = date('m');
        $tahun = date('Y');
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT A.*,B.DeptAbbr from tblTrnMemoNew as A left join vwDepartemenNew as B ON A.DeptID = B.DeptID where MONTH(A.CreatedDate) = '$bulan' and YEAR(A.CreatedDate) = '$tahun' AND A.DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = '$grupID') and B.NotActive = 0 ORDER BY MemoID DESC");
        return $query->result();
    }

    function get_datamonitor($bulan, $tahun, $type)
    {
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT A.*,B.DeptAbbr from tblTrnMemoNew as A left join vwDepartemenNew as B ON A.DeptID = B.DeptID where MONTH(A.CreatedDate) = '$bulan' and YEAR(A.CreatedDate) = '$tahun' and A.GeneralStatus =  '$type' AND A.DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = '$grupID') and B.NotActive = 0");
        return $query->result();
    }

    function get_dataTolakan()
    {
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM tblTrnMemoPermintaan as A left join vwDepartemenNew as B ON A.DeptID = B.DeptID  WHERE A.DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = '$grupID') and GeneralStatus = '2'");
        return $query->result();
    }

    function update_ubahMemoTolakan($id, $data)
    {
        $this->db->where('MemoID', $id);
        $this->db->update('tblTrnMemo', $data);
    }

    function get_dataubahmemo($dept)
    {
        $query = $this->db->query("SELECT distinct IDPermintaan,DeptID,DeptAbbr,Idealkaryawan,Realkaryawan,Idealtenagakerja,Realtenagakerja,CreatedBy,CreatedDate,UpdateBy,UpdateDate FROM vw_permintaanideal where DeptID ='$dept' ");
        return $query->result();
    }

    function get_dept()
    {
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT distinct DeptID,DeptAbbr FROM vw_permintaanideal WHERE DeptID IN "
            . "(SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = '$grupID') ORDER BY DeptAbbr");
        return $query->result();
    }

    function get_dataideal($dept)
    {
        $tahun = date('Y');
        $query = $this->db->query("select * from tblTrnMemoPermintaan where DeptID = '$dept'");
        return $query->num_rows();
    }

    function get_dataTolakanMemo($id)
    {
        $query = $this->db->query("SELECT * FROM tblTrnMemoPermintaan as A left join vwDepartemenNew as B ON A.DeptID = B.DeptID WHERE MemoID = '$id' ");
        return $query->result();
    }

    function updateData($id, $data)
    {
        $this->db->where('MemoID', $id);
        $this->db->update('tblTrnMemoNew', $data);
    }

    function get_datamonitorpendding($bulan, $tahun)
    {
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT A.*,B.DeptAbbr FROM tblTrnMemoNew as A left join vwDepartemenNew as B ON A.DeptID = B.DeptID where MONTH(A.CreatedDate) = '$bulan' and YEAR(A.CreatedDate) = '$tahun' and A.GeneralStatus is null AND A.DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = '$grupID') and B.NotActive = 0");
        return $query->result();
    }

    function updateCloseData($id, $data)
    {
        $this->db->where('MemoID', $id);
        $this->db->update('tblTrnMemo', $data);
    }

    function get_dataApprovedept()
    {
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT A.*,B.DeptAbbr FROM tblTrnMemoNew as A left join (SELECT distinct DeptID,DeptAbbr FROM tblMstDepartemenNew where NotActive = 0) as B ON A.DeptID = B.DeptID  WHERE A.DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = '$grupID') and A.ApproveDept is null  and GeneralStatus IS NULL");
        return $query->result();
    }

    function get_dataApproveDivisi()
    {
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM tblTrnMemoNew as A left join vwDepartemenNew as B ON A.DeptID = B.DeptID WHERE A.DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = '$grupID') and A.ApproveDept = '1' and ApproveDiv IS NULL and B.NotActive = '0'");
        return $query->result();
    }

    function get_dataApprovePsn()
    {
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM tblTrnMemoNew as A left join vwDepartemenNew as B ON A.DeptID = B.DeptID  WHERE A.DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = '$grupID') and A.ApproveDept = 1 and A.ApproveDiv = 1 and A.ApprovePsn is null  and GeneralStatus IS NULL");
        return $query->result();
    }

    function get_dataApproveVgm()
    {
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM tblTrnMemoNew as A left join vwDepartemenNew as B ON A.DeptID = B.DeptID  WHERE A.DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = '$grupID') and A.ApproveDept = 1 and A.ApproveDiv = 1 and A.ApprovePsn = 1 and A.ApproveVgm is null  and (GeneralStatus IS NULL OR GeneralStatus = '1')");
        return $query->result();
    }

    function get_data($id)
    {
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM tblTrnMemo as A left join vwDepartemenNew as B ON A.DeptID = B.DeptID  WHERE A.DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = '$grupID') and A.MemoID = '$id'");
        return $query->result();
    }

    function getDataCancelTolakan($id)
    {
        $query = $this->db->query("SELECT * FROM tblTrnMemo as A left join vwDepartemenNew as B ON A.DeptID = B.DeptID where A.MemoID = '$id'");
        return $query->result();
    }

    function update_permintaan($dept, $data2)
    {
        $this->db->where('DeptID', $dept);
        $this->db->update('tblTrnPermintaan', $data2);
    }

    function update_master($dept, $data3)
    {
        $this->db->where('DeptID', $dept);
        $this->db->update('tblMstIdeal', $data3);
    }
}
