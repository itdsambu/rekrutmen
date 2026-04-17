<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Memodept extends CI_Controller
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

        $this->load->model('M_memodept');
    }

    function index()
    {
        $data['_getFormID']  = $this->input->get('id');
        $data['getData']     = $this->M_memodept->get_memo();
        $this->template->display('monitor/memo_dept/index', $data);
    }

    function ajaxMonitorMemo()
    {
        $bulan = $this->uri->segment('4');
        $tahun = $this->uri->segment('3');
        $type  = $this->uri->segment('5');

        if ($type != 0) {
            $data['getData'] = $this->M_memodept->get_datamonitor($bulan, $tahun, $type);
        } else {
            $data['getData'] = $this->M_memodept->get_datamonitorpendding($bulan, $tahun);
        }
        $this->load->view('monitor/memo_dept/ajaxMemo', $data);
    }

    function viewMemo()
    {
        $id = $this->uri->segment(3);
        $data['getData'] = $this->M_memodept->get_datamemo($id);
        $this->template->display('monitor/memo_dept/memo', $data);
    }

     function mon_viewMemo()
    {
        $id = $this->uri->segment(3);
        $data['getData'] = $this->M_memodept->get_datamemo($id);
        $this->template->display('monitor/memo_dept/mon_memo', $data);
    }

    function printMemo()
    {
        ob_start();
        $this->load->view("monitor/memo_dept/printmemo");
        $html   = ob_get_contents();
        ob_end_clean();

        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P', 'A4', 'en');
        $pdf->writeHTML($html);
        $pdf->Output('');
    }

    /* Approval Departemen */
    function dept()
    {
        $data['_getFormID']         = $this->input->get('id');
        $data['getData'] = $this->M_memodept->get_dataApprovedept();
        $this->template->display('Approval/memo_permintaanideal/departemen/index', $data);
    }

    function approveDept()
    {
        $id = $this->uri->segment(3);
        $data['getData'] = $this->M_memodept->get_datamemo($id);
        $this->template->display('Approval/memo_permintaanideal/departemen/approve', $data);
    }

    function updateApproveDept()
    {
        $id = $this->input->post('txtmemo');

        $data = array(
            'ApproveDept'       => 1,
            'ApproveDeptBy'     => $this->session->userdata('username'),
            'ApproveDeptDate'   => date('Y-m-d H:i:s'),
        );

        $this->M_memodept->updateData($id, $data);
        redirect('Memodept/dept');
    }

    function tolakMemoDept()
    {
        $id = $this->input->get('id');
        $data['memoid'] = $id;
        $data['getData'] = $this->M_memodept->getDataCancelTolakan($id);

        $this->load->view('Approval/memo_permintaanideal/departemen/inputKeterangan', $data);
    }

    function cancelMemoDept()
    {
        $id = $this->input->get('id');
        $data['memoid'] = $id;
        $data['getData'] = $this->M_memodept->getDataCancelTolakan($id);
        $this->load->view('Approval/memo_permintaanideal/departemen/keteranganCancel', $data);
    }

    /* Approve Divisi */

    function divisi()
    {
        $data['_getFormID']         = $this->input->get('id');
        $data['getData'] = $this->M_memodept->get_dataApproveDivisi();
        $this->template->display('Approval/memo_permintaanideal/divisi/index', $data);
    }

    function approveDivisi()
    {
        $id = $this->uri->segment(3);

        $data['getData'] = $this->M_memodept->get_datamemo($id);
        $this->template->display('Approval/memo_permintaanideal/divisi/approve', $data);
    }

    function updateApproveDivisi()
    {
        $id = $this->input->post('txtmemo');

        $data = array(
            'ApproveDiv'     => 1,
            'ApproveDivBy'   => $this->session->userdata('username'),
            'ApproveDivDate' => date('Y-m-d H:i:s')
        );

        $this->M_memodept->updateData($id, $data);
        redirect('Memodept/divisi');
    }

    function tolakMemoDivisi()
    {
        $id = $this->input->get('id');
        $data['memoid'] = $id;
        $data['getData'] = $this->M_memodept->getDataCancelTolakan($id);
        $this->load->view('Approval/memo_permintaanideal/divisi/inputKeterangan', $data);
    }

    function cancelMemoDivisi()
    {
        $id = $this->input->get('id');
        $data['memoid'] = $id;
        $data['getData'] = $this->M_memodept->getDataCancelTolakan($id);
        $this->load->view('Approval/memo_permintaanideal/divisi/keteranganCancel', $data);
    }

    /* Approve PSN */

    function psn()
    {
        $data['_getFormID']         = $this->input->get('id');
        $data['getData'] = $this->M_memodept->get_dataApprovePsn();
        $this->template->display('Approval/memo_permintaanideal/psn/index', $data);
    }

    function approvePsn()
    {
        $id = $this->uri->segment(3);

        $data['getData'] = $this->M_memodept->get_datamemo($id);

        $this->template->display('Approval/memo_permintaanideal/psn/approve', $data);
    }

    function updateApprovePsn()
    {
        $id         = $this->input->post('txtmemo');

        $data = array(
            'ApprovePsn'     => 1,
            'ApprovePsnBy'   => $this->session->userdata('username'),
            'ApprovePsnDate' => date('Y-m-d H:i:s')
        );

        $this->M_memodept->updateData($id, $data);

        redirect('Memodept/psn');
    }


    function Vgm()
    {

        $data['_getFormID']         = $this->input->get('id');
        $data['getData'] =  $this->M_memodept->get_dataApproveVgm();
        $this->template->display('Approval/memo_permintaanideal/vgm/index', $data);
    }

    function approveVgm()
    {
        $id = $this->uri->segment(3);

        $data['getData'] = $this->M_memodept->get_datamemo($id);
        $this->template->display('Approval/memo_permintaanideal/vgm/approve', $data);
    }

    function updateApproveVgm()
    {
        $id         = $this->input->post('txtmemo');

        $data = array(
            'ApproveVgm'     => 1,
            'GeneralStatus'  => 1,
            'ApproveVgmBy'   => $this->session->userdata('username'),
            'ApproveVgmDate' => date('Y-m-d H:i:s')
        );

        // print_r($data);

        $this->M_memodept->updateData($id, $data);

        $exsisting  = $this->input->post('txtexsisting');
        $type       = $this->input->post('txttype');
        $total      = $this->input->post('txttotal');
        $dept       = $this->input->post('txtdept');

        if ($type == 1) {
            $data2 = array(
                'Idealkaryawan' => $total,
                'Realkaryawan' =>  $exsisting
            );
            $this->M_memodept->update_permintaan($dept, $data2);

            $data3 = array(
                'Jumlah_IdealKar ' => $total
            );
            $this->M_memodept->update_master($dept, $data3);
        } else {
            $data2 = array(
                'Idealtenagakerja' => $total,
                'Realtenagakerja'  => $exsisting
            );
            $this->M_memodept->update_permintaan($dept, $data2);

            $data3 = array(
                'Jumlah_IdealBor ' => $total
            );
            $this->M_memodept->update_master($dept, $data3);
        }

        redirect('Memodept/Vgm');
    }

    function cancelApproveVgm()
    {
        $id = $this->input->get('id');
        $data['memoid'] = $id;
        $data['getData'] = $this->M_memodept->getDataCancelTolakan($id);
        $this->load->view('Approval/memo_permintaanideal/vgm/keteranganCancel', $data);
    }

    function tolakMemoVgm()
    {
        $id = $this->input->get('id');
        $data['memoid'] = $id;
        $data['getData'] = $this->M_memodept->getDataCancelTolakan($id);
        $this->load->view('Approval/memo_permintaanideal/vgm/inputKeterangan', $data);
    }

    function tolakMemoPSN()
    {
        $id = $this->input->get('id');
        $data['memoid'] = $id;
        $data['getData'] = $this->M_memodept->getDataCancelTolakan($id);
        $this->load->view('Approval/memo_permintaanideal/psn/inputKeterangan', $data);
    }

    function cancelMemoPSN()
    {
        $id = $this->input->get('id');
        $data['memoid'] = $id;
        $data['getData'] = $this->M_memodept->getDataCancelTolakan($id);
        $this->load->view('Approval/memo_permintaanideal/psn/keteranganCancel', $data);
    }

    function simpantolakMemodept()
    {
        $id     = $this->input->post('txtMemoID');
        $ket    = $this->input->post('txtInputKeterangan');
        $data = array(
            'ApproveDept'       => NULL,
            'ApproveDeptBy'     => NULL,
            'ApproveDeptDate'   => NULL,
            'GeneralStatus'     => 2,
            'ketTolakCancel'    => $ket,
        );

        // print_r($data);
        $this->M_memodept->tolakDatamemo($id, $data);
        redirect('Memodept/dept');
    }

    function simpantolakMemopsn()
    {
        $id     = $this->input->post('txtMemoID');
        $ket    = $this->input->post('txtInputKeterangan');
        $data = array(
            'ApprovePsn'     => NULL,
            'ApprovePsnBy'   => NULL,
            'ApprovePsnDate' => NULL,
            'GeneralStatus'  => 2,
            'ketTolakCancel' => $ket,
        );

        // print_r($data);
        $this->M_memodept->tolakDatamemo($id, $data);
        redirect('Memodept/psn');
    }

    function simpantolakMemodivisi()
    {
        $id     = $this->input->post('txtMemoID');
        $ket    = $this->input->post('txtInputKeterangan');
        $data = array(
            'ApproveDiv'     => 0,
            'ApproveDivBy'   => NULL,
            'ApproveDivDate' => NULL,
            'GeneralStatus'  => 2,
            'ketTolakCancel' => $ket,
        );

        // print_r($data);
        $this->M_memodept->tolakDatamemo($id, $data);
        redirect('Memodept/divisi');
    }

     function simpantolakMemovgm()
    {
        $id     = $this->input->post('txtMemoID');
        $ket    = $this->input->post('txtInputKeterangan');
        $data = array(
            'ApproveVgm'     => 0,
            'ApproveVgmBy'   => NULL,
            'ApproveVgmDate' => NULL,
            'GeneralStatus'  => 2,
            'ketTolakCancel' => $ket,
        );

        // print_r($data);
        $this->M_memodept->tolakDatamemo($id, $data);
        redirect('Memodept/vgm');
    }


    function CancelMemo()
    {
        $memoid     = $this->input->post('txtMemoID');
        $ket        = $this->input->post('txtInputKeterangan');

        $data = array(
            'ketTolakCancel' => $ket,
            'GeneralStatus'  => 3,
        );
        $this->M_memodept->update_cancelmemodept($memoid, $data);
        redirect('Memodept');
    }

    function CancelMemoDepartemen(){
        $memoid     = $this->input->post('txtMemoID');
        $ket        = $this->input->post('txtInputKeterangan');

        $data = array(
            'ApproveDept'       => 0,
            'ApproveDeptBy'     => $this->session->userdata('username'),
            'ApproveDeptDate'   => date('Y-m-d H:i:s'),
            'ketTolakCancel'    => $ket,
            'GeneralStatus'     => 3,
        );
        $this->M_memodept->update_cancelmemodept($memoid, $data);
        redirect('Memodept/dept');
    }

    function CancelMemoDiv(){
        $data = array(
            'ApproveDiv'     => 0,
            'ApproveDivBy'   => $this->session->userdata('username'),
            'ApproveDivDate' => date('Y-m-d H:i:s'),
            'ketTolakCancel' => $ket,
            'GeneralStatus'  => 3,
        );
        $this->M_memodept->update_cancelmemodept($memoid, $data);
        redirect('Memodept/Divisi');
    }

    function CancelMemoPersonalia(){
        $data = array(
            'ApprovePsn'     => 0,
            'ApprovePsnBy'   => $this->session->userdata('username'),
            'ApprovePsnDate' => date('Y-m-d H:i:s'),
            'ketTolakCancel' => $ket,
            'GeneralStatus'  => 3,
        );
        $this->M_memodept->update_cancelmemodept($memoid, $data);
        redirect('Memodept/psn');
    }


     function CancelMemovgm(){
        $data = array(
            'ApproveVgm'     => 0,
            'ApproveVgmBy'   => $this->session->userdata('username'),
            'ApproveVgmDate' => date('Y-m-d H:i:s'),
            'ketTolakCancel' => $ket,
            'GeneralStatus'  => 3,
        );
        $this->M_memodept->update_cancelmemodept($memoid, $data);
        redirect('Memodept/psn');
    }

    function memoTolakan()
    {
        $data['getData'] = $this->M_memodept->get_dataTolakan();

        $this->template->display('returndata/memo_tolakan/index', $data);
    }

    function ubahMemoToalkan()
    {
        $memoid     = $this->uri->segment(3);

        $data = array(
            'Approve'            => 0,
            'ApproveBy'          => NULL,
            'ApproveDate'        => NULL,
            'ApproveDivisi'      => 0,
            'ApproveBy_Divisi'   => NULL,
            'ApproveDate_Divisi' => NULL,
            'ApprovePsn'         => 0,
            'ApproveBy_Psn'      => NULL,
            'ApproveDate_Psn'    => NULL,
            'ApproveVgm'         => 0,
            'ApproveBy_Vgm'      => NULL,
            'ApproveDate_Vgm'    => NULL,
            'GeneralStatus'      => NULL,
        );

        $this->M_memodept->update_ubahMemoTolakan($memoid, $data);
        redirect('Memodept/ubahMemo/' . $memoid);
    }

    function ubahMemo()
    {
        $id = $this->uri->segment(3);

        $data['getDept'] = $this->M_memodept->get_dept();
        $data['getData'] = $this->M_memodept->get_dataTolakanMemo($id);
        $this->template->display('returndata/memo_tolakan/ubah_memo', $data);
    }

    function ajaxIdeal()
    {
        $dept = $this->uri->segment(3);

        $data['dept']       = $dept;
        $data['getData']    = $this->M_memodept->get_dataubahmemo($dept);
        $this->load->view('returndata/memo_tolakan/ajaxMemoIdeal');
    }

    function ajaxnoref()
    {
        $dept = $this->uri->segment(3);

        $data['dept']       = $dept;
        $data['getDept']    = $this->M_memodept->get_dept();
        $data['getData']    = $this->M_memodept->get_dataubahmemo($dept);
        $jml                = $this->M_memodept->get_dataideal($dept);
        $data['datahitung'] = $jml + 1;
        $this->load->view('returndata/memo_tolakan/ajaxNoRef', $data);
    }

    function ajaxdept()
    {
        $dept = $this->uri->segment(3);

        $data['getDept']    = $this->M_memodept->get_dept();
        $data['getData']    = $this->M_memodept->get_dataubahmemo($dept);
        $this->load->view('returndata/memo_tolakan/ajaxDept', $data);
    }

    function EditMemoTolakan()
    {
        $memoid         = $this->input->post('txtMemoid');
        $dept           = $this->input->post('txtDept');
        $noref          = $this->input->post('txtNoref');
        $idealK         = $this->input->post('txtIdealkaryawan');
        $idealTK        = $this->input->post('txtIdealtenagakerja');
        $idealtambahan  = $this->input->post('txtIdealtambahan');
        $typeideal      = $this->input->post('txtTypeideal');
        $total          = $this->input->post('txtTotal');
        $ket            = $this->input->post('txtAlasanpenambahan');

        if ($typeideal == 1) {
            $data = array(
                'Idealkaryawan'     => $idealK,
                'Idealtenagakerja'  => $idealTK,
                'IdealtambahanK'    => $idealtambahan,
                'Type'              => $typeideal,
                'Total'             => $total,
                'Keterangan'        => $ket,
            );
            // echo 'hahahhahaha';
            $this->M_memodept->updateData($memoid, $data);
        } else {
            $data = array(
                'Idealkaryawan'     => $idealK,
                'Idealtenagakerja'  => $idealTK,
                'IdealtambahanTK'   => $idealtambahan,
                'Type'              => $typeideal,
                'Total'             => $total,
                'Keterangan'        => $ket,
            );
            // echo 'wkwkwkwkwkwk';
            $this->M_memodept->updateData($memoid, $data);
        }
        redirect('Memodept');
    }

    function closeData()
    {
        $id = $this->uri->segment(3);

        $data = array(
            'GeneralStatus' => 4,
        );

        $this->M_memodept->updateCloseData($id, $data);
        redirect('Memodept');
    }
}
