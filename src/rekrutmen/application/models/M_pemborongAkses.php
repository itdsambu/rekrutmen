<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 * Date : 2022-09-21
 * Time : 13:40
*/

class M_pemborongAkses extends CI_Model {

    private $primary_key = 'ID';
    private $table_name = 'tblUtlAksesSubPemborong2';

    public function selectGroupAkses(){
        $this->db->order_by('GroupName','ASC');
        $query = $this->db->get($this->table_name);
        return $query->result();
    }

    public function selectGrupUser(){
        $this->db->order_by('GroupName','ASC');
        $query = $this->db->get('tblUtlGroupUser');
        return $query->result();
    }

    public function selectGroupPemborong(){
        $query = $this->db->query(
            "SELECT
                A.IDPerusahaan,
                A.Pemborong,
                A.IDPemborong,
                B.IDSubPemborong,
                B.IDPemborong AS ID_pbr,
                B.NamaSub,
                B.AliasNama 
            FROM
                dbo.vwMstPemborong AS A
            LEFT OUTER JOIN dbo.tblMstSubPemborong AS B ON A.IDPemborong = B.IDPemborong"
        );
        return $query->result();
    }

    public function getNamePerusahaan($cv, $owner){
        $query = $this->db->query(
            "SELECT
                x.IDPerusahaan,
                x.Perusahaan,
                x.Singkatan,
                x.Pimpinan,
                y.IDPemborong,
                y.Pemborong
            FROM
                [192.168.3.32].PSGBorongan.dbo.tblMstPerusahaan AS x
                INNER JOIN [192.168.3.32].PSGBorongan.dbo.tblMstPemborong AS y ON y.IDPerusahaan = x.IDPerusahaan
            WHERE x.IDPerusahaan = '$cv'
            AND y.IDPemborong = '$owner'"
        );
        return $query->result();
    }

    public function getGroupame($IDGroup){
        $query = $this->db->query("SELECT GroupID, GroupName FROM tblUtlGroupUser WHERE GroupID = '$IDGroup' AND NotActive = '0' ORDER BY GroupName ASC");
        return $query->result();
    }

    public function save($data){
        $this->db->trans_start();
        $this->db->insert($this->table_name,$data);
        $hdrid = $this->db->insert_id();
        $this->db->trans_complete();
        return $hdrid;
    }

    public function getGrupAkses($id){
        $this->db->where($this->primary_key, $id);
        $query = $this->db->get($this->table_name);
        return $query->result();
    }

    function update($id,$data){
        $this->db->where($this->primary_key,$id);
        $this->db->update($this->table_name,$data);
    }

    function delete($id){
        $this->db->where($this->primary_key,$id);
        $this->db->delete($this->table_name);
    }

}

/* End of file M_pemborongAkses.php */
