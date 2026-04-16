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

	function update($calon,$data){
        $this->db->where('CalonPelamarID',$calon);
        $this->db->update('tblTrnCalonKandidatNew',$data);
    }

	function simpan_interview($dataIntr){
		$this->db->insert('TblMntInterview',$dataIntr);
        $primay_key = $this->db->insert_id();
        return $primay_key;
	}

	function simpan_calon_karantina($dataCalonKarantina){
		$this->db->insert('tblTrnPraPelamar',$dataCalonKarantina);
        $primay_key = $this->db->insert_id();
        return $primay_key;
	}

	function simpan_reg($dataRegistrasi){
		$this->db->insert('tblTrnCalonTenagaKerja',$dataRegistrasi);
        $primay_key = $this->db->insert_id();
        return $primay_key;
	}

	function simpan_berkas($dataBerkas){
		$this->db->insert('tblTrnBerkas',$dataBerkas);
	}

	function _getListData(){
		$query = $this->db->query("SELECT *,DATEDIFF(YEAR,TanggalLahir,GETDATE()) as Umur FROM vwCalonKandidat where DeletedBy is null");
		return $query->result();
	}

	function _getByID($CalonPelamarID){
		$query = $this->db->query("SELECT * FROM vwCalonKandidat where CalonPelamarID = '$CalonPelamarID'");
		return $query->result();
	}

	function update_data($calonid,$data){
		$this->db->where("CalonPelamarID",$calonid);
		$this->db->update("tblTrnCalonKandidatNew",$data);
	}

	function _getCalon($hdrid){
		$query = $this->db->query("SELECT * FROM vwCalonKandidat WHERE HeaderID = '$hdrid'");
		return $query->result();
	}

	function get_db_berkas($id){
		$query = $this->db->query("SELECT * FROM tblTrnBerkas WHERE HeaderID = '$id'");
		return $query->result();
	}

	function update_db_berkas($hdrid,$berkas,$lokasi){		
        $this->db->trans_start();
        $this->db->where('HeaderID',$hdrid);
        $this->db->update('tblTrnBerkas',array($berkas => $lokasi));
        $this->db->trans_complete();
    }

    function update_db_berkasKarantina($hdrid,$berkas,$lokasi){		
        $this->db->trans_start();
        $this->db->where('Pra_PelamarID',$hdrid);
        $this->db->update('tblTrnBerkasPra',array($berkas => $lokasi));
        $this->db->trans_complete();
    }

    function minimal_berkas($hdrid){
        $minimalberkas = 1;
        // $query = $this->db->query("SELECT HeaderID from tblTrnBerkas Where HeaderID = '$hdrid' and KTP is not null");
        $query = $this->db->query("SELECT HeaderID from tblTrnBerkas Where HeaderID = '$hdrid'");
        if ($query->num_rows() < 0){
            $minimalberkas = 1;
        }
        return $minimalberkas;
    }

    function getDocs($userID){
        $query = $this->db->query("SELECT * FROM tblTrnBerkas WHERE HeaderID ='".$userID."'");
        return $query->result();
    }


    function _getMstGaji(){
    	$query = $this->db->query("SELECT * FROM tblMstGaji");
		return $query->result();
    }

    function _getListDataByJurusan($jurusan){
    	$query = $this->db->query("SELECT *,DATEDIFF(YEAR,TanggalLahir,GETDATE()) as Umur FROM vwCalonKandidat where Jurusan = '".$jurusan."'");
		return $query->result();
    }

    function _getGajiByID($gaji){
    	$query = $this->db->query("SELECT * FROM tblMstGaji WHERE GajiID = '".$gaji."' ");
		return $query->result();
    }

    function _getListDataByGaji($gaji_1,$gaji_2){
    	$query = $this->db->query("SELECT *,DATEDIFF(YEAR,TanggalLahir,GETDATE()) as Umur FROM vwCalonKandidat where Gaji BETWEEN '".$gaji_1."' AND '".$gaji_2."'");
    	return $query->result();
    }

    function _getListDataPertanggal($tglawal,$tglakhir){
    	$query = $this->db->query("SELECT *,DATEDIFF(YEAR,TanggalLahir,GETDATE()) as Umur FROM vwCalonKandidat where CONVERT(DATE,CreatedDate) >= '".$tglawal."' AND CONVERT(DATE,CreatedDate) <= '".$tglakhir."'");
    	return $query->result();
    }

    function _getByCalonTenagaKerja($hdrid)
    {
    	$query = $this->db->query("SELECT * from tblTrnCalonTenagaKerja where HeaderID = '$hdrid'");
    	return $query->result();
    }
}