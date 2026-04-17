<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by Heriyanto
 */

class M_configpermintaan extends My_Model
{

    protected $table = 'vwPermintaanKryTKMemo';

    //field yang ada di table user
    private $column_order = array(
        'IDMemo',
        'Doc',
        'DeptAbbr',
        'IsKry',
        'Jumlah',

    );
    //field yang diizin untuk pencarian
    private $column_search = array(
        'IDMemo',
        'Doc',
        'DeptAbbr',
        'IsKry',
        'Jumlah',
    );

    private $order = array('IDMemo' => 'desc'); // default order 

    private function _get_datatables_query()
    {

        $this->db->select('*');
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

    // ############################################################################################## Bor
    // protected $table_bor = 'vwIdealKryTk_bor';
    protected $table_bor = 'vw_idealtkbor';

    //field yang ada di table user
    private $column_order_bor = array(
        'DeptAbbr',
        'IBor',
        'RBor',
        'SubJabatanAbbr',
        'PERMINTAANBORApp',
        'PERMINTAANBORPending',
        'bperiode',

    );
    //field yang diizin untuk pencarian
    private $column_search_bor = array(
        'DeptAbbr',
        'IBor',
        'RBor',
        'SubJabatanAbbr',
        'PERMINTAANBORApp',
        'PERMINTAANBORPending',
        'bperiode',
    );

    private $order_bor = array('DeptAbbr' => 'asc', 'periode' => 'desc'); // default order 

    private function _get_datatables_query_bor()
    {

        $this->db->select('*');
        $this->db->from($this->table_bor);

        $i = 0;

        foreach ($this->column_order_bor as $item) // loop column 
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

                if (count($this->column_search_bor) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['dept']) && !empty($_POST['dept']) && $_POST['dept'] != '') {
            $this->db->where('DeptAbbr', $_POST['dept']);
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_bor[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_bor)) {
            $order_bor = $this->order_bor;
            $this->db->order_by(key($order_bor), $order_bor[key($order_bor)]);
        }
    }

    public function get_datatables_bor()
    {
        $this->_get_datatables_query_bor();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_bor()
    {
        $this->_get_datatables_query_bor();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_bor()
    {
        return $this->db->from($this->table_bor)
            ->count_all_results();
    }
    // ############################################################################################## Bor
    // ############################################################################################## Kry
    protected $table_kry = 'vw_idealtkkry';

    //field yang ada di table user
    private $column_order_kry = array(
        'DeptAbbr',
        'IKry',
        'RKry',
        'PERMINTAANKARApp',
        'PERMINTAANKARPending',
        'bperiode',

    );
    //field yang diizin untuk pencarian
    private $column_search_kry = array(
        'DeptAbbr',
        'IKry',
        'RKry',
        'PERMINTAANKARApp',
        'PERMINTAANKARPending',
        'bperiode',
    );

    private $order_kry = array('DeptAbbr' => 'asc', 'periode' => 'desc'); // default order 

    private function _get_datatables_query_kry()
    {

        $this->db->select('*');
        $this->db->from($this->table_kry);

        $i = 0;

        foreach ($this->column_order_kry as $item) // loop column 
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

                if (count($this->column_search_kry) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['dept']) && !empty($_POST['dept']) && $_POST['dept'] != '') {
            $this->db->where('DeptAbbr', $_POST['dept']);
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_kry[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_kry)) {
            $order_kry = $this->order_kry;
            $this->db->order_by(key($order_kry), $order_kry[key($order_kry)]);
        }
    }

    public function get_datatables_kry()
    {
        $this->_get_datatables_query_kry();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_kry()
    {
        $this->_get_datatables_query_kry();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_kry()
    {
        return $this->db->from($this->table_kry)
            ->count_all_results();
    }
    // ############################################################################################## Kry

    // ############################################################################################## Kry Bor New
    protected $table_kry_new = 'vwIdealKryTk_new';

    //field yang ada di table user
    private $column_order_kry_new = array(
        'DeptAbbr',
        'IKry',
        'RKry',
        'PERMINTAANKARApp',
        'PERMINTAANKARPending',
        'Periode',
        'id_master_bongkar_kelapa',
        'SubJabatanTk',
        'SubJabatanKry',

    );
    //field yang diizin untuk pencarian
    private $column_search_kry_new = array(
        'DeptAbbr',
        'IKry',
        'RKry',
        'PERMINTAANKARApp',
        'PERMINTAANKARPending',
        'Periode',
        'id_master_bongkar_kelapa',
        'SubJabatanTk',
        'SubJabatanKry',
    );

    private $order_kry_new = array('DeptAbbr' => 'asc', 'periode' => 'desc'); // default order 

    private function _get_datatables_query_kry_new()
    {

        $this->db->select('*');
        $this->db->from($this->table_kry_new);

        $i = 0;

        foreach ($this->column_order_kry_new as $item) // loop column 
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

                if (count($this->column_search_kry_new) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['dept']) && !empty($_POST['dept']) && $_POST['dept'] != '') {
            $this->db->where('DeptAbbr', $_POST['dept']);
        }

        if (isset($_POST['id_bongkar']) && !empty($_POST['id_bongkar']) && $_POST['id_bongkar'] != '') {
            $this->db->where('id_master_bongkar_kelapa', $_POST['id_bongkar']);
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_kry_new[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_kry_new)) {
            $order_kry_new = $this->order_kry_new;
            $this->db->order_by(key($order_kry_new), $order_kry_new[key($order_kry_new)]);
        }
    }

    public function get_datatables_kry_new()
    {
        $this->_get_datatables_query_kry_new();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_kry_new()
    {
        $this->_get_datatables_query_kry_new();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_kry_new()
    {
        return $this->db->from($this->table_kry_new)
            ->count_all_results();
    }
    // ############################################################################################## Kry Bor New



    public function getdatavwkaryawan($param)
    {
        //  ada di class Datatablesql2 method sql_select
        $query = $this->datatablesql2->sql_select(
            $param,
            function ($param) {
                $vw = "vwIdealKryTk";
                return $vw;
            },
            function ($param) {
                $field = ' * ';
                // $field = ' TOP 100 * '; // Ambil hanya 100 data teratas                
                return $field;
            }
        );

        // $query = $this->db->query("SELECT * FROM vwIdealKryTk ORDER BY Periode DESC");
        return $query;
        // return $query;
    }

    public function gettotalall($param = null)
    {

        // print_r($param);
        // die;
        if ($param['dept'] == 'dept') {
            $sql = "SELECT Ideal_Kry = SUM(IKry),Real_Kry=SUM(RKry),Ideal_Bor=SUM(IBOR),Real_Bor=SUM(RBOR),ReqB=SUM(PERMINTAANBORApp),ReqK=SUM(PERMINTAANKARApp),ReqKP=SUM(PERMINTAANKARPending),ReqBP=SUM(PERMINTAANBORPending)    FROM vwKuotaKryTKinReq";
            $query = $this->db->query($sql);
            return $query;
        } else {
            $sql = "SELECT Ideal_Kry = SUM(IKry),Real_Kry=SUM(RKry),Ideal_Bor=SUM(IBOR),Real_Bor=SUM(RBOR),ReqB=SUM(PERMINTAANBORApp),ReqK=SUM(PERMINTAANKARApp),ReqKP=SUM(PERMINTAANKARPending),ReqBP=SUM(PERMINTAANBORPending)    FROM vwKuotaKryTKinReq " .
                " where krydeptname in ('" . $param['dept'] . "')";
            $query = $this->db->query($sql);
            return $query;
        }
    }

    public function getdatavwkaryawandept($param)
    {
        $query = $this->datatablesql2->sql_select(
            $param,
            function ($param) {
                $vw = 'vwIdealKryTk';
                return $vw;
            },
            function ($param) {
                $field = ' * ';
                return $field;
            },
            function ($param) {
                $where = "DeptKry in ('" . $param['dept'] . "')";
                return $where;
            }
        );
        return $query;
    }

    public function UpdateIdealKaryawan($param)
    {
        $query = $this->exec_sql('UpdataIdealKry', $param);
        return $query;
    }
    public function UpdateIdealKaryawan_($param)
    {
        $query = $this->exec_sql('UpdataIdealKry_new', $param);
        return $query;
    }

    public function UpdateMemo($param)
    {
        $query = $this->exec_sql('Trans_MemoIdealDept', $param);
        return $query;
    }

    public function getMonitoringMemos($param)
    {
        $query = $this->datatablesql2->sql_select2(
            $param,
            function ($param) {
                return 'vwPermintaanKryTKMemo';
            },
            function ($param) {
                $field = "Opsi='',IDMemo,Doc,DeptAbbr,IsKry,Jumlah,IsComplete,CreatedDate";
                return $field;
            },
            function ($param) {
                $where = "DeptAbbr in ('" . $param['deptlist'] . "')";
                return $where;
            },
            true,
            function ($row) {
                $row->opsi = '';
                $tanggal = '<div class="text-right smaller-80">' . $row->CreatedDate . '</div>';
                if ($row->IsComplete == 0) {
                    $row->IsComplete = 'Belum Complete ' . $tanggal;
                    //if($this->session->userdata('dept')=='PSN'){
                    $row->opsi = '<a href="' . base_url() . "configpermintaan/updatememo?noref="
                        . encode_str($row->IDMemo) . '" class="btn btn-primary btn-sm btn-icon">Edit</a>';
                    //}
                } else {
                    $row->IsComplete = 'Sudah Complete ' . $tanggal;
                }
            }
        );

        return $query;
    }

    public function getfilememo($id)
    {
        $query = $this->exec_sql('getPrintMemo', $id);
        return $query;
    }

    public function getmstkuotapermintaan($noref)
    {
        $this->db->where('idmemo', $noref);
        $query = $this->db->get('tblMstKuotaPermintaanMemo');
        return $query->row();
    }

    public function getkuotapermintaanbydept($deptabbr, $iskry)
    {
        $sql = "select * from vwKuotaKryTK " .
            " where ";
        if ($iskry)
            $sql = $sql . " krydeptname='" . $deptabbr . "'";
        else
            $sql = $sql . " bordeptname='" . $deptabbr . "'";
        $query = $this->db->query($sql);
        return $query;
    }

    function getdataIdeal($dept)
    {
        $this->db->where('krydeptname', $dept);
        $this->db->where('bordeptname', $dept);
        $data = $this->db->get('vwKuotaKryTK');
        if ($data->num_rows() > 0) {
            return $data->result_array();
        }
    }

    function getDept()
    {
        $this->db->select('DeptAbbr');
        $this->db->distinct();
        $this->db->where('statusKar', 2);
        $query = $this->db->get('tblMstKuotaPermintaan_new');
        return $query->result();
    }

    function getDept_()
    {
        $this->db->select('DeptAbbr');
        $this->db->distinct();
        // $this->db->where('statusKar', 2);
        $query = $this->db->get('tblMstKuotaPermintaan_test');
        return $query->result();
    }

    function getTarget()
    {
        $this->db->select('*');
        $query = $this->db->get('tblMstBongkarKelapa');
        return $query->result();
    }

    function getIdealBor()
    {
        $this->db->select('*');
        $this->db->from($this->table_bor);
        $query = $this->db->get();
        return $query->result();
    }

    function update_data_kry($id, $data)
    {
        $this->db->trans_begin();

        $this->db->where('ID', $id);
        $this->db->update('tblMstKuotaPermintaan_test', $data);

        // kalau query error
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        // optional: pastikan ada row yg kena
        if ($this->db->affected_rows() === 0) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
    }

    function toExcel($target, $dept)
    {
        if ($target) {
            $this->db->where('id_master_bongkar_kelapa', $target);
        }

        if ($dept) {
            $this->db->where('DeptAbbr', $dept);
        }
        $query = $this->db->get('vwIdealKryTk_new');
        return $query->result();
    }

    public function insert_batch($data)
    {
        $this->db->trans_start();

        $this->db->truncate('tk_ideal_staging');
        $this->db->insert_batch('tk_ideal_staging', $data);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}
