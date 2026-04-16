<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: itd15
 * Date: 10/08/2015
 * Time: 10:31
 */
class M_grup_user extends CI_Model{

    private $primary_key = 'GroupID';
    private $table_name = 'tblUtlGroupUser';

    function __construct(){
        parent:: __construct();
    }
    function save($data){
        //$this->db->insert($this->table_name,$data);
        //return $this->db->insert_id();

        $this->db->trans_start();
        $this->db->insert($this->table_name,$data);
        $hdrid = $this->db->insert_id();
        $this->db->trans_complete();
        return $hdrid;
    }

    function update($id,$data){
        $this->db->where($this->primary_key,$id);
        $this->db->update($this->table_name,$data);
    }

    function delete($id){
        $this->db->where($this->primary_key,$id);
        $this->db->delete($this->table_name);
    }

    public function selectGrupUser(){
        $this->db->order_by('GroupName','ASC');
        $query = $this->db->get($this->table_name);
        return $query->result();
    }

    //===== get ID u/ Edit
    public function getGrupUser($id){
        $this->db->where($this->primary_key, $id);
        $query = $this->db->get($this->table_name);
        return $query->result();
    }

}

/* End of file m_grup_user.php */
/* Location: ./application/models/m_grup_user.php */