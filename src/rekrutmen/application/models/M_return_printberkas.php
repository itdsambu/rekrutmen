<?php defined('BASEPATH') or exit('No Direct Script Access Allowed');

class m_return_printberkas extends CI_Model{

    public function __construct() {
        parent::__construct();
    }

    function getDataMcuForm(){
    	$bulan = date('m');
    	$tahun = date('Y');
    	$query = $this->db->query("SELECT * FROM RSUPPayroll.dbo.v_kk_CalonTenagaKerjalulusWawancara where PrintMCUForm = 1 and MONTH(PrintMCUFormDate) = '$bulan' and YEAR(PrintMCUFormDate) = '$tahun'");
    	return $query->result();
    }

    function update($id,$data){
    	$this->db->where('HeaderID',$id);
    	$this->db->update('tblTrnCalonTenagaKerja',$data);
    }

    function getDataAjaxMcuForm($bulan,$tahun){
        $query = $this->db->query("SELECT * FROM RSUPPayroll.dbo.v_kk_CalonTenagaKerjalulusWawancara where PrintMCUForm = 1 and MONTH(PrintMCUFormDate) = '$bulan' and YEAR(PrintMCUFormDate) = '$tahun'");
        return $query->result();
    }

    function getDataMcuCard(){
        $bulan = date('m');
        $tahun = date('Y');
        $query = $this->db->query("SELECT * FROM RSUPPayroll.dbo.v_kk_CalonTenagaKerjalulusWawancara where PrintMCUCard = 1 and MONTH(PrintMCUCardDate) = '$bulan' and YEAR(PrintMCUCardDate) = '$tahun'");
        return $query->result();
    }

    function getDataAjaxMcuCard($bulan,$tahun){
        $query = $this->db->query("SELECT * FROM RSUPPayroll.dbo.v_kk_CalonTenagaKerjalulusWawancara where PrintMCUCard = 1 and MONTH(PrintMCUCardDate) = '$bulan' and YEAR(PrintMCUCardDate) = '$tahun'");
        return $query->result();
    }

    function getDataSPMK(){
        $bulan = date('m');
        $tahun = date('Y');
        $query = $this->db->query("SELECT * FROM RSUPPayroll.dbo.v_kk_CalonTenagaKerjalulusWawancara where PrintSPMK = 1 and MONTH(PrintSPMKDate) = '$bulan' and YEAR(PrintSPMKDate) = '$tahun'");
        return $query->result();
    }

    function getDataAjaxSPMK($bulan,$tahun){
        $query = $this->db->query("SELECT * FROM RSUPPayroll.dbo.v_kk_CalonTenagaKerjalulusWawancara where PrintSPMK = 1 and MONTH(PrintSPMKDate) = '$bulan' and YEAR(PrintSPMKDate) = '$tahun'");
        return $query->result();
    }

    function getDataKpbCard(){
        $bulan = date('m');
        $tahun = date('Y');
        $query = $this->db->query("SELECT * FROM RSUPPayroll.dbo.v_kk_CalonTenagaKerjalulusWawancara where PrintKPBCard = 1 and MONTH(PrintKPBCardDate) = '$bulan' and YEAR(PrintKPBCardDate) = '$tahun'");
        return $query->result();
    }

    function getDataAjaxKpbCard($bulan,$tahun){
        $query = $this->db->query("SELECT * FROM RSUPPayroll.dbo.v_kk_CalonTenagaKerjalulusWawancara where PrintKPBCard = 1 and MONTH(PrintKPBCardDate) = '$bulan' and YEAR(PrintKPBCardDate) = '$tahun'");
        return $query->result();
    }
}