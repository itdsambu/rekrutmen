<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: itd15
 * Date: 10/08/2015
 * Time: 15:20
 */
class M_menuSidebar extends CI_Model{

    private $menu1 = 'vwUtlMenu_lv1';
    private $menu2 = 'vwUtlMenu_lv2';
    private $menu3 = 'vwUtlMenu_lv3';

    function __construct(){
        parent:: __construct();
    }

    // public function selectMenu1($GrupID){
    //     $this->db->where('GroupID', $GrupID);
    //     $this->db->order_by("MenuID", "asc");
    //     $query = $this->db->get($this->menu1);
    //     return $query->result();
    // }

    // public function selectMenu2($GrupID){
    //     $this->db->where('GroupID', $GrupID);
    //     $query = $this->db->get($this->menu2);
    //     return $query->result();
    // }
    // public function selectMenu3($GrupID){
    //     $this->db->where('GroupID', $GrupID);
    //     $query = $this->db->get($this->menu3);
    //     return $query->result();
    // }

    public function selectMenu1($GrupID){
        $query = $this->db->query("Select * from vwUtlMenu_lv1 where GroupID = '$GrupID' order by MenuID asc");
        return $query->result();
    }

    public function selectMenu2($GrupID){
        $query = $this->db->query("Select * from vwUtlMenu_lv2 where GroupID = '$GrupID'");
        return $query->result();
    }
    public function selectMenu3($GrupID){
        $query = $this->db->query("Select * from vwUtlMenu_lv3 where GroupID = '$GrupID'");
        return $query->result();
    }
}

/* End of file m_menuSidebar.php */
/* Location: ./application/models/m_menuSidebar.php */