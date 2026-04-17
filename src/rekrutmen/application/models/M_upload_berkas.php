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

    // function insert_db_berkas($hdrid)
    // {
    //     $query = $this->db->get_where("tblTrnBerkas", array("HeaderID" => $hdrid));
    //     if ($query->num_rows() === 0) {
    //         $this->db->trans_start();
    //         $this->db->insert('tblTrnBerkas', array("HeaderID" => $hdrid));
    //         $berkasid = $this->db->insert_id();
    //         $this->db->trans_complete();
    //         return $berkasid;
    //     }
    // }




    //field yang ada di table user
    private $column_order = array(
        'HdrID',
        'Nama',
        'Pemborong',
        'Tgl_Lahir',
        'Jenis_Kelamin'
    );

    //field yang diizin untuk pencarian
    private $column_search = array(
        'HdrID',
        'Nama',
        'Pemborong',
        'Tgl_Lahir',
        'Jenis_Kelamin'
    );

    private $order = array('HdrID' => 'desc');

    function insert_db_berkas($ktp)
    {
        // Cek apakah ada data dengan HeaderID yang sama dalam tabel
        $query = $this->db->get_where("tblTrnBerkas", array("HeaderID" => $ktp['HeaderID']));

        if ($query->num_rows() === 0) {
            // Jika tidak ada data dengan HeaderID yang sama, maka lakukan insert
            $this->db->insert('tblTrnBerkas', $ktp);
            return $this->db->insert_id();
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
        // print_r($idpemborong);
        // die;
        if ($idpemborong > 0) {
            // die;
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
                    AND " . "( CVNama IN ( SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) OR CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) ) "
                );
            } else if ($filter_status == 'minimal') {
                $query = $this->db->query(
                    "SELECT TOP 2000
                        * 
                    FROM
                        vwListBerkas 
                    WHERE
                        GeneralStatus = 0 
                    AND KTP IS NOT NULL 
                    AND ( CV IS NULL OR Lamaran IS NULL OR Ijazah IS NULL OR Transkrip IS NULL ) 
                    AND " . " ( CVNama IN ( SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) OR CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) ) 
                    ORDER BY HdrID DESC"
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
                    AND " . " ( CVNama IN ( SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) OR CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) ) "
                );
            }
        } else {
            // die;
            //$query = $this->db->query("SELECT * FROM vwListBerkas WHERE GeneralStatus = 0 ");
            // $query = $this->db->query("SELECT * FROM vwListBerkas WHERE GeneralStatus = 0 AND CVNama IN (SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '20')"); # OR HdrID = 44489
            // $query = $this->db->query("SELECT TOP 2500 * FROM vwListBerkas WHERE GeneralStatus = 0 AND CVNama IN (SELECT Perusahaan FROM vwMstPemborong) order by HdrID Desc"); # OR HdrID = 44489
            $query = $this->db->query("SELECT
                                            * 
                                        FROM
                                            (
                                            SELECT TOP
                                                2000 * 
                                                -- 100 * 
                                            FROM
                                                vwListBerkas 
                                            WHERE
                                                GeneralStatus = 0 
                                                AND CVNama IN ( SELECT Perusahaan FROM vwMstPemborong ) UNION ALL
                                            SELECT TOP
                                                2000 * 
                                            FROM
                                                vwListBerkas 
                                            WHERE
                                                GeneralStatus = 0 
                                                AND CVNama IN ( SELECT Perusahaan FROM vwMstPemborong ) 
                                                AND (
                                                HdrID = 136736 
                                                    OR HdrID = 137070 
                                                    OR HdrID = 135050
                                                    OR HdrID = 136922 
                                                    OR HdrID = 136931 
                                                    OR HdrID = 136941 
                                                    OR HdrID = 136942 
                                                    OR HdrID = 136943 
                                                    OR HdrID = 136944 
                                                    OR HdrID = 136946 
                                                    OR HdrID = 136947 
                                                    OR HdrID = 137121 
                                                    OR HdrID = 137141 
                                                    OR HdrID = 137140 
                                                    OR HdrID = 137106 
                                                    OR HdrID = 137107 
                                                    OR HdrID = 137110 
                                                    OR HdrID = 137118 
                                                    OR HdrID = 137114 
                                                    )
                                            ) AS CombinedResults 
                                        ORDER BY
                                            HdrID DESC;"); // Sementara aja
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
                    AND AND ( CVNama IN ( SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) OR CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) ) "
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


    private function _get_datatables_query_upload_berkas()
    {

        $idpemborong = $this->session->userdata('idpemborong');
        // $idpemborong = 13;

        if ($idpemborong > 0) {
            $this->db->where("( CVNama IN ( SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) OR CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) )");
        } else {
            $this->db->where("CVNama IN ( SELECT Perusahaan FROM vwMstPemborong )");
        }

        $this->db->select('*');

        if (isset($_POST['selList']) && $_POST['selList'] == '1') {
            $this->db->from('vwTenakerForUploadSPK');
        } else {
            $this->db->from('vwListBerkas');
            $this->db->where("GeneralStatus", 0);
        }
        $this->db->limit(200);


        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable sends POST for search
            {
                if ($item == 'date_time') {
                    $search_value = $_POST['search']['value'];
                    $this->db->or_where("TO_CHAR($item, 'YYYY-MM-DD') LIKE", "'%$search_value%'", false);
                } else {
                    if ($i === 0) // first loop
                    {
                        $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                        $this->db->like($item, $_POST['search']['value']);
                    } else {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
                }
                if (count($this->column_search) - 1 == $i)  //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['filter_status']) && $_POST['filter_status'] != '') {

            switch ($_POST['filter_status']) {
                case 'lengkap':
                    $this->db->where(" KTP IS NOT NULL ");
                    $this->db->where(" CV IS NOT NULL ");
                    $this->db->where(" Lamaran IS NOT NULL ");
                    $this->db->where(" Ijazah IS NOT NULL ");
                    $this->db->where(" Transkrip IS NOT NULL ");
                    break;
                case 'minimal':
                    $this->db->where(" KTP IS NOT NULL ");
                    $this->db->where("KTP <>", "");
                    // $this->db->where(" ( CV IS NULL OR Lamaran IS NULL OR Ijazah IS NULL OR Transkrip IS NULL )  ");
                    break;
                case 'tidak_lengkap':
                    $this->db->where(" KTP IS NULL ");
                    break;
                default:
                    break;
            }
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->column_order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }


    public function get_datatables_upload_berkas()
    {
        $this->_get_datatables_query_upload_berkas();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_upload_berkas()
    {
        $this->_get_datatables_query_upload_berkas();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_upload_berkas()
    {
        return $this->db->from('vwListBerkas')
            ->count_all_results();
    }
}

/* End of file m_upload_berkas.php */
/* Location: ./application/models/m_upload_berkas.php */