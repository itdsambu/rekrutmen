<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class updateIssuPermintaan extends CI_Controller{
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
        
        $this->load->model('m_updateIssuPermintaan');
    }

    function index(){
        $data['_getFormID']         = $this->input->get('id');
        $data['getData'] = $this->m_updateIssuPermintaan->get_IssueRequest();
        $this->template->display('statistic/update_issue/index',$data);
    }

    function updateIssue(){
        $id = $this->input->get('id');

        $data['getData'] = $this->m_updateIssuPermintaan->get_IssueRequestId($id);
        $this->load->view("statistic/update_issue/modUpdateIssue",$data);
    }

    function updateData(){
        $dtlid  = $this->input->post('txtDetailid');
        $efu    = $this->input->post('txtEFU');
        $solusi = $this->input->post('txtSolution');
        $dof    = $this->input->post('txtDOF');

        $data = array(
            'ExplanationForUnfulfilled' => $efu,
            'Solution'                  => $solusi,
            'DateOfFulfillment'         => $dof,
            'UpdateByIssue'             => $this->session->userdata('username'),
            'UpdateDateIssue'           => date('Y-m-d H:i:s'),
        );

        $this->m_updateIssuPermintaan->update($dtlid,$data);
        redirect('updateIssuPermintaan/?msg=success');
    }

    function ajaxDataFilter(){
        $filter = str_replace('%20', ' ', $this->uri->segment(3));

        // echo $filter;
        $data['getData'] = $this->m_updateIssuPermintaan->getAjaxFilter($filter);
        $this->load->view('statistic/update_issue/ajax',$data);
    }

    function exportExcel(){
        $this->load->library("Excel/PHPExcel");

        $data['getData'] = $this->m_updateIssuPermintaan->get_IssueRequest();
        $this->load->view('statistic/update_issue/excel',$data);
    }
}