<?php 
defined ('BASEPATH') OR exit ('No direct script access allowed');

class m_HasiltestKepribadian extends CI_Model{
	function simpan($data){
		$this->db->insert('tblTrnHasilKepribadian',$data);
	}
	function perbaharui($id,$data){
    	$this->db->where('HeaderID', $id);
    	$this->db->update('tblTrnHasilKepribadian',$data);
    }
	function getKaryawan($nama){
		$query = $this->db->query("SELECT * from tblTrnCalonTenagaKerja where HeaderID LIKE '%$nama%' OR Nama LIKE '%$nama%'");
		return $query->result();
	}
	function getData($id){
    	$query = $this->db->query("SELECT HeaderID,Nama,Tgl_Lahir,datediff(YY,Tgl_Lahir,GETDATE()) as Umur,DeptTujuan, Pendidikan, Jenis_Kelamin, Tempat_Lahir, Pemborong from tblTrnCalonTenagaKerja where HeaderID = '$id'");
		return $query->result();
    }
    function cekHasil($HeaderID){
    	$this->db->where('HeaderID', $HeaderID);
    	$query = $this->db->get('tblTrnHasilKepribadian');
    	return $query->result();
    }
}