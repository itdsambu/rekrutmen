<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_datakaryawan extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->PSGBOR = $this->load->database('PSGBOR', TRUE);
    }

function getDocs($fixno){
    $query = $this->db->query("SELECT berkas.KTP,ro.HeaderID 
                                FROM
                                    [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja AS boro
                                    LEFT JOIN tblTrnCalonTenagaKerja AS ro ON boro.FixNo = ro.Nofix
                                    LEFT JOIN tblTrnBerkas AS berkas ON ro.HeaderID = berkas.HeaderID 
                                WHERE
                                    boro.TanggalKeluar IS NULL AND FixNo = ".$fixno." ");
    return $query->row();
}

function getDocsKaryawan($regno){
    $query = $this->db->query("WITH table1 AS (
                                                SELECT
                                                    a.regno AS ro_regno,
                                                    MAX ( b.HeaderID ) AS HeaderID,
                                                    b.nama AS nama_ro,
                                                    b.NamaBapak AS NamaBapak_ro,
                                                    b.NamaIbuKandung AS NamaIbuKandung_ro,
                                                    b.tempat_lahir AS tempat_lahir_ro,
                                                    b.tgl_lahir AS tgl_lahir_ro,
                                                    b.no_ktp AS ro_ktp 
                                                FROM
                                                    PSGPayroll.dbo.vwDataKaryawanNonFinance AS a
                                                    INNER JOIN tblTrnCalonTenagaKerja AS b ON LTRIM( RTRIM( a.nama ) ) = LTRIM( RTRIM( b.nama ) ) 
                                                WHERE
                                                    UPPER ( a.NamaAyah ) = UPPER ( b.NamaBapak ) 
                                                    AND UPPER ( a.NamaIbuKandung ) = UPPER ( b.NamaIbuKandung ) 
                                                    AND CAST ( a.TGLLAHIR AS DATE ) = CAST ( b.TGL_LAHIR AS DATE ) 
                                                    AND b.Pemborong = 'YAO HSING' 
                                                    AND b.GeneralStatus = 1 
                                                GROUP BY
                                                    a.regno,
                                                    b.nama,
                                                    b.NamaBapak,
                                                    b.NamaIbuKandung,
                                                    b.tempat_lahir,
                                                    b.tgl_lahir,
                                                    b.no_ktp 
                                                ),
                                                table2 AS ( SELECT regno, nama, NamaAyah, NamaIbuKandung, tempatlhr, tgllahir, noktp AS payroll_ktp FROM PSGPayroll.dbo.vwDataKaryawanNonFinance ),
                                                table3 AS ( SELECT BerkasID, HeaderID AS HdrIDBerkas, KTP FROM TblTrnBerkas ) SELECT
                                                HeaderID,KTP 
                                            FROM
                                                table2
                                                LEFT JOIN table1 ON table2.regno = table1.ro_regno
                                                LEFT JOIN table3 ON table1.HeaderID = table3.HdrIDBerkas 
                                            WHERE
                                                regno = ".$regno."");
    return $query->row();
}


// --------------- LIST KTP HARIAN ---------------

function getdept_payboro() {
        $query = $this->db->query("SELECT * FROM [192.168.3.32].PSGBorongan.dbo.tblMstDepartemen ORDER BY DeptAbbr ASC");
        return $query->result();
    }

function countRegisteredTenaker(){
        $query = $this->db->query("SELECT boro.nik FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja AS boro LEFT JOIN tblTrnCalonTenagaKerja AS ro ON boro.FixNo = ro.Nofix
                                   LEFT JOIN tblTrnBerkas AS berkas ON ro.HeaderID = berkas.HeaderID WHERE boro.TanggalKeluar IS NULL AND ro.nofix IS NOT NULL ORDER BY boro.Nama ASC");

        return $query->num_rows();
}

function countRegisteredTenakerWhere($nofix,$dept){
        if ($nofix != '' && $dept != '') {
            $where = "boro.FixNo = ".$nofix." AND boro.IDDepartemen = ".$dept."";
        } else if ($nofix == '' && $dept != '') {
            $where = "boro.IDDepartemen = ".$dept."";
        } else if ($nofix != '' && $dept == '') {
            $where = "boro.FixNo = ".$nofix."";
        } else {
            $where = "";
        }
        $query = $this->db->query("SELECT boro.nik FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja AS boro LEFT JOIN tblTrnCalonTenagaKerja AS ro ON boro.FixNo = ro.Nofix
                                   LEFT JOIN tblTrnBerkas AS berkas ON ro.HeaderID = berkas.HeaderID WHERE boro.TanggalKeluar IS NULL AND ro.nofix IS NOT NULL AND $where ORDER BY boro.Nama ASC");

        return $query->num_rows();
}

function countUnRegisteredTenaker(){
        $query = $this->db->query("SELECT boro.nik FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja AS boro LEFT JOIN tblTrnCalonTenagaKerja AS ro ON boro.FixNo = ro.Nofix
                                   LEFT JOIN tblTrnBerkas AS berkas ON ro.HeaderID = berkas.HeaderID WHERE boro.TanggalKeluar IS NULL AND ro.nofix IS NULL ORDER BY boro.Nama ASC");

        return $query->num_rows();
}

function countUnRegisteredTenakerWhere($nofix,$dept){
        if ($nofix != '' && $dept != '') {
            $where = "boro.FixNo = ".$nofix." AND boro.IDDepartemen = ".$dept."";
        } else if ($nofix == '' && $dept != '') {
            $where = "boro.IDDepartemen = ".$dept."";
        } else if ($nofix != '' && $dept == '') {
            $where = "boro.FixNo = ".$nofix."";
        } else {
            $where = "";
        }

        $query = $this->db->query("SELECT boro.nik FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja AS boro LEFT JOIN tblTrnCalonTenagaKerja AS ro ON boro.FixNo = ro.Nofix
                                   LEFT JOIN tblTrnBerkas AS berkas ON ro.HeaderID = berkas.HeaderID WHERE boro.TanggalKeluar IS NULL AND ro.nofix IS NULL AND $where ORDER BY boro.Nama ASC");

        return $query->num_rows();
}

function countAllTenakerWhere($nofix,$dept){
        if ($nofix != '' && $dept != '') {
            $where = "FixNo = ".$nofix." AND IDDepartemen = ".$dept."";
        } else if ($nofix == '' && $dept != '') {
            $where = "IDDepartemen = ".$dept."";
        } else if ($nofix != '' && $dept == '') {
            $where = "FixNo = ".$nofix."";
        } else {
            $where = "";
        }
        $query = $this->db->query("SELECT Nik FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja WHERE TanggalKeluar IS NULL AND $where ORDER BY Nama ASC");
        return $query->num_rows();
}

function selectAllTenakerKTPWhere($start,$end,$nofix,$dept){
        if ($nofix != '' && $dept != '') {
            $where = "boro.FixNo = ".$nofix." AND boro.IDDepartemen = ".$dept."";
        } else if ($nofix == '' && $dept != '') {
            $where = "boro.IDDepartemen = ".$dept."";
        } else if ($nofix != '' && $dept == '') {
            $where = "boro.FixNo = ".$nofix."";
        } else {
            $where = "";
        }
        $query = $this->db->query("SELECT * FROM (SELECT
                                        ROW_NUMBER() OVER(ORDER BY boro.Nama ASC) AS ROW,boro.FixNo,ro.Nofix,ro.HeaderID,berkas.HeaderID as hdrid_berkas,boro.nama,boro.NamaBapak,boro.NamaIbu,boro.tgllahir,boro.tempatlahir,berkas.KTP,ro.No_Ktp as ro_ktp,boro.NOKTP as boro_ktp,boro.DeptAbbr,boro.IDDepartemen 
                                    FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja as boro LEFT JOIN tblTrnCalonTenagaKerja as ro on boro.FixNo = ro.Nofix LEFT JOIN tblTrnBerkas as berkas on ro.HeaderID = berkas.HeaderID
                                    WHERE
                                        boro.TanggalKeluar IS NULL AND $where) AS A WHERE ROW >= ".$start." AND ROW <= ".$end." ");
        return $query->result();
} 

function selectAllTenakerKTP($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT
                                        ROW_NUMBER() OVER(ORDER BY boro.Nama ASC) AS ROW,boro.FixNo,ro.Nofix,ro.HeaderID,berkas.HeaderID as hdrid_berkas,boro.nama,boro.NamaBapak,boro.NamaIbu,boro.tgllahir,boro.tempatlahir,berkas.KTP,ro.No_Ktp as ro_ktp,boro.NOKTP as boro_ktp,boro.DeptAbbr
                                    FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja as boro LEFT JOIN tblTrnCalonTenagaKerja as ro on boro.FixNo = ro.Nofix LEFT JOIN tblTrnBerkas as berkas on ro.HeaderID = berkas.HeaderID
                                    WHERE
                                        boro.TanggalKeluar IS NULL) AS A WHERE ROW >= ".$start." AND ROW <= ".$end." ");
        return $query->result();
}   
function selectTenakerKTPRegistered($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT
                                        ROW_NUMBER() OVER(ORDER BY boro.Nama ASC) AS ROW,boro.FixNo,ro.Nofix,ro.HeaderID,berkas.HeaderID as hdrid_berkas,boro.nama,boro.NamaBapak,boro.NamaIbu,boro.tgllahir,boro.tempatlahir,berkas.KTP,ro.No_Ktp as ro_ktp,boro.NOKTP as boro_ktp,boro.DeptAbbr
                                    FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja as boro LEFT JOIN tblTrnCalonTenagaKerja as ro on boro.FixNo = ro.Nofix LEFT JOIN tblTrnBerkas as berkas on ro.HeaderID = berkas.HeaderID
                                    WHERE
                                        boro.TanggalKeluar IS NULL AND ro.nofix IS NOT NULL) AS A WHERE ROW >= ".$start." AND ROW <= ".$end." ");
        return $query->result();
} 

function selectTenakerKTPRegisteredWhere($start,$end,$nofix,$dept){
        if ($nofix != '' && $dept != '') {
            $where = "boro.FixNo = ".$nofix." AND boro.IDDepartemen = ".$dept."";
        } else if ($nofix == '' && $dept != '') {
            $where = "boro.IDDepartemen = ".$dept."";
        } else if ($nofix != '' && $dept == '') {
            $where = "boro.FixNo = ".$nofix."";
        } else {
            $where = "";
        }
        $query = $this->db->query("SELECT * FROM (SELECT
                                        ROW_NUMBER() OVER(ORDER BY boro.Nama ASC) AS ROW,boro.FixNo,ro.Nofix,ro.HeaderID,berkas.HeaderID as hdrid_berkas,boro.nama,boro.NamaBapak,boro.NamaIbu,boro.tgllahir,boro.tempatlahir,berkas.KTP,ro.No_Ktp as ro_ktp,boro.NOKTP as boro_ktp,boro.DeptAbbr,boro.IDDepartemen
                                    FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja as boro LEFT JOIN tblTrnCalonTenagaKerja as ro on boro.FixNo = ro.Nofix LEFT JOIN tblTrnBerkas as berkas on ro.HeaderID = berkas.HeaderID
                                    WHERE
                                        boro.TanggalKeluar IS NULL AND ro.nofix IS NOT NULL AND $where) AS A WHERE ROW >= ".$start." AND ROW <= ".$end." ");
        return $query->result();
} 

function selectTenakerKTPUnRegistered($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT
                                        ROW_NUMBER() OVER(ORDER BY boro.Nama ASC) AS ROW,boro.FixNo,ro.Nofix,ro.HeaderID,berkas.HeaderID as hdrid_berkas,boro.nama,boro.NamaBapak,boro.NamaIbu,boro.tgllahir,boro.tempatlahir,berkas.KTP,ro.No_Ktp as ro_ktp,boro.NOKTP as boro_ktp,boro.DeptAbbr
                                    FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja as boro LEFT JOIN tblTrnCalonTenagaKerja as ro on boro.FixNo = ro.Nofix LEFT JOIN tblTrnBerkas as berkas on ro.HeaderID = berkas.HeaderID
                                    WHERE
                                        boro.TanggalKeluar IS NULL AND ro.nofix IS NULL) AS A WHERE ROW >= ".$start." AND ROW <= ".$end." ");
        return $query->result();
} 

 function selectTenakerKTPUnRegisteredWhere($start,$end,$nofix,$dept){
        if ($nofix != '' && $dept != '') {
            $where = "boro.FixNo = ".$nofix." AND boro.IDDepartemen = ".$dept."";
        } else if ($nofix == '' && $dept != '') {
            $where = "boro.IDDepartemen = ".$dept."";
        } else if ($nofix != '' && $dept == '') {
            $where = "boro.FixNo = ".$nofix."";
        } else {
            $where = "";
        }
        $query = $this->db->query("SELECT * FROM (SELECT
                                        ROW_NUMBER() OVER(ORDER BY boro.Nama ASC) AS ROW,boro.FixNo,ro.Nofix,ro.HeaderID,berkas.HeaderID as hdrid_berkas,boro.nama,boro.NamaBapak,boro.NamaIbu,boro.tgllahir,boro.tempatlahir,berkas.KTP,ro.No_Ktp as ro_ktp,boro.NOKTP as boro_ktp,boro.DeptAbbr
                                    FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja as boro LEFT JOIN tblTrnCalonTenagaKerja as ro on boro.FixNo = ro.Nofix LEFT JOIN tblTrnBerkas as berkas on ro.HeaderID = berkas.HeaderID
                                    WHERE
                                        boro.TanggalKeluar IS NULL AND ro.nofix IS NULL AND $where) AS A WHERE ROW >= ".$start." AND ROW <= ".$end." ");
        return $query->result();
}   

function update_db_berkas($hdrid,$berkas,$lokasi){      
    $this->db->trans_start();
    $this->db->where('HeaderID',$hdrid);
    $this->db->update('tblTrnBerkas',array($berkas => $lokasi));
    $this->db->trans_complete();
}   

// --------------- LIST KTP KARYAWAN ---------------

     function getdept_payroll() {
        $query = $this->db->query("SELECT DISTINCT(deptabbr) FROM PSGPayroll.dbo.vwDataKaryawanNonFinance order by deptabbr ASC");
        return $query->result();
    }

    function countKaryawanAktifAll(){
        $query = $this->db->query("SELECT NIK FROM PSGPayroll.dbo.vwDataKaryawanNonFinance ORDER BY NAMA ASC");
        return $query->num_rows();
    }

    function countKaryawanAllAktifWhere($regno,$dept){
        if ($regno != '') {
            $where = "regno = ".$regno." AND DeptAbbr LIKE '%".$dept."%'";
        } else {
            $where = "DeptAbbr LIKE '%".$dept."%'";
        }
        $query = $this->db->query("SELECT NIK FROM PSGPayroll.dbo.vwDataKaryawanNonFinance WHERE $where ORDER BY NAMA ASC");
        return $query->num_rows();
    }

    function countKaryawanRegistered(){
        $query = $this->db->query("WITH table1 AS (
                                                SELECT
                                                    a.regno AS ro_regno,
                                                    MAX ( b.HeaderID ) AS HeaderID,
                                                    b.nama AS nama_ro,
                                                    b.NamaBapak AS NamaBapak_ro,
                                                    b.NamaIbuKandung AS NamaIbuKandung_ro,
                                                    b.tempat_lahir AS tempat_lahir_ro,
                                                    b.tgl_lahir AS tgl_lahir_ro,
                                                    b.no_ktp AS ro_ktp 
                                                FROM
                                                    PSGPayroll.dbo.vwDataKaryawanNonFinance AS a
                                                    INNER JOIN tblTrnCalonTenagaKerja AS b ON LTRIM( RTRIM( a.nama ) ) = LTRIM( RTRIM( b.nama ) ) 
                                                WHERE
                                                    UPPER ( a.NamaAyah ) = UPPER ( b.NamaBapak ) 
                                                    AND UPPER ( a.NamaIbuKandung ) = UPPER ( b.NamaIbuKandung ) 
                                                    AND CAST ( a.TGLLAHIR AS DATE ) = CAST ( b.TGL_LAHIR AS DATE ) 
                                                    AND b.Pemborong = 'YAO HSING' 
                                                    AND b.GeneralStatus = 1 
                                                GROUP BY
                                                    a.regno,
                                                    b.nama,
                                                    b.NamaBapak,
                                                    b.NamaIbuKandung,
                                                    b.tempat_lahir,
                                                    b.tgl_lahir,
                                                    b.no_ktp 
                                                ),
                                                table2 AS ( SELECT regno, nama, NamaAyah, NamaIbuKandung, tempatlhr, tgllahir, noktp AS payroll_ktp FROM PSGPayroll.dbo.vwDataKaryawanNonFinance ),
                                                table3 AS ( SELECT BerkasID, HeaderID AS HdrIDBerkas, KTP FROM TblTrnBerkas ) SELECT
                                                regno 
                                            FROM
                                                table2
                                                LEFT JOIN table1 ON table2.regno = table1.ro_regno
                                                LEFT JOIN table3 ON table1.HeaderID = table3.HdrIDBerkas 
                                            WHERE
                                                HeaderID IS NOT NULL");
        return $query->num_rows();
    }

    function countKaryawanRegisteredWhere($regno,$dept){
        if ($regno != '') {
            $where = "regno = ".$regno." AND DeptAbbr LIKE '%".$dept."%'";
        } else {
            $where = "DeptAbbr LIKE '%".$dept."%'";
        }
        $query = $this->db->query("WITH table1 AS (
                                                SELECT
                                                    a.regno AS ro_regno,
                                                    MAX ( b.HeaderID ) AS HeaderID,
                                                    b.nama AS nama_ro,
                                                    b.NamaBapak AS NamaBapak_ro,
                                                    b.NamaIbuKandung AS NamaIbuKandung_ro,
                                                    b.tempat_lahir AS tempat_lahir_ro,
                                                    b.tgl_lahir AS tgl_lahir_ro,
                                                    b.no_ktp AS ro_ktp 
                                                FROM
                                                    PSGPayroll.dbo.vwDataKaryawanNonFinance AS a
                                                    INNER JOIN tblTrnCalonTenagaKerja AS b ON LTRIM( RTRIM( a.nama ) ) = LTRIM( RTRIM( b.nama ) ) 
                                                WHERE
                                                    UPPER ( a.NamaAyah ) = UPPER ( b.NamaBapak ) 
                                                    AND UPPER ( a.NamaIbuKandung ) = UPPER ( b.NamaIbuKandung ) 
                                                    AND CAST ( a.TGLLAHIR AS DATE ) = CAST ( b.TGL_LAHIR AS DATE ) 
                                                    AND b.Pemborong = 'YAO HSING' 
                                                    AND b.GeneralStatus = 1 
                                                GROUP BY
                                                    a.regno,
                                                    b.nama,
                                                    b.NamaBapak,
                                                    b.NamaIbuKandung,
                                                    b.tempat_lahir,
                                                    b.tgl_lahir,
                                                    b.no_ktp 
                                                ),
                                                table2 AS ( SELECT regno, DeptAbbr, nama, NamaAyah, NamaIbuKandung, tempatlhr, tgllahir, noktp AS payroll_ktp FROM PSGPayroll.dbo.vwDataKaryawanNonFinance ),
                                                table3 AS ( SELECT BerkasID, HeaderID AS HdrIDBerkas, KTP FROM TblTrnBerkas ) SELECT
                                                regno 
                                            FROM
                                                table2
                                                LEFT JOIN table1 ON table2.regno = table1.ro_regno
                                                LEFT JOIN table3 ON table1.HeaderID = table3.HdrIDBerkas 
                                            WHERE
                                                HeaderID IS NOT NULL AND $where");
        return $query->num_rows();
    }

    function countKaryawanUnRegistered(){
        $query = $this->db->query("WITH table1 AS (
                                                SELECT
                                                    a.regno AS ro_regno,
                                                    MAX ( b.HeaderID ) AS HeaderID,
                                                    b.nama AS nama_ro,
                                                    b.NamaBapak AS NamaBapak_ro,
                                                    b.NamaIbuKandung AS NamaIbuKandung_ro,
                                                    b.tempat_lahir AS tempat_lahir_ro,
                                                    b.tgl_lahir AS tgl_lahir_ro,
                                                    b.no_ktp AS ro_ktp 
                                                FROM
                                                    PSGPayroll.dbo.vwDataKaryawanNonFinance AS a
                                                    INNER JOIN tblTrnCalonTenagaKerja AS b ON LTRIM( RTRIM( a.nama ) ) = LTRIM( RTRIM( b.nama ) ) 
                                                WHERE
                                                    UPPER ( a.NamaAyah ) = UPPER ( b.NamaBapak ) 
                                                    AND UPPER ( a.NamaIbuKandung ) = UPPER ( b.NamaIbuKandung ) 
                                                    AND CAST ( a.TGLLAHIR AS DATE ) = CAST ( b.TGL_LAHIR AS DATE ) 
                                                    AND b.Pemborong = 'YAO HSING' 
                                                    AND b.GeneralStatus = 1 
                                                GROUP BY
                                                    a.regno,
                                                    b.nama,
                                                    b.NamaBapak,
                                                    b.NamaIbuKandung,
                                                    b.tempat_lahir,
                                                    b.tgl_lahir,
                                                    b.no_ktp 
                                                ),
                                                table2 AS ( SELECT regno, nama, NamaAyah, NamaIbuKandung, tempatlhr, tgllahir, noktp AS payroll_ktp FROM PSGPayroll.dbo.vwDataKaryawanNonFinance ),
                                                table3 AS ( SELECT BerkasID, HeaderID AS HdrIDBerkas, KTP FROM TblTrnBerkas ) SELECT
                                                regno 
                                            FROM
                                                table2
                                                LEFT JOIN table1 ON table2.regno = table1.ro_regno
                                                LEFT JOIN table3 ON table1.HeaderID = table3.HdrIDBerkas 
                                            WHERE
                                                HeaderID IS NULL");
        return $query->num_rows();
    }

    function countKaryawanUnRegisteredWhere($regno,$dept){
        if ($regno != '') {
            $where = "regno = ".$regno." AND DeptAbbr LIKE '%".$dept."%'";
        } else {
            $where = "DeptAbbr LIKE '%".$dept."%'";
        }
        $query = $this->db->query("WITH table1 AS (
                                                SELECT
                                                    a.regno AS ro_regno,
                                                    MAX ( b.HeaderID ) AS HeaderID,
                                                    b.nama AS nama_ro,
                                                    b.NamaBapak AS NamaBapak_ro,
                                                    b.NamaIbuKandung AS NamaIbuKandung_ro,
                                                    b.tempat_lahir AS tempat_lahir_ro,
                                                    b.tgl_lahir AS tgl_lahir_ro,
                                                    b.no_ktp AS ro_ktp 
                                                FROM
                                                    PSGPayroll.dbo.vwDataKaryawanNonFinance AS a
                                                    INNER JOIN tblTrnCalonTenagaKerja AS b ON LTRIM( RTRIM( a.nama ) ) = LTRIM( RTRIM( b.nama ) ) 
                                                WHERE
                                                    UPPER ( a.NamaAyah ) = UPPER ( b.NamaBapak ) 
                                                    AND UPPER ( a.NamaIbuKandung ) = UPPER ( b.NamaIbuKandung ) 
                                                    AND CAST ( a.TGLLAHIR AS DATE ) = CAST ( b.TGL_LAHIR AS DATE ) 
                                                    AND b.Pemborong = 'YAO HSING' 
                                                    AND b.GeneralStatus = 1 
                                                GROUP BY
                                                    a.regno,
                                                    b.nama,
                                                    b.NamaBapak,
                                                    b.NamaIbuKandung,
                                                    b.tempat_lahir,
                                                    b.tgl_lahir,
                                                    b.no_ktp 
                                                ),
                                                table2 AS ( SELECT regno, DeptAbbr, nama, NamaAyah, NamaIbuKandung, tempatlhr, tgllahir, noktp AS payroll_ktp FROM PSGPayroll.dbo.vwDataKaryawanNonFinance ),
                                                table3 AS ( SELECT BerkasID, HeaderID AS HdrIDBerkas, KTP FROM TblTrnBerkas ) SELECT
                                                regno 
                                            FROM
                                                table2
                                                LEFT JOIN table1 ON table2.regno = table1.ro_regno
                                                LEFT JOIN table3 ON table1.HeaderID = table3.HdrIDBerkas 
                                            WHERE
                                                HeaderID IS NULL AND $where");
        return $query->num_rows();
    }

    function selectKTPAllKaryawan($start,$end){
        $query = $this->db->query("WITH table1 AS (
                                            SELECT
                                                a.regno AS ro_regno,
                                                MAX ( b.HeaderID ) AS HeaderID,
                                                b.nama AS nama_ro,
                                                b.NamaBapak AS NamaBapak_ro,
                                                b.NamaIbuKandung AS NamaIbuKandung_ro,
                                                b.tempat_lahir AS tempat_lahir_ro,
                                                b.tgl_lahir AS tgl_lahir_ro,
                                                b.no_ktp AS ro_ktp 
                                            FROM
                                                PSGPayroll.dbo.vwDataKaryawanNonFinance AS a
                                                INNER JOIN tblTrnCalonTenagaKerja AS b ON LTRIM( RTRIM( a.nama ) ) = LTRIM( RTRIM( b.nama ) ) 
                                            WHERE
                                                UPPER ( a.NamaAyah ) = UPPER ( b.NamaBapak ) 
                                                AND UPPER ( a.NamaIbuKandung ) = UPPER ( b.NamaIbuKandung ) 
                                                AND CAST ( a.TGLLAHIR AS DATE ) = CAST ( b.TGL_LAHIR AS DATE ) 
                                                AND b.Pemborong = 'YAO HSING' 
                                                AND b.GeneralStatus = 1 
                                            GROUP BY
                                                a.regno,
                                                b.nama,
                                                b.NamaBapak,
                                                b.NamaIbuKandung,
                                                b.tempat_lahir,
                                                b.tgl_lahir,
                                                b.no_ktp 
                                            ),
                                            table2 AS ( SELECT regno, deptabbr, nama, NamaAyah, NamaIbuKandung, tempatlhr, tgllahir, noktp AS payroll_ktp FROM PSGPayroll.dbo.vwDataKaryawanNonFinance ),
                                            table3 AS ( SELECT BerkasID, HeaderID AS HdrIDBerkas, KTP FROM TblTrnBerkas ) SELECT
                                            * 
                                        FROM
                                            (
                                            SELECT
                                                ROW_NUMBER ( ) OVER ( ORDER BY table2.nama ASC ) AS ROW,* 
                                            FROM
                                                table2
                                                LEFT JOIN table1 ON table2.regno = table1.ro_regno
                                                LEFT JOIN table3 ON table1.HeaderID = table3.HdrIDBerkas 
                                            ) AS A 
                                        WHERE
                                            ROW >= ".$start." 
                                            AND ROW <= ".$end."");
        return $query->result();
}   

function selectKTPAllKaryawanWhere($start,$end,$regno,$dept){
        if ($regno != '') {
            $where = "regno = ".$regno." AND DeptAbbr LIKE '%".$dept."%'";
        } else {
            $where = "DeptAbbr LIKE '%".$dept."%'";
        }
        $query = $this->db->query("WITH table1 AS (
                                            SELECT
                                                a.regno AS ro_regno,
                                                MAX ( b.HeaderID ) AS HeaderID,
                                                b.nama AS nama_ro,
                                                b.NamaBapak AS NamaBapak_ro,
                                                b.NamaIbuKandung AS NamaIbuKandung_ro,
                                                b.tempat_lahir AS tempat_lahir_ro,
                                                b.tgl_lahir AS tgl_lahir_ro,
                                                b.no_ktp AS ro_ktp 
                                            FROM
                                                PSGPayroll.dbo.vwDataKaryawanNonFinance AS a
                                                INNER JOIN tblTrnCalonTenagaKerja AS b ON LTRIM( RTRIM( a.nama ) ) = LTRIM( RTRIM( b.nama ) ) 
                                            WHERE
                                                UPPER ( a.NamaAyah ) = UPPER ( b.NamaBapak ) 
                                                AND UPPER ( a.NamaIbuKandung ) = UPPER ( b.NamaIbuKandung ) 
                                                AND CAST ( a.TGLLAHIR AS DATE ) = CAST ( b.TGL_LAHIR AS DATE ) 
                                                AND b.Pemborong = 'YAO HSING' 
                                                AND b.GeneralStatus = 1 
                                            GROUP BY
                                                a.regno,
                                                b.nama,
                                                b.NamaBapak,
                                                b.NamaIbuKandung,
                                                b.tempat_lahir,
                                                b.tgl_lahir,
                                                b.no_ktp 
                                            ),
                                            table2 AS ( SELECT regno, deptabbr, nama, NamaAyah, NamaIbuKandung, tempatlhr, tgllahir, noktp AS payroll_ktp FROM PSGPayroll.dbo.vwDataKaryawanNonFinance ),
                                            table3 AS ( SELECT BerkasID, HeaderID AS HdrIDBerkas, KTP FROM TblTrnBerkas ) SELECT
                                            * 
                                        FROM
                                            (
                                            SELECT
                                                ROW_NUMBER ( ) OVER ( ORDER BY table2.nama ASC ) AS ROW,* 
                                            FROM
                                                table2
                                                LEFT JOIN table1 ON table2.regno = table1.ro_regno
                                                LEFT JOIN table3 ON table1.HeaderID = table3.HdrIDBerkas
                                                WHERE $where
                                            ) AS A 
                                        WHERE
                                            ROW >= ".$start." 
                                            AND ROW <= ".$end."");
        return $query->result();
}

function selectKTPRegisteredKaryawan($start,$end){
        $query = $this->db->query("WITH table1 AS (
                                            SELECT
                                                a.regno AS ro_regno,
                                                MAX ( b.HeaderID ) AS HeaderID,
                                                b.nama AS nama_ro,
                                                b.NamaBapak AS NamaBapak_ro,
                                                b.NamaIbuKandung AS NamaIbuKandung_ro,
                                                b.tempat_lahir AS tempat_lahir_ro,
                                                b.tgl_lahir AS tgl_lahir_ro,
                                                b.no_ktp AS ro_ktp 
                                            FROM
                                                PSGPayroll.dbo.vwDataKaryawanNonFinance AS a
                                                INNER JOIN tblTrnCalonTenagaKerja AS b ON LTRIM( RTRIM( a.nama ) ) = LTRIM( RTRIM( b.nama ) ) 
                                            WHERE
                                                UPPER ( a.NamaAyah ) = UPPER ( b.NamaBapak ) 
                                                AND UPPER ( a.NamaIbuKandung ) = UPPER ( b.NamaIbuKandung ) 
                                                AND CAST ( a.TGLLAHIR AS DATE ) = CAST ( b.TGL_LAHIR AS DATE ) 
                                                AND b.Pemborong = 'YAO HSING' 
                                                AND b.GeneralStatus = 1 
                                            GROUP BY
                                                a.regno,
                                                b.nama,
                                                b.NamaBapak,
                                                b.NamaIbuKandung,
                                                b.tempat_lahir,
                                                b.tgl_lahir,
                                                b.no_ktp 
                                            ),
                                            table2 AS ( SELECT regno, deptabbr, nama, NamaAyah, NamaIbuKandung, tempatlhr, tgllahir, noktp AS payroll_ktp FROM PSGPayroll.dbo.vwDataKaryawanNonFinance ),
                                            table3 AS ( SELECT BerkasID, HeaderID AS HdrIDBerkas, KTP FROM TblTrnBerkas ) SELECT
                                            * 
                                        FROM
                                            (
                                            SELECT
                                                ROW_NUMBER ( ) OVER ( ORDER BY table2.nama ASC ) AS ROW,* 
                                            FROM
                                                table2
                                                LEFT JOIN table1 ON table2.regno = table1.ro_regno
                                                LEFT JOIN table3 ON table1.HeaderID = table3.HdrIDBerkas 
                                                WHERE HeaderID IS NOT NULL
                                            ) AS A 
                                        WHERE
                                            ROW >= ".$start." 
                                            AND ROW <= ".$end."");
        return $query->result();
} 

function selectKTPRegisteredKaryawanWhere($start,$end,$regno,$dept){
        if ($regno != '') {
                $where = "regno = ".$regno." AND DeptAbbr LIKE '%".$dept."%'";
            } else {
                $where = "DeptAbbr LIKE '%".$dept."%'";
            }
        $query = $this->db->query("WITH table1 AS (
                                            SELECT
                                                a.regno AS ro_regno,
                                                MAX ( b.HeaderID ) AS HeaderID,
                                                b.nama AS nama_ro,
                                                b.NamaBapak AS NamaBapak_ro,
                                                b.NamaIbuKandung AS NamaIbuKandung_ro,
                                                b.tempat_lahir AS tempat_lahir_ro,
                                                b.tgl_lahir AS tgl_lahir_ro,
                                                b.no_ktp AS ro_ktp 
                                            FROM
                                                PSGPayroll.dbo.vwDataKaryawanNonFinance AS a
                                                INNER JOIN tblTrnCalonTenagaKerja AS b ON LTRIM( RTRIM( a.nama ) ) = LTRIM( RTRIM( b.nama ) ) 
                                            WHERE
                                                UPPER ( a.NamaAyah ) = UPPER ( b.NamaBapak ) 
                                                AND UPPER ( a.NamaIbuKandung ) = UPPER ( b.NamaIbuKandung ) 
                                                AND CAST ( a.TGLLAHIR AS DATE ) = CAST ( b.TGL_LAHIR AS DATE ) 
                                                AND b.Pemborong = 'YAO HSING' 
                                                AND b.GeneralStatus = 1 
                                            GROUP BY
                                                a.regno,
                                                b.nama,
                                                b.NamaBapak,
                                                b.NamaIbuKandung,
                                                b.tempat_lahir,
                                                b.tgl_lahir,
                                                b.no_ktp 
                                            ),
                                            table2 AS ( SELECT regno, deptabbr, nama, NamaAyah, NamaIbuKandung, tempatlhr, tgllahir, noktp AS payroll_ktp FROM PSGPayroll.dbo.vwDataKaryawanNonFinance ),
                                            table3 AS ( SELECT BerkasID, HeaderID AS HdrIDBerkas, KTP FROM TblTrnBerkas ) SELECT
                                            * 
                                        FROM
                                            (
                                            SELECT
                                                ROW_NUMBER ( ) OVER ( ORDER BY table2.nama ASC ) AS ROW,* 
                                            FROM
                                                table2
                                                LEFT JOIN table1 ON table2.regno = table1.ro_regno
                                                LEFT JOIN table3 ON table1.HeaderID = table3.HdrIDBerkas 
                                                WHERE HeaderID IS NOT NULL AND $where
                                            ) AS A 
                                        WHERE
                                            ROW >= ".$start." 
                                            AND ROW <= ".$end."");
        return $query->result();
}   

function selectKTPUnRegisteredKaryawan($start,$end){
        $query = $this->db->query("WITH table1 AS (
                                            SELECT
                                                a.regno AS ro_regno,
                                                MAX ( b.HeaderID ) AS HeaderID,
                                                b.nama AS nama_ro,
                                                b.NamaBapak AS NamaBapak_ro,
                                                b.NamaIbuKandung AS NamaIbuKandung_ro,
                                                b.tempat_lahir AS tempat_lahir_ro,
                                                b.tgl_lahir AS tgl_lahir_ro,
                                                b.no_ktp AS ro_ktp 
                                            FROM
                                                PSGPayroll.dbo.vwDataKaryawanNonFinance AS a
                                                INNER JOIN tblTrnCalonTenagaKerja AS b ON LTRIM( RTRIM( a.nama ) ) = LTRIM( RTRIM( b.nama ) ) 
                                            WHERE
                                                UPPER ( a.NamaAyah ) = UPPER ( b.NamaBapak ) 
                                                AND UPPER ( a.NamaIbuKandung ) = UPPER ( b.NamaIbuKandung ) 
                                                AND CAST ( a.TGLLAHIR AS DATE ) = CAST ( b.TGL_LAHIR AS DATE ) 
                                                AND b.Pemborong = 'YAO HSING' 
                                                AND b.GeneralStatus = 1 
                                            GROUP BY
                                                a.regno,
                                                b.nama,
                                                b.NamaBapak,
                                                b.NamaIbuKandung,
                                                b.tempat_lahir,
                                                b.tgl_lahir,
                                                b.no_ktp 
                                            ),
                                            table2 AS ( SELECT regno, deptabbr, nama, NamaAyah, NamaIbuKandung, tempatlhr, tgllahir, noktp AS payroll_ktp FROM PSGPayroll.dbo.vwDataKaryawanNonFinance ),
                                            table3 AS ( SELECT BerkasID, HeaderID AS HdrIDBerkas, KTP FROM TblTrnBerkas ) SELECT
                                            * 
                                        FROM
                                            (
                                            SELECT
                                                ROW_NUMBER ( ) OVER ( ORDER BY table2.nama ASC ) AS ROW,* 
                                            FROM
                                                table2
                                                LEFT JOIN table1 ON table2.regno = table1.ro_regno
                                                LEFT JOIN table3 ON table1.HeaderID = table3.HdrIDBerkas 
                                                WHERE HeaderID IS NULL
                                            ) AS A 
                                        WHERE
                                            ROW >= ".$start." 
                                            AND ROW <= ".$end."");
        return $query->result();
}   

function selectKTPUnRegisteredKaryawanWhere($start,$end,$regno,$dept){
        if ($regno != '') {
                $where = "regno = ".$regno." AND DeptAbbr LIKE '%".$dept."%'";
            } else {
                $where = "DeptAbbr LIKE '%".$dept."%'";
            }
        $query = $this->db->query("WITH table1 AS (
                                            SELECT
                                                a.regno AS ro_regno,
                                                MAX ( b.HeaderID ) AS HeaderID,
                                                b.nama AS nama_ro,
                                                b.NamaBapak AS NamaBapak_ro,
                                                b.NamaIbuKandung AS NamaIbuKandung_ro,
                                                b.tempat_lahir AS tempat_lahir_ro,
                                                b.tgl_lahir AS tgl_lahir_ro,
                                                b.no_ktp AS ro_ktp 
                                            FROM
                                                PSGPayroll.dbo.vwDataKaryawanNonFinance AS a
                                                INNER JOIN tblTrnCalonTenagaKerja AS b ON LTRIM( RTRIM( a.nama ) ) = LTRIM( RTRIM( b.nama ) ) 
                                            WHERE
                                                UPPER ( a.NamaAyah ) = UPPER ( b.NamaBapak ) 
                                                AND UPPER ( a.NamaIbuKandung ) = UPPER ( b.NamaIbuKandung ) 
                                                AND CAST ( a.TGLLAHIR AS DATE ) = CAST ( b.TGL_LAHIR AS DATE ) 
                                                AND b.Pemborong = 'YAO HSING' 
                                                AND b.GeneralStatus = 1 
                                            GROUP BY
                                                a.regno,
                                                b.nama,
                                                b.NamaBapak,
                                                b.NamaIbuKandung,
                                                b.tempat_lahir,
                                                b.tgl_lahir,
                                                b.no_ktp 
                                            ),
                                            table2 AS ( SELECT regno, deptabbr, nama, NamaAyah, NamaIbuKandung, tempatlhr, tgllahir, noktp AS payroll_ktp FROM PSGPayroll.dbo.vwDataKaryawanNonFinance ),
                                            table3 AS ( SELECT BerkasID, HeaderID AS HdrIDBerkas, KTP FROM TblTrnBerkas ) SELECT
                                            * 
                                        FROM
                                            (
                                            SELECT
                                                ROW_NUMBER ( ) OVER ( ORDER BY table2.nama ASC ) AS ROW,* 
                                            FROM
                                                table2
                                                LEFT JOIN table1 ON table2.regno = table1.ro_regno
                                                LEFT JOIN table3 ON table1.HeaderID = table3.HdrIDBerkas 
                                                WHERE HeaderID IS NULL AND $where
                                            ) AS A 
                                        WHERE
                                            ROW >= ".$start." 
                                            AND ROW <= ".$end."");
        return $query->result();
}  
// --------------- KARYAWAN ---------------

    function countAllKaryawan(){
        $query = $this->db->query("SELECT NIK FROM PSGPayroll.dbo.vwDataKaryawanNonFinanceAll WHERE TGLKELUAR IS NULL ORDER BY NAMA ASC");
        return $query->num_rows();
    }

    function countPriaKaryawan(){
        $query = $this->db->query("SELECT NIK FROM PSGPayroll.dbo.vwDataKaryawanNonFinanceAll WHERE TGLKELUAR IS NULL AND Sex='L' ORDER BY NAMA ASC");
        return $query->num_rows();
    }

    function countWanitaKaryawan(){
        $query = $this->db->query("SELECT NIK FROM PSGPayroll.dbo.vwDataKaryawanNonFinanceAll WHERE TGLKELUAR IS NULL AND Sex='P' ORDER BY NAMA ASC");
        return $query->num_rows();
    }

    function selectAllKaryawan($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY NAMA ASC) AS ROW, * FROM PSGPayroll.dbo.vwDataKaryawanNonFinanceAll WHERE TGLKELUAR IS NULL) vwDataKaryawanNonFinanceAll WHERE ROW >= ".$start." AND ROW <= ".$end." ");
        return $query->result();
    }

    function selectAllKaryawanNama($cari){
        $query = $this->db->query("SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY NAMA ASC) AS ROW, * FROM PSGPayroll.dbo.vwDataKaryawanNonFinanceAll WHERE TGLKELUAR IS NULL) vwDataKaryawanNonFinanceAll WHERE Nama like '%$cari%'");
        return $query->result();
    }

    function selectPriaKaryawan($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY NAMA ASC) AS ROW, * FROM PSGPayroll.dbo.vwDataKaryawanNonFinanceAll WHERE TGLKELUAR IS NULL AND Sex='L') vwDataKaryawanNonFinanceAll WHERE ROW >= ".$start." AND ROW <= ".$end." ");
        return $query->result();
    }
    function selectWanitaKaryawan($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY NAMA ASC) AS ROW, * FROM PSGPayroll.dbo.vwDataKaryawanNonFinanceAll WHERE TGLKELUAR IS NULL AND Sex='P') vwDataKaryawanNonFinanceAll WHERE ROW >= ".$start." AND ROW <= ".$end." ");
        return $query->result();
    }
	
// --------------- HARIAN ---------------
    function countAllTenaker(){
        $query = $this->db->query("SELECT Nik FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja WHERE TanggalKeluar IS NULL ORDER BY Nama ASC");
        return $query->num_rows();
    }

    function countPriaTenaker(){
        $query = $this->db->query("SELECT Nik FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja WHERE TanggalKeluar IS NULL AND IDJenisKelamin='L' ORDER BY Nama ASC");
        return $query->num_rows();
    }

    function countWanitaTenaker(){
        $query = $this->db->query("SELECT Nik FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja WHERE TanggalKeluar IS NULL AND IDJenisKelamin='P' ORDER BY Nama ASC");
        return $query->num_rows();
    }

    function selectAllTenaker($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY Nama ASC) AS ROW, * FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja) vwMstTenagaKerja WHERE ROW >= ".$start." AND ROW <= ".$end." ");
        return $query->result();
    }

    function selectPriaTenaker($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY Nama ASC) AS ROW, * FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja WHERE TanggalKeluar IS NULL AND IDJenisKelamin='L') vwMstTenagaKerja WHERE ROW >= ".$start." AND ROW <= ".$end." ");
        return $query->result();
    }

    function selectWanitaTenaker($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY Nama ASC) AS ROW, * FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja WHERE TanggalKeluar IS NULL AND IDJenisKelamin='P') vwMstTenagaKerja WHERE ROW >= ".$start." AND ROW <= ".$end." ");
        return $query->result();
    }
	
	function get_detailtk($nik){
        return $this->PSGBOR->get_where('vwMstTenagaKerja',array('Nik'=>$nik));
    }
	
	function get_detailk($nik){
        return $this->db->get_where('PSGPayroll.dbo.vwDataKaryawanNonFinanceAll',array('NIK'=>$nik));
    }
	
	function getResultK($nik){
        $query = $this->db->query("SELECT * FROM PSGPayroll.dbo.vwDataKaryawanNonFinanceAll WHERE Nik ='".$nik."'");
        return $query->result();
    }
	
	function getResultTK($nik){
        $query = $this->db->query("SELECT * FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja WHERE Nik ='".$nik."'");
        return $query->result();
    }
}