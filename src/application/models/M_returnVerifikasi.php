<?php defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_returnVerifikasi extends CI_Model{

	function getData($bulan,$tahun){
		
		$this->db->where('MONTH(VerifiedDate)',$bulan);
		$this->db->where('YEAR(VerifiedDate)',$tahun);
		$this->db->where('Verified IS NOT NULL');
        return $this->db->get('tblTrnCalonTenagaKerja')->result();
	}

	function simpan($id,$data){
		$this->db->where('HeaderID',$id);
		$this->db->update('tblTrnCalonTenagaKerja',$data);
	}
}