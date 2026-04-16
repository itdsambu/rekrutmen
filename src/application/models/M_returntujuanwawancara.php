<?php defined('BASEPATH') or exit('No Direct Script Access Allowed');

class m_returntujuanwawancara extends CI_Model{

	function get_DataReturnTujuanWawancara($bulan,$tahun){
		$this->db->where('MONTH(DeptTujuanDate)',$bulan);
		$this->db->where('YEAR(DeptTujuanDate)',$tahun);
		$this->db->where('DeptTujuan IS NOT NULL');
        return $this->db->get('tblTrnCalonTenagaKerja')->result();
	}

	function simpan($id,$data){
		$this->db->where('HeaderID',$id);
		$this->db->update('tblTrnCalonTenagaKerja',$data);
	}
}