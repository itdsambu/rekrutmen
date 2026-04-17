<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class PrintControl extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('darurat');
//        $status = 1;
        $status = $this->darurat->getStatus();
        if($status === 1 && $this->session->userdata('userid') !=='ismo_adm'){
            redirect(site_url('maintenanceControl'));
        }
        
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('userid')){
            redirect('login');
        }
        
        $this->load->model(array('m_posting_tenaker','m_print_berkas'));
    }
    
    function index(){
        $start  = date('Y-m-d', strtotime($this->input->post('startDate')));
        $end    = date('Y-m-d', strtotime($this->input->post('endDate')));
        
        if($this->input->post('startDate')){
            $data['_listTenaker']    = $this->m_print_berkas->getTenakerPostedWhere($start, $end);
        }else{
            $data['_listTenaker']    = $this->m_print_berkas->getTenakerPosted();
        }
        
        $this->template->display('registrasi/print_berkas/index',$data);
    }
    function newPaging(){
        /*
         * -- dataSelect -- 
         * 0 => Telah Posting
         * 1 => Lulus Wawancara
         */
        $dataSelect             = $this->uri->segment(3);
        $num                    = $this->uri->segment(4);
        if($num === FALSE && $dataSelect === FALSE){
            redirect('PrintControl/newPaging/0/1');
        }elseif ($num === FALSE) {
            redirect('PrintControl/newPaging/'.$dataSelect.'/1');
        }
        
        $numStart               = $num-1;
        $start                  = 1;
        $end                    = 0;
        $startPaging            = (int)$numStart.$start;
        $endPaging              = (int)$num.$end;
        if($dataSelect == 0){
            $total                  = $this->m_print_berkas->countTenakerPostedPrintPaging();
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->m_print_berkas->selectTenakerPostedPrintPaging($startPaging,$endPaging);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
        }elseif($dataSelect == 1){
            $total                  = $this->m_print_berkas->countTenakerInterviewedPrintPaging();
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->m_print_berkas->selectTenakerInterviewedPrintPaging($startPaging,$endPaging);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
        }else{
            $total                  = NULL;
            $data['_selected']      = NULL;
            $data['_selectWhere']   = NULL;
            $data['_pagination']    = NULL;
        }
        
        $this->template->display('registrasi/print_berkas/new_paging',$data);
    }
    function filterData(){
        $dataFilter = $this->input->post('selDataFilter');
        
        $this->session->unset_userdata('w_pemborong');
        $this->session->unset_userdata('w_noreg');
        $this->session->unset_userdata('w_nama');
        
        if($this->input->post('txtNama') == NULL && $this->input->post('txtNoreg') == NULL && $this->input->post('txtPemborong') == NULL){
            redirect('PrintControl/newPaging/'.$dataFilter);
        }
        
        $this->session->set_userdata('w_pemborong', $this->input->post('txtPemborong'));
        $this->session->set_userdata('w_noreg', $this->input->post('txtNoreg'));
        $this->session->set_userdata('w_nama', $this->input->post('txtNama'));
        
        redirect('PrintControl/dataFilter/'.$dataFilter.'/1');
    }
    function dataFilter(){
        $dataSelect             = $this->uri->segment(3);
        $num                    = $this->uri->segment(4);
        
        $pemborong      = $this->session->userdata('w_pemborong');
        $noreg          = $this->session->userdata('w_noreg');
        $nama           = $this->session->userdata('w_nama');
        
        $numStart               = $num-1;
        $start                  = 1;
        $end                    = 0;
        $startPaging            = (int)$numStart.$start;
        $endPaging              = (int)$num.$end;
        
        if($dataSelect == 0){
            $total                  = $this->m_print_berkas->countTenakerPostedPrintPagingWhere($pemborong,$noreg,$nama);
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->m_print_berkas->selectTenakerPostedPrintPagingWhere($startPaging,$endPaging,$pemborong,$noreg,$nama);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
        }elseif($dataSelect == 1){
            $total                  = $this->m_print_berkas->countTenakerInterviewedPrintPagingWhere($pemborong,$noreg,$nama);
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->m_print_berkas->selectTenakerInterviewedPrintPagingWhere($startPaging,$endPaging,$pemborong,$noreg,$nama);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
        }else{
            $total                  = NULL;
            $data['_selected']      = NULL;
            $data['_selectWhere']   = NULL;
            $data['_pagination']    = NULL;
        }
        $this->template->display('registrasi/print_berkas/new_paging',$data);
    }
            
    function viewSPMK(){
        ob_start();
        $hdrID  = $this->uri->segment(3);
        $data['_getDetail'] = $this->m_posting_tenaker->getResult($hdrID);
        $data['_getInterV'] = $this->m_posting_tenaker->getInterV($hdrID);
        $data['adm']        = $this->session->userdata('username');
        $data['tglPrint']   = date("d M Y");
        
        $this->load->view("registrasi/posting/print/spmk",$data);
        $html   = ob_get_contents();
        ob_end_clean();
        
        require_once ('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P','A4','en');
        $pdf->writeHTML($html);
        $pdf->Output('SPMK-'.$hdrID.'.pdf');
    }
    function viewFormMCU(){
        ob_start();
        $hdrID  = $this->uri->segment(3);
        foreach ($this->m_posting_tenaker->getResult($hdrID) as $row):
            $tglLahir   = $row->Tgl_Lahir;
        endforeach;
        $data['_umur'] = $this->hitungUmur(date('Y-m-d',strtotime($tglLahir)));
        $data['_getDetail'] = $this->m_posting_tenaker->getResult($hdrID);
        
        $this->load->view("registrasi/posting/print/mcu_form",$data);
        $html   = ob_get_contents();
        ob_end_clean();
        
        require_once ('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P','A4','en');
        $pdf->writeHTML($html, isset($_GET['vuehtml']));
        $pdf->Output('MCU Form - '.$hdrID.'.pdf');
    }
    function viewCardMCU(){
        ob_start();
        $hdrID  = $this->uri->segment(3);
        $data['_getDetail'] = $this->m_posting_tenaker->getResult($hdrID);
        
        $this->load->view("registrasi/posting/print/mcu_card",$data);
        $html   = ob_get_contents();
        ob_end_clean();
        
        require_once ('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P','A4','en');
        $pdf->writeHTML($html, isset($_GET['vuehtml']));
        $pdf->Output('MCU Card - '.$hdrID.'.pdf');
    }
    function viewKPB(){
        ob_start();
        $hdrID  = $this->uri->segment(3);
        $data['_getDetail'] = $this->m_posting_tenaker->getResult($hdrID);
        $data['_getAnak']   = $this->m_posting_tenaker->getAnak($hdrID);
        
        $this->load->view("registrasi/posting/print/kpb",$data);
        $html   = ob_get_contents();
        ob_end_clean();
        
        require_once ('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P','A4','en');
        $pdf->writeHTML($html, isset($_GET['vuehtml']));
        $pdf->Output('KPB-'.$hdrID.'.pdf');
    }
    function viewIntervewResultSMA(){
        ob_start();
//        $hdrID  = $this->uri->segment(3);
//        $data['_getDetail'] = $this->m_posting_tenaker->getResult($hdrID);
//        $data['_getAnak']   = $this->m_posting_tenaker->getAnak($hdrID);
        
        $this->load->view("registrasi/posting/print/interviewSMU");
        $html   = ob_get_contents();
        ob_end_clean();
        
        require_once ('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P','A4','en');
        $pdf->writeHTML($html, isset($_GET['vuehtml']));
        $pdf->Output('Interview Result-.pdf');
    }
    function viewIntervewResultStrata(){
        ob_start();
//        $hdrID  = $this->uri->segment(3);
//        $data['_getDetail'] = $this->m_posting_tenaker->getResult($hdrID);
//        $data['_getAnak']   = $this->m_posting_tenaker->getAnak($hdrID);
        
        $this->load->view("registrasi/posting/print/interviewStrata");
        $html   = ob_get_contents();
        ob_end_clean();
        
        require_once ('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P','A4','en');
        $pdf->writeHTML($html, isset($_GET['vuehtml']));
        $pdf->Output('Interview Result-.pdf');
    }
    function viewDaftarCekOrientasi(){
        ob_start();        
        $this->load->view("registrasi/posting/print/cekOrientasi");
        $html   = ob_get_contents();
        ob_end_clean();
        
        require_once ('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P','A4','en');
        $pdf->writeHTML($html, isset($_GET['vuehtml']));
        $pdf->Output('Interview Result-.pdf');
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
        $tahun  = substr($umur/365, 0, 3);
        
        return $tahun;        
    }
    //Paging
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