<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD24
 */


class m_calonKandidat extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        // $db2 = $this->load->database('psgrekrutmen',TRUE);  
    }

    function get_departemen()
    {
        $tahun = date('Y');
        // $query = $this->db->query("SELECT distinct * FROM vwTrnApprovalAll where GeneralStatus = '1' and YEAR(CreatedDate) = '$tahun' and Pemborong = 'RSUP' ORDER BY DeptAbbr ASC");
        $query = $this->db->query("SELECT distinct * FROM vwTrnApprovalAll where GeneralStatus = '1' and YEAR(CreatedDate) = '$tahun' and Pemborong = 'PSG' ORDER BY DeptAbbr ASC");
        return $query->result();
    }
    function get_divisi($id)
    {
        $query = $this->db->query("SELECT Distinct DeptID,DeptAbbr,NewDivID,NamaDept FROM tblMstDepartemenNew where NotActive = '0' ");
        return $query->result();
    }
    function get_pendidikan()
    {
        $query = $this->db->query("SELECT * FROM tblMstPendidikan");
        return $query->result();
    }
    function get_suku()
    {
        $query = $this->db->query("SELECT * FROM tblMstSuku");
        return $query->result();
    }
    function get_jurusan()
    {
        $query = $this->db->query("SELECT * FROM tblMstJurusan");
        return $query->result();
    }

    function simpan($data)
    {
        $this->db->insert('tblTrnCalonkandidat', $data);
    }

    function get_CalonkandidatRsup()
    {
        $tahun = date('Y');
        $query = $this->db->query("SELECT  distinct * FROM vwApprovalAll where GeneralStatus = '1' and YEAR(CreatedDate) = '$tahun' and Pemborong = 'RSUP' ORDER BY DeptAbbr ASC");
        return $query->result();
    }

    function get_dataCalonKandidatRsupId($id)
    {
        $query = $this->db->query("SELECT A.*,B.DeptID,B.DeptAbbr,B.DetailID,C.Jurusan,D.Pendidikan,B.Pekerjaan  FROM tblTrnCalonKandidat as A left join (SELECT DetailID,DeptID,DeptAbbr,Pekerjaan FROM vwApprovalAll where GeneralStatus = '1' and YEAR(CreatedDate) = '2019' and Pemborong = 'RSUP') as B ON A.IssueID = B.DetailID left join tblMstJurusan as C ON A.JurusanID = C.ID left join tblMstPendidikan as D ON A.PendidikanID = D.ID where A.CalonID = '$id'");
        return $query->result();
    }

    function get_ajaxCalonKandidat1($bulan, $tahun, $status)
    {
        $query = $this->db->query("SELECT * FROM vwCalonKandidat where MONTH(CreatedDate) = '$bulan' and YEAR(CreatedDate) = '$tahun' and Status = '$status'");
        return $query->result();
    }

    function get_ajaxCalonKandidat2($bulan, $tahun)
    {
        $query = $this->db->query("SELECT * FROM vwCalonKandidat where MONTH(CreatedDate) = '$bulan' and YEAR(CreatedDate) = '$tahun'");
        return $query->result();
    }

    function get_dataCalonkandidat($id)
    {
        $query = $this->db->query("SELECT * FROM vwCalonKandidat where CalonID = '$id'");
        return $query->result();
    }

    function update($id, $data)
    {
        $this->db->where('CalonID', $id);
        $this->db->update('tblTrnCalonKandidat', $data);
    }

    function get_db_berkas($hdrid)
    {
        return $this->db->get_where('tblTrnBerkasCalonKandidat', array('HeaderID' => $hdrid));
    }

    function minimal_berkas($hdrid)
    {
        $minimalberkas = 0;
        $query = $this->db->query("Select HeaderID from tblTrnBerkasCalonKandidat Where HeaderID=" . $hdrid .
            " And SuratLamaran is not null And Ijazah is not null");
        if ($query->num_rows() > 0) {
            $minimalberkas = 1;
        }
        return $minimalberkas;
    }

    function update_db_berkas($hdrid, $berkas, $lokasi)
    {
        $this->db->trans_start();
        $this->db->where('HeaderID', $hdrid);
        $this->db->update('tblTrnBerkasCalonKandidat', array($berkas => $lokasi));
        $this->db->trans_complete();
    }

    function get_deptIssue()
    {
        $tahun = date('Y');
        $query = $this->db->query("SELECT distinct DetailID,DeptID,DeptAbbr,Pekerjaan,CreatedDate FROM vwApprovalAll where GeneralStatus = '1' and YEAR(CreatedDate) = '$tahun' and Pemborong = 'RSUP' ORDER BY DeptAbbr ASC");
        return $query->result();
    }

    function getCalonKandidat()
    {
        $tahun = date('Y');
        $query = $this->db->query("SELECT A.*,B.DeptID,B.DeptAbbr,B.DetailID,C.Jurusan,D.Pendidikan,B.Pekerjaan  FROM tblTrnCalonKandidat as A left join (SELECT DetailID,DeptID,DeptAbbr,Pekerjaan FROM vwApprovalAll where GeneralStatus = '1' and YEAR(CreatedDate) = '$tahun' and Pemborong = 'RSUP') as B ON A.IssueID = B.DetailID left join tblMstJurusan as C ON A.JurusanID = C.ID left join tblMstPendidikan as D ON A.PendidikanID = D.ID");
        return $query->result();
    }

    function getData1($suku)
    {
        $tahun = date('Y');
        $query = $this->db->query("SELECT A.*,B.DeptID,B.DeptAbbr,B.DetailID,C.Jurusan,D.Pendidikan,B.Pekerjaan  FROM tblTrnCalonKandidat as A left join (SELECT DetailID,DeptID,DeptAbbr,Pekerjaan FROM vwApprovalAll where GeneralStatus = '1' and YEAR(CreatedDate) = '$tahun' and Pemborong = 'RSUP') as B ON A.IssueID = B.DetailID left join tblMstJurusan as C ON A.JurusanID = C.ID left join tblMstPendidikan as D ON A.PendidikanID = D.ID where A.SukuID = '$suku'");
        return $query->result();
    }
    function getData2($suku, $tglawal, $tglakhir)
    {
        $tahun = date('Y');
        $query = $this->db->query("SELECT A.*,B.DeptID,B.DeptAbbr,B.DetailID,C.Jurusan,D.Pendidikan,B.Pekerjaan  FROM tblTrnCalonKandidat as A left join (SELECT DetailID,DeptID,DeptAbbr,Pekerjaan FROM vwApprovalAll where GeneralStatus = '1' and YEAR(CreatedDate) = '$tahun' and Pemborong = 'RSUP') as B ON A.IssueID = B.DetailID left join tblMstJurusan as C ON A.JurusanID = C.ID left join tblMstPendidikan as D ON A.PendidikanID = D.ID where A.SukuID = '$suku' and CONVERT(DATE, A.TanggalInterview) >= '$tglawal' and CONVERT(DATE, A.TanggalInterview) <= '$tglakhir'");
        return $query->result();
    }
}
