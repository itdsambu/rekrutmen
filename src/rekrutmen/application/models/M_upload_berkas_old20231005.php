<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_upload_berkas extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function insert_db_berkas($hdrid)
    {
        $query = $this->db->get_where("tblTrnBerkas", array("HeaderID" => $hdrid));
        if ($query->num_rows() === 0) {
            $this->db->trans_start();
            $this->db->insert('tblTrnBerkas', array("HeaderID" => $hdrid));
            $berkasid = $this->db->insert_id();
            $this->db->trans_complete();
            return $berkasid;
        }
    }

    function update_db_berkas($hdrid, $berkas, $lokasi)
    {
        $this->db->trans_start();
        $this->db->where('HeaderID', $hdrid);
        $this->db->update('tblTrnBerkas', array($berkas => $lokasi));
        $this->db->trans_complete();
    }

    function get_db_berkas($hdrid)
    {
        return $this->db->get_where('tblTrnBerkas', array('HeaderID' => $hdrid));
        // $this->db->where('HeaderID', $hdrid);
        // $query = $this->db->get('tblTrnBerkas');
        // return $query->result();
    }

    function minimal_berkas($hdrid)
    {
        $minimalberkas = 0;
        $query = $this->db->query("Select HeaderID from tblTrnBerkas Where HeaderID=" . $hdrid . " And KTP is not null");
        if ($query->num_rows() > 0) {
            $minimalberkas = 1;
        }
        return $minimalberkas;
    }

    function getListTK($idpemborong, $filter_status)
    {
        //    $this->db->where('GeneralStatus','0');
        //    $query = $this->db->get(array('vwListBerkas'));
        //    return $query->result();
        if ($idpemborong > 0) {
            if ($filter_status == 'lengkap') {
                $query = $this->db->query(
                    "SELECT
                        * 
                    FROM
                        vwListBerkas 
                    WHERE
                        GeneralStatus = 0 
                    AND KTP IS NOT NULL 
                    AND CV IS NOT NULL 
                    AND Lamaran IS NOT NULL 
                    AND Ijazah IS NOT NULL 
                    AND Transkrip IS NOT NULL 
                    AND " . " CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' )"
                );
            } else if ($filter_status == 'minimal') {
                $query = $this->db->query(
                    "SELECT
                        * 
                    FROM
                        vwListBerkas 
                    WHERE
                        GeneralStatus = 0 
                    AND KTP IS NOT NULL 
                    AND ( CV IS NULL OR Lamaran IS NULL OR Ijazah IS NULL OR Transkrip IS NULL ) 
                    AND " . " CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' )"
                );
            } else {
                $query = $this->db->query(
                    "SELECT
                        * 
                    FROM
                        vwListBerkas 
                    WHERE
                        GeneralStatus = 0 
                    AND KTP IS NULL 
                    AND " . " CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' )"
                );
            }
        } else {
            //$query = $this->db->query("SELECT * FROM vwListBerkas WHERE GeneralStatus = 0 ");
            // $query = $this->db->query("SELECT * FROM vwListBerkas WHERE GeneralStatus = 0 AND CVNama IN (SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '20')"); # OR HdrID = 44489
            $query = $this->db->query("SELECT TOP 2000 * FROM vwListBerkas WHERE GeneralStatus = 0 AND CVNama IN (SELECT Perusahaan FROM vwMstPemborong) order by HdrID Desc"); # OR HdrID = 44489
        }
        return $query->result();
    }

    //==== list tenaga kerja

    function get_detailtk($hdrid)
    {
        return $this->db->get_where('vwTrnCalonTenagaKerja2', array('HeaderID' => $hdrid));

        //return $query = $this->db->query("exec spGetDetailCalonTenaker '".$id."'")->result();
    }

    // === UPload Berkas Surat Perjanjian Kontrak ===
    function getTenakerUploadSPK($idpemborong, $filter_status)
    {
        if ($idpemborong > 0) {
            if ($filter_status == 'lengkap') {
                $query = $this->db->query(
                    "SELECT
                        * 
                    FROM
                        vwTenakerForUploadSPK 
                    WHERE
                        KTP IS NOT NULL 
                    AND CV IS NOT NULL 
                    AND Lamaran IS NOT NULL 
                    AND Ijazah IS NOT NULL 
                    AND Transkrip IS NOT NULL 
                    AND CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' )"
                );
            } else if ($filter_status == 'minimal') {
                $query = $this->db->query("SELECT * FROM vwTenakerForUploadSPK WHERE KTP IS NOT NULL AND (CV IS NULL OR Lamaran IS NULL OR Ijazah IS NULL OR Transkrip IS NULL) AND "
                    . "CVNama IN (SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) ");
            } else {
                $query = $this->db->query("SELECT * FROM vwTenakerForUploadSPK WHERE KTP IS NULL AND "
                    . "CVNama IN (SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) ");
            }
        } else {
            //$query = $this->db->query("SELECT * FROM vwTenakerForUploadSPK ");
            $query = $this->db->query("SELECT * FROM vwTenakerForUploadSPK WHERE CVNama IN (SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '20') ");
        }
        return $query->result();
    }

    function getdrhID($id)
    {
        return $query = $this->db->query("exec getBiodataCalonTenaker '" . $id . "'")->result();
    }

    function toExcelSemuaLimitMonth($bln, $thn)
    {
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = " . $thn . " AND "
            . "MONTH(RegisteredDate) = " . $bln . " ORDER BY HeaderID ASC");
        return $query->result();
    }

    function getRiwayatPendidikan($id)
    {
        return $query = $this->db->query("select * from tblTrnPendidikan where HeaderID = '$id'")->result();
    }

    function getListSaudara($id)
    {
        return $query = $this->db->query("select * from tblTrnSaudara where HeaderID = '$id'")->result();
    }
}

/* End of file m_upload_berkas.php */
/* Location: ./application/models/m_upload_berkas.php */