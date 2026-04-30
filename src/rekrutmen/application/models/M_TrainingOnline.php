<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_TrainingOnline extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
        $this->PSGKlinik = $this->load->database('PSGKlinik', TRUE);
    }

    public function getCalonTenagaKerja($id_register)
    {
        $query = $this->db->query("SELECT * FROM PSGRekrutmen..tblTrnCalonTenagaKerja WHERE HeaderID = '$id_register'");
        return $query->row();
    }

    function _getTenagaKerjaKaryawan($nik, $deptid)
    {
        // $query = $this->db->query("SELECT * FROM PSGTrainingOnline..vwTrnPerson where TglKeluar is null and NIKPayroll = '$nik' and DeptID = '$deptid'");
        $query = $this->db->query("SELECT * FROM PSGTrainingOnline..vwtrnlatihperson where TglKeluar is null and NIK = '$nik' and DeptID = '$deptid'");
        $query2 = $this->PSGKlinik->query("SELECT
                                            A.*,
                                            B.jabatan_nama 
                                            FROM
                                            PSGTrainingOnline..vwtrnlatihperson A
                                            LEFT JOIN [PSGKlinik].[dbo].[vw_sambupedia_all_pekerja_aktif] B ON A.RegnoFixNo = B.personalid
                                            WHERE
                                            TglKeluar IS NULL 
                                            AND A.NIK = '$nik' 
                                            AND A.DeptID = '$deptid'");
        return $query->row();
        // return $query2->row();
    }

    function _getTenagaKerjaKaryawan_elc($nik_id)
    {
        $query = $this->db->query("SELECT * FROM PSGTrainingOnline..vwTrnPersonOptimized where TglKeluar is null and NIKPayroll = '$nik_id'");
        return $query->row();
    }

    function _getTenagaKerjaHarian($nik)
    {
        $query = $this->db->query("SELECT * FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja  as a join PSGTrainingOnline..vwMasterDepartemenAktif as b on a.IDBagian = b.IDDeptPayBoro where Nik = '$nik' AND TanggalKeluar is null");
        return $query->row();
    }

    function _getDept($id_dept)
    {
        $query = $this->db->query("SELECT DeptID,DeptAbbr,Nama FROM PSGTrainingOnline..vwloaddeptnew where DeptID = '$id_dept' order by DeptAbbr");
        return $query->result();
    }

    function _getMateri($materi, $id_dept, $idHdrSoal)
    {
        $query = $this->db->query("SELECT a.IKPMateriDtl,JudulMateri,b.DeptID,c.IdMstSoalHdr,c.KategoriMateri from PSGTrainingOnline..tblTrnMateriDtl a join PSGTrainingOnline..tblTrnMateriHdr b on a.IKPMateriHdr=b.IKPMateriHdr left join PSGTrainingOnline..tblMstSoalHdr  c on a.IKPMateriDtl = c.IKPMateriDtl where a.IKPMateriDtl ='$materi' and b.DeptID='$id_dept' and c.IdMstSoalHdr='$idHdrSoal' And c.Hapus=0");
        return $query->result();
    }

    function _getSoal($HdrSoal)
    {
        $query = $this->db->query("SELECT * from PSGTrainingOnline..tblMstSoalHdr as A left join PSGTrainingOnline..tblMstSoal as B ON A.IdMstSoalHdr = B.IdMstSoalHdr WHERE b.IdMstSoalHdr  = '$HdrSoal'");
        return $query->result();
    }
    function _getSoalAwal($HdrSoal, $hdrid_jawaban)
    {
        $query = $this->db->query("SELECT A.*,C.DetailID,B.* from PSGTrainingOnline..tblMstSoalHdr as A left join PSGTrainingOnline..tblMstSoal as B ON A.IdMstSoalHdr = B.IdMstSoalHdr left join PSGTrainingOnline..tblTrnJawabanDtl as C ON B.IDSoal = C.IDSoal WHERE b.IdMstSoalHdr  = '$HdrSoal' and HeaderID = '$hdrid_jawaban'");
        return $query->result();
    }

    function _getJawaban($IDSoal = NULL)
    {
        if ($IDSoal) {
            $con = "WHERE A.IDSoal = '$IDSoal'";
        } else {
            $con = '';
        }
        // ini_set('memory_limit', '512M'); // atau lebih tinggi jika diperlukan
        $query = $this->db->query("SELECT A.IDSoalObjectif,A.IDObjectif,A.Objectif,B.NamaObjektif,A.IDSoal,A.Link,A.ID FROM PSGTrainingOnline..tblMstSoalDtl as A left join PSGTrainingOnline..tblMstSoalObjektif as B ON A.IDObjectif = B.IDObjektif $con");
        return $query->result();
    }

    function getWaktu($HdrSoal)
    {
        $query = $this->db->query("SELECT WaktuPublish,SettingWaktu,CreatedDate,IdMstSoalHdr FROM PSGTrainingOnline..tblMstSoalHdr where idMstSoalHdr = '$HdrSoal'");
        return $query->result();
    }

    //function cek nofix dan materi yang sama

    function cekNofix($Nofix, $hdrSoal)
    {
        // Query lama
        // $query = $this->db->query("SELECT COUNT(RegFix) as nofix  from PSGTrainingOnline..tblTrnJawabanHdr where RegFix ='$Nofix'  and IDMstSoalHdr= '$hdrSoal'");
        // Query baru
        $query = $this->db->query("SELECT COUNT(RegFix) as nofix  from PSGTrainingOnline..vwTrnJawabanHdrelc where RegFix ='$Nofix'  and IDMstSoalHdr= '$hdrSoal' and Nilai is not null and remedial = 0");
        return $query->row();
    }

    // function cekNofix($Nofix, $hdrSoal)
    // {
    //     // OPTIMIZED VERSION:
    //     // 1. Query langsung ke base table (bukan view)
    //     // 2. Prepared statement (anti SQL injection + plan caching)
    //     // 3. TOP 3 + COUNT - stop scan setelah ketemu 3 row (early termination)

    //     $sql = "SELECT COUNT(*) AS nofix 
    //             FROM (
    //                 SELECT TOP 3 RegFix 
    //                 FROM PSGTrainingOnline..tblTrnJawabanHdr 
    //                 WHERE RegFix = ? 
    //                 AND IDMstSoalHdr = ? 
    //                 AND Nilai IS NOT NULL 
    //                 AND remedial = 0
    //             ) AS t";

    //     $query = $this->db->query($sql, array($Nofix, $hdrSoal));
    //     return $query->row();
    // }

    function cekHeaderID($id_register, $hdrSoal)
    {
        $query = $this->db->query("SELECT COUNT(RegFix) as nofix  from PSGTrainingOnline..tblTrnJawabanHdr where IDNonTK ='$id_register'  and IDMstSoalHdr= '$hdrSoal'");
        return $query->row();
    }

    // Simpan

    function simpanHdr($dataHdr)
    {
        $this->db->insert('PSGTrainingOnline..tblTrnJawabanHdr', $dataHdr);
        $primary_key = $this->db->insert_id();
        return $primary_key;
    }

    function simpanDtl($dataDtl)
    {
        $this->db->insert('PSGTrainingOnline..tblTrnJawabanDtl', $dataDtl);
        $primary_key = $this->db->insert_id();
        return $primary_key;
    }

    function updateDtl($dtlid, $dataDtl)
    {
        $this->db->where('DetailID', $dtlid);
        $this->db->update('PSGTrainingOnline..tblTrnJawabanDtl', $dataDtl);
    }

    function UpdateHdr($hdrid_jawaban, $dataHdr)
    {
        $this->db->where('HeaderID', $hdrid_jawaban);
        $this->db->update('PSGTrainingOnline..tblTrnJawabanHdr', $dataHdr);
    }

    // BEGIN HASIL TRAINING ONLINE 
    function _getTenagaKerjaHasilK($hdrid, $type)
    {
        $query = $this->db->query("SELECT A.*,B.Nik,B.Nama,B.Departemen as dept,B.Jabatan,C.NamaDept as DeptTraining,C.NamaMateri,C.JenisSoal,C.SettingWaktu FROM (SELECT * FROM PSGTrainingOnline..tblTrnJawabanHdr where Status= '$type') as A left join PSGTrainingOnline..vwTrnPerson as B ON A.RegFix = B.RegNo
			left join PSGTrainingOnline..tblMstSoalHdr as C ON A.IKPMateriDtl = C.IKPMateriDtl
			where A.HeaderID = '$hdrid' And c.Hapus=0 And c.Hapus=0");
        return $query->result();
    }

    public function _getNonTenagaKerjaHasil($hdrid)
    {
        $query = $this->db->query(
            "SELECT
				A.*,
				B.Nik,
				B.Nama,
				B.Departemen AS dept,
				B.Jabatan,
				C.NamaDept AS DeptTraining,
				C.NamaMateri,
				C.JenisSoal,
				C.SettingWaktu 
			FROM
				( SELECT * FROM PSGTrainingOnline..tblTrnJawabanHdr) AS A
				LEFT JOIN PSGTrainingOnline..vwTrnPerson AS B ON A.RegFix = B.RegNo
				LEFT JOIN PSGTrainingOnline..tblMstSoalHdr AS C ON A.IKPMateriDtl = C.IKPMateriDtl 
			WHERE
				A.HeaderID = '$hdrid'
				AND c.Hapus= 0 
				AND c.Hapus=0"
        );
        return $query->result();
    }

    function _getTenagaKerjaHasilH_old($hdrid, $type)
    {
        $query = $this->db->query("SELECT A.*,B.Nik,B.Nama,B.Bagian as dept,C.NamaDept as DeptTraining,C.NamaMateri,C.JenisSoal,C.SettingWaktu,B.Jabatan FROM (SELECT * FROM PSGTrainingOnline..tblTrnJawabanHdr where Status= '$type') as A left join [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja as B ON A.RegFix = B.Nofix
		left join PSGTrainingOnline..tblMstSoalHdr as C ON A.IKPMateriDtl = C.IKPMateriDtl
		where A.HeaderID = '$hdrid' And c.Hapus=0 And c.Hapus=0");
        return $query->result();
    }

    function _getTenagaKerjaHasilH($hdrid, $type)
    {
        $query = $this->db->query(
            "SELECT
				A.*,
				B.Nik,
				B.Nama,
				B.BagianAbbr AS dept,
				C.NamaDept AS DeptTraining,
				C.NamaMateri,
				C.JenisSoal,
				C.SettingWaktu,
				B.Jabatan 
			FROM
				( SELECT * FROM PSGTrainingOnline..tblTrnJawabanHdr WHERE Status = '$type' ) AS A
				LEFT JOIN [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja AS B ON A.RegFix = B.FixNo
				LEFT JOIN PSGTrainingOnline..tblMstSoalHdr AS C ON A.IKPMateriDtl = C.IKPMateriDtl 
			WHERE
				A.HeaderID = '$hdrid'
				AND c.Hapus= 0"
        );
        return $query->result();
    }

    function _getJawabanBenar($hdrid)
    {
        $query = $this->db->query("SELECT * FROM PSGTrainingOnline..vwTrnJawabanDtl where HeaderID = '$hdrid' ");
        return $query->result();
    }

    function UnikSoal($id)
    {
        $query = $this->db->query("SELECT * FROM PSGTrainingOnline..tblMstLinkSoal where IDL = '$id'");
        return $query->row();
    }

    function MasterRuangMeting()
    {
        $query = $this->db->query("SELECT * FROM PSGTrainingOnline..tblMstRuangMeeting");

        return $query->result();
    }

    public function getIdRegisterTkb($HeaderID, $DeptTujuan)
    {
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE HeaderID = '$HeaderID' AND DeptTujuan = '$DeptTujuan'");

        return $query->result();
    }


    public function getMstKategoriMateri($status_tk)
    {
        $query = $this->db->query("SELECT * FROM PSGTrainingOnline..tblMstSoalHdr WHERE KategoriMateri = '$status_tk' ORDER BY IdMstSoalHdr");

        return $query->result();
    }

    public function getMstKategoriMateri_tk()
    {
        $query = $this->db->query("SELECT * FROM PSGTrainingOnline..tblMstSoalHdr WHERE KategoriMateri = '1' ORDER BY IdMstSoalHdr");

        return $query->result();
    }

    public function getMstKategoriMateri_nonTK()
    {
        $query = $this->db->query("SELECT * FROM PSGTrainingOnline..tblMstSoalHdr WHERE KategoriMateri = '2' ORDER BY IdMstSoalHdr");

        return $query->result();
    }

    // END HASIL TRAINING ONLINE
}
