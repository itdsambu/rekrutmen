<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class Verifikasi extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('darurat');
        $status = $this->darurat->getStatus();
//        $status = 1;
        if($status === 1 && $this->session->userdata('userid') !=='ismo_adm'){
            redirect(site_url('maintenanceControl'));
        }
        
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('userid')){
            redirect('login');
        }
        
        $this->load->model(array('m_verifikasi'));
    }
    
    function index(){
        $dataselect             = $this->uri->segment(3);
        $num                    = $this->uri->segment(4);
        if($num == FALSE && $dataselect == FALSE){
            redirect('verifikasi/index/0/1');
        } elseif ($num == FALSE){
            redirect('verifikasi/index/'.$dataselect.'/1');
        }

        $numStart               = $num-1;
        $start                  = 1;
        $end                    = 0;
        $startPaging             = (int)$numStart.$start;
        $endPaging              = (int)$num.$end;

        if($dataselect == 0){
            $total                  = $this->m_verifikasi->countAllTenaker();
            $data['_selected']      = $dataselect;
            $data['_selectWhere']   = $this->m_verifikasi->selectAllTenaker($startPaging,$endPaging);
            $data['_peganation']    = $this->pagination($page = $num, 10, $total);
        } elseif($dataselect == 1){
            $total                  = $this->m_verifikasi->countBerkasLengkapTenaker();
            $data['_selected']      = $dataselect;
            $data['_selectWhere']   = $this->m_verifikasi->selectBerkasLengkapTenaker($startPaging,$endPaging);
            $data['_peganation']    = $this->pagination($page = $num, 10, $total);
        } elseif($dataselect == 2){
            $total                  = $this->m_verifikasi->countMinimalBerkasTenaker();
            $data['_selected']      = $dataselect;
            $data['_selectWhere']   = $this->m_verifikasi->selectMinimalBerkasTenaker($startPaging,$endPaging);
            $data['_peganation']    = $this->pagination($page = $num, 10, $total);
        } elseif($dataselect == 3){
            $total                  = $this->m_verifikasi->countTidakLengkapTenaker();
            $data['_selected']      = $dataselect;
            $data['_selectWhere']   = $this->m_verifikasi->selectTidakLengkapTenaker($startPaging,$endPaging);
            $data['_peganation']    = $this->pagination($page = $num, 10, $total);
        } else {
            $total                  = NULL;
            $data['_selected']      = NULL;
            $data['_selectWhere']   = NULL;
            $data['_peganation']    = NULL;
        }

        $this->template->display('registrasi/verifikasi/index',$data);
    }

    function indextest(){
        $dataFilter = $this->input->post('selDataFilter');
        
        $this->session->unset_userdata('w_pemborong');
        $this->session->unset_userdata('w_noreg');
        $this->session->unset_userdata('w_nama');
        
        if($this->input->post('txtNama') == NULL && $this->input->post('txtNoreg') == NULL && $this->input->post('txtPemborong') == NULL){
            redirect('verifikasi/index/'.$dataFilter);
        }
        
        $this->session->set_userdata('w_pemborong', $this->input->post('txtPemborong'));
        $this->session->set_userdata('w_noreg', $this->input->post('txtNoreg'));
        $this->session->set_userdata('w_nama', $this->input->post('txtNama'));
        
        redirect('verifikasi/indexWhere/'.$dataFilter.'/1');
    }

    function indexWhere(){
        $dataselect         = $this->uri->segment(3);
        $num                = $this->uri->segment(4);

        $pemborong          = $this->session->userdata('w_pemborong');
        $nama               = $this->session->userdata('w_nama');
        $noreg              = $this->session->userdata('w_noreg');

        $numStart               = $num-1;
        $start                  = 1;
        $end                    = 0;
        $startPaging            = (int)$numStart.$start;
        $endPaging              = (int)$num.$end;

        if($dataselect == 0){
            $total                  = $this->m_verifikasi->countAllTenakerWhere($pemborong,$noreg,$nama);
            $data['_selected']      = $dataselect;
            $data['_selectWhere']   = $this->m_verifikasi->selectAllTenakerWhere($startPaging,$endPaging,$pemborong,$noreg,$nama);
            $data['_peganation']    = $this->pagination($page = $num, 10, $total);
        } elseif($dataselect == 1){
            $total                  = $this->m_verifikasi->countBerkasLengkapTenakerWhere($pemborong,$noreg,$nama);
            $data['_selected']      = $dataselect;
            $data['_selectWhere']   = $this->m_verifikasi->selectBerkasLengkapTenakerWhere($startPaging,$endPaging,$pemborong,$noreg,$nama);
            $data['_peganation']    = $this->pagination($page = $num, 10, $total);
        } elseif($dataselect == 2){
            $total                  = $this->m_verifikasi->countMinimalBerkasTenakerWhere($pemborong,$noreg,$nama);
            $data['_selected']      = $dataselect;
            $data['_selectWhere']   = $this->m_verifikasi->selectMinimalBerkasTenakerWhere($startPaging,$endPaging,$pemborong,$noreg,$nama);
            $data['_peganation']    = $this->pagination($page = $num, 10, $total);
        } elseif($dataselect == 3){
            $total                  = $this->m_verifikasi->countTidakLengkapTenakerWhere($pemborong,$noreg,$nama);
            $data['_selected']      = $dataselect;
            $data['_selectWhere']   = $this->m_verifikasi->selectTidakLengkapTenakerWhere($startPaging,$endPaging,$pemborong,$noreg,$nama);
            $data['_peganation']    = $this->pagination($page = $num, 10, $total);
        } else {
            $total                  = NULL;
            $data['_selected']      = NULL;
            $data['_selectWhere']   = NULL;
            $data['_peganation']    = NULL;
        }

        $this->template->display('registrasi/verifikasi/index',$data);
    }

    function simpan(){
        $data = array(
            'HeaderID'      => $this->input->post('txtHeaderID'),
            'Dept'          => $this->input->post('txtDept'),
            'VirifiedBy'    => $this->input->post('txtName'),
            'VirifiedDate'  => date('Y-m-d H:m:i'),
            'VirifiedKet'   => $this->input->post('txtKeterangan')
        );
        
        $this->m_verifikasi->simpanVerifikasiTim($data);
        
        redirect('verifikasi/index?msg=success_add_komentar');
    }
    
    function verifiAksi(){
        if(isset($_POST['Verifi'])){
            $checked = $this->input->post('checkVerifi');
            $itung = count($checked);
            for($i=0; $i<$itung; $i++){
                $this->m_verifikasi->updateVerified($checked[$i]);
            }
            redirect(site_url('verifikasi/index'));
        }
        elseif (isset($_POST['Cancel'])) {
            $checked = $this->input->post('checkVerifi');
            $itung = count($checked);
            for($i=0; $i<$itung; $i++){
                $this->m_verifikasi->batalVerified($checked[$i]);
            }
            redirect(site_url('verifikasi/index'));
        }
    }
    
    function detailtk(){
        if('IS_AJAX') {
            $kode=$this->input->post('kode');
            $data['datatk'] = $this->m_verifikasi->get_detailtk($kode)->result();
            foreach ($this->m_verifikasi->get_detailtk($kode)->result() as $row):
                $tglLahir   = $row->Tgl_Lahir;
            endforeach;
            $data['_umur']  = $this->hitungUmur(date('Y-m-d', strtotime($tglLahir)));
            $data['resultScreen'] = $this->m_verifikasi->resultScreen($kode)->result();
            $this->load->view('registrasi/verifikasi/detail',$data);
        }
    }
    
    function closeTenaker(){
        $hdrID = $this->input->post('txtHeaderID');
        $remark= $this->input->post('txtRemarkClose');
        $this->m_verifikasi->closeTenaker($hdrID,$remark);
        redirect(site_url('verifikasi/index'));
    }

    function hitungUmur($tglLahir = "1991-02-01"){
        $thn    = substr($tglLahir, 0, 4);
        $bln    = substr($tglLahir, 5, 2);
        $day    = substr($tglLahir, 8, 2);
        
        $nowY   = date("Y");
        $nowM   = date("m");
        $nowD   = date("d");
        
        $hariLahir  = gregoriantojd($bln, $day, $thn);
        $today      = gregoriantojd($nowM, $nowD, $nowY);
        
        $umur   = $today-$hariLahir;
        $tahun  = substr($umur/365, 0, 2);
        
        return $tahun;
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

/* End of file verifikasi.php */
/* Location: ./application/controllers/verifikasi.php */