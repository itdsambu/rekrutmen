<?php
defined('BASEPATH') or exit('No Direct Script Access Allowed');

class m_tambah_rencana extends CI_Model{

	function get_Dept(){
		$query = $this->db->query("SELECT distinct DeptID,DeptAbbr FROM tblMstDepartemenNew where NotActive = 0 ORDER BY DeptAbbr");
		return $query->result();
	}

    function get_DeptKaryawan(){
        $query = $this->db->query("SELECT distinct DeptID,DeptAbbr FROM tblMstDepartemenNew where NotActive = 0 ORDER BY DeptAbbr");
        return $query->result();
    }

	function get_Data(){
        $tahun = date('Y');
        $tanggal = date('d/m/Y');
        $query = $this->db->query("SELECT A.IdealID,A.DeptID,C.DeptAbbr,A.Jumlah_IdealBor,B.Jumlah,D.requstTK,A.Jumlah_IdealBor - B.Jumlah as Sisa FROM tblMstIdeal as A left join (SELECT DISTINCT  B.DeptID, B.BagianIDBorongan, A.Bagian, COUNT(A.Bagian) AS Jumlah FROM (SELECT IDBagian, Bagian FROM RSUPBorongan2010.dbo.vwMasterTenagaKerja WHERE        (IDStatusTenagaKerja NOT IN ('4')) AND (NikLepas = 0) AND (CONVERT(DateTime, CONVERT(Varchar, TanggalMasuk, 103), 103) <= CONVERT(DateTime, '$tanggal', 103)) AND (CONVERT(DateTime,CONVERT(Varchar, TanggalKeluar, 103), 103) > CONVERT(DateTime, '$tanggal', 103)) AND (CONVERT(DateTime, CONVERT(Varchar, TanggalKeluarTemporary, 103), 103) > CONVERT(DateTime, '$tanggal',103)) OR (IDStatusTenagaKerja NOT IN ('4')) AND (NikLepas = 0) AND (CONVERT(DateTime, CONVERT(Varchar, TanggalMasuk, 103), 103) <= CONVERT(DateTime, '$tanggal', 103)) AND (CONVERT(DateTime,CONVERT(Varchar, TanggalKeluarTemporary, 103), 103) > CONVERT(DateTime, '$tanggal', 103)) AND (TanggalKeluar IS NULL) OR (IDStatusTenagaKerja NOT IN ('4')) AND (NikLepas = 0) AND (CONVERT(DateTime, CONVERT(Varchar, TanggalMasuk, 103), 103) <= CONVERT(DateTime, '$tanggal', 103)) AND (CONVERT(DateTime,CONVERT(Varchar, TanggalKeluar, 103), 103) > CONVERT(DateTime, '$tanggal', 103)) AND (TanggalKeluarTemporary IS NULL) OR(IDStatusTenagaKerja NOT IN ('4')) AND (NikLepas = 0) AND (CONVERT(DateTime, CONVERT(Varchar, TanggalMasuk, 103), 103) <= CONVERT(DateTime, '$tanggal', 103)) AND (TanggalKeluar IS NULL) AND (TanggalKeluarTemporary IS NULL)) AS A LEFT OUTER JOIN (SELECT        DeptID, DeptAbbr, BagianIDPayroll, BagianIDBorongan FROM dbo.tblMstDepartemenNew WHERE        (NotActive = 0)) AS B ON A.IDBagian = B.BagianIDPayroll OR A.IDBagian = B.BagianIDBorongan GROUP BY B.DeptID, A.Bagian, B.BagianIDBorongan, B.BagianIDPayroll ) as B ON A.DeptID = B.DeptID left join ( SELECT distinct DeptID,DeptAbbr,BagianIDBorongan FROM tblMstDepartemenNew where NotActive = 0) as C ON A.DeptID = C.DeptID left join (SELECT DeptID,DeptAbbr,SUM(TKPermintaan) AS requstTK FROM vwApprovalAll where (GeneralStatus = '1' OR GeneralStatus IS NULL) AND Pemborong IN ('ALL PEMBORONG') and YEAR(CreatedDate) = '$tahun'  GROUP BY DeptID,DeptAbbr) as D ON A.DeptID = D.DeptID ORDER BY C.DeptAbbr");
        return $query->result();
	}

    function get_DataRealBorongan(){
        $tanggal = date('d/m/Y');
        $query = $this->db->query("SELECT B.DeptID,B.BagianIDPayroll,B.BagianIDBorongan,A.Bagian,COUNT(A.Bagian) as Jumlah FROM 
            (
                SELECT IDBagian,Bagian FROM RSUPBorongan2010 .dbo. vwMasterTenagaKerja 
                where IDStatusTenagaKerja not in ('4') and Niklepas = 0 
                AND Convert(DateTime,Convert(Varchar,TanggalMasuk,103),103)<=Convert(DateTime,'$tanggal',103) 
                AND (Convert(DateTime,Convert(Varchar,TanggalKeluar,103),103)>Convert(DateTime,'$tanggal',103) Or TanggalKeluar is Null) 
                AND (Convert(DateTime,Convert(Varchar,TanggalKeluarTemporary,103),103)>Convert(DateTime,'$tanggal',103) Or TanggalKeluarTemporary is Null)
            ) as A
            left join 
            (
                SELECT DeptID,DeptAbbr,BagianIDPayroll,BagianIDBorongan FROM tblMstDepartemenNew where NotActive = 0
            ) as B
            ON A.IDBagian = B.BagianIDPayroll OR A.IDBagian = B.BagianIDBorongan
            GROUP BY B.DeptID,A.Bagian,B.BagianIDBorongan,B.BagianIDPayroll
            ORDER BY A.Bagian ");
        return $query->result_array();
    }
    
	function get_DataKaryawan(){
		$tahun = date('Y');
        $query = $this->db->query("SELECT B.IDPermintaan,A.DeptID,A.DeptAbbr,B.Idealkaryawan,B.Realkaryawan,B.Idealtenagakerja,B.Realtenagakerja,SUM(TKPermintaan) AS requestKary FROM vwApprovalAll AS A LEFT JOIN tblTrnPermintaan AS B ON A.DeptID = B.DeptID WHERE YEAR(A.CreatedDate) = '$tahun' AND Pemborong IN('RSUP') and (GeneralStatus = 1 or GeneralStatus is null) GROUP BY B.IDPermintaan,A.DeptID,A.DeptAbbr,B.Idealkaryawan,B.Realkaryawan,B.Idealtenagakerja,B.Realtenagakerja");
        return $query->result();
	}

	function get_DataHarianBorongan(){
		$tahun = date('Y');
        $query = $this->db->query("SELECT A.IDPermintaan,B.DeptID,B.DeptAbbr,B.Pemborong,A.Idealtenagakerja,A.Realtenagakerja,SUM(B.TKPermintaan) AS requstTK FROM tblTrnPermintaan AS A LEFT JOIN vwApprovalAll B ON A.DeptID = B.DeptID WHERE year(B.CreatedDate) = '$tahun' AND Pemborong IN ('ALL PEMBORONG') AND (GeneralStatus = 1 OR GeneralStatus is NULL) GROUP BY A.IDPermintaan,B.DeptID,B.DeptAbbr,B.Pemborong,A.Idealtenagakerja,A.Realtenagakerja");
        return $query->result();
	}

	function simpan($data){
		$this->db->insert('tblTrnPermintaan',$data);
	}

	function simpanHB($data){
		return  $this->db->insert('tblTrnPermintaan',$data);
	}

	function cek_Data($id){
        $query = $this->db->query("SELECT * FROM tblTrnPermintaan where DeptID = '$id'");
            return $query->result();
    }

    function updateData($id,$data){
    	$this->db->where('DeptID',$id);
    	$this->db->update('tblTrnPermintaan',$data);
    }

    function simpanDataHistory($data){
    	$this->db->insert('tblTrnHistoryPermintaan',$data);
    }

    function get_RencanaKaryawan($id,$deptid){
    	$query = $this->db->query("SELECT A.MemoID,A.DeptID,B.DeptAbbr,A.No_ref,A.JmlRencanaKaryawan,A.RencanaTambahanKaryawan,A.JmlRencanaHarianBorongan,A.RencanaTambahanHarianBorongan,A.Type,A.Total,A.Keterangan,A.GeneralStatus,A.ketTolakCancel,A.CreatedBy,A.CreatedDate,A.RegistrasiBy,A.RegistrasiDate,A.UpdateBy,A.UpdateBy,A.ApproveDept,A.ApproveDeptBy,A.ApproveDeptDate,A.ApproveDivisi,A.ApproveDivisiBy,A.ApproveDivisiDate,A.ApprovePsn,A.ApprovePsnBy,A.ApprovePsnDate,B.NotActive FROM tblTrnMemo as A left join (select distinct DeptID,DeptAbbr,NotActive from tblMstDepartemenNew ) as B ON A.DeptID = B.DeptID WHERE A.DeptID = '$deptid' and A.MemoID = '$id' and  A.type = 1 and B.NotActive = 0");
    	return $query->result();
    }

    function get_cekDataK($id){
    	$query = $this->db->query("SELECT * FROM tblTrnMemo as A Left join tblMstDepartemenNew as B ON A.DeptID = B.DeptID where A.DeptID = '$id' and  A.type = 1 and B.NotActive = 0");
    	return $query->result();
    }
    function get_cekDataHB($id){
        $query = $this->db->query("SELECT * FROM tblTrnMemo as A Left join tblMstDepartemenNew as B ON A.DeptID = B.DeptID where A.DeptID = '$id' and  A.type = 0 and B.NotActive = 0");
        return $query->result();
    }

     function get_RencanaBorongan($id,$deptid){
        $query = $this->db->query("SELECT A.MemoID,A.DeptID,B.DeptAbbr,A.No_ref,A.JmlRencanaKaryawan,A.RencanaTambahanKaryawan,A.JmlRencanaHarianBorongan,A.RencanaTambahanHarianBorongan,A.Type,A.Total,A.Keterangan,A.GeneralStatus,A.ketTolakCancel,A.CreatedBy,A.CreatedDate,A.RegistrasiBy,A.RegistrasiDate,A.UpdateBy,A.UpdateBy,A.ApproveDept,A.ApproveDeptBy,A.ApproveDeptDate,A.ApproveDivisi,A.ApproveDivisiBy,A.ApproveDivisiDate,A.ApprovePsn,A.ApprovePsnBy,A.ApprovePsnDate,B.NotActive FROM tblTrnMemo as A left join (select distinct DeptID,DeptAbbr,NotActive from tblMstDepartemenNew ) as B ON A.DeptID = B.DeptID WHERE A.DeptID = '$deptid' and A.MemoID = '$id' and  A.type = 0 and B.NotActive = 0");
        return $query->result();
    }

    function updateDataMemo($id,$data){
        $this->db->where('MemoID',$id);
        $this->db->update('tblTrnMemo',$data);
    }

    function get_dataTotal(){
       $tahun = date('Y');
        $tanggal = date('d/m/Y');
        $query = $this->db->query(" SELECT SUM(AA.Jumlah_IdealBor) as TotalIdeal,SUM(AA.Jumlah) as TotalReal,SUM(AA.Sisa) as TotalSisa,SUM(requstTK) as TotalRequest FROM (SELECT distinct A.DeptID,C.DeptAbbr,A.Jumlah_IdealBor,B.Jumlah,D.requstTK,(A.Jumlah_IdealBor - B.Jumlah) as Sisa FROM tblMstIdeal as A left join (SELECT B.DeptID,B.BagianIDBorongan,A.Bagian,COUNT(A.Bagian) as Jumlah FROM(SELECT IDBagian,Bagian FROM RSUPBorongan2010 .dbo. vwMasterTenagaKerja where IDStatusTenagaKerja not in ('4') and Niklepas = 0 AND Convert(DateTime,Convert(Varchar,TanggalMasuk,103),103)<=Convert(DateTime,'$tanggal',103) AND (Convert(DateTime,Convert(Varchar,TanggalKeluar,103),103)>Convert(DateTime,'$tanggal',103) Or TanggalKeluar is Null) AND (Convert(DateTime,Convert(Varchar,TanggalKeluarTemporary,103),103)>Convert(DateTime,'$tanggal',103) OR TanggalKeluarTemporary is Null)) as A left join (SELECT DeptID,DeptAbbr,BagianIDBorongan FROM tblMstDepartemenNew where NotActive = 0) as B ON A.IDBagian = B.BagianIDBorongan where B.DeptID IS NOT NULL GROUP BY B.DeptID,A.Bagian,B.BagianIDBorongan) as B ON A.DeptID = B.DeptID left join (SELECT DeptID,DeptAbbr,BagianIDBorongan FROM tblMstDepartemenNew where NotActive = 0) as C ON A.DeptID = C.DeptID left join (SELECT DeptID,DeptAbbr,SUM(TKPermintaan) AS requstTK FROM vwApprovalAll where (GeneralStatus = '1' OR GeneralStatus IS NULL AND Pemborong IN ('ALL PEMBORONG') and YEAR(CreatedDate) = '$tahun' )  GROUP BY DeptID,DeptAbbr) as D ON A.DeptID = D.DeptID) as AA");
        return $query->result();
    }

    function get_dataTotalK(){
        $tahun = date('Y');
        $query = $this->db->query("SELECT SUM(AA.Jumlah_IdealKar) as TotalIdeal,SUM(AA.Jumlah) as TotalReal,SUM(AA.Sisa) as TotalSisa,SUM(Aa.requstK) as TotalRequest FROM (SELECT distinct A.DeptID,C.DeptAbbr,A.Jumlah_IdealKar,B.Jumlah,(A.Jumlah_IdealKar - B.Jumlah) as Sisa,D.requstK FROM tblMstIdeal as A left join (SELECT B.DeptID,B.DeptAbbr,COUNT(A.BagianID) as Jumlah FROM (SELECT * FROM RSUPPayroll .dbo.vwDataKaryawanNonFinance) as A left join(SELECT * FROM tblMstDepartemenNew where NotActive = '0') as B ON A.BagianID = B.BagianIDPayroll  GROUP BY B.DeptID,B.DeptAbbr) as B ON A.DeptID = B.DeptID left join (SELECT distinct DeptID,DeptAbbr FROM tblMstDepartemenNew where NotActive = 0) as C ON A.DeptID = C.DeptID left join  (SELECT DeptID,SUM(TKPermintaan) AS requstK FROM vwApprovalAll where (GeneralStatus = '1' OR GeneralStatus IS NULL) AND Pemborong IN ('RSUP') and YEAR(CreatedDate) = '$tahun' GROUP BY DeptID) as D ON A.DeptID = D.DeptID ) as AA");
        return $query->result();
    }

     function get_dataTotalBoro(){
        $query = $this->db->query("SELECT sum(Idealtenagakerja) AS TotalIdeal,sum(Realtenagakerja) AS TotalReal from tblTrnPermintaan");
        return $query->result();
    }

    function get_totalsisa(){
        $query = $this->db->query("SELECT SUM(A.Sisa) as Total FROM (SELECT DeptID, (Idealtenagakerja - Realtenagakerja) as Sisa FROM tblTrnPermintaan where Idealtenagakerja NOT IN(0)) as A");
        return $query->result();
    }
    function get_totalsisaK(){
        $query = $this->db->query("SELECT SUM(A.Sisa) as Total FROM (SELECT DeptID, (Idealkaryawan - Realkaryawan) as Sisa FROM tblTrnPermintaan where Idealtenagakerja NOT IN(0)) as A");
        return $query->result();
    }

    function get_dataTotalExisting(){
        $query = $this->db->query("SELECT COUNT(IDBagian) AS TotalBoronganReal FROM [RSUPBorongan2010].[dbo].[tblMstTenagaKerja] WHERE TanggalKeluar IS NULL AND TanggalKeluarTemporary IS NULL AND (ketKeluar IS NULL OR ketKeluar = '') AND IDStatusTenagaKerja not in ('4') and Niklepas=0");
        return $query->result();
    }

    function get_RealKaryawanlist(){
        $tahun = date('Y');
        $query = $this->db->query("SELECT distinct A.IdealID,A.DeptID,C.DeptAbbr,A.Jumlah_IdealKar,B.Jumlah,(A.Jumlah_IdealKar - B.Jumlah) as Sisa,D.requstK FROM tblMstIdeal as A left join (SELECT B.DeptID,B.DeptAbbr,COUNT(A.BagianID) as Jumlah FROM (SELECT * FROM RSUPPayroll .dbo.vwDataKaryawanNonFinance) as A left join(SELECT * FROM tblMstDepartemenNew where NotActive = '0') as B ON A.BagianID = B.BagianIDPayroll  GROUP BY B.DeptID,B.DeptAbbr) as B ON A.DeptID = B.DeptID left join (SELECT distinct DeptID,DeptAbbr FROM tblMstDepartemenNew where NotActive = 0) as C ON A.DeptID = C.DeptID left join  (SELECT DeptID,SUM(TKPermintaan) AS requstK FROM vwApprovalAll where (GeneralStatus = '1' OR GeneralStatus IS NULL) AND Pemborong IN ('RSUP') and YEAR(CreatedDate) = '$tahun' GROUP BY DeptID) as D ON A.DeptID = D.DeptID
         ORDER BY A.DeptID ASC");
        return $query->result();
    }



    function get_RealKaryawan($deptid){
        $tahun = date('Y');
        $query = $this->db->query("SELECT distinct A.DeptID,C.DeptAbbr,A.Jumlah_IdealKar,B.Jumlah,(A.Jumlah_IdealKar - B.Jumlah) as Sisa,D.requstK FROM tblMstIdeal as A left join (SELECT B.DeptID,B.DeptAbbr,COUNT(A.BagianID) as Jumlah FROM (SELECT * FROM RSUPPayroll .dbo.vwDataKaryawanNonFinance) as A left join(SELECT * FROM tblMstDepartemenNew where NotActive = '0') as B ON A.BagianID = B.BagianIDPayroll  GROUP BY B.DeptID,B.DeptAbbr) as B ON A.DeptID = B.DeptID left join (SELECT distinct DeptID,DeptAbbr FROM tblMstDepartemenNew where NotActive = 0) as C ON A.DeptID = C.DeptID left join  (SELECT DeptID,SUM(TKPermintaan) AS requstK FROM vwApprovalAll where (GeneralStatus = '1' OR GeneralStatus IS NULL) AND Pemborong IN ('RSUP') and YEAR(CreatedDate) = '$tahun' GROUP BY DeptID) as D ON A.DeptID = D.DeptID
        where A.DeptID = '$deptid' ORDER BY A.DeptID ASC");
        return $query->result();
    }

    function get_RealBor($deptid){
        $tahun = date('Y');
        $query = $this->db->query("SELECT distinct A.DeptID,C.DeptAbbr,A.Jumlah_IdealBor,B.Jumlah,(A.Jumlah_IdealBor - B.Jumlah) as Sisa,D.requstK FROM tblMstIdeal as A left join (SELECT B.DeptID,B.DeptAbbr,COUNT(A.BagianID) as Jumlah FROM (SELECT * FROM RSUPPayroll .dbo.vwDataKaryawanNonFinance) as A left join(SELECT * FROM tblMstDepartemenNew where NotActive = '0') as B ON A.BagianID = B.BagianIDPayroll  GROUP BY B.DeptID,B.DeptAbbr) as B ON A.DeptID = B.DeptID left join (SELECT distinct DeptID,DeptAbbr FROM tblMstDepartemenNew where NotActive = 0) as C ON A.DeptID = C.DeptID left join  (SELECT DeptID,SUM(TKPermintaan) AS requstK FROM vwApprovalAll where (GeneralStatus = '1' OR GeneralStatus IS NULL) AND Pemborong NOT IN ('RSUP') and YEAR(CreatedDate) = '$tahun' GROUP BY DeptID) as D ON A.DeptID = D.deptid where A.DeptID = '$deptid' 
            ORDER BY A.DeptID ASC");
        return $query->result();
    }
}