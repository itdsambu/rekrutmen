<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_verifikasi extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    protected $table = 'vwlistberkas';

    //field yang ada di table user
    private $column_order = array(
        'HdrID',
        'Nama',
        'Pemborong',
        'Tgl_Lahir',
        'Jenis_Kelamin',
        'Pendidikan',
        'Verified',
    );
    //field yang diizin untuk pencarian
    private $column_search = array(
        'HdrID',
        'Nama',
        'Pemborong',
        'Tgl_Lahir',
        'Jenis_Kelamin',
        'Pendidikan',
        'Verified',
    );
    private $order = array('HdrID' => 'desc'); // default order 

    private function _get_datatables_query()
    {
        $this->db->select('*');
        // $this->db->from($this->table . 'a');
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
        // $this->db->where_not_in('verified', [1]);

        $this->db->group_start();
        $this->db->where('Verified IS NULL');
        $this->db->or_where('Verified <>', 1);
        $this->db->group_end();

        if (isset($_POST['headerid']) && !empty($_POST['headerid']) && $_POST['headerid'] != '') {
            $this->db->where('HdrID', $_POST['headerid']);
        }
        if (isset($_POST['inputPemborong']) && !empty($_POST['inputPemborong']) && $_POST['inputPemborong'] != '') {
            $this->db->like('Pemborong', $_POST['inputPemborong']);
        }

        if (isset($_POST['inputNama']) && !empty($_POST['inputNama']) && $_POST['inputNama'] != '') {
            $this->db->like('Nama', $_POST['inputNama']);
        }


        if (isset($_POST['selDataFilter']) && !empty($_POST['selDataFilter']) && $_POST['selDataFilter'] != '') {

            switch ($_POST['selDataFilter']) {
                case '1':
                    // Kondisi untuk case '1'
                    $this->db->where('KTP IS NOT NULL');
                    $this->db->where('Lamaran IS NOT NULL');
                    $this->db->where('CV IS NOT NULL');
                    $this->db->where('Ijazah IS NOT NULL');
                    $this->db->where('Transkrip IS NOT NULL');
                    break;

                case '2':
                    // Kondisi untuk case '2'
                    $this->db->where('KTP IS NOT NULL');
                    break;

                case '3':
                    // Kondisi untuk case '3'
                    $this->db->where('KTP IS NULL');
                    $this->db->where('Lamaran IS NULL');
                    $this->db->where('CV IS NULL');
                    $this->db->where('Ijazah IS NULL');
                    $this->db->where('Transkrip IS NULL');
                    break;

                default:
                    // Tidak ada kondisi tambahan untuk default
                    break;
            }
        }

        // $this->db->where('Proses', 'proses');
        // $this->db->where('StatusDaftar', 1);

        // Tanggal 1 bulan sebelum awal bulan ini
        $startDate = date('Y-m-d', strtotime('-1 year -1 months', strtotime(date('Y-m-01')))); // Default
        // Tanggal akhir bulan sekarang
        $endDate = date('Y-m-d', strtotime('last day of this month')); // Default



        if ((isset($_POST['start_date']) && !empty($_POST['start_date']) && $_POST['start_date'] != '') && (isset($_POST['end_date']) && !empty($_POST['end_date']) && $_POST['end_date'] != '')) {
            $this->db->where('registereddate >=', date('Y-m-d', strtotime($_POST['start_date'])));
            $this->db->where('registereddate <=', date('Y-m-d', strtotime($_POST['end_date'])));
        } else {

            $this->db->where('registereddate >=', $startDate);
            $this->db->where('registereddate <=', $endDate);
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
        return $this->db->from($this->table)
            ->count_all_results();
    }
    // ############################################################################################################################

    function list_calon_tk($dataselect, $start_date, $end_date, $pemborong, $nama, $noreg, $start_paging, $end_paging)
    {
        switch ($dataselect) {
            case '1':
                $con = 'and ktp is not null and lamaran is not null and cv is not null and ijazah is not null and transkrip is not null ';
                break;
            case '2':
                $con = 'and ktp is not null ';
                break;
            case '3':
                $con = 'and ktp is null and lamaran is null and cv is null and ijazah is null and transkrip is null';
                break;

                // 0
            default:
                $con = '';
                break;
        }

        $con_noreg = !empty($noreg) ? "and headerid like '%" . $noreg . "%'" : '';
        $con_nama = !empty($nama) ? "and nama like '%" . $nama . "%'" : '';
        $con_pemborong = !empty($pemborong) ? "and pemborong like '%" . $pemborong . "%'" : '';

        $q1 = $this->db->query(
            "SELECT
                hdrid 
            FROM
                -- vwlistberkas_run20220611 
                vwlistberkas 
            WHERE
                generalstatus = 0 
            AND verified NOT IN ( 1 ) 
            AND registereddate >= '$start_date' 
            AND registereddate <= '$end_date' $con $con_noreg $con_nama $con_pemborong"
        )->num_rows();

        $q2 = $this->db->query(
            "SELECT
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
                    generalstatus = 0 
                    AND verified NOT IN ( 1 ) 
                    AND registereddate >= '$start_date' 
                    AND registereddate <= '$end_date' $con $con_noreg $con_nama $con_pemborong 
                ) A 
            WHERE
                ROW >= $start_paging 
                AND ROW <= $end_paging"
        )->result();

        return [
            'jumlah_row' => $q1,
            'list_per_page' => $q2,
        ];
    }

    function updateVerified($hdrID)
    {
        $data   = array(
            'Verified'      => 1,
            'VerifiedBy'    => strtoupper($this->session->userdata('username')),
            'VerifiedDate'  => date('Y-m-d H:i:s')
        );
        $this->db->trans_start();
        $this->db->where('HeaderID', $hdrID);
        $this->db->update('tblTrnCalonTenagaKerja', $data);
        $this->db->trans_complete();
    }

    function batalVerified($hdrID)
    {
        $this->db->trans_start();
        $this->db->where('HeaderID', $hdrID);
        $this->db->update('tblTrnCalonTenagaKerja', array('Verified' => 0));
        $this->db->trans_complete();
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

    function get_detailtk($hdrid)
    {
        return $this->db->get_where('vwTrnCalonTenagaKarantina', array('HeaderID' => $hdrid));
    }

    function resultScreen($hdrid)
    {
        return $this->db->get_where('tblTrnVerifikasi', array('HeaderID' => $hdrid));
    }

    function simpanVerifikasiTim($data)
    {
        $this->db->trans_start();
        $this->db->insert('tblTrnVerifikasi', $data);
        $sID = $this->db->insert_id();
        $this->db->trans_complete();
        return $sID;
    }

    public function column_exists($table, $column)
    {
        $query = $this->db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table' AND COLUMN_NAME = '$column'");
        return $query->num_rows() > 0;
    }
}
