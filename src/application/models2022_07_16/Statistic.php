<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class Statistic extends CI_Controller{
    
    public function __construct() {
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
        
        $this->load->model('m_statistic');
    }
    
    function statRegistered(){
        if(isset($_POST['txtTglSelect'])){
            $tgl = date('Y-m-d', strtotime($this->input->post('txtTglSelect')));
            $data['_getData']   = $this->m_statistic->countPemborongTgl($tgl);
            $data['_getBuln']   = $this->m_statistic->countPemborongBln($tgl);
            $data['_getTgl']    = $tgl;
        }else{
            $tgl = date('Y-m-d');
            $data['_getData']   = $this->m_statistic->countPemborongTgl($tgl);
            $data['_getBuln']   = $this->m_statistic->countPemborongBln($tgl);
            $data['_getTgl']    = $tgl;
        }
//        $data['_getData'] = $this->m_statistic->countPemborongTgl($tgl = date('Y-m-d'));
//        $data['_getBuln'] = $this->m_statistic->countPemborongBln($tgl = date('Y-m-d'));
        $this->template->display('statistic/registered/index',$data);
    }
    function setPemborong(){
        if('IS_AJAX') {
            $tgl = date('Y-m-d', strtotime($this->input->post('tgl')));
            $data['_getData']   = $this->m_statistic->countPemborongTgl($tgl);
            $data['_getTgl']    = $tgl;
            $this->load->view('statistic/registered/statPemborong',$data);
        }
    }
            
    function statPosted(){
        $this->template->display('statistic/posted/index');
    }
    function setPosted(){
        
    }
            
    function statIssue(){
        $tanggal    = date('Y-m-d');
        if($this->input->post('txtPeriode')){
            $tanggal    = date('Y-m-d',  strtotime($this->input->post('txtPeriode')));
        }
        $data['_getIssue']  = $this->m_statistic->getIssue($tanggal);
        $data['_getDate']   = $tanggal;
        $this->template->display('statistic/request_issue/index',$data);
    }
    
    function reviewTenaker(){
        if('IS_AJAX') {
            $issueID    = $this->input->post('kode');
            $cekData    = $this->m_statistic->getReviewTenaker($issueID);
            if($cekData->num_rows > 0):
                $data['_getTenaker']   = $this->m_statistic->getReviewTenaker($issueID)->result();
                $this->load->view('statistic/request_issue/review',$data);
            else:
                $this->load->view('statistic/request_issue/noReview');
            endif;
        }
    }

    // New Rekap Issue Permintaan
    function rekapIssueRequest(){
        $tanggalz   = date('Y-m-t');
        $tanggala   = date('Y-m-d', strtotime($tanggalz.' -3 months'));
        if($this->input->post('txtDateA')){
            $tanggala   = date('Y-m-d',  strtotime($this->input->post('txtDateA')));
            $tanggalz   = date('Y-m-d',  strtotime($this->input->post('txtDateZ')));
        }
        $data['_getIssue']  = $this->m_statistic->getRekapIssueRequest($tanggala,$tanggalz);
        $data['_getDateA']   = $tanggala;
        $data['_getDateZ']   = $tanggalz;
        $this->template->display('statistic/rekapIssue/index',$data);
    }
}