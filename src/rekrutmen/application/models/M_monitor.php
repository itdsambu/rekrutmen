<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author : てり　らま
 */

class M_monitor extends CI_Model
{
    protected $table = 'vwTrnCalonKandidat';
    protected $table_tenaker_new = 'vwListBerkas';

    //field yang ada di table user
    private $column_order = array(
        'Nama',
        'JK',
        'Tempat_Lhr',
        'Tanggal_Lhr',
        'NoKTP',
        'NoHP',
        'Email',
        'Pendidikan',
        'JadwalTest',
        'Status',
        'Posisi',
        'Level',
        'Dept',
        'Divisi',
        'CreatedBy',
        'CreatedDate',
        'UpdatedBy',
        'UpdatedDate',
        'Jurusan',
        'Keterangan',
        'StsTest',
        'Transport',
        'Biaya',
        'CV',
        'RiwayatHidup',
        'Ijazah',
        'SumberPelamar'

    );
    //field yang diizin untuk pencarian
    private $column_search = array(
        'Nama',
        'JK',
        'Tempat_Lhr',
        'Tanggal_Lhr',
        'NoKTP',
        'NoHP',
        'Email',
        'Pendidikan',
        'JadwalTest',
        'Status',
        'Posisi',
        'Level',
        'Dept',
        'Divisi',
        'CreatedBy',
        'CreatedDate',
        'UpdatedBy',
        'UpdatedDate',
        'Jurusan',
        'Keterangan',
        'StsTest',
        'Transport',
        'Biaya',
        'CV',
        'RiwayatHidup',
        'Ijazah',
        'SumberPelamar'
    );


    private $column_order_list_for_pbr = array(
        'HeaderID',
        'Nama',
        'Pemborong',
        'SubPemborong',
        'Jenis_Kelamin',
        'JadwalInterview',
    );

    private $column_search_list_for_pbr = array(
        'A.HeaderID',
        'Nama',
        'Pemborong',
        'SubPemborong',
        'Jenis_Kelamin',
        'JadwalInterview',
        'mcu_date',
    );

    private $column_order_calon_tenaker = array(
        'HeaderID',
        'HeaderID',
        'Nama',
        'Pemborong',
        'SubPemborong',
        'Tgl_Lahir',
        'Jenis_Kelamin',
    );

    private $column_search_calon_tenaker = array(
        'HeaderID',
        'HeaderID',
        'Nama',
        'Pemborong',
        'SubPemborong',
        'Tgl_Lahir',
        'Jenis_Kelamin',
    );

    private $order_list_for_pbr = array('A.HeaderID' => 'desc'); // default order 
    private $order = array('ID' => 'desc'); // default order 
    private $order_list_berkas = array('HeaderID' => 'desc'); // default order 
    private $order_calon_tenaker = array('HeaderID' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->telebot = $this->load->database('telebot', TRUE);
    }

    private function _get_datatables_query()
    {

        $this->db->select("ROW_NUMBER() OVER(ORDER BY ID DESC) AS Row, vwTrnCalonKandidat.*", false);
        $this->db->from($this->table);

        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {

            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['status']) && !empty($_POST['status']) && $_POST['status'] != '') {
            $this->db->where('Status', $_POST['status']);
        }

        if ((isset($_POST['start_date']) && !empty($_POST['start_date']) && $_POST['start_date'] != '') && (isset($_POST['end_date']) && !empty($_POST['end_date']) && $_POST['end_date'] != '')) {
            $this->db->where('TglKeluar >=', date('Y-m-d', strtotime($_POST['start_date'])));
            $this->db->where('TglKeluar <=', date('Y-m-d', strtotime($_POST['end_date'])));
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    private $column_order_listberkas = array(
        'HeaderID',
        'Nama',
        'Pemborong',
        'SubPemborong',
        'Tgl_Lahir',
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,

    );

    //field yang diizin untuk pencarian
    private $column_search_listberkas = array(
        'HeaderID',
        'Nama',
        'Pemborong',
        'Tgl_Lahir',
        'RegisteredBy',
        'RegisteredDate',
        'CVNama',
        // 'SubPemborong',
        'Pendidikan',
        'Jenis_Kelamin',
        'Jurusan',
        'No_ktp'
    );

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        return $this->db->from($this->table)
            ->count_all_results();
    }


    function getListTK()
    {
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE GeneralStatus = 0 ORDER BY HeaderID ASC");
        return $query->result();
    }
    function getListTK2()
    {
        $query = $this->db->query("SELECT HeaderID,Nama,Pemborong,Tgl_Lahir,Jenis_Kelamin,ScreeningHasil,
        ScreeningComplete,SpecialScreening,Verified,PostingData,RegisteredBy,RegisteredDate,
        [dbo].[fnGenerateHistory] (k.HeaderID) as History
        FROM tblTrnCalonTenagaKerja k WHERE GeneralStatus = 0  ORDER BY HeaderID ASC");
        return $query->result();
    }
    function getListTK3($start, $end)
    {
        $query = $this->db->query("SELECT HeaderID,Nama,Pemborong,Tgl_Lahir,Jenis_Kelamin,ScreeningHasil,
        ScreeningComplete,SpecialScreening,Verified,PostingData,RegisteredBy,RegisteredDate,
        [dbo].[fnGenerateHistory] (k.HeaderID) as History
        FROM tblTrnCalonTenagaKerja k WHERE GeneralStatus = 0 and RegisteredDate BETWEEN '" . $start . "' AND '" . $end . "' ORDER BY HeaderID ASC");
        return $query->result();

        // $query = $this->db->query("SELECT HeaderID,Nama,Pemborong,Tgl_Lahir,Jenis_Kelamin,ScreeningHasil,
        // ScreeningComplete,SpecialScreening,Verified,PostingData,RegisteredBy,RegisteredDate,
        // [dbo].[fnGenerateHistory] (k.HeaderID) as History
        // FROM tblTrnCalonTenagaKerja k WHERE GeneralStatus = 0 and convert(char,RegisteredDate,105) like '%$monthyear' ORDER BY HeaderID ASC");
        // return $query->result();
    }

    function list_calon_tk($dataselect, $start_date, $end_date, $nama, $noreg)
    {
        switch ($dataselect) {
            case 'verifi':
                $con = 'and Verified = 0 ';
                $filterDate = 'DikirimDate';
                break;
            case 'interview':
                $con = "and PostingData = 0 and GeneralStatus = 0 and StatusDaftar = 1 and JadwalInterview IS NOT NULL and JadwalInterview <> ''";
                $filterDate = 'JadwalInterview';
                break;
            case 'identifi':
                $con = 'and GeneralStatus = 0 and Verified = 1 and DeptTujuan IS NULL';
                $filterDate = 'DikirimDate';
                break;
            case 'belumposting':
                $con = 'and SpecialScreening IS NOT NULL AND PostingData IS NULL';
                $filterDate = 'DikirimDate';
                break;
            case 'mcu':
                $con = 'and Verified = 1 AND SpecialScreening = 1 AND  WawancaraHasil = 1  AND PostingData = 1  AND GeneralStatus = 1';
                $filterDate = 'ClosingDate';
                break;
            case 'closed':
                $con = 'and ClosingDate is not null';
                $filterDate = 'ClosingDate';
                break;
                // case 'mcu':
                //     $con = 'and Verified = 1 AND SpecialScreening = 1 AND  WawancaraHasil = 1  AND PostingData = 0 ';
                //     $filterDate = 'DikirimDate';
                //     break;

                // 0
            default:
                $con = '';
                $filterDate = 'DikirimDate';
                break;
        }

        // $con_noreg = !empty($noreg) ? "and headerid like '%" . $noreg . "%'" : '';
        // $con_nama = !empty($nama) ? "and nama like '%" . $nama . "%'" : '';
        /**
         * 
         */
        $q1 = $this->db->query(
            "SELECT
                hdrid 
            FROM
                vwlistberkas 
            WHERE
             $filterDate >= '$start_date' 
            AND $filterDate <= '$end_date' $con"
            // AND DikirimDate <= '$end_date' $con $con_noreg $con_nama"
        )->num_rows();

        // $q2 = $this->db->query("select * from vwListBerkas where nama like '%tengku%'")->result();
        $q2 = $this->db->query(
            "SELECT 
            top(2000)
                *
            FROM
                (
                    SELECT ROW_NUMBER
                        ( ) OVER ( ORDER BY verified ASC ) AS ROW, 
                        * 
                    FROM
                        -- vwListBerkas_run20220611 
                        vwListBerkas 
                    WHERE
                -- cvnama like '%PT. PULAU SAMBU (GUNTUNG)%'
                        $filterDate >= '$start_date' 
                        AND $filterDate <= '$end_date' $con 
                    -- ORDER BY HeaderID desc
                ) A"
        )->result();
        return [
            'jumlah_row' => $q1,
            'list_per_page' => $q2,
        ];
    }

    function sendToRegister($data)
    {
        $this->db->trans_start();
        $this->db->update_batch('tblTrnCalonTenagaKerja', $data, 'HeaderID');
        $rtn = $this->db->trans_complete();

        if ($rtn) {
            return 1;
        } else {
            return 0;
        }
    }

    function sendToTransaksi($data)
    {
        $this->db->trans_start();
        $this->db->update_batch('tblTrnCalonTenagaKerja', $data, 'HeaderID');
        $rtn = $this->db->trans_complete();

        if ($rtn) {
            return 1;
        } else {
            return 0;
        }
    }

    function closeTenaker($hdrID, $remark)
    {
        $data   = array(
            'GeneralStatus' => 1,
            'ClosingRemark' => $remark,
            'ClosingBy'     => strtoupper($this->session->userdata('username')),
            'ClosingDate'   => date('Y-m-d H:i:s')
        );
        $this->db->trans_start();
        $this->db->where('HeaderID', $hdrID);
        $this->db->update('tblTrnCalonTenagaKerja', $data);
        $this->db->trans_complete();
    }


    function insertToBlacklistByPass($data)
    {

        $this->db->trans_start();
        $this->db->insert('tblTrnBlacklistByCancel', $data);
        $rtn = $this->db->trans_complete();

        if ($rtn) {
            return 1;
        } else {
            return 0;
        }
    }

    function getLogLoginView($userID)
    {
        $query = $this->db->query("SELECT * FROM tblUtl_LogOnline WHERE UserID='" . $userID . "' ORDER BY Tanggal DESC");
        return $query->result();
    }
    function getLogLoginViewForAdmin()
    {
        $query = $this->db->query("SELECT TOP 300 * FROM tblUtl_LogOnline ORDER BY Tanggal DESC");
        return $query->result();
    }

    function getTrans($bln, $thn)
    {
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL WHERE GeneralStatus <> '2' AND DeptID IN "
            . "(SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =" . $grupID . ") "
            . "AND YEAR(CreatedDate) = " . $thn . " AND MONTH(CreatedDate) = " . $bln . " ");
        return $query->result();
    }
    //  Ini kuubah yan
    function getTransByStatus($status, $jenis)
    {
        $grupID = $this->session->userdata('groupuser');
        // $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL WHERE Pemborong='$jenis' and GeneralStatus = '" . $status . "' AND DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =" . $grupID . ")");
        // 14/04/2025
        // $query = $this->db->query("SELECT TOP 3000 * FROM vwTrnApprovalALL WHERE Pemborong='$jenis' and GeneralStatus = '" . $status . "' AND DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =" . $grupID . ")");
        // ditambah detailid desc
        $query = $this->db->query("SELECT TOP 2000 * FROM vwTrnApprovalALL WHERE Pemborong='$jenis' and GeneralStatus = '" . $status . "' AND DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =" . $grupID . ") ORDER BY DetailID DESC");
        // sementara
        // $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL_temp_v2 WHERE Pemborong='$jenis' and GeneralStatus = '" . $status . "' AND DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara_temp_v2 WHERE GroupID =" . $grupID . ")");
        // $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL_new WHERE Pemborong='$jenis' and GeneralStatus = '" . $status . "' AND DeptID IN (SELECT DISTINCT DeptID FROM vwTrnDeptWawancara_temp WHERE GroupID =" . $grupID . ")");
        return $query->result();
    }
    //  Ini kuubah yan
    function getTransByStatusPending($jenis)
    {
        $grupID = $this->session->userdata('groupuser');
        // var_dump($grupID); die;
        // echo "SELECT DISTINCT * FROM vwTrnApprovalALL WHERE Pemborong='$jenis' and GeneralStatus Is NULL AND DeptID IN "
        //         . "(SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =".$grupID.") ";
        // $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL_new WHERE Pemborong='$jenis' and GeneralStatus Is NULL AND DeptID IN " . "(SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =" . $grupID . ")");
        // sementara, untuk menampilkan dept rmp
        // $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL_temp_v2 WHERE Pemborong='$jenis' and GeneralStatus Is NULL AND DeptID IN "
        //     . "(SELECT DISTINCT DeptID FROM vwTrnDeptWawancara_temp_v2 WHERE GroupID =" . $grupID . ")");
        $query = $this->db->query("SELECT DISTINCT * FROM vwTrnApprovalALL WHERE Pemborong='$jenis' and GeneralStatus Is NULL AND DeptID IN "
            . "(SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =" . $grupID . " AND tipe = '$jenis')");

        return $query->result();
    }

    //========= Start to View Docs =========
    function getListViewDocs()
    {
        // $query = $this->db->get(array('vwListBerkas'));
        //maks sampai 3600
        $query = $this->db->query("SELECT TOP(1000) * FROM vwListBerkas ORDER BY HdrID DESC");
        // $query = $this->db->query("select * from vwListBerkas where nama like '%tengku%'");
        return $query->result();
    }
    function getDocs($userID)
    {
        $query = $this->db->query("SELECT *,KK as KKK FROM tblTrnBerkas WHERE HeaderID='" . $userID . "'");
        return $query->result();
    }
    //========= END to View Docs ==========

    function tenakerTanggal($datea, $datez)
    {
        $query = $this->db->query("SELECT TOP(1000) * FROM vwListBerkas WHERE RegisteredDate BETWEEN '" . $datea . "' AND '" . $datez . "' ORDER BY HeaderID DESC");
        return $query->result();
    }

    function tenakerVerifi()
    {
        $query = $this->db->query("SELECT TOP(1000) * FROM vwListBerkas WHERE Verified = 0 ORDER BY HeaderID DESC");
        return $query->result();
    }

    function tenakerProses()
    {
        $query = $this->db->query("SELECT TOP(1000) * FROM vwListBerkas WHERE PostingData = 0 AND GeneralStatus = 0 ORDER BY HeaderID DESC");
        return $query->result();
    }

    function tenakerIdentifi()
    {
        $query = $this->db->query("SELECT TOP(1000) * FROM vwListBerkas WHERE GeneralStatus = '0' AND Verified = '1' AND DeptTujuan IS NULL ORDER BY HeaderID DESC");
        return $query->result();
    }

    function tenakerBelumPosting()
    {
        $query = $this->db->query("SELECT TOP(1000) * FROM vwListBerkas WHERE SpecialScreening IS NOT NULL AND PostingData IS NULL ORDER BY HeaderID DESC");
        return $query->result();
    }

    function tenakerClosed()
    {
        $query = $this->db->query("SELECT TOP(1000) * FROM vwListBerkas WHERE GeneralStatus = 1 ORDER BY HeaderID DESC");
        return $query->result();
    }


    //================ to Excel ==================
    function toExcelSemua()
    {
        $query = $this->db->query("SELECT TOP(1000) * FROM tblTrnCalonTenagaKerja ORDER BY HeaderID DESC");
        return $query->result();
    }
    function toExcelVerifi()
    {
        $query = $this->db->query("SELECT TOP(1000) * FROM tblTrnCalonTenagaKerja WHERE Verified = 0 ORDER BY HeaderID DESC");
        return $query->result();
    }
    function toExcelProses()
    {
        $query = $this->db->query("SELECT TOP(1000) * FROM tblTrnCalonTenagaKerja WHERE PostingData = 0 AND GeneralStatus = 0 ORDER BY HeaderID DESC");
        return $query->result();
    }
    function toExcelIdentifi()
    {
        $query = $this->db->query("SELECT TOP(1000) * FROM tblTrnCalonTenagaKerja WHERE GeneralStatus = '0' AND Verified = '1' AND DeptTujuan IS NULL ORDER BY HeaderID DESC");
        return $query->result();
    }
    function toExcelClosed()
    {
        $query = $this->db->query("SELECT TOP(1000) * FROM tblTrnCalonTenagaKerja WHERE GeneralStatus = 1 ORDER BY HeaderID DESC");
        return $query->result();
    }

    //========== FOR PEMBORONG =================
    function listByPBR($idpemborong, $dataselect, $tanggal)
    {

        if ($idpemborong > 0) {

            // $query = $this->db->query("SELECT TOP(1000) * FROM vwListTenakerForPemborong WHERE PostingData = 0 AND "
            //     . "CVNama IN (SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) ");
            switch ($dataselect) {
                case 'proses':
                    $con = "AND Proses = 'proses' AND CONVERT(date, DiprosesDate) = '$tanggal'";
                    break;
                case 'belum_bisa_proses':
                    $con = "AND Proses = 'belum' AND CONVERT(date, DiprosesDate) = '$tanggal'";
                    break;
                case 'interview':
                    $con = "AND JadwalInterview IS NOT NULL AND CONVERT(date, JadwalInterview) = '$tanggal'";
                    break;
                    // case 'mcu':
                    //     $con = "AND JadwalInterview IS NOT NULL AND CASE WHEN (DATEPART( WEEKDAY, CAST ( DATEADD( DAY, 1, b.CreatedDate ) AS DATE ) ) ) = 1 THEN
                    //     CONVERT ( DATE, CAST ( DATEADD( DAY, 2, b.CreatedDate ) AS DATE ) )  ELSE CONVERT ( DATE, CAST ( DATEADD( DAY, 1, b.CreatedDate ) AS DATE ) ) 
                    // END = '$tanggal'";
                    //     break;
                case 'mcu':
                    $con = "AND JadwalInterview IS NOT NULL AND CASE WHEN (DATEPART( WEEKDAY, CAST ( DATEADD( DAY, 1, a.SpecialScreeningDate ) AS DATE ) ) ) = 1 THEN
                    CONVERT ( DATE, CAST ( DATEADD( DAY, 2, a.SpecialScreeningDate ) AS DATE ) )  ELSE CONVERT ( DATE, CAST ( DATEADD( DAY, 1, a.SpecialScreeningDate ) AS DATE ) ) 
                    END =  '$tanggal'";
                    break;
                case 'blacklist':
                    $con = "AND A.KeteranganKirim IN ('blacklist','blacklist_2_bln' )";
                    break;
                default:
                    $con = '';
                    break;
            }

            $query = $this->db->query(" WITH t1 AS (SELECT a.*,
                                            b.CreatedDate as TanggalPosting,
                                            c.HeaderID as CheaderID,
                                            c.apvdokterby,
                                            CAST(DATEADD(DAY, 1, b.CreatedDate) AS DATE) AS TanggalSetelahPosting,
                                            CAST(DATEADD(DAY, 1, a.SpecialScreeningDate) AS DATE) AS TanggalSetelahScreening,

                                            -- CASE
                                            --     WHEN DATEPART(WEEKDAY, CAST(DATEADD(DAY, 1, b.CreatedDate) AS DATE)) = 1 THEN 1
                                            --     ELSE 0
                                            -- END AS HariMinggu
                                            CASE
                                                -- WHEN DATEPART(WEEKDAY, CAST(DATEADD(DAY, 1, b.CreatedDate) AS DATE)) = 1 THEN 1
                                                WHEN DATEPART(WEEKDAY, CAST(DATEADD(DAY, 1, a.SpecialScreeningDate) AS DATE)) = 1 THEN 1

                                                ELSE 0
                                            END AS HariMinggu
                                        FROM
                                            PSGRekrutmen.dbo.vwListTenakerForPemborong AS A
                                            LEFT JOIN PSGRekrutmen.dbo.tblTrnPosting AS B ON A.HeaderID = B.HeaderID
                                            LEFT JOIN PSGKlinik.dbo.tbl_kk_MstMedicalTemporaryTKNew AS C ON B.HeaderID = C.HeaderID  WHERE ( CVNama IN ( SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) OR CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) )  $con)
                                            
                                        SELECT TOP(1000) T1.*,
                                                Libur.libur AS Libur
                                            FROM
                                                t1 AS T1
                                             --   LEFT JOIN [192.168.3.32].PSGborongan.dbo.tblMstSetHariLiburDtl AS Libur ON T1.TanggalSetelahPosting = Libur.tanggal
                                             LEFT JOIN [192.168.3.32].PSGborongan.dbo.tblMstSetHariLiburDtl AS Libur ON T1.TanggalSetelahScreening = Libur.tanggal

                                        ORDER BY HeaderID DESC");
        } else {

            switch ($dataselect) {
                case 'proses':
                    $con = "WHERE Proses = 'proses' AND CONVERT(date, DiprosesDate) = '$tanggal'";
                    break;
                case 'proses_all':
                    $con = "WHERE Proses = 'proses' AND CONVERT(date, JadwalInterview) is null AND b.CreatedDate is null ";
                    break;
                case 'belum_bisa_proses':
                    $con = "WHERE Proses = 'belum' AND CONVERT(date, DiprosesDate) = '$tanggal'";
                    break;
                case 'interview':
                    $con = "WHERE JadwalInterview IS NOT NULL AND CONVERT(date, JadwalInterview) = '$tanggal'";
                    break;
                    // case 'mcu':
                    //     $con = "WHERE JadwalInterview IS NOT NULL AND CASE WHEN (DATEPART( WEEKDAY, CAST ( DATEADD( DAY, 1, b.CreatedDate ) AS DATE ) ) ) = 1 THEN
                    //     CONVERT ( DATE, CAST ( DATEADD( DAY, 2, b.CreatedDate ) AS DATE ) )  ELSE CONVERT ( DATE, CAST ( DATEADD( DAY, 1, b.CreatedDate ) AS DATE ) ) 
                    //     END =  '$tanggal'";
                    //     break;
                case 'mcu':
                    $con = "WHERE JadwalInterview IS NOT NULL AND CASE WHEN (DATEPART( WEEKDAY, CAST ( DATEADD( DAY, 1, a.SpecialScreeningDate ) AS DATE ) ) ) = 1 THEN
                    CONVERT ( DATE, CAST ( DATEADD( DAY, 2, a.SpecialScreeningDate ) AS DATE ) )  ELSE CONVERT ( DATE, CAST ( DATEADD( DAY, 1, a.SpecialScreeningDate ) AS DATE ) ) 
                    END =  '$tanggal'";
                    break;
                case 'blacklist':
                    $con = "WHERE A.KeteranganKirim = 'blacklist' OR A.KeteranganKirim = 'blacklist_2_bln'";
                    break;
                default:
                    $con = '';
                    break;
            }

            $query = $this->db->query(" WITH t1 AS ( SELECT a.*,
                                            b.CreatedDate as TanggalPosting,
                                            c.HeaderID as CheaderID,
                                            c.apvdokterby,
                                            CAST(DATEADD(DAY, 1, b.CreatedDate) AS DATE) AS TanggalSetelahPosting,
                                            CAST(DATEADD(DAY, 1, a.SpecialScreeningDate) AS DATE) AS TanggalSetelahScreening,
                                            -- CASE
                                            --     WHEN DATEPART(WEEKDAY, CAST(DATEADD(DAY, 1, b.CreatedDate) AS DATE)) = 1 THEN 1
                                            --     ELSE 0
                                            -- END AS HariMinggu
                                            CASE
                                                -- WHEN DATEPART(WEEKDAY, CAST(DATEADD(DAY, 1, b.CreatedDate) AS DATE)) = 1 THEN 1
                                                WHEN DATEPART(WEEKDAY, CAST(DATEADD(DAY, 1, a.SpecialScreeningDate) AS DATE)) = 1 THEN 1
                                                ELSE 0
                                            END AS HariMinggu
                                        FROM
                                            PSGRekrutmen.dbo.vwListTenakerForPemborong AS A
                                            LEFT JOIN PSGRekrutmen.dbo.tblTrnPosting AS B ON A.HeaderID = B.HeaderID
                                            LEFT JOIN PSGKlinik.dbo.tbl_kk_MstMedicalTemporaryTKNew AS C ON B.HeaderID = C.HeaderID $con)

                                        SELECT TOP(1000) T1.*,
                                                    Libur.libur AS Libur
                                                FROM
                                                    t1 AS T1
                                                    -- LEFT JOIN [192.168.3.32].PSGborongan.dbo.tblMstSetHariLiburDtl AS Libur ON T1.TanggalSetelahPosting = Libur.tanggal
                                                    LEFT JOIN [192.168.3.32].PSGborongan.dbo.tblMstSetHariLiburDtl AS Libur ON T1.TanggalSetelahScreening = Libur.tanggal
                                            ORDER BY HeaderID DESC");
        }
        // $query = $this->db->query("SELECT TOP(1000) * FROM vwListTenakerForPemborong WHERE PostingData = 0 ");

        return $query->result();
    }

    function AutoMaticUpdateTK()
    {
        /**
         * Note: HeaderID 125722 adalah heaerId buatan agar query tidak error
         */
        // Start a transaction
        $this->db->trans_start();

        // Perform custom SQL query
        $sql = "WITH t1 AS (
                            SELECT
                                A.HeaderID,
                                A.UdahDiAmbil,
                                A.Nofix,
                                A.RegisteredDate,
                                CAST ( b.CreatedDate AS DATE ) AS TanggalPosting,
                                CAST ( DATEadd( DAY, 7, b.CreatedDate ) AS DATE ) AS TanggalTerakhirInputPayboro,
                                CAST ( apvdokterdate AS DATE ) TanggalAppDokter 
                            FROM
                                PSGRekrutmen.dbo.vwListTenakerForPemborong AS A
                                LEFT JOIN PSGRekrutmen.dbo.tblTrnPosting AS B ON A.HeaderID = B.HeaderID
                                LEFT JOIN PSGKlinik.dbo.tbl_kk_MstMedicalTemporaryTKNew AS C ON B.HeaderID = C.HeaderID 
                            WHERE
                                A.PostingData = 1 
                                -- AND A.Nofix IS NULL
                                AND CAST ( A.RegisteredDate AS DATE ) > '2023-07-31' 
                            ),
                            t2 AS (
                            SELECT
                                t1.HeaderID,
                                t1.UdahDiambil,
                                t1.Nofix,
                                t1.TanggalPosting,
                                t1.TanggalAppDokter,
                                t1.RegisteredDate,
                                t1.TanggalTerakhirInputPayboro,
                                DATEDIFF( DAY, t1.TanggalPosting, GETDATE( ) ) AS dayDiff 
                            FROM
                                t1 
                            ),
                            t3 AS (
                            SELECT
                                *,
                            CASE
                                    
                                    WHEN t2.dayDiff > 8 
                                    AND t2.UdahDiambil = 0 
                                    AND Nofix IS NULL 
                                    AND t2.TanggalAppDokter IS NULL THEN
                                        'Update' ELSE 'Dont' 
                                    END AS canUpdate 
                                FROM
                                    t2 
                                ) UPDATE PSGRekrutmen.dbo.tblTrnCalonTenagaKerja 
                                SET PostingData = 0,
                                StatusDaftar = NULL,
                                KeteranganKirim = NULL,
                                Proses = NULL,
                                JadwalInterview = NULL 
                        WHERE
                            HeaderID IN ( SELECT HeaderID FROM t3 WHERE canUpdate = 'Update')";
        // HeaderID IN ( SELECT ISNULL(HeaderID, 125722) FROM t3 WHERE canUpdate = 'Update'  ) OR HeaderID = 125722";
        $this->db->query($sql);

        // Commit the transaction
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            // An error occurred, so roll back the transaction
            $this->db->trans_rollback();
            return FALSE;
        } else {
            // All operations were successful, so commit the transaction
            return TRUE;
        }
    }

    // ======= NEW MONITOR TENAGA KERJA =======
    // All Kenaker
    function selectAllTenaker($start, $end)
    {
        //$query = $this->db->query("SELECT * FROM vwTestPaging WHERE Row >= ".$start." AND Row <= ".$end." ");
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, " . "* FROM vwListBerkas AS tbl ) vwListBerkas WHERE Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }
    function countAllTenaker()
    {
        $query = $this->db->query("SELECT HeaderID FROM vwListBerkas ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    function selectAllTenakerWhere($start, $end, $pemborong, $jekel, $status, $pendidikan, $jurusan, $noreg, $nama, $thnlahir, $tipe)
    {
        if ($tipe == "K") {
            $tipe1 = "AND Pemborong LIKE '%YAO HSING%'";
        } else {
            $tipe1 = "AND Pemborong NOT LIKE '%YAO HSING%'";
        }
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
            . "* FROM vwListBerkas AS tbl WHERE Pemborong LIKE '%" . $pemborong . "%' AND Jenis_Kelamin LIKE '%" . $jekel . "%' AND "
            . "Status_Personal LIKE '%" . $status . "%' AND Pendidikan LIKE '%" . $pendidikan . "%' AND Jurusan LIKE '%" . $jurusan . "%' AND "
            . "HeaderID LIKE '%" . $noreg . "%' AND Nama LIKE '%" . $nama . "%' AND Tgl_lahir LIKE '%" . $thnlahir . "%' " . $tipe1 . ") "
            . "vwListBerkas WHERE  Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }
    function countAllTenakerWhere($pemborong, $jekel, $status, $pendidikan, $jurusan, $noreg, $nama)
    {
        $query = $this->db->query("SELECT HeaderID FROM vwListBerkas WHERE Pemborong LIKE '%" . $pemborong . "%' AND "
            . "Jenis_Kelamin LIKE '%" . $jekel . "%' AND Status_Personal LIKE '%" . $status . "%' AND Pendidikan LIKE '%" . $pendidikan . "%' AND "
            . "HeaderID LIKE '%" . $noreg . "%' AND Nama LIKE '%" . $nama . "%' AND "
            . "Jurusan LIKE '%" . $jurusan . "%' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    // On Proccess Tenaker
    function selectOnProccessTenaker($start, $end)
    {
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, * "
            . "FROM vwListBerkas AS tbl WHERE PostingData = 0 AND GeneralStatus = 0) vwListBerkas "
            . "WHERE Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }
    function countOnProccessTenaker()
    {
        $query = $this->db->query("SELECT HeaderID FROM vwListBerkas WHERE PostingData = 0 AND GeneralStatus = 0 ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    function selectOnProccessTenakerWhere($start, $end, $pemborong, $jekel, $status, $pendidikan, $jurusan, $noreg, $nama, $thnlahir, $tipe)
    {
        if ($tipe == "K") {
            $tipe1 = "AND Pemborong LIKE '%YAO HSING%'";
        } else {
            $tipe1 = "AND Pemborong NOT LIKE '%YAO HSING%'";
        }
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, * FROM vwListBerkas AS tbl "
            . "WHERE PostingData = 0 AND GeneralStatus = 0 AND Pemborong LIKE '%" . $pemborong . "%' AND Jenis_Kelamin LIKE '%" . $jekel . "%' AND "
            . "Status_Personal LIKE '%" . $status . "%' AND Pendidikan LIKE '%" . $pendidikan . "%' AND Jurusan LIKE '%" . $jurusan . "%' AND "
            . "HeaderID LIKE '%" . $noreg . "%' AND Nama LIKE '%" . $nama . "%' AND Tgl_lahir LIKE '%" . $thnlahir . "%' " . $tipe1 . ") "
            . "vwListBerkas WHERE  Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }
    function countOnProccessTenakerWhere($pemborong, $jekel, $status, $pendidikan, $jurusan, $noreg, $nama)
    {
        $query = $this->db->query("SELECT HeaderID FROM vwListBerkas WHERE PostingData = 0 AND GeneralStatus = 0 AND "
            . "Pemborong LIKE '%" . $pemborong . "%' AND Jenis_Kelamin LIKE '%" . $jekel . "%' AND Status_Personal LIKE '%" . $status . "%' "
            . "AND Pendidikan LIKE '%" . $pendidikan . "%' AND HeaderID LIKE '%" . $noreg . "%' AND Nama LIKE '%" . $nama . "%' AND "
            . "Jurusan LIKE '%" . $jurusan . "%' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    // Was Close Tenaker
    function selectClosedTenaker($start, $end)
    {
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, * "
            . "FROM vwListBerkas AS tbl WHERE GeneralStatus = 1) vwListBerkas "
            . "WHERE Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }
    function countClosedTenaker()
    {
        $query = $this->db->query("SELECT HeaderID FROM vwListBerkas WHERE GeneralStatus = 1 ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    function selectClosedTenakerWhere($start, $end, $pemborong, $jekel, $status, $pendidikan, $jurusan, $noreg, $nama, $thnlahir, $tipe)
    {
        if ($tipe == "K") {
            $tipe1 = "AND Pemborong LIKE '%YAO HSING%'";
        } else {
            $tipe1 = "AND Pemborong NOT LIKE '%YAO HSING%'";
        }
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, * FROM vwListBerkas AS tbl "
            . "WHERE GeneralStatus = 1 AND Pemborong LIKE '%" . $pemborong . "%' AND Jenis_Kelamin LIKE '%" . $jekel . "%' AND "
            . "Status_Personal LIKE '%" . $status . "%' AND Pendidikan LIKE '%" . $pendidikan . "%' AND Jurusan LIKE '%" . $jurusan . "%' AND "
            . "HeaderID LIKE '%" . $noreg . "%' AND Nama LIKE '%" . $nama . "%' AND Tgl_lahir LIKE '%" . $thnlahir . "%' " . $tipe1 . ") "
            . "vwListBerkas WHERE  Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }
    function countClosedTenakerWhere($pemborong, $jekel, $status, $pendidikan, $jurusan, $noreg, $nama)
    {
        $query = $this->db->query("SELECT HeaderID FROM vwListBerkas WHERE GeneralStatus = 1 AND "
            . "Pemborong LIKE '%" . $pemborong . "%' AND Jenis_Kelamin LIKE '%" . $jekel . "%' AND Status_Personal LIKE '%" . $status . "%' "
            . "AND Pendidikan LIKE '%" . $pendidikan . "%' AND HeaderID LIKE '%" . $noreg . "%' AND Nama LIKE '%" . $nama . "%' AND "
            . "Jurusan LIKE '%" . $jurusan . "%' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    // Was Post Tenaker
    function selectPostedTenaker($start, $end)
    {
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
            . "* FROM vwTrnReportPosted AS tbl ) vwTrnReportPosted WHERE Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }
    function countPostedTenaker()
    {
        $query = $this->db->query("SELECT HeaderID FROM vwTrnReportPosted ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    function selectPostedTenakerWhere($start, $end, $pemborong, $jekel, $status, $pendidikan, $jurusan, $noreg, $nama, $thnlahir, $tipe)
    {
        if ($tipe == "K") {
            $tipe1 = "AND Pemborong LIKE '%YAO HSING%'";
        } else {
            $tipe1 = "AND Pemborong NOT LIKE '%YAO HSING%'";
        }
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
            . "* FROM vwTrnReportPosted AS tbl WHERE Pemborong LIKE '%" . $pemborong . "%' AND Jenis_Kelamin LIKE '%" . $jekel . "%' AND "
            . "Status_Personal LIKE '%" . $status . "%' AND Pendidikan LIKE '%" . $pendidikan . "%' AND Jurusan LIKE '%" . $jurusan . "%' AND "
            . "HeaderID LIKE '%" . $noreg . "%' AND Nama LIKE '%" . $nama . "%' AND Tgl_lahir LIKE '%" . $thnlahir . "%' " . $tipe1 . ") "
            . "vwTrnReportPosted WHERE  Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }
    function countPostedTenakerWhere($pemborong, $jekel, $status, $pendidikan, $jurusan, $noreg, $nama)
    {
        $query = $this->db->query("SELECT HeaderID FROM vwTrnReportPosted WHERE Pemborong LIKE '%" . $pemborong . "%' AND "
            . "Jenis_Kelamin LIKE '%" . $jekel . "%' AND Status_Personal LIKE '%" . $status . "%' AND Pendidikan LIKE '%" . $pendidikan . "%' AND "
            . "HeaderID LIKE '%" . $noreg . "%' AND Nama LIKE '%" . $nama . "%' AND "
            . "Jurusan LIKE '%" . $jurusan . "%' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }

    //===== New Report to Excel=======
    function toExcelSemuaLimitMonth($bln, $thn)
    {
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE YEAR(RegisteredDate) = " . $thn . " AND "
            . "MONTH(RegisteredDate) = " . $bln . " ORDER BY HeaderID ASC");
        return $query->result();
    }
    function reportPostedLimitDate($bulan, $tahun)
    {
        $query = $this->db->query("SELECT * FROM vwTrnReportPosted WHERE YEAR(PostedDate) = " . $tahun . " AND "
            . "MONTH(PostedDate) = " . $bulan . " ORDER BY PostedDate ASC");
        return $query->result();
    }

    function getDept()
    {
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM vwMstDepartemen_new WHERE IDDept IN "
            . "(SELECT DISTINCT DeptID FROM vwTrnDeptWawancara WHERE GroupID =" . $grupID . ") ORDER BY DeptAbbr");
        return $query->result();
    }

    function getDeptPayroll()
    {
        $q = $this->db->query("SELECT
                                * 
                                FROM
                                PSGPayroll.dbo.vwMstDepartemen WHERE
                                DeptID <> 0");
        return $q->result();
    }

    function getPekerjaan($dept)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM vwMstPekerjaanDept WHERE IDDept = '" . $dept . "'");
        return $query->result();
    }

    function getJabatan()
    {
        $query = $this->db->query("SELECT DISTINCT * FROM tblMstJabatan ORDER BY Jabatan");
        return $query->result();
    }

    function getJabatanPayroll()
    {
        $query = $this->db->query("SELECT DISTINCT * FROM PSGPayroll.dbo.tblMstJabatan WHERE JabatanID NOT IN (0,1) ORDER BY Jabatan");
        return $query->result();
    }

    function getPemborong()
    {
        $query = $this->db->query("SELECT * FROM PSGBorongan.dbo.tblMstPerusahaan ");
        return $query->result();
    }
    function getPemborongKaryawan()
    {
        $query = $this->db->query("SELECT * FROM vwMstPemborong WHERE Pemborong = 'RSUP' ");
        return $query->result();
    }

    function getStatusKawin()
    {
        $query = $this->db->get('tblMstStatusKawin');
        return $query->result();
    }

    function getPendidikan()
    {
        $query = $this->db->get('tblMstPendidikan');
        return $query->result();
    }

    function getJurusan()
    {
        $query = $this->db->get('tblMstJurusan');
        return $query->result();
    }

    function getPemborongAll()
    {
        $query = $this->db->query("SELECT * FROM vwMstPemborong ORDER BY Pemborong ASC");
        return $query->result();
    }
    function setInfoTran($id)
    {
        $query = $this->db->query("SELECT * FROM vwTrnApprovalAll WHERE DetailID = '" . $id . "'");
        return $query->result();
    }
    function setInfoTranEdit($id)
    {
        $query = $this->db->query("SELECT * FROM vwTrnApprovalAll WHERE DetailID = '" . $id . "'");
        return $query;
    }
    function updateTran($id, $data)
    {
        $this->db->trans_start();
        $this->db->where('DetailID', $id);
        $this->db->update('tblTrnRequest', $data);
        $this->db->trans_complete();
    }

    function updateket($id, $data)
    {
        $this->db->trans_start();
        $this->db->where('HeaderID', $id);
        $this->db->update('tblTrnCalonTenagaKerja', $data);
        $rtn = $this->db->trans_complete();

        if ($rtn) {
            return 1;
        } else {
            return 0;
        }
    }

    function updateKualifikasi($id, $data)
    {
        $this->db->trans_start();
        $this->db->where('HeaderID', $id);
        $this->db->update('tblTrnCalonTenagaKerja', $data);
        $rtn = $this->db->trans_complete();

        if ($rtn) {
            return 1;
        } else {
            return 0;
        }
    }

    function updateStatusCancel($id, $data)
    {
        // print_r($data);
        // die;
        $this->db->trans_start();
        $this->db->where('HeaderID', $id);
        $this->db->update('tblTrnCalonTenagaKerja', $data);
        $rtn = $this->db->trans_complete();

        if ($rtn) {
            return 1;
        } else {
            return 0;
        }
    }

    function delete($id)
    {
        //$this->db->where('DetailID',$id);
        //$this->db->delete('tblTrnRequest');
        $data = array('GeneralStatus' => 3);
        $this->db->trans_start();
        $this->db->where('DetailID', $id);
        $this->db->update('tblTrnRequest', $data);
        $this->db->trans_complete();
    }

    function getTenakerByTransID($id)
    {
        $query = $this->db->query("SELECT HeaderID,TransID,Nama FROM tblTrnCalonTenagaKerja WHERE TransID='" . $id . "' AND PostingData='0' ");
        return $query->result();
    }
    function getTenakerByTransIDALL($DetailID)
    {
        $query = $this->db->query("SELECT a.HeaderID,a.TransID,a.Nama,b.DeptAbbr,b.Pekerjaan 
                                        FROM
                                            tblTrnCalonTenagaKerja AS a
                                            JOIN vwTrnApprovalALL AS b ON a.TransID = b.DetailID 
                                        WHERE
                                            a.TransID IN (" . $DetailID . ") 
                                            AND a.PostingData= '0'");
        return $query->result();
    }
    function getTenakerByTransIDsucces($id)
    {
        $query = $this->db->query("SELECT HeaderID,TransID,Nama FROM tblTrnCalonTenagaKerja WHERE TransID=" . $id .
            " AND PostingData='1' and ClosingRemark <> 'Failed' ");
        return $query->result();
    }

    function updatecekidentifikasi($hdrid)
    {
        $data = array(
            'GeneralStatus' => False,
            'TransID'       => NULL,
            'Transaksi'     => NULL,
            'DeptTujuan'    => NULL,
            'DeptTujuan'    => NULL
        );
        $this->db->trans_start();
        $this->db->where('HeaderID', $hdrid);
        $this->db->update('tblTrnCalonTenagaKerja', $data);
        $this->db->trans_complete();
    }

    function hapuscekidentifikasi($hdrid)
    {
        $data = array(
            'GeneralStatus' => False,
            'TransID'       => NULL,
            'Transaksi'     => NULL,
            'DeptTujuan'    => NULL,
            'DeptTujuan'    => NULL
        );
        $this->db->trans_start();
        $this->db->where('HeaderID', $hdrid);
        $this->db->update('tblTrnCalonTenagaKerja', $data);
        $this->db->trans_complete();
    }

    function restoreAngkaTransaksi($transid)
    {
        $query = $this->db->query("UPDATE tblTrnRequest set TKPermintaan = (SELECT TKPermintaan FROM tblTrnRequest WHERE DetailID = '" . $transid . "')+1 WHERE DetailID = '" . $transid . "'");
        return $query->result();
    }

    function getTransa($idDetail)
    {
        $query = $this->db->query("SELECT * FROM tblTrnRequest WHERE DetailID = '" . $idDetail . "'");
        return $query->result();
    }

    function updateTrans($id, $data)
    {
        $this->db->trans_start();
        $this->db->where('DetailID', $id);
        $this->db->update('tblTrnRequest', $data);
        $this->db->trans_complete();
    }

    function SelectIdentifikasi($periode)
    {
        return $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE TransID IS NOT NULL and PostingData=0 AND SpecialJeda=0 and WawancaraHasil Is NULL AND CONVERT(DATE, SendedDate,103) = '" . $periode . "' ORDER BY HeaderID DESC")->result();
    }

    function countCalonKandidat()
    {
        $query = $this->db->query('SELECT distinct ID FROM tblTrnCalonKandidat ORDER BY ID DESC');
        return $query->num_rows();
    }

    function getCalonKandidat($start, $end)
    {
        $query = $this->db->query("SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY ID DESC) AS Row, * FROM vwTrnCalonKandidat AS tbl)vwTrnCalonKandidat WHERE Row>='" . $start . "' AND Row<='" . $end . "'");
        return $query->result();
    }

    function countCalonKandidatwhere($nama, $periode)
    {
        $query = $this->db->query("SELECT ID FROM vwCalonKandidat WHERE Nama LIKE '%" . $nama . "%' AND Periode LIKE '%" . $periode . "%' ORDER BY ID DESC");
        return $query->num_rows();
    }
    function countCalonKandidatwherenew($nama, $periode)
    {
        $query = $this->db->query("SELECT ID FROM vwTrnCalonKandidat WHERE Nama LIKE '%" . $nama . "%' AND Periode LIKE '%" . $periode . "%' ORDER BY ID DESC");
        return $query->num_rows();
    }

    function getCalonKandidatwhere($start, $end, $nama, $periode)
    {
        $query = $this->db->query("SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY ID DESC) AS Row, * FROM vwTrnCalonKandidat AS tbl WHERE Nama LIKE '%" . $nama . "%' AND Periode LIKE '%" . $periode . "%')vwTrnCalonKandidat WHERE Row>='" . $start . "' AND Row<='" . $end . "'");
        return $query->result();
    }

    function hapusCK($id)
    {
        $this->db->where('ID', $id);
        $query = $this->db->delete('tblTrnCalonKandidat');
        return $query;
    }

    function getCalonKandidatExcelAll()
    {
        $query = $this->db->query("SELECT * FROM vwCalonKandidat");
        return $query->result();
    }

    function getCalonKandidatExcelLulus()
    {
        $query = $this->db->query("SELECT * FROM vwCalonKandidat WHERE Status='L'");
        return $query->result();
    }

    function getDataTK($headerID)
    {
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE HeaderID='$headerID'");
        return $query->result();
    }

    function getCalonKandidatExcelTidakLulus()
    {
        $query = $this->db->query("SELECT * FROM vwCalonKandidat WHERE Status='TL'");
        return $query->result();
    }

    function getdataIdeal($periode)
    {
        if ($this->session->userdata('dept') == 'ITD' || $this->session->userdata('dept') == 'HRD') {
            $this->db->where('Periode', $periode);
            $this->db->order_by('DeptAbbr', 'asc');
            $query = $this->db->get('vwIdealKryTk');
            return $query->result();
        } else {
            $this->db->where('Periode', $periode);
            $this->db->where('DeptAbbr', $this->session->userdata('dept'));
            $this->db->order_by('DeptAbbr', 'asc');
            $query = $this->db->get('vwIdealKryTk');
            return $query->result();
        }
    }

    function getDetailSubPerkerjaanDeptKry($issueID)
    {
        $query = $this->db->query("SELECT JabatanName,count(JabatanName) AS TotalJabatan FROM PSGPayroll..vwMstKaryawan WHERE DeptAbbr='" . $issueID . "' and TGLKELUAR is null GROUP BY JabatanName");
        return $query;
    }

    function getDetailSubPerkerjaanDeptBor($issueID)
    {
        $query = $this->db->query("SELECT Jabatan,count(Jabatan) AS TotalJabatan FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja WHERE DeptAbbr='" . $issueID . "' and TanggalKeluar is null and TanggalKeluarTemp is null GROUP BY Jabatan");
        return $query;
    }

    function get_db_berkas($id)
    {
        return $this->db->get_where('tblTrnCalonKandidat', array('ID' => $id));
    }

    function update_db_berkas($id, $berkas, $lokasi)
    {
        $this->db->trans_start();
        $this->db->where('ID', $id);
        $this->db->update('tblTrnCalonKandidat', array($berkas => $lokasi));
        $this->db->trans_complete();
    }

    function getdatafoto($id)
    {
        // $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE HeaderID='$id'");
        // return $query->result();

        $this->db->where('HeaderID', $id);
        $query = $this->db->get('tblTrnCalonTenagaKerja');
        return $query->result();
    }

    function update_status_foto($loginID)
    {
        $this->db->trans_start();
        $this->db->where('LoginID', $loginID);
        $this->db->update('tblUtlUserDetail', array('AdaPhoto' => 1));
        $this->db->trans_complete();
    }

    function getJumlahRequestK()
    {
        $tahun = date('Y');
        $th = date('Y') - 1;
        $get = $this->db->query("SELECT COUNT(DeptAbbr) AS Jumlah, SUM(TKTarget) AS jmlRequestK,SUM(TKSedia) AS jmlSuccess, SUM(TKPermintaan) AS JmlSisa FROM vwTrnApprovalAll WHERE YEAR(CreatedDate) BETWEEN '$th' AND '$tahun' AND Pemborong IN ('PSG') AND GeneralStatus IN (1)");
        return $get->result();
    }
    function getJumlahRequestTK()
    {
        $tahun = date('Y');
        $th = date('Y') - 1;
        $get = $this->db->query("SELECT COUNT(DeptAbbr) AS Jumlah, SUM(TKTarget) AS JmlRequest,SUM(TKSedia) AS JmlSuccess,SUM(TKPermintaan) AS JmlSisa FROM vwTrnApprovalAll WHERE YEAR(CreatedDate) BETWEEN '$th' AND '$tahun' AND Pemborong IN ('ALL PEMBORONG') AND GeneralStatus = 1");
        return $get->result();
    }

    function send_info($dataTel)
    {
        $this->telebot->insert("telebot.dbo.telegramoutbox_slip", $dataTel);
    }

    // === Monitoring Approval P2K3 === //
    function listTenagaKerjaP2K3($dept)
    {
        $query = $this->db->query("SELECT
                                        a.HeaderID,
                                        a.Nama,
                                        a.CVNama,
                                        a.Pemborong,
                                        a.Tgl_Lahir,
                                        a.Jenis_Kelamin,
                                        a.ScreeningComplete,
                                        a.RegisteredBy,
                                        a.RegisteredDate,
                                        a.AppDivStatus,
                                        a.DeptTujuan,
                                        a.TransID,
                                        c.Pekerjaan,
                                        a.AppP2K3Status,
                                        a.AppP2K3Date,
                                        a.AppP2K3By,
                                        a.AppP2K3Catatan,
                                    CASE
                                            
                                            WHEN b.kodedivisi = 25 THEN
                                            1 ELSE 0 
                                        END AS AppDivNeeded,
                                        a.status_p2k3,
                                        a.status_elc 
                                    FROM
                                        tblTrnCalonTenagaKerja a
                                        LEFT JOIN ( SELECT DISTINCT DeptKary, kodedivisi FROM vwMstDivisi ) b ON a.DeptTujuan = b.DeptKary
                                        LEFT JOIN vwTrnApprovalAll AS c ON a.TransID = c.DetailID 
                                    WHERE
                                        Verified = '1' 
                                        -- AND UdahDiAmbil = '0' 
                                        -- AND a.GeneralStatus = '0' 
                                        -- AND a.RegisteredDate >= '2022-01-01' 
                                        AND HeaderID NOT IN ( SELECT HeaderID FROM tblTrnScreening WHERE Dept = '$dept' ) 
                                        AND a.status_p2k3 = 1 
                                        -- AND AppP2K3Status  IN ( 0, 1 ) 
                                        -- and AppP2K3Status IS NOT NULL  
                                    ORDER BY
                                        a.HeaderID ASC");
        return $query->result();
    }
    // === Monitoring Approval HED === //
    function listTenagaKerjaHED($dept)
    {
        $query = $this->db->query("SELECT
                                    a.HeaderID,
                                    a.Nama,
                                    a.CVNama,
                                    a.Pemborong,
                                    a.Tgl_Lahir,
                                    a.Jenis_Kelamin,
                                    a.ScreeningComplete,
                                    a.RegisteredBy,
                                    a.RegisteredDate,
                                    a.AppDivStatus,
                                    a.DeptTujuan,
                                    a.TransID,
                                    c.Pekerjaan,
                                    a.AppHEDStatus,
                                    a.AppHEDDate,
                                    a.AppHEDBy,
                                    a.AppHEDCatatan,
                                    CASE
                                        
                                        WHEN b.kodedivisi = 25 THEN
                                        1 ELSE 0 
                                    END AS AppDivNeeded,
                                    a.status_p2k3,
                                    a.status_elc, 
                                    a.status_hed 
                                    FROM
                                    tblTrnCalonTenagaKerja a
                                    LEFT JOIN (SELECT DISTINCT DeptKary, kodedivisi FROM vwMstDivisi) b ON a.DeptTujuan = b.DeptKary
                                    LEFT JOIN vwTrnApprovalAll AS c ON a.TransID = c.DetailID 
                                    WHERE
                                    Verified = '1'  
                                    AND HeaderID NOT IN (SELECT HeaderID FROM tblTrnScreening WHERE Dept = '$dept') 
                                    AND a.status_hed = 1 
                                    ORDER BY
                                    a.HeaderID ASC");
        return $query->result();
    }


    // === Pengecekan === //

    //cek TK dalam Black List atau Tidak
    function cekTK()
    {
        return $this->db->query("select * from tblTrnBlacklist where ((BlackListDuaBulan = 1 
                                and DATEDIFF(month, created_date,GETDATE()) < 6) or (BlackListDuaBulan is null and Status = 'Blacklist'))")->result();
    }


    function cekRegInTempSamePemborong($tglLahir, $namaIbu, $namaAyah, $pemborong)
    {
        $query = $this->db->query("SELECT Nama,NamaIbuKandung,Tgl_Lahir,NamaBapak  FROM vw_cekTKRequestPayBoro "
            . "WHERE (Pemborong = '" . $pemborong . "' AND NamaIbuKandung = '" . $namaIbu . "' AND Tgl_Lahir = '" . $tglLahir . "' AND (DateDiff(DAY,TanggalKeluarTemp,GETDATE()) < 31  or DateDiff(DAY,TanggalKeluar,GETDATE()) < 31)) "
            . "OR (Pemborong = '" . $pemborong . "' AND NamaBapak = '" . $namaAyah . "' AND Tgl_Lahir = '" . $tglLahir . "' AND (DateDiff(DAY,TanggalKeluarTemp,GETDATE()) < 31  or DateDiff(DAY,TanggalKeluar,GETDATE()) < 31)) "
            . "OR (Pemborong = '" . $pemborong . "' AND NamaIbuKandung = '" . $namaIbu . "' AND NamaBapak = '" . $namaAyah . "' AND (DateDiff(DAY,TanggalKeluarTemp,GETDATE()) < 31  or DateDiff(DAY,TanggalKeluar,GETDATE()) < 31))");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function cekRegInTempDiffPemborong($tglLahir, $namaIbu, $namaAyah, $pemborong)
    {
        $query = $this->db->query("SELECT Nama,NamaIbuKandung,Tgl_Lahir,NamaBapak  FROM vw_cekTKRequestPayBoro "
            . "WHERE (Pemborong != '" . $pemborong . "' AND NamaIbuKandung = '" . $namaIbu . "' AND Tgl_Lahir = '" . $tglLahir . "' AND (DateDiff(MONTH,TanggalKeluarTemp,GETDATE()) <= 3  or DateDiff(MONTH,TanggalKeluar,GETDATE()) <= 3)) "
            . "OR (Pemborong != '" . $pemborong . "' AND NamaBapak = '" . $namaAyah . "' AND Tgl_Lahir = '" . $tglLahir . "' AND (DateDiff(MONTH,TanggalKeluarTemp,GETDATE()) <= 3  or DateDiff(MONTH,TanggalKeluar,GETDATE()) <= 3)) "
            . "OR (Pemborong != '" . $pemborong . "' AND NamaIbuKandung = '" . $namaIbu . "' AND NamaBapak = '" . $namaAyah . "' AND (DateDiff(MONTH,TanggalKeluarTemp,GETDATE()) <= 3  or DateDiff(MONTH,TanggalKeluar,GETDATE()) <= 3))");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    private function _get_dataTenakerNew_query()
    {

        $this->db->select("*", false);
        if ((isset($_POST['selDataFilter']) && !empty($_POST['selDataFilter']) && $_POST['selDataFilter'] != '') && $_POST['selDataFilter'] == '3') {
            $this->db->from('vwTrnReportPosted');
        } else {
            $this->db->from($this->table_tenaker_new);
        }

        $i = 0;

        foreach ($this->column_search_listberkas as $item) // loop column 
        {

            if (isset($_POST['search']['value'])) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search_listberkas) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['pemborong']) && !empty($_POST['pemborong']) && $_POST['pemborong'] != '') {
            $this->db->like('Pemborong', $_POST['pemborong']);
        }

        if (isset($_POST['pendidikan']) && !empty($_POST['pendidikan']) && $_POST['pendidikan'] != '') {
            $this->db->like('Pendidikan', $_POST['pendidikan']);
        }


        if (isset($_POST['tipePekerja']) && !empty($_POST['tipePekerja'])) {
            if ($_POST['tipePekerja'] == "K") {
                $this->db->like('Pemborong', 'PT PULAU SAMBU');
            } else {
                $this->db->not_like('Pemborong', 'PT PULAU SAMBU');
            }
        }

        if (isset($_POST['noreg']) && !empty($_POST['noreg']) && $_POST['noreg'] != '') {
            $this->db->where('HeaderID', $_POST['noreg']);
        }

        if (isset($_POST['gender']) && !empty($_POST['gender']) && $_POST['gender'] != '') {
            $this->db->where('Jenis_Kelamin', $_POST['gender']);
        }

        if (isset($_POST['jurusan']) && !empty($_POST['jurusan']) && $_POST['jurusan'] != '') {
            $this->db->where('Jurusan', $_POST['jurusan']);
        }

        if (isset($_POST['nama']) && !empty($_POST['nama']) && $_POST['nama'] != '') {
            $this->db->like('Nama', $_POST['nama']);
        }

        if (isset($_POST['statusPersonal']) && !empty($_POST['statusPersonal']) && $_POST['statusPersonal'] != '') {
            $this->db->like('Status_Personal', $_POST['statusPersonal']);
        }

        if (isset($_POST['tglLahir']) && !empty($_POST['tglLahir']) && $_POST['tglLahir'] != '') {
            $this->db->like('Tgl_lahir', $_POST['tglLahir']);
        }

        if ((isset($_POST['selDataFilter']) && !empty($_POST['selDataFilter']) && $_POST['selDataFilter'] != '') && $_POST['selDataFilter'] == '1') {
            $this->db->where('PostingData', 0);
            $this->db->where('GeneralStatus', 0);
        } elseif ((isset($_POST['selDataFilter']) && !empty($_POST['selDataFilter']) && $_POST['selDataFilter'] != '') && $_POST['selDataFilter'] == '2') {
            $this->db->where('GeneralStatus', 1);
        }



        // if (isset($_POST['order'])) // here order processing
        // {
        //     // print_r($this->column_order_listberkas[$_POST['order']['0']['column']]);
        //     // print_r($_POST['order']['0']['dir']);
        //     // die;
        //     $this->db->order_by($this->column_order_listberkas[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        // } else if (isset($this->order_list_berkas)) {
        //     $order = $this->order_list_berkas;
        //     $this->db->order_by(key($order), $order[key($order)]);
        // }


        // Offset untuk membatasi jumlah data yang ditampilkan
        if (isset($_POST['start']) && isset($_POST['length'])) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        if (isset($_POST['order']) && count($_POST['order'])) {
            $order_col_index = $_POST['order'][0]['column'];
            $order_col_name = $this->column_order_listberkas[$order_col_index];
            $order_dir = $_POST['order'][0]['dir'];
            $this->db->order_by($order_col_name, $order_dir);
        } else {
            // Jika tidak ada parameter sortir, gunakan pengaturan sortir default
            $order = $this->order_list_berkas;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    private function _get_dataTenakerNew_query2()
    {
        if ((isset($_POST['selDataFilter']) && !empty($_POST['selDataFilter']) && $_POST['selDataFilter'] != '') && $_POST['selDataFilter'] == '3') {
            $table = 'vwTrnReportPosted';
        } else {
            $table = $this->table_tenaker_new;
        }

        // Subquery menggunakan Query Builder dengan TOP 100 PERCENT
        $subquery = $this->db
            ->select('*', false)
            ->from($table);
        // ->from($table . 'a');

        if ($this->session->userdata('userid') == 'KIKI' || $this->session->userdata('userid') == 'kiki') {
            // $subquery = $this->db->query("SELECT
            //                             A.* ,
            //                             B.DeptAbbr, B.BagianAbbr, B.ResignRemark, B.TanggalKeluar
            //                         FROM
            //                             vwTrnReportPosted A
            //                             LEFT JOIN [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja_TEST B ON A.Nofix = B.FixNo");
        }

        // $subquery =  $this->db->select('A.*, B.DeptAbbr, B.BagianAbbr, B.ResignRemark, B.TanggalKeluar', false)
        //     ->from($table . ' AS A')
        //     ->join('[192.168.3.32].[PSGBorongan].[dbo].[vwMstTenagaKerja_TEST]  AS B', ' A.Nofix = B.FixNo ', 'left');






        $i = 0;
        foreach ($this->column_search_listberkas as $item) {
            if (isset($_POST['search']['value'])) {
                if ($i === 0) {
                    $this->db->group_start();
                    $subquery->like($item, $_POST['search']['value']);
                } else {
                    $subquery->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search_listberkas) - 1 == $i) {
                    $subquery->group_end();
                }
            }
            $i++;
        }

        if (isset($_POST['pemborong']) && !empty($_POST['pemborong']) && $_POST['pemborong'] != '') {
            $subquery->like('Pemborong', $_POST['pemborong']);
        }

        if (isset($_POST['pendidikan']) && !empty($_POST['pendidikan']) && $_POST['pendidikan'] != '') {
            $subquery->like('Pendidikan', $_POST['pendidikan']);
        }

        if (isset($_POST['tipePekerja']) && !empty($_POST['tipePekerja'])) {
            if ($_POST['tipePekerja'] == "K") {
                $subquery->like('Pemborong', 'PT PULAU SAMBU');
            } else {
                $subquery->not_like('Pemborong', 'PT PULAU SAMBU');
            }
        }

        if (isset($_POST['noreg']) && !empty($_POST['noreg']) && $_POST['noreg'] != '') {
            $subquery->where('HeaderID', $_POST['noreg']);
        }

        if (isset($_POST['gender']) && !empty($_POST['gender']) && $_POST['gender'] != '') {
            $subquery->where('Jenis_Kelamin', $_POST['gender']);
        }

        if (isset($_POST['jurusan']) && !empty($_POST['jurusan']) && $_POST['jurusan'] != '') {
            $subquery->where('Jurusan', $_POST['jurusan']);
        }

        if (isset($_POST['nama']) && !empty($_POST['nama']) && $_POST['nama'] != '') {
            $subquery->like('Nama', $_POST['nama']);
        }
        if (isset($_POST['inputKtp']) && !empty($_POST['inputKtp']) && $_POST['inputKtp'] != '') {
            $subquery->where('No_Ktp', $_POST['inputKtp']);
        }

        if (isset($_POST['statusPersonal']) && !empty($_POST['statusPersonal']) && $_POST['statusPersonal'] != '') {
            $subquery->like('Status_Personal', $_POST['statusPersonal']);
        }

        if (isset($_POST['tglLahir']) && !empty($_POST['tglLahir']) && $_POST['tglLahir'] != '') {
            $subquery->like('Tgl_lahir', $_POST['tglLahir']);
        }

        if ((isset($_POST['selDataFilter']) && !empty($_POST['selDataFilter']) && $_POST['selDataFilter'] != '') && $_POST['selDataFilter'] == '1') {
            $subquery->where('PostingData', 0);
            $subquery->where('GeneralStatus', 0);
        } elseif ((isset($_POST['selDataFilter']) && !empty($_POST['selDataFilter']) && $_POST['selDataFilter'] != '') && $_POST['selDataFilter'] == '2') {
            $subquery->where('GeneralStatus', 1);
        }
        // Offset untuk membatasi jumlah data yang ditampilkan
        if (isset($_POST['start']) && isset($_POST['length'])) {
            $subquery->limit($_POST['length'], $_POST['start']);
        }

        // $subquery->group_start();  // Start grouping of where clauses
        // $subquery->where('KeteranganKirim !=', 'blacklist');
        // $subquery->where('KeteranganKirim !=', 'blacklist_2_bln');
        // $subquery->or_where('KeteranganKirim IS NULL');
        // $subquery->group_end();  // End grouping of where clauses
        // $subquery->limit(10, 0);

        $subquery = $subquery->order_by('HeaderID', 'DESC')->get_compiled_select();

        // Gunakan subquery sebagai derived table
        $this->db->select('*', false);
        $this->db->from("($subquery) as SortedData", false);


        if (isset($_POST['order']) && count($_POST['order'])) {
            $order_col_index = $_POST['order'][0]['column'];
            $order_col_name = $this->column_order_listberkas[$order_col_index];
            $order_dir = $_POST['order'][0]['dir'];
            $this->db->order_by($order_col_name, $order_dir);
        } else {
            // Jika tidak ada parameter sortir, gunakan pengaturan sortir default
            $order = $this->order_list_berkas;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_dataTenakerNew()
    {
        $this->_get_dataTenakerNew_query2();
        // if ($_POST['length'] != -1)
        //     $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_tenaker_new()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_tenaker_new()
    {
        if (isset($_POST['selDataFilter']) && $_POST['selDataFilter'] == '3') {
            $table = 'vwTrnReportPosted';
        } else {
            $table = 'vwListBerkas';
        }
        return $this->db->from($table)
            ->count_all_results();
    }

    public function column_exists($table, $column)
    {
        $query = $this->db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table' AND COLUMN_NAME = '$column'");
        return $query->num_rows() > 0;
    }


    // private function _get_datatables_query_list_for_pbr($table)
    // {

    //     $idpemborong = $this->session->userdata('idpemborong');
    //     // $idpemborong = 13;

    //     if ($idpemborong > 0) {
    //         $this->db->where("( CVNama IN ( SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) OR CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) )");
    //     }

    //     $this->db->select('A.*, A.HeaderID as ID, B.*');
    //     if (isset($_POST['selTenaker']) && $_POST['selTenaker'] == 'mcu') {
    //         $this->db->from('tblTrnCalonTenagaKerja' . ' AS A');
    //     } else {
    //         $this->db->from($table . ' AS A');
    //     }
    //     $this->db->join('PSGKlinik.dbo.tbl_kk_MstMedicalTemporaryTKNew AS B', 'A.HeaderID = B.HeaderID ', 'left');
    //     $this->db->limit(800);
    //     // limit dari 1000 ke 900 25/03/2025


    //     $i = 0;

    //     foreach ($this->column_search_list_for_pbr as $item) // loop column 
    //     {
    //         if ($_POST['search']['value']) // if datatable sends POST for search
    //         {
    //             if ($item == 'date_time') {


    //                 $search_value = $_POST['search']['value'];
    //                 $this->db->or_where("TO_CHAR($item, 'YYYY-MM-DD') LIKE", "'%$search_value%'", false);
    //             } else {

    //                 if ($i === 0) // first loop
    //                 {
    //                     $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
    //                     $this->db->like($item, $_POST['search']['value']);
    //                 } else {
    //                     $this->db->or_like($item, $_POST['search']['value']);
    //                 }
    //             }
    //             if (count($this->column_search_list_for_pbr) - 1 == $i)  //last loop
    //                 $this->db->group_end(); //close bracket
    //         }
    //         $i++;
    //     }

    //     if (isset($_POST['selTenaker']) && $_POST['selTenaker'] != '') {

    //         if (isset($_POST['tanggal']) && $_POST['tanggal'] != '') {
    //             $tanggal = date('Y-m-d', strtotime($_POST['tanggal']));
    //         } else {
    //             $tanggal = '';
    //         }

    //         switch ($_POST['selTenaker']) {
    //             case 'proses':
    //                 $this->db->where("Proses", "proses");
    //                 $this->db->where("KeteranganKirim", "");
    //                 if ($tanggal) {
    //                     $this->db->where("CONVERT(date, DiprosesDate) =", $tanggal);
    //                 }
    //                 break;
    //             case 'proses_all':
    //                 $this->db->where("Proses", "proses");
    //                 $this->db->where("CONVERT(date, JadwalInterview) IS NULL");
    //                 // $this->db->where("b.CreatedDate IS NULL", NULL, FALSE);
    //                 break;
    //             case 'belum_bisa_proses':
    //                 $this->db->where("Proses", "belum");
    //                 // $this->db->where("CONVERT(date, DiprosesDate) =", $tanggal);
    //                 if ($tanggal) {
    //                     $this->db->where("CONVERT(date, DiprosesDate) =", $tanggal);
    //                 }
    //                 break;
    //             case 'interview':
    //                 $this->db->where("JadwalInterview IS NOT NULL");
    //                 if ($tanggal) {
    //                     $this->db->where("CONVERT(date, JadwalInterview) =", $tanggal);
    //                 }
    //                 break;
    //             case 'mcu':
    //                 // $this->db->where("tanggal_mcu IS NOT NULL");
    //                 $this->db->where("mcu_date IS NOT NULL");
    //                 $this->db->where("JadwalInterview IS NULL");
    //                 if ($tanggal) {
    //                     $this->db->where("CONVERT(date, mcu_date) =", $tanggal);
    //                 }
    //                 break;
    //             case 'blacklist':
    //                 $this->db->where_in("A.KeteranganKirim", array('blacklist', 'blacklist_2_bln'));
    //                 break;
    //             case 'id_lama':
    //                 $this->db->where("JadwalInterview IS NULL");
    //                 $this->db->where("tanggal_mcu IS NULL");
    //                 $this->db->where("KeteranganKirim IS NULL");
    //                 $this->db->where("WawancaraKe IS NULL");
    //                 $this->db->where("apvdokterby IS NULL");
    //                 $this->db->where("Nofix IS NULL");
    //                 $this->db->where('DATEDIFF(month, A.RegisteredDate, GETDATE()) >=', 3);
    //                 break;
    //             default:
    //                 break;
    //         }
    //     }
    //     // $this->db->group_start();  // Start grouping of where clauses
    //     // $this->db->where('KeteranganKirim !=', 'blacklist');
    //     // $this->db->where('KeteranganKirim !=', 'blacklist_2_bln');
    //     // $this->db->or_where('KeteranganKirim IS NULL');
    //     // $this->db->group_end();  // End grouping of where clauses

    //     if (isset($_POST['order'])) // here order processing
    //     {
    //         $this->db->order_by($this->column_order_list_for_pbr[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    //     } else if (isset($this->column_order_list_for_pbr)) {
    //         $order = $this->order_list_for_pbr;
    //         $this->db->order_by(key($order), $order[key($order)]);
    //     }
    // }


    // public function get_datatables_list_for_pbr($table)
    // {
    //     $this->_get_datatables_query_list_for_pbr($table);
    //     if ($_POST['length'] != -1)
    //         $this->db->limit($_POST['length'], $_POST['start']);
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    // public function count_filtered_list_for_pbr($table)
    // {
    //     $this->_get_datatables_query_list_for_pbr($table);
    //     $query = $this->db->get();
    //     return $query->num_rows();
    // }

    // public function count_all_list_for_pbr($table)
    // {
    //     return $this->db->from($table)
    //         ->count_all_results();
    // }

    private function _get_datatables_query_list_for_pbr($table)
    {
        $idpemborong = $this->session->userdata('idpemborong');

        if ($idpemborong > 0) {
            $this->db->where("( CVNama IN ( SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) OR CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) )");
        }

        // Select hanya dari A, B di-merge di PHP
        $this->db->select('A.*, A.HeaderID as ID');

        if (isset($_POST['selTenaker']) && $_POST['selTenaker'] == 'mcu') {
            $this->db->from('tblTrnCalonTenagaKerja AS A');
        } else {
            $this->db->from($table . ' AS A');
        }

        $this->db->limit(800);

        $i = 0;
        foreach ($this->column_search_list_for_pbr as $item) {
            if ($_POST['search']['value']) {
                if ($item == 'date_time') {
                    $search_value = $_POST['search']['value'];
                    $this->db->or_where("TO_CHAR($item, 'YYYY-MM-DD') LIKE", "'%$search_value%'", false);
                } else {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, $_POST['search']['value']);
                    } else {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
                }
                if (count($this->column_search_list_for_pbr) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['selTenaker']) && $_POST['selTenaker'] != '') {

            if (isset($_POST['tanggal']) && $_POST['tanggal'] != '') {
                $tanggal = date('Y-m-d', strtotime($_POST['tanggal']));
            } else {
                $tanggal = '';
            }

            switch ($_POST['selTenaker']) {
                case 'proses':
                    $this->db->where("Proses", "proses");
                    $this->db->where("KeteranganKirim", "");
                    if ($tanggal) {
                        $this->db->where("CONVERT(date, DiprosesDate) =", $tanggal);
                    }
                    break;

                case 'proses_all':
                    $this->db->where("Proses", "proses");
                    $this->db->where("CONVERT(date, JadwalInterview) IS NULL");
                    break;

                case 'belum_bisa_proses':
                    $this->db->where("Proses", "belum");
                    if ($tanggal) {
                        $this->db->where("CONVERT(date, DiprosesDate) =", $tanggal);
                    }
                    break;

                case 'interview':
                    $this->db->where("JadwalInterview IS NOT NULL");
                    if ($tanggal) {
                        $this->db->where("CONVERT(date, JadwalInterview) =", $tanggal);
                    }
                    break;

                case 'mcu':
                    $this->db->where("mcu_date IS NOT NULL");
                    $this->db->where("JadwalInterview IS NULL");
                    if ($tanggal) {
                        $this->db->where("CONVERT(date, mcu_date) =", $tanggal);
                    }
                    break;

                case 'blacklist':
                    $this->db->where_in("A.KeteranganKirim", array('blacklist', 'blacklist_2_bln'));
                    break;

                case 'id_lama':
                    // apvdokterby sudah di-handle post-merge (karena dari sambusehat)
                    $this->db->where("JadwalInterview IS NULL");
                    $this->db->where("tanggal_mcu IS NULL");
                    $this->db->where("KeteranganKirim IS NULL");
                    $this->db->where("WawancaraKe IS NULL");
                    $this->db->where("Nofix IS NULL");
                    $this->db->where('DATEDIFF(month, A.RegisteredDate, GETDATE()) >=', 3);
                    break;

                default:
                    break;
            }
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order_list_for_pbr[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->column_order_list_for_pbr)) {
            $order = $this->order_list_for_pbr;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables_list_for_pbr($table)
    {
        $this->_get_datatables_query_list_for_pbr($table);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        $dataA = $query->result();

        // Merge dengan data medical dari sambusehat
        $merged = $this->_merge_with_pgsql_medical($dataA);

        // Post-filter untuk case id_lama (cek apvdokterby IS NULL)
        if (isset($_POST['selTenaker']) && $_POST['selTenaker'] == 'id_lama') {
            $merged = array_values(array_filter($merged, function ($row) {
                // apvdokterby IS NULL berarti: property tidak ada (header_id tidak match di B)
                // atau nilainya null
                return !isset($row->approved_dokter_by) || $row->approved_dokter_by === null;
            }));
        }

        return $merged;
    }

    public function count_filtered_list_for_pbr($table)
    {
        $this->_get_datatables_query_list_for_pbr($table);
        $query = $this->db->get();

        // Untuk id_lama, harus merge + filter dulu baru hitung
        if (isset($_POST['selTenaker']) && $_POST['selTenaker'] == 'id_lama') {
            $dataA = $query->result();
            $merged = $this->_merge_with_pgsql_medical($dataA);
            $filtered = array_filter($merged, function ($row) {
                return !isset($row->approved_dokter_by) || $row->approved_dokter_by === null;
            });
            return count($filtered);
        }

        return $query->num_rows();
    }

    public function count_all_list_for_pbr($table)
    {
        return $this->db->from($table)
            ->count_all_results();
    }

    /**
     * Merge data A dengan data medical dari PostgreSQL
     * Output sama persis seperti hasil LEFT JOIN SELECT A.*, B.*
     */
    // private function _merge_with_pgsql_medical($dataA)
    // {
    //     if (empty($dataA)) return [];

    //     $dbPgsql   = $this->load->database('sambusehat', TRUE);
    //     $headerIds = array_column($dataA, 'HeaderID');

    //     // Tentukan kolom yang mau di-expose (sesuai yg dipakai controller/view)
    //     $selectCols = 'header_id, approved_dokter_by, kesimpulan_mcu';
    //     // Tambahkan kolom lain yang dipakai:
    //     // $selectCols = 'header_id, approved_dokter_by, kesimpulan_cu, mcu_date, dst';

    //     // Daftar kolom B yg harus selalu ada di output (tanpa header_id)
    //     $bColumns = ['approved_dokter_by', 'kesimpulan_mcu'];
    //     // Sinkronkan dengan $selectCols di atas

    //     $dataB = $dbPgsql->select($selectCols)
    //         ->from('mcu_trx_medical_hdr')
    //         ->where_in('header_id', $headerIds)
    //         ->get()->result();

    //     $mapB = [];
    //     foreach ($dataB as $row) {
    //         $mapB[$row->header_id] = $row;
    //     }

    //     foreach ($dataA as &$row) {
    //         // Default semua kolom B jadi null dulu
    //         foreach ($bColumns as $k) {
    //             $row->$k = null;
    //         }
    //         // Override dengan data aktual kalau match
    //         if (isset($mapB[$row->HeaderID])) {
    //             foreach ($mapB[$row->HeaderID] as $k => $v) {
    //                 if ($k === 'header_id') continue;
    //                 $row->$k = $v;
    //             }
    //         }
    //     }
    //     unset($row);

    //     return $dataA;
    // }

    private function _merge_with_pgsql_medical($dataA)
    {
        if (empty($dataA)) return [];

        $dbPgsql   = $this->load->database('sambusehat', TRUE);
        $headerIds = array_column($dataA, 'HeaderID');

        // Tentukan kolom yang mau di-expose (sesuai yg dipakai controller/view)
        $selectCols = 'header_id, approved_dokter_by, kesimpulan_mcu, pesan_klinik';
        // Tambahkan kolom lain yang dipakai:
        // $selectCols = 'header_id, approved_dokter_by, kesimpulan_cu, mcu_date, dst';

        // Daftar kolom B yg harus selalu ada di output (tanpa header_id)
        $bColumns = ['approved_dokter_by', 'kesimpulan_mcu', 'pesan_klinik'];
        // Sinkronkan dengan $selectCols di atas

        // Mapping: nama kolom baru (pgsql) => nama kolom lama (alias biar kode lama tetap jalan)
        $aliasMap = [
            'approved_dokter_by' => 'apvdokterby',
            'kesimpulan_mcu'     => 'kesimpulanCU',
            'pesan_klinik'       => 'pesanklinik',
        ];

        $dataB = $dbPgsql->select($selectCols)
            ->from('mcu_trx_medical_hdr')
            ->where_in('header_id', $headerIds)
            ->get()->result();

        $mapB = [];
        foreach ($dataB as $row) {
            $mapB[$row->header_id] = $row;
        }

        foreach ($dataA as &$row) {
            // Default semua kolom B jadi null dulu
            foreach ($bColumns as $k) {
                $row->$k = null;
            }
            // Override dengan data aktual kalau match
            if (isset($mapB[$row->HeaderID])) {
                foreach ($mapB[$row->HeaderID] as $k => $v) {
                    if ($k === 'header_id') continue;
                    $row->$k = $v;
                }
            }

            // Tambahan: copy nilai kolom baru ke nama kolom lama (alias)
            foreach ($aliasMap as $newName => $oldName) {
                $row->$oldName = $row->$newName ?? null;
            }
        }
        unset($row);

        return $dataA;
    }


    private function _get_datatables_query_calon_tenaker($table)
    {


        // $idpemborong = 13;


        $this->db->select('A.*');
        // $this->db->from($table . ' AS A');
        $this->db->from('vwListBerkas_  AS A');
        // $this->db->from('tblTrnCalonTenagaKerja  AS A');
        $this->db->limit(2000);
        // $this->db->limit(2000);
        // $this->db->limit(100);


        $i = 0;

        foreach ($this->column_search_calon_tenaker as $item) // loop column 
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
                if (count($this->column_search_calon_tenaker) - 1 == $i)  //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['selTenaker']) && $_POST['selTenaker'] != '') {

            if ((isset($_POST['start_date']) && $_POST['start_date'] != '') && (isset($_POST['end_date']) && $_POST['end_date'] != '')) {
                $start_date = date('Y-m-d', strtotime($_POST['start_date']));
                $end_date = date('Y-m-d', strtotime($_POST['end_date']));
            } else {
                $start_date = '';
                $end_date = '';
            }

            switch ($_POST['selTenaker']) {
                case 'verifi':
                    $this->db->where("Verified", 0);
                    $this->db->where("cancel_status IS NULL");

                    if ($start_date && $end_date) {
                        $this->db->where("CONVERT(date, DikirimDate) >=", $start_date);
                        $this->db->where("CONVERT(date, DikirimDate) <=", $end_date);
                    }
                    break;
                case 'interview':
                    $this->db->where("PostingData", 0);
                    $this->db->where("GeneralStatus", 0);
                    $this->db->where("StatusDaftar", 1);
                    $this->db->where("StatusDaftar", 1);
                    $this->db->where("CONVERT(date, JadwalInterview) IS NOT NULL");
                    $this->db->where("CONVERT(date, JadwalInterview) <>", '');
                    $this->db->where("cancel_status IS NULL");

                    if ($start_date && $end_date) {
                        $this->db->where("CONVERT(date, JadwalInterview) >=", $start_date);
                        $this->db->where("CONVERT(date, JadwalInterview) <=", $end_date);
                    }
                    break;
                case 'identifi':
                    $this->db->where("GeneralStatus", 0);
                    $this->db->where("Verified", 1);
                    $this->db->where("DeptTujuan IS NULL");
                    $this->db->where("cancel_status IS NULL");

                    if ($start_date && $end_date) {
                        $this->db->where("CONVERT(date, DikirimDate) >=", $start_date);
                        $this->db->where("CONVERT(date, DikirimDate) <=", $end_date);
                    }
                    break;
                case 'belumposting':
                    $this->db->where("SpecialScreening IS NOT NULL");
                    $this->db->where("PostingData IS NULL");
                    $this->db->where("cancel_status IS NULL");

                    if ($start_date && $end_date) {
                        $this->db->where("CONVERT(date, DikirimDate) >=", $start_date);
                        $this->db->where("CONVERT(date, DikirimDate) <=", $end_date);
                    }
                    break;
                case 'mcu':
                    $this->db->where("mcu_date IS NOT NULL");
                    $this->db->where("cancel_status IS NULL");
                    if ($start_date && $end_date) {
                        $this->db->where("CONVERT(date, mcu_date) >=", $start_date);
                        $this->db->where("CONVERT(date, mcu_date) <=", $end_date);
                    }
                    $this->db->where("CONVERT(date, RegisteredDate) >=", '2024-12-12');

                    break;
                case 'closed':
                    $this->db->where("ClosingDate IS NOT NULL");
                    $this->db->where("cancel_status IS NULL");
                    if ($start_date && $end_date) {
                        $this->db->where("CONVERT(date, ClosingDate) >=", $start_date);
                        $this->db->where("CONVERT(date, ClosingDate) <=", $end_date);
                    }
                    break;
                default:
                    break;
            }
        }
        $this->db->where("cancel_status IS NULL");

        $this->db->group_start();  // Start grouping of where clauses
        $this->db->where('KeteranganKirim !=', 'blacklist');
        $this->db->where('KeteranganKirim !=', 'blacklist_2_bln');
        $this->db->or_where('KeteranganKirim IS NULL');
        $this->db->group_end();  // End grouping of where clauses


        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_calon_tenaker[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->column_order_calon_tenaker)) {
            $order = $this->order_calon_tenaker;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }


    public function get_datatables_calon_tenaker($table)
    {
        $this->_get_datatables_query_calon_tenaker($table);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_calon_tenaker($table)
    {
        $this->_get_datatables_query_calon_tenaker($table);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_calon_tenaker($table)
    {
        return $this->db->from($table)
            ->count_all_results();
    }

    public function getDataTenagaKerjaNew($id)
    {
        $this->db->select('*');
        $this->db->from('vwTrnCalonTenagaKerja2');
        $this->db->where('HeaderID', $id);
        return $this->db->get()->result();
    }
    public function getDataAnak($id)
    {
        $this->db->select('*');
        $this->db->from('tblTrnAnak');
        $this->db->where('HeaderID', $id);
        return $this->db->get()->result();
    }

    public function getDataPendidikan($id)
    {
        $this->db->select('*');
        $this->db->from('vw_riwayatpendidikan');
        $this->db->where('HeaderID', $id);
        return $this->db->get()->result();
    }

    public function getDataSaudara($id)
    {
        $this->db->select('*');
        $this->db->from('tblTrnSaudara');
        $this->db->where('HeaderID', $id);
        return $this->db->get()->result();
    }

    public function getDataListTenakerForPBR($id)
    {
        $this->db->select('A.*, A.HeaderID as ID');
        $this->db->from('tblTrnCalonTenagaKerja AS A');
        $this->db->where('A.HeaderID', $id);
        $dataA = $this->db->get()->result();

        return $this->_merge_with_pgsql_medical($dataA);
    }

    // public function getDataListTenakerForPBR($id)
    // {
    //     $this->db->select('A.*, A.HeaderID as ID, B.*');
    //     $this->db->from('tblTrnCalonTenagaKerja' . ' AS A');
    //     $this->db->join('PSGKlinik.dbo.tbl_kk_MstMedicalTemporaryTKNew AS B', 'A.HeaderID = B.HeaderID ', 'left');
    //     $this->db->where('A.HeaderID', $id);
    //     return $this->db->get()->result();
    // }

    function sendToMCU($id)
    {
        $data   = array(
            'mcu_date' => NULL,
            'mcu_update_by' => NULL,
        );
        $this->db->trans_start();
        $this->db->where('HeaderID', $id);
        $this->db->update('tblTrnCalonTenagaKerja', $data);
        $rtn = $this->db->trans_complete();

        if ($rtn) {
            return 1;
        } else {
            return 0;
        }
    }

    function getKualifikasiDasar($headerID)
    {
        $this->db->select('A.HeaderID, B.HasilWawancara, B.TotalNilai, B.RataNilai, B.Grade,B.Keterangan, C.Item, C.Nilai, D.Uraian');
        $this->db->from('tblTrnCalonTenagaKerja A');
        $this->db->join('tblTrnWawancara B', 'A.HeaderID = B.HeaderID', 'left');
        $this->db->join('tblTrnWawancaraDetail C', 'B.HeaderID = C.HeaderID', 'left');
        $this->db->join('tblMstListKualifikasi D', 'D.Item = C.Item', 'right');
        $this->db->where('A.HeaderID', $headerID);
        $this->db->order_by('C.Item');

        $query = $this->db->get();
        return $query->result();
    }

    function getKualifikasiKaryawan()
    {


        $query = $this->db->query("SELECT * FROM tblMstListKualifikasiKaryawan");
        return $query->result();
    }

    function getNilaiKaryawan($id)
    {
        $this->db->select('A.HeaderID, B.HasilWawancara, B.TotalNilai, B.RataNilai, B.Grade,C.Catatan, C.Item, C.Nilai, D.Uraian, B.Keterangan, D.GroupItem, D.Head');
        $this->db->from('tblTrnCalonTenagaKerja A');
        $this->db->join('tblTrnWawancara B', 'A.HeaderID = B.HeaderID', 'left');
        $this->db->join('tblTrnWawancaraDetail C', 'B.HeaderID = C.HeaderID', 'left');
        $this->db->join('tblMstListKualifikasiKaryawan D', 'D.Item = C.Item', 'right');
        $this->db->where('A.HeaderID', $id);
        $this->db->order_by('C.Item');

        $query = $this->db->get();
        return $query->result();
    }

    function riwayat_kerja($ktp, $nofix)
    {

        $query = $this->db->query("SELECT * FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja_TEST WHERE FixNo = '$nofix' OR NOKTP = '$ktp'");
        return $query->result();
    }


    ///### unscreening by hrd 

    private $column_order_unscreening_by_hrd = array(
        'HeaderID',
        'Nama',
        'Pemborong',
        'SubPemborong',
        'Tgl_Lahir',
        'Jenis_Kelamin',
    );

    private $column_search_unscreening_by_hrd = array(
        'A.HeaderID',
        'A.Nama',
        'A.Pemborong',
        'A.SubPemborong',
        'A.Tgl_Lahir',
        'A.Jenis_Kelamin',
    );

    private $order_unscreening_by_hrd = array('HeaderID' => 'desc'); // default order 


    public function count_filtered_unscreening_by_hrd($table)
    {
        $this->_get_datatables_query_unscreening_by_hrd($table);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_unscreening_by_hrd($table)
    {
        return $this->db->from($table)
            ->count_all_results();
    }

    public function get_datatables_unscreening_by_hrd($table)
    {
        $this->_get_datatables_query_unscreening_by_hrd($table);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_datatables_query_unscreening_by_hrd($table)
    {


        // $idpemborong = 13;


        // $this->db->select('A.*');
        // $this->db->from($table . ' AS A');
        // $this->db->limit(2000);

        $subquery_dept = $this->db
            ->select('DISTINCT DeptID', false)
            ->from('vwTrnDeptWawancara')
            ->where('GroupID', 93)
            ->get_compiled_select();

        $this->db->select('A.*, B.DeptID');
        $this->db->from($table . ' AS A');
        $this->db->join('vwTenakerForInterview AS B', 'A.HeaderID = B.HdrID', 'left');
        $this->db->where('A.GeneralStatus', 0);

        $this->db->where('A.WawancaraHasil IS NULL', null, false);
        $this->db->where("B.DeptID IN ($subquery_dept)", null, false);
        $this->db->limit(2000);

        // // Subquery DeptID
        // $subquery_dept = $this->db
        //     ->select('DISTINCT DeptID', false)
        //     ->from('vwTrnDeptWawancara')
        //     ->where('GroupID', 93)
        //     ->get_compiled_select();

        // // Query 1
        // $query1 = $this->db
        //     ->select('A.*, B.DeptID', false)
        //     ->from("{$table} AS A")
        //     ->join('vwTenakerForInterview AS B', 'A.HeaderID = B.HdrID', 'left')
        //     ->where('A.GeneralStatus', 0)
        //     ->where('A.Pemborong !=', 'YAO HSING')
        //     ->where('A.Pemborong !=', 'PT PULAU SAMBU')
        //     ->where('A.WawancaraHasil IS NULL', null, false)
        //     ->where("B.DeptID IN ($subquery_dept)", null, false)
        //     ->get_compiled_select();

        // // Query 2
        // $query2 = $this->db
        //     ->select('A.*, B.DeptID', false)
        //     ->from("{$table} AS A")
        //     ->join('vwTenakerForInterview AS B', 'A.HeaderID = B.HdrID', 'left')
        //     ->where('A.GeneralStatus', 0)
        //     ->where_in('A.Pemborong', ['PT PULAU SAMBU', 'YAO HSING '])
        //     ->where('A.WawancaraHasil IS NULL', null, false)
        //     ->where("B.DeptID IN ($subquery_dept)", null, false)
        //     ->get_compiled_select();

        // // Gabungkan UNION ALL
        // $sql = "$query1 UNION ALL $query2";

        // // Eksekusi
        // $this->db->query($sql);
        // // $result = $query->result();



        $i = 0;

        foreach ($this->column_search_unscreening_by_hrd as $item) // loop column 
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
                if (count($this->column_search_unscreening_by_hrd) - 1 == $i)  //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }


        // $this->db->where("WawancaraHasil IS NOT NULL");
        // $this->db->where("DeptTujuan IS NULL");
        // $this->db->where("TransID IS NULL");
        // $this->db->where("ScreeningComplete <> 1");


        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_unscreening_by_hrd[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->column_order_unscreening_by_hrd)) {
            $order = $this->order_unscreening_by_hrd;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    // private function _get_datatables_query_unscreening_by_hrd($table)
    // {
    //     // Subquery untuk DeptID
    //     $subquery_dept = $this->db
    //         ->select('DISTINCT DeptID', false)
    //         ->from('vwTrnDeptWawancara')
    //         ->where('GroupID', 93)
    //         ->get_compiled_select();

    //     // Query 1
    //     $query1 = $this->db
    //         ->select('A.*, B.DeptID', false)
    //         ->from("$table AS A")
    //         ->join('vwTenakerForInterview AS B', 'A.HeaderID = B.HdrID', 'left')
    //         ->where('A.GeneralStatus', 0)
    //         ->where('A.Pemborong !=', 'YAO HSING')
    //         ->where('A.Pemborong !=', 'PT PULAU SAMBU')
    //         ->where('A.WawancaraHasil IS NULL', null, false)
    //         ->where("B.DeptID IN ($subquery_dept)", null, false)
    //         // ->where("A.ScreeningComplete <> 1")
    //         ->get_compiled_select();

    //     // Query 2
    //     $query2 = $this->db
    //         ->select('A.*, B.DeptID', false)
    //         ->from("$table AS A")
    //         ->join('vwTenakerForInterview AS B', 'A.HeaderID = B.HdrID', 'left')
    //         ->where('A.GeneralStatus', 0)
    //         ->where_in('A.Pemborong', ['PT PULAU SAMBU', 'YAO HSING '])
    //         ->where('A.WawancaraHasil IS NULL', null, false)
    //         ->where("B.DeptID IN ($subquery_dept)", null, false)
    //         // ->where("A.ScreeningComplete <> 1")
    //         ->get_compiled_select();

    //     // Gabungkan UNION ALL
    //     $union_sql = "$query1 UNION ALL $query2";

    //     // Set ke FROM sebagai subquery (harus gunakan alias!)
    //     $this->db->from("($union_sql) AS data");

    //     // Kolom pencarian
    //     $i = 0;
    //     foreach ($this->column_search_unscreening_by_hrd as $item) {
    //         if ($_POST['search']['value']) {
    //             if ($item == 'date_time') {
    //                 $search_value = $_POST['search']['value'];
    //                 if ($i === 0) {
    //                     $this->db->group_start();
    //                 }
    //                 $this->db->or_where("TO_CHAR($item, 'YYYY-MM-DD') LIKE '%$search_value%'");
    //             } else {
    //                 if ($i === 0) {
    //                     $this->db->group_start();
    //                 }
    //                 $this->db->or_like($item, $_POST['search']['value']);
    //             }
    //             if (count($this->column_search_unscreening_by_hrd) - 1 == $i) {
    //                 $this->db->group_end();
    //             }
    //         }
    //         $i++;
    //     }

    //     // Urutan
    //     if (isset($_POST['order'])) {
    //         $this->db->order_by($this->column_order_unscreening_by_hrd[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    //     } else if (isset($this->order_unscreening_by_hrd)) {
    //         $order = $this->order_unscreening_by_hrd;
    //         $this->db->order_by(key($order), $order[key($order)]);
    //     }
    // }
}

/* End of file m_monitor.php */
/* Location: ./application/models/m_monitor.php */