<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class M_Pra_pelamar extends CI_Model{

	function simpan($data){ 
		// $this->db->insert('tblTrnPraPelamar',$data);
		$this->db->insert('tblTrnPraPelamar',$data);
		$primay_key = $this->db->insert_id();
		return $primay_key;
	}

	function get_dataPraPelamar(){
		$bulan1 = date('m') - 1;
        $bulan = date('m');
        $tahun1 = date('Y') -1;
        $tahun2 = date('Y');
        $groupid = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT A.*,B.HeaderID,B.Status_Personal,C.tglMedical,C.rapid_test_ket,datediff(YEAR,Tanggal_Lahir,GETDATE()) as umur,D.TanggalMasuk as TanggalMasukHarian,E.TGLMASUK,K.Status_kedatangan,L.DeletedBy FROM vwTrnPraPelamarNew A 
                                    left join tblTrnCalonTenagaKerja as B ON A.Pra_PelamarID = B.Pra_PelamarID 
                                    left join TblMntInterview as K on B.IDInterview = K.IDInterview
                                    left join tblTrnCalonKandidatNew as L on K.CalonPElamarID = L.CalonPelamarID
                                    left join (SELECT * FROM RSUPPayroll..tbl_kk_MstMedicalTemporaryTKNew) as C ON B.HeaderID = C.HeaderID 
                                    left join vwTanggalEfektifMasukKerjaBorongan as D ON B.HeaderID = D.RequestID
                                    left join vwTanggalMasukKaryawan as E ON B.HeaderID = E.HeaderID
                                    where A.IDPemborong IN (SELECT DISTINCT PemborongID FROM tblUtlGroupPemborong WHERE GroupID = '$groupid' ) and (Status_kedatangan != 2  or Status_kedatangan is null)
                                     and DeletedBy is null and (StatusAktif != 0 or StatusAktif is null)
                                    and  YEAR(A.CreatedDate) = '$tahun2' and (MONTH(A.CreatedDate) = '$bulan1' OR MONTH(A.CreatedDate) = '$bulan')  ORDER BY A.Pra_PelamarID DESC");
        return $query->result();
	}

    function get_dataPraPelamarupload(){
        $groupid = $this->session->userdata('groupuser');
        $thn_sekarang = date('Y');
        $tahun_sebelum = date('Y') -1;
        $query = $this->db->query("SELECT A.*,B.HeaderID,C.tglMedical,C.rapid_test_ket,datediff(YEAR,Tanggal_Lahir,GETDATE()) as umur,D.TanggalMasuk as TanggalMasukHarian,E.TGLMASUK FROM vwTrnPraPelamarNew A left join tblTrnCalonTenagaKerja as B ON A.Pra_PelamarID = B.Pra_PelamarID left join (SELECT * FROM RSUPPayroll..tbl_kk_MstMedicalTemporaryTKNew) as C ON B.HeaderID = C.HeaderID left join vwTanggalEfektifMasukKerjaBorongan as D ON B.HeaderID = D.RequestID left join vwTanggalMasukKaryawan as E ON B.HeaderID = E.HeaderID where A.IDPemborong IN (SELECT DISTINCT PemborongID FROM tblUtlGroupPemborong WHERE GroupID = '$groupid' ) and YEAR(A.CreatedDate) = '$thn_sekarang' ORDER BY A.Pra_PelamarID DESC");
        return $query->result();
    }

    function get_datapertanggalkarantina($tgl_awal,$tgl_akhir){
        $query = $this->db->query("SELECT A.*,B.HeaderID,B.Status_Personal,B.Verified,B.VerifiedBy,B.VerifiedDate,C.tglMedical,C.rapid_test_ket,datediff(YEAR,Tanggal_Lahir,GETDATE()) as umur,D.TanggalMasuk as TanggalMasukHarian,E.TGLMASUK FROM vwTrnPraPelamarNew A left join tblTrnCalonTenagaKerja as B ON A.Pra_PelamarID = B.Pra_PelamarID left join (SELECT * FROM RSUPPayroll..tbl_kk_MstMedicalTemporaryTKNew) as C ON B.HeaderID = C.HeaderID  left join vwTanggalEfektifMasukKerjaBorongan as D ON B.HeaderID = D.RequestID left join vwTanggalMasukKaryawan as E ON B.HeaderID = E.HeaderID where A.IDPemborong IN (SELECT DISTINCT PemborongID FROM tblUtlGroupPemborong WHERE GroupID = '1' ) and CONVERT(date,A.TglMulaiKrantina) >='$tgl_awal' and CONVERT(DATE,A.TglMulaiKrantina) <= '$tgl_akhir' ORDER BY A.Pra_PelamarID DESC");
        return $query->result();
    }

     function get_dataPraPelamarbyRange($tgl_awal,$tgl_akhir,$pbr){
        $groupid =  $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT A.*,B.HeaderID,B.Status_Personal,B.Verified,B.VerifiedBy,B.VerifiedDate,C.tglMedical,C.rapid_test_ket,datediff(YEAR,Tanggal_Lahir,GETDATE()) as umur,D.TanggalMasuk as TanggalMasukHarian,E.TGLMASUK FROM vwTrnPraPelamarNew A left join tblTrnCalonTenagaKerja as B ON A.Pra_PelamarID = B.Pra_PelamarID left join (SELECT * FROM RSUPPayroll..tbl_kk_MstMedicalTemporaryTKNew) as C ON B.HeaderID = C.HeaderID left join vwTanggalEfektifMasukKerjaBorongan as D ON B.HeaderID = D.RequestID left join vwTanggalMasukKaryawan as E ON B.HeaderID = E.HeaderID where A.IDPemborong IN (SELECT DISTINCT PemborongID FROM tblUtlGroupPemborong WHERE GroupID = '$groupid' ) and CONVERT(date,A.CreatedDate) >='$tgl_awal' and CONVERT(DATE,A.CreatedDate) <= '$tgl_akhir' and A.IDPemborong  ='$pbr' ORDER BY A.Pra_PelamarID DESC ");
        return $query->result();
    }

    function get_dataPraPelamarRangeAll($tgl_awal,$tgl_akhir){
        $groupid =  $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT A.*,B.HeaderID,B.Status_Personal,B.Verified,B.VerifiedBy,B.VerifiedDate,C.tglMedical,C.rapid_test_ket,datediff(YEAR,Tanggal_Lahir,GETDATE()) as umur,D.TanggalMasuk as TanggalMasukHarian,E.TGLMASUK FROM vwTrnPraPelamarNew A left join tblTrnCalonTenagaKerja as B ON A.Pra_PelamarID = B.Pra_PelamarID left join (SELECT * FROM RSUPPayroll..tbl_kk_MstMedicalTemporaryTKNew) as C ON B.HeaderID = C.HeaderID left join vwTanggalEfektifMasukKerjaBorongan as D ON B.HeaderID = D.RequestID left join vwTanggalMasukKaryawan as E ON B.HeaderID = E.HeaderID where A.IDPemborong IN (SELECT DISTINCT PemborongID FROM tblUtlGroupPemborong WHERE GroupID = '$groupid' ) and CONVERT(date,A.CreatedDate) >='$tgl_awal' and CONVERT(DATE,A.CreatedDate) <= '$tgl_akhir' ORDER BY A.Pra_PelamarID DESC ");
        return $query->result();
    }

	function get_dataSudahKarantinaPerTanggal($tanggal){
        $bulan = date('m',strtotime($tanggal));
        $tahun = date('Y',strtotime($tanggal));
        $query = $this->db->query("SELECT A.*,C.BerkasPraID,C.KTP,C.KTPVerifed,C.KTPVerifedBy,C.KTPVerifedDate,C.KartuKeluarga,C.KartuKeluargaVerifed,C.KartuKeluargaVerifedDate,C.KartuKeluargaVerifedBy,C.SuratSehat,C.SuratSehatVerifed,C.SuratSehatVerifedBy,C.SuratSehatVerifedDate,C.Domisili,C.DomisiliVerifed,C.DomisiliVerifedBy,C.DomisiliVerifedDate,C.SuratGugusCovid,C.GugusCovidVerifed,C.GugusCovidVerifedBy,C.GugusCovidVerifedDate FROM (SELECT *, DATEADD(DAY,-14,'$tanggal') as TglAkhir FROM vwTrnPraPelamar) as A left join tblTrnBerkasPra as C ON A.Pra_PelamarID = C.Pra_PelamarID where A.TglMulaiKrantina BETWEEN A.TglAkhir AND '$tanggal' and A.Alamat_Karantina IS NOT NULL AND A.MulaiKarantina = '1' ORDER BY A.TglMulaiKrantina ASC");
        return $query->result();
    }

    function get_dataSudahKarantinaPerRange($tgl_awal,$tgl_akhir){
        $query = $this->db->query("SELECT * FROM vwTrnPraPelamarNew where Tanggal_Kedatangan IS NOt NULL and Alamat_Karantina IS NOT NULL and MulaiKarantina = '1' and CONVERT(DATE,TglMulaiKrantina) >= '$tgl_awal' and CONVERT(DATE,TglMulaiKrantina) <= '$tgl_akhir' ORDER BY TglMulaiKrantina ASC");
        return $query->result();
    }

    function get_dataBelumKarantinaPerRange($tgl_awal,$tgl_akhir){
        $query = $this->db->query("SELECT * FROM vwTrnPraPelamarNew where CONVERT(DATE,CreatedDate) >= '$tgl_awal' and CONVERT(DATE,CreatedDate) <= '$tgl_akhir' and (Tanggal_Kedatangan = '1900-01-01' OR Tanggal_Kedatangan is null)");
        return $query->result();
    }

    function get_tanggalceksuhu($tanggal){
        $query = $this->db->query("DECLARE @TglKarantina as date='$tanggal'
                SELECT distinct X.Tanggal as Tanggal 
                from
                (SELECT @TglKarantina as Tanggal union
                select DATEADD(d,-1,@TglKarantina) union
                select DATEADD(d,-2,@TglKarantina) union
                select DATEADD(d,-3,@TglKarantina) union
                select DATEADD(d,-4,@TglKarantina) union
                select DATEADD(d,-5,@TglKarantina) union
                select DATEADD(d,-6,@TglKarantina) union
                select DATEADD(d,-7,@TglKarantina) union
                select DATEADD(d,-8,@TglKarantina) union
                select DATEADD(d,-9,@TglKarantina) union
                select DATEADD(d,-10,@TglKarantina) union
                select DATEADD(d,-11,@TglKarantina) union
                select DATEADD(d,-12,@TglKarantina) union
                select DATEADD(d,-13,@TglKarantina)) as X left outer join
                vwTrnPraPelamarNew as Y on day(X.Tanggal)=day(Y.TglMulaiKrantina) and month(X.Tanggal)=month(Y.TglMulaiKrantina) and year(X.Tanggal)=year(Y.TglMulaiKrantina)");
        return $query->result();
    }
    function get_suhu($tanggal){
        $query = $this->db->query("Declare @TglKarantina as date='$tanggal'
            select distinct X.Tanggal as Tanggal,
            DATEADD(d,-13,@TglKarantina) as Tgl_suhu_1, (select suhu from tblTrnCekSuhuNew where Pra_PelamarID = y.Pra_PelamarID and Tanggal = DATEADD(d,-13,@TglKarantina)) as suhu_1,
            DATEADD(d,-12,@TglKarantina) as Tgl_suhu_2, (select suhu from tblTrnCekSuhuNew where Pra_PelamarID = y.Pra_PelamarID and Tanggal = DATEADD(d,-12,@TglKarantina)) as suhu_2,
            DATEADD(d,-11,@TglKarantina) as Tgl_suhu_3, (select suhu from tblTrnCekSuhuNew where Pra_PelamarID = y.Pra_PelamarID and Tanggal = DATEADD(d,-11,@TglKarantina)) as suhu_3,
            DATEADD(d,-10,@TglKarantina) as Tgl_suhu_4, (select suhu from tblTrnCekSuhuNew where Pra_PelamarID = y.Pra_PelamarID and Tanggal = DATEADD(d,-10,@TglKarantina)) as suhu_4,
            DATEADD(d,-9,@TglKarantina) as Tgl_suhu_5, (select suhu from tblTrnCekSuhuNew where Pra_PelamarID = y.Pra_PelamarID and Tanggal = DATEADD(d,-9,@TglKarantina)) as suhu_5,
            DATEADD(d,-8,@TglKarantina) as Tgl_suhu_6, (select suhu from tblTrnCekSuhuNew where Pra_PelamarID = y.Pra_PelamarID and Tanggal = DATEADD(d,-8,@TglKarantina)) as suhu_6,
            DATEADD(d,-7,@TglKarantina) as Tgl_suhu_7, (select suhu from tblTrnCekSuhuNew where Pra_PelamarID = y.Pra_PelamarID and Tanggal = DATEADD(d,-7,@TglKarantina)) as suhu_7,
            DATEADD(d,-6,@TglKarantina) as Tgl_suhu_8, (select suhu from tblTrnCekSuhuNew where Pra_PelamarID = y.Pra_PelamarID and Tanggal = DATEADD(d,-6,@TglKarantina)) as suhu_8,
            DATEADD(d,-5,@TglKarantina) as Tgl_suhu_9, (select suhu from tblTrnCekSuhuNew where Pra_PelamarID = y.Pra_PelamarID and Tanggal = DATEADD(d,-5,@TglKarantina)) as suhu_9,
            DATEADD(d,-4,@TglKarantina) as Tgl_suhu_10, (select suhu from tblTrnCekSuhuNew where Pra_PelamarID = y.Pra_PelamarID and Tanggal = DATEADD(d,-4,@TglKarantina)) as suhu_10,
            DATEADD(d,-3,@TglKarantina) as Tgl_suhu_11, (select suhu from tblTrnCekSuhuNew where Pra_PelamarID = y.Pra_PelamarID and Tanggal = DATEADD(d,-3,@TglKarantina)) as suhu_11,
            DATEADD(d,-2,@TglKarantina) as Tgl_suhu_12, (select suhu from tblTrnCekSuhuNew where Pra_PelamarID = y.Pra_PelamarID and Tanggal = DATEADD(d,-2,@TglKarantina)) as suhu_12,
            DATEADD(d,-1,@TglKarantina) as Tgl_suhu_13, (select suhu from tblTrnCekSuhuNew where Pra_PelamarID = y.Pra_PelamarID and Tanggal = DATEADD(d,-1,@TglKarantina)) as suhu_13,
            DATEADD(d,-0,@TglKarantina) as Tgl_suhu_14, (select suhu from tblTrnCekSuhuNew where Pra_PelamarID = y.Pra_PelamarID and Tanggal = DATEADD(d,-1,@TglKarantina)) as suhu_14,
            Y.Pra_PelamarID,Y.Nama_Lengkap,Y.Pemborong,Y.TglMulaiKrantina,Y.TglMedical,Y.TglSelesaiKarantina,Y.Alamat_Karantina
            from
            (select @TglKarantina as Tanggal union
            select DATEADD(d,-1,@TglKarantina) union
            select DATEADD(d,-2,@TglKarantina) union
            select DATEADD(d,-3,@TglKarantina) union
            select DATEADD(d,-4,@TglKarantina) union
            select DATEADD(d,-5,@TglKarantina) union
            select DATEADD(d,-6,@TglKarantina) union
            select DATEADD(d,-7,@TglKarantina) union
            select DATEADD(d,-8,@TglKarantina) union
            select DATEADD(d,-9,@TglKarantina) union
            select DATEADD(d,-10,@TglKarantina) union
            select DATEADD(d,-11,@TglKarantina) union
            select DATEADD(d,-12,@TglKarantina) union
            select DATEADD(d,-13,@TglKarantina)) as X left outer join
            vwTrnPraPelamarNew as Y on day(X.Tanggal)=day(Y.TglMulaiKrantina) and month(X.Tanggal)=month(Y.TglMulaiKrantina) and year(X.Tanggal)=year(Y.TglMulaiKrantina) left outer join
            tblTrnCekSuhuNew as Z on y.Pra_PelamarID = z.Pra_PelamarID 
            where Y.Pra_PelamarID IS NOT NULL order by y.TglMulaiKrantina asc");
        return $query->result();
    }

    function get_tanggal($tanggal){
        $query = $this->db->query("Declare @TglKarantina as date='$tanggal'
            select distinct DATEADD(d,-13,@TglKarantina) as Tgl_suhu_1,
            DATEADD(d,-12,@TglKarantina) as Tgl_suhu_2,
            DATEADD(d,-11,@TglKarantina) as Tgl_suhu_3, 
            DATEADD(d,-10,@TglKarantina) as Tgl_suhu_4,
            DATEADD(d,-9,@TglKarantina) as Tgl_suhu_5,
            DATEADD(d,-8,@TglKarantina) as Tgl_suhu_6,
            DATEADD(d,-7,@TglKarantina) as Tgl_suhu_7,
            DATEADD(d,-6,@TglKarantina) as Tgl_suhu_8,
            DATEADD(d,-5,@TglKarantina) as Tgl_suhu_9,
            DATEADD(d,-4,@TglKarantina) as Tgl_suhu_10,
            DATEADD(d,-3,@TglKarantina) as Tgl_suhu_11,
            DATEADD(d,-2,@TglKarantina) as Tgl_suhu_12,
            DATEADD(d,-1,@TglKarantina) as Tgl_suhu_13,
            DATEADD(d,-0,@TglKarantina) as Tgl_suhu_14
            from
            (select @TglKarantina as Tanggal union
            select DATEADD(d,-1,@TglKarantina) union
            select DATEADD(d,-2,@TglKarantina) union
            select DATEADD(d,-3,@TglKarantina) union
            select DATEADD(d,-4,@TglKarantina) union
            select DATEADD(d,-5,@TglKarantina) union
            select DATEADD(d,-6,@TglKarantina) union
            select DATEADD(d,-7,@TglKarantina) union
            select DATEADD(d,-8,@TglKarantina) union
            select DATEADD(d,-9,@TglKarantina) union
            select DATEADD(d,-10,@TglKarantina) union
            select DATEADD(d,-11,@TglKarantina) union
            select DATEADD(d,-12,@TglKarantina) union
            select DATEADD(d,-13,@TglKarantina)) as X left outer join
            vwTrnPraPelamarNew as Y on day(X.Tanggal)=day(Y.TglMulaiKrantina) and month(X.Tanggal)=month(Y.TglMulaiKrantina) and year(X.Tanggal)=year(Y.TglMulaiKrantina) left outer join
            tblTrnCekSuhuNew as Z on y.Pra_PelamarID = z.Pra_PelamarID 
            where Y.Pra_PelamarID IS NOT NULL ");
        return $query->result();
    }

    function get_dataCekSuhu($tgl_mulai){
        $query = $this->db->query("SELECT A.*,DATEDIFF(DD,A.TglMulaiKrantina,A.TglSelesaiKarantina) as Jumlah,B.Pemborong,C.HariKeSatu_1,C.HariKeSatu_2,C.HariKeDua_1,C.HariKeDua_2,C.HariKeTiga_1,C.HariKeTiga_2,C.HariKeEmpat_1,C.HariKeEmpat_2,C.HariKeLima_1,C.HariKeLima_2,C.HariKeEnam_1,C.HariKeEnam_2,C.HariKeTujuh_1,C.HariKeTujuh_2,C.HariKeDelapan_1,C.HariKeDelapan_2,C.HariKeSembilan_1,C.HariKeSembilan_2,C.HariKeSepuluh_1,C.HariKeSepuluh_2,C.HariKeSebelas_1,C.HariKeSebelas_2,C.HariKeDuabelas_1,C.HariKeDuabelas_2,C.HariKeTigabelas_1,C.HariKeTigabelas_2,C.HariKeEmpatbelas_1,C.HariKeEmpatbelas_2 FROM vwTrnPraPelamar as A left join vwMstPemborong as B ON A.IDPemborong = B.IDPemborong left join tblTrnCekSuhu as C ON A.Pra_PelamarID = C.Pra_PelamarID where A.TglMulaiKrantina = '$tgl_mulai'");
        return $query->result();
    }

    function get_datapertanggal($bulan,$tahun){
        $query = $this->db->query("SELECT A.TargetID,A.Tanggal,A.Target,B.Total FROM (SELECT * FROM  tblTrnTargetPraPelamar where MONTH(Tanggal) = '$bulan' and YEAR(Tanggal) = '$tahun') as A left join (SELECT CONVERT(DATE,TglMulaiKrantina) as Tanggal,COUNT(Pra_PelamarID) as Total  FROM vwTrnPraPelamarNew where MONTH(TglMulaiKrantina) = '$bulan' and YEAR(TglMulaiKrantina) = '$tahun'and Komplit = '1' GROUP BY CONVERT(DATE,TglMulaiKrantina)) as B ON A.Tanggal = B.Tanggal");
        return $query->result();
    }

    function get_datatanggal($bulan,$tahun){
        $query = $this->db->query("SELECT TglMulaiKrantina,COUNT(Pra_PelamarID) as Total FROM vwTrnPraPelamar where MONTH(TglMulaiKrantina) = '$bulan' and YEAR(TglMulaiKrantina) = '$tahun' GROUP BY tglMulaiKrantina");
        return $query->result();
    }

    function getStatusKawin(){
        $query = $this->db->get('tblMstStatusKawin');
        return $query->result();
    }

    function cek_dataceksuhu($id){
        $query = $this->db->query("SELECT Pra_PelamarID FROM tblTrnCekSuhu where Pra_PelamarID = '$id'");
        return $query->num_rows();
    }

     function cek_tanggalkedatangan($nama_lengkap,$nama_ibukandung,$tanggal_lahir){
        $query = $this->db->query("SELECT * FROM tblTrnPraPelamar where Nama_Lengkap = '$nama_lengkap' and Nama_Ibu_Kandung = '$nama_ibukandung' and Tanggal_Lahir = '$tanggal_lahir'");
        return $query->result();
    }

    function cek_tenagakerja_aktif($nama_lengkap,$nama_ibukandung,$tanggal_lahir){
        $query = $this->db->query("SELECT A.*,B.RequestID,B.TanggalKeluar,B.TanggalKeluarTemporary,DATEDIFF(MONTH,B.TanggalKeluar,GETDATE()) as RentangWaktuKeluar,B.Blacklist,B.BlacklistDuaBulan,B.ketKeluar FROM tblTrnCalonTenagaKerja as A left join RSUPBorongan2010..tblMstTenagaKerja as b ON A.HeaderID = B.RequestID where A.Pemborong not in ('RSUP') and A.Pra_PelamarID is not null and A.NamaIbuKandung = '$nama_ibukandung' and A.Nama = '$nama_lengkap' and A.Tgl_Lahir = '$tanggal_lahir' ORDER BY A.HeaderID asc");
        return $query->result();
    }

	function cek_dataPraPelamar($nama_lengkap,$nama_ibukandung,$tanggal_lahir){
		$query = $this->db->query("SELECT TOP (1) *,DATEDIFF(MONTH,CreatedDate,GETDATE()) as RentangWaktuReg ,DATEDIFF(MONTH,Tanggal_Kedatangan,CONVERT(DATE,(GETDATE()))) AS RentangWaktuKedatangan FROM tblTrnPraPelamar where Nama_Lengkap = '$nama_lengkap' and Nama_Ibu_Kandung = '$nama_ibukandung' and Tanggal_Lahir = '$tanggal_lahir' order by Pra_PelamarID desc");
		return $query->result();
	}

	function get_pemborong(){
		$groupid = $this->session->userdata('groupuser');
		$query  = $this->db->query("SELECT * FROM tblUtlGroupPemborong as A left join vwMstPemborong as B ON A.PemborongID = B.IDPemborong where GroupID = '$groupid'");
		return $query->result();
	}

	function get_berkas($pra_pelamarid){
		$query = $this->db->query("SELECT * FROM tblTrnBerkasPra where Pra_PelamarID = '$pra_pelamarid'");
		return $query->result();
	}

	function get_minimalberkas($pra_pelamarid){
        $minimalberkas = 0;
        $query = $this->db->query("SELECT * FROM tblTrnBerkasPra where Pra_PelamarID = '$pra_pelamarid' and KTP is not null and KartuKeluarga is not null and Foto is not null");
        if ($query->num_rows() > 0){
            $minimalberkas=1;
        }
        return $minimalberkas;
    }

	function update_db_berkas($hdrid,$berkas,$lokasi){		
        $this->db->trans_start();
        $this->db->where('Pra_PelamarID',$hdrid);
        $this->db->update('tblTrnBerkasPra',array($berkas => $lokasi));
        $this->db->trans_complete();
    }

    function getDocs($userID){
        $query = $this->db->query("SELECT * FROM tblTrnBerkasPra WHERE Pra_PelamarID='".$userID."'");
        return $query->result();
    }

    function get_pelamar_by_id($id){
        $query = $this->db->query("SELECT A.*,B.Pemborong,C.BerkasPraID,C.KTP,C.KTPVerifed,C.KTPVerifedBy,C.KTPVerifedDate,C.KartuKeluarga,C.KartuKeluargaVerifed,C.KartuKeluargaVerifedDate,C.KartuKeluargaVerifedBy,C.SuratSehat,C.SuratSehatVerifed,C.SuratSehatVerifedBy,C.SuratSehatVerifedDate,C.Domisili,C.DomisiliVerifed,C.DomisiliVerifedBy,C.DomisiliVerifedDate,C.SuratGugusCovid,C.GugusCovidVerifed,C.GugusCovidVerifedBy,C.GugusCovidVerifedDate,A.InfoKePmh_Kantin,A.MulaiKarantina ,D.HeaderID,C.Vaksin,C.VaksinVerifed,C.VaksinVerifedBy,C.VaksinVerifedDate,C.Foto,C.FotoVerifed,C.FotoVerifedBy,C.FotoVerifedDate
            FROM tblTrnPraPelamar as A left join vwMstPemborong as B ON A.IDPemborong = B.IDPemborong left join tblTrnBerkasPra as C ON a.Pra_PelamarID = C.Pra_PelamarID 
            left join tblTrnCalonTenagaKerja as D ON A.Pra_PelamarID = D.Pra_PelamarID WHERE A.Pra_PelamarID='".$id."'");
        return $query->result();
    }

    function update($id,$data){
    	$this->db->where('Pra_PelamarID',$id);
    	$this->db->update('tblTrnPraPelamar',$data);
    }

    function update_registrasi($hdrid,$data_regcalon){
        $this->db->where("HeaderID",$hdrid);
        $this->db->update('tblTrnCalonTenagaKerja',$data_regcalon);
    }

    function cek_pra($id){
    	$query = $this->db->query("SELECT A.*,B.Pemborong FROM tblTrnPraPelamar as A left join vwMstPemborong as B ON A.IDPemborong = B.IDPemborong where A.Pra_PelamarID='".$id."'");
        return $query->result();
    }

    function get_dataK($nama,$tgllahir,$namaibu){
    	$query = $this->db->query("SELECT A.*,B.NamaIbuKandung FROM RSUPPayroll.dbo.vwDataKaryawanNonFinanceAll as a left join tblTrnCalonTenagaKerja as B ON A.RegNo = B.Nofix where Pemborong IN ('RSUP') and A.NAMA = '$nama' and CONVERT(DATE,A.TGLLAHIR) = '$tgllahir' and B.NamaIbuKandung = '$namaibu'");
        return $query->result();
    }
    function cek_blacklistK($nama,$tgllahir,$namaibu){
        $query = $this->db->query("SELECT A.*,B.NamaIbuKandung FROM RSUPPayroll.dbo.vwDataKaryawanNonFinanceAll as a left join tblTrnCalonTenagaKerja as B ON A.RegNo = B.Nofix where Pemborong IN ('RSUP') and A.NAMA = '$nama' and CONVERT(DATE,A.TGLLAHIR) = '$tgllahir' and B.NamaIbuKandung = '$namaibu' and Blacklist='1'");
        return $query->result();
    }

    function get_dataTK($nama,$tgllahir,$namaibu){
    	$query = $this->db->query("SELECT * FROM RSUPBorongan2010..vwMasterTenagaKerja where Nama='$nama' and CONVERT(DATE,TanggalLahir) = '$tgllahir' and NamaIbuKandung = '$namaibu'");
        return $query->result();
    }

    function cek_blacklistTK($nama,$tgllahir,$namaibu){
        $query = $this->db->query("SELECT * FROM RSUPBorongan2010..vwMasterTenagaKerja where Nama='$nama' and CONVERT(DATE,TanggalLahir) = '$tgllahir' and NamaIbuKandung = '$namaibu' and Blacklist = '1'");
        return $query->result();
    }

    function cek_blacklistTKDuaBulan($nama,$tgllahir,$namaibu){
        $query = $this->db->query("SELECT * FROM RSUPBorongan2010..vwMasterTenagaKerja where Nama='$nama' and CONVERT(DATE,TanggalLahir) = '$tgllahir' and NamaIbuKandung = '$namaibu' and BlacklistDuaBulan = '1'");
        return $query->result();
    }

    function get_catatan($id){
    	$query = $this->db->query("SELECT * FROM tblTrnPraPelamar where Pra_PelamarID = '$id'");
        return $query->result();
    }

    function update_berkas($id,$data){
        $this->db->where('Pra_PelamarID',$id);
        $this->db->update('tblTrnBerkasPra',$data);
    }

    function simpanBerkas($dataBerkas){
        $this->db->insert('tblTrnBerkasPra',$dataBerkas);
    }

    function cek_berkas($id){
        $query = $this->db->query("SELECT * FROM tblTrnBerkasPra where Pra_PelamarID = '$id'");
        return $query->result();
    }
    function getMstPemborong(){
        $query = $this->db->query("SELECT * FROM vwMstPemborong");
        return $query->result();
    }

    function inputlistceksuhu($data){
        $this->db->insert('tblTrnCekSuhu',$data);
        $hdrid = $this->db->insert_id();
        return $hdrid;
    }

    function get_mess(){
        $query = $this->db->query("SELECT * FROM vwMstMess ORDER BY Alamat_Mess ASC");
        return $query->result();
    }

    function update_inputlistceksuhu($id,$data){
        $this->db->where('Pra_PelamarID',$id);
        $this->db->update('tblTrnCekSuhu',$data);
    }

    function get_idcalontenagakerja($id){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja where HeaderID like '%$id%'");
        return $query->result();
    }

    function updatecalonid($calonid,$data){
        $this->db->where("HeaderID",$calonid);
        $this->db->update("tblTrnCalonTenagaKerja",$data);
    }

    function simpan_target($data){
        $this->db->insert('tblTrnTargetPraPelamar',$data);
    }

    function get_pendidikan(){
        $query = $this->db->query("SELECT * from tblMstPendidikan");
        return $query->result();
    }
    function get_jurusan(){
        $query = $this->db->query("SELECT * from tblMstJurusan");
        return $query->result();
    }

    function get_target($bulan,$tahun){
        $query = $this->db->query("SELECT * from tblTrnTargetPraPelamar where MONTH(Tanggal) = '$bulan' and YEAR(Tanggal) = '$tahun'");
        return $query->result();
    }

    function update_target($id,$data){
        $this->db->where("TargetID",$id);
        $this->db->update("tblTrnTargetPraPelamar",$data);
    }

    function cek($bulan,$tahun){
       $query = $this->db->query("SELECT * from tblTrnTargetPraPelamar where YEAR(Tanggal) = '$tahun' AND MONTH(Tanggal) = '$bulan'");
        return $query->result(); 
    }

    function cek_target($id){
        $query = $this->db->query("SELECT TargetID,Target from tblTrnTargetPraPelamar where TargetID = '$id'");
        return $query->result();
    }

    function simpan_history($data2){
        $this->db->insert('tblTrnHistoryTarget',$data2);
    }

    function cek_tenagakerja($id){
        $query = $this->db->query("SELECT * from tblTrnCalonTenagaKerja where Pra_PelamarID = '$id'");
        return $query->result();
    }

    function delete_medical($registerid){
       $query = $this->db->query("DELETE tbl_kk_ListpendaftaranMedical where IDregKary = '$registerid'");
        return $query->result();
    }

    function simpan_history_prapelamar($dataHistory){
        $this->db->insert('tblHistoryPraPelamar',$dataHistory);
    }

    function cek_pra_pelamar($id){
        $query = $this->db->query("SELECT * FROM tblTrnPraPelamar where Pra_PelamarID = '$id'");
        return $query->result();
    }

    // AMBIL DATA DARI CALON PELAMAR KARYAWAN

    function _getCalonPelamar($id){
        $query = $this->db->query("SELECT * FROM vwCalonKandidat where CalonPelamarID = '".$id."'");
        return $query->result();
    }

    ////////Modul pra karantina////////


    function simpan_kuota($data)
    {
        $this->db->insert('tblTrnPraKarantina',$data);
    }

    function simpan_namaTKB($data)
    {
        $this->db->insert('tblTrnPraKarantina_detail',$data);
    }

    function update_kuota($id,$data){
        $this->db->where('ID',$id);
        $this->db->update('tblTrnPraKarantina',$data);
    }

    function getkuota(){
        $bulan1 = date('m') - 1;
        $bulan = date('m');
        $tahun1 = date('Y') -1;
        $tahun2 = date('Y');
        $query = $this->db->query("SELECT * from tblTrnPraKarantina as A left join vwMstPemborong as B on A.IDPemborong = B.IDPemborong where YEAR(A.CreatedDate) = '$tahun2' and (MONTH(A.CreatedDate) = '$bulan1' OR MONTH(A.CreatedDate) = '$bulan') order by tanggalKarantina asc");
        return $query->result();
    }

    function kuota()
    {
        $bulan = date('m');
        $tahun2 = date('Y');
        $groupid = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT A.*,B.GroupID,B.PemborongID,C.Pemborong,jml from tblTrnPraKarantina as A left join tblUtlGroupPemborong as B on A.IDPemborong = B.PemborongID 
            left join vwMstPemborong as C on A.IDPemborong = C.IDPemborong 
            left join (SELECT DATEDIFF(DAY,TanggalKarantina,GETDATE()) as jml,IDPemborong,COUNT(DetailID) as Jumlah FROM tblTrnPraKarantina_detail group by TanggalKarantina,IDPemborong) as D ON a.IDPemborong = d.IDPemborong
            where GroupID = '$groupid' and YEAR(A.CreatedDate) = '$tahun2' and (MONTH(A.CreatedDate) = '$bulan' OR MONTH(A.CreatedDate) = '$bulan') 
            order by A.tanggalKarantina asc");
        return $query->result();
    }

    function JumlahTKBTerdaftar($id)
    {
        $query = $this->db->query("SELECT A.ID,Nama,TanggalLahir,NamaIbu,TanggalKarantina,Pemborong,COUNT(A.ID) as Total from tblTrnPraKarantina_detail as A left join tblUtlGroupPemborong as B on A.IDPemborong = B.PemborongID left join vwMstPemborong as C on A.IDPemborong = C.IDPemborong where A.ID='$id' group by A.ID,Nama,TanggalLahir,NamaIbu,TanggalKarantina,Pemborong");
        return $query->result();
    }

    function getkuotaKarantina($tanggal)
    {
        $groupid = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT A.*,B.GroupID,B.PemborongID,C.Pemborong,D.Jumlah from tblTrnPraKarantina as A left join tblUtlGroupPemborong as B on A.IDPemborong = B.PemborongID 
            left join vwMstPemborong as C on A.IDPemborong = C.IDPemborong 
            left join (SELECT IDPemborong,COUNT(DetailID) as Jumlah FROM tblTrnPraKarantina_detail where TanggalKarantina = '$tanggal'
            group by IDPemborong) as D ON a.IDPemborong = d.IDPemborong
            where B.GroupID = '$groupid' and A.tanggalKarantina = '$tanggal' order by A.tanggalKarantina asc
            ");
        return $query->result();
    }

    function kuotaByTanggal($tanggal)
    {
        $query = $this->db->query("SELECT * from tblTrnPraKarantina as A left join vwMstPemborong as B on A.IDPemborong = B.IDPemborong where tanggalKarantina ='$tanggal' order by tanggalKarantina asc");
        return $query->result();
    }

    function KarantinaDetail($id)
    {
        $query = $this->db->query("SELECT * FROM tblTrnPraKarantina_detail where IDPemborong ='$id'");
        return $query->result();
    }

    function getTKB($IDPemborong)
    {
        $bulan1 = date('m') - 1;
        $bulan = date('m');
        $tahun1 = date('Y') -1;
        $tahun2 = date('Y');
        $groupid = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT A.*,B.HeaderID,C.tglMedical,C.rapid_test_ket,datediff(YEAR,Tanggal_Lahir,GETDATE()) as umur,D.TanggalMasuk as TanggalMasukHarian,E.TGLMASUK,K.Status_kedatangan,L.DeletedBy FROM vwTrnPraPelamarNew A 
                                    left join tblTrnCalonTenagaKerja as B ON A.Pra_PelamarID = B.Pra_PelamarID 
                                    left join TblMntInterview as K on B.IDInterview = K.IDInterview
                                    left join tblTrnCalonKandidatNew as L on K.CalonPElamarID = L.CalonPelamarID
                                    left join (SELECT * FROM RSUPPayroll..tbl_kk_MstMedicalTemporaryTKNew) as C ON B.HeaderID = C.HeaderID 
                                    left join vwTanggalEfektifMasukKerjaBorongan as D ON B.HeaderID = D.RequestID
                                    left join vwTanggalMasukKaryawan as E ON B.HeaderID = E.HeaderID
                                    
                                    where A.IDPemborong IN (SELECT DISTINCT PemborongID FROM tblUtlGroupPemborong WHERE GroupID = '$groupid' ) and (Status_kedatangan != 2  or Status_kedatangan is null)
                                     and L.DeletedBy is null and (StatusAktif != 0 or StatusAktif is null) and A.IDPemborong = '$IDPemborong' and Alamat_Karantina is null
                                    and  YEAR(A.CreatedDate) = '$tahun2' and (MONTH(A.CreatedDate) = '$bulan1' OR MONTH(A.CreatedDate) = '$bulan')  ORDER BY A.Pra_PelamarID DESC");
        return $query->result();
    }

     function GetCalonTenagaKerja($id)
     {
        $query = $this->db->query("SELECT A.*,B.HeaderID,C.tglMedical,C.rapid_test_ket,datediff(YEAR,Tanggal_Lahir,GETDATE()) as umur,D.TanggalMasuk as TanggalMasukHarian,E.TGLMASUK,K.Status_kedatangan,L.DeletedBy FROM vwTrnPraPelamarNew A 
                                    left join tblTrnCalonTenagaKerja as B ON A.Pra_PelamarID = B.Pra_PelamarID 
                                    left join TblMntInterview as K on B.IDInterview = K.IDInterview
                                    left join tblTrnCalonKandidatNew as L on K.CalonPElamarID = L.CalonPelamarID
                                    left join (SELECT * FROM RSUPPayroll..tbl_kk_MstMedicalTemporaryTKNew) as C ON B.HeaderID = C.HeaderID 
                                    left join vwTanggalEfektifMasukKerjaBorongan as D ON B.HeaderID = D.RequestID
                                    left join vwTanggalMasukKaryawan as E ON B.HeaderID = E.HeaderID
                                    
                                    where (Status_kedatangan != 2  or Status_kedatangan is null)
                                     and L.DeletedBy is null and (StatusAktif != 0 or StatusAktif is null) and A.Pra_PelamarID ='$id' ORDER BY A.Pra_PelamarID DESC");
        return $query->result();
     }

    function getByPemborong($id){
        $query = $this->db->query("SELECT * from tblTrnPraKarantina where ID = '$id'");
        return $query->result();
    }

    //Monitor antigen TKB
    function get_dataPraPelamarAntigen(){
        $bulan1 = date('m') - 1;
        $bulan = date('m');
        $tahun1 = date('Y') -1;
        $tahun2 = date('Y');
        $tanggal = date('Y-m-d');
        $groupid = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT A.*,B.HeaderID,B.Status_Personal,C.tglMedical,C.rapid_test_ket,datediff(YEAR,Tanggal_Lahir,GETDATE()) as umur,D.TanggalMasuk as TanggalMasukHarian,E.TGLMASUK,K.Status_kedatangan,L.DeletedBy FROM vwTrnPraPelamarNew A 
                                    left join tblTrnCalonTenagaKerja as B ON A.Pra_PelamarID = B.Pra_PelamarID 
                                    left join TblMntInterview as K on B.IDInterview = K.IDInterview
                                    left join tblTrnCalonKandidatNew as L on K.CalonPElamarID = L.CalonPelamarID
                                    left join (SELECT * FROM RSUPPayroll..tbl_kk_MstMedicalTemporaryTKNew) as C ON B.HeaderID = C.HeaderID 
                                    left join vwTanggalEfektifMasukKerjaBorongan as D ON B.HeaderID = D.RequestID
                                    left join vwTanggalMasukKaryawan as E ON B.HeaderID = E.HeaderID
                                    where A.IDPemborong IN (SELECT DISTINCT PemborongID FROM tblUtlGroupPemborong WHERE GroupID = '$groupid' ) and (Status_kedatangan != 2  or Status_kedatangan is null)
                                     and DeletedBy is null and (StatusAktif != 0 or StatusAktif is null) and TipeTatalaksana is not null
                                    and  CONVERT(DATE,A.TglMedical) ='$tanggal'  ORDER BY A.Pra_PelamarID DESC");
        return $query->result();
    }

    function get_datapertanggalkarantinaAntigen($tanggal){
        $query = $this->db->query("SELECT A.*,B.HeaderID,B.Status_Personal,B.Verified,B.VerifiedBy,B.VerifiedDate,C.tglMedical,C.rapid_test_ket,datediff(YEAR,Tanggal_Lahir,GETDATE()) as umur,D.TanggalMasuk as TanggalMasukHarian,E.TGLMASUK FROM vwTrnPraPelamarNew A left join tblTrnCalonTenagaKerja as B ON A.Pra_PelamarID = B.Pra_PelamarID left join (SELECT * FROM RSUPPayroll..tbl_kk_MstMedicalTemporaryTKNew) as C ON B.HeaderID = C.HeaderID  left join vwTanggalEfektifMasukKerjaBorongan as D ON B.HeaderID = D.RequestID left join vwTanggalMasukKaryawan as E ON B.HeaderID = E.HeaderID where A.IDPemborong IN (SELECT DISTINCT PemborongID FROM tblUtlGroupPemborong WHERE GroupID = '1' ) and CONVERT(date,A.TglMedical) ='$tanggal' and TipeTatalaksana is not null ORDER BY A.Pra_PelamarID DESC");
        return $query->result();
    }

    #prioritasTenagaKerja

    function GetPraPelamar()
    {
        $query = $this->db->query("SELECT * from vwTrnPraPelamarNew where Komplit is null");
        return $query->result();
    }

    function getPrioritas($pra)
    {
        $query = $this->db->query("SELECT Pra_PelamarID from TblTrnVerifikasiPrioritas WHERE Pra_PelamarID = '$pra'");
        return $query->result();
    }

    public function simpanDataPrioritas($data)
    {
       $this->db->insert("TblTrnVerifikasiPrioritas",$data);
    }

    function getprioritasverifikasi()
    {
          $groupid = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT a.ID,a.Pra_PelamarID,b.Nama_Lengkap,b.Pemborong,b.Pendidikan,b.Jenis_Kelamin,b.StatusKawin,b.Nama_Ibu_Kandung,a.CreatedDate,a.Catatan,b.StatusPrioritas,b.PrioritasBy,b.PrioritasDate  FROM TblTrnVerifikasiPrioritas as a left join vwTrnPraPelamarNew as b on a.Pra_PelamarID = b.Pra_PelamarID WHERE B.IDPemborong IN (SELECT DISTINCT PemborongID FROM tblUtlGroupPemborong WHERE GroupID = '$groupid' ) and Komplit is null and StatusPrioritas is null");
        return $query->result();
    }

    function getprioritasgagal()
    {
        $groupid = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT a.ID,a.Pra_PelamarID,b.Nama_Lengkap,b.Pemborong,b.Pendidikan,b.Jenis_Kelamin,b.StatusKawin,b.Nama_Ibu_Kandung,a.CreatedDate,a.Catatan,b.StatusPrioritas,b.PrioritasBy,b.PrioritasDate  FROM TblTrnVerifikasiPrioritas as a left join vwTrnPraPelamarNew as b on a.Pra_PelamarID = b.Pra_PelamarID WHERE B.IDPemborong IN (SELECT DISTINCT PemborongID FROM tblUtlGroupPemborong WHERE GroupID = '$groupid' ) and StatusPrioritas =2");
        return $query->result();
    }

    function getprioritasbypemborong($pemborong)
    {
        $groupid = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT a.ID,a.Pra_PelamarID,b.Nama_Lengkap,b.Pemborong,b.Pendidikan,b.Jenis_Kelamin,b.StatusKawin,b.Nama_Ibu_Kandung,a.CreatedDate,a.Catatan,b.StatusPrioritas,b.PrioritasBy,b.PrioritasDate FROM TblTrnVerifikasiPrioritas as a left join vwTrnPraPelamarNew as b on a.Pra_PelamarID = b.Pra_PelamarID WHERE B.IDPemborong IN (SELECT DISTINCT PemborongID FROM tblUtlGroupPemborong WHERE GroupID = '12' ) and IDPemborong ='$pemborong'");
        return $query->result();
    }

    function getprioritasBelumCatatan()
    {
        $groupid = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT a.ID,a.Pra_PelamarID,b.Nama_Lengkap,b.Pemborong,b.Pendidikan,b.Jenis_Kelamin,b.StatusKawin,b.Nama_Ibu_Kandung,a.CreatedDate,a.Catatan,b.StatusPrioritas,b.PrioritasBy,b.PrioritasDate  FROM TblTrnVerifikasiPrioritas as a left join vwTrnPraPelamarNew as b on a.Pra_PelamarID = b.Pra_PelamarID WHERE B.IDPemborong IN (SELECT DISTINCT PemborongID FROM tblUtlGroupPemborong WHERE GroupID = '$groupid' ) and a.Catatan is null and Komplit is null");
        return $query->result();
    }

    function getprioritasAll()
    {
        $groupid = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT a.ID,a.Pra_PelamarID,b.Nama_Lengkap,b.Pemborong,b.Pendidikan,b.Jenis_Kelamin,b.StatusKawin,b.Nama_Ibu_Kandung,a.CreatedDate,a.Catatan,b.StatusPrioritas,b.PrioritasBy,b.PrioritasDate  FROM TblTrnVerifikasiPrioritas as a left join vwTrnPraPelamarNew as b on a.Pra_PelamarID = b.Pra_PelamarID WHERE B.IDPemborong IN (SELECT DISTINCT PemborongID FROM tblUtlGroupPemborong WHERE GroupID = '$groupid')");
        return $query->result();
    }

    function getprioritasverifikasiSudahProses($tglawal,$tglakhir)
    {
        $groupid = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT a.ID,a.Pra_PelamarID,b.Nama_Lengkap,b.Pemborong,b.Pendidikan,b.Jenis_Kelamin,b.StatusKawin,b.Nama_Ibu_Kandung,a.CreatedDate,a.Catatan,b.StatusPrioritas,b.PrioritasBy,b.PrioritasDate FROM TblTrnVerifikasiPrioritas as a left join vwTrnPraPelamarNew as b on a.Pra_PelamarID = b.Pra_PelamarID WHERE B.IDPemborong IN (SELECT DISTINCT PemborongID FROM tblUtlGroupPemborong WHERE GroupID = '$groupid' ) and CONVERT(date,KomplitDate) BETWEEN '$tglawal' AND '$tglakhir'  and Komplit is not null");
        return $query->result();
    }
    function getCatatan($id){
        $query = $this->db->query("SELECT ID,Catatan FROM TblTrnVerifikasiPrioritas where ID = '$id'");
        return $query->result();
    }

    function update_catatan($ID,$data){
        $this->db->where("ID",$ID);
        $this->db->update("TblTrnVerifikasiPrioritas",$data);
    }
}