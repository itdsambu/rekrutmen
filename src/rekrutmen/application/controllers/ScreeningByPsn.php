<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class ScreeningByPsn extends CI_Controller{
    
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
        
        $this->load->model('m_screening');
    }
    
    public function index(){ 
        $dept           = $this->session->userdata('dept');
        // print_r($dept);
        // exit;
        $data['_getTK'] = $this->m_screening->listTKScreenedTim();
        //  print_r($data);
        // exit;
        $this->template->display('registrasi/screening/psn',$data);
    }


    // function screening(){
    //     $dataSelect             = $this->uri->segment(3);
    //     $num                    = $this->uri->segment(4);
    //     if($num == FALSE && $dataSelect == FALSE){
    //         redirect('ScreeningByPsn/screening/0/1');
    //     }elseif ($num == FALSE) {
    //         redirect('ScreeningByPsn/screening/'.$dataSelect.'/1');
    //     }
    //     $numStart               = $num-1;
    //     $start                  = 1;
    //     $end                    = 0;
    //     $startPaging            = (int)$numStart.$start;
    //     $endPaging              = (int)$num.$end;
    //     if($dataSelect == 1){
    //         $total                  = $this->m_screening->countScreeningLulus();
    //         $data['_selected']      = $dataSelect;
    //         $data['_selectWhere']   = $this->m_screening->selectScreeningLulus($startPaging,$endPaging);
    //         $data['_pagination']    = $this->pagination($page = $num, 10, $total);
    //     }elseif($dataSelect == 0){
    //         $total                  = $this->m_screening->countScreeningTidakLulus();
    //         $data['_selected']      = $dataSelect;
    //         $data['_selectWhere']   = $this->m_screening->selectScreeningTidakLulus($startPaging,$endPaging);
    //         $data['_pagination']    = $this->pagination($page = $num, 10, $total);
    //     }elseif($dataSelect == 2){
    //         $total                  = $this->m_screening->countScreeningAll();
    //         $data['_selected']      = $dataSelect;
    //         $data['_selectWhere']   = $this->m_screening->selectScreeningAll($startPaging,$endPaging);
    //         $data['_pagination']    = $this->pagination($page = $num, 10, $total);
    //     }else{
    //         $total                  = NULL;
    //         $data['_selected']      = NULL;
    //         $data['_selectWhere']   = NULL;
    //         $data['_pagination']    = NULL;
    //     }

    //     $this->template->display('registrasi/screening/psn',$data);
    // }

    // function screeningfilter(){
    //     $dataFilter = $this->input->post('txtFilter');

    //     $this->session->unset_userdata('w_nama');

    //     if($this->input->post('txtNama') == NULL){
    //         redirect('ScreeningByPsn/screening/'.$dataFilter);
    //     }

    //     $this->session->set_userdata('w_nama', $this->input->post('txtNama'));

    //     redirect('ScreeningByPsn/screeningWhere/'.$dataFilter.'/1');
    // }

    // function screeningWhere(){
    //     $dataSelect             = $this->uri->segment(3);
    //     $num                    = $this->uri->segment(4);

    //     $nama           = $this->session->userdata('w_nama');
        
    //     $numStart               = $num-1;
    //     $start                  = 1;
    //     $end                    = 0;
    //     $startPaging            = (int)$numStart.$start;
    //     $endPaging              = (int)$num.$end;

    //     if($dataSelect == 1){
    //         $total                  = $this->m_screening->countScreeningLulusWhere($nama);
    //         $data['_selected']      = $dataSelect;
    //         $data['_selectWhere']   = $this->m_screening->selectScreeningLulusWhere($startPaging,$endPaging,$nama);
    //         $data['_pagination']    = $this->pagination($page = $num, 10, $total);
    //     }elseif($dataSelect == 0){
    //         $total                  = $this->m_screening->countScreeningTidakLulusWhere($nama);
    //         $data['_selected']      = $dataSelect;
    //         $data['_selectWhere']   = $this->m_screening->selectScreeningTidakLulusWhere($startPaging,$endPaging,$nama);
    //         $data['_pagination']    = $this->pagination($page = $num, 10, $total);
    //     }elseif($dataSelect == 2){
    //         $total                  = $this->m_screening->countScreeningAllWhere($nama);
    //         $data['_selected']      = $dataSelect;
    //         $data['_selectWhere']   = $this->m_screening->selectScreeningAllWhere($startPaging,$endPaging,$nama);
    //         $data['_pagination']    = $this->pagination($page = $num, 10, $total);
    //     }else{
    //         $total                  = NULL;
    //         $data['_selected']      = NULL;
    //         $data['_selectWhere']   = NULL;
    //         $data['_pagination']    = NULL;
    //     }

    //     $this->template->display('registrasi/screening/psn',$data);
    // }
	
	function viewDocs(){
        if('IS_AJAX') {
            $userID=$this->input->post('kode');
            $berkas=$this->input->post('nama');
            $data['_jenisBerkas'] = $berkas;
            $data['_getViewDocs'] = $this->m_screening->getDocs($userID);
            $this->load->view('registrasi/screening/viewDocs',$data);
        }
    }
    
    function screenPsn(){
        if('IS_AJAX') {
        $kode=$this->input->post('kode');
        $data['datatk'] = $this->m_screening->getDetailTK($kode)->result();
        $data['resultScreen'] = $this->m_screening->resultScreen($kode)->result();
        $data['resultInterV'] = $this->m_screening->resultInterview($kode)->result();
        $this->load->view('registrasi/screening/screenPsn',$data);
        }
    }
    // penambahan SpecialScreeningHostname dan SpecialScreeningIpAddress tanggal 25 Mei 2019
    function simpanScreenPsn(){
        $hdrID = $this->input->post('txtHeaderID');
        if($this->input->post('txtHasil') == 1){
            $data = array(
                'SpecialScreening'          => 1,
                'SpecialJeda'               => $this->input->post('txtJeda'),            
                'SpecialScreeningRemark'    => $this->input->post('txtKeterangan'),
                'SpecialScreeningBy'        => $this->input->post('txtNamePSN'),
                'SpecialScreeningDate'      => date('Y-m-d H:i:s'),
                'ScreeningComplete'         => 1,
                'ScreeningHasil'            => 1,
                'GeneralStatus'             => 0,
                'SpecialScreeningHostname'  => $this->session->userdata('hostname'),
                'SpecialScreeningIpAddress' => $this->session->userdata('ipaddress')
            );
            $this->m_screening->screenByPsn($hdrID,$data);
        }elseif ($this->input->post('txtHasil') == 0) {
            $data = array(
                'SpecialScreening'          => 0,
                'SpecialJeda'               => $this->input->post('txtJeda'),            
                'SpecialScreeningRemark'    => $this->input->post('txtKeterangan'),
                'SpecialScreeningBy'        => $this->input->post('txtNamePSN'),
                'SpecialScreeningDate'      => date('Y-m-d H:i:s'),
                'ScreeningComplete'         => 1,
                'ScreeningHasil'            => 0,
                'GeneralStatus'             => 1,
                'ClosingRemark'             => $this->input->post('txtKeterangan'),
                'ClosingBy'                 => $this->session->userdata('username'),
                'ClosingDate'               => date('Y-m-d H:i:s'),
                'SpecialScreeningHostname'  => $this->session->userdata('hostname'),
                'SpecialScreeningIpAddress' => $this->session->userdata('ipaddress')
            );
            $this->m_screening->screenByPsn($hdrID,$data);
        }
        
        redirect('screeningByPsn/index?msg=Success');
    }

    function pagination($page = 1, $per_page = 10, $row = 0){
        $total = $row;
        $adjacents = "2"; 

        $page = ($page == 0 ? 1 : $page);  
        $start = ($page - 1) * $per_page;                               
        
        $prev = $page - 1;                          
        $next = $page + 1;
        $lastpage = ceil($total/$per_page);
        $lpm1 = $lastpage - 1;
        
        $pagination = "";
        if ($lastpage > 1) {
            $pagination .= "<ul class='pagination'>";
            $pagination .= "<li><a>Page $page of $lastpage</a></li>";
            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page){
                        $pagination.= "<li class='active'><a>$counter</a></li>";
                    }else{
                        $pagination.= "<li><a href='$counter'>$counter</a></li>";
                    }
                }
            }
            elseif ($lastpage > 5 + ($adjacents * 2)) {
                if ($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page){
                            $pagination.= "<li class='active'><a class='active'>$counter</a></li>";
                        }else{
                            $pagination.= "<li><a href='$counter'>$counter</a></li>";
                        }
                    }
                    $pagination.= "<li class='dot'><a>...</a></li>";
                    $pagination.= "<li><a href='$lpm1'>$lpm1</a></li>";
                    $pagination.= "<li><a href='$lastpage'>$lastpage</a></li>";
                }
                elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination.= "<li><a href='1'>1</a></li>";
                    $pagination.= "<li><a href='2'>2</a></li>";
                    $pagination.= "<li class='dot'><a>...</a></li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<li class='active'><a class='active'>$counter</a></li>";
                        else
                            $pagination.= "<li><a href='$counter'>$counter</a></li>";
                    }
                    $pagination.= "<li class='dot'><a>...</a></li>";
                    $pagination.= "<li><a href='$lpm1'>$lpm1</a></li>";
                    $pagination.= "<li><a href='$lastpage'>$lastpage</a></li>";
                }
                else {
                    $pagination.= "<li><a href='1'>1</a></li>";
                    $pagination.= "<li><a href='2'>2</a></li>";
                    $pagination.= "<li class='dot'><a>...</a></li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<li class='active'><a class='active'>$counter</a></li>";
                        else
                            $pagination.= "<li><a href='$counter'>$counter</a></li>";
                    }
                }
            }

            if ($page < $counter - 1) {
                $pagination.= "<li><a href='$next'>Next</a></li>";
                $pagination.= "<li><a href='$lastpage'>Last</a></li>";
            } else {
                $pagination.= "<li><a class='current'>Next</a></li>";
                $pagination.= "<li><a class='current'>Last</a></li>";
            }
            $pagination.= "</ul>\n";
        }
        return $pagination;
    }
}

/* End of file screeningByPsn.php */
/* Location: ./application/controllers/screeningByPsn.php */