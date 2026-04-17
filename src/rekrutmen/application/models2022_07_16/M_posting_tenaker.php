<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author by ITD15
 */

class M_posting_tenaker extends CI_Model{

    public function __construct() {
        parent::__construct();
    }

    function getTenakerOK(){
        $query = $this->db->query("SELECT
                                        * 
                                    FROM
                                        vwListBerkas_run20220611 
                                    WHERE
                                        Verified = '1' 
                                        AND SpecialScreening = '1' 
                                        AND WawancaraHasil = '1' 
                                        AND GeneralStatus = '0' 
                                        AND PostingData = '0'
                                ");   
        return $query->result();
    }

    function getTrans($idDetail){
        $query = $this->db->query("SELECT * FROM tblTrnRequest WHERE DetailID = '".$idDetail."'");
        return $query->result();
    }

    // ==================== Ambil Data Detail Karyawan dan Anaknya ===========================
    function getResult($hdrID){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE HeaderID ='".$hdrID."'");
        return $query->result();
    }
    function getInterV($hdrID){
        $query = $this->db->query("SELECT TOP 1 * FROM tblTrnWawancara WHERE HeaderID ='".$hdrID."' ORDER BY Tanggal DESC");
        return $query->result();
    }
    function getAnak($hdrID){
        $query = $this->db->query("SELECT TOP 2 * FROM tblTrnAnak WHERE HeaderID ='".$hdrID."' ORDER BY TglLahir DESC");
        return $query->result();
    }

    // ============== Lakukan Posting ================
    function setPosting($info){
        $this->db->trans_start();
        $this->db->insert('tblTrnPosting',$info);
        $this->db->insert_id();
        $this->db->trans_complete();
    }

    function cek_data_utility_p2k3($p2k3){
        $this->db->from($this->table1);
        $this->db->where('formula', $formula);
        $this->db->where('productiondate', $productiondate);
        $this->db->where('filler', $filler);
        $this->db->where('pack_kosong', $pack_kosong);
        $this->db->where('kategori_produk_2', $kategori_produk_2);
        $this->db->where('nm_produk', $nm_produk);
        $this->db->where('bbd', $bbd);
        $query = $this->db->get();
        return $query;

    }


    function updatePost($hdrID){
        $data   = array(
            'PostingData'   => 1,
            'GeneralStatus' => 1,
            'ClosingRemark' => 'Telah Diposting',
            'ClosingBy'     => $this->session->userdata('username'),
            'ClosingDate'   => date('Y-m-d H:i:s')
        );
        $this->db->trans_start();
        $this->db->where('HeaderID',$hdrID);
        $this->db->update('tblTrnCalonTenagaKerja', $data);
        $this->db->trans_complete();
    }
    function updateTrans($id,$data){
        $this->db->trans_start();
        $this->db->where('DetailID',$id);
        $this->db->update('tblTrnRequest',$data);
        $this->db->trans_complete();
    }

    //===================================================
    function resetToIdentifikasi($hdrID,$data){
        $this->db->trans_start();
        $this->db->where('HeaderID',$hdrID);
        $this->db->update('tblTrnCalonTenagaKerja',$data);
        $this->db->trans_complete();
    }

    // ===============Jika Ingin membuka dept lain==================
    function selectWhereIssue($deptTujuan,$pekerjaan){
        if($deptTujuan == 'MP1'){
            $dept   = 'MPD';
            $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalAll WHERE DeptAbbr LIKE '%".$dept."%' AND "
                . "GeneralStatus = 1 ORDER BY DeptAbbr");

        }else if ($deptTujuan == 'MP2'){
            $dept   = $deptTujuan;
            $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalAll WHERE DeptAbbr LIKE '%".$dept."%' OR DeptAbbr LIKE '%MPD%' AND "
                . "GeneralStatus = 1 ORDER BY DeptAbbr");
            
        }else{
            $dept   = $deptTujuan;
            $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalAll WHERE DeptAbbr LIKE '%".$dept."%' AND "
                . "GeneralStatus = 1 ORDER BY DeptAbbr");
        }
        
        return $query->result();
    }
    function selectWhereIssueByID($id){
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalAll WHERE DetailID = '".$id."'");
        return $query->row();
    }
    function updateIssueByTenaker($idHdr,$data){
        $this->db->trans_start();
        $this->db->where('HeaderID',$idHdr);
        $this->db->update('tblTrnCalonTenagaKerja',$data);
        $this->db->trans_complete();
    }

    function getDept($idDetail){
        $query = $this->db->query("SELECT * FROM vwTrnApprovalAll WHERE DetailID = '".$idDetail."'");
        return $query->result();
    }

}