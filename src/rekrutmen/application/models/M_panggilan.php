<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_panggilan extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    function getListTK(){
        $query = $this->db->query("SELECT * FROM vwListBerkas ORDER BY Panggil ASC");
        return $query->result();
    }
    
    function updateGeneralStatus($hdrID){
        $this->db->trans_start();
        $this->db->where('HeaderID',$hdrID);
        $this->db->update('tblTrnCalonTenagaKerja',array('Panggil'=>1));
        $this->db->trans_complete();
    }
    
    function batalPanggil($hdrID){
        $this->db->trans_start();
        $this->db->where('HeaderID',$hdrID);
        $this->db->update('tblTrnCalonTenagaKerja',array('Panggil'=>0));
        $this->db->trans_complete();
    }
    
    function get_detailtk($hdrid){
        return $this->db->get_where('tblTrnCalonTenagaKerja',array('HeaderID'=>$hdrid));
    }
}

/* End of file m_panggilan.php */
/* Location: ./application/models/m_panggilan.php */