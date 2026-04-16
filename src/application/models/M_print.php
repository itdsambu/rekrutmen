<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_print extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    // ===== Start Monitor Screening Progress =====
    function selectTenakerActive($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
                . "* FROM vwScreening AS tbl ) vwScreening WHERE Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }

    function countTenakerActive(){
        $query = $this->db->query("SELECT HeaderID FROM vwScreening ORDER BY HeaderID DESC");
        return $query->num_rows();
    }

    function selectTenakerActiveWhere($start,$end,$noreg,$nama,$dept){
        $dept = array('PAM','PSN','HMS','PSP','PJC','MP1');
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
                . "* FROM vwScreening AS tbl WHERE Nama LIKE '%".$nama."%' AND HeaderID LIKE '%".$noreg."%' AND Dept NOT LIKE '%".$dept."%') vwScreening WHERE Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }

    function countTenakerActiveWhere($noreg,$nama,$dept){
        $query = $this->db->query("SELECT HeaderID FROM vwScreening WHERE Nama LIKE '%".$nama."%' AND HeaderID LIKE '%".$noreg."%' AND Dept NOT LIKE '%".$dept."%' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }

    // ===== End Monitor Screening Progress =====
            
    function getListTK(){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE GeneralStatus = 0 AND HeaderID IN(" 
                . "SELECT HeaderID FROM vwListBerkas) ORDER BY HeaderID DESC");
        return $query->result();
    }
    
    function getLogLoginView($userID){
        $query = $this->db->query("SELECT * FROM tblUtl_LogOnline WHERE UserID='".$userID."' ORDER BY Tanggal DESC");
        return $query->result();
    }
    function getLogLoginViewForAdmin(){
        $query = $this->db->query("SELECT TOP 300 * FROM tblUtl_LogOnline ORDER BY Tanggal DESC");
        return $query->result();
    }

    function getLogLoginViewForAdminbyPSN(){
        $query = $this->db->query("SELECT TOP 300 * FROM tblUtl_LogOnline where convert(varchar(10),Tanggal,120) = convert(varchar(10),getdate(),120)  ORDER BY Tanggal DESC");
        return $query->result();
    }

    // === Lihat Berdasarkan All ===
    
    function getTransDesktop(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM vwIssueDesktopForWeb WHERE Departemen IN "
                . "(SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.") ORDER BY DetailID DESC");
        return $query->result();
    }

    // === Lihat Berdasarkan Sudah Approv === 

    function getTransDesktopApp(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM vwIssueDesktopForWeb WHERE GeneralStatus = 1 AND Departemen IN "
                . "(SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.") ORDER BY DetailID DESC");
        return $query->result();
    }


    // ============================= Review Isu Permintaan ================================
    function getTrans($bln,$thn){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT DISTINCT * "
                . "FROM vwApprovalAll WHERE YEAR(CreatedDate) = ".$thn." AND MONTH(CreatedDate) = ".$bln." AND TKPermintaan <> '0'"
                . "AND DeptAbbr IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.")");
        return $query->result();
    }

    function getDetailIssue($id){
        $query = $this->db->query("SELECT * FROM vwApprovalAll WHERE DetailID ='".$id."'");
        return $query->result();
    }
    function getDetailIssuePekerjaan($id){
        $query = $this->db->query("SELECT DetailID, Pekerjaan FROM vwApprovalAll WHERE DetailID ='".$id."'");
        return $query->result();
    }
    function getDetailIssueAll(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT DISTINCT * FROM vwApprovalAll WHERE " 
                . "TKPermintaan <> '0'"
                . "AND DeptAbbr IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.") ORDER BY DetailID ASC ");
        return $query->result();
    }
    function getDetailIssueApp(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT DISTINCT * FROM vwApprovalAll WHERE " 
                . "GeneralStatus = '1'"
                . "AND DeptAbbr IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.") ORDER BY DetailID ASC ");
        return $query->result();
    }
    function getDetailIssueCancle(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT DISTINCT * FROM vwApprovalAll WHERE " 
                . "GeneralStatus = '2'"
                . "AND DeptAbbr IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.") ORDER BY DetailID ASC ");
        return $query->result();
    }
    function getDetailIssueClose(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT DISTINCT * FROM vwApprovalAll WHERE " 
                . "GeneralStatus = '3'"
                . "AND DeptAbbr IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.") ORDER BY DetailID ASC ");
        return $query->result();
    }

    //========= Start to View Docs =========
    function getListViewDocs($pemborong,$jekel,$status,$pendidikan,$jurusan){
//        $this->db->select('TOP 100 * ');
        $this->db->where("Pemborong LIKE '%".$pemborong."%' AND Jenis_Kelamin LIKE '%".$jekel."%' AND "
                . "Status_Personal LIKE '%".$status."%' AND Pendidikan LIKE '%".$pendidikan."%' AND Jurusan LIKE '%".$jurusan."%'");
        $query = $this->db->get(array('vwListBerkas'));
        return $query->result();
    }
    function getDocs($userID){
        $query = $this->db->query("SELECT * FROM tblTrnBerkas WHERE HeaderID='".$userID."'");
        return $query->result();
    }
    //========= END to View Docs ==========
    
    function tenakerVerifi(){
        $query = $this->db->query("SELECT * FROM vwListBerkas WHERE HdrID Not IN (SELECT HdrID FROM vwListBerkas WHERE Verified = 1)");
        return $query->result();
    }
    
    function tenakerProses(){
        $query = $this->db->query("SELECT * FROM vwListBerkas WHERE PostingData = 0 AND GeneralStatus = 0 ORDER BY HeaderID ASC");
        return $query->result();
    }
    
    function tenakerClosed(){
        $query = $this->db->query("SELECT * FROM vwListBerkas WHERE GeneralStatus = 1 ORDER BY HeaderID ASC");
        return $query->result();
    }

    function tenakerProsesview(){
        $query = $this->db->query("SELECT * FROM vwListBerkas WHERE PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe = NULL ORDER BY HeaderID ASC");
        return $query->result();
    }
    
    
    //============================================= to Excel =================================================

    function toExcelSemuaLimitMonth($bln, $thn){
        $query = $this->db->query("SELECT * FROM vwListBerkas WHERE YEAR(RegisteredDate) = ".$thn." AND "
                . "MONTH(RegisteredDate) = ".$bln." ORDER BY HeaderID ASC");
        return $query->result();
    }

    function toExcelSearch($Nama){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE Nama LIKE '".$Nama."' ORDER BY HeaderID ASC");
        return $query->result();
    }

    function toExcelSearchID($HdrID){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE HdrID = '".$HdrID."' ORDER BY HeaderID ASC");
        return $query->result();
    }

    function toExcelData($Pemborong, $Jenis_Kelamin, $thn, $bln){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE Pemborong LIKE '".$Pemborong."' AND Jenis_Kelamin LIKE '%".$Jenis_Kelamin."%' AND YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelSemua1($Pemborong, $Jenis_Kelamin, $thn, $bln){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE Pemborong LIKE '".$Pemborong."' AND Jenis_Kelamin LIKE '%".$Jenis_Kelamin."%' AND Pendidikan in ('TIDAK SEKOLAH','SD','SMP','MTS') AND YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelSemua2($Pemborong, $Jenis_Kelamin, $thn, $bln){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE Pemborong LIKE '".$Pemborong."' AND Jenis_Kelamin LIKE '%".$Jenis_Kelamin."%' AND Pendidikan in ('SMU','SMK','MAN') AND YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' ORDER BY HeaderID DESC");
        return $query->result();
    }


    //======================================================= Belum Interview ==========================================
    function toExcelNotview($thn, $bln){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND PostingData = '0' AND GeneralStatus = '0' AND WawancaraKe is null ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelNotview1($thn, $bln, $Pemborong){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND PostingData = '0' AND GeneralStatus = '0' AND WawancaraKe is null AND Pemborong = '".$Pemborong."'ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelNotview2($thn, $bln, $Pemborong, $Jenis_Kelamin){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND PostingData = '0' AND GeneralStatus = '0' AND WawancaraKe is null AND Pemborong = '".$Pemborong."' AND Jenis_Kelamin = '".$Jenis_Kelamin."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelNotview3($thn, $bln, $Pemborong, $Jenis_Kelamin){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND PostingData = '0' AND GeneralStatus = '0' AND WawancaraKe is null AND Pendidikan in ('TIDAK SEKOLAH','SD','SMP','MTS') AND Pemborong = '".$Pemborong."' AND Jenis_Kelamin = '".$Jenis_Kelamin."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelNotview4($thn, $bln, $Pemborong, $Jenis_Kelamin){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND PostingData = '0' AND GeneralStatus = '0' AND WawancaraKe is null AND Pendidikan in ('SMU','SMK','MAN') AND Pemborong = '".$Pemborong."' AND Jenis_Kelamin = '".$Jenis_Kelamin."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelNotview5($thn, $bln, $Pemborong, $Jenis_Kelamin){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND PostingData = '0' AND GeneralStatus = '0' AND WawancaraKe is null AND Pemborong = '".$Pemborong."' AND Jenis_Kelamin = '".$Jenis_Kelamin."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    //====================================================== Gagal SCREENING ==========================================

    function toExcelGagalview($thn, $bln){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND PostingData = 0 AND GeneralStatus = 1 AND WawancaraKe Is Not NULL AND DeptTujuan Is Not NULL AND WawancaraHasil = 1 AND SpecialScreening = 0 ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelGagalview1($thn, $bln, $Pemborong){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND PostingData = 0 AND GeneralStatus = 1 AND WawancaraKe Is Not NULL AND DeptTujuan Is Not NULL AND WawancaraHasil = 1 AND SpecialScreening = 0 AND Pemborong = '".$Pemborong."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelGagalview2($thn, $bln, $Pemborong, $Jenis_Kelamin){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND PostingData = 0 AND GeneralStatus = 1 AND WawancaraKe Is Not NULL AND DeptTujuan Is Not NULL AND WawancaraHasil = 1 AND SpecialScreening = 0 AND Pemborong = '".$Pemborong."' AND Jenis_Kelamin = '".$Jenis_Kelamin."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelGagalview3($thn, $bln, $Pemborong, $Jenis_Kelamin){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND PostingData = 0 AND GeneralStatus = 1 AND WawancaraKe Is Not NULL AND DeptTujuan Is Not NULL AND WawancaraHasil = 1 AND SpecialScreening = 0 AND Pendidikan in ('TIDAK SEKOLAH','SD','SMP','MTS') AND Pemborong = '".$Pemborong."' AND Jenis_Kelamin = '".$Jenis_Kelamin."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelGagalview4($thn, $bln, $Pemborong, $Jenis_Kelamin){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND PostingData = 0 AND GeneralStatus = 1 AND WawancaraKe Is Not NULL AND DeptTujuan Is Not NULL AND WawancaraHasil = 1 AND SpecialScreening = 0 AND Pendidikan in ('SMU','SMK','MAN') AND Pemborong = '".$Pemborong."' AND Jenis_Kelamin = '".$Jenis_Kelamin."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelGagalview5($thn, $bln, $Jenis_Kelamin, $Pemborong){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND PostingData = 0 AND GeneralStatus = 1 AND WawancaraKe Is Not NULL AND DeptTujuan Is Not NULL AND WawancaraHasil = 1 AND SpecialScreening = 0 AND Jenis_Kelamin = '".$Jenis_Kelamin."' AND Pemborong = '".$Pemborong."' ORDER BY HeaderID DESC");
        return $query->result();
    }


    //==================================================== Telah Interview =============================================
    function toExcelTelahview($thn, $bln){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe Is Not NULL AND ScreeningHasil = 1 ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelTelahview1($thn, $bln, $Pemborong){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe Is Not NULL AND ScreeningHasil = 1 AND Pemborong = '".$Pemborong."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelTelahview2($thn, $bln, $Pemborong, $Jenis_Kelamin){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe Is Not NULL AND ScreeningHasil = 1 AND Pemborong = '".$Pemborong."' AND Jenis_Kelamin = '".$Jenis_Kelamin."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelTelahview3($thn, $bln, $Pemborong, $Jenis_Kelamin){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe Is Not NULL AND ScreeningHasil = 1 AND Pendidikan in ('TIDAK SEKOLAH','SD','SMP','MTS') AND Pemborong = '".$Pemborong."' AND Jenis_Kelamin = '".$Jenis_Kelamin."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelTelahview4($thn, $bln, $Pemborong, $Jenis_Kelamin){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe Is Not NULL AND ScreeningHasil = 1 AND Pendidikan in ('SMU','SMK','MAN') AND Pemborong = '".$Pemborong."' AND Jenis_Kelamin = '".$Jenis_Kelamin."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelTelahview5($thn, $bln, $Pemborong, $Jenis_Kelamin){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe Is Not NULL AND ScreeningHasil = 1 AND Pemborong = '".$Pemborong."' AND Jenis_Kelamin = '".$Jenis_Kelamin."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    //====================================================== ALL PEMBORONG =======================================

    function toExcelAll($thn, $bln){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelAll1($thn, $bln){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND Pendidikan in ('TIDAK SEKOLAH','SD','SMP','MTS') ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelAll2($thn, $bln){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND Pendidikan in ('SMU','SMK','MAN') ORDER BY HeaderID DESC");
        return $query->result();
    }

     function toExcelAll3($thn, $bln, $Jenis_Kelamin){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND Pendidikan in ('TIDAK SEKOLAH','SD','SMP','MTS') AND Jenis_Kelamin = '".$Jenis_Kelamin."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelAll4($thn, $bln, $Jenis_Kelamin){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND Pendidikan in ('SMU','SMK','MAN') AND Jenis_Kelamin = '".$Jenis_Kelamin."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelAll5($thn, $bln, $Jenis_Kelamin){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND Jenis_Kelamin = '".$Jenis_Kelamin."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelAll6($thn, $bln, $Pemborong){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND Pemborong = '".$Pemborong."' ORDER BY HeaderID DESC");
        return $query->result();
    }

    function toExcelAll7($thn, $bln, $Pemborong, $Jenis_Kelamin){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = '".$thn."' AND MONTH(RegisteredDate) = '".$bln."' AND Pemborong = '".$Pemborong."' AND Jenis_Kelamin = '".$Jenis_Kelamin."' ORDER BY HeaderID DESC");
        return $query->result();
    }


    //======================================================= TELAH POSTING ===============================================

    function toExcelPost($thn, $bln){
        $query = $this->db->query("SELECT * FROM vwTrnReportPosted WHERE YEAR(PostedDate) = '".$thn."' AND MONTH(PostedDate) = '".$bln."' ORDER BY PostedDate DESC");
        return $query->result();
    }

    function toExcelPost1($thn, $bln, $Pemborong){
        $query = $this->db->query("SELECT * FROM vwTrnReportPosted WHERE YEAR(PostedDate) = '".$thn."' AND MONTH(PostedDate) = '".$bln."' AND Pemborong LIKE '".$Pemborong."' ORDER BY PostedDate DESC");
        return $query->result();
    }

    function toExcelPost2($thn, $bln, $Pemborong, $Jenis_Kelamin){
        $query = $this->db->query("SELECT * FROM vwTrnReportPosted WHERE YEAR(PostedDate) = '".$thn."' AND MONTH(PostedDate) = '".$bln."' AND Pemborong LIKE '".$Pemborong."' AND Jenis_Kelamin = '".$Jenis_Kelamin."' ORDER BY PostedDate DESC");
        return $query->result();
    }

    function toExcelPost3($thn, $bln, $Pemborong, $Jenis_Kelamin){
        $query = $this->db->query("SELECT * FROM vwTrnReportPosted WHERE YEAR(PostedDate) = '".$thn."' AND MONTH(PostedDate) = '".$bln."' AND Pendidikan in ('TIDAK SEKOLAH','SD','SMP','MTS') AND Pemborong LIKE '".$Pemborong."' AND Jenis_Kelamin = '".$Jenis_Kelamin."' ORDER BY PostedDate DESC");
        return $query->result();
    }

    function toExcelPost4($thn, $bln, $Pemborong, $Jenis_Kelamin){
        $query = $this->db->query("SELECT * FROM vwTrnReportPosted WHERE YEAR(PostedDate) = '".$thn."' AND MONTH(PostedDate) = '".$bln."' AND Pendidikan in ('SMU','SMK','MAN') AND Pemborong LIKE '".$Pemborong."' AND Jenis_Kelamin = '".$Jenis_Kelamin."' ORDER BY PostedDate DESC");
        return $query->result();
    }

    function toExcelPost5($thn, $bln, $Jenis_Kelamin){
        $query = $this->db->query("SELECT * FROM vwTrnReportPosted WHERE YEAR(PostedDate) = '".$thn."' AND MONTH(PostedDate) = '".$bln."' AND Jenis_Kelamin LIKE '".$Jenis_Kelamin."' ORDER BY PostedDate DESC");
        return $query->result();
    }

     function toExcelPost6($thn, $bln){
        $query = $this->db->query("SELECT * FROM vwTrnReportPosted WHERE YEAR(PostedDate) = '".$thn."' AND MONTH(PostedDate) = '".$bln."' AND Pendidikan in ('TIDAK SEKOLAH','SD','SMP','MTS') ORDER BY PostedDate DESC");
        return $query->result();
    }

    function toExcelPost7($thn, $bln){
        $query = $this->db->query("SELECT * FROM vwTrnReportPosted WHERE YEAR(PostedDate) = '".$thn."' AND MONTH(PostedDate) = '".$bln."' AND Pendidikan in ('SMU','SMK','MAN') ORDER BY PostedDate DESC");
        return $query->result();
    }

    // ==================================================================================================================

    function toExcelVerifi(){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE HeaderID Not IN (SELECT HdrID FROM vwListBerkas WHERE Verified = 1) "
                . "AND HeaderID IN(SELECT HeaderID FROM vwListBerkas) ORDER BY HeaderID ASC");
        return $query->result();
    }
    function toExcelProses(){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE PostingData = 0 AND GeneralStatus = 0 AND HeaderID IN(" 
                . "SELECT HeaderID FROM vwListBerkas) ORDER BY HeaderID ASC");
        return $query->result();
    }
    function toExcelClosed(){
        $query = $this->db->query("SELECT TOP 1000 * FROM tblTrnCalonTenagaKerja WHERE GeneralStatus = 1 AND HeaderID IN(" 
                . "SELECT HeaderID FROM vwListBerkas) ORDER BY HeaderID ASC");
        return $query->result();
    }
    function toExcelProsesview($bln, $thn, $jekel, $pemborong){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe = NULL AND Pemborong LIKE '".$pemborong."' AND Jenis_Kelamin LIKE '%".$jekel."%' AND YEAR(RegisteredDate) = ".$thn." AND MONTH(RegisteredDate) = ".$bln." AND HeaderID IN(" 
                . "SELECT HeaderID FROM vwListBerkas) ORDER BY HeaderID ASC");
        return $query->result();
    }

    function toExcelProsesinterview($bln, $thn, $jekel, $pemborong){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe = NULL AND Pemborong LIKE '".$pemborong."' AND Jenis_Kelamin LIKE '%".$jekel."%' AND YEAR(RegisteredDate) = ".$thn." AND MONTH(RegisteredDate) = ".$bln." AND HeaderID IN(" 
                . "SELECT HeaderID FROM vwListBerkas) ORDER BY HeaderID ASC");
        return $query->result();
    }
    
    function toExcelnonPendidikan($bln, $thn, $jekel, $pemborong){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe = NULL AND Pendidikan in ('TIDAK SEKOLAH','SD','SMP','MTS') AND Pemborong LIKE '".$pemborong."' AND Jenis_Kelamin LIKE '%".$jekel."%' AND YEAR(RegisteredDate) = ".$thn." AND MONTH(RegisteredDate) = ".$bln." AND HeaderID IN(" 
                . "SELECT HeaderID FROM vwListBerkas) ORDER BY Pendidikan ASC");
        return $query->result();
    }

    function toExcelsmusederajat($bln, $thn, $jekel, $pemborong){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe = NULL AND Pendidikan in ('SMU','SMK','MAN') AND Pemborong LIKE '".$pemborong."' AND Jenis_Kelamin LIKE '%".$jekel."%' AND YEAR(RegisteredDate) = ".$thn." AND MONTH(RegisteredDate) = ".$bln." AND HeaderID IN(" 
                . "SELECT HeaderID FROM vwListBerkas) ORDER BY Pemborong ASC");
        return $query->result();
    }

    // function toExcelsmusederajat($bln, $thn, $jekel, $pemborong){
    //     $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe = NULL AND Pendidikan in ('SMU','SMK','MAN') AND Pemborong LIKE '%".$pemborong."%' AND Jenis_Kelamin LIKE '%".$jekel."%' AND YEAR(RegisteredDate) = ".$thn." AND MONTH(RegisteredDate) = ".$bln." AND "
    //     . "HeaderID IN (SELECT HeaderID FROM vwListBerkas and Pemborong IN "
    //     . "(SELECT DISTINCT Pemborong FROM vwMstPemborong WHERE IDPemborong =".$IDPemborong.")  ORDER BY Pendidikan ASC");
    //     return $query->result();
    // }

    // function hasilinterview(){
    //     $grupID = $this->session->userdata('groupuser');
    //     $query = $this->db->query("SELECT * FROM vwListBerkas WHERE GeneralStatus = 0 AND DeptTujuan Is Not NULL AND SudahPrintBerkas = 0 AND "
    //             . "HeaderID IN (SELECT HeaderID FROM tblTrnWawancara WHERE HasilWawancara = 1 and Departemen IN "
    //             . "(SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.")) ORDER BY HeaderID DESC");
    //     return $query->result();
    // }

    // ======= New Monitoring Security Tenaga Kerja =======

    function cekAllTenaker($start,$end){
        $query = $this->db->query("SELECT * FROM vwTestListBerkas WHERE Row >= ".$start." AND Row <= ".$end." ");
        // $query = $this->db->query("SELECT * FROM vwTestPaging WHERE PostingData = 1");
        // $query=$this->db->query(‘SELECT nama, judul, email FROM tabel’);
        // foreach ($query->result() as row)
        // {
        // echo $row->nama;
        // echo $row->judul;
        // echo $row->email;
        // }
        return $query->result();
    }

    function selectTenakersecuryti($start,$end){
        $query = $this->db->query("SELECT * FROM vwTestListBerkas WHERE Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }

    function countTenakersecuryti(){
        $query = $this->db->query("SELECT HdrID FROM vwTestListBerkas ORDER BY HdrID DESC");
        return $query->num_rows();
    }

    function selectTenakersecurytiWhere($start,$end,$noreg,$nama){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HdrID DESC) AS Row, "
                . "* FROM vwListBerkas AS tbl WHERE Nama LIKE '%".$nama."%' AND HdrID LIKE '%".$noreg."%') vwListBerkas WHERE Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }

    function countTenakersecurytiWhere($noreg,$nama){
        $query = $this->db->query("SELECT HdrID FROM vwTestListBerkas WHERE Nama LIKE '%".$nama."%' AND HdrID LIKE '%".$noreg."%' ORDER BY HdrID DESC");
        return $query->num_rows();
    }
    

    // ============================================== TK PEMBORONG ======================================
    function countPemborongTgl($Tahun,$Bulan){
        $query = $this->db->query("SELECT Pemborong = Pemborong COLLATE SQL_Latin1_General_CP1_CI_AS, SMU_SEDERAJAT_P, SMU_SEDERAJAT_L, NON_PENDIDIKAN_P, NON_PENDIDIKAN_L FROM vwTotalTKperPemborong Where Tahun = '".$Tahun."' AND Bulan = '".$Bulan."' AND Pemborong NOT IN ('H. JASRI VIII','0','PINEFEED','','BLR','PERUMAHAN','ALL PEMBORONG','CV. SURYA ABADI','SUHARDI-2','H. JASRI IV','H. MONEL','JEFRIZAL','RSUP') AND Pemborong IS NOT NULL ORDER BY Pemborong ASC");
        return $query->result();
    }

    // function toExcelSemuaLimitMonth($bln, $thn){
    //     $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = ".$thn." AND "
    //             . "MONTH(RegisteredDate) = ".$bln." ORDER BY HeaderID ASC");
    //     return $query->result();
    // }

    // function countPemborong(){
    //     $query = $this->db->query("SELECT SMU_SEDERAJAT_P=() AS Total1, SUM(SMU_SEDERAJAT_L) AS Total2, SUM(NON_PENDIDIKAN_P) AS Total3, SUM(NON_PENDIDIKAN_L) AS Total4 FROM vwTotalTKperPemborong ORDER BY Pemborong ASC");
    //     return $query->result();
    // }

    // function countPemborong1(){
    //     $query = $this->db->query("SELECT SUM(SMU_SEDERAJAT_P) AS Total1, SUM(SMU_SEDERAJAT_L) AS Total2, SUM(NON_PENDIDIKAN_P) AS Total3, SUM(NON_PENDIDIKAN_L) AS Total4 FROM vwTotalTKperPemborong ORDER BY Pemborong ASC");
    //     return $query->result();
    // }

    // function countPemborong(){
    //     $this->db->select('(SELECT SUM(vwTotalTKperPemborong.SMU_SEDERAJAT_P) FROM vwTotalTKperPemborong WHERE vwTotalTKperPemborong.pemborong) AS Total1', FALSE);
    //     $query = $this->db->get('vwTotalTKperPemborong');
    // }

    // function countPemborong(){
    //     $query = $this->db->query("SELECT SUM(SMU_SEDERAJAT_P) AS Total1, SUM(SMU_SEDERAJAT_L) AS Total2, SUM(NON_PENDIDIKAN_P) AS Total3, SUM(NON_PENDIDIKAN_L) AS Total4 FROM vwTotalTKperPemborong ORDER BY Pemborong ASC");
    //     return $query->result();
    // }

    //================================================================================================

    // ======= NEW MONITOR TENAGA KERJA =======
    // All Kenaker
    function selectAllTenaker($start,$end){
        $query = $this->db->query("SELECT * FROM vwTestListBerkas WHERE Row >= ".$start." AND Row <= ".$end." ");
        //$query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
                //. "* FROM vwListBerkas AS tbl ) vwListBerkas WHERE Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countAllTenaker(){
        $query = $this->db->query("SELECT HeaderID FROM vwListBerkas ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    function selectAllTenakerWhere($start,$end,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
                . "* FROM vwListBerkas AS tbl WHERE Pemborong LIKE '%".$pemborong."%' AND Jenis_Kelamin LIKE '%".$jekel."%' AND "
                . "Status_Personal LIKE '%".$status."%' AND Pendidikan LIKE '%".$pendidikan."%' AND Jurusan LIKE '%".$jurusan."%' AND "
                . "HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%') "
                . "vwListBerkas WHERE  Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countAllTenakerWhere($pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama){
        $query = $this->db->query("SELECT HeaderID FROM vwListBerkas WHERE Pemborong LIKE '%".$pemborong."%' AND "
                . "Jenis_Kelamin LIKE '%".$jekel."%' AND Status_Personal LIKE '%".$status."%' AND Pendidikan LIKE '%".$pendidikan."%' AND "
                . "HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' AND "
                . "Jurusan LIKE '%".$jurusan."%' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }

    function getPemborong(){
        return $this->db->get('vwMstPemborong')->result();
    }

    // On Proccess Tenaker Yang Sudah Interview
    function selectOnProccessTenaker($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, * "
                . "FROM vwListBerkas AS tbl WHERE PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe Is Not NULL AND ScreeningHasil = 1) vwListBerkas "
                . "WHERE Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countOnProccessTenaker(){
        $query = $this->db->query("SELECT HeaderID FROM vwListBerkas WHERE PostingData = 0 AND GeneralStatus = 0 ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    function selectOnProccessTenakerWhere($start,$end,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, * FROM vwListBerkas AS tbl "
                . "WHERE PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe Is Not NULL AND Pemborong LIKE '%".$pemborong."%' AND Jenis_Kelamin LIKE '%".$jekel."%' AND "
                . "Status_Personal LIKE '%".$status."%' AND Pendidikan LIKE '%".$pendidikan."%' AND Jurusan LIKE '%".$jurusan."%' AND "
                . "HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%') "
                . "vwListBerkas WHERE  Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countOnProccessTenakerWhere($pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama){
        $query = $this->db->query("SELECT HeaderID FROM vwListBerkas WHERE PostingData = 0 AND GeneralStatus = 0 AND "
                . "Pemborong LIKE '%".$pemborong."%' AND Jenis_Kelamin LIKE '%".$jekel."%' AND Status_Personal LIKE '%".$status."%' "
                . "AND Pendidikan LIKE '%".$pendidikan."%' AND HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' AND "
                . "Jurusan LIKE '%".$jurusan."%' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }

    // Was Close Tenaker
    function selectClosedTenaker($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, * "
                . "FROM vwListBerkas AS tbl WHERE GeneralStatus = 1 AND ScreeningHasil = 1) vwListBerkas "
                . "WHERE Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countClosedTenaker(){
        $query = $this->db->query("SELECT HeaderID FROM vwListBerkas WHERE GeneralStatus = 1 ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    function selectClosedTenakerWhere($start,$end,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, * FROM vwListBerkas AS tbl "
                . "WHERE GeneralStatus = 1 AND Pemborong LIKE '%".$pemborong."%' AND Jenis_Kelamin LIKE '%".$jekel."%' AND "
                . "Status_Personal LIKE '%".$status."%' AND Pendidikan LIKE '%".$pendidikan."%' AND Jurusan LIKE '%".$jurusan."%' AND "
                . "HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%') "
                . "vwListBerkas WHERE  Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countClosedTenakerWhere($pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama){
        $query = $this->db->query("SELECT HeaderID FROM vwListBerkas WHERE GeneralStatus = 1 AND "
                . "Pemborong LIKE '%".$pemborong."%' AND Jenis_Kelamin LIKE '%".$jekel."%' AND Status_Personal LIKE '%".$status."%' "
                . "AND Pendidikan LIKE '%".$pendidikan."%' AND HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' AND "
                . "Jurusan LIKE '%".$jurusan."%' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    // Was Post Tenaker
    function selectPostedTenaker($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
                . "* FROM vwTrnReportPosted AS tbl ) vwTrnReportPosted WHERE Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countPostedTenaker(){
        $query = $this->db->query("SELECT HeaderID FROM vwTrnReportPosted ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    function selectPostedTenakerWhere($start,$end,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
                . "* FROM vwTrnReportPosted AS tbl WHERE Pemborong LIKE '%".$pemborong."%' AND Jenis_Kelamin LIKE '%".$jekel."%' AND "
                . "Status_Personal LIKE '%".$status."%' AND Pendidikan LIKE '%".$pendidikan."%' AND Jurusan LIKE '%".$jurusan."%' AND "
                . "HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%') "
                . "vwTrnReportPosted WHERE  Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countPostedTenakerWhere($pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama){
        $query = $this->db->query("SELECT HeaderID FROM vwTrnReportPosted WHERE Pemborong LIKE '%".$pemborong."%' AND "
                . "Jenis_Kelamin LIKE '%".$jekel."%' AND Status_Personal LIKE '%".$status."%' AND Pendidikan LIKE '%".$pendidikan."%' AND "
                . "HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' AND "
                . "Jurusan LIKE '%".$jurusan."%' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }

    // New On Proccess Tenaker Belum Interview
    function selectOnProccessTenakerview($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, * "
                . "FROM vwListBerkas AS tbl WHERE PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe = NULL) vwListBerkas "
                . "WHERE Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countOnProccessTenakerview(){
        $query = $this->db->query("SELECT HeaderID FROM vwListBerkas WHERE PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe = NULL ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    function selectOnProccessTenakerWhereview($start,$end,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, * FROM vwListBerkas AS tbl "
                . "WHERE PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe = NULL AND Pemborong LIKE '%".$pemborong."%' AND Jenis_Kelamin LIKE '%".$jekel."%' AND "
                . "Status_Personal LIKE '%".$status."%' AND Pendidikan LIKE '%".$pendidikan."%' AND Jurusan LIKE '%".$jurusan."%' AND "
                . "HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%') "
                . "vwListBerkas WHERE  Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countOnProccessTenakerWhereview($pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama){
        $query = $this->db->query("SELECT HeaderID FROM vwListBerkas WHERE PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe = NULL AND "
                . "Pemborong LIKE '%".$pemborong."%' AND Jenis_Kelamin LIKE '%".$jekel."%' AND Status_Personal LIKE '%".$status."%' "
                . "AND Pendidikan LIKE '%".$pendidikan."%' AND HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' AND "
                . "Jurusan LIKE '%".$jurusan."%' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }

    // === new report ===
    // function reportPostedLimitDate($bulan,$tahun){
    //     $query = $this->db->query("SELECT * FROM vwTrnReportPosted WHERE YEAR(PostedDate) = ".$tahun." AND "
    //             . "MONTH(PostedDate) = ".$bulan." ORDER BY PostedDate ASC");
    //     return $query->result();
    // }

    // function hasilinterview(){
    //     $grupID = $this->session->userdata('groupuser');
    //     $query = $this->db->query("SELECT * FROM vwListBerkas WHERE GeneralStatus = 0 AND DeptTujuan Is Not NULL AND SudahPrintBerkas = 0 AND "
    //             . "HeaderID IN (SELECT HeaderID FROM tblTrnWawancara WHERE HasilWawancara = 1 and Departemen IN "
    //             . "(SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.")) ORDER BY HeaderID DESC");
    //     return $query->result();
    // }

    //==========================================================================================

    // New On Proccess Tenaker GAgal Interview
    function selectOnTenakerGagal($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, * "
                . "FROM vwListBerkas AS tbl WHERE PostingData = 0 AND GeneralStatus = 1 AND WawancaraKe Is Not NULL AND DeptTujuan Is Not NULL AND WawancaraHasil = 1 AND SpecialScreening = 0) vwListBerkas "
                . "WHERE Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countOnTenakerGagal(){
        $query = $this->db->query("SELECT HeaderID FROM vwListBerkas WHERE PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe = NULL ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    function selectOnTenakerWhereGagal($start,$end,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, * FROM vwListBerkas AS tbl "
                . "WHERE PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe = NULL AND Pemborong LIKE '%".$pemborong."%' AND Jenis_Kelamin LIKE '%".$jekel."%' AND "
                . "Status_Personal LIKE '%".$status."%' AND Pendidikan LIKE '%".$pendidikan."%' AND Jurusan LIKE '%".$jurusan."%' AND "
                . "HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%') "
                . "vwListBerkas WHERE  Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countOnTenakerWhereGagal($pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama){
        $query = $this->db->query("SELECT HeaderID FROM vwListBerkas WHERE PostingData = 0 AND GeneralStatus = 0 AND WawancaraKe = NULL AND "
                . "Pemborong LIKE '%".$pemborong."%' AND Jenis_Kelamin LIKE '%".$jekel."%' AND Status_Personal LIKE '%".$status."%' "
                . "AND Pendidikan LIKE '%".$pendidikan."%' AND HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' AND "
                . "Jurusan LIKE '%".$jurusan."%' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }

    // === new report ===
    function reportPostedLimitDate($bulan,$tahun){
        $query = $this->db->query("SELECT * FROM vwTrnReportPosted WHERE YEAR(PostedDate) = ".$tahun." AND "
                . "MONTH(PostedDate) = ".$bulan." ORDER BY PostedDate ASC");
        return $query->result();
    }

    function hasilinterview(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM vwListBerkas WHERE GeneralStatus = 0 AND DeptTujuan Is Not NULL AND SudahPrintBerkas = 0 AND "
                . "HeaderID IN (SELECT HeaderID FROM tblTrnWawancara WHERE HasilWawancara = 1 and Departemen IN "
                . "(SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.")) ORDER BY HeaderID DESC");
        return $query->result();
    }

    //==========================================================================================



    // === new report Belum Interview===
    function reportPostedLimitDateview($bulan,$tahun){
        $query = $this->db->query("SELECT * FROM vwTrnReportPosted WHERE YEAR(PostedDate) = ".$tahun." AND "
                . "MONTH(PostedDate) = ".$bulan." ORDER BY PostedDate ASC");
        return $query->result();
    }

    function hasilinterviewtk(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM vwListBerkas WHERE GeneralStatus = 0 AND DeptTujuan Is Not NULL AND SudahPrintBerkas = 0 AND "
                . "HeaderID IN (SELECT HeaderID FROM tblTrnWawancara WHERE HasilWawancara = 1 and Departemen IN "
                . "(SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.")) ORDER BY HeaderID DESC");
        return $query->result();
    }

    //==========================================================================================

    function listResetInterview(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM vwListBerkas WHERE GeneralStatus = 0 AND DeptTujuan Is Not NULL AND "
                . "HeaderID IN (SELECT HeaderID FROM tblTrnWawancara WHERE HasilWawancara = 1 and Departemen IN "
                . "(SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID =".$grupID."))");
        return $query->result();
    }
}

/* End of file m_monitor.php */
/* Location: ./application/models/m_monitor.php */