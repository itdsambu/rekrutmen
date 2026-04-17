<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class CTK_interview extends CI_Controller{
    
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
        
        $this->load->model(array('M_inter_ctk'));
    }
    
    function index(){
        $tanggalz   = date('Y-m-t');
        $tanggala   = date('Y-m-d', strtotime($tanggalz.' -3 months'));
        if($this->input->post('txtDateA')){
            $tanggala   = date('Y-m-d',  strtotime($this->input->post('txtDateA')));
            $tanggalz   = date('Y-m-d',  strtotime($this->input->post('txtDateZ')));
        }
        $data['_getTK'] = $this->M_inter_ctk->getListTK3($tanggala,$tanggalz);
        $data['_getDateA']   = $tanggala;
        $data['_getDateZ']   = $tanggalz;

        $this->template->display('monitor/CTK_interview/index',$data);
    }

    function indextest(){
        $dataFilter = $this->input->post('selDataFilter');
        
        $this->session->unset_userdata('w_pemborong');
        $this->session->unset_userdata('w_noreg');
        $this->session->unset_userdata('w_nama');
        
        if($this->input->post('txtNama') == NULL && $this->input->post('txtNoreg') == NULL && $this->input->post('txtPemborong') == NULL){
            redirect('CTK_interview/index/'.$dataFilter);
        }
        
        $this->session->set_userdata('w_pemborong', $this->input->post('txtPemborong'));
        $this->session->set_userdata('w_noreg', $this->input->post('txtNoreg'));
        $this->session->set_userdata('w_nama', $this->input->post('txtNama'));
        
        redirect('CTK_interview/indexWhere/'.$dataFilter.'/1');
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
            $total                  = $this->M_inter_ctk->countAllTenakerWhere($pemborong,$noreg,$nama);
            $data['_selected']      = $dataselect;
            $data['_selectWhere']   = $this->M_inter_ctk->selectAllTenakerWhere($startPaging,$endPaging,$pemborong,$noreg,$nama);
            $data['_peganation']    = $this->pagination($page = $num, 10, $total);
        } elseif($dataselect == 1){
            $total                  = $this->M_inter_ctk->countBerkasLengkapTenakerWhere($pemborong,$noreg,$nama);
            $data['_selected']      = $dataselect;
            $data['_selectWhere']   = $this->M_inter_ctk->selectBerkasLengkapTenakerWhere($startPaging,$endPaging,$pemborong,$noreg,$nama);
            $data['_peganation']    = $this->pagination($page = $num, 10, $total);
        } elseif($dataselect == 2){
            $total                  = $this->M_inter_ctk->countMinimalBerkasTenakerWhere($pemborong,$noreg,$nama);
            $data['_selected']      = $dataselect;
            $data['_selectWhere']   = $this->M_inter_ctk->selectMinimalBerkasTenakerWhere($startPaging,$endPaging,$pemborong,$noreg,$nama);
            $data['_peganation']    = $this->pagination($page = $num, 10, $total);
        } elseif($dataselect == 3){
            $total                  = $this->M_inter_ctk->countTidakLengkapTenakerWhere($pemborong,$noreg,$nama);
            $data['_selected']      = $dataselect;
            $data['_selectWhere']   = $this->M_inter_ctk->selectTidakLengkapTenakerWhere($startPaging,$endPaging,$pemborong,$noreg,$nama);
            $data['_peganation']    = $this->pagination($page = $num, 10, $total);
        } else {
            $total                  = NULL;
            $data['_selected']      = NULL;
            $data['_selectWhere']   = NULL;
            $data['_peganation']    = NULL;
        }

        $this->template->display('monitor/CTK_interview/index',$data);
    }

    function simpan(){
        $data = array(
            'HeaderID'      => $this->input->post('txtHeaderID'),
            'Dept'          => $this->input->post('txtDept'),
            'VirifiedBy'    => $this->input->post('txtName'),
            'VirifiedDate'  => date('Y-m-d H:m:i'),
            'VirifiedKet'   => $this->input->post('txtKeterangan')
        );
        
        $this->M_inter_ctk->simpanVerifikasiTim($data);
        
        redirect('CTK_interview/index?msg=success_add_komentar');
    }
    
    function verifiAksi(){
        if(isset($_POST['Verifi'])){
            $checked = $this->input->post('checkVerifi');
            $itung = count($checked);
            for($i=0; $i<$itung; $i++){
                $this->M_inter_ctk->updateVerified($checked[$i]);
            }
            redirect(site_url('CTK_interview/index'));
        }
        elseif (isset($_POST['Cancel'])) {
            $checked = $this->input->post('checkVerifi');
            $itung = count($checked);
            for($i=0; $i<$itung; $i++){
                $this->M_inter_ctk->batalVerified($checked[$i]);
            }
            redirect(site_url('CTK_interview/index'));
        }
    }
    
    function detailtk(){
        if('IS_AJAX') {
            $kode=$this->input->post('kode');
            $data['datatk'] = $this->M_inter_ctk->get_detailtk($kode)->result();
            foreach ($this->M_inter_ctk->get_detailtk($kode)->result() as $row):
                $tglLahir   = $row->Tgl_Lahir;
            endforeach;
            $data['_umur']  = $this->hitungUmur(date('Y-m-d', strtotime($tglLahir)));
            $data['resultScreen'] = $this->M_inter_ctk->resultScreen($kode)->result();
            $this->load->view('monitor/CTK_interview/detail',$data);
        }
    }
    
    function closeTenaker(){
        $hdrID = $this->input->post('txtHeaderID');
        $remark= $this->input->post('txtRemarkClose');
        $this->M_inter_ctk->closeTenaker($hdrID,$remark);
        redirect(site_url('CTK_interview/index'));
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
                        if ($counter == $page){
                            $pagination.= "<li class='active'><a class='active'>$counter</a></li>";
                        }else{
                            $pagination.= "<li><a href='$counter'>$counter</a></li>";
                        }
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

/* End of file CTK_interview.php */
/* Location: ./application/controllers/CTK_interview.php */