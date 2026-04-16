<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author by ITD15
 */

class M_posting_tenaker extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->PSGBOR = $this->load->database('PSGBOR', TRUE);
    }

    // function getTenakerOK()
    // {
    //     $query = $this->db->query("SELECT
    //                                     * 
    //                                 FROM
    //                                     -- vwListBerkas_run20220611 
    //                                     vwListBerkas 
    //                                 WHERE
    //                                     Verified = '1' 
    //                                     AND SpecialScreening = '1' 
    //                                     AND WawancaraHasil = '1' 
    //                                     AND GeneralStatus = '0' 
    //                                     AND PostingData = '0'
    //                                     ORDER BY HdrID DESC
    //                             ");
    //     return $query->result();
    // }


    // permintaan hrd-yuli filter hanya tahun ini saja 14/04/2025
    function getTenakerOK()
    {
        $query = $this->db->query("SELECT
                                        * 
                                    FROM
                                        vwListBerkas 
                                    WHERE
                                        Verified = '1' 
                                        AND SpecialScreening = '1' 
                                        AND WawancaraHasil = '1' 
                                        AND GeneralStatus = '0' 
                                        AND PostingData = '0' 
                                        -- AND YEAR ( verifiedDate ) = YEAR ( GETDATE( ) ) 
                                        AND verifiedDate >= DATEFROMPARTS(YEAR(GETDATE()) - 1, 1, 1)
                                        AND verifiedDate <  DATEFROMPARTS(YEAR(GETDATE()) + 1, 1, 1)
                                    ORDER BY
                                        HdrID DESC
                                ");
        return $query->result();
    }

    function getTrans($idDetail)
    {
        $query = $this->db->query("SELECT * FROM tblTrnRequest WHERE DetailID = '" . $idDetail . "'");
        return $query->result();
    }

    // ==================== Ambil Data Detail Karyawan dan Anaknya ===========================
    function getResult($hdrID = [])
    {
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE HeaderID ='" . $hdrID . "'");
        return $query->result();
    }
    function getResultChecked($hdrID = null)
    {
        $hdrid = implode(",", $hdrID);
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE HeaderID IN($hdrid) ");
        return $query->result();
    }
    function getResultData_($data)
    {
        $Awal = date("Y-m-d", strtotime($data[0]));
        $Akhir = date("Y-m-d", strtotime($data[1]));
        $dataSelect = $data[2];



        if ($dataSelect == '2') {
            $con = "WHERE a.SpecialScreeningDate >= '$Awal' AND a.SpecialScreeningDate <= '$Akhir' AND Verified = '1' 
                            AND SpecialScreening = '1' 
                            AND WawancaraHasil = '1' 
                            AND GeneralStatus = '0' 
                            --AND PostingData = '0'
                ";
            // die;
        } else {
            $con = "WHERE ClosingDate >= '$Awal' AND ClosingDate <= '$Akhir'";
        }

        // $limit = 800;
        // $offset = 0;
        // $allData = [];

        // do {
        //     $query = $this->db
        //         ->select('a.*, b.Kabupaten_KotaName')
        //         ->from('tblTrnCalonTenagaKerja a')
        //         ->join('PSGPayroll.dbo.tblMstKabKota b', 'a.KabKotaID = b.Kabupaten_KotaID', 'left')
        //         ->where($con, null, false) // raw SQL condition
        //         ->order_by('a.HeaderID', 'ASC')
        //         ->limit($limit, $offset)
        //         ->get();

        //     $rows = $query->result(); // array of objects
        //     $allData = array_merge($allData, $rows);
        //     $offset += $limit;
        // } while (count($rows) > 0);
        $query = $this->db->query("SELECT TOP 800 a.*, b.Kabupaten_KotaName FROM tblTrnCalonTenagaKerja a LEFT JOIN PSGPayroll..tblMstKabKota b ON a.KabKotaID = b.Kabupaten_KotaID $con  ORDER BY A.HeaderID DESC");
        return $query->result();
        // return $allData;
    }

    function getResultData($data)
    {
        $Awal = date("Y-m-d", strtotime($data[0]));
        $Akhir = date("Y-m-d", strtotime($data[1]));
        $dataSelect = $data[2];

        if ($dataSelect == '0') {
            $con = "WHERE SpecialScreeningDate >= '$Awal' AND SpecialScreeningDate <= '$Akhir'";
        }

        if ($dataSelect == '1') {
            $con = "WHERE ClosingDate >= '$Awal' AND ClosingDate <= '$Akhir'";
        }

        if ($dataSelect == '2') {
            $con = "WHERE a.SpecialScreeningDate >= '$Awal' AND a.SpecialScreeningDate <= '$Akhir' AND Verified = '1' 
                            AND SpecialScreening = '1' 
                            AND WawancaraHasil = '1' 
                            AND GeneralStatus = '0' 
                            AND PostingData = '0'
                ";
        }

        $query = $this->db->query("SELECT TOP 800 a.*, b.Kabupaten_KotaName FROM tblTrnCalonTenagaKerja a LEFT JOIN PSGPayroll..tblMstKabKota b ON a.KabKotaID = b.Kabupaten_KotaID $con  ORDER BY A.HeaderID DESC");
        return $query->result();
    }
    function getInterV($hdrID)
    {
        $query = $this->db->query("SELECT TOP 1 * FROM tblTrnWawancara WHERE HeaderID ='" . $hdrID . "' ORDER BY Tanggal DESC");
        return $query->result();
    }
    function getAnak($hdrID)
    {
        $query = $this->db->query("SELECT TOP 2 * FROM tblTrnAnak WHERE HeaderID ='" . $hdrID . "' ORDER BY TglLahir DESC");
        return $query->result();
    }

    // ============== Lakukan Posting ================
    function setPosting($info)
    {
        $this->db->trans_start();
        $this->db->insert('tblTrnPosting', $info);
        $this->db->insert_id();
        $this->db->trans_complete();
    }

    // function cek_data_utility_p2k3($p2k3)
    // {
    //     $this->db->from($this->table1);
    //     $this->db->where('formula', $formula);
    //     $this->db->where('productiondate', $productiondate);
    //     $this->db->where('filler', $filler);
    //     $this->db->where('pack_kosong', $pack_kosong);
    //     $this->db->where('kategori_produk_2', $kategori_produk_2);
    //     $this->db->where('nm_produk', $nm_produk);
    //     $this->db->where('bbd', $bbd);
    //     $query = $this->db->get();
    //     return $query;
    // }


    function updatePost($hdrID)
    {
        $data   = array(
            'PostingData'   => 1,
            'GeneralStatus' => 1,
            'ClosingRemark' => 'Telah Diposting',
            'ClosingBy'     => $this->session->userdata('username'),
            'ClosingDate'   => date('Y-m-d H:i:s')
        );
        $this->db->trans_start();
        $this->db->where('HeaderID', $hdrID);
        $this->db->update('tblTrnCalonTenagaKerja', $data);
        $this->db->trans_complete();
    }


    function updateTrans($id, $data)
    {
        $this->db->trans_start();
        $this->db->where('DetailID', $id);
        $this->db->update('tblTrnRequest', $data);
        $this->db->trans_complete();
    }

    function updateMstTenakerPayboro($id, $data)
    {
        $this->PSGBOR->trans_start();
        $this->PSGBOR->where('FixNo', $id);
        $this->PSGBOR->update('tblMstTenagaKerja', $data);
        $this->PSGBOR->trans_complete();
    }

    //===================================================
    function resetToIdentifikasi($hdrID, $data)
    {
        $this->db->trans_start();
        $this->db->where('HeaderID', $hdrID);
        $this->db->update('tblTrnCalonTenagaKerja', $data);
        $this->db->trans_complete();
    }

    // ===============Jika Ingin membuka dept lain==================
    function selectWhereIssue($deptTujuan, $pekerjaan)
    {
        if ($deptTujuan == 'MP1') {
            $dept   = 'MPD';
            $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalAll WHERE DeptAbbr LIKE '%" . $dept . "%' AND "
                . "GeneralStatus = 1 ORDER BY DeptAbbr");
        } else if ($deptTujuan == 'MP2') {
            $dept   = $deptTujuan;
            $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalAll WHERE DeptAbbr LIKE '%" . $dept . "%' OR DeptAbbr LIKE '%MPD%' AND "
                . "GeneralStatus = 1 ORDER BY DeptAbbr");
        } else {
            $dept   = $deptTujuan;
            $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalAll WHERE DeptAbbr LIKE '%" . $dept . "%' AND "
                . "GeneralStatus = 1 ORDER BY DeptAbbr");
        }

        return $query->result();
    }
    function selectWhereIssueByID($id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalAll WHERE DetailID = '" . $id . "'");
        return $query->row();
    }
    function updateIssueByTenaker($idHdr, $data)
    {
        $this->db->trans_start();
        $this->db->where('HeaderID', $idHdr);
        $this->db->update('tblTrnCalonTenagaKerja', $data);
        $this->db->trans_complete();
    }

    function getDept($idDetail)
    {
        $query = $this->db->query("SELECT * FROM vwTrnApprovalAll WHERE DetailID = '" . $idDetail . "'");
        return $query->result();
    }
}
