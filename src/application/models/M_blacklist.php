<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_blacklist extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        // $this->dbpayroll   = $this->load->database('rsuppayroll', TRUE);
        //       $this->dbborongan   = $this->load->database('rsupborongan', TRUE);
    }

    function getData($NIK)
    {
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM PSGPayroll.dbo.v_kk_mstkaryawan WHERE NIK ='$NIK'");
        return $query->result();
    }

    function save($data)
    {
        $this->db->insert('tblTrnBlacklist', $data);
        $hdrid = $this->db->insert_id();
        $this->db->trans_complete();
        return $hdrid;
    }

    public function selectBlacklistK()
    {
        $query = $this->db->query("SELECT * FROM vwTrnBlacklistK WHERE CVNama='PT. PULAU SAMBU GUNTUNG'");
        return $query->result();
    }

    public function filterselectBlacklistK($nama)
    {
        $query = $this->db->query("SELECT * FROM vwTrnBlacklistK WHERE CVNama='PT. PULAU SAMBU GUNTUNG' AND NAMA LIKE '%$nama%'");
        return $query->result();
    }

    public function selectBlacklistTK()
    {
        $query = $this->db->query("SELECT * FROM vwTrnBlacklistTK WHERE CVNama != 'PT. PULAU SAMBU GUNTUNG'");
        return $query->result();
    }

    public function selectBlacklistTenakerCancel()
    {
        $query = $this->db->query("SELECT * FROM vwTrnBlackListByCancel WHERE sudah_3_bulan = 0 AND Status_Blacklist = 1");
        return $query->result();
    }

    public function selectBlacklistTenakerCancelFilter($nama)
    {
        $query = $this->db->query("SELECT * FROM vwTrnBlackListByCancel WHERE sudah_3_bulan = 0 AND Nama LIKE '%$nama%'");
        return $query->result();
    }

    public function filterselectBlacklistTK($nama)
    {
        $query = $this->db->query("SELECT * FROM vwTrnBlacklistTK WHERE CVNama != 'PT. PULAU SAMBU GUNTUNG' AND NAMA LIKE '%$nama%'");
        return $query->result();
    }

    function getDataBlacklistK($nik)
    {
        $sql_product = $this->db->query("SELECT * FROM PSGPayroll.dbo.vwMstKaryawan WHERE NIK ='$nik'");
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function getDataBlacklistTK($nik)
    {
        $sql_product = $this->db->query("SELECT * FROM [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja WHERE Nik ='$nik'");
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function printBlacklistKaryawan()
    {
        $query = $this->db->query("SELECT * FROM vwTrnBlacklistK");
        return $query->result();
    }

    function printBlacklistTenaker()
    {
        $query = $this->db->query("SELECT * FROM vwTrnBlacklistTK");
        return $query->result();
    }

    // detail KARYAWAN

    function get_karyawan($nik)
    {
        return $this->db->get_where('vwTrnBlacklistK', array('NIK' => $nik));
    }

    function get_tenaker($nik)
    {
        return $this->db->get_where('vwTrnBlacklistTK', array('NIK' => $nik));
    }
    function get_tenaker_cancel($nik)
    {
        return $this->db->get_where('vwTrnBlackListByCancel', array('NIK' => $nik));
    }

    // BY PASS

    function savebypass($data)
    {
        $this->db->insert('tblTrnBlacklistTemporary', $data);
        $hdrid = $this->db->insert_id();
        $this->db->trans_complete();
        return $hdrid;
    }

    function getPSGPemborong($idpemborong)
    {
        if ($idpemborong > 0) {
            $result = $this->db->get_where('vwMstPemborong', array('IDPerusahaan' => $idpemborong));
        } else {
            $this->db->select('*');
            $this->db->from('vwMstPemborong');
            $this->db->order_by('Perusahaan', 'ASC');
            $result = $this->db->get();
        }
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

    public function selectBlacklistByPass()
    {
        $query = $this->db->query("SELECT * FROM tblTrnBlacklistTemporary ORDER BY Detail DESC");
        return $query->result();
    }

    public function filterselectBlacklistByPass($nama)
    {
        $query = $this->db->query("SELECT * FROM tblTrnBlacklistTemporary WHERE Nama LIKE '%$nama%' ORDER BY Detail DESC");
        return $query->result();
    }

    function get_detailbypass($id)
    {
        return $this->db->get_where('tblTrnBlacklistTemporary', array('Detail' => $id));
    }

    function update_status_foto($id)
    {
        // $this->db->trans_start();
        // $this->db->where('Detail',$id);
        // $this->db->set('AdaPhoto','1');
        // $this->db->update('tblTrnBlacklistTemporary');
        // $this->db->trans_complete();
        $query = $this->db->query("UPDATE tblTrnBlacklistTemporary SET AdaPhoto='1' WHERE Detail='$id'");
    }

    function selectBlacklistKRSUP()
    {
        $query = $this->load->database('rsuppayroll', TRUE)->query("SELECT * FROM RSUPPayroll..vwDataKaryawanNonFinanceAll WHERE Blacklist='1'");
        return $query->result();
    }

    function filterselectBlacklistKRSUP($nama)
    {
        $query = $this->load->database('rsuppayroll', TRUE)->query("SELECT * FROM RSUPPayroll..vwDataKaryawanNonFinanceAll WHERE Blacklist='1' AND NAMA like '%$nama%'");
        return $query->result();
    }

    function selectBlacklistTKRSUP()
    {
        $query = $this->load->database('rsupborongan', TRUE)->query("SELECT * FROM RSUPBorongan2010..vwMasterTenagaKerja WHERE Blacklist='1'");
        return $query->result();
    }
    function filterselectBlacklistTKRSUP($nama)
    {
        $query = $this->load->database('rsupborongan', TRUE)->query("SELECT * FROM RSUPBorongan2010..vwMasterTenagaKerja WHERE Blacklist='1'  AND NAMA like '%$nama%'");
        return $query->result();
    }

    function get_detailKRSUP($id)
    {
        return $this->load->database('rsuppayroll', TRUE)->get_where('RSUPPayroll..vwDataKaryawanNonFinanceAll', array('RegNo' => $id));
    }

    function get_detailTKRSUP($id)
    {
        return $this->load->database('rsuppayroll', TRUE)->get_where('RSUPBorongan2010..vwMasterTenagaKerja', array('RequestID' => $id));
    }

    function blok_dua_bulan()
    {
        $query = $this->db->query("SELECT DATEDIFF(month, TGLKELUAR, GETDATE()) AS JarakBulan, * FROM vwTrnBlacklistTK WHERE CVNama != 'PT. PULAU SAMBU GUNTUNG' AND BlackListDuaBulan = 1 AND DATEDIFF(month,  TGLKELUAR,GETDATE()) > 6");
        return $query->result();
    }

    function updateStatusCancel($nik)
    {
        $this->db->trans_start();

        $this->db->where('NIK', $nik);
        $success = $this->db->update('tblTrnBlacklistByCancel', ['Status_Blacklist' => 0, 'Update_By' => strtoupper($this->session->userdata('username')), 'Update_Date' =>  date('Y-m-d H:i:s')]);

        if (!$success) {
            // Error handling
            $this->db->trans_rollback();
            $error = $this->db->error();
            return 0;
        }

        // Commit transaction
        $this->db->trans_commit();

        return 1;
    }

    function get_tenaker_cancel_excel()
    {
        $query = $this->db->query("SELECT
                                    a.*,
                                    b.Keterangan 
                                FROM
                                    vwTrnBlackListByCancel a
                                    LEFT JOIN tblTrnWawancara b ON A.NIK = B.HeaderID 
                                ORDER BY
                                    a.ID DESC");
        return $query->result();
    }

    /**
     * ################################################################### Module Salmonella Carrier ###################################################################
     * 
     */

    private $column_order = array(

        'HeaderID',
        'Nama',
        'No_Ktp',
        '',
        'Jenis_kelamin',
        'Nama_Ibu',
        'CV_Nama',
        'Pemborong',
        'Sub_Pemborong',
        'Keterangan',

    );

    private $column_search = array(
        'id',
        'HeaderID',
        'Nama',
        'Pemborong',
        'Sub_Pemborong',
        'Jenis_kelamin',
        'CV_Nama',
        'Pemborong',
        'Sub_Pemborong',
        'Keterangan',
    );

    private $order = array('id' => 'desc'); // default order 


    public function get_datatables($table)
    {
        $this->_get_datatables_query($table);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered($table)
    {
        $this->_get_datatables_query($table);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($table)
    {
        return $this->db->from($table)
            ->count_all_results();
    }

    private function _get_datatables_query($table)
    {

        $this->db->select('A.*');
        // $this->db->from('a' . $table . ' AS A');
        $this->db->from($table . ' AS A');

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


        $this->db->where("Status_Blacklist", '1');


        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->column_order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function getTenaker($nik)
    {
        $this->db->select('A.*');
        $this->db->from('tblTrnCalonTenagaKerja AS A');
        $this->db->where("A.HeaderID", $nik);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function saveSalmonellaCarrier($dataInsert)
    {

        $this->db->trans_start();
        $this->db->insert('tblTrnSalmonellaCarrier', $dataInsert);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    function updateSalmonellaCarrier($HeaderID, $updateData)
    {

        $this->db->trans_start();
        $this->db->where('HeaderID', $HeaderID);
        $this->db->update('tblTrnCalonTenagaKerja', $updateData);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    function checkNik($nik)
    {
        $this->db->select('HeaderID');
        $this->db->from('tblTrnSalmonellaCarrier');
        $this->db->where('HeaderID', $nik);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function deleteSalmonellaCarrier($nik, $updateData)
    {
        $this->db->trans_start();
        $this->db->where('HeaderID', $nik);
        $this->db->update('tblTrnSalmonellaCarrier', $updateData);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    function deleteSalmonellaCarrier_b($nik, $updateData)
    {
        $this->db->trans_start();
        $this->db->where('HeaderID', $nik);
        $this->db->update('tblTrnCalonTenagaKerja', $updateData);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            return true;
        }
    }
    function updateNotif($nik)
    {
        $data = [
            'notif'           => '0',
            'notifUpdateBy'   => strtoupper($this->session->userdata('username')),
            'notifUpdateDate' => date('Y-m-d H: i: s')
        ];

        $this->db->trans_start();
        $this->db->where('HeaderID', $nik);
        $this->db->update('tblTrnSalmonellaCarrier',  $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    public function get_suggestions($term)
    {
        // $this->PSGKlinik = $this->load->database('PSGKlinik', TRUE);

        $this->db->select('*');
        $this->db->from('tblTrnCalonTenagaKerja');
        $this->db->group_start(); // buka group OR
        $this->db->like('Nama', $term);
        $this->db->or_like('HeaderID', $term);
        // $this->db->or_like('bagian_abbr', $term);
        $this->db->group_end();   // tutup group OR
        $this->db->limit(20);

        $query = $this->db->get();
        return $query->result();
    }
}
