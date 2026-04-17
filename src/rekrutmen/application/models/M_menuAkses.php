<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: itd15
 * Date: 10/08/2015
 * Time: 15:20
 */
class M_menuAkses extends CI_Model{

    private $menu1 = 'vwUtlMenu_lv1';
    private $menu2 = 'vwUtlMenu_lv2';
    private $menu3 = 'vwUtlMenu_lv3';

    function __construct(){
        parent:: __construct();
    }
    
    function get_menu(){
        $grupid = $this->input->post('grupid');

        $q = $this->subquery->start_union();
        $q->select('*')->from('vwUtlMenuAkses')->where('GroupID',$grupid);

        $q1 = $this->subquery->start_union();
        $q1->select('tblUtlMenu_lv1.MenuID, tblUtlMenu_lv1.MenuName, tblUtlMenu_lv1.MenuLabel, tblUtlMenu_lv1.MenuIcon, '
                .'tblUtlMenu_lv2.MenuID AS MenuID2, tblUtlMenu_lv2.MenuName AS MenuName2, tblUtlMenu_lv2.MenuLabel AS MenuLabel2, tblUtlMenu_lv2.MenuIcon AS MenuIcon2, '
                .'tblUtlMenu_lv2.MenuLink AS MenuLink2, tblUtlMenu_lv2.MenuHeader AS MenuHeader2, '
                .'tblUtlMenu_lv3.MenuID AS MenuID3, tblUtlMenu_lv3.MenuName AS MenuName3, tblUtlMenu_lv3.MenuLabel AS MenuLabel3, tblUtlMenu_lv3.MenuIcon AS MenuIcon3, '
                .'tblUtlMenu_lv3.MenuLink AS MenuLink3, tblUtlMenu_lv3.MenuHeader AS MenuHeader3')->from('tblUtlMenu_lv1','tblUtlMenu_lv2','tblUtlMenu_lv3');

            $q11=$this->subquery->start_subquery('where_in');
            $q11->select('MenuID','MenuID2','MenuID3')->from('vwUtlMenuAkses')->where('GroupID',$grupid);		
            $this->subquery->end_subquery('MenuID','MenuID2','MenuID3',false);

        $this->subquery->end_union();

        $result = $this->db->get();
        return $result;
    }

    public function selectMenu1($groupID){
        $query = $this->db->query("SELECT GroupID, MenuID, MenuName, MenuLabel, Atc = 1 FROM dbo.vwUtlMenu_lv1 WHERE GroupID = ".$groupID."
            UNION ALL
            SELECT GroupID = NULL, MenuID, MenuName, MenuLabel, Atc = 0 FROM dbo.tblUtlMenu_lv1 
            WHERE MenuID NOT IN (SELECT MenuID FROM dbo.vwUtlMenu_lv1 WHERE GroupID = ".$groupID.")");
        return $query->result();
    }

    public function selectPerusahaan(){
        $query = $this->db->query(
            "SELECT
                x.IDPerusahaan,
                y.IDPemborong,
                x.Perusahaan,
                x.Singkatan,
                x.Pimpinan,
                y.Pemborong 
            FROM
                [192.168.3.32].PSGBorongan.dbo.tblMstPerusahaan AS x
                INNER JOIN [192.168.3.32].PSGBorongan.dbo.tblMstPemborong AS y ON y.IDPerusahaan = x.IDPerusahaan"
        );
        return $query->result();
    }

    public function selectMenu2($groupID){
        $query = $this->db->query("SELECT GroupID, MenuID, MenuName, MenuLabel, MenuHeader, Atc = 1 FROM dbo.vwUtlMenu_lv2 WHERE GroupID = ".$groupID."
            UNION ALL 
            SELECT GroupID = NULL, MenuID, MenuName, MenuLabel, MenuHeader, Atc = 0 FROM dbo.tblUtlMenu_lv2 
            WHERE MenuID NOT IN (SELECT MenuID FROM dbo.vwUtlMenu_lv2 WHERE GroupID = ".$groupID.")");
        return $query->result();
    }
    public function selectMenu3($groupID){
        $query = $this->db->query("SELECT GroupID, MenuID, MenuName, MenuLabel, MenuHeader, Atc = 1 FROM dbo.vwUtlMenu_lv3 WHERE GroupID = ".$groupID."
            UNION ALL 
            SELECT GroupID = NULL, MenuID, MenuName, MenuLabel, MenuHeader, Atc = 0 FROM dbo.tblUtlMenu_lv3 
            WHERE MenuID NOT IN (SELECT MenuID FROM dbo.vwUtlMenu_lv3 WHERE GroupID = ".$groupID.")");
        return $query->result();
    }
    
    //===== simpan menu akses
    function simpanAkses($grupid,$menuid){
        $info = array(
            'GroupID'     => $grupid,
            'MenuID'      => $menuid,
            'CreatedBy'   => strtoupper($this->session->userdata('username')),
            'CreatedDate' => date('Y-m-d H:i:s')
        );

        $this->db->trans_start();
        $cek = $this->db->get_where('tblUtlMenuAkses',$info);

        if ($cek->num_rows() == 0){		
                $this->db->insert('tblUtlMenuAkses',$info);
        }
        $this->db->trans_complete();
    }
    
    function hapus_menuakses($grupid){
        $this->db->delete('tblUtlMenuAkses',array('GroupID'=>$grupid));
    }
}

/* End of file m_menuAkses.php */
/* Location: ./application/models/m_menuAkses.php */