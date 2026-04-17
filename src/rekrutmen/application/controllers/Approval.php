<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class Approval extends CI_Controller{
    
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
        
        $this->load->model(array('m_approval','m_issue'));
    }
    
    // ======================== Approval Department ============================
    function deptIndex(){
        $data['_getTran'] = $this->m_approval->getTransForDept();
        $this->template->display('transaksi/approval/dept/index',$data);
    }
    function viewApprovalDept(){
        if('IS_AJAX') {
        $id = $this->input->post('kode');
        $data['getPend'] = $this->m_issue->getPendidikan();
        $data['getJurs'] = $this->m_issue->getJurusan();
        $data['getSKwn'] = $this->m_issue->getStatusKawin();
        $data['getTran'] = $this->m_approval->setInfoTran($id);
        $this->load->view('transaksi/approval/dept/approvalDept',$data);
        }
    }
    function updateIssueByDept(){
        $id     = $this->input->post('txtID');
        $data   = array(
            'UpdatedBy'     => $this->session->userdata('username'),
            'UpdatedDate'   => date('Y-m-d H:m:i'),
            'TKTarget'      => $this->input->post('txtTarget'),
            'TKSedia'       => $this->input->post('txtTersedia'),
            'TKPermintaan'  => $this->input->post('txtPermintaan'),
            'IssueRemark'   => $this->input->post('txtKeterangan'),
            'Umur'          => $this->input->post('txtUmur'),
            'Pendidikan'    => $this->input->post('comboPendidikan'),
            'Jurusan'       => $this->input->post('comboJurusan'),
            'JenisKelamin'  => $this->input->post('comboJekel'),
            'StatusPersonal'=> $this->input->post('comboStatus')
        );
        $this->m_approval->updateTran($id,$data);
        redirect('approval/deptIndex');
    }            
    function approvalDept(){
        if($this->input->post('txtHasil') == 1){
            $id     = $this->input->post('txtID');
            $data   = array(
                'DEPTApproval'  => $this->session->userdata('username'),
                'DEPTDate'      => date('Y-m-d H:m:i'),
                'DEPTStatus'    => $this->input->post('txtHasil'),
                'DEPTRemark'    => $this->input->post('txtKeterangan')
            );
            $this->m_approval->updateTran($id,$data);
        }else{
            $id     = $this->input->post('txtID');
            $data   = array(
                'DEPTApproval'  => $this->session->userdata('username'),
                'DEPTDate'      => date('Y-m-d H:m:i'),
                'DEPTStatus'    => $this->input->post('txtHasil'),
                'GeneralStatus' => 2, //cancel
                'KeteranganStatus'  => 'Cancel di Departemen',
                'DEPTRemark'    => $this->input->post('txtKeterangan')
            );
            $this->m_approval->updateTran($id,$data);
        }
        redirect('approval/deptIndex');
    }
    function multiApprovalDept(){
        if($this->input->post('Submit') == 'Approve'){
            $id = $this->input->post('ckDetailID');
            $itung  = count($id);
            for($i=0; $i<$itung; $i++){
                $data   = array(
                    'DEPTApproval'  => $this->session->userdata('username'),
                    'DEPTDate'      => date('Y-m-d H:m:i'),
                    'DEPTStatus'    => 1,
                    'DEPTRemark'    => 'Disetujui Oleh Departemen'
                ); 
                $this->m_approval->updateTran($id[$i],$data);
            }
            redirect('approval/deptIndex');
            
        }elseif($this->input->post('Submit') == 'Decline'){
            $id = $this->input->post('ckDetailID');
            $itung  = count($id);
            for($i=0; $i<$itung; $i++){
                $data   = array(
                    'DEPTApproval'  => $this->session->userdata('username'),
                    'DEPTDate'      => date('Y-m-d H:m:i'),
                    'DEPTStatus'    => 2,
                    'GeneralStatus' => 2, //cancel
                    'KeteranganStatus'  => 'Cancel di Departemen',
                    'DEPTRemark'    => 'Ditolak Oleh Departemen'
                ); 
                $this->m_approval->updateTran($id[$i],$data);
            }
            redirect('approval/deptIndex');
            
        }
    }
    
    // ======================== Approval DIVISI ============================
    function divisiIndex(){
        $data['_getTran'] = $this->m_approval->getTranForDivisi();
        $this->template->display('transaksi/approval/divisi/index',$data);
    }
    function viewApprovalDivisi(){
        if('IS_AJAX') {
        $id = $this->input->post('kode');
        $data['getPend'] = $this->m_issue->getPendidikan();
        $data['getJurs'] = $this->m_issue->getJurusan();
        $data['getSKwn'] = $this->m_issue->getStatusKawin();
        $data['getTran'] = $this->m_approval->setInfoTran($id);
        $this->load->view('transaksi/approval/divisi/approvalDivisi',$data);
        }
    }
    function updateIssueByDivisi(){
        $id     = $this->input->post('txtID');
        $data   = array(
            'UpdatedBy'     => $this->session->userdata('username'),
            'UpdatedDate'   => date('Y-m-d H:m:i'),
            'TKTarget'      => $this->input->post('txtTarget'),
            'TKSedia'       => $this->input->post('txtTersedia'),
            'TKPermintaan'  => $this->input->post('txtPermintaan'),
            'IssueRemark'   => $this->input->post('txtKeterangan'),
            'Umur'          => $this->input->post('txtUmur'),
            'Pendidikan'    => $this->input->post('comboPendidikan'),
            'Jurusan'       => $this->input->post('comboJurusan'),
            'JenisKelamin'  => $this->input->post('comboJekel'),
            'StatusPersonal'=> $this->input->post('comboStatus')
        );
        $this->m_approval->updateTran($id,$data);
        redirect('approval/divisiIndex');
    }
    function approvalDivisi(){
        if($this->input->post('txtHasil') == 1){
            $id     = $this->input->post('txtID');
            $data   = array(
                'DIVISIApproval'  => $this->session->userdata('username'),
                'DIVISIDate'      => date('Y-m-d H:m:i'),
                'DIVISIStatus'    => $this->input->post('txtHasil'),
                'DIVISIRemark'    => $this->input->post('txtKeterangan')
            );
            $this->m_approval->updateTran($id,$data);
        }else{
            $id     = $this->input->post('txtID');
            $data   = array(
                'DIVISIApproval'  => $this->session->userdata('username'),
                'DIVISIDate'      => date('Y-m-d H:m:i'),
                'DIVISIStatus'    => $this->input->post('txtHasil'),
                'GeneralStatus' => 2, //cancel
                'KeteranganStatus'  => 'Cancel di Divisi',
                'DIVISIRemark'    => $this->input->post('txtKeterangan')
            );
            $this->m_approval->updateTran($id,$data);
        }
        redirect('approval/divisiIndex');
    }
    function multiApprovalDivisi(){
        if($this->input->post('Submit') == 'Approve'){
            $id = $this->input->post('ckDetailID');
            $itung  = count($id);
            for($i=0; $i<$itung; $i++){
                $data   = array(
                    'DIVISIApproval'  => $this->session->userdata('username'),
                    'DIVISIDate'      => date('Y-m-d H:m:i'),
                    'DIVISIStatus'    => 1,
                    'DIVISIRemark'    => 'Disetujui Oleh Divisi'
                );
                $this->m_approval->updateTran($id[$i],$data);
            }

            redirect('approval/divisiIndex');
        }elseif($this->input->post('Submit') == 'Decline'){
            $id = $this->input->post('ckDetailID');
            $itung  = count($id);
            for($i=0; $i<$itung; $i++){
                $data   = array(
                    'DIVISIApproval'  => $this->session->userdata('username'),
                    'DIVISIDate'      => date('Y-m-d H:m:i'),
                    'DIVISIStatus'    => 2,
                    'GeneralStatus' => 2, //cancel
                    'KeteranganStatus'  => 'Cancel di Divisi',
                    'DIVISIRemark'    => 'Ditolak Oleh Divisi'
                );
                $this->m_approval->updateTran($id[$i],$data);
            }

            redirect('approval/divisiIndex');
        }
    }
    
    // ======================== Approval PSN ============================
    function psnIndex(){
        $data['_getTran'] = $this->m_approval->getTranForPsn();
        $this->template->display('transaksi/approval/psn/index',$data);
    }
    function viewApprovalPSN(){
        if('IS_AJAX') {
        $id = $this->input->post('kode');
        $data['getPend'] = $this->m_issue->getPendidikan();
        $data['getJurs'] = $this->m_issue->getJurusan();
        $data['getSKwn'] = $this->m_issue->getStatusKawin();
        $data['getTran'] = $this->m_approval->setInfoTran($id);
        $this->load->view('transaksi/approval/psn/approvalPSN',$data);
        }
    }
    function updateIssueByPSN(){
        $id     = $this->input->post('txtID');
        $data   = array(
            'UpdatedBy'     => $this->session->userdata('username'),
            'UpdatedDate'   => date('Y-m-d H:m:i'),
            'TKTarget'      => $this->input->post('txtTarget'),
            'TKSedia'       => $this->input->post('txtTersedia'),
            'TKPermintaan'  => $this->input->post('txtPermintaan'),
            'IssueRemark'   => $this->input->post('txtKeterangan'),
            'Umur'          => $this->input->post('txtUmur'),
            'Pendidikan'    => $this->input->post('comboPendidikan'),
            'Jurusan'       => $this->input->post('comboJurusan'),
            'JenisKelamin'  => $this->input->post('comboJekel'),
            'StatusPersonal'=> $this->input->post('comboStatus')
        );
        $this->m_approval->updateTran($id,$data);
        redirect('approval/psnIndex');
    }
    function approvalPSN(){
        if($this->input->post('txtHasil') == 1){
            $id     = $this->input->post('txtID');
            $data   = array(
                'PSNApproval'  => $this->session->userdata('username'),
                'PSNDate'      => date('Y-m-d H:m:i'),
                'PSNStatus'    => $this->input->post('txtHasil'),
                'PSNRemark'    => $this->input->post('txtKeterangan')
            );
            $this->m_approval->updateTran($id,$data);
        }else{
            $id     = $this->input->post('txtID');
            $data   = array(
                'PSNApproval'  => $this->session->userdata('username'),
                'PSNDate'      => date('Y-m-d H:m:i'),
                'PSNStatus'    => $this->input->post('txtHasil'),
                'GeneralStatus' => 2, //cancel
                'KeteranganStatus'  => 'Cancel di Personalia',
                'PSNRemark'    => $this->input->post('txtKeterangan')
            );
            $this->m_approval->updateTran($id,$data);
        }
        redirect('approval/psnIndex');
    }
    function multiApprovalPSN(){
        if($this->input->post('Submit') == 'Approve'){
            $id = $this->input->post('ckDetailID');
            $itung  = count($id);
            for($i=0; $i<$itung; $i++){
                $data   = array(
                    'PSNApproval'  => $this->session->userdata('username'),
                    'PSNDate'      => date('Y-m-d H:m:i'),
                    'PSNStatus'    => 1,
                    'PSNRemark'    => 'Disetujui Oleh PSN'
                );
                $this->m_approval->updateTran($id[$i],$data);
            }

            redirect('approval/psnIndex');
        }elseif($this->input->post('Submit') == 'Decline'){
            $id = $this->input->post('ckDetailID');
            $itung  = count($id);
            for($i=0; $i<$itung; $i++){
                $data   = array(
                    'PSNApproval'  => $this->session->userdata('username'),
                    'PSNDate'      => date('Y-m-d H:m:i'),
                    'PSNStatus'    => 2,
                    'GeneralStatus' => 2, //cancel
                    'KeteranganStatus'  => 'Cancel di PSN',
                    'PSNRemark'    => 'Ditolak Oleh PSN'
                );
                $this->m_approval->updateTran($id[$i],$data);
            }

            redirect('approval/psnIndex');
        }
    }
    
    // ======================== Approval AGM ============================
    function agmIndex(){
        $data['_getTran'] = $this->m_approval->getTranForAgm();
        $this->template->display('transaksi/approval/agm/index',$data);
    }
    function viewApprovalAGM(){
        if('IS_AJAX') {
        $id = $this->input->post('kode');
        $data['getPend'] = $this->m_issue->getPendidikan();
        $data['getJurs'] = $this->m_issue->getJurusan();
        $data['getSKwn'] = $this->m_issue->getStatusKawin();
        $data['getTran'] = $this->m_approval->setInfoTran($id);
        $this->load->view('transaksi/approval/agm/approvalAGM',$data);
        }
    }
    function updateIssueByAGM(){
        $id     = $this->input->post('txtID');
        $data   = array(
            'UpdatedBy'     => $this->session->userdata('username'),
            'UpdatedDate'   => date('Y-m-d H:m:i'),
            'TKTarget'      => $this->input->post('txtTarget'),
            'TKSedia'       => $this->input->post('txtTersedia'),
            'TKPermintaan'  => $this->input->post('txtPermintaan'),
            'IssueRemark'   => $this->input->post('txtKeterangan'),
            'Umur'          => $this->input->post('txtUmur'),
            'Pendidikan'    => $this->input->post('comboPendidikan'),
            'Jurusan'       => $this->input->post('comboJurusan'),
            'JenisKelamin'  => $this->input->post('comboJekel'),
            'StatusPersonal'=> $this->input->post('comboStatus')
        );
        $this->m_approval->updateTran($id,$data);
        redirect('approval/agmIndex');
    }
    function approvalAGM(){
        if($this->input->post('txtHasil') == 1){
            $id     = $this->input->post('txtID');
            $data   = array(
                'AGMApproval'  => $this->session->userdata('username'),
                'AGMDate'      => date('Y-m-d H:m:i'),
                'AGMStatus'    => $this->input->post('txtHasil'),
                'AGMRemark'    => $this->input->post('txtKeterangan')
            );
            $this->m_approval->updateTran($id,$data);
        }else{
            $id     = $this->input->post('txtID');
            $data   = array(
                'AGMApproval'  => $this->session->userdata('username'),
                'AGMDate'      => date('Y-m-d H:m:i'),
                'AGMStatus'    => $this->input->post('txtHasil'),
                'GeneralStatus' => 2, //cancel
                'KeteranganStatus'  => 'Cancel di AGM',
                'AGMRemark'    => $this->input->post('txtKeterangan')
            );
            $this->m_approval->updateTran($id,$data);
        }
        redirect('approval/agmIndex');
    }
    function multiApprovalAGM(){
        if($this->input->post('Submit') == 'Approve'){
            $id = $this->input->post('ckDetailID');
            $itung  = count($id);
            for($i=0; $i<$itung; $i++){
                $data   = array(
                    'AGMApproval'  => $this->session->userdata('username'),
                    'AGMDate'      => date('Y-m-d H:m:i'),
                    'AGMStatus'    => 1,
                    'AGMRemark'    => 'Disetujui Oleh AGM'
                );
                $this->m_approval->updateTran($id[$i],$data);
            }

            redirect('approval/agmIndex');
        }elseif($this->input->post('Submit') == 'Decline'){
            $id = $this->input->post('ckDetailID');
            $itung  = count($id);
            for($i=0; $i<$itung; $i++){
                $data   = array(
                    'AGMApproval'  => $this->session->userdata('username'),
                    'AGMDate'      => date('Y-m-d H:m:i'),
                    'AGMStatus'    => 2,
                    'GeneralStatus' => 2, //cancel
                    'KeteranganStatus'  => 'Cancel di AGM',
                    'AGMRemark'    => 'Ditolak Oleh AGM'
                );
                $this->m_approval->updateTran($id[$i],$data);
            }

            redirect('approval/agmIndex');
        }
    }
    
    // ======================== Approval VGM ============================
    function vgmIndex(){
        $data['_getTran'] = $this->m_approval->getTranForVgm();
        $this->template->display('transaksi/approval/vgm/index',$data);
    }
    function viewApprovalVGM(){
        if('IS_AJAX') {
        $id = $this->input->post('kode');
        $data['getPend'] = $this->m_issue->getPendidikan();
        $data['getJurs'] = $this->m_issue->getJurusan();
        $data['getSKwn'] = $this->m_issue->getStatusKawin();
        $data['getTran'] = $this->m_approval->setInfoTran($id);
        $this->load->view('transaksi/approval/vgm/approvalVGM',$data);
        }
    }
    function updateIssueByVGM(){
        $id     = $this->input->post('txtID');
        $data   = array(
            'UpdatedBy'     => $this->session->userdata('username'),
            'UpdatedDate'   => date('Y-m-d H:m:i'),
            'TKTarget'      => $this->input->post('txtTarget'),
            'TKSedia'       => $this->input->post('txtTersedia'),
            'TKPermintaan'  => $this->input->post('txtPermintaan'),
            'IssueRemark'   => $this->input->post('txtKeterangan'),
            'Umur'          => $this->input->post('txtUmur'),
            'Pendidikan'    => $this->input->post('comboPendidikan'),
            'Jurusan'       => $this->input->post('comboJurusan'),
            'JenisKelamin'  => $this->input->post('comboJekel'),
            'StatusPersonal'=> $this->input->post('comboStatus')
        );
        $this->m_approval->updateTran($id,$data);
        redirect('approval/vgmIndex');
    }
    function approvalVGM(){
        if($this->input->post('txtHasil') == 1){
            $id     = $this->input->post('txtID');
            $data   = array(
                'VGMApproval'   => $this->session->userdata('username'),
                'VGMDate'       => date('Y-m-d H:m:i'),
                'VGMStatus'     => $this->input->post('txtHasil'),
                'VGMRemark'     => $this->input->post('txtKeterangan')
            );
            $this->m_approval->updateTran($id,$data);
        }else{
            $id     = $this->input->post('txtID');
            $data   = array(
                'VGMApproval'   => $this->session->userdata('username'),
                'VGMDate'       => date('Y-m-d H:m:i'),
                'VGMStatus'     => $this->input->post('txtHasil'),
                'GeneralStatus' => 2, //cancel
                'KeteranganStatus'  => 'Cancel di VGM',
                'VGMRemark'     => $this->input->post('txtKeterangan')
            );
            $this->m_approval->updateTran($id,$data);
        }
        redirect('approval/vgmIndex');
    }
    function multiApprovalVGM(){
        if($this->input->post('Submit') == 'Approve'){
            $id = $this->input->post('ckDetailID');
            $itung  = count($id);
            for($i=0; $i<$itung; $i++){
                $data   = array(
                    'VGMApproval'  => $this->session->userdata('username'),
                    'VGMDate'      => date('Y-m-d H:m:i'),
                    'VGMStatus'    => 1,
                    'VGMRemark'    => 'Disetujui Oleh VGM',
                    'GeneralStatus'=> 1,
                    'KeteranganStatus'  => 'Disetujui di VGM'
                );
                $this->m_approval->updateTran($id[$i],$data);
            }

            redirect('approval/vgmIndex');
        }elseif($this->input->post('Submit') == 'Decline'){
            $id = $this->input->post('ckDetailID');
            $itung  = count($id);
            for($i=0; $i<$itung; $i++){
                $data   = array(
                    'VGMApproval'  => $this->session->userdata('username'),
                    'VGMDate'      => date('Y-m-d H:m:i'),
                    'VGMStatus'    => 2,
                    'VGMRemark'    => 'Ditolak Oleh VGM',
                    'GeneralStatus' => 2, //cancel
                    'KeteranganStatus'  => 'Cancel di VGM'
                );
                $this->m_approval->updateTran($id[$i],$data);
            }

            redirect('approval/vgmIndex');
        }
            
    }
    
}