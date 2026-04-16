<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class PostingTenaker extends CI_Controller
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

        $this->load->model(array('m_posting_tenaker', 'm_upload_berkas'));
    }

    function index()
    {
        $sgm    = $this->uri->segment(3);
        if ($sgm == 'full') {
            $data['label'] = 'alert-danger';
            $data['pesan'] = 'Maaf, Permintaan Karyawan Telah Terpenuhi..';
        } elseif ($sgm == 'success') {
            $data['label'] = 'alert-info';
            $data['pesan'] = 'Well Done, Posting Karyawan Success..';
        } else {
            $data['label'] = 'alert-info';
            $data['pesan'] = 'Welcome, Silahkan Posting Tenaga Kerja..';
        }
        $data['_listTenaker']   = $this->m_posting_tenaker->getTenakerOK();

        $this->template->display('registrasi/posting/index', $data);
    }

    function doPosting()
    {
        $hdrID  = $this->input->post('chkPosting');
        $p2k3   = $this->input->post('txt_p2k3');
        $departemen = $this->input->post('departemen');
        $Nofix = $this->input->post('Nofix');

        // $jml = count($Nofix);

        // // Get Nofix
        // for ($i = 0; $i < $jml; $i++) {
        //     if (isset($hdrID[$i])) {
        //         $getNofix[]  = $Nofix[$i];
        //     }
        // }
        // print_r($Nofix);
        // die;

        $itung  = count($hdrID);
        for ($x = 0; $x < $itung; $x++) {
            $getData    = $this->m_posting_tenaker->getResult($hdrID[$x]);
            foreach ($getData as $row) {
                if ($row->Pemborong == "YAO HSING" || $row->Pemborong == "PT PULAU SAMBU") {
                    $tipe   = 1;
                } else {
                    $tipe   = 0;
                }
                $id = $row->TransID;
            }
            $getTrans   = $this->m_posting_tenaker->getTrans($id);
            foreach ($getTrans as $rowTrans) {
                $permin = $rowTrans->TKPermintaan;
                $temp   = $rowTrans->TempSetTenaker;
            }
            // print_r($permin);
            // die;
            $info   = array(
                'HeaderID'      => $hdrID[$x],
                'TipeKaryawan'  => $tipe,
                'CreatedBy'     => $this->session->userdata('username'),
                'CreatedDate'   => date('Y-m-d H:m:i')
            );

            if ($permin == 1) {

                $updatePermin   = $permin - 1;
                $updateTemp     = $temp - 1;
                $gStatus        = 3;
                $data   = array(
                    'TKPermintaan'  => $updatePermin,
                    'TempSetTenaker' => $updateTemp,
                    'GeneralStatus' => $gStatus,
                    'KeteranganStatus' => 'Telah terpenuhi',
                    'PostedBy' => $this->session->userdata('username'),
                    'UpadatedPostDate' => date('Y-m-d H:i:s'),
                );
                $this->m_posting_tenaker->setPosting($info);
                $this->m_posting_tenaker->updatePost($hdrID[$x]);
                $this->m_posting_tenaker->updateTrans($id, $data);
            } elseif ($permin == 0) {
                $updatePermin   = 0;
                $gStatus        = 3;
                $data   = array(
                    'TKPermintaan'  => $updatePermin,
                    'GeneralStatus' => $gStatus,
                    'KeteranganStatus' => 'Telah terpenuhi',
                    'PostedBy' => $this->session->userdata('username'),
                    'UpadatedPostDate' => date('Y-m-d H:i:s'),
                );
                $this->m_posting_tenaker->updateTrans($id, $data);
                redirect(site_url('postingTenaker/index/full'));
            } else {
                $updatePermin   = $permin - 1;
                $updateTemp     = $temp - 1;
                $gStatus        = 1;

                $data   = array(
                    'TKPermintaan'  => $updatePermin,
                    'TempSetTenaker' => $updateTemp,
                    'GeneralStatus' => $gStatus,
                    'PostedBy' => $this->session->userdata('username'),
                    'PostedDate' => date('Y-m-d H:i:s'),
                );

                $data2  = array(
                    'TanggalKeluar'  => NULL,
                    'IndNotValidTK'  => FALSE,
                );

                $this->m_posting_tenaker->setPosting($info);
                $this->m_posting_tenaker->updatePost($hdrID[$x]);
                $this->m_posting_tenaker->updateTrans($id, $data);

                $this->m_posting_tenaker->updateMstTenakerPayboro($Nofix[$x], $data2);
            }
        }
        redirect(site_url('postingTenaker/index/success'));
    }

    function resetToIndentifikasi()
    {
        $hdrID  = $this->input->post('txtHeaderID');
        $data   = array(
            'DeptTujuan'    => NULL,
            'TransID'       => NULL,
            'Transaksi'     => NULL,
            'WawancaraHasil' => NULL
        );
        $this->m_posting_tenaker->resetToIdentifikasi($hdrID, $data);

        redirect(site_url('postingTenaker/index'));
    }

    function detailtk()
    {
        if ('IS_AJAX') {
            $kode   = $this->input->post('kode');
            $dept   = substr($this->input->post('dept'), 0, 3);
            $pkrj   = $this->input->post('pkrj');
            $trans  = $this->input->post('transID');
            $data['datatk']         = $this->m_upload_berkas->get_detailtk($kode)->result();
            $data['_selectIssue']   = $this->m_posting_tenaker->selectWhereIssue($dept, $pkrj);
            $data['_rowIssue']      = $this->m_posting_tenaker->selectWhereIssueByID($trans);
            $this->load->view('registrasi/posting/detail', $data);
        }
    }
    function ajaxGetKeteranganIssue()
    {
        $detailID   = $this->input->post('txtDetailID');
        $getData    = $this->m_posting_tenaker->selectWhereIssueByID($detailID);
        if ($getData->Pemborong == 'PSG') {
            $jenis  = "Posisi";
        } else {
            $jenis  = "Pekerjaan";
        }
        $data       = $jenis . ' : ' . $getData->Pekerjaan . '<br/>'
            . 'Keterangan :' . $getData->IssueRemark . '<br/>'
            . 'Jenis Kelamin : ' . $getData->JenisKelamin . ', Umur : ' . $getData->Umur . '<br/>'
            . 'Status : ' . $getData->StatusPersonal . '<br/>'
            . 'Pendidikan : ' . $getData->Pendidikan . ', Jurusan : ' . $getData->Jurusan;
        echo json_encode($data);
    }

    function updateDeptTujuan()
    {
        $idHdr      = $this->input->post('txtHdrID');
        $idTrans    = $this->input->post('txtTransID');
        $getDepta   = $this->m_posting_tenaker->getDept($idTrans);
        foreach ($getDepta as $row) {
            $idDetail   = $row->DetailID;
            $dept       = $row->DeptAbbr;
            $transaksi  = $row->Pekerjaan;
        }
        $data = array(
            'DeptTujuan'    => $dept,
            'TransID'       => $idDetail,
            'Transaksi'     => $transaksi
        );
        $excute = $this->m_posting_tenaker->updateIssueByTenaker($idHdr, $data);

        if (!$excute) {
            redirect(site_url('postingTenaker/index/updated'));
        } else {
            redirect(site_url('postingTenaker/index/updateFailed'));
        }
    }
}
