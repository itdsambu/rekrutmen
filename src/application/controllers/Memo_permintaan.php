<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class memo_permintaan extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('darurat');
        $status = $this->darurat->getStatus();
        if($status === 1 && $this->session->userdata('userid') !=='ismo_adm'){
            redirect(site_url('maintenanceControl'));
        }
        
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('userid')){
            redirect('login');
        }
        
        $this->load->model('M_memo_permintaan');
    }

    function index(){
        $data['_getFormID']         = $this->input->get('id');
        $data['getDept'] = $this->M_memo_permintaan->get_dept();
        $this->template->display('returndata/memo_permintaan/index',$data);
    }
    function ajaxNoref(){
        $deptid = $this->uri->segment(3);

        $data['deptid']     = $deptid;
        $data['getDept']    = $this->M_memo_permintaan->get_dept();
        $data['getData']    = $this->M_memo_permintaan->get_data($deptid);
        $jml                = $this->M_memo_permintaan->get_dataideal($deptid);
        $data['datahitung'] = $jml+1;
        $this->load->view('returndata/memo_permintaan/ajaxNoRef',$data);
    }

    function getidealexsisiting(){
        $type = $this->uri->segment(3);
        $dept = $this->uri->segment(4);

        if($type == 1){
            $data['getJmlEx'] =  $this->M_memo_permintaan->get_exsisitingkary($dept);
            $data['getJmlIdeal'] = $this->M_memo_permintaan->get_ideal($dept);
        }else{
            $data['getJmlEx'] =  $this->M_memo_permintaan->get_exsisitingbor($dept);
            $data['getJmlIdeal'] = $this->M_memo_permintaan->get_ideal($dept);
        }
        $data['type'] = $type;
        $this->load->view('returndata/memo_permintaan/ajaxidealexs',$data);
    }

    function simpandata(){
        $noref      = $this->input->post('txtNoref');
        $dept       = $this->input->post('txtDept');
        $type       = $this->input->post('txttypememo');
        $jmlEx      = $this->input->post('txtjumlahexsisiting');
        $jmlIdeal   = $this->input->post('txtJumalhIdeal');
        $rencana    = $this->input->post('txtRencanaTambahan');
        $total      = $this->input->post('txtTotal');
        $alasan     = $this->input->post('txtAlasanpenambahan');

        if($type == 1){
            $data = array(
                'DeptID'        => $dept,
                'NoRef'         => $noref,
                'ExsistingKar' => $jmlEx,
                'IdealKar'      => $jmlIdeal,
                'Rencana'       => $rencana,
                'Type'          => $type,
                'Total'         => $total,
                'Keterangan'    => $alasan,
                'CreatedBy'     => $this->session->userdata('username'),
                'CreatedDate'   => date('Y-m-d H:i:s'),
            );
            $result = $this->M_memo_permintaan->simpan($data);
            if(!$result){
                redirect('memo_permintaan?msg=success');
            }else{
                redirect('memo_permintaan?msg=failed');
            }
        }else{
            $data = array(
                'DeptID'      => $dept,
                'NoRef'      => $noref,
                'ExsistingTk' => $jmlEx,
                'IdealTk'     => $jmlIdeal,
                'Rencana'     => $rencana,
                'Type'        => $type,
                'Total'       => $total,
                'Keterangan'  => $alasan,
                'CreatedBy'   => $this->session->userdata('username'),
                'CreatedDate' => date('Y-m-d H:i:s')
            );

            $result = $this->M_memo_permintaan->simpan($data);
            if(!$result){
                redirect('memo_permintaan?msg=success');
            }else{
                redirect('memo_permintaan?msg=failed');
            }
        }
    }
}