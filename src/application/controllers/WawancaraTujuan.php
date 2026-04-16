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

    function simpanTujuan()
    {
        $filter_status              = $this->input->post('filter_status');
        $alldatapost                = $this->input->post('alldatapost');
        $jml_data                   = $this->input->post('jml_data');
        $checked                    = $this->input->post('ckHdrID');
        $comboDept                  = $this->input->post('cmbIDDetailHarian');
        $comboDept2                 = $this->input->post('cmbIDDetailKar');
        $to_p2k3                    = $this->input->post('to_p2k3');
        $to_elc                     = $this->input->post('to_elc');
        $itung                      = count($checked);



        if ($comboDept == '') {
            $comboDept = $comboDept2;
        }

        $jml_post = count($this->m_wawancara->getTenagaKerja_($filter_status));
        $jmldata = count($jml_data);


        for ($i = 0; $i <= $jml_data; $i++) {

            if (isset($checked[$i])) {

                if (isset($to_p2k3[$i])) {
                    $vto_p2k3[$i] = '1';
                } else {
                    $vto_p2k3[$i] = '0';
                }
                if (isset($to_elc[$i])) {
                    $vto_elc[$i] = '1';
                } else {
                    $vto_elc[$i] = '0';
                }

                $getDepta = $this->m_wawancara->getDept($comboDept);
                foreach ($getDepta as $row) {
                    $idDetail   = $row->DetailID;
                    $dept       = $row->DeptAbbr;
                    $transaksi  = $row->Pekerjaan;
                }

                $data = array(
                    'DeptTujuan'     => $dept,
                    'TransID'        => $idDetail,
                    'Transaksi'      => $transaksi,
                    'SendedBy'       => strtoupper($this->session->userdata('username')),
                    'SendedDate'     => date('Y-m-d H:i:s'),
                    'WawancaraHasil' => NULL,
                    'status_p2k3'    => $vto_p2k3[$i],
                    'status_elc'     => $vto_elc[$i],
                );



                $this->m_wawancara->updateDeptTujuan($checked[$i], $data);
            } else {
                $data = []; // Tes
            }
        }

        $getDeptb = $this->m_wawancara->getDept($comboDept);
        foreach ($getDeptb as $rowb) {
            $detailID   = $rowb->DetailID;
            $minta      = $rowb->TempSetTenaker;
        }
        $temp   = $minta + $itung;
        $this->m_wawancara->updateTempMinta($detailID, $temp);

        // for($i=0; $i<$itung; $i++){ //Function Update Before ToP2K3 (Only Send Wawancara)

        //     $getDepta = $this->m_wawancara->getDept($comboDept);
        //     foreach ($getDepta as $row){
        //         $idDetail   = $row->DetailID;
        //         $dept       = $row->DeptAbbr;
        //         $transaksi  = $row->Pekerjaan;
        //     }
        //     $data = array(
        //         'DeptTujuan'    => $dept,
        //         'TransID'       => $idDetail,
        //         'Transaksi'     => $transaksi,
        //         'SendedBy'      => strtoupper($this->session->userdata('username')),
        //         'SendedDate'    => date('Y-m-d H:i:s'),
        //         'WawancaraHasil'=> NULL
        //     );

        //     $this->m_wawancara->updateDeptTujuan($checked[$i],$data);
        // }

        // $getDeptb = $this->m_wawancara->getDept($comboDept);
        // foreach ($getDeptb as $rowb){
        //     $detailID   = $rowb->DetailID;
        //     $minta      = $rowb->TempSetTenaker;
        // }
        // $temp   = $minta+$itung;
        // $this->m_wawancara->updateTempMinta($detailID,$temp);

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