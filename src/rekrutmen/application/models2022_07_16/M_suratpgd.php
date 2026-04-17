<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_suratpgd extends CI_Model {

    function __construct() {
        parent:: __construct();

        $this->dbborongan   = $this->load->database('PSGBOR', TRUE);
    }

    function getDatatenagakerja($nik){
        $sql_product = $this->db->query("SELECT * FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja WHERE Nik ='$nik'");
        if($sql_product->num_rows() >0){
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function save($nik,$tglkeluar,$keterangan,$user){
        // $this->db->insert('tblTrnSuratPgd',$data);
        // $hdrid = $this->db->insert_id();
        // $this->db->trans_complete();
        // return $hdrid;
        $query = $this->db->query("exec spInsertTenakerKeluar '$nik','$tglkeluar','$keterangan','$user'");
        return $query;
    }

    public function getdatattd($nik){
        $query = $this->db->query("SELECT * FROM tblTrnSuratPgd where NIK='".$nik."'");
        return $query->result();
    }

    function getdatapermohonanpgd(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM tblTrnSuratPgd WHERE DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.") AND PemohonStatus=1 AND DEPTStatus is null");
        return $query->result();
    }

    function getmonpermohonanpgd(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM tblTrnSuratPgd WHERE DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.")");
        return $query->result();
    }


    function getdatapermohonanpgddept($dept){
        $this->db->select('*');
        $this->db->where('DeptAbbr',$dept);
        $query = $this->db->get('tblTrnSuratPgd');
        return $query->result();
    }

    function getdatapgdforpemohon($dept){
        $query = $this->db->query("SELECT * FROM tblTrnSuratPgd WHERE PemohonStatus = '0' AND DeptAbbr='".$dept."'");
        return $query->result();
    }

    function getdatapgdfordept($dept){
        $query = $this->db->query("SELECT * FROM tblTrnSuratPgd WHERE PemohonStatus = '1' AND DEPTStatus = '0' AND DeptAbbr='".$dept."'");
        return $query->result();
    }

    function get_tenakerPGD($nik){
        return $this->db->get_where('tblTrnSuratPgd',array('NIK'=>$nik));
    }

    function updatedata($id,$user,$jab,$ttd){
        $query = $this->db->query("exec spApproveSuratPGD '$id','1','$user','$jab','$ttd'");
        return $query;
    }

    function get_insert($data){
       $this->db->insert('tblTrnSuratPgd',$data);
        $hdrid = $this->db->insert_id();
        return $hdrid;
    }

    function getinfoNik($nik,$tipe){
        $arparam = array($nik,$tipe);
        $query = $this->db->query("exec spGetDataTenagaKerja '$nik','$tipe'");
        return $query;
    }

    function GetdataDept($param){
        $sql = "SELECT RegNo,NIK,NAMA,Jabatan FROM PSGPersonalia..vwMstKaryawanAktif " .
               "WHERE NIK = '" . $param . "'";
        $get = $this->db->query($sql);
        return $get;
    }

    function approveddata($chknik,$data){
        $this->db->where('NIK',$chknik);
        $hdr = $this->db->update('tblTrnSuratPgd',$data);
        return $hdr;
    }

    function approvedatapbr($id = 0){
        if ($id === 0) {
            $query = $this->db->query("SELECT * FROM tblTrnSuratPgd WHERE PemohonStatus=1 AND DEPTStatus=1 AND PemborongStatus is null");
        }else{
            $query = $this->db->query("SELECT * FROM tblTrnSuratPgd WHERE PemborongID='".$id."' AND PemohonStatus=1 AND DEPTStatus=1 AND PemborongStatus is null");
        }
        return $query->result();
    }

    function approvedatapsn(){
        $query = $this->db->query("SELECT * FROM tblTrnSuratPgd WHERE PemohonStatus=1 AND DEPTStatus=1 AND PemborongStatus=1 AND PSNStatus is null");
        return $query->result();
    }
}