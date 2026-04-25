<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class WawancaraTujuan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('darurat');
        $status = $this->darurat->getStatus();
        if ($status === 1 && $this->session->userdata('userid') !== 'ismo_adm') {
            redirect(site_url('maintenanceControl'));
        }

        date_default_timezone_set("Asia/Jakarta");
        if (!$this->session->userdata('userid')) {
            redirect('login');
        }

        $this->load->model(array('m_wawancara', 'm_screening'));
    }

    public function index()
    {
        $data['_getCVNama']         = $this->m_wawancara->getCVNama();
        $data['_selected']          = '';
        $data['_getTenagaKerja']    = $this->m_wawancara->getTenagaKerja();
        $data['_getDept1']          = $this->m_wawancara->getDepartment2('ALL PEMBORONG');
        $data['_getDept2']          = $this->m_wawancara->getDepartment2('PSG');
        $this->template->display('registrasi/tujuan_wawancara/index', $data);
    }

    public function listWawancaraTujuan()
    {
        $filter_status              = $this->uri->segment(3);
        $filter_status2             = str_replace("_", " ", $filter_status);
        if ($filter_status2 == 'PT PSG') {
            $filter_status2         = 'PT. PULAU SAMBU (GUNTUNG)';
        } else {
            $filter_status2         = $filter_status2;
        }

        $data['_getCVNama']         = $this->m_wawancara->getCVNama();
        $data['_selected']          = $filter_status2;
        $data['_getTenagaKerja']    = $this->m_wawancara->getTenagaKerja_($filter_status2);
        $data['_getDept1']          = $this->m_wawancara->getDepartment2('ALL PEMBORONG');
        $data['_getDept2']          = $this->m_wawancara->getDepartment2('PSG');

        $this->template->display('registrasi/tujuan_wawancara/index', $data);
    }

    // function simpanTujuan()
    // {
    //     $filter_status              = $this->input->post('filter_status');
    //     $alldatapost                = $this->input->post('alldatapost');
    //     $jml_data                   = $this->input->post('jml_data');
    //     $checked                    = $this->input->post('ckHdrID');
    //     $comboDept                  = $this->input->post('cmbIDDetailHarian');
    //     $comboDept2                 = $this->input->post('cmbIDDetailKar');
    //     $to_p2k3                    = $this->input->post('to_p2k3');
    //     $to_elc                     = $this->input->post('to_elc');
    //     $to_hed                     = $this->input->post('to_hed');
    //     $itung                      = count($checked);



    //     if ($comboDept == '') {
    //         $comboDept = $comboDept2;
    //     }

    //     $jml_post = count($this->m_wawancara->getTenagaKerja_($filter_status));
    //     $jmldata = count($jml_data);


    //     for ($i = 0; $i <= $jml_data; $i++) {

    //         if (isset($checked[$i])) {

    //             if (isset($to_p2k3[$i])) {
    //                 $vto_p2k3[$i] = '1';
    //             } else {
    //                 $vto_p2k3[$i] = '0';
    //             }
    //             if (isset($to_elc[$i])) {
    //                 $vto_elc[$i] = '1';
    //             } else {
    //                 $vto_elc[$i] = '0';
    //             }
    //             if (isset($to_hed[$i])) {
    //                 $vto_hed[$i] = '1';
    //             } else {
    //                 $vto_hed[$i] = '0';
    //             }

    //             $getDepta = $this->m_wawancara->getDept($comboDept);
    //             foreach ($getDepta as $row) {
    //                 $idDetail   = $row->DetailID;
    //                 $dept       = $row->DeptAbbr;
    //                 $transaksi  = $row->Pekerjaan;
    //             }

    //             $data = array(
    //                 'DeptTujuan'     => $dept,
    //                 'TransID'        => $idDetail,
    //                 'Transaksi'      => $transaksi,
    //                 'SendedBy'       => strtoupper($this->session->userdata('username')),
    //                 'SendedDate'     => date('Y-m-d H:i:s'),
    //                 'WawancaraHasil' => NULL,
    //                 'status_p2k3'    => $vto_p2k3[$i],
    //                 'status_elc'     => $vto_elc[$i],
    //                 'status_hed'     => $vto_hed[$i],
    //             );



    //             $this->m_wawancara->updateDeptTujuan($checked[$i], $data);
    //         } else {
    //             $data = []; // Tes
    //         }
    //     }

    //     $getDeptb = $this->m_wawancara->getDept($comboDept);
    //     foreach ($getDeptb as $rowb) {
    //         $detailID   = $rowb->DetailID;
    //         $minta      = $rowb->TempSetTenaker;
    //     }
    //     $temp   = $minta + $itung;
    //     $this->m_wawancara->updateTempMinta($detailID, $temp);

    //     // for($i=0; $i<$itung; $i++){ //Function Update Before ToP2K3 (Only Send Wawancara)

    //     //     $getDepta = $this->m_wawancara->getDept($comboDept);
    //     //     foreach ($getDepta as $row){
    //     //         $idDetail   = $row->DetailID;
    //     //         $dept       = $row->DeptAbbr;
    //     //         $transaksi  = $row->Pekerjaan;
    //     //     }
    //     //     $data = array(
    //     //         'DeptTujuan'    => $dept,
    //     //         'TransID'       => $idDetail,
    //     //         'Transaksi'     => $transaksi,
    //     //         'SendedBy'      => strtoupper($this->session->userdata('username')),
    //     //         'SendedDate'    => date('Y-m-d H:i:s'),
    //     //         'WawancaraHasil'=> NULL
    //     //     );

    //     //     $this->m_wawancara->updateDeptTujuan($checked[$i],$data);
    //     // }

    //     // $getDeptb = $this->m_wawancara->getDept($comboDept);
    //     // foreach ($getDeptb as $rowb){
    //     //     $detailID   = $rowb->DetailID;
    //     //     $minta      = $rowb->TempSetTenaker;
    //     // }
    //     // $temp   = $minta+$itung;
    //     // $this->m_wawancara->updateTempMinta($detailID,$temp);

    //     redirect(site_url('wawancaraTujuan/index'));
    // }

    // function simpanTujuan()
    // {
    //     // === Ambil input dengan null-safety ===
    //     $filter_status = $this->input->post('filter_status');
    //     $jml_data      = (int) $this->input->post('jml_data');
    //     $checked       = $this->input->post('ckHdrID') ?? [];
    //     $comboDept     = $this->input->post('cmbIDDetailHarian');
    //     $comboDept2    = $this->input->post('cmbIDDetailKar');
    //     $to_p2k3       = $this->input->post('to_p2k3') ?? [];
    //     $to_elc        = $this->input->post('to_elc') ?? [];
    //     $to_hed        = $this->input->post('to_hed') ?? [];

    //     // Fallback ke combo kedua kalau yang pertama kosong
    //     if (empty($comboDept)) {
    //         $comboDept = $comboDept2;
    //     }

    //     $itung = count($checked);

    //     // === Ambil data department sekali di awal (bukan di dalam loop) ===
    //     $getDept   = $this->m_wawancara->getDept($comboDept);
    //     $idDetail  = null;
    //     $dept      = null;
    //     $transaksi = null;
    //     $minta     = 0;

    //     foreach ($getDept as $row) {
    //         $idDetail  = $row->DetailID;
    //         $dept      = $row->DeptAbbr;
    //         $transaksi = $row->Pekerjaan;
    //         $minta     = $row->TempSetTenaker;
    //     }

    //     // === Guard: kalau department nggak ketemu, stop ===
    //     if ($idDetail === null) {
    //         redirect(site_url('wawancaraTujuan/index'));
    //         return;
    //     }

    //     // === Data statis yang sama untuk semua row ===
    //     $baseData = [
    //         'DeptTujuan'     => $dept,
    //         'TransID'        => $idDetail,
    //         'Transaksi'      => $transaksi,
    //         'SendedBy'       => strtoupper($this->session->userdata('username')),
    //         'SendedDate'     => date('Y-m-d H:i:s'),
    //         'WawancaraHasil' => null,
    //     ];

    //     // === Loop update per checked row ===
    //     for ($i = 0; $i <= $jml_data; $i++) {
    //         if (!isset($checked[$i])) {
    //             continue;
    //         }

    //         $data = $baseData + [
    //             'status_p2k3' => isset($to_p2k3[$i]) ? '1' : '0',
    //             'status_elc'  => isset($to_elc[$i])  ? '1' : '0',
    //             'status_hed'  => isset($to_hed[$i])  ? '1' : '0',
    //         ];

    //         $this->m_wawancara->updateDeptTujuan($checked[$i], $data);
    //     }

    //     // === Update counter TempSetTenaker ===
    //     $this->m_wawancara->updateTempMinta($idDetail, $minta + $itung);

    //     redirect(site_url('wawancaraTujuan/index'));
    // }

    function simpanTujuan()
    {
        // === Ambil input dengan null-safety ===
        $filter_status = $this->input->post('filter_status');
        $jml_data      = (int) $this->input->post('jml_data');
        $checked       = $this->input->post('ckHdrID') ?? [];
        $comboDept     = $this->input->post('cmbIDDetailHarian');
        $comboDept2    = $this->input->post('cmbIDDetailKar');
        $to_p2k3       = $this->input->post('to_p2k3') ?? [];
        $to_elc        = $this->input->post('to_elc') ?? [];
        $to_hed        = $this->input->post('to_hed') ?? [];

        // Fallback ke combo kedua kalau yang pertama kosong
        if (empty($comboDept)) {
            $comboDept = $comboDept2;
        }

        // === Guard: nggak ada yang dichecklist, stop ===
        if (empty($checked)) {
            $this->session->set_flashdata('error', 'Tidak ada data yang dipilih.');
            redirect(site_url('wawancaraTujuan/index'));
            return;
        }

        $itung = count($checked);

        // === Ambil data department sekali di awal ===
        $getDept   = $this->m_wawancara->getDept($comboDept);
        $idDetail  = null;
        $dept      = null;
        $transaksi = null;
        $minta     = 0;

        foreach ($getDept as $row) {
            $idDetail  = $row->DetailID;
            $dept      = $row->DeptAbbr;
            $transaksi = $row->Pekerjaan;
            $minta     = $row->TempSetTenaker;
        }

        // === Guard: kalau department nggak ketemu, stop ===
        if ($idDetail === null) {
            $this->session->set_flashdata('error', 'Department tidak ditemukan.');
            redirect(site_url('wawancaraTujuan/index'));
            return;
        }

        // === Data statis yang sama untuk semua row ===
        $baseData = [
            'DeptTujuan'     => $dept,
            'TransID'        => $idDetail,
            'Transaksi'      => $transaksi,
            'SendedBy'       => strtoupper($this->session->userdata('username')),
            'SendedDate'     => date('Y-m-d H:i:s'),
            'WawancaraHasil' => null,
        ];

        // === Loop update per checked row ===
        $totalUpdated = 0;
        $skipped      = [];

        foreach ($checked as $i => $hdrId) {
            // Validasi tujuan: minimal 1 harus dipilih
            $isP2k3 = isset($to_p2k3[$i]) ? 1 : 0;
            $isElc  = isset($to_elc[$i])  ? 1 : 0;
            $isHed  = isset($to_hed[$i])  ? 1 : 0;

            // Skip kalau nggak ada tujuan sama sekali
            if ($isP2k3 === 0 && $isElc === 0 && $isHed === 0) {
                $skipped[] = $hdrId;
                continue;
            }

            // Server-side guard: p2k3 dan elc nggak boleh barengan
            if ($isP2k3 === 1 && $isElc === 1) {
                $skipped[] = $hdrId;
                continue;
            }

            $data = $baseData + [
                'status_p2k3' => (string) $isP2k3,
                'status_elc'  => (string) $isElc,
                'status_hed'  => (string) $isHed,
            ];

            $this->m_wawancara->updateDeptTujuan($hdrId, $data);
            $totalUpdated++;
        }

        // === Update counter TempSetTenaker hanya yang berhasil diupdate ===
        if ($totalUpdated > 0) {
            $this->m_wawancara->updateTempMinta($idDetail, $minta + $totalUpdated);
            $this->session->set_flashdata('success', "$totalUpdated data berhasil diproses.");
        }

        if (!empty($skipped)) {
            $this->session->set_flashdata('warning', count($skipped) . ' data dilewati (tujuan tidak valid).');
        }

        redirect(site_url('wawancaraTujuan/index'));
    }

    function cekRecordInterview()
    {
        if ('IS_AJAX') {
            $kode = $this->input->post('kode');
            $data['datatk'] = $this->m_screening->getDetailTK($kode)->result();
            $data['resultInterV'] = $this->m_screening->resultInterview($kode)->result();
            $this->load->view('registrasi/tujuan_wawancara/recordInterview', $data);
        }
    }

    function quotaFull()
    {
        $this->template->display('registrasi/tujuan_wawancara/quotaFull');
    }
}


/* End of file wawancaraTujuan.php */
/* Location: ./application/controllers/wawancaraTujuan.php */