<?php
defined('BASEPATH') or exit('No Direct Script Access Allowed');

class m_monitoringtenagakerja extends CI_Model{
	function getPemborong(){
		return $this->db->query("select * from vwMstPemborong")->result();
	}

	function getTypependidikan(){
		return $this->db->query("select * from tblTypePendidikan")->result();
	}

	function getMasterJurusan(){
		return $this->db->query("select * from tblMstJurusan")->result();
	}

	function get_viewall($bulan,$tahun,$pemborong,$jeniskelamin,$pendidikan,$jurusan){
		if ($bulan=='0') {
			$bulannya='';
		}else{
			$bulannya="and MONTH(RegisteredDate)='$bulan'";
		}

		if ($tahun=='0') {
			$tahunnya='';
		}else{
			$tahunnya="and YEAR(RegisteredDate)='$tahun'";
		}
		if ($pemborong=='0') {
			$pemborongnya='';
		}else{
			$pemborongnya="and IDPemborong='$pemborong'";
		}

		if ($jeniskelamin=='0') {
			$jeniskelaminnya='';
		}else{
			$jeniskelaminnya="and Jenis_Kelamin='$jeniskelamin'";
		}

		if ($pendidikan=='0') {
			$pendidikannya='';
		}else{
			$pendidikannya="and ID_Typependidikan='$pendidikan'";
		}
		if ($jurusan=='0') {
			$jurusannya='';
		}else{
			$jurusannya="and IDJurusan='$jurusan'";
		}
		
		return $this->db->query("select * from vwListBerkas where Verified='1' $bulannya $tahunnya $pemborongnya $jeniskelaminnya $pendidikannya $jurusannya")->result();
	}

	function getDataPosting($bulan,$tahun,$pemborong,$jeniskelamin,$pendidikan,$jurusan){
		if ($bulan=='0') {
			$bulannya='';
		}else{
			$bulannya="and MONTH(PostingDate)='$bulan'";
		}

		if ($tahun=='0') {
			$tahunnya='';
		}else{
			$tahunnya="and YEAR(PostingDate)='$tahun'";
		}

		if ($pemborong=='0') {
			$pemborongnya='';
		}else{
			$pemborongnya="and IDPemborong='$pemborong'";
		}

		if ($jeniskelamin=='0') {
			$jeniskelaminnya='';
		}else{
			$jeniskelaminnya="and Jenis_Kelamin='$jeniskelamin'";
		}

		if ($pendidikan=='0') {
			$pendidikannya='';
		}else{
			$pendidikannya="and ID_Typependidikan='$pendidikan'";
		}
		if ($jurusan=='0') {
			$jurusannya='';
		}else{
			$jurusannya="and IDJurusan='$jurusan'";
		}

		return $this->db->query("select * from vwListBerkas where PostingData = '1' $bulannya $tahunnya $pemborongnya $jeniskelaminnya $pendidikannya $jurusannya")->result();
	}

	function getDataGagalScreening($bulan,$tahun,$pemborong,$jeniskelamin,$pendidikan,$jurusan){
		if ($bulan=='0') {
			$bulannya='';
		}else{
			$bulannya="and MONTH(RegisteredDate) = '$bulan'";
		}

		if ($tahun=='0') {
			$tahunnya='';
		}else{
			$tahunnya="and YEAR(RegisteredDate)='$tahun'";
		}
		if ($pemborong=='0') {
			$pemborongnya='';
		}else{
			$pemborongnya="and IDPemborong='$pemborong'";
		}

		if ($jeniskelamin=='0') {
			$jeniskelaminnya='';
		}else{
			$jeniskelaminnya="and Jenis_Kelamin='$jeniskelamin'";
		}

		if ($pendidikan=='0') {
			$pendidikannya='';
		}else{
			$pendidikannya="and ID_Typependidikan='$pendidikan'";
		}
		if ($jurusan=='0') {
			$jurusannya='';
		}else{
			$jurusannya="and IDJurusan='$jurusan'";
		}
		return $this->db->query("select * from vwListBerkas where PostingData = '0' AND GeneralStatus = '1' AND WawancaraKe Is Not NULL AND DeptTujuan Is Not NULL AND WawancaraHasil = '1' AND SpecialScreening = '0' $bulannya $tahunnya $pemborongnya $jeniskelaminnya $pendidikannya $jurusannya")->result();
	}

	function getDataBelumWawancara($bulan,$tahun,$pemborong,$jeniskelamin,$pendidikan,$jurusan){
		if ($bulan=='0') {
			$bulannya='';
		}else{
			$bulannya="and MONTH(RegisteredDate) = '$bulan'";
		}

		if ($tahun=='0') {
			$tahunnya='';
		}else{
			$tahunnya="and YEAR(RegisteredDate)='$tahun'";
		}
		if ($pemborong=='0') {
			$pemborongnya='';
		}else{
			$pemborongnya="and IDPemborong='$pemborong'";
		}

		if ($jeniskelamin=='0') {
			$jeniskelaminnya='';
		}else{
			$jeniskelaminnya="and Jenis_Kelamin='$jeniskelamin'";
		}

		if ($pendidikan=='0') {
			$pendidikannya='';
		}else{
			$pendidikannya="and ID_Typependidikan='$pendidikan'";
		}
		if ($jurusan=='0') {
			$jurusannya='';
		}else{
			$jurusannya="and IDJurusan='$jurusan'";
		}
		return $this->db->query("select * FROM vwListBerkas where PostingData = '0' AND GeneralStatus = '0' AND WawancaraKe is null $bulannya $tahunnya $pemborongnya $jeniskelaminnya $pendidikannya $jurusannya")->result();
	}

	function getDataTelahWawancara($bulan,$tahun,$pemborong,$jeniskelamin,$pendidikan,$jurusan){
		if ($bulan=='0') {
			$bulannya='';
		}else{
			$bulannya="and MONTH(RegisteredDate) = '$bulan'";
		}

		if ($tahun=='0') {
			$tahunnya='';
		}else{
			$tahunnya="and YEAR(RegisteredDate)='$tahun'";
		}
		if ($pemborong=='0') {
			$pemborongnya='';
		}else{
			$pemborongnya="and IDPemborong='$pemborong'";
		}

		if ($jeniskelamin=='0') {
			$jeniskelaminnya='';
		}else{
			$jeniskelaminnya="and Jenis_Kelamin='$jeniskelamin'";
		}

		if ($pendidikan=='0') {
			$pendidikannya='';
		}else{
			$pendidikannya="and ID_Typependidikan='$pendidikan'";
		}
		if ($jurusan=='0') {
			$jurusannya='';
		}else{
			$jurusannya="and IDJurusan='$jurusan'";
		}
		return $this->db->query("select * FROM vwListBerkas WHERE PostingData = '0' AND GeneralStatus = '0' AND WawancaraKe Is Not NULL AND ScreeningHasil = '1' $bulannya $tahunnya $pemborongnya $jeniskelaminnya $pendidikannya $jurusannya")->result();
	}
	function countPemborongTgl($Tahun,$Bulan){
        $query = $this->db->query("SELECT Pemborong = Pemborong COLLATE SQL_Latin1_General_CP1_CI_AS, SMU_SEDERAJAT_P, SMU_SEDERAJAT_L, NON_PENDIDIKAN_P, NON_PENDIDIKAN_L FROM vwTotalTKperPemborong Where Tahun = '".$Tahun."' AND Bulan = '".$Bulan."' AND Pemborong NOT IN ('H. JASRI VIII','0','PINEFEED','','BLR','PERUMAHAN','ALL PEMBORONG','CV. SURYA ABADI','SUHARDI-2','H. JASRI IV','H. MONEL','JEFRIZAL','RSUP') AND Pemborong IS NOT NULL ORDER BY Pemborong ASC");
        return $query->result();
    }

    function getSemuaTahun(){
    	return $this->db->query("select * from vwListBerkas where year(RegisteredDate) = '2016' or year(RegisteredDate) ='2018'")->result();
    }
}
?>