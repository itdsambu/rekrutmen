<?php 
defined ('BASEPATH') OR exit ('No direct script access allowed');
class m_PsychologicalAssisment extends CI_Model{

	function simpan($data){
		$this->db->insert('tblTrnPsychologicalTest',$data);
	}
	function perbaharui($id, $data){
		$this->db->where('HeaderID',$id);
		$this->db->update('tblTrnPsychologicalTest',$data);
	}
	function save($data){
		$this->db->insert('tblTrnDiscAssisment',$data);
	}
	function update($id,$data){
		$this->db->where('HeaderID', $id);
		$this->db->update('tblTrnDiscAssisment',$data);
	}
	function savefiroB($data){ 
		$this->db->insert('tblTrnFiroB',$data);
	}
	function updatefiroB($id,$data){
		$this->db->where('HeaderID', $id);
		$this->db->update('tblTrnFiroB',$data);
	}
	function get_DataPsychologi(){
		return $this->db->query("select CalonPelamarID, Nama, TanggalLahir FROM tblTrnCalonKandidatNew")->result();	
	}
	function get_DataKaryawan($nama){
		$query = $this->db->query("SELECT * from tblTrnCalonKandidatNew where CalonPelamarID LIKE '%$nama%' OR Nama LIKE '%$nama%'");
		return $query->result();
	}

    function get_Data($id){
    	$query = $this->db->query("SELECT CalonPelamarID,Nama,TanggalLahir,datediff(YY,TanggalLahir,GETDATE()) as Umur,DeptAbbr, Pendidikan, JenisKelamin from vwCalonKandidat where CalonPelamarID = '$id'");
		return $query->result();
    }
    function getList(){
        $query = $this->db->query("select TOP(1000) * from vwCalonKandidat order by JadwalTes desc");
        return $query->result();
    }
    function getListdua(){
        $query = $this->db->query("select TOP(1000) * from vwCalonKandidat as A join tblTrnPsychologicalTest as B ON A.CalonPelamarID = B.HeaderID order by JadwalTes desc");
        return $query->result();
    }
    function simpanMbti($data){
    	$this->db->insert('tblTrnMbtiTest', $data);
    }
    function perbaharuiMbti($id,$data){
    	$this->db->where('HeaderID', $id);
    	$this->db->update('tblTrnMbtiTest',$data);
    }
    function getKaryawanMbti($nama){
		$query = $this->db->query("SELECT * from tblTrnCalonKandidatNew where CalonPelamarID LIKE '%$nama%' OR Nama LIKE '%$nama%'");
		return $query->result();
	}
	function getDataMbti($id){
    	$query = $this->db->query("SELECT CalonPelamarID,Nama,TanggalLahir,datediff(YY,TanggalLahir,GETDATE()) as Umur,DeptAbbr, Pendidikan, JenisKelamin from vwCalonKandidat where CalonPelamarID = '$id'");
		return $query->result();
    }

    function simpanSds($data){
    	$this->db->insert('tblTrnSdsTest', $data);
    }
    function perbaharuiSds($id,$data){
    	$this->db->where('HeaderID', $id);
    	$this->db->update('tblTrnSdsTest',$data);
    }
    function getKaryawanSds($nama){
		$query = $this->db->query("SELECT * from tblTrnCalonKandidatNew where CalonPelamarID LIKE '%$nama%' OR Nama LIKE '%$nama%'");
		return $query->result();
	}
	function getDataSds($id){
    	$query = $this->db->query("SELECT CalonPelamarID,Nama,TanggalLahir,datediff(YY,TanggalLahir,GETDATE()) as Umur,DeptAbbr, Pendidikan, JenisKelamin from vwCalonKandidat where CalonPelamarID = '$id'");
		return $query->result();
    }

    function simpanBelbin($data){
    	$this->db->insert('tblTrnBelbinTest', $data);
    }
    function perbaharuiBelbin($id,$data){
    	$this->db->where('HeaderID',$id);
    	$this->db->update('tblTrnBelbinTest',$data);
    }
    function getKaryawanBelbin($nama){
		$query = $this->db->query("SELECT * from tblTrnCalonKandidatNew where CalonPelamarID LIKE '%$nama%' OR Nama LIKE '%$nama%'");
		return $query->result();
	}
	function getDataBelbin($id){
    	$query = $this->db->query("SELECT CalonPelamarID,Nama,TanggalLahir,datediff(YY,TanggalLahir,GETDATE()) as Umur,DeptAbbr, Pendidikan, JenisKelamin from vwCalonKandidat where CalonPelamarID = '$id'");
		return $query->result();
    }

    function cekPsychoTest($HeaderID){
    	$this->db->where('HeaderID', $HeaderID);
    	$query = $this->db->get('tblTrnPsychologicalTest');
    	return $query->result();
    }
    function cekDiscAsses($HeaderID){
    	$this->db->where('HeaderID', $HeaderID);
    	$query = $this->db->get('tblTrnDiscAssisment');
    	return $query->result();
    }
    function cekfiroB($HeaderID){
    	$this->db->where('HeaderID', $HeaderID);
    	$query = $this->db->get('tblTrnFiroB');
    	return $query->result();
    }
    function cekMbti($HeaderID){
    	$this->db->where('HeaderID', $HeaderID);
    	$query = $this->db->get('tblTrnMbtiTest');
    	return $query->result();
    }
    function cekSds($HeaderID){
    	$this->db->where('HeaderID', $HeaderID);
    	$query = $this->db->get('tblTrnSdsTest');
    	return $query->result();
    }
    function cekBelbin($HeaderID){
    	$this->db->where('HeaderID', $HeaderID);
    	$query = $this->db->get('tblTrnBelbinTest');
    	return $query->result();
    }
}