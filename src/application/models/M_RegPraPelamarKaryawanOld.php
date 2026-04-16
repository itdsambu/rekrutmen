<?php
defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_RegPraPelamarKaryawan extends CI_Model{

	function _getMstPendidikan(){
		$query = $this->db->query("SELECT * FROM tblMstPendidikan where ID not in (1,2,3)");
		return $query->result();
	}

	function _getMstJurusan(){
		$query = $this->db->query("SELECT * FROM tblMstJurusan ORDER BY Jurusan ASC");
		return $query->result();
	}

	function simpan($data){
		$this->db->insert('tblTrnCalonKandidatNew',$data);
        $primay_key = $this->db->insert_id();
        return $primay_key;
	}

	function simpan_interview($dataIntr){
		$this->db->insert('TblMntInterview',$dataIntr);
	}

	function simpan_berkas($dataBerkas){
		$this->db->insert('tblTrnBerkasPraKry',$dataBerkas);
	}

	function _getListData(){
		$query = $this->db->query("SELECT * FROM vwCalonKandidat");
		return $query->result();
	}

	function update($id,$data){
		$this->db->where("CalonPelamarID",$id);
		$this->db->update("tblTrnCalonKandidatNew",$data);
	}

	function _getCalon($id){
		$query = $this->db->query("SELECT * FROM tblTrnCalonKandidatNew WHERE CalonPelamarID = '$id'");
		return $query->result();
	}

	function get_db_berkas($id){
		$query = $this->db->query("SELECT * FROM tblTrnBerkasPraKry WHERE CalonPelamarID = '$id'");
		return $query->result();
	}

	function update_db_berkas($hdrid,$berkas,$lokasi){		
        $this->db->trans_start();
        $this->db->where('CalonPelamarID',$hdrid);
        $this->db->update('tblTrnBerkasPraKry',array($berkas => $lokasi));
        $this->db->trans_complete();
    }

    function minimal_berkas($hdrid){
        $minimalberkas = 0;
        $query = $this->db->query("SELECT CalonPelamarID from tblTrnBerkasPraKry Where CalonPelamarID = '$hdrid' and KTP is not null and Lamaran is not null");
        if ($query->num_rows() > 0){
            $minimalberkas=1;
        }
        return $minimalberkas;
    }

    function getDocs($userID){
        $query = $this->db->query("SELECT * FROM tblTrnBerkasPraKry WHERE CalonPelamarID ='".$userID."'");
        return $query->result();
    }


    function _getMstGaji(){
    	$query = $this->db->query("SELECT * FROM tblMstGaji");
		return $query->result();
    }

    function _getListDataByJurusan($jurusan){
    	$query = $this->db->query("SELECT * FROM vwCalonKandidat where Jurusan = '".$jurusan."'");
		return $query->result();
    }

    function _getGajiByID($gaji){
    	$query = $this->db->query("SELECT * FROM tblMstGaji WHERE GajiID = '".$gaji."' ");
		return $query->result();
    }

    function _getListDataByGaji($gaji_1,$gaji_2){
    	$query = $this->db->query("SELECT * FROM vwCalonKandidat where Gaji BETWEEN '".$gaji_1."' AND '".$gaji_2."'");
    	return $query->result();
    }
}