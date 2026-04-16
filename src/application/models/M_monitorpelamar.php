<?php defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_monitorpelamar extends CI_Model{

	public function __construct() {
        parent::__construct();
    }

    function getDataPelamar($statusid){
    	// $this->db->where('TesMasuk',$statusid);
     //    $this->db->where('ketTesMasuk NOT IN (1)');
     //    $this->db->where('CloseData = 0');
    	// return $this->db->get('tblTrnCalonTenagaKerja')->result();
    	$query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE TesMasuk =".$statusid."  AND ketTesMasuk NOT IN (1) and CloseData = '0'");
    	return $query->result();
    }

    function get_DetailTK($headerid){
    	$this->db->where('HeaderID',$headerid);
    	return $this->db->get('vwtblTrnCalonTenagaKerja')->result();
    	 // return $this->db->query("select * from vwtblTrnCalonTenagaKerja where HeaderID = '$headerid' ")->result();
    }

    function result_Screen($headerid){
    	$this->db->where('HeaderID',$headerid);
    	return $this->db->get('tblTrnScreening')->result();
    }
    function result_Interview($headerid){
    	$this->db->where('HeaderID',$headerid);
    	return $this->db->get('tblTrnWawancara')->result();
    }
}
