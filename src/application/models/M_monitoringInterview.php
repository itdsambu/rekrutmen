<?php
defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_monitoringInterview extends CI_Model{

    function get(){
    	$query = $this->db->query("SELECT *,DATEDIFF(YEAR,TanggalLahir,GETDATE()) as Umur FROM tblTrnCalonKandidatNew as A left join TblMntInterview as B ON A.CalonPelamarID = B.CalonPelamarID left join vw_mstKecamatan as C ON B.KecamatanID = C.KecamatanID where A.Interview = '1' and DeletedBy is null");
    	return $query->result();
    }

    function _getListDataById($idInterview){
        $query = $this->db->query("SELECT *,DATEDIFF(YEAR,TanggalLahir,GETDATE()) as Umur FROM vwCalonKandidat where IDInterview = '$idInterview'");
        return $query->result();
    }

    function _getMstPendidikan(){
         $query = $this->db->query("SELECT * FROM tblMstPendidikan");
        return $query->result();
    }

    function _getMstJurusan(){
        $query = $this->db->query("SELECT * FROM tblMstJurusan");
        return $query->result();
    }

    function _getMstKecamatan(){
        $query = $this->db->query("SELECT * FROM vw_mstKecamatan");
        return $query->result();
    }

    function _getMstSuku(){
        $query = $this->db->query("SELECT * FROM tblMstSuku");
        return $query->result();
    }
    function _getMstDept(){
        $query = $this->db->query("SELECT * FROM tblMstDepartemenNew");
        return $query->result();
    }

    function update($interview,$data){
        $this->db->where('IDInterview',$interview);
        $this->db->update('TblMntInterview',$data);
    }

    function getDocs($userID){
        $query = $this->db->query("SELECT * FROM tblTrnBerkas where HeaderID = '$userID'");
        return $query->result();
    }

    function getPelamar($userID){
        $query = $this->db->query("SELECT * FROM vwCalonKandidat where HeaderID = '$userID'");
        return $query->result(); 
    }

    function cek_nomorSurat($hdrid){
        $query = $this->db->query("SELECT * FROM TblMntInterview where CalonPelamarID = '$hdrid'");
        return $query->result();
    }

    function updateHdr($hdrid,$data){
        $this->db->where('CalonPelamarID',$hdrid);
        $this->db->update("TblMntInterview",$data);
    }

    function getTenagaKerja($hdrid){
        $query = $this->db->query("SELECT * FROM vwCalonKandidat where CalonPelamarID = '$hdrid'");
        return $query->result();
    }

    function nomer(){
        $query = $this->db->query("SELECT COUNT(IDInterview) as Nomor FROM TblMntInterview where SuratPanggilanKerja in (1,2) and MONTH(CreatedDate) = '".date('m')."' and YEAR(CreatedDate) = '".date('Y')."'");
        return $query->result();
    }

    function update_calon_pelamar($calonid,$data2){
        $this->db->where('CalonPelamarID',$calonid);
        $this->db->update('tblTrnCalonKandidatNew',$data2);
    }

    function _getDataListBerdasarkanJurusan($jurusan){
         $query = $this->db->query("SELECT *,DATEDIFF(YEAR,TanggalLahir,GETDATE()) as Umur  FROM vwCalonKandidat as A left join vw_mstKecamatan as B ON A.KecamatanID = B.KecamatanID 
            WHERE A.Interview = 1 and A.Jurusan = '".$jurusan."'");
        return $query->result();
    }

    function _getDataListBerdasarkanGaji($gaji1,$gaji2){
         $query = $this->db->query("SELECT *,DATEDIFF(YEAR,TanggalLahir,GETDATE()) as Umur  FROM vwCalonKandidat as A left join vw_mstKecamatan as B ON A.KecamatanID = B.KecamatanID 
            WHERE A.Interview = 1 and A.Gaji BETWEEN '".$gaji1."' AND '".$gaji2."'");
        return $query->result();
    }

    function _getDataListBerdasarkanPendidikan($pendidikan){
        $query = $this->db->query("SELECT *,DATEDIFF(YEAR,TanggalLahir,GETDATE()) as Umur  FROM vwCalonKandidat as A left join vw_mstKecamatan as B ON A.KecamatanID = B.KecamatanID 
        WHERE A.Interview = 1 and A.Pendidikan = '".$pendidikan."'");
        return $query->result();
    }

    function _getDataListBerdasarkanPertanggal($tglawal,$tglakhir){
        $query = $this->db->query("SELECT *,DATEDIFF(YEAR,TanggalLahir,GETDATE()) as Umur FROM vwCalonKandidat as A left join vw_mstKecamatan as B ON A.KecamatanID = B.KecamatanID  where A.Interview = 1 and CONVERT(DATE,CreatedDate) >= '".$tglawal."' AND CONVERT(DATE,CreatedDate) <= '".$tglakhir."'");
        return $query->result();
    }
}
?>