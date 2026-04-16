<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_upload_berkas extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function insert_db_berkas($hdrid){
        $query = $this->db->get_where("tblTrnBerkas",array("HeaderID" => $hdrid));
        if ($query->num_rows() === 0){
            $this->db->trans_start();
            $this->db->insert('tblTrnBerkas',array("HeaderID" => $hdrid));
            $berkasid = $this->db->insert_id();
            $this->db->trans_complete();
            return $berkasid;
        }
    }

    function update_db_berkas($hdrid,$berkas,$lokasi){		
        $this->db->trans_start();
        $this->db->where('HeaderID',$hdrid);
        $this->db->update('tblTrnBerkas',array($berkas => $lokasi));
        $this->db->trans_complete();
    }

    function get_db_berkas($hdrid){
        return $this->db->get_where('tblTrnBerkas',array('HeaderID' => $hdrid));
//        $this->db->where('HeaderID', $hdrid);
//        $query = $this->db->get('tblTrnBerkas');
//        return $query->result();
    }

    function minimal_berkas($hdrid){
        $minimalberkas = 0;
        $query = $this->db->query("Select HeaderID from tblTrnBerkas Where HeaderID=" .$hdrid. 
                        " And KTP is not null");
        if ($query->num_rows() > 0){
            $minimalberkas=1;
        }
        return $minimalberkas;
    }
    
    function getListTK($idpemborong){
//        $this->db->where('GeneralStatus','0');
//        $query = $this->db->get(array('vwListBerkas'));
//        return $query->result();
        if ($idpemborong > 0){
            $query = $this->db->query("SELECT * FROM vwListBerkas WHERE GeneralStatus = 0 AND "
                    . "CVNama IN (SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '".$idpemborong."' ) ");
        }else{
            //$query = $this->db->query("SELECT * FROM vwListBerkas WHERE GeneralStatus = 0 ");
			$query = $this->db->query("SELECT * FROM vwListBerkas WHERE GeneralStatus = 0 AND CVNama IN (SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '20')");
        }        
        return $query->result();
    }
    
    //==== list tenaga kerja
    
    function get_detailtk($hdrid){
        return $this->db->get_where('vwTrnCalonTenagaKerja',array('HeaderID'=>$hdrid));
		
		//return $query = $this->db->query("exec spGetDetailCalonTenaker '".$id."'")->result();
    }
    
    // === UPload Berkas Surat Perjanjian Kontrak ===
    function getTenakerUploadSPK($idpemborong){
        if ($idpemborong > 0){
            $query = $this->db->query("SELECT * FROM vwTenakerForUploadSPK WHERE "
                    . "CVNama IN (SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '".$idpemborong."' ) ");
        }else{
            //$query = $this->db->query("SELECT * FROM vwTenakerForUploadSPK ");
			$query = $this->db->query("SELECT * FROM vwTenakerForUploadSPK WHERE CVNama IN (SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '20') ");
        }        
        return $query->result();
    }
	
	function getdrhID($id){
		return $query = $this->db->query("exec getBiodataCalonTenaker '".$id."'")->result();
	}
	
	function toExcelSemuaLimitMonth($bln, $thn){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = ".$thn." AND "
                . "MONTH(RegisteredDate) = ".$bln." ORDER BY HeaderID ASC");
        return $query->result();
    }

}

/* End of file m_upload_berkas.php */
/* Location: ./application/models/m_upload_berkas.php */