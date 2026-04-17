<?php defined('BASEPATH') OR exit ('No direct script access allowed');
/**
 * ITD 31
 */
class M_PapiKostickReport extends CI_Model
{
	function get_DataKaryawan($nama){
		$query = $this->db->query("SELECT * from tblTrnCalonKandidatNew where CalonPelamarID LIKE '%$nama%' OR Nama LIKE '%$nama%'");
		return $query->result();
	}

	function get_Data($nama){
    	$query = $this->db->query("SELECT CalonPelamarID,Nama,TanggalLahir,datediff(YY,TanggalLahir,GETDATE()) as Umur,DeptAbbr, Pendidikan, JenisKelamin from vwCalonKandidat where CalonPelamarID = '$nama'");
		return $query->result();
    }
    function getList(){
        $query = $this->db->query("select * from vwCalonKandidat order by JadwalTes desc");
        return $query->result();
    }
    function getListdua(){
        $query = $this->db->query("select TOP(1000) * from vwCalonKandidat as A join tblTrnPsychologicalTest as B ON A.CalonPelamarID = B.HeaderID order by JadwalTes desc");
        return $query->result();
    }
    function save($data){
    	$this->db->insert('tblTrnPapikostick',$data);
    }
    function perbaharui($id,$data){
    	$this->db->where('HeaderID', $id);
    	$this->db->update('tblTrnPapikostick',$data);
    }
    function cekPapikostick($HeaderID){
    	$this->db->where('HeaderID', $HeaderID);
    	$query = $this->db->get('tblTrnPapikostick');
    	return $query->result();
    }
} 