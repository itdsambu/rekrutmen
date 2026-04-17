<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_transaksi extends CI_Model {

    function __construct() {
        parent:: __construct();
    }

    function savekouta($data){
    	$this->db->insert('tblMstKoutaPemborong',$data);
    	$hdrid = $this->db->insert_id();
    	$this->db->trans_complete();
    	return $hdrid;
    }

    function saveTKkouta($data){
    	$this->db->insert('tblTrnKoutaTK',$data);
    	$hdrid = $this->db->insert_id();
    	$this->db->trans_complete();
    	return $hdrid;
    }

    function list($periode,$idpemborong){
        return $query = $this->db->query(
            "
                SELECT
                    *,cast(BatasInput as time(0)) as BatasInput, JmlKouta - (
                        SELECT
                            COUNT (HeaderID) AS HdrID
                        FROM
                            tblTrnKoutaTK
                        WHERE
                            CVNama IN (
                                SELECT
                                    Perusahaan
                                FROM
                                    vwMstPemborong
                                WHERE
                                    IDPerusahaan = '".$idpemborong."'
                            )
                        AND Periode = '".$periode."'
                        AND Status = 'UNLOCK'
                    ) AS SisaKouta
                FROM
                    tblMstKoutaPemborong
                WHERE
                    Periode = '".$periode."'
                AND Status = 'UNLOCK'
                AND CVNama IN (
                    SELECT
                        Perusahaan
                    FROM
                        vwMstPemborong
                    WHERE
                        IDPerusahaan = '".$idpemborong."'
                )
            "
            )->result();
    }

    function getDataTK($id){
    	return $query = $this->db->query("exec spGetCalonTenaker '".$id."'")->result();
    }

    function listTK($periode,$idpemborong){
    	//return $query = $this->db->query("SELECT distinct * FROM vwTrnKoutaTK WHERE Status='UNLOCK' AND Periode='".$periode."' and CVNama IN (SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '".$idpemborong."') ")->result();
		return $query = $this->db->query("select * from tblTrnKoutaTK where periode='".$periode."' and CVNama IN (SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '".$idpemborong."')")->result();
    }

    function TotallistTK($periode,$idpemborong){
    	$periode = date('d-m-Y');
        $idpemborong    = $this->session->userdata('idpemborong');
    	return $query = $this->db->query("SELECT COUNT(HeaderID) FROM tblTrnKoutaTK WHERE Periode='".$periode."' and CVNama='".$idpemborong."' ")->result();
    }
    function Totallist($periode){
    	$periode = date('d-m-Y');
    	return $query = $this->db->query("SELECT * FROM tblMstKoutaPemborong WHERE Periode='".$periode."'")->result();
    }

    function getKouta($periode){
        return $query = $this->db->query("SELECT * FROM tblMstKoutaPemborong WHERE Periode='".$periode."' ORDER BY Periode DESC")->result();
    }

    function lockKouta($id){
        $data = array('Status'=>'LOCK');
        $this->db->trans_start();
        $this->db->where('id',$id);
        $this->db->update('tblMstKoutaPemborong',$data);
        $this->db->trans_complete();
    }

    function unlockKouta($id){
        $data = array('Status'=>'UNLOCK');
        $this->db->trans_start();
        $this->db->where('id',$id);
        $this->db->update('tblMstKoutaPemborong',$data);
        $this->db->trans_complete();
    }

    function get_kouta($id){
        return $this->db->get_where('tblMstKoutaPemborong',array('id'=>$id));
    }

    function updateKouta($id,$data){
        $this->db->where('id',$id);
        $query = $this->db->update('tblMstKoutaPemborong',$data);
        return $query;
    }

    function listKoutaTK(){
        return $query = $this->db->query("select * from tblTrnKoutaTK")->result();
    }

    function DeleteTransTK($hdrID){
        $this->db->trans_start();
        $this->db->where('HeaderID',$hdrID);
        $this->db->delete('tblTrnKoutaTK');
        $this->db->trans_complete();
    }

    function getPSGPemborong($idpemborong){
        if ($idpemborong > 0){
            $result = $this->db->get_where('vwMstPemborong', array('IDPerusahaan'=>$idpemborong));
        }else{
            // $this->db->select('*');
            // $this->db->from('vwMstPemborong');
            // $this->db->order_by('Perusahaan','ASC');
            // $result = $this->db->get();
            $result = $this->db->query("SELECT * FROM vwMstPemborong WHERE IDPemborong!=19 ORDER BY Perusahaan ASC");
        }
        return $result->result();
    }

    function getPemborong(){
        $pemborong = strtoupper($this->input->post('pemborong'));
        $query = $this->db->get_where('vwMstPemborong', array('Perusahaan' => $pemborong));
        if ($query->num_rows() > 0){
                $row = $query->row();
                $perusahaan=$row->Pimpinan;
        }else{
                $perusahaan='';
        }
        return $perusahaan;
    }

    function getListPBR($idpemborong,$periode){
        return $query = $this->db->query("SELECT distinct a.HeaderID,a.Nama,b.CVNama,a.Periode,b.Status FROM tblTrnKoutaTK AS a INNER JOIN tblMstKoutaPemborong AS b on b.CVNama=a.CVNama WHERE b.CVNama IN (SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '".$idpemborong."') AND b.Status='UNLOCK' AND a.Periode='".$periode."' order by Nama ASC")->result();
    }
	
	function getListperiode($periode){
		$this->db->select('*');
        $this->db->from('tblTrnKoutaTK');
		$this->db->where('Periode',$periode);
        $this->db->order_by('CVNama','ASC');
        $result = $this->db->get();
		return $result->result();
    }
	function getHari(){
        //return $query = $this->db->query("SELECT DATENAME(w,GETDATE()) as HARI")->result();
		return $query = $this->db->query("SELECT * FROM (SELECT datename(dw,getdate()) as hari,convert(varchar(20),getdate(),105) as tanggal) A")->result();
    }
	
	function getLibur(){
		return $query = $this->db->query("SELECT * FROM vwMstHariLibur")->result();
    }
}