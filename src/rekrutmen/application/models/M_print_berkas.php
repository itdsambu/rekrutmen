<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author bt ITD15
 */

class M_print_berkas extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function getTenakerPosted()
    {
        $query = $this->db->query("SELECT TOP 50 * FROM vwTrnPosted ORDER BY CreatedDate DESC");
        return $query->result();
    }
    function getTenakerPostedWhere($startDate, $endDate)
    {
        $query = $this->db->query("SELECT * FROM vwTrnPosted WHERE CONVERT(date,CreatedDate) BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY HeaderID DESC");
        return $query->result();
    }

    // ###=== For Paging ===###
    // == Tenaker Posted
    function selectTenakerPostedPrintPaging($start, $end)
    {
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
            . "* FROM vwTrnPosted AS tbl ) vwTrnPosted WHERE Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }
    function countTenakerPostedPrintPaging()
    {
        $query = $this->db->query("SELECT HeaderID FROM vwTrnPosted ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    // == Tenaker Posted Condotion Filter
    function selectTenakerPostedPrintPagingWhere($pemborong, $noreg, $nama, $tglA, $tglZ)
    {
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
            . "* FROM vwTrnPosted AS tbl WHERE Pemborong LIKE '%$pemborong%' AND "
            . "HeaderID LIKE '%" . $noreg . "%' AND Nama LIKE '%" . $nama . "%' AND CreatedDate BETWEEN '" . $tglA . "' AND '" . $tglZ . "') "
            . "vwTrnPosted");
        return $query->result();
    }
    function countTenakerPostedPrintPagingWhere($pemborong, $noreg, $nama, $tglA, $tglZ)
    {
        $query = $this->db->query("SELECT HeaderID FROM vwTrnPosted WHERE Pemborong LIKE '%" . $pemborong . "%' AND "
            . "HeaderID LIKE '%" . $noreg . "%' AND Nama LIKE '%" . $nama . "%' AND CreatedDate BETWEEN '" . $tglA . "' AND '" . $tglZ . "' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }

    // == Tenaker Interviewed
    function selectTenakerInterviewedPrintPaging($start, $end)
    {
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
            . "* FROM vwListBerkas AS tbl where tbl.GeneralStatus = '0' AND tbl.DeptTujuan Is Not NULL 
            AND tbl.HeaderID IN (SELECT HeaderID FROM tblTrnWawancara WHERE HasilWawancara = '1') ) vwTrnLulusInterview WHERE Row >= " . $start . " AND Row <= " . $end . " ");
        // $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
        //     . "* FROM vwTrnLulusInterview AS tbl ) vwTrnLulusInterview WHERE Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }
    function countTenakerInterviewedPrintPaging()
    {
        $query = $this->db->query("SELECT HeaderID FROM vwTrnLulusInterview ORDER BY HeaderID DESC");
        return $query->num_rows();
    }
    // == Tenaker Interviewed Condition Filter
    function selectTenakerInterviewedPrintPagingWhere($start, $end, $pemborong, $noreg, $nama)
    {
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
            . "* FROM vwTrnLulusInterview AS tbl WHERE Pemborong LIKE '%" . $pemborong . "%' AND "
            . "HeaderID LIKE '%" . $noreg . "%' AND Nama LIKE '%" . $nama . "%') "
            . "vwTrnLulusInterview WHERE  Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }
    function countTenakerInterviewedPrintPagingWhere($pemborong, $noreg, $nama)
    {
        $query = $this->db->query("SELECT HeaderID FROM vwTrnLulusInterview WHERE Pemborong LIKE '%" . $pemborong . "%' AND "
            . "HeaderID LIKE '%" . $noreg . "%' AND Nama LIKE '%" . $nama . "%' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }


    // ==================== Ambil Data Detail Karyawan dan Anaknya ===========================
    function getResult($hdrID)
    {
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja WHERE HeaderID ='" . $hdrID . "'");
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


    function getTenakerOK($start, $end)
    {
        $query = $this->db->query("SELECT
                                        * 
                                    FROM
                                        (
                                        SELECT
                                            ROW_NUMBER ( ) OVER ( ORDER BY HdrID DESC ) AS Row, * 
                                        FROM
                                            vwListBerkas AS tbl 
                                        WHERE
                                            Verified = '1' 
                                            AND SpecialScreening = '1' 
                                            AND WawancaraHasil = '1' 
                                            AND GeneralStatus = '0' 
                                            AND PostingData = '0' 
                                        ) vwListBerkas 
                                    WHERE
                                        Row >= '$start' 
                                        AND Row <= '$end'
                                        -- ORDER BY HdrID DESC
                                ");
        return $query->result();
    }
    function getTenakerOKWhere($pemborong, $noreg, $nama, $tglA, $tglZ)
    {
        $query = $this->db->query("SELECT
                                        * 
                                    FROM
                                        (
                                        SELECT
                                            ROW_NUMBER ( ) OVER ( ORDER BY HdrID DESC ) AS Row, * 
                                        FROM
                                            vwListBerkas AS tbl 
                                        WHERE
                                            Verified = '1' 
                                            AND SpecialScreening = '1' 
                                            AND WawancaraHasil = '1' 
                                            AND GeneralStatus = '0' 
                                            AND PostingData = '0' 
                                        ) vwListBerkas 
                                    WHERE
                                        Pemborong LIKE '%$pemborong%' 
                                        AND HdrID LIKE '%$noreg%' AND
                                    Nama LIKE '%$nama%'
                                    AND SpecialScreeningDate BETWEEN '$tglA' AND '$tglZ'
                                        
                                     
                                                                ");
        return $query->result();
    }
    function countgetTenakerOKWhere($pemborong, $noreg, $nama)
    {
        $query = $this->db->query("SELECT
                                        * 
                                    FROM
                                        (
                                        SELECT
                                            ROW_NUMBER ( ) OVER ( ORDER BY HdrID DESC ) AS Row, * 
                                        FROM
                                            vwListBerkas AS tbl 
                                        WHERE
                                            Verified = '1' 
                                            AND SpecialScreening = '1' 
                                            AND WawancaraHasil = '1' 
                                            AND GeneralStatus = '0' 
                                            AND PostingData = '0' 
                                        ) vwListBerkas 
                                    WHERE
                                        Pemborong LIKE '%$pemborong%' 
                                        AND HdrID LIKE '%$noreg%' AND
                                    Nama LIKE '%$nama%'
                                                                ");
        return $query->num_rows();
    }
    function countGetTenakerOK()
    {
        $query = $this->db->query("SELECT
                                        * 
                                    FROM
                                        (
                                        SELECT
                                            ROW_NUMBER ( ) OVER ( ORDER BY HeaderID DESC ) AS Row, * 
                                        FROM
                                            vwListBerkas AS tbl 
                                        WHERE
                                            Verified = '1' 
                                            AND SpecialScreening = '1' 
                                            AND WawancaraHasil = '1' 
                                            AND GeneralStatus = '0' 
                                            AND PostingData = '0' 
                                        ) vwListBerkas 
                                    
                                ");
        return $query->num_rows();
    }


    // AJAX DATATABLES ##################################################################################################

    protected $table = 'vwTrnPosted';
    protected $table2 = 'vwTrnLulusInterview';
    protected $table3 = 'vwListBerkas';

    //field yang ada di table user
    private $column_order = array(
        'HeaderID',
        'Nama',
        'DeptTujuan',
        // 'TipeKaryawan',
        'Jenis_Kelamin',
    );
    //field yang diizin untuk pencarian
    private $column_search = array(
        'HeaderID',
        'Nama',
        'DeptTujuan',
        // 'TipeKaryawan',
        'Jenis_Kelamin',
        'CreatedBy',
        'SpecialScreeningBy',
        'Pemborong',
    );

    private $order = array('HeaderID' => 'desc'); // default order 

    private function _get_datatables_query()
    {

        $this->db->select("*", false);

        $table = $this->table; // default

        // Jika filter data berkas lulus wawancara atau Telah Discreening HRD
        if (
            isset($_POST['selDataFilter']) &&
            ($_POST['selDataFilter'] == '1')
        ) {
            $table = $this->table2;
        } else if (
            isset($_POST['selDataFilter']) &&
            ($_POST['selDataFilter'] == '2')
        ) {
            $table = $this->table3;
        }

        $this->db->from($table);
        $this->db->limit(5000);

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

        if ((isset($_POST['start_date']) && !empty($_POST['start_date']) && $_POST['start_date'] != '') && (isset($_POST['end_date']) && !empty($_POST['end_date']) && $_POST['end_date'] != '') && $_POST['selDataFilter'] != '2' && $_POST['selDataFilter'] != '0') {
            $this->db->where('RegisteredDate >=', date('Y-m-d', strtotime($_POST['start_date'])));
            $this->db->where('RegisteredDate <=', date('Y-m-d', strtotime($_POST['end_date'])));
        }

        if (isset($_POST['selDataFilter']) && $_POST['selDataFilter'] == '2') {
            $this->db->where('Verified', '1');
            $this->db->where('SpecialScreening', '1');
            $this->db->where('WawancaraHasil', '1');
            $this->db->where('GeneralStatus', '0');
            $this->db->where('PostingData', '0');
        }

        if (((isset($_POST['selDataFilter']) && $_POST['selDataFilter'] == '2') || (isset($_POST['selDataFilter']) && $_POST['selDataFilter'] == '0')) && (isset($_POST['start_date']) && !empty($_POST['start_date']) && $_POST['start_date'] != '') && (isset($_POST['end_date']) && !empty($_POST['end_date']) && $_POST['end_date'] != '')) {
            $this->db->where('SpecialScreeningDate >=', date('Y-m-d', strtotime($_POST['start_date'])));
            $this->db->where('SpecialScreeningDate <=', date('Y-m-d', strtotime($_POST['end_date'])));
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

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
        $table = $this->table; // default
        if (
            isset($_POST['selDataFilter']) &&
            ($_POST['selDataFilter'] == '1')
        ) {
            $table = $this->table2;
        } else if (
            isset($_POST['selDataFilter']) &&
            ($_POST['selDataFilter'] == '2')
        ) {
            $table = $this->table3;
        }
        return $this->db->from($table)
            ->count_all_results();
    }
}
