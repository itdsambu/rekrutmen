<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class M_approval_spmk extends CI_Model
{

	function get_tenagakerja($tanggal){
		$tahun = date('Y');
		 $grupID = $this->session->userdata('groupuser');
		$query = $this->db->query("SELECT * FROM (SELECT A.HeaderID,a.Nama,A.Pemborong,A.DeptTujuan,A.Tempat_Lahir,A.Tgl_Lahir,A.Jenis_Kelamin,a.NamaIbuKandung,a.Alamat,A.ApproveSPMKKasift,A.ApproveSPMKKasiftBy,A.ApproveSPMKKasiftDate,A.ApproveSPMKPimpinan,A.ApproveSPMKPimpinanBy,a.ApproveSPMKPimpinanDate,B.NIK,B.TanggalMasuk,B.CreatedBy,B.CreatedDate , case when  A.DeptTujuan in ('MP1','MP2') THEN ApproveSPMKKasift ELSE 1 END AS APPKASI FROM (SELECT * FROM tblTrnCalonTenagaKerja where Pemborong not in ('RSUP') and Nofix is not null) as A left join (SELECT * FROM RSUPBorongan2010..tblMstTenagaKerja) as B ON A.Nofix = b.Nofix) AS A where A.DeptTujuan IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID ='$grupID')  and A.APPKASI = '1' and A.ApproveSPMKPimpinan is null and Year(A.TanggalMasuk) = '$tahun'");
		return $query->result(); 
	}


	function get_karyawan($tanggal){
		$tahun = date('Y');
		$grupID = $this->session->userdata('groupuser');
		$query = $this->db->query("SELECT A.*,B.NIK,B.TGLMASUK FROM (SELECT * FROM tblTrnCalonTenagaKerja where Pemborong in ('RSUP') and Nofix is not null) as A left join (SELECT * FROM RSUPPayroll..vwDataKaryawanNonFinance ) as B ON A.Nofix = B.RegNo where  A.DeptTujuan IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID ='$grupID') and A.ApproveSPMKPimpinan is null and Year(B.TGLMASUK) = '$tahun'");
		return $query->result();
	}

	function get_tenagakerja_kasift($tanggal){
		$grupID = $this->session->userdata('groupuser');
		$tahun = date('Y');
		$query = $this->db->query("SELECT A.*,C.*,B.NIK,B.TanggalMasuk,B.CreatedBy,B.CreatedDate FROM (SELECT * FROM tblTrnCalonTenagaKerja where Pemborong not in ('RSUP') and Nofix is not null) as A left join (SELECT * FROM RSUPBorongan2010..tblMstTenagaKerja) as B ON A.Nofix = b.Nofix left join tblTrnWawancara as C ON A.HeaderID = C.HeaderID  where  Year(B.TanggalMasuk) = '$tahun' AND A.DeptTujuan IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID ='$grupID') and A.ApproveSPMKKasift is null and A.DeptTujuan in ('MP1','MP2') and HasilWawancara = '1'");
		return $query->result(); 
	}

	function get_karyawan_kasift($tanggal){
		$grupID = $this->session->userdata('groupuser');
		$tahun = date('Y');
		$query = $this->db->query("SELECT A.*,B.NIK,B.TGLMASUK FROM (SELECT * FROM tblTrnCalonTenagaKerja where Pemborong in ('RSUP') and Nofix is not null) as A left join (SELECT * FROM RSUPPayroll..vwDataKaryawanNonFinance ) as B ON A.Nofix = B.RegNo where  Year(B.TGLMASUK) = '$tahun'  AND A.DeptTujuan IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID ='$grupID') and A.ApproveSPMKKasift is null and A.DeptTujuan in ('MP1','MP2')");
		return $query->result();
	}

	function update($hdrid,$data){
 		$this->db->where('HeaderID',$hdrid);
 		$this->db->update('tblTrnCalonTenagaKerja',$data);
 	}

 	function get_mon_tenagakerja($tanggal){
		 $grupID = $this->session->userdata('groupuser');
		$query = $this->db->query("SELECT A.*,C.*,B.NIK,B.TanggalMasuk,B.CreatedBy,B.CreatedDate,DATEDIFF(DAY,B.TanggalMasuk,A.ApproveSPMKPimpinanDate) as TotalHariPimpinan,DATEDIFF(DAY,B.TanggalMasuk,A.ApproveSPMKKasiftDate) as TotalHariKasift FROM (SELECT * FROM tblTrnCalonTenagaKerja where Pemborong not in ('RSUP') and Nofix is not null) as A left join (SELECT * FROM RSUPBorongan2010..tblMstTenagaKerja) as B ON A.Nofix = b.Nofix left join tblTrnWawancara as C ON A.HeaderID = C.HeaderID where B.TanggalMasuk = '$tanggal' and C.Grade = 'LULUS' AND A.DeptTujuan IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID ='$grupID')");
		return $query->result(); 
	}


	function get_mon_karyawan($tanggal){
		$grupID = $this->session->userdata('groupuser');
		$query = $this->db->query("SELECT A.*,B.NIK,B.TGLMASUK,DATEDIFF(DAY,B.TGLMASUK,A.ApproveSPMKPimpinanDate) as TotalHariPimpinan,DATEDIFF(DAY,B.TGLMASUK,A.ApproveSPMKKasiftDate) as TotalHariKasfit FROM (SELECT * FROM tblTrnCalonTenagaKerja where Pemborong in ('RSUP') and Nofix is not null) as A left join (SELECT * FROM RSUPPayroll..vwDataKaryawanNonFinance ) as B ON A.Nofix = B.RegNo where B.TGLMASUK = '$tanggal' AND A.DeptTujuan IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID ='$grupID')");
		return $query->result();
	}

	function get_ajax_tenagakerja($tgl_awal,$tgl_akhir){
		$grupID = $this->session->userdata('groupuser');
		$query = $this->db->query("SELECT A.*,C.*,B.NIK,B.TanggalMasuk,B.CreatedBy,B.CreatedDate,DATEDIFF(DAY,B.TanggalMasuk,A.ApproveSPMKPimpinanDate) as TotalHariPimpinan,DATEDIFF(DAY,B.TanggalMasuk,A.ApproveSPMKKasiftDate) as TotalHariKasift FROM (SELECT * FROM tblTrnCalonTenagaKerja where Pemborong not in ('RSUP') and Nofix is not null) as A left join (SELECT * FROM RSUPBorongan2010..tblMstTenagaKerja) as B ON A.Nofix = b.Nofix left join tblTrnWawancara as C ON A.HeaderID = C.HeaderID where CONVERT(date,B.TanggalMasuk) >='$tgl_awal' and CONVERT(DATE,B.TanggalMasuk) <= '$tgl_akhir'  and C.Grade = 'LULUS' AND A.DeptTujuan IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID ='$grupID')");
		return $query->result();
	}

	function get_ajax_karyawan($tgl_awal,$tgl_akhir){
		$grupID = $this->session->userdata('groupuser');
		$query = $this->db->query("SELECT A.*,B.NIK,B.TGLMASUK,DATEDIFF(DAY,B.TGLMASUK,A.ApproveSPMKPimpinanDate) as TotalHariPimpinan,DATEDIFF(DAY,B.TGLMASUK,A.ApproveSPMKKasiftDate) as TotalHariKasfit FROM (SELECT * FROM tblTrnCalonTenagaKerja where Pemborong in ('RSUP') and Nofix is not null) as A left join (SELECT * FROM RSUPPayroll..vwDataKaryawanNonFinance ) as B ON A.Nofix = B.RegNo where CONVERT(date,B.TGLMASUK) >='$tgl_awal' and CONVERT(DATE,B.TGLMASUK) <= '$tgl_akhir' AND A.DeptTujuan IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID ='$grupID')");
		return $query->result();
	}
}