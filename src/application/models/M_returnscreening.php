<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_returnscreening extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }

    function getdatascreening ($periode){
    	$query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE ScreeningComplete=1 AND convert(varchar,SpecialScreeningDate,105) LIKE '%".$periode."' ORDER BY HeaderID DESC");
    	return $query->result();
    }

    function screenByPsn($hrdID, $info){
        $this->db->where('HeaderID',$hrdID);
        $this->db->update('tblTrnCalonTenagaKerja',$info);
    }

    function getdatattdtk(){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, * FROM vwTTDReplace AS tbl) vwTenakerInterview WHERE Row >= '2401' AND Row <= '2500'");
        return $query->result();
    }
}