<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model untuk Form Pengajuan Perubahan MPP
 * Author: Generated
 */

class M_perubahanmpp extends My_Model
{
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

    private function _get_datatables_query()
    {
        $this->db->select('*');
        $this->db->from($this->table_header);

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
            if ($_POST['filter_status'] == 2) {
                $this->db->where_in('Status', [4]);
            } elseif ($_POST['filter_status'] == 6) {
                $this->db->where_in('Status', [0, 2, 3]);
            } else {
                $this->db->where('Status', $_POST['filter_status']);
            }
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
        $grupId = $this->session->userdata('groupuser');
        $this->db->where("Departemen IN (SELECT DISTINCT DeptAbbr 
                             FROM vwGrupDept 
                             WHERE GroupID = " . $grupId . ")", null, false);

        // if ($this->session->userdata('dept') != 'ITD' && ($this->session->userdata('dept') != 'HRD')) {
        //     $this->db->where('Departemen', $this->session->userdata('dept'));
        // }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
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

    // ==================== CRUD Header ====================

    /**
     * Insert header dan generate nomor pengajuan
     */
    public function insertHeader($data)
    {
        // Generate nomor pengajuan
        $noPengajuan = $this->_generateNoPengajuan();
        $data['NoPengajuan'] = $noPengajuan;

        $this->db->insert($this->table_header, $data);
        return $this->db->insert_id();
    }

    /**
     * Generate nomor pengajuan otomatis
     * Format: MPP/YYYY/MM/XXXX
     */
    private function _generateNoPengajuan()
    {
        $year = date('Y');
        $month = date('m');
        $prefix = "MPP/{$year}/{$month}/";

        // Get last number
        $this->db->select('NoPengajuan');
        $this->db->from($this->table_header);
        $this->db->like('NoPengajuan', $prefix, 'after');
        $this->db->order_by('ID', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $lastNo = $query->row()->NoPengajuan;
            $lastNumber = (int) substr($lastNo, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Update header
     */
    public function updateHeader($id, $data)
    {
        $this->db->where('ID', $id);
        return $this->db->update($this->table_header, $data);
    }

    /**
     * Delete header
     */
    public function deleteHeader($id)
    {
        $this->db->where('ID', $id);
        return $this->db->delete($this->table_header);
    }

    /**
     * Get header by ID
     */
    public function getHeaderById($id)
    {
        $this->db->where('ID', $id);
        $query = $this->db->get($this->table_header);
        return $query->row();
    }

    /**
     * Update status pengajuan
     */
    public function updateStatus($id, $status, $userId)
    {
        $data = array(
            'Status' => $status,
            'UpdatedBy' => $userId,
            'UpdatedDate' => date('Y-m-d H:i:s')
        );

        if ($status == 1) {
            $data['SubmittedDate'] = date('Y-m-d H:i:s');
            $data['SubmittedBy'] = $userId;
        } elseif ($status == 2) {
            $data['ApprovedDate'] = date('Y-m-d H:i:s');
            $data['ApprovedBy'] = $userId;
        } elseif ($status == 3) {
            $data['RejectedDate'] = date('Y-m-d H:i:s');
            $data['RejectedBy'] = $userId;
        }

        $this->db->where('ID', $id);
        return $this->db->update($this->table_header, $data);
    }

    // ==================== CRUD Detail ====================

    /**
     * Insert detail lampiran
     */
    public function insertDetail($data)
    {
        $this->db->insert($this->table_detail, $data);
        return $this->db->insert_id();
    }

    /**
     * Get detail by header ID dan tipe lampiran
     */
    public function getDetailByHeaderId($headerId, $tipeLampiran = null)
    {
        $this->db->where('HeaderID', $headerId);
        if ($tipeLampiran) {
            $this->db->where('TipeLampiran', $tipeLampiran);
        }
        $query = $this->db->get($this->table_detail);

        if ($tipeLampiran) {
            return $query->row();
        }
        return $query->result();
    }

    /**
     * Delete detail by header ID
     */
    public function deleteDetailByHeaderId($headerId)
    {
        $this->db->where('HeaderID', $headerId);
        return $this->db->delete($this->table_detail);
    }

    // ==================== Master Data ====================

    /**
     * Get list Divisi
     */
    public function getDivisi($dept = null)
    {
        $dept ? $con = "WHERE DeptAbbr ='$dept'" : $con = "";
        $query = $this->db->query("SELECT * FROM PSGPayroll.dbo.vwMstDepartemen $con");
        return $query->result();
    }

    /**
     * Get list Departemen
     */
    public function getDept()
    {
        return json_decode($this->curl->simple_get(setAPI2() . "p1_get_all_departemen"));
    }

    /**
     * Get list Sub Departemen
     */
    public function getSubDept()
    {
        return json_decode($this->curl->simple_get(setAPI2() . "p1_get_all_bagian"));
    }

    /**
     * Get Sub Departemen by Departemen ID
     */
    public function getSubDeptByDept($deptId)
    {
        $this->db->select('IDSubDept, SubDeptAbbr, SubDeptName');
        $this->db->from('tblMstSubDepartemen');
        $this->db->where('IDDept', $deptId);
        $this->db->where('IsActive', 1);
        $this->db->order_by('SubDeptName', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get list Jabatan
     */
    public function getJabatan()
    {
        return json_decode($this->curl->simple_post(setAPI2() . "p1_get_all_jabatan", array(CURLOPT_BUFFERSIZE => 10)));
    }

    /**
     * Get Jabatan by Departemen ID
     */
    public function getJabatanByDept($deptId)
    {
        $this->db->select('IDJabatan, JabatanAbbr, JabatanName');
        $this->db->from('tblMstJabatan');
        $this->db->where('IDDept', $deptId);
        $this->db->where('IsActive', 1);
        $this->db->order_by('JabatanName', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get list Sub Jabatan
     */
    public function getSubJabatan()
    {
        $query = $this->db->get('tblMstSubJabatan');
        return $query->result();
    }

    /**
     * Get Sub Jabatan by Jabatan ID
     */
    public function getSubJabatanByJabatan($jabatanId)
    {
        $this->db->select('IDSubJabatan, SubJabatanAbbr, SubJabatanName');
        $this->db->from('tblMstSubJabatan');
        $this->db->where('IDJabatan', $jabatanId);
        $this->db->where('IsActive', 1);
        $this->db->order_by('SubJabatanName', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get list Level Jabatan
     */
    public function getLevelJabatan()
    {
        $this->db->select('IDLevel, LevelName');
        $this->db->from('tblMstLevelJabatan');
        $this->db->where('IsActive', 1);
        $this->db->order_by('IDLevel', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // ==================== Reporting ====================

    /**
     * Get summary pengajuan per status
     */
    public function getSummaryByStatus()
    {
        $sql = "SELECT 
                    Status,
                    COUNT(*) as Total
                FROM {$this->table_header}
                GROUP BY Status";
        $query = $this->db->query($sql);
        return $query->result();
    }

    /**
     * Get summary pengajuan per departemen
     */
    public function getSummaryByDept()
    {
        $sql = "SELECT 
                    Departemen,
                    COUNT(*) as Total,
                    SUM(CASE WHEN Status = 0 THEN 1 ELSE 0 END) as Draft,
                    SUM(CASE WHEN Status = 1 THEN 1 ELSE 0 END) as Submitted,
                    SUM(CASE WHEN Status = 2 THEN 1 ELSE 0 END) as Approved,
                    SUM(CASE WHEN Status = 3 THEN 1 ELSE 0 END) as Rejected
                FROM {$this->table_header}
                GROUP BY Departemen
                ORDER BY Departemen";
        $query = $this->db->query($sql);
        return $query->result();
    }

    /**
     * Get pengajuan yang pending approval
     */
    public function getPendingApproval($limit = 10)
    {
        $this->db->where('Status', 1);
        $this->db->order_by('SubmittedDate', 'ASC');
        $this->db->limit($limit);
        $query = $this->db->get($this->table_header);
        return $query->result();
    }
}
