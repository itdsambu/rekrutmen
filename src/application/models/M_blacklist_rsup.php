<?php defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_blacklist_rsup extends CI_Model{

	public function __construct() {
        parent::__construct();

        // $this->dbpsgrekrutmen = $this->load->database('psgrekrutmen', TRUE);
    }

    function get_KaryawanBlacklist(){
    	$query = $this->db->query("SELECT * FROM RSUPPayroll..vwDataKaryawanNonFinanceAll WHERE Blacklist = '1' ORDER BY TGLKELUAR DESC");
    	return $query->result();
    }

    function get_HarianBoronganBlacklist(){
    	$query = $this->db->query("SELECT * FROM RSUPBorongan2010..vwMasterTenagaKerja where Blacklist = '1' ORDER BY TanggalKeluar ASC");
    	return $query->result();
    }

    function get_CalonTenagaKerja(){
    	$query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerjaBlacklist");
    	return $query->result();
    }

    function get_MasyarakatBlacklist(){
        $query = $this->db->query("SELECT DetailID, Nama, Nik, TempatLahir, DaerahAsal, Suku, CAST(CAST(HistoryKasus AS VARCHAR(131)) AS TEXT) AS HistoryKasus, Foto, Computer, CreatedDate FROM Personalia.dbo.tbl_HumasDPO");
        return $query->result();
    }

    function get_TenagaKerjaDuaBulanBlacklist(){
        $query = $this->db->query("SELECT * FROM RSUPBorongan2010..vwMasterTenagaKerja where BlacklistDuaBulan = '1'");
        return $query->result();   
    }

     function get_CalonKarantinaBlacklist(){
        $query = $this->db->query("SELECT *,B.Pemborong FROM tblTrnBlacklistPraPelamar as A left join vwMstPemborong as B ON A.IDPemborong = B.IDPemborong");
        return $query->result();
    }

    function get_MasyarakatBlacklisttest(){
        $this->db->select('Foto');
        $this->db->from('Personalia.dbo.tbl_HumasDPO');
        $this->db->limit('1');
        return $query = $this->db->get()->result();
    }

    function get_MasyarakatBlacklist3(){
        $query = $this->db->query("SELECT DetailID, Nama, Nik, TempatLahir, DaerahAsal, Suku, CAST(CAST(HistoryKasus AS VARCHAR(131)) AS TEXT) AS HistoryKasus, CAST(Foto AS VARBINARY(MAX)) AS Foto, Computer, CreatedDate FROM Personalia.dbo.tbl_HumasDPO");
        return $query->result();
    }

     function getJmlhBlacklistTK(){
        $this->db->where('Blacklist', 1);
        $get = $this->db->get('RSUPBorongan2010.dbo.tblMstTenagaKerja');
        return $get->num_rows();
    }

    function getJmlhBlacklistK(){
        $this->db->where('Blacklist', 1);
        $get = $this->db->get('RSUPPayroll..vwDataKaryawanNonFinanceAll');
        return $get->num_rows();
    }

    function getJmlhBlacklistCTK(){
        $this->db->where('Blacklist', 1);
        $get = $this->db->get('tblTrnCalonTenagaKerjaBlacklist');
        return $get->num_rows();
    }

    function getJmlhBlacklistM(){
        $get = $this->db->get('vw_tblTrnBlacklistMasyarakat');
        return $get->num_rows();
    }

    function getJmlhBlacklistTkduabulan(){
        $this->db->where('BlacklistDuaBulan', 1);
        $get = $this->db->get('RSUPBorongan2010.dbo.tblMstTenagaKerja');
        return $get->num_rows();
    }

    function get_excel1(){
        return $this->db->query("SELECT Nik,Nama,NamaIbuKandung,TanggalKeluar,TanggalMasuk,ketKeluar,TempatLahir,TanggalLahir,Bagian,Pemborong,Perusahaan,Nofix FROM RSUPBorongan2010.dbo.vwMasterTenagaKerja where Blacklist = 1")->result();
    }
    function get_excel2(){
        return $this->db->query("SELECT RegNo,NIK,NAMA,NamaBagian,TGLMASUK,TGLKELUAR,TGLLAHIR,TEMPATLHR,Blacklist_ket FROM RSUPPayroll.dbo.vwDataKaryawanNonFinanceAll where Blacklist = 1")->result();
    }

    function get_excel3(){
        return $this->db->query("SELECT HeaderID, NIK, Nama, NamaIbuKandung, TanggalLahir, TanggalMasuk, TanggalKeluar, Pemborong, NamaCV, Keterangan FROM tblTrnCalonTenagaKerjaBlacklist WHERE Blacklist = 1")->result();
    }

    function karyawankeluar(){
        return $this->db->query("SELECT * FROM RSUPPayroll.dbo.KARYAWAN WHERE TGLKELUAR IS NOT NULL AND (YEAR(TGLKELUAR) = '".date('Y')."') AND (MONTH(TGLKELUAR) = '".date('m')."') AND (Blacklist IS NULL)")->result();
    }

    function getDataBlacklistK($nik){
         return $this->db->query("select * from RSUPPayroll..vwDataKaryawanNonFinanceAll where NIK like '%$nik%' or NAMA like '%$nik%' or RegNo like '%$nik' ")->result();
    }
    function get_dataKaryawan($nik){
        return $this->db->query("select * from RSUPPayroll..vwDataKaryawanNonFinanceAll where NIK = '$nik'")->result();
    }

    function simpanDataBlacklistM($data){
        $this->db->insert('tblTrnBlacklistMasyarakat',$data);
        $hdrid = $this->db->insert_id();
        return $hdrid;
    }

    function tambah_balcklistcalonTK($data){
        $this->db->insert('tblTrnCalonTenagaKerjaBlacklist',$data);
        $hdrid = $this->db->insert_id();
        return $hdrid;
    }

    function getDataCalonTenagaKerja($hdrid){
       $this->db->where('HeaderID', $hdrid);
       return $this->db->get('tblTrnCalonTenagaKerja')->result();
    }

    function get_dataBlacklistKPSG(){
        $query = $this->dbpsgrekrutmen->query("SELECT * FROM vwTrnBlacklistK WHERE CVNama in ('PT. PULAU SAMBU GUNTUNG')");
        return $query->result();
        
    }

    function get_dataBlacklistTKPSG(){
        $query = $this->dbpsgrekrutmen->query("SELECT * FROM tblTrnBlacklist WHERE CVNama not in ('PT. PULAU SAMBU GUNTUNG')");
        return $query->result();
    }

    function get_dataMasyarakat(){
        // $query = $this->db->query("SELECT * FROM tblTrnBlacklistMasyarakat");
        // return $query->result();

        $sql = "SELECT * FROM tblTrnBlacklistMasyarakat";
        $sth = $db->query($sql);
        $result = mysqli_fetch_array($sth);
    }

    function update_blacklist($id,$data){
        $this->db->where('RegNo', $id);
        $this->db->update('RSUPPayroll.dbo.KARYAWAN',$data);
    }

    function get_data_pra_pelamar($nik){
        $query = $this->db->query("SELECT * FROM tblTrnPraPelamar as A left join vwMstPemborong as B ON A.IDPemborong = B.IDPemborong where A.Pra_PelamarID = '$nik'");
        return $query->result();
    }

    function simpan_blacklist_pra($data){
        $this->db->insert('tblTrnBlacklistPraPelamar',$data);
    }

}