<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_blacklist extends CI_Model {

    function __construct() {
        parent:: __construct();
		
		// $this->dbpayroll   = $this->load->database('rsuppayroll', TRUE);
  //       $this->dbborongan   = $this->load->database('rsupborongan', TRUE);
    }

    function getData(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM PSGPayroll.dbo.v_kk_mstkaryawan WHERE NIK ='$NIK'");
        return $query->result();
    }

    function save($data){
        $this->db->insert('tblTrnBlacklist',$data);
        $hdrid = $this->db->insert_id();
        $this->db->trans_complete();
        return $hdrid;
    }

    public function selectBlacklistK(){
        $query = $this->db->query("SELECT * FROM vwTrnBlacklistK WHERE CVNama='PT. PULAU SAMBU GUNTUNG'");
        return $query->result();
    } 

    public function filterselectBlacklistK($nama){
        $query = $this->db->query("SELECT * FROM vwTrnBlacklistK WHERE CVNama='PT. PULAU SAMBU GUNTUNG' AND NAMA LIKE '%$nama%'");
        return $query->result();
    }

    public function selectBlacklistTK(){
        $query = $this->db->query("SELECT * FROM vwTrnBlacklistTK WHERE CVNama != 'PT. PULAU SAMBU GUNTUNG'");
        return $query->result();
    }

    public function filterselectBlacklistTK($nama){
        $query = $this->db->query("SELECT * FROM vwTrnBlacklistTK WHERE CVNama != 'PT. PULAU SAMBU GUNTUNG' AND NAMA LIKE '%$nama%'");
        return $query->result();
    }

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
        $sql_product = $this->db->query("SELECT * FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja WHERE Nik ='$nik'");
        if($sql_product->num_rows() >0){
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function printBlacklistKaryawan(){
        $query = $this->db->query("SELECT * FROM vwTrnBlacklistK");
        return $query->result();
    }

    function printBlacklistTenaker(){
        $query = $this->db->query("SELECT * FROM vwTrnBlacklistTK");
        return $query->result();
    }

    // detail KARYAWAN

    function get_karyawan($nik){
        return $this->db->get_where('vwTrnBlacklistK',array('NIK'=>$nik));
    }

    function get_tenaker($nik){
        return $this->db->get_where('vwTrnBlacklistTK',array('NIK'=>$nik));
    }
	
    // BY PASS
	
	function savebypass($data){
        $this->db->insert('tblTrnBlacklistTemporary',$data);
        $hdrid = $this->db->insert_id();
        $this->db->trans_complete();
        return $hdrid;
    }

    function getPSGPemborong($idpemborong){
        if($idpemborong > 0){
            $result = $this->db->get_where('vwMstPemborong', array('IDPerusahaan'=>$idpemborong));
        }else{
            $this->db->select('*');
            $this->db->from('vwMstPemborong');
            $this->db->order_by('Perusahaan','ASC');
            $result = $this->db->get();
        }
        return $result->result();
    }

    function getPemborong(){
        $pemborong = strtoupper($this->input->post('pemborong'));
        $query = $this->db->get_where('vwMstPemborong', array('Perusahaan' => $pemborong));
        if($query->num_rows() > 0){
            $row = $query->row();
            $perusahaan=$row->Pimpinan;
        }else{
            $perusahaan='';
        }
        return $perusahaan;
    }

    public function selectBlacklistByPass(){
        $query = $this->db->query("SELECT * FROM tblTrnBlacklistTemporary");
        return $query->result();
    }

    public function filterselectBlacklistByPass($nama){
        $query = $this->db->query("SELECT * FROM tblTrnBlacklistTemporary WHERE Nama LIKE '%$nama%'");
        return $query->result();
    }
	
	function get_detailbypass($id){
        return $this->db->get_where('tblTrnBlacklistTemporary',array('Detail'=>$id));
    }
	
	function update_status_foto($id){
        // $this->db->trans_start();
        // $this->db->where('Detail',$id);
        // $this->db->set('AdaPhoto','1');
        // $this->db->update('tblTrnBlacklistTemporary');
        // $this->db->trans_complete();
        $query = $this->db->query("UPDATE tblTrnBlacklistTemporary SET AdaPhoto='1' WHERE Detail='$id'");
    }
	
	function selectBlacklistKRSUP(){
        $query = $this->load->database('rsuppayroll', TRUE)->query("SELECT * FROM RSUPPayroll..vwDataKaryawanNonFinanceAll WHERE Blacklist='1'");
        return $query->result();
    }

    function filterselectBlacklistKRSUP($nama){
        $query = $this->load->database('rsuppayroll', TRUE)->query("SELECT * FROM RSUPPayroll..vwDataKaryawanNonFinanceAll WHERE Blacklist='1' AND NAMA like '%$nama%'");
        return $query->result();
    }

    function selectBlacklistTKRSUP(){
        $query = $this->load->database('rsupborongan', TRUE)->query("SELECT * FROM RSUPBorongan2010..vwMasterTenagaKerja WHERE Blacklist='1'");
        return $query->result();
    }
    function filterselectBlacklistTKRSUP($nama){
        $query = $this->load->database('rsupborongan', TRUE)->query("SELECT * FROM RSUPBorongan2010..vwMasterTenagaKerja WHERE Blacklist='1'  AND NAMA like '%$nama%'");
        return $query->result();
    }
	
	function get_detailKRSUP($id){
        return $this->load->database('rsuppayroll', TRUE)->get_where('RSUPPayroll..vwDataKaryawanNonFinanceAll',array('RegNo'=>$id));
    }
	
	function get_detailTKRSUP($id){
        return $this->load->database('rsuppayroll', TRUE)->get_where('RSUPBorongan2010..vwMasterTenagaKerja',array('RequestID'=>$id));
    }

    function blok_dua_bulan() {
        $query = $this->db->query("SELECT * FROM vwTrnBlacklistTK WHERE CVNama != 'PT. PULAU SAMBU GUNTUNG' AND BlackListDuaBulan = 1");
        return $query->result();
    }
}