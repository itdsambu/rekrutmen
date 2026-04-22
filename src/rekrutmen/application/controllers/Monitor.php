<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : てり　らま
 */

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Borders;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class Monitor extends CI_Controller
{

    function __construct()
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
        $this->load->model(array('m_monitor', 'm_approval', 'm_upload_berkas', 'm_screening', 'm_wawancara', 'M_perubahanmpp'));
    }

    public function screeningProses()
    {

        //Tampilan Berdasarkan Range Bulan

        $tanggalz             = date('Y-m-t');
        $tanggala             = date('Y-m-d', strtotime($tanggalz . ' -3 months'));
        if ($this->input->post('txtDateA')) {
            $tanggala         = date('Y-m-d',  strtotime($this->input->post('txtDateA')));
            $tanggalz         = date('Y-m-d',  strtotime($this->input->post('txtDateZ')));
        }
        $data['_getTK']       = $this->m_monitor->getListTK3($tanggala, $tanggalz);
        $data['_getDateA']    = $tanggala;
        $data['_getDateZ']    = $tanggalz;
        $this->template->display('monitor/proses_screening/index', $data);
    }

    //Tampilan Berdasarkan Bulan

    //     if(!isset($_GET['monthyear']))
    //     {
    //         redirect("monitor/screeningProses?monthyear=".date("m-Y"));
    //     }
    //     else
    //     {
    //         $data['_getTK'] = $this->m_monitor->getListTK3($_GET['monthyear']);
    //         $data['monthfilter']=$_GET['monthyear'];
    //         $this->template->display('monitor/proses_screening/index',$data);
    //     }


    //     // $monthyear=date("m-Y");$data['monthfilter']=$monthyear;
    //     // $data['_getTK'] = $this->m_monitor->getListTK3($monthyear);
    //     // $this->template->display('monitor/proses_screening/index',$data);
    // }

    public function AppP2K3()
    {
        $nowOL            = $this->session->userdata('username');
        $dept             = $this->session->userdata('dept');
        $data['_getTK']   = $this->m_monitor->listTenagaKerjaP2K3($dept);
        $this->template->display('monitor/AppP2K3/V_AppP2K3', $data);
    }

    public function AppHED()
    {
        $nowOL            = $this->session->userdata('username');
        $dept             = $this->session->userdata('dept');
        $data['_getTK']   = $this->m_monitor->listTenagaKerjaHED($dept);
        $this->template->display('monitor/AppHED/V_AppHED', $data);
    }

    public function screeningProses2()
    {
        $monthfilter = $this->input->post('monthfilter');
        //$data['_getTK'] = $this->m_monitor->getListTK2();
        $data['_getTK'] = $this->m_monitor->getListTK3($monthfilter);
        echo json_encode($data['_getTK']);
    }

    function detailScreened()
    {
        if ('IS_AJAX') {
            $kode                   = $this->input->post('kode');
            $data['datatk']         = $this->m_upload_berkas->get_detailtk($kode)->result();
            $data['resultScreen']   = $this->m_screening->resultScreen($kode)->result();
            $this->load->view('monitor/proses_screening/detailScreened', $data);
        }
    }

    function viewLogLogin()
    {
        $userID = $this->session->userdata('userid');
        if ($userID == 'riyan' || $userID == 'ISMO_ADM') {
            $data['_getViewLogLogin'] = $this->m_monitor->getLogLoginViewForAdmin();
        } else {
            $data['_getViewLogLogin'] = $this->m_monitor->getLogLoginView($userID);
        }
        $this->template->display('monitor/viewLogLogin/index', $data);
    }

    function reviewIssue()
    {
        if (!isset($_GET['jenis'])) {
            $_GET['jenis'] = 'harian';
        }
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
        } else {
            $status = $this->input->post('selStatus');
        }
        $jenis = '';
        if ($_GET['jenis'] == 'harian') {
            $jenis = 'ALL PEMBORONG';
        } else {
            $jenis = 'PSG';
        }

        if ($status == 'approved') {
            $status               = 1;
            $data['_selStatus']   = 1;
            $data['_getIssue']    = $this->m_monitor->getTransByStatus($status, $jenis);
        } elseif ($status == 'canceled') {
            $status               = 2;
            $data['_selStatus']   = 2;
            $data['_getIssue']    = $this->m_monitor->getTransByStatus($status, $jenis);
        } elseif ($status == 'closed') {
            $status               = 3;
            $data['_selStatus']   = 3;
            $data['_getIssue']    = $this->m_monitor->getTransByStatus($status, $jenis);
        } else {
            $status               = NULL;
            $data['_selStatus']   = NULL;
            $data['_getIssue']    = $this->m_monitor->getTransByStatusPending($jenis);
        }
        $data['jenis']            = $_GET['jenis'];
        $data['_getKaryawan']     = $this->m_monitor->getJumlahRequestK();
        $data['_getTenaker']      = $this->m_monitor->getJumlahRequestTK();
        $this->template->display('monitor/permintaan_review/index', $data);
    }

    function viewApprovalDetail()
    {
        if ('IS_AJAX') {
            $id = $this->input->post('kode');
            $data['getTran'] = $this->m_approval->setInfoTran($id);
            $this->load->view('monitor/permintaan_review/detailIssue', $data);
        }
    }

    //function viewcekDetail(){
    //    if('IS_AJAX') {
    //        $id = $this->input->post('kode');
    //        $data['getTrans'] = $this->m_monitor->getTenakerByTransID($id);
    //		$data['getTranssucces'] = $this->m_monitor->getTenakerByTransIDsucces($id);
    //        $this->load->view('monitor/permintaan_review/viewcekDetail',$data);
    //    }
    //}

    function viewcek()
    {
        $id = $this->input->get('id');
        $this->session->set_flashdata("id", $id);

        redirect('monitor/viewcekdetail');
    }

    function viewallidentifikasiapproved()
    {
        $grupID   = $this->session->userdata('groupuser');
        $jenis    = $_GET['jenis'];
        $status   = $_GET['status'];
        if ($status = 'approved') {
            $status = 1;
        } else {
            $status = '';
        }
        $DetailIDALL = "";
        $getIssue = $this->m_monitor->getTransByStatus($status, $jenis);
        foreach ($getIssue as $row) {
            $DetailIDALL .= "'" . $row->DetailID . "',";
        }
        $DetailID = substr($DetailIDALL, 0, -1);
        $data['_getTrans'] = $this->m_monitor->getTenakerByTransIDALL($DetailID);

        $this->template->display('monitor/permintaan_review/viewcekDetailAll', $data);
    }

    function viewcekdetail()
    {
        $id = $this->session->flashdata("id");
        $this->session->keep_flashdata("id");

        $data['id'] = $id;
        // var_dump( $data['id']); die;
        // var_dump($id);
        // die;

        $data['getTrans'] = $this->m_monitor->getTenakerByTransID($id);
        $data['getTranssucces'] = $this->m_monitor->getTenakerByTransIDsucces($id);

        $this->template->display('monitor/permintaan_review/viewcekDetail', $data, $id);
    }

    function updateidentifikasi()
    {
        $hdrid = $this->input->get('hdrid');
        $this->m_monitor->updatecekidentifikasi($hdrid);
        redirect(site_url('Monitor/reviewIssue'));
    }

    function hapusidentifikasi()
    {
        $hdrid = $this->input->get('hdrid');
        $transid = $this->input->get('id');
        $this->m_monitor->hapuscekidentifikasi($hdrid);
        $this->m_monitor->restoreAngkaTransaksi($transid);
        redirect(site_url('Monitor/reviewIssue'));
    }


    //======== Start to View Docs ===========

    // function ViewAllDataCTK()
    // {
    //     $data['selTenaker'] = $this->input->post('selTenaker') ?? 'all';
    //     $data['page_aktif']    = $this->input->post('page_aktif') ?? 1;

    //     if (!empty($this->input->post('end_date')) && date('Y-m-d', strtotime($this->input->post('end_date'))) >= '2021-01-01') {
    //         $data['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date')));
    //     } else {
    //         $data['end_date'] = date('Y-m-t');
    //     }

    //     if (!empty($this->input->post('start_date')) && date('Y-m-d', strtotime($this->input->post('start_date'))) <= $data['end_date']) {
    //         $data['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date')));
    //     } else {
    //         $data['start_date'] = date('Y-m-d', strtotime($data['end_date'] . ' -3 months'));
    //     }

    //     $data['nama']      = !empty($this->input->post('txtNama')) ? $this->input->post('txtNama') : '';
    //     $data['noreg']     = !empty($this->input->post('txtNoreg')) ? $this->input->post('txtNoreg') : '';

    //     $nums_tart    = $data['page_aktif'] - 1;
    //     $start        = 1;
    //     $end          = 0;
    //     $start_paging = (int)$nums_tart . $start;
    //     $end_paging   = (int)$data['page_aktif'] . $end;

    //     // $list_tk = $this->m_monitor->list_calon_tk($data['selTenaker'], $data['start_date'], $data['end_date'],  $data['nama'], $data['noreg'], $start_paging, $end_paging);
    //     $list_tk = $this->m_monitor->list_calon_tk($data['selTenaker'], $data['start_date'], $data['end_date'],  $data['nama'], $data['noreg']);

    //     $data['_getListTK']   = $list_tk['list_per_page'];
    //     // $data['_peganation']    = $this->pagination->create_links();
    //     $data['_peganation']    = $this->pagination($page = $data['page_aktif'], 10, $list_tk['jumlah_row']);
    //     // print_r($data['_peganation']);
    //     // exit;
    //     $this->template->display('monitor/calon_tk/index2', $data);
    // }



    function viewListTK_()
    {
        // $data['_getListTK']        = $this->m_monitor->getListViewDocs();
        // $data['_getListTKtoExcel'] = $this->m_monitor->toExcelSemua();
        // $this->template->display('monitor/calon_tk/index', $data);

        $data['selTenaker'] = $this->input->post('selTenaker') ?? 'all';
        $data['page_aktif']    = $this->input->post('page_aktif') ?? 1;

        if (!empty($this->input->post('end_date')) && date('Y-m-d', strtotime($this->input->post('end_date'))) >= '2021-01-01') {
            $data['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date')));
        } else {
            $data['end_date'] = date('Y-m-t');
        }

        if (!empty($this->input->post('start_date')) && date('Y-m-d', strtotime($this->input->post('start_date'))) <= $data['end_date']) {
            $data['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date')));
        } else {
            $data['start_date'] = date('Y-m-d', strtotime($data['end_date'] . ' -3 months'));
        }

        $data['nama']      = !empty($this->input->post('txtNama')) ? $this->input->post('txtNama') : '';
        $data['noreg']     = !empty($this->input->post('txtNoreg')) ? $this->input->post('txtNoreg') : '';

        $nums_tart    = $data['page_aktif'] - 1;
        $start        = 1;
        $end          = 0;
        $start_paging = (int)$nums_tart . $start;
        $end_paging   = (int)$data['page_aktif'] . $end;

        $list_tk = $this->m_monitor->list_calon_tk($data['selTenaker'], $data['start_date'], $data['end_date'],  $data['nama'], $data['noreg']);

        $data['_getListTK']   = $list_tk['list_per_page'];
        // print_r($data['_getListTK']);
        // die;
        $data['_peganation']    = $this->pagination($page = $data['page_aktif'], 10, $list_tk['jumlah_row']);

        if ($this->session->userdata('userid') == 'kiki') {

            $this->template->display('monitor/calon_tk/index_dev', $data);
        } else {

            $this->template->display('monitor/calon_tk/index', $data);
        }
    }
    function viewListTK()
    {
        $this->template->display('monitor/calon_tk/index');
    }

    function sendToRegister()
    {
        $headerID        = $this->input->post('headerID');
        $keterangan      = $this->input->post('keterangan');
        $proses          = $this->input->post('proses');

        $result = array();
        $i = 0;
        foreach ($headerID as $key => $val) {

            $result[] = array(
                'HeaderID'        => $headerID[$key],
                'StatusDaftar'    => null,
                'DikirimBy'      => null,
                'DikirimDate'    => null,
                'Proses'          => null,
                'KeteranganKirim' => null,
                'JadwalInterview' => null,
            );
            $i++;
        }
        $feedback = $this->m_monitor->sendToRegister($result);

        if ($feedback == 1) {
            $msg = [
                'type' => 'success',
                'msg' => 'Berhasil'
            ];
        } else {
            $msg = [
                'type' => 'error',
                'msg' => 'Gagal'
            ];
        }
        echo json_encode($msg);
    }

    function sendToTransaksi()
    {
        $headerID        = $this->input->post('headerID');
        $keterangan      = $this->input->post('keterangan');
        $proses          = $this->input->post('proses');

        $result = array();
        $i = 0;
        foreach ($headerID as $key => $val) {

            $result[] = array(
                'HeaderID'        => $headerID[$key],
                // 'StatusDaftar'    => null,
                // 'DiprosesBy'      => null,
                // 'DiprosesDate'    => null,
                // 'Proses'          => null,
                // 'KeteranganKirim' => null,
                'JadwalInterview' => null,
            );
            $i++;
        }
        $feedback = $this->m_monitor->sendToTransaksi($result);

        if ($feedback == 1) {
            $msg = [
                'type' => 'success',
                'msg' => 'Berhasil'
            ];
        } else {
            $msg = [
                'type' => 'error',
                'msg' => 'Gagal'
            ];
        }
        echo json_encode($msg);
    }

    function selectViewTanggal()
    {
        $datea   = date('Y-m-d',  strtotime($this->input->post('datea')));
        $datez   = date('Y-m-d',  strtotime($this->input->post('datez')));

        if ('IS_AJAX') {
            $data['_getTenaker'] = $this->m_monitor->tenakerTanggal($datea, $datez);
            $this->load->view('monitor/calon_tk/tanggal', $data);
        }
    }
    function selectViewTenakerVerifi()
    {
        if ('IS_AJAX') {
            $data['_getTenaker'] = $this->m_monitor->tenakerVerifi();
            $this->load->view('monitor/calon_tk/verifi', $data);
        }
    }
    function selectViewTenakerIdentifi()
    {
        if ('IS_AJAX') {
            $data['_getTenaker'] = $this->m_monitor->tenakerIdentifi();
            $this->load->view('monitor/calon_tk/identifi', $data);
        }
    }
    function selectViewTenakerBelumPosting()
    {
        if ('IS_AJAX') {
            $data['_getTenaker'] = $this->m_monitor->tenakerBelumPosting();
            $this->load->view('monitor/calon_tk/belomPosting', $data);
        }
    }
    function selectViewTenakerProses()
    {
        if ('IS_AJAX') {
            $data['_getTenaker'] = $this->m_monitor->tenakerProses();
            $this->load->view('monitor/calon_tk/proses', $data);
        }
    }
    function selectViewTenakerClosed()
    {
        if ('IS_AJAX') {
            $data['_getTenaker'] = $this->m_monitor->tenakerClosed();
            $this->load->view('monitor/calon_tk/closed', $data);
        }
    }

    function toExcel()
    {
        $select = $this->input->post('select');
        print_r($select);
        die;

        if ($select === 'closed') {
            if ('IS_AJAX') {
                $data['_getTenaker'] = $this->m_monitor->toExcelClosed();
                $this->load->view('monitor/calon_tk/toExcel', $data);
            }
        } elseif ($select === 'verifi') {
            if ('IS_AJAX') {
                $data['_getTenaker'] = $this->m_monitor->toExcelVerifi();
                $this->load->view('monitor/calon_tk/toExcel', $data);
            }
        } elseif ($select === 'identifi') {
            if ('IS_AJAX') {
                $data['_getTenaker'] = $this->m_monitor->toExcelIdentifi();
                $this->load->view('monitor/calon_tk/toExcel', $data);
            }
        } elseif ($select === 'proses') {
            if ('IS_AJAX') {
                $data['_getTenaker'] = $this->m_monitor->toExcelProses();
                $this->load->view('monitor/calon_tk/toExcel', $data);
            }
        } else {
            echo 'Anda tidak beruntung';
        }
    }

    function AutomaticCheck()
    {
        $check = $this->m_monitor->AutoMaticUpdateTK();

        if ($check) {
            $msg = 'success';
        } else {
            $msg = 'failed';
        }

        echo json_encode($msg);
    }

    function viewDocs()
    {
        if ('IS_AJAX') {
            $userID                 = $this->input->post('kode');
            $berkas                 = $this->input->post('nama');
            $data['_jenisBerkas']   = $berkas;
            $data['_getViewDocs']   = $this->m_monitor->getDocs($userID);
            // print_r($data['_getViewDocs']);
            // die;
            $this->load->view('monitor/calon_tk/viewDocs', $data);
            // $this->load->view('monitor/calon_tk/viewDocs', json_encode($data));  
        }
    }
    //======== END to View Docs ===========

    //=========== MONITOR FOR PEMBORONG ===========
    function viewListByPBR_()
    {

        if (!empty($this->input->post('tanggal')) && date('Y-m-d', strtotime($this->input->post('tanggal'))) >= '2021-01-01') {
            $data['tanggal'] = date('Y-m-d', strtotime($this->input->post('tanggal')));
        } else {
            $data['tanggal'] = date('Y-m-d');
        }
        $idpemborong          = $this->session->userdata('idpemborong');
        // $idpemborong          = 57; // tes pbr suprihadi

        $data['selTenaker']   = $this->input->post('selTenaker') ?? 'all';
        $data['_getTenaker']  = $this->m_monitor->listByPBR($idpemborong, $data['selTenaker'], $data['tanggal']);
        $data['idpemborong']  = $idpemborong;

        if ($this->session->userdata('userid') == 'kiki' || $this->session->userdata('userid') == 'KIKI') {

            $this->template->display('monitor/listTenakerForPemborong/index_dev', $data);
        } else {

            $this->template->display('monitor/listTenakerForPemborong/index', $data);
        }
    }

    // function viewListByPBR()
    // {
    //     $data['selTenaker']   = $this->input->post('selTenaker') ?? 'all';
    //     $this->template->display('monitor/listTenakerForPemborong/index');
    // }

    function viewListByPBR()
    {
        // $data['selTenaker']   = $this->input->post('selTenaker') ?? 'all';
        $this->template->display('monitor/listTenakerForPemborong/index');
    }

    function detailtk()
    {
        if ('IS_AJAX') {
            $kode = $this->input->post('kode');
            $data['datatk'] = $this->m_upload_berkas->get_detailtk($kode)->result();
            $this->load->view('monitor/listTenakerForPemborong/detail', $data);
        }
    }

    // ====== New List Tenaker Monitor ======
    function closeTenaker()
    {
        $hdrID = $this->input->post('txtHeaderID');
        $remark = $this->input->post('txtRemarkClose');
        $this->m_monitor->closeTenaker($hdrID, $remark);
        redirect(site_url('Monitor/testPaging'));
    }
    function testPaging()
    {
        /*
         * -- dataSelect -- 
         * 0 => Semua Data
         * 1 => Dalam Proses
         * 2 => Telah Close
         * 3 => Telah Posting
         */
        $dataSelect             = $this->uri->segment(3);
        $num                    = $this->uri->segment(4);
        if ($num == FALSE && $dataSelect == FALSE) {
            redirect('monitor/testPaging/0/1');
        } elseif ($num == FALSE) {
            redirect('monitor/testPaging/' . $dataSelect . '/1');
        }

        // 1. cek apakah user ada di list blacklist atau tidak
        $data['cek_black_list'] = $this->m_monitor->cekTK();

        // 2.  cek masih dalam masa jeda (TanggalKeluarTemporary di pemborong yang sama) 
        // $cekRegInTempSamePemborong  = $this->m_register->cekRegInTempSamePemborong();

        // 3.  cek masih dalam masa jeda (TanggalKeluarTemporary di pemborong yang berbeda) 
        // $cekRegInTempDiffPemborong  = $this->m_register->cekRegInTempDiffPemborong();


        $numStart               = $num - 1;
        $start                  = 1;
        $end                    = 0;
        $startPaging            = (int)$numStart . $start;
        $endPaging              = (int)$num . $end;
        if ($dataSelect == 0) {
            // die;
            $total                = $this->m_monitor->countAllTenaker();
            $data['_selected']    = $dataSelect;
            $data['_tipe']        = NULL;
            $data['_selectWhere'] = $this->m_monitor->selectAllTenaker($startPaging, $endPaging);
            $data['_pagination']  = $this->pagination($page = $num, 10, $total);
        } elseif ($dataSelect == 1) {
            $total                = $this->m_monitor->countOnProccessTenaker();
            $data['_selected']    = $dataSelect;
            $data['_tipe']        = NULL;
            $data['_selectWhere'] = $this->m_monitor->selectOnProccessTenaker($startPaging, $endPaging);
            $data['_pagination']  = $this->pagination($page = $num, 10, $total);
        } elseif ($dataSelect == 2) {
            $total                = $this->m_monitor->countClosedTenaker();
            $data['_selected']    = $dataSelect;
            $data['_tipe']        = NULL;
            $data['_selectWhere'] = $this->m_monitor->selectClosedTenaker($startPaging, $endPaging);
            $data['_pagination']  = $this->pagination($page = $num, 10, $total);
        } elseif ($dataSelect == 3) {
            $total                = $this->m_monitor->countPostedTenaker();
            $data['_selected']    = $dataSelect;
            $data['_tipe']        = NULL;
            $data['_selectWhere'] = $this->m_monitor->selectPostedTenaker($startPaging, $endPaging);
            $data['_pagination']  = $this->pagination($page = $num, 10, $total);
        } else {
            $total                = NULL;
            $data['_selected']    = NULL;
            $data['_tipe']        = NULL;
            $data['_selectWhere'] = NULL;
            $data['_pagination']  = NULL;
        }

        // print_r($this->session->userdata());   
        if ($this->session->userdata('userid') == 'kiki' || $this->session->userdata('userid') == 'KIKI') {
            $this->template->display('monitor/calon_tk/testPaging_dev', $data);
        } else {

            $this->template->display('monitor/calon_tk/testPaging', $data);
        }
    }

    function listtenaker()
    {
        $data['_selected']    = NULL;
        $data['_tipe']        = NULL;
        $data['_selectWhere'] = NULL;
        $data['_pagination']  = NULL;
        // print_r($this->session->userdata());
        // die;

        $this->template->display('monitor/calon_tk/listtenaker', $data);
    }

    function testtest()
    {
        $dataFilter = $this->input->post('selDataFilter');

        $this->session->unset_userdata('w_pemborong');
        $this->session->unset_userdata('w_jekel');
        $this->session->unset_userdata('w_status');
        $this->session->unset_userdata('w_pendidikan');
        $this->session->unset_userdata('w_jurusan');
        $this->session->unset_userdata('w_noreg');
        $this->session->unset_userdata('w_nama');
        $this->session->unset_userdata('w_thnlahir');
        $this->session->unset_userdata('w_tipe');

        if ($this->input->post('txtThnLahir') == NULL && $this->input->post('txtNama') == NULL && $this->input->post('txtNoreg') == NULL && $this->input->post('txtPemborong') == NULL && $this->input->post('txtJekel') == NULL && $this->input->post('txtStatus') == NULL && $this->input->post('txtPendidikan') == NULL && $this->input->post('txtJurusan') == NULL && $this->input->post('tipe') == NULL) {
            redirect('monitor/testPaging/' . $dataFilter);
        }

        $this->session->set_userdata('w_pemborong', $this->input->post('txtPemborong'));
        $this->session->set_userdata('w_jekel', $this->input->post('txtJekel'));
        $this->session->set_userdata('w_status', $this->input->post('txtStatus'));
        $this->session->set_userdata('w_pendidikan', $this->input->post('txtPendidikan'));
        $this->session->set_userdata('w_jurusan', $this->input->post('txtJurusan'));
        $this->session->set_userdata('w_noreg', $this->input->post('txtNoreg'));
        $this->session->set_userdata('w_nama', $this->input->post('txtNama'));
        $this->session->set_userdata('w_thnlahir', $this->input->post('txtThnLahir'));
        $this->session->set_userdata('w_tipe', $this->input->post('tipe'));

        redirect('monitor/testPagingWhere/' . $dataFilter . '/1');
    }

    function testPagingWhere()
    {
        $dataSelect             = $this->uri->segment(3);
        $num                    = $this->uri->segment(4);

        $pemborong  = $this->session->userdata('w_pemborong');
        $jekel      = $this->session->userdata('w_jekel');
        $status     = $this->session->userdata('w_status');
        $pendidikan = $this->session->userdata('w_pendidikan');
        $jurusan    = $this->session->userdata('w_jurusan');
        $noreg      = $this->session->userdata('w_noreg');
        $nama       = $this->session->userdata('w_nama');
        $thnlahir   = $this->session->userdata('w_thnlahir');
        $tipe       = $this->session->userdata('w_tipe');

        $numStart               = $num - 1;
        $start                  = 1;
        $end                    = 0;
        $startPaging            = (int)$numStart . $start;
        $endPaging              = (int)$num . $end;

        if ($dataSelect == 0) {
            $total                = $this->m_monitor->countAllTenakerWhere($pemborong, $jekel, $status, $pendidikan, $jurusan, $noreg, $nama);
            $data['_selected']    = $dataSelect;
            $data['_tipe']        = $tipe;
            $data['_selectWhere'] = $this->m_monitor->selectAllTenakerWhere($startPaging, $endPaging, $pemborong, $jekel, $status, $pendidikan, $jurusan, $noreg, $nama, $thnlahir, $tipe);
            $data['_pagination']  = $this->pagination($page = $num, 10, $total);
            // die;
        } elseif ($dataSelect == 1) {
            $total                = $this->m_monitor->countOnProccessTenakerWhere($pemborong, $jekel, $status, $pendidikan, $jurusan, $noreg, $nama);
            $data['_selected']    = $dataSelect;
            $data['_tipe']        = $tipe;
            $data['_selectWhere'] = $this->m_monitor->selectOnProccessTenakerWhere($startPaging, $endPaging, $pemborong, $jekel, $status, $pendidikan, $jurusan, $noreg, $nama, $thnlahir, $tipe);
            $data['_pagination']  = $this->pagination($page = $num, 10, $total);
        } elseif ($dataSelect == 2) {
            $total                = $this->m_monitor->countClosedTenakerWhere($pemborong, $jekel, $status, $pendidikan, $jurusan, $noreg, $nama);
            $data['_selected']    = $dataSelect;
            $data['_tipe']        = $tipe;
            $data['_selectWhere'] = $this->m_monitor->selectClosedTenakerWhere($startPaging, $endPaging, $pemborong, $jekel, $status, $pendidikan, $jurusan, $noreg, $nama, $thnlahir, $tipe);
            $data['_pagination']  = $this->pagination($page = $num, 10, $total);
        } elseif ($dataSelect == 3) {
            $total                = $this->m_monitor->countPostedTenakerWhere($pemborong, $jekel, $status, $pendidikan, $jurusan, $noreg, $nama);
            $data['_selected']    = $dataSelect;
            $data['_tipe']        = $tipe;
            $data['_selectWhere'] = $this->m_monitor->selectPostedTenakerWhere($startPaging, $endPaging, $pemborong, $jekel, $status, $pendidikan, $jurusan, $noreg, $nama, $thnlahir, $tipe);
            $data['_pagination']  = $this->pagination($page = $num, 10, $total);
        } else {
            $total                = NULL;
            $data['_selected']    = NULL;
            $data['_tipe']        = NULL;
            $data['_selectWhere'] = NULL;
            $data['_pagination']  = NULL;
        }
        // print_r($dataSelect);
        // exit;
        $this->template->display('monitor/calon_tk/testPaging', $data);
    }

    function pagination($page = 1, $per_page = 10, $row = 0)
    {
        $total           = $row;
        $adjacents       = "2";

        $page            = ($page == 0 ? 1 : $page);
        $start           = ($page - 1) * $per_page;

        $prev            = $page - 1;
        $next            = $page + 1;
        $lastpage        = ceil($total / $per_page);
        $lpm1            = $lastpage - 1;

        $pagination = "";
        if ($lastpage > 1) {
            $pagination .= "<ul class='pagination'>";
            $pagination .= "<li><a>Page $page of $lastpage</a></li>";
            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<li class='active'><a>$counter</a></li>";
                    } else {
                        $pagination .= "<li><a href='$counter'>$counter</a></li>";
                    }
                }
            } elseif ($lastpage > 5 + ($adjacents * 2)) {
                if ($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page) {
                            $pagination .= "<li class='active'><a class='active'>$counter</a></li>";
                        } else {
                            $pagination .= "<li><a href='$counter'>$counter</a></li>";
                        }
                    }
                    $pagination .= "<li class='dot'><a>...</a></li>";
                    $pagination .= "<li><a href='$lpm1'>$lpm1</a></li>";
                    $pagination .= "<li><a href='$lastpage'>$lastpage</a></li>";
                } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination .= "<li><a href='1'>1</a></li>";
                    $pagination .= "<li><a href='2'>2</a></li>";
                    $pagination .= "<li class='dot'><a>...</a></li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li class='active'><a class='active'>$counter</a></li>";
                        else
                            $pagination .= "<li><a href='$counter'>$counter</a></li>";
                    }
                    $pagination .= "<li class='dot'><a>...</a></li>";
                    $pagination .= "<li><a href='$lpm1'>$lpm1</a></li>";
                    $pagination .= "<li><a href='$lastpage'>$lastpage</a></li>";
                } else {
                    $pagination .= "<li><a href='1'>1</a></li>";
                    $pagination .= "<li><a href='2'>2</a></li>";
                    $pagination .= "<li class='dot'><a>...</a></li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li class='active'><a class='active'>$counter</a></li>";
                        else
                            $pagination .= "<li><a href='$counter'>$counter</a></li>";
                    }
                }
            }

            if ($page < $counter - 1) {
                $pagination .= "<li><a href='$next'>Next</a></li>";
                $pagination .= "<li><a href='$lastpage'>Last</a></li>";
            } else {
                $pagination .= "<li><a class='current'>Next</a></li>";
                $pagination .= "<li><a class='current'>Last</a></li>";
            }
            $pagination .= "</ul>\n";
        }
        return $pagination;
    }

    function editIssue($id)
    {
        $this->load->model('m_monitor');
        $data['getIssue'] = $this->m_user_login->getUserLogin($id);
    }

    function viewEditIssue()
    {
        if ('IS_AJAX') {
            $id = $this->input->post('kode');
            $data['getDept'] = $this->m_monitor->getDept();
            $data['getDeptPayroll'] = $this->m_monitor->getDeptPayroll();
            $data['getJbtn'] = $this->m_monitor->getJabatan();
            $data['getJbtnPayroll'] = $this->m_monitor->getJabatanPayroll();
            $data['getPemb'] = $this->m_monitor->getPemborongAll();
            $data['getPend'] = $this->m_monitor->getPendidikan();
            $data['getJurs'] = $this->m_monitor->getJurusan();
            $data['getSKwn'] = $this->m_monitor->getStatusKawin();
            $data['getTran'] = $this->m_monitor->setInfoTranEdit($id)->result();

            $row = $this->m_monitor->setInfoTranEdit($id)->row();

            $idDept          = $row->DeptID;
            $data['getKrj']  = $this->m_monitor->getPekerjaan($idDept);

            $this->load->view('monitor/permintaan_review/editIssue', $data);
        }
    }

    function getBagian()
    {
        if ('IS_AJAX') {
            $dept   = $this->input->post('dept');
            $data['_getBagian'] = $this->m_monitor->getPekerjaan($dept);
            $this->load->view('monitor/permintaan_review/borongan/getBagian', $data);
        }
    }
    function doEditIssue()
    {
        $id = $this->input->post('txtID');

        if ($this->input->post('comboPemborong') == 'PSG') {
            $idKerja    = $this->input->post('comboJabatan');
        } else {
            $idKerja    = $this->input->post('comboTansaksi');
        }
        $data = array(
            'DeptID'        => $this->input->post('comboDept'),
            'Pemborong'     => $this->input->post('comboPemborong'),
            'PekerjaanID'   => $idKerja,
            'TKTarget'      => $this->input->post('txtTarget'),
            'TKSedia'       => $this->input->post('txtTersedia'),
            'TKPermintaan'  => $this->input->post('txtPermintaan'),
            'IssueRemark'   => $this->input->post('txtKeterangan'),
            'Umur'          => $this->input->post('txtUmur'),
            'Pendidikan'    => $this->input->post('comboPendidikan'),
            'Jurusan'       => $this->input->post('comboJurusan'),
            'JenisKelamin'  => $this->input->post('comboJekel'),
            'StatusPersonal' => $this->input->post('comboStatus'),
            'UpdatedBy'     => $this->session->userdata('username'),
            'UpdatedDate'   => date('Y-m-d H:m:i')
        );
        $this->m_monitor->updateTran($id, $data);

        redirect(site_url('monitor/reviewIssue'));
    }

    function updateKeterangan()
    {
        $id           = $this->input->post('headerID');
        $keterangan   = $this->input->post('keterangan');

        $data = array(
            'Keterangan'  => $keterangan,
            'UpdatedBy'   => $this->session->userdata('username'),
            'UpdatedDate' => date('Y-m-d H:m:i')
        );
        // print_r($data);
        // die;
        $bebas = $this->m_monitor->updateket($id, $data);
        if ($bebas == 1) {
            $msg = [
                'type' => 'success',
                'msg' => 'Berhasil'
            ];
        } else {
            $msg = [
                'type' => 'error',
                'msg' => 'Gagal'
            ];
        }
        echo json_encode($msg);
    }

    function updateKualifikasi()
    {
        $id           = $this->input->post('headerID');
        $Kualifikasi   = $this->input->post('kualifikasi');

        $data = array(
            'Kualifikasi'  => $Kualifikasi,
            'UpdatedBy'    => $this->session->userdata('username'),
            'UpdatedDate'  => date('Y-m-d H:m:i')
        );
        // print_r($data);
        // die;
        $bebas = $this->m_monitor->updateKualifikasi($id, $data);
        if ($bebas == 1) {
            $msg = [
                'type' => 'success',
                'msg' => 'Berhasil'
            ];
        } else {
            $msg = [
                'type' => 'error',
                'msg' => 'Gagal'
            ];
        }
        echo json_encode($msg);
    }

    function updateStatusCancel()
    {
        $headerID = $this->input->post('id');
        $opt = $this->input->post('opt');
        $pemborong = $this->input->post('pemborong');

        if ($opt == 1) {
            $data = [
                'cancel_status' => $opt,
                'cancel_by' => $this->session->userdata('username'),
                'cancel_date' => date('Y-m-d H:m:i'),
                'cancel_keterangan' => 'Pernah Cancel Sendiri',
            ];

            $update = $this->m_monitor->updateStatusCancel($headerID, $data);

            if ($pemborong != 'PT PULAU SAMBU' || $pemborong != 'YAO HSING') {
                $getData = $this->m_monitor->getDataTK($headerID);

                foreach ($getData as  $value) {
                    $NIK = $value->HeaderID;
                    $cvNama = $value->CVNama;
                    $No_Ktp = $value->No_Ktp;
                    $Nama = $value->Nama;
                    $Tgl_Lahir = $value->Tgl_Lahir;
                    $Nama_Ibu = $value->NamaIbuKandung;
                    $Daerah_Asal = $value->Alamat;
                    $Suku = $value->Suku;
                    $Pemborong = $value->Pemborong;
                    $SubPemborong = $value->SubPemborong;
                    $Id_Pemborong = $value->IDPemborong;
                    $Id_Sub_Pemborong = $value->IDSubPemborong;
                    $Status = 1;
                }

                $dataInsert = [
                    'NIK'              => $NIK,
                    'Nama'             => $Nama,
                    'No_Ktp'           => trim($No_Ktp),
                    'Tgl_Lahir'        => $Tgl_Lahir,
                    'Nama_Ibu'         => $Nama_Ibu,
                    'Daerah_Asal'      => $Daerah_Asal,
                    'Suku'             => $Suku,
                    'Status_Blacklist' => $Status,
                    'CV_Nama'          => $cvNama,
                    'Pemborong'        => $Pemborong,
                    'Sub_Pemborong'    => $SubPemborong,
                    'Id_Pemborong'     => $Id_Pemborong,
                    'Id_Sub_Pemborong' => $Id_Sub_Pemborong,
                    'Blacklist_Date'   => date('Y-m-d H: m: i'),
                    'Created_By'       => $this->session->userdata('username'),
                    'Created_Date'     => date('Y-m-d H: m: i'),
                ];

                $update = $this->m_monitor->insertToBlacklistByPass($dataInsert);
            }
        } elseif ($opt == 2) {
            $data = [
                'cancel_status' => $opt,
                'cancel_by' => $this->session->userdata('username'),
                'cancel_date' => date('Y-m-d H:m:i'),
                'cancel_keterangan' => 'Pernah Cancel Dari Dept',
                'PostingData' => 0,
                'StatusDaftar' => 0,
                'Proses' => NULL,
            ];
            $update = $this->m_monitor->updateStatusCancel($headerID, $data);
        }

        if ($update == 1) {
            $res = [
                'status' => 200
            ];
        } else {
            $res = [
                'status' => 400
            ];
        }

        echo json_encode($res);
    }

    function deleteIssue()
    {
        $id = $this->input->get('id');

        $this->load->model('m_monitor');
        $result = $this->m_monitor->delete($id);
        if (!$result) {
            redirect('monitor/reviewIssue?msg=success_delete');
        } else {
            redirect('monitor/reviewIssue?msg=failed_delete');
        }
    }

    function identifikasi()
    {
        $periode = date('Y-m-d');
        if ($this->input->post('txtperiode')) {
            $periode   = date('Y-m-d',  strtotime($this->input->post('txtperiode')));
        }
        $data['_select']   = $this->m_monitor->SelectIdentifikasi($periode);
        $data['_getperiode']   = $periode;
        $this->template->display('monitor/identifikasi/index', $data);
    }

    public function downloadIdentifikasi()
    {
        $this->load->library("Excel/PHPExcel");

        $export = $this->input->post('selDataExport');
        // select data from database
        $periode    = $this->input->post('dttanggal');

        $title  = 'List Identifikasi';
        $data   = $this->m_monitor->SelectIdentifikasi($periode);

        $objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(36);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(28);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(19);

        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('000');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', $title . ' : ' . $periode)

            ->setCellValue('A3', 'No.')
            ->setCellValue('B3', 'RegisID')
            ->setCellValue('C3', 'Nama')
            ->setCellValue('D3', 'CV Nama')
            ->setCellValue('E3', 'Pemborong')
            ->setCellValue('F3', 'Departemen')
            ->setCellValue('G3', 'Bagian');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $no = 1;
        $counter = 4;
        foreach ($data as $row) {
            $ex->setCellValue('A' . $counter, $no++);
            $ex->setCellValue('B' . $counter, $row->HeaderID);
            $ex->setCellValue('C' . $counter, $row->Nama);
            $ex->setCellValue('D' . $counter, $row->CVNama);
            $ex->setCellValue('E' . $counter, $row->Pemborong);
            $ex->setCellValue('F' . $counter, $row->DeptTujuan);
            $ex->setCellValue('G' . $counter, $row->Transaksi);
            $counter = $counter + 1;
        }

        $objPHPExcel->getActiveSheet()->setTitle('LaporanIdentifikasi');

        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        header('Last-Modified:' . gmdate("D, d M Y H:i:s") . 'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Lap_Identifikasi(' . $periode . ').xls"');

        $objWriter->save('php://output');
    }

    function calonkandidat_()
    {
        // print_r($this->session->userdata('userid'));


        $page = $this->uri->segment(4);
        if ($this->uri->segment(2) == FALSE || $this->uri->segment(3) == FALSE || $this->uri->segment(4) == FALSE) {
            redirect(base_url('monitor/calonkandidat/10/1'));
        }
        $numStart               = $page - 1;
        $start                  = 1;
        $end                    = 0;
        $perPage                = array($this->uri->segment(3) / 10, $this->uri->segment(3));
        $startPaging            = (int)($numStart * $perPage[0]) . $start;
        $endPaging              = (int)($page * $perPage[0]) . $end;
        $total                  = $this->m_monitor->countCalonKandidat();
        $data['_getData']       = $this->m_monitor->getCalonKandidat($startPaging, $endPaging);
        $data['_pagination']    = $this->pagination($page, $perPage[1], $total);
        if ($this->session->userdata('userid') == 'KIKI') {
            $this->template->display('monitor/calon_kandidat/index2', $data);
            // die;
        } else {

            $this->template->display('monitor/calon_kandidat/index', $data);
        }
    }
    function calonkandidat()
    {

        $this->template->display('monitor/calon_kandidat/index');
    }

    function setFilterCalonKandidat()
    {
        $this->session->unset_userdata('f_nama');
        $this->session->unset_userdata('f_periode');

        if ($this->input->post('txtFilterNama') == NULL && $this->input->post('txtperiode') == NULL) {
            redirect(base_url('monitor/calonkandidat/10/1'));
        }

        $this->session->set_userdata('f_nama', $this->input->post('txtFilterNama'));
        $this->session->set_userdata('f_periode', $this->input->post('txtperiode'));

        redirect(base_url('monitor/getFilterCalonKandidat/10/1'));
    }

    function getFilterCalonKandidat()
    {
        $page = $this->uri->segment(4);

        $nama           = $this->session->userdata('f_nama');
        $periode        = $this->session->userdata('f_periode');

        if ($this->uri->segment(2) == FALSE || $this->uri->segment(3) == FALSE || $this->uri->segment(4) == FALSE) {
            redirect(base_url('monitor/getFilterCalonKandidat/10/1'));
        }
        $numStart   = $page - 1;
        $start      = 1;
        $end        = 0;
        $perPage    = array($this->uri->segment(3) / 10, $this->uri->segment(3));
        $startPaging = (int)($numStart * $perPage[0]) . $start;
        $endPaging  = (int)($page * $perPage[0]) . $end;
        $total      = $this->m_monitor->countCalonKandidatwhere($nama, $periode);
        $data['_getData'] = $this->m_monitor->getCalonKandidatwhere($startPaging, $endPaging, $nama, $periode);
        $data['_pagination']    = $this->pagination($page, $perPage[1], $total);
        $this->template->display('monitor/calon_kandidat/index', $data);
    }

    function hapusdataCK()
    {
        $id = $this->input->get('id');
        $result = $this->m_monitor->hapusCK($id);
        if ($result) {
            redirect('Monitor/calonkandidat?msg=success_delete');
        } else {
            redirect('Monitor/calonkandidat?msg=failed_delete');
        }
    }

    function monitorpermintaanbydept()
    {
        // var_dump($this->session->userdata());
        // die;
        $periode = $this->input->post('txtPeriode');
        $data['periodeaktif'] = $periode;
        $data['_getData'] = $this->m_monitor->getdataIdeal($periode);
        $this->template->display('monitor/ideal/index', $data);
    }

    function reviewIdeal()
    {
        if ('IS_AJAX') {
            $issueID    = $this->input->post('kode');
            $cekDataKry    = $this->m_monitor->getDetailSubPerkerjaanDeptKry($issueID);
            $cekDataBor    = $this->m_monitor->getDetailSubPerkerjaanDeptBor($issueID);
            $data['_getKaryawan']   = $this->m_monitor->getDetailSubPerkerjaanDeptKry($issueID)->result();
            $data['_getBorongan']   = $this->m_monitor->getDetailSubPerkerjaanDeptBor($issueID)->result();
            $this->load->view('monitor/ideal/detail', $data);
        }
    }

    function uploadberkas()
    {
        $id  = $this->input->get('id');
        $nama   = $this->input->get('nama');
        $this->session->set_flashdata("regid", $id);
        $this->session->set_flashdata("regnama", $nama);

        redirect('Monitor/uploadberkasck');
    }

    function uploadberkasck()
    {
        $id = $this->session->flashdata("regid");
        //redirect("uploadBerkas/listTKforUploadDoc");;
        $id = $this->session->flashdata("regid");
        $nama = $this->session->flashdata("regnama");
        $this->session->keep_flashdata("regid");
        $this->session->keep_flashdata("regnama");

        $data['id'] = $id;
        $data['namapelamar'] = $nama;
        $data['errormsg'] = "";

        $data['databerkas'] = $this->m_monitor->get_db_berkas($id)->result();

        $this->template->display('registrasi/calon_kandidat/upload', $data);
    }

    function uploadarea()
    {
        $tipe = $this->input->post("tipe");
        $data["id"] = $this->input->post("id");
        $data["namapelamar"] = $this->input->post("nama");
        $data['errormsg'] = "";

        switch ($tipe) {
            case 'cv':
                $namaberkas = "CV";
                break;
            case 'riwayathidup':
                $namaberkas = "Daftar Riwayat Hidup";
                break;
            case 'ijazah':
                $namaberkas = "Ijazah";
                break;
        }

        $data['jenisberkas']    = $tipe;
        $data['namaberkas']     = $namaberkas;
        if ($tipe === "cv") {
            $this->load->view('registrasi/calon_kandidat/formCV', $data);
        } elseif ($tipe == "riwayathidup") {
            $this->load->view('registrasi/calon_kandidat/formRH', $data);
        } else {
            $this->load->view('registrasi/calon_kandidat/formIjazah', $data);
        }
    }

    function do_upload($berkas)
    {
        switch ($berkas) {
            case "cv":
                $url = './dataupload/calonkandidat/cv';
                $namaberkas = "CV";
                break;
            case "riwayathidup":
                $url = './dataupload/calonkandidat/riwayathidup';
                $namaberkas = "Daftar Riwayat Hidup";
                break;
            case "ijazah":
                $url = './dataupload/calonkandidat/ijazah';
                $namaberkas = "Ijazah";
                break;
            default:
                $url = './dataupload/calonkandidat';
                $namaberkas = "Lain-Lain";
                break;
        }

        $id = $this->input->post("txtid");
        $namapelamar = $this->input->post("txtnamapelamar");
        $namafile = $id . '_' . $berkas;

        $data['namapelamar']        = $namapelamar;
        $config['upload_path']      = $url;
        $config['allowed_types']    = 'pdf';
        $config['allow_scale_up']   = true;
        $config['overwrite']        = true;
        $config['file_name']        = $namafile;
        $config['max_size']         = '5120';

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->upload->do_upload('txtfile')) {
            $this->upload->data();
            $data['errormsg'] = "<div class='alert alert-success'><a class='close' data-dismiss='alert'>×</a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Berkas $namaberkas Berhasil</strong></div>";
            $this->m_monitor->update_db_berkas($id, $berkas, $url . '/' . $namafile . '.pdf');
        } else {
            $error = $this->upload->display_errors();
            $data['errormsg'] = "<div class='alert alert-danger'><a class='close' data-dismiss='alert'><i class='fa fa-times'>&nbsp;</i></a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Berkas $namaberkas Gagal</strong><br/>$error</div>";
        }

        $data['databerkas']     = $this->m_monitor->get_db_berkas($id)->result();
        $data['id']  = $id;
        $this->template->display('registrasi/calon_kandidat/upload', $data);
    }

    function ubahfotokaryawan()
    {
        $id = $this->input->get('id');
        $this->session->set_flashdata("id", $id);

        redirect('monitor/changefoto');
        //$data['_getdatafoto'] = $this->m_monitor->getdatafoto($id);
        //$this->template->display('monitor/calon_tk/changefoto',$data);
    }

    function changefoto()
    {
        $id = $this->session->flashdata("id");
        $this->session->keep_flashdata("id");
        $data['_refid'] = $id;
        $data['_getdatafoto'] = $this->m_monitor->getdatafoto($id);
        $this->template->display('monitor/calon_tk/changefoto', $data);
    }

    function uploadPhoto()
    {
        $this->load->library('image_moo');

        $url = './dataupload/fotoProfil/';
        $loginID    = $this->input->post("txtID");
        $filefoto = $loginID;

        $config['upload_path']      = $url;
        $config['allowed_types']    = 'jpeg|jpg|png|gif';
        $config['allow_scale_up']   = true;
        $config['overwrite']        = true;
        $config['max_size']         = '1024';
        $config['file_name']        = $filefoto . '.png';    //Filename harus pakai headerID pelamar

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->upload->do_upload('fileFoto1') == "") {
            $file = $this->upload->do_upload('fileFoto2');
        } else {
            $file = $this->upload->do_upload('fileFoto1');
        }
        if ($file) {
            $files = $this->upload->data();
            $fileNameResize = $config['upload_path'] . $files['file_name'];

            $this->image_moo
                ->load($fileNameResize)
                ->set_background_colour('#fff')
                ->resize(200, 200, TRUE)
                ->save($fileNameResize, true);

            if ($this->image_moo->errors) {
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                foto gagal dirubah...!</div>');
                redirect('monitor/ubahfotokaryawan?id="' . $loginID . '"', 'refresh');
            } else {
                $this->m_monitor->update_status_foto($loginID);
                $this->image_moo->clear();
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                foto berhasil dirubah...!</div>');
                redirect('monitor/testPaging/0/1', 'refresh');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
            foto gagal dirubah...!</div>');
            redirect('monitor/ubahfotokaryawan?id="' . $loginID . '"', 'refresh');
        }
        $this->image_moo->clear();
    }


    public function CetakreviewIssue()
    {
        $jns  = $this->uri->segment(3);
        $status = $this->uri->segment(4);
        if ($jns == 'harian') {
            $jenis = 'ALL PEMBORONG';
        } else {
            $jenis = 'PSG';
        }
        // include APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel.php';
        // include APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';

        $style1 = [

            'font'      => ['bold' => true, 'name' => 'Time New Roman', 'size' => '14'],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'wrap' => true,
                'vertical'  => Alignment::VERTICAL_CENTER
            ],

            'borders'   => [
                'top'   => ['style'  => Border::BORDER_THIN], // Set border top dengan garis tipis   
                'right' => ['style'  => Border::BORDER_THIN],  // Set border right dengan garis tipis    
                'bottom' => ['style'  => Border::BORDER_THIN], // Set border bottom dengan garis tipis    
                'left'  => ['style'  => Border::BORDER_THIN] // Set border left dengan garis tipis  
            ]
        ];
        $style2 = [

            'font'      => ['bold' => false, 'name' => 'Time New Roman', 'size' => '11'],
            'fill'      => [
                'type' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'FF0000')
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],

            'borders'   => [
                'top'   => ['style'  => Border::BORDER_THIN], // Set border top dengan garis tipis   
                'right' => ['style'  => Border::BORDER_THIN],  // Set border right dengan garis tipis    
                'bottom' => ['style'  => Border::BORDER_THIN], // Set border bottom dengan garis tipis    
                'left'  => ['style'  => Border::BORDER_THIN] // Set border left dengan garis tipis  
            ]
        ];
        $style3 = [

            'font'      => ['bold' => false, 'name' => 'Time New Roman', 'size' => '11'],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],

            'borders'   => [
                'top'   => ['style'  => Border::BORDER_THIN], // Set border top dengan garis tipis   
                'right' => ['style'  => Border::BORDER_THIN],  // Set border right dengan garis tipis    
                'bottom' => ['style'  => Border::BORDER_THIN], // Set border bottom dengan garis tipis    
                'left'  => ['style'  => Border::BORDER_THIN] // Set border left dengan garis tipis  
            ]
        ];
        $style4 = [

            'font'      => ['bold' => false, 'name' => 'Time New Roman', 'size' => '11'],
            'fill'      => [
                'type' => Fill::FILL_SOLID,
                'color' => array('rgb' => '#BDB76B')
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],

            'borders'   => [
                'top'   => ['style'  => Border::BORDER_THIN], // Set border top dengan garis tipis   
                'right' => ['style'  => Border::BORDER_THIN],  // Set border right dengan garis tipis    
                'bottom' => ['style'  => Border::BORDER_THIN], // Set border bottom dengan garis tipis    
                'left'  => ['style'  => Border::BORDER_THIN] // Set border left dengan garis tipis  
            ]
        ];

        // $objPHPExcel = new PHPExcel();
        $objPHPExcel = new Spreadsheet();

        if ($status == '1') {
            $status = 1;
            $nmstatus = 'Approved';
            $cetak = $this->m_monitor->getTransByStatus($status, $jenis);
        } elseif ($status == '2') {
            $status = 2;
            $nmstatus = 'Canceled';
            $cetak = $this->m_monitor->getTransByStatus($status, $jenis);
        } elseif ($status == '3') {
            $status = 3;
            $nmstatus = 'Closed';
            $cetak = $this->m_monitor->getTransByStatus($status, $jenis);
        } else {
            $status = NULL;
            $nmstatus = 'Pending';
            $cetak = $this->m_monitor->getTransByStatusPending($jenis);
        }

        // $objPHPExcel    = new PHPExcel();
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);
        $no = 0;
        $tot_sisa = 0;
        $tot_penuhi = 0;
        $tot_minta = 0;
        $tot_identifikasi = 0;
        $ex = $objPHPExcel->setActiveSheetIndex(0);
        foreach ($cetak as $ctk) {
            $no++;
            $objPHPExcel->getActiveSheet()->mergeCells('A2:T2')->setCellValue('A2', 'Data Issue Permintaan ' . $nmstatus)->getStyle('A2:T2')->applyFromArray($style1);
            if ($nmstatus == 'Closed') {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'ID')
                    ->setCellValue('B4', 'DEPT')
                    ->setCellValue('C4', 'POSISI')
                    ->setCellValue('D4', 'MINTA')
                    ->setCellValue('E4', 'OK')
                    ->setCellValue('F4', 'SISA')
                    ->setCellValue('G4', 'IDEN')
                    ->setCellValue('H4', 'DEPT')
                    ->setCellValue('I4', 'DIVISI')
                    ->setCellValue('J4', 'PSN')
                    ->setCellValue('K4', 'AGM')
                    ->setCellValue('L4', 'VGM')
                    ->setCellValue('M4', 'STATUS')
                    ->setCellValue('N4', 'TGL CLOSED')
                    ->setCellValue('O4', 'REQUEST BY')
                    ->setCellValue('P4', 'REQUEST DATE')
                    ->setCellValue('Q4', 'KETENTUAN')
                    ->setCellValue('R4', 'PENDIDIKAN')
                    ->setCellValue('S4', 'JURUSAN')
                    ->setCellValue('T4', 'JENIS KELAMIN')
                    ->setCellValue('U4', 'CATATAN')
                    ->setCellValue('V4', 'JABATAN')
                    ->setCellValue('W4', 'SUB JABATAN');
            } else {
                # code...
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'ID')
                    ->setCellValue('B4', 'DEPT')
                    ->setCellValue('C4', 'POSISI')
                    ->setCellValue('D4', 'MINTA')
                    ->setCellValue('E4', 'OK')
                    ->setCellValue('F4', 'SISA')
                    ->setCellValue('G4', 'IDEN')
                    ->setCellValue('H4', 'DEPT')
                    ->setCellValue('I4', 'DIVISI')
                    ->setCellValue('J4', 'PSN')
                    ->setCellValue('K4', 'AGM')
                    ->setCellValue('L4', 'VGM')
                    ->setCellValue('M4', 'STATUS')
                    ->setCellValue('N4', 'REQUEST BY')
                    ->setCellValue('O4', 'REQUEST DATE')
                    ->setCellValue('P4', 'KETENTUAN')
                    ->setCellValue('Q4', 'PENDIDIKAN')
                    ->setCellValue('R4', 'JURUSAN')
                    ->setCellValue('S4', 'JENIS KELAMIN')
                    ->setCellValue('T4', 'CATATAN')
                    ->setCellValue('U4', 'JABATAN')
                    ->setCellValue('V4', 'SUB JABATAN');
            }
            $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('D4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('E4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('F4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('G4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('H4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('I4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('J4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('K4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('L4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('M4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('N4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('O4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('P4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('Q4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('R4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('S4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('T4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('U4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('V4')->applyFromArray($style2);
            $objPHPExcel->getActiveSheet()->getStyle('W4')->applyFromArray($style2);
        }

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $no = 1;
        $counter = 5;
        foreach ($cetak as $row) {
            $target           = $row->TKTarget;
            $sedia            = $row->TKSedia;
            $minta            = $row->TKPermintaan;
            $jumlahID         = $row->Identifikasi;

            $sisa             = $target - $sedia;
            $penuhi           = $sisa - $minta;
            $diidentifikasi   = $jumlahID - ($penuhi);

            // rumus baru
            // astaga pabo, gini aja gak diperbaiki.
            $penuhi2 = $row->Success;
            $minta2 = $sisa - $penuhi2;
            $diidentifikasi2 = $jumlahID - $penuhi2;

            // $tot_sisa         += $sisa;
            // $tot_penuhi       += $penuhi;
            // $tot_minta        += $minta;
            // $tot_identifikasi += $diidentifikasi;

            $tot_sisa         += $sisa;
            $tot_penuhi       += $penuhi2;
            $tot_minta        += $minta2;
            $tot_identifikasi += $diidentifikasi2;

            if ($row->DEPTStatus == '1') {
                $DEPTApprov =  '☑' . $row->DEPTApproval;
            } else if ($row->DEPTStatus == '2') {
                $DEPTApprov =  '☒' . $row->DEPTApproval;
            } else {
                $DEPTApprov = 'Pending';
            }

            if ($row->DIVISIStatus == '1') {
                $DIVISIApprov =  '☑' . $row->DIVISIApproval;
            } else if ($row->DIVISIStatus == '2') {
                $DIVISIApprov =  '☒' . $row->DIVISIApproval;
            } else {
                $DIVISIApprov = 'Pending';
            }

            if ($row->PSNStatus == '1') {
                $PSNApprov =  '☑' . $row->PSNApproval;
            } else if ($row->PSNStatus == '2') {
                $PSNApprov =  '☒' . $row->PSNApproval;
            } else {
                $PSNApprov = 'Pending';
            }

            if ($row->AGMStatus == '1') {
                $AGMApprov =  '☑' . $row->AGMApproval;
            } else if ($row->AGMStatus == '2') {
                $AGMApprov =  '☒' . $row->AGMApproval;
            } else {
                $AGMApprov = 'Pending';
            }

            if ($row->VGMStatus == '1') {
                $VGMApprov =  '☑' . $row->VGMApproval;
            } else if ($row->VGMStatus == '2') {
                $VGMApprov =  '☒' . $row->VGMApproval;
            } else {
                $VGMApprov = 'Pending';
            }

            if ($row->DEPTDate != '') {
                $DEPTDate =  date('d M Y H:m:i', strtotime($row->DEPTDate));
            } else {
                $DEPTDate = '';
            }
            if ($row->DIVISIDate != '') {
                $DIVISIDate =  date('d M Y H:m:i', strtotime($row->DIVISIDate));
            } else {
                $DIVISIDate = '';
            }
            if ($row->PSNDate != '') {
                $PSNDate =  date('d M Y H:m:i', strtotime($row->PSNDate));
            } else {
                $PSNDate = '';
            }
            if ($row->AGMDate != '') {
                $AGMDate =  date('d M Y H:m:i', strtotime($row->AGMDate));
            } else {
                $AGMDate = '';
            }
            if ($row->VGMDate != '') {
                $VGMDate =  date('d M Y H:m:i', strtotime($row->VGMDate));
            } else {
                $VGMDate = '';
            }
            $ex->setCellValue('A' . $counter, $row->DetailID);
            $ex->setCellValue('B' . $counter, $row->DeptAbbr);
            $ex->setCellValue('C' . $counter, $row->Pekerjaan);
            $ex->setCellValue('D' . $counter, $sisa);
            // $ex->setCellValue('E' . $counter, $penuhi);
            $ex->setCellValue('E' . $counter, $penuhi2);
            // $ex->setCellValue('F' . $counter, $minta);
            $ex->setCellValue('F' . $counter, $minta2);
            // $ex->setCellValue('G' . $counter, $diidentifikasi2);
            $ex->setCellValue('G' . $counter, ($diidentifikasi2) < 0 ? 0 : ($diidentifikasi2));
            $ex->setCellValue('H' . $counter, $DEPTApprov . ', ' . $DEPTDate);
            $ex->setCellValue('I' . $counter, $DIVISIApprov . ', ' . $DIVISIDate);
            $ex->setCellValue('J' . $counter, $PSNApprov . ', ' . $PSNDate);
            $ex->setCellValue('K' . $counter, $AGMApprov . ', ' . $AGMDate);
            $ex->setCellValue('L' . $counter, $VGMApprov . ', ' . $VGMDate);
            $ex->setCellValue('M' . $counter, $nmstatus);
            if ($nmstatus == 'Closed') {
                # code...
                $ex->setCellValue('N' . $counter, $row->UpadatedPostDate != NULL ? date('d-m-Y H:i:s', strtotime($row->UpadatedPostDate)) : '');
                $ex->setCellValue('O' . $counter, $row->CreatedBy);
                $ex->setCellValue('P' . $counter, date('d-M-Y H:m:i', strtotime($row->CreatedDate)));
                $ex->setCellValue('Q' . $counter, $row->IssueRemark);
                $ex->setCellValue('R' . $counter, $row->Pendidikan);
                $ex->setCellValue('S' . $counter, $row->Jurusan);
                $ex->setCellValue('T' . $counter, $row->JenisKelamin);
                $ex->setCellValue('U' . $counter, $row->Umur);
                $ex->setCellValue('V' . $counter, $row->JabatanName);
                $ex->setCellValue('W' . $counter, $row->SubJabatanName);
            } else {
                $ex->setCellValue('N' . $counter, $row->CreatedBy);
                $ex->setCellValue('O' . $counter, date('d-M-Y H:m:i', strtotime($row->CreatedDate)));
                $ex->setCellValue('P' . $counter, $row->IssueRemark);
                $ex->setCellValue('Q' . $counter, $row->Pendidikan);
                $ex->setCellValue('R' . $counter, $row->Jurusan);
                $ex->setCellValue('S' . $counter, $row->JenisKelamin);
                $ex->setCellValue('T' . $counter, $row->Umur);
                $ex->setCellValue('U' . $counter, $row->JabatanName);
                $ex->setCellValue('V' . $counter, $row->SubJabatanName);
                # code...
            }

            //Style
            $ex->getStyle('A' . $counter)->applyFromArray($style3);
            $ex->getStyle('B' . $counter)->applyFromArray($style3);
            $ex->getStyle('C' . $counter)->applyFromArray($style3);
            $ex->getStyle('D' . $counter)->applyFromArray($style3);
            $ex->getStyle('E' . $counter)->applyFromArray($style3);
            $ex->getStyle('F' . $counter)->applyFromArray($style3);
            $ex->getStyle('G' . $counter)->applyFromArray($style3);
            $ex->getStyle('H' . $counter)->applyFromArray($style3);
            $ex->getStyle('I' . $counter)->applyFromArray($style3);
            $ex->getStyle('J' . $counter)->applyFromArray($style3);
            $ex->getStyle('K' . $counter)->applyFromArray($style3);
            $ex->getStyle('L' . $counter)->applyFromArray($style3);
            $ex->getStyle('M' . $counter)->applyFromArray($style3);
            $ex->getStyle('N' . $counter)->applyFromArray($style3);
            $ex->getStyle('O' . $counter)->applyFromArray($style3);
            $ex->getStyle('P' . $counter)->applyFromArray($style3);
            $ex->getStyle('Q' . $counter)->applyFromArray($style3);
            $ex->getStyle('R' . $counter)->applyFromArray($style3);
            $ex->getStyle('S' . $counter)->applyFromArray($style3);
            $ex->getStyle('T' . $counter)->applyFromArray($style3);
            $ex->getStyle('U' . $counter)->applyFromArray($style3);
            $ex->getStyle('V' . $counter)->applyFromArray($style3);
            $ex->getStyle('W' . $counter)->applyFromArray($style3);
            $counter = $counter + 1;
        }
        $counter2 = $counter;
        // var_dump($test); die;
        $ex->mergeCells('A' . $counter2 . ':C' . $counter2)->setCellValue('A' . $counter2, 'TOTAL');
        $ex->mergeCells('D' . $counter2 . ':D' . $counter2)->setCellValue('D' . $counter2, $tot_sisa);
        $ex->mergeCells('E' . $counter2 . ':E' . $counter2)->setCellValue('E' . $counter2, $tot_penuhi);
        $ex->mergeCells('F' . $counter2 . ':F' . $counter2)->setCellValue('F' . $counter2, $tot_minta);
        $ex->mergeCells('G' . $counter2 . ':G' . $counter2)->setCellValue('G' . $counter2, $tot_identifikasi);
        $ex->getStyle('A' . $counter2 . ':C' . $counter2)->applyFromArray($style2);
        $ex->getStyle('D' . $counter2)->applyFromArray($style2);
        $ex->getStyle('E' . $counter2)->applyFromArray($style2);
        $ex->getStyle('F' . $counter2)->applyFromArray($style2);
        $ex->getStyle('G' . $counter2)->applyFromArray($style2);
        $ex->getStyle('H' . $counter2 . ':T' . $counter2)->applyFromArray($style2);



        // $filename = "Issue Permintaan " . $nmstatus . '.xlsx';
        // $objPHPExcel->getActiveSheet()->setTitle($nmstatus);
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachement; filename="' . $filename . '"');
        // header('Cache-Control: max-age=0');

        // $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        // $writer->save('php://output');
        // exit;

        $writer = new Xlsx($objPHPExcel);

        header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Issue Permintaan (' . $nmstatus . ').xlsx"');

        $writer->save('php://output');
        exit;
    }

    public function show()
    {

        // if ($this->input->is_ajax_request()) {
        // print_r($_POST);
        // die;
        $list = $this->m_monitor->get_datatables();
        $data = array();
        $no   = $_POST['start'];
        foreach ($list as $field) {

            $jenis_kelamin = 'Perempuan';
            if ($field->JK == 'L') {
                $jenis_kelamin = 'Laki-laki';
            }

            if ($field->Status == 'TL') {
                $new_status = "<span class='label label-sm label-danger'>Tidak Lulus</span>";;
            } elseif ($field->Status == 'L') {
                $new_status = "<span class='label label-sm label-primary'>Lulus</span>";
            } else {
                $new_status = "";
            }

            if ($field->StsTest == 'Test') {
                $status_test = "<span class='label label-sm label-primary'>Test</span>";;
            } elseif ($field->StsTest == 'Non Test') {
                $status_test = "<span class='label label-sm label-danger'>Tidak Test</span>";
            } else {
                $status_test = "";
            }

            if ($field->Transport == 'Diganti') {
                $transport = "<span class='label label-sm label-primary'>Diganti</span>";;
            } elseif ($field->Transport == 'Tidak Diganti') {
                $transport = "<span class='label label-sm label-danger'>Tidak Diganti</span>";
            } else {
                $transport = "";
            }


            $no++;
            $row   = array();
            $row[] = $no . '.' . '<input class="data-id" id="data-id" value="' . $field->ID . '" type="hidden" data-id="' . $field->ID . '">';
            $row[] = trim($field->Nama);
            $row[] = $jenis_kelamin;
            $row[] = $field->Tempat_Lhr . ', ' . date('d-m-Y', strtotime($field->Tanggal_Lhr));
            $row[] = $field->NoKTP;
            $row[] = $field->NoHP;
            $row[] = $field->Email;
            $row[] = $field->Posisi;
            $row[] = $field->Level;
            $row[] = $field->DeptAbbr;
            $row[] = $field->NamaDivisi;
            $row[] = $field->Pendidikan;
            $row[] = $field->Jurusan;
            $row[] = $field->JadwalTest;
            $row[] = $new_status;
            $row[] = $transport;
            $row[] = $status_test;
            $row[] = $field->Biaya;
            $row[] = $field->SumberPelamar;
            $row[] = $field->Keterangan;
            $row[] = $field->CreatedBy . '<br><small>' . date('d-m-Y', strtotime($field->CreatedDate)) . '<small>';
            $row[] = '<a class="edit btn btn-primary btn-xs" title="Edit Calon Kandidat"><i class="fa fa-edit"></i></a>
                          <a href="' . site_url("Monitor/hapusdataCK?id=" . $field->ID) . '" class="btn btn-danger btn-xs hapusCK" title="Hapus Calon Kandidat"><i class="glyphicon glyphicon-trash"></i></a>
                          <a title="Upload berkas" class="btn btn-minier btn-round btn-success" href="' . site_url("Monitor/uploadberkas") . '"?id="' . $field->ID . '"&nama="' . $field->Nama . '">
                                Upload
                          </a>';



            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->m_monitor->count_all(),
            "recordsFiltered" => $this->m_monitor->count_filtered(),
            "data"            => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
        // }
    }

    public function showTenakerNew()
    {


        // if ($this->input->is_ajax_request()) {
        $cek_black_list = $this->m_monitor->cekTK();
        $list = $this->m_monitor->get_dataTenakerNew();

        $data = array();
        $no   = $_POST['start'];
        foreach ($list as $field) {


            if ($field->SpecialScreening == true) {
                $screened = '<span class="label label-sm label-success">Lulus</span>';;
            } elseif ($field->SpecialScreening == NULL) {
                $screened = "<span class='label label-sm label-default'>Belum</span>";
            } elseif ($field->SpecialScreening == false) {
                $screened = "<span class='label label-sm label-danger'>Gagal</span>";
            }

            if ($field->WawancaraKe == NULL) {
                $wawancara = '<span class="label label-sm label-default">Belum Pernah</span>';
            } else {
                $wawancara = ' <a title="View Detail" data-rel="tooltip" href="javascript:;" class="detailInterview btn btn-minier btn-white btn-block">
                                    <i class="ace-icon fa fa-files-o bigger-100"></i>' . $field->WawancaraKe . ' kali
                                   </a>';
            }

            $berkas = '<div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle">
                                Berkas
                                <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-default">
                                ';

            if (isset($_POST['selDataFilter']) && $_POST['selDataFilter'] == '3') {
                $table = 'vwTrnReportPosted';
            } else {
                $table = 'vwListBerkas';
            }
            if ($this->m_monitor->column_exists($table, 'KK')) {



                if ($field->KTP != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="KTP" data-tk="' . ucwords(strtolower($field->Nama)) . '">KTP</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>KTP is NULL</i></small></a></li>';
                }
                if ($field->KK != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="KK" data-tk="' . ucwords(strtolower($field->Nama)) . '">KK</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>KK is NULL</i></small></a></li>';
                }
                if ($field->SKCK != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="SKCK" data-tk="' . ucwords(strtolower($field->Nama)) . '">SKCK</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>SKCK is NULL</i></small></a></li>';
                }
                if ($field->Lamaran != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Lamaran" data-tk="' . ucwords(strtolower($field->Nama)) . '">Lamaran</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Lamaran is NULL</i></small></a></li>';
                }
                if ($field->CV != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="CV" data-tk="' . ucwords(strtolower($field->Nama)) . '">CV</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>CV is NULL</i></small></a></li>';
                }
                if ($field->Ijazah != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Ijazah" data-tk="' . ucwords(strtolower($field->Nama)) . '">Ijazah</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Ijazah is NULL</i></small></a></li>';
                }
                if ($field->Transkrip != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Transkrip" data-tk="' . ucwords(strtolower($field->Nama)) . '">Transkip</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Transkrip is NULL</i></small></a></li>';
                }
                if ($field->Vaksin1 != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin1" data-tk="' . ucwords(strtolower($field->Nama)) . '">Berkas Pendukung</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Berkas Pendukung is NULL</i></small></a></li>';
                }
                if ($field->Vaksin2 != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin2" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 2</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Vaksin2 is NULL</i></small></a></li>';
                }

                if ($field->Vaksin3 != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin3" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 3</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Vaksin3 is NULL</i></small></a></li>';
                }
                $berkas .= '</ul>
                            </div>
                            <a title="View Detail" data-rel="tooltip" href="javascript:;" class="detailInfo btn btn-minier btn-round btn-primary">
                                <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                            </a>                           
                            ';

                // if ($this->session->userdata('userid') == 'KIKI') {
                $berkas .= ' <a title="Export Excel" target="_blank" data-rel="tooltip" href="' . base_url("export_excel/C_export_excel_monitor_tenaker_new/exportxls/") . $field->HeaderID . '" class="btn btn-minier btn-round btn-success">
                                    <i class="ace-icon fa fa-file-excel-o bigger-100"></i> Export Excel
                                </a>';
                // }
            } else {
                $berkas = '';
            }
            if ($field->WawancaraHasil != NULL) {
                $berkas .= ' <button title="Export target="_blank" data-rel="tooltip"  class="btn btn-minier btn-round btn-danger hasil-interview">
                                        <i class="ace-icon fa fa-files-o bigger-100"></i> Hasil Interview
                                    </button>';
                # code...
            }
            // if ($this->session->userdata('userid') == 'KIKI' || $this->session->userdata('userid') == 'kiki') {
            $berkas .= ' <a title="Export Excel" target="_blank" data-rel="tooltip" href="' . base_url("export_excel/C_export_excel_aplikasi_kerja/exportxls/") . $field->HeaderID . '" class="btn btn-minier btn-round btn-success">
                                    <i class="ace-icon fa fa-file-excel-o bigger-100"></i> Aplikasi Kerja
                                </a>';
            // }

            if ($this->session->userdata('groupuser') == '93') {
                if (!isset($cek_black_list)) {
                    $readonly = 'readonly';
                } else {
                    $readonly = '';
                }

                if (isset($field->Keterangan)) {
                    $keterangan = '<textarea name="keterangan" id="keterangan" class="keterangan" value="' . $field->Keterangan . '" ' . $readonly . '><' . $field->Keterangan . '></textarea><br>';
                } else {
                    $keterangan = '<textarea name="keterangan" id="keterangan" class="keterangan" ' . $readonly . '></textarea><br>';
                }
                $keterangan .= '<button type="submit" name="simpan" id="simpan" class="simpan btn btn-primary btn-round btn-minier">Simpan</button>';
            } else {
                $keterangan = '';
            }

            // if ($field->Nofix != NULL || $field->Nofix != '') {
            // } else {
            //     $riwayat_kerja = '';
            // }
            $riwayat_kerja = '<button title="Riwayat Kerja" data-rel="tooltip" href="javascript:;" class="riwayat_kerja btn btn-minier btn-round btn-primary" data-nofix="' . $field->Nofix . '" data-ktp="' . ($_POST['selDataFilter'] == '3' ? $field->No_Ktp : $field->No_ktp)  . '">
                                    <i class="ace-icon fa fa-files-o bigger-100"></i> Riwayat Kerja
                                </button>';


            if ($field->sCarrierStatus == 1) {
                $salmonellaCarrier = '<button title="" data-rel="tooltip" href="javascript:;" class=" btn btn-minier btn-round btn-warning" >
                                    <i class="ace-icon fa fa-files-o bigger-100"></i> Salmonella Carrier
                                </button>';
            } else {
                $salmonellaCarrier = '';
            }

            $detail = ' <a title="View Detail" data-rel="tooltip" href="javascript:;" class="detailInfo btn btn-minier btn-round btn-primary">
                                <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                            </a> ';



            $no++;
            $row   = array();
            $row[] = $field->HeaderID  . '<input class="info data-id" id="data-id" value="' . $field->HeaderID . '" type="hidden" data-id="' . $field->HeaderID . '">';
            // $row[] = $field->HeaderID;
            $row[] = $field->Nama;
            $row[] = $field->Pemborong;
            $row[] = $field->SubPemborong;
            $row[] = date('d-m-Y', strtotime($field->Tgl_Lahir));
            // $row[] = $field->Tgl_Lahir;
            $row[] = ucwords(strtolower($field->Jenis_Kelamin));
            $row[] = $_POST['selDataFilter'] == '3' ? ucwords(strtolower($field->No_Ktp)) : ucwords(strtolower($field->No_ktp));
            $row[] = $screened;
            $row[] = '<div class="text-left">' . strtoupper($field->RegisteredBy) . '</div> <div class="text-right smaller-80">' . $field->RegisteredDate . '</div> ';
            $row[] = $wawancara;
            if ($this->session->userdata('dept') == 'ITD' || $this->session->userdata('dept') == 'HRD') {

                $row[] = $salmonellaCarrier;
            }
            $row[] = $riwayat_kerja;
            if ($this->session->userdata('userid') != 'PTADM') {

                $row[] = $berkas;
            }
            if ($this->session->userdata('dept') == 'ITD' || $this->session->userdata('dept') == 'HRD') {

                $row[] = $keterangan;
            }
            if ($this->session->userdata('userid') == 'PTADM' || $this->session->userdata('dept') == 'ITD') {

                $row[] = $detail;
            }

            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->m_monitor->count_all_tenaker_new(),
            "recordsFiltered" => $this->m_monitor->count_filtered_tenaker_new(),
            "data"            => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
        // }
    }

    public function show_list_for_pbr()
    {

        if ($this->input->is_ajax_request()) {
            $idpemborong = $this->session->userdata('idpemborong');
            // $idpemborong = 13;
            $list = $this->m_monitor->get_datatables_list_for_pbr('vwListTenakerForPemborong');

            $data = array();
            $no   = $_POST['start'];
            foreach ($list as $field) {

                if ($field->Jenis_Kelamin == 'M' || $field->Jenis_Kelamin == 'LAKI-LAKI') {
                    $gender = 'Laki-laki';
                } elseif ($field->Jenis_Kelamin == 'F' || $field->Jenis_Kelamin == 'PEREMPUAN') {
                    $gender = 'Perempuan';
                } else {
                    $gender = '';
                }

                $wawancara = '';
                if ($field->WawancaraKe == NULL) {
                    $wawancara .= 'Belum Pernah';
                } else {
                    if ($idpemborong > 0) {
                        $wawancara .= $field->WawancaraKe . ' kali';
                    } else {
                        $wawancara .= '<a title="View Detail" data-rel="tooltip" href="#" class="detailInterview btn btn-minier btn-white btn-block">
                                            <i class="ace-icon fa fa-files-o bigger-100"></i>' . $field->WawancaraKe . ' kali
                                      </a>';
                    }
                }

                $isMcu = '';
                if ($field->apvdokterby == NULL) {
                    $isMcu .= '<span class="label label-default">✘</span>';
                } else {
                    $isMcu .= '<span class="label label-success">✔</span>';
                }

                $idCard = '';
                if ($field->UdahDiAmbil == 1 && $field->Nofix != null) {
                    $idCard .= '<span class="label label-success">✔</span>';
                } else {
                    $idCard .= '<span class="label label-default">✘</span>';
                }

                $keterangan = '';
                if ($field->WawancaraKe != NULL && $field->apvdokterby != NULL && $field->UdahDiAmbil == 1 && $field->Nofix != null) {
                    $keterangan .= '<span class="label label-success">Complete</span>';
                } else {
                    if ($idpemborong > 0 && ($field->KeteranganKirim == 'blacklist' || $field->KeteranganKirim == 'blacklist_2_bln')) {
                        $keterangan .= "Tidak Lulus Screening";
                    } else {
                        $keterangan .= strtoupper($field->KeteranganKirim);
                    }
                }

                $registeredBy = '<div class="text-left">' . $field->RegisteredBy . '</div>
                                 <div class="text-right smaller-90">' . $field->RegisteredDate . '</div>';

                $detail = ' <a title="show detail" href="#" class="detail">
                                <button class="btn btn-minier btn-primary">
                                    <i class="ace-icon fa fa-list-alt bigger-100"></i>Detail
                                </button>
                            </a>';

                $kesimpulanCu = '';
                $printPDF = '';
                if (strpos($field->kesimpulanCU, "Tidak Sehat permanen") !== false || strpos($field->kesimpulanCU, "Tidak Sehat Permanen") !== false) {
                    $kesimpulanCu =   str_replace("Tidak Sehat permanen", '<span class="badge badge-danger">Tidak Sehat Permanen</span>', $field->kesimpulanCU);
                    $key = 'your-secret-key'; // Kunci enkripsi, simpan di tempat yang aman
                    $encryptedHeaderID = encrypt($field->HeaderID, $key);

                    $printPDF = '<a disabled title="Export PDF" target="_blank" data-rel="tooltip" href="' . base_url("export_pdf/C_export_topdf/exporttopdf/") . $encryptedHeaderID . '" class="btn btn-minier btn-round btn-danger">
                                    <i class="ace-icon fa fa-file-o bigger-100"></i> Export PDF
                                </a>';
                } elseif (strpos($field->kesimpulanCU, "Tidak Sehat") !== false) {
                    $kesimpulanCu =   str_replace("Tidak Sehat", '<span class="badge badge-danger">Tidak Sehat</span>', $field->kesimpulanCU);
                    $key = 'your-secret-key'; // Kunci enkripsi, simpan di tempat yang aman
                    $encryptedHeaderID = encrypt($field->HeaderID, $key);

                    $printPDF = '<a  title="Export PDF" target="_blank" data-rel="tooltip" href="' . base_url("export_pdf/C_export_topdf/exporttopdf/") . $encryptedHeaderID . '" class="btn btn-minier btn-round btn-danger">
                                    <i class="ace-icon fa fa-file-o bigger-100"></i> Export PDF
                                </a>';
                } else {
                    // $kesimpulanCu =  str_replace("Sehat", '<span class="badge badge-success">Sehat</span>', $field->kesimpulanCU);
                    $kesimpulanCu =  $field->kesimpulanCU;
                }
                $mcudate = $field->mcu_date != NULL ? date('d-m-Y', strtotime($field->mcu_date)) : '';


                if ($idpemborong == 0 &&  $mcudate != '') {
                    $mcudate .= '<br><br><button class="btn btn-sm btn-round btn-success reschedule"><i class="fa fa-undo"></i>  Reschedule Jadwal Interview</button>';
                }



                $no++;
                $row   = array();

                $row[] = $field->ID . '<input type="hidden" id="headerID" value="' . $field->ID . '"/>';
                $row[] = $field->Nama;
                $row[] = $field->Pemborong;
                $row[] = $field->SubPemborong;
                $row[] = date('d-m-Y', strtotime($field->Tgl_Lahir));
                $row[] = $gender;
                $row[] = $field->JadwalInterview == NULL ? '' : date('d-M-Y',  strtotime($field->JadwalInterview));
                $row[] = $mcudate;
                $row[] = $kesimpulanCu;
                $row[] = $printPDF;
                $row[] = $wawancara;
                $row[] = $isMcu;
                $row[] = $idCard;
                $row[] = (str_replace("_", " ", $keterangan));
                $row[] = $registeredBy;
                $row[] = $detail;


                $data[] = $row;
            }

            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // die;


            $output = array(
                "draw"            => $_POST['draw'],
                "recordsTotal"    => $this->m_monitor->count_all_list_for_pbr('vwListTenakerForPemborong'),
                "recordsFiltered" => $this->m_monitor->count_filtered_list_for_pbr('vwListTenakerForPemborong'),
                "data"            => $data,
            );
            //output dalam format JSON

            echo json_encode($output);
        }
    }


    public function show_calon_tenaker()
    {

        if ($this->input->is_ajax_request()) {
            $idpemborong = $this->session->userdata('idpemborong');
            // $idpemborong = 13;
            $list = $this->m_monitor->get_datatables_calon_tenaker('vwlistberkas_');
            $data = array();
            $no   = $_POST['start'];
            foreach ($list as $field) {

                $checkBox = '<div class="checkbox">
                        <label class="pos-rel">
                            <input name="chkPosting[]" id="chkPosting" class="chkPosting" type="checkbox" value="' . $field->HeaderID . '">
                            <span class="lbl"></span>
                        </label>
                    </div>';

                if ($field->Jenis_Kelamin == 'M' || $field->Jenis_Kelamin == 'LAKI-LAKI') {
                    $gender = 'Laki-laki';
                } elseif ($field->Jenis_Kelamin == 'F' || $field->Jenis_Kelamin == 'PEREMPUAN') {
                    $gender = 'Perempuan';
                } else {
                    $gender = '';
                }

                $wawancara = '';
                if ($field->WawancaraKe == NULL) {
                    $wawancara .= 'Belum Pernah';
                } else {
                    if ($idpemborong > 0) {
                        $wawancara .= $field->WawancaraKe . ' kali';
                    } else {
                        $wawancara .= '<a title="View Detail" data-rel="tooltip" href="#" class="detailInterview btn btn-minier btn-white btn-block">
                                            <i class="ace-icon fa fa-files-o bigger-100"></i>' . $field->WawancaraKe . ' kali
                                      </a>';
                    }
                }

                $berkas = '';

                $berkas = '<div class="btn-group">
                  <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle">
                      Berkas
                      <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                  </button>
                  <ul class="dropdown-menu dropdown-default">';
                if ($field->KTP != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="KTP" data-tk="' . ucwords(strtolower($field->Nama)) . '">KTP</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>KTP is NULL</i></small></a></li>';
                }
                if ($field->KK != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="KK" data-tk="' . ucwords(strtolower($field->Nama)) . '">KK</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>KK is NULL</i></small></a></li>';
                }
                if ($field->SKCK != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="SKCK" data-tk="' . ucwords(strtolower($field->Nama)) . '">SKCK</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>SKCK is NULL</i></small></a></li>';
                }
                if ($field->Lamaran != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Lamaran" data-tk="' . ucwords(strtolower($field->Nama)) . '">Lamaran</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Lamaran is NULL</i></small></a></li>';
                }
                if ($field->CV != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="CV" data-tk="' . ucwords(strtolower($field->Nama)) . '">CV</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>CV is NULL</i></small></a></li>';
                }
                if ($field->Ijazah != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Ijazah" data-tk="' . ucwords(strtolower($field->Nama)) . '">Ijazah</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Ijazah is NULL</i></small></a></li>';
                }
                if ($field->Transkrip != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Transkrip" data-tk="' . ucwords(strtolower($field->Nama)) . '">Transkip</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Transkrip is NULL</i></small></a></li>';
                }
                if ($field->Vaksin1 != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin1" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 1</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Vaksin1 is NULL</i></small></a></li>';
                }
                if ($field->Vaksin2 != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin2" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 2</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Vaksin2 is NULL</i></small></a></li>';
                }

                if ($field->Vaksin3 != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin3" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 3</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Vaksin3 is NULL</i></small></a></li>';
                }
                $berkas .= '</ul>
                    </div>
                    <a title="View Detail" data-rel="tooltip" href="javascript:;" class="detailInfo btn btn-minier btn-round btn-primary">
                        <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                    </a>';



                $registeredBy = '<div class="text-left">' . $field->RegisteredBy . '</div>
                                 <div class="text-right smaller-90">' . $field->RegisteredDate . '</div>';

                $kualifikasi = '';
                if (isset($field->Kualifikasi)) {
                    $kualifikasi .=  '<textarea name="kualifikasi" id="kualifikasi" class="kualifikasi" value="' . $field->Kualifikasi . '">' . $field->Kualifikasi . '</textarea><br>';
                } else {
                    $kualifikasi .=  '<textarea name="kualifikasi" id="kualifikasi" class="kualifikasi"></textarea><br>';
                }

                $kualifikasi .= '<button type="button" name="simpan" id="simpan" class="simpan btn btn-primary btn-round btn-minier">Simpan</button>';


                $opsi_cancel = '<select class="form-control cancel" name="cancel" id="cancel">';
                $opsi_cancel .= '<option>-Pilih-</option>';
                $opsi_cancel .= '<option value="1" ' . ($field->cancel_status == 1 ? 'selected' : '') . '>Cancel Sendiri</option>';
                $opsi_cancel .= '<option value="2" ' . ($field->cancel_status == 2 ? 'selected' : '') . '>Cancel dari Dept</option>';
                $opsi_cancel .= '</select>';





                $no++;
                $row   = array();

                $row[] = $checkBox;
                $row[] = $field->HeaderID . '<input type="hidden" id="headerID" value="' . $field->HeaderID . '"/><input type="hidden" class="pemborong" id="pemborong" value="' . $field->Pemborong . '"/>';
                $row[] = $field->Nama;
                $row[] = $field->Pemborong;
                $row[] = $field->SubPemborong;
                $row[] = date('d-m-Y', strtotime($field->Tgl_Lahir));
                $row[] = $gender;
                $row[] = $wawancara;
                $row[] = $registeredBy;
                $row[] = $field->DikirimDate == NULL ? '' : date('d-m-Y',  strtotime($field->DikirimDate));
                $row[] = $field->JadwalInterview == NULL ? '' : date('d-m-Y',  strtotime($field->JadwalInterview));

                $row[] = $berkas;
                $row[] = $opsi_cancel;
                $row[] = $kualifikasi;


                $data[] = $row;
            }

            $output = array(
                "draw"            => $_POST['draw'],
                "recordsTotal"    => $this->m_monitor->count_all_calon_tenaker('vwlistberkas'),
                "recordsFiltered" => $this->m_monitor->count_filtered_calon_tenaker('vwlistberkas'),
                "data"            => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        }
    }

    public function show_unscreening_by_hrd()
    {

        if ($this->input->is_ajax_request()) {
            $idpemborong = $this->session->userdata('idpemborong');
            // $idpemborong = 13;
            $list = $this->m_monitor->get_datatables_unscreening_by_hrd('vwlistberkas');
            $data = array();
            $no   = $_POST['start'];
            foreach ($list as $field) {

                $checkBox = '<div class="checkbox">
                        <label class="pos-rel">
                            <input name="chkPosting[]" id="chkPosting" class="chkPosting" type="checkbox" value="' . $field->HeaderID . '">
                            <span class="lbl"></span>
                        </label>
                    </div>';

                if ($field->Jenis_Kelamin == 'M' || $field->Jenis_Kelamin == 'LAKI-LAKI') {
                    $gender = 'Laki-laki';
                } elseif ($field->Jenis_Kelamin == 'F' || $field->Jenis_Kelamin == 'PEREMPUAN') {
                    $gender = 'Perempuan';
                } else {
                    $gender = '';
                }

                $wawancara = '';
                if ($field->WawancaraKe == NULL) {
                    $wawancara .= 'Belum Pernah';
                } else {
                    if ($idpemborong > 0) {
                        $wawancara .= $field->WawancaraKe . ' kali';
                    } else {
                        $wawancara .= '<a title="View Detail" data-rel="tooltip" href="#" class="detailInterview btn btn-minier btn-white btn-block">
                                            <i class="ace-icon fa fa-files-o bigger-100"></i>' . $field->WawancaraKe . ' kali
                                      </a>';
                    }
                }

                $berkas = '<div class="btn-group">
                  <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle">
                      Berkas
                      <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                  </button>
                  <ul class="dropdown-menu dropdown-default">';
                if ($field->KTP != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="KTP" data-tk="' . ucwords(strtolower($field->Nama)) . '">KTP</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>KTP is NULL</i></small></a></li>';
                }
                if ($field->KK != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="KK" data-tk="' . ucwords(strtolower($field->Nama)) . '">KK</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>KK is NULL</i></small></a></li>';
                }
                if ($field->SKCK != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="SKCK" data-tk="' . ucwords(strtolower($field->Nama)) . '">SKCK</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>SKCK is NULL</i></small></a></li>';
                }
                if ($field->Lamaran != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Lamaran" data-tk="' . ucwords(strtolower($field->Nama)) . '">Lamaran</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Lamaran is NULL</i></small></a></li>';
                }
                if ($field->CV != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="CV" data-tk="' . ucwords(strtolower($field->Nama)) . '">CV</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>CV is NULL</i></small></a></li>';
                }
                if ($field->Ijazah != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Ijazah" data-tk="' . ucwords(strtolower($field->Nama)) . '">Ijazah</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Ijazah is NULL</i></small></a></li>';
                }
                if ($field->Transkrip != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Transkrip" data-tk="' . ucwords(strtolower($field->Nama)) . '">Transkip</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Transkrip is NULL</i></small></a></li>';
                }
                if ($field->Vaksin1 != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin1" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 1</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Vaksin1 is NULL</i></small></a></li>';
                }
                if ($field->Vaksin2 != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin2" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 2</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Vaksin2 is NULL</i></small></a></li>';
                }

                if ($field->Vaksin3 != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin3" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 3</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Vaksin3 is NULL</i></small></a></li>';
                }
                $berkas .= '</ul>
                    </div>
                    <a title="View Detail" data-rel="tooltip" href="javascript:;" class="detailInfo btn btn-minier btn-round btn-primary">
                        <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                    </a>';



                $registeredBy = '<div class="text-left">' . $field->RegisteredBy . '</div>
                                 <div class="text-right smaller-90">' . $field->RegisteredDate . '</div>';

                $kualifikasi = '';
                if (isset($field->Kualifikasi)) {
                    $kualifikasi .=  '<textarea name="kualifikasi" id="kualifikasi" class="kualifikasi" value="' . $field->Kualifikasi . '">' . $field->Kualifikasi . '</textarea><br>';
                } else {
                    $kualifikasi .=  '<textarea name="kualifikasi" id="kualifikasi" class="kualifikasi"></textarea><br>';
                }

                $kualifikasi .= '<button type="button" name="simpan" id="simpan" class="simpan btn btn-primary btn-round btn-minier">Simpan</button>';


                $opsi_cancel = '<select class="form-control cancel" name="cancel" id="cancel">';
                $opsi_cancel .= '<option>-Pilih-</option>';
                $opsi_cancel .= '<option value="1" ' . ($field->cancel_status == 1 ? 'selected' : '') . '>Cancel Sendiri</option>';
                $opsi_cancel .= '<option value="2" ' . ($field->cancel_status == 2 ? 'selected' : '') . '>Cancel dari Dept</option>';
                $opsi_cancel .= '</select>';





                $no++;
                $row   = array();

                // $row[] = $checkBox;
                $row[] = $field->HeaderID . '<input type="hidden" class="headerID" id="headerID" value="' . $field->HeaderID . '"/><input type="hidden" class="pemborong" id="pemborong" value="' . $field->Pemborong . '"/>';
                $row[] = $field->DeptTujuan;
                $row[] = $field->Nama;
                $row[] = $field->Pemborong;
                $row[] = $field->SubPemborong;
                $row[] = date('d-m-Y', strtotime($field->Tgl_Lahir));
                $row[] = $gender;
                $row[] = $wawancara;
                $row[] = $registeredBy;
                $row[] = $field->DikirimDate == NULL ? '' : date('d-m-Y',  strtotime($field->DikirimDate));
                $row[] = $field->JadwalInterview == NULL ? '' : date('d-m-Y',  strtotime($field->JadwalInterview));

                $row[] = $berkas;
                // $row[] = $opsi_cancel;
                // $row[] = $kualifikasi;


                $data[] = $row;
            }

            $output = array(
                "draw"            => $_POST['draw'],
                "recordsTotal"    => $this->m_monitor->count_all_unscreening_by_hrd('vwlistberkas'),
                "recordsFiltered" => $this->m_monitor->count_filtered_unscreening_by_hrd('vwlistberkas'),
                "data"            => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        }
    }

    function sendToMCU()
    {
        $id = $this->input->post('id');
        $this->m_monitor->sendToMCU($id);
        echo json_encode($id);
    }

    function hasilInterview()
    {
        // die;
        if ('IS_AJAX') {
            $kode = $this->input->post('kode');
            $cekPendidikan = $this->m_wawancara->getDetailTK($kode)->result();
            foreach ($cekPendidikan as $p) {
                $pemborong = $p->Pemborong;
                $pendidikan = $p->Pendidikan;
            }


            if (trim($pemborong) == 'PT PULAU SAMBU') {
                $data['datatk']          = $this->m_wawancara->getDetailTK($kode)->result();
                $data['datatenaker']     = $this->m_wawancara->getDetailTenaker($kode)->result();
                // $data['_getKualifikasi'] = $this->m_monitor->getKualifikasiKaryawan();
                // $data['_getKualifiSmu']  = $this->m_wawancara->getKualifikasiSMU();
                $nilai_karyawan = $this->m_monitor->getNilaiKaryawan($kode);
                // Mendapatkan data kualifikasi karyawan
                $kualifikasi = $this->m_monitor->getKualifikasiKaryawan();
                // Mendapatkan nilai karyawan berdasarkan ID
                $nilai = $this->m_monitor->getNilaiKaryawan($kode);
                // Membuat array nilai yang terstruktur berdasarkan Item
                $nilaiArr = [];
                foreach ($nilai as $n) {
                    $nilaiArr[$n->Item] = $n->Nilai;
                    $TotalNilai[$n->Item] = $n->TotalNilai;
                    $RataNilai[$n->Item] = $n->RataNilai;
                    $Grade[$n->Item] = $n->Grade;
                    $Catatan[$n->Item] = $n->Catatan;
                }



                // Menggabungkan kualifikasi dengan nilai
                $combinedData = [];
                foreach ($kualifikasi as $key => $k) {
                    $k->TotalNilai = isset($TotalNilai[1]) ? $TotalNilai[1] : null;
                    $k->RataNilai = isset($RataNilai[1]) ? $RataNilai[1] : null;
                    $k->Grade = isset($Grade[1]) ? $Grade[1] : null;
                    $k->Catatan = isset($Catatan[1]) ? $Catatan[1] : null;

                    switch ($k->Item) {
                        case 2:
                            $k->Nilai = isset($nilaiArr[1]) ? $nilaiArr[1] : null; // Item 2 kualifikasi adalah Item 1 dinilai
                            break;
                        case 3:
                            $k->Nilai = isset($nilaiArr[2]) ? $nilaiArr[2] : null; // Item 3 kualifikasi adalah Item 2 dinilai
                            break;
                        case 5:
                            $k->Nilai = isset($nilaiArr[3]) ? $nilaiArr[3] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                            break;
                        case 6:
                            $k->Nilai = isset($nilaiArr[4]) ? $nilaiArr[4] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                            break;
                        case 7:
                            $k->Nilai = isset($nilaiArr[5]) ? $nilaiArr[5] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                            break;
                        case 9:
                            $k->Nilai = isset($nilaiArr[6]) ? $nilaiArr[6] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                            break;
                        case 10:
                            $k->Nilai = isset($nilaiArr[7]) ? $nilaiArr[7] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                            break;
                        case 11:
                            $k->Nilai = isset($nilaiArr[8]) ? $nilaiArr[8] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                            break;
                        case 13:
                            $k->Nilai = isset($nilaiArr[9]) ? $nilaiArr[9] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                            break;
                        case 14:
                            $k->Nilai = isset($nilaiArr[10]) ? $nilaiArr[10] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                            break;
                        case 16:
                            $k->Nilai = isset($nilaiArr[11]) ? $nilaiArr[11] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                            break;
                        case 17:
                            $k->Nilai = isset($nilaiArr[12]) ? $nilaiArr[12] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                            break;
                        default:
                            $k->Nilai = NULL;
                            break;
                    }
                    // } else {
                    //     $k->Nilai = null;
                    // }
                    $combinedData[] = $k;
                }
                // print_r($combinedData);
                // die;

                // Mengirim data ke view
                $data['_getKualifikasi'] = $combinedData;
            } else {
                $data['datatk']             = $this->m_wawancara->getDetailTK($kode)->result();
                $data['datatenaker']        = $this->m_wawancara->getDetailTenaker($kode)->result();
                $data['_getMP']             = $this->m_wawancara->cekMP($kode);
                $data['_getKualifikasi']    = $this->m_monitor->getKualifikasiDasar($kode);
                $data['_getPekerjaan']      = $this->m_wawancara->getPekerjaanGO();
                $data['_getHarian']         = $this->m_wawancara->getPekerjaanHarian();
                $data['_getSubPekerjaan']   = $this->m_wawancara->getSubPekerjaan();
                $data['_getLiburMingguan']  = $this->m_wawancara->getLiburMingguan();
            }
            $data['hdrid'] = $kode;

            // print_r($data['_getKualifikasi']);
            // die;

            if ($pemborong == 'PT PULAU SAMBU') {
                if ($pendidikan == 'D3' || $pendidikan == 'S1' || $pendidikan == 'S2' || $pendidikan == 'S3') {
                    $this->load->view('monitor/listtenaker/wawancaraKaryawan', $data);
                } else {
                    $this->load->view('monitor/listtenaker/wawancaraKaryawan', $data);
                }
            } else {
                $this->load->view('monitor/listtenaker/wawancaraHarian', $data);
            }

            // if ((trim($pemborong) == 'PT PULAU SAMBU') && ($pendidikan == 'D3' || $pendidikan == 'S1' || $pendidikan == 'S2' || $pendidikan == 'S3')) {
            // } elseif ((trim($pemborong) == 'PT PULAU SAMBU')) {
            // } else {
            // }
        }
    }

    function print_hasil_interview_karyawan($headerID)
    {
        $data['datatk']         = $this->m_wawancara->getDetailTK($headerID)->result();
        foreach ($data['datatk']  as $p) {
            $pemborong = $p->Pemborong;
            $pendidikan = $p->Pendidikan;
        }
        if (trim($pemborong) == 'PT PULAU SAMBU') {

            $data['datatk']          = $this->m_wawancara->getDetailTK($headerID)->result();
            $data['datatenaker']     = $this->m_wawancara->getDetailTenaker($headerID)->result();
            // $data['_getKualifikasi'] = $this->m_monitor->getKualifikasiKaryawan();
            // $data['_getKualifiSmu']  = $this->m_wawancara->getKualifikasiSMU();
            $nilai_karyawan = $this->m_monitor->getNilaiKaryawan($headerID);
            // Mendapatkan data kualifikasi karyawan
            $kualifikasi = $this->m_monitor->getKualifikasiKaryawan();
            // Mendapatkan nilai karyawan berdasarkan ID
            $nilai = $this->m_monitor->getNilaiKaryawan($headerID);
            // Membuat array nilai yang terstruktur berdasarkan Item
            $nilaiArr = [];
            foreach ($nilai as $n) {
                $nilaiArr[$n->Item] = $n->Nilai;
                $TotalNilai[$n->Item] = $n->TotalNilai;
                $RataNilai[$n->Item] = $n->RataNilai;
                $Grade[$n->Item] = $n->Grade;
                $Catatan[$n->Item] = $n->Catatan;
            }



            // Menggabungkan kualifikasi dengan nilai
            $combinedData = [];
            foreach ($kualifikasi as $key => $k) {
                $k->TotalNilai = isset($TotalNilai[1]) ? $TotalNilai[1] : null;
                $k->RataNilai = isset($RataNilai[1]) ? $RataNilai[1] : null;
                $k->Grade = isset($Grade[1]) ? $Grade[1] : null;
                $k->Catatan = isset($Catatan[1]) ? $Catatan[1] : null;

                switch ($k->Item) {
                    case 2:
                        $k->Nilai = isset($nilaiArr[1]) ? $nilaiArr[1] : null; // Item 2 kualifikasi adalah Item 1 dinilai
                        break;
                    case 3:
                        $k->Nilai = isset($nilaiArr[2]) ? $nilaiArr[2] : null; // Item 3 kualifikasi adalah Item 2 dinilai
                        break;
                    case 5:
                        $k->Nilai = isset($nilaiArr[3]) ? $nilaiArr[3] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                        break;
                    case 6:
                        $k->Nilai = isset($nilaiArr[4]) ? $nilaiArr[4] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                        break;
                    case 7:
                        $k->Nilai = isset($nilaiArr[5]) ? $nilaiArr[5] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                        break;
                    case 9:
                        $k->Nilai = isset($nilaiArr[6]) ? $nilaiArr[6] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                        break;
                    case 10:
                        $k->Nilai = isset($nilaiArr[7]) ? $nilaiArr[7] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                        break;
                    case 11:
                        $k->Nilai = isset($nilaiArr[8]) ? $nilaiArr[8] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                        break;
                    case 13:
                        $k->Nilai = isset($nilaiArr[9]) ? $nilaiArr[9] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                        break;
                    case 14:
                        $k->Nilai = isset($nilaiArr[10]) ? $nilaiArr[10] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                        break;
                    case 16:
                        $k->Nilai = isset($nilaiArr[11]) ? $nilaiArr[11] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                        break;
                    case 17:
                        $k->Nilai = isset($nilaiArr[12]) ? $nilaiArr[12] : null; // Item 5 kualifikasi adalah Item 3 dinilai
                        break;
                    default:
                        $k->Nilai = NULL;
                        break;
                }
                // } else {
                //     $k->Nilai = null;
                // }
                $combinedData[] = $k;
            }
            // print_r($combinedData);
            // die;

            // Mengirim data ke view
            $data['_getKualifikasi'] = $combinedData;
        } else {
            $data['datatenaker']        = $this->m_wawancara->getDetailTenaker($headerID)->result();
            $data['_getKualifikasi']    = $this->m_monitor->getKualifikasiDasar($headerID);
        }
        $data['hdrid'] = $headerID;

        if (trim($pemborong) == 'PT PULAU SAMBU') {
            $this->load->view('monitor/listtenaker/printdata/printDataTenakerkaryawan', $data);
        } else {
            $this->load->view('monitor/listtenaker/printdata/printDataTenaker', $data);
        }
    }

    function riwayat_kerja()
    {
        $nofix = $this->input->post('nofix');
        $ktp = $this->input->post('ktp');

        $data['riwayat_kerja'] = $this->m_monitor->riwayat_kerja($ktp, $nofix);
        if (!$data['riwayat_kerja']) {
            return;
        }
        $this->load->view('monitor/listtenaker/riwayat_kerja', $data);

        // echo json_encode($data);
    }

    function unscreeningbyhrd()
    {
        $this->template->display('monitor/unscreeningbyhrd/index');
    }

    // Perubahan MPP
    function perubahanmpp()
    {
        $cssadd = array(
            'sweetalert.css',
            'bootstrap-select.min.css',
            'addcss/buttons.bootstrap.min.css',
            'addcss/fixdb.css'
        );

        $data['cssadd'] = $cssadd;
        $data['getDivisi'] = $this->M_perubahanmpp->getDivisi();
        $data['getDept'] = $this->M_perubahanmpp->getDept();

        $this->template->display('monitor/perubahan_mpp/index', $data);
    }
    public function show_perubahan_mpp()
    {
        if ($this->input->is_ajax_request()) {
            $list = $this->M_perubahanmpp->get_datatables();
            $data = array();
            $no = $_POST['start'];

            foreach ($list as $field) {
                $no++;

                $statusBadge = '';
                switch ($field->Status) {
                    case 0:
                        $statusBadge = '<span class="label label-default">Draft</span>';
                        break;
                    case 1:
                        $statusBadge = '<span class="label label-success">Submitted</span>';
                        break;
                    case 2:
                        $statusBadge = '<span class="label label-success">Approved by Dept</span>';
                        break;
                    case 3:
                        $statusBadge = '<span class="label label-success">Approved by Divisi</span>';
                        break;
                    case 4:
                        $statusBadge = '<span class="label label-success">Approved by HRD</span>';
                        break;
                    case 5:
                        $statusBadge = '<span class="label label-danger">Rejected</span>';
                        break;
                    case 6:
                        $statusBadge = '<span class="label label-warning">Pending</span>';
                        break;
                }

                if ($this->input->post('filter_status') == '6') {
                    $statusBadge = '<span class="label label-warning">Pending</span>';
                }

                $tipeLabel = '';
                switch ($field->TipePerubahan) {
                    case 1:
                        $tipeLabel = 'Jabatan Baru';
                        break;
                    case 2:
                        $tipeLabel = 'Jabatan Lama';
                        break;
                    case 3:
                        $tipeLabel = 'Baru & Lama';
                        break;
                }

                $badgeApp1 = 'test';
                if ($field->AppStatus == '' || $field->AppStatus == null) {
                    $badgeApp1 = '<span class="label label-warning">Pending</span>';
                } elseif ($field->AppStatus == 1) {
                    $badgeApp1 = '<span class="label label-success">Approved</span>';
                } elseif ($field->AppStatus == 2) {
                    $badgeApp1 = '<span class="label label-danger">Disapprove</span>';
                }

                $badgeApp2 = '';
                if ($field->AppStatus2 == '' || $field->AppStatus2 == null) {
                    $badgeApp2 = '<span class="label label-warning">Pending</span>';
                } elseif ($field->AppStatus2 == 1) {
                    $badgeApp2 = '<span class="label label-success">Approved</span>';
                } elseif ($field->AppStatus2 == 2) {
                    $badgeApp2 = '<span class="label label-danger">Disapprove</span>';
                }

                $badgeApp3 = '';
                if ($field->AppStatus3 == '' || $field->AppStatus3 == null) {
                    $badgeApp3 = '<span class="label label-warning">Pending</span>';
                } elseif ($field->AppStatus3 == 1) {
                    $badgeApp3 = '<span class="label label-success">Approved</span>';
                } elseif ($field->AppStatus3 == 2) {
                    $badgeApp3 = '<span class="label label-danger">Disapprove</span>';
                }

                $opsi = '<div class="btn-group">';
                $opsi .= '<a href="' . base_url('perubahanmpp/detail/' . encode_str($field->ID)) . '" class="btn btn-info btn-xs" title="Detail"><i class="fa fa-eye"></i></a>';
                if ($field->Status == 0) {
                    $opsi .= '<a href="' . base_url('perubahanmpp/edit/' . encode_str($field->ID)) . '" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-edit"></i></a>';
                    $opsi .= '<button type="button" onclick="deleteData(\'' . encode_str($field->ID) . '\')" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i></button>';
                }
                $opsi .= '</div>';

                $row = array();
                $row[] = $no;
                // $row[] = $opsi;
                $row[] = $field->NoPengajuan;
                $row[] = $field->Divisi;
                $row[] = $field->Departemen;
                $row[] = $field->Jabatan;
                $row[] = $tipeLabel;
                $row[] = $field->SifatPerubahan;
                $row[] = $statusBadge;
                $row[] = $badgeApp1;
                $row[] = $badgeApp2;
                $row[] = $badgeApp3;
                $row[] = date('d-m-Y', strtotime($field->CreatedDate));
                $row[] = $field->CreatedBy;

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->M_perubahanmpp->count_all(),
                "recordsFiltered" => $this->M_perubahanmpp->count_filtered(),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }
}

/* End of file monitor.php */
/* Location: ./application/controllers/monitor.php */