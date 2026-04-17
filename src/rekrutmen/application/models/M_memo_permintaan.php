<?php defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_memo_permintaan extends CI_Model{

    public function __construct() {
        parent::__construct();
    }

    function get_dept(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT distinct DeptID,DeptAbbr FROM tblMstDepartemenNew WHERE DeptID IN "
                . "(SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = '$grupID') ORDER BY DeptAbbr");
        return $query->result();
    }

    function get_data($dept){
        $query = $this->db->query("SELECT distinct DeptID,DeptAbbr FROM tblMstDepartemenNew where NotActive = '0' and DeptID = '$dept'");
        return $query->result();
    }

    function get_dataideal($dept){
        $query = $this->db->query("SELECT * from tblTrnMemoNew where DeptID = '$dept'");
        return $query->num_rows();
    }

    function get_exsisitingkary($dept){
        $query = $this->db->query("SELECT B.DeptID,B.DeptAbbr,COUNT(A.BagianID) as Jumlah FROM (SELECT * FROM RSUPPayroll .dbo.vwDataKaryawanNonFinance) as A left join(
                SELECT * FROM tblMstDepartemenNew where NotActive = '0') as B ON A.BagianID = B.BagianIDPayroll where B.DeptID = '$dept' GROUP BY B.DeptID,B.DeptAbbr");
        return $query->result();
    }

    function get_exsisitingbor($dept){
        $tanggal = date('d/m/Y');
        $query = $this->db->query("SELECT * FROM (SELECT DISTINCT  B.DeptID, B.BagianIDBorongan, A.Bagian, COUNT(A.Bagian) AS Jumlah FROM (SELECT IDBagian, Bagian FROM RSUPBorongan2010.dbo.vwMasterTenagaKerja WHERE        (IDStatusTenagaKerja NOT IN ('4')) AND (NikLepas = 0) AND (CONVERT(DateTime, CONVERT(Varchar, TanggalMasuk, 103), 103) <= CONVERT(DateTime, '$tanggal', 103)) AND (CONVERT(DateTime, CONVERT(Varchar, TanggalKeluar, 103), 103) > CONVERT(DateTime, '$tanggal', 103)) AND (CONVERT(DateTime, CONVERT(Varchar, TanggalKeluarTemporary, 103), 103) > CONVERT(DateTime, '$tanggal', 103)) OR (IDStatusTenagaKerja NOT IN ('4')) AND (NikLepas = 0) AND (CONVERT(DateTime, CONVERT(Varchar, TanggalMasuk, 103), 103) <= CONVERT(DateTime, '$tanggal', 103)) AND (CONVERT(DateTime,CONVERT(Varchar, TanggalKeluarTemporary, 103), 103) > CONVERT(DateTime, '$tanggal', 103)) AND (TanggalKeluar IS NULL) OR(IDStatusTenagaKerja NOT IN ('4')) AND (NikLepas = 0) AND (CONVERT(DateTime, CONVERT(Varchar, TanggalMasuk, 103), 103) <= CONVERT(DateTime, '$tanggal', 103)) AND (CONVERT(DateTime, CONVERT(Varchar, TanggalKeluar, 103), 103) > CONVERT(DateTime, '$tanggal', 103)) AND (TanggalKeluarTemporary IS NULL) OR (IDStatusTenagaKerja NOT IN ('4')) AND (NikLepas = 0) AND (CONVERT(DateTime, CONVERT(Varchar, TanggalMasuk, 103), 103) <= CONVERT(DateTime, '$tanggal', 103)) AND (TanggalKeluar IS NULL) AND (TanggalKeluarTemporary IS NULL)) AS A LEFT OUTER JOIN (SELECT DeptID, DeptAbbr, BagianIDPayroll, BagianIDBorongan FROM dbo.tblMstDepartemenNew WHERE        (NotActive = 0)) AS B ON A.IDBagian = B.BagianIDPayroll OR A.IDBagian = B.BagianIDBorongan GROUP BY B.DeptID, A.Bagian, B.BagianIDBorongan, B.BagianIDPayroll ) as A where A.DeptID = '$dept' ORDER BY A.Bagian");
        return $query->result();
    }

    function get_ideal($dept){
         $query = $this->db->query("SELECT * FROM tblMstIdeal where DeptID = '$dept'");
        return $query->result();
    }

    function simpan($data){
        $this->db->insert("tblTrnMemoNew",$data);
    }
}