<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : Ifa Sonia Istifarani 
 */

class m_bontkkeluar extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }

    function get_DataPbr(){
    	$query = $this->db->query("select * from tblMstPemborong");
    	return $query->result();
    }

    function get_DataTK($id,$tahun,$bulan){
    	$this->db->where('IDPemborong',$id);
    	$this->db->where('YEAR(TanggalKeluar)',$tahun);
    	$this->db->where('MONTH(TanggalKeluar)',$bulan);
    	return $this->db->get('vwMstTenagaKerjaBorongan2010')->result();
    	}

    function simpan($data){
        $this->db->insert('RSUPBorongan2010..tblTrnPotonganBONPemborong',$data);
        $hdrid = $this->db->insert_id();
        return $hdrid;
    }
}
?>