<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_memo_tenaga_kerja extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
 
 	function get_approvalWawancara(){
 		$grupID = $this->session->userdata('groupuser');
 		$query = $this->db->query("SELECT * FROM vwListBerkas where WawancaraCek = '1' and  WawancaraDept IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.") and AppMemoWawancara IS NULL and DeptTujuan in ('PBL','WHK')");
 		return $query->result();
 	}

 	function get_approvalWawancara_dept(){
 		$grupID = $this->session->userdata('groupuser');
 		$query = $this->db->query("SELECT * FROM vwListBerkas as A left join tblTrnWawancara as B ON A.HeaderID = B.HeaderID where A.WawancaraCek = '1' and  A.WawancaraDept IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID ='$grupID') and A.AppMemoWawancara = '1' and A.AppMemoWawancara_dept IS NULL");
 		return $query->result();
 	}

 	function get_approvalWawancara_div(){
 		$grupID = $this->session->userdata('groupuser');
 		$query = $this->db->query("SELECT * FROM vwListBerkas as A left join tblTrnWawancara as B ON A.HeaderID = B.HeaderID where A.WawancaraCek = '1' and  A.WawancaraDept IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.") and A.AppMemoWawancara_dept = '1' and A.AppMemoWawancara_div IS NULL");
 		return $query->result();
 	}

 	function simpan($hdrid,$data){
 		$this->db->where('HeaderID',$hdrid);
 		$this->db->update('tblTrnCalonTenagaKerja',$data);
 	}

 	function get_approvalCekFisik(){
 		$grupID = $this->session->userdata('groupuser');
 		$query = $this->db->query("SELECT * FROM vwListBerkas as A left join tblTrnHasilCekFisik as B ON A.HeaderID = B.RequestID where A.FisikCek = '1' and  A.FisikDept IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID ='$grupID') and A.AppMemoCekFisik IS NULL AND convert(varchar, A.FisikCekDate, 105) = convert(varchar, GETDATE(), 105)");
 		return $query->result();
 	}

 	function simpan_hasil($data){
 		$this->db->insert('tblTrnHasilCekFisik',$data);
 		$primay_key = $this->db->insert_id();
		return $primay_key;
 	}   

 	function updateForm($hdrid,$data){
 		$this->db->where('ID',$hdrid);
 		$this->db->update('tblTrnHasilCekFisik',$data);

 	}

 	function get_hasil($hdrid){
 		$query = $this->db->query("SELECT * FROM tblTrnWawancara where HeaderID = '$hdrid'");
 		return $query->result();
 	}

 	function update_wawancara($hdrid,$data){
 		$this->db->where('HeaderID',$hdrid);
 		$this->db->update('tblTrnWawancara',$data);
 	}

 	function update_tk($hdrid,$data){
 		$this->db->where('HeaderID',$hdrid);
 		$this->db->update('tblTrnCalonTenagaKerja',$data);
 	}

 	// Monitoring

 	function get_TkCekFisik(){
 		$bulan = date('m');
 		$tahun = date('Y');
 		$grupID = $this->session->userdata('groupuser');
 		$query = $this->db->query("SELECT * FROM vwListBerkas where FisikDept IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID ='$grupID') and FisikCek = '1' and MONTH(CreatedDate) = '$bulan' and YEAR(CreatedDate) = '$tahun' order by HeaderID desc");
 		return $query->result();
 	}

 	function get_hasilcekfisik(){
 		$bulan = date('m');
 		$tahun = date('Y');
 		$query = $this->db->query("SELECT * FROM tblTrnHasilCekFisik where MONTH(CreatedDate) = '$bulan' and YEAR(CreatedDate) = '$tahun' order by ID desc");
 		return $query->result();
 	}

 	function get_TkCekFisikPerTanggal($tanggal,$jamAwal,$jamAkhir){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM vwListBerkas where FisikDept IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID ='12') and FisikCek = '1' and CONVERT(DATE,FisikCekDate) = '$tanggal' and CONVERT(VARCHAR(8),CAST(FisikCekDate as time)) BETWEEN  '$jamAwal' AND '$jamAkhir' order by HeaderID desc");
        return $query->result();
    }

    function get_hasilcekfisikPerTanggal($tanggal,$jamAwal,$jamAkhir){
        $query = $this->db->query("SELECT * FROM tblTrnHasilCekFisik where CONVERT(DATE,CreatedDate) = '$tanggal' and CONVERT(VARCHAR(8),CAST(CreatedDate as time)) BETWEEN  '$jamAwal' AND '$jamAkhir'");
        return $query->result();
    }

    function get_tenagakerja($tanggal,$jamAwal,$jamAkhir){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM vwListBerkas where FisikDept IN (SELECT DISTINCT DeptAbbr FROM vwTrnDeptWawancara WHERE GroupID ='$grupID') and FisikCek = '1' and CONVERT(DATE,FisikCekDate) = '$tanggal' and CONVERT(VARCHAR(8),CAST(FisikCekDate as time)) BETWEEN  '$jamAwal' AND '$jamAkhir' order by HeaderID desc");
        return $query->result();
    }


 	function get_appmemocekfisik($tanggal){
 		$query = $this->db->query("SELECT distinct AppMemoCekFisik,AppMemoCekFisikBy,AppMemoCekFisikDate FROM vwListBerkas where CONVERT(DATE,FisikCekDate) = '$tanggal' and AppMemoCekFisikDate IS NOT NULL");
 		return $query->result();
 	}

    function getUser($userID){
        $query = $this->db->query("SELECT * FROM tblUtlLogin where LoginID = '".$userID."'");
        return $query->result();
    }

 	function get_TkWawancara(){
 		$query = $this->db->query("SELECT * FROM vwListBerkas where WawancaraCek = '1' order by HeaderID desc");
 		return $query->result();
 	}

 	function get_tkwawancarapertanggal($tanggal,$dept){
 		$query = $this->db->query("SELECT * FROM vwListBerkas where WawancaraCek = '1' and CONVERT(DATE,WawancaraCekDate) = '$tanggal' and WawancaraDept ='$dept' order by HeaderID desc");
 		return $query->result();
 	}

 	function get_departemen(){
 		$query = $this->db->query("SELECT DISTINCT DeptID,DeptAbbr FROM tblMstDepartemenNew WHERE DeptAbbr IN ('PBL','WHK')");
 		return $query->result();
 	}

 	function get_dept($dept){
 		$query = $this->db->query("SELECT distinct DeptID,DeptAbbr FROM tblMstDepartemenNew where DeptAbbr='$dept'");
 		return $query->result();
 	}

 	function get_appmemowawancara($tanggal){
 		$query = $this->db->query("SELECT distinct AppMemoWawancara, AppMemoWawancaraBy,AppMemoWawancara_dept,AppMemoWawancaraBy_dept,AppMemoWawancara_div,AppMemoWawancaraBy_div,GeneralApproved FROM vwListBerkas where CONVERT(DATE,WawancaraCekDate) = '$tanggal' and AppMemoWawancaraDate IS NOT NULL");
 		return $query->result();
 	}

 	function get_hasilwawancara(){
 		$query = $this->db->query("SELECT * FROM tblTrnWawancara");
 		return $query->result();
 	}
}