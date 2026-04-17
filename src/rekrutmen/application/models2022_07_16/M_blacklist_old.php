<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_blacklist extends CI_Model {

    function __construct() {
        parent:: __construct();
    }

    public function selectBlacklistK(){
        $query = $this->db->query("SELECT * FROM vwTrnBlacklistK");
        return $query->result();
    }

    public function selectBlacklistTK(){
        $query = $this->db->query("SELECT * FROM vwTrnBlacklistTK");
        return $query->result();
    }
	
	public function selectBlacklistByPass(){
        $query = $this->db->query("SELECT * FROM tblTrnBlacklistTemporary");
        return $query->result();
    }

    function getPSGPemborong($idpemborong){
//        $this->db->order_by('Perusahaan','ASC');
       // $query = $this->db->get('PSGBorongan.dbo.tblMstPerusahaan');
//        return $query->result();
        if ($idpemborong > 0){
            $result = $this->db->get_where('vwMstPemborong', array('IDPerusahaan'=>$idpemborong));
        }else{
            $this->db->select('*');
            $this->db->from('vwMstPemborong');
            $this->db->order_by('Perusahaan','ASC');
            $result = $this->db->get();
        }
        return $result->result();
    }

    function getMstAllKaryByNIK($nik){
        $this->db->where("NIK = '".$nik."'");
        return $this->db->get('PSGPayroll.dbo.vwMstKaryawan');
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

    function getDept(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM vwMstDepartemen WHERE IDDept IN "
                . "(SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.") ORDER BY DeptAbbr");
        return $query->result();
    }

    function getData(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM PSGPayroll.dbo.v_kk_mstkaryawan WHERE NIK ='$NIK'");
        return $query->result();
    }
	
	function getTGLLAHIR(){
		$tgllahir = $this->input->post('tgllahir');
		$query = $this->db->get_where('PSGBorongan.dbo.vwMstTenagaKerja', array('TglLahir' => $tgllahir));
		if($query->num_rows() > 0){
			$row = $query->row();
			$tgllahir=$row->TglLahir;
		}else{
			$tgllahir='';
		}
		return $tgllahir;
	}

    function save($data){
        $this->db->insert('tblTrnBlacklist',$data);
        $hdrid = $this->db->insert_id();
        return $hdrid;
    }
	
	public function getBlacklistbypass($id){
        $this->db->where('NIK', $id);
        $query = $this->db->get('tblTrnBlacklistTemporary');
        return $query->result();
    }
	
	function get_detailbypass($nik){
        return $this->db->get_where('tblTrnBlacklistTemporary',array('NIK'=>$nik));
    }
	
	function savebypass($data){
        $this->db->insert('tblTrnBlacklistTemporary',$data);
        $hdrid = $this->db->insert_id();
        return $hdrid;
    }

    // function saveDetail($NIK){
    //     $this->db->insert('tblTrnBlacklist', $NIK);
    //     $hdrid = $this->db->insert_id();
    //     return $hdrid;
    // }

    public function getBlacklistK($id){
        $this->db->where('NIK', $id);
        $query = $this->db->get('vwTrnBlacklistK');
        return $query->result();
    }
	
	//public function getBlacklistTK($id){
    //    $this->db->where('NIK', $id);
    //    $query = $this->db->get('vwTrnBlacklistTK');
    //    return $query->result();
    //}
	
	function getBlacklistTK($nik){
        return $this->db->get_where('vwTrnBlacklistTK',array('NIK'=>$nik));
    }

    function update_status_foto($NIK){
        $this->db->trans_start();
        $this->db->where('NIK',$NIK);
        $this->db->update('tblTrnBlacklist',array('AdaPhotoOnline'=>1));
        $this->db->trans_complete();
    }

    // function getBlacklistNIK($NIK){
    //     $query = $this->db->query("SELECT * FROM vwTrnBlacklist WHERE NIK ='".$NIK."'");
    //     return $query->result();
    // }
    
    function getDataBlacklistK($nik){
        $sql_product = $this->db->query("SELECT * FROM PSGPayroll.dbo.vwMstKaryawan WHERE NIK ='$nik'");
        if($sql_product->num_rows() >0){
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function getDataBlacklistTK($nik){
        $sql_product = $this->db->query("SELECT * FROM PSGBorongan.dbo.vwMstTenagaKerja WHERE Nik ='$nik'");
        if($sql_product->num_rows() >0){
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function chekedKBlacklist($nik){
        $query = $this->db->get_where('tblTrnBlacklist', array('NIK' => $nik));
        if($query->num_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	function printBlacklistKaryawan(){
        $query = $this->db->query("SELECT * FROM tblTrnBlacklist WHERE CVNama = 'PT. PULAU SAMBU GUNTUNG'");
        return $query->result();
    }

    function printBlacklistTenaker(){
        $query = $this->db->query("SELECT * FROM tblTrnBlacklist WHERE CVNama NOT IN ('PT. PULAU SAMBU GUNTUNG')");
        return $query->result();
    }
}