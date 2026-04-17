<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class M_Approval_mpp extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    protected $table_header = 'tblPerubahanMPPHeader';
    protected $table_detail = 'tblPerubahanMPPDetail';

    // DataTables columns
    private $column_order = array(
        null,
        null,
        'NoPengajuan',
        'Divisi',
        'Departemen',
        'Jabatan',
        'TipePerubahan',
        'SifatPerubahan',
        'Status',
        'CreatedDate',
        'CreatedBy'
    );

    private $column_search = array(
        'NoPengajuan',
        'Divisi',
        'Departemen',
        'Jabatan',
        'SifatPerubahan',
        'CreatedBy'
    );

    private $order = array('ID' => 'desc');

    // ==================== DataTables Methods ====================

    private function _get_datatables_query($param = null)
    {
        $this->db->select('*');
        $this->db->from($this->table_header);
        $grupId = $this->session->userdata('groupuser');

        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        // Filter by Status
        if (isset($_POST['filter_status']) && $_POST['filter_status'] !== '') {
            $this->db->where('Status', $_POST['filter_status']);
        }

        // Filter by Departemen
        if (isset($_POST['filter_dept']) && !empty($_POST['filter_dept'])) {
            $this->db->where('Departemen', $_POST['filter_dept']);
        }

        // Filter by Date Range
        if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
            $this->db->where('CreatedDate >=', date('Y-m-d', strtotime($_POST['start_date'])));
            $this->db->where('CreatedDate <=', date('Y-m-d', strtotime($_POST['end_date'])) . ' 23:59:59');
        }

        if ($param == 'dept') {
            $this->db->where('AppStatus', null);
            $this->db->where('AppStatus2', null);
            $this->db->where('AppStatus3', null);
            $this->db->where('Status', 1);
        }

        if ($param == 'divisi') {
            $this->db->where('AppStatus IS NOT NULL', null, false);;
            $this->db->where('AppStatus2', null);
            $this->db->where('AppStatus3', null);
        }

        if ($param == 'hrd') {
            $this->db->where('AppStatus IS NOT NULL', null, false);
            $this->db->where('AppStatus2 IS NOT NULL', null, false);
            $this->db->where('AppStatus3', null);
        }

        $this->db->where("Departemen IN (SELECT DISTINCT DeptAbbr 
                             FROM vwGrupDept 
                             WHERE GroupID = " . $grupId . ")", null, false);

        //  laporan dissaprove
        $this->db->where('RejectedDate IS NULL', null, false);



        // if ($this->session->userdata('dept') != 'ITD' && ($this->session->userdata('dept') != 'HRD') && ($param != 'divisi' || $param != 'hrd')) {
        //     $this->db->where('Departemen', $this->session->userdata('dept'));
        // }


        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables($param = null)
    {
        $this->_get_datatables_query($param);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
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
        return $this->db->from($this->table_header)->count_all_results();
    }

    function approve($id, $data)
    {
        $this->db->where('ID', $id);
        return $this->db->update($this->table_header, $data);
    }

    function approve_batch($ids, $data)
    {
        if (empty($ids)) {
            return false;
        }

        $this->db->where_in('ID', $ids);
        $this->db->update($this->table_header, $data);

        return ($this->db->affected_rows() > 0);
    }
}
