<?php 
defined ('BASEPATH') OR exit ('No direct script access allowed');
/**
 *  ITD 31
 */
class m_MonitoringPsychological extends CI_Model
{
	function getKaryawan($nama){
		$query = $this->db->query("SELECT * from tblTrnCalonKandidat where CalonPelamarID LIKE '%$nama%' OR Nama LIKE '%$nama%'");
		return $query->result();
	}
	function getData($id){
    	$query = $this->db->query("SELECT * from tblTrnCalonKandidat where CalonPelamarID = '$id'");
		return $query->result();
    }
    function getPsycho($id){
    	$query = $this->db->query("SELECT * FROM vwMonitoringPsychological as A left join vwCalonKandidat as B ON A.HeaderID = B.CalonPelamarID where A.HeaderID = '$id'");
		return $query->result();
    }
    function getList(){
        $query = $this->db->query("select * from vwCalonKandidat as A join vwMonitoringPsychological as B ON A.CalonPelamarID = B.HeaderID order by JadwalTes desc");
        return $query->result();
    }
    function getPrivacy(){
        $query = $this->db->query("select A.GroupID, A.GroupName, A.GroupDescription, B.LoginID, B.NamaUser from tblUtlGroupUser_Rec as A join tblUtlLogin as B ON A.GroupID = B.GroupID where A.GroupName = 'Super Administrator' OR A.GroupName like '%Pimpinan%'");
        return $query->result();
    }
    function getPsychologyData($id){
        $query = $this->db->query("select Nama, CreatedDate, DATEADD(day, +2, CreatedDate) as Tgl_Akhir from tblTrnPsychologicalTest where HeaderID = '$id'");
        return $query->result();
    }
} 