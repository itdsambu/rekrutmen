<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_transaksi extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function savekouta($data)
    {
        $this->db->insert('tblMstKuotaPemborong', $data);
        $hdrid = $this->db->insert_id();
        $this->db->trans_complete();
        return $hdrid;
    }

    function saveTKkouta($data)
    {
        $this->db->insert('tblTrnKuotaTK', $data);
        $hdrid = $this->db->insert_id();
        $this->db->trans_complete();
        return $hdrid;
    }

    function list($periode, $idpemborong)
    {
        return $query = $this->db->query(
            "
                SELECT
                    *,cast(BatasInput as time(0)) as BatasInput, JmlKouta - (
                        SELECT
                            COUNT (HeaderID) AS HdrID
                        FROM
                            tblTrnKuotaTK
                        WHERE
                        AND ( CVNama IN ( SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) OR CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) ) 
                        AND Periode = convert(date,'" . $periode . "',105)
                        AND Status = 'UNLOCK'
                    ) AS SisaKouta
                FROM
                    tblMstKoutaPemborong
                WHERE
                    Periode = convert(varchar,'" . $periode . "',105)
                AND Status = 'UNLOCK'
                AND AND ( CVNama IN ( SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) OR CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) ) 
                "
        )->result();
    }

    function getDataTK($id, $idpemborong)
    {
        return $query = $this->db->query("exec spGetCalonTenaker '" . $id . "','" . $idpemborong . "'")->result();
    }

    function listTK($periode, $idpemborong)
    {
        //return $query = $this->db->query("SELECT distinct * FROM vwTrnKoutaTK WHERE Status='UNLOCK' AND Periode='".$periode."' and CVNama IN (SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '".$idpemborong."') ")->result();
        return $query = $this->db->query("select * from tblTrnKuotaTK where periode=convert(date,'" . $periode . "',105) and AND ( CVNama IN ( SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) OR CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) ) ")->result();
    }

    function TotallistTK($periode, $idpemborong)
    {
        $periode = date('Y-m-d');
        $idpemborong    = $this->session->userdata('idpemborong');
        return $query = $this->db->query("SELECT COUNT(HeaderID) FROM tblTrnKuotaTK WHERE Periode='" . $periode . "' and CVNama='" . $idpemborong . "' ")->result();
    }
    function Totallist($periode)
    {
        $periode = date('d-m-Y');
        return $query = $this->db->query("SELECT * FROM tblMstKuotaPemborong WHERE Periode='" . $periode . "'")->result();
    }

    function getKouta($periode)
    {
        return $query = $this->db->query("SELECT * FROM tblMstKuotaPemborong WHERE Periode=convert(date,'" . $periode . "',105) ORDER BY Periode DESC")->result();
    }

    function lockKouta($id)
    {
        $data = array('Status' => 'LOCK');
        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->update('tblMstKoutaPemborong', $data);
        $this->db->trans_complete();
    }

    function unlockKouta($id)
    {
        $data = array('Status' => 'UNLOCK');
        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->update('tblMstKoutaPemborong', $data);
        $this->db->trans_complete();
    }

    function get_kouta($id)
    {
        return $this->db->get_where('tblMstKoutaPemborong', array('id' => $id));
    }

    function updateKouta($id, $data)
    {
        $this->db->where('id', $id);
        $query = $this->db->update('tblMstKoutaPemborong', $data);
        return $query;
    }

    function listKoutaTK()
    {
        return $query = $this->db->query("select * from tblTrnKuotaTK")->result();
    }

    function DeleteTransTK($hdrID)
    {
        $this->db->trans_start();
        $this->db->where('HeaderID', $hdrID);
        $this->db->delete('tblTrnKuotaTK');
        $this->db->trans_complete();
    }

    // function getPSGPemborong($idpemborong){
    //     if ($idpemborong > 0){
    //         $result = $this->db->get_where('vwMstPemborong', array('IDPerusahaan'=>$idpemborong));
    //     }else{
    //         // $this->db->select('*');
    //         // $this->db->from('vwMstPemborong');
    //         // $this->db->order_by('Perusahaan','ASC');
    //         // $result = $this->db->get();
    //         $result = $this->db->query("SELECT * FROM vwMstPemborong WHERE IDPemborong!=19 ORDER BY Perusahaan ASC");
    //     }
    //     return $result->result();
    // }

    function getPSGPemborong()
    {
        // if ($idpemborong > 0){
        //     $result = $this->db->get_where('vwMstPemborong', array('IDPerusahaan'=>$idpemborong));
        // }else{
        //     // $this->db->select('*');
        //     // $this->db->from('vwMstPemborong');
        //     // $this->db->order_by('Perusahaan','ASC');
        //     // $result = $this->db->get();
        //     $result = $this->db->query("SELECT * FROM vwMstPemborong WHERE IDPemborong!=19 ORDER BY Perusahaan ASC");
        // }

        $result = $this->db->query("SELECT * FROM vwMstPemborong WHERE IDPemborong!=19 ORDER BY Perusahaan ASC");
        return $result->result();
    }

    function getPemborong()
    {
        $pemborong = strtoupper($this->input->post('pemborong'));
        $query = $this->db->get_where('vwMstPemborong', array('Perusahaan' => $pemborong));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $perusahaan = $row->Pimpinan;
        } else {
            $perusahaan = '';
        }
        return $perusahaan;
    }

    function getListPBR($idpemborong, $periode)
    {
        return $query = $this->db->query("SELECT distinct a.HeaderID,a.Nama,b.CVNama,a.Periode,b.Status FROM tblTrnKuotaTK AS a INNER JOIN tblMstKoutaPemborong AS b on b.CVNama=a.CVNama WHERE b.AND ( CVNama IN ( SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) OR CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) ) 
        AND b.Status='UNLOCK' AND a.Periode=convert(date,'" . $periode . "',105) order by Nama ASC")->result();
    }

    function getListperiode($periode)
    {
        // $this->db->select('*');
        //       $this->db->from('tblTrnKuotaTK');
        // $this->db->where('Periode',convert(date,$periode,105));
        //       $this->db->order_by('CVNama','ASC');
        //       $result = $this->db->get();

        $result = $this->db->query("SELECT * FROM tblTrnKuotaTK WHERE Periode=convert(date,'" . $periode . "',105) ORDER BY CVNama ASC");
        return $result->result();
    }
    function getHari()
    {
        //return $query = $this->db->query("SELECT DATENAME(w,GETDATE()) as HARI")->result();
        return $query = $this->db->query("SELECT * FROM (SELECT datename(dw,getdate()) as hari,convert(varchar(20),getdate(),105) as tanggal) A")->result();
    }

    function getLibur()
    {
        return $query = $this->db->query("SELECT * FROM vwMstHariLibur")->result();
    }

    function gettglinputkuota()
    {
        $query = $this->exec_sql('getTglInputKuota');
        return $query;
    }


    function getTotalKuotaMedicalPerHari()
    {
        // $getDate = date('N');
        $getDate = date('N');
        $this->db->where('DayNumber', $getDate);
        $get = $this->db->get('tblMstKuotaTenakerPerHari')->row();
        return $get->Kuota;
    }

    function getStartInputKuotaMedicalPerHari()
    {
        $getDate = date('N');
        $this->db->where('DayNumber', $getDate);
        $get = $this->db->get('tblMstKuotaTenakerPerHari')->row();
        return $get->StartInput;
    }

    function getBatasInputKuotaMedicalPerHari()
    {
        $getDate = date('N');
        $this->db->where('DayNumber', $getDate);
        $get = $this->db->get('tblMstKuotaTenakerPerHari')->row();
        return $get->BatasInput;
    }

    function getAlertKuotaMedicalPerHari()
    {
        $getDate = date('N');
        $this->db->where('DayNumber', $getDate);
        $get = $this->db->get('tblMstKuotaTenakerPerHari')->row();
        return $get->Alert;
    }

    function countKuotaToDay($periode)
    {
        // $this->db->where("Periode",$periode);
        // $get = $this->db->get("tblTrnKuotaTK");
        $query = $this->db->query("SELECT HeaderID FROM tblTrnKuotaTK WHERE convert(varchar,Periode,105)='" . $periode . "'");
        return $query->num_rows();
    }

    function getKoutaPerHari()
    {
        return $query = $this->db->query("SELECT * FROM tblMstKuotaTenakerPerHari")->result();
    }

    function setKoutaPerHari($id)
    {
        $query = $this->db->query("SELECT * FROM tblMstKuotaTenakerPerHari WHERE DayNumber = '" . $id . "'");
        return $query->result();
    }

    function updateKoutaPerhari($id, $data)
    {
        $this->db->where('DayNumber', $id);
        $query = $this->db->update('tblMstKuotaTenakerPerHari', $data);
        return $query;
    }

    function getDataKuotaPerHari($periode)
    {
        $result = $this->db->query("SELECT a.HeaderID,a.Nama,a.CVNama,a.Periode,b.KTP,b.CV,b.Lamaran,b.Ijazah,b.Transkrip,b.SuratKontrak FROM tblTrnKuotaTK AS a left outer join tblTrnBerkas AS b ON a.HeaderID=b.HeaderID WHERE a.Periode=convert(date,'" . $periode . "',105) ORDER BY a.CVNama ASC");
        return $result->result();
    }

    function getDocs($userID)
    {
        $query = $this->db->query("SELECT * FROM tblTrnBerkas WHERE HeaderID='" . $userID . "'");
        return $query->result();
    }

    function getTransByStatus($status, $jenis, $dept)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL WHERE Pemborong='$jenis' and GeneralStatus = '" . $status . "' AND DeptID IN (" . $dept . ")");
        return $query->result();
    }

    function countKuotaPendidikanToDay($periode)
    {
        $query = $this->db->query("SELECT HeaderID FROM tblTrnKuotaTK WHERE convert(varchar,Periode,105)='" . $periode . "' AND StatusPendidikan='1'");
        return $query->num_rows();
    }

    function countKuotaNonPendidikanToDay($periode)
    {
        $query = $this->db->query("SELECT HeaderID FROM tblTrnKuotaTK WHERE convert(varchar,Periode,105)='" . $periode . "' AND StatusPendidikan='0'");
        return $query->num_rows();
    }

    function getTotalKuotaPendidikanPerHari($periode)
    {
        // $getDate = date('N');
        $getDate = date('N', strtotime($periode));
        $this->db->where('DayNumber', $getDate);
        $get = $this->db->get('tblMstKuotaTenakerPerHari')->row();
        return $get->KuotaPendidikan;
    }

    function getTotalKuotaNonPendidikanPerHari($periode)
    {
        // $getDate = date('N');
        $getDate = date('N', strtotime($periode));
        $this->db->where('DayNumber', $getDate);
        $get = $this->db->get('tblMstKuotaTenakerPerHari')->row();
        return $get->KuotaNonPendidikan;
    }


    function getsisakuota($periode)
    {
        $getDate = date('Y-m-d', strtotime($periode));
        $get = $this->db->query("exec spGetSisaKuotaPemborong '" . $getDate . "'");
        return $get->result();
    }

    // terbaru
    function getTotalKuotaNonPendidikan($periode, $pemborong)
    {
        // $getDate = date('N');
        $getDate = date('Y-m-d', strtotime($periode));
        $this->db->where('Periode', $getDate);
        $this->db->where("AND ( CVNama IN ( SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = '" . $pemborong . "' ) OR CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $pemborong . "' ) ) ");
        $get = $this->db->get('tblMstKuotaPemborong')->row();
        return $get->KuotaNonPendidikan;
    }

    function countKuotaBiasaToDay($periode, $pemborong)
    {
        $query = $this->db->query("SELECT * FROM tblTrnKuotaTK WHERE AND ( CVNama IN ( SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = '" . $pemborong . "' ) OR CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $pemborong . "' ) ) 
        AND convert(varchar,Periode,105)='" . $periode . "'");
        return $query->num_rows();
    }

    function bataswaktuinputkuotabiasa($periode, $pemborong)
    {
        $tgl = date('Y-m-d', strtotime($periode));
        $this->db->where('Periode', $tgl);
        $this->db->where("AND ( CVNama IN ( SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = '" . $pemborong . "' ) OR CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $pemborong . "' ) ) ");
        $get = $this->db->get('tblMstKuotaPemborong')->row();
        return $get->BatasInput;
    }

    function mulaiwaktuinputkuotabiasa($periode, $pemborong)
    {
        $tgl = date('Y-m-d', strtotime($periode));
        $this->db->where('Periode', $tgl);
        $this->db->where("AND ( CVNama IN ( SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = '" . $pemborong . "' ) OR CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $pemborong . "' ) ) ");
        $get = $this->db->get('tblMstKuotaPemborong')->row();
        return $get->StartInput;
    }
}
