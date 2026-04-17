<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_register extends CI_Model {

    function __construct() {
        parent:: __construct();
    }
        
//    function get_perusahaan_bygroup(){
//        $pemborong = strtoupper($this->input->post('pemborong'));
//        $query = $this->db->get_where('vwMstPemborong', array('Pemborong' => $pemborong));
//        if ($query->num_rows() > 0){
//                $row = $query->row();
//                $perusahaan=$row->Perusahaan;
//        }else{
//                $perusahaan='';
//        }
//        return $perusahaan;
//    }
//        
//    function get_pemborong_bygroup($idpemborong){
//        if ($idpemborong > 0){
//            $result = $this->db->get_where('vwMstPemborong', array('IDPemborong'=>$idpemborong));
//        }else{
//            $this->db->select('*');
//            $this->db->from('vwMstPemborong');
//            $this->db->order_by('IDPerusahaan','ASC');
//            $this->db->order_by('IDPemborong','ASC');
//            $result = $this->db->get();
//        }
//        return $result;
//    }
    
    function getPSGPemborong($idpemborong){
//        $this->db->order_by('Perusahaan','ASC');
//        $query = $this->db->get('PSGBorongan.dbo.tblMstPerusahaan');
//        return $query->result();
        if ($idpemborong > 0){
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
        if ($query->num_rows() > 0){
                $row = $query->row();
                $perusahaan=$row->Pimpinan;
        }else{
                $perusahaan='';
        }
        return $perusahaan;
    }
            
    function getSuku(){
        $query = $this->db->get('tblMstSuku');
        return $query->result();
    }
    
    function getAgama(){
        $query = $this->db->get('tblMstAgama');
        return $query->result();
    }
    
    function getStatusKawin(){
        $query = $this->db->get('tblMstStatusKawin');
        return $query->result();
    }
    
    function getPendidikan(){
        $query = $this->db->get('tblMstPendidikan');
        return $query->result();
    }
    
    function getJurusan(){
        $query = $this->db->get('tblMstJurusan');
        return $query->result();
    }
    
    function getJabatan(){
        $query = $this->db->get('tblMstJabatan');
        return $query->result();
    }
    
    // gx dipake --start
    function cek_data_pelamar($tgllahir,$namaibu,$pemborong){
        $statustk = 0;

        //cek pelamar yang pernah bekerja/melamar dan dinyatakan TIDAK LULUS
        //STATUS = 5
        if ($statustk === 0){
                $query5 = $this->db->query("Select HeaderID From tblTrnCalonTenagaKerja Where convert(datetime,convert(varchar(10),Tgl_Lahir,103),103)=convert(datetime,convert(varchar(10),'".$tgllahir."',103),103) "
                                . "and NamaIbuKandung='$namaibu' And GeneralStatus=1 And ScreeningHasil=0 ");
                if ($query5->num_rows() > 0){
                        $statustk = 5;
                }
        }

        //cek pelamar masih kerja di RSUP (parameter TanggalKeluar & TanggalKeluarTemporary)
        //STATUS = 3
        if ($statustk === 0){
                $query3 = $this->db->query("Select NoFix From vwOL_TKRequestPayBoro Where convert(datetime,convert(varchar(10),Tgl_Lahir,103),103)=convert(datetime,convert(varchar(10),'".$tgllahir."',103),103) "
                                . "and NamaIbuKandung='$namaibu' and TanggalKeluar is Null And TanggalKeluarTemporary is Null");
                if ($query3->num_rows() > 0){
                        $statustk = 3;
                }
        }

        //cek pelamar masih jeda (parameter TanggalKeluarTemporary)
        //STATUS = 4
        if ($statustk === 0){
                $query4 = $this->db->query("Select NoFix From vwOL_TKRequestPayBoro Where convert(datetime,convert(varchar(10),Tgl_Lahir,103),103)=convert(datetime,convert(varchar(10),'".$tgllahir."',103),103) "
                                . "and NamaIbuKandung='$namaibu' and (DateDiff(DAY,TanggalKeluarTemporary,GETDATE()) < 31 or DateDiff(DAY,TanggalKeluar,GETDATE()) < 31)");
                if ($query4->num_rows() > 0){
                        $statustk = 4;
                }
        }

        //cek pelamar sudah diinput dengan nama pemborong TIDAK sama
        //STATUS = 2
        if ($statustk === 0){
                $query2 = $this->db->query("Select top 1 HeaderID From tblTrnCalonTenagaKerja Where convert(datetime,convert(varchar(10),Tgl_Lahir,103),103)=convert(datetime,convert(varchar(10),'".$tgllahir."',103),103) "
                                . "and NamaIbuKandung='$namaibu' And Pemborong <> '$pemborong' And GeneralStatus=0 "
                                . "Order By HeaderID Desc");
                if ($query2->num_rows() > 0){
                        $statustk = 2;
                }
        }

        //cek pelamar sudah diinput dengan nama pemborong sama
        //STATUS = 1
        if ($statustk === 0){
                $query1 = $this->db->query("Select top 1 HeaderID From tblTrnCalonTenagaKerja Where convert(datetime,convert(varchar(10),Tgl_Lahir,103),103)=convert(datetime,convert(varchar(10),'".$tgllahir."',103),103) "
                                . "and NamaIbuKandung='$namaibu' And Pemborong = '$pemborong' And GeneralStatus=0 "
                                . "Order By HeaderID Desc");
                if ($query1->num_rows() > 0){
                        $statustk = 1;
                }
        }

        return $statustk;
    }
    // gx dipake --end
    
    // cek pelamar yang pernah bekerja/melamar dan dinyatakan TIDAK LULUS ==========
    function cekRegScreeningReject($tglLahir,$namaIbu,$namaAyah){
        $query = $this->db->query("SELECT Nama,NamaIbuKandung,Tgl_Lahir,GeneralStatus,ScreeningHasil,NamaBapak  FROM tblTrnCalonTenagaKerja "
                . "WHERE (NamaIbuKandung = '".$namaIbu."' AND Tgl_Lahir = '".$tglLahir."' AND GeneralStatus = 1 AND ScreeningHasil = 0) "
                . "OR (NamaBapak = '".$namaAyah."' AND Tgl_Lahir = '".$tglLahir."' AND GeneralStatus = 1 AND ScreeningHasil = 0) "
                . "OR (NamaBapak = '".$namaAyah."' AND NamaIbuKandung = '".$namaIbu."' AND GeneralStatus = 1 AND ScreeningHasil = 0)");
        if ($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // cek Pernah Melamar ==========
    function cekRegTK($pemborong,$tglLahir,$namaIbu,$namaAyah){
        $query = $this->db->query("SELECT Nama,NamaIbuKandung,Tgl_Lahir,Pemborong,NamaBapak FROM tblTrnCalonTenagaKerja "
                . "WHERE (NamaIbuKandung = '".$namaIbu."' AND Pemborong != '".$pemborong."' AND Tgl_Lahir = '".$tglLahir."' AND GeneralStatus = 0) "
                . "OR (NamaBapak = '".$namaAyah."' AND Pemborong != '".$pemborong."' AND Tgl_Lahir = '".$tglLahir."' AND GeneralStatus = 0) "
                . "OR (NamaIbuKandung = '".$namaIbu."' AND Pemborong != '".$pemborong."' AND NamaBapak = '".$namaAyah."' AND GeneralStatus = 0)");
        if ($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // cek masih dalam masa jeda (TanggalKeluarTemporary) ==========
    function cekRegInTemp($tglLahir,$namaIbu,$namaAyah){
        $query = $this->db->query("SELECT Nama,NamaIbuKandung,Tgl_Lahir,NamaBapak  FROM vw_cekTKRequestPayBoro "
                . "WHERE (NamaIbuKandung = '".$namaIbu."' AND Tgl_Lahir = '".$tglLahir."' AND (DateDiff(DAY,TanggalKeluarTemp,GETDATE()) < 31  or DateDiff(DAY,TanggalKeluar,GETDATE()) < 31)) "
                . "OR (NamaBapak = '".$namaAyah."' AND Tgl_Lahir = '".$tglLahir."' AND (DateDiff(DAY,TanggalKeluarTemp,GETDATE()) < 31  or DateDiff(DAY,TanggalKeluar,GETDATE()) < 31)) "
                . "OR (NamaIbuKandung = '".$namaIbu."' AND NamaBapak = '".$namaAyah."' AND (DateDiff(DAY,TanggalKeluarTemp,GETDATE()) < 31  or DateDiff(DAY,TanggalKeluar,GETDATE()) < 31))");
        if ($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // cek Pernah Masih Aktif sebagai karyawan ==========
    function cekRegAktif($tglLahir,$namaIbu,$namaAyah){
        $query = $this->db->query("SELECT Nama,NamaIbuKandung,Tgl_Lahir,NamaBapak  FROM vw_cekTKRequestPayBoro "
                . "WHERE (NamaIbuKandung = '".$namaIbu."' AND Tgl_Lahir = '".$tglLahir."' AND TanggalKeluar Is NULL AND TanggalKeluarTemp Is NULL) "
                . "OR (NamaBapak = '".$namaAyah."' AND Tgl_Lahir = '".$tglLahir."' AND TanggalKeluar Is NULL AND TanggalKeluarTemp Is NULL) "
                . "OR (NamaIbuKandung = '".$namaIbu."' AND NamaBapak = '".$namaAyah."' AND TanggalKeluar Is NULL AND TanggalKeluarTemp Is NULL)");
        if ($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // cek sudah diiput oleh Pemborong Lainnya ===========
    function cekRegTKPem($pemborong,$tglLahir,$namaIbu,$namaAyah){
        $query = $this->db->query("SELECT Nama,NamaIbuKandung,Tgl_Lahir,Pemborong,NamaBapak FROM tblTrnCalonTenagaKerja "
                . "WHERE (NamaIbuKandung = '".$namaIbu."' AND Pemborong = '".$pemborong."' AND Tgl_Lahir = '".$tglLahir."' AND GeneralStatus = 0) "
                . "OR (NamaBapak = '".$namaAyah."' AND Pemborong = '".$pemborong."' AND Tgl_Lahir = '".$tglLahir."' AND GeneralStatus = 0) "
                . "OR (NamaIbuKandung = '".$namaIbu."' AND Pemborong = '".$pemborong."' AND NamaBapak = '".$namaAyah."' AND GeneralStatus = 0)");
        if ($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    function pernahReg($tglLahir,$namaIbu){
            return $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja where NamaIbuKandung='".strtoupper($namaIbu)."' AND "
                            . "Tgl_Lahir='".$tglLahir."' ORDER BY RegisteredDate DESC, CreatedDate DESC ");
    }
        
    function simpanTKTemp($info){		
        $this->db->trans_start();
        $this->db->insert('tblTrnCalonTenagaKerjaTemporary',$info);
        $hdridtemp = $this->db->insert_id();
        $this->db->trans_complete();
        return $hdridtemp;
    }
    
    function simpanTK($info){		
        $this->db->trans_start();
        $this->db->insert('tblTrnCalonTenagaKerja',$info);
        $hdrID = $this->db->insert_id();
        $this->db->trans_complete();
        return $hdrID;
    }
    
    function hapusTKTemp($hdridtemp){
        $this->db->where('HeaderIDTemporary',$hdridtemp);
        $this->db->delete('tblTrnCalonTenagaKerjaTemporary');
    }
    
    function cek_datakeluarga($hdrID,$hdridtemp,$nama){
        if ($hdridtemp == 0){
            $query = $this->db->get_where('tblTrnKeluarga',array('HeaderID'=>$hdrID,'Nama'=>$nama));			
        }else{
            $query = $this->db->get_where('tblTrnKeluarga',array('HeaderIDTemp'=>$hdridtemp,'Nama'=>$nama));
        }

        if ($query->num_rows() > 0){
            $row = $query->row();
            $detailid=$row->DetailID;
        }else{
            $detailid=0;
        }
        return $detailid;
    }
    
    function simpan_datakeluarga($infokel){
        $this->db->trans_start();
        $this->db->insert('tblTrnKeluarga',$infokel);
        $this->db->insert_id();
        $this->db->trans_complete();
    }
    
    function update_datakeluarga($detailid, $infokel){
        $this->db->trans_start();
        $this->db->where('DetailID',$detailid);
        $this->db->update('tblTrnKeluarga',$infokel);
        $this->db->trans_complete();
    }
    
    function update_datakeluarga_fromtemp($hdrID,$hdrtempid){
        $this->db->trans_start();
        $this->db->where('HeaderIDTemp',$hdrtempid);
        $this->db->update('tblTrnKeluarga',array('HeaderID'=>$hdrID));
        $this->db->trans_complete();
    }
    
    function update_headeridtemp_formtemp($hdrID, $hdridtemp){
        $this->db->trans_start();
        $this->db->where('HeaderID',$hdrID);
        $this->db->update('tblTrnCalonTenagaKerja',array('HeaderIDTemp'=>$hdridtemp));
        $this->db->trans_complete();
    }
    
    function cek_dataanak($hdrID,$hdridtemp,$namaanak){
        if ($hdridtemp == 0){
            $query = $this->db->get_where('tblTrnAnak',array('HeaderID'=>$hdrID,'Nama'=>$namaanak));
        }else{
            $query = $this->db->get_where('tblTrnAnak',array('HeaderIDTemp'=>$hdridtemp,'Nama'=>$namaanak));
        }

        if ($query->num_rows() > 0){
            $row = $query->row();
            $detailid=$row->DetailID;
        }else{
            $detailid=0;
        }
        return $detailid;
    }
    
    function simpan_dataanak($infoanak){
        $this->db->trans_start();
        $this->db->insert('tblTrnAnak',$infoanak);
        $this->db->insert_id();
        $this->db->trans_complete();
    }
    
    function update_dataanak($detailid, $infoanak){
        $this->db->trans_start();
        $this->db->where('DetailID',$detailid);
        $this->db->update('tblTrnAnak',$infoanak);
        $this->db->trans_complete();
    }
    
    function update_dataanak_fromtemp($hdrID,$hdrtempid){
        $this->db->trans_start();
        $this->db->where('HeaderIDTemp',$hdrtempid);
        $this->db->update('tblTrnAnak',array('HeaderID'=>$hdrID));
        $this->db->trans_complete();
    }
    
    function update_status_foto($hdrID){
        $this->db->trans_start();
        $this->db->where('HeaderID',$hdrID);
        $this->db->update('tblTrnCalonTenagaKerja',array('AdaPhotoOnline'=>1));
        $this->db->trans_complete();
    }
    
    function get_tenagakerja($hdrID){
        return $this->db->get_where('tblTrnCalonTenagaKerja',array('HeaderID' => $hdrID));
    }
    
    function get_datatk_temp($hdridtemp){
        $this->db->where('HeaderIDTemporary',$hdridtemp);
        return $this->db->get('tblTrnCalonTenagaKerjaTemporary');
    }
}

/* End of file m_register.php */
/* Location: ./application/models/m_register.php */