<?php defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_tambahidealkaryawan extends CI_Model{

	public function __construct() {
        parent::__construct();
    }

    function get_Dept(){
    	$query = $this->db->query("SELECT distinct DeptID,DeptAbbr FROM tblMstDepartemenNew ORDER BY DeptAbbr");
    	return $query->result();
    }

    function Simpan_idealkaryawan($data){
    	$this->db->insert('tblTrnPermintaan',$data);
    }

    function get_Data(){
    	$query = $this->db->query("SELECT distinct IDPermintaan,DeptID,DeptAbbr,Idealkaryawan,Realkaryawan,Idealtenagakerja,Realtenagakerja,CreatedBy,CreatedDate,UpdateBy,UpdateDate FROM vw_permintaanideal");
    	return $query->result();
    }

    function get_DataPermintaan($id){
        $query = $this->db->query("SELECT * FROM vw_permintaanideal WHERE IDPermintaan = '$id'");
        return $query->result();
    }

    function Update($id,$dataUpdate){
        $this->db->where('IDPermintaan',$id);
        $this->db->update('tblTrnPermintaan',$dataUpdate);
    }
    function get_DataK(){
        $tahun = date('Y');
        $query = $this->db->query("SELECT B.IDPermintaan,A.DeptID,A.DeptAbbr,B.Idealkaryawan,B.Realkaryawan,B.Idealtenagakerja,B.Realtenagakerja,SUM(TKPermintaan) AS requestKary FROM vwApprovalAll AS A LEFT JOIN tblTrnPermintaan AS B ON A.DeptID = B.DeptID WHERE YEAR(A.CreatedDate) = '$tahun' AND Pemborong IN('RSUP') and (GeneralStatus = 1 or GeneralStatus is null) GROUP BY B.IDPermintaan,A.DeptID,A.DeptAbbr,B.Idealkaryawan,B.Realkaryawan,B.Idealtenagakerja,B.Realtenagakerja");
        return $query->result();
    }

    function get_DataTK(){
        $tahun = date('Y');
        $query = $this->db->query("SELECT A.IDPermintaan,B.DeptID,B.DeptAbbr,B.Pemborong,A.Idealtenagakerja,A.Realtenagakerja,SUM(B.TKPermintaan) AS requstTK FROM tblTrnPermintaan AS A LEFT JOIN vwApprovalAll B ON A.DeptID = B.DeptID WHERE year(B.CreatedDate) = '$tahun' AND Pemborong IN ('ALL PEMBORONG') AND (GeneralStatus = 1 OR GeneralStatus is NULL) GROUP BY A.IDPermintaan,B.DeptID,B.DeptAbbr,B.Pemborong,A.Idealtenagakerja,A.Realtenagakerja");
        return $query->result();
    }

    function get_dataIdeal($id){
    $query = $this->db->query("SELECT * FROM vw_permintaanideal WHERE DeptID = '$id'");
        return $query->result();
    }

    function cek_Data($id){
        $query = $this->db->query("SELECT * FROM tblTrnPermintaan where DeptID = '$id'");
            return $query->result();
    }
}