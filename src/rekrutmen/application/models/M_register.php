<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_register extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->PSGPayroll = $this->load->database('PSGPayroll', TRUE);
    }

    private $column_order_main_ctkb = array(
        NULL,
        'A.HeaderID',
        'Nama',
        'Pemborong',
        'SubPemborong',
        // 'Tgl_Lahir',
        // 'Jenis_Kelamin',
        // 'RegisteredBy',
        // 'DikirimDate',
        // 'Jenis_Kelamin',
        // 'RegisteredDate',
        // 'Vaksin',
        // 'KeteranganKirim',
        // 'Proses',
        // 'Kualifikasi',
    );
    //field yang diizin untuk pencarian
    private $column_search_main_ctkb = array(
        'A.HeaderID',
        'Nama',
        'Pemborong',
        'SubPemborong',
        // 'Tgl_Lahir',
        // 'Jenis_Kelamin',
        // 'RegisteredBy',
        // 'DikirimDate',
        // 'A.HeaderID',
        // 'Nama',
        // 'Pemborong',
        // 'SubPemborong',
        // 'Tgl_Lahir',
        // 'Jenis_Kelamin',
        // 'RegisteredBy',
        // 'RegisteredDate',
        // 'DikirimDate',
        // 'Vaksin',
        // 'KeteranganKirim',
        // 'Proses',
        // 'Kualifikasi',
    );

    private $order_main_ctkb = array('HeaderID' => 'desc');



    // private function _get_datatables_query($table, $proses = '')
    // {
    //     $idpemborong = $this->session->userdata('idpemborong');


    //     if ($idpemborong > 0) {
    //         $this->db->select('*');
    //         $this->db->from($table);
    //         $this->db->where('PostingData', 0);
    //         $this->db->where('StatusDaftar IS NOT NULL', null, false);
    //         $this->db->where('StatusDaftar <>', 1);

    //         if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
    //             $this->db->where('DikirimDate >=', date('Y-m-d', strtotime($_POST['start_date'])));
    //             $this->db->where('DikirimDate <=', date('Y-m-d', strtotime($_POST['end_date'])));
    //         }
    //         $this->db->group_start();  // Start grouping for OR condition
    //         $this->db->where('CVNama IN (SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = ' . $this->db->escape($idpemborong) . ')', null, false);
    //         $this->db->or_where('CVNama IN (SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = ' . $this->db->escape($idpemborong) . ')', null, false);
    //         $this->db->group_end();  // End grouping for OR condition
    //         // $this->db->order_by('headerid', 'DESC');
    //     } else {

    //         if ($table == 'vwListTenakerForPemborong') {
    //             $this->db->select('A.*,C.kesimpulanCU, B.BerkasID, B.KTP, B.CV, B.Lamaran, B.Ijazah, B.Transkrip, B.SuratKontrak, B.Vaksin1, B.Vaksin2, B.Vaksin3, B.KK, B.SKCK');
    //             $this->db->from($table . ' AS A');
    //             $this->db->join('dbo.tblTrnBerkas AS B', 'A.HeaderID = B.HeaderID', 'inner');
    //             $this->db->join('PSGKlinik.dbo.tbl_kk_MstMedicalTemporaryTKNew AS C', 'A.HeaderID = C.HeaderID ', 'left');
    //             $this->db->where('PostingData', 0);
    //             $this->db->where('StatusDaftar IS NOT NULL');

    //             if ($proses == 'proses') {
    //                 $this->db->where('Proses', 'proses');
    //                 $this->db->where('StatusDaftar', 1);
    //                 $this->db->where('JadwalInterview IS NULL');
    //                 $this->db->where('kesimpulanCU IS NOT NULL');
    //             } elseif ($proses == 'mcu') {
    //                 $this->db->where('Proses', 'proses');
    //                 $this->db->where('StatusDaftar', 1);
    //                 $this->db->where('kesimpulanCU IS NULL');
    //                 $this->db->where('mcu_date IS NULL');
    //                 $this->db->where('mcu_update_by IS NULL');
    //             } else {
    //                 $this->db->where('StatusDaftar <>', 1);
    //                 // $this->db->where('DATEDIFF(month, A.RegisteredDate, GETDATE()) <=', 3);
    //                 $this->db->where('DATEDIFF(month, A.RegisteredDate, GETDATE()) <=', 5);
    //             }

    //             if (!empty($_POST['start_process_date']) && !empty($_POST['end_process_date'])) {
    //                 $this->db->where('DiprosesDate >=', date('Y-m-d', strtotime($_POST['start_process_date'])));
    //                 $this->db->where('DiprosesDate <=', date('Y-m-d', strtotime($_POST['end_process_date'])));
    //             }


    //             $this->db->group_start();  // Start grouping of where clauses
    //             $this->db->where('KeteranganKirim !=', 'blacklist');
    //             $this->db->where('KeteranganKirim !=', 'blacklist_2_bln');
    //             $this->db->where('KeteranganKirim !=', 'blacklist_6_bln');
    //             $this->db->or_where('KeteranganKirim IS NULL');
    //             $this->db->group_end();  // End grouping of where clauses
    //             // $this->db->order_by('HeaderID', 'DESC');
    //         } else {

    //             $this->db->select('*');
    //             $this->db->from($table);
    //         }
    //     }

    //     $this->db->limit(500);

    //     $i = 0;

    //     foreach ($this->column_search_main_ctkb as $item) // loop column 
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
    //             if (count($this->column_search_main_ctkb) - 1 == $i)  //last loop
    //                 $this->db->group_end(); //close bracket
    //         }
    //         $i++;
    //     }




    //     if (isset($_POST['order'])) // here order processing
    //     {
    //         $this->db->order_by($this->column_order_main_ctkb[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    //     } else if (isset($this->order_main_ctkb)) {
    //         $order = $this->order_main_ctkb;
    //         $this->db->order_by(key($order), $order[key($order)]);
    //     }
    // }


    // public function get_datatables($table, $proses = '')
    // {
    //     $this->_get_datatables_query($table, $proses);
    //     if ($_POST['length'] != -1)
    //         $this->db->limit($_POST['length'], $_POST['start']);
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    // public function count_filtered($table)
    // {
    //     $this->_get_datatables_query($table);
    //     $query = $this->db->get();
    //     return $query->num_rows();
    // }

    // public function count_all($table)
    // {
    //     return $this->db->from($table)
    //         ->count_all_results();
    // }

    // methode baru dengan merge data medical dari sambusehat + post-filter MCU
    private function _get_datatables_query($table, $proses = '')
    {
        $idpemborong = $this->session->userdata('idpemborong');

        if ($idpemborong > 0) {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where('PostingData', 0);
            $this->db->where('StatusDaftar IS NOT NULL', null, false);
            $this->db->where('StatusDaftar <>', 1);

            if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
                $this->db->where('DikirimDate >=', date('Y-m-d', strtotime($_POST['start_date'])));
                $this->db->where('DikirimDate <=', date('Y-m-d', strtotime($_POST['end_date'])));
            }
            $this->db->group_start();
            $this->db->where('CVNama IN (SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = ' . $this->db->escape($idpemborong) . ')', null, false);
            $this->db->or_where('CVNama IN (SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = ' . $this->db->escape($idpemborong) . ')', null, false);
            $this->db->group_end();
        } else {

            if ($table == 'vwListTenakerForPemborong') {
                // Select tanpa kolom C (akan di-merge dari sambusehat)
                $this->db->select('A.*, B.BerkasID, B.KTP, B.CV, B.Lamaran, B.Ijazah, B.Transkrip, B.SuratKontrak, B.Vaksin1, B.Vaksin2, B.Vaksin3, B.KK, B.SKCK');
                $this->db->from($table . ' AS A');
                $this->db->join('dbo.tblTrnBerkas AS B', 'A.HeaderID = B.HeaderID', 'inner');
                // JOIN ke PSGKlinik dihapus

                $this->db->where('PostingData', 0);
                $this->db->where('StatusDaftar IS NOT NULL');

                // Pre-filter HeaderID dari sambusehat untuk case yg butuh kesimpulanCU
                $headerIdsFromPgsql = $this->_get_header_ids_from_pgsql_filter_ctkb($proses);
                if ($headerIdsFromPgsql !== null) {
                    if (empty($headerIdsFromPgsql)) {
                        $this->db->where('1 = 0', NULL, FALSE);
                    } else {
                        $this->db->where_in('A.HeaderID', $headerIdsFromPgsql);
                    }
                }

                if ($proses == 'proses') {
                    $this->db->where('Proses', 'proses');
                    $this->db->where('StatusDaftar', 1);
                    $this->db->where('JadwalInterview IS NULL');
                    // kesimpulanCU IS NOT NULL → sudah di-pre-filter
                } elseif ($proses == 'mcu') {
                    $this->db->where('Proses', 'proses');
                    $this->db->where('StatusDaftar', 1);
                    // kesimpulanCU IS NULL → di post-filter setelah merge
                    $this->db->where('mcu_date IS NULL');
                    $this->db->where('mcu_update_by IS NULL');
                } else {
                    $this->db->where('StatusDaftar <>', 1);
                    $this->db->where('DATEDIFF(month, A.RegisteredDate, GETDATE()) <=', 5);
                }

                if (!empty($_POST['start_process_date']) && !empty($_POST['end_process_date'])) {
                    $this->db->where('DiprosesDate >=', date('Y-m-d', strtotime($_POST['start_process_date'])));
                    $this->db->where('DiprosesDate <=', date('Y-m-d', strtotime($_POST['end_process_date'])));
                }

                $this->db->group_start();
                $this->db->where('KeteranganKirim !=', 'blacklist');
                $this->db->where('KeteranganKirim !=', 'blacklist_2_bln');
                $this->db->where('KeteranganKirim !=', 'blacklist_6_bln');
                $this->db->or_where('KeteranganKirim IS NULL');
                $this->db->group_end();
            } else {
                $this->db->select('*');
                $this->db->from($table);
            }
        }

        $this->db->limit(500);

        $i = 0;
        foreach ($this->column_search_main_ctkb as $item) {
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
                if (count($this->column_search_main_ctkb) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order_main_ctkb[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_main_ctkb)) {
            $order = $this->order_main_ctkb;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    /**
     * Pre-filter HeaderID dari sambusehat berdasarkan parameter $proses
     *
     * @return array|null  null = tidak perlu pre-filter, [] = tidak ada match, array = list HeaderID
     */

    private function _get_header_ids_from_pgsql_filter_ctkb($proses)
    {
        if ($proses != 'proses') return null; // hanya case 'proses' yg pre-filter

        // Step 1: Ambil kandidat HeaderID dari tabel A
        $candidateIds = $this->_get_candidate_header_ids($proses);

        if (empty($candidateIds)) return [];

        // Step 2: Cek mana yg punya kesimpulan_mcu di sambusehat
        $dbPgsql = $this->load->database('sambusehat', TRUE);
        $rows = $dbPgsql->select('header_id')
            ->from('mcu_trx_medical_hdr')
            ->where('kesimpulan_mcu IS NOT NULL')
            ->where_in('header_id', $candidateIds)
            ->get()->result();

        return array_column($rows, 'header_id');
    }

    public function get_datatables($table, $proses = '')
    {
        $this->_get_datatables_query($table, $proses);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        $dataA = $query->result();

        // Merge dengan data medical dari sambusehat
        $merged = $this->_merge_with_pgsql_medical($dataA);

        // Post-filter untuk case 'mcu' → kesimpulanCU IS NULL
        if ($proses == 'mcu' && $table == 'vwListTenakerForPemborong') {
            $merged = array_values(array_filter($merged, function ($row) {
                return !isset($row->kesimpulan_mcu) || $row->kesimpulan_mcu === null;
            }));
        }
        return $merged;
    }

    public function count_filtered($table, $proses = '')
    {
        $this->_get_datatables_query($table, $proses);
        $query = $this->db->get();

        // Untuk case 'mcu', harus merge + filter dulu baru hitung
        if ($proses == 'mcu' && $table == 'vwListTenakerForPemborong') {
            $dataA = $query->result();
            $merged = $this->_merge_with_pgsql_medical($dataA);
            $filtered = array_filter($merged, function ($row) {
                return !isset($row->kesimpulan_mcu) || $row->kesimpulan_mcu === null;
            });
            return count($filtered);
        }

        return $query->num_rows();
    }

    public function count_all($table)
    {
        return $this->db->from($table)
            ->count_all_results();
    }

    private function _merge_with_pgsql_medical($dataA)
    {
        if (empty($dataA)) return [];

        $dbPgsql   = $this->load->database('sambusehat', TRUE);
        $headerIds = array_column($dataA, 'HeaderID');

        // Tentukan kolom yang mau di-expose (sesuai yg dipakai controller/view)
        $selectCols = 'header_id, approved_dokter_by, kesimpulan_mcu';

        // Daftar kolom B yg harus selalu ada di output (tanpa header_id)
        $bColumns = ['approved_dokter_by', 'kesimpulan_mcu'];

        // Mapping: nama kolom baru (pgsql) => nama kolom lama (alias biar kode lama tetap jalan)
        $aliasMap = [
            'approved_dokter_by' => 'apvdokterby',
            'kesimpulan_mcu'     => 'kesimpulanCU',
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

            // Copy nilai kolom baru ke nama kolom lama (alias)
            foreach ($aliasMap as $newName => $oldName) {
                $row->$oldName = $row->$newName ?? null;
            }
        }
        unset($row);

        return $dataA;
    }

    /**
     * Ambil HeaderID kandidat dari tabel A (tanpa filter kesimpulanCU)
     * Dipakai untuk membatasi scope query ke sambusehat
     */

    // private function _get_candidate_header_ids($proses)
    // {
    //     // Pakai koneksi terpisah biar tidak bentrok dengan $this->db
    //     $db = $this->load->database('default', TRUE);

    //     $db->select('A.HeaderID')
    //         ->from('vwListTenakerForPemborong AS A')
    //         ->join('dbo.tblTrnBerkas AS B', 'A.HeaderID = B.HeaderID', 'inner')
    //         ->where('PostingData', 0)
    //         ->where('StatusDaftar IS NOT NULL');

    //     if ($proses == 'proses') {
    //         $db->where('Proses', 'proses');
    //         $db->where('StatusDaftar', 1);
    //         $db->where('JadwalInterview IS NULL');
    //     }

    //     if (!empty($_POST['start_process_date']) && !empty($_POST['end_process_date'])) {
    //         $db->where('DiprosesDate >=', date('Y-m-d', strtotime($_POST['start_process_date'])));
    //         $db->where('DiprosesDate <=', date('Y-m-d', strtotime($_POST['end_process_date'])));
    //     }

    //     $db->group_start();
    //     $db->where('KeteranganKirim !=', 'blacklist');
    //     $db->where('KeteranganKirim !=', 'blacklist_2_bln');
    //     $db->where('KeteranganKirim !=', 'blacklist_6_bln');
    //     $db->or_where('KeteranganKirim IS NULL');
    //     $db->group_end();
    //     $db->order_by('A.HeaderID', 'DESC');
    //     $db->limit(2000);

    //     $rows = $db->get()->result();
    //     return array_column($rows, 'HeaderID');
    // }

    private function _get_candidate_header_ids($proses)
    {
        $db = $this->load->database('default', TRUE);

        $db->select('A.HeaderID')
            ->from('vwListTenakerForPemborong AS A')
            ->join('dbo.tblTrnBerkas AS B', 'A.HeaderID = B.HeaderID', 'inner')
            ->where('PostingData', 0)
            ->where('StatusDaftar IS NOT NULL');

        if ($proses == 'proses') {
            $db->where('Proses', 'proses');
            $db->where('StatusDaftar', 1);
            $db->where('JadwalInterview IS NULL');
        }

        if (!empty($_POST['start_process_date']) && !empty($_POST['end_process_date'])) {
            $db->where('DiprosesDate >=', date('Y-m-d', strtotime($_POST['start_process_date'])));
            $db->where('DiprosesDate <=', date('Y-m-d', strtotime($_POST['end_process_date'])));
        }

        $db->group_start();
        $db->where('KeteranganKirim !=', 'blacklist');
        $db->where('KeteranganKirim !=', 'blacklist_2_bln');
        $db->where('KeteranganKirim !=', 'blacklist_6_bln');
        $db->or_where('KeteranganKirim IS NULL');
        $db->group_end();

        // 🔍 SEARCH (FIX: pakai $db, bukan $this->db)
        $i = 0;
        foreach ($this->column_search_main_ctkb as $item) {
            if (!empty($_POST['search']['value'])) {
                $search_value = $_POST['search']['value'];

                if ($i === 0) {
                    $db->group_start();
                }

                if ($item == 'date_time') {
                    $db->or_where("TO_CHAR($item, 'YYYY-MM-DD') LIKE '%$search_value%'", null, false);
                } else {
                    $db->or_like($item, $search_value);
                }

                if (count($this->column_search_main_ctkb) - 1 == $i) {
                    $db->group_end();
                }
            }
            $i++;
        }

        // // 🔽 ORDERING (prioritas: request dari datatable)
        // if (isset($_POST['order'])) {
        //     $db->order_by(
        //         $this->column_order_main_ctkb[$_POST['order']['0']['column']],
        //         $_POST['order']['0']['dir']
        //     );
        // } else if (isset($this->order_main_ctkb)) {
        //     $order = $this->order_main_ctkb;
        //     $db->order_by(key($order), $order[key($order)]);
        // } else {
        //     // default fallback
        //     $db->order_by('A.HeaderID', 'DESC');
        // }
        $db->order_by('A.HeaderID', 'DESC');
        $db->limit(2000);

        $rows = $db->get()->result();
        return array_column($rows, 'HeaderID');
    }


    // /////////////////

    //    function get_perusahaan_bygroup(){
    //        $pemborong = strtoupper($this->input->post('pemborong'));
    //        $query = $this->db->get_where('vwMstPemborong', array('Pemborong' => $pemborong));
    //        if ($query->num_rows() > 0){
    //                $row = $query->row();
    //                $perusahaan=$row->Perusahaan;
    //        }else{
    //                $perusahaan='';
    //        }
    //        return $perusahaan;
    //    }
    //        
    //    function get_pemborong_bygroup($idpemborong){
    //        if ($idpemborong > 0){
    //            $result = $this->db->get_where('vwMstPemborong', array('IDPemborong'=>$idpemborong));
    //        }else{
    //            $this->db->select('*');
    //            $this->db->from('vwMstPemborong');
    //            $this->db->order_by('IDPerusahaan','ASC');
    //            $this->db->order_by('IDPemborong','ASC');
    //            $result = $this->db->get();
    //        }
    //        return $result;
    //    }

    function getPSGPemborong($idpemborong)
    {
        //        $this->db->order_by('Perusahaan','ASC');
        //        $query = $this->db->get('PSGBorongan.dbo.tblMstPerusahaan');
        //        return $query->result();
        if ($idpemborong > 0) {
            $result = $this->db->get_where('vwMstPemborong', array('IDPerusahaan' => $idpemborong));
            $this->db->where('pimpinan is not null');
        } else {
            $this->db->select('*');
            $this->db->from('vwMstPemborong');
            $this->db->where('IDPerusahaan > 21 or IDPerusahaan = 20');
            $result = $this->db->get();
        }
        return $result->result();
    }
    function getPSGSubPemborong($idpemborong)
    {
        if ($idpemborong > 0) {
            $result = $this->db->get_where('vwMstSubPemborong', array('IDPerusahaan' => $idpemborong));
        } else {
            $this->db->select('*');
            $this->db->from('vwMstSubPemborong');
            $this->db->order_by('Perusahaan', 'ASC');
            $result = $this->db->get();
        }
        return $result->result();
    }

    function getPemborong()
    {
        $pemborong = strtoupper($this->input->post('pemborong'));

        $query = $this->db->query("SELECT * FROM vwMstPemborong WHERE Perusahaan = ? AND (IDPerusahaan > 21 OR IDPerusahaan = 20)", array($pemborong));
        return $query->result();
    }

    function getSubPemborong($subpemborong)
    {
        $query = $this->db->query("select * from vwmstsubpemborong where Perusahaan ='$subpemborong' and NamaSubPemborong is not null");
        return $query->result();
    }

    function PilihCTKB($start_date, $end_date, $idpemborong)
    {
        if ($idpemborong > 0) {
            $query = $this->db->query("SELECT * FROM vwListTenakerForPemborong WHERE PostingData = 0 AND StatusDaftar IS NOT NULL  AND StatusDaftar <> 1  AND registereddate >= '$start_date' 
            AND registereddate <= '$end_date' AND "
                . "( CVNama IN ( SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) OR CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) ) 
                ORDER BY headerid DESC");
        } else {
            /**
             * VINO MINTA RANGE tanggalnya sesuai dengan tanggal yang di daftarkan pemborong
             */
            $query = $this->db->query("SELECT TOP
                                            ( 1000 ) A.*,
                                            B.BerkasID,
                                            B.KTP,
                                            B.CV,
                                            B.Lamaran,
                                            B.Ijazah,
                                            B.Transkrip,
                                            B.SuratKontrak,
                                            B.Vaksin1,
                                            B.Vaksin2,
                                            B.Vaksin3,
                                            B.KK,
                                            B.SKCK 
                                        FROM
                                            vwListTenakerForPemborong AS A
                                            INNER JOIN dbo.tblTrnBerkas AS B ON A.HeaderID = b.HeaderID 
                                        WHERE
                                            PostingData = 0 
                                            AND StatusDaftar IS NOT NULL 
                                            AND StatusDaftar <> 1 
                                            -- AND DikirimDate >= '$start_date' 
                                            -- AND DikirimDate <= '$end_date' 
                                            AND DikirimDate >= '2024-03-05' 
                                            AND DikirimDate <= '2024-06-05' 
                                            AND ( KeteranganKirim != 'blacklist' OR KeteranganKirim IS NULL ) 
                                        ORDER BY
                                            headerid DESC");
        }

        return $query->result();
    }

    function PilihCTKBProses($start_date, $end_date, $idpemborong)
    {
        if ($idpemborong > 0) {
            $query = $this->db->query("SELECT * FROM vwListTenakerForPemborong WHERE PostingData = 0 AND StatusDaftar IS NOT NULL  AND StatusDaftar <> 1  AND registereddate >= '$start_date' 
            AND registereddate <= '$end_date' AND "
                . "( CVNama IN ( SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) OR CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) ) 
                ORDER BY headerid DESC");
        } else {
            /**
             * VINO MINTA RANGE tanggalnya sesuai dengan tanggal yang di daftarkan pemborong
             */
            $query = $this->db->query("SELECT
                                        A.*,
                                        B.BerkasID,
                                        B.KTP,
                                        B.CV,
                                        B.Lamaran,
                                        B.Ijazah,
                                        B.Transkrip,
                                        B.SuratKontrak,
                                        B.Vaksin1,
                                        B.Vaksin2,
                                        B.Vaksin3,
                                        B.KK,
                                        B.SKCK 
                                    FROM
                                        vwListTenakerForPemborong AS A
                                        LEFT JOIN dbo.tblTrnBerkas as B ON A.HeaderID = b.HeaderID  
                                    WHERE 
                                        PostingData = 0 
                                        AND StatusDaftar IS NOT NULL  
                                        AND StatusDaftar = 1 
                                        AND Proses = 'proses' 
                                        AND (JadwalInterview IS NULL OR JadwalInterview = '') 
                                        AND DikirimDate >= '$start_date' 
                                        AND DikirimDate <= '$end_date' 
                                        ORDER BY headerid DESC");
        }

        return $query->result();
    }

    // function listByPBR($idpemborong)
    // {
    //     if ($idpemborong > 0) {
    //         $query = $this->db->query("SELECT TOP ( 2000 ) * 
    //                                     FROM
    //                                         vwListTenakerForPemborong 
    //                                     WHERE
    //                                         PostingData = 0 
    //                                         AND StatusDaftar IS NULL 
    //                                         AND ( CVNama IN ( SELECT NamaCV FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) OR CVNama IN ( SELECT Perusahaan FROM vwMstPemborong WHERE IDPerusahaan = '" . $idpemborong . "' ) ) 
    //                                     ORDER BY
    //                                         headerid DESC");
    //     } else {
    //         $query = $this->db->query("SELECT TOP(2000) * FROM vwListTenakerForPemborong WHERE PostingData = 0 AND StatusDaftar IS NULL ORDER BY headerid DESC");
    //     }
    //     return $query->result();
    // }

    function listByPBR($idpemborong)
    {
        $this->db->select('*');
        $this->db->from('vwListTenakerForPemborong');
        $this->db->where('PostingData', 0);
        $this->db->where('StatusDaftar IS NULL', NULL, FALSE);
        $this->db->order_by('headerid', 'DESC');
        $this->db->limit(900);
        //rubah dari 2000 jadi 1000 25/03/2025

        if ($idpemborong > 0) {
            $this->db->join('vwMstPemborong', 'vwListTenakerForPemborong.CVNama = vwMstPemborong.NamaCV OR vwListTenakerForPemborong.CVNama = vwMstPemborong.Perusahaan', 'inner');
            $this->db->where('vwMstPemborong.IDPerusahaan', $idpemborong);
        }
        // var_dump($idpemborong);
        // exit;

        $query = $this->db->get();
        return $query->result();
    }


    function updateDikirim($data)
    {
        $this->db->trans_start();
        // $this->db->where_in('HeaderID', $id);
        // $this->db->update('tblTrnCalonTenagaKerja', $data);
        $this->db->update_batch('tblTrnCalonTenagaKerja', $data, 'HeaderID');
        $rtn = $this->db->trans_complete();

        if ($rtn) {
            return 1;
        } else {
            return 0;
        }
    }

    function updateMCUDate($data)
    {
        $this->db->trans_start();
        // $this->db->where_in('HeaderID', $id);
        // $this->db->update('tblTrnCalonTenagaKerja', $data);
        $this->db->update_batch('tblTrnCalonTenagaKerja', $data, 'HeaderID');
        $rtn = $this->db->trans_complete();

        if ($rtn) {
            return 1;
        } else {
            return 0;
        }
    }

    function sendToBlacklist($headerId, $keterangan, $diprosesby, $diprosesDt, $StatusBlacklist, $statusBL6 = NULL)
    {
        $this->db->trans_begin();
        $this->db->query(
            "INSERT INTO tblTrnBlacklist (
                                CVNama,
                                Pemborong,
                                NIK,
                                DeptAbbr,
                                Remark,
                                NamaIbuKandung,
                                AdaPhotoOnline,
                                created_by,
                                created_date,
                                Nama,
                                Status,
                                IDPT,
                                NoKTP,
                                TglLahir,
                            BlackListDuaBulan,
                            BlackListEnamBulan,
                            HeaderID 
                            )
                            
                            SELECT
                                CVNama,
                                Pemborong,
                                ISNULL(NIK, '0') as NIK,
                                DeptTujuan as DeptAbbr,
                                '$keterangan' as Remark,
                                NamaIbuKandung,
                                AdaPhotoOnline,
                                '$diprosesby' as created_by,
                                CAST('$diprosesDt' AS DATE) AS created_date,
                                Nama,
                                'Blacklist' as Status,
                                'P1' as IDPT,
                                No_Ktp as NoKTP,
                                Tgl_Lahir as TglLahir,
                                '$StatusBlacklist' as BlackListDuaBulan,
                                '$statusBL6' as BlackListEnamBulan,
                                HeaderID
                            FROM
                                tblTrnCalonTenagaKerja 
                            WHERE
                                HeaderID = '$headerId'"
        );
        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            $result = 0;
        } else {
            $this->db->trans_commit();
            $result = 1;
        }

        return $result;
    }

    function getSuku()
    {
        $query = $this->db->get('tblMstSuku');
        return $query->result();
    }

    function getProvinsi()
    {
        $query = $this->db->get('PSGPayroll..tblMstProvinsi');
        return $query->result();
    }

    function getKabupaten($idprov)
    {
        $this->db->where('ProvinsiID', $idprov);
        $query = $this->db->get('PSGPayroll..tblMstKabKota');
        return $query;
    }

    function getkecamatan($idprov, $idkab)
    {
        $this->db->where('KabKotaID', $idkab);
        $this->db->where('ProvinsiID', $idprov);
        $query = $this->db->get('PSGPayroll..tblMstKecamatan');
        return $query;
    }

    function getAgama()
    {
        $query = $this->db->get('tblMstAgama');
        return $query->result();
    }

    function getStatusKawin()
    {
        $query = $this->db->get('tblMstStatusKawin');
        return $query->result();
    }

    function getPendidikan()
    {
        $this->db->ORDER_BY('ID');
        $query = $this->db->get('tblMstPendidikan');
        return $query->result();
    }

    function getDept()
    {
        $this->db->ORDER_BY('DeptAbbr');
        $query = $this->db->get('PSGPayroll..tblMstDepartemen');
        return $query->result();
    }

    function getDept1($div)
    {
        $this->db->where('DeptID', $div);
        $query = $this->db->get('PSGRekrutmen.dbo.vwMstDivisi');
        return $query;
    }

    function getJurusan()
    {
        $this->db->ORDER_BY('Jurusan');
        $query = $this->db->get('tblMstJurusan');
        return $query->result();
    }

    function getJurusanPayroll()
    {
        $this->PSGPayroll->ORDER_BY('Jurusan');
        $this->PSGPayroll->where('Jurusan != ', '-');
        $query = $this->PSGPayroll->get('tblMstJurusanPendidikan');
        return $query->result();
    }

    function getJabatan()
    {
        $query = $this->db->get('tblMstJabatan');
        return $query->result();
    }

    // gx dipake --start
    function cek_data_pelamar($tgllahir, $namaibu, $pemborong)
    {
        $statustk = 0;

        //cek pelamar yang pernah bekerja/melamar dan dinyatakan TIDAK LULUS
        //STATUS = 5
        if ($statustk === 0) {
            $query5 = $this->db->query("Select HeaderID From tblTrnCalonTenagaKerja Where convert(datetime,convert(varchar(10),Tgl_Lahir,103),103)=convert(datetime,convert(varchar(10),'" . $tgllahir . "',103),103) "
                . "and NamaIbuKandung='$namaibu' And GeneralStatus=1 And ScreeningHasil=0 ");
            if ($query5->num_rows() > 0) {
                $statustk = 5;
            }
        }

        //cek pelamar masih kerja di RSUP (parameter TanggalKeluar & TanggalKeluarTemporary)
        //STATUS = 3
        if ($statustk === 0) {
            $query3 = $this->db->query("Select NoFix From vwOL_TKRequestPayBoro Where convert(datetime,convert(varchar(10),Tgl_Lahir,103),103)=convert(datetime,convert(varchar(10),'" . $tgllahir . "',103),103) "
                . "and NamaIbuKandung='$namaibu' and TanggalKeluar is Null And TanggalKeluarTemporary is Null");
            if ($query3->num_rows() > 0) {
                $statustk = 3;
            }
        }

        //cek pelamar masih jeda (parameter TanggalKeluarTemporary)
        //STATUS = 4
        if ($statustk === 0) {
            $query4 = $this->db->query("Select NoFix From vwOL_TKRequestPayBoro Where convert(datetime,convert(varchar(10),Tgl_Lahir,103),103)=convert(datetime,convert(varchar(10),'" . $tgllahir . "',103),103) "
                . "and NamaIbuKandung='$namaibu' and (DateDiff(DAY,TanggalKeluarTemporary,GETDATE()) < 31 or DateDiff(DAY,TanggalKeluar,GETDATE()) < 31)");
            if ($query4->num_rows() > 0) {
                $statustk = 4;
            }
        }

        //cek pelamar sudah diinput dengan nama pemborong TIDAK sama
        //STATUS = 2
        if ($statustk === 0) {
            $query2 = $this->db->query("Select top 1 HeaderID From tblTrnCalonTenagaKerja Where convert(datetime,convert(varchar(10),Tgl_Lahir,103),103)=convert(datetime,convert(varchar(10),'" . $tgllahir . "',103),103) "
                . "and NamaIbuKandung='$namaibu' And Pemborong <> '$pemborong' And GeneralStatus=0 "
                . "Order By HeaderID Desc");
            if ($query2->num_rows() > 0) {
                $statustk = 2;
            }
        }

        //cek pelamar sudah diinput dengan nama pemborong sama
        //STATUS = 1
        if ($statustk === 0) {
            $query1 = $this->db->query("Select top 1 HeaderID From tblTrnCalonTenagaKerja Where convert(datetime,convert(varchar(10),Tgl_Lahir,103),103)=convert(datetime,convert(varchar(10),'" . $tgllahir . "',103),103) "
                . "and NamaIbuKandung='$namaibu' And Pemborong = '$pemborong' And GeneralStatus=0 "
                . "Order By HeaderID Desc");
            if ($query1->num_rows() > 0) {
                $statustk = 1;
            }
        }

        return $statustk;
    }
    // gx dipake --end

    // cek pelamar yang pernah bekerja/melamar dan dinyatakan TIDAK LULUS ==========
    function cekRegScreeningReject($tglLahir, $namaIbu, $namaAyah, $No_Ktp = NULL)
    {
        // $query = $this->db->query("SELECT Nama,NamaIbuKandung,Tgl_Lahir,GeneralStatus,ScreeningHasil,NamaBapak  FROM tblTrnCalonTenagaKerja "
        //   . "WHERE (NamaIbuKandung = '" . $namaIbu . "' AND Tgl_Lahir = '" . $tglLahir . "' AND GeneralStatus = 1 AND ScreeningHasil = 0) "
        //   . "OR (NamaBapak = '" . $namaAyah . "' AND Tgl_Lahir = '" . $tglLahir . "' AND GeneralStatus = 1 AND ScreeningHasil = 0) "
        //   . "OR (NamaBapak = '" . $namaAyah . "' AND NamaIbuKandung = '" . $namaIbu . "' AND GeneralStatus = 1 AND ScreeningHasil = 0)");
        $query = $this->db->query("SELECT
                                Nama,
                                NamaIbuKandung,
                                Tgl_Lahir,
                                GeneralStatus,
                                ScreeningHasil,
                                NamaBapak 
                              FROM
                                tblTrnCalonTenagaKerja 
                              WHERE
                                ( No_Ktp = '$No_Ktp' AND GeneralStatus = 1 AND ScreeningHasil = 0 )");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // cek Pernah Melamar di Pemborong lain==========
    function cekRegTK($namaTK, $pemborong, $tglLahir, $namaIbu, $namaAyah)
    {
        $query = $this->db->query("SELECT Nama,NamaIbuKandung,Tgl_Lahir,Pemborong,NamaBapak FROM tblTrnCalonTenagaKerja "
            . "WHERE (Nama = '" . $namaTK . "' AND NamaIbuKandung = '" . $namaIbu . "' AND Pemborong != '" . $pemborong . "' AND Tgl_Lahir = '" . $tglLahir . "' AND GeneralStatus = 0 AND DATEDIFF(MONTH, RegisteredDate, GETDATE( ))<=3) "
            . "OR (Nama = '" . $namaTK . "' AND NamaBapak = '" . $namaAyah . "' AND Pemborong != '" . $pemborong . "' AND Tgl_Lahir = '" . $tglLahir . "' AND GeneralStatus = 0 AND DATEDIFF(MONTH, RegisteredDate, GETDATE( ))<=3) "
            . "OR (Nama = '" . $namaTK . "' AND NamaIbuKandung = '" . $namaIbu . "' AND Pemborong != '" . $pemborong . "' AND NamaBapak = '" . $namaAyah . "' AND Tgl_Lahir = '" . $tglLahir . "' AND GeneralStatus = 0 AND DATEDIFF(MONTH, RegisteredDate, GETDATE( ))<=3)");
        return $query->result();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // cek sudah diiput oleh Pemborong Saat Ini ===========
    function cekRegTKPem($namaTK, $pemborong, $tglLahir, $namaIbu, $namaAyah)
    {
        $query = $this->db->query("SELECT Nama,NamaIbuKandung,Tgl_Lahir,Pemborong,NamaBapak FROM tblTrnCalonTenagaKerja "
            . "WHERE (Nama = '" . $namaTK . "' AND NamaIbuKandung = '" . $namaIbu . "' AND Pemborong = '" . $pemborong . "' AND Tgl_Lahir = '" . $tglLahir . "' AND GeneralStatus = 0 AND DATEDIFF(MONTH, RegisteredDate, GETDATE( ))<=1) "
            . "OR (Nama = '" . $namaTK . "' AND NamaBapak = '" . $namaAyah . "' AND Pemborong = '" . $pemborong . "' AND Tgl_Lahir = '" . $tglLahir . "' AND GeneralStatus = 0 AND DATEDIFF(MONTH, RegisteredDate, GETDATE( ))<=1) "
            . "OR (Nama = '" . $namaTK . "' AND NamaIbuKandung = '" . $namaIbu . "' AND Pemborong = '" . $pemborong . "' AND NamaBapak = '" . $namaAyah . "' AND Tgl_Lahir = '" . $tglLahir . "' AND GeneralStatus = 0 AND DATEDIFF(MONTH, RegisteredDate, GETDATE( ))<=1) ");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // cek sudah diiput oleh Pemborong Lainnya ===========
    function cekRegTKPem2($pemborong, $tglLahir, $namaIbu, $namaAyah)
    {
        return $this->db->query("SELECT Nama,NamaIbuKandung,Tgl_Lahir,Pemborong,NamaBapak FROM tblTrnCalonTenagaKerja "
            . "WHERE (NamaIbuKandung = '" . $namaIbu . "' AND Pemborong != '" . $pemborong . "' AND Tgl_Lahir = '" . $tglLahir . "' AND GeneralStatus = 0) "
            . "OR (NamaBapak = '" . $namaAyah . "' AND Pemborong != '" . $pemborong . "' AND Tgl_Lahir = '" . $tglLahir . "' AND GeneralStatus = 0) "
            . "OR (NamaIbuKandung = '" . $namaIbu . "' AND Pemborong != '" . $pemborong . "' AND NamaBapak = '" . $namaAyah . "' AND GeneralStatus = 0)")->row();
    }

    // cek masih dalam masa jeda (TanggalKeluarTemporary) ==========
    function cekRegInTemp($tglLahir, $namaIbu, $namaAyah)
    {
        $query = $this->db->query("SELECT Nama,NamaIbuKandung,Tgl_Lahir,NamaBapak  FROM vw_cekTKRequestPayBoro "
            . "WHERE (NamaIbuKandung = '" . $namaIbu . "' AND Tgl_Lahir = '" . $tglLahir . "' AND (DateDiff(DAY,TanggalKeluarTemp,GETDATE()) < 31  or DateDiff(DAY,TanggalKeluar,GETDATE()) < 31)) "
            . "OR (NamaBapak = '" . $namaAyah . "' AND Tgl_Lahir = '" . $tglLahir . "' AND (DateDiff(DAY,TanggalKeluarTemp,GETDATE()) < 31  or DateDiff(DAY,TanggalKeluar,GETDATE()) < 31)) "
            . "OR (NamaIbuKandung = '" . $namaIbu . "' AND NamaBapak = '" . $namaAyah . "' AND (DateDiff(DAY,TanggalKeluarTemp,GETDATE()) < 31  or DateDiff(DAY,TanggalKeluar,GETDATE()) < 31))");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
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
            . "OR (Pemborong != '" . $pemborong . "' AND NamaIbuKandung = '" . $namaIbu . "' AND NamaBapak = '" . $namaAyah . "' AND Tgl_Lahir = '" . $tglLahir . "' AND (DateDiff(MONTH,TanggalKeluarTemp,GETDATE()) <= 3  or DateDiff(MONTH,TanggalKeluar,GETDATE()) <= 3))");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // cek Pernah Masih Aktif sebagai karyawan ==========
    function cekRegAktif($namaTK, $tglLahir, $namaIbu, $namaAyah)
    {
        $query = $this->db->query("SELECT Nama,NamaIbuKandung,Tgl_Lahir,NamaBapak  FROM vw_cekTKRequestPayBoro "
            . "WHERE (Nama ='" . $namaTK . "' AND NamaIbuKandung = '" . $namaIbu . "' AND Tgl_Lahir = '" . $tglLahir . "' AND TanggalKeluar Is NULL AND TanggalKeluarTemp Is NULL) "
            . "OR (Nama ='" . $namaTK . "' AND NamaBapak = '" . $namaAyah . "' AND Tgl_Lahir = '" . $tglLahir . "' AND TanggalKeluar Is NULL AND TanggalKeluarTemp Is NULL) "
            . "OR (Nama ='" . $namaTK . "' AND NamaIbuKandung = '" . $namaIbu . "' AND NamaBapak = '" . $namaAyah . "' AND Tgl_Lahir = '" . $tglLahir . "' AND TanggalKeluar Is NULL AND TanggalKeluarTemp Is NULL)");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function cekBlacklistByCancel($noKTP)
    {
        $this->db->select('*');
        $this->db->from('vwTrnBlackListByCancel');
        $this->db->where('No_Ktp', $noKTP);
        $this->db->where('sudah_3_bulan', 0);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function pernahReg($tglLahir, $namaIbu)
    {
        return $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja where NamaIbuKandung='" . strtoupper($namaIbu) . "' AND "
            . "Tgl_Lahir='" . $tglLahir . "' ORDER BY RegisteredDate DESC, CreatedDate DESC ");
    }

    function simpanTKTemp($info)
    {
        $this->db->trans_start();
        $this->db->insert('tblTrnCalonTenagaKerjaTemporary', $info);
        $hdridtemp = $this->db->insert_id();
        $this->db->trans_complete();
        return $hdridtemp;
    }

    function simpanTK($info)
    {
        $this->db->trans_start();
        $this->db->insert('tblTrnCalonTenagaKerja', $info);
        $hdrID = $this->db->insert_id();
        $this->db->trans_complete();
        return $hdrID;
    }

    function hapusTKTemp($hdridtemp)
    {
        $this->db->where('HeaderIDTemporary', $hdridtemp);
        $this->db->delete('tblTrnCalonTenagaKerjaTemporary');
    }

    function cek_datakeluarga($hdrID, $hdridtemp, $nama)
    {
        if ($hdridtemp == 0) {
            $query = $this->db->get_where('tblTrnKeluarga', array('HeaderID' => $hdrID, 'Nama' => $nama));
        } else {
            $query = $this->db->get_where('tblTrnKeluarga', array('HeaderIDTemp' => $hdridtemp, 'Nama' => $nama));
        }

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $detailid = $row->DetailID;
        } else {
            $detailid = 0;
        }
        return $detailid;
    }

    function simpan_datakeluarga($infokel)
    {
        $this->db->trans_start();
        $this->db->insert('tblTrnKeluarga', $infokel);
        $this->db->insert_id();
        $this->db->trans_complete();
    }

    function update_datakeluarga($detailid, $infokel)
    {
        $this->db->trans_start();
        $this->db->where('DetailID', $detailid);
        $this->db->update('tblTrnKeluarga', $infokel);
        $this->db->trans_complete();
    }

    function update_datakeluarga_fromtemp($hdrID, $hdrtempid)
    {
        $this->db->trans_start();
        $this->db->where('HeaderIDTemp', $hdrtempid);
        $this->db->update('tblTrnKeluarga', array('HeaderID' => $hdrID));
        $this->db->trans_complete();
    }

    function update_headeridtemp_formtemp($hdrID, $hdridtemp)
    {
        $this->db->trans_start();
        $this->db->where('HeaderID', $hdrID);
        $this->db->update('tblTrnCalonTenagaKerja', array('HeaderIDTemp' => $hdridtemp));
        $this->db->trans_complete();
    }

    function cek_dataanak($hdrID, $hdridtemp, $namaanak)
    {
        if ($hdridtemp == 0) {
            $query = $this->db->get_where('tblTrnAnak', array('HeaderID' => $hdrID, 'Nama' => $namaanak));
        } else {
            $query = $this->db->get_where('tblTrnAnak', array('HeaderIDTemp' => $hdridtemp, 'Nama' => $namaanak));
        }

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $detailid = $row->DetailID;
        } else {
            $detailid = 0;
        }
        return $detailid;
    }

    function simpan_dataanak($infoanak)
    {
        $this->db->trans_start();
        $this->db->insert('tblTrnAnak', $infoanak);
        $this->db->insert_id();
        $this->db->trans_complete();
    }

    function update_dataanak($detailid, $infoanak)
    {
        $this->db->trans_start();
        $this->db->where('DetailID', $detailid);
        $this->db->update('tblTrnAnak', $infoanak);
        $this->db->trans_complete();
    }

    function update_dataanak_fromtemp($hdrID, $hdrtempid)
    {
        $this->db->trans_start();
        $this->db->where('HeaderIDTemp', $hdrtempid);
        $this->db->update('tblTrnAnak', array('HeaderID' => $hdrID));
        $this->db->trans_complete();
    }

    function cek_datasdr($hdrID, $hdridtemp, $namasdr)
    {
        if ($hdridtemp == 0) {
            $query = $this->db->get_where('tblTrnSaudara', array('HeaderID' => $hdrID, 'Nama' => $namasdr));
        } else {
            $query = $this->db->get_where('tblTrnSaudara', array('HeaderIDTemp' => $hdridtemp, 'Nama' => $namasdr));
        }

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $detailid = $row->DetailID;
        } else {
            $detailid = 0;
        }
        return $detailid;
    }

    function simpan_datasdr($infosaudara)
    {
        $this->db->trans_start();
        $this->db->insert('tblTrnSaudara', $infosaudara);
        $this->db->insert_id();
        $this->db->trans_complete();
    }

    function update_datasdr($detailid, $infosaudara)
    {
        $this->db->trans_start();
        $this->db->where('DetailID', $detailid);
        $this->db->update('tblTrnSaudara', $infosaudara);
        $this->db->trans_complete();
    }

    function update_datasdr_fromtemp($hdrID, $hdrtempid)
    {
        $this->db->trans_start();
        $this->db->where('HeaderIDTemp', $hdrtempid);
        $this->db->update('tblTrnSaudara', array('HeaderID' => $hdrID));
        $this->db->trans_complete();
    }

    function cek_datapendidikan($hdrID, $hdridtemp, $pendidikantingkat)
    {
        if ($hdridtemp == 0) {
            $query = $this->db->get_where('tblTrnPendidikan', array('HeaderID' => $hdrID, 'Tingkat' => $pendidikantingkat));
        } else {
            $query = $this->db->get_where('tblTrnPendidikan', array('HeaderIDTemp' => $hdridtemp, 'Tingkat' => $pendidikantingkat));
        }

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $detailid = $row->DetailID;
        } else {
            $detailid = 0;
        }
        return $detailid;
    }

    function simpan_datapendidikan($infopendidikan)
    {
        $this->db->trans_start();
        $this->db->insert('tblTrnPendidikan', $infopendidikan);
        $this->db->insert_id();
        $this->db->trans_complete();
    }

    function update_datapendidikan($detailid, $infopendidikan)
    {
        $this->db->trans_start();
        $this->db->where('DetailID', $detailid);
        $this->db->update('tblTrnPendidikan', $infopendidikan);
        $this->db->trans_complete();
    }

    function update_datapendidikan_fromtemp($hdrID, $hdrtempid)
    {
        $this->db->trans_start();
        $this->db->where('HeaderIDTemp', $hdrtempid);
        $this->db->update('tblTrnPendidikan', array('HeaderID' => $hdrID));
        $this->db->trans_complete();
    }

    function simpan_info_saudara($infopendidikan)
    {
        $this->db->trans_start();
        $this->db->insert('tblTrnSaudara', $infopendidikan);
        $this->db->insert_id();
        $this->db->trans_complete();
    }

    function update_status_foto($hdrID)
    {
        $this->db->trans_start();
        $this->db->where('HeaderID', $hdrID);
        $this->db->update('tblTrnCalonTenagaKerja', array('AdaPhotoOnline' => 1));
        $this->db->trans_complete();
    }

    function get_tenagakerja($hdrID)
    {
        return $this->db->get_where('tblTrnCalonTenagaKerja', array('HeaderID' => $hdrID));
    }

    function get_datatk_temp($hdridtemp)
    {
        $this->db->where('HeaderIDTemporary', $hdridtemp);
        return $this->db->get('tblTrnCalonTenagaKerjaTemporary');
    }

    // function saveCK($data){
    //        $this->db->insert('tblTrnCalonKandidat',$data);
    //        $hdrid = $this->db->insert_id();
    //        $this->db->trans_complete();
    //        return $hdrid;
    //    }

    function saveCK($data)
    {
        $this->db->trans_start();
        $this->db->insert('tblTrnCalonKandidat', $data);
        $hdrID = $this->db->insert_id();
        $this->db->trans_complete();
        return $hdrID;
    }

    function getDataCK($id)
    {
        return $this->db->get_where('vwTrnCalonKandidat', array('ID' => $id));
    }

    function updateCK($id_ck, $data)
    {
        $this->db->where($id_ck);
        $query = $this->db->update('tblTrnCalonKandidat', $data);
        return $query;
    }

    // function cekTK1($where)
    // {
    //     return $this->db->get_where('tblTrnBlacklist', $where)->result();
    // }
    function cekTK($namaTK, $ibu)
    {
        // return $this->db->query("select * from tblTrnBlacklist where Nama = '$namaTK' and NamaIbuKandung = '$ibu' and ((BlackListDuaBulan = 1 
        //                             and DATEDIFF(month, created_date,GETDATE()) < 6) or (BlackListDuaBulan is null and Status = 'Blacklist'))")->result();
        return $this->db->query("SELECT
                              * 
                            FROM
                              tblTrnBlacklist 
                            WHERE
                              Nama = '$namaTK' 
                              AND NamaIbuKandung = '$ibu' 
                              AND (
                                ( BlackListDuaBulan = 1 AND DATEDIFF( MONTH, created_date, GETDATE( ) ) < 6 ) 
                                OR ( BlackListDuaBulan IS NULL AND Status = 'Blacklist' ) 
                              OR ( BlackListDuaBulan = 0 AND Status = 'Blacklist' ) 
                              )")->result();
    }

    function cekTKByKtp($noktp)
    {
        return $this->db->query("SELECT
                              * 
                            FROM
                              tblTrnBlacklist 
                            WHERE
                              TRIM(NoKtp) = TRIM('$noktp') 
                              AND (
                                ( BlackListDuaBulan = 1 AND DATEDIFF( MONTH, created_date, GETDATE( ) ) < 6 ) 
                                OR ( BlackListDuaBulan IS NULL AND Status = 'Blacklist' ) 
                              OR ( BlackListDuaBulan = 0 AND Status = 'Blacklist' ) 
                              )")->result();
    }
    function cekNama($nama)
    {
        return $this->db->query("select * from tblTrnBlacklist where Nama like '%$nama%'")->result();
    }

    // function update_input_mandiri($id, $data_update)
    // {
    //   // $this->db->trans_start();
    //   $this->db->where('HeaderID', $id);
    //   // $this->db->update('tblTrnCalonTenagaKerja', ['input_mandiri' => 0, 'checked_by' => $this->session->userdata('username'), 'checked_date' => date('Y-m-d H:i:s')]);
    //   $this->db->update('tblTrnCalonTenagaKerja', $data_update);
    //   return true;
    //   // $this->db->trans_complete();

    //   // if ($this->db->trans_status() === FALSE) {
    //   //   return false;
    //   // } else {
    //   //   return true;
    //   // }
    // }

    function update_input_mandiri($id, $data_update)
    {
        $this->db->trans_start();  // Mulai transaksi
        $this->db->where('HeaderID', $id);
        $this->db->update('tblTrnCalonTenagaKerja', $data_update);
        $this->db->trans_complete();  // Selesaikan transaksi

        if ($this->db->trans_status() === FALSE) {
            return false;  // Jika ada kesalahan, rollback
        } else {
            return true;  // Jika sukses, commit
        }
    }


    ###################################################################################################### IMPORT DATA TK MANUAL
    protected $table = 'tblTrnCalonTenagaKerja';

    //field yang ada di table user
    private $column_order = array(
        'HeaderID',
        'Nama',

    );
    //field yang diizin untuk pencarian
    private $column_search = array(
        'HeaderID',
        'Nama',
    );

    private $order_list_import = array('A.HeaderID' => 'DESC'); // default order 


    public function insert_batch($data)
    {
        return $this->db->insert_batch('tblTrnCalonTenagaKerja', $data);
    }

    function simpan_info_pendidikan($data)
    {
        $this->db->trans_start();
        $this->db->insert('tblTrnPendidikan', $data);
        $this->db->insert_id();
        $this->db->trans_complete();
    }

    function simpan_data_saudara($data)
    {
        $this->db->trans_start();
        $this->db->insert('tblTrnSaudara', $data);
        $this->db->insert_id();
        $this->db->trans_complete();
    }

    private function _get_datatables_query_list_import($table)
    {


        $this->db->select('A.HeaderID, A.Nama, A.importAt, A.importedBy');
        $this->db->from($table . ' AS A');
        $this->db->where('isUploadManual', 1);

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
        if (isset($_POST['dateFilter']) && $_POST['dateFilter'] != '') {
            $this->db->where("CONVERT(DATE, importAt) =", "CONVERT(DATE, '" . date('Y-m-d', strtotime($_POST['dateFilter'])) . "')", false);
        }


        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->column_order)) {
            $order = $this->order_list_import;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }


    public function get_datatables_list_import($table)
    {
        $this->_get_datatables_query_list_import($table);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_list_import($table)
    {
        $this->_get_datatables_query_list_import($table);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_list_import($table)
    {
        return $this->db->from($table)
            ->count_all_results();
    }
}

/* End of file m_register.php */
/* Location: ./application/models/m_register.php */