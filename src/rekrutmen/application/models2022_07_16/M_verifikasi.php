<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_verifikasi extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }

    function list_calon_tk($dataselect, $start_date, $end_date, $pemborong, $nama, $noreg, $start_paging, $end_paging){
        switch ($dataselect) {
            case '1':
                $con = 'and ktp is not null and lamaran is not null and cv is not null and ijazah is not null and transkrip is not null ';
                break;
            case '2':
                $con = 'and ktp is not null ';
                break;
            case '3':
                $con = 'and ktp is null and lamaran is null and cv is null and ijazah is null and transkrip is null';
                break;
            
            // 0
            default:
                $con = '';
                break;
        }

        $con_noreg = !empty($noreg) ? "and headerid like '%".$noreg."%'" : '';
        $con_nama = !empty($nama) ? "and nama like '%".$nama."%'" : '';
        $con_pemborong = !empty($pemborong) ? "and pemborong like '%".$pemborong."%'" : '';

        $q1 = $this->db->query("select 
                                    hdrid 
                                from 
                                    vwlistberkas_run20220611
                                where 
                                    generalstatus = 0 
                                    and verified not in (1)
                                    and registereddate >='$start_date'
                                    and registereddate <='$end_date'
                                    $con
                                    $con_noreg
                                    $con_nama
                                    $con_pemborong")->num_rows();

        $q2 = $this->db->query("select 
                                    *
                                from 
                                    (select 
                                        row_number() over(order by verified asc) as row, 
                                        * 
                                    from 
                                        vwListBerkas_run20220611 
                                    where 
                                        generalstatus = 0 
                                        and verified not in (1)
                                        and registereddate >='$start_date'
                                        and registereddate <='$end_date'
                                        $con
                                        $con_noreg
                                        $con_nama
                                        $con_pemborong) a 
                                where 
                                    row >= $start_paging 
                                    and row <= $end_paging")->result();

        return [
            'jumlah_row' => $q1,
            'list_per_page' => $q2,
        ]; 
    }

    function updateVerified($hdrID){
        $data   = array(
            'Verified'      => 1,
            'VerifiedBy'    => strtoupper($this->session->userdata('username')),
            'VerifiedDate'  => date('Y-m-d H:i:s')
        );
        $this->db->trans_start();
        $this->db->where('HeaderID',$hdrID);
        $this->db->update('tblTrnCalonTenagaKerja',$data);
        $this->db->trans_complete();
    }
    
    function batalVerified($hdrID){
        $this->db->trans_start();
        $this->db->where('HeaderID',$hdrID);
        $this->db->update('tblTrnCalonTenagaKerja',array('Verified'=>0));
        $this->db->trans_complete();
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
    
    function get_detailtk($hdrid){
        return $this->db->get_where('vwTrnCalonTenagaKarantina',array('HeaderID'=>$hdrid));
    }

    function resultScreen($hdrid){
        return $this->db->get_where('tblTrnVerifikasi',array('HeaderID'=>$hdrid));
    }

    function simpanVerifikasiTim($data){
        $this->db->trans_start();
        $this->db->insert('tblTrnVerifikasi',$data);
        $sID = $this->db->insert_id();
        $this->db->trans_complete();
        return $sID;
    }
}