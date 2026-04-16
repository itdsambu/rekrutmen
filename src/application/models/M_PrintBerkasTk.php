<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_PrintBerkasTk extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }

    function get_tenagakerja(){
    	$tahun1 = date('Y') - 1;
        $tahun2 = date('Y');
        $query = $this->db->query("SELECT * from vwListBerkas where (ScreeningComplete IS NULL OR ScreeningComplete = 'true') and (YEAR(RegisteredDate) = '$tahun1' OR YEAR(RegisteredDate) = '$tahun2') and FisikCek IS NULL and GeneralStatus = '0'  and Jenis_Kelamin ='laki-laki'");
        return $query->result();
    }

    function get_departemen(){
    	$query = $this->db->query("SELECT distinct DeptID,DeptAbbr FROM tblMstDepartemenNew where DeptAbbr IN ('PBL','WHK')");
    	return $query->result();
    }

     function get_departemen_pam(){
        $query = $this->db->query("SELECT DeptID,DeptAbbr FROM tblMstDepartemenNew where DeptAbbr IN ('PAM')");
        return $query->result();
    }

    function get_tenagakerja_wawancara($tanggal,$depttujuan){
    	$query = $this->db->query("SELECT * FROM vwListBerkas where Verified = '1' and CONVERT(DATE,DeptTujuanDate) ='$tanggal' and DeptTujuan  = '$depttujuan' and WawancaraCek IS NULL");
    	return $query->result();
    }   

    function get_tenagakerja_cekfisik(){
    	$tahun1 = date('Y') - 1;
    	$tahun2 = date('Y');
    	$query = $this->db->query("SELECT * from vwListBerkas where (ScreeningComplete IS NULL OR ScreeningComplete = 'true') and (YEAR(RegisteredDate) = '$tahun1' OR YEAR(RegisteredDate) = '$tahun2') and FisikCek IS NULL and GeneralStatus = '0'");
    	return $query->result();
    }

    function simpan($headerid,$data){
    	$this->db->where("HeaderID",$headerid);
    	$this->db->update('tblTrnCalonTenagaKerja',$data);
    }
}