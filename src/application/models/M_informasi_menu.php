<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD24
 */

class M_informasi_menu extends CI_Model{
    
    public function __construct() {
        parent::__construct();
 
    }

    function get_mnulv1(){
    	$query = $this->db->query("SELECT * FROM tblUtlMenu_lv1 ORDER BY MenuID");
    	return $query->result();
    }

    function get_mnulv2(){
    	$query = $this->db->query("SELECT * FROM tblUtlMenu_lv2 where Status IS NULL ORDER BY MenuID ");
    	return $query->result();
    }
    function get_mnulv3(){
    	$query = $this->db->query("SELECT * FROM tblUtlMenu_lv3 where Status IS NULL ORDER BY MenuID");
    	return $query->result();
    }

    function simpan($data){
    	$this->db->insert('tblMstKeteranganMenu',$data);
    }

    function update($id,$data){
    	$this->db->where('ID',$id);
    	$this->db->update('tblMstKeteranganMenu',$data);
    }

    function get_data($menuid){
    	$query = $this->db->query("SELECT * FROM tblMstKeteranganMenu where MenuID = '$menuid'");
    	return $query->result();
    }

     function cek_data($menuid){
    	$query = $this->db->query("SELECT * FROM tblMstKeteranganMenu where MenuID = '$menuid'");
    	return $query->result();
    }

    function get_ket(){
        $query = $this->db->query("SELECT * FROM tblMstKeteranganMenu");
        return $query->result();
    }

    function get_dataMenu(){
        $query = $this->db->query("SELECT m1.MenuID, m1.MenuLabel, m4.Keterangan_menu FROM tblUtlMenu_lv1 AS m1 LEFT JOIN tblMstKeteranganMenu AS m4 ON m1.MenuID = m4.MenuID UNION ALL SELECT m2.MenuID, m2.MenuLabel, m4.Keterangan_menu FROM tblUtlMenu_lv2 AS m2 LEFT JOIN tblMstKeteranganMenu AS m4 ON m2.MenuID = m4.MenuID UNION ALL SELECT m3.MenuID, m3.MenuLabel, m4.Keterangan_menu FROM tblUtlMenu_lv3 AS m3 LEFT JOIN tblMstKeteranganMenu AS m4 ON m3.MenuID = m4.MenuID ORDER BY MenuID ASC");
        return $query->result();
    }
}