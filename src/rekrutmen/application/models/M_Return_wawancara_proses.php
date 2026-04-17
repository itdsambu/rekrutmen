<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD24
 */

class M_Return_wawancara_proses extends CI_Model{


	function get_dataGagalWawancaraProses(){
		$thnSebelum = date('Y')-1;
		$thnSekarang = date('Y');
		$query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja where WawancaraKe = '3' and ClosingRemark = 'Gagal wawancara 3 kali' and (YEAR(RegisteredDate) = '$thnSekarang' OR YEAR(RegisteredDate) = '$thnSebelum') ORDER BY HeaderID DESC");
		return $query->result();

	}

	function update($headerid,$data){
		$this->db->where('HeaderID',$headerid);
		$this->db->update('tblTrnCalonTenagaKerja',$data);
	}
}