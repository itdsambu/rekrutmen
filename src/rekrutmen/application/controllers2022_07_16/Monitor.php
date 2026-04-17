<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class Monitor extends CI_Controller{
    
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
        $this->load->model(array('m_monitor','m_approval','m_upload_berkas','m_screening'));
    }
    
    public function screeningProses(){

        //Tampilan Berdasarkan Range Bulan

        $tanggalz   = date('Y-m-t');
        $tanggala   = date('Y-m-d', strtotime($tanggalz.' -3 months'));
        if($this->input->post('txtDateA')){
            $tanggala   = date('Y-m-d',  strtotime($this->input->post('txtDateA')));
            $tanggalz   = date('Y-m-d',  strtotime($this->input->post('txtDateZ')));
        }
        $data['_getTK'] = $this->m_monitor->getListTK3($tanggala,$tanggalz);
        $data['_getDateA']   = $tanggala;
        $data['_getDateZ']   = $tanggalz;
        $this->template->display('monitor/proses_screening/index',$data);
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
    public function screeningProses2(){
        $monthfilter= $this->input->post('monthfilter');
        //$data['_getTK'] = $this->m_monitor->getListTK2();
        $data['_getTK'] = $this->m_monitor->getListTK3($monthfilter);
        echo json_encode($data['_getTK']);
    }
            
    function detailScreened(){
        if('IS_AJAX') {
            $kode=$this->input->post('kode');
            $data['datatk'] = $this->m_upload_berkas->get_detailtk($kode)->result();
            $data['resultScreen'] = $this->m_screening->resultScreen($kode)->result();
            $this->load->view('monitor/proses_screening/detailScreened',$data);
        }
    }
    
    function viewLogLogin(){
        $userID = $this->session->userdata('userid');
        if($userID == 'ismo_adm' || $userID == 'ISMO_ADM'){
            $data['_getViewLogLogin'] = $this->m_monitor->getLogLoginViewForAdmin();
        }else{
            $data['_getViewLogLogin'] = $this->m_monitor->getLogLoginView($userID);
        }
        $this->template->display('monitor/viewLogLogin/index',$data);
    }
    
    function reviewIssue(){
        if(!isset($_GET['jenis']))
        {$_GET['jenis']='harian';}
        if(isset($_GET['status'])){$status=$_GET['status'];}
        else{$status=$this->input->post('selStatus');}
        $jenis='';
        if($_GET['jenis']=='harian'){$jenis='ALL PEMBORONG';}
        else{$jenis='PSG';}

        if($status == 'approved'){
            $status = 1;
            $data['_selStatus']= 1;
            $data['_getIssue'] = $this->m_monitor->getTransByStatus($status,$jenis);
        }elseif($status == 'canceled'){
            $status = 2;
            $data['_selStatus']= 2;
            $data['_getIssue'] = $this->m_monitor->getTransByStatus($status,$jenis);
        }elseif($status == 'closed'){
            $status = 3;
            $data['_selStatus']= 3;
            $data['_getIssue'] = $this->m_monitor->getTransByStatus($status,$jenis);
        }else{
            $status = NULL;
            $data['_selStatus']= NULL;
            $data['_getIssue'] = $this->m_monitor->getTransByStatusPending($jenis);
        }       
        $data['jenis']=$_GET['jenis'];
        $data['_getKaryawan'] = $this->m_monitor->getJumlahRequestK();
        $data['_getTenaker'] = $this->m_monitor->getJumlahRequestTK();
        $this->template->display('monitor/permintaan_review/index',$data);
    }
    
    function viewApprovalDetail(){
        if('IS_AJAX') {
            $id = $this->input->post('kode');
            $data['getTran'] = $this->m_approval->setInfoTran($id);
            $this->load->view('monitor/permintaan_review/detailIssue',$data);
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
	
	function viewcek(){
        $id = $this->input->get('id');
        $this->session->set_flashdata("id",$id);

        redirect('monitor/viewcekdetail');
    }

    function viewallidentifikasiapproved(){
        $grupID = $this->session->userdata('groupuser');
        $jenis=$_GET['jenis'];
        $status=$_GET['status'];
        if ($status = 'approved') {
            $status = 1;
        } else {
            $status = '';
        }
        $DetailIDALL = "";
        $getIssue = $this->m_monitor->getTransByStatus($status,$jenis);
        foreach ($getIssue as $row) {
            $DetailIDALL .= "'".$row->DetailID."',";

        }
        $DetailID = substr($DetailIDALL,0,-1);
        $data['_getTrans'] = $this->m_monitor->getTenakerByTransIDALL($DetailID);
        
        $this->template->display('monitor/permintaan_review/viewcekDetailAll',$data);
    }

    function viewcekdetail(){
        $id = $this->session->flashdata("id");
        // var_dump($id); die;
        $this->session->keep_flashdata("id");

        $data['id'] = $id;

        $data['getTrans'] = $this->m_monitor->getTenakerByTransID($id);
        $data['getTranssucces'] = $this->m_monitor->getTenakerByTransIDsucces($id);

        $this->template->display('monitor/permintaan_review/viewcekDetail',$data);
    }
	
    function updateidentifikasi(){
        $hdrid = $this->input->get('hdrid');
        $this->m_monitor->updatecekidentifikasi($hdrid);
        redirect(site_url('Monitor/reviewIssue'));
    }

    function hapusidentifikasi(){
        $hdrid = $this->input->get('hdrid');
        $transid = $this->input->get('id');
        $this->m_monitor->hapuscekidentifikasi($hdrid);
        $this->m_monitor->restoreAngkaTransaksi($transid);
        redirect(site_url('Monitor/reviewIssue'));
    }


    //======== Start to View Docs ===========
    function viewListTK(){
        $data['_getListTK'] = $this->m_monitor->getListViewDocs();
        $data['_getListTKtoExcel'] = $this->m_monitor->toExcelSemua();
        $this->template->display('monitor/calon_tk/index',$data);
    }
    
    function selectViewTenakerVerifi(){
        if('IS_AJAX') {
            $data['_getTenaker'] = $this->m_monitor->tenakerVerifi();
            $this->load->view('monitor/calon_tk/verifi',$data);
        }
    }
    function selectViewTenakerProses(){
        if('IS_AJAX') {
            $data['_getTenaker'] = $this->m_monitor->tenakerProses();
            $this->load->view('monitor/calon_tk/proses',$data);
        }
    }
    function selectViewTenakerClosed(){
        if('IS_AJAX') {
            $data['_getTenaker'] = $this->m_monitor->tenakerClosed();
            $this->load->view('monitor/calon_tk/closed',$data);
        }
    }
    
    function toExcel(){
        $select = $this->input->post('select');
        
        if($select === 'closed'){
            if('IS_AJAX') {
                $data['_getTenaker'] = $this->m_monitor->toExcelClosed();
                $this->load->view('monitor/calon_tk/toExcel',$data);
            }
        }elseif ($select === 'verifi') {
            if('IS_AJAX') {
                $data['_getTenaker'] = $this->m_monitor->toExcelVerifi();
                $this->load->view('monitor/calon_tk/toExcel',$data);
            }
        }elseif ($select === 'proses') {
            if('IS_AJAX') {
                $data['_getTenaker'] = $this->m_monitor->toExcelProses();
                $this->load->view('monitor/calon_tk/toExcel',$data);
            }
        }else {
            echo 'Anda tidak beruntung';
        }
    }
            
    function viewDocs(){
        if('IS_AJAX') {
            $userID=$this->input->post('kode');
            $berkas=$this->input->post('nama');
            $data['_jenisBerkas'] = $berkas;
            $data['_getViewDocs'] = $this->m_monitor->getDocs($userID);
            $this->load->view('monitor/calon_tk/viewDocs',$data);  
        }
    }
    //======== END to View Docs ===========
    
    //=========== MONITOR FOR PEMBORONG ===========
    function viewListByPBR(){
        $idpemborong    = $this->session->userdata('idpemborong');
        $data['_getTenaker'] = $this->m_monitor->listByPBR($idpemborong);
        $this->template->display('monitor/listTenakerForPemborong/index',$data);
    }
	
	function detailtk(){
        if('IS_AJAX') {
        $kode=$this->input->post('kode');
        $data['datatk'] = $this->m_upload_berkas->get_detailtk($kode)->result();
        $this->load->view('monitor/listTenakerForPemborong/detail',$data);
        }
    }
    
    // ====== New List Tenaker Monitor ======
    function closeTenaker(){
        $hdrID = $this->input->post('txtHeaderID');
        $remark= $this->input->post('txtRemarkClose');
        $this->m_monitor->closeTenaker($hdrID,$remark);
        redirect(site_url('Monitor/testPaging'));
    }
    function testPaging(){
        /*
         * -- dataSelect -- 
         * 0 => Semua Data
         * 1 => Dalam Proses
         * 2 => Telah Close
         * 3 => Telah Posting
         */
        $dataSelect             = $this->uri->segment(3);
        $num                    = $this->uri->segment(4);
        if($num == FALSE && $dataSelect == FALSE){
            redirect('monitor/testPaging/0/1');
        }elseif ($num == FALSE) {
            redirect('monitor/testPaging/'.$dataSelect.'/1');
        }
        
        $numStart               = $num-1;
        $start                  = 1;
        $end                    = 0;
        $startPaging            = (int)$numStart.$start;
        $endPaging              = (int)$num.$end;
        if($dataSelect == 0){
            $total                = $this->m_monitor->countAllTenaker();
            $data['_selected']    = $dataSelect;
            $data['_tipe']        = NULL;
            $data['_selectWhere'] = $this->m_monitor->selectAllTenaker($startPaging,$endPaging);
            $data['_pagination']  = $this->pagination($page = $num, 10, $total);
        }elseif($dataSelect == 1){
            $total                = $this->m_monitor->countOnProccessTenaker();
            $data['_selected']    = $dataSelect;
            $data['_tipe']        = NULL;
            $data['_selectWhere'] = $this->m_monitor->selectOnProccessTenaker($startPaging,$endPaging);
            $data['_pagination']  = $this->pagination($page = $num, 10, $total);
        }elseif($dataSelect == 2){
            $total                = $this->m_monitor->countClosedTenaker();
            $data['_selected']    = $dataSelect;
            $data['_tipe']        = NULL;
            $data['_selectWhere'] = $this->m_monitor->selectClosedTenaker($startPaging,$endPaging);
            $data['_pagination']  = $this->pagination($page = $num, 10, $total);
        }elseif($dataSelect == 3){
            $total                = $this->m_monitor->countPostedTenaker();
            $data['_selected']    = $dataSelect;
            $data['_tipe']        = NULL;
            $data['_selectWhere'] = $this->m_monitor->selectPostedTenaker($startPaging,$endPaging);
            $data['_pagination']  = $this->pagination($page = $num, 10, $total);
        }else{
            $total                = NULL;
            $data['_selected']    = NULL;
            $data['_tipe']        = NULL;
            $data['_selectWhere'] = NULL;
            $data['_pagination']  = NULL;
        }
        
        $this->template->display('monitor/calon_tk/testPaging',$data);
    }
    
    function testtest(){
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
        
        if($this->input->post('txtThnLahir') == NULL && $this->input->post('txtNama') == NULL && $this->input->post('txtNoreg') == NULL && $this->input->post('txtPemborong') == NULL && $this->input->post('txtJekel') == NULL && $this->input->post('txtStatus') == NULL && $this->input->post('txtPendidikan') == NULL && $this->input->post('txtJurusan') == NULL && $this->input->post('tipe') == NULL){
            redirect('monitor/testPaging/'.$dataFilter);
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
        
        redirect('monitor/testPagingWhere/'.$dataFilter.'/1');
    }
            
    function testPagingWhere(){
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

        
        $numStart               = $num-1;
        $start                  = 1;
        $end                    = 0;
        $startPaging            = (int)$numStart.$start;
        $endPaging              = (int)$num.$end;
        
        if($dataSelect == 0){
            $total                = $this->m_monitor->countAllTenakerWhere($pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama);
            $data['_selected']    = $dataSelect; 
            $data['_tipe']        = $tipe; 
            $data['_selectWhere'] = $this->m_monitor->selectAllTenakerWhere($startPaging,$endPaging,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama,$thnlahir,$tipe);
            $data['_pagination']  = $this->pagination($page = $num, 10, $total);
        }elseif($dataSelect == 1){
            $total                = $this->m_monitor->countOnProccessTenakerWhere($pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama);
            $data['_selected']    = $dataSelect;
            $data['_tipe']        = $tipe;
            $data['_selectWhere'] = $this->m_monitor->selectOnProccessTenakerWhere($startPaging,$endPaging,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama,$thnlahir,$tipe);
            $data['_pagination']  = $this->pagination($page = $num, 10, $total);
        }elseif($dataSelect == 2){
            $total                = $this->m_monitor->countClosedTenakerWhere($pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama);
            $data['_selected']    = $dataSelect;
            $data['_tipe']        = $tipe;
            $data['_selectWhere'] = $this->m_monitor->selectClosedTenakerWhere($startPaging,$endPaging,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama,$thnlahir,$tipe);
            $data['_pagination']  = $this->pagination($page = $num, 10, $total);
        }elseif($dataSelect == 3){
            $total                = $this->m_monitor->countPostedTenakerWhere($pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama);
            $data['_selected']    = $dataSelect;
            $data['_tipe']        = $tipe;
            $data['_selectWhere'] = $this->m_monitor->selectPostedTenakerWhere($startPaging,$endPaging,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama,$thnlahir,$tipe);
            $data['_pagination']  = $this->pagination($page = $num, 10, $total);
        }else{
            $total                = NULL;
            $data['_selected']    = NULL;
            $data['_tipe']        = NULL;
            $data['_selectWhere'] = NULL;
            $data['_pagination']  = NULL;
        }
        $this->template->display('monitor/calon_tk/testPaging',$data);
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

    function editIssue(){
        $this->load->model('m_monitor');
        $data['getIssue'] = $this->m_user_login->getUserLogin($id);
    }

    function viewEditIssue(){
        if('IS_AJAX') {
        $id = $this->input->post('kode');
        $data['getDept'] = $this->m_monitor->getDept();
        $data['getJbtn'] = $this->m_monitor->getJabatan();
        $data['getPemb'] = $this->m_monitor->getPemborongAll();
        $data['getPend'] = $this->m_monitor->getPendidikan();
        $data['getJurs'] = $this->m_monitor->getJurusan();
        $data['getSKwn'] = $this->m_monitor->getStatusKawin();
        $data['getTran'] = $this->m_monitor->setInfoTranEdit($id)->result();
        $row = $this->m_monitor->setInfoTranEdit($id)->row();
        $idDept          = $row->DeptID;
        $data['getKrj']  = $this->m_monitor->getPekerjaan($idDept);
        $this->load->view('monitor/permintaan_review/editIssue',$data);
        }
    }

    function getBagian(){
        if('IS_AJAX') {
            $dept   = $this->input->post('dept');
            $data['_getBagian'] = $this->m_monitor->getPekerjaan($dept);
            $this->load->view('monitor/permintaan_review/borongan/getBagian',$data);
        }
    }
    function doEditIssue(){
        $id = $this->input->post('txtID');
        
        if($this->input->post('comboPemborong') == 'PSG'){
            $idKerja    = $this->input->post('comboJabatan');
        }else{
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
            'StatusPersonal'=> $this->input->post('comboStatus'),
            'UpdatedBy'     => $this->session->userdata('username'),
            'UpdatedDate'   => date('Y-m-d H:m:i')
        );
        $this->m_monitor->updateTran($id,$data);
        
        redirect(site_url('monitor/reviewIssue'));
    }

    function deleteIssue(){
        $id = $this->input->get('id'); 

        $this->load->model('m_monitor');
        $result = $this->m_monitor->delete($id);
        if(!$result){
            redirect('monitor/reviewIssue?msg=success_delete');
        }else{
            redirect('monitor/reviewIssue?msg=failed_delete');
        }
    }

    function identifikasi(){
        $periode = date('Y-m-d');
        if($this->input->post('txtperiode')){
            $periode   = date('Y-m-d',  strtotime($this->input->post('txtperiode')));
        }
        $data['_select']   = $this->m_monitor->SelectIdentifikasi($periode);
        $data['_getperiode']   = $periode;
        $this->template->display('monitor/identifikasi/index',$data);
    }
	
	public function downloadIdentifikasi(){
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
                ->setCellValue('A1', $title.' : '.$periode)
                
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
        foreach ($data as $row){
            $ex->setCellValue('A'.$counter, $no++);
            $ex->setCellValue('B'.$counter, $row->HeaderID);
            $ex->setCellValue('C'.$counter, $row->Nama);
            $ex->setCellValue('D'.$counter, $row->CVNama);
            $ex->setCellValue('E'.$counter, $row->Pemborong);
			$ex->setCellValue('F'.$counter, $row->DeptTujuan);
			$ex->setCellValue('G'.$counter, $row->Transaksi);
            $counter = $counter+1;
        }
        
        $objPHPExcel->getActiveSheet()->setTitle('LaporanIdentifikasi');
        
        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Lap_Identifikasi('.$periode.').xls"');
        
        $objWriter->save('php://output');
    }
    
    function calonkandidat(){
		$page = $this->uri->segment(4);
		if($this->uri->segment(2) == FALSE || $this->uri->segment(3) == FALSE || $this->uri->segment(4) == FALSE){
			redirect(base_url('monitor/calonkandidat/10/1'));
		}
		$numStart 	= $page-1;
		$start		= 1;
		$end		= 0;
		$perPage	= array($this->uri->segment(3)/10,$this->uri->segment(3));
		$startPaging= (int)($numStart*$perPage[0]).$start;
		$endPaging	= (int)($page*$perPage[0]).$end;
		$total		= $this->m_monitor->countCalonKandidat();
        $data['_getData'] = $this->m_monitor->getCalonKandidat($startPaging,$endPaging);
		$data['_pagination']    = $this->pagination($page,$perPage[1], $total);
        $this->template->display('monitor/calon_kandidat/index',$data);
    }
	
	function setFilterCalonKandidat(){
        $this->session->unset_userdata('f_nama'); 
        $this->session->unset_userdata('f_periode');

        if($this->input->post('txtFilterNama') == NULL && $this->input->post('txtperiode') == NULL){
            redirect(base_url('monitor/calonkandidat/10/1'));
        }

        $this->session->set_userdata('f_nama', $this->input->post('txtFilterNama'));
        $this->session->set_userdata('f_periode', $this->input->post('txtperiode'));
        
        redirect(base_url('monitor/getFilterCalonKandidat/10/1'));
    }
    
    function getFilterCalonKandidat(){
        $page = $this->uri->segment(4);

        $nama           = $this->session->userdata('f_nama');
        $periode        = $this->session->userdata('f_periode');

        if($this->uri->segment(2) == FALSE || $this->uri->segment(3) == FALSE || $this->uri->segment(4) == FALSE){
            redirect(base_url('monitor/getFilterCalonKandidat/10/1'));
        }
        $numStart   = $page-1;
        $start      = 1;
        $end        = 0;
        $perPage    = array($this->uri->segment(3)/10,$this->uri->segment(3));
        $startPaging= (int)($numStart*$perPage[0]).$start;
        $endPaging  = (int)($page*$perPage[0]).$end;
        $total      = $this->m_monitor->countCalonKandidatwhere($nama,$periode);
        $data['_getData'] = $this->m_monitor->getCalonKandidatwhere($startPaging,$endPaging,$nama,$periode);
        $data['_pagination']    = $this->pagination($page,$perPage[1], $total);
        $this->template->display('monitor/calon_kandidat/index',$data);
    }
	
	function hapusdataCK(){
		$id = $this->input->get('id');
		$result = $this->m_monitor->hapusCK($id);
		if($result){
			redirect('Monitor/calonkandidat?msg=success_delete');
		}else{
			redirect('Monitor/calonkandidat?msg=failed_delete');
		}
	}

    function monitorpermintaanbydept(){
        $periode = $this->input->post('txtPeriode');
        $data['periodeaktif'] = $periode;
        $data['_getData'] = $this->m_monitor->getdataIdeal($periode);
        $this->template->display('monitor/ideal/index',$data);
    }

    function reviewIdeal(){
        if('IS_AJAX') {
            $issueID    = $this->input->post('kode');
            $cekDataKry    = $this->m_monitor->getDetailSubPerkerjaanDeptKry($issueID);
            $cekDataBor    = $this->m_monitor->getDetailSubPerkerjaanDeptBor($issueID);
            $data['_getKaryawan']   = $this->m_monitor->getDetailSubPerkerjaanDeptKry($issueID)->result();
            $data['_getBorongan']   = $this->m_monitor->getDetailSubPerkerjaanDeptBor($issueID)->result();
            $this->load->view('monitor/ideal/detail',$data);
        }
    }

    function uploadberkas(){
        $id  = $this->input->get('id');
        $nama   = $this->input->get('nama');
        $this->session->set_flashdata("regid",$id);
        $this->session->set_flashdata("regnama",$nama);
        
        redirect('Monitor/uploadberkasck');
    }

    function uploadberkasck(){        
        $id = $this->session->flashdata("regid");
        //redirect("uploadBerkas/listTKforUploadDoc");;
        $id = $this->session->flashdata("regid");
        $nama = $this->session->flashdata("regnama");
        $this->session->keep_flashdata("regid");
        $this->session->keep_flashdata("regnama");
        
        $data['id']=$id;
        $data['namapelamar']=$nama;
        $data['errormsg']="";

        $data['databerkas']= $this->m_monitor->get_db_berkas($id)->result();
        
        $this->template->display('registrasi/calon_kandidat/upload',$data);
    }

    function uploadarea(){      
        $tipe = $this->input->post("tipe");
        $data["id"] = $this->input->post("id");
        $data["namapelamar"] = $this->input->post("nama");
        $data['errormsg']="";

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

        $data['jenisberkas']    =$tipe;
        $data['namaberkas']     =$namaberkas;
        if ($tipe === "cv"){
                $this->load->view('registrasi/calon_kandidat/formCV',$data);
        }elseif($tipe == "riwayathidup"){
                $this->load->view('registrasi/calon_kandidat/formRH',$data);
        }else{
            $this->load->view('registrasi/calon_kandidat/formIjazah',$data);
        }
    }

    function do_upload($berkas){
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
        $namafile = $id.'_'.$berkas;

        $data['namapelamar']        = $namapelamar;
        $config['upload_path']      = $url;
        $config['allowed_types']    = 'pdf';
        $config['allow_scale_up']   = true;
        $config['overwrite']        = true;
        $config['file_name']        = $namafile;
        $config['max_size']         = '5120';

        $this->load->library('upload');
        $this->upload->initialize($config);

        if( $this->upload->do_upload('txtfile')){
            $this->upload->data();
            $data['errormsg']="<div class='alert alert-success'><a class='close' data-dismiss='alert'>×</a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Berkas $namaberkas Berhasil</strong></div>";
            $this->m_monitor->update_db_berkas($id,$berkas,$url.'/'.$namafile.'.pdf');
        }else{
            $error = $this->upload->display_errors();
            $data['errormsg']="<div class='alert alert-danger'><a class='close' data-dismiss='alert'><i class='fa fa-times'>&nbsp;</i></a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Berkas $namaberkas Gagal</strong><br/>$error</div>";
        }
        
        $data['databerkas']     = $this->m_monitor->get_db_berkas($id)->result();
        $data['id']  = $id;
        $this->template->display('registrasi/calon_kandidat/upload',$data);
    }

    function ubahfotokaryawan(){
        $id = $this->input->get('id');
		$this->session->set_flashdata("id",$id);
		
		redirect('monitor/changefoto');
        //$data['_getdatafoto'] = $this->m_monitor->getdatafoto($id);
        //$this->template->display('monitor/calon_tk/changefoto',$data);
    }
	
	function changefoto(){
		$id = $this->session->flashdata("id");
        $this->session->keep_flashdata("id");
		$data['_refid'] = $id;
		$data['_getdatafoto'] = $this->m_monitor->getdatafoto($id);
        $this->template->display('monitor/calon_tk/changefoto',$data);
	}
	
	function uploadPhoto(){
        $this->load->library('image_moo');
        
        $url = './dataupload/fotoProfil/';
        $loginID    = $this->input->post("txtID");
        $filefoto = $loginID;

        $config['upload_path']      = $url;		
        $config['allowed_types']    = 'jpeg|jpg|png|gif';
        $config['allow_scale_up']   = true;
        $config['overwrite']        = true;
        $config['max_size']         = '1024';
        $config['file_name']        = $filefoto.'.png';	//Filename harus pakai headerID pelamar

        $this->load->library('upload');
        $this->upload->initialize($config);
        
        if($this->upload->do_upload('fileFoto1') == ""){
            $file = $this->upload->do_upload('fileFoto2');
        }  else {
            $file = $this->upload->do_upload('fileFoto1');
        }
        if( $file ){
            $files = $this->upload->data();
            $fileNameResize = $config['upload_path'].$files['file_name'];					

            $this->image_moo
                    ->load($fileNameResize)
                    ->set_background_colour('#fff')
                    ->resize(200,200,TRUE)
                    ->save($fileNameResize,true);

            if ($this->image_moo->errors){
				$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                foto gagal dirubah...!</div>');
                redirect('monitor/ubahfotokaryawan?id="'.$loginID.'"','refresh');
            }else{				
                $this->m_monitor->update_status_foto($loginID);
                $this->image_moo->clear();
				$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                foto berhasil dirubah...!</div>');
                redirect('monitor/testPaging/0/1','refresh');
            }
        }else{
            $this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
            foto gagal dirubah...!</div>');
            redirect('monitor/ubahfotokaryawan?id="'.$loginID.'"','refresh');
        }
        $this->image_moo->clear();
    }


    public function CetakreviewIssue() {
        $jns  = $this->uri->segment(3);
        $status = $this->uri->segment(4);
        if($jns=='harian'){$jenis='ALL PEMBORONG';}
        else{$jenis='PSG';}
      include APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel.php';
      include APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';

      $style1 = [

         'font'      => ['bold'=> true, 'name'=> 'Time New Roman', 'size'=> '14'],
         'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                         'wrap' =>true,
                         'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER],
   
         'borders'   => [    
                        'top'   => ['style'  => PHPExcel_Style_Border::BORDER_THIN], // Set border top dengan garis tipis   
                        'right' => ['style'  => PHPExcel_Style_Border::BORDER_THIN],  // Set border right dengan garis tipis    
                        'bottom'=> ['style'  => PHPExcel_Style_Border::BORDER_THIN], // Set border bottom dengan garis tipis    
                        'left'  => ['style'  => PHPExcel_Style_Border::BORDER_THIN] // Set border left dengan garis tipis  
                        ]
                  ];
      $style2 = [

     'font'      => ['bold'=> false, 'name'=> 'Time New Roman', 'size'=> '11'],
     'fill'      => ['type' => PHPExcel_Style_Fill::FILL_SOLID,
                     'color' => array('rgb' => 'FF0000')],
     'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER],

     'borders'   => [    
                    'top'   => ['style'  => PHPExcel_Style_Border::BORDER_THIN], // Set border top dengan garis tipis   
                    'right' => ['style'  => PHPExcel_Style_Border::BORDER_THIN],  // Set border right dengan garis tipis    
                    'bottom'=> ['style'  => PHPExcel_Style_Border::BORDER_THIN], // Set border bottom dengan garis tipis    
                    'left'  => ['style'  => PHPExcel_Style_Border::BORDER_THIN] // Set border left dengan garis tipis  
                    ]
              ];
    $style3 = [

     'font'      => ['bold'=> false, 'name'=> 'Time New Roman', 'size'=> '11'],
     'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER],

     'borders'   => [    
                    'top'   => ['style'  => PHPExcel_Style_Border::BORDER_THIN], // Set border top dengan garis tipis   
                    'right' => ['style'  => PHPExcel_Style_Border::BORDER_THIN],  // Set border right dengan garis tipis    
                    'bottom'=> ['style'  => PHPExcel_Style_Border::BORDER_THIN], // Set border bottom dengan garis tipis    
                    'left'  => ['style'  => PHPExcel_Style_Border::BORDER_THIN] // Set border left dengan garis tipis  
                    ]
              ];
    $style4 = [

     'font'      => ['bold'=> false, 'name'=> 'Time New Roman', 'size'=> '11'],
     'fill'      => ['type' => PHPExcel_Style_Fill::FILL_SOLID,
                     'color' => array('rgb' => '#BDB76B')],
     'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER],

     'borders'   => [    
                    'top'   => ['style'  => PHPExcel_Style_Border::BORDER_THIN], // Set border top dengan garis tipis   
                    'right' => ['style'  => PHPExcel_Style_Border::BORDER_THIN],  // Set border right dengan garis tipis    
                    'bottom'=> ['style'  => PHPExcel_Style_Border::BORDER_THIN], // Set border bottom dengan garis tipis    
                    'left'  => ['style'  => PHPExcel_Style_Border::BORDER_THIN] // Set border left dengan garis tipis  
                    ]
              ];
      
      $objPHPExcel = new PHPExcel();
      
      if($status == '1'){
            $status = 1;
            $nmstatus = 'Approved';
            $cetak = $this->m_monitor->getTransByStatus($status,$jenis);
        }elseif($status == '2'){
            $status = 2;
            $nmstatus = 'Canceled';
            $cetak = $this->m_monitor->getTransByStatus($status,$jenis);
        }elseif($status == '3'){
            $status = 3;
            $nmstatus = 'Closed';
            $cetak = $this->m_monitor->getTransByStatus($status,$jenis);
        }else{
            $status = NULL;
            $nmstatus = 'Pending';
            $cetak = $this->m_monitor->getTransByStatusPending($jenis);
        }

      $objPHPExcel    = new PHPExcel();
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
        
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);
         $no = 0;
         $tot_sisa = 0;
         $tot_penuhi = 0;
         $tot_minta = 0;
         $tot_identifikasi = 0;
         $ex = $objPHPExcel->setActiveSheetIndex(0);
        foreach ($cetak as $ctk) { $no++;
        $objPHPExcel->getActiveSheet()->mergeCells('A2:T2')->setCellValue('A2', 'Data Issue Permintaan ' . $nmstatus)->getStyle('A2:T2')->applyFromArray($style1);
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
            ->setCellValue('T4', 'CATATAN');
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
      }

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $no = 1;
        $counter = 5;
        foreach ($cetak as $row){
            $target           = $row->TKTarget;
            $sedia            = $row->TKSedia;
            $minta            = $row->TKPermintaan;
            $jumlahID         = $row->Identifikasi;
            
            $sisa             = $target-$sedia;
            $penuhi           = $sisa-$minta;
            $diidentifikasi   = $jumlahID-($penuhi);

            $tot_sisa         += $sisa;
            $tot_penuhi       += $penuhi;
            $tot_minta        += $minta;
            $tot_identifikasi += $diidentifikasi;

            if ($row->DEPTStatus == '1') {
                $DEPTApprov =  '☑'.$row->DEPTApproval;
            } else if ($row->DEPTStatus == '2') {
                $DEPTApprov =  '☒'.$row->DEPTApproval;
            } else {
                $DEPTApprov = 'Pending';
            }

            if ($row->DIVISIStatus == '1') {
                $DIVISIApprov =  '☑'.$row->DIVISIApproval;
            } else if ($row->DIVISIStatus == '2') {
                $DIVISIApprov =  '☒'.$row->DIVISIApproval;
            } else {
                $DIVISIApprov = 'Pending';
            }

            if ($row->PSNStatus == '1') {
                $PSNApprov =  '☑'.$row->PSNApproval;
            } else if ($row->PSNStatus == '2') {
                $PSNApprov =  '☒'.$row->PSNApproval;
            } else {
                $PSNApprov = 'Pending';
            }

            if ($row->AGMStatus == '1') {
                $AGMApprov =  '☑'.$row->AGMApproval;
            } else if ($row->AGMStatus == '2') {
                $AGMApprov =  '☒'.$row->AGMApproval;
            } else {
                $AGMApprov = 'Pending';
            }

            if ($row->VGMStatus == '1') {
                $VGMApprov =  '☑'.$row->VGMApproval;
            } else if ($row->VGMStatus == '2') {
                $VGMApprov =  '☒'.$row->VGMApproval;
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
            $ex->setCellValue('A'.$counter, $row->DetailID);
            $ex->setCellValue('B'.$counter, $row->DeptAbbr);
            $ex->setCellValue('C'.$counter, $row->Pekerjaan);
            $ex->setCellValue('D'.$counter, $sisa);
            $ex->setCellValue('E'.$counter, $penuhi);
            $ex->setCellValue('F'.$counter, $minta);
            $ex->setCellValue('G'.$counter, $diidentifikasi);
            $ex->setCellValue('H'.$counter, $DEPTApprov.', '.$DEPTDate);
            $ex->setCellValue('I'.$counter, $DIVISIApprov.', '.$DIVISIDate);
            $ex->setCellValue('J'.$counter, $PSNApprov.', '.$PSNDate);
            $ex->setCellValue('K'.$counter, $AGMApprov.', '.$AGMDate);
            $ex->setCellValue('L'.$counter, $VGMApprov.', '.$VGMDate);
            $ex->setCellValue('M'.$counter, $nmstatus);
            $ex->setCellValue('N'.$counter, $row->CreatedBy);
            $ex->setCellValue('O'.$counter, date('d-M-Y H:m:i',strtotime($row->CreatedDate)));
            $ex->setCellValue('P'.$counter, $row->IssueRemark);
            $ex->setCellValue('Q'.$counter, $row->Pendidikan);
            $ex->setCellValue('R'.$counter, $row->Jurusan);
            $ex->setCellValue('S'.$counter, $row->JenisKelamin);
            $ex->setCellValue('T'.$counter, $row->Umur);

            //Style
            $ex->getStyle('A'.$counter)->applyFromArray($style3);
            $ex->getStyle('B'.$counter)->applyFromArray($style3);
            $ex->getStyle('C'.$counter)->applyFromArray($style3);
            $ex->getStyle('D'.$counter)->applyFromArray($style3);
            $ex->getStyle('E'.$counter)->applyFromArray($style3);
            $ex->getStyle('F'.$counter)->applyFromArray($style3);
            $ex->getStyle('G'.$counter)->applyFromArray($style3);
            $ex->getStyle('H'.$counter)->applyFromArray($style3);
            $ex->getStyle('I'.$counter)->applyFromArray($style3);
            $ex->getStyle('J'.$counter)->applyFromArray($style3);
            $ex->getStyle('K'.$counter)->applyFromArray($style3);
            $ex->getStyle('L'.$counter)->applyFromArray($style3);
            $ex->getStyle('M'.$counter)->applyFromArray($style3);
            $ex->getStyle('N'.$counter)->applyFromArray($style3);
            $ex->getStyle('O'.$counter)->applyFromArray($style3);
            $ex->getStyle('P'.$counter)->applyFromArray($style3);
            $ex->getStyle('Q'.$counter)->applyFromArray($style3);
            $ex->getStyle('R'.$counter)->applyFromArray($style3);
            $ex->getStyle('S'.$counter)->applyFromArray($style3);
            $ex->getStyle('T'.$counter)->applyFromArray($style3);
            $counter = $counter+1;
        }
        $counter2 = $counter;
        // var_dump($test); die;
        $ex->mergeCells('A'.$counter2.':C'.$counter2)->setCellValue('A'.$counter2, 'TOTAL');
        $ex->mergeCells('D'.$counter2.':D'.$counter2)->setCellValue('D'.$counter2, $tot_sisa);
        $ex->mergeCells('E'.$counter2.':E'.$counter2)->setCellValue('E'.$counter2, $tot_penuhi);
        $ex->mergeCells('F'.$counter2.':F'.$counter2)->setCellValue('F'.$counter2, $tot_minta);
        $ex->mergeCells('G'.$counter2.':G'.$counter2)->setCellValue('G'.$counter2, $tot_identifikasi);
        $ex->getStyle('A'.$counter2.':C'.$counter2)->applyFromArray($style2);
        $ex->getStyle('D'.$counter2)->applyFromArray($style2);
        $ex->getStyle('E'.$counter2)->applyFromArray($style2);
        $ex->getStyle('F'.$counter2)->applyFromArray($style2);
        $ex->getStyle('G'.$counter2)->applyFromArray($style2);
        $ex->getStyle('H'.$counter2.':T'.$counter2)->applyFromArray($style2);

      

      $filename = "Issue Permintaan ".$nmstatus.'.xlsx';
      $objPHPExcel->getActiveSheet()->setTitle($nmstatus);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachement; filename="'.$filename. '"');
      header('Cache-Control: max-age=0');

      $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      $writer->save('php://output');
      exit;
   }
}

/* End of file monitor.php */
/* Location: ./application/controllers/monitor.php */