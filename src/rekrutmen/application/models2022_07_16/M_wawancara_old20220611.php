<?php

/* 
 * Author by ITD15
 */

class M_wawancara extends CI_Model{
    
    public function __construct() {
        parent::__construct();   
    }
    
    // ============================ TUJUAN WAWANCARA =================
    function getCVNama(){
        $query = $this->db->query("SELECT DISTINCT(CVNama) FROM tblTrnCalonTenagaKerja WHERE GeneralStatus = 0 AND Verified = 1 AND DeptTujuan IS NULL ORDER BY CVNama DESC");
        return $query->result();
    }

    function getTenagaKerja(){
        $query = $this->db->query("SELECT
                                        * 
                                    FROM
                                        tblTrnCalonTenagaKerja 
                                        LEFT JOIN tblTrnKarantina_dtl ON tblTrnCalonTenagaKerja.HeaderID = tblTrnKarantina_dtl.registrasi_id
                                    WHERE
                                        tblTrnCalonTenagaKerja.GeneralStatus = '0' 
                                        AND tblTrnCalonTenagaKerja.Verified = '1' 
                                        AND tblTrnCalonTenagaKerja.DeptTujuan IS NULL 
                                        AND tblTrnCalonTenagaKerja.CVNama = 'PT. PULAU SAMBU (GUNTUNG)' 
                                        AND tblTrnKarantina_dtl.status_karantina = '1'
                                        AND tblTrnKarantina_dtl.tgl_klr_karantina IS NOT NULL
                                        AND tblTrnKarantina_dtl.hasil_tes_karantina IS NOT NULL
                                        AND dbo.tblTrnKarantina_dtl.tgl_klr_karantina >= '2022-03-01'
                                    ORDER BY
                                        HeaderID ASC");
        return $query->result();
    }
    function getTenagaKerja_($filter_status2){
        $query = $this->db->query("SELECT
                                        * 
                                    FROM
                                        tblTrnCalonTenagaKerja 
                                        LEFT JOIN tblTrnKarantina_dtl ON tblTrnCalonTenagaKerja.HeaderID = tblTrnKarantina_dtl.registrasi_id
                                    WHERE
                                        tblTrnCalonTenagaKerja.GeneralStatus = '0' 
                                        AND tblTrnCalonTenagaKerja.Verified = '1' 
                                        AND tblTrnCalonTenagaKerja.DeptTujuan IS NULL 
                                        AND tblTrnCalonTenagaKerja.CVNama = '".$filter_status2."' 
                                        AND tblTrnKarantina_dtl.status_karantina = '1'
                                        AND tblTrnKarantina_dtl.tgl_klr_karantina IS NOT NULL
                                        AND tblTrnKarantina_dtl.hasil_tes_karantina IS NOT NULL
                                        AND dbo.tblTrnKarantina_dtl.tgl_klr_karantina >= '2022-03-01'
                                    ORDER BY
                                        HeaderID ASC");
        return $query->result();
    }
    function getDepartment(){
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL WHERE GeneralStatus = 1 ");
        return $query->result();
    }
    function getDepartment2($jenis){
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL WHERE Pemborong='$jenis' and  GeneralStatus = 1 ");
        return $query->result();
    }
    function getDept($idDetail){
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL WHERE DetailID = '".$idDetail."'");
        return $query->result();
    }
    function quota($transID){
        $query = $this->db->query("SELECT TransID, COUNT(HeaderID) AS Quota FROM tblTrnCalonTenagaKerja WHERE "
                . "TransID = ".$transID." AND TransID Is Not NULL GROUP BY TransID");
        return $query->result();
    }
            
    function updateDeptTujuan($hdrID,$data){
        $this->db->trans_start();
        $this->db->where('HeaderID',$hdrID);
        $this->db->update('tblTrnCalonTenagaKerja',$data);
        $this->db->trans_complete();
    }
    function updateTempMinta($detailID,$temp){
        $this->db->trans_start();
        $this->db->where('DetailID',$detailID);
        $this->db->update('tblTrnRequest',array('TempSetTenaker' => $temp));
        $this->db->trans_complete();
    }
    
    function getDetailTK($hdrid){
        return $this->db->get_where('tblTrnCalonTenagaKerja',array('HeaderID'=>$hdrid));
    }
    function getDetailTenaker($hdrid){
        return $this->db->get_where('vwTenakerForInterview_karantina',array('HeaderID'=>$hdrid));
    }
    
    //=============== PROSES WAWANCARA HARIAN==============
    function getKualifikasiDasar(){
        $query = $this->db->query("SELECT * FROM tblMstListKualifikasi");
        return $query->result();
    }
    
    function getTenakerHarian(){
        $grupID = $this->session->userdata('groupuser');
        // var_dump($grupID); die;
        // 
        if ($grupID == '29') { //Kondisi Hidden Overtime khusus
            $query = $this->db->query("SELECT datediff(day,SendedDate,GETDATE()) as overtime,*
                                            FROM
                                                vwTenakerForInterview_karantina 
                                            WHERE
                                                GeneralStatus = 0 
                                                AND Pemborong != 'YAO HSING' 
                                                AND WawancaraHasil IS NULL 
                                                AND DeptID IN ( SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID = ".$grupID." ) AND datediff(day,SendedDate,GETDATE()) <= 6");
        } else {
            $query = $this->db->query("SELECT * FROM vwTenakerForInterview_karantina WHERE GeneralStatus = 0 AND Pemborong != 'YAO HSING' AND "
                . "WawancaraHasil Is NULL AND DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.")");
        }
        
        //echo $this->db->last_query();
        return $query->result();
    }
    function cekMP($HrdID){
        $kondisi    = 0;
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE HeaderID = '".$HrdID."' AND DeptTujuan LIKE 'MP%'");
        if($query->num_rows() > 0 ){
            $kondisi = 1;
        }else{
            $kondisi = 0;
        }
        return $kondisi;
    }
    function getPekerjaan($department){
        $query = $this->db->query("SELECT DISTINCT * FROM vwMsrPekerjaanDept WHERE DeptAbbr = '".$department."'");
        return $query->result();
    }
    function getPekerjaanGO(){
        $query = $this->db->query("SELECT  DISTINCT b.DeptID, b.DeptAbbr, a.IDPekerjaan, a.Pekerjaan, b.BagianIDBorongan
FROM [192.168.3.32].PSGBorongan.dbo.tblMstPekerjaan AS a INNER JOIN dbo.tblMstDepartemenNew AS b ON a.IDPekerjaan = b.BagianIDBorongan WHERE b.DeptAbbr LIKE '%MP%'");
        return $query->result();   
    }
    function getPekerjaanHarian(){
        $query = $this->db->query("SELECT * FROM tblMstPekerjaanHarian ");
        return $query->result();
    }
            
    function getHasil($hrdID){
        $query = $this->db->query("SELECT AVG(RataNilai) AS Total FROM tblTrnWawancara WHERE HeaderID =".$hrdID);
        return $query->result();  
    }


    //=============== PROSES WAWANCARA STRATA==============
    function getKualifikasiKaryawan(){
        $query = $this->db->query("SELECT * FROM tblMstListKualifikasiKaryawan");
        return $query->result();
    }
    function getKualifikasiSMU(){
        $query = $this->db->query("SELECT * FROM tblMstListKualifikasiKaryawanSMU");
        return $query->result();
    }
    
    function getTenaker(){
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM vwTenakerForInterview_karantina WHERE GeneralStatus = 0 AND Pemborong = 'YAO HSING' AND "
                . "WawancaraHasil Is NULL AND DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.")");
        return $query->result();
    }
    
    
    //=================PROSES WAWANCARA SMU===================
    function getKualifikasiKaryawanSMU(){
        $query = $this->db->query("SELECT * FROM tblMstListKualifikasiKaryawan");
        return $query->result();
    }
    
    
    // ============================= SIMPAN PROSES WAWANCARA ===================
    function insertWawancara($data){
        $this->db->trans_start();
        $this->db->insert('tblTrnWawancara',$data);
        $wID = $this->db->insert_id();
        $this->db->trans_complete();
        return $wID;
    }
    
    function insertDetailWawancara($data){
        $this->db->trans_start();
        $this->db->insert('tblTrnWawancaraDetail',$data);
        $this->db->insert_id();
        $this->db->trans_complete();
    }
    
    function updateWawancaraTenaker($hrdID,$info){
        $this->db->where('HeaderID',$hrdID);
        $this->db->update('tblTrnCalonTenagaKerja',$info);
    }
    
    //============== auto update list interview if > 3 =================
    
}


/* End of file m_wawancara.php */
/* Location: ./application/controllers/m_wawancara.php */