<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author : ITD15
 */

class M_monitor extends CI_Model{

    public function __construct() {
        parent::__construct();
    } 

    function getListTK(){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE GeneralStatus = 0 ORDER BY HeaderID ASC");
        return $query->result();
    }
    function getListTK2(){
        $query = $this->db->query("SELECT HeaderID,Nama,Pemborong,Tgl_Lahir,Jenis_Kelamin,ScreeningHasil,
        ScreeningComplete,SpecialScreening,Verified,PostingData,RegisteredBy,RegisteredDate,
        [dbo].[fnGenerateHistory] (k.HeaderID) as History
        FROM tblTrnCalonTenagaKerja k WHERE GeneralStatus = 0  ORDER BY HeaderID ASC");
        return $query->result();
    }
    function getListTK3($start,$end){
        $query = $this->db->query("SELECT HeaderID,Nama,Pemborong,Tgl_Lahir,Jenis_Kelamin,ScreeningHasil,
        ScreeningComplete,SpecialScreening,Verified,PostingData,RegisteredBy,RegisteredDate,
        [dbo].[fnGenerateHistory] (k.HeaderID) as History
        FROM tblTrnCalonTenagaKerja k WHERE GeneralStatus = 0 and RegisteredDate BETWEEN '".$start."' AND '".$end."' ORDER BY HeaderID ASC");
        return $query->result();

        // $query = $this->db->query("SELECT HeaderID,Nama,Pemborong,Tgl_Lahir,Jenis_Kelamin,ScreeningHasil,
        // ScreeningComplete,SpecialScreening,Verified,PostingData,RegisteredBy,RegisteredDate,
        // [dbo].[fnGenerateHistory] (k.HeaderID) as History
        // FROM tblTrnCalonTenagaKerja k WHERE GeneralStatus = 0 and convert(char,RegisteredDate,105) like '%$monthyear' ORDER BY HeaderID ASC");
        // return $query->result();
    }

    function closeTenaker($hdrID, $remark){
        $data   = array(
            'GeneralStatus' => 1,
            'ClosingRemark' => $remark,
            'ClosingBy'     => strtoupper($this->session->userdata('username')),
            'ClosingDate'   => date('Y-m-d H:i:s')
        );
        $this->db->trans_start();
        $this->db->where('HeaderID',$hdrID);
        $this->db->update('tblTrnCalonTenagaKerja',$data);
        $this->db->trans_complete();
    }

    function getLogLoginView($userID){
        $query = $this->db->query("SELECT * FROM tblUtl_LogOnline WHERE UserID='".$userID."' ORDER BY Tanggal DESC");
        return $query->result();
    }
    function getLogLoginViewForAdmin(){
        $query = $this->db->query("SELECT TOP 300 * FROM tblUtl_LogOnline ORDER BY Tanggal DESC");
        return $query->result();
    }

    function getTrans($bln,$thn){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL WHERE GeneralStatus <> '2' AND DeptID IN "
                . "(SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.") "
		. "AND YEAR(CreatedDate) = ".$thn." AND MONTH(CreatedDate) = ".$bln." ");
        return $query->result();
    }
    function getTransByStatus($status,$jenis){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL WHERE Pemborong='$jenis' and GeneralStatus = '".$status."' AND DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.")");
        return $query->result();
    }
    function getTransByStatusPending($jenis){
        $grupID = $this->session->userdata('groupuser');
        // var_dump($grupID); die;
        // echo "SELECT DISTINCT * FROM vwTrnApprovalALL WHERE Pemborong='$jenis' and GeneralStatus Is NULL AND DeptID IN "
        //         . "(SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.") ";
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL WHERE Pemborong='$jenis' and GeneralStatus Is NULL AND DeptID IN "
                . "(SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.")");
        return $query->result();
    }

    //========= Start to View Docs =========
    function getListViewDocs(){
        $query = $this->db->get(array('vwListBerkas'));
        return $query->result();
    }
    function getDocs($userID){
        $query = $this->db->query("SELECT * FROM tblTrnBerkas WHERE HeaderID='".$userID."'");
        return $query->result();
    }
    //========= END to View Docs ==========

    function tenakerVerifi(){
        $query = $this->db->query("SELECT * FROM vwListBerkas WHERE Verified = 0 ORDER BY HeaderID ASC");
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


    //================ to Excel ==================
    function toExcelSemua(){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja ORDER BY HeaderID ASC");
        return $query->result();
    }
    function toExcelVerifi(){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE Verified = 0 ORDER BY HeaderID ASC");
        return $query->result();
    }
    function toExcelProses(){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE PostingData = 0 AND GeneralStatus = 0 ORDER BY HeaderID ASC");
        return $query->result();
    }
    function toExcelClosed(){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE GeneralStatus = 1 ORDER BY HeaderID ASC");
        return $query->result();
    }

    //========== FOR PEMBORONG =================
    function listByPBR($idpemborong){
        if ($idpemborong > 0){
            $query = $this->db->query("SELECT * FROM vwListTenakerForPemborong WHERE PostingData = 0 AND "
                    . "CVNama IN (SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '".$idpemborong."' ) ");
        }else{
            $query = $this->db->query("SELECT * FROM vwListTenakerForPemborong WHERE PostingData = 0 ");
        }
        return $query->result();
    }

    // ======= NEW MONITOR TENAGA KERJA =======
    // All Kenaker
    function selectAllTenaker($start,$end){
        //$query = $this->db->query("SELECT * FROM vwTestPaging WHERE Row >= ".$start." AND Row <= ".$end." ");
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
                . "* FROM vwListBerkas AS tbl ) vwListBerkas WHERE Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countAllTenaker(){
        $query = $this->db->query("SELECT HeaderID FROM vwListBerkas ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    function selectAllTenakerWhere($start,$end,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama,$thnlahir,$tipe){
        if ($tipe == "K") {
            $tipe1 = "AND Pemborong LIKE '%YAO HSING%'";
        } else {
            $tipe1 = "AND Pemborong NOT LIKE '%YAO HSING%'";
        }
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
                . "* FROM vwListBerkas AS tbl WHERE Pemborong LIKE '%".$pemborong."%' AND Jenis_Kelamin LIKE '%".$jekel."%' AND "
                . "Status_Personal LIKE '%".$status."%' AND Pendidikan LIKE '%".$pendidikan."%' AND Jurusan LIKE '%".$jurusan."%' AND "
                . "HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' AND Tgl_lahir LIKE '%".$thnlahir."%' ".$tipe1.") "
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
    // On Proccess Tenaker
    function selectOnProccessTenaker($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, * "
                . "FROM vwListBerkas AS tbl WHERE PostingData = 0 AND GeneralStatus = 0) vwListBerkas "
                . "WHERE Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countOnProccessTenaker(){
        $query = $this->db->query("SELECT HeaderID FROM vwListBerkas WHERE PostingData = 0 AND GeneralStatus = 0 ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    function selectOnProccessTenakerWhere($start,$end,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama,$thnlahir,$tipe){
        if ($tipe == "K") {
            $tipe1 = "AND Pemborong LIKE '%YAO HSING%'";
        } else {
            $tipe1 = "AND Pemborong NOT LIKE '%YAO HSING%'";
        }
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, * FROM vwListBerkas AS tbl "
                . "WHERE PostingData = 0 AND GeneralStatus = 0 AND Pemborong LIKE '%".$pemborong."%' AND Jenis_Kelamin LIKE '%".$jekel."%' AND "
                . "Status_Personal LIKE '%".$status."%' AND Pendidikan LIKE '%".$pendidikan."%' AND Jurusan LIKE '%".$jurusan."%' AND "
                . "HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' AND Tgl_lahir LIKE '%".$thnlahir."%' ".$tipe1.") "
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
                . "FROM vwListBerkas AS tbl WHERE GeneralStatus = 1) vwListBerkas "
                . "WHERE Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countClosedTenaker(){
        $query = $this->db->query("SELECT HeaderID FROM vwListBerkas WHERE GeneralStatus = 1 ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    function selectClosedTenakerWhere($start,$end,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama,$thnlahir,$tipe){
        if ($tipe == "K") {
            $tipe1 = "AND Pemborong LIKE '%YAO HSING%'";
        } else {
            $tipe1 = "AND Pemborong NOT LIKE '%YAO HSING%'";
        }
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, * FROM vwListBerkas AS tbl "
                . "WHERE GeneralStatus = 1 AND Pemborong LIKE '%".$pemborong."%' AND Jenis_Kelamin LIKE '%".$jekel."%' AND "
                . "Status_Personal LIKE '%".$status."%' AND Pendidikan LIKE '%".$pendidikan."%' AND Jurusan LIKE '%".$jurusan."%' AND "
                . "HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' AND Tgl_lahir LIKE '%".$thnlahir."%' ".$tipe1.") "
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
    function selectPostedTenakerWhere($start,$end,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama,$thnlahir,$tipe){
        if ($tipe == "K") {
            $tipe1 = "AND Pemborong LIKE '%YAO HSING%'";
        } else {
            $tipe1 = "AND Pemborong NOT LIKE '%YAO HSING%'";
        }
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
                . "* FROM vwTrnReportPosted AS tbl WHERE Pemborong LIKE '%".$pemborong."%' AND Jenis_Kelamin LIKE '%".$jekel."%' AND "
                . "Status_Personal LIKE '%".$status."%' AND Pendidikan LIKE '%".$pendidikan."%' AND Jurusan LIKE '%".$jurusan."%' AND "
                . "HeaderID LIKE '%".$noreg."%' AND Nama LIKE '%".$nama."%' AND Tgl_lahir LIKE '%".$thnlahir."%' ".$tipe1.") "
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

    //===== New Report to Excel=======
    function toExcelSemuaLimitMonth($bln, $thn){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = ".$thn." AND "
                . "MONTH(RegisteredDate) = ".$bln." ORDER BY HeaderID ASC");
        return $query->result();
    }
    function reportPostedLimitDate($bulan,$tahun){
        $query = $this->db->query("SELECT * FROM vwTrnReportPosted WHERE YEAR(PostedDate) = ".$tahun." AND "
                . "MONTH(PostedDate) = ".$bulan." ORDER BY PostedDate ASC");
        return $query->result();
    }

    function getDept(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM vwMstDepartemen WHERE IDDept IN "
                . "(SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.") ORDER BY DeptAbbr");
        return $query->result();
    }
    
    function getPekerjaan($dept){
        $query = $this->db->query("SELECT DISTINCT * FROM vwMstPekerjaanDept WHERE IDDept = '".$dept."'");
        return $query->result();
    }
    
    function getJabatan(){
        $query = $this->db->query("SELECT DISTINCT * FROM tblMstJabatan ORDER BY Jabatan");
        return $query->result();
    }
            
    function getPemborong(){
        $query = $this->db->query("SELECT * FROM PSGBorongan.dbo.tblMstPerusahaan ");
        return $query->result();
    }
    function getPemborongKaryawan(){
        $query = $this->db->query("SELECT * FROM vwMstPemborong WHERE Pemborong = 'RSUP' ");
        return $query->result();
    }
    
    function getStatusKawin(){
        $query = $this->db->get('tblMstStatusKawin');
        return $query->result();
    }
    
    function getPendidikan(){
        $query = $this->db->get('tblMstPendidikan');
        return $query->result();
    }
    
    function getJurusan(){
        $query = $this->db->get('tblMstJurusan');
        return $query->result();
    }
    
    function getPemborongAll(){
        $query = $this->db->query("SELECT * FROM vwMstPemborong ORDER BY Pemborong ASC");
        return $query->result();
    }
    function setInfoTran($id){
        $query = $this->db->query("SELECT * FROM vwTrnApprovalAll WHERE DetailID = '".$id."'");
        return $query->result();
    }
    function setInfoTranEdit($id){
        $query = $this->db->query("SELECT * FROM vwTrnApprovalAll WHERE DetailID = '".$id."'");
        return $query;
    }
    function updateTran($id,$data){
        $this->db->trans_start();
        $this->db->where('DetailID',$id);
        $this->db->update('tblTrnRequest',$data);
        $this->db->trans_complete();
    }

    function delete($id){
        //$this->db->where('DetailID',$id);
        //$this->db->delete('tblTrnRequest');
		$data = array('GeneralStatus'=>3);
		$this->db->trans_start();
		$this->db->where('DetailID',$id);
		$this->db->update('tblTrnRequest',$data);
		$this->db->trans_complete();
    }
	
	function getTenakerByTransID($id){
        $query = $this->db->query("SELECT HeaderID,TransID,Nama FROM tblTrnCalonTenagaKerja WHERE TransID='".$id."' AND PostingData='0' ");
        return $query->result();
    }
    function getTenakerByTransIDALL($DetailID){
        $query = $this->db->query("SELECT a.HeaderID,a.TransID,a.Nama,b.DeptAbbr,b.Pekerjaan 
                                        FROM
                                            tblTrnCalonTenagaKerja AS a
                                            JOIN vwTrnApprovalALL AS b ON a.TransID = b.DetailID 
                                        WHERE
                                            a.TransID IN (".$DetailID.") 
                                            AND a.PostingData= '0'");
        return $query->result();
    }
	function getTenakerByTransIDsucces($id){
        $query = $this->db->query("SELECT HeaderID,TransID,Nama FROM tblTrnCalonTenagaKerja WHERE TransID=".$id.
            " AND PostingData='1' and ClosingRemark <> 'Failed' ");
        return $query->result();
    }
	
    function updatecekidentifikasi($hdrid){
        $data = array(
            'GeneralStatus' => False,
            'TransID'       => NULL,
            'Transaksi'     => NULL,
            'DeptTujuan'    => NULL,
            'DeptTujuan'    => NULL
        );
        $this->db->trans_start();
        $this->db->where('HeaderID',$hdrid);
        $this->db->update('tblTrnCalonTenagaKerja',$data);
        $this->db->trans_complete();
    }

    function hapuscekidentifikasi($hdrid){
        $data = array(
            'GeneralStatus' => False,
            'TransID'       => NULL,
            'Transaksi'     => NULL,
            'DeptTujuan'    => NULL,
            'DeptTujuan'    => NULL
        );
        $this->db->trans_start();
        $this->db->where('HeaderID',$hdrid);
        $this->db->update('tblTrnCalonTenagaKerja',$data);
        $this->db->trans_complete();
    }
    
    function restoreAngkaTransaksi($transid){
        $query = $this->db->query("UPDATE tblTrnRequest set TKPermintaan = (SELECT TKPermintaan FROM tblTrnRequest WHERE DetailID = '".$transid."')+1 WHERE DetailID = '".$transid."'");
        return $query->result();
    }
    
	function getTransa($idDetail){
        $query = $this->db->query("SELECT * FROM tblTrnRequest WHERE DetailID = '".$idDetail."'");
        return $query->result();
    }

    function updateTrans($id,$data){
        $this->db->trans_start();
        $this->db->where('DetailID',$id);
        $this->db->update('tblTrnRequest',$data);
        $this->db->trans_complete();
    }

    function SelectIdentifikasi($periode){
        return $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE TransID IS NOT NULL and PostingData=0 AND SpecialJeda=0 and WawancaraHasil Is NULL AND CONVERT(DATE, SendedDate,103) = '".$periode."' ORDER BY HeaderID DESC")->result();
    }
	
	function countCalonKandidat(){
		$query = $this->db->query('SELECT distinct ID FROM tblTrnCalonKandidat ORDER BY ID DESC');
		return $query->num_rows();
	}
	
	function getCalonKandidat($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY ID DESC) AS Row, * FROM vwTrnCalonKandidat AS tbl)vwTrnCalonKandidat WHERE Row>='".$start."' AND Row<='".$end."'");
        return $query->result();
    }

    function countCalonKandidatwhere($nama,$periode){
        $query = $this->db->query("SELECT ID FROM vwCalonKandidat WHERE Nama LIKE '%".$nama."%' AND Periode LIKE '%".$periode."%' ORDER BY ID DESC");
        return $query->num_rows();
    }
    function countCalonKandidatwherenew($nama,$periode){
        $query = $this->db->query("SELECT ID FROM vwTrnCalonKandidat WHERE Nama LIKE '%".$nama."%' AND Periode LIKE '%".$periode."%' ORDER BY ID DESC");
        return $query->num_rows();
    }
    
    function getCalonKandidatwhere($start,$end,$nama,$periode){
        $query = $this->db->query("SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY ID DESC) AS Row, * FROM vwTrnCalonKandidat AS tbl WHERE Nama LIKE '%".$nama."%' AND Periode LIKE '%".$periode."%')vwTrnCalonKandidat WHERE Row>='".$start."' AND Row<='".$end."'");
        return $query->result();
    }
	
	function hapusCK($id){
		$this->db->where('ID',$id);
		$query = $this->db->delete('tblTrnCalonKandidat');
		return $query;
    }
    
    function getCalonKandidatExcelAll(){
        $query = $this->db->query("SELECT * FROM vwCalonKandidat");
        return $query->result();
    }

    function getCalonKandidatExcelLulus(){
        $query = $this->db->query("SELECT * FROM vwCalonKandidat WHERE Status='L'");
        return $query->result();
    }

    function getCalonKandidatExcelTidakLulus(){
        $query = $this->db->query("SELECT * FROM vwCalonKandidat WHERE Status='TL'");
        return $query->result();
    }

    function getdataIdeal($periode){
        $this->db->where('Periode',$periode);
        $this->db->order_by('DeptAbbr','asc');
        $query = $this->db->get('vwIdealKryTk');
        return $query->result();
    }

    function getDetailSubPerkerjaanDeptKry($issueID){
        $query = $this->db->query("SELECT JabatanName,count(JabatanName) AS TotalJabatan FROM PSGPayroll..vwMstKaryawan WHERE DeptAbbr='".$issueID."' and TGLKELUAR is null GROUP BY JabatanName");
        return $query;
    }

    function getDetailSubPerkerjaanDeptBor($issueID){
        $query = $this->db->query("SELECT Jabatan,count(Jabatan) AS TotalJabatan FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja WHERE DeptAbbr='".$issueID."' and TanggalKeluar is null and TanggalKeluarTemp is null GROUP BY Jabatan");
        return $query;
    }

    function get_db_berkas($id){
        return $this->db->get_where('tblTrnCalonKandidat',array('ID' => $id));
    }

    function update_db_berkas($id,$berkas,$lokasi){		
        $this->db->trans_start();
        $this->db->where('ID',$id);
        $this->db->update('tblTrnCalonKandidat',array($berkas => $lokasi));
        $this->db->trans_complete();
    }

    function getdatafoto($id){
        // $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE HeaderID='$id'");
        // return $query->result();
     
        $this->db->where('HeaderID', $id);
        $query = $this->db->get('tblTrnCalonTenagaKerja');
        return $query->result();
    }

    function update_status_foto($loginID){
        $this->db->trans_start();
        $this->db->where('LoginID',$loginID);
        $this->db->update('tblUtlUserDetail',array('AdaPhoto'=>1));
        $this->db->trans_complete();
    }

    function getJumlahRequestK(){
        $tahun = date('Y');
        $th = date('Y')-1;
        $get = $this->db->query("SELECT COUNT(DeptAbbr) AS Jumlah, SUM(TKTarget) AS jmlRequestK,SUM(TKSedia) AS jmlSuccess, SUM(TKPermintaan) AS JmlSisa FROM vwTrnApprovalAll WHERE YEAR(CreatedDate) BETWEEN '$th' AND '$tahun' AND Pemborong IN ('PSG') AND GeneralStatus IN (1)");
        return $get->result();
    }
    function getJumlahRequestTK(){
        $tahun = date('Y');
        $th = date('Y')-1;
        $get = $this->db->query("SELECT COUNT(DeptAbbr) AS Jumlah, SUM(TKTarget) AS JmlRequest,SUM(TKSedia) AS JmlSuccess,SUM(TKPermintaan) AS JmlSisa FROM vwTrnApprovalAll WHERE YEAR(CreatedDate) BETWEEN '$th' AND '$tahun' AND Pemborong IN ('ALL PEMBORONG') AND GeneralStatus = 1");
        return $get->result();
    }
}

/* End of file m_monitor.php */
/* Location: ./application/models/m_monitor.php */