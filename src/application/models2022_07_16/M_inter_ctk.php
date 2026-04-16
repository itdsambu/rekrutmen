<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_inter_ctk extends CI_Model{
    
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
        $query = $this->db->query("SELECT DISTINCT
                                        b.RegNo,
                                        a.HeaderID,
                                        a.Nama,
                                        a.Pemborong,
                                        a.DeptTujuan,
                                        a.Tgl_Lahir,
                                        a.Jenis_Kelamin,
                                        a.RegisteredBy,
                                        a.RegisteredDate,
                                        a.TanggalVaksin,
                                        a.TanggalVaksin2,
                                        a.TanggalVaksin3,
                                        a.JenisVaksin,
                                        a.No_Ktp 
                                    FROM
                                        tblTrnCalonTenagaKerja AS a
                                        JOIN PSGPayroll..KARYAWAN AS b ON a.Nama = b.NAMA 
                                        AND a.NamaIbuKandung = b.NamaIbuKandung 
                                        AND a.NamaBapak = b.NamaAyah 
                                        AND a.No_Ktp = b.NoKTP 
                                        WHERE
                                            a.GeneralStatus = 1 
                                            AND a.Pemborong = ( 'YAO HSING' ) 
                                            AND a.DeptTujuan IS NOT NULL 
                                            AND a.RegisteredDate BETWEEN '".$start."' 
                                            AND '".$end."' 
                                        ORDER BY
                                            HeaderID DESC");
        return $query->result();

        // $query = $this->db->query("SELECT HeaderID,Nama,Pemborong,Tgl_Lahir,Jenis_Kelamin,ScreeningHasil,
        // ScreeningComplete,SpecialScreening,Verified,PostingData,RegisteredBy,RegisteredDate,
        // [dbo].[fnGenerateHistory] (k.HeaderID) as History
        // FROM tblTrnCalonTenagaKerja k WHERE GeneralStatus = 0 and convert(char,RegisteredDate,105) like '%$monthyear' ORDER BY HeaderID ASC");
        // return $query->result();
    }

}

/* End of file m_monitor.php */
/* Location: ./application/models/m_monitor.php */